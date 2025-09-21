<div class="max-w-5xl mx-auto py-8 space-y-8">
    @if (session()->has("message"))
        <div
            class="p-3 rounded bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200"
        >
            {{ session("message") }}
        </div>
    @endif

    <div class="bg-muted-foreground/20 shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Créer un challenge</h2>
        <form wire:submit.prevent="create" class="grid sm:grid-cols-2 gap-4">
            <flux:input
                label="Titre"
                placeholder="100 Days of Code"
                wire:model="title"
                class="w-full"
            />
            <flux:input
                label="Date de début"
                type="date"
                wire:model="start_date"
                class="w-full"
            />
            <flux:input
                label="Nombre de jours"
                type="number"
                wire:model="target_days"
                class="w-full"
            />
{{--            <div class="flex items-center gap-2 pt-6">--}}
{{--                <input id="is_public" type="checkbox" wire:model="is_public"/>--}}
{{--                <label for="is_public" class="text-sm">Rendre public</label>--}}
{{--            </div>--}}
            <div class="inline-flex items-center gap-2">
            <flux:field variant="inline">
                <flux:checkbox wire:model="is_public" />

                <flux:label>Rendre public</flux:label>

                <flux:error name="is_public" />
            </flux:field>
            </div>
            <div class="sm:col-span-2">
                <flux:button type="submit" >Créer</flux:button>
            </div>
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
                                Début: {{ $run->start_date->format("Y-m-d") }} •
                                {{ $run->target_days }} jours
                            </div>
                        </div>
                        <x-ui.button
                            :link="true"
                            href="{{ route('challenges.show', $run) }}"
                            title="Ouvrir"
                        />
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
                                Début: {{ $run->start_date->format("Y-m-d") }} •
                                {{ $run->target_days }} jours
                            </div>
                        </div>
                        <x-ui.button
                            :link="true"
                            href="{{ route('challenges.show', $run) }}"
                            title="Ouvrir"
                        />
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
