<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $inquiries = ProjectInquiry::latest()->paginate(25);
        return response()->json([
            'success' => true,
            'data' => $inquiries,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:50',
            'company' => 'nullable|string|max:150',
            'service' => 'required|string|max:150',
            'budget' => 'nullable|string|max:100',
            'timeline' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $inquiry = ProjectInquiry::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'company' => $request->input('company'),
                'service' => $request->input('service'),
                'budget' => $request->input('budget'),
                'timeline' => $request->input('timeline'),
                'message' => $request->input('message'),
                'status' => 'new',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            Log::info("New project inquiry received from: {$inquiry->name} ({$inquiry->email}) for service: {$inquiry->service}");

            return response()->json([
                'success' => true,
                'message' => 'Your project inquiry has been received. Our solutions team will contact you within 24 hours.',
                'data' => $inquiry,
            ], 201);
        } catch (\Exception $e) {
            Log::error("Failed to save project inquiry: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process inquiry. Please contact us directly via WhatsApp or email.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $inquiry = ProjectInquiry::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $inquiry,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_review,contacted,closed',
        ]);

        $inquiry = ProjectInquiry::findOrFail($id);
        $inquiry->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry status updated successfully',
            'data' => $inquiry,
        ]);
    }
}
