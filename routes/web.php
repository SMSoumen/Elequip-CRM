<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\FeatureController;
// use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Contact\CompanyController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\StoreLocatorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/command', function () {
    Artisan::call('cache:clear');
    return redirect()->route('front.home');
});

// Route::get('/login', function ()  {
//     return redirect()->route('front.home')->name('login');
// });


Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/robots.txt', [FrontController::class, 'robotsText']);

// Route::get('service-request', [ContactController::class, 'serviceRequest'])->name('front.service_request');
// Route::get('/search/{keyw}',[FrontController::class,'ajaxSearchProduct']);
// require __DIR__.'/sura.php';
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
require __DIR__ . '/admin-auth.php';


// Route::get('/admin/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth:admin'])->name('admin.dashboard');

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users', 'AdminController');
    Route::post('/user-status-change', [AdminController::class, 'userStatusChange'])->name('user.change.status');

    Route::post('/common-status-change', [AjaxController::class, 'statusChange']);

    Route::resource('categories', 'CategoryController');
    Route::resource('subcategories', 'SubCategoryController');

    Route::get('/upload/contact', [CompanyController::class, 'uploadcontact'])->name('upload.contact');
    Route::post('/upload/contact', [CompanyController::class, 'uploadcontactsubmit'])->name('upload.contactsubmit');

    Route::get('/temp-user-store', [AdminController::class, 'tempUserCreate']);
    Route::get('/temp-brand-store', [AdminController::class, 'tempBrandCreate']);
    Route::get('/temp-company-store', [AdminController::class, 'tempCompanyCreate']);
    Route::get('/temp-customer-store', [AdminController::class, 'tempCustomerCreate']);
    Route::get('/temp-subcat-store', [AdminController::class, 'tempSubcategoryCreate']);
    Route::get('/temp-product-store', [AdminController::class, 'tempProductCreate']);
    Route::get('/temp-lead-store', [AdminController::class, 'tempLeadCreate']);
    Route::get('/temp-lead-details-store', [AdminController::class, 'tempLeadDetailsCreate']);
    Route::get('/temp-lead-followup-store', [AdminController::class, 'tempLeadFollowupCreate']);
    Route::get('/temp-lead-quot-store', [AdminController::class, 'tempLeadQuotCreate']);
    Route::get('/temp-quot-details-store', [AdminController::class, 'tempQuotDetailsCreate']);
    Route::get('/temp-quot-terms-store', [AdminController::class, 'tempQuotTermsCreate']);
    Route::get('/temp-po-store', [AdminController::class, 'tempPOCreate']);
    Route::get('/temp-order-delivery-store', [AdminController::class, 'tempOrderDeliveryCreate']);
    Route::get('/temp-proforma-store', [AdminController::class, 'tempProformaCreate']);
    Route::get('/temp-proforma-details-store', [AdminController::class, 'tempProformaDetailsCreate']);
});
