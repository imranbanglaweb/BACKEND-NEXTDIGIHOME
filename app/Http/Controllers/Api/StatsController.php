<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatsController extends Controller
{
    public function index()
    {
        $stats = Stat::active()->ordered()->get();
        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|max:50|unique:stats',
            'value' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
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

        $stat = Stat::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Stat created successfully',
            'data' => $stat,
        ], 201);
    }

    public function show(Stat $stat)
    {
        return response()->json([
            'success' => true,
            'data' => $stat,
        ]);
    }

    public function update(Request $request, Stat $stat)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|max:50|unique:stats,key,' . $stat->id,
            'value' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
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

        $stat->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Stat updated successfully',
            'data' => $stat,
        ]);
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stat deleted successfully',
        ]);
    }
}