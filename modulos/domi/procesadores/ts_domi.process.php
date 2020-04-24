<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
function validateDate($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

include_once("../clases/ts_domi.class.php");

if( !empty($_REQUEST["Accion"]) ){
    
    $obCon=new Domi($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear o editar un local
            
            $Datos["idCategoria"]=$obCon->normalizar($_REQUEST["cmbCategoriaLocal"]);
            $Datos["Nombre"]=$obCon->normalizar($_REQUEST["NombreLocal"]);
            $Datos["Descripcion"]=$obCon->normalizar($_REQUEST["Descripcion"]);
            $Datos["Telefono"]=$obCon->normalizar($_REQUEST["Telefono"]);
            $Datos["Direccion"]=$obCon->normalizar($_REQUEST["Direccion"]);
            
            $TipoFormulario=$obCon->normalizar($_REQUEST["TipoFormulario"]);
            $idEditar=$obCon->normalizar($_REQUEST["idEditar"]);
            
            foreach ($Datos as $key => $value) {
                if($value=='' ){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
            }
            if(empty($_FILES['Fondo']['name'])){
                
                exit("E1;Debe Adjuntar un fondo para el local;Local");
            }else{
                $info = new SplFileInfo($_FILES['Fondo']['name']);
                $Extension=($info->getExtension());  
                if($Extension<>'jpg' and $Extension<>'png' and $Extension<>'jpeg'){
                    exit("E1;Solo se permiten imagenes;Local");
                }
            } 
            
            $Tabla="locales";
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000); 
            
            if($TipoFormulario==1){
                $sql="SELECT MAX(Orden) as Orden FROM locales";
                $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                $DatosLocal=$obCon->FetchAssoc($Consulta);
                $idCategoria=$Datos["idCategoria"];
                $sql="SELECT Icono,ColorIcono FROM catalogo_categorias WHERE id='$idCategoria'";
                $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                $DatosCategorias=$obCon->FetchAssoc($Consulta);
                $Datos["Icono"]=$DatosCategorias["Icono"];
                $Datos["ColorIcono"]=$DatosCategorias["ColorIcono"];
                $Datos["Orden"]=$DatosLocal["Orden"]+1;
                $Datos["Created"]=date("Y-m-d H:i:s");
                $Datos["idUser"]=$idUser;
                $Datos["Estado"]=1;
                $sql=$obCon->getSQLInsert($Tabla, $Datos);
                $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                $sql="SELECT MAX(ID) as ID FROM locales";
                $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                $DatosLocal=$obCon->FetchAssoc($Consulta);
                $idLocal=$DatosLocal["ID"];
                $db="ts_domi_$idLocal";
                $sql="UPDATE locales set db='$db' WHERE ID='$idLocal'";
                $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
            }
            if($TipoFormulario==2){
                $sql=$obCon->getSQLUpdate($Tabla, $Datos);
                $sql.=" WHERE ID='$idEditar'";
                $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                $idLocal=$idEditar;
                
            }
            
            $Extension="";
            if(!empty($_FILES['Fondo']['name'])){
                
                $info = new SplFileInfo($_FILES['Fondo']['name']);
                $Extension=($info->getExtension());  
                $Tamano=filesize($_FILES['Fondo']['tmp_name']);
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 2000);
                
                $carpeta=$DatosConfiguracion["Valor"];
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta=$DatosConfiguracion["Valor"].$idLocal."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                opendir($carpeta);
                $idAdjunto=uniqid(true);
                $destino=$carpeta.$idAdjunto.".".$Extension;
                
                
                if($TipoFormulario==2){
                    $sql="SELECT Ruta FROM locales_imagenes WHERE idLocal='$idLocal' LIMIT 1";
                    $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                    $DatosValidacion=$obCon->FetchAssoc($Consulta);
                    if (file_exists($DatosValidacion["Ruta"])) {
                        unlink($DatosValidacion["Ruta"]);
                    }
                    $sql="DELETE FROM locales_imagenes WHERE idLocal='$idLocal'";
                    $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                }
                move_uploaded_file($_FILES['Fondo']['tmp_name'],$destino);
                $obCon->RegistreFondoLocal($DatosServidor,$idLocal, $destino, $Tamano, $_FILES['Fondo']['name'], $Extension, $idUser);
            }
            
            print("OK;Registro Guardado Correctamente;$idEditar");
            
        break;//Fin caso 1
       
        case 2:// crea o edita una clasificacion
            $Datos["Clasificacion"]=$obCon->normalizar($_REQUEST["Clasificacion"]);
            $Datos["Estado"]=$obCon->normalizar($_REQUEST["Estado"]);
            $dbLocal=$obCon->normalizar($_REQUEST["dbLocal"]);
            if(!isset($_REQUEST["idEditar"])){
                exit("E1;No se recibió la base de datos");
            }
            $TipoFormulario=$obCon->normalizar($_REQUEST["TipoFormulario"]);
            $idEditar=$obCon->normalizar($_REQUEST["idEditar"]);
            
            foreach ($Datos as $key => $value) {
                if($value=='' ){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
            }
            
            if($dbLocal=='' ){
                exit("E1;No se recibió la base de datos");
            }
            
            
                
            $Tabla="inventarios_clasificacion";
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000); 
            $DatosServidor["DataBase"]=$dbLocal;
            if($TipoFormulario==1){
                
                $sql=$obCon->getSQLInsert($Tabla, $Datos);
                $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                
            }
            if($TipoFormulario==2){
                $sql=$obCon->getSQLUpdate($Tabla, $Datos);
                $sql.=" WHERE ID='$idEditar'";
                $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                
                
            }
            print("OK;Registro Guardado Correctamente");
        break;//Fin caso 2    
        
        case 3: //Crear o editar un producto
            
            $Datos["idClasificacion"]=$obCon->normalizar($_REQUEST["idClasificacion"]);
            $Datos["Referencia"]=$obCon->normalizar($_REQUEST["Referencia"]);
            $Datos["Nombre"]=$obCon->normalizar($_REQUEST["Nombre"]);
            $Datos["PrecioVenta"]=$obCon->normalizar($_REQUEST["PrecioVenta"]);
            $Datos["DescripcionCorta"]=$obCon->normalizar($_REQUEST["DescripcionCorta"]);
            $Datos["DescripcionLarga"]=$obCon->normalizar($_REQUEST["DescripcionLarga"]);
            $Datos["Estado"]=$obCon->normalizar($_REQUEST["Estado"]);
            $Datos["Orden"]=$obCon->normalizar($_REQUEST["Orden"]);
            
            $dbLocal=$obCon->normalizar($_REQUEST["dbLocal"]);
            if(!isset($_REQUEST["idEditar"])){
                exit("E1;No se recibió la base de datos");
            }
            $TipoFormulario=$obCon->normalizar($_REQUEST["TipoFormulario"]);
            $idEditar=$obCon->normalizar($_REQUEST["idEditar"]);
            
            foreach ($Datos as $key => $value) {
                if($value=='' and $key<>'DescripcionLarga'){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
            }
            
            if($dbLocal=='' ){
                exit("E1;No se recibió la base de datos");
            }
            
            $Tabla="productos_servicios";
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000); 
            $DatosServidor["DataBase"]=$dbLocal;
            
            if($TipoFormulario==1){
                if(empty($_FILES['ImagenProducto']['name'])){

                    exit("E1;Debe Adjuntar una Imagen para el Producto;ImagenProducto");
                }else{
                    $info = new SplFileInfo($_FILES['ImagenProducto']['name']);
                    $Extension=($info->getExtension());  
                    if($Extension<>'jpg' and $Extension<>'png' and $Extension<>'jpeg'){
                        exit("E1;Solo se permiten imagenes;ImagenProducto");
                    }
                } 
            }
            
            if($TipoFormulario==1){
                $idProducto=$obCon->getUniqId();
                $Datos["Created"]=date("Y-m-d H:i:s");
                $Datos["idUser"]=$idUser;
                $Datos["ID"]=$idProducto;
                $sql=$obCon->getSQLInsert($Tabla, $Datos);
                $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                
            }
            if($TipoFormulario==2){
                $sql=$obCon->getSQLUpdate($Tabla, $Datos);
                $sql.=" WHERE ID='$idEditar'";
                $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                $idProducto=$idEditar;
                
            }
            
            $Extension="";
            if(!empty($_FILES['ImagenProducto']['name'])){
                
                $info = new SplFileInfo($_FILES['ImagenProducto']['name']);
                $Extension=($info->getExtension()); 
                if($Extension<>'jpg' and $Extension<>'png' and $Extension<>'jpeg'){
                    exit("E1;Solo se permiten imagenes;ImagenProducto");
                }
                $Tamano=filesize($_FILES['ImagenProducto']['tmp_name']);
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 2001);
                
                $carpeta=$DatosConfiguracion["Valor"];
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta=$DatosConfiguracion["Valor"].$idProducto."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                opendir($carpeta);
                $idAdjunto=uniqid(true);
                $destino=$carpeta.$idAdjunto.".".$Extension;
                
                
                if($TipoFormulario==2){
                    $sql="SELECT ID,Ruta FROM productos_servicios_imagenes WHERE idProducto='$idProducto' LIMIT 1";
                    $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                    $DatosValidacion=$obCon->FetchAssoc($Consulta);
                    $idImagen=$DatosValidacion["ID"];
                    if (file_exists($DatosValidacion["Ruta"])) {
                        unlink($DatosValidacion["Ruta"]);
                    }
                    $sql="DELETE FROM productos_servicios_imagenes WHERE ID='$idImagen'";
                    $obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                }
                move_uploaded_file($_FILES['ImagenProducto']['tmp_name'],$destino);
                $obCon->RegistreImagenProducto($DatosServidor,$idProducto, $destino, $Tamano, $_FILES['ImagenProducto']['name'], $Extension, $idUser);
            }
            
            print("OK;Registro Guardado Correctamente");
            
        break;//Fin caso 3
       
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>