<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;

class HeroSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroSliders = HeroSlider::orderBy('sort_order')->paginate(15);

        return view('admin.hero-sliders.index', compact('heroSliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero-sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/hero-sliders'), $imageName);
            $data['image'] = 'images/hero-sliders/'.$imageName;
        }

        HeroSlider::create($data);

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero slider created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.show', compact('heroSlider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.edit', compact('heroSlider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroSlider $heroSlider)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($heroSlider->image && file_exists(public_path($heroSlider->image))) {
                unlink(public_path($heroSlider->image));
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/hero-sliders'), $imageName);
            $data['image'] = 'images/hero-sliders/'.$imageName;
        }

        $heroSlider->update($data);

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSlider $heroSlider)
    {
        // Delete image file
        if ($heroSlider->image && file_exists(public_path($heroSlider->image))) {
            unlink(public_path($heroSlider->image));
        }

        $heroSlider->delete();

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero slider deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(HeroSlider $heroSlider)
    {
        $heroSlider->update(['is_active' => ! $heroSlider->is_active]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
