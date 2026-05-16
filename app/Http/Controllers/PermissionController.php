<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
// use Yajra\DataTables\DataTables as DataTablesDataTables;
use \DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\Exports\ExportLandinventory;
Use \Carbon\Carbon;
Use Redirect;
Use Session;
use DataTables;
use Illuminate\Support\Str;
class PermissionController extends Controller
{
    
        public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        // $permissions = Permission::all();
        return view('admin.dashboard.permission.index');


    }
            public function list(Request $request)
{
    $query = Permission::query();
    
    // Handle search
    if ($request->has('search') && !empty($request->search['value'])) {
        $search = $request->search['value'];
        $query->where('name', 'like', '%' . $search . '%');
    }

    return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function($row) {
            $actionBtn = '';
            
            // Edit button - Always show for testing, then add permission check
            if (true) { // Change to: if(auth()->user()->can('permission-edit'))
                $actionBtn .= '<a href="' . route('admin.permissions.edit', $row->id) . '" class="btn btn-primary btn-sm me-1">';
                $actionBtn .= '<i class="fa fa-edit"></i>';
                $actionBtn .= '</a> ';
            }
            
            // Delete button
            if (true) { // Change to: if(auth()->user()->can('permission-delete'))
                $actionBtn .= '<button type="button" class="btn btn-danger btn-sm delete-btn" data-url="' . route('admin.permissions.destroy', $row->id) . '">';
                $actionBtn .= '<i class="fa fa-minus-circle"></i>';
                $actionBtn .= '</button>';
            }
            
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
}

    public function create(Request $request)
    {



         $permission = Permission::get();
        return view('admin.dashboard.permission.create',compact('permission'));
    }

  public function validatePermission(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    // Check if permission name already exists
    $exists = Permission::where(
        'name',
        Str::of($request->name)->lower()->replace(' ', '-')
    )->exists();

    if ($exists) {
        return response()->json([
            'valid' => false,
            'message' => 'Permission name already exists. Please choose a different name.'
        ]);
    }

    // Check if name follows convention (optional)
    if (!preg_match('/^[a-z-]+$/', $request->name)) {
        return response()->json([
            'valid' => false,
            'message' => 'Permission name should contain only lowercase letters and hyphens.'
        ]);
    }

    return response()->json([
        'valid' => true,
        'message' => 'Permission name is available.'
    ]);
}
    
public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'table_name'  => 'nullable|string|max:255',
        'key'         => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Normalize name (lowercase + hyphen)
    $name = Str::of($request->name)
        ->lower()
        ->replace(' ', '-');

    // DUPLICATE CHECK (FINAL GUARD)
    if (Permission::where('name', $name)->exists()) {
        return response()->json([
            'status'  => false,
            'message' => 'This permission already exists!'
        ], 422);
    }

    DB::beginTransaction();

    try {
        Permission::create([
            'name'        => $name,
            'table_name'  => $request->table_name,
            'key'         => $request->key,
            'description' => $request->description,
            'guard_name'  => 'web',
        ]);

        DB::commit();

        return response()->json([
            'status'  => true,
            'message' => 'Permission created successfully!'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status'  => false,
            'message' => 'Failed to create permission.'
        ], 500);
    }
}
        


    public function edit(Permission $permission)
    {
        return view('admin.dashboard.permission.edit', compact('permission'));
    }
   
   // Update permission
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'key' => 'nullable|string',
            'table_name' => 'nullable|string',
            'description' => 'nullable|string',
            'is_user_defined' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $permission->update([
            'name' => $request->name,
            'key' => $request->key,
            'table_name' => $request->table_name,
            'description' => $request->description,
            'is_user_defined' => $request->has('is_user_defined') ? 1 : 0,
        ]);

        return response()->json(['message'=>'Permission updated successfully!']);
    }

         public function destroy($id)
        {

            // dd($id);
            $permission = Permission::findOrFail($id);
            $permission->delete();

             return response()->json([
                    'success' => 'Permission deleted successfully'
                ]);
        }
    
  
}
