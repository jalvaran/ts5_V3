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
$obRest=new ProcesoVenta($idUser);
$key=$obRest->normalizar($_REQUEST['q']);

$sql = "SELECT t1.idFacturas, t1.NumeroFactura, t1.Prefijo,t1.Fecha,t1.Total,
        (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=t1.Clientes_idClientes LIMIT 1) AS RazonSocialCliente,
        (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=t1.Clientes_idClientes LIMIT 1) AS NIT_Cliente
        FROM facturas t1 WHERE t1.NumeroFactura = '$key' or t1.idFacturas='$key' ORDER BY idFacturas DESC LIMIT 50"; 
$result = $obRest->Query($sql);
$json = [];

while($row = $obRest->FetchAssoc($result)){
    $Texto= utf8_encode($row['Fecha']." || ".$row['Prefijo'].$row['NumeroFactura']." || ".$row['RazonSocialCliente']." || ".($row['NIT_Cliente'])." || ".number_format($row['Total']));
     $json[] = ['id'=>$row['idFacturas'], 'text'=>$Texto];
}
echo json_encode($json);