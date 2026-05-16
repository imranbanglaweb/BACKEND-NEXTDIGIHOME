@extends('admin.dashboard.master')
@section('title', 'View Document')

@section('main_content')
<section role="main" class="content-body">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">View Document Details</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Documents</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Document Information</h3>
                        <div class="card-tools">
                            <a href="{{ route('documents.index') }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-list"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Document ID</th>
                                        <td>{{ $document->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ $document->date->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Project Name</th>
                                        <td>{{ $document->project_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Land Name</th>
                                        <td>{{ $document->land_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Document Name</th>
                                        <td>{{ $document->document_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vault Number</th>
                                        <td>{{ $document->vault_number }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Document Taker</th>
                                        <td>{{ $document->document_taker }}</td>
                                    </tr>
                                    <tr>
                                        <th>Witness Name</th>
                                        <td>{{ $document->witness_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Proposed Return Date</th>
                                        <td>{{ $document->proposed_return_date->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge badge-{{ $document->status === 'withdrawn' ? 'warning' : 'success' }}">
                                                {{ ucfirst($document->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if($document->status === 'returned')
                                    <tr>
                                        <th>Actual Return Date</th>
                                        <td>{{ $document->actual_return_date->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Returner Name</th>
                                        <td>{{ $document->returner_name }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Withdrawal Reason</h3>
                                    </div>
                                    <div class="card-body">
                                        {{ $document->withdrawal_reason }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-primary">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('documents.index') }}" class="btn btn-danger">
                                <i class="fa fa-times"></i> Close
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
    }
    .badge {
        padding: 0.5em 0.75em;
    }
    .card-footer {
        background: none;
    }
    .btn-group {
        gap: 10px;
    }
</style>
@endpush
@endsection 