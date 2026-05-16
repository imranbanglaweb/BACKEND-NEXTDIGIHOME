 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <title>Transport and Vehicle  Management System</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <style>
    body {
        background-color: #f4f6f9;
        font-family: "Open Sans", sans-serif;
        color: #2b3e51;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('public/admin_resource/assets/images/bg-login.png');
        background-size: cover;
        background-position: center center;
        min-height: 110vh;
        display: flex;
        align-items: center;
        justify-content: center;
        /* position:fixed */
    }

    .system-name {
        text-align: center;
        color: #fff;
        margin-bottom: 2rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .system-name h2 {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .system-name p {
        font-size: 1rem;
        opacity: 0.9;
    }

    #login-form-wrap {
        background-color: rgba(255, 255, 255, 0.95);
        width: 400px;
        margin: 0 auto;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-header img {
        width: 80px;
        margin-bottom: 1rem;
    }

    .login-header h4 {
        color: #2c3e50;
        font-size: 1.5rem;
        font-weight: 600;
    }

    #login-form {
        padding: 0 1rem;
    }

    .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-control {
        height: 45px;
        padding-left: 45px;
        border: 1px solid #dce4ec;
        border-radius: 5px;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .form-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #95a5a6;
    }

    .btn-login {
        background: #3498db;
        border: none;
        color: #fff;
        padding: 12px 0;
        font-size: 1rem;
        font-weight: 600;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background: #2980b9;
    }

    .invalid-feedback {
        font-size: 0.85rem;
    }

    @media (max-width: 576px) {
        #login-form-wrap {
            width: 90%;
            margin: 0 15px;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #login-form-wrap {
        animation: fadeIn 0.5s ease-out;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="system-name">
            <!-- <h2>Vehicle Management System</h2>
            <p>Total Vehicle Solution</p> -->
        </div>
        
        <div id="login-form-wrap">
            <div class="login-header">
                <img src="{{ asset('public/admin_resource/assets/images/vault-logo.webp') }}" alt="Logo">
                <h4>Login</h4>
            </div>

            <form id="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <i class="fa fa-user"></i>
                    <input type="text" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Enter Employee ID" 
                           required 
                           autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder="Enter Password" 
                           required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-login">
                        <i class="fa fa-sign-in-alt mr-2"></i>Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
