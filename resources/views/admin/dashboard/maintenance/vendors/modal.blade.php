
<div class="modal" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="vendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="vendorModalLabel">Add / Edit Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div id="errorAlert" class=""></div>

                <form id="vendorForm">
                    @csrf
                    <input type="hidden" name="vendor_id" id="vendor_id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Vendor Name</label>
                        <input type="text" name="vendor_name" id="vendor_name"
                               class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person"
                               class="form-control form-control-lg">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control form-control-lg">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone" id="phone"
                               class="form-control form-control-lg">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Address</label>
                        <textarea name="address" id="address" rows="2" class="form-control form-control-lg"></textarea>
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
            </div>

        </div>
    </div>
</div>
