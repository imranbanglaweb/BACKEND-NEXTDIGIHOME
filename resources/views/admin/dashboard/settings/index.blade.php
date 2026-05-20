@extends('admin.dashboard.master')

@section('main_content')

<style>
    .settings-container {
        background: #ffffff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .settings-title {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
    }

    .tab-btn {
        padding: 10px 25px;
        border-radius: 30px;
        font-weight: 600;
        transition: 0.3s;
        border: 2px solid transparent;
        background: #f1f5f9;
        color: #64748b;
    }

    .tab-btn.active {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        border-color: transparent;
    }

    .tab-btn:hover:not(.active) {
        background: #e2e8f0;
        color: #1e293b;
    }

    .settings-card {
        background: #f8fafc;
        padding: 25px;
        border-radius: 16px;
        transition: 0.3s;
        border: 1px solid #e2e8f0;
    }

    .settings-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #334155;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .btn-primary.saved {
        padding: 12px 35px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 16px;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary.saved:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }

    /* Premium Toast Notifications */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .premium-toast {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 20px;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        min-width: 350px;
        max-width: 450px;
        animation: slideInRight 0.4s ease-out;
        border-left: 4px solid;
        overflow: hidden;
    }

    .premium-toast.success {
        border-left-color: #10b981;
    }

    .premium-toast.error {
        border-left-color: #ef4444;
    }

    .premium-toast.warning {
        border-left-color: #f59e0b;
    }

    .premium-toast.info {
        border-left-color: #3b82f6;
    }

    .toast-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .premium-toast.success .toast-icon {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
        color: #10b981;
    }

    .premium-toast.error .toast-icon {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
        color: #ef4444;
    }

    .premium-toast.warning .toast-icon {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
        color: #f59e0b;
    }

    .premium-toast.info .toast-icon {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
        color: #3b82f6;
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 700;
        font-size: 15px;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .toast-message {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
    }

    .toast-close {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: #94a3b8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .toast-close:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 0 0 12px 12px;
        overflow: hidden;
    }

    .toast-progress-bar {
        height: 100%;
        border-radius: 0 0 0 12px;
        transition: width 0.1s linear;
    }

    .premium-toast.success .toast-progress-bar {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .premium-toast.error .toast-progress-bar {
        background: linear-gradient(90deg, #ef4444, #f87171);
    }

    .premium-toast.warning .toast-progress-bar {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    .premium-toast.info .toast-progress-bar {
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }

    .premium-toast.hiding {
        animation: slideOutRight 0.3s ease-out forwards;
    }

    /* Custom SweetAlert2 Premium Theme */
    .swal2-popup.swal2-toast {
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .swal2-icon.swal2-success {
        border-color: #10b981;
        color: #10b981;
    }

    .swal2-icon.swal2-success::before {
        background: #10b981;
    }

    .swal2-icon.swal2-success::after {
        background: #10b981;
    }

    .swal2-icon.swal2-error {
        border-color: #ef4444;
        color: #ef4444;
    }

    .swal2-icon.swal2-warning {
        border-color: #f59e0b;
        color: #f59e0b;
    }

    .swal2-icon.swal2-info {
        border-color: #3b82f6;
        color: #3b82f6;
    }
</style>

{{-- Toast Container --}}
<div class="toast-container" id="toastContainer"></div>

<section role="main" class="content-body">
    <div class="settings-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="settings-title">
                ⚙️ {{ trans(ensure_menu_translation('website_settings')) }}
                
            </h2>
            <a class="btn btn-outline-primary" href="{{ route('home') }}">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>

         {{-- TAB BUTTONS --}}
        <div class="mb-4">
            <button class="btn btn-light tab-btn admin_menu active" data-target=".admin_settings">
                <i class="fa fa-user"></i>  Admin Settings
            </button>
            <button class="btn btn-light tab-btn favicon_menu" data-target=".favicon_settings">
                <i class="fa fa-icons"></i> Favicon Settings
            </button>
            @auth
            @if(auth()->user()->hasPermissionTo('settings-language'))
            <button class="btn btn-light tab-btn language_menu" data-target=".language_settings">
                <i class="fa fa-language me-1"></i> Language Settings
            </button>
            @endif
            @if(auth()->user()->hasPermissionTo('email-setting'))
            <button class="btn btn-light tab-btn email_menu" data-target=".email_settings">
                <i class="fa fa-envelope me-1"></i> Email Settings
            </button>
            @endif
            @endauth
        </div>

        <hr>

        {{-- FORM --}}
        {!! Form::open(['method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'upload-image-form']) !!}

        <div class="row">

            {{-- ADMIN SETTINGS CARD --}}
            <div class="col-md-12 admin_settings settings-card">

                <div class="form-group mb-3">
                    <label>Admin Title:</label>
                    {!! Form::text('admin_title', $settings->admin_title ?? null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group mb-3">
                    <label>Admin Description:</label>
                    {!! Form::text('admin_description', $settings->admin_description ?? null, ['class'=>'form-control']) !!}
                </div>

                 <label>Admin Logo:</label>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <input type="file" name="admin_logo">
                    @if(!empty($settings->admin_logo))
                        <img src="{{ asset('public/admin_resource/assets/images/'.$settings->admin_logo) }}" width="80">
                    @endif
                </div>

            </div>

            {{-- FAVICON SETTINGS CARD --}}
            <div class="col-md-12 favicon_settings settings-card" style="display: none;">

                <h4 class="mb-4"><i class="fa fa-icons text-primary me-2"></i>Favicon Settings</h4>
                <p class="text-muted mb-4">Manage the favicon that appears in the browser tab.</p>

                <div class="row">
                    <div class="col-md-12">
                        <label>Favicon</label>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <input type="file" name="favicon" accept="image/png,image/x-icon,image/vnd.microsoft.icon">
                            @if(!empty($settings->favicon))
                                <img src="{{ asset('public/admin_resource/assets/images/'.$settings->favicon) }}" width="40" style="padding:5px;background:#f0f0f0;border-radius:4px;">
                            @else
                                <img src="{{ asset('favicon.ico') }}" width="40" style="padding:5px;background:#f0f0f0;border-radius:4px;">
                            @endif
                        </div>
                        <small class="text-muted">Recommended size: 32x32px or 16x16px. Formats: PNG, ICO</small>
                    </div>
                </div>

            </div>

            {{-- LANGUAGE SETTINGS CARD --}}
            <div class="col-md-12 language_settings settings-card" style="display: none;">

                <h4 class="mb-4"><i class="fa fa-language text-primary me-2"></i>Language Management</h4>

                {{-- Default Language --}}
                <div class="form-group mb-4">
                    <label>Default Language:</label>
                    <select name="default_language" class="form-control">
                        @foreach($languages as $lang)
                            <option value="{{ $lang->code }}"
                                    {{ ($settings->default_language ?? 'en') == $lang->code ? 'selected' : '' }}>
                                {{ $lang->native_name }} ({{ strtoupper($lang->code) }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">This will be the fallback language for untranslated content</small>
                </div>

                {{-- Available Languages --}}
                <div class="form-group mb-4">
                    <label>Available Languages:</label>
                    <div class="border rounded p-3 bg-light">
                        @php
                            $availableLanguages = json_decode($settings->available_languages ?? '["en"]', true);
                        @endphp
                        @foreach($languages as $lang)
                            <div class="form-check d-inline-block me-4 mb-2">
                                <input class="form-check-input" type="checkbox"
                                       name="available_languages[]" value="{{ $lang->code }}"
                                       id="lang_{{ $lang->code }}"
                                       {{ in_array($lang->code, $availableLanguages) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lang_{{ $lang->code }}">
                                    <span class="fi fi-{{ $lang->flag_icon ?? 'us' }} me-1"></span>
                                    {{ $lang->native_name }} ({{ strtoupper($lang->code) }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Select which languages users can choose from</small>
                </div>

                {{-- Auto Translation --}}
                <div class="form-group mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="auto_translate" value="1" id="auto_translate"
                               {{ ($settings->auto_translate ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="auto_translate">
                            <strong>Enable Auto Translation</strong>
                        </label>
                    </div>
                    <small class="text-muted">Automatically translate new content using Google Translate API</small>
                </div>

                {{-- Language Cache --}}
                <div class="form-group mb-4">
                    <label>Translation Cache Duration (hours):</label>
                    {!! Form::number('cache_duration', $settings->cache_duration ?? 24, [
                        'class'=>'form-control',
                        'min'=>'1',
                        'max'=>'168',
                        'placeholder'=>'24'
                    ]) !!}
                    <small class="text-muted">How long to cache translations (1-168 hours)</small>
                </div>

                {{-- Quick Actions --}}
                <div class="border-top pt-3">
                    <h5 class="mb-3">Quick Actions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="clearTranslationCache()">
                            <i class="fa fa-trash me-1"></i>Clear Translation Cache
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="syncLanguages()">
                            <i class="fa fa-sync me-1"></i>Sync Languages
                        </button>
                        <a href="{{ route('admin.translations') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                            <i class="fa fa-list me-1"></i>Manage Translations
                        </a>
                    </div>
                </div>

            </div>

            {{-- EMAIL SETTINGS CARD --}}
            <div class="col-md-12 email_settings settings-card" style="display: none;">

                <h4 class="mb-4"><i class="fa fa-envelope text-primary me-2"></i>Email Configuration</h4>

                <div class="alert alert-info mb-4" style="border-radius: 10px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%); border: 1px solid rgba(59, 130, 246, 0.2);">
                    <i class="fa fa-info-circle me-2"></i>
                    Configure your SMTP settings here. These settings will override the .env mail configuration.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Mail Mailer:</label>
                            <select name="mail_mailer" class="form-control">
                                <option value="smtp" {{ ($settings->mail_mailer ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="sendmail" {{ ($settings->mail_mailer ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                <option value="log" {{ ($settings->mail_mailer ?? '') == 'log' ? 'selected' : '' }}>Log (for testing)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Mail Host:</label>
                            {!! Form::text('mail_host', $settings->mail_host ?? 'smtp.gmail.com', ['class'=>'form-control', 'placeholder'=>'smtp.gmail.com']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Mail Port:</label>
                            {!! Form::number('mail_port', $settings->mail_port ?? 587, ['class'=>'form-control', 'placeholder'=>'587']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Mail Encryption:</label>
                            <select name="mail_encryption" class="form-control">
                                <option value="tls" {{ ($settings->mail_encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ ($settings->mail_encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="" {{ ($settings->mail_encryption ?? '') == '' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Mail Username:</label>
                            {!! Form::text('mail_username', $settings->mail_username ?? '', ['class'=>'form-control', 'placeholder'=>'your-email@gmail.com']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Mail Password:</label>
                            <div class="input-group">
                                <input type="text" name="mail_password" class="form-control" placeholder="App Password" id="mail_password" value="{{ $settings->mail_password ?? '' }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('mail_password', 'mail_password_toggle')">
                                    <i class="fa fa-eye" id="mail_password_toggle"></i>
                                </button>
                            </div>
                            <small class="text-muted">For Gmail, use an App Password, not your login password</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>From Address:</label>
                            {!! Form::email('mail_from_address', $settings->mail_from_address ?? '', ['class'=>'form-control', 'placeholder'=>'noreply@example.com']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>From Name:</label>
                            {!! Form::text('mail_from_name', $settings->mail_from_name ?? '', ['class'=>'form-control', 'placeholder'=>'Your Application Name']) !!}
                        </div>
                    </div>
                </div>

                <div class="border-top pt-3">
                    <h5 class="mb-3">Quick Actions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearMailConfigCache()">
                            <i class="fa fa-trash me-1"></i>Clear Config Cache
                        </button>
                    </div>
                </div>

            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary saved">Save Changes</button>
            </div>

        </div>

        {!! Form::close() !!}

    </div>
</section>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Toggle Password Visibility Function
    function togglePassword(inputId, toggleIconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(toggleIconId);
        // alert(passwordInput);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
    
    // Premium Toast Notification Function
    function showPremiumToast(type, title, message, duration = 5000) {
        const container = document.getElementById('toastContainer');
        
        const icons = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-times-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            info: '<i class="fas fa-info-circle"></i>'
        };

        const toastId = 'toast_' + Date.now();
        
        const toastHTML = `
            <div class="premium-toast ${type}" id="${toastId}">
                <div class="toast-icon">${icons[type]}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="dismissToast('${toastId}')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="toast-progress">
                    <div class="toast-progress-bar" style="width: 100%;"></div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', toastHTML);
        
        const toast = document.getElementById(toastId);
        const progressBar = toast.querySelector('.toast-progress-bar');
        
        // Animate progress bar
        setTimeout(() => {
            progressBar.style.transition = `width ${duration}ms linear`;
            progressBar.style.width = '0%';
        }, 100);
        
        // Auto dismiss
        const dismissTimer = setTimeout(() => {
            dismissToast(toastId);
        }, duration);
        
        // Store timer on element for manual dismiss
        toast.dataset.timerId = dismissTimer;
    }

    function dismissToast(toastId) {
        const toast = document.getElementById(toastId);
        if (!toast) return;
        
        // Clear the timer
        clearTimeout(toast.dataset.timerId);
        
        // Add hiding class for animation
        toast.classList.add('hiding');
        
        // Remove after animation
        setTimeout(() => {
            toast.remove();
        }, 300);
    }

    $(document).ready(function() {
        // Initialize: Hide all cards
        $('.settings-card').hide();

        // Restore active tab from localStorage or default to Admin Settings
        let activeTab = localStorage.getItem('active_settings_tab') || '.admin_settings';
        if ($(activeTab).length === 0) activeTab = '.admin_settings'; // Fallback

        $(activeTab).show();
        $('.tab-btn').removeClass('active');
        $('.tab-btn[data-target="' + activeTab + '"]').addClass('active');

        // Generic Tab Switching Logic
        $(".tab-btn").click(function(e) {
            e.preventDefault();
            $(".tab-btn").removeClass("active");
            $(this).addClass("active");
            var target = $(this).data('target');
            $(".settings-card").hide();
            $(target).fadeIn(300);
            localStorage.setItem('active_settings_tab', target);
        });
    });

    // AJAX SAVE
    $('#upload-image-form').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let btn = $('.saved');
        let originalText = btn.html();

        $.ajax({
            type:'POST',
            url:"{{ route('settings.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            },

            success: (response) => {
                // Show premium toast notification
                showPremiumToast(
                    'success',
                    '<i class="fas fa-check-circle me-2"></i>Settings Updated',
                    'Your changes have been saved successfully.',
                    5000
                );
                
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },

            error: function(err){
                console.log(err);
                showPremiumToast(
                    'error',
                    '<i class="fas fa-times-circle me-2"></i>Error',
                    'Failed to save settings. Please try again.',
                    5000
                );
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Language Management Functions
    function clearTranslationCache() {
        Swal.fire({
            title: '<span style="font-size: 20px;"><i class="fas fa-trash-alt me-2" style="color: #f59e0b;"></i>Clear Translation Cache?</span>',
            html: '<span style="color: #64748b; font-size: 14px;">This will clear all cached translations and may temporarily slow down the site.</span>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-check me-1"></i> Yes, Clear Cache',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
            reverseButtons: true,
            backdrop: 'rgba(0, 0, 0, 0.5)',
            customClass: {
                popup: 'swal2-premium-popup',
                confirmButton: 'swal2-premium-confirm'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.language.clear-cache") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showPremiumToast(
                            'success',
                            '<i class="fas fa-check-circle me-2"></i>Cache Cleared',
                            'Translation cache has been cleared successfully.',
                            5000
                        );
                    },
                    error: function() {
                        showPremiumToast(
                            'error',
                            '<i class="fas fa-times-circle me-2"></i>Error',
                            'Failed to clear translation cache.',
                            5000
                        );
                    }
                });
            }
        });
    }

    function clearMailConfigCache() {
        Swal.fire({
            title: '<span style="font-size: 20px;"><i class="fas fa-envelope me-2" style="color: #f59e0b;"></i>Clear Mail Config Cache?</span>',
            html: '<span style="color: #64748b; font-size: 14px;">This will clear the cached mail configuration.</span>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-check me-1"></i> Yes, Clear Cache',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
            reverseButtons: true,
            backdrop: 'rgba(0, 0, 0, 0.5)'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.mail.clear-cache") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showPremiumToast(
                            'success',
                            '<i class="fas fa-check-circle me-2"></i>Cache Cleared',
                            'Mail configuration cache has been cleared.',
                            5000
                        );
                    },
                    error: function() {
                        showPremiumToast(
                            'error',
                            '<i class="fas fa-times-circle me-2"></i>Error',
                            'Failed to clear cache.',
                            5000
                        );
                    }
                });
            }
        });
    }

    function syncLanguages() {
        Swal.fire({
            title: '<span style="font-size: 20px;"><i class="fas fa-sync-alt me-2" style="color: #3b82f6;"></i>Sync Languages?</span>',
            html: '<span style="color: #64748b; font-size: 14px;">This will synchronize language settings with the database.</span>',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-sync me-1"></i> Sync Now',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
            reverseButtons: true,
            backdrop: 'rgba(0, 0, 0, 0.5)'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.language.sync") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showPremiumToast(
                            'success',
                            '<i class="fas fa-check-circle me-2"></i>Languages Synced',
                            'Language settings have been synchronized successfully.',
                            5000
                        );
                    },
                    error: function() {
                        showPremiumToast(
                            'error',
                            '<i class="fas fa-times-circle me-2"></i>Error',
                            'Failed to sync languages.',
                            5000
                        );
                    }
                });
            }
        });
    }
</script>

@endsection
