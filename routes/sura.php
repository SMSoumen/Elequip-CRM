<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\StoreLocatorController;

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::resource('home-slider', 'HomeSliderController');
    Route::resource('product-enquiry', 'ProductEnquiryController');
    Route::resource('contact-form', 'ContactFormController');
    // Route::resource('newsletter', 'NewsletterController');
    Route::get('/social-media-credential', [SocialMediaController::class, 'index']);
    Route::post('/social-media-credential/add', [SocialMediaController::class, 'credentialAdd']);
    Route::get('/social-media-credential/api', [SocialMediaController::class, 'fetchDataFromApi']);
    Route::resource('job-application', 'JobApplicationController');
    Route::resource('complaints', 'ComplaintController');
    Route::resource('queries', 'QueryController');
    Route::resource('service-request', 'ServiceRequestController');
    Route::resource('contact-us', 'ContactUsController');
    Route::post('/contact-us/add', [ContactUsController::class, 'saveContactDetails']);
    Route::resource('store', 'StoreController');
    Route::resource('customer-care', 'CustomerCareController');
    // Route::post('/store/upload', [StoreController::class, 'excelUpload']);
});

Route::post('/complaint-action', [ContactController::class, 'complaintAdd']);
Route::post('/career-action', [ContactController::class, 'careerAdd']);
Route::post('/query-action', [ContactController::class, 'queryAdd']);
Route::post('/customer_care_action', [ContactController::class, 'customerCareRequestAdd']);
Route::post('/contact-form-action', [ContactController::class, 'contactFormAdd'])->name('front.contact_form_action');
// Route::get('store-locator', [StoreLocatorController::class, 'storeLocator'])->name('front.store_locator');
Route::post('/get-city', [StoreLocatorController::class, 'getCity'])->name('front.getCity');
Route::post('/get-pincode', [StoreLocatorController::class, 'getPincode'])->name('front.getPincode');
Route::post('/get-pincode-store', [StoreLocatorController::class, 'getStoreByPincode'])->name('front.storePincode');

Route::post('/all-cities', [ContactController::class, 'allCities']);

Route::post('/fetch-products', [ContactController::class, 'fetchProducts']);