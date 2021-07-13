<?php
/**
 * POS para clubes nocturnos
 * 2021-07-12, Julian Alvaran Techno Soluciones SAS
 */
$myPage="modelos.php";
$myTitulo="Coltrol de Modelos";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);

    $css->Modal("ModalAcciones", "TS5", "", 0);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();
        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    
    $css->Modal("ModalAccionesPOS", "POS TS5", "", 1);
        $css->div("DivFrmPOS", "", "", "", "", "", "");
        $css->Cdiv();
       
    $css->CModal("BntModalPOS", "onclick=AccionesPOS(event)", "button", "Guardar");
    
    $css->Modal("ModalAccionesPOSSmall", "POS TS5", "", 0);
        $css->div("DivFrmPOSSmall", "", "", "", "", "", "");
        $css->Cdiv();
       
    $css->CModal("BntModalPOSSmall", "onclick=AccionesPOS(event)", "button", "Guardar");
    $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
    $Habilita=1;
    if($DatosCaja["ID"]==''){
        print("<h3>  No tienes una caja asignada, no puedes continuar</h3>");
        $Habilita=0;
    }
    $css->CrearDiv("DivMensajes", "container", "center", 1, 1);
    
    $css->CerrarDiv();
    
    $css->input("hidden", "idCajero", "", "idCajero", "", $idUser, "", "", "", "");
    print('<br>');
    print('<div class="col-md-12">');
        print('<div class="box-tools pull-right">');
            print('<div class="input-group">
                    <input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar...">
                        <span class="input-group-btn">
                          <button name="btn_busqueda" id="btn_busqueda" class="btn btn-flat"><i class="fa fa-search"></i>
                          </button>
                        </span>
                  </div>');
        print('</div>');
        print('<div class="nav-tabs-custom">');
            print('<ul class="nav nav-tabs">');
                print('<li class="active" onclick="idPestana=1;DibujeServicios();"><a href="#tab_list_1" data-toggle="tab" aria-expanded="true">Listado de Servicios</a></li>');
                print('<li class="" onclick="listado_id=2;ver_listado_segun_id();"></span><a href="#tab_list_2" data-toggle="tab" aria-expanded="false">Modelos Activas</a></li>');
                print('<li class="" onclick="listado_id=3;ver_listado_segun_id();"><a href="#tab_list_3" data-toggle="tab" aria-expanded="false">Base de datos Modelos</a></li>');
                print('<li class="" onclick="idPestana=3;DibujeCuentasXPagarServicios();"><a href="#tab_list_4" data-toggle="tab" aria-expanded="false">Cuentas X Pagar</a></li>');                                
                print('<li class="" onclick="idPestana=2;DibujeResumenTurno();"><a href="#tab_list_5" data-toggle="tab" aria-expanded="false">Resumen</a></li>');
               // print('<li class="" onclick="idPestana=3;DibujeCuentasXPagarServicios();"><a href="#tab_list_6" data-toggle="tab" aria-expanded="false">Opciones</a></li>');
            print('</ul>');
            
            print('<div class="tab-content">');
                print('<div id="tab_list_1" class="tab-pane active">');
                    
                        
                        $css->section("", "contentTab1", "", "");
                            print('<div class="row">');
                            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                                $css->CrearTitulo("<strong>Registro de Servicios</strong>", "azul");
                                $css->CrearTabla();
                                    $css->FilaTabla(16);
                                        $css->ColTabla("<strong>Modelo</strong>", 1);
                                        $css->ColTabla("<strong>Servicio</strong>", 1);
                                        $css->ColTabla("<strong>Efectivo</strong>", 1);
                                        $css->ColTabla("<strong>Tarjetas</strong>", 1);
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
                                            $css->input("text", "TxtEfectivo", "form-control", "TxtEfectivo", "", "0", "Efectivo", "off", "", "onkeyUp=CalculeFormasPago(1)");

                                        print("</td>");print("<td>");
                                            $css->input("text", "TxtTarjetas", "form-control", "TxtTarjetas", "", "0", "Tarjetas", "off", "", "onkeyUp=CalculeFormasPago(2)");

                                        print("</td>");
                                        print("<td>");
                                            $css->input("text", "ValorServicio", "form-control", "ValorServicio", "", "", "Valor del Servicio", "off", "", "onkeyUp=IgualeValorEfectivo()");

                                        print("</td>");
                                        print("<td>");
                                            $css->CrearBotonEvento("BtnAgregarServicio", "Agregar", 1, "onclick", "AgregarServicio()", "verde", "");
                                        print("</td>");

                                    $css->CierraFilaTabla();
                                $css->CerrarTabla();

                                $css->CrearDiv("DivServicios", "", "left", 1, 1);

                                $css->CerrarDiv();

                            $css->CerrarDiv();
                            $css->CerrarDiv();
                        $css->Csection();
                    //print('</div>');
                print('</div>');
                print('<div id="tab_list_2" class="tab-pane">');
                    print('<div class="row">');
                        print('<div id="list_2" class="col-md-12 ts_list_forms">');
                            
                        print('</div>');
                    print('</div>');
                print('</div>');
                print('<div id="tab_list_3" class="tab-pane">');
                    print('<div class="row">');
                        print('<div id="list_3" class="col-md-12 ts_list_forms">');
                            
                        print('</div>');
                    print('</div>');
                print('</div>');
                print('<div id="tab_list_4" class="tab-pane">');
                    print('<div class="row">');
                        $css->CrearDiv("", "col-md-12", "center", 1, 1);
                            $css->CrearTitulo("<strong>Cuentas por Pagar</strong>", "naranja");

                            $css->CrearDiv("DivCuentasXPagar", "", "left", 1, 1);

                            $css->CerrarDiv();
                        $css->CerrarDiv();
                    print('</div>');    
                print('</div>');
                print('<div id="tab_list_5" class="tab-pane">');
                    print('<div class="row">');
                        $css->CrearDiv("", "col-md-12", "center", 1, 1);
                            $css->CrearTitulo("<strong>Resumen de servicios en este turno</strong>", "verde");

                            $css->CrearDiv("DivResumenTurno", "", "left", 1, 1);

                            $css->CerrarDiv();
                        $css->CerrarDiv();
                    $css->CerrarDiv();
                print('</div>');
                
            print('</div>');  //Fin content
        print('</div>');  //Fin tabs    
        
    print('</div>');  //Fin column    
            
        
$css->PageFin();
print('<script src="../../componentes/shortcuts.js"></script>');  //script propio de la pagina
print('<script src="jsPages/modelos.js"></script>');  //script propio de la pagina
print('<script src="jsPages/ServicioAcompanamiento.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>