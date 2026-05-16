<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Premium Form Styling */
    * { box-sizing: border-box; }
    
    .page-header { 
        padding: 2.5rem 0 2rem 0;
        animation: slideDown 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: linear-gradient(135deg, rgba(74, 144, 226, 0.05) 0%, rgba(74, 144, 226, 0.02) 100%);
        border-bottom: 2px solid #e9ecf1;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    
    .page-header h4 { 
        margin: 0 0 0.5rem 0;
    }
    
    .page-header p { 
        margin: 0;
    }
    
    .page-title { 
        color: #0f0f1e;
        font-weight: 900;
        font-size: 2.25rem;
        margin-bottom: 0.5rem;
        letter-spacing: -0.8px;
        text-shadow: 0 2px 4px rgba(15, 15, 30, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .page-title i { 
        color: #4a90e2;
        font-size: 2rem;
        text-shadow: 0 2px 8px rgba(74, 144, 226, 0.2);
    }
    
    .page-header .text-muted { 
        color: #5a6a7a !important;
        font-size: 1.05rem;
        font-weight: 500;
        letter-spacing: 0.2px;
        margin-top: 0.5rem;
    }
    
    .form-section { 
        background: linear-gradient(135deg, #fafbfc 0%, #ffffff 50%, #f5f8fc 100%);
        padding: 1.75rem;
        border-radius: 12px;
        border: 2px solid #f0f2f5;
        border-left: 5px solid #4a90e2;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(74, 144, 226, 0.08);
        position: relative;
        overflow: hidden;
    }
    .form-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        height: 100%;
        width: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        transition: left 0.5s ease;
    }
    .form-section:hover {
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.12);
        border-color: #e8f0f8;
        transform: translateY(-2px);
    }
    .form-section:hover::before { left: 100%; }
    
    .section-title { 
        color: #1a2332;
        font-weight: 800;
        font-size: 1rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #e9ecf1;
        margin-bottom: 1.75rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-title i { color: #4a90e2; font-size: 1.1rem; }
    
    .row { 
        display: flex;
        flex-wrap: wrap;
        margin-right: -0.75rem;
        margin-left: -0.75rem;
    }
    
    [class*='col-'] {
        padding-right: 0.75rem;
        padding-left: 0.75rem;
    }
    
    .form-group { 
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
        width: 100%;
    }
    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }
    .form-group:nth-child(4) { animation-delay: 0.4s; }
    .form-group:nth-child(5) { animation-delay: 0.5s; }
    
    .form-group label { 
        font-weight: 700;
        color: #1a2332;
        font-size: 0.9rem;
        margin-bottom: 0.7rem;
        display: block;
        text-transform: capitalize;
        letter-spacing: 0.2px;
    }
    
    .form-group small {
        color: #7a8a9a;
        font-size: 0.8rem;
        display: block;
        margin-top: 0.4rem;
        font-weight: 500;
    }
    
    .input-group { 
        display: flex;
        align-items: center;
        position: relative;
    }
    
    .input-group-prepend { 
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }
    
    .input-group-text { 
        background: linear-gradient(135deg, #eef4fb 0%, #e5ecf3 100%);
        border: 2px solid #d5dce3;
        color: #4a90e2;
        font-weight: 700;
        border-radius: 6px 0 0 6px;
        transition: all 0.3s ease;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 1rem;
    }
    .input-group-text i { font-size: 1rem; }
    
    .form-control { 
        border: 2px solid #e0e6ed;
        border-radius: 0 6px 6px 0;
        height: 44px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        background-color: #ffffff;
        font-weight: 500;
    }
    
    .form-control:focus { 
        border-color: #4a90e2;
        box-shadow: inset 0 2px 4px rgba(74, 144, 226, 0.08), 0 0 0 4px rgba(74, 144, 226, 0.12);
        outline: none;
        background-color: #fafbfc;
    }
    
    .form-control::-webkit-input-placeholder { color: #a8b2c1; font-weight: 500; }
    .form-control:-ms-input-placeholder { color: #a8b2c1; font-weight: 500; }
    .form-control::placeholder { color: #a8b2c1; font-weight: 500; }
    
    .form-group .input-group .form-control:first-of-type { 
        border-radius: 0 6px 6px 0;
    }
    
    .select2-container { 
        width: 100% !important;
    }
    
    .input-group .select2-container { 
        flex: 1;
        margin-bottom: 0;
    }
    
    .input-group.has-prepend .select2-container--default .select2-selection--single { 
        border-radius: 0 6px 6px 0;
    }
    
    .select2-container--default .select2-selection--single { 
        height: 44px;
        border: 2px solid #e0e6ed;
        border-radius: 6px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #ffffff;
        display: flex;
        align-items: center;
    }
    .select2-container--default.select2-container--focus .select2-selection--single { 
        border-color: #4a90e2;
        box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.12);
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered { 
        line-height: 44px;
        font-weight: 500;
        color: #1a2332;
        padding: 0 0.75rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow { 
        height: 44px;
        display: flex;
        align-items: center;
    }
    
    .custom-switch .custom-control-label::before { 
        height: 28px;
        width: 52px;
        background-color: #d5dce3;
        border-radius: 14px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .custom-switch .custom-control-label::after { 
        width: 24px;
        height: 24px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }
    .custom-switch .custom-control-input:checked ~ .custom-control-label::before { 
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        box-shadow: 0 2px 8px rgba(74, 144, 226, 0.3);
    }
    .custom-switch .custom-control-input:checked ~ .custom-control-label::after { 
        transform: translateX(26px);
        background-color: #ffffff;
    }
    
    .alert { 
        border-radius: 8px;
        border: none;
        padding: 1.25rem;
        animation: slideDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .alert-info { 
        background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f4 100%);
        color: #0c5460;
        border-left: 4px solid #4a90e2;
        box-shadow: 0 2px 8px rgba(74, 144, 226, 0.1);
    }
    
    .alert h5 { 
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #055160;
    }
    
    .alert p { 
        margin-bottom: 0;
        font-size: 0.9rem;
        color: #0c5460;
    }
    
    .text-danger { 
        color: #dc3545 !important;
        font-weight: 700;
    }
    
    .is-invalid { border-color: #dc3545 !important; }
    .invalid-feedback { 
        display: block;
        color: #dc3545;
        font-size: 0.8rem;
        margin-top: 0.5rem;
        font-weight: 600;
        animation: slideDown 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .card { 
        border-radius: 14px;
        border: none;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    }
    .card:hover { 
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        transform: translateY(-4px);
    }
    
    .btn { 
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 700;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.85rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s ease;
        z-index: 0;
    }
    .btn:hover::before { left: 100%; }
    
    .btn:focus { 
        outline: 2px solid transparent;
        box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.25);
    }
    
    .btn-primary { 
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.35);
    }
    .btn-primary:hover { 
        background: linear-gradient(135deg, #357abd 0%, #2a6ab5 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(74, 144, 226, 0.45);
    }
    .btn-primary:active { transform: translateY(-1px); }
    
    .btn-light { 
        background: #f8f9fa;
        border: 2px solid #d5dce3;
        color: #1a2332;
        transition: all 0.35s ease;
        font-weight: 700;
    }
    .btn-light:hover { 
        background: linear-gradient(135deg, #ffffff 0%, #f5f8fc 100%);
        border-color: #4a90e2;
        color: #4a90e2;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
    }
    
    .form-actions { 
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 1.5rem;
        padding-bottom: 1rem;
        border-top: 2px solid #f0f2f5;
        animation: slideDown 0.5s 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        opacity: 0;
    }
    .form-actions .btn { 
        min-width: 140px;
        text-align: center;
    }
    
    .btn-loader { 
        display: none !important;
        align-items: center;
        gap: 0.7rem;
    }
    
    #submitBtn { 
        min-width: 150px;
        position: relative;
        z-index: 1;
    }
    #submitBtn.processing { 
        pointer-events: none;
        opacity: 0.9;
    }
    #submitBtn.processing .btn-content { display: none !important; }
    #submitBtn.processing .btn-loader { display: inline-flex !important; }
    
    .spinner-border-sm { 
        width: 1.1rem;
        height: 1.1rem;
        animation: spin 0.7s linear infinite;
        border: 2px solid rgba(255,255,255,0.3);
        border-right-color: white;
    }
    
    /* Utility Classes */
    .mr-1 { margin-right: 0.25rem; }
    .mr-2 { margin-right: 0.5rem; }
    .me-2 { margin-right: 0.5rem; }
    .me-1 { margin-right: 0.25rem; }
    .mt-3 { margin-top: 1rem; }
    .mb-0 { margin-bottom: 0 !important; }
    .pt-3 { padding-top: 1rem; }
    .p-4 { padding: 1.5rem; }
    .mb-4 { margin-bottom: 1.5rem; }
    .d-flex { display: flex; }
    .d-none { display: none !important; }
    .align-items-center { align-items: center; }
    .justify-content-between { justify-content: space-between; }
    .justify-content-end { justify-content: flex-end; }
    .border-top { border-top: 1px solid #f0f0f0; }
    .border-0 { border: none; }
    .shadow-sm { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); }
    .text-muted { color: #6c757d; }
    
    /* Full Width Container */
    .card { 
        width: 100%;
        max-width: 100%;
    }
    
    .card-body { 
        width: 100%;
    }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @media (max-width: 768px) {
        .page-header { padding: 2rem 0 1.5rem 0; margin-bottom: 1rem; }
        .page-title { font-size: 1.8rem; }
        .page-title i { font-size: 1.6rem; }
        .page-header .text-muted { font-size: 0.95rem; }
        .form-section { padding: 1.25rem; border-radius: 10px; }
        .section-title { font-size: 0.85rem; letter-spacing: 0.5px; }
        .btn { padding: 0.65rem 1.25rem; font-size: 0.8rem; }
        #submitBtn { min-width: 120px; }
        .col-md-6, .col-md-8, .col-md-4, .col-md-12 { width: 100%; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; }
    }
    
    @media (max-width: 576px) {
        .page-header { padding: 1.5rem 0 1rem 0; margin-bottom: 0.75rem; border-radius: 6px; }
        .page-title { font-size: 1.5rem; gap: 0.5rem; }
        .page-title i { font-size: 1.3rem; }
        .page-header .text-muted { font-size: 0.9rem; }
        .form-section { padding: 1rem; border-radius: 8px; margin-bottom: 1rem; }
        .section-title { font-size: 0.8rem; padding-bottom: 0.75rem; }
        .form-group { margin-bottom: 1rem; }
        .input-group-text { padding: 0 0.75rem; }
        .input-group-text i { font-size: 0.9rem; }
    }
</style>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
                <!-- Device Information Section -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-info-circle mr-2"></i>Device Information
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="device_name">Device Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    </div>
                                    <input type="text" name="device_name" id="device_name" class="form-control"
                                           value="{{ old('device_name', isset($gpsDevice) ? $gpsDevice->device_name : '') }}">
                                </div>
                                <div class="invalid-feedback" id="device_name_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="device_type">Device Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-microchip"></i></span>
                                    </div>
                                    <select name="device_type" id="device_type" class="form-control select2">
                                        <option value="">Select Device Type</option>
                                        @foreach($deviceTypes as $key => $value)
                                            <option value="{{ $key }}" {{ old('device_type', isset($gpsDevice) ? $gpsDevice->device_type : '') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Connection Details Section -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-link mr-2"></i>Connection Details
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="imei_number">IMEI Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    </div>
                                    <input type="text" name="imei_number" id="imei_number" class="form-control"
                                           value="{{ old('imei_number', isset($gpsDevice) ? $gpsDevice->imei_number : '') }}">
                                </div>
                                <div class="invalid-feedback" id="imei_number_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sim_number">SIM Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-sim-card"></i></span>
                                    </div>
                                    <input type="text" name="sim_number" id="sim_number" class="form-control"
                                           value="{{ old('sim_number', isset($gpsDevice) ? $gpsDevice->sim_number : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="protocol">Protocol <span class="text-danger">*</span></label>
                                <select name="protocol" id="protocol" class="form-control select2">
                                    <option value="">Select Communication Protocol</option>
                                    @foreach($protocols as $key => $value)
                                        <option value="{{ $key }}" {{ old('protocol', isset($gpsDevice) ? $gpsDevice->protocol : 'GT06') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="protocol_error"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Server Configuration Section -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-server mr-2"></i>Server Configuration
                    </h5>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="server_host">Server Host / IP Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    </div>
                                    <input type="text" name="server_host" id="server_host" class="form-control"
                                           value="{{ old('server_host', isset($gpsDevice) ? $gpsDevice->server_host : '') }}" placeholder="e.g., yourserver.com or IP">
                                </div>
                                <small class="text-muted">The GPS device will send data to this server</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="server_port">Server Port</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-plug"></i></span>
                                    </div>
                                    <input type="number" name="server_port" id="server_port" class="form-control"
                                           value="{{ old('server_port', isset($gpsDevice) ? $gpsDevice->server_port : '') }}" placeholder="e.g., 8080">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Assignment Section -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-car mr-2"></i>Vehicle Assignment
                    </h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="vehicle_id">Assign to Vehicle</label>
                                <select name="vehicle_id" id="vehicle_id" class="form-control select2">
                                    <option value="">Select Vehicle (Optional)</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id', isset($gpsDevice) ? $gpsDevice->vehicle_id : '') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->vehicle_name }} ({{ $vehicle->vehicle_number }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Link this GPS device to a specific vehicle</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Settings Section -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-cog mr-2"></i>Additional Settings
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="installation_date">Installation Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="date" name="installation_date" id="installation_date" class="form-control"
                                           value="{{ old('installation_date', isset($gpsDevice) ? $gpsDevice->installation_date : '') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                           {{ old('is_active', isset($gpsDevice) ? $gpsDevice->is_active : true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Device is Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', isset($gpsDevice) ? $gpsDevice->notes : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supported Device Protocols Info -->
                <div class="alert alert-info mt-3">
                    <h5><i class="fas fa-info-circle"></i> Supported GPS Device Protocols</h5>
                    <p class="mb-0">This system supports various GPS device protocols including: GT06 (Concox), TK103/TK104, A8/A9, Syrus, Meiligao, and custom protocols. The device will send location data to the configured server endpoint.</p>
                </div>

                <!-- Form Actions -->
                <div class="form-actions d-flex justify-content-end pt-3 border-top">
                    <button type="button" class="btn btn-light mr-2" onclick="window.location.href='{{ route('admin.gps-devices.index') }}'">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="btn-content">
                            <i class="fas fa-save mr-1"></i> {{ isset($gpsDevice) ? 'Update Device' : 'Create Device' }}
                        </span>
                        <span class="btn-loader d-none">
                            <span class="spinner-border spinner-border-sm mr-1"></span>
                            {{ isset($gpsDevice) ? 'Updating...' : 'Creating...' }}
                        </span>
                    </button>
                </div>
            </div>
        </div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({ 
        placeholder: 'Select an option', 
        allowClear: true, 
        width: '100%',
        theme: 'bootstrap'
    });

    // Optional: Server-side validation is primary
    // Client-side validation only for better UX

    // Form submission with enhanced AJAX
    $('#gpsDeviceForm').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        var $form = $(this);
        var formData = new FormData(this);
        var $submitBtn = $('#submitBtn');
        var originalText = $submitBtn.find('.btn-content').html();

        // Disable button and show loading state
        $submitBtn.prop('disabled', true).addClass('processing');

        // Visual feedback - form dimming
        $form.css('opacity', '0.85').css('pointer-events', 'none');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            timeout: 30000,
            success: function(response) {
                $submitBtn.prop('disabled', false).removeClass('processing');
                $form.css('opacity', '1').css('pointer-events', 'auto');

                if (response.success) {
                    // Success notification with celebration effect
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'GPS Device saved successfully!',
                        confirmButtonColor: '#4a90e2',
                        allowOutsideClick: false,
                        didOpen: function() {
                            // Add celebration animation
                            Swal.getConfirmButton().style.animation = 'pulse 0.5s ease-in-out';
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect || '{{ route("admin.gps-devices.index") }}';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Something went wrong!',
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr, status, error) {
                $submitBtn.prop('disabled', false).removeClass('processing');
                $form.css('opacity', '1').css('pointer-events', 'auto');

                if (status === 'timeout') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Timeout',
                        text: 'Request took too long. Please try again.',
                        confirmButtonColor: '#dc3545'
                    });
                    return;
                }

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var firstErrorField = null;

                    // Display field-level errors
                    $.each(errors, function(field, msgs) {
                        var fieldId = field.replace(/\./g, '_');
                        var $input = $('#' + fieldId);

                        if ($input.length) {
                            $input.addClass('is-invalid').attr('aria-invalid', 'true');
                            var $errorTarget = $('#' + fieldId + '_error');
                            if ($errorTarget.length) {
                                $errorTarget.text(msgs[0]);
                            }

                            // Focus on first error field
                            if (!firstErrorField) {
                                firstErrorField = $input;
                            }
                        }
                    });

                    // Scroll to first error field
                    if (firstErrorField) {
                        $('html, body').animate({
                            scrollTop: firstErrorField.offset().top - 100
                        }, 400);
                        firstErrorField.focus();
                    }

                    // Show main validation alert
                    var firstError = errors[Object.keys(errors)[0]];
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: firstError[0],
                        confirmButtonColor: '#dc3545'
                    });
                } else if (xhr.status === 409) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: xhr.responseJSON?.message || 'This entry already exists!',
                        confirmButtonColor: '#ff9800'
                    });
                } else {
                    var errorMsg = 'An unexpected error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMsg + ' Please try again.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            }
        });
    });

    // Real-time validation clearing
    $('#gpsDeviceForm input, #gpsDeviceForm select, #gpsDeviceForm textarea').on('change input', function() {
        var $field = $(this);

        // Remove error state
        if ($field.hasClass('is-invalid')) {
            $field.removeClass('is-invalid').attr('aria-invalid', 'false');
            var $errorTarget = $('#' + $field.attr('id') + '_error');
            if ($errorTarget.length) {
                $errorTarget.slideUp(200, function() { $(this).text(''); }).slideDown(200);
            }
        }
    });

    // Form cancel functionality with confirmation
    $('#gpsDeviceForm button[type="button"]').on('click', function() {
        Swal.fire({
            title: 'Cancel Form?',
            text: 'Any unsaved changes will be lost.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel',
            cancelButtonText: 'No, continue'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("admin.gps-devices.index") }}';
            }
        });
    });
});
</script>
@endpush

