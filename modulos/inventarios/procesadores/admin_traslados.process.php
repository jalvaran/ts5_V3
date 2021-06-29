<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/inventarios.class.php");
include_once("../clases/inventariosExcel.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Inventarios($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1://crear un traslado
            $CmbDestino=$obCon->normalizar($_REQUEST['CmbDestino']);
            $TxtDescripcion=$obCon->normalizar($_REQUEST['TxtDescripcion']);
            if($CmbDestino=='0' or $CmbDestino==""){
                exit("E1;Debe seleccionar un destino;CmbDestino");
            }
            if($TxtDescripcion==""){
                exit("E1;Debe escribir una descripcion;TxtDescripcion");
            }
            
            $datos_sucursal=$obCon->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
            $sucursal_id=$datos_sucursal["ID"];
            
            $sql="SELECT MAX(ConsecutivoInterno) as Consecutivo FROM traslados_mercancia WHERE Origen='$sucursal_id' ";
            $datos_consecutivos=$obCon->FetchAssoc($obCon->Query($sql));
            $Consecutivo=$datos_consecutivos["Consecutivo"]+1;
            $ID=$sucursal_id."-".$CmbDestino."-".$Consecutivo;
            $obCon->crear_traslado($ID, date("Y-m-d"), date("H:i:s"), $sucursal_id, $Consecutivo, $CmbDestino, $TxtDescripcion,$idUser);
            print("OK;Traslado Creado;$ID");
        break;//Fin caso 1
        
        case 2://agregar item a traslado
            $idComprobante=$obCon->normalizar($_REQUEST["traslado_id"]);
            $Cantidad=$obCon->normalizar($_REQUEST["TxtCantidad"]);
            $CodBarras=$obCon->normalizar($_REQUEST["TxtCodigo"]); 
            $producto_id=$obCon->normalizar($_REQUEST["producto_id"]); 
            
            if((!is_numeric($CodBarras) or $CodBarras<=0) and $producto_id==''){
                exit("E1;El codigo de barras debe ser un valor numerico mayor a cero");
            }
            if(!is_numeric($Cantidad) or $Cantidad<=0){
                exit("E1;La cantidad debe ser un valor numerico mayor a cero");
            }
            if($producto_id<>''){
                if(!is_numeric($producto_id) or $producto_id<=0){
                    exit("E1;El codigo del producto debe ser un valor numerico mayor a cero");
                }
                $CodBarras=$producto_id;
            }
                         
            
            $DatosProducto=$obCon->DevuelveValores("productosventa", "idProductosVenta", $CodBarras);
            
            if($DatosProducto["idProductosVenta"] <> ''){                
                $idProducto=$CodBarras;
                $obCon->agregar_item_traslado($idComprobante,$idProducto,$Cantidad,$DatosProducto);
            }else{
                $DatosCodigo=$obCon->DevuelveValores("prod_codbarras", "CodigoBarras", $CodBarras);
                if($DatosCodigo<>''){                    
                    $idProducto=$DatosCodigo["ProductosVenta_idProductosVenta"];
                    $obCon->agregar_item_traslado($idComprobante,$idProducto,$Cantidad,$DatosProducto);
                }
            }
            
            print("OK;item agregado");
              
        break;//Fin caso 2
        
        case 3://eliminar un item de un traslado
            $traslado_id=$obCon->normalizar($_REQUEST["traslado_id"]);
            $datos_traslado=$obCon->DevuelveValores("traslados_mercancia", "ID", $traslado_id);
            if($datos_traslado["Estado"]<>'EN DESARROLLO'){
                exit("E1;El item no se puede eliminar porque el traslado ya fué guardado");
            }
            $tabla_id=$obCon->normalizar($_REQUEST["tabla_id"]);
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);
            $obCon->ActualizaRegistro("traslados_items", "Deleted", date("Y-m-d H:i:s"), "ID", $item_id);
            print("OK;Item Eliminado");
            
        break;//Fin caso 3
    
        case 4://Guardar el traslado
            $traslado_id=$obCon->normalizar($_REQUEST["traslado_id"]);
            $obCon->guardar_traslado($traslado_id);
            print("OK;Traslado Guardado");
        break;//Fin caso 4
        
        case 5:// verifica si hay conexion a la base de datos del servidor general            
            
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            $base_datos=$DatosServer["DataBase"];
            $sql="SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '$base_datos' AND table_name = 'traslados_mercancia'";
            $Consulta=$obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            $datos_consulta=$obCon->FetchAssoc($Consulta);
            if($datos_consulta["count"]>='1'){
                print("OK;Conectado a la base de datos externa");
            }else{
                print("E1;Erorr al conectar a la base de datos externa");
            }
            
        break;//Fin caso 5  
        
        case 6:// Sube un traslado           
            
            $traslado_id=$obCon->normalizar($_REQUEST["traslado_id"]);
            $obCon->subir_traslado($traslado_id);
            print("OK;Traslado $traslado_id Subido");
            
        break;//Fin caso 6
        
       
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>