<?php

namespace App\Livewire\Page;

use App\Models\ChallengeRun;
use App\Models\Project;
use App\Models\Task;
use Livewire\Attributes\Layout;
use Livewire\Component;

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

    public ?string $feedbackMessage = null;

    public string $feedbackType = 'success';

    protected function setFeedback(string $type, string $message): void
    {
        $this->feedbackType = $type;
        $this->feedbackMessage = $message;
    }

    public function createProject(): void
    {
        $this->resolveActiveRun();

        if (! $this->activeRunId) {
            $this->setFeedback('error', "Vous devez d'abord rejoindre ou créer un challenge actif avant d'ajouter un projet.");

            return;
        }

        $this->validate([
            'projectName' => 'required|string|max:255',
        ]);
        Project::create([
            'name' => $this->projectName,
            'user_id' => auth()->id(),
            'challenge_run_id' => $this->activeRunId,
        ]);
        $this->projectName = '';

        $this->resetErrorBag();
        $this->setFeedback('success', 'Projet créé avec succès.');
    }

    public function createTask(): void
    {
        $this->resolveActiveRun();

        if (! $this->activeRunId) {
            $this->setFeedback('error', "Vous devez d'abord rejoindre ou créer un challenge actif avant d'ajouter une tâche.");

            return;
        }

        $this->validate([
            'taskName' => 'required|string|max:255',
            'taskProjectId' => 'required|exists:projects,id',
        ]);
        $project = Project::query()
            ->whereKey($this->taskProjectId)
            ->where('challenge_run_id', $this->activeRunId)
            ->first();

        if (! $project) {
            $this->addError('taskProjectId', 'Sélectionnez un projet lié à votre challenge actif.');

            return;
        }

        Task::create([
            'title' => $this->taskName,
            'project_id' => $project->id,
            'user_id' => auth()->id(),
        ]);
        $this->taskName = '';
        $this->taskProjectId = '';

        $this->resetErrorBag();
        $this->setFeedback('success', 'Tâche créée avec succès.');
    }

    public function editProject($id): void
    {
        $project = Project::findOrFail($id);
        $this->editProjectId = $project->id;
        $this->editProjectName = $project->name;
    }

    public function updateProject(): void
    {
        $this->validate([
            'editProjectName' => 'required|string|max:255',
        ]);
        $project = Project::findOrFail($this->editProjectId);
        $project->update(['name' => $this->editProjectName]);
        $this->editProjectId = null;
        $this->editProjectName = '';
    }

    public function deleteProject($id): void
    {
        Project::findOrFail($id)->delete();
    }

    public function editTask($id): void
    {
        $task = Task::findOrFail($id);
        $this->editTaskId = $task->id;
        $this->editTaskName = $task->title;
        $this->taskProjectId = $task->project_id;
    }

    public function updateTask(): void
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

    public function deleteTask($id): void
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
                    ->orWhereHas('participantLinks', fn ($qq) => $qq->where('user_id', $user->id));
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
                    ->orWhereHas('members', function ($qq) use ($user) {
                        $qq->where('users.id', $user->id);
                    });
            })
            ->when($this->activeRunId, fn ($q) => $q->where('challenge_run_id', $this->activeRunId))
            ->latest()
            ->get();

        $activeRun = $this->activeRunId ? ChallengeRun::find($this->activeRunId) : null;

        return view('livewire.page.project-manager', [
            'projects' => $projects,
            'activeRun' => $activeRun,
        ]);
    }
}
