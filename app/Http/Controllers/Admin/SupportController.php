<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportCategory;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:support-manage');
    }

    /**
     * Display a listing of all tickets
     */
    public function index()
    {
        $tickets = SupportTicket::with(['category', 'customer', 'assignedUser'])
            ->latest()
            ->paginate(15);

        return view('admin.support.tickets.index', compact('tickets'));
    }

    /**
     * Display open tickets
     */
    public function open()
    {
        $tickets = SupportTicket::with(['category', 'customer', 'assignedUser'])
            ->open()
            ->latest()
            ->paginate(15);

        return view('admin.support.tickets.index', compact('tickets'));
    }

    /**
     * Display pending tickets
     */
    public function pending()
    {
        $tickets = SupportTicket::with(['category', 'customer', 'assignedUser'])
            ->pending()
            ->latest()
            ->paginate(15);

        return view('admin.support.tickets.index', compact('tickets'));
    }

    /**
     * Display closed tickets
     */
    public function closed()
    {
        $tickets = SupportTicket::with(['category', 'customer', 'assignedUser'])
            ->closed()
            ->latest()
            ->paginate(15);

        return view('admin.support.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket
     */
    public function create()
    {
        $categories = SupportCategory::active()->orderBy('sort_order')->get();
        $customers = User::all(); // Get all users as potential customers
        $admins = User::where('role', 'admin')->get();

        return view('admin.support.tickets.create', compact('categories', 'customers', 'admins'));
    }

    /**
     * Store a newly created ticket
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:support_categories,id',
            'customer_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticket = SupportTicket::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'customer_id' => $request->customer_id,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'tags' => $request->tags,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.support.tickets.show', $ticket)
            ->with('success', 'Support ticket created successfully.');
    }

    /**
     * Display the specified ticket
     */
    public function show(SupportTicket $ticket)
    {
        $ticket->load(['category', 'customer', 'assignedUser', 'replies.creator']);
        $categories = SupportCategory::active()->get();
        $admins = User::where('role', 'admin')->get();

        return view('admin.support.tickets.show', compact('ticket', 'categories', 'admins'));
    }

    /**
     * Show the form for editing the ticket
     */
    public function edit(SupportTicket $ticket)
    {
        $categories = SupportCategory::active()->orderBy('sort_order')->get();
        $customers = User::all(); // Get all users as potential customers
        $admins = User::where('role', 'admin')->get();

        return view('admin.support.tickets.edit', compact('ticket', 'categories', 'customers', 'admins'));
    }

    /**
     * Update the specified ticket
     */
    public function update(Request $request, SupportTicket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:support_categories,id',
            'customer_id' => 'required|exists:users,id',
            'status' => 'required|in:open,pending,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticket->update([
            'subject' => $request->subject,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'customer_id' => $request->customer_id,
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'tags' => $request->tags,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.support.tickets.show', $ticket)
            ->with('success', 'Support ticket updated successfully.');
    }

    /**
     * Remove the specified ticket
     */
    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();

        return redirect()->route('admin.support.tickets.index')
            ->with('success', 'Support ticket deleted successfully.');
    }

    /**
     * Add a reply to the ticket
     */
    public function addReply(Request $request, SupportTicket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'is_internal' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'message' => $request->message,
            'is_internal' => $request->is_internal ?? false,
            'created_by' => Auth::id(),
        ]);

        // Update ticket's last reply timestamp
        $ticket->update([
            'last_reply_at' => now(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'reply' => $reply->load('creator'),
        ]);
    }

    /**
     * Update ticket status
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:open,pending,in_progress,resolved,closed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ticket->update([
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket status updated successfully.',
        ]);
    }

    /**
     * Assign ticket to user
     */
    public function assign(Request $request, SupportTicket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'assigned_to' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ticket->update([
            'assigned_to' => $request->assigned_to,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket assigned successfully.',
        ]);
    }
}