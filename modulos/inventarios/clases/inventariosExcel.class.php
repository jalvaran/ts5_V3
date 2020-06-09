<?php
/* 
 * Clase donde se realizaran la generacion de archivos en excel para el modulo de inteligencia de negocios
 * Julian Alvaran 
 * Techno Soluciones SAS
 */
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class ExcelIntentarios extends ProcesoVenta{
    
    // Clase para generar excel de un balance de comprobacion
    
    public function ListadoSeparadosExcel($Condicion) {
        require_once('../../../librerias/Excel/PHPExcel2.php');
        
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getStyle('G:H')->getNumberFormat()->setFormatCode('#,##0');
        $styleTitle = [
            'font' => [
                'bold' => true,
                'size' => 12
            ]
            
        ];
                
        $Campos=["A","B","C","D","E","F","G","H","I","J","K","L","M",
                 "N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB"];
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A1","LISTADO DE SEPARADOS")
             
                ;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
        //$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getTop()->applyFromArray( [ 'borderStyle' => Border::BORDER_DASHDOT, 'color' => [ 'rgb' => '808080' ] ] ); 
        //$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleTitle);
        $z=0;
        $i=3;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($Campos[$z++].$i,"ID")
            ->setCellValue($Campos[$z++].$i,"Fecha")
            ->setCellValue($Campos[$z++].$i,"Fecha de Vencimiento")    
            ->setCellValue($Campos[$z++].$i,"Cliente")
            ->setCellValue($Campos[$z++].$i,"Identificacion")
            ->setCellValue($Campos[$z++].$i,"Telefono")
            ->setCellValue($Campos[$z++].$i,"Valor")
            ->setCellValue($Campos[$z++].$i,"Saldo")
            ->setCellValue($Campos[$z++].$i,"Estado")
                                    
            ;
            
        $sql="SELECT * FROM vista_separados_reportes $Condicion";
        $Consulta=$this->Query($sql);
        $i=3;
        while($DatosVista= $this->FetchAssoc($Consulta)){
            
            $i++;
            $z=0;
            $objPHPExcel->setActiveSheetIndex(0)

                ->setCellValue($Campos[$z++].$i,$DatosVista["ID"])
                ->setCellValue($Campos[$z++].$i,$DatosVista["Fecha"])
                ->setCellValue($Campos[$z++].$i,$DatosVista["FechaVencimiento"])
                ->setCellValue($Campos[$z++].$i, utf8_encode($DatosVista["RazonSocial"]))
                ->setCellValue($Campos[$z++].$i,$DatosVista["Num_Identificacion"])
                
                ->setCellValue($Campos[$z++].$i,$DatosVista["Telefono"])
                ->setCellValue($Campos[$z++].$i,$DatosVista["Total"])
                
                ->setCellValue($Campos[$z++].$i,$DatosVista["Saldo"])
                ->setCellValue($Campos[$z++].$i,$DatosVista["Estado"])

                ;
            
        }
        
        
        $objPHPExcel->getActiveSheet()->getStyle("A3:M3")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth('12');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth('40');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth('10');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth('10');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth('12');
        
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com.co")
        ->setLastModifiedBy("www.technosoluciones.com.co")
        ->setTitle("Lista de Clientes")
        ->setSubject("Clientes")
        ->setDescription("Documento generado por Techno Soluciones SAS")
        ->setKeywords("techno soluciones sas")
        ->setCategory("Lista de Separados");    
 
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'."Separados".'.xls"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter=IOFactory::createWriter($objPHPExcel,'Xlsx');
    $objWriter->save('php://output');
    exit; 
   
    }
        
   //Fin Clases
}
    