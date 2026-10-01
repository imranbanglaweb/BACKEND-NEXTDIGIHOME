<?php
    
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Yajra\DataTables\Facades\DataTables;   
use App\Services\MenuService;
use Carbon\Carbon;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('admin.dashboard.roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    
    public function data()
    {

        // dd('working');
        $roles = Role::select(['id', 'name', 'created_at']);

        return DataTables::of($roles)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)
                        ->format('d M Y, h:i A'); 
                    // Example: 21 Jan 2026, 10:35 PM
                })
            ->addColumn('actions', function ($row) {
                return '
                    <a href="'.route('admin.roles.show', $row->id).'" class="btn btn-sm btn-info" title="View">
                        <i class="fa fa-eye"></i>
                    </a>

                    <a href="'.route('admin.roles.edit', $row->id).'" class="btn btn-sm btn-primary" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>

                    <button class="btn btn-sm btn-danger deleteRole"
                            data-id="'.$row->id.'"
                            title="Delete">
                        <i class="fa fa-minus"></i>
                    </button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);

    }


    public function create()
    {
        
            $permission        = Permission::get();
            $table_lists = DB::table('permissions')
                 ->select('table_name','name', DB::raw('id as permission_id'))
                 ->get()
                  ->unique('table_name');

$general_permissions = DB::table('permissions')
                 ->select('table_name', DB::raw('id as permission_id'))
                 ->where('table_name',null)
                  ->whereNull('table_name')
                 ->get()
                  ->unique('table_name');

        return view('admin.dashboard.roles.create',compact('permission','table_lists','general_permissions'));
    
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));
        MenuService::clear();
        return redirect()->route('admin.roles.index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show(Role $role)
{
    $permissions = Permission::all();

    $groupedPermissions = $permissions->groupBy(function ($permission) {
        return $permission->table_name ?? 'general';
    });

    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('admin.dashboard.roles.show', compact(
        'role',
        'groupedPermissions',
        'rolePermissions'
    ));
}

    
 
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        // All permissions
        $permissions = Permission::orderBy('name')->get();

        // Group permissions by table_name (module)
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return $permission->table_name ?? 'general';
        });

        // Role assigned permissions
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.dashboard.roles.edit', compact(
            'role',
            'groupedPermissions',
            'rolePermissions'
        ));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,' . $id,
        'permissions' => 'required|array|min:1',
    ]);

    DB::beginTransaction();

    try {
        $role = Role::findOrFail($id);

        // Update role name
        $role->name = $request->name;
        $role->save();

        // Sync permissions
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        DB::commit();

        return response()->json([
            'status'  => true,
            'message' => 'Role updated successfully!'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong while updating the role.'
        ], 500);
    }
}
  public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
           'status'  => 'success',
            'message' => 'Role deleted successfully'
        ]);
    }

}