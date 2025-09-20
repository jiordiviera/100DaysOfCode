<div class="max-w-4xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-2 text-center">Projets</h1>

  @if ($activeRun)
    <p class="text-center text-sm text-muted-foreground mb-6">
      Challenge actif:
      <a
        class="underline"
        href="{{ route("challenges.show", $activeRun->id) }}"
      >
        {{ $activeRun->title ?? "100 Days of Code" }}
      </a>
      • démarré le {{ $activeRun->start_date->format("Y-m-d") }}
    </p>
  @else
    <p class="text-center text-sm text-muted-foreground mb-6">
      Aucun challenge actif.
      <a class="underline" href="{{ route("challenges.index") }}">
        Créer ou rejoindre
      </a>
    </p>
  @endif

  @if (session()->has("message"))
    <div
      class="mb-4 p-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded"
    >
      {{ session("message") }}
    </div>
  @endif

  <!-- Formulaire création projet -->
  <div
    class="border border-border rounded-xl shadow-2xs bg-background p-6 mb-8"
  >
    <form wire:submit.prevent="createProject" class="grid gap-3">
      <x-ui.input
        label="Nom du projet"
        id="project_name"
        name="projectName"
        wire:model="projectName"
        placeholder="Mon super projet"
      />
      @error("projectName")
        <span class="text-red-500 text-xs">{{ $message }}</span>
      @enderror

      <x-ui.button type="submit" title="Créer le projet" />
      @if ($activeRun)
        <p class="text-xs text-muted-foreground">
          Le projet sera rattaché au challenge
          “{{ $activeRun->title ?? "100 Days of Code" }}”.
        </p>
      @endif
    </form>
  </div>

  <!-- Formulaire création tâche -->
  <div
    class="border border-border rounded-xl shadow-2xs bg-background p-6 mb-8"
  >
    <form wire:submit.prevent="createTask" class="grid gap-3">
      <x-ui.input
        label="Nom de la tâche"
        id="task_name"
        name="taskName"
        wire:model="taskName"
        placeholder="Nouvelle tâche"
      />
      @error("taskName")
        <span class="text-red-500 text-xs">{{ $message }}</span>
      @enderror

      <div>
        <label class="block text-sm mb-2">Projet associé</label>
        <select wire:model="taskProjectId" class="w-full">
          <option value="">-- Choisir un projet --</option>
          @foreach ($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
          @endforeach
        </select>
        @error("taskProjectId")
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
      <x-ui.button type="submit" title="Créer la tâche" />
    </form>
  </div>

  <!-- Liste des projets et tâches -->
  <div class="space-y-6">
    @forelse ($projects as $project)
      <div class="border border-border rounded-xl shadow-2xs bg-background p-6">
        <div class="flex justify-between items-center mb-2">
          <div>
            <strong class="text-lg">{{ $project->name }}</strong>
            <span
              class="ml-2 text-xs px-2 py-1 rounded bg-secondary text-secondary-foreground"
            >
              {{ $project->tasks->count() }} tâches
            </span>
          </div>
          <div class="flex gap-2">
            <x-ui.button
              link="true"
              href="{{ route('projects.tasks.index', ['project' => $project->id]) }}"
              class="text-sm text-nowrap"
              title="Voir les tâches"
            />
            <x-ui.button
              wire:click="editProject({{ $project->id }})"
              title="Éditer"
            />
            <x-ui.button
              wire:click="deleteProject({{ $project->id }})"
              variant="destructive"
              title="Supprimer"
            />
          </div>
        </div>
        @if ($editProjectId === $project->id)
          <form wire:submit.prevent="updateProject" class="flex gap-2 mb-2">
            <x-ui.input
              id="edit_project_{{ $project->id }}"
              name="editProjectName"
              wire:model="editProjectName"
            />
            <x-ui.button type="submit" title="Valider" />
            <x-ui.button
              type="button"
              wire:click="$set('editProjectId', null)"
              title="Annuler"
            />
            @error("editProjectName")
              <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
          </form>
        @endif

        <div class="mb-2 text-sm text-muted-foreground">
          Créateur : {{ $project->user->name ?? "N/A" }}
        </div>
        <div class="mb-2 text-sm text-muted-foreground">
          Membres :
          @forelse ($project->members as $member)
            <span class="px-2 py-1 bg-accent/50 rounded mr-1">
              {{ $member->name }}
            </span>
          @empty
            Aucun membre
          @endforelse
        </div>
        <ul class="list-disc ml-6 mt-2">
          @forelse ($project->tasks as $task)
            <li class="mb-1">
              <span
                @if($task->is_completed) class="line-through text-gray-400" @endif
              >
                {{ $task->title }}
              </span>
              <span class="ml-2 text-xs text-gray-500">
                par {{ $task->user->name ?? "N/A" }}
              </span>
              <x-ui.button
                wire:click="editTask({{ $task->id }})"
                title="Éditer"
              />
              <x-ui.button
                wire:click="deleteTask({{ $task->id }})"
                title="Supprimer"
                variant="destructive"
              />
              @if ($editTaskId === $task->id)
                <form wire:submit.prevent="updateTask" class="flex gap-2 mt-2">
                  <x-ui.input
                    id="edit_task_{{ $task->id }}"
                    name="editTaskName"
                    wire:model="editTaskName"
                  />
                  <x-ui.button size="sm" type="submit" title="Valider" />
                  <x-ui.button
                    size="sm"
                    type="button"
                    wire:click="$set('editTaskId', null)"
                    variant="outline"
                    title="Annuler"
                  />
                  @error("editTaskName")
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                  @enderror
                </form>
              @endif
            </li>
          @empty
            <li class="text-gray-500">Aucune tâche</li>
          @endforelse
        </ul>
      </div>
    @empty
      <div
        class="border border-border rounded-xl shadow-2xs bg-background p-8 text-center"
      >
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
          Aucun projet
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          Commencez par créer votre premier projet pour le défi 100DaysOfCode.
        </p>
      </div>
    @endforelse
  </div>
</div>
