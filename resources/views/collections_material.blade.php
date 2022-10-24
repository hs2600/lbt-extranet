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

            <div class="col-md-4 img-container" style="
             min-height: 200px;
             max-height: 700px;
             padding: 5px;
             overflow: hidden;
             ">
              <a href="/collections/{{ $collection->material }}">
                <?php
                $image = $collection->series;
                if ($image == "-") {
                  $image = $collection->material;
                }
                $image = strtolower(str_replace(" ", "_", $image)) . ".png";
                ?>
                <img src="/assets/images/products/{{ $image }}" class="img-preview"
                style="
                height: 100%;
                object-fit: cover;
                border-radius: 5px;
                ">
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