@extends('admin.dashboard.master')

@section('main_content')
<style>
    .text-secondary {
        color: #0088cc !important;
        font-size: 15px;
        font-weight: 700;
    }
    .text-dark {
        color: #000!important;
        font-size: 16px;
        font-weight: 600;
    }
    .table th,td{
        font-size: 15px!important;
        font-weight: 500!important;
    }
    .table th{
        font-size: 16px!important;
        font-weight: 500!important;
        color: #fff!important;
        background-color: #0088cc!important;
    }
    /* Full Page Loading Overlay */
    .page-loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100vw;
        height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 999999;
        transition: opacity 0.3s ease;
    }
    .page-loading-overlay.hidden {
        opacity: 0;
        pointer-events: none;
    }
    .page-loading-overlay.fade-out {
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    .page-loading-overlay.fade-out .loading-spinner-circle {
        transform: scale(0.8);
    }
    .loading-spinner-circle {
        width: 70px;
        height: 70px;
        border: 6px solid rgba(255,255,255,0.3);
        border-top: 6px solid #fff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        box-shadow: 0 0 30px rgba(255,255,255,0.3);
    }
    .loading-text {
        margin-top: 25px;
        font-size: 18px;
        color: #fff;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        letter-spacing: 1px;
    }
    .loading-subtext {
        margin-top: 10px;
        font-size: 14px;
        color: rgba(255,255,255,0.8);
        font-weight: 400;
    }
    .loading-progress {
        width: 200px;
        height: 4px;
        background: rgba(255,255,255,0.3);
        border-radius: 2px;
        margin-top: 20px;
        overflow: hidden;
    }
    .loading-progress-bar {
        height: 100%;
        background: #fff;
        border-radius: 2px;
        animation: progress 1.5s ease-in-out infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes progress {
        0% { width: 0%; margin-left: 0%; margin-right: 100%; }
        50% { width: 100%; margin-left: 0%; margin-right: 0%; }
        100% { width: 0%; margin-left: 100%; margin-right: 0%; }
    }
    .btn-loading {
        position: relative;
        color: transparent !important;
        pointer-events: none;
    }
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #fff;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    .loading-select {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><circle cx="50" cy="50" r="40" fill="none" stroke="%230088cc" stroke-width="8" stroke-dasharray="200" stroke-dashoffset="0"><animateTransform attributeName="transform" type="rotate" from="0 50 50" to="360 50 50" dur="1s" repeatCount="indefinite"/></circle></svg>') !important;
        background-repeat: no-repeat !important;
        background-position: right 10px center !important;
        background-size: 20px 20px !important;
    }
    .select-loading {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><circle cx="50" cy="50" r="40" fill="none" stroke="%230088cc" stroke-width="8" stroke-dasharray="200" stroke-dashoffset="0"><animateTransform attributeName="transform" type="rotate" from="0 50 50" to="360 50 50" dur="1s" repeatCount="indefinite"/></circle></svg>') !important;
        background-repeat: no-repeat !important;
        background-position: right 35px center !important;
        background-size: 18px 18px !important;
        padding-right: 50px !important;
    }
</style>

<!-- Page Loading Overlay -->
<div class="page-loading-overlay" id="pageLoadingOverlay">
    <div class="loading-spinner-circle"></div>
    <div class="loading-text">Loading Transport Approval</div>
    <div class="loading-subtext">Please wait while we prepare your request...</div>
    <div class="loading-progress">
        <div class="loading-progress-bar"></div>
    </div>
</div>

<section role="main" class="content-body" style="background-color:#eef2f7;">
<br>
<div class="container py-4">
    <!-- PAGE TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa fa-file-alt me-2"></i> Transport Requisition Review
        </h2>
    </div>
    <br>
    <!-- CARD -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h4 class="fw-bold text-dark mb-3">
                <i class="fa fa-info-circle me-2"></i> Requisition Information
            </h4>
            <hr>
            <!-- GRID INFO -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Requisition No</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->requisition_number }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Requested By</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->requestedBy->name }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Department</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->department->department_name }}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Unit</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->unit->unit_name ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Number of Passengers</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->number_of_passenger }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Created Date</span>
                        <div class="fs-5 fw-bold text-dark">
                            {{ $requisition->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">From Location</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->from_location ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">To Location</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->to_location ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Pickup Location</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->pickup_location ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Passenger List -->
            <h4 class="fw-bold text-dark mt-5 mb-3">
                <i class="fa fa-users me-2"></i> Passenger List
            </h4>
            <table class="table table-bordered table-striped shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">SL</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requisition->passengers as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $p->employee->name }}</td>
                            <td>{{ $p->employee->designation }}</td>
                            <td>{{ $p->employee->department->department_name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr class="mt-4">
            <!-- Vehicle/Driver Assignment Section -->
            @include('admin.dashboard.approvals.transport.partials.assignment', ['requisition' => $requisition, 'vehicles' => $vehicles, 'drivers' => $drivers])
            <hr class="my-5">
            <!-- ACTION BUTTONS -->
            <form id="actionForm" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Remarks</label>
                    <textarea name="remarks" class="form-control form-control-lg" placeholder="Enter remarks before approval/rejection"></textarea>
                </div>
                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-success btn-lg px-4 fw-bold" onclick="submitAction('approve')">
                        <i class="fa fa-thumbs-up me-2"></i> Approve
                    </button>
                    <button type="button" class="btn btn-danger btn-lg px-4 fw-bold" onclick="submitAction('reject')">
                        <i class="fa fa-thumbs-down me-2"></i> Reject
                    </button>
                    <a href="{{ route('transport.approvals.index') }}" class="btn btn-secondary btn-lg px-4 fw-bold">
                        <i class="fa fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){
    var requisitionId = {{ $requisition->id }};

    // Hide page loading overlay when page is ready with smooth fade
    function hidePageLoading() {
        var $overlay = $('#pageLoadingOverlay');
        if ($overlay.length) {
            $overlay.addClass('fade-out');
            setTimeout(function() {
                $overlay.addClass('hidden');
            }, 500);
        }
    }

    // Show loading on a button
    function setButtonLoading(button, loading) {
        if (loading) {
            button.addClass('btn-loading').data('original-text', button.html()).html('<span class="visually-hidden">Loading...</span>');
        } else {
            button.removeClass('btn-loading').html(button.data('original-text'));
        }
    }

    // initialize select2 with custom template for availability icons
    // First destroy any existing Select2 initialization, then reinitialize with custom options
    function initSelect2() {
        var $vehicleSelect = $('#vehicleSelect');
        var $driverSelect = $('#driverSelect');
        
        // Add loading overlay to selection container
        function addLoadingOverlay($select) {
            if ($select.next('.select2-container').length && !$select.next('.select2-container').find('.loading-overlay').length) {
                $select.next('.select2-container').css('position', 'relative').append(
                    '<div class="loading-overlay" style="display:none;"><div class="loading-spinner"></div></div>'
                );
            }
        }
        
        addLoadingOverlay($vehicleSelect);
        addLoadingOverlay($driverSelect);
        
        // Destroy existing Select2 if already initialized
        if ($vehicleSelect.data('select2')) {
            try { $vehicleSelect.select2('destroy'); } catch(e) {}
        }
        if ($driverSelect.data('select2')) {
            try { $driverSelect.select2('destroy'); } catch(e) {}
        }
        
        // Reinitialize with custom options (without event handlers - they are attached separately)
        $vehicleSelect.select2({
            width: '100%',
            templateResult: function(opt) {
                if (!opt.id) return opt.text;
                var status = $(opt.element).data('status') || '';
                var isAvailable = status.toLowerCase() !== 'assigned';
                var icon = isAvailable ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>';
                var statusText = isAvailable ? 'Available' : 'Busy';
                var badgeClass = isAvailable ? 'bg-success' : 'bg-danger';
                
                var $el = $('<span>' + opt.text + ' </span>');
                $el.append('<span class="badge ' + badgeClass + '" style="margin-left:8px; font-size:11px;">' + icon + ' ' + statusText + '</span>');
                return $el;
            },
            templateSelection: function(opt) {
                if (!opt.id) return opt.text;
                var status = $(opt.element).data('status') || '';
                var isAvailable = status.toLowerCase() !== 'assigned';
                var icon = isAvailable ? '<i class="fa fa-check-circle me-1" style="color:#28a745;"></i>' : '<i class="fa fa-exclamation-circle me-1" style="color:#dc3545;"></i>';
                return $('<span>' + icon + opt.text + '</span>');
            },
            escapeMarkup: function(m) { return m; }
        });
        
        $driverSelect.select2({
            width: '100%',
            templateResult: function(opt) {
                if (!opt.id) return opt.text;
                var status = $(opt.element).data('status') || '';
                var isAvailable = status.toLowerCase() !== 'assigned';
                var icon = isAvailable ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>';
                var statusText = isAvailable ? 'Available' : 'Busy';
                var badgeClass = isAvailable ? 'bg-success' : 'bg-danger';
                
                var $el = $('<span>' + opt.text + ' </span>');
                $el.append('<span class="badge ' + badgeClass + '" style="margin-left:8px; font-size:11px;">' + icon + ' ' + statusText + '</span>');
                return $el;
            },
            templateSelection: function(opt) {
                if (!opt.id) return opt.text;
                var status = $(opt.element).data('status') || '';
                var isAvailable = status.toLowerCase() !== 'assigned';
                var icon = isAvailable ? '<i class="fa fa-check-circle me-1" style="color:#28a745;"></i>' : '<i class="fa fa-exclamation-circle me-1" style="color:#dc3545;"></i>';
                return $('<span>' + icon + opt.text + '</span>');
            },
            escapeMarkup: function(m) { return m; }
        });
    }

    // Initialize Select2 on page load
    initSelect2();
    
    // Ensure pre-selected values are displayed properly
    setTimeout(function() {
        // Get assigned values from requisition
        var assignedVehicleId = '{{ $requisition->assigned_vehicle_id ?? "" }}';
        var assignedDriverId = '{{ $requisition->assigned_driver_id ?? "" }}';
        
        // If vehicle select doesn't have a value but we have an assigned vehicle, set it
        if ((!$('#vehicleSelect').val() || $('#vehicleSelect').val() === '') && assignedVehicleId) {
            $('#vehicleSelect').val(assignedVehicleId).trigger('change');
        }
        
        // If driver select doesn't have a value but we have an assigned driver, set it
        if ((!$('#driverSelect').val() || $('#driverSelect').val() === '') && assignedDriverId) {
            $('#driverSelect').val(assignedDriverId).trigger('change');
        }
        
        // Trigger change to ensure select2 displays the selected values
        $('#vehicleSelect').trigger('change.select2');
        $('#driverSelect').trigger('change.select2');
        $('#transportTypeSelect').trigger('change.select2');
        
        // Update displays for pre-selected values
        updateStatusDisplays();
        updateSummary();
    }, 100);
    
    // Hide page loading after Select2 is initialized
    setTimeout(hidePageLoading, 500);
    
    // Add loading effects to select2 dropdowns (after small delay to ensure master layout init is complete)
    setTimeout(function() {
        // For master layout's Select2, we need to add loading effect using click/focus events
        $('#vehicleSelect, #driverSelect').on('focus mousedown', function() {
            var $container = $(this).next('.select2-container');
            if ($container.length) {
                $container.find('.select2-selection').addClass('select-loading');
                // Add loading indicator to dropdown when it opens
                var $dropdown = $('.select2-dropdown');
                if ($dropdown.length && !$dropdown.find('.select-loading-indicator').length) {
                    $dropdown.prepend('<div class="select-loading-indicator" style="padding:15px;text-align:center;background:#f8f9fa;border-bottom:1px solid #dee2e6;"><i class="fa fa-spinner fa-spin" style="color:#0088cc;font-size:18px;"></i><br><span style="color:#0088cc;font-weight:600;">Loading options...</span></div>');
                }
            }
        });
        
        // Remove loading state when selection is made or dropdown closes
        $('#vehicleSelect, #driverSelect').on('change select2:close', function() {
            $(this).next('.select2-container').find('.select2-selection').removeClass('select-loading');
            $('.select-loading-indicator').remove();
        });
        
        // Also remove on blur
        $('#vehicleSelect, #driverSelect').on('blur', function() {
            var self = this;
            setTimeout(function() {
                $(self).next('.select2-container').find('.select2-selection').removeClass('select-loading');
            }, 200);
        });
    }, 1500);

    // Helper function to update driver availability indicator
    function updateDriverAvailabilityIndicator() {
        var selectedDriver = $('#driverSelect option:selected');
        var status = selectedDriver.data('status') || '';
        var isAvailable = status.toLowerCase() !== 'assigned';
        
        if (!selectedDriver.val()) {
            $('#driverAvailabilityIndicator').html('');
            return;
        }
        
        var icon = isAvailable 
            ? '<i class="fa fa-check-circle icon"></i> Available' 
            : '<i class="fa fa-times-circle icon"></i> Busy/Assigned';
        var statusClass = isAvailable ? 'available' : 'busy';
        
        $('#driverAvailabilityIndicator').html(
            '<div class="driver-indicator ' + statusClass + '">' + icon + '</div>'
        );
    }

    // helper: update small badges/text below selects
    function updateStatusDisplays() {
        let vStatus = $('#vehicleSelect option:selected').data('status') || '';
        let dStatus = $('#driverSelect option:selected').data('status') || '';

        if (!vStatus) $('#vehicleStatus').html('');
        else if (vStatus.toLowerCase() === 'assigned') {
            $('#vehicleStatus').html('<span class="text-danger"><i class="fa fa-times-circle"></i> Vehicle already assigned</span>');
        } else {
            $('#vehicleStatus').html('<span class="text-success"><i class="fa fa-check-circle"></i> Vehicle available</span>');
        }

        if (!dStatus) $('#driverStatus').html('');
        else if (dStatus.toLowerCase() === 'assigned') {
            $('#driverStatus').html('<span class="text-danger"><i class="fa fa-times-circle"></i> Driver already assigned</span>');
        } else {
            $('#driverStatus').html('<span class="text-success"><i class="fa fa-check-circle"></i> Driver available</span>');
        }
        
        updateDriverAvailabilityIndicator();
    }

    // show assignment summary
    function updateSummary() {
        let vText = $('#vehicleSelect option:selected').text();
        let dText = $('#driverSelect option:selected').text();
        let departure = $('#estimatedDeparture').val();

        vText = vText ? vText.replace(/<span[^>]*>.*?<\/span>/g, '').replace(/\s+—\s+(Available|Unavailable)/g, '') : '';
        dText = dText ? dText.replace(/<span[^>]*>.*?<\/span>/g, '').replace(/\s+—\s+(Available|Unavailable)/g, '') : '';

        if ((vText && vText.trim() !== '-- Select Vehicle --') || (dText && dText.trim() !== '-- Select Driver --') || departure) {
            $('#assignmentSummary').show();
            $('#summaryVehicle').text(vText.trim() || '—');
            $('#summaryDriver').text(dText.trim() || '—');
            $('#summaryDeparture').text(departure ? formatDateTime(departure) : '—');
        } else {
            $('#assignmentSummary').hide();
        }
    }

    // Format datetime for display
    function formatDateTime(datetimeStr) {
        if (!datetimeStr) return '—';
        let date = new Date(datetimeStr);
        return date.toLocaleString('en-BD', { 
            day: '2-digit', month: 'short', year: 'numeric', 
            hour: '2-digit', minute: '2-digit', hour12: true 
        });
    }

    // ============================================================
    // COMPREHENSIVE VEHICLE SELECTION HANDLER
    // ============================================================
    
    // Vehicle Selection Handler Configuration
    var VehicleSelectionHandler = {
        // Get required passenger count
        getRequiredCapacity: function() {
            return {{ $requisition->number_of_passenger ?? 0 }};
        },
        
        // Show loading state on vehicle select
        showVehicleLoading: function() {
            var $select = $('#vehicleSelect');
            var $container = $select.next('.select2-container');
            if ($container.length) {
                $container.find('.select2-selection').addClass('select-loading');
            }
            // Show loading in status area
            $('#vehicleStatus').html('<span class="text-muted"><i class="fa fa-spinner fa-spin"></i> Loading vehicles...</span>');
        },
        
        // Hide loading state
        hideVehicleLoading: function() {
            var $select = $('#vehicleSelect');
            var $container = $select.next('.select2-container');
            if ($container.length) {
                $container.find('.select2-selection').removeClass('select-loading');
            }
        },
        
        // Filter vehicles by transport type
        filterVehiclesByType: function(transportTypeId) {
            var $select = $('#vehicleSelect');
            var requiredCapacity = this.getRequiredCapacity();
            var preSelectedVehicleId = $select.val();
            var assignedVehicleId = '{{ $requisition->assigned_vehicle_id ?? "" }}';
            
            if (!transportTypeId || transportTypeId === 'all') {
                // Show all options
                $select.find('option').not(':first').each(function() {
                    var capacity = parseInt($(this).data('capacity')) || 0;
                    var status = $(this).data('status') || '';
                    var isAvailable = status.toLowerCase() !== 'assigned';
                    var thisVehicleId = $(this).val();
                    
                    // Always show if it's the assigned vehicle for this requisition
                    var isAssignedVehicle = String(thisVehicleId) === String(assignedVehicleId);
                    
                    // Show if available, has sufficient capacity, or is the assigned vehicle
                    if (isAssignedVehicle || (isAvailable && capacity >= requiredCapacity)) {
                        $(this).show();
                    } else if (isAvailable) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('#transportTypeStatus').html('');
            } else {
                // Filter by transport type
                $select.find('option').not(':first').each(function() {
                    var vehicleTypeId = $(this).data('transport-type') || '';
                    var capacity = parseInt($(this).data('capacity')) || 0;
                    var status = $(this).data('status') || '';
                    var isAvailable = status.toLowerCase() !== 'assigned';
                    var thisVehicleId = $(this).val();
                    
                    // Always show if it's the assigned vehicle for this requisition
                    var isAssignedVehicle = String(thisVehicleId) === String(assignedVehicleId);
                    
                    if (isAssignedVehicle) {
                        $(this).show();
                    } else if (String(vehicleTypeId) === String(transportTypeId) && isAvailable) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('#transportTypeStatus').html('<span class="text-info"><i class="fa fa-filter"></i> Filtered by transport type</span>');
            }
            
            // Refresh select2 to reflect changes
            $select.trigger('change.select2');
        },
        
        // Filter vehicles by capacity
        filterVehiclesByCapacity: function() {
            var $select = $('#vehicleSelect');
            var requiredCapacity = this.getRequiredCapacity();
            var preSelectedVehicleId = $select.val();
            var assignedVehicleId = '{{ $requisition->assigned_vehicle_id ?? "" }}';
            
            $select.find('option').not(':first').each(function() {
                var capacity = parseInt($(this).data('capacity')) || 0;
                var status = $(this).data('status') || '';
                var isAvailable = status.toLowerCase() !== 'assigned';
                var thisVehicleId = $(this).val();
                
                // Always show if it's the assigned vehicle for this requisition
                var isAssignedVehicle = String(thisVehicleId) === String(assignedVehicleId);
                
                if (isAssignedVehicle) {
                    $(this).show();
                } else if (isAvailable) {
                    if (capacity >= requiredCapacity) {
                        $(this).show();
                    } else {
                        // Show but mark as insufficient
                        $(this).show();
                    }
                } else {
                    $(this).hide();
                }
            });
        },
        
        // Filter vehicles by availability status
        filterVehiclesByAvailability: function() {
            var $select = $('#vehicleSelect');
            var preSelectedVehicleId = $select.val();
            var assignedVehicleId = '{{ $requisition->assigned_vehicle_id ?? "" }}';
            
            $select.find('option').not(':first').each(function() {
                var status = $(this).data('status') || '';
                var isAvailable = status.toLowerCase() !== 'assigned';
                var thisVehicleId = $(this).val();
                
                // Always show if it's the assigned vehicle for this requisition
                var isAssignedVehicle = String(thisVehicleId) === String(assignedVehicleId);
                
                if (isAssignedVehicle) {
                    $(this).prop('disabled', false);
                } else if (!isAvailable) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
            
            $select.trigger('change.select2');
        },
        
        // Update vehicle capacity info display
        updateCapacityInfo: function() {
            var $selected = $('#vehicleSelect option:selected');
            var capacity = parseInt($selected.data('capacity')) || 0;
            var requiredCapacity = this.getRequiredCapacity();
            var passengerCount = {{ $requisition->number_of_passenger ?? 0 }};
            
            if (capacity > 0) {
                var diff = capacity - passengerCount;
                var statusClass = diff >= 0 ? 'text-success' : 'text-danger';
                var statusIcon = diff >= 0 ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-exclamation-circle"></i>';
                var statusText = diff >= 0 ? 
                    'Sufficient capacity (' + diff + ' extra seats)' : 
                    'Insufficient capacity (' + Math.abs(diff) + ' seats short)';
                
                $('#vehicleCapacityInfo').html(
                    '<span class="' + statusClass + '">' + statusIcon + ' ' + statusText + '</span> | ' +
                    '<span class="text-muted">Total capacity: ' + capacity + ' seats</span>'
                );
            } else {
                $('#vehicleCapacityInfo').html('');
            }
        },
        
        // Update driver suggestions based on selected vehicle
        updateDriverSuggestions: function(vehicleId) {
            var $driverSelect = $('#driverSelect');
            var requisitionId = {{ $requisition->id }};
            var assignedDriverId = '{{ $requisition->assigned_driver_id ?? "" }}';
            
            // Show loading state
            $driverSelect.next('.select2-container').find('.select2-selection').addClass('select-loading');
            $('#driverStatus').html('<span class="text-muted"><i class="fa fa-spinner fa-spin"></i> Loading drivers...</span>');
            
            // Call API to get drivers for the selected vehicle
            $.get("{{ route('transport.approvals.drivers-for-vehicle', ['id' => $requisition->id, 'vehicleId' => '__VEHICLE_ID__']) }}".replace('__VEHICLE_ID__', vehicleId))
                .done(function(response) {
                    var availableDrivers = response.drivers || [];
                    var driverIds = availableDrivers.map(function(d) { return d.id; });
                    
                    // Show all drivers but highlight available ones
                    $driverSelect.find('option').not(':first').each(function() {
                        var driverId = $(this).val();
                        var status = $(this).data('status') || '';
                        var isAvailable = status.toLowerCase() !== 'assigned';
                        
                        // Always show if it's the assigned driver for this requisition
                        var isAssignedDriver = String(driverId) === String(assignedDriverId);
                        
                        if (isAssignedDriver) {
                            $(this).show();
                            $(this).data('available', true);
                        } else if (driverIds.indexOf(parseInt(driverId)) !== -1 && isAvailable) {
                            $(this).show();
                            $(this).data('available', true);
                        } else if (isAvailable) {
                            // Also show other available drivers
                            $(this).show();
                            $(this).data('available', true);
                        } else {
                            $(this).hide();
                            $(this).data('available', false);
                        }
                    });
                    
                    // Remove loading state
                    $driverSelect.next('.select2-container').find('.select2-selection').removeClass('select-loading');
                    $('#driverStatus').html('<span class="text-success"><i class="fa fa-check-circle"></i> ' + availableDrivers.length + ' driver(s) available</span>');
                    
                    $driverSelect.trigger('change.select2');
                })
                .fail(function() {
                    // Fallback: just show all available drivers
                    var assignedDriverId = '{{ $requisition->assigned_driver_id ?? "" }}';
                    $driverSelect.find('option').not(':first').each(function() {
                        var driverId = $(this).val();
                        var status = $(this).data('status') || '';
                        var isAvailable = status.toLowerCase() !== 'assigned';
                        
                        // Always show if it's the assigned driver for this requisition
                        var isAssignedDriver = String(driverId) === String(assignedDriverId);
                        
                        if (isAssignedDriver || isAvailable) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                    
                    $driverSelect.next('.select2-container').find('.select2-selection').removeClass('select-loading');
                    $('#driverStatus').html('<span class="text-warning"><i class="fa fa-exclamation-circle"></i> Using all available drivers</span>');
                    $driverSelect.trigger('change.select2');
                });
        },
        
        // Handle vehicle selection change
        onVehicleChange: function(vehicleId) {
            var $selected = $('#vehicleSelect option:selected');
            var status = $selected.data('status') || '';
            var capacity = parseInt($selected.data('capacity')) || 0;
            var vehicleName = $selected.text().replace(/<span[^>]*>.*?<\/span>/g, '').trim();
            
            // Validate availability
            if (status.toLowerCase() === 'assigned' && vehicleId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Vehicle Unavailable',
                    text: 'Selected vehicle is currently assigned. Please choose another vehicle.',
                    confirmButtonText: 'OK'
                });
                $('#vehicleSelect').val(null).trigger('change');
                return false;
            }
            
            // Validate capacity
            var passengerCount = this.getRequiredCapacity();
            if (capacity > 0 && capacity < passengerCount) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Insufficient Capacity',
                    text: 'This vehicle has ' + capacity + ' seats but ' + passengerCount + ' passengers need transport. Please select a vehicle with sufficient capacity.',
                    confirmButtonText: 'OK'
                });
            }
            
            // Update capacity info
            this.updateCapacityInfo();
            
            // Update driver suggestions
            this.updateDriverSuggestions(vehicleId);
            
            // Update status displays
            updateStatusDisplays();
            
            // Update summary
            updateSummary();
            
            // Trigger vehicle change event for other handlers
            $(document).trigger('vehicle:selected', [vehicleId, {
                name: vehicleName,
                capacity: capacity,
                status: status
            }]);
            
            return true;
        },
        
        // Initialize transport type select
        initTransportTypeSelect: function() {
            var $transportTypeSelect = $('#transportTypeSelect');
            if (!$transportTypeSelect.length) return;
            
            var handler = this;
            
            $transportTypeSelect.on('change', function(e) {
                var transportTypeId = $(this).val();
                handler.showVehicleLoading();
                
                // Simulate loading delay for visual feedback
                setTimeout(function() {
                    handler.filterVehiclesByType(transportTypeId);
                    handler.hideVehicleLoading();
                    
                    // Reset vehicle selection if current selection is hidden
                    var $selected = $('#vehicleSelect option:selected');
                    if ($selected.length && !$selected.is(':visible')) {
                        $('#vehicleSelect').val(null).trigger('change');
                    }
                }, 300);
            });
            
            // Show vehicles based on pre-selected transport type (if any)
            var preSelectedType = $transportTypeSelect.val();
            if (preSelectedType && preSelectedType !== '') {
                handler.filterVehiclesByType(preSelectedType);
            } else {
                handler.filterVehiclesByType('all');
            }
        },
        
        // Initialize vehicle select with event handlers
        initVehicleSelect: function() {
            var handler = this;
            var $vehicleSelect = $('#vehicleSelect');
            
            // Handle vehicle selection
            $(document).on('select2:select', '#vehicleSelect', function(e) {
                handler.onVehicleChange($(this).val());
            });
            
            // Handle vehicle clear
            $(document).on('select2:clear', '#vehicleSelect', function() {
                handler.updateCapacityInfo();
                updateStatusDisplays();
                updateSummary();
                $(document).trigger('vehicle:cleared');
            });
            
            // Handle capacity info on change
            $vehicleSelect.on('change', function() {
                handler.updateCapacityInfo();
            });
            
            // Initialize capacity info and driver suggestions for pre-selected vehicle
            if ($vehicleSelect.val()) {
                handler.updateCapacityInfo();
                handler.updateDriverSuggestions($vehicleSelect.val());
            }
        },
        
        // Initialize driver select with vehicle-aware logic
        initDriverSelect: function() {
            // When driver is selected, update summary
            $(document).on('select2:select', '#driverSelect', function(e) {
                var status = $(this).find(':selected').data('status') || '';
                if (status.toLowerCase() === 'assigned' && $(this).val() !== '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Driver Unavailable',
                        text: 'Selected driver is currently assigned. Please choose another driver.',
                        confirmButtonText: 'OK'
                    });
                    $(this).val(null).trigger('change');
                    return;
                }
                updateStatusDisplays();
                updateSummary();
                
                // Trigger driver selected event
                $(document).trigger('driver:selected', [$(this).val()]);
            });
            
            // Handle driver clear
            $(document).on('select2:clear', '#driverSelect', function() {
                updateStatusDisplays();
                updateSummary();
                $(document).trigger('driver:cleared');
            });
        },
        
        // Initialize estimated departure time handler
        initDepartureTimeHandler: function() {
            $('#estimatedDeparture').on('change', function() {
                updateSummary();
            });
        },
        
        // Initialize all handlers
        init: function() {
            console.log('Initializing Vehicle Selection Handler...');
            
            // Initialize all components
            this.initTransportTypeSelect();
            this.initVehicleSelect();
            this.initDriverSelect();
            this.initDepartureTimeHandler();
            
            // Filter by capacity initially
            this.filterVehiclesByCapacity();
            this.filterVehiclesByAvailability();
            
            console.log('Vehicle Selection Handler initialized successfully');
        }
    };
    
    // Initialize vehicle selection handler
    VehicleSelectionHandler.init();
    
    // ============================================================
    // END VEHICLE SELECTION HANDLER
    // ============================================================

    // Use select2:select event since select2 intercepts the native change event
    $(document).on('select2:select', '#vehicleSelect', function(e){
        console.log('Vehicle select triggered via select2, value:', $(this).val());
        let status = $(this).find(':selected').data('status') || '';
        if (status.toLowerCase() === 'assigned' && $(this).val() !== '') {
            Swal.fire({
                icon: 'warning',
                title: 'Vehicle Unavailable',
                text: 'Selected vehicle is currently assigned. Please choose another vehicle.',
                confirmButtonText: 'OK'
            });
            $(this).val(null).trigger('change');
        }
        
        // Show driver status when vehicle is selected
        updateStatusDisplays();
        updateSummary();
    });

    $(document).on('select2:select', '#driverSelect', function(e){
        console.log('Driver select triggered via select2, value:', $(this).val());
        let status = $(this).find(':selected').data('status') || '';
        if (status.toLowerCase() === 'assigned' && $(this).val() !== '') {
            Swal.fire({
                icon: 'warning',
                title: 'Driver Unavailable',
                text: 'Selected driver is currently assigned. Please choose another driver.',
                confirmButtonText: 'OK'
            });
            $(this).val(null).trigger('change');
        }
        updateStatusDisplays();
        updateSummary();
    });

    $(document).on('select2:clear', '#vehicleSelect', function(){
        console.log('Vehicle select cleared');
        updateStatusDisplays();
        updateSummary();
    });

    // run initial update
    updateStatusDisplays();
    updateSummary();

    // Live refresh: poll availability endpoint every 10 seconds with loading indicator
    function refreshAvailability() {
        // Show loading indicator on status displays
        $('#vehicleStatus').html('<span class="text-muted"><i class="fa fa-spinner fa-spin"></i> Refreshing...</span>');
        $('#driverStatus').html('<span class="text-muted"><i class="fa fa-spinner fa-spin"></i> Refreshing...</span>');
        
        $.get("{{ route('transport.approvals.availability', $requisition->id) }}")
            .done(function(res){
                if (!res) return;

                if (res.vehicles && Array.isArray(res.vehicles)) {
                    res.vehicles.forEach(function(v){
                        let opt = $('#vehicleSelect option[value="'+v.id+'"]');
                        if (opt.length) {
                            opt.data('status', v.availability_status);
                            if (String(v.availability_status).toLowerCase() === 'assigned') {
                                opt.prop('disabled', true);
                            } else {
                                opt.prop('disabled', false);
                            }
                        }
                    });
                }

                if (res.drivers && Array.isArray(res.drivers)) {
                    res.drivers.forEach(function(d){
                        let opt = $('#driverSelect option[value="'+d.id+'"]');
                        if (opt.length) {
                            opt.data('status', d.availability_status);
                            if (String(d.availability_status).toLowerCase() === 'assigned') {
                                opt.prop('disabled', true);
                            } else {
                                opt.prop('disabled', false);
                            }
                        }
                    });
                }

                // Refresh select2 dropdown to show updated status
                $('#vehicleSelect, #driverSelect').trigger('change.select2');
                updateStatusDisplays();
                updateSummary();
            })
            .fail(function(){
                console.warn('Failed to refresh availability');
                updateStatusDisplays(); // Reset to current status
            });
    }

    var availabilityInterval = setInterval(refreshAvailability, 10000);
    refreshAvailability();

    $(window).on('beforeunload', function(){ clearInterval(availabilityInterval); });
});
</script>

<script>
// SweetAlert Popup
function alertBox(type, message, title = ''){
    Swal.fire({
        icon: type,
        title: title || (type === 'success' ? 'Success!' : (type === 'error' ? 'Error!' : (type === 'warning' ? 'Warning!' : ''))),
        text: message,
        confirmButtonText: 'OK'
    });
}

// Assign Vehicle & Driver with loading effect and SweetAlert confirmation
function submitAssign() {
    // DEBUG: Log form data
    console.log('[DEBUG] Form serialize:', $('#assignForm').serialize());
    console.log('[DEBUG] Vehicle value:', $('#vehicleSelect').val());
    console.log('[DEBUG] Driver value:', $('#driverSelect').val());
    console.log('[DEBUG] Transport type:', $('#transportTypeSelect').val());
    
    let transportTypeId = $('#transportTypeSelect').val();
    let vehicleId = $('#vehicleSelect').val();
    let driverId = $('#driverSelect').val();
    let driverName = $('#driverSelect option:selected').text();
    let vehicleName = $('#vehicleSelect option:selected').text();
    
    if (!transportTypeId) {
        Swal.fire({
            icon: 'warning',
            title: 'Transport Type Required',
            text: 'Please select a Transport Type before assigning vehicle and driver.',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    if (!vehicleId || !driverId) {
        Swal.fire({
            icon: 'warning',
            title: 'Selection Required',
            text: 'Please select both vehicle and driver.',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // SweetAlert confirmation for driver assignment
    Swal.fire({
        title: 'Assign Driver',
        html: `<p>Are you sure you want to assign this driver?</p>
               <div class="text-start mt-3 p-3 bg-light rounded">
                   <strong><i class="fa fa-car me-1"></i> Vehicle:</strong> ${vehicleName}<br>
                   <strong><i class="fa fa-user me-1"></i> Driver:</strong> ${driverName}
               </div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-check me-1"></i> Yes, Assign',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            performDriverAssignment();
        }
    });
}

function performDriverAssignment() {
    var $btn = $('#actionForm button[type="submit"]');
    var originalText = $btn.html();
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Assigning...');

    $.ajax({
        url: "{{ route('transport.approvals.assign', $requisition->id) }}",
        type: 'POST',
        data: $('#actionForm').serialize(),
        success: function(res) {
            let driverName = $('#driverSelect option:selected').text();
            let vehicleName = $('#vehicleSelect option:selected').text();
            Swal.fire({
                icon: 'success',
                title: 'Driver Assigned!',
                html: `<div class="text-start">
                    <p class="mb-2">${res.message}</p>
                    <div class="p-3 bg-light rounded mt-2">
                        <strong><i class="fa fa-user me-1"></i> Driver:</strong> ${driverName}<br>
                        <strong><i class="fa fa-car me-1"></i> Vehicle:</strong> ${vehicleName}
                    </div>
                </div>`,
                confirmButtonText: 'OK'
            });
            setTimeout(() => location.reload(), 1500);
        },
        error: function(xhr) {
            $btn.prop('disabled', false).html(originalText);
            if (xhr.status === 422) {
                if (xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let firstError = Object.values(errors)[0][0];
                    Swal.fire({
                        icon: 'error',
                        title: 'Assignment Failed',
                        text: firstError,
                        confirmButtonText: 'OK'
                    });
                }
                else if (xhr.responseJSON.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Assignment Failed',
                        text: xhr.responseJSON.message,
                        confirmButtonText: 'OK'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Assignment failed. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        }
    });
}

// Approve or Reject
function submitAction(type){
    // Check server assigned values (read from data attributes on the form)
    let assignedVehicleId = $('#actionForm').data('assigned-vehicle') || '';
    let assignedDriverId = $('#actionForm').data('assigned-driver') || '';
    
    console.log('[DEBUG] Assigned Vehicle ID:', assignedVehicleId);
    console.log('[DEBUG] Assigned Driver ID:', assignedDriverId);
    
    let remarks = $('textarea[name="remarks"]').val().trim();
    
    if(type === 'reject' && !remarks){
        alertBox('error', 'Remarks are required for rejection.');
        return;
    }
    
    if(type === 'approve') {
        // Validate Transport Type
        let transportTypeId = $('#transportTypeSelect').val();
      
        if (!transportTypeId) {
            alertBox('warning', 'Please select a Transport Type before proceeding.', 'Transport Type Required');
            return;
        }
        
        let vehicleId = $('#vehicleSelect').val();
        let driverId = $('#driverSelect').val();
        
        alert('vehicleId=' + vehicleId + ', driverId=' + driverId);
        
        // If dropdowns are empty but we have assigned values from server, use those
        if ((!vehicleId || !driverId) && assignedVehicleId && assignedDriverId) {
            console.log('[DEBUG] Using server-assigned values');
            vehicleId = assignedVehicleId;
            driverId = assignedDriverId;
        }
        
        if (!vehicleId || !driverId) {
            alertBox('warning', 'Please assign both a vehicle and driver before approving.', 'Assignment Required');
            return;
        }
        
        Swal.fire({
            icon: 'question',
            title: 'Confirm Approval',
            text: 'Are you sure you want to approve this requisition with the selected vehicle and driver?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                performApproval(remarks);
            }
        });
        return;
    }
    
    performApproval(remarks);
}

function performApproval(remarks) {
    let url = "{{ route('transport.approvals.approve', $requisition->id) }}";
    
    // Show loading on approve button
    var $btn = $('.btn-success');
    var originalText = $btn.html();
    $btn.prop('disabled', true).addClass('btn-loading').html('<span class="visually-hidden">Loading...</span>');

    $.post(url, $('#actionForm').serialize(), function(res){
        alertBox('success', res.message, 'Success!');
        setTimeout(()=>window.location.href="{{ route('transport.approvals.index') }}", 1500);
    }).fail(function(xhr){
        $btn.prop('disabled', false).removeClass('btn-loading').html(originalText);
        let msg = xhr.responseJSON?.message || 'Action failed.';
        alertBox('error', msg);
    });
}
</script>
@endsection
