@extends('admin.dashboard.master')

@section('main_content')

@push('styles')
<style>
    .content-body { background-color: #ffffff; min-height: 100vh; }
    .card { border: 1px solid #eef2f7; box-shadow: 0 0.75rem 1.5rem rgba(18,38,63,.03); border-radius: 0.5rem; }
    .card-header { background-color: transparent; border-bottom: 1px solid #eef2f7; padding: 1.5rem; }
    .card-body { padding: 1.5rem; }
    .form-label { font-weight: 500; color: #343a40; margin-bottom: 0.5rem; }
    .form-control, .form-select { border-color: #dee2e6; padding: 0.6rem 1rem; border-radius: 0.4rem; }
    .form-control:focus, .form-select:focus { border-color: #727cf5; box-shadow: 0 0 0 0.2rem rgba(114, 124, 245, 0.25); }
    .table thead th { background-color: #f8f9fa; border-bottom: 2px solid #eef2f7; color: #6c757d; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    .btn-primary { background-color: #727cf5; border-color: #727cf5; box-shadow: 0 2px 6px 0 rgba(114, 124, 245, 0.5); }
    .btn-primary:hover { background-color: #5f6af3; border-color: #5f6af3; }
    .total-display { font-size: 1.5rem; font-weight: 700; color: #727cf5; }
    .select2-container .select2-selection--single { height: 42px !important; border: 1px solid #dee2e6; padding: 6px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { top: 8px; }
    .is-invalid + .select2-container .select2-selection--single { border-color: #dc3545; }
    .status-badge { padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; color: #fff; }
    .status-pending { background-color: #ffc107; }
    .status-approved { background-color: #28a745; }
    .status-rejected { background-color: #dc3545; }
    /* Readonly select styling */
    select[disabled] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>
@endpush

<section class="content-body">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Create Requisition</h3>
                <p class="">
                    <strong>
                    Fill in the details to create a new maintenance requisition.
                    </strong>
                </p>
            </div>
            <a href="{{ route('maintenance.index') }}" class="btn btn-primary">
            <i class="fa fa-arrow-left me-1"></i> Back to List</a>
        </div>

        <form id="requisitionForm" action="{{ route('maintenance.store') }}" method="POST" novalidate>
            @csrf
            
            <!-- Main Info Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Requisition Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label class="form-label">Requisition Type <span class="text-danger">*</span></label>
                            <select name="requisition_type" class="form-select select2" required>
                                <option value="">Select Type</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="breakdown">Breakdown</option>
                                <option value="inspection">Inspection</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Priority <span class="text-danger">*</span></label>
                            <select name="priority" class="form-select select2" required>
                                <option value="">Select Priority</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="Urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Requested By <span class="text-danger">*</span></label>
                            <select name="employee_id" id="employee_id" class="form-select select2" required @if($loggedInEmployeeId) disabled @endif>
                                <option value="">Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" @if($loggedInEmployeeId && $loggedInEmployeeId == $emp->id) selected @endif>{{ $emp->name }}</option>
                                @endforeach
                            </select>
                            @if($loggedInEmployeeId)
                            <input type="hidden" name="employee_id" value="{{ $loggedInEmployeeId }}">
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                            <select name="vehicle_id" class="form-select select2" required>
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}">{{ $v->vehicle_name }} - {{ $v->model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Maintenance Type <span class="text-danger">*</span></label>
                            <select name="maintenance_type_id" class="form-select select2" required>
                                <option value="">Select Type</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Maintenance Vendor</label>
                            <select name="vendor_id" class="form-select select2">
                                <option value="">Select Vendor (Optional)</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Maintenance Date <span class="text-danger">*</span></label>
                            <input type="date" name="maintenance_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Service Title <span class="text-danger">*</span></label>
                            <input type="text" name="service_title" class="form-control" placeholder="e.g. Regular Service 5000km" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Parts & Items</h5>
                    <div>
                        <button type="button" class="btn btn-outline-primary btn-sm me-2" id="addManualItem"><i class="fa fa-plus me-1"></i> Add Manual Item</button>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#inventoryModal"><i class="fa fa-box me-1"></i> Add from Inventory</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="itemsTable">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Category</th>
                                    <th style="width: 30%;">Item Name</th>
                                    <th style="width: 15%;">Quantity</th>
                                    <th style="width: 15%;">Unit Price</th>
                                    <th style="width: 15%;">Total</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows will be added here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Parts Total:</td>
                                    <td class="fw-bold text-end" id="partsTotalDisplay">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="emptyState" class="text-center py-5 text-muted">
                        <i class="fa fa-box-open fa-3x mb-3 opacity-50"></i>
                        <p>No items added yet. Add items from inventory or manually.</p>
                    </div>
                </div>
            </div>

            <!-- Cost & Remarks Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Remarks / Notes</label>
                            <textarea name="remarks" class="form-control" rows="4" placeholder="Any additional notes..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Charge Bear By</label>
                                        <select name="charge_bear_by" class="form-select">
                                            <option value="Company">Company</option>
                                            <option value="Vendor">Vendor</option>
                                            <option value="Employee">Employee</option>
                                            <option value="Department">Department</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Service Charge</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="charge_amount" id="chargeAmount" class="form-control text-end" value="0" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Grand Total</h5>
                                    <div class="total-display">$<span id="grandTotalDisplay">0.00</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Notification Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Notification Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="sendEmailToHead" name="send_email_to_head" value="1" checked>
                                <label class="form-check-label" for="sendEmailToHead">
                                    Send email notification to Department Head
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" id="departmentHeadEmailSection">
                            <label class="form-label">Department Head Email</label>
                            <input type="email" name="department_head_email" class="form-control" placeholder="department.head@company.com" readonly>
                            <small class="text-muted">Leave empty to send to default department head</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Actions -->
            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('maintenance.index') }}" class="btn btn-light border px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4" id="submitBtn"><i class="fa fa-save me-1"></i> Create Requisition</button>
            </div>
        </form>
    </div>
</section>

<!-- Inventory Modal -->
<div class="modal" id="inventoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select from Inventory</h5>
                <button type="button" class="btn-close pull-right btn-danger" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="inventorySearch" class="form-control" placeholder="Search items...">
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Item Name</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody">
                            @foreach($inventoryItems as $item)
                            <tr class="inventory-row" data-stock="{{ $item->stock_qty }}">
                                <td class="item-name">{{ $item->name }}</td>
                                <td>{{ $item->stock_qty }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary select-inventory-item"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-price="{{ $item->unit_price }}"
                                        data-category="{{ $item->category_id }}">
                                        Select
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    $('.select2').select2({ width: '100%' });
    
    // Disable select2 when it's pre-selected with logged in user
    @if($loggedInEmployeeId)
    $('select[name="employee_id"]').on('select2:open', function(e) {
        e.preventDefault();
    });
    @endif
    
    let rowIndex = 0;

    // Category options
    let categoryOptions = '<option value="">Select Category</option>';
    @foreach($categories as $cat)
        categoryOptions += '<option value="{{ $cat->id }}">{{ $cat->category_name }}</option>';
    @endforeach

    // Prevent duplicate inventory items
    let selectedItemIds = [];

    function addRow(name='', price=0, categoryId='', stock=0, inventoryId=''){
        if(inventoryId && selectedItemIds.includes(inventoryId)){
            Swal.fire('Error','Item already added!','error');
            return;
        }

        let html = `<tr class="item-row" data-stock="${stock}" data-inventory="${inventoryId}">
            <td><select name="items[${rowIndex}][category_id]" class="form-select">${categoryOptions}</select></td>
            <td><input type="text" name="items[${rowIndex}][item_name]" class="form-control" value="${name}" required></td>
            <td><input type="number" name="items[${rowIndex}][qty]" class="form-control qty" value="1" min="1" required></td>
            <td><input type="number" name="items[${rowIndex}][unit_price]" class="form-control price" value="${price}" step="0.01" required></td>
            <td><input type="text" class="form-control total text-end" readonly value="${price}"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-times"></i></button></td>
        </tr>`;

        $('#itemsTable tbody').append(html);
        $('#emptyState').hide();
        if(categoryId){
            $(`select[name="items[${rowIndex}][category_id]"]`).val(categoryId);
        }
        if(inventoryId) selectedItemIds.push(inventoryId);
        rowIndex++;
        calculate();
    }

    // Manual add
    $('#addManualItem').click(()=>addRow());

    // Inventory select
    $('.select-inventory-item').click(function(){
        let btn = $(this);
        let row = btn.closest('tr');
        let name = btn.data('name');
        let price = parseFloat(btn.data('price'));
        let category = btn.data('category');
        let stock = parseInt(row.data('stock'));
        let id = btn.data('id');
        addRow(name, price, category, stock, id);
        $('#inventoryModal').modal('hide');
    });

    // Remove row
    $(document).on('click','.removeRow',function(){
        let row = $(this).closest('tr');
        let inventoryId = row.data('inventory');
        if(inventoryId){
            selectedItemIds = selectedItemIds.filter(i=>i!=inventoryId);
        }
        row.remove();
        if($('#itemsTable tbody tr').length===0) $('#emptyState').show();
        calculate();
    });

    // Quantity / price input change
    $(document).on('input','.qty, .price, #chargeAmount', calculate);

    function calculate(){
        let partsTotal = 0;
        $('.item-row').each(function(){
            let qty = parseFloat($(this).find('.qty').val())||0;
            let price = parseFloat($(this).find('.price').val())||0;
            let stock = parseInt($(this).data('stock'))||0;

            if(qty>stock && stock>0){
                Swal.fire('Error','Quantity exceeds available stock!','error');
                $(this).find('.qty').val(stock);
                qty=stock;
            }

            let total = qty*price;
            $(this).find('.total').val(total.toFixed(2));
            partsTotal += total;
        });
        let charge = parseFloat($('#chargeAmount').val())||0;
        let grandTotal = partsTotal + charge;
        $('#partsTotalDisplay').text(partsTotal.toFixed(2));
        $('#grandTotalDisplay').text(grandTotal.toFixed(2));
    }

    // Inventory search
    $('#inventorySearch').on('keyup',function(){
        var value = $(this).val().toLowerCase();
        $("#inventoryTableBody tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)
        });
    });

    // Form submit with inline validation
    $('#requisitionForm').on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        let valid = true;

        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();

        // Validate main fields
        form.find('[required]').each(function(){
            let el = $(this);
            if(!el.val()){
                valid = false;
                el.addClass('is-invalid');
                let msg = 'This field is required.';
                if(el.hasClass('select2-hidden-accessible')){
                    el.next('.select2-container').after('<div class="invalid-feedback d-block">'+msg+'</div>');
                } else el.after('<div class="invalid-feedback d-block">'+msg+'</div>');
            }
        });

        // Validate items
        if($('#itemsTable tbody tr').length===0){
            Swal.fire('Error','Please add at least one item.','error');
            valid=false;
        }

        if(!valid) return;

        let btn = $('#submitBtn');
        btn.prop('disabled',true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: form.attr('action'),
            method:'POST',
            data: form.serialize(),
            success:function(res){
                if(res.status==='success'){
                    Swal.fire({icon:'success',title:'Success',text:res.message,timer:1500,showConfirmButton:false})
                        .then(()=>window.location.href=res.redirect_url);
                } else {
                    Swal.fire('Error',res.message||'Something went wrong','error');
                    btn.prop('disabled',false).html('<i class="fa fa-save me-1"></i> Create Requisition');
                }
            },
            error:function(xhr){
                btn.prop('disabled',false).html('<i class="fa fa-save me-1"></i> Create Requisition');
                if(xhr.status===422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors,function(key,value){
                        let name = key.includes('.') ? key.replace(/\./g,'[')+']' : key;
                        let el = form.find(`[name="${name}"]`);
                        el.addClass('is-invalid');
                        let msg=value[0];
                        if(el.hasClass('select2-hidden-accessible')){
                            el.next('.select2-container').after('<div class="invalid-feedback d-block">'+msg+'</div>');
                        } else el.after('<div class="invalid-feedback d-block">'+msg+'</div>');
                    });
                } else {
                    Swal.fire('Error','An error occurred.','error');
                }
            }
        });
    });

    /* ================= EMAIL TO DEPARTMENT HEAD TOGGLE ================= */
    $('#sendEmailToHead').on('change', function() {
        if ($(this).is(':checked')) {
            $('#departmentHeadEmailSection').slideDown();
            fetchDepartmentHeadFromEmployee();
        } else {
            $('#departmentHeadEmailSection').slideUp();
            $('#departmentHeadEmailSection input').val('');
        }
    });

    // Fetch department head info when employee changes
    $('#employee_id').on('change', function() {
        if ($('#sendEmailToHead').is(':checked')) {
            fetchDepartmentHeadFromEmployee();
        }
    });

    function fetchDepartmentHeadFromEmployee() {
        var employeeId = $('#employee_id').val();
        console.log('Fetching for employee ID:', employeeId);
        
        if (employeeId) {
            // Use Laravel route helper
            var url = '{{ url("/admin/employees") }}/' + employeeId;
            console.log('Calling URL:', url);
            
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    console.log('Employee response:', res);
                    if (res.department_id) {
                        fetchDepartmentHeadInfo(res.department_id);
                    } else {
                        console.log('No department_id in response');
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr.status, xhr.statusText);
                }
            });
        }
    }

    function fetchDepartmentHeadInfo(departmentId) {
        var url = '{{ url("/admin/departments") }}/' + departmentId + '/head-info';
        console.log('Calling department URL:', url);
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                console.log('Department head response:', res);
                // Try multiple ways to set the value
                if (res.head_email) {
                    $('input[name="department_head_email"]').val(res.head_email);
                    console.log('Set email to:', res.head_email);
                }
            },
            error: function(xhr) {
                console.log('Error:', xhr.status, xhr.statusText);
            }
        });
    }

    // Initialize on page load
    if ($('#sendEmailToHead').is(':checked')) {
        $('#departmentHeadEmailSection').show();
        fetchDepartmentHeadFromEmployee();
    } else {
        $('#departmentHeadEmailSection').hide();
    }
});
</script>
@endsection
