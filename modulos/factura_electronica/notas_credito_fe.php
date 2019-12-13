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
$myPage="notas_credito_fe.php";
$myTitulo="Notas Credito";
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
    $css->Modal("ModalAcciones", "TS5", "", 1);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    //$css->div("", "col-md-12", "", "", "", "", "");
    $css->section("", "content-header", "", "");
        print("<h1>Módulo Creacion de Notas Credito</h1>"); 
    $css->Csection();
    //print("<br>");
    $css->section("", "content", "", "");
    $css->CrearDiv("", "row", "left", 1, 1);
    $css->CrearDiv("", "col-md-2", "left", 1, 1);
    $css->CrearBotonEvento("BtnCrearNota", "Crear una Nota Credito", 1, "onclick", "FormularioNuevaNotaCredito()", "azul");
    
    $css->CrearDiv("", "box box-solid", "left", 1, 1);
    $css->CrearDiv("", "box-header with-border", "left", 1, 1);
    //print('<h3 class="box-title">Documentos</h3>');
    $css->CrearDiv("", "box-tools", "left", 1, 1);    
    print('  
              </div>
            </div>
            
            
            <div id="NotificacionProcesos" class="box-body no-padding" style="">
                
            </div>
            
           </div></div>
            ');
            
           
        $css->CrearDiv("", "col-md-10", "left", 1, 1);
        $css->CrearDiv("", "box-tools pull-right", "left", 1, 1);                
                print('<div class="input-group">');               
                    $css->input("text", "TxtBusquedas", "form-control", "TxtBusquedas", "", "", "Buscar", "", "", "onchange=VerListado();");

                print('<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
                          </div>');
            $css->CerrarDiv(); 
        $css->CerrarDiv();     
        $css->CrearDiv("", "col-md-12", "left", 1, 1);
             
            $css->CrearDiv("", "box box-success", "left", 1, 1);
                $css->CrearDiv("DivDrawFE", "box-header with-border", "left", 1, 1);  
                $css->CerrarDiv();
            $css->CerrarDiv(); 
            $css->CrearDiv("", "box box-success", "left", 1, 1);
                $css->CrearDiv("DivProcessFE", "", "left", 1, 1);  
                $css->CerrarDiv();
                $css->CrearDiv("DivDrawListFE", "box-header with-border", "left", 1, 1);  
                $css->CerrarDiv();
            $css->CerrarDiv(); 
        $css->CerrarDiv();
       
        
        
        print(' </div>
                <!-- /.row -->
              </section>');
$css->PageFin();
$css->AddJSTextAreaEnriquecida();
print('<script src="jsPages/notas_credito_fe.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>