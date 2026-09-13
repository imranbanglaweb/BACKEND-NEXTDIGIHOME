@extends('admin.dashboard.master')

@section('title', 'Inquiry #' . $inquiry->id . ' - ' . $inquiry->name)

@section('main_content')
<section class="content-body py-4" style="background: linear-gradient(135deg, #0b0d14 0%, #151824 100%); min-height: 100vh; color: #f1f5f9;">
    <div class="container-fluid">
        <!-- Back Navigation -->
        <div class="mb-4">
            <a href="{{ route('inquiries.index') }}" class="btn btn-outline-secondary btn-sm text-light">
                <i class="fas fa-arrow-left mr-1"></i> Back to All Inquiries
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Left: Inquiry Content -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-lg" style="background: #111827; border-radius: 14px; border: 1px solid #1f2937;">
                    <div class="card-header border-bottom border-dark py-3 d-flex justify-content-between align-items-center" style="background: #1a2234;">
                        <div>
                            <span class="badge badge-pill badge-primary px-3 py-1 mr-2">{{ $inquiry->service }}</span>
                            <span class="text-muted small">Inquiry ID: #{{ $inquiry->id }}</span>
                        </div>
                        <span class="text-muted small">
                            <i class="fas fa-clock mr-1"></i> {{ $inquiry->created_at->format('M d, Y - h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})
                        </span>
                    </div>

                    <div class="card-body p-4">
                        <h4 class="font-weight-bold text-white mb-3">{{ $inquiry->name }}</h4>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-2">
                                <span class="text-muted small text-uppercase">Email</span>
                                <div class="font-weight-bold">
                                    <a href="mailto:{{ $inquiry->email }}" class="text-info">
                                        <i class="fas fa-envelope mr-1"></i> {{ $inquiry->email }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="text-muted small text-uppercase">Phone / WhatsApp</span>
                                <div class="font-weight-bold">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" class="text-success">
                                        <i class="fab fa-whatsapp mr-1"></i> {{ $inquiry->phone }}
                                    </a>
                                </div>
                            </div>
                            @if($inquiry->company)
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted small text-uppercase">Company</span>
                                    <div class="text-light"><i class="fas fa-building mr-1 text-secondary"></i> {{ $inquiry->company }}</div>
                                </div>
                            @endif
                            <div class="col-md-6 mb-2">
                                <span class="text-muted small text-uppercase">Budget</span>
                                <div class="text-success font-weight-bold"><i class="fas fa-dollar-sign mr-1"></i> {{ $inquiry->budget ?: 'Not specified' }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="text-muted small text-uppercase">Timeline</span>
                                <div class="text-light"><i class="fas fa-calendar-alt mr-1 text-secondary"></i> {{ $inquiry->timeline ?: 'Flexible' }}</div>
                            </div>
                        </div>

                        <hr style="border-color: #1f2937;">

                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted small font-weight-bold mb-2">Project Brief / Message:</h6>
                            <div class="p-3 rounded text-white" style="background: #0f172a; border: 1px solid #1e293b; white-space: pre-wrap; line-height: 1.6; font-size: 14.5px;">{{ $inquiry->message }}</div>
                        </div>

                        <hr style="border-color: #1f2937;">

                        <!-- Metadata -->
                        <div class="small text-muted">
                            <div><strong>IP Address:</strong> {{ $inquiry->ip_address ?: 'Unknown' }}</div>
                            <div class="text-truncate"><strong>User Agent:</strong> {{ $inquiry->user_agent ?: 'Unknown' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Status Control & Direct Actions -->
            <div class="col-lg-4">
                <!-- Status Control Card -->
                <div class="card border-0 shadow-lg mb-4" style="background: #111827; border-radius: 14px; border: 1px solid #1f2937;">
                    <div class="card-header border-bottom border-dark py-3" style="background: #1a2234;">
                        <h6 class="mb-0 text-white font-weight-bold">
                            <i class="fas fa-tasks mr-2 text-warning"></i> Inquiry Status
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <span class="text-muted small">Current Status:</span>
                            <div class="mt-1">
                                @if($inquiry->status === 'new')
                                    <span class="badge badge-warning text-dark font-weight-bold px-3 py-2" style="font-size: 13px;">New / Unread</span>
                                @elseif($inquiry->status === 'in_review')
                                    <span class="badge badge-info px-3 py-2" style="font-size: 13px;">In Review</span>
                                @elseif($inquiry->status === 'contacted')
                                    <span class="badge badge-success px-3 py-2" style="font-size: 13px;">Contacted</span>
                                @elseif($inquiry->status === 'closed')
                                    <span class="badge badge-secondary px-3 py-2" style="font-size: 13px;">Closed</span>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('inquiries.update-status', $inquiry->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-3">
                                <label for="statusSelect" class="text-muted small text-uppercase">Change Status:</label>
                                <select name="status" id="statusSelect" class="form-control bg-dark text-white border-secondary">
                                    <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="in_review" {{ $inquiry->status === 'in_review' ? 'selected' : '' }}>In Review</option>
                                    <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save mr-1"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Direct Actions Card -->
                <div class="card border-0 shadow-lg mb-4" style="background: #111827; border-radius: 14px; border: 1px solid #1f2937;">
                    <div class="card-header border-bottom border-dark py-3" style="background: #1a2234;">
                        <h6 class="mb-0 text-white font-weight-bold">
                            <i class="fas fa-bolt mr-2 text-info"></i> Direct Contact
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Regarding your inquiry for ' . $inquiry->service . ' - NextDigiHome') }}" class="btn btn-outline-info btn-block mb-2 text-left">
                            <i class="fas fa-envelope mr-2"></i> Send Email
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" class="btn btn-outline-success btn-block mb-2 text-left">
                            <i class="fab fa-whatsapp mr-2"></i> Message on WhatsApp
                        </a>
                        <a href="tel:{{ $inquiry->phone }}" class="btn btn-outline-light btn-block mb-3 text-left">
                            <i class="fas fa-phone mr-2"></i> Direct Phone Call
                        </a>

                        <hr style="border-color: #1f2937;">

                        <form action="{{ route('inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this inquiry?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-block btn-sm">
                                <i class="fas fa-trash-alt mr-1"></i> Delete Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
