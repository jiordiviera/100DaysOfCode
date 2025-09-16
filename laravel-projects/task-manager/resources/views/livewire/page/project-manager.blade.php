<div>
    <!-- Formulaire création projet -->
    <form wire:submit.prevent="createProject">
        <label>Nom du projet :</label>
        <input type="text" wire:model="projectName">
        <button type="submit">Créer projet</button>
        @error('projectName') <span style="color:red">{{ $message }}</span> @enderror
    </form>

    <!-- Formulaire création tâche -->
    <form wire:submit.prevent="createTask" style="margin-top:1em;">
        <label>Nom de la tâche :</label>
        <input type="text" wire:model="taskName">
        <label>Projet associé :</label>
        <select wire:model="taskProjectId">
            <option value="">-- Choisir un projet --</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
        <button type="submit">Créer tâche</button>
        @error('taskName') <span style="color:red">{{ $message }}</span> @enderror
        @error('taskProjectId') <span style="color:red">{{ $message }}</span> @enderror
    </form>

    <!-- Liste des projets et tâches -->
    <div style="margin-top:2em;">
        <h3>Projets et tâches</h3>
        @foreach($projects as $project)
            <div style="margin-bottom:1em;">
                <strong>{{ $project->name }}</strong>
                <div>Créateur : {{ $project->user->name ?? 'N/A' }}</div>
                <div>Membres :
                    @forelse($project->members as $member)
                        {{ $member->name }}@if(!$loop->last), @endif
                    @empty
                        Aucun membre
                    @endforelse
                </div>
                <ul>
                    @forelse($project->tasks as $task)
                        <li>{{ $task->title }} (par {{ $task->user->name ?? 'N/A' }})</li>
                    @empty
                        <li>Aucune tâche</li>
                    @endforelse
                </ul>
            </div>
        @endforeach
    </div>
</div>
