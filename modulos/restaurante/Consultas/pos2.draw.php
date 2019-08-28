<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/pos2.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new VentasRestaurantePOS($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar el formulario para crear un pedido en una mesa
            print("<h4><strong>Mesas Disponibles:<strong></h4><br>");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", "1", "", "", "", "");       
            $Consulta=$obCon->ConsultarTabla("restaurante_mesas", "WHERE Estado=0");
            
            while($DatosMesas=$obCon->FetchAssoc($Consulta)){
                $idMesa=$DatosMesas["ID"];
                $idBoton="BtnMesa_$idMesa";
                $js="onclick=CrearPedidoMesa(`$idMesa`)";
                $css->IconButton($idBoton,$idBoton,'fa fa-spoon',$DatosMesas["Nombre"],$js,$spanActivo=0,"orange",$style='style="background-color:#349cc2;color:white"');
                
            }
                        
        break; 
        case 2:// se dibuja el listado de pedidos
            
            $sql="SELECT rp.ID,rp.FechaCreacion,rp.Estado,rp.Fecha,rp.Hora,rp.idUsuario,rp.idMesa, CONCAT(us.Nombre,' ',us.Apellido) as NombreUsuario,rm.Nombre as NombreMesa"
                . " FROM restaurante_pedidos rp "
                . "INNER JOIN usuarios us ON us.idUsuarios=rp.idUsuario "
                . "INNER JOIN restaurante_mesas rm ON rm.ID=rp.idMesa"
                . " WHERE rp.idUsuario='$idUser' AND (rp.Estado<>'2' AND rp.Estado<>'7') AND rp.Tipo='1'";
            $Consulta=$obCon->Query($sql);
            if($obCon->NumRows($Consulta)){
                $css->CrearTitulo("<strong>Lista de Pedidos</strong>");
               
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>ID</strong>", 1,"C");
                        $css->ColTabla("<strong>Mesa</strong>", 1,"C");                        
                        $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                         
                        $css->ColTabla("<strong>Acciones</strong>", 1,"C");
                         
                        $css->ColTabla("<strong>Creado</strong>", 1,"C");
                        $css->ColTabla("<strong>Usuario</strong>", 1,"C");      
                    $css->CierraFilaTabla();
                
                while($DatosPedidos=$obCon->FetchAssoc($Consulta)){
                    $TiempoTranscurrido=$obCon->CalcularTiempoPedido($DatosPedidos["FechaCreacion"]);
                    $Estado=$DatosPedidos["Estado"];
                    $styles="";
                    if($TiempoTranscurrido>15 and $Estado==1){
                        $styles="style=background-color:#ffaeae;";
                        $MensajePedido="Solicitado hace: ".$TiempoTranscurrido." min.";
                    }
                    
                    if($TiempoTranscurrido<=15 and $Estado==1){
                        $styles="";
                        $MensajePedido="Solicitado hace: ".$TiempoTranscurrido." min.";
                    }
                    
                    if($Estado==3){
                        $styles="style=background-color:#f9ffd2;";
                        $MensajePedido="Re Abierto";
                    }
                    
                    if($Estado==4){
                        $styles="style=background-color:#a786ff;";
                        $MensajePedido="Preparado";
                    }
                    
                    if($Estado==5){
                        $styles="style=background-color:#c1c9bf;";
                        $MensajePedido="Enviado";
                    }
                    
                    if($Estado==6){
                        $styles="style=background-color:#88d675;";
                        $MensajePedido="Entregado";
                    }
                    $css->FilaTabla(16);
                        $idPedido=$DatosPedidos["ID"];
                        $css->ColTabla($DatosPedidos["ID"], 1,"C");
                        $css->ColTabla($DatosPedidos["NombreMesa"], 1,"C");
                        
                        print("<td $styles>");
                            print($MensajePedido);
                        print("</td>");
                        
                        
                        print("<td>");
                            $css->IconButton("btnAgregar", "btnAgregar", "fa fa-opencart", "Agregar Items", "onclick='DibujePedido($idPedido)'",$spanActivo=0,"orange",$style='style="background-color:#dbffae;color:red"');
                            $css->IconButton("btnPreparar", "btnPreparar", "fa fa-spoon", "Preparar", "onclick='DibujePreparacion($idPedido)'",$spanActivo=0,"orange",$style='style="background-color:#5792ff;color:white"');
                            $css->IconButton("btnEntregar", "btnEntregar", "fa fa-hand-paper-o", "Entregar", "onclick='EntregarPedido($idPedido)'",$spanActivo=0,"orange",$style='style="background-color:#84ffff;color:black"');
                            //$css->IconButton("btnEstados", "btnEstados", "fa fa-bullseye", "Ver Preparacion", "onclick='VerEstadoPreparacion($idPedido)'",$spanActivo=0,"orange",$style='style="background-color:#e0eff3;color:black"');
                            $css->IconButton("btnFacturar", "btnFacturar", "fa fa-credit-card", "Facturar", "onclick='AbrirOpcionesFacturacion(`$idPedido`)'",$spanActivo=0,"orange",$style='style="background-color:#ffffcd;color:black"');
                            $css->IconButton("btnCancelar", "btnCancelar", "fa fa-remove", "Eliminar", "onclick='AgregarItems($idPedido)'",$spanActivo=0,"orange",$style='style="background-color:#ffeaae;color:red"');
                        print("</td>");
                        
                        
                        $css->ColTabla($DatosPedidos["Fecha"]." ".$DatosPedidos["Hora"], 1,"C");
                        $css->ColTabla($DatosPedidos["NombreUsuario"], 1,"C");
                    $css->CierraFilaTabla();
                }
                $css->CerrarTabla();
            }else{
                $css->CrearTitulo("<strong>No hay pedidos</strong>",'rojo');
            }
            
        break;  
        
        case 3://Dibuje el titulo de un pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            $TipoPedido="";
            if($DatosPedido["Tipo"]==1){
                $Titulo="<strong>PEDIDO PARA LA MESA ".$DatosPedido["idMesa"]."</strong>";
            }
            $css->CrearTitulo($Titulo,'azul');
            //$css->IconButton("btnAgregarItems", "btnAgregarItems", "fa fa-opencart", "Agregar Items", "onclick='MuestraOcultaXID(`DivAgregarItem`)'",$spanActivo=0,"orange",$style='style="background-color:#92ff71;color:black"');
            
            $css->IconButton("btnPrintPedido", "btnPrintPedido", "fa fa-print", "Imprimir Pedido", "onclick='ImprimirPedido(`$idPedido`)'",$spanActivo=0,"orange",$style='style="background-color:#ffcde5;color:black"');
            
            $css->IconButton("btnAgregarItems", "btnAgregarItems", "fa fa-print", "Imprimir Precuenta", "onclick='ImprimirPrecuenta(`$idPedido`)'",$spanActivo=0,"orange",$style='style="background-color:#cdd8ff;color:black"');
            
            $css->IconButton("btnAgregarItems", "btnAgregarItems", "fa fa-credit-card", "Facturar", "onclick='AbrirOpcionesFacturacion(`$idPedido`)'",$spanActivo=0,"orange",$style='style="background-color:#ffffcd;color:black"');
        break;// fin caso 3
        
        case 4://Dibuje los departamentos            
            
            $Consulta=$obCon->ConsultarTabla("prod_departamentos", "");
            while($DatosDepartamento=$obCon->FetchAssoc($Consulta)){
                $idDepartamento=$DatosDepartamento["idDepartamentos"];
               // $css->CrearBotonEvento("BtnDepartamento", $DatosDepartamento["Nombre"], 1, "onclick", "MostrarProductos(`$idDepartamento`)", "verde", "");
                $css->IconButton("btnAgregarDepartamento", "btnAgregarDepartamento", "fa fa-institution", $DatosDepartamento["Nombre"], "onclick='MostrarProductos($idDepartamento)'",$spanActivo=0,"orange",$style='style="background-color:#aed0ff;color:black"');
                //print("<br><br>");
                
            }
        break;// fin caso 4

        
        case 5: //Dibuja los productos de un departamento
            $Condicion=" LIMIT 100";
            if(isset($_REQUEST["idDepartamento"])){
                $idDepartamento=$obCon->normalizar($_REQUEST["idDepartamento"]);
                $Condicion="WHERE Departamento='$idDepartamento' ORDER BY Nombre ASC LIMIT 1000";
            }
            
            if(isset($_REQUEST["Busqueda"])){
                $key=$obCon->normalizar($_REQUEST["Busqueda"]);
                $Condicion="WHERE Nombre like '$key%' or idProductosVenta='$key' or Referencia='$key' LIMIT 100";
            }
            
            
            $Consulta=$obCon->ConsultarTabla("productosventa", $Condicion);
            $css->select("idProducto", "form-control", "idProducto", "", "", "", "");
            while($DatosProducto=$obCon->FetchAssoc($Consulta)){
                $idProducto=$DatosProducto["idProductosVenta"]; 
                $css->option("", "", "", $idProducto, "", "");
                    print($DatosProducto["Nombre"]." // ".number_format($DatosProducto["PrecioVenta"]));
                $css->Coption();
                //$css->IconButton("btnAgregarProducto", "btnAgregarProducto", "fa  fa-hand-o-right", utf8_encode($DatosProducto["Nombre"])." $<strong>". number_format($DatosProducto["PrecioVenta"])."</strong>", "onclick='AgregarProducto($idProducto)'",$spanActivo=0,"orange",$style='style="background-color:#edeceb;color:black"');
                
            }
            $css->Cselect();
            
            break;//Fin caso 5
            
        case 6: //Dibuje los items del pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $sql="SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido' ORDER BY ID Desc";
            $Consulta=$obCon->Query($sql);
            if($obCon->NumRows($Consulta)){
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Nombre</strong>", 1);
                        $css->ColTabla("<strong>Total</strong>", 1);
                        $css->ColTabla("<strong>Acciones</strong>", 1);
                    $css->CierraFilaTabla();
                    while($DatosItems=$obCon->FetchAssoc($Consulta)){
                        $idItem=$DatosItems["ID"];
                        $Estado=$DatosItems["Estado"];
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosItems["Cantidad"], 1);
                            $Observaciones="";
                            if ($DatosItems["Observaciones"]<>""){
                                $Observaciones="<br>Observaciones: ".$DatosItems["Observaciones"];
                            }
                            $css->ColTabla($DatosItems["NombreProducto"].$Observaciones, 1);
                            $css->ColTabla(number_format($DatosItems["Total"]), 1,'R');
                            print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");
                                if($Estado=='AB'){
                                    $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`1`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                                    $css->Cli();
                                }
                            print("</td>");
                        $css->CierraFilaTabla();
                    }
                $css->CerrarTabla();
            }else{
                $css->CrearTitulo("No hay Items en este pedido","rojo");
            }
        break;     //Fin caso 6
        
        case 7://Muestro el total del pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            
            $Total=$obCon->SumeColumna("restaurante_pedidos_items", "Total", "idPedido", $idPedido);
            
            print("$idPedido, por un Total de: $". number_format($Total));
            
        break; 
    
        case 8://Dibujo el formulario para registrar la factura
            $ConsultaCajas=$obCon->ConsultarTabla("cajas", "WHERE idUsuario='$idUser' AND Estado='ABIERTA'");
            $DatosCaja=$obCon->FetchArray($ConsultaCajas);

            if($DatosCaja["ID"]<=0){
               $css->CrearTitulo("No tiene asignada una Caja, por favor Asignese a una Caja, <a href='HabilitarUser.php' target='_blank'>Vamos</a>", "rojo");
               exit();
            }  

        //Tipo pedido AB= pedidos abiertos, DO=Domicilios abieros, LL=para llevar Abiertos
        $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
        if($idPedido==''){
            $css->CrearTitulo("<strong>Debes Seleccionar un pedido</strong>", "rojo");
            exit();
        }
        $sql="SELECT SUM(Subtotal) as Subtotal,SUM(IVA) AS IVA, SUM(Total) AS Total FROM restaurante_pedidos_items WHERE idPedido='$idPedido'";
        $Datos=$obCon->Query($sql);
        $Totales=$obCon->FetchAssoc($Datos);
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Facturar Pedido $idPedido</strong>", 3);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Subtotal</strong>", 1);
                $css->ColTabla("<strong>Impuestos</strong>", 1);
                $css->ColTabla("<strong>Total</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla(number_format($Totales["Subtotal"]), 1);
                $css->ColTabla(number_format($Totales["IVA"]), 1);
                $css->ColTabla(number_format($Totales["Total"]), 1);
            $css->CierraFilaTabla();


            $css->FilaTabla(16);
                print("<td colspan=3 style='text-align:center'>");
                    $css->ImageOcultarMostrar("ImgOcultar", "", "DivOpcionesPago", 40, 40, "");
                    $css->CrearDiv("DivOpcionesPago", "", "center", 0, 1);
                        $css->CrearSelect("idCliente", "",300);
                            $css->CrearOptionSelect(1, "Clientes Varios", 1);
                        $css->CerrarSelect();
                        //$css->CrearTableChosen("idCliente", "clientes", "", "RazonSocial", "Num_Identificacion", "Telefono", "idClientes", 200, 0, "Clientes", "Clientes<br>");
                        print("<br>");
                        $css->CrearInputNumber("TxtTarjetas", "number", "Tarjetas:<br>", 0, "Tarjetas", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 50, 0, 0, 0, "", 1);
                        print("<br>");
                        $css->CrearInputNumber("TxtCheques", "number", "Cheques:<br>", 0, "Tarjetas", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 50, 0, 0, 0, "", 1);
                        print("<br>");
                        $css->CrearInputNumber("TxtBonos", "number", "Bonos:<br>", 0, "Tarjetas", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 50, 0, 0, 0, "", 1);
                        print("<br><strong>Tipo de Factura:</strong><br>");
                        $css->CrearSelect("CmbTipoPago","");
                            $consulta=$obCon->ConsultarTabla("facturas_tipo_pago", "");
                            while ($DatosTipoPago=$obCon->FetchArray($consulta)){
                                $sel=0;
                                if($DatosTipoPago["TipoPago"]=="Contado"){
                                    $sel=1;
                                }
                                $css->CrearOptionSelect($DatosTipoPago["TipoPago"], $DatosTipoPago["Leyenda"], $sel);
                            }
                        $css->CerrarSelect();
                        print("<br><strong>Asignar a:</strong><br>");
                        $css->CrearSelect("CmbColaboradores","");
                            $css->CrearOptionSelect("", "Colaborador", 0);
                            $consulta=$obCon->ConsultarTabla("colaboradores", " WHERE Activo='A'");
                            while ($DatosTipoPago=$obCon->FetchArray($consulta)){
                                $css->CrearOptionSelect($DatosTipoPago["idColaboradores"], $DatosTipoPago["Nombre"], 0);
                            }
                        $css->CerrarSelect();

                        print("<br>");
                        $css->CrearInputNumber("TxtPropinaEfectivo", "number", "Propina Efectivo:<br>", 0, "P Efectivo", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 50, 0, 0, 0, "", 1);
                        print("<br>");
                        $css->CrearInputNumber("TxtPropinaTarjetas", "number", "Propina Tarjetas:<br>", 0, "P Tarjeta", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 50, 0, 0, 0, "", 1);
                        print("<br>");
                        $css->CrearTextArea("TxtObservacionesFactura", "", "", "Observaciones", "", "", "", 200, 80, 0, 0);
                    $css->CerrarDiv();
                print("</td>");
            $css->CierraFilaTabla();      
            $css->FilaTabla(16);
                print("<td colspan=3 style='text-align:center'>");
                    $css->CrearDiv("", "", "center", 1, 1);
                        $css->CrearInputNumber("TxtEfectivo", "number", "Efectivo:",$Totales["Total"] , "Efectivo", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 60, 0, 1, 1, "", 1,"font-size:2em;");
                        $css->CrearInputNumber("GranTotalPropinas", "hidden", "<br>Devuelta:",0 , "Efectivo", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 60, 0, 1, 1, "", 1,"font-size:2em;");
                    $css->CerrarDiv();
                print("</td>");
            $css->CierraFilaTabla();   


            $css->FilaTabla(16);
                print("<td colspan=3 style='text-align:center'>");
                    $css->CrearDiv("", "", "center", 1, 1);
                    $css->CrearInputNumber("TxtDevuelta", "number", "",0 , "Devuelta", "", "", "", 200, 60, 0, 1, 1, "", 1,"font-size:2em;");
                    $css->CerrarDiv();
                print("</td>");
            $css->CierraFilaTabla();  
            $css->FilaTabla(16); 

                print("<td colspan=3 style='text-align:center'>");
                    $evento="onClick";
                    $funcion="FacturarPedido($idPedido);";

                    $css->CrearBotonEvento("BtnFacturarPedido", "Facturar", 1, $evento, $funcion, "naranja", "");
            print("</td>");
            $css->CierraFilaTabla();  
            $css->CerrarTabla();
            
        break; //Fin caso 8
        
        case 9: //Dibuje los items para realizar la preparacion
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido==''){
                $css->CrearTitulo("<strong>Debe seleccionar un pedido</strong>", "rojo");
                exit();
            }
            $sql="SELECT rp.ID,rp.FechaCreacion,rp.Fecha,rp.Hora,rp.idUsuario, CONCAT(us.Nombre,' ',us.Apellido) as NombreUsuario "
                . " FROM restaurante_pedidos rp "
                . "INNER JOIN usuarios us ON us.idUsuarios=rp.idUsuario "
                
                . " WHERE rp.idUsuario='$idUser' AND rp.Estado='1' ";
            $Consulta=$obCon->Query($sql);
            $DatosPedido=$obCon->FetchAssoc($Consulta);
            $css->CrearTitulo("<strong>Items a Preparar para el Pedido $idPedido, Realizado por: $DatosPedido[NombreUsuario] </strong>", "azul");
            $sql="SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido' ORDER BY ID Desc";
            $Consulta=$obCon->Query($sql);
            if($obCon->NumRows($Consulta)){
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Nombre</strong>", 1);
                        $css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Acciones</strong>", 1);
                    $css->CierraFilaTabla();
                    while($DatosItems=$obCon->FetchAssoc($Consulta)){
                        $idItem=$DatosItems["ID"];
                        $Estado=$DatosItems["Estado"];
                        if($Estado=="AB"){
                            $css->FilaTabla(16);
                        }else{
                            print("<tr style='background-color:#d2ffd3'>");
                        }
                        
                            
                            $Observaciones="";
                            if ($DatosItems["Observaciones"]<>""){
                                $Observaciones="<br>Observaciones: ".$DatosItems["Observaciones"];
                            }
                            $css->ColTabla($DatosItems["NombreProducto"].$Observaciones, 1);
                            $css->ColTabla($DatosItems["Cantidad"], 1);
                            
                            
                            print("<td style='font-size:16px;text-align:center;color:red' title='Preparar'>");
                                if($Estado=='AB'){
                                    $css->IconButton("BtnCambiarEstadoItem","BtnCambiarEstadoItem",'fa fa-check',"Marcar Como Preparado","onclick='CambiarEstadoAPreparado(`PR`,`$idItem`)'",$spanActivo=0,"orange",$style='style="background-color:#d9f2ff;color:black"');
                                }else{
                                    $css->CrearTitulo("<strong>Item Preparado</strong>", "verde");
                                }
                            print("</td>");
                        $css->CierraFilaTabla();
                    }
                $css->CerrarTabla();
            }else{
                $css->CrearTitulo("No hay Items en este pedido","rojo");
            }
        break;     //Fin caso 9
        
        case 10: //dibujar el formulario para cerrar el turno
            print("<h4><strong>Cerrar este turno:<strong></h4><br>");
            $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "Observaciones", "Observaciones", "", "");
            $css->Ctextarea();
            $css->CrearBotonEvento("BtnConfirmaCerrarTurno", "Cerrar Turno", 1, "onclick", "ConfirmaCerrarTurno()", "rojo", "");
                        
        break; //Fin Caso 10
    
        case 11://Formulario para Crear un egreso
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 3, "", "", "", ""); //3 sirve para indicarle al sistema que debe guardar el formulario de crear un egreso
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Tipo de Egreso</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    
                    $css->ColTabla("<strong>Número de Soporte</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td>");
                        $css->select("TipoEgreso", "form-control", "TipoEgreso", "", "", "", "style=width:300px");
                        $Consulta=$obCon->ConsultarTabla("subcuentas", " WHERE (PUC LIKE '5135%' or PUC LIKE '5105%' or PUC LIKE '5195%') AND LENGTH(PUC)>4 ");
                        while($DatosCuenta=$obCon->FetchAssoc($Consulta)){
                                                       
                            $css->option("", "", "", $DatosCuenta["PUC"], "", "", 0);
                                print($DatosCuenta["PUC"]." ".$DatosCuenta["Nombre"]);
                            $css->Coption();
                        }    
                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->select("CmbTerceroEgreso", "form-control", "CmbTerceroEgreso", "", "", "", "style=width:300px");
                            $css->option("", "", "", "", "", "");
                                print("Seleccione un tercero");
                            $css->Coption();
                        $css->Cselect();
                    print("</td>");
                    
                    
                    print("<td>");
                        $css->input("text", "TxtNumeroSoporteEgreso", "form-control", "TxtNumeroSoporteEgreso", "", "", "Número de Soporte", "off", "", "");
                    print("</td>");
                    
                    
                $css->CierraFilaTabla();
                                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Concepto</strong>", 2);
                    $css->ColTabla("<strong>Valor</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td colspan=2>");
                        $css->textarea("TxtConcepto", "form-control", "TxtConcepto", "Concepto", "Concepto", "", "");
                        $css->Ctextarea();
                    print("</td>");
                    
                    print("<td>");
                        $css->input("number", "SubtotalEgreso", "form-control", "SubtotalEgreso", "SubtotalEgreso", "", "Subtotal", "off", "", "", "onkeyup=CalculeTotalEgreso()");                    
                        $css->input("number", "IVAEgreso", "form-control", "IVAEgreso", "IVAEgreso", 0, "IVA", "off", "", "", "onkeyup=CalculeTotalEgreso()");
                        $css->input("number", "TotalEgreso", "form-control", "TotalEgreso", "TotalEgreso", "", "Total", "off", "", "", "","disabled");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
            $css->CerrarTabla();
        break;//Fin caso 11    
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>