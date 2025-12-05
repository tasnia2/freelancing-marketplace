<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Freelance Marketplace - Find Talent & Projects</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">FreelanceHub</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="#features" class="text-gray-600 hover:text-gray-900">Features</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-gray-900">How it Works</a>
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login</a>
                    <a href="{{ route('register') }}" 
                       class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-24">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                        Connect with <span class="text-yellow-300">Top Talent</span> Worldwide
                    </h1>
                    <p class="text-xl opacity-90 mb-8">
                        The premier freelance marketplace for businesses and professionals. 
                        Hire experts or find your next project opportunity.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" 
                           class="px-8 py-4 bg-white text-blue-600 font-bold rounded-xl hover:shadow-2xl text-center">
                            <i class="fas fa-rocket mr-2"></i> Get Started Free
                        </a>
                        <a href="#how-it-works" 
                           class="px-8 py-4 border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 text-center">
                            <i class="fas fa-play-circle mr-2"></i> See How It Works
                        </a>
                    </div>
                </div>
                
                <div class="lg:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="floating">
                            <div class="w-64 h-64 md:w-80 md:h-80 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center">
                                <div class="text-center p-8">
                                    <i class="fas fa-handshake text-6xl mb-4"></i>
                                    <h3 class="text-2xl font-bold">50K+ Successful Projects</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-white rounded-xl shadow-sm">
                    <div class="text-3xl font-bold text-blue-600 mb-2">50,000+</div>
                    <div class="text-gray-600">Freelancers</div>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm">
                    <div class="text-3xl font-bold text-green-600 mb-2">10,000+</div>
                    <div class="text-gray-600">Clients</div>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm">
                    <div class="text-3xl font-bold text-purple-600 mb-2">$5M+</div>
                    <div class="text-gray-600">Paid to Freelancers</div>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm">
                    <div class="text-3xl font-bold text-yellow-600 mb-2">4.9/5</div>
                    <div class="text-gray-600">Client Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose FreelanceHub?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Everything you need for successful freelance collaboration</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card p-8 bg-white rounded-2xl shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Secure Payments</h3>
                    <p class="text-gray-600">Escrow protection ensures you only pay for approved work. Safe and reliable transactions.</p>
                </div>
                
                <div class="feature-card p-8 bg-white rounded-2xl shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-6">
                        <i class="fas fa-search text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Smart Matching</h3>
                    <p class="text-gray-600">AI-powered recommendations connect you with the perfect freelancers or projects.</p>
                </div>
                
                <div class="feature-card p-8 bg-white rounded-2xl shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mb-6">
                        <i class="fas fa-headset text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">24/7 Support</h3>
                    <p class="text-gray-600">Round-the-clock customer support to help you with any issues or questions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Get Started?</h2>
            <p class="text-white/90 text-lg mb-8">
                Join thousands of freelancers and clients who are already succeeding on our platform.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" 
                   class="px-8 py-4 bg-white text-blue-600 font-bold rounded-xl hover:shadow-2xl">
                    <i class="fas fa-user-plus mr-2"></i> Create Free Account
                </a>
                <a href="{{ route('login') }}" 
                   class="px-8 py-4 bg-white/20 backdrop-blur-sm text-white font-bold rounded-xl hover:bg-white/30 border-2 border-white">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <span class="text-xl font-bold">FreelanceHub</span>
                    </div>
                    <p class="text-gray-400">Connecting talent with opportunity since 2023</p>
                </div>
                
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400 text-sm">
                <p>&copy; 2023 FreelanceHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
