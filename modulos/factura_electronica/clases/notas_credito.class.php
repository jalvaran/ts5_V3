<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
/* 
 * Clase donde se realizaran procesos para construir recetas
 * Julian Alvaran
 * Techno Soluciones SAS
 * 2018-09-26
 */
        
class NotasCredito extends ProcesoVenta{
    
    public function CrearNotaCredito($idFactura,$idFacturaElectronica,$TxtFecha,$TxtObservaciones,$idUser) {
        $Datos["idFactura"]=$idFactura;
        $Datos["idFacturaElectronica"]=$idFacturaElectronica;
        $Datos["Fecha"]=$TxtFecha;
        $Datos["Observaciones"]=$TxtObservaciones;
        $Datos["idUser"]=$idUser;        
        $Datos["Estado"]=0;
        $Datos["Created"]=date("Y-m-d H:i:s");
                
        $sql= $this->getSQLInsert("notas_credito", $Datos);
        $this->Query($sql);
        $ID= $this->ObtenerMAX("notas_credito", "ID", 1, "");
        return($ID);
    }
    
    public function AgregarItemANotaCredito($idFacturaElectronica,$idItemFactura,$Cantidad,$idUser) {
        
        $sql="SELECT TablaItems,Referencia,Nombre,ValorUnitarioItem,Cantidad,Dias,
                SubtotalItem,IVAItem,ValorOtrosImpuestos,TotalItem,PorcentajeIVA,
                idOtrosImpuestos,idPorcentajeIVA,PrecioCostoUnitario,SubtotalCosto,
                TipoItem,CuentaPUC FROM facturas_items WHERE ID='$idItemFactura'";
        $Datos= $this->FetchAssoc($this->Query($sql));
        if($Cantidad<>$Datos["Cantidad"]){
            $Datos["Cantidad"]=$Cantidad;
            $Datos["SubtotalItem"]=$Cantidad*$Datos["ValorUnitarioItem"];
            $PorcentajeIVA= str_replace("%", "", $Datos["PorcentajeIVA"]);
            $PorcentajeIVA=$PorcentajeIVA/100;
            $Datos["IVAItem"]=round($PorcentajeIVA*$Datos["SubtotalItem"],2);        
            $Datos["TotalItem"]=$Datos["SubtotalItem"]+$Datos["IVAItem"];
            $Datos["SubtotalCosto"]=$Datos["SubtotalCosto"]*$Cantidad;
        }
        $Datos["idItemFactura"]=$idItemFactura;  
        $Datos["idFacturaElectronica"]=$idFacturaElectronica;        
        $Datos["idUser"]=$idUser;
        $Datos["Created"]=date("Y-m-d H:i:s");
                
        $sql= $this->getSQLInsert("notas_credito_items", $Datos);
        $this->Query($sql);
        return("OK");
    }
    
    public function ContabilizarNotaCredito($idNota) {
        
        $DatosNota= $this->DevuelveValores("notas_credito", "ID", $idNota);
        $DatosFactura= $this->DevuelveValores("facturas", "idFacturas", $DatosNota["idFactura"]);
        $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $Parametros=$this->DevuelveValores("parametros_contables", "ID", 9); //Devolucion en ventas
        $CuentaDevolucion=$Parametros["CuentaPUC"];
        $NombreCuentaDevolucion=$Parametros["NombreCuenta"];
        $sql="SELECT SUM(SubtotalItem) AS SubtotalItem,SUM(IVAItem) AS IVAItem,SUM(TotalItem) AS TotalItem,
                SUM(SubtotalCosto) AS SubtotalCosto 
                FROM notas_credito_items WHERE idNotaCredito='$idNota'";
        $Totales= $this->FetchAssoc($this->Query($sql));
        
        
        $this->IngreseMovimientoLibroDiario($DatosNota["Fecha"], "NOTA_CREDITO", $idNota, $DatosFactura["NumeroFactura"], $DatosCliente["Num_Identificacion"], $CuentaDevolucion, $NombreCuentaDevolucion, "Nota credito Factura ".$DatosFactura["NumeroFactura"], "DB", $Totales["SubtotalItem"], $DatosNota["Observaciones"], $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        if($Totales["IVAItem"]<>0){
            $Parametros=$this->DevuelveValores("parametros_contables", "ID", 33); //Devolucion de IVA
            $CuentaDevolucionIVA=$Parametros["CuentaPUC"];
            $NombreCuentaDevolucionIVA=$Parametros["NombreCuenta"];
            $this->IngreseMovimientoLibroDiario($DatosNota["Fecha"], "NOTA_CREDITO", $idNota, $DatosFactura["NumeroFactura"], $DatosCliente["Num_Identificacion"], $CuentaDevolucionIVA, $NombreCuentaDevolucionIVA, "Nota credito Factura ".$DatosFactura["NumeroFactura"], "DB", $Totales["IVAItem"], $DatosNota["Observaciones"], $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        }
        
        if($DatosFactura["FormaPago"]=='Contado'){
            $Parametros=$this->DevuelveValores("parametros_contables", "ID", 21); //Caja General
            $CuentaDevolucion=$Parametros["CuentaPUC"];
            $NombreCuentaDevolucion=$Parametros["NombreCuenta"];
            $this->IngreseMovimientoLibroDiario($DatosNota["Fecha"], "NOTA_CREDITO", $idNota, $DatosFactura["NumeroFactura"], $DatosCliente["Num_Identificacion"], $CuentaDevolucion, $NombreCuentaDevolucion, "Nota credito Factura ".$DatosFactura["NumeroFactura"], "CR", $Totales["TotalItem"], $DatosNota["Observaciones"], $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        }else{
            $Parametros=$this->DevuelveValores("parametros_contables", "ID", 6); //Clientes
            $CuentaDevolucion=$Parametros["CuentaPUC"];
            $NombreCuentaDevolucion=$Parametros["NombreCuenta"];
            $this->IngreseMovimientoLibroDiario($DatosNota["Fecha"], "NOTA_CREDITO", $idNota, $DatosFactura["NumeroFactura"], $DatosCliente["Num_Identificacion"], $CuentaDevolucion, $NombreCuentaDevolucion, "Nota credito Factura ".$DatosFactura["NumeroFactura"], "CR", $Totales["TotalItem"], $DatosNota["Observaciones"], $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        }
        
    }
    
    //Fin Clases
}
