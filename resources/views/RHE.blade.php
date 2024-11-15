<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Recurso Humano</title>
    <script type="text/javascript">

    icremento =0;
    function crear(obj) {
        icremento++;
        field = document.getElementById('field');
        contenedor = document.createElement('div');
            contenedor.id = 'div'+icremento;
        field.appendChild(contenedor);
        
        selectList = document.createElement('select');
        var myParent = document.body;

        var array = ["Investigador Titular","Investigador Asociado", "Investigador Tecnico","Investigador Titular(Contratado)"];
        selectList.id = "mySelect";
        myParent.appendChild(selectList);

        for (var i = 0; i < array.length; i++) {
            var option = document.createElement("option");
            option.value = array[i];
            option.text = array[i];
            selectList.appendChild(option);
        }
        selectList.class = "form-control col-4";
        selectList.style="width : 270px; heigth : 100px"
        contenedor.appendChild(selectList);

        boton = document.createElement('input');
            boton.type = 'text';
            boton.placeholder = '---------';
            boton.name = 'text'+'[ ]';
            boton.disabled = 'disabled';
            boton.class="form-control col-2";
            boton.style="width : 170px; heigth : 100px";
        contenedor.appendChild(boton);

        boton = document.createElement('input');
            boton.type = 'number';
            boton.placeholder = '000';
            boton.min = '1';
            boton.max = '999'
            boton.name = 'text'+'[ ]';
            boton.class="form-control col-1";
            boton.style="width : 100px; heigth : 100px";
        contenedor.appendChild(boton);

        boton = document.createElement('input');
            boton.type = 'number';
            boton.placeholder = '00000';
            boton.min = '1';
            boton.max = '99999';
            boton.name = 'text'+'[ ]';
            boton.disabled = 'disabled';
            boton.class="form-control col-2";
            boton.style="width : 110px; heigth : 100px";
        contenedor.appendChild(boton);
    
        boton = document.createElement('input');
            boton.type = 'number';
            boton.placeholder = '00000';
            boton.min = '1';
            boton.max = '99999';
            boton.name = 'text'+'[ ]';
            boton.disabled = 'disabled';
            boton.class="form-control col-2";
            boton.style="width : 110px; heigth : 100px";
        contenedor.appendChild(boton);
    
        }
        function borrar(obj) {
        field = document.getElementById('field');
        field.removeChild(document.getElementById(obj));
        }
    </script>
    </head>
<body class="bg-primary">
{{-- <form name="form1" method="POST" action="save.php"> --}}
    <div class="container text-center mb-4">
        <h1 class= "display-1 mt-4 text-white "> Recurso Humano </h1>
    </div>
    <div class="container jumbotron col-6 shadow-lg rounded font-weight-light">
    {{-- <input name="save" type="submit" value="Guardar" onclick="enviar(this)"> --}}
    <form action="paginaBienvenida" method="get">
        <div class="form-group ">
        <input type="button" value="+ Nuevo" onclick="crear(this)">
        <fieldset id="field">   
            <div class="input-group">
                <div class="col-4" id="div1">
                    <label class="form"> Concepto </label>
                    {{-- <select name="transporte" class="form-control">
                        <option>Investigador Titular</option>
                        <option>Investigador Asociado</option>
                        <option>Investigador Tecnico</option>
                        <option>Investigador Titular(Contratado)</option>
                    </select>
                    <input type="text" class="form-control" name="nombre" placeholder="dias" disabled> --}}
                </div>
                <div class="col-2" id="div2">
                    <label class="form"> Unidad </label>
                    {{-- <input type="number" class="form-control" name="nombre" placeholder="00000" min="1" max="99999" disabled> --}}
                </div>
                
                <div class="col-2" id="div3">
                    <label class="form"> Cantidad </label>
                    {{-- <input type="number" class="form-control" name="nombre" placeholder="000" min="1" max="999"> --}}
                </div>
                <div class="col-1" id="div4">
                    <label  class="form"> P.U.($) </label>
                    {{-- <input type="number" class="form-control" name="nombre" placeholder="0000" min="1" max="9999" disabled> --}}
                </div>
                <div class="col-2" id="div5">
                    <label class="form"> Total ($) </label>
                    {{-- <input type="number" class="form-control" name="nombre" placeholder="00000" min="1" max="99999" disabled> --}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-success"><i class="fas fa-sign-in-alt"></i>Registrar</button>
        </div>
    </fieldset>
    </form>
    </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>