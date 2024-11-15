<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Proyecto de iniciativa externa</title>
    <script type="text/javascript">

//---------------Finacieros------------------------------------------------------------------------------
    icremento =0;
    function crearFinanciero(obj) {
        icremento++;
    
        field = document.getElementById('fina');
        contenedor = document.createElement('div');
            contenedor.id = 'div'+icremento;
        field.appendChild(contenedor);

        selectList = document.createElement('select');
        var myParent = document.body;
        var array = ["Viáticos nacionales(Investigador titular)","Viaticos nacionales(Investigador titular)", 
        "Gastos de camino(peajes)","Gastos de camino gasolina(combustible)"];
            selectList.id = "mySelect";
            selectList.style="width : 270px; heigth : 100px";
            selectList.class = "form-control col-4";
        myParent.appendChild(selectList);
        for (var i = 0; i < array.length; i++) {
            var option = document.createElement("option");
            option.value = array[i];
            option.text = array[i];
            selectList.appendChild(option);
        }   
    contenedor.appendChild(selectList);

    boton = document.createElement('input');
        boton.type = 'text';
        boton.placeholder = '----';
        boton.name = 'text'+ '[]';
        boton.disabled = 'disabled';
        boton.class="form-control col-2";
        boton.style="width : 170px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='999';
        boton.name = 'text'+'[ ]';
        boton.placeholder = '000';
        boton.class="form-control col-1";
        boton.style="width : 100px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled = 'disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);
 
    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled='disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);
    }
//---------------Materiales------------------------------------------------------------------------------
    function crearMateriales(obj) {
    icremento++;

    field = document.getElementById('mat');
    contenedor = document.createElement('div');
        contenedor.id = 'div'+icremento;
    field.appendChild(contenedor);

    selectList = document.createElement('select');
    var myParent = document.body;
    var array = ["Comsumibles","Vehiculo"];
        selectList.id = "mySelect";
        selectList.style="width : 270px; heigth : 100px";
        selectList.class = "form-control col-4";
    myParent.appendChild(selectList);
    for (var i = 0; i < array.length; i++) {
        var option = document.createElement("option");
        option.value = array[i];
        option.text = array[i];
        selectList.appendChild(option);
    }   
    contenedor.appendChild(selectList);

    boton = document.createElement('input');
        boton.type = 'text';
        boton.placeholder = '----';
        boton.name = 'text'+ '[]';
        boton.disabled = 'disabled';
        boton.class="form-control col-2";
        boton.style="width : 170px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='999';
        boton.name = 'text'+'[ ]';
        boton.placeholder = '000';
        boton.class="form-control col-1";
        boton.style="width : 100px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled = 'disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);

     boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled='disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);

    }
//---------------Tecnologicos------------------------------------------------------------------------------
    function crearTecnologicos(obj) {
    icremento++;

    field = document.getElementById('tec');
    contenedor = document.createElement('div');
        contenedor.id = 'div'+icremento;
    field.appendChild(contenedor);

    selectList = document.createElement('select');
    var myParent = document.body;
    var array = ["Equipo tecnologico"];
        selectList.id = "mySelect";
        selectList.style="width : 270px; heigth : 100px";
        selectList.class = "form-control col-4";
    myParent.appendChild(selectList);
    for (var i = 0; i < array.length; i++) {
        var option = document.createElement("option");
        option.value = array[i];
        option.text = array[i];
        selectList.appendChild(option);
    }   
    contenedor.appendChild(selectList);


    boton = document.createElement('input');
        boton.type = 'text';
        boton.placeholder = '----';
        boton.name = 'text'+ '[]';
        boton.disabled = 'disabled';
        boton.class="form-control col-2";
        boton.style="width : 170px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='999';
        boton.name = 'text'+'[ ]';
        boton.placeholder = '000';
        boton.class="form-control col-1";
        boton.style="width : 100px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled = 'disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled='disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);

    }
//---------------Humanos------------------------------------------------------------------------------
    function crearHumano(obj) {
    icremento++;

    field = document.getElementById('hum');
    contenedor = document.createElement('div');
        contenedor.id = 'div'+icremento;
    field.appendChild(contenedor);
    selectList = document.createElement('select');
    var myParent = document.body;
    var array = ["Investigador titular","Investigador asociado", 
    "Investigador tecnico","Investigador titular(contratado)"];
        selectList.id = "mySelect";
        selectList.style="width : 270px; heigth : 100px";
        selectList.class = "form-control col-4";
    myParent.appendChild(selectList);
    for (var i = 0; i < array.length; i++) {
        var option = document.createElement("option");
        option.value = array[i];
        option.text = array[i];
        selectList.appendChild(option);
    }   
    contenedor.appendChild(selectList);


    boton = document.createElement('input');
        boton.type = 'text';
        boton.placeholder = '----';
        boton.name = 'text'+ '[]';
        boton.disabled = 'disabled';
        boton.class="form-control col-2";
        boton.style="width : 170px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='999';
        boton.name = 'text'+'[ ]';
        boton.placeholder = '000';
        boton.class="form-control col-1";
        boton.style="width : 100px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled = 'disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled='disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);

    }
//---------------Otros------------------------------------------------------------------------------
    function crearOtro(obj) {
        icremento++;

        field = document.getElementById('otro');
        contenedor = document.createElement('div');
            contenedor.id = 'div'+icremento;
        field.appendChild(contenedor);
        selectList = document.createElement('select');
        var myParent = document.body;
        var array = ["Otro"];
            selectList.id = "mySelect";
            selectList.style="width : 270px; heigth : 100px";
            selectList.class = "form-control col-4";
        myParent.appendChild(selectList);
        for (var i = 0; i < array.length; i++) {
            var option = document.createElement("option");
            option.value = array[i];
            option.text = array[i];
            selectList.appendChild(option);
        }   
    contenedor.appendChild(selectList);


    boton = document.createElement('input');
        boton.type = 'text';
        boton.placeholder = '----';
        boton.name = 'text'+ '[]';
        boton.class="form-control col-2";
        boton.style="width : 170px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='999';
        boton.name = 'text'+'[ ]';
        boton.placeholder = '000';
        boton.class="form-control col-1";
        boton.style="width : 100px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled='disabled';
        boton.placeholder = '00000';
        boton.class="form-control col-2";
        boton.style="width : 110px; heigth : 100px";
    contenedor.appendChild(boton);
    }

    </script>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="img/IMT-LOGO.PNG" alt="50" width="30" height="24">
          </a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="paginaBienvenida">Ventana Principal</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="infoproyect">Info</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="recursosproyect">Recursos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="tareaproyect">Tarea</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </head>


    <body class="bg-primary">

    <h1 class="text-center"> Modificación de recursos </h1>
        <br>
        <div class="container jumbotron col-6 shadow-lg rounded font-weight-light">
        <form name="form1" method="POST" action="save.php">
            <div class="form-group ">
                <div>
                    <h3 class= "text-center"> Recurso Financieros </h3>
                </div>  
                <fieldset id="fina">
                    <div class="input-group">
                        <div class="col-4" id="div1">
                            <label class="form"> Concepto </label>
                        </div>
                        <div class="col-2" id="div2">
                            <label class="form"> Unidad </label>
                        </div>
                        <div class="col-2" id="div3">
                            <label class="form"> Cantidad </label>
                        </div>
                        <div class="col-1" id="div4">
                            <label  class="form"> P.U.($) </label>
                        </div>
                        <div class="col-2" id="div5">
                            <label class="form"> Total ($) </label>
                        </div>
                    </div>
                </div>
                    <input type="button" value="Crear nuevo recurso financiero" onclick="crearFinanciero(this)">
                </fieldset>
            </div>
        </form>
        <div class="container jumbotron col-6 shadow-lg rounded font-weight-light">
        <form name="form1" method="POST" action="save.php">
            <div class="form-group ">
                <div>
                    <h3 class= "text-center"> Recurso Materiales </h3>
                </div>  
                <fieldset id="mat">
                    <div class="input-group">
                        <div class="col-4" id="div1">
                            <label class="form"> Concepto </label>
                        </div>
                        <div class="col-2" id="div2">
                            <label class="form"> Unidad </label>
                        </div>
                        <div class="col-2" id="div3">
                            <label class="form"> Cantidad </label>
                        </div>
                        <div class="col-1" id="div4">
                            <label  class="form"> P.U.($) </label>
                        </div>
                        <div class="col-2" id="div5">
                            <label class="form"> Total ($) </label>
                        </div>
                    </div>
                </div>
                    <input type="button" value="Crear nuevo recurso material" onclick="crearMateriales(this)">
                </fieldset>
            </div>
        </form>
        <div class="container jumbotron col-6 shadow-lg rounded font-weight-light">
        <form name="form1" method="POST" action="save.php">       
            <div class="form-group ">
                <div>
                    <h3 class= "text-center"> Recurso Tecnologicos </h3>
                </div>  
                <fieldset id="tec">
                    <div class="input-group">
                        <div class="col-4" id="div1">
                            <label class="form"> Concepto </label>
                        </div>
                        <div class="col-2" id="div2">
                            <label class="form"> Unidad </label>
                        </div>
                        <div class="col-2" id="div3">
                            <label class="form"> Cantidad </label>
                        </div>
                        <div class="col-1" id="div4">
                            <label  class="form"> P.U.($) </label>
                        </div>
                        <div class="col-2" id="div5">
                            <label class="form"> Total ($) </label>
                        </div>
                    </div>
                </div>
                <input type="button" value="Crear nuevo recurso tecnologico" onclick="crearTecnologicos(this)">
            </fieldset>
            </div>
        </form>
        <div class="container jumbotron col-6 shadow-lg rounded font-weight-light">
        <form name="form1" method="POST" action="save.php">
            <div class="form-group ">
                <div>
                    <h3 class= "text-center"> Recurso Humano </h3>
                </div>  
                <fieldset id="hum">
                    <div class="input-group">
                        <div class="col-4" id="div1">
                            <label class="form"> Concepto </label>
                        </div>
                        <div class="col-2" id="div2">
                            <label class="form"> Unidad </label>
                        </div>
                        <div class="col-2" id="div3">
                            <label class="form"> Cantidad </label>
                        </div>
                        <div class="col-1" id="div4">
                            <label  class="form"> P.U.($) </label>
                        </div>
                        <div class="col-2" id="div5">
                            <label class="form"> Total ($) </label>
                        </div>
                    </div>
                </div>
                <input type="button" value="Crear nuevo recurso tecnologico" onclick="crearHumano(this)">
            </fieldset>
            </div>
        </form>
        <div class="container jumbotron col-6 shadow-lg rounded font-weight-light">
        <form name="form1" method="POST" action="save.php">
            <div class="form-group ">
                <div>
                    <h3 class= "text-center"> Recurso Tecnologicos </h3>
                </div>  
                <fieldset id="otro">
                    <div class="input-group">
                        <div class="col-4" id="div1">
                            <label class="form"> Concepto </label>
                        </div>
                        <div class="col-2" id="div2">
                            <label class="form"> Unidad </label>
                        </div>
                        <div class="col-2" id="div3">
                            <label class="form"> Cantidad </label>
                        </div>
                        <div class="col-1" id="div4">
                            <label  class="form"> P.U.($) </label>
                        </div>
                        <div class="col-2" id="div5">
                            <label class="form"> Total ($) </label>
                        </div>
                    </div>
                </div>
                <input type="button" value="Crear OTRO recurso" onclick="crearOtro(this)">
            </fieldset>
            </div>
        </fieldset>

       <div class="form-group text-center" >
                <button type="button" class="btn btn-danger"><i class="fas fa-sign-in-alt"></i>Cancelar</button>
                <button type="submit" class="btn btn-warning"><i class="fas fa-sign-in-alt"></i>Modificar recursos</button>
        </div>

        </form>

        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>