<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin - Tech Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 50%, #06b6d4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background shapes */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite;
        }

        body::before {
            width: 500px;
            height: 500px;
            background: white;
            top: -250px;
            left: -250px;
        }

        body::after {
            width: 400px;
            height: 400px;
            background: white;
            bottom: -200px;
            right: -200px;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
            padding: 2rem;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
        }

        .login-left {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 50%, #06b6d4 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: move 20s linear infinite;
            top: -50%;
            left: -50%;
        }

        @keyframes move {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .login-left-content {
            position: relative;
            z-index: 1;
        }

        .login-icon {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .login-icon i {
            font-size: 3.5rem;
        }

        .login-left h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .login-left p {
            font-size: 1.1rem;
            opacity: 0.95;
            line-height: 1.6;
        }

        .login-right {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 2rem;
        }

        .login-header h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #2563eb;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 1;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.875rem 1rem 0.875rem 3rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #ef4444;
        }

        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            border: 2px solid #d1d5db;
            border-radius: 4px;
            width: 1.1rem;
            height: 1.1rem;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .form-check-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin-left: 0.5rem;
            cursor: pointer;
        }

        .btn-login {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #1d4ed8 0%, #0284c7 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            margin-right: 0.5rem;
        }

        /* Tablet styles (768px - 1024px) */
        @media (max-width: 1024px) {
            .login-container {
                grid-template-columns: 1fr 1fr;
            }
            .login-left {
                padding: 2rem;
            }
            .login-right {
                padding: 2rem;
            }
        }

        /* Mobile styles (max 768px) */
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .login-left {
                padding: 2rem 1.5rem;
                min-height: 180px;
            }

            .login-left h2 {
                font-size: 1.5rem;
            }

            .login-left p {
                font-size: 0.95rem;
            }

            .login-icon {
                width: 80px;
                height: 80px;
            }

            .login-icon i {
                font-size: 2.5rem;
            }

            .login-right {
                padding: 2rem 1.5rem;
            }

            .login-wrapper {
                padding: 1rem;
            }

            .login-header h3 {
                font-size: 1.5rem;
            }
        }

        /* Small mobile (max 576px) */
        @media (max-width: 576px) {
            .login-wrapper {
                padding: 0.5rem;
            }

            .login-left {
                padding: 1.5rem 1rem;
                min-height: 150px;
            }

            .login-left h2 {
                font-size: 1.25rem;
            }

            .login-left p {
                font-size: 0.875rem;
            }

            .login-icon {
                width: 70px;
                height: 70px;
                margin-bottom: 1rem;
            }

            .login-icon i {
                font-size: 2rem;
            }

            .login-right {
                padding: 1.5rem 1rem;
            }

            .login-header {
                margin-bottom: 1.5rem;
            }

            .login-header h3 {
                font-size: 1.25rem;
            }

            .login-header p {
                font-size: 0.875rem;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }

            .form-control {
                padding: 0.75rem 1rem 0.75rem 2.75rem;
                font-size: 0.9rem;
            }

            .input-icon {
                left: 0.75rem;
            }

            .btn-login {
                padding: 0.75rem 1.5rem;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Left Side - Branding -->
            <div class="login-left">
                <div class="login-left-content">
                    <div class="login-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h2>Tech Store</h2>
                    <p>Hệ thống quản trị thương mại điện tử<br>Chuyên nghiệp & Hiện đại</p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="login-right">
                <div class="login-header">
                    <h3>Chào mừng trở lại</h3>
                    <p>Đăng nhập để tiếp tục quản lý hệ thống</p>
                </div>

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i>
                            Email
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="admin@gmail.com">
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i>
                            Mật khẩu
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="••••••••">
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Đăng nhập
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
