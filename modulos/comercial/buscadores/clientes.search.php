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

$sql = "SELECT t1.RazonSocial,t1.Num_Identificacion,t1.Telefono,t1.idClientes,
            (SELECT SUM(Neto) FROM librodiario t2 WHERE t2.Tercero_Identificacion=t1.Num_Identificacion 
            AND EXISTS(SELECT 1 FROM contabilidad_parametros_cuentasxcobrar t3 WHERE t2.CuentaPUC like t3.CuentaPUC)) as TotalCredito 
            FROM clientes t1 
            WHERE t1.RazonSocial LIKE '%$key%' or t1.Num_Identificacion LIKE '%$key%' OR  t1.Telefono LIKE '%$key%'
            LIMIT 100"; 

$result = $obRest->Query($sql);

$json = [];

while($row = $obRest->FetchAssoc($result)){
    
    $Texto= utf8_encode($row['RazonSocial'])." ".$row['Num_Identificacion']." ".$row['Telefono']."  ".number_format($row["TotalCredito"]);
     $json[] = ['id'=>$row['idClientes'], 'text'=>$Texto];
}
echo json_encode($json);