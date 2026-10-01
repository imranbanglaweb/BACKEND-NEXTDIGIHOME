<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::active()->ordered()->get();
        return response()->json([
            'success' => true,
            'data' => $contactInfo,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string',
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

        $info = ContactInfo::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Contact info created successfully',
            'data' => $info,
        ], 201);
    }

    public function show(ContactInfo $contactInfo)
    {
        return response()->json([
            'success' => true,
            'data' => $contactInfo,
        ]);
    }

    public function update(Request $request, ContactInfo $contactInfo)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string',
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

        $contactInfo->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Contact info updated successfully',
            'data' => $contactInfo,
        ]);
    }

    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact info deleted successfully',
        ]);
    }

    public function getByType($type)
    {
        $contactInfo = ContactInfo::type($type)->active()->ordered()->get();
        return response()->json([
            'success' => true,
            'data' => $contactInfo,
        ]);
    }
}