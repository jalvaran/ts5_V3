<?php
/**
 * Modulo de recaudo
 * 2020-09-24, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */

$myPage="recaudo.php";
$myTitulo="Recaudo";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");

$css = new PageConstruct($myTitulo, "", "", "");
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    
    $css->Modal("ModalAcciones", "TS5", "", 1);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    
    $css->Modal("ModalAccionesPOS", "POS TS5", "", 1);
        $css->div("DivFrmPOS", "", "", "", "", "", "");
        $css->Cdiv();
       
    $css->CModal("BntModalPOS", "onclick=AccionesPOS()", "button", "Guardar");
    
    
    $css->input("hidden", "TxtBtnVerActivo", "", "TxtBtnVerActivo", "", "", "", "", "", "");
    print("<br>");
    $css->CrearDiv("", "col-md-3", "center", 1, 1);
        $css->CrearBotonEvento("btnCrearEgreso", "Crear Egreso", 1, "onclick", "ModalCrearEgreso()", "verde");
    $css->CerrarDiv();
    print("<br>");
    print("<br>");
    $css->CrearDiv("", "col-md-12", "center", 1, 1);
    
        $css->TabInit();
            $css->TabLabel("TabCuentas1", "Cuentas Por Cobrar", "Tab_1", 1);
            $css->TabLabel("TabCuentas2", "Informe de Recaudo", "Tab_2");
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
                
                $css->CrearDiv("", "col-md-12", "left", 1, 1);

                    $css->CrearDiv("", "col-md-12", "left", 1, 1);
                        $css->CrearTabla();
                            $css->FilaTabla(16);
                                $css->ColTabla("<strong>Tercero</strong>", 6, "C");
                                $css->ColTabla("<strong>Abono</strong>", 1, "C");
                                $css->ColTabla("<strong>Guardar</strong>", 1, "C");                          
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);
                                print("<td colspan=6>");
                                    $css->select("cmbTercero", "form-control", "cmbTercero", "", "", "onchange=DibujeCuentaTercero()", "");
                                        $css->option("", "", "", "", "", "");
                                            print("SELECCIONE UN TERCERO");
                                        $css->Coption();
                                    $css->Cselect();    
                                print("</td>");
                                print("<td style=width:300px;>");
                                    $css->input_number_format("number", "txtAbono", "form-control", "txtAbono", "", "", "Abono", "off", "", "");
                                print("</td>");
                                print("<td>");
                                    $css->CrearBotonEvento("btnGuardar", "Abonar", 1, "onclick", "confirmaAbono()", "rojo");
                                print("</td>");
                                                      
                            $css->CierraFilaTabla();
                        $css->CerrarTabla();
                        $css->CrearDiv("DivMensajesImpresiones", "", "center", 1, 1);
                        
                        $css->CerrarDiv();
                        $css->CrearDiv("DivDocumentosTercero", "", "center", 1, 1);
                        
                        $css->CerrarDiv();
                    $css->CerrarDiv();
                    
                    
                    

                $css->CerrarDiv();
                
                
            /*
             * Fin codigo cuentas x pagar
             */
            $css->TabPaneEnd();
            $css->TabPaneInit("Tab_2");
                
                $css->CrearDiv("DivInformeReaudo", "", "center", 1, 1);
                    $css->h3("", "", "", "");
                        print("<strong>Informe de Recaudo por usuario</strong>");
                    $css->Ch3();
                    
                    $css->form("frmReporteRecuado", "form-control", "frmReporteRecuado", "post", "../../general/Consultas/PDF_Documentos.draw.php", "_blank", "", "style=border:0");
                        $css->input("hidden", "idDocumento", "", "idDocumento", "", 40, "", "", "", "");
                        $css->CrearTabla();
                            $css->FilaTabla(16);
                                $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
                                $css->ColTabla("<strong>Fecha Final</strong>", 1);
                                $css->ColTabla("<strong>Usuario</strong>", 1);
                                $css->ColTabla("<strong>Generar</strong>", 1);
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);
                                print("<td>");
                                    $css->input("date", "FechaInicialRangos", "form-control", "FechaInicialRangos", "Fecha", date("Y-m-d"), "Fecha Inicial", "off", "", "onchange=DibujeListadoSegunTipo();","style='line-height: 15px;'");
                                print("</td>");
                                print("<td>");
                                    $css->input("date", "FechaFinalRangos", "form-control", "FechaFinalRangos", "Fecha", date("Y-m-d"), "Fecha Inicial", "off", "", "onchange=DibujeListadoSegunTipo();","style='line-height: 15px;'");
                                print("</td>");
                                print("<td>");
                                    $css->select("cmbUsuario", "form-control", "cmbUsuario", "", "", "", "");
                                        if($_SESSION["tipouser"]<>'administrador'){
                                            $css->option("", "", "", $idUser, "", "");
                                                print($_SESSION["nombre"]." ".$_SESSION["apellido"]);
                                            $css->Coption();
                                        }else{
                                            $sql="SELECT idUsuarios,Nombre, Apellido, Identificacion FROM usuarios";
                                            $Consulta=$obCon->Query($sql);
                                            $css->option("", "", "", "ALL", "", "");
                                                print("Todos los usuarios");
                                            $css->Coption();
                                            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                                                $css->option("", "", "", $DatosConsulta["idUsuarios"], "", "");
                                                    print($DatosConsulta["Nombre"]." ".$DatosConsulta["Apellido"]." ".$DatosConsulta["Identificacion"]);
                                                $css->Coption();
                                            }
                                        }
                                    $css->Cselect();
                                print("</td>");
                                print("<td>");
                                    $css->input("submit", "btnEnviar", "form-control btn btn-success", "btnEnviar", "", "Enviar", "", "", "", "");
                                print("</td>");
                            $css->CierraFilaTabla();
                        $css->CerrarTabla();
                        
                    $css->Cform();
                $css->CerrarDiv();
                print("<br><br><br><br>");
            $css->TabPaneEnd();
            
            $css->TabPaneInit("Tab_3");
                $css->CrearDiv("DivDetallesCuentasXPagar", "", "center", 1, 1);
                
                $css->CerrarDiv();
            $css->TabPaneEnd();
            
            
        $css->TabContentEnd();
        $css->CerrarDiv();
    $css->CerrarDiv();
    
$css->PageFin();

print('<script src="jsPages/recaudo.js"></script>');
print('<script src="jsPages/pos.js"></script>');

$css->AddJSExcel();
$css->Cbody();
$css->Chtml();

?>