<?php 
$myPage="PDF_Informes_Ventas.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/PrintPos.php");
if(isset($_REQUEST["BtnVerInformeAdmin"])){
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
    $obPrint= new PrintPos($idUser);
    $FechaCorte = $obVenta->normalizar($_POST["TxtFechaCorte"]);
    $FechaIni = $obVenta->normalizar($_POST["TxtFechaIni"]);
    $FechaFinal = $obVenta->normalizar($_POST["TxtFechaFinal"]);
    $CentroCostos=$obVenta->normalizar($_POST["CmbCentroCostos"]);
    $EmpresaPro=$obVenta->normalizar($_POST["CmbEmpresaPro"]);
    $TipoReporte=$obVenta->normalizar($_POST["CmbTipoReporte"]);
    $obTabla->PDF_Informe_Ventas_Admin($TipoReporte,$FechaCorte,$FechaIni, $FechaFinal,$CentroCostos,$EmpresaPro,"");
    $ip=$_SERVER['REMOTE_ADDR'];
    $ipServer=$_SERVER['SERVER_ADDR'];
    if($ip==$ipServer){
        $obPrint->ImprimeCierreAdmin($idUser, $FechaIni, $FechaFinal);
    }
    
    
}
?>