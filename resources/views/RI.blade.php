<html>
 <head>
    <title>Recurso Financiero INTERNO</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    
    <script type="text/javascript">


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

    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='999';
        boton.name = 'text'+'[ ]';
    contenedor.appendChild(boton);

    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled = 'disabled';
    contenedor.appendChild(boton);
 
    boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled='disabled';
    contenedor.appendChild(boton);
}

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

    contenedor.appendChild(boton);

        boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='999';
        boton.name = 'text'+'[ ]';
    contenedor.appendChild(boton);

        boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled = 'disabled';
    
    contenedor.appendChild(boton);

        boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled='disabled';
        contenedor.appendChild(boton);

}

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

    contenedor.appendChild(boton);

        boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='999';
        boton.name = 'text'+'[ ]';
    
     
    contenedor.appendChild(boton);

        boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled = 'disabled';
    
    contenedor.appendChild(boton);

        boton = document.createElement('input');
        boton.type = 'num';
        boton.min='1';
        boton.max='50000';
        boton.name = 'text'+'[ ]';
        boton.disabled='disabled';

    contenedor.appendChild(boton);

}

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

contenedor.appendChild(boton);

boton = document.createElement('input');
boton.type = 'num';
boton.min='1';
boton.max='999';
boton.name = 'text'+'[ ]';
contenedor.appendChild(boton);

boton = document.createElement('input');
boton.type = 'num';
boton.min='1';
boton.max='50000';
boton.name = 'text'+'[ ]';
boton.disabled = 'disabled';
contenedor.appendChild(boton);

boton = document.createElement('input');
boton.type = 'num';
boton.min='1';
boton.max='50000';
boton.name = 'text'+'[ ]';
boton.disabled='disabled';
contenedor.appendChild(boton);

}

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

contenedor.appendChild(boton);

boton = document.createElement('input');
boton.type = 'num';
boton.min='1';
boton.max='999';
boton.name = 'text'+'[ ]';
contenedor.appendChild(boton);

boton = document.createElement('input');
boton.type = 'num';
boton.min='1';
boton.max='50000';
boton.name = 'text'+'[ ]';
contenedor.appendChild(boton);

boton = document.createElement('input');
boton.type = 'num';
boton.min='1';
boton.max='50000';
boton.name = 'text'+'[ ]';
boton.disabled='disabled';
contenedor.appendChild(boton);

}

    </script>
 </head>
 <body>
    <h1> Propuesta economica INTERNA <h1>

    <form name="form1" method="POST" action="save.php">
        
        <h3> Recursos Financerios  </h3>         
    <fieldset id="fina">
    <input type="button" value="Crear nuevo recurso financiero" onclick="crearFinanciero(this)">
    <input name="save" type="submit" value="Guardar" onclick="enviar(this)">
    </fieldset>
    </form>

    <form name="form1" method="POST" action="save.php">
        <h3> Recursos Materiales  </h3> 
 
    <fieldset id="mat">
    <input type="button" value="Crear nuevo recurso material" onclick="crearMateriales(this)">
    <input name="save" type="submit" value="Guardar" onclick="enviar(this)">
    </fieldset>
    </form>

    <form name="form1" method="POST" action="save.php">
        <h3> Recursos Tecnologicos  </h3> 
 
    <fieldset id="tec">
    <input type="button" value="Crear nuevo recurso tecnologico" onclick="crearTecnologicos(this)">
    <input name="save" type="submit" value="Guardar" onclick="enviar(this)">
    </fieldset>
    </form>

    <form name="form1" method="POST" action="save.php">
        <h3> Recursos Humanos  </h3> 
 
    <fieldset id="hum">
    <input type="button" value="Crear nuevo recurso humano" onclick="crearHumano(this)">
    <input name="save" type="submit" value="Guardar" onclick="enviar(this)">
    </fieldset>
    </form>

    <form name="form1" method="POST" action="save.php">
        <h4> Otros  </h4> 
 
    <fieldset id="otro">
    <input type="button" value="Crear OTRO recurso" onclick="crearOtro(this)">
    <input name="save" type="submit" value="Guardar" onclick="enviar(this)">
    </fieldset>
    </form>

 </body>
</html>