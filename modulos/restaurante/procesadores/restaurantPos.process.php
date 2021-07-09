<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/restaurantPos.class.php");
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
            $idPedido=$obCon->CrearPedido($idMesa, 1, "CLIENTES VARIOS", "", "", $Observaciones, $idUser, 1);
            $obCon->ActualizaRegistro("restaurante_mesas", "Estado", 1, "ID", $idMesa);
            print("OK;Pedido $idPedido, creado;$idPedido");            
            
        break; 
        
        case 2: //Agrega producto a pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]); 
            $idProducto=$obCon->normalizar($_REQUEST["idProducto"]);             
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]); 
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            if($idPedido=="" or $idPedido==0){
                exit("E1;No se ha seleccionado un pedido");
            }
            if($idProducto=="" or $idProducto==0){
                exit("E1;El campo Codigo no puede estar vacío");
            }
            if(!is_numeric($Cantidad) or $Cantidad<=0){
                exit("E1;La cantidad debe ser un numero mayor a cero");
            }
            
            $DatosValidacion=$obCon->DevuelveValores("productos_has_complementos", "idProducto", $idProducto);
            if($DatosValidacion["ID"]>0){
                exit("E2;Agregue Complementos");
            }
            $obCon->AgregueProductoAPedido($idPedido,$Cantidad, $idProducto, $Observaciones, $idUser, "");
            $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            if($DatosPedido["Estado"]<>'1' AND $DatosPedido["Estado"]<>'3'){
                $obCon->ActualizaRegistro("restaurante_pedidos", "Estado", 3, "ID", $idPedido);
            }
            print("OK;Producto Agregado");
            
        break; //fin caso 2
        
        case 3: //Imprime un pedido
            
            $obPrint=new PrintPos($idUser);
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido=='' or $idPedido==0){
                exit("E1;Debe seleccionar un pedido");
            }
            $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            if($DatosPedido["Tipo"]==1){//Imprime pedido mesa
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 10);
                $obCon->imprime_pedido_restaurante($idPedido,"",$DatosConfiguracion["Valor"],"");
            }
            if($DatosPedido["Tipo"]==2 or $DatosPedido["Tipo"]==3){//Imprime un domicilio o un para llevar
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 10);
                $obPrint->ImprimeDomicilioRestaurante($idPedido, "", $DatosConfiguracion["Valor"], "");
                
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
        
        case 5: //Realiza la factura
            
            $obPrint=new PrintPos($idUser);
            $fecha=date("Y-m-d");
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            if($DatosCaja["ID"]==''){
                exit("E1;Usted no tiene una caja Asignada");
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            if($idCliente==""){
                $idCliente=1;
            }
            $idColaborador=$obCon->normalizar($_REQUEST["CmbColaboradores"]);
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            $Efectivo=$obCon->normalizar($_REQUEST["TxtEfectivo"]);
            $PropinaEfectivo=$obCon->normalizar($_REQUEST["TxtPropinaEfectivo"]);
            $PropinaTarjetas=$obCon->normalizar($_REQUEST["TxtPropinaTarjetas"]);
            $sql="SELECT SUM(Subtotal) as Subtotal, SUM(IVA) as IVA,SUM(Total) as Total,SUM(TotalCostos) as TotalCostos FROM restaurante_pedidos_items WHERE idPedido='$idPedido'";
            $Consulta=$obCon->Query($sql);
            $TotalesPedido=$obCon->FetchAssoc($Consulta);
            
            $Print="S";
            if($Efectivo=="NA"){
                //$DatosVistaPedido=$obCon->DevuelveValores("vista_pedidos_restaurante", "ID", $idPedido);
                $Efectivo=$TotalesPedido["Total"];
                $Print="N";
            }
            if($TotalesPedido["Total"]==0){
                exit("E1;El pedido no puede estar vacío");
            }
            $Cheque=$obCon->normalizar($_REQUEST["TxtCheques"]);
            $Tarjeta=$obCon->normalizar($_REQUEST["TxtTarjetas"]);
            
            $OtrosPaga=$obCon->normalizar($_REQUEST["TxtBonos"]);
            $Devuelta=$obCon->normalizar($_REQUEST["TxtDevuelta"]);
            $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
            $TipoPago=$obCon->normalizar($_REQUEST["CmbTipoPago"]);
            $Observaciones="";
            if(isset($_REQUEST["TxtObservaciones"])){
                $Observaciones=$obCon->normalizar($_REQUEST["TxtObservaciones"]);
            }
            
            
            $DatosVentaRapida["PagaCheque"]=$Cheque;
            $DatosVentaRapida["PagaTarjeta"]=$Tarjeta;
            $DatosVentaRapida["idTarjeta"]=1;
            $DatosVentaRapida["PagaOtros"]=$OtrosPaga;
            
            $DatosVentaRapida["CentroCostos"]=$DatosCaja["CentroCostos"];
            $DatosVentaRapida["ResolucionDian"]=$DatosCaja["idResolucionDian"];
            $DatosVentaRapida["idEmpresa"]=$DatosCaja["idEmpresa"];
            $DatosVentaRapida["Observaciones"]=$Observaciones;
            
            if($TipoPago<>"Contado" AND $idCliente<=1){
                
                exit("E1;Para poder hacer una venta a credito se debe seleccionar un cliente");
            }
            $SaldoFactura=0;
            if($TipoPago<>"Contado"){
                $Efectivo=0;
                $DatosVentaRapida["PagaCheque"]=0;
                $DatosVentaRapida["PagaTarjeta"]=0;
                $DatosVentaRapida["idTarjeta"]=0;
                $DatosVentaRapida["PagaOtros"]=0;
                $SaldoFactura= $TotalesPedido["Total"];
            }
            $idFactura=$obCon->idFactura();
            $NumFactura=$obCon->CrearFactura($idFactura, $fecha, date("H:i:s"), $DatosCaja["idResolucionDian"], "", "", $TipoPago, $TotalesPedido["Subtotal"], $TotalesPedido["IVA"], $TotalesPedido["Total"], 0, $SaldoFactura, $idPedido, $DatosCaja["idEmpresa"], $DatosCaja["CentroCostos"], $DatosCaja["idSucursal"], $idUser, $idCliente, $TotalesPedido["TotalCostos"], $Observaciones, $Efectivo, $Devuelta, $Cheque, $OtrosPaga, $Tarjeta, 1, 1, "");
            if($NumFactura=="E1"){
                exit("E1;La resolucion está completa");
            }
            
            if($NumFactura=="E2"){
                exit("E1;La resolucion está ocupada");
            }
            
            $Datos["idPedido"]=$idPedido;
            $Datos["NumFactura"]=$NumFactura;
            $Datos["FechaFactura"]=$fecha;
            $Datos["ID"]=$idFactura;
            $Datos["CuentaDestino"]=$CuentaDestino;
            $Datos["EmpresaPro"]=$DatosCaja["idEmpresa"];
            $Datos["CentroCostos"]=$DatosCaja["CentroCostos"];
            $obCon->InsertarItemsPedidoAItemsFactura($Datos,$idUser);///Relaciono los items de la factura
                
            if($TipoPago=='Contado'){
                $DatosCuenta=$obCon->DevuelveValores("subcuentas", "PUC", $CuentaDestino);                
                //$NombreCuentaDestino=$DatosCuenta["Nombre"];
            }else{
                $DatosCuenta=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Cuenta Clientes
                $CuentaDestino=$DatosCuenta["CuentaPUC"];
                //$NombreCuentaDestino=$DatosCuenta["NombreCuenta"];
            }
            
            $obCon->InsertarFacturaLibroDiarioV2($idFactura,$CuentaDestino,$idUser); 
            $obCon->DescargueFacturaInventariosV2($idFactura, "");
            
            if($TipoPago=='SisteCredito' or $TipoPago=='KUPY'){
                if($TipoPago=='SisteCredito'){
                    $idPlataforma=1;
                }
                if($TipoPago=='KUPY'){
                    $idPlataforma=2;
                }
                $obCon->PlataformasPagoVentas($idPlataforma,$fecha,$Hora,$DatosCliente["Num_Identificacion"],$idFactura,$Total,$idUser);
            }
            if($idColaborador>0){
                $obCon->AgregueVentaColaborador($idFactura,$idColaborador);
            }
            
            //$idFactura=$obCon->RegistreVentaRestaurante($idPedido, $idCliente, $TipoPago, $Efectivo, $Devuelta, $CuentaDestino,$idUser, $DatosVentaRapida);
            $Estado=2; //Cambia el estado de Abierto a Cerrado o facturado
            
            $obCon->ActualizaRegistro("restaurante_pedidos", "Estado", $Estado, "ID", $idPedido);
            $obCon->ActualizaRegistro("restaurante_pedidos_items", "Estado", $Estado, "idPedido", $idPedido);
            $obCon->ActualizaRegistro("restaurante_mesas", "Estado", "", "ID", $DatosPedido["idMesa"]);
            
            if($PropinaEfectivo>0 or $PropinaTarjetas>0){
                $obCon->PropinasRegistro($CuentaDestino,$idFactura,$idColaborador,$PropinaEfectivo,$PropinaTarjetas,"");
            }
            $Total=$TotalesPedido["Total"];
            $obCon->RestauranteRegistreVentaUsuario($idFactura, $DatosPedido["idUsuario"],$Total);
            if($Print=="S"){
                $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
                if($DatosImpresora["Habilitado"]=="SI"){
                    $DatosGenerales=$obCon->DevuelveValores("configuracion_general", "ID", 2);//Saber si se imprime una factura pos
                    
                    if($DatosGenerales["Valor"]==1){
                        $obPrint->ImprimeFacturaPOS($idFactura,$DatosImpresora["Puerto"],1);
                    }else{
                        $obPrint->AbreCajon("");
                    }
                    
                    $DatosTikete=$obCon->DevuelveValores("config_tiketes_promocion", "ID", 1);
                    if($Total>=$DatosTikete["Tope"] AND $DatosTikete["Activo"]=="SI"){
                        $VectorTiket["F"]=0;
                        $Copias=1;
                        if($DatosTikete["Multiple"]=="SI"){
                            $Copias=floor($Total/$DatosTikete["Tope"]);
                        }
                        $obPrint->ImprimirTiketePromo($idFactura,$DatosTikete["NombreTiket"],$DatosImpresora["Puerto"],$Copias,$VectorTiket);
                    }
                }
            }
            
            $LinkFactura="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID=$idFactura";
            $Mensaje="<br><strong>Factura $NumFactura Creada Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
            $Mensaje.="<br><h3>Devuelta: ".number_format($Devuelta)."</h3>";
            
            
            print("OK;$Mensaje");
            
        break; //Fin caso 5
        
        case 6: //Eliminar Item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $obCon->BorraReg("restaurante_pedidos_items", "ID", $idItem);
            print("OK;Item Eliminado");
        break;
    
        case 7: //Cambiar Estado a item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $Estado=$obCon->normalizar($_REQUEST["Estado"]);
            $obCon->ActualizaRegistro("restaurante_pedidos_items", "Estado", $Estado, "ID", $idItem);
            $sql="SELECT Estado FROM restaurante_pedidos_items WHERE Estado='AB' AND idPedido='$idPedido' LIMIT 1";
            $Consulta=$obCon->Query($sql);
            $EstadosPedido=$obCon->FetchAssoc($Consulta);
            if($EstadosPedido["Estado"]==""){
                $obCon->ActualizaRegistro("restaurante_pedidos", "Estado", 4, "ID", $idPedido);
            }
            print("Item Preparado");
        break;
       
        case 8: //Cambiar un pedido a estado entregado
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $obCon->ActualizaRegistro("restaurante_pedidos_items", "Estado", "EN", "idPedido", $idPedido);
            $obCon->ActualizaRegistro("restaurante_pedidos", "Estado", "6", "ID", $idPedido);
            
            print("OK;Pedido Entregado");
        break;
    
        case 9: //Cerrar turno
            
            $TxtObservaciones=$obCon->normalizar($_REQUEST["ObservacionesCierre"]);
            $EfectivoEnCaja=$obCon->normalizar($_REQUEST["EfectivoEnCaja"]);
            if(!is_numeric($EfectivoEnCaja) or  $EfectivoEnCaja<0){
                exit("E1;El campo Efectivo en caja no puede estar vacío;EfectivoEnCaja");
            }
            if($TxtObservaciones==''){
                exit("E1;El campo Observaciones no puede estar vacío;ObservacionesCierre");
            }
            $sql="SELECT COUNT(ID) AS Items FROM restaurante_pedidos WHERE Estado<>2 AND Estado<>7 AND idCierre=0";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            if($Totales["Items"]>0){
                exit("E1;No es posible cerrar el turno, hay pedidos que aún no se han facturado");
            }
            $idCierre=$obCon->CierreTurnoRestaurantePos($TxtObservaciones,$idUser,$EfectivoEnCaja);
            //$obCon->RegistreResumenCierre($idCierre, $idUser);
            $obPrint->ImprimirCierreRestaurantePos($idCierre,"",1,"");
            print("OK;Se ha Cerrado el turno $idCierre");
        break; //Fin caso 9
        
        case 10://Crear un egreso
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $obPrint = new PrintPos($idUser);
            $idProveedor=$obCon->normalizar($_REQUEST['Tercero']);
            $CuentaDestino=$obCon->normalizar($_REQUEST['CuentaPUC']);
            $Subtotal=$obCon->normalizar($_REQUEST['SubtotalEgreso']);
            $IVA=$obCon->normalizar($_REQUEST['IVAEgreso']);
            $Total=$obCon->normalizar($_REQUEST['TotalEgreso']);
            $NumFact=$obCon->normalizar($_REQUEST['TxtNumeroSoporteEgreso']);
            $Concepto=$obCon->normalizar($_REQUEST['TxtConcepto']);
            
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            if($DatosCaja["ID"]==''){
                exit("E1;No tienes una caja Asignada, por favor asignese una caja");
            }
            
            $CuentaOrigen=$DatosCaja["CuentaPUCEfectivo"];
            $CentroCostos=$DatosCaja["CentroCostos"];
            $CuentaPUCIVA=$DatosCaja["CuentaPUCIVAEgresos"];
            $TipoEgreso="Restaurante";
            $TipoPago="Contado";
            $Sanciones=0;
            $Intereses=0;
            $Impuestos=0;
            $ReteFuente=0;
            $ReteIVA=0;
            $ReteICA=0;
            $VectorEgreso["Fut"]=0;  //Uso futuro
            ///                
            
            $idEgreso=$obCon->CrearEgreso($fecha,"",$idUser,$CentroCostos,$TipoPago,$CuentaOrigen,$CuentaDestino,$CuentaPUCIVA,$idProveedor, $Concepto,$NumFact,"",$TipoEgreso,$Subtotal,$IVA,$Total,$Sanciones,$Intereses,$Impuestos,$ReteFuente,$ReteIVA,$ReteICA,$VectorEgreso);
            
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
            $VectorEgresos["Fut"]=1;
            if($DatosImpresora["Habilitado"]=="SI"){
                $Configuracion=$obCon->DevuelveValores("configuracion_general", "ID", 9); //Copias del egreso
                $obPrint->ImprimeEgresoPOS($idEgreso,$VectorEgresos,$DatosImpresora["Puerto"],$Configuracion["Valor"]);
                    
            }
            print("OK;Egreso $idEgreso Realizado");
        break;//fin caso 10
        
        case 11://Busque los datos de un cliente de domicilio
            $Telefono=$obCon->normalizar($_REQUEST["TelefonoPedido"]);
            $sql="SELECT NombreCliente,DireccionEnvio FROM restaurante_pedidos WHERE TelefonoConfirmacion='$Telefono' ORDER BY ID DESC LIMIT 1 ";
            $DatosPedido=$obCon->FetchAssoc($obCon->Query($sql));
            print("OK;$DatosPedido[NombreCliente];$DatosPedido[DireccionEnvio]");
        break;//Fin caso 11  
    
        case 12: //Crear un domicilio o un pedido para llevar
            
            $idMesa=0;
            $TipoPedido=$obCon->normalizar($_REQUEST["TipoPedido"]);
            $TelefonoPedido=$obCon->normalizar($_REQUEST["TelefonoPedido"]);
            $NombrePedido=$obCon->normalizar($_REQUEST["NombrePedido"]);
            $DireccionPedido=$obCon->normalizar($_REQUEST["DireccionPedido"]);
            $ObservacionesPedido=$obCon->normalizar($_REQUEST["ObservacionesPedido"]);
            if($TipoPedido==''){
                exit("E1;Debe seleccionar un tipo de pedido");
            }
            if($NombrePedido=='' ){
                exit("E1;Debe escribir un nombre para el pedido;NombrePedido");
            }
            if($TipoPedido==2){
                if($TelefonoPedido==''){
                    exit("E1;Debe escribir un numero telefonico;TelefonoPedido");
                }
                if($DireccionPedido==''){
                    exit("E1;Debe escribir una direccion;DireccionPedido");
                }
            }
            $Observaciones="";    
            $idPedido=$obCon->CrearPedido($idMesa, 1, $NombrePedido, $DireccionPedido, $TelefonoPedido, $ObservacionesPedido, $idUser, $TipoPedido);
            
            print("OK;Pedido $idPedido, creado;$idPedido");            
            
        break; //Fin caso 12
        
        case 13: //imprimir un cierre
            
            $idCierre=$obCon->normalizar($_REQUEST["idCierre"]);
            
            if(!is_numeric($idCierre) or  $idCierre<=0){
                exit("E1;El id del cierre debe ser un numero mayor a cero");
            }
            
            
            $obPrint->ImprimirCierreRestaurantePos($idCierre,"",1,"");
            print("OK;Se imprimió el cierre $idCierre");
        break; //Fin caso 13
        
        case 14: //Anular un pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido==''){
                exit("E1;No se recibió un pedido");
            }
            $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            $obCon->ActualizaRegistro("restaurante_mesas", "Estado", "0", "ID", $DatosPedido["idMesa"]);
            $obCon->BorraReg("restaurante_pedidos_items", "idPedido", $idPedido);
            $obCon->ActualizaRegistro("restaurante_pedidos", "Estado", "7", "ID", $idPedido);
            
            print("OK;Pedido Anulado");
        break;//Fin caso 14
        
        case 15: //Anular un pedido
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Total=$obCon->normalizar($_REQUEST["Total"]);
            
            if($idItem==''){
                exit("E1;No se recibió el item");
            }
            if(!is_numeric($Total) OR $Total<=0){
                exit("E1;El valor debe ser numerico;TxtTotal_".$idItem);
            }
            $DatosItem=$obCon->DevuelveValores("restaurante_pedidos_items", "ID", $idItem);
            
            $sql="UPDATE restaurante_pedidos_items SET Subtotal='$Total',Total='$Total' WHERE ID='$idItem'";
            $obCon->Query($sql);
            print("OK;Total editado");
        break;//Fin caso 15
        
        case 16: //Agrega producto con complementos a un pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]); 
            $idProducto=$obCon->normalizar($_REQUEST["idProducto"]);             
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]); 
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
                        
            $jsonForm= $_REQUEST["jsonComplementos"];
            parse_str($jsonForm,$DatosFormulario);
            
            //print_r($DatosFormulario);
            //exit();
            
            foreach ($DatosFormulario as $key => $value) {
                $indice= str_replace("rd_", "", $key);
                $DatosComplementos[$indice]=$obCon->normalizar($value);
                $Datositem=$obCon->DevuelveValores("productosventa_complementos_items", "ID", $DatosComplementos[$indice]);
                $Observaciones.=" || ".$Datositem["Nombre"];
            }
            
            if(!isset($DatosComplementos) or count($DatosComplementos)<1){
                exit("E1;Debe seleccionar al menos un complemento");
            }
            if($idPedido=="" or $idPedido==0){
                exit("E1;No se ha seleccionado un pedido");
            }
            if($idProducto=="" or $idProducto==0){
                exit("E1;El campo Codigo no puede estar vacío");
            }
            if(!is_numeric($Cantidad) or $Cantidad<=0){
                exit("E1;La cantidad debe ser un numero mayor a cero");
            }
            
            $pedido_item_id=$obCon->AgregueProductoAPedido($idPedido,$Cantidad, $idProducto, $Observaciones, $idUser, "");
            
            foreach ($DatosComplementos as $key => $value) {
                
                $obCon->agregarComplementoPedido($pedido_item_id,$key,$value);
            }
            
            $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            if($DatosPedido["Estado"]<>'1' AND $DatosPedido["Estado"]<>'3'){
                $obCon->ActualizaRegistro("restaurante_pedidos", "Estado", 3, "ID", $idPedido);
            }
            print("OK;Producto Agregado");
            
        break; //fin caso 16
        
        case 17: //editar un favorito
            $favorito_id=$obCon->normalizar($_REQUEST["favorito_id"]);
            $product_id_favorite=$obCon->normalizar($_REQUEST["product_id_favorite"]);
            
            if($product_id_favorite==''){
                exit("E1;No se recibió el item");
            }
            
            $sql="UPDATE restaurante_productos_favoritos SET producto_id='$product_id_favorite' WHERE ID='$favorito_id'";
            $obCon->Query($sql);
            print("OK;Favorito editado");
        break;//Fin caso 17
        
        case 18: //preparar item
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);
            
            if($item_id==''){
                exit("E1;No se recibió el item");
            }
            $obCon->preparar_item_pedido($item_id);
            print("OK;Item preparado");
        break;//Fin caso 18
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>