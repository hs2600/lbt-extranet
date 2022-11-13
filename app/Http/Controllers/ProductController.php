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
    public function collections()
    {
        error_log("INFO: get /");
        return view('collections_by_series', [
            'collections' => Collection::orderBy('status', 'desc')
                ->orderBy('series', 'asc')
                ->where('category', '=', 'series')
                ->where('status', '!=', '1')
                ->paginate(12)
        ]);
    }


    /**
     * Show collections by Material
     */
    public function collectionsMaterial()
    {
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
    public function collectionsByMaterial($material)
    {
        error_log("INFO: get /");
        return view(
            'collections_by_material',
            [
                'collections' => Collection::orderBy('status', 'desc')
                    ->orderBy('series', 'asc')
                    ->where('category', '=', 'series')
                    ->where('material', '=', $material)
                    ->where('status', '!=', '1')
                    ->paginate(12)
            ],
            [
                'collection' => Collection::orderBy('material', 'asc')
                    ->selectRaw('description')
                    ->where('category', '=', 'Material')
                    ->where('material', '=', $material)
                    ->limit(1)
                    ->get()
            ]
        )
            ->with('material', ucfirst($material));
    }


    /**
     * Show collections by Material/Series/Size
     */
    public function collectionsByMaterialSeries($material, $series)
    {
        error_log("INFO: get /");
        return view(
            'collections_material_series',
            [
                'products' => Product::orderBy('size', 'asc')
                    ->leftjoin('collections as series', function ($join) {
                        $join->on('products.material', '=', 'series.material')
                            ->On('products.series', '=', 'series.series')
                            ->where('series.category', '=', 'series');
                    })
                    ->leftjoin('collections as size', function ($join) {
                        $join->on('products.material', '=', 'size.material')
                            ->On('products.series', '=', 'size.series')
                            ->On('products.size', '=', 'size.size')
                            ->where('size.category', '=', 'size');
                    })
                    ->select(
                        'products.material',
                        'products.series',
                        'products.size',
                        'series.img_url as series_img_url',
                        'size.technical_name as size_technical_name'
                    )
                    ->where('products.material', '=', $material)
                    ->where('products.series', '=', str_replace('Ã©', 'é', $series))
                    ->where('products.status', '!=', '1')
                    ->groupBy('products.material', 'products.series', 'products.size', 'series.img_url', 'size.technical_name')
                    ->paginate(18)
            ],
            [
                'collection' => Collection::orderBy('material', 'asc')
                    ->selectRaw('description, default_color, default_finish, img_url')
                    ->where('category', '=', 'series')
                    ->where('material', '=', $material)
                    ->where('series', '=', $series)
                    ->limit(1)
                    ->get()
            ]
        )
            ->with('material', ucfirst($material))
            ->with('series', ucfirst($series));
    }



    /**
     * Show size
     */
    public function collectionsByMaterialSeriesSize($material, $series, $size)
    {
        error_log("INFO: get /");
        return view(
            'collections_material_series_size',
            [
                'products' => Product::orderBy('item', 'asc')
                    ->leftjoin('collections as size', function ($join) {
                        $join->on('products.material', '=', 'size.material')
                            ->On('products.series', '=', 'size.series')
                            ->On('products.size', '=', 'size.size')
                            ->where('size.category', '=', 'size');
                    })
                    ->selectRaw('products.sku, products.item, products.description
                    , products.material, products.series, products.size, products.color
                    , products.finish, products.site, products.qty_p as qty, products.uofm, products.img_url
                    , size.technical_name as size_technical_name')
                    ->where('products.material', '=', $material)
                    ->where('products.series', '=', str_replace('Ã©', 'é', $series))
                    ->where('products.size', '=', str_replace('_', '/', $size))
                    ->paginate(50)
            ],
            [
                'collection' => Collection::orderBy('material', 'asc')
                    ->selectRaw('size_desc as description, img_url')
                    ->where('category', '=', 'series')
                    ->where('material', '=', $material)
                    ->where('series', '=', $series)
                    ->limit(1)
                    ->get()
            ]
        )
            ->with('material', ucfirst($material))
            ->with('series', ucfirst($series))
            ->with('size', ucfirst($size));
    }


    /**
     * Show products
     */
    public function productsAll()
    {
        error_log("INFO: get /");
        return view('products', [
            'products' => Product::orderBy('item', 'asc')
                ->simplePaginate(30)
        ]);
    }

    /**
     * [TEST] Show products by price level
     */
    public function productsPL()
    {
        error_log("INFO: get /");
        
        $testColumn = 'material as qty';

        $selectedFields = 'sku, item, description, series, size, color, finish, site, uofm, ' . $testColumn;

        return view('products_pl', [
            'products' => Product::orderBy('item', 'asc')
            ->selectRaw($selectedFields)
            ->simplePaginate(30)
        ])
        ->with('selectedFields', $selectedFields);
    }

    /**
     * Show products - Search
     */
    public function productsSearch()
    {
        error_log("INFO: get /");
        return view('products_search');
    }

    /**
     * Show products - Search v3
     */
    public function productsSearchv3()
    {
        error_log("INFO: get /");

        return view('products_searchv3');
    }

    /**
     * Show products - Search CSR
     */
    public function productsSearchv4()
    {
        error_log("INFO: get /");

        return view('products_searchv4');
    }

    /**
     * Show products v2
     */
    public function productsID($id)
    {

        $series_desc = '';
        $size_desc = '';

        $product = Product::where('sku','=', $id)
        ->selectraw('sku, item, description, material, series, size, color, finish, qty_p as qty, pl_57 as price')
        ->first();

        // print_r($product);

        $collection = Collection::where('category','=', 'series')
        ->where('material','=', $product->material)
        ->where('series','=', $product->series)
        ->first();

        $series_desc = $collection->description;
        $size_desc = $collection->size_desc;

        $product_sizes = Product::orderBy('item', 'asc')
            ->where('material', '=', $product->material)
            ->where('series', '=', $product->series)
            ->where('color', '=', $product->color)
            ->selectraw('sku, item, description, material, series, size, color, finish, qty_p as qty')
            ->get();

        $product_colors = Product::orderBy('item', 'asc')
            ->where('material', '=', $product->material)
            ->where('series', '=', $product->series)        
            ->where('size', '=', $product->size)
            ->selectraw('sku, item, description, material, series, size, color, finish, qty_p as qty')
            ->get();

        $product_lots = Quantity::orderBy('item', 'asc')
            ->selectRaw('item, lot, sum(qty_p) as qty')
            ->where('sku', '=', $id)
            ->groupBy('item')
            ->groupBy('lot')
            ->having('qty', '>', 0)
            ->orderBy('qty', 'desc')
            ->orderBy('lot', 'asc')
            ->get();

        return view('product')
            ->with('product', $product)
            ->with('product_sizes', $product_sizes)
            ->with('product_colors', $product_colors)
            ->with('product_lots', $product_lots)
            ->with('series_desc', $series_desc)
            ->with('size_desc', $size_desc);

    }

}
