<div class="mt-7 border-border rounded-xl shadow-2xs">
    <div class="p-4 sm:p-7">
        <div class="text-center">
            <h1 class="block text-2xl font-bold">Sign up</h1>
            <p class="mt-2 text-sm text-muted-foreground">
                Already have an account?
                <a href={{route('login')}}>
                    Sign in here
                </a>
            </p>
        </div>

        <div class="mt-5 mx-auto max-w-sm">

            <!-- Form -->
            <form wire:submit.prevent="submit">
                <div class="grid gap-y-4">
                    <x-ui.input label="Name" type="text" id="name" wire:model="name" required placeholder="John Doe" />
                    <x-ui.input label="Email Address" type="email" id="email" wire:model="email" required placeholder="john@example.com" />
                    <x-ui.input label="Password" type="password" id="password" wire:model="password" required placeholder="*******" />
                    <x-ui.input label="Password confirmation" type="password" id="password_confirmation" wire:model="password_confirmation" required placeholder="*******" />

                    <button type="submit" class="">Sign in</button>
                </div>
            </form>
            <!-- End Form -->
        </div>
    </div>
</div>
