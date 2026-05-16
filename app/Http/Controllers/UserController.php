<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Location;
use App\Models\SubscriptionPlan;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
   

        public function __construct()
        {
            $this->middleware('auth');
        }


    /* ------------------------------------------------------------------
        INDEX PAGE VIEW
    ------------------------------------------------------------------ */
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->pluck('name', 'name')->toArray();
        $userTypes = [
            'super_user' => 'Super User',
            'admin' => 'Admin',
            'normal_user' => 'Normal User',
            'department_head' => 'Department Head',
            'driver' => 'Driver',
            'maintenance_head' => 'Maintenance Head',
        ];
        return view('admin.dashboard.users.index', compact('roles', 'userTypes'));
    }

     /* ------------------------------------------------------------------
        DATATABLE SERVER-SIDE DATA
    ------------------------------------------------------------------ */
        public function getData(Request $request)
        {

            $users = User::with(['employee', 'department', 'unit', 'location', 'company', 'roles'])
                ->select([
                    'id',
                    'user_name',
                    'name',
                    'email',
                    'user_image',
                    'user_type',
                    'employee_id',
                    'department_id',
                    'unit_id',
                    'location_id',
                    'company_id'
                ]);

            // Advance Filters
            if ($request->filled('user_type_filter')) {
                $users->where('user_type', $request->user_type_filter);
            }

            if ($request->filled('role_filter')) {
                $users->whereHas('roles', function ($query) use ($request) {
                    $query->where('name', $request->role_filter);
                });
            }

            if ($request->filled('status_filter')) {
                $users->where('status', $request->status_filter);
            }

            if ($request->filled('search') && is_string($request->search)) {
                $search = $request->search;
                $users->where(function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('user_name', 'like', "%{$search}%");
                });
            }

            $users->orderBy('id', 'DESC');

            return DataTables::of($users)
                ->addIndexColumn() // DT_RowIndex

                ->editColumn('user_image', function ($row) {
                    $imagePath = public_path('admin_resource/assets/images/user_image/' . $row->user_image);
                    $imageUrl = asset('public/admin_resource/assets/images/user_image/default.jpg');

                    if (!empty($row->user_image) && file_exists($imagePath)) {
                        $imageUrl = asset('public/admin_resource/assets/images/user_image/' . $row->user_image);
                    }

                    return '<img src="'.$imageUrl.'" width="45" height="45"
                            class="rounded-circle"
                            onerror="this.onerror=null;this.src=\''.asset('public/admin_resource/assets/images/user_image/default.jpg').'\'">';
                })

                ->addColumn('user_type', function ($row) {
                    $userTypeLabels = [
                        'super_user' => '<span class="badge bg-dark">Super User</span>',
                        'admin' => '<span class="badge bg-primary">Admin</span>',
                        'normal_user' => '<span class="badge bg-info">Normal User</span>',
                        'department_head' => '<span class="badge bg-warning">Dept. Head</span>',
                        'driver' => '<span class="badge bg-secondary">Driver</span>',
                        'maintenance_head' => '<span class="badge bg-success">Maintenance Head</span>',
                    ];
                    return $userTypeLabels[$row->user_type] ?? '<span class="badge bg-light text-dark">'.$row->user_type.'</span>';
                })

                ->addColumn('roles', function ($row) {
                    $roles = $row->getRoleNames();
                    if ($roles->isNotEmpty()) {
                        return $roles->map(function($role) {
                            $badgeClass = match($role) {
                                'Super Admin' => 'bg-dark',
                                'Admin' => 'bg-primary',
                                'Department Head' => 'bg-warning',
                                'Transport' => 'info',
                                'Employee' => 'info',
                                'Driver' => 'secondary',
                                'Maintenance_Head' => 'success',
                                'Maintenance' => 'success',
                                default => 'light'
                            };
                            return '<span class="badge bg-'.$badgeClass.' me-1">'.$role.'</span>';
                        })->implode(' ');
                    }
                    return '<span class="text-muted">No Role</span>';
                })

                ->addColumn('email', function ($row) {
                    return $row->email;
                })

                ->addColumn('status', function ($row) {
                    if ($row->status =1) {
                        return '<span class="badge bg-success" style="font-size: 11px;"><i class="fa fa-check-circle me-1"></i> Active</span>';
                    }
                    return '<span class="badge bg-danger" style="font-size: 11px;"><i class="fa fa-times-circle me-1"></i>Inactive</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-danger deleteUser" data-id="'.$row->id.'">
                            <i class="fa fa-minus"></i>
                        </button>
                        <a href="'.route('users.edit',$row->id).'" class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i>
                        </a>
                    ';
                })

                ->rawColumns(['user_image','action','status','email','user_type','roles'])
                ->make(true);
        }


    /* ------------------------------------------------------------------
        CREATE VIEW
    ------------------------------------------------------------------ */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        $plans = SubscriptionPlan::where('is_active', 1)->orderBy('display_order')->get();

        return view('admin.dashboard.users.create', compact('roles', 'plans'));
    }

    /* ------------------------------------------------------------------
        STORE USER
    ------------------------------------------------------------------ */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type'   => 'required',
            'user_name'   => 'required',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|same:confirm-password',
            'roles'       => 'required',
            'user_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:8192',
        ]);

        if ($validator->fails()) {
            return response()->json(['success'=>false,'errors'=>$validator->errors()],422);
        }

        DB::beginTransaction();
        try {
            $userData = [
                'name'          => $request->user_name,
                'user_name'     => $request->user_name,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'user_type'     => $request->user_type,
                'role'          => $request->user_type, // Use user_type as role for simplicity
                'created_by'    => Auth::id(),
            ];


            if ($request->hasFile('user_image')) {
                $file = $request->file('user_image');

                $fileName = time().'_'.$file->getClientOriginalName();

                // Save to your correct path
                $file->move(
                    public_path('public/admin_resource/assets/images/user_image'),
                    $fileName
                );

                $userData['user_image'] = $fileName;
            }


            $user = User::create($userData);
            $user->assignRole($request->roles);

            // If user is department_head, update the department with this employee as head
            if ($request->user_type === 'department_head' && $request->head_department_id) {
                Department::where('id', $request->head_department_id)->update([
                    'head_employee_id' => $request->employee_id,
                ]);
            }

            DB::commit();
            return response()->json(['success'=>true,'message'=>'User created successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$e->getMessage()],500);
        }
    }

    /* ------------------------------------------------------------------
        EDIT USER
    ------------------------------------------------------------------ */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $employees = Employee::orderBy('employee_order','ASC')->get();
        $departments = Department::all();
        $units = Unit::all();
        $locations = Location::all();
        $plans = SubscriptionPlan::where('is_active', 1)->orderBy('display_order')->get();

        return view('admin.dashboard.users.edit', compact('user','roles','userRole','employees','departments','units','locations','plans'));
    }

    /* ------------------------------------------------------------------
        UPDATE USER
    ------------------------------------------------------------------ */
    public function update(Request $request, $id)
        {
            $user = User::findOrFail($id);

            // Validate
            $request->validate([
                // 'name' => 'required|string|max:255',
                'employee_id' => 'nullable',
                'user_type'   => 'required',
                'user_name'   => 'required|string|max:255',
                'email'       => "required|email|unique:users,email,$id",
                'phone'       => 'nullable|string|max:20',
                'roles'       => 'required',
                'password'    => 'nullable|min:6|same:confirm-password',
                'user_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            ]);

            // UPDATE FIELDS
                $user->employee_id = $request->employee_id;
                $user->user_type   = $request->user_type;
                $user->name        = $request->user_name;
                $user->email       = $request->email;
                $user->cell_phone       = $request->phone;


            $employee = Employee::find($request->employee_id);
                if ($employee) {
                    $user->department_id = $request->department_id ?: $employee->department_id;
                    $user->unit_id       = $request->unit_id ?: $employee->unit_id;
                    $user->location_id   = $request->location_id;
                    $user->user_name     = $employee->employee_code;
                }

                 // OPTIONAL PASSWORD UPDATE
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }

            // If new image uploaded
            if ($request->hasFile('user_image')) {

                // Delete old image if exists

                if ($user->user_image) {
                    $oldImagePath = public_path('admin_resource/assets/images/user_image/'.$user->user_image);

                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // SAVE NEW IMAGE
                $file = $request->file('user_image');
                $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(
                    public_path('admin_resource/assets/images/user_image'),
                    $fileName
                );

                $user->user_image = $fileName;
            }

            // Save updates
            $user->save();

            // UPDATE ROLE
            $user->syncRoles([$request->roles]);

            // If user is department_head, update the department with this employee as head
            if ($request->user_type === 'department_head' && $request->head_department_id) {
                Department::where('id', $request->head_department_id)->update([
                    'head_employee_id' => $request->employee_id,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully!'
            ]);
        }


    /* ------------------------------------------------------------------
        DELETE USER
    ------------------------------------------------------------------ */
        public function destroy($id)
        {
            $user = User::find($id);

            if (!$user) return response()->json(['error'=>'User not found'],404);

            if ($user->user_image) {
                $path = public_path('admin_resource/assets/images/user_image/'.$user->user_image);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $user->delete();

            return response()->json(['success'=>'User deleted successfully']);
        }

        public function show($id)
        {
           
        }

       public function userprofile()
        {
            $user = Auth::user();
            $roles = Role::pluck('name')->all();
            $userRole = $user->roles->pluck('name','name')->all();
            $employees = Employee::orderBy('employee_order','ASC')->get();

            // Get employee data if user has an employee profile
            $employee = null;
            if ($user->employee_id) {
                $employee = Employee::with(['department', 'unit', 'location', 'company'])
                    ->where('id', $user->employee_id)
                    ->first();
            }

            return view(
                'admin.dashboard.users.user-profile',
                compact('user','roles','userRole','employees','employee')
            );
        }
        public function updateProfile(Request $request)
            {
                $user = Auth::user();

                // VALIDATION - Make user_image optional and lenient
                $request->validate([
                    'user_name'  => 'required|string|max:255',
                    'email'      => 'required|email|unique:users,email,' . $user->id,
                    'phone'      => 'nullable|string|max:20',
                    'password'   => 'nullable|min:6|same:confirm-password',
                    'user_image' => 'nullable|image',
                ]);

                // BASIC UPDATE
                $user->name       = $request->user_name;
                $user->email      = $request->email;
                $user->cell_phone = $request->phone;

                // OPTIONAL PASSWORD UPDATE
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }

                // IMAGE UPDATE
                if ($request->hasFile('user_image')) {

                    // CREATE DIRECTORY IF NOT EXISTS
                    $uploadPath = public_path('admin_resource/assets/images/user_image');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    // DELETE OLD IMAGE
                    if (!empty($user->user_image)) {
                        $oldPath = public_path(
                            'admin_resource/assets/images/user_image/' . $user->user_image
                        );

                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }

                    // SAVE NEW IMAGE
                    $file = $request->file('user_image');
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    $file->move(
                        public_path('admin_resource/assets/images/user_image'),
                        $fileName
                    );

                    $user->user_image = $fileName;
                }

                $user->save();

                // UPDATE EMPLOYEE DATA
                if ($user->employee_id) {
                    $employee = \App\Models\Employee::find($user->employee_id);
                    if ($employee) {
                        // Update employee fields
                        if ($request->has('designation')) {
                            $employee->designation = $request->designation;
                        }
                        if ($request->has('phone')) {
                            $employee->phone = $request->phone;
                        }
                        if ($request->has('blood_group')) {
                            $employee->blood_group = $request->blood_group;
                        }
                        if ($request->has('nid')) {
                            $employee->nid = $request->nid;
                        }
                        if ($request->has('present_address')) {
                            $employee->present_address = $request->present_address;
                        }
                        if ($request->has('permanent_address')) {
                            $employee->permanent_address = $request->permanent_address;
                        }
                        
                        // Handle employee photo upload
                        if ($request->hasFile('employee_photo')) {
                            // Create directory if not exists
                            $uploadPath = public_path('uploads/employee');
                            if (!file_exists($uploadPath)) {
                                mkdir($uploadPath, 0755, true);
                            }
                            
                            // Delete old photo
                            if (!empty($employee->photo)) {
                                $oldPhotoPath = public_path('uploads/employee/' . $employee->photo);
                                if (file_exists($oldPhotoPath)) {
                                    unlink($oldPhotoPath);
                                }
                            }
                            
                            // Save new photo
                            $photoFile = $request->file('employee_photo');
                            $photoFileName = time() . '_' . uniqid() . '.' . $photoFile->getClientOriginalExtension();
                            $photoFile->move(public_path('uploads/employee'), $photoFileName);
                            $employee->photo = $photoFileName;
                        }
                        
                        $employee->save();
                    }
                }

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Profile updated successfully'
                ]);
            }
            public function profilepasswordupdate(Request $request)
            {

                $request->validate([
                    'password' => 'required|min:6|same:confirm-password',
                ]);

                $user = Auth::user();

                // UPDATE PASSWORD
                $user->password = Hash::make($request->password);
                $user->save();

                // FORCE LOGOUT (SECURITY)
                Auth::logout();

                // INVALIDATE SESSION
                $request->session()->invalidate();

                // REGENERATE CSRF TOKEN
                $request->session()->regenerateToken();

                return response()->json([
                    'status'   => 'logout',
                    'message'  => 'Password changed successfully. Please login again.',
                    'redirect' => route('login')   // ✅ route-based redirect
                ]);
            }



        /* ------------------------------------------------------------------
            GET EMPLOYEE DETAILS (for auto-populate)
        ------------------------------------------------------------------ */
        public function getEmployeeDetails($employeeId)
        {
            $employee = Employee::with(['company', 'department', 'unit', 'location'])
                ->find($employeeId);
            
            if ($employee) {
                return response()->json([
                    'success' => true,
                    'employee' => [
                        'id' => $employee->id,
                        'name' => $employee->name,
                        'email' => $employee->email ?? '',
                        'phone' => $employee->phone ?? '',
                        'company_id' => $employee->company_id,
                        'department_id' => $employee->department_id,
                        'unit_id' => $employee->unit_id,
                        'location_id' => $employee->location_id,
                    ]
                ]);
            }
            
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }
}