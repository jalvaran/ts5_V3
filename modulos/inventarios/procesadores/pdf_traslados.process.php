<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/inventarios.class.php");
include_once("../clases/pdf_traslados.class.php");
//include("../../../modelo/PrintPos.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Inventarios($idUser);
    $obPDF = new PDF_Traslados(DB);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1://crear el pdf de un traslado
            $traslado_id=$obCon->normalizar($_REQUEST['traslado_id']);
            $obPDF->pdf_traslado($traslado_id);          
           
            $obCon->imprime_traslado($traslado_id, 1);
        break;//Fin caso 1
        
         
        
       
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>