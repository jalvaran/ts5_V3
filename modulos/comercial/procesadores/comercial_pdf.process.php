<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/Facturacion.class.php");
include_once("../clases/PDF_Comercial.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Facturacion($idUser);
    $obPDF = new PDF_Comercial($db);
    switch ($_REQUEST["Accion"]) {
        
        case 1://imprima el pdf de un cierre de turno
            
            $cierre_id=$obCon->normalizar($_REQUEST["cierre_id"]); 
            $obPDF->PDF_cierre_turno($cierre_id);
                                   
        break;//Fin caso 1
               
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
