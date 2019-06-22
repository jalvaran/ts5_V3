<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/BajasAltas.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new BajasAltas($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una compra
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]);
            $Observaciones=$obCon->normalizar($_REQUEST["Concepto"]); 
            
            $idComprobante=$obCon->CrearComprobante($Fecha, $Observaciones, $idUser, "");
            print("OK;$idComprobante");            
            
        break; 
        
        case 2: //editar datos generales de una factura de compra
            $idComprobante=$obCon->normalizar($_REQUEST["idComprobanteActivo"]); 
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            
            $Concepto=$obCon->normalizar($_REQUEST["Concepto"]); 
            
            $obCon->ActualizaRegistro("inventario_comprobante_movimientos", "Fecha", $Fecha, "ID", $idComprobante,0);
            
            $obCon->ActualizaRegistro("inventario_comprobante_movimientos", "Observaciones", $Concepto, "ID", $idComprobante,0);
            
            print("OK;$Fecha,$Concepto");
            
        break; 
        case 3://Agregar un item
            
            $idComprobante=$obCon->normalizar($_REQUEST["idComprobante"]); 
            $CmbListado=$obCon->normalizar($_REQUEST["CmbListado"]); 
            $idProducto=$obCon->normalizar($_REQUEST["CmbBusquedas"]);             
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]); 
            $TipoMovimiento=$obCon->normalizar($_REQUEST["TipoMovimiento"]); 
            $TablaOrigen="";
            if($CmbListado==1){
                $TablaOrigen="productosventa";
            }
            if($CmbListado==2){
                $TablaOrigen="insumos";
            }
            if($TipoMovimiento==1){
                $TipoMovimiento="BAJA";
            }
            if($TipoMovimiento==2){
                $TipoMovimiento="ALTA";
            }
            $obCon->AgregarItem($idComprobante,$idProducto, $TablaOrigen, $Cantidad, $TipoMovimiento, "");
            print("OK");
            
        break;//Fin caso 3
        
        case 4://Se elimina un item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            if($Tabla==1){
                $Tabla="inventario_comprobante_movimientos_items";
            }
            
            $obCon->BorraReg($Tabla, "ID", $idItem);
            print("Item Eliminado");
        break;//Fin caso 4
        
        case 5://Se registran los movimientos del comprobante
            $idComprobante=$obCon->normalizar($_REQUEST["idComprobante"]);
            
            $DatosComprobante=$obCon->DevuelveValores("inventario_comprobante_movimientos", "ID", $idComprobante);
            if($DatosComprobante["Estado"]=='CERRADO'){
                exit("E1;El comprobante $idComprobante ya está Cerrado");
            }
            $NumItems=$obCon->Count("inventario_comprobante_movimientos_items", "ID", "WHERE idComprobante='$idComprobante'");
            if($NumItems==0 or $NumItems==""){
                exit("E1;El comprobante $idComprobante No tiene Items, debe agregar items para poder guardarlo");
            }
            $obCon->RealizarMovimientosInventario($idComprobante, $idUser);
            
            print("OK;Comprobante Ingresado al Kardex");
        break;//Fin caso 5
        
        case 6://Se Cierra el comprobante
            $idComprobante=$obCon->normalizar($_REQUEST["idComprobante"]);
            $obCon->ActualizaRegistro("inventario_comprobante_movimientos", "Estado", "CERRADO", "ID", $idComprobante);
            $Ruta="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=25&idComprobante=$idComprobante";
            $Link="<a href='$Ruta' target='_BLANK'> Imprimir </a>";
            print("OK;Comprobante $idComprobante Cerrado, $Link");
        break;    
        
       
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>