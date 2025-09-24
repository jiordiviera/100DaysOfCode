<div class="max-w-5xl mx-auto py-8 space-y-8">
    @if (session()->has('message'))
        <div class="p-3 rounded bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-muted-foreground/20 shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Créer un challenge</h2>
        <form wire:submit.prevent="create" class="space-y-4">
            {{ $this->form }}

            <x-filament::button type="submit" color="primary">
                Créer
            </x-filament::button>
        </form>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-muted-foreground/20 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Mes challenges</h3>
            <ul class="space-y-2">
                @forelse ($owned as $run)
                    <li class="flex justify-between items-center">
                        <div>
                            <div class="font-medium">
                                {{ $run->title ?? "100 Days of Code" }}
                            </div>
                            <div class="text-xs text-muted-foreground">
                                Début: {{ $run->start_date->format('Y-m-d') }} •
                                {{ $run->target_days }} jours
                            </div>
                        </div>
                        <x-filament::button tag="a" href="{{ route('challenges.show', $run) }}" color="gray">
                            Ouvrir
                        </x-filament::button>
                    </li>
                @empty
                    <li class="text-sm text-muted-foreground">Aucun challenge créé.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-muted-foreground/20 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Challenges rejoints</h3>
            <ul class="space-y-2">
                @forelse ($joined as $run)
                    <li class="flex justify-between items-center">
                        <div>
                            <div class="font-medium">
                                {{ $run->title ?? "100 Days of Code" }}
                            </div>
                            <div class="text-xs text-muted-foreground">
                                Début: {{ $run->start_date->format('Y-m-d') }} •
                                {{ $run->target_days }} jours
                            </div>
                        </div>
                        <x-filament::button tag="a" href="{{ route('challenges.show', $run) }}" color="gray">
                            Ouvrir
                        </x-filament::button>
                    </li>
                @empty
                    <li class="text-sm text-muted-foreground">
                        Aucun challenge rejoint.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
