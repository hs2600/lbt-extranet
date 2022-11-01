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
                ->paginate(16)
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
                    ->paginate(16)
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
     * Show products
     */
    public function productsID($id)
    {
        error_log("INFO: get /");

        $product_sizes = Product::orderBy('item', 'asc')
            ->leftjoin('products as sizes', function ($join) {
                $join->on('products.material', '=', 'sizes.material')
                    ->On('products.series', '=', 'sizes.series')
                    ->On('products.color', '=', 'sizes.color');
            })
            ->leftjoin('collections as size', function ($join) {
                $join->on('sizes.material', '=', 'size.material')
                    ->On('sizes.series', '=', 'size.series')
                    ->On('sizes.size', '=', 'size.size')
                    ->where('size.category', '=', 'size');
            })
            ->selectRaw('sizes.sku, sizes.item, sizes.description, sizes.material
        , sizes.series, sizes.size, sizes.color, sizes.finish, sizes.max_lot_qty_p as qty
        , sizes.uofm, sizes.img_url, sizes.site, size.technical_name as size_technical_name')
            ->where('products.sku', '=', $id)
            ->get();

        $product_colors = Product::orderBy('item', 'asc')
            ->leftjoin('products as colors', function ($join) {
                $join->on('products.material', '=', 'colors.material')
                    ->On('products.series', '=', 'colors.series')
                    ->On('products.size', '=', 'colors.size');
            })
            ->leftjoin('collections as size', function ($join) {
                $join->on('colors.material', '=', 'size.material')
                    ->On('colors.series', '=', 'size.series')
                    ->On('colors.size', '=', 'size.size')
                    ->where('size.category', '=', 'size');
            })
            ->selectRaw('colors.sku, colors.item, colors.description, colors.material
        , colors.series, colors.size, colors.color, colors.finish, colors.max_lot_qty_p as qty
        , colors.uofm, colors.img_url, colors.site, size.technical_name as size_technical_name')
            ->where('products.sku', '=', $id)
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

        return view('product', [
            'products' => Product::orderBy('item', 'asc')
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
                ->selectRaw('products.sku, products.item, products.description
        , products.material, products.series, products.size, products.color
        , products.finish, products.qty_p as qty, products.uofm, products.img_url
        , series.description as series_desc, series.size_desc
        , series.img_url as series_img_url, size.technical_name as size_technical_name')
                ->where('sku', '=', $id)
                ->limit(1)
                ->get()
        ])
            ->with('product_sizes', $product_sizes)
            ->with('product_colors', $product_colors)
            ->with('product_lots', $product_lots);
    }
}
