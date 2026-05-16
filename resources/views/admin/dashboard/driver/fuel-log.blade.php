@extends('admin.dashboard.master')
@section('main_content')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #4338ca;
        --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    body { font-family: 'Inter', sans-serif; }
    
      .page-header {
    background: #fff;
    padding: 0 25px;
    border-bottom: 1px solid var(--border-color);
    /* margin-bottom: 20px; */
    background-color:#000
}
    
    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .right-wrapper {
        color: white;
    }
    
    .breadcrumbs {
        color: rgba(255,255,255,0.9);
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 5px;
    }
    
    .breadcrumbs li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumbs li + li::before {
        content: "/";
        margin: 0 8px;
        opacity: 0.7;
    }
    
    .breadcrumbs a {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        transition: opacity 0.3s ease;
    }
    
    .breadcrumbs a:hover {
        opacity: 1;
    }
    
    .breadcrumbs span {
        color: rgba(255,255,255,0.7);
    }
    
    .card-premium {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .card-premium .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .card-premium .card-body {
        padding: 25px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #4a5568;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-control.is-invalid {
        border-color: #ef4444;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }
    
    .form-control.is-invalid + .invalid-feedback {
        display: block;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Premium Form Styling */
    .form-control {
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        background: #fff;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }
    
    .form-control.select2-container {
        padding: 0;
        border: none;
    }
    
    .select2-container--classic .select2-selection--single {
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        height: 46px;
    }
    
    .select2-container--classic .select2-selection--single:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }
    
    .select2-container--classic .select2-selection--single .select2-selection__rendered {
        line-height: 44px;
        padding-left: 12px;
    }
    
    .select2-container--classic .select2-selection--single .select2-selection__arrow {
        height: 44px;
    }
    
    /* Premium Select Dropdown */
    .select2-dropdown {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    
    .select2-results__option {
        padding: 12px 16px;
        transition: background 0.2s;
    }
    
    .select2-results__option--highlighted {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%) !important;
        color: white;
    }
    
    /* Premium Input with Icons */
    .input-icon-wrapper {
        position: relative;
    }
    
    .input-icon-wrapper .form-control {
        padding-left: 40px;
    }
    
    .input-icon-wrapper .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    
    /* Premium Labels */
    .form-group label {
        color: #374151;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    /* File Upload Premium */
    .file-upload-wrapper {
        position: relative;
    }
    
    .file-upload-wrapper input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-upload-preview {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .file-upload-preview:hover {
        border-color: #6366f1;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
    }
    
    .file-upload-preview i {
        font-size: 32px;
        color: #6366f1;
        margin-bottom: 8px;
    }
    
    .btn-primary .spinner-border {
        display: none;
        width: 16px;
        height: 16px;
        border-width: 2px;
        margin-right: 8px;
    }
    
    .btn-primary.loading .spinner-border {
        display: inline-block;
    }
    
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .table-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .table-card .card-body {
        padding: 0;
    }
    
    .table {
        margin: 0;
    }
    
    .table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #4a5568;
        font-weight: 600;
        padding: 15px;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    
    .table tbody td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        color: #4a5568;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-success {
        background: #10b981;
        color: white;
    }
    
    .badge-primary {
        background: #6366f1;
        color: white;
    }
    
    .alert-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 20px 25px;
        font-size: 15px;
    }
    
    .alert-custom {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert-custom.success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }
    
    .alert-custom.warning {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #f59e0b;
    }
    
    .alert-custom.error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }
    
    .fuel-table-empty td {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }
    
    .previous-data-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #0ea5e9;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }
    
    .previous-data-card h4 {
        color: #0369a1;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .previous-data-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }
    
    .previous-data-item {
        text-align: center;
    }
    
    .previous-data-item .label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }
    
    .previous-data-item .value {
        font-size: 18px;
        font-weight: 700;
        color: #0369a1;
    }
    
    .previous-data-item .value.warning {
        color: #f59e0b;
    }
    
    .previous-data-item .value.danger {
        color: #ef4444;
    }
    
    .calculated-info {
        background: #f0fdf4;
        border: 1px solid #22c55e;
        border-radius: 8px;
        padding: 10px 15px;
        margin-top: 10px;
    }
    
    .calculated-info .row {
        display: flex;
        justify-content: space-around;
    }
    
    .calculated-info .item {
        text-align: center;
    }
    
    .calculated-info .item .label {
        font-size: 11px;
        color: #64748b;
    }
    
    .calculated-info .item .value {
        font-size: 16px;
        font-weight: 700;
        color: #15803d;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2><i class="fa fa-gas-pump mr-2"></i>Fuel Log</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Driver Portal</span></li>
                <li><span>Fuel Log</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Success/Error Message Container -->
                <div id="alertContainer"></div>
                
                <!-- Previous Data Intelligence -->
                <div id="previousDataSection" class="previous-data-card" style="display: none;">
                    <h4><i class="fa fa-info-circle"></i> Previous Fuel Data for Selected Vehicle</h4>
                    <div class="previous-data-grid">
                        <div class="previous-data-item">
                            <div class="label">Last Odometer</div>
                            <div class="value" id="prevOdometer">-</div>
                        </div>
                        <div class="previous-data-item">
                            <div class="label">Last Fuel Date</div>
                            <div class="value" id="prevFuelDate">-</div>
                        </div>
                        <div class="previous-data-item">
                            <div class="label">Last Quantity</div>
                            <div class="value" id="prevQuantity">-</div>
                        </div>
                        <div class="previous-data-item">
                            <div class="label">Last Mileage</div>
                            <div class="value" id="prevMileage">-</div>
                        </div>
                    </div>
                </div>
                
                @if(isset($vehicles) && $vehicles->count() > 0)
                <div class="card-premium">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-plus-circle mr-2"></i>Add New Fuel Entry</h3>
                    </div>
                    <div class="card-body">
                        <form id="fuelLogForm" action="{{ route('driver.fuel.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Vehicle <span class="text-danger">*</span></label>
                                        <select name="vehicle_id" id="vehicle_id" class="form-control" required>
                                            <option value="">-- Select Vehicle --</option>
                                            <option value="">-- Select Vehicle --</option>
                                            @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_name }} ({{ $vehicle->vehicle_number }})</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a vehicle</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Fuel Date <span class="text-danger">*</span></label>
                                        <input type="date" name="fuel_date" id="fuel_date" class="form-control" value="{{ date('Y-m-d') }}">
                                        <div class="invalid-feedback">Please select a valid date</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Fuel Quantity (Liters) <span class="text-danger">*</span></label>
                                        <input type="number" name="fuel_quantity" id="fuel_quantity" class="form-control" step="0.01" min="0" placeholder="Enter fuel quantity">
                                        <div class="invalid-feedback">Please enter fuel quantity</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cost (BDT) <span class="text-danger">*</span></label>
                                        <input type="number" name="fuel_cost" id="fuel_cost" class="form-control" step="0.01" min="0" placeholder="Enter total cost">
                                        <div class="invalid-feedback">Please enter fuel cost</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Odometer Reading (km) <span class="text-danger">*</span></label>
                                        <input type="number" name="odometer_reading" id="odometer_reading" class="form-control" step="0.01" min="0" placeholder="Enter odometer reading">
                                        <div class="invalid-feedback">Please enter odometer reading</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fuel Type <span class="text-danger">*</span></label>
                                        <select name="fuel_type" id="fuel_type" class="form-control">
                                            <option value="Petrol">Petrol</option>
                                            <option value="Diesel">Diesel</option>
                                            <option value="Octane">Octane</option>
                                            <option value="CNG">CNG</option>
                                            <option value="EV">EV Charging</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fuel Station <span class="text-danger">*</span></label>
                                        <input type="text" name="fuel_station" id="fuel_station" class="form-control" placeholder="Enter fuel station name">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Receipt Image (Bill)</label>
                                        <input type="file" name="receipt_image" id="receipt_image" class="form-control" accept="image/*">
                                        <small class="text-muted">jpg, png only</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn-primary" id="submitBtn">
                                        <span class="spinner-border spinner-border-sm"></span>
                                        <i class="fa fa-save mr-2"></i>Save Entry
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="card-premium">
                    <div class="card-body">
                        <div class="alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            No vehicles assigned to you. Please contact your administrator.
                        </div>
                    </div>
                </div>
                @endif
                
                @if(isset($fuelLogs) && $fuelLogs->count() > 0)
                <div class="table-card mt-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-history mr-2"></i>Fuel Log History</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Fuel Type</th>
                                    <th>Vehicle</th>
                                    <th>Quantity (L)</th>
                                    <th>Cost (BDT)</th>
                                    <th>Odometer (km)</th>
                                    <th>Station</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fuelLogs as $log)
                                <tr>
                                    <td>{{ date('d M Y', strtotime($log->fuel_date)) }}</td>
                                    <td><span class="badge badge-primary">{{ $log->fuel_type ?? 'Petrol' }}</span></td>
                                    <td>{{ $log->vehicle->vehicle_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($log->quantity, 2) }}</td>
                                    <td>{{ number_format($log->cost, 2) }}</td>
                                    <td>{{ number_format($log->odometer_reading, 2) }}</td>
                                    <td>{{ $log->location ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="card-premium mt-4">
                    <div class="card-body">
                        <div class="alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            No fuel log entries found.
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Initialize Select2 for dropdowns
    $('#vehicle_id, #fuel_type').select2({
        theme: 'classic',
        width: '100%',
        placeholder: 'Select an option'
    });
    
    // Clear validation errors on input
    $('#fuelLogForm input, #fuelLogForm select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Fetch previous fuel data when vehicle is selected
    $('#vehicle_id').on('change', function() {
        const vehicleId = $(this).val();
        if (!vehicleId) {
            $('#previousDataSection').hide();
            return;
        }
        
        $.get('{{ route('driver.fuel.vehicle.data') }}', { vehicle_id: vehicleId }, function(response) {
            if (response.data && response.data.last_odometer) {
                $('#prevOdometer').text(response.data.last_odometer + ' km');
                $('#prevFuelDate').text(response.data.last_fuel_date || '-');
                $('#prevQuantity').text(response.data.last_quantity ? response.data.last_quantity + ' L' : '-');
                
                const mileageEl = $('#prevMileage');
                if (response.data.mileage) {
                    mileageEl.text(response.data.mileage + ' km/L');
                    if (response.data.mileage < 5) {
                        mileageEl.addClass('danger');
                    } else if (response.data.mileage > 25) {
                        mileageEl.addClass('warning');
                    }
                } else {
                    mileageEl.text('-');
                }
                
                $('#previousDataSection').show();
            } else {
                $('#previousDataSection').hide();
            }
        });
    });
    
    // Auto-calculate cost per liter when cost and quantity change
    $('#fuel_cost, #fuel_quantity').on('input', function() {
        const cost = parseFloat($('#fuel_cost').val()) || 0;
        const quantity = parseFloat($('#fuel_quantity').val()) || 0;
        const odometer = parseFloat($('#odometer_reading').val()) || 0;
        
        // Calculate and display cost per liter
        if (quantity > 0 && cost > 0) {
            const costPerLiter = (cost / quantity).toFixed(2);
            // Store for display (could add a badge showing this)
        }
    });
    
    // Auto-calculate expected odometer hint
    $('#vehicle_id').on('change', function() {
        // Show hint for expected odometer
    });
    
    // AJAX Form Submission
    $('#fuelLogForm').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous alerts
        $('#alertContainer').html('');
        
        // Validate form
        let isValid = true;
        const requiredFields = ['vehicle_id', 'fuel_date', 'fuel_quantity', 'fuel_cost', 'odometer_reading'];
        
        requiredFields.forEach(function(field) {
            const input = $('#' + field);
            if (!input.val() || input.val() === '') {
                input.addClass('is-invalid');
                isValid = false;
            }
        });
        
        if (!isValid) {
            showAlert('Please fill in all required fields', 'error');
            return;
        }
        
        // Show loading state
        $('#submitBtn').addClass('loading').prop('disabled', true);
        
        // Submit via AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Show warnings if any
                    if (response.warnings && response.warnings.length > 0) {
                        response.warnings.forEach(function(warning) {
                            showAlert(warning, 'warning');
                        });
                    }
                    showAlert(response.message || 'Fuel log added successfully!', 'success');
                    // Reset form
                    $('#fuelLogForm')[0].reset();
                    $('#fuel_date').val('{{ date('Y-m-d') }}');
                    
                    // Reload after short delay to show the new entry
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(response.message || 'Error adding fuel log', 'error');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Error adding fuel log';
                let targetField = null;
                
                if (xhr.status === 422 && xhr.responseJSON) {
                    // Check for custom field error (odometer, duplicate date, etc.)
                    if (xhr.responseJSON.field) {
                        targetField = xhr.responseJSON.field;
                        $('#' + targetField).addClass('is-invalid');
                        errorMessage = xhr.responseJSON.error || 'Validation error';
                    } else if (xhr.responseJSON.errors) {
                        // Show validation errors
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $('#' + field).addClass('is-invalid');
                        });
                        errorMessage = messages[0];
                    } else if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // Show with custom alert (like SweetAlert)
                showAlert(errorMessage, 'error');
            },
            complete: function() {
                $('#submitBtn').removeClass('loading').prop('disabled', false);
            }
        });
    });
    
    // Show alert function (SweetAlert-style)
    function showAlert(message, type) {
        const icons = {
            'success': 'fa-check-circle',
            'error': 'fa-times-circle',
            'warning': 'fa-exclamation-triangle',
            'info': 'fa-info-circle'
        };
        const icon = icons[type] || 'fa-info-circle';
        const html = '<div class="alert-custom ' + type + '" style="display: flex; align-items: center; gap: 12px;">' +
                    '<i class="fa ' + icon + '" style="font-size: 24px;"></i>' +
                    '<div><strong>' + (type === 'success' ? 'Success!' : type === 'error' ? 'Error!' : type === 'warning' ? 'Warning!' : 'Notice') + '</strong><br>' + message + '</div>' +
                   '</div>';
        $('#alertContainer').html(html);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('#alertContainer').html('');
        }, 5000);
    }
});
</script>
@endsection
