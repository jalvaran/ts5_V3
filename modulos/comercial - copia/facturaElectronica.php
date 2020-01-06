<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
/**
 * Pagina para la facturacion electronica
 * 2019-03-01, Julian Alvaran Techno Soluciones SAS
 */
$myPage="facturaElectronica.php";
$myTitulo="FE TS5";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    
    $css->Modal("ModalAccionesPOS", "POS TS5", "", 1);
        $css->div("DivFrmPOS", "", "", "", "", "", "");
        $css->Cdiv();
       
    $css->CModal("BntModalPOS", "onclick=AccionesPOS(event)", "button", "Guardar");
    
    $css->Modal("ModalAccionesPOSSmall", "POS TS5", "", 0);
        $css->div("DivFrmPOSSmall", "", "", "", "", "", "");
        $css->Cdiv();
       
    $css->CModal("BntModalPOSSmall", "onclick=AccionesPOS(event)", "button", "Guardar");
    
    $css->CrearDiv("", "col-md-12", "left", 1, 1); 
        $css->CrearBotonEvento("btnIniciar", "Iniciar", 1, "onclick", "VerificaReporteFacturas()", "azul", "");
        $css->CrearDiv("DivMensajes", "col-md-12", "left", 1, 1);
        
        $css->CerrarDiv();
    
    $css->Cdiv();

$css->PageFin();
print('<script src="../../componentes/shortcuts.js"></script>');  //script propio de la pagina
print('<script src="jsPages/facturaElectronica.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>