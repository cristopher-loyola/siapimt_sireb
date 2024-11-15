<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title> Nueva Tarea</title>
  </head>
<body class="bg-primary">
        <div class="container text-center mb-4">
          <h1 class= "display-1 mt-4 text-white "> Tarea </h1>
          </div>
          <div class="container jumbotron col-6 shadow-lg rounded font-weight-light">
          <form action="tareaproyect" method="get">
            <div class="form-group ">
            <label class="text-primary">Tarea/label</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre de la tarea">
                </div>
            </div>
            <div class="form-group ">
            <label class="text-primary">Fecha de inicio</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="fecha" placeholder="DD-MM-AAAA">
                </div>
            </div>
            <div class="form-group ">
            <label class="text-primary">Fecha de inicio</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="fecha" placeholder="DD-MM-AAAA">
                </div>
            </div>
            <div class="form-group ">
                <label class="text-primary">Duracion</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="duracion" placeholder="DDD" disabled>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i>Acceder</button>
            </div>
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>