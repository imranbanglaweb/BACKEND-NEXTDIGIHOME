<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupportCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:support-manage');
    }

    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = SupportCategory::orderBy('sort_order')->get();

        return view('admin.support.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.support.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:support_categories',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate slug if not provided
        $slug = $request->slug ?: Str::slug($request->name);

        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while (SupportCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        SupportCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'icon' => $request->icon,
            'is_active' => $request->is_active ?? true,
            'sort_order' => $request->sort_order ?? 0,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.support.categories.index')
            ->with('success', 'Support category created successfully.');
    }

    /**
     * Display the specified category
     */
    public function show(SupportCategory $category)
    {
        $category->load(['creator', 'updater', 'tickets']);
        return view('admin.support.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the category
     */
    public function edit(SupportCategory $category)
    {
        return view('admin.support.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, SupportCategory $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:support_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate slug if not provided
        $slug = $request->slug ?: Str::slug($request->name);

        // Ensure slug is unique (excluding current category)
        $originalSlug = $slug;
        $counter = 1;
        while (SupportCategory::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'icon' => $request->icon,
            'is_active' => $request->is_active ?? true,
            'sort_order' => $request->sort_order ?? 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.support.categories.index')
            ->with('success', 'Support category updated successfully.');
    }

    /**
     * Remove the specified category
     */
    public function destroy(SupportCategory $category)
    {
        // Check if category has tickets
        if ($category->tickets()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with existing tickets. Please reassign tickets first.');
        }

        $category->delete();

        return redirect()->route('admin.support.categories.index')
            ->with('success', 'Support category deleted successfully.');
    }

    /**
     * Toggle category active status
     */
    public function toggleStatus(SupportCategory $category)
    {
        $category->update([
            'is_active' => !$category->is_active,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()
            ->with('success', 'Category status updated successfully.');
    }
}