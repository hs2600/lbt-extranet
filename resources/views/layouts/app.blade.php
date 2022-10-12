<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel Quickstart - Basic</title>

  <!-- Fonts -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

  <!-- Styles -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/main.css" rel="stylesheet">
  {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

  <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.js"></script>

  <style>
    body {
      padding-top: 75px;
      font-family: lato, source sans pro, sans-serif;
    }

    .search {
      border: 1px solid #666;
      border-radius: 5px;
      padding: 10px 20px;
     min-width: 600px;
      max-height: 500px;
      background-color: white;
      margin-right: 20px;
      overflow-y: auto;
    }
  </style>
  @livewireStyles
</head>

<body id="app-layout">

  <nav class="navbar navbar-default navbar-fixed-top justify-content-between">
    <div class="container navbar-container">
      <div class="col-md-8">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="/collections" style="padding: 10px;">
            <img class="invert_effect" src="/assets/images/logo.png" style="width: 75%;">
          </a>

        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/collections">Home</a></li>
            <li><a href="/collections/">Material</a></li>
            <li><a href="/collections/series/">Series</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-4" style="padding-top: 7px;">

        <div>



          @livewire('search-product')

        </div>
      </div>
    </div>

  </nav>

  @yield('content')


  <footer class="footer">
    <div class="container">

      <div class="d-none d-lg-block" style="height:25px"></div>

      <div class="row">
        <div class="col-sm-1 col-md-1 col-lg-1"></div>

        <div class="col-sm-3 col-md-3 col-lg-3">
          <div class="bs-component">
            COLLECTIONS<br>
            <a href="/collections/ceramic">Ceramic</a><br>
            <a href="/collections/concrete">Concrete</a><br>
            <a href="/collections/glass">Glass</a><br>
            <a href="/collections/ceramic/jonathan adler">Jonathan Adler</a><br>
            <a href="/collections/glass/tommy bahama">Tommy Bahama</a><br>
            <a href="/collections/">All</a><br>
          </div>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3">
          <div class="bs-component">
            FEATURED<br>
            <a href="/collections/ceramic/shelter island">Shelter Island</a><br>
            <a href="/collections/ceramic/momentum">Momentum</a><br>
            <a href="/collections/ceramic/linen">Linen</a><br>
            <a href="/collections/glass/tommy bahama">Tommy Bahama</a><br>
            <a href="/collections/glass/birdscape">Birdscape</a><br>
            <a href="/collections/series">All</a><br>
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
                  <a href="http://twitter.com/lunadabaytile" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li style="margin-right: 25px; display: inline;">
                  <a href="http://pinterest.com/lunadabaytile" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                </li>
                <li style="margin-right: 25px; display: inline;">
                  <a href="https://www.instagram.com/lunadabaytile" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>
                <li style="margin-right: 25px; display: inline;">
                  <a href="http://houzz.com/lunada-bay-tile" target="_blank"><i class="fa fa-houzz" aria-hidden="true"></i></a>
                </li>
                </li>
                <li style="margin-right: 25px; display: inline;">
                  <a href="http://linkedin.com/company/lunadabaytile" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
                </li>
                <li style="margin-right: 25px; display: inline;">
                  <a href="http://youtube.com/lunadabaytile" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
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
  @livewireScripts


  <script>
    $(document).on('keydown', function(e) {
      if (e.keyCode === 27) { // ESC
        $('.searchDiv').fadeOut(1000);
        setTimeout(function() {
          document.getElementById('txtSearch').value = "";
          document.getElementById('divSearch').innerHTML = "";
        }, 1000);
      }
    });

    $(document).ready(function() {
      $('.txtShowDiv').focus(function() {
        $('.searchDiv').fadeIn(1000);
      }).focusout(function() {
        $('.searchDiv').fadeOut(1000);
      });
    });

</script>

</body>

</html>