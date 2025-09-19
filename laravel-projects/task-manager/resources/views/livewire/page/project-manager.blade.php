<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center text-blue-700 dark:text-blue-300">Gestion des projets</h1>

    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Formulaire création projet -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <form wire:submit.prevent="createProject" class="flex flex-col gap-2">
            <label class="font-medium">Nom du projet :</label>
            <input type="text" wire:model="projectName" placeholder="Nom du projet..." class="rounded border-gray-300 dark:bg-gray-900 dark:text-white">
            @error('projectName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Créer projet</button>
        </form>
    </div>

    <!-- Formulaire création tâche -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <form wire:submit.prevent="createTask" class="flex flex-col gap-2">
            <label class="font-medium">Nom de la tâche :</label>
            <input type="text" wire:model="taskName" placeholder="Nom de la tâche..." class="rounded border-gray-300 dark:bg-gray-900 dark:text-white">
            @error('taskName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <label class="font-medium">Projet associé :</label>
            <select wire:model="taskProjectId" class="rounded border-gray-300 dark:bg-gray-900 dark:text-white">
                <option value="">-- Choisir un projet --</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            @error('taskProjectId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <x-ui.button type="submit"  title="Créer tâche" />
        </form>
    </div>

    <!-- Liste des projets et tâches -->
    <div class="space-y-6">
        @forelse($projects as $project)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <strong class="text-lg text-blue-700 dark:text-blue-300">{{ $project->name }}</strong>
                        <span class="ml-2 text-xs px-2 py-1 rounded bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">{{ $project->tasks->count() }} tâches</span>
                    </div>
                    <div class="flex gap-2">
                        <x-ui.button link="true" href="{{ route('projects.tasks.index', ['project' => $project->id]) }}" class="text-sm text-nowrap" title="Voir les tâches" />
                        <x-ui.button wire:click="editProject({{ $project->id }})" title="Éditer" />
                        <x-ui.button wire:click="deleteProject({{ $project->id }})" variant="destructive" wire:confirm="Supprimer ce post" title="Supprimer" />
                    </div>
                </div>
                @if($editProjectId === $project->id)
                    <form wire:submit.prevent="updateProject" class="flex gap-2 mb-2">
                        <input type="text" wire:model="editProjectName" class="rounded border-gray-300 dark:bg-gray-900 dark:text-white">
                        <x-ui.button type="submit" title="Valider" />
                        <x-ui.button type="button" wire:click="$set('editProjectId', null)" title="Annuler"/>
                        @error('editProjectName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </form>
                @endif
                <div class="mb-2 text-sm text-gray-600 dark:text-gray-300">Créateur : {{ $project->user->name ?? 'N/A' }}</div>
                <div class="mb-2 text-sm text-gray-600 dark:text-gray-300">Membres :
                    @forelse($project->members as $member)
                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded mr-1">{{ $member->name }}</span>
                    @empty
                        Aucun membre
                    @endforelse
                </div>
                <ul class="list-disc ml-6 mt-2">
                    @forelse($project->tasks as $task)
                        <li class="mb-1">
                            <span @if($task->is_completed) class="line-through text-gray-400" @endif>{{ $task->title }}</span>
                            <span class="ml-2 text-xs text-gray-500">par {{ $task->user->name ?? 'N/A' }}</span>
                            <x-ui.button wire:click="editTask({{ $task->id }})"  title="Éditer" />
                            <x-ui.button wire:click="deleteTask({{ $task->id }})"  onclick="return confirm('Supprimer cette tâche ?')" title="Supprimer" variant="destructive"/>
                            @if($editTaskId === $task->id)
                                <form wire:submit.prevent="updateTask" class="flex gap-2 mt-2">
                                    <input type="text" wire:model="editTaskName" class="rounded border-gray-300 dark:bg-gray-900 dark:text-white">
                                    <button type="submit" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Valider</button>
                                    <button type="button" wire:click="$set('editTaskId', null)" class="px-2 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 text-xs">Annuler</button>
                                    @error('editTaskName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </form>
                            @endif
                        </li>
                    @empty
                        <li class="text-gray-500">Aucune tâche</li>
                    @endforelse
                </ul>
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucun projet</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Commencez par créer votre premier projet pour le défi 100DaysOfCode.</p>
            </div>
        @endforelse
    </div>
</div>
