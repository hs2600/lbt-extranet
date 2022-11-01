<?php

use Illuminate\Support\Facades\DB;

$series = DB::table('collections')
  ->where('category', '=', 'series')
  ->where('status', '!=', 1)
  ->orderBy('status', 'desc')
  ->orderBy('series')
  ->limit(10)
  ->get();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Lunada Bay Tile Extranet</title>

  <!-- JQuery -->
  <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.js"></script>
  <!-- Custom styles -->
  <link href="/assets/css/imgpreview.css" rel="stylesheet">
  <link href="/assets/css/dashboard.css" rel="stylesheet">

  <!-- Livewire -->
  @livewireStyles

  <!-- Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])


  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <script src="https://unpkg.com/@popperjs/core@2"></script>

  <!-- Vendor CSS Files -->
  <link href="/assets/dashboard/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="/assets/dashboard/vendor/simple-datatables/style.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="/assets/dashboard/css/style.css" rel="stylesheet" />

</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center" style="border-bottom: 1px solid #dadce0; box-shadow: 0px 0px 0px #ffffff;">
    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex">
        <img src="/assets/images/logo.png" style="padding-left: 20px; max-height: 35px; filter: invert(100%)" />
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    @livewire('search-product')

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none" style="padding-right: 30px;">
          <a class="nav-link nav-icon search-bar-toggle" href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <!-- End Search Icon-->

        @if (Route::has('login'))
        @guest
        <li class="nav-item dropdown pe-4">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
        </li>
        @endguest

        @auth

        <?php
        $name = Auth::user()->name;
        $name_arr = explode(" ", $name);
        $initials = substr($name_arr[0], 0, 1) . substr($name_arr[1], 0, 1);
        $shortname = substr($name_arr[0], 0, 1) . '.' . $name_arr[1];
        ?>

        <li class="nav-item dropdown pe-4">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

            <div class="no-flex" style="background-color: rgb(204, 208, 236); color: rgb(0, 0, 0);
              padding: 4px 6px;
              border-radius: 100%;
              " onmouseover="this.style.backgroundColor='#AAB1DF'" onmouseout="this.style.backgroundColor='#CCD0EC'">
              {{ $initials }}
            </div>

            <span class="d-md-block dropdown-toggle ps-2" style="font-weight: 600;">
            </span>
          </a>
          <!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header" style="text-align: left;">
              <h6>{{ Auth::user()->name }}</h6>
              <span><i>{{ Auth::user()->email }}</i></span>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/invitations">
                <i class="bi bi-envelope"></i>
                <span>Invitations</span>
              </a>
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li> -->
            <li>
              <hr class="dropdown-divider" />
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
          <!-- End Profile Dropdown Items -->
        </li>
        @endauth
        @endif

        <!-- End Profile Nav -->
      </ul>
    </nav>
    <!-- End Icons Navigation -->
  </header>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar" style="box-shadow: inset -1px 0 0 rgb(255 255 255 / 10%);">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/collections">
        <i class="fa-solid fa-layer-group"></i>
          <span>Collections</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/collections/material">
        <i class="fa-solid fa-layer-group"></i>
          <span>Materials</span>
        </a>
      </li>

      <!-- Material -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#material-nav" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-layer-group"></i>
          <span>Material</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="material-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/collections/ceramic">
              <i class="bi bi-circle"></i><span>Ceramic</span>
            </a>
          </li>
          <li>
            <a href="/collections/concrete">
              <i class="bi bi-circle"></i><span>Concrete</span>
            </a>
          </li>

          <li>
            <a href="/collections/glass">
              <i class="bi bi-circle"></i><span>Glass</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Material Nav -->

      <!-- Series -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#series-nav" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-layer-group"></i>
          <span>Series</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="series-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

          @foreach ($series as $series)

          <?php
            $icon = 'bi bi-circle';
            $icon_size = '6px';

            if($series->status == 2){
                $icon = 'fa-regular fa-star';
                $icon_size = '15px';
            } elseif($series->status == 3){
              $icon = 'fa-solid fa-bullhorn';
              $icon_size = '15px';
            }

          ?>
          <li>
            <a href="/collections/{{ $series->material . '/' . $series->series }}">
              <i class="{{ $icon }}" style="font-size: {{ $icon_size }};"></i>
              <span>{{ $series->series }}</span>
            </a>
          </li>
          @endforeach

        </ul>
      </li>
      <!-- End Series Nav -->

      <li class="nav-item">
        <a class="nav-link" href="/products">
        <i class="fa-solid fa-binoculars"></i>
          <span>Products Search</span>
        </a>
      </li>

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/contact">
          <i class="fa-regular fa-envelope"></i>
          <span>Contact</span>
        </a>
      </li>
      <!-- End Contact Page Nav -->

    </ul>
  </aside>
  <!-- End Sidebar-->

  <main id="main" class="main">

    @yield('content')

  </main>
  <!-- End #main -->


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/assets/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/dashboard/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/assets/dashboard/vendor/tinymce/tinymce.min.js"></script>

  @livewireScripts


  <!-- Product Info Modal -->
  <div class="modal fade p-5" id="exModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <span class="product-title" id="title" style="text-transform: capitalize; font-size: 27px;">title</span>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-size: 35%;"></button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md">

              <div class="row" style="padding: 10px; margin: 0px; margin-bottom: 15px; background-color: #efefef;">
                <div class="col-sm-6">
                  <label><b>Material:</b></label>
                  <span id="cat_material"></span>
                </div>
                <div class="col-sm-6">
                  <label><b>Series:</b></label>
                  <span id="cat_series"></span>
                </div>
                <div class="col-sm-6">
                  <label><b>Size:</b></label>
                  <span id="cat_size"></span>
                </div>
                <div class="col-sm-6">
                  <label><b>Color:</b></label>
                  <span id="cat_color"></span>
                </div>
                <div class="col-sm-6">
                  <label><b>Finish:</b></label>
                  <span id="cat_finish"></span>
                </div>
              </div>

              <div style="background-color: #fafafa; padding: 5px; margin-bottom: 20px;
                border-bottom: 1px solid #ddd;">
                <div class="">
                  <span id="qty" class="product-price"></span>
                </div>
              </div>

            </div>

          </div>

        </div>
      </div>
    </div>
  </div>


  <script>
    function titleCase(str) {
      return str.toLowerCase().replace(/\b\w/g, s => s.toUpperCase());
    }

    function fileMenu(data, ID) {

      const json = data;
      const obj = JSON.parse(json);

      document.getElementById("title").innerHTML = titleCase(obj.description);

      document.getElementById("cat_material").innerHTML = obj.material;
      document.getElementById("cat_series").innerHTML = obj.series;
      document.getElementById("cat_size").innerHTML = obj.size;
      document.getElementById("cat_color").innerHTML = obj.color;
      document.getElementById("cat_finish").innerHTML = obj.finish;

      var uofm = obj.uofm.toLowerCase();
      
      uofm = uofm.replace('each','piece');
      uofm = uofm + 's';

      if (obj.qty_p > 0) {
        document.getElementById("qty").innerHTML = '<b><i>' + obj.qty_p + ' ' + uofm + '</i></b><i> stocked in Harbor City</i>';
      } else {
        document.getElementById("qty").innerHTML = '<b><i style="color: #d35d5d;">Item is currently out of stock.</i></b>';
      }

    }
  </script>


  <!-- Template Main JS File -->
  <script src="/assets/dashboard/js/main.js"></script>

  <script>
    var status = 0;

    $(document).on('keydown', function(e) {
      if (e.keyCode === 27) { // ESC
        $('.searchDiv').fadeOut(500);
        setTimeout(function() {
          document.getElementById('txtSearch').value = "";
          document.getElementById('divSearch').innerHTML = "";
        }, 1000);
      }
    });

    $(document).ready(function() {
      $('.txtShowDiv').focus(function() {
        $('.searchDiv').fadeIn(1000);
      })
    });

    window.addEventListener('click', function(e) {
      if (document.getElementById('divSearch').contains(e.target)) {
        // Clicked in box
        status = 1;
        // alert("in box");
      } else {
        // Clicked outside the box
        status = 0;
        // alert("outside box");
      }
    });

    $(document).ready(function() {
      $('.txtShowDiv').focusout(function() {
        $('.searchDiv').fadeOut(1000);
      })
    });
  </script>


</body>

</html>