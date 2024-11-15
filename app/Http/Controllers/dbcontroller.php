<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Contribucion;
use App\Models\Objetivo;
use App\Models\Investigacion;
use App\Models\Transporte;
use App\Models\Alineacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Acceso;
use App\Models\Afectacion;
use App\Models\Cliente;
use App\Models\ContribucionesProyecto;
use App\Models\Equipo;
use App\Models\Financiero;
use App\Models\Puesto;
use App\Models\Recursos;
use App\Models\RecursosGeneral;
use App\Models\Tarea;
use App\Models\fechabimestre;
use App\Models\Orientacion; //nuevo
use App\Models\Nivel; //nuevo
use App\Models\Materia; //nuevo
use App\Models\MateriaPr; //nuevo
use App\Models\Observacion;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Exports\Afectacion_Export;
use App\Exports\ProyectosExport;
use App\Models\comitesAdmin;
use App\Models\ServiciostecnologicosAdmin;
//nuevo
use Illuminate\Support\Facades\Mail;
use App\Mail\Solicitudreprogramacion;
use App\Mail\Solicitudreprogramacionaceptada;
use App\Mail\Solicitudreprogramacionrechazada;
use App\Mail\Solicitudcancelacion;
use App\Mail\Solicitudcancelacionrechazada;
use App\Mail\Solicitudcancelacionaceptada;
//Nuevo
use DB;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\Controllers\EjecutivoController;
use App\Http\Controllers\class\StatusController;
use App\Http\Controllers\class\PorcentTasksController;
use App\Http\Controllers\ProyectoController;




class dbcontroller extends Controller
{


    //funcion para comitesAdmin
    public function comitesAdmin()
    {

        // Obtener todos los clientes
        $comitesAdmin = comitesAdmin::OrderBy('tipo','asc')->OrderBy('nombre','asc')->get();


        // Crear un arreglo de datos
        $data = [
            'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
            'comitesAdmin' => $comitesAdmin
        ];

        return view('SIRB/comitesAdmin', $data);
    }

      //funcion para serviciosAdmin
      public function serviciosAdmin(){

          // Obtener todos los clientes
          $ServiciostecnologicosAdmin = ServiciostecnologicosAdmin::all();


          // Crear un arreglo de datos
          $data = [
              'LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first(),
              'ServiciostecnologicosAdmin' => $ServiciostecnologicosAdmin
          ];

          return view('SIRB/serviciosAdmin', $data);
      }

/*Login y Accesos Inicio */
    public function loginuser (Request $request) {
        $request->validate([
            'usuario'=>'required',
            'pass'=>'required'
        ]);
        $user = User::where('usuario','=',$request->usuario)->where('acceso', '=','1')->first();
        $resp = User::where('usuario','=',$request->usuario)->where('acceso', '=','2')->first();
        $asoc = User::where('usuario','=',$request->usuario)->where('acceso', '=','3')->first();
        $adminf = User::where('usuario','=',$request->usuario)->where('acceso', '=','4')->first();
        $fina = User::where('usuario','=',$request->usuario)->where('acceso', '=','5')->first();
        if ($user) {
            if (Hash::check($request->pass, $user->pass)){
                    $request->session()->put('LoginId',$user->id);
                    return redirect('dashboard');
            }else {
                return back()->with('fail', 'Intenta Acceder de nuevo, Verifica el Usuario y la Contraseña');
            }
        } elseif ($resp) {
            if (Hash::check($request->pass, $resp->pass)){
                $request->session()->put('LoginId',$resp->id);

                // Obtener el id del usuario autenticado
                $userID = $request->session()->get('LoginId');

                $fechabimestre = DB::table('usuarios')->where('id', $userID)->first();

                $fechabimestre2 = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
                $añoActual = $fechabimestre2->año;
                $bimestreActual = $fechabimestre2->bimestre;

                $periodoConsultado = $bimestreActual . " del " . $añoActual;

                $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

                $data = [
                    'LoggedUserInfo' => User::where('id', session('LoginId'))->first(),
                    'FullName' => $resp->Nombre,
                    'fechabimestre' => $fechabimestre,
                    'periodoConsultado' => $periodoConsultado,
                    'fechabimestreP' => $fechabimestreP,                   
                    'userID' => $userID
                ];
                return view('SIRB/newinicio4', $data);
            }else {
                return back()->with('fail', 'Intenta Acceder de nuevo, Verifica el Usuario y la Contraseña');
            }


        } elseif ($asoc) {
            if (Hash::check($request->pass, $asoc->pass)){
                $request->session()->put('LoginId',$asoc->id);

                // Obtener el id del usuario autenticado
                $userID = $request->session()->get('LoginId');

                $fechabimestre = DB::table('usuarios')->where('id', $userID)->first();

                $fechabimestre2 = DB::table('usuarios')->where('id', $userID)->select('año', 'bimestre')->first();
                $añoActual = $fechabimestre2->año;
                $bimestreActual = $fechabimestre2->bimestre;


                $periodoConsultado = $bimestreActual . " del " . $añoActual;

                $fechabimestreP = DB::table('usuarios')->where('id', $userID)->first();

                $data = [
                    'LoggedUserInfo' => User::where('id', session('LoginId'))->first(),
                    'FullName' => $asoc->Nombre,
                    'fechabimestre' => $fechabimestre,
                    'periodoConsultado' => $periodoConsultado,
                    'fechabimestreP' => $fechabimestreP,
                    'userID' => $userID
                ];
                return view('SIRB/newinicio4', $data);
            }else {
                return back()->with('fail', 'Intenta Acceder de nuevo, Verifica el Usuario y la Contraseña');
            }


        } elseif ($adminf) {
            if (Hash::check($request->pass, $adminf->pass)){
                $request->session()->put('LoginId',$adminf->id);
                return redirect('dashboardaadminf');
            } else {
                return back()->with('fail', 'Intenta Acceder de nuevo, Verifica el Usuario y la Contraseña');
            }
        } elseif ($fina) {
            if (Hash::check($request->pass, $fina->pass)){
                $request->session()->put('LoginId',$fina->id);
                return redirect('dashboardafina');
            } else {
                return back()->with('fail', 'Intenta Acceder de nuevo, Verifica el Usuario y la Contraseña');
            }
        } else {
            return back()->with('fail', 'Usuario No Existente');
        }
    }

    public function dashboard(Request $request){
        if (session()->has('LoginId')) {
            $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];
            $statusController = new StatusController();
            //instancia para objeto de porcentaje esperado por tarea
            $porcentProjectController = new PorcentTasksController();

            //seleccionamos todos los proyectos con los datos correspondientes
            $proy = Proyecto::join('usuarios', 'usuarios.id', '=', 'proyectos.idusuarior')
            ->where('proyectos.oculto', '=', '1')
            ->orderBy('proyectos.clavea', 'ASC')
            ->orderBy('proyectos.clavet', 'ASC')
            ->orderBy('proyectos.claven', 'ASC')
            ->orderBy('proyectos.clavey', 'ASC')
            ->get([
                'proyectos.id',
                'proyectos.oculto',
                'usuarios.Nombre',
                'usuarios.Apellido_Paterno',
                'usuarios.Apellido_Materno',
                'proyectos.nomproy',
                'proyectos.clavea',
                'proyectos.clavet',
                'proyectos.claven',
                'proyectos.clavey',
                'proyectos.fecha_inicio',
                'proyectos.fecha_fin',
                'proyectos.progreso',
                'proyectos.duracionm',
                'proyectos.costo',
                'proyectos.estado',
                'proyectos.publicacion',
                'proyectos.idpublicacion'
            ])
            //agregamos el campo con la etiqueta de acuerdo con su estado
            ->map(function($project) use ($statusController, $porcentProjectController){
                $project->label_status = $statusController->getLabelStatus($project->estado);
                $project->label_color = $statusController->getColorLabelStatus($project->estado);
                //$project->label_negotiation = $statusController->getLabelStatusNegotiation($project->estado,$project->clavet);

                //si el proyecto tiene fecha de inicio y fecha de fin, independientemente del estado que tenga
                if(!empty($porcentProjectController->getDateStartProject($project->id)) && 
                    !empty($porcentProjectController->getDateEndProject($project->id))){
                    $project->porcent_program = $porcentProjectController->getPorcentProgrammedForTasks($project->id);
                }else{
                    //en caso de que no tenga fecha de inicio y fin,dejamos en 0 el porcentaje programado
                    $project->porcent_program = 0;
                }

                return $project;  
            });

            $areasAdscripcion = $this->getAreasAdscripcion();

        }
        return view('paginaprincipal', $data, compact('proy', 'areasAdscripcion'));
    }

    /*
    public function dashboardresp()
        if (session()->has('LoginId') ) {
            $data = ['LoggedUserInfo'=>User::where('id', '=',session('LoginId'))->first()];
            $user = User::where('id','=',session('LoginId'))->first();
            $proy = Proyecto::join('usuarios', 'usuarios.id','=','proyectos.idusuarior')
            ->where('proyectos.oculto','=','1')
            ->orwhere('proyectos.aprobo',$user->id)
            ->orwhere('proyectos.idarea',$user->idarea)
            ->orderBy('proyectos.clavea', 'ASC')
            ->orderBy('proyectos.clavet', 'ASC')
            ->orderBy('proyectos.claven', 'ASC')
            ->orderBy('proyectos.clavey', 'ASC')
            ->get(['proyectos.id',
            'proyectos.oculto',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
            'proyectos.nomproy',
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.progreso',
            'proyectos.duracionm',
            'proyectos.costo',
            'proyectos.aprobo',
            'proyectos.idarea'
            ]);
            return view('paginaprincipalejec', $data,compact('proy'));
        }
    }*/

    /* CAMBIOS DEL DE ARRIBA  */

    public function dashboardresp() {
        if (session()->has('LoginId')) {
            $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];
            $user = User::where('id', '=', session('LoginId'))->first();

            //instancia a la clase de EjecutivoController
            $ejecutiveController = new EjecutivoController();
            //instancia a clase de StatusContoller
            $statusController = new StatusController();
            //instancia a clase de PorcentTasksController
            $porcentProjectController = new PorcentTasksController();

            //recuperamos todos los proyectos del area del usuario donde es reponsable        
            $allProjectsWhereImResponsable = $ejecutiveController->getProjectsMulticoordinacionIamResponsableInMyArea($this->getCurrentUserAuthDepto())
            ->concat($ejecutiveController->getProjectsIamResponsableInMyArea($this->getCurrentUserAuthDepto()))            //agregamos el campo con la etiqueta de acuerdo con su estado
            ->map(function($project) use ($statusController){
                $project->label_status = $statusController->getLabelStatus($project->estado);
                $project->label_color = $statusController->getColorLabelStatus($project->estado);
                //$project->label_negotiation = $statusController->getLabelStatusNegotiation($project->estado,$project->clavet);
                return $project;  
            });
            //embedimos los porcentajes programados o esperados para cada proyecto    
            $allProjectsWhereImResponsable = $porcentProjectController->appendProgressProgram($allProjectsWhereImResponsable);

            //recuperamos los proyectos multicoordinacion y del area donde el usuario es participante
            $allProjectsWhereImMember = $ejecutiveController->getProjectsMulticoordinacionIamMiembro()
            ->concat($ejecutiveController->getProjectsIamMiembroInMyArea($this->getCurrentUserAuthDepto()))
            //agregamos el campo con la etiqueta de acuerdo con su estado
            ->map(function($project) use ($statusController){
                $project->label_status = $statusController->getLabelStatus($project->estado);
                $project->label_color = $statusController->getColorLabelStatus($project->estado);
                //$project->label_negotiation = $statusController->getLabelStatusNegotiation($project->estado,$project->clavet);
                return $project;  
            });
            //embedimos los porcentajes programados o esperados para cada proyecto
            $allProjectsWhereImMember = $porcentProjectController->appendProgressProgram($allProjectsWhereImMember);

            //recuperamos el resto de proyectos del area y de multicoordinacion
            $projectsMulticoordinacionAndArea = $this->getProjectsAreaAndMulticoordinacion($this->getCurrentUserAuthDepto())
            //agregamos el campo con la etiqueta de acuerdo con su estado
            ->map(function($project) use ($statusController){
                $project->label_status = $statusController->getLabelStatus($project->estado);
                $project->label_color = $statusController->getColorLabelStatus($project->estado);
                //$project->label_negotiation = $statusController->getLabelStatusNegotiation($project->estado,$project->clavet);
                return $project;
            });
            //embedimos los porcentajes programados o esperados para cada proyecto
            $projectsMulticoordinacionAndArea = $porcentProjectController->appendProgressProgram($projectsMulticoordinacionAndArea);

            $restProjects = $projectsMulticoordinacionAndArea->diff($allProjectsWhereImResponsable->concat($allProjectsWhereImMember));
            //embedimos los porcentajes programados o esperados para cada proyecto    
            $restProjects = $porcentProjectController->appendProgressProgram($restProjects);

            return view('paginaprincipalejec', $data, compact('allProjectsWhereImResponsable','allProjectsWhereImMember','restProjects'));
        }
    }

    public function dashboardauser() {
        if (session()->has('LoginId')) {
            $data = ['LoggedUserInfo' => User::where('id', '=', session('LoginId'))->first()];
            $statusController = new StatusController();
            $porcentProjectController = new PorcentTasksController();

            $proyt = User::join('proyectos', 'proyectos.idusuarior', '=', 'usuarios.id')
                ->Where('proyectos.idusuarior', '=', session('LoginId'))
                ->where('proyectos.oculto', '=', '1')
                ->orderBy('proyectos.clavea', 'ASC')
                ->orderBy('proyectos.clavet', 'ASC')
                ->orderBy('proyectos.claven', 'ASC')
                ->orderBy('proyectos.clavey', 'ASC')
                ->get([
                    'proyectos.id',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.nomproy',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.idusuarior',
                    'proyectos.progreso',
                    'proyectos.duracionm',
                    'proyectos.costo',
                    'proyectos.estado',
                    'proyectos.publicacion',
                    'proyectos.idpublicacion'
                ])
                //agregamos el campo con la etiqueta de acuerdo con su estado
                ->map(function($project) use ($statusController){
                    $project->label_status = $statusController->getLabelStatus($project->estado);
                    $project->label_color = $statusController->getColorLabelStatus($project->estado);
                    //$project->label_negotiation = $statusController->getLabelStatusNegotiation($project->estado,$project->clavet);
                    return $project;  
                });
            //embedimos los porcentajes programados o esperados para cada proyecto    
            $proyt = $porcentProjectController->appendProgressProgram($proyt);    

            $proy = Equipo::join('proyectos', 'proyectos.id', '=', 'equipo.idproyecto')
                ->where('equipo.idusuario', '=', session('LoginId'))
                ->where('proyectos.oculto', '=', '1')
                ->orderBy('proyectos.clavea', 'ASC')
                ->orderBy('proyectos.clavet', 'ASC')
                ->orderBy('proyectos.claven', 'ASC')
                ->orderBy('proyectos.clavey', 'ASC')
                ->get([
                    'proyectos.id',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.nomproy',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'equipo.idusuario',
                    'proyectos.idusuarior',
                    'proyectos.progreso',
                    'proyectos.duracionm',
                    'proyectos.costo',
                    'proyectos.estado',
                    'proyectos.publicacion',
                    'proyectos.idpublicacion'
                ])
                //agregamos el campo con la etiqueta de acuerdo con su estado
                ->map(function($project) use ($statusController){
                    $project->label_status = $statusController->getLabelStatus($project->estado);
                    $project->label_color = $statusController->getColorLabelStatus($project->estado);
                    //$project->label_negotiation = $statusController->getLabelStatusNegotiation($project->estado,$project->clavet);
                    return $project;  
                });

                //embedimos los porcentajes programados o esperados para cada proyecto    
                $proy = $porcentProjectController->appendProgressProgram($proy);  
            return view('paginaprincipaluser', $data, compact('proy', 'proyt'));
        }
    }

    public function dashboardaadminf() {
        if (session()->has('LoginId') ) {
            $data = ['LoggedUserInfo'=>User::where('id', '=',session('LoginId'))->first()];
            $proy = Proyecto::orderBy('ncontratos', 'ASC')
            ->orderBy('proyectos.claven', 'ASC')
            ->orderBy('proyectos.clavey', 'ASC')
            ->whereNotNull('ncontratos')->where('status', 1)->get();
        }
        return view('paginaprincipaladminf', $data, compact('proy'));
    }

    public function dashboardafina() {
        if (session()->has('LoginId') ) {
            $data = ['LoggedUserInfo'=>User::where('id', '=',session('LoginId'))->first()];
            $proy = Proyecto::orderBy('ncontratos', 'ASC')
            ->orderBy('proyectos.claven', 'ASC')
            ->orderBy('proyectos.clavey', 'ASC')
            ->whereNotNull('ncontratos')->where('status', 1)->get();
        }
        return view('paginaprincipalfina', $data, compact('proy'));
    }

    function logout (request $request) {
        $userID = $request->session()->get('LoginId');
        $user = User::find($userID);

        $periodoactual = fechabimestre::where('id', 2)->first();
        $periodoaño = $periodoactual->año;
        $periodobimestre = $periodoactual->bimestre;
        
        if (session()->has('LoginId')){

            // Actualiza el registro en la tabla 'usuarios' antes de cerrar la sesión
            User::where('id', $userID)->update(['año' => $periodoaño]);
            User::where('id', $userID)->update(['bimestre' => $periodobimestre]);

            session()->pull('LoginId');
            return redirect('/');
        }
    }

    public function cancelcrud()
    {
        if (session()->has('LoginId')){
            $access = User::where('id', '=',session('LoginId'))->where('acceso', '=',1)->first();
            $accessejec = User::where('id', '=',session('LoginId'))->where('acceso', '=',2)->first();
            $accessuser = User::where('id', '=',session('LoginId'))->where('acceso', '=',3)->first();
            if ($access) {
                return redirect('dashboard');
            } elseif ($accessejec){
                return redirect('dashboardresp');
            } elseif ($accessuser){
                return redirect('dashboardauser');
            } else {
                return redirect('/');
            }
        }
    }

    public function cancelcrudafect()
    {
        if (session()->has('LoginId')) {
            $access = User::where('id','=',session('LoginId'))->where('acceso','=',1)->first();
            $accessejec = User::where('id','=',session('LoginId'))->where('acceso','=',4)->first();
            $accessuser = User::where('id','=',session('LoginId'))->where('acceso','=',5)->first();
            if ($access) {
                return redirect('Financiero');
            } elseif ($accessejec){
                return redirect('dashboardaadminf');
            } elseif ($accessuser){
                return redirect('dashboardafina');
            } else {
                return redirect('/');
            }
        }
    }
/*Login y Accesos Fin */

/*Usuarios Inicio*/
    public function newuser(){
        $access = Acceso::all();
        $areas = Area::where('status',1)->get();
        $puesto = Puesto::Where('status',1)->get();
        return view('adduser', compact('areas','access','puesto'));
    }

    public function adduser( Request $request){
        $request -> validate([
            'name'=>'required',
            'appat'=>'required',
            'apmat'=>'required',
            'correo'=>'required',
            'curp'=>'required',
            'pass'=>'required',
            'usuario'=>'required',
            'areas'=>'numeric',
            'tacces'=>'numeric',
            'puesto'=>'numeric'
        ]);
        $use = new User();
        $use->id;
        $use->Nombre = $request->name;
        $use->Apellido_Paterno = $request->appat;
        $use->Apellido_Materno = $request->apmat;
        $use->correo = $request->correo;
        $use->curp = $request->curp;
        $use->usuario = $request->usuario;
        $use->idarea = $request->areas;
        $use->acceso = $request->tacces;
        $use->pass = Hash::make($request->pass);
        $use->passen = Crypt::encrypt($request->pass);
        $use->idpuesto = $request->get('puesto');
        $res = $use->save();
        if($res){
            return back()->with('success','Registro de nuevo usuario completado con exito' );
        }else{
            return back()->with('fail','No se pudo resgistrar al nuevo usuario');
        }
    }

    public function upusers($id){
        $user = User::where('id',$id)->first();
        $access = Acceso::all();
        $acces = Acceso::where('id',$user->acceso)->first();
        $areas = Area::where('status',1)->get();
        $areass = Area::where('id',$user->idarea)->first();
        $pass = Crypt::decrypt($user->passen);
        $puesto = Puesto::where('status',1)->get();
        $puestos = Puesto::where('id',$user->idpuesto)->first();
        return view('upuser', compact('user','access','areas','pass','puesto','acces', 'puestos','areass'));
    }
    
    public function upuser(Request $request, $id){
        $request -> validate([
            'name'=>'required',
            'appat'=>'required',
            'apmat'=>'required',
            'correo'=>'required',
            'curp'=>'required',
            'pass'=>'required',
            'usuario'=>'required',
            'tacces' => 'numeric',
            'areas'=>'numeric',
            'puesto'=>'numeric'
        ]);
        $use = User::find($id);
        $use->id;
        $use->Nombre = $request->get('name');
        $use->Apellido_Paterno = $request->get('appat');
        $use->Apellido_Materno = $request->get('apmat');
        $use->correo = $request->get('correo');
        $use->curp = $request->get('curp');
        $use->usuario = $request->get('usuario');
        $use-> idarea = $request->areas;
        $use->pass = Hash::make($request->pass);
        $use->passen = Crypt::encrypt($request->pass);
        $use->acceso = $request->get('tacces');
        $use->idpuesto = $request->get('puesto');
        $use->save();
        return redirect('userAdmin');
    }

    public function changestatuuser (Request $request){
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }

    public function changestaturesp (Request $request){
        $user = User::findOrFail($request->id);
        $user->responsable = $request->responsable;
        $user->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }

    public function changestatussesionespecial (Request $request){
        $user = User::findOrFail($request->id);
        $user->sesionespecial = $request->sesionespecial;
        $user->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }

    public function userAdmin(Request $request){
        if(session()->has('LoginId')){
            $texto = trim($request->get('buscarpor'));
            if($texto == "") {
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
                }else{
                    $users= User::join('t_accessos','t_accessos.id','=','usuarios.acceso')
                    ->Where('usuarios.Nombre', 'LIKE', '%'.$texto.'%')
                    ->orWhere('usuarios.Apellido_Paterno', 'LIKE', '%'.$texto.'%')
                    ->orWhere('usuarios.Apellido_Materno', 'LIKE', '%'.$texto.'%')
                    ->orWhere('usuarios.usuario', 'LIKE', '%'.$texto.'%')
                    ->orderBy('t_accessos.nom_acceso', 'ASC')
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
                }
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('Usuarios',$data,compact('users', 'texto'));
    }
/*Usuarios Fin */

/*Proyectos Fin*/
    public function adpindex(){
        if(session()->has('LoginId')){
        $proyt = Proyecto::join('usuarios','usuarios.id','=','proyectos.idusuarior')
                ->get(['proyectos.id',
                    'proyectos.oculto',
                    'usuarios.Nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                    'proyectos.nomproy',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin'
                ]);
        $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('AdminPr',$data,compact('proyt'));
    }

    public function changestatuspro (Request $request){
        $proyt = Proyecto::findOrFail($request->id);
        $proyt->status =  $request->status;
        $proyt->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }

    /* esta funcion se encarga de recibir un ajax que cambia el valor del campo de proyectos por 1 o 0 deprendiendo
    el estado anterior de dl campo, este funcion se repite para la mayoria de los catalogos*/
    /* Nota: este funcion esta en el archivo AdminPr revisarlo para entender el funcionamiento*/
    
    public function changeStatusoculto (Request $request){
        $proyto = Proyecto::find($request->pr_id);
        $proyto->oculto = $request->oculto;
        $proyto->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }

    public function newp()
    {
        if (session()->has('LoginId')) {
            $search = User::where('id', '=', session('LoginId'))->first();
            $areauser = Area::where('id', $search->idarea)->first();
            $resp = User::Where('idarea', $areauser->id)->where('responsable', 1)->first();
            $contri = Contribucion::where('status', 1)->get();
            $areas = Area::where('status', 1)->orderBy('nombre_area', 'ASC')->get();
            $invs = Investigacion::where('status', 1)->orderBy('nombre_linea', 'ASC')->get();
            $objs = Objetivo::where('status', 1)->get();
            $trans = Transporte::where('status', 1)->get();
            $alins = Alineacion::where('status', 1)->get();
            $proy = Proyecto::where('status', 1)->get();
            $clie = Cliente::where('status', 1)->orderBy('nivel1', 'DESC')
                ->orderBy('nivel2', 'ASC')->orderBy('nivel3', 'ASC')->get();
            $user = User::where('status', 1)->where('acceso', '!=', 4)->Where('acceso', '!=', 5)
                ->orderBy('Apellido_Paterno', 'ASC')->orderBy('Apellido_Materno', 'ASC')->orderBy('nombre', 'ASC')->get();

            //Nuevas tablas
                $materia = Materia::where('status', 1)->get();
                $orientacion = Orientacion::where('status', 1)->get();
                $nivel = Nivel::where('status', 1)->get();
            //Nuevas tablas

            //enviamos las categorias disponibles en base de datos
            $categoriesN1 = $this->getCategoriesList();
            //enviamos la lista de clientes nivel2 de la primera categoria    
            $clientsN2 = $this->getCategoriesListN2($categoriesN1[0]);
            //enviamos los clientes de la categoria niveo 3 que coincida con la categoria y nivel1 y nivel2 
            $clientsN3 =  $this->getCategoriesListN3($categoriesN1[0], $clientsN2[0]);

                        //obtenemos los anios disponibles para realizar el proyecto
            //instancia a la clase
            $projectController = new ProyectoController();
            $yearOptions = $projectController->getYearOptionsForRealizeProject(2);
        }

        return view('addproy', compact(
            'contri',
            'areas',
            'invs',
            'objs',
            'trans',
            'alins',
            'proy',
            'user',
            'clie',
            'areauser',
            'search',
            'resp',
            'categoriesN1',
            'clientsN2',
            'clientsN3',
            'orientacion',
            'nivel',
            'materia',
            'yearOptions'
        ));
    }

    /*
        Campo nivel1 se tomara como Category del registro
    */

    //retorna todas las distintas categorias Nivel1 de la base de datos
    public function getCategoriesList()
    {
        //seleccionamos las categorias diferentes de la base de datos
        $categories = Cliente::distinct()
        ->orderBy('nivel1','ASC')
        ->pluck('nivel1');

        return $categories;
    }

    //retorna todas las distintas categorias Nivel1 de la base de datos
    public function getCategoriesListByJSON()
    {
        //seleccionamos las categorias diferentes de la base de datos
        return response()->json($this->getCategoriesList());
    }

    //retorna todas las distintas categorias Nivel2 de la base de datos
    private function getCategoriesListN2($categoryN1)
    {
        //comprobamos si el usuario autenticado pertenece al departamento de División de Telemática
        if ($this->currentUserIsInDepto('División de Telemática') || $this->currentUserIsInDepto('Administración y Finanzas')) {
            
            //seleccionamos todas las categorias diferentes de la base de datos
            $categoriesN2 = Cliente::Where('nivel1', $categoryN1)
                ->select('nivel2')
                ->distinct()
                ->orderBy('nivel2','ASC')
                ->pluck('nivel2');
            return $categoriesN2;
        }

        //para el resto de areas se excluye el IMT
        return $this->getClientsExcludeByDepartamento($categoryN1, 'IMT');
    }

    //retorna todas las distintas categorias Nivel2 de la base de datos en JSON
    public function getCategoriesListN2ByJSON($categoryN1)
    {
        //seleccionamos las categorias diferentes de la base de datos
        //retornamos la lista de categorias nivel 2
        return response()->json($this->getCategoriesListN2($categoryN1));   
    }

    //retorna todas las distintas categorias Nivel3 de la base de datos dado el nivel1 y nivel2
    private function getCategoriesListN3($categoryN1, $categoryN2){
        //seleccionamos las categorias diferentes de la base de datos
        $categoriesN3 = Cliente::where('nivel1', $categoryN1)
            ->where('nivel2', $categoryN2)
            ->select('nivel3')
            ->distinct()
            ->orderBy('nivel3','ASC')
            ->pluck('nivel3');
        return $categoriesN3;
    }

    //retorna todas las distintas categorias Nivel3 de la base de datos dado el nivel1 y nivel2 en JSON
    public function getCategoriesListN3ByJSON($categoryN1, $categoryN2){
        //seleccionamos las categorias diferentes de la base de datos
        return response()->json($this->getCategoriesListN3($categoryN1, $categoryN2));
    }

    /*
    metodo para obtener obtener el id del cliente usando el nombre completo
    */
    function getIdClientByFullName($nivel1, $nivel2, $nivel3){
        $client = Cliente::select('id')
            ->where('nivel1', $nivel1)
            ->where('nivel2', $nivel2)
            ->where('nivel3', $nivel3)
            ->get();

        return $client;
    }

    public function getIdClientByFullNameByJSON($nivel1, $nivel2, $nivel3){
        //retornamos en formato json el id del cliente
        return response()->json($this->getIdClientByFullName($nivel1, $nivel2, $nivel3));
    }

    /*
    obtiene los clientes descartando alguno especificado del nivel 2; retorna un JSON
    */
    private function getClientsExcludeByDepartamento($category, $clientToExclude = 'IMT'){
        //seleccionamos las categorias diferentes de la base de datos
        $categoriesN2 = Cliente::Where('nivel1', $category)
            ->select('nivel2')
            ->where('nivel2', '!=', $clientToExclude)
            ->distinct()
            ->orderBy('nivel2','ASC')
            ->pluck('nivel2');

        return ($categoriesN2);
    }

    /*
        retorna verdadero o falso (JSON) para saber si el usuario con la sesion activa pertenece a un dado departamento
    */
    public function currentUserIsInDeptoByJSON($depto = 'División de Telemática'){
        //ya se usa middleware para esto, pero la tuya por si acaso
        if (session()->has('LoginId')) {

            //hacemos las relaciones para poder encontrar el area de adscrpcion al que pertenece el usuario
            $idSession = session('LoginId');
            $userDepto = User::select('usuarios.id', 'area_adscripcion.nombre_area')
                ->join('area_adscripcion', 'usuarios.idarea', '=', 'area_adscripcion.id')
                ->where('usuarios.id', $idSession)
                ->first();

            //vemos si pertenece al area que se solicita
            if ($userDepto->nombre_area  !=  $depto) {
                return response()->json(['is_in_area' => false]);
            }
            return response()->json(['is_in_area' => true]);
        }

        return response()->json(['error' => 'Error de autenticacion']);
    }

    /*
        retorna verdadero o falso para saber si el usuario con la sesion activa pertenece a un dado departamento
    */
    private function currentUserIsInDepto($depto = 'División de Telemática'){
        //ya se usa middleware para esto, pero la tuya por si acaso
        if (session()->has('LoginId')) {
            //hacemos las relaciones para poder encontrar el area de adscrpcion al que pertenece el usuario
            $idSession = session('LoginId');
            $userDepto = User::select('usuarios.id', 'area_adscripcion.nombre_area')
                ->join('area_adscripcion', 'usuarios.idarea', '=', 'area_adscripcion.id')
                ->where('usuarios.id', $idSession)
                ->first();

            //vemos si pertenece al area que se solicita
            if ($userDepto->nombre_area  !=  $depto) {
                return false;
            }
            return true;
        }
        return false;
    }

    /*
        retorna el departamento actual(JSON)  del usuario autenticado
    */
    public function getCurrentUserAuthDepto(){
        //ya se usa middleware para esto, pero la tuya por si acaso
        if (session()->has('LoginId')) {
            //hacemos las relaciones para poder encontrar el area de adscrpcion al que pertenece el usuario
            $idSession = session('LoginId');
            $userDepto = User::select('usuarios.id', 'area_adscripcion.nombre_area')
                ->join('area_adscripcion', 'usuarios.idarea', '=', 'area_adscripcion.id')
                ->where('usuarios.id', $idSession)
                ->first();
            
            //return response()->json([$userDepto->nombre_area]);
            return $userDepto->nombre_area;
        }
        return response()->json(['error' => 'Error de autenticacion']);
    }

    /*
        obtenemos los proyectos a un area dada
    */
    public function getProjectsByArea($area){
        $projectsArea = Proyecto::select(
            'proyectos.id',
            'proyectos.nomproy',
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.idusuarior',
            'proyectos.aprobo',
            'proyectos.oculto',
            'proyectos.progreso',
            'proyectos.duracionm',
            'proyectos.costo',
            'proyectos.estado',
            'proyectos.publicacion',
            'proyectos.idpublicacion',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
            'area_adscripcion.nombre_area',
        )
        ->where('area_adscripcion.nombre_area', $area)
        ->where('proyectos.oculto', '=', '1')
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->join('usuarios','proyectos.idusuarior','=','usuarios.id')
        ->join('area_adscripcion','proyectos.idarea','=','area_adscripcion.id')
        ->get();

        return $projectsArea;
    }


    //obtiene los proyectos de multicoordinacion de un usaurio que pertence a un area dada
    function getProjectsMulticoordinacionArea($area){
        $projectsAreaMulticoordinacion = Proyecto::select(
            'proyectos.id',
            'proyectos.nomproy',
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.idusuarior',
            'proyectos.aprobo',
            'proyectos.oculto',
            'proyectos.progreso',
            'proyectos.duracionm',
            'proyectos.publicacion',
            'proyectos.idpublicacion',
            'proyectos.costo',
            'proyectos.estado',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
            'area_adscripcion.nombre_area',
        )
        ->join('usuarios','proyectos.idusuarior','=','usuarios.id')        
        ->join('area_adscripcion','usuarios.idarea','=','area_adscripcion.id')
        ->where([
            ['proyectos.oculto','=','1'],
            ['proyectos.clavea','=','M'],
            ['area_adscripcion.nombre_area', '=',$area]
        ])
        ->orderBy('proyectos.clavea', 'ASC')
        ->orderBy('proyectos.clavet', 'ASC')
        ->orderBy('proyectos.claven', 'ASC')
        ->orderBy('proyectos.clavey', 'ASC')
        ->get();

        return $projectsAreaMulticoordinacion;
    }


    public function getProjectsAreaAndMulticoordinacion($area){

        $multicoordinacionProjects = $this->getProjectsMulticoordinacionArea($area);
        $areaProjects = $this->getProjectsByArea($area);

        return $areaProjects->concat($multicoordinacionProjects);                        

    }

    public function getProjectsAreaAndMulticoordinacionByJSON($area){

        $statusController = new StatusController();
        $porcentProjectController = new PorcentTasksController();

        $multicoordinacionProjects = $statusController->appendLabelAndColorStatus($this->getProjectsMulticoordinacionArea($area));
        $areaProjects = $statusController->appendLabelAndColorStatus($this->getProjectsByArea($area));

        $multicoordinacionProjects = $porcentProjectController->appendProgressProgram($multicoordinacionProjects);
        $areaProjects = $porcentProjectController->appendProgressProgram($areaProjects);

        return response()->json($areaProjects->concat($multicoordinacionProjects));

    }

    public function getAreasAdscripcion(){
        $areasAdscripcion = Area::select('id','nombre_area','inicial_clave','siglas')
        ->get();

        return $areasAdscripcion;
    }

    public function changeEstadoProject(Request $request){

        try{
            $project = Proyecto::findOrFail($request->input('id'));
            $project->estado = $request->input('estado');
            $project->save();

            return response()->json(['success'=> 'El estado se cambio exitosamente('.$request->input('estado').')']);
        }
        catch (Exception $e){
            return response()->json(['error'=> $e->getMessage()]);
        }

    }

    //busca y retona todos los proyectos del usuario y del mismo area a la que pertenece
    private function getProjectsByUserAndAreaAuth(){

        if (session()->has('LoginId')) {
            //recuperamos el id y el area de la sesion del usuario
            $userId = session('LoginId');
            $userArea = $this->getCurrentUserAuthDepto();

            $userProjects = Proyecto::join('usuarios', 'usuarios.id', '=', 'proyectos.idusuarior')
                            ->join('area_adscripcion','area_adscripcion.id','proyectos.idarea')
                            ->select(['proyectos.id',
                            'proyectos.oculto',
                            'usuarios.Nombre',
                            'usuarios.Apellido_Paterno',
                            'usuarios.Apellido_Materno',
                            'proyectos.nomproy',
                            'proyectos.clavea',
                            'proyectos.clavet',
                            'proyectos.claven',
                            'proyectos.clavey',
                            'proyectos.fecha_inicio',
                            'proyectos.fecha_fin',
                            'proyectos.progreso',
                            'proyectos.duracionm',
                            'proyectos.costo',
                            'proyectos.estado'])
                            ->where('usuarios.id','=',$userId)
                            ->where('area_adscripcion.nombre_area','=',$userArea)
                            ->get();

            //return response()->json($userProjects);
            return $userProjects;                

        }

        return ['error' => 'Error de autenticacion'];
        //return response()->json(['error' => 'Error de autenticacion']);
        
    }

    protected function getMulticoordData(){
        return Area::where('id','=', 12)->first();
    }
    public function addnewp(Request $request)
    {
        //mensajes de error personalizados
        $messages = [
            'nameproy.required' => 'Escribe un nombre para el proyecto',
            'year_to_realize_project.required' => 'Por favor selecciona un valor para este campo (:attribute)',
            'is_project_multicoord.required' => 'Por favor selecciona si el proyecto es multicoordinacion',
            'is_project_multicoord.in' => 'Selecciona un valor permitido "Sí" o "No"',
            'userpot.numeric' => 'Selecciona los 3 nivles del :attribute',
            'lins.numeric' => 'Selecciona una :attribute',
            'objs.numeric' => 'Selecciona un :attribute',
            'alin.numeric' => 'Selecciona una :attribute',
            'tran.numeric' => 'Selecciona un :attribute',
        ];
        //atributos del request
        $attributtes = [
            'year_to_realize_project' => 'Año de realización',
            'is_project_multicoord' => 'Proyecto multicoordinación',
            'userpot' => 'Cliente o Usuario Potencial',
            'lins' => 'Línea investigación',
            'objs' => 'Objetivo Sectorial',
            'alin' => 'Alineación',
            'tran' =>  'Modo de Transporte',
        ];

        $request->validate([
            'nameproy' => 'required',
            'objetivo' => 'required',
            'prodobt' => 'required',
            'userpot' => 'numeric',
            'alin' => 'numeric',
            'areas' => 'numeric',
            'lins' => 'numeric',
            'tran' => 'numeric',
            'objs' => 'numeric',
            'tipo' => 'required',
            'respon' => 'numeric',
            'aprobo' => 'numeric',
            'year_to_realize_project' => 'required',
            'is_project_multicoord' => 'required|in:Sí,No|string',
        ],$messages,$attributtes);

        //instancia de objeto a clase que nos permite la asignacion de numeros a proyectos de manera automatica
        $projectController = new ProyectoController();

        //comprobamos si el usuario selecciono la casilla de proyecto multicoordinacion
        if($request->input('is_project_multicoord') == 'Sí'){
            $areaProject = $this->getMulticoordData();
        }else{
            $areaProject = Area::find($request->get('areas'));
        }

        //obtenemos la clave del numero
        $claveNumber = $projectController->getNumberProject($areaProject->id,
        $request->input('year_to_realize_project'));

        //obtenemos la clave del anio
        $claveYear = $projectController->getValueYear($request->input('year_to_realize_project'));



        $pr = new Proyecto();
        $pr->id;
        $pr->nomproy = $request->get('nameproy');
        $pr->objetivo = $request->get('objetivo');
        $pr->idusuarior = $request->get('respon');
        $pr->producto = $request->get('prodobt');
        $pr->tipo = $request->get('tipo');
        $pr->cliente = $request->get('userpot');
        $pr->oculto;
        $pr->status;
        $pr->duracionm = $request->get('meses');
        $pr->idalin = $request->get('alin');
        $pr->idarea = $areaProject->id;
        $pr->idlinea = $request->get('lins');
        $pr->idmodot = $request->get('tran');
        $pr->aprobo = $request->get('aprobo');
        $pr->ncontratos = $request->get('atipo');
        $pr->otrotrans = $request->get('otran');
        $pr->idobjt = $request->get('objs');
        $pr->clavea = $areaProject->inicial_clave;
        $pr->clavet = $request->get('tipo');

        $pr->claven = $claveNumber;

        $pr->clavey = $claveYear;

        $res = $pr->save();
        if ($res) {
            if (session()->has('LoginId')) {
                $access = User::where('id', '=', session('LoginId'))->where('acceso', '=', 1)->first();
                $accessejec = User::where('id', '=', session('LoginId'))->where('acceso', '=', 2)->first();
                $accessuser = User::where('id', '=', session('LoginId'))->where('acceso', '=', 3)->first();
                //construimos la clave del proyecto y la regresamos
                if($pr->claven < 10){
                    $claveN = '0'.$pr->claven;
                }else{
                    $claveN =$pr->claven;
                }
                $key_project = $pr->clavea . $pr->clavet.'-'.$claveN.'/'.$pr->clavey;

                if ($access) {
                    return redirect('dashboard')->with([
                        'registered'=>'¡Proyecto registrado exitosamente!',
                        'key_project'=> $key_project
                    ]);
                } elseif ($accessejec) {
                    return redirect('dashboardresp')->with([
                        'registered'=>'¡Proyecto registrado exitosamente!',
                        'key_project'=> $key_project
                    ]);
                } elseif ($accessuser) {
                    return redirect('dashboardauser')->with([
                        'registered'=>'¡Proyecto registrado exitosamente!',
                        'key_project'=> $key_project
                    ]);
                } else {
                    return redirect('/');
                }
            }
        } else {
            return back()->with('fail', 'No se pudo resgistrar al nuevo usuario');
        }
    }


    public function infoproys( $id ){
        $proyt = Proyecto::where('id',$id)->first();
        $tareas = Tarea::where('idproyecto',$id)->count();

        if ($proyt->claven < 10) {
            $clave = $proyt->clavea.''.$proyt->clavet.'-0'.$proyt->claven.'/'.$proyt->clavey;
        } else 	{
            $clave = $proyt->clavea.''.$proyt->clavet.'-'.$proyt->claven.'/'.$proyt->clavey;
        }

        $publicacion = DB::table('siapimt25.imt_pub_publicacion')->where('CveProy', $clave)->first();

        if ($proyt->progreso == 100) {
            if ($proyt->clavet == 'I'){
                if ($proyt->publicacion == 1 || $proyt->publicacion == 2) {
                    $pr0 = Proyecto::find($id);
                    $pr0->estado = 2;
                    $pr0->save();
                }elseif ($proyt->publicacion == 0){
                    $pr0 = Proyecto::find($id);
                    $pr0->estado = 1;
                    $pr0->save();
                }
            } else {
                $pr0 = Proyecto::find($id);
                $pr0->estado = 2;
                $pr0->save();
            }
        }

        $pr1 = Proyecto::find($id);
        $pr1->numtar = $tareas;
        $pr1->save();
        
        $areas = Area::where('id',$proyt->idarea)->first();
        $resp = User::Join('proyectos','.aprobo','=','usuarios.id')
        ->join('area_adscripcion','area_adscripcion.id','=','usuarios.idarea')
        ->where('proyectos.id',$id)
        ->get(['usuarios.Nombre','usuarios.Apellido_Paterno','usuarios.Apellido_Materno'])->first();

        $user = User::where('id',$proyt->idusuarior)->first();
        $linea = Investigacion::where('id',$proyt->idlinea)->first();
        $alin = Alineacion::where('id',$proyt->idalin)->first();
        $cli = Cliente::where('id',$proyt->Cliente)->first();
        $obj = Objetivo::where('id',$proyt->idobjt)->first();
        $team = Equipo::join('proyectos','proyectos.id','=','equipo.idproyecto')
            ->join('usuarios','usuarios.id','=','equipo.idusuario')
            ->where('idproyecto',$id)
            ->get(['usuarios.nombre','usuarios.Apellido_Paterno','usuarios.Apellido_Materno']);
        //nuevo
            $materia = Materia::where('id',$proyt->materia)->first();
            $orien = Orientacion::where('id',$proyt->orientacion)->first();
            $nivel = Nivel::where('id',$proyt->nivel)->first();
        //Nuevo

        $contri = ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
                ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
                ->where('idproyecto',$id)
                ->get(['contribucion_a.nombre_contri']);
        $tran = Transporte::where('id',$proyt->idmodot)->first();

        $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        $LoggedUserInfo = User::where('id','=',session('LoginId'))->first();

            if ($LoggedUserInfo->id == $user->id) {
                $responsable = 1;
            } else {
                $responsable = 0;
            }

            if ($LoggedUserInfo['acceso'] == 2){
                $reanudar = 1;
            }else{
                $reanudar = 0;
            }
        //instancia al contrlador de estados
        $statusController = new StatusController();
        //instancia la contolador de porcentaje de progresos
        $porcentProjectController = new PorcentTasksController();
        //le agregamos lo campos para los estados, etiquetas y colores
        $proyt = $statusController->appendLabelAndColorStatus(Proyecto::select(
            'id',
            'nomproy',
            'clavea',
            'clavet',
            'claven',
            'clavey',
            'fecha_inicio',
            'fecha_fin',
            'idusuarior',
            'aprobo',
            'oculto',
            'progreso',
            'duracionm',
            'costo',
            'estado',
            'Tipo',
            'ncontratos',
            'objetivo',
            'producto',
            'materia',
            'orientacion',
            'nivel',
            'publicacion'
        )->where(
            [
                ['id','=',$id]
            ]
        )->get())[0];

            //si el proyecto tiene fecha de inicio y fecha de fin, independientemente del estado que tenga
        if(!empty($porcentProjectController->getDateStartProject($proyt->id)) &&
            !empty($porcentProjectController->getDateEndProject($proyt->id))){
            $proyt->porcent_program = $porcentProjectController->getPorcentProgrammedForTasks($proyt->id);
        }else{
            //en caso de que no tenga fecha de inicio y fin,dejamos en 0 el porcentaje programado
            $proyt->porcent_program = 0;
        }

        return view('infoproy', $data, compact('proyt','areas','user','linea','alin', 'nivel', 'publicacion',
        'cli','obj','contri','tran','team','resp', 'responsable', 'reanudar', 'materia', 'orien'));
    }

    public function infotec($id){
        if(session()->has('LoginId')){
            $proy = Proyecto::find($id);
            $proy->publicacion = 2;
            $res = $proy->save();
            if ($res) {
                return redirect('infoproys/'.$id);
            }else {
                return back()->with('fail', 'No se pudo resgistrar la tarea correctamente');
            }
        }
    }
    
    public function infoproy($id ){
        if(session()->has('LoginId')){
            $proyt = Proyecto::find($id);
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('infoproy',$data,compact('proyt'));
    }

    public function solicitud($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::find($id);
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('solicitud',$data, compact('proyt'));
    }

    public function soldcan($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::find($id);
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('solicitud_cancel',$data, compact('proyt'));
    }


    // Nuevo codigo

        public function sendsolicitud(Request $request, $id){
            $request -> validate([
                'obssol'=>'required',
            ]);

            $pr = Proyecto::find($id);
            $pr->cam_estado = 1;
            $pr->save();
            
            $posc = Observacion::all()->count();
            if ($posc == 0) {
                $posc = 1;
            } else {
                $posc++;
            }
            
            $obs = new Observacion();
            $obs->id = $posc;
            $obs->obs = $request->get('obssol');
            $obs->idproyecto = $id;
            $obs->tipo = 1;
            $obs->fechaobs = date("Y-m-d");
            $mes = date('m');
            $obs->yearobs = date(('Y'));
            switch ($mes) {
                case "1":
                    $obs->bimestreobs = "Enero-Febrero";
                    break;
                case "2":
                    $obs->bimestreobs = "Enero-Febrero";
                    break;
                case "3":
                    $obs->bimestreobs = "Marzo-Abril";
                    break;
                case "4":
                    $obs->bimestreobs = "Marzo-Abril";
                    break;
                case "5":
                    $obs->bimestreobs = "Mayo-Junio";
                    break;
                case "6":
                    $obs->bimestreobs = "Mayo-Junio";
                    break;
                case "7":
                    $obs->bimestreobs = "Julio-Agosto";
                    break;
                case "8":
                    $obs->bimestreobs = "Julio-Agosto";
                    break;
                case "9":
                    $obs->bimestreobs = "Septiembre-Octubre";
                    break;
                case "10":
                    $obs->bimestreobs = "Septiembre-Octubre";
                    break;
                case "11":
                    $obs->bimestreobs = "Noviembre-Diciembre";
                    break;
                case "12":
                    $obs->bimestreobs = "Noviembre-Diciembre";
                    break;
            }
            // correo
                $responsable = User::where('id', $pr->idusuarior)->first();
                $autoriza = User::where('id', $pr->aprobo)->first();
                $area = Area::where('id', $pr->idarea )->first();
                if ($pr->claven < 10) {
                    $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                } else 	{
                    $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                }
                $details = [
                    'mando' => $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno,
                    'responsable' => $responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno,
                    'area' => $area->nombre_area,
                    'clave' => $nombreproyecto,
                    'just' => $request->get('obssol'),
                    'idproy' => $id,
                    'idobs' => $posc
                ];
                Mail::to($autoriza->correo)->send(new Solicitudreprogramacion($details));
                // correo
            $res = $obs->save();
            if($res){
                if(session()->has('LoginId')){
                    $access = User::where('id','=',session('LoginId'))->where('acceso','=',1)->first();
                    $accessejec = User::where('id','=',session('LoginId'))->where('acceso','=',2)->first();
                    $accessuser = User::where('id','=',session('LoginId'))->where('acceso','=',3)->first();
                    if($access){
                        return redirect('infoproys/'.$id);
                    }elseif($accessejec){
                        return redirect('infoproys/'.$id);
                    }elseif($accessuser){
                        return redirect('infoproys/'.$id);
                    }else{
                        return redirect('/');
                    }
                }
            }else{
                return back()->with('fail','No se pudo resgistrar al nuevo usuario');
            }
        }

        public function rechazoreprogram(Request $request,$id, $ida){
            $request -> validate([
                'obsresp'=>'required',
            ]);
            $pr = Proyecto::find($id);
            $pr->cam_estado = 0;
            $pr->estado = 1;
            
            $obs = Observacion::find($ida);
            $obs->obs_respuesta = $request->get('obsresp');
            $obs->revisado = 2;

            $responsable = User::where('id', $pr->idusuarior)->first();
            $autoriza = User::where('id', $pr->aprobo)->first();
            $area = Area::where('id', $pr->idarea )->first();
            if ($pr->claven < 10) {
                $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
            } else 	{
                $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
            }
            $details = [
                'mando' => $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno,
                'responsable' => $responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno,
                'area' => $area->nombre_area,
                'clave' => $nombreproyecto,
                'justrechazo' => $request->get('obsresp')
            ];
            Mail::to($responsable->correo)->send(new Solicitudreprogramacionrechazada($details));

            $obs->save();
            $pr->save();

            if(session()->has('LoginId')){
                return redirect('observaciones/'.$id);
            }else {
                return view('loginuser');
            }
        }

        public function aceptarreprogram (Request $request, $id, $ida){
            
            $request -> validate([
                'datofichero'=>'required',
                'pass'=>'required'
            ]);

            date_default_timezone_set('America/Mexico_City');
            $data = User::where('id','=',session('LoginId'))->first();

            $nombre = explode(".", $request->get('datofichero'));
            $bdfirmas = DB::table('firmasimt.usuarios')->where('username', $nombre[0])->first();

            if( $request->get('pass') == $bdfirmas->pass){
                if ($data->curp == $bdfirmas->curp){
                    
                    DB::table('firmasimt.usuarioslog')->insert([
                        'idusuario' => $bdfirmas->id,
                        'fechalog' => date("Y-m-d"),
                        'timelog' => date("h:i:s", strtotime('-1 hour')),
                        'sistema' => 'SIREB',
                        'created_at' => date("Y-m-d h:i:s", strtotime('-1 hour')),
                        'updated_at' => date("Y-m-d h:i:s", strtotime('-1 hour'))
                    ]);

                    $pr = Proyecto::find($id);
                    $pr->cam_estado = 0;
                    $pr->estado = 4;
                    
                    $obs = Observacion::find($ida);
                    $obs->revisado = 1;
        
                    $responsable = User::where('id', $pr->idusuarior)->first();
                    $autoriza = User::where('id', $pr->aprobo)->first();
                    $area = Area::where('id', $pr->idarea )->first();
                    if ($pr->claven < 10) {
                        $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                    } else 	{
                        $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                    }
                    $details = [
                        'mando' => $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno,
                        'responsable' => $responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno,
                        'area' => $area->nombre_area,
                        'clave' => $nombreproyecto
                    ];
                    Mail::to($responsable->correo)->send(new Solicitudreprogramacionaceptada($details));
        
                    $nombremando = $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno;
                    $obs->fobsmando = $nombremando.'| IMT | '.date("Y-m-d").'||'.date("H:i:s");
                    $obs->save();
                    $pr->save();

                    return redirect('observaciones/'.$id);
                } else {
                    return back()->with('fail', 'La CURP del usuario no es la correspondiente');
                }
            } else {
                return back()->with('fail', 'Usuario o contraseña incorrecta, intenta de nuevo');
            }
        }

        public function sendsolicitudcancel (Request $request, $id){
            $request -> validate([
                'obssol'=>'required',
            ]);

            $pr = Proyecto::find($id);
            $pr->cam_estado = 1;
            $pr->save();
            
            $posc = Observacion::all()->count();
            if ($posc == 0) {
                $posc = 1;
            } else {
                $posc++;
            }

            
            $obs = new Observacion();
            $obs->id = $posc;
            $obs->obs = $request->get('obssol');
            $obs->idproyecto = $id;
            $obs->tipo = 2;
            $obs->fechaobs = date("Y-m-d");
            $mes = date('m');
            $obs->yearobs = date(('Y'));
            switch ($mes) {
                case "1":
                    $obs->bimestreobs = "Enero-Febrero";
                    break;
                case "2":
                    $obs->bimestreobs = "Enero-Febrero";
                    break;
                case "3":
                    $obs->bimestreobs = "Marzo-Abril";
                    break;
                case "4":
                    $obs->bimestreobs = "Marzo-Abril";
                    break;
                case "5":
                    $obs->bimestreobs = "Mayo-Junio";
                    break;
                case "6":
                    $obs->bimestreobs = "Mayo-Junio";
                    break;
                case "7":
                    $obs->bimestreobs = "Julio-Agosto";
                    break;
                case "8":
                    $obs->bimestreobs = "Julio-Agosto";
                    break;
                case "9":
                    $obs->bimestreobs = "Septiembre-Octubre";
                    break;
                case "10":
                    $obs->bimestreobs = "Septiembre-Octubre";
                    break;
                case "11":
                    $obs->bimestreobs = "Noviembre-Diciembre";
                    break;
                case "12":
                    $obs->bimestreobs = "Noviembre-Diciembre";
                    break;
            }
            // correo
                $responsable = User::where('id', $pr->idusuarior)->first();
                $autoriza = User::where('id', $pr->aprobo)->first();
                $area = Area::where('id', $pr->idarea )->first();
                if ($pr->claven < 10) {
                    $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                } else 	{
                    $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                }
                $details = [
                    'mando' => $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno,
                    'responsable' => $responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno,
                    'area' => $area->nombre_area,
                    'clave' => $nombreproyecto,
                    'just' => $request->get('obssol'),
                    'idproy' => $id,
                    'idobs' => $posc
                ];
                Mail::to($autoriza->correo)->send(new Solicitudcancelacion($details));
                // correo
            $res = $obs->save();
            if($res){
                if(session()->has('LoginId')){
                    $access = User::where('id','=',session('LoginId'))->where('acceso','=',1)->first();
                    $accessejec = User::where('id','=',session('LoginId'))->where('acceso','=',2)->first();
                    $accessuser = User::where('id','=',session('LoginId'))->where('acceso','=',3)->first();
                    if($access){
                        return redirect('infoproys/'.$id);
                    }elseif($accessejec){
                        return redirect('infoproys/'.$id);
                    }elseif($accessuser){
                        return redirect('infoproys/'.$id);
                    }else{
                        return redirect('/');
                    }
                }
            }else{
                return back()->with('fail','No se pudo resgistrar al nuevo usuario');
            }
        }

        public function rechazocancel(Request $request,$id, $ida){
            $request -> validate([
                'obsresp'=>'required',
            ]);
            $pr = Proyecto::find($id);
            $pr->cam_estado = 0;
            $pr->estado = 1;
            
            $obs = Observacion::find($ida);
            $obs->obs_respuesta = $request->get('obsresp');
            $obs->revisado = 2;

            $responsable = User::where('id', $pr->idusuarior)->first();
            $autoriza = User::where('id', $pr->aprobo)->first();
            $area = Area::where('id', $pr->idarea )->first();
            if ($pr->claven < 10) {
                $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
            } else 	{
                $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
            }
            $details = [
                'mando' => $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno,
                'responsable' => $responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno,
                'area' => $area->nombre_area,
                'clave' => $nombreproyecto,
                'justrechazo' => $request->get('obsresp')
            ];
            Mail::to($responsable->correo)->send(new Solicitudcancelacionrechazada($details));

            $obs->save();
            $pr->save();

            if(session()->has('LoginId')){
                return redirect('observaciones/'.$id);
            }else {
                return view('loginuser');
            }
        }

        public function aceptarcancel (Request $request,$id, $ida){
            $request -> validate([
                'datofichero'=>'required',
                'pass'=>'required'
            ]);

            date_default_timezone_set('America/Mexico_City');
            $data = User::where('id','=',session('LoginId'))->first();

            $nombre = explode(".", $request->get('datofichero'));
            $bdfirmas = DB::table('firmasimt.usuarios')->where('username', $nombre[0])->first();

            if( $request->get('pass') == $bdfirmas->pass){
                if ($data->curp == $bdfirmas->curp){

                    DB::table('firmasimt.usuarioslog')->insert([
                        'idusuario' => $bdfirmas->id,
                        'fechalog' => date("Y-m-d"),
                        'timelog' => date("h:i:s", strtotime('-1 hour')),
                        'sistema' => 'SIREB',
                        'created_at' => date("Y-m-d h:i:s", strtotime('-1 hour')),
                        'updated_at' => date("Y-m-d h:i:s", strtotime('-1 hour'))
                    ]);

                    $pr = Proyecto::find($id);
                    $pr->cam_estado = 0;
                    $pr->estado = 5;
                    
                    $obs = Observacion::find($ida);
                    $obs->revisado = 1;

                    $responsable = User::where('id', $pr->idusuarior)->first();
                    $autoriza = User::where('id', $pr->aprobo)->first();
                    $area = Area::where('id', $pr->idarea )->first();
                    if ($pr->claven < 10) {
                        $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                    } else 	{
                        $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                    }
                    $details = [
                        'mando' => $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno,
                        'responsable' => $responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno,
                        'area' => $area->nombre_area,
                        'clave' => $nombreproyecto
                    ];
                    Mail::to($responsable->correo)->send(new Solicitudcancelacionaceptada($details));

                    $nombremando = $autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno;
                    $obs->fobsmando = $nombremando.'| IMT | '.date("Y-m-d").'||'.date("H:i:s");
                    $obs->save();
                    $pr->save();

                    return redirect('observaciones/'.$id);
                } else {
                    return back()->with('fail', 'La CURP del usuario no es la correspondiente');
                }
            } else {
                return back()->with('fail', 'Usuario o contraseña incorrecta, intenta de nuevo');
            }
        }

        public function changestatusproy ($id){
            $getStatus = Proyecto::select('cam_estado')->where('id', $id)->first();
            if ($getStatus->cam_estado == 1) {
                $estado = 1;
            }
            Proyecto::where('id',$id)->update(['estado' => $estado, 'cam_estado' => 0]);
            if(session()->has('LoginId')){
                $access = User::where('id','=',session('LoginId'))->where('acceso','=',1)->first();
                $accessejec = User::where('id','=',session('LoginId'))->where('acceso','=',2)->first();
                $accessuser = User::where('id','=',session('LoginId'))->where('acceso','=',3)->first();
                if($access){
                    return redirect('infoproys/'.$id);
                }elseif($accessejec){
                    return redirect('infoproys/'.$id);
                }elseif($accessuser){
                    return redirect('infoproys/'.$id);
                }else{
                    return redirect('/');
                }
            }
        }

        public function reporteaceptado($id, $ida){
            if (session()->has('LoginId')) {
                $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoginId'))->first()];
                $user = User::where('id', '=', session('LoginId'))->first();
                $fechayear = date('Y');
                $fecha = date('Y-m-d');
                $pr = Proyecto::find($id);
                $obs = Observacion::find($ida);
                $responsable = User::where('id', $pr->idusuarior)->first();
                $autoriza = User::where('id', $pr->aprobo)->first();
                $area = Area::where('id', $pr->idarea )->first();

                if ($pr->claven < 10) {
                    $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                } else 	{
                    $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
                }
            }
            if ($obs->tipo == 1) {
                $file = 'Autorización Reprogramacion-'.$nombreproyecto;
                $pdf = PDF::loadView('reporteaprobado', $data, compact('user', 'fechayear', 'pr', 'obs', 'responsable','autoriza', 'area', 'fecha', 'nombreproyecto'));
                return $pdf->stream($file.'.pdf');
                // return view ('reporteaprobadoaceptado', $data, compact('user', 'fechayear', 'pr', 'obs', 'responsable','autoriza', 'area', 'fecha'));
            } else {
                $file = 'Autorización Cancelación-'.$nombreproyecto;
                $pdf = PDF::loadView('reporteaprobadocancel', $data, compact('user', 'fechayear', 'pr', 'obs', 'responsable','autoriza', 'area', 'fecha', 'nombreproyecto'));
                return $pdf->stream($file.'.pdf');
                // return view ('reporteaprobadocancelado', $data, compact('user', 'fechayear', 'pr', 'obs', 'responsable','autoriza', 'area', 'fecha'));
            }
        }

        public function vistainfoobs($id, $ida){
            if (session()->has('LoginId')) {
                $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoginId'))->first()];
                $user = User::where('id', '=', session('LoginId'))->first();
                $proyt = Proyecto::find($id);
                $obs = Observacion::find($ida);
                $responsable = User::where('id', $proyt->idusuarior)->first();
                $autoriza = User::where('id', $proyt->aprobo)->first();
                $area = Area::where('id', $proyt->idarea )->first();
            }
            return view ('infosolicitud', $data, compact('user', 'proyt', 'obs', 'responsable','autoriza', 'area'));
            
        }

    // Nuevo codigo


    //  NO se usa este codigo
    public function aprosolicitud(Request $request, $id){
        $request -> validate([
            'obssol'=>'required',
            'solr'=>'numeric'
        ]);
        $pr = Proyecto::find($id);
        if ($request->get('solr') == 0){
            if ($pr->cam_estado == 4)
            {
                $pr->Observaciones = $pr->Observaciones.' Reprogramacion: '.$request->get('obssol');
                $pr->estado = $pr->cam_estado;
                $pr->obser_cam = "";
                $pr->cam_estado = 0;
                $pr->activo_act = 1;
            }
            elseif ($pr->cam_estado == 3)
            {
                $pr->Observaciones = $pr->Observaciones.' Pausa: '.$request->get('obssol');
                $pr->estado = $pr->cam_estado;
                $pr->obser_cam = "";
                $pr->cam_estado = 0;
            }
            elseif ($pr->cam_estado == 5)
            {
                $pr->Observaciones = $pr->Observaciones.' Cancelación: '.$request->get('obssol');
                $pr->estado = $pr->cam_estado;
                $pr->obser_cam = "";
                $pr->cam_estado = 0;
            }
        }
        else{
            if ($pr->cam_estado == 3){
                $pr->Observaciones = 'Pausa denegada: '.$request->get('obssol');
                $pr->obser_cam = "";
                $pr->cam_estado = 0;
            }
            elseif($pr->cam_estado == 4)
            {
                $pr->Observaciones = 'Reprogramacion denegada: '.$request->get('obssol');
                $pr->obser_cam = "";
                $pr->cam_estado = 0;
            }
            elseif($pr->cam_estado == 5){
                $pr->Observaciones = 'Cancelación denegada: '.$request->get('obssol');
                $pr->obser_cam = "";
                $pr->cam_estado = 0;
            }
        }
        $res = $pr->save();
        if($res){
            if(session()->has('LoginId')){
                $access = User::where('id','=',session('LoginId'))->where('acceso','=',1)->first();
                $accessejec = User::where('id','=',session('LoginId'))->where('acceso','=',2)->first();
                $accessuser = User::where('id','=',session('LoginId'))->where('acceso','=',3)->first();
                if($access){
                    return redirect('infoproys/'.$id);
                }elseif($accessejec){
                    return redirect('infoproys/'.$id);
                }elseif($accessuser){
                    return redirect('infoproys/'.$id);
                }else{
                    return redirect('/');
                }
            }
        }else{
            return back()->with('fail','No se pudo resgistrar al nuevo usuario');
        }
    }
    // no se usa este codigo

    public function upproys($id){
        $proyt = Proyecto::where('id',$id)->first();

        $areass = Area::where('id',$proyt->idarea)->first();
        $users = User::where('id',$proyt->idusuarior)->first();
        $lineas = Investigacion::where('id',$proyt->idlinea)->first();
        $alinss = Alineacion::where('id',$proyt->idalin)->first();
        $clis = Cliente::where('id',$proyt->Cliente)->first();
        $objss = Objetivo::where('id',$proyt->idobjt)->first();
        $contris = Contribucion::where('id',$proyt->idcontri)->first();
        $transs = Transporte::where('id',$proyt->idmodot)->first();
        $search = User::where('id','=',session('LoginId'))->first();
        $areauser= Area::where('id',$search->idarea)->first();
        $resp = User::Where('idarea',$areauser->id)->where('responsable',1)->first();
        $orent = Orientacion::where('id', $proyt->orientacion)->first();
        $nivelp = Nivel::where('id', $proyt->nivel)->first();
        $mate = Materia::where('id', $proyt->materia)->first();


        $contri = Contribucion::where('status',1)->get();
        $areas = Area::where('status',1)->orderBy('nombre_area', 'ASC')->get();
        $invs = Investigacion::where('status',1)->orderBy('nombre_linea', 'ASC')->get();
        $objs = Objetivo::where('status',1)->get();
        $trans = Transporte::where('status',1)->get();
        $alins = Alineacion::where('status',1)->get();
        $clie = Cliente::where('status',1)->orderBy('nivel1', 'DESC')->orderBy('nivel2', 'ASC')->orderBy('nivel3', 'ASC')->get();
        //Nuevas tablas
            $materia = Materia::where('status', 1)->get();
            $orientacion = Orientacion::where('status', 1)->get();
            $nivel = Nivel::where('status', 1)->get();
        //Nuevas tablas

        //listado de niveles de clientes y cliente actual para enviar los elementos 
        //lista de categorias N1
        $categoriesN1 = $this->getCategoriesList();
        //lista de categorias basado en nivel 1 y nivel 2 del cliente
        $categoriesN2 = $this->getCategoriesListN2($clis->nivel1);
        $categoriesN3 = $this->getCategoriesListN3($clis->nivel1,$clis->nivel2);

        $user = User::where('status',1)->where('acceso','!=',4)->Where('acceso','!=',5)
                ->orderBy('Apellido_Paterno', 'ASC')
                ->orderBy('Apellido_Materno', 'ASC')
                ->orderBy('nombre', 'ASC')
                ->get();

        return view('upproy',compact('proyt','contri','areas','invs','objs','trans','alins','user', 'clie', 'materia', 'mate',
        'areass','users','lineas','clis','objss','contris','transs','alinss','resp', 'orientacion', 'nivel', 'orent', 'nivelp',            
        'categoriesN1',
        'categoriesN2',
        'categoriesN3',));
    }

    public function upproy(Request $request, $id){
        $pr = Proyecto::find($id);
        $tareafecha = Tarea::Where('idproyecto',$id)->min('fecha_inicio');//obtiene la menor fecha de inicio de una actividad
        $tareafecha1 = Tarea::Where('idproyecto',$id)->max('fecha_fin');//obtiene la mayor fecga de fin de una actividad
        $anio = date("Y", strtotime($tareafecha));//obtiene el año de la primera fecha
        $anio1 = date("Y", strtotime($tareafecha1));//obtiene el año de la ultima fecha
        $mes = date("m", strtotime($tareafecha));//obtiene el mes de la primera fecha
        $mes1 = date("m", strtotime($tareafecha1));//obtiene el mes de la ultima fecha
        if($mes===0){
            $mes++;
            $mes1++;
        }
        $duracion = ($anio1 - $anio) * 12 + ($mes1 - $mes) + 1; //Esta operacion calcula el numero de meses entre dos fechas
        $request -> validate([
            'nameproy'=>'required',
            'objetivo'=>'required',
            'prodobt'=>'required',
            'userpot'=>'numeric',
            'alin'=>'numeric',
            'areas'=>'numeric',
            'lins'=>'numeric',
            'tran'=>'numeric',
            'objs'=>'numeric',
            'respon'=>'numeric',
            // 'costo'=>'numeric',
            'orien'=>'numeric',
            'nivel'=>'numeric',
            'materia'=>'numeric'
        ]);
        $pr->id;
        $pr->nomproy = $request->get('nameproy');
        $pr->objetivo = $request->get('objetivo');
        $pr->idusuarior = $request->get('respon');
        $pr->producto = $request->get('prodobt');
        $pr->tipo= $request->get('tipo');
        $pr->cliente= $request->get('userpot');
        $pr->ncontratos = $request->get('atipo');
        // $pr->costo = $request->get('costo');
        $pr->duracionm = $duracion;
        $pr->fecha_inicio = $tareafecha;//guarda la primera fecha en el inicio del proyecto
        $pr->fecha_fin = $tareafecha1;//guarda la ultima fecha en el fin del proyecto
        $pr->oculto;
        $pr->status;
        $pr->idalin = $request->get('alin');
        $pr->idarea = $request->get('areas');
        $pr->idlinea = $request->get('lins');
        $pr->idmodot = $request->get('tran');
        $pr->aprobo = $request->get('aprobo');
        $pr->otrotrans = $request->get('otran');
        $pr->idobjt = $request->get('objs');
        $pr->orientacion = $request->get('orien');
        $pr->nivel = $request->get('nivel');
        $pr->materia = $request->get('materia');
        $res = $pr->save();
        if($res){
            if(session()->has('LoginId')){
                $access = User::where('id','=',session('LoginId'))->where('acceso','=',1)->first();
                $accessejec = User::where('id','=',session('LoginId'))->where('acceso','=',2)->first();
                $accessuser = User::where('id','=',session('LoginId'))->where('acceso','=',3)->first();
                if($access){
                    return redirect('infoproys/'.$id);
                }elseif($accessejec){
                    return redirect('infoproys/'.$id);
                }elseif($accessuser){
                    return redirect('infoproys/'.$id);
                }else{
                    return redirect('/');
                }
            }
        }else{
            return back()->with('fail','No se pudo resgistrar al nuevo usuario');
        }
    }

    public function iniciarproy($id){
        if(session()->has('LoginId')){
            $proy = Proyecto::find($id);
            $proy->estado = 1;
            $res = $proy->save();
            if ($res) {
                return redirect('tareag/'.$id);
            }else {
                return back()->with('fail', 'No se pudo resgistrar la tarea correctamente');
            }
        }
    }
/*Proyectos Fin  */

/*Tareas Inicio*/
    public function tareag($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $tarea = Tarea::Where('idproyecto',$id)->orderBy('fecha_inicio', 'ASC')->get();

            $existen = Tarea::Where('idproyecto',$id)->count();

            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
            $progres = Tarea::where('idproyecto',$id)->get();//se usa para generara un arreglo a recorrer
            $mesesa = Tarea::Where('idproyecto',$id)->sum('duracion');//se usa para obtener el total de la duracion del las tarea
            $pr = Proyecto::find($id);
            $f = 0;
            $fr = 0;
            if($mesesa != 0){
                $real = (1*100)/$mesesa;//calcula el valor de un unidad de la duracion total de las actividades
                foreach ($progres as $progre) {
                    $c = $progre->duracion;//obtiene la duracion de la actividad recorrida por el arreglo
                    $p = $progre->progreso;//obtiene el progreso de la actividad recorrida por el arreglo
                    $op = $real * $c;//multiplica el valor de una unidad total de las actividades por la duracion de la tarea
                    $f = ($op*$p)/100;// multiplica el progreso por la operacion anterior y lo divide entre 100
                    $fr = $fr+$f;//suma los resultados de cada recorrido del arreglo por la formula
                }
            }
            $fr;//almacena el resultado de todas las sumas del foreach que dio como resultado el pocentaje total de avance del proyecto
            $proy = Proyecto::find($id);
            $proy->progreso = round($fr,2);//redondea el valor del resultado anterior a 2 decimales y lo alamacena en el progreso del proyecto
            $proy->save();
            $tareafecha = Tarea::Where('idproyecto',$id)->min('fecha_inicio');//busca la menor fecha de inicio de las actividades o tareas
            $tareafecha1 = Tarea::Where('idproyecto',$id)->max('fecha_fin');//busca la mayor fecha de fin de las actividades o tareas
            $anio = date("Y", strtotime($tareafecha));//convierta la fecha de inicio a solo el año
            $anio1 = date("Y", strtotime($tareafecha1));//convierta la fecha de fin a solo el año
            $mes = date("m", strtotime($tareafecha));//convierta la fecha de inicio a solo el mes
            $mes1 = date("m", strtotime($tareafecha1));//convierta la fecha de fin a solo el mes
            if($mes===0){
                $mes++;
                $mes1++;
            }
            $duracion = ($anio1 - $anio) * 12 + ($mes1 - $mes) + 1;//calcula la duracion en meses del proyecto en base a las dos fechas antes mencionadas
            $pr->duracionm = $duracion;
            $pr->fecha_inicio = $tareafecha;
            $pr->fecha_fin = $tareafecha1;
            $pr->save();
        }
        return view('tareag',$data,compact('proyt','tarea', 'existen'));
    }

    public function tareas($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('addtarea',$data,compact('proyt'));
    }

    public function tarea(Request $request, $id ){
        $proy = Proyecto::find($id);
            $request -> validate([
                'act'=>'required',
                'inicio'=>'date',
                'fin'=>'date|after_or_equal:inicio',
                'idproy'=>'numeric',
            ]);
        $tarea = new Tarea();
        /* esta formula repite lo mismo que la anterior para sacar
        la duracion en meses pero ahora para una sola actividad*/
        $fechain = $request->get('inicio');
        $fechafin = $request->get('fin');
        $anio = date("Y", strtotime($fechain));
        $anio1 = date("Y", strtotime($fechafin));
        $mes = date("m", strtotime($fechain));
        $mes1 = date("m", strtotime($fechafin));
            if($mes===0){
                $mes++;
                $mes1++;
            }
        $duracion = ($anio1 - $anio) * 12 + ($mes1 - $mes) + 1;
        $tarea->actividad = $request->get('act');
        $tarea->fecha_inicio = $request->get('inicio');
        $tarea->fecha_fin = $request->get('fin');
        $tarea->duracion = $duracion;
        $tarea->idproyecto = $request->idproy;
        $res = $tarea->save();
        $proy->save();
        if ($res) {
            return redirect('tareag/'.$id);
        }else {
            return back()->with('fail', 'No se pudo resgistrar la tarea correctamente');
        }
    }

    public function avance($id,$idt){
        $proyt = Proyecto::where('id',$id)->first();
        $tarea = Tarea::where('id',$idt)->first();
        $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        $mesesa = Tarea::Where('idproyecto',$id)->sum('duracion');
        $real = (1*100)/$mesesa;
        $c = $tarea->duracion;
        $p = $tarea->progreso;
        $op = $real * $c;
        $f = ($op*$p)/100;
        return view('avancetarea',$data,compact('proyt','tarea','real','op','f'));
    }

    public function upavance(Request $request, $id,$idt){
        $progres = Tarea::where('idproyecto',$id)->get();
        $total = 0;
        $actualfinal = 0;
        $avance = Tarea::where('idproyecto',$id)->get()->count();
        /* esta foreach realiza el mismo proceso para obtener el
        proceso pero este se encarga de actualizar cuando se hace un avance en una actividad*/
        foreach($progres as $progre){
            $final = 100*$avance; //se multiplica por 100 el total de actividades
            $total = $progre->progreso + $total;// se suman el progreso de todas las actividades en una variable
            $actual = (100*$total)/$final;//se multiplica por 100 la suma anterior y se divide entre el resultado de la primera opreracion
            $actualfinal = round($actual);//se redonde el resultado final
        }
        $proy = Proyecto::find($id);
        $proy->progreso = $actualfinal;
        $proy->save();
        $request -> validate([
            'avpor'=>'numeric',
        ]);

        $tarea = Tarea::find($idt);
        $tarea->progreso = $request->get('avpor1');
        $tarea->save();
        return redirect('tareag/'.$id);
    }

    public function uptareas($id,$idt){
        $proyt = Proyecto::where('id',$id)->first();
        $tarea = Tarea::where('id',$idt)->first();
        $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        return view('uptarea',$data,compact('proyt','tarea'));
    }

    public function uptarea(Request $request, $id, $idt){
        $tarea = Tarea::find($idt);
        $fechain = $request->get('inicio');
        $fechafin = $request->get('fin');

	    $request -> validate([
                'fin'=>'date|after_or_equal:inicio',
        ]);

        /* realiza el mismo proceso para obtener la duracion en meses de la actividad
        pero de una actividad que se actualizo*/
        $anio = date("Y", strtotime($fechain));
        $anio1 = date("Y", strtotime($fechafin));
        $mes = date("m", strtotime($fechain));
        $mes1 = date("m", strtotime($fechafin));
            if($mes===0){
                $mes++;
                $mes1++;
            }
        $duracion = ($anio1 - $anio) * 12 + ($mes1 - $mes) + 1;
        $tarea->actividad = $request->get('act');
        $tarea->fecha_inicio = $request->get('inicio');
        $tarea->fecha_fin = $request->get('fin');
        $tarea->idproyecto = $request->get('idproy');
        $tarea->duracion = $duracion;
        $tarea->save();
        return redirect('tareag/'.$id);
    }

    public function destroytarea($id,$ida){
        $tarea= Tarea::find($ida);
        $tarea->delete();
        return redirect('tareag/'.$id);
    }

/*Tareas Fin*/

/*Equipo Inicio */
    public function Equipo($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $equipos= Equipo::join('usuarios','usuarios.id','=','equipo.idusuario')
                ->join('proyectos','proyectos.id','=','equipo.idproyecto')
                ->orderBy('usuarios.Apellido_Paterno', 'ASC')
                ->orderBy('usuarios.Apellido_Materno', 'ASC')
                ->orderBy('usuarios.Nombre', 'ASC')
                ->Where('idproyecto',$id)
                ->get(['equipo.id','usuarios.Nombre','usuarios.Apellido_Paterno', 'usuarios.Apellido_Materno']);
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('Equipo',$data,compact('proyt','equipos'));
    }
    public function addequipos($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $user = User::where('status',1)->where('acceso','!=',4)->Where('acceso','!=',5)->where('id','!=',session('LoginId'))
            ->orderBy('Apellido_Paterno', 'ASC')->orderBy('Apellido_Materno', 'ASC')->orderBy('nombre', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('addequipo',$data,compact('proyt','user'));
    }
    public function addequipo(Request $request, $id ){
            $request -> validate([
                'idproy'=>'numeric',
                'equipo'=>'numeric'
            ]);
        $equipo = new Equipo();
        $equipo->idproyecto = $request->idproy;
        $equipo->idusuario = $request->equipo;
        $res = $equipo->save();
        if($res){
            return redirect('Equipo/'.$id);
        }else{
            return back()->with('fail','No se pudo resgistrar la tarea correctamente');
        }
    }
    public function destroyequipo($id,$ida){
        $equipo= Equipo::find($ida);
        $equipo->delete();
        return redirect('Equipo/'.$id);
    }
/*Equipo Fin */

/*Materia Inicio */
    public function Materia($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $materia= MateriaPr::join('materia','materia.id','=','materias_proy.idmateria')
                        ->join('proyectos','proyectos.id','=','materias_proy.idproy')
                        ->Where('materias_proy.idproy',$id)
                        ->get(['materias_proy.id','materia.descmateria']);

            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('Materia',$data,compact('proyt','materia'));
    }
    public function addmaterias($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $materia = Materia::where('status',1)->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('addmateria',$data,compact('proyt','materia'));
    }
    public function addmateria(Request $request, $id ){
            $request -> validate([
                'idproy'=>'numeric',
                'materia'=>'numeric'
            ]);
        $material = new MateriaPr();
        $material->idproy = $request->idproy;
        $material->idmateria = $request->materia;
        $res = $material->save();
        if($res){
            return redirect('Materia/'.$id);
        }else{
            return back()->with('fail','No se pudo resgistrar la tarea correctamente');
        }
    }
    public function destroymateria($id,$ida){
        $equipo= MateriaPr::find($ida);
        $equipo->delete();
        return redirect('Materia/'.$id);
    }
/*Materia Fin */

/*Nuevo Solicitudes Inicio*/
    
    public function observaciones ($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $obs= Observacion::Where('idproyecto',$id)->get();

            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('solicitudes',$data,compact('proyt','obs'));
    }

    public function revisionobs($id, $ida){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $obs= Observacion::Where('id',$ida)->first();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('respuestasolicitud',$data,compact('proyt','obs'));
    }

/*Nuevo Solicitudes Fin*/

/*Recursos Inicio */
    public function recursosproy($id){
        if(session()->has('LoginId')){
            $proyt = Proyecto::where('id',$id)->first();
            $rescm= RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','M')
                ->get(['recursos_general.id','recursos.partida','recursos.concepto', 'recursos_general.cantidad']);
            $subtotalm = RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','M')
                ->sum('recursos_general.cantidad');
            $rescf= RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','F')
                ->get(['recursos_general.id','recursos.partida','recursos.concepto', 'recursos_general.cantidad']);
            $subtotalf = RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','F')
                ->sum('recursos_general.cantidad');
            $resct= RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','T')
                ->get(['recursos_general.id','recursos.partida','recursos.concepto', 'recursos_general.cantidad']);
            $subtotalt = RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','T')
                ->sum('recursos_general.cantidad');
            $resch= RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','H')
                ->get(['recursos_general.id','recursos.partida','recursos.concepto', 'recursos_general.cantidad']);
            $subtotalh = RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','H')
                ->sum('recursos_general.cantidad');
            $resco= RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','O')
                ->get(['recursos_general.id','recursos.partida','recursos.concepto', 'recursos_general.cantidad']);
            $subtotalo = RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->where('clave','O')
                ->sum('recursos_general.cantidad');
            $total = RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->sum('recursos_general.cantidad');
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];

            if($proyt->Tipo == 'E'){
                $iva = 16;
                $costo = round((($total*$iva)/100),2);
                $final = round(($total+$costo),2);
                $proyt->costo = $final;
            }else{
                $proyt->costo = $total;
            }
            $proyt->save();
        }
        return view('recursosg',$data,compact('proyt','rescf','rescm','resct','resch','resco','subtotalm','subtotalf','subtotalh','subtotalo','subtotalt','total'));
    }

    public function addrecursosproyf($id){
            $resc = Recursos::where('status',1)->where('clave','F')->orderBy('partida', 'ASC')->get();
            $proyt = Proyecto::where('id',$id)->first();
        return view('addrecursog',compact('resc','proyt'));
    }
    public function addrecursosproym($id){
            $resc = Recursos::where('status',1)->where('clave','M')->orderBy('partida', 'ASC')->get();
            $proyt = Proyecto::where('id',$id)->first();
        return view('addrecursog',compact('resc','proyt'));
    }
    public function addrecursosproyt($id){
            $resc = Recursos::where('status',1)->where('clave','T')->orderBy('partida', 'ASC')->get();
            $proyt = Proyecto::where('id',$id)->first();
        return view('addrecursog',compact('resc','proyt'));
    }
    public function addrecursosproyh($id){
            $resc = Recursos::where('status',1)->where('clave','H')->orderBy('partida', 'ASC')->get();
            $proyt = Proyecto::where('id',$id)->first();
        return view('addrecursog',compact('resc','proyt'));
    }
    public function addrecursosproyo($id){
            $resc = Recursos::where('status',1)->where('clave','O')->orderBy('partida', 'ASC')->get();
            $proyt = Proyecto::where('id',$id)->first();
        return view('addrecursog',compact('resc','proyt'));
    }

    public function addrecursoproy(Request $request, $id ){
            $request -> validate([
                'idproy'=>'numeric',
                'resc'=>'numeric',
                'cant'=>'numeric'
            ]);
        $resg = new RecursosGeneral();
        $resg->idproyecto = $request->idproy;
        $resg->idrecurso = $request->resc;
        $resg->cantidad = $request->cant;
        $res = $resg->save();
        if($res){
            return redirect('recursosproy/'.$id);
        }else{
            return back()->with('fail','No se pudo resgistrar el recurso correctamente');
        }
    }
    public function Recursos(){
        if(session()->has('LoginId')){
            $resc = Recursos::orderBy('partida', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('Recursos',$data,compact('resc'));
    }
    public function changestatusrecu (Request $request){
        $resc = Recursos::findOrFail($request->id);
        $resc->status =  $request->status;
        $resc->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function addrecus(){
        return view('addrecursos');
    }
    public function addrecu (Request $request){
        $request -> validate([
            'partida'=>'numeric',
            'clave'=>'required',
            'concepto'=>'required'
        ]);
        $resc = new Recursos();
        $resc->id;
        $resc->partida = $request->get('partida');
        $resc->concepto = $request->get('concepto');
        $resc->clave = $request->get('clave');
        $res = $resc->save();
        if($res){
            return redirect('Recursos');
        }else{
            return back()->with('fail','No se agrego el recurso correctamente');
        }
    }
    public function uprecu ( $id ){
        $resc = Recursos::where('id',$id)->first();
        return view('uprecursos',compact('resc'));
    }
    public function uprecus (Request $request, $id ){
        $resc = Recursos::find($id);
        $request -> validate([
            'partida'=>'numeric',
            'clave'=>'required',
            'concepto'=>'required'
        ]);
        $resc->id;
        $resc->partida = $request->get('partida');
        $resc->concepto = $request->get('concepto');
        $resc->clave = $request->get('clave');
        $res = $resc->save();
        if($res){
            return redirect('Recursos');
        }else{
            return back()->with('fail','No se actualizar el recurso correctamente');
        }
    }
    public function destroyrecurso(Request $request,$id,$ida){
        $recs= RecursosGeneral::find($ida);
        $recs->delete();
        return redirect('recursosproy/'.$id);
    }
/*Recursos Fin */

/*Contribuciones Inicio*/
    public function contribuciones($id){
        if(session()->has('LoginId')){
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
            $proyt = Proyecto::where('id',$id)->first();
            $contri= ContribucionesProyecto::join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
                ->join('proyectos','proyectos.id','=','contribuciones.idproyecto')
                ->orderBy('contribucion_a.nombre_contri', 'ASC')
                ->Where('idproyecto',$id)
                ->get(['contribuciones.id','contribucion_a.nombre_contri']);
        }
        return view('contribuciones', $data,compact('contri', 'proyt'));
    }

    public function addcontribuciones($id){
        $proyt = Proyecto::where('id',$id)->first();
        $contri = Contribucion::where('status',1)->get();
        return view('addcontribuciones',compact('contri','proyt'));
    }
    public function addcontribucione(Request $request,$id){
        $request -> validate([
            'contri'=>'numeric',
            'idproy'=>'numeric'
        ]);
        $resg = new ContribucionesProyecto();
        $resg->id;
        $resg->idcontri = $request->get('contri');
        $resg->idproyecto = $request->get('idproy');
        $res = $resg->save();
        if($res){
            return redirect('contribuciones/'.$id);
        }else{
            return back()->with('fail','No se pudo resgistrar la contribucion correctamente');
        }
    }
    public function destroycontribucion($id,$ida){
        $contris= ContribucionesProyecto::find($ida);
        $contris->delete();
        return redirect('contribuciones/'.$id);
    }
/*Contribuciones Fin*/

/*Puesto Inicio*/
    public function puesto(){
        if(session()->has('LoginId')){
            $allpuesto = Puesto::orderBy('puesto', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('Puesto',$data,compact('allpuesto'));
    }
    public function addpuestos(){
        if(session()->has('LoginId')){
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('addpuesto',$data);
    }
    public function addpuesto(Request $request){
        $request -> validate([
                'puesto'=>'required',
                'cxh'=>'numeric'
            ]);
        $puesto = new Puesto();
        $puesto->puesto = $request->get('puesto');
        $puesto->costoxhora = $request->get('cxh');
        $res = $puesto->save();
        if($res){
            return redirect('puesto');
        }else{
            return back()->with('fail','No se pudo resgistrar el puesto correctamente');
        }
    }
    public function changestatupuest (Request $request){
        $contri = Puesto::findOrFail($request->id);
        $contri->status =  $request->status;
        $contri->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function uppuestos ( $id ){
        $puesto = Puesto::where('id',$id)->first();
        return view('uppuesto',compact('puesto'));
    }
    public function uppuesto (Request $request, $id ){
        $puesto = Puesto::find($id);
        $request -> validate([
                'puesto'=>'required',
                'cxh'=>'numeric'
            ]);
        $puesto->puesto = $request->get('puesto');
        $puesto->costoxhora = $request->get('cxh');
        $res = $puesto->save();
        if($res){
            return redirect('puesto');
        }else{
            return back()->with('fail','No se pudo actualizar el puesto correctamente');
        }
    }
/*Puesto Fin*/

/*Contribucion inicio*/
    public function indexcontri (){
        if(session()->has('LoginId')){
            $allContri = Contribucion::orderBy('nombre_contri', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('contribucion',$data,compact('allContri'));
    }
    public function changestatuscontri (Request $request){
        $contri = Contribucion::findOrFail($request->id);
        $contri->status =  $request->status;
        $contri->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function addcontribu (Request $request){
        $request -> validate([
            'name'=>'required',
        ]);
        $contri = new Contribucion();
        $contri->id;
        $contri->nombre_contri = $request->get('name');
        $contri->status;
        $res = $contri->save();
        if($res){
            return redirect('contri');
        }else{
            return back()->with('fail','No se agrego la nueva contribución  correctamente');
        }
    }
    public function upcontri ( $id ){
        $contri = Contribucion::where('id',$id)->first();
        return view('upcontri',compact('contri'));
    }
    public function upcontris (Request $request, $id ){
        $request -> validate([
            'name'=>'required',
        ]);
        $contris = Contribucion::find($id);
        $contris->nombre_contri = $request->get('name');
        $contris->save();
        $res = $contris->save();
        if($res){
            return redirect('contri');
        }else{
            return back()->with('fail','No se actualizo la contribución correctamente');
        }
    }
/*Contribucion fin*/

/*Area de adscripcion inicio*/
    public function indexarea (){
        if(session()->has('LoginId')){
            $areas = Area::orderBy('nombre_area', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('modArea',$data,compact('areas'));
    }
    public function changestatus (Request $request){
        $area = Area::findOrFail($request->id);
        $area->status =  $request->status;
        $area->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function addar (Request $request){
        $request -> validate([
            'name'=>'required',
            'siglas'=>'required',
            'letra'=>'required'
        ]);
        $area = new Area();
        $area->nombre_area = $request->get('name');
        $area->siglas = $request->get('siglas');
        $area->inicial_clave = $request->get('letra');
        $area->status;
        $res = $area->save();
        if($res){
            return redirect('moda');
        }else{
            return back()->with('fail','No se agrego el area correctamente');
        }

    }
    public function uparea ( $id ){
        $key = Area::where('id',$id)->first();
        return view('uparea',compact('key'));
    }
    public function upareas (Request $request, $id ){
        $request -> validate([
            'name'=>'required',
            'siglas'=>'required',
            'letra'=>'required'
        ]);
        $areas = Area::find($id);
        $areas->nombre_area = $request->get('name');
        $areas->siglas = $request->get('siglas');
        $areas->inicial_clave = $request->get('letra');
        $res = $areas->save();
        if($res){
            return redirect('moda');
        }else{
            return back()->with('fail','No se actualizo el area correctamente');
        }
    }
/*Area de adscripcion fin*/

/*Linea de investigacion inicio*/
    public function indexinvestigacion (){
        if(session()->has('LoginId')){
            $invs = Investigacion::orderBy('rubro', 'DESC')->orderBy('nombre_linea', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('modInvestigacion',$data,compact('invs'));
    }
    public function changestatusinv (Request $request){
        $inv = Investigacion::find($request->id);
        $inv->status =  $request->status;
        $inv->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function addlininv (Request $request){
        $request -> validate([
            'name'=>'required',
            'rubro' => 'required'
        ]);
        $inves = new Investigacion();
        $inves->id;
        $inves->nombre_linea = $request->get('name');
        $inves->rubro = $request->get('rubro');
        $inves->status;
        $res = $inves->save();
        if($res){
            return redirect('modinv');
        }else{
            return back()->with('fail','No se agrego la linea de investigación correctamente');
        }
    }
    public function upinv ( $id ){
        $invs = Investigacion::where('id',$id)->first();
        return view('upinv',compact('invs'));
    }
    public function upinvs (Request $request, $id ){
        $request -> validate([
            'name'=>'required',
            'rubro' => 'required'
        ]);
        $invesi = Investigacion::find($id);
        $invesi->nombre_linea = $request->get('name');
        $invesi->rubro = $request->get('rubro');
        $res = $invesi->save();
        if($res){
            return redirect('modinv');
        }else{
            return back()->with('fail','No se actualizo la linea de investigación correctamente');
        }
    }
/*Linea de investigacion fin*/

/*Objetivo sectorial inicio*/
    public function indexObjetivo (){
        if(session()->has('LoginId')){
            $objs = Objetivo::orderBy('nombre_objetivosec', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('modObjetivo',$data,compact('objs'));
    }
    public function changestatusobj (Request $request){
        $obj = Objetivo::findOrFail($request->id);
        $obj->status =  $request->status;
        $obj->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function addobjs (Request $request){
        $request -> validate([
            'name'=>'required',
        ]);
        $obje = new Objetivo();
        $obje->id;
        $obje->nombre_objetivosec = $request->get('name');
        $obje->status;
        $res = $obje->save();
        if($res){
            return redirect('modo');
        }else{
            return back()->with('fail','No se agrego el objetivo correctamente');
        }
    }
    public function upobj ( $id ){
        $obj = Objetivo::where('id',$id)->first();
        return view('upobj',compact('obj'));
    }
    public function upobjs (Request $request, $id ){
        $request -> validate([
            'name'=>'required',
        ]);
        $objs = Objetivo::find($id);
        $objs->nombre_objetivosec = $request->get('name');
        $res = $objs->save();
        if($res){
            return redirect('modo');
        }else{
            return back()->with('fail','No se Actualizo el objetivo correctamente');
        }
    }
/*Objetivo sectorial fin*/

/*Modo de transporte Inicio*/
    public function  indextransporte (){
        if(session()->has('LoginId')){
            $trans = Transporte::orderBy('nombre_transporte', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('modTransporte',$data,compact('trans'));
    }
    public function changestatustran (Request $request){
        $tran = Transporte::findOrFail($request->id);
        $tran->status =  $request->status;
        $tran->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function addtranspo (Request $request){
        $request -> validate([
            'name'=>'required',
        ]);
        $tran = new Transporte();
        $tran->id;
        $tran->nombre_transporte = $request->get('name');
        $tran->status;
        $res = $tran->save();
        if($res){
            return redirect('modt');
        }else{
            return back()->with('fail','No se agrego el modo de transporte Correctamente');
        }

    }
    public function uptran ( $id ){
        $tran = Transporte::where('id',$id)->first();
        return view('uptran',compact('tran'));
    }

    public function uptrans (Request $request, $id ){
        $request -> validate([
            'name'=>'required',
        ]);
        $trans = Transporte::find($id);
        $trans->nombre_transporte = $request->get('name');
        $res = $trans->save();
        if($res){
            return redirect('modt');
        }else{
            return back()->with('fail','No se actualizo el modo de transporte correctamente');
        }
    }
/*Modo de transporte Fin*/

/*Alineacion inicio*/
    public function  indexalineacion (){
        if(session()->has('LoginId')){
            $alins = Alineacion::orderBy('nombre', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('modAlineacion',$data,compact('alins'));
    }

    public function changestatuslin (Request $request){
        $alin = Alineacion::findOrFail($request->id);
        $alin->status =  $request->status;
        $alin->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function addalinea (Request $request){
        $request -> validate([
            'name'=>'required',
        ]);
        $alin = new Alineacion();
        $alin->id;
        $alin->nombre = $request->get('name');
        $alin->status;
        $res = $alin->save();
        if($res){
            return redirect('modlin');
        }else{
            return back()->with('fail','No se agrego la alineacion correctamente');
        }

    }
    public function upalin ( $id ){
        $ali = Alineacion::where('id',$id)->first();
        return view('upalin',compact('ali'));
    }

    public function upalins (Request $request, $id ){
        $request -> validate([
            'name'=>'required',
        ]);
        $alins = Alineacion::find($id);
        $alins->nombre = $request->get('name');
        $res = $alins->save();
        if($res){
            return redirect('modlin');
        }else{
            return back()->with('fail','No se actualizo la alineacion correctamente');
        }
    }
/*Alienacion fin*/

/*Cliente o Usuario inicio */
    public function  indexcliente (){
        if(session()->has('LoginId')){
            $clien = Cliente::orderBy('nivel1', 'DESC')->orderBy('nivel2', 'ASC')->orderBy('nivel3', 'ASC')->get();
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        }
        return view('modcliente',$data,compact('clien'));
    }
    public function changestatucl (Request $request){
        $clien = Cliente::findOrFail($request->id);
        $clien->status =  $request->status;
        $clien->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function newcli(){
        return view('addcli');
    }
    public function addcli( Request $request){
        $request -> validate([
            'nivel1'=>'required',
            'nivel2'=>'required',
            'nivel3'=>'required'
        ]);
        $clien = new Cliente();
        $clien->id;
        $clien->nivel1 = $request->nivel1;
        $clien->nivel2 = $request->nivel2;
        $clien->nivel3 = $request->nivel3;
        $res = $clien->save();
        if($res){
            return back()->with('success','Registro de nuevo Cliente completado con exito' );
        }else{
            return back()->with('fail','No se pudo resgistrar al nuevo Cliente');
        }
    }
    public function upcli( $id ){
        $cli = Cliente::where('id',$id)->first();
        return view('upclie',compact('cli'));
    }

    public function upclis (Request $request, $id ){
        $request -> validate([
            'nivel1'=>'required',
            'nivel2'=>'required',
            'nivel3'=>'required',
        ]);
        $clien = Cliente::find($id);
        $clien->id;
        $clien->nivel1 = $request->nivel1;
        $clien->nivel2 = $request->nivel2;
        $clien->nivel3 = $request->nivel3;
        $res = $clien->save();
        if($res){
            return redirect('indexcliente');
        }else{
            return back()->with('fail','No se pudo resgistrar al nuevo Cliente');
        }
    }
/*Cliente o Usuario Fin */

/*Financiero Inicio */
    public function Financiero(){
        if(session()->has('LoginId')){
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
            $proy = Proyecto::orderBy('ncontratos', 'ASC')
            ->orderBy('proyectos.claven', 'ASC')
            ->orderBy('proyectos.clavey', 'ASC')
            ->whereNotNull('ncontratos')->where('status',1)->get();
        }
        return view('Financiero', $data,compact('proy'));
    }
    public function indexpartida (){
        if(session()->has('LoginId')){
            $access = User::where('id','=',session('LoginId'))->where('acceso','=',1)->first();
            $accessadminf = User::where('id','=',session('LoginId'))->where('acceso','=',4)->first();
            if($access){
                    $ext = 'plantillas/plantilla';
                    $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
                    $allPartidas = Financiero::all();
                    return view('partidas', $data,compact('allPartidas','ext'));
            }elseif($accessadminf){
                    $ext = 'plantillas/plantillaadminf';
                    $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
                    $allPartidas = Financiero::all();
                    return view('partidas', $data,compact('allPartidas','ext'));
            }else{
                return redirect('/');
            }
        }
    }
    public function changestatupart (Request $request){
        $part = Financiero::findOrFail($request->id);
        $part->status =  $request->status;
        $part->save();
        return response()->json(['success'=>'Status changed Succesfully']);
    }
    public function addpartidas (Request $request){
        $partida = new Financiero();
        $partida->id;
        $partida->partida = $request->get('partida');
        $partida->concepto = $request->get('concepto');
        $partida->status;
        $partida->save();
        return redirect('partidas');
    }
    public function uppartida ( $id ){
        $partida = Financiero::where('id',$id)->first();
        return view('uppartida',compact('partida'));
    }
    public function uppartidas (Request $request, $id ){
        $partidas = Financiero::find($id);
        $partidas->partida = $request->get('partida');
        $partidas->concepto = $request->get('concepto');
        $partidas->save();
        return redirect('partidas');
    }
    public function newAf(){
        $partidas = Financiero::where('status',1)->get();
        return view('newAfectacion', compact('partidas'));
    }

    public function afectaciones($id){
            //IDPROYECTO - IDPROYECTO
        $proy_a = Proyecto::where('id',$id)->first();
            //IDPROYECTO LLAVE FORANEA - IDPROYECTO
        $totalproyt = RecursosGeneral::join('recursos','recursos.id','=','recursos_general.idrecurso')
                ->join('proyectos','proyectos.id','=','recursos_general.idproyecto')
                ->Where('idproyecto',$id)
                ->sum('recursos_general.cantidad');
        $afectacion = Afectacion::Where('id_proyecto',$id)->get();

        $total = Afectacion::Where('id_proyecto',$id)->sum('montoxpartida');
        $partidas = Afectacion::Where('id_partida',$id)->get();
        $allPartidas = Financiero::where('status',1)->get();
        $partida= Afectacion::join('tb_partidas','tb_partidas.id','=','tb_afectaciones.id_partida')
            ->join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            ->Where('id_proyecto',$id)->orderBy('clc', 'asc')
            ->get(['tb_afectaciones.id','tb_partidas.partida','tb_partidas.concepto', 'proyectos.costo',
            'tb_afectaciones.fecha','tb_afectaciones.clc','tb_afectaciones.montoxpartida','tb_afectaciones.tipo']);

        $contador = Afectacion::where('id_proyecto', $id)->get()->count();

        return view('afectaciones',compact('proy_a','afectacion','total','partidas','allPartidas','partida','totalproyt','contador'));
    }

    public function afectaciones_($id){
        $proy_a = Proyecto::where('id',$id)->first();
        $allPartidas = Financiero::where('status',1)->get();
        return view('addAfectacion',compact('proy_a','allPartidas'));
    }

    public function add_Afectacion (){
        $allPartidas = Financiero::where('status',1)->get();
        return view('addAfectacion', compact('allPartidas'));
    }

    public function addAfectacion(Request $request, $id ){
        $request -> validate([
            'fecha'=>'date',
            'clc'=>'required',
            'conceptoc'=>'required',
            'id_partida'=>'numeric',
            'montoxpartida'=>'numeric',
            'idproy'=>'numeric'
        ]);
        $afectacion = new Afectacion();
        $afectacion->id;
        $afectacion->fecha = $request->get('fecha');
        $afectacion->clc = $request->get('clc');
        $afectacion->conceptoc = $request->get('conceptoc');
        $afectacion->id_partida = $request->get('partidas');
        $afectacion->montoxpartida = $request->get('montoxpartida');
        $afectacion->tipo = $request->get('tipo');
        $afectacion->id_proyecto = $request->idproy;
        $res = $afectacion->save();
        if($res){
            return redirect('afectaciones/'.$id);
        }else {
            return back()->with('fail','No se pudo resgistrar correctamente');
        }
    }
    //Información
    public function infoafectacion ( $id ,$ida){
        $allPartidas = Financiero::all();
        $proy_a= Proyecto::where('id',$id)->first();
        $afectaciones= Afectacion::where('id',$ida)->first();

        $partida = Financiero :: where('id',$afectaciones->id_partida)->first();

        return view('infoafectacion',compact('allPartidas','partida','proy_a','afectaciones'));
    }
    public function upafectaciones($id,$ida){
        $allPartidas = Financiero::all();
        $proy_a= Proyecto::where('id',$id)->first();
        $afectaciones= Afectacion::where('id',$ida)->first();
        $partida = Financiero :: where('id',$afectaciones->id_partida)->first();
        return view('upafectacion',compact('proy_a','afectaciones','allPartidas','partida'));
    }

    public function upafectacion(Request $request, $id, $ida){
        $request -> validate([
            'fecha'=>'date',
            'clc'=>'required',
            'conceptoc'=>'required',
            'id_partida'=>'numeric',
            'montoxpartida'=>'numeric',
            'tipo'=>'required',
            'idproy'=>'numeric'
        ]);

        $afectaciones= Afectacion::find($ida);
        $afectaciones->fecha = $request->get('fecha');
        $afectaciones->clc = $request->get('clc');
        $afectaciones->conceptoc = $request->get('conceptoc');
        $afectaciones->id_partida = $request->get('partida');
        $afectaciones->montoxpartida = $request->get('montoxpartida');
        $afectaciones->tipo = $request ->get('tipo');
        $afectaciones->id_proyecto = $request->idproy;
        $afectaciones ->save();
        return redirect('afectaciones/'.$id);
    }
    public function destroyAfectacion(Request $request, $id, $ida){
        $afectaciones= Afectacion::find($ida);
        $afectaciones -> delete();
        return redirect('afectaciones/'.$id);
    }

    public function exportExcel($ncontratos, $totalproyt){

        return (new Afectacion_Export($ncontratos, $totalproyt))->download('afectaciones.xlsx');
    }

    public function exportExcelPr(){

        return (new ProyectosExport())->download('Proyectos.xlsx');
    }
/*Financiero Fin */

/*Exceles Alternativo Inicio*/
    public function vistareportes(){
        $search = User::where('id','=',session('LoginId'))->first();
        $areass = Area::where('id',$search->idarea)->first();
        $areas = Area::where('status',1)->get();
        return view('vistareportes',compact('search','areass','areas'));
    }

    public function vistareportesglobal(){
        $search = User::where('id','=',session('LoginId'))->first();
        $areass = Area::where('id',$search->idarea)->first();
        $areas = Area::where('status',1)->get();
        return view('vistareportesglobal',compact('search','areass','areas'));
    }

    public function excelporresponsable(Request $request){
        $request -> validate([
            'areas'=>'numeric',
        ]);
        $areas = $request->get('areas');
        $proy = Proyecto::join('usuarios','usuarios.id','=','proyectos.idusuarior')
        ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
        ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
        ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
        ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
        ->join('cliente','cliente.id','=','proyectos.Cliente')
        ->orderBy('fecha_inicio', 'ASC')
        ->where('proyectos.idarea',$areas)
        ->where('proyectos.oculto','=','1')
        ->get(['proyectos.id',
            'proyectos.oculto',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
            'proyectos.nomproy',
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.progreso',
            'proyectos.duracionm',
            'proyectos.costo',
            'proyectos.orientacion',
            'proyectos.nivel',
            'proyectos.materia',
            'modo_transporte.nombre_transporte',
            'area_adscripcion.nombre_area',
            'linea_investigación.nombre_linea',
            'objetivo_sectorial.nombre_objetivosec',
            'cliente.nivel1',
            'cliente.nivel2',
            'cliente.nivel3'
        ]);

        $orientacion = Orientacion::all();
        $nivel = Nivel::all();
        $materia = Materia::all();
        // $materia = MateriaPr::join('proyectos','proyectos.id','=','materias_proy.idproy')
        //         ->join('materia','materia.id','=','materias_proy.idmateria')
        //         ->get(['materia.descmateria','materias_proy.idproy']);

        $contri = ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
                ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
                ->get(['contribucion_a.nombre_contri','contribuciones.idproyecto']);

        return view('excelproyectosresponsable',compact('proy', 'contri', 'orientacion', 'nivel', 'materia'));
    }

    public function f6gs001(Request $request){
        $request -> validate([
            'areas'=>'numeric',
        ]);
        $areas = $request->get('areas');
        $proy = Proyecto::join('usuarios','usuarios.id','=','proyectos.idusuarior')
        ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
        ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
        ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
        ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
        ->join('cliente','cliente.id','=','proyectos.Cliente')
        ->orderBy('fecha_inicio', 'ASC')
        ->where('proyectos.idarea',$areas)
        ->where('proyectos.oculto','=','1')
        ->get(['proyectos.id',
            'proyectos.oculto',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
            'proyectos.nomproy',
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.progreso',
            'proyectos.duracionm',
            'proyectos.costo',
            'proyectos.estado',
            'modo_transporte.nombre_transporte',
            'area_adscripcion.nombre_area',
            'linea_investigación.nombre_linea',
            'objetivo_sectorial.nombre_objetivosec',
            'cliente.nivel1',
            'cliente.nivel2',
            'cliente.nivel3'
        ]);

        $proy2 = Proyecto::join('usuarios','usuarios.id','=','proyectos.idusuarior')
            ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
            ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
            ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
            ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
            ->join('cliente','cliente.id','=','proyectos.Cliente')
            ->orderBy('fecha_inicio', 'ASC')
            ->where('usuarios.idarea',$areas)
            ->Where('proyectos.oculto','=','1')
            ->Where('proyectos.clavea','=','M')
            ->get(['proyectos.id',
                'proyectos.oculto',
                'usuarios.Nombre',
                'usuarios.Apellido_Paterno',
                'usuarios.Apellido_Materno',
                'proyectos.nomproy',
                'proyectos.clavea',
                'proyectos.clavet',
                'proyectos.claven',
                'proyectos.clavey',
                'proyectos.fecha_inicio',
                'proyectos.fecha_fin',
                'proyectos.progreso',
                'proyectos.duracionm',
                'proyectos.costo',
                'proyectos.estado',
                'modo_transporte.nombre_transporte',
                'area_adscripcion.nombre_area',
                'linea_investigación.nombre_linea',
                'objetivo_sectorial.nombre_objetivosec',
                'cliente.nivel1',
                'cliente.nivel2',
                'cliente.nivel3'
            ]);
        

        

        return view('F6GS001',compact('proy','areas', 'proy2'));
    }

    public function excelporfecha(Request $request){
        $request -> validate([
            'inicio'=>'date',
            'fin'=>'date'
        ]);
        $fechainicio = $request->get('inicio');
        $fechafin = $request->get('fin');
        $proy = Proyecto::join('usuarios','usuarios.id','=','proyectos.idusuarior')
        ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
        ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
        ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
        ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
        ->join('cliente','cliente.id','=','proyectos.Cliente')
        ->orderBy('fecha_inicio', 'ASC')
        ->whereBetween('fecha_fin', [$fechainicio, $fechafin])
        ->get(['proyectos.id',
            'proyectos.oculto',
            'usuarios.Nombre',
            'usuarios.Apellido_Paterno',
            'usuarios.Apellido_Materno',
            'proyectos.nomproy',
            'proyectos.clavea',
            'proyectos.clavet',
            'proyectos.claven',
            'proyectos.clavey',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.progreso',
            'proyectos.duracionm',
            'proyectos.costo',
            'proyectos.estado',
            'modo_transporte.nombre_transporte',
            'area_adscripcion.nombre_area',
            'linea_investigación.nombre_linea',
            'objetivo_sectorial.nombre_objetivosec',
            'cliente.nivel1',
            'cliente.nivel2',
            'cliente.nivel3'
        ]);

        $contri = ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
                ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
                ->get(['contribucion_a.nombre_contri','contribuciones.idproyecto']);

        return view('excelproyectosfechas',compact('proy','contri'));
    }
    public function exceltodos (){
        if(session()->has('LoginId')){
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
            $proy = Proyecto::join('usuarios','usuarios.id','=','proyectos.idusuarior')
                ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
                ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
                ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
                ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
                ->join('cliente','cliente.id','=','proyectos.Cliente')
                ->where('proyectos.oculto','=','1')
                ->orderBy('fecha_inicio', 'ASC')
                ->get(['proyectos.id',
                    'proyectos.oculto',
                    'usuarios.Nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                    'proyectos.nomproy',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.progreso',
                    'proyectos.duracionm',
                    'proyectos.costo',
                    'proyectos.estado',
                    'proyectos.orientacion',
                    'proyectos.nivel',
                    'proyectos.materia',
                    'proyectos.Observaciones',
                    'modo_transporte.nombre_transporte',
                    'area_adscripcion.nombre_area',
                    'linea_investigación.nombre_linea',
                    'objetivo_sectorial.nombre_objetivosec',
                    'cliente.nivel1',
                    'cliente.nivel2',
                    'cliente.nivel3'
                ]);
            $orientacion = Orientacion::all();
            $nivel = Nivel::all();
            $materia = Materia::all();
            // $materia = MateriaPr::join('proyectos','proyectos.id','=','materias_proy.idproy')
            //     ->join('materia','materia.id','=','materias_proy.idmateria')
            //     ->get(['materia.descmateria','materias_proy.idproy']);
            $contri = ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
                ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
                ->get(['contribucion_a.nombre_contri','contribuciones.idproyecto']);
        }
        return view('excelproyectos', $data,compact('proy','contri', 'orientacion', 'nivel', 'materia'));
    }

    public function exceltodosglobal (){
        if(session()->has('LoginId')){
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
            $proy = Proyecto::join('usuarios','usuarios.id','=','proyectos.idusuarior')
                ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
                ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
                ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
                ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
                ->join('cliente','cliente.id','=','proyectos.Cliente')
                ->orderBy('fecha_inicio', 'ASC')
                ->get(['proyectos.id',
                    'proyectos.oculto',
                    'usuarios.Nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                    'proyectos.nomproy',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.progreso',
                    'proyectos.duracionm',
                    'proyectos.costo',
                    'proyectos.estado',
                    'proyectos.Observaciones',
                    'modo_transporte.nombre_transporte',
                    'area_adscripcion.nombre_area',
                    'linea_investigación.nombre_linea',
                    'objetivo_sectorial.nombre_objetivosec',
                    'cliente.nivel1',
                    'cliente.nivel2',
                    'cliente.nivel3'
                ]);

            $contri = ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
                ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
                ->get(['contribucion_a.nombre_contri','contribuciones.idproyecto']);
        }
        return view('excelproyectos', $data,compact('proy', 'contri'));
    }

    public function exceltodosuser (){
        if(session()->has('LoginId')){
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
                $proyt = User::join('proyectos','proyectos.idusuarior','=','usuarios.id')
                ->join('equipo','equipo.idusuario','=','usuarios.id')
                ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
                ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
                ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
                ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
                ->join('cliente','cliente.id','=','proyectos.Cliente')
                ->Where('proyectos.idusuarior','=',session('LoginId'))
                ->orwhere('equipo.idusuario','=',session('LoginId'))
                ->get(['proyectos.id',
                    'proyectos.oculto',
                    'usuarios.Nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                    'proyectos.nomproy',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.progreso',
                    'proyectos.duracionm',
                    'proyectos.costo',
                    'modo_transporte.nombre_transporte',
                    'area_adscripcion.nombre_area',
                    'linea_investigación.nombre_linea',
                    'objetivo_sectorial.nombre_objetivosec',
                    'cliente.nivel1',
                    'cliente.nivel2',
                    'cliente.nivel3'
                ]);
                $proy = Equipo::join('proyectos','proyectos.id','=','equipo.idproyecto')
                ->join('usuarios','usuarios.id','=','proyectos.idusuarior')
                ->join('area_adscripcion','area_adscripcion.id','=','proyectos.idarea')
                ->join('modo_transporte','modo_transporte.id','=','proyectos.idmodot')
                ->join('objetivo_sectorial','objetivo_sectorial.id','=','proyectos.idobjt')
                ->join('linea_investigación','linea_investigación.id','=','proyectos.idlinea')
                ->join('cliente','cliente.id','=','proyectos.Cliente')
                ->where('equipo.idusuario','=',session('LoginId'))
                ->where('proyectos.oculto','=','1')
                ->get(['proyectos.id',
                    'proyectos.oculto',
                    'usuarios.Nombre',
                    'usuarios.Apellido_Paterno',
                    'usuarios.Apellido_Materno',
                    'proyectos.nomproy',
                    'proyectos.clavea',
                    'proyectos.clavet',
                    'proyectos.claven',
                    'proyectos.clavey',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.progreso',
                    'proyectos.duracionm',
                    'proyectos.costo',
                    'modo_transporte.nombre_transporte',
                    'area_adscripcion.nombre_area',
                    'linea_investigación.nombre_linea',
                    'objetivo_sectorial.nombre_objetivosec',
                    'cliente.nivel1',
                    'cliente.nivel2',
                    'cliente.nivel3'
                ]);
        }
        return view('exceltodosuser', $data,compact('proy','proyt'));
    }

    public function excelinfoproyecto($id){
        $proyt = Proyecto::where('id',$id)->first();
        $areas = Area::where('id',$proyt->idarea)->first();
        $user = User::where('id',$proyt->idusuarior)->first();
        $linea = Investigacion::where('id',$proyt->idlinea)->first();
        $alin = Alineacion::where('id',$proyt->idalin)->first();
        $cli = Cliente::where('id',$proyt->Cliente)->first();
        $obj = Objetivo::where('id',$proyt->idobjt)->first();
        $resp = User::Join('proyectos','.aprobo','=','usuarios.id')
        ->join('area_adscripcion','area_adscripcion.id','=','usuarios.idarea')
        ->where('proyectos.id',$id)
        ->where('usuarios.idarea',$areas->id)
        ->get(['usuarios.Nombre','usuarios.Apellido_Paterno','usuarios.Apellido_Materno'])->first();
        $team = Equipo::join('proyectos','proyectos.id','=','equipo.idproyecto')
            ->join('usuarios','usuarios.id','=','equipo.idusuario')
            ->where('idproyecto',$id)
            ->get(['usuarios.nombre','usuarios.Apellido_Paterno','usuarios.Apellido_Materno']);
        $contri = ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
                ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
                ->where('idproyecto',$id)
                ->get(['contribucion_a.nombre_contri']);
        $tran = Transporte::where('id',$proyt->idmodot)->first();
        return view ('excelinfoproyectos',
        compact('proyt','areas','user','linea','alin','cli','obj','contri','tran','team','resp'));
    }
    
    public function excelinfoactividades($id){
        $proyt = Proyecto::where('id',$id)->first();
        $areas = Area::where('id',$proyt->idarea)->first();
        $tarea = Tarea::Where('idproyecto',$id)->orderBy('fecha_inicio', 'ASC')->get();
        $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
        $progres = Tarea::where('idproyecto',$id)->get();
        $total = 0;
        $actualfinal = 0;
        $avance = Tarea::where('idproyecto',$id)->get()->count();
        foreach($progres as $progre){
            $final = 100*$avance;
            $total = $progre->progreso + $total;
            $actual = (100*$total)/$final;
            $actualfinal = round($actual);
        }
        $proy = Proyecto::find($id);
        $proy->progreso = $actualfinal;
        $proy->save();
    return view('excelinfoactividades',$data,compact('proyt','tarea','areas'));
    }
/*Exceles Alternativo Fin*/

/*Excel Módulo Financiero Inicio*/
    public function exportExcel1 ($id){
        if(session()->has('LoginId')){
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
            $afectaciones = Afectacion::join('tb_partidas','tb_partidas.id','=','tb_afectaciones.id_partida')
            -> join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            -> orderBy('tb_afectaciones.clc','asc')
            -> where('tb_afectaciones.id_proyecto', $id)
            -> get (['proyectos.ncontratos','proyectos.nomproy', 'proyectos.clavea','proyectos.clavet',
            'proyectos.claven','proyectos.clavey', 'proyectos.costo',
            'tb_afectaciones.clc','tb_afectaciones.conceptoc','tb_afectaciones.fecha',
            'tb_partidas.partida','tb_partidas.concepto','tb_afectaciones.tipo','tb_afectaciones.montoxpartida']
            );
            $total = Afectacion:: join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            -> where('tb_afectaciones.id_proyecto', $id)
            -> sum('montoxpartida');
        }
        return view('excel_afectaciones', $data,compact('afectaciones','total'));
    }

    public function porcontrato(){
        $contratos = Proyecto::distinct()->where('status',1)->whereNotNull('ncontratos')->get(['ncontratos']);
        return view('porcontrato', compact('contratos'));
    }

    public function exportExcel2 (Request $request ){
        $ncontratos = $request->get('ncontratos');
        if(session()->has('LoginId')){
            $data = ['LoggedUserInfo'=>User::where('id','=',session('LoginId'))->first()];
            $afectaciones = Afectacion::join('tb_partidas','tb_partidas.id','=','tb_afectaciones.id_partida')
            -> join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            -> orderBy('proyectos.nomproy','asc')
            -> where('ncontratos', $ncontratos)
            -> get (['proyectos.ncontratos','proyectos.nomproy', 'proyectos.clavea','proyectos.clavet',
            'proyectos.claven','proyectos.clavey', 'proyectos.costo',
            'tb_afectaciones.clc','tb_afectaciones.conceptoc','tb_afectaciones.fecha',
            'tb_partidas.partida','tb_partidas.concepto','tb_afectaciones.tipo','tb_afectaciones.montoxpartida']);
            $total = Afectacion:: join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            -> where('ncontratos', $ncontratos)
            ->sum('montoxpartida');
            return view('excelContrato', $data,compact('afectaciones','total','ncontratos'));
        }
    }
/*Excel Módulo Financiero  Fin*/

/**/

/**/
}
