@csrf
<div class="mb-3">
    <label class="form-label">Type Name</label>
    <input type="text" name="type_name" class="form-control" value="{{ old('type_name', $licnese_type->type_name ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $licnese_type->description ?? '') }}</textarea>
</div>
<!-- <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="Active" {{ (old('status', $licnese_type->status ?? 'Active') == 'Active') ? 'selected' : '' }}>Active</option>
        <option value="Inactive" {{ (old('status', $licnese_type->status ?? '') == 'Inactive') ? 'selected' : '' }}>Inactive</option>
    </select>
</div> -->
