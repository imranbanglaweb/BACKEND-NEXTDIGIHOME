<div class="btn-group btn-group-sm">
    <a href="{{ route('menus.show', $menu) }}" class="btn btn-info" title="View">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('menus.edit', $menu) }}" class="btn btn-warning" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Are you sure you want to delete this menu?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>