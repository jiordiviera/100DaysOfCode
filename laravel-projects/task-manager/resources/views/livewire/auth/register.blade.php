  <div class="w-full max-w-md border border-border rounded-xl shadow-2xs bg-background">
    <div class="p-6 sm:p-8">
      <div class="text-center">
        <h1 class="block text-2xl font-bold">Créer un compte</h1>
        <p class="mt-2 text-sm text-muted-foreground">
          Vous avez déjà un compte ?
          <x-ui.button :link="true" variant="link" size="sm" href="{{ route('login') }}" wire:navigate title="Se connecter" />
        </p>
      </div>

      <div class="mt-6">
        <x-ui.button class="w-full justify-center" variant="outline" disabled>
          @include('components.ui.icons.github')
          <span>S'inscrire avec GitHub (bientôt)</span>
        </x-ui.button>
      </div>

      <div class="my-6 grid grid-cols-[1fr_auto_1fr] items-center gap-3 text-xs text-muted-foreground">
        <span class="h-px bg-border"></span>
        <span>ou</span>
        <span class="h-px bg-border"></span>
      </div>

      <div>
        <form wire:submit.prevent="submit" class="grid gap-y-4">
          <x-ui.input
            label="Nom"
            type="text"
            id="name"
            name="name"
            wire:model="name"
            required
            placeholder="Jean Dupont"
            autocomplete="name"
          />

          <x-ui.input
            label="Adresse e-mail"
            type="email"
            id="email"
            name="email"
            wire:model="email"
            required
            placeholder="jean@example.com"
            autocomplete="email"
          />

          <x-ui.input
            label="Mot de passe"
            type="password"
            id="password"
            name="password"
            wire:model="password"
            required
            placeholder="••••••••"
            autocomplete="new-password"
          />

          <x-ui.input
            label="Confirmation du mot de passe"
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            wire:model="password_confirmation"
            required
            placeholder="••••••••"
            autocomplete="new-password"
          />

          <x-ui.button class="w-full" type="submit" title="Créer le compte" />
        </form>
      </div>
    </div>
  </div>
