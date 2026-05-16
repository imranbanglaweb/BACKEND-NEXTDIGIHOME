<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PageContentController extends Controller
{
    public function index(Request $request)
    {
        $query = PageContent::active();

        if ($request->has('page')) {
            $query->where('page', $request->page);
        }

        if ($request->has('section')) {
            $query->where('section', $request->section);
        }

        $contents = $query->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => $contents,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|string|max:50',
            'section' => 'required|string|max:50',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_text' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('page-content', 'public');
            $data['image'] = $imagePath;
        }

        $content = PageContent::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Page content created successfully',
            'data' => $content,
        ], 201);
    }

    public function show(PageContent $pageContent)
    {
        return response()->json([
            'success' => true,
            'data' => $pageContent,
        ]);
    }

    public function update(Request $request, PageContent $pageContent)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|string|max:50',
            'section' => 'required|string|max:50',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_text' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($pageContent->image && Storage::disk('public')->exists($pageContent->image)) {
                Storage::disk('public')->delete($pageContent->image);
            }

            $imagePath = $request->file('image')->store('page-content', 'public');
            $data['image'] = $imagePath;
        }

        $pageContent->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Page content updated successfully',
            'data' => $pageContent,
        ]);
    }

    public function destroy(PageContent $pageContent)
    {
        // Delete image if exists
        if ($pageContent->image && Storage::disk('public')->exists($pageContent->image)) {
            Storage::disk('public')->delete($pageContent->image);
        }

        $pageContent->delete();

        return response()->json([
            'success' => true,
            'message' => 'Page content deleted successfully',
        ]);
    }

    public function getByPage($page)
    {
        $contents = PageContent::page($page)->active()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => $contents,
        ]);
    }

    public function getBySection($page, $section)
    {
        $contents = PageContent::page($page)->section($section)->active()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => $contents,
        ]);
    }
}