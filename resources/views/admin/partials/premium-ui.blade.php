<style>
    .premium-page { background:#f6f8fb; min-height:calc(100vh - 70px); padding:24px; }
    .premium-header { align-items:center; background:#111827; border-radius:8px; color:#fff; display:flex; justify-content:space-between; margin-bottom:18px; padding:22px 24px; }
    .premium-header h2 { font-size:26px; font-weight:700; margin:0 0 4px; }
    .premium-header p { color:rgba(255,255,255,.72); margin:0; }
    .premium-eyebrow { color:#60a5fa; font-size:12px; font-weight:700; letter-spacing:0; text-transform:uppercase; }
    .premium-actions, .premium-nav { display:flex; flex-wrap:wrap; gap:10px; }
    .premium-nav { background:#fff; border:1px solid #e5e7eb; border-radius:8px; gap:8px; margin-bottom:16px; padding:10px; }
    .premium-nav a { border-radius:6px; color:#4b5563; font-size:13px; font-weight:700; padding:8px 12px; text-decoration:none; }
    .premium-nav a:hover, .premium-nav a.active { background:#111827; color:#fff; }
    .premium-card { background:#fff; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 8px 24px rgba(15,23,42,.06); padding:18px; }
    .premium-card-title { align-items:flex-start; display:flex; gap:12px; justify-content:space-between; margin-bottom:16px; }
    .premium-card-title h5 { color:#111827; font-size:18px; font-weight:700; margin:0 0 3px; }
    .premium-card-title p { color:#6b7280; margin:0; }
    .premium-stat { align-items:center; background:#fff; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 8px 24px rgba(15,23,42,.06); display:flex; gap:14px; min-height:98px; padding:18px; }
    .premium-stat small { color:#6b7280; display:block; font-size:13px; margin-bottom:5px; }
    .premium-stat strong { color:#111827; display:block; font-size:24px; line-height:1; }
    .premium-icon { align-items:center; border-radius:8px; color:#fff; display:inline-flex; flex:0 0 44px; height:44px; justify-content:center; width:44px; }
    .premium-blue { background:#2563eb; }
    .premium-green { background:#16a34a; }
    .premium-cyan { background:#0891b2; }
    .premium-amber { background:#d97706; }
    .premium-red { background:#dc2626; }
    .premium-table thead th { background:#f9fafb; border-bottom:1px solid #e5e7eb; color:#4b5563; font-size:12px; font-weight:700; padding:13px 12px; text-transform:uppercase; white-space:nowrap; }
    .premium-table tbody td { border-top:1px solid #edf0f4; color:#1f2937; padding:13px 12px; vertical-align:middle; }
    .premium-form label { color:#374151; font-size:13px; font-weight:700; margin-bottom:7px; }
    .premium-form .form-control, .premium-form .form-select { border:1px solid #d1d5db; border-radius:6px; min-height:42px; }
    .premium-form .form-control:focus, .premium-form .form-select:focus { border-color:#2563eb; box-shadow:0 0 0 .18rem rgba(37,99,235,.12); }
    .premium-muted { color:#6b7280; }
    .premium-page .text-white { color:#111827 !important; }
    .premium-page .text-white-50 { color:#6b7280 !important; }
    .premium-page .card { border:1px solid #e5e7eb; border-radius:8px !important; box-shadow:0 8px 24px rgba(15,23,42,.06) !important; }
    .premium-page .card-header { background:#fff !important; border-bottom:1px solid #edf0f4 !important; border-radius:8px 8px 0 0 !important; }
    .premium-page .table thead.bg-light th, .premium-page .table thead th { color:#4b5563; font-size:12px; font-weight:700; text-transform:uppercase; }
    @media (max-width:767px) {
        .premium-page { padding:14px; }
        .premium-header { align-items:flex-start; flex-direction:column; }
        .premium-actions, .premium-actions .btn { width:100%; }
        .premium-card-title { display:block; }
    }
</style>
