<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportCategory;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KnowledgeBaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:support-manage');
    }

    /**
     * Display a listing of knowledge base articles
     */
    public function index()
    {
        $articles = KnowledgeBase::with(['category', 'creator'])
            ->latest()
            ->paginate(15);

        return view('admin.support.knowledge-base.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        $categories = SupportCategory::active()->orderBy('sort_order')->get();
        return view('admin.support.knowledge-base.create', compact('categories'));
    }

    /**
     * Store a newly created article
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:knowledge_bases',
            'content' => 'required|string',
            'category_id' => 'required|exists:support_categories,id',
            'is_published' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate slug if not provided
        $slug = $request->slug ?: Str::slug($request->title);

        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while (KnowledgeBase::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        KnowledgeBase::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->is_published ?? false,
            'tags' => $request->tags,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.support.knowledge-base.index')
            ->with('success', 'Knowledge base article created successfully.');
    }

    /**
     * Display the specified article
     */
    public function show(KnowledgeBase $article)
    {
        $article->load(['category', 'creator', 'updater']);
        return view('admin.support.knowledge-base.show', compact('article'));
    }

    /**
     * Show the form for editing the article
     */
    public function edit(KnowledgeBase $article)
    {
        $categories = SupportCategory::active()->orderBy('sort_order')->get();
        return view('admin.support.knowledge-base.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified article
     */
    public function update(Request $request, KnowledgeBase $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:knowledge_bases,slug,' . $article->id,
            'content' => 'required|string',
            'category_id' => 'required|exists:support_categories,id',
            'is_published' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate slug if not provided
        $slug = $request->slug ?: Str::slug($request->title);

        // Ensure slug is unique (excluding current article)
        $originalSlug = $slug;
        $counter = 1;
        while (KnowledgeBase::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $article->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->is_published ?? false,
            'tags' => $request->tags,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.support.knowledge-base.show', $article)
            ->with('success', 'Knowledge base article updated successfully.');
    }

    /**
     * Remove the specified article
     */
    public function destroy(KnowledgeBase $article)
    {
        $article->delete();

        return redirect()->route('admin.support.knowledge-base.index')
            ->with('success', 'Knowledge base article deleted successfully.');
    }

    /**
     * Toggle article published status
     */
    public function togglePublished(KnowledgeBase $article)
    {
        $article->update([
            'is_published' => !$article->is_published,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()
            ->with('success', 'Article status updated successfully.');
    }
}