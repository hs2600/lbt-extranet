@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md">

    <nav aria-label="breadcrumb" style="padding-top: 10px;"
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
        <h2 class="card-title">Products by Size</h2>
      </div>

      <div class="card-body">
        <table class="table table-striped task-table">
          <thead>
            <th>SKU</th>
            <th>Item</th>
            <th>Description</th>
            <th>Series</th>
            <th>Size</th>
            <th>Color</th>
            <th>Finish</th>
            <th>Site</th>
            <th>Qty</th>
            <th>UofM</th>
          </thead>
          <tbody>
            @foreach ($products as $product)
            <tr>
              <td class="table-text">
                <div><a href="/products/{{ $product->sku }}">{{ $product->sku }}</a></div>
              </td>
              <td class="table-text">
                <div>{{ $product->item }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->description }}</div>
              </td>
              <td class="table-text">
                <div>{{ str_replace('Ã©', 'é', $product->series) }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->size }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->color }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->finish }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->site }}</div>
              </td>
              <td class="table-text">
                <div>{{ number_format($product->qty,0) }}</div>
              </td>
              <td class="table-text">
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