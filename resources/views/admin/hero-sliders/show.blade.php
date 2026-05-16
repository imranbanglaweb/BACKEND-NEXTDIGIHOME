@extends('admin.dashboard.master')

@section('title', 'View Hero Slider')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hero Slider Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.hero-sliders.edit', $heroSlider) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.hero-sliders.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Title</h5>
                            <p>{{ $heroSlider->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Subtitle</h5>
                            <p>{{ $heroSlider->subtitle ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>CTA Text</h5>
                            <p>{{ $heroSlider->cta_text ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>CTA Link</h5>
                            <p>{{ $heroSlider->cta_link ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Background Color</h5>
                            <p><span style="background-color: {{ $heroSlider->background_color }}; padding: 5px 10px; border-radius: 3px;">{{ $heroSlider->background_color }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Text Color</h5>
                            <p><span style="background-color: {{ $heroSlider->text_color }}; padding: 5px 10px; border-radius: 3px;">{{ $heroSlider->text_color }}</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Sort Order</h5>
                            <p>{{ $heroSlider->sort_order }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Status</h5>
                            <p>
                                @if($heroSlider->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5>Description</h5>
                            <p>{{ $heroSlider->description ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5>Image</h5>
                            @if($heroSlider->image)
                                @if(str_starts_with($heroSlider->image, 'http'))
                                    <img src="{{ $heroSlider->image }}" alt="{{ $heroSlider->title }}" class="img-fluid" style="max-width: 300px;">
                                @else
                                    <img src="{{ asset($heroSlider->image) }}" alt="{{ $heroSlider->title }}" class="img-fluid" style="max-width: 300px;">
                                @endif
                            @else
                                <p>No image</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection