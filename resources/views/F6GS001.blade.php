<?php
require_once '../vendor/autoload.php';
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
use App\Models\fechabimestre;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Exports\Afectacion_Export;
use App\Exports\ProyectosExport;
use App\Models\comitesAdmin;
use App\Models\ServiciostecnologicosAdmin;


date_default_timezone_set('America/Mexico_City');
setLocale(LC_TIME, 'es_MX.UTF-8');
setLocale(LC_TIME, 'spanish');

//Inicio para general el documento
$documento = new Spreadsheet();
$documento->createSheet();
$portada = $documento->getActiveSheet(0);
//Fin para general el documento

//Inicio para generar las hojas del excel
$documento->setActiveSheetIndex(0);
$documento->getActiveSheet()->setTitle('F6 GS-001');
//Fin para generar las hojas del excel

    /* Logo del instituto Inicio*/
    /* Logo del instituto Fin */
    /* Estilos de las celdas Fin*/
        /* Formato de la Hoja Inicio */
            $documento->getActiveSheet()->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                /* define la orientacion vetical de la hoja */
            $documento->getActiveSheet()->getPageSetup()
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                /* Define el tamaño de papel */
            // $documento->getActiveSheet()->getPageSetup()->setFitToWidth(0);	/* Escala la hoja para el contenido */
            $documento->getActiveSheet()->getPageSetup()->setFitToWidth(1);
            $documento->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        /* Formato de la Hoja Fin */

        /*Encabezado y Pie de pagina inicio*/
    
        //Genera el nombre del are en base al select
            $areass = Area::where('id', $areas)->first();
        //

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        $drawing->setName('PhpSpreadsheet logo');
        $drawing->setPath('img/Logo variante.png');
        $drawing->setHeight(80);
        $documento->getActiveSheet()->getHeaderFooter()
        ->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);

        $documento->getActiveSheet()->getHeaderFooter()
        ->setOddHeader('&L&G&O'.'&C&18&"Arial,Negrita"&O'.$areass->nombre_area.'
        &X&O&14&"Arial"& Sistema de Gestión de la Calidad');

        $documento->getActiveSheet()->getHeaderFooter()
            ->setOddFooter('&L&"Arial,Negrita"&O REV 01,FECHA 20230921'.
            '&C&"Arial,Negrita"&O Hoja &P de &N'.
            '&R&"Arial,Negrita"&O F6 GS-001');

        $documento->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,4);

        /*Encabezado y Pie de pagina fin*/

        /* Estilo del titulo Inicio */
            /* Tamaño de las celdas Inicio*/
                $documento->getActiveSheet()->getColumnDimension('A')->setWidth(3);
                $documento->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                $documento->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $documento->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                $documento->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $documento->getActiveSheet()->getColumnDimension('F')->setWidth(14);
                $documento->getActiveSheet()->getColumnDimension('G')->setWidth(14);
                $documento->getActiveSheet()->getColumnDimension('H')->setWidth(14);
                $documento->getActiveSheet()->getColumnDimension('I')->setWidth(12);
                $documento->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $documento->getActiveSheet()->getColumnDimension('K')->setWidth(27);
                $documento->getActiveSheet()->getColumnDimension('L')->setWidth(18);

                $documento->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
                $documento->getActiveSheet()->getRowDimension('4')->setRowHeight(35);

             /* Tamaño de las celdas Fin*/
            $documento->getActiveSheet()->getStyle('B2')->getFont()->setSize(14)->setName('Arial')->setBold(true);
            $documento->getActiveSheet()->getStyle('B2')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);

            $arraynuml2 = array('B','C','D','E','F','G','H','I','J','K','L');
            foreach ($arraynuml2 as $letra) {
                $documento->getActiveSheet()->getStyle($letra.'4')->getFont()
                ->setSize(11)->setName('Arial')->setBold(true);
                $documento->getActiveSheet()->getStyle($letra.'4')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle($letra.'4')
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            }
        /* Estilo del titulo fin */
    /* Estilo para la primera hoja Fin*/
    /*Inicio de datos de portada*/
        /* Datos y construccion ddl encabezado de inicio */
        /* Datos y construccion ddl encabezado de inicio */
        /* Inicio Titulo del primer tabla*/
            $fecha1= date('Y');
            $fechames = date('m');
            switch ($fechames) {
                case 1:
                    $mes = 'ENERO';
                    break;
                case 2:
                    $mes = 'FEBRERO';
                    break;
                case 3:
                    $mes = 'MARZO';
                    break;
                case 4:
                    $mes = 'ABRIL';
                    break;
                case 5:
                    $mes = 'MAYO';
                    break;
                case 6:
                    $mes = 'JUNIO';
                    break;
                case 7:
                    $mes = 'JULIO';
                    break;
                case 8:
                    $mes = 'AGOSTO';
                    break;
                case 9:
                    $mes = 'SEPTIEMBRE';
                    break;
                case 10:
                    $mes = 'OCTUBRE';
                    break;
                case 11:
                    $mes = 'NOVIEMBRE';
                    break;
                default:
                    $mes = 'DICIEMBRE';
                }


            $portada->mergeCells("B2:L2");
            $portada->setCellValue('B2', 'SEGUIMIENTO DE PROYECTOS DE INVESTIGACIÓN'.' '.$mes.' / '.$fecha1);
            
        /* Inicio Titulo del primer tabla */
        /* Inicio de encabezado de la tabla de asignandos */
            $portada->setCellValue('B4', 'Clave');
            $portada->setCellValue('C4', 'Interno / Externo');
            $portada->setCellValue('D4', 'Nombre del Proyecto');
            $portada->setCellValue('E4', 'Cliente');
            $portada->setCellValue('F4', 'Duración');
            $portada->setCellValue('G4', 'Fecha inicio');
            $portada->setCellValue('H4', 'Fecha Fin');
            $portada->setCellValue('I4', 'Costo');
            $portada->setCellValue('J4', 'Avance (%)');
            $portada->setCellValue('K4', 'Responsable');
            $portada->setCellValue('L4', 'Estatus');
        /* Fin de encabezado de la tabla de asignandos */
        $valor = 5;
        /* Inicio de contenido de la tabla de detalles */
        foreach ($proy as $pr) {

            if ($pr->claven < 10){
                $portada->setCellValue('B'.$valor, $pr->clavea.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey);
            }
          	else{
                $portada->setCellValue('B'.$valor, $pr->clavea.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey);
            }  
            $portada->setCellValue('C'.$valor, $pr->clavet);
            $portada->setCellValue('D'.$valor, $pr->nomproy);
            $portada->setCellValue('E'.$valor, $pr->nivel3);
            $portada->setCellValue('F'.$valor, $pr->duracionm.' Meses');
            $portada->setCellValue('G'.$valor, $pr->fecha_inicio);
            $portada->setCellValue('H'.$valor, $pr->fecha_fin);
            $portada->setCellValue('I'.$valor, $pr->costo);

            if ($pr->clavet == 'I'){
                if ($pr->publicacion == 1){
                    $portada->setCellValue('J'.$valor, $pr->progreso);
                }elseif ($pr->publicacion == 2){
                    $portada->setCellValue('J'.$valor, $pr->progreso);
                }else{
                    if ($pr->progreso == 100){
                        $portada->setCellValue('J'.$valor, '98');
                    }else{
                        $pgreal = $pr->progreso;
                        $comp = 98;
                        $mult = ($comp*$pgreal);
                        $div = ($mult/100);
                        $psinp = round($div,0);
                        $portada->setCellValue('J'.$valor, $psinp);
                    }
                }
            }else{
                $portada->setCellValue('J'.$valor, $pr->progreso);
            }

            $portada->setCellValue('K'.$valor, $pr->Nombre.' '.$pr->Apellido_Paterno.' '.$pr->Apellido_Materno);
            switch ($pr->estado) {
                case 00:
                    $portada->setCellValue('L'.$valor, 'No iniciado');
                    break;
                case 1:
                    $portada->setCellValue('L'.$valor, 'En ejecución');
                    break;
                case 2:
                    $portada->setCellValue('L'.$valor, 'Concluido');
                    break;
                case 3:
                    $portada->setCellValue('L'.$valor, 'En pausa');
                    break;
                case 4:
                    $portada->setCellValue('L'.$valor, 'Reprogramado');
                    break;
                default:
                    $portada->setCellValue('L'.$valor, 'Cancelado');
                }
                  

            $arraynuml2 = array('B','C','D','E','F','G','H','I','J','K','L');
            foreach ($arraynuml2 as $letra) {
                $documento->getActiveSheet()->getStyle($letra.$valor)->getFont()
                ->setSize(10)->setName('Arial')->setBold(false);
                $documento->getActiveSheet()->getStyle($letra.$valor)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle($letra.$valor)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('I'.$valor)->getNumberFormat(0000,0000);
                $documento->getActiveSheet()->getStyle('D'.$valor)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('E'.$valor)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            }

            $valor++;
        }
        /* Fin de contenido de la tabla de detalles*/
        $valor2 = $valor;
        /* Inicio de contenido de la tabla de detalles */
        foreach ($proy2 as $pr2) {

            if ($pr2->claven < 10){
                $portada->setCellValue('B'.$valor2, $pr2->clavea.$pr2->clavet.'-0'.$pr2->claven.'/'.$pr2->clavey);
            }
            else{
                $portada->setCellValue('B'.$valor2, $pr2->clavea.$pr2->clavet.'-'.$pr2->claven.'/'.$pr2->clavey);
            }
            $portada->setCellValue('C'.$valor2, $pr2->clavet);
            $portada->setCellValue('D'.$valor2, $pr2->nomproy);
            $portada->setCellValue('E'.$valor2, $pr2->nivel3);
            $portada->setCellValue('F'.$valor2, $pr2->duracionm.' Meses');
            $portada->setCellValue('G'.$valor2, $pr2->fecha_inicio);
            $portada->setCellValue('H'.$valor2, $pr2->fecha_fin);
            $portada->setCellValue('I'.$valor2, $pr2->costo);
            $portada->setCellValue('J'.$valor2, $pr2->progreso);
            $portada->setCellValue('K'.$valor2, $pr2->Nombre.' '.$pr2->Apellido_Paterno.' '.$pr2->Apellido_Materno);
            switch ($pr2->estado) {
                case 00:
                    $portada->setCellValue('L'.$valor2, 'No iniciado');
                    break;
                case 1:
                    $portada->setCellValue('L'.$valor2, 'En ejecución');
                    break;
                case 2:
                    $portada->setCellValue('L'.$valor2, 'Concluido');
                    break;
                case 3:
                    $portada->setCellValue('L'.$valor2, 'En pausa');
                    break;
                case 4:
                    $portada->setCellValue('L'.$valor2, 'Reprogramado');
                    break;
                default:
                    $portada->setCellValue('L'.$valor2, 'Cancelado');
                }
                

            $arraynuml2 = array('B','C','D','E','F','G','H','I','J','K','L');
            foreach ($arraynuml2 as $letra) {
                $documento->getActiveSheet()->getStyle($letra.$valor2)->getFont()
                ->setSize(10)->setName('Arial')->setBold(false);
                $documento->getActiveSheet()->getStyle($letra.$valor2)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle($letra.$valor2)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $documento->getActiveSheet()->getStyle('I'.$valor2)->getNumberFormat(0000,0000);
                $documento->getActiveSheet()->getStyle('D'.$valor2)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
                $documento->getActiveSheet()->getStyle('E'.$valor2)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            }

            $valor2++;
        }
    /* Fin de contenido de la tabla de detalles*/
    /*Fin de datos de portada*/


// Incio del Nombre del documento
$nombreDelDocumento = "Reporte F6 GS-001";
$fecha=date('Y_m_d');
//  Fin del Nombre del documento
/* Encabezado y lineas para la impresion Inicio */
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nombreDelDocumento.'-'.$fecha.'.xlsx"');
    header('Cache-Control: max-age=0');
 
    $writer = IOFactory::createWriter($documento, 'Xlsx');
    $writer->save('php://output');
    exit;
/* Encabezadoi y lineas para la impresion Fin*/



