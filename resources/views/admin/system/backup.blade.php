@extends('admin.dashboard.master')

@section('title', 'Backup & Restore')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-save"></i> Database Backup & Restore
                    </h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.system.backup.create') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Create Backup
                            </button>
                        </form>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Backup Information -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Backup Information:</strong> Regular backups are essential for data safety.
                        The system creates database backups that can be downloaded or restored when needed.
                    </div>

                    <!-- Existing Backups -->
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-list"></i> Existing Backups
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(empty($backups))
                                <div class="text-center text-muted">
                                    <i class="fas fa-database fa-3x mb-3"></i>
                                    <p>No backups found. Create your first backup to get started.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Filename</th>
                                                <th>Size</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($backups as $backup)
                                            <tr>
                                                <td>
                                                    <i class="fas fa-file-code text-primary"></i>
                                                    {{ $backup['name'] }}
                                                </td>
                                                <td>{{ $backup['size'] }}</td>
                                                <td>{{ $backup['modified'] }}</td>
                                                <td>
                                                    <a href="{{ route('admin.system.backup.download', $backup['name']) }}"
                                                       class="btn btn-sm btn-success"
                                                       title="Download Backup">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="deleteBackup('{{ $backup['name'] }}')"
                                                            title="Delete Backup">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Backup Settings -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card card-outline card-warning">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-cog"></i> Backup Settings
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="backup_type">Backup Type</label>
                                        <select class="form-control" id="backup_type" disabled>
                                            <option value="database" selected>Database Only</option>
                                            <option value="full">Full Application</option>
                                        </select>
                                        <small class="form-text text-muted">
                                            Currently supports database backups only.
                                        </small>
                                    </div>

                                    <div class="form-group">
                                        <label for="auto_backup">Auto Backup</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="auto_backup" disabled>
                                            <label class="custom-control-label" for="auto_backup">
                                                Enable automatic daily backups
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            Feature coming soon.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-exclamation-triangle"></i> Important Notes
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success"></i>
                                            Backups contain sensitive data - store securely
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success"></i>
                                            Test restore procedures regularly
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success"></i>
                                            Keep multiple backup versions
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                            Large databases may take time to backup
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-times-circle text-danger"></i>
                                            Do not delete recent backups without verification
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Requirements -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-server"></i> System Requirements
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Required for Database Backup:</h6>
                                            <ul>
                                                <li><code>mysqldump</code> command available</li>
                                                <li>Write permissions to <code>storage/backups/</code></li>
                                                <li>Sufficient disk space</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Backup Storage:</h6>
                                            <p>Backups are stored in: <code>storage/backups/</code></p>
                                            <p>Make sure this directory has proper permissions and is included in your backup strategy.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> Last backup check: {{ now()->format('Y-m-d H:i:s') }}
                        | Total backups: {{ count($backups) }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Backup Modal -->
<div class="modal fade" id="deleteBackupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Backup</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this backup?</p>
                <p class="text-danger"><strong>This action cannot be undone!</strong></p>
                <p id="deleteBackupName"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteBackupForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Backup</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteBackup(filename) {
    document.getElementById('deleteBackupName').textContent = filename;
    document.getElementById('deleteBackupForm').action = '{{ url("admin/system/backup") }}/' + filename;
    $('#deleteBackupModal').modal('show');
}
</script>
@endsection