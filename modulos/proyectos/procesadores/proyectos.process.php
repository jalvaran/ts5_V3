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
        
        case 2://eliminar una fecha excluida
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
            $obCon->BorraReg($tabla, "ID", $item_id);
            print("OK;Fecha Eliminada");
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
       
        
            
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>