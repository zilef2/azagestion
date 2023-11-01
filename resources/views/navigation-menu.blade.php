<?php 
$versionapp = "0.9.0";
?>
<nav x-data="{ open: false }" class="" 
{{-- style="background-color: #00a0df" --}}
style="
background: rgb(4,160,218);
background: linear-gradient(90deg, rgba(4,160,218,1) 32%, rgba(0,160,223,1) 100%);
" 
>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="text-white hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-white">
                        {{ __('Menu Principal') }}
                        <div wire:offline> ¡No hay coneccion a internet! </div>
                    </x-jet-nav-link>
                    @if(Auth::user()->is_admin >= 1 || Auth::user()->getRol() == 'Asignador' || Auth::user()->getRol() == 'Revisor')
                        <x-jet-nav-link href="{{ route('SubirOrdenesDeCompra') }}" :active="request()->routeIs('SubirOrdenesDeCompra')" class="text-white">
                            {{ __('Subir OC') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('RechazadosAceptadosRevisor') }}" :active="request()->routeIs('RechazadosAceptadosRevisor')" class="text-white">
                            {{ __('Rechazados') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('SubirUsuarios') }}" :active="request()->routeIs('SubirUsuarios')" class="text-white">
                            {{ __('Subir Usuarios') }}
                        </x-jet-nav-link>
                        @if (Auth::user()->is_admin > 0 && (Auth::user()->name === 'admin' || Auth::user()->name === 'Admin'))
                            <x-jet-nav-link href="{{ route('todaBD') }}" :active="request()->routeIs('SubirUsuarios')" class="text-white">
                                {{ __('Export Toda') }}
                            </x-jet-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <div class="text-white hidden sm:flex sm:items-center sm:ml-6">
                <a href="{{ route('TutorialDash') }}" class="cursor-pointer mx-2"> ❔ </a> 
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <small class="mx-2">{{ Auth::user()->getRol() }} &nbsp; @if(Auth::user()->is_admin >= 2) {{ $versionapp }} @endif </small> 
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="text-white flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    <div class="text-xl text-red-400 w-full" wire:offline> ¡No hay coneccion a internet! </div>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-sky-500/75 hover:text-sky-800 focus:outline-none focus:bg-sky-100 active:bg-sky-400/50 transition">
                                        <b>
                                            {{ Auth::user()->name }}
                                            {{ Auth::user()->is_admin > 0 ? '✅ Admin' : '' }}
                                            {{ Auth::user()->is_admin > 1 ? '😎 SUPER' : '' }}
                                        </b> <br>
                                        <div wire:offline> ¡No hay coneccion a internet! </div>
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /> </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <div class="block p-4 text-md text-gray-600">
                                {{ Auth::user()->email }}
                            </div>
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>
                            @if (Auth::user()->is_admin > 0)
                                <x-jet-dropdown-link href="{{ route('CambioRoles') }}">
                                    Roles
                                </x-jet-dropdown-link>
                            @endif


                            @if (Auth::user()->is_admin > 0)
                                <x-jet-dropdown-link href="{{ route('todaBD') }}">
                                    {{ __('Exportar la BD') }}
                                </x-jet-dropdown-link>
                            @endif



                            

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos()) <div class="shrink-0 mr-3"> <img class="text-white h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" /> </div> @endif

                <div>
                    <div class="text-white font-medium text-base">{{ Auth::user()->name }}</div>
                    <div class="text-white font-medium text-sm">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="text-white ">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')" class="text-white ">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();" class="text-white ">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
