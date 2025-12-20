<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $freelancer->name }} - WorkNest Freelancer</title>
    
    <!-- Include your existing CSS/JS links -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/worknest-themes.css') }}" rel="stylesheet">
</head>
<body class="theme-guest bg-gray-50 dark:bg-gray-900">
    
    <!-- Navigation (Simplified for public view) -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-handshake text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-bold text-gray-800 dark:text-white">
                        Work<span class="gradient-text">Nest</span>
                    </span>
                </a>
                <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Home
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Profile Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Profile Header -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Profile Picture/Initial -->
                <div class="w-32 h-32 rounded-full bg-gradient-to-r from-[#5B21B6] to-[#7C3AED] flex items-center justify-center text-white text-4xl font-bold">
                    {{ substr($freelancer->name, 0, 1) }}
                </div>
                
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $freelancer->name }}</h1>
                            <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">{{ $freelancer->title ?? 'Freelancer' }}</p>
                            <div class="flex items-center mt-4">
                                <div class="flex items-center mr-6">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-{{ $i <= ($freelancer->rating ?? 4.5) ? 'yellow-400' : 'gray-300' }} mr-1"></i>
                                    @endfor
                                    <span class="ml-2 text-gray-600 dark:text-gray-300">{{ $freelancer->rating ?? 4.5 }}/5</span>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full text-sm">
                                    {{ $freelancer->availability ?? 'Available' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-800 dark:text-white">
                                ${{ $freelancer->hourly_rate ?? 50 }}/hr
                            </div>
                            <div class="text-gray-500 dark:text-gray-400 mt-2">
                                Member since {{ $freelancer->created_at->format('M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tags/Skills -->
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Skills & Expertise</h3>
                <div class="flex flex-wrap gap-2">
                    @if(isset($freelancer->skills) && $freelancer->skills->count() > 0)
                        @foreach($freelancer->skills as $skill)
                            <span class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                    @else
                        @foreach(['Laravel', 'PHP', 'Vue.js', 'MySQL', 'REST API', 'Tailwind CSS'] as $skill)
                            <span class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full">
                                {{ $skill }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

                <!-- Two Column Layout -->
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Left Column (2/3 width) -->
            <div class="md:col-span-2 space-y-8">
                <!-- About Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">About Me</h2>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $freelancer->bio ?? 'Experienced freelancer with a passion for delivering high-quality work. I specialize in creating efficient, scalable solutions and have worked with clients from startups to enterprises.' }}
                    </p>
                    
                    <!-- Experience Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Professional Experience</h3>
                        <div class="space-y-4">
                            
                            <!-- Current Position from User Fields -->
                            @if($freelancer->title || $freelancer->company)
                                <div class="border-l-4 border-[#5B21B6] pl-4 py-2 bg-gradient-to-r from-[#5B21B6]/5 to-transparent">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            @if($freelancer->title)
                                                <h4 class="font-bold text-gray-800 dark:text-white">{{ $freelancer->title }}</h4>
                                            @endif
                                            @if($freelancer->company)
                                                <p class="text-gray-600 dark:text-gray-300">{{ $freelancer->company }}</p>
                                            @endif
                                            <span class="inline-block mt-2 px-3 py-1 bg-[#5B21B6]/10 text-[#5B21B6] dark:text-[#A78BFA] text-xs rounded-full">
                                                Current Position
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Present</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Fallback Experience Items -->
                            <div class="border-l-4 border-[#5B21B6] pl-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold text-gray-800 dark:text-white">Senior Full Stack Developer</h4>
                                        <p class="text-gray-600 dark:text-gray-300">Various Tech Companies</p>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                                            Led development of web applications using Laravel, Vue.js, and modern frameworks.
                                            Focus on scalable architecture and performance optimization.
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">2019 - Present</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-l-4 border-[#5B21B6] pl-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold text-gray-800 dark:text-white">Web Development Specialist</h4>
                                        <p class="text-gray-600 dark:text-gray-300">Freelance Projects</p>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                                            Developed custom solutions for clients including e-commerce platforms,
                                            business dashboards, and API integrations.
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">2017 - 2019</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-l-4 border-[#5B21B6] pl-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold text-gray-800 dark:text-white">Junior Developer</h4>
                                        <p class="text-gray-600 dark:text-gray-300">Digital Agency</p>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                                            Built responsive websites and web applications, collaborated with design teams,
                                            and maintained client projects.
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">2015 - 2017</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio/Projects -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Expertise</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach(['Web Development', 'API Integration', 'Database Design', 'UI/UX Implementation'] as $expertise)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover-lift">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#5B21B6]/20 to-[#7C3AED]/20 flex items-center justify-center mb-4">
                                    <i class="fas fa-laptop-code text-xl text-[#5B21B6]"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 dark:text-white">{{ $expertise }}</h4>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                    Professional services in {{ strtolower($expertise) }} with focus on quality and timely delivery.
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- END Left Column -->

            <!-- Right Column (1/3 width) -->
            <div class="space-y-8">
                <!-- Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Performance Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-300">Job Success</span>
                            <span class="font-bold text-gray-800 dark:text-white">98%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-300">On Budget</span>
                            <span class="font-bold text-gray-800 dark:text-white">95%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-300">On Time</span>
                            <span class="font-bold text-gray-800 dark:text-white">96%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-300">Repeat Hire Rate</span>
                            <span class="font-bold text-gray-800 dark:text-white">85%</span>
                        </div>
                    </div>
                </div>

                <!-- Contact/CTA (for clients) -->
                @auth
                    @if(auth()->user()->role == 'client')
                        <div class="bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-white mb-4">Hire {{ $freelancer->name }}</h3>
                            <p class="text-white/80 mb-6">Ready to start a project with this freelancer?</p>
                            <div class="space-y-3">
                                <a href="{{ route('messages.show', $freelancer->id) }}" 
                                   class="block w-full py-3 bg-white text-[#1B3C53] font-bold rounded-lg text-center hover:bg-gray-100 transition-colors duration-300">
                                    <i class="fas fa-envelope mr-2"></i> Send Message
                                </a>
                                <a href="{{ route('contracts-create') }}" 
                                   class="block w-full py-3 bg-white/20 text-white font-bold rounded-lg text-center hover:bg-white/30 transition-colors duration-300 border border-white">
                                    <i class="fas fa-file-contract mr-2"></i> Hire Now
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-gradient-to-r from-[#3A506B] to-[#5B6C8D] rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Want to hire?</h3>
                        <p class="text-white/80 mb-6">Sign up as a client to contact this freelancer</p>
                        <a href="{{ route('register', ['role' => 'client']) }}" 
                           class="block w-full py-3 bg-white text-[#3A506B] font-bold rounded-lg text-center hover:bg-gray-100 transition-colors duration-300">
                            Sign Up as Client
                        </a>
                    </div>
                @endauth

                <!-- Reviews - Fixed -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Client Feedback</h3>
                    <div class="space-y-4">
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <div class="flex items-center mb-2">
                                <div class="flex items-center mr-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">2 months ago</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">"Excellent work! Delivered ahead of schedule with great communication."</p>
                            <p class="text-gray-500 dark:text-gray-400 text-xs mt-2">- Sarah Johnson, TechCorp Inc.</p>
                        </div>
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <div class="flex items-center mb-2">
                                <div class="flex items-center mr-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">4 months ago</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">"Professional and skilled developer. Would definitely hire again."</p>
                            <p class="text-gray-500 dark:text-gray-400 text-xs mt-2">- Michael Chen, StartupXYZ</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Right Column -->
        </div>
        <!-- END Two Column Layout -->
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} WorkNest. All rights reserved.</p>
            <p class="text-gray-400 text-sm mt-2">Freelancer profile - View only</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Simple theme detection for guest theme
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>