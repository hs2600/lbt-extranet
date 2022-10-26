<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;
use App\Models\Quantity;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function home()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $sku
     * @return \Illuminate\Http\Response
     */
    public function showSku($sku)
    {
        return Product::where('sku', $sku)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    ///---------------------

    /**
    * Show collections by Series (All)
    */
    public function collections(){
    error_log("INFO: get /");
    return view('collections_by_series', [
        'collections' => Collection::orderBy('status', 'desc')
                    ->orderBy('series', 'asc')
                    ->where('series', '!=', '-')
                    ->where('status', '!=', '1')                        
                    ->paginate(16)
    ]);
    }


    /**
    * Show collections by Material
    */
    public function collectionsMaterial(){
        error_log("INFO: get /");
        return view('collections_material', [
            'collections' => Collection::orderBy('material', 'asc')
            ->where('category', '=', 'Material')
            ->where('status', '!=', '1')
            ->get()
        ]);
    }


    /**
    * Show collections by Material/Series
    */
    public function collectionsByMaterial($material){
        error_log("INFO: get /");
        return view('collections_by_material', [
            'collections' => Collection::orderBy('status', 'desc')
                        ->orderBy('series', 'asc')
                        ->where('material', '=', $material)
                        ->where('series', '!=', '-')
                        ->where('status', '!=', '1')                        
                        ->paginate(16)
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
    }


    /**
    * Show collections by Material/Series/Size
    */
    public function collectionsByMaterialSeries($material, $series){
        error_log("INFO: get /");
        return view('collections_material_series', [
            'products' => Product::orderBy('size', 'asc')
            ->leftjoin('collections', function ($join) {
                $join->on('products.material', '=', 'collections.material')
                    ->On('products.series', '=', 'collections.series');
                })
                ->select('products.material', 'products.series', 'products.size', 'collections.img_url as series_img_url')
                ->where('products.material', '=', $material)
                ->where('products.series', '=', str_replace('é', 'Ã©', $series))
                ->where('products.status', '!=', '1')
                ->groupBy('products.material', 'products.series', 'products.size', 'collections.img_url')
                ->paginate(18)
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
    }



    /**
    * Show size
    */
    public function collectionsByMaterialSeriesSize($material, $series, $size){
        error_log("INFO: get /");
        return view('collections_material_series_size', [
          'products' => Product::orderBy('item', 'asc')
                        ->where('material', '=', $material)
                        ->where('series', '=', str_replace('é', 'Ã©', $series))
                        ->where('size', '=', str_replace('_', '/', $size))
                        ->paginate(50)
        ])
        ->with('material', ucfirst($material))
        ->with('series', ucfirst($series))
        ->with('size', ucfirst($size))
        ;
    }


    /**
     * Show products
     */
    public function productsAll(){
      error_log("INFO: get /");
      return view('products', [
        'products' => Product::orderBy('item', 'asc')
        ->simplePaginate(30)
      ]);
    }


    /**
     * Show products - Search
     */
    public function productsSearch(){
        error_log("INFO: get /");
        return view('products_search');
      }

    /**
     * Show products - Search v3
     */
    public function productsSearchv3(){
        error_log("INFO: get /");

        return view('products_searchv3');
      }

    /**
     * Show products
     */
    public function productsID($id){
      error_log("INFO: get /");

        $product_sizes = Product::orderBy('item', 'asc')
        ->leftjoin('products as product_sizes', function ($join) {
        $join->on('products.material', '=', 'product_sizes.material')
             ->On('products.series', '=', 'product_sizes.series')
             ->On('products.color', '=', 'product_sizes.color');
        })
        ->select('product_sizes.*')
        ->where('products.sku', '=', $id)
        ->get();

        $product_lots = Quantity::orderBy('item', 'asc')
        ->orderBy('bin', 'asc')
        ->orderBy('lot', 'asc')
        ->orderBy('qty', 'desc')
        ->where('sku', '=', $id)
        ->get();

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
      ->with('product_sizes', $product_sizes)
      ->with('product_lots', $product_lots)
      ;
    }


}
