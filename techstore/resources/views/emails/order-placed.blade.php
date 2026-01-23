<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt hàng thành công</title>
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
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-items {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            overflow: hidden;
        }
        .order-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-items th,
        .order-items td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .order-items th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total {
            background-color: #28a745;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã đặt hàng tại Tech Store</p>
    </div>

    <div class="order-info">
        <h3>Thông tin đơn hàng</h3>
        <p><strong>Mã đơn hàng:</strong> {{ $donHang->ma_don_hang }}</p>
        <p><strong>Ngày đặt:</strong> {{ $donHang->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Tên khách hàng:</strong> {{ $donHang->ten_khach }}</p>
        <p><strong>Email:</strong> {{ $donHang->email_khach }}</p>
        <p><strong>Số điện thoại:</strong> {{ $donHang->sdt_khach }}</p>
        <p><strong>Địa chỉ giao hàng:</strong> {{ $donHang->dia_chi_khach }}</p>
        <p><strong>Phương thức thanh toán:</strong> 
            @if($donHang->phuong_thuc_thanh_toan == 'cod')
                Thanh toán khi nhận hàng (COD)
            @else
                {{ $donHang->phuong_thuc_thanh_toan }}
            @endif
        </p>
        @if($donHang->ghi_chu)
            <p><strong>Ghi chú:</strong> {{ $donHang->ghi_chu }}</p>
        @endif
    </div>

    <div class="order-items">
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chiTietDonHangs as $chiTiet)
                <tr>
                    <td>
                        {{ $chiTiet->sanPham->ten ?? 'N/A' }}
                        @if($chiTiet->bienThe && $chiTiet->bienThe->gia_tri_thuoc_tinh)
                            <br><small style="color: #6c757d;">{{ $chiTiet->bienThe->gia_tri_thuoc_tinh }}</small>
                        @endif
                    </td>
                    <td>{{ $chiTiet->so_luong }}</td>
                    <td>{{ number_format($chiTiet->gia_luc_mua, 0, ',', '.') }}đ</td>
                    <td>{{ number_format($chiTiet->thanh_tien, 0, ',', '.') }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        Tổng tiền: {{ number_format($donHang->thanh_tien, 0, ',', '.') }}đ
    </div>

    <div class="footer">
        <p>Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.</p>
        <p>Mọi thắc mắc xin liên hệ: <strong>support@techstore.com</strong> hoặc <strong>0123-456-789</strong></p>
        <p><em>Tech Store - Công nghệ cho cuộc sống</em></p>
    </div>
</body>
</html>