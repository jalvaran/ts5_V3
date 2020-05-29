<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/inteligencia.class.php");
include_once("../clases/inteligenciaExcel.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Inteligencia($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1://Verifica si ya existe la referencia de un producto o servicio
            $Referencia=$obCon->normalizar($_REQUEST['TxtReferencia']);
            $Tabla=$obCon->normalizar($_REQUEST['Tabla']);
            if($Tabla==1){
                $Tabla="productosventa";
            }
            $Datos=$obCon->ValorActual("$Tabla", "Referencia", " Referencia='$Referencia'");
            if($Datos["Referencia"]<>''){
                print("E1;La Referencia Digitada ya existe");
                exit();
            }
            print("OK;Referencia disponible");
        break;//Fin caso 1
        
        case 2://Genere el excel con el listado de clientes
            $obExcel= new ExcelInteligencia($idUser);
            $Condicion= urldecode(base64_decode($_REQUEST["c"]));            
            $obExcel->ListadoClientesExcel($Condicion);
            print("OK;Hoja Exportada");
        break;//fin caso 2
        
            
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>