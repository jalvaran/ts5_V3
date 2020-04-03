<?php
/**
 * Pagina para administrar la plataforma domi
 * 2020-04-03, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */
$myPage="ts_domi.php";
$myTitulo="Administrador DOMI";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");

$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html

$obCon = new conexion($idUser); //Conexion a la base de datos
$NombreUser=$_SESSION['nombre'];

$sql="SELECT TipoUser,Role FROM usuarios WHERE idUsuarios='$idUser'";
$DatosUsuario=$obCon->Query($sql);
$DatosUsuario=$obCon->FetchAssoc($DatosUsuario);
$TipoUser=$DatosUsuario["TipoUser"];

$css->PageInit($myTitulo);
    //$css->div("", "col-md-12", "", "", "", "", "");
    $css->section("", "content-header", "", "");
        print("<h1>Plataforma DOMI");
            //print('<small id="info1">13 nuevos mensajes sin leer</small>');
        print("</h1>");
    $css->Csection();
    //print("<br>");
    $css->section("", "content", "", "");
        $css->CrearDiv("", "row", "left", 1, 1);
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
            //$css->CrearBotonEvento("BtnNuevoTicket", "Abrir Nuevo Ticket", 1, "onclick", "FormularioNuevoTicket()", "azul");
                $css->CrearDiv("", "box box-solid", "left", 1, 1);
                    $css->CrearDiv("", "box-header with-border", "left", 1, 1);
                        print('<h3 class="box-title">Carpetas</h3>');
                        $css->CrearDiv("", "box-tools", "left", 1, 1);
                            print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>');
                        $css->CerrarDiv();
                    $css->CerrarDiv();
                    $css->CrearDiv("", "box-body no-padding", "left", 1, 1);
                        print('<ul class="nav nav-pills nav-stacked">');
                            print('<li><a href="#" onclick="ListarLocales()"><i class="fa fa-inbox"></i>Locales</a></li>');
                            print('<li><a href="#" onclick="ListarClasificacion()"><i class="fa fa-inbox"></i>Clasificacion</a></li>');
                            print('<li><a href="#" onclick="listarProductos()"><i class="fa fa-inbox"></i>Productos</a></li>');
                            print('<li><a href="#" onclick="ListarPedidos()"><i class="fa fa-inbox"></i>Pedidos</a></li>');
                        print('</ul>');
                    $css->CerrarDiv(); 
                    
                    
                $css->CerrarDiv();  
                $css->CrearDiv("", "box box-solid", "left", 1, 1);
                    $css->CrearDiv("", "box-header with-border", "left", 1, 1);
                        print('<h3 class="box-title">Filtros</h3>');
                        $css->CrearDiv("", "box-tools", "left", 1, 1);
                            print('<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>');
                        $css->CerrarDiv(); 
                    $css->CerrarDiv();
                    $css->CrearDiv("", "box-body no-padding", "left", 1, 1);
                        print('<ul class="nav nav-pills nav-stacked">');            
                            print('<li>');            
                                $css->select("CmbEstadoTicketsListado", "form-control", "CmbEstadoTicketsListado", "", "", "onchange=VerListadoTickets()", "");
                                    $css->option("", "", "", 1, "", "");
                                        print("Abiertos");
                                    $css->Coption();

                                    $css->option("", "", "", 0, "", "");
                                        print("Cerrados");
                                    $css->Coption();

                                    $css->option("", "", "", 3, "", "");
                                        print("Todos");
                                    $css->Coption();
                                $css->Cselect();
                            print('</li>'); 
                        print('</ul>'); 
                    $css->CerrarDiv(); 
                $css->CerrarDiv();
            $css->CerrarDiv();    

        $css->CrearDiv("", "col-md-10", "left", 1, 1);
            $css->CrearDiv("", "box-tools pull-right", "left", 1, 1);                
                    print('<div class="input-group">');               
                        $css->input("text", "TxtBusquedas", "form-control", "TxtBusquedas", "", "", "Buscar", "", "", "onchange=VerListadoTickets()");

                    print('<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
                              </div>');
                $css->CerrarDiv(); 
            $css->CerrarDiv();     
            $css->CrearDiv("", "col-md-10", "left", 1, 1);

                $css->CrearDiv("", "box box-primary", "left", 1, 1);
                    $css->CrearDiv("DivDraw", "box-header with-border", "left", 1, 1);  
                    $css->CerrarDiv();
                $css->CerrarDiv();    
            $css->CerrarDiv();
        $css->CerrarDiv();
        
    print('</section>');
$css->PageFin();

print('<script src="jsPages/ts_domi.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>