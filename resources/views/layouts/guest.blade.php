{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'WorkNest - Freelance Marketplace')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
<style>
    body {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        overflow-x: hidden;
    }
    
    /* Gradient Background */
    .gradient-bg {
        background: linear-gradient(-45deg, #6f1b55ff, #d899b1ff, #23a6d5, #9ad1c5ff);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }

    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Particle Styles */
    .particle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        pointer-events: none;
    }

    /* Blob Animation */
    .blob-animation {
        animation: blob 7s infinite;
    }

    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    /* Main container - keep flex but ensure full height */
    .min-h-screen.flex {
        min-height: 100vh;
    }
    
    /* ===== LAYOUT ===== */
    
    /* Left side */
    .left-side {
        display: none; /* Hidden by default on mobile */
        position: relative;
        overflow: hidden;
    }
    
    @media (min-width: 768px) {
        .left-side {
            display: block;
            width: 55%;
        }
    }
    
    @media (min-width: 1024px) {
        .left-side {
            width: 44%; /* Adjust this to increase picture size */
        }
    }
    
    /* Ensure image covers properly */
    .left-side img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        inset: 0;
    }
    
    /* Right side */
    .right-side {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }
    
    @media (min-width: 768px) {
        .right-side {
            width: 50%;
            padding: 2rem;
        }
    }
    
    @media (min-width: 1024px) {
        .right-side {
            width: 45%; /* Adjust this to balance with left side */
        }
    }
    
    /* Card container */
    .right-side-content {
        width: 100%;
        max-width: 420px; /* Adjust this to increase card width */
        margin: 0 auto;
    }
    
    /* Auth card */
    .auth-card {
        background: rgba(255, 255, 255, 0.10);
        backdrop-filter: blur(30px);
        border-radius: 20px;
        padding: 2.5rem; /* Adjust this to increase card padding */
        width: 100%;
        max-width: 420px; /* Adjust this to increase card width */
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        border: 1px solid rgba(255, 255, 255, 0.25);
        transition: transform 0.3s ease;
    }
    
    .auth-card:hover {
        transform: translateY(-2px);
    }
    
    /* ===== DECORATIVE ELEMENTS ===== */
    
    /* Floating shapes */
    .floating-shapes {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
    }
    
    .shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(40px);
        opacity: 0.15;
    }
    
    .shape-1 {
        width: 300px;
        height: 300px;
        background: #cb649fff;
        top: 10%;
        left: 10%;
        animation: float-1 20s infinite ease-in-out;
    }
    
    .shape-2 {
        width: 200px;
        height: 200px;
        background: #96cfcbff;
        top: 60%;
        right: 15%;
        animation: float-2 25s infinite ease-in-out;
    }
    
    .shape-3 {
        width: 150px;
        height: 150px;
        background: #d8cfa2ff;
        bottom: 20%;
        left: 20%;
        animation: float-3 30s infinite ease-in-out;
    }
    
    @keyframes float-1 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -50px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }
    
    @keyframes float-2 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(-40px, 30px) rotate(-90deg); }
        66% { transform: translate(20px, -20px) rotate(180deg); }
    }
    
    @keyframes float-3 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(15px, 40px) rotate(60deg); }
        66% { transform: translate(-30px, -15px) rotate(120deg); }
    }
    
    /* ===== FORM ELEMENTS ===== */
    
    .input-field {
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
        padding: 12px 16px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        width: 100%;
    }
    
    .input-field:focus {
        border-color: #edecf0ff;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
        background: white;
        outline: none;
    }
    
    /* Progress steps */
    .step-progress {
        height: 4px;
        background: #673271ff;
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    
    .step-fill {
        height: 100%;
        background: linear-gradient(to right, #8b5cf6, #6366f1);
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.3);
        border: none;
        cursor: pointer;
        width: 100%;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
    }
    
    .btn-secondary {
        background: rgba(190, 31, 176, 0.9);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-secondary:hover {
        background: rgba(190, 31, 176, 1);
        border-color: #d1d5db;
    }
    
    /* Role cards */
    .role-card {
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        margin-bottom: 1rem;
    }
    
    .role-card:hover {
        transform: translateY(-4px);
        border-color: #8b5cf6;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .role-card.active {
        border-color: #8b5cf6;
        background: rgba(139, 92, 246, 0.05);
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);
    }
    
    /* Logo styling */
    .logo-container {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .logo-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.3);
    }
    
    .logo-icon img {
        width: 70%;
        height: 70%;
        object-fit: contain;
    }
    
    /* Form spacing */
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    /* Footer */
    .auth-footer {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
        text-align: center;
        font-size: 0.875rem;
        color: #6b7280;
    }
</style>
<body class="gradient-bg">
    <!-- Animated Background Shapes -->
    <!-- Animated Background Particles -->
    <div id="particles-container"></div>

    <!-- Floating Shapes (Decoration) -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-purple-300/20 rounded-full blur-3xl blob-animation"></div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-pink-300/20 rounded-full blur-3xl blob-animation" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-80 h-80 bg-blue-300/20 rounded-full blur-3xl blob-animation" style="animation-delay: 4s;"></div>
        <div class="absolute bottom-1/3 right-1/3 w-72 h-72 bg-teal-300/20 rounded-full blur-3xl blob-animation" style="animation-delay: 6s;"></div>
    </div>

        <!-- MAIN TWO-SIDE LAYOUT -->
    <div class="min-h-screen flex">
        <!-- LEFT SIDE IMAGE - Now shows on tablets and up -->
        <div class="left-side">
            <img src="{{ asset('images/side.webp') }}" alt="WorkNest" class="w-full h-full object-cover">
        </div>

        <!-- RIGHT SIDE AUTH CARD -->
        <div class="right-side relative z-10">
            <div class="right-side-content">
                <div class="auth-card">
                    <!-- Logo -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-extrabold text-white">WorkNest</h1>
                        <p class="text-gray-200 text-sm mt-1">Freelance Marketplace</p>
                    </div>

                    <!-- Dynamic Form Content -->
                    @yield('content')

                    <!-- Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-300/30 text-center">
                        <p class="text-sm text-gray-200">
                            © {{ date('Y') }} WorkNest — All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Background Particle System Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('particles-container');
        const particleCount = 30;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Random size and position
            const size = Math.random() * 100 + 20;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
            
            // Random color with opacity
            const colors = [
                'rgba(255, 255, 255, 0.1)',
                'rgba(255, 255, 255, 0.05)',
                'rgba(255, 255, 255, 0.15)'
            ];
            particle.style.background = colors[Math.floor(Math.random() * colors.length)];
            
            // Animation
            particle.style.animation = `float ${Math.random() * 10 + 10}s ease-in-out infinite`;
            particle.style.animationDelay = `${Math.random() * 5}s`;
            
            container.appendChild(particle);
        }
        
        // Add hover effect to card (updated selector)
        const card = document.querySelector('.thin-wrapper');
        if (card) {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'scale(1.01)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'scale(1)';
            });
        }
    });
    </script>

    @stack('scripts')
</body>
</html>
