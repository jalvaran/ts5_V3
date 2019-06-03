<?php 
$myPage="DarDeBajaAltaInsumos.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$obCon = new ProcesoVenta($idUser);

print("<html>");
print("<head>");
$css =  new CssIni("Baja Altas");

print("</head>");
print("<body>");
    
    //include_once("procesadores/ProcesaCreaTraslado.php");
    
    $css->CabeceraIni("Bajas Altas"); //Inicia la cabecera de la pagina
    $css->CabeceraFin();    
    
    ///////////////Creamos el contenedor
    /////
    /////
     
     
    $css->CrearDiv("principal", "container", "center",1,1);
    ////Menu de historial
    
    
       
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "", "center",1,1);
     /////////////////Cuadro de dialogo de Clientes create
    
    
    $css->CrearDiv("DivDatosItemTraslado", "", "center", 1, 1);
    
    $css->CrearTabla();
        $css->FilaTabla(16);            
            $css->ColTabla("<strong>Dar de Baja o alta a un insumo o Producto</strong>", 4,'C');
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td colspan=4 style=text-align:center>");
                print("<strong>Tipo de movimiento:<br></strong>");
                $css->CrearSelect("TipoMovimiento", "",400);
                    $css->CrearOptionSelect("", "Seleccione el tipo de movimiento", 0);
                    $css->CrearOptionSelect("1", "Baja", 0);
                    $css->CrearOptionSelect("2", "Alta", 0);
                $css->CerrarSelect();
               
            print("</td>");
        $css->CierraFilaTabla();   
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Insumo</strong>", 1);
            $css->ColTabla("<strong>Observaciones</strong>", 1);
            $css->ColTabla("<strong>Cantidad</strong>", 1);
            $css->ColTabla("<strong>Accion</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            
            print("<td>");
                $css->CrearSelect("idInsumo", "",400);
                    $css->CrearOptionSelect("", "Buscar Insumo", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearTextArea("TxtObservacionesInsumo", "", "", "Observaciones", "", "", "", 200, 60, 0, 1);
            print("</td>");
            print("<td>");
                $css->CrearInputNumber("TxtCantidadInsumo", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 0, 0, "", "any");
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnEjecutar", "Ejecutar", 1, "OnClick", "BajaAltaInsumo()", "rojo", "");
            print("</td>");
        $css->CierraFilaTabla();
        
        /*
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Producto</strong>", 1);
            $css->ColTabla("<strong>Observaciones</strong>", 1);
            $css->ColTabla("<strong>Cantidad</strong>", 1);
            $css->ColTabla("<strong>Ejecutar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            
            print("<td>");
                $css->CrearSelect("idProductoReceta", "",400);
                    $css->CrearOptionSelect("", "Buscar Producto", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearTextArea("TxtObservacionesInsumo", "", "", "Observaciones", "", "", "", 200, 60, 0, 1);
            print("</td>");
            print("<td>");
                $css->CrearInputNumber("TxtCantidadProducto", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 0, 0, "", "any");
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnDarBajaProducto", "Ejecutar", 1, "OnClick", "BajaAltaProducto()", "naranja", "");
            print("</td>");
        $css->CierraFilaTabla();
         * 
         */
    $css->CerrarTabla();
    $css->CerrarDiv();    
    $css->CrearDiv("DivMensajes", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CrearDiv("DivItemsRecetas", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaCssJSSelect2(); //Agregamos CSS y JS de Select2
    $css->AgregaSubir();
    print('<script src="jsPages/BajaAlta.js"></script>');
    
    print("</body></html>");
    ob_end_flush();
?>