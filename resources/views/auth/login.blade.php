<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistem Profesional</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Iconify untuk ikon -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
    
    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #7209b7;
            --accent-color: #4cc9f0;
            --text-primary: #2b2d42;
            --text-secondary: #6c757d;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --border-color: #e9ecef;
            --success-color: #06d6a0;
            --error-color: #ef476f;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            background-color: var(--light-bg);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.5;
        }

        .login-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: row;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            background-color: var(--white);
            min-height: 700px;
        }

        .login-illustration {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .login-illustration::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -100px;
            right: -100px;
        }

        .login-illustration::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            bottom: -50px;
            left: -50px;
        }

        .illustration-content {
            position: relative;
            z-index: 2;
            max-width: 500px;
            text-align: center;
        }

        .illustration-icon {
            font-size: 120px;
            margin-bottom: 30px;
            display: block;
            opacity: 0.9;
        }

        .illustration-content h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .illustration-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
            margin-bottom: 30px;
        }

        .features-list {
            text-align: left;
            margin-top: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .feature-item iconify-icon {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .login-form-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: var(--white);
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .login-header p {
            color: var(--text-secondary);
            font-size: 1.05rem;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.2rem;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            background-color: var(--white);
            color: var(--text-primary);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0;
            z-index: 2;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox-container input {
            margin-right: 8px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary-color);
        }

        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
            margin-bottom: 24px;
        }

        .btn-login:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--border-color);
        }

        .divider span {
            padding: 0 15px;
        }

        .social-login {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-sm);
            background-color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            color: var(--text-primary);
        }

        .social-btn:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .social-btn iconify-icon {
            font-size: 1.2rem;
        }

        .btn-google {
            color: #DB4437;
        }

        .btn-microsoft {
            color: #00A4EF;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-secondary);
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Alert Styles */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideIn 0.3s ease;
        }

        .alert-success {
            background-color: rgba(6, 214, 160, 0.1);
            color: #055a45;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: rgba(239, 71, 111, 0.1);
            color: #b71540;
            border-left: 4px solid var(--error-color);
        }

        .alert-warning {
            background-color: rgba(255, 209, 102, 0.1);
            color: #8d6e00;
            border-left: 4px solid var(--warning-color);
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: 1.2rem;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Validation Error Styles */
        .invalid-feedback {
            display: block;
            margin-top: 5px;
            font-size: 0.85rem;
            color: var(--error-color);
            display: flex;
            align-items: center;
        }

        .invalid-feedback iconify-icon {
            margin-right: 5px;
            font-size: 1rem;
        }

        /* Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                max-width: 600px;
                min-height: auto;
            }
            
            .login-illustration {
                padding: 40px 30px;
            }
            
            .illustration-icon {
                font-size: 80px;
            }
            
            .illustration-content h2 {
                font-size: 1.8rem;
            }
            
            .login-form-section {
                padding: 40px 30px;
            }
        }

        @media (max-width: 576px) {
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .social-login {
                flex-direction: column;
            }
            
            .login-illustration {
                padding: 30px 20px;
            }
            
            .login-form-section {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 1.8rem;
            }
        }

        /* Loading animation for button */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Bagian Ilustrasi -->
        <div class="login-illustration">
            <div class="illustration-content">
                <iconify-icon icon="carbon:security" class="illustration-icon"></iconify-icon>
                <h2>Akses Sistem yang Aman</h2>
                <p>Masuk ke dashboard profesional Anda dengan aman dan mudah. Kelola semua kebutuhan Anda di satu tempat.</p>
                
                <div class="features-list">
                    <div class="feature-item">
                        <iconify-icon icon="carbon:checkmark-filled"></iconify-icon>
                        <span>Autentikasi yang aman dan terenkripsi</span>
                    </div>
                    <div class="feature-item">
                        <iconify-icon icon="carbon:checkmark-filled"></iconify-icon>
                        <span>Antarmuka yang intuitif dan mudah digunakan</span>
                    </div>
                    <div class="feature-item">
                        <iconify-icon icon="carbon:checkmark-filled"></iconify-icon>
                        <span>Dukungan pelanggan 24/7</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bagian Form Login -->
        <div class="login-form-section">
            <div class="login-header">
                <h1>Selamat Datang Kembali</h1>
                <p>Silakan masuk ke akun Anda untuk melanjutkan</p>
            </div>
            
            <div class="form-container">
                <!-- Alert Success -->
                @if(session('success'))
                    <div class="alert alert-success" id="successAlert">
                        <div>
                            <iconify-icon icon="carbon:checkmark-filled" style="margin-right: 8px;"></iconify-icon>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button class="alert-close" onclick="closeAlert('successAlert')">
                            <iconify-icon icon="carbon:close"></iconify-icon>
                        </button>
                    </div>
                @endif

                <!-- Alert Error -->
                @if(session('error'))
                    <div class="alert alert-danger" id="errorAlert">
                        <div>
                            <iconify-icon icon="carbon:warning-filled" style="margin-right: 8px;"></iconify-icon>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button class="alert-close" onclick="closeAlert('errorAlert')">
                            <iconify-icon icon="carbon:close"></iconify-icon>
                        </button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('store.login') }}" id="loginForm">
    @csrf

                    
                    <!-- Email Input -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <div class="input-with-icon">
                            <iconify-icon icon="carbon:email" class="input-icon"></iconify-icon>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="nama@perusahaan.com"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                <iconify-icon icon="carbon:warning"></iconify-icon>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Password Input -->
                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label" for="password">Password</label>
                            <a href="#" class="forgot-link">Lupa password?</a>
                        </div>
                        <div class="input-with-icon">
                            <iconify-icon icon="carbon:password" class="input-icon"></iconify-icon>
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Masukkan password Anda"
                                required
                            >
                            <button type="button" class="password-toggle" id="togglePassword">
                                <iconify-icon icon="carbon:view" id="eyeIcon"></iconify-icon>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                <iconify-icon icon="carbon:warning"></iconify-icon>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="remember-forgot">
                        <div class="checkbox-container">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ingat saya</label>
                        </div>
                    </div>
                    
                    <!-- Login Button -->
                    <button type="submit" class="btn-login" id="loginBtn">
                        <iconify-icon icon="carbon:login" style="margin-right: 8px;"></iconify-icon>
                        Masuk ke Akun
                    </button>
                    
                    <!-- Divider -->
                    <div class="divider">
                        <span>atau lanjutkan dengan</span>
                    </div>
                    
                    <!-- Social Login -->
                    <div class="social-login">
                        <button type="button" class="social-btn btn-google" onclick="socialLogin('google')">
                            <iconify-icon icon="carbon:logo-google"></iconify-icon>
                            Google
                        </button>
                        <button type="button" class="social-btn btn-microsoft" onclick="socialLogin('microsoft')">
                            <iconify-icon icon="carbon:logo-microsoft"></iconify-icon>
                            Microsoft
                        </button>
                    </div>
                    
                    <!-- Register Link -->
                    <div class="register-link">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                if (type === 'password') {
                    eyeIcon.setAttribute('icon', 'carbon:view');
                } else {
                    eyeIcon.setAttribute('icon', 'carbon:view-off');
                }
            });
        }
        
        // Form submission
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                // Basic client-side validation
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                
                if (!email || !password) {
                    e.preventDefault();
                    showCustomError('Harap isi semua field yang diperlukan.');
                    return;
                }
                
                // Show loading state
                if (loginBtn) {
                    loginBtn.classList.add('btn-loading');
                    loginBtn.disabled = true;
                }
                
                // Form will submit normally after validation
            });
        }
        
        
        // Email validation function
        function validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
        
        // Show custom error alert
        function showCustomError(message) {
            // Remove existing custom alert
            const existingAlert = document.getElementById('customErrorAlert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            // Create new alert
            const alertDiv = document.createElement('div');
            alertDiv.id = 'customErrorAlert';
            alertDiv.className = 'alert alert-danger';
            alertDiv.innerHTML = `
                <div>
                    <iconify-icon icon="carbon:warning-filled" style="margin-right: 8px;"></iconify-icon>
                    <span>${message}</span>
                </div>
                <button class="alert-close" onclick="closeAlert('customErrorAlert')">
                    <iconify-icon icon="carbon:close"></iconify-icon>
                </button>
            `;
            
            // Insert after form container
            const formContainer = document.querySelector('.form-container');
            if (formContainer) {
                formContainer.insertBefore(alertDiv, formContainer.firstChild);
            }
        }
        
        // Close alert
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }
        
        // Social login function
        function socialLogin(provider) {
            showCustomError(`Login dengan ${provider.charAt(0).toUpperCase() + provider.slice(1)} sedang dalam pengembangan.`);
        }
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    closeAlert(alert.id);
                }, 5000);
            });
            
            // Demo credentials auto-fill for testing (remove in production)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('demo') === 'true') {
                document.getElementById('email').value = 'admin@example.com';
                document.getElementById('password').value = 'password123';
                document.getElementById('remember').checked = true;
            }
        });
    </script>
</body>
</html>