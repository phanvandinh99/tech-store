<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận mã khôi phục Admin - Tech Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 2rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
        }
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            border: 2px solid #e9ecef;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .code-input {
            font-size: 24px !important;
            letter-spacing: 8px !important;
            font-family: 'Courier New', monospace !important;
            text-align: center !important;
        }
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <i class="fas fa-shield-check fa-3x mb-3"></i>
                        <h4>Xác nhận mã khôi phục</h4>
                        <p class="mb-0">Tech Store Admin Panel</p>
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Chúng tôi đã gửi mã xác nhận 6 số đến email: <strong>{{ $email }}</strong>
                            <br><small>Mã có hiệu lực trong 15 phút</small>
                        </div>

                        <form method="POST" action="{{ route('admin.password.update') }}">
                            @csrf
                            
                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="mb-3">
                                <label for="code" class="form-label">
                                    <i class="fas fa-key me-2"></i>Mã xác nhận (6 số)
                                </label>
                                <input type="text" 
                                       class="form-control code-input @error('code') is-invalid @enderror" 
                                       id="code" 
                                       name="code" 
                                       maxlength="6"
                                       pattern="[0-9]{6}"
                                       required 
                                       autofocus
                                       placeholder="000000">
                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">Nhập mã 6 số từ email</div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Mật khẩu mới
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       minlength="6"
                                       placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu mới
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required 
                                       minlength="6"
                                       placeholder="Nhập lại mật khẩu mới">
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i>
                                    Đặt lại mật khẩu
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('admin.password.request') }}" class="text-decoration-none me-3">
                                    <i class="fas fa-envelope me-1"></i>
                                    Gửi lại mã
                                </a>
                                <br><br>
                                <a href="{{ route('admin.login') }}" class="text-decoration-none">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Quay lại đăng nhập Admin
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Tự động format input mã xác nhận
        document.getElementById('code').addEventListener('input', function(e) {
            // Chỉ cho phép số
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Giới hạn 6 ký tự
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
        });

        // Kiểm tra mật khẩu khớp
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Mật khẩu xác nhận không khớp');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>