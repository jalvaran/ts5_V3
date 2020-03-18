<?php
/**
 * Pagina para las ventas POS
 * 2019-03-01, Julian Alvaran Techno Soluciones SAS
 */
$myPage="pos.php";
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
        print('<a id="vinculoItems" href="#AnclaItems" title="Facturas">ITEMS </a>');
        print('<a id="vinculoOpcionesPago" href="#AnclaOpcionesPago" title="Facturas">OPCIONES DE PAGO </a>');
    $css->CerrarDiv();
    
    $css->input("hidden", "idCajero", "", "idCajero", "", $idUser, "", "", "", "");
    $css->CrearDiv("", "col-md-12", "left", $Habilita, 1); 
        $css->fieldset("", "", "FieldDatosCotizacion", "DatosCotizacion", "", "");
            $css->legend("", "");
                print("<a href='#'>POS TS5,<span id='SpEstadoCaja'> Usted está asignad@ a la caja No. $DatosCaja[ID]</span></a>");
                
            $css->Clegend(); 
         
    

    
    $css->CrearDiv("", "col-md-2", "center", 1, 1);
        $css->select("idPreventa", "form-control", "idPreventa", "", "", "", "onchange=DibujePreventa()");
            $css->option("", "", "", "", "", "");
                print("Preventa");
            $css->Coption();
            $sql="SELECT * FROM vestasactivas WHERE Usuario_idUsuario='$idUser'";
            $Consulta=$obCon->Query($sql);
            while($DatosVentasActivas=$obCon->FetchAssoc($Consulta)){
                $css->option("", "", "", $DatosVentasActivas["idVestasActivas"], "", "");
                    print($DatosVentasActivas["idVestasActivas"]." ".$DatosVentasActivas["Nombre"]);
                $css->Coption();
            }
        $css->Cselect();
    $css->CerrarDiv();
    
            
    $css->CrearDiv("", "col-md-3", "center", 1, 1);
        $css->select("CmbListado", "form-control", "CmbListado", "", "", "", "");
            $css->option("", "", "", 1, "", "");
                print("Productos para la venta");
            $css->Coption();

            $css->option("", "", "", 2, "", "");
                print("Servicios");
            $css->Coption();
            $css->option("", "", "", 3, "", "");
                print("Productos para alquilar");
            $css->Coption();
            $css->option("", "", "", 4, "", "");
                print("Sistemas");
            $css->Coption();
            $css->option("", "", "", 5, "", "");
                print("Modo Bascula");
            $css->Coption();
            

        $css->Cselect();
    $css->CerrarDiv();
    
    
    
    $css->CrearDiv("", "col-md-5", "center", 1, 1);
        $css->select("idCliente", "form-control", "idCliente", "", "", "", "style=width:100%");
            $css->option("", "", "", "1", "", "");
                print("Clientes Varios");
            $css->Coption();
            
        $css->Cselect();
    $css->CerrarDiv();
    
    $css->CrearDiv("", "col-md-2", "right", 1, 1); 
         $css->CrearBotonEvento("BtnOpcionesAdicionales", "Opciones", 1, "onclick", "MuestraOculta('DivOpcionesGenerales')", "naranja", "");
        
    $css->CerrarDiv(); 
    $css->Cfieldset();    
    $css->CerrarDiv();
    
    
    $css->CrearDiv("DivOpcionesGenerales", "col-md-12", "left", 0, 0);
        $css->fieldset("", "", "FieldDatosCotizacion", "DatosCotizacion", "", "");
            $css->legend("", "");
                print("<a href='#'>Opciones Adicionales:</a>");
            $css->Clegend();  
            
            $css->CrearDiv("", "col-md-5", "left", 1, 1);
                print('<div class="input-group input-group-md">');
                    $css->select("CmbNuevaOpcion", "form-control", "CmbNuevaOpcion", "", "", "", "");
                        $css->option("", "", "", 1, "", "");
                            print("Agregar Preventa");
                        $css->Coption();
                        $css->option("", "", "", 2, "", "");
                            print("Crear Tercero");
                        $css->Coption();
                        $css->option("", "", "", 3, "", "");
                            print("Ingresos por plataformas de Pago");
                        $css->Coption();
                        $css->option("", "", "", 4, "", "");
                            print("Crear Separado");
                        $css->Coption();
                        $css->option("", "", "", 5, "", "");
                            print("Crear Egreso");
                        $css->Coption();
                        $css->option("", "", "", 6, "", "");
                            print("Anticipos por Encargos");
                        $css->Coption();
                    $css->Cselect();
                    print('<div class="input-group-btn">');                
                        $css->CrearBotonEvento("BtnNuevaOpcion", "+", 1, "onclick", "SeleccionaNuevaAccion()", "verde");
                    $css->CerrarDiv();
                $css->CerrarDiv();    
            $css->CerrarDiv();
            
            /*
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
                $css->CrearBotonEvento("BtnAgregarPreventa", "Agregar Preventa", 1, "onclick", "AgregarPreventa();", "azulclaro", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
                $css->CrearBotonEvento("BtnCrearTercero", "Crear Tercero", 1, "onclick", "ModalCrearTercero();", "verde", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
                $css->CrearBotonEvento("BtnRegistrarIngreso", "Ingresos", 1, "onclick", "ModalIngresosPlataformas();", "azulclaro", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
                $css->CrearBotonEvento("BtnCrearSeparado", "Crear Separado", 1, "onclick", "ModalCrearSeparado();", "naranja", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
               $css->CrearBotonEvento("BtnCrearEgreso", "Crear Egreso", 1, "onclick", "ModalCrearEgreso();", "azul", "");
            $css->CerrarDiv();
            
             * 
             */
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
               $css->CrearBotonEvento("BtnCerrarTurno", "Cerrar Turno", 1, "onclick", "CerrarTurno();", "rojo", "");
            $css->CerrarDiv();
            print("<br><br><br>");           
            
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
               $css->input("text", "TxtBuscarSeparado", "form-control", "TxtBuscarSeparado", "TxtBuscarSeparado", "", "Buscar Separado", "off", "", "onkeyup=BuscarSeparados()");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
               $css->input("text", "TxtBuscarCredito", "form-control", "TxtBuscarCredito", "TxtBuscarCredito", "", "Buscar Crédito", "off", "", "onkeyup=BuscarCreditos()");
            $css->CerrarDiv();
                
            
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
            
            print('<div class="input-group input-group-md">
                <input type="password" id="TxtAutorizaciones" class="form-control" placeholder="Autorizaciones">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >Acción
                    <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu">
                    
                        <li><a href="#" onclick="AutorizarPreventa()">Autorizar Preventa</a></li>
                        <li><a href="#" onclick="PreciosMayoristas()">Cambiar Precios a Mayorista</a></li>
                        <li><a href="#" onclick="AbrirModalAutorizacionesPOS()">Otros</a></li>
                    
                  </ul>
                </div>
               
              </div>');
            
            
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
               $css->input("password", "CodigoTarjetaEntrada", "form-control", "CodigoTarjetaEntrada", "CodigoTarjeta", "", "Tarjeta Código", "off", "", "onchange=CodigoTarjeta()");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "left", 1, 1);
               $css->input("text", "TxtBuscarAcuerdo", "form-control", "TxtBuscarAcuerdo", "TxtBuscarAcuerdo", "", "Buscar Acuerdo", "off", "", "onkeyup=BuscarAcuerdo()");
            $css->CerrarDiv();
            
            $css->CrearDiv("DivBusquedasPOS", "col-md-12", "left", 1, 1);
              
            $css->CerrarDiv();
            
        $css->Cfieldset();
        print("<br><br>");
    $css->CerrarDiv();  
    
    $css->CrearDiv("DivDatos", "col-md-12", "left", $Habilita, 1); //Datos para la creacion de la compra
        
            
        $css->CrearDiv("DivMensajesModulo", "", "center", 1, 1); 
        $css->CerrarDiv(); 
        
        $css->fieldset("", "", "FieldDatos", "Agregar Items", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Agregar items</a>");
                    $css->Clegend();    
        $css->CrearDiv("DivAgregarItems", "", "center", 1, 1); 
        
            $css->CrearDiv("", "col-md-5", "center", 1, 1);
                $css->select("CmbBusquedaItems", "form-control", "CmbBusquedaItems", "", "", "style=width:100%", "");
                    $css->option("", "", "", "", "", "");
                        print("Buscar Item");
                    $css->Coption();
                    
                $css->Cselect();
            $css->CerrarDiv();
                    
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->input("text", "Codigo", "form-control", "Codigo", "Codigo", "", "Código", "off", "", "onchange=AgregarItem()");
            $css->CerrarDiv();            
            
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
               
               $css->input("number", "Cantidad", "form-control", "Cantidad", "Cantidad", "1", "Cantidad", "off", "", "");
            $css->CerrarDiv();
            
            
            $css->CrearDiv("DivBtnAregar", "col-md-2", "left", 1, 1); 
                $css->CrearBotonEvento("BtnAgregarItem", "Agregar", 1, "onClick", "AgregarItem()", "verde", "");
            $css->CerrarDiv();
            
        
        $css->CerrarDiv();       
            $css->Cfieldset();
    $css->CerrarDiv();
    //$css->CerrarDiv();

    print("<br><br><br><br><br><br><br><br>");
    
    
    
    $css->CrearDiv("DivDatosCompras", "col-md-8", "left", $Habilita, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosCompra", "items en esta venta", "", "");
            $css->legend("", "");
                print("<a href='#'>Items Agregados</a>");
            $css->Clegend();    
            $css->CrearDiv("DivItems", "", "center", 1, 1,"","height: 400px;overflow: auto;");   

            $css->CerrarDiv();       
        $css->Cfieldset();
        $css->CerrarDiv();
        
        
        $css->CrearDiv("DivInfoTotales", "col-md-4", "left", $Habilita, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosCompra", "Totales", "", "");
            $css->legend("", "");
                print("<a href='#'>Totales</a>");
            $css->Clegend();    
           
            $css->CrearDiv("DivTotales", "", "center", 1, 1);   
                
            $css->CerrarDiv(); 
        $css->Cfieldset();    
    $css->CerrarDiv();
        
    $css->CrearDiv("DivInfoOpcionesPago", "col-md-12", "left", $Habilita, 1);
            $css->fieldset("", "", "FieldOpcionesPago", "Opciones de Pago", "", "");
                $css->legend("", "");
                    print("<a name='AnclaOpcionesPago'>Opciones de Pago</a>");
                $css->Clegend();    

                $css->CrearDiv("DivOpcionesPagoManta", "", "center", 1, 1);   

                $css->CerrarDiv(); 
            $css->Cfieldset();    
        $css->CerrarDiv();
      
    //$css->CerrarDiv();
    
    $css->Cdiv();
    print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
$css->PageFin();
print('<script src="../../componentes/shortcuts.js"></script>');  //script propio de la pagina
print('<script src="jsPages/pos.js"></script>');  //script propio de la pagina
print('<script src="jsPages/AcuerdoPago.js"></script>');  //script propio de la pagina
print('<script src="../../componentes/webcam/webcam.js"></script>');  //script para usar la web cam

$css->Cbody();
$css->Chtml();

?>