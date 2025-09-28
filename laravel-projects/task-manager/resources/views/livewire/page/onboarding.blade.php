<div class="mx-auto max-w-3xl space-y-6 py-10">
  <x-filament::section>
    <x-slot name="heading">Configuration rapide</x-slot>
    <x-slot name="description">
      Personnalisez votre arrivée : nous préparons automatiquement le bon challenge pour vous.
    </x-slot>

    <form wire:submit.prevent="submit" class="space-y-6">
      {{ $this->form }}

      <div class="flex flex-wrap items-center justify-between gap-3">
        <x-filament::button color="gray" tag="a" href="{{ route('dashboard') }}">
          Passer pour l'instant
        </x-filament::button>
        <x-filament::button type="submit">
          Continuer
        </x-filament::button>
      </div>
    </form>
  </x-filament::section>

  @if ($publicChallenges->isNotEmpty())
    <x-filament::section>
      <x-slot name="heading">Challenges publics suggérés</x-slot>
      <x-slot name="description">
        Sélectionnez-en un dans le formulaire si vous souhaitez rejoindre une communauté existante.
      </x-slot>

      <div class="grid gap-3 md:grid-cols-2">
        @foreach ($publicChallenges as $challenge)
          <x-filament::card>
            <x-slot name="heading">{{ $challenge->title }}</x-slot>
            <div class="space-y-2 text-sm text-muted-foreground" x-data="{ copied: false, copy(text) { navigator.clipboard.writeText(text); this.copied = true; setTimeout(() => this.copied = false, 2000); } }" x-cloak>
              <p>Animé par {{ $challenge->owner?->name ?? 'un membre' }}</p>
              <p>Début : {{ $challenge->start_date->translatedFormat('d/m/Y') }}</p>
              <div class="flex items-center justify-between gap-2">
                <span>{{ $challenge->target_days }} jours • Code : <span class="font-semibold text-foreground">{{ $challenge->public_join_code }}</span></span>
                <button type="button" @click="copy('{{ $challenge->public_join_code }}')" class="text-xs px-2 py-1 rounded border border-primary/40 text-primary hover:bg-primary/10">
                  <span x-show="! copied">Copier</span>
                  <span x-show="copied">Copié !</span>
                </button>
              </div>
            </div>
          </x-filament::card>
        @endforeach
      </div>
    </x-filament::section>
  @endif
</div>
