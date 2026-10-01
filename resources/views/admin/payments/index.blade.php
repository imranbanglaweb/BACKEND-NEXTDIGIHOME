@extends('admin.dashboard.master')

@section('title', 'Payments')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payments</h3>
                    <div class="card-tools">
                        <a href="{{ route('payments.pending') }}" class="btn btn-warning">Pending Payments</a>
                        <a href="{{ route('payments.paid') }}" class="btn btn-success">Paid Payments</a>
                    </div>
                </div>
                <div class="card-body">
                    <p>Payment management dashboard. Use the buttons above to view pending or paid payments.</p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending Payments</span>
                                    <span class="info-box-number">{{ \App\Models\Payment::where('status', 'pending')->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Paid Payments</span>
                                    <span class="info-box-number">{{ \App\Models\Payment::where('status', 'paid')->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection