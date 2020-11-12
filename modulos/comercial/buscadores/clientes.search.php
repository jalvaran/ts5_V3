<?php

//include_once("../../../modelo/php_conexion.php");
include_once("../clases/AcuerdoPago.class.php");
@session_start();
$idUser=$_SESSION['idUser'];
if($idUser==''){
    $json[0]['id']="";
    $json[0]['text']="Debe iniciar sesion para realizar la busqueda";
    echo json_encode($json);
    exit();
}
$obRest=new AcuerdoPago($idUser);
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
    $Tercero=$row['Num_Identificacion'];
    $datos_acuerdo["idAcuerdoPago"]="";
    $EstadoGeneral="AL DIA";
    $sql2="SELECT idAcuerdoPago FROM acuerdo_pago WHERE Tercero='$Tercero' AND (Estado=1 or Estado=12)  LIMIT 1";
    $datos_acuerdo=$obRest->FetchAssoc($obRest->Query($sql2));
        
    if($datos_acuerdo["idAcuerdoPago"]<>''){
        $idAcuerdo=$datos_acuerdo["idAcuerdoPago"];
        $EstadoAcuerdo=$obRest->ObtengaEstadoGeneralAcuerdo($idAcuerdo);        
        if($EstadoAcuerdo==4){
            $EstadoGeneral="EN MORA";
        }
    }
    
    $Texto= utf8_encode($row['RazonSocial'])." ".$row['Num_Identificacion']." ".$row['Telefono']." ".number_format($row["TotalCredito"])." Estado: ".$EstadoGeneral;
     $json[] = ['id'=>$row['idClientes'], 'text'=>$Texto];
}
echo json_encode($json);