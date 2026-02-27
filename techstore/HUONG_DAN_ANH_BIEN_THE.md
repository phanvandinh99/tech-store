# Hướng dẫn Quản lý Ảnh theo Biến thể

## Tổng quan
Hệ thống cho phép gán ảnh riêng cho từng biến thể sản phẩm. Khi khách hàng chọn biến thể (ví dụ: chọn màu Đen), hình ảnh sẽ tự động thay đổi để hiển thị ảnh của biến thể đó.

## Cách hoạt động

### Trên trang chi tiết sản phẩm (Frontend):
1. Khách hàng xem sản phẩm (ví dụ: iPhone Air)
2. Chọn thuộc tính (ví dụ: Màu sắc = Đen, Dung lượng = 256GB, RAM = 8GB)
3. Hệ thống tự động:
   - Tìm biến thể phù hợp
   - Thay đổi ảnh chính và gallery thumbnail
   - Cập nhật giá, tồn kho
   - Cập nhật nút "Thêm vào giỏ hàng" / "HẾT HÀNG"

### Ưu điểm:
- ✅ Khách hàng thấy chính xác sản phẩm họ đang chọn
- ✅ Tăng trải nghiệm mua hàng
- ✅ Giảm nhầm lẫn về màu sắc/phiên bản
- ✅ Tự động, không cần reload trang

## Cách thêm ảnh cho biến thể

### Phương pháp 1: Khi tạo sản phẩm mới
1. Vào **Sản phẩm** > **Thêm mới**
2. Điền thông tin sản phẩm
3. Tạo các biến thể với thuộc tính (Màu sắc, Dung lượng, RAM...)
4. Lưu sản phẩm
5. Sau đó vào **Sửa sản phẩm** để thêm ảnh cho từng biến thể

### Phương pháp 2: Thêm ảnh cho biến thể đã có
1. Vào **Sản phẩm** > Chọn sản phẩm cần sửa
2. Chuyển sang tab **"Ảnh"**
3. Trong form **"Thêm ảnh mới"**:
   - Chọn file ảnh (có thể chọn nhiều ảnh)
   - Trong dropdown **"Gán cho biến thể"**, chọn biến thể tương ứng
   - Ví dụ: Chọn biến thể "IP-AIR-BLACK-256-8 - (Đen, 256GB, 8GB)"
   - Click **Upload**
4. Ảnh sẽ được gán cho biến thể đó

### Phương pháp 3: Khi thêm biến thể mới
1. Vào **Sản phẩm** > Sửa sản phẩm
2. Tab **"Biến thể"** > Click **"Thêm biến thể mới"**
3. Điền thông tin biến thể
4. Chọn giá trị thuộc tính
5. Trong phần **"Ảnh cho biến thể"**, chọn file ảnh
6. Click **"Thêm"**

## Ví dụ thực tế

### Ví dụ 1: iPhone Air với 3 màu
**Sản phẩm**: iPhone Air 256GB

**Biến thể**:
1. Màu Đen - 256GB - 8GB RAM
   - Ảnh: iphone-air-black-1.jpg, iphone-air-black-2.jpg
2. Màu Trắng - 256GB - 8GB RAM
   - Ảnh: iphone-air-white-1.jpg, iphone-air-white-2.jpg
3. Màu Vàng - 256GB - 8GB RAM
   - Ảnh: iphone-air-gold-1.jpg, iphone-air-gold-2.jpg

**Kết quả**: Khi khách chọn màu Đen, hiển thị ảnh đen. Chọn màu Trắng, hiển thị ảnh trắng.

### Ví dụ 2: Laptop với nhiều cấu hình
**Sản phẩm**: Dell XPS 15

**Biến thể**:
1. Intel i5 - 16GB RAM - 512GB SSD
   - Ảnh: dell-xps-i5.jpg
2. Intel i7 - 32GB RAM - 1TB SSD
   - Ảnh: dell-xps-i7.jpg (có thể khác về sticker cấu hình)

## Quản lý ảnh biến thể

### Xem ảnh đã gán
1. Vào **Sản phẩm** > Sửa sản phẩm
2. Tab **"Ảnh"** > Phần **"Ảnh hiện có"**
3. Mỗi ảnh sẽ hiển thị:
   - Ảnh preview
   - Badge "Ảnh chính" (nếu là ảnh chính)
   - Thông tin biến thể: SKU và giá trị thuộc tính
   - Hoặc "Ảnh chung" nếu không gán cho biến thể nào

### Đặt ảnh chính cho biến thể
1. Mỗi biến thể nên có 1 ảnh chính
2. Click **"Đặt làm ảnh chính"** trên ảnh muốn làm ảnh chính
3. Ảnh chính sẽ hiển thị đầu tiên khi chọn biến thể

### Xóa ảnh
1. Click nút **Xóa** (icon thùng rác) trên ảnh
2. Xác nhận xóa

## Lưu ý quan trọng

### 1. Ảnh chung vs Ảnh biến thể
- **Ảnh chung**: Không gán cho biến thể nào, hiển thị mặc định
- **Ảnh biến thể**: Gán cho biến thể cụ thể, hiển thị khi chọn biến thể đó

### 2. Nếu biến thể không có ảnh riêng
- Hệ thống sẽ hiển thị ảnh chung của sản phẩm
- Không bị lỗi hoặc hiển thị trống

### 3. Nhiều ảnh cho 1 biến thể
- Có thể upload nhiều ảnh cho 1 biến thể
- Ảnh đầu tiên (hoặc ảnh được đặt làm chính) sẽ hiển thị đầu tiên
- Khách hàng có thể xem các ảnh khác trong gallery thumbnail

### 4. Kích thước ảnh khuyến nghị
- Tỷ lệ: 1:1 (vuông) hoặc 4:3
- Kích thước: Tối thiểu 800x800px
- Định dạng: JPG, PNG, WEBP
- Dung lượng: Dưới 2MB mỗi ảnh

### 5. Đặt tên file ảnh
Nên đặt tên có ý nghĩa để dễ quản lý:
- ✅ Tốt: `iphone-air-black-front.jpg`, `iphone-air-black-back.jpg`
- ❌ Tránh: `IMG_1234.jpg`, `photo.jpg`

## Quy trình làm việc khuyến nghị

### Khi thêm sản phẩm mới:
1. Tạo sản phẩm với thông tin cơ bản
2. Tạo tất cả các biến thể cần thiết
3. Upload ảnh chung cho sản phẩm (nếu có)
4. Upload ảnh riêng cho từng biến thể
5. Đặt ảnh chính cho mỗi biến thể
6. Kiểm tra trên trang chi tiết sản phẩm

### Khi cập nhật ảnh:
1. Xóa ảnh cũ (nếu cần)
2. Upload ảnh mới
3. Gán cho đúng biến thể
4. Kiểm tra lại trên frontend

## Troubleshooting

### Vấn đề: Ảnh không thay đổi khi chọn biến thể
**Nguyên nhân**: Biến thể chưa có ảnh riêng
**Giải pháp**: Upload ảnh và gán cho biến thể đó

### Vấn đề: Ảnh bị mờ hoặc vỡ
**Nguyên nhân**: Ảnh upload có độ phân giải thấp
**Giải pháp**: Upload lại ảnh có độ phân giải cao hơn (tối thiểu 800x800px)

### Vấn đề: Không thấy dropdown chọn biến thể
**Nguyên nhân**: Sản phẩm chưa có biến thể
**Giải pháp**: Tạo biến thể trước, sau đó mới upload ảnh

### Vấn đề: Upload ảnh bị lỗi
**Nguyên nhân**: File quá lớn hoặc định dạng không hỗ trợ
**Giải pháp**: 
- Nén ảnh xuống dưới 2MB
- Chỉ dùng định dạng JPG, PNG, WEBP

## Tính năng kỹ thuật

### Cấu trúc Database
- Bảng `anh_san_pham` có trường `bien_the_id`
- `bien_the_id = NULL`: Ảnh chung
- `bien_the_id = [ID]`: Ảnh của biến thể cụ thể

### JavaScript
- Hàm `updateVariantImages()`: Cập nhật ảnh khi chọn biến thể
- Hàm `changeMainImage()`: Thay đổi ảnh chính khi click thumbnail
- Auto-update khi chọn thuộc tính

### API Response
Mỗi variant trả về:
```json
{
  "id": 123,
  "sku": "IP-AIR-BLACK-256-8",
  "gia": 25000000,
  "images": [
    {
      "url": "http://domain.com/storage/products/image1.jpg",
      "is_primary": true
    }
  ],
  "primary_image": "http://domain.com/storage/products/image1.jpg"
}
```

## Best Practices

1. **Chụp ảnh đồng nhất**: Cùng góc độ, ánh sáng cho tất cả biến thể
2. **Đủ số lượng ảnh**: Ít nhất 3-4 ảnh mỗi biến thể (trước, sau, cạnh, chi tiết)
3. **Ảnh chất lượng cao**: Rõ nét, màu sắc chính xác
4. **Đặt tên có hệ thống**: Dễ tìm kiếm và quản lý
5. **Kiểm tra trước khi publish**: Test trên frontend xem ảnh có đổi đúng không

## Kết luận

Tính năng ảnh theo biến thể giúp:
- Tăng trải nghiệm người dùng
- Giảm tỷ lệ trả hàng do nhầm lẫn
- Tăng tỷ lệ chuyển đổi
- Chuyên nghiệp hơn trong mắt khách hàng

Hãy tận dụng tính năng này để cải thiện chất lượng hiển thị sản phẩm!
