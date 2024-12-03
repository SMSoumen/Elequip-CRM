<?php

// use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\Auth\ConfirmablePasswordController;
// use App\Http\Controllers\Auth\EmailVerificationNotificationController;
// use App\Http\Controllers\Auth\EmailVerificationPromptController;
// use App\Http\Controllers\Auth\NewPasswordController;
// use App\Http\Controllers\Auth\PasswordController;
// use App\Http\Controllers\Auth\PasswordResetLinkController;
// use App\Http\Controllers\Auth\RegisteredUserController;
// use App\Http\Controllers\Auth\VerifyEmailController;

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\LeadCategoryController;
use App\Http\Controllers\Master\LeadStageController;
use App\Http\Controllers\Master\BrandController;
use App\Http\Controllers\Master\MeasuringUnitController;
use App\Http\Controllers\Master\SMSFormatController;
use App\Http\Controllers\Contact\CompanyController;
use App\Http\Controllers\Contact\CustomerController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductSubCategoryController;
use App\Http\Controllers\Master\LeadSourceController;
use App\Http\Controllers\Lead\LeadController;
use App\Http\Controllers\Lead\PurchaseOrderController;
use App\Http\Controllers\Order\OrderController;

Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //     ->name('register');

    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //             ->name('password.request');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //             ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //             ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //             ->name('password.store');
});

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change_password');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('change_password.update');
    // Route::get('verify-email', EmailVerificationPromptController::class)
    //             ->name('verification.notice');

    // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    //             ->middleware(['signed', 'throttle:6,1'])
    //             ->name('verification.verify');

    // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //             ->middleware('throttle:6,1')
    //             ->name('verification.send');

    // Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    //             ->name('password.confirm');

    // Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::put('password', [PasswordController::class, 'update'])->name('password.update');


    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');


//==============================> Elequip CRM Surajit Route <==============================//

   Route::resource('lead-category', LeadCategoryController::class);
   Route::resource('lead-stage', LeadStageController::class);
   Route::resource('lead-sources', LeadSourceController::class);
   Route::resource('measuring-unit', MeasuringUnitController::class);
   Route::resource('brand', BrandController::class);
   Route::resource('sms-format', SMSFormatController::class);
   Route::resource('companies', CompanyController::class);
   Route::resource('customers', CustomerController::class);
   Route::resource('product-categories', ProductCategoryController::class);
   Route::resource('product-subcategories', ProductSubCategoryController::class);
   Route::resource('products', ProductController::class);
   Route::get('product/subcategories/{id}', [ProductSubCategoryController::class, 'allSubCategory'])->name('product-subcategories.all');
   Route::post('subcategories/list', [ProductController::class, 'subCategoryList'])->name('subcategory.list');
   Route::post('products/upload', [ProductController::class, 'uploadProduct'])->name('products.upload');
   Route::post('check/company', [CompanyController::class, 'checkCompany'])->name('checkcompany');
   Route::resource('leads', LeadController::class);
   Route::post('product/details', [LeadController::class, 'productDetails'])->name('product-details');
   Route::post('leads/assign', [LeadController::class, 'leadAssignUser'])->name('lead-assign');
   Route::post('leads/stage-update', [LeadController::class, 'leadStageUpdate'])->name('lead.stage_update');
   Route::post('leads/company/customer', [LeadController::class, 'companyCustomers'])->name('lead.company_customer');

   Route::post('leads/quotation/store', [LeadController::class, 'quotationGenerate'])->name('lead.quotation_store');
   Route::post('lead/product-details', [LeadController::class, 'leadProductDetails'])->name('lead.product_details');
   Route::post('leads/quotation/create', [LeadController::class, 'addQuotation'])->name('lead.quotation.create');
   Route::get('leads/quotation/edit/{lead_id}', [LeadController::class, 'editQuotation'])->name('lead.quotation.edit');
   Route::post('leads/quotation/update', [LeadController::class, 'updateQuotation'])->name('lead.quotation.update');
   Route::get('leads/quotation/pdf/{quotaion_id}', [LeadController::class, 'quotaionPdf'])->name('quotaion.pdf');
   Route::post('lead-stage/update', [LeadController::class, 'leadStageUpdate'])->name('lead_stage.update');

   Route::post('lead/purchase-order/create', [PurchaseOrderController::class, 'createPurchaseOrder'])->name('lead.purchase_order.create');
   Route::get('lead/po-details/{po_id}', [PurchaseOrderController::class, 'poDetailsView'])->name('po.details');
   Route::post('lead/purchase-order/update', [PurchaseOrderController::class, 'updatePurchaseOrder'])->name('lead.purchase_order.update');

   Route::resource('orders', OrderController::class);
   Route::post('orders/advance-amount', [OrderController::class, 'addAdvanceAmount'])->name('order.add_advance_amount');
   Route::post('orders/remaining-amount', [OrderController::class, 'addRemainingAmount'])->name('order.add_remaining_amount');

});
