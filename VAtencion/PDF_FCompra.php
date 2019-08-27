<?php 
$myPage="PDF_FCompra.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/PrintPos.php");

if(isset($_REQUEST["ID"])){
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
    $obPrint=new PrintPos($idUser);
    $idCompra=$obVenta->normalizar($_REQUEST["ID"]);
    $obTabla->PDF_FacturaCompra($idCompra, "");  
    $obPrint->ImprimeFacturaCompra($idCompra, "", 1, "");
}
?>