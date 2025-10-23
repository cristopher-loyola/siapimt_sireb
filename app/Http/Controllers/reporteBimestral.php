<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Exports\Afectacion_Export;
use App\Exports\ProyectosExport;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
//Archivos para los correos//
use Illuminate\Support\Facades\Mail;
use App\Mail\notification;
use App\Mail\notificationElim;
use App\Mail\notificationReunion;
use App\Mail\notificationElimReunion;
use App\Mail\notificationComite;
use App\Mail\notificationElimComite;
use App\Mail\notificationSolicitudes;
use App\Mail\notificationElimSolicitudes;
use App\Mail\notificationRevistas;
use App\Mail\notificationElimRevistas;
use App\Mail\notificationMemorias;
use App\Mail\notificationElimMemorias;
use App\Mail\notificationponenciaconferencia;
use App\Mail\notificationElimponenciaconferencia;
use App\Mail\notificationLibros;
use App\Mail\notificationElimLibros;
use App\Mail\notificationCursos;
use App\Mail\notificationElimCursos;
use App\Mail\notificationOtraActividad;
use App\Mail\notificationElimOtraActividad;
use Carbon\Carbon;
use App\Mail\notificaractivarimpacto;
//modelos de MySQL//
use App\Models\User;
use App\Models\Cliente;
use App\Models\serviciotecnologico;
use App\Models\serviciotecnologico_usuario;
use App\Models\reunion;
use App\Models\reunion_usuario;
use App\Models\comite;
use App\Models\comite_usuario;
use App\Models\solicitudes;
use App\Models\solicitud_usuario;
use App\Models\revista;
use App\Models\revista_usuario;
use App\Models\memoria;
use App\Models\memoria_usuario;
use App\Models\ponenciasconferencia;
use App\Models\ponenciaconferencia_usuario;
use App\Models\docencia;
use App\Models\libro;
use App\Models\libros_usuario;
use App\Models\cursorecibido;
use App\Models\cursorecibido_usuarios;
use App\Models\postgrado;
use App\Models\tesi;
use App\Models\otraactivida;
use App\Models\otraactivida_usuarios;
use App\Models\fechabimestre;
use App\Models\comitesAdmin;
use App\Models\Proyecto;
use App\Models\Equipo;
use App\Models\Impacto;
use App\Models\Area;
use App\Models\ServiciostecnologicosAdmin;
use App\Models\miconfig;

use DateTime;

class reporteBimestral extends Controller
{
    // Función para obtener el mes de inicio de un bimestre
    private function getStartMonthOfBimester($bimestre) {
        $mesesPorBimestre = [
            'Enero-Febrero' => 1, // El mes de inicio de Enero-Febrero es enero (1)
            'Marzo-Abril' => 3,  // El mes de inicio de Marzo-Abril es Marzo (3)
            'Mayo-Junio' => 5,  // El mes de inicio de Mayo-Junio es Mayo (5)
            'Julio-Agosto' => 7,  // El mes de inicio de Julio-Agosto es Julio (7)
            'Septiembre-Octubre' => 9,  // El mes de inicio de Septiembre-Octubre es Septiembre (9)
            'Noviembre-Diciembre' => 11,  // El mes de inicio de Noviembre-Diciembre es Noviembre (11)
        ];

        return $mesesPorBimestre[$bimestre] ?? 1; // Si el bimestre no se encuentra, se utiliza enero (1) por defecto
    }

    private function getEndMonthOfBimester($bimestre) {
        $mesesPorBimestre = [
            'Enero-Febrero' => 2,   // El mes de finalización de Enero-Febrero es febrero (2)
            'Marzo-Abril' => 4,     // El mes de finalización de Marzo-Abril es abril (4)
            'Mayo-Junio' => 6,      // El mes de finalización de Mayo-Junio es junio (6)
            'Julio-Agosto' => 8,    // El mes de finalización de Julio-Agosto es agosto (8)
            'Septiembre-Octubre' => 10, // El mes de finalización de Septiembre-Octubre es octubre (10)
            'Noviembre-Diciembre' => 12, // El mes de finalización de Noviembre-Diciembre es diciembre (12)
        ];

        return $mesesPorBimestre[$bimestre] ?? 2; // Si el bimestre no se encuentra, se utiliza Febrero (2) por defecto
    }

    private function calcularBimestres($fechaInicio, $fechaFin) {
        // Convierte las fechas en objetos DateTime
        $inicio = new \DateTime($fechaInicio);
        $fin = new \DateTime($fechaFin);

        // Inicializa un array para almacenar los bimestres involucrados
        $bimestres = [];

        // Encuentra el primer bimestre
        $bimestres[] = $this->obtenerBimestre($inicio);

        // Mientras la fecha de inicio no alcance o supere la fecha de fin
        while ($inicio < $fin) {
            // Avanza un mes
            $inicio->modify('+1 month');

            // Encuentra el bimestre actual
            $bimestres[] = $this->obtenerBimestre($inicio);
        }

        return $bimestres;
    }

    private function obtenerBimestre($fecha) {
        $mes = $fecha->format('n');
        $bimestres = [
            1 => 'Enero-Febrero',
            2 => 'Enero-Febrero',
            3 => 'Marzo-Abril',
            4 => 'Marzo-Abril',
            5 => 'Mayo-Junio',
            6 => 'Mayo-Junio',
            7 => 'Julio-Agosto',
            8 => 'Julio-Agosto',
            9 => 'Septiembre-Octubre',
            10 => 'Septiembre-Octubre',
            11 => 'Noviembre-Diciembre',
            12 => 'Noviembre-Diciembre',
        ];

        return $bimestres[$mes];
    }

    public function difusionD(request $request)
    {
        if(session()->has('LoginId')){
            $users= User::join('t_accessos','t_accessos.id','=','usuarios.acceso')
                ->orderBy('usuarios.Apellido_Paterno', 'ASC')
                ->get(['usuarios.id',
                    'usuarios.Nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                    'usuarios.usuario',
                    't_accessos.nom_acceso',
                    'usuarios.status',
                    'usuarios.responsable',
                    'usuarios.sesionespecial'
                ]);
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }



        try {
            // Conecta a la base de datos remota (latontatexas)
            DB::setDefaultConnection('latontatexas');

            // Lista de tablas a copiar
            $tablas = [
                'imt_bol_articulo' => ['ID_BOL_Articulo', 'ID_BOL_Boletin', 'NoArticulo', 'titulo', 'Autor'],
                'imt_bol_autorarticulo' => ['ID_BOL_Articulo', 'ID_GEN_Autor', 'Jerarquia'],
                'imt_bol_boletin' => ['ID_BOL_Boletin', 'Anio', 'IdMes', 'ID_GEN_Coordinacion', 'NoBoletin', 'Titulo', 'Activo'],
                'imt_gen_autor' => ['ID_GEN_Autor', 'Nombre', 'NombreCorto', 'Apellidos', 'Iniciales', 'Activo', 'curp'],
                'imt_gen_coordinacion' => ['ID_GEN_Coordinacion', 'Nombre', 'Acronimo', 'NombreCorto', 'VerToolTip', 'Orden'],
                'imt_pub_autorpublicacion' => ['ID_PUB_Publicacion', 'ID_GEN_Autor', 'Jerarquia'],
                'imt_pub_publicacion' => ['ID_PUB_Publicacion', 'ID_PUB_TipoPublicacion', 'ID_GEN_Coordinacion', 'Anio', 'NoPublicacion', 'Titulo', 'Resumen', 'AreaInteres', 'Precio', 'Archivo', 'Empastado', 'IncluyeCD', 'SoloCopias', 'NoPaginasPortada', 'NoPaginasColor', 'NoPaginasBN', 'EsTerminado', 'EsRevisarDifusion', 'SoloSCT', 'Agotada', 'ProcesoImpresion', 'ID_PUB_EstatusPublicacion', 'Anexo', 'Novedad', 'CveProy'],
                'imt_pub_tipopublicacion' => ['id_pub_tipoPublicacion', 'Nombre', 'Activo']
            ];

        // Conecta a la base de datos local (mysql2)
        DB::setDefaultConnection('mysql2');

        // Itera sobre las tablas y copia los datos en lotes
        foreach ($tablas as $nombreTabla => $campos) {
            // Elimina todos los registros de la tabla
            DB::table($nombreTabla)->truncate();

            $datosRemotos = DB::connection('latontatexas')->table($nombreTabla)->get();
            $datosLocales = collect($datosRemotos)->chunk(100); // Ajusta el tamaño del lote según tus necesidades

            foreach ($datosLocales as $loteDatos) {
                // Realiza la inserción
                DB::table($nombreTabla)->insert(
                    $loteDatos->map(function ($dato) use ($campos) {
                        // Convierte el objeto stdClass a array
                        $datoArray = (array) $dato;

                        // Filtra solo los campos deseados
                        $datosFiltrados = Arr::only($datoArray, $campos);

                        return $datosFiltrados;
                    })->toArray()
                );
            }
        }

        // Restaura la conexión predeterminada
        DB::setDefaultConnection('mysql2');

        return redirect(route('alerta', $data, compact('users')))->with(['success' => true, 'message' => 'Datos copiados exitosamente']);
    } catch (\Exception $e) {
        // Maneja cualquier excepción que pueda ocurrir
        return response()->json(['failed' => false, 'message' => $e->getMessage()]);
    }
}

    public function alerta(){
        $publicacion = DB::table('siapimt25.imt_pub_publicacion')->where('CveProy', '!=', '')->get();
        $proyecto = Proyecto::all();
        foreach ($proyecto as $pr) {
            $ppp = Proyecto::find($pr->id);
                if ($pr->claven < 10) {
                    $clave = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey;
                } else 	{
                    $clave = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey;
                }

                foreach ($publicacion as $pub) {
                    if ($clave == $pub->CveProy) {
                        $ppp->idpublicacion = $pub->ID_PUB_Publicacion;
                        $ppp->publicacion = 1;
                    }
                }
            $ppp->save();
        }

        $fechaactual = new DateTime(date('Y-m-d'));
        $proytimp = Proyecto::join('siapimt25.imt_pub_publicacion','siapimt25.imt_pub_publicacion.ID_PUB_Publicacion','=','proyectos.idpublicacion')
        ->Where('clavet', 'I')
        ->Where('estado', 2)
        ->Where('oculto', 1)
        ->Where('publicacion', 1)
        ->Where('actimpacto', 0)
        ->Where('idpublicacion', '!=' ,'null')
        ->get([
            'proyectos.id',
            'proyectos.nomproy',
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.idpublicacion',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.estado',
            'proyectos.actimpacto',
            'proyectos.idusuarior',
            'proyectos.aprobo',
            'proyectos.idarea',
            'siapimt25.imt_pub_publicacion.ID_PUB_Publicacion',
            'siapimt25.imt_pub_publicacion.Anio',
            'siapimt25.imt_pub_publicacion.NoPublicacion'
        ]);
        
        foreach ($proytimp as $pr) {
            if (!empty($pr->Anio) && strtotime($pr->Anio)) {
                $fechaFin = new DateTime($pr->Anio);
                $intervalo = $fechaFin->diff($fechaactual);
                $meses = $intervalo->y * 12 + $intervalo->m;// Total de meses
                $dias = $intervalo->d;// Días restantes en este mes
                $meses += $dias / 30.44; // Usar promedio de días por mes para mayor precisión
                $pr->meses_diferencia = round($meses, 1);// Redondear a 2 decimales

                if (round($meses, 1) >= 2) {
                    $upproy = Proyecto::find($pr->id);
                    $upproy->actimpacto = 1;

                    $responsable = User::where('id', $pr->idusuarior)->first();
                    $autoriza = User::where('id', $pr->aprobo)->first();
                    $area = Area::where('id', $pr->idarea )->first();

                    if ($pr->claven < 10) {
                        $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                    } else 	{
                        $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                    }

                    $upproy->save();
                    $details = [
                        'mando' => $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno,
                        'responsable' => $responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno,
                        'area' => $area->nombre_area,
                        'clave' => $nombreproyecto
                    ];

                    $destinatarios = [
                        $autoriza->correo,
                        $responsable->correo
                    ];

                    Mail::to($destinatarios)->send(new notificaractivarimpacto($details));
                }
            } else {
                $pr->cumple = 0;
            }
        }

        $proyt = Proyecto::Where('clavet', 'I')
            ->Where('estado', 2)
            ->Where('oculto', 1)
            ->Where('publicacion', 2)
            ->Where('actimpacto', 0)
            ->get([
                'proyectos.id',
                'proyectos.nomproy',
                'proyectos.clavea',
                'proyectos.clavet',
                'proyectos.claven',
                'proyectos.clavey',
                'proyectos.idpublicacion',
                'proyectos.fecha_inicio',
                'proyectos.fechapublicacion',
                'proyectos.fecha_fin',
                'proyectos.estado',
                'proyectos.actimpacto',
                'proyectos.idusuarior',
                'proyectos.aprobo',
                'proyectos.idarea'
        ]);
        
        foreach ($proyt as $pr) {
            // Seleccionar fechapublicacion si existe, sino usar fecha_fin
            $fechaReferenciaStr = !empty($pr->fechapublicacion) && strtotime($pr->fechapublicacion)
                ? $pr->fechapublicacion
                : (!empty($pr->fecha_fin) && strtotime($pr->fecha_fin)
                    ? $pr->fecha_fin
                    : null);

            if ($fechaReferenciaStr) {
                $fechaReferencia = new DateTime($fechaReferenciaStr);
                $intervalo = $fechaReferencia->diff($fechaactual);
                $meses = $intervalo->y * 12 + $intervalo->m; // Total de meses
                $dias = $intervalo->d; // Días restantes en este mes
                $meses += $dias / 30.44; // Promedio de días por mes para más precisión
                $pr->meses_diferencia = round($meses, 1); // Redondear a un decimal

                if (round($meses, 1) >= 2) {
                    $upproy = Proyecto::find($pr->id);
                    $upproy->actimpacto = 1;

                    $responsable = User::find($pr->idusuarior);
                    $autoriza = User::find($pr->aprobo);
                    $area = Area::find($pr->idarea);

                    if ($pr->claven < 10) {
                        $nombreproyecto = $pr->clavea . $pr->clavet . '-0' . $pr->claven . '/' . $pr->clavey . ' | ' . $pr->nomproy;
                    } else {
                        $nombreproyecto = $pr->clavea . $pr->clavet . '-' . $pr->claven . '/' . $pr->clavey . ' | ' . $pr->nomproy;
                    }

                    $upproy->save();

                    $details = [
                        'mando' => $autoriza->Nombre . ' ' . $autoriza->Apellido_Paterno . ' ' . $autoriza->Apellido_Materno,
                        'responsable' => $responsable->Nombre . ' ' . $responsable->Apellido_Paterno . ' ' . $responsable->Apellido_Materno,
                        'area' => $area->nombre_area,
                        'clave' => $nombreproyecto
                    ];

                    $destinatarios = [
                        $autoriza->correo,
                        $responsable->correo
                    ];

                    Mail::to($destinatarios)->send(new notificaractivarimpacto($details));
                }
            } else {
                $pr->cumple = 0;
            }
        }

        return view('SIRB/alertaBD');
    }


//////////////////////////////////////Funciones para el modulo de comitesAdmin///////////////////////////////



    //funcion para un nuevo comitesAdmin
    public function nuevocomiteAdmin(request $request)
    {
        //dd($request->all());

        $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

        $comiteAdmin = new comitesAdmin;
        $comiteAdmin->nombre = $request->nombrecomite;
        $comiteAdmin->tipo = $request->tipocomite;
        $comiteAdmin->save();


        return redirect(route('comitesAdmin', $data));
    }


    //funcion para editar
    public function comitesAdminEditar(request $request, $id)
    {

        $comiteAdmin = comitesAdmin::find($id);
        $comiteAdmin->nombre = $request->nombrecomite;
        $comiteAdmin->tipo = $request->tipocomite;
        $comiteAdmin->save();

        return redirect(route('comitesAdmin'));
    }


    //funcion para eliminar
    public function comitesAdminEliminar($id)
    {

        // Eliminar la solicitud principal
        $comiteAdmin = comitesAdmin::find($id);
        $comiteAdmin->delete();

        return redirect(route('comitesAdmin'));

    }

///////////////////////////Fin de las funciones para el modulo de comitesAdmin///////////////////////////////

//////////////////////////////////////Funciones para el modulo de serviciosAdmin/////////////////////////////



    //funcion para un nuevo serviciosAdmin
    public function nuevoserviciosAdmin(request $request)
    {
        //dd($request->all());

        $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

        $servicioAdmin = new ServiciostecnologicosAdmin;
        $servicioAdmin->nombre = $request->nombreservicio;
        $servicioAdmin->save();


        return redirect(route('serviciosAdmin', $data));
    }


    //funcion para editar
    public function serviciosAdminEditar(request $request, $id)
    {

        $servicioAdmin = ServiciostecnologicosAdmin::find($id);
        $servicioAdmin->nombre = $request->nombreservicio;
        $servicioAdmin->save();

        return redirect(route('serviciosAdmin'));
    }


    //funcion para eliminar
    public function serviciosAdminEliminar($id)
    {

        // Eliminar la solicitud principal
        $servicioAdmin = ServiciostecnologicosAdmin::find($id);
        $servicioAdmin->delete();

        return redirect(route('serviciosAdmin'));

    }

///////////////////////////Fin de las funciones para el modulo de serviciosAdmin/////////////////////////////

///////////////////////////////////////////Funciones para el modulo de inicio////////////////////////////////

    //funcion para El nuevo inicio del usuario (Pero se usa en el controladordbcontroller)
    public function inicioUsuario(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');

        $userInfo = User::where('id', session('LoginId'))->first();

        $fullName = User::selectRaw('CONCAT(Nombre) AS nombre_completo')
            ->where('id', session('LoginId'))
            ->first();

        /*$fullName = User::selectRaw('CONCAT(Nombre, " ", Apellido_Paterno, " ", Apellido_Materno) AS nombre_completo')
            ->where('id', session('LoginId'))
            ->first();*/

        $fechabimestre = DB::table('usuarios')->where('id', $userID)->first();

        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
          $añoActual = $fechabimestre->año;
          $bimestreActual = $fechabimestre->bimestre;

        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        $periodoConsultado = $bimestreActual . " del " . $añoActual;

        $data = [
            'LoggedUserInfo' => $userInfo,
            'FullName' => $fullName->nombre_completo,
            'fechabimestre' => $fechabimestre,
            'periodoConsultado'=>$periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'userID' => $userID
        ];

        return view('SIRB/newinicio4', $data);
    }

    public function nuevafecha(Request $request)
    {
        // Obtener todos los usuarios
        $usuarios = User::all();

        // Actualizar cada usuario
        foreach ($usuarios as $usuario) {
            $usuario->año = $request->slct1;
            $usuario->bimestre = $request->slct2;
            $usuario->save();
        }

     return redirect(route('iniciousuario'));

    }

    public function editarfecha(Request $request, $id)
    {
        $fechabimestre = User::find($id);
        $fechabimestre->año = $request->slct1;
        $fechabimestre->bimestre = $request->slct2;
        $fechabimestre->save();

        $idEdit = 2; // Reemplaza 2 con el ID que desees editar
        $fechabimestre = fechabimestre::find($idEdit);
        $fechabimestre->año = $request->slct3;
        $fechabimestre->bimestre = $request->slct4;
        $fechabimestre->save();

        return redirect(route('iniciousuario'));

    }

    public function editarfecha2(Request $request, $id)
    {
        $fechabimestre = User::find($id);
        $fechabimestre->año = $request->year;
        $fechabimestre->bimestre = $request->bimestre;
        $fechabimestre->save();

     return back();

    }

/////////////////////////////////Fin de las funciones para el modulo de inicio///////////////////////////////

///////////////////////////Funciones para el modulo de Servicios Tecnologicos////////////////////////////////

    //funcion para Sercicios Tecnologicos
    public function serciciosTecnologicos(request $request)
    {
        $dbController = new dbcontroller();

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el idarea del usuario autenticado
        $idarea = $user->idarea;
        // Obtener el nombre completo del usuario autenticado
        $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
        // Obtener todos los clientes
        $Cliente = Cliente::where('status',1)->get();
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Servicios listados
        $ServiciostecnologicosAdmin = ServiciostecnologicosAdmin::all();
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)
            ->whereIn('acceso', [2, 3])
            ->orderBy('Apellido_Paterno')
            ->orderBy('Apellido_Materno')
            ->orderBy('Nombre')
            ->get();




        // Obtener servicios tecnologicos relacionados con el usuario y la fecha del periodo
        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;

        $mesInicioBimestre = $this->getStartMonthOfBimester($fechabimestre2->bimestre);
        $mesFinBimestre = $this->getEndMonthOfBimester($fechabimestre2->bimestre);

        // Obtener los registros de servicios tecnológicos
        $serviciotecnologico = serviciotecnologico::where('nombre_persona', $user->usuario)
        ->whereYear('fechafin', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fechainicio', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fechafin', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        // Obtener los registros relacionados de servicios tecnológicos
        $serviciotecnologicoRelacionadas = serviciotecnologico::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fechafin', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fechainicio', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fechafin', $this->getEndMonthOfBimester($bimestreActual));
        })->get();


        $periodoConsultado = $bimestreActual . " del " . $añoActual;

        $serviciotecnologicoDescripcion = serviciotecnologico_usuario::where('usuario_id', $userID)->get();

        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();


        $categoriesN1 = $dbController->getCategoriesList();
        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'userID' => $userID,
            'nombreCompleto' => $nombreCompleto,
            'Cliente' => $Cliente,
            'idarea' => $idarea,
            'usuarios' => $usuarios,
            'sesionEspecial' => $sesionEspecial,
            'serviciotecnologico' => $serviciotecnologico,
            'serviciotecnologicoRelacionadas' => $serviciotecnologicoRelacionadas,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            'periodoConsultado' => $periodoConsultado,
            'serviciotecnologicoDescripcion' => $serviciotecnologicoDescripcion,
            'fechabimestreP' => $fechabimestreP,
            'ServiciostecnologicosAdmin' => $ServiciostecnologicosAdmin,
            'categoriesN1' => $categoriesN1

        ];

    return view('SIRB/serviciostecnologico2', $data);
    }




    //funcion para nuevo servicio tecnologico
    public function nuevoserviciot(request $request)
    {
        /*
            Debido a implementaciones del nuevo componente y no realizar alteraciones
            en la base de datos, se obtiene el nombre para mantener la forma de registro
            del cliente y evitar inconsistencia de datos
        */
        $cliente = Cliente::select(
            DB::raw("
            CONCAT(cliente.nivel1,' | ' ,cliente.nivel2, ' | ' ,cliente.nivel3) as clienteNombre
            ")
        )
        ->where([
            ['cliente.id','=',$request->input('nombrecliente')]
        ])
        ->first();
        
        $nombreCliente = $cliente ? $cliente->clienteNombre : 'Cliente no encontrado';

        $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

        // Obtener la cadena de usuarios seleccionados
        $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
        // Dividir la cadena por comas para obtener un arreglo de IDs
        $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);



        // Crear la solicitud principal
        $serviciot = new serviciotecnologico;

        // Resto de campos de servicio tecno
        $serviciot->encargado = $request->encargadoservicio;
        $serviciot->nombreservicio = $request->nombreservicio;
        $serviciot->numeroregistro = $request->numeroregistro;
        $serviciot->nombrecliente = $nombreCliente;
        $serviciot->servicio = $request->servicio;
        $serviciot->costo = $request->costo;
        $serviciot->fechainicio = $request->fechainicio;
        $serviciot->fechafin = $request->fechafin;
        $serviciot->numerococ = $request->numerocontrato;
        $serviciot->duracion = $request->duracion;
        $serviciot->nombre_persona = $request->nombre_persona;
        $serviciot->participacion = $request->participacion;
        $serviciot->participantes = $request->usuarios_seleccionados;
        $serviciot->idarea = $request->area;
        $serviciot->save();

        // Verificar si hay usuarios seleccionados antes de asociarlos
        if (!empty($usuariosSeleccionados)) {
            // Asociar los usuarios seleccionados con la nueva serviciot
            foreach ($usuariosSeleccionados as $usuarioId) {
                // Verificar si $usuarioId es un valor válido (no vacío)
                if (!empty($usuarioId)) {
                    $serviciotUsuario = new serviciotecnologico_usuario([
                        'serviciostec_id' => $serviciot->id,
                        'usuario_id' => $usuarioId,
                    ]);
                    $serviciotUsuario->save();

                    // Enviar correo al participante actual
                    $usuario = User::find($usuarioId);
                    $correoParticipante = $usuario->correo;
                    // Crear un arreglo con la información del servicio y del participante
                    $details = [
                        'servicio' => $serviciot, // Información del servicio tecnológico
                        'participante' => $usuario, // Información del participante
                        'evento' => 'Servicio tecnológico'
                    ];

                    Mail::to($correoParticipante)->send(new notification($details));
                }
            }
        }

        return redirect(route('serciciosTecnologicos', $data));
    }


    //funcion para editar
    public function serviciotEditar(request $request, $id)
    {

        $serviciot = serviciotecnologico::find($id);
        $serviciot->nombreservicio = $request->nombreservicio;
        $serviciot->encargado = $request->encargadoservicio;
        $serviciot->numeroregistro = $request->numeroregistro;
        $serviciot->servicio = $request->servicio;
        $serviciot->costo = $request->costo;
        $serviciot->fechainicio = $request->fechainicio;
        $serviciot->fechafin = $request->fechafin;
        $serviciot->numerococ = $request->numerocontrato;
        $serviciot->duracion = $request->duracion;
        $serviciot->nombre_persona = $request->nombre_persona;
        $serviciot->descripcion = $request->descripcion;
        $serviciot->participantes = $request->usuarios_seleccionados;

        //solo se actualiza el cliente en caso de que se haya seleccionado uno nuevo
        if(isset($request->nombrecliente)){
            $cliente = Cliente::select(
                DB::raw("
                CONCAT(cliente.nivel1,' | ' ,cliente.nivel2, ' | ' ,cliente.nivel3) as clienteNombre
                ")
            )
            ->where([
                ['cliente.id','=',$request->input('nombrecliente')]
            ])
            ->first();
            
            if($cliente) {
                $serviciot->nombrecliente = $cliente->clienteNombre;
            }
        }

        $serviciot->save();


        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $serviciot->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
        if (strpos($usuariosSeleccionados, ',') !== false) {
            $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosArray = [$usuariosSeleccionados];
        }

        // Obtener la lista de todos los participantes previamente asociados a este registro
        $participantesActualesEnBD = serviciotecnologico_usuario::where('serviciostec_id', $serviciot->id)->pluck('usuario_id')->toArray();
        // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
        $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);

        // Eliminar a los participantes no seleccionados
        serviciotecnologico_usuario::where('serviciostec_id', $serviciot->id)
            ->whereIn('usuario_id', $participantesParaEliminar)
            ->delete();

        // Agregar nuevos participantes o mantener los existentes
        foreach ($participantesActualesArray as $usuarioId) {
            $serviciotUsuario = new serviciotecnologico_usuario([
                'serviciostec_id' => $serviciot->id,
                'usuario_id' => $usuarioId,
            ]);
            $serviciotUsuario->save();
        }

     //////////////////////////////////////////enviar correos//////////////////////////////////////////

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosBDMail = $request->usuarios_seleccionadosMail;
        if (strpos($usuariosBDMail, ',') !== false) {
            $usuariosBDMailArray = explode(',', $usuariosBDMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosBDMailArray = [$usuariosBDMail];
        }

        $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
        if (strpos($usuariosSeleccionadosMail, ',') !== false) {
            $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
        }

        $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
        $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

        // Envia correos de eliminación a los participantes a eliminar
        $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

        foreach ($usuariosParaEliminar as $usuarioElim) {
            $correoParticipanteElim = $usuarioElim->correo;
            $details = [
                'servicio' => $serviciot,
                'participante' => $usuarioElim,
                'evento' => 'Servicio tecnológico'
            ];

            Mail::to($correoParticipanteElim)->send(new notificationElim($details));
        }

        // Envia correos de edición a los nuevos participantes
        $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

        foreach ($usuariosParaAgregar as $usuario) {
            $correoParticipante = $usuario->correo;
            $details = [
                'servicio' => $serviciot,
                'participante' => $usuario,
                'evento' => 'Servicio tecnológico'
            ];

            Mail::to($correoParticipante)->send(new notification($details));
        }

        return redirect(route('serciciosTecnologicos'));
    }


    public function serviciotEditarDescripcion(Request $request, $id)
    {


        // Obtener el registro en 'serviciotecnologicos'
        $serviciot = serviciotecnologico::find($id);
        $serviciot->descripcion = $request->descripcion;
        $serviciot->porcentaje = $request->porcentaje;
        // Verificar si el porcentaje es igual a 100
        if ($request->porcentaje == 100) {
            $fechaActual = now();
            $fechaFormateada = $fechaActual->format('Y-m-d'); // Formatear la fecha en "aaaa-mm-dd"
            $serviciot->fechafin = $fechaFormateada;
        }
        $serviciot->save();

        return redirect(route('serciciosTecnologicos'));
    }


    public function serviciotEditarDescripcionRelacion(Request $request, $id)
    {
        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);

        // Obtener el registro en 'serviciotecnologicos'
        $servicioRelacion = serviciotecnologico_usuario::where('serviciostec_id', $id)->where('usuario_id', $userID)->first();
        $servicioRelacion->descripcionusuario = $request->descripcion;
        $servicioRelacion->save();

        return redirect(route('serciciosTecnologicos'));
    }



    //funcion para eliminar
    public function serviciotEliminar($id)
    {
        $serviciot = serviciotecnologico::find($id);

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $serviciot->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $detailsEliminar = [
                'servicio' => $serviciot, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Servicio tecnológico'
            ];

            Mail::to($correoParticipante)->send(new notificationElim($detailsEliminar));
        }
    }

        // Eliminar registros relacionados en solicitud_usuarios
        $serviciot->usuariosQuePuedenVisualizar()->delete();

        // Eliminar la solicitud principal
        $serviciot->delete();

        return redirect(route('serciciosTecnologicos'));
    }

    public function serviciotEliminarRelacion(Request $request, $id)
    {
        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');

        // Eliminar el registro en la tabla serviciostec_usuarios
        serviciotecnologico_usuario::where('serviciostec_id', $id)
            ->where('usuario_id', $userID)
            ->delete();

        // Obtener el servicio tecnológico
        $serviciot = serviciotecnologico::find($id);

        // Obtener la lista de participantes actuales
        $participantesActuales = explode(',', $serviciot->participantes);

        // Eliminar al usuario del array si existe
        $key = array_search($userID, $participantesActuales);
        if ($key !== false) {
            unset($participantesActuales[$key]);
        }

        // Unir nuevamente la lista de participantes en un formato de cadena
        $participantesActualizados = implode(',', $participantesActuales);

        // Actualizar el campo "participantes" en el servicio tecnológico
        $serviciot->participantes = $participantesActualizados;
        $serviciot->save();

        return redirect(route('serciciosTecnologicos'));
    }


/////////////////////////////Fin de las funciones para el modulo de Servicios Tecnologicos///////////////////

///////////////////////////////////////////Funciones para el modulo de Reuniones/////////////////////////////


//funcion para Visualizar la vista reuniones
public function reuniones(request $request)
{

    $dbController = new dbcontroller();

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // Obtener el nombre completo del usuario autenticado
    $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
    // Obtener todos los clientes
    $Cliente = Cliente::where('status',1)->get();
    // Obtener el valor de sesionespecial de usuarios
    $sesionEspecial = $user->sesionespecial;

    // Obtener todos los usuarios menos el que esta autenticado
    $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();

    // Obtener otras reuniones relacionadas con el usuario y la fecha del periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;

    $mesInicioBimestre = $this->getStartMonthOfBimester($fechabimestre2->bimestre);
    $mesFinBimestre = $this->getEndMonthOfBimester($fechabimestre2->bimestre);

    $reuniones = reunion::where('nombre_persona', $user->usuario)
    ->whereYear('fecha_reunion', $añoActual)
    ->where(function ($query) use ($bimestreActual) {
        $query->whereMonth('fecha_reunion', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fecha_reunion', $this->getEndMonthOfBimester($bimestreActual));
    })->get();

    // Obtener las solicitudes relacionadas a través de la tabla intermedia reunion_usuarios
    $reunionesRelacionadas = reunion::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
        $query->where('usuario_id', $userID);
    })->whereYear('fecha_reunion', $añoActual)
      ->where(function ($query) use ($bimestreActual) {
        $query->whereMonth('fecha_reunion', $this->getStartMonthOfBimester($bimestreActual))
          ->orWhereMonth('fecha_reunion', $this->getEndMonthOfBimester($bimestreActual));})->get();

    //Periodo consultado
    $periodoConsultado = $bimestreActual . " del " . $añoActual;


    // Crear un arreglo de datos
    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'nombreCompleto' => $nombreCompleto,
        'Cliente' => $Cliente,
        'usuarios' => $usuarios,
        'sesionEspecial' => $sesionEspecial,
        'reuniones' => $reuniones,
        'reunionesRelacionadas' => $reunionesRelacionadas,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'periodoConsultado' => $periodoConsultado,
        'fechabimestreP' => $fechabimestreP,
        'userID' => $userID,
        'categoriesN1' => $dbController->getCategoriesList()

    ];


return view('SIRB/reunion', $data);
}


//funcion para nueva reunion
public function nuevareunion(request $request)
{
    /*
        Debido a implementaciones del nuevo componente y no realizar alteraciones
        en la base de datos, se obtiene el nombre para mantener la forma de registro
        del cliente y evitar inconsistencia de datos
    */
    $nombreCliente = Cliente::select(
        DB::raw("
        CONCAT(cliente.nivel1,' | ' ,cliente.nivel2, ' | ' ,cliente.nivel3) as clienteNombre
        ")
    )
    ->where([
        ['cliente.id','=',$request->input('D_perteneciente')]
    ])
    ->first()->clienteNombre;

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);


    $reunion = new reunion;
    $reunion->fecha_reunion = $request->fecha;
    $reunion->tipo_reunion = $request->tipo_reunion;
    // Verificar si se seleccionó "Otro" en tipo_reunion
    if ($request->tipo_reunion === 'Otro') {
        $reunion->tipo_reunion = $request->otro_tipo;
    } else {
        $reunion->tipo_reunion = $request->tipo_reunion;
    }
    $reunion->nombre_persona = $request->nombre_persona;
    $reunion->D_vinculacion = $nombreCliente;
    $reunion->descripcion_R = $request->descripcion;
    $reunion->lugar_reunion = $request->lugar_reunion;
    $reunion->encargado = $request->encargadoservicio;
    $reunion->area = $request->areaActividad;
    $reunion->participantes = $request->usuarios_seleccionados;
    $reunion->save();

    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva reunion
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $reunionUsuario = new reunion_usuario([
                    'reunion_id' => $reunion->id,
                    'usuario_id' => $usuarioId,
                ]);
                $reunionUsuario->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $detailsReunion = [
                    'servicio' => $reunion, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Reunión'
                ];

                Mail::to($correoParticipante)->send(new notificationReunion($detailsReunion));
            }
        }
    }


    return redirect(route('reuniones', $data));
}

//funcion para editar
public function reunionesEditar(request $request, $id)
{

    $reunion = reunion::find($id);
    $reunion->fecha_reunion = $request->fecha;
    $reunion->tipo_reunion = $request->tipo_reunion;
    // Verificar si se seleccionó "Otro" en tipo_reunion
    if ($request->tipo_reunion === 'Otroedit') {
        $reunion->tipo_reunion = $request->otro_tipo;
    } else {
        $reunion->tipo_reunion = $request->tipo_reunion;
    }
    $reunion->nombre_persona = $request->nombre_persona;
    $reunion->encargado = $request->encargadoservicio;
    $reunion->descripcion_R = $request->descripcion;
    $reunion->lugar_reunion = $request->lugar_reunion;
    $reunion->participantes = $request->usuarios_seleccionados;

    //solo se actualiza el cliente en caso de que se haya seleccionado uno nuevo
    if(isset($request->D_perteneciente)){
        $reunion->D_vinculacion = Cliente::select(
            DB::raw("
            CONCAT(cliente.nivel1,' | ' ,cliente.nivel2, ' | ' ,cliente.nivel3) as clienteNombre
            ")
        )
        ->where([
            ['cliente.id','=',$request->input('D_perteneciente')]
        ])
        ->first()->clienteNombre;
    }

    $reunion->save();

    // Obtener la lista de participantes actuales asociados al registro
    $participantesActuales = $reunion->participantes;
    if (strpos($participantesActuales, ',') !== false) {
        $participantesActualesArray = explode(',', $participantesActuales);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $participantesActualesArray = [$participantesActuales];
    }

    // Obtener la lista de participantes seleccionados del formulario
    $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
    if (strpos($usuariosSeleccionados, ',') !== false) {
        $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosSeleccionadosArray = [$usuariosSeleccionados];
    }

    // Obtener la lista de todos los participantes previamente asociados a este registro
    $participantesActualesEnBD = reunion_usuario::where('reunion_id', $reunion->id)->pluck('usuario_id')->toArray();
    // Obtener la lista de participantes seleccionados del formulario
    $usuariosSeleccionadosArray = explode(',', $request->input('usuarios_seleccionadosedit'));
    // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
    $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);
    // Eliminar a los participantes no seleccionados
    reunion_usuario::where('reunion_id', $reunion->id)
        ->whereIn('usuario_id', $participantesParaEliminar)
        ->delete();


    // Agregar nuevos participantes o mantener los existentes
    foreach ($participantesActualesArray as $usuarioId) {
        $ReunionUsuario = new reunion_usuario([
            'reunion_id' => $reunion->id,
            'usuario_id' => $usuarioId,
        ]);
        $ReunionUsuario->save();
    }




    // Obtener la lista de participantes seleccionados del formulario
    $usuariosBDMail = $request->usuarios_seleccionadosMail;
    if (strpos($usuariosBDMail, ',') !== false) {
        $usuariosBDMailArray = explode(',', $usuariosBDMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosBDMailArray = [$usuariosBDMail];
    }

    $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
    if (strpos($usuariosSeleccionadosMail, ',') !== false) {
        $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
    }

    $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
    $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

    // Envia correos de eliminación a los participantes a eliminar
    $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

    foreach ($usuariosParaEliminar as $usuarioElim) {
        $correoParticipanteElim = $usuarioElim->correo;
        $details = [
            'servicio' => $reunion,
            'participante' => $usuarioElim,
            'evento' => 'Reunión'
        ];

        Mail::to($correoParticipanteElim)->send(new notificationElimReunion($details));
    }

    // Envia correos de edición a los nuevos participantes
    $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

    foreach ($usuariosParaAgregar as $usuario) {
        $correoParticipante = $usuario->correo;
        $details = [
            'servicio' => $reunion,
            'participante' => $usuario,
            'evento' => 'Reunión'
        ];

        Mail::to($correoParticipante)->send(new notificationReunion($details));
    }


    return redirect(route('reuniones'));
}

//funcion para eliminar
public function reunionesEliminar($id)
{
        $reunion = reunion::find($id);

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $reunion->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $detailsEliminar = [
                'servicio' => $reunion, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Reunión'
            ];

            Mail::to($correoParticipante)->send(new notificationElimReunion($detailsEliminar));
        }
    }

    // Eliminar registros relacionados en solicitud_usuarios
    $reunion->usuariosQuePuedenVisualizar()->delete();

    // Eliminar la solicitud principal
    $reunion->delete();

    return redirect(route('reuniones'));
}

public function reunionesEliminarRelacion(Request $request, $id)
{
    $userID = $request->session()->get('LoginId'); // Obtener el ID del usuario autenticado

    // Eliminar el registro en la tabla solicitud_usuarios
    reunion_usuario::where('reunion_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

            // Obtener el servicio tecnológico
    $reunion = reunion::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $reunion->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $reunion->participantes = $participantesActualizados;
    $reunion->save();

    return redirect(route('reuniones'));
}

///////////////////////////////////Terminan las funciones del modulo de reuniones/////////////////////////////

///////////////////////////////////////////Funciones para el modulo de comites////////////////////////////////

public function comites(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // Obtener el nombre completo del usuario autenticado
    $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
    // obtener todos los comites de la tabla comitesAdmin
    $comitesAdmin = comitesAdmin::Orderby('nombre','asc')->get();
    // Obtener el valor de sesionespecial de usuarios
    $sesionEspecial = $user->sesionespecial;
    // Obtener todos los usuarios menos el que esta autenticado
    $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
    // Obtener todos los clientes
    $Cliente = Cliente::where('status',1)->get();

    // Obtener otros comites relacionadas con el usuario y la fecha del periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

    $comites = comite::where('nombre_persona', $user->usuario)
    ->whereYear('fechas', $añoActual)
    ->where(function ($query) use ($bimestreActual) {
        $query->whereMonth('fechas', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fechas', $this->getEndMonthOfBimester($bimestreActual));
    })->get();

    // Obtener las solicitudes relacionadas a través de la tabla intermedia reunion_usuarios
    $comitesRelacionadas = comite::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
        $query->where('usuario_id', $userID);
    })->whereYear('fechas', $añoActual)
    ->where(function ($query) use ($bimestreActual) {
        $query->whereMonth('fechas', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fechas', $this->getEndMonthOfBimester($bimestreActual));
    })->get();

    //Periodo consultado
    $periodoConsultado = $bimestreActual . " del " . $añoActual;
    $dbController = new dbcontroller();


    // Crear un arreglo de datos
    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'nombreCompleto' => $nombreCompleto,
        'Cliente' => $Cliente,
        'usuarios' => $usuarios,
        'comitesAdmin' => $comitesAdmin,
        'sesionEspecial' => $sesionEspecial,
        'comites' => $comites,
        'comitesRelacionadas' => $comitesRelacionadas,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'periodoConsultado' => $periodoConsultado,
        'fechabimestreP' => $fechabimestreP,
        'userID' => $userID,
        'categoriesN1' => $dbController->getCategoriesList()

        ];


return view('SIRB/comite', $data);
}


//funcion para nuevo comite
public function nuevocomite(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);

    $comite = new comite;
    $comite->fechas = $request->fecha;
    $comite->nombre_comite = $request->nombre_comite;
    $comite->nombre_persona = $request->nombre_persona;
    $comite->encargado = $request->encargadoservicio;
    $comite->dependencia_V = $request->client_full_name;
    $comite->cargo_comite = $request->cargo_comite;
    $comite->A_desarrolladas = $request->A_desarrolladas;
    $comite->area = $request->areaActividad;
    $comite->participantes = $request->usuarios_seleccionados;
    $comite->save();

    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva comite
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $comiteUsuario = new comite_usuario([
                    'comite_id' => $comite->id,
                    'usuario_id' => $usuarioId,
                ]);
                $comiteUsuario->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $details = [
                    'servicio' => $comite, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Comité'
                ];

                Mail::to($correoParticipante)->send(new notificationComite($details));
            }
        }
    }


    return redirect(route('comites', $data));
}


//funcion para editar
public function comitesEditar(request $request, $id)
{

    $comite = comite::find($id);
    $comite->fechas = $request->fecha;
    $comite->nombre_comite = $request->nombre_comite;
    $comite->nombre_persona = $request->nombre_persona;
    $comite->encargado = $request->encargadoservicio;
    $comite->cargo_comite = $request->cargo_comite;
    $comite->A_desarrolladas = $request->A_desarrolladas;
    $comite->participantes = $request->usuarios_seleccionados;
        //solo se actualiza el cliente en caso de que se haya seleccionado uno nuevo
    if(isset($request->dependencia_V)){
        $comite->dependencia_V = Cliente::select(
            DB::raw("
            CONCAT(cliente.nivel1,' | ' ,cliente.nivel2, ' | ' ,cliente.nivel3) as clienteNombre
            ")
        )
        ->where([
            ['cliente.id','=',$request->input('dependencia_V')]
        ])
        ->first()->clienteNombre;
    }
    $comite->save();

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $comite->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
        if (strpos($usuariosSeleccionados, ',') !== false) {
            $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosArray = [$usuariosSeleccionados];
        }

        // Obtener la lista de todos los participantes previamente asociados a este registro
        $participantesActualesEnBD = comite_usuario::where('comite_id', $comite->id)->pluck('usuario_id')->toArray();
        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionadosArray = explode(',', $request->input('usuarios_seleccionadosedit'));
        // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
        $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);
        // Eliminar a los participantes no seleccionados
        comite_usuario::where('comite_id', $comite->id)
            ->whereIn('usuario_id', $participantesParaEliminar)
            ->delete();


        // Agregar nuevos participantes o mantener los existentes
        foreach ($participantesActualesArray as $usuarioId) {
            $serviciotUsuario = new comite_usuario([
                'comite_id' => $comite->id,
                'usuario_id' => $usuarioId,
            ]);
            $serviciotUsuario->save();
        }


        // Obtener la lista de participantes seleccionados del formulario
        $usuariosBDMail = $request->usuarios_seleccionadosMail;
        if (strpos($usuariosBDMail, ',') !== false) {
            $usuariosBDMailArray = explode(',', $usuariosBDMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosBDMailArray = [$usuariosBDMail];
        }

        $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
        if (strpos($usuariosSeleccionadosMail, ',') !== false) {
            $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
        }

        $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
        $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

        // Envia correos de eliminación a los participantes a eliminar
        $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

        foreach ($usuariosParaEliminar as $usuarioElim) {
            $correoParticipanteElim = $usuarioElim->correo;
            $details = [
                'servicio' => $comite,
                'participante' => $usuarioElim,
                'evento' => 'Comité'
            ];

            Mail::to($correoParticipanteElim)->send(new notificationElimComite($details));
        }

        // Envia correos de edición a los nuevos participantes
        $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

        foreach ($usuariosParaAgregar as $usuario) {
            $correoParticipante = $usuario->correo;
            $details = [
                'servicio' => $comite,
                'participante' => $usuario,
                'evento' => 'Comité'
            ];

            Mail::to($correoParticipante)->send(new notificationComite($details));
        }



    return redirect(route('comites'));
}


//funcion para eliminar
public function eliminarcomites($id)
{

    // Eliminar la solicitud principal
    $comite = comite::find($id);

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $comite->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $details = [
                'servicio' => $comite, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Comité'
            ];

            Mail::to($correoParticipante)->send(new notificationElimComite($details));
        }
    }

    // Eliminar registros relacionados en comite_usuarios
    $comite->usuariosQuePuedenVisualizar()->delete();
    $comite->delete();

    return redirect(route('comites'));

}


public function comitesEliminarRelacion(Request $request, $id)
{
    $userID = $request->session()->get('LoginId'); // Obtener el ID del usuario autenticado

    // Eliminar el registro en la tabla solicitud_usuarios
    comite_usuario::where('comite_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

    // Obtener el servicio tecnológico
    $comite = comite::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $comite->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $comite->participantes = $participantesActualizados;
    $comite->save();

    return redirect(route('comites'));
}

/////////////////////////////////Terminan las funciones del modulo de comites/////////////////////////////////


///////////////////////////////////////////Funciones para el modulo de solicitudes////////////////////////////

    //funcion para Vusualizar en la vista solicitudes
    public function solicitudes(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el nombre completo del usuario autenticado
        $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
        // Obtener todos los clientes
        $Cliente = Cliente::where('status',1)->get();

        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;
        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        $solicitudes = solicitudes::where('nombre_persona', $user->usuario)
        ->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        // Obtener las solicitudes relacionadas a través de la tabla intermedia solicitudes_usuarios
        $solicitudesRelacionadas = solicitudes::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fecha', $añoActual)
          ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
              ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
            })->get();

    //Periodo consultado
    $periodoConsultado = $bimestreActual . " del " . $añoActual;

    $dbController = new dbcontroller();


        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'nombreCompleto' => $nombreCompleto,
            'solicitudes' => $solicitudes,
            'usuarios' => $usuarios,
            'sesionEspecial' => $sesionEspecial,
            'Cliente' => $Cliente,
            'solicitudesRelacionadas' => $solicitudesRelacionadas,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            'periodoConsultado' => $periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'userID' => $userID,
            'categoriesN1' => $dbController->getCategoriesList()
        ];


    return view('SIRB/solicitudes', $data);
}

//funcion para nueva solicitud
public function nuevasolicitud(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);
    $usuarioes = User::all();
    foreach ($usuarioes as $use) {
        if ($use->usuario == $request->nombre_persona) {
            $nombrereal = $use->Nombre.' '.$use->Apellido_Paterno;
        }
    }
    // Crear la solicitud principal
    $solicitud = new solicitudes;


    // Resto de campos de solicitud
    $solicitud->fecha = $request->fecha;
    $solicitud->tipo_solicitud = $request->tipo_solicitud;
    $solicitud->titulo = $request->titulosol;
    $solicitud->nombre_persona = $request->nombre_persona;
    $solicitud->encargado = $request->encargadoservicio;
    $solicitud->cargo_actual = $request->cargo_actual;
    //se inserta el nombre del cliente, directo del componente
    $solicitud->D_perteneciente = $request->client_full_name;
    $solicitud->descripcion = $request->descripcion;
    $solicitud->tiempo_dedicado = $request->tiempo_dedicado;
    $solicitud->producto_final = $request->producto_final;
    $solicitud->actividad = $request->actividad;
    $solicitud->area = $request->areaActividad;
    $solicitud->participantes = $request->usuarios_seleccionados;
    $solicitud->save();
    $solicitud->username = $nombrereal;
    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva solicitud
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $solicitudUsuario = new solicitud_usuario([
                    'solicitud_id' => $solicitud->id,
                    'usuario_id' => $usuarioId,
                ]);
                $solicitudUsuario->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $details = [
                    'servicio' => $solicitud, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Solicitud'
                ];

                Mail::to($correoParticipante)->send(new notificationSolicitudes($details));
            }
        }
    }

    return redirect(route('solicitudes', $data));
}

//funcion para editar
public function solicitudesEditar(request $request, $id)
{

    $solicitud = solicitudes::find($id);
    $solicitud->fecha = $request->fecha;
    $solicitud->tipo_solicitud = $request->tipo_solicitud;
    $solicitud->titulo = $request->titulosol;
    $solicitud->nombre_persona = $request->nombre_persona;
    $solicitud->encargado = $request->encargadoservicio;
    $solicitud->cargo_actual = $request->cargo_actual;
    $solicitud->descripcion = $request->descripcion;
    $solicitud->tiempo_dedicado = $request->tiempo_dedicado;
    $solicitud->producto_final = $request->producto_final;
    $solicitud->participantes = $request->usuarios_seleccionados;
    //solo se actualiza el cliente en caso de que se haya seleccionado uno nuevo
    if(isset($request->D_perteneciente)){
        $solicitud->D_perteneciente = Cliente::select(
            DB::raw("
            CONCAT(cliente.nivel1,' | ' ,cliente.nivel2, ' | ' ,cliente.nivel3) as clienteNombre
            ")
        )
        ->where([
            ['cliente.id','=',$request->input('D_perteneciente')]
        ])
        ->first()->clienteNombre;
    }
    $solicitud->save();


    // Obtener la lista de participantes actuales asociados al registro
    $participantesActuales = $solicitud->participantes;
    if (strpos($participantesActuales, ',') !== false) {
        $participantesActualesArray = explode(',', $participantesActuales);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $participantesActualesArray = [$participantesActuales];
    }

    // Obtener la lista de participantes seleccionados del formulario
    $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
    if (strpos($usuariosSeleccionados, ',') !== false) {
        $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosSeleccionadosArray = [$usuariosSeleccionados];
    }

    // Obtener la lista de todos los participantes previamente asociados a este registro
    $participantesActualesEnBD = solicitud_usuario::where('solicitud_id', $solicitud->id)->pluck('usuario_id')->toArray();
    // Obtener la lista de participantes seleccionados del formulario
    $usuariosSeleccionadosArray = explode(',', $request->input('usuarios_seleccionadosedit'));
    // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
    $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);
    // Eliminar a los participantes no seleccionados
    solicitud_usuario::where('solicitud_id', $solicitud->id)
        ->whereIn('usuario_id', $participantesParaEliminar)
        ->delete();


    // Agregar nuevos participantes o mantener los existentes
    foreach ($participantesActualesArray as $usuarioId) {
        $serviciotUsuario = new solicitud_usuario([
            'solicitud_id' => $solicitud->id,
            'usuario_id' => $usuarioId,
        ]);
        $serviciotUsuario->save();
    }

    // Obtener la lista de participantes seleccionados del formulario
    $usuariosBDMail = $request->usuarios_seleccionadosMail;
    if (strpos($usuariosBDMail, ',') !== false) {
        $usuariosBDMailArray = explode(',', $usuariosBDMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosBDMailArray = [$usuariosBDMail];
    }

    $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
    if (strpos($usuariosSeleccionadosMail, ',') !== false) {
        $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
    }

    $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
    $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

    // Envia correos de eliminación a los participantes a eliminar
    $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

    foreach ($usuariosParaEliminar as $usuarioElim) {
        $correoParticipanteElim = $usuarioElim->correo;
        $details = [
            'servicio' => $solicitud,
            'participante' => $usuarioElim,
            'evento' => 'Solicitud'
        ];

        Mail::to($correoParticipanteElim)->send(new notificationElimSolicitudes($details));
    }

    // Envia correos de edición a los nuevos participantes
    $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

    foreach ($usuariosParaAgregar as $usuario) {
        $correoParticipante = $usuario->correo;
        $details = [
            'servicio' => $solicitud,
            'participante' => $usuario,
            'evento' => 'Solicitud'
        ];

        Mail::to($correoParticipante)->send(new notificationSolicitudes($details));
    }

    return redirect(route('solicitudes'));
}

//funcion para eliminar
public function solicitudesEliminar($id)
{
    $usuarioes = User::all();
    $solicitud = solicitudes::find($id);
        
        foreach ($usuarioes as $use) {
            if ($use->usuario == $solicitud->nombre_persona) {
            $nombrereal = $use->Nombre.' '.$use->Apellido_Paterno;
            }
        }

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $solicitud->participantes;
        $solicitud->username = $nombrereal;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $detailsEliminar = [
                'servicio' => $solicitud, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Solicitud'
            ];

            Mail::to($correoParticipante)->send(new notificationElimSolicitudes($detailsEliminar));
        }
    }

    // Eliminar registros relacionados en solicitud_usuarios
    $solicitud->usuariosQuePuedenVisualizar()->delete();

    // Eliminar la solicitud principal
    $solicitud->delete();

    return redirect(route('solicitudes'));
}

public function solicitudesEliminarRelacion(Request $request, $id)
{
    $userID = $request->session()->get('LoginId'); // Obtener el ID del usuario autenticado

    // Eliminar el registro en la tabla solicitud_usuarios
    solicitud_usuario::where('solicitud_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

    // Obtener el servicio tecnológico
    $solicitud = solicitudes::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $solicitud->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $solicitud->participantes = $participantesActualizados;
    $solicitud->save();

    return redirect(route('solicitudes'));
}


/////////////////////////////////Terminan las funciones del modulo de solicitudes/////////////////////////////


////////////////////////////Inician las para el modulo funciones para el modulo de Difucion y Docencia///////////////////////////////////

////////////Funciones para el modulo de revistas////////////

    //funcion para Visualizar en la vista revistas
    public function revistas(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el nombre completo del usuario autenticado
        $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
        // Obtener todos los clientes
        $Cliente = Cliente::where('status',1)->get();

        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;
        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        $revistas = revista::where('nombre_persona', $user->usuario)
        ->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        // Obtener las revistas relacionadas a través de la tabla intermedia
        $revistaRelacionados = revista::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fecha', $añoActual)
          ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
              ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));})->get();

        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();

    //Periodo consultado
    $periodoConsultado = $bimestreActual . " del " . $añoActual;

        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'nombreCompleto' => $nombreCompleto,
            'usuarios' => $usuarios,
            'Cliente' => $Cliente,
            'sesionEspecial' => $sesionEspecial,
            'revistas' => $revistas,
            'revistaRelacionados' => $revistaRelacionados,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            'periodoConsultado' => $periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'userID' => $userID
        ];


    return view('SIRB/difucionDocencia/revistas', $data);
}


//funcion para nueva revista
public function nuevarevista(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);

    // Crear el insert de revistas
    $revista = new revista;

    // Resto de campos de curso recibido
    $revista->titulo = $request->tituloarticulo;
    $revista->editorial = $request->editorial;
    $revista->tipo_revista = $request->tiporevista;
    $revista->tipo_articulo = $request->tipoarticulo;
    $revista->nombre_revista = $request->nombrerevista;
    $revista->numero_revista = $request->numerorevista;
    $revista->ciudad_pais = $request->ciudadpais;
    $revista->fecha = $request->fecha;
    $revista->nombre_persona = $request->nombre_persona;
    $revista->encargado = $request->encargadoservicio;
    $revista->area = $request->areaActividad;
    $revista->participantes = $request->usuarios_seleccionados;
    $revista->save();


    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva solicitud
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $revistaR = new revista_usuario([
                    'revista_id' => $revista->id,
                    'usuario_id' => $usuarioId,
                ]);
                $revistaR->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $details = [
                    'servicio' => $revista, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Revista'
                ];

                Mail::to($correoParticipante)->send(new notificationRevistas($details));
            }
        }
    }

    return redirect(route('revistas', $data));
}



//funcion para editar
public function revistaEditar(request $request, $id)
{

    $revista = revista::find($id);
    $revista->titulo = $request->tituloarticulo;
    $revista->editorial = $request->editorial;
    $revista->tipo_revista = $request->tiporevista;
    $revista->tipo_articulo = $request->tipoarticulo;
    $revista->nombre_revista = $request->nombrerevista;
    $revista->numero_revista = $request->numerorevista;
    $revista->ciudad_pais = $request->ciudadpais;
    $revista->fecha = $request->fecha;
    $revista->nombre_persona = $request->nombre_persona;
    $revista->encargado = $request->encargadoservicio;
    $revista->participantes = $request->usuarios_seleccionados;
    $revista->save();

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $revista->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
        if (strpos($usuariosSeleccionados, ',') !== false) {
            $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosArray = [$usuariosSeleccionados];
        }

        // Obtener la lista de todos los participantes previamente asociados a este registro
        $participantesActualesEnBD = revista_usuario::where('revista_id', $revista->id)->pluck('usuario_id')->toArray();
        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionadosArray = explode(',', $request->input('usuarios_seleccionadosedit'));
        // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
        $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);
        // Eliminar a los participantes no seleccionados
        revista_usuario::where('revista_id', $revista->id)
            ->whereIn('usuario_id', $participantesParaEliminar)
            ->delete();


        // Agregar nuevos participantes o mantener los existentes
        foreach ($participantesActualesArray as $usuarioId) {
            $serviciotUsuario = new revista_usuario([
                'revista_id' => $revista->id,
                'usuario_id' => $usuarioId,
            ]);
            $serviciotUsuario->save();
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosBDMail = $request->usuarios_seleccionadosMail;
        if (strpos($usuariosBDMail, ',') !== false) {
            $usuariosBDMailArray = explode(',', $usuariosBDMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosBDMailArray = [$usuariosBDMail];
        }

        $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
        if (strpos($usuariosSeleccionadosMail, ',') !== false) {
            $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
        }

        $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
        $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

        // Envia correos de eliminación a los participantes a eliminar
        $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

        foreach ($usuariosParaEliminar as $usuarioElim) {
            $correoParticipanteElim = $usuarioElim->correo;
            $details = [
                'servicio' => $revista,
                'participante' => $usuarioElim,
                'evento' => 'Revista'
            ];

            Mail::to($correoParticipanteElim)->send(new notificationElimRevistas($details));
        }

        // Envia correos de edición a los nuevos participantes
        $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

        foreach ($usuariosParaAgregar as $usuario) {
            $correoParticipante = $usuario->correo;
            $details = [
                'servicio' => $revista,
                'participante' => $usuario,
                'evento' => 'Revista'
            ];

            Mail::to($correoParticipante)->send(new notificationRevistas($details));
        }

    return redirect(route('revistas'));
}



//funcion para eliminar
public function revistaEliminar($id)
{
    $revista = revista::find($id);

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $revista->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $detailsEliminar = [
                'servicio' => $revista, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Revista'
            ];

            Mail::to($correoParticipante)->send(new notificationElimRevistas($detailsEliminar));
        }
    }

    // Eliminar registros relacionados en revista_usuarios
    $revista->usuariosQuePuedenVisualizar()->delete();

    // Eliminar la revista principal
    $revista->delete();

    return redirect(route('revistas'));
}



public function revistaEliminarR(Request $request, $id)
{
    $userID = $request->session()->get('LoginId'); // Obtener el ID del usuario autenticado

    // Eliminar el registro en la tabla revista_usuarios
    revista_usuario::where('revista_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

    // Obtener el servicio tecnológico
    $revista = revista::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $revista->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $revista->participantes = $participantesActualizados;
    $revista->save();

    return redirect(route('revistas'));
}

////////////Fin de las funciones para el modulo de revistas////////////

////////////Funciones para el modulo de memorias////////////

    //funcion para Vusualizar en la vista memorias
    public function memorias(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el nombre completo del usuario autenticado
        $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
        // Obtener todos los clientes
        $Cliente = Cliente::where('status',1)->get();

        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;
        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        $memorias = memoria::where('nombre_persona', $user->usuario)
        ->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        // Obtener las revistas relacionadas a través de la tabla intermedia
        $memoriaRelacionados = memoria::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fecha', $añoActual)
          ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
              ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));})->get();

    //Periodo consultado
    $periodoConsultado = $bimestreActual . " del " . $añoActual;

        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'nombreCompleto' => $nombreCompleto,
            'usuarios' => $usuarios,
            'Cliente' => $Cliente,
            'sesionEspecial' => $sesionEspecial,
            'memorias' => $memorias,
            'memoriaRelacionados' => $memoriaRelacionados,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            'periodoConsultado' => $periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'userID' => $userID
        ];


    return view('SIRB/difucionDocencia/memorias', $data);
}


//funcion para nueva memorias
public function nuevamemorias(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);

    // Crear el insert de cursos
    $memoria = new memoria;

    // Resto de campos de memorias
    $memoria->titulo = $request->tituloarticulo;
    $memoria->organizador = $request->organizador;
    $memoria->tipo_memoria = $request->tipomemoria;
    $memoria->nombre_seminario = $request->nombreseminario;
    $memoria->ciudad_pais = $request->ciudadpais;
    $memoria->fecha = $request->fecha;
    $memoria->nombre_persona = $request->nombre_persona;
    $memoria->encargado = $request->encargadoservicio;
    $memoria->area = $request->areaActividad;
    $memoria->participantes = $request->usuarios_seleccionados;
    $memoria->save();


    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva solicitud
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $memoriaR = new memoria_usuario([
                    'memoria_id' => $memoria->id,
                    'usuario_id' => $usuarioId,
                ]);
                $memoriaR->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $details = [
                    'servicio' => $memoria, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Memoria'
                ];

                Mail::to($correoParticipante)->send(new notificationMemorias($details));
            }
        }
    }

    return redirect(route('memorias', $data));
}



//funcion para editar
public function memoriasEditar(request $request, $id)
{

    $memoria = memoria::find($id);
    $memoria->titulo = $request->tituloarticulo;
    $memoria->organizador = $request->organizador;
    $memoria->tipo_memoria = $request->tipomemoria;
    $memoria->nombre_seminario = $request->nombreseminario;
    $memoria->ciudad_pais = $request->ciudadpais;
    $memoria->fecha = $request->fecha;
    $memoria->nombre_persona = $request->nombre_persona;
    $memoria->encargado = $request->encargadoservicio;
    $memoria->participantes = $request->usuarios_seleccionados;
    $memoria->save();

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $memoria->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
        if (strpos($usuariosSeleccionados, ',') !== false) {
            $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosArray = [$usuariosSeleccionados];
        }

        // Obtener la lista de todos los participantes previamente asociados a este registro
        $participantesActualesEnBD = memoria_usuario::where('memoria_id', $memoria->id)->pluck('usuario_id')->toArray();
        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionadosArray = explode(',', $request->input('usuarios_seleccionadosedit'));
        // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
        $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);
        // Eliminar a los participantes no seleccionados
        memoria_usuario::where('memoria_id', $memoria->id)
            ->whereIn('usuario_id', $participantesParaEliminar)
            ->delete();


        // Agregar nuevos participantes o mantener los existentes
        foreach ($participantesActualesArray as $usuarioId) {
            $serviciotUsuario = new memoria_usuario([
                'memoria_id' => $memoria->id,
                'usuario_id' => $usuarioId,
            ]);
            $serviciotUsuario->save();
        }

    // Obtener la lista de participantes seleccionados del formulario
    $usuariosBDMail = $request->usuarios_seleccionadosMail;
    if (strpos($usuariosBDMail, ',') !== false) {
        $usuariosBDMailArray = explode(',', $usuariosBDMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosBDMailArray = [$usuariosBDMail];
    }

    $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
    if (strpos($usuariosSeleccionadosMail, ',') !== false) {
        $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
    }

    $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
    $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

    // Envia correos de eliminación a los participantes a eliminar
    $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

    foreach ($usuariosParaEliminar as $usuarioElim) {
        $correoParticipanteElim = $usuarioElim->correo;
        $details = [
            'servicio' => $memoria,
            'participante' => $usuarioElim,
            'evento' => 'Memoria'
        ];

        Mail::to($correoParticipanteElim)->send(new notificationElimMemorias($details));
    }

    // Envia correos de edición a los nuevos participantes
    $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

    foreach ($usuariosParaAgregar as $usuario) {
        $correoParticipante = $usuario->correo;
        $details = [
            'servicio' => $memoria,
            'participante' => $usuario,
            'evento' => 'Memoria'
        ];

        Mail::to($correoParticipante)->send(new notificationMemorias($details));
    }

    return redirect(route('memorias'));
}



//funcion para eliminar
public function memoriasEliminar($id)
{
    $memoria = memoria::find($id);

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $memoria->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $detailsEliminar = [
                'servicio' => $memoria, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Memoria'
            ];

            Mail::to($correoParticipante)->send(new notificationElimMemorias($detailsEliminar));
        }
    }

    // Eliminar registros relacionados en memoria_usuarios
    $memoria->usuariosQuePuedenVisualizar()->delete();

    // Eliminar la revista principal
    $memoria->delete();

    return redirect(route('memorias'));
}



public function memoriasEliminarR(Request $request, $id)
{
    $userID = $request->session()->get('LoginId'); // Obtener el ID del usuario autenticado

    // Eliminar el registro en la tabla memoria_usuarios
    memoria_usuario::where('memoria_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

    // Obtener el servicio tecnológico
    $memoria = memoria::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $memoria->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $memoria->participantes = $participantesActualizados;
    $memoria->save();

    return redirect(route('memorias'));
}

////////////Fin de las funciones para el modulo de memorias////////////

////////////Funciones para el modulo de boletines////////////


    //funcion para Visualizar en la vista boletines
    public function boletines(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
        // Obtener todos los clientes
        $Cliente = Cliente::where('status',1)->get();

        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        
        $bimestreActual = $fechabimestre->bimestre;
        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();
        $añoActual = $fechabimestre->año;
        $startDateInicio = $this->getStartMonthOfBimester($bimestreActual);
        $startDateFin = $this->getEndMonthOfBimester($bimestreActual);

        $curpUsuario = $user->curp;
        $boletines = DB::select("
        SELECT
            usuarios.curp,
            usuarios.idarea,
            imt_bol_boletin.Anio,
            imt_bol_boletin.Titulo AS BoletinTitulo,
            imt_bol_articulo.Titulo AS ArticuloTitulo,
            imt_bol_boletin.NoBoletin,
            imt_bol_articulo.NoArticulo,
            imt_gen_coordinacion.Nombre,
            imt_bol_autorarticulo.ID_BOL_Articulo,
            imt_bol_autorarticulo.ID_GEN_Autor,
            imt_bol_autorarticulo.Jerarquia
        FROM usuarios
            JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
            JOIN siapimt25.imt_bol_autorarticulo ON imt_gen_autor.ID_GEN_Autor = imt_bol_autorarticulo.ID_GEN_Autor
            JOIN siapimt25.imt_bol_articulo ON imt_bol_autorarticulo.ID_BOL_Articulo = imt_bol_articulo.ID_BOL_Articulo
            JOIN siapimt25.imt_bol_boletin ON imt_bol_articulo.ID_BOL_Boletin = imt_bol_boletin.ID_BOL_Boletin
            JOIN siapimt25.imt_gen_coordinacion ON imt_bol_boletin.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
        WHERE usuarios.curp = ? AND (MONTH(imt_bol_boletin.Anio) = ? OR MONTH(imt_bol_boletin.Anio) = ?) AND YEAR(imt_bol_boletin.Anio) = ?
        ", 
        [$curpUsuario, $startDateInicio, $startDateFin, $añoActual]);



        //Periodo consultado
        $periodoConsultado = $bimestreActual . " del " . $añoActual;

        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'usuarios' => $usuarios,
            'sesionEspecial' => $sesionEspecial,
            'Cliente' => $Cliente,
            'periodoConsultado' => $periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'boletines' => $boletines,
            'userID' => $userID
        ];


    return view('SIRB/difucionDocencia/boletines', $data);
}


////////////Fin de las funciones para el modulo de boletines////////////

////////////Funciones para el modulo de documentos tecnicos////////////


    //funcion para Visualizar en la vista documentosT
    public function documentosT(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
        // Obtener todos los clientes
        $Cliente = Cliente::where('status',1)->get();

        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;
        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        $startDateInicio = $this->getStartMonthOfBimester($bimestreActual);
        $startDateFin = $this->getEndMonthOfBimester($bimestreActual);

        // Consultar la información deseada de documentos tecnicos
        $curpUsuario = $user->curp;

        $documentos = DB::select("
        SELECT
            usuarios.curp,
            imt_pub_publicacion.Anio,
            imt_pub_publicacion.Titulo,
            imt_pub_publicacion.NoPublicacion,
            imt_pub_publicacion.AreaInteres,
            imt_pub_tipopublicacion.Nombre,
            imt_pub_autorpublicacion.ID_PUB_Publicacion,
            imt_pub_autorpublicacion.ID_GEN_Autor,
            imt_pub_autorpublicacion.Jerarquia
        FROM usuarios
            JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
            JOIN siapimt25.imt_pub_autorpublicacion ON imt_gen_autor.ID_GEN_Autor = imt_pub_autorpublicacion.ID_GEN_Autor
            JOIN siapimt25.imt_pub_publicacion ON imt_pub_autorpublicacion.ID_PUB_Publicacion = imt_pub_publicacion.ID_PUB_Publicacion
            JOIN siapimt25.imt_pub_tipopublicacion ON imt_pub_publicacion.id_pub_tipoPublicacion = imt_pub_tipopublicacion.id_pub_tipoPublicacion
        WHERE
            usuarios.curp = ? AND (MONTH(imt_pub_publicacion.Anio) = ? OR MONTH(imt_pub_publicacion.Anio) = ?) AND YEAR(imt_pub_publicacion.Anio) = ?
    ", [$curpUsuario, $startDateInicio, $startDateFin, $añoActual]);




        //Periodo consultado
        $periodoConsultado = $bimestreActual . " del " . $añoActual;

        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'usuarios' => $usuarios,
            'sesionEspecial' => $sesionEspecial,
            'Cliente' => $Cliente,
            'periodoConsultado' => $periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'documentos' => $documentos,
            'userID' => $userID
        ];


    return view('SIRB/difucionDocencia/documentosT', $data);
}


////////////Fin de las funciones para el modulo de documentos tecnicos////////////

////////////Funciones para el modulo de ponencias y conferencias////////////

    //funcion para Vusualizar en la vista ponencias y conferencias
    public function ponenciasconferencias(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el nombre completo del usuario autenticado
        $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
        // Obtener todos los clientes
        $Cliente = Cliente::where('status',1)->get();

        // Obtener otros ponenciasconferencia relacionados con el usuario
        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;


        $ponenciasconferencias = ponenciasconferencia::where('nombre_persona', $user->usuario)
        ->whereYear('fecha_fin', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        $ponenciasconferenciasRelacionadas = ponenciasconferencia::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fecha_fin', $añoActual)->get();

    //Periodo consultado
    $periodoConsultado = $bimestreActual . " del " . $añoActual;

    $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'usuarios' => $usuarios,
            'Cliente' => $Cliente,
            'sesionEspecial' => $sesionEspecial,
            'ponenciasconferencias' => $ponenciasconferencias,
            'ponenciasconferenciasRelacionadas' => $ponenciasconferenciasRelacionadas,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            'periodoConsultado' => $periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'userID' => $userID,
            'nombreCompleto' => $nombreCompleto
        ];


    return view('SIRB/difucionDocencia/ponenciasconferencias', $data);
}


//funcion para nueva ponenciasconferencias
public function nuevaponenciasconferencias(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);

    // Crear el insert de ponenciasconferencias
    $ponenciasconferencia = new ponenciasconferencia;

    // Resto de campos de ponenciasconferencias
    $ponenciasconferencia->tipo_PC = $request->tipo;
    $ponenciasconferencia->entidad_O = $request->entidad_O;
    $ponenciasconferencia->titulo = $request->titulopoco;
    $ponenciasconferencia->fecha_inicio = $request->fechainicio;
    $ponenciasconferencia->fecha_fin = $request->fechafin;
    $ponenciasconferencia->tipo_participacion = $request->tipoparticipacion;
    $ponenciasconferencia->publicacion_PC = $request->publicacion;
    $ponenciasconferencia->fecha_part_ponente = $request->fechaponente;
    $ponenciasconferencia->nombre_evento = $request->nombreevento;
    $ponenciasconferencia->lugar_evento = $request->lugar;
    $ponenciasconferencia->nombre_persona = $request->nombre_persona;
    $ponenciasconferencia->encargado = $request->encargadoservicio;
    $ponenciasconferencia->area = $request->areaActividad;
    $ponenciasconferencia->participantes = $request->usuarios_seleccionados;

    $ponenciasconferencia->save();

    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva reunion
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $reunionUsuario = new ponenciaconferencia_usuario([
                    'ponenciaconferencia_id' => $ponenciasconferencia->id,
                    'usuario_id' => $usuarioId,
                ]);
                $reunionUsuario->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $detailsReunion = [
                    'servicio' => $ponenciasconferencia, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Ponencias y conferencias'
                ];

                Mail::to($correoParticipante)->send(new notificationponenciaconferencia($detailsReunion));
            }
        }
    }



    return redirect(route('ponenciasconferencias', $data));
}





//funcion para editar
public function ponenciasconferenciasEditar(request $request, $id)
{

    $ponenciasconferencia = ponenciasconferencia::find($id);
    $ponenciasconferencia->tipo_PC = $request->tipo;
    $ponenciasconferencia->entidad_O = $request->entidad_O;
    $ponenciasconferencia->titulo = $request->titulopoco;
    $ponenciasconferencia->fecha_inicio = $request->fechainicio;
    $ponenciasconferencia->fecha_fin = $request->fechafin;
    $ponenciasconferencia->tipo_participacion = $request->tipoparticipacion;
    $ponenciasconferencia->publicacion_PC = $request->publicacion;
    $ponenciasconferencia->fecha_part_ponente = $request->fechaponente;
    $ponenciasconferencia->nombre_evento = $request->nombreevento;
    $ponenciasconferencia->lugar_evento = $request->lugar;
    $ponenciasconferencia->nombre_persona = $request->nombre_persona;
    $ponenciasconferencia->encargado = $request->encargadoservicio;
    $ponenciasconferencia->participantes = $request->usuarios_seleccionados;
    $ponenciasconferencia->save();

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $ponenciasconferencia->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
        if (strpos($usuariosSeleccionados, ',') !== false) {
            $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosArray = [$usuariosSeleccionados];
        }

        // Obtener la lista de todos los participantes previamente asociados a este registro
        $participantesActualesEnBD = ponenciaconferencia_usuario::where('ponenciaconferencia_id', $ponenciasconferencia->id)->pluck('usuario_id')->toArray();
        // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
        $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);

        // Eliminar a los participantes no seleccionados
        ponenciaconferencia_usuario::where('ponenciaconferencia_id', $ponenciasconferencia->id)
            ->whereIn('usuario_id', $participantesParaEliminar)
            ->delete();

        // Agregar nuevos participantes o mantener los existentes
        foreach ($participantesActualesArray as $usuarioId) {
            $serviciotUsuario = new ponenciaconferencia_usuario([
                'ponenciaconferencia_id' => $ponenciasconferencia->id,
                'usuario_id' => $usuarioId,
            ]);
            $serviciotUsuario->save();
        }


        // Obtener la lista de participantes seleccionados del formulario
    $usuariosBDMail = $request->usuarios_seleccionadosMail;
    if (strpos($usuariosBDMail, ',') !== false) {
        $usuariosBDMailArray = explode(',', $usuariosBDMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosBDMailArray = [$usuariosBDMail];
    }

    $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
    if (strpos($usuariosSeleccionadosMail, ',') !== false) {
        $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
    }

    $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
    $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

    // Envia correos de eliminación a los participantes a eliminar
    $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

    foreach ($usuariosParaEliminar as $usuarioElim) {
        $correoParticipanteElim = $usuarioElim->correo;
        $details = [
            'servicio' => $ponenciasconferencia,
            'participante' => $usuarioElim,
            'evento' => 'Ponencias y conferencias'
        ];

        Mail::to($correoParticipanteElim)->send(new notificationElimponenciaconferencia($details));
    }

    // Envia correos de edición a los nuevos participantes
    $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

    foreach ($usuariosParaAgregar as $usuario) {
        $correoParticipante = $usuario->correo;
        $details = [
            'servicio' => $ponenciasconferencia,
            'participante' => $usuario,
            'evento' => 'Ponencias y conferencias'
        ];

        Mail::to($correoParticipante)->send(new notificationponenciaconferencia($details));
    }

    return redirect(route('ponenciasconferencias'));
}



//funcion para eliminar
public function ponenciasconferenciasEliminar($id)
{
    $ponenciasconferencia = ponenciasconferencia::find($id);

     // Obtener la lista de participantes actuales asociados al registro
     $participantesActuales = $ponenciasconferencia->participantes;
     if (strpos($participantesActuales, ',') !== false) {
         $participantesActualesArray = explode(',', $participantesActuales);
     } else {
         // Si no hay comas, crea un array con un solo elemento
         $participantesActualesArray = [$participantesActuales];
     }

     // Envía correos a los participantes antes de eliminar el registro
     foreach ($participantesActualesArray as $usuarioId) {
         $usuario = User::find($usuarioId);
         if ($usuario) {
         $correoParticipante = $usuario->correo;

         $detailsEliminar = [
             'servicio' => $ponenciasconferencia, // Información de la ponencia
             'participante' => $usuario, // Información del participante
             'evento' => 'Ponencias y conferencias'
         ];

         Mail::to($correoParticipante)->send(new notificationElimponenciaconferencia($detailsEliminar));
     }
 }

    // Eliminar registros relacionados en solicitud_usuarios
    $ponenciasconferencia->usuariosQuePuedenVisualizar()->delete();

    // Eliminar la ponencia y conferencia principal
    $ponenciasconferencia->delete();

    return redirect(route('ponenciasconferencias'));
}

public function ponenciasconferenciaEliminarRelacion(Request $request, $id)
{
    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');

    // Eliminar el registro en la tabla ponenciaconferencia_usuarios
    ponenciaconferencia_usuario::where('ponenciaconferencia_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

    // Obtener el servicio tecnológico
    $ponenciaconferencia = ponenciasconferencia::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $ponenciaconferencia->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $ponenciaconferencia->participantes = $participantesActualizados;
    $ponenciaconferencia->save();

    return redirect(route('ponenciasconferencias'));
}

////////////Fin de las funciones para el modulo de ponencias y conferencias////////////

////////////Funciones para el modulo de docencia////////////

    //funcion para Vusualizar en la vista docencia
    public function docencia(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
        // Obtener las universidades
        $Cliente = Cliente::where('status',1)->get();


        // Obtener otros ponenciasconferencia relacionados con el usuario
        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;

        $docencias = docencia::where('nombre_persona', $user->usuario)
        ->whereYear('fecha_fin', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        //Periodo consultado
        $periodoConsultado = $bimestreActual . " del " . $añoActual;

        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'usuarios' => $usuarios,
            'Cliente' => $Cliente,
            'sesionEspecial' => $sesionEspecial,
            'docencias' => $docencias,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            'periodoConsultado' => $periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'userID' => $userID
        ];


    return view('SIRB/difucionDocencia/docencia', $data);
}


//funcion para nueva docencia
public function nuevadocencia(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Crear el insert de docencia
    $docencia = new docencia;

    // Resto de campos de docencia
    $docencia->titulo_curso = $request->titulodocencia;
    $docencia->fecha_inicio = $request->fechainicio;
    $docencia->fecha_fin = $request->fechafin;
    $docencia->duracion_curso = $request->duracion;
    $docencia->institucion_impartio = $request->D_perteneciente;
    $docencia->lugar = $request->lugar;
    $docencia->nombre_persona = $request->nombre_persona;
    $docencia->encargado = $request->encargadoservicio;
    $docencia->area = $request->areaActividad;
    $docencia->save();


    return redirect(route('docencia', $data));
}



//funcion para editar
public function docenciaEditar(request $request, $id)
{

    $docencia = docencia::find($id);
    $docencia->titulo_curso = $request->titulodocencia;
    $docencia->fecha_inicio = $request->fechainicio;
    $docencia->fecha_fin = $request->fechafin;
    $docencia->duracion_curso = $request->duracion;
    $docencia->institucion_impartio = $request->D_perteneciente;
    $docencia->lugar = $request->lugar;
    $docencia->nombre_persona = $request->nombre_persona;
    $docencia->encargado = $request->encargadoservicio;
    $docencia->save();

    return redirect(route('docencia'));
}



//funcion para eliminar
public function docenciaEliminar($id)
{
    $docencia = docencia::find($id);

    // Eliminar la docencia principal
    $docencia->delete();

    return redirect(route('docencia'));
}

////////////Fin de las funciones para el modulo de docencia////////////

////////////Funciones para el modulo de libros////////////

    //funcion para Vusualizar en la vista libros
    public function libros(request $request)
    {

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // Obtener el nombre completo del usuario autenticado
        $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
        // Obtener el valor de sesionespecial de usuarios
        $sesionEspecial = $user->sesionespecial;
        // Obtener todos los usuarios menos el que esta autenticado
        $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
        // Obtener todos los clientes
        $Cliente = Cliente::where('status',1)->get();

        // Obtener otros libros relacionados con el usuario
        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;

        $libros = libro::where('nombre_persona', $user->usuario)
        ->whereYear('created_at', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('created_at', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('created_at', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        // Obtener las revistas relacionadas a través de la tabla intermedia
        $librosRelacionados = libro::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('created_at', $añoActual)
          ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('created_at', $this->getStartMonthOfBimester($bimestreActual))
              ->orWhereMonth('created_at', $this->getEndMonthOfBimester($bimestreActual));})->get();

              $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();

        //Periodo consultado
        $periodoConsultado = $bimestreActual . " del " . $añoActual;

        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'nombreCompleto' => $nombreCompleto,
            'usuarios' => $usuarios,
            'Cliente' => $Cliente,
            'sesionEspecial' => $sesionEspecial,
            'libros' => $libros,
            'librosRelacionados' => $librosRelacionados,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            'periodoConsultado' => $periodoConsultado,
            'fechabimestreP' => $fechabimestreP,
            'userID' => $userID
        ];


    return view('SIRB/difucionDocencia/libros', $data);
}


//funcion para nueva libro
public function nuevolibro(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);

    // Crear el insert de libro
    $libros = new libro;

    // Resto de campos de memorias
    $libros->titulo = $request->titulolibro;
    $libros->año = $request->año;
    $libros->editorial = $request->editorial;
    $libros->ciudad = $request->ciudad;
    $libros->pais = $request->pais;
    $libros->isbn = $request->isbn;
    $libros->nombre_persona = $request->nombre_persona;
    $libros->encargado = $request->encargadoservicio;
    $libros->area = $request->areaActividad;
    $libros->participantes = $request->usuarios_seleccionados;
    $libros->save();


    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva solicitud
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $librosR = new libros_usuario([
                    'libros_id' => $libros->id,
                    'usuario_id' => $usuarioId,
                ]);
                $librosR->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $details = [
                    'servicio' => $libros, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Libro'
                ];

                Mail::to($correoParticipante)->send(new notificationLibros($details));
            }
        }
    }

    return redirect(route('libros', $data));
}



//funcion para editar
public function librosEditar(request $request, $id)
{

    $libros = libro::find($id);
    $libros->titulo = $request->titulolibro;
    $libros->año = $request->año;
    $libros->editorial = $request->editorial;
    $libros->ciudad = $request->ciudad;
    $libros->pais = $request->pais;
    $libros->isbn = $request->isbn;
    $libros->nombre_persona = $request->nombre_persona;
    $libros->encargado = $request->encargadoservicio;
    $libros->participantes = $request->usuarios_seleccionados;
    $libros->save();

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $libros->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
        if (strpos($usuariosSeleccionados, ',') !== false) {
            $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosArray = [$usuariosSeleccionados];
        }

        // Obtener la lista de todos los participantes previamente asociados a este registro
        $participantesActualesEnBD = libros_usuario::where('libros_id', $libros->id)->pluck('usuario_id')->toArray();
        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionadosArray = explode(',', $request->input('usuarios_seleccionadosedit'));
        // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
        $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);
        // Eliminar a los participantes no seleccionados
        libros_usuario::where('libros_id', $libros->id)
            ->whereIn('usuario_id', $participantesParaEliminar)
            ->delete();


        // Agregar nuevos participantes o mantener los existentes
        foreach ($participantesActualesArray as $usuarioId) {
            $serviciotUsuario = new libros_usuario([
                'libros_id' => $libros->id,
                'usuario_id' => $usuarioId,
            ]);
            $serviciotUsuario->save();
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosBDMail = $request->usuarios_seleccionadosMail;
        if (strpos($usuariosBDMail, ',') !== false) {
            $usuariosBDMailArray = explode(',', $usuariosBDMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosBDMailArray = [$usuariosBDMail];
        }

        $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
        if (strpos($usuariosSeleccionadosMail, ',') !== false) {
            $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
        }

        $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
        $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

        // Envia correos de eliminación a los participantes a eliminar
        $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

        foreach ($usuariosParaEliminar as $usuarioElim) {
            $correoParticipanteElim = $usuarioElim->correo;
            $details = [
                'servicio' => $libros,
                'participante' => $usuarioElim,
                'evento' => 'Libro'
            ];

            Mail::to($correoParticipanteElim)->send(new notificationElimLibros($details));
        }

        // Envia correos de edición a los nuevos participantes
        $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

        foreach ($usuariosParaAgregar as $usuario) {
            $correoParticipante = $usuario->correo;
            $details = [
                'servicio' => $libros,
                'participante' => $usuario,
                'evento' => 'Libro'
            ];

            Mail::to($correoParticipante)->send(new notificationLibros($details));
        }

    return redirect(route('libros'));
}



//funcion para eliminar
public function librosEliminar($id)
{
    $libros = libro::find($id);

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $libros->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $detailsEliminar = [
                'servicio' => $libros, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Libros'
            ];

            Mail::to($correoParticipante)->send(new notificationElimLibros($detailsEliminar));
        }
    }

    // Eliminar registros relacionados en memoria_usuarios
    $libros->usuariosQuePuedenVisualizar()->delete();

    // Eliminar la revista principal
    $libros->delete();

    return redirect(route('libros'));
}



public function librosEliminarR(Request $request, $id)
{
    $userID = $request->session()->get('LoginId'); // Obtener el ID del usuario autenticado

    // Eliminar el registro en la tabla memoria_usuarios
    libros_usuario::where('libros_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

    // Obtener el servicio tecnológico
    $libros = libro::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $libros->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $libros->participantes = $participantesActualizados;
    $libros->save();

    return redirect(route('libros'));
}

////////////Fin de las funciones para el modulo de libros////////////
//////////////////////////Terminan las funciones del modulo de difucion y docencia////////////////////////////


////////////////////////////Funciones para el modulo de cursos Recibidos//////////////////////////////////////

//funcion para Visualizar en la vista cursos Recibidos
public function cursosRecibidos(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // Obtener el nombre completo del usuario autenticado
    $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
    // Obtener el valor de sesionespecial de usuarios
    $sesionEspecial = $user->sesionespecial;
    // Obtener todos los usuarios menos el que esta autenticado
    $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
    // Obtener todos los clientes
    $Cliente = Cliente::where('status',1)->get();
    // $Cliente = Cliente::where('status',1)->get();

    // Obtener otros cursos relacionados con el usuario
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;

    $cursosR = cursorecibido::where('nombre_persona', $user->usuario)
    ->whereYear('fecha_fin', $añoActual)
    ->where(function ($query) use ($bimestreActual) {
        $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
    })->get();

    // Obtener las revistas relacionadas a través de la tabla intermedia
    $cursosRelacionados = cursorecibido::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
        $query->where('usuario_id', $userID);
    })->whereYear('fecha_fin', $añoActual)
      ->where(function ($query) use ($bimestreActual) {
        $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
          ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));})->get();

    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

    // Crear una cadena que combine el bimestre y el año
    $periodoConsultado = $bimestreActual . " - " . $añoActual;
    // Fin del bimestre vigente segun tabla 'fechabimestres' (id=2)
    $refYear     = $fechabimestre2->año;
    $refBimester = $fechabimestre2->bimestre;

    $endMonth = $this->getEndMonthOfBimester($refBimester); // ya tienes este helper
    $bimestreEndDate = Carbon::create($refYear, $endMonth, 1)->endOfMonth()->toDateString();



    // Crear un arreglo de datos
    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'nombreCompleto' => $nombreCompleto,
        'usuarios' => $usuarios,
        'Cliente' => $Cliente,
        'sesionEspecial' => $sesionEspecial,
        'cursosR' => $cursosR,
        'cursosRelacionados' => $cursosRelacionados,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'periodoConsultado' => $periodoConsultado,
        'fechabimestreP' => $fechabimestreP,
        'bimestreEndDate' => $bimestreEndDate,
        'userID' => $userID
    ];


return view('SIRB/cursosRecividos', $data);
}


//funcion para nuevo curso
public function nuevocursoRecibido(request $request)
{
    //dd($request->all());
    // Bimestre vigente del sistema para topar la fecha de fin
    $ref = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $endMonth = $this->getEndMonthOfBimester($ref->bimestre);
    $bimestreEndDate = Carbon::create($ref->año, $endMonth, 1)->endOfMonth()->toDateString();

    $request->validate([
        'fechainicio' => ['required','date'],
        'fechafin'    => ['required','date','after_or_equal:fechainicio', function($attribute, $value, $fail) use ($bimestreEndDate) {
            if ($value > $bimestreEndDate) {
                $fail('La fecha de fin debe ser a más tardar ' . $bimestreEndDate . '.');
            }
        }],
    ],[
        'fechafin.after_or_equal' => 'La fecha de fin no puede ser anterior a la fecha de inicio.',
    ]);


    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);

    // Crear el insert de cursos
    $cursoR = new cursorecibido;

    // Resto de campos de curso recibido
    $cursoR->nombre_curso = $request->nombrecurso;
    $cursoR->fecha_inicio = $request->fechainicio;
    $cursoR->fecha_fin = $request->fechafin;
    $cursoR->duracion_curso = $request->duracion;
    $cursoR->I_organizadora = $request->D_perteneciente;
    $cursoR->lugar = $request->lugar;
    $cursoR->nombre_persona = $request->nombre_persona;
    $cursoR->encargado = $request->encargadoservicio;
    $cursoR->area = $request->areaActividad;
    $cursoR->participantes = $request->usuarios_seleccionados;
    $cursoR->save();


    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva solicitud
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $cursoRUsuario = new cursorecibido_usuarios([
                    'cursorecibido_id' => $cursoR->id,
                    'usuario_id' => $usuarioId,
                ]);
                $cursoRUsuario->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $details = [
                    'servicio' => $cursoR, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Curso'
                ];

                Mail::to($correoParticipante)->send(new notificationCursos($details));
            }
        }
    }

    return redirect(route('cursosRecibidos', $data));
}

//funcion para editar
public function cursoRecibidoEditar(request $request, $id)
{
    $ref = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $endMonth = $this->getEndMonthOfBimester($ref->bimestre);
    $bimestreEndDate = Carbon::create($ref->año, $endMonth, 1)->endOfMonth()->toDateString();

    $request->validate([
        'fechainicio' => ['required','date'],
        'fechafin'    => ['required','date','after_or_equal:fechainicio', function($attribute, $value, $fail) use ($bimestreEndDate) {
            if ($value > $bimestreEndDate) {
                $fail('La fecha de fin debe ser a más tardar ' . $bimestreEndDate . '.');
            } 
        }],
    ],[
        'fechafin.after_or_equal' => 'La fecha de fin no puede ser anterior a la fecha de inicio.',
    ]);


    $cursoR = cursorecibido::find($id);
    $cursoR->nombre_curso = $request->nombrecurso;
    $cursoR->fecha_inicio = $request->fechainicio;
    $cursoR->fecha_fin = $request->fechafin;
    $cursoR->duracion_curso = $request->duracion;
    $cursoR->I_organizadora = $request->D_perteneciente;
    $cursoR->lugar = $request->lugar;
    $cursoR->nombre_persona = $request->nombre_persona;
    $cursoR->encargado = $request->encargadoservicio;
    $cursoR->participantes = $request->usuarios_seleccionados;
    $cursoR->save();

            // Obtener la lista de participantes actuales asociados al registro
            $participantesActuales = $cursoR->participantes;
            if (strpos($participantesActuales, ',') !== false) {
                $participantesActualesArray = explode(',', $participantesActuales);
            } else {
                // Si no hay comas, crea un array con un solo elemento
                $participantesActualesArray = [$participantesActuales];
            }

            // Obtener la lista de participantes seleccionados del formulario
            $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
            if (strpos($usuariosSeleccionados, ',') !== false) {
                $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
            } else {
                // Si no hay comas, crea un array con un solo elemento
                $usuariosSeleccionadosArray = [$usuariosSeleccionados];
            }

            // Obtener la lista de todos los participantes previamente asociados a este registro
            $participantesActualesEnBD = cursorecibido_usuarios::where('cursorecibido_id', $cursoR->id)->pluck('usuario_id')->toArray();
            // Obtener la lista de participantes seleccionados del formulario
            $usuariosSeleccionadosArray = explode(',', $request->input('usuarios_seleccionadosedit'));
            // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
            $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);
            // Eliminar a los participantes no seleccionados
            cursorecibido_usuarios::where('cursorecibido_id', $cursoR->id)
                ->whereIn('usuario_id', $participantesParaEliminar)
                ->delete();


            // Agregar nuevos participantes o mantener los existentes
            foreach ($participantesActualesArray as $usuarioId) {
                $serviciotUsuario = new cursorecibido_usuarios([
                    'cursorecibido_id' => $cursoR->id,
                    'usuario_id' => $usuarioId,
                ]);
                $serviciotUsuario->save();
            }

    // Obtener la lista de participantes seleccionados del formulario
    $usuariosBDMail = $request->usuarios_seleccionadosMail;
    if (strpos($usuariosBDMail, ',') !== false) {
        $usuariosBDMailArray = explode(',', $usuariosBDMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosBDMailArray = [$usuariosBDMail];
    }

    $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
    if (strpos($usuariosSeleccionadosMail, ',') !== false) {
        $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
    } else {
        // Si no hay comas, crea un array con un solo elemento
        $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
    }

    $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
    $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

    // Envia correos de eliminación a los participantes a eliminar
    $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

    foreach ($usuariosParaEliminar as $usuarioElim) {
        $correoParticipanteElim = $usuarioElim->correo;
        $details = [
            'servicio' => $cursoR,
            'participante' => $usuarioElim,
            'evento' => 'Curso'
        ];

        Mail::to($correoParticipanteElim)->send(new notificationElimCursos($details));
    }

    // Envia correos de edición a los nuevos participantes
    $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

    foreach ($usuariosParaAgregar as $usuario) {
        $correoParticipante = $usuario->correo;
        $details = [
            'servicio' => $cursoR,
            'participante' => $usuario,
            'evento' => 'Curso'
        ];

        Mail::to($correoParticipante)->send(new notificationCursos($details));
    }

    return redirect(route('cursosRecibidos'));
}

//funcion para eliminar
public function cursoRecibidoEliminar($id)
{
    $cursoR = cursorecibido::find($id);

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $cursoR->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $detailsEliminar = [
                'servicio' => $cursoR, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Curso'
            ];

            Mail::to($correoParticipante)->send(new notificationElimCursos($detailsEliminar));
        }
    }

    // Eliminar registros relacionados en solicitud_usuarios
    $cursoR->usuariosQuePuedenVisualizar()->delete();

    // Eliminar la solicitud principal
    $cursoR->delete();

    return redirect(route('cursosRecibidos'));
}

public function cursoRecibidoEliminarR(Request $request, $id)
{
    $userID = $request->session()->get('LoginId'); // Obtener el ID del usuario autenticado

    // Eliminar el registro en la tabla cursosrecibidos_usuarios
    cursorecibido_usuarios::where('cursorecibido_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

    // Obtener el servicio tecnológico
    $cursoR = cursorecibido::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $cursoR->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $cursoR->participantes = $participantesActualizados;
    $cursoR->save();

    return redirect(route('cursosRecibidos'));
}

////////////////////////////Terminan las funciones del modulo de cursos recibidos/////////////////////////////

/////////////////////////////funciones del modulo de postgrados///////////////////////////////////////////////

//funcion para Visualizar en la vista postgrados
public function postgrados(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // Obtener el valor de sesionespecial de usuarios
    $sesionEspecial = $user->sesionespecial;
    // Obtener todos los usuarios menos el que esta autenticado
    $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
    // Obtener todos los clientes
    //$Cliente = Cliente::all();

    //Obtener a las universidades
    $Cliente = Cliente::where('nivel2', 'Universidades y Centros de Investigación')->get();

    // Obtener otros postgrados relacionados con el usuario
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    $mesInicioBimestre = $this->getStartMonthOfBimester($fechabimestre2->bimestre);
    $mesFinBimestre = $this->getEndMonthOfBimester($fechabimestre2->bimestre);
    $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

    // Obtener los registros de postgrados
    $postgrados = postgrado::where('nombre_persona', $user->usuario)
    ->get();


    //Periodo consultado
    $periodoConsultado = $bimestreActual . " del " . $añoActual;


    // Crear un arreglo de datos
    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'usuarios' => $usuarios,
        'Cliente' => $Cliente,
        'sesionEspecial' => $sesionEspecial,
        'postgrados' => $postgrados,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'periodoConsultado' => $periodoConsultado,
        'fechabimestreP' => $fechabimestreP,
        'userID' => $userID
        ];


return view('SIRB/postgrados', $data);
}


//funcion para nueva solicitud
public function nuevopostgrados(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Crear el insert de cursos
    $postgrado = new postgrado;
    $postgrado->grado = $request->grado;
    $postgrado->fecha_inicio = $request->fechainicio;
    $postgrado->fechaT_titulacion = $request->fechatitulacion;
    $postgrado->titulo_postgrado = $request->nombrepostgrado;
    // $postgrado->titulo_tesis  $request->nombretesis;
    $postgrado->titulo_tesis = '';
    $postgrado->institucion = $request->D_perteneciente;
    $postgrado->A_desarrolladas = $request->A_desarrolladas;
    $postgrado->estado = $request->estado;
    $postgrado->nombre_persona = $request->nombre_persona;
    $postgrado->encargado = $request->encargadoservicio;
    $postgrado->area = $request->areaActividad;
    $postgrado->save();

    return redirect(route('postgrados', $data));
}

//funcion para editar
public function postgradosEditar(request $request)
{

    $postgrado = postgrado::find($request->input('id_posgrade'));
    $postgrado->grado = $request->grado;
    $postgrado->fecha_inicio = $request->fechainicio;
    $postgrado->fechaT_titulacion = $request->fechatitulacion;
    $postgrado->titulo_postgrado = $request->nombrepostgrado;
    // $postgrado->titulo_tesis  $request->nombretesis;
    $postgrado->titulo_tesis = '';
    $postgrado->institucion = $request->D_perteneciente;
    $postgrado->A_desarrolladas = $request->A_desarrolladasedit;
    $postgrado->estado = $request->estado;
        // Verificar si el estado es igual a Finalizado
        if ($request->estado == 'Finalizado') {
            $fechaActual = now();
            $fechaFormateada = $fechaActual->format('Y-m-d'); // Formatear la fecha en "aaaa-mm-dd"
            $postgrado->fechaT_titulacion = $fechaFormateada;
        }
    $postgrado->nombre_persona = $request->nombre_persona;
    $postgrado->encargado = $request->encargadoservicio;
    $postgrado->save();

    return redirect(route('postgrados'));
}

//funcion para eliminar
public function postgradosEliminar($id)
{
    $postgrado = postgrado::find($id);

    // Eliminar el postgrado principal
    $postgrado->delete();

    return redirect(route('postgrados'));
}

//////////////////////////////////Terminan las funciones del modulo de postgrados/////////////////////////////

//////////////////////////////////funciones del modulo de tesis///////////////////////////////////////////////

//funcion para Visualizar en la vista tesis
public function tesis(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // Obtener el valor de sesionespecial de usuarios
    $sesionEspecial = $user->sesionespecial;
    // Obtener todos los usuarios menos el que esta autenticado
    $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
    // Obtener todos los clientes
    //$Cliente = Cliente::all();

    //Obtener a las universidades
    $Cliente = Cliente::where('nivel2', 'Universidades y Centros de Investigación')->get();

    // Obtener otros postgrados relacionados con el usuario
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

    // Obtener los registros de servicios tecnológicos
    $tesis = tesi::where('nombre_alumno', $user->usuario)
    ->get();


    //Periodo consultado
    $periodoConsultado = $bimestreActual . " del " . $añoActual;


    // Crear un arreglo de datos
    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'usuarios' => $usuarios,
        'Cliente' => $Cliente,
        'sesionEspecial' => $sesionEspecial,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'tesis' => $tesis,
        'periodoConsultado' => $periodoConsultado,
        'fechabimestreP' => $fechabimestreP,
        'userID' => $userID
        ];


return view('SIRB/tesis', $data);
}


//funcion para nueva tesis
public function nuevotesis(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Crear el insert de tesis
    $tesis = new tesi;
    $tesis->titulo_tesis = $request->nombretesis;
    $tesis->participacion = $request->participacion;
    $tesis->nombre_alumno = $request->nombre_estudiante;
    $tesis->encargado = $request->encargadoservicio;
    $tesis->nombre_especialidad = $request->nombreespecialidad;
    $tesis->facultad = $request->facultad;
    $tesis->grado = $request->grado;
    $tesis->institucion = $request->D_perteneciente;
    $tesis->fecha_inicio = $request->fechainicio;
    $tesis->fechaT_titulacion = $request->fechatitulacion;
    $tesis->fase_tesis = $request->estado;
    $tesis->estudiante = $request->estudiante;
    $tesis->area = $request->areaActividad;
    $tesis->save();

    return redirect(route('tesis', $data));
}

//funcion para editar
public function tesisEditar(request $request, $id)
{

    $tesis = tesi::find($id);
    $tesis->titulo_tesis = $request->nombretesis;
    $tesis->participacion = $request->participacion;
    $tesis->nombre_alumno = $request->nombre_estudiante;
    $tesis->encargado = $request->encargadoservicio;
    $tesis->nombre_especialidad = $request->nombreespecialidad;
    $tesis->facultad = $request->facultad;
    $tesis->grado = $request->grado;
    $tesis->institucion = $request->D_perteneciente;
    $tesis->fecha_inicio = $request->fechainicio;
    $tesis->fechaT_titulacion = $request->fechatitulacion;
    $tesis->fase_tesis = $request->estado; // Asignar el estado de la tesis
    // Verificar si el estado es igual a Terminada o Cancelada
    if ($request->estado == 'Terminada' || $request->estado == 'Cancelada') {
        $fechaActual = now();
        $fechaFormateada = $fechaActual->format('Y-m-d'); // Formatear la fecha en "aaaa-mm-dd"
        $tesis->fechaT_titulacion = $fechaFormateada;
    }

    // Verificar si el estado es igual a Suspendida
    if ($request->estado == 'Suspendida') {
        $anioActual = date('Y'); // Obtener el año actual
        $anioSuspendida = $anioActual + 5; // Sumar cinco años
        $fechaSuspendida = $anioSuspendida . '-12-31'; // Formar la fecha en "aaaa-12-31"
        $tesis->fechaT_titulacion = $fechaSuspendida;
    }

    $tesis->estudiante = $request->estudiante;
    $tesis->save();

    return redirect(route('tesis'));
}

//funcion para eliminar
public function tesisEliminar($id)
{
    $tesis = tesi::find($id);

    // Eliminar el postgrado principal
    $tesis->delete();

    return redirect(route('tesis'));
}

//////////////////////////////////Terminan las funciones del modulo de tesis//////////////////////////////////

////////////////////////////Funciones para el modulo de otras actividades/////////////////////////////////////

//funcion para Visualizar en la vista de otras actividades
public function otrasactividades(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // Obtener el nombre completo del usuario autenticado
    $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;
    // Obtener el valor de sesionespecial de usuarios
    $sesionEspecial = $user->sesionespecial;
    // Obtener todos los usuarios menos el que esta autenticado
    $usuarios = User::where('id', '!=', $userID)->whereIn('acceso', [2, 3])
                                                    ->orderBy('Apellido_Paterno')
                                                    ->orderBy('Apellido_Materno')
                                                    ->orderBy('Nombre')
                                                    ->get();
    // Obtener todos los clientes
    $Cliente = Cliente::where('status',1)->get();

    // Obtener otras actividades relacionados con el usuario
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

    $otraactivida = otraactivida::where('nombre_persona', $user->usuario)
    ->whereYear('fecha', $añoActual)
    ->where(function ($query) use ($bimestreActual) {
        $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
    })->get();

    // Obtener las otras actividades relacionadas a través de la tabla intermedia
    $otraactividaRelacionados = otraactivida::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
        $query->where('usuario_id', $userID);
    })->whereYear('fecha', $añoActual)
      ->where(function ($query) use ($bimestreActual) {
        $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
          ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));})->get();


          $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();

        //Periodo consultado
        $periodoConsultado = $bimestreActual . " del " . $añoActual;

    // Crear un arreglo de datos
    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'nombreCompleto' => $nombreCompleto,
        'usuarios' => $usuarios,
        'Cliente' => $Cliente,
        'sesionEspecial' => $sesionEspecial,
        'otraactivida' => $otraactivida,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'otraactividaRelacionados' => $otraactividaRelacionados,
        'periodoConsultado' => $periodoConsultado,
        'fechabimestreP' => $fechabimestreP,
        'userID' => $userID
    ];


return view('SIRB/otrasactividades', $data);
}


//funcion para nueva solicitud
public function nuevaactividad(request $request)
{
    //dd($request->all());

    $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];

    // Obtener la cadena de usuarios seleccionados
    $usuariosSeleccionadosStr = $request->input('usuarios_seleccionados');
    // Dividir la cadena por comas para obtener un arreglo de IDs
    $usuariosSeleccionados = explode(',', $usuariosSeleccionadosStr);

    // Crear el insert de cursos
    $otraactivida = new otraactivida;

    // Resto de campos de curso recibido
    $otraactivida->nombre_actividad = $request->actividad;
    $otraactivida->fecha = $request->fecha;
    $otraactivida->tipo_actividad = $request->tipoactividad;
    $otraactivida->descripcion = $request->descripcion;
    $otraactivida->nombre_persona = $request->nombre_persona;
    $otraactivida->encargado = $request->encargadoservicio;
    $otraactivida->area = $request->areaActividad;
    $otraactivida->participantes = $request->usuarios_seleccionados;
    $otraactivida->save();


    // Verificar si hay usuarios seleccionados antes de asociarlos
    if (!empty($usuariosSeleccionados)) {
        // Asociar los usuarios seleccionados con la nueva solicitud
        foreach ($usuariosSeleccionados as $usuarioId) {
            // Verificar si $usuarioId es un valor válido (no vacío)
            if (!empty($usuarioId)) {
                $otraactivida_usuarios = new otraactivida_usuarios([
                    'otraactividad_id' => $otraactivida->id,
                    'usuario_id' => $usuarioId,
                ]);
                $otraactivida_usuarios->save();

                // Enviar correo al participante actual
                $usuario = User::find($usuarioId);
                $correoParticipante = $usuario->correo;
                // Crear un arreglo con la información del servicio y del participante
                $details = [
                    'servicio' => $otraactivida, // Información del servicio tecnológico
                    'participante' => $usuario, // Información del participante
                    'evento' => 'Otra Actividad'
                ];

                Mail::to($correoParticipante)->send(new notificationOtraActividad($details));
            }
        }
    }

    return redirect(route('otrasactividades', $data));
}

//funcion para editar
public function actividadEditar(request $request, $id)
{

    $otraactivida = otraactivida::find($id);
    $otraactivida->nombre_actividad = $request->actividad;
    $otraactivida->fecha = $request->fecha;
    $otraactivida->tipo_actividad = $request->tipoactividad;
    $otraactivida->descripcion = $request->descripcion;
    $otraactivida->nombre_persona = $request->nombre_persona;
    $otraactivida->encargado = $request->encargadoservicio;
    $otraactivida->participantes = $request->usuarios_seleccionados;
    $otraactivida->save();

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $otraactivida->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionados = $request->input('usuarios_seleccionadosedit');
        if (strpos($usuariosSeleccionados, ',') !== false) {
            $usuariosSeleccionadosArray = explode(',', $usuariosSeleccionados);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosArray = [$usuariosSeleccionados];
        }

        // Obtener la lista de todos los participantes previamente asociados a este registro
        $participantesActualesEnBD = otraactivida_usuarios::where('otraactividad_id', $otraactivida->id)->pluck('usuario_id')->toArray();
        // Obtener la lista de participantes seleccionados del formulario
        $usuariosSeleccionadosArray = explode(',', $request->input('usuarios_seleccionadosedit'));
        // Identificar a los participantes que estaban en la base de datos pero no se seleccionaron
        $participantesParaEliminar = array_diff($participantesActualesEnBD, $usuariosSeleccionadosArray);
        // Eliminar a los participantes no seleccionados
        otraactivida_usuarios::where('otraactividad_id', $otraactivida->id)
            ->whereIn('usuario_id', $participantesParaEliminar)
            ->delete();


        // Agregar nuevos participantes o mantener los existentes
        foreach ($participantesActualesArray as $usuarioId) {
            $serviciotUsuario = new otraactivida_usuarios([
                'otraactividad_id' => $otraactivida->id,
                'usuario_id' => $usuarioId,
            ]);
            $serviciotUsuario->save();
        }

        // Obtener la lista de participantes seleccionados del formulario
        $usuariosBDMail = $request->usuarios_seleccionadosMail;
        if (strpos($usuariosBDMail, ',') !== false) {
            $usuariosBDMailArray = explode(',', $usuariosBDMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosBDMailArray = [$usuariosBDMail];
        }

        $usuariosSeleccionadosMail = $request->usuarios_seleccionados;
        if (strpos($usuariosSeleccionadosMail, ',') !== false) {
            $usuariosSeleccionadosMailArray = explode(',', $usuariosSeleccionadosMail);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $usuariosSeleccionadosMailArray = [$usuariosSeleccionadosMail];
        }

        $usuariosParaEliminarMail = array_diff($usuariosBDMailArray, $usuariosSeleccionadosMailArray);
        $usuariosParaAgregarMail = array_diff($usuariosSeleccionadosMailArray, $usuariosBDMailArray);

        // Envia correos de eliminación a los participantes a eliminar
        $usuariosParaEliminar = User::whereIn('id', $usuariosParaEliminarMail)->get();

        foreach ($usuariosParaEliminar as $usuarioElim) {
            $correoParticipanteElim = $usuarioElim->correo;
            $details = [
                'servicio' => $otraactivida,
                'participante' => $usuarioElim,
                'evento' => 'Otra Actividad'
            ];

            Mail::to($correoParticipanteElim)->send(new notificationElimOtraActividad($details));
        }

        // Envia correos de edición a los nuevos participantes
        $usuariosParaAgregar = User::whereIn('id', $usuariosParaAgregarMail)->get();

        foreach ($usuariosParaAgregar as $usuario) {
            $correoParticipante = $usuario->correo;
            $details = [
                'servicio' => $otraactivida,
                'participante' => $usuario,
                'evento' => 'Otra Actividad'
            ];

            Mail::to($correoParticipante)->send(new notificationOtraActividad($details));
        }


    return redirect(route('otrasactividades'));
}

//funcion para eliminar
public function actividadEliminar($id)
{
    $otraactivida = otraactivida::find($id);

        // Obtener la lista de participantes actuales asociados al registro
        $participantesActuales = $otraactivida->participantes;
        if (strpos($participantesActuales, ',') !== false) {
            $participantesActualesArray = explode(',', $participantesActuales);
        } else {
            // Si no hay comas, crea un array con un solo elemento
            $participantesActualesArray = [$participantesActuales];
        }

        // Envía correos a los participantes antes de eliminar el registro
        foreach ($participantesActualesArray as $usuarioId) {
            $usuario = User::find($usuarioId);
            if ($usuario) {
            $correoParticipante = $usuario->correo;

            $detailsEliminar = [
                'servicio' => $otraactivida, // Información del servicio tecnológico
                'participante' => $usuario, // Información del participante
                'evento' => 'Otra Actividad'
            ];

            Mail::to($correoParticipante)->send(new notificationElimOtraActividad($detailsEliminar));
        }
    }

    // Eliminar registros relacionados en solicitud_usuarios
    $otraactivida->usuariosQuePuedenVisualizar()->delete();

    // Eliminar la solicitud principal
    $otraactivida->delete();

    return redirect(route('otrasactividades'));
}

public function actividadEliminarR(Request $request, $id)
{
    $userID = $request->session()->get('LoginId'); // Obtener el ID del usuario autenticado

    // Eliminar el registro en la tabla otraactivida_usuarios
    otraactivida_usuarios::where('otraactividad_id', $id)
        ->where('usuario_id', $userID)
        ->delete();

            // Obtener el servicio tecnológico
    $otraactivida = otraactivida::find($id);

    // Obtener la lista de participantes actuales
    $participantesActuales = explode(',', $otraactivida->participantes);

    // Eliminar al usuario del array si existe
    $key = array_search($userID, $participantesActuales);
    if ($key !== false) {
        unset($participantesActuales[$key]);
    }

    // Unir nuevamente la lista de participantes en un formato de cadena
    $participantesActualizados = implode(',', $participantesActuales);

    // Actualizar el campo "participantes" en el servicio tecnológico
    $otraactivida->participantes = $participantesActualizados;
    $otraactivida->save();

    return redirect(route('otrasactividades'));
}

////////////////////////////Terminan las funciones del modulo de otras actividades////////////////////////////


////////////////////////////Funciones para el modulo de reportes/////////////////////////////////////

public function menureportes(Request $request){
    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // Obtener el valor de sesionespecial de usuarios
    $sesionEspecial = $user->sesionespecial;

    //Periodo consultado
    $fechabimestreC = User::find($userID); // Obtener el registro con id=1
    $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();


    // Comprobar si se encontró un registro con el id=1
    if ($fechabimestreC) {
        $año = $fechabimestreC->año;
        $bimestre = $fechabimestreC->bimestre;

        // Crear una cadena que combine el bimestre y el año
        $periodoConsultado = $bimestre . " - " . $año;
    } else {
        // Manejar el caso en el que no se encuentra un registro con id=1
        $periodoConsultado = "No encontrado";
    }

    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'periodoConsultado' => $periodoConsultado,
        'sesionEspecial' => $sesionEspecial,
        'fechabimestreC' => $fechabimestreC,
        'fechabimestreP' => $fechabimestreP,
        'fechabimestre' => $fechabimestre,
        'userID' => $userID
    ];



    return view('SIRB/menureportes', $data);
}

public function reporte(Request $request){
////////////////////////////Consulta para los reportes/////////////////////////////////////
    // Obtener los datos del usuario
        $userID = $request->session()->get('LoginId');
        $user = User::find($userID);
        $userData = DB::table('usuarios')
        ->join('puesto', 'usuarios.idpuesto', '=', 'puesto.id')
        ->join('area_adscripcion', 'usuarios.idarea', '=', 'area_adscripcion.id')
        ->select(
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
            'puesto.puesto as Plaza',
            'area_adscripcion.nombre_area as Area'
        )
        ->where('usuarios.id', $userID)
        ->first();
        

        $fcoordinador = DB::table('usuarios as u')
        ->join('usuarios as c', function ($join) use ($userID) {
            $join->on('u.idarea', '=', 'c.idarea')
                ->where('c.responsable', '=', 1)
                ->where('c.id', '<>', $userID); // Excluir al usuario actual
        })
        ->join('area_adscripcion as a', 'c.idarea', '=', 'a.id')
        ->select(
            'c.Nombre as NombreCoordinador',
            'c.Apellido_Paterno as ApellidoPaternoCoordinador',
            'c.Apellido_Materno as ApellidoMaternoCoordinador',
            'a.nombre_area as Area'
        )
        ->where('u.id', $userID)
        ->first();



    //Varibles para el filtrado

        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;

        $mesInicioBimestre = $this->getStartMonthOfBimester($fechabimestre2->bimestre);
        $mesFinBimestre = $this->getEndMonthOfBimester($fechabimestre2->bimestre);

        $curpUsuario = $user->curp;
        $startDateInicio = $this->getStartMonthOfBimester($bimestreActual);
        $startDateFin = $this->getEndMonthOfBimester($bimestreActual);

        $proyectosrelacionados = DB::table('equipo')
        ->where('idusuario', $userID)
        ->pluck('idproyecto');


    //Proyectos en los que participa

    $proyectos = DB::table('proyectos')
        ->where('idusuarior', $userID)
        ->where('oculto', 1)
        ->get()
        ->map(function ($item) {
            // Añadir la propiedad "participacion"
            $item->participacion = 'Responsable';

            // Calcular los años y bimestres para cada registro
            $fechas = [$item->fecha_inicio, $item->fecha_fin];
            $aniosBimestres = [];

            foreach ($fechas as $fecha) {
                $date = new \DateTime($fecha); // Añadir la barra invertida para indicar que es una clase global

                $anio = $date->format('Y');
                $mes = $date->format('n');
                $bimestre = ceil($mes / 2);

                // Añadir al array todos los bimestres entre fecha_inicio y fecha_fin
                $fechaFin = new \DateTime($item->fecha_fin);
                while ($date <= $fechaFin) {
                    $bimestre = ceil($date->format('n') / 2);
                    $aniosBimestres[$date->format('Y')][$bimestre] = true;
                    $date->add(new \DateInterval('P1M')); // Agregar un mes
                }
            }

            // Añadir el array al objeto
            $item->aniosBimestres = $aniosBimestres;

            return $item;
        });

    $proyectosPart = DB::table('proyectos')
        ->whereIn('id', $proyectosrelacionados)
        ->where('oculto', 1)
        ->get()
        ->map(function ($item) {
            // Añadir la propiedad "participacion"
            $item->participacion = 'Participante';

            // Calcular los años y bimestres para cada registro
            $fechas = [$item->fecha_inicio, $item->fecha_fin];
            $aniosBimestres = [];

            foreach ($fechas as $fecha) {
                $date = new \DateTime($fecha); // Añadir la barra invertida para indicar que es una clase global

                $anio = $date->format('Y');
                $mes = $date->format('n');
                $bimestre = ceil($mes / 2);

                // Añadir al array todos los bimestres entre fecha_inicio y fecha_fin
                $fechaFin = new \DateTime($item->fecha_fin);
                while ($date <= $fechaFin) {
                    $bimestre = ceil($date->format('n') / 2);
                    $aniosBimestres[$date->format('Y')][$bimestre] = true;
                    $date->add(new \DateInterval('P1M')); // Agregar un mes
                }
            }

            // Añadir el array al objeto
            $item->aniosBimestres = $aniosBimestres;

            return $item;
        });

    $proyectosfin = $proyectos->concat($proyectosPart);

    //dd($proyectosfin);

    // Obtener los registros de servicios tecnológicos
    $serviciotecnologico = serviciotecnologico::where('nombre_persona', $user->usuario)
        ->get()
        ->map(function ($item) {

            // Calcular los años y bimestres para cada registro
            $fechas = [$item->fechainicio, $item->fechafin];
            $aniosBimestres = [];

            foreach ($fechas as $fecha) {
                $date = new \DateTime($fecha); // Añadir la barra invertida para indicar que es una clase global

                $anio = $date->format('Y');
                $mes = $date->format('n');
                $bimestre = ceil($mes / 2);

                // Añadir al array todos los bimestres entre fechainicio y fechafin
                $fechaFin = new \DateTime($item->fechafin);
                while ($date <= $fechaFin) {
                    $bimestre = ceil($date->format('n') / 2);
                    $aniosBimestres[$date->format('Y')][$bimestre] = true;
                    $date->add(new \DateInterval('P1M')); // Agregar un mes
                }
            }

            // Añadir el array al objeto
            $item->aniosBimestres = $aniosBimestres;

            return $item;
        });

    // Obtener los registros relacionados de servicios tecnológicos
    $serviciotecnologicoRelacionadas = serviciotecnologico::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
        $query->where('usuario_id', $userID);
        })->get()
        ->map(function ($item) {

            // Calcular los años y bimestres para cada registro
            $fechas = [$item->fechainicio, $item->fechafin];
            $aniosBimestres = [];

            foreach ($fechas as $fecha) {
                $date = new \DateTime($fecha); // Añadir la barra invertida para indicar que es una clase global

                $anio = $date->format('Y');
                $mes = $date->format('n');
                $bimestre = ceil($mes / 2);

                // Añadir al array todos los bimestres entre fechainicio y fechafin
                $fechaFin = new \DateTime($item->fechafin);
                while ($date <= $fechaFin) {
                    $bimestre = ceil($date->format('n') / 2);
                    $aniosBimestres[$date->format('Y')][$bimestre] = true;
                    $date->add(new \DateInterval('P1M')); // Agregar un mes
                }
            }

            // Añadir el array al objeto
            $item->aniosBimestres = $aniosBimestres;

            return $item;
        });
    



    // Reuniones en las que participa
        $reuniones = reunion::where('nombre_persona', $user->usuario)
        ->whereYear('fecha_reunion', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha_reunion', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha_reunion', $this->getEndMonthOfBimester($bimestreActual));
        })->get();


        $reunionesRelacionadas = reunion::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fecha_reunion', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha_reunion', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fecha_reunion', $this->getEndMonthOfBimester($bimestreActual));})->get();


    //Comités en los que participa
        $comites = comite::where('nombre_persona', $user->usuario)
        ->whereYear('created_at', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fechas', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fechas', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        $comitesRelacionadas = comite::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fechas', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fechas', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fechas', $this->getEndMonthOfBimester($bimestreActual));
        })->get();



    //Solicitudes en los que participa
        $solicitudes = solicitudes::where('nombre_persona', $user->usuario)
        ->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        $solicitudesRelacionadas = solicitudes::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('created_at', $añoActual)
          ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
              ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));})->get();

    ////////////////Modulos de difusión/////////////

    ////Revistas
        $revistas = revista::where('nombre_persona', $user->usuario)
            ->whereYear('fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
            })->get();


        $revistaRelacionados = revista::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));})->get();

    ////Memorias
        $memorias = memoria::where('nombre_persona', $user->usuario)
            ->whereYear('fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
            })->get();

            $memoriaRelacionados = memoria::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
                $query->where('usuario_id', $userID);
            })->whereYear('fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));})->get();

    ///Boletín

    $boletines = DB::select("
    SELECT
        usuarios.curp,
        usuarios.idarea,
        imt_bol_boletin.Anio,
        imt_bol_boletin.Titulo AS BoletinTitulo,
        imt_bol_articulo.Titulo AS ArticuloTitulo,
        imt_bol_boletin.NoBoletin,
        imt_bol_articulo.NoArticulo,
        imt_gen_coordinacion.Nombre,
        imt_bol_autorarticulo.ID_BOL_Articulo,
        imt_bol_autorarticulo.ID_GEN_Autor,
        imt_bol_autorarticulo.Jerarquia
    FROM usuarios
        JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
        JOIN siapimt25.imt_bol_autorarticulo ON imt_gen_autor.ID_GEN_Autor = imt_bol_autorarticulo.ID_GEN_Autor
        JOIN siapimt25.imt_bol_articulo ON imt_bol_autorarticulo.ID_BOL_Articulo = imt_bol_articulo.ID_BOL_Articulo
        JOIN siapimt25.imt_bol_boletin ON imt_bol_articulo.ID_BOL_Boletin = imt_bol_boletin.ID_BOL_Boletin
        JOIN siapimt25.imt_gen_coordinacion ON imt_bol_boletin.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
    WHERE usuarios.curp = ? AND (MONTH(imt_bol_boletin.Anio) = ? OR MONTH(imt_bol_boletin.Anio) = ?) AND YEAR(imt_bol_boletin.Anio) = ?
", [$curpUsuario, $startDateInicio, $startDateFin, $añoActual]);

    $participantes = DB::select("
        SELECT
            imt_bol_autorarticulo.ID_BOL_Articulo,
            GROUP_CONCAT(imt_gen_autor.Nombre, ' ', imt_gen_autor.Apellidos) AS NombresParticipantes
        FROM siapimt25.imt_gen_autor
            JOIN siapimt25.imt_bol_autorarticulo ON imt_gen_autor.ID_GEN_Autor = imt_bol_autorarticulo.ID_GEN_Autor
            JOIN siapimt25.imt_bol_articulo ON imt_bol_autorarticulo.ID_BOL_Articulo = imt_bol_articulo.ID_BOL_Articulo
            JOIN siapimt25.imt_bol_boletin ON imt_bol_articulo.ID_BOL_Boletin = imt_bol_boletin.ID_BOL_Boletin
            JOIN siapimt25.imt_gen_coordinacion ON imt_bol_boletin.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
        WHERE (MONTH(imt_bol_boletin.Anio) = ? OR MONTH(imt_bol_boletin.Anio) = ?) AND YEAR(imt_bol_boletin.Anio) = ?
        GROUP BY imt_bol_autorarticulo.ID_BOL_Articulo
    ", [$startDateInicio, $startDateFin, $añoActual]);

    // Acceder a los nombres de los participantes
    $nombresParticipantes = [];

    foreach ($participantes as $participante) {
        $nombresParticipantes[$participante->ID_BOL_Articulo] = $participante->NombresParticipantes;
    }



    ////Documentos Tecnicos


        // Consultar la información deseada de documentos tecnicos

        $documentos = DB::select("
        SELECT
            usuarios.curp,
            imt_pub_publicacion.Anio,
            imt_pub_publicacion.Titulo,
            imt_pub_publicacion.NoPublicacion,
            imt_pub_publicacion.ID_GEN_Coordinacion,
            imt_pub_publicacion.AreaInteres,
            imt_pub_tipopublicacion.Nombre,
            imt_pub_autorpublicacion.ID_PUB_Publicacion,
            imt_pub_autorpublicacion.ID_GEN_Autor,
            imt_pub_autorpublicacion.Jerarquia
        FROM usuarios
            JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
            JOIN siapimt25.imt_pub_autorpublicacion ON imt_gen_autor.ID_GEN_Autor = imt_pub_autorpublicacion.ID_GEN_Autor
            JOIN siapimt25.imt_pub_publicacion ON imt_pub_autorpublicacion.ID_PUB_Publicacion = imt_pub_publicacion.ID_PUB_Publicacion
            JOIN siapimt25.imt_pub_tipopublicacion ON imt_pub_publicacion.id_pub_tipoPublicacion = imt_pub_tipopublicacion.id_pub_tipoPublicacion
            JOIN siapimt25.imt_gen_coordinacion ON imt_pub_publicacion.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
        WHERE
            usuarios.curp = ? AND (MONTH(imt_pub_publicacion.Anio) = ? OR MONTH(imt_pub_publicacion.Anio) = ?) AND YEAR(imt_pub_publicacion.Anio) = ?
        ", [$curpUsuario, $startDateInicio, $startDateFin, $añoActual]);

            $participantesII = DB::select("
            SELECT
                imt_pub_autorpublicacion.ID_PUB_Publicacion,
                GROUP_CONCAT(imt_gen_autor.Nombre, ' ', imt_gen_autor.Apellidos) AS NombresParticipantes
            FROM siapimt25.imt_gen_autor
                JOIN siapimt25.imt_pub_autorpublicacion ON imt_gen_autor.ID_GEN_Autor = imt_pub_autorpublicacion.ID_GEN_Autor
                JOIN siapimt25.imt_pub_publicacion ON imt_pub_autorpublicacion.ID_PUB_Publicacion = imt_pub_publicacion.ID_PUB_Publicacion
            WHERE (MONTH(imt_pub_publicacion.Anio) = ? OR MONTH(imt_pub_publicacion.Anio) = ?) AND YEAR(imt_pub_publicacion.Anio) = ?
            GROUP BY imt_pub_autorpublicacion.ID_PUB_Publicacion
        ", [$startDateInicio, $startDateFin, $añoActual]);

        // Acceder a los nombres de los participantes
        $nombresParticipantesII = [];
        foreach ($participantesII as $participante) {
            $nombresParticipantesII[$participante->ID_PUB_Publicacion] = $participante->NombresParticipantes;
        }



    ////Ponencias y conf
        $ponenciasconferencias = ponenciasconferencia::where('nombre_persona', $user->usuario)
            ->whereYear('fecha_fin', $añoActual)
            ->where('fecha_fin', 'like', $añoActual.'%')
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
            })->get();

            // $ponenciasconferenciasRelacionadas = ponenciasconferencia::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            //     $query->where('usuario_id', $userID);
            // })->whereYear('fecha_fin', $añoActual)->get();

            $ponenciasconferenciasRelacionadas = ponenciasconferencia::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
                $query->where('usuario_id', $userID);
            })->whereYear('fecha_fin', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
            })->get();

    ////Docencia
        $docencias = docencia::where('nombre_persona', $user->usuario)
            ->whereYear('fecha_fin', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
            })->get();

    ////Libros
        $libros = libro::where('nombre_persona', $user->usuario)
            ->whereYear('created_at', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('created_at', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('created_at', $this->getEndMonthOfBimester($bimestreActual));
            })->get();

            $librosRelacionados = libro::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
                $query->where('usuario_id', $userID);
            })->whereYear('created_at', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('created_at', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('created_at', $this->getEndMonthOfBimester($bimestreActual));})->get();

    ////////////////Fin de los modulos de difusión//////////

    //Cursos en los que participa
        $cursosR = cursorecibido::where('nombre_persona', $user->usuario)
        ->whereYear('fecha_fin', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        $cursosRelacionados = cursorecibido::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fecha_fin', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));})
            ->get();


    //Postgrados en los que participa
        $postgrados = postgrado::where('nombre_persona', $user->usuario)
        ->get()
        ->map(function ($item) {

            // Calcular los años y bimestres para cada registro
            $fechas = [$item->fecha_inicio, $item->fechaT_titulacion];
            $aniosBimestres = [];

            foreach ($fechas as $fecha) {
                $date = new \DateTime($fecha); // Añadir la barra invertida para indicar que es una clase global

                $anio = $date->format('Y');
                $mes = $date->format('n');
                $bimestre = ceil($mes / 2);

                // Añadir al array todos los bimestres entre fecha_inicio y fechaT_titulacion
                $fechaFin = new \DateTime($item->fechaT_titulacion);
                while ($date <= $fechaFin) {
                    $bimestre = ceil($date->format('n') / 2);
                    $aniosBimestres[$date->format('Y')][$bimestre] = true;
                    $date->add(new \DateInterval('P1M')); // Agregar un mes
                }
            }

            // Añadir el array al objeto
            $item->aniosBimestres = $aniosBimestres;

            return $item;
        });


    //Tesis en las que participa
        $tesis = tesi::where('nombre_alumno', $user->usuario)
        ->get()
        ->map(function ($item) {

            // Calcular los años y bimestres para cada registro
            $fechas = [$item->fecha_inicio, $item->fechaT_titulacion];
            $aniosBimestres = [];

            foreach ($fechas as $fecha) {
                $date = new \DateTime($fecha); // Añadir la barra invertida para indicar que es una clase global

                $anio = $date->format('Y');
                $mes = $date->format('n');
                $bimestre = ceil($mes / 2);

                // Añadir al array todos los bimestres entre fecha_inicio y fechaT_titulacion
                $fechaFin = new \DateTime($item->fechaT_titulacion);
                while ($date <= $fechaFin) {
                    $bimestre = ceil($date->format('n') / 2);
                    $aniosBimestres[$date->format('Y')][$bimestre] = true;
                    $date->add(new \DateInterval('P1M')); // Agregar un mes
                }
            }

            // Añadir el array al objeto
            $item->aniosBimestres = $aniosBimestres;

            return $item;
        });


    //Otras actividades en las que participa
        $otraactivida = otraactivida::where('nombre_persona', $user->usuario)
        ->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

    // Obtener las otras actividades relacionadas a través de la tabla intermedia
        $otraactividaRelacionados = otraactivida::whereHas('usuariosQuePuedenVisualizar', function ($query) use ($userID) {
            $query->where('usuario_id', $userID);
        })->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
            ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));})->get();

            $fechabimestreC = User::find($userID); // Obtener el registro con id=1

    // Comprobar si se encontró un registro con el id=1
        if ($fechabimestreC) {
            $año = $fechabimestreC->año;
            $bimestre = $fechabimestreC->bimestre;

            // Crear una cadena que combine el bimestre y el año
            $periodoConsultado = $bimestre . "  " . $año;
        } else {
            // Manejar el caso en el que no se encuentra un registro con id=1
            $periodoConsultado = "No encontrado";
        }

        $yearactual = date('y');
        $mesactual = date('m');
        $mes = 0;
        switch ($fechabimestre->bimestre) {
            case "Enero-Febrero":
                $mes = 1;
              break;
            case "Marzo-Abril":
                $mes = 2;
              break;
            case "Mayo-Junio":
                $mes = 3;
              break;
            case "Julio-Agosto":
                $mes = 4;
              break;
            case "Septiembre-Octubre":
                $mes = 5;
              break;
            case "Noviembre-Diciembre":
                $mes = 6;
              break;
        };

        $letra = substr($userData->Nombre, 0, 1);
        $unir = strtoupper($letra).strtoupper($userData->Apellido_Paterno).'_'.$mes.'B'.$yearactual;

        $data = [
            'reuniones' => $reuniones,
            'reunionesRelacionadas' => $reunionesRelacionadas,
            'comites' => $comites,
            'comitesRelacionadas' => $comitesRelacionadas,
            'solicitudes' => $solicitudes,
            'solicitudesRelacionadas' => $solicitudesRelacionadas,
            'userData' => $userData,
            'cursosR' => $cursosR,
            'cursosRelacionados' => $cursosRelacionados,
            'postgrados' => $postgrados,
            'tesis' => $tesis,
            'otraactivida' => $otraactivida,
            'otraactividaRelacionados' => $otraactividaRelacionados,
            'serviciotecnologico' => $serviciotecnologico,
            'serviciotecnologicoRelacionadas' => $serviciotecnologicoRelacionadas,
            'fcoordinador' => $fcoordinador,
            'periodoConsultado' => $periodoConsultado,
            'revistas' => $revistas,
            'revistaRelacionados' => $revistaRelacionados,
            'memorias' => $memorias,
            'memoriaRelacionados' => $memoriaRelacionados,
            'ponenciasconferencias' => $ponenciasconferencias,
            'ponenciasconferenciasRelacionadas' => $ponenciasconferenciasRelacionadas,
            'docencias' => $docencias,
            'libros' => $libros,
            'librosRelacionados' => $librosRelacionados,
            'proyectos' => $proyectos,
            'proyectosfin' => $proyectosfin,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            'startDateInicio' => $startDateInicio,
            'startDateFin' => $startDateFin,
            'curpUsuario' => $curpUsuario,
            'documentos' => $documentos,
            'boletines' => $boletines,
            'participantes' => $participantes,
            'nombresParticipantes' => $nombresParticipantes,
            'nombresParticipantesII' => $nombresParticipantesII,
        ];

        $userInfo = User::all();
    // Generar el PDF con las consultas
        $pdf = PDF::loadView('SIRB.reportes.reporteusuario2', $data, compact('userInfo'));
        //Visualizar, guardar y imprir el pdf:
        return $pdf->download($unir.'.pdf');

        //Descargar el pdf:
        //return $pdf-> download ('reportebimestral.pdf');
}
////////////////////////////Terminan las funciones del modulo de reportes////////////////////////////


public function reporteACVN(request $request){

    $userID = $request->session()->get('LoginId');
    $user = User::find($userID);
    $idarea = $user->idarea;
    $userData = DB::table('usuarios')
    ->join('puesto', 'usuarios.idpuesto', '=', 'puesto.id')
    ->join('area_adscripcion', 'usuarios.idarea', '=', 'area_adscripcion.id')
    ->select(
        'usuarios.idarea',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno',
        'puesto.puesto as Plaza',
        'area_adscripcion.nombre_area as Area'
    )
    ->where('usuarios.id', $userID)
    ->first();

    $fechabimestreC = User::find($userID); // Obtener el registro con id=1
    if ($fechabimestreC) {
        $año = $fechabimestreC->año;
        $bimestre = $fechabimestreC->bimestre;

        // Crear una cadena que combine el bimestre y el año
        $periodoConsultado = $bimestre . "  " . $año;
    } else {
        // Manejar el caso en el que no se encuentra un registro con id=1
        $periodoConsultado = "No encontrado";
    }

    //fechas para el filtrado

    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;

    $mesInicioBimestre = $this->getStartMonthOfBimester($fechabimestre2->bimestre);
    $mesFinBimestre = $this->getEndMonthOfBimester($fechabimestre2->bimestre);


    $reuniones = reunion::where('area', $idarea)
    ->whereYear('fecha_reunion', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha_reunion', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha_reunion', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

    $proyectos = DB::table('proyectos')
        ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
        ->where('proyectos.idarea', $idarea)
        ->get()
        ->map(function ($item) {

            // Calcular los años y bimestres para cada registro
            $fechas = [$item->fecha_inicio, $item->fecha_fin];
            $aniosBimestres = [];

            foreach ($fechas as $fecha) {
                $date = new \DateTime($fecha); // Añadir la barra invertida para indicar que es una clase global

                $anio = $date->format('Y');
                $mes = $date->format('n');
                $bimestre = ceil($mes / 2);

                // Añadir al array todos los bimestres entre fecha_inicio y fecha_fin
                $fechaFin = new \DateTime($item->fecha_fin);
                while ($date <= $fechaFin) {
                    $bimestre = ceil($date->format('n') / 2);
                    $aniosBimestres[$date->format('Y')][$bimestre] = true;
                    $date->add(new \DateInterval('P1M')); // Agregar un mes
                }
            }

            // Añadir el array al objeto
            $item->aniosBimestres = $aniosBimestres;

            return $item;
        });

    // Consulta para obtener usuarios en un área específica
    $usuariosA = DB::table('usuarios')
    ->where('idarea', $idarea)
    ->pluck('id');  // Pluck para obtener un array de IDs de usuario

    // Consulta para obtener proyectos según los usuarios y una condición adicional
    $prmI = DB::table('proyectos')
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->whereIn('proyectos.idusuarior', $usuariosA)
    ->where('proyectos.clavea', 'M')
    ->get()
    ->map(function ($item) {

        // Calcular los años y bimestres para cada registro
        $fechas = [$item->fecha_inicio, $item->fecha_fin];
        $aniosBimestres = [];

        foreach ($fechas as $fecha) {
            $date = new \DateTime($fecha); // Añadir la barra invertida para indicar que es una clase global

            $anio = $date->format('Y');
            $mes = $date->format('n');
            $bimestre = ceil($mes / 2);

            // Añadir al array todos los bimestres entre fecha_inicio y fecha_fin
            $fechaFin = new \DateTime($item->fecha_fin);
            while ($date <= $fechaFin) {
                $bimestre = ceil($date->format('n') / 2);
                $aniosBimestres[$date->format('Y')][$bimestre] = true;
                $date->add(new \DateInterval('P1M')); // Agregar un mes
            }
        }

        // Añadir el array al objeto
        $item->aniosBimestres = $aniosBimestres;

        return $item;
    });


    $yearactual = date('y');
    $mesactual = date('m');
    $mes = 0;
    switch ($fechabimestre->bimestre) {
        case "Enero-Febrero":
            $mes = 1;
          break;
        case "Marzo-Abril":
            $mes = 2;
          break;
        case "Mayo-Junio":
            $mes = 3;
          break;
        case "Julio-Agosto":
            $mes = 4;
          break;
        case "Septiembre-Octubre":
            $mes = 5;
          break;
        case "Noviembre-Diciembre":
            $mes = 6;
          break;
    };

    $unir = 'VINCULACION_'.$mes.'B'.$yearactual;

    //dd($prmI);

    //dd($proyectos);

    $pdf = PDF::loadView('SIRB.reportes.accionesVinculacion',compact('periodoConsultado','userData','reuniones','proyectos', 'fechabimestre', 'fechabimestre2', 'mesInicioBimestre', 'mesFinBimestre'
    ,'usuariosA','prmI'));

        //Visualizar, guardar y imprir el pdf:
        $pdf->setPaper('A4','landscape');
        return $pdf->download($unir.'.pdf');

        //Descargar el pdf:
        //$pdf->setPaper('A4','landscape');
        //return $pdf-> download ('accionesVinculacion.pdf');
}

public function reporteACDF(request $request){
    $userID = $request->session()->get('LoginId');
    $user = User::find($userID);
    $areatraer = $user->idarea;
    $idarea= User::find($userID)->idarea;
    
    $userData = DB::table('usuarios')
        ->join('puesto', 'usuarios.idpuesto', '=', 'puesto.id')
        ->join('area_adscripcion', 'usuarios.idarea', '=', 'area_adscripcion.id')
        ->select(
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
            'puesto.puesto as Plaza',
            'area_adscripcion.nombre_area as Area'
        )
        ->where('usuarios.id', $userID)
        ->first();

    $fcoordinador = DB::table('usuarios as u')
        ->join('usuarios as c', function ($join) use ($userID) {
            $join->on('u.idarea', '=', 'c.idarea')
                ->where('c.responsable', '=', 1);
                // ->where('c.id', '<>', $userID); // Excluir al usuario actual
        })
        ->join('area_adscripcion as a', 'c.idarea', '=', 'a.id')
        ->select(
            'c.Nombre as NombreCoordinador',
            'c.Apellido_Paterno as ApellidoPaternoCoordinador',
            'c.Apellido_Materno as ApellidoMaternoCoordinador',
            'a.nombre_area as Area'
        )
        ->where('u.id', $userID)
        ->first();

        $fechabimestreC = User::find($userID); // Obtener el registro con id=1
        if ($fechabimestreC) {
        $año = $fechabimestreC->año;
        $bimestre = $fechabimestreC->bimestre;

        // Crear una cadena que combine el bimestre y el año
        $periodoConsultado = $bimestre . "  " . $año;
    } else {
        // Manejar el caso en el que no se encuentra un registro con id=1
        $periodoConsultado = "No encontrado";
    }


    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;

    $mesInicioBimestre = $this->getStartMonthOfBimester($fechabimestre2->bimestre);
    $mesFinBimestre = $this->getEndMonthOfBimester($fechabimestre2->bimestre);

    $curpUsuario = $user->curp;
        $startDateInicio = $this->getStartMonthOfBimester($bimestreActual);
        $startDateFin = $this->getEndMonthOfBimester($bimestreActual);

    $usuarios = User::where('idarea', $idarea)->where('status', 1)->Orderby('nombre','ASC')->get();
    foreach ($usuarios as $use){
        $usuario = $use->usuario;

        $CountRevistasindnac = DB::table('revistas')
            ->join ('usuarios', 'usuarios.usuario', '=', 'revistas.nombre_persona')
            ->where('revistas.tipo_articulo', 'Indizado')
            ->where('revistas.tipo_revista', 'Nacional con arbitraje')
            ->where('revistas.nombre_persona', $usuario)
            ->whereYear('revistas.fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('revistas.fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('revistas.fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        $CountMemoriasindnac = DB::table('memorias')
            ->join ('usuarios', 'usuarios.usuario', '=', 'memorias.nombre_persona')
            ->where('memorias.tipo_memoria', 'Nacional con arbitraje')
            ->where('memorias.nombre_persona', $usuario)
            ->whereYear('memorias.fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('memorias.fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('memorias.fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        // 

        $CountRevistasindinter = DB::table('revistas')
            ->join ('usuarios', 'usuarios.usuario', '=', 'revistas.nombre_persona')
            ->where('revistas.tipo_articulo', 'Indizado')
            ->where('revistas.tipo_revista', 'Internacional con arbitraje')
            ->where('revistas.nombre_persona', $usuario)
            ->whereYear('revistas.fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('revistas.fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('revistas.fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        $CountMemoriasindinter = DB::table('memorias')
            ->join ('usuarios', 'usuarios.usuario', '=', 'memorias.nombre_persona')
            ->where('memorias.tipo_memoria', 'Internacional con arbitraje')
            ->where('memorias.nombre_persona', $usuario)
            ->whereYear('memorias.fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('memorias.fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('memorias.fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        // 

        $CountRevistasnoindnac = DB::table('revistas')
            ->join ('usuarios', 'usuarios.usuario', '=', 'revistas.nombre_persona')
            ->where('revistas.tipo_articulo', 'Indizado')
            ->where('revistas.tipo_revista', 'Nacional sin arbitraje')
            ->where('revistas.nombre_persona', $usuario)
            ->whereYear('revistas.fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('revistas.fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('revistas.fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        $CountMemoriasnoindnac = DB::table('memorias')
            ->join ('usuarios', 'usuarios.usuario', '=', 'memorias.nombre_persona')
            ->where('memorias.tipo_memoria', 'Nacional sin arbitraje')
            ->where('memorias.nombre_persona', $usuario)
            ->whereYear('memorias.fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('memorias.fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('memorias.fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        // 

        
        $CountRevistasnoindinter = DB::table('revistas')
            ->join ('usuarios', 'usuarios.usuario', '=', 'revistas.nombre_persona')
            ->where('revistas.tipo_articulo', 'Indizado')
            ->where('revistas.tipo_revista', 'Internacional sin arbitraje')
            ->where('revistas.nombre_persona', $usuario)
            ->whereYear('revistas.fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('revistas.fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('revistas.fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        $CountMemoriasnoindinter = DB::table('memorias')
            ->join ('usuarios', 'usuarios.usuario', '=', 'memorias.nombre_persona')
            ->where('memorias.tipo_memoria', 'Internacional sin arbitraje')
            ->where('memorias.nombre_persona', $usuario)
            ->whereYear('memorias.fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('memorias.fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('memorias.fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();


        $use->crevistaind = $CountRevistasindnac+$CountMemoriasindnac;
        $use->crevistanoind = $CountRevistasnoindnac+$CountMemoriasnoindnac;
        $use->crevistaindint = $CountRevistasindinter+$CountMemoriasindinter;
        $use->crevistanoindint = $CountRevistasnoindinter+$CountMemoriasnoindinter;

        $conteoBoletines = DB::connection('mysql2')
            ->table('imt_bol_articulo')
            ->join('imt_bol_boletin', 'imt_bol_boletin.ID_BOL_Boletin', '=', 'imt_bol_articulo.ID_BOL_Boletin')
            ->join('imt_bol_autorarticulo', 'imt_bol_autorarticulo.ID_BOL_Articulo', '=', 'imt_bol_articulo.ID_BOL_Articulo')
            ->join('imt_gen_autor', 'imt_gen_autor.ID_GEN_Autor', '=', 'imt_bol_autorarticulo.ID_GEN_Autor')
            ->join( 'siapimt2.usuarios' ,'usuarios.curp' ,'=' ,'imt_gen_autor.curp')
            // ->where('imt_bol_boletin.Anio', '>=', $año . '-01-01')
            // ->where('imt_bol_boletin.Anio', '<=', $año . '-12-31')
            ->whereYear('imt_bol_boletin.Anio', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('imt_bol_boletin.Anio', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('imt_bol_boletin.Anio', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->where('usuarios.idarea', $idarea)
            ->where('usuarios.usuario', $usuario)
            ->where('imt_bol_autorarticulo.Jerarquia', 0)
            ->count();

        $use->boletines = $conteoBoletines;

        //

        $conteoPonenciainv = DB::table('ponenciasconferencias')
            ->join ('usuarios', 'usuarios.usuario', '=', 'ponenciasconferencias.nombre_persona')
            ->where('ponenciasconferencias.tipo_participacion', 'Invitación')
            ->where('ponenciasconferencias.nombre_persona', $usuario)
            ->whereYear('ponenciasconferencias.fecha_part_ponente', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('ponenciasconferencias.fecha_part_ponente', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('ponenciasconferencias.fecha_part_ponente', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        $conteoPonenciainvcon = DB::table('ponenciasconferencias')
            ->join ('usuarios', 'usuarios.usuario', '=', 'ponenciasconferencias.nombre_persona')
            ->where('ponenciasconferencias.tipo_participacion', 'Iniciativa propia con arbitraje')
            ->where('ponenciasconferencias.nombre_persona', $usuario)
            ->whereYear('ponenciasconferencias.fecha_part_ponente', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('ponenciasconferencias.fecha_part_ponente', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('ponenciasconferencias.fecha_part_ponente', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        $conteoPonenciainvsin = DB::table('ponenciasconferencias')
            ->join ('usuarios', 'usuarios.usuario', '=', 'ponenciasconferencias.nombre_persona')
            ->where('ponenciasconferencias.tipo_participacion', 'Iniciativa propia sin arbitraje')
            ->where('ponenciasconferencias.nombre_persona', $usuario)
            ->whereYear('ponenciasconferencias.fecha_part_ponente', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('ponenciasconferencias.fecha_part_ponente', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('ponenciasconferencias.fecha_part_ponente', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->count();

        
        $use->poninv = $conteoPonenciainv;
        $use->poncon = $conteoPonenciainvcon;
        $use->ponsin = $conteoPonenciainvsin;

        //

        $conteopblicacion = DB::connection('mysql2')
            ->table('imt_pub_publicacion')
            ->join('imt_pub_autorpublicacion', 'imt_pub_autorpublicacion.ID_PUB_Publicacion', '=', 'imt_pub_publicacion.ID_PUB_Publicacion')
            ->join('imt_gen_autor', 'imt_gen_autor.ID_GEN_Autor', '=', 'imt_pub_autorpublicacion.ID_GEN_Autor')
            ->join( 'siapimt2.usuarios' ,'usuarios.curp' ,'=' ,'imt_gen_autor.curp')
            // ->where('imt_pub_publicacion.Anio', '>=', $año . '-01-01')
            // ->where('imt_pub_publicacion.Anio', '<=', $año . '-12-31')
            ->whereYear('imt_pub_publicacion.Anio', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('imt_pub_publicacion.Anio', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('imt_pub_publicacion.Anio', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->where('usuarios.idarea', $idarea)
            ->where('usuarios.usuario', $usuario)
            ->where('imt_pub_autorpublicacion.Jerarquia', 0)
            ->count();

        $use->publicacion = $conteopblicacion;
    }
    $usuarios;

   
    //Filtrado//

    $ponenciasconferencias = DB::table('ponenciasconferencias')
    ->join('usuarios', 'ponenciasconferencias.area', '=', 'usuarios.idarea')
    ->where('usuarios.id', $userID)
    ->whereYear('fecha_fin', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        // para comentar lo seleccionado ctrl+k+c  para descomentar ctrl+k+g
        // $countPC = DB::table('ponenciasconferencias')
        //     ->select('tipo_participacion', DB::raw('count(*) as count'))
        //     ->groupBy('tipo_participacion')
        //     ->get();


        $countPC = DB::table('ponenciasconferencias')
                    ->select('tipo_participacion', DB::raw('count(*) as count'))
                    ->where('area', $areatraer) // Agrega la condición de área aquí
                    ->whereYear('fecha_fin', $añoActual)
                    ->where(function ($query) use ($bimestreActual) {
                        $query->whereMonth('fecha_fin', $this->getStartMonthOfBimester($bimestreActual))
                            ->orWhereMonth('fecha_fin', $this->getEndMonthOfBimester($bimestreActual));
                    })
                    ->groupBy('tipo_participacion')
                    ->get();



    $revistas = DB::table('revistas')
    ->join('usuarios', 'revistas.area', '=', 'usuarios.idarea')
    ->where('usuarios.id', $userID)
    ->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        $countRV = DB::table('revistas')
            ->select('tipo_revista', DB::raw('count(*) as count'))
            ->where('area', $areatraer) // Agrega la condición de área aquí
            ->whereYear('fecha', $añoActual)
            ->where(function ($query) use ($bimestreActual) {
                $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                    ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
            })
            ->groupBy('tipo_revista')
            ->get();

    $memorias = DB::table('memorias')
    ->join('usuarios', 'memorias.area', '=', 'usuarios.idarea')
    ->where('usuarios.id', $userID)
    ->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        $countMM = DB::table('memorias')
        ->select('tipo_memoria', DB::raw('count(*) as count'))
        ->where('area', $areatraer) // Agrega la condición de área aquí
        ->whereYear('fecha', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fecha', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fecha', $this->getEndMonthOfBimester($bimestreActual));
        })
        ->groupBy('tipo_memoria')
        ->get();



    // Boletínes

    $boletines = DB::select("
        SELECT
            usuarios.*,
            imt_bol_boletin.*,
            imt_bol_articulo.*,
            imt_gen_coordinacion.*,
            imt_bol_autorarticulo.*
        FROM usuarios
            JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
            JOIN siapimt25.imt_bol_autorarticulo ON imt_gen_autor.ID_GEN_Autor = imt_bol_autorarticulo.ID_GEN_Autor
            JOIN siapimt25.imt_bol_articulo ON imt_bol_autorarticulo.ID_BOL_Articulo = imt_bol_articulo.ID_BOL_Articulo
            JOIN siapimt25.imt_bol_boletin ON imt_bol_articulo.ID_BOL_Boletin = imt_bol_boletin.ID_BOL_Boletin
            JOIN siapimt25.imt_gen_coordinacion ON imt_bol_boletin.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
        WHERE usuarios.idarea = ?
            AND (MONTH(imt_bol_boletin.Anio) = ? OR MONTH(imt_bol_boletin.Anio) = ?)
            AND YEAR(imt_bol_boletin.Anio) = ?
    ", [$areatraer, $startDateInicio, $startDateFin, $añoActual]);

    $participantes = DB::select("
        SELECT
            imt_bol_autorarticulo.ID_BOL_Articulo,
            GROUP_CONCAT(imt_gen_autor.Nombre, ' ', imt_gen_autor.Apellidos) AS NombresParticipantes
        FROM siapimt25.imt_gen_autor
            JOIN siapimt25.imt_bol_autorarticulo ON imt_gen_autor.ID_GEN_Autor = imt_bol_autorarticulo.ID_GEN_Autor
            JOIN siapimt25.imt_bol_articulo ON imt_bol_autorarticulo.ID_BOL_Articulo = imt_bol_articulo.ID_BOL_Articulo
            JOIN siapimt25.imt_bol_boletin ON imt_bol_articulo.ID_BOL_Boletin = imt_bol_boletin.ID_BOL_Boletin
            JOIN siapimt25.imt_gen_coordinacion ON imt_bol_boletin.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
        WHERE (MONTH(imt_bol_boletin.Anio) = ? OR MONTH(imt_bol_boletin.Anio) = ?) AND YEAR(imt_bol_boletin.Anio) = ?
        GROUP BY imt_bol_autorarticulo.ID_BOL_Articulo
    ", [$startDateInicio, $startDateFin, $añoActual]);


    // Acceder a los nombres de los participantes
    $nombresParticipantes = [];

    foreach ($participantes as $participante) {
        $nombresParticipantes[$participante->ID_BOL_Articulo] = $participante->NombresParticipantes;
    }

    $contadorBoletines = DB::select("
    SELECT
        COUNT(DISTINCT imt_bol_boletin.ID_BOL_Boletin) as contador
    FROM usuarios
        JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
        JOIN siapimt25.imt_bol_autorarticulo ON imt_gen_autor.ID_GEN_Autor = imt_bol_autorarticulo.ID_GEN_Autor
        JOIN siapimt25.imt_bol_articulo ON imt_bol_autorarticulo.ID_BOL_Articulo = imt_bol_articulo.ID_BOL_Articulo
        JOIN siapimt25.imt_bol_boletin ON imt_bol_articulo.ID_BOL_Boletin = imt_bol_boletin.ID_BOL_Boletin
        JOIN siapimt25.imt_gen_coordinacion ON imt_bol_boletin.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
    WHERE usuarios.idarea = ?
        AND (MONTH(imt_bol_boletin.Anio) = ? OR MONTH(imt_bol_boletin.Anio) = ?)
        AND YEAR(imt_bol_boletin.Anio) = ?
    ", [$areatraer, $startDateInicio, $startDateFin, $añoActual])[0]->contador;


    $documentos = DB::select("
    SELECT
        usuarios.*,
        imt_pub_publicacion.*,
        imt_pub_tipopublicacion.*,
        imt_pub_autorpublicacion.*
    FROM usuarios
        JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
        JOIN siapimt25.imt_pub_autorpublicacion ON imt_gen_autor.ID_GEN_Autor = imt_pub_autorpublicacion.ID_GEN_Autor
        JOIN siapimt25.imt_pub_publicacion ON imt_pub_autorpublicacion.ID_PUB_Publicacion = imt_pub_publicacion.ID_PUB_Publicacion
        JOIN siapimt25.imt_pub_tipopublicacion ON imt_pub_publicacion.id_pub_tipoPublicacion = imt_pub_tipopublicacion.id_pub_tipoPublicacion
        JOIN siapimt25.imt_gen_coordinacion ON imt_pub_publicacion.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
    WHERE
    usuarios.idarea = ?
        AND (MONTH(imt_pub_publicacion.Anio) = ? OR MONTH(imt_pub_publicacion.Anio) = ?)
        AND YEAR(imt_pub_publicacion.Anio) = ?
    ", [$areatraer, $startDateInicio, $startDateFin, $añoActual]);

        $participantesII = DB::select("
        SELECT
            imt_pub_autorpublicacion.ID_PUB_Publicacion,
            GROUP_CONCAT(imt_gen_autor.Nombre, ' ', imt_gen_autor.Apellidos) AS NombresParticipantes
        FROM siapimt25.imt_gen_autor
            JOIN siapimt25.imt_pub_autorpublicacion ON imt_gen_autor.ID_GEN_Autor = imt_pub_autorpublicacion.ID_GEN_Autor
            JOIN siapimt25.imt_pub_publicacion ON imt_pub_autorpublicacion.ID_PUB_Publicacion = imt_pub_publicacion.ID_PUB_Publicacion
        WHERE (MONTH(imt_pub_publicacion.Anio) = ? OR MONTH(imt_pub_publicacion.Anio) = ?) AND YEAR(imt_pub_publicacion.Anio) = ?
        GROUP BY imt_pub_autorpublicacion.ID_PUB_Publicacion
    ", [$startDateInicio, $startDateFin, $añoActual]);

    // Acceder a los nombres de los participantes
    $nombresParticipantesII = [];
    foreach ($participantesII as $participante) {
        $nombresParticipantesII[$participante->ID_PUB_Publicacion] = $participante->NombresParticipantes;
    }

    $contadorDocumentos = DB::select("
    SELECT
        COUNT(DISTINCT imt_pub_publicacion.ID_PUB_Publicacion) as contador
    FROM usuarios
        JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
        JOIN siapimt25.imt_pub_autorpublicacion ON imt_gen_autor.ID_GEN_Autor = imt_pub_autorpublicacion.ID_GEN_Autor
        JOIN siapimt25.imt_pub_publicacion ON imt_pub_autorpublicacion.ID_PUB_Publicacion = imt_pub_publicacion.ID_PUB_Publicacion
        JOIN siapimt25.imt_pub_tipopublicacion ON imt_pub_publicacion.id_pub_tipoPublicacion = imt_pub_tipopublicacion.id_pub_tipoPublicacion
        JOIN siapimt25.imt_gen_coordinacion ON imt_pub_publicacion.ID_GEN_Coordinacion = imt_gen_coordinacion.ID_GEN_Coordinacion
    WHERE
        usuarios.idarea = ?
        AND (MONTH(imt_pub_publicacion.Anio) = ? OR MONTH(imt_pub_publicacion.Anio) = ?)
        AND YEAR(imt_pub_publicacion.Anio) = ?
    ", [$areatraer, $startDateInicio, $startDateFin, $añoActual])[0]->contador;

    $yearactual = date('y');
    $mesactual = date('m');
    $mes = 0;
    switch ($fechabimestre->bimestre) {
        case "Enero-Febrero":
            $mes = 1;
          break;
        case "Marzo-Abril":
            $mes = 2;
          break;
        case "Mayo-Junio":
            $mes = 3;
          break;
        case "Julio-Agosto":
            $mes = 4;
          break;
        case "Septiembre-Octubre":
            $mes = 5;
          break;
        case "Noviembre-Diciembre":
            $mes = 6;
          break;
    };
        $unir = 'DIFUSION_'.$mes.'B'.$yearactual;

    $pdf = PDF::loadView('SIRB.reportes.accionesDifusion',compact('userData','fcoordinador','periodoConsultado',
    'ponenciasconferencias','countPC','revistas','countRV','memorias','countMM','participantes','nombresParticipantes',
    'boletines','documentos','participantesII','nombresParticipantesII','contadorBoletines','contadorDocumentos','usuarios'
    ));

        //Visualizar, guardar y imprir el pdf:
        $pdf->setPaper('A4','landscape');
        return $pdf->download($unir.'.pdf');

        //Descargar el pdf:
        //$pdf->setPaper('A4','landscape');
        //return $pdf-> download ('accionesDifusion.pdf');
}

public function reporteACCM(request $request){
    $userID = $request->session()->get('LoginId');
    $user = User::find($userID);
    $userData = DB::table('usuarios')
    ->join('puesto', 'usuarios.idpuesto', '=', 'puesto.id')
    ->join('area_adscripcion', 'usuarios.idarea', '=', 'area_adscripcion.id')
    ->select(
        'usuarios.idarea',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno',
        'puesto.puesto as Plaza',
        'area_adscripcion.nombre_area as Area'
    )
    ->where('usuarios.id', $userID)
    ->first();

    $fechabimestreC = User::find($userID); // Obtener el registro con id=1
    if ($fechabimestreC) {
        $año = $fechabimestreC->año;
        $bimestre = $fechabimestreC->bimestre;

        // Crear una cadena que combine el bimestre y el año
        $periodoConsultado = $bimestre . "  " . $año;
    } else {
        // Manejar el caso en el que no se encuentra un registro con id=1
        $periodoConsultado = "No encontrado";
    }

    //fechas para el filtrado

    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;

    $mesInicioBimestre = $this->getStartMonthOfBimester($fechabimestre2->bimestre);
    $mesFinBimestre = $this->getEndMonthOfBimester($fechabimestre2->bimestre);


    $comites = DB::table('comites')
    ->where('area', $userData->idarea)
    ->whereYear('created_at', $añoActual)
        ->where(function ($query) use ($bimestreActual) {
            $query->whereMonth('fechas', $this->getStartMonthOfBimester($bimestreActual))
                ->orWhereMonth('fechas', $this->getEndMonthOfBimester($bimestreActual));
        })->get();

        $yearactual = date('y');
        $mesactual = date('m');
        $mes = 0;
        switch ($fechabimestre->bimestre) {
            case "Enero-Febrero":
                $mes = 1;
              break;
            case "Marzo-Abril":
                $mes = 2;
              break;
            case "Mayo-Junio":
                $mes = 3;
              break;
            case "Julio-Agosto":
                $mes = 4;
              break;
            case "Septiembre-Octubre":
                $mes = 5;
              break;
            case "Noviembre-Diciembre":
                $mes = 6;
              break;
        };
        $unir = 'COMITES_'.$mes.'B'.$yearactual;

        $pdf = PDF::loadView('SIRB.reportes.accionesComites',compact('periodoConsultado','userData','comites'));
        //Visualizar, guardar y imprir el pdf:
        $pdf->setPaper('A4','landscape');
        return $pdf->download($unir.'.pdf');

        //Descargar el pdf:
        //$pdf->setPaper('A4','landscape');
        //return $pdf-> download ('accionesComites.pdf');
}

public function reporteConfigIndicadores(request $request){

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);

        $idarea= User::find($userID)->idarea;

        // Obtener el nombre completo del usuario autenticado
        $nombreCompleto = $user->Nombre . ' ' . $user->Apellido_Paterno . ' ' . $user->Apellido_Materno;

        $nombrearea = DB::table('area_adscripcion')->where('id', $idarea)->first();

        $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

        //recupera el dato del select sexenio
        $sexenio = $request->input('sexenio');

        // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
        $rangoDeAños = range($sexenio, $sexenio + 5);

        // Obtener los datos de la base de datos para el rango de años
        $datosParaRango = miconfig::whereBetween('anio', [$sexenio, $sexenio + 5])->get();

        //dd($datosParaRango);

    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'userID' => $userID,
        'nombreCompleto' => $nombreCompleto,
        'fechabimestreP' => $fechabimestreP,
        'sexenio' => $sexenio,
        'rangoDeAños' => $rangoDeAños,
        'datosParaRango' => $datosParaRango,
        'nombrearea' => $nombrearea
    ];



    return view('SIRB/reportes/configindicadores', $data);
}

// public function insertarRegistros20102030()
// {
//     $anios = range(2010, 2030);

//     foreach ($anios as $anio) {
//         MiConfig::create(['anio' => $anio]);
//     }

//     return 'Registros insertados exitosamente.';
// }

public function insertarRegistrosIndicadores(request $request)
{
    // Recupera el dato del input añoReferencia
    $sexenio = $request->input('añoReferencia');

    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);

    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor1 = $request->input("PI1años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['PI1' => $valor1]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor2 = $request->input("CPT1-2años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['CPT1-2' => $valor2]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor3 = $request->input("MIPC3años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['MIPC3' => $valor3]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor4 = $request->input("IPC4años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['IPC4' => $valor4]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor5 = $request->input("PE5años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['PE5' => $valor5]
        );
    }

    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor6 = $request->input("CPT2-6años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['CPT2-6' => $valor6]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor7 = $request->input("MIPEC7años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['MIPEC7' => $valor7]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor8 = $request->input("PIIE8años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['PIIE8' => $valor8]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor9 = $request->input("EL9años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['EL9' => $valor9]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor10 = $request->input("ELC10años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['ELC10' => $valor10]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor11 = $request->input("APRMN11años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['APRMN11' => $valor11]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor12 = $request->input("IAPRMN12años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['IAPRMN12' => $valor12]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor13 = $request->input("APRMI13años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['APRMI13' => $valor13]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor14 = $request->input("IAPRMI14años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['IAPRMI14' => $valor14]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor15 = $request->input("AB15años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['AB15' => $valor15]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor16 = $request->input("IAB16años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['IAB16' => $valor16]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor17 = $request->input("CSC17años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['CSC17' => $valor17]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor18 = $request->input("ICSC18años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['ICSC18' => $valor18]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor19 = $request->input("PT19años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['PT19' => $valor19]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor20 = $request->input("IPT20años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['IPT20' => $valor20]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor21 = $request->input("ACA21años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['ACA21' => $valor21]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor22 = $request->input("IACA22años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['IACA22' => $valor22]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor23 = $request->input("IOGDML23años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['IOGDML23' => $valor23]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor24 = $request->input("IIOGDML24años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['IIOGDML24' => $valor24]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor25 = $request->input("CI25años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['CI25' => $valor25]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor26 = $request->input("ICI26años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['ICI26' => $valor26]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor27 = $request->input("CIR27años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['CIR27' => $valor27]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor28 = $request->input("ICIR28años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['ICIR28' => $valor28]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor29 = $request->input("TITD29años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['TITD29' => $valor29]
        );
    }


    // Itera sobre los años y realiza la inserción en la base de datos
    foreach ($rangoDeAños as $año) {
        // Recupera el valor del select actual
        $valor30 = $request->input("ITITD30años.$año");

        // Actualiza el campo 1PI en la tabla miconfig
        miconfig::updateOrCreate(
            ['anio' => $año],
            ['ITITD30' => $valor30]
        );
    }



    return redirect(route('menureportes'));
}

public function indicadoresrendimiento(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);

    $idarea= User::find($userID)->idarea;

    $nombrearea = DB::table('area_adscripcion')->where('id', $idarea)->first();

    //recupera el dato del select sexenio
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);
    //dd($rangoDeAños);
    // Obtener los datos de la base de datos para el rango de datos
    $datosParaRango = miconfig::whereBetween('anio', [$sexenio, $sexenio + 5])->get();
    //dd($datosParaRango);

    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoProyectosIPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año

        foreach ($rangoDeAños as $año) {
        $conteoProyectosI = Proyecto::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('progreso', 100)
            ->where('idarea', $idarea)
            ->where('clavet', 'I')
            ->count();

        $conteoProyectosMI = Proyecto::join('usuarios', 'usuarios.id', '=', 'proyectos.idusuarior')
            ->where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('proyectos.progreso', 100)
            ->where('proyectos.clavea', 'M')
            ->where('clavet', 'I')
            ->where('usuarios.idarea', $idarea)
            ->count();

        $conteoProys = $conteoProyectosI+ $conteoProyectosMI;

        $conteoProyectosIPorAño[$año] = $conteoProys;
        //dd($conteoProyectosIPorAño);
    }

    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoProyectosIPorAñoFull = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoProyectosIFull = Proyecto::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('idarea', User::find($userID)->idarea)
            ->where('Tipo', 'I')
            ->get();
            //dd($conteoProyectosIFull);

        $proyectosMIE = Proyecto::select('proyectos.*')
            ->join('usuarios', 'usuarios.id', '=', 'proyectos.idusuarior')
            ->where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('proyectos.clavea', 'M')
            ->where('usuarios.idarea', $idarea)
            ->get();

        $proyectosCombinados = $conteoProyectosIFull->merge($proyectosMIE);

        // Almacenar el conteo en el arreglo asociativo
        $conteoProyectosIPorAñoFull[$año] = $proyectosCombinados;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoProyectosEPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoProyectosE = Proyecto::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('progreso', 100)
            ->where('idarea', User::find($userID)->idarea)
            ->where('Tipo', 'E')
            ->count();

        $conteoProyectosME = Proyecto::join('usuarios', 'usuarios.id', '=', 'proyectos.idusuarior')
            ->where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('proyectos.progreso', 100)
            ->where('proyectos.clavea', 'M')
            ->where('clavet', 'E')
            ->where('usuarios.idarea', $idarea)
            ->count();

        // Almacenar el conteo en el arreglo asociativo
        $conteoProyectosEPorAño[$año] = $conteoProyectosE + $conteoProyectosME;
    }

    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoProyectosEPorAñoFull = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoProyectosEFull = Proyecto::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('idarea', User::find($userID)->idarea)
            ->where('Tipo', 'E')
            ->get();
                
        $conteoProyectosEPorAñoFull[$año] = $conteoProyectosEFull;
    }

    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoProyectosEPorAñoGET = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoProyectosEGET = Proyecto::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('progreso', 100)
            ->where('idarea', User::find($userID)->idarea)
            ->where('Tipo', 'E')
            ->get();

        // Almacenar el conteo en el arreglo asociativo
        $conteoProyectosEPorAñoGET[$año] = $conteoProyectosEGET;
    }

    //hacer suma de las variables conteoMemoriasNacionalPorAño y conteoRevistasNacionalPorAño
    $ProyectosIEPorAño = [];
    foreach ($rangoDeAños as $año) {
        $conteoProyectosIE = $conteoProyectosEPorAño[$año] + $conteoProyectosIPorAño[$año];
        $ProyectosIEPorAño[$año] = $conteoProyectosIE;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoServiciosTecnologicosPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoST = serviciotecnologico::where('fechafin', '>=', $año . '-01-01')
            ->where('fechafin', '<=', $año . '-12-31')
            ->where('porcentaje', 100)
            ->where('idarea', User::find($userID)->idarea)
            ->count();

        // Almacenar el conteo en el arreglo asociativo
        $conteoServiciosTecnologicosPorAño[$año] = $conteoST;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoRevistasNacionalPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoRevistasNacional = revista::where('fecha', '>=', $año . '-01-01')
        ->where('fecha', '<=', $año . '-12-31')
        ->where(function ($query) {
            $query->where('tipo_revista', 'Nacional con arbitraje')
                ->orWhere('tipo_revista', 'Nacional sin arbitraje');
        })
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoRevistasNacionalPorAño[$año] = $conteoRevistasNacional;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoMemoriasNacionalPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoMemoriasNacional = memoria::where('fecha', '>=', $año . '-01-01')
        ->where('fecha', '<=', $año . '-12-31')
        ->where(function ($query) {
            $query->where('tipo_memoria', 'Nacional con arbitraje')
                ->orWhere('tipo_memoria', 'Nacional sin arbitraje');
        })
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoMemoriasNacionalPorAño[$año] = $conteoMemoriasNacional;
    }

    //hacer suma de las variables conteoMemoriasNacionalPorAño y conteoRevistasNacionalPorAño
    $RevistaMemoriaNacionalPorAño = [];
    foreach ($rangoDeAños as $año) {
        $RevistaMemoriaNacional = $conteoMemoriasNacionalPorAño[$año] + $conteoRevistasNacionalPorAño[$año];
        $RevistaMemoriaNacionalPorAño[$año] = $RevistaMemoriaNacional;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoRevistasInternacionalPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoRevistasInternacional = revista::where('fecha', '>=', $año . '-01-01')
        ->where('fecha', '<=', $año . '-12-31')
        ->where(function ($query) {
            $query->where('tipo_revista', 'Internacional con arbitraje')
                ->orWhere('tipo_revista', 'Internacional sin arbitraje');
        })
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoRevistasInternacionalPorAño[$año] = $conteoRevistasInternacional;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoMemoriasInternacionalPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoMemoriasInternacional = memoria::where('fecha', '>=', $año . '-01-01')
        ->where('fecha', '<=', $año . '-12-31')
        ->where(function ($query) {
            $query->where('tipo_memoria', 'Internacional con arbitraje')
                ->orWhere('tipo_memoria', 'Internacional sin arbitraje');
        })
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoMemoriasInternacionalPorAño[$año] = $conteoMemoriasInternacional;
    }

    //hacer suma de las variables conteoMemoriasNacionalPorAño y conteoRevistasNacionalPorAño
    $RevistaMemoriaInternacionalPorAño = [];
    foreach ($rangoDeAños as $año) {
        $RevistaMemoriaInternacional = $conteoMemoriasInternacionalPorAño[$año] + $conteoRevistasInternacionalPorAño[$año];
        $RevistaMemoriaInternacionalPorAño[$año] = $RevistaMemoriaInternacional;
    }


    switch ($idarea) {
        case 1:
            $idcoordinacion = 8;
            break;
        case 2:
            $idcoordinacion = 1;
            break;
        case 3:
            $idcoordinacion = 7;
            break;
        case 4:
            $idcoordinacion = 2;
            break;
        case 5:
            $idcoordinacion = 3;
            break;
        case 6:
            $idcoordinacion = 5;
            break;
        case 7:
            $idcoordinacion = 6;
            break;
        case 8:
            $idcoordinacion = 10;
            break;
        case 9:
            $idcoordinacion = 9;
            break;
        case 10:
            $idcoordinacion = 4;
            break;
        case 11:
            $idcoordinacion = 11;
            break;
        case 12:
            $idcoordinacion = 12;
            break;
        case 13:
            $idcoordinacion = 13;
            break;
        }



    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoBoletinesPorAño = [];

    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {

        $conteoBoletines = \DB::connection('mysql2')
            ->table('imt_bol_articulo')
            ->join('imt_bol_boletin', 'imt_bol_boletin.ID_BOL_Boletin', '=', 'imt_bol_articulo.ID_BOL_Boletin')
            ->join('imt_bol_autorarticulo', 'imt_bol_autorarticulo.ID_BOL_Articulo', '=', 'imt_bol_articulo.ID_BOL_Articulo')
            ->join('imt_gen_autor', 'imt_gen_autor.ID_GEN_Autor', '=', 'imt_bol_autorarticulo.ID_GEN_Autor')
            ->join( 'siapimt2.usuarios' ,'usuarios.curp' ,'=' ,'imt_gen_autor.curp')
            ->where('imt_bol_boletin.Anio', '>=', $año . '-01-01')
            ->where('imt_bol_boletin.Anio', '<=', $año . '-12-31')
            ->where('usuarios.idarea', $idarea)
            ->where('imt_bol_autorarticulo.Jerarquia', 0)
            ->count();

        // Almacenar el conteo en el arreglo asociativo
        $conteoBoletinesPorAño[$año] = $conteoBoletines;
    }

    //dd($conteoBoletinesPorAño);

    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoPonenciasConferenciasPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoPonenciasConferencias = ponenciasconferencia::where('fecha_fin', '>=', $año . '-01-01')
        ->where('fecha_fin', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoPonenciasConferenciasPorAño[$año] = $conteoPonenciasConferencias;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoDocumentosPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoDocumentos = \DB::connection('mysql2')
            ->table('imt_pub_publicacion')
            ->where('Anio', '>=', $año . '-01-01')
            ->where('Anio', '<=', $año . '-12-31')
            ->where('ID_GEN_Coordinacion', $idcoordinacion)
            ->count();

        // Almacenar el conteo en el arreglo asociativo
        $conteoDocumentosPorAño[$año] = $conteoDocumentos;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoReunionPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoReunion = reunion::where('fecha_reunion', '>=', $año . '-01-01')
        ->where('fecha_reunion', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoReunionPorAño[$año] = $conteoReunion;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoSolicitudPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoSolicitud = solicitudes::where('fecha', '>=', $año . '-01-01')
        ->where('fecha', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoSolicitudPorAño[$año] = $conteoSolicitud;
    }

    //hacer suma de las variables conteoMemoriasNacionalPorAño y conteoRevistasNacionalPorAño
    $ReunionSolicitudPorAño = [];
    foreach ($rangoDeAños as $año) {
        $conteoReunionSolicitud = $conteoReunionPorAño[$año] + $conteoSolicitudPorAño[$año];
        $ReunionSolicitudPorAño[$año] = $conteoReunionSolicitud;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoPostgradosPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoPostgrados = postgrado::where('fechaT_titulacion', '>=', $año . '-01-01')
        ->where('fechaT_titulacion', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoPostgradosPorAño[$año] = $conteoPostgrados;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoDocenciaPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoDocencia = docencia::where('fecha_fin', '>=', $año . '-01-01')
        ->where('fecha_fin', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoDocenciaPorAño[$año] = $conteoDocencia;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoTesisPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoTesis = tesi::where('fechaT_titulacion', '>=', $año . '-01-01')
        ->where('fechaT_titulacion', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->where('fase_tesis', '=', 'Terminada')
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoTesisPorAño[$año] = $conteoTesis;
    }


    // Inicializar el arreglo asociativo para almacenar el conteo por año
    $conteoCursosPorAño = [];
    // Iterar sobre el rango de años y obtener el conteo para cada año
    foreach ($rangoDeAños as $año) {
        $conteoCursos = cursorecibido::where('fecha_fin', '>=', $año . '-01-01')
        ->where('fecha_fin', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->count();


        // Almacenar el conteo en el arreglo asociativo
        $conteoCursosPorAño[$año] = $conteoCursos;
    }

    //hacer suma de las variables conteoMemoriasNacionalPorAño y conteoRevistasNacionalPorAño
    $TesisCursosPorAño = [];
    foreach ($rangoDeAños as $año) {
        $conteoTesisCursos = $conteoTesisPorAño[$año] + $conteoDocenciaPorAño[$año];
        $TesisCursosPorAño[$año] = $conteoTesisCursos;
    }


    //dd($TesisCursosPorAño);

    $data = [
        'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
        'userID' => $userID,
        'idarea' => $idarea,
        'nombrearea' => $nombrearea,
        'sexenio' => $sexenio,
        'rangoDeAños' => $rangoDeAños,
        'datosParaRango' => $datosParaRango,
        'conteoProyectosIPorAño' => $conteoProyectosIPorAño,
        'conteoProyectosIPorAñoFull' => $conteoProyectosIPorAñoFull,
        'conteoProyectosEPorAño' => $conteoProyectosEPorAño,
        'conteoProyectosEPorAñoFull' => $conteoProyectosEPorAñoFull,
        'conteoServiciosTecnologicosPorAño' => $conteoServiciosTecnologicosPorAño,
        'RevistaMemoriaNacionalPorAño' => $RevistaMemoriaNacionalPorAño,
        'RevistaMemoriaInternacionalPorAño' => $RevistaMemoriaInternacionalPorAño,
        'conteoBoletinesPorAño' => $conteoBoletinesPorAño,
        'conteoPonenciasConferenciasPorAño' => $conteoPonenciasConferenciasPorAño,
        'conteoDocumentosPorAño' => $conteoDocumentosPorAño,
        'ReunionSolicitudPorAño' => $ReunionSolicitudPorAño,
        'conteoPostgradosPorAño' => $conteoPostgradosPorAño,
        'conteoDocenciaPorAño' => $conteoDocenciaPorAño,
        'TesisCursosPorAño' => $TesisCursosPorAño,
        'conteoCursosPorAño' => $conteoCursosPorAño,
        'ProyectosIEPorAño' => $ProyectosIEPorAño,
    ];

        return view('SIRB/reportes/indicadoresrendimiento', $data);
}

public function indicadorProyectosInternosTablas(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');

    $conteoProyectosIGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'I')
    ->get();

    $conteoProyectosMIGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('usuarios.idarea', $idarea)
    ->where('clavea', '=', 'M' )
    ->where('proyectos.Tipo', 'I')
    ->get();

    $conteoProyectosInternosTodos = $conteoProyectosIGET->merge($conteoProyectosMIGET);

   // Agrupar proyectos por bimestre
   $proyectosPorBimestreI = $conteoProyectosInternosTodos->groupBy(function ($proyecto) {
    $fechaProyecto = strtotime($proyecto->fecha_fin);
    $mesProyecto = date("n", $fechaProyecto);

    

    // Define los bimestres según tu lógica
    $bimestres = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 2,
        5 => 3,
        6 => 3,
        7 => 4,
        8 => 4,
        9 => 5,
        10 => 5,
        11 => 6,
        12 => 6,
    ];

    return $bimestres[$mesProyecto] ?? 0;
    });

    

    //dd($conteoProyectosIGET);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosInternosTodos' => $conteoProyectosInternosTodos,
        'proyectosPorBimestreI' => $proyectosPorBimestreI
    ];


    return view('SIRB/reportes/tablasIndicadores/indicadoresproyectosItabla', $data);
}

public function indicadorProyectosITodosTablas(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');

    $conteoProyectosIGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'I')
    ->get();

    $conteoProyectosMIGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('usuarios.idarea', $idarea)
    ->where('clavea', '=', 'M' )
    ->where('proyectos.Tipo', 'I')
    ->get();

    //PORYECTOS EXTERNOS

    $conteoProyectosEGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'E')
    ->get();

    $conteoProyectosMEGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('usuarios.idarea', $idarea)
    ->where('clavea', '=', 'M' )
    ->where('proyectos.Tipo', 'E')
    ->get();

    $conteoProysInternos = $conteoProyectosIGET->merge($conteoProyectosMIGET);

    $conteoProysExternos = $conteoProyectosEGET->merge($conteoProyectosMEGET);

    $conteoProyectosInternosTodos = $conteoProysInternos->merge($conteoProysExternos);

   // Agrupar proyectos por bimestre
   $proyectosPorBimestreI = $conteoProyectosInternosTodos->groupBy(function ($proyecto) {
    $fechaProyecto = strtotime($proyecto->fecha_fin);
    $mesProyecto = date("n", $fechaProyecto);

    

    // Define los bimestres según tu lógica
    $bimestres = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 2,
        5 => 3,
        6 => 3,
        7 => 4,
        8 => 4,
        9 => 5,
        10 => 5,
        11 => 6,
        12 => 6,
    ];

    return $bimestres[$mesProyecto] ?? 0;
    });

    

    //dd($conteoProyectosIGET);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosIGET' => $conteoProysInternos,
        'proyectosPorBimestreI' => $proyectosPorBimestreI
    ];


    return view('SIRB/reportes/tablasIndicadores/indicadoresproyectosTodostablas', $data);
}

public function indicadorProyectosInternosGrafica(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');

    $conteoProyectosIGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'I')
    ->get();

   // Agrupar proyectos por bimestre
   $proyectosPorBimestreI = $conteoProyectosIGET->groupBy(function ($proyecto) {
    $fechaProyecto = strtotime($proyecto->fecha_fin);
    $mesProyecto = date("n", $fechaProyecto);

    // Define los bimestres según tu lógica
    $bimestres = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 2,
        5 => 3,
        6 => 3,
        7 => 4,
        8 => 4,
        9 => 5,
        10 => 5,
        11 => 6,
        12 => 6,
    ];

    return $bimestres[$mesProyecto] ?? 0;
    })->map(function ($proyectos) {
        return $proyectos->count();
    });

    //dd($proyectosPorBimestreI);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosIGET' => $conteoProyectosIGET,
        'proyectosPorBimestreI' => $proyectosPorBimestreI,
    ];

    return view('SIRB/reportes/graficasindicadores/graficaProyectosI', $data);
}

public function indicadorProyectosIntExtGrafica(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');

    $conteoProyectosIGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'I')
    ->get();

    $conteoProyectosMIGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('usuarios.idarea', $idarea)
    ->where('clavea', '=', 'M' )
    ->where('proyectos.Tipo', 'I')
    ->get();

    $conteoProyectosEGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'E')
    ->get();

    $conteoProyectosMEGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('usuarios.idarea', $idarea)
    ->where('clavea', '=', 'M' )
    ->where('proyectos.Tipo', 'E')
    ->get();

    $conteoProysInternos = $conteoProyectosIGET->merge($conteoProyectosMIGET);

    $conteoProysExternos = $conteoProyectosEGET->merge($conteoProyectosMEGET);

    $conteoProyectosIntExtGraf = $conteoProysInternos->merge($conteoProysExternos);


   // Agrupar proyectos por bimestre
   $proyectosPorBimestreI = $conteoProyectosIntExtGraf->groupBy(function ($proyecto) {
    $fechaProyecto = strtotime($proyecto->fecha_fin);
    $mesProyecto = date("n", $fechaProyecto);

    // Define los bimestres según tu lógica
    $bimestres = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 2,
        5 => 3,
        6 => 3,
        7 => 4,
        8 => 4,
        9 => 5,
        10 => 5,
        11 => 6,
        12 => 6,
    ];

    return $bimestres[$mesProyecto] ?? 0;
    })->map(function ($proyectos) {
        return $proyectos->count();
    });

    //dd($proyectosPorBimestreI);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosIGET' => $conteoProyectosIGET,
        'proyectosPorBimestreI' => $proyectosPorBimestreI,
    ];

    return view('SIRB/reportes/graficasindicadores/graficaProyectosIntExt', $data);
}

public function indicadorProyectosExternosTablas(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');

    $conteoProyectosEGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'E')
    ->get();

    $conteoProyectosMEGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('usuarios.idarea', $idarea)
    ->where('clavea', '=', 'M' )
    ->where('proyectos.Tipo', 'E')
    ->get();

    $conteoProysExternosTodos = $conteoProyectosEGET->merge($conteoProyectosMEGET);

   // Agrupar proyectos por bimestre
   $proyectosPorBimestreE = $conteoProysExternosTodos->groupBy(function ($proyecto) {
    $fechaProyecto = strtotime($proyecto->fecha_fin);
    $mesProyecto = date("n", $fechaProyecto);

    // Define los bimestres según tu lógica
    $bimestres = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 2,
        5 => 3,
        6 => 3,
        7 => 4,
        8 => 4,
        9 => 5,
        10 => 5,
        11 => 6,
        12 => 6,
    ];

    return $bimestres[$mesProyecto] ?? 0;
    });

    //dd($conteoProyectosIGET);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosIGET' => $conteoProysExternosTodos,
        'proyectosPorBimestreE' => $proyectosPorBimestreE
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresproyectosEtabla', $data);
}

public function indicadorProyectosExternosGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');

    $conteoProyectosEGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'E')
    ->get();

    $conteoProyectosMEGET = Proyecto::select(
        'proyectos.*',
        'usuarios.Nombre',
        'usuarios.Apellido_Paterno',
        'usuarios.Apellido_Materno'
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->where('proyectos.fecha_fin', '>=', $año . '-01-01')
    ->where('proyectos.fecha_fin', '<=', $año . '-12-31')
    ->where('proyectos.progreso', 100)
    ->where('usuarios.idarea', $idarea)
    ->where('clavea', '=', 'M' )
    ->where('proyectos.Tipo', 'E')
    ->get();

    $conteoProysExternosTodos = $conteoProyectosEGET->merge($conteoProyectosMEGET);


   // Agrupar proyectos por bimestre
   $proyectosPorBimestreE = $conteoProysExternosTodos->groupBy(function ($proyecto) {
    $fechaProyecto = strtotime($proyecto->fecha_fin);
    $mesProyecto = date("n", $fechaProyecto);

    // Define los bimestres según tu lógica
    $bimestres = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 2,
        5 => 3,
        6 => 3,
        7 => 4,
        8 => 4,
        9 => 5,
        10 => 5,
        11 => 6,
        12 => 6,
    ];

    return $bimestres[$mesProyecto] ?? 0;
    })->map(function ($proyectos) {
        return $proyectos->count();
    });

    //dd($conteoProyectosEGET);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosEGET' => $conteoProysExternosTodos,
        'proyectosPorBimestreE' => $proyectosPorBimestreE
    ];

    return view('SIRB/reportes/graficasIndicadores/graficaProyectosE', $data);
}

public function indicadorServiciosTablas(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



    // Paso 1: Consulta para obtener participantes
    $participantes = serviciotecnologico::select('id', 'participantes')
        ->where('fechafin', '>=', $año . '-01-01')
        ->where('fechafin', '<=', $año . '-12-31')
        ->where('porcentaje', 100)
        ->where('idarea', User::find($userID)->idarea)
        ->get();

    // Verificar si hay resultados antes de continuar
    if ($participantes->isNotEmpty()) {
        // Paso 2: Organizar los IDs de participantes por servicio
        $participantesPorServicio = [];
        foreach ($participantes as $participante) {
            $ids = explode(',', $participante->participantes);
            $participantesPorServicio[$participante->id] = $ids;
        }

        // Paso 3: Obtener nombres de participantes por servicio
        $nombresParticipantesPorServicio = [];
        foreach ($participantesPorServicio as $servicioId => $participantesIds) {
            $nombresParticipantes = DB::table('usuarios')
                ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
                ->whereIn('id', $participantesIds)
                ->get();
            $nombresParticipantesPorServicio[$servicioId] = $nombresParticipantes;
        }

        // Paso 4: Consulta original para obtener servicios
        $conteoServiciosGET = serviciotecnologico::where('fechafin', '>=', $año . '-01-01')
            ->where('fechafin', '<=', $año . '-12-31')
            ->where('porcentaje', 100)
            ->where('idarea', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $serviciosPorBimestre = $conteoServiciosGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fechafin);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });
    } else {
        // Manejar el caso donde no hay participantes
    }

    //dd($serviciosPorBimestre);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoServiciosGET' => $conteoServiciosGET,
        'nombresParticipantesPorServicio' => $nombresParticipantesPorServicio,
        'serviciosPorBimestre' => $serviciosPorBimestre
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresServiciostabla', $data);
}

public function indicadorServiciosGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



        $conteoServiciosGET = serviciotecnologico::where('fechafin', '>=', $año . '-01-01')
            ->where('fechafin', '<=', $año . '-12-31')
            ->where('porcentaje', 100)
            ->where('idarea', User::find($userID)->idarea)
            ->get();

        $serviciosPorBimestre = $conteoServiciosGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fechafin);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });


    //dd($serviciosPorBimestre);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoServiciosGET' => $conteoServiciosGET,
        'serviciosPorBimestre' => $serviciosPorBimestre
    ];

    return view('SIRB/reportes/graficasindicadores/graficaServicios', $data);
}

public function indicadoresRevistasMemoriasNacionalestabla(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');


    // Paso 1: Consulta para obtener participantes

        $participantesRevistaI = revista::select('id', 'participantes')
            ->where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where(function ($query) {
                $query->where('tipo_revista', 'Nacional con arbitraje')
                    ->orWhere('tipo_revista', 'Nacional sin arbitraje');
            })
            ->where('area', User::find($userID)->idarea)
        ->get();

        $participantesMemoriaI = memoria::select('id', 'participantes')
            ->where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where(function ($query) {
                $query->where('tipo_memoria', 'Nacional con arbitraje')
                    ->orWhere('tipo_memoria', 'Nacional sin arbitraje');
            })
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Verificar si hay resultados antes de continuar

        // if ($participantesRevistaI->isNotEmpty()) {
        //     // Paso 2: Organizar los IDs de participantes por RevistaNacional y memoriaNacional
        //     $participantesPorRevistaI = [];
        //     foreach ($participantesRevistaI as $participantesrevistai) {
        //     $ids = explode(',', $participantesrevistai->participantes);
        //     $participantesPorRevistaI[$participantesrevistai->id] = $ids;
        // }};
        
        // if ($participantesMemoriaI->isNotEmpty()) {
        //     // Paso 2: Organizar los IDs de participantes por RevistaNacional y memoriaNacional
        //     $participantesPorMemoriaI = [];
        //     foreach ($participantesMemoriaI as $participantesmemoriai) {
        //     $ids = explode(',', $participantesmemoriai->participantes);
        //     $participantesPorMemoriaI[$participantesmemoriai->id] = $ids;
        // }};

        // Paso 3: Obtener nombres de participantes por RevistaNacional y memoriaNacional
        // $nombresParticipantesPorRevistaI = [];
        // foreach ($participantesPorRevistaI as $evistaId => $participantesIdsRevistasI) {
        //     $nombresParticipantesRevistaI = DB::table('usuarios')
        //         ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
        //         ->whereIn('id', $participantesIdsRevistasI)
        //         ->get();
        //     $nombresParticipantesPorRevistaI[$evistaId] = $nombresParticipantesRevistaI;
        // }

        // $nombresParticipantesPorMemoriaI = [];
        // foreach  $participantesPorMemoriaI as $MemoriaId => $participantesIdsMemoriasI) {
        //     $nombresParticipantesMemoriaI = DB::table('usuarios')
        //         ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
        //         ->whereIn('id', $participantesIdsMemoriasI)
        //         ->get();
        //     $nombresParticipantesPorMemoriaI[$MemoriaId] = $nombresParticipantesMemoriaI;
        // }

        // Paso 4: Consulta original para obtener RevistaNacional y memoriasNacional
        $conteoRevistaNGET = revista::where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where(function ($query) {
                $query->where('tipo_revista', 'Nacional con arbitraje')
                    ->orWhere('tipo_revista', 'Nacional sin arbitraje');
            })
            ->where('area', User::find($userID)->idarea);

        $conteoMemoriaNGET = memoria::where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where(function ($query) {
                $query->where('tipo_memoria', 'Nacional con arbitraje')
                    ->orWhere('tipo_memoria', 'Nacional sin arbitraje');
            })
            ->where('area', User::find($userID)->idarea);

        // Obtener colecciones
        $conteoRevistaNGET = $conteoRevistaNGET->get();
        $conteoMemoriaNGET = $conteoMemoriaNGET->get();

        // Combinar los resultados en una única colección
        $conteoRevistasMemorasGET = $conteoMemoriaNGET->concat($conteoRevistaNGET);

        // Paso 5: Agrupar servicios por bimestre
        $serviciosRevistasMemorasNGET = $conteoRevistasMemorasGET->groupBy(function ($servicio) {
            if (isset($servicio->fecha)) {
                $fechaServicio = strtotime($servicio->fecha);
            } elseif (isset($servicio->fechaT_titulacion)) {
                $fechaServicio = strtotime($servicio->fechaT_titulacion);
            } else {
                // Ajusta esta lógica según tus necesidades si ninguna fecha está presente
                return 0;
            }

            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });


        //dd($serviciosPorBimestreRevistaMemoria);

        $data = [
            'año' => $año,
            'sexenio' => $sexenio,
            'fechabimestre' => $fechabimestre,
            'fechabimestre2' => $fechabimestre2,
            // 'conteoRevistaIGET' => $conteoRevistaIGET,
            // 'conteoMemoriaIGET' => $conteoMemoriaIGET,
            // 'nombresParticipantesPorRevistaI' => $nombresParticipantesPorRevistaI,
            // 'nombresParticipantesPorMemoriaI' => $nombresParticipantesPorMemoriaI
            'serviciosRevistasMemorasNGET' => $serviciosRevistasMemorasNGET
        ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresRevistasMemoriasNacionalestabla', $data);
}

public function indicadoresRevistasMemoriasNacionalesGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



        $conteoRevistasNacionalGET = revista::where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where(function ($query) {
                $query->where('tipo_revista', 'Nacional con arbitraje')
                    ->orWhere('tipo_revista', 'Nacional sin arbitraje');
            })
            ->where('area', User::find($userID)->idarea);

        $conteoMemoriasNacionalGET = memoria::where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where(function ($query) {
                $query->where('tipo_memoria', 'Nacional con arbitraje')
                    ->orWhere('tipo_memoria', 'Nacional sin arbitraje');
            })
            ->where('area', User::find($userID)->idarea);


        $conteoRevistasNacionalGET = $conteoRevistasNacionalGET->get();
        $conteoMemoriasNacionalGET = $conteoMemoriasNacionalGET->get();

        // Combinar los resultados en una única colección
        $conteoRevistasMemoriasNacionalGET = $conteoRevistasNacionalGET->concat($conteoMemoriasNacionalGET);


        $serviciosPorBimestreRevistaMemoria = $conteoRevistasMemoriasNacionalGET->groupBy(function ($servicio) {
            $fechaServicio = strtotime($servicio->fecha);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });


    //dd($serviciosPorBimestreRevistaMemoria);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoRevistasNacionalGET' => $conteoRevistasNacionalGET,
        'conteoMemoriasNacionalGET' => $conteoMemoriasNacionalGET,
        'serviciosPorBimestreRevistaMemoria' => $serviciosPorBimestreRevistaMemoria
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresRevistasMemoriasNacionalesGrafica', $data);
}

public function indicadoresRevistasMemoriasInternacionalestabla(request $request){

        // Obtener el id del usuario autenticado
        $userID = $request->session()->get('LoginId');
        // variable para buscar en la tabla usuarios y relacionarla
        $user = User::find($userID);
        // variable para buscar el area del usuario
        $idarea= User::find($userID)->idarea;
        // variables para buscar el periodo
        $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
        $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
        $añoActual = $fechabimestre->año;
        $bimestreActual = $fechabimestre->bimestre;
        // variables para buscar el año y sexenio
        $año = $request->input('año');
        $sexenio = $request->input('sexenio');
    
    
        // Paso 1: Consulta para obtener participantes

            $participantesRevistaI = revista::select('id', 'participantes')
                ->where('fecha', '>=', $año . '-01-01')
                ->where('fecha', '<=', $año . '-12-31')
                ->where(function ($query) {
                    $query->where('tipo_revista', 'Internacional con arbitraje')
                        ->orWhere('tipo_revista', 'Internacional sin arbitraje');
                })
                ->where('area', User::find($userID)->idarea)
            ->get();

            $participantesMemoriaI = memoria::select('id', 'participantes')
                ->where('fecha', '>=', $año . '-01-01')
                ->where('fecha', '<=', $año . '-12-31')
                ->where(function ($query) {
                    $query->where('tipo_memoria', 'Internacional con arbitraje')
                        ->orWhere('tipo_memoria', 'Internacional sin arbitraje');
                })
                ->where('area', User::find($userID)->idarea)
                ->get();
    
            // Verificar si hay resultados antes de continuar

            // if ($participantesRevistaI->isNotEmpty()) {
            //     // Paso 2: Organizar los IDs de participantes por RevistaNacional y memoriaNacional
            //     $participantesPorRevistaI = [];
            //     foreach ($participantesRevistaI as $participantesrevistai) {
            //     $ids = explode(',', $participantesrevistai->participantes);
            //     $participantesPorRevistaI[$participantesrevistai->id] = $ids;
            // }};
            
            // if ($participantesMemoriaI->isNotEmpty()) {
            //     // Paso 2: Organizar los IDs de participantes por RevistaNacional y memoriaNacional
            //     $participantesPorMemoriaI = [];
            //     foreach ($participantesMemoriaI as $participantesmemoriai) {
            //     $ids = explode(',', $participantesmemoriai->participantes);
            //     $participantesPorMemoriaI[$participantesmemoriai->id] = $ids;
            // }};

            // Paso 3: Obtener nombres de participantes por RevistaNacional y memoriaNacional
            // $nombresParticipantesPorRevistaI = [];
            // foreach ($participantesPorRevistaI as $evistaId => $participantesIdsRevistasI) {
            //     $nombresParticipantesRevistaI = DB::table('usuarios')
            //         ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
            //         ->whereIn('id', $participantesIdsRevistasI)
            //         ->get();
            //     $nombresParticipantesPorRevistaI[$evistaId] = $nombresParticipantesRevistaI;
            // }

            // $nombresParticipantesPorMemoriaI = [];
            // foreach  $participantesPorMemoriaI as $MemoriaId => $participantesIdsMemoriasI) {
            //     $nombresParticipantesMemoriaI = DB::table('usuarios')
            //         ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
            //         ->whereIn('id', $participantesIdsMemoriasI)
            //         ->get();
            //     $nombresParticipantesPorMemoriaI[$MemoriaId] = $nombresParticipantesMemoriaI;
            // }
    
            // Paso 4: Consulta original para obtener RevistaNacional y memoriasNacional
            $conteoRevistaIGET = revista::where('fecha', '>=', $año . '-01-01')
                ->where('fecha', '<=', $año . '-12-31')
                ->where(function ($query) {
                    $query->where('tipo_revista', 'Internacional con arbitraje')
                        ->orWhere('tipo_revista', 'Internacional sin arbitraje');
                })
                ->where('area', User::find($userID)->idarea);

            $conteoMemoriaIGET = memoria::where('fecha', '>=', $año . '-01-01')
                ->where('fecha', '<=', $año . '-12-31')
                ->where(function ($query) {
                    $query->where('tipo_memoria', 'Internacional con arbitraje')
                        ->orWhere('tipo_memoria', 'Internacional sin arbitraje');
                })
                ->where('area', User::find($userID)->idarea);
    
            // Obtener colecciones
            $conteoRevistaIGET = $conteoRevistaIGET->get();
            $conteoMemoriaIGET = $conteoMemoriaIGET->get();
    
            // Combinar los resultados en una única colección
            $conteoRevistasMemorasGET = $conteoMemoriaIGET->concat($conteoRevistaIGET);
    
            // Paso 5: Agrupar servicios por bimestre
            $serviciosRevistasMemorasGET = $conteoRevistasMemorasGET->groupBy(function ($servicio) {
                if (isset($servicio->fecha)) {
                    $fechaServicio = strtotime($servicio->fecha);
                } elseif (isset($servicio->fechaT_titulacion)) {
                    $fechaServicio = strtotime($servicio->fechaT_titulacion);
                } else {
                    // Ajusta esta lógica según tus necesidades si ninguna fecha está presente
                    return 0;
                }
    
                $mesServicio = date("n", $fechaServicio);
    
                // Define los bimestres según tu lógica
                $bimestres = [
                    1 => 1,
                    2 => 1,
                    3 => 2,
                    4 => 2,
                    5 => 3,
                    6 => 3,
                    7 => 4,
                    8 => 4,
                    9 => 5,
                    10 => 5,
                    11 => 6,
                    12 => 6,
                ];
    
                return $bimestres[$mesServicio] ?? 0;
            });
    
            //dd($serviciosPorBimestreRevistaMemoria);
        
            $data = [
                'año' => $año,
                'sexenio' => $sexenio,
                'fechabimestre' => $fechabimestre,
                'fechabimestre2' => $fechabimestre2,
                // 'conteoRevistaIGET' => $conteoRevistaIGET,
                // 'conteoMemoriaIGET' => $conteoMemoriaIGET,
                // 'nombresParticipantesPorRevistaI' => $nombresParticipantesPorRevistaI,
                // 'nombresParticipantesPorMemoriaI' => $nombresParticipantesPorMemoriaI
                'serviciosRevistasMemorasGET' => $serviciosRevistasMemorasGET
        
            ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresRevistasMemoriasInternacionalestabla', $data);
}

public function indicadoresRevistasMemoriasInternacionalesGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



        $conteoRevistasInternacionalacionalGET = revista::where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where(function ($query) {
                $query->where('tipo_revista', 'Internacional con arbitraje')
                    ->orWhere('tipo_revista', 'Internacional sin arbitraje');
            })
            ->where('area', User::find($userID)->idarea);

        $conteoMemoriasInternacionalacionalGET = memoria::where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where(function ($query) {
                $query->where('tipo_memoria', 'Internacional con arbitraje')
                    ->orWhere('tipo_memoria', 'Internacional sin arbitraje');
            })
            ->where('area', User::find($userID)->idarea);

        // Obtener colecciones
        $conteoRevistasInternacionalacionalGET = $conteoRevistasInternacionalacionalGET->get();
        $conteoMemoriasInternacionalacionalGET = $conteoMemoriasInternacionalacionalGET->get();

        // Combinar los resultados en una única colección
        $conteoRevistasMemoriasInternacionalacionalGET = $conteoRevistasInternacionalacionalGET->concat($conteoMemoriasInternacionalacionalGET);


        // Paso 5: Agrupar servicios por bimestre
        $serviciosPorBimestreRevistaMemoria = $conteoRevistasMemoriasInternacionalacionalGET->groupBy(function ($servicio) {
            $fechaServicio = strtotime($servicio->fecha);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });


    //dd($serviciosPorBimestreRevistaMemoria);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoRevistasNacionalGET' => $conteoRevistasInternacionalacionalGET,
        'conteoMemoriasNacionalGET' => $conteoMemoriasInternacionalacionalGET,
        'serviciosPorBimestreRevistaMemoria' => $serviciosPorBimestreRevistaMemoria
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresRevistasMemoriasInternacionalesGrafica', $data);
}

public function indicadoresBoletinestabla(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    $idcoordinacion = 0;

    switch ($idarea) {
        case 1:
            $idcoordinacion = 8;
            break;
        case 2:
            $idcoordinacion = 1;
            break;
        case 3:
            $idcoordinacion = 7;
            break;
        case 4:
            $idcoordinacion = 2;
            break;
        case 5:
            $idcoordinacion = 3;
            break;
        case 6:
            $idcoordinacion = 5;
            break;
        case 7:
            $idcoordinacion = 6;
            break;
        case 8:
            $idcoordinacion = 10;
            break;
        case 9:
            $idcoordinacion = 9;
            break;
        case 10:
            $idcoordinacion = 4;
            break;
        case 11:
            $idcoordinacion = 11;
            break;
        case 12:
            $idcoordinacion = 12;
            break;
        case 13:
            $idcoordinacion = 13;
            break;
        }
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');

    $curpUsuario = $user->curp;
    $startDateInicio = $this->getStartMonthOfBimester($bimestreActual);
    $startDateFin = $this->getEndMonthOfBimester($bimestreActual);

        // Paso 1: Consulta para obtener participantes
        // $participantes = \DB::connection('mysql2')
        //     ->table('imt_bol_articulo')
        //     ->join('imt_bol_boletin', 'imt_bol_articulo.ID_BOL_Boletin', '=', 'imt_bol_boletin.ID_BOL_Boletin')
        //     ->leftJoin('imt_bol_autorarticulo', 'imt_bol_articulo.ID_BOL_Articulo', '=', 'imt_bol_autorarticulo.ID_BOL_Articulo')
        //     ->leftJoin('imt_gen_autor', 'imt_bol_autorarticulo.ID_GEN_Autor', '=', 'imt_gen_autor.ID_GEN_Autor')
        //     ->where('imt_bol_boletin.Anio', '>=', $año . '-01-01')
        //     ->where('imt_bol_boletin.Anio', '<=', $año . '-12-31')
        //     ->where('imt_bol_boletin.ID_GEN_Coordinacion',  $idcoordinacion)
        //     ->select('imt_bol_articulo.*', 'imt_bol_boletin.*', 'imt_bol_autorarticulo.*', 'imt_gen_autor.Nombre', 'imt_gen_autor.Apellidos')
        //     ->get();

        // $participantes  \DB::connection('mysql2')
        //     ->table('imt_bol_articulo')
        //     ->join('imt_bol_boletin', 'imt_bol_boletin.ID_BOL_Boletin', '=', 'imt_bol_articulo.ID_BOL_Boletin')
        //     ->join('imt_bol_autorarticulo', 'imt_bol_autorarticulo.ID_BOL_Articulo', '=', 'imt_bol_articulo.ID_BOL_Articulo')
        //     ->join('imt_gen_autor', 'imt_gen_autor.ID_GEN_Autor', '=', 'imt_bol_autorarticulo.ID_GEN_Autor')
        //     ->join( 'siapimt2.usuarios' ,'usuarios.curp' ,'=' ,'imt_gen_autor.curp')
        //     ->where('imt_bol_boletin.Anio', '>=', $año . '-01-01')
        //     ->where('imt_bol_boletin.Anio', '<=', $año . '-12-31')
        //     ->where('usuarios.idarea', $idarea)
        //     ->where('imt_bol_autorarticulo.Jerarquia', 0)
        //     ->select('imt_bol_articulo.*', 'imt_bol_boletin.*', 'imt_bol_autorarticulo.*', 'imt_gen_autor.Nombre', 'imt_gen_autor.Apellidos')
        //     ->get();

        $participantes = \DB::connection('mysql2')
        ->table('imt_bol_articulo')
        ->join('imt_bol_boletin', 'imt_bol_boletin.ID_BOL_Boletin', '=', 'imt_bol_articulo.ID_BOL_Boletin')
        ->join('imt_bol_autorarticulo', 'imt_bol_autorarticulo.ID_BOL_Articulo', '=', 'imt_bol_articulo.ID_BOL_Articulo')
        ->join('imt_gen_autor', 'imt_gen_autor.ID_GEN_Autor', '=', 'imt_bol_autorarticulo.ID_GEN_Autor')
        ->join( 'siapimt2.usuarios' ,'usuarios.curp' ,'=' ,'imt_gen_autor.curp')
        ->where('imt_bol_boletin.Anio', '>=', $año . '-01-01')
        ->where('imt_bol_boletin.Anio', '<=', $año . '-12-31')
        ->select('imt_bol_articulo.*', 'imt_bol_boletin.*', 'imt_bol_autorarticulo.*', 'imt_gen_autor.Nombre', 'imt_gen_autor.Apellidos')
        ->get();

        // Consulta para obtener participantes agrupados por ID_BOL_Articulo
        $participantesPorArticulo = $participantes->groupBy('ID_BOL_Articulo');
        

        // Consulta para obtener la información de los boletines
        // $conteoBoletines = \DB::connection('mysql2')
        //     ->table('imt_bol_articulo')
        //     ->join('imt_bol_boletin', 'imt_bol_articulo.ID_BOL_Boletin', '=', 'imt_bol_boletin.ID_BOL_Boletin')
        //     ->where('imt_bol_boletin.Anio', '>=', $año . '-01-01')
        //     ->where('imt_bol_boletin.Anio', '<=', $año . '-12-31')
        //     ->where('imt_bol_boletin.ID_GEN_Coordinacion', $idcoordinacion)
        //     ->get();

        $conteoBoletines = \DB::connection('mysql2')
            ->table('imt_bol_articulo')
            ->join('imt_bol_boletin', 'imt_bol_boletin.ID_BOL_Boletin', '=', 'imt_bol_articulo.ID_BOL_Boletin')
            ->join('imt_bol_autorarticulo', 'imt_bol_autorarticulo.ID_BOL_Articulo', '=', 'imt_bol_articulo.ID_BOL_Articulo')
            ->join('imt_gen_autor', 'imt_gen_autor.ID_GEN_Autor', '=', 'imt_bol_autorarticulo.ID_GEN_Autor')
            ->join( 'siapimt2.usuarios' ,'usuarios.curp' ,'=' ,'imt_gen_autor.curp')
            ->where('imt_bol_boletin.Anio', '>=', $año . '-01-01')
            ->where('imt_bol_boletin.Anio', '<=', $año . '-12-31')
            ->where('usuarios.idarea', $idarea)
            ->where('imt_bol_autorarticulo.Jerarquia', 0)
            ->get();


        $BoletinesPorBimestre = $conteoBoletines->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->Anio);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });



    //dd($participantesArticulo);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'participantesPorArticulo' => $participantesPorArticulo,
        'BoletinesPorBimestre' => $BoletinesPorBimestre
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresboletinestabla', $data);
}

public function indicadoresBoletinesGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    $idcoordinacion = null;

    switch ($idarea) {
        case 1:
            $idcoordinacion = 8;
            break;
        case 2:
            $idcoordinacion = 1;
            break;
        case 3:
            $idcoordinacion = 7;
            break;
        case 4:
            $idcoordinacion = 2;
            break;
        case 5:
            $idcoordinacion = 3;
            break;
        case 6:
            $idcoordinacion = 5;
            break;
        case 7:
            $idcoordinacion = 6;
            break;
        case 8:
            $idcoordinacion = 10;
            break;
        case 9:
            $idcoordinacion = 9;
            break;
        case 10:
            $idcoordinacion = 4;
            break;
        case 11:
            $idcoordinacion = 11;
            break;
        case 12:
            $idcoordinacion = 12;
            break;
        case 13:
            $idcoordinacion = 13;
            break;
        }
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');

    $curpUsuario = $user->curp;
    $startDateInicio = $this->getStartMonthOfBimester($bimestreActual);
    $startDateFin = $this->getEndMonthOfBimester($bimestreActual);


        // Consulta para obtener la información de los boletines
        $conteoBoletines = \DB::connection('mysql2')
            ->table('imt_bol_articulo')
            ->join('imt_bol_boletin', 'imt_bol_boletin.ID_BOL_Boletin', '=', 'imt_bol_articulo.ID_BOL_Boletin')
            ->join('imt_bol_autorarticulo', 'imt_bol_autorarticulo.ID_BOL_Articulo', '=', 'imt_bol_articulo.ID_BOL_Articulo')
            ->join('imt_gen_autor', 'imt_gen_autor.ID_GEN_Autor', '=', 'imt_bol_autorarticulo.ID_GEN_Autor')
            ->join( 'siapimt2.usuarios' ,'usuarios.curp' ,'=' ,'imt_gen_autor.curp')
            ->where('imt_bol_boletin.Anio', '>=', $año . '-01-01')
            ->where('imt_bol_boletin.Anio', '<=', $año . '-12-31')
            ->where('usuarios.idarea', $idarea)
            ->where('imt_bol_autorarticulo.Jerarquia', 0)
            ->get();


        $BoletinesPorBimestre = $conteoBoletines->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->Anio);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });



    //dd($participantesArticulo);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'BoletinesPorBimestre' => $BoletinesPorBimestre
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresboletinesgrafica', $data);
}

public function indicadoresBoletinesGraficaporAño(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    $idcoordinacion = 0;

    switch (User::find($userID)->idarea) {
        case 1:
            $idcoordinacion = 8;
            break;
        case 2:
            $idcoordinacion = 1;
            break;
        case 3:
            $idcoordinacion = 7;
            break;
        case 4:
            $idcoordinacion = 2;
            break;
        case 5:
            $idcoordinacion = 3;
            break;
        case 6:
            $idcoordinacion = 5;
            break;
        case 7:
            $idcoordinacion = 6;
            break;
        case 8:
            $idcoordinacion = 10;
            break;
        case 9:
            $idcoordinacion = 9;
            break;
        case 10:
            $idcoordinacion = 4;
            break;
        case 11:
            $idcoordinacion = 11;
            break;
        case 12:
            $idcoordinacion = 12;
            break;
        case 13:
            $idcoordinacion = 13;
            break;
        }
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    $rangoDeAños = range($sexenio, $sexenio + 5);
    $curpUsuario = $user->curp;
    $startDateInicio = $this->getStartMonthOfBimester($bimestreActual);
    $startDateFin = $this->getEndMonthOfBimester($bimestreActual);


        $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
            ->select('anio', 'AB15')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->anio => $item->AB15];
            })
            ->all();


        $conteoBoletines = DB::connection('mysql2')
            ->table('imt_bol_articulo')
            ->join('imt_bol_boletin', 'imt_bol_articulo.ID_BOL_Boletin', '=', 'imt_bol_boletin.ID_BOL_Boletin')
            ->where('Anio', '>=', $sexenio . '-01-01')
            ->where('Anio', '<=', ($sexenio + 5) . '-12-31')
            ->where('imt_bol_boletin.ID_GEN_Coordinacion', $idcoordinacion);

        // Agrupar documentos por año dentro del rango del sexenio
        $BoletinesPorAñoSexenio = $conteoBoletines->groupBy(function ($Boletines) {
        return date('Y', strtotime($Boletines->Anio));
        })->map(function ($Boletin) {
        return $Boletin->count();
        });
            
    //dd($BoletinesPorAñoSexenio);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'datosParaRango' => $datosParaRango,
        'conteoBoletines' => $conteoBoletines,
        'BoletinesPorAñoSexenio' => $BoletinesPorAñoSexenio
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadoresboletinesgraficaporaño', $data);
}

public function indicadorPonenciasConferenciasTablas(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



    // Paso 1: Consulta para obtener participantes
    $participantes = ponenciasconferencia::select('id', 'participantes')
        ->where('fecha_fin', '>=', $año . '-01-01')
        ->where('fecha_fin', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->get();


    // Verificar si hay resultados antes de continuar
    if ($participantes->isNotEmpty()) {
        // Paso 2: Organizar los IDs de participantes por Ponencia
        $participantesPorPonencia = [];
        foreach ($participantes as $participante) {
            $ids = explode(',', $participante->participantes);
            $participantesPorPonencia[$participante->id] = $ids;
        }

        // Paso 3: Obtener nombres de participantes por Ponencia
        $nombresParticipantesPorPonencia = [];
        foreach ($participantesPorPonencia as $PonenciaId => $participantesIds) {
            $nombresParticipantes = DB::table('usuarios')
                ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
                ->whereIn('id', $participantesIds)
                ->get();
            $nombresParticipantesPorPonencia[$PonenciaId] = $nombresParticipantes;
        }

        // Paso 4: Consulta original para obtener Ponencia
        $conteoPonenciaGET = ponenciasconferencia::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $PonenciaPorBimestre = $conteoPonenciaGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fecha_fin);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });
    } else {
        // Manejar el caso donde no hay participantes
    }

    //dd($serviciosPorBimestre);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoServiciosGET' => $conteoPonenciaGET,
        'nombresParticipantesPorPonencia' => $nombresParticipantesPorPonencia,
        'PonenciaPorBimestre' => $PonenciaPorBimestre
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresPonenciatabla', $data);
}

public function indicadorPonenciasConferenciasGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



        // Paso 4: Consulta original para obtener Ponencia
        $conteoPonenciaGET = ponenciasconferencia::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $PonenciaPorBimestre = $conteoPonenciaGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fecha_fin);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });

    //dd($serviciosPorBimestre);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoServiciosGET' => $conteoPonenciaGET,
        'PonenciaPorBimestre' => $PonenciaPorBimestre
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresPonenciagrafica', $data);
}

public function indicadorDocumentosTablas(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    $idcoordinacion = null;

    switch ($idarea) {
        case 1:
            $idcoordinacion = 8;
            break;
        case 2:
            $idcoordinacion = 1;
            break;
        case 3:
            $idcoordinacion = 7;
            break;
        case 4:
            $idcoordinacion = 2;
            break;
        case 5:
            $idcoordinacion = 3;
            break;
        case 6:
            $idcoordinacion = 5;
            break;
        case 7:
            $idcoordinacion = 6;
            break;
        case 8:
            $idcoordinacion = 10;
            break;
        case 9:
            $idcoordinacion = 9;
            break;
        case 10:
            $idcoordinacion = 4;
            break;
        case 11:
            $idcoordinacion = 11;
            break;
        case 12:
            $idcoordinacion = 12;
            break;
        case 13:
            $idcoordinacion = 13;
            break;
        }
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



    // Paso 1: Consulta para obtener participantes
    $participantes = DB::select("
    SELECT
        usuarios.curp,
        imt_pub_publicacion.Anio,
        imt_pub_publicacion.Titulo,
        imt_pub_publicacion.NoPublicacion,
        imt_pub_publicacion.AreaInteres,
        imt_pub_publicacion.ID_GEN_Coordinacion,
        imt_pub_tipopublicacion.Nombre,
        imt_pub_autorpublicacion.ID_PUB_Publicacion,
        imt_pub_autorpublicacion.ID_GEN_Autor,
        imt_pub_autorpublicacion.Jerarquia
    FROM usuarios
        JOIN siapimt25.imt_gen_autor ON usuarios.curp = imt_gen_autor.curp
        JOIN siapimt25.imt_pub_autorpublicacion ON imt_gen_autor.ID_GEN_Autor = imt_pub_autorpublicacion.ID_GEN_Autor
        JOIN siapimt25.imt_pub_publicacion ON imt_pub_autorpublicacion.ID_PUB_Publicacion = imt_pub_publicacion.ID_PUB_Publicacion
        JOIN siapimt25.imt_pub_tipopublicacion ON imt_pub_publicacion.id_pub_tipoPublicacion = imt_pub_tipopublicacion.id_pub_tipoPublicacion
    WHERE YEAR(imt_pub_publicacion.Anio) = ? AND imt_pub_publicacion.ID_GEN_Coordinacion = ?
    ", [$año, $idcoordinacion]);

        // Paso 2: Organizar los IDs de participantes por Documentos
        $publicaciones = [];

        foreach ($participantes as $resultado) {
            $noPublicacion = $resultado->NoPublicacion;

            if (!isset($publicaciones[$noPublicacion])) {
                $publicaciones[$noPublicacion] = [
                    'autores' => [],
                    'autorPrincipal' => null,
                ];
            }

            $idAutor = $resultado->ID_GEN_Autor;

            if ($resultado->Jerarquia == 0) {
                $publicaciones[$noPublicacion]['autorPrincipal'] = $idAutor;
            }

            $publicaciones[$noPublicacion]['autores'][] = $idAutor;
        }

        // Ahora $publicaciones contiene la información organizada por publicación


        //Paso 3: Recorre cada publicación y obtén los nombres de los autores
        foreach ($publicaciones as &$publicacion) {
            $autoresIds = $publicacion['autores'];
            $autoresIds[] = $publicacion['autorPrincipal'];

            // Consulta para obtener nombres de autores
            $autores = DB::connection('mysql2')
                ->table('imt_gen_autor')
                ->select('ID_GEN_Autor', 'Nombre', 'Apellidos')
                ->whereIn('ID_GEN_Autor', $autoresIds)
                ->get();

            $publicacion['nombresAutores'] = $autores;
        }



        // Paso 4: Consulta original para obtener Documentos
        $conteoDocumentosGET = \DB::connection('mysql2')
        ->table('imt_pub_publicacion')
        ->where('Anio', '>=', $año . '-01-01')
        ->where('Anio', '<=', $año . '-12-31')
        ->where('ID_GEN_Coordinacion', $idcoordinacion)
        ->get();

        // Paso 5: Agrupar servicios por bimestre
        $DocumentosPorBimestre = $conteoDocumentosGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->Anio);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });


    //dd($publicacion);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'publicaciones' => $publicaciones,
        'publicacion' => $publicacion,
        'DocumentosPorBimestre' => $DocumentosPorBimestre
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresDocumentotabla', $data);
}

public function indicadorDocumentosGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    $idcoordinacion = null;

    switch ($idarea) {
        case 1:
            $idcoordinacion = 8;
            break;
        case 2:
            $idcoordinacion = 1;
            break;
        case 3:
            $idcoordinacion = 7;
            break;
        case 4:
            $idcoordinacion = 2;
            break;
        case 5:
            $idcoordinacion = 3;
            break;
        case 6:
            $idcoordinacion = 5;
            break;
        case 7:
            $idcoordinacion = 6;
            break;
        case 8:
            $idcoordinacion = 10;
            break;
        case 9:
            $idcoordinacion = 9;
            break;
        case 10:
            $idcoordinacion = 4;
            break;
        case 11:
            $idcoordinacion = 11;
            break;
        case 12:
            $idcoordinacion = 12;
            break;
        case 13:
            $idcoordinacion = 13;
            break;
        }
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');


        $conteoDocumentosGET = \DB::connection('mysql2')
        ->table('imt_pub_publicacion')
        ->where('Anio', '>=', $año . '-01-01')
        ->where('Anio', '<=', $año . '-12-31')
        ->where('ID_GEN_Coordinacion', $idcoordinacion)
        ->get();

        $DocumentosPorBimestre = $conteoDocumentosGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->Anio);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });


    //dd($publicacion);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoServiciosGET' => $conteoDocumentosGET,
        'DocumentosPorBimestre' => $DocumentosPorBimestre
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresDocumentoGrafica', $data);
}

public function indicadoresReunionesSolicitudestabla(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



    // Paso 1: Consulta para obtener participantes
    $participantesReunion = reunion::select('id', 'participantes')
        ->where('fecha_reunion', '>=', $año . '-01-01')
        ->where('fecha_reunion', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->get();

    $participantesSolicitud = solicitudes::select('id', 'participantes')
        ->where('fecha', '>=', $año . '-01-01')
        ->where('fecha', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->get();


    // Verificar si hay resultados antes de continuar
    if ($participantesReunion->isNotEmpty() && $participantesSolicitud->isNotEmpty()) {
        // Paso 2: Organizar los IDs de participantes por RevistaNacional y memoriaNacional
        $participantesPorReunion = [];
        foreach ($participantesReunion as $participanteReunion) {
            $ids = explode(',', $participanteReunion->participantes);
            $participantesPorReunion[$participanteReunion->id] = $ids;
        }

        $participantesPorSolicitud = [];
        foreach ($participantesSolicitud as $participanteSolicitud) {
            $ids = explode(',', $participanteSolicitud->participantes);
            $participantesPorSolicitud[$participanteSolicitud->id] = $ids;
        }

        // Paso 3: Obtener nombres de participantes por RevistaNacional y memoriaNacional
        $nombresParticipantesPorReunion = [];
        foreach ($participantesPorReunion as $ReunionId => $participantesIdsReunion) {
            $nombresParticipantes = DB::table('usuarios')
                ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
                ->whereIn('id', $participantesIdsReunion)
                ->get();
            $nombresParticipantesPorReunion[$ReunionId] = $nombresParticipantes;
        }

        $nombresParticipantesPorSolicitud = [];
        foreach ($participantesPorSolicitud as $SolicitudId => $participantesIdsSolicitud) {
            $nombresParticipantesSolicitud = DB::table('usuarios')
                ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
                ->whereIn('id', $participantesIdsSolicitud)
                ->get();
            $nombresParticipantesPorSolicitud[$SolicitudId] = $nombresParticipantesSolicitud;
        }

        // Paso 4: Consulta original para obtener RevistaNacional y memoriasNacional
        $conteoReunionGET = reunion::where('fecha_reunion', '>=', $año . '-01-01')
            ->where('fecha_reunion', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea);

        $conteoSolicitudGET = solicitudes::where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea);

        // Obtener colecciones
        $conteoReunionGET = $conteoReunionGET->get();
        $conteoSolicitudGET = $conteoSolicitudGET->get();

        // Combinar los resultados en una única colección
        $conteoReunionSolicitudGET = $conteoReunionGET->concat($conteoSolicitudGET);


        // Paso 5: Agrupar servicios por bimestre
        $serviciosReunionSolicitudGET = $conteoReunionSolicitudGET->groupBy(function ($servicio) {
            if (isset($servicio->fecha_reunion)) {
                $fechaServicio = strtotime($servicio->fecha_reunion);
            } elseif (isset($servicio->fecha)) {
                $fechaServicio = strtotime($servicio->fecha);
            } else {
                // Ajusta esta lógica según tus necesidades si ninguna fecha está presente
                return 0;
            }

            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });
    }

    //dd($serviciosPorBimestreRevistaMemoria);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoReunionGET' => $conteoReunionGET,
        'conteoSolicitudGET' => $conteoSolicitudGET,
        'nombresParticipantesPorReunion' => $nombresParticipantesPorReunion,
        'nombresParticipantesPorSolicitud' => $nombresParticipantesPorSolicitud,
        'serviciosReunionSolicitudGET' => $serviciosReunionSolicitudGET
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresReunionesSolicitudestabla', $data);
}

public function indicadoresReunionesSolicitudesGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');




        $conteoReunionGET = reunion::where('fecha_reunion', '>=', $año . '-01-01')
            ->where('fecha_reunion', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea);

        $conteoSolicitudGET = solicitudes::where('fecha', '>=', $año . '-01-01')
            ->where('fecha', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea);

        // Obtener colecciones
        $conteoReunionGET = $conteoReunionGET->get();
        $conteoSolicitudGET = $conteoSolicitudGET->get();

        // Combinar los resultados en una única colección
        $conteoReunionSolicitudGET = $conteoReunionGET->concat($conteoSolicitudGET);


        $serviciosReunionSolicitudGET = $conteoReunionSolicitudGET->groupBy(function ($servicio) {
            if (isset($servicio->fecha_reunion)) {
                $fechaServicio = strtotime($servicio->fecha_reunion);
            } elseif (isset($servicio->fecha)) {
                $fechaServicio = strtotime($servicio->fecha);
            } else {
                // Ajusta esta lógica según tus necesidades si ninguna fecha está presente
                return 0;
            }

            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });


    //dd($serviciosPorBimestreRevistaMemoria);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoReunionGET' => $conteoReunionGET,
        'conteoSolicitudGET' => $conteoSolicitudGET,
        'serviciosReunionSolicitudGET' => $serviciosReunionSolicitudGET
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresReunionesSolicitudesGrafica', $data);
}

public function indicadoresPostgradostabla(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');


        // Paso 4: Consulta original para obtener Ponencia
        $conteoPostgradoGET = postgrado::where('fechaT_titulacion', '>=', $año . '-01-01')
            ->where('fechaT_titulacion', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $PostgradoPorBimestre = $conteoPostgradoGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fechaT_titulacion);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });


    //dd($serviciosPorBimestre);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoServiciosGET' => $conteoPostgradoGET,
        'PostgradoPorBimestre' => $PostgradoPorBimestre
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresPostgradotabla', $data);
}

public function indicadoresPostgradosGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');


        // Paso 4: Consulta original para obtener Ponencia
        $conteoPostgradoGET = postgrado::where('fechaT_titulacion', '>=', $año . '-01-01')
            ->where('fechaT_titulacion', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $PostgradoPorBimestre = $conteoPostgradoGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fechaT_titulacion);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });


    //dd($serviciosPorBimestre);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoServiciosGET' => $conteoPostgradoGET,
        'PostgradoPorBimestre' => $PostgradoPorBimestre
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresPostgradografica', $data);
}

public function indicadoresDocenciatabla(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



    $participantesCursos = cursorecibido::select('id', 'participantes')
        ->where('fecha_inicio', '>=', $año . '-01-01')
        ->where('fecha_fin', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->get();


    // Verificar si hay resultados antes de continuar
    if ($participantesCursos->isNotEmpty()) {
        // Paso 2: Organizar los IDs de participantes por RevistaNacional y memoriaNacional
        $participantesPorCursos = [];
        foreach ($participantesCursos as $participanteCursos) {
            $ids = explode(',', $participanteCursos->participantes);
            $participantesPorCursos[$participanteCursos->id] = $ids;
        }

        // Paso 3: Obtener nombres de participantes por RevistaNacional y memoriaNacional
        $nombresParticipantesPorCursos = [];
        foreach ($participantesPorCursos as $CursosId => $participantesIdsCursos) {
            $nombresParticipantesCursos = DB::table('usuarios')
                ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
                ->whereIn('id', $participantesIdsCursos)
                ->get();
            $nombresParticipantesPorCursos[$CursosId] = $nombresParticipantesCursos;
        }

        // Paso 4: Consulta original para obtener Postgrado
        $conteoCursosGET = cursorecibido::where('fecha_inicio', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $CursosPorBimestre = $conteoCursosGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fecha_fin);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });
    }

    //dd($serviciosPorBimestre);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoCursosGET' => $conteoCursosGET,
        'nombresParticipantesPorCursos' => $nombresParticipantesPorCursos,
        'CursosPorBimestre' => $CursosPorBimestre
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresDocenciatabla', $data);
}

public function indicadoresDocenciaGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



        // Paso 4: Consulta original para obtener Postgrado
        $conteoCursosGET = cursorecibido::where('fecha_inicio', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $CursosPorBimestre = $conteoCursosGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fecha_fin);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });

    //dd($conteoCursosGET);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoCursosGET' => $conteoCursosGET,
        'CursosPorBimestre' => $CursosPorBimestre
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresDocenciagrafica', $data);
}

// Nuevos indicadores agregados inicio 
public function indicadoresDocenciatabla1(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



    $participantesCursos = docencia::where('fecha_inicio', '>=', $año . '-01-01')
        ->where('fecha_fin', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->get();


    // Verificar si hay resultados antes de continuar
    if ($participantesCursos->isNotEmpty()) {
        // Paso 2: Organizar los IDs de participantes por RevistaNacional y memoriaNacional
        $participantesPorCursos = [];
        foreach ($participantesCursos as $participanteCursos) {
            $ids = explode(',', $participanteCursos->participantes);
            $participantesPorCursos[$participanteCursos->id] = $ids;
        }

        // Paso 3: Obtener nombres de participantes por RevistaNacional y memoriaNacional
        $nombresParticipantesPorCursos = [];
        foreach ($participantesPorCursos as $CursosId => $participantesIdsCursos) {
            $nombresParticipantesCursos = DB::table('usuarios')
                ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
                ->whereIn('id', $participantesIdsCursos)
                ->get();
            $nombresParticipantesPorCursos[$CursosId] = $nombresParticipantesCursos;
        }

        // Paso 4: Consulta original para obtener Postgrado
        $conteoCursosGET = docencia::where('fecha_inicio', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $CursosPorBimestre = $conteoCursosGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fecha_fin);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });
    }

    //dd($serviciosPorBimestre);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoCursosGET' => $conteoCursosGET,
        'nombresParticipantesPorCursos' => $nombresParticipantesPorCursos,
        'CursosPorBimestre' => $CursosPorBimestre
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresDocenciatablaimp', $data);
}

public function indicadoresDocenciaGrafica1(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



        // Paso 4: Consulta original para obtener Postgrado
        $conteoCursosGET = docencia::where('fecha_inicio', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->get();

        // Paso 5: Agrupar servicios por bimestre
        $CursosPorBimestre = $conteoCursosGET->groupBy(function ($Servicio) {
            $fechaServicio = strtotime($Servicio->fecha_fin);
            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });

    //dd($conteoCursosGET);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoCursosGET' => $conteoCursosGET,
        'CursosPorBimestre' => $CursosPorBimestre
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresDocenciagrafica', $data);
}
// Nuevos indicadores agregados fin 

public function indicadoresTesisCursostabla(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



    // Paso 1: Consulta para obtener participantes
    $participantesCursos = cursorecibido::select('id', 'participantes')
        ->where('fecha_inicio', '>=', $año . '-01-01')
        ->where('fecha_fin', '<=', $año . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->get();


    // Verificar si hay resultados antes de continuar
    if ($participantesCursos->isNotEmpty()) {
        // Paso 2: Organizar los IDs de participantes por RevistaNacional y memoriaNacional
        $participantesPorCursos = [];
        foreach ($participantesCursos as $participanteCursos) {
            $ids = explode(',', $participanteCursos->participantes);
            $participantesPorCursos[$participanteCursos->id] = $ids;
        }

        // Paso 3: Obtener nombres de participantes por RevistaNacional y memoriaNacional
        $nombresParticipantesPorCursos = [];
        foreach ($participantesPorCursos as $CursosId => $participantesIdsCursos) {
            $nombresParticipantesCursos = DB::table('usuarios')
                ->select('Nombre', 'Apellido_Paterno', 'Apellido_Materno')
                ->whereIn('id', $participantesIdsCursos)
                ->get();
            $nombresParticipantesPorCursos[$CursosId] = $nombresParticipantesCursos;
        }

        // Paso 4: Consulta original para obtener RevistaNacional y memoriasNacional
        $conteoTesisGET = tesi::where('fecha_inicio', '>=', $año . '-01-01')
            ->where('fechaT_titulacion', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea)
            ->where('fase_tesis', '=', 'Terminada');

        $conteoDocenciaGET = docencia::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea);

        // Obtener colecciones
        $conteoTesisGET = $conteoTesisGET->get();
        $conteoDocenciaGET = $conteoDocenciaGET->get();

        // Combinar los resultados en una única colección
        $conteoTesisCursosGET = $conteoTesisGET->concat($conteoDocenciaGET);


        // Paso 5: Agrupar servicios por bimestre
        $serviciosTesisCursosGET = $conteoTesisCursosGET->groupBy(function ($servicio) {
            if (isset($servicio->fecha_fin)) {
                $fechaServicio = strtotime($servicio->fecha_fin);
            } elseif (isset($servicio->fechaT_titulacion)) {
                $fechaServicio = strtotime($servicio->fechaT_titulacion);
            } else {
                // Ajusta esta lógica según tus necesidades si ninguna fecha está presente
                return 0;
            }

            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        });
    }

    //dd($serviciosPorBimestreRevistaMemoria);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoTesisGET' => $conteoTesisGET,
        'conteoDocenciaGET' => $conteoDocenciaGET,
        'nombresParticipantesPorCursos' => $nombresParticipantesPorCursos,
        'serviciosTesisCursosGET' => $serviciosTesisCursosGET
    ];

    return view('SIRB/reportes/tablasIndicadores/indicadoresTesisCursostabla', $data);
}

public function indicadoresTesisCursosGrafica(request $request){

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');



        // Paso 4: Consulta original para obtener RevistaNacional y memoriasNacional
        $conteoTesisGET = tesi::where('fecha_inicio', '>=', $año . '-01-01')
            ->where('fechaT_titulacion', '<=', $año . '-12-31')
            ->where('fase_tesis', '=', 'Terminada')
            ->where('area', User::find($userID)->idarea);

        $conteoDocenciaGET = docencia::where('fecha_fin', '>=', $año . '-01-01')
            ->where('fecha_fin', '<=', $año . '-12-31')
            ->where('area', User::find($userID)->idarea);

        // Obtener colecciones
        $conteoTesisGET = $conteoTesisGET->get();
        $conteoDocenciaGET = $conteoDocenciaGET->get();

        // Combinar los resultados en una única colección
        $conteoTesisCursosGET = $conteoTesisGET->concat($conteoDocenciaGET);


        // Paso 5: Agrupar servicios por bimestre
        $serviciosTesisCursosGET = $conteoTesisCursosGET->groupBy(function ($servicio) {
            if (isset($servicio->fecha_fin)) {
                $fechaServicio = strtotime($servicio->fecha_fin);
            } elseif (isset($servicio->fechaT_titulacion)) {
                $fechaServicio = strtotime($servicio->fechaT_titulacion);
            } else {
                // Ajusta esta lógica según tus necesidades si ninguna fecha está presente
                return 0;
            }

            $mesServicio = date("n", $fechaServicio);

            // Define los bimestres según tu lógica
            $bimestres = [
                1 => 1,
                2 => 1,
                3 => 2,
                4 => 2,
                5 => 3,
                6 => 3,
                7 => 4,
                8 => 4,
                9 => 5,
                10 => 5,
                11 => 6,
                12 => 6,
            ];

            return $bimestres[$mesServicio] ?? 0;
        })->map(function ($proyectos) {
            return $proyectos->count();
        });


    //dd($serviciosPorBimestreRevistaMemoria);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoTesisGET' => $conteoTesisGET,
        'conteoDocenciaGET' => $conteoDocenciaGET,
        'serviciosTesisCursosGET' => $serviciosTesisCursosGET
    ];

    return view('SIRB/reportes/graficasindicadores/indicadoresTesisCursosgrafica', $data);
}

public function indicadorProyectosInternosGraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'PI1')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->PI1];
    })
    ->all();

    $conteoProyectosIGET = Proyecto::select(
        DB::raw('YEAR(proyectos.fecha_fin) as year'),
        DB::raw('COUNT(*) as count')
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->whereBetween('proyectos.fecha_fin', [$sexenio . '-01-01', ($sexenio + 5) . '-12-31'])
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'I')
    ->groupBy('year')
    ->get()
    ->mapWithKeys(function ($proyecto) {
        return [$proyecto->year => $proyecto->count];
    });

    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosIGET' => $conteoProyectosIGET,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadoresporañoproyectostabla', $data);
}


public function indicadorProyectosExternosGraficaAños1(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'PE5')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->PE5];
    })
    ->all();

    $conteoProyectosEGET = Proyecto::select(
        DB::raw('YEAR(proyectos.fecha_fin) as year'),
        DB::raw('COUNT(*) as count')
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->whereBetween('proyectos.fecha_fin', [$sexenio . '-01-01', ($sexenio + 5) . '-12-31'])
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'E')
    ->groupBy('year')
    ->get()
    ->mapWithKeys(function ($proyecto) {
        return [$proyecto->year => $proyecto->count];
    });


    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosEGET' => $conteoProyectosEGET,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadoresporañoproyectostablaII', $data);
}

public function indicadorProyectosExternosGraficaAños2(request $request)
{
    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'MIPEC7')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->MIPEC7];
    })
    ->all();

    $conteoProyectosEGET = Proyecto::select(
        DB::raw('YEAR(proyectos.fecha_fin) as year'),
        DB::raw('COUNT(*) as count')
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->whereBetween('proyectos.fecha_fin', [$sexenio . '-01-01', ($sexenio + 5) . '-12-31'])
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->where('proyectos.Tipo', 'E')
    ->groupBy('year')
    ->get()
    ->mapWithKeys(function ($proyecto) {
        return [$proyecto->year => $proyecto->count];
    });

    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosEGET' => $conteoProyectosEGET,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadoresporañoproyectostablaII', $data);
}

public function indicadorProyectosIn_Ex_ternosGraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'MIPC3')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->MIPC3];
    })
    ->all();

    $conteoProyectosGET = Proyecto::select(
        DB::raw('YEAR(proyectos.fecha_fin) as year'),
        DB::raw('COUNT(*) as count')
    )
    ->join('usuarios', 'proyectos.idusuarior', '=', 'usuarios.id')
    ->whereBetween('proyectos.fecha_fin', [$sexenio . '-01-01', ($sexenio + 5) . '-12-31'])
    ->where('proyectos.progreso', 100)
    ->where('proyectos.idarea', $idarea)
    ->groupBy('year')
    ->get()
    ->mapWithKeys(function ($proyecto) {
        return [$proyecto->year => $proyecto->count];
    });


    //dd($datosParaRango);

    //$proyectosfin = $proyectos->concat($proyectosPart);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoProyectosGET' => $conteoProyectosGET,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadoresporañoproyectostablaI', $data);
}

public function indicadorServiciosGraficaAños(request $request)
{
    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'EL9')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->EL9];
    })
    ->all();

    $conteoServiciosGET = serviciotecnologico::select(
        DB::raw('YEAR(fechafin) as year'),
        DB::raw('COUNT(*) as count')
    )
    ->whereBetween('fechafin', [$sexenio . '-01-01', ($sexenio + 5) . '-12-31'])
    ->where('porcentaje', 100)
    ->where('idarea', User::find($userID)->idarea)
    ->groupBy('year')
    ->get()
    ->mapWithKeys(function ($servicio) {
        return [$servicio->year => $servicio->count];
    });


    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoServiciosGET' => $conteoServiciosGET,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadoresporañoservtablaIII', $data);
}

public function indicadorMem_Rev_NacGraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'APRMN11')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->APRMN11];
    })
    ->all();


    // Asumiendo que $sexenio contiene el año inicial del sexenio
    $conteoRevistasNacionalGET = revista::where('fecha', '>=', $sexenio . '-01-01')
    ->where('fecha', '<=', ($sexenio + 5) . '-12-31')
    ->where(function ($query) {
        $query->where('tipo_revista', 'Nacional con arbitraje')
            ->orWhere('tipo_revista', 'Nacional sin arbitraje');
    })
    ->where('area', User::find($userID)->idarea)
    ->get();

    $conteoMemoriasNacionalGET = memoria::where('fecha', '>=', $sexenio . '-01-01')
    ->where('fecha', '<=', ($sexenio + 5) . '-12-31')
    ->where(function ($query) {
        $query->where('tipo_memoria', 'Nacional con arbitraje')
            ->orWhere('tipo_memoria', 'Nacional sin arbitraje');
    })
    ->where('area', User::find($userID)->idarea)
    ->get();

    // Combinar los resultados en una única colección
    $conteoRevistasMemoriasNacionalGET = $conteoRevistasNacionalGET->concat($conteoMemoriasNacionalGET);

    // Mapear conteoRevistasMemoriasNacionalGET para obtener el conteo por año dentro del sexenio
    $conteoPorAñoSexenio = $conteoRevistasMemoriasNacionalGET->groupBy(function ($item) {
    return date('Y', strtotime($item->fecha));
    })->map(function ($items) {
    return $items->count();
    });

    //dd($datosParaRango);

    //$proyectosfin = $proyectos->concat($proyectosPart);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoRevistasNacionalGET' => $conteoRevistasNacionalGET,
        'conteoMemoriasNacionalGET' => $conteoMemoriasNacionalGET,
        'conteoRevistasMemoriasNacionalGET' => $conteoRevistasMemoriasNacionalGET,
        'conteoPorAñoSexenio' => $conteoPorAñoSexenio,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadormemrevañoservtablaIV', $data);
}

public function indicadorMem_Rev_ItnacGraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'APRMI13')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->APRMI13];
    })
    ->all();


    // Asumiendo que $sexenio contiene el año inicial del sexenio
    $conteoRevistasInternacionalGET = revista::where('fecha', '>=', $sexenio . '-01-01')
    ->where('fecha', '<=', ($sexenio + 5) . '-12-31')
    ->where(function ($query) {
        $query->where('tipo_revista', 'Internacional con arbitraje')
            ->orWhere('tipo_revista', 'Internacional sin arbitraje');
    })
    ->where('area', User::find($userID)->idarea)
    ->get();

    $conteoMemoriasInternacionalGET = memoria::where('fecha', '>=', $sexenio . '-01-01')
    ->where('fecha', '<=', ($sexenio + 5) . '-12-31')
    ->where(function ($query) {
        $query->where('tipo_memoria', 'Internacional con arbitraje')
            ->orWhere('tipo_memoria', 'Internacional sin arbitraje');
    })
    ->where('area', User::find($userID)->idarea)
    ->get();

    // Combinar los resultados en una única colección
    $conteoRevistasMemoriasInternacionalGET = $conteoRevistasInternacionalGET->concat($conteoMemoriasInternacionalGET);

    // Mapear conteoRevistasMemoriasNacionalGET para obtener el conteo por año dentro del sexenio
    $conteoPorAñoSexenio = $conteoRevistasMemoriasInternacionalGET->groupBy(function ($item) {
    return date('Y', strtotime($item->fecha));
    })->map(function ($items) {
    return $items->count();
    });

    //dd($datosParaRango);

    //$proyectosfin = $proyectos->concat($proyectosPart);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoRevistasInternacionalGET' => $conteoRevistasInternacionalGET,
        'conteoMemoriasInternacionalGET' => $conteoMemoriasInternacionalGET,
        'conteoRevistasMemoriasInternacionalGET' => $conteoRevistasMemoriasInternacionalGET,
        'conteoPorAñoSexenio' => $conteoPorAñoSexenio,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadormemrevañoservtablaV', $data);
}

public function indicadorPonenConfGraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'CSC17')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->CSC17];
    })
    ->all();

    // Asumiendo que $sexenio contiene el año inicial del sexenio
    $conteoPonenciaGET = ponenciasconferencia::where('fecha_fin', '>=', $sexenio . '-01-01')
    ->where('fecha_fin', '<=', ($sexenio + 5) . '-12-31')
    ->where('area', User::find($userID)->idarea)
    ->get();

    // Agrupar ponencias por año dentro del rango del sexenio
    $PonenciaPorAñoSexenio = $conteoPonenciaGET->groupBy(function ($Servicio) {
    return date('Y', strtotime($Servicio->fecha_fin));
    })->map(function ($proyectos) {
    return $proyectos->count();
    });


    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoPonenciaGET' => $conteoPonenciaGET,
        'PonenciaPorAñoSexenio' => $PonenciaPorAñoSexenio,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadorponenconftablaVI', $data);
}

public function indicadorDocTecGraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'PT19')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->PT19];
    })
    ->all();

    $idcoordinacion = null;

    switch ($idarea) {
        case 1:
            $idcoordinacion = 8;
            break;
        case 2:
            $idcoordinacion = 1;
            break;
        case 3:
            $idcoordinacion = 7;
            break;
        case 4:
            $idcoordinacion = 2;
            break;
        case 5:
            $idcoordinacion = 3;
            break;
        case 6:
            $idcoordinacion = 5;
            break;
        case 7:
            $idcoordinacion = 6;
            break;
        case 8:
            $idcoordinacion = 10;
            break;
        case 9:
            $idcoordinacion = 9;
            break;
        case 10:
            $idcoordinacion = 4;
            break;
        case 11:
            $idcoordinacion = 11;
            break;
        case 12:
            $idcoordinacion = 12;
            break;
        case 13:
            $idcoordinacion = 13;
            break;
        }


        // Asumiendo que $sexenio contiene el año inicial del sexenio
        $conteoDocumentosGET = \DB::connection('mysql2')
        ->table('imt_pub_publicacion')
        ->where('Anio', '>=', $sexenio . '-01-01')
        ->where('Anio', '<=', ($sexenio + 5) . '-12-31')
        ->where('ID_GEN_Coordinacion', $idcoordinacion)
        ->get();

        // Agrupar documentos por año dentro del rango del sexenio
        $DocumentosPorAñoSexenio = $conteoDocumentosGET->groupBy(function ($documento) {
        return date('Y', strtotime($documento->Anio));
        })->map(function ($documentos) {
        return $documentos->count();
        });



    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoDocumentosGET' => $conteoDocumentosGET,
        'DocumentosPorAñoSexenio' => $DocumentosPorAñoSexenio,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadorTecdocconftablaVII', $data);
}

public function indicadorReu_solc_GraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'ACA21')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->ACA21];
    })
    ->all();

    // Asumiendo que $sexenio contiene el año inicial del sexenio
    $conteoReunionGET = reunion::where('fecha_reunion', '>=', $sexenio . '-01-01')
    ->where('fecha_reunion', '<=', ($sexenio + 5) . '-12-31')
    ->where('area', User::find($userID)->idarea)
    ->get();

    $conteoSolicitudGET = solicitudes::where('fecha', '>=', $sexenio . '-01-01')
    ->where('fecha', '<=', ($sexenio + 5) . '-12-31')
    ->where('area', User::find($userID)->idarea)
    ->get();

    // Combinar los resultados en una única colección
    $conteoReunionSolicitudGET = $conteoReunionGET->concat($conteoSolicitudGET);

    // Agrupar reuniones y solicitudes por año dentro del rango del sexenio
    $serviciosReunionSolicitudPorAñoSexenio = $conteoReunionSolicitudGET->groupBy(function ($servicio) {
    $fechaServicio = isset($servicio->fecha_reunion) ? $servicio->fecha_reunion : $servicio->fecha;
    return date('Y', strtotime($fechaServicio));
    })->map(function ($servicios) {
    return $servicios->count();
    });

    //dd($datosParaRango);


    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoReunionGET' => $conteoReunionGET,
        'conteoSolicitudGET' => $conteoSolicitudGET,
        'serviciosReunionSolicitudPorAñoSexenio' => $serviciosReunionSolicitudPorAñoSexenio,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadorreusolctablaVIII', $data);
}

public function indicadorPostgradosGraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'IOGDML23')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->IOGDML23];
    })
    ->all();

    // Asumiendo que $sexenio contiene el año inicial del sexenio
    $conteoPostgradoGET = postgrado::where('fechaT_titulacion', '>=', $sexenio . '-01-01')
    ->where('fechaT_titulacion', '<=', ($sexenio + 5) . '-12-31')
    ->where('area', User::find($userID)->idarea)
    ->get();

    // Agrupar postgrados por año dentro del rango del sexenio
    $PostgradoPorAñoSexenio = $conteoPostgradoGET->groupBy(function ($postgrado) {
    return date('Y', strtotime($postgrado->fechaT_titulacion));
    })->map(function ($postgrados) {
    return $postgrados->count();
    });

    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoPostgradoGET' => $conteoPostgradoGET,
        'PostgradoPorAñoSexenio' => $PostgradoPorAñoSexenio,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadorpostgradostablaIX', $data);
}

public function indicadorDocenciasGraficaAños1(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'CI25')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->CI25];
    })
    ->all();

    // Asumiendo que $sexenio contiene el año inicial del sexenio
    $conteoCursosGET = cursorecibido::where('fecha_inicio', '>=', $sexenio . '-01-01')
    ->where('fecha_fin', '<=', ($sexenio + 5) . '-12-31')
    ->where('area', User::find($userID)->idarea)
    ->get();

    // Agrupar cursos por año dentro del rango del sexenio
    $CursosPorAñoSexenio = $conteoCursosGET->groupBy(function ($curso) {
    return date('Y', strtotime($curso->fecha_fin));
    })->map(function ($cursos) {
    return $cursos->count();
    });


    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoCursosGET' => $conteoCursosGET,
        'CursosPorAñoSexenio' => $CursosPorAñoSexenio,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadordocenciastablaX', $data);
}

public function indicadorDocenciasGraficaAños2(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'CIR27')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->CIR27];
    })
    ->all();

    // Asumiendo que $sexenio contiene el año inicial del sexenio
    $conteoCursosGET = docencia::where('fecha_inicio', '>=', $sexenio . '-01-01')
    ->where('fecha_fin', '<=', ($sexenio + 5) . '-12-31')
    ->where('area', User::find($userID)->idarea)
    ->get();

    // Agrupar cursos por año dentro del rango del sexenio
    $CursosPorAñoSexenio = $conteoCursosGET->groupBy(function ($curso) {
    return date('Y', strtotime($curso->fecha_fin));
    })->map(function ($cursos) {
    return $cursos->count();
    });


    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoCursosGET' => $conteoCursosGET,
        'CursosPorAñoSexenio' => $CursosPorAñoSexenio,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadordocenciastablaX', $data);
}

public function indicadorTesisCursosRecGraficaAños(request $request)
{

    // Obtener el id del usuario autenticado
    $userID = $request->session()->get('LoginId');
    // variable para buscar en la tabla usuarios y relacionarla
    $user = User::find($userID);
    // variable para buscar el area del usuario
    $idarea= User::find($userID)->idarea;
    // variables para buscar el periodo
    $fechabimestre = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
    $fechabimestre2 = DB::table('fechabimestres')->where('id', 2)->select('año', 'bimestre')->first();
    $añoActual = $fechabimestre->año;
    $bimestreActual = $fechabimestre->bimestre;
    // variables para buscar el año y sexenio
    $año = $request->input('año');
    $sexenio = $request->input('sexenio');
    // Calcular el rango de años (desde el año seleccionado hasta 5 años después)
    $rangoDeAños = range($sexenio, $sexenio + 5);


    $datosParaRango = miconfig::whereIn('anio', $rangoDeAños)
    ->select('anio', 'TITD29')
    ->get()
    ->mapWithKeys(function ($item) {
        return [$item->anio => $item->TITD29];
    })
    ->all();

    // Asumiendo que $sexenio contiene el año inicial del sexenio
    $conteoTesisGET = tesi::where('fecha_inicio', '>=', $sexenio . '-01-01')
        ->where('fechaT_titulacion', '<=', ($sexenio + 5) . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->get();

    $conteoDocenciaGET = docencia::where('fecha_fin', '>=', $sexenio . '-01-01')
        ->where('fecha_fin', '<=', ($sexenio + 5) . '-12-31')
        ->where('area', User::find($userID)->idarea)
        ->get();

    // Combinar los resultados en una única colección
    $conteoTesisCursosGET = $conteoTesisGET->concat($conteoDocenciaGET);

    // Agrupar tesis y docencia por año dentro del rango del sexenio
    $serviciosTesisCursosPorAñoSexenio = $conteoTesisCursosGET->groupBy(function ($servicio) {
        $fechaServicio = isset($servicio->fecha_fin) ? $servicio->fecha_fin : $servicio->fechaT_titulacion;
        return date('Y', strtotime($fechaServicio));
    })->map(function ($servicios) {
        return $servicios->count();
    });


    //dd($datosParaRango);

    $data = [
        'año' => $año,
        'sexenio' => $sexenio,
        'fechabimestre' => $fechabimestre,
        'fechabimestre2' => $fechabimestre2,
        'conteoTesisGET' => $conteoTesisGET,
        'conteoDocenciaGET' => $conteoDocenciaGET,
        'conteoTesisCursosGET' => $conteoTesisCursosGET,
        'serviciosTesisCursosPorAñoSexenio' => $serviciosTesisCursosPorAñoSexenio ,
        'datosParaRango' => $datosParaRango
    ];

    return view('SIRB/reportes/graficasporañoindicadores/indicadortesiscursosrecXI', $data);
}

}


//    $fechabimestre = DB::table('fechabimestres')->where('id', 1)->select('año', 'bimestre')->first();
