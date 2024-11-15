<!doctype html>
<html lang="en">
  <head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../img/Logo_IMT_mini.png" type="image/png" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
    crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    {{-- inicio estilos CSS --}}
    <style>
      *{
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell,
        'Open Sans', 'Helvetica Neue', sans-serif;
      }
      body{
        background: #1F4CF0;
      }
      .bg{
        background: #006098;
        background-image: url(../img/modcuadrada.png);
        background-position: 50% 75%;
        background-size:contain;
        background-repeat: no-repeat;
      }
      #redond{
        border-radius: 25px;
      }
      #redondb{
        border-radius: 25px;
        height:40px;
      }
      #redondbc{
        border-radius: 100px;
      }
    </style>
    {{-- fin estilos CSS --}}
  </head>
<body>
  <div class="container w-75 bg-white mt-5 rounded shadow">
    <div class="row align-items-stretch">
      <div class="col bg rounded d-none d-lg-block col-md-5 col-lg-5 col-xl-6">

      </div>
      <div class="col p-5 rounded-end">
          <div class="text-center mt-2">
            <img src='../img/Logo_IMT.png' alt="80" width="100">
          </div>

    @yield('contenido')

        </div>
        <div class="col bg rounded d-none d-lg-block col-md-5 col-lg-5 col-xl-6">

        </div>
    </div>
  </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  </body>
  </html>