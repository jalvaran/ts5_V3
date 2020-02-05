<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/admindb.class.php");

if( !empty($_REQUEST["Accion"]) ){
    
    $obCon=new AdminDataBase($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Insertar un registro
            $DataBase="ts5";
            $Tabla="abonos_libro";
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]);
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            $idLibroDiario=$obCon->normalizar($_REQUEST["idLibroDiario"]);
            $idComprobanteContable=$obCon->normalizar($_REQUEST["idComprobanteContable"]);
            $TipoAbono=$obCon->normalizar($_REQUEST["TipoAbono"]);
            
            if(!is_numeric($Cantidad) or $Cantidad<=0){
                exit("E1;El campo cantidad debe ser un numero mayor a Cero, no sea mk;Cantidad");
            }
            
            $sql="SELECT idComprobanteContable FROM $DataBase.$Tabla WHERE idComprobanteContable='$idComprobanteContable' LIMIT 1";
            $DatosValidacion=$obCon->FetchAssoc($obCon->Query($sql));
            if($DatosValidacion["idComprobanteContable"] <> ""){
                exit("E1;No sea mkon y no mande datos repetidos;idComprobanteContable");
            }
            $Datos["Fecha"]=$Fecha;
            $Datos["Cantidad"]=$Cantidad;
            $Datos["idLibroDiario"]=$idLibroDiario;
            $Datos["idComprobanteContable"]=$idComprobanteContable;
            $Datos["TipoAbono"]=$TipoAbono;
            
            $sql=$obCon->getSQLInsert($DataBase.".".$Tabla, $Datos);
            $obCon->Query($sql);
            print("OK;Registro insertado correctamente");
        break;//Fin caso 1
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>