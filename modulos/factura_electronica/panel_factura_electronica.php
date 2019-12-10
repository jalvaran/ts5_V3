<?php
/**
 * Pagina para la realizacion de los procesos de las facturas electronicas
 * 2019-12-09, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */
$myPage="panel_factura_electronica.php";
$myTitulo="Facturacion Electronica TSS";
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
        print("<h1>Módulo de Facturación Electrónica TS5");
            
        print("</h1>");
    $css->Csection();
    //print("<br>");
    $css->section("", "content", "", "");
    $css->CrearDiv("", "row", "left", 1, 1);
    $css->CrearDiv("", "col-md-2", "left", 1, 1);
    $css->CrearBotonEvento("BtnTablero", "Tablero", 1, "onclick", "VerTablero()", "azul");
    $css->CrearDiv("", "box box-solid", "left", 1, 1);
    $css->CrearDiv("", "box-header with-border", "left", 1, 1);
    print('<h3 class="box-title">Documentos</h3>');
    $css->CrearDiv("", "box-tools", "left", 1, 1);    
    print('  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding" style="">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="#" onclick="VerHistorialDeFacturasElectronicas()"><i class="fa fa-send-o"></i> Enviados
                  </a></li>
                <li><a href="#" onclick="VerHistorialDeFacturasElectronicas()"><i class="fa fa-inbox"></i> Recibidos
                  </a></li>  
                
               
              </ul>
            </div>
            
            <div id="NotificacionProcesos" class="box-body no-padding" style="">
                
            </div>
            
           </div></div>
            ');
            
           
        $css->CrearDiv("", "col-md-10", "left", 1, 1);
        $css->CrearDiv("", "box-tools pull-right", "left", 1, 1);                
                print('<div class="input-group">');               
                    $css->input("text", "TxtBusquedas", "form-control", "TxtBusquedas", "", "", "Buscar", "", "", "onchange=VerHistorialDeFacturasElectronicas()");

                print('<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
                          </div>');
            $css->CerrarDiv(); 
        $css->CerrarDiv();     
        $css->CrearDiv("", "col-md-10", "left", 1, 1);
             
            $css->CrearDiv("", "box box-primary", "left", 1, 1);
                $css->CrearDiv("DivDrawFE", "box-header with-border", "left", 1, 1);  
                $css->CerrarDiv();
            $css->CerrarDiv(); 
            $css->CrearDiv("", "box box-primary", "left", 1, 1);
                $css->CrearDiv("DivDrawListFE", "box-header with-border", "left", 1, 1);  
                $css->CerrarDiv();
            $css->CerrarDiv(); 
        $css->CerrarDiv();
       
        
        
        print(' </div>
                <!-- /.row -->
              </section>');
$css->PageFin();
$css->AddJSTextAreaEnriquecida();
print('<script src="jsPages/panel_factura_electronica.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>