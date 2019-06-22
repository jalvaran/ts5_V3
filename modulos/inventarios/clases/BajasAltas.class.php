<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
include_once 'Recetas.class.php';
class BajasAltas extends ProcesoVenta{
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
    public function CrearComprobante($Fecha, $Observaciones, $idUser,$Vector ) {
        $tab="inventario_comprobante_movimientos";
        $Datos["Fecha"]=$Fecha;
        $Datos["Observaciones"]=$Observaciones;
        $Datos["idUser"]=$idUser;
        $Datos["Estado"]="ABIERTO";
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
        $idComprobante=$this->ObtenerMAX($tab,"ID", 1,"");
        
        return $idComprobante;
    }
    /**
     * Agrega un item
     * @param type $idProducto
     * @param type $TablaOrigen
     * @param type $Cantidad
     * @param type $TipoMovimiento
     * @param type $Vector
     */
    public function AgregarItem($idComprobante,$idProducto, $TablaOrigen, $Cantidad,$TipoMovimiento,$Vector ) {
        $tab="inventario_comprobante_movimientos_items";
        $Datos["idProducto"]=$idProducto;
        $Datos["TablaOrigen"]=$TablaOrigen;
        $Datos["Cantidad"]=$Cantidad;
        $Datos["TipoMovimiento"]=$TipoMovimiento;
        $Datos["idComprobante"]=$idComprobante;
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
        
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
    
    /**
     * Fin Clase
     */
}
