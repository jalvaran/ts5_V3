<?php
/**
 * POS para restaurantes bares
 * 2021-07-07, Julian Alvaran Techno Soluciones SAS
 */
$myPage="pos_cel.php";
$myTitulo="POS TS5";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    
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
        
    $css->input("hidden", "idCajero", "", "idCajero", "", $idUser, "", "", "", "");
    $css->CrearDiv("", "", "", 1, 1);
        print('<a id="vinculoItems" href="#vinculoItems" title="Facturas"> </a>');
        
    $css->CerrarDiv();
    print('<br>');
    print('<div class="col-md-12">');
        print('<div class="nav-tabs-custom">');
            print('<ul class="nav nav-tabs">');
                print('<li class="active"><a href="#tab_list_1" data-toggle="tab" aria-expanded="true">Venta</a></li>');
                
                
            print('</ul>');
            
            print('<div class="tab-content">');
                print('<div id="tab_list_1" class="tab-pane active">');
                    print('<div class="row">');
                        print('<div id="list_1" class="col-md-12 ts_list_forms">');
                            $css->input("hidden", "idPreventa", "", "idPreventa", "", $idUser, "", "", "", "");
                            print('<a class="btn btn-app bg-blue " onclick="frm_agregar_producto();"><i class="fa fa-plus"></i> Agregar </a>');
                            print('<a class="btn btn-app bg-navy " onclick=frm_crear_tercero();><i class="fa fa-users"></i> Terceros </a>');
                            print('<a class="btn btn-app bg-maroon " onclick="ModalCerrarTurno();"><i class="fa fa-cog"></i> Cerrar Turno </a>');
                            
                            
                            
                        print('</div>');
                        
                        
                            
                    print('</div>');
                    print('<div class="row">');
                        
                        print('<div id="div_preventa" class="col-md-7 ts_list_forms">');

                        print('</div>');
                        print('<div id="div_totales" class="col-md-5 ts_list_forms">');

                        print('</div>');
                        
                    print('</div>');
                print('</div>');
                
                print('<div id="tab_list_5" class="tab-pane">');
                    print('<div class="row">');
                        print('<div id="div_opciones" class="col-md-12 ts_list_forms">');
                            
                        print('</div>');
                    print('</div>');   
                print('</div>');
                
                
            print('</div>');  //Fin content
        print('</div>');  //Fin tabs    
        
    print('</div>');  //Fin column    
            
        
$css->PageFin();
print('<script src="../../componentes/shortcuts.js"></script>');  //script propio de la pagina
print('<script src="jsPages/pos_cel.js"></script>');  //script propio de la pagina
$css->Cbody();
$css->Chtml();

?>