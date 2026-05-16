@extends('admin.dashboard.master')

@section('main_content')

<section class="content-body" style="background-color: #fff;">
<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary"><i class="fa fa-edit me-2"></i> Edit Menu</h2>
    <a class="btn btn-dark pull-right" href="{{ route('menus.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>
<hr>
<br>
<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">
        {!! Form::model($menu_edit, ['method' => 'PATCH','route' => ['menus.update', $menu_edit->id], 'id'=>'menuForm']) !!}
        <div class="row g-4">

            <div class="col-md-6">
                <label class="fw-bold">Menu Name <span class="text-danger">*</span></label>
                {!! Form::text('menu_name', null, ['class'=>'form-control form-control-lg rounded-3','id'=>'menu_name','placeholder'=>'Enter menu name']) !!}
                <span class="text-danger small error-text menu_name_error"></span>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Menu URL / Slug</label>
                {!! Form::text('menu_url', null, ['class'=>'form-control form-control-lg rounded-3','id'=>'menu_url','placeholder'=>'Auto-generated from name']) !!}
                <span class="text-danger small error-text menu_url_error"></span>
            </div>

            <div class="col-md-12">
                <label class="fw-bold">Menu Parent</label>
                <select class="form-select form-select-lg rounded-3 select2" name="menu_parent">
                    <option value="0">No Parent</option>
                    @foreach($menus as $menu)
                    <option value="{{$menu->id}}" {{ $menu_edit->menu_parent == $menu->id ? 'selected' : '' }}>{{$menu->menu_name}}</option>
                    @endforeach
                </select>
                <span class="text-danger small error-text menu_parent_error"></span>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Permission</label>
                <select class="form-select form-select-lg select2" name="menu_permission">
                    <option value="0">Select Permission</option>
                    @foreach($permission_lists as $list)
                    <option value="{{$list->name}}" {{ $menu_edit->menu_permission == $list->name ? 'selected' : '' }}>{{$list->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger small error-text menu_permission_error"></span>
            </div>

            <div class="col-md-6 d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mt-1" href="{{ route('admin.permissions.create')}}">
                    <i class="fa fa-plus"></i> Add Permission
                </a>
            </div>

            <div class="col-md-12">
                <label class="fw-bold">Menu Type</label><br>
                <label class="me-3"><input class="menu_location_backend" type="checkbox" name="menu_type" value="backend" {{ $menu_edit->menu_type == 'backend' ? 'checked' : '' }}><strong class="ms-1">Backend</strong></label>
                <label><input class="menu_location" type="checkbox" name="menu_type" value="frontend" {{ $menu_edit->menu_type == 'frontend' ? 'checked' : '' }}><strong class="ms-1">Frontend</strong></label>
                <br><span class="text-danger small error-text menu_type_error"></span>
            </div>

            <div class="col-md-12 menu_location_div" style="{{ $menu_edit->menu_type == 'frontend' ? '' : 'display:none;' }}">
                <label class="fw-bold">Menu Location</label>
                <select class="form-select form-select-lg rounded-3" name="menu_location">
                    <option value="Header" {{ $menu_edit->menu_location == 'Header' ? 'selected' : '' }}>Header</option>
                    <option value="Footer" {{ $menu_edit->menu_location == 'Footer' ? 'selected' : '' }}>Footer</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Menu Icon</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i id="iconPreview" class="{{ $menu_edit->menu_icon }}"></i></span>
                    <input type="text" name="menu_icon" class="form-control form-control-lg" placeholder="Type or pick icon" id="iconInput" value="{{ $menu_edit->menu_icon }}">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#iconModal"><i class="fa fa-icons"></i> Pick</button>
                </div>
                <span class="text-danger small error-text menu_icon_error"></span>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Menu Highlight Color</label>
                <input type="color" name="menu_color" class="form-control form-control-lg rounded-3" value="{{ $menu_edit->menu_color ?? '#0d6efd' }}">
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Status</label>
                <select name="status" class="form-select form-select-lg rounded-3">
                    <option value="1" {{ $menu_edit->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $menu_edit->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm" id="submitBtn">
                <i class="fa fa-save me-2"></i> Update Menu
            </button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<!-- ICON MODAL -->
<div class="modal" id="iconModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select FontAwesome Icon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="iconSearch" class="form-control mb-3" placeholder="Search icons...">
        <div class="row g-2" id="iconList"></div>
      </div>
    </div>
  </div>
</div>

</div>

<!-- CSS/JS -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function(){

    // Select2 initialization
    // $('.select2').select2({ placeholder:'Select an option', allowClear:true });

    // Menu type toggle
    $(".menu_location").click(function(){ 
        if($(this).is(':checked')){
            $(".menu_location_div").slideDown(300); 
            $('.menu_location_backend').prop('checked', false); 
        } else {
            $(".menu_location_div").slideUp(300);
        }
    });
    $(".menu_location_backend").click(function(){ 
        if($(this).is(':checked')){
            $(".menu_location_div").slideUp(300); 
            $('.menu_location').prop('checked', false); 
        }
    });

    // Auto-generate slug
    $('#menu_name').on('keyup', function(){ 
        $('#menu_url').val($(this).val().toLowerCase().trim().replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'')); 
    });

    // FontAwesome icons array
    const faIcons = [
        'fa-solid fa-house','fa-solid fa-user','fa-solid fa-cog','fa-solid fa-chart-line','fa-solid fa-envelope',
        'fa-solid fa-bell','fa-solid fa-book','fa-solid fa-camera','fa-solid fa-heart','fa-solid fa-star',
        'fa-solid fa-trash','fa-solid fa-edit','fa-solid fa-search','fa-solid fa-lock','fa-solid fa-globe',
        'fa-solid fa-file','fa-solid fa-folder','fa-solid fa-tag','fa-solid fa-cart-shopping','fa-solid fa-comments',
        'fa-solid fa-paper-plane','fa-solid fa-calendar','fa-solid fa-play','fa-solid fa-pause','fa-solid fa-stop',
        'fa-solid fa-upload','fa-solid fa-download','fa-solid fa-magnifying-glass','fa-solid fa-microphone',
        'fa-solid fa-shield','fa-solid fa-phone','fa-solid fa-map','fa-solid fa-location-dot','fa-solid fa-clock',
        'fa-solid fa-rss','fa-solid fa-link','fa-solid fa-lock-open','fa-solid fa-key','fa-solid fa-gift',
        'fa-solid fa-list', 'fa-solid fa-th', 'fa-solid fa-table', 'fa-solid fa-check', 'fa-solid fa-times'
    ];

    function renderIcons(filter=''){
        $('#iconList').html('');
        let filtered = faIcons.filter(i => i.includes(filter));
        if(filtered.length === 0){
            $('#iconList').html('<div class="col-12 text-center text-muted py-3">No icons found.</div>');
        } else {
            filtered.forEach(icon => {
                $('#iconList').append(`
                    <div class="col-3 col-md-2 text-center">
                        <div class="p-3 bg-light rounded-3 iconPicker h-100 d-flex flex-column align-items-center justify-content-center" style="cursor:pointer; transition: all 0.2s;" data-icon-class="${icon}">
                            <i class="${icon} fs-3 mb-2 text-secondary"></i>
                            <div class="small text-truncate w-100 text-muted" style="font-size: 10px;">${icon.replace('fa-solid fa-', '')}</div>
                        </div>
                    </div>
                `);
            });
        }
    }

    // Bootstrap 5 modal API
    const iconModalEl = document.getElementById('iconModal');
    const iconModal = new bootstrap.Modal(iconModalEl, { backdrop: 'static', keyboard: false });

    // Render icons on modal show
    $('#iconModal').on('shown.bs.modal', function () {
        renderIcons();
        $('#iconSearch').val('').focus();
    });

    // Search icons
    $('#iconSearch').on('input', function(){
        renderIcons($(this).val().trim());
    });

    // Pick icon
    $(document).on('click','.iconPicker',function(){
        // Get the icon class from the data attribute
        let iconClass = $(this).data('icon-class');
        $('#iconInput').val(iconClass);
        $('#iconPreview').attr('class', iconClass + ' text-primary');
        iconModal.hide();
    });

    // Hover effect for icons
    $(document).on('mouseenter', '.iconPicker', function() {
        $(this).removeClass('bg-light').addClass('bg-white shadow-sm border');
        $(this).find('i').removeClass('text-secondary').addClass('text-primary');
    }).on('mouseleave', '.iconPicker', function() {
        $(this).removeClass('bg-white shadow-sm border').addClass('bg-light');
        $(this).find('i').removeClass('text-primary').addClass('text-secondary');
    });

    // Live preview typing
    $('#iconInput').on('input', function(){
        $('#iconPreview').attr('class', $(this).val().trim());
    });

    // AJAX Submit
    $('#menuForm').on('submit', function(e){
        e.preventDefault();
        
        // Reset errors
        $('.error-text').text('');
        $('input, select').removeClass('is-invalid');
        
        let btn = $('#submitBtn');
        let originalBtnText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin me-2"></i> Updating...').prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST', // Form::model uses POST with _method=PATCH
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function(data){
                if(data.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                }
            },
            error: function(response){
                btn.html(originalBtnText).prop('disabled', false);
                
                if(response.status === 422){
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, val){
                        $('span.'+key+'_error').text(val[0]);
                        $('[name="'+key+'"]').addClass('is-invalid');
                    });
                    // Scroll to top to see alert
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.responseJSON ? response.responseJSON.message : 'Something went wrong!',
                    });
                }
            }
        });
    });

});
</script>

@endsection