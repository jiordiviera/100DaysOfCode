<div class="mt-7 border-border rounded-xl shadow-2xs">
  <div class="p-4 sm:p-7">
    <div class="text-center">
      <h1 class="block text-2xl font-bold">Sign in</h1>
      <p class="mt-2 text-sm text-muted-foreground">
        Don't have an account yet?
        <a href={{route('register')}}>
          Sign up here
        </a>
      </p>
    </div>

    <div class="mt-5 mx-auto max-w-sm">

      <!-- Form -->
      <form wire:submit.prevent="submit">
        <div class="grid gap-y-4">
          <!-- Form Group -->
            <x-ui.input label="Email Address" type="email" id="email" wire:model="email" required placeholder="example@mail.com" />
          <!-- End Form Group -->

          <!-- Form Group -->
            <x-ui.input label="Password" type="password" id="password" wire:model="password" required placeholder="*******" />

          <!-- End Form Group -->

          <!-- Checkbox -->
          <div class="flex items-center">
            <div class="flex">
              <input id="remember-me" name="remember-me" type="checkbox">
            </div>
            <div class="ms-3">
              <label for="remember-me" class="text-sm dark:text-white">Remember me</label>
            </div>
          </div>
          <!-- End Checkbox -->

          <button type="submit" class="">Sign in</button>
        </div>
      </form>
      <!-- End Form -->
    </div>
  </div>
</div>
