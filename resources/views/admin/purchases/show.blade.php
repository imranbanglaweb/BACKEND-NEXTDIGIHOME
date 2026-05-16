@extends('admin.dashboard.master')

@section('title', 'View Purchase')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Purchase #{{ $purchase->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Purchase ID:</strong> {{ $purchase->id }}</p>
                            <p><strong>Product:</strong> {{ optional($purchase->product)->name ?? 'N/A' }}</p>
                            <p><strong>User ID:</strong> {{ $purchase->user_id ?? 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $purchase->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Updated At:</strong> {{ $purchase->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Requisition Title:</strong> {{ $purchase->requisition_title ?? 'N/A' }}</p>
                            <p><strong>Unit ID:</strong> {{ $purchase->unit_id ?? 'N/A' }}</p>
                            <p><strong>Company ID:</strong> {{ $purchase->company_id ?? 'N/A' }}</p>
                            <p><strong>Department ID:</strong> {{ $purchase->department_id ?? 'N/A' }}</p>
                            <p><strong>Status:</strong>
                                @if($purchase->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @if($purchase->remarks)
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Remarks:</strong></p>
                            <p>{{ $purchase->remarks }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection