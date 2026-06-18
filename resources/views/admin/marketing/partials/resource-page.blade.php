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
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" data-toggle="modal" data-target="#{{ $modalId }}">
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
                                            <button type="button" class="btn btn-sm {{ $action['class'] }}" title="{{ $action['title'] }}">
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
                <button type="button" class="btn btn-primary">{{ $modalSubmit }}</button>
            </div>
        </div>
    </div>
</div>
