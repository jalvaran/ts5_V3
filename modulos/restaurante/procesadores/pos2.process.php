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
            if($idPedido=='' or $idPedido==0){
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
            if($Print=="S"){
                $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
                if($DatosImpresora["Habilitado"]=="SI"){
                    $obPrint->ImprimeFacturaPOS($idFactura,$DatosImpresora["Puerto"],1);
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
        
        
       
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>