<?php

namespace App\Livewire\Page;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TaskManager extends Component
{
    public Project $project;

    #[Locked]
    public string $projectId;

    #[Validate('required|string|max:255')]
    public string $taskName = '';

    public ?int $editTaskId = null;

    #[Validate('required|string|max:255')]
    public string $editTaskName = '';

    public function mount(Project $project): void
    {
        $this->projectId = $project->id;
        $this->refreshProject();
    }

    public function createTask(): void
    {
        $this->validateOnly('taskName');

        Task::create([
            'title' => $this->taskName,
            'project_id' => $this->project->id,
            'user_id' => auth()->id(),
        ]);

        $this->reset('taskName');
        $this->resetErrorBag('taskName');
        $this->refreshProject();
    }

    public function editTask(int $id): void
    {
        $task = Task::findOrFail($id);

        $this->editTaskId = $task->id;
        $this->editTaskName = $task->title;
    }

    public function updateTask(): void
    {
        $this->validateOnly('editTaskName');

        $task = Task::findOrFail($this->editTaskId);
        $task->update(['title' => $this->editTaskName]);

        $this->reset('editTaskId', 'editTaskName');
        $this->resetErrorBag('editTaskName');
        $this->refreshProject();
    }

    public function deleteTask(string $id): void
    {
        Task::findOrFail($id)->delete();

        $this->refreshProject();
    }

    public function completeTask(string $id): void
    {
        $task = Task::findOrFail($id);
        dd($task);
        $task->update(['is_completed' => true]);

        $this->refreshProject();
    }

    protected function refreshProject(): void
    {
        $this->project = Project::with('tasks.user')->findOrFail($this->projectId);
    }

    public function render(): View
    {
        return view('livewire.page.task-manager', [
            'project' => $this->project,
        ]);
    }
}
