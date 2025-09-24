@php
  $active = $stats['active'] ?? null;
  $projectCount = $stats['projectCount'] ?? 0;
  $taskCount = $stats['taskCount'] ?? 0;
  $completedTaskCount = $stats['completedTaskCount'] ?? 0;
  $taskCompletionRate = $taskCount > 0 ? round(($completedTaskCount / max($taskCount, 1)) * 100) : 0;
  $activeDayNumber = $active['dayNumber'] ?? null;
  $targetDays = $active['targetDays'] ?? 100;
  $daysLeft = $activeDayNumber ? max(0, $targetDays - $activeDayNumber) : null;
  $taskCompletionDescription = $taskCount > 0 ? $taskCompletionRate . '% complétées' : 'Aucune tâche pour le moment';
  $challengeDayValue = $activeDayNumber ? 'Jour ' . min($targetDays, $activeDayNumber) . '/' . $targetDays : 'Aucun challenge';
  $challengeDayDescription = $daysLeft !== null ? $daysLeft . ' jours restants' : 'Rejoignez un challenge';
@endphp

<div class="mx-auto max-w-6xl space-y-6 py-6">
  <x-filament::section
    heading="Tableau de bord"
    description="Bienvenue dans votre espace 100DaysOfCode."
  >
    <div class="flex flex-wrap gap-3">
      <x-filament::button tag="a" href="{{ route('daily-challenge') }}">
        Journal du jour
      </x-filament::button>
      <x-filament::button tag="a" href="{{ route('projects.index') }}" color="gray">
        Gérer mes projets
      </x-filament::button>
      <x-filament::button tag="a" href="{{ route('challenges.index') }}" color="gray">
        Challenges
      </x-filament::button>
    </div>
  </x-filament::section>

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-filament::card heading="Total Projets">
      <div class="text-3xl font-semibold">{{ $projectCount }}</div>
      <p class="text-sm text-muted-foreground">Projets suivis pendant le défi</p>
    </x-filament::card>
    <x-filament::card heading="Total Tâches">
      <div class="text-3xl font-semibold">{{ $taskCount }}</div>
      <p class="text-sm text-muted-foreground">Tâches planifiées</p>
    </x-filament::card>
    <x-filament::card heading="Tâches complétées">
      <div class="text-3xl font-semibold">{{ $completedTaskCount }}</div>
      <p class="text-sm text-muted-foreground">{{ $taskCompletionDescription }}</p>
    </x-filament::card>
    <x-filament::card heading="Jours du défi">
      <div class="text-2xl font-semibold">{{ $challengeDayValue }}</div>
      <p class="text-sm text-muted-foreground">{{ $challengeDayDescription }}</p>
    </x-filament::card>
  </div>

  <x-filament::card heading="Progression du défi">
    @if ($active)
      @php
        $run = $active['run'] ?? null;
        $percent = (int) ($active['myPercent'] ?? 0);
        $boundedPercent = max(0, min(100, $percent));
      @endphp

      <div class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <p class="text-sm text-muted-foreground">
              {{ $run?->title ?? 'Challenge actif' }}
            </p>
            <div class="flex flex-wrap items-center gap-2 text-xs text-muted-foreground">
              @if ($activeDayNumber)
                <span>Jour {{ min($targetDays, $activeDayNumber) }}/{{ $targetDays }}</span>
              @endif
              @if ($daysLeft !== null)
                <span>•</span>
                <span>{{ $daysLeft }} jours restants</span>
              @endif
            </div>
          </div>
          <x-filament::badge color="primary">
            {{ $boundedPercent }}% accompli
          </x-filament::badge>
        </div>

        <div class="h-3 w-full overflow-hidden rounded-full bg-muted">
          <div
            class="h-full rounded-full bg-primary transition-all"
            style="width: {{ $boundedPercent }}%"
          ></div>
        </div>

        <div class="flex flex-wrap gap-2">
          @if ($run)
            <x-filament::button tag="a" href="{{ route('challenges.show', $run->id) }}">
              Voir le challenge
            </x-filament::button>
          @endif
          <x-filament::button tag="a" href="{{ route('daily-challenge') }}" color="gray">
            Renseigner ma journée
          </x-filament::button>
        </div>
      </div>
    @else
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <p class="text-sm text-muted-foreground">
          Aucun challenge actif. Lancez-vous pour suivre vos progrès jour après jour.
        </p>
        <x-filament::button tag="a" href="{{ route('challenges.index') }}">
          Créer ou rejoindre un challenge
        </x-filament::button>
      </div>
    @endif
  </x-filament::card>

  <x-filament::section
    heading="Suivi quotidien"
    description="Complétez votre entrée de la journée pour garder votre dynamique."
  >
    @livewire("page.daily-challenge")
  </x-filament::section>

  <x-filament::section>
    <div class="flex flex-wrap items-center justify-between gap-4">
      <div>
        <h2 class="text-lg font-semibold">Mes projets récents</h2>
        <p class="text-sm text-muted-foreground">Les projets sur lesquels vous avez travaillé dernièrement.</p>
      </div>
      <x-filament::button tag="a" href="{{ route('projects.index') }}" color="gray">
        Tous les projets
      </x-filament::button>
    </div>

    <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
      @forelse ($recentProjects as $project)
        <x-filament::card :heading="$project->name">
          <x-slot name="description">
            {{ $project->description ?? 'Aucune description disponible pour ce projet.' }}
          </x-slot>

          <div class="space-y-3 text-sm">
            <x-filament::badge color="primary">
              {{ $project->tasks->count() }} tâches
            </x-filament::badge>
            <div class="text-xs text-muted-foreground">
              Créé le {{ $project->created_at->format('d/m/Y') }}
            </div>
            <div class="flex flex-wrap items-center justify-between gap-2">
              <x-filament::button
                tag="a"
                href="{{ route('projects.tasks.index', ['project' => $project->id]) }}"
                size="sm"
                color="gray"
              >
                Voir détails
              </x-filament::button>
              <x-filament::badge color="success">
                {{ $project->tasks->where('is_completed', true)->count() }}/{{ $project->tasks->count() }} complétées
              </x-filament::badge>
            </div>
          </div>
        </x-filament::card>
      @empty
        <x-filament::card heading="Aucun projet">
          <x-slot name="description">
            Commencez par créer votre premier projet pour le défi 100DaysOfCode.
          </x-slot>

          <x-filament::button tag="a" href="{{ route('projects.index') }}">
            Créer un projet
          </x-filament::button>
        </x-filament::card>
      @endforelse
    </div>
  </x-filament::section>

  <x-filament::card id="tasks" heading="Mes tâches récentes">
    <div class="space-y-4">
      @forelse ($recentTasks as $task)
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <h3 class="text-sm font-medium">{{ $task->title }}</h3>
            <p class="text-xs text-muted-foreground">
              Projet : {{ $task->project->name }}
            </p>
          </div>
          <x-filament::badge :color="$task->is_completed ? 'success' : 'gray'">
            {{ $task->is_completed ? 'Terminée' : 'À faire' }}
          </x-filament::badge>
        </div>
      @empty
        <p class="py-4 text-center text-sm text-muted-foreground">
          Vous n'avez pas encore créé de tâches pour vos projets.
        </p>
      @endforelse
    </div>

    <div class="mt-4">
      <x-filament::button tag="a" href="#" color="gray">
        Toutes les tâches
      </x-filament::button>
    </div>
  </x-filament::card>
</div>
