<?php
/**
 * Pagina para administracion de los acuerdos de pago
 * 2020-03-06, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */

$myPage="adminAcuerdosPago.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Administrador de Acuerdos de Pago";  //Titulo en la pestaña del navegador
include_once("../../sesiones/php_control_usuarios.php"); //Controla los permisos de los usuarios
include_once("../../constructores/paginas_constructor.php"); //Construye la pagina, estan las herramientas para construir los objetos de la pagina

$css =  new PageConstruct($myTitulo, ""); //instancia para el objeto con las funciones del html

$obCon = new conexion($idUser); //instancia para Conexion a la base de datos
$TipoUser=$_SESSION['tipouser'];
$css->PageInit($myTitulo);
    /*
     * Inicio de la maqueta propia de cada programador
     */
     
    $css->Modal("ModalAccionesPOS", "POS TS5", "", 1);
        $css->div("DivFrmPOS", "", "", "", "", "", "");
        $css->Cdiv();
       
    $css->CModal("BntModalPOS", "onclick=AccionesPOS(event)", "button", "Guardar");
    
    $css->Modal("ModalAcciones", "TS5", "", 1);
        $css->div("DivModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();
       
    $css->CModal("BntModalAcciones", "onclick=GuardarSegunFormulario()", "button", "Guardar");
    
    $css->section("", "content-header", "", "");
        print("<h1>Administrador de Acuerdos de Pago</h1>");
         
    $css->Csection();
    //print("<br>");
    $css->section("", "content", "", "");
        $css->CrearDiv("", "row", "left", 1, 1);
         $css->CrearDiv("", "col-md-2", "left", 1, 1);
         $css->CrearBotonEvento("BtnInicio", "Inicio", 1, "onclick", "DibujeListadoSegunTipo()", "azul"); 
         if($TipoUser=="administrador"){
            print("<br>");
            $css->CrearBotonEvento("BtnNuevoAcuerdo", "Nuevo Acuerdo de Pago", 1, "onclick", "DibujeFormularioAcuerdoPago(`NA`,`DivDrawTables`)", "naranja");   
         }
         print("<br>");
         print("<br>");
         $css->CrearBotonEvento("BtnLimpiarFiltros", "Limpiar Filtros", 1, "onclick", "LimpiarFiltros();DibujeListadoSegunTipo();", "verde");   
            $css->CrearDiv("", "box box-solid", "left", 1, 1);
             $css->CrearDiv("", "box-header with-border", "left", 1, 1);
               print('<h3 class="box-title">Informe</h3>');
               
               $css->CrearDiv("", "box-tools", "left", 1, 1);    
                  print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                  </div>');
        
                   $css->div("DivFiltros", "box-body no-padding", "", "", "", "", "");
                                
                                //Creamos el Selector que contiene las bases de datos
                         $css->select("cmbTipoInforme", "form-control", "cmbTipoInforme", "", "", "onchange=DibujeListadoSegunTipo()"/*funcion js para listar las tablas de  una base de datos*/, "");
                            
                            $css->option("", "", "", "1", "", "");
                                    print("Historial de Acuerdos de Pago");
                            $css->Coption();

                            $css->option("", "", "", "2", "", "");
                                    print("Cuotas Acuerdos de Pago");
                            $css->Coption();
                                
                            $css->option("", "", "", "3", "", "");
                                    print("Historial de Abonos");
                            $css->Coption();
                            
                            $css->option("", "", "", "4", "", "");
                                    print("Movimientos contables");
                            $css->Coption();
                            
                            $css->option("", "", "", "5", "", "");
                                    print("Productos Comprados en acuerdos");
                            $css->Coption();
                            $css->option("", "", "", "6", "", "");
                                    print("Historial de productos devueltos");
                            $css->Coption();
                            
                      $css->Cselect();
            
                    $css->Cdiv();
                    
                    $css->CrearDiv("DivEstadosAcuerdos", "box-header with-border", "left", 1, 1);
                        print('<h3 class="box-title">Estados acuerdos</h3>');

                        $css->CrearDiv("", "box-tools", "left", 1, 1);    
                           print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                          </div>
                      ');
        
                   $css->div("DivFiltros", "box-body no-padding", "", "", "", "", "");
                                
                                //Creamos el Selector que contiene las bases de datos
                         $css->select("cmbEstadosAcuerdos", "form-control", "cmbEstadosAcuerdos", "", "", "onchange=DibujeListadoSegunTipo()"/*funcion js para listar las tablas de  una base de datos*/, "");
                            
                            $css->option("", "", "", "", "", "");
                                    print("Todos");
                            $css->Coption();
                            
                            $Consulta=$obCon->ConsultarTabla("acuerdo_pago_estados", "ORDER BY ID");
                            while($DatosEstados=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "", "", $DatosEstados["ID"], "", "");
                                    print($DatosEstados["NombreEstado"]);
                                $css->Coption();
                            }
                      $css->Cselect();
            
                    $css->Cdiv();
                    $css->Cdiv();
                    
                    $css->CrearDiv("DivEstadosProyeccion", "box-header with-border", "left", 1, 1);
                    print('<h3 class="box-title">Estados Proyeccion</h3>');

                    $css->CrearDiv("", "box-tools", "left", 1, 1);    
                       print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                  ');
        
                   $css->div("DivFiltros", "box-body no-padding", "", "", "", "", "");
                                
                                //Creamos el Selector que contiene las bases de datos
                         $css->select("cmbEstadosProyeccion", "form-control", "cmbEstadosProyeccion", "", "", "onchange=DibujeListadoSegunTipo()"/*funcion js para listar las tablas de  una base de datos*/, "");
                            
                            $css->option("", "", "", "", "", "");
                                    print("Todos");
                            $css->Coption();
                            
                            $Consulta=$obCon->ConsultarTabla("acuerdo_pago_proyeccion_estados", "ORDER BY ID");
                            while($DatosEstados=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "", "", $DatosEstados["ID"], "", "");
                                    print($DatosEstados["NombreEstado"]);
                                $css->Coption();
                            }
                      $css->Cselect();
            
                    $css->Cdiv();
                    $css->Cdiv();
                    
                    $css->CrearDiv("DivTiposCuota", "box-header with-border", "left", 1, 1);
                    print('<h3 class="box-title">Tipos de Cuota</h3>');

                    $css->CrearDiv("", "box-tools", "left", 1, 1);    
                       print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                  ');
        
                   $css->div("DivFiltros", "box-body no-padding", "", "", "", "", "");
                                
                                //Creamos el Selector que contiene las bases de datos
                         $css->select("cmbTiposCuota", "form-control", "cmbTiposCuota", "", "", "onchange=DibujeListadoSegunTipo()"/*funcion js para listar las tablas de  una base de datos*/, "");
                            
                            $css->option("", "", "", "", "", "");
                                    print("Todos");
                            $css->Coption();
                            
                            $Consulta=$obCon->ConsultarTabla("acuerdo_pago_tipo_cuota", "ORDER BY ID");
                            while($DatosEstados=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "", "", $DatosEstados["ID"], "", "");
                                    print($DatosEstados["NombreTipoCuota"]);
                                $css->Coption();
                            }
                      $css->Cselect();
            
                    $css->Cdiv();
                   $css->Cdiv();
        
            print('        
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>');
            
            $css->CrearDiv("", "col-md-10", "left", 1, 1);
             
                $css->CrearDiv("DivMensajes", "col-md-12", "left", 1, 1);

                $css->CerrarDiv();
                $css->CrearDiv("DivClientes", "col-md-4", "left", 1, 1);
                    $css->select("idCliente", "form-control", "idCliente", "", "", "", "onchange=DibujeListadoSegunTipo();");
                        $css->option("", "", "", "", "", "");
                            print("Selecciona un Cliente");
                        $css->Coption();
                    $css->Cselect();
                $css->CerrarDiv();
                
                $css->CrearDiv("DivClientes", "col-md-2", "left", 1, 1);
                    $css->select("cmbCicloPagos", "form-control", "cmbCicloPagos", "", "", "", "onchange=DibujeListadoSegunTipo();");
                        
                        $css->option("", "", "", "", "", "");
                            print("Todos los ciclos");
                        $css->Coption();
                        
                        $sql="SELECT * FROM acuerdo_pago_ciclos_pagos";
                        $Consulta=$obCon->Query($sql);
                        while($DatosCiclo=$obCon->FetchAssoc($Consulta)){
                            $css->option("", "", "", $DatosCiclo["ID"], "", "");
                                print($DatosCiclo["NombreCiclo"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->CerrarDiv();
                
                $css->CrearDiv("", "col-md-2", "right", 1, 1); 

                    $css->input("date", "FechaInicialRangos", "form-control", "FechaInicialRangos", "Fecha", "", "Fecha Inicial", "off", "", "onchange=DibujeListadoSegunTipo();","style='line-height: 15px;'");

                $css->CerrarDiv();
                $css->CrearDiv("", "col-md-2", "right", 1, 1); 
                    $css->input("date", "FechaFinalRangos", "form-control", "FechaFinalRangos", "Fecha", "", "Fecha Final", "off", "", "onchange=DibujeListadoSegunTipo();","style='line-height: 15px;'");

                $css->CerrarDiv();

                $css->CrearDiv("", "col-md-2", "right", 1, 1); 
                    $css->input("text", "Busqueda", "form-control", "Busqueda", "", "", "Buscar", "off", "", "onchange=DibujeListadoSegunTipo()");
                $css->CerrarDiv();


                $css->CrearDiv("", "col-md-12", "left", 1, 1);
                            
                    $css->CrearDiv("", "box box-primary", "left", 1, 1);
                        $css->CrearDiv("DivDrawTables", "box-header with-border", "left", 1, 1);

                        $css->CerrarDiv();
                    $css->CerrarDiv();    
                $css->CerrarDiv();
            $css->CerrarDiv();
       
        print('
                
              </section>');
     
        /*
         * Fin de la maqueta del programador
         */
        
$css->PageFin();
$css->AddJSExcel();
print('<script src="jsPages/adminAcuerdosPago.js"></script>');  //script propio de la pagina
print('<script src="jsPages/AcuerdoPago.js"></script>');  //script propio de la pagina
print('<script src="../../componentes/webcam/webcam.js"></script>');  //script para usar la web cam

$css->Cbody();
$css->Chtml();

?>