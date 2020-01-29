<?php
/**
 * Pagina para crear un administrador de bases de datos
 * 2020-01-26, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */

$myPage="admindb.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Administrador de Bases de Datos TSS";  //Titulo en la pestaña del navegador
include_once("../../sesiones/php_control_usuarios.php"); //Controla los permisos de los usuarios
include_once("../../constructores/paginas_constructor.php"); //Construye la pagina, estan las herramientas para construir los objetos de la pagina

$css =  new PageConstruct($myTitulo, ""); //instancia para el objeto con las funciones del html

$obCon = new conexion($idUser); //instancia para Conexion a la base de datos

$css->PageInit($myTitulo);
    /*
     * Inicio de la maqueta propia de cada programador
     */
    $css->section("", "content-header", "", "");
        print("<h1>Administrador de Bases de Datos TS5</h1>");
         
    $css->Csection();
    //print("<br>");
    $css->section("", "content", "", "");
        $css->CrearDiv("", "row", "left", 1, 1);
         $css->CrearDiv("", "col-md-3", "left", 1, 1);
          $css->CrearBotonEvento("BtnNuevoRegistro", "Nuevo Registro", 1, "onclick", "FormularioNuevoRegistro()", "azul");
           $css->CrearDiv("", "box box-solid", "left", 1, 1);
             $css->CrearDiv("", "box-header with-border", "left", 1, 1);
               print('<h3 class="box-title">Bases de Datos</h3>');
               
               $css->CrearDiv("", "box-tools", "left", 1, 1);    
                  print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                  </div>');
        
                   $css->div("DivBasesDatos", "box-body no-padding", "", "", "", "", "");
                                $sql="show databases";// sentencia sql para mostrar las base de datos
                                $Consulta=$obCon->Query($sql); //se corre la sentencia sql por medio del objecto conexion           
            
                                //Creamos el Selector que contiene las bases de datos
                         $css->select("cmbDataBase", "form-control", "cmbDataBase", "", "", "onchange=ListTables()"/*funcion js para listar las tablas de  una base de datos*/, "");
                                $css->option("", "", "", "", "", "");
                                        print("Seleccione una Base de Datos");
                                $css->Coption();
                
                                  while($DatosConsulta=$obCon->FetchAssoc($Consulta)){//se corre el bucle para que se muestre uno a uno los registros de la consulta
                                   $NombreBaseDatos=$DatosConsulta["Database"];//se almacena en la variable los nombres de cada base de datos
                    
                                $css->option("", "", "", $NombreBaseDatos, "", "");// meto dentro de cada opcion el nombre de la base de datos dada por la consulta 
                                print($NombreBaseDatos);
                                $css->Coption();
                    
                    
                                }
                
                      $css->Cselect();
            
                    $css->Cdiv();
        
        print('                  
                <!-- /.box-body -->
              </div>
              <!-- /. box -->
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Tablas</h3>

                  <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>');
        
        $css->div("DivTablasBaseDatos", "box-body no-padding", "", "", "", "", "");
            
        $css->Cdiv();
                

            print('        
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>');
            $css->CrearDiv("", "col-md-9", "left", 1, 1);
            $css->CrearDiv("", "box-tools pull-right", "left", 1, 1);                
                    print('<div class="input-group">');               
                        $css->input("text", "TxtBusquedas", "form-control", "TxtBusquedas", "", "", "Buscar", "", "", "onchange=BuscarRegistros()");

                    print('<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
                              </div>');
                $css->CerrarDiv(); 
            $css->CerrarDiv();   
            
            $css->CrearDiv("", "col-md-9", "left", 1, 1);
                $css->CrearDiv("DivPager", "", "left", 1, 1);
                    
                $css->CerrarDiv();  
            
                $css->CrearDiv("", "box box-primary", "left", 1, 1);
                    $css->CrearDiv("DivDrawTables", "box-header with-border", "left", 1, 1);
                        print("Informacion de las tablas");
                    $css->CerrarDiv();
                $css->CerrarDiv();    
            $css->CerrarDiv();
       
        print('</div>
                
              </section>');
     
        /*
         * Fin de la maqueta del programador
         */
        
$css->PageFin();

print('<script src="jsPages/admindb.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>