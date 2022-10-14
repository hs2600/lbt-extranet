@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md">

    <nav aria-label="breadcrumb" style="padding-top: 10px;">
      <ol class="breadcrumb">
        
      <li class="breadcrumb-item"><a href="/collections/">Collections</a></li>    
            <li class="breadcrumb-item"><a href="/collections/material">Material</a></li>
        <li class="breadcrumb-item"><a href="/collections/{{ $material }}">{{ $material }}</a></li>
        <li class="breadcrumb-item"><a href="/collections/{{ $material }}/{{ $series }}">{{ ucwords($series) }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ str_replace('_', '/', $size) }}</li>
      </ol>
    </nav>

    @if (count($products) > 0)
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Products by Size</h6>
      </div>

      <div class="card-body">
        <table class="table table-striped ">
          <thead>
            <th scope="col">Item</th>
            <th scope="col" class="d-none d-md-block">Description</th>
            <th scope="col">Color</th>
            <th scope="col">Finish</th>
            <th scope="col">Site</th>
            <th scope="col">Qty</th>
            <th scope="col">UofM</th>
          </thead>
          <tbody>
            @foreach ($products as $product)
            <tr>
              <td class="d-none d-md-block">
                <div><a href="/products/{{ $product->sku }}">{{ $product->item }}</a></div>
              </td>
              <td>
                <div>{{ $product->description }}</div>
              </td>
              <td>
                <div>{{ $product->color }}</div>
              </td>
              <td>
                <div>{{ $product->finish }}</div>
              </td>
              <td>
                <div>{{ $product->site }}</div>
              </td>
              <td>
                <div>{{ number_format($product->qty,0) }}</div>
              </td>
              <td>
                <div>{{ $product->uofm }}</div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        {{ $products->links() }}
      </div>
    </div>
    @endif
  </div>
</div>
@endsection