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

/*
    La escritura y la estilizacion de este documento sera por secciones, primero se hara la escirtura y en seguida  
    se aplicaran los estilos correspondientes a cada seccion
*/

//nombre del area del que se genera el reporte
$nombreArea = Area::find($area)->nombre_area;

//columnas que abarcara el contenido
$columns = [
    'B','C','D','E','F','G','H','I'
];

//titulo de la tabla
$headerTitle = [
    'main_title'=>[
        'from'=>[
            'row' => 2,
            'col' => 'B',
        ],
        'to'=>[
            'row' => 2,
            'col' => 'I',
        ],
        'title'=> 'PORTAFOLIO DE PROYECTOS '.date('Y')
    ]
];
//encabezados de la tabla
$headerProjects = [
    [
        'title' => 'Indetificación',
        'from' => [
            'col'=> 'B',
            'row'=> 3
        ],
        'to' => [
            'col'=> 'B',
            'row'=> 4
        ]
    ],
    [
        'title' => 'Nombre del proyecto',
        'from' => [
            'col'=> 'C',
            'row'=> 3
        ],
        'to' => [
            'col'=> 'C',
            'row'=> 4
        ]
    ],
    [
        'title' => 'Solicitante y/o usuario',
        'from' => [
            'col'=> 'D',
            'row'=> 3
        ],
        'to' => [
            'col'=> 'D',
            'row'=> 4
        ]
    ],
    [
        'title' => 'Beneficios',
        'from' => [
            'col'=> 'E',
            'row'=> 3
        ],
        'to' => [
            'col'=> 'E',
            'row'=> 4
        ]
    ],

    [
        'title'=>[
            'text'=> 'Fecha',
            'from' => [
                'col'=> 'F',
                'row'=> 3
            ],
            'to' => [
                'col'=> 'G',
                'row'=> 3
            ]
        ],
        'subtitles'=>[
            'start'=>[
                'text'=>'Inicio',
                'from' => [
                    'col'=> 'F',
                    'row'=> 4
                ],
                'to' => [
                    'col'=> 'F',
                    'row'=> 4
                ]
            ],
            'end'=>[
                'text'=>'Término',
                'from' => [
                    'col'=> 'G',
                    'row'=> 4
                ],
                'to' => [
                    'col'=> 'G',
                    'row'=> 4
                ]
            ]
        ]
    ],

    [
        'title' => 'Costo (miles de $)',
        'from' => [
            'col'=> 'H',
            'row'=> 3
        ],
        'to' => [
            'col'=> 'H',
            'row'=> 4
        ]
    ],
    [
        'title' => '% Financiamiento',
        'from' => [
            'col'=> 'I',
            'row'=> 3
        ],
        'to' => [
            'col'=> 'I',
            'row'=> 4
        ]
    ],
    
];
//subsecciones por tipo de proyecto
$labelsTypeProject = [
    'externos' => 'PROYECTOS DE INVESTIGACIÓN EXTERNA',
    'internos' => 'PROYECTOS DE INVESTIGACIÓN INTERNA',
    'negociando' => 'PROYECTOS EN NEGOCIACIÓN',
    'espera' => 'PROYECTOS EN ESPERA',
];

//esquina de donde se empezara la tabla de proyectos
$tableProject = [
    'col' => $columns[0], //B
    'row' => 5
];
//footer de la tabla, se muestra el total de proyectos y meta anual
$footer = [
    [
        'title' =>[ 
            'text' => 'No.Total de Proyectos:',
            'cells' => 2,
        ],
        'value'=>[
            'text' => $totalProjects,
            'cells' => 1
        ]
    ],
    [
        'title' =>[ 
            'text' => 'Meta Anual:',
            'cells' => 3,
        ],
        'value'=>[
            'text' => '[META_ANUAL]',
            'cells' => 2
        ]
    ],
];
//inserta la seccion de tipo de proyecto, con sus proyectos correspondientes
function setSectionProjects($activeSheet,$title,$cols,$projects,$col,$row){
    //establecemos el titulo de la seccion
    $activeSheet->setCellValue($col.$row,$title);
    $activeSheet->mergeCells($col.$row.':'.$cols[count($cols)-1].$row);

    //estilos
    $activeSheet->getStyle($col.$row)->getFont()
            ->setSize(14)->setName('Aptos')->setBold(false);
    //alineaciones
    $activeSheet->getStyle($col.$row)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);

    $lastRow =   $row + 1;
    
    if(count($projects) < 1|| empty($projects) || is_null($projects) ){
        //agregamos una fila vacia
        for ($i=0; $i < count($cols); $i++) { 
            
            if ($i == 0) {
                $activeSheet->setCellValue($cols[$i].$lastRow,'No hay proyectos de este tipo');  
                $activeSheet->getStyle($cols[$i].$lastRow)
                    ->getAlignment()->setWrapText(true);
            }
            $activeSheet->getStyle($cols[$i].$lastRow)
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_THIN);
        }

        return [
            'col' => $col,
            'row' => $lastRow + 1
        ];
    }
    

    //agregamos los proyectos
    foreach ($projects as $project ) { //=> $value

        $activeSheet->setCellValue($cols[0].$lastRow,$project->clave_project);
        setStyleAlign($activeSheet,$cols[0],$lastRow,true);

        $activeSheet->setCellValue($cols[1].$lastRow,$project->nomproy);
        setStyleAlign($activeSheet,$cols[1],$lastRow);

        $activeSheet->setCellValue($cols[2].$lastRow,$project->Nombre.' '.$project->Apellido_Paterno
                                        .' '.$project->Apellido_Materno);
        setStyleAlign($activeSheet,$cols[2],$lastRow,true);

        $activeSheet->setCellValue($cols[3].$lastRow,"[Beneficios del proyecto]");
        setStyleAlign($activeSheet,$cols[3],$lastRow,true);
        
        $activeSheet->setCellValue($cols[4].$lastRow,$project->fecha_inicio);
        setStyleAlign($activeSheet,$cols[4],$lastRow,true);
        
        $activeSheet->setCellValue($cols[5].$lastRow,$project->fecha_fin);
        setStyleAlign($activeSheet,$cols[5],$lastRow,true);

        $activeSheet->getStyle($cols[6].$lastRow)->getNumberFormat()->setFormatCode('$ #,##0.00');
        $activeSheet->setCellValue($cols[6].$lastRow,$project->costo);
        setStyleAlign($activeSheet,$cols[6],$lastRow,true);
        
        $activeSheet->setCellValue($cols[7].$lastRow,'[% Financiamiento]');
        setStyleAlign($activeSheet,$cols[7],$lastRow,true);

        $lastRow =   $lastRow + 1;      

    }        

    $lastPosition = [
        'col' => $col,
        'row' => $lastRow
    ];

    return $lastPosition;
}

function setStyleAlign($activeSheet,$col,$row,$centeredCell=false){

    //estilos
    $activeSheet->getStyle($col.$row)->getFont()
        ->setSize(11)->setName('Aptos Narrow')->setBold(false);

    //bordes
    $activeSheet->getStyle($col.$row)
        ->getBorders()
        ->getOutline()
        ->setBorderStyle(Border::BORDER_THIN); 
    //alineaciones
    $activeSheet->getStyle($col.$row)
            ->getAlignment()
            ->setWrapText(true);

    if ($centeredCell) {
        $activeSheet->getStyle($col.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }

}


//setea el footer
function setFooterDoc($activeSheet,$footer,$col,$row,$cols){

    $currentIndexCol = array_search($col, array_keys($cols));

    foreach ($footer as $field ) { //=> $value
        foreach ($field as $fieldValue) {
            //titulo del campo
            $activeSheet->setCellValue(($cols[$currentIndexCol]).$row,
            $fieldValue['text']); 
            //mergde celdas que ocupa
            $activeSheet->mergeCells(($cols[$currentIndexCol]).$row.':'
            .($cols[$currentIndexCol+$fieldValue['cells']-1]).$row);
            //font
            $activeSheet->getStyle(($cols[$currentIndexCol]).$row)->getFont()
            ->setSize(11)->setName('Arial')->setBold(true); 
            $activeSheet->getStyle(($cols[$currentIndexCol]).$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); 
            //bordes
            $activeSheet->getStyle(($cols[$currentIndexCol]).$row.':'
            .($cols[$currentIndexCol+$fieldValue['cells']-1]).$row)
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);  
            //la ultima columna para escribir
            $currentIndexCol = $currentIndexCol+$fieldValue['cells'];
        }
    }
    return [
        'col' => $cols[count($cols)-1],
        'row'=> $row + 1
    ];
}

//setea la fecha de elaboracion del doucmento
function setDateElaboration($activeSheet,$col,$row,$cols){
    $currentIndexCol = array_search($col, array_keys($cols));
    //titulo del campo
    $activeSheet->setCellValue(($cols[$currentIndexCol]).$row,
    'Fecha elaboración:'); 

    $activeSheet->setCellValue(($cols[$currentIndexCol + 1]).$row,
    date('Y').'/'.getMonth(date('m')).'/'.date('d'));

    //alineaciones
    $activeSheet->getStyle(($cols[$currentIndexCol]).$row.':'
    .($cols[$currentIndexCol + 1]).$row)
    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    //bordes
    $activeSheet->getStyle(($cols[$currentIndexCol]).$row.':'
    .($cols[$currentIndexCol + 1]).$row)
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);

    return [
        'col' => $cols[count($cols)-1],
        'row'=> $row + 1
    ];                
}

function getMonth($month){
    $months = [
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'MArzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre',
    ];
    return $months[$month];
}


function setPageConfig($documento){
    /* Formato de la Hoja Inicio */
    $documento->getActiveSheet()->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        /* define la orientacion vetical de la hoja */
    $documento->getActiveSheet()->getPageSetup()
        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        /* Define el tamaño de papel */
    //$documento->getActiveSheet()->getPageSetup()->setFitToPage(100);/* Escala la hoja para el contenido */
    /* Formato de la Hoja Fin */

    $documento->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $documento->getActiveSheet()->getPageSetup()->setFitToHeight(0);
    /* Formato de la Hoja Fin */
}

function setFooterPrint($activeSheet){
    $activeSheet->getHeaderFooter()
            ->setOddFooter('&L&"Arial,Negrita"&O REV 05,FECHA 20230921'.
            '&C&"Arial,Negrita"&O Hoja &P de &N'.
            '&R&"Arial,Negrita"&O F2 GS-001');
}

function setHeaderPrint($activeSheet,$areaName){

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        $drawing->setName('PhpSpreadsheet_logo');
        $drawing->setPath('img/Logo variante.png');
        $drawing->setHeight(80);
        $activeSheet->getHeaderFooter()
        ->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);

        $activeSheet->getHeaderFooter()
        ->setOddHeader('&L&G&O'.'&C&18&"Arial,Negrita"&O'.$areaName.'
        &X&16&"Arial"& Sistema de Gestión de la Calidad');
        
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,4);

    }

function setSignArea($activeSheet,$col,$row,$cols,$jefeArea,$area){

    //txt aprobado
    $activeSheet->setCellValue('E'.($row + 2),"Aprobó");
    $activeSheet->getStyle('E'.($row + 2))
    ->getFont()
    ->setSize(11)
    ->setName("Arial")
    ->setBold(true);

    $activeSheet->getStyle('E'.($row + 2))
    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);

    //establecemos con fondo blanco las celdas
    $activeSheet->getStyle('D'.($row + 3).':'.'G'.($row + 10))->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFFFF');

    //merge de celdas para nombre y grado del responsable
    $activeSheet->mergeCells('D'.($row + 8).':'.'G'.($row + 8));
    $activeSheet->getStyle('D'.($row + 8))
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
    //setamos el nombre del responsable
    $activeSheet->setCellValue('D'.($row + 8),$jefeArea);
    
    //grado el responsable
    $activeSheet->mergeCells('D'.($row + 9).':'.'G'.($row + 9));
    $activeSheet->getStyle('D'.($row + 9))
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
    //setamos el nombre del responsable
    $activeSheet->setCellValue('D'.($row + 9),$area);

    //agregamos la linea para la firma
    $activeSheet->getStyle('E'.($row + 7))
    ->getBorders()
    ->getBottom()
    ->setBorderStyle(Border::BORDER_THIN);

    //seteamos los bordes del rectangulo donde va la firma
    $activeSheet->getStyle('D'.($row + 3).':'.'G'.($row + 10))
    ->getBorders()
    ->getOutline()
    ->setBorderStyle(Border::BORDER_THIN);
}

//configuracion de zona horaria y lenguaje
date_default_timezone_set('America/Mexico_City');
setLocale(LC_TIME, 'es_MX.UTF-8');
setLocale(LC_TIME, 'spanish');

//para general el documento
$documento = new Spreadsheet();
$documento->createSheet();


//generar las hojas del excel
$documento->setActiveSheetIndex(0);
//titulo de la hoja
$documento->getActiveSheet()->setTitle('F2_GS-001');

//referencia a hoja activa
$activeSheet = $documento->getActiveSheet(0);

//configuracion pagina
setPageConfig($documento);

/*tamanios de las columnas*/
$activeSheet->getColumnDimension('A')->setWidth(3.5);
$activeSheet->getColumnDimension($columns[0])->setWidth(21);
$activeSheet->getColumnDimension($columns[1])->setWidth(34);
$activeSheet->getColumnDimension($columns[2])->setWidth(26);
$activeSheet->getColumnDimension($columns[3])->setWidth(30);
$activeSheet->getColumnDimension($columns[4])->setWidth(13);
$activeSheet->getColumnDimension($columns[5])->setWidth(13);
$activeSheet->getColumnDimension($columns[6])->setWidth(23);
$activeSheet->getColumnDimension($columns[7])->setWidth(21);

/*
 Altos de las filas
*/
//$activeSheet->getRowDimension('2')->setRowHeight(30);
$activeSheet->getRowDimension('2')->setRowHeight(40);
$activeSheet->getRowDimension('3')->setRowHeight(30);



//ESCRITURA Y MODIFICACION DEL DOCUMENTO


//h1
$activeSheet->mergeCells($headerTitle['main_title']['from']['col'].$headerTitle['main_title']['from']['row']
                        .':'.$headerTitle['main_title']['to']['col'].$headerTitle['main_title']['to']['row']);
$activeSheet->setCellValue($headerTitle['main_title']['from']['col'].$headerTitle['main_title']['from']['row'],
                $headerTitle['main_title']['title']);    
//estilos
$activeSheet->getStyle($headerTitle['main_title']['from']['col'].$headerTitle['main_title']['from']['row'])
                ->getFont()->setSize(12)->setName('Arial')->setBold(true);  
//alineaciones
$activeSheet->getStyle($headerTitle['main_title']['from']['col'].$headerTitle['main_title']['from']['row'])
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);              
//bordes
$activeSheet->getStyle($headerTitle['main_title']['from']['col'].$headerTitle['main_title']['from']['row']
.':'.$headerTitle['main_title']['to']['col'].$headerTitle['main_title']['to']['row'])
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);

//establecemos los encabezados de columna
foreach ($headerProjects as $header ) { //=> $header

    //en caso de que sea el campo de fecha
    if (isset($header['subtitles'])) {
        //titulo de 'Fecha'
        $activeSheet->mergeCells($header['title']['from']['col'].$header['title']['from']['row'].
        ':'.$header['title']['to']['col'].$header['title']['to']['row']);
        $activeSheet->setCellValue($header['title']['from']['col'].
        $header['title']['from']['row'],$header['title']['text']);

        //estilos
        $activeSheet->getStyle($header['title']['from']['col'].$header['title']['from']['row'])->getFont()
            ->setSize(11)->setName('Arial')->setBold(true);
        //alineaciones
        $activeSheet->getStyle($header['title']['from']['col'].$header['title']['from']['row'])
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        //bordes
        $activeSheet->getStyle($header['title']['from']['col'].$header['title']['from']['row'].
                    ':'.$header['title']['to']['col'].$header['title']['to']['row'])
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN); 

        //subtitulos
        foreach ($header['subtitles'] as $subtitle ) { //=> $value
            $activeSheet->setCellValue($subtitle['from']['col'].
                        $subtitle['from']['row'],$subtitle['text']);
            //estilos
            $activeSheet->getStyle($subtitle['from']['col'].$subtitle['from']['row'])->getFont()
                ->setSize(11)->setName('Arial')->setBold(true);
            //alineaciones
            $activeSheet->getStyle($subtitle['from']['col'].$subtitle['from']['row'])
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            //bordes
            $activeSheet->getStyle($subtitle['from']['col'].$subtitle['from']['row'].
                        ':'.$subtitle['to']['col'].$subtitle['to']['row'])
                        ->getBorders()
                        ->getOutline()
                        ->setBorderStyle(Border::BORDER_THIN);                        
        }


    }else{   
        $activeSheet->mergeCells($header['from']['col'].$header['from']['row'].':'.$header['to']['col'].$header['to']['row']);
        $activeSheet->setCellValue($header['from']['col'].$header['from']['row'],$header['title']);
        //estilos
        $activeSheet->getStyle($header['from']['col'].$header['from']['row'])->getFont()
                ->setSize(11)->setName('Arial')->setBold(true);
        //alineaciones
        $activeSheet->getStyle($header['from']['col'].$header['from']['row'])
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        //bordes
        $activeSheet->getStyle($header['from']['col'].$header['from']['row'].
                    ':'.$header['to']['col'].$header['to']['row'])
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
    }
}

//Insertamos los proyectos

//proyectos externos
$tableProject = setSectionProjects($activeSheet,$labelsTypeProject['externos'],$columns,$extProjects,
$tableProject['col'],$tableProject['row']);

//proyectos internos
$tableProject = setSectionProjects($activeSheet,$labelsTypeProject['internos'],$columns,$internalProjects,
$tableProject['col'],$tableProject['row']);

//proyectos negociando
$tableProject = setSectionProjects($activeSheet,$labelsTypeProject['negociando'],$columns,$negotiationProjects,
$tableProject['col'],$tableProject['row']);

//proyectos en espera
$tableProject = setSectionProjects($activeSheet,$labelsTypeProject['espera'],$columns,$waitProjects,
$tableProject['col'],$tableProject['row']);

//footer con los datos de los proyectos

$tableProject = setFooterDoc($activeSheet,$footer,
                $tableProject['col'],$tableProject['row'],$columns);

//fecha de elaboracion
$tableProject = setDateElaboration($activeSheet,$tableProject['col'],
$tableProject['row'],$columns);                

//area para las firmas
setSignArea($activeSheet,$tableProject['col'],$tableProject['row'],$columns,$jefeArea,$nombreArea);

//footer para impresion
setFooterPrint($activeSheet);
//header para impresion 
setHeaderPrint($activeSheet,$nombreArea);


//Nombre del documento
$nombreDelDocumento = "Reporte_F2_GS-001";
$fecha = date('Y_m_d');
//  Fin del Nombre del documento

/* Encabezado y lineas para la impresion Inicio */
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nombreDelDocumento.'-'.Str::slug($nombreArea).'_'.$fecha.'.xlsx"');
    header('Cache-Control: max-age=0');
 
    $writer = IOFactory::createWriter($documento, 'Xlsx');
    $writer->save('php://output');
    exit;
/* Encabezado y lineas para la impresion Fin*/

