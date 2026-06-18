<style>
    .marketing-page {
        background: #f6f8fb;
        min-height: calc(100vh - 70px);
        padding: 24px;
    }

    .marketing-header {
        align-items: center;
        background: #111827;
        border-radius: 8px;
        color: #fff;
        display: flex;
        gap: 18px;
        justify-content: space-between;
        margin-bottom: 18px;
        padding: 22px 24px;
    }

    .marketing-eyebrow {
        color: #93c5fd;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .08em;
        margin-bottom: 4px;
        text-transform: uppercase;
    }

    .marketing-header h2 {
        font-size: 26px;
        font-weight: 800;
        margin: 0 0 4px;
    }

    .marketing-header p {
        color: rgba(255, 255, 255, 0.72);
        margin: 0;
    }

    .marketing-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .marketing-stat-card,
    .marketing-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
    }

    .marketing-stat-card {
        align-items: center;
        display: flex;
        gap: 14px;
        min-height: 92px;
        padding: 16px;
    }

    .marketing-stat-card .stat-icon {
        align-items: center;
        border-radius: 8px;
        display: inline-flex;
        flex: 0 0 44px;
        height: 44px;
        justify-content: center;
        width: 44px;
    }

    .marketing-stat-card small {
        color: #6b7280;
        display: block;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    .marketing-stat-card strong {
        color: #111827;
        display: block;
        font-size: 24px;
        line-height: 1.1;
        margin-top: 4px;
    }

    .stat-blue { background: #dbeafe; color: #1d4ed8; }
    .stat-green { background: #dcfce7; color: #15803d; }
    .stat-amber { background: #fef3c7; color: #b45309; }
    .stat-cyan { background: #cffafe; color: #0e7490; }
    .stat-red { background: #fee2e2; color: #b91c1c; }
    .stat-violet { background: #ede9fe; color: #6d28d9; }

    .marketing-panel {
        padding: 18px;
    }

    .marketing-panel-title {
        align-items: center;
        display: flex;
        gap: 14px;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .marketing-panel-title h5 {
        color: #111827;
        font-size: 18px;
        font-weight: 800;
        margin: 0 0 3px;
    }

    .marketing-panel-title p {
        color: #6b7280;
        margin: 0;
    }

    .marketing-tools {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: flex-end;
    }

    .marketing-tools .form-control,
    .marketing-tools .form-select {
        border-color: #d1d5db;
        border-radius: 6px;
        min-height: 38px;
    }

    .marketing-tools .search-field {
        min-width: 240px;
    }

    .marketing-table-wrap {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
    }

    .marketing-page .table {
        margin-bottom: 0;
    }

    .marketing-page .table th {
        background: #111827;
        border-color: #111827;
        color: #fff;
        font-size: 12px;
        letter-spacing: .03em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .marketing-page .table td {
        color: #374151;
        vertical-align: middle;
    }

    .marketing-title-cell {
        align-items: center;
        display: flex;
        gap: 12px;
        min-width: 220px;
    }

    .marketing-title-cell .row-icon {
        align-items: center;
        border-radius: 8px;
        display: inline-flex;
        flex: 0 0 38px;
        height: 38px;
        justify-content: center;
        width: 38px;
    }

    .marketing-title-cell h6 {
        color: #111827;
        font-weight: 800;
        margin: 0;
    }

    .marketing-title-cell small {
        color: #6b7280;
    }

    .marketing-page .badge {
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        padding: 7px 10px;
    }

    .badge-soft-blue { background: #eff6ff; color: #1d4ed8; }
    .badge-soft-green { background: #ecfdf3; color: #047857; }
    .badge-soft-amber { background: #fffbeb; color: #b45309; }
    .badge-soft-red { background: #fef2f2; color: #b91c1c; }
    .badge-soft-slate { background: #f1f5f9; color: #475569; }

    .marketing-actions {
        display: inline-flex;
        gap: 6px;
        white-space: nowrap;
    }

    .marketing-actions .btn,
    .marketing-page .template-actions .btn {
        align-items: center;
        border-radius: 6px;
        display: inline-flex;
        height: 32px;
        justify-content: center;
        padding: 0;
        width: 34px;
    }

    .marketing-modal .modal-content {
        border: 0;
        border-radius: 8px;
        box-shadow: 0 24px 80px rgba(15, 23, 42, .24);
        overflow: hidden;
    }

    .marketing-modal .modal-header {
        background: #111827;
        border: 0;
        color: #fff;
        padding: 18px 22px;
    }

    .marketing-modal .modal-title {
        font-size: 18px;
        font-weight: 800;
    }

    .marketing-modal .btn-close {
        filter: invert(1);
        opacity: .85;
    }

    .marketing-modal .modal-footer {
        border-top: 1px solid #e5e7eb;
    }

    .marketing-page .form-label,
    .marketing-modal .form-label {
        color: #374151;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .marketing-page .form-control,
    .marketing-page .form-select,
    .marketing-modal .form-control,
    .marketing-modal .form-select {
        border-color: #d1d5db;
        border-radius: 6px;
        min-height: 38px;
    }

    @media (max-width: 767px) {
        .marketing-page {
            padding: 14px;
        }

        .marketing-header,
        .marketing-panel-title {
            align-items: flex-start;
            flex-direction: column;
        }

        .marketing-header-actions,
        .marketing-header-actions .btn,
        .marketing-tools,
        .marketing-tools .form-control,
        .marketing-tools .form-select,
        .marketing-tools .search-field {
            width: 100%;
        }
    }
</style>
