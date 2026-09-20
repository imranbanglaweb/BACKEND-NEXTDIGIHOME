@extends('admin.dashboard.master')

@section('main_content')

<section class="content-body" style="background-color: #fff;">
<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary"><i class="fa fa-eye me-2"></i> Menu Details: {{ $menu->menu_name }}</h2>
    <div>
        <a class="btn btn-warning me-2" href="{{ route('menus.edit', $menu->id) }}">
            <i class="fa fa-edit"></i> Edit
        </a>
        <a class="btn btn-dark" href="{{ route('menus.index') }}">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
</div>
<hr>
<br>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6 mb-3">
                <label class="text-muted small fw-bold">Menu Name</label>
                <div class="fs-5 fw-bold text-dark">{{ $menu->menu_name }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted small fw-bold">Menu Slug</label>
                <div><code>{{ $menu->menu_slug }}</code></div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted small fw-bold">Target Route / URL</label>
                <div><code>{{ $menu->menu_url ?: 'None (Dropdown parent)' }}</code></div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted small fw-bold">Icon</label>
                <div>
                    @if($menu->menu_icon)
                        <i class="fa {{ $menu->menu_icon }} fa-lg me-2 text-primary"></i> <code>{{ $menu->menu_icon }}</code>
                    @else
                        <span class="text-muted">No icon</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted small fw-bold">Parent Menu</label>
                <div>{{ $menu->parent ? $menu->parent->menu_name : 'Root Level (No Parent)' }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted small fw-bold">Required Permission</label>
                <div><span class="badge bg-secondary">{{ $menu->menu_permission ?: 'Public / Authenticated' }}</span></div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted small fw-bold">Sort Order</label>
                <div><strong>{{ $menu->menu_order }}</strong></div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted small fw-bold">Sub-menu Children Count</label>
                <div><span class="badge bg-info">{{ $menu->children ? $menu->children->count() : 0 }} Child Items</span></div>
            </div>
        </div>

        @if($menu->children && $menu->children->count() > 0)
        <hr class="my-4">
        <h5 class="fw-bold mb-3">Sub-menu Children</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>URL / Route</th>
                        <th>Icon</th>
                        <th>Order</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menu->children as $i => $child)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $child->menu_name }}</strong></td>
                        <td><code>{{ $child->menu_slug }}</code></td>
                        <td><code>{{ $child->menu_url }}</code></td>
                        <td><i class="fa {{ $child->menu_icon }} me-1"></i> {{ $child->menu_icon }}</td>
                        <td>{{ $child->menu_order }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

</div>
</section>

@endsection
