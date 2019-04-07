<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
include_once 'Recetas.class.php';
class Compra extends ProcesoVenta{
    
    public function CrearCompra($Fecha, $idTercero, $Observaciones,$CentroCostos, $idSucursal, $idUser,$TipoCompra,$NumeroFactura,$Concepto,$Vector ) {
        
        //////Creo la compra            
        $tab="factura_compra";
        $NumRegistros=11;

        $Columnas[0]="Fecha";		$Valores[0]=$Fecha;
        $Columnas[1]="Tercero";         $Valores[1]=$idTercero;
        $Columnas[2]="Observaciones";   $Valores[2]=$Observaciones;
        $Columnas[3]="Estado";		$Valores[3]="ABIERTA";
        $Columnas[4]="idUsuario";	$Valores[4]=$idUser;
        $Columnas[5]="idCentroCostos";	$Valores[5]=$CentroCostos;
        $Columnas[6]="idSucursal";	$Valores[6]=$idSucursal;
        $Columnas[7]="TipoCompra";	$Valores[7]=$TipoCompra;
        $Columnas[8]="NumeroFactura";	$Valores[8]=$NumeroFactura;
        $Columnas[9]="Soporte";         $Valores[9]="";
        $Columnas[10]="Concepto";        $Valores[10]=$Concepto;
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idCompra=$this->ObtenerMAX($tab,"ID", 1,"");
        
        //Miro si se recibe un archivo
        //
        $destino="";
        if(!empty($_FILES['foto']['name'])){
            //echo "<script>alert ('entra foto')</script>";
            $Atras="../";
            $carpeta="SoportesCompras/";
            opendir($Atras.$carpeta);
            $Name=$idCompra."_".str_replace(' ','_',$_FILES['foto']['name']);
            $destino=$carpeta.$Name;
            move_uploaded_file($_FILES['foto']['tmp_name'],$Atras.$destino);
	}
        $this->ActualizaRegistro("factura_compra", "Soporte", $destino, "ID", $idCompra);
        return $idCompra;
    }
    
    //Clase para agregar un item a una compra
    public function AgregueProductoCompra($idCompra,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,$Vector) {
        //Proceso la informacion
        if($IVAIncluido=="SI"){
            if(is_numeric($TipoIVA)){
                $CostoUnitario=round($CostoUnitario/(1+$TipoIVA));
            }            
        }
        $Subtotal= round($CostoUnitario*$Cantidad);
        if(is_numeric($TipoIVA)){
            $Impuestos=round($Subtotal*$TipoIVA);
        }else{
            $Impuestos=0;
        }
        $Total=$Subtotal+$Impuestos;
        //////Agrego el registro           
        $tab="factura_compra_items";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Clase para agregar un insumo a una compra
    public function AgregueInsumoCompra($idCompra,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,$Vector) {
        //Proceso la informacion
        if($IVAIncluido=="SI"){
            if(is_numeric($TipoIVA)){
                $CostoUnitario=round($CostoUnitario/(1+$TipoIVA));
            }            
        }
        $Subtotal= round($CostoUnitario*$Cantidad);
        if(is_numeric($TipoIVA)){
            $Impuestos=round($Subtotal*$TipoIVA);
        }else{
            $Impuestos=0;
        }
        $Total=$Subtotal+$Impuestos;
        //////Agrego el registro           
        $tab="factura_compra_insumos";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Clase para agregar un item a una compra
    public function AgregueRetencionCompra($idCompra,$Cuenta,$Valor,$Porcentaje,$Vector) {
        //Proceso la informacion
        $DatosCuentas= $this->DevuelveValores("subcuentas", "PUC", $Cuenta);
        //////Agrego el registro           
        $tab="factura_compra_retenciones";
        $NumRegistros=5;

        $Columnas[0]="idCompra";            $Valores[0]=$idCompra;
        $Columnas[1]="CuentaPUC";           $Valores[1]=$Cuenta;
        $Columnas[2]="NombreCuenta";        $Valores[2]=$DatosCuentas["Nombre"];
        $Columnas[3]="ValorRetencion";      $Valores[3]=$Valor;
        $Columnas[4]="PorcentajeRetenido";  $Valores[4]=$Porcentaje;       
                            
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    //Contabilizar Items de la compra
    public function ContabilizarProductosCompra($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 4);   //Cuenta de inventarios
        $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $ParametrosContables["CuentaPUC"], $ParametrosContables["NombreCuenta"], "Compras", "DB", $TotalesCompra["Subtotal_Productos_Add"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
        $sql="SELECT SUM(`ImpuestoCompra`) AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_items` WHERE `idFacturaCompra`='$idCompra' GROUP BY `Tipo_Impuesto` ";
        $consulta= $this->Query($sql);
        while($DatosImpuestos= $this->FetchArray($consulta)){
            $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosImpuestos["TipoImpuesto"]);
            if($DatosImpuestos["IVA"]>0){
                $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "Compras", "DB", $DatosImpuestos["IVA"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            }
        }
    }
    
    //Contabilizar insumos de la compra
    public function ContabilizarInsumosCompra($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 22);   //Cuenta de inventarios
        $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $ParametrosContables["CuentaPUC"], $ParametrosContables["NombreCuenta"], "Compras", "DB", $TotalesCompra["Subtotal_Insumos"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
        $sql="SELECT SUM(`ImpuestoCompra`) AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_insumos` WHERE `idFacturaCompra`='$idCompra' GROUP BY `Tipo_Impuesto` ";
        $consulta= $this->Query($sql);
        while($DatosImpuestos= $this->FetchArray($consulta)){
            $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosImpuestos["TipoImpuesto"]);
            if($DatosImpuestos["IVA"]>0){
                $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "Compras", "DB", $DatosImpuestos["IVA"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            }
        }
    }
    
    //Contabilizar Items de la compra
    public function ContabilizarServiciosCompra($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        //$TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $sql="SELECT CuentaPUC_Servicio AS CuentaPUC,Nombre_Cuenta AS NombreCuenta, Concepto_Servicio AS Concepto,`Subtotal_Servicio` AS Subtotal,`Impuesto_Servicio` AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_servicios` WHERE `idFacturaCompra`='$idCompra' ";
        $consulta= $this->Query($sql);
        while($DatosServicios= $this->FetchArray($consulta)){
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosServicios["CuentaPUC"], $DatosServicios["NombreCuenta"], "Servicios", "DB", $DatosServicios["Subtotal"], $DatosServicios["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosServicios["TipoImpuesto"]);
            if($DatosServicios["IVA"]>0){
                $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "Servicios", "DB", $DatosServicios["IVA"], $DatosServicios["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            }
        }
    }
    //Contabilice Retenciones
    public function ContabilizarRetencionesCompra($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        //$TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $sql="SELECT SUM(`ValorRetencion`) AS Retencion, `CuentaPUC` AS CuentaPUC,`NombreCuenta` AS NombreCuenta FROM `factura_compra_retenciones` WHERE `idCompra`='$idCompra' GROUP BY `CuentaPUC` ";
        $consulta= $this->Query($sql);
        while($DatosRetencion= $this->FetchArray($consulta)){
            
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosRetencion["CuentaPUC"], $DatosRetencion["NombreCuenta"], "Retenciones", "CR", $DatosRetencion["Retencion"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            
        }
    }
    
    //Ingrese los items al inventario o retire items del inventario
    public function IngreseRetireProductosInventarioCompra($idCompra,$Movimiento,$idTabla='idFacturaCompra') {
        $obInsumos=new Recetas(1);
        $Detalle="FacturaCompra";
            if($idTabla=='idNotaDevolucion'){
                $Detalle="NotaDevolucion";
            }
        if($Movimiento=="ENTRADA" AND $idTabla=='idNotaDevolucion'){
            $consulta= $this->ConsultarTabla("factura_compra_items_devoluciones", "WHERE $idTabla='$idCompra'");
        }    
        if($Movimiento=="ENTRADA" AND $idTabla=='idFacturaCompra'){
            $consulta= $this->ConsultarTabla("factura_compra_items", "WHERE $idTabla='$idCompra'");
            $DatosKardex["CalcularCostoPromedio"]=1;
        }
        if($Movimiento=="SALIDA"){
            $consulta= $this->ConsultarTabla("factura_compra_items_devoluciones", "WHERE $idTabla='$idCompra'");
        } 
        while($DatosProductos= $this->FetchArray($consulta)){
            $DatosProductoGeneral= $this->DevuelveValores("productosventa", "idProductosVenta", $DatosProductos["idProducto"]);
            $DatosKardex["Cantidad"]=$DatosProductos["Cantidad"];
            $DatosKardex["idProductosVenta"]=$DatosProductos["idProducto"];
            $DatosKardex["CostoUnitario"]=$DatosProductos['CostoUnitarioCompra'];
            $DatosKardex["Existencias"]=$DatosProductoGeneral['Existencias'];
            
            $DatosKardex["Detalle"]=$Detalle;   
            $DatosKardex["idDocumento"]=$idCompra;
            $DatosKardex["TotalCosto"]=$DatosProductos["Cantidad"]*$DatosProductos['CostoUnitarioCompra'];
            $DatosKardex["Movimiento"]=$Movimiento;
            $DatosKardex["CostoUnitarioPromedio"]=$DatosProductoGeneral["CostoUnitarioPromedio"];
            $DatosKardex["CostoTotalPromedio"]=$DatosProductoGeneral["CostoUnitarioPromedio"]*$DatosKardex["Cantidad"];
            $this->InserteKardex($DatosKardex);
        }
        
        if($Movimiento=="ENTRADA" AND $idTabla=='idFacturaCompra'){
            $consulta= $this->ConsultarTabla("factura_compra_insumos", "WHERE $idTabla='$idCompra'");
            while($DatosProductos= $this->FetchArray($consulta)){
                $DatosProductoGeneral= $this->DevuelveValores("insumos", "ID", $DatosProductos["idProducto"]);
            
                $obInsumos->KardexInsumo($Movimiento, $Detalle, $idCompra, $DatosProductoGeneral["Referencia"], $DatosProductos["Cantidad"], $DatosProductos["CostoUnitarioCompra"], "");
            }
        }    
        
    }
    //Revise si hay productos devueltos y contabilice
    public function ContabiliceProductosDevueltos($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        
        if($TotalesCompra["Total_Productos_Dev"]>0){
            
            $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 4); //Cuenta de inventarios
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $ParametrosContables["CuentaPUC"], $ParametrosContables["NombreCuenta"], "DevolucionCompras", "CR", $TotalesCompra["Subtotal_Productos_Dev"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            $sql="SELECT SUM(`ImpuestoCompra`) AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_items_devoluciones` WHERE `idFacturaCompra`='$idCompra' GROUP BY `Tipo_Impuesto` ";
            $consulta= $this->Query($sql);
            while($DatosImpuestos= $this->FetchArray($consulta)){
                $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosImpuestos["TipoImpuesto"]);
                if($DatosImpuestos["IVA"]>0){
                    $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "DevolucionCompras", "CR", $DatosImpuestos["IVA"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
                }
            }
                       
        }
    }
    //Guarde una Compra
    public function GuardarFacturaCompra($idCompra,$TipoPago,$CuentaOrigen,$CuentaPUCCXP,$FechaProgramada,$Vector) {
        
        
        $DatosEmpresa=$this->ValorActual("empresapro", "CXPAutomaticas", "idEmpresaPro='1'");
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $TotalRetenciones= $TotalesCompra["Total_Retenciones"];
        $this->ContabilizarProductosCompra($idCompra);     //Contabilizo los productos agregados
        $this->ContabilizarServiciosCompra($idCompra);     //Contabilizo los Servicios agregados
        $this->ContabilizarRetencionesCompra($idCompra);   //Contabilizo las Retenciones
        $this->ContabilizarInsumosCompra($idCompra);     //Contabilizo los productos agregados
        //Contabilizo salida de dinero o cuenta X Pagar
        if($TipoPago=="Credito"){
            //$ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 14);
            //$CuentaDestino=$ParametrosContables["CuentaPUC"];
            //$NombreCuenta=$ParametrosContables["NombreCuenta"];
            $ParametrosContables=$this->DevuelveValores("subcuentas", "PUC", $CuentaPUCCXP);
            $CuentaDestino=$CuentaPUCCXP;
            $NombreCuenta=$ParametrosContables["Nombre"];
        }else{
            $DatosSubcuentas= $this->DevuelveValores("subcuentas", "PUC", $CuentaOrigen);
            $CuentaDestino=$CuentaOrigen;
            $NombreCuenta=$DatosSubcuentas["Nombre"];
        }
        $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $CuentaDestino, $NombreCuenta, "Compras", "CR", $TotalesCompra["Total_Productos_Add"]+$TotalesCompra["Total_Servicios"]+$TotalesCompra["Total_Insumos"]-$TotalesCompra["Total_Retenciones"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
        if($TotalesCompra["Total_Productos_Dev"]>0){  //Si hay devoluciones en compras se debita la cuenta de proveedores
          $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $CuentaDestino, $NombreCuenta, "DevolucionCompras", "DB", $TotalesCompra["Total_Productos_Dev"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            
        }
        $this->ContabiliceProductosDevueltos($idCompra);
        $this->IngreseRetireProductosInventarioCompra($idCompra,"ENTRADA");  //Ingreso los productos al inventario
        $this->IngreseRetireProductosInventarioCompra($idCompra,"SALIDA");   //Retiro los productos del inventario
        //Si es credito se ingresa a cuentas X Pagar
        
        if($TipoPago=="Credito" AND $DatosEmpresa["CXPAutomaticas"]=="SI"){
            $SubtotalCuentaXPagar=$TotalesCompra["Gran_Subtotal"];
            $TotalIVACXP=$TotalesCompra["Gran_Impuestos"];
            $TotalCompraCXP=$TotalesCompra["Gran_Total"];
            $VectorCuentas["CuentaPUC"]=$CuentaPUCCXP;
            $this->RegistrarCuentaXPagar($DatosFacturaCompra["Fecha"], $DatosFacturaCompra["NumeroFactura"], $FechaProgramada, "factura_compra", $idCompra, $SubtotalCuentaXPagar, $TotalIVACXP, $TotalCompraCXP, $TotalesCompra["Total_Retenciones"], 0, 0, $DatosFacturaCompra["Tercero"], $DatosFacturaCompra["idSucursal"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["Soporte"], $VectorCuentas);
        }
        $this->ActualizaRegistro("factura_compra", "Estado", "CERRADA", "ID", $idCompra);
    }
    
    //Clase para devolver un item a una compra
    public function DevolverProductoCompra($idCompra,$idProducto,$Cantidad,$idFacturaItems,$Vector) {
        //Proceso la informacion
        $DatosFacturaItems= $this->DevuelveValores("factura_compra_items", "ID", $idFacturaItems);
        $CostoUnitario=$DatosFacturaItems["CostoUnitarioCompra"];
        $TipoIVA=$DatosFacturaItems["Tipo_Impuesto"];
        $Subtotal=round($CostoUnitario*$Cantidad);
        $Impuestos= round($Subtotal*$TipoIVA);
        $Total=$Subtotal+$Impuestos;
        //////Agrego el registro           
        $tab="factura_compra_items_devoluciones";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Agregar Un Servicio
    public function AgregueServicioCompra($idCompra,$CuentaPUC,$Concepto,$Valor,$TipoIVA,$Vector) {
        //Proceso la informacion
        $DatosCuenta= $this->DevuelveValores("subcuentas", "PUC", $CuentaPUC);
        $Impuestos=0;
        if(is_numeric($TipoIVA)){
            $Impuestos=$Valor*$TipoIVA;
        } 
        $Total=$Valor+$Impuestos;
        
        //////Agrego el registro           
        $tab="factura_compra_servicios";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="CuentaPUC_Servicio";  $Valores[1]=$CuentaPUC;
        $Columnas[2]="Nombre_Cuenta";       $Valores[2]=$DatosCuenta["Nombre"];
        $Columnas[3]="Concepto_Servicio";   $Valores[3]=$Concepto;
        $Columnas[4]="Subtotal_Servicio";   $Valores[4]=$Valor;
        $Columnas[5]="Impuesto_Servicio";   $Valores[5]=$Impuestos;
        $Columnas[6]="Total_Servicio";      $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Calcule totales de la compra
    
    public function CalculeTotalesCompra($idCompra) {
        $sql="SELECT SUM(SubtotalDescuento) as SubtotalDescuento,SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_items "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesCompraProductos=$this->FetchArray($consulta);
        
        $sql="SELECT SUM(SubtotalDescuento) as SubtotalDescuento,SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_insumos "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesCompraInsumos=$this->FetchArray($consulta);
        
        $sql="SELECT SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_items_devoluciones "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesItemsDevueltos=$this->FetchArray($consulta);
        $TotalRetenciones= $this->SumeColumna("factura_compra_retenciones", "ValorRetencion", "idCompra", $idCompra);
        
        $sql="SELECT SUM(Subtotal_Servicio) as Subtotal, sum(Impuesto_Servicio) as IVA, SUM(Total_Servicio) AS Total FROM factura_compra_servicios "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesServicios=$this->FetchArray($consulta);
        $TotalesCompra["Subtotal_Productos_Add"]=$TotalesCompraProductos["Subtotal"];
        $TotalesCompra["Impuestos_Productos_Add"]=$TotalesCompraProductos["IVA"];
        $TotalesCompra["Total_Productos_Add"]=$TotalesCompraProductos["Total"];
        $TotalesCompra["Subtotal_Descuentos_Productos_Add"]=$TotalesCompraProductos["SubtotalDescuento"];
        
        $TotalesCompra["Subtotal_Insumos"]=$TotalesCompraInsumos["Subtotal"];
        $TotalesCompra["Impuestos_Insumos"]=$TotalesCompraInsumos["IVA"];
        $TotalesCompra["Total_Insumos"]=$TotalesCompraInsumos["Total"];
        $TotalesCompra["Subtotal_Descuentos_Insumos"]=$TotalesCompraInsumos["SubtotalDescuento"];
        
        $TotalesCompra["Subtotal_Servicios"]=$TotalesServicios["Subtotal"];
        $TotalesCompra["Impuestos_Servicios"]=$TotalesServicios["IVA"];
        $TotalesCompra["Total_Servicios"]=$TotalesServicios["Total"];
        $TotalesCompra["Total_Retenciones"]=$TotalRetenciones;
        $TotalesCompra["Subtotal_Productos_Dev"]=$TotalesItemsDevueltos["Subtotal"];
        $TotalesCompra["Impuestos_Productos_Dev"]=$TotalesItemsDevueltos["IVA"];
        $TotalesCompra["Total_Productos_Dev"]=$TotalesItemsDevueltos["Total"];
        $TotalesCompra["Subtotal_Productos"]=$TotalesCompra["Subtotal_Productos_Add"]-$TotalesCompra["Subtotal_Productos_Dev"];
        $TotalesCompra["Impuestos_Productos"]=$TotalesCompra["Impuestos_Productos_Add"]-$TotalesCompra["Impuestos_Productos_Dev"];
        $TotalesCompra["Total_Productos"]=$TotalesCompra["Total_Productos_Add"]-$TotalesCompra["Total_Productos_Dev"];
        $TotalesCompra["Gran_Subtotal"]=$TotalesCompra["Subtotal_Productos"]+$TotalesCompra["Subtotal_Servicios"]+$TotalesCompra["Subtotal_Insumos"];
        $TotalesCompra["Gran_Impuestos"]=$TotalesCompra["Impuestos_Productos"]+$TotalesCompra["Impuestos_Servicios"]+$TotalesCompra["Impuestos_Insumos"];
        $TotalesCompra["Gran_Total"]=$TotalesCompra["Total_Productos"]+$TotalesCompra["Total_Servicios"]+$TotalesCompra["Total_Insumos"];
        $TotalesCompra["Total_Pago"]=$TotalesCompra["Gran_Total"]-$TotalesCompra["Total_Retenciones"];
        return($TotalesCompra);
    }
    
    //Anula una factura de compra
    
    public function AnularCompra($Fecha,$Concepto,$idCompra,$idUser) {
        $hora=date("H:i:s");
        $tab="factura_compra_anulaciones";
        $NumRegistros=5;
        $Columnas[0]="Fecha";               $Valores[0]=$Fecha;
        $Columnas[1]="Hora";                $Valores[1]=$hora;
        $Columnas[2]="Observaciones";       $Valores[2]=$Concepto;
        $Columnas[3]="idCompra";            $Valores[3]=$idCompra;
        $Columnas[4]="idUsuario";           $Valores[4]=$idUser;
                
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        $idAnulacion=$this->ObtenerMAX($tab,"ID", 1, "");
        $DocumentoInterno="FacturaCompra";
        $this->AnularMovimientoLibroDiario($DocumentoInterno, $idCompra, "");
        $this->ReverseInventarioCompra($idCompra,"Entradas");  //retiro los productos agregados
        $this->ReverseInventarioCompra($idCompra,"Devoluciones");  //retiro los productos devueltos
        $sql="UPDATE cuentasxpagar SET Saldo=0, Estado='ANULADA' WHERE Origen='factura_compra' and DocumentoCruce='$idCompra'";
        $this->Query($sql);
        $this->ActualizaRegistro("factura_compra", "Estado", "ANULADA", "ID", $idCompra);
        return $idAnulacion;
    }
    
    //Anula una una anulacion
    
    public function AnularComprobanteAnulacion($Fecha,$Concepto,$idNota,$idUser) {
        $hora=date("H:i:s");
        $tab="factura_compra_anulaciones";
        $NumRegistros=5;
        $Columnas[0]="Fecha";               $Valores[0]=$Fecha;
        $Columnas[1]="Hora";                $Valores[1]=$hora;
        $Columnas[2]="Observaciones";       $Valores[2]=$Concepto;
        $Columnas[3]="idCompra";            $Valores[3]=$idNota;
        $Columnas[4]="idUsuario";           $Valores[4]=$idUser;
                
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        $idAnulacion=$this->ObtenerMAX($tab,"ID", 1, "");
        $DocumentoInterno="NOTA_DEVOLUCION";
        $this->AnularMovimientoLibroDiario($DocumentoInterno, $idNota, "");
        //$this->ReverseInventarioCompra($idCompra,"Entradas");  //retiro los productos agregados
        $this->ReverseInventarioCompra($idNota,"Devoluciones",$idTabla='idNotaDevolucion');  //retiro los productos devueltos
        
        $this->ActualizaRegistro("factura_compra_notas_devolucion", "Estado", "ANULADA", "ID", $idNota);
        return $idAnulacion;
    }
    
    //Ingrese los items al inventario o retire items del inventario
    public function ReverseInventarioCompra($idCompra,$Proceso,$idTabla='idFacturaCompra') {
        $Detalle="FacturaCompra";
        if($idTabla=='idNotaDevolucion'){
            $Detalle="NotaDevolucion";
        }
        if($Proceso=='Entradas'){
            $Movimiento="SALIDA";
            $consulta= $this->ConsultarTabla("factura_compra_items", "WHERE idFacturaCompra='$idCompra'");
        }else{
            $Movimiento="ENTRADA";
            $consulta= $this->ConsultarTabla("factura_compra_items_devoluciones", "WHERE $idTabla='$idCompra'");
        } 
        while($DatosProductos= $this->FetchArray($consulta)){
            $DatosProductoGeneral= $this->DevuelveValores("productosventa", "idProductosVenta", $DatosProductos["idProducto"]);
            $DatosKardex["Cantidad"]=$DatosProductos["Cantidad"];
            $DatosKardex["idProductosVenta"]=$DatosProductos["idProducto"];
            $DatosKardex["CostoUnitario"]=$DatosProductos['CostoUnitarioCompra'];
            $DatosKardex["Existencias"]=$DatosProductoGeneral['Existencias'];
            $DatosKardex["Detalle"]=$Detalle;
            $DatosKardex["idDocumento"]=$idCompra;
            $DatosKardex["TotalCosto"]=$DatosProductos["Cantidad"]*$DatosProductos['CostoUnitarioCompra'];
            $DatosKardex["Movimiento"]=$Movimiento;
            $DatosKardex["CostoUnitarioPromedio"]=$DatosProductoGeneral["CostoUnitarioPromedio"];
            $DatosKardex["CostoTotalPromedio"]=$DatosProductoGeneral["CostoUnitarioPromedio"]*$DatosKardex["Cantidad"];
            $this->InserteKardex($DatosKardex);
        }
    }
    
    //Anula una factura de compra
    
    public function CopiarFacturaCompra($idCompra,$idUser,$Vector) {
        $DatosFactura= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        //////Creo la factura         
        $idCompraNew=$this->CrearCompra($DatosFactura["Fecha"], $DatosFactura["Tercero"], $DatosFactura["Observaciones"], $DatosFactura["idCentroCostos"], $DatosFactura["idSucursal"], $idUser, $DatosFactura["TipoCompra"], $DatosFactura["NumeroFactura"], $DatosFactura["Concepto"],"" );
        //Copio los items de los productos agregados
        $Datos= $this->ConsultarTabla("factura_compra_items", " WHERE idFacturaCompra='$idCompra'");
        while($DatosItems=$this->FetchArray($Datos)){
            $tab="factura_compra_items";
            $NumRegistros=8;

            $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompraNew;
            $Columnas[1]="idProducto";          $Valores[1]=$DatosItems["idProducto"];
            $Columnas[2]="Cantidad";            $Valores[2]=$DatosItems["Cantidad"];
            $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$DatosItems["CostoUnitarioCompra"];
            $Columnas[4]="SubtotalCompra";      $Valores[4]=$DatosItems["SubtotalCompra"];
            $Columnas[5]="ImpuestoCompra";      $Valores[5]=$DatosItems["ImpuestoCompra"];
            $Columnas[6]="TotalCompra";         $Valores[6]=$DatosItems["TotalCompra"];
            $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$DatosItems["Tipo_Impuesto"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        
         //Copio los items de los insumos agregados
        $Datos= $this->ConsultarTabla("factura_compra_insumos", " WHERE idFacturaCompra='$idCompra'");
        while($DatosItems=$this->FetchArray($Datos)){
            $tab="factura_compra_insumos";
            $NumRegistros=8;

            $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompraNew;
            $Columnas[1]="idProducto";          $Valores[1]=$DatosItems["idProducto"];
            $Columnas[2]="Cantidad";            $Valores[2]=$DatosItems["Cantidad"];
            $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$DatosItems["CostoUnitarioCompra"];
            $Columnas[4]="SubtotalCompra";      $Valores[4]=$DatosItems["SubtotalCompra"];
            $Columnas[5]="ImpuestoCompra";      $Valores[5]=$DatosItems["ImpuestoCompra"];
            $Columnas[6]="TotalCompra";         $Valores[6]=$DatosItems["TotalCompra"];
            $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$DatosItems["Tipo_Impuesto"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        
        //Copio los items de los productos devueltos
        $Datos= $this->ConsultarTabla("factura_compra_items_devoluciones", " WHERE idFacturaCompra='$idCompra'");
        while($DatosItems=$this->FetchArray($Datos)){
            $tab="factura_compra_items_devoluciones";
            $NumRegistros=8;

            $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompraNew;
            $Columnas[1]="idProducto";          $Valores[1]=$DatosItems["idProducto"];
            $Columnas[2]="Cantidad";            $Valores[2]=$DatosItems["Cantidad"];
            $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$DatosItems["CostoUnitarioCompra"];
            $Columnas[4]="SubtotalCompra";      $Valores[4]=$DatosItems["SubtotalCompra"];
            $Columnas[5]="ImpuestoCompra";      $Valores[5]=$DatosItems["ImpuestoCompra"];
            $Columnas[6]="TotalCompra";         $Valores[6]=$DatosItems["TotalCompra"];
            $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$DatosItems["Tipo_Impuesto"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        
        //Copio los items de los servicios
        $Datos= $this->ConsultarTabla("factura_compra_servicios", " WHERE idFacturaCompra='$idCompra'");
        while($DatosItems=$this->FetchArray($Datos)){
            //////Agrego el registro           
            $tab="factura_compra_servicios";
            $NumRegistros=8;

            $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompraNew;
            $Columnas[1]="CuentaPUC_Servicio";  $Valores[1]=$DatosItems["CuentaPUC_Servicio"];
            $Columnas[2]="Nombre_Cuenta";       $Valores[2]=$DatosItems["Nombre_Cuenta"];
            $Columnas[3]="Concepto_Servicio";   $Valores[3]=$DatosItems["Concepto_Servicio"];
            $Columnas[4]="Subtotal_Servicio";   $Valores[4]=$DatosItems["Subtotal_Servicio"];
            $Columnas[5]="Impuesto_Servicio";   $Valores[5]=$DatosItems["Impuesto_Servicio"];
            $Columnas[6]="Total_Servicio";      $Valores[6]=$DatosItems["Total_Servicio"];
            $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$DatosItems["Tipo_Impuesto"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        
        //Copio los items de los servicios
        $Datos= $this->ConsultarTabla("factura_compra_retenciones", " WHERE idCompra='$idCompra'");
        while($DatosItems=$this->FetchArray($Datos)){
            //////Agrego el registro           
            $tab="factura_compra_retenciones";
            $NumRegistros=5;

            $Columnas[0]="idCompra";            $Valores[0]=$idCompraNew;
            $Columnas[1]="CuentaPUC";           $Valores[1]=$DatosItems["CuentaPUC"];
            $Columnas[2]="NombreCuenta";        $Valores[2]=$DatosItems["NombreCuenta"];
            $Columnas[3]="ValorRetencion";      $Valores[3]=$DatosItems["ValorRetencion"];
            $Columnas[4]="PorcentajeRetenido";  $Valores[4]=$DatosItems["PorcentajeRetenido"];     

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        return($idCompraNew);
    }
    /**
     * Funcion para crear una nota de devolucion 
     * @param type $Fecha           Fecha de realizacion
     * @param type $idTercero       Tercero al que se le devuelve
     * @param type $Concepto        Concepto por el que se devuelve
     * @param type $CentroCostos    Centro de costos al que afecta
     * @param type $idSucursal      Sucursal
     * @param type $idUser          Usuario que registra la devolcuion
     * @param type $Vector          uso Futuro
     * @return type $idNota         retorna el id de la nota creada            
     */
     public function CrearNotaDevolucion($Fecha, $idTercero, $Concepto,$CentroCostos, $idSucursal, $idUser,$Vector ) {
        
        //////Creo la compra            
        $tab="factura_compra_notas_devolucion";
        $NumRegistros=7;

        $Columnas[0]="Fecha";		$Valores[0]=$Fecha;
        $Columnas[1]="Tercero";         $Valores[1]=$idTercero;
        $Columnas[2]="Concepto";        $Valores[2]=$Concepto;
        $Columnas[3]="Estado";		$Valores[3]="ABIERTA";
        $Columnas[4]="idUser";          $Valores[4]=$idUser;
        $Columnas[5]="idCentroCostos";	$Valores[5]=$CentroCostos;
        $Columnas[6]="idSucursal";	$Valores[6]=$idSucursal;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idNota=$this->ObtenerMAX($tab,"ID", 1,"");
        return $idNota;
    }
    
    /**
     * funcion para ingresar los items a la devolucion
     * @param type $idNota              id de la nota
     * @param type $idProducto          id del producto a devolver
     * @param type $Cantidad            cantidad del producto devuelto
     * @param type $CostoUnitario       Costo unitario del producto
     * @param type $TipoIVA             Tipo del iva del producto
     * @param type $IVAIncluido         Si tiene iva incluido
     * @param type $Vector              futuro
     */
    public function IngresaItemNotaDevolucion($idNota,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,$Vector) {
        //Proceso la informacion
        if($IVAIncluido=="SI"){
            if(is_numeric($TipoIVA)){
                $CostoUnitario=round($CostoUnitario/(1+$TipoIVA));
            }            
        }
        $Subtotal=round($CostoUnitario*$Cantidad);
        if(is_numeric($TipoIVA)){
            $Impuestos=round($Subtotal*$TipoIVA);
        }else{
            $Impuestos=0;
        }
        
        $Impuestos= round($Subtotal*$TipoIVA);
        $Total=$Subtotal+$Impuestos;
        //////Agrego el registro           
        $tab="factura_compra_items_devoluciones";
        $NumRegistros=8;

        $Columnas[0]="idNotaDevolucion";    $Valores[0]=$idNota;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    /**
     * Funcion para guardar una nota de devolucion
     * @param type $idNota -> id de la nota
     * @param type $Vector -> Futuro
     */
    public function GuardarNotaDevolucion($idNota,$Vector) {
       
        $DatosNota= $this->DevuelveValores("factura_compra_notas_devolucion", "ID", $idNota);
        $DatosTercero=$this->DevuelveValores("proveedores", "Num_Identificacion", $DatosNota["Tercero"]);
        $sql="SELECT SUM(SubtotalCompra) as Subtotal, SUM(ImpuestoCompra) as IVA,SUM(TotalCompra) as Total "
                . " FROM factura_compra_items_devoluciones WHERE idNotaDevolucion='$idNota' AND idNotaDevolucion<>'0'";
        $consulta=$this->Query($sql);
        $DatosTotalesNota= $this->FetchArray($consulta);
        
        if($DatosTotalesNota["Total"]>0){  //Si tenemos totales
            
            //Se arma el SQL para el subtotal en la cuenta de inventarios inventarios
            $Parametros=$this->DevuelveValores("parametros_contables", "ID", 4); //Datos de la cuenta de inventarios
            $CuentaPUC=$Parametros["CuentaPUC"];
            $NombreCuenta=$Parametros["NombreCuenta"];
            $Tabla="librodiario";
            
            $Datos["Fecha"]=$DatosNota["Fecha"];
            $Datos["Tipo_Documento_Intero"]="NOTA_DEVOLUCION";
            $Datos["Num_Documento_Interno"]=$idNota;
            $Datos["Num_Documento_Externo"]="";
            $Datos["Tercero_Tipo_Documento"]=$DatosTercero["Tipo_Documento"];
            $Datos["Tercero_Identificacion"]=$DatosTercero["Num_Identificacion"];
            $Datos["Tercero_DV"]=$DatosTercero["DV"];
            $Datos["Tercero_Primer_Apellido"]=$DatosTercero["Primer_Apellido"];
            $Datos["Tercero_Segundo_Apellido"]=$DatosTercero["Segundo_Apellido"];
            $Datos["Tercero_Primer_Nombre"]=$DatosTercero["Primer_Nombre"];
            $Datos["Tercero_Otros_Nombres"]=$DatosTercero["Otros_Nombres"];
            $Datos["Tercero_Razon_Social"]=$DatosTercero["RazonSocial"];
            $Datos["Tercero_Direccion"]=$DatosTercero["Direccion"];
            $Datos["Tercero_Cod_Dpto"]=$DatosTercero["Cod_Dpto"];
            $Datos["Tercero_Cod_Mcipio"]=$DatosTercero["Cod_Mcipio"];
            $Datos["Tercero_Pais_Domicilio"]=$DatosTercero["Pais_Domicilio"];
            $Datos["Concepto"]="Devolucion de mercancia";
            $Datos["CuentaPUC"]=$CuentaPUC;
            $Datos["NombreCuenta"]=$NombreCuenta;
            $Datos["Detalle"]="Nota $idNota";
            $Datos["Debito"]=0;
            $Datos["Credito"]=$DatosTotalesNota["Subtotal"];
            $Datos["Neto"]=$Datos["Credito"]*(-1);
            $Datos["idCentroCosto"]=$DatosNota["idCentroCostos"];
            $Datos["idEmpresa"]=1;
            $Datos["idSucursal"]=$DatosNota["idSucursal"];
            $Datos["idUsuario"]=$DatosNota["idUser"];

            $sql=$this->getSQLInsert($Tabla, $Datos);
            $this->Query($sql);
            //Se arma el SQL para el iva de acuerdo a cada tipo
            if($DatosTotalesNota["IVA"]>0){
                $sql_items="SELECT Tipo_Impuesto,SUM(ImpuestoCompra) as IVA FROM factura_compra_items_devoluciones WHERE idNotaDevolucion='$idNota' AND idNotaDevolucion<>'0' "
                        . "GROUP BY Tipo_Impuesto";
                $consulta = $this->Query($sql_items);
                while($DatosIVAItems= $this->FetchArray($consulta)){
                    
                    if($DatosIVAItems["IVA"]>0){
                        $DatosIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosIVAItems["Tipo_Impuesto"]);
                        $Datos["CuentaPUC"]=$DatosIVA["CuentaPUC"];
                        $Datos["NombreCuenta"]=$DatosIVA["NombreCuenta"];
                        $Datos["Credito"]=$DatosIVAItems["IVA"];
                        $Datos["Neto"]=$Datos["Credito"]*(-1);
                        $sql=$this->getSQLInsert($Tabla, $Datos);
                        $this->Query($sql);
                    }
                    
                }
            }
            //Se arma el SQL para para la contrapartida a la cuenta de proveedores
            $Parametros=$this->DevuelveValores("parametros_contables", "ID", 14); //Cuentas X pagar proveedores
            $Datos["CuentaPUC"]=$Parametros["CuentaPUC"];
            $Datos["NombreCuenta"]=$Parametros["NombreCuenta"];
            $Datos["Debito"]=$DatosTotalesNota["Total"];
            $Datos["Credito"]=0;
            $Datos["Neto"]=$DatosTotalesNota["Total"];
            $sql=$this->getSQLInsert($Tabla, $Datos);
            $this->Query($sql);
         
            $this->IngreseRetireProductosInventarioCompra($idNota,"SALIDA","idNotaDevolucion");  //Retiro los productos del inventario
           
        }
        
        $this->ActualizaRegistro("factura_compra_notas_devolucion", "Estado", "CERRADA", "ID", $idNota);
    }
    /**
     * Funcion para crear un traslado desde una compra
     * @param type $idCompra -> id de la compra de donde se va a realizar el traslado
     * @param type $Vector ->Futuro
     */
    public function CrearTrasladoDesdeCompra($idCompra,$idSede,$Vector) {
        $DatosCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $VectorTraslado["idBodega"]=1;
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $Concepto="FC_$idCompra";
        $Destino=$idSede;        
        $Consulta=$this->ConsultarTabla("factura_compra_items", "WHERE idFacturaCompra='$idCompra'");
        if($this->NumRows($Consulta)){
            $idTraslado=$this->CrearTraslado($fecha, $hora, $Concepto, $Destino, $VectorTraslado);
            while($ItemsCompra=$this->FetchArray($Consulta)){
                $this->AgregarItemTraslado($idTraslado, $ItemsCompra["idProducto"], $ItemsCompra["Cantidad"], "");
            }
            return($idTraslado);
        }else{
            return("ENI"); //No Items en la factura de compra
        }
        
    }
    /**
     * Funcion para crear una orden de compra
     * @param type $Fecha
     * @param type $Tercero
     * @param type $Descripcion
     * @param type $PlazoEntrega -> Plazo expresado en dias
     * @param type $NoCotizacion
     * @param type $Condiciones
     * @param type $Solicitante
     * @param type $Cargo
     * @param type $idUser
     * @param type $Vector
     * @return type
     */
    public function CrearOrdenCompra($Fecha,$Tercero,$Descripcion,$PlazoEntrega,$NoCotizacion,$Condiciones,$Solicitante,$Cargo,$idUser,$Vector) {
        $tab="ordenesdecompra";
        $Datos["Fecha"]=$Fecha;
        $Datos["Tercero"]=$Tercero;
        $Datos["Descripcion"]=$Descripcion;
        $Datos["PlazoEntrega"]=$PlazoEntrega;
        $Datos["NoCotizacion"]=$NoCotizacion;
        $Datos["Condiciones"]=$Condiciones;
        $Datos["Solicitante"]=$Solicitante;
        $Datos["Cargo"]=$Cargo;
        $Datos["UsuarioCreador"]=$idUser;
        $Datos["Estado"]="ABIERTA";
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
        $idCompra=$this->ObtenerMAX($tab,"ID", 1,"");
        return $idCompra;
    }
    
    public function IngresaItemOrdenCompra($idOrden,$idProducto,$Referencia,$Nombre,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,$Vector) {
        //Proceso la informacion
        if($IVAIncluido=="SI"){
            if(is_numeric($TipoIVA)){
                $CostoUnitario=round($CostoUnitario/(1+$TipoIVA));
            }            
        }
        $Subtotal=round($CostoUnitario*$Cantidad);
        if(is_numeric($TipoIVA)){
            $Impuestos=round($Subtotal*$TipoIVA);
        }else{
            $Impuestos=0;
        }
        
        $Impuestos= round($Subtotal*$TipoIVA);
        $Total=$Subtotal+$Impuestos;
        $sql="SELECT * FROM ordenesdecompra_items WHERE NumOrden='$idOrden' AND idProducto='$idProducto'";
        $Consulta=$this->Query($sql);
        $DatosItem=$this->FetchAssoc($Consulta);
        if($DatosItem==''){
            //////Agrego el registro           
            $tab="ordenesdecompra_items";
            $NumRegistros=10;

            $Columnas[0]="NumOrden";        $Valores[0]=$idOrden;
            $Columnas[1]="idProducto";      $Valores[1]=$idProducto;
            $Columnas[2]="Cantidad";        $Valores[2]=$Cantidad;
            $Columnas[3]="ValorUnitario";   $Valores[3]=$CostoUnitario;
            $Columnas[4]="Subtotal";        $Valores[4]=$Subtotal;
            $Columnas[5]="IVA";             $Valores[5]=$Impuestos;
            $Columnas[6]="Total";           $Valores[6]=$Total;
            $Columnas[7]="Tipo_Impuesto";   $Valores[7]=$TipoIVA;
            $Columnas[8]="Referencia";      $Valores[8]=$Referencia;  
            $Columnas[9]="Descripcion";     $Valores[9]=$Nombre;   
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }else{
            $idItem=$DatosItem["ID"];
            $sql="UPDATE ordenesdecompra_items SET Cantidad=Cantidad+$Cantidad, Subtotal=ValorUnitario*Cantidad,"
                    . "IVA=round(Subtotal*Tipo_Impuesto),Total=Subtotal+IVA WHERE ID='$idItem'";
            $this->Query($sql);
        }
    }
    
    //Clase para agregar un item a una compra
    public function AgregueItemDesdeOrdenCompra($idCompra,$idOrdenCompra,$Vector) {
        $sql="SELECT * FROM ordenesdecompra_items WHERE NumOrden='$idOrdenCompra'";
        $Consulta=$this->Query($sql);
        //////Agrego el registro           
        $tab="factura_compra_items";
        $NumRegistros=8;
        while($DatosOC=$this->FetchAssoc($Consulta)){
            $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
            $Columnas[1]="idProducto";          $Valores[1]=$DatosOC["idProducto"];
            $Columnas[2]="Cantidad";            $Valores[2]=$DatosOC["Cantidad"];
            $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$DatosOC["ValorUnitario"];
            $Columnas[4]="SubtotalCompra";      $Valores[4]=$DatosOC["Subtotal"];
            $Columnas[5]="ImpuestoCompra";      $Valores[5]=$DatosOC["IVA"];
            $Columnas[6]="TotalCompra";         $Valores[6]=$DatosOC["Total"];
            $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$DatosOC["Tipo_Impuesto"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
        }
        
        

        
    }
    //Fin Clases
}