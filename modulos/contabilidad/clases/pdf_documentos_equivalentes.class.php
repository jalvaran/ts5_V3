<?php

if(file_exists("../../../general/clases/ClasesPDFDocumentos.class.php")){
    include_once("../../../general/clases/ClasesPDFDocumentos.class.php");
}

class PDF_Documentos_Equivalentes extends Documento{
    public $color_titulos_tablas="#000aa0";
    public $color_fuente_titulos_tablas="white";
    public $color_linea1_tablas="#f2f2f2"; 
    public $color_linea2_tablas="white";   
    
    public function pdf_documento_equivalente($db,$empresa_id,$documento_id,$totales_documento ) {
        $obCon=new conexion($_SESSION["idUser"]);
        $datos_formato_calidad=$obCon->DevuelveValores("$db.formatos_calidad", "ID", 44);
        $datos_documento=$obCon->DevuelveValores("$db.vista_documentos_equivalentes", "ID", $documento_id);
        $datos_resolucion=$obCon->DevuelveValores("$db.documentos_equivalentes_resoluciones", "ID", $datos_documento["resolucion_id"]);
        $this->PDF_Ini("Documento Equivalente", 8, "",1,"../../../");
        $this->PDF_Encabezado($datos_documento["fecha"],$empresa_id, 44, "","","../../../");
        $html='<BR><BR><BR><center><strong>'.($datos_formato_calidad["Nombre"]." No.".$datos_documento["consecutivo"]).'</strong></center><br>';
        $html.='(Art. 3 Decreto 522 Marzo de 2003)<br><br>';
        $html.='Resolución DIAN No. '.$datos_resolucion["numero_resolucion"].", del ".$datos_resolucion["fecha"]."<br>";
        $html.='Numeración autorizada desde el Número '.$datos_resolucion["desde"]." Hasta el ".$datos_resolucion["hasta"];
        $html.='<br>Vigencia: '.$datos_resolucion["fecha_final"];
        $html.='<br><br><table>';
        $html.='<tr>';
        $html.='<td>FECHA:</td><td><strong>'.$datos_documento["fecha"].'</strong></td><td> </td>';
        $html.='</tr>';
        $html.='<tr>';
        $html.='<td>NOMBRE O RAZÓN SOCIAL:</td><td><strong>'.$datos_documento["tercero_razon_social"].'</strong></td><td> </td>';
        
        $html.='</tr>';
        $html.='<tr>';
        $html.='<td>CÉDULA O NIT:</td><td><strong>'.$datos_documento["tercero_id"].'</strong></td><td> </td>';
        $html.='</tr>';
        $html.='<tr>';
        $html.='<td>DOMICILIO:</td><td><strong>'.$datos_documento["tercero_direccion"].'</strong></td><td> </td>';
        $html.='</tr>';
        $html.='<tr>';
        $html.='<td>TELEFONO:</td><td><strong>'.$datos_documento["tercero_telefono"].'</strong></td><td> </td>';
        $html.='</tr>';
        
        $html.='</table>';
        $this->PDF_Write($html);
        
        
        $html=$this->get_items_documento($db,$datos_documento,$totales_documento) ;
        $this->PDF_Write('<br><br><br>'.$html);
        
        $html=$this->HTML_Movimiento_Contable("DOCUMENTO EQUIVALENTE", $documento_id, "");
        $this->PDF_Write('<br><br><br><strong>MOVIMENTOS CONTABLES</strong><br>'.$html);
        $html= $this->HTML_Movimiento_Firmas_Egresos($totales_documento["total"]);
        $this->PDF_Write("<br><br>".$html);
        $this->PDF_Output("documento_equivalente_$documento_id");
    }
    
    
    public function get_items_documento($db,$datos_documento,$totales_documento) {
        $documento_id=$datos_documento["ID"];
        $obCon=new conexion($_SESSION["idUser"]);
        
        $sql="select t1.* 
                    from $db.documentos_equivalentes_items t1 
                    where t1.documento_equivalente_id='$documento_id'    
                   
             ";
        
        $Back=$this->color_titulos_tablas;
        $html =' 
                <table cellspacing="1" cellpadding="2" border="0">
                    
                    <tr>
                                   
                        <td align="center" ><strong>CANTIDAD</strong></td>
                        <td align="center" colspan="2" ><strong>DESCRIPCIÓN</strong></td>             
                        <td align="center" ><strong>VALOR UNITARIO</strong></td>
                        <td align="center" ><strong>VALOR TOTAL</strong></td>
                                               
                    </tr>
      
                ';
        $Back=$this->color_linea1_tablas;
        $costo_total=0;
        
        $Consulta=$obCon->Query($sql);
        $z=1;
        while($datos_consulta=$obCon->FetchAssoc($Consulta)){
            $costo_total=$costo_total+$datos_consulta["total_item"];
            
            if($z==0){
                $z=1;
                $Back=$this->color_linea1_tablas;
            }else{
                $z=0;
                $Back=$this->color_linea2_tablas;
            }
            $html .=' <tr>
                        
                        <td align="center" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" >'.number_format($datos_consulta["cantidad"]).'</td>
                        <td align="left" colspan="2" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" >'.$datos_consulta["descripcion"].'</td>
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" >'.number_format($datos_consulta["valor_unitario"]).'</td>
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" >'.number_format($datos_consulta["total_item"]).'</td>
                        
                    </tr>';
        }
        $html .=' <tr>
                        <td align="rigth" colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" ><strong>Subtotal</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" ><strong>'.number_format($totales_documento["base"]).'</strong></td>
                        
                    </tr>';
        $html .=' <tr>
                        <td align="rigth" colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" ><strong>Retenciones</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" ><strong>'.number_format($totales_documento["retenciones_no_asumidas"]).'</strong></td>
                        
                    </tr>';
        $html .=' <tr>
                        <td align="rigth" colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" ><strong>Neto a Pagar</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';" ><strong>'.number_format($totales_documento["total"]).'</strong></td>
                        
                    </tr>';
        $html .='</table>';
            
        return($html);
    }
    
    
    
    /**
     * Fin Clase
     */
}
