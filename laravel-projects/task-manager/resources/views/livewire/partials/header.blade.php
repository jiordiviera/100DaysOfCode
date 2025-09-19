<header
    x-data="{ open: false }"
    class="sticky top-0 z-40 backdrop-blur supports-[backdrop-filter]:bg-background/95 bg-background/90 border-b border-border shadow-sm">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="flex items-center justify-between h-16">
            <!-- Logo ou titre -->
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" wire:navigate class="text-xl font-bold text-foreground hover:text-primary-700 transition-colors">{{config('app.name')}}</a>
            </div>
            @if (Route::has('login'))
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a wire:navigate href="{{ route('home') }}" wire:navigate>Accueil</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" wire:navigate>Tableau de bord</a>
                        <a href="{{ route('challenges.index') }}" wire:navigate>Challenges</a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate >Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" wire:navigate >Inscription</a>
                        @endif
                    @endauth
                </nav>
                <!-- Bouton logout visible seulement si authentifié -->
                @auth
                    <a href="{{ route('logout') }}" wire:navigate class="py-2 px-4 rounded bg-destructive text-white hover:bg-destructive hidden md:flex" >Déconnexion</a>
                @endauth
            @endif
            <!-- Menu mobile -->
            <div class="md:hidden flex items-center">
                <!-- Bouton hamburger -->
                <button @click="open = !open"  aria-label="Ouvrir le menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Menu mobile déroulant -->
        <div x-show="open" x-transition class="md:hidden bg-background border-t border-border shadow-lg rounded-b-lg">
            <nav class="flex flex-col gap-2 p-4 text-sm font-medium">
                <a wire:navigate href="{{ route('home') }}" class="py-2 px-4 rounded hover:bg-background/80">Accueil</a>
                @auth
                    <a href="{{ url('/dashboard') }}" wire:navigate class="py-2 px-4 rounded">Tableau de bord</a>
                    <a href="{{ route('challenges.index') }}" wire:navigate class="py-2 px-4 rounded">Challenges</a>
                    <a href="{{ route('logout') }}" wire:navigate class="py-2 px-4 rounded bg-destructive text-white hover:bg-destructive">Déconnexion</a>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="py-2 px-4 rounded ">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" wire:navigate class="py-2 px-4 rounded">Inscription</a>
                    @endif
                @endauth
            </nav>
        </div>
    </div>
</header>
