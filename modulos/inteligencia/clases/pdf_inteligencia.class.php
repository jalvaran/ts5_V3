<?php

if(file_exists("../../../general/clases/ClasesPDFDocumentos.class.php")){
    include_once("../../../general/clases/ClasesPDFDocumentos.class.php");
}

class PDF_Inteligencia extends Documento{
    
    public function pdf_inteligencia_negocio($fecha_inicial,$fecha_final,$idEmpresa,$CentroCosto=1 ) {
        $TipoReporte="Rango";
        $idEmpresaEncabezado=$idEmpresa;
        if($idEmpresa=="ALL"){
            $idEmpresaEncabezado=1;
        }
        
        $FechaReporte="DEL $fecha_inicial AL $fecha_final";
        
        
        $this->PDF_Ini("Informe de Inteligencia de Negocio", 8, "",1,"../../../");
        $this->PDF_Encabezado($fecha_final,$idEmpresaEncabezado, 40, "","","../../../");
        $html='<center><strong>INTELIGENCIA DEL NEGOCIO '.$FechaReporte.' </strong></center><br>';
        $this->PDF_Write($html);
        $html=$this->get_clientes_atendidos($fecha_inicial, $fecha_final) ;
        $this->PDF_Write('<br>'.$html);
        $html=$this->get_clientes_estrella($fecha_inicial, $fecha_final) ;
        $this->PDF_Write('<br>'.$html);
        $html=$this->get_clientes_frecuencia($fecha_inicial, $fecha_final) ;
        $this->PDF_Write('<br>'.$html);
        $html=$this->get_producto_estrella($fecha_inicial, $fecha_final) ;
        $this->PDF_Write('<br>'.$html);
        $this->PDF_Output("Inteligencia_Negocios_$fecha_inicial-$fecha_final");
    }
    
    public function get_clientes_atendidos($fecha_inicial,$fecha_final) {
        $datos_clientes_atendidos=[];
        $html="";
        $sql="SELECT COUNT( DISTINCT  Clientes_idClientes  ) as TotalFacturas, FormaPago 
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' 
            GROUP BY FormaPago 
            ";
        $consulta=($this->obCon->Query($sql));
        $total_clientes_atendidos=0;
        while($datos_consulta=$this->obCon->FetchAssoc($consulta)){
            $tipo_factura=$datos_consulta["FormaPago"];
            $datos_clientes_atendidos[$tipo_factura]=$datos_consulta["TotalFacturas"];
            $total_clientes_atendidos=$total_clientes_atendidos+$datos_consulta["TotalFacturas"];
        }
        $datos_clientes_atendidos["Total_Clientes_Atendidos"]=$total_clientes_atendidos;
        $sql="SELECT COUNT( DISTINCT  Clientes_idClientes ) as TotalFacturas 
            FROM vista_facturas_x_cliente 
            WHERE fecha_creacion_cliente>='$fecha_inicial' AND fecha_creacion_cliente<='$fecha_final' 
            ";
        $datos_consulta=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        $total_clientes_nuevos=0;
        
        
        if(isset($datos_consulta["TotalFacturas"])){
            $datos_clientes_atendidos['Clientes_Nuevos']=$datos_consulta["TotalFacturas"];
            $total_clientes_nuevos=$datos_consulta["TotalFacturas"];
        }
        $divisor=$total_clientes_atendidos;
        if($divisor==0){
            $divisor=1;
        }
        $porcentaje_clientes_nuevos=round(100/$divisor*$total_clientes_nuevos,2);
        $datos_clientes_atendidos['Porcentaje_Clientes_Nuevos']=$porcentaje_clientes_nuevos;
        $Back="#CEE3F6";
        $html.='<table cellspacing="1" cellpadding="2" border="0">';
        $html.='<tr >';
        $html.='<td colspan="2" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Clientes</strong></td></tr>'; 
        $html.='<tr >';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Criterio</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Total</strong></td>';
            
        $html.='</tr>';
        foreach ($datos_clientes_atendidos as $key => $value) {
            $html.='<tr >';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$key.'</td>';
                if($key=="Porcentaje_Clientes_Nuevos"){
                    $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'. ($value).'%</strong></td>';
                }else{
                    $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'. number_format($value).'</strong></td>';
                }
                            
            $html.='</tr>';
        }
        
        
        $html.='</tabla>';
        return($html);
        
    }
    
    public function get_producto_estrella($fecha_inicial,$fecha_final) {
        
        $html="";
        $sql="SELECT sum(Cantidad) as total_items_vendidos,sum(TotalItem) as valor_vendido,
            Referencia,Nombre   
            FROM vista_productos_x_cliente
            WHERE FechaFactura>='$fecha_inicial' AND FechaFactura<='$fecha_final' 
            GROUP BY Referencia ORDER BY total_items_vendidos DESC LIMIT 5
            ";
        $consulta=($this->obCon->Query($sql));
        
        
        $Back="#CEE3F6";
        $html.='<table cellspacing="1" cellpadding="2" border="0">';
        $html.='<tr >';
        $html.='<td colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>PRODUCTOS ESTRELLA</strong></td></tr>'; 
        $html.='<tr >';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Referencia</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Nombre</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Cantidad Vendida</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Valor Vendido</strong></td>';
            
        $html.='</tr>';
        
        while($datos_producto_estrella=$this->obCon->FetchAssoc($consulta)){
            $html.='<tr >';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_producto_estrella["Referencia"].'</td>';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_producto_estrella["Nombre"].'</td>';
                $html.='<td colspan="1" style="text-align:center;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_producto_estrella["total_items_vendidos"]).'</strong></td>';
                $html.='<td colspan="1" style="text-align:rigth;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_producto_estrella["valor_vendido"]).'</strong></td>';

            $html.='</tr>';
        }
       
        
        
        $html.='</tabla>';
        return($html);
        
    }
    
    
    public function get_clientes_frecuencia($fecha_inicial,$fecha_final) {
        
        $html="";
        $sql="SELECT count( Total) TotalFacturas,Clientes_idClientes AS cliente_id,sum(Total) as total_comprado,FormaPago , 
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' and FormaPago='Contado' 
            GROUP BY Clientes_idClientes,FormaPago
            ORDER BY TotalFacturas DESC limit 10 ;
            ";
        $consulta=($this->obCon->Query($sql));
        
        $Back="#CEE3F6";
        $html.='<table cellspacing="1" cellpadding="2" border="0">';
        $html.='<tr >';
        $html.='<td colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>FRECUENCIA DE CLIENTES DE CONTADO</strong></td></tr>'; 
        $html.='<tr >';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Nombre</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Identificacion</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Frecuencia</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Total Comprado</strong></td>';
        $html.='</tr>';
        
        while($datos_consulta=$this->obCon->FetchAssoc($consulta)){
            $html.='<tr >';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["RazonSocial"].'</td>';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Identificacion"].'</td>';
                $html.='<td colspan="1" style="text-align:center;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["TotalFacturas"]).'</strong></td>';
                $html.='<td colspan="1" style="text-align:rigth;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["total_comprado"]).'</strong></td>';
            $html.='</tr>';
            
        }
                         
         
        $html.='</tabla>';
        
        
        $sql="SELECT count( Total) TotalFacturas,Clientes_idClientes AS cliente_id,sum(Total) as total_comprado,FormaPago , 
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' and FormaPago='SisteCredito' 
            GROUP BY Clientes_idClientes,FormaPago
            ORDER BY TotalFacturas DESC limit 10 ;
            ";
        $consulta=($this->obCon->Query($sql));
        
        $Back="#CEE3F6";
        $html.='<BR><BR><table cellspacing="1" cellpadding="2" border="0">';
        $html.='<tr >';
        $html.='<td colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>FRECUENCIA DE CLIENTES SISTE CREDITO</strong></td></tr>'; 
        $html.='<tr >';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Nombre</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Identificacion</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Frecuencia</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Total Comprado</strong></td>';
        $html.='</tr>';
        
        while($datos_consulta=$this->obCon->FetchAssoc($consulta)){
            $html.='<tr >';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["RazonSocial"].'</td>';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Identificacion"].'</td>';
                $html.='<td colspan="1" style="text-align:center;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["TotalFacturas"]).'</strong></td>';
                $html.='<td colspan="1" style="text-align:rigth;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["total_comprado"]).'</strong></td>';
            $html.='</tr>';
            
        }
                         
         
        $html.='</tabla>';
        
        $sql="SELECT count( Total) TotalFacturas,Clientes_idClientes AS cliente_id,sum(Total) as total_comprado,FormaPago , 
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' and FormaPago LIKE 'Acuerdo%' 
            GROUP BY Clientes_idClientes,FormaPago
            ORDER BY TotalFacturas DESC limit 10 ;
            ";
        $consulta=($this->obCon->Query($sql));
        
        $Back="#CEE3F6";
        $html.='<BR><BR><table cellspacing="1" cellpadding="2" border="0">';
        $html.='<tr >';
        $html.='<td colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>FRECUENCIA DE CLIENTES ACUERDO DE PAGO</strong></td></tr>'; 
        $html.='<tr >';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Nombre</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Identificacion</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Frecuencia</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Total Comprado</strong></td>';
        $html.='</tr>';
        
        while($datos_consulta=$this->obCon->FetchAssoc($consulta)){
            $html.='<tr >';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["RazonSocial"].'</td>';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Identificacion"].'</td>';
                $html.='<td colspan="1" style="text-align:center;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["TotalFacturas"]).'</strong></td>';
                $html.='<td colspan="1" style="text-align:rigth;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["total_comprado"]).'</strong></td>';
            $html.='</tr>';
            
        }
                         
         
        $html.='</tabla>';
        
        $sql="SELECT count( Total) TotalFacturas,Clientes_idClientes AS cliente_id,sum(Total) as total_comprado,FormaPago , 
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' and FormaPago LIKE 'Credito%' 
            GROUP BY Clientes_idClientes,FormaPago
            ORDER BY TotalFacturas DESC limit 10 ;
            ";
        $consulta=($this->obCon->Query($sql));
        
        $Back="#CEE3F6";
        $html.='<BR><BR><table cellspacing="1" cellpadding="2" border="0">';
        $html.='<tr >';
        $html.='<td colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>FRECUENCIA DE CLIENTES CREDITO</strong></td></tr>'; 
        $html.='<tr >';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Nombre</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Identificacion</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Frecuencia</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Total Comprado</strong></td>';
        $html.='</tr>';
        
        while($datos_consulta=$this->obCon->FetchAssoc($consulta)){
            $html.='<tr >';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["RazonSocial"].'</td>';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Identificacion"].'</td>';
                $html.='<td colspan="1" style="text-align:center;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["TotalFacturas"]).'</strong></td>';
                $html.='<td colspan="1" style="text-align:rigth;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["total_comprado"]).'</strong></td>';
            $html.='</tr>';
            
        }
                         
         
        $html.='</tabla>';
        
        
        $sql="SELECT count( Total) TotalFacturas,Clientes_idClientes AS cliente_id,sum(Total) as total_comprado,FormaPago , 
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' and FormaPago LIKE 'Separado' 
            GROUP BY Clientes_idClientes,FormaPago
            ORDER BY TotalFacturas DESC limit 10 ;
            ";
        $consulta=($this->obCon->Query($sql));
        
        $Back="#CEE3F6";
        $html.='<BR><BR><table cellspacing="1" cellpadding="2" border="0">';
        $html.='<tr >';
        $html.='<td colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>FRECUENCIA DE CLIENTES SEPARADO</strong></td></tr>'; 
        $html.='<tr >';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Nombre</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Identificacion</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Frecuencia</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Total Comprado</strong></td>';
        $html.='</tr>';
        
        while($datos_consulta=$this->obCon->FetchAssoc($consulta)){
            $html.='<tr >';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["RazonSocial"].'</td>';
                $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Identificacion"].'</td>';
                $html.='<td colspan="1" style="text-align:center;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["TotalFacturas"]).'</strong></td>';
                $html.='<td colspan="1" style="text-align:rigth;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($datos_consulta["total_comprado"]).'</strong></td>';
            $html.='</tr>';
            
        }
                         
         
        $html.='</tabla>';
        
        return($html);
        
    }
    
    public function get_clientes_estrella($fecha_inicial,$fecha_final) {
        $datos_clientes_estrella=[];
        $html="";
        $sql="SELECT SUM( Total) Total,Clientes_idClientes AS cliente_id,
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' AND FormaPago='Contado'
            GROUP BY Clientes_idClientes  
            ORDER BY Total DESC LIMIT 1";
        $datos_consulta=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        if(isset($datos_consulta["Total"])){
            
            $datos_clientes_estrella["Contado"]["RazonSocial"]=$datos_consulta["RazonSocial"];
            $datos_clientes_estrella["Contado"]["Total"]=$datos_consulta["Total"];
            $datos_clientes_estrella["Contado"]["Identificacion"]=$datos_consulta["Identificacion"];
        }
        $sql="SELECT SUM( Total) Total,Clientes_idClientes AS cliente_id,
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' AND FormaPago='SisteCredito'
            GROUP BY Clientes_idClientes  
            ORDER BY Total DESC LIMIT 1";
        $datos_consulta=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        if(isset($datos_consulta["Total"])){
            $datos_clientes_estrella["SisteCredito"]["RazonSocial"]=$datos_consulta["RazonSocial"];
            $datos_clientes_estrella["SisteCredito"]["Total"]=$datos_consulta["Total"];
            $datos_clientes_estrella["SisteCredito"]["Identificacion"]=$datos_consulta["Identificacion"];
        }
        $sql="SELECT SUM( Total) Total,Clientes_idClientes AS cliente_id,
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' AND FormaPago='Separado'
            GROUP BY Clientes_idClientes  
            ORDER BY Total DESC LIMIT 1";
        $datos_consulta=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        if(isset($datos_consulta["Total"])){
            $datos_clientes_estrella["Separado"]["RazonSocial"]=$datos_consulta["RazonSocial"];
            $datos_clientes_estrella["Separado"]["Total"]=$datos_consulta["Total"];
            $datos_clientes_estrella["Separado"]["Identificacion"]=$datos_consulta["Identificacion"];
        }
        $sql="SELECT SUM( Total) Total,Clientes_idClientes AS cliente_id,
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' AND FormaPago like 'Credito%'
            GROUP BY Clientes_idClientes  
            ORDER BY Total DESC LIMIT 1";
        $datos_consulta=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        if(isset($datos_consulta["Total"])){
            $datos_clientes_estrella["Credito"]["RazonSocial"]=$datos_consulta["RazonSocial"];
            $datos_clientes_estrella["Credito"]["Total"]=$datos_consulta["Total"];
            $datos_clientes_estrella["Credito"]["Identificacion"]=$datos_consulta["Identificacion"];
        }
        
        $sql="SELECT SUM( Total) Total,Clientes_idClientes AS cliente_id,
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' AND FormaPago like 'Acuerdo%'
            GROUP BY Clientes_idClientes  
            ORDER BY Total DESC LIMIT 1";
        $datos_consulta=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        if(isset($datos_consulta["Total"])){
            $datos_clientes_estrella["Acuerdo"]["RazonSocial"]=$datos_consulta["RazonSocial"];
            $datos_clientes_estrella["Acuerdo"]["Total"]=$datos_consulta["Total"];
            $datos_clientes_estrella["Acuerdo"]["Identificacion"]=$datos_consulta["Identificacion"];
        }
        
        $sql="SELECT SUM( Total) Total,Clientes_idClientes AS cliente_id,
            (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS RazonSocial,
            (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT cliente_id) LIMIT 1) AS Identificacion
            FROM facturas
            WHERE Fecha>='$fecha_inicial' AND Fecha<='$fecha_final' AND FormaPago like 'ANULADA'
            GROUP BY Clientes_idClientes  
            ORDER BY Total DESC LIMIT 1";
        $datos_consulta=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        if(isset($datos_consulta["Total"])){
            $datos_clientes_estrella["ANULADA"]["RazonSocial"]=$datos_consulta["RazonSocial"];
            $datos_clientes_estrella["ANULADA"]["Total"]=$datos_consulta["Total"];
            $datos_clientes_estrella["ANULADA"]["Identificacion"]=$datos_consulta["Identificacion"];
        }
        
        $Back="#CEE3F6";
        $html.='<table cellspacing="1" cellpadding="2" border="0">';
        $html.='<tr >';
        $html.='<td colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Clientes Estrella Agrupados por Tipo de Factura</strong></td></tr>'; 
        $html.='<tr >';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Tipo de Factura</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Cliente</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Identificacion</strong></td>';
            $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>Total</strong></td>';
            
        $html.='</tr>';
        if(is_array($datos_clientes_estrella)){
            $h=0;
            foreach ($datos_clientes_estrella as $key => $value) {
                if($h==0){
                    $Back="#f2f2f2";
                        $h=1;
                    }else{
                        $Back="white";
                        $h=0;
                }
            
                $html.='<tr >';
                    $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$key.'</td>';
                    $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$value["RazonSocial"].'</td>';
                    $html.='<td colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$value["Identificacion"].'</td>';
                    $html.='<td colspan="1" style="text-align:rigth;border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.number_format($value["Total"]).'</strong></td>';

                $html.='</tr>';
            }
        }
        
        $html.='</tabla>';
        return($html);
        
    }
    
    
    
    /**
     * Fin Clase
     */
}
