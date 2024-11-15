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
$ncontratos;
$afectaciones = Afectacion::join('tb_partidas','tb_partidas.id','=','tb_afectaciones.id_partida')
            -> join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            -> orderBy('proyectos.clavea','asc')
            -> orderBy('proyectos.clavet','asc')
            -> orderBy('proyectos.claven','asc')
            -> orderBy('proyectos.clavey','asc')
            -> where('ncontratos', $ncontratos)
            -> get (['proyectos.ncontratos','proyectos.nomproy', 'proyectos.clavea','proyectos.clavet',
            'proyectos.claven','proyectos.clavey', 'proyectos.costo',
            'tb_afectaciones.clc','tb_afectaciones.conceptoc','tb_afectaciones.fecha',
            'tb_partidas.partida','tb_partidas.concepto','tb_afectaciones.tipo','tb_afectaciones.montoxpartida']);
$total = Afectacion:: join('proyectos','proyectos.id','=','tb_afectaciones.id_proyecto')
            -> where('ncontratos', $ncontratos)
            ->sum('montoxpartida');
$afecta = Proyecto::where('ncontratos', $ncontratos)->sum('costo');
$variablein = Proyecto::where('ncontratos', $ncontratos)->first()->min('claven');

    $documento = new Spreadsheet();
    $documento->createSheet();
    $portada = $documento->getActiveSheet(0);
    /* Tamaño de las celdas Inicio*/
        $documento->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $documento->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $documento->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $documento->getActiveSheet()->getStyle('A5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('B5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('C5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('D5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('E5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('F5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('G5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('H5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('I5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('J5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('K5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $documento->getActiveSheet()->getStyle('L5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
    /* Tamaño de las celdas Fin*/
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
        /* Fila 5 */
        $portada->setCellValue("A5", "");
        $portada->setCellValue('A5','Número de contrato');
        $portada->setCellValue("B5", "");
        $portada->setCellValue('B5','Clave del Proyecto');
        $portada->setCellValue("C5", "");
        $portada->setCellValue('C5','Nombre del Proyecto');
        $portada->setCellValue("D5", "");
        $portada->setCellValue('D5','Número de Clc');
        $portada->setCellValue("E5", "");
        $portada->setCellValue('E5','Concepto de Clc');
        $portada->setCellValue("F5", "");
        $portada->setCellValue('F5','Fecha');
        $portada->setCellValue("G5", "");
        $portada->setCellValue('G5','Partidas Presupuestarias');
        $portada->setCellValue("H5", "");
        $portada->setCellValue('H5','Concepto de la Partida');
        $portada->setCellValue("I5", "");
        $portada->setCellValue('I5','Fuente de Financiamiento');
        $portada->setCellValue("J5", "");
        $portada->setCellValue('J5','Monto por Partida ');
        $portada->setCellValue("K5", "");
        $portada->setCellValue('K5','Monto asignado al Proyecto ');  
        /* Fila 6 */
        $cont = 6;
        $val = $variablein;
        foreach ($afectaciones as $af) {
        /* Texto estilo inicio*/
            $documento->getActiveSheet()->getStyle('A'.$cont)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('B'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('C'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('D'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('E'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('F'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('G'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('H'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('I'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('J'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('K'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('L'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        /* Texto estilo Fin */
                $portada->setCellValue('A'.$cont,$af->ncontratos);
                $portada->setCellValue('B'.$cont,$af->clavea. $af->clavet. '-'. $af->claven. '/' .$af->clavey);
                $portada->setCellValue('C'.$cont,$af->nomproy);
                $portada->setCellValue('D'.$cont,$af->clc);
                $portada->setCellValue('E'.$cont,$af->conceptoc);
                $portada->setCellValue('F'.$cont,$af->fecha);
                $portada->setCellValue('G'.$cont,$af->partida);
                $portada->setCellValue('H'.$cont,$af->concepto);
                $portada->setCellValue('I'.$cont,$af->tipo);
                $portada->setCellValue('J'.$cont,'$'.round($af->montoxpartida,2));
                $portada->setCellValue('K'.$cont,'$'.round($af->costo,2));
                if($af->claven != $val){
                        $spa = $cont+1;
                        $portada->insertNewRowBefore($cont);
                        $portada->setCellValue('A'.$spa,$af->ncontratos);
                        $portada->setCellValue('B'.$spa,$af->clavea. $af->clavet. '-'. $af->claven. '/' .$af->clavey);
                        $portada->setCellValue('C'.$spa,$af->nomproy);
                        $portada->setCellValue('D'.$spa,$af->clc);
                        $portada->setCellValue('E'.$spa,$af->conceptoc);
                        $portada->setCellValue('F'.$spa,$af->fecha);
                        $portada->setCellValue('G'.$spa,$af->partida);
                        $portada->setCellValue('H'.$spa,$af->concepto);
                        $portada->setCellValue('I'.$spa,$af->tipo);
                        $portada->setCellValue('J'.$spa,'$'.round($af->montoxpartida,2));
                        $portada->setCellValue('K'.$spa,'$'.round($af->costo,2));
                        $cont++; 
                }
                $val = $af->claven;
                $cont++; 
        }
        $cont = $cont+1;
        /* Texto estilo inicio*/
            $documento->getActiveSheet()->getStyle('A'.$cont)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('B'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('C'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('D'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('E'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('F'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('G'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('H'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('I'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('J'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('K'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('L'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        /* Texto estilo Fin */
        $portada->setCellValue('A'.$cont,'');
        $portada->setCellValue('B'.$cont,'');
        $portada->setCellValue('C'.$cont,'');
        $portada->setCellValue('D'.$cont,'');
        $portada->setCellValue('E'.$cont,'');
        $portada->setCellValue('F'.$cont,'');
        $portada->setCellValue('G'.$cont,'');
        $portada->setCellValue('H'.$cont,'');
        $portada->setCellValue('I'.$cont,'Monto Asignado del Contrato:');
        $portada->setCellValue('J'.$cont,'$'.round($afecta,2));
        $portada->setCellValue('K'.$cont,'');
        $cont = $cont+1;
        /* Texto estilo inicio*/
            $documento->getActiveSheet()->getStyle('A'.$cont)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('B'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('C'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('D'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('E'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('F'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('G'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('H'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('I'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('J'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('K'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('L'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        /* Texto estilo Fin */
        $portada->setCellValue('A'.$cont,'');
        $portada->setCellValue('B'.$cont,'');
        $portada->setCellValue('C'.$cont,'');
        $portada->setCellValue('D'.$cont,'');
        $portada->setCellValue('E'.$cont,'');
        $portada->setCellValue('F'.$cont,'');
        $portada->setCellValue('G'.$cont,'');
        $portada->setCellValue('H'.$cont,'');
        $portada->setCellValue('I'.$cont,'Monto de las Afectaciones:');
        $portada->setCellValue('J'.$cont,'$'.round($total,2));
        $portada->setCellValue('K'.$cont,'');
        $cont = $cont+1;
        /* Texto estilo inicio*/
            $documento->getActiveSheet()->getStyle('A'.$cont)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('B'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('C'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('D'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('E'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('F'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('G'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('H'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('I'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('J'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('K'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
            $documento->getActiveSheet()->getStyle('L'.$cont)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        /* Texto estilo Fin */
        $rest = $afecta - $total;
        $portada->setCellValue('A'.$cont,'');
        $portada->setCellValue('B'.$cont,'');
        $portada->setCellValue('C'.$cont,'');
        $portada->setCellValue('D'.$cont,'');
        $portada->setCellValue('E'.$cont,'');
        $portada->setCellValue('F'.$cont,'');
        $portada->setCellValue('G'.$cont,'');
        $portada->setCellValue('H'.$cont,'');
        $portada->setCellValue('I'.$cont,'Restante:');
        $portada->setCellValue('J'.$cont,'$'.round($rest,2));
        $portada->setCellValue('K'.$cont,'');
        /* Color del Documento Inicio */
        $cont = $cont+1;
                $documento->getActiveSheet()->getStyle('A1:L'.$cont)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFFFF');
         /* Color del Documento Fin */
    $nombreDelDocumento = "Por Contrato.xlsx";
    $fecha=date('Y_m_d');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$ncontratos.'-'.$fecha.'-'.$nombreDelDocumento.'"');
    header('Cache-Control: max-age=0');
 
    $writer = IOFactory::createWriter($documento, 'Xlsx');
    $writer->save('php://output');
    exit;
?>
{{-- <style>
    #aling{
        text-align: center;
    }
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<div> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<img src="\\10.34.1.205\Logo\logoIMT con letras.jpg" width="150" height="100">
</div>
<table class="text-center" border="1">
    <thead>
        <tr>
            <th scope="col">Número de contrato</th>
            <th scope="col">Clave del Proyecto</th>
            <th scope="col">Nombre del Proyecto</th>            
            <th scope="col">Número de Clc</th>
            <th scope="col">Concepto de Clc</th>
            <th scope="col">Fecha</th>
            <th scope="col">Partidas Presupuestarias</th>
            <th scope="col">Concepto de la Partida</th>
            <th scope="col">Fuente de Financiamiento</th>
            <th scope="col">Monto por Partida </th>
            <th scope="col">Monto asignado al Proyecto </th>
        </tr>
    </thead>
    <label for="" hidden>{{$valor = 0}}</label>
    <tbody>
        @foreach ($afectaciones as $af)
        <tr>
            <label for="" hidden>{{$vaant = $af->claven}}</label>
            <th scope="row">{{ $af->ncontratos }}</th>
            <td id="aling">{{$af->clavea. $af->clavet. '-'. $af->claven. '/' .$af->clavey}}</td>
            <td id="aling">{{$af->nomproy}}</td>   
            <th scope="row">{{  }}</th>
            <td id="aling">{{ $af->conceptoc }}</td>
            <td id="aling">{{ $af->fecha }}</td>
            <td id="aling">{{ $af->partida }}</td>
            <td id="aling">{{ $af->concepto}}</td>
            <td id="aling">{{ $af->tipo}}</td>
            <td id="aling">$ {{ $af->montoxpartida }}</td>
            <td id="aling">$ {{$af->costo}} </td>
        </tr>
            @if ($af->claven != $vaant)
                <tr> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id="aling">$ {{$af->costo}}</td>
                </tr> 
            @endif
            <label for="" hidden>{{$vaant = $af->claven}}</label>
        @endforeach 
        <tr>             
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td id="aling-l"><strong>Monto Asignado:</strong></td>
            <td id="aling"><strong> $ {{$valor}}</strong></td>
        
        </tr>

        <tr> 
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td id="aling-l"><strong> Monto de las Afectaciones: </strong></td>
            <td id="aling"><strong>${{$total}}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td id="aling-l"><strong> Restante:</strong></td>
            <td id="aling"><strong> $ {{$valor - $total}}</strong></td>
        </tr>
    </tbody>  
    </table> --}}

             
                        