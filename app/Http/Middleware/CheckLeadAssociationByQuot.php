<?php

namespace App\Http\Middleware;

use App\Models\Lead;
use App\Models\Quotation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLeadAssociationByQuot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $quotation_id = $request->route('quotation_id'); // Assuming the lead ID is passed in the route
        $user = Auth::guard('admin')->user();

        $quotation = Quotation::where('id', $quotation_id)->first();

        $lead = Lead::where('id', $quotation->lead_id)->first();

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
        return $next($request);
    }
}
