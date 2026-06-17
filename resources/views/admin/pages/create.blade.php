@extends('admin.dashboard.master')

@section('title', 'Create Page Content')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page premium-form">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1"><i class="fas fa-file-alt me-3"></i>Create Page Content</h2>
                        <p class="text-white-50 mb-0">Add a content section for a frontend page.</p>
                    </div>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to Pages
                    </a>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.pages.form', ['pageContent' => null, 'submitLabel' => 'Create Page Content'])
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
