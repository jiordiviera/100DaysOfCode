<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Project;
use App\Models\Task;
use App\Models\ChallengeRun;

#[Layout('components.layouts.app')]
class ProjectManager extends Component
{
    public $projectName = '';
    public $taskName = '';
    public $taskProjectId = '';
    public $editProjectId = null;
    public $editProjectName = '';
    public $editTaskId = null;
    public $editTaskName = '';
    public ?string $activeRunId = null;

    public function createProject(): void
    {
        $this->validate([
            'projectName' => 'required|string|max:255',
        ]);
        Project::create([
            'name' => $this->projectName,
            'user_id' => auth()->id(),
            'challenge_run_id' => $this->activeRunId,
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

    public function editProject($id)
    {
        $project = Project::findOrFail($id);
        $this->editProjectId = $project->id;
        $this->editProjectName = $project->name;
    }

    public function updateProject()
    {
        $this->validate([
            'editProjectName' => 'required|string|max:255',
        ]);
        $project = Project::findOrFail($this->editProjectId);
        $project->update(['name' => $this->editProjectName]);
        $this->editProjectId = null;
        $this->editProjectName = '';
    }

    public function deleteProject($id)
    {
        Project::findOrFail($id)->delete();
    }

    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        $this->editTaskId = $task->id;
        $this->editTaskName = $task->title;
        $this->taskProjectId = $task->project_id;
    }

    public function updateTask()
    {
        $this->validate([
            'editTaskName' => 'required|string|max:255',
        ]);
        $task = Task::findOrFail($this->editTaskId);
        $task->update(['title' => $this->editTaskName]);
        $this->editTaskId = null;
        $this->editTaskName = '';
        $this->taskProjectId = '';
    }

    public function deleteTask($id)
    {
        Task::findOrFail($id)->delete();
    }

    protected function resolveActiveRun(): void
    {
        $user = auth()->user();
        $run = ChallengeRun::query()
            ->where('status', 'active')
            ->where(function ($q) use ($user) {
                $q->where('owner_id', $user->id)
                  ->orWhereHas('participantLinks', fn($qq) => $qq->where('user_id', $user->id));
            })
            ->latest('start_date')
            ->first();
        $this->activeRunId = $run?->id;
    }

    public function render()
    {
        $user = auth()->user();
        $this->resolveActiveRun();

        $projects = Project::with('tasks', 'user', 'members')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereHas('members', function($qq) use ($user) {
                      $qq->where('users.id', $user->id);
                  });
            })
            ->when($this->activeRunId, fn($q) => $q->where('challenge_run_id', $this->activeRunId))
            ->latest()
            ->get();

        $activeRun = $this->activeRunId ? ChallengeRun::find($this->activeRunId) : null;
        return view('livewire.page.project-manager', [
            'projects' => $projects,
            'activeRun' => $activeRun,
        ]);
    }
}
