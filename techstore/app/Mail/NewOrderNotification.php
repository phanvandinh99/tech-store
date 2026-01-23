<?php

namespace App\Mail;

use App\Models\DonHang;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;

    public function __construct(DonHang $donHang)
    {
        $this->donHang = $donHang;
    }

    public function build()
    {
        return $this->subject('Đơn hàng mới - ' . $this->donHang->ma_don_hang)
                    ->view('emails.new-order-notification')
                    ->with([
                        'donHang' => $this->donHang,
                        'chiTietDonHangs' => $this->donHang->chiTietDonHangs()->with([
                            'sanPham', 
                            'bienThe.giaTriThuocTinhs'
                        ])->get()
                    ]);
    }
}