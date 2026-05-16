<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Next Digi Home - Premium Digital Products Marketplace</title>
    @php
        $settings = \Illuminate\Support\Facades\DB::table('settings')->where('id', 1)->first();
    @endphp
    @if(!empty($settings->favicon))
        <link rel="shortcut icon" type="image/png" href="{{ asset('public/admin_resource/assets/images/'.$settings->favicon) }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin_resource/assets/images/'.$settings->favicon) }}">
    @else
        <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Bootstrap + FontAwesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: "Open Sans", sans-serif;
            overflow: hidden;
            background: #f4f6f9;
        }

        .login-wrapper {
            display: flex;
            height: 100vh;
        }

        /* LEFT PANEL */
        .login-left {
            width: 38%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            box-shadow: 5px 0 20px rgba(0,0,0,0.1);
            z-index: 10;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
            text-align: center;
        }

        .login-box .logo-container {
            margin-bottom: 25px;
        }

        .login-box .logo {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #00d4aa 0%, #8b5cf6 100%);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 212, 170, 0.3);
        }

        .login-box .logo i {
            font-size: 32px;
            color: #fff;
        }

        .login-box .brand-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            line-height: 1.3;
        }

        .login-box .brand-tagline {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .login-box h5 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #2b3e51;
        }

        .form-control {
            height: 45px;
            border-radius: 5px;
            font-size: 0.95rem;
            padding-left: 40px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #999;
        }

        .btn-login {
            background: linear-gradient(135deg, #00d4aa 0%, #8b5cf6 100%);
            color: #fff;
            font-weight: 600;
            width: 100%;
            padding: 12px 0;
            border-radius: 8px;
            border: none;
            transition: .3s;
            font-size: 1rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #00b894 0%, #7c3aed 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 212, 170, 0.4);
        }

        /* RIGHT PANEL - DIGITAL PRODUCTS THEME */
        .login-right {
            flex: 1;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0f0f12 0%, #1a1a1f 50%, #0f0f12 100%);
        }

        .digital-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        /* FLOATING CODE SNIPPETS */
        .code-snippet {
            position: absolute;
            background: rgba(0, 212, 170, 0.1);
            border: 1px solid rgba(0, 212, 170, 0.3);
            border-radius: 8px;
            padding: 12px 16px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #00d4aa;
            backdrop-filter: blur(10px);
            animation: floatCode 6s ease-in-out infinite;
        }

        .code-snippet::before {
            content: '</>';
            position: absolute;
            top: -8px;
            right: -8px;
            background: #8b5cf6;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }

        .code-snippet:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        .code-snippet:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        .code-snippet:nth-child(3) {
            top: 40%;
            left: 70%;
            animation-delay: 4s;
        }

        /* FLOATING DESIGN TOOLS */
        .design-tool {
            position: absolute;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(0, 212, 170, 0.2));
            border: 2px solid rgba(139, 92, 246, 0.4);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #8b5cf6;
            backdrop-filter: blur(10px);
            animation: floatTool 8s ease-in-out infinite;
            box-shadow: 0 8px 32px rgba(139, 92, 246, 0.3);
        }

        .design-tool:nth-child(4) {
            top: 30%;
            right: 20%;
            animation-delay: 1s;
        }
        .design-tool:nth-child(5) {
            bottom: 25%;
            left: 20%;
            animation-delay: 3s;
        }
        .design-tool:nth-child(6) {
            top: 70%;
            left: 60%;
            animation-delay: 5s;
        }

        /* FLOATING PRODUCT ICONS */
        .product-icon {
            position: absolute;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.2), rgba(139, 92, 246, 0.2));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #00d4aa;
            backdrop-filter: blur(10px);
            animation: floatProduct 7s ease-in-out infinite;
            box-shadow: 0 6px 24px rgba(0, 212, 170, 0.3);
        }

        .product-icon:nth-child(7) {
            top: 50%;
            left: 5%;
            animation-delay: 0.5s;
        }
        .product-icon:nth-child(8) {
            top: 15%;
            right: 5%;
            animation-delay: 2.5s;
        }
        .product-icon:nth-child(9) {
            bottom: 35%;
            right: 40%;
            animation-delay: 4.5s;
        }

        /* DIGITAL GLOW EFFECT */
        .digital-glow {
            position: absolute;
            top: 40%;
            left: 30%;
            width: 400px;
            height: 200px;
            background: radial-gradient(circle, rgba(0, 212, 170, 0.3) 0%, rgba(139, 92, 246, 0.2) 50%, transparent 100%);
            border-radius: 50%;
            animation: pulseGlow 4s ease-in-out infinite;
            filter: blur(20px);
            z-index: 10;
            opacity: 0.8;
        }

        /* COMPANY TITLE + TAGLINE */
        .system-text {
            position: absolute;
            top: 15%;
            left: 50px;
            z-index: 20;
            color: #fff;
            text-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        .system-text h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #00d4aa, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .system-text p {
            font-size: 20px;
            opacity: .9;
            color: #00d4aa;
            font-weight: 300;
        }

        /* ANIMATIONS */
        @keyframes floatCode {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.7;
            }
            25% {
                transform: translateY(-20px) rotate(2deg);
                opacity: 1;
            }
            50% {
                transform: translateY(-10px) rotate(-1deg);
                opacity: 0.8;
            }
            75% {
                transform: translateY(-25px) rotate(1deg);
                opacity: 0.9;
            }
        }

        @keyframes floatTool {
            0%, 100% {
                transform: translateY(0px) scale(1) rotate(0deg);
            }
            33% {
                transform: translateY(-15px) scale(1.1) rotate(5deg);
            }
            66% {
                transform: translateY(-8px) scale(0.95) rotate(-3deg);
            }
        }

        @keyframes floatProduct {
            0%, 100% {
                transform: translateY(0px) translateX(0px);
                opacity: 0.6;
            }
            25% {
                transform: translateY(-12px) translateX(5px);
                opacity: 1;
            }
            50% {
                transform: translateY(-6px) translateX(-3px);
                opacity: 0.8;
            }
            75% {
                transform: translateY(-18px) translateX(2px);
                opacity: 0.9;
            }
        }

        @keyframes cloudMove {
            0% { transform: translateX(100vw); }
            100% { transform: translateX(-200px); }
        }

        @keyframes particleFloat {
            0%, 100% { transform: translateY(0px) scale(1); opacity: 0.5; }
            50% { transform: translateY(-10px) scale(1.2); opacity: 1; }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        }

        @media(max-width: 1024px) {
            .login-left {
                width: 100%;
                box-shadow: none;
                padding: 30px 20px;
            }
            .login-right {
                display: none;
            }

            .system-text h1 {
                font-size: 32px;
            }

            .system-text p {
                font-size: 16px;
            }

            .login-box {
                max-width: 100%;
            }
        }

        @media(max-width: 768px) {
            .login-wrapper {
                height: auto;
                min-height: 100vh;
            }

            .login-left {
                padding: 20px 15px;
                min-height: auto;
            }

            .login-box {
                padding: 20px 15px;
            }

            .login-box .logo {
                width: 60px;
                height: 60px;
            }

            .login-box .logo i {
                font-size: 28px;
            }

            .login-box .brand-title {
                font-size: 20px;
            }

            .login-box .brand-tagline {
                font-size: 13px;
            }

            .login-box h5 {
                font-size: 18px;
                margin-bottom: 20px;
            }

            .form-control {
                height: 42px;
                font-size: 16px;
                padding-left: 35px;
            }

            .input-icon {
                font-size: 18px;
                left: 12px;
            }

            .btn-login {
                padding: 14px 0;
                font-size: 16px;
            }

            .system-text {
                top: 10%;
                left: 20px;
            }

            .system-text h1 {
                font-size: 24px;
            }

            .system-text p {
                font-size: 14px;
            }

            .road-container {
                height: 50%;
            }
        }

        @media(max-width: 480px) {
            .login-box {
                padding: 15px 10px;
            }

            .login-box .logo {
                width: 50px;
                height: 50px;
            }

            .login-box .logo i {
                font-size: 24px;
            }

            .login-box h5 {
                font-size: 16px;
            }

            .login-box .form-group {
                margin-bottom: 15px;
            }

            .btn-login {
                padding: 14px 20px;
                min-height: 48px;
            }

            .system-text {
                left: 10px;
            }

            .system-text h1 {
                font-size: 20px;
            }

            .system-text p {
                font-size: 12px;
            }

            .cloud {
                width: 80px;
                height: 30px;
            }

            .car-container {
                width: 200px;
                height: 90px;
                bottom: 25%;
            }

            .car-body {
                border-radius: 10px 10px 4px 4px;
            }

            .car-window {
                width: 35%;
                height: 25px;
            }

            .car-wheel {
                width: 28px;
                height: 28px;
                bottom: -12px;
            }
        }

        /* Mobile Touch Optimizations */
        @media (max-width: 768px) {
            input[type="text"],
            input[type="password"] {
                font-size: 16px;
            }

            .btn-login {
                min-height: 48px;
                padding: 14px 20px;
            }

            .form-control {
                min-height: 44px;
            }

            .login-box .form-group {
                margin-bottom: 16px;
            }

            .login-box .form-group:last-of-type {
                margin-bottom: 20px;
            }
        }

        /* Orientation change handling */
        @media (max-height: 500px) and (orientation: landscape) {
            .login-wrapper {
                height: auto;
                min-height: 100vh;
            }

            .login-left {
                height: auto;
                min-height: 100vh;
                padding: 40px 20px;
            }

            .login-right {
                display: none;
            }

            .system-text {
                display: none;
            }
        }

        /* High resolution displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .login-box .logo {
                box-shadow: 0 8px 20px rgba(0, 212, 170, 0.3);
            }

            .btn-login {
                box-shadow: 0 4px 12px rgba(0, 212, 170, 0.4);
            }
        }

        /* Reduced motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            .road-surface,
            .car-container,
            .car-wheel,
            .tree,
            .lamp-post,
            .cloud,
            .code-snippet,
            .design-tool,
            .product-icon,
            .digital-glow {
                animation: none !important;
            }

            .car-body,
            .btn-login:hover {
                transform: none !important;
                transition: none !important;
            }
        }
    </style>
</head>

<body>
    <?php
    $settings = DB::table('settings')->where('id', 1)->first();
    $logoUrl = null;
    if ($settings && $settings->site_logo) {
        $logoUrl = asset('public/admin_resource/assets/images/' . $settings->site_logo);
    } elseif ($settings && $settings->admin_logo) {
        $logoUrl = asset('public/admin_resource/assets/images/' . $settings->admin_logo);
    }
    ?>

    <div class="login-wrapper">
        <!-- LEFT SIDE LOGIN -->
        <div class="login-left">
            <div class="login-box">
                <div class="logo-container">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="Logo" class="site-logo" style="width: 250px; object-fit: contain; margin: 0 auto; border-radius: 8px;">
                    @else
                        <div class="logo">
                            <i class="fas fa-rocket"></i>
                        </div>
                    @endif
                    <h1 class="brand-title">Next Digi Home</h1>
                    <p class="brand-tagline">Premium Digital Products Marketplace</p>
                </div>

                <h5>Login to your account</h5>
                <hr>

                <div class="login-form">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter Email"
                                   required autofocus
                                   autocapitalize="off"
                                   autocomplete="username"
                                   inputmode="text">
                            @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                        <div class="form-group position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter Password"
                                   required
                                   autocomplete="current-password"
                                   inputmode="text">
                            @error('password') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE WITH DIGITAL PRODUCTS THEME -->
        <div class="login-right">
            <!-- SKY -->
            <div class="sky">
                <div class="cloud"></div>
                <div class="cloud"></div>
                <div class="cloud"></div>
            </div>

            <!-- DIGITAL CONTAINER -->
            <div class="digital-container">
                <!-- FLOATING ELEMENTS -->
                <div class="floating-elements">
                    <div class="code-snippet">
                        <div>const products = [<br/>&nbsp;&nbsp;'templates',<br/>&nbsp;&nbsp;'tools',<br/>&nbsp;&nbsp;'resources'<br/>];</div>
                    </div>
                    <div class="code-snippet">
                        <div>function innovate() {<br/>&nbsp;&nbsp;return 'success';<br/>}</div>
                    </div>
                    <div class="code-snippet">
                        <div>digitalProducts.map(<br/>&nbsp;&nbsp;product => product)</div>
                    </div>

                    <div class="design-tool">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="design-tool">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="design-tool">
                        <i class="fas fa-mobile-alt"></i>
                    </div>

                    <div class="product-icon">
                        <i class="fas fa-file-code"></i>
                    </div>
                    <div class="product-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="product-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>

                <!-- DIGITAL GLOW -->
                <div class="digital-glow"></div>
            </div>

            <!-- COMPANY TEXT -->
            <div class="system-text">
                <h1>Next Digi Home</h1>
                <p>Premium Digital Products Marketplace</p>
            </div>
        </div>
    </div>
</body>
</html>