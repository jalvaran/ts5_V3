<?php
/**
 * Reportes de contabilidad
 * 2019-05-22, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */
$myPage="CuentasXPagar.php";
$myTitulo="Cuentas X Pagar";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");

$css = new PageConstruct($myTitulo, "", "", "");
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
        
    $css->CrearDiv("", "col-md-12", "center", 1, 1);   
        print("<h3>CUENTAS POR PAGAR</h3>");
    $css->CerrarDiv();
    $css->CrearDiv("", "col-md-6", "left", 1, 1);
    
        $css->CrearDiv("", "col-md-6", "left", 1, 1);
        
        $css->CerrarDiv();
        print('<div class="input-group">');
        $css->input("text", "TxtBusquedasTercero", "form-control", "TxtBusquedasTercero", "", "", "Buscar Tercero", "", "", "onkeyup=BuscarTercero()");
        
                        
         print('<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
              </div>');
        $css->CrearDiv("DivOpcionesCuentaGeneral", "", "left", 1, 1);

        $css->CerrarDiv();
        $css->CrearDiv("DivCuentasGeneral", "", "center", 1, 1);

        $css->CerrarDiv();
        
    $css->CerrarDiv();
    $css->CrearDiv("", "col-md-6", "left", 1, 1);
    
        $css->CrearDiv("", "col-md-6", "left", 1, 1);
        
        $css->CerrarDiv();
        print('<div class="input-group">');
        $css->input("text", "TxtBusquedasReferencia", "form-control", "TxtBusquedasReferencia", "", "", "Buscar Documento Referencia", "", "", "onkeyup=BuscarDocumentoReferencia()");
        
                        
         print('<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
              </div>');
        $css->CrearDiv("DivOpcionesCuentaGeneral", "", "left", 1, 1);

        $css->CerrarDiv();
        $css->CrearDiv("DivDocumentosTercero", "", "center", 1, 1);

        $css->CerrarDiv();
        
    $css->CerrarDiv();
    
$css->PageFin();

print('<script src="jsPages/CuentasXPagar.js"></script>');
$css->AddJSExcel();
$css->Cbody();
$css->Chtml();

?>