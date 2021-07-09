<?php
/**
 * POS para restaurantes bares
 * 2021-07-07, Julian Alvaran Techno Soluciones SAS
 */
$myPage="restobarpos.php";
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
    $css->CrearDiv("", "", "", 0, 1);
        print('<a id="vinculoInicio" href="#AnclaInicio" title="Facturas">INICIO </a>');
        print('<a id="vinculoItems" href="#AnclaItems" title="Facturas">ITEMS </a>');
        
    $css->CerrarDiv();
    
    $css->input("hidden", "idCajero", "", "idCajero", "", $idUser, "", "", "", "");
    print('<br>');
    print('<div class="col-md-12">');
        print('<div class="nav-tabs-custom">');
            print('<ul class="nav nav-tabs">');
                print('<li class="active" onclick="TipoPedido=1;CambiarListaPedidos();"><a href="#tab_list_1" data-toggle="tab" aria-expanded="true">Mesas</a></li>');
                print('<li class="" onclick="TipoPedido=2;CambiarListaPedidos();"></span><a href="#tab_list_2" data-toggle="tab" aria-expanded="false">Domicilios</a></li>');
                print('<li class="" onclick="TipoPedido=3;CambiarListaPedidos();"><a href="#tab_list_3" data-toggle="tab" aria-expanded="false">Llevar</a></li>');
                print('<li class="" onclick="lista_pendientes_preparacion()"><a href="#tab_list_4" data-toggle="tab" aria-expanded="false">Preparación</a></li>');
                print('<li class=""><a href="#tab_list_5" data-toggle="tab" aria-expanded="false">Servicios</a></li>');
                print('<li class=""><a href="#tab_list_6" data-toggle="tab" aria-expanded="false">Resumen</a></li>');
                print('<li class=""><a href="#tab_list_7" data-toggle="tab" aria-expanded="false">Opciones</a></li>');
            print('</ul>');
            
            print('<div class="tab-content">');
                print('<div id="tab_list_1" class="tab-pane active">');
                    print('<div class="row">');
                        print('<div id="list_1" class="col-md-12 ts_list_forms">');
                            
                        print('</div>');
                    print('</div>');
                print('</div>');
                print('<div id="tab_list_2" class="tab-pane">');
                    print('<div class="row">');
                        print('<div id="list_2" class="col-md-12 ts_list_forms">');
                            
                        print('</div>');
                    print('</div>');
                print('</div>');
                print('<div id="tab_list_3" class="tab-pane">');
                    print('<div class="row">');
                        print('<div id="list_3" class="col-md-12 ts_list_forms">');
                            
                        print('</div>');
                    print('</div>');
                print('</div>');
                print('<div id="tab_list_4" class="tab-pane">');
                    print('<div class="row">');
                        print('<div id="div_preparacion" class="col-md-12 ts_list_forms">');

                        print('</div>');
                    print('</div>');    
                print('</div>');
                print('<div id="tab_list_5" class="tab-pane">');
                    print("idv5");
                print('</div>');
                print('<div id="tab_list_6" class="tab-pane">');
                    print("idv6");
                print('</div>');
                print('<div id="tab_list_7" class="tab-pane">');
                    print("idv7");
                print('</div>');
            print('</div>');  //Fin content
        print('</div>');  //Fin tabs    
        
    print('</div>');  //Fin column    
            
        
$css->PageFin();
print('<script src="../../componentes/shortcuts.js"></script>');  //script propio de la pagina
print('<script src="jsPages/restobarpos.js"></script>');  //script propio de la pagina
$css->Cbody();
$css->Chtml();

?>