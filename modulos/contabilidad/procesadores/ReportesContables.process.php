<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Export_ReportesContables.class.php");
include_once("../clases/ReportesContables.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obExport = new ExportReportes($idUser);
    $obCon = new Contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crea un prestamo a un tercero
            $Opciones=$obCon->normalizar($_REQUEST["Opciones"]);
            $Encabezado=$obCon->normalizar($_REQUEST["Encabezado"]);
            $obExport->ExportarBalanceXTercerosAExcel($Opciones,$Encabezado);
            print("OKBXT");
           
        break; //fin caso 1
    
        case 2: //Calcula la base de una retencion
            $certificado_id=$obCon->normalizar($_REQUEST["certificado_id"]);
            $cuenta_puc=$obCon->normalizar($_REQUEST["cuenta_puc"]);
            $porcentaje=$obCon->normalizar($_REQUEST["porcentaje"]);
            $valor_retencion=$obCon->normalizar($_REQUEST["valor_retencion"]);
            $concepto=$obCon->normalizar($_REQUEST["concepto"]);
            if(!is_numeric($porcentaje) or $porcentaje<=0 or $porcentaje>100){
                exit("E1;El porcentaje debe ser un número mayor a cero y menor a 100");
            }
            $base=round($valor_retencion/$porcentaje*100,2);
            $obCon->agrega_retenciones_certificado($certificado_id, $cuenta_puc, $valor_retencion, $porcentaje, $base,$concepto, $idUser);
            print("OK;".number_format($base));
           
        break; //fin caso 1
    
                
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>