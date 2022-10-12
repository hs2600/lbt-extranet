<?php

use Illuminate\Support\Facades\Route;

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
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;



Route::get('/', function () {
    return view('welcome');
});

/**
    * Show collections by Material
    */
    Route::get('/collections', function () {
        error_log("INFO: get /");
        return view('collections', [
            'collections' => Collection::orderBy('material', 'asc')->where('category', '=', 'Material')->get()
        ]);
    });


    /**
    * Show collections by Series (All)
    */
    Route::get('/collections/series', function () {
        error_log("INFO: get /");
        return view('collections_series_all', [
            'collections' => Collection::orderBy('status', 'desc')
                        ->orderBy('series', 'asc')
                        ->where('series', '!=', '-')
                        ->where('status', '!=', '1')                        
                        ->paginate(15)
        ]);
    });


/**
    * Show collections by Material/Series
    */
    Route::get('/collections/{material}', function ($material) {
        error_log("INFO: get /");
        return view('collections_series', [
            'collections' => Collection::orderBy('status', 'desc')
                        ->orderBy('series', 'asc')
                        ->where('material', '=', $material)
                        ->where('series', '!=', '-')
                        ->where('status', '!=', '1')                        
                        ->paginate(15)
        ]
        , [
            'collection' => Collection::orderBy('material', 'asc')
            ->selectRaw('description')
            ->where('category', '=', 'Material')
            ->where('material', '=', $material)
            ->limit(1)
            ->get()
        ])        
        ->with('material', ucfirst($material));
    });


/**
    * Show collections by Material/Series/Size
    */
    Route::get('/collections/{material}/{series}', function ($material, $series) {
        error_log("INFO: get /");
        return view('collections_size', [
            'products' => Product::orderBy('size', 'asc')
                      ->selectRaw('material, series, size')
                      ->where('material', '=', $material)
                      ->where('series', '=', $series)
                      ->where('status', '!=', '1')
                      ->groupBy('material', 'series', 'size')
                      ->get()
        ]
        , [
            'collection' => Collection::orderBy('material', 'asc')
            ->selectRaw('description')
            ->where('material', '=', $material)
            ->where('series', '=', $series)            
            ->limit(1)
            ->get()
        ])        
        ->with('material', ucfirst($material))
        ->with('series', ucfirst($series))
        ;
    });



/**
    * Show size
    */
    Route::get('/collections/{material}/{series}/{size}', function ($material, $series, $size) {
        error_log("INFO: get /");
        return view('products_size', [
          'products' => Product::orderBy('item', 'asc')
                        ->where('material', '=', $material)
                        ->where('series', '=', $series)
                        ->where('size', '=', str_replace('_', '/', $size))
                        ->paginate(10)
        ])
        ->with('material', ucfirst($material))
        ->with('series', ucfirst($series))
        ->with('size', ucfirst($size))
        ;
    });


/**
     * Show products
     */
    Route::get('/products', function () {
      error_log("INFO: get /");
      return view('products', [
        'products' => Product::orderBy('item', 'asc')->paginate(10)
      ]);
    });


/**
     * Show products
     */
    Route::get('/products/{id}', function ($id) {
      error_log("INFO: get /");
      return view('product', [
        'products' => Product::orderBy('item', 'asc')
        ->leftjoin('collections', function ($join) {
        $join->on('products.material', '=', 'collections.material')
          ->On('products.series', '=', 'collections.series');
        })
        ->select('products.*', 'collections.description as material_desc', 'collections.series_desc', 'collections.img_url as series_img_url')
        ->where('sku', '=', $id)
        ->limit(1)
        ->get()
      ], [
        'product_colors' => Product::orderBy('item', 'asc')
        ->leftjoin('products as product_colors', function ($join) {
        $join->on('products.material', '=', 'product_colors.material')
             ->On('products.series', '=', 'product_colors.series')
             ->On('products.size', '=', 'product_colors.size');
        })
        ->select('product_colors.*')
        ->where('products.sku', '=', $id)
        ->get()
      ])
      ;
    });



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
