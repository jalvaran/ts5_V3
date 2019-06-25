<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/pos2.class.php");
include_once("../../../modelo/PrintPos.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new VentasRestaurantePOS($idUser);
    $obPrint = new PrintPos($idUser); 
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear un pedido para una mesa
            $idMesa=$obCon->normalizar($_REQUEST["idMesa"]);
            if($idMesa=='' or $idMesa==0){
                exit("E1;Debe seleccionar una mesa");
            }
            $Observaciones="";             
            $idPedido=$obCon->CrearPedido($idMesa, 1, "CLIENTES VARIOS", "", "", $Observaciones, $idUser, "");
            $obCon->ActualizaRegistro("restaurante_mesas", "Estado", 1, "ID", $idMesa);
            print("OK;Pedido $idPedido, creado;$idPedido");            
            
        break; 
        
        case 2: //Agrega producto a pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]); 
            $idProducto=$obCon->normalizar($_REQUEST["idProducto"]);             
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]); 
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            if($idPedido==""){
                exit("E1;No hay un pedido seleccionado");
            }
            $obCon->AgregueProductoAPedido($idPedido,$Cantidad, $idProducto, $Observaciones, $idUser, "");
            print("OK;Producto Agregado");
            
        break; //fin caso 2
        
        case 3: //Imprime un pedido
            
            $obPrint=new PrintPos($idUser);
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido=='' or $idPedido=0){
                exit("E1;Debe seleccionar un pedido");
            }
            $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            if($DatosPedido["Tipo"]==1){
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 10);
                $obPrint->ImprimePedidoRestaurante($idPedido,"",$DatosConfiguracion["Valor"],"");
            }
            
            print("OK;Pedido $idPedido Impreso");
            
        break; //Fin caso 3
        
        case 4: //Imprime una precuenta
            
            $obPrint=new PrintPos($idUser);
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido=='' or $idPedido==0){
                exit("E1;Debe seleccionar un pedido");
            }
                  
            $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 11);
            $obPrint->ImprimePrecuentaRestaurante($idPedido,"",$DatosConfiguracion["Valor"],"");            
            
            print("OK;Precuenta $idPedido Impresa");
            
        break; //Fin caso 4
        
        
       
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>