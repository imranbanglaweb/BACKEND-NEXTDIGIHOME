<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Category;
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
use Yajra\DataTables\Facades\DataTables;
use \DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\Exports\ExportLandinventory;
Use \Carbon\Carbon;
Use Redirect;
Use Session;
use App\Exports\EmployeeExport;
use App\Imports\CategoryeeImport;
use App\Imports\UserImport;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        //  $categories = DB::table('categories')
        //         ->select('categories.id as c_id','categories.parent_id','categories.category_name','departments.department_name')
        //         ->leftJoin('departments','departments.id','=','categories.department_id')
        //         ->get();
        //  $departments = Department::orderBy('id','desc')->get();
        // return view('admin.dashboard.category.index',compact('categories','departments'));

   // $departments = Department::orderBy('id','ASC')->get();
            // $project_lists = DB::table('projects')
            //             ->select('projects.id as p_id','projects.project_name','projects.project_description','companies.company_name','units.unit_name')
            //             ->leftJoin('units','projects.unit_id','=','units.id')
            //             ->leftJoin('companies','projects.company_id','=','companies.id')
            //             ->get();


      $location_lists = DB::table('locations')->get();
      $department_lists = DB::table('departments')->get();

    //   $location_assigned = DB::table('locations')
    // ->whereIn('id',$location_list_by_employee)
    // ->get();

    //   $department_assigned = DB::table('departments')
    // ->whereIn('id',$department_list_by_employee)
    // ->get();


$user_type_admin = DB::table('users')->select('user_type','id')
->where('id',Auth::id())
->where('user_type','admin')
->first();

$user_type_department_head = DB::table('users')->select('user_type','id')
->where('id',Auth::id())
->where('user_type','department_head')
->first();


// return dd($user_type_admin->user_type);

  if ($request->ajax()) {


    if (!empty($user_type_admin)) {

        $data = Category::select(
                [
                  'categories.id',
                  'categories.category_name',
                  'categories.category_slug',
                  'categories.status',
                  'categories.created_at',
                  'categories.unit_id',
                  'categories.department_id',
                  'categories.location_id',
                 ]
             )
// return dd('yah');
            // ->where('assign_task_status',Auth::id())
            ->orderBy('categories.id','desc')
            ->get();
    }


    else if (!empty($user_type_department_head)) {

  $data = Category::select(
               [
                 'categories.id',
                 'categories.category_name',
                 'categories.unit_id',
                 'categories.department_id',
                 'categories.location_id',
                ]
            )

            ->where('categories.department_id',Auth::user()->department_id)
            ->orderBy('categories.id','desc')
            ->get();

    }

    else{
  $data = Category::select(
               [
                 'categories.id',
                 'categories.category_name',
                 'categories.unit_id',
                 'categories.department_id',
                 'categories.location_id',
                ]
            )

            ->where('categories.department_id',Auth::user()->department_id)
            ->where('categories.created_by',Auth::id())
            ->orderBy('categories.id','desc')
            ->get();
    }
          
            return Datatables::of($data)
                    ->addIndexColumn()
          
               ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('created_by') && $request->get('created_by') !='all')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['created_by'], $request->get('created_by')) ? true : false;
                            });
                        }

                       // else if (!empty($request->get('created_by') =='all')) {
                       //      $instance->collection = $instance->collection->filter(function ($row) use ($request) {

                       //          return Str::contains($row['created_by'], ) ? true : false;
                       //      });
                       //  }

                      

                    })


              
                ->addColumn('actions', function($row){
                     $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">Edit</a>';
                     return $btn;
                 })

                 // ->addColumn('department_name', function (Category $categories) {
                 //         return $categories->departmentName->department_name;
                 //    })
              
                  
                ->rawColumns(['actions','changed_status','view','created_by','department_name'])
                ->make(true);
        }

        return view('admin.categories.index',
          compact('location_lists','department_lists')
              );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $categories  = Category::get();
         $departments = Department::orderBy('id','desc')->get();
        return view('admin.dashboard.category.create',compact('categories','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
                    "category_name" => "required",
        ]);

        if ($validator->fails()) {
              return redirect()->back()->withErrors($validator->errors());
            // return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        try {

            DB::beginTransaction();
            $user = Auth::user();
            $category_name = $request->category_name;
           
            if (!empty($category_name)) {
            // dd($request);

            // Menu entry

            $category = new Category();
            $category->category_name     = $request->category_name;
            $category->parent_id     = $request->parent_id;
            $category->department_id     = $request->d_id;
            $category->category_slug = \Str::slug($request->category_name);;
            $category->created_by    = $user->id;
            $category->save();

            }
           
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            return response()->json(['errors' => array($exception->getMessage().__('try_again'))], 422);
        }
   
        return redirect()->route('categories.index')
                        ->with('success','Category Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }


       public function export() 
    {

          $employee_lists = DB::table('employees')
                        ->select(
                            'employees.id as emp_id',
                            'employees.employee_id',
                            'employees.employee_name',
                            'employees.unit_id',
                            'employees.department_id',
                            'employees.location_id',
                            'locations.id',
                            'locations.location_name',
                            'units.id',
                            'units.unit_name'
                        )
                        ->leftJoin('units','units.id','=','employees.unit_id')
                        ->leftJoin('locations','locations.id','=','employees.location_id')
                        ->get();
                
        // return Excel::download(new EmployeeExport, 'employee_lists.xlsx');
        return Excel::download(new EmployeeExport($employee_lists), 'employee_lists.xlsx');
          // return back();
    }
     

    public function import() 
    {
        Excel::import(new CategoryeeImport,request()->file('file'));
             
        return back();
    }


    // importuser
    public function importuser() 
    {
        Excel::import(new UserImport,request()->file('file'));
             
        return back();
    }
}
