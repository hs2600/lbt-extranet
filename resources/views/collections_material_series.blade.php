@extends('layouts.app')

@section('content')

<div class="header-container" style="background-image: url(/assets/images/hd2_bg.png) !important; background-size: 100%; background-position: bottom; background-repeat: repeat;">
    <div style="background-color: rgba(5,64,60,0.65); padding: 20px 0px;">
    <div class="container">
      <div class="row center-block">
        <h1>{{ ucwords(str_replace('Ã©', 'é', $series)) }}</h1>
      </div>
      <div class="center-block text-justify">
        <h4 style="font-family: Times New Roman;">
          @foreach ($collection as $collection)
          {{ $collection->description }}
          @endforeach
        </h4>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="col-md">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/collections/">Collections</a></li>    
            <li class="breadcrumb-item"><a href="/collections/material">Material</a></li>
        <li class="breadcrumb-item"><a href="/collections/{{ $material }}">{{ $material }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ ucwords($series) }}</li>
      </ol>
    </nav>    

    @if (count($products) > 0)

    <div class="card">
      <div class="card-header">
        <h2 class="card-title">{{ ucwords(str_replace('Ã©', 'é', $series)) }} Items by Size</h2>
      </div>
      <div class="card-body">
        <table class="table table-striped task-table">
          <thead>
            <th>Size</th>
          </thead>
          <tbody>
            @foreach ($products as $product)
            <tr>
              <td class="table-text">
                <div><a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}"> {{ $product->size }} </a></div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection