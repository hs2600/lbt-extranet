<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Lunada Bay Tile Extranet</title>

  <link rel="icon" href="/favicon.ico" />

  <!-- JQuery -->
  <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.js"></script>
  
  <!-- Custom styles -->
  <link href="/assets/css/dashboard.css" rel="stylesheet">

  <!-- Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <!-- Vendor CSS Files -->
  <link href="/assets/dashboard/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="/assets/dashboard/vendor/simple-datatables/style.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="/assets/dashboard/css/style.css" rel="stylesheet" />

</head>

<body>

  <main id="main" class="main">

    @yield('content')

  </main>
  <!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/assets/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>