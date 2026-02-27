<?php

use Illuminate\Support\Facades\Route;
use App\Models\SanPham;

// Route debug - XÓA SAU KHI HOÀN THÀNH
Route::get('/debug/product/{id}', function($id) {
    $product = SanPham::with([
        'bienThes.giaTriThuocTinhs.thuocTinh',
        'thuocTinhs.giaTriThuocTinhs'
    ])->findOrFail($id);
    
    echo "<h2>Sản phẩm: {$product->ten}</h2>";
    
    echo "<h3>Thuộc tính của sản phẩm:</h3>";
    echo "<ul>";
    foreach($product->thuocTinhs as $tt) {
        echo "<li><strong>{$tt->ten}:</strong> ";
        echo $tt->giaTriThuocTinhs->pluck('giatri')->implode(', ');
        echo "</li>";
    }
    echo "</ul>";
    
    echo "<h3>Biến thể và giá trị thuộc tính:</h3>";
    foreach($product->bienThes as $bt) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
        echo "<strong>SKU: {$bt->sku}</strong><br>";
        echo "Giá: " . number_format($bt->gia) . " đ<br>";
        echo "Tồn kho: {$bt->so_luong_ton}<br>";
        
        if($bt->giaTriThuocTinhs->count() > 0) {
            echo "<strong>Giá trị thuộc tính:</strong><br>";
            echo "<ul>";
            foreach($bt->giaTriThuocTinhs as $gttt) {
                echo "<li>{$gttt->thuocTinh->ten}: <strong>{$gttt->giatri}</strong> (ID: {$gttt->id})</li>";
            }
            echo "</ul>";
        } else {
            echo "<span style='color: red;'>⚠️ CHƯA CÓ GIÁ TRỊ THUỘC TÍNH</span><br>";
        }
        
        // Kiểm tra ảnh
        $images = $bt->anhSanPhams;
        if($images->count() > 0) {
            echo "<strong>Ảnh biến thể:</strong><br>";
            foreach($images as $img) {
                echo "<img src='" . asset('storage/' . $img->duong_dan) . "' style='width: 100px; height: 100px; object-fit: cover; margin: 5px;'>";
            }
        } else {
            echo "<span style='color: orange;'>⚠️ Chưa có ảnh riêng</span>";
        }
        
        echo "</div>";
    }
    
    echo "<hr>";
    echo "<h3>Kết luận:</h3>";
    $hasIssue = false;
    foreach($product->bienThes as $bt) {
        if($bt->giaTriThuocTinhs->count() == 0) {
            $hasIssue = true;
            echo "<p style='color: red;'>❌ Biến thể <strong>{$bt->sku}</strong> chưa được gán giá trị thuộc tính!</p>";
        }
    }
    
    if(!$hasIssue) {
        echo "<p style='color: green;'>✅ Tất cả biến thể đã có giá trị thuộc tính</p>";
    } else {
        echo "<p><strong>Cách khắc phục:</strong></p>";
        echo "<ol>";
        echo "<li>Vào <a href='/admin/sanpham/{$id}/edit'>Sửa sản phẩm</a></li>";
        echo "<li>Tab 'Biến thể' → Click 'Sửa' từng biến thể</li>";
        echo "<li>Chọn giá trị thuộc tính (Màu sắc, Dung lượng, RAM...)</li>";
        echo "<li>Lưu lại</li>";
        echo "</ol>";
    }
});
