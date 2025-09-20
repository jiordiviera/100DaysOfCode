<?php

namespace App\Livewire\Page;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class TaskManager extends Component
{
    public $project;

    public $taskName = '';

    public $editTaskId = null;

    public $editTaskName = '';

    public function mount($project)
    {
        $this->project = Project::with('tasks.user')->findOrFail($project);
    }

    public function createTask()
    {
        $this->validate([
            'taskName' => 'required|string|max:255',
        ]);
        Task::create([
            'title' => $this->taskName,
            'project_id' => $this->project->id,
            'user_id' => auth()->id(),
        ]);
        $this->taskName = '';
        $this->project->refresh();
    }

    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        $this->editTaskId = $task->id;
        $this->editTaskName = $task->title;
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
        $this->project->refresh();
    }

    public function deleteTask($id)
    {
        Task::findOrFail($id)->delete();
        $this->project->refresh();
    }

    public function completeTask($id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = true;
        $task->save();
        $this->project->refresh();
    }

    public function render()
    {
        return view('livewire.page.task-manager', [
            'project' => $this->project,
        ]);
    }
}
