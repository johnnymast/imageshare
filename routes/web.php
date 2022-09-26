<?php

use App\Models\ImageUpload;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('image.upload');
});

Route::get('/expired', function() {
    return response()->view('errors.expired')->setStatusCode(404);
})->name('image.expired');

Route::get('image/{imageupload:hash}', '\App\Http\Controllers\ImageController@getImageData')->name('image.data');
Route::get('{imageupload:hash}', '\App\Http\Controllers\ImageController@showImage')->name('image.show');

Route::resource('upload', \App\Http\Controllers\UploadController::class, [
    'names' => [
        'index' => 'upload.index',
        'create' => 'upload.create',
        'store' => 'upload.upload',
        'show' => 'upload.show',
        'edit' => 'upload.edit',
        'update' => 'upload.update',
        'destroy' => 'upload.destroy'
    ],
])->parameters([
    'upload' => 'imageupload:hash',
]);;
