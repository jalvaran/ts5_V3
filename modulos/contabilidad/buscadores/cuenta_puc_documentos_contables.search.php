<?php

include_once("../../../modelo/php_conexion.php");
@session_start();
$idUser=$_SESSION['idUser'];
if($idUser==''){
    $json[0]['id']="";
    $json[0]['text']="Debe iniciar sesion para realizar la busqueda";
    echo json_encode($json);
    exit();
}
$obRest=new ProcesoVenta($idUser);
$key=$obRest->normalizar($_REQUEST['q']);
$tipo=$obRest->normalizar($_REQUEST['tipo']);
$condicional="";
if($tipo==1){
    $condicional=" AND (PUC LIKE '1%' or PUC LIKE '5%')";
}
if($tipo==2){
    $condicional=" AND (PUC LIKE '1%')";
}
if($tipo==3){
    $condicional=" AND (PUC LIKE '13%' or PUC LIKE '23%')";
}
$sql = "SELECT * FROM subcuentas 
		WHERE (Nombre LIKE '%$key%' or PUC LIKE '$key%') AND LENGTH(PUC)>=6 $condicional
		LIMIT 50"; 
$result = $obRest->Query($sql);
$json = [];

while($row = $obRest->FetchAssoc($result)){
    $Texto=$row['Nombre']." ".$row['PUC'];
     $json[] = ['id'=>$row['PUC'], 'text'=>$Texto];
}
echo json_encode($json);