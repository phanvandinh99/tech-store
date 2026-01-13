@extends('frontend.layout')

@section('title', 'Chính Sách Bảo Hành - Tech Store')

@push('styles')
<style>
    .warranty-policy-container {
        padding: 3rem 0;
        min-height: 60vh;
    }
    .policy-header {
        text-align: center;
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #e0e0e0;
    }
    .policy-header h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 1rem;
    }
    .policy-header p {
        font-size: 1.1rem;
        color: #666;
    }
    .policy-content {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .policy-section {
        margin-bottom: 2.5rem;
    }
    .policy-section:last-child {
        margin-bottom: 0;
    }
    .policy-section h2 {
        font-size: 1.5rem;
        color: #c40316;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
    }
    .policy-section h3 {
        font-size: 1.2rem;
        color: #333;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
    .policy-section p {
        line-height: 1.8;
        color: #555;
        margin-bottom: 1rem;
    }
    .policy-section ul, .policy-section ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .policy-section li {
        line-height: 1.8;
        color: #555;
        margin-bottom: 0.5rem;
    }
    .highlight-box {
        background: #f8f9fa;
        border-left: 4px solid #c40316;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0.25rem;
    }
    .highlight-box strong {
        color: #c40316;
    }
    .contact-info {
        background: #e8f4f8;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-top: 2rem;
    }
    .contact-info h3 {
        color: #0c5460;
        margin-bottom: 1rem;
    }
    .contact-info p {
        margin-bottom: 0.5rem;
    }
    .contact-info strong {
        color: #0c5460;
    }
    @media (max-width: 768px) {
        .policy-header h1 {
            font-size: 2rem;
        }
        .policy-content {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li>Chính Sách Bảo Hành</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--warranty policy area start-->
<div class="warranty-policy-container">
    <div class="container">
        <div class="policy-header">
            <h1>Chính Sách Bảo Hành</h1>
            <p>Cập nhật lần cuối: {{ date('d/m/Y') }}</p>
        </div>

        <div class="policy-content">
            <!-- Section 1: Tổng quan -->
            <div class="policy-section">
                <h2>1. Tổng Quan Về Chính Sách Bảo Hành</h2>
                <p>
                    Tech Store cam kết cung cấp dịch vụ bảo hành chất lượng cao cho tất cả sản phẩm được mua tại cửa hàng. 
                    Chúng tôi đảm bảo quyền lợi của khách hàng và hỗ trợ giải quyết mọi vấn đề liên quan đến sản phẩm trong thời gian bảo hành.
                </p>
            </div>

            <!-- Section 2: Thời gian bảo hành -->
            <div class="policy-section">
                <h2>2. Thời Gian Bảo Hành</h2>
                <h3>2.1. Thời gian bảo hành theo sản phẩm:</h3>
                <ul>
                    <li><strong>Điện thoại, Tablet:</strong> 12 tháng kể từ ngày mua</li>
                    <li><strong>Laptop, Máy tính:</strong> 24 tháng kể từ ngày mua</li>
                    <li><strong>Màn hình, TV:</strong> 24 tháng kể từ ngày mua</li>
                    <li><strong>Phụ kiện:</strong> 6 tháng kể từ ngày mua</li>
                    <li><strong>Sản phẩm khác:</strong> Theo quy định của nhà sản xuất</li>
                </ul>

                <div class="highlight-box">
                    <strong>Lưu ý:</strong> Thời gian bảo hành được tính từ ngày mua hàng và được ghi rõ trên hóa đơn mua hàng. 
                    Khách hàng cần giữ lại hóa đơn để được hưởng chế độ bảo hành.
                </div>
            </div>

            <!-- Section 3: Điều kiện bảo hành -->
            <div class="policy-section">
                <h2>3. Điều Kiện Bảo Hành</h2>
                <h3>3.1. Sản phẩm được bảo hành khi:</h3>
                <ul>
                    <li>Có hóa đơn mua hàng hợp lệ từ Tech Store</li>
                    <li>Sản phẩm còn trong thời gian bảo hành</li>
                    <li>Sản phẩm bị lỗi do nhà sản xuất hoặc lỗi kỹ thuật</li>
                    <li>Sản phẩm chưa bị can thiệp, sửa chữa bởi bên thứ ba</li>
                    <li>Sản phẩm không bị hư hỏng do tác động bên ngoài (rơi vỡ, va đập, ngấm nước...)</li>
                    <li>Serial number, tem bảo hành còn nguyên vẹn, chưa bị tẩy xóa</li>
                </ul>

                <h3>3.2. Sản phẩm không được bảo hành khi:</h3>
                <ul>
                    <li>Hết thời gian bảo hành</li>
                    <li>Không có hóa đơn mua hàng hoặc hóa đơn không hợp lệ</li>
                    <li>Serial number, tem bảo hành bị tẩy xóa, thay đổi</li>
                    <li>Sản phẩm bị hư hỏng do sử dụng sai cách, không đúng hướng dẫn</li>
                    <li>Sản phẩm bị hư hỏng do thiên tai, hỏa hoạn, sét đánh</li>
                    <li>Sản phẩm đã được sửa chữa, can thiệp bởi bên thứ ba</li>
                    <li>Hư hỏng do người dùng tự ý tháo lắp, sửa chữa</li>
                </ul>
            </div>

            <!-- Section 4: Hình thức bảo hành -->
            <div class="policy-section">
                <h2>4. Hình Thức Bảo Hành</h2>
                <h3>4.1. Sửa chữa:</h3>
                <p>
                    Sản phẩm sẽ được sửa chữa tại trung tâm bảo hành chính thức. 
                    Thời gian sửa chữa thông thường từ 7-14 ngày làm việc tùy theo mức độ hư hỏng.
                </p>

                <h3>4.2. Thay thế linh kiện:</h3>
                <p>
                    Trong trường hợp cần thay thế linh kiện, chúng tôi sẽ sử dụng linh kiện chính hãng. 
                    Khách hàng sẽ được thông báo trước về chi phí (nếu có) và thời gian thay thế.
                </p>

                <h3>4.3. Đổi mới:</h3>
                <p>
                    Sản phẩm sẽ được đổi mới trong các trường hợp:
                </p>
                <ul>
                    <li>Sản phẩm bị lỗi trong 30 ngày đầu sau khi mua</li>
                    <li>Sản phẩm không thể sửa chữa được</li>
                    <li>Sản phẩm bị lỗi nghiêm trọng do nhà sản xuất</li>
                </ul>
                <p>
                    <strong>Lưu ý:</strong> Sản phẩm đổi mới phải còn nguyên vẹn, đầy đủ phụ kiện và hộp đựng ban đầu.
                </p>
            </div>

            <!-- Section 5: Quy trình bảo hành -->
            <div class="policy-section">
                <h2>5. Quy Trình Bảo Hành</h2>
                <ol>
                    <li><strong>Tiếp nhận yêu cầu:</strong> Khách hàng tạo yêu cầu bảo hành trực tuyến hoặc đến trực tiếp cửa hàng</li>
                    <li><strong>Kiểm tra sản phẩm:</strong> Nhân viên kiểm tra tình trạng sản phẩm và xác nhận điều kiện bảo hành</li>
                    <li><strong>Xác nhận yêu cầu:</strong> Khách hàng nhận mã yêu cầu bảo hành để theo dõi</li>
                    <li><strong>Xử lý bảo hành:</strong> Sản phẩm được chuyển đến trung tâm bảo hành để xử lý</li>
                    <li><strong>Thông báo kết quả:</strong> Khách hàng được thông báo khi sản phẩm đã được xử lý xong</li>
                    <li><strong>Nhận lại sản phẩm:</strong> Khách hàng đến cửa hàng nhận lại sản phẩm đã bảo hành</li>
                </ol>

                <div class="highlight-box">
                    <strong>Mẹo:</strong> Khách hàng có thể theo dõi trạng thái yêu cầu bảo hành trực tuyến tại mục 
                    <a href="{{ route('warranty.index') }}" style="color: #c40316; text-decoration: underline;">"Yêu cầu bảo hành"</a> 
                    trong tài khoản của mình.
                </div>
            </div>

            <!-- Section 6: Chi phí bảo hành -->
            <div class="policy-section">
                <h2>6. Chi Phí Bảo Hành</h2>
                <h3>6.1. Miễn phí:</h3>
                <ul>
                    <li>Sửa chữa lỗi do nhà sản xuất trong thời gian bảo hành</li>
                    <li>Thay thế linh kiện lỗi do nhà sản xuất</li>
                    <li>Đổi mới sản phẩm lỗi trong 30 ngày đầu</li>
                </ul>

                <h3>6.2. Có phí:</h3>
                <ul>
                    <li>Thay thế linh kiện bị hư hỏng do người dùng (màn hình, pin, vỏ máy...)</li>
                    <li>Sửa chữa sản phẩm hết thời gian bảo hành</li>
                    <li>Vệ sinh, bảo dưỡng sản phẩm</li>
                </ul>
                <p>
                    <strong>Lưu ý:</strong> Khách hàng sẽ được thông báo và xác nhận trước khi thực hiện các dịch vụ có phí.
                </p>
            </div>

            <!-- Section 7: Thời gian xử lý -->
            <div class="policy-section">
                <h2>7. Thời Gian Xử Lý Bảo Hành</h2>
                <ul>
                    <li><strong>Tiếp nhận:</strong> Ngay khi khách hàng gửi yêu cầu</li>
                    <li><strong>Kiểm tra:</strong> 1-2 ngày làm việc</li>
                    <li><strong>Sửa chữa:</strong> 7-14 ngày làm việc (tùy mức độ hư hỏng)</li>
                    <li><strong>Thay thế linh kiện:</strong> 10-21 ngày làm việc (nếu cần đặt hàng linh kiện)</li>
                    <li><strong>Đổi mới:</strong> 3-5 ngày làm việc</li>
                </ul>
                <p>
                    <strong>Lưu ý:</strong> Thời gian có thể kéo dài hơn trong các trường hợp đặc biệt hoặc do ảnh hưởng 
                    từ nhà sản xuất. Chúng tôi sẽ thông báo cho khách hàng nếu có thay đổi.
                </p>
            </div>

            <!-- Section 8: Quyền lợi khách hàng -->
            <div class="policy-section">
                <h2>8. Quyền Lợi Của Khách Hàng</h2>
                <ul>
                    <li>Được bảo hành miễn phí theo đúng chính sách</li>
                    <li>Được thông báo rõ ràng về tình trạng và phương án xử lý</li>
                    <li>Được theo dõi trạng thái bảo hành trực tuyến 24/7</li>
                    <li>Được hỗ trợ tư vấn kỹ thuật miễn phí</li>
                    <li>Được đổi mới sản phẩm nếu không thể sửa chữa</li>
                </ul>
            </div>

            <!-- Section 9: Liên hệ -->
            <div class="policy-section">
                <h2>9. Liên Hệ Hỗ Trợ</h2>
                <div class="contact-info">
                    <h3><i class="fa fa-headphones"></i> Bộ phận Bảo hành - Tech Store</h3>
                    <p><strong>Hotline:</strong> 0329555345 (Miễn phí 24/7)</p>
                    <p><strong>Email:</strong> baohanh@techstore.com</p>
                    <p><strong>Địa chỉ:</strong> [Địa chỉ cửa hàng của bạn]</p>
                    <p><strong>Giờ làm việc:</strong> Thứ 2 - Chủ nhật: 8:00 - 22:00</p>
                    <p style="margin-top: 1rem;">
                        <strong>Hỗ trợ trực tuyến:</strong> 
                        <a href="{{ route('warranty.create') }}" style="color: #c40316; text-decoration: underline;">
                            Tạo yêu cầu bảo hành trực tuyến
                        </a>
                    </p>
                </div>
            </div>

            <!-- Section 10: Lưu ý -->
            <div class="policy-section">
                <h2>10. Lưu Ý Quan Trọng</h2>
                <div class="highlight-box">
                    <ul style="margin-left: 0; list-style: none;">
                        <li>✓ Vui lòng giữ lại hóa đơn mua hàng để được hưởng chế độ bảo hành</li>
                        <li>✓ Không tự ý tháo lắp, sửa chữa sản phẩm khi đang trong thời gian bảo hành</li>
                        <li>✓ Sao lưu dữ liệu trước khi gửi sản phẩm đi bảo hành</li>
                        <li>✓ Kiểm tra kỹ sản phẩm trước khi nhận lại sau bảo hành</li>
                        <li>✓ Thông báo ngay cho chúng tôi nếu có bất kỳ vấn đề nào</li>
                    </ul>
                </div>
            </div>

            <!-- Footer note -->
            <div class="policy-section" style="text-align: center; margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e0e0e0;">
                <p style="color: #666; font-style: italic;">
                    Tech Store cam kết cung cấp dịch vụ bảo hành tốt nhất cho khách hàng. 
                    Mọi thắc mắc vui lòng liên hệ với chúng tôi qua các kênh hỗ trợ trên.
                </p>
                <p style="margin-top: 1rem;">
                    <a href="{{ route('warranty.create') }}" class="btn btn-primary">
                        <i class="fa fa-wrench"></i> Tạo Yêu Cầu Bảo Hành Ngay
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
<!--warranty policy area end-->
@endsection
