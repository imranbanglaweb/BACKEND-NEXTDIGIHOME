@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body customer-page">
    <div class="container-fluid">
        <div class="customer-header">
            <div>
                <div class="customer-eyebrow">Customers</div>
                <h2>Add Customer</h2>
                <p>Create a customer login with contact details and account status.</p>
            </div>
            <div class="customer-header-actions">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>All Customers
                </a>
            </div>
        </div>

        <div class="customer-nav mb-3">
            <a href="{{ route('admin.customers.index') }}">Customers</a>
            <a href="{{ route('admin.customers.create') }}" class="active">Add Customer</a>
            <a href="{{ route('admin.customer-groups.index') }}">Groups</a>
            <a href="{{ route('admin.customers.reviews') }}">Reviews</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-3 mb-3">
            <div class="col-xl-4 col-md-6">
                <div class="customer-stat-card">
                    <span class="stat-icon stat-blue"><i class="fas fa-users"></i></span>
                    <div><small>Total Customers</small><strong>{{ number_format($stats['total'] ?? 0) }}</strong></div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="customer-stat-card">
                    <span class="stat-icon stat-green"><i class="fas fa-user-check"></i></span>
                    <div><small>Active Customers</small><strong>{{ number_format($stats['active'] ?? 0) }}</strong></div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="customer-stat-card">
                    <span class="stat-icon stat-cyan"><i class="fas fa-calendar-plus"></i></span>
                    <div><small>New This Month</small><strong>{{ number_format($stats['new_this_month'] ?? 0) }}</strong></div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.customers.store') }}" method="POST" class="customer-panel">
            @csrf
            <div class="customer-panel-title">
                <h5>Account Details</h5>
                <p>Fields marked with an asterisk are required.</p>
            </div>

            <div class="row g-3">
                <div class="col-lg-6">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-lg-6">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" id="user_name" name="user_name" value="{{ old('user_name') }}" class="form-control @error('user_name') is-invalid @enderror" placeholder="Auto-filled from email if blank">
                    @error('user_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-lg-6">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-lg-6">
                    <label for="cell_phone" class="form-label">Phone</label>
                    <input type="text" id="cell_phone" name="cell_phone" value="{{ old('cell_phone') }}" class="form-control @error('cell_phone') is-invalid @enderror">
                    @error('cell_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-lg-6">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-lg-6">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <div class="col-lg-6">
                    <label for="status" class="form-label">Account Status <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="1" {{ old('status', '1') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-lg-6">
                    <label class="form-label d-block">Email Verification</label>
                    <label class="customer-toggle">
                        <input type="checkbox" name="email_verified" value="1" {{ old('email_verified', '1') ? 'checked' : '' }}>
                        <span>Mark email as verified</span>
                    </label>
                </div>
            </div>

            <div class="customer-form-actions">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Create Customer
                </button>
            </div>
        </form>
    </div>
</section>

<style>
    .customer-page { background:#f6f8fb; min-height:calc(100vh - 70px); padding:24px; }
    .customer-header { align-items:center; background:#111827; border-radius:8px; color:#fff; display:flex; justify-content:space-between; margin-bottom:18px; padding:22px 24px; }
    .customer-header h2 { font-size:26px; font-weight:700; margin:0 0 4px; }
    .customer-header p, .customer-panel-title p { margin:0; }
    .customer-header p { color:rgba(255,255,255,.72); }
    .customer-eyebrow { color:#60a5fa; font-size:12px; font-weight:700; text-transform:uppercase; }
    .customer-header-actions, .customer-nav { display:flex; flex-wrap:wrap; gap:10px; }
    .customer-nav { background:#fff; border:1px solid #e5e7eb; border-radius:8px; gap:8px; padding:10px; }
    .customer-nav a { border-radius:6px; color:#4b5563; font-size:13px; font-weight:700; padding:8px 12px; text-decoration:none; }
    .customer-nav a:hover, .customer-nav a.active { background:#111827; color:#fff; }
    .customer-stat-card, .customer-panel { background:#fff; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 8px 24px rgba(15,23,42,.06); }
    .customer-stat-card { align-items:center; display:flex; gap:14px; min-height:102px; padding:18px; }
    .customer-stat-card small { color:#6b7280; display:block; font-size:13px; margin-bottom:5px; }
    .customer-stat-card strong { color:#111827; display:block; font-size:24px; line-height:1; }
    .stat-icon { align-items:center; border-radius:8px; color:#fff; display:inline-flex; flex:0 0 44px; height:44px; justify-content:center; width:44px; }
    .stat-blue { background:#2563eb; }
    .stat-green { background:#16a34a; }
    .stat-cyan { background:#0891b2; }
    .customer-panel { padding:22px; }
    .customer-panel-title { border-bottom:1px solid #edf0f4; margin-bottom:18px; padding-bottom:14px; }
    .customer-panel-title h5 { color:#111827; font-size:18px; font-weight:700; margin:0 0 3px; }
    .customer-panel-title p { color:#6b7280; }
    .form-label { color:#374151; font-size:13px; font-weight:700; margin-bottom:7px; }
    .form-control { border:1px solid #d1d5db; border-radius:6px; min-height:42px; }
    .form-control:focus { border-color:#2563eb; box-shadow:0 0 0 .18rem rgba(37,99,235,.12); }
    .customer-toggle { align-items:center; border:1px solid #d1d5db; border-radius:6px; color:#374151; display:flex; font-weight:600; gap:10px; min-height:42px; padding:9px 12px; }
    .customer-toggle input { height:17px; width:17px; }
    .customer-form-actions { border-top:1px solid #edf0f4; display:flex; gap:10px; justify-content:flex-end; margin-top:22px; padding-top:18px; }
    @media (max-width:767px) {
        .customer-page { padding:14px; }
        .customer-header { align-items:flex-start; flex-direction:column; }
        .customer-header-actions, .customer-header-actions .btn, .customer-form-actions .btn { width:100%; }
        .customer-form-actions { flex-direction:column-reverse; }
    }
</style>
@endsection
