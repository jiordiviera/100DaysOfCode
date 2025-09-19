<?php

namespace App\Livewire\Page;

use App\Models\ChallengeInvitation;
use App\Models\ChallengeRun;
use App\Models\DailyLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Title('Challenge')]
#[Layout('components.layouts.app')]
class ChallengeShow extends Component
{
    public ChallengeRun $run;
    public string $inviteEmail = '';
    public ?string $lastInviteLink = null;

    public function mount(ChallengeRun $run): void
    {
        $this->run = $run->load('participantLinks.user', 'owner');
        abort_unless($this->canView(), 403);
    }

    protected function canView(): bool
    {
        $user = auth()->user();
        if ($user->id === $this->run->owner_id) return true;
        return $this->run->participantLinks->contains(fn($p) => $p->user_id === $user->id);
    }

    public function sendInvite(): void
    {
        abort_unless(auth()->id() === $this->run->owner_id, 403);

        $this->validate([
            'inviteEmail' => 'required|email',
        ]);

        // Already participant?
        $already = $this->run->participants()->where('email', $this->inviteEmail)->exists();
        if ($already) {
            $this->addError('inviteEmail', 'Cet utilisateur participe déjà.');
            return;
        }

        // Existing pending invitation?
        $pending = ChallengeInvitation::where('challenge_run_id', $this->run->id)
            ->where('email', $this->inviteEmail)
            ->whereNull('accepted_at')
            ->exists();
        if ($pending) {
            $this->addError('inviteEmail', 'Invitation déjà envoyée.');
            return;
        }

        $token = (string) Str::ulid();
        $inv = ChallengeInvitation::create([
            'challenge_run_id' => $this->run->id,
            'inviter_id' => auth()->id(),
            'email' => strtolower($this->inviteEmail),
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);

        $this->lastInviteLink = route('challenges.accept', ['token' => $token]);
        $this->inviteEmail = '';
        session()->flash('message', 'Invitation créée. Partagez le lien de participation.');
    }

    public function getProgressProperty(): array
    {
        $target = max(1, (int) $this->run->target_days);
        $byUser = [];
        foreach ($this->run->participantLinks as $link) {
            $u = $link->user;
            if (!$u) continue;
            $done = DailyLog::where('challenge_run_id', $this->run->id)
                ->where('user_id', $u->id)
                ->count();
            $streak = $this->computeStreak($u->id);
            $byUser[] = [
                'user' => $u,
                'done' => $done,
                'percent' => round(min(100, $done / $target * 100), 1),
                'streak' => $streak,
            ];
        }
        return $byUser;
    }

    protected function computeStreak(string $userId): int
    {
        // Current streak counted from today's expected day number backwards
        $start = $this->run->start_date;
        if (!$start) return 0;
        $todayDay = Carbon::now()->diffInDays(Carbon::parse($start)) + 1;
        // Build a set of done day_numbers
        $days = DailyLog::where('challenge_run_id', $this->run->id)
            ->where('user_id', $userId)
            ->pluck('day_number')
            ->all();
        $doneSet = array_fill_keys($days, true);
        $streak = 0;
        for ($d = $todayDay; $d >= 1; $d--) {
            if (!isset($doneSet[$d])) break;
            $streak++;
        }
        return $streak;
    }

    public function render(): View
    {
        $pendingInvites = [];
        if (auth()->id() === $this->run->owner_id) {
            $pendingInvites = ChallengeInvitation::where('challenge_run_id', $this->run->id)
                ->whereNull('accepted_at')
                ->latest()
                ->get();
        }

        // Derniers logs de l'utilisateur connecté pour ce challenge
        $myRecentLogs = DailyLog::where('challenge_run_id', $this->run->id)
            ->where('user_id', auth()->id())
            ->latest('day_number')
            ->take(10)
            ->get();

        // Global progression
        $participantsCount = max(1, $this->run->participantLinks->count());
        $totalDone = DailyLog::where('challenge_run_id', $this->run->id)->count();
        $globalPercent = round(min(100, ($totalDone / ($participantsCount * max(1, (int)$this->run->target_days))) * 100), 1);

        // My done days set for calendar
        $myDoneDays = DailyLog::where('challenge_run_id', $this->run->id)
            ->where('user_id', auth()->id())
            ->pluck('day_number')
            ->all();
        $myDoneDays = array_map('intval', $myDoneDays);

        return view('livewire.page.challenge-show', [
            'progress' => $this->progress,
            'pendingInvites' => $pendingInvites,
            'myRecentLogs' => $myRecentLogs,
            'globalPercent' => $globalPercent,
            'participantsCount' => $participantsCount,
            'myDoneDays' => $myDoneDays,
        ]);
    }

    public function removeParticipant(string $participantId): void
    {
        abort_unless(auth()->id() === $this->run->owner_id, 403);
        $link = $this->run->participantLinks()->whereKey($participantId)->firstOrFail();
        // Ne pas retirer l'owner par ce chemin
        if ($link->user_id === $this->run->owner_id) {
            $this->addError('inviteEmail', "Vous ne pouvez pas retirer l'owner.");
            return;
        }
        $link->delete();
        $this->run->refresh()->load('participantLinks.user');
        session()->flash('message', 'Participant retiré.');
    }

    public function leave(): void
    {
        // L'owner ne peut pas quitter via cette action
        abort_if(auth()->id() === $this->run->owner_id, 403);
        $this->run->participantLinks()->where('user_id', auth()->id())->delete();
        session()->flash('message', 'Vous avez quitté le challenge.');
        redirect()->route('challenges.index');
    }

    public function revokeInvite(string $inviteId): void
    {
        abort_unless(auth()->id() === $this->run->owner_id, 403);
        $inv = ChallengeInvitation::where('challenge_run_id', $this->run->id)
            ->whereKey($inviteId)
            ->whereNull('accepted_at')
            ->first();
        if ($inv) {
            $inv->delete();
            session()->flash('message', 'Invitation révoquée.');
        }
        // refresh pending
        $this->run->refresh();
    }
}
