@forelse($projects as $project)
<tr id="project-{{ $project->id }}">
    <td>{{ $project->id }}</td>
    <td>{{ $project->project_name }}</td>
    <td>{{ optional($project->starting_date)->format('d M Y') ?? '-' }}</td>
    <td>{{ optional($project->ending_date)->format('d M Y') ?? '-' }}</td>
    <td>
        <span class="badge badge-{{ strtolower($project->status) === 'active' ? 'success' : (strtolower($project->status) === 'completed' ? 'primary' : 'warning') }}">
            {{ ucfirst($project->status) }}
        </span>
    </td>
    <td>
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm" onclick="viewProject({{ $project->id }})">
                <i class="fa fa-eye"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" onclick="editProject({{ $project->id }})">
                <i class="fa fa-pencil"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteProject({{ $project->id }})">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">No projects found</td>
</tr>
@endforelse 