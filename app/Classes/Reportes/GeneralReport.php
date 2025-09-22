<?php

namespace App\Classes\Reportes;

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



class GeneralReport{

    protected $projects;
    protected $fileName;
    protected $titleDoc;
    protected $formatName;

    //obj attributes
    protected $document;
    protected $activeSheet;
    protected $numberActiveSheet = 0;
    protected $headersTable;
    protected $paddingCell = 5;
    protected $elaborateDatePB = 1;
    
    protected $headerDocumentCoords = [
        'row' => 1,
        'col' => 'A'
    ];

    protected $elaborateDateCoords = [
        'row' => 6,
        'col' => 'A'
    ];
    
    protected $headersTableCoords = [
        'row' => 8,
        'col' => 'A'
    ];
    
    protected $tableCoord = [
        'row' => 9,
        'col' => 'A'
    ];

    public function __construct($projects ,$fileName = 'reporte_general',$titleDoc='Reporte General',
        $formatName = 'reporte_general'
    )
    {
        $this->projects = $projects;
        $this->fileName = $fileName;
        $this->titleDoc = $titleDoc;
        $this->formatName = $formatName;

        $this->document = new Spreadsheet();
        $this->activeSheet = $this->document->setActiveSheetIndex($this->numberActiveSheet);

        
        $this->setData(); //colocamos los datos sobre el documento
        $this->setPrintConfig(); //
        $this->saveDocument(); //guardamos el documento
        
    }

    //todas las funciones para setear los datos en el formato
    protected function setData(){
        $this->setHeadersTable();
        $this->setTitleDocument();

        $this->setElaboratedDate();
        $this->setTableProjects();
    }

    protected function writeSheet(){
        $this->activeSheet->setCellValue('B5','What tha hell is going on!');
    }

    //guarda el documento
    protected function saveDocument(){
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$this->fileName.'_'.date('Y-m-d').'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($this->document,'Xlsx');
        $writer->save('php://output');
        exit;  
    }

    //retorna una columna en letra dado un numero
    protected function getColumnFromIndex($index){
        if (($index == 0) || ($index == '0')) return 'A';
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index);
    }

    //retorna un indice dada una letra de columna
    protected function getIndexFromColumn($column){
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($column);
    }
    
    //obtienen los encabezados de acuderdo con los nombres de campos de la coleccion 
    protected function getHeadersTable(){

        if(count($this->projects) < 1){
            return  collect([]);
        }
        return array_keys($this->projects->first()->getAttributes());
    }

    //coloca el titulo a la hoja y colocamos titulo en la hoja
    protected function setTitleDocument(){

        $this->activeSheet->setTitle($this->formatName);

        //colocamos texto de titulo
        $this->activeSheet->setCellValue($this->headerDocumentCoords['col'].
        $this->headerDocumentCoords['row'],$this->titleDoc);

        $this->setFontSizeAndBold($this->headerDocumentCoords['col'].
        $this->headerDocumentCoords['row'],18,true,'Arial');
        //merge de cells para ampliar el titulo
        
        $this->activeSheet->mergeCells(
            $this->headerDocumentCoords['col'].
            $this->headerDocumentCoords['row'].':'.
            ($this->getColumnFromIndex(
                $this->getIndexFromColumn($this->headersTableCoords['col']) - 1
            )
            ).
            ($this->headersTableCoords['row'] - 2 - $this->elaborateDatePB)
        );

        //centrado y ajustado de texto
        $this->setAligmentVerticalAndHorizontal(
            $this->headerDocumentCoords['col'].
            $this->headerDocumentCoords['row'].':'.
            ($this->getColumnFromIndex(
                $this->getIndexFromColumn($this->headersTableCoords['col']) - 1
            )
            ).
            ($this->headersTableCoords['row'] - 2 - $this->elaborateDatePB)
        );

        //borde de celda
        $this->setBorderCell(
            $this->headerDocumentCoords['col'].
            $this->headerDocumentCoords['row'].':'.
            ($this->getColumnFromIndex(
                $this->getIndexFromColumn($this->headersTableCoords['col']) - 1
            )
            ).
            ($this->headersTableCoords['row'] - 2 - $this->elaborateDatePB)
        );
        
    }

    protected function setHeadersTable(){
        //obtenemos todos los encabezados, con los nombres de los campos de la coleccion
        $this->headersTable = $this->getHeadersTable();

        foreach ($this->headersTable as $header ) {

            //referencia a la celda actual
            $currentCell = $this->headersTableCoords['col'].$this->headersTableCoords['row'];
            //colocamos el encabezado
            $this->activeSheet->setCellValue($currentCell,$header);

            //asignamos el tamanio de la columna
            $this->setColumnSize($this->headersTableCoords['col'],$this->calculateSizeColFromTitle($header));
        
            //colocamos tamanio de letra y negreita
            $this->setFontSizeAndBold($currentCell,12,true,'Arial');

            //centramos el texto en la celda
            $this->setAligmentVerticalAndHorizontal($currentCell);

            //coloca borde 
            $this->setBorderCell($currentCell);

            //aumentamos una columna para colocar un encabezado
            $this->headersTableCoords['col'] = $this->getColumnFromIndex(
                $this->getIndexFromColumn($this->headersTableCoords['col']) + 1
            );
        }
    }

    //colocamos los datos de los proyectos en la tabla
    protected function setTableProjects(){
        
        foreach ($this->projects as $index => $project) {
            foreach ($this->getHeadersTable() as $indexField => $fieldValue) {
                //en caso de que sean las contribuciones, las transforma a string para mostrarlas
                if(is_array($project[$fieldValue])){
                    $this->activeSheet->setCellValue($this->getColumnFromIndex(
                        $this->getIndexFromColumn($this->tableCoord['col']) + $indexField
                    ).$this->tableCoord['row'] + $index, $this->convertContributionsToString($project[$fieldValue]));
                }else{
                    //coloca la informacion del campo
                    $this->activeSheet->setCellValue($this->getColumnFromIndex(
                        $this->getIndexFromColumn($this->tableCoord['col']) + $indexField
                    ).$this->tableCoord['row'] + $index, $project[$fieldValue]);
                }
                //colocamos el borde
                $this->setBorderCell($this->getColumnFromIndex(
                    $this->getIndexFromColumn($this->tableCoord['col']) + $indexField
                ).$this->tableCoord['row'] + $index);

                //centramos texto
                $this->setAligmentVerticalAndHorizontal($this->getColumnFromIndex(
                    $this->getIndexFromColumn($this->tableCoord['col']) + $indexField
                ).$this->tableCoord['row'] + $index);
            }
/////Use el comando strip_tags para eliminar etiquetas HTML y preg_replace para eliminar espacios en blanco adicionales.
                $cell = $this->getColumnFromIndex(
                    $this->getIndexFromColumn($this->tableCoord['col']) + $indexField
                ).($this->tableCoord['row'] + $index);
                $value = $project[$fieldValue];
              if (is_string($value)) {
                    $value = strip_tags(html_entity_decode($value));
                    $value = preg_replace('/\s+/', ' ', trim($value));
                }

                $this->activeSheet->setCellValue($cell, $value);

            
        }

    }

    protected function setBorderCell($cell){
        $this->document->getActiveSheet()->getStyle($cell)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
    }

    protected function setColumnSize($column,$size){
        $this->activeSheet->getColumnDimension($column)->setWidth($size);
    }

    protected function setRowSize($row,$size){
        $this->activeSheet->getRowDimension($row)->setRowHeight($size);
    }


    protected function calculateSizeColFromTitle($title){
        return strlen($title) + $this->paddingCell;
    }

    protected function convertContributionsToString($contributions){
        return implode('|', $contributions);
    }

    protected function setAligmentVerticalAndHorizontal($cell){
        $this->document->getActiveSheet()->getStyle($cell)
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
    }

    protected function setFontSizeAndBold($cell,$fontSize = 12,$bold = false,$fontFamily = "Arial"){
        $this->document->getActiveSheet()->getStyle($cell)->getFont()
            ->setSize($fontSize)->setName($fontFamily)->setBold($bold);
    }

    protected function setPrintConfig($imgHeight = 80){

        $this->activeSheet->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            /* define la orientacion vetical de la hoja */
        $this->activeSheet->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $this->activeSheet->getPageSetup()->setFitToWidth(1);
        $this->activeSheet->getPageSetup()->setFitToHeight(0);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        $drawing->setName('PhpSpreadsheet logo');
        $drawing->setPath('img/Logo variante.png');
        $drawing->setHeight($imgHeight);
        $this->activeSheet->getHeaderFooter()
        ->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);

        $this->activeSheet->getHeaderFooter()
        ->setOddHeader('&L&G&O'.'&C&18&"Arial,Negrita"&O'.'
        &X&O&14&"Arial"& Sistema de Gestión de la Calidad');

        $this->activeSheet->getHeaderFooter()
            ->setOddFooter('&L&"Arial,Negrita"&O REV 01,FECHA 20230921'.
            '&C&"Arial,Negrita"&O Hoja &P de &N'.
            '&R&"Arial,Negrita"&O General');

        $this->activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,4);
    }

    protected function setElaboratedDate(){

        //seteamos el valor
        $this->activeSheet->setCellValue($this->elaborateDateCoords['col'].$this->elaborateDateCoords['row'],
        'Elaborado el: '.date('Y-m-d'));

        //merged de celdas
        $this->activeSheet->mergeCells(
            $this->elaborateDateCoords['col'].$this->elaborateDateCoords['row']
            .':'.
            $this->getColumnFromIndex($this->getIndexFromColumn($this->headersTableCoords['col']) - 1).$this->elaborateDateCoords['row']
        );

        //centrado
        $this->setBorderCell(
            $this->elaborateDateCoords['col'].$this->elaborateDateCoords['row']
            .':'.
            $this->getColumnFromIndex($this->getIndexFromColumn($this->headersTableCoords['col']) - 1).$this->elaborateDateCoords['row']
        );

        //alineacion
        $this->setAligmentVerticalAndHorizontal(
            $this->elaborateDateCoords['col'].$this->elaborateDateCoords['row']
            .':'.
            $this->getColumnFromIndex($this->getIndexFromColumn($this->headersTableCoords['col']) - 1).$this->elaborateDateCoords['row']
        );
    }

}
