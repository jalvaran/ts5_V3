<?php
/**
 * Pagina para ver los diferentes informes de los acuerdos de pago
 * 2020-02-16, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */

$myPage="informesAcuerdosPago.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Informes de Acuerdos de Pago";  //Titulo en la pestaña del navegador
include_once("../../sesiones/php_control_usuarios.php"); //Controla los permisos de los usuarios
include_once("../../constructores/paginas_constructor.php"); //Construye la pagina, estan las herramientas para construir los objetos de la pagina

$css =  new PageConstruct($myTitulo, ""); //instancia para el objeto con las funciones del html

$obCon = new conexion($idUser); //instancia para Conexion a la base de datos

$css->PageInit($myTitulo);
    /*
     * Inicio de la maqueta propia de cada programador
     */
    $css->section("", "content-header", "", "");
        print("<h1>Informes de Acuerdos de Pago</h1>");
         
    $css->Csection();
    //print("<br>");
    $css->section("", "content", "", "");
        $css->CrearDiv("", "row", "left", 1, 1);
         $css->CrearDiv("", "col-md-2", "left", 1, 1);
            
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
                         $css->select("cmbTipoInforme", "form-control", "cmbTipoInforme", "", "", "onchange=DibujeFormularioSegunTipoInforme()"/*funcion js para listar las tablas de  una base de datos*/, "");
                            
                            $css->option("", "", "", "1", "", "");
                                    print("Cuentas X Cobrar");
                            $css->Coption();

                            $css->option("", "", "", "2", "", "");
                                    print("Historial de facturas a Credito");
                            $css->Coption();
                            
                            $css->option("", "", "", "3", "", "");
                                    print("Historial de abonos de un cliente");
                            $css->Coption();
                            
                            $css->option("", "", "", "4", "", "");
                                    print("Gestion de Cobranza");
                            $css->Coption();
                      $css->Cselect();
            
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
                    $css->CrearBotonEvento("btnGenerarListado", "Generar", 1, "onclick", "DibujeListadoSegunTipo();", "verde");
                $css->CerrarDiv();


                $css->CrearDiv("", "col-md-12", "left", 1, 1);
                            
                    $css->CrearDiv("", "box box-primary", "left", 1, 1);
                        $css->CrearDiv("DivDrawTables", "box-header with-border", "left", 1, 1);

                        $css->CerrarDiv();
                    $css->CerrarDiv();    
                $css->CerrarDiv();
            $css->CerrarDiv();
       
        print('</div>
                
              </section>');
     
        /*
         * Fin de la maqueta del programador
         */
        
$css->PageFin();
$css->AddJSExcel();
print('<script src="jsPages/informesAcuerdosPago.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>