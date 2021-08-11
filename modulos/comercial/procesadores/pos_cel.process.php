<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/Facturacion.class.php");

include_once("../../../general/clases/contabilidad.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Facturacion($idUser);
    $obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1://Agregar un producto a la preventa
            
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]); 
            $producto_id=$obCon->normalizar($_REQUEST["producto_id"]);             
            $Cantidad=$obCon->normalizar($_REQUEST["cantidad"]); 
            $valor=$obCon->normalizar($_REQUEST["valor"]); 
            
            if($idPreventa==""){
                exit("E1;No se envió el numero de la preventa");
            }
            if($producto_id==""){
                exit("E1;No se envió el id del producto");
            }
            if(!is_numeric($Cantidad) or $Cantidad<=0){
                exit("E1;La cantidad debe ser un número mayor a Cero");
            }
            if(!is_numeric($valor) or $valor<=0){
                exit("E1;El valor del producto debe ser mayor a Cero");
            }
            //exit("OK;$producto_id // $Cantidad // $valor");         
            $obCon->POS_AgregaItemPreventa($producto_id, "productosventa", $Cantidad, $idPreventa,$valor);
            exit("OK;Item $producto_id Agregado");
                       
        break;//Fin caso 1
               
        case 3: //Guarda la factura
                       
            $obFactura = new Facturacion($idUser);            
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);       
            $Fecha=date("Y-m-d");
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            if($DatosCaja["ID"]==''){
                exit("E1;No tiene una caja asignada para facturar");
            }
            $idCentroCostos=$DatosCaja["CentroCostos"];
            $CmbResolucion=$DatosCaja["idResolucionDian"];
            $CmbFormaPago=$obCon->normalizar($_REQUEST["CmbTipoPago"]);
            $CmbFrecuente="NO";
            $CmbCuentaIngresoFactura=$DatosCaja["CuentaPUCEfectivo"];
            $CmbColaboradores="";
            $Observaciones="";
            $AnticiposCruzados="";
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
            $Devuelta=0;
            $Cheques=0;
            $Otros=0;
            
            $OrdenCompra="";
            $TxtCuotaInicialCredito="";
            if($idCliente<=1){
                exit("E1;Debe seleccionar un Cliente");
            }
            
            $FormaPagoFactura=$CmbFormaPago;
            if(is_numeric($FormaPagoFactura)){
                $FormaPagoFactura="Credito a $CmbFormaPago dias";
            }
            if($CmbFormaPago=='Bancos'){
                $FormaPagoFactura="Contado";
            }
            $Hora=date("H:i:s");
            
            $sql="SELECT count(*) totalItems,SUM(ValorAcordado*Cantidad) AS Subtotal, SUM(Impuestos) AS IVA, SUM(TotalVenta) as Total,SUM(CostoUnitario*Cantidad) AS TotalCostos "
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
            
            if($CmbFormaPago=="Bancos"){
                $Efectivo=0;                
                $Tarjetas=$Total;
            }
            if($CmbFormaPago=="Contado"){                
                $Efectivo=$Total;                
                $Tarjetas=0;
            }
            
            $Descuentos=0;
            
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
            if($CmbFormaPago=='Bancos'){
                $CmbCuentaIngresoFactura=$DatosCaja["CuentaPUCCheques"];
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
            
            $obFactura->pos_InsertarItemsPreventaAItemsFactura($Datos,$idUser,$GeneradoDesde,$idDocGenera);
            
            if($CmbFormaPago=='Contado' or $CmbFormaPago=='Bancos'){
                $DatosCuenta=$obCon->DevuelveValores("subcuentas", "PUC", $CmbCuentaIngresoFactura);
                $CuentaDestino=$CmbCuentaIngresoFactura;
                $NombreCuentaDestino=$DatosCuenta["Nombre"];
            }else{
                
                $DatosCuenta=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Cuenta Clientes
                 
                $CuentaDestino=$DatosCuenta["CuentaPUC"];
                $NombreCuentaDestino=$DatosCuenta["NombreCuenta"];
                
            }
            
            $obFactura->InsertarFacturaLibroDiarioV2($idFactura,$CmbCuentaIngresoFactura,$idUser);
            
            $obFactura->DescargueFacturaInventariosV2($idFactura, "");
            $idComprobanteAbono="";
            
            /*
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI" AND $CmbPrint=='SI'){
                $Copias=1;
                if($CmbFormaPago=="Acuerdo"){
                    //$Copias=2;
                }
                //$obPrint->ImprimeFacturaPOS($idFactura,$DatosImpresora["Puerto"],1);
                
            }
            
             * 
             */
            
            
            
            $LinkFactura="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID=$idFactura";
        
            $Mensaje='<a href="'.$LinkFactura.'" target="blank" class="btn btn-block btn-social btn-google btn-lg">
                        <i class="fa fa-file-pdf-o"></i> Factura '.$NumFactura.' Creada Correctamente
                      </a>';
            $obCon->ActualizaRegistro("clientes", "Updated", date("Y-m-d"), "Num_Identificacion", $Tercero);
            $obFactura->BorraReg("preventa", "VestasActivas_idVestasActivas", $idPreventa);
            print("OK;$Mensaje");
                        
        break;//fin case 3
        
        case 4://Genera una cotizacion que descarga del inventario
            $fecha=date("Y-m-d");
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);
            $Observaciones='';
            $idCliente=$obCon->normalizar($_REQUEST['idCliente']);
            if($idCliente<=1){
                exit("E1;Debe seleccionar un Cliente");
            }
            $idCotizacion=$obCon->CotizarDesdePreventa($idPreventa,$fecha,$idCliente,$Observaciones,"");
            $obCon->DescargueCotizacionInventariosV2($idCotizacion, "");
            $obCon->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
            
            
            $RutaPrintCot="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=1&ID=".$idCotizacion;
            $Mensaje='<a href="'.$RutaPrintCot.'" target="blank" class="btn btn-block btn-social btn-github btn-lg">
                        <i class="fa fa-file-pdf-o"></i> Cotización '.$idCotizacion.' Creada Correctamente
                      </a>';
            print("OK;$Mensaje");
            
        break;//Fin caso 4 
        
        case 5: //aumentar o disminuir la cantidad de un producto
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);
            $accion_id=$obCon->normalizar($_REQUEST["accion_id"]);
            if($item_id==''){
                exit("E1;No se recibió el item");
            }
            if($accion_id==''){
                exit("E1;No se recibió la accion");
            }
            $datos_item=$obCon->DevuelveValores("preventa", "idPrecotizacion", $item_id);
            $cantidad_actual=$datos_item["Cantidad"];
            if($accion_id==1){
                $cantidad_nueva=$cantidad_actual+1;
            }
            if($accion_id==2 and $cantidad_actual==1){
                exit("E1;La cantidad no se puede disminuir");
            }
            if($accion_id==2){
                $cantidad_nueva=$cantidad_actual-1;
            }
            $divisor=$cantidad_actual;
            if($cantidad_actual==0){
                $divisor=1;
            }
            $iva_nuevo=round(($datos_item["Impuestos"]/$divisor)*$cantidad_nueva,2);
            $subtotal=$datos_item["ValorAcordado"]*$cantidad_nueva;
            $total_nuevo=$subtotal+$iva_nuevo;
            $sql="UPDATE preventa SET Cantidad='$cantidad_nueva',Subtotal='$subtotal',Impuestos='$iva_nuevo', TotalVenta='$total_nuevo' WHERE idPrecotizacion='$item_id' ";
            $obCon->Query($sql);
            $number_total= number_format($total_nuevo);
            print("OK;Item modificado;$cantidad_nueva;$number_total");
        break;//Fin caso 5
        
        case 6://Borrar un producto de la preventa
            $item_id=$obCon->normalizar($_REQUEST["idItem"]);
            
            $obCon->BorraReg("preventa", "idPrecotizacion", $item_id);
            
            print("OK;Item Eliminado");
            
        break;//Fin caso 6    
    
        case 7:// Cerrar turno
            
            $idCaja=1;
            $TotalEfectivoRecaudado=$obCon->normalizar($_REQUEST['TotalRecaudadoCierre']);    
            
            if(!is_numeric($TotalEfectivoRecaudado) or $TotalEfectivoRecaudado<0){
                exit("E1;El Valor debe ser un numero positivo mayor o igual a Cero;total_entrega_Format_Number");
            }
            
            $idCierre=$obCon->CierreTurnoPos($idUser,$idCaja,$TotalEfectivoRecaudado);
            
            $RutaPrintCot="procesadores/comercial_pdf.process.php?Accion=1&cierre_id=".$idCierre;
            $Mensaje='<a href="'.$RutaPrintCot.'" target="blank" class="btn btn-block btn-social btn-github btn-lg">
                        <i class="fa fa-file-pdf-o"></i> Cierre '.$idCierre.' Creado Correctamente
                      </a>';
            print("OK;$Mensaje");
            
            
        break;//Fin caso 7
    
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
