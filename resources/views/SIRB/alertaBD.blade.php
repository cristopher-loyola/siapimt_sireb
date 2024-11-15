<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="alert alert-success" role="alert">
        <h1 class="alert-heading">¡Se han actualizado los registros de la base de datos!</h1>
        <hr>
        <p class="mb-0" style="font-family: 'Times New Roman', Times, serif; color: gray; font-size: 1.3rem;">Fecha de actualización: <?php echo date('Y-m-d'); ?></p>
    </div>
    <a href="dashboard" class="btn btn-success">Volver</a>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
