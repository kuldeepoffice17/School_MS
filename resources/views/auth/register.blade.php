<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - School Management System</title>
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
        
        .register-container {
            width: 100%;
            max-width: 520px;
        }
        
        .register-card {
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
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header .icon {
            font-size: 60px;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .register-header h3 {
            font-weight: 700;
            color: #333;
        }
        
        .register-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }
        
        .form-group label .required {
            color: #dc3545;
        }
        
        .input-group-custom {
            position: relative;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 1;
        }
        
        .input-group-custom input,
        .input-group-custom select {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
        }
        
        .input-group-custom select {
            appearance: none;
            cursor: pointer;
        }
        
        .input-group-custom input:focus,
        .input-group-custom select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .input-group-custom .role-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }
        
        .btn-register {
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
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .register-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        
        .register-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .role-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            display: block;
        }
        
        .role-info i {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="icon">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h3>Create Account</h3>
                <p>Register as Student, Teacher, Parent or Accountant</p>
                <div class="alert alert-info mt-3" style="font-size: 13px;">
                    <i class="bi bi-info-circle"></i> 
                    After registration, admin will verify your account. You'll receive access after verification.
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-person"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email Address <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Phone Number <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-telephone"></i>
                        <input type="text" name="phone" value="{{ old('phone') }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Address <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-geo-alt"></i>
                        <input type="text" name="address" value="{{ old('address') }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Register As <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-person-badge"></i>
                        <select name="role" required>
                            <option value="">Select Role</option>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="parent" {{ old('role') == 'parent' ? 'selected' : '' }}>Parent</option>
                            <option value="accountant" {{ old('role') == 'accountant' ? 'selected' : '' }}>Accountant</option>
                        </select>
                        <i class="bi bi-chevron-down role-icon"></i>
                    </div>
                    <small class="role-info">
                        <i class="bi bi-info-circle"></i> 
                        @if(old('role') == 'student')
                            I am a student who wants to access academic records
                        @elseif(old('role') == 'teacher')
                            I am a teacher who wants to manage classes and exams
                        @elseif(old('role') == 'parent')
                            I am a parent who wants to track my child's progress
                        @elseif(old('role') == 'accountant')
                            I am an accountant who wants to manage fee collections
                        @else
                            Select a role to see description
                        @endif
                    </small>
                </div>
                
                <div class="form-group">
                    <label>Password <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Confirm Password <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password_confirmation" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="bi bi-person-plus"></i> Register
                </button>
            </form>
            
            <div class="register-footer">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
        </div>
    </div>

    <script>
        // Update role description when selection changes
        document.querySelector('select[name="role"]').addEventListener('change', function() {
            const roleInfo = document.querySelector('.role-info');
            const role = this.value;
            
            const descriptions = {
                'student': '📚 I am a student who wants to access academic records',
                'teacher': '👨‍🏫 I am a teacher who wants to manage classes and exams',
                'parent': '👨‍👩‍👦 I am a parent who wants to track my child\'s progress',
                'accountant': '💰 I am an accountant who wants to manage fee collections'
            };
            
            roleInfo.innerHTML = '<i class="bi bi-info-circle"></i> ' + (descriptions[role] || 'Select a role to see description');
        });
    </script>
</body>
</html>