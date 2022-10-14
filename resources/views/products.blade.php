@extends('layouts.app')

@section('content')





<div class="container" style="padding-top: 10px;">
  <div class="col-md">

    <div class="card" style="margin-bottom: 20px;">
      <div class="card-header">
        <h6 class="card-title">Product List</h6>
      </div>
      <div class="card-body">
        @if (count($products) > 0)
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Item</th>
              <th scope="col">Description</th>
              <th scope="col">Series</th>
              <th scope="col">Size</th>
              <th scope="col">Color</th>
              <th scope="col">Finish</th>
              <th scope="col">Site</th>
              <th scope="col">Qty</th>
              <th scope="col">UofM</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($products as $product)
          <tr>
              <td scope="row">
                <?php

                $series = str_replace('Ã©', 'é', $product->series);

                echo '<div><a href="/products/' . $product->sku . '">' . $product->item . '</a></div>';

                ?>
              </td>
              <td class="d-none d-md-block">
                <div>{{ $product->description }}</div>
              </td>
              <td>
                <div>{{ $product->series }}</div>
              </td>
              <td>
                <div>{{ $product->size }}</div>
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

            {{ $products->onEachSide(2)->links() }}
    @else

    Nothing to see here...
    <br>
    <a href="/products/">All products</a>
            @endif

      </div>

    </div>

  </div>
</div>

@endsection