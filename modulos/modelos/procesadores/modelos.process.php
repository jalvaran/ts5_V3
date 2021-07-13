<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/modelos.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Modelos($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear o editar una modelo
            $jsonForm= $_REQUEST["jsonFormulario"];
            parse_str($jsonForm,$datos_formulario);
            
            
            foreach ($datos_formulario as $key => $value) {
                $datos_formulario[$key]=$obCon->normalizar($datos_formulario[$key]);
                if($value=='' and $key<>'ID'){
                    exit("E1;El campo $key no puede estar vacío");
                }
                if((!is_numeric($value) or $value<0) and ($key=="valor_servicio_20" or $key=="valor_servicio_30" or $key=="valor_servicio_60" or $key=="show" or $key=="masaje"  )){
                    exit("E1;El campo $key debe ser un valor numerico positivo");
                }
            }
            $nombre_artistico=$datos_formulario["NombreArtistico"];
            $sql="SELECT ID FROM modelos_db WHERE NombreArtistico='$nombre_artistico'";
            $validacion=$obCon->FetchAssoc($obCon->Query($sql));
            
            if($datos_formulario["ID"]==''){
                if($validacion["ID"]>0){
                    exit("E1;El nombre Artistico $nombre_artistico ya existe");
                }
                $sql=$obCon->getSQLInsert("modelos_db", $datos_formulario);
                $obCon->Query($sql);
            }else{
                if($validacion["ID"]>0 and $validacion["ID"]<>$datos_formulario["ID"]){
                    exit("E1;El nombre Artistico $nombre_artistico ya existe");
                }
                $id=$datos_formulario["ID"];
                $sql=$obCon->getSQLUpdate("modelos_db", $datos_formulario);
                $sql.=" WHERE ID='$id'";
                $obCon->Query($sql);
            }
            
            print("OK;Datos Guardados");
                
            
        break; //fin caso 1
        
        case 2: //editar el estado de una modelo
            $item_id=$obCon->normalizar($_REQUEST["item_id"]); 
            $estado=$obCon->normalizar($_REQUEST["estado"]);             
            $condicion='';
            if($item_id<>''){
                $condicion=" WHERE ID='$item_id'";
            }
            $sql="UPDATE modelos_db SET Estado='$estado' $condicion ";
            $obCon->Query($sql);
            print("OK;Registro Actualizado");
            
        break; //fin caso 2
        
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>