@extends('admin.dashboard.master')

@section('title', 'Inquiry #' . ($inquiry->lead_id ?: $inquiry->id) . ' - ' . $inquiry->name)

@section('main_content')
<section class="content-body py-4" style="background: linear-gradient(135deg, #0b0d14 0%, #151824 100%); min-height: 100vh; color: #f1f5f9;">
    <div class="container-fluid">
        <!-- Back Navigation -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('inquiries.index') }}" class="btn btn-outline-secondary btn-sm text-light">
                <i class="fas fa-arrow-left mr-1"></i> Back to All Inquiries
            </a>
            @if($inquiry->lead_id)
                <span class="badge badge-dark px-3 py-2 font-mono text-muted border border-secondary">
                    Lead Ref: <strong class="text-info">{{ $inquiry->lead_id }}</strong>
                </span>
            @endif
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
                <div class="card border-0 shadow-lg mb-4" style="background: #111827; border-radius: 14px; border: 1px solid #1f2937;">
                    <div class="card-header border-bottom border-dark py-3 d-flex justify-content-between align-items-center" style="background: #1a2234;">
                        <div>
                            <span class="badge badge-pill badge-primary px-3 py-1 mr-2">{{ $inquiry->service }}</span>
                            @php
                                $priority = strtoupper($inquiry->priority ?: 'LOW');
                                $score = $inquiry->lead_score ?: 20;
                            @endphp
                            @if($priority === 'HIGH')
                                <span class="badge badge-danger px-2 py-1 font-weight-bold">HIGH PRIORITY</span>
                            @elseif($priority === 'MEDIUM')
                                <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold">MEDIUM PRIORITY</span>
                            @else
                                <span class="badge badge-secondary px-2 py-1">LOW PRIORITY</span>
                            @endif
                            <span class="badge badge-info ml-2 px-2 py-1">Score: {{ $score }}/100</span>
                        </div>
                        <span class="text-muted small">
                            <i class="fas fa-clock mr-1"></i> {{ $inquiry->created_at->format('M d, Y - h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})
                        </span>
                    </div>

                    <div class="card-body p-4">
                        <h4 class="font-weight-bold text-white mb-3">{{ $inquiry->name }}</h4>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <span class="text-muted small text-uppercase">Email Address</span>
                                <div class="font-weight-bold">
                                    <a href="mailto:{{ $inquiry->email }}" class="text-info">
                                        <i class="fas fa-envelope mr-1"></i> {{ $inquiry->email }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="text-muted small text-uppercase">Phone / Mobile</span>
                                <div class="font-weight-bold">
                                    <a href="tel:{{ $inquiry->phone }}" class="text-light">
                                        <i class="fas fa-phone-alt mr-1 text-success"></i> {{ $inquiry->phone }}
                                    </a>
                                </div>
                            </div>
                            @if($inquiry->whatsapp)
                                <div class="col-md-6 mb-3">
                                    <span class="text-muted small text-uppercase">WhatsApp</span>
                                    <div class="font-weight-bold">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->whatsapp) }}" target="_blank" class="text-success">
                                            <i class="fab fa-whatsapp mr-1"></i> {{ $inquiry->whatsapp }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($inquiry->company)
                                <div class="col-md-6 mb-3">
                                    <span class="text-muted small text-uppercase">Company / Organization</span>
                                    <div class="text-light"><i class="fas fa-building mr-1 text-secondary"></i> {{ $inquiry->company }}</div>
                                </div>
                            @endif
                            @if($inquiry->website)
                                <div class="col-md-6 mb-3">
                                    <span class="text-muted small text-uppercase">Website</span>
                                    <div>
                                        <a href="{{ $inquiry->website }}" target="_blank" class="text-info">
                                            <i class="fas fa-globe mr-1"></i> {{ $inquiry->website }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6 mb-3">
                                <span class="text-muted small text-uppercase">Budget</span>
                                <div class="text-success font-weight-bold"><i class="fas fa-wallet mr-1"></i> {{ $inquiry->budget ?: 'Not specified' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="text-muted small text-uppercase">Target Timeline</span>
                                <div class="text-light"><i class="fas fa-calendar-alt mr-1 text-secondary"></i> {{ $inquiry->timeline ?: 'Flexible' }}</div>
                            </div>
                            @if($inquiry->contact_method)
                                <div class="col-md-6 mb-3">
                                    <span class="text-muted small text-uppercase">Preferred Contact</span>
                                    <div class="text-light"><i class="fas fa-comment-dots mr-1 text-info"></i> {{ $inquiry->contact_method }}</div>
                                </div>
                            @endif
                            @if($inquiry->lead_source)
                                <div class="col-md-6 mb-3">
                                    <span class="text-muted small text-uppercase">Acquisition Source</span>
                                    <div class="text-light"><i class="fas fa-bullhorn mr-1 text-warning"></i> {{ $inquiry->lead_source }}</div>
                                </div>
                            @endif
                        </div>

                        <!-- Service-Specific Details (if present) -->
                        @if(!empty($inquiry->service_details) && is_array($inquiry->service_details))
                            <div class="p-3 rounded mb-4" style="background: rgba(0, 212, 170, 0.05); border: 1px solid rgba(0, 212, 170, 0.2);">
                                <h6 class="text-uppercase text-[#00d4aa] font-weight-bold mb-2 small" style="color: #00d4aa;">
                                    <i class="fas fa-cogs mr-1"></i> Service-Specific Scope Details:
                                </h6>
                                <div class="row">
                                    @foreach($inquiry->service_details as $key => $val)
                                        <div class="col-md-6 mb-2">
                                            <span class="text-muted small text-capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                            <span class="text-white font-weight-bold ml-1">{{ is_array($val) ? implode(', ', $val) : $val }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <hr style="border-color: #1f2937;">

                        <!-- Project Message -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted small font-weight-bold mb-2">Project Brief / Message:</h6>
                            <div class="p-3 rounded text-white" style="background: #0f172a; border: 1px solid #1e293b; white-space: pre-wrap; line-height: 1.6; font-size: 14.5px;">{{ $inquiry->message }}</div>
                        </div>

                        <!-- Lead Score Reasons -->
                        @if(!empty($inquiry->score_reasons) && is_array($inquiry->score_reasons))
                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted small font-weight-bold mb-2">Lead Qualification Signals:</h6>
                                <ul class="list-unstyled mb-0">
                                    @foreach($inquiry->score_reasons as $reason)
                                        <li class="text-light small mb-1">
                                            <i class="fas fa-check text-success mr-2"></i> {{ $reason }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <hr style="border-color: #1f2937;">

                        <!-- Attribution & Telemetry -->
                        <div class="row small text-muted">
                            <div class="col-md-6 mb-2">
                                <strong>Landing Page:</strong> {{ $inquiry->landing_page ?: 'Direct' }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Referrer:</strong> {{ $inquiry->referrer ?: 'Direct' }}
                            </div>
                            @if($inquiry->utm_source || $inquiry->utm_campaign)
                                <div class="col-12 mb-2">
                                    <strong>UTM Campaign:</strong>
                                    <span class="badge badge-secondary font-mono">
                                        {{ $inquiry->utm_source ?: 'none' }} / {{ $inquiry->utm_medium ?: 'none' }} / {{ $inquiry->utm_campaign ?: 'none' }}
                                    </span>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <strong>IP Address:</strong> {{ $inquiry->ip_address ?: 'Unknown' }}
                            </div>
                            <div class="col-md-6 text-truncate">
                                <strong>User Agent:</strong> {{ $inquiry->user_agent ?: 'Unknown' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Internal Notes Card -->
                <div class="card border-0 shadow-lg" style="background: #111827; border-radius: 14px; border: 1px solid #1f2937;">
                    <div class="card-header border-bottom border-dark py-3 d-flex justify-content-between align-items-center" style="background: #1a2234;">
                        <h6 class="mb-0 text-white font-weight-bold">
                            <i class="fas fa-sticky-note mr-2 text-warning"></i> Internal Admin Notes
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <!-- Add Note Form -->
                        <form action="{{ route('inquiries.add-note', $inquiry->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="form-group mb-2">
                                <textarea name="note" rows="2" class="form-control bg-dark text-white border-secondary" placeholder="Add an internal note or status comment about this inquiry..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus mr-1"></i> Add Internal Note
                            </button>
                        </form>

                        <!-- Notes Timeline -->
                        @php
                            $notes = is_array($inquiry->notes) ? $inquiry->notes : [];
                        @endphp
                        @if(count($notes) > 0)
                            <div class="timeline-notes">
                                @foreach($notes as $n)
                                    <div class="p-3 mb-2 rounded" style="background: #1e293b; border-left: 3px solid #3b82f6;">
                                        <div class="d-flex justify-content-between text-muted small mb-1">
                                            <strong>{{ $n['author'] ?? 'Admin' }}</strong>
                                            <span>{{ $n['created_at'] ?? '' }}</span>
                                        </div>
                                        <div class="text-white small" style="white-space: pre-wrap;">{{ $n['text'] ?? '' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small mb-0">No internal notes added yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Status Control & Direct Actions -->
            <div class="col-lg-4">
                <!-- Status & Priority Control Card -->
                <div class="card border-0 shadow-lg mb-4" style="background: #111827; border-radius: 14px; border: 1px solid #1f2937;">
                    <div class="card-header border-bottom border-dark py-3" style="background: #1a2234;">
                        <h6 class="mb-0 text-white font-weight-bold">
                            <i class="fas fa-tasks mr-2 text-warning"></i> Status &amp; Priority
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <span class="text-muted small">Status:</span>
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

                        <!-- Update Status Form -->
                        <form action="{{ route('inquiries.update-status', $inquiry->id) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-2">
                                <label for="statusSelect" class="text-muted small text-uppercase">Change Status:</label>
                                <select name="status" id="statusSelect" class="form-control bg-dark text-white border-secondary">
                                    <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="in_review" {{ $inquiry->status === 'in_review' ? 'selected' : '' }}>In Review</option>
                                    <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-sm">
                                <i class="fas fa-save mr-1"></i> Update Status
                            </button>
                        </form>

                        <hr style="border-color: #1f2937;">

                        <!-- Update Priority Form -->
                        <form action="{{ route('inquiries.update-priority', $inquiry->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-2">
                                <label for="prioritySelect" class="text-muted small text-uppercase">Change Priority:</label>
                                <select name="priority" id="prioritySelect" class="form-control bg-dark text-white border-secondary">
                                    <option value="LOW" {{ strtoupper($inquiry->priority) === 'LOW' ? 'selected' : '' }}>Low Priority</option>
                                    <option value="MEDIUM" {{ strtoupper($inquiry->priority) === 'MEDIUM' ? 'selected' : '' }}>Medium Priority</option>
                                    <option value="HIGH" {{ strtoupper($inquiry->priority) === 'HIGH' ? 'selected' : '' }}>High Priority</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-warning btn-block btn-sm">
                                <i class="fas fa-flag mr-1"></i> Update Priority
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
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $inquiry->whatsapp ?: $inquiry->phone);
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="btn btn-outline-success btn-block mb-2 text-left">
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
