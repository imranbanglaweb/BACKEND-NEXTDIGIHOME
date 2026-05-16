@extends('admin.dashboard.master')

@section('title', 'Create Hero Slider')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Hero Slider</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.hero-sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="subtitle">Subtitle</label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="cta_text">CTA Text</label>
                            <input type="text" class="form-control" id="cta_text" name="cta_text">
                        </div>
                        <div class="form-group">
                            <label for="cta_link">CTA Link</label>
                            <input type="text" class="form-control" id="cta_link" name="cta_link">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="background_color">Background Color</label>
                            <input type="color" class="form-control" id="background_color" name="background_color" value="#0f0f12">
                        </div>
                        <div class="form-group">
                            <label for="text_color">Text Color</label>
                            <input type="color" class="form-control" id="text_color" name="text_color" value="#fafafa">
                        </div>
                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                        </div>
                        <div class="form-group">
                            <label for="is_active">Active</label>
                            <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Hero Slider</button>
                        <a href="{{ route('admin.hero-sliders.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection