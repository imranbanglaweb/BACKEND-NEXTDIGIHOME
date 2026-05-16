<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin.dashboard.common.header')
    
    <!-- Premium Dashboard Styling -->
    <!-- Meta Pixel Tracking Component -->
    @include('components.metapixel')

    <!-- Responsive Dashboard CSS -->
    <link href="{{ asset('public/css/responsive-dashboard.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-color: #00d4aa;
            --primary-light: #00b894;
            --secondary-color: #8b5cf6;
            --accent-color: #ff6b6b;
            --sidebar-bg: #0f0f12;
            --sidebar-dark: #1a1a1f;
            --header-bg: #ffffff;
            --content-bg: #f8fafc;
            --text-color: #1e293b;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--content-bg);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        /* Wrapper Layout */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Premium Styling */
        .sidebar-left {
            width: 260px;
            background: linear-gradient(180deg, var(--sidebar-dark) 0%, var(--sidebar-bg) 100%);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            box-shadow: var(--shadow-lg);
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-left.collapsed {
            width: 70px;
        }
        
        .sidebar-collapsed .sidebar-left {
            width: 70px;
        }
        
        .sidebar-collapsed .body {
            margin-left: 70px;
        }
        
        .body {
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }
        
        .sidebar-left .sidebar-header {
            /* padding: 20px; */
            background: rgba(0,0,0,0.15);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 10;
        }
        
        .sidebar-left .sidebar-title {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-left .logo {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-left .logo img {
            max-height: 50px;
            max-width: 180px;
            width: auto;
        }
        
        .sidebar-left .sidebar-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.7);
            cursor: pointer;
            font-size: 18px;
            transition: var(--transition);
        }
        
        .sidebar-left .sidebar-toggle:hover {
            color: #fff;
        }
        
        .sidebar-left .sidebar-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 15px 0;
        }
        
        .sidebar-left .nav-main {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-left .nav-main > li {
            /* margin: 2px 10px; */
        }
        
        .sidebar-left .nav-main > li > a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            border-radius: 6px;
            transition: var(--transition);
            gap: 12px;
        }
        
        .sidebar-left .nav-main > li > a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        
        .sidebar-left .nav-main > li.nav-active > a {
            background: var(--primary-light);
            color: #fff;
            box-shadow: var(--shadow-md);
        }
        
        .sidebar-left .nav-main > li > a i:not(.arrow) {
            width: 20px;
            text-align: center;
            font-size: 18px;
        }
        
        .sidebar-left .nav-main > li > a .arrow {
            font-size: 10px;
            width: 16px;
            transition: transform 0.3s ease;
        }
        
        .sidebar-left .nav-parent.nav-expanded > a .arrow {
            transform: rotate(90deg);
        }
        
        .sidebar-left .nav-main > li > a span {
            display: inline-block;
            transition: opacity 0.3s ease;
        }
        
        /* Hide header content but keep toggle button when collapsed */
        .sidebar-collapsed .sidebar-left .sidebar-header {
            /* padding: 10px; */
        }
        
        .sidebar-collapsed .sidebar-left .sidebar-title {
            display: none;
        }
        
        .sidebar-collapsed .sidebar-left .sidebar-toggle {
            position: relative;
            right: auto;
            top: auto;
            transform: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 40px;
        }
        
        .sidebar-collapsed .sidebar-left .sidebar-toggle i {
            font-size: 20px;
        }
        
        .sidebar-collapsed .sidebar-left .nav-main > li > a span,
        .sidebar-collapsed .sidebar-left .nav-main > li > a .arrow {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }
        
        .sidebar-collapsed .sidebar-left .nav-main > li > a {
            justify-content: center;
            padding: 12px;
        }
        
        .sidebar-collapsed .sidebar-left .nav-main > li > a i:not(.arrow) {
            margin: 0;
        }
        
        .sidebar-left .nav-children {
            list-style: none;
            padding: 0;
            margin: 0;
            display: none;
            background: rgba(0,0,0,0.1);
            border-radius: 6px;
            margin-top: 5px;
        }
        
        .sidebar-left .nav-children.show {
            display: block;
        }
        
        .sidebar-left .nav-children > li > a {
            display: flex;
            align-items: center;
            padding: 10px 15px 10px 45px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: var(--transition);
            gap: 10px;
        }
        
        .sidebar-left .nav-children > li > a:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        
        .sidebar-left .nav-children > li.nav-active > a {
            background: rgba(52, 152, 219, 0.3);
            color: #fff;
        }
        
        .sidebar-left .nav-children > li > a i {
            width: 16px;
            text-align: center;
            font-size: 14px;
        }
        
        .sidebar-left .nav-parent > a .fa-chevron-right {
            margin-left: auto;
            font-size: 10px;
            transition: var(--transition);
        }
        
        .sidebar-left .nav-parent.nav-expanded > a .fa-chevron-right {
            transform: rotate(90deg);
        }
        
        /* Main Content Area */
        .body {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Header Styling */
        .header {
            background: var(--header-bg);
            padding: 15px 25px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid var(--border-color);
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-color);
            cursor: pointer;
        }
        
        .header-search {
            display: flex;
            align-items: center;
            background: var(--content-bg);
            border-radius: 8px;
            padding: 8px 15px;
            gap: 10px;
        }
        
        .header-search input {
            border: none;
            background: transparent;
            outline: none;
            width: 250px;
            font-size: 14px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background: var(--content-bg);
            color: var(--text-light);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            position: relative;
            text-decoration: none;
        }
        
        .header-icon-btn:hover {
            background: var(--border-color);
            color: var(--text-color);
        }
        
        .header-icon-btn .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--accent-color);
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .user-dropdown:hover {
            background: var(--content-bg);
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-color);
        }
        
        .user-role {
            font-size: 12px;
            color: var(--text-light);
        }
        
        /* Content Area */
        .page-header {
            background: #fff;
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .page-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--text-light);
        }
        
        .page-breadcrumb a {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .page-breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .page-content {
            padding: 0 25px 25px;
            flex: 1;
        }
        
        /* Card Styling */
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            margin-bottom: 20px;
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-color);
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Loader */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #1e3a5f 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        
        #loader::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(236, 72, 153, 0.1) 0%, transparent 40%);
            animation: ambientGlow 8s ease-in-out infinite;
        }
        
        @keyframes ambientGlow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.02); }
        }
        
        #loader.fade-out {
            opacity: 0;
            visibility: hidden;
        }
        
        .animate_loader {
            width: 70px;
            height: 70px;
            border: 3px solid transparent;
            border-top-color: #6366f1;
            border-right-color: #a855f7;
            border-bottom-color: #ec4899;
            border-left-color: #f43f5e;
            border-radius: 50%;
            animation: spin 1s linear infinite, borderGlow 2s linear infinite;
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.4), 0 0 60px rgba(168, 85, 247, 0.2), inset 0 0 20px rgba(255, 255, 255, 0.1);
        }
        
        .loader-title {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-top: 40px;
            text-align: center;
            animation: fadeInUp 0.6s ease-out, textShimmer 3s ease-in-out infinite;
            text-shadow: 0 0 40px rgba(129, 140, 248, 0.3);
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }
        
        @keyframes textShimmer {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2); }
        }
        
        .loader-description {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 12px;
            text-align: center;
            animation: fadeInUp 0.6s ease-out 0.2s both;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }
        
        .loader-logo {
            width: 100px;
            height: 100px;
            border-radius: 24px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #d946ef);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 
                0 20px 60px rgba(99, 102, 241, 0.4),
                0 0 0 4px rgba(99, 102, 241, 0.1),
                inset 0 2px 10px rgba(255, 255, 255, 0.2);
            animation: logoFloat 3s ease-in-out infinite, logoGlow 2s ease-in-out infinite;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        
        .loader-logo img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.95);
            padding: 8px;
        }
        
        .loader-logo i {
            font-size: 48px;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes logoGlow {
            0%, 100% { box-shadow: 0 20px 60px rgba(99, 102, 241, 0.4), 0 0 0 4px rgba(99, 102, 241, 0.1), inset 0 2px 10px rgba(255, 255, 255, 0.2); }
            50% { box-shadow: 0 20px 60px rgba(168, 85, 247, 0.5), 0 0 0 4px rgba(168, 85, 247, 0.1), inset 0 2px 10px rgba(255, 255, 255, 0.2); }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @keyframes borderGlow {
            0% { box-shadow: 0 0 30px rgba(99, 102, 241, 0.4), 0 0 60px rgba(168, 85, 247, 0.2), inset 0 0 20px rgba(255, 255, 255, 0.1); }
            33% { box-shadow: 0 0 30px rgba(168, 85, 247, 0.4), 0 0 60px rgba(236, 72, 153, 0.2), inset 0 0 20px rgba(255, 255, 255, 0.1); }
            66% { box-shadow: 0 0 30px rgba(236, 72, 153, 0.4), 0 0 60px rgba(244, 63, 94, 0.2), inset 0 0 20px rgba(255, 255, 255, 0.1); }
            100% { box-shadow: 0 0 30px rgba(99, 102, 241, 0.4), 0 0 60px rgba(168, 85, 247, 0.2), inset 0 0 20px rgba(255, 255, 255, 0.1); }
        }
        
        /* Dropdown Menu */
        .dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            min-width: 200px;
            z-index: 1000;
            display: none;
        }
        
        .dropdown.open .dropdown-menu {
            display: block;
        }
        
        .dropdown-menu .dropdown-header {
            padding: 12px 15px;
            font-weight: 600;
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
        }
        
        .dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
            gap: 10px;
        }
        
        .dropdown-menu .dropdown-item:hover {
            background: var(--content-bg);
        }
        
        .dropdown-menu .dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 5px 0;
        }
        
         /* Mobile Responsive - Enhanced */
        @media (max-width: 1200px) {
            .sidebar-left {
                width: 240px;
            }
            
            .body {
                margin-left: 240px;
            }
            
            .sidebar-left.collapsed,
            .sidebar-collapsed .sidebar-left {
                width: 60px;
            }
            
            .sidebar-collapsed .body {
                margin-left: 60px;
            }
        }
        
        @media (max-width: 992px) {
            .sidebar-left {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1050;
            }
            
            .sidebar-left.show {
                transform: translateX(0);
            }
            
            .body {
                margin-left: 0 !important;
            }
            
            .sidebar-left.collapsed,
            .sidebar-left.show {
                width: 260px;
            }
            
            .sidebar-left.show + .overlay {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                padding: 12px 15px;
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .header-left {
                gap: 10px;
            }
            
            .header-search {
                display: none;
            }
            
            .header-toggle {
                display: block;
                font-size: 18px;
                width: 36px;
                height: 36px;
            }
            
            .page-header {
                padding: 15px;
                margin-bottom: 15px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .page-content {
                padding: 0 15px 15px;
            }
            
            .card {
                margin-bottom: 15px;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .user-info {
                display: none;
            }
            
            .header-right {
                gap: 8px;
            }
            
            .header-icon-btn {
                width: 36px;
                height: 36px;
            }
            
            /* Dashboard Cards Stack on Mobile */
            .row > [class*="col-"] {
                margin-bottom: 15px;
            }
            
            /* Stats cards */
            .stat-card {
                margin-bottom: 15px;
            }
            
            /* Table responsive wrapper */
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            /* Form elements */
            .form-control, .form-select {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            /* Buttons */
            .btn {
                font-size: 14px;
                padding: 8px 16px;
            }
            
            .btn-lg {
                padding: 12px 20px;
                font-size: 16px;
            }
            
            /* Toast notifications */
            .toast {
                width: calc(100% - 30px);
                margin: 10px;
            }
        }
        
        @media (max-width: 576px) {
            .header {
                padding: 10px 12px;
            }
            
            .page-header {
                padding: 12px 10px;
            }
            
            .page-title {
                font-size: 18px;
            }
            
            .page-breadcrumb {
                font-size: 12px;
            }
            
            .page-content {
                padding: 0 10px 10px;
            }
            
            .card-header {
                padding: 12px 15px;
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
            
            .card-body {
                padding: 12px;
            }
            
            /* Compact badges */
            .badge {
                font-size: 10px;
                padding: 3px 6px;
            }
            
            /* Small screen table adjustments */
            table {
                font-size: 13px;
            }
            
            table th,
            table td {
                padding: 8px 6px;
            }
            
            /* Hide less important columns on very small screens */
            .table-responsive th:not(:nth-child(1)),
            .table-responsive td:not(:nth-child(1)) {
                min-width: 60px;
            }
        }
        
        /* Large screen optimization */
        @media (min-width: 1400px) {
            .sidebar-left {
                width: 280px;
            }
            
            .body {
                margin-left: 280px;
            }
            
            .sidebar-left.collapsed,
            .sidebar-collapsed .sidebar-left {
                width: 70px;
            }
            
            .sidebar-collapsed .body {
                margin-left: 70px;
            }
        }
        
        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            /* Larger touch targets for mobile */
            .nav-main > li > a {
                padding: 15px;
                min-height: 48px;
            }
            
            .nav-children > li > a {
                padding: 12px 15px 12px 45px;
                min-height: 44px;
            }
            
            .dropdown-item {
                padding: 12px 15px;
                min-height: 48px;
            }
            
            .header-icon-btn {
                width: 44px;
                height: 44px;
            }
            
            /* Remove hover-only effects */
            .sidebar-left .nav-main > li > a:hover {
                background: rgba(255,255,255,0.1);
            }
            
            /* Better tap feedback */
            .sidebar-left .nav-main > li > a:active,
            .dropdown-item:active,
            .header-icon-btn:active {
                opacity: 0.7;
                transform: scale(0.98);
            }
        }
        
        /* High DPI screens */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .card {
                border-width: 1px;
            }
            
            .sidebar-left {
                box-shadow: 0 0 30px rgba(0,0,0,0.15);
            }
        }
        
        /* Reduced motion preference */
        @media (prefers-reduced-motion: reduce) {
            .sidebar-left,
            .body,
            .header-toggle,
            .dropdown-menu {
                transition: none !important;
            }
            
            .animate_loader {
                animation: none;
            }
            
            .loader-logo {
                animation: none;
            }
        }
        
        /* Print styles */
        @media print {
            .sidebar-left,
            .header,
            .header-toggle,
            .dropdown-menu {
                display: none !important;
            }
            
            .body {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            
            .page-content {
                padding: 0 !important;
            }
            
            .card {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
            }
            
            .header-icon-btn {
                display: none;
            }
        }
        
        /* Language Switcher Header Styles */
        .language-dropdown {
            display: inline-block;
        }
        
        .language-toggle {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background: var(--content-bg);
            color: var(--text-light);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            position: relative;
            text-decoration: none;
        }
        
        .language-toggle:hover {
            background: var(--border-color);
            color: var(--text-color);
        }
        
        .language-dropdown .dropdown-menu {
            min-width: 200px;
            z-index: 1000;
        }
        
        .language-item {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            transition: all 0.3s;
        }
        
        .language-item:hover {
            background-color: #f8f9fa;
        }
        
        .language-item.active {
            background-color: #e9ecef;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .user-info {
                display: none;
            }
        }
        
        /* Scrollbar Styling */
        .sidebar-left::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar-left::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        
        .sidebar-left::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }
        
        .sidebar-left::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div id="loader">
            @if(!empty($settings->admin_logo))
            <div class="loader-logo">
                <img src="{{ asset('public/admin_resource/assets/images/'.$settings->admin_logo) }}" alt="Logo">
            </div>
            @endif
            <div class="animate_loader"></div>
            <div class="loader-title">{{ $settings->admin_title ?? 'Transport Management System' }}</div>
            <div class="loader-description">{{ $settings->admin_description ?? 'Fleet Management Solution' }}</div>
        </div>
        
        <!-- Sidebar -->
        @include('admin.dashboard.common.sidebar')
        
        <!-- Main Content -->
        <section class="body">
            <!-- Mobile Sidebar Toggle -->
            <button class="mobile-sidebar-toggle" onclick="toggleMobileSidebar()" aria-label="Toggle navigation menu">
                <i class="fa fa-bars"></i>
            </button>
            
            <!-- Sidebar Overlay -->
            <div class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>
            
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button class="header-toggle" onclick="toggleSidebar()">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="header-search">
                        <i class="fa fa-search" style="color: var(--text-light);"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Reload Button -->
                    <a class="header-icon-btn" href="javascript:location.reload();" title="Reload Page">
                        <i class="fa fa-sync-alt"></i>
                    </a>
                    
                    <!-- Language Switcher -->
                    @auth
                    @include('admin.dashboard.languages.language-switcher')
                    @endauth
                    
                    <!-- Notifications -->
                    @auth
                    @php
                    $notifications = auth()->user()->unreadNotifications()->limit(10)->get();
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp
                    
                    <div class="dropdown" id="notificationDropdown">
                        <a class="header-icon-btn" href="#" onclick="toggleDropdown('notificationDropdown'); return false;">
                            <i class="fa fa-bell"></i>
                            @if($unreadCount > 0)
                                <span class="badge">{{ $unreadCount }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-header">Notifications</div>
                            @forelse($notifications as $note)
                                <a href="#" class="dropdown-item" onclick="markNotificationAsRead('{{ $note->id }}'); return true;">
                                    <strong>{{ $note->data['title'] ?? 'New Notification' }}</strong>
                                    <small class="text-muted d-block">{{ $note->created_at->diffForHumans() }}</small>
                                </a>
                            @empty
                                <div class="dropdown-item text-muted text-center">No notifications</div>
                            @endforelse
                        </div>
                    </div>
                    @endauth
                    
                    @auth
                    <!-- User Menu -->
                    <div class="dropdown" id="userDropdown">
                        <a class="user-dropdown" href="#" onclick="toggleDropdown('userDropdown'); return false;">
                            @php
                                $userImage = Auth::user()->user_image;
                                $userImagePath = public_path('admin_resource/assets/images/user_image/' . $userImage);
                                $hasUserImage = !empty($userImage) && file_exists($userImagePath);
                            @endphp
                            @if($hasUserImage)
                                <img src="{{ asset('public/admin_resource/assets/images/user_image/'.Auth::user()->user_image) }}" class="user-avatar" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                            @else
                                <div class="user-avatar">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                            @endif
                            <div class="user-info">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">{{ Auth::user()->role ?? 'User' }}</span>
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('user-profile') }}" class="dropdown-item">
                                <i class="fa fa-user"></i> My Profile
                            </a>
                            @auth
                            @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                            <a href="{{ route('settings.index') }}" class="dropdown-item">
                                <i class="fa fa-cog"></i> Settings
                            </a>
                            @endif
                            @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Transport'))
                            <a href="{{ route('pricing') }}" class="dropdown-item">
                                <i class="fa fa-credit-card"></i> Subscription Plan
                            </a>
                            @endif
                            @endauth
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>
            
            <!-- start: content -->
            @yield('main_content')
            <!-- end: content -->
            
            <!-- start: footer -->
            {{-- @include('admin.dashboard.common.footer') --}}
            <!-- end: footer -->
        </section>
    </div>

    <!-- Vendor -->
    <script src="{{ asset('public/admin_resource/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    
    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('public/admin_resource/assets/javascripts/theme.js') }}"></script>
    
    <!-- Custom -->
    <script src="{{ asset('public/admin_resource/assets/javascripts/theme.custom.js') }}"></script>
    
    <!-- Initializations -->
    <script src="{{ asset('public/admin_resource/assets/javascripts/theme.init.js') }}"></script>
    
    @stack('scripts')
    
    <script>
        // Loader - with fallback for cases where load event might not fire
        function hideLoader() {
            var loader = document.getElementById('loader');
            if (loader) {
                loader.classList.add('fade-out');
                setTimeout(function() {
                    loader.style.display = 'none';
                }, 400);
            }
        }
        
        // Try window load event first
        window.addEventListener('load', function() {
            setTimeout(hideLoader, 500);
        });
        
        // Fallback: hide loader after a timeout even if load event doesn't fire
        setTimeout(hideLoader, 2000);
        
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            document.querySelector('.sidebar-left').classList.toggle('show');
        }
        
        // Sidebar Collapse
        function toggleSidebarCollapse() {
            document.body.classList.toggle('sidebar-collapsed');
        }
        
        // Menu Toggle
        function toggleMenu(element) {
            var parent = element.closest('.nav-parent');
            var children = parent.querySelector('.nav-children');
            if (children) {
                children.classList.toggle('show');
                parent.classList.toggle('nav-expanded');
            }
        }
        
        // Dropdown Toggle
        function toggleDropdown(id) {
            var dropdown = document.getElementById(id);
            dropdown.classList.toggle('open');
            
            // Close other dropdowns
            document.querySelectorAll('.dropdown').forEach(function(d) {
                if (d.id !== id) {
                    d.classList.remove('open');
                }
            });
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown').forEach(function(d) {
                    d.classList.remove('open');
                });
            }
        });
        
        // Mark notification as read
        function markNotificationAsRead(notificationId) {
            fetch('/notifications/mark-read/' + notificationId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                }
            });
        }
    </script>
</body>
</html>
