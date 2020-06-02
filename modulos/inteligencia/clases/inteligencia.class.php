<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
class Inteligencia extends ProcesoVenta{
    
    
    function crearVistaProductosPorCliente($FechaInicial,$FechaFinal){
        $sql="DROP VIEW IF EXISTS `vista_productos_x_cliente`;";
        $this->Query($sql);
        
        $sql="CREATE VIEW vista_productos_x_cliente AS 
                SELECT t1.ID,t1.Referencia,t1.Nombre,t1.FechaFactura,SUM(t1.Cantidad) as Cantidad, SUM(t1.TotalItem) as TotalItem,
                t2.Clientes_idClientes as idCliente, t3.RazonSocial,t3.Num_Identificacion             
                
                FROM facturas_items t1 INNER JOIN facturas t2 ON t1.idFactura=t2.idFacturas INNER JOIN clientes t3 ON t2.Clientes_idClientes=t3.idClientes 
                
                WHERE FechaFactura>='$FechaInicial' AND FechaFactura<='$FechaFinal' GROUP BY Referencia;
                    
           ";
        $this->Query($sql);
    }
    /**
     * Fin Clase
     */
}
