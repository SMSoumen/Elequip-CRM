<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {

        $user = auth('admin')->user();
        $isSuperAdmin = $user->hasRole('Super-Admin');

        // Quotation Amount
        $query = Quotation::where(['qout_is_latest' => 1]);
        $leads_query = Lead::where('lead_stage_id', '>', 2);
        if (!$isSuperAdmin) {
            $leads_query->where(['admin_id' => $user->id])->orWhere(['lead_assigned_to' => $user->id]);
        }
        $leads = $leads_query->pluck('id')->toArray();

        $query->whereIn('lead_id', $leads);
        $quotation_amount = $query->sum('quot_amount');
        unset($leads);

        // Active Quotation Amount
        $leads = $leads_query->where('status', 1)->pluck('id')->toArray();        
        $query->whereIn('lead_id', $leads);
        $active_quot_amount = $query->sum('quot_amount');
        unset($leads);


        // Purchase Order Amount
        $po_query = PurchaseOrder::query();

        $leads = Lead::where('lead_stage_id', '>=', 5);
        if (!$isSuperAdmin) {
            $leads->where(['admin_id' => $user->id])->orWhere(['lead_assigned_to' => $user->id]);
        }
        $leads = $leads->pluck('id')->toArray();
        $po_amount = $po_query->whereIn('lead_id', $leads)->sum('po_amount');
        // unset($leads);

        // Closed Purchase Order Amount
        $leads = Lead::where('lead_stage_id', '=', 9);
        if (!$isSuperAdmin) {
            $leads->where(['admin_id' => $user->id])->orWhere(['lead_assigned_to' => $user->id]);
        }
        $leads = $leads->pluck('id')->toArray();
        $closed_amount = $po_query->whereIn('lead_id', $leads)->sum('po_amount');
        unset($leads);

        $total_counts = [];
        $dates = $this->_getLastNDays(7);


        if ($dates) {
            foreach ($dates as $i => $date) {
                $startOfDay = Carbon::parse($date)->startOfDay();
                $endOfDay = Carbon::parse($date)->endOfDay();

                // leads per day
                $leadsQuery = DB::table('leads')->whereBetween('created_at', [$startOfDay, $endOfDay]);
                if (!$isSuperAdmin) {
                    $leadsQuery->where(['admin_id' => $user->id])->orWhere(['lead_assigned_to' => $user->id]);
                }
                $leads_per_day = $leadsQuery->count();

                // quotations per day
                $quotQuery = DB::table('quotations')->where(['qout_is_latest' => 1])->whereBetween('created_at', [$startOfDay, $endOfDay]);
                $leads = Lead::where('lead_stage_id', '>', 2);
                if (!$isSuperAdmin) {
                    $leads->where(['admin_id' => $user->id])->orWhere(['lead_assigned_to' => $user->id]);
                }
                $lead_ids = $leads->pluck('id')->toArray();
                $quotQuery->whereIn('lead_id', $lead_ids);
                $quot_per_day = $quotQuery->count();

                // purchase orders per day
                $poQuery = DB::table('purchase_orders')->whereBetween('created_at', [$startOfDay, $endOfDay]);
                $po_leads = $leads->where('lead_stage_id', '>=', 5)->pluck('id')->toArray();
                $poQuery->whereIn('lead_id', $po_leads);
                $po_per_day = $poQuery->count();

                // account closed per day
                $ac_query = DB::table('purchase_orders');
                $ac_leads = $leads->whereBetween('updated_at', [$startOfDay, $endOfDay])->where('lead_stage_id', '=', 9)->pluck('id')->toArray();
                $ac_query->whereIn('lead_id', $ac_leads);
                $ac_per_day = $ac_query->count();


                $total_counts[] = [
                    'leads_per_day' => $leads_per_day,
                    'quot_per_day' => $quot_per_day,
                    'po_per_day' => $po_per_day,
                    'ac_per_day' => $ac_per_day,
                    'date' => substr($date, 8, 2) . '/' . substr($date, 5, 2),
                ];
            }
        }

        return view('admin.dashboard', compact(['quotation_amount', 'active_quot_amount', 'po_amount', 'closed_amount', 'total_counts']));
    }

    private function _getLastNDays($days = 7, $format = 'Y-m-d')
    {
        $m     = date("m");
        $de = date("d");
        $y     = date("Y");
        $dateArray = array();
        for ($i = 0; $i <= $days - 1; $i++) {
            $dateArray[] = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
        }
        return array_reverse($dateArray);
    }
}
