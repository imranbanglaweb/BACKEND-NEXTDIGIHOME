@extends('admin.dashboard.master')
@section('title', 'Projects')

@section('main_content')
<div class="content-header">
    <div class="container-fluid content-body">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Projects</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Projects</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
   <section role="main" class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Project List</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" onclick="createProject()">
                                <i class="fa fa-plus"></i> Add New Project
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert-container"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('admin.dashboard.projects.table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>

@push('scripts')
<script>
function createProject() {
    $.ajax({
        url: "{{ route('projects.create') }}",
        type: 'GET',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#projectModal .modal-content').html(response.view);
                $('#projectModal').modal('show');
            } else {
                showAlert('error', response.message || 'Error loading form');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading form: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

function editProject(id) {
    $.ajax({
        url: "{{ url('projects') }}/" + id + "/edit",
        type: 'GET',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            $('#projectModal .modal-content').html(response.view);
            $('#projectModal').modal('show');
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading project: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

function deleteProject(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('projects') }}/" + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        $('#project-' + id).remove();
                    } else {
                        showAlert('error', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    showAlert('error', 'Error deleting project: ' + error);
                }
            });
        }
    });
}

function showAlert(type, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    Toast.fire({
        icon: type,
        title: message
    });
}

function viewProject(id) {
    $.ajax({
        url: "{{ url('projects') }}/" + id,
        type: 'GET',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#projectModal .modal-content').html(response.view);
                $('#projectModal').modal('show');
            } else {
                showAlert('error', response.message || 'Error loading project');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading project: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

// Add this to handle modal cleanup
$('#projectModal').on('hidden.bs.modal', function () {
    $(this).find('.modal-content').html('');
});
</script>
@endpush
@endsection 