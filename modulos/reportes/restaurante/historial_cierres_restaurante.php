<?php
/**
 * historial de cierres de restaurante
 * 2019-08-29, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */
$myPage="historial_cierres_restaurante.php";
$myTitulo="Cierres Restaurante";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");

$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html

$obCon = new conexion($idUser); //Conexion a la base de datos
$NombreUser=$_SESSION['nombre'];

$sql="SELECT TipoUser,Role FROM usuarios WHERE idUsuarios='$idUser'";
$DatosUsuario=$obCon->Query($sql);
$DatosUsuario=$obCon->FetchAssoc($DatosUsuario);
$TipoUser=$DatosUsuario["TipoUser"];

$css->PageInit($myTitulo);
    print("<br>");
    $css->CrearDiv("", "col-md-12", "left", 1, 1);
    
    
    $css->CerrarDiv();
    
$css->PageFin();
//print('<script>SeleccioneTablaDB(`ts_eps_ips_890300513.vista_hoja_trabajo_cruce`)</script>');  //script propio de la pagina
print('<script>SeleccioneTablaDB(`restaurante_cierres`)</script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>