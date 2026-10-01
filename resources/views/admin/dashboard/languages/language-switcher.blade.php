@php
    use App\Models\Language;
    use Illuminate\Support\Facades\Cache;

    $currentLocale = app()->getLocale();

    // Get all active languages from database (not limited by settings)
    // This ensures all active languages are displayed in the switcher
    $languages = Cache::remember('available_languages', 3600, function () {
        return Language::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();
    });

    // Find current language or default or first available
    $currentLanguage = $languages->where('code', $currentLocale)->first()
        ?? $languages->where('is_default', 1)->first()
        ?? $languages->first();
@endphp

<style>
/* Premium Modal Styles for SweetAlert */
.premium-modal {
    border-radius: 20px !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    border: none !important;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%) !important;
}

.premium-modal .swal2-title {
    color: #2c3e50 !important;
    font-weight: 700 !important;
    font-size: 1.8rem !important;
    margin-bottom: 1rem !important;
}

.premium-modal .swal2-html-container {
    color: #495057 !important;
    font-size: 1rem !important;
    font-weight: 500 !important;
}

.premium-modal .swal2-input {
    border: 2px solid #e9ecef !important;
    border-radius: 10px !important;
    padding: 12px 16px !important;
    font-size: 1rem !important;
    transition: all 0.3s ease !important;
    background: #f8f9fa !important;
}

.premium-modal .swal2-input:focus {
    border-color: #667eea !important;
    background: white !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
    outline: none !important;
}

.btn-secondary-premium {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
    color: white !important;
    border: none !important;
    padding: 12px 24px !important;
    border-radius: 25px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    transition: all 0.3s ease !important;
}

.btn-secondary-premium:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 18px rgba(108, 117, 125, 0.4) !important;
}
</style>

@if($languages->count() > 1)
<div class="dropdown language-dropdown" style="margin-right: 10px;">
    <a href="#" 
       class="header-icon-btn language-toggle"
       role="button"
       aria-haspopup="true"
       aria-expanded="false"
       title="Language">
        <i class="fa fa-globe"></i>
        <span class="fi fi-{{ $currentLanguage->flag_icon ?? 'us' }}" style="margin-left: 5px;"></span>
    </a>

    <ul class="dropdown-menu pull-right language-menu">

        <li class="dropdown-header">
            <i class="fa fa-language"></i> Select Language
        </li>

        @foreach($languages as $language)
            @if($language->code !== $currentLocale)
                <li>
                    <a href="javascript:void(0)"
                       class="language-switch"
                       data-lang="{{ $language->code }}">

                        <span class="fi fi-{{ $language->flag_icon }}"></span>
                        {{ $language->native_name }}
                        <small class="text-muted">
                            ({{ strtoupper($language->code) }})
                        </small>

                        @if($language->direction === 'rtl')
                            <span class="label label-info pull-right">RTL</span>
                        @endif
                    </a>
                </li>
            @else
                <li class="active">
                    <a href="#">
                        <span class="fi fi-{{ $language->flag_icon }}"></span>
                        <strong>{{ $language->native_name }}</strong>
                        <i class="fa fa-check text-success pull-right"></i>
                    </a>
                </li>
            @endif
        @endforeach

        <li class="divider"></li>

        <li>
            <a href="{{ route('admin.translations') }}">
                <i class="fa fa-cog"></i> Manage Translations
            </a>
        </li>
    </ul>
</div>
@endif
<!-- jQuery is already loaded in the master layout -->
<script>
$(document).ready(function () {

    // Manual dropdown toggle since Bootstrap might not be initializing properly
    $(document).on('click', '.language-toggle', function(e) {
        e.preventDefault();
        $(this).parent('.dropdown').toggleClass('open');
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.language-dropdown').length) {
            $('.language-dropdown').removeClass('open');
        }
    });

    // Language switch
    $(document).on('click', '.language-switch', function (e) {
        e.preventDefault();
        var locale = $(this).data('lang');

        $.ajax({
            url: "{{ route('admin.language.switch') }}",
            type: "POST",
            data: {
                language: locale,
                _token: "{{ csrf_token() }}"
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Language switched. The page will now reload.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'premium-modal'
                        }
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: res.message || 'Failed to switch language',
                        icon: 'error',
                        confirmButtonColor: '#667eea',
                        customClass: {
                            popup: 'premium-modal'
                        }
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Server Error!',
                    text: 'An error occurred while switching language',
                    icon: 'error',
                    confirmButtonColor: '#667eea',
                    customClass: {
                        popup: 'premium-modal'
                    }
                });
            }
        });
    });

});

</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
