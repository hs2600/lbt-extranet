@extends('layouts.dashboard')

@section('content')



<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-header">

          <h4 class="card-title">Collections by Material</h4>

        </div>
        <div class="card-body" style="padding: 10px;">

        <div class="row" style="--bs-gutter-x: 0rem;">

            @if (count($collections) > 0)
            @foreach ($collections as $collection)

            <div class="col-md-4 img-container" style="border: 1px solid #efefef; padding: 0px; min-height: 200px;">
              <a href="/collections/{{ $collection->material }}">
                <?php
                $image = $collection->series;
                if ($image == "-") {
                  $image = $collection->material;
                }
                $image = strtolower(str_replace(" ", "_", $image)) . "_h.png";
                ?>
                <img src="/assets/images/products/{{ $image }}" class="img-preview" style="width: 100%;">
                <span class="middle-vis">
                  {{ $collection->material }} <span class="fa fa-arrow-circle-right"></span>
                </span>
              </a>
            </div>

            @endforeach
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection