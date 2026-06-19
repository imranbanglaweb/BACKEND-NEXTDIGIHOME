@include('admin.marketing.partials.premium-styles')

<section role="main" class="content-body marketing-page">
    <div class="container-fluid">
        <div class="marketing-header">
            <div>
                <div class="marketing-eyebrow">Marketing</div>
                <h2><i class="{{ $pageIcon }} me-2"></i>{{ $pageTitle }}</h2>
                <p>{{ $pageSubtitle }}</p>
            </div>
            <div class="marketing-header-actions">
                <button type="button" class="btn btn-light js-open-marketing-modal" data-modal-id="{{ $modalId }}" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" data-toggle="modal" data-target="#{{ $modalId }}">
                    <i class="fas fa-plus me-2"></i>{{ $primaryAction }}
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </div>
        </div>

        <div class="row g-3 mb-3">
            @foreach($stats as $stat)
                <div class="col-xl-3 col-md-6">
                    <div class="marketing-stat-card">
                        <span class="stat-icon {{ $stat['tone'] }}"><i class="{{ $stat['icon'] }}"></i></span>
                        <div>
                            <small>{{ $stat['label'] }}</small>
                            <strong>{{ $stat['value'] }}</strong>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="marketing-panel">
            <div class="marketing-panel-title">
                <div>
                    <h5>{{ $tableTitle }}</h5>
                    <p>{{ $tableSubtitle }}</p>
                </div>
                <div class="marketing-tools">
                    <input type="text" class="form-control search-field" placeholder="{{ $searchPlaceholder }}">
                    <select class="form-select">
                        @foreach($filters as $filter)
                            <option>{{ $filter }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive marketing-table-wrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            @foreach($columns as $column)
                                <th>{{ $column }}</th>
                            @endforeach
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr>
                                @foreach($row['cells'] as $cell)
                                    <td>{!! $cell !!}</td>
                                @endforeach
                                <td>
                                    <div class="marketing-actions">
                                        @foreach($row['actions'] as $action)
                                            <button type="button"
                                                class="btn btn-sm {{ $action['class'] }} js-marketing-row-action"
                                                title="{{ $action['title'] }}"
                                                data-action-title="{{ $action['title'] }}"
                                                data-row-title="{{ trim(preg_replace('/\s+/', ' ', strip_tags($row['cells'][0]))) }}"
                                                data-modal-id="{{ $modalId }}">
                                                <i class="{{ $action['icon'] }}"></i>
                                            </button>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade marketing-modal" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog {{ $modalSize ?? 'modal-lg' }} modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $modalBody !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary js-marketing-modal-submit">{{ $modalSubmit }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade marketing-modal" id="{{ $modalId }}ActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title js-marketing-action-modal-title">Action</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="marketing-action-summary">
                    <span class="row-icon stat-blue js-marketing-action-modal-icon"><i class="fas fa-chart-bar"></i></span>
                    <div>
                        <h6 class="js-marketing-action-modal-item mb-1">Marketing item</h6>
                        <p class="js-marketing-action-modal-text mb-0 text-muted">Action details</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary js-marketing-action-confirm">Done</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function getBootstrapModalInstance(modalElement) {
        if (!window.bootstrap || !window.bootstrap.Modal) {
            return null;
        }

        if (typeof window.bootstrap.Modal.getOrCreateInstance === 'function') {
            return window.bootstrap.Modal.getOrCreateInstance(modalElement);
        }

        if (typeof window.bootstrap.Modal.getInstance === 'function') {
            return window.bootstrap.Modal.getInstance(modalElement) || new window.bootstrap.Modal(modalElement);
        }

        if (typeof window.bootstrap.Modal === 'function') {
            return new window.bootstrap.Modal(modalElement);
        }

        return null;
    }

    function showMarketingModal(modalId) {
        var modalElement = document.getElementById(modalId);

        if (!modalElement) {
            return;
        }

        var shownByPlugin = false;
        var bootstrapModal = getBootstrapModalInstance(modalElement);

        if (bootstrapModal && typeof bootstrapModal.show === 'function') {
            bootstrapModal.show();
            shownByPlugin = true;
        }

        if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
            window.jQuery(modalElement).modal('show');
            shownByPlugin = true;
        }

        if (!shownByPlugin) {
            forceOpenMarketingModal(modalElement);
            return;
        }

        setTimeout(function() {
            if (!modalElement.classList.contains('show') && !modalElement.classList.contains('in')) {
                forceOpenMarketingModal(modalElement);
            }
        }, 80);
    }

    function forceOpenMarketingModal(modalElement) {
        modalElement.style.display = 'block';
        modalElement.classList.add('show', 'in');
        modalElement.removeAttribute('aria-hidden');
        modalElement.setAttribute('aria-modal', 'true');
        modalElement.setAttribute('role', 'dialog');
        document.body.classList.add('modal-open');
    }

    function forceCloseMarketingModal(modalElement) {
        if (!modalElement) {
            return;
        }

        modalElement.style.display = 'none';
        modalElement.classList.remove('show', 'in');
        modalElement.setAttribute('aria-hidden', 'true');
        modalElement.removeAttribute('aria-modal');
        modalElement.removeAttribute('role');
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
            backdrop.remove();
        });
    }

    function hideMarketingModal(modalElement) {
        if (!modalElement) {
            return;
        }

        var hiddenByPlugin = false;
        var bootstrapModal = getBootstrapModalInstance(modalElement);

        if (bootstrapModal && typeof bootstrapModal.hide === 'function') {
            bootstrapModal.hide();
            hiddenByPlugin = true;
        }

        if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
            window.jQuery(modalElement).modal('hide');
            hiddenByPlugin = true;
        }

        if (!hiddenByPlugin) {
            forceCloseMarketingModal(modalElement);
            return;
        }

        setTimeout(function() {
            if (modalElement.classList.contains('show') || modalElement.classList.contains('in') || modalElement.style.display === 'block') {
                forceCloseMarketingModal(modalElement);
            }
        }, 150);
    }

    function notify(icon, title, text) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                timer: icon === 'success' ? 1600 : undefined,
                showConfirmButton: icon !== 'success'
            });
            return;
        }

        alert(title + (text ? '\n' + text : ''));
    }

    function showMarketingActionModal(modalId, action, rowTitle, iconClass) {
        var actionModal = document.getElementById(modalId + 'ActionModal');

        if (!actionModal) {
            notify('info', action, rowTitle);
            return;
        }

        var title = actionModal.querySelector('.js-marketing-action-modal-title');
        var item = actionModal.querySelector('.js-marketing-action-modal-item');
        var text = actionModal.querySelector('.js-marketing-action-modal-text');
        var icon = actionModal.querySelector('.js-marketing-action-modal-icon i');

        if (title) {
            title.textContent = action;
        }

        if (item) {
            item.textContent = rowTitle;
        }

        if (text) {
            text.textContent = action + ' details are ready for ' + rowTitle + '.';
        }

        if (icon) {
            icon.className = iconClass || 'fas fa-info-circle';
        }

        showMarketingModal(modalId + 'ActionModal');
    }

    document.querySelectorAll('.js-open-marketing-modal').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            showMarketingModal(button.dataset.modalId);
        });
    });

    document.querySelectorAll('.js-marketing-modal-submit').forEach(function(button) {
        button.addEventListener('click', function() {
            hideMarketingModal(button.closest('.modal'));
            setTimeout(function() {
                notify('success', 'Saved', 'The marketing item was saved for this session.');
            }, 180);
        });
    });

    document.querySelectorAll('.js-marketing-action-confirm').forEach(function(button) {
        button.addEventListener('click', function() {
            hideMarketingModal(button.closest('.modal'));
        });
    });

    document.addEventListener('click', function(event) {
        var closeButton = event.target.closest('.marketing-modal [data-dismiss="modal"], .marketing-modal [data-bs-dismiss="modal"], .marketing-modal .close, .marketing-modal .btn-close');

        if (!closeButton) {
            return;
        }

        event.preventDefault();
        hideMarketingModal(closeButton.closest('.modal'));
    });

    document.addEventListener('click', function(event) {
        var button = event.target.closest('.js-marketing-row-action');

        if (!button) {
            return;
        }

        var action = button.dataset.actionTitle || 'Action';
        var rowTitle = button.dataset.rowTitle || 'this item';
        var row = button.closest('tr');
        var normalizedAction = action.toLowerCase();
        var icon = button.querySelector('i');
        var iconClass = icon ? icon.className : 'fas fa-info-circle';

        if (normalizedAction === 'edit') {
            showMarketingModal(button.dataset.modalId);
            return;
        }

        if (normalizedAction === 'duplicate') {
            if (row && row.parentNode) {
                var clone = row.cloneNode(true);
                row.parentNode.insertBefore(clone, row.nextSibling);
            }

            notify('success', 'Duplicated', rowTitle + ' was duplicated.');
            return;
        }

        if (normalizedAction === 'delete') {
            var removeRow = function() {
                if (row) {
                    row.remove();
                }
                notify('success', 'Deleted', rowTitle + ' was removed.');
            };

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Delete item?',
                    text: rowTitle,
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#dc2626'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        removeRow();
                    }
                });
            } else if (confirm('Delete ' + rowTitle + '?')) {
                removeRow();
            }
            return;
        }

        if (normalizedAction === 'pause' || normalizedAction === 'disable') {
            var statusBadge = row ? row.querySelector('.badge') : null;
            if (statusBadge) {
                statusBadge.className = 'badge badge-soft-slate';
                statusBadge.textContent = normalizedAction === 'pause' ? 'Paused' : 'Disabled';
            }
            notify('success', action + 'd', rowTitle + ' was updated.');
            return;
        }

        showMarketingActionModal(button.dataset.modalId, action, rowTitle, iconClass);
    });
});
</script>
@endpush
