@extends('admin.dashboard.master')

@section('main_content')

<link rel="stylesheet" href="{{ asset('public/admin_resource/assets/css/translation.css') }}">

<style>
    /* Progress Overlay Styles */
    .progress-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .progress-container {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        text-align: center;
        width: 400px;
        max-width: 90%;
        position: relative;
        overflow: hidden;
    }

    .progress-spinner {
        margin-bottom: 20px;
    }

    .progress-spinner i {
        font-size: 3rem;
        color: #667eea;
    }

    .progress-bar-wrapper {
        height: 10px;
        background-color: #e9ecef;
        border-radius: 5px;
        overflow: hidden;
        margin: 20px 0;
        position: relative;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        width: 0%;
        transition: width 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-radius: 5px;
        position: relative;
    }

    .progress-bar-fill::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background-image: linear-gradient(
            45deg,
            rgba(255, 255, 255, 0.15) 25%,
            transparent 25%,
            transparent 50%,
            rgba(255, 255, 255, 0.15) 50%,
            rgba(255, 255, 255, 0.15) 75%,
            transparent 75%,
            transparent
        );
        background-size: 1rem 1rem;
        animation: progress-bar-stripes 1s linear infinite;
    }

    @keyframes progress-bar-stripes {
        0% { background-position: 1rem 0; }
        100% { background-position: 0 0; }
    }

    .progress-bar-fill.progress-low {
        background: linear-gradient(90deg, #ef4444, #f97316);
    }
    .progress-bar-fill.progress-medium {
        background: linear-gradient(90deg, #f97316, #eab308);
    }
    .progress-bar-fill.progress-high {
        background: linear-gradient(90deg, #22c55e, #10b981);
    }

    .progress-status {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .progress-percentage {
        color: #666;
        font-size: 0.9rem;
    }
    
    .progress-log {
        color: #888;
        font-size: 0.8rem;
        margin-top: 5px;
        min-height: 1.2em;
        font-family: monospace;
    }

    /* Success Checkmark Animation */
    .success-checkmark {
        display: none;
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        position: relative;
    }
    .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4CAF50;
    }
    .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }
    .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }
    .check-icon::before, .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: #FFFFFF;
        transform: rotate(-45deg);
    }
    .check-icon .icon-line {
        height: 5px;
        background-color: #4CAF50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }
    .check-icon .line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }
    .check-icon .line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }
    .check-icon .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(76, 175, 80, .5);
    }
    .check-icon .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: #FFFFFF;
    }
    @keyframes rotate-circle {
        0% { transform: rotate(-45deg); }
        5% { transform: rotate(-45deg); }
        12% { transform: rotate(-405deg); }
        100% { transform: rotate(-405deg); }
    }
    @keyframes icon-line-tip {
        0% { width: 0; left: 1px; top: 19px; }
        54% { width: 0; left: 1px; top: 19px; }
        70% { width: 50px; left: -8px; top: 37px; }
        84% { width: 17px; left: 21px; top: 48px; }
        100% { width: 25px; left: 14px; top: 46px; }
    }
    @keyframes icon-line-long {
        0% { width: 0; right: 46px; top: 54px; }
        65% { width: 0; right: 46px; top: 54px; }
        84% { width: 55px; right: 0px; top: 35px; }
        100% { width: 47px; right: 8px; top: 38px; }
    }
</style>

<div id="notification-container"></div>

<section class="content-body" style="background:#fff;">
<div class="main-container">

    <!-- Header -->
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fa fa-language"></i> Translation Management</h2>
        <br>

        <div class="d-flex gap-2 ms-auto align-items-center">
        <div class="row">
            <div class="col-md-4">
                        <!-- Select & Bulk Save -->

        <label>
            <input type="checkbox" id="select-all"> Select All
        </label>

        <button class="btn btn-primary px-4" id="bulk-save-btn" disabled>
            <i class="fa fa-save"></i> Bulk Save
        </button>

            <button class="btn btn-success" id="bulk-auto-btn">
                <i class="fa fa-language"></i> Bulk Auto Translate
            </button>
           
            </div>
            <div class="col-md-4"><input type="text" id="search-input" class="form-control" placeholder="Search..." style="width:260px;">
        </div>
            <div class="col-md-4">
                 <button class="btn btn-primary ms-2 pull-right" data-bs-toggle="modal" data-bs-target="#addTranslationModal">
                <i class="fa fa-plus"></i> Add
            </button>
            </div>
        </div>
        </div>
    </div>

    <div class="progress mb-3" style="display: none;">
        <div id="bulk-save-progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>

    <!-- Table -->
    <table class="table table-bordered align-middle">
        <thead>
        <tr>
            <th width="40">✔</th>
            <th>Key</th>
            <th>Group</th>
            @foreach(available_languages() as $lang)
                <th>{{ strtoupper($lang->code) }}</th>
            @endforeach
            <th width="180">Action</th>
        </tr>
        </thead>

        <tbody id="translations-table-body">
            <tr>
                <td colspan="100%" class="text-center">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </td>
            </tr>
        </tbody>
    </table>

    <div id="pagination-wrapper" class="mt-3"></div>

</div>
</section>
{{-- ADD MODAL --}}
<div class="modal" id="addTranslationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="fa fa-plus-circle me-2"></i> Add Translation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    {{-- Left Column: Group + Key --}}
                    <div class="col-md-6">
                        <div class="mb-3 position-relative">
                            <label class="form-label"><i class="fa fa-layer-group me-1"></i> Group</label>
                            <input class="form-control" id="new-group" placeholder="Enter group">
                            <div class="invalid-feedback" id="error-group"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label"><i class="fa fa-key me-1"></i> Key</label>
                            <input class="form-control" id="new-key" placeholder="Enter key">
                            <div class="invalid-feedback" id="error-key"></div>
                        </div>
                    </div>

                    {{-- Right Column: Language Values --}}
                    <div class="col-md-6">
                        @foreach(available_languages() as $lang)
                            <div class="mb-3 position-relative">
                                <label class="form-label">
                                    <i class="fa fa-language me-1"></i> {{ strtoupper($lang->code) }}
                                    @if(strtolower($lang->code) === 'en') <span class="text-danger">*</span> @endif
                                </label>
                                <input class="form-control new-value" 
                                       data-lang="{{ $lang->code }}" 
                                       placeholder="Enter {{ strtoupper($lang->code) }} value">
                                <div class="invalid-feedback" id="error-{{ $lang->code }}"></div>
                                <span class="valid-icon"><i class="fa fa-check-circle text-success"></i></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-primary px-4" id="add-translation-submit">
                    <i class="fa fa-plus-circle me-1"></i> Submit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Progress Overlay -->
<div class="progress-overlay" id="progress-overlay">
    <div class="progress-container">
        <div class="progress-spinner">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>
        <h5 class="progress-status" id="progress-title">Processing...</h5>
        <div class="progress-bar-wrapper">
            <div class="progress-bar-fill" id="progress-fill" style="width: 0%;"></div>
        </div>
        <p class="progress-percentage" id="progress-message">0% Completed</p>
        <p class="progress-log" id="progress-key"></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
window.LANGUAGES = @json(available_languages()->pluck('code'));
window.ROUTES = {
    ajax: "{{ route('admin.translations.ajax') }}",
    update: "{{ route('translations.update') }}",
    auto: "{{ route('admin.translations.auto') }}",
    create: "{{ route('translations.create') }}"
};
window.CSRF_TOKEN = "{{ csrf_token() }}";
</script>

<script src="{{ asset('public/admin_resource/assets/js/translate.js') }}"></script>

@endsection
