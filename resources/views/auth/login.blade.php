<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header .icon {
            font-size: 60px;
            color: #667eea;
            margin-bottom: 15px;
            display: block;
        }
        
        .login-header h3 {
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }
        
        .input-group-custom {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }
        
        .input-group-custom i:first-child {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 2;
            pointer-events: none;
            font-size: 18px;
        }
        
        .input-group-custom input {
            width: 100%;
            padding: 12px 50px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
            color: #333;
            height: 50px;
            outline: none;
            position: relative;
            z-index: 1;
        }
        
        .input-group-custom input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .input-group-custom input::placeholder {
            color: #aaa;
        }
        
        .input-group-custom input:hover {
            border-color: #667eea;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            z-index: 3;
            font-size: 18px;
            padding: 8px;
            transition: color 0.3s;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }
        
        .password-toggle:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }
        
        .password-toggle:active {
            transform: translateY(-50%) scale(0.95);
        }
        
        .password-toggle i {
            pointer-events: none;
            font-size: 20px;
            line-height: 1;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-check-input {
            cursor: pointer;
            width: 18px;
            height: 18px;
            margin-top: 0;
        }
        
        .form-check-label {
            cursor: pointer;
            font-size: 14px;
            color: #555;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 50px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a6fd6 0%, #6a3f8f 100%);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login i {
            font-size: 18px;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        
        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            cursor: pointer;
        }
        
        .login-footer a:hover {
            color: #5a6fd6;
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert i {
            font-size: 18px;
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 25px 20px;
            }
            
            .login-header .icon {
                font-size: 45px;
            }
            
            .login-header h3 {
                font-size: 22px;
            }
        }
        
        .input-group-custom input:focus-visible {
            outline: 2px solid #667eea;
            outline-offset: -2px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <span class="icon">
                    <i class="bi bi-mortarboard"></i>
                </span>
                <h3>Welcome Back!</h3>
                <p>Sign in to access your dashboard</p>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            placeholder="Enter your email"
                            autocomplete="email"
                        >
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required
                            placeholder="Enter your password"
                            autocomplete="current-password"
                        >
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> 
                    Sign In
                </button>
            </form>
            
            <div class="login-footer">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (togglePassword && password) {
                togglePassword.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const type = password.type === 'password' ? 'text' : 'password';
                    password.type = type;
                    
                    if (eyeIcon) {
                        eyeIcon.classList.toggle('bi-eye');
                        eyeIcon.classList.toggle('bi-eye-slash');
                    }
                });
            }
        });
    </script>
</body>
</html>