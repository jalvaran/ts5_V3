<?php

include_once("../../comercial/clases/Facturacion.class.php");
class VentasRestaurantePOS extends Facturacion{
    /**
     * Crea una compra
     * @param type $Fecha
     * @param type $idTercero
     * @param type $Observaciones
     * @param type $CentroCostos
     * @param type $idSucursal
     * @param type $idUser
     * @param type $TipoCompra
     * @param type $NumeroFactura
     * @param type $Concepto
     * @param type $Vector
     * @return type
     */
    public function CrearPedido($idMesa,$idCliente,$NombreCliente, $DireccionEnvio,$Telefono,$Observaciones, $idUser,$Vector ) {
        $Fecha=date("Y-m-d");
        $Hora=date("H:i:s");
        $FechaCreacion=$Fecha." ".$Hora;
        $tab="restaurante_pedidos";
        $Datos["Fecha"]=$Fecha;
        $Datos["Hora"]=$Hora;
        $Datos["idUsuario"]=$idUser;
        $Datos["idMesa"]=$idMesa;
        $Datos["Estado"]="1";
        $Datos["Tipo"]=1;
        $Datos["idCliente"]=$idCliente;
        $Datos["NombreCliente"]=$NombreCliente;
        $Datos["DireccionEnvio"]=$DireccionEnvio;
        $Datos["TelefonoConfirmacion"]=$Telefono;
        $Datos["Observaciones"]=$Observaciones;
        
        $Datos["FechaCreacion"]=$FechaCreacion;
        
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
        $idPedido=$this->ObtenerMAX($tab,"ID", 1,"");
        
        return $idPedido;
    }
    
    public function CalcularTiempoPedido($FechaCreacion) {
        $fecha1 = date_create($FechaCreacion);
        $fecha2 = date_create(date("Y-m-d H:i:s"));
        $DatosDiferencias= date_diff($fecha1, $fecha2);
        $Dias=$DatosDiferencias->d;
        $Horas=$DatosDiferencias->h;
        $Minutos=$DatosDiferencias->i;
        $Segundos=$DatosDiferencias->s;
        $TotalTranscurrido=($Dias*1140)+($Horas*60)+$Minutos;
        return($TotalTranscurrido);
    }
    
    public function AgregueProductoAPedido($idPedido,$Cantidad,$idProducto,$Observaciones,$idUser,$Vector) {
            
            $fecha=date("Y-m-d");
            $hora=date("H:i:s");
            $DatosProductos=$this->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
            if($DatosProductos["idProductosVenta"]==''){
                exit("E1;El producto no existe en la base de datos, por favor no lo entregue");
            }
            $ValoresProducto=$this->CalculeValoresItem($fecha, $idProducto, "productosventa", $Cantidad, "");
            $tab="restaurante_pedidos_items";
            $NumRegistros=20; 

            $Columnas[0]="idProducto";          $Valores[0]=$idProducto;
            $Columnas[1]="NombreProducto";      $Valores[1]=$DatosProductos["Nombre"];
            $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
            $Columnas[3]="ValorUnitario";       $Valores[3]=$ValoresProducto["ValorUnitario"];
            $Columnas[4]="Subtotal";            $Valores[4]=$ValoresProducto["Subtotal"];
            $Columnas[5]="IVA";                 $Valores[5]=$ValoresProducto["IVA"];
            $Columnas[6]="Total";               $Valores[6]=$ValoresProducto["Total"];
            $Columnas[7]="Observaciones";       $Valores[7]=$Observaciones;
            $Columnas[8]="idPedido";            $Valores[8]=$idPedido;
            $Columnas[9]="idUsuario";           $Valores[9]=  $idUser;
            $Columnas[10]="Fecha";              $Valores[10]=$fecha;
            $Columnas[11]="Hora";               $Valores[11]= $hora;
            $Columnas[12]="ProcentajeIVA";      $Valores[12]=($DatosProductos["IVA"]*100)."%";
            $Columnas[13]="Departamento";       $Valores[13]=$DatosProductos["Departamento"];
            $Columnas[14]="Sub1";               $Valores[14]=$DatosProductos["Sub1"];
            $Columnas[15]="Sub2";               $Valores[15]= $DatosProductos["Sub2"];
            $Columnas[16]="Sub3";               $Valores[16]= $DatosProductos["Sub3"];
            $Columnas[17]="Sub4";               $Valores[17]= $DatosProductos["Sub4"];
            $Columnas[18]="Sub5";               $Valores[18]= $DatosProductos["Sub5"];
            $Columnas[19]="Estado";             $Valores[19]= "AB";
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            
        }
      
   
    public function RegistreVentaRestaurante($idPedido, $idCliente, $TipoPago, $Paga, $Devuelta, $CuentaDestino,$idUser, $DatosVentaRapida){
  	
        $obFac=new Facturacion($idUser);      
        
        $CentroCostos=$DatosVentaRapida["CentroCostos"];
        $ResolucionDian=$DatosVentaRapida["ResolucionDian"];
        $EmpresaPro=$DatosVentaRapida["idEmpresa"];
        $Cheques=$DatosVentaRapida["PagaCheque"];
        $Tarjetas=$DatosVentaRapida["PagaTarjeta"];
        $idTarjetas=$DatosVentaRapida["idTarjeta"];
        $PagaOtros=$DatosVentaRapida["PagaOtros"];
        $Observaciones=$DatosVentaRapida["Observaciones"];
        
        $OrdenCompra="";
        $OrdenSalida="";
        $ObservacionesFactura=$Observaciones;
        $FechaFactura=date("Y-m-d");
        
        if($TipoPago=="Contado"){
            $SumaDias=0;
        }else{
            $SumaDias=$TipoPago;
        }
        ////////////////////////////////Preguntamos por disponibilidad
        ///////////
        ///////////
        $ID="";
        $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
        if($DatosResolucion["Completada"]=="NO"){           ///Pregunto si la resolucion ya fue completada
            $Disponibilidad=$DatosResolucion["Estado"];
                                              //si entra a verificar es porque estaba ocupada y cambiará a 1
            while($Disponibilidad=="OC"){                   //miro que esté disponible para facturar, esto para no crear facturas dobles
                print("Esperando disponibilidad<br>");
                usleep(300);
                $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
                $Disponibilidad=$DatosResolucion["Estado"];
                
            }
            
            $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
            if($DatosResolucion["Completada"]<>"SI"){
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "OC", "ID", $ResolucionDian); //Ocupo la resolucion
                
                $sql="SELECT MAX(NumeroFactura) as FacturaActual FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                $Consulta=$this->Query($sql);
                $Consulta=$this->FetchArray($Consulta);
                $FacturaActual=$Consulta["FacturaActual"];
                $idFactura=$FacturaActual+1;
                
                //Verificamos si ya se completó el numero de la resolucion y si es así se cambia su estado
                if($DatosResolucion["Hasta"]==$idFactura){ 
                    $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $ResolucionDian);
                }
                //Verificamos si es la primer factura que se creará con esta resolucion
                //Si es así se inicia desde el numero autorizado
                if($idFactura==1){
                   $idFactura=$DatosResolucion["Desde"];
                }
                //Convertimos los dias en credito
                $FormaPagoFactura=$TipoPago;
                if($TipoPago<>"Contado"){
                    $FormaPagoFactura="Credito a $TipoPago dias";
                }
                ////////////////Inserto datos de la factura
                /////
                ////
                $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1); 
                $ID=date("YmdHis").microtime(false);
                $tab="facturas";
                $NumRegistros=32; 
                
                $Columnas[0]="TipoFactura";		    $Valores[0]=$DatosResolucion["Tipo"];
                $Columnas[1]="Prefijo";                     $Valores[1]=$DatosResolucion["Prefijo"];
                $Columnas[2]="NumeroFactura";               $Valores[2]=$idFactura;
                $Columnas[3]="Fecha";                       $Valores[3]=$FechaFactura;
                $Columnas[4]="OCompra";                     $Valores[4]=$OrdenCompra;
                $Columnas[5]="OSalida";                     $Valores[5]=$OrdenSalida;
                $Columnas[6]="FormaPago";                   $Valores[6]=$FormaPagoFactura;
                $Columnas[7]="Subtotal";                    $Valores[7]="";
                $Columnas[8]="IVA";                         $Valores[8]="";
                $Columnas[9]="Descuentos";                  $Valores[9]="";
                $Columnas[10]="Total";                      $Valores[10]="";
                $Columnas[11]="SaldoFact";                  $Valores[11]="";
                $Columnas[12]="Cotizaciones_idCotizaciones";$Valores[12]="";
                $Columnas[13]="EmpresaPro_idEmpresaPro";    $Valores[13]=$EmpresaPro;
                $Columnas[14]="Usuarios_idUsuarios";        $Valores[14]=$idUser;
                $Columnas[15]="Clientes_idClientes";        $Valores[15]=$idCliente;
                $Columnas[16]="TotalCostos";                $Valores[16]="";
                $Columnas[17]="CerradoDiario";              $Valores[17]="";
                $Columnas[18]="FechaCierreDiario";          $Valores[18]="";
                $Columnas[19]="HoraCierreDiario";           $Valores[19]="";
                $Columnas[20]="ObservacionesFact";          $Valores[20]=$ObservacionesFactura;
                $Columnas[21]="CentroCosto";                $Valores[21]=$CentroCostos;
                $Columnas[22]="idResolucion";               $Valores[22]=$ResolucionDian;
                $Columnas[23]="idFacturas";                 $Valores[23]=$ID;
                $Columnas[24]="Hora";                       $Valores[24]=date("H:i:s");
                $Columnas[25]="Efectivo";                   $Valores[25]=$Paga;
                $Columnas[26]="Devuelve";                   $Valores[26]=$Devuelta;
                $Columnas[27]="Cheques";                    $Valores[27]=$Cheques;
                $Columnas[28]="Otros";                      $Valores[28]=$PagaOtros;
                $Columnas[29]="Tarjetas";                   $Valores[29]=$Tarjetas;
                $Columnas[30]="idTarjetas";                 $Valores[30]=$idTarjetas;
                $Columnas[31]="idSucursal";                 $Valores[31]=$DatosSucursal["ID"];
                
                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
                //libero la resolucion
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                
                //////////////////////Agrego Items a la Factura desde la devolucion
                /////
                /////
                
                
                $Datos["idPedido"]=$idPedido;
                $Datos["NumFactura"]=$idFactura;
                $Datos["FechaFactura"]=$FechaFactura;
                $Datos["ID"]=$ID;
                $Datos["CuentaDestino"]=$CuentaDestino;
                $Datos["EmpresaPro"]=$EmpresaPro;
                $Datos["CentroCostos"]=$CentroCostos;
                $this->InsertarItemsPedidoAItemsFactura($Datos,$idUser);///Relaciono los items de la factura
                
                $this->InsertarFacturaLibroDiario($Datos);///Inserto Items en el libro diario
               
                if($TipoPago<>"Contado"){                   //Si es a Credito
                    $Datos["Fecha"]=$FechaFactura; 
                    $Datos["Dias"]=$SumaDias;
                    $FechaVencimiento=$this->SumeDiasFecha($Datos);
                    $Datos["idFactura"]=$Datos["ID"]; 
                    $Datos["FechaFactura"]=$FechaFactura; 
                    $Datos["FechaVencimiento"]=$FechaVencimiento;
                    $Datos["idCliente"]=$idCliente;
                    $this->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
                }
                 
            }    
          
        }else{
            exit("La Resolucion de facturacion fue completada");
        }
	return ($ID);	
		
	}
         
        
        
    public function InsertarItemsPedidoAItemsFactura($Datos,$idUser){
        
        $idPedido=$Datos["idPedido"];
        $NumFactura=$Datos["ID"];
        $FechaFactura=$Datos["FechaFactura"];
        
        $sql="SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido'";
        $Consulta=$this->Query($sql);
        $TotalSubtotal=0;
        $TotalIVA=0;
        $GranTotal=0;
        $TotalCostos=0;
        
        while($DatosCotizacion=  $this->FetchArray($Consulta)){

            $DatosProducto=$this->DevuelveValores("productosventa", "idProductosVenta", $DatosCotizacion["idProducto"]);
            ////Empiezo a insertar en la tabla items facturas
            ///
            ///
            $SubtotalItem=$DatosCotizacion["Subtotal"];
            $TotalSubtotal=$TotalSubtotal+$SubtotalItem; //se realiza la sumatoria del subtotal
            
            $IVAItem=$DatosCotizacion["IVA"];
            $TotalIVA=$TotalIVA+$IVAItem; //se realiza la sumatoria del iva
            
            $TotalItem=$DatosCotizacion['Total'];
            $GranTotal=$GranTotal+$TotalItem;//se realiza la sumatoria del total
            
            $SubtotalCosto=$DatosCotizacion['Cantidad']*$DatosProducto["CostoUnitario"];
            $TotalCostos=$TotalCostos+$SubtotalCosto;//se realiza la sumatoria de los costos
            
            //$ID=date("YmdHis").microtime(false);
            $tab="facturas_items";
            $NumRegistros=26;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]="productosventa";
            $Columnas[3]="Referencia";          $Valores[3]=$DatosProducto["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosProducto["Nombre"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosProducto["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosProducto['Sub1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosProducto['Sub2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosProducto['Sub3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosProducto['Sub4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosProducto['Sub5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosCotizacion['ValorUnitario'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosCotizacion['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=1;
            $Columnas[14]="SubtotalItem";       $Valores[14]=$SubtotalItem;
            $Columnas[15]="IVAItem";		$Valores[15]=$IVAItem;
            $Columnas[16]="TotalItem";		$Valores[16]=$TotalItem;
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=($DatosProducto['IVA']*100)."%";
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosProducto['CostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$SubtotalCosto;
            $Columnas[20]="TipoItem";		$Valores[20]="PR";
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosProducto['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="cotizacionesv5";
            $Columnas[23]="NumeroIdentificador";$Valores[23]="";
            $Columnas[24]="FechaFactura";       $Valores[24]=$FechaFactura;
            $Columnas[25]="idUsuarios";         $Valores[25]= $idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        /*   
         * Se deshabilita porque se realiza el registro en el kardex desde otra clase 
        if($DatosProducto['Existencias']<=0){
            $DatosReceta=$this->DevuelveValores("recetas_relaciones", "ReferenciaProducto", $DatosProducto['Referencia']);  
            if($DatosReceta["ID"]<>''){
                $obReceta=new Recetas($idUser);
                $obReceta->FabricarProducto($DatosCotizacion["idProducto"], $DatosCotizacion['Cantidad'], "");
                $DatosProducto['Existencias']=$DatosProducto['Existencias']+$DatosCotizacion['Cantidad'];
                
            }
        }    
        
        $DatosKardex["Cantidad"]=$DatosCotizacion['Cantidad'];
        $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
        $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
        $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
        $DatosKardex["Detalle"]="Factura";
        $DatosKardex["idDocumento"]=$NumFactura;
        $DatosKardex["TotalCosto"]=$SubtotalCosto;
        $DatosKardex["Movimiento"]="SALIDA";
        $DatosKardex["CostoUnitarioPromedio"]=$DatosProducto["CostoUnitarioPromedio"];
        $DatosKardex["CostoTotalPromedio"]=$DatosProducto["CostoUnitarioPromedio"]*$DatosKardex["Cantidad"];
        $this->InserteKardex($DatosKardex);
         * 
         */
            
        }
        /*
        $ID=$Datos["ID"]; 
        $TotalSubtotal=$TotalSubtotal;
        $TotalIVA=$TotalIVA;
        $GranTotal=$GranTotal;
        $TotalCostos=round($TotalCostos);
        
        $sql="UPDATE facturas SET Subtotal='$TotalSubtotal', IVA='$TotalIVA', Total='$GranTotal', "
                . "SaldoFact='$GranTotal', TotalCostos='$TotalCostos' WHERE idFacturas='$ID'";
        $this->Query($sql);
        */
    } 
    
    
    public function PropinasRegistro($CuentaDestino,$idFactura,$idColaborador,$Efectivo,$Tarjetas,$Vector) {
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $tab="restaurante_registro_propinas";
        $NumRegistros=6; 
        
        $Columnas[0]="Fecha";          $Valores[0]=$fecha;
        $Columnas[1]="Hora";           $Valores[1]=$hora;
        $Columnas[2]="idFactura";      $Valores[2]=$idFactura;
        $Columnas[3]="idColaborador";  $Valores[3]=$idColaborador;
        $Columnas[4]="Efectivo";       $Valores[4]=$Efectivo;
        $Columnas[5]="Tarjetas";       $Valores[5]=$Tarjetas;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        if($Efectivo>0){
            $this->IngreseMovimientoLibroDiario($fecha, "FACTURA", $idFactura, "", 1, $CuentaDestino, "CAJA GENERAL", "PROPINA", "DB", $Efectivo, "PROPINA", 1, 1, "");
            $this->IngreseMovimientoLibroDiario($fecha, "FACTURA", $idFactura, "", 1, $CuentaDestino, "CAJA GENERAL", "PROPINA", "CR", $Efectivo, "PROPINA", 1, 1, "");
                    
        }
        
        if($Tarjetas>0){
            $this->IngreseMovimientoLibroDiario($fecha, "FACTURA", $idFactura, "", 1, 11100502, "BANCOS PROPINAS", "PROPINA", "DB", $Tarjetas, "PROPINA", 1, 1, "");
            $this->IngreseMovimientoLibroDiario($fecha, "FACTURA", $idFactura, "", 1, $CuentaDestino, "CAJA GENERAL", "PROPINA", "CR", $Tarjetas, "PROPINA", 1, 1, "");
                    
        }
        
        
    }
    
    //Ingrese los items al inventario o retire items del inventario
    public function RealizarMovimientosInventario($idComprobante,$idUser) {
        $obInsumos=new Recetas(1);
        $Detalle="ComprobanteBajaAlta";
        $sql="SELECT * FROM inventario_comprobante_movimientos_items WHERE idComprobante='$idComprobante' AND Estado=''";
        $Consulta=$this->Query($sql);
        while($DatosProductos= $this->FetchArray($Consulta)){
            if($DatosProductos["TipoMovimiento"]=="BAJA"){
                $Movimiento="SALIDA";
            }else{
                $Movimiento="ENTRADA";
            }
            $idItem=$DatosProductos["ID"];
            if($DatosProductos["TablaOrigen"]=='productosventa'){
                
                $DatosProductoGeneral= $this->DevuelveValores("productosventa", "idProductosVenta", $DatosProductos["idProducto"]);
                $DatosKardex["Cantidad"]=$DatosProductos["Cantidad"];
                $DatosKardex["idProductosVenta"]=$DatosProductos["idProducto"];
                $DatosKardex["CostoUnitario"]=$DatosProductoGeneral['CostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProductoGeneral['Existencias'];

                $DatosKardex["Detalle"]=$Detalle;   
                $DatosKardex["idDocumento"]=$idComprobante;
                $DatosKardex["TotalCosto"]=$DatosProductos["Cantidad"]*$DatosProductoGeneral['CostoUnitario'];
                $DatosKardex["Movimiento"]=$Movimiento;
                $DatosKardex["CostoUnitarioPromedio"]=$DatosProductoGeneral["CostoUnitarioPromedio"];
                $DatosKardex["CostoTotalPromedio"]=$DatosProductoGeneral["CostoUnitarioPromedio"]*$DatosKardex["Cantidad"];
                $this->InserteKardex($DatosKardex);
            }
            
            if($DatosProductos["TablaOrigen"]=='insumos'){
                $DatosProductoGeneral= $this->DevuelveValores("insumos", "ID", $DatosProductos["idProducto"]);
            
                $obInsumos->KardexInsumo($Movimiento, $Detalle, $idComprobante, $DatosProductoGeneral["Referencia"], $DatosProductos["Cantidad"], $DatosProductoGeneral["CostoUnitario"], "");
            }
            
            $this->ActualizaRegistro("inventario_comprobante_movimientos_items", "Estado", "KARDEX", "ID", $idItem);
            
        }
        
          
        
    }
    
    public function RestauranteRegistreVentaUsuario($idFactura,$idMesero,$Total) {
        
        $tab="restaurante_registro_ventas_mesero";
        $Datos["idFactura"]=$idFactura;
        $Datos["idUsuario"]=$idMesero;
        $Datos["Total"]=$Total;
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
    }
    
    //cerrar el turno en restaurante
    public function CierreTurnoRestaurantePos($Observaciones,$idUser) {
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $tab="restaurante_cierres";
        $NumRegistros=4; 
        
        $Columnas[0]="Fecha";               $Valores[0]=$fecha;
        $Columnas[1]="Hora";                $Valores[1]=$hora;
        $Columnas[2]="idUsuario";           $Valores[2]=$idUser;
        $Columnas[3]="Observaciones";       $Valores[3]=$Observaciones;
                
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idCierre=$this->ObtenerMAX($tab,"ID", 1,"");
        $this->update("restaurante_pedidos", "idCierre", $idCierre, " WHERE idCierre=0 AND Estado<>'1'");
        $this->update("restaurante_pedidos_items", "idCierre", $idCierre, " WHERE idCierre=0 AND Estado<>'1' ");
        $this->update("traslados_items", "idCierre", $idCierre, " WHERE idCierre=0");
        $this->update("restaurante_registro_propinas", "idCierre", $idCierre, " WHERE idCierre=0;");
        $this->update("restaurante_registro_ventas_mesero", "idCierre", $idCierre, " WHERE idCierre=0;");
        $this->update("inventario_comprobante_movimientos_items", "idCierre", $idCierre, " WHERE idCierre=0;");
        
        $this->update("modelos_pagos_realizados", "idCierre", $idCierre, " WHERE idCierre=0;");
        $this->update("modelos_agenda", "idCierre", $idCierre, " WHERE idCierre=0;");
        $this->update("librodiario", "idCierre", $idCierre, " WHERE idCierre=0;"); //Ojo para este caso se cierra sin tener en cuenta el id del usuario
        $this->update("facturas", "CerradoDiario", $idCierre, "WHERE (CerradoDiario='0' or CerradoDiario='' ) ");
        $this->update("facturas_items", "idCierre", $idCierre, "WHERE (idCierre='0' or idCierre='')");
        $this->update("factura_compra_items", "idCierre", $idCierre, "WHERE (idCierre='0' or idCierre='') ");
        return($idCierre);
    }
    
    
    //cerrar el turno en restaurante
    public function RegistreResumenCierre($idCierre,$idUser) {
        $Fecha=date("Y-m-d");
        $FechaRegistro=date("Y-m-d H:i:s");
        $DatosSucursal= $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
        $SedeActual= $DatosSucursal["ID"];     
        $sql="INSERT INTO restaurante_resumen_cierre 
                (`Fecha`,`idProducto`,`NombreProducto`,`Compra`,`Ventas`,`TrasladosRecibidos`,`TrasladosRealizados`,`Bajas`,`Altas`,`Recibe`,`Saldo`,`TotalVentas`,`TotalPropinas1`,`TotalPropinas2`,`TotalPropinas3`,`TotalPropinas4`,`TotalCasa`,`idUser`,`idCierre`,`FechaCreacion`)
              SELECT '$Fecha',t1.idProductosVenta,t1.Nombre,
               (SELECT IFNULL((SELECT SUM(Cantidad) FROM factura_compra_items fci WHERE t1.idProductosVenta=fci.idProducto AND idCierre='$idCierre'),0)) AS ItemsCompras,
               (SELECT IFNULL((SELECT SUM(Cantidad) FROM facturas_items fi WHERE t1.Referencia=fi.Referencia AND idCierre='$idCierre'),0)) as ItemsVentas,
               (SELECT IFNULL((SELECT SUM(Cantidad) FROM traslados_items ti WHERE CONVERT(ti.Referencia USING utf8)=CONVERT(t1.Referencia USING utf8 ) AND Destino='$SedeActual' AND idCierre='$idCierre'),0)) as TrasladosRecibidos,
               (SELECT IFNULL((SELECT SUM(Cantidad) FROM traslados_items ti WHERE CONVERT(ti.Referencia USING utf8)=CONVERT(t1.Referencia USING utf8 ) AND Destino<>'$SedeActual' AND idCierre='$idCierre' AND Estado='PREPARADO'),0)) as TrasladosEnviados,
               (SELECT IFNULL((SELECT SUM(Cantidad) FROM inventario_comprobante_movimientos_items icm WHERE t1.idProductosVenta=icm.idProducto AND TablaOrigen='productosventa' AND TipoMovimiento='BAJA' AND idCierre='$idCierre'),0)) AS TotalBajas,
               (SELECT IFNULL((SELECT SUM(Cantidad) FROM inventario_comprobante_movimientos_items icm WHERE t1.idProductosVenta=icm.idProducto AND TablaOrigen='productosventa' AND TipoMovimiento='ALTA' AND idCierre='$idCierre'),0)) AS TotalAltas,
               (t1.Existencias - (SELECT ItemsCompras) + (SELECT TrasladosEnviados) - (SELECT TrasladosRecibidos) + (SELECT TotalBajas) - (SELECT TotalAltas) + (SELECT ItemsVentas)) AS CantidadRecibida, 
               (t1.Existencias) as SaldoFinal,
               (SELECT SUM(TotalItem) FROM facturas_items fi WHERE t1.Referencia=fi.Referencia AND idCierre='$idCierre') as TotalVentas,
               (t1.ValorComision1 * (SELECT ItemsVentas)) as TotalComisiones1,
               (t1.ValorComision2 * (SELECT ItemsVentas)) as TotalComisiones2,
               (t1.ValorComision3 * (SELECT ItemsVentas)) as TotalComisiones3,
               (t1.ValorComision4 * (SELECT ItemsVentas)) as TotalComisiones4,
               ((SELECT TotalVentas)-(SELECT TotalComisiones1)-(SELECT TotalComisiones2)-(SELECT TotalComisiones3)-(SELECT TotalComisiones4)) as TotalCasa,
               '$idUser','$idCierre','$FechaRegistro'
              FROM productosventa t1   
            ";
        $this->Query($sql);
    }
    
    /**
     * Fin Clase
     */
}
