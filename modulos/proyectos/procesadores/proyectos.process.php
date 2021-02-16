<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/proyectos.class.php");
//include_once("../clases/inteligenciaExcel.class.php");
//include_once("../clases/pdf_inteligencia.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Proyectos($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1://Agregar una Fecha excluida a un proyecto
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $fecha_excluida=$obCon->normalizar($_REQUEST["fecha_excluida"]);
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            if($fecha_excluida==''){
                exit("E1;El campo Fecha Excluida no puede estar vacío;fecha_excluida");
            }
            $obCon->agregar_fecha_excluida($db, $proyecto_id, $fecha_excluida);
            print("OK;Fecha Excluida Agregada");
        break;//Fin caso 1
        
        case 2://eliminar un registro
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $tabla_id=$obCon->normalizar($_REQUEST["tabla_id"]);
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);
            if($tabla_id==''){
                exit("E1;No se envio tabla");
            }
            if($tabla_id==1){
                $tabla="$db.proyectos_fechas_excluidas";
            }
            if($tabla_id==2){
                $tabla=$db.".proyectos_adjuntos";
                $DatosAdjunto=$obCon->DevuelveValores("$db.proyectos_adjuntos", "ID", $item_id);
                if(file_exists($DatosAdjunto["Ruta"])){
                    unlink($DatosAdjunto["Ruta"]);
                }
            }
            if($tabla_id==3){
                $tabla=$db.".proyectos_tareas_adjuntos";
                $DatosAdjunto=$obCon->DevuelveValores("$db.proyectos_tareas_adjuntos", "ID", $item_id);
                if(file_exists($DatosAdjunto["Ruta"])){
                    unlink($DatosAdjunto["Ruta"]);
                }
            }
            if($tabla_id==4){
                $tabla=$db.".proyectos_actividades_adjuntos";
                $DatosAdjunto=$obCon->DevuelveValores("$db.proyectos_actividades_adjuntos", "ID", $item_id);
                if(file_exists($DatosAdjunto["Ruta"])){
                    unlink($DatosAdjunto["Ruta"]);
                }
            }
            if($tabla_id==5){
                $tabla="$db.proyectos_actividades_recursos";
            }
            $obCon->BorraReg($tabla, "ID", $item_id);
            print("OK;Registro Eliminado");
        break;//Fin caso 2
        
        case 3://crear o editar un proyecto
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $datos_proyecto["proyecto_id"]=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $datos_proyecto["cliente_id"]=$obCon->normalizar($_REQUEST["cliente_id"]);
            $datos_proyecto["nombre"]=$obCon->normalizar($_REQUEST["nombre_proyecto"]);
            $datos_proyecto["horas_x_dia"]=$obCon->normalizar($_REQUEST["horas_x_dia"]);
            $datos_proyecto["excluir_sabados"]=$obCon->normalizar($_REQUEST["excluir_sabados"]);
            $datos_proyecto["excluir_domingos"]=$obCon->normalizar($_REQUEST["excluir_domingos"]);
            
            foreach ($datos_proyecto as $key => $value) {
                if($value==''){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
                if($key=='horas_x_dia' and (!is_numeric($value) or $value<1 or $value>24)){
                    exit("E1;Debe escribir un valor numerico entre 1 y 24 para el campo dias por hora;$key");
                }
            }
            $datos_proyecto["usuario_id"]=$idUser;
            
            $obCon->crear_editar_proyecto($db, $datos_proyecto);
            
            print("OK;Datos Guardados");
        break;//Fin caso 3
        
        
        case 4://Recibir un adjunto para un proyecto
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]); 
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            
            $Extension="";
            if(!empty($_FILES['adjunto_proyecto']['name'])){
                
                $info = new SplFileInfo($_FILES['adjunto_proyecto']['name']);
                $Extension=($info->getExtension()); 
                
                $Tamano=filesize($_FILES['adjunto_proyecto']['tmp_name']);
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 38);
                
                $carpeta=$DatosConfiguracion["Valor"];
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                $carpeta.=$empresa_id."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta.="Proyectos/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta.=$proyecto_id."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                opendir($carpeta);
                $idAdjunto=$obCon->getUniqId("ad_pr_");
                $destino=$carpeta.$idAdjunto.".".$Extension;
                
                move_uploaded_file($_FILES['adjunto_proyecto']['tmp_name'],$destino);
                $obCon->RegistreAdjuntoProyecto($db,$proyecto_id, $destino, $Tamano, $_FILES['adjunto_proyecto']['name'], $Extension, $idUser);
            }else{
                exit("E1;No se recibió el archivo");
            }
            print("OK;Archivo adjuntado");
           
        break;//Fin caso 4
        
        case 5://Recibir un adjunto para una tarea
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]); 
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $tarea_id=$obCon->normalizar($_REQUEST["tarea_id"]);
            
            $Extension="";
            if(!empty($_FILES['adjunto_tarea']['name'])){
                
                $info = new SplFileInfo($_FILES['adjunto_tarea']['name']);
                $Extension=($info->getExtension()); 
                
                $Tamano=filesize($_FILES['adjunto_tarea']['tmp_name']);
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 38);
                
                $carpeta=$DatosConfiguracion["Valor"];
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                $carpeta.=$empresa_id."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta.="Proyectos/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                $carpeta.=$proyecto_id."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                $carpeta.="tareas/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta.=$tarea_id."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                opendir($carpeta);
                $idAdjunto=$obCon->getUniqId("tr_");
                $destino=$carpeta.$idAdjunto.".".$Extension;
                
                move_uploaded_file($_FILES['adjunto_tarea']['tmp_name'],$destino);
                $obCon->RegistreAdjuntoTarea($db,$proyecto_id,$tarea_id, $destino, $Tamano, $_FILES['adjunto_tarea']['name'], $Extension, $idUser);
            }else{
                exit("E1;No se recibió el archivo");
            }
            print("OK;Archivo adjuntado");
           
        break;//Fin caso 5
       
        case 6://crear o editar una tarea de un proyecto
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $datos_tarea["proyecto_id"]=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $datos_tarea["tarea_id"]=$obCon->normalizar($_REQUEST["tarea_id"]);
            $datos_tarea["titulo_tarea"]=$obCon->normalizar($_REQUEST["titulo_tarea"]);
            $datos_tarea["color"]=$obCon->normalizar($_REQUEST["color_tarea"]);
            
            foreach ($datos_tarea as $key => $value) {
                if($value==''){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
                
            }
            $datos_tarea["usuario_id"]=$idUser;
            
            $obCon->crear_editar_proyecto_tarea($db, $datos_tarea);
            
            print("OK;Datos Guardados");
        break;//Fin caso 6
        
        case 7://Recibir un adjunto para una actividad
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]); 
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $tarea_id=$obCon->normalizar($_REQUEST["tarea_id"]);
            $actividad_id=$obCon->normalizar($_REQUEST["actividad_id"]);
            
            $Extension="";
            if(!empty($_FILES['adjunto_actividad']['name'])){
                
                $info = new SplFileInfo($_FILES['adjunto_actividad']['name']);
                $Extension=($info->getExtension()); 
                
                $Tamano=filesize($_FILES['adjunto_actividad']['tmp_name']);
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 38);
                
                $carpeta=$DatosConfiguracion["Valor"];
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                $carpeta.=$empresa_id."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta.="Proyectos/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                $carpeta.=$proyecto_id."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                $carpeta.="actividades/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta.=$actividad_id."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                opendir($carpeta);
                $idAdjunto=$obCon->getUniqId("ac_");
                $destino=$carpeta.$idAdjunto.".".$Extension;
                
                move_uploaded_file($_FILES['adjunto_actividad']['tmp_name'],$destino);
                $obCon->RegistreAdjuntoActividad($db,$proyecto_id,$tarea_id,$actividad_id, $destino, $Tamano, $_FILES['adjunto_actividad']['name'], $Extension, $idUser);
            }else{
                exit("E1;No se recibió el archivo");
            }
            print("OK;Archivo adjuntado");
           
        break;//Fin caso 7
        
        case 8://crear o editar una actividad de una tarea de un proyecto
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $datos_actividad["proyecto_id"]=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $datos_actividad["tarea_id"]=$obCon->normalizar($_REQUEST["tarea_id"]);
            $datos_actividad["actividad_id"]=$obCon->normalizar($_REQUEST["actividad_id"]);
            $datos_actividad["titulo_actividad"]=$obCon->normalizar($_REQUEST["titulo_actividad"]);
            $datos_actividad["color"]=$obCon->normalizar($_REQUEST["color_actividad"]);
            
            foreach ($datos_actividad as $key => $value) {
                if($value==''){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
                
            }
            $datos_actividad["usuario_id"]=$idUser;
            
            $obCon->crear_editar_proyecto_tarea_actividad($db, $datos_actividad);
            
            print("OK;Datos Guardados");
        break;//Fin caso 8
        
        case 9://crear o editar evento de una actividad de una tarea de un proyecto
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $evento_id=$obCon->normalizar($_REQUEST["evento_id"]);
            $array_evento_id= explode("_", $evento_id);
            $db=$datos_empresa["db"];
            
            $datos_evento["evento_id"]=$array_evento_id[1];
            $datos_evento["fecha_inicial"]=$obCon->normalizar($_REQUEST["fecha_inicial"]);
            $datos_evento["fecha_final"]=$obCon->normalizar($_REQUEST["fecha_final"]);
            $datos_evento["todo_el_dia"]=$obCon->normalizar($_REQUEST["todo_el_dia"]);
            $datos_evento["actividad_id"]=$array_evento_id[0];
            $datos_actividad=$obCon->DevuelveValores("$db.proyectos_actividades", "actividad_id", $datos_evento["actividad_id"]);
            $datos_evento["proyecto_id"]=$datos_actividad["proyecto_id"];
            $datos_evento["titulo"]=$datos_actividad["titulo_actividad"];
            $datos_evento["color"]=$datos_actividad["color"];
            $datos_evento["tarea_id"]=$datos_actividad["tarea_id"];
            
            $datos_evento["horas"]=$obCon->calcular_horas($datos_evento["fecha_inicial"], $datos_evento["fecha_final"]);
            foreach ($datos_evento as $key => $value) {
                if($value==''){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
                
            }
            $datos_evento["usuario_id"]=$idUser;
            
            $obCon->crear_editar_evento($db, $datos_evento);
            $proyecto_id=$datos_evento["proyecto_id"];
            $obCon->actualizar_totales_proyecto($db, $proyecto_id);
            
            print("OK;Evento Registrado");
        break;//Fin caso 9
        
        case 10://obtengo los eventos
         
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $sql="SELECT * FROM $db.proyectos_actividades_eventos WHERE proyecto_id='$proyecto_id' AND estado<=9";
            $Consulta=$obCon->Query($sql);
            $array_json_eventos=[];
            $i=0;
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                $array_json_eventos[$i]["id"]=$datos_consulta["actividad_id"]."_".$datos_consulta["evento_id"];
                $array_json_eventos[$i]["title"]=$datos_consulta["titulo"];
                $array_json_eventos[$i]["start"]=($datos_consulta["fecha_inicial"]);
                $array_json_eventos[$i]["end"]=($datos_consulta["fecha_final"]);
                $array_json_eventos[$i]["color"]=$datos_consulta["color"];
                $todo_el_dia=false;
                if($datos_consulta["todo_el_dia"]==1){
                    $todo_el_dia=true;
                }
                $array_json_eventos[$i]["allDay"]=$todo_el_dia;
                
                $i=$i+1;
            }
            
            print(json_encode($array_json_eventos));
        break;//Fin caso 10
            
        case 11://cambiar el estado a una tabla para eliminar una actividad o tarea
         
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $tabla_id=$obCon->normalizar($_REQUEST["tabla_id"]);
            $item_id=$obCon->normalizar($_REQUEST["cambiar_id"]);
            
            if($tabla_id==1){
                $array_evento_id= explode("_", $item_id);
                $item_id=$array_evento_id[1];
                $tab="$db.proyectos_actividades_eventos";
                $sql="UPDATE $tab SET estado=10 WHERE evento_id='$item_id'";
                $obCon->Query($sql); 
                exit("OK;Evento eliminado ");
            }
            
            if($tabla_id==2){
                
                $tab="$db.proyectos_tareas";
                $sql="UPDATE $tab SET estado=10 WHERE tarea_id='$item_id'";
                $obCon->Query($sql);
                $tab="$db.proyectos_actividades_eventos";
                $sql="UPDATE $tab SET estado=10 WHERE tarea_id='$item_id'";
                $obCon->Query($sql);
                $tab="$db.proyectos_actividades";
                $sql="UPDATE $tab SET estado=10 WHERE tarea_id='$item_id'";
                $obCon->Query($sql);    
                exit("OK;Tarea Eliminada ");
            }
            if($tabla_id==3){
                
                
                $tab="$db.proyectos_actividades_eventos";
                $sql="UPDATE $tab SET estado=10 WHERE actividad_id='$item_id'";
                $obCon->Query($sql);
                $tab="$db.proyectos_actividades";
                $datos_actividad=$obCon->DevuelveValores($tab, "actividad_id", $item_id);
                $sql="UPDATE $tab SET estado=10 WHERE actividad_id='$item_id'";
                $obCon->Query($sql);
                exit("OK;Actividad eliminada;".$datos_actividad["tarea_id"]);
            }
            
            
        break;//Fin caso 11
    
        case 12://agregar un recurso a una actividad
         
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            
            $recurso_id=$obCon->normalizar($_REQUEST["recurso_id"]);
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $tarea_id=$obCon->normalizar($_REQUEST["tarea_id"]);
            $actividad_id=$obCon->normalizar($_REQUEST["actividad_id"]);
            
            $nombre_recurso=$obCon->normalizar($_REQUEST["recurso_tarea"]);
            $cantidad_recurso=$obCon->normalizar($_REQUEST["cantidad_recurso"]);
            $costo_unitario_recurso=$obCon->normalizar($_REQUEST["costo_unitario_recurso"]);
            $utilidad_recurso=$obCon->normalizar($_REQUEST["utilidad_recurso"]);
            $precio_venta=$obCon->normalizar($_REQUEST["precio_venta"]);
            $hora_o_fijo=$obCon->normalizar($_REQUEST["recurso_hora_fijo"]);
            $tipo_recurso=$obCon->normalizar($_REQUEST["tipo_recurso"]);
            
            if($nombre_recurso==''){
                exit("E1;Debe seleccionar el tipo de recurso;tipo_recurso");
            }
            
            if($nombre_recurso==''){
                exit("E1;El campo nombre del recurso no puede estar vacío;recurso_tarea");
            }
            if(!is_numeric($cantidad_recurso) or $cantidad_recurso<=0){
                exit("E1;El campo cantidad del recurso debe ser un numero mayor a cero;cantidad_recursos");
            }
            if(!is_numeric($costo_unitario_recurso) or $costo_unitario_recurso<=0){
                exit("E1;El campo costo unitario del recurso debe ser un numero mayor a cero;costo_unitario_recurso");
            }
            if(!is_numeric($utilidad_recurso) or $utilidad_recurso<0){
                exit("E1;El campo utilidad del recurso debe ser un numero mayor a cero;utilidad_recurso");
            }
            if(!is_numeric($precio_venta) or $precio_venta<0){
                exit("E1;El campo precio de venta del recurso debe ser un numero mayor a cero;precio_venta");
            }
                  
            $tab="$db.proyectos_recursos";
            $sql="SELECT ID,recurso_id FROM $tab WHERE nombre_recurso LIKE '$nombre_recurso' and tipo='$tipo_recurso'";
            $valida=$obCon->FetchAssoc($obCon->Query($sql));
            
            if($valida["ID"]>0){
                $recurso_id=$valida["recurso_id"];
            }else{
                $recurso_id=$obCon->getUniqId("rec_");
                $obCon->crear_recurso_proyecto($db, $recurso_id, $nombre_recurso, $hora_o_fijo,$tipo_recurso, $idUser);
            
            }
             
            $obCon->agregar_recurso_actividad($db, $proyecto_id, $tarea_id, $actividad_id,$tipo_recurso,$nombre_recurso, "", $hora_o_fijo, $recurso_id, $cantidad_recurso, $costo_unitario_recurso, $utilidad_recurso, $precio_venta, $precio_venta*$cantidad_recurso, $idUser);
            print("OK;Recurso Agregado");
        break;//Fin caso 12
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>