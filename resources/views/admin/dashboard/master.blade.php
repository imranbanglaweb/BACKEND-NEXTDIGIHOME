<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin.dashboard.common.header')
    
    <!-- Premium Dashboard Styling -->
    <!-- Meta Pixel Tracking Component -->
    @include('components.metapixel')

    <script>
        (function() {
            function isOpenDialogPresent() {
                return document.querySelector('.modal.show, .modal.in, .swal2-popup.swal2-show, .mfp-wrap.mfp-ready');
            }

            function removeElement(element) {
                if (element && element.parentNode) {
                    element.parentNode.removeChild(element);
                }
            }

            function disableStaleFullScreenBlockers() {
                var loader = document.getElementById('loader');
                var sidebar = document.querySelector('.sidebar-left');
                var overlay = document.querySelector('.sidebar-overlay');
                var hasOpenDialog = isOpenDialogPresent();

                if (loader && (loader.classList.contains('fade-out') || loader.classList.contains('is-hidden'))) {
                    loader.style.pointerEvents = 'none';
                    loader.classList.add('is-hidden');
                }

                if (overlay && (!sidebar || !sidebar.classList.contains('show'))) {
                    overlay.classList.remove('show');
                    overlay.style.pointerEvents = 'none';
                }

                if (!hasOpenDialog) {
                    if (document.body && (document.body.classList.contains('modal-open') || document.body.classList.contains('swal2-shown'))) {
                        document.body.classList.remove('modal-open', 'swal2-shown', 'swal2-height-auto');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                        document.querySelectorAll('.modal-backdrop, .swal2-container:empty, .mfp-bg, .mfp-wrap').forEach(removeElement);
                    }
                }
            }

            window.recoverDashboardInput = disableStaleFullScreenBlockers;
            document.addEventListener('DOMContentLoaded', disableStaleFullScreenBlockers);
            window.addEventListener('pageshow', disableStaleFullScreenBlockers);
        })();
    </script>

    <!-- Responsive Dashboard CSS -->
    <link href="{{ asset('public/css/responsive-dashboard.css') }}" rel="stylesheet">

    <style>
        /* Mobile toggle - strictly hidden on desktop */
        .mobile-sidebar-toggle {
            display: none !important;
        }
        @media (max-width: 991.98px) {
            .mobile-sidebar-toggle {
                display: flex !important;
            }
        }
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
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--content-bg);
            color: var(--text-color);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Wrapper Layout */
        .wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        
        /* Main Layout Base */
        .sidebar-left {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            z-index: 1000;
            transition: width 0.25s cubic-bezier(0.16, 1, 0.3, 1), transform 0.25s ease;
        }

        .sidebar-collapsed .sidebar-left {
            width: 72px !important;
        }

        .body {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            background: #f8fafc;
            transition: margin-left 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .sidebar-collapsed .body {
            margin-left: 72px !important;
        }

        @media (max-width: 991.98px) {
            .sidebar-left {
                transform: translateX(-100%);
                width: 270px !important;
            }
            .sidebar-left.show {
                transform: translateX(0);
            }
            .body,
            .sidebar-collapsed .body {
                margin-left: 0 !important;
            }
        }

        /* Top Header Styling */
        .header {
            background: #ffffff;
            height: 66px;
            padding: 0 20px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 990;
            border-bottom: 1px solid #e2e8f0;
            backdrop-filter: blur(8px);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .header-toggle {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .header-toggle:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        /* Top Header Brand (Shown on mobile & collapsed mode, or as sleek pill) */
        .header-brand {
            display: none;
            align-items: center;
            gap: 8px;
            text-decoration: none !important;
            padding: 5px 12px 5px 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .header-brand:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .header-brand-emblem {
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .header-brand-title {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.3px;
            white-space: nowrap;
        }

        .header-brand-accent {
            background: linear-gradient(135deg, #00d4aa 0%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Show header brand when sidebar is collapsed or on screens < 992px */
        @media (max-width: 991.98px) {
            .header-brand {
                display: inline-flex !important;
            }
        }
        .sidebar-collapsed .header-brand {
            display: inline-flex !important;
        }

        .header-search {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            padding: 6px 14px;
            gap: 9px;
            transition: all 0.2s ease;
        }

        .header-search:focus-within {
            background: #ffffff;
            border-color: #00d4aa;
            box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.12);
        }

        .header-search input {
            border: none;
            background: transparent;
            outline: none;
            width: 220px;
            font-size: 13.5px;
            color: #0f172a;
            font-family: inherit;
        }

        .header-search input::placeholder {
            color: #94a3b8;
        }

        @media (max-width: 575.98px) {
            .header-search {
                display: none !important;
            }
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .header-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            position: relative;
            text-decoration: none !important;
            font-size: 14px;
        }

        .header-icon-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .header-icon-btn .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(244, 63, 94, 0.5);
            border: 1.5px solid #ffffff;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px 4px 6px;
            border-radius: 9999px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none !important;
        }

        .user-dropdown:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00d4aa 0%, #38bdf8 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            box-shadow: 0 2px 6px rgba(0, 212, 170, 0.25);
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            text-align: left;
        }

        .user-name {
            font-weight: 700;
            font-size: 13px;
            color: #0f172a;
            white-space: nowrap;
        }

        .user-role {
            font-size: 10.5px;
            color: #64748b;
            font-weight: 500;
            white-space: nowrap;
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
        
        /* ==========================================================================
           NEXTDIGIHOME ULTRA-FAST BRAND PRELOADER
           ========================================================================== */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 40%, #0d1424 0%, #060911 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 999999;
            transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.22s ease;
        }

        /* Top High-Velocity Progress Track */
        .ndh-progress-track {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.05);
            z-index: 1000000;
            overflow: hidden;
        }

        .ndh-progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #00d4aa 0%, #38bdf8 50%, #8b5cf6 100%);
            box-shadow: 0 0 14px rgba(56, 189, 248, 0.85);
            transition: width 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Central Glass Card */
        .ndh-loader-card {
            background: rgba(13, 19, 34, 0.82);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 24px;
            padding: 32px 42px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6), 0 0 50px rgba(0, 212, 170, 0.08);
            position: relative;
            transform: translateY(0);
            animation: ndhCardFloat 3s ease-in-out infinite;
        }

        @keyframes ndhCardFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        /* Logo Emblem with Pulse Ring */
        .ndh-loader-emblem-wrap {
            position: relative;
            width: 68px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .ndh-loader-pulse-ring {
            position: absolute;
            inset: -6px;
            border-radius: 20px;
            border: 2px solid transparent;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.4), rgba(56, 189, 248, 0.4), rgba(139, 92, 246, 0.4)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            animation: ndhRingPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes ndhRingPulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.08); opacity: 0.3; }
        }

        .ndh-loader-logo-svg {
            width: 52px;
            height: 52px;
            filter: drop-shadow(0 0 16px rgba(0, 212, 170, 0.5));
        }

        .ndh-loader-title {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.4px;
            color: #ffffff;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .ndh-loader-title .accent {
            background: linear-gradient(135deg, #00d4aa 0%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .ndh-loader-sub {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        /* Micro Loader Indicator */
        .ndh-micro-loader {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ndh-micro-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            animation: ndhDotBounce 1.2s ease-in-out infinite;
        }

        .ndh-micro-dot:nth-child(1) { background: #00d4aa; animation-delay: 0s; }
        .ndh-micro-dot:nth-child(2) { background: #38bdf8; animation-delay: 0.2s; }
        .ndh-micro-dot:nth-child(3) { background: #8b5cf6; animation-delay: 0.4s; }

        @keyframes ndhDotBounce {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.3; }
            40% { transform: scale(1.2); opacity: 1; }
        }

        #loader.fade-out {
            opacity: 0 !important;
            transform: scale(0.985);
            pointer-events: none !important;
        }

        #loader.is-hidden {
            display: none !important;
        }

        .sidebar-overlay:not(.show),
        .modal-backdrop:not(.show),
        .swal2-container:empty,
        .mfp-bg:not(.mfp-ready),
        .mfp-wrap:not(.mfp-ready) {
            pointer-events: none !important;
        }

        /* Inner Page Smooth Structure */
        .content-body {
            transition: opacity 0.2s ease-in-out;
            min-height: calc(100vh - 66px);
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
            <div class="ndh-progress-track">
                <div class="ndh-progress-bar" id="ndhProgressBar"></div>
            </div>
            <div class="ndh-loader-card">
                <div class="ndh-loader-emblem-wrap">
                    <div class="ndh-loader-pulse-ring"></div>
                    @if(!empty($settings->admin_logo))
                        <img src="{{ asset('public/admin_resource/assets/images/'.$settings->admin_logo) }}" alt="Logo" style="width: 52px; height: 52px; object-fit: contain; border-radius: 12px;">
                    @else
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="ndh-loader-logo-svg">
                            <defs>
                                <linearGradient id="ldrPillarLeft" x1="16" y1="8" x2="16" y2="56" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="#00f2fe" />
                                    <stop offset="100%" stop-color="#00d4aa" />
                                </linearGradient>
                                <linearGradient id="ldrDiagFold" x1="16" y1="8" x2="48" y2="56" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="#00f2fe" />
                                    <stop offset="25%" stop-color="#00d4aa" />
                                    <stop offset="75%" stop-color="#8b5cf6" />
                                    <stop offset="100%" stop-color="#ec4899" />
                                </linearGradient>
                                <linearGradient id="ldrPillarRight" x1="48" y1="8" x2="48" y2="56" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="#a855f7" />
                                    <stop offset="100%" stop-color="#6366f1" />
                                </linearGradient>
                                <linearGradient id="ldrSpecular" x1="10" y1="8" x2="30" y2="28" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="#ffffff" stop-opacity="0.9" />
                                    <stop offset="100%" stop-color="#ffffff" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <rect x="42" y="8" width="12" height="48" rx="6" fill="url(#ldrPillarRight)" />
                            <rect x="10" y="8" width="12" height="48" rx="6" fill="url(#ldrPillarLeft)" />
                            <path d="M 10 14 C 10 10.7 12.7 8 16 8 C 17.8 8 19.4 8.8 20.5 10.1 L 47.5 45.9 C 48.6 47.2 49.2 48.8 49.2 50.5 C 49.2 53.5 46.8 56 43.8 56 C 42 56 40.4 55.2 39.3 53.9 L 12.5 18.1 C 10.9 16.9 10 15.6 10 14 Z" fill="url(#ldrDiagFold)" />
                            <path d="M 10 14 C 10 10.7 12.7 8 16 8 C 17.8 8 19.4 8.8 20.5 10.1 L 28 20 L 22 25 L 10 14 Z" fill="url(#ldrSpecular)" opacity="0.75" />
                        </svg>
                    @endif
                </div>
                <div class="ndh-loader-title">Next<span class="accent">DigiHome</span></div>
                <div class="ndh-loader-sub">{{ $settings->admin_title ?? 'Agency Command Center' }}</div>
                <div class="ndh-micro-loader">
                    <span class="ndh-micro-dot"></span>
                    <span class="ndh-micro-dot"></span>
                    <span class="ndh-micro-dot"></span>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        @include('admin.dashboard.common.sidebar')
        
        <!-- Main Content -->
        <section class="body">
            <!-- Mobile Sidebar Toggle -->
            <button class="mobile-sidebar-toggle" onclick="toggleMobileSidebar()" aria-label="Toggle navigation menu" style="display: none;" type="button">
                <i class="fa fa-bars"></i>
            </button>
            
            <!-- Sidebar Overlay -->
            <div class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>
            
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button class="header-toggle" onclick="toggleSidebar()" aria-label="Toggle navigation" type="button">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Header Brand Logo & Name -->
                    <a href="{{ route('home') }}" class="header-brand" title="NextDigiHome">
                        <div class="header-brand-emblem">
                            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 26px; height: 26px;">
                                <defs>
                                    <linearGradient id="hbPillarLeft" x1="16" y1="8" x2="16" y2="56" gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#00f2fe" />
                                        <stop offset="100%" stop-color="#00d4aa" />
                                    </linearGradient>
                                    <linearGradient id="hbDiagFold" x1="16" y1="8" x2="48" y2="56" gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#00f2fe" />
                                        <stop offset="25%" stop-color="#00d4aa" />
                                        <stop offset="75%" stop-color="#8b5cf6" />
                                        <stop offset="100%" stop-color="#ec4899" />
                                    </linearGradient>
                                    <linearGradient id="hbPillarRight" x1="48" y1="8" x2="48" y2="56" gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#a855f7" />
                                        <stop offset="100%" stop-color="#6366f1" />
                                    </linearGradient>
                                    <linearGradient id="hbSpecular" x1="10" y1="8" x2="30" y2="28" gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.9" />
                                        <stop offset="100%" stop-color="#ffffff" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                                <rect x="42" y="8" width="12" height="48" rx="6" fill="url(#hbPillarRight)" />
                                <rect x="10" y="8" width="12" height="48" rx="6" fill="url(#hbPillarLeft)" />
                                <path d="M 10 14 C 10 10.7 12.7 8 16 8 C 17.8 8 19.4 8.8 20.5 10.1 L 47.5 45.9 C 48.6 47.2 49.2 48.8 49.2 50.5 C 49.2 53.5 46.8 56 43.8 56 C 42 56 40.4 55.2 39.3 53.9 L 12.5 18.1 C 10.9 16.9 10 15.6 10 14 Z" fill="url(#hbDiagFold)" />
                                <path d="M 10 14 C 10 10.7 12.7 8 16 8 C 17.8 8 19.4 8.8 20.5 10.1 L 28 20 L 22 25 L 10 14 Z" fill="url(#hbSpecular)" opacity="0.75" />
                            </svg>
                        </div>
                        <span class="header-brand-title">Next<span class="header-brand-accent">DigiHome</span></span>
                    </a>
                    <div class="header-search">
                        <i class="fa fa-search" style="color: #94a3b8; font-size: 13px;"></i>
                        <input type="text" placeholder="Search resources, leads...">
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
        // NextDigiHome High-Velocity Progress & Preloader Controller
        function setProgressBar(percent) {
            var bar = document.getElementById('ndhProgressBar');
            if (bar) {
                bar.style.width = percent + '%';
            }
        }

        // Set quick initial velocity
        setProgressBar(35);
        document.addEventListener('readystatechange', function() {
            if (document.readyState === 'interactive') {
                setProgressBar(75);
            } else if (document.readyState === 'complete') {
                setProgressBar(100);
            }
        });

        function hideLoader() {
            var loader = document.getElementById('loader');
            if (!loader || loader.classList.contains('is-hidden')) {
                return;
            }
            setProgressBar(100);
            loader.style.pointerEvents = 'none';
            loader.classList.add('fade-out');
            setTimeout(function() {
                loader.classList.add('is-hidden');
            }, 220);
        }
        
        function unlockDashboardOverlays() {
            var loader = document.getElementById('loader');
            var sidebar = document.querySelector('.sidebar-left');
            var overlay = document.querySelector('.sidebar-overlay');
            var hasOpenModal = document.querySelector('.modal.show, .modal.in');
            var hasOpenSwal = document.querySelector('.swal2-popup.swal2-show');
            var hasOpenMagnific = document.querySelector('.mfp-wrap.mfp-ready');
            
            if (loader) {
                loader.style.pointerEvents = 'none';
            }
            
            if (sidebar && !sidebar.classList.contains('show')) {
                document.body.style.overflow = '';
                if (overlay) {
                    overlay.classList.remove('show');
                }
            }
            
            if (!hasOpenModal) {
                document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                    backdrop.parentNode.removeChild(backdrop);
                });
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
            }
            
            if (!hasOpenSwal) {
                document.body.classList.remove('swal2-shown', 'swal2-height-auto');
                document.querySelectorAll('.swal2-container').forEach(function(container) {
                    if (!container.querySelector('.swal2-popup.swal2-show')) {
                        container.parentNode.removeChild(container);
                    }
                });
            }
            
            if (!hasOpenMagnific) {
                document.documentElement.classList.remove('mfp-ready', 'mfp-removing');
                document.querySelectorAll('.mfp-bg, .mfp-wrap').forEach(function(popupLayer) {
                    popupLayer.parentNode.removeChild(popupLayer);
                });
            }
        }
        
        // Fast dismissal on DOMContentLoaded with micro requestAnimationFrame
        document.addEventListener('DOMContentLoaded', function() {
            unlockDashboardOverlays();
            setProgressBar(90);
            requestAnimationFrame(function() {
                setTimeout(hideLoader, 60);
            });
        });
        
        window.addEventListener('load', function() {
            unlockDashboardOverlays();
            hideLoader();
        });
        
        window.addEventListener('pageshow', function() {
            unlockDashboardOverlays();
            hideLoader();
        });
        
        // Safety timeout: loader NEVER stays longer than 700ms under any network condition
        setTimeout(hideLoader, 700);
        
        // Responsive Sidebar Toggle
        function toggleSidebar() {
            if (window.innerWidth < 992) {
                toggleMobileSidebar();
            } else {
                toggleSidebarCollapse();
            }
        }
        
        function toggleMobileSidebar() {
            var sidebar = document.querySelector('.sidebar-left');
            var overlay = document.querySelector('.sidebar-overlay');
            if (!sidebar) return;
            sidebar.classList.toggle('show');
            if (overlay) {
                overlay.classList.toggle('show', sidebar.classList.contains('show'));
            }
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }
        
        // Sidebar Collapse (Desktop)
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
