<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_slug' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $category = Category::create([
            'category_name' => $request->category_name,
            'category_slug' => $request->category_slug ?: Str::slug($request->category_name),
            'status' => $request->status ?? 1,
            'created_by' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully.',
                'category' => $category
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_slug' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $category->update([
            'category_name' => $request->category_name,
            'category_slug' => $request->category_slug ?: Str::slug($request->category_name),
            'status' => $request->status ?? $category->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully.',
                'category' => $category
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Get categories data for DataTables AJAX request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        \Log::info('Categories getData called', $request->all());

        $categories = Category::query();

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $categories->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $categories->where(function($query) use ($search) {
                $query->where('category_name', 'like', '%' . $search . '%')
                      ->orWhere('category_slug', 'like', '%' . $search . '%');
            });
        }

        // Ordering
        if ($request->has('order')) {
            $columnIndex = $request->order[0]['column'];
            $direction = $request->order[0]['dir'];

            $columns = ['id', 'category_name', 'category_slug', 'status', 'created_at'];
            if (isset($columns[$columnIndex])) {
                $categories->orderBy($columns[$columnIndex], $direction);
            }
        } else {
            $categories->orderBy('category_name');
        }

        $totalRecords = $categories->count();

        // Pagination
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $categories = $categories->skip($start)->take($length)->get();

        \Log::info('Categories found:', ['count' => $categories->count()]);

        $data = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'category_name' => $category->category_name,
                'category_slug' => $category->category_slug,
                'status' => $category->status,
                'created_at' => $category->created_at->format('Y-m-d H:i:s'),
                'actions' => '
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-warning btn-sm edit-category" data-id="' . $category->id . '" data-name="' . $category->category_name . '" data-slug="' . $category->category_slug . '" data-status="' . $category->status . '" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-category" data-id="' . $category->id . '" data-name="' . $category->category_name . '" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                ',
            ];
        });

        \Log::info('Returning categories data:', [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data_count' => count($data)
        ]);

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }

    /**
     * Toggle category status
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->status = !$category->status;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category status updated successfully.',
            'status' => $category->status
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.'
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
