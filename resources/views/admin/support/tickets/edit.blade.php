@extends('admin.dashboard.master')

@section('title', 'Edit Support Ticket')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Ticket #{{ $ticket->ticket_number }}</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.support.tickets.show', $ticket) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View Ticket
                        </a>
                        <a href="{{ route('admin.support.tickets.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Tickets
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.support.tickets.update', $ticket) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="subject">Subject <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                           id="subject" name="subject" value="{{ old('subject', $ticket->subject) }}" required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="open" {{ old('status', $ticket->status) === 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="pending" {{ old('status', $ticket->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('status', $ticket->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ old('status', $ticket->status) === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="closed" {{ old('status', $ticket->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority">Priority <span class="text-danger">*</span></label>
                                    <select class="form-control @error('priority') is-invalid @enderror"
                                            id="priority" name="priority" required>
                                        <option value="low" {{ old('priority', $ticket->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority', $ticket->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority', $ticket->priority) === 'high' ? 'selected' : '' }}>High</option>
                                        <option value="urgent" {{ old('priority', $ticket->priority) === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                    <select class="form-control @error('customer_id') is-invalid @enderror"
                                            id="customer_id" name="customer_id" required>
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                    {{ old('customer_id', $ticket->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="assigned_to">Assign To</label>
                                    <select class="form-control @error('assigned_to') is-invalid @enderror"
                                            id="assigned_to" name="assigned_to">
                                        <option value="">Unassigned</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}"
                                                    {{ old('assigned_to', $ticket->assigned_to) == $admin->id ? 'selected' : '' }}>
                                                {{ $admin->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                   id="tags" name="tags" value="{{ old('tags') ? implode(',', old('tags')) : ($ticket->tags ? implode(',', $ticket->tags) : '') }}"
                                   placeholder="Enter tags separated by commas">
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Separate multiple tags with commas</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="6" required>{{ old('description', $ticket->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Ticket
                            </button>
                            <a href="{{ route('admin.support.tickets.show', $ticket) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize select2 for better UX if available
$(document).ready(function() {
    // Convert tags input to array for form submission
    $('#tags').on('change', function() {
        const tags = $(this).val().split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
        // This will be handled by Laravel's array casting in the model
    });
});
</script>
@endsection