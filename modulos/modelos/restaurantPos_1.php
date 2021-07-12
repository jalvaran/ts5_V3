<?php
/**
 * Pagina POS para restaurantes
 * 2020-01-30, Julian Alvaran Techno Soluciones SAS
 */
$myPage="restaurantPos.php";
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
    
    $css->div("", "col-md-12", "", "", "", "", "");
        $css->div("", "nav-tabs-custom", "", "", "", "", "");
    print('
         
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Pedir</a></li>
              <li><a href="#tab_2" data-toggle="tab">Listado de Pedidos</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>How to use:</b>

                <p>Exactly like the original bootstrap tabs except you should use
                  the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                A wonderful serenity has taken possession of my entire soul,
                like these sweet mornings of spring which I enjoy with my whole heart.
                I am alone, and feel the charm of existence in this spot,
                which was created for the bliss of souls like mine. I am so happy,
                my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                that I neglect my talents. I should be incapable of drawing a single stroke
                at the present moment; and yet I feel that I never was a greater artist than now.
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                The European languages are members of the same family. Their separate existence is a myth.
                For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                in their grammar, their pronunciation and their most common words. Everyone realizes why a
                new common language would be desirable: one could refuse to pay expensive translators. To
                achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                words. If several languages coalesce, the grammar of the resulting language is more simple
                and regular than that of the individual languages.
              </div>
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          
       ');
        $css->Cdiv();
    $css->Cdiv();
    
    $css->CrearDiv("", "col-md-8", "left", $Habilita, 1); 
        
        $css->fieldset("", "", "FieldDatosCotizacion", "DatosCotizacion", "", "");
            $css->legend("", "");
                
                print("<a name='AnclaInicio' >POS TS5,<span id='SpEstadoCaja'> Usted está asignad@ a la caja No. $DatosCaja[ID]</span></a>");
                
            $css->Clegend(); 
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="input-group input-group-md">');
                $css->select("TipoPedido", "form-control", "TipoPedido", "", "", "", "onchange=CambiarListaPedidos()");

                    $sql="SELECT * FROM restaurante_tipos_pedido ";
                    $Consulta=$obCon->Query($sql);
                    while($DatosTipoPedido=$obCon->FetchAssoc($Consulta)){
                        $css->option("", "", "", $DatosTipoPedido["ID"], "", "");
                            print($DatosTipoPedido["Nombre"]);
                        $css->Coption();
                    }
                $css->Cselect();
                print('<span class="input-group-btn">
                          <button type="button" class="btn btn-success btn-flat" onclick=FormularioCrearPedido()><i class="fa fa-plus"></i></button>
                        </span>');
                $css->CerrarDiv();
            $css->CerrarDiv();
            
            $css->CrearDiv("DivInfoPedidoActivo", "col-md-8", "center", 1, 1);
                
                
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-1", "right", 1, 1);    
                print('<span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-flat" onclick=MuestraOculta(`DivOpcionesGenerales`)><i class="fa fa-bars"></i></button>
                      </span>');
                
            $css->CerrarDiv();
            
        $css->Cfieldset();    
        
        $css->CrearDiv("DivOpcionesGenerales", "col-md-12", "left", 0, 0);
        
            $css->fieldset("", "", "FieldDatosCotizacion", "DatosCotizacion", "", "");
                $css->legend("", "");
                    print("<a href='#'>Opciones Adicionales:</a>");
                $css->Clegend();  
                
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    print('<div class="input-group input-group-md">');
                        print('<span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-flat" onclick=ModalCrearTercero(`ModalAccionesPOS`,`DivFrmPOS`);><i class="fa fa-user-plus"></i></button>
                              </span>');
                        $css->select("idCliente", "form-control", "idCliente", "", "", "", "style=width:100%");
                            $css->option("", "", "", "1", "", "");
                                print("Clientes Varios");
                            $css->Coption();

                        $css->Cselect();
                        print('<span class="input-group-btn">
                                  <button type="button" class="btn btn-info btn-flat" onclick=EditarTerceroPOS()><i class="fa fa-edit"></i></button>
                                </span>');
                        print("</div>");
                $css->CerrarDiv();
                
                print("<br><br>");
                /*
                $css->CrearDiv("", "col-md-2", "left", 1, 1);
                   $css->CrearBotonEvento("BtnCrearEgreso", "Crear Egreso", 1, "onclick", "ModalCrearEgreso();", "azul", "");
                $css->CerrarDiv();   
                
                 * 
                 */
                $css->CrearDiv("", "col-md-2", "left", 1, 1);
                   $css->CrearBotonEvento("BtnCerrarTurno", "Cerrar Turno", 1, "onclick", "FormularioCerrarTurno();", "rojo", "");
                $css->CerrarDiv();
                
            $css->Clegend();    
        
        $css->CerrarDiv();
        
        $css->CrearDiv("DivMensajes", "col-md-12", "center", 1, 1); 
            
        $css->CerrarDiv();
        $css->CrearDiv("", "col-md-12", "center", 1, 1); 
            $css->fieldset("", "", "FieldDatos", "Agregar Items", "", "");
                $css->legend("", "");
                    print("<a href='#'>Agregar items</a>");
                $css->Clegend();  

                $css->CrearDiv("", "col-md-7", "center", 1, 1);
                    $css->select("CmbBusquedaItems", "form-control", "CmbBusquedaItems", "", "", "", "");
                        $css->option("", "", "", "", "", "");
                            print("Buscar Item");
                        $css->Coption();

                    $css->Cselect();
                $css->CerrarDiv();
                
                $css->CrearDiv("", "col-md-3", "center", 1, 1);
                    $css->input("number", "Codigo", "form-control", "Codigo", "Codigo", "", "Código", "off", "", "");
                $css->CerrarDiv();  
                
                $css->CrearDiv("", "col-md-2", "center", 1, 1);
                    print('<div class="input-group input-group-md">');
                        $css->input("number", "Cantidad", "form-control", "Cantidad", "Cantidad", "1", "Cantidad", "off", "", "");
                         print('<span class="input-group-btn">
                            <button type="button" id="BtnAgregarItem" class="btn btn-success btn-flat" onclick=AgregarItem()><i class="fa fa-plus"></i></button>
                          </span>');
                    $css->CerrarDiv();
                $css->CerrarDiv();
                
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    $css->textarea("Observaciones", "form-control", "Observaciones", "", "Observaciones", "", "");
                        
                    $css->Ctextarea();
                $css->CerrarDiv();
            $css->Cfieldset();    
        $css->CerrarDiv();                
        
        $css->CrearDiv("", "col-md-12", "center", 1, 1); 
            $css->CrearDiv("DivDatosItems", "col-md-8", "left", $Habilita, 1); //Datos para la creacion de la compra
                $css->fieldset("", "", "FieldDatosPedido", "items en esta venta", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Items Agregados</a>");
                    $css->Clegend();    
                    $css->CrearDiv("DivItems", "", "center", 1, 1,"","height: 400px;overflow: auto;");   

                    $css->CerrarDiv();       
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("DivTotales", "col-md-4", "left", $Habilita, 1); //Datos para la creacion de la compra
                $css->fieldset("", "", "FieldDatosPedido", "Totales en esta venta", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Totales</a>");
                    $css->Clegend();    
                    $css->CrearDiv("DivTotalesPedido", "", "center", 1, 1,"","height: 400px;overflow: auto;");   

                    $css->CerrarDiv();       
                $css->Cfieldset();
            $css->CerrarDiv();
    
        $css->CerrarDiv();
        
    $css->CerrarDiv();
    
    $css->CrearDiv("", "col-md-4", "left", $Habilita, 1); 
        $css->fieldset("", "", "FieldDatosCotizacion", "DatosCotizacion", "", "");
            $css->legend("", "");
                print("<a href='#'>Lista de Pedidos</a>");
                
            $css->Clegend(); 
            
            $css->CrearDiv("DivListadoPedidos", "", "center", 1, 1,"","height: 800px;overflow: auto;");   

            $css->CerrarDiv();
            
        $css->Cfieldset();   
    $css->CerrarDiv();
    print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
    print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
    print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
    print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
$css->PageFin();
print('<script src="../../componentes/shortcuts.js"></script>');  //script propio de la pagina
print('<script src="jsPages/restaurantPos.js"></script>');  //script propio de la pagina
$css->Cbody();
$css->Chtml();

?>