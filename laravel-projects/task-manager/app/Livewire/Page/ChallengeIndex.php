<?php

namespace App\Livewire\Page;

use App\Models\ChallengeRun;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Mes Challenges')]
#[Layout('components.layouts.app')]
class ChallengeIndex extends Component
{
    public string $title = '';

    public string $start_date;

    public int $target_days = 100;

    public bool $is_public = false;

    public function mount(): void
    {
        $this->start_date = now()->toDateString();
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|unique:challenge_runs,title|max:255',
            'start_date' => 'required|date',
            'target_days' => 'required|integer|min:1|max:365',
        ];
    }

    public function create(): void
    {
        $this->validate();

        $run = ChallengeRun::create([
            'owner_id' => auth()->id(),
            'title' => $this->title,
            'start_date' => $this->start_date,
            'target_days' => $this->target_days,
            'status' => 'active',
            'is_public' => $this->is_public,
        ]);
        $run->participantLinks()->create([
            'user_id' => auth()->id(),
            'joined_at' => now(),
        ]);

        redirect()->route('challenges.show', ['run' => $run->id]);
    }

    public function render(): View
    {
        $user = auth()->user();
        $owned = $user->challengeRunsOwned()->latest()->get();
        $joined = $user->challengeRuns()->whereNotIn('challenge_runs.id', $owned->pluck('id'))->latest()->get();

        return view('livewire.page.challenge-index', [
            'owned' => $owned,
            'joined' => $joined,
        ]);
    }
}
