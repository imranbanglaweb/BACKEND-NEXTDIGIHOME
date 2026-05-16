<?php

namespace App\Http\Middleware;

use App\Services\QuotaService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckQuota
{
    protected $quotaService;

    public function __construct(QuotaService $quotaService)
    {
        $this->quotaService = $quotaService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $action, int $count = 1): Response
    {
        $user = auth()->user();

        if (!$user || !$user->company) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$this->quotaService->canPerformAction($user->company, $action, $count)) {
            // Check if it's an API request
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Quota exceeded',
                    'message' => "You have reached your {$action} limit. Please upgrade your plan.",
                    'action' => $action,
                    'upgrade_required' => true,
                ], 429);
            }

            // For web requests, redirect to home with error
            return redirect()->route('home')
                ->with('error', "You have reached your {$action} limit. Please upgrade your plan to continue.");
        }

        // Increment usage counter after successful request
        $response = $next($request);

        if ($response->getStatusCode() < 400) {
            $this->quotaService->incrementUsage($user->company, $action, $count);
        }

        return $response;
    }
}