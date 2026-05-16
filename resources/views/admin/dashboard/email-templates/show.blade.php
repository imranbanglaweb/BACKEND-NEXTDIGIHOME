@extends('admin.dashboard.master')

@section('title')
Email Template Details
@endsection

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary mb-0">
                <i class="fa fa-envelope"></i> Email Template Details
            </h4>
            <div>
                <a href="{{ route('email-templates.edit', $emailTemplate->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="{{ route('email-templates.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 1200px;">
            <div class="card-body p-4 bg-light">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Template Name</label>
                        <div class="fw-bold fs-5">{{ $emailTemplate->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Slug</label>
                        <div class="fw-bold fs-5">{{ $emailTemplate->slug }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Template Type</label>
                        <div>
                            @php $types = App\Models\EmailTemplate::getTemplateTypes(); @endphp
                            <span class="badge bg-primary fs-6">
                                {{ $types[$emailTemplate->type] ?? $emailTemplate->type }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Status</label>
                        <div>
                            @if($emailTemplate->trashed())
                                <span class="badge bg-secondary fs-6">Deleted</span>
                            @else
                                <span class="badge {{ $emailTemplate->is_active ? 'bg-success' : 'bg-danger' }} fs-6">
                                    {{ $emailTemplate->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Email Subject</label>
                        <div class="fw-bold fs-5">{{ $emailTemplate->subject }}</div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Email Body</label>
                        <div class="border rounded p-3 bg-white" style="min-height: 200px;">
                            {!! nl2br(e($emailTemplate->body)) !!}
                        </div>
                    </div>
                </div>

                @if($emailTemplate->variables)
                <hr>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Available Variables (JSON)</label>
                        <div class="border rounded p-3 bg-light">
                            <pre class="mb-0" style="white-space: pre-wrap;">{{ json_encode($emailTemplate->variables, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                </div>
                @endif

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Created By</label>
                        <div>
                            @if($emailTemplate->createdBy)
                                <i class="fa fa-user text-secondary"></i> {{ $emailTemplate->createdBy->name ?? 'Unknown' }}
                            @else
                                <span class="text-muted">System</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Created At</label>
                        <div>{{ $emailTemplate->created_at->format('d M, Y h:i A') }}</div>
                    </div>
                    @if($emailTemplate->updated_by)
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Updated By</label>
                        <div>
                            @if($emailTemplate->updatedBy)
                                <i class="fa fa-user-edit text-secondary"></i> {{ $emailTemplate->updatedBy->name ?? 'Unknown' }}
                            @else
                                <span class="text-muted">Unknown</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold small mb-1 text-muted">Updated At</label>
                        <div>{{ $emailTemplate->updated_at->format('d M, Y h:i A') }}</div>
                    </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
@endpush

@push('scripts')
<script>
$(function() {
    // No additional scripts needed for show page
});
</script>

<style>
.form-label {
    color: #000;
    font-size: 15px;
}
.card {
    background-color: #fff;
    padding: 20px;
}
.badge {
    font-size: 15px;
}
pre {
    font-size: 14px;
    color: #333;
}
</style>
@endpush
