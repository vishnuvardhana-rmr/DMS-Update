<nav x-data="{ open: false }" class="bg-indigo-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo and Navigation Links -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role == 1 ? route('admin.dashboard') : route('user.dashboard') }}" class="navbar-logo flex items-center group">
                        <div class="relative">
                            <!-- Logo Circle Background -->
                            <div class="absolute inset-0 transform scale-105 bg-gradient-to-r from-blue-400 to-purple-600 rounded-full transition duration-300 ease-in-out group-hover:scale-110"></div>
                            <!-- Logo SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="text-white relative z-10" viewBox="0 0 24 24">
                                <path d="M12 0C5.372 0 0 5.373 0 12s5.372 12 12 12 12-5.373 12-12S18.628 0 12 0zm1.374 17.373L10.373 14h1.127l2.53 2.53c.172.172.392.26.616.26.224 0 .444-.088.616-.26.345-.345.345-.903 0-1.248l-2.53-2.53h1.127l-3-3H12l1.374 1.373c.345.345.345.903 0 1.248-.172.172-.392.26-.616.26-.224 0-.444-.088-.616-.26zM12 6.618l-2.53 2.53L12 11.78l2.53-2.53L12 6.618z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white ml-2 transition duration-300 ease-in-out group-hover:translate-x-1">DMS</span>
                    </a>
                </div>
            </div>

            <!-- Navigation Links + User Dropdown in same flex container -->
            <div class="hidden sm:flex sm:items-center space-x-4">
                <div class="flex space-x-4">
                    @if(Auth::user()->role == 1)
                        <x-nav-link :href="route('admin.documents.index')" :active="request()->routeIs('admin.documents.index')" class="nav-link text-white">
                            {{ __('Documents') }}
                        </x-nav-link>

                        @if(isset($folder)) 
                            <x-nav-link :href="route('admin.documents.grant-access', $folder->id)" class="nav-link text-white">
                                {{ __('Grant Access') }}
                            </x-nav-link>
                        @endif
                    @else
                        <x-nav-link :href="route('user.documents.index')" :active="request()->routeIs('user.documents.index')" class="nav-link text-white">
                            {{ __('Documents') }}
                        </x-nav-link>
                    @endif
                </div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md dropdown-btn hover:bg-indigo-700 focus:outline-none transition ease-in-out duration-150">
                            <span class="text-white">{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="-mr-2 flex sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-white hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white">
                {{ Auth::user()->role == 1 ? __('Admin Dashboard') : __('User Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role == 1)
                <x-responsive-nav-link :href="route('admin.documents.index')" :active="request()->routeIs('admin.documents.index')" class="text-white">
                    {{ __('Documents') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('user.documents.index')" :active="request()->routeIs('user.documents.index')" class="text-white">
                    {{ __('Documents') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive User Options -->
        <div class="pt-4 pb-1 border-t border-indigo-300">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-white">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
