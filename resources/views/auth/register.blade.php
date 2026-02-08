<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi | Buat Akun Baru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Iconify -->
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
            --success-color: #06d6a0;
            --error-color: #ef476f;
            --warning-color: #ffd166;
            --text-primary: #2b2d42;
            --text-secondary: #6c757d;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --border-color: #e9ecef;
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
        
        .register-container {
            width: 100%;
            max-width: 1300px;
            display: flex;
            flex-direction: row;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            background-color: var(--white);
            min-height: 750px;
        }
        
        .register-illustration {
            flex: 1.2;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .register-illustration::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -150px;
            right: -150px;
        }
        
        .register-illustration::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            bottom: -80px;
            left: -80px;
        }
        
        .illustration-content {
            position: relative;
            z-index: 2;
            max-width: 550px;
            text-align: center;
        }
        
        .illustration-icon {
            font-size: 130px;
            margin-bottom: 30px;
            display: block;
            opacity: 0.9;
        }
        
        .illustration-content h2 {
            font-size: 2.4rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .illustration-content p {
            font-size: 1.15rem;
            opacity: 0.9;
            font-weight: 300;
            margin-bottom: 30px;
        }
        
        .benefits-list {
            text-align: left;
            margin-top: 40px;
            width: 100%;
        }
        
        .benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            font-size: 1rem;
        }
        
        .benefit-item iconify-icon {
            margin-right: 15px;
            font-size: 1.4rem;
            flex-shrink: 0;
            margin-top: 2px;
        }
        
        .register-form-section {
            flex: 1.5;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: var(--white);
            overflow-y: auto;
            max-height: 750px;
        }
        
        .register-header {
            margin-bottom: 40px;
        }
        
        .register-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
        }
        
        .register-header p {
            color: var(--text-secondary);
            font-size: 1.05rem;
        }
        
        .form-container {
            width: 100%;
            max-width: 450px;
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
        
        .password-strength {
            margin-top: 8px;
            height: 6px;
            border-radius: 3px;
            background-color: #e9ecef;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 3px;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        
        .password-strength-text {
            font-size: 0.8rem;
            margin-top: 5px;
            color: var(--text-secondary);
        }
        
        .requirements-list {
            margin-top: 8px;
            padding-left: 20px;
        }
        
        .requirement-item {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
        }
        
        .requirement-item iconify-icon {
            font-size: 0.9rem;
            margin-right: 6px;
        }
        
        .requirement-item.met {
            color: var(--success-color);
        }
        
        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .terms-checkbox input {
            margin-right: 12px;
            margin-top: 4px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary-color);
            flex-shrink: 0;
        }
        
        .terms-checkbox label {
            font-size: 0.95rem;
            color: var(--text-secondary);
        }
        
        .terms-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .terms-link:hover {
            text-decoration: underline;
        }
        
        .btn-register {
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
        
        .btn-register:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn-register:active {
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
        
        .social-register {
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
        
        .btn-facebook {
            color: #1877F2;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-secondary);
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
        }
        
        .login-link a:hover {
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
        
        /* Progress Steps */
        .registration-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }
        
        .registration-steps::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--border-color);
            z-index: 1;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--white);
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .step.active .step-circle {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--white);
        }
        
        .step.completed .step-circle {
            background-color: var(--success-color);
            border-color: var(--success-color);
            color: var(--white);
        }
        
        .step-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        .step.active .step-label {
            color: var(--primary-color);
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
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
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
        
        /* Responsive Design */
        @media (max-width: 1100px) {
            .register-container {
                flex-direction: column;
                max-width: 700px;
                min-height: auto;
            }
            
            .register-illustration {
                padding: 40px 30px;
            }
            
            .illustration-icon {
                font-size: 80px;
            }
            
            .illustration-content h2 {
                font-size: 1.8rem;
            }
            
            .register-form-section {
                padding: 40px 30px;
                max-height: none;
            }
        }
        
        @media (max-width: 576px) {
            .registration-steps {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            
            .registration-steps::before {
                display: none;
            }
            
            .step {
                flex-direction: row;
                gap: 12px;
            }
            
            .step-circle {
                margin-bottom: 0;
            }
            
            .social-register {
                flex-direction: column;
            }
            
            .register-illustration {
                padding: 30px 20px;
            }
            
            .register-form-section {
                padding: 30px 20px;
            }
            
            .register-header h1 {
                font-size: 1.8rem;
            }
        }
        
        /* Form Step Transitions */
        .form-step {
            display: none;
            animation: fadeIn 0.4s ease;
        }
        
        .form-step.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Bagian Ilustrasi -->
        <div class="register-illustration">
            <div class="illustration-content">
                <iconify-icon icon="carbon:user-profile" class="illustration-icon"></iconify-icon>
                <h2>Bergabunglah dengan Komunitas Kami</h2>
                <p>Daftar sekarang untuk mendapatkan akses ke fitur-fitur eksklusif dan mulai perjalanan digital Anda bersama kami.</p>
                
                <div class="benefits-list">
                    <div class="benefit-item">
                        <iconify-icon icon="carbon:security"></iconify-icon>
                        <span>Keamanan data terjamin dengan enkripsi tingkat tinggi</span>
                    </div>
                    <div class="benefit-item">
                        <iconify-icon icon="carbon:user-certification"></iconify-icon>
                        <span>Akses ke konten premium dan fasilitas eksklusif</span>
                    </div>
                    <div class="benefit-item">
                        <iconify-icon icon="carbon:chart-line"></iconify-icon>
                        <span>Dashboard analitik untuk memantau perkembangan Anda</span>
                    </div>
                    <div class="benefit-item">
                        <iconify-icon icon="carbon:group"></iconify-icon>
                        <span>Komunitas aktif dengan dukungan 24/7</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bagian Form Registrasi -->
        <div class="register-form-section">
            <div class="register-header">
                <h1>Buat Akun Baru</h1>
                <p>Silakan lengkapi informasi berikut untuk membuat akun Anda</p>
            </div>
            
            <!-- Progress Steps -->
            <div class="registration-steps">
                <div class="step active" id="step1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Informasi Pribadi</div>
                </div>
                <div class="step" id="step2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Keamanan Akun</div>
                </div>
                <div class="step" id="step3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
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
                @if($errors->any() && !$errors->has('step1') && !$errors->has('step2'))
                    <div class="alert alert-danger" id="errorAlert">
                        <div>
                            <iconify-icon icon="carbon:warning-filled" style="margin-right: 8px;"></iconify-icon>
                            <span>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}@if(!$loop->last)<br>@endif
                                @endforeach
                            </span>
                        </div>
                        <button class="alert-close" onclick="closeAlert('errorAlert')">
                            <iconify-icon icon="carbon:close"></iconify-icon>
                        </button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register.process') }}" id="registerForm">
                    @csrf
                    
                    <!-- Step 1: Personal Information -->
                    <div class="form-step active" id="step1Form">
                        <!-- Nama Lengkap -->
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <div class="input-with-icon">
                                <iconify-icon icon="carbon:user" class="input-icon"></iconify-icon>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror" 
                                    placeholder="Masukkan nama lengkap Anda"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                >
                            </div>
                            @error('name')
                                <div class="invalid-feedback">
                                    <iconify-icon icon="carbon:warning"></iconify-icon>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-with-icon">
                                <iconify-icon icon="carbon:email" class="input-icon"></iconify-icon>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="nama@contoh.com"
                                    value="{{ old('email') }}"
                                    required
                                >
                            </div>
                            @error('email')
                                <div class="invalid-feedback">
                                    <iconify-icon icon="carbon:warning"></iconify-icon>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Nomor Telepon -->
                        <div class="form-group">
                            <label class="form-label" for="phone">Nomor Telepon (Opsional)</label>
                            <div class="input-with-icon">
                                <iconify-icon icon="carbon:phone" class="input-icon"></iconify-icon>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    placeholder="+62 812-3456-7890"
                                    value="{{ old('phone') }}"
                                >
                            </div>
                            @error('phone')
                                <div class="invalid-feedback">
                                    <iconify-icon icon="carbon:warning"></iconify-icon>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <div></div> <!-- Spacer -->
                            <button type="button" class="btn-register" onclick="nextStep()">
                                Lanjut
                                <iconify-icon icon="carbon:arrow-right" style="margin-left: 8px;"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Account Security -->
                    <div class="form-step" id="step2Form">
                        <!-- Password -->
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-with-icon">
                                <iconify-icon icon="carbon:password" class="input-icon"></iconify-icon>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Buat password yang kuat"
                                    required
                                >
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <iconify-icon icon="carbon:view" id="eyeIcon"></iconify-icon>
                                </button>
                            </div>
                            <div class="password-strength">
                                <div class="password-strength-bar" id="passwordStrengthBar"></div>
                            </div>
                            <div class="password-strength-text" id="passwordStrengthText"></div>
                            
                            <!-- Password Requirements -->
                            <div class="requirements-list">
                                <div class="requirement-item" id="reqLength">
                                    <iconify-icon icon="carbon:circle-dash"></iconify-icon>
                                    Minimal 8 karakter
                                </div>
                                <div class="requirement-item" id="reqUppercase">
                                    <iconify-icon icon="carbon:circle-dash"></iconify-icon>
                                    Mengandung huruf besar
                                </div>
                                <div class="requirement-item" id="reqLowercase">
                                    <iconify-icon icon="carbon:circle-dash"></iconify-icon>
                                    Mengandung huruf kecil
                                </div>
                                <div class="requirement-item" id="reqNumber">
                                    <iconify-icon icon="carbon:circle-dash"></iconify-icon>
                                    Mengandung angka
                                </div>
                                <div class="requirement-item" id="reqSpecial">
                                    <iconify-icon icon="carbon:circle-dash"></iconify-icon>
                                    Mengandung karakter khusus
                                </div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">
                                    <iconify-icon icon="carbon:warning"></iconify-icon>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <div class="input-with-icon">
                                <iconify-icon icon="carbon:password-check" class="input-icon"></iconify-icon>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                                    placeholder="Ketik ulang password Anda"
                                    required
                                >
                                <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                    <iconify-icon icon="carbon:view" id="eyeConfirmIcon"></iconify-icon>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    <iconify-icon icon="carbon:warning"></iconify-icon>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn-register" style="background-color: var(--text-secondary);" onclick="prevStep()">
                                <iconify-icon icon="carbon:arrow-left" style="margin-right: 8px;"></iconify-icon>
                                Kembali
                            </button>
                            <button type="button" class="btn-register" onclick="nextStep()">
                                Lanjut
                                <iconify-icon icon="carbon:arrow-right" style="margin-left: 8px;"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Confirmation -->
                    <div class="form-step" id="step3Form">
                        <!-- Terms and Conditions -->
                        <div class="terms-checkbox">
                            <input type="checkbox" id="terms" name="terms" value="1" required>
                            <label for="terms">
                                Saya setuju dengan <a href="#" class="terms-link">Syarat & Ketentuan</a> dan <a href="#" class="terms-link">Kebijakan Privasi</a> yang berlaku. Saya memahami bahwa data saya akan diproses sesuai dengan kebijakan tersebut.
                            </label>
                        </div>
                        @error('terms')
                            <div class="invalid-feedback" style="margin-top: -15px; margin-bottom: 15px;">
                                <iconify-icon icon="carbon:warning"></iconify-icon>
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <!-- Newsletter Subscription -->
                        <div class="terms-checkbox mb-4">
                            <input type="checkbox" id="newsletter" name="newsletter" value="1" {{ old('newsletter') ? 'checked' : '' }}>
                            <label for="newsletter">
                                Saya ingin berlangganan newsletter untuk mendapatkan pembaruan, tips, dan penawaran eksklusif.
                            </label>
                        </div>
                        
                        <button type="submit" class="btn-register" id="registerBtn">
                            <iconify-icon icon="carbon:user-profile" style="margin-right: 8px;"></iconify-icon>
                            Buat Akun
                        </button>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn-register" style="background-color: var(--text-secondary);" onclick="prevStep()">
                                <iconify-icon icon="carbon:arrow-left" style="margin-right: 8px;"></iconify-icon>
                                Kembali
                            </button>
                            <div></div> <!-- Spacer -->
                        </div>
                    </div>
                </form>
                
                <!-- Divider -->
                <div class="divider">
                    <span>atau daftar dengan</span>
                </div>
                
                <!-- Social Register -->
                <div class="social-register">
                    <button type="button" class="social-btn btn-google" onclick="socialRegister('google')">
                        <iconify-icon icon="carbon:logo-google"></iconify-icon>
                        Google
                    </button>
                    <button type="button" class="social-btn btn-facebook" onclick="socialRegister('facebook')">
                        <iconify-icon icon="carbon:logo-facebook"></iconify-icon>
                        Facebook
                    </button>
                </div>
                
                <!-- Login Link -->
                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}" id="loginLink">Masuk sekarang</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // State management
        let currentStep = 1;
        const totalSteps = 3;
        
        // DOM Elements
        const stepElements = document.querySelectorAll('.step');
        const formStepElements = document.querySelectorAll('.form-step');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeConfirmIcon = document.getElementById('eyeConfirmIcon');
        const passwordStrengthBar = document.getElementById('passwordStrengthBar');
        const passwordStrengthText = document.getElementById('passwordStrengthText');
        const registerForm = document.getElementById('registerForm');
        const registerBtn = document.getElementById('registerBtn');
        
        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            const requirements = {
                length: false,
                uppercase: false,
                lowercase: false,
                number: false,
                special: false
            };
            
            // Check length
            if (password.length >= 8) {
                strength += 20;
                requirements.length = true;
                document.getElementById('reqLength').classList.add('met');
                document.getElementById('reqLength').querySelector('iconify-icon').setAttribute('icon', 'carbon:checkmark');
            } else {
                document.getElementById('reqLength').classList.remove('met');
                document.getElementById('reqLength').querySelector('iconify-icon').setAttribute('icon', 'carbon:circle-dash');
            }
            
            // Check uppercase
            if (/[A-Z]/.test(password)) {
                strength += 20;
                requirements.uppercase = true;
                document.getElementById('reqUppercase').classList.add('met');
                document.getElementById('reqUppercase').querySelector('iconify-icon').setAttribute('icon', 'carbon:checkmark');
            } else {
                document.getElementById('reqUppercase').classList.remove('met');
                document.getElementById('reqUppercase').querySelector('iconify-icon').setAttribute('icon', 'carbon:circle-dash');
            }
            
            // Check lowercase
            if (/[a-z]/.test(password)) {
                strength += 20;
                requirements.lowercase = true;
                document.getElementById('reqLowercase').classList.add('met');
                document.getElementById('reqLowercase').querySelector('iconify-icon').setAttribute('icon', 'carbon:checkmark');
            } else {
                document.getElementById('reqLowercase').classList.remove('met');
                document.getElementById('reqLowercase').querySelector('iconify-icon').setAttribute('icon', 'carbon:circle-dash');
            }
            
            // Check numbers
            if (/[0-9]/.test(password)) {
                strength += 20;
                requirements.number = true;
                document.getElementById('reqNumber').classList.add('met');
                document.getElementById('reqNumber').querySelector('iconify-icon').setAttribute('icon', 'carbon:checkmark');
            } else {
                document.getElementById('reqNumber').classList.remove('met');
                document.getElementById('reqNumber').querySelector('iconify-icon').setAttribute('icon', 'carbon:circle-dash');
            }
            
            // Check special characters
            if (/[^A-Za-z0-9]/.test(password)) {
                strength += 20;
                requirements.special = true;
                document.getElementById('reqSpecial').classList.add('met');
                document.getElementById('reqSpecial').querySelector('iconify-icon').setAttribute('icon', 'carbon:checkmark');
            } else {
                document.getElementById('reqSpecial').classList.remove('met');
                document.getElementById('reqSpecial').querySelector('iconify-icon').setAttribute('icon', 'carbon:circle-dash');
            }
            
            // Update strength bar
            passwordStrengthBar.style.width = `${strength}%`;
            
            // Update strength text and color
            if (strength <= 20) {
                passwordStrengthBar.style.backgroundColor = '#ef476f'; // Red
                passwordStrengthText.textContent = 'Sangat lemah';
            } else if (strength <= 40) {
                passwordStrengthBar.style.backgroundColor = '#ff9e00'; // Orange
                passwordStrengthText.textContent = 'Lemah';
            } else if (strength <= 60) {
                passwordStrengthBar.style.backgroundColor = '#ffd166'; // Yellow
                passwordStrengthText.textContent = 'Cukup';
            } else if (strength <= 80) {
                passwordStrengthBar.style.backgroundColor = '#06d6a0'; // Green
                passwordStrengthText.textContent = 'Kuat';
            } else {
                passwordStrengthBar.style.backgroundColor = '#118ab2'; // Blue
                passwordStrengthText.textContent = 'Sangat kuat';
            }
            
            return { strength, requirements };
        }
        
        // Toggle password visibility
        if (togglePasswordBtn) {
            togglePasswordBtn.addEventListener('click', function() {
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
        
        // Toggle confirm password visibility
        if (toggleConfirmPasswordBtn) {
            toggleConfirmPasswordBtn.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                
                // Toggle icon
                if (type === 'password') {
                    eyeConfirmIcon.setAttribute('icon', 'carbon:view');
                } else {
                    eyeConfirmIcon.setAttribute('icon', 'carbon:view-off');
                }
            });
        }
        
        // Real-time password strength check
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                if (passwordInput.value.length > 0) {
                    checkPasswordStrength(passwordInput.value);
                } else {
                    passwordStrengthBar.style.width = '0%';
                    passwordStrengthText.textContent = '';
                    
                    // Reset requirement indicators
                    document.querySelectorAll('.requirement-item').forEach(item => {
                        item.classList.remove('met');
                        item.querySelector('iconify-icon').setAttribute('icon', 'carbon:circle-dash');
                    });
                }
            });
        }
        
        // Validate current step
        function validateStep(step) {
            let isValid = true;
            
            if (step === 1) {
                // Validate name
                const name = document.getElementById('name').value;
                if (name.length < 2) {
                    isValid = false;
                }
                
                // Validate email
                const email = document.getElementById('email').value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    isValid = false;
                }
                
            } else if (step === 2) {
                // Validate password
                const password = passwordInput.value;
                const passwordStrength = checkPasswordStrength(password);
                
                if (passwordStrength.strength < 60) {
                    isValid = false;
                }
                
                // Validate confirm password
                if (confirmPasswordInput.value !== passwordInput.value) {
                    isValid = false;
                }
            }
            
            return isValid;
        }
        
        // Step navigation
        function nextStep() {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    // Hide current step
                    document.getElementById(`step${currentStep}Form`).classList.remove('active');
                    document.getElementById(`step${currentStep}`).classList.remove('active');
                    
                    // Show next step
                    currentStep++;
                    document.getElementById(`step${currentStep}Form`).classList.add('active');
                    document.getElementById(`step${currentStep}`).classList.add('active');
                    
                    // Mark previous step as completed
                    document.getElementById(`step${currentStep-1}`).classList.add('completed');
                }
            } else {
                showCustomError('Harap perbaiki kesalahan di formulir sebelum melanjutkan.');
            }
        }
        
        function prevStep() {
            if (currentStep > 1) {
                // Hide current step
                document.getElementById(`step${currentStep}Form`).classList.remove('active');
                document.getElementById(`step${currentStep}`).classList.remove('active');
                
                // Show previous step
                currentStep--;
                document.getElementById(`step${currentStep}Form`).classList.add('active');
                document.getElementById(`step${currentStep}`).classList.add('active');
                
                // Remove completed status from next step
                document.getElementById(`step${currentStep+1}`).classList.remove('completed');
            }
        }
        
        // Form submission
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                // Validate all steps
                let allValid = true;
                
                for (let i = 1; i <= totalSteps; i++) {
                    if (!validateStep(i)) {
                        allValid = false;
                        
                        // Jump to the first invalid step
                        if (currentStep !== i) {
                            // Hide current step
                            document.getElementById(`step${currentStep}Form`).classList.remove('active');
                            document.getElementById(`step${currentStep}`).classList.remove('active');
                            
                            // Show the invalid step
                            currentStep = i;
                            document.getElementById(`step${currentStep}Form`).classList.add('active');
                            document.getElementById(`step${currentStep}`).classList.add('active');
                        }
                        
                        break;
                    }
                }
                
                // Check terms agreement
                const termsCheckbox = document.getElementById('terms');
                if (!termsCheckbox.checked) {
                    showCustomError('Anda harus menyetujui Syarat & Ketentuan untuk melanjutkan.');
                    allValid = false;
                    e.preventDefault();
                }
                
                if (allValid && registerBtn) {
                    // Show loading state
                    registerBtn.classList.add('btn-loading');
                    registerBtn.disabled = true;
                }
                
                if (!allValid) {
                    e.preventDefault();
                }
            });
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
        
        // Social register function
        function socialRegister(provider) {
            showCustomError(`Registrasi dengan ${provider.charAt(0).toUpperCase() + provider.slice(1)} sedang dalam pengembangan.`);
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    closeAlert(alert.id);
                }, 5000);
            });
            
            // Check if there are validation errors and jump to appropriate step
            const errors = {!! json_encode($errors->any()) !!};
            if (errors) {
                // Check which fields have errors to determine step
                const errorFields = {!! json_encode($errors->keys()) !!};
                
                if (errorFields.includes('password') || errorFields.includes('password_confirmation')) {
                    // Jump to step 2
                    document.getElementById('step1Form').classList.remove('active');
                    document.getElementById('step1').classList.remove('active');
                    document.getElementById('step2Form').classList.add('active');
                    document.getElementById('step2').classList.add('active');
                    document.getElementById('step1').classList.add('completed');
                    currentStep = 2;
                } else if (errorFields.includes('terms')) {
                    // Jump to step 3
                    document.getElementById('step1Form').classList.remove('active');
                    document.getElementById('step1').classList.remove('active');
                    document.getElementById('step2Form').classList.remove('active');
                    document.getElementById('step2').classList.remove('active');
                    document.getElementById('step3Form').classList.add('active');
                    document.getElementById('step3').classList.add('active');
                    document.getElementById('step1').classList.add('completed');
                    document.getElementById('step2').classList.add('completed');
                    currentStep = 3;
                }
            }
            
            // Demo data for testing (remove in production)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('demo') === 'true') {
                document.getElementById('name').value = 'Ahmad Fauzi';
                document.getElementById('email').value = 'ahmad.fauzi@example.com';
                document.getElementById('phone').value = '+62 812-3456-7890';
                if (passwordInput) passwordInput.value = 'Password123!';
                if (confirmPasswordInput) confirmPasswordInput.value = 'Password123!';
                document.getElementById('terms').checked = true;
                document.getElementById('newsletter').checked = true;
                
                // Trigger events to update UI
                if (passwordInput) {
                    passwordInput.dispatchEvent(new Event('input'));
                }
            }
        });
    </script>
</body>
</html>