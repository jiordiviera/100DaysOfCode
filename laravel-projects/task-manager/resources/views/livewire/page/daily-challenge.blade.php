<x-filament::card
    heading="Progression du jour ({{ $challengeDate }})"
    description="Complétez votre journal pour garder votre rythme."
>
    @if (session()->has('message'))
        <div class="mb-4 rounded-md bg-green-100 px-3 py-2 text-sm text-green-800 dark:bg-green-900/60 dark:text-green-200">
            {{ session('message') }}
        </div>
    @endif

    @if ($todayEntry && $todayEntry->completed)
        <div class="space-y-4">
            <x-filament::badge color="success">
                Entrée du jour déjà complétée !
            </x-filament::badge>

            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-xs uppercase text-muted-foreground">Description</dt>
                    <dd class="mt-1 whitespace-pre-line rounded-md bg-muted px-3 py-2 font-mono text-sm">
                        {{ $todayEntry->notes }}
                    </dd>
                </div>

                <div>
                    <dt class="text-xs uppercase text-muted-foreground">Projets travaillés</dt>
                    <dd class="mt-1 flex flex-wrap gap-2">
                        @php($projects = collect($todayEntry->projects_worked_on ?? []))

                        @if ($projects->isNotEmpty())
                            @foreach ($projects as $pid)
                                @php($project = $allProjects->find($pid))
                                @if ($project)
                                    <x-filament::badge color="gray">
                                        {{ $project->name }}
                                    </x-filament::badge>
                                @endif
                            @endforeach
                        @else
                            <span class="text-muted-foreground">Aucun</span>
                        @endif
                    </dd>
                </div>

                <div class="grid gap-3 md:grid-cols-3">
                    <div class="rounded-md bg-muted px-3 py-2">
                        <p class="text-xs uppercase text-muted-foreground">Heures codées</p>
                        <p class="text-base font-semibold">{{ $todayEntry->hours_coded }}</p>
                    </div>
                    <div class="rounded-md bg-muted px-3 py-2">
                        <p class="text-xs uppercase text-muted-foreground">Apprentissages</p>
                        <p class="text-sm">{{ $todayEntry->learnings ?: '—' }}</p>
                    </div>
                    <div class="rounded-md bg-muted px-3 py-2">
                        <p class="text-xs uppercase text-muted-foreground">Difficultés</p>
                        <p class="text-sm">{{ $todayEntry->challenges_faced ?: '—' }}</p>
                    </div>
                </div>
            </dl>
        </div>
    @else
        <form wire:submit.prevent="saveEntry" class="space-y-4">
            {{ $this->form }}

            <x-filament::button type="submit" color="primary">
                Sauvegarder ma progression
            </x-filament::button>
        </form>
    @endif
</x-filament::card>
