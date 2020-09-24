<?php
/**
 * Cuentas x Cobrar
 * 2019-06-10, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */
$myPage="CuentasXCobrar.php";
$myTitulo="Cuentas X Cobrar";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");

$css = new PageConstruct($myTitulo, "", "", "");
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    
    $css->Modal("ModalAcciones", "TS5", "", 1);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    $css->input("hidden", "TxtBtnVerActivo", "", "TxtBtnVerActivo", "", "", "", "", "", "");
    print("<br>");
    $css->CrearDiv("", "col-md-12", "center", 1, 1);   
        $css->TabInit();
            $css->TabLabel("TabCuentas1", "Cuentas Por Cobrar", "Tab_1", 1);
            $css->TabLabel("TabCuentas2", "Documentos Contables", "Tab_2");
            $css->TabLabel("TabCuentas3", "Detalles", "Tab_3");          
        $css->TabInitEnd();
        $css->TabContentInit();
            $css->TabPaneInit("Tab_1", 1);
                /*Espacio para las cuentas x cobrar
                 * 
                 */
            $css->CrearDiv("", "col-md-12", "left", 1, 1);   
                    $css->h3("", "", "", "");
                            print("<strong>Cuentas Por Cobrar</strong>");
                    $css->Ch3();
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
                
            /*
             * Fin codigo cuentas x pagar
             */
            $css->TabPaneEnd();
            $css->TabPaneInit("Tab_2");
                include_once 'DocumentosContablesBody.php';
            $css->TabPaneEnd();
            
            $css->TabPaneInit("Tab_3");
                $css->CrearDiv("DivDetallesCuentasXPagar", "", "center", 1, 1);
                
                $css->CerrarDiv();
            $css->TabPaneEnd();
            
            
        $css->TabContentEnd();
        $css->CerrarDiv();
    $css->CerrarDiv();
    
$css->PageFin();

print('<script src="jsPages/CuentasXCobrar.js"></script>');
print('<script src="jsPages/DocumentosContables.js"></script>');  //script propio de la pagina
$css->AddJSExcel();
$css->Cbody();
$css->Chtml();

?>