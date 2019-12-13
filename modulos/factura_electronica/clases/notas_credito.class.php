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
    //Fin Clases
}
