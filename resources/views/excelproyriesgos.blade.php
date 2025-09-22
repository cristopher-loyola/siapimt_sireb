<?php
require '../vendor/autoload.php';
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
use App\Models\Analisis;
use App\Models\Riesgos;
use App\Models\Puesto;
use App\Models\Recursos;
use App\Models\RecursosGeneral;
use App\Models\Tarea;
use App\Models\fechabimestre;
use App\Models\Orientacion;
use App\Models\Nivel;
use App\Models\Materia;
use App\Models\MateriaPr;
use App\Models\Observacion;

date_default_timezone_set('America/Mexico_City');
setLocale(LC_TIME, 'es_MX.UTF-8');
setLocale(LC_TIME, 'spanish');

function convchr($letraf)
{
    switch ($letraf) {
        case ($letraf >= 65 && $letraf <= 90):
            $letra = chr($letraf);
            break;
        case ($letraf >= 91 && $letraf <= 116):
            $letra = 'A' . chr($letraf - 26);
            break;
        case ($letraf >= 117 && $letraf <= 142):
            $letra = 'B' . chr($letraf - 52);
            break;
        case ($letraf >= 143 && $letraf <= 168):
            $letra = 'C' . chr($letraf - 78);
            break;
        case ($letraf >= 169 && $letraf <= 194):
            $letra = 'D' . chr($letraf - 104);
            break;
        case ($letraf >= 195 && $letraf <= 220):
            $letra = 'E' . chr($letraf - 130);
            break;
        default:
            $letra = '';
            break;
    }
    return $letra;
}

// PARA EL NOMBRE DEL DOCUMENTO
$nombreDelDocumento = "Riesgos";
$fecha = date('Y_m_d');
$fechapie = date('Ymd');

// AQUI SE INICIA EL ARCHIVO EXCEL QUE CONTENDRA EL REPORTE DE RIESGOS
$documento = new Spreadsheet();
$reporteriesgos = $documento->getActiveSheet();
$documento->getActiveSheet()->setTitle('Reporte de Riesgos');

$documento->getActiveSheet()->getPageSetup()
    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$documento->getActiveSheet()->getPageSetup()
    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
$documento->getActiveSheet()->getPageSetup()
    ->setFitToPage(50);

// TIPO DE LETRA GLOBAL 
$reporteriesgos->getStyle('A1')->getFont()->setSize(14)->setName('Arial');
$arrayletraS = array('A', 'B', 'C', 'D', 'E');
$arraynumS = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25);
foreach ($arrayletraS as $letra) {
    foreach ($arraynumS as $num) {
        $reporteriesgos->getStyle($letra . $num)->getFont()->setSize(10)->setName('Arial');
    }
}

$documento->getActiveSheet()->getColumnDimension('A')->setWidth(16);
$documento->getActiveSheet()->getColumnDimension('B')->setWidth(40);

// ESTILOS PARA LAS CELDAS
$documento->getActiveSheet()->getStyle('B1')
    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
$documento->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$documento->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$documento->getActiveSheet()->getStyle('B2')
    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
$documento->getActiveSheet()->getStyle('C2')
    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_GENERAL)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
$arraynuml2 = array('C', 'D', 'E', 'F', 'G', 'H');
foreach ($arraynuml2 as $letra) {
    $documento->getActiveSheet()->getStyle($letra . '2')
        ->getBorders()
        ->getOutline()
        ->setBorderStyle(Border::BORDER_THIN);
}


$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Paid');
$drawing->setDescription('Paid');
$drawing->setPath('img/Logo_IMT.png');
$drawing->setCoordinates('A1');
$drawing->setOffsetX(0);
$drawing->setRotation(0);
$drawing->setWidth(100);
$drawing->setHeight(80);
$drawing->setWorksheet($documento->getActiveSheet());

// PARA COLOCAR EL AREA Y EL NOMBRE DE REPORTES DE RIESGOS
$reporteriesgos->setCellValue("A1", "");
$reporteriesgos->mergeCells("B1:H1");
$reporteriesgos->setCellValue('B1', 'REPORTE DE RIESGOS DE ALTA PRIORIDAD');

$reporteriesgos->setCellValue("B2", "Área de Adscripción");
$reporteriesgos->mergeCells("C2:H2");
$reporteriesgos->setCellValue('C2', strip_tags(html_entity_decode($area->nombre_area)));

// INICIO DE TITULOS PARA EL REPORTE
$reporteriesgos->mergeCells("A4:B4");
$reporteriesgos->setCellValue("A4", "Riesgos");
$reporteriesgos->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
$reporteriesgos->getStyle('A4')->getFont()->setBold(true);

$reporteriesgos->setCellValue("A5", "No.");
$reporteriesgos->setCellValue("B5", "Descripción");

$rows = $documento->getActiveSheet();
foreach ($rows->getRowIterator() as $row) {
    if ($row->getRowIndex() <= 2) {
        $rows->getRowDimension($row->getRowIndex())->setRowHeight(35);
    }
}

$rows = $documento->getActiveSheet();
foreach ($rows->getRowIterator() as $row) {
    if ($row->getRowIndex() <= 5 && $row->getRowIndex() >= 3) {
        $rows->getRowDimension($row->getRowIndex())->setRowHeight(20);
    }
}
$reporteriesgos->getStyle('K2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFBF00'); 
$reporteriesgos->setCellValue('K2', 'X');
$reporteriesgos->mergeCells("L2:M2");
$reporteriesgos->setCellValue("L2", "Indicador de riesgos");
$reporteriesgos->getStyle('L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
$reporteriesgos->getStyle('K2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);

$arrayletras = array('A', 'B');
$arraynums = array(5, 6);
foreach ($arrayletras as $letra) {
    foreach ($arraynums as $num) {
        $documento->getActiveSheet()->getStyle($letra . $num)
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $documento->getActiveSheet()->getStyle($letra . $num)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
    }
}

$cantProys = count($proysFiltrados);

if ($cantProys > 0) {
    $letraf = $cantProys + 66;  
    $letra = convchr($letraf);  

    if($cantProys <= 1){
        $reporteriesgos->getColumnDimension('C')->setWidth(20);
    }

    $reporteriesgos->mergeCells('C4:' . $letra . '4');
    $reporteriesgos->setCellValue('C4', "Claves de Proyecto");

    $reporteriesgos->getStyle('C4:' . $letra . '4')->getFont()->setBold(true);
    $reporteriesgos->getStyle('C4:' . $letra . '4')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
        ->setWrapText(true);

    $documento->getActiveSheet()->getStyle('A4:' . $letra . '4')
        ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    $documento->getActiveSheet()->getStyle('C5:' . $letra . '5')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
        ->setWrapText(true);
    $documento->getActiveSheet()->getStyle('C5:' . $letra . '5')
        ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
} else {
    $reporteriesgos->setCellValue('C4', "");
}   

$reporteriesgos->getStyle('C4:' . $letra . '4')->getFont()->setBold(true);

$reporteriesgos->getStyle('C4:' . $letra . '4')->getAlignment()
    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
    ->setWrapText(true);

$documento->getActiveSheet()->getStyle('A4:' . $letra . '4')
    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

$documento->getActiveSheet()->getStyle('C5:' . $letra . '5')
    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
    ->setWrapText(true);
$documento->getActiveSheet()->getStyle('C5:' . $letra . '5')
    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);



$lc = 67; // ES MI COLUMNA C
//$im = 1;


foreach($proysFiltrados as $proy){
    $col = convchr($lc); 
    if($proy->claven < 10){
        $claveProyecto = $proy->clavea. $proy->clavet.'-0'. $proy->claven.'/'.$proy->clavey;
    }else{
        $claveProyecto = $proy->clavea . $proy->clavet . '-' . $proy->claven . '/' . $proy->clavey;
    }
    $reporteriesgos->setCellValue($col . "5", strip_tags(html_entity_decode($claveProyecto)));
    $lc++;
}

$documento->getActiveSheet()->getStyle('A5:' . $letra . '5') 
    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$documento->getActiveSheet()->getStyle('A5:' . $letra . '5')
    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
    ->setWrapText(true);
$documento->getActiveSheet()->getStyle('A5:' . $letra . '5')
    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);


$num = 1; 
$cont = 6;

// UN ARRAY QUE GUARDE LOS IDS DDE LOS PROYECTOS QUE ESTAN DE ENCABEZADO
$proyectosOrdenados = $proysFiltrados->pluck('id')->toArray(); 
// LO MISMO PERO AHORA CON LOS RIESFOS
$riesgosOrdenados = $riesgos->pluck('id')->toArray(); 

if ($cantProys == 0 || empty($riesgosOrdenados)) {

    $reporteriesgos->setCellValue('A6', 'No se encontraron riesgos de prioridad alta.');
    $reporteriesgos->mergeCells('A6:' . $letra . '6'); 

    $style = $reporteriesgos->getStyle('A6:' . $letra . '6');
    $style->getFont()->setBold(true)->setSize(10)->getColor()->setRGB('FF0000'); 
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
    $nombreArchivo = "Reporte_Riesgos_" . date('Y-m-d_H-i-s') . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($documento, 'Xlsx');
    $writer->save('php://output');
    exit; 
}


$rows = $documento->getActiveSheet();
$ultimaFila = $cont - 1;
for($i = 6; $i <= $ultimaFila; $i++){
    $rows->getRowDimension($i)->setRowHeight(55);
}
// LO MISMO PERO AHORA CON LOS RIESFOS
$riesgosOrdenados = $riesgos->pluck('id')->toArray(); 
//dd($riesgosOrdenados);
$proyectosRiesgosAltoP = []; 

// PARA PODER IR GUARDANDO AQUELLOS RIESGOS QUE SEAN DE UN MISMO PROYECTO, SI NO TIENEN UN RIESGO SE HACE EL ARREGLO DE ESE PROYECTO
        /*
        // CHECAR PQ NO ESTA FUNCIONANDO ESTO
        foreach ($analisisRiesgos as $analisis) {
            if ($proyectosRiesgosAltoP[$analisis->idproyecto] == NULL) {
                $proyectosRiesgosAltoP[$analisis->idproyecto] = [];
            }
            $proyectosRiesgosAltoP[$analisis->idproyecto][] = $analisis->riesgo;
        }*/ 

        foreach ($riesgosFiltrados as $analisis) {
            if (!isset($proyectosRiesgosAltoP[$analisis->idproyecto])) {
                $proyectosRiesgosAltoP[$analisis->idproyecto] = [];
            }
            $proyectosRiesgosAltoP[$analisis->idproyecto][] = $analisis->riesgo;
        }
/*      
// PARA PODER IR GUARDANDO AQUELLOS RIESGOS QUE SEAN DE UN MISMO PROYECTO, SI NO TIENEN UN RIESGO SE HACE EL ARREGLO DE ESE PROYECTO
    foreach($analisisRiesgos as $analisis){
        if(!isset($proyectosRiesgosAltoP[$analisis->idproyecto])){
            $proyectosRiesgosAltoP[$analisis->idproyecto] = [];
        }
        $proyectosRiesgosAltoP[$analisis->idproyecto][] = $analisis->riesgo;
        
        /*if ($proyectosRiesgosAltoP[$analisis->idproyecto] == NULL) {
            $proyectosRiesgosAltoP[$analisis->idproyecto] = [];
        }
        $proyectosRiesgosAltoP[$analisis->idproyecto][] = $analisis->riesgo;
    }*/

foreach($riesgosOrdenados as $riesgoId){
    $reporteriesgos->setCellValue('A' . $cont, $num); 
    $reporteriesgos->setCellValue('B' . $cont, strip_tags(html_entity_decode($riesgos->find($riesgoId)->tiporiesgo)));

    $documento->getActiveSheet()->getStyle('A' . $cont)
        ->getBorders()->getOutline()
        ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); 
    $documento->getActiveSheet()->getStyle('A' . $cont)
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
        ->setWrapText(true);

    $documento->getActiveSheet()->getStyle('B' . $cont)
        ->getBorders()->getOutline()
        ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); 
    $documento->getActiveSheet()->getStyle('B' . $cont)
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
        ->setWrapText(true);  


    $lc = 67; 
    foreach ($proyectosOrdenados as $proyectoId) {
// PARA LA RELACIÓN DE SI EL PROYECTOO TIENE RIESGOS RELACIONADOS
        if (isset($proyectosRiesgosAltoP[$proyectoId])) {
            if (in_array($riesgoId, $proyectosRiesgosAltoP[$proyectoId])) {

                $celda = $reporteriesgos->getStyle(convchr($lc) . $cont);
                $celda->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFBF00'); 
                $reporteriesgos->setCellValue(convchr($lc) . $cont, 'X');

                $reporteriesgos->getStyle(convchr($lc) . $cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $celda->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }else{
                $reporteriesgos->setCellValue(convchr($lc) . $cont, '');

                $reporteriesgos->getStyle(convchr($lc) . $cont)
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        }else{
            $reporteriesgos->setCellValue(convchr($lc) . $cont, '');

            $reporteriesgos->getStyle(convchr($lc) . $cont)
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
        $lc++;
    }
    $cont++; 
    $num++; 
}



$nombreArchivo = "Reporte_Riesgos_" . date('Y-m-d_H-i-s') . ".xlsx";


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');

header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($documento, 'Xlsx');
$writer->save('php://output');
exit;

