<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Filter by priority
        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by lead source
        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('lead_source', $request->source);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('lead_id', 'like', "%{$search}%")
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
            'high_priority' => ProjectInquiry::where('priority', 'HIGH')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts'));
    }

    /**
     * Display the specified inquiry.
     */
    public function show($id)
    {
        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

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

        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

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
     * Update the priority of an inquiry.
     */
    public function updatePriority(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required|in:LOW,MEDIUM,HIGH',
        ]);

        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

        $inquiry->update(['priority' => $request->priority]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Lead priority updated successfully',
                'priority' => $inquiry->priority,
            ]);
        }

        return redirect()->back()->with('success', 'Lead priority updated successfully.');
    }

    /**
     * Add an internal note to the inquiry.
     */
    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:2000',
        ]);

        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

        $currentNotes = is_array($inquiry->notes) ? $inquiry->notes : [];
        $adminName = Auth::user() ? Auth::user()->name : 'Admin';

        $newNote = [
            'id' => 'note_' . time() . '_' . rand(100, 999),
            'text' => trim($request->note),
            'author' => $adminName,
            'created_at' => now()->toDateTimeString(),
        ];

        array_unshift($currentNotes, $newNote);
        $inquiry->update(['notes' => $currentNotes]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note recorded successfully',
                'note' => $newNote,
            ]);
        }

        return redirect()->back()->with('success', 'Note recorded successfully.');
    }

    /**
     * Update follow-up schedule.
     */
    public function updateFollowUp(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'note' => 'nullable|string|max:500',
            'status' => 'nullable|in:PENDING,COMPLETED,CANCELLED',
        ]);

        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

        $inquiry->update([
            'follow_up' => [
                'date' => $request->date,
                'note' => $request->note ?: '',
                'status' => $request->status ?: 'PENDING',
            ]
        ]);

        return redirect()->back()->with('success', 'Follow-up scheduled successfully.');
    }

    /**
     * Remove the specified inquiry from storage.
     */
    public function destroy($id)
    {
        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

        $inquiry->delete();

        return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}

