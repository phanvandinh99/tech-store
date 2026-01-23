<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mã khôi phục mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .code-container {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .code-label {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: normal;
            letter-spacing: normal;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .instructions {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔐 Mã khôi phục mật khẩu</h1>
        @if($userType === 'admin')
            <p>Yêu cầu khôi phục mật khẩu Admin</p>
        @else
            <p>Yêu cầu khôi phục mật khẩu</p>
        @endif
    </div>

    <div class="content">
        <p>Xin chào,</p>
        
        <p>Chúng tôi nhận được yêu cầu khôi phục mật khẩu cho tài khoản: <strong>{{ $email }}</strong></p>
        
        <p>Đây là mã xác nhận để đặt lại mật khẩu của bạn:</p>
        
        <div class="code-container">
            <div class="code-label">MÃ XÁC NHẬN</div>
            {{ $code }}
        </div>
        
        <div class="instructions">
            <h4>📋 Hướng dẫn sử dụng:</h4>
            <ol>
                <li>Quay lại trang đặt lại mật khẩu</li>
                <li>Nhập mã <strong>{{ $code }}</strong> vào ô "Mã xác nhận"</li>
                <li>Nhập mật khẩu mới của bạn</li>
                <li>Nhấn "Đặt lại mật khẩu"</li>
            </ol>
        </div>
    </div>

    <div class="warning">
        <p><strong>⚠️ Lưu ý quan trọng:</strong></p>
        <ul>
            <li>Mã xác nhận này chỉ có hiệu lực trong <strong>15 phút</strong></li>
            <li>Mã chỉ có thể sử dụng <strong>1 lần duy nhất</strong></li>
            <li>Nếu bạn không yêu cầu khôi phục mật khẩu, vui lòng bỏ qua email này</li>
            <li>Để bảo mật tài khoản, không chia sẻ mã này với bất kỳ ai</li>
            @if($userType === 'admin')
                <li><strong>Đây là tài khoản Admin - Vui lòng kiểm tra kỹ trước khi thực hiện</strong></li>
            @endif
        </ul>
    </div>

    <div class="footer">
        <p>Nếu bạn không yêu cầu khôi phục mật khẩu, không cần thực hiện bất kỳ hành động nào. Mật khẩu của bạn sẽ không thay đổi.</p>
        
        <p style="margin-top: 20px;">
            <strong>Liên hệ hỗ trợ:</strong><br>
            Email: support@techstore.com<br>
            Điện thoại: 0123-456-789
        </p>
        
        <p style="margin-top: 20px;"><em>Tech Store - Công nghệ cho cuộc sống</em></p>
    </div>
</body>
</html>