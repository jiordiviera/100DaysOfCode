<div class="shadow rounded-lg p-6 bg-muted-foreground/20">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
        Progression du jour ({{ $challengeDate }})
    </h3>

    @if (session()->has("message"))
        <div
            class="mb-4 p-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded"
        >
            {{ session("message") }}
        </div>
    @endif

    @if ($todayEntry && $todayEntry->completed)
        <div
            class="mb-4 p-3 bg-primary/80  rounded"
        >
            <strong>Entrée du jour déjà complétée !</strong>
            <br/>
            <span class="block mt-2">Description : {{ $todayEntry->notes }}</span>
            <span class="block mt-2">
        Projets travaillés :
        @if (! empty($todayEntry->projects_worked_on))
                    @foreach ($todayEntry->projects_worked_on as $pid)
                        @php
                            $p = $allProjects->find($pid);
                        @endphp

                        @if ($p)
                            <span
                                class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded mr-1"
                            >
                {{ $p->name }}
              </span>
                        @endif
                    @endforeach
                @else
                    Aucun
                @endif
      </span>
            <span class="block mt-2">
        Heures codées : {{ $todayEntry->hours_coded }}
      </span>
            <span class="block mt-2">
        Apprentissages : {{ $todayEntry->learnings }}
      </span>
            <span class="block mt-2">
        Difficultés : {{ $todayEntry->challenges_faced }}
      </span>
        </div>
    @else
        <form wire:submit.prevent="saveEntry" class="space-y-4">

{{--            <x-ui.input type="textarea" rows="3" label="Description du jour" wire:model.defer="description" name="description"/>--}}
            <flux:textarea label="Description du jour" wire:model.defer="description" />
            <flux:select wire:model="projectsWorkedOn" label="Projets travaillés"  multiple="true">
                @foreach ($allProjects as $project)--}}
                <flux:select.option value="{{ $project->id }}">{{ $project->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:input type="number" label="Heures codées" min="0.25" step="0.25" wire:model.defer="hoursCoded" name="hoursCoded"/>

            <flux:textarea label="Apprentissages du jour" wire:model.defer="learnings" name="learnings"/>
            <flux:textarea label="Difficultés rencontrées" wire:model.defer="challengesFaced" name="challengesFaced"/>
            <flux:button type="submit" variant="primary">Sauvegarder ma progression</flux:button>
        </form>
    @endif
</div>
