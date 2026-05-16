<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="from_date" class="form-control">
    </div>
    <div class="col-md-3">
        <input type="date" name="to_date" class="form-control">
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            <option value="0">Pending</option>
            <option value="1">Approved</option>
            <option value="2">Rejected</option>
        </select>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('reports.requisitions.pdf') }}" class="btn btn-danger">
            Export PDF
        </a>
        <a href="{{ route('reports.requisitions.excel') }}" class="btn btn-success">
            Export Excel
        </a>
    </div>
</form>
