<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageContents = PageContent::orderBy('page')
            ->orderBy('sort_order')
            ->paginate(15);

        return view('admin.pages.index', compact('pageContents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'page' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_text' => 'nullable|string|max:255',
            'link_url' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/pages'), $imageName);
            $data['image'] = 'images/pages/' . $imageName;
        }

        PageContent::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PageContent $pageContent)
    {
        return view('admin.pages.show', compact('pageContent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PageContent $pageContent)
    {
        return view('admin.pages.edit', compact('pageContent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PageContent $pageContent)
    {
        $request->validate([
            'page' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_text' => 'nullable|string|max:255',
            'link_url' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($pageContent->image && file_exists(public_path($pageContent->image))) {
                unlink(public_path($pageContent->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/pages'), $imageName);
            $data['image'] = 'images/pages/' . $imageName;
        }

        $pageContent->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageContent $pageContent)
    {
        // Delete image file
        if ($pageContent->image && file_exists(public_path($pageContent->image))) {
            unlink(public_path($pageContent->image));
        }

        $pageContent->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page content deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(PageContent $pageContent)
    {
        $pageContent->update(['is_active' => !$pageContent->is_active]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}