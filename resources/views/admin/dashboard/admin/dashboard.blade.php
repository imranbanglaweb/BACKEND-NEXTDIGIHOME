@extends('admin.dashboard.master')

@section('title', 'Next Digi Home Admin Dashboard')

@php
$user = Auth::user();
@endphp

@section('main_content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-color: #00d4aa;
        --primary-dark: #00b894;
        --primary-light: #26deaa;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #06b6d4;
        --purple-color: #8b5cf6;
        --pink-color: #ec4899;
        --bg-gradient: linear-gradient(135deg, #00d4aa 0%, #8b5cf6 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        --card-shadow-hover: 0 20px 50px rgba(0, 0, 0, 0.15);
        --glass-bg: rgba(255, 255, 255, 0.08);
        --glass-border: rgba(255, 255, 255, 0.15);
        --dark-bg: #0f0f12;
        --card-bg: #1a1a1f;
        --text-primary: #fafafa;
        --text-secondary: #737373;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        margin: 0;
        padding: 0;
    }

    /* Premium Animations */
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }

    @keyframes particle-float {
        0%, 100% {
            transform: translateY(0px) scale(1);
            opacity: 0.6;
        }
        50% {
            transform: translateY(-10px) scale(1.2);
            opacity: 1;
        }
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(0, 212, 170, 0.3);
        }
        50% {
            box-shadow: 0 0 40px rgba(0, 212, 170, 0.6);
        }
    }

    @keyframes slide-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .animate-slide-in-up {
        animation: slide-in-up 0.8s ease-out forwards;
    }
    
    /* Header Section */
    .dashboard-header {
        background: var(--bg-gradient);
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.35);
    }
    
    .dashboard-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .welcome-section h1 {
        color: white;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .welcome-section p {
        color: rgba(255,255,255,0.85);
        font-size: 14px;
        margin: 0;
    }
    
    .admin-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .role-badge {
        background: rgba(255,255,255,0.2);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .header-actions {
        display: flex;
        gap: 12px;
    }
    
    .btn-premium {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary-premium {
        background: white;
        color: var(--primary-color);
    }
    
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }
    
    .btn-outline-premium {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    .btn-outline-premium:hover {
        background: rgba(255,255,255,0.3);
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }
    
    .stat-card.total::before { background: var(--primary-color); }
    .stat-card.pending::before { background: var(--warning-color); }
    .stat-card.approved::before { background: var(--success-color); }
    .stat-card.rejected::before { background: var(--danger-color); }
    .stat-card.vehicle::before { background: var(--purple-color); }
    .stat-card.driver::before { background: var(--info-color); }
    .stat-card.employee::before { background: var(--pink-color); }
    .stat-card.completed::before { background: #10b981; }
    
    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .stat-card.total .stat-icon { background: #e0e7ff; color: var(--primary-color); }
    .stat-card.pending .stat-icon { background: #fef3c7; color: var(--warning-color); }
    .stat-card.approved .stat-icon { background: #d1fae5; color: var(--success-color); }
    .stat-card.rejected .stat-icon { background: #fee2e2; color: var(--danger-color); }
    .stat-card.vehicle .stat-icon { background: #ede9fe; color: var(--purple-color); }
    .stat-card.driver .stat-icon { background: #cffafe; color: var(--info-color); }
    .stat-card.employee .stat-icon { background: #fce7f3; color: var(--pink-color); }
    .stat-card.completed .stat-icon { background: #d1fae5; color: #10b981; }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }
    
    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        margin-top: 10px;
    }
    
    .stat-trend.up { background: #d1fae5; color: var(--success-color); }
    .stat-trend.down { background: #fee2e2; color: var(--danger-color); }
    .stat-trend.neutral { background: #f3f4f6; color: #64748b; }
    
    /* Charts Section */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .chart-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .chart-container {
        height: 250px;
        position: relative;
    }
    
    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
    }
    
    .quick-action-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px;
        border-radius: 12px;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .quick-action-item:hover {
        background: #e0e7ff;
        transform: translateX(5px);
    }
    
    .quick-action-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        background: var(--primary-color);
        color: white;
    }
    
    .quick-action-text h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    
    .quick-action-text p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }
    
    /* System Overview */
    .system-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .system-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        text-align: center;
    }
    
    .system-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 15px;
    }
    
    .system-value {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .system-label {
        font-size: 14px;
        color: #64748b;
    }
    
    /* Table Styles */
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .table-header {
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .table-header h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-premium {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-premium thead th {
        background: #f8fafc;
        padding: 14px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .table-premium tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 14px;
    }
    
    .table-premium tbody tr:hover {
        background: #f8fafc;
    }
    
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-pending { background: #fef3c7; color: #b45309; }
    .badge-approved { background: #d1fae5; color: #047857; }
    .badge-rejected { background: #fee2e2; color: #b91c1c; }
    .badge-completed { background: #cffafe; color: #0e7490; }
    .badge-active { background: #d1fae5; color: #047857; }
    
    /* Action Buttons */
    .btn-view {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        background: var(--primary-color);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-view:hover {
        background: var(--primary-dark);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }
    
    .empty-state-icon {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }
    
    /* ===== PREMIUM DASHBOARD ENHANCEMENTS ===== */

    /* Premium Header */
    .premium-dashboard-header {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(0, 212, 170, 0.1) 0%, rgba(139, 92, 246, 0.1) 50%, rgba(0, 212, 170, 0.05) 100%);
        border-radius: 20px;
        margin-bottom: 30px;
        padding: 40px;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1;
    }

    .float-element {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(0, 212, 170, 0.2), rgba(139, 92, 246, 0.2));
        backdrop-filter: blur(20px);
        animation: float 6s ease-in-out infinite;
    }

    .float-element.float-1 {
        width: 80px;
        height: 80px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }

    .float-element.float-2 {
        width: 60px;
        height: 60px;
        top: 20%;
        right: 15%;
        animation-delay: 2s;
    }

    .float-element.float-3 {
        width: 100px;
        height: 100px;
        bottom: 15%;
        left: 20%;
        animation-delay: 4s;
    }

    .float-element.float-4 {
        width: 70px;
        height: 70px;
        top: 60%;
        right: 10%;
        animation-delay: 1s;
    }

    .float-element.float-5 {
        width: 90px;
        height: 90px;
        bottom: 10%;
        right: 20%;
        animation-delay: 3s;
    }

    .premium-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .premium-header-left {
        flex: 1;
        min-width: 300px;
    }

    .premium-header-icon {
        margin-bottom: 20px;
    }

    .icon-container {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(0, 212, 170, 0.2), rgba(139, 92, 246, 0.2));
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: var(--primary-color);
        position: relative;
        overflow: hidden;
        animation: pulse-glow 3s ease-in-out infinite;
    }

    .icon-glow {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: icon-shine 3s ease-in-out infinite;
    }

    @keyframes icon-shine {
        0%, 100% {
            transform: rotate(0deg);
            opacity: 0;
        }
        50% {
            transform: rotate(180deg);
            opacity: 1;
        }
    }

    .premium-title {
        font-size: 42px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .gradient-text {
        background: linear-gradient(135deg, var(--primary-color), var(--purple-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .subtitle {
        font-size: 24px;
        color: var(--primary-color);
        font-weight: 600;
    }

    .premium-welcome {
        font-size: 16px;
        color: #64748b;
        margin-bottom: 20px;
    }

    .user-name {
        color: var(--primary-color);
        font-weight: 600;
    }

    .premium-stats {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--primary-color);
        display: block;
    }

    .stat-label {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .stat-trend-up {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        color: var(--success-color);
        font-weight: 500;
        margin-top: 5px;
    }

    .stat-trend-neutral {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        margin-top: 5px;
    }

    .premium-header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 20px;
    }

    .premium-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .premium-btn {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .premium-btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--purple-color));
        color: white;
        box-shadow: 0 4px 15px rgba(0, 212, 170, 0.3);
    }

    .premium-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 212, 170, 0.4);
    }

    .premium-btn-secondary {
        background: rgba(255, 255, 255, 0.9);
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        backdrop-filter: blur(10px);
    }

    .premium-btn-secondary:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .premium-btn-whatsapp {
        background: linear-gradient(135deg, #25d366, #128c7e);
        color: white;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
    }

    .premium-btn-whatsapp:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
    }

    .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shine 3s ease-in-out infinite;
    }

    @keyframes shine {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .premium-time {
        text-align: right;
    }

    .time-display {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 5px;
    }

    .date-display {
        font-size: 14px;
        color: #64748b;
    }

    .live-indicator {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
        justify-content: flex-end;
    }

    .live-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--success-color);
        animation: live-pulse 2s ease-in-out infinite;
    }

    @keyframes live-pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.6;
            transform: scale(1.2);
        }
    }

    /* Premium Role Indicator */
    .premium-role-indicator {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        margin-bottom: 30px;
        border: 1px solid rgba(0, 212, 170, 0.1);
    }

    .premium-role-card {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 25px;
        background: linear-gradient(135deg, rgba(0, 212, 170, 0.05), rgba(139, 92, 246, 0.05));
        border-radius: 16px;
        border: 1px solid rgba(0, 212, 170, 0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .premium-role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 212, 170, 0.15);
        border-color: rgba(0, 212, 170, 0.3);
    }

    .role-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary-color), var(--purple-color));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .role-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: icon-shine 3s ease-in-out infinite;
    }

    .role-content h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .role-content p {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .role-badge {
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        color: #1f2937;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid #ffd700;
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Premium Stats Cards */
    .premium-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 30px;
    }

    .premium-stat-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 212, 170, 0.1);
    }

    .premium-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(0, 212, 170, 0.3);
    }

    .premium-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(0, 212, 170, 0.1), rgba(139, 92, 246, 0.1));
        border-radius: 50%;
        transform: translate(30px, -30px);
    }

    .stat-card-inner {
        position: relative;
        z-index: 1;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
        position: relative;
    }

    .stat-icon::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: inherit;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: icon-shine 3s ease-in-out infinite;
    }

    .stat-number {
        font-size: 42px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 16px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .trend-up {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .trend-down {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .trend-neutral {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
    }

    .trend-warning {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    /* Premium Charts */
    .premium-charts-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    .premium-chart-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0, 212, 170, 0.1);
        overflow: hidden;
    }

    .chart-card-header {
        padding: 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chart-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chart-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-color), var(--purple-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .chart-title h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .chart-title p {
        font-size: 14px;
        color: #64748b;
        margin: 4px 0 0 0;
    }

    .chart-card-body {
        padding: 24px;
    }

    .chart-container {
        height: 300px;
        position: relative;
    }

    .chart-insights {
        display: flex;
        gap: 24px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .insight-item {
        text-align: center;
        flex: 1;
        min-width: 80px;
    }

    .insight-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-color);
        display: block;
    }

    .insight-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    /* Premium Activity & Actions */
    .premium-activity-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    .premium-activity-card,
    .premium-actions-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0, 212, 170, 0.1);
        overflow: hidden;
    }

    .activity-card-header,
    .actions-card-header {
        padding: 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .activity-title,
    .actions-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .activity-icon,
    .actions-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-color), var(--purple-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .activity-title h3,
    .actions-title h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .activity-title p,
    .actions-title p {
        font-size: 14px;
        color: #64748b;
        margin: 4px 0 0 0;
    }

    .premium-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .premium-link:hover {
        color: var(--primary-dark);
        transform: translateX(3px);
    }

    .activity-card-body,
    .actions-card-body {
        padding: 24px;
    }

    .activity-timeline {
        space-y: 16px;
    }

    .activity-timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 16px;
        border-radius: 12px;
        background: #f8fafc;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .activity-timeline-item:hover {
        background: white;
        border-color: rgba(0, 212, 170, 0.2);
        transform: translateX(5px);
    }

    .timeline-dot {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
        position: relative;
    }

    .timeline-dot-success {
        background: linear-gradient(135deg, var(--success-color), #34d399);
        color: white;
    }

    .timeline-dot-warning {
        background: linear-gradient(135deg, var(--warning-color), #fbbf24);
        color: white;
    }

    .timeline-dot-info {
        background: linear-gradient(135deg, var(--info-color), #06b6d4);
        color: white;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-text {
        font-size: 14px;
        color: #374151;
        margin-bottom: 6px;
        line-height: 1.5;
    }

    .timeline-meta {
        display: flex;
        gap: 12px;
        font-size: 12px;
        color: #6b7280;
    }

    .timeline-actions {
        flex-shrink: 0;
    }

    .timeline-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .timeline-action-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .premium-action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .premium-action-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        border-radius: 16px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        border: 1px solid rgba(0, 212, 170, 0.1);
        position: relative;
        overflow: hidden;
    }

    .premium-action-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 212, 170, 0.15);
        border-color: rgba(0, 212, 170, 0.3);
    }

    .premium-action-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(0, 212, 170, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .premium-action-item:hover::before {
        left: 100%;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        background: var(--primary-color);
        color: white;
        position: relative;
        z-index: 1;
    }

    .action-content {
        position: relative;
        z-index: 1;
    }

    .action-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .action-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }

    .action-arrow {
        margin-left: auto;
        color: var(--primary-color);
        font-size: 16px;
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease;
    }

    .premium-action-item:hover .action-arrow {
        transform: translateX(4px);
    }

    /* Enhanced Table */
    .table-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0, 212, 170, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .table-header {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 24px 30px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h4 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-premium {
        width: 100%;
        border-collapse: collapse;
    }

    .table-premium thead th {
        background: #f8fafc;
        padding: 16px 30px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-premium tbody td {
        padding: 18px 30px;
        border-bottom: 1px solid #f1f5f9;
        color: #374151;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .table-premium tbody tr:hover td {
        background: rgba(0, 212, 170, 0.02);
    }

    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }

    /* WhatsApp Floating Button */
    .whatsapp-floating-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #25d366, #128c7e);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        text-decoration: none;
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
        transition: all 0.3s ease;
        z-index: 9999;
        border: 3px solid white;
        animation: float-up 0.5s ease-out;
    }

    .whatsapp-floating-btn:hover {
        transform: scale(1.15) translateY(-5px);
        box-shadow: 0 12px 35px rgba(37, 211, 102, 0.6);
    }

    .whatsapp-floating-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        animation: pulse-ring 2s ease-in-out infinite;
    }

    @keyframes float-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse-ring {
        0%, 100% {
            transform: scale(1);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.5;
        }
    }

    .whatsapp-floating-tooltip {
        position: absolute;
        bottom: 80px;
        right: 0;
        background: linear-gradient(135deg, #25d366, #128c7e);
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        transform: translateY(10px);
    }

    .whatsapp-floating-btn:hover .whatsapp-floating-tooltip {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .premium-dashboard-header {
            padding: 30px 20px;
        }

        .premium-header-content {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .premium-stats {
            justify-content: center;
        }

        .premium-header-right {
            align-items: center;
        }

        .premium-stats-grid {
            grid-template-columns: 1fr;
        }

        .premium-charts-section {
            grid-template-columns: 1fr;
        }

        .premium-activity-actions {
            grid-template-columns: 1fr;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 12px 15px;
            font-size: 12px;
        }

        .premium-action-grid {
            grid-template-columns: 1fr;
        }

        .stat-number {
            font-size: 36px;
        }

        .premium-title {
            font-size: 32px;
        }

        .subtitle {
            font-size: 20px;
        }

        .whatsapp-floating-btn {
            width: 50px;
            height: 50px;
            font-size: 24px;
            bottom: 20px;
            right: 20px;
        }
    }

    /* Recent Activity Card */
    .premium-recent-activity-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.8);
        overflow: hidden;
        backdrop-filter: blur(20px);
    }

    .activity-card-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        padding: 24px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .activity-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><pattern id="activity-grain" width="100" height="20" patternUnits="userSpaceOnUse"><circle cx="25" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="20" fill="url(%23activity-grain)"/></svg>');
        opacity: 0.3;
    }

    .activity-title {
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    }

    .activity-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
    }

    .activity-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
    }

    .activity-text h3 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .activity-text p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .activity-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    }

    .activity-card-body {
        padding: 30px;
    }

    .premium-activity-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .premium-activity-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .premium-activity-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .activity-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .activity-details {
        flex: 1;
        min-width: 0;
    }

    .activity-message {
        font-size: 14px;
        color: #374151;
        margin-bottom: 4px;
        font-weight: 500;
    }

    .activity-time {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 2px;
    }

    .activity-amount {
        font-size: 14px;
        color: #059669;
        font-weight: 600;
    }

    .activity-status {
        flex-shrink: 0;
    }

    /* Analytics Card */
    .premium-analytics-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.8);
        overflow: hidden;
        backdrop-filter: blur(20px);
    }

    .analytics-card-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        padding: 24px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .analytics-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><pattern id="analytics-grain" width="100" height="20" patternUnits="userSpaceOnUse"><circle cx="25" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="20" fill="url(%23analytics-grain)"/></svg>');
        opacity: 0.3;
    }

    .analytics-title {
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    }

    .analytics-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .analytics-text h3 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .analytics-text p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .analytics-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    }

    .analytics-card-body {
        padding: 30px;
    }

    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .analytics-metric {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        flex-shrink: 0;
    }

    .metric-data {
        flex: 1;
    }

    .metric-value {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .metric-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .metric-trend {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    .metric-trend.trend-up {
        color: #059669;
    }

    .metric-trend.trend-down {
        color: #dc2626;
    }

    .metric-trend.trend-neutral {
        color: #6b7280;
    }

    .analytics-chart {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Support Card */
    .premium-support-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.8);
        overflow: hidden;
        backdrop-filter: blur(20px);
    }

    .support-card-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        padding: 24px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .support-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><pattern id="support-grain" width="100" height="20" patternUnits="userSpaceOnUse"><circle cx="25" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="20" fill="url(%23support-grain)"/></svg>');
        opacity: 0.3;
    }

    .support-title {
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    }

    .support-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .support-text h3 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .support-text p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .support-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    }

    .support-status {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
    }

    .status-indicator.online {
        background: #10b981;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
    }

    .support-card-body {
        padding: 30px;
    }

    .support-metrics {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .support-metric {
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .metric-number {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .metric-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .support-metric .metric-trend {
        justify-content: center;
    }

    .support-recent-tickets h4 {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 16px;
    }

    .tickets-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .ticket-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .ticket-priority {
        font-size: 8px;
        color: #6b7280;
    }

    .ticket-priority.priority-high .fa-circle {
        color: #dc2626;
    }

    .ticket-priority.priority-medium .fa-circle {
        color: #f59e0b;
    }

    .ticket-priority.priority-low .fa-circle {
        color: #10b981;
    }

    .ticket-info {
        flex: 1;
    }

    .ticket-subject {
        font-size: 13px;
        color: #374151;
        font-weight: 500;
        margin-bottom: 2px;
    }

    .ticket-time {
        font-size: 11px;
        color: #9ca3af;
    }

    .ticket-status {
        flex-shrink: 0;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.status-open {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-badge.status-pending {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .status-badge.status-resolved {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #166534;
    }

    /* Enhanced Layout Improvements */
    .premium-dashboard-header {
        margin-bottom: 40px;
    }

    .premium-bottom-section {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 30px;
        margin-top: 40px;
    }

    @media (max-width: 1200px) {
        .premium-bottom-section {
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .analytics-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .premium-bottom-section {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .activity-card-header,
        .analytics-card-header,
        .support-card-header {
            padding: 20px;
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .activity-actions,
        .analytics-actions,
        .support-actions {
            width: 100%;
            justify-content: space-between;
        }

        .support-metrics {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .analytics-metric {
            padding: 16px;
        }

        .metric-value {
            font-size: 20px;
        }
    }
</style>

{{-- WhatsApp Floating Button --}}
<a href="https://wa.me/1234567890?text=Hello%20Next%20Digi%20Home%20Support" target="_blank" class="whatsapp-floating-btn" title="Contact Support via WhatsApp">
    <i class="fa fa-whatsapp"></i>
    <div class="whatsapp-floating-tooltip">Chat with us on WhatsApp</div>
</a>

{{-- Premium Dashboard Header --}}
<div class="premium-dashboard-header">
    <!-- Animated Background -->
    <div class="header-bg-gradient"></div>
    <div class="floating-elements">
        <div class="float-element float-1"></div>
        <div class="float-element float-2"></div>
        <div class="float-element float-3"></div>
        <div class="float-element float-4"></div>
        <div class="float-element float-5"></div>
    </div>

    <div class="premium-header-content">
        <div class="premium-header-left">
            <div class="premium-header-icon">
                <div class="icon-container">
                    <i class="fa fa-crown"></i>
                    <div class="icon-glow"></div>
                    <div class="icon-particles">
                        <span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>
            </div>
            <div class="premium-header-text">
                <h1 class="premium-title">
                    <span class="gradient-text">Next Digi Home</span>
                    <span class="subtitle">Super Admin Dashboard</span>
                </h1>
                <p class="premium-welcome">Welcome back, <span class="user-name">{{ $user->name }}</span>! 🚀 Master control panel for your digital marketplace.</p>
                <div class="premium-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ $stats['total'] ?? 0 }}</span>
                        <span class="stat-label">Total Requisitions</span>
                        <div class="stat-trend-up">
                            <i class="fa fa-arrow-up"></i>
                            <span>+12.5%</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $stats['approved'] ?? 0 }}</span>
                        <span class="stat-label">Approved</span>
                        <div class="stat-trend-up">
                            <i class="fa fa-arrow-up"></i>
                            <span>+8.3%</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $stats['pending'] ?? 0 }}</span>
                        <span class="stat-label">Pending</span>
                        <div class="stat-trend-neutral">
                            <i class="fa fa-clock"></i>
                            <span>Processing</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="premium-header-right">
            <div class="premium-actions">
                <a href="https://wa.me/1234567890?text=Hello%20Next%20Digi%20Home%20Support" target="_blank" class="premium-btn premium-btn-whatsapp" title="Contact us on WhatsApp">
                    <i class="fa fa-whatsapp"></i>
                    <span>WhatsApp</span>
                    <div class="btn-shine"></div>
                </a>
                <button onclick="location.reload()" class="premium-btn premium-btn-secondary">
                    <i class="fa fa-sync-alt"></i>
                    <span>Refresh</span>
                    <div class="btn-pulse"></div>
                </button>
                <a href="{{ route('settings.index') }}" class="premium-btn premium-btn-primary">
                    <i class="fa fa-cog"></i>
                    <span>System Settings</span>
                    <div class="btn-shine"></div>
                </a>
            </div>
            <div class="premium-time">
                <div class="time-display">
                    <i class="fa fa-clock"></i>
                    <span id="current-time">{{ now()->format('H:i') }}</span>
                </div>
                <div class="date-display">
                    <span>{{ now()->format('l, F j, Y') }}</span>
                </div>
                <div class="live-indicator">
                    <div class="live-dot"></div>
                    <span>Live</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Premium Stats Cards --}}
<div class="premium-stats-grid">
    <div class="premium-stat-card premium-stat-products">
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-box"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ number_format($totalProducts ?? 0) }}</div>
                <div class="stat-label">Total Products</div>
                <div class="stat-trend trend-up">
                    <i class="fa fa-arrow-up"></i>
                    <span>+12.5% this month</span>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-stat-card premium-stat-sales">
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ number_format($totalPurchases ?? 0) }}</div>
                <div class="stat-label">Total Sales</div>
                <div class="stat-trend trend-up">
                    <i class="fa fa-arrow-up"></i>
                    <span>+18.3% growth</span>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-stat-card premium-stat-revenue">
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">${{ number_format($totalRevenue ?? 0, 0) }}</div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-trend trend-up">
                    <i class="fa fa-chart-line"></i>
                    <span>+24.7% increase</span>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-stat-card premium-stat-customers">
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ number_format($stats['customers'] ?? 0) }}</div>
                <div class="stat-label">Total Customers</div>
                <div class="stat-trend trend-up">
                    <i class="fa fa-user-plus"></i>
                    <span>New signups</span>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-stat-card premium-stat-active">
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ number_format($activeProducts ?? 0) }}</div>
                <div class="stat-label">Active Products</div>
                <div class="stat-trend trend-up">
                    <i class="fa fa-check"></i>
                    <span>Live products</span>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-stat-card premium-stat-categories">
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-tags"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ \App\Models\Category::count() }}</div>
                <div class="stat-label">Categories</div>
                <div class="stat-trend trend-neutral">
                    <i class="fa fa-tag"></i>
                    <span>Product categories</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Premium Activity & Actions Section --}}
<div class="premium-activity-actions">
    <div class="premium-activity-card">
        <div class="activity-card-header">
            <div class="activity-title">
                <div class="activity-icon">
                    <i class="fa fa-history"></i>
                    <div class="activity-icon-glow"></div>
                </div>
                <div class="activity-text">
                    <h3>Recent Activity</h3>
                    <p>Latest system activities and updates</p>
                </div>
            </div>
            <a href="#" class="premium-link">
                <span>View All</span>
                <i class="fa fa-arrow-right"></i>
                <div class="link-glow"></div>
            </a>
        </div>
        <div class="activity-card-body">
            @if($timeline && $timeline->count() > 0)
            <div class="activity-timeline">
                @foreach($timeline as $activity)
                <div class="activity-timeline-item">
                    <div class="timeline-dot timeline-dot-{{ $activity->status == 'Approved' ? 'success' : ($activity->status == 'Pending' ? 'warning' : 'info') }}">
                        <i class="fa fa-{{ $activity->status == 'Approved' ? 'check' : ($activity->status == 'Pending' ? 'clock' : 'info') }}"></i>
                        <div class="timeline-dot-pulse"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-text">{!! $activity->description ?? 'System activity' !!}</div>
                        <div class="timeline-meta">
                            <span class="timeline-time">{{ $activity->created_at->diffForHumans() }}</span>
                            <span class="timeline-user">{{ $activity->user_name ?? 'System' }}</span>
                        </div>
                    </div>
                    <div class="timeline-actions">
                        <button class="timeline-action-btn" title="View Details">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="activity-empty">
                <div class="empty-icon">
                    <i class="fa fa-rocket"></i>
                    <div class="empty-icon-glow"></div>
                </div>
                <div class="empty-content">
                    <h4>System Activity</h4>
                    <p>Recent activities will appear here</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="premium-actions-card">
        <div class="actions-card-header">
            <div class="actions-title">
                <div class="actions-icon">
                    <i class="fa fa-bolt"></i>
                    <div class="actions-icon-glow"></div>
                </div>
                <div class="actions-text">
                    <h3>Quick Actions</h3>
                    <p>Administrative shortcuts</p>
                </div>
            </div>
        </div>
        <div class="actions-card-body">
            <div class="premium-action-grid">
                <a href="{{ route('admin.products.index') }}" class="premium-action-item premium-action-primary">
                    <div class="action-icon">
                        <i class="fa fa-box"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Manage Products</span>
                        <span class="action-subtitle">Digital products catalog</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                    <div class="action-shine"></div>
                </a>

                <a href="{{ route('admin.purchases.index') }}" class="premium-action-item premium-action-info">
                    <div class="action-icon">
                        <i class="fa fa-shopping-cart"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Order Management</span>
                        <span class="action-subtitle">Customer purchases</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}" class="premium-action-item premium-action-success">
                    <div class="action-icon">
                        <i class="fa fa-users"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Customer Management</span>
                        <span class="action-subtitle">User accounts & roles</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="premium-action-item premium-action-warning">
                    <div class="action-icon">
                        <i class="fa fa-tags"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Categories</span>
                        <span class="action-subtitle">Product organization</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="premium-action-item premium-action-secondary">
                    <div class="action-icon">
                        <i class="fa fa-credit-card"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Payments</span>
                        <span class="action-subtitle">Transaction management</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="premium-action-item premium-action-danger">
                    <div class="action-icon">
                        <i class="fa fa-chart-line"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Analytics</span>
                        <span class="action-subtitle">Sales & performance</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Premium Charts Section --}}
<div class="premium-charts-section">
    <div class="premium-chart-card premium-chart-large">
        <div class="chart-card-header">
            <div class="chart-title">
                <div class="chart-icon">
                    <i class="fa fa-chart-line"></i>
                </div>
                <div class="chart-text">
                    <h3>Sales Performance</h3>
                    <p>Monthly revenue and product trends</p>
                </div>
            </div>
            <div class="chart-controls">
                <select class="premium-select" id="monthFilter">
                    <option value="12">Last 12 Months</option>
                    <option value="6">Last 6 Months</option>
                    <option value="3">Last 3 Months</option>
                </select>
                <button class="premium-btn premium-btn-outline">
                    <i class="fa fa-download"></i>
                    Export Data
                </button>
            </div>
        </div>
        <div class="chart-card-body">
            <div class="chart-container">
                <canvas id="monthlyRequisitionsChart"></canvas>
            </div>
            <div class="chart-insights">
                <div class="insight-item">
                    <span class="insight-value">${{ number_format($totalRevenue ?? 0, 0) }}</span>
                    <span class="insight-label">Total Revenue</span>
                </div>
                <div class="insight-item">
                    <span class="insight-value">{{ $totalPurchases ?? 0 }}</span>
                    <span class="insight-label">Total Sales</span>
                </div>
                <div class="insight-item">
                    <span class="insight-value">${{ $totalPurchases ? number_format($totalRevenue / $totalPurchases, 0) : '0' }}</span>
                    <span class="insight-label">Avg Order Value</span>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-chart-card premium-chart-small">
        <div class="chart-card-header">
            <div class="chart-title">
                <div class="chart-icon">
                    <i class="fa fa-chart-pie"></i>
                </div>
                <div class="chart-text">
                    <h3>Product Categories</h3>
                    <p>Distribution by category</p>
                </div>
            </div>
        </div>
        <div class="chart-card-body">
            <div class="chart-container">
                <canvas id="statusDistributionChart"></canvas>
            </div>
            <div class="status-legend">
                <div class="legend-item">
                    <span class="legend-color" style="background: #10b981;"></span>
                    <span class="legend-text">Active Products ({{ $totalProducts ?? 0 }})</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #f59e0b;"></span>
                    <span class="legend-text">Pending Products ({{ $pending ?? 0 }})</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #3b82f6;"></span>
                    <span class="legend-text">Total Sales ({{ $approved ?? 0 }})</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #8b5cf6;"></span>
                    <span class="legend-text">Total Revenue (${{ number_format($totalRevenue ?? 0, 2) }})</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Premium Bottom Section --}}
<div class="premium-bottom-section">
    <div class="premium-recent-activity-card">
        <div class="activity-card-header">
            <div class="activity-title">
                <div class="activity-icon">
                    <i class="fa fa-clock"></i>
                    @if($latestPurchases && $latestPurchases->count() > 0)
                    <span class="activity-badge">{{ $latestPurchases->count() }}</span>
                    @endif
                </div>
                <div class="activity-text">
                    <h3>Recent Orders</h3>
                    <p>Latest customer purchases</p>
                </div>
            </div>
            <div class="activity-actions">
                <a href="{{ route('admin.purchases.index') }}" class="premium-btn premium-btn-outline small">
                    <i class="fa fa-list"></i>
                    View All
                </a>
                <a href="{{ route('admin.purchases.create') }}" class="premium-link">
                    <span>New Order</span>
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="activity-card-body">
            @if($latestPurchases && $latestPurchases->count() > 0)
            <div class="premium-activity-list">
                @foreach($latestPurchases->take(5) as $purchase)
                <div class="premium-activity-item">
                    <div class="activity-avatar activity-success">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="activity-details">
                        <div class="activity-message">
                            <strong>{{ optional($purchase->product)->name ?? 'Digital Product' }}</strong>
                            purchased by Customer #{{ $purchase->user_id }}
                        </div>
                        <div class="activity-time">{{ $purchase->created_at->diffForHumans() }}</div>
                        <div class="activity-amount">${{ number_format(optional($purchase->product)->price ?? 0, 2) }}</div>
                    </div>
                    <div class="activity-status">
                        <span class="status-badge status-completed">Paid</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="activity-empty">
                <div class="empty-icon">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="empty-content">
                    <h4>No Recent Orders</h4>
                    <p>Customer orders will appear here</p>
                    <a href="{{ route('admin.products.index') }}" class="premium-btn premium-btn-primary small">
                        <i class="fa fa-plus"></i>
                        Add Products
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="premium-analytics-card">
        <div class="analytics-card-header">
            <div class="analytics-title">
                <div class="analytics-icon">
                    <i class="fa fa-chart-line"></i>
                </div>
                <div class="analytics-text">
                    <h3>Marketplace Analytics</h3>
                    <p>Performance insights & trends</p>
                </div>
            </div>
            <div class="analytics-actions">
                <select class="premium-select small" onchange="updateAnalyticsPeriod(this.value)">
                    <option value="7">Last 7 days</option>
                    <option value="30" selected>Last 30 days</option>
                    <option value="90">Last 3 months</option>
                </select>
                <a href="{{ route('admin.reports.index') }}" class="premium-link">
                    <span>Full Report</span>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="analytics-card-body">
            <div class="analytics-grid">
                <div class="analytics-metric">
                    <div class="metric-icon">
                        <i class="fa fa-eye"></i>
                    </div>
                    <div class="metric-data">
                        <div class="metric-value">{{ number_format(rand(1000, 5000)) }}</div>
                        <div class="metric-label">Page Views</div>
                        <div class="metric-trend trend-up">
                            <i class="fa fa-arrow-up"></i>
                            <span>+12.5%</span>
                        </div>
                    </div>
                </div>

                <div class="analytics-metric">
                    <div class="metric-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="metric-data">
                        <div class="metric-value">{{ number_format($totalCustomers ?? 0) }}</div>
                        <div class="metric-label">Unique Visitors</div>
                        <div class="metric-trend trend-up">
                            <i class="fa fa-arrow-up"></i>
                            <span>+8.3%</span>
                        </div>
                    </div>
                </div>

                <div class="analytics-metric">
                    <div class="metric-icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="metric-data">
                        <div class="metric-value">{{ number_format($totalPurchases ?? 0) }}</div>
                        <div class="metric-label">Conversion Rate</div>
                        <div class="metric-trend trend-up">
                            <i class="fa fa-arrow-up"></i>
                            <span>+5.7%</span>
                        </div>
                    </div>
                </div>

                <div class="analytics-metric">
                    <div class="metric-icon">
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="metric-data">
                        <div class="metric-value">4.8</div>
                        <div class="metric-label">Avg Rating</div>
                        <div class="metric-trend trend-neutral">
                            <i class="fa fa-minus"></i>
                            <span>+0.2</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="analytics-chart">
                <canvas id="marketplaceAnalyticsChart" style="max-height: 200px;"></canvas>
            </div>
        </div>
    </div>

    <div class="premium-support-card">
        <div class="support-card-header">
            <div class="support-title">
                <div class="support-icon">
                    <i class="fa fa-headset"></i>
                </div>
                <div class="support-text">
                    <h3>Customer Support</h3>
                    <p>Support tickets & inquiries</p>
                </div>
            </div>
            <div class="support-actions">
                <span class="support-status">
                    <div class="status-indicator online"></div>
                    All Systems Operational
                </span>
                <a href="#" class="premium-link">
                    <span>Support Center</span>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="support-card-body">
            <div class="support-metrics">
                <div class="support-metric">
                    <div class="metric-number">{{ rand(5, 25) }}</div>
                    <div class="metric-label">Open Tickets</div>
                    <div class="metric-trend trend-down">
                        <i class="fa fa-arrow-down"></i>
                        <span>-12%</span>
                    </div>
                </div>

                <div class="support-metric">
                    <div class="metric-number">{{ rand(95, 99) }}%</div>
                    <div class="metric-label">Satisfaction</div>
                    <div class="metric-trend trend-up">
                        <i class="fa fa-arrow-up"></i>
                        <span>+2%</span>
                    </div>
                </div>

                <div class="support-metric">
                    <div class="metric-number">{{ rand(10, 60) }}min</div>
                    <div class="metric-label">Avg Response</div>
                    <div class="metric-trend trend-down">
                        <i class="fa fa-arrow-down"></i>
                        <span>-8min</span>
                    </div>
                </div>
            </div>

            <div class="support-recent-tickets">
                <h4>Recent Support Tickets</h4>
                <div class="tickets-list">
                    <div class="ticket-item">
                        <div class="ticket-priority priority-medium">
                            <i class="fa fa-circle"></i>
                        </div>
                        <div class="ticket-info">
                            <div class="ticket-subject">Payment processing issue</div>
                            <div class="ticket-time">2 hours ago</div>
                        </div>
                        <div class="ticket-status">
                            <span class="status-badge status-open">Open</span>
                        </div>
                    </div>

                    <div class="ticket-item">
                        <div class="ticket-priority priority-low">
                            <i class="fa fa-circle"></i>
                        </div>
                        <div class="ticket-info">
                            <div class="ticket-subject">Download link not working</div>
                            <div class="ticket-time">5 hours ago</div>
                        </div>
                        <div class="ticket-status">
                            <span class="status-badge status-pending">Pending</span>
                        </div>
                    </div>

                    <div class="ticket-item">
                        <div class="ticket-priority priority-high">
                            <i class="fa fa-circle"></i>
                        </div>
                        <div class="ticket-info">
                            <div class="ticket-subject">Account access problem</div>
                            <div class="ticket-time">1 day ago</div>
                        </div>
                        <div class="ticket-status">
                            <span class="status-badge status-resolved">Resolved</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function initCharts() {
    // Monthly Requisitions Bar Chart
    const monthlyCtx = document.getElementById('monthlyRequisitionsChart');
    if (monthlyCtx) {
        const monthLabels = {!! json_encode($monthLabels ?: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']) !!};
        const monthlyData = {!! json_encode($monthlyData ?: [0,0,0,0,0,0,0,0,0,0,0,0]) !!};
        const monthlyDataNumbers = monthlyData.map(function(x) { return parseInt(x) || 0; });

        new Chart(monthlyCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Requisitions',
                    data: monthlyDataNumbers,
                    backgroundColor: 'rgba(0, 212, 170, 0.8)',
                    borderColor: 'rgba(0, 212, 170, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#64748b' } },
                    y: { grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { color: '#64748b' }, beginAtZero: true }
                }
            }
        });
    }

    // Status Distribution Doughnut Chart
    const statusCtx = document.getElementById('statusDistributionChart');
    if (statusCtx) {
        const statusCountsRaw = {!! json_encode($statusCounts ?: ['Active Products' => $totalProducts ?? 0, 'Pending Products' => $pending ?? 0, 'Total Sales' => $approved ?? 0, 'Total Revenue' => $totalRevenue ?? 0]) !!};
        const statusLabels = Object.keys(statusCountsRaw);
        const statusValues = Object.values(statusCountsRaw).map(function(x) { return parseInt(x) || 0; });

        new Chart(statusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Active Products - green
                        'rgba(245, 158, 11, 0.8)',  // Pending Products - orange
                        'rgba(59, 130, 246, 0.8)',  // Total Sales - blue
                        'rgba(139, 92, 246, 0.8)'   // Total Revenue - purple
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
}

// Initialize charts when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initCharts, 100);
    });
} else {
    setTimeout(initCharts, 100);
}
</script>

{{-- Push Notifications Initialization --}}
<script>
// Service Worker Registration for Push Notifications
if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', async () => {
        try {
            // Register service worker from public folder
            const registration = await navigator.serviceWorker.register('{{ asset('service-worker.js') }}');
            console.log('Service Worker registered:', registration.scope);

            // Wait for the service worker to be ready
            await registration.ready;
            console.log('Service Worker ready');

            // Request notification permission
            if (Notification.permission !== 'granted') {
                const permission = await Notification.requestPermission();
                console.log('Notification permission:', permission);

                if (permission === 'granted') {
                    await subscribeToPush(registration);
                }
            } else {
                await subscribeToPush(registration);
            }
        } catch (error) {
            console.error('Service Worker registration failed:', error);
        }
    });
}

async function subscribeToPush(registration) {
    try {
        // VAPID public key (hardcoded for testing)
        const vapidPublicKey = 'BL8nB7H3jyXBugZ7NQbhyBidyynLlM9Ieuc1DaEYGpAp_adPZ1v8wGr94K2MGF1iXmX-qQSkZD9FdoNgXjY8SOY';

        // Validate VAPID key
        if (!vapidPublicKey || vapidPublicKey.length < 10) {
            console.error('Invalid VAPID public key:', vapidPublicKey);
            return;
        }

        console.log('VAPID key length:', vapidPublicKey.length);
        console.log('VAPID key:', vapidPublicKey);

        // Convert VAPID key to Uint8Array
        const applicationServerKey = urlBase64ToUint8Array(vapidPublicKey);

        console.log('Application server key:', applicationServerKey);

        // Subscribe to push
        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: applicationServerKey
        });

        console.log('Push subscription:', subscription);

        // Send subscription to server
        const subscriptionData = subscription.toJSON();

        // Format data for the controller
        const formData = new FormData();
        formData.append('endpoint', subscriptionData.endpoint);
        formData.append('keys[auth]', subscriptionData.keys.auth);
        formData.append('keys[p256dh]', subscriptionData.keys.p256dh);

        await fetch('{{ url('/api/push/subscribe') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        console.log('Push subscription sent to server');
    } catch (error) {
        console.error('Push subscription failed:', error);
    }
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

// Analytics Period Update Function
function updateAnalyticsPeriod(days) {
    // In a real application, this would make an AJAX call to update the analytics data
    console.log('Updating analytics period to:', days, 'days');

    // Show loading state
    const metrics = document.querySelectorAll('.metric-value');
    metrics.forEach(metric => {
        metric.style.opacity = '0.5';
    });

    // Simulate data update (in real app, this would be an AJAX call)
    setTimeout(() => {
        // Update with new random data based on period
        const multiplier = days / 30; // Scale data based on period

        metrics.forEach((metric, index) => {
            let newValue;
            switch(index) {
                case 0: // Page Views
                    newValue = Math.floor((Math.random() * 3000 + 2000) * multiplier);
                    break;
                case 1: // Unique Visitors
                    newValue = Math.floor((Math.random() * 500 + 200) * multiplier);
                    break;
                case 2: // Conversion Rate
                    newValue = Math.floor((Math.random() * 20 + 5) * multiplier);
                    break;
                case 3: // Avg Rating
                    newValue = (Math.random() * 0.5 + 4.3).toFixed(1);
                    break;
            }
            metric.textContent = newValue.toLocaleString();
            metric.style.opacity = '1';
        });

        // Show success message
        showAnalyticsUpdateMessage(`Analytics updated for last ${days} days`);
    }, 1000);
}

function showAnalyticsUpdateMessage(message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        font-weight: 500;
        max-width: 400px;
        animation: slideInRight 0.3s ease-out;
    `;
    notification.textContent = message;

    // Add slide in animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-in';
        setTimeout(() => {
            notification.remove();
            style.remove();
        }, 300);
    }, 3000);
}
</script>
@endsection
