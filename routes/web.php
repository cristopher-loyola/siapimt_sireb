<?php
use App\Http\Controllers\ApiController;

use App\Http\Controllers\dbcontroller;
use App\Http\Controllers\reporteBimestral;
use App\Http\Controllers\SearchClientController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::get('phpinfo', function () {
    phpinfo();
});
/* Login y Aceccesos Inicio*/
    Route::get('/', function () {
        return view('login');
    })->middleware('preventBackHistory');
    Route::get('newuser', [dbcontroller::class, 'newuser'])
    ->middleware('isLogged','preventBackHistory')->name('newuser');
    Route::post('adduser',[dbcontroller::class, 'adduser'])
    ->middleware('isLogged','preventBackHistory')->name('adduser');
    Route::post('loginuser',[dbcontroller::class, 'loginuser'])
    ->name('loginuser');
    Route::get('dashboard', [dbcontroller::class, 'dashboard'])
    ->middleware('isLogged','preventBackHistory')->name('dashboard');
    Route::get('dashboardresp', [dbcontroller::class, 'dashboardresp'])
    ->middleware('isLogged','preventBackHistory')->name('dashboardresp');
    Route::get('dashboardasoc', [dbcontroller::class, 'dashboardasoc'])
    ->middleware('isLogged','preventBackHistory')->name('dashboardasoc');
    Route::get('dashboardauser', [dbcontroller::class, 'dashboardauser'])
    ->middleware('isLogged','preventBackHistory')->name('dashboardauser');
    Route::get('dashboardaadminf', [dbcontroller::class, 'dashboardaadminf'])
    ->middleware('isLogged','preventBackHistory')->name('dashboardaadminf');
    Route::get('dashboardafina', [dbcontroller::class, 'dashboardafina'])
    ->middleware('isLogged','preventBackHistory')->name('dashboardafina');
    Route::get('logout', [dbcontroller::class, 'logout'])->middleware('preventBackHistory');
    Route::get('cancelcrud', [dbcontroller::class, 'cancelcrud'])
    ->middleware('isLogged','preventBackHistory')->name('cancelcrud');
    Route::get('cancelcrud2', [dbcontroller::class, 'cancelcrud2'])
    ->middleware('isLogged','preventBackHistory')->name('cancelcrud2');
    Route::get('cancelcrudafect', [dbcontroller::class, 'cancelcrudafect'])
    ->middleware('isLogged','preventBackHistory')->name('cancelcrudafect');
    // RUTAS PARA QUILL - GUARDAR Y BORRAR IMAGENES 
        Route::post('/quill/imagenesQuill', [dbcontroller::class, 'imagenesQuill'])->name('imagenesQuill');
        Route::post('/quill/imagenesQuillBase64', [dbcontroller::class, 'imagenesQuillBase64'])->name('imagenesQuillBase64');
    // TERMINAN RUTAS
/* Login y Aceccesos Fin*/
Route::group(['middleware'=>'isLogged','preventBackHistory'], function()
{
    Route::get('pruebas',[dbcontroller::class, 'pruebas'])->name('pruebas');
/* Proyectos CRUD Inicio*/
    
    Route::get('resumenMensual/{id}', [dbcontroller::class, 'resumenMensual'])->name('resumenMensual'); 
    Route::get('infotec/{id}',[dbcontroller::class, 'infotec'])->name('infotec'); //Nuevo
    Route::get('ppindex',[dbcontroller::class, 'ppindex'])->name('ppindex');
    Route::get('newp',[dbcontroller::class, 'newp'])->name('newp');
    Route::post('addnewp',[dbcontroller::class, 'addnewp'])->name('addnewp');

    Route::get('claveproy',[dbcontroller::class, 'claveproy'])->name('claveproy'); //generar clave de nuevo proyecto
    Route::post('addclave',[dbcontroller::class, 'addclave'])->name('addclave');

    // Route::get('upgradecliente/{id}',[dbcontroller::class,'upgradecliente'])->name('upgradecliente');//
    // Route::post('upgradeclient/{id}',[dbcontroller::class,'upgradeclient'])->name('upgradeclient');

    Route::get('cambiarcliente/{id}',[dbcontroller::class, 'cambiarcliente'])->name('cambiarcliente');
    Route::post('changeclien/{id}',[dbcontroller::class, 'changeclien'])->name('changeclien');

    //RUTAS PARA APARTADO DE IMPACTO SOCIOECONOMICO
        Route::get('impactoproy/{id}',[dbcontroller::class,'impactoproy'])->name('impactoproy');
        Route::get('impactoproy1/{id}',[dbcontroller::class,'impactoproy1'])->name('impactoproy1');
        Route::get('impactoproy2/{id}',[dbcontroller::class,'impactoproy2'])->name('impactoproy2');

        Route::post('upimpactoproy/{id}',[dbcontroller::class,'upimpactoproy'])->name('upimpactoproy');
        Route::post('upimpactoproy1/{id}',[dbcontroller::class,'upimpactoproy1'])->name('upimpactoproy1');
        Route::post('upimpactoproy2/{id}',[dbcontroller::class,'upimpactoproy2'])->name('upimpactoproy2');

        //RUTAS PARA EXPORTAR PDF EN IMPACTO SOCIOECONOMICO
        Route::get('/impactoproyecto/pdf/{id}', [App\Http\Controllers\dbcontroller::class, 'exportImpactoPdf'])
     ->name('impacto.pdf');
    // TERMINAN RUTAS

    Route::get('proydatos/{id}',[dbcontroller::class, 'proydatos'])->name('proydatos');
    Route::get('proydatos1/{id}',[dbcontroller::class, 'proydatos1'])->name('proydatos1');
    Route::get('proydatos2/{id}',[dbcontroller::class, 'proydatos2'])->name('proydatos2');
    Route::get('proydatos3/{id}',[dbcontroller::class, 'proydatos3'])->name('proydatos3');
    Route::get('proydatos4/{id}',[dbcontroller::class, 'proydatos4'])->name('proydatos4');

    Route::get('generalimpacto/{id}',[dbcontroller::class, 'generalimpacto'])->name('generalimpacto'); //Nuevo General Impacto

    Route::post('actulizarproyecto/{id}',[dbcontroller::class, 'actulizarproyecto'])->name('actulizarproyecto');
    Route::post('actulizarproyecto1/{id}',[dbcontroller::class, 'actulizarproyecto1'])->name('actulizarproyecto1');
    Route::post('actulizarproyecto2/{id}',[dbcontroller::class, 'actulizarproyecto2'])->name('actulizarproyecto2');
    Route::post('actulizarproyecto3/{id}',[dbcontroller::class, 'actulizarproyecto3'])->name('actulizarproyecto3');
    Route::post('actulizarproyecto4/{id}',[dbcontroller::class, 'actulizarproyecto4'])->name('actulizarproyecto4');

    Route::post('notificarreporte/{id}',[dbcontroller::class, 'notificarreporte'])->name('notificarreporte');
    Route::post('notificarprotocoloaceptado/{id}',[dbcontroller::class, 'notificarprotocoloaceptado'])->name('notificarprotocoloaceptado');
    Route::post('notificarprotocolorevision/{id}/{ida}',[dbcontroller::class, 'notificarprotocolorevision'])->name('notificarprotocolorevision');
    Route::post('previsadoaprobado/{id}/{ida}',[dbcontroller::class, 'previsadoaprobado'])->name('previsadoaprobado');

    Route::get('gprotocolo/{id}', [dbcontroller::class, 'gprotocolo'])->name('gprotocolo');
    Route::get('gprotocolo2/{id}', [dbcontroller::class, 'gprotocolo2'])->name('gprotocolo2');

    Route::get('adpindex',[dbcontroller::class, 'adpindex'])->name('adpindex');
    Route::get('changestatuspro',[dbcontroller::class, 'changestatuspro'])->name('changestatuspro');
    /* la ruta para actualizar mediante la funcion de ajax con json se define de la sig. manera
    el proceso se repite para otros usos en el sistema*/
    Route::get('changeStatusoculto',[dbcontroller::class, 'changeStatusoculto'])->name('changeStatusoculto');
    Route::get('infoproys/{id}',[dbcontroller::class,'infoproys'])->name('infoproys');
    Route::post('infoproy/{id}',[dbcontroller::class,'infoproy'])->name('infoproy');
    Route::get('upproys/{id}',[dbcontroller::class,'upproys'])->name('upproys');
    Route::post('upproy/{id}',[dbcontroller::class,'upproy'])->name('upproy');
    Route::get('tareag/{id}',[dbcontroller::class,'tareag'])->name('tareag');
    Route::get('tareas/{id}',[dbcontroller::class,'tareas'])->name('tareas');
    Route::post('tarea/{id}',[dbcontroller::class,'tarea'])->name('tarea');

    Route::get('riesgos',[dbcontroller::class,'riesgos'])->name('riesgos');
    Route::get('changestatusrisk',[dbcontroller::class, 'changestatusrisk'])->name('changestatusrisk');
    Route::get('addlriesgo',['as'=>'addlriesgo',function () {
        return view('addlriesgo');
    }]);
    Route::post('addlriesgos',[dbcontroller::class, 'addlriesgos'])->name('addlriesgos');
    Route::get('uplrisk/{id}',[dbcontroller::class, 'uplrisk'])->name('uplrisk');
    Route::post('uplrisks/{id}',[dbcontroller::class, 'uplrisks'])->name('uplrisks');

    Route::get('ariesgo/{id}',[dbcontroller::class,'ariesgo'])->name('ariesgo');
    Route::get('addriesgo/{id}/{idt}',[dbcontroller::class,'addriesgo'])->name('addriesgo');
    Route::post('addriesgosave/{id}',[dbcontroller::class,'addriesgosave'])->name('addriesgosave');
    Route::get('upriesgo/{id}',[dbcontroller::class,'upriesgo'])->name('upriesgo');
    Route::post('upriesgosave/{id}',[dbcontroller::class,'upriesgosave'])->name('upriesgosave');
    Route::delete('destroyriesgo/{id}/{ida}', [dbcontroller::class, 'destroyriesgo'])-> name('destroyriesgo');

    Route::get('firnaralldg',[dbcontroller::class,'firnaralldg'])->name('firnaralldg');
    Route::post('firmartodosdg', [dbcontroller::class, 'firmartodosdg'])->name('firmartodosdg');
    Route::post('firmardgprotocolo/{id}/{ida}', [dbcontroller::class, 'firmardgprotocolo'])->name('firmardgprotocolo');

    Route::get('firmarcospiii',[dbcontroller::class,'firmarcospiii'])->name('firmarcospiii');
    Route::post('aprobarcospiii', [dbcontroller::class, 'aprobarcospiii'])->name('aprobarcospiii');

    Route::delete('destroytarea/{id}/{ida}', [dbcontroller::class, 'destroytarea'])-> name('destroytarea');
    Route::get('uptareas/{id}/{idt}',[dbcontroller::class,'uptareas'])->name('uptareas');
    Route::post('uptarea/{id}/{idt}',[dbcontroller::class,'uptarea'])->name('uptarea');
    Route::get('avance/{id}/{idt}',[dbcontroller::class,'avance'])->name('avance');
    Route::post('upavance/{id}/{idt}',[dbcontroller::class,'upavance'])->name('upavance');

    //Funcion de cambio de estados inicio
        Route::get('iniciarproy/{id}',[dbcontroller::class,'iniciarproy'])->name('iniciarproy');
    //Funcion de cambio de estados fin

    Route::get('Equipo/{id}',[dbcontroller::class,'Equipo'])->name('Equipo');
    Route::get('sinColab',[dbcontroller::class, 'sinColab'])->name('sinColab');
    Route::get('addequipos/{id}',[dbcontroller::class,'addequipos'])->name('addequipos');
    Route::post('addequipo/{id}',[dbcontroller::class,'addequipo'])->name('addequipo');
    Route::delete('destroyequipo/{id}/{ida}', [dbcontroller::class, 'destroyequipo'])-> name('destroyequipo');
    //NUEVO
        Route::get('Materia/{id}',[dbcontroller::class,'Materia'])->name('Materia');
        Route::get('addmaterias/{id}',[dbcontroller::class,'addmaterias'])->name('addmaterias');
        Route::post('addmateria/{id}',[dbcontroller::class,'addmateria'])->name('addmateria');
        Route::delete('destroymateria/{id}/{ida}', [dbcontroller::class, 'destroymateria'])-> name('destroymateria');

        Route::get('observaciones/{id}',[dbcontroller::class,'observaciones'])->name('observaciones');
        Route::get('vistainfoobs/{id}/{ida}', [dbcontroller::class, 'vistainfoobs'])-> name('vistainfoobs');
        Route::get('revisionobs/{id}/{ida}', [dbcontroller::class, 'revisionobs'])-> name('revisionobs');
        Route::post('aceptarreprogram/{id}/{ida}', [dbcontroller::class, 'aceptarreprogram'])-> name('aceptarreprogram');
        Route::post('aceptarcancel/{id}/{ida}', [dbcontroller::class, 'aceptarcancel'])-> name('aceptarcancel');
        Route::post('rechazoreprogram/{id}/{ida}', [dbcontroller::class, 'rechazoreprogram'])-> name('rechazoreprogram');
        Route::post('rechazocancel/{id}/{ida}', [dbcontroller::class, 'rechazocancel'])-> name('rechazocancel');
        Route::get('reporteaceptado/{id}/{ida}', [dbcontroller::class, 'reporteaceptado'])-> name('reporteaceptado');

        Route::post('rechazarprotocolopte/{id}/{ida}', [dbcontroller::class, 'rechazarprotocolopte'])-> name('rechazarprotocolopte');

        Route::post('aceptarprotocolo/{id}/{ida}', [dbcontroller::class, 'aceptarprotocolo'])-> name('aceptarprotocolo');
        Route::get('firmaresponsable/{id}/{ida}', [dbcontroller::class, 'firmaresponsable'])-> name('firmaresponsable');
        Route::post('firmarprotocolo/{id}/{ida}', [dbcontroller::class, 'firmarprotocolo'])-> name('firmarprotocolo');


    // Nuevo
    Route::get('recursosproy/{id}',[dbcontroller::class,'recursosproy'])->name('recursosproy');
    Route::get('addrecursosproyf/{id}',[dbcontroller::class,'addrecursosproyf'])->name('addrecursosproyf');
    Route::get('addrecursosproym/{id}',[dbcontroller::class,'addrecursosproym'])->name('addrecursosproym');
    Route::get('addrecursosproyt/{id}',[dbcontroller::class,'addrecursosproyt'])->name('addrecursosproyt');
    Route::get('addrecursosproyh/{id}',[dbcontroller::class,'addrecursosproyh'])->name('addrecursosproyh');
    Route::get('addrecursosproyo/{id}',[dbcontroller::class,'addrecursosproyo'])->name('addrecursosproyo');
    Route::post('addrecursoproy/{id}',[dbcontroller::class,'addrecursoproy'])->name('addrecursoproy');
    Route::delete('destroyrecurso/{id}/{ida}', [dbcontroller::class, 'destroyrecurso'])-> name('destroyrecurso');
    Route::post('addnotapresupuesto',[dbcontroller::class,'addnotapresupuesto'])->name('addnotapresupuesto');

    Route::get('solicitud/{id}',[dbcontroller::class,'solicitud'])->name('solicitud');
    Route::get('soldcan/{id}',[dbcontroller::class,'soldcan'])->name('soldcan');
    Route::post('sendsolicitud/{id}',[dbcontroller::class,'sendsolicitud'])->name('sendsolicitud');
    Route::post('sendsolicitudcancel/{id}',[dbcontroller::class,'sendsolicitudcancel'])->name('sendsolicitudcancel');
    Route::post('aprosolicitud/{id}',[dbcontroller::class,'aprosolicitud'])->name('aprosolicitud');

    Route::get('change-status-proy/{id}', [dbcontroller::class, 'changestatusproy']);
/* Proyectos CRUD Fin*/
/* Usuarios CRUD Inicio*/
    Route::get('userAdmin',[dbcontroller::class, 'userAdmin'])->name('userAdmin');
    Route::get('upusers/{id}',[dbcontroller::class, 'upusers'])->name('upusers');
    Route::post('upuser/{id}',[dbcontroller::class, 'upuser'])->name('upuser');
    Route::get('changestatuuser',[dbcontroller::class, 'changestatuuser'])->name('changestatuuser');
/* Usuarios CRUD Fin*/
/* Ocurrencias CRUD Inicio*/
    Route::get('ocurrencia',[dbcontroller::class, 'ocurrencia'])->name('ocurrencia');
    // Route::get('addocurrencia',[dbcontroller::class, 'addocurrencia'])->name('addocurrencia');
    Route::get('addocurrencia',['as'=>'addocurrencia',function () {
        return view('addocurrencia');
    }]);
    Route::post('addcurrent',[dbcontroller::class, 'addcurrent'])->name('addcurrent');
    Route::get('upocurrencia/{id}',[dbcontroller::class, 'upocurrencia'])->name('upocurrencia');
    Route::post('upcurrent/{id}',[dbcontroller::class, 'upcurrent'])->name('upcurrent');
    Route::get('changestatuocurrencia',[dbcontroller::class, 'changestatuocurrencia'])->name('changestatuocurrencia');
/* Ocurrencias CRUD Fin*/
/* Recursos Inicio */
    Route::get('Recursos',[dbcontroller::class, 'Recursos'])->name('Recursos');
    Route::get('addrecus',[dbcontroller::class, 'addrecus'])->name('addrecus');
    Route::post('addrecu',[dbcontroller::class, 'addrecu'])->name('addrecu');
    Route::get('changestatusrecu',[dbcontroller::class, 'changestatusrecu'])->name('changestatusrecu');
    Route::get('changestaturesp',[dbcontroller::class, 'changestaturesp'])->name('changestaturesp');
    Route::get('changestatussesionespecial',[dbcontroller::class, 'changestatussesionespecial'])->name('changestatussesionespecial');
    Route::get('uprecu/{id}',[dbcontroller::class, 'uprecu'])->name('uprecu');
    Route::post('uprecus/{id}',[dbcontroller::class, 'uprecus'])->name('uprecus');
/* Recursos Fin */
/* Puesto Inicio */
    Route::get('puesto',[dbcontroller::class, 'puesto'])->name('puesto');
    Route::get('addpuestos',[dbcontroller::class, 'addpuestos'])->name('addpuestos');
    Route::post('addpuesto',[dbcontroller::class, 'addpuesto'])->name('addpuesto');
    Route::get('changestatupuest',[dbcontroller::class, 'changestatupuest'])->name('changestatupuest');
    Route::get('uppuestos/{id}',[dbcontroller::class, 'uppuestos'])->name('uppuestos');
    Route::post('uppuesto/{id}',[dbcontroller::class, 'uppuesto'])->name('uppuesto');
/* Puesto Fin */
/* Contribuciones Inicio*/
    Route::get('contribuciones/{id}', [dbcontroller::class, 'contribuciones'])->name('contribuciones');
    Route::get('addcontribuciones/{id}',[dbcontroller::class,'addcontribuciones'])->name('addcontribuciones');
    Route::post('addcontribucione/{id}',[dbcontroller::class,'addcontribucione'])->name('addcontribucione');
    Route::delete('destroycontribucion/{id}/{ida}', [dbcontroller::class, 'destroycontribucion'])
    ->name('destroycontribucion');
/* Contribuciones Fin*/
/* Contribucion CRUD Inicio*/
    Route::get('contri',[dbcontroller::class, 'indexcontri'])->name('indexcontri');
    Route::get('changestatuscontri',[dbcontroller::class, 'changestatuscontri'])->name('changestatuscontri');
    Route::get('addcontri',['as'=>'addcontri',function () {
        return view('addcontri');
    }]);
    Route::post('addcontribu',[dbcontroller::class, 'addcontribu'])->name('addcontribu');
    Route::get('upcontri/{id}',[dbcontroller::class, 'upcontri'])->name('upcontri');
    Route::post('upcontris/{id}',[dbcontroller::class, 'upcontris'])->name('upcontris');
/* Contribucion CRUD Fin*/
/* Area de adscripcion CRUD Inicio*/
    Route::get('moda',[dbcontroller::class, 'indexarea'])->name('indexarea');
    Route::get('changestatus',[dbcontroller::class, 'changestatus'])->name('changestatus');
    Route::get('addarea',['as'=>'addarea',function () {
        return view('addarea');
    }]);
    Route::post('addar',[dbcontroller::class, 'addar'])->name('addar');
    Route::get('uparea/{id}',[dbcontroller::class, 'uparea'])->name('uparea');
    Route::post('upareas/{id}',[dbcontroller::class, 'upareas'])->name('upareas');
/* Area de adscripcion CRUD Fin*/
/* Objetivo CRUD Inicio*/
    Route::get('modo',[dbcontroller::class, 'indexObjetivo'])->name('indexObjetivo');
    Route::get('changestatusobj',[dbcontroller::class, 'changestatusobj'])->name('changestatusobj');
    Route::get('addobj',['as'=>'addobj',function () {
        return view('addobj');
    }]);
    Route::post('addobjs',[dbcontroller::class, 'addobjs'])->name('addobjs');
    Route::get('upobj/{id}',[dbcontroller::class, 'upobj'])->name('upobj');
    Route::post('upobjs/{id}',[dbcontroller::class, 'upobjs'])->name('upobjs');
/* Objetivo CRUD Fin*/
/* Linea de investigacion CRUD Inicio*/
    Route::get('modinv',[dbcontroller::class, 'indexinvestigacion'])->name('indexinvestigacion');
    Route::get('changestatusinv',[dbcontroller::class, 'changestatusinv'])->name('changestatusinv');
    Route::get('addinv',['as'=>'addinv',function () {
        return view('addinv');
    }]);
    Route::post('addlininv',[dbcontroller::class, 'addlininv'])->name('addlininv');
    Route::get('upinv/{id}',[dbcontroller::class, 'upinv'])->name('upinv');
    Route::post('upinvs/{id}',[dbcontroller::class, 'upinvs'])->name('upinvs');
/* Linea de investigacion CRUD Fin*/
/* Modo de transporte CRUD Inicio*/
    Route::get('modt',[dbcontroller::class, 'indextransporte'])->name('indextransporte');
    Route::get('changestatustran',[dbcontroller::class, 'changestatustran'])->name('changestatustran');
    Route::get('addtrans',['as'=>'addtrans',function () {
        return view('addtrans');
    }]);
    Route::post('addtranspo',[dbcontroller::class, 'addtranspo'])->name('addtranspo');
    Route::get('uptran/{id}',[dbcontroller::class, 'uptran'])->name('uptran');
    Route::post('uptrans/{id}',[dbcontroller::class, 'uptrans'])->name('uptrans');
/* Modo de transporte CRUD Fin*/
/* Alineacion Sectorial CRUD Inicio*/
    Route::get('modlin',[dbcontroller::class, 'indexalineacion'])->name('indexalineacion');
    Route::get('changestatuslin',[dbcontroller::class, 'changestatuslin'])->name('changestatuslin');
    Route::get('addalin',['as'=>'addalin',function () {
        return view('addalin');
    }]);
    Route::post('addalinea',[dbcontroller::class, 'addalinea'])->name('addalinea');
    Route::get('upalin/{id}',[dbcontroller::class, 'upalin'])->name('upalin');
    Route::post('upalins/{id}',[dbcontroller::class, 'upalins'])->name('upalins');
/* Alineacion Sectorial CRUD Fin*/
/* Cliente o Usuario CRUD Inicio */
    Route::get('indexcliente',[dbcontroller::class, 'indexcliente'])->name('indexcliente');
    Route::get('changestatucl',[dbcontroller::class, 'changestatucl'])->name('changestatucl');
    Route::get('newcli', [dbcontroller::class, 'newcli'])->name('newcli');
    Route::post('addcli',[dbcontroller::class, 'addcli'])->name('addcli');
    Route::get('upcli/{id}', [dbcontroller::class, 'upcli'])->name('upcli');
    Route::post('upclis/{id}',[dbcontroller::class, 'upclis'])->name('upclis');
/* Cliente o Usuario CRUD Fin */
/* Financiero CRUD Inicio*/
    Route::get('Financiero',[dbcontroller::class, 'Financiero'])->name('Financiero');
    Route::get('partidas',[dbcontroller::class, 'indexpartida'])->name('indexpartida');
    Route::get('addpartida',['as'=>'addpartida',function () {
        return view('addpartida');
    }]);
    Route::get('changestatupart',[dbcontroller::class, 'changestatupart'])->name('changestatupart');
    Route::post('addpartidas',[dbcontroller::class, 'addpartidas'])->name('addpartidas');
    Route::get('uppartida/{id}',[dbcontroller::class, 'uppartida'])->name('uppartida');
    Route::post('uppartidas/{id}',[dbcontroller::class, 'uppartidas'])->name('uppartidas');

    Route::get('afectaciones/{id}',[dbcontroller::class,'afectaciones'])->name('afectaciones');
    Route::get('afectaciones_/{id}',[dbcontroller::class,'afectaciones_'])->name('afectaciones_');
    //Nueva afectacion
    Route::get('add_Afectacion',[dbcontroller::class, 'add_Afectacion'])->name('add_Afectacion');
    Route::post('addAfectacion/{id}',[dbcontroller::class,'addAfectacion'])->name('addAfectacion');
    //Informacion
    Route::get('infoafectacion/{id}/{ida}',[dbcontroller::class, 'infoafectacion'])->name('infoafectacion');
     //Eliminar afectacion
    Route::delete('destroyAfectacion/{id}/{ida}', [dbcontroller::class, 'destroyAfectacion'])
    ->name('destroyAfectacion');
    //Modificar afectacion
    Route::get('upafectaciones/{id}/{ida}',[dbcontroller::class,'upafectaciones'])->name('upafectaciones');
    Route::post('upafectacion/{id}/{ida}',[dbcontroller::class,'upafectacion'])->name('upafectacion');

    //Imprimir Excel
    //Imprimir Excel - FINANCIERO
    Route::get('afectaciones_/{id}/{totalproyt}', [dbcontroller::class,'exportExcel'])->name('afectacion.excel');

    //Imprimir Excel - PROYECTOS
    Route::get('dashboard_', [dbcontroller::class,'exportExcelPr'])->name('proyectos.excel');
/* Financiero CRUD Fin */
/*Exceles Alternativa Inicio*/
    Route::get('vistareportes', [dbcontroller::class,'vistareportes'])->name('vistareportes');
    Route::get('vistareportesglobal', [dbcontroller::class,'vistareportesglobal'])->name('vistareportesglobal');
    Route::post('excelporfecha', [\App\Http\Controllers\reportes\DateReportController::class,'getReport'])->name('report.date');
    Route::post('excelporresponsable', [\App\Http\Controllers\reportes\AreaReportController::class,'getReport'])->name('report.area');
    Route::post('f6gs001', [dbcontroller::class,'f6gs001'])->name('f6gs001');
    Route::get('exceltodos', [\App\Http\Controllers\reportes\GeneralReportController::class,'getReport'])->name('general.report');
    Route::get('exceltodosglobal', [dbcontroller::class,'exceltodosglobal'])->name('exceltodosglobal');
    Route::get('exceltodosuser', [dbcontroller::class,'exceltodosuser'])->name('exceltodosuser');
    Route::get('excelinfoproyecto/{id}', [dbcontroller::class,'excelinfoproyecto'])->name('excelinfoproyecto');
    Route::get('excelinfoactividades/{id}', [dbcontroller::class,'excelinfoactividades'])->name('excelinfoactividades');
    Route::post('excelriesgos/', [dbcontroller::class,'excelriesgos'])->name('excelriesgos');
/*Exceles Alternativa Fin  */
/*Excel Financiero Incicio */
    Route::get('exportExcel1/{id}', [dbcontroller::class,'exportExcel1'])->name('exportExcel1');
    Route::get('porcontrato',[dbcontroller::class, 'porcontrato'])->name('porcontrato');
    Route::post('exportExcel2', [dbcontroller::class,'exportExcel2'])->name('exportExcel2');
/*Excel Financiero Fin */



//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Rutas del proyecto sistema informatico de reportes bimestrales */

Route::get('difusionD',[reporteBimestral::class, 'difusionD'])->name('difusionD');
Route::get('alerta',[reporteBimestral::class, 'alerta'])->name('alerta');

////////////////////////////////////////Rutas del modulo de comitesAdmin//////////////////////////////////////
Route::get('comitesAdmin',[reporteBimestral::class, 'comitesAdmin'])->name('comitesAdmin');
Route::post('nuevocomiteAdmin',[reporteBimestral::class, 'nuevocomiteAdmin'])->name('nuevocomiteAdmin');
Route::get('editar/comitesAdmin/{id}',[reporteBimestral::class, 'comitesAdminEditar'])->name('comitesAdminEditar');
Route::get('eliminar/comitesAdmin/{id}',[reporteBimestral::class, 'comitesAdminEliminar'])->name('comitesAdminEliminar');
//////////////////////////////Fin de las rutas del modulo de comitesAdmin/////////////////////////////////////

////////////////////////////////////////Rutas del modulo de serviciosAdmin//////////////////////////////////////
Route::post('nuevoserviciosAdmin',[reporteBimestral::class, 'nuevoserviciosAdmin'])->name('nuevoserviciosAdmin');
Route::get('editar/serviciosAdmin/{id}',[reporteBimestral::class, 'serviciosAdminEditar'])->name('serviciosAdminEditar');
Route::get('eliminar/serviciosAdmin/{id}',[reporteBimestral::class, 'serviciosAdminEliminar'])->name('serviciosAdminEliminar');
////////////////////////////////////////Fin de las rutas del modulo de serviciosAdmin//////////////////////////////////////

///////////////////////////////////////Rutas del modulo de inicioUsuario//////////////////////////////////////
Route::get('iniciousuario',[reporteBimestral::class, 'inicioUsuario'])->name('iniciousuario');
Route::post('nuevafecha',[reporteBimestral::class, 'nuevafecha'])->name('nuevafecha');
Route::put('editarfecha/{id}',[reporteBimestral::class, 'editarfecha'])->name('editarfecha');
Route::put('editarfecha2/{id}',[reporteBimestral::class, 'editarfecha2'])->name('editarfecha2');
////////////////////////////////Fin de las rutas del modulo de inicioUsuario//////////////////////////////////

///////////////////////////////////////Rutas del modulo de sercicios Tecnologicos/////////////////////////////
Route::get('serciciosTecnologicos',[reporteBimestral::class, 'serciciosTecnologicos'])->name('serciciosTecnologicos');
Route::post('nuevoserviciot',[reporteBimestral::class, 'nuevoserviciot'])->name('nuevoserviciot');
Route::get('editar/serviciot/{id}',[reporteBimestral::class, 'serviciotEditar'])->name('serviciotEditar');
Route::get('editar/serviciotDescripcion/{id}',[reporteBimestral::class, 'serviciotEditarDescripcion'])->name('serviciotEditarDescripcion');
Route::get('editar/serviciotDescripcion2/{id}',[reporteBimestral::class, 'serviciotEditarDescripcionRelacion'])->name('serviciotEditarDescripcionRelacion');
Route::get('eliminar/serviciot/{id}',[reporteBimestral::class, 'serviciotEliminar'])->name('serviciotEliminar');
Route::get('eliminar/serviciotR/{id}',[reporteBimestral::class, 'serviciotEliminarRelacion'])->name('serviciotEliminarRelacion');
////////////////////////////////Fin de las rutas del modulo de sercicios Tecnologicos/////////////////////////

///////////////////////////////////////////Rutas del modulo de reuniones//////////////////////////////////////
Route::get('reuniones',[reporteBimestral::class, 'reuniones'])->name('reuniones');
Route::post('nuevareunion',[reporteBimestral::class, 'nuevareunion'])->name('nuevareunion');
Route::get('editar/reuniones/{id}',[reporteBimestral::class, 'reunionesEditar'])->name('reunionesEditar');
Route::get('eliminar/reuniones/{id}',[reporteBimestral::class, 'reunionesEliminar'])->name('eliminarreunion');
Route::get('eliminar/reunionesR/{id}',[reporteBimestral::class, 'reunionesEliminarRelacion'])->name('eliminarreunionR');
/////////////////////////////////Fin de las rutas del modulo de reuniones/////////////////////////////////////

///////////////////////////////////////////Rutas del modulo de comites////////////////////////////////////////
Route::get('comites',[reporteBimestral::class, 'comites'])->name('comites');
Route::post('nuevocomite',[reporteBimestral::class, 'nuevocomite'])->name('nuevocomite');
Route::get('editar/comites/{id}',[reporteBimestral::class, 'comitesEditar'])->name('comitesEditar');
Route::get('eliminar/comites/{id}',[reporteBimestral::class, 'eliminarcomites'])->name('eliminarcomites');
Route::get('eliminar/comitesR/{id}',[reporteBimestral::class, 'comitesEliminarRelacion'])->name('eliminarcomitesR');
/////////////////////////////////Fin de las rutas del modulo de comites///////////////////////////////////////

///////////////////////////////////////////Rutas del modulo de solicitudes////////////////////////////////////
Route::get('solicitudes',[reporteBimestral::class, 'solicitudes'])->name('solicitudes');
Route::post('nuevasolicitud',[reporteBimestral::class, 'nuevasolicitud'])->name('nuevasolicitud');
Route::get('editar/solicitudes/{id}',[reporteBimestral::class, 'solicitudesEditar'])->name('editarsolicitud');
Route::get('eliminar/solicitudes/{id}',[reporteBimestral::class, 'solicitudesEliminar'])->name('eliminarsolicitud');
Route::get('eliminar/solicitudesR/{id}',[reporteBimestral::class, 'solicitudesEliminarRelacion'])->name('eliminarsolicitudR');
/////////////////////////////////Fin de las rutas del modulo de solicitudes///////////////////////////////////

///////////////////////////////////Rutas del modulo de Difucion y docencia////////////////////////////////////
///Revistas///
Route::get('revistas',[reporteBimestral::class, 'revistas'])->name('revistas');
Route::post('nuevarevista',[reporteBimestral::class, 'nuevarevista'])->name('nuevarevista');
Route::get('editar/revistas/{id}',[reporteBimestral::class, 'revistaEditar'])->name('revistaEditar');
Route::get('eliminar/revistas/{id}',[reporteBimestral::class, 'revistaEliminar'])->name('revistaEliminar');
Route::get('eliminar/revistasR/{id}',[reporteBimestral::class, 'revistaEliminarR'])->name('revistaEliminarR');
///Memorias///
Route::get('memorias',[reporteBimestral::class, 'memorias'])->name('memorias');
Route::post('nuevamemorias',[reporteBimestral::class, 'nuevamemorias'])->name('nuevamemorias');
Route::get('editar/memorias/{id}',[reporteBimestral::class, 'memoriasEditar'])->name('memoriasEditar');
Route::get('eliminar/memorias/{id}',[reporteBimestral::class, 'memoriasEliminar'])->name('memoriasEliminar');
Route::get('eliminar/memoriasR/{id}',[reporteBimestral::class, 'memoriasEliminarR'])->name('memoriasEliminarR');
///Boletines///
Route::get('boletines',[reporteBimestral::class, 'boletines'])->name('boletines');
Route::post('nuevoboletin',[reporteBimestral::class, 'nuevoboletin'])->name('nuevoboletin');
///Documentos Tecnicos///
Route::get('documentosT',[reporteBimestral::class, 'documentosT'])->name('documentosT');
Route::post('nuevodocumento',[reporteBimestral::class, 'nuevodocumento'])->name('nuevodocumento');
///ponencias y conferencias///
Route::get('ponenciasconferencias',[reporteBimestral::class, 'ponenciasconferencias'])->name('ponenciasconferencias');
Route::post('nuevaponenciasconferencias',[reporteBimestral::class, 'nuevaponenciasconferencias'])->name('nuevaponenciasconferencias');
Route::get('editar/ponencias/y/conferencias/{id}',[reporteBimestral::class, 'ponenciasconferenciasEditar'])->name('ponenciasconferenciasEditar');
Route::get('eliminar/ponencias/y/conferencias/{id}',[reporteBimestral::class, 'ponenciasconferenciasEliminar'])->name('ponenciasconferenciasEliminar');
Route::get('eliminar/ponencias/y/conferenciasR/{id}',[reporteBimestral::class, 'ponenciasconferenciaEliminarRelacion'])->name('ponenciasconferenciaEliminarRelacion');
///Docencia///
Route::get('docencia',[reporteBimestral::class, 'docencia'])->name('docencia');
Route::post('nuevadocencia',[reporteBimestral::class, 'nuevadocencia'])->name('nuevadocencia');
Route::get('editar/docencia/{id}',[reporteBimestral::class, 'docenciaEditar'])->name('docenciaEditar');
Route::get('eliminar/docencia/{id}',[reporteBimestral::class, 'docenciaEliminar'])->name('docenciaEliminar');
///libros///
Route::get('libros',[reporteBimestral::class, 'libros'])->name('libros');
Route::post('nuevolibro',[reporteBimestral::class, 'nuevolibro'])->name('nuevolibro');
Route::get('editar/libros/{id}',[reporteBimestral::class, 'librosEditar'])->name('librosEditar');
Route::get('eliminar/libros/{id}',[reporteBimestral::class, 'librosEliminar'])->name('librosEliminar');
Route::get('eliminar/librosR/{id}',[reporteBimestral::class, 'librosEliminarR'])->name('librosEliminarR');
////////////////////////////Fin de las rutas del modulo de Difucion y docencia////////////////////////////////

//////////////////////////////////////Rutas del modulo de cursos recividos////////////////////////////////////
Route::get('cursosRecibidos',[reporteBimestral::class, 'cursosRecibidos'])->name('cursosRecibidos');
Route::post('nuevocursoRecibido',[reporteBimestral::class, 'nuevocursoRecibido'])->name('nuevocursoRecibido');
Route::get('editar/cursosRecibido/{id}',[reporteBimestral::class, 'cursoRecibidoEditar'])->name('cursoRecibidoEditar');
Route::get('eliminar/cursosRecibido/{id}',[reporteBimestral::class, 'cursoRecibidoEliminar'])->name('cursoRecibidoEliminar');
Route::get('eliminar/cursosRecibidoR/{id}',[reporteBimestral::class, 'cursoRecibidoEliminarR'])->name('cursoRecibidoEliminarR');
/////////////////////////////////fin de las rutas del modulo de cursos recividos//////////////////////////////

//////////////////////////////////////Rutas del modulo de postgrados//////////////////////////////////////////
Route::get('postgrados',[reporteBimestral::class, 'postgrados'])->name('postgrados');
Route::post('nuevopostgrados',[reporteBimestral::class, 'nuevopostgrados'])->name('nuevopostgrados');
Route::post('editar/postgrados',[reporteBimestral::class, 'postgradosEditar'])->name('postgradosEditar');
Route::get('eliminar/postgrados/{id}',[reporteBimestral::class, 'postgradosEliminar'])->name('postgradosEliminar');
/////////////////////////////////fin de las rutas del modulo de postgrados////////////////////////////////////

//////////////////////////////////////Rutas del modulo de tesis///////////////////////////////////////////////
Route::get('tesis',[reporteBimestral::class, 'tesis'])->name('tesis');
Route::post('nuevotesis',[reporteBimestral::class, 'nuevotesis'])->name('nuevotesis');
Route::get('editar/tesis/{id}',[reporteBimestral::class, 'tesisEditar'])->name('tesisEditar');
Route::get('eliminar/tesis/{id}',[reporteBimestral::class, 'tesisEliminar'])->name('tesisEliminar');
/////////////////////////////////fin de las rutas del modulo de tesis/////////////////////////////////////////

//////////////////////////////////////Rutas del modulo de otras actividades///////////////////////////////////
Route::get('otrasactividades',[reporteBimestral::class, 'otrasactividades'])->name('otrasactividades');
Route::post('nuevaactividad',[reporteBimestral::class, 'nuevaactividad'])->name('nuevaactividad');
Route::get('editar/actividad/{id}',[reporteBimestral::class, 'actividadEditar'])->name('actividadEditar');
Route::get('eliminar/actividad/{id}',[reporteBimestral::class, 'actividadEliminar'])->name('actividadEliminar');
Route::get('eliminar/actividadR/{id}',[reporteBimestral::class, 'actividadEliminarR'])->name('actividadEliminarR');
/////////////////////////////////fin de las rutas del modulo de otras actividades/////////////////////////////

//////////////////////////////////////Rutas de levantar comites///////////////////////////////////
Route::get('comitesAdmin',[dbcontroller::class, 'comitesAdmin'])->name('comitesAdmin');
Route::get('serviciosAdmin',[dbcontroller::class, 'serviciosAdmin'])->name('serviciosAdmin');
/*Route::get('upusers/{id}',[dbcontroller::class, 'upusers'])->name('upusers');
Route::post('upuser/{id}',[dbcontroller::class, 'upuser'])->name('upuser');
Route::get('changestatuuser',[dbcontroller::class, 'changestatuuser'])->name('changestatuuser');*/
/////////////////////////////////fin de las rutas del moddulo de levantar comites/////////////////////////////

//////////////////////////////////////Rutas de reportes de usuario////////////////////////////////////////////
Route::get('menureportes',[reporteBimestral::class, 'menureportes'])->name('menureportes');
Route::get('reporte', [reporteBimestral::class, 'reporte'])->name('reporte');
Route::get('reporteACVN', [reporteBimestral::class, 'reporteACVN'])->name('reporteACVN');
Route::get('reporteACDF', [reporteBimestral::class, 'reporteACDF'])->name('reporteACDF');
Route::get('reporteACCM', [reporteBimestral::class, 'reporteACCM'])->name('reporteACCM');
Route::get('reporteConfigIndicadores', [reporteBimestral::class, 'reporteConfigIndicadores'])->name('reporteConfigIndicadores');
Route::post('insertarRegistrosIndicadores',[reporteBimestral::class, 'insertarRegistrosIndicadores'])->name('insertarRegistrosIndicadores');
Route::get('indicadoresrendimiento', [reporteBimestral::class, 'indicadoresrendimiento'])->name('indicadoresrendimiento');
// Route::get('insertarRegistros20102030', [reporteBimestral::class, 'insertarRegistros20102030'])->name('insertarRegistros20102030');
//////////////////////Tablas de indicadores//////////////////////////
Route::get('indicadorProyectosInternosTablas', [reporteBimestral::class, 'indicadorProyectosInternosTablas'])->name('indicadorProyectosInternosTablas');
Route::get('indicadorProyectosITodosTablas', [reporteBimestral::class, 'indicadorProyectosITodosTablas'])->name('indicadorProyectosITodosTablas');
Route::get('indicadorProyectosExternosTablas', [reporteBimestral::class, 'indicadorProyectosExternosTablas'])->name('indicadorProyectosExternosTablas');
Route::get('indicadorServiciosTablas', [reporteBimestral::class, 'indicadorServiciosTablas'])->name('indicadorServiciosTablas');
Route::get('indicadoresRevistasMemoriasNacionalestabla', [reporteBimestral::class, 'indicadoresRevistasMemoriasNacionalestabla'])->name('indicadoresRevistasMemoriasNacionalestabla');
Route::get('indicadoresRevistasMemoriasInternacionalestabla', [reporteBimestral::class, 'indicadoresRevistasMemoriasInternacionalestabla'])->name('indicadoresRevistasMemoriasInternacionalestabla');
Route::get('indicadoresBoletinestabla', [reporteBimestral::class, 'indicadoresBoletinestabla'])->name('indicadoresBoletinestabla');
Route::get('indicadorPonenciasConferenciasTablas', [reporteBimestral::class, 'indicadorPonenciasConferenciasTablas'])->name('indicadorPonenciasConferenciasTablas');
Route::get('indicadorDocumentosTablas', [reporteBimestral::class, 'indicadorDocumentosTablas'])->name('indicadorDocumentosTablas');
Route::get('indicadoresReunionesSolicitudestabla', [reporteBimestral::class, 'indicadoresReunionesSolicitudestabla'])->name('indicadoresReunionesSolicitudestabla');
Route::get('indicadoresPostgradostabla', [reporteBimestral::class, 'indicadoresPostgradostabla'])->name('indicadoresPostgradostabla');
Route::get('indicadoresDocenciatabla', [reporteBimestral::class, 'indicadoresDocenciatabla'])->name('indicadoresDocenciatabla');
Route::get('indicadoresDocenciatabla1', [reporteBimestral::class, 'indicadoresDocenciatabla1'])->name('indicadoresDocenciatabla1');
Route::get('indicadoresTesisCursostabla', [reporteBimestral::class, 'indicadoresTesisCursostabla'])->name('indicadoresTesisCursostabla');
//////////////////////Graficas de indicadores por bimestre//////////////////////////
Route::get('indicadorProyectosInternosGrafica', [reporteBimestral::class, 'indicadorProyectosInternosGrafica'])->name('indicadorProyectosInternosGrafica');
Route::get('indicadorProyectosIntExtGrafica', [reporteBimestral::class, 'indicadorProyectosIntExtGrafica'])->name('indicadorProyectosIntExtGrafica');
Route::get('indicadorProyectosExternosGrafica', [reporteBimestral::class, 'indicadorProyectosExternosGrafica'])->name('indicadorProyectosExternosGrafica');
Route::get('indicadorServiciosGrafica', [reporteBimestral::class, 'indicadorServiciosGrafica'])->name('indicadorServiciosGrafica');
Route::get('indicadoresRevistasMemoriasNacionalesGrafica', [reporteBimestral::class, 'indicadoresRevistasMemoriasNacionalesGrafica'])->name('indicadoresRevistasMemoriasNacionalesGrafica');
Route::get('indicadoresRevistasMemoriasInternacionalesGrafica', [reporteBimestral::class, 'indicadoresRevistasMemoriasInternacionalesGrafica'])->name('indicadoresRevistasMemoriasInternacionalesGrafica');
Route::get('indicadoresBoletinesGrafica', [reporteBimestral::class, 'indicadoresBoletinesGrafica'])->name('indicadoresBoletinesGrafica');
Route::get('indicadorPonenciasConferenciasGrafica', [reporteBimestral::class, 'indicadorPonenciasConferenciasGrafica'])->name('indicadorPonenciasConferenciasGrafica');
Route::get('indicadorDocumentosGrafica', [reporteBimestral::class, 'indicadorDocumentosGrafica'])->name('indicadorDocumentosGrafica');
Route::get('indicadoresReunionesSolicitudesGrafica', [reporteBimestral::class, 'indicadoresReunionesSolicitudesGrafica'])->name('indicadoresReunionesSolicitudesGrafica');
Route::get('indicadoresPostgradosGrafica', [reporteBimestral::class, 'indicadoresPostgradosGrafica'])->name('indicadoresPostgradosGrafica');
Route::get('indicadoresDocenciaGrafica', [reporteBimestral::class, 'indicadoresDocenciaGrafica'])->name('indicadoresDocenciaGrafica');
Route::get('indicadoresDocenciaGrafica1', [reporteBimestral::class, 'indicadoresDocenciaGrafica1'])->name('indicadoresDocenciaGrafica1');
Route::get('indicadoresTesisCursosGrafica', [reporteBimestral::class, 'indicadoresTesisCursosGrafica'])->name('indicadoresTesisCursosGrafica');
//////////////////////Graficas de indicadores por sexenio//////////////////////////
Route::get('indicadorProyectosInternosGraficaAños', [reporteBimestral::class, 'indicadorProyectosInternosGraficaAños'])->name('indicadorProyectosInternosGraficaAños');
Route::get('indicadorProyectosExternosGraficaAños1', [reporteBimestral::class, 'indicadorProyectosExternosGraficaAños1'])->name('indicadorProyectosExternosGraficaAños1');
Route::get('indicadorProyectosExternosGraficaAños2', [reporteBimestral::class, 'indicadorProyectosExternosGraficaAños2'])->name('indicadorProyectosExternosGraficaAños2');
Route::get('indicadorProyectosIn_Ex_ternosGraficaAños', [reporteBimestral::class, 'indicadorProyectosIn_Ex_ternosGraficaAños'])->name('indicadorProyectosIn_Ex_ternosGraficaAños');
Route::get('indicadorServiciosGraficaAños', [reporteBimestral::class, 'indicadorServiciosGraficaAños'])->name('indicadorServiciosGraficaAños');
Route::get('indicadorMem_Rev_NacGraficaAños', [reporteBimestral::class, 'indicadorMem_Rev_NacGraficaAños'])->name('indicadorMem_Rev_NacGraficaAños');
Route::get('indicadorMem_Rev_ItnacGraficaAños', [reporteBimestral::class, 'indicadorMem_Rev_ItnacGraficaAños'])->name('indicadorMem_Rev_ItnacGraficaAños');
Route::get('indicadoresBoletinesGraficaporAño', [reporteBimestral::class, 'indicadoresBoletinesGraficaporAño'])->name('indicadoresBoletinesGraficaporAño');
Route::get('indicadorPonenConfGraficaAños', [reporteBimestral::class, 'indicadorPonenConfGraficaAños'])->name('indicadorPonenConfGraficaAños');
Route::get('indicadorDocTecGraficaAños', [reporteBimestral::class, 'indicadorDocTecGraficaAños'])->name('indicadorDocTecGraficaAños');
Route::get('indicadorReu_solc_GraficaAños', [reporteBimestral::class, 'indicadorReu_solc_GraficaAños'])->name('indicadorReu_solc_GraficaAños');
Route::get('indicadorPostgradosGraficaAños', [reporteBimestral::class, 'indicadorPostgradosGraficaAños'])->name('indicadorPostgradosGraficaAños');
Route::get('indicadorDocenciasGraficaAños1', [reporteBimestral::class, 'indicadorDocenciasGraficaAños1'])->name('indicadorDocenciasGraficaAños1');
Route::get('indicadorDocenciasGraficaAños2', [reporteBimestral::class, 'indicadorDocenciasGraficaAños2'])->name('indicadorDocenciasGraficaAños2');
Route::get('indicadorTesisCursosRecGraficaAños', [reporteBimestral::class, 'indicadorTesisCursosRecGraficaAños'])->name('indicadorTesisCursosRecGraficaAños');
//////////////////////////////fin de las rutas del modulo de reportes de usuario//////////////////////////////

});

//rutas para obtener todos los niveles de cleintes 
Route::prefix('/clients')->middleware(['isLogged','preventBackHistory'])->group(function(){
    Route::get('/nivel3/{category_name_1}/{category_name_2}',[dbcontroller::class,'getCategoriesListN3ByJSON'])->name('clients.n3.get');

    //retorna todas las categorias nivel 2 sin excluir ninguna
    Route::get('/nivel2/all/{category_name_1}',[dbcontroller::class,'getCategoriesListN2All'])->name('clients.n2.all');
    
    Route::get('/nivel2/{category_name}',[dbcontroller::class,'getCategoriesListN2ByJSON'])->name('clients.n2.get');

    Route::get('/nivel2/{category_name}/{exclude}',[dbcontroller::class,'getClientsExcludeByDepartamento'])->name('clients.n2.get.exclude');

    Route::get('/nivel1',[dbcontroller::class,'getCategoriesListByJSON'])->name('clients.get');

    Route::get('/fullname/{nivel1}/{nivel2}/{nivel3}',[dbcontroller::class,'getIdClientByFullNameByJSON'])->name('clients.fullname');

    Route::get('/is-in-area/{area}',[dbcontroller::class,'currentUserIsInDeptoByJSON'])->name('clients.is.in.area');
       //retorna las coincidencias con un valor otorgado
       Route::get('/search/{client}',[SearchClientController::class,'getClientByInputJSON'])->name('clients.search');
});

Route::prefix('/projects')->middleware(['isLogged','preventBackHistory'])->group(function(){

    Route::get('/area/user',[dbcontroller::class,'getCurrentUserAuthDepto'])->name('projects.area.user');
    //rutas para proyectos con multicoordinacion
    Route::get('/area/{name_area}',[dbcontroller::class,'getProjectsAreaAndMulticoordinacionByJSON'])->name('projects.area');
    Route::get('/area/my-projects',[dbcontroller::class,'getProjectsByUserAndAreaAuth'])->name('projects.user.area');
    Route::get('/areas-adscripcion',[dbcontroller::class,'getAreasAdscripcion'])->name('projects.areas');

    Route::get('/search-by',[ApiController::class,'getProjectsByNombreClaveResponsable'])->name('projects.search.by');

    Route::post('/change-estado',[dbcontroller::class,'changeEstadoProject'])->name('projects.change.estado');


});

//ruta para el reporte con formato F2 GS 001
Route::prefix('/reportes')->middleware(['isLogged','preventBackHistory'])->group(function(){
    Route::post('/format-f2_gs_001',[\App\Http\Controllers\reportes\F2GS001Controller::class,'getF2GS001Report'])->name('reports.format.f2gs001');
});

