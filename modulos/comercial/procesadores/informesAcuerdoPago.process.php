<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/AcuerdoPago.class.php");
include_once("../clases/informesAcuerdosPago.class.php");
include_once("../clases/AcuerdoPagoExcel.class.php");
//include_once("../clases/AcuerdoPago.print.class.php");
//include_once("../../../general/clases/contabilidad.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new informesAcuerdoPago($idUser);
    $obExcel=new ExcelAcuerdoPago($idUser);
    //$obPrint=new AcuerdoPagoPrint($idUser);
    //$obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Construir la hoja de trabajo de los informes
            $FechaFinal= $obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $obCon->ConstruirHojaDeTrabajoAcuerdo($FechaFinal);
            print("OK;Hoja de trabajo construida");
        break; //fin caso 1
        
        case 2://Genere el excel con el informe de cuentas x cobrar
            $Condicion= base64_decode($_REQUEST["c"]);
            $FechaInicialRangos= $obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos= $obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $obExcel->HojaDeTrabajoAcuerdosExcel($Condicion,$FechaInicialRangos,$FechaFinalRangos);
            print("OK;Hoja Exportada");
        break;//fin caso 2    
        
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
