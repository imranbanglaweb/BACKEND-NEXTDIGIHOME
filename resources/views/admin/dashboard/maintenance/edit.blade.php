@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color:#fff;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary"><i class="fa fa-edit me-2"></i> Edit Requisition - {{ $requisition->requisition_no }}</h3>
            <div>
                <a href="{{ route('maintenance.index') }}" class="btn btn-secondary btn-sm">Back</a>
                <a href="{{ route('maintenance.show', $requisition->id) }}" class="btn btn-info btn-sm">View</a>
            </div>
        </div>

        <form id="requisitionEditForm" method="POST" enctype="multipart/form-data" action="{{ route('maintenance.update', $requisition->id) }}">
            @csrf
            @method('PUT')

            <div class="card mb-3 p-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Requisition No</label>
                        <input type="text" class="form-control" value="{{ $requisition->requisition_no }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Type</label>
                        <select name="requisition_type" class="form-control">
                            <option value="Maintenance" {{ $requisition->requisition_type == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="Breakdown" {{ $requisition->requisition_type == 'Breakdown' ? 'selected' : '' }}>Breakdown</option>
                            <option value="Inspection" {{ $requisition->requisition_type == 'Inspection' ? 'selected' : '' }}>Inspection</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-control">
                            <option value="Low" {{ $requisition->priority=='Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ $requisition->priority=='Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ $requisition->priority=='High' ? 'selected' : '' }}>High</option>
                            <option value="Urgent" {{ $requisition->priority=='Urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Maintenance Date</label>
                        <input type="date" name="maintenance_date" class="form-control" value="{{ optional($requisition->maintenance_date)->format('Y-m-d') ?? $requisition->maintenance_date }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Vehicle</label>
                        <select name="vehicle_id" class="form-control">
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}" {{ $requisition->vehicle_id == $v->id ? 'selected' : '' }}>
                                    {{ $v->vehicle_name }} - {{ $v->model ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Employee</label>
                        <select name="employee_id" class="form-control">
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ $requisition->employee_id == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Maintenance Type</label>
                        <select name="maintenance_type_id" class="form-control">
                            @foreach($types as $t)
                                <option value="{{ $t->id }}" {{ $requisition->maintenance_type_id == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Maintenance Vendor</label>
                        <select name="vendor_id" class="form-control">
                            <option value="">Select Vendor (Optional)</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ $requisition->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Service Title</label>
                        <input type="text" name="service_title" class="form-control" value="{{ $requisition->service_title }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Charge Bear By</label>
                        <select name="charge_bear_by" class="form-control">
                            <option value="Company" {{ $requisition->charge_bear_by=='Company' ? 'selected':'' }}>Company</option>
                            <option value="Vendor" {{ $requisition->charge_bear_by=='Vendor' ? 'selected':'' }}>Vendor</option>
                            <option value="Employee" {{ $requisition->charge_bear_by=='Employee' ? 'selected':'' }}>Employee</option>
                            <option value="Department" {{ $requisition->charge_bear_by=='Department' ? 'selected':'' }}>Department</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Charge Amount</label>
                        <input type="number" step="0.01" name="charge_amount" id="charge_amount" class="form-control" value="{{ $requisition->charge_amount }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2">{{ $requisition->remarks }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Items block --}}
            <div class="card mb-3 p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Parts / Items</h5>
                    <button type="button" id="addRow" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add Item</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width:180px">Category</th>
                                <th>Item Name</th>
                                <th style="width:120px">Qty</th>
                                <th style="width:150px">Unit Price</th>
                                <th style="width:150px">Total</th>
                                <th style="width:60px">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requisition->items as $i => $item)
                                <tr class="item-row">
                                    <td>
                                        <select name="items[{{ $i }}][category_id]" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="items[{{ $i }}][item_name]" class="form-control" value="{{ $item->item_name }}"></td>
                                    <td><input type="number" min="0" step="1" name="items[{{ $i }}][qty]" class="form-control qty" value="{{ $item->qty }}"></td>
                                    <td><input type="number" min="0" step="0.01" name="items[{{ $i }}][unit_price]" class="form-control unit_price" value="{{ $item->unit_price }}"></td>
                                    <td><input type="text" name="items[{{ $i }}][total_price]" class="form-control total_price" readonly value="{{ $item->total_price }}"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Parts Total:</strong></td>
                                <td colspan="1"><input type="text" id="parts_total" class="form-control" readonly value="{{ $requisition->total_parts_cost ?? 0 }}"></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Charge Amount:</strong></td>
                                <td colspan="1"><input type="text" id="charge_total_display" class="form-control" readonly value="{{ $requisition->charge_amount ?? 0 }}"></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                                <td colspan="1"><input type="text" id="grand_total" class="form-control" readonly value="{{ $requisition->total_cost ?? 0 }}"></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mb-4">
                <button type="submit" id="saveBtn" class="btn btn-primary"><i class="fa fa-save"></i> Update Requisition</button>
                <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</section>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // Utility: recompute totals for each row and totals summary
    function recomputeTotals() {
        let partsTotal = 0;

        $('#itemsTable tbody tr.item-row').each(function(){
            let qty = parseFloat($(this).find('.qty').val() || 0);
            let unit = parseFloat($(this).find('.unit_price').val() || 0);
            let total = qty * unit;
            $(this).find('.total_price').val(total.toFixed(2));
            partsTotal += total;
        });

        $('#parts_total').val(partsTotal.toFixed(2));

        // charge amount from parent input
        let charge = parseFloat($('#charge_amount').val() || 0);
        $('#charge_total_display').val(charge.toFixed(2));

        $('#grand_total').val((partsTotal + charge).toFixed(2));
    }

    // bind change handlers (delegate for dynamic rows)
    $('#itemsTable').on('input', '.qty, .unit_price', function(){
        recomputeTotals();
    });

    // when charge amount changes
    $('#charge_amount').on('input', function(){
        recomputeTotals();
    });

    // add new blank row
    let rowIndex = {{ $requisition->items->count() }};
    $('#addRow').on('click', function(){
        let idx = rowIndex++;
        let categoriesOptions = `@foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach`;
        let tr = `<tr class="item-row">
            <td><select name="items[${idx}][category_id]" class="form-control"><option value="">-- Select --</option>${categoriesOptions}</select></td>
            <td><input type="text" name="items[${idx}][item_name]" class="form-control"></td>
            <td><input type="number" min="0" step="1" name="items[${idx}][qty]" class="form-control qty" value="0"></td>
            <td><input type="number" min="0" step="0.01" name="items[${idx}][unit_price]" class="form-control unit_price" value="0.00"></td>
            <td><input type="text" name="items[${idx}][total_price]" class="form-control total_price" readonly value="0.00"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-minus"></i></button></td>
        </tr>`;
        $('#itemsTable tbody').append(tr);
    });

    // remove row
    $('#itemsTable').on('click', '.removeRow', function(){
        $(this).closest('tr').remove();
        recomputeTotals();
    });

    // initial compute
    recomputeTotals();

    // AJAX submit
    $('#requisitionEditForm').on('submit', function(e){
        e.preventDefault();
        $('#saveBtn').prop('disabled', true).text('Updating...');

        let form = this;
        let formData = $(form).serializeArray(); // simpler for arrays
        // send via AJAX (we'll post form-encoded)
        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(), // includes _method=PUT
            success: function(res){
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: res.message || 'Requisition updated successfully'
                }).then(()=> {
                    window.location.href = "{{ route('maintenance.index') }}";
                });
            },
            error: function(xhr) {
                $('#saveBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Update Requisition');
                if (xhr.status === 422) {
                    // validation errors
                    let errors = xhr.responseJSON.errors;
                    let errText = '';
                    $.each(errors, function(k,v){ errText += v[0] + '\n'; });
                    Swal.fire('Validation error', errText, 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong. See console for details.', 'error');
                    console.error(xhr.responseText);
                }
            }
        });
    });

});
</script>
 
@endsection
