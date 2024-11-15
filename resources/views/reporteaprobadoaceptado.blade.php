<?php
require_once '../vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Language;
use PHPOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Alignment;
use PhpOffice\PhpWord\Style\Paper;
use PhpOffice\PhpWord\Element\Table;

$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->getSettings()->setThemeFontLang(new Language("ES-MX"));

// Estilos de textos inicio
    /*En este espacio se colocan las propiedades de los estilos del texto que tendra el
    documento, en base a las necesidades del documentos*/
$fontStyleText = 'oneUserDefinedStyle';
$phpWord->addFontStyle(
    $fontStyleText,
    array('name' => 'Arial', 'size' => 8.5)
);
$phpWord->addFontStyle(
    'titulo',
    array('name' => 'Arial', 'size' => 8.5, 'bold' => true)
);
$phpWord->addFontStyle(
    'encabezado',
    array('name' => 'Arial', 'size' => 16, 'bold' => true)
);
$phpWord->addFontStyle(
    'encabezado1',
    array('name' => 'Arial', 'size' => 12, 'bold' => true)
);
$phpWord->addFontStyle(
    'encabezado2',
    array('name' => 'Arial', 'size' => 10, 'bold' => true)
);
$phpWord->addFontStyle(
    'encabezado3',
    array('name' => 'Arial', 'size' => 10)
);
$phpWord->addFontStyle(
    'letrastablas',
    array('name' => 'Arial', 'size' => 11, 'bold' => false, 'align' => 'justify' )
);
$phpWord->addFontStyle(
    'letrastablas1',
    array('name' => 'Arial', 'size' => 9)
);
$styleTable1 = array('borderSize' => 1,
                'borderColor' => 'ffffff',
                'cellMargin' => 80
            );
$styleTable2 = array('borderSize' => 1,
                'borderColor' => 'ffffff',
                'cellMargin' => 80
            );
$styleTable3 = array('borderSize' => 1,
                'borderColor' => '000000',
                'cellMargin' => 40,0,40,0,
                'align' => 'end'
            );
$styleCell = array('valign' => 'center');
$cellRowSpan = array('borderSize' => 1,
                'borderColor' => 'ffffff',
                'cellMargin' => 80,
                'vMerge' => 'restart',
                'valign' => 'center');
$cellRowContinue = array('vMerge' => 'continue');
$cellColSpan2 = array('borderSize' => 1,
                    'borderColor' => '#000000',
                    'gridSpan' => 3,
                    'valign' => 'center');
$cellColSpan = array('gridSpan' => 3, 'valign' => 'center');
$cellHCentered = array('align' => 'center');
$cellVCentered = array('valign' => 'center');

$fechames = date('m');
switch ($fechames) {
    case 1:
        $mes = 'Enero';
        break;
    case 2:
        $mes = 'Febrero';
        break;
    case 3:
        $mes = 'Marzo';
        break;
    case 4:
        $mes = 'Abril';
        break;
    case 5:
        $mes = 'Mayo';
        break;
    case 6:
        $mes = 'Junio';
        break;
    case 7:
        $mes = 'Julio';
        break;
    case 8:
        $mes = 'Agosto';
        break;
    case 9:
        $mes = 'Septiembre';
        break;
    case 10:
        $mes = 'Octubre';
        break;
    case 11:
        $mes = 'Noviembre';
        break;
    default:
        $mes = 'Diciembre';
    }
$fechadias = date('d');

// Estilos de textos fin

// Cantidad de hojsa y propiedades Inicio
    /*Define el tamaño de las hojas del documento y el orden de creacion de las hojas
    las medidas de las hojas actuales corresponden con el tamaño carta para cambiarlos
    para otras medidadas basta con buscar las medidas en IN de la hoja correspondiente*/
$section1 = $phpWord->addSection([
    'pageSizeH' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11),
    'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.5)
]);

// $section = $phpWord->addSection([
//     'pageSizeH' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11),
//     'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.5)
// ]);

// Cantidad de hojsa y propiedades Inicio

// Hoja 1 Inicio
    // Inicio del Header de la hoja de inicio
        //nota: este header solo afecta a esta hoja
        $header = $section1->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow(50);
        $table->addCell(120, $cellRowSpan)->addImage('img/IMT-LOGO.png',
                            array('width'  => 84,
                            'height' => 62,
                            'align'  => 'START'
                        ));
        $table->addCell(8000, $styleTable1)->addText('',
                'encabezado2',
                array(
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                ));
        $table->addRow(50);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(8000, $styleTable1)->addText('INSTITUTO MEXICANO DEL TRANSPORTE',
                'encabezado',
                array(
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                ));
        $table->addRow(50);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(8000, $styleTable1)->addText('AUTORIZACIÓN REPROGRAMACIÓN DE PROYECTO',
                'encabezado1',
                array(
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                ));
        // $lineStyle = array('weight' => 3, 'width' => 450, 'height' => 0, 'color' => '#444444');
        // $header->addLine($lineStyle);
    // Fin del Header de la hoja de inicio

    // Inicio de contenido de hoja 1
        $section1->addTextBreak(1);
        $section1->addTextBreak(1);
        $section1->addTextBreak(1);
        $section1->addText(htmlspecialchars($responsable->Nombre.' '.$responsable->Apellido_Paterno.' '.$responsable->Apellido_Materno), 'letrastablas');
        $section1->addText(htmlspecialchars('Responsable del Proyecto.'), 'letrastablas');
        if ($pr->claven < 10) {
            $nombreproyecto = $pr->clavea.''.$pr->clavet.'-0'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
        } else 	{
            $nombreproyecto = $pr->clavea.''.$pr->clavet.'-'.$pr->claven.'/'.$pr->clavey.' | '.$pr->nomproy;
        }
        $section1->addText(htmlspecialchars($nombreproyecto), 'letrastablas');
        $section1->addTextBreak(1);
        $section1->addText(htmlspecialchars('Analizando lo planteado en la justificación'), 'letrastablas');
        $section1->addText(htmlspecialchars($obs->obs), 'letrastablas');
        $section1->addTextBreak(1);
        $section1->addText(htmlspecialchars('Se determina viable la Reprogramación del Proyecto '.$nombreproyecto.', por lo que puede proceder con los cambios que considere pertinentes en el Sistema de Administración de Proyectos (SIAPIMT), considerando que se deben especificar las pausas en el mismo; es decir, que la duración neta no debe variar, aunque se modifique la fecha de fin, para evitar cambios en los porcentajes ya reportados.'), 'letrastablas');
        $section1->addTextBreak(1);
        $section1->addText(htmlspecialchars('Sin más por el momento,'), 'letrastablas');
        $section1->addTextBreak(1);
        $section1->addText(htmlspecialchars('Atentamente,'), 'letrastablas');
        $section1->addText(htmlspecialchars($autoriza->Nombre.' '.$autoriza->Apellido_Paterno.' '.$autoriza->Apellido_Materno), 'letrastablas');
        $section1->addText(htmlspecialchars($area->nombre_area), 'letrastablas');
        $section1->addTextBreak(1);
    // Fin de contenido de hoja 1

    // Inicio del footer de la hoja de inicio
        //nota: este footer solo afecta a esta hoja
        // $footer = $section1->addFooter();
        // $footer->firstPage();
        // $lineStyle = array('weight' => 1,
        //                 'width' => 180,
        //                 'height' => 0,
        //                 'color' => '#000000',
        //                 'align'  => 'center');
        // $footer->addLine($lineStyle);
        // $table = $footer->addTable();
        // $table->addRow();
        // $table->addCell(10000, $styleTable1)->addText('Usuario',
        //         'encabezado3',
        //         array(
        //             'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        //         ));
        // $table->addRow();
        // $table->addCell(10000, $styleTable2)->addText('Nombre y Firma',
        //         'encabezado2',
        //         array(
        //             'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        //         ));
    // Fin del footer de la hoja de inicio
// Hoja 1 fin

// Hoja 2 Inicio
// Hoja 2 Fin
// foreach ($nombre as $nom) {
//     $nomd = $nom->nombre;
// }

$file = 'Autorización Reprogramacion-'.$nombreproyecto.'.docx';
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$xmlWriter->save("php://output");

