<?php
/* 
 * Clase donde se realizaran la generacion de archivos en excel para los informes de cuentas x cobrar de los acuerdos de pago.
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

class ExcelAcuerdoPago extends ProcesoVenta{
    
    // Clase para generar excel de un balance de comprobacion
    
    public function HojaDeTrabajoAcuerdosExcel($Condicion) {
        require_once('../../../librerias/Excel/PHPExcel2.php');
        
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getStyle('H:K')->getNumberFormat()->setFormatCode('#,##0');
        $styleTitle = [
            'font' => [
                'bold' => true,
                'size' => 12
            ]
            
        ];
                
        $Campos=["A","B","C","D","E","F","G","H","I","J","K","L","M",
                 "N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB"];
        $FechaActual=date("Y-m-d");
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A1","LISTADO DE COBROS $FechaActual")
             
                ;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        //$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getTop()->applyFromArray( [ 'borderStyle' => Border::BORDER_DASHDOT, 'color' => [ 'rgb' => '808080' ] ] ); 
        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleTitle);
        $z=0;
        $i=3;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($Campos[$z++].$i,"CC")
            ->setCellValue($Campos[$z++].$i,"Nombre")
            ->setCellValue($Campos[$z++].$i,"Direccion")
            ->setCellValue($Campos[$z++].$i,"Telefono")
            ->setCellValue($Campos[$z++].$i,"Ciclo")
            ->setCellValue($Campos[$z++].$i,"#")
            ->setCellValue($Campos[$z++].$i,"Fecha")
            ->setCellValue($Campos[$z++].$i,"Valor")
            ->setCellValue($Campos[$z++].$i,"Cuota Pte.")
            ->setCellValue($Campos[$z++].$i,"Saldo")
                        
            ;
            
        $sql="SELECT * FROM acuerdo_pago_hoja_trabajo_informes $Condicion";
        $Consulta=$this->Query($sql);
        $i=3;
        $Tercero="";
        $CuotasPendientes=0;
        while($DatosVista= $this->FetchAssoc($Consulta)){
            $Encabezado=0;
            if($Tercero<>$DatosVista["Tercero"]){
                $Tercero=$DatosVista["Tercero"];
                $CuotasPendientes=0;
                $Encabezado=1;
            }
            if($Encabezado==1){
                $Identificaion=$DatosVista["Tercero"];
                $RazonSocial=$DatosVista["RazonSocial"]." (".$DatosVista["SobreNombreCliente"].")";
                $Direccion=$DatosVista["DireccionCliente"];
                $Telefono=$DatosVista["TelefonoCliente"];
                $NombreCiclo=$DatosVista["NombreCicloPago"];
                $SaldoFinal=$DatosVista["SaldoFinal"];
            }else{
                $Identificaion="";
                $RazonSocial="";
                $Direccion="";
                $Telefono="";
                $NombreCiclo="";
                $SaldoFinal="";
            }
            $CuotasPendientes=$CuotasPendientes+($DatosVista["ValorCuota"]-$DatosVista["ValorPagado"]);
            $z=0;
            $i++;
            
        $objPHPExcel->setActiveSheetIndex(0)
            
            ->setCellValue($Campos[$z++].$i,$Identificaion)
            ->setCellValue($Campos[$z++].$i,$RazonSocial)
            ->setCellValue($Campos[$z++].$i,$Direccion)
            ->setCellValue($Campos[$z++].$i,$Telefono)
            ->setCellValue($Campos[$z++].$i,$NombreCiclo)
            ->setCellValue($Campos[$z++].$i,$DatosVista["NumeroCuota"])
            ->setCellValue($Campos[$z++].$i,$DatosVista["Fecha"])
            ->setCellValue($Campos[$z++].$i,$DatosVista["ValorCuota"])
            ->setCellValue($Campos[$z++].$i,$CuotasPendientes)
            ->setCellValue($Campos[$z++].$i,$SaldoFinal)
            
            ;
            
        }
        
        $objPHPExcel->getActiveSheet()->getStyle("A3:J3")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth('10');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth('45');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth('22');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth('14');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth('11');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth('6');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth('10');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth('8');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth('9');
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth('9');
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com.co")
        ->setLastModifiedBy("www.technosoluciones.com.co")
        ->setTitle("Formato conciliacion masiva")
        ->setSubject("Formato")
        ->setDescription("Documento generado por Techno Soluciones SAS")
        ->setKeywords("techno soluciones sas")
        ->setCategory("Formato conciliacion masiva");    
 
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'."InformeCuentasXCobrar".'.xls"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter=IOFactory::createWriter($objPHPExcel,'Xlsx');
    $objWriter->save('php://output');
    exit; 
   
    }
    
    
   //Fin Clases
}
    