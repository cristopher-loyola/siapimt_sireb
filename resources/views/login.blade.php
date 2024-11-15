<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="icon" href="img/Logo_IMT_mini.png" type="image/png" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  </head>

<body>
    <div class="container w-75 bg-white mt-5 rounded shadow">
        <div class="row">
            <div class="col-md-5 col-lg-5 col-xl-5 bg rounded text-center">
                <!-- Contenido en la columna izquierda (imagen y texto) -->
                <br><br>
                <img src="img\Logo_IMT.png" alt="Imagen de sistema" class="img-fluid" style="margin: 0 auto;" style="width: 120%;">
                <h4 class="mt-3 font-weight-bold">Sistema de Reportes Bimestrales</h4>
                <p class="font-weight-bold">Inicio de sesión</p>
              </div>
        <div class="col-md-7 col-lg-7 col-xl-7 p-5 rounded-end">
            <div class="text-end mt-2">
              <img src="img/Tiempo dinero esfuerzo.jpg" class="box">
            </div>
            <form action="loginuser" method="post">
                @if (Session::has('success'))
                  <div class="alert-success">{{Session::get('success')}}</div>
                  <br>
                @endif
                @if (Session::has('fail'))
                  <div class="alert-danger">{{Session::get('fail')}}</div>
                  <br>
                @endif
                @csrf
                <br>
                <div class="mb-4">
                  <label class="form-label"> Usuario </label>
                  <input type="text" class="form-control" name="usuario" placeholder="Usuario" value="{{old('usuario')}}">
                  <span class="text-danger">@error('usuario') {{$message}} @enderror</span>
                </div>
                <div class="mb-4">
                  <label class="form-label">Contraseña </label>
                  <input type="password" class="form-control" name="pass" placeholder="Contraseña" value="{{old('password')}}">
                  <span class="text-danger">@error('password') {{$message}} @enderror</span>
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Acceder</button>
                </div>
                <div class="mb-4">
                  {{-- <hr size=5 color="black"> --}}
                </div>
              </form>
              {{--fIN del Login o Acceso --}}
                {{--          <div class="d-grid">
                <form action="{{route('newuser')}}" method="GET" class="d-grid">
                  <button type="submit" class="btn btn-success" id="redondb">
                    <i class='bx bx-plus-circle bx-fw bx-flashing-hover'></i> Nuevo Usuario
                  </button>
                </form>
              </div>            --}}
        </div>
        </div>
    </div>

  <script src="bootstap.budle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>
</body>
</html>

