<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
include_once 'Recetas.class.php';
class Inventarios extends ProcesoVenta{
    
    public function InventariosCrearProductoVenta($Fecha, $Observaciones, $idUser,$Vector ) {
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
        $idTabla="ID";
        if($TablaOrigen=="productosventa"){
            $idTabla="idProductosVenta";
        }
        
        $DatosProducto=$this->DevuelveValores($TablaOrigen, $idTabla, $idProducto);
        $tab="inventario_comprobante_movimientos_items";
        $Datos["idProducto"]=$idProducto;
        $Datos["TablaOrigen"]=$TablaOrigen;
        $Datos["Cantidad"]=$Cantidad;
        $Datos["CostoUnitario"]=$DatosProducto["CostoUnitario"];
        $Datos["CostoTotal"]=$DatosProducto["CostoUnitario"]*$Cantidad;
        $Datos["TipoMovimiento"]=$TipoMovimiento;
        $Datos["idComprobante"]=$idComprobante;
        $sql=$this->getSQLInsert($tab, $Datos);
        
        $this->Query($sql);
        
    }
    
    //Ingrese los items al inventario o retire items del inventario
    public function RealizarMovimientosInventario($idComprobante,$idUser) {
        $obInsumos=new Recetas(1);
        $DatosComprobante=$this->DevuelveValores("inventario_comprobante_movimientos", "ID", $idComprobante);
        $DatosEmpresaPro=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
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
                $idProductoVenta=$DatosProductos["idProducto"];
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
                /*
                $TotalCosto=$DatosProductos["Cantidad"]*$DatosProductoGeneral['CostoUnitario'];
                $DatosParametros= $this->DevuelveValores("parametros_contables", "ID", 4);
                $CuentaInventarios=$DatosParametros["CuentaPUC"];
                $NombreCuentaInventarios=$DatosParametros["NombreCuenta"];
                $DatosParametros= $this->DevuelveValores("parametros_contables", "ID", 3);
                $CuentaBajas=$DatosParametros["CuentaPUC"];
                $DatosParametros= $this->DevuelveValores("parametros_contables", "ID", 5);
                $CuentaAltas=$DatosParametros["CuentaPUC"];
                $NombreCuentaAltas=$DatosParametros["NombreCuenta"];
                if($DatosProductos["TipoMovimiento"]=="ALTA"){
                    //print("Entra Alta");
                    $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteMovimientosInventario", $idComprobante,$idComprobante , $DatosEmpresaPro["NIT"], $CuentaInventarios, $NombreCuentaInventarios, "Movimiento en Inventario $Movimiento", "DB", $TotalCosto, $DatosComprobante["Observaciones"], 1, 1, "");
                    $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteMovimientosInventario", $idComprobante,$idComprobante , $DatosEmpresaPro["NIT"], $CuentaAltas, $NombreCuentaAltas, "Movimiento en Inventario $Movimiento", "CR", $TotalCosto, $DatosComprobante["Observaciones"], 1, 1, "");
                }
                if($DatosProductos["TipoMovimiento"]=="BAJA"){
                    //print("Entra Baja");
                    $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteMovimientosInventario", $idComprobante,$idComprobante , $DatosEmpresaPro["NIT"], $CuentaInventarios, $NombreCuentaInventarios, "Movimiento en Inventario $Movimiento", "CR", $TotalCosto, $DatosComprobante["Observaciones"], 1, 1, "");
                    $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteMovimientosInventario", $idComprobante,$idComprobante , $DatosEmpresaPro["NIT"], $CuentaAltas, $NombreCuentaAltas, "Movimiento en Inventario $Movimiento", "DB", $TotalCosto,$DatosComprobante["Observaciones"], 1, 1, "");
                }
                 * 
                 */
            }
            
            if($DatosProductos["TablaOrigen"]=='insumos'){
                $DatosProductoGeneral= $this->DevuelveValores("insumos", "ID", $DatosProductos["idProducto"]);
            
                $obInsumos->KardexInsumo($Movimiento, $Detalle, $idComprobante, $DatosProductoGeneral["Referencia"], $DatosProductos["Cantidad"], $DatosProductoGeneral["CostoUnitario"], "");
            }
            
            $this->ActualizaRegistro("inventario_comprobante_movimientos_items", "Estado", "KARDEX", "ID", $idItem);
            
        }
        
          
        
    }
    
    
    function crearVistaSeparados(){
        $sql="DROP VIEW IF EXISTS `vista_separados_reportes`;";
        $this->Query($sql);
                
        $sql="CREATE VIEW vista_separados_reportes AS 
                SELECT t1.*,t2.RazonSocial,t2.Num_Identificacion,t2.Telefono,t2.Direccion,          
                (SELECT DATE_ADD(t1.Fecha, INTERVAL 2 MONTH) ) as FechaVencimiento 
                FROM separados t1 INNER JOIN clientes t2 ON t1.idCliente=t2.idClientes 
                
                ;
                    
           ";
        $this->Query($sql);
    }
    
    /**
     * Fin Clase
     */
}
