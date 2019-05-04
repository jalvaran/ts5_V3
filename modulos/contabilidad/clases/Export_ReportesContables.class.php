<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
    
}
if(file_exists("../../../librerias/Excel/PHPExcel.php")){
    
    require_once '../../../librerias/Excel/PHPExcel.php';
}


class ExportReportes extends conexion{
    
    public $Campos = array("A","B","C","D","E","F","G","H","I","J","K","L",
    "M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP");
    
    public function ExportarBalanceXTercerosAExcel(){
        
        $objPHPExcel = new PHPExcel();  
        
        $objPHPExcel->getActiveSheet()->getStyle('A:C')->getNumberFormat()->setFormatCode('#');
        $objPHPExcel->getActiveSheet()->getStyle('E:I')->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->getActiveSheet()->getStyle("A:F")->getFont()->setSize(10);
        
        $f=1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[1].$f,"BALANCE DE COMPROBACION X TERCEROS")
                        
            ;
        $f=2;
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[0].$f,"CUENTA")
            ->setCellValue($this->Campos[1].$f,"NOMBRE")
            ->setCellValue($this->Campos[2].$f,"TERCERO")
            ->setCellValue($this->Campos[3].$f,"RAZON SOCIAL")
            ->setCellValue($this->Campos[4].$f,"FECHA")
            ->setCellValue($this->Campos[5].$f,"SALDO ANTERIOR")
            ->setCellValue($this->Campos[6].$f,"DEBITOS")
            ->setCellValue($this->Campos[7].$f,"CREDITOS")
            ->setCellValue($this->Campos[8].$f,"NUEVO SALDO")
            
            
            ;
         
        $sql="SELECT SUBSTRING(CuentaPUC,1,2) as Grupo,SUM(SaldoInicialSubcuenta) as SaldoInicialGrupo FROM vista_balancextercero2 GROUP BY SUBSTRING(CuentaPUC,1,2);";
        $Consulta=$this->Query($sql);
        
        while($DatosInicialesGrupo=$this->FetchArray($Consulta)){
            $Grupo=$DatosInicialesGrupo["Grupo"];
            $SaldosIniciales["Grupo"][$Grupo]=$DatosInicialesGrupo["SaldoInicialGrupo"];
        }
        
        $sql="SELECT SUBSTRING(CuentaPUC,1,1) as Clase,SUM(SaldoInicialSubcuenta) as SaldoInicialClase FROM vista_balancextercero2 GROUP BY SUBSTRING(CuentaPUC,1,1);";
        $Consulta=$this->Query($sql);
        
        while($DatosInicialesClase=$this->FetchArray($Consulta)){
            $Clase=$DatosInicialesClase["Clase"];
            $SaldosIniciales["Clase"][$Clase]=$DatosInicialesClase["SaldoInicialClase"];
        }
        
        $sql="SELECT * FROM vista_balancextercero2";
        $Consulta=$this->Query($sql);
        $TotalDebitos=0;
        $TotalCreditos=0;
        $SaldoAnterior=0;
        $f=3;
        $ClaseAnterior="";
        $GrupoAnterior="";
        $identificacionAnterior="";
        $SaldoInicialClase=0;
        $SaldoInicialGrupo=0;
        while($DatosLibro= $this->FetchArray($Consulta)){
                        
            
            if($DatosLibro["Identificacion"]<>$identificacionAnterior){
                $identificacionAnterior=$DatosLibro["Identificacion"];
                $SaldoAnterior=$DatosLibro["SaldoInicialSubCuenta"];
               // $f++;
            }
            
            if($DatosLibro["Clase"]<>$ClaseAnterior){
                $ClaseAnterior=$DatosLibro["Clase"];
                $Clase=$DatosLibro["Clase"];
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($this->Campos[0].$f,$DatosLibro["Clase"])
                    ->setCellValue($this->Campos[1].$f,$DatosLibro["NombreClase"])
                    
                    ->setCellValue($this->Campos[5].$f,$SaldosIniciales["Clase"][$Clase])
                    ->setCellValue($this->Campos[6].$f,$DatosLibro["Debito"])
                    ->setCellValue($this->Campos[7].$f,$DatosLibro["Credito"])
                    ->setCellValue($this->Campos[8].$f,"")

                    ;
                $LineaActualClase=$f;
                $SaldoInicialClase=0;
                $f++;
            }
            
            if($DatosLibro["Grupo"]<>$GrupoAnterior){
                $f++;
                $GrupoAnterior=$DatosLibro["Grupo"];
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($this->Campos[0].$f,$DatosLibro["Grupo"])
                    ->setCellValue($this->Campos[1].$f,$DatosLibro["NombreGrupo"])
                    
                    ->setCellValue($this->Campos[5].$f,"@SaldoInicialGrupo")
                    ->setCellValue($this->Campos[6].$f,$DatosLibro["Debito"])
                    ->setCellValue($this->Campos[7].$f,$DatosLibro["Credito"])
                    ->setCellValue($this->Campos[8].$f,"")

                    ;
                $LineaActualGrupo=$f;
                $SaldoInicialGrupo=0;
            }
            
            $NuevoSaldo=$SaldoAnterior+$DatosLibro["Debito"]-$DatosLibro["Credito"];
            /**
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[0].$f,$DatosLibro["CuentaPUC"])
            ->setCellValue($this->Campos[1].$f,$DatosLibro["NombreCuenta"])             
            ->setCellValue($this->Campos[2].$f,$DatosLibro["Identificacion"])
            ->setCellValue($this->Campos[3].$f,$DatosLibro["Razon_Social"])
            ->setCellValue($this->Campos[4].$f,$DatosLibro["Fecha"])
            ->setCellValue($this->Campos[5].$f,$SaldoAnterior)
            ->setCellValue($this->Campos[6].$f,$DatosLibro["Debito"])
            ->setCellValue($this->Campos[7].$f,$DatosLibro["Credito"])
            ->setCellValue($this->Campos[8].$f,$NuevoSaldo)
            
            ;
            $f++;
             
            
             * 
             */
            $SaldoAnterior=$SaldoAnterior+$DatosLibro["Debito"]-$DatosLibro["Credito"]; 
            
            
            $SaldoInicialClase=$SaldoInicialClase+$SaldoAnterior;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[5].$LineaActualClase,$SaldoInicialClase);
            
            $SaldoInicialGrupo=$SaldoInicialGrupo+$SaldoAnterior;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[5].$LineaActualGrupo,$SaldoInicialGrupo);
            
            $TotalDebitos=$TotalDebitos+$DatosLibro["Debito"];
            $TotalCreditos=$TotalDebitos+$DatosLibro["Credito"];
            
            
            
        }
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[5].$f,"TOTALES:")
            ->setCellValue($this->Campos[6].$f,$TotalDebitos)
            ->setCellValue($this->Campos[7].$f,$TotalCreditos)
            ->setCellValue($this->Campos[8].$f,"DIFERENCIA:")
            ->setCellValue($this->Campos[9].$f,$TotalDebitos-$TotalCreditos)
                     
            ;
        
        $objPHPExcel->
        getProperties()
            ->setCreator("www.technosoluciones.com.co")
            ->setLastModifiedBy("www.technosoluciones.com.co")
            ->setTitle("Relacion de Facturas")
            ->setSubject("Informe")
            ->setDescription("Documento generado con PHPExcel")
            ->setKeywords("techno soluciones sas")
            ->setCategory("Relacion de Facturas");    

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Relacion_Facturas_Cobro".'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit; 
    
    }
    
    /**
     * Fin Clase
     */
}
