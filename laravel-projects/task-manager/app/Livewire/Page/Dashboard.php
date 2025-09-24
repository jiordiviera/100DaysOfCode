<?php

namespace App\Livewire\Page;

use App\Models\ChallengeRun;
use App\Models\DailyLog;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function getUserStats(): array
    {
        $user = auth()->user();
        $ownedProjects = $user->projects()->pluck('id');
        $memberProjects = $user->memberProjects()->pluck('project_id');
        $projectCount = $ownedProjects->merge($memberProjects)->unique()->count();

        // Active run = dernier run actif où l'utilisateur est owner ou participant
        $activeRun = ChallengeRun::query()
            ->where('status', 'active')
            ->where(function ($q) use ($user) {
                $q->where('owner_id', $user->id)
                    ->orWhereHas('participantLinks', fn ($qq) => $qq->where('user_id', $user->id));
            })
            ->latest('start_date')
            ->first();

        $active = null;
        if ($activeRun) {
            $target = max(1, (int) $activeRun->target_days);
            $dayNumber = round(max(1, Carbon::parse($activeRun->start_date)->diffInDays(Carbon::now()) + 1));
            $myDone = DailyLog::where('challenge_run_id', $activeRun->id)->where('user_id', $user->id)->count();
            $myPercent = round(min(100, ($myDone / $target) * 100));
            $active = [
                'run' => $activeRun,
                'dayNumber' => $dayNumber,
                'targetDays' => $target,
                'myPercent' => $myPercent,
            ];
        }

        return [
            'projectCount' => $projectCount,
            'taskCount' => Task::where('user_id', $user->id)->count(),
            'completedTaskCount' => Task::where('user_id', $user->id)
                ->where('is_completed', true)
                ->count(),
            'active' => $active,
        ];
    }

    public function getRecentProjects($limit = 3)
    {
        $user = auth()->user();
        // Si un challenge actif existe, filtrer les projets liés à ce challenge
        $activeRun = ChallengeRun::query()
            ->where('status', 'active')
            ->where(function ($q) use ($user) {
                $q->where('owner_id', $user->id)
                    ->orWhereHas('participantLinks', fn ($qq) => $qq->where('user_id', $user->id));
            })
            ->latest('start_date')
            ->first();

        $query = $user->projects()->with(['tasks'])->latest();
        if ($activeRun) {
            $query->where('challenge_run_id', $activeRun->id);
        }

        return $query->take($limit)->get();
    }

    public function getRecentTasks($limit = 5): \Illuminate\Database\Eloquent\Collection|array
    {
        return Task::with('project')
            ->where('user_id', auth()->id())
            ->latest()
            ->take($limit)
            ->get();
    }

    public function render(): View
    {
        $stats = $this->getUserStats();
        $recentProjects = $this->getRecentProjects();
        $recentTasks = $this->getRecentTasks();

        return view('livewire.page.dashboard', [
            'stats' => $stats,
            'recentProjects' => $recentProjects,
            'recentTasks' => $recentTasks,
        ]);
    }
}
