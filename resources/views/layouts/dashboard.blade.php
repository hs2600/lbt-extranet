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

  <!-- Livewire -->
  @livewireStyles

  <!-- Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Bootstrap only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">



  <!-- Vendor CSS Files -->
  <link href="/assets/dashboard/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="/assets/dashboard/vendor/simple-datatables/style.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="/assets/dashboard/css/style.css" rel="stylesheet" />

</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center bg-light" style="border-bottom: 1px solid #cddffe; box-shadow: 0px 0px 0px #ffffff;">
    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex">
        <img src="/assets/images/logo.png" style="padding-left: 20px; max-height: 35px; filter: invert(100%)" />
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    @livewire('search-product')


    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword" />
        <button type="submit" title="Search">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div> -->
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle" href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <!-- End Search Icon-->

        @if (Route::has('login'))
        @guest
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
        </li>
        @endguest

        @auth
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-md-block dropdown-toggle ps-2" style="font-weight: 600;">
            {{ Auth::user()->name }}</span> </a>
            <!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              <!-- <span>Title</span> -->
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
  <aside id="sidebar" class="sidebar" style="background-color: #f8f9fa; box-shadow: inset -1px 0 0 rgb(0 0 0 / 10%);">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/collections">
          <i class="bi bi-grid"></i>
          <span>Collections</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/products">
          <i class="bi bi-grid"></i>
          <span>Products</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->

      <!-- Material -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#material-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Material</span><i class="bi bi-chevron-down ms-auto"></i>
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
          <i class="bi bi-layout-text-window-reverse"></i><span>Series</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="series-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
          <a href="/collections/glass/agate">
              <i class="bi bi-circle"></i><span>Agate</span>
            </a>
          </li>
          <li>
          <a href="/collections/glass/birdscape">
              <i class="bi bi-circle"></i><span>Birdscape</span>
            </a>
          </li>

          <li>
          <a href="/collections/glass/tommy bahama glass blends">
              <i class="bi bi-circle"></i><span>Tommy Bahamma</span>
            </a>
          </li>

          <li>
          <a href="/collections/glass/shelter island">
              <i class="bi bi-circle"></i><span>Johnathan Adler</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Series Nav -->


      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/contact">
          <i class="bi bi-envelope"></i>
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

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Lunada Bay Tile</span></strong>. All Rights Reserved
    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/assets/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/dashboard/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/assets/dashboard/vendor/tinymce/tinymce.min.js"></script>

  @livewireScripts

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