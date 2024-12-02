<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Exception;
use App\Models\PurchaseOrder;
use App\Models\OrderAndDelivery;

class OrderController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Order access|Order create|Order edit|Order delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Order create', only: ['create', 'store']),
            new Middleware('role_or_permission:Order edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Order delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(PurchaseOrder::query()->join('leads','purchase_orders.lead_id','leads.id')
                ->join('lead_stages','leads.lead_stage_id','lead_stages.id')
                ->join('customers','leads.company_id','customers.id')->join('companies','leads.customer_id','companies.id')
                ->select('purchase_orders.id','purchase_orders.po_net_amount','purchase_orders.po_refer_no','customers.customer_name','customers.mobile','customers.designation','customers.email','companies.company_name','lead_stages.stage_name')
                ->orderBy('purchase_orders.id','desc'))
                ->addColumn('orderby', function ($data) {
                    return $data->orderby = $data->customer_name.'('.$data->designation.')<br>'.$data->company_name .'<br>Email : '.$data->email.'<br> Phone : '.$data->mobile;
                })
                ->addColumn('balance_amount', function ($data) {
                    return $data->balance_amount = $data->po_net_amount;
                })
                ->addColumn('stage', function ($data) {
                    return $data->stage = '<span class="badge bg-secondary">'.$data->stage_name.'</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })
                ->addColumn('action', function ($data) {
                    $viewRoute = route('admin.orders.show', $data->id);
                    return view('admin.layouts.partials.order_action_btn', compact(['data', 'viewRoute']))->render();
                })
                ->addIndexColumn()->rawColumns(['orderby','balance_amount','action','stage','created_date'])->make(true);
            }
            return view('admin.order.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
