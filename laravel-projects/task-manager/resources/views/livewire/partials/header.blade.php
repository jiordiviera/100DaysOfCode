<header class="sticky top-0 z-40 backdrop-blur supports-[backdrop-filter]:bg-background/95 bg-background/90 border-b border-border shadow-sm">
    <div className="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div className="flex items-center justify-between h-16">
    @if (Route::has('login'))
        <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
        <a wire:navigate href={{route('home')}}>Home</a>
            @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="relative px-3 py-2 rounded-lg transition-all duration-200"
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="relative px-3 py-2 rounded-lg transition-all duration-200"
                    
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        class="relative px-3 py-2 rounded-lg transition-all duration-200"
                        href="{{ route('register') }}">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
    </div>
    </div>
</header>
