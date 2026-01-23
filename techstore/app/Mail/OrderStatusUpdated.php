<?php

namespace App\Mail;

use App\Models\DonHang;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;
    public $oldStatus;
    public $newStatus;

    public function __construct(DonHang $donHang, $oldStatus, $newStatus)
    {
        $this->donHang = $donHang;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        $statusText = $this->getStatusText($this->newStatus);
        
        return $this->subject('Cập nhật trạng thái đơn hàng - ' . $this->donHang->ma_don_hang)
                    ->view('emails.order-status-updated')
                    ->with([
                        'donHang' => $this->donHang,
                        'oldStatus' => $this->getStatusText($this->oldStatus),
                        'newStatus' => $statusText,
                        'chiTietDonHangs' => $this->donHang->chiTietDonHangs()->with([
                            'sanPham', 
                            'bienThe.giaTriThuocTinhs'
                        ])->get()
                    ]);
    }

    private function getStatusText($status)
    {
        $statusMap = [
            'cho_xac_nhan' => 'Chờ xác nhận',
            'da_xac_nhan' => 'Đã xác nhận',
            'dang_giao' => 'Đang giao hàng',
            'da_giao' => 'Đã giao hàng',
            'da_huy' => 'Đã hủy'
        ];

        return $statusMap[$status] ?? $status;
    }
}