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
    
    public function CrearNotaCredito($idFactura,$TxtFecha,$TxtObservaciones,$idUser) {
        $Datos["idFactura"]=$idFactura;
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
    
    public function AgregarItemANotaCredito($idNota,$idItemFactura,$Cantidad,$idUser) {
        
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
        $Datos["idNotaCredito"]=$idNota;        
        $Datos["idUser"]=$idUser;
        $Datos["Created"]=date("Y-m-d H:i:s");
                
        $sql= $this->getSQLInsert("notas_credito_items", $Datos);
        $this->Query($sql);
        return("OK");
    }
    
    public function ContabilizarNotaCredito($idNota) {
        
        $DatosNota= $this->DevuelveValores("notas_credito", "ID", $idNotas);
        $DatosFactura= $this->DevuelveValores("facturas", "idFacturas", $DatosNota["idFacturas"]);
        $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosNota["Clientes_idClientes"]);
        $Parametros=$this->DevuelveValores("parametros_contables", "ID", 9);
        $CuentaDevolucion=$Parametros["CuentaPUC"];
        $NombreCuentaDevolucion=$Parametros["NombreCuenta"];
        $sql="SELECT SUM(SubtotalItem) AS SubtotalItem,SUM(IVAItem) AS IVAItem,SUM(TotalItem) AS TotalItem,
                SUM(SubtotalCosto) AS SubtotalCosto 
                FROM notas_credito_items WHERE idNotaCredito='$idNota'";
        $Totales= $this->FetchAssoc($this->Query($sql));
        
        
        $this->IngreseMovimientoLibroDiario($DatosNota["Fecha"], "NOTA_CREDITO", $idNota, $DatosFactura["NumeroFactura"], $DatosCliente["Num_Identificacion"], $CuentaDevolucion, $NombreCuentaDevolucion, "Nota credito Factura ".$DatosFactura["NumeroFactura"], "DB", $Totales["SubtotalItem"], $DatosNota["Observacion"], $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        if($Totales["IVAItem"]<>0){
            $this->IngreseMovimientoLibroDiario($DatosNota["Fecha"], "NOTA_CREDITO", $idNota, $DatosFactura["NumeroFactura"], $DatosCliente["Num_Identificacion"], $CuentaDevolucion, $NombreCuentaDevolucion, "Nota credito Factura ".$DatosFactura["NumeroFactura"], "DB", $Totales["IVAItem"], $DatosNota["Observacion"], $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        }
        
        if($DatosFactura["FormaPago"]=='Contado'){
            $Parametros=$this->DevuelveValores("parametros_contables", "ID", 21); //Caja General
            $CuentaDevolucion=$Parametros["CuentaPUC"];
            $NombreCuentaDevolucion=$Parametros["NombreCuenta"];
            $this->IngreseMovimientoLibroDiario($DatosNota["Fecha"], "NOTA_CREDITO", $idNota, $DatosFactura["NumeroFactura"], $DatosCliente["Num_Identificacion"], $CuentaDevolucion, $NombreCuentaDevolucion, "Nota credito Factura ".$DatosFactura["NumeroFactura"], "CR", $Totales["TotalItem"], $DatosNota["Observacion"], $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        }else{
            $Parametros=$this->DevuelveValores("parametros_contables", "ID", 6); //Clientes
            $CuentaDevolucion=$Parametros["CuentaPUC"];
            $NombreCuentaDevolucion=$Parametros["NombreCuenta"];
            $this->IngreseMovimientoLibroDiario($DatosNota["Fecha"], "NOTA_CREDITO", $idNota, $DatosFactura["NumeroFactura"], $DatosCliente["Num_Identificacion"], $CuentaDevolucion, $NombreCuentaDevolucion, "Nota credito Factura ".$DatosFactura["NumeroFactura"], "CR", $Totales["TotalItem"], $DatosNota["Observacion"], $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        }
        
    }
    
    //Fin Clases
}
