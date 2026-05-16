<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::active()->ordered()->get();
        return response()->json([
            'success' => true,
            'data' => $sliders,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
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
            $imagePath = $request->file('image')->store('hero-sliders', 'public');
            $data['image'] = $imagePath;
        }

        $slider = HeroSlider::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Hero slider created successfully',
            'data' => $slider,
        ], 201);
    }

    public function show(HeroSlider $heroSlider)
    {
        return response()->json([
            'success' => true,
            'data' => $heroSlider,
        ]);
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
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
            if ($heroSlider->image && Storage::disk('public')->exists($heroSlider->image)) {
                Storage::disk('public')->delete($heroSlider->image);
            }

            $imagePath = $request->file('image')->store('hero-sliders', 'public');
            $data['image'] = $imagePath;
        }

        $heroSlider->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Hero slider updated successfully',
            'data' => $heroSlider,
        ]);
    }

    public function destroy(HeroSlider $heroSlider)
    {
        // Delete image if exists
        if ($heroSlider->image && Storage::disk('public')->exists($heroSlider->image)) {
            Storage::disk('public')->delete($heroSlider->image);
        }

        $heroSlider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero slider deleted successfully',
        ]);
    }
}