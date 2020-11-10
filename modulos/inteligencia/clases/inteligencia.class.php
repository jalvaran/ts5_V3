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
        
        $sql="CREATE VIEW vista_productos_x_cliente AS 
                SELECT t1.ID,t1.Referencia,t1.Nombre,t1.FechaFactura,SUM(t1.Cantidad) as Cantidad, SUM(t1.TotalItem) as TotalItem,
                (SELECT Clientes_idClientes FROM facturas t2 WHERE t2.idFacturas=t1.idFactura LIMIT 1) AS idCliente,
                (SELECT FormaPago FROM facturas t2 WHERE t2.idFacturas=t1.idFactura LIMIT 1) AS FormaPago,
                (SELECT RazonSocial FROM clientes t3 WHERE t3.idClientes=(SELECT idCliente) LIMIT 1) AS RazonSocial,
                (SELECT Num_Identificacion FROM clientes t3 WHERE t3.idClientes=(SELECT idCliente) LIMIT 1) AS Num_Identificacion 
                     
                
                FROM facturas_items t1  
                
                WHERE FechaFactura>='$FechaInicial' AND FechaFactura<='$FechaFinal' GROUP BY FormaPago,Referencia,idCliente;
                    
           ";
        $this->Query($sql);
    }
    /**
     * Fin Clase
     */
}
