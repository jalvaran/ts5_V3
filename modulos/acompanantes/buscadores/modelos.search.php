<?php

include_once("../../../modelo/php_conexion.php");
session_start();
$idUser=$_SESSION['idUser'];
if($idUser==''){
    $json[0]['id']="";
    $json[0]['text']="Debe iniciar sesion para realizar la busqueda";
    echo json_encode($json);
    exit();
}
$obRest=new conexion($idUser);
$key=$obRest->normalizar($_REQUEST['q']);

$sql = "SELECT NombreArtistico,ID FROM modelos_db 
		WHERE NombreArtistico LIKE '%$key%' OR Identificacion = '$key'  OR ID = '$key' ORDER BY NombreArtistico ASC LIMIT 100"; 
$result = $obRest->Query($sql);
$json = [];

while($row = $obRest->FetchAssoc($result)){
    $Texto= utf8_encode($row['NombreArtistico']." // ".$row['ID']);
    $json[] = ['id'=>$row['ID'], 'text'=>$Texto];
}
echo json_encode($json);