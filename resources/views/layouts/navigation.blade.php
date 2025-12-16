<nav x-data="{ open: false }" class="bg-surface border-b border-white/10 shadow-lg shadow-black/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    
                    @php
                       
                        $role = Auth::user()->role;
                        $homeRoute = match ($role) {
                            'admin' => route('admin.dashboard'),
                            'kasir' => route('kasir.dashboard'),
                            default => route('pengguna.menu.index'), 
                        };
                    @endphp
                    
                    <a href="{{ $homeRoute }}" class="font-serif text-xl italic text-gold hover:text-moon transition">
                        ruang teduh.
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-white/10 text-sm leading-4 font-medium rounded-md text-moon bg-surface hover:text-gold focus:outline-none focus:bg-void transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            
                            <div class="ms-3 text-xs uppercase tracking-widest text-gold bg-gold/10 px-2 py-0.5 rounded-full border border-gold/30">
                                {{ Auth::user()->role }}
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-moon hover:bg-void/50">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-400 hover:bg-void/50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-dim hover:text-moon hover:bg-void/50 focus:outline-none focus:bg-void/50 focus:text-moon transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-void border-t border-white/5">
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="$homeRoute" :active="request()->routeIs($homeRoute)" class="text-moon hover:bg-surface">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-white/5">
            <div class="px-4">
                <div class="font-medium text-base text-moon">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-dim">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-moon hover:bg-surface">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-red-400 hover:bg-surface">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>