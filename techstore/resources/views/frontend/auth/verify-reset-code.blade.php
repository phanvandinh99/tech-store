@extends('frontend.layout')

@section('title', 'Xác nhận mã khôi phục')

@section('content')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Xác nhận mã khôi phục</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Chúng tôi đã gửi mã xác nhận 6 số đến email: <strong>{{ $email }}</strong>
                        <br><small>Mã có hiệu lực trong 15 phút</small>
                    </div>

                    <form method="POST" action="{{ route('customer.password.update') }}">
                        @csrf
                        
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group mb-3">
                            <label for="code">Mã xác nhận (6 số)</label>
                            <input type="text" 
                                   class="form-control @error('code') is-invalid @enderror text-center" 
                                   id="code" 
                                   name="code" 
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   required 
                                   autofocus
                                   placeholder="000000"
                                   style="font-size: 24px; letter-spacing: 8px; font-family: monospace;">
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">Nhập mã 6 số từ email</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu mới</label>
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

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Xác nhận mật khẩu mới</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   minlength="6"
                                   placeholder="Nhập lại mật khẩu mới">
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary btn-block w-100">
                                <i class="fas fa-key me-2"></i>
                                Đặt lại mật khẩu
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('customer.password.request') }}" class="text-decoration-none">
                                <i class="fas fa-envelope me-2"></i>
                                Gửi lại mã xác nhận
                            </a>
                            <br><br>
                            <a href="{{ route('customer.login') }}" class="text-decoration-none">
                                ← Quay lại đăng nhập
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
@endsection