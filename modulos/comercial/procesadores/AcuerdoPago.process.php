<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/AcuerdoPago.class.php");
include_once("../clases/AcuerdoPago.print.class.php");

include_once("../../../general/clases/contabilidad.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new AcuerdoPago($idUser);
    $obPrint=new AcuerdoPagoPrint($idUser);
    $obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Imprimir acuerdo de pago
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
                
            $obPrint->PrintAcuerdoPago($idAcuerdo, 1, 0);
            
        break; //fin caso 1
        
             
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
