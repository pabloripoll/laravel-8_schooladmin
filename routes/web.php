<?php
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
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\FormController as AdminDataController;
use App\Http\Controllers\Admin\FilesController as AdminFilesController;

/*
|-----------------------------------------------------------------------  /
| Public Website
|----------------------------------------------------------------------- */
Route::get('/', function () {
    return view('site/home');
});
Route::get('/home', function () {
    return view('site/home');
});

/*
|-----------------------------------------------------------------------  /
| Administration
|----------------------------------------------------------------------- */
$admin = env('ADMIN_PATH_PREFIX'); // this directory should have a more secured name from .env
Route::group(['prefix' => $admin, 'middleware' => 'auth'], function () {    
    Route::get('/', [AdminPageController::class, 'controller']);
    Route::get('/{panel?}', [AdminPageController::class, 'controller']);
    Route::get('/{panel?}/{section?}', [AdminPageController::class, 'controller']);    
    Route::get('/{panel?}/{section?}/{page?}', [AdminPageController::class, 'controller']);
    Route::get('/files/{target?}/{type?}/{file?}', [AdminFilesController::class, 'privateFiles']);
    Route::post('/json/{panel?}', [AdminDataController::class, 'jsonData']);
    Route::post('/json/{panel?}/{section?}', [AdminDataController::class, 'jsonData']);
    Route::post('/json/{panel?}/{section?}/{page?}', [AdminDataController::class, 'jsonData']);
    Route::post('/form/{panel?}', [AdminDataController::class, 'formData']);
    Route::post('/form/{panel?}/{section?}', [AdminDataController::class, 'formData']);
    Route::post('/form/{panel?}/{section?}/{page?}', [AdminDataController::class, 'formData']);    
});

require __DIR__.'/auth.php';