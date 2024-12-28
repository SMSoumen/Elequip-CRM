<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\LeadDetail;
use App\Models\LeadFollowup;
use App\Models\MeasuringUnit;
use App\Models\OrderAndDelivery;
use App\Models\Product;
use App\Models\ProductSubCategory;
use App\Models\ProformaDetail;
use App\Models\ProformaInvoice;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\QuotationTerm;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Admin access|Admin create|Admin edit|Admin delete', only: ['index']),
            new Middleware('role_or_permission:Admin create', only: ['create', 'store']),
            new Middleware('role_or_permission:Admin edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Admin delete', only: ['destroy']),

        ];
    }

    private function checkEdit($user)
    {

        if (auth('admin')->id() == 1 && isSuperAdmin()) {
            return true;
        } else {
            if (isSuperAdmin()) {
                if ($user->id !== 1) {
                    return true;
                }
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Admin::query();
                if (auth('admin')->user()->id !== 1) {
                    $query->where('id', '!=', 1);
                }
                return DataTables::eloquent($query)->addColumn('status', function ($data) {
                    if ($data->id != 1) {
                        $table = 'admins';
                        return view('admin.layouts.partials.listing_status_switch', compact(['data', 'table']))->render();
                    } else {
                        return "";
                    }
                })->addColumn('role', function ($data) {
                    return $data->roles ? '<span class="badge badge-pill badge-custom badge-info">' . $data->roles->pluck('name')->implode('|') . '</span>' : '<span class="badge badge-pill badge-custom badge-secondary">Sorry there is no role</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y', strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.users.edit', $data->id);
                    // $deleteRoute = route('admin.users.destroy', $data->id);
                    $deleteRoute = null;
                    $edit_type = "";
                    $permission = 'Admin';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission', 'edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action', 'status', 'created_date', 'role'])->make(true);
            }
            return view('admin.setting.user.index');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view('admin.setting.user.add', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|digits:10|unique:admins,phone',
            'roles' => ['required', 'array', Rule::notIn([1])],
            // 'password' => 'required|confirmed|min:8|max:25'
        ]);

        $password = ucwords(strtolower($validated['name'])) . '@123';

        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'phone' => $request->phone,
            'code' => generate_user_code($request->name),
        ]);
        $user->syncRoles($request->roles);
        return redirect()->back()->withSuccess('Admin created !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $user)
    {
        $role = Role::where('id', '!=', 1)->get();

        if ($this->checkEdit($user) !== true) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot edit another Super Admin.');
        }

        return view('admin.setting.user.edit', ['user' => $user, 'roles' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $user)
    {
        if ($this->checkEdit($user) !== true) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot edit another Super Admin.');
        }
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $user->id,
            'phone' => 'required|digits:10|unique:admins,phone,' . $user->id,
            'roles' => ['required', 'array', Rule::notIn([1])],
        ]);

        if ($request->password != null) {
            $request->validate([
                'password' => 'required|confirmed'
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        // dd($request->all());
        $user->update($validated);

        $user->syncRoles($request->roles);
        return redirect()->back()->withSuccess('Admin updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $user)
    {
        if ($this->checkEdit($user) !== true) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete another Super Admin.');
        }
        $user->delete();
        return redirect()->back()->withSuccess('Admin deleted !!!');
    }

    public function userStatusChange(Request $request)
    {

        $user = Admin::where('id', $request->user_id)->first();
        if ($this->checkEdit($user) !== true) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot edit another Super Admin.');
        }
        $user_status = ($request->user_stat == 'true') ? 1 : 0;

        if ($user) {
            $user->where('id', $request->user_id)->update(['status' => $user_status]);
            return response()->json(['error' => false, 'msg' => 'Admin status updated']);
            // if ($response) {
            //     return response()->json(['error' => false, 'msg' => 'Admin status updated']);
            // } else {
            //     return response()->json(['error' => true, 'msg' => 'Admin not updated']);
            // }
        } else {
            return response()->json(['error' => true, 'msg' => 'Admin not found']);
        }
    }

    private function readJson($path)
    {
        // Path to the JSON file
        $filePath = public_path($path);

        // Check if the file exists
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'JSON file not found'], 404);
        }

        // Read and decode the JSON file
        $jsonData = file_get_contents($filePath);
        $dataArray = json_decode($jsonData); // Convert to associative array

        // Handle JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON format'], 400);
        }

        // Return the array or use it as needed
        return $dataArray;
    }

    public function tempUserCreate()
    {
        $userArr = $this->readJson('assets/data/users.json');

        foreach ($userArr as $key => $value) {
            echo "<pre>";
            print_r($value);
            if ($value->_user_id == 1) {
                continue;
            }

            $tempAdmin = Admin::create([
                'name' => $value->user_name,
                'code' => $value->user_code,
                'email' => $value->user_email,
                'phone' => $value->user_mobile,
                'password' => Hash::make(base64_decode($value->user_password)),
                'status' => $value->user_status,
                'created_at' => $value->user_created,
                'updated_at' => $value->user_modified,
            ]);

            if ($value->user_type == 1) {
                $tempAdmin->assignRole('Admin');
            } else if ($value->user_type == 2) {
                $tempAdmin->assignRole('Sales');
            } else {
                $tempAdmin->assignRole('Factory');
            }
            unset($tempAdmin);
        }
    }

    public function tempBrandCreate()
    {
        $brandArr = $this->readJson('assets/data/brands.json');

        foreach ($brandArr as $key => $value) {
            echo "<pre>";
            print_r($value);
            Brand::create([
                'brand_name' => $value->brand_name,
                'status' => $value->brand_status,
                'created_at' => $value->brand_created,
                'updated_at' => $value->brand_updated,
            ]);
        }
    }

    public function tempCompanyCreate()
    {
        $dataArr = $this->readJson('assets/data/companies.json');

        foreach ($dataArr as $key => $value) {
            echo "<pre>";
            print_r($value);

            if (($key + 1) != $value->_company_id) {
                echo "**********************************************";
                //     break;
            }

            Company::create([
                'id' => $value->_company_id,
                'company_name' => $value->company_name,
                'phone' => $value->company_phone,
                'email' => $value->company_email,
                'gst' => $value->company_gstn,
                'pan' => $value->company_pan,
                'website' => $value->company_website,
                'logo' => $value->company_logo,
                'address' => $value->company_address,
                'city_id' => $value->company_city == 0 ?  1 : (int)($value->company_city),

                'status' => (int)$value->company_status,
                'created_at' => $value->company_created,
                'updated_at' => $value->company_updated,
            ]);
        }

        unset($dataArr);
    }

    public function tempCustomerCreate()
    {
        $dataArr = $this->readJson('assets/data/customers.json');

        foreach ($dataArr as $key => $value) {
            echo "<pre>";
            // print_r($key + 1);
            print_r($value);

            if (($key + 1) != $value->_customer_id) {
                echo "**********************************************";
                // break;
            }

            Customer::create([
                'id' => $value->_customer_id,
                'customer_name' => $value->customer_name,
                'designation' => $value->customer_designation,
                'mobile' => $value->customer_phone,
                'phone' => $value->customer_phone2,
                'email' => $value->customer_email,
                'email2' => $value->customer_email2,
                'address' => $value->customer_address,
                'company_id' => (int)$value->customer_company,

                'status' => (int)$value->customer_status,
                'created_at' => $value->customer_created,
                'updated_at' => $value->customer_modified,
            ]);
        }
        unset($dataArr);
    }

    public function tempSubcategoryCreate()
    {
        $dataArr = $this->readJson('assets/data/pro_sub_categories.json');

        foreach ($dataArr as $key => $value) {
            echo "<pre>";
            // print_r($key + 1);
            print_r($value);

            // if (($key + 1) != $value->_customer_id) {
            //     echo "**********************************************";
            //     // break;
            // }

            ProductSubCategory::create([
                'id' => $value->_pro_sub_cat_id,
                'product_category_id' => $value->pro_cat_id,
                'product_subcat_name' => $value->pro_sub_cat_name,
                'product_subcat_slug' => Str::slug($value->pro_sub_cat_name),

                'status' => (int)$value->pro_sub_cat_status,
                'created_at' => $value->pro_sub_cat_created,
                'updated_at' => $value->pro_sub_cat_updated,
            ]);
        }
        unset($dataArr);
    }

    public function tempProductCreate()
    {
        $dataArr = $this->readJson('assets/data/products.json');

        foreach ($dataArr as $key => $value) {
            // echo "<pre>";
            // print_r($key + 1);
            // print_r($value);

            // if (($key + 1) != $value->_customer_id) {
            //     echo "**********************************************";
            //     // break;
            // }

            Product::create([
                'id' => $value->_product_id,
                'product_category_id' => $value->product_category,
                'product_sub_category_id' => $value->product_sub_category,
                'product_name' => $value->product_title,
                'product_code' => $value->product_code,
                'product_price' => $value->product_price,
                'measuring_unit_id' => $value->product_unit_type,
                'brand_id' => $value->product_brand,
                'product_tech_spec' => $value->product_tech_spec,
                'product_marketing_spec' => $value->product_marketing_spec,

                'status' => (int)$value->product_status,
                'created_at' => $value->product_created,
                'updated_at' => $value->product_modified,
            ]);
        }
        unset($dataArr);
    }

    public function tempLeadCreate()
    {
        $dataArr = $this->readJson('assets/data/leads.json');

        foreach ($dataArr as $key => $value) {

            Lead::create([
                'id' => $value->_lead_id,
                'company_id' => $value->lead_company,
                'customer_id' => $value->lead_customer,
                'lead_source_id' => $value->lead_source,
                'lead_category_id' => $value->lead_category,
                'lead_remarks' => $value->lead_remarks,
                'lead_estimate_closure_date' => $value->lead_estimate_closure,
                'lead_total_amount' => $value->lead_total_amount,
                'lead_stage_id' => $value->lead_status,
                'admin_id' => $value->lead_created_by,
                'lead_assigned_to' => $value->lead_assigned_to,
                'status' => $value->lead_is_active,
                'created_at' => $value->lead_created,
                'updated_at' => $value->lead_updated,
            ]);

            // "_lead_id": "2122",
            // "lead_company": "1232",
            // "lead_customer": "1539",
            // "lead_source": "6",
            // "lead_category": "5",
            // "lead_remarks": "Indef chain block pulley",
            // "lead_estimate_closure": "2024-12-18",
            // "lead_total_amount": "72440.00",
            // "lead_status": "3",
            // "lead_created_by": "16",
            // "lead_created_by_type": "2",
            // "lead_assigned_to": "16",
            // "lead_created": "2024-12-17 18:35:12",
            // "lead_updated": "2024-12-17 13:14:13",
            // "lead_is_active": "1"

            // $table->id();
            // $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            // $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            // $table->foreignId('lead_source_id')->constrained('lead_sources')->cascadeOnDelete();
            // $table->foreignId('lead_category_id')->constrained('lead_categories')->cascadeOnDelete();
            // $table->text('lead_remarks')->nullable();
            // $table->date('lead_estimate_closure_date')->nullable();
            // $table->decimal('lead_total_amount', 15, 2);
            // $table->foreignId('lead_stage_id')->default(1)->constrained('lead_stages')->cascadeOnDelete();
            // $table->foreignId('admin_id')->comment('lead creator')->constrained('admins')->cascadeOnDelete();
            // $table->foreignId('lead_assigned_to')->nullable()->constrained('admins')->cascadeOnDelete();
            //$table->foreignId('lead_stage_id')->constrained('lead_stages')->cascadeOnDelete();
            // $table->tinyInteger('status')->default(1);
            // $table->timestamps();
        }

        unset($dataArr);
    }

    public function tempLeadDetailsCreate()
    {
        $dataArr = $this->readJson('assets/data/lead_details.json');

        foreach ($dataArr as $key => $value) {

            if (Lead::where('id', $value->ld_lead_id)->count() == 0) {
                continue;
            }

            LeadDetail::create([
                'id' => $value->_ld_id,
                'lead_id' => $value->ld_lead_id,
                'product_id' => $value->ld_product_id,
                'lead_product_name' => $value->ld_pdoduct_title,
                'lead_product_code' => $value->ld_product_code,
                'lead_product_qty' => $value->ld_product_quantity,
                'lead_product_price' => $value->ld_product_price,
                'lead_product_tech_spec' => $value->ld_product_spec,
                'lead_product_m_spec' => $value->ld_product_mspec,
                'lead_product_unit' => $value->ld_product_unit,
                'status' => $value->ld_status,
                'created_at' => $value->ld_created,
                'updated_at' => $value->ld_updated,
            ]);

            // "_ld_id": "3335",
            // "ld_lead_id": "2120",
            // "ld_product_id": "29",
            // "ld_pdoduct_title": "CHAIN PULLEY BLOCK- M",
            // "ld_product_code": "CPB-M/5T-VL",
            // "ld_product_quantity": "1",
            // "ld_product_price": "38590.00",
            // "ld_product_spec": "&lt;p&gt;Capacity: 5.0 ton&lt;/p&gt;&lt;p&gt;Height of lift: 4 mtrs.&lt;/p&gt;&lt;p&gt;No. of falls (load chain): 2&lt;/p&gt;&lt;p&gt;Grade 80 load chain for strenght &amp; wear resistance&lt;/p&gt;",
            // "ld_product_mspec": "&lt;p&gt;INDEF brand, Herculer hoist make triple spur gear Chain Pulley Block, tested to 50% overload capacity.HSN Code - 8425&lt;/p&gt;",
            // "ld_product_unit": "No.",
            // "ld_created": "2024-12-17 17:46:34",
            // "ld_updated": null,
            // "ld_status": "1"

            // $table->id();
            // $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            // $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            // $table->string('lead_product_name')->nullable();
            // $table->string('lead_product_code')->nullable();
            // $table->decimal('lead_product_qty', 15, 2)->default(0.00);
            // $table->decimal('lead_product_price', 15, 2)->default(0.00);
            // $table->longText('lead_product_tech_spec')->nullable();
            // $table->longText('lead_product_m_spec')->nullable();
            // $table->string('lead_product_unit')->nullable();
            // $table->tinyInteger('status')->default(1);
            // $table->timestamps();

        }

        unset($dataArr);
    }

    public function tempLeadFollowupCreate()
    {
        $dataArr = $this->readJson('assets/data/lead_followups.json');

        foreach ($dataArr as $key => $value) {

            if (Lead::where('id', $value->lf_lead_id)->count() == 0) {
                continue;
            }

            LeadFollowup::create([
                'id' => $value->_lf_id,
                'lead_id' => $value->lf_lead_id,
                'followup_next_date' => $value->lf_next_date,
                'followup_remarks' => $value->lf_remarks,
                'followup_type' => $value->lf_type,
                'admin_id' => $value->lf_created_by,
                'created_at' => $value->lf_created,
                'updated_at' => $value->lf_updated,
            ]);
        }

        unset($dataArr);
    }
    public function tempLeadQuotCreate()
    {
        $dataArr = $this->readJson('assets/data/lead_quotations.json');

        foreach ($dataArr as $key => $value) {

            if (Lead::where('id', $value->quot_lead_id)->count() == 0) {
                continue;
            }

            Quotation::create([
                'id' => $value->_quot_id,
                'lead_id' => $value->quot_lead_id,
                'quot_ref_no' => $value->quot_ref_no,
                'quot_user_ref_no' => $value->quot_user_ref_no,
                'quot_remarks' => $value->quot_remarks,
                'quot_version' => $value->quot_version,
                'qout_is_latest' => $value->qout_is_latest,
                'quot_amount' => $value->quot_amount,
                'admin_id' => $value->quot_created_by,
                'status' => $value->quot_status,
                'created_at' => $value->quot_created,
                'updated_at' => $value->quot_updated,
            ]);
        }

        unset($dataArr);
    }
    public function tempQuotDetailsCreate()
    {
        $dataArr = $this->readJson('assets/data/quotation_details.json');

        foreach ($dataArr as $key => $value) {

            if (Quotation::where('id', $value->qd_quote_id)->count() == 0) {
                continue;
            }

            QuotationDetail::create([
                'id' => $value->_qd_id,
                'quotation_id' => $value->qd_quote_id,
                'product_id' => $value->qd_pro_id,
                'quot_product_qty' => $value->qd_pro_qty,
                'quot_product_unit' => $value->qd_pro_qty_type,
                'quot_product_unit_price' => $value->qd_pro_u_price,
                'quot_product_total_price' => $value->qd_pro_tot_price,
                'quot_product_discount' => $value->qd_discount,
                'quot_product_discount_amount' => $value->qd_discount_amount,
                'quot_product_name' => $value->qd_pro_title,
                'quot_product_code' => $value->qd_pro_code,
                'quot_product_tech_spec' => $value->qd_pro_spec,
                'quot_product_m_spec' => $value->qd_pro_mspec,
                'created_at' => $value->qd_created,
                'updated_at' => $value->qd_updated,

            ]);
        }

        unset($dataArr);
    }
    public function tempQuotTermsCreate()
    {
        $dataArr = $this->readJson('assets/data/lead_terms.json');

        foreach ($dataArr as $key => $value) {

            if (Quotation::where('id', $value->term_quot_id)->count() == 0) {
                continue;
            }

            QuotationTerm::create([
                'id' => $value->_term_id,
                'lead_id' => $value->term_lead_id,
                'quotation_id' => $value->term_quot_id,
                'term_is_latest' => $value->term_is_latest,
                'term_discount' => $value->term_discount,
                'term_tax' => $value->term_tax,
                'term_inspection' => $value->term_inspection,
                'term_price' => $value->term_price,
                'term_dispatch' => $value->term_dispatch,
                'term_payment' => $value->term_payment,
                'term_warranty' => $value->term_warranty,
                'term_validity' => $value->term_validity,
                'term_forwarding' => $value->term_forwarding,
                'term_note_1' => $value->term_note_1,
                'term_note_2' => $value->term_note_2,
                'created_at' => $value->term_created,
                'updated_at' => $value->term_updated,

            ]);

            // "_term_id": "2995",
            // "term_lead_id": "2123",
            // "term_quot_id": "3015",
            // "term_is_latest": "1",
            // "term_discount": "",
            // "term_tax": "GST 18% EXTRA",
            // "term_inspection": null,
            // "term_price": "F.O.R Kolkata",
            // "term_dispatch": "10 days of PO",
            // "term_payment": "100% against proforma invoice",
            // "term_warranty": "12 months from the date of supply",
            // "term_validity": "Offers remains valid for 30 days from the date of hereof.",
            // "term_forwarding": "Extra at actuals/ To pay basis dispatch by road",
            // "term_note_1": "HSN Code - 8425",
            // "term_note_2": "GST no. - 19AAACE8804D1ZT",
            // "term_created": "2024-12-20 19:06:29",
            // "term_updated": null

            // $table->id();
            // $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            // $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            // $table->tinyInteger('term_is_latest')->default(1)->comment("0:No,1:Yes");
            // $table->string('term_discount')->nullable();
            // $table->string('term_tax')->nullable();
            // $table->string('term_inspection')->nullable();
            // $table->string('term_price')->nullable();
            // $table->string('term_dispatch')->nullable();
            // $table->string('term_payment')->nullable();
            // $table->string('term_warranty')->nullable();
            // $table->string('term_validity')->nullable();
            // $table->string('term_forwarding')->nullable();
            // $table->text('term_note_1')->nullable();
            // $table->text('term_note_2')->nullable();
            // $table->timestamps();            

        }

        unset($dataArr);
    }
    public function tempPOCreate()
    {
        $dataArr = $this->readJson('assets/data/puchase_orders.json');

        foreach ($dataArr as $key => $value) {

            if (Quotation::where('id', $value->po_quot_id)->count() == 0) {
                continue;
            }

            PurchaseOrder::create([
                'id' => $value->_po_id,
                'lead_id' => $value->po_lead_id,
                'quotation_id' => $value->po_quot_id,
                'po_refer_no' => $value->po_refer_no,
                'po_amount' => $value->po_amount,
                'po_gross_amount' => $value->po_gross_amount,
                'po_net_amount' => $value->po_net_amount,
                'po_taxable' => $value->po_taxable,
                'po_tax_percent' => $value->po_tax_percent,
                'po_advance' => $value->po_advance,
                'po_remaining' => $value->po_remaining,
                'po_document' => str_replace("assets/files/", "", $value->po_document),
                'po_remarks' => $value->po_remarks,
                'po_order_no' => $value->po_order_no,
                'po_order_date' => $value->po_order_date,
                'po_et_bill_no' => $value->po_et_bill_no,
                'admin_id' => $value->po_created_by,
                'created_at' => $value->po_created,
                'updated_at' => $value->po_updated,
            ]);

            // "_po_id": "393",
            // "po_lead_id": "2093",
            // "po_quot_id": "2976",
            // "po_refer_no": "P/0393",
            // "po_amount": "14500.00",
            // "po_gross_amount": "14500.00",
            // "po_net_amount": "17110.00",
            // "po_taxable": "2610.00",
            // "po_tax_percent": "18.00",
            // "po_advance": "0.00",
            // "po_remaining": "17110.00",
            // "po_document": "assets/files/9dac548cc7a4dddf43f931e56631ad0d.pdf",
            // "po_remarks": "DISPATCHED",
            // "po_order_no": "3524000543",
            // "po_order_date": "2024-11-29",
            // "po_et_bill_no": "",
            // "po_created": "2024-12-16 15:33:14",
            // "po_updated": "2024-12-16 10:03:14",
            // "po_created_by": "16"

            // $table->id();
            // $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            // $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            // $table->string('po_refer_no', 50)->nullable();
            // $table->decimal('po_amount', 15, 2)->default(0.00);
            // $table->decimal('po_gross_amount', 15, 2)->default(0.00);
            // $table->decimal('po_net_amount', 15, 2)->default(0.00);
            // $table->decimal('po_taxable', 15, 2)->default(0.00);
            // $table->decimal('po_tax_percent', 15, 2)->default(18.00);
            // $table->decimal('po_advance', 15, 2)->nullable()->default(0.00);
            // $table->decimal('po_remaining', 15, 2)->nullable()->default(0.00);
            // $table->text('po_document')->nullable();
            // $table->text('po_remarks')->nullable();
            // $table->string('po_order_no')->nullable();
            // $table->date('po_order_date')->nullable();
            // $table->string('po_et_bill_no')->nullable();
            // $table->foreignId('admin_id')->comment('creator')->constrained('admins')->cascadeOnDelete();
            // $table->timestamps();          

        }

        unset($dataArr);
    }

    public function tempOrderDeliveryCreate()
    {
        $dataArr = $this->readJson('assets/data/orders_and_deliveries.json');

        foreach ($dataArr as $key => $value) {

            if (PurchaseOrder::where('id', $value->od_order_id)->count() == 0) {
                continue;
            }

            OrderAndDelivery::create([
                'id' => $value->_od_id,
                'purchase_order_id' => $value->od_order_id,
                'lead_id' => $value->od_lead_id,
                'quotation_id' => $value->od_quot_id,
                'product_id' => $value->od_pro_id,
                'order_product_name' => $value->od_pro_title,
                'order_product_code' => $value->od_pro_code,
                'measuring_unit' => $value->od_pro_unit_type,
                'order_product_qty' => $value->od_pro_unit,
                'order_product_spec' => $value->od_pro_spec,
                'order_product_unit_price' => $value->od_pro_u_price,
                'order_product_total_price' => $value->od_pro_tot_price,
                'order_product_delivery_date' => $value->od_pro_delivery,
                'status' => $value->od_current_status,
                'created_at' => $value->od_created,
                'updated_at' => $value->od_updated,

            ]);
        }

        unset($dataArr);
    }

    public function tempProformaCreate()
    {
        $dataArr = $this->readJson('assets/data/proforma_invoices.json');

        foreach ($dataArr as $key => $value) {

            if (PurchaseOrder::where('id', $value->proforma_po_id)->count() == 0) {
                continue;
            }

            ProformaInvoice::create([
                'id' => $value->_proforma_id,
                'lead_id' => $value->proforma_lead_id,
                'purchase_order_id' => $value->proforma_po_id,
                'proforma_discount' => $value->proforma_discount,
                'proforma_gst_type' => $value->proforma_gst_type,
                'proforma_dispatch' => $value->proforma_dispatch,
                'proforma_remarks' => $value->proforma_remarks,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at,
                'created_by' => $value->created_by,
                'updated_by' => $value->updated_by,
            ]);
        }
        unset($dataArr);
    }
    public function tempProformaDetailsCreate()
    {
        $dataArr = $this->readJson('assets/data/proforma_details.json');

        foreach ($dataArr as $key => $value) {

            if (ProformaInvoice::where('id', $value->proforma_id)->count() == 0) {
                continue;
            }

            $product = Product::where('id', $value->proforma_product_id)->first();
            $unit = MeasuringUnit::where('id', $product->measuring_unit_id)->first();

            ProformaDetail::create([
                'id' => $value->_proforma_details_id,
                'proforma_invoice_id' => $value->proforma_id,
                'product_id' => $value->proforma_product_id,
                'proforma_product_name' => $product->product_name,
                'proforma_product_code' => $product->product_code,
                'proforma_product_spec' => $value->proforma_product_spec,
                'proforma_product_qty' => $value->proforma_product_qty,
                'proforma_product_unit' => $unit->unit_type,
                'proforma_product_price' => $value->proforma_product_price,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at,
            ]);

            // "_proforma_details_id": "267",
            // "proforma_id": "189",
            // "proforma_product_id": "442",
            // "proforma_product_spec": "<ul>\r\n\t<li>Capacity: 3.0 ton.</li>\r\n\t<li>Fork Length: 1150 mm</li>\r\n\t<li>fork width: 550mm</li>\r\n\t<li>Lifting height: 200mm</li>\r\n\t<li>Comes fitted with Heavy duty NYLON WHEELS</li>\r\n</ul>\r\n",
            // "proforma_product_qty": "2",
            // "proforma_product_price": "16500.00",
            // "created_at": "2024-12-03 10:45:24",
            // "updated_at": "2024-12-03 10:45:24"


            // $table->id();
            // $table->foreignId('proforma_invoice_id')->constrained('proforma_invoices')->cascadeOnDelete();
            // $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            // $table->string('proforma_product_name')->nullable();
            // $table->string('proforma_product_code')->nullable();
            // $table->longText('proforma_product_spec');
            // $table->decimal('proforma_product_qty', 15, 2)->default(0.00);
            // $table->string('proforma_product_unit');
            // $table->decimal('proforma_product_price', 15, 2);
            // $table->timestamps();
        }
        unset($dataArr);
    }
}
