<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img class="block h-10 w-auto fill-current" src="/img/STRIZZI_Logo.png" alt="Logo">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <!-- Küche Dropdown -->
                @if ($kitchenWatchRight)
                    <div class="hidden lg:flex lg:items-center lg:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-800 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Küche') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('rezepte.index', ['type' => 1])" :active="request()->routeIs('rezepte.*')">
                                    {{ __('Gerichte') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('produkte.index', ['type' => 1])" :active="request()->routeIs('produkte.*')">
                                    {{ __('Mise en Place') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Bar Dropdown -->
                @if ($kitchenWatchRight)
                    <div class="hidden lg:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-800 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Bar') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('rezepte.index', ['type' => 2])" :active="request()->routeIs('rezepte.*')">
                                    {{ __('Bar Angebote') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('produkte.index', ['type' => 2])" :active="request()->routeIs('produkte.*')">
                                    {{ __('Bar Mise en Place') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Eis Dropdown -->
                @if ($kitchenWatchRight)
                    <div class="hidden lg:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-800 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Eis') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('rezepte.index', ['type' => 3])" :active="request()->routeIs('rezepte.*')">
                                    {{ __('Eis Angebote') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('produkte.index', ['type' => 3])" :active="request()->routeIs('produkte.*')">
                                    {{ __('Eis Mise en Place') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Lager Dropdown -->
                @if ($warehouseRight)
                    <div class="hidden lg:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-800 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Lager') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('zutaten.index')" :active="request()->routeIs('zutaten.*')">
                                    {{ __('Zutaten') }}
                                </x-dropdown-link>
                                @if ($stocktakingRight)
                                    <x-dropdown-link :href="route('inventuren.index', ['type' => 1])" :active="request()->routeIs('inventuren.*')">
                                        {{ __('Inventuren') }}
                                    </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Bestellungen Dropdown -->
                @if ($orderRight)
                    <div class="hidden lg:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-800 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Bestellungen') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('bestellungen.index')" :active="request()->routeIs('bestellungen.index')">
                                    {{ __('Bestellungen einsehen') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('bestellungen.new')" :active="request()->routeIs('bestellungen.new')">
                                    {{ __('Neue Bestellung') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Administration Dropdown -->
                <div class="hidden lg:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-800 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ __('Verwaltung') }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if ($warehouseRight)
                                <x-dropdown-link :href="route('lieferanten.index')" :active="request()->routeIs('lieferanten.*')">
                                    {{ __('Lieferanten') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('inventare.index')" :active="request()->routeIs('inventare.*')">
                                    {{ __('Inventar') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('naehrwerte.index')" :active="request()->routeIs('naehrwerte.*')">
                                    {{ __('Nährwerte') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('allergene.index')" :active="request()->routeIs('allergene.*')">
                                    {{ __('Allergene') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('einheiten.index')" :active="request()->routeIs('einheiten.*')">
                                    {{ __('Maßeinheiten') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('kategorien.index')" :active="request()->routeIs('kategorien.*')">
                                    {{ __('Kategorisierung') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('lagerorte.index')" :active="request()->routeIs('lagerorte.*')">
                                    {{ __('Lagerorte') }}
                                </x-dropdown-link>
                            @endif
                            @if ($staffRight)
                                <!-- Personal -->
                                <x-dropdown-link :href="route('user.index')" :active="request()->routeIs('user.*')">
                                    {{ __('Mitarbeiter') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('logs.index')" :active="request()->routeIs('logs.*')">
                                    {{ __('Logs') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('tagesbar.index')" :active="request()->routeIs('tagesbar.*')">
                                    {{ __('Tagesbar Auswertung') }}
                                </x-dropdown-link>
                            @endif
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden lg:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="pt-4 pb-1 border-t border-gray-200">
            <x-responsive-nav-link class="font-bold text-gray-900" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Küche Navigation-->
        @if ($kitchenWatchRight)
            <div class="py-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-bold text-gray-900">{{ __('Küche') }}</div>
                    <x-responsive-nav-link :href="route('rezepte.index', ['type' => 1])" :active="request()->is(['1/rezepte', '1/rezepte/*'])">
                        {{ __('Gerichte') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('produkte.index', ['type' => 1])" :active="request()->is(['1/produkte', '1/produkte/*'])">
                        {{ __('Mise en Place') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endif
        <!-- Responsive Bar Navigation-->
        @if ($kitchenWatchRight)
            <div class="py-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-bold text-gray-900">{{ __('Bar') }}</div>
                    <x-responsive-nav-link :href="route('rezepte.index', ['type' => 2])" :active="request()->is(['2/rezepte', '2/rezepte/*'])">
                        {{ __('Bar Angebote') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('produkte.index', ['type' => 2])" :active="request()->is(['2/produkte', '2/produkte/*'])">
                        {{ __('Bar Mise en Place') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endif
        <!-- Responsive Eis Navigation-->
        @if ($kitchenWatchRight)
            <div class="py-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-bold text-gray-900">{{ __('Eis') }}</div>
                    <x-responsive-nav-link :href="route('rezepte.index', ['type' => 3])" :active="request()->is(['3/rezepte', '3/rezepte/*'])">
                        {{ __('Eis Angebote') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('produkte.index', ['type' => 3])" :active="request()->is(['3/produkte', '3/produkte/*'])">
                        {{ __('Eis Mise en Place') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endif

        <!-- Responsive Lager Navigation -->
        @if ($warehouseRight)
            <div class="py-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-bold text-gray-900">{{ __('Lager') }}</div>
                    <x-responsive-nav-link :href="route('zutaten.index')" :active="request()->routeIs('zutaten.*')">
                        {{ __('Zutaten') }}
                    </x-responsive-nav-link>
                    @if ($stocktakingRight)
                        <x-responsive-nav-link :href="route('inventuren.index', ['type' => 1])" :active="request()->routeIs('inventuren.*')">
                            {{ __('Inventuren') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endif

        <!-- Responsive Bestellungen Navigation -->
        @if ($orderRight)
            <div class="py-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-bold text-gray-900">{{ __('Bestellungen') }}</div>
                    <x-responsive-nav-link :href="route('bestellungen.index')" :active="request()->routeIs('bestellungen.index')">
                        {{ __('Bestellungen einsehen') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('bestellungen.new')" :active="request()->routeIs('bestellungen.new')">
                        {{ __('Neue Bestellung') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endif

        <!-- Responsive administration Navigation-->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-bold text-gray-900">{{ __('Verwaltung') }}</div>
                @if ($warehouseRight)
                    <x-responsive-nav-link :href="route('lieferanten.index')" :active="request()->routeIs('lieferanten.*')">
                        {{ __('Lieferanten') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inventare.index')" :active="request()->routeIs('inventare.*')">
                        {{ __('Inventar') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('naehrwerte.index')" :active="request()->routeIs('naehrwerte.*')">
                        {{ __('Nährwerte') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('allergene.index')" :active="request()->routeIs('allergene.*')">
                        {{ __('Allergene') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('einheiten.index')" :active="request()->routeIs('einheiten.*')">
                        {{ __('Maßeinheiten') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('kategorien.index')" :active="request()->routeIs('kategorien.*')">
                        {{ __('Kategorisierung') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('lagerorte.index')" :active="request()->routeIs('lagerorte.*')">
                        {{ __('Lagerorte') }}
                    </x-responsive-nav-link>
                    @endif
                    @if($staffRight)
                    <x-responsive-nav-link :href="route('user.index')" :active="request()->routeIs('user.*')">
                        {{ __('Mitarbeiter') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('logs.index')" :active="request()->routeIs('logs.*')">
                        {{ __('Logs') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('tagesbar.index')" :active="request()->routeIs('tagesbar.*')">
                        {{ __('Tagesbar Auswertung') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    @if (Auth::user()->picture)
                        <img class="w-20" src="/storage{{ Auth::user()->picture }}">
                    @else
                        <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    @endif
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
