<?php
require "../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
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

function convchr($letraf)
{
    switch ($letraf) {
     case ($letraf>=65 and $letraf<=90):
          $letra=chr($letraf);
     break;
     case ($letraf>=91 and $letraf<=116):
          $letra='A'. chr($letraf-26);
     break;
     case ($letraf>=117 and $letraf<=142):
           $letra='B' . chr($letraf-52);
     break;
     case ($letraf>=143 and $letraf<=168):
           $letra='C' . chr($letraf-78);
     break;
     case ($letraf>=169 and $letraf<=194):
           $letra='D' . chr($letraf-104);
     break;
      case ($letraf>=195 and $letraf<=220):
           $letra='E' . chr($letraf-130);
     break;
 }
 return $letra;
}



/* Consultas para el rellenar el documento Inicio*/
    $proyt->id;/* Carga la id del proyectos del cual se genera el reporte*/
    $proyt = Proyecto::where('id',$proyt->id)->first();
    $areas = Area::where('id',$proyt->idarea)->first();
    $user = User::where('id',$proyt->idusuarior)->first();
    $linea = Investigacion::where('id',$proyt->idlinea)->first();
    $alin = Alineacion::where('id',$proyt->idalin)->first();
    $cli = Cliente::where('id',$proyt->Cliente)->first();
    $obj = Objetivo::where('id',$proyt->idobjt)->first();
    $tran = Transporte::where('id',$proyt->idmodot)->first();
    $team = Equipo::join('proyectos','proyectos.id','=','equipo.idproyecto')
                ->join('usuarios','usuarios.id','=','equipo.idusuario')
                ->where('idproyecto',$proyt->id)
                ->get(['usuarios.nombre','usuarios.Apellido_Paterno','usuarios.Apellido_Materno']);
    $contri = ContribucionesProyecto::join('proyectos','proyectos.id','=','contribuciones.idproyecto')
                ->join('contribucion_a','contribucion_a.id','=','contribuciones.idcontri')
                ->where('idproyecto',$proyt->id)
                ->get(['contribucion_a.nombre_contri']);
    $resp = User::Join('proyectos','.aprobo','=','usuarios.id')
                ->join('area_adscripcion','area_adscripcion.id','=','usuarios.idarea')
                ->where('proyectos.id',$proyt->id)
                ->get(['usuarios.Nombre','usuarios.Apellido_Paterno','usuarios.Apellido_Materno'])->first();
    $tarea = Tarea::Where('idproyecto',$proyt->id)->orderBy('fecha_inicio', 'ASC')->get();
    $mesesa = Tarea::Where('idproyecto',$proyt->id)->sum('duracion');
/* Consultas para el rellenar el documento Fin*/

/* Variables para el nombre del documento Inicio*/
    if ($proyt->claven<10) 
	{$nombre = $proyt->clavea.$proyt->clavet.'-0'.$proyt->claven.'/'.$proyt->clavey;}
    else
	{$nombre = $proyt->clavea.$proyt->clavet.'-'.$proyt->claven.'/'.$proyt->clavey;}
    $nombreDelDocumento = "F1RI-002";
    $fecha=date('Y_m_d');
    $fechapie=date('Ymd');
/* Variables para el nombre del documento Fin*/
/* Inicio del Excel */
    $documento = new Spreadsheet();
    $documento->createSheet();
    $portada = $documento->getActiveSheet(0);
    /* Estilo para la primera hoja Inicio*/
        /* Estilos de las celdas Inicio*/
            /* Color de Fondo Inicio */
                $documento->getActiveSheet()->getStyle('A1:E23')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFFFF');
            /* Color de Fondo Fin */
            /* Tipo de letra Global Incio */
                $documento->getActiveSheet()->getStyle('B1')->getFont()->setSize(14)->setName('Arial');
                $arrayletral5 = array('A','B','C','D','E');
                $arraynuml5 = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
                foreach ($arrayletral5 as $letra) {  
                    foreach ($arraynuml5 as $num) {          
                        $documento->getActiveSheet()->getStyle($letra.$num)->getFont()->setSize(10)->setName('Arial');
                    }
                }
                $arraynum = array(5,7,8,9,10,11,12,13,14,15,16);
                foreach ($arraynum as $num) {            
                    $documento->getActiveSheet()->getStyle('A'.$num)->getFont()->setBold(true);
                    $documento->getActiveSheet()->getStyle('D'.$num)->getFont()->setBold(true);
                }
                $documento->getActiveSheet()->getStyle('B2')->getFont()->setSize(12)->setBold(true)->setName('Arial');
                $documento->getActiveSheet()->getStyle('B17')->getFont()->setBold(true);
                $documento->getActiveSheet()->getStyle('E17')->getFont()->setBold(true);
            /* Tipo de letra Global Fin  */
            /* Tamaño de Celdas Inicio  */
                $documento->getActiveSheet()->getColumnDimension('A')->setWidth(31);
                $documento->getActiveSheet()->getColumnDimension('B')->setWidth(51);
                $documento->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $documento->getActiveSheet()->getColumnDimension('D')->setWidth(26);
                $documento->getActiveSheet()->getColumnDimension('E')->setWidth(51);
            /* Tamaño de Celdas Fin  */
            /* Encabezado estilo Inicio  */
                $documento->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                $documento->getActiveSheet()->getStyle('B1')
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('B2')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('C2')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_GENERAL)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $arraynuml2 = array('C','D','E');
                foreach ($arraynuml2 as $letra) {            
                    $documento->getActiveSheet()->getStyle($letra.'2')
                        ->getBorders()
                        ->getOutline()
                        ->setBorderStyle(Border::BORDER_THIN);
                }
                $documento->getActiveSheet()->getStyle('A5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $arraynuml2 = array('B','C','D','E');
                foreach ($arraynuml2 as $letra) {            
                    $documento->getActiveSheet()->getStyle($letra.'5')
                        ->getBorders()
                        ->getOutline()
                        ->setBorderStyle(Border::BORDER_THIN);
                }
                $documento->getActiveSheet()->getStyle('B4')
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
            /* Encabezado estilo Fin  */
            /* Alineacion del texto Inicio  */
                $arraynum = array(7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
                foreach ($arraynum as $num) {            
                    $documento->getActiveSheet()->getStyle('B'.$num)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_GENERAL)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                    $documento->getActiveSheet()->getStyle('D'.$num)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                    $documento->getActiveSheet()->getStyle('E'.$num)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_GENERAL)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                    $documento->getActiveSheet()->getStyle('A'.$num)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                    $documento->getActiveSheet()->getStyle('D'.$num)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                }
            /* Alineacion del texto Fin  */
            /* Borde de las columnas Inicio */
                $arraynumb = array(7,8,9,10,11,12,13,15);
                foreach ($arraynumb as $num) {            
                    $documento->getActiveSheet()->getStyle('B'.$num)
                        ->getBorders()
                        ->getOutline()
                        ->setBorderStyle(Border::BORDER_THIN); 
                }
                $arraynume = array(7,8,9,10,11,12);
                foreach ($arraynume as $num) {            
                    $documento->getActiveSheet()->getStyle('E'.$num)
                        ->getBorders()
                        ->getOutline()
                        ->setBorderStyle(Border::BORDER_THIN); 
                }
            /* Borde de las columnas Fin */
            /* Estilo de las firmas Inicio */
                $documento->getActiveSheet()->getStyle('B17')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('B20')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('B20')
                    ->getBorders()
                    ->getTop()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('E17')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('E20')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('E20')
                    ->getBorders()
                    ->getTop()
                    ->setBorderStyle(Border::BORDER_THIN); 
                $documento->getActiveSheet()->getStyle('E21')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            /* Estilo de las firmas Fin */
            /* Estilo del pie de pagina Inicio */
                $documento->getActiveSheet()->getStyle('A23')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('A23')
                        ->getBorders()
                        ->getOutline()
                        ->setBorderStyle(Border::BORDER_THIN); 
                $documento->getActiveSheet()->getStyle('C23')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('C23')
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN); 
                $documento->getActiveSheet()->getStyle('E23')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('E23')
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            /* Estilo del pie de pagina Fin */   
            /* Logo del instituto Inicio*/
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Paid');
            $drawing->setDescription('Paid');
            $drawing->setPath('img/Logo_IMT.png'); // Si cambias las imagen asegurse de que este en la misma carpeta
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(0);
            $drawing->setRotation(0);
            $drawing->setWidth(100);
            $drawing->setHeight(80);
            $drawing->setWorksheet($documento->getActiveSheet());
            /* Logo del instituto Fin */
        /* Estilos de las celdas Fin*/
        /* Formato de la Hoja Inicio */
            $documento->getActiveSheet()->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);/* define la orientacion vetical de la hoja */
            $documento->getActiveSheet()->getPageSetup()
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);/* Define el tamaño de papel */
            $documento->getActiveSheet()->getPageSetup()->setFitToPage(100);/* Escala la hoja para el contenido */
        /* Formato de la Hoja Fin */
    /* Estilo para la primera hoja Fin*/
    /* Creacion de las hojas */
        $documento->setActiveSheetIndex(0);
        $documento->getActiveSheet()->setTitle('Portada');
        $documento->setActiveSheetIndex(1);
        $documento->getActiveSheet()->setTitle('Cronograma');
    /* Creacion de las hojas */
    /* Estilo para la segunda hoja Inicio*/
        /* Formato de la Hoja Inicio */
            $documento->getActiveSheet()->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);/* define la orientacion vetical de la hoja */
            $documento->getActiveSheet()->getPageSetup()
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);/* Define el tamaño de papel */
            $documento->getActiveSheet()->getPageSetup()->setFitToPage(50);/* Escala la hoja para el contenido */
        /* Formato de la Hoja Fin */
        /* Tamaño de las celdas Inicio*/
            $documento->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $documento->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $documento->getActiveSheet()->getColumnDimension('C')->setWidth(8);
            $documento->getActiveSheet()->getColumnDimension('D')->setWidth(8);
            $documento->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        /* Tamaño de las celdas Fin*/
        /* Estilo del titulo Inicio*/
            $documento->getActiveSheet()->getStyle('B1')
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
            $documento->getActiveSheet()->getStyle('B2')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('C2')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_GENERAL)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $arraynuml2 = array('C','D','E','F','G','H');
            foreach ($arraynuml2 as $letra) {            
                $documento->getActiveSheet()->getStyle($letra.'2')
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            }
        /* Estilo del titulo Fin*/
        /* Formato del titulo de la tabla Inicio*/
            $arrayletral5 = array('A','B','C','D');
            $arraynuml5 = array(7,8);
            foreach ($arrayletral5 as $letra) {  
                foreach ($arraynuml5 as $num) {          
                $documento->getActiveSheet()->getStyle($letra.$num)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                    $documento->getActiveSheet()->getStyle($letra.$num)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                }
            }
            $documento->getActiveSheet()->getStyle('A6')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('B5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
            $documento->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
        /* Formato del titulo de la tabla fin*/
        /* Logo del instituto Inicio*/
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Paid');
                $drawing->setDescription('Paid');
                $drawing->setPath('img/Logo_IMT.png'); // Si cambias las imagen asegurse de que este en la misma carpeta
                $drawing->setCoordinates('A1');
                $drawing->setOffsetX(0);
                $drawing->setRotation(0);
                $drawing->setWidth(100);
                $drawing->setHeight(80);
                $drawing->setWorksheet($documento->getActiveSheet());
        /* Logo del instituto Fin */
    /* Estilo para la segunda hoja Fin*/
    /* Datos y construccion de la portada inicio */
        /* Fila 1 */
        $portada->setCellValue("A1", "");
        $portada->mergeCells("B1:E1");
        $portada->setCellValue('B1','Sistema de Gestión de la Calidad'); 
        /* Fila 2 */
        $portada->setCellValue("B2", "Coordinación de");
        $portada->mergeCells("C2:E2");
        $portada->setCellValue('C2',$areas->nombre_area);
        /* Fila 3 */
        $portada->setCellValue("A3", "");
        /* Fila 4 */
        $portada->setCellValue("A4", "");
        $portada->mergeCells("B4:E4");
        $portada->setCellValue('B4','DATOS GENERALES'); 
         /* Fila 5 */
        $portada->setCellValue("A5","Proyecto:");
        $portada->mergeCells("B5:E5");
		if ($proyt->claven<10) 
			{$portada->setCellValue("B5",$proyt->clavea.$proyt->clavet.'-0'.$proyt->claven.'/'.$proyt->clavey.' '.$proyt->nomproy);}
          	else
			{$portada->setCellValue("B5",$proyt->clavea.$proyt->clavet.'-'.$proyt->claven.'/'.$proyt->clavey.' '.$proyt->nomproy);}
               /* Fila 6 */
        $portada->setCellValue("A6", "");
        /* Fila 7 */
        $portada->setCellValue("A7","Objetivo del proyecto");
        $portada->setCellValue("B7",$proyt->objetivo);
        $portada->setCellValue("D7","Fecha de inicio");
        $portada->setCellValue("E7",$proyt->fecha_inicio);
        /* Fila 8 */
        $portada->setCellValue("A8","Responsable del proyecto");
        $portada->setCellValue("B8",$user->Apellido_Paterno.' '.$user->Apellido_Materno.' '.$user->Nombre);
        $portada->setCellValue("D8","Fecha de terminación");
        $portada->setCellValue("E8",$proyt->fecha_fin);
        /* Fila 9 */
        $portada->setCellValue("A9","Investigadores participantes");
            $equipo = "";
            $inter = "";
            foreach ($team as $t) {
                $nom = $t->nombre;
                $pat = $t->Apellido_Paterno;
                $mat = $t->Apellido_Materno;
                $equipo = $pat.' '.$mat.' '.$nom.' ';
                $inte = $equipo.'/';
                $inter .= $inte;
            }
            $inter;
        $portada->setCellValue("B9",$inter); 
        $portada->setCellValue("D9","Duración (meses)");
        $portada->setCellValue("E9",$proyt->duracionm.' Meses');
        /* Fila 10 */
        $portada->setCellValue("A10","Línea de investigación");
        $portada->setCellValue("B10",$linea->nombre_linea);
        $portada->setCellValue("D10","Costo estimado");
        $portada->setCellValue("E10",'$'.$proyt->costo);
        /* Fila 11 */
        $portada->setCellValue("A11","Alineación al programa sectorial");
        $portada->setCellValue("B11",$alin->nombre);
        $portada->setCellValue("D11","Cliente o usuario potencial");
        $portada->setCellValue("E11",$cli->nivel1.'|'.$cli->nivel2.'|'.$cli->nivel3);
        /* Fila 12 */
        $portada->setCellValue("A12","Objetivo sectorial");
        $portada->setCellValue("B12",$obj->nombre_objetivosec);
        $portada->setCellValue("D12","Producto por obtener");
        $portada->setCellValue("E12",$proyt->producto);
        /* Fila 13 */
        $portada->setCellValue("A13","Contribución a");
            $con = "";
            $contribu = "";
            foreach ($contri as $c) {
                $dato = $c->nombre_contri;
                $con = $dato.'/';
                $contribu .= $con;
            }
            $contribu;
        $portada->setCellValue("B13",$contribu);
        /* Fila 14 */
        $portada->setCellValue("A14","");
        /* Fila 15 */
        $portada->setCellValue("A15","Fecha de elaboración");
        $portada->setCellValue("B15",$fecha);
        /* Fila 16 */
        $portada->setCellValue("A16","");
        /* Fila 17 */
        $portada->setCellValue("B17","Elaboró:");
        $portada->setCellValue("E17","Aprobó:");
        /* Fila 18 */
        $portada->setCellValue("B18","");
        $portada->setCellValue("E18","");
        /* Fila 19 */
        $portada->setCellValue("B19","");
        $portada->setCellValue("E19","");
        /* Fila 20 */
        $portada->setCellValue("B20",$user->Apellido_Paterno.' '.$user->Apellido_Materno.' '.$user->Nombre);
        $portada->setCellValue("E20",$resp->Apellido_Paterno.' '.$resp->Apellido_Materno.' '.$resp->Nombre);
        /* Fila 21 */
        $portada->setCellValue("E21",$areas->nombre_area);
        /* Fila 22 */
        $portada->setCellValue("D22","");
        /* Fila 23 */
        $portada->setCellValue("A23","REV 06, FECHA:20170809");
        $portada->setCellValue("C23","HOJA 1 DE 2");
        $portada->setCellValue("E23","F1 RI-002");    
    /* Datos y construccion de la portada fin */
    /* Datos y construccion del Cronograma Inicio */
        $cronograma = $documento->getActiveSheet(1);
        /* Fila 1 */
        $cronograma->setCellValue("A1","");
        $cronograma->mergeCells("B1:H1");
        $cronograma->setCellValue('B1','Sistema de Gestión de la Calidad'); 
        /* Fila 2 */
        $cronograma->setCellValue("B2", "Coordinación de");
        $cronograma->mergeCells("C2:H2");
        $cronograma->setCellValue('C2',$areas->nombre_area);
        /* Fila 3 */
        $cronograma->setCellValue("A3","");
        /* Fila 4 */
        $cronograma->setCellValue("A4","");
        /* Fila 5 */
        $cronograma->setCellValue("A5","");
        $cronograma->mergeCells("B5:E5");
        $cronograma->setCellValue('B5','PROGRAMA DE ACTIVIDADES'); 
         /* Fila 6 */
        $cronograma->setCellValue("A6","Proyecto:");
        $cronograma->mergeCells("B6:E6");
		if ($proyt->claven<10) 
			{$cronograma->setCellValue("B6",$proyt->clavea.$proyt->clavet.'-0'.$proyt->claven.'/'.$proyt->clavey.' '.$proyt->nomproy);}
          	else
			{$cronograma->setCellValue("B6",$proyt->clavea.$proyt->clavet.'-'.$proyt->claven.'/'.$proyt->clavey.' '.$proyt->nomproy);}
        /* Fila 7 */
        $cronograma->mergeCells("A7:B7");
        $cronograma->setCellValue("A7", "ACTIVIDAD");
        $cronograma->mergeCells("C7:D8");
        $cronograma->setCellValue("C7", "% DE PARTICIPACIÓN");
        $letraf=$proyt->duracionm +68;
        $letra=convchr($letraf);
        $cronograma->mergeCells('E7:'.$letra.'7');
        $cronograma->setCellValue("E7", "DURACIÓN (MESES)");
           /* Colorea los bordes de los meses de la tabla Inicio*/
                $documento->getActiveSheet()->getStyle('E8:'.$letra.'8')
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN); 
                $documento->getActiveSheet()->getStyle('E8:'.$letra.'8')
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('E9:'.$letra.'9')
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);                        
            /* Colorea los bordes de los meses de la tabla Fin*/

        /* Da el estilo al titulo de meses y pinta los meses Inicio*/
        $comb;
        $documento->getActiveSheet()->getStyle('E7:'.$letra.'7')
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN); 
        $documento->getActiveSheet()->getStyle('E7:'.$letra.'7')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
       $lc=69;      
       $im=1;   
     for ($h=1; $h<=$proyt->duracionm; $h++)
        {  $matp[$h]=0.0;
           $matr[$h]=0.0;
           $mmes[$h]="";
        }
       $finiciop=strtotime($proyt->fecha_inicio);
       $ffinp=strtotime($proyt->fecha_fin);
	$dini=date("d",$finiciop);
 	if ($dini >28)
	{$finiciop=strtotime("-5 day",$finiciop); }
       while ($im <= $proyt->duracionm) {
              $col=convchr($lc);
              $cronograma->setCellValue($col."8", date("M-y", $finiciop));
              $mmes[$im]=date("M-y", $finiciop); /*crea una matriz con mes y año para después comparar y conocer la columna donde inicia cada tarea */
              $finiciop = strtotime("+1 month", $finiciop);
              $lc++;
              $im++;
             }
           
        /*  Da el estilo al titulo de meses y pinta los meses  Fin*/

         /* Fila 8 */
        $cronograma->setCellValue("A8", "NO.");
        $cronograma->setCellValue("B8", "DESCRIPCIÓN");
        /* Fila Actividades */
        $num = 1;
        $cont = 9;
        $comb = 10;
        $fr = 0;
	$minip=strtotime($proyt->fecha_inicio);

foreach ($tarea as $ta) {
            $act = $ta->actividad;
            $cronograma->mergeCells('A'.$cont.':A'.$comb);
            $cronograma->mergeCells('B'.$cont.':B'.$comb);
            $cronograma->setCellValue('A'.$cont,$num);
            $cronograma->setCellValue('B'.$cont,$act);
            $cronograma->setCellValue('C'.$cont,'P');
            $cronograma->setCellValue('C'.$comb,'R');
                $real = round(100/$mesesa,2);
                $c = $ta->duracion;
                $p = $ta->progreso;
                $op = round($real * $c,2);
                $f = round(($op*$p)/100,2);
                $fr = $fr+$op;

            /* Formato de las celdas Inicio */
                $documento->getActiveSheet()->getStyle('A'.$cont.':A'.$comb)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('A'.$cont.':A'.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('B'.$cont.':B'.$comb)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('B'.$cont.':B'.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('C'.$cont.':C'.$comb)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('C'.$cont.':C'.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('D'.$cont.':D'.$comb)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('D'.$cont.':D'.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            /* Formato de las celdas Fin */
            
        /*Colocar el código para pintar contenido de la tarea y porcentajes inicia*/
            /*coloca el número consecutivo de tarea*/
               $cronograma->setCellValue('A'.$cont, $num);

            /*coloca el nombre de la tarea */
               $cronograma->setCellValue('B'.$cont, $act);

            /*coloca letras de programado o realizado */
		$a=$cont+1;
               $cronograma->setCellValue('C'.$cont, 'P');
               $cronograma->setCellValue('C'.$a, 'R');

            /*coloca porcentaje de programado o realizado de participación de la tarea en el proyecto*/
               $cronograma->setCellValue('D'.$cont, round($op).'%');
               $cronograma->setCellValue('D'.$a, round($f).'%');

            /* coloca el porcentaje programado en el mes correspondiente e ilumina la celda*/
	       $minita=strtotime($ta->fecha_inicio);
	       $mt=date("M-y",$minita);
			/*Encuentra la fecha de inicio de la tarea dentro de la matriz de meses*/
               for($j=1; $j<=$proyt->duracionm;$j++)
               { $fmat=$mmes[$j];
                 if($mt==$fmat){ $colinicro=69+($j-1); 
                                $difm=($j-1);} 
                }

               $fin=$colinicro + $ta->duracion;
	       $zh=1+$difm;
            for ($i=$colinicro; $i < $fin;$i++)
                {   $asccolini= convchr($i);
                    $cronograma->getStyle($asccolini.$cont)->getNumberformat()
					->setFormatCode(\phpoffice\PhpSpreadSheet\Style\NumberFormat::FORMAT_PERCENTAGE);
		    $cronograma->getStyle($asccolini.$cont)->getFont()->getcolor()->setARGB('FF000088');
                    $cronograma->setCellValue($asccolini.$cont,round($real,2).'%');
                    $cronograma->getStyle($asccolini.$cont)->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()->setARGB('FF000088');
                  
                    $matp[$zh]=$matp[$zh]+$real;
		 $zh++;                 }

            /*coloca el porcentaje realizado en el mes correspondiente e ilumina la celda*/
               if ($p>0)
               { $mesprog=ceil($f/$real);
                 if ($mesprog >$ta->duracion)
                    { $mesprog= $ta->duracion; }
                 $finr=$colinicro+$mesprog;     
   		         $zk=1+$difm;
		         $mp=1;
                 $idcol=$colinicro;
                $progrm=$real*$mp;
                 /*while ($mp<=$mesprog)
                    {  $asccolini= convchr($idcol);
                       $cronograma->getStyle($asccolini.$comb)->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()->setARGB('FF32CD32');
		               $cronograma->getStyle($asccolini.$cont)->getFont()->getcolor()->setARGB('FF32CD32');
			        
	            	   $cronograma->setCellValue($asccolini.$comb, round($real,2).'%');
				             $matr[$zk]=$matr[$zk]+$real;			           
			           $zk++;
			           $mp++;
                       $idcol++;
                       $progrm=round($real*$mp,2);
                    }
                     
                    If($p<100){ $pa=abs(($real*($mp-1))-$f);
                           $cronograma->setCellValue($asccolini.$comb, round($pa,2).'%');    
                           $matr[$zk]=$matr[$zk]+$pa;
                               }*/
                    for($mp=1;$mp<=$mesprog;$mp++)
                    { $asccolini= convchr($idcol);
                      $cronograma->getStyle($asccolini.$comb)->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()->setARGB('FF32CD32');
                       $cronograma->getStyle($asccolini.$cont)->getFont()->getcolor()->setARGB('FF32CD32');
                    
                      if ($mp<$mesprog)
                         {$cronograma->setCellValue($asccolini.$comb, round($real,2).'%');
                          $matr[$zk]=$matr[$zk]+$real;                      }
                      else
                         { $pa=($f-($real*($mp-1)));
                           $cronograma->setCellValue($asccolini.$comb, round($pa,2).'%');    
                           $matr[$zk]=$matr[$zk]+$pa;
                         }
                        $zk++;
                        $idcol++;
                    }  
                   


               }
        /*Colocar el código para pintar contenido de la tarea y porcentajes aquí termina*/
            
 
            $comb = $comb+2;
            $cont = $cont+2;
            $num++;
} /*fin de foreachtarea*/
        $letra;
        $fr;
        $comb;
        $cont;
        $cronograma->mergeCells('A'.$cont.':B'.$comb);
        $cronograma->setCellValue('A'.$cont,'Total');
        $cronograma->setCellValue('C'.$cont,'P');
        $cronograma->setCellValue('C'.$comb,'R');
        $cronograma->setCellValue('D'.$cont,round($fr).'%');
        $cronograma->setCellValue('D'.$comb,round($proyt->progreso).'%');
        /* Suma de porcentajes Inicio*/
           $inicio=9;
           $colini=69;
	   $totalp=0;
	   $totalr=0;
           $colfin=$proyt->duracionm;
           $fin=$comb-2;
           for($k=1; $k<=$colfin; $k++)
                {   $totalp=$totalp+$matp[$k];
                    $totalr=$totalr+$matr[$k];
                $cronograma->setCellValue(convchr($colini).$cont,round($totalp).'%');
                $cronograma->setCellValue(convchr($colini).$comb,round($totalr).'%');
		$colini=$colini+1;
             }
        /* Suma de porcentajes Fin */
            /* Convierte la celda a porcentaje Inicio */
                $documento->getActiveSheet()->getStyle('D'.$cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);
                $documento->getActiveSheet()->getStyle('D'.$cont)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);
               $documento->getActiveSheet()->getStyle('E1:'.$letra.$comb)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);
            /* Convierte la celda a porcentaje Fin */
            /* Formato de las celdas Inicio */
                $documento->getActiveSheet()->getStyle('A'.$cont.':A'.$comb)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('A'.$cont.':A'.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('B'.$cont.':B'.$comb)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('B'.$cont.':B'.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('C'.$cont.':C'.$comb)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('C'.$cont.':C'.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('D'.$cont.':D'.$comb)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('D'.$cont.':D'.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('E'.$cont.':'.$letra.$comb)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
               $documento->getActiveSheet()->getStyle('E'.$cont.':'.$letra.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('E9:'.$letra.$comb)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                 $documento->getActiveSheet()->getStyle('E9:'.$letra.$comb)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);

               for ($i=9;$i<$cont;$i+=2){
                         $documento->getActiveSheet()->getStyle('E'.$i.':'.$letra.$i)->getFont()->getcolor()->setARGB('FF000088');
                      }
               for ($i=10;$i<$comb;$i+=2){
                         $documento->getActiveSheet()->getStyle('E'.$i.':'.$letra.$i)->getFont()->getcolor()->setARGB('FF32CD32');
                      }
            /* Formato de las celdas Fin */

        $extra = $comb+3;
        $extra2 = $cont+3;
        $cronograma->mergeCells('A'.$extra2.':B'.$extra);
        $cronograma->setCellValue('A'.$extra2,'OBSERVACIONES');
        $cronograma->mergeCells('C'.$extra2.':'.$letra.$extra);
        $cronograma->setCellValue('C'.$extra2,'');
        /* Formato observaciones  Inicio */
            $documento->getActiveSheet()->getStyle('A'.$extra2.':B'.$extra)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $documento->getActiveSheet()->getStyle('A'.$extra2.':B'.$extra)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('C'.$extra2.':'.$letra.$extra)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $documento->getActiveSheet()->getStyle('C'.$extra2.':'.$letra.$extra)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        /* Formato Observaciones Inicio */
        $pie = $comb+5;
        $cronograma->setCellValue('A'.$pie,"REV 06, FECHA:20170809");
        $cronograma->setCellValue('C'.$pie,"HOJA 2 DE 2");
        $cronograma->setCellValue($letra.$pie,"F1 RI-002"); 
            /* Bordes pie de pagina Inicio */
                $documento->getActiveSheet()->getStyle('A'.$pie)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('A'.$pie)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('C'.$pie)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('C'.$pie)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle($letra.$pie)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle($letra.$pie)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            /* Bordes pie de pagina Fin */
            /* Estilo de letra documento Inicio*/        
                $documento->getActiveSheet()->getStyle('A1:E'.$pie)->getFont()->setSize(10)->setName('Arial');
                $documento->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                $documento->getActiveSheet()->getStyle('B1')->getFont()->setSize(14)->setName('Arial');
            /* Estilo de letra documento Fin*/
    /* Datos y construccion del Cronograma Fin */
/* Fin del Excel*/
/* Encabezado y lineas para la impresion Inicio */
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nombreDelDocumento.'-'.$nombre.'-'.$fecha.'.xlsx"');
    header('Cache-Control: max-age=0');
 
    $writer = IOFactory::createWriter($documento, 'Xlsx');
    $writer->save('php://output');
    exit;
/* Encabezadoi y lineas para la impresion Fin*/
?>