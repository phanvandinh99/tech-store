<!--footer area start-->
<footer class="footer_widgets">
    <!--newsletter area start-->
    <div class="newsletter_area">
        <div class="container">
            <div class="newsletter_inner">
                <div class="row">
                    <div class="col-lg-3 col-md-5">
                        <div class="newsletter_sing_up">
                            <h3>Đăng ký nhận tin</h3>
                            <p>Nhận <span>Giảm 30%</span> cho người đăng ký hôm nay</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7">
                        <div class="subscribe_content">
                            <p><strong>Tham gia hơn 226.000+ người đăng ký</strong> và nhận mã giảm giá mới mỗi thứ Hai.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="subscribe_form">
                            <form id="mc-form" class="mc-form footer-newsletter">
                                <input id="mc-email" type="email" autocomplete="off" placeholder="Nhập địa chỉ email của bạn..." />
                                <button id="mc-submit">Đăng ký</button>
                            </form>
                            <!-- mailchimp-alerts Start -->
                            <div class="mailchimp-alerts text-centre">
                                <div class="mailchimp-submitting"></div>
                                <div class="mailchimp-success"></div>
                                <div class="mailchimp-error"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--newsletter area end-->
    
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5 col-sm-7">
                    <div class="widgets_container contact_us">
                        <h3>TẢI ỨNG DỤNG</h3>
                        <div class="aff_content">
                            <p><strong>TECH STORE</strong> App hiện có sẵn trên Google Play & App Store. Tải ngay.</p>
                        </div>
                        <div class="app_img">
                            <figure class="app_img">
                                <a href="#"><img src="{{ asset('assets/img/icon/icon-appstore.png') }}" alt=""></a>
                            </figure>
                            <figure class="app_img">
                                <a href="#"><img src="{{ asset('assets/img/icon/icon-googleplay.png') }}" alt=""></a>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-5">
                    <div class="widgets_container widget_menu">
                        <h3>Thông tin</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">Về chúng tôi</a></li>
                                <li><a href="#">Thông tin giao hàng</a></li>
                                <li><a href="#">Sản phẩm mới</a></li>
                                <li><a href="#">Bán chạy nhất</a></li>
                                <li><a href="#">Tài khoản của tôi</a></li>
                                <li><a href="#">Lịch sử đơn hàng</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="widgets_container widget_menu">
                        <h3>Tài khoản của tôi</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">Tài khoản của tôi</a></li>
                                <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                                <li><a href="#">Danh sách yêu thích</a></li>
                                <li><a href="#">Giá giảm</a></li>
                                <li><a href="#">Lịch sử đơn hàng</a></li>
                                <li><a href="#">Đơn hàng quốc tế</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-5 col-sm-6">
                    <div class="widgets_container widget_menu">
                        <h3>Dịch vụ khách hàng</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">Sitemap</a></li>
                                <li><a href="#">Tài khoản của tôi</a></li>
                                <li><a href="#">Thông tin giao hàng</a></li>
                                <li><a href="#">Lịch sử đơn hàng</a></li>
                                <li><a href="#">Danh sách yêu thích</a></li>
                                <li><a href="#">Khuyến mãi đặc biệt</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-7 col-sm-12">
                    <div class="widgets_container">
                        <h3>THÔNG TIN LIÊN HỆ</h3>
                        <div class="footer_contact">
                            <div class="footer_contact_inner">
                                <div class="contact_icone">
                                    <img src="{{ asset('assets/img/icon/icon-phone.png') }}" alt="">
                                </div>
                                <div class="contact_text">
                                    <p>Hotline miễn phí 24/24: <br> <strong>0123456789</strong></p>
                                </div>
                            </div>
                            <p>Địa chỉ của bạn tại đây. <br> contact@techstore.com</p>
                        </div>
                        <div class="footer_social">
                            <ul>
                                <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="copyright_area">
                        <p>&copy; {{ date('Y') }} <a href="{{ route('home') }}" class="text-uppercase">TECH STORE</a>. Made with <i class="fa fa-heart"></i></p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer_payment text-right">
                        <img src="{{ asset('assets/img/icon/payment.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer area end-->

