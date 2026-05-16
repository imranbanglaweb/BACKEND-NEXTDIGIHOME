<div class="modal-header">
    <h5 class="modal-title">View Project</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Project Name</th>
                    <td>{{ $project->project_name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{!! $project->project_description !!}</td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>{{ optional($project->starting_date)->format('d M Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td>{{ optional($project->ending_date)->format('d M Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge badge-{{ $project->status === 'active' ? 'success' : ($project->status === 'completed' ? 'primary' : 'warning') }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="editProject({{ $project->id }})">
        <i class="fa fa-pencil"></i> Edit
    </button>
</div> 