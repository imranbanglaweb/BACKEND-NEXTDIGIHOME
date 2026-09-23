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
       6. STATUS BADGES
       -------------------------------------------------------------------------- */
    .badge-new { background: #7c3aed; color: #fff; border-radius: 20px; padding: 4px 12px; font-size: 12.5px; font-weight: 800; }
    .badge-in_review { background: #d97706; color: #fff; border-radius: 20px; padding: 4px 12px; font-size: 12.5px; font-weight: 800; }
    .badge-contacted { background: #2563eb; color: #fff; border-radius: 20px; padding: 4px 12px; font-size: 12.5px; font-weight: 800; }
    .badge-closed { background: #475569; color: #fff; border-radius: 20px; padding: 4px 12px; font-size: 12.5px; font-weight: 800; }

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
