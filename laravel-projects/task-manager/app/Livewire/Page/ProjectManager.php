<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;

class ProjectManager extends Component
{
    public $projectName = '';
    public $taskName = '';
    public $taskProjectId = '';

    public function createProject(): void
    {
        $this->validate([
            'projectName' => 'required|string|max:255',
        ]);
        Project::create([
            'name' => $this->projectName,
            'user_id' => auth()->id(),
        ]);
        $this->projectName = '';
    }

    public function createTask(): void
    {
        $this->validate([
            'taskName' => 'required|string|max:255',
            'taskProjectId' => 'required|exists:projects,id',
        ]);
        Task::create([
            'title' => $this->taskName,
            'project_id' => $this->taskProjectId,
            'user_id' => auth()->id(),
        ]);
        $this->taskName = '';
        $this->taskProjectId = '';
    }

    public function render()
    {
        $user = auth()->user();
        $projects = Project::with('tasks')
            ->where('user_id', $user->id)
            ->orWhereHas('members', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->get();
        return view('livewire.page.project-manager', [
            'projects' => $projects,
        ]);
    }
}
