<div class="row g-3">

    <div class="col-md-4">
        <label class="form-label fw-semibold">Title</label>
        <input type="text" name="title" class="form-control"
               value="{{ old('title', $schedule->title ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Vehicle</label>
        <select name="vehicle_id" class="form-select">
            @foreach($vehicles as $v)
                <option value="{{ $v->id }}"
                    {{ old('vehicle_id', $schedule->vehicle_id ?? '') == $v->id ? 'selected':'' }}>
                    {{ $v->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Maintenance Type</label>
        <select name="maintenance_type_id" class="form-select">
            @foreach($types as $t)
                <option value="{{ $t->id }}"
                    {{ old('maintenance_type_id', $schedule->maintenance_type_id ?? '') == $t->id ? 'selected':'' }}>
                    {{ $t->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Vendor</label>
        <select name="vendor_id" class="form-select">
            <option value="">Select vendor</option>
            @foreach($vendors as $v)
                <option value="{{ $v->id }}"
                    {{ old('vendor_id', $schedule->vendor_id ?? '') == $v->id ? 'selected':'' }}>
                    {{ $v->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Scheduled Date</label>
        <input type="date" name="scheduled_at" class="form-control"
               value="{{ old('scheduled_at', $schedule->scheduled_at ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Next Due Date</label>
        <input type="date" name="next_due_date" class="form-control"
               value="{{ old('next_due_date', $schedule->next_due_date ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Due KM</label>
        <input type="number" name="due_km" class="form-control"
               value="{{ old('due_km', $schedule->due_km ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Frequency</label>
        <input type="text" name="frequency" placeholder="e.g. 3 months"
               class="form-control"
               value="{{ old('frequency', $schedule->frequency ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Active</label>
        <select name="active" class="form-select">
            <option value="1" {{ old('active', $schedule->active ?? 1)==1?'selected':'' }}>Active</option>
            <option value="0" {{ old('active', $schedule->active ?? 1)==0?'selected':'' }}>Inactive</option>
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label fw-semibold">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $schedule->notes ?? '') }}</textarea>
    </div>

</div>
