<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
class Inteligencia extends ProcesoVenta{
    
    
    function crearVistaProductosPorCliente($FechaInicial,$FechaFinal){
        $sql="DROP VIEW IF EXISTS `vista_productos_x_cliente`;";
        $this->Query($sql);
        $sql="DROP VIEW IF EXISTS `vista_facturas_x_cliente`;";
        $this->Query($sql);
        
        $sql="CREATE VIEW vista_productos_x_cliente AS 
                SELECT t1.ID,t1.Referencia,t1.Nombre,t1.FechaFactura,SUM(t1.Cantidad) as Cantidad, SUM(t1.TotalItem) as TotalItem,
                t2.Clientes_idClientes as idCliente, t3.RazonSocial,t3.Num_Identificacion,t3.created as fecha_creacion_cliente              
                
                FROM facturas_items t1 INNER JOIN facturas t2 ON t1.idFactura=t2.idFacturas INNER JOIN clientes t3 ON t2.Clientes_idClientes=t3.idClientes 
                
                WHERE FechaFactura>='$FechaInicial' AND FechaFactura<='$FechaFinal' GROUP BY Referencia;
                    
           ";
        
        $sql="CREATE VIEW vista_productos_x_cliente AS 
                SELECT t1.ID,t1.Referencia,t1.Nombre,t1.FechaFactura,SUM(t1.Cantidad) as Cantidad, SUM(t1.TotalItem) as TotalItem,
                (SELECT Clientes_idClientes FROM facturas t2 WHERE t2.idFacturas=t1.idFactura LIMIT 1) AS idCliente,
                (SELECT FormaPago FROM facturas t2 WHERE t2.idFacturas=t1.idFactura LIMIT 1) AS FormaPago,
                (SELECT RazonSocial FROM clientes t3 WHERE t3.idClientes=(SELECT idCliente) LIMIT 1) AS RazonSocial,
                (SELECT Num_Identificacion FROM clientes t3 WHERE t3.idClientes=(SELECT idCliente) LIMIT 1) AS Num_Identificacion, 
                (SELECT created FROM clientes t3 WHERE t3.idClientes=(SELECT idCliente) LIMIT 1) AS fecha_creacion_cliente       
                
                FROM facturas_items t1  
                
                WHERE FechaFactura>='$FechaInicial' AND FechaFactura<='$FechaFinal' GROUP BY FormaPago,Referencia,idCliente;
                    
           ";
        $this->Query($sql);
        
        $sql="CREATE VIEW vista_facturas_x_cliente AS 
                SELECT t1.*,
                (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=t1.Clientes_idClientes LIMIT 1) AS RazonSocial,
                (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=t1.Clientes_idClientes LIMIT 1) AS Num_Identificacion,
                (SELECT Created FROM clientes t2 WHERE t2.idClientes=t1.Clientes_idClientes LIMIT 1) AS fecha_creacion_cliente 
                
                FROM facturas t1  
                
                WHERE t1.Fecha>='$FechaInicial' AND t1.Fecha<='$FechaFinal' ;
                    
           ";
        $this->Query($sql);
    }
    
    public function obtener_cumplimiento_metas($fecha_inicial,$fecha_final,$ano_actual='') {
        if($ano_actual==''){
            $ano_actual=date("Y");
        }
        $ano_actual=substr($fecha_inicial, 0,4);
        //$mes_actual=date("n");
        $mes_actual=substr($fecha_inicial, 5,2);
        $mes_actual=ltrim($mes_actual, "0");
        $total_dias_mes=date("t",strtotime($fecha_inicial));
        $dia_actual=date("d",strtotime($fecha_final));
        $sql="SELECT * FROM metas_ventas WHERE Anio='$ano_actual'";
        $consulta=$this->Query($sql);
        $datos_metas=[];
        while($datos_consulta=$this->FetchAssoc($consulta)){
            $mes=$datos_consulta["Mes"];
            $datos_metas[$mes]["meta"]=$datos_consulta["Meta"];
            $datos_metas[$mes]["frase"]=$datos_consulta["Frase"];
        }
        if(!isset($datos_metas[$mes_actual]["frase"])){
            $datos_metas["frase_mes_actual"]="";
        }else{
            $datos_metas["frase_mes_actual"]=$datos_metas[$mes_actual]["frase"];
        }
        
        $fecha_actual=date("Y-m-d");
        $sql="SELECT SUM(Total) as Total, FormaPago FROM facturas WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' AND FormaPago<>'ANULADA' GROUP BY  FormaPago ";
        
        $Consulta=$this->Query($sql);
        $ventas_rango=[];
        $total_ventas_rango=0;
        while($datos_consulta=$this->FetchAssoc($Consulta)){
            $total_ventas_rango=$total_ventas_rango+$datos_consulta["Total"];
            $tipo_factura=$datos_consulta["FormaPago"];
            $ventas_rango[$tipo_factura]=$datos_consulta["Total"];
            
        }
        $datos_metas["total_ventas_rango"]= $total_ventas_rango;
        $datos_metas["ventas_rango"]=$ventas_rango;
        
        $fecha_inicial_ano=$ano_actual."-01-01";
        $fecha_final_ano=$ano_actual."-12-31";
        $sql="SELECT SUM(Total) as Total, FormaPago,SUBSTRING(Fecha,6,2) as Mes FROM facturas WHERE Fecha>='$fecha_inicial_ano' AND Fecha<='$fecha_final_ano' AND FormaPago<>'ANULADA' GROUP BY  FormaPago,SUBSTRING(Fecha,6,2) ";
        $Consulta=$this->Query($sql);
        $ventas_ano=[];
        $total_ventas_ano=0;
        for ($i=1;$i<=12;$i++){
            $ventas_ano[$i]["total_venta_mes"]=0;
        }
        
        while($datos_consulta=$this->FetchAssoc($Consulta)){
            $total_ventas_ano=$total_ventas_ano+$datos_consulta["Total"];
            $mes_ano= ltrim($datos_consulta["Mes"], "0");
            $tipo_factura=$datos_consulta["FormaPago"];
            $ventas_ano[$mes_ano][$tipo_factura]=$datos_consulta["Total"];            
            $ventas_ano[$mes_ano]["total_venta_mes"]=$ventas_ano[$mes_ano]["total_venta_mes"]+$datos_consulta["Total"];
        }
        $datos_metas["total_ventas_anio"]= $total_ventas_ano;
        $datos_metas["ventas_anio"]= $ventas_ano;
        $mes_actual_meta=str_pad($mes_actual, 2, "0", STR_PAD_LEFT);
        $ano_mes_consulta=$ano_actual."-".$mes_actual_meta;
        
        $ano_mes_consulta_inicial=$ano_actual."-".$mes_actual_meta.'-01';
        $sql="SELECT SUM(Total) as Total FROM facturas WHERE Fecha LIKE '$ano_mes_consulta%' AND FormaPago<>'ANULADA' ";
        
        $array_ventas_ano_mes=$this->FetchAssoc($this->Query($sql));
        $datos_metas["cumplimiento_mes_actual"]= $array_ventas_ano_mes["Total"];
        $datos_metas["cumplimiento_mes_meta"]= $datos_metas[$mes_actual]["meta"];
        
        $sql="SELECT SUM(Total) as Total FROM facturas WHERE Fecha >= '$ano_mes_consulta_inicial' AND Fecha <= '$fecha_final' AND FormaPago<>'ANULADA' ";
        
        $array_ventas_ano_mes_dia=$this->FetchAssoc($this->Query($sql));
        
        $datos_metas["cumplimiento_dia_actual"]= $array_ventas_ano_mes_dia["Total"];
        
        $datos_metas["cumplimiento_dia_meta"]= round(($datos_metas[$mes_actual]["meta"]/$total_dias_mes)*$dia_actual);
        
        return($datos_metas);
    }
    
    public function construir_metas_diarias() {
        $sql="TRUNCATE metas_ventas_diarias";
        $this->Query($sql);
        $sql="SELECT * FROM metas_ventas";
        $Consulta=$this->Query($sql);
        $venta_anterior=0;
        while($datos_metas=$this->FetchAssoc($Consulta)){
            $ano_actual=$datos_metas["Anio"];
            $mes_actual=str_pad($datos_metas["Mes"], 2, "0", STR_PAD_LEFT);
            $fecha_inicial=$ano_actual."-".$mes_actual."-01";
            $total_dias_mes=date("t", strtotime($fecha_inicial));
            $venta_anterior=0;
            for ($i=1;$i<=$total_dias_mes;$i++){
                $dia=str_pad($i, 2, "0", STR_PAD_LEFT);
                $fecha=$ano_actual."-".$mes_actual."-".$dia;
                $sql="SELECT SUM(Total) as Total FROM facturas WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha' AND FormaPago<>'ANULADA'";
                $array_total_ventas=$this->FetchAssoc($this->Query($sql));                
                $meta_diaria=($datos_metas["Meta"]/$total_dias_mes)*$i;
                $total_ventas=$array_total_ventas["Total"];
                $cumplimiento=(100/$meta_diaria)*$total_ventas;
                
                $Tabla="metas_ventas_diarias";
                $Datos["fecha"]=$fecha;
                $Datos["meta"]=round($meta_diaria,2);
                $Datos["total_ventas"]=$total_ventas;
                $Datos["ventas_dia"]=$total_ventas-$venta_anterior;
                $Datos["diferencia"]=round($total_ventas-$meta_diaria,2);
                $Datos["cumplimiento"]=round($cumplimiento,2);
                $sql=$this->getSQLInsert($Tabla, $Datos);
                $this->Query($sql);
                $venta_anterior=$total_ventas;
            }
            
        }
    }
    
    
    /**
     * Fin Clase
     */
}
