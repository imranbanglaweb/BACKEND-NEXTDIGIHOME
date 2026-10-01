<style>
    /* ==========================================================================
       NEXTDIGIHOME SHARED ADMIN UI - ENHANCED TYPOGRAPHY & VISIBILITY SYSTEM
       Universal font scale upgrade, high-contrast text, and crisp modern layout
       ========================================================================== */

    .premium-page { 
        background: #f8fafc; 
        min-height: calc(100vh - 66px); 
        padding: 26px 30px; 
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 15px;
        color: #1e293b;
        line-height: 1.6;
    }
    .premium-page .container-fluid { padding-left: 0 !important; padding-right: 0 !important; }
    .dashboard-stat-link { text-decoration: none !important; color: inherit !important; display: block; height: 100%; }
    
    /* --------------------------------------------------------------------------
       1. HERO HEADER: OBSIDIAN NIGHT WITH VIVID READABLE TYPOGRAPHY
       -------------------------------------------------------------------------- */
    .premium-header {
        align-items: center;
        background: linear-gradient(135deg, #090e17 0%, #0f172a 45%, #1e293b 100%);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 16px;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        margin-bottom: 24px;
        padding: 26px 32px;
        box-shadow: 0 12px 36px rgba(15, 23, 42, 0.22);
    }
    .premium-header h2 {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.6px;
        color: #ffffff;
        margin: 0 0 8px;
        line-height: 1.25;
    }
    .premium-header p {
        color: #e2e8f0;
        font-size: 15.5px;
        font-weight: 500;
        margin: 0;
        line-height: 1.6;
    }
    .premium-eyebrow {
        color: #38bdf8;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        margin-bottom: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* --------------------------------------------------------------------------
       2. HERO ACTION BUTTONS
       -------------------------------------------------------------------------- */
    .premium-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .premium-actions .btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 9px !important;
        padding: 10px 20px !important;
        font-size: 14.5px !important;
        font-weight: 700 !important;
        line-height: 1.4 !important;
        border-radius: 10px !important;
        text-decoration: none !important;
        cursor: pointer !important;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
        white-space: nowrap !important;
    }
    .premium-actions .btn i {
        font-size: 15px !important;
        line-height: 1 !important;
    }
    .premium-actions .btn-outline-light {
        background: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.28) !important;
        backdrop-filter: blur(10px) !important;
    }
    .premium-actions .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.22) !important;
        border-color: rgba(255, 255, 255, 0.5) !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
    }
    .premium-actions .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        box-shadow: 0 4px 16px rgba(79, 70, 229, 0.4) !important;
    }
    .premium-actions .btn-primary:hover {
        background: linear-gradient(135deg, #4338ca 0%, #2563eb 100%) !important;
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.55) !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
    }

    /* --------------------------------------------------------------------------
       3. NAVIGATION TABS BAR
       -------------------------------------------------------------------------- */
    .premium-nav {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        padding: 9px 12px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }
    .premium-nav a {
        border-radius: 9px;
        color: #334155;
        font-size: 14.5px;
        font-weight: 700;
        padding: 8px 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .premium-nav a:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .premium-nav a.active {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }
    .premium-nav a .badge {
        font-size: 12.5px;
        font-weight: 800;
        padding: 3px 9px;
        border-radius: 9999px;
    }
    .premium-nav a.active .badge {
        background: rgba(255, 255, 255, 0.22);
        color: #ffffff;
    }

    /* --------------------------------------------------------------------------
       4. GRID LAYOUT SYSTEM
       -------------------------------------------------------------------------- */
    .premium-stats-grid {
        display: grid !important;
        grid-template-columns: 1.25fr 1fr 1fr 1fr 1fr !important;
        gap: 18px !important;
        margin-bottom: 24px !important;
    }
    .premium-stats-grid > div {
        width: 100% !important;
        float: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .dashboard-grid-2col {
        display: grid !important;
        grid-template-columns: 1.8fr 1fr !important;
        gap: 20px !important;
        margin-bottom: 24px !important;
    }
    .dashboard-grid-2col > div {
        width: 100% !important;
        float: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .dashboard-grid-2col-table {
        display: grid !important;
        grid-template-columns: 1.4fr 1fr !important;
        gap: 20px !important;
        margin-bottom: 24px !important;
    }
    .dashboard-grid-2col-table > div {
        width: 100% !important;
        float: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Responsive Breakpoints */
    @media (max-width: 1280px) {
        .premium-stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 991.98px) {
        .dashboard-grid-2col,
        .dashboard-grid-2col-table {
            grid-template-columns: 1fr !important;
        }
    }
    @media (max-width: 820px) {
        .premium-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 520px) {
        .premium-stats-grid {
            grid-template-columns: 1fr !important;
        }
    }

    /* --------------------------------------------------------------------------
       5. CARDS & STAT METRICS
       -------------------------------------------------------------------------- */
    .premium-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
        padding: 24px;
    }
    .premium-card-title {
        align-items: flex-start;
        display: flex;
        gap: 14px;
        justify-content: space-between;
        margin-bottom: 18px;
    }
    .premium-card-title h5 {
        color: #0f172a;
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 4px;
        letter-spacing: -0.3px;
    }
    .premium-card-title p {
        color: #475569;
        font-size: 14.5px;
        margin: 0;
        font-weight: 500;
    }
    .premium-stat {
        align-items: center;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        display: flex;
        gap: 16px;
        height: 100%;
        min-height: 102px;
        padding: 20px 22px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .premium-stat:hover {
        border-color: #94a3b8;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.09);
        transform: translateY(-3px);
    }
    .premium-stat small {
        color: #475569;
        display: block;
        font-size: 13.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 4px;
    }
    .premium-stat strong {
        color: #0f172a;
        display: block;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.5px;
    }
    .premium-icon {
        align-items: center;
        border-radius: 12px;
        color: #ffffff;
        display: inline-flex;
        flex: 0 0 52px;
        height: 52px;
        justify-content: center;
        width: 52px;
        font-size: 22px;
    }
    .premium-blue { background: #2563eb; }
    .premium-green { background: #16a34a; }
    .premium-cyan { background: #0891b2; }
    .premium-amber { background: #d97706; }
    .premium-red { background: #dc2626; }
    .premium-purple { background: #7c3aed; }

    /* --------------------------------------------------------------------------
       6. UNIVERSAL HIGH-CONTRAST BADGES, PILLS & STATUS SYSTEM (BOOTSTRAP 3 OVERRIDE)
       -------------------------------------------------------------------------- */
    .badge {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        padding: 4px 9px !important;
        font-size: 11.5px !important;
        font-weight: 700 !important;
        line-height: 1.25 !important;
        text-align: center !important;
        white-space: nowrap !important;
        vertical-align: middle !important;
        border-radius: 6px !important;
        letter-spacing: 0.3px !important;
        transition: all 0.15s ease !important;
        border: 1px solid transparent !important;
        box-shadow: none !important;
    }

    /* Bootstrap 3 default #777 override - ensure badges are never muddy dark grey */
    .badge.badge-light,
    .badge-light,
    .badge.bg-light {
        background: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
    }
    .badge.badge-light.text-primary,
    .badge-light.text-primary {
        background: #eff6ff !important;
        color: #1d4ed8 !important;
        border-color: #bfdbfe !important;
    }
    .badge.badge-light.text-success,
    .badge-light.text-success {
        background: #ecfdf5 !important;
        color: #047857 !important;
        border-color: #a7f3d0 !important;
    }
    .badge.badge-light.text-warning,
    .badge-light.text-warning {
        background: #fffbeb !important;
        color: #b45309 !important;
        border-color: #fde68a !important;
    }
    .badge.badge-light.text-danger,
    .badge-light.text-danger {
        background: #fef2f2 !important;
        color: #b91c1c !important;
        border-color: #fecaca !important;
    }
    .badge.badge-light.text-info,
    .badge-light.text-info {
        background: #f0f9ff !important;
        color: #0369a1 !important;
        border-color: #bae6fd !important;
    }
    .badge.badge-light.text-purple,
    .badge-light.text-purple {
        background: #f5f3ff !important;
        color: #6d28d9 !important;
        border-color: #ddd6fe !important;
    }
    .badge.badge-light.text-muted,
    .badge-light.text-muted {
        background: #f8fafc !important;
        color: #475569 !important;
        border-color: #e2e8f0 !important;
    }
    .badge.badge-light.text-dark,
    .badge-light.text-dark {
        background: #f8fafc !important;
        color: #0f172a !important;
        border-color: #cbd5e1 !important;
    }
    .badge.badge-light.text-secondary,
    .badge-light.text-secondary {
        background: #f8fafc !important;
        color: #64748b !important;
        border-color: #e2e8f0 !important;
    }

    /* Soft modern color badges */
    .badge.badge-success,
    .badge-success {
        background: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
    }

    .badge.badge-danger,
    .badge-danger {
        background: #fef2f2 !important;
        color: #b91c1c !important;
        border: 1px solid #fecaca !important;
    }

    .badge.badge-warning,
    .badge-warning {
        background: #fffbeb !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }

    .badge.badge-info,
    .badge-info {
        background: #f0f9ff !important;
        color: #0369a1 !important;
        border: 1px solid #bae6fd !important;
    }

    .badge.badge-primary,
    .badge-primary {
        background: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
    }

    .badge.badge-secondary,
    .badge-secondary {
        background: #f1f5f9 !important;
        color: #475569 !important;
        border: 1px solid #cbd5e1 !important;
    }

    .badge.badge-dark,
    .badge-dark {
        background: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid #334155 !important;
    }

    /* Channel / Platform Specific Badges */
    .st-badge-meta, .channel-meta {
        background: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
        font-weight: 700 !important;
    }
    .st-badge-ga4, .channel-ga4 {
        background: #fffbeb !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
        font-weight: 700 !important;
    }
    .st-badge-webhook, .channel-webhook {
        background: #f5f3ff !important;
        color: #6d28d9 !important;
        border: 1px solid #ddd6fe !important;
        font-weight: 700 !important;
    }
    .channel-tiktok {
        background: #fdf2f8 !important;
        color: #db2777 !important;
        border: 1px solid #fbcfe8 !important;
        font-weight: 700 !important;
    }

    /* Bootstrap 5 subtle background compatibility */
    .bg-success-subtle { background-color: #ecfdf5 !important; border: 1px solid #a7f3d0 !important; color: #047857 !important; }
    .bg-info-subtle { background-color: #f0f9ff !important; border: 1px solid #bae6fd !important; color: #0369a1 !important; }
    .bg-warning-subtle { background-color: #fffbeb !important; border: 1px solid #fde68a !important; color: #b45309 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; border: 1px solid #fecaca !important; color: #b91c1c !important; }
    .bg-primary-subtle { background-color: #eff6ff !important; border: 1px solid #bfdbfe !important; color: #1d4ed8 !important; }
    .bg-secondary-subtle { background-color: #f1f5f9 !important; border: 1px solid #cbd5e1 !important; color: #475569 !important; }

    /* Solid color badge backgrounds */
    .badge.bg-danger, .badge.bg-danger.text-white { background-color: #ef4444 !important; color: #ffffff !important; border: none !important; }
    .badge.bg-warning, .badge.bg-warning.text-white { background-color: #f59e0b !important; color: #ffffff !important; border: none !important; }
    .badge.bg-success, .badge.bg-success.text-white { background-color: #10b981 !important; color: #ffffff !important; border: none !important; }
    .badge.bg-primary, .badge.bg-primary.text-white { background-color: #2563eb !important; color: #ffffff !important; border: none !important; }
    .badge.bg-dark, .badge.bg-dark.text-white { background-color: #0f172a !important; color: #ffffff !important; border: 1px solid #334155 !important; }
    .badge.text-white { color: #ffffff !important; }

    /* Color utility overrides */
    .text-purple { color: #7c3aed !important; }
    .text-emerald { color: #059669 !important; }
    .text-slate-dark { color: #0f172a !important; }
    .text-slate-muted { color: #475569 !important; }

    .badge-new { background: #7c3aed !important; color: #fff !important; border-radius: 20px !important; padding: 4px 12px !important; font-size: 12.5px !important; font-weight: 800 !important; }
    .badge-in_review { background: #d97706 !important; color: #fff !important; border-radius: 20px !important; padding: 4px 12px !important; font-size: 12.5px !important; font-weight: 800 !important; }
    .badge-contacted { background: #2563eb !important; color: #fff !important; border-radius: 20px !important; padding: 4px 12px !important; font-size: 12.5px !important; font-weight: 800 !important; }
    .badge-closed { background: #475569 !important; color: #fff !important; border-radius: 20px !important; padding: 4px 12px !important; font-size: 12.5px !important; font-weight: 800 !important; }

    /* --------------------------------------------------------------------------
       7. DATA TABLES
       -------------------------------------------------------------------------- */
    .premium-table thead th {
        background: #f8fafc;
        border-bottom: 1.5px solid #cbd5e1;
        color: #1e293b;
        font-size: 13.5px;
        font-weight: 800;
        padding: 15px 18px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        white-space: nowrap;
    }
    .premium-table tbody td {
        border-top: 1px solid #e2e8f0;
        color: #0f172a;
        font-size: 14.5px;
        font-weight: 500;
        padding: 15px 18px;
        vertical-align: middle;
    }
    .premium-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* --------------------------------------------------------------------------
       8. FORMS & INPUT CONTROLS
       -------------------------------------------------------------------------- */
    .premium-form label { 
        color: #0f172a; 
        font-size: 14.5px; 
        font-weight: 700; 
        margin-bottom: 8px; 
        display: block;
    }
    .premium-form .form-control, .premium-form .form-select { 
        border: 1.5px solid #cbd5e1; 
        border-radius: 9px; 
        min-height: 46px; 
        font-size: 15px;
        font-weight: 500;
        color: #0f172a;
        padding: 10px 14px;
        transition: all 0.2s ease;
    }
    .premium-form .form-control:focus, .premium-form .form-select:focus { 
        border-color: #4f46e5; 
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15); 
        background: #ffffff;
        outline: none;
    }
    .premium-muted { 
        color: #475569; 
        font-size: 13.5px;
        font-weight: 500;
    }

    .premium-page .card { 
        border: 1px solid #cbd5e1; 
        border-radius: 16px !important; 
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05) !important; 
        background: #ffffff;
    }
    .premium-page .card-header { 
        background: #ffffff !important; 
        border-bottom: 1px solid #e2e8f0 !important; 
        border-radius: 16px 16px 0 0 !important; 
        padding: 18px 24px;
    }
    .premium-page .table thead.bg-light th, .premium-page .table thead th { 
        color: #1e293b; 
        font-size: 13.5px; 
        font-weight: 800; 
        text-transform: uppercase; 
        letter-spacing: 0.6px;
    }

    @media (max-width: 767.98px) {
        .premium-page { padding: 16px; }
        .premium-header { align-items: flex-start; flex-direction: column; gap: 16px; padding: 20px; }
        .premium-actions { width: 100%; }
        .premium-actions .btn { flex: 1 1 auto; }
        .premium-card-title { display: block; }
    }
</style>
