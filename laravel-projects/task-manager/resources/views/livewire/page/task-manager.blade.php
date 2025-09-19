<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center text-indigo-700 dark:text-indigo-300">Tâches du projet : <span class="text-indigo-900 dark:text-indigo-100">{{ $project->name }}</span></h1>

    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Formulaire création tâche -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <form wire:submit.prevent="createTask" class="flex flex-col gap-2">
            <label class="font-medium">Nom de la tâche :</label>
            <input type="text" wire:model="taskName" placeholder="Nom de la tâche..." class="rounded border-gray-300 dark:bg-gray-900 dark:text-white">
            @error('taskName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <button type="submit" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Créer tâche</button>
        </form>
    </div>

    <!-- Liste des tâches -->
    <div class="space-y-4">
        @forelse($project->tasks as $task)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <div>
                        <span @if($task->is_completed) class="line-through text-gray-400" @endif class="font-medium text-lg">{{ $task->title }}</span>
                        <span class="ml-2 text-xs text-gray-500">par {{ $task->user->name ?? 'N/A' }}</span>
                        @if($task->is_completed)
                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Terminée</span>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        @if(!$task->is_completed)
                            <button wire:click="completeTask({{ $task->id }})" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">Marquer comme terminée</button>
                        @endif
                        <button wire:click="editTask({{ $task->id }})" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">Éditer</button>
                        <button wire:click="deleteTask({{ $task->id }})" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs" onclick="return confirm('Supprimer cette tâche ?')">Supprimer</button>
                    </div>
                </div>
                @if($editTaskId === $task->id)
                    <form wire:submit.prevent="updateTask" class="flex gap-2 mt-2">
                        <input type="text" wire:model="editTaskName" class="rounded border-gray-300 dark:bg-gray-900 dark:text-white">
                        <button type="submit" class="px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs">Valider</button>
                        <button type="button" wire:click="$set('editTaskId', null)" class="px-2 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 text-xs">Annuler</button>
                        @error('editTaskName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </form>
                @endif
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucune tâche pour ce projet.</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ajoutez votre première tâche pour commencer à progresser !</p>
            </div>
        @endforelse
    </div>

    <a href="{{ route('projects.index') }}" class="inline-block mt-8 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Retour aux projets</a>
</div>
