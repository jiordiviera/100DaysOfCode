<div
  class="w-full max-w-md border border-border rounded-xl shadow-2xs bg-background"
>
  <div class="p-6 sm:p-8">
    <div class="text-center">
      <h1 class="block text-2xl font-bold">Connexion</h1>
      <p class="mt-2 text-sm text-muted-foreground">
        Pas encore de compte ?
        <x-filament::link
          href="{{ route('register') }}"
          wire:navigate
        >
          Créer un compte
        </x-filament::link>
      </p>
    </div>

    <div class="mt-6">
      <x-filament::button
        class="w-full justify-center"
        color="gray"
        outlined
        disabled
      >
        @include("components.ui.icons.github")
        <span>Continuer avec GitHub (bientôt)</span>
      </x-filament::button>
    </div>

    <div
      class="my-6 grid grid-cols-[1fr_auto_1fr] items-center gap-3 text-xs text-muted-foreground"
    >
      <span class="h-px bg-border"></span>
      <span>ou</span>
      <span class="h-px bg-border"></span>
    </div>

    <div>
      <form wire:submit.prevent="submit" class="grid gap-y-4">
        <x-ui.input
          label="Adresse e-mail"
          type="email"
          id="email"
          name="email"
          wire:model="email"
          required
          placeholder="exemple@mail.com"
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
          autocomplete="current-password"
        />

        <div class="flex items-center justify-between">
          <label
            for="remember"
            class="flex items-center gap-2 text-sm cursor-pointer select-none"
          >
            <input
              id="remember"
              name="remember"
              type="checkbox"
              class="size-4"
              wire:model="remember"
            />
            <span>Se souvenir de moi</span>
          </label>
          <span class="text-sm text-muted-foreground">
            Mot de passe oublié ?
          </span>
        </div>

        <x-filament::button class="w-full" type="submit">
          Se connecter
        </x-filament::button>
      </form>
    </div>
  </div>
</div>
