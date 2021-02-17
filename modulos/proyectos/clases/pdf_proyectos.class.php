<?php

if(file_exists("../../../general/clases/ClasesPDFDocumentos.class.php")){
    include_once("../../../general/clases/ClasesPDFDocumentos.class.php");
}

class PDF_Proyectos extends Documento{
    public $color_titulos_tablas="#000aa0";
    public $color_fuente_titulos_tablas="white";
    public $color_linea1_tablas="#f2f2f2"; 
    public $color_linea2_tablas="white";   
    
    public function pdf_informe_proyecto($db,$empresa_id,$proyecto_id ) {
        $obCon=new conexion($_SESSION["idUser"]);
        $datos_formato_calidad=$obCon->DevuelveValores("$db.formatos_calidad", "ID", 42);
        $datos_proyecto=$obCon->DevuelveValores("$db.vista_proyectos", "proyecto_id", $proyecto_id);
        $this->PDF_Ini("Proyectos", 8, "",1,"../../../");
        $this->PDF_Encabezado($datos_proyecto["created"],$empresa_id, 42, "","","../../../");
        $html='<BR><BR><BR><center><strong>INFORME GENERAL DEL PROYECTO: '.($datos_proyecto["nombre"]).', PARA EL CLIENTE '.$datos_proyecto["cliente_razon_social"].'</strong></center><br>';
        $this->PDF_Write($html);
        $cuerpo_formato= str_replace("@nombre_proyecto", utf8_decode($datos_proyecto["nombre"]), $datos_formato_calidad["CuerpoFormato"]);
        $html='<p style="text-align: justify;">'.utf8_encode($cuerpo_formato).'</p>';
        $this->PDF_Write($html);
        
        $html=$this->get_resumen_general($db,$datos_proyecto) ;
        $this->PDF_Write('<br><br><br>'.$html);
        
        $html=$this->get_tareas_actividades($db,$datos_proyecto) ;
        $this->PDF_Write('<br><br><br>'.$html);
         
        
        $this->PDF_Output("Informe_proyecto_$datos_proyecto[ID]");
    }
    
    public function get_tareas_actividades($db,$datos_proyecto) {
        $obCon=new conexion($_SESSION["idUser"]);
        $Back=$this->color_titulos_tablas;
        $proyecto_id=$datos_proyecto["proyecto_id"];
        $datos_tareas=[];
        $sql="SELECT t1.tarea_id,t1.nombre_tarea, SUM(t1.total_costos_planeacion) as total_costos,
                SUM(t1.precio_venta_planeado) as total_venta,
                 MIN(t1.fecha_inicial_planeada) as fecha_inicio,
                 MAX(t1.fecha_final_planeada) as fecha_final,
                 (SELECT SUM(horas) FROM $db.proyectos_actividades_eventos t2 WHERE t1.tarea_id=t2.tarea_id and estado<10) as total_horas
                 
                 
                FROM $db.vista_proyectos_costos t1 WHERE t1.proyecto_id='$proyecto_id' group by t1.tarea_id order by t1.fecha_inicial_planeada asc";
        
        $Consulta=$obCon->Query($sql);
        
        while($datos_consulta=$obCon->FetchAssoc($Consulta)){
            $tarea_id=$datos_consulta["tarea_id"];
            $datos_tareas[$tarea_id]["nombre_tarea"]=$datos_consulta["nombre_tarea"];
            $datos_tareas[$tarea_id]["total_costos"]=$datos_consulta["total_costos"];
            $datos_tareas[$tarea_id]["total_venta"]=$datos_consulta["total_venta"];
            $datos_tareas[$tarea_id]["fecha_inicio"]=$datos_consulta["fecha_inicio"];
            $datos_tareas[$tarea_id]["fecha_final"]=$datos_consulta["fecha_final"];
            $datos_tareas[$tarea_id]["total_horas"]=$datos_consulta["total_horas"];
        }
        
        $sql="SELECT t1.tarea_id,t1.actividad_id,t1.nombre_tarea,t1.nombre_actividad, SUM(t1.total_costos_planeacion) as total_costos,
                SUM(t1.precio_venta_planeado) as total_venta,
                 MIN(t1.fecha_inicial_planeada) as fecha_inicio,
                 MAX(t1.fecha_final_planeada) as fecha_final,
                (SELECT SUM(horas) FROM $db.proyectos_actividades_eventos t2 WHERE t1.actividad_id=t2.actividad_id and estado<10) as total_horas
                 
                FROM $db.vista_proyectos_costos t1 WHERE t1.proyecto_id='$proyecto_id' group by t1.actividad_id order by t1.fecha_inicial_planeada asc";
        
        $Consulta=$obCon->Query($sql);
        $datos_actividades=[];
        while($datos_consulta=$obCon->FetchAssoc($Consulta)){
            $tarea_id=$datos_consulta["tarea_id"];
            $actividad_id=$datos_consulta["actividad_id"];
            $datos_actividades[$tarea_id][$actividad_id]["nombre_actividad"]=$datos_consulta["nombre_actividad"];
            $datos_actividades[$tarea_id][$actividad_id]["total_costos"]=$datos_consulta["total_costos"];
            $datos_actividades[$tarea_id][$actividad_id]["total_venta"]=$datos_consulta["total_venta"];
            $datos_actividades[$tarea_id][$actividad_id]["fecha_inicio"]=$datos_consulta["fecha_inicio"];
            $datos_actividades[$tarea_id][$actividad_id]["fecha_final"]=$datos_consulta["fecha_final"];
            $datos_actividades[$tarea_id][$actividad_id]["total_horas"]=$datos_consulta["total_horas"];
        }
       
        $html =' 
                <table cellspacing="1" cellpadding="2" border="0">
                    <tr>
                        <td align="center" colspan="7"  style="color:'.$this->color_fuente_titulos_tablas.';border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TAREAS Y ACTIVIDADES DE ESTE PROYECTO</strong></td>
                    </tr>   
                    <tr>
                        <td align="center" colspan="2" width="30%" style="color:'.$this->color_fuente_titulos_tablas.';border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TAREA</strong></td>
                        <td align="center" colspan="1" width="16%" style="color:'.$this->color_fuente_titulos_tablas.';border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>FECHA INICIAL</strong></td>
                        <td align="center" colspan="1" width="16%" style="color:'.$this->color_fuente_titulos_tablas.';border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>FECHA FINAL</strong></td>
                        <td align="center" colspan="1" width="8%"  style="color:'.$this->color_fuente_titulos_tablas.';border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>HORAS</strong></td>
                        <td align="center" colspan="1" width="15%" style="color:'.$this->color_fuente_titulos_tablas.';border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL COSTOS</strong></td>
                        <td align="center" colspan="1" width="15%" style="color:'.$this->color_fuente_titulos_tablas.';border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL VENTA</strong></td>    
                    </tr>   
                    
      
                ';
        
        $i=0;
        foreach ($datos_tareas as $key => $array_tareas) {
            $i++;
            $Back='#f6fcfc';
            $tarea_id=$key;
            $html .=' 
                
                    <tr>
                        <td colspan="2" align="left" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';"><span style="color:white;background-color: #000aa0;"> <strong>'.$i.'</strong> </span> '.$array_tareas["nombre_tarea"].' </td>
                        <td align="center" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';">'.$array_tareas["fecha_inicio"].'</td>
                        <td align="center" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';">'.$array_tareas["fecha_final"].'</td>
                        <td align="center" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';"><strong>'.$array_tareas["total_horas"].'</strong></td>
                        <td align="right" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';"><span style="color:white;background-color: #0f6d0a;"> <strong>$'.number_format($array_tareas["total_costos"]).'</strong></span></td>
                        <td align="right" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';"><span style="color:white;background-color: #005892;"> <strong>$'.number_format($array_tareas["total_venta"]).'</strong></span></td>
                        
                    </tr>

                  
                ';
            foreach ($datos_actividades[$tarea_id] as $key => $array_actividades) {
                
                $Back='white';
                $html .=' 
                
                    <tr>
                        <td align="right" width="5%">*</td>
                        <td align="left" width="25%" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';"><span style="color:white;background-color: #000aa0;"></span> '.$array_actividades["nombre_actividad"].' </td>
                        <td align="center" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';">'.$array_actividades["fecha_inicio"].'</td>
                        <td align="center" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';">'.$array_actividades["fecha_final"].'</td>
                        <td align="center" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';">'.$array_actividades["total_horas"].'</td>     
                        <td align="right" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';">$'.number_format($array_actividades["total_costos"]).'</td>
                        <td align="right" style="border-bottom: 0px solid #ddd;background-color: '.$Back.';">$'.number_format($array_actividades["total_venta"]).'</td>
                        
                    </tr>

                  
                ';
            }
        }
        
        $html .='</table>';
        return($html);
    }
    
    public function get_resumen_general($db,$datos_proyecto) {
        
        $Back=$this->color_titulos_tablas;
        $html =' 
                <table cellspacing="1" cellpadding="2" border="0">
                    <tr>
                        <td align="center" colspan="6"  style="color:'.$this->color_fuente_titulos_tablas.';border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>RESUMEN DEL PROYECTO</strong></td>
                    </tr>   
                    <tr>
                        <td align="center" ><strong>FECHA DE INICIO</strong></td>
                        <td align="center" ><strong>FECHA DE FINALIZACIÓN</strong></td>
                        <td align="center" ><strong>TOTAL DE HORAS</strong></td>
                        <td align="center" ><strong>TOTAL COSTOS</strong></td>
                        <td align="center" ><strong>TOTAL A FACTURAR</strong></td>
                        <td align="center" ><strong>UTILIDAD ESPERADA</strong></td>
                    </tr>
      
                ';
        $Back=$this->color_linea1_tablas;
        $html .=' 
                
                    <tr>
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_proyecto["fecha_inicio_planeacion"].'</td>
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_proyecto["fecha_final_planeacion"].'</td>
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($datos_proyecto["total_horas_planeadas"]).'</td>
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><span style="color:white;background-color: #0f6d0a;"> <strong>$'.number_format($datos_proyecto["costos_planeacion"]).'</strong></span></td>
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><span style="color:white;background-color: #005892;"> <strong>$'.number_format($datos_proyecto["valor_facturar"]).'</strong></span></td>
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($datos_proyecto["utilidad_planeada"],2).'</td>
                    </tr>

                 </table>        
                ';
        return($html);
        
    }
    
    
    
    /**
     * Fin Clase
     */
}
