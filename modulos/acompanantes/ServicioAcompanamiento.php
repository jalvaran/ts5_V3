<?php
/**
 * Registra los servicios de acompañamiento de un bar
 * 2019-08-26, Julian Alvaran Techno Soluciones SAS
 */
$myPage="ServicioAcompanamiento.php";
$myTitulo="Servicios Modelos";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    
    $css->Modal("ModalAcciones", "TS5", "", 0);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();
        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    $css->CrearDiv("", "col-md-8", "center", 1, 1);
        print("<h3>MÓDULO DE ACOMPAÑANTES<h3>");
    $css->CerrarDiv();
    $css->CrearDiv("", "col-md-4", "center", 1, 1);
        print('<br><div class="input-group">');
        $css->input("text", "TxtBusquedas", "form-control", "TxtBusquedas", "", "", "Buscar Modelo", "", "", "onchange=BuscarModelo()");


         print('<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
              </div>');
    $css->CerrarDiv();
    print("<br><br><br>");
    $css->CrearDiv("divContenedr", "container", "left", 1, 1);
     $css->TabInit();
            $css->TabLabel("Tab1", "<strong>Registrar Servicios</strong>", "Tab_1", 1,"onclick='DibujeServicios();idPestana=1;'");
            
            $css->TabLabel("Tab2", "<strong>Resumen Servicios</strong>", "Tab_2",0,"onclick='DibujeResumenTurno();idPestana=2;'");
            $css->TabLabel("Tab3", "<strong>Cuentas por Pagar</strong>", "Tab_3",0,"onclick='DibujeCuentasXPagarServicios();idPestana=3;'");
        $css->TabInitEnd();
        $css->TabContentInit();
        
        
        $css->TabPaneInit("Tab_1", 1);
            $css->section("", "contentTab1", "", "");
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    $css->CrearTitulo("<strong>Registro de Servicios</strong>", "azul");
                    $css->CrearTabla();
                        $css->FilaTabla(16);
                            $css->ColTabla("<strong>Modelo</strong>", 1);
                            $css->ColTabla("<strong>Servicio</strong>", 1);
                            $css->ColTabla("<strong>Valor</strong>", 1);
                            $css->ColTabla("<strong>Agregar</strong>", 1);
                        $css->CierraFilaTabla();
                        
                        $css->FilaTabla(16);
                            print("<td>");
                                $css->select("CmbModelo", "form-control", "CmbModelo", "", "", "", "");
                                    $css->option("", "", "", "", "", "");
                                        print("Seleccione una modelo");
                                    $css->Coption();
                                $css->Cselect();
                            print("</td>");
                            print("<td>");
                                $css->select("CmbTipoServicio", "form-control", "CmbTipoServicio", "", "", "", "onchange='ObtengaValorServicio()'");
                                    $css->option("", "", "", "", "", "");
                                        print("Seleccione el tipo de Servicio");
                                    $css->Coption();
                                    $Consulta=$obCon->ConsultarTabla("modelos_tipo_servicios", "WHERE Habilitado=1");
                                    
                                    while($DatosTipoServicio=$obCon->FetchAssoc($Consulta)){
                                        $css->option("", "", "", $DatosTipoServicio["ID"], "", "");
                                            print($DatosTipoServicio["Servicio"]);
                                        $css->Coption();
                                    }
                                
                                $css->Cselect();
                            print("</td>");
                            
                            print("<td>");
                                $css->input("text", "ValorServicio", "form-control", "ValorServicio", "", "", "Valor del Servicio", "off", "", "");
                                
                            print("</td>");
                            print("<td>");
                                $css->CrearBotonEvento("BtnAgregarServicio", "Agregar", 1, "onclick", "AgregarServicio()", "verde", "");
                            print("</td>");
                            
                        $css->CierraFilaTabla();
                    $css->CerrarTabla();
                    
                    $css->CrearDiv("DivServicios", "", "left", 1, 1);
                    
                    $css->CerrarDiv();
                    
                $css->CerrarDiv();
            $css->Csection();
        $css->TabPaneEnd();
        
        $css->TabPaneInit("Tab_2", 0);
            $css->section("", "contentTab2", "", "");
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    $css->CrearTitulo("<strong>Resumen de servicios en este turno</strong>", "verde");

                    $css->CrearDiv("DivResumenTurno", "", "left", 1, 1);
                    
                    $css->CerrarDiv();
                $css->CerrarDiv();
            $css->Csection();
        $css->TabPaneEnd();
        
        $css->TabPaneInit("Tab_3", 0);
            $css->section("", "contentTab2", "", "");
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    $css->CrearTitulo("<strong>Cuentas por Pagar</strong>", "naranja");

                    $css->CrearDiv("DivCuentasXPagar", "", "left", 1, 1);
                    
                    $css->CerrarDiv();
                $css->CerrarDiv();
                
                
            $css->Csection();
        $css->TabPaneEnd();
    $css->CerrarDiv();
$css->PageFin();

print('<script src="jsPages/ServicioAcompanamiento.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>