<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Tech Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary-color: #0ea5e9;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --sidebar-bg: #ffffff;
            --sidebar-hover: #f0f9ff;
            --border-color: #e5e7eb;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
        }

        body {
            background-color: #f9fafb;
            color: var(--text-primary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
        }

        .sidebar-header h4 {
            color: white;
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .nav-link {
            color: var(--text-primary);
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-menu .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
        }

        .sidebar-menu .nav-link.active {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            color: white;
        }

        .sidebar-menu .nav-link i {
            font-size: 1.1rem;
            width: 20px;
        }

        .main-content {
            margin-left: 260px;
            padding: 2rem;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            margin: -2rem -2rem 2rem -2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-primary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .menu-toggle:hover {
            background-color: var(--sidebar-hover);
        }

        .user-dropdown .dropdown-toggle {
            color: var(--text-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .user-dropdown .dropdown-toggle:hover {
            background-color: var(--sidebar-hover);
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }

        .card:hover {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #1d4ed8 0%, #0284c7 100%);
        }

        .table {
            background: white;
        }

        .table thead {
            background-color: #f9fafb;
        }

        .badge {
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
            font-weight: 500;
        }

        /* Toast Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 400px;
            width: 100%;
        }

        .toast {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid;
            animation: slideInRight 0.3s ease-out;
            position: relative;
            overflow: hidden;
        }

        .toast::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: currentColor;
            width: 100%;
            animation: toastProgress 5s linear forwards;
        }

        .toast.success {
            border-left-color: var(--success-color);
            color: var(--success-color);
        }

        .toast.error {
            border-left-color: var(--danger-color);
            color: var(--danger-color);
        }

        .toast.warning {
            border-left-color: var(--warning-color);
            color: var(--warning-color);
        }

        .toast.info {
            border-left-color: var(--info-color);
            color: var(--info-color);
        }

        .toast-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .toast.success .toast-icon {
            background: rgba(16, 185, 129, 0.1);
        }

        .toast.error .toast-icon {
            background: rgba(239, 68, 68, 0.1);
        }

        .toast.warning .toast-icon {
            background: rgba(245, 158, 11, 0.1);
        }

        .toast.info .toast-icon {
            background: rgba(6, 182, 212, 0.1);
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
            color: var(--text-primary);
        }

        .toast-message {
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.25rem;
            line-height: 1;
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .toast-close:hover {
            color: var(--text-primary);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        @keyframes toastProgress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }

        .toast.hiding {
            animation: slideOutRight 0.3s ease-out forwards;
        }

        /* Tablet styles (768px - 1024px) */
        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }
            .main-content {
                margin-left: 240px;
                padding: 1.5rem;
            }
            .topbar {
                padding: 1rem 1.5rem;
            }
        }

        /* Mobile styles (max 768px) */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .topbar {
                padding: 1rem;
                margin: -1rem -1rem 1rem -1rem;
                flex-wrap: wrap;
                gap: 1rem;
            }
            .menu-toggle {
                display: block;
            }
            .topbar h5 {
                font-size: 1.1rem;
            }
            .user-dropdown .dropdown-toggle span {
                display: none;
            }
            .card-header {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
            .table {
                font-size: 0.875rem;
            }
            .table th,
            .table td {
                padding: 0.5rem;
            }
            .btn {
                padding: 0.4rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* Small mobile (max 576px) */
        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
            }
            .main-content {
                padding: 0.75rem;
            }
            .topbar {
                padding: 0.75rem;
                margin: -0.75rem -0.75rem 0.75rem -0.75rem;
            }
            .topbar h5 {
                font-size: 1rem;
            }
            .card {
                border-radius: 0.5rem;
            }
            .card-header {
                padding: 0.75rem;
            }
            .table-responsive {
                font-size: 0.8rem;
            }
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
            .toast {
                padding: 0.875rem 1rem;
            }
            .toast-icon {
                width: 35px;
                height: 35px;
                font-size: 1.1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-shop"></i> Tech Store</h4>
        </div>
        <nav class="sidebar-menu">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            
            <div class="sidebar-divider px-3 py-2">
                <small class="text-muted text-uppercase">Sản phẩm</small>
            </div>
            <a class="nav-link {{ request()->routeIs('admin.danhmuc.*') ? 'active' : '' }}" href="{{ route('admin.danhmuc.index') }}">
                <i class="bi bi-folder"></i>
                <span>Danh mục</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.thuonghieu.*') ? 'active' : '' }}" href="{{ route('admin.thuonghieu.index') }}">
                <i class="bi bi-bookmark-star"></i>
                <span>Thương hiệu</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.thuoctinh.*') ? 'active' : '' }}" href="{{ route('admin.thuoctinh.index') }}">
                <i class="bi bi-sliders"></i>
                <span>Thuộc tính</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.sanpham.*') ? 'active' : '' }}" href="{{ route('admin.sanpham.index') }}">
                <i class="bi bi-box"></i>
                <span>Sản phẩm</span>
            </a>
            
            <div class="sidebar-divider px-3 py-2">
                <small class="text-muted text-uppercase">Bán hàng</small>
            </div>
            <a class="nav-link {{ request()->routeIs('admin.donhang.*') ? 'active' : '' }}" href="{{ route('admin.donhang.index') }}">
                <i class="bi bi-cart-check"></i>
                <span>Đơn hàng</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.magiamgia.*') ? 'active' : '' }}" href="{{ route('admin.magiamgia.index') }}">
                <i class="bi bi-ticket-perforated"></i>
                <span>Mã giảm giá</span>
            </a>
            
            <div class="sidebar-divider px-3 py-2">
                <small class="text-muted text-uppercase">Kho hàng</small>
            </div>
            <a class="nav-link {{ request()->routeIs('admin.phieunhap.*') ? 'active' : '' }}" href="{{ route('admin.phieunhap.index') }}">
                <i class="bi bi-box-arrow-in-down"></i>
                <span>Nhập hàng</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.nhacungcap.*') ? 'active' : '' }}" href="{{ route('admin.nhacungcap.index') }}">
                <i class="bi bi-building"></i>
                <span>Nhà cung cấp</span>
            </a>
            
            <div class="sidebar-divider px-3 py-2">
                <small class="text-muted text-uppercase">Khách hàng</small>
            </div>
            <a class="nav-link {{ request()->routeIs('admin.nguoidung.*') ? 'active' : '' }}" href="{{ route('admin.nguoidung.index') }}">
                <i class="bi bi-people"></i>
                <span>Người dùng</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.danhgia.*') ? 'active' : '' }}" href="{{ route('admin.danhgia.index') }}">
                <i class="bi bi-star-half"></i>
                <span>Đánh giá</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.baohanh.*') ? 'active' : '' }}" href="{{ route('admin.baohanh.index') }}">
                <i class="bi bi-shield-check"></i>
                <span>Bảo hành</span>
            </a>
            
            <div class="sidebar-divider px-3 py-2">
                <small class="text-muted text-uppercase">Hệ thống</small>
            </div>
            <a class="nav-link {{ request()->routeIs('admin.nhatky.*') ? 'active' : '' }}" href="{{ route('admin.nhatky.index') }}">
                <i class="bi bi-clock-history"></i>
                <span>Nhật ký</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.thongke.*') ? 'active' : '' }}" href="{{ route('admin.thongke.index') }}">
                <i class="bi bi-graph-up"></i>
                <span>Thống kê</span>
            </a>
        </nav>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-toggle" id="menuToggle" type="button">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
            </div>
            <div class="user-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ Auth::guard('admin')->user()->ten }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Toast Container -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- Alerts (Fallback for errors) -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toast Notification System
        function showToast(message, type = 'success', duration = 5000) {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) {
                console.error('Toast container not found!');
                return;
            }

            if (!message || message.trim() === '') {
                console.error('Toast message is empty!');
                return;
            }

            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            const icons = {
                success: 'bi-check-circle-fill',
                error: 'bi-x-circle-fill',
                warning: 'bi-exclamation-triangle-fill',
                info: 'bi-info-circle-fill'
            };

            const titles = {
                success: 'Thành công',
                error: 'Lỗi',
                warning: 'Cảnh báo',
                info: 'Thông tin'
            };

            toast.innerHTML = `
                <div class="toast-icon">
                    <i class="bi ${icons[type] || icons.success}"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${titles[type] || titles.success}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="removeToast(this.closest('.toast'))">
                    <i class="bi bi-x"></i>
                </button>
            `;

            toastContainer.appendChild(toast);

            // Trigger animation
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateX(0)';
            }, 10);

            // Auto remove after duration
            let timer = setTimeout(() => {
                removeToast(toast);
            }, duration);

            // Pause on hover
            toast.addEventListener('mouseenter', () => {
                clearTimeout(timer);
            });

            toast.addEventListener('mouseleave', () => {
                timer = setTimeout(() => {
                    removeToast(toast);
                }, duration);
            });
        }

        function removeToast(toast) {
            toast.classList.add('hiding');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }

        // Make showToast available globally
        window.showToast = showToast;
        window.removeToast = removeToast;

        // Function to show session flash messages
        function showSessionToasts() {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) {
                console.error('Toast container not found');
                return;
            }

            @if(session('success'))
                showToast('{{ addslashes(session('success')) }}', 'success');
            @endif

            @if(session('error'))
                showToast('{{ addslashes(session('error')) }}', 'error');
            @endif

            @if(session('warning'))
                showToast('{{ addslashes(session('warning')) }}', 'warning');
            @endif

            @if(session('info'))
                showToast('{{ addslashes(session('info')) }}', 'info');
            @endif
        }

        // Show toasts when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(showSessionToasts, 300);
            });
        } else {
            // DOM is already ready
            setTimeout(showSessionToasts, 300);
        }

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar when clicking on a link (mobile)
        if (window.innerWidth <= 768) {
            const navLinks = document.querySelectorAll('.sidebar-menu .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            });
        }

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
