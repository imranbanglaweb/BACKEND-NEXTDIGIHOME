@extends('admin.dashboard.master')

@section('main_content')
<style>
/* Premium UI Styles */
.translation-management {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.main-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    margin: 20px;
}

.page-header {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    padding: 30px;
    margin: 0;
    border-radius: 20px 20px 0 0;
    padding-bottom: 40px;
}

.page-header h1 {
    margin: 0;
    font-weight: 800;
    font-size: 3.2rem;
    display: flex;
    align-items: center;
    gap: 20px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.page-header h1 i {
    font-size: 3.5rem;
    opacity: 0.95;
    filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));
}

.group-sidebar {
    background: #f8f9fa;
    border-right: 2px solid #e9ecef;
    padding: 30px 20px;
}

.group-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.group-item {
    margin-bottom: 10px;
}

.group-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 18px 24px;
    border-radius: 15px;
    text-decoration: none;
    color: #6c757d;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
}

.group-link:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.group-link:hover:before {
    left: 100%;
}

.group-link:hover {
    background: white;
    color: #495057;
    transform: translateX(8px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.group-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: rgba(255,255,255,0.3);
    box-shadow: 0 6px 18px rgba(102, 126, 234, 0.4);
}

.group-link i {
    font-size: 1.4rem;
    width: 24px;
}

.content-area {
    /* padding: 30px; */
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f8f9fa;
}

.content-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.content-title i {
    font-size: 2.4rem;
    color: #667eea;
}

.action-buttons {
    display: flex;
    gap: 15px;
    align-items: center;
}

.btn-premium {
    padding: 16px 32px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 1.1rem;
    border: none;
    cursor: pointer;
    transition: all 0.4s ease;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    position: relative;
    overflow: hidden;
}

.btn-premium:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-premium:hover:before {
    left: 100%;
}

.btn-premium i {
    font-size: 1.3rem;
    font-weight: bold;
}

.btn-primary-premium {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
}

.btn-primary-premium:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.7);
}

.btn-success-premium {
    background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(78, 205, 196, 0.5);
}

.btn-success-premium:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 12px 35px rgba(78, 205, 196, 0.7);
}

.btn-info-premium {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(116, 185, 255, 0.5);
}

.btn-info-premium:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 12px 35px rgba(116, 185, 255, 0.7);
}

.bulk-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 20px;
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    color: #495057;
    font-size: 1rem;
}

.row-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #667eea;
    cursor: pointer;
    border-radius: 4px;
    margin-right: 10px;
}

.translation-table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.table-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    font-weight: 700;
}

.table-header th {
    padding: 25px 20px;
    border: none;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.key-column {
    width: 220px;
    font-weight: 700;
    color: #2c3e50;
    font-size: 1rem;
}

.language-column {
    min-width: 180px;
}

.language-header {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: center;
}

.flag-text {
    display: inline-block;
    width: 24px;
    height: 18px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-align: center;
    font-size: 10px;
    font-weight: bold;
    border-radius: 3px;
    line-height: 18px;
    margin-right: 8px;
}

.table-body tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f1f3f4;
}

.table-body tr:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
    transform: scale(1.01);
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.table-body td {
    padding: 18px 20px;
    border: none;
    vertical-align: middle;
    font-size: 0.95rem;
}

.translation-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
    font-weight: 500;
}

.translation-input:focus {
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
    outline: none;
    transform: scale(1.02);
}

.translation-input.changed {
    border-color: #28a745;
    background: #f8fff8;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
}

.actions-column {
    width: 200px;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 8px;
}

.action-btn {
    padding: 12px 20px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-right: 8px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    position: relative;
    overflow: hidden;
}

.action-btn:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.4s;
}

.action-btn:hover:before {
    left: 100%;
}

.action-btn i {
    font-size: 1rem;
}

.btn-save {
    background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
    color: white;
}

.btn-save:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 18px rgba(78, 205, 196, 0.6);
}

.btn-translate {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.btn-translate:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 18px rgba(116, 185, 255, 0.6);
}

.btn-loading {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.progress-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.progress-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    min-width: 300px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin: 20px 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    width: 0%;
    transition: width 0.3s ease;
}

.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

.toast-premium {
    background: white;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 10px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 12px;
    transform: translateX(400px);
    opacity: 0;
    transition: all 0.3s ease;
    border-left: 4px solid;
    min-width: 300px;
}

.toast-premium.show {
    transform: translateX(0);
    opacity: 1;
}

.toast-success {
    border-left-color: #28a745;
}

.toast-error {
    border-left-color: #dc3545;
}

.toast-info {
    border-left-color: #17a2b8;
}

.toast-warning {
    border-left-color: #ffc107;
}

.toast-icon {
    font-size: 1.5rem;
}

.toast-success .toast-icon { color: #28a745; }
.toast-error .toast-icon { color: #dc3545; }
.toast-info .toast-icon { color: #17a2b8; }
.toast-warning .toast-icon { color: #ffc107; }

.toast-message {
    font-weight: 500;
    color: #495057;
}

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

@media (max-width: 768px) {
    .main-container {
        margin: 10px;
        border-radius: 15px;
    }

    .page-header {
        padding: 20px;
    }

    .page-header h1 {
        font-size: 2rem;
    }

    .content-area {
        padding: 20px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 10px;
    }

    .bulk-actions {
        flex-wrap: wrap;
    }

    .translation-table {
        font-size: 0.8rem;
    }

    .table-header th,
    .table-body td {
        padding: 10px 8px;
    }

    .actions-column {
        width: 150px;
    }

    .action-btn {
        padding: 6px 12px;
        font-size: 0.75rem;
    }
}
</style>
<section role="" class="content-body" style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
<section class="translation-management">
<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>
            <i class="fa fa-language"></i>
            Translation Management
        </h1>
    </div>
<br>
    <div class="row no-gutters">
        <!-- Main Content -->
        <div class="col-md-12">
            <div class="content-area">
                <div class="content-header">
                    <h2 class="content-title">
                        <i class="fa fa-list"></i>
                        @if($search ?? false)
                            Search Results for "{{ $search }}" ({{ $translations->total() }} found)
                        @else
                            All Translations ({{ $translations->total() }} total)
                        @endif
                    </h2>
                    <div class="action-buttons">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.translations') }}" class="d-flex me-3">
                            <div class="input-group" style="width: 300px;">
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Search keys, groups, or text..." 
                                       value="{{ $search ?? '' }}"
                                       style="border-radius: 25px 0 0 25px; border: 2px solid #e9ecef;">
                                <button class="btn btn-outline-secondary" type="submit" style="border-radius: 0 25px 25px 0; border: 2px solid #e9ecef; border-left: none;">
                                    <i class="fa fa-search"></i>
                                </button>
                                @if($search ?? false)
                                <a href="{{ route('admin.translations') }}" class="btn btn-outline-danger ms-2" style="border-radius: 25px;" title="Clear search">
                                    <i class="fa fa-times"></i>
                                </a>
                                @endif
                            </div>
                        </form>
                        <button class="btn-premium btn-primary-premium" onclick="addNewTranslation()">
                            <i class="fa fa-plus"></i>
                            Add New Key
                        </button>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <div class="bulk-actions">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="select-all" onchange="toggleSelectAll()">
                        <label for="select-all">Select All</label>
                    </div>
                    <button class="btn-premium btn-success-premium" onclick="bulkSave()" id="bulk-save-btn">
                        <i class="fa fa-save"></i>
                        Bulk Save
                    </button>
                    <button class="btn-premium btn-info-premium" onclick="bulkAutoTranslate()" id="bulk-translate-btn">
                        <i class="fa fa-magic"></i>
                        Bulk Auto Translate
                    </button>
                </div>

                <!-- Translation Table -->
                <div class="translation-table">
                    <table class="table table-hover mb-0">
                        <thead class="table-header">
                            <tr>
                                <th class="key-column">
                                    <i class="fa fa-key"></i>
                                    Translation Key
                                </th>
                                <th style="width: 120px;">
                                    <i class="fa fa-folder"></i>
                                    Group
                                </th>
                                @foreach(available_languages() as $lang)
                                <th class="language-column">
                                    <div class="language-header">
                                        <span class="flag-text">{{ strtoupper(substr($lang->code, 0, 2)) }}</span>
                                        {{ $lang->name }}
                                    </div>
                                </th>
                                @endforeach
                                <th class="actions-column">
                                    <i class="fa fa-cogs"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-body" id="translations-table-body">
                            <!-- Translations will be loaded via AJAX -->
                            <tr id="loading-row">
                                <td colspan="100%" class="text-center py-5">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="spinner-border text-primary me-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span class="text-muted">Loading translations...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper" id="pagination-wrapper">
                    <!-- Pagination will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Progress Overlay -->
<div class="progress-overlay" id="progress-overlay">
    <div class="progress-container">
        <div class="text-center mb-3">
            <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
        </div>
        <h5 id="progress-title">Processing...</h5>
        <div class="progress-bar">
            <div class="progress-fill" id="progress-fill"></div>
        </div>
        <p id="progress-message">Please wait...</p>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toast-container"></div>
</section>
</section>

@endsection

@section('scripts')
<script>
// Global variables
let selectedTranslations = new Set();
let changedTranslations = new Set();

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Load translations via AJAX
    loadTranslations();

    // Search functionality
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
    const clearSearchBtn = document.getElementById('clear-search-btn');

    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadTranslations(1, this.value);
        }, 500);
    });

    searchBtn.addEventListener('click', function() {
        loadTranslations(1, searchInput.value);
    });

    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        loadTranslations(1, '');
    });

    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        loadTranslations(1, '');
    });

    // Mark changed inputs (will be called after AJAX load)
    // document.querySelectorAll('.translation-input').forEach(input => {
    //     input.dataset.originalValue = input.value;
    // });
});

// AJAX Functions
function loadTranslations(page = 1, search = '') {
    const tableBody = document.getElementById('translations-table-body');
    const paginationWrapper = document.getElementById('pagination-wrapper');

    // Show loading state
    tableBody.innerHTML = `
        <tr id="loading-row">
            <td colspan="100%" class="text-center py-5">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="spinner-border text-primary me-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="text-muted">Loading translations...</span>
                </div>
            </td>
        </tr>
    `;

    // Build URL with parameters
    const url = new URL(window.location);
    url.searchParams.set('page', page);
    if (search) {
        url.searchParams.set('search', search);
    }

    fetch(url.toString(), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        renderTranslations(data.translations);
        renderPagination(data.pagination, search);
        updateSearchResults(data.search, data.pagination.total);

        // Mark inputs as changed after loading
        document.querySelectorAll('.translation-input').forEach(input => {
            input.dataset.originalValue = input.value;
        });
    })
    .catch(error => {
        console.error('Error loading translations:', error);
        tableBody.innerHTML = `
            <tr>
                <td colspan="100%" class="text-center py-5">
                    <div class="text-danger">
                        <i class="fa fa-exclamation-triangle fa-2x mb-3"></i>
                        <p>Error loading translations. Please try again.</p>
                        <button class="btn btn-primary" onclick="loadTranslations(${page}, '${search}')">
                            <i class="fa fa-refresh me-2"></i>Retry
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
}

function renderTranslations(translations) {
    const tableBody = document.getElementById('translations-table-body');

    if (translations.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="100%" class="text-center py-5">
                    <div class="text-muted">
                        <i class="fa fa-search fa-2x mb-3"></i>
                        <p>No translations found.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    translations.forEach(translation => {
        html += `
            <tr data-id="${translation.id}">
                <td class="key-column">
                    <div class="d-flex align-items-center gap-2">
                        <input type="checkbox" class="row-checkbox" value="${translation.id}">
                        <code class="text-primary">${translation.key}</code>
                    </div>
                </td>
                <td>
                    <span class="badge bg-secondary">${translation.group}</span>
                </td>`;

        // Add language columns
        @foreach(available_languages() as $lang)
        html += `
                <td>
                    <input type="text"
                           class="form-control translation-input"
                           data-id="${translation.id}"
                           data-lang="{{ $lang->code }}"
                           value="${translation.values['{{ $lang->code }}'] || ''}"
                           onchange="markAsChanged(this)">
                </td>`;
        @endforeach

        html += `
                <td class="actions-column">
                    <button class="action-btn btn-save"
                            onclick="saveTranslation(${translation.id}, this)">
                        <i class="fa fa-save"></i>
                    </button>
                    <button class="action-btn btn-translate"
                            onclick="autoTranslate(${translation.id}, this)">
                        <i class="fa fa-magic"></i>
                    </button>
                </td>
            </tr>`;
    });

    tableBody.innerHTML = html;
}

function renderPagination(pagination, search) {
    const paginationWrapper = document.getElementById('pagination-wrapper');

    if (!pagination || pagination.last_page <= 1) {
        paginationWrapper.innerHTML = '';
        return;
    }

    let html = '<nav aria-label="Translation pagination"><ul class="pagination justify-content-center">';

    // Previous button
    if (pagination.current_page > 1) {
        html += `<li class="page-item">
            <a class="page-link" href="#" onclick="loadTranslations(${pagination.current_page - 1}, '${search}')">
                <i class="fa fa-chevron-left"></i>
            </a>
        </li>`;
    }

    // Page numbers
    const startPage = Math.max(1, pagination.current_page - 2);
    const endPage = Math.min(pagination.last_page, pagination.current_page + 2);

    if (startPage > 1) {
        html += `<li class="page-item">
            <a class="page-link" href="#" onclick="loadTranslations(1, '${search}')">1</a>
        </li>`;
        if (startPage > 2) {
            html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        const activeClass = i === pagination.current_page ? ' active' : '';
        html += `<li class="page-item${activeClass}">
            <a class="page-link" href="#" onclick="loadTranslations(${i}, '${search}')">${i}</a>
        </li>`;
    }

    if (endPage < pagination.last_page) {
        if (endPage < pagination.last_page - 1) {
            html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        html += `<li class="page-item">
            <a class="page-link" href="#" onclick="loadTranslations(${pagination.last_page}, '${search}')">${pagination.last_page}</a>
        </li>`;
    }

    // Next button
    if (pagination.current_page < pagination.last_page) {
        html += `<li class="page-item">
            <a class="page-link" href="#" onclick="loadTranslations(${pagination.current_page + 1}, '${search}')">
                <i class="fa fa-chevron-right"></i>
            </a>
        </li>`;
    }

    html += '</ul></nav>';
    paginationWrapper.innerHTML = html;
}

function updateSearchResults(search, total) {
    const searchResultsDiv = document.getElementById('search-results');
    const clearSearchBtn = document.getElementById('clear-search-btn');

    if (search) {
        searchResultsDiv.innerHTML = `
            <i class="fa fa-search me-2"></i>
            Search Results for "${search}" (${total} found)
        `;
        clearSearchBtn.style.display = 'inline-block';
    } else {
        searchResultsDiv.innerHTML = '';
        clearSearchBtn.style.display = 'none';
    }
}

// Premium Toast System
function showToast(message, type = 'success', duration = 4000) {
    const toastContainer = document.getElementById('toast-container');

    const toast = document.createElement('div');
    toast.className = `toast-premium toast-${type}`;

    let icon = '';
    switch(type) {
        case 'success': icon = 'fa fa-check-circle'; break;
        case 'error': icon = 'fa fa-exclamation-circle'; break;
        case 'info': icon = 'fa fa-info-circle'; break;
        case 'warning': icon = 'fa fa-exclamation-triangle'; break;
    }

    toast.innerHTML = `
        <div class="toast-icon">
            <i class="${icon}"></i>
        </div>
        <div class="toast-message">${message}</div>
    `;

    toastContainer.appendChild(toast);

    // Trigger animation
    setTimeout(() => toast.classList.add('show'), 100);

    // Auto remove
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

// Mark input as changed
function markAsChanged(input) {
    if (input.value !== input.dataset.originalValue) {
        input.classList.add('changed');
        changedTranslations.add(parseInt(input.dataset.id));
    } else {
        input.classList.remove('changed');
        changedTranslations.delete(parseInt(input.dataset.id));
    }
}

// Toggle select all
function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.row-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
        updateSelection(parseInt(checkbox.value), checkbox.checked);
    });
}

// Update selection
function updateSelection(id, checked) {
    if (checked) {
        selectedTranslations.add(id);
    } else {
        selectedTranslations.delete(id);
    }
    updateBulkButtons();
}

// Update bulk buttons state
function updateBulkButtons() {
    const bulkSaveBtn = document.getElementById('bulk-save-btn');
    const bulkTranslateBtn = document.getElementById('bulk-translate-btn');

    const hasSelection = selectedTranslations.size > 0;
    const hasChanges = [...selectedTranslations].some(id => changedTranslations.has(id));

    bulkSaveBtn.disabled = !hasChanges;
    bulkTranslateBtn.disabled = !hasSelection;

    bulkSaveBtn.style.opacity = hasChanges ? '1' : '0.5';
    bulkTranslateBtn.style.opacity = hasSelection ? '1' : '0.5';
}

// Save single translation
function saveTranslation(translationId, btn) {
    const inputs = document.querySelectorAll(`.translation-input[data-id="${translationId}"]`);
    const data = {};
    inputs.forEach(input => data[input.dataset.lang] = input.value);

    setButtonLoading(btn, true, 'Saving...');

    fetch("{{ route('translations.update') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            translation_id: translationId,
            translations: data
        })
    })
    .then(res => {
        if (!res.ok) throw res;
        return res.json();
    })
    .then(data => {
        if (data.success) {
            showToast('Translation saved successfully!', 'success');
            // Reset changed state
            inputs.forEach(input => {
                input.dataset.originalValue = input.value;
                input.classList.remove('changed');
            });
            changedTranslations.delete(translationId);
            updateBulkButtons();
        } else {
            showToast(data.message || 'Save failed!', 'error');
        }
    })
    .catch(async (err) => {
        let msg = 'Server error!';
        try {
            const json = await err.json();
            if (json.message) msg = json.message;
        } catch {}
        showToast(msg, 'error');
    })
    .finally(() => {
        setButtonLoading(btn, false, '<i class="fa fa-save"></i> Save');
    });
}

// Bulk save
function bulkSave() {
    if (selectedTranslations.size === 0) {
        showToast('Please select translations to save', 'warning');
        return;
    }

    const changedSelected = [...selectedTranslations].filter(id => changedTranslations.has(id));
    if (changedSelected.length === 0) {
        showToast('No changes to save', 'info');
        return;
    }

    showProgress('Saving translations...', 0, `Processing ${changedSelected.length} translations...`);

    let completed = 0;
    let errors = 0;

    const promises = changedSelected.map(id => {
        return new Promise((resolve) => {
            const inputs = document.querySelectorAll(`.translation-input[data-id="${id}"]`);
            const data = {};
            inputs.forEach(input => data[input.dataset.lang] = input.value);

            fetch("{{ route('translations.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    translation_id: id,
                    translations: data
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Reset changed state
                    inputs.forEach(input => {
                        input.dataset.originalValue = input.value;
                        input.classList.remove('changed');
                    });
                    changedTranslations.delete(id);
                } else {
                    errors++;
                }
                completed++;
                updateProgress(completed / changedSelected.length * 100, `Processed ${completed}/${changedSelected.length} translations...`);
                resolve();
            })
            .catch(() => {
                errors++;
                completed++;
                updateProgress(completed / changedSelected.length * 100, `Processed ${completed}/${changedSelected.length} translations...`);
                resolve();
            });
        });
    });

    Promise.all(promises).then(() => {
        hideProgress();
        if (errors === 0) {
            showToast(`Successfully saved ${changedSelected.length} translations!`, 'success');
        } else {
            showToast(`Saved ${changedSelected.length - errors} translations, ${errors} failed`, errors > 0 ? 'warning' : 'success');
        }
        updateBulkButtons();
    });
}

// Auto translate single
function autoTranslate(translationId, btn) {
    const englishInput = document.querySelector(`.translation-input[data-id="${translationId}"][data-lang="en"]`);
    if (!englishInput || !englishInput.value.trim()) {
        showToast('Please enter English text first!', 'error');
        return;
    }

    setButtonLoading(btn, true, 'Translating...');

    fetch("{{ route('admin.translations.auto') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            translation_id: translationId,
            source_text: englishInput.value.trim()
        })
    })
    .then(res => {
        if (!res.ok) throw res;
        return res.json();
    })
    .then(data => {
        if (data.success) {
            // Update input fields
            Object.keys(data.translations).forEach(lang => {
                const input = document.querySelector(`.translation-input[data-id="${translationId}"][data-lang="${lang}"]`);
                if (input && data.translations[lang]) {
                    input.value = data.translations[lang];
                    input.classList.add('changed');
                    changedTranslations.add(translationId);
                    markAsChanged(input);
                }
            });
            showToast('Auto translation completed!', 'success');
            updateBulkButtons();
        } else {
            showToast(data.message || 'Auto translation failed!', 'error');
        }
    })
    .catch(async (err) => {
        let msg = 'Server error!';
        try {
            const json = await err.json();
            if (json.message) msg = json.message;
        } catch {}
        showToast(msg, 'error');
    })
    .finally(() => {
        setButtonLoading(btn, false, '<i class="fa fa-magic"></i> Auto');
    });
}

// Bulk auto translate
function bulkAutoTranslate() {
    if (selectedTranslations.size === 0) {
        showToast('Please select translations to auto-translate', 'warning');
        return;
    }

    showProgress('Auto translating...', 0, `Processing ${selectedTranslations.size} translations...`);

    let completed = 0;
    let errors = 0;

    const promises = [...selectedTranslations].map(id => {
        return new Promise((resolve) => {
            const englishInput = document.querySelector(`.translation-input[data-id="${id}"][data-lang="en"]`);
            if (!englishInput || !englishInput.value.trim()) {
                completed++;
                updateProgress(completed / selectedTranslations.size * 100, `Processed ${completed}/${selectedTranslations.size} translations...`);
                resolve();
                return;
            }

            fetch("{{ route('admin.translations.auto') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    translation_id: id,
                    source_text: englishInput.value.trim()
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update input fields
                    Object.keys(data.translations).forEach(lang => {
                        const input = document.querySelector(`.translation-input[data-id="${id}"][data-lang="${lang}"]`);
                        if (input && data.translations[lang]) {
                            input.value = data.translations[lang];
                            input.classList.add('changed');
                            changedTranslations.add(id);
                            markAsChanged(input);
                        }
                    });
                } else {
                    errors++;
                }
                completed++;
                updateProgress(completed / selectedTranslations.size * 100, `Processed ${completed}/${selectedTranslations.size} translations...`);
                resolve();
            })
            .catch(() => {
                errors++;
                completed++;
                updateProgress(completed / selectedTranslations.size * 100, `Processed ${completed}/${selectedTranslations.size} translations...`);
                resolve();
            });
        });
    });

    Promise.all(promises).then(() => {
        hideProgress();
        if (errors === 0) {
            showToast(`Successfully auto-translated ${selectedTranslations.size} translations!`, 'success');
        } else {
            showToast(`Auto-translated ${selectedTranslations.size - errors} translations, ${errors} failed`, errors > 0 ? 'warning' : 'success');
        }
        updateBulkButtons();
    });
}

// Add new translation
function addNewTranslation() {
    Swal.fire({
        title: 'Add New Translation Key',
        html: `
            <input type="text" id="swal-key" class="swal2-input" placeholder="Enter translation key (e.g., welcome.message)">
            <select id="swal-group" class="swal2-input">
                <option value="backend">Backend</option>
                <option value="frontend">Frontend</option>
                <option value="messages">Messages</option>
                <option value="validation">Validation</option>
                <option value="emails">Emails</option>
            </select>
        `,
        focusConfirm: false,
        preConfirm: () => {
            const key = document.getElementById('swal-key').value;
            const group = document.getElementById('swal-group').value;
            
            if (!key) {
                Swal.showValidationMessage('Translation key is required!');
                return false;
            }
            if (key.length < 2) {
                Swal.showValidationMessage('Translation key must be at least 2 characters!');
                return false;
            }
            if (!/^[a-zA-Z0-9._]+$/.test(key)) {
                Swal.showValidationMessage('Translation key can only contain letters, numbers, dots, and underscores!');
                return false;
            }
            
            return { key, group };
        },
        showCancelButton: true,
        confirmButtonText: 'Add Key',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#6c757d',
        customClass: {
            popup: 'premium-modal',
            confirmButton: 'btn-premium btn-primary-premium',
            cancelButton: 'btn-premium btn-secondary-premium'
        },
        showLoaderOnConfirm: true,
        preConfirm: (data) => {
            return fetch("{{ route('translations.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    key: data.key,
                    group: data.group
                })
            })
            .then(res => {
                if (!res.ok) throw res;
                return res.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Failed to add translation key!');
                }
                return data;
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Success!',
                text: 'Translation key added successfully! Reloading page...',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'premium-modal'
                }
            });
            setTimeout(() => location.reload(), 2000);
        }
    }).catch((error) => {
        Swal.fire({
            title: 'Error!',
            text: error.message || 'An error occurred while adding the translation key.',
            icon: 'error',
            confirmButtonColor: '#667eea',
            customClass: {
                popup: 'premium-modal'
            }
        });
    });
}

// Utility functions
function setButtonLoading(btn, loading, text) {
    btn.disabled = loading;
    btn.innerHTML = text;
    if (loading) {
        btn.classList.add('btn-loading');
    } else {
        btn.classList.remove('btn-loading');
    }
}

function showProgress(title, percentage, message) {
    const overlay = document.getElementById('progress-overlay');
    const titleEl = document.getElementById('progress-title');
    const fillEl = document.getElementById('progress-fill');
    const messageEl = document.getElementById('progress-message');

    titleEl.textContent = title;
    messageEl.textContent = message;
    fillEl.style.width = percentage + '%';

    overlay.style.display = 'flex';
}

function updateProgress(percentage, message) {
    const fillEl = document.getElementById('progress-fill');
    const messageEl = document.getElementById('progress-message');

    fillEl.style.width = percentage + '%';
    messageEl.textContent = message;
}

function hideProgress() {
    const overlay = document.getElementById('progress-overlay');
    overlay.style.display = 'none';
}

// Initialize checkbox listeners
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelection(parseInt(this.value), this.checked);
        });
    });

    // Initialize bulk buttons state
    updateBulkButtons();
});
</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
