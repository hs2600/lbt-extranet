<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Extranet for Lunada Bay Tile for Product Inquiry">
  <meta name="author" content="Horacio Santoyo">
  <meta name="generator" content="Hugo 0.104.2">
  <title>Lunada Bay Tile Extranet</title>

  <!-- JQuery -->
  <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.js"></script>
  <!-- Custom styles -->
  <link href="/assets/css/imgpreview.css" rel="stylesheet">


  <!-- Livewire -->
  @livewireStyles

  <!-- Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Bootstrap only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .card-body a {
      text-decoration: underline !important;
      color: #0057af !important;
    }

    .card-body a:hover {
      color: #52a8ff !important;
      text-decoration: none !important;
    }

    .breadcrumb-item a {
      color: #0d6efd !important;
      text-decoration: none !important;
    }

    .breadcrumb-item a:hover {
      color: #52a8ff !important;
      text-decoration: none !important;
    }
  </style>


</head>

<body class="d-flex flex-column h-100">

  <main>

    <nav class="navbar navbar-expand-lg bg-light sticky-top" aria-label="Eighth navbar example" style="border-bottom: 2px solid #999;">
      <div class="container">

        <a class="navbar-brand" href="/collections" style="padding: 10px;">
          <img class="invert_effect" src="/assets/images/logo.png" style="width: 75%;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/">Home</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/products">Products</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/collections">Collections</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Material</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/collections/ceramic">Ceramic</a></li>
                <li><a class="dropdown-item" href="/collections/concrete">Concrete</a></li>
                <li><a class="dropdown-item" href="/collections/glass">Glass</a></li>
                <li><a class="dropdown-item" href="/collections/material">All</a></li>
              </ul>
            </li>


            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Series</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/collections/ceramic/shelter island">Shelter Island</a></li>
                <li><a class="dropdown-item" href="/collections/ceramic/momentum">Momentum</a></li>
                <li><a class="dropdown-item" href="/collections/ceramic/linen">Linen</a></li>
                <li><a class="dropdown-item" href="/collections/glass/tommy bahama">Tommy Bahama</a></li>
                <li><a class="dropdown-item" href="/collections/glass/birdscape">Birdscape</a></li>
                <li><a class="dropdown-item" href="/collections">All</a></li>
              </ul>
            </li>

          </ul>
          @livewire('search-product')
        </div>
      </div>
    </nav>

    @yield('content')

  </main>


  <footer class="footer" style="margin-top: auto!important;">
    <div class="container">

      <div class="d-none d-lg-block" style="height:25px"></div>

      <div class="row">
        <div class="col-sm-1 col-md-1 col-lg-1"></div>

        <div class="col-sm-3 col-md-3 col-lg-3">
          <div class="bs-component">
            MATERIALS<br>
            <a href="/collections/ceramic">Ceramic</a><br>
            <a href="/collections/concrete">Concrete</a><br>
            <a href="/collections/glass">Glass</a><br>
            <a href="/collections/material">All</a><br>
          </div>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3">
          <div class="bs-component">
            FEATURED COLLECTIONS<br>
            <a href="/collections/ceramic/shelter island">Shelter Island</a><br>
            <a href="/collections/ceramic/momentum">Momentum</a><br>
            <a href="/collections/ceramic/linen">Linen</a><br>
            <a href="/collections/glass/tommy bahama">Tommy Bahama</a><br>
            <a href="/collections/glass/birdscape">Birdscape</a><br>
            <a href="/collections/">All</a><br>
          </div>
        </div>

        <div class="col-sm-5 col-md-5 col-lg-5">
          <div class="bs-component">
            NEED ASSISTANCE?<br>
            <a href="mailto:Info@Thousandfold.store">
              Info@LunadaBayTile.com
            </a><br><br>
            <span style="font-size: 25px;">
              <ul>
                <li style="margin-right: 25px; display: inline;">
                  <a href="http://twitter.com/lunadabaytile" target="_blank">
                    <i class="fa-brands fa-twitter"></i>
                  </a>
                </li>
                <li style="margin-right: 25px; display: inline;">
                  <a href="http://pinterest.com/lunadabaytile" target="_blank">
                    <i class="fa-brands fa-pinterest"></i>
                  </a>
                </li>
                <li style="margin-right: 25px; display: inline;">
                  <a href="https://www.instagram.com/lunadabaytile" target="_blank">
                    <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                  </a>
                </li>
                <li style="margin-right: 25px; display: inline;">
                  <a href="http://houzz.com/lunada-bay-tile" target="_blank">
                    <i class="fa-brands fa-houzz" aria-hidden="true"></i>
                  </a>
                </li>

                <li style="margin-right: 25px; display: inline;">
                  <a href="http://linkedin.com/company/lunadabaytile" target="_blank">
                    <i class="fa-brands fa-linkedin" aria-hidden="true"></i>
                  </a>
                </li>

                <li style="margin-right: 25px; display: inline;">
                  <a href="http://youtube.com/lunadabaytile" target="_blank">
                    <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                  </a>
                </li>

              </ul>
            </span>
          </div>

        </div>
      </div>

      <div class="row">
        <hr style="border: 0.5px solid #ccc;">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <div class="d-lg-block" style="height:40px; font-size: 13px ;">
            © 2022 Lunada Bay Tile. All rights reserved.
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- JavaScripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

  <script src="/assets/js/bootstrap.bundle.min.js"></script>

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
      } else {
        // Clicked outside the box
        status = 0;
      }
    });

    $(document).ready(function() {
      $('.txtShowDiv').focusout(function() {
        $('.searchDiv').fadeOut(1000);
      })
    });
  </script>

  @livewireScripts

</body>

</html>