<?php

namespace App\Livewire\Page;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function getUserStats()
    {
        $user = auth()->user();

        return [
            'projectCount' => $user->projects()->count(),
            'taskCount' => Task::where('user_id', $user->id)->count(),
            'completedTaskCount' => Task::where('user_id', $user->id)
                ->where('is_completed', true)
                ->count(),
            'daysSinceStart' => Carbon::now()->diffInDays($user->created_at),
        ];
    }

    public function getRecentProjects($limit = 3)
    {
        return auth()->user()->projects()->with(['tasks'])->latest()->take($limit)->get();
    }

    public function getRecentTasks($limit = 5)
    {
        return Task::with('project')
            ->where('user_id', auth()->id())
            ->latest()
            ->take($limit)
            ->get();
    }

    public function render()
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
