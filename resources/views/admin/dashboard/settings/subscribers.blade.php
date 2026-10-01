@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body bg-light py-4" style="background-color:#fff">

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Push Notification Subscribers</h3>
            <small class="text-muted">Users currently receiving system notifications</small>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Subscribers</h6>
                    <h3 class="fw-bold">{{ $subscriptions->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Today</h6>
                    <h3 class="fw-bold">
                        {{ $subscriptions->where('created_at', '>=', now()->startOfDay())->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">This Month</h6>
                    <h3 class="fw-bold">
                        {{ $subscriptions->where('created_at', '>=', now()->startOfMonth())->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-lg">
        <div class="card-body">

            <!-- Search -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchInput" class="form-control"
                        placeholder="Search by name or email">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover" id="subscriberTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Endpoint</th>
                            <th>Subscribed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $sub)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center"
                                         style="width:38px;height:38px;">
                                        {{ strtoupper(substr($sub->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $sub->user->name ?? 'N/A' }}</div>
                                        <small class="text-muted">User ID: {{ $sub->user->id ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $sub->user->email ?? 'N/A' }}</td>

                            <td>
                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    Active
                                </span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted small">
                                        {{ Str::limit($sub->endpoint, 35) }}
                                    </span>
                                    <button class="btn btn-sm btn-outline-secondary"
                                        onclick="navigator.clipboard.writeText('{{ $sub->endpoint }}')">
                                        Copy
                                    </button>
                                </div>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $sub->created_at->format('d M Y') }}
                                </div>
                                <small class="text-muted">
                                    {{ $sub->created_at->format('h:i A') }}
                                </small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <h5 class="text-muted">No subscribers found</h5>
                                <p class="text-muted mb-0">
                                    Users will appear here after enabling browser notifications.
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
</section>

<!-- Search Script -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll('#subscriberTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';
    });
});
</script>

@endsection
