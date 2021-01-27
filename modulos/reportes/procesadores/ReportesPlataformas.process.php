<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

//include_once("../clases/DocumentosContables.class.php");
include_once("../../../general/clases/contabilidad.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Contabilidad($idUser);
    //$obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Anular un abono
            $abono_id=$obCon->normalizar($_REQUEST["abono_id"]);             
            $datos_abono=$obCon->DevuelveValores("comercial_plataformas_pago_ingresos", "ID", $abono_id);
            $obCon->AnularMovimientoLibroDiario("ComprobanteIngreso", $datos_abono["idComprobanteIngreso"], "");
            $fecha=date("Y-m-d H:i:s");
            $sql="UPDATE comercial_plataformas_pago_ingresos SET valor_anulado=Valor,Valor=0,usuario_anulacion='$idUser', fecha_anulacion='$fecha' WHERE ID='$abono_id'";
            $obCon->Query($sql);
            print("OK;Abono Anulado");
        break; //Fin caso 1
    
        
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>