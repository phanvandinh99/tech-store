<?php

namespace App\Mail;

use App\Models\DonHang;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;

    public function __construct(DonHang $donHang)
    {
        $this->donHang = $donHang;
    }

    public function build()
    {
        return $this->subject('Đặt hàng thành công - Mã đơn hàng: ' . $this->donHang->ma_don_hang)
                    ->view('emails.order-placed')
                    ->with([
                        'donHang' => $this->donHang,
                        'chiTietDonHangs' => $this->donHang->chiTietDonHangs()->with([
                            'sanPham', 
                            'bienThe.giaTriThuocTinhs'
                        ])->get()
                    ]);
    }
}