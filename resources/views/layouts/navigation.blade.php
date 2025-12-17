<nav x-data="{ open: false, userMenuOpen: false }" class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-primary-600 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-handshake text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white hidden md:block">FreelanceHub</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                @auth
                    <!-- Dashboard Links -->
                    <a href="{{ route('dashboard') }}" 
                       class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        Dashboard
                    </a>
                    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        Projects
                    </a>
                    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        Messages
                        <span class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">3</span>
                    </a>
                @endauth
            </div>

            <!-- Right Side -->
            <div class="flex items-center">
                @auth
                    <!-- Notifications -->
                    <button class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 mr-2">
                        <i class="fas fa-bell text-xl"></i>
                    </button>

                    <!-- User Menu -->
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <div class="font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        {{ Auth::user()->role === 'freelancer' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                                           'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' }}">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                            <a href="{{ route('profile') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#" 
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" 
                           class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">
                            Login
                        </a>
                        
                        <!-- Role Selector Component -->
                        <div>
                            @include('marketplace.components.role-selector')
                        </div>
                    </div>
                @endauth

                <!-- Mobile menu button -->
                <button @click="open = !open" class="sm:hidden p-2 ml-2 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-transition class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Dashboard
                </a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Projects
                </a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Messages
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>
