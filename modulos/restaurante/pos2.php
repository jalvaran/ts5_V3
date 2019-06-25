<?php
/**
 * Pagina para la creacion de compras 
 * 2018-11-27, Julian Alvaran Techno Soluciones SAS
 */
$myPage="pos2.php";
$myTitulo="Restaurante TS5";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    
    $css->Modal("ModalAcciones", "TS5", "", 1);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();
        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    $css->section("", "content", "", "");
    $css->CrearInputText("idPedido", "hidden", "", "", "", "", "", "", 100, 30, 0, 1);
    $css->TabInit();
            $css->TabLabel("TabCuentas1", "<strong>Crear</strong>", "Tab_1", 1,"");
            
            $css->TabLabel("TabCuentas2", "<strong>Pedidos</strong>", "Tab_2",0,"onclick=DibujePedidos()");
            $css->TabLabel("TabCuentas5", "<strong>Detalles</strong>", "Tab_5", 0,"");
            $css->TabLabel("TabCuentas3", "<strong>Facturar</strong>", "Tab_3",0,"onclick=CargarHistorialPagos()");  
            $css->TabLabel("TabCuentas4", "<strong>Opciones</strong>", "Tab_4",0,"onclick=HistorialAnticipos()"); 
            
        $css->TabInitEnd();
        $css->TabContentInit();
        
        
        $css->TabPaneInit("Tab_1", 1);
            $css->section("", "contentTab1", "", "");
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                $css->CrearTitulo("Opciones de Creación", "azul");
                $css->div("", "col-sm-2", "", "", "", "", "");
                    
                    $css->IconButton("BtnNuevoPedido","bntNuevoPedido",'fa fa-plus',"Nuevo Pedido","onclick='AbrirFormularioNuevoPedido()'",$spanActivo=0,"orange",$style='style="background-color:#d9f2ff;color:black"');

                    $css->IconButton("BtnNuevoDomicilio","bntNuevoDomicilio",'fa fa-motorcycle',"Nuevo Domicilio","onclick='AbrirNuevoDomicilio()'",$spanActivo=0,"orange",$style='style="background-color:#fffed9;color:black"');
                    $css->IconButton("BtnNuevoBarra","bntNuevoBarra",'fa fa-home',"Pedido en Barra","onclick='AbrirNuevoPedido()'",$spanActivo=0,"orange",$style='style="background-color:#d9dfff;color:black"');
                    $css->IconButton("BtnNuevoTercero","bntNuevoTercero",'fa fa-user-plus',"Nuevo Tercero","onclick='AbrirNuevoPedido()'",$spanActivo=0,"orange",$style='style="background-color:#ffd9e3;color:black"');
                $css->CerrarDiv();
                $css->div("DivTa1_1", "col-sm-10", "", "", "", "", "");

                $css->CerrarDiv();
            
            $css->CerrarDiv();
            $css->Csection();
        $css->TabPaneEnd();
        $css->TabPaneInit("Tab_2");
            $css->div("DivListaPedidos", "col-sm-12", "", "", "", "", "");
            
            $css->CerrarDiv();
        
        $css->TabPaneEnd();
        $css->TabPaneInit("Tab_3");
            
             
            $css->CrearDiv("DivTab3", "", "center", 1, 1);
            $css->CerrarDiv();
            
        $css->TabPaneEnd();
        
        $css->TabPaneInit("Tab_4");
                         
            $css->CrearDiv("DivTab4", "", "center", 1, 1);
            $css->CerrarDiv();
            
        $css->TabPaneEnd();
        
        $css->TabPaneInit("Tab_5");
            
            $css->CrearDiv("DivTituloPedido", "col-sm-12", "left", 1, 1);
            $css->CerrarDiv();
            $css->div("DivAgregarItem", "col-sm-12", "", "", "", "", "style=display:none;");
                $css->div("", "col-sm-12", "", "", "", "", "");
                    $css->CrearTitulo("<strong>Departamentos</strong>",'verde');
                    $css->div("DivDepartamentos", "col-sm-12", "", "", "", "", "style=overflow:auto;height:100px;");
                    $css->CerrarDiv();
                $css->CerrarDiv();
                $css->div("DivOpcionesProductos", "col-sm-12", "", "", "", "", "style=text-align:center");
                    $html='<div class="input-group" style="text-align:center">
                      <div class="input-group-addon" onclick="DisminuyeCantidad()" style="background-color:#ffc5c5;cursor:pointer;font-size:40px">
                        <i class="fa fa-minus-circle"></i>
                      </div>
                      <input id="Cantidad" type="number" value="1"  placeholder="Cantidad" style="width:94%" ><br>
                      <input id="Observaciones" type="text"  placeholder="Observaciones" style="width:94%" ><br>
                      <input id="Busqueda" type="text" class="" placeholder="Buscar" onkeyup="BuscarProductos()" style="width:94%">
                      <div class="input-group-addon" onclick="IncrementaCantidad()" style="background-color:#c5ffcc;cursor:pointer;font-size:40px" >
                        <i class="fa fa-plus-circle"></i>
                      </div>
                    </div>';

                    $css->CrearTitulo($html, "azul");

                    $css->div("DivProductos", "col-sm-12", "", "", "", "", "style=overflow:auto;height:150px;");

                    $css->CerrarDiv();
                $css->CerrarDiv();
            $css->CerrarDiv();
            $css->div("", "col-sm-12", "", "", "", "", "");
                $css->CrearTitulo("<strong>Items en el Pedido <span id='spTotal'></span></strong>", "naranja");
                $css->div("DivItems", "", "", "", "", "", "style=overflow:auto;height:500px;");
                $css->CerrarDiv();
            $css->CerrarDiv();
            $css->div("DivTotales", "col-sm-3", "", "", "", "", "style=overflow:auto;height:500px;");
            $css->CerrarDiv();

        $css->TabPaneEnd();
           
            
            
            /*            
            $css->CrearDiv("DivTotales", "col-sm-4", "center", 1, 1);
            $css->CerrarDiv();
            
             * 
             */
        $css->TabPaneEnd();
        
    $css->Csection();

$css->PageFin();

print('<script src="jsPages/pos2.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>