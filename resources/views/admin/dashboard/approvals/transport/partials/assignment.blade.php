<!-- Assignment section for transport approvals -->
<div class="assignment-section mt-5 mb-4">
    <h4 class="fw-bold text-dark mb-3">
        <i class="fa fa-car me-2"></i> Vehicle & Driver Assignment
    </h4>
    @if(isset($vehicles) && isset($drivers))
    <form id="actionForm" action="{{ route('transport.approvals.assign', $requisition->id) }}" method="POST" class="mt-4" onsubmit="event.preventDefault(); submitAssign();" data-assigned-vehicle="{{ $requisition->assigned_vehicle_id ?? '' }}" data-assigned-driver="{{ $requisition->assigned_driver_id ?? '' }}">
        @csrf
        <div class="row">
            <!-- Transport Type Selection -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Transport Type</label>
                <select name="transport_type" id="transportTypeSelect" class="form-select form-select-lg select2" style="width:100%">
                    <option value="">-- Select Transport Type --</option>
                    @php
                    $transportTypes = \App\Models\VehicleType::where('status', 1)->get();
                    $selectedVehicleType = $requisition->vehicle_type ?? null;
                    @endphp
                    @foreach($transportTypes as $type)
                        <option value="{{ $type->id }}" {{ $selectedVehicleType == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
                <div id="transportTypeStatus" class="mt-2 fw-semibold"></div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Select Vehicle</label>
                <select name="assigned_vehicle_id" id="vehicleSelect" class="form-select form-select-lg select2" style="width:100%" data-initial-vehicle="{{ $requisition->assigned_vehicle_id ?? '' }}">
                    <option value="">-- Select Vehicle --</option>
                    @php
                    $selectedVehicleId = $requisition->assigned_vehicle_id ?? null;
                    @endphp
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" data-transport-type="{{ $vehicle->vehicle_type_id ?? '' }}" data-capacity="{{ $vehicle->capacity ?? 0 }}" data-status="{{ $vehicle->availability_status }}" @if(strtolower($vehicle->availability_status) === 'assigned') disabled @endif {{ $selectedVehicleId == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->vehicle_name }}@if(!empty($vehicle->number_plate)) - [{{ $vehicle->number_plate }}]@endif
                            @if($vehicle->capacity) ({{ $vehicle->capacity }} seats) @endif
                        </option>
                    @endforeach
                </select>
                <div id="vehicleStatus" class="mt-2 fw-semibold"></div>
                <div id="vehicleCapacityInfo" class="mt-1 text-muted small"></div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Select Driver</label>
                <select name="assigned_driver_id" id="driverSelect" class="form-select form-select-lg select2" style="width:100%" data-initial-driver="{{ $requisition->assigned_driver_id ?? '' }}">
                    <option value="">-- Select Driver --</option>
                    @php
                    $selectedDriverId = $requisition->assigned_driver_id ?? null;
                    @endphp
                    @foreach($drivers as $driver)
                        <option 
                            value="{{ $driver->id }}"
                            data-status="{{ $driver->availability_status }}"
                            data-vehicle-id="{{ $driver->vehicle_id ?? '' }}"
                            {{ strtolower($driver->availability_status) === 'assigned' ? 'disabled' : '' }}
                            {{ $selectedDriverId == $driver->id ? 'selected' : '' }}
                        >
                            {{ $driver->driver_name }} 
                            @if($driver->employee && $driver->employee->employee_id) - [{{ $driver->employee->employee_id }}] @endif
                            @if($driver->phone) - {{ $driver->phone }} @endif
                        </option>
                    @endforeach
                </select>
                <div id="driverStatus" class="mt-2 fw-semibold"></div>
                <div id="driverAvailabilityIndicator" class="mt-2"></div>
            </div>
        </div>
        <div class="row mt-3">
            <!-- Estimated Departure Time -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Est. Departure Time</label>
                @php
                $estimatedDeparture = '';
                if ($requisition->travel_date && $requisition->travel_time) {
                    $travelDate = \Carbon\Carbon::parse($requisition->travel_date);
                    $travelTime = \Carbon\Carbon::parse($requisition->travel_time);
                    $estimatedDeparture = $travelDate->format('Y-m-d') . 'T' . $travelTime->format('H:i');
                } elseif ($requisition->travel_date) {
                    $estimatedDeparture = \Carbon\Carbon::parse($requisition->travel_date)->format('Y-m-d') . 'T09:00';
                }
                @endphp
                <input type="datetime-local" name="estimated_departure" id="estimatedDeparture" class="form-control form-control-lg" value="{{ $estimatedDeparture }}">
            </div>
            <!-- Assignment Summary -->
            <div class="col-md-8">
                <div class="mt-4 p-3 bg-light rounded-4 border" id="assignmentSummary" style="display:none;">
                    <h6 class="fw-bold mb-2">Assignment Summary:</h6>
                    <div class="row">
                        <div class="col-md-4"><strong>Vehicle:</strong> <span id="summaryVehicle">—</span></div>
                        <div class="col-md-4"><strong>Driver:</strong> <span id="summaryDriver">—</span></div>
                        <div class="col-md-4"><strong>Departure:</strong> <span id="summaryDeparture">—</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-lg fw-bold" id="assignButton">
                    <i class="fa fa-save me-2"></i> Assign Vehicle & Driver
                </button>
            </div>
        </div>
    </form>
    @endif
</div>

<style>
/* Driver availability indicator styles */
.driver-indicator {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.driver-indicator.available {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.driver-indicator.busy {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.driver-indicator .icon {
    margin-right: 6px;
    font-size: 16px;
}

.driver-indicator.available .icon {
    color: #28a745;
}

.driver-indicator.busy .icon {
    color: #dc3545;
}
</style>
