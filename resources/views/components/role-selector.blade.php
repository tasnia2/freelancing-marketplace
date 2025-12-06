{{-- resources/views/components/role-selector.blade.php --}}
<div x-data="{ showRoleModal: false, selectedRole: null }" x-cloak>
    <!-- Role Selection Modal -->
    <template x-teleport="body">
        <div x-show="showRoleModal" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            
            <div @click.away="showRoleModal = false" 
                 class="relative w-full max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
                
                <!-- Close Button -->
                <button @click="showRoleModal = false" 
                        class="absolute top-6 right-6 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 z-10">
                    <i class="fas fa-times text-2xl"></i>
                </button>

                <!-- Modal Content -->
                <div class="p-8 md:p-12">
                    <div class="text-center mb-12">
                        <div class="inline-block p-8 rounded-3xl bg-gradient-to-r from-primary-500 via-purple-500 to-pink-500 mb-8 transform hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-handshake text-5xl text-white"></i>
                        </div>
                        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">Start Your Journey</h2>
                        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                            Join thousands of freelancers and clients building amazing projects together
                        </p>
                    </div>

                    <!-- Role Cards -->
                    <div class="grid md:grid-cols-2 gap-8 mb-12">
                        <!-- Freelancer Card -->
                        <div @click="selectRole('freelancer')"
                             :class="selectedRole === 'freelancer' ? 'ring-4 ring-purple-500 shadow-2xl transform scale-[1.02]' : 'hover:shadow-xl hover:-translate-y-2'"
                             class="p-10 border-2 border-gray-200 dark:border-gray-700 rounded-3xl cursor-pointer transition-all duration-300 group bg-gradient-to-b from-white to-gray-50 dark:from-gray-800 dark:to-gray-900">
                            <div class="text-center">
                                <div class="w-28 h-28 rounded-full bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <i class="fas fa-laptop-code text-4xl text-white"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">I'm a Freelancer</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
                                    I want to offer my skills and find amazing projects
                                </p>
                                <div class="space-y-4 text-left">
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <span>Find work worldwide</span>
                                    </div>
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <span>Set your own rates & schedule</span>
                                    </div>
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <span>Secure milestone payments</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client Card -->
                        <div @click="selectRole('client')"
                             :class="selectedRole === 'client' ? 'ring-4 ring-green-500 shadow-2xl transform scale-[1.02]' : 'hover:shadow-xl hover:-translate-y-2'"
                             class="p-10 border-2 border-gray-200 dark:border-gray-700 rounded-3xl cursor-pointer transition-all duration-300 group bg-gradient-to-b from-white to-gray-50 dark:from-gray-800 dark:to-gray-900">
                            <div class="text-center">
                                <div class="w-28 h-28 rounded-full bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <i class="fas fa-briefcase text-4xl text-white"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">I'm a Client</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
                                    I want to hire talent and get projects done
                                </p>
                                <div class="space-y-4 text-left">
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <span>Access top freelancers</span>
                                    </div>
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <span>Manage projects easily</span>
                                    </div>
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-500"></i>
                                        </div>
                                        <span>Protected payment system</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <div class="text-center" x-show="selectedRole">
                        <button @click="continueToRegister"
                                class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-primary-600 to-purple-600 text-white font-bold text-xl rounded-2xl hover:shadow-2xl hover:scale-105 transition-all duration-300 transform">
                            <span>Continue as </span>
                            <span x-text="selectedRole === 'freelancer' ? ' Freelancer' : ' Client'" class="ml-2"></span>
                            <i class="fas fa-arrow-right ml-4 animate-pulse"></i>
                        </button>
                        <p class="mt-6 text-gray-500 dark:text-gray-400 text-sm">
                            You can change your role preferences later in settings
                        </p>
                    </div>

                    <!-- Already have account -->
                    <div class="text-center mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-600 dark:text-gray-400">
                            Already have an account?
                            <a href="{{ route('login') }}" 
                               class="text-primary-600 dark:text-primary-400 font-semibold hover:underline ml-2">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
    function selectRole(role) {
        this.selectedRole = role;
    }
    
    function continueToRegister() {
        if (this.selectedRole) {
            window.location.href = `/register?role=${this.selectedRole}`;
        }
    }
    </script>
</div>