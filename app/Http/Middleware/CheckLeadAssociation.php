<?php

namespace App\Http\Middleware;

use App\Models\Lead;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckLeadAssociation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lead = $request->route('lead'); // Assuming the lead ID is passed in the route
        $user = Auth::guard('admin')->user();

        // Fetch the lead
        // $lead = Lead::where('id', );

        // Log::info('User: ' . $user->hasRole('Super-Admin'));
        // Log::info('Lead: ' . $lead);

        if (!$user->hasRole('Super-Admin')) {
            if ($user->hasRole('Sales')) {
                if (($lead->admin_id != $user->id) && ($lead->lead_assigned_to != $user->id)) {
                    // Log::info('Test Lead: ');
                    return redirect()->route('admin.leads.index');
                }
            } else {
                if ($lead->lead_stage_id < 5) {
                    // Log::info('Test Lead 2: ');
                    return redirect()->route('admin.leads.index');
                }
            }
        }



        return $next($request); // Proceed to the next middleware/controller
    }
}
