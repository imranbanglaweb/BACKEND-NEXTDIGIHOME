<style>
    .premium-page { background: #f8fafc; min-height: calc(100vh - 66px); padding: 24px; }
    .premium-page .container-fluid { padding-left: 0 !important; padding-right: 0 !important; }
    .dashboard-stat-link { text-decoration: none !important; color: inherit !important; display: block; height: 100%; }
    
    /* Hero Header */
    .premium-header {
        align-items: center;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
        padding: 22px 26px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
    }
    .premium-header h2 {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #ffffff;
        margin: 0 0 6px;
    }
    .premium-header p {
        color: rgba(255, 255, 255, 0.78);
        font-size: 14px;
        margin: 0;
    }
    .premium-eyebrow {
        color: #38bdf8;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    /* Hero Action Buttons */
    .premium-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .premium-actions .btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        padding: 8px 18px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        line-height: 1.4 !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        white-space: nowrap !important;
    }
    .premium-actions .btn i {
        font-size: 13px !important;
        line-height: 1 !important;
    }
    .premium-actions .btn-outline-light {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.22) !important;
        backdrop-filter: blur(8px) !important;
    }
    .premium-actions .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.18) !important;
        border-color: rgba(255, 255, 255, 0.45) !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
    }
    .premium-actions .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;
    }
    .premium-actions .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.5) !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
    }

    /* Navigation Pills Bar */
    .premium-nav {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        margin-bottom: 20px;
        padding: 8px 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .premium-nav a {
        border-radius: 7px;
        color: #4b5563;
        font-size: 13px;
        font-weight: 600;
        padding: 7px 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .premium-nav a:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .premium-nav a.active {
        background: #0f172a;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.25);
    }
    .premium-nav a .badge {
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 10px;
    }

    /* Grid Layout System */
    .premium-stats-grid {
        display: grid !important;
        grid-template-columns: 1.25fr 1fr 1fr 1fr 1fr !important;
        gap: 16px !important;
        margin-bottom: 20px !important;
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
        gap: 16px !important;
        margin-bottom: 20px !important;
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
        gap: 16px !important;
        margin-bottom: 20px !important;
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

    /* Cards & Stats */
    .premium-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        padding: 20px;
    }
    .premium-card-title {
        align-items: flex-start;
        display: flex;
        gap: 12px;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .premium-card-title h5 {
        color: #111827;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 3px;
    }
    .premium-card-title p {
        color: #6b7280;
        font-size: 13px;
        margin: 0;
    }
    .premium-stat {
        align-items: center;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        display: flex;
        gap: 14px;
        height: 100%;
        min-height: 94px;
        padding: 18px 20px;
        transition: all 0.2s ease;
    }
    .premium-stat:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        transform: translateY(-2px);
    }
    .premium-stat small {
        color: #6b7280;
        display: block;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 4px;
    }
    .premium-stat strong {
        color: #0f172a;
        display: block;
        font-size: 24px;
        font-weight: 800;
        line-height: 1.1;
    }
    .premium-icon {
        align-items: center;
        border-radius: 10px;
        color: #ffffff;
        display: inline-flex;
        flex: 0 0 46px;
        height: 46px;
        justify-content: center;
        width: 46px;
        font-size: 18px;
    }
    .premium-blue { background: #2563eb; }
    .premium-green { background: #16a34a; }
    .premium-cyan { background: #0891b2; }
    .premium-amber { background: #d97706; }
    .premium-red { background: #dc2626; }
    .premium-purple { background: #7c3aed; }

    /* Badges */
    .badge-new { background: #7c3aed; color: #fff; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 700; }
    .badge-in_review { background: #d97706; color: #fff; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 700; }
    .badge-contacted { background: #2563eb; color: #fff; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 700; }
    .badge-closed { background: #6b7280; color: #fff; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 700; }

    /* Tables */
    .premium-table thead th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        padding: 13px 14px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .premium-table tbody td {
        border-top: 1px solid #f1f5f9;
        color: #1e293b;
        padding: 13px 14px;
        vertical-align: middle;
    }

    /* Forms */
    .premium-form label { color: #374151; font-size: 13px; font-weight: 700; margin-bottom: 7px; }
    .premium-form .form-control, .premium-form .form-select { border: 1px solid #d1d5db; border-radius: 6px; min-height: 42px; }
    .premium-form .form-control:focus, .premium-form .form-select:focus { border-color: #2563eb; box-shadow: 0 0 0 .18rem rgba(37,99,235,.12); }
    .premium-muted { color: #6b7280; }

    .premium-page .card { border: 1px solid #e5e7eb; border-radius: 12px !important; box-shadow: 0 4px 16px rgba(15,23,42,.04) !important; }
    .premium-page .card-header { background: #fff !important; border-bottom: 1px solid #edf0f4 !important; border-radius: 12px 12px 0 0 !important; }
    .premium-page .table thead.bg-light th, .premium-page .table thead th { color: #4b5563; font-size: 12px; font-weight: 700; text-transform: uppercase; }

    @media (max-width: 767.98px) {
        .premium-page { padding: 14px; }
        .premium-header { align-items: flex-start; flex-direction: column; gap: 14px; }
        .premium-actions { width: 100%; }
        .premium-actions .btn { flex: 1 1 auto; }
        .premium-card-title { display: block; }
    }
</style>
