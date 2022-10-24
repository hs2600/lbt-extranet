@extends('layouts.dashboard')

@section('content')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center 
 pt-3 mb-2 border-bottom">

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">

      <li class="breadcrumb-item"><a href="/collections/">Collections</a></li>
      <li class="breadcrumb-item"><a href="/collections/material">Material</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ $material }}">{{ $material }}</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ $material }}/{{ $series }}">{{ ucwords($series) }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ str_replace('_', '/', $size) }}</li>
    </ol>
  </nav>

</div>


<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">


      @if (count($products) > 0)

      <div class="card">
        <div class="card-header">
          <!-- <h6 class="card-title">{{ ucwords(str_replace('Ã©', 'é', $series)) }} Items by Size</h6> -->

          <h4 class="card-title">{{ ucwords(str_replace('1/2','0.5', str_replace('_', '/', $size))) }}</h4>

        </div>
        <div class="card-body" style="padding: 10px;">

          <table class="table table-striped table-borderless datatable">
            <thead>
              <th scope="col">Item</th>
              <th scope="col">Description</th>
              <th scope="col">Color</th>
              <th scope="col">Finish</th>
              <th scope="col">Site</th>
              <th scope="col">Qty</th>
              <th scope="col">UofM</th>
            </thead>
            <tbody>
              @foreach ($products as $product)
              <tr>
                <td>
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
</section>

@endsection