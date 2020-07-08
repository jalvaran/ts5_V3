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

$myPage="adminInventarios.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Administrador de Inventarios";  //Titulo en la pestaña del navegador
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
        print('<h1>Inventarios <button class="btn btn-success fa fa-bars" onclick=MostrarOcultarMenuListados()></button></h1>');
        
         
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
                    <a href="#" onclick="idListado=1;Filtro=``;MostrarListadoSegunID();">
                        <i class="fa fa-list-ol"></i>Productos</a>
                </li>
                <!--
                <li>
                    <a href="#" onclick="idListado=2;Filtro=``;MostrarListadoSegunID();">
                        <i class="fa fa-indent"></i>Servicios</a>
                </li>
                <li>
                    <a href="#" onclick="idListado=3;Filtro=``;MostrarListadoSegunID();">
                        <i class="fa fa-exchange"></i>Traslados</a>
                </li>
                <li>
                    <a href="#" onclick="idListado=4;Filtro=``;MostrarListadoSegunID();">
                        <i class="fa fa-th-list"></i>Insumos</a>
                </li>
                <li>
                    <a href="#" onclick="idListado=5;Filtro=``;MostrarListadoSegunID();">
                        <i class="fa fa-list"></i>Kardex</a>
                </li>
                -->
                <li>
                    <a href="#" onclick="idListado=6;Filtro=``;MostrarListadoSegunID();">
                        <i class="fa fa-object-ungroup"></i>Separados</a>
                </li>
               
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          ');
                    
                               
                
            $css->Cdiv();
        
            
            $css->CrearDiv("DivContenidoFiltros", "col-md-10", "left", 1, 1);
                      
            $css->CrearDiv("DivMensajes", "col-md-4", "left", 1, 1);
                print("<strong>Rango de fechas por vencimiento</strong>");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "right", 1, 1); 

                    $css->input("date", "FechaInicialRangos", "form-control", "FechaInicialRangos", "Fecha", "", "Fecha Inicial", "off", "", "onchange=MostrarListadoSegunID();","style='line-height: 15px;'");

                $css->CerrarDiv();
                $css->CrearDiv("", "col-md-2", "right", 1, 1); 
                    $css->input("date", "FechaFinalRangos", "form-control", "FechaFinalRangos", "Fecha", "", "Fecha Final", "off", "", "onchange=MostrarListadoSegunID();","style='line-height: 15px;'");

                $css->CerrarDiv();
            
            $css->CrearDiv("DivContenidoFiltros", "box-tools pull-right", "left", 1, 1);      
                        
                    print('<div class="input-group">'); 
                        
                        $css->input("text", "TxtBusquedas", "form-control", "TxtBusquedas", "", "", "Busqueda General", "", "", "onchange=MostrarListadoSegunID()");

                    print('<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
                              </div>');
                $css->CerrarDiv(); 
            $css->CerrarDiv();   
            
            $css->CrearDiv("DivContenidoListado", "col-md-10", "left", 1, 1);
                            
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

print('<script src="jsPages/adminInventarios.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>