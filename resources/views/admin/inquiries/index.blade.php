@extends('admin.dashboard.master')

@section('title', 'Project Inquiries')

@section('main_content')
<section class="content-body py-4" style="background: linear-gradient(135deg, #0b0d14 0%, #151824 100%); min-height: 100vh; color: #f1f5f9;">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h3 class="font-weight-bold text-white mb-1">
                    <i class="fas fa-paper-plane mr-2 text-primary"></i> Project Inquiries & Leads
                </h3>
                <p class="text-muted mb-0 small">Client inquiries submitted from the NextDigiHome website & ecosystem solutions</p>
            </div>
            <div class="mt-2 mt-md-0">
                <span class="badge badge-pill badge-info px-3 py-2">
                    <i class="fas fa-bell mr-1"></i> {{ $counts['new'] }} New Inquiries
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Quick Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="btn-group flex-wrap" role="group">
                    <a href="{{ route('inquiries.index', ['status' => 'all']) }}" class="btn btn-sm {{ request('status', 'all') === 'all' ? 'btn-primary' : 'btn-outline-secondary text-white' }} px-3">
                        All <span class="badge badge-light ml-1">{{ $counts['all'] }}</span>
                    </a>
                    <a href="{{ route('inquiries.index', ['status' => 'new']) }}" class="btn btn-sm {{ request('status') === 'new' ? 'btn-warning text-dark font-weight-bold' : 'btn-outline-warning' }} px-3">
                        New / Unread <span class="badge badge-light ml-1">{{ $counts['new'] }}</span>
                    </a>
                    <a href="{{ route('inquiries.index', ['status' => 'in_review']) }}" class="btn btn-sm {{ request('status') === 'in_review' ? 'btn-info' : 'btn-outline-info' }} px-3">
                        In Review <span class="badge badge-light ml-1">{{ $counts['in_review'] }}</span>
                    </a>
                    <a href="{{ route('inquiries.index', ['status' => 'contacted']) }}" class="btn btn-sm {{ request('status') === 'contacted' ? 'btn-success' : 'btn-outline-success' }} px-3">
                        Contacted <span class="badge badge-light ml-1">{{ $counts['contacted'] }}</span>
                    </a>
                    <a href="{{ route('inquiries.index', ['status' => 'closed']) }}" class="btn btn-sm {{ request('status') === 'closed' ? 'btn-secondary' : 'btn-outline-secondary' }} px-3">
                        Closed <span class="badge badge-light ml-1">{{ $counts['closed'] }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <div class="card border-0 shadow-sm mb-4" style="background: rgba(30, 41, 59, 0.7); border-radius: 12px; backdrop-filter: blur(10px);">
            <div class="card-body p-3">
                <form action="{{ route('inquiries.index') }}" method="GET" class="row align-items-center">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="col-md-9 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control bg-dark text-white border-secondary" placeholder="Search by client name, email, phone, company, or service..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Inquiries Table Card -->
        <div class="card border-0 shadow-lg" style="background: #111827; border-radius: 14px; overflow: hidden; border: 1px solid #1f2937;">
            <div class="card-header border-bottom border-dark d-flex justify-content-between align-items-center py-3" style="background: #1a2234;">
                <h5 class="mb-0 text-white font-weight-bold">
                    <i class="fas fa-list-alt mr-2 text-info"></i> Inquiries ({{ $inquiries->total() }})
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-white" style="background: transparent;">
                        <thead style="background: #1e293b; color: #94a3b8; font-size: 13px; text-transform: uppercase;">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Client Details</th>
                                <th>Target Service</th>
                                <th>Budget & Timeline</th>
                                <th>Status</th>
                                <th>Received</th>
                                <th class="text-right" style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inquiries as $inquiry)
                                <tr style="border-bottom: 1px solid #1f2937; {{ $inquiry->status === 'new' ? 'background: rgba(59, 130, 246, 0.05);' : '' }}">
                                    <td class="text-muted small align-middle">#{{ $inquiry->id }}</td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold text-white">{{ $inquiry->name }}</div>
                                        <div class="small text-muted">
                                            <i class="fas fa-envelope mr-1 text-primary"></i> <a href="mailto:{{ $inquiry->email }}" class="text-info">{{ $inquiry->email }}</a>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="fas fa-phone-alt mr-1 text-success"></i> <a href="tel:{{ $inquiry->phone }}" class="text-light">{{ $inquiry->phone }}</a>
                                            @if($inquiry->company)
                                                <span class="ml-2 badge badge-dark"><i class="fas fa-building mr-1"></i> {{ $inquiry->company }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-pill badge-primary px-2 py-1 font-weight-normal" style="font-size: 12px;">
                                            {{ $inquiry->service }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="small font-weight-bold text-success">
                                            <i class="fas fa-wallet mr-1"></i> {{ $inquiry->budget ?: 'Not specified' }}
                                        </div>
                                        <div class="small text-muted">
                                            <i class="fas fa-calendar-alt mr-1"></i> {{ $inquiry->timeline ?: 'Flexible' }}
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @if($inquiry->status === 'new')
                                            <span class="badge badge-warning text-dark font-weight-bold px-2 py-1">New</span>
                                        @elseif($inquiry->status === 'in_review')
                                            <span class="badge badge-info px-2 py-1">In Review</span>
                                        @elseif($inquiry->status === 'contacted')
                                            <span class="badge badge-success px-2 py-1">Contacted</span>
                                        @elseif($inquiry->status === 'closed')
                                            <span class="badge badge-secondary px-2 py-1">Closed</span>
                                        @endif
                                    </td>
                                    <td class="align-middle small text-muted">
                                        <div>{{ $inquiry->created_at->format('M d, Y') }}</div>
                                        <div class="text-secondary">{{ $inquiry->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="align-middle text-right">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('inquiries.show', $inquiry->id) }}" class="btn btn-outline-info" title="View Inquiry">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <form action="{{ route('inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
                                        <p class="mb-0">No project inquiries found matching your filter criteria.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($inquiries->hasPages())
                <div class="card-footer border-top border-dark d-flex justify-content-end py-3" style="background: #1a2234;">
                    {{ $inquiries->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
