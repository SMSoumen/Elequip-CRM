<?php

use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\FeatureController;
// use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/command', function ()  {
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
require __DIR__.'/admin-auth.php';


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin'])->name('admin.dashboard');

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users', 'AdminController');
    Route::post('/user-status-change', [UserController::class, 'userStatusChange'])->name('user.change.status');

    Route::post('/common-status-change', [AjaxController::class, 'statusChange']);

    Route::resource('categories', 'CategoryController');
    Route::resource('subcategories', 'SubCategoryController');

    // Elequip CRM 
    Route::resource('product-categories', 'ProductCategoryController');
    Route::resource('products', 'ProductController');
    // Elequip CRM 


    // Route::resource('product_types', 'ProductTypeController');
    // Route::resource('categoryfeatureicon', 'CategoryFeatureIconController');
    // Route::resource('icons', 'IconController');
    // Route::resource('features', 'FeatureController');
    // Route::post('feature-sort', [FeatureController::class, 'updateSortOrder'])->name('features.sort');
    // Route::resource('faqs', 'FaqController');
    // Route::resource('product_features', 'ProductFeatureController');

    // Route::get('categories-treeview', [CategoryController::class, 'treeView'])->name('category.treeview');
    // Route::resource('brands', 'BrandController');
    // Route::resource('units', 'UnitController');
    // Route::resource('taxes', 'TaxController');

    // Route::resource('attributes', 'AttributeController');
    // Route::resource('attribute-values', 'AttributeValueController');


    // Route::resource('products', 'ProductController');
    // Route::post('/get-attr-value', [AjaxController::class, 'getProductAttrValue']);
    // Route::post('/get-variant-template', [AjaxController::class, 'getProductVariantTemplate']);
    
    // Route::resource('diseases', 'DiseaseController');
    // Route::resource('drugs', 'DrugController');
    // Route::get('drug-import', [DrugController::class, 'importDrug'])->name('drug_import');
    // Route::post('drug-import', [DrugController::class, 'importDrugSubmit'])->name('drug_import.store');

    // Route::resource('pages', 'PageController');
    // Route::resource('frontusers', 'CustomerController');

    // Route::resource('vendors', 'VendorController');
    
    // Route::resource('product_attributes', 'ProductAttributeController');
    // Route::resource('product_attribute_values', 'ProductAttributeValueController');
    // Route::resource('productgroups', 'ProductgroupController');
    // Route::resource('homebanners', 'HomebannerController');

    // Route::resource('blog-category', 'BlogCategoryController');
    // Route::resource('blog', 'BlogController');


    // Route::resource('service_center', 'ServiceCenterController');
    // Route::resource('pagevisit', 'PageVisitController')->only('index');
    
});