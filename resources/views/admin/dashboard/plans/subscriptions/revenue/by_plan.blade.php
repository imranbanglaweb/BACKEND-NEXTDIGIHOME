@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body bg-white">
<div class="container-fluid">
<br>

<h4 class="fw-bold mb-3">Revenue by Plan</h4>

<div class="row mb-3">
<div class="col-md-4">
<div class="card shadow-sm">
<div class="card-body text-center">
<h6>Total Revenue</h6>
<h3 class="fw-bold text-success">{{ number_format($totalRevenue,2) }}</h3>
</div>
</div>
</div>
</div>

<div class="card shadow-sm border-0">
<div class="card-body">

<table class="table table-hover align-middle">
<thead class="table-light">
<tr>
    <th>Plan</th>
    <th>Total Revenue</th>
</tr>
</thead>
<tbody>
@foreach($revenue as $row)
<tr>
    <td>{{ $row->plan->name }}</td>
    <td class="fw-bold">{{ number_format($row->total,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

</div>
</div>
</div>
</section>
@endsection
