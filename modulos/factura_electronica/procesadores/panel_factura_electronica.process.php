<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/notas_credito.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new NotasCredito($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una nota credito
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
            $idFacturaElectronica=$obCon->normalizar($_REQUEST["idFacturaElectronica"]);
            $idItemFactura=$obCon->normalizar($_REQUEST["idItemFactura"]);
            $Cantidad=$obCon->normalizar($_REQUEST["TxtCantidad"]);
            $DatosItem=$obCon->DevuelveValores("facturas_items", "ID", $idItemFactura);
            $DatosFacturaElectronica=$obCon->DevuelveValores("vista_listado_facturas_electronicas", "ID", $idFacturaElectronica);
            if($idFacturaElectronica==''){
                exit("E1;No se recibió el id de la factura electronica");
            }
            if($idItemFactura==''){
                exit("E1;No se recibió el item de la factura a agregar en la nota credito");
            }
            if(!is_numeric($Cantidad) or $Cantidad<=0){
                exit("E1;La cantidad debe ser un valor numerico y positivo;TxtCantidad_$idItemFactura");
            }
            if($DatosItem["idFactura"]<>$DatosFacturaElectronica["idFactura"]){
                exit("E1;El item seleccionado no corresponde a la factura que se seleccionó en la nota credito");
            }
            $sql="SELECT SUM(Cantidad) as CantidadActual FROM notas_credito_items WHERE idItemFactura='$idItemFactura'";
            $CantidadActual=$obCon->FetchAssoc($obCon->Query($sql));
            
            $CantidadTotal=$Cantidad+$CantidadActual["CantidadActual"];
            if($CantidadTotal>($DatosItem["Cantidad"]*$DatosItem["Dias"])){
                exit("E1;La cantidad de este producto no puede superar la cantidad que hay en la factura;TxtCantidad_$idItemFactura");
            }
            $Respuesta=$obCon->AgregarItemANotaCredito($idFacturaElectronica,$idItemFactura,$Cantidad,$idUser);
            
            if($Respuesta=="OK"){
                exit("OK;Item agregado;$idFacturaElectronica");
            }else{
                exit("E1;".$Respuesta);
            }
            
        break;//Fin caso 2   
        
        case 3://eliminar un item a una nota credito
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $idFacturaElectronica=$obCon->normalizar($_REQUEST["idFacturaElectronica"]);
            if($idItem==''){
                exit("E1;No se recibió el item a eliminar");
            }
            
            if($Tabla==''){
                exit("E1;No se recibió la tabla para eliminar el item");
            }
            if($Tabla==1){
                $Tabla="notas_credito_items";
            }else{
                exit("E1;Tabla invalida");
            }
            $obCon->BorraReg($Tabla, "ID", $idItem);
            exit("OK;Item Eliminado;$idFacturaElectronica");
        break;//Fin caso 3
        
        case 4://Guardar una nota credito
            $idFacturaElectronica=$obCon->normalizar($_REQUEST["idFacturaElectronica"]); 
            $TxtFecha=$obCon->normalizar($_REQUEST["TxtFecha"]);
            $TxtObservaciones=$obCon->normalizar($_REQUEST["TxtObservaciones"]);
            
            if($idFacturaElectronica==''){
                exit("E1;No se recibió el id de la Factura electronica");
            }
            
            if($TxtFecha==''){
                exit("E1;Debe seleccionar una Fecha;TxtFecha");
            }
            
            if($TxtObservaciones==''){
                exit("E1;el campo observaciones no puede estar vacío;TxtObservaciones");
            }
            $sql="SELECT idFactura FROM vista_listado_facturas_electronicas WHERE ID='$idFacturaElectronica'";
            $DatosFacturaElectronica=$obCon->FetchAssoc($obCon->Query($sql));
            $idNota=$obCon->CrearNotaCredito($DatosFacturaElectronica["idFactura"],$idFacturaElectronica,$TxtFecha,$TxtObservaciones,$idUser);
            $sql="UPDATE notas_credito_items SET idNotaCredito='$idNota' WHERE idFacturaElectronica='$idFacturaElectronica' AND idNotaCredito=''";
            $obCon->Query($sql);
            $obCon->ContabilizarNotaCredito($idNota);    
            
            exit("OK;Nota Credito No. $idNota creada");
        break;//Fin caso 4    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>