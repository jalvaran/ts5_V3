<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/admindb.class.php");
include_once("../../../constructores/paginas_constructor.php");

if(!empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new AdminDataBase($idUser);
    
    switch($_REQUEST["Accion"]) {
        case 1://listar las tablas de una base de datos
            
            $DataBase=$obCon->normalizar($_REQUEST["cmbDataBase"]);
            $sql="SELECT table_name, table_rows
                FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '$DataBase';";
            $Consulta=$obCon->Query($sql);
            
            while($DatosTablas=$obCon->FetchAssoc($Consulta)){
                print($DatosTablas["table_name"]."<br>");
            }
            
        break;//fin caso 1  
        
    }
    
          
}else{
    print("No se enviaron parametros");
}
?>