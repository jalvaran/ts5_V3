<?php
/**
 * Pagina para la creacion de compras 
 * 2018-11-27, Julian Alvaran Techno Soluciones SAS
 */
$myPage="BajasAltas.php";
$myTitulo="Movimientos en Inventario TS5";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    
    $css->Modal("ModalAcciones", "TS5", "", 1);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();
        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    //$css->div("", "container", "", "", "", "", "");
    $css->CrearDiv("", "col-md-12", "left", 1, 1); 
        $css->h3("", "", "", "");
                print("<strong>Registrar un Movimiento en el Inventario</strong>");
        $css->Ch3();
    $css->CerrarDiv(); 
        
       
    
    $css->CrearDiv("DivOpcionesCrearCompras", "col-md-12", "left", 1, 1); 
        
        $css->fieldset("", "", "FieldDatosCompra", "DatosCompra", "", "");
            $css->legend("", "");
                print("<a href='#'>Cree o Seleccione un Comprobante de Movimientos en el Inventario</a>");
            $css->Clegend();   
            
        $css->CrearDiv("DivBtnCrear", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnNuevaCompra", "Crear Comprobante", 1, "onClick", "AbrirModalNuevoComprobante()", "azul", "");
        $css->CerrarDiv();
        $css->CrearDiv("DivDatosCompras", "col-md-8", "left", 1, 1); 
            $css->select("idComprobante", "form-control", "idComprobante", "", "", "onchange=DibujeComprobante()", "");
            $css->option("", "", "","", "", "");
                print("Seleccione un Comprobante");
            $css->Coption();
            $consulta = $obCon->ConsultarTabla("inventario_comprobante_movimientos","WHERE Estado='ABIERTO'");
            while($DatosComprobante=$obCon->FetchArray($consulta)){
                
                $css->option("", "", "", $DatosComprobante['ID'], "", "");
                    print($DatosComprobante['ID']." ".$DatosComprobante["Fecha"]." ".$DatosComprobante['Observaciones']);
                $css->Coption();
            }
            $css->Cselect();
           
        $css->CerrarDiv();
        $css->CrearDiv("DivBtnEditar", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnEditarCompra", "Editar Datos", 0, "onClick", "AbrirModalNuevoComprobante('Editar')", "azul", "");
        $css->CerrarDiv();
        
       
        
        $css->Cfieldset(); 
    $css->CerrarDiv();
    print("<br><br><br><br><br>");
    $css->CrearDiv("DivDatosCompras", "col-md-12", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosCompra", "DatosComprobante", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Agregar items a este Comprobante</a>");
                    $css->Clegend();    
        $css->CrearDiv("DivAgregarItems", "", "center", 1, 1);   
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->select("CmbListado", "form-control", "CmbListado", "Listado", "", "", "onchange=ConvertirSelectBusquedas()");
                    $css->option("", "", "", 1, "", "");
                        print("Productos para la venta");
                    $css->Coption();
                    
                    $css->option("", "", "", 2, "", "");
                        print("Insumos");
                    $css->Coption();
                    
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->select("CmbBusquedas", "form-control", "CmbBusquedas", "Búsquedas<br>", "", "", "style=width:100%");
                   
                    $css->option("", "", "", "", "", "");
                        print("Buscar");
                    $css->Coption();
                    
                    
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->select("TipoMovimiento", "form-control", "TipoMovimiento", "Tipo de Movimiento", "", "", "");
                    $css->option("", "", "", 1, "", "");
                        print("BAJA");
                    $css->Coption();
                    $css->option("", "", "", 2, "", "");
                        print("ALTA");
                    $css->Coption();
                    
                $css->Cselect();
            $css->CerrarDiv();
                        
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
               print("<strong>Cantidad</strong>");
               $css->input("number", "Cantidad", "form-control", "Cantidad", "Cantidad", "", "Cantidad", "off", "", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("DivBtnEditar", "col-md-2", "center", 1, 1); 
                print("<strong>Agregar</strong>");
                $css->CrearBotonEvento("BtnAgregarItem", "Agregar Item", 1, "onClick", "AgregarItem(event)", "verde", "");
            $css->CerrarDiv();
            
            print("<br><br><br><br>");
            
            
            
        
        $css->CerrarDiv();       
            $css->Cfieldset();
    $css->CerrarDiv();
    //$css->CerrarDiv();

    print("<br>");
    $css->CrearDiv("DivDatosCompras", "col-md-10", "left", 1, 1); //Items del comprobante
        $css->fieldset("", "", "FieldDatosCompra", "items en este comprobante", "", "");
            $css->legend("", "");
                print("<a href='#'>Items Agregados a este comprobante</a>");
            $css->Clegend();   
            $css->CrearDiv("DivMensajesModulo", "", "center", 1, 1);   

            $css->CerrarDiv();  
            $css->CrearDiv("DivItemsComprobantes", "", "center", 1, 1);   

            $css->CerrarDiv();       
        $css->Cfieldset();
            
        
    $css->CerrarDiv();
    
    $css->CrearDiv("DivDatosCompras", "col-md-2", "left", 1, 1); //Items del comprobante
        $css->fieldset("", "", "FieldDatosCompra", "Guardar", "", "");
            $css->legend("", "");
                print("<a href='#'>Guardar</a>");
            $css->Clegend();   
            
            $css->CrearBotonEvento("BtnGuardarComprobante", "Guardar", 1, "onclick", "ConfirmarBajaAlta()", "rojo", "");
            $css->Cfieldset();
    $css->CerrarDiv();
    
    $css->Cdiv();

$css->PageFin();

print('<script src="jsPages/BajasAltas.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>