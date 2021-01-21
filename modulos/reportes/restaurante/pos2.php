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
            $css->TabLabel("TabCuentas1", "<strong>Crear</strong>", "Tab_1", 1,"onclick='AbrirFormularioNuevoPedido();idPestana=1;'");
            
            $css->TabLabel("TabCuentas2", "<strong>Pedidos</strong>", "Tab_2",0,"onclick='DibujePedidos();idPestana=2;'");
            $css->TabLabel("TabCuentas5", "<strong>Detalles</strong>", "Tab_5", 0,"onclick='idPestana=5;'");
            $css->TabLabel("TabCuentas3", "<strong>Facturar</strong>", "Tab_3",0,"onclick='AbrirOpcionesFacturacion();idPestana=3;'");  
            $css->TabLabel("TabCuentas4", "<strong>Preparación</strong>", "Tab_4",0,"onclick='idPestana=4;'"); 
            if($TipoUser=='administrador'){
                $css->TabLabel("TabCuentas6", "<strong>Resumen Turno Actual</strong>", "Tab_6",0,"onclick='VerResumenTurno();idPestana=6;'"); 
            }
        $css->TabInitEnd();
        $css->TabContentInit();
        
        
        $css->TabPaneInit("Tab_1", 1);
            $css->section("", "contentTab1", "", "");
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                $css->CrearTitulo("<strong>Opciones de Creación</strong>", "azul");
                $css->div("", "col-sm-2", "", "", "", "", "");
                    
                    $css->IconButton("BtnNuevoPedido","bntNuevoPedido",'fa fa-plus',"Nuevo Pedido","onclick='AbrirFormularioNuevoPedido()'",$spanActivo=0,"orange",$style='style="background-color:#d9f2ff;color:black"');

                    //$css->IconButton("BtnNuevoDomicilio","bntNuevoDomicilio",'fa fa-motorcycle',"Nuevo Domicilio","onclick='AbrirNuevoDomicilio()'",$spanActivo=0,"orange",$style='style="background-color:#fffed9;color:black"');
                    //$css->IconButton("BtnNuevoBarra","bntNuevoBarra",'fa fa-home',"Pedido en Barra","onclick='AbrirNuevoPedido()'",$spanActivo=0,"orange",$style='style="background-color:#d9dfff;color:black"');
                    $css->IconButton("BtnNuevoTercero","bntNuevoTercero",'fa fa-user-plus',"Nuevo Tercero","onclick='ModalCrearTercero(`ModalAcciones`,`DivFrmModalAcciones`);'",$spanActivo=0,"orange",$style='style="background-color:#ffd9e3;color:black"');
                    if($TipoUser=='administrador'){
                        $css->IconButton("BtnCrearEgreso","BtnCrearEgreso",'fa fa-money',"Crear Egreso","onclick='ModalCrearEgreso()'",$spanActivo=0,"orange",$style='style="background-color:#d7dbf8;color:black"');
                        $css->IconButton("BtnCerrarTurno","BtnCerrarTurno",'fa fa-cogs',"Cerrar Turno","onclick='AbrirCierreTurno()'",$spanActivo=0,"orange",$style='style="background-color:#ff2b2b;color:white"');
                    }
                    
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
            
             
            $css->CrearDiv("DivFormularioFacturacion", "", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivProcesamiento", "", "center", 1, 1);
            $css->CerrarDiv();
            
        $css->TabPaneEnd();
        
        $css->TabPaneInit("Tab_4");
                         
            $css->CrearDiv("DivTab4", "", "center", 1, 1);
            $css->CerrarDiv();
            
        $css->TabPaneEnd();
        
        $css->TabPaneInit("Tab_5");
            
            $css->CrearDiv("DivTituloPedido", "col-sm-4", "left", 1, 1);
            $css->CerrarDiv();
            $css->div("DivAgregarItem", "col-sm-8", "", "", "", "", "");
                $css->div("", "col-sm-6", "", "", "", "", "");
                    $css->CrearTitulo("<strong>Departamentos</strong>",'verde');
                    $css->div("DivDepartamentos", "col-sm-12", "", "", "", "", "style=overflow:auto;height:140px;");
                    $css->CerrarDiv();
                $css->CerrarDiv();
                $css->div("DivOpcionesProductos", "col-sm-6", "", "", "", "", "style=text-align:center");
                $css->CrearTitulo("<strong>Agregar Item</strong>");    
                $html='<div class="input-group" style="text-align:center">
                       
                      <div class="input-group-addon" onclick="DisminuyeCantidad()" style="background-color:#ffc5c5;cursor:pointer;font-size:40px">
                        <i class="fa fa-minus-circle"></i>
                      </div>
                       <div id="DivSelectProductos">
                      <select id="idProducto" name="idProducto" class="form-control" style="">
                        <option value="">Seleccione un producto</option>
                      </select>
                      </div>
                      <input id="Cantidad" type="number" value="1" class="form-control"  placeholder="Cantidad"  ><br>
                      <input id="Observaciones" type="text" class="form-control" placeholder="Observaciones"  ><br>
                      <input id="BtnAgregarItem" type="button" value="Agregar" class="btn btn-success" style="width:100%" onclick="AgregarProducto()" >
                      <div class="input-group-addon" onclick="IncrementaCantidad()" style="background-color:#c5ffcc;cursor:pointer;font-size:40px" >
                        <i class="fa fa-plus-circle"></i>
                      </div>
                    </div>';
                    print($html);
                   
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
           
        if($TipoUser=='administrador'){
            
        $css->TabPaneInit("Tab_6");
                         
            $css->CrearDiv("DivTab6", "", "center", 1, 1);
            $css->CerrarDiv();
            
        $css->TabPaneEnd();
            
        }
    $css->Csection();

$css->PageFin();

print('<script src="jsPages/pos2.js"></script>');  //script propio de la pagina

$css->AddJSExcel();
$css->Cbody();
$css->Chtml();

?>