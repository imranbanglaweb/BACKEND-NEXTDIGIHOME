@extends('admin.dashboard.master')

@section('main_content')
<style>
    .page-title {
        font-size: 16px;
        font-weight: 700;
    }

    .card {
        border-radius: 10px !important;
        padding: 5px;
    }

    .card-header {
        font-size: 16px;
        padding: 15px 20px;
        border-radius: 10px 10px 0 0 !important;
    }

    .card-body {
        font-size: 14px;
        padding: 25px !important;
    }

    .info-label {
        font-weight: 400;
        color: #555;
        font-size: 14px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #222;
    }

    .table th {
        font-size: 15px !important;
        padding: 10px !important;
    }

    .table td {
        font-size: 14px !important;
        padding: 10px !important;
        vertical-align: middle;
    }

    .badge {
        font-size: 14px !important;
        padding: 8px 12px !important;
    }
</style>
<section class="content-body" style="background-color:#fff; padding: 20px;">

    <div class="container">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary">
                <i class="fa fa-eye me-2"></i> Requisition Details
            </h3>
            <a href="{{ route('maintenance.index') }}" class="btn btn-primary btn-lg pull-right">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
<hr>
<br>
        <!-- BASIC INFO CARD -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Requisition Summary</strong>
            </div>

            <div class="card-body row">

                <div class="col-md-6 mb-3">
                    <strong>Requisition No:</strong><br>
                    {{ $data->requisition_no }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Date:</strong><br>
                    {{ $data->maintenance_date }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Type:</strong><br>
                    {{ $data->requisition_type }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Priority:</strong><br>
                    <span class="badge 
                    @if($data->priority=='High') bg-danger
                    @elseif($data->priority=='Medium') bg-warning
                    @elseif($data->priority=='Low') bg-success
                    @else bg-secondary @endif">
                    {{ $data->priority }}</span>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Status:</strong><br>
                    @php
                        $color = $data->status == 'Approved' ? 'success' :
                                 ($data->status == 'Rejected' ? 'danger' : 'warning');
                    @endphp
                    <span class="badge bg-{{ $color }}">{{ $data->status }}</span>
                </div>

            </div>
        </div>

        <!-- VEHICLE & EMPLOYEE -->
        <div class="row">

            <!-- Vehcile Details -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <strong>Vehicle Information</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Vehicle No:</strong> {{ $data->vehicle->vehicle_number ?? 'N/A' }}</p>
                        <p><strong>Vehicle Name:</strong> {{ $data->vehicle->vehicle_name ?? 'N/A' }}</p>
                        <p><strong>Type:</strong> {{ $data->vehicle->vehicleType->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Employee Details -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <strong>Employee Information</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $data->employee->name ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $data->employee->phone ?? 'N/A' }}</p>
                        <p><strong>Department:</strong> {{ $data->employee->department->department_name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- SERVICE DETAILS -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning text-dark">
                <strong>Service Information</strong>
            </div>

            <div class="card-body">

                <p><strong>Service Title:</strong> {{ $data->service_title }}</p>

                <p><strong>Charge Bear By:</strong> {{ $data->charge_bear_by }}</p>

                <p><strong>Service Charge:</strong> 
                    <span class="fw-bold">${{ number_format($data->charge_amount, 2) }}</span>
                </p>

                <p><strong>Remarks:</strong><br>
                    {{ $data->remarks ?? 'N/A' }}
                </p>

            </div>
        </div>

        <!-- ITEM LIST -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <strong>Parts / Items Used</strong>
            </div>

            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Category</th>
                            <th>Item</th>
                            <th width="90">Qty</th>
                            <th width="120">Unit Price</th>
                            <th width="120">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data->items as $item)
                        <tr>
                            <td>{{ $item->category->category_name ?? 'N/A' }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end fw-bold">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

        <!-- TOTAL COST SUMMARY -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">

                <div class="row text-end">

                    <div class="col-md-12">
                        <h5><strong>Parts Cost:</strong>
                            ${{ number_format($data->total_parts_cost, 2) }}
                        </h5>

                        <h5><strong>Service Charge:</strong>
                            ${{ number_format($data->charge_amount, 2) }}
                        </h5>

                        <hr>

                        <h3 class="fw-bold text-primary">
                            Grand Total: ${{ number_format($data->total_cost, 2) }}
                        </h3>
                    </div>

                </div>

            </div>
        </div>

    </div>

</section>

@endsection
