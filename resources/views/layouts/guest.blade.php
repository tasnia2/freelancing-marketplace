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
        :root{
            /* YOUR BRAND BUTTON COLORS */
            --blue-1: #1B3C53;
            --blue-2: #3f83b7ff;

            --glass: rgba(255,255,255,.12);
            --glass-border: rgba(255,255,255,.18);
            --shadow: 0 25px 70px rgba(0,0,0,.45);
        }

        body{
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            background: #020617; /* fallback only */
            overflow-x: hidden;
        }

        /* ===== VIDEO BACKGROUND (NO OVERLAY) ===== */
        .video-bg{
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            background: #020617;
        }

        .video-bg video{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Mobile fallback */
        @media (max-width: 768px){
            .video-bg video{ display:none; }
            .video-bg{
                background: url("{{ asset('images/side.webp') }}") center / cover no-repeat;
            }
        }

        /* ===== MAIN WRAPPER ===== */
        .page{
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .shell{
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
            align-items: center;
        }
        .brand-chips{
    margin-top: 22px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.brand-chip{
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 999px;
    background: rgba(255,255,255,.10);
    border: 1px solid rgba(255,255,255,.18);
    color: rgba(255,255,255,.85);
    font-size: .88rem;
    backdrop-filter: blur(6px);
}

.brand-chip i{
    color: rgba(255,255,255,.95);
    font-size: .85rem;
}


        @media (min-width: 1024px){
            .shell{
                grid-template-columns: 1.1fr .9fr;
                gap: 64px;
            }
        }

        /* ===== LEFT BRAND ===== */
        .brand{
            display: none;
            color: #fff;
        }

        @media (min-width: 1024px){
            .brand{ display:block; }
        }

        .brand h1{
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.05;
        }

        .brand p{
            margin-top: 14px;
            max-width: 520px;
            font-size: 1.05rem;
            opacity: .85;
        }

        /* ===== AUTH CARD ===== */
        .auth-wrap{
            display: flex;
            justify-content: center;
        }

        .auth-card{
            width: 100%;
            max-width: 440px;
            background: var(--glass);
            backdrop-filter: blur(18px);
            border: 1px solid var(--glass-border);
            border-radius: 22px;
            padding: 40px 32px;
            box-shadow: var(--shadow);
        }

        /* ===== LOGO ===== */
        .logo{
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-badge{
            width: 52px;
            height: 52px;
            border-radius: 14px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--blue-1), var(--blue-2));
        }

        .logo-badge i{
            color: #fff;
            font-size: 20px;
        }

        .logo h2{
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
        }

        .logo p{
            font-size: .9rem;
            opacity: .75;
        }

        /* ===== FORM ELEMENTS ===== */
        .input-field{
            width: 100%;
            background: rgba(255,255,255,.95);
            border-radius: 14px;
            padding: 14px 18px;
            border: none;
            font-size: 15px;
        }

        .input-field:focus{
            outline: none;
            box-shadow: 0 0 0 3px rgba(69,104,130,.4);
        }

        .btn-primary{
            width: 100%;
            border: none;
            cursor: pointer;
            border-radius: 14px;
            padding: 14px 16px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--blue-1), var(--blue-2));
        }

        .btn-primary:hover{
            filter: brightness(1.05);
        }

        .role-card{
            border-radius: 14px;
            padding: 14px;
            border: 1px solid rgba(255,255,255,.18);
            cursor: pointer;
        }

        .role-card:hover{
            background: rgba(255,255,255,.06);
        }

        .card-footer{
            margin-top: 26px;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,.15);
            text-align: center;
            font-size: .85rem;
            opacity: .7;
        }
    </style>
</head>
<script>
    // Check if page loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded successfully');
    });
    
    window.addEventListener('load', function() {
        console.log('All resources loaded');
        // Hide any loading spinners if you have them
    });
</script>
<body>

    <!-- VIDEO BACKGROUND -->
    <div class="video-bg">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('images/bgg.mp4') }}" type="video/mp4">
        </video>
    </div>

    <!-- MAIN CONTENT -->
    <div class="page">
        <div class="shell">

            <!-- LEFT BRAND -->
            <section class="brand">
                <h1>
                    Where Skills<br>
                    Meet Opportunity
                </h1>
                <p>
                    WorkNest connects freelancers and clients worldwide.
                </p>
                <div class="brand-chips">
    <span class="brand-chip">
        <i class="fa-solid fa-shield-halved"></i>
        Trusted Payments
    </span>

    <span class="brand-chip">
        <i class="fa-solid fa-badge-check"></i>
        Verified Talent
    </span>

    <span class="brand-chip">
        <i class="fa-solid fa-globe"></i>
        Global Reach
    </span>
</div>

            </section>

            <!-- AUTH CARD -->
            <section class="auth-wrap">
                <div class="auth-card">
                    <div class="logo">
                        <div class="logo-badge">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h2>WorkNest</h2>
                        <p>Freelance Marketplace</p>
                    </div>

                    @yield('content')

                    <div class="card-footer">
                        © {{ date('Y') }} WorkNest — All Rights Reserved
                    </div>
                </div>
            </section>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
