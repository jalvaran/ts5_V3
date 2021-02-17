<?php
/**
 * Pagina para registrar la prefacturacion de basante
 * 2020-03-30, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */

$myPage="proyectos.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Proyectos";  //Titulo en la pestaña del navegador
include_once("../../sesiones/php_control_usuarios.php"); //Controla los permisos de los usuarios
include_once("../../constructores/paginas_constructor.php"); //Construye la pagina, estan las herramientas para construir los objetos de la pagina

$css =  new PageConstruct($myTitulo, ""); //instancia para el objeto con las funciones del html

$obCon = new conexion($idUser); //instancia para Conexion a la base de datos

$css->PageInit($myTitulo);
    /*
     * Inicio de la maqueta propia de cada programador
     */
     $css->Modal("ModalAcciones", "TSS", "", 1);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    
    
    $css->section("", "content-header", "", "");
        //print("<h1>Inventarios</h1>");
        print('<h1>Proyectos <button class="btn btn-success fa fa-bars" onclick=MostrarOcultarMenuListados()></button></h1>');
        
         
    $css->Csection();
    //print("<br>");
    $css->section("", "content", "", "");
    $css->CrearDiv("", "row", "left", 1, 1);
        $css->CrearDiv("DivMenuLateral", "col-md-2", "left", 1, 1);

        $css->CrearDiv("", "box box-solid", "left", 1, 1);
    $css->CrearDiv("", "box-header with-border", "left", 1, 1);
    print('<h3 class="box-title">Carpetas</h3>');
    $css->CrearDiv("", "box-tools", "left", 1, 1);    
    print('  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding" style="">
              <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="#" onclick="idListado=1;MostrarListadoSegunID();">
                        <i class="fa fa-list-ol"></i>Proyectos</a>
                </li>
                <!--
                <li>
                    <a href="#" onclick="idListado=2;MostrarListadoSegunID();">
                        <i class="fa fa-list-alt"></i>Tareas</a>
                </li>
                
                <li>
                    <a href="#" onclick="idListado=3;MostrarListadoSegunID();">
                        <i class="fa fa-indent"></i>Actividades</a>
                </li>
                -->               
                                               
              </ul>
              
         
            </div>
            <!-- /.box-body -->
          </div>
          ');
        
     $css->CrearDiv("", "box-header with-border", "left", 1, 1);   
        print('<h3 class="box-title">Filtros</h3>');
    $css->CrearDiv("", "box-tools", "left", 1, 1);    
    print('  
              </div>
            </div>
            <div class="box-body no-padding" style="">
                            
              <ul class="nav nav-pills nav-stacked">');
        
              $css->select("cmb_filtro_proyectos", "form-control", "cmb_filtro_proyectos", "Proyectos:", "", "", "onchange=MostrarListadoSegunID();");
                    $sql="SELECT * FROM proyectos_estados";
                    $Consulta=$obCon->Query($sql);
                    $css->option("", "", "", "", "", "");
                        print("Todos los proyectos");
                    $css->Coption();
                    while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                        $css->option("", "", "", $datos_consulta["ID"], "", "");
                            print($datos_consulta["nombre_estado"]);
                        $css->Coption();
                    }


                $css->Cselect();
                print("<br>");
                /*
                $css->select("cmb_filtro_tareas", "form-control", "cmb_filtro_tareas", "Tareas:", "", "", "onchange=MostrarListadoSegunID();");
                    $sql="SELECT * FROM proyectos_tareas_estados";
                    $Consulta=$obCon->Query($sql);
                    $css->option("", "", "", "", "", "");
                        print("Todas las tareas");
                    $css->Coption();
                    while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                        $css->option("", "", "", $datos_consulta["ID"], "", "");
                            print($datos_consulta["estado_tarea"]);
                        $css->Coption();
                    }


                $css->Cselect();
                    
                 * 
                 */
        print('</ul>
            </div>
            <!-- /.box-body -->
          
          <!-- /. box -->
          ');
                    
                               
                
        $css->Cdiv();
        
            
            $css->CrearDiv("DivContenidoFiltros", "col-md-10", "left", 1, 1);
                      
            
            
            $css->CrearDiv("DivClientes", "col-md-4", "left", 1, 1);
                    $css->select("empresa_id", "form-control", "empresa_id", "", "", "", "onchange=MostrarListadoSegunID();");
                        $sql="SELECT * FROM empresapro";
                        $Consulta=$obCon->Query($sql);
                        
                        while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                            $css->option("", "", "", $datos_consulta["idEmpresaPro"], "", "");
                                print($datos_consulta["RazonSocial"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->CerrarDiv();
                
                
                
                $css->CrearDiv("", "col-md-2", "right", 1, 1); 

                    $css->input("date", "FechaInicialRangos", "form-control", "FechaInicialRangos", "Fecha", "", "Fecha Inicial", "off", "", "onchange=MostrarListadoSegunID();","style='line-height: 15px;'");

                $css->CerrarDiv();
                $css->CrearDiv("", "col-md-2", "right", 1, 1); 
                    $css->input("date", "FechaFinalRangos", "form-control", "FechaFinalRangos", "Fecha", "", "Fecha Final", "off", "", "onchange=MostrarListadoSegunID();","style='line-height: 15px;'");

                $css->CerrarDiv();
                $css->CrearDiv("", "col-md-3", "right", 1, 1); 
                    $css->input("text", "busqueda_general", "form-control", "busqueda_general", "Buscar", "", "Buscar", "off", "", "onchange=MostrarListadoSegunID();","");

                $css->CerrarDiv();
                
                $css->CrearDiv("", "col-md-1", "right", 1, 1); 
                    
                    print("<button id='btn_actualizar_listados' class='btn btn-success' onclick='MostrarListadoSegunID();'><li class='fa fa-search'></li></button>");
                $css->CerrarDiv();   
            
            $css->CrearDiv("DivContenidoListado", "col-md-12", "left", 1, 1);
                            
                $css->CrearDiv("DivGeneralDrawBox", "box box-primary", "left", 1, 1);
                    $css->CrearDiv("DivGeneralDraw", "box-header with-border", "left", 1, 1);
                        
                    $css->CerrarDiv();
                $css->CerrarDiv();    
            $css->CerrarDiv();
       
        print('</div>
                
              </section>');
     
        /*
         * Fin de la maqueta del programador
         */
        
$css->PageFin();
$css->agregar_full_calendar();
print('<script src="jsPages/proyectos.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>