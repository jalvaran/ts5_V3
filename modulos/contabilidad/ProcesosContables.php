<?php
/**
 * Pagina para realizar un cierre contable
 * 2020-03-18, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */

$myPage="ProcesosContables.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Cierre Contable";  //Titulo en la pestaña del navegador
include_once("../../sesiones/php_control_usuarios.php"); //Controla los permisos de los usuarios
include_once("../../constructores/paginas_constructor.php"); //Construye la pagina, estan las herramientas para construir los objetos de la pagina

$css =  new PageConstruct($myTitulo, ""); //instancia para el objeto con las funciones del html

$obCon = new conexion($idUser); //instancia para Conexion a la base de datos

$css->PageInit($myTitulo);
    /*
     * Inicio de la maqueta propia de cada programador
     */
    $css->section("", "content-header", "", "");
        print("<h1>Procesos contables</h1>");
         
    $css->Csection();
    //print("<br>");
    $css->section("", "content", "", "");
        $css->CrearDiv("", "row", "left", 1, 1);
         $css->CrearDiv("", "col-md-2", "left", 1, 1);
         
        
            $css->CrearDiv("", "box box-solid", "left", 1, 1);
             $css->CrearDiv("", "box-header with-border", "left", 1, 1);
               print('<h3 class="box-title">Proceso</h3>');
               
               $css->CrearDiv("", "box-tools", "left", 1, 1);    
                  print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                  </div>');
        
                   $css->div("DivFiltros", "box-body no-padding", "", "", "", "", "");
                                
                                //Creamos el Selector que contiene las bases de datos
                        $css->select("cmbTipoProceso", "form-control", "cmbTipoProceso", "", "", "onchange=DibujeProcesoSegunTipo()"/*funcion js para listar las tablas de  una base de datos*/, "");

                           $css->option("", "", "", "1", "", "");
                                   print("Auditoría de documentos");
                           $css->Coption();

                           $css->option("", "", "", "2", "", "");
                                   print("Cierre contable");
                           $css->Coption();                               
                            
                        $css->Cselect();
            
                    $css->Cdiv();
                    
                    $css->CrearDiv("DivProcesosAuditoria", "box-header with-border", "left", 1, 1);
                        print('<h3 class="box-title">Tipo de Auditoria</h3>');

                        $css->CrearDiv("", "box-tools", "left", 1, 1);    
                           print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                          </div>
                      ');
        
                   $css->div("DivFiltros", "box-body no-padding", "", "", "", "", "");
                                
                                //Creamos el Selector que contiene las bases de datos
                        $css->select("cmbTipoAuditoria", "form-control", "cmbTipoAuditoria", "", "", "onchange=DibujeProcesoSegunTipo()"/*funcion js para listar las tablas de  una base de datos*/, "");

                           $css->option("", "", "", "1", "", "");
                                print("Registros Sin Cuenta Contable");
                           $css->Coption();

                           $css->option("", "", "", "2", "", "");
                                print("Registros Sin Tercero");
                           $css->Coption();   
                           
                           $css->option("", "", "", "1", "", "");
                                print("Registros a Cuentas Padre");
                           $css->Coption();
                           
                           $css->option("", "", "", "3", "", "");
                                print("Documentos Sin Balance");
                           $css->Coption();    
                            
                        $css->Cselect();
            
            
                    $css->Cdiv();
                    $css->Cdiv();
                    
                    $css->CrearDiv("DivProcesoCierre", "box-header with-border", "left", 1, 1);
                    print('<h3 class="box-title">Cierre de Cuentas</h3>');

                    $css->CrearDiv("", "box-tools", "left", 1, 1);    
                       print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                  ');
        
                   $css->div("DivFiltros", "box-body no-padding", "", "", "", "", "");
                                
                                //Creamos el Selector que contiene las bases de datos
                         $css->select("cmbTipoCierre", "form-control", "cmbTipoCierre", "", "", "onchange=DibujeProcesoSegunTipo()"/*funcion js para listar las tablas de  una base de datos*/, "");

                           $css->option("", "", "", "1", "", "");
                                print("Cierre de Cuentas de Resultado");
                           $css->Coption();

                           $css->option("", "", "", "2", "", "");
                                print("Cierre de Cuentas de Terceros");
                           $css->Coption();   
                           
                        $css->Cselect();
            
                    $css->Cdiv();
                    $css->Cdiv();
                    
                    
                   //$css->Cdiv();
        
            print('        
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>');
            
            $css->CrearDiv("", "col-md-10", "left", 1, 1);
             
                $css->CrearDiv("DivMensajes", "col-md-12", "left", 1, 1);

                $css->CerrarDiv();
                $css->CrearDiv("DivEmpresa", "col-md-4", "left", 1, 1);
                    $css->select("idEmpresa", "form-control", "idEmpresa", "", "", "", "");
                        $css->option("", "", "", "", "", "");
                            print("Todas las empresas");
                        $css->Coption();
                        $sql="SELECT * FROM empresapro";
                        $Consulta=$obCon->Query($sql);
                        while($DatosEmpresa=$obCon->FetchAssoc($Consulta)){
                            $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                                print($DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->CerrarDiv();
                                
                $css->CrearDiv("", "col-md-2", "right", 1, 1); 
                                        
                    $css->select("CmbAnio", "form-control", "CmbAnio", "", "", "", "onchange=DibujeOpcionesReporte()"); 
                            
                        $css->option("", "", "", "", "", "");
                            print("Seleccione un año");
                        $css->Coption();
                    
                        $sql="SELECT DISTINCT(SUBSTRING(Fecha,1,4)) as Anio FROM librodiario GROUP BY SUBSTRING(Fecha,1,4)";
                        $Consulta=$obCon->Query($sql);
                        while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                            $sel=0;
                            $Anio=$DatosLibro["Anio"];
                            
                            $css->option("", "", "Rango", "$Anio", "", "",$sel);
                                print($Anio);
                            $css->Coption();
                        }
                        
                                       
                    $css->Cselect();
                $css->CerrarDiv();
                
                $css->CrearDiv("", "col-md-4", "right", 1, 1); 
                    $css->select("idDocumento", "form-control", "idDocumento", "", "", "onchange=DibujeDocumento()", "");
                        $css->option("", "", "","", "", "");
                            print("Seleccione un Documento");
                        $css->Coption();
                        $consulta = $obCon->ConsultarTabla("vista_documentos_contables","WHERE Estado='ABIERTO' AND idDocumento=9");
                        while($DatosDocumento=$obCon->FetchArray($consulta)){


                            $css->option("", "", "", $DatosDocumento['ID'], "", "");
                                print($DatosDocumento['Fecha']." ".$DatosDocumento['Prefijo']." ".$DatosDocumento["Nombre"]." ".$DatosDocumento["Consecutivo"]." ".$DatosDocumento["Descripcion"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->CerrarDiv();
                
                $css->CrearDiv("", "col-md-2", "right", 1, 1); 
                    $css->CrearBotonEvento("BtnGenerar", "Ejecutar", 1, "onclick", "EjecutarProcesoSegunTipo()", "naranja");
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
print('<script src="jsPages/ProcesosContables.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>