@extends('admin.dashboard.master')

@section('title', 'Purchases')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Purchases</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->id }}</td>
                                <td>{{ optional($purchase->product)->name ?? 'N/A' }}</td>
                                <td>{{ $purchase->user_id ?? 'N/A' }}</td>
                                <td>{{ $purchase->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.purchases.show', $purchase) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $purchases->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection