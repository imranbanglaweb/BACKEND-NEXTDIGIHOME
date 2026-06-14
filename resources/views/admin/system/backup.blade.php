@extends('admin.dashboard.master')

@section('title', 'Backup & Restore')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div><div class="premium-eyebrow">System</div><h2>Backup</h2><p>Create, download, and remove database backup files.</p></div>
            <div class="premium-actions"><form action="{{ route('admin.system.backup.create') }}" method="POST">@csrf<button type="submit" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Create Backup</button></form></div>
        </div>
        <div class="premium-nav"><a href="{{ route('admin.system.info') }}">Info</a><a href="{{ route('admin.system.logs') }}">Logs</a><a href="{{ route('admin.system.cache') }}">Cache</a><a href="{{ route('admin.system.backup') }}" class="active">Backup</a><a href="{{ route('admin.system.api') }}">API</a></div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        <div class="row g-3 mb-3">
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-blue"><i class="fas fa-database"></i></span><div><small>Total Backups</small><strong>{{ number_format(count($backups)) }}</strong></div></div></div>
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-green"><i class="fas fa-clock"></i></span><div><small>Latest Backup</small><strong>{{ count($backups) ? $backups[0]['modified'] : 'None' }}</strong></div></div></div>
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-amber"><i class="fas fa-folder"></i></span><div><small>Storage</small><strong>storage/backups</strong></div></div></div>
        </div>
        <div class="premium-card">
            <div class="premium-card-title"><div><h5>Backup Files</h5><p>Download verified files before deleting older backups.</p></div></div>
            @if(empty($backups))
                <div class="text-center premium-muted py-5"><i class="fas fa-database fa-3x mb-3"></i><p>No backups found.</p></div>
            @else
                <div class="table-responsive"><table class="table premium-table"><thead><tr><th>Filename</th><th>Size</th><th>Created</th><th>Actions</th></tr></thead><tbody>
                    @foreach($backups as $backup)
                        <tr><td><i class="fas fa-file-code text-primary me-2"></i>{{ $backup['name'] }}</td><td>{{ $backup['size'] }}</td><td>{{ $backup['modified'] }}</td><td><a href="{{ route('admin.system.backup.download', $backup['name']) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a> <button type="button" class="btn btn-sm btn-danger" onclick="deleteBackup('{{ $backup['name'] }}')"><i class="fas fa-trash"></i></button></td></tr>
                    @endforeach
                </tbody></table></div>
            @endif
        </div>
    </div>
</section>
<div class="modal fade" id="deleteBackupModal" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Delete Backup</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><div class="modal-body"><p>Delete this backup?</p><p class="text-danger fw-bold" id="deleteBackupName"></p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><form id="deleteBackupForm" method="POST">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Delete Backup</button></form></div></div></div></div>
<script>function deleteBackup(filename){document.getElementById('deleteBackupName').textContent=filename;document.getElementById('deleteBackupForm').action='{{ url("admin/system/backup") }}/'+filename;$('#deleteBackupModal').modal('show');}</script>
@endsection
