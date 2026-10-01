@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body bg-white">
<div class="container-fluid">
<br>

<h4 class="fw-bold mb-3">Expiring Subscriptions</h4>

<div class="card shadow-sm border-0">
<div class="card-body">

<table class="table table-hover align-middle">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Company</th>
    <th>Plan</th>
    <th>Ends At</th>
    <th>Days Left</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@forelse($subscriptions as $sub)
@php
$days = now()->diffInDays($sub->ends_at,false);
@endphp
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $sub->company->name }}</td>
    <td>{{ $sub->plan->name }}</td>
    <td>{{ $sub->ends_at->format('d M Y') }}</td>
    <td>
        <span class="badge {{ $days <= 3 ? 'bg-danger' : 'bg-warning' }}">
            {{ $days }} Days
        </span>
    </td>
    <td>
        <a href="{{ route('admin.subscriptions.notify',$sub->id) }}"
           class="btn btn-sm btn-primary">Notify</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted py-4">No expiring subscriptions</td>
</tr>
@endforelse
</tbody>
</table>

</div>
</div>
</div>
</section>
@endsection
