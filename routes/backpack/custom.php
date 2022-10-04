<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('category', 'CategoryCrudController');

    // Get Storage Path
    Route::get('get-storage-path/{name}/{filename}', function($name, $filename) {
        $path = storage_path('app/public/'.$name.'/'.$filename);
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    })->name('getStoragePath');
    Route::crud('attributes', 'AttributesCrudController');
    Route::crud('advertisement', 'AdvertisementCrudController');

    Route::get('getadvertisement', 'AdvertisementCrudController@getadvertisement')->name('getadvertisement');
    Route::get('geteditadvertisement', 'AdvertisementCrudController@geteditadvertisement')->name('geteditadvertisement');
    Route::post('ajax-upload-images', 'AdvertisementCrudController@ajaxUploadImages')->name('ajaxUploadImages');
    Route::post('ajax-remove-images', 'AdvertisementCrudController@ajaxRemoveImages')->name('ajaxremoveImages');
    Route::post('editajax-remove-images', 'AdvertisementCrudController@editajaxRemoveImages')->name('editajaxremoveImages');
});
