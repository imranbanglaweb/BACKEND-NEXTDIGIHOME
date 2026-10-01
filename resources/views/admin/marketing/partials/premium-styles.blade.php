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
        background: #ffffff;
        border: 1px solid rgba(148, 163, 184, .28);
        border-radius: 8px;
        box-shadow: 0 28px 90px rgba(15, 23, 42, .28);
        overflow: hidden;
    }

    .marketing-modal .modal-header {
        align-items: flex-start;
        background: linear-gradient(135deg, #0f172a 0%, #10263f 58%, #0f766e 100%);
        border: 0;
        color: #fff;
        min-height: 86px;
        padding: 22px 26px;
        position: relative;
    }

    .marketing-modal .modal-header::after {
        background: linear-gradient(90deg, #22c55e, #38bdf8, #f59e0b);
        bottom: 0;
        content: '';
        height: 3px;
        left: 0;
        position: absolute;
        right: 0;
    }

    .marketing-modal .modal-title {
        font-size: 21px;
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.2;
        margin: 0;
        padding-right: 42px;
    }

    .marketing-modal .btn-close {
        align-items: center;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 6px;
        color: #fff;
        display: inline-flex;
        filter: invert(1);
        height: 34px;
        justify-content: center;
        opacity: .95;
        padding: 0;
        width: 34px;
    }

    .marketing-modal .btn-close:hover {
        background: rgba(255, 255, 255, .22);
        opacity: 1;
    }

    .marketing-modal .modal-body {
        background: #f8fafc;
        padding: 24px 26px;
    }

    .marketing-modal .modal-body form {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
        padding: 18px;
    }

    .marketing-modal .modal-footer {
        background: #fff;
        border-top: 1px solid #e5e7eb;
        gap: 10px;
        padding: 16px 26px;
    }

    .marketing-modal .modal-footer .btn {
        border-radius: 6px;
        font-weight: 800;
        min-height: 40px;
        padding: 9px 16px;
    }

    .marketing-modal .modal-footer .btn-primary {
        background: #0f766e;
        border-color: #0f766e;
        box-shadow: 0 10px 22px rgba(15, 118, 110, .22);
    }

    .marketing-modal .modal-footer .btn-primary:hover {
        background: #115e59;
        border-color: #115e59;
    }

    .marketing-action-summary {
        align-items: center;
        display: flex;
        gap: 14px;
    }

    .marketing-action-summary .row-icon {
        align-items: center;
        border-radius: 8px;
        display: inline-flex;
        flex: 0 0 44px;
        height: 44px;
        justify-content: center;
        width: 44px;
    }

    .marketing-action-summary h6 {
        color: #111827;
        font-size: 16px;
        font-weight: 800;
        margin: 0;
    }

    .marketing-page .form-label,
    .marketing-modal .form-label {
        color: #1f2937;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0;
        margin-bottom: 7px;
    }

    .marketing-page .form-control,
    .marketing-page .form-select,
    .marketing-modal .form-control,
    .marketing-modal .form-select {
        background-color: #fff;
        border-color: #cbd5e1;
        border-radius: 6px;
        color: #111827;
        font-size: 14px;
        font-weight: 600;
        min-height: 42px;
    }

    .marketing-modal textarea.form-control {
        min-height: 96px;
    }

    .marketing-page .form-control:focus,
    .marketing-page .form-select:focus,
    .marketing-modal .form-control:focus,
    .marketing-modal .form-select:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, .14);
    }

    .marketing-page .form-control::placeholder,
    .marketing-modal .form-control::placeholder,
    .marketing-modal textarea.form-control::placeholder {
        color: #4b5563;
        font-weight: 700;
        opacity: 1;
    }

    .marketing-page .form-control::-webkit-input-placeholder,
    .marketing-modal .form-control::-webkit-input-placeholder,
    .marketing-modal textarea.form-control::-webkit-input-placeholder {
        color: #4b5563;
        font-weight: 700;
        opacity: 1;
    }

    .marketing-page .form-control::-moz-placeholder,
    .marketing-modal .form-control::-moz-placeholder,
    .marketing-modal textarea.form-control::-moz-placeholder {
        color: #4b5563;
        font-weight: 700;
        opacity: 1;
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
