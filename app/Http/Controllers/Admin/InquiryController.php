<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectInquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of project inquiries.
     */
    public function index(Request $request)
    {
        $query = ProjectInquiry::query();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('service', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $counts = [
            'all' => ProjectInquiry::count(),
            'new' => ProjectInquiry::where('status', 'new')->count(),
            'in_review' => ProjectInquiry::where('status', 'in_review')->count(),
            'contacted' => ProjectInquiry::where('status', 'contacted')->count(),
            'closed' => ProjectInquiry::where('status', 'closed')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts'));
    }

    /**
     * Display the specified inquiry.
     */
    public function show($id)
    {
        $inquiry = ProjectInquiry::findOrFail($id);

        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Update the status of an inquiry.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_review,contacted,closed',
        ]);

        $inquiry = ProjectInquiry::findOrFail($id);
        $inquiry->update(['status' => $request->status]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Inquiry status updated successfully',
                'status' => $inquiry->status,
            ]);
        }

        return redirect()->back()->with('success', 'Inquiry status updated successfully.');
    }

    /**
     * Remove the specified inquiry from storage.
     */
    public function destroy($id)
    {
        $inquiry = ProjectInquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
