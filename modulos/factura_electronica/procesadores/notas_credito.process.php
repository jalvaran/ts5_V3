<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/notas_credito.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new NotasCredito($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear un ticket
            $idFactura=$obCon->normalizar($_REQUEST["idFactura"]); 
            $TxtFecha=$obCon->normalizar($_REQUEST["TxtFecha"]);
            $TxtObservaciones=$obCon->normalizar($_REQUEST["TxtObservaciones"]);
            
            if($idFactura==''){
                exit("E1;Debe seleccionar una factura;select2-cmbIdFactura-container");
            }
            
            if($TxtFecha==''){
                exit("E1;Debe seleccionar una prioridad;TxtFecha");
            }
            
            if($TxtObservaciones==''){
                exit("E1;el campo observaciones no puede estar vacío;TxtObservaciones");
            }
            
            $idNota=$obCon->CrearNotaCredito($idFactura,$TxtFecha,$TxtObservaciones,$idUser);
            
            print("OK;Nota $idNota Creada;$idNota");          
            
        break; //fin caso 1
        
        case 2://Agregar un item a una nota credito
            $idNota=$obCon->normalizar($_REQUEST["idNota"]);
            $idItemFactura=$obCon->normalizar($_REQUEST["idItemFactura"]);
            $Cantidad=$obCon->normalizar($_REQUEST["TxtCantidad"]);
            $DatosItem=$obCon->DevuelveValores("facturas_items", "ID", $idItemFactura);
            $DatosNota=$obCon->DevuelveValores("notas_credito", "ID", $idNota);
            if($idNota==''){
                exit("E1;No se recibió el numero de la nota credito");
            }
            if($idItemFactura==''){
                exit("E1;No se recibió el item de la factura a agregar en la nota credito");
            }
            if(!is_numeric($Cantidad) or $Cantidad<=0){
                exit("E1;La cantidad debe ser un valor numerico y positivo;TxtCantidad_$idItemFactura");
            }
            if($DatosItem["idFactura"]<>$DatosNota["idFactura"]){
                exit("E1;El item seleccionado no corresponde a la factura que se seleccionó en la nota credito");
            }
            $sql="SELECT SUM(Cantidad) as CantidadActual FROM notas_credito_items WHERE idNotaCredito='$idNota' AND idItemFactura='$idItemFactura'";
            $CantidadActual=$obCon->FetchAssoc($obCon->Query($sql));
            
            $CantidadTotal=$Cantidad+$CantidadActual["CantidadActual"];
            if($CantidadTotal>$DatosItem["Cantidad"]){
                exit("E1;La cantidad de este producto no puede superar la cantidad que hay en la factura;TxtCantidad_$idItemFactura");
            }
            $Respuesta=$obCon->AgregarItemANotaCredito($idNota,$idItemFactura,$Cantidad,$idUser);
            
            if($Respuesta=="OK"){
                exit("OK;Item agregado;$idNota");
            }else{
                exit("E1;".$Respuesta);
            }
            
        break;//Fin caso 2    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>