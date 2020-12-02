<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/Facturacion.class.php");
include_once("../../../modelo/PrintPos.php");
include_once("../clases/AcuerdoPago.class.php");
include_once("../clases/AcuerdoPago.print.class.php");

include_once("../../../general/clases/contabilidad.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Facturacion($idUser);
    $obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una preventa
            //Verifico primero que no tenga mas de 3 preventas creadas
            $sql="SELECT COUNT(*) as Total FROM vestasactivas WHERE Usuario_idUsuario='$idUser'";
            $Consulta=$obCon->Query($sql);
            $CantidadPreventas=$obCon->FetchAssoc($Consulta);
            if($CantidadPreventas["Total"]>=3){
                print("E1;");//Preventas Máximas permitidas
                exit();
            }
            $DatosUsuario=$obCon->ValorActual("usuarios", "Nombre,Apellido", " idUsuarios='$idUser'");
            $TextoPreventa="Venta por: ".$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"];
            $idPreventa=$obCon->CrearPreventaPOS($idUser,$TextoPreventa);
            print("OK;$idPreventa;$TextoPreventa");            
            
        break; 
        
        
        case 2://Agregar un producto para la venta
            
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]); 
            $CmbListado=$obCon->normalizar($_REQUEST["CmbListado"]); 
            $Codigo=$obCon->normalizar($_REQUEST["Codigo"]); 
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]); 
            $Comando=strtolower(substr($Codigo, 0,1));
            if($Comando=="s"){
                $CmbListado=4; //Para que tome el sistema
            }
            if($CmbListado==1 or $CmbListado==5){
                $TablaItem="productosventa";
                $idProducto=$obCon->ObtenerIdProducto($Codigo);
                if($idProducto==''){
                    print("E1;El producto no existe en la base de datos, por favor no lo entregue"); //El producto no existe en la base de datos
                    exit();
                }
                $DatosProducto=$obCon->ValorActual("productosventa", "PrecioVenta", "idProductosVenta='$idProducto'");
                $DatosImpuestosAdicionales=$obCon->DevuelveValores("productos_impuestos_adicionales", "idProducto", $idProducto);
                if($DatosProducto["PrecioVenta"]<=0 and $DatosImpuestosAdicionales["ValorImpuesto"]==''){
                    print("E1;Este Producto no tiene precio por favor no lo entregue"); //El producto no tiene precio de venta
                    exit();
                }
                $obCon->POS_AgregaItemPreventa($idProducto, $TablaItem, $Cantidad, $idPreventa);
                print("OK;Item $idProducto Agregado");
                exit();
            }
            if($CmbListado==2){
                $TablaItem="servicios";
                $DatosProducto=$obCon->ValorActual($TablaItem, "PrecioVenta", "idProductosVenta='$Codigo'");
                if($DatosProducto["PrecioVenta"]==''){
                    print("E1;El Servicio $Codigo no Existe");
                    exit();
                }
                
                if($DatosProducto["PrecioVenta"]<=0){
                    print("E1;El precio de venta del Servicio $Codigo es menor o igual a Cero");
                    exit();
                }
                $obCon->POS_AgregaItemPreventa($Codigo, $TablaItem, $Cantidad, $idPreventa);
                print("OK;Servicio $Codigo Agregado");
                exit();
            }
            if($CmbListado==3){
                $TablaItem="productosalquiler";
                $DatosProducto=$obCon->ValorActual($TablaItem, "PrecioVenta", "idProductosVenta='$Codigo'");
                if($DatosProducto["PrecioVenta"]==''){
                    print("E1;El Producto para alquilar $Codigo no Existe");
                    exit();
                }
                
                if($DatosProducto["PrecioVenta"]<=0){
                    print("E1;El precio de venta del Producto para alquilar $Codigo es menor o igual a Cero");
                    exit();
                }
                $obCon->POS_AgregaItemPreventa($Codigo, $TablaItem, $Cantidad, $idPreventa);
                print("OK;Producto para alquilar $Codigo Agregado");
                exit();
                
            }
            if($CmbListado==4){
                $TablaItem="sistemas";
                $Codigo= lcfirst($Codigo);   //Convierte el primer caracter en minusculas
                $idSistema=str_replace("s", '', $Codigo);
                $DatosProducto=$obCon->ValorActual($TablaItem, "Nombre", "ID='$idSistema'");
                if($DatosProducto["Nombre"]==''){
                    print("E1;El sistema $Codigo no Existe");
                    exit();
                }
                
                $obCon->POS_AgregueSistemaPreventa($idPreventa,$idSistema, $Cantidad, "");
                print("OK;Sitema $idSistema Agregado");
                exit();
            }
            
                       
        break;//Fin caso 2
        
        
        case 3://Se elimina un item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Tabla="preventa";
            $DatosPreventa=$obCon->DevuelveValores("preventa", "idPrecotizacion", $idItem);
            $DatoGenerales=$obCon->DevuelveValores("configuracion_general", "ID", 4); //Determina si se debe pedir autoirzacion para retornar un item
            if($DatoGenerales["Valor"]>0){ //Si está en 1 pedirá autorización
                if($DatosPreventa["Autorizado"]=='0'){
                    print("E1;Esta acción requiere autorización");
                    exit();
                }
            }
            
            $obCon->BorraReg($Tabla, "idPrecotizacion", $idItem);
            print("OK;Item Eliminado");
        break;//Fin caso 3
        
        
        case 4://Edita una cantidad
             
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);            
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            if($Cantidad==0){
                print("E1;No se puede editar la cantidad en cero");
                exit();
            }
            
            $DatosPreventa=$obCon->DevuelveValores("preventa", "idPrecotizacion", $idItem);
            $DatoGenerales=$obCon->DevuelveValores("configuracion_general", "ID", 3); //Determina si se debe pedir autoirzacion para retornar un item
            if($DatoGenerales["Valor"]>0){ //Si está en 1 pedirá autorización
                if($DatosPreventa["Autorizado"]=='0' and $Cantidad<0){
                    print("E1;Esta acción requiere autorización");
                    exit();
                }
            }
            $ValorAcordado=$DatosPreventa["ValorAcordado"];
            $idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
            $Tabla=$DatosPreventa["TablaItem"];
            $Subtotal=$ValorAcordado*$Cantidad;
            $DatosProductos=$obCon->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
            $DatosImpuestosAdicionales=$obCon->DevuelveValores("productos_impuestos_adicionales", "idProducto", $idProducto);
            $IVA=$Subtotal*$DatosProductos["IVA"]+($DatosImpuestosAdicionales["ValorImpuesto"]*$Cantidad);
            $SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
            $Total=$Subtotal+$IVA;
            $filtro="idPrecotizacion";

            $obCon->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
            $obCon->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
            $obCon->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
            $obCon->ActualizaRegistro("preventa","Cantidad", $Cantidad, $filtro, $idItem);
           
            $Mensaje="Item Editado";
            print("OK;$Mensaje");
            
        break;//Fin caso 4
        
        case 5:// Editar el precio de venta de un item
            $idItem=$obCon->normalizar($_REQUEST['idItem']);            
            $ValorAcordado=$obCon->normalizar($_REQUEST["PrecioVenta"]);
            $Mayorista=$obCon->normalizar($_REQUEST["Mayorista"]);
            if($ValorAcordado<=0){
                print("OK;El Valor del producto debe ser mayor a cero");
                exit();
            }
            
            $DatosPreventa=$obCon->DevuelveValores("preventa", "idPrecotizacion", $idItem);
            $DatoGenerales=$obCon->DevuelveValores("configuracion_general", "ID", 5); //Determina si se debe pedir autoirzacion para retornar un item
            if($DatoGenerales["Valor"]>0){ //Si está en 1 pedirá autorización
                if($DatosPreventa["Autorizado"]=='0'){
                    print("E1;Esta acción requiere autorización");
                    exit();
                }
            }
            
            $obCon->POS_EditarPrecio($idItem,$ValorAcordado, $Mayorista);
            
            print("OK;Valor Editado");
        break;//Fin caso 5
        
                
        case 6://Obtiene los datos de la bascula
            
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            $idBascula=$DatosCaja["idBascula"];
            if($idBascula==''){
                print("E1;Usted no tiene una Caja Asignada");//No tiene caja asignada
                exit();
            }
            if($idBascula==0){
                print("E1;Usted No tiene una báscula asignada");//No tiene bascula asignada
                exit();
            }
            $DatosBascula=$obCon->DevuelveValores("registro_basculas", "idBascula", $idBascula);
            if($DatosBascula["Gramos"]==''){
                print("E1;No hay registros de la bascula");//No tiene bascula asignada
                exit();
            }
            
            print("OK;".$DatosBascula["Gramos"]); //Devuelve el dato registrado por la bascula en la base de datos
            
        break;//Fin caso 13
        
        case 7: //Guarda la factura
            $obPrint = new PrintPos($idUser);
            
            $obFactura = new Facturacion($idUser);
            $obAcuerdo = new AcuerdoPago($idUser);
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);       
            $Fecha=date("Y-m-d");
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            $idCentroCostos=$DatosCaja["CentroCostos"];
            $CmbResolucion=$DatosCaja["idResolucionDian"];
            $CmbFormaPago=$obCon->normalizar($_REQUEST["CmbFormaPago"]);
            $CmbFrecuente="NO";
            $CmbCuentaIngresoFactura=$DatosCaja["CuentaPUCEfectivo"];
            $CmbColaboradores=$obCon->normalizar($_REQUEST["CmbColaboradores"]);
            $Observaciones=$obCon->normalizar($_REQUEST["TxtObservacionesFactura"]);
            $AnticiposCruzados=$obCon->normalizar($_REQUEST["AnticiposCruzados"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $idEmpresa=$DatosCaja["idEmpresa"];
            $idSucursal=$DatosCaja["idSucursal"];
            $Devuelta=0;
            $Efectivo=0;
            $Cheques=0;
            $Otros=0;
            $Tarjetas=0;
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            $Tercero=$DatosCliente["Num_Identificacion"];
            if($CmbFormaPago=="Contado"){
                $Devuelta=$obCon->normalizar($_REQUEST["Devuelta"]);
                $Efectivo=$obCon->normalizar($_REQUEST["Efectivo"]);
                $Cheques=$obCon->normalizar($_REQUEST["Cheque"]);
                $Otros=$obCon->normalizar($_REQUEST["Otros"]);
                $Tarjetas=$obCon->normalizar($_REQUEST["Tarjetas"]);
            }
            $CmbPrint=$obCon->normalizar($_REQUEST["CmbPrint"]);
            $idCajero=$obCon->normalizar($_REQUEST["idCajero"]);
            $OrdenCompra=$obCon->normalizar($_REQUEST["orden_compra"]);
            $TxtCuotaInicialCredito=$obCon->normalizar($_REQUEST["TxtCuotaInicialCredito"]);
            
            if($idCajero<>$idUser){
                print("Se ha iniciado sesion por un usario diferente al cajero actual, por favor inicie sesion nuevamente");
                exit();
            }
            $FormaPagoFactura=$CmbFormaPago;
            if(is_numeric($FormaPagoFactura)){
                $FormaPagoFactura="Credito a $CmbFormaPago dias";
            }
            
            if($CmbFormaPago=="Acuerdo"){
                $obAcuerdo->ValidarDatosCreacionAcuerdoPagoPOS($_REQUEST);
            }
            
            $Hora=date("H:i:s");
            
            $sql="SELECT count(*) totalItems,SUM(ValorAcordado) AS Subtotal, SUM(Impuestos) AS IVA, SUM(TotalVenta) as Total,SUM(CostoUnitario*Cantidad) AS TotalCostos "
                    . "FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
            $Consulta=$obCon->Query($sql);
            $DatosTotalesCotizacion=$obCon->FetchAssoc($Consulta);
            if($DatosTotalesCotizacion["totalItems"]<=0){
                exit("E4;La factura no tiene items agregados");
            }
            $Subtotal=round($DatosTotalesCotizacion["Subtotal"],2);
            $IVA=round($DatosTotalesCotizacion["IVA"],2);
            $Total=round($DatosTotalesCotizacion["Total"],2);
            $TotalCostos=$DatosTotalesCotizacion["TotalCostos"];
            $SaldoFactura=$Total;
            if($TxtCuotaInicialCredito>abs($SaldoFactura)){
                exit("E4; El valor de la cuota inicial no puede ser superior al valor de la factura;");
            }
            if($TxtCuotaInicialCredito<>'' and $TxtCuotaInicialCredito<>'0'){
                if(!is_numeric($TxtCuotaInicialCredito) or $TxtCuotaInicialCredito<0){
                    exit("E4; El valor de la cuota inicial debe ser un numero mayor a cero;");
                }
            }
            $Descuentos=0;
            
            if($AnticiposCruzados>0){
                            
                $NIT=$DatosCliente["Num_Identificacion"];
                $ParametrosAnticipos=$obCon->DevuelveValores("parametros_contables", "ID", 20);//Aqui se encuentra la cuenta para los anticipos
                $CuentaAnticipos=$ParametrosAnticipos["CuentaPUC"];
                $sql="SELECT SUM(Debito) as Debito, SUM(Credito) AS Credito FROM librodiario WHERE CuentaPUC='$CuentaAnticipos' AND Tercero_Identificacion='$NIT'";
                $Consulta=$obCon->Query($sql);
                $DatosAnticipos=$obCon->FetchAssoc($Consulta);
                $SaldoAnticiposTercero=$DatosAnticipos["Credito"]-$DatosAnticipos["Debito"];
                
                if($SaldoAnticiposTercero<$AnticiposCruzados){
                    $Mensaje="El Cliente no cuenta con el anticipo registrado";
                    print("E3;$Mensaje");
                    exit();
                }
                
            }
            
            if($FormaPagoFactura<>'Contado' and $idCliente<=1){
                print("E5;No se puede crear una factura tipo $FormaPagoFactura asignada al cliente $idCliente");
                    exit();
            }
            
            if($FormaPagoFactura<>'Contado'){
                $NitCliente=$DatosCliente["Num_Identificacion"];
                $sql="SELECT SUM(t1.Neto) as TotalCredito FROM librodiario t1 
                        WHERE Tercero_Identificacion='$NitCliente' 
                        AND EXISTS(SELECT 1 FROM contabilidad_parametros_cuentasxcobrar t2 WHERE t2.CuentaPUC like t1.CuentaPUC)";
                $DatosTotalCreditoCliente=$obCon->FetchAssoc($obCon->Query($sql));
                $SaldoNuevoCliente=$DatosTotalCreditoCliente["TotalCredito"]+$Total;
                if($DatosCliente["Cupo"]<$SaldoNuevoCliente AND $FormaPagoFactura=='Credito'){
                    exit("E4;El cupo del cliente no es suficiente para realizar la factura");
                }
            }
            
            $idFactura=$obFactura->idFactura();
                        
            $NumFactura=$obFactura->CrearFactura($idFactura, $Fecha, $Hora, $CmbResolucion, $OrdenCompra, "", $FormaPagoFactura, $Subtotal, $IVA, $Total, $Descuentos, $SaldoFactura, "", $idEmpresa, $idCentroCostos, $idSucursal, $idUser, $idCliente, $TotalCostos, $Observaciones, $Efectivo, $Devuelta, $Cheques, $Otros, $Tarjetas, 0, 0, "");
            if($NumFactura=="E1"){
                $Mensaje="La Resolucion está completa";
                print("E1;$Mensaje");
                exit();
            }
            if($NumFactura=="E2"){
                $Mensaje="La Resolucion está ocupada, intentelo nuevamente";
                print("E2;$Mensaje");
                exit();
            }
            
            $Datos["idPreventa"]=$idPreventa;
            $Datos["NumFactura"]=$NumFactura;
            $Datos["FechaFactura"]=$Fecha;
            $Datos["ID"]=$idFactura;
            $Datos["CuentaDestino"]=$CmbCuentaIngresoFactura;
            $Datos["EmpresaPro"]=$idEmpresa;
            $Datos["CentroCostos"]=$idCentroCostos;
            $GeneradoDesde="POS";
            $idDocGenera=$idPreventa;
            if($CmbFormaPago=="Acuerdo"){
                $GeneradoDesde="Acuerdo";
                $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
                $idDocGenera=$idAcuerdoPago;
            }
            $obFactura->pos_InsertarItemsPreventaAItemsFactura($Datos,$idUser,$GeneradoDesde,$idDocGenera);
                
            //$obFactura->CopiarItemsCotizacionAItemsFactura($idCotizacion, $idFactura, $Fecha,$idUser, "");
            if($CmbFormaPago=='Contado'){
                $DatosCuenta=$obCon->DevuelveValores("subcuentas", "PUC", $CmbCuentaIngresoFactura);
                $CuentaDestino=$CmbCuentaIngresoFactura;
                $NombreCuentaDestino=$DatosCuenta["Nombre"];
            }else{
                if($CmbFormaPago=="Acuerdo"){
                    $DatosCuenta=$obCon->DevuelveValores("parametros_contables", "ID", 39); //Cuenta Clientes
                    
                }else{
                    $DatosCuenta=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Cuenta Clientes
                    
                }
                $CuentaDestino=$DatosCuenta["CuentaPUC"];
                $NombreCuentaDestino=$DatosCuenta["NombreCuenta"];
                
            }
            
            $obFactura->InsertarFacturaLibroDiarioV2($idFactura,$CmbCuentaIngresoFactura,$idUser);
            $ParametrosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 35);//Determina si una factura negativa debe devolver dinero al cliente
            if($ParametrosConfiguracion["Valor"]==1 AND $Total<0){
                $obFactura->ContabilizaGananciaOcasionalPOS($idFactura,$Total,$CmbCuentaIngresoFactura,$idUser);
            }
            $obFactura->DescargueFacturaInventariosV2($idFactura, "");
            if($CmbFormaPago<>'Contado'){
                $obFactura->IngreseCartera($idFactura, $Fecha, $idCliente, $CmbFormaPago, $SaldoFactura, "");
                //Se verifica si se recibió una cuota unicial
                if((is_numeric($TxtCuotaInicialCredito) or $TxtCuotaInicialCredito>=1)){
                    $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $idFactura);
                    $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
                    $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                    $CentroCosto=$DatosCaja["CentroCostos"];
                    $idTerceroInteres=$DatosCaja["idTerceroIntereses"];
                    $CentroCosto=$DatosCaja["CentroCostos"];
                    if($CmbFormaPago<>'SisteCredito' AND $CmbFormaPago<>'KUPY' AND $CmbFormaPago<>'Acuerdo'){
                        $Concepto="ABONO A FACTURA No $DatosFactura[Prefijo] - $DatosFactura[NumeroFactura]";
                        $VectorIngreso["fut"]="";
                        $TipoPago="";
                        $idComprobanteAbono=$obCon->RegistreAbonoCarteraCliente($Fecha,$Hora,$CuentaDestino,$idFactura,$TxtCuotaInicialCredito,$TipoPago,$CentroCosto,$Concepto,$idUser,"");

                        $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);

                        if($DatosImpresora["Habilitado"]=="SI"){
                            $obPrint->ImprimeComprobanteAbonoFactura($idComprobanteAbono, $DatosImpresora["Puerto"], 1);

                        }

                    }else{
                        if($CmbFormaPago=='SisteCredito'){
                            $CmbPlataforma=1;
                        }else{
                            $CmbPlataforma=2;
                        }
                        $DatosPlataforma=$obCon->DevuelveValores("comercial_plataformas_pago", "ID", $CmbPlataforma);

                        $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                        $CentroCosto=$DatosCaja["CentroCostos"];
                        $idTerceroInteres=$DatosPlataforma["NIT"];

                        $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 19);
                        $Abono=$TxtCuotaInicialCredito;
                        if($Abono>0){
                            $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $idTerceroInteres, $Abono, "PlataformasPago", "Ingreso por Plataforma de Pago $CmbPlataforma", "CERRADO");
                            $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $idTerceroInteres, $CuentaDestino, $Parametros["CuentaPUC"], $DatosCaja["idEmpresa"], $DatosCaja["idSucursal"], $DatosCaja["CentroCostos"]);

                            $obCon->IngresoPlataformasPago($CmbPlataforma,$Fecha, $Hora, $Tercero, $Abono, $idComprobante, $idUser,1);
                        }
                    }
                }    
            }
            if($CmbFormaPago=='SisteCredito' or $CmbFormaPago=='KUPY'){
                if($CmbFormaPago=='SisteCredito'){
                    $idPlataforma=1;
                }
                if($CmbFormaPago=='KUPY'){
                    $idPlataforma=2;
                }
                $TotalVentaPlataforma=$Total-$TxtCuotaInicialCredito;
                $obFactura->PlataformasPagoVentas($idPlataforma,$fecha,$Hora,$DatosCliente["Num_Identificacion"],$idFactura,$TotalVentaPlataforma,$idUser);
            }
            if($AnticiposCruzados>0){
                
                $obFactura->CruzarAnticipoAFactura($idFactura,$Fecha,$AnticiposCruzados,$CuentaDestino,$NombreCuentaDestino,"");
            }
            
            if($CmbColaboradores>0){
                $obCon->AgregueVentaColaborador($idFactura,$CmbColaboradores);
            }
            
            
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI" AND $CmbPrint=='SI'){
                $Copias=1;
                if($CmbFormaPago=="Acuerdo"){
                    //$Copias=2;
                }
                $obPrint->ImprimeFacturaPOS($idFactura,$DatosImpresora["Puerto"],$Copias);
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
            
            $sql="INSERT INTO pos_registro_descuentos (Fecha,idFactura,TablaItem,idProducto,Cantidad,ValorDescuento,idUsuario) "
                    . "SELECT Fecha,'$idFactura',TablaItem,ProductosVenta_idProductosVenta,Cantidad,Descuento,'$idUser' "
                    . " FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' AND Descuento <> 0;";
            $obCon->Query($sql);
            
            
            $Mensaje2="";
            
            if($CmbFormaPago=="Acuerdo"){
                $obPrintAcuerdo = new AcuerdoPagoPrint($idUser);
                $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
                $FechaInicialParaPagos=$obCon->normalizar($_REQUEST["TxtFechaInicialPagos"]);
                $ValorCuotaGeneral=$obCon->normalizar($_REQUEST["ValorCuotaAcuerdo"]);
                $CicloPagos=$obCon->normalizar($_REQUEST["cicloPagos"]);                
                $Observaciones=$obCon->normalizar($_REQUEST["TxtObservacionesAcuerdoPago"]);
                $SaldoAnterior=$obCon->normalizar($_REQUEST["SaldoActualAcuerdoPago"]);
                $SaldoFinal=$obCon->normalizar($_REQUEST["NuevoSaldoAcuerdoPago"]);
                $sql="SELECT SUM(ValorPago) as TotalCuotaInicial FROM acuerdo_pago_cuotas_pagadas_temp WHERE idAcuerdoPago='$idAcuerdoPago' AND TipoCuota=0";
                $TotalesCuotaInicial=$obAcuerdo->FetchAssoc($obAcuerdo->Query($sql));
                $CuotaInicial=$TotalesCuotaInicial["TotalCuotaInicial"];
                $SaldoInicial=$SaldoFinal;
                $SaldoFinal=$SaldoInicial-$CuotaInicial;
                
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 39);//Cuenta Clientes
                $sql="SELECT SUM(t1.ValorPago) as TotalCuotaInicial,(SELECT CuentaPUCIngresos FROM metodos_pago t2 WHERE t2.ID=t1.MetodoPago LIMIT 1 ) as CuentaPUCIngresos, (SELECT NombreCuentaPUCIngresos FROM metodos_pago t2 WHERE t2.ID=t1.MetodoPago LIMIT 1 ) as NombreCuentaPUCIngresos  FROM acuerdo_pago_cuotas_pagadas_temp t1 WHERE t1.idAcuerdoPago='$idAcuerdoPago' AND t1.TipoCuota=0 GROUP BY t1.MetodoPago";
                $ConsultaCuota=$obAcuerdo->Query($sql);
                
                while($DatosCuotaInicial=$obAcuerdo->FetchAssoc($ConsultaCuota)){
                    
                    $CuentaDestino=$DatosCuotaInicial["CuentaPUCIngresos"];
                    $CentroCosto=$DatosCaja["CentroCostos"];
                    
                    $Abono=$DatosCuotaInicial["TotalCuotaInicial"];
                    
                    $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $Abono, "AbonoAcuerdoPago", "Ingreso por Acuerdo de Pago $idAcuerdoPago", "CERRADO");
                    $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $DatosCaja["idEmpresa"], $DatosCaja["idSucursal"], $DatosCaja["CentroCostos"]);
                    $obAcuerdo->RelacionAbonosComprobantesIngreso($idAcuerdoPago, $idComprobante);
                
                }
                $obAcuerdo->CrearAcuerdoPagoDesdePOS($idAcuerdoPago,$idFactura, $FechaInicialParaPagos, $DatosCliente["Num_Identificacion"],$ValorCuotaGeneral, $CicloPagos, $Observaciones,$SaldoAnterior,$CuotaInicial, $SaldoInicial, $SaldoFinal, 1, $idUser);
                $NuevoIdAcuerdo=$obAcuerdo->getId("ap_");
                $obAcuerdo->ActualizaRegistro("vestasactivas", "IdentificadorUnico", $NuevoIdAcuerdo, "idVestasActivas", $idPreventa);
                $obFactura->BorraReg("preventa", "VestasActivas_idVestasActivas", $idPreventa);
                $obPrintAcuerdo->PrintAcuerdoPago($idAcuerdoPago, 2, 0);
                $LinkAcuerdo="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=37&idAcuerdo=$idAcuerdoPago&EstadoGeneral=0";
                $Mensaje2="<br><strong>Acuerdo de Pago Creado Correctamente </strong><a href='$LinkAcuerdo'  target='blank'> Imprimir</a>";
                
            }
            $LinkFactura="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID=$idFactura";
            $Mensaje="<br><strong>Factura $NumFactura Creada Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
            $MensajeDevuelta="<br><h3>Devuelta: ".number_format($Devuelta)."</h3>";
            $LinkProcessMail="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=38&idFactura=$idFactura";
            $MensajeMail="<br><a href='$LinkProcessMail'  target='blank'><strong>Click para enviar Factura por Email</strong></a>";
            $obCon->ActualizaRegistro("clientes", "Updated", date("Y-m-d"), "Num_Identificacion", $Tercero);
            $obFactura->BorraReg("preventa", "VestasActivas_idVestasActivas", $idPreventa);
            print("OK;$Mensaje.$Mensaje2.$MensajeDevuelta.$MensajeMail");
            
            
            
        break;//fin case 7
        
        case 8://Cotizar
            $obPrint = new PrintPos($idUser);            
            $fecha=date("Y-m-d");
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);
            $Observaciones="";
            $idCliente=$obCon->normalizar($_REQUEST['idCliente']);
            $idCotizacion=$obCon->CotizarDesdePreventa($idPreventa,$fecha,$idCliente,$Observaciones,"");
            $obCon->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI"){
                $obPrint->ImprimeCotizacionPOS($idCotizacion,$DatosImpresora["Puerto"],1);
            }
            
            $RutaPrintCot="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=1&ID=".$idCotizacion;			
            print("Cotización almacenada Correctamente <a href='$RutaPrintCot' target='_blank'>Imprimir Cotización No. $idCotizacion</a>");
            
        break;//fin caso 8
        
        case 9://Autorizar una preventa
            
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);            
            $pw=$obCon->normalizar($_REQUEST['TxtAutorizaciones']);
            //$pw=md5($pw);
            $sql="SELECT Identificacion FROM usuarios WHERE Password='$pw' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
            $Datos=$obCon->Query($sql);
            $DatosAutorizacion=$obCon->FetchArray($Datos);

            if($DatosAutorizacion["Identificacion"]==''){
                print("E1;Clave incorrecta");
                exit();
            }
            $obCon->ActualizaRegistro("preventa", "Autorizado", $DatosAutorizacion["Identificacion"], "VestasActivas_idVestasActivas", $idPreventa);
        
            print("OK;Preventa $idPreventa Autorizada");
            
        break;//fin caso 9
        
        case 10:// Colocar todos los precios de venta como mayoristas
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);            
            $pw=$obCon->normalizar($_REQUEST['TxtAutorizaciones']);
            //$pw=md5($pw);
            $sql="SELECT Identificacion FROM usuarios WHERE Password='$pw' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
            $Datos=$obCon->Query($sql);
            $DatosAutorizacion=$obCon->FetchArray($Datos);

            if($DatosAutorizacion["Identificacion"]==''){
                print("E1;Clave incorrecta");
                exit();
            }
            
            $sql="SELECT idPrecotizacion FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
            $Consulta=$obCon->Query($sql);
            while($DatosPreventa=$obCon->FetchAssoc($Consulta)){
                $obCon->POS_EditarPrecio($DatosPreventa["idPrecotizacion"],1, 1);
            }
            
            print("OK;Valores de Mayoristas Actualizados");
        break;//Fin caso 10
        
        case 11:// Descuento general por porcentaje
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);            
            $pw=$obCon->normalizar($_REQUEST['TxtAutorizaciones']);
            $Descuento=$obCon->normalizar($_REQUEST['TxtPorcentajeDescuento']);
            //$pw=md5($pw);
            $sql="SELECT Identificacion FROM usuarios WHERE Password='$pw' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
            $Datos=$obCon->Query($sql);
            $DatosAutorizacion=$obCon->FetchArray($Datos);

            if($DatosAutorizacion["Identificacion"]==''){
                //print("E1;Clave incorrecta");
                //exit();
            }
            $DatosGeneral=$obCon->DevuelveValores("configuracion_general", "ID", 6);
            $DescuentoMaximo=$DatosGeneral["Valor"];
            if($Descuento>$DescuentoMaximo){
                print("E1;El descuento máximo para esta acción es de: $DescuentoMaximo");
                exit();
            }
            $Descuento=(100-$Descuento)/100;
            
            $sql="UPDATE preventa SET Subtotal=round(Subtotal*$Descuento), Impuestos=round(Impuestos*$Descuento),"
                    . "  ValorAcordado=round(ValorAcordado*$Descuento),Descuento=round(TotalVenta-((ValorAcordado*Cantidad+Impuestos))) ,TotalVenta=round(TotalVenta*$Descuento)"
                    . " WHERE VestasActivas_idVestasActivas='$idPreventa'";
            $obCon->Query($sql);
            print("OK;Descuento Aplicado");
        break;//Fin caso 11  
        
        case 12:// Colocar todos los precios segun una lista de precios
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);            
            $pw=$obCon->normalizar($_REQUEST['TxtAutorizaciones']);
            //$pw=md5($pw);
            $sql="SELECT Identificacion FROM usuarios WHERE Password='$pw' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
            $Datos=$obCon->Query($sql);
            $DatosAutorizacion=$obCon->FetchArray($Datos);

            if($DatosAutorizacion["Identificacion"]==''){
                print("E1;Clave incorrecta");
                exit();
            }
            
            $Listado=$obCon->normalizar($_REQUEST['CmbListaPrecio']);
            
            $consulta=$obCon->ConsultarTabla("preventa", " WHERE VestasActivas_idVestasActivas='$idPreventa'");
            while ($DatosPreventa=$obCon->FetchAssoc($consulta)){
                $Cantidad=$DatosPreventa["Cantidad"];
                $idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
                $idItem=$DatosPreventa["idPrecotizacion"];
                $Tabla=$DatosPreventa["TablaItem"];
                $Datos=$obCon->ConsultarTabla("productos_precios_adicionales", " WHERE idProducto='$idProducto' AND idListaPrecios='$Listado' AND TablaVenta='$Tabla'");
                $DatosListado=$obCon->FetchArray($Datos);
                if($DatosListado["PrecioVenta"]>0){
                    $DatosProductos=$obCon->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
                    $ValorAcordado=$DatosListado["PrecioVenta"];
                    $DatosTablaItem=$obCon->DevuelveValores("tablas_ventas", "NombreTabla", $Tabla);
                    if($DatosTablaItem["IVAIncluido"]=="SI"){

                        $ValorAcordado=round($ValorAcordado/($DatosProductos["IVA"]+1),2);

                    }
                    $Subtotal=round($ValorAcordado*$Cantidad,2);


                    $IVA=round($Subtotal*$DatosProductos["IVA"],2);
                    //$SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
                    $Total=$Subtotal+$IVA;
                    $filtro="idPrecotizacion";

                    $obCon->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
                    $obCon->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
                    $obCon->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
                    $obCon->ActualizaRegistro("preventa","ValorAcordado", $ValorAcordado, $filtro, $idItem);
                }
                
            }
            
            print("OK;Valores Actualizados");
        break;//Fin caso 12
        
        case 13:// Descuento general a precio costo
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);            
            $pw=$obCon->normalizar($_REQUEST['TxtAutorizaciones']);
            
            //$pw=md5($pw);
            $sql="SELECT Identificacion FROM usuarios WHERE Password='$pw' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
            $Datos=$obCon->Query($sql);
            $DatosAutorizacion=$obCon->FetchArray($Datos);

            if($DatosAutorizacion["Identificacion"]==''){
                print("E1;Clave incorrecta");
                exit();
            }
            $DatosGeneral=$obCon->DevuelveValores("configuracion_general", "ID", 7);
            $Habilitado=$DatosGeneral["Valor"];
            if($Habilitado==0 or $Habilitado==''){
                print("E1;Esta opción no está habilitada");
                exit();
            }
            $sql="UPDATE `preventa` "
                    . "SET `ValorAcordado`=round((`CostoUnitario`)/(`PorcentajeIVA`+1),2), "
                    . "`Impuestos`=round(`PorcentajeIVA`*(`ValorAcordado`*`Cantidad`),2),"
                    . "`Subtotal`=(`ValorAcordado`*`Cantidad`), `TotalVenta`=(`Subtotal`+`Impuestos`) "
                    . "WHERE `VestasActivas_idVestasActivas`='$idPreventa' ";
            
            $sql="UPDATE `preventa` "
                    . "SET `ValorAcordado`=round((`CostoUnitario`),2), "
                    . "`Impuestos`=round(`PorcentajeIVA`*(`ValorAcordado`*`Cantidad`),2),"
                    . "`Subtotal`=(`ValorAcordado`*`Cantidad`), `TotalVenta`=(`Subtotal`+`Impuestos`) "
                    . "WHERE `VestasActivas_idVestasActivas`='$idPreventa' ";
            
            $obCon->Query($sql);
            print("OK;Descuento Aplicado");
        break;//Fin caso 13
        
        case 14:// Cerrar turno
            $obPrint = new PrintPos($idUser);
            $idCaja=1;
            $TotalEfectivoRecaudado=$obCon->normalizar($_REQUEST['TotalRecaudadoCierre']);    
            
            if(!is_numeric($TotalEfectivoRecaudado) or $TotalEfectivoRecaudado<0){
                exit("E1;El Valor debe ser un numero positivo mayor o igual a Cero;total_entrega_Format_Number");
            }
            
            $idCierre=$obCon->CierreTurnoPos($idUser,$idCaja,$TotalEfectivoRecaudado);
            
            
            $VectorCierre["idCierre"]=$idCierre;
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
                        
            if($DatosImpresora["Habilitado"]=="SI"){

                $obPrint->ImprimeCierre($idUser,$VectorCierre,$DatosImpresora["Puerto"],1);
            }
            
            print("OK;Se ha cerrado el turno de usuario $idUser");
        break;//Fin caso 14
        
        case 15:// Colocar todos los precios de venta como mayoristas si se digita el codigo de un cliente
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);            
            $CodigoTarjeta=$obCon->normalizar($_REQUEST['CodigoTarjeta']);
            
            $sql="SELECT idClientes, RazonSocial FROM clientes WHERE CodigoTarjeta='$CodigoTarjeta' LIMIT 1";
            $Datos=$obCon->Query($sql);
            $DatosCliente=$obCon->FetchArray($Datos);

            if($DatosCliente["idClientes"]==''){
                print("E1;Código inexistente");
                exit();
            }
            $idCliente=$DatosCliente["idClientes"];
            $RazonSocial=$DatosCliente["RazonSocial"];
            $sql="SELECT idPrecotizacion FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
            $Consulta=$obCon->Query($sql);
            while($DatosPreventa=$obCon->FetchAssoc($Consulta)){
                $obCon->POS_EditarPrecio($DatosPreventa["idPrecotizacion"],1, 1);
            }
            
            print("OK;Valores de Mayoristas Actualizados;$idCliente;$RazonSocial");
        break;//Fin caso 15
        
        case 16://Crear un tercero
            $nit=$obCon->normalizar($_REQUEST['Num_Identificacion']);
            $idCiudad=$obCon->normalizar($_REQUEST['CodigoMunicipio']);
            $DatosCiudad=$obCon->DevuelveValores("cod_municipios_dptos", "ID", $idCiudad);
            $DV=$obCon->CalcularDV($nit);
            $DatosCliente=$obCon->ValorActual("clientes", "idClientes", " Num_Identificacion='$nit'");
            if($DatosCliente["idClientes"]<>''){
                print("E1;El Nit Digitado ya existe");
                exit();
            }
            $Datos["Tipo_Documento"]=$obCon->normalizar($_REQUEST['TipoDocumento']);  
            $Datos["Num_Identificacion"]=$nit;    
            $Datos["DV"]=$DV;  
            $Datos["Primer_Apellido"]=$obCon->normalizar($_REQUEST['PrimerApellido']);    
            $Datos["Segundo_Apellido"]=$obCon->normalizar($_REQUEST['SegundoApellido']);    
            $Datos["Primer_Nombre"]=$obCon->normalizar($_REQUEST['PrimerNombre']);    
            $Datos["Otros_Nombres"]=$obCon->normalizar($_REQUEST['OtrosNombres']);    
            $Datos["RazonSocial"]=$obCon->normalizar($_REQUEST['RazonSocial']);    
            $Datos["Direccion"]=$obCon->normalizar($_REQUEST['Direccion']);    
            $Datos["Cod_Dpto"]=$DatosCiudad["Cod_Dpto"];    
            $Datos["Cod_Mcipio"]=$DatosCiudad["Cod_mcipio"];    
            $Datos["Pais_Domicilio"]=169;   
            $Datos["Telefono"]=$obCon->normalizar($_REQUEST['Telefono']);             
            $Datos["Ciudad"]=$DatosCiudad["Ciudad"];    
            $Datos["Email"]=$obCon->normalizar($_REQUEST['Email']); 
            $Datos["Cupo"]=$obCon->normalizar($_REQUEST['Cupo']);    
            $Datos["CodigoTarjeta"]=$obCon->normalizar($_REQUEST['CodigoTarjeta']); 
            $Datos["DiaNacimiento"]=$obCon->normalizar($_REQUEST['cmbDiaCumple']); 
            $Datos["MesNacimiento"]=$obCon->normalizar($_REQUEST['cmbMesCumple']); 
                        
            $sqlClientes=$obCon->getSQLInsert("clientes", $Datos);
            $sqlProveedores=$obCon->getSQLInsert("proveedores", $Datos);
            $obCon->Query($sqlClientes);
            $obCon->Query($sqlProveedores);
            $DatosCliente=$obCon->ValorActual("clientes", "idClientes", " Num_Identificacion='$nit'");
            
            print("OK;Se ha creado el tercero ".$Datos["RazonSocial"].", con Identificación: ".$nit.";".$DatosCliente["idClientes"].";".$Datos["RazonSocial"]);
            
        break;//FIn caso 16
        
        case 17://Verifica si ya existe un nit
            $nit=$obCon->normalizar($_REQUEST['Num_Identificacion']);
            
            $DatosCliente=$obCon->ValorActual("clientes", "idClientes", " Num_Identificacion='$nit'");
            if($DatosCliente["idClientes"]<>''){
                print("E1;El Nit Digitado ya existe");
                exit();
            }
            print("OK;El cliente no existe aún");
        break;//Fin caso 17
        
        case 18://Verifica si ya existe el codigo de una tarjeta
            $Codigo=$obCon->normalizar($_REQUEST['CodigoTarjeta']);
            
            $DatosCliente=$obCon->ValorActual("clientes", "idClientes", " CodigoTarjeta='$Codigo'");
            if($DatosCliente["idClientes"]<>''){
                print("E1;El Código de la tarjeta Digitado ya existe");
                exit();
            }
            print("OK;Código disponible");
        break;//Fin caso 18
        
        case 19://Crea un separado
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $obPrint = new PrintPos($idUser);
            $Abono=$obCon->normalizar($_REQUEST['TxtAbonoCrearSeparado']);
            $idCliente=$obCon->normalizar($_REQUEST['idCliente']);
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);
            if($idCliente<=1){
                print("E1;Debe seleccionar un cliente diferente a Clientes Varios");
                exit();
            }
            $TotalSeparado=$obCon->Sume("preventa", "TotalVenta", " WHERE VestasActivas_idVestasActivas='$idPreventa'");
            if($Abono>=$TotalSeparado){
                print("E1;El Abono no puede ser mayor o igual al total del separado");
                exit();
            }
            if($Abono<=0){
                print("E1;El Abono debe ser un número mayor a cero");
                exit();
            }
            if($TotalSeparado==0){
                print("E1;La Preventa no tiene items agregados");
                exit();
            }
            $consulta=$obCon->ConsultarTabla("preventa", " WHERE VestasActivas_idVestasActivas='$idPreventa'");
            if($obCon->NumRows($consulta)){
                $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
                $CentroCosto=$DatosCaja["CentroCostos"];
                $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                $Concepto="ANTICIPO POR SEPARADO";
                $VectorIngreso["Separado"]=1;

                $idComprobanteIngreso=$obCon->RegistreAnticipo2($fecha,$CuentaDestino,$idCliente,$Abono,$CentroCosto,$Concepto,$idUser,$VectorIngreso);

                $DatosSeparado["idCompIngreso"]=$idComprobanteIngreso;
                $idSeparado=$obCon->RegistreSeparado($fecha,$Hora,$idPreventa,$idCliente,$Abono,$DatosSeparado);
                $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
                if($DatosImpresora["Habilitado"]=="SI"){
                    $Configuracion=$obCon->DevuelveValores("configuracion_general", "ID", 8);  //Trae el numero de copias que se debe imprimir al hacer el separado
                    $obPrint->ImprimeSeparado($idSeparado, $DatosImpresora["Puerto"], $Configuracion["Valor"]);
                }
            }
            print("OK;Separado $idSeparado Creado Exitósamente");
        break;//Fin caso 19
        
        case 20://Crear un egreso
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
            $CuentaOrigen=$DatosCaja["CuentaPUCEfectivo"];
            $CentroCostos=$DatosCaja["CentroCostos"];
            $CuentaPUCIVA=$DatosCaja["CuentaPUCIVAEgresos"];
            if($DatosCaja["CuentaPUCEfectivo"]==''){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 10); //Efectivo
                
                $CuentaOrigen=$Parametros["CuentaPUC"];
                $CentroCostos=1;
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 40); //Cuenta IVA
                $CuentaPUCIVA=$Parametros["CuentaPUC"];
            }
            
            $TipoEgreso="VentasRapidas";
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
        break;//fin caso 20
        
        case 21://Abono a un separado
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $obPrint = new PrintPos($idUser);
            $Valor=$obCon->normalizar($_REQUEST['Abono']);
            $idSeparado=$obCon->normalizar($_REQUEST['idSeparado']);
            $DatosSeparado=$obCon->DevuelveValores("separados", "ID", $idSeparado);
            
            if($Valor>$DatosSeparado["Saldo"]){
                print("E1;El abono no puede ser mayor a ". number_format($DatosSeparado["Saldo"]));
                exit();
            }
            
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
            $CentroCosto=$DatosCaja["CentroCostos"];
            $Concepto="ABONO A SEPARADO No $idSeparado";
            $VectorIngreso["Separado"]=1;
            $idCliente=$DatosSeparado["idCliente"];
            $idIngreso=$obCon->RegistreAnticipo2($fecha,$CuentaDestino,$idCliente,$Valor,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
            
            $VectorSeparados["idCompIngreso"]=$idIngreso;
            $Saldo=$obCon->RegistreAbonoSeparado($idSeparado,$Valor,$fecha,$Hora,$VectorSeparados);
            
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
            $Impresiones=2;
            $NumFactura="";
            if($Saldo==0){
		$Impresiones=1;
                $VectorSeparados["Ft"]="";
                $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                $NumFactura=$obCon->CreaFacturaDesdeSeparado($idSeparado,$CuentaDestino,$VectorSeparados);
               if($DatosImpresora["Habilitado"]=="SI"){
                    $obPrint->ImprimeFacturaPOS($NumFactura,$DatosImpresora["Puerto"],1);
               }
            }
            
            if($DatosImpresora["Habilitado"]=="SI"){
                $obPrint->ImprimeSeparado($idSeparado, $DatosImpresora["Puerto"], $Impresiones);

            }
            $LinkComprobante="../../VAtencion/PDF_Documentos.php?idDocumento=4&idIngreso=$idIngreso";
            $MensajeComprobante="<br><strong>Comprobante de ingreso $idIngreso Creado Correctamente </strong><a href='$LinkComprobante'  target='blank'> Imprimir</a>";
            $MensajeFactura="";
            if($NumFactura<>''){
                $LinkFactura="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID=$NumFactura";
                $MensajeFactura="<br><strong>Factura Creada Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
           
            }
            print("OK;$MensajeComprobante;$MensajeFactura");
        break;//Fin caso 21
        
        case 22://Factura un item de un separado
            $obPrint=new PrintPos($idUser);
            $idItemSeparado=$obCon->normalizar($_REQUEST['idItemSeparado']);
            $Cantidad=$obCon->normalizar($_REQUEST['Cantidad']);
            $TotalAbonos=$obCon->normalizar($_REQUEST['TotalAbonos']);
            $DatosItem=$obCon->DevuelveValores("separados_items", "ID", $idItemSeparado);
            if($Cantidad>$DatosItem["Cantidad"]){
                print("E1;La cantidad no puede ser mayor a ".$DatosItem["Cantidad"]);
                exit();
            }
            $TotalAFacturar=$DatosItem["TotalItem"]/$Cantidad;
            if($TotalAbonos<$TotalAFacturar){
                exit("E1;El total de los abonos es inferior al valor del Producto ". number_format($TotalAFacturar));
            }
            $NumFactura=$obCon->FacturarItemSeparado($idItemSeparado,$Cantidad,$idUser,"");
            $obPrint->ImprimeFacturaPOS($NumFactura, "", 1);
            $MensajeFactura="";
            if($NumFactura<>''){
                $LinkFactura="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID=$NumFactura";
                $MensajeFactura="<br><strong>Factura Creada Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
           
            }
            print("OK;$MensajeFactura");
        break;//Fin caso 22   
        
        case 23: //Abona a una factura a credito
            $obPrint=new PrintPos($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $idCartera=$obCon->normalizar($_REQUEST['idCredito']);
            $idFactura=$obCon->normalizar($_REQUEST['idFactura']);            
            $Valor=$obCon->normalizar($_REQUEST["Abono"]);
            $Intereses=$obCon->normalizar($_REQUEST["Intereses"]);
            $AbonoTarjetas=$obCon->normalizar($_REQUEST["Tarjetas"]);
            $AbonoCheques=$obCon->normalizar($_REQUEST["Cheques"]);
            $AbonoOtros=$obCon->normalizar($_REQUEST["Otros"]);
            $TotalAbono=$Valor+$AbonoTarjetas+$AbonoCheques+$AbonoOtros;
            $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $idFactura);
            if($TotalAbono+$Intereses==0){
                print("E1;Debe enviar algún valor");
                exit();
            }
            if($TotalAbono<=$DatosFactura["SaldoFact"]){
                $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
                $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                $CentroCosto=$DatosCaja["CentroCostos"];
                $idTerceroInteres=$DatosCaja["idTerceroIntereses"];
                $CentroCosto=$DatosCaja["CentroCostos"];
                $Concepto="ABONO A FACTURA No $DatosFactura[Prefijo] - $DatosFactura[NumeroFactura]";
                $VectorIngreso["fut"]="";
                $TipoPago="";
                $idComprobanteAbono=$obCon->RegistreAbonoCarteraCliente($fecha,$Hora,$CuentaDestino,$idFactura,$Valor,$TipoPago,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                if($AbonoTarjetas>0){
                    $TipoPago="Tarjetas";
                    $DatosParametros=$obCon->DevuelveValores("parametros_contables", "ID", 17);
                    $idComprobanteAbono=$obCon->RegistreAbonoCarteraCliente($fecha,$Hora,$DatosParametros["CuentaPUC"],$idFactura,$AbonoTarjetas,$TipoPago,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                }
                if($AbonoCheques>0){
                    $TipoPago="Cheques";
                    $DatosParametros=$obCon->DevuelveValores("parametros_contables", "ID", 18);
                    $idComprobanteAbono=$obCon->RegistreAbonoCarteraCliente($fecha,$Hora,$DatosParametros["CuentaPUC"],$idFactura,$AbonoCheques,$TipoPago,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                }
                if($AbonoOtros>0){
                    $TipoPago="Bonos";
                    $idComprobanteAbono=$obCon->RegistreAbonoCarteraCliente($fecha,$Hora,$DatosCaja["CuentaPUCEfectivo"],$idFactura,$AbonoCheques,$TipoPago,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                }
                if($Intereses>0){
                    $obCon->RegistrePagoInteresesSisteCredito($fecha,$Hora,$Intereses,$idFactura,$idUser,$idTerceroInteres,$DatosCaja["CuentaPUCEfectivo"],$CentroCosto,"");
                }
                $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);

                if($DatosImpresora["Habilitado"]=="SI"){
                    $obPrint->ImprimeComprobanteAbonoFactura($idComprobanteAbono, $DatosImpresora["Puerto"], 2);

                }
                $DatosAbono=$obCon->DevuelveValores("facturas_abonos", "ID", $idComprobanteAbono);
                $idComprobanteIngreso=$DatosAbono["idComprobanteIngreso"];
                print("OK;Abono Registrado Exitosamente <a href='../../VAtencion/PDF_Documentos.php?idDocumento=4&idIngreso=$idComprobanteIngreso' target='_blank'> Imprimir</a>");
           
            }else{
                print("E1;El Saldo de la Factura es inferior a los abonos digitados, vuelva a intentarlo");
                exit();
            }
            
        break;//Fin caso 23
        
        case 24://ingresa un pago de una plataforma
            $obContabilidad = new contabilidad($idUser);
            $obPrint=new PrintPos($idUser);
            $Fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $Tercero=$obCon->normalizar($_REQUEST['Tercero']);
            $CmbPlataforma=$obCon->normalizar($_REQUEST['CmbPlataforma']);            
            $Abono=$obCon->normalizar($_REQUEST["Abono"]);
            $cmb_metodo_pago=$obCon->normalizar($_REQUEST["cmb_metodo_pago"]);
            
            $DatosPlataforma=$obCon->DevuelveValores("comercial_plataformas_pago", "ID", $CmbPlataforma);
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            $CentroCosto=$DatosCaja["CentroCostos"];
            if($cmb_metodo_pago==1){
                
                $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                
            }else{
                $datos_metodo_pago=$obCon->DevuelveValores("metodos_pago", "ID", $cmb_metodo_pago);
                $CuentaDestino=$datos_metodo_pago["CuentaPUCIngresos"];
            }
            
            $idTerceroInteres=$DatosPlataforma["NIT"];
            
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 19); //Cuenta por pagar a siste credito
            $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $idTerceroInteres, $Abono, "PlataformasPago", "Ingreso por Plataforma de Pago $CmbPlataforma", "CERRADO");
            $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $idTerceroInteres, $CuentaDestino, $Parametros["CuentaPUC"], $DatosCaja["idEmpresa"], $DatosCaja["idSucursal"], $DatosCaja["CentroCostos"]);
            
            $obCon->IngresoPlataformasPago($CmbPlataforma,$Fecha, $Hora, $Tercero, $Abono, $idComprobante, $idUser);
            $obPrint->ComprobanteIngresoPOS($idComprobante, "", 1);
            print("OK;Ingreso registrado en Comprobante $idComprobante");
            
        break;    //Fin caso 24
    
        case 30://Crear un anticipo por encargos
            
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);            
            $Observaciones=$obCon->normalizar($_REQUEST["TxtObservacionesEncargos"]);
            $MetodoPagoAnticipo=$obCon->normalizar($_REQUEST["CmbMetodoPagoAnticipo"]);
            $ValorAnticipoEncargo=$obCon->normalizar($_REQUEST["TxtValorAnticipoEncargo"]);
            
            if($idCliente<=1){
                exit("E1;No se recibió un tercero válido");
            }
            
            if($Observaciones==''){
                exit("E1;El campo observaciones no puede estar vacío;TxtObservacionesEncargos");
            }
            
            if($MetodoPagoAnticipo==''){
                exit("E1;El campo observaciones no puede estar vacío;CmbMetodoPagoAnticipo");
            }
            
            if(!is_numeric($ValorAnticipoEncargo) or $ValorAnticipoEncargo<=0){
                exit("E1;El Valor debe ser un numero positivo mayor a Cero;TxtValorAnticipoEncargo");
            }
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            $Fecha=date("Y-m-d");
            $Tercero=$DatosCliente["Num_Identificacion"];
            $idAnticipo=$obCon->NuevoAnticipoPorEncargo($Fecha, $Tercero, $Observaciones, $idUser);
            $idAbono=$obCon->AbonoAnticipoPorEncargo($Fecha, $idAnticipo, $MetodoPagoAnticipo, $ValorAnticipoEncargo, $idUser);
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            $DatosMetodoPago=$obCon->DevuelveValores("metodos_pago", "ID", $MetodoPagoAnticipo);
            $CentroCosto=$DatosCaja["CentroCostos"];
            
            if($MetodoPagoAnticipo==1){
                $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                
            }else{
                $CuentaDestino=$DatosMetodoPago["CuentaPUCIngresos"];
            }
            
            
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 20);  //Cuenta para los Anticipos de los clientes
            $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $ValorAnticipoEncargo, "AnticiposPorEncargos", $Observaciones." Ingreso por Anticipo por encargo No. $idAnticipo ", "CERRADO");
            $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $DatosCaja["idEmpresa"], $DatosCaja["idSucursal"], $DatosCaja["CentroCostos"]);
            
            $obCon->update("anticipos_encargos_abonos", "idComprobanteIngreso", $idComprobante, "WHERE ID='$idAbono'");
            $obPrint= new PrintPos($idUser);
            $obPrint->ComprobanteIngresoPOS($idComprobante, "", 1);
            
            print("OK;Anticipo x encargo recibido");
        break;//Fin caso 30    
        
        case 31://Crear un egreso por un retorno de un anticipo
            
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $Observaciones=$obCon->normalizar($_REQUEST["TxtObservacionesEncargos"]);
            $MetodoPagoAnticipo=$obCon->normalizar($_REQUEST["CmbMetodoPagoAnticipo"]);
            $ValorAnticipoEncargo=$obCon->normalizar($_REQUEST["TxtValorAnticipoEncargo"]);
            
            if($idCliente<=1){
                exit("E1;No se recibió un tercero válido");
            }
            
            if($Observaciones==''){
                exit("E1;El campo observaciones no puede estar vacío;TxtObservacionesEncargos");
            }
            
            if($MetodoPagoAnticipo==''){
                exit("E1;El campo observaciones no puede estar vacío;CmbMetodoPagoAnticipo");
            }
            
            if(!is_numeric($ValorAnticipoEncargo) or $ValorAnticipoEncargo<=0){
                exit("E1;El Valor debe ser un numero positivo mayor a Cero;TxtValorAnticipoEncargo");
            }
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            
            $NIT=$DatosCliente["Num_Identificacion"];
            $ParametrosAnticipos=$obCon->DevuelveValores("parametros_contables", "ID", 20);//Aqui se encuentra la cuenta para los anticipos
            $CuentaAnticipos=$ParametrosAnticipos["CuentaPUC"];
            $sql="SELECT SUM(Debito) as Debito, SUM(Credito) AS Credito FROM librodiario WHERE CuentaPUC='$CuentaAnticipos' AND Tercero_Identificacion='$NIT'";
            $Consulta=$obCon->Query($sql);
            $DatosAnticipos=$obCon->FetchAssoc($Consulta);
            $SaldoAnticiposTercero=$DatosAnticipos["Credito"]-$DatosAnticipos["Debito"];

            if($SaldoAnticiposTercero<$ValorAnticipoEncargo){
                $Mensaje="El Cliente no cuenta con el anticipo registrado";
                print("E1;$Mensaje");
                exit();
            }
                
            $Fecha=date("Y-m-d");
            $Tercero=$DatosCliente["Num_Identificacion"];
            
            $DatosCuentaOrigen=$obCon->DevuelveValores("parametros_contables", "ID", 21);//Cuenta para erogaciones de dinero
            $DatosCuentaAnticipos=$obCon->DevuelveValores("parametros_contables", "ID", 20);//Cuenta para anticipos del cliente
            $idEgreso=$obCon->CrearEgreso($Fecha, $Fecha, $idUser, 1, "Contado", $DatosCuentaOrigen["CuentaPUC"], $DatosCuentaAnticipos["CuentaPUC"], 0, $Tercero, "Retorno de anticipo", "NA", "", "POS", $ValorAnticipoEncargo, 0, $ValorAnticipoEncargo, 0, 0, 0, 0, 0, 0, "");
                     
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI"){
                $obPrint=new PrintPos($idUser);
                $obPrint->ImprimeEgresoPOS($idEgreso, "", "", 2);
            }
            print("OK;Egreso Realizado");
        break;//Fin caso 31    
        
        case 32: // agrega un traslado a una preventa  
        
            $traslado_id=str_replace(" ", "", $obCon->normalizar($_REQUEST["convert_id"]));
            $idPreventa= $obCon->normalizar($_REQUEST["idPreventa"]);
            
            if($idPreventa==''){
                exit("Debe seleccionar una preventa");
            }
            
            if($traslado_id==''){
                exit("E1;Debe digitar un traslado;convert_id");
            }
            
            $sql="SELECT Cantidad,(SELECT idProductosVenta FROM productosventa t2 WHERE CONVERT(t1.Referencia USING utf8)=CONVERT(t2.Referencia USING utf8) ) as producto_id FROM traslados_items t1 WHERE idTraslado='$traslado_id'";
            $Consulta=$obCon->Query($sql);
            
            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                if($DatosConsulta["producto_id"]<>''){
                    $obCon->POS_AgregaItemPreventa($DatosConsulta["producto_id"], "productosventa", $DatosConsulta["Cantidad"], $idPreventa);
                }
                
            }
            
            print("OK;Traslado agregado a la preventa $idPreventa");
            
        break;//fin caso 32    
        
        case 33://Insertar una factura al libro diario de acuerdo al listado en la tabla facturas_contabilizar
            $obFactura = new Facturacion($idUser);
            $sql="SELECT * FROM facturas_contabilizar WHERE Estado=0";
            $Consulta=$obCon->Query($sql);
            
            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                $idFactura=$DatosConsulta["idFactura"];
                $obCon->BorraReg("librodiario", "Num_Documento_Interno", $idFactura);
                $obFactura->InsertarFacturaLibroDiarioV2($idFactura,130505,$idUser);
                $obCon->ActualizaRegistro("facturas_contabilizar", "Estado", 1, "idFactura", $idFactura);
            }
            print("OK;Sentencia ejecutada");
        break;//Fin caso 33    
        
        case 34://editar el valor de un articulo de acuerdo a un porcentaje
            
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $porcentaje=$obCon->normalizar($_REQUEST["porcentaje"]);
            
            if(!is_numeric($porcentaje) or $porcentaje<=0 or $porcentaje>100){
                exit("E1;El Porcentaje debe ser un numero del 1 al 100");
            }
            
            $porcentaje=100-$porcentaje;
            $factor=($porcentaje/100);
            $sql="UPDATE preventa SET Subtotal=round(Subtotal*$factor,2), ValorAcordado=round(ValorAcordado*$factor,2), Impuestos=round(Impuestos*$factor,2), TotalVenta=round(TotalVenta*$factor,2),Descuento=round((ValorUnitario*Cantidad*(PorcentajeIVA+1)-TotalVenta),2) WHERE idPrecotizacion='$item_id';";
            $obCon->Query($sql);
            
            print("OK;$porcentaje % de descuento aplicado");
            
        break;//Fin caso 34
        
        case 35://editar el valor de un articulo de acuerdo a un porcentaje
            
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $precio=$obCon->normalizar($_REQUEST["precio"]);
            
            if(!is_numeric($precio) or $precio<=0){
                exit("E1;El Valor debe ser un valor numerico mayor a cero");
            }
            $datos_preventa=$obCon->DevuelveValores("preventa", "idPrecotizacion", $item_id);
            $datos_producto=$obCon->DevuelveValores("productosventa", "idProductosVenta", $datos_preventa["ProductosVenta_idProductosVenta"]);
            $cantidad_proporcion=round((1/$datos_producto["PrecioVenta"])*$precio,4);
            
            $sql="UPDATE preventa SET ValorUnitario=round($precio/(PorcentajeIVA+1),2), ValorAcordado='$precio', Impuestos=ValorAcordado-ValorUnitario, TotalVenta='$precio',Cantidad='$cantidad_proporcion' WHERE idPrecotizacion='$item_id';";
            $obCon->Query($sql);
            
            print("OK;Cantidad ajustada de acuerdo a proporcion");
            
        break;//Fin caso 35
        
        case 36://Consulta el valor de las ventas en el pos
            
            
            $sql="SELECT SUM(Total) as Total FROM facturas WHERE FormaPago<>'ANULADA' AND Usuarios_idUsuarios='$idUser' AND CerradoDiario=0 ";
            $datos_total=$obCon->FetchAssoc($obCon->Query($sql));
            print("OK;$ ".number_format($datos_total["Total"]).";".$datos_total["Total"]);
            
        break;//Fin caso 36
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
