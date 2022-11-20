<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

use App\Models\Task;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/collections');
})->middleware(['auth', 'verified'])->name('collections');

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Invitations group with auth middleware.
 * Even though we only have one route currently, the route group is for future updates.
 */
Route::group([
    'middleware' => ['auth', 'admin', 'verified'],
    'prefix' => '/admin/invitations'
], function() {
    Route::get('/', [InvitationController::class, 'index'])
        ->name('showInvitations');
    Route::post('/', [InvitationController::class, 'store']);        
});


//Private routes (Login required)
Route::group(['middleware' => ['auth', 'verified']], function(){
    //products
    Route::get('/products',[ProductController::class, 'productsSearchv3'])->name('products');
    Route::get('/products_search',[ProductController::class, 'productsSearchv3']);
    Route::get('/products_lot',[ProductController::class, 'productsSearchv4']);
    Route::get('/products/{id}',[ProductController::class, 'productsID']);
    Route::get('/products_all',[ProductController::class, 'productsAll']);
    
    //collections
    Route::get('/collections',[ProductController::class, 'collections'])->name('collections');
    Route::get('/collections/material',[ProductController::class, 'collectionsMaterial']);
    Route::get('/collections/{material}',[ProductController::class, 'collectionsByMaterial']);    
    Route::get('/collections/{material}/{series}',[ProductController::class, 'collectionsByMaterialSeries']);
    Route::get('/collections/{material}/{series}/{size}',[ProductController::class, 'collectionsByMaterialSeriesSize']);
    
});

//Throttle (throttle:{seconds:limit}, or throttle:{name}
Route::group(['middleware' => ['auth', 'verified','throttle:dealer-locator']], function(){

    //dealer locator
    Route::get('/find-a-dealer', function () {
        return view('find-dealer.dealer_locator_form');
    });
    Route::get('/dealer_locator',[Controller::class, 'dealerLocatorJS']);
    Route::get('/dealer-locator', function () {
        return view('find-dealer.dealer_locator_livewire');
    });
    Route::get('/dealer_locator/{zip}',[Controller::class, 'dealerLocator']);

});

//Public routes
Route::get('/products_pl',[ProductController::class, 'productsPL']);

/**  TESTING */
/**
    * Show Task Dashboard
    */
Route::get('/tasks', function () {
    error_log("INFO: get /");
    return view('tasks', [
        'tasks' => Task::orderBy('created_at', 'asc')->get()
    ]);
});

/**
    * Add New Task
    */
Route::post('/task', function (Request $request) {
    error_log("INFO: post /task");
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        error_log("ERROR: Add task failed.");
        return redirect('/tasks')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');
});

/**
    * Delete Task
    */
Route::delete('/task/{id}', function ($id) {
    error_log('INFO: delete /task/'.$id);
    Task::findOrFail($id)->delete();

    return redirect('/tasks');
});


require __DIR__.'/auth.php';
