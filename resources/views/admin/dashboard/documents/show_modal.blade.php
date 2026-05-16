<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #17a2b8;">
            <h5 class="modal-title text-white">
                <i class="fa fa-file-text"></i> Document Details
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <!-- Document Info Tabs -->
            <ul class="nav nav-tabs" id="documentTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab">
                        <i class="fa fa-info-circle"></i> Basic Info
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab">
                        <i class="fa fa-map-marker"></i> Location Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="dates-tab" data-toggle="tab" href="#dates" role="tab">
                        <i class="fa fa-calendar"></i> Dates
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="documentTabContent">
                <!-- Basic Info Tab -->
                <div class="tab-pane fade show active" id="details" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-details">
                                <tr>
                                    <th width="40%">Project</th>
                                    <td><span class="badge badge-info">{{ optional($document->project)->project_name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Land</th>
                                    <td><span class="badge badge-secondary">{{ optional($document->land)->name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Document Type</th>
                                    <td><span class="badge badge-primary">{{ optional($document->documentType)->name }}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-details">
                                <tr>
                                    <th width="40%">Document Taker</th>
                                    <td>{{ $document->document_taker }}</td>
                                </tr>
                                <tr>
                                    <th>Witness Name</th>
                                    <td>{{ $document->witness_name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $document->status === 'withdrawn' ? 'warning' : 'success' }}">
                                            {{ ucfirst($document->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Location Tab -->
                <div class="tab-pane fade" id="location" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-details">
                                <tr>
                                    <th width="40%">Vault Number</th>
                                    <td>{{ $document->vault_number }}</td>
                                </tr>
                                <tr>
                                    <th>Vault Location</th>
                                    <td>{{ $document->vault_location }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Dates Tab -->
                <div class="tab-pane fade" id="dates" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-details">
                                <tr>
                                    <th width="40%">Created Date</th>
                                    <td>{{ $document->date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Expected Return</th>
                                    <td>{{ $document->proposed_return_date->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<style>
.modal-content {
    border: none;
    border-radius: 0.3rem;
}

.nav-tabs {
    border-bottom: 2px solid #dee2e6;
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    color: #495057;
    padding: 0.75rem 1rem;
}

.nav-tabs .nav-link:hover {
    border-color: transparent;
    color: #17a2b8;
}

.nav-tabs .nav-link.active {
    color: #17a2b8;
    border-bottom: 2px solid #17a2b8;
    background: transparent;
}

.table-details {
    margin-bottom: 0;
}

.table-details th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-top: none;
}

.table-details td {
    border-top: none;
}

.badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}
</style>

<script>
$(document).ready(function() {
    // Initialize tabs
    $('#documentTabs a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Show first tab on load
    $('#documentTabs li:first-child a').tab('show');
});
</script> 