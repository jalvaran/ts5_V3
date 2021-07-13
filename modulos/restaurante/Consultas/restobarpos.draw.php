<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../clases/restaurantPos.class.php");
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
                        
        break; //Fin caso 1
        
        case 2: //Dibuja la informacion general de un pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $sql="SELECT t1.*, 
                   (SELECT Nombre FROM restaurante_tipos_pedido t2 WHERE t1.Tipo=t2.ID LIMIT 1) as NombreTipoPedido,
                   (SELECT Nombre FROM restaurante_mesas t3 WHERE t1.idMesa=t3.ID LIMIT 1) as NombreMesa
                   FROM restaurante_pedidos t1 WHERE ID='$idPedido'";
            $DatosPedido=$obCon->FetchAssoc($obCon->Query($sql));
            
            if($DatosPedido["Tipo"]==1){
                print('<div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-renren"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-number">Pedido No: '.$idPedido.'</span>
                          <span class="info-box-number">'.$DatosPedido["NombreMesa"].'</span>                      
                        </div>                   
                      </div>
                ');
            }
            
            if($DatosPedido["Tipo"]<>1){
                print('<div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-renren"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-number">Pedido No: '.$idPedido.'</span>
                          <span class="info-box-number">'.$DatosPedido["NombreCliente"].'</span>                      
                        </div>                   
                      </div>
                ');
            }
            
        break;//Fin caso 2    
        
        case 3://Dibuja los items de un pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido==0 or $idPedido==''){
                $css->CrearTitulo("Esperando pedido", "rojo");
                exit();
            }
            $sql="SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido' ORDER BY ID DESC";
            $Consulta=$obCon->Query($sql);
            
            print('<table class="table table-responsive">');
            
                $css->FilaTabla(16);
                    //$css->ColTabla("<strong>ID</strong>", 1, "C");
                    $css->ColTabla("<strong>Producto</strong>", 1, "C");
                    $css->ColTabla("<strong>Cantidad</strong>", 1, "C");
                    $css->ColTabla("<strong>Total</strong>", 1, "C");
                    $css->ColTabla("<strong>Eliminar</strong>", 1, "C");
                $css->CierraFilaTabla();
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosPedido["ID"];
                $Descripcion= utf8_encode($DatosPedido["NombreProducto"]);
                if($DatosPedido["Observaciones"]<>''){
                    $Descripcion.="<br><strong>".utf8_encode($DatosPedido["Observaciones"])."</strong>";
                }
                print('<tr>');
                    //$css->ColTabla($DatosPedido["idProducto"], 1);
                    print('<td >');
                        print($Descripcion);
                    print('</td>');
                    print('<td style="text-align:center">');
                        print('<div class="btn-group-vertical"  >
                                    <button onclick="editar_cantidad(`'.$idItem.'`,`1`);"  type="button" class="btn bg-purple " onclick="frm_cambiar_cantidad(`'.$idItem.'`);" style="cursor:pointer;text-align:center;"><li class="fa fa-sort-up"></li></button>
                                        <span class="text-lg"><strong><span id=sp_cantidad_'.$idItem.'>'.$DatosPedido["Cantidad"].'</strong></span></span>
                                    <button onclick="editar_cantidad(`'.$idItem.'`,`2`);"  type="button" class="btn bg-purple " onclick="frm_cambiar_cantidad(`'.$idItem.'`);" style="cursor:pointer;text-align:center;"><li class="fa fa-sort-desc"></li></button>    
                                    
                                  </div>');
                    //print($DatosPedido["Cantidad"]);
                    print('</td>');
                    
                    print('<td style="text-align:right">');
                        print("<strong><span id=sp_total_".$idItem.">".number_format($DatosPedido["Total"])."</span></strong>");
                    print('</td>');
                    
                    
                    print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>"); 
                        $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                        $css->Cli();
                    print("</td>");                    
                $css->CierraFilaTabla();
            }
            
            $css->CerrarTabla();
        break;//Fin caso 3  
        
        case 4://Dibujo los totales del pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido==0 or $idPedido==''){
                $css->CrearTitulo("Esperando pedido", "rojo");
                exit();
            }
            $sql="SELECT SUM(Cantidad) as Items,SUM(Subtotal) as Subtotal,SUM(IVA) as IVA,SUM(Total) as Total 
                    FROM restaurante_pedidos_items WHERE idPedido='$idPedido' ";
            $DatosTotales=$obCon->FetchAssoc($obCon->Query($sql));
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>TOTALES</strong>", 3, "C");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ITEMS</strong>", 2, "L");
                    $css->ColTabla($DatosTotales["Items"], 1, "R");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>SUBTOTAL</strong>", 2, "L");
                    $css->ColTabla(number_format($DatosTotales["Subtotal"]), 1, "R");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>IMPUESTOS</strong>", 2, "L");
                    $css->ColTabla(number_format($DatosTotales["IVA"]), 1, "R");
                $css->CierraFilaTabla();
                $css->FilaTabla(24);
                    $css->ColTabla("<strong>TOTAL</strong>", 2, "L");
                    $css->ColTabla("<strong>".number_format($DatosTotales["Total"])."</strong>", 1, "R");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>OPCIONES</strong>", 3, "C");                    
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print('<span class="input-group-btn">
                            <button type="button" id="BtnImprimePedido" class="btn btn-success btn-flat" onclick=ImprimirPedido(`'.$idPedido.'`) title="Imprimir Pedido" style="font-size:30px;"><i class="fa fa-print"></i></button>
                          </span>');
                    print("</td>");
                    print("<td style='text-align:center'> ");
                        print('<span class="input-group-btn">
                            <button type="button" id="BtnImprimePrecuenta" class="btn btn-warning btn-flat" onclick=ImprimirPrecuenta(`'.$idPedido.'`) title="Imprimir Precuenta" style="font-size:30px;"><i class="fa fa-credit-card"></i></button>
                          </span>');
                    print("</td>"); 
                    print("<td style='text-align:center'>");
                        if($TipoUser=="administrador"){
                            print('<span class="input-group-btn">
                                <button type="button" id="BtnImprimePedido" class="btn btn-danger btn-flat" onclick=AbrirOpcionesFacturacion(`'.$idPedido.'`) title="Facturar" style="font-size:30px;"><i class="fa fa-money"></i></button>
                              </span>');
                        }
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
        break;//fin caso 4    
        
        case 5://Dibujo el formulario para registrar la factura
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
        $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
        
        $ObservacionesFactura="";
        if($DatosPedido["Tipo"]>1){
            $ObservacionesFactura="Domicilio para: ".$DatosPedido["NombreCliente"]." || ".$DatosPedido["TelefonoConfirmacion"]." || ".$DatosPedido["DireccionEnvio"];
        }
        
        print('<div id="DivMensajes">');
        
        print('</div>');
        
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
                        //print("Observaciones: $ObservacionesFactura");
                        $css->CrearTextArea("TxtObservacionesFactura", "", $ObservacionesFactura, "Observaciones", "", "", "", 200, 80, 0, 0);
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
            
        break; //Fin caso 5
        
        case 6://Dibuja el listado de pedidos
            $TipoPedido=$obCon->normalizar($_REQUEST["TipoPedido"]);
            $sql="SELECT t1.*,
                    (SELECT t2.Nombre FROM restaurante_mesas t2 WHERE t1.idMesa=t2.ID) as NombreMesa,
                    (SELECT t5.NombreEstado FROM restaurante_estados_pedidos t5 WHERE t1.Estado=t5.ID) as NombreEstado,
                    (SELECT CONCAT(Nombre, ' ', Apellido) FROM usuarios t3 WHERE t1.idUsuario=t3.idUsuarios) as NombreUsuario,
                    (SELECT SUM(Total) FROM restaurante_pedidos_items t4 WHERE t4.idPedido=t1.ID) as TotalPedido
                    FROM restaurante_pedidos t1 WHERE Tipo='$TipoPedido' AND (Estado<>2 AND Estado<>7 ) ORDER BY idMesa,ID ASC; ";
            $Consulta=$obCon->Query($sql);
            $datos_pedido=$obCon->DevuelveValores("restaurante_tipos_pedido", "ID", $TipoPedido);
            print('<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Pedidos '.$datos_pedido["Nombre"].'</h3>

                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      
                    </div>
                  </div>
                  <!-- /.box-tools -->
                </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                
                <div class="btn-group">
                    <a title="Nuevo" onclick="FormularioCrearPedido()" class="btn btn-social-icon btn-github btn-lg"><i class="fa fa-plus"></i></a>
                    
                </div>
                
                <div class="pull-right">
                <!--
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  -->
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table mailbox-messages">
                <table class="table table-responsive table-hover table-striped">
                  <tbody>');
            
                  
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                
                $idPedido=$DatosPedido["ID"];
                $bg="blue";
                $InfoAdicional="";
                $EntregaTardia=0;
                if($TipoPedido==1){//Si es un pedido de mesa
                    $Titulo=$DatosPedido["NombreMesa"];
                    $NombreUsuario=$DatosPedido["NombreUsuario"];
                }
                
                if($TipoPedido==2){//Si es un domicilio
                    $bg="purple";
                    $Titulo=$DatosPedido["NombreCliente"];
                    $NombreUsuario=$DatosPedido["DireccionEnvio"]." || ".$DatosPedido["TelefonoConfirmacion"]." || ".$DatosPedido["Observaciones"];
                }
                
                if($TipoPedido==3){//Si es para llevar
                    $bg="red";
                    $Titulo=$DatosPedido["NombreCliente"];
                    $NombreUsuario=$DatosPedido["DireccionEnvio"];
                }
                if($DatosPedido["Estado"]==1){//Estado abierto o reabierto se mostrará el tiempo que lleva 
                    
                    $FechaCreacion=$DatosPedido["FechaCreacion"];
                    $TiempoTranscurrido=$obCon->CalcularTiempoPedido($FechaCreacion);
                    $InfoAdicional="$TiempoTranscurrido min atrás";
                    if($TiempoTranscurrido>14){
                        $EntregaTardia=1;
                    }
                }
                if($EntregaTardia==1){
                        $InfoAdicional=('                       
                        <div style="color:red">
                         <li class="fa fa-clock-o"> Entrega Tardía
                          </li>
                        </div>
                        ');
                    }
                
                if($DatosPedido["Estado"]==6){//Estado entregado
                    $bg="green";
                }
                
                if($DatosPedido["Estado"]==4){//Estado preparado
                    $bg="orange";
                }
                print('<tr >
                    <td >
                        <div class="btn-group">
                            <a title="Precuenta" onclick="ImprimirPrecuenta(`'.$idPedido.'`)" class="btn btn-flat bg-orange margin"><i class="fa fa-credit-card"></i></a>
                            <a title="Pedido" onclick="ImprimirPedido(`'.$idPedido.'`)" class="btn bg-purple btn-flat margin"><i class="fa fa-print"></i></a>
                            <a title="Entregar" onclick="EntregarPedido(`'.$idPedido.'`)" class="btn bg-olive btn-flat margin"><i class="fa fa-hand-paper-o"></i></a>');
                if($TipoUser=="administrador"){
                    print('<a title="Anular" onclick="AnularPedido(`'.$idPedido.'`)" class="btn bg-maroon btn-flat margin"><i class="fa fa-remove"></i></a>');
                }
                print('    </div>
                    </td>
                    <td onclick="idPedidoActivo='.$idPedido.'; DibujePedidoActivo();" style="cursor:pointer" class="mailbox-star"><a onclick="idPedidoActivo='.$idPedido.'; DibujePedidoActivo();"><i class="fa fa-star text-'.$bg.' "></i> <strong>'.$idPedido.'</strong></a></td>
                    <td onclick="idPedidoActivo='.$idPedido.'; DibujePedidoActivo();" style="cursor:pointer" class="mailbox-name"><a onclick="idPedidoActivo='.$idPedido.'; DibujePedidoActivo();">'.$Titulo.'</a></td>
                    <td onclick="idPedidoActivo='.$idPedido.'; DibujePedidoActivo();" style="cursor:pointer" class="mailbox-subject" onclick="idPedidoActivo='.$idPedido.'; DibujePedidoActivo();"><b>'.$NombreUsuario.' </b>
                    </td>
                    <td onclick="idPedidoActivo='.$idPedido.'; DibujePedidoActivo();" style="cursor:pointer" class="mailbox-attachment">'.substr($DatosPedido["NombreEstado"],0,3).'</td>
                    <td onclick="idPedidoActivo='.$idPedido.'; DibujePedidoActivo();" style="cursor:pointer"  class="mailbox-date">'.$InfoAdicional.'</td>
                  </tr>');
                
                //print('<tr><td colspan="6"> </td></tr>');
            }
            
            
            
            print('      </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
          </div>');
        break;//Fin caso 6   
        
        case 7://Dibuja el formulario para crear un domicilio
            $TipoPedido=$obCon->normalizar($_REQUEST["TipoPedido"]);
            
            if($TipoPedido==2){
                $Color="azul";
                $Titulo="Nuevo Domicilio";
            }
            if($TipoPedido==3){
                $Color="verde";
                $Titulo="Nuevo Pedido para Llevar";
            }
            $css->CrearTitulo($Titulo, $Color);
            $css->input("hidden", "idFormulario", "form-control", "idFormulario", "1", "1", "idFormulario", "off", "", "onkeyup=AutocompleteDatos()");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        $css->input("text", "TelefonoPedido", "form-control", "Telefono", "", "", "Telefono", "off", "", "onkeyup=AutocompleteDatos()");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "NombrePedido", "form-control", "Nombre", "", "", "Nombre", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "DireccionPedido", "form-control", "Direccion", "", "", "Direccion", "off", "", "");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                    print("<td colspan=3>");
                        $css->textarea("ObservacionesPedido", "form-control", "TxtObservaciones", "", "Observaciones", "", "");
                        
                        $css->Ctextarea();
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        break;//fin caso 7    
           
        case 8:// dibuja el formulario para cerrar turno
            $sql="SELECT COUNT(ID) AS Items FROM restaurante_pedidos WHERE Estado<>2 AND Estado<>7 AND idCierre=0 ";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            if($Totales["Items"]>0){
                $css->CrearTitulo("<strong>No es posible cerrar el turno, hay pedidos que aún no se han facturado</strong>", "rojo");
                exit();
            }
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 2, "", "off", "", "");
            print('<div class="row">');
            
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    $css->CrearTitulo("<strong>Cerrar Turno</strong>", "verde");
                    $css->input("number", "EfectivoEnCaja", "form-control input-number", "EfectivoEnCaja", "", "", "Efectivo en Caja", "off", "", "style=width:250px;");
                    print("<br>");
                    $css->textarea("ObservacionesCierre", "form-control", "ObservacionesCierre", "", "Observaciones", "", "style=width:250px;");

                    $css->Ctextarea();
                $css->CerrarDiv();
            $css->CerrarDiv();
            
            print('<div class="row">');
                $css->CrearDiv("div_mensajes_frm_cerrar_turno", "col-md-12", "center", 1, 1);
                
                $css->CerrarDiv();
            $css->CerrarDiv();
            
        break;// fin caso 8    
        
        case 9:// dibuja el formulario para agregar complementos a un producto
            $idProducto=$obCon->normalizar($_REQUEST["Codigo"]);
            //$idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            //$css->CrearTitulo("Por favor elija una opción en cada una de las pestañas");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 3, "", "", "", "");
            $diaSemana=date("N");
            $arrayDiaSemana=array("","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
            $Mensaje="Menú disponible para los días <strong>".$arrayDiaSemana[$diaSemana]."</strong>";
            $css->CrearTitulo($Mensaje);
            print('<form id="frm_complementos">');
               
                print('<div class="row">');
                    print('<div class="col-md-9">');    
                        print('<div class="nav-tabs-custom">');
                            print('<ul class="nav nav-tabs pull-right">');

                                $sql="SELECT * FROM productosventa_complementos ORDER BY ID DESC";
                                $Consulta=$obCon->Query($sql);

                                while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                                    $id=$DatosConsulta["ID"];
                                    $Complementos[$id]["ID"]=$DatosConsulta["ID"];
                                    
                                    $expan="false";
                                    $classli="";
                                    if($id==1){

                                        $expan="true";
                                        $classli="active";
                                    }
                                    print('<li class="'.$classli.'"><a href="#tab_'.$id.'" data-toggle="tab" aria-expanded="'.$expan.'">'.$DatosConsulta["Nombre"].'</a></li>');
                                }
                                print('<li class="pull-left header"><i class="fa fa-spoon"></i> Complementos </li>');
                            print('</ul>');

                            $sql="SELECT * FROM productosventa_complementos_items WHERE Estado=1 AND (dia_semana_id='$diaSemana' or dia_semana_id='0' )";
                            $Consulta=$obCon->Query($sql);
                            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                                $idComplemento=$DatosConsulta["complemento_id"];
                                $ID=$DatosConsulta["ID"];                         
                                $ComplementosItems[$idComplemento][$ID]["ID"]=$DatosConsulta["ID"];
                                $ComplementosItems[$idComplemento][$ID]["Nombre"]=$DatosConsulta["Nombre"];
                                $ComplementosItems[$idComplemento][$ID]["url_imagen"]=$DatosConsulta["url_imagen"];
                            }
                            //print_r($ComplementosItems);
                            print('<div class="tab-content">');

                                foreach ($Complementos as $key => $value) {

                                    $classli="";
                                    if($key==1){

                                        $classli="active";
                                    }
                                    print('<div class="tab-pane '.$classli.'" id="tab_'.$key.'">');
                                        $css->CrearTabla();
                                            $css->FilaTabla(16);
                                                $css->ColTabla("Agregar", 1);
                                                $css->ColTabla("Item", 1);
                                                                               
                                            $css->CierraFilaTabla();

                                            foreach ($ComplementosItems[$key] as $keyComplementoItem => $valueComplementoItem) {
                                                $complementoitem_id=$valueComplementoItem["ID"];
                                                $image_url=$valueComplementoItem["url_imagen"];
                                                print('<tr onclick="cambie_option_complemento(`rd_'.$complementoitem_id.'`);" style="cursor:pointer;">');
                                                    
                                                    print('<td style="text-align:center;font-size:30px;">');
                                                
                                                        print('<input style="-ms-transform: scale(1.5);-webkit-transform: scale(1.5);transform: scale(1.5);" type="radio" id="rd_'.$complementoitem_id.'" name="rd_'.$key.'" value="'.$complementoitem_id.'">');
                                                        
                                                    print('</td>');
                                                    print('<td style="text-align:left;">');
                                                        print('<div class="info-box" >
                                                                <span class="info-box-icon bg-navy " "><i class="fa fa-star-half-full "></i></span>
                                                                <div class="info-box-content">
                                                                  <span class="info-box-number" style="font-size:14px;">'.$valueComplementoItem["Nombre"].'<div class="pull-right"></div></span>
                                                                  
                                                                  
                                                                </div>  
                                                            </div>');
                                                    print('</td>');
                                                                                       
                                                $css->CierraFilaTabla();
                                            }

                                        $css->CerrarTabla();
                                    print('</div>');
                                }


                            print('</div>');
                        print('</div>');
                    print('</div>');
                print('</div>');
            print('</form>');            
        break;// fin caso 9
        
        case 10://Dibuje el area para agregar los items a un pedido
            print('<div class="col-md-8">');
                print('<div class="row">');
                    print('<div class="col-md-6">');
                        print('<div  class="input-group input-group-md">');
                            print('<div id="div_select_items" >');
                                $css->select("Codigo", "form-control", "Codigo", "", "", "", 'style="width:300px;"');
                                    $css->option("", "", "", "", "", "");
                                        print("Seleccione un producto");
                                    $css->Cselect();
                                $css->Cselect();
                            print('</div>');
                            print('<span class="input-group-btn">
                                    <button id="btn_change_input_items" type="button" class="btn btn-danger btn-flat" data-id="1" onclick="change_input_item_search()"><i class="fa fa-barcode"></i></button>
                                  </span>');
                        print('</div>');    
                    print('</div>'); 
                    
                    print('<div class="col-md-4">');
                        print('<textarea style="font-size:14px;" rows="1" id="Observaciones" class="form-control" placeholder="Observaciones"></textarea>');
                        
                    print('</div>');
                    print('<div class="col-md-2">');
                        $css->CrearBotonEvento("BtnAgregarItem", "Agregar", 1, "onclick", "AgregarItem()", "naranja");
                    print('</div>');
                print('</div>');
                print("<br>");
                print('<div class="row">');
                    print('<div class="col-md-12">');
                        print('<div id="div_form_add_items">');
                    
                        print('</div>');
                    print('</div>');
                print('</div>');
            print('</div>');
            
            print('<div class="col-md-4">');
                print('<div class="col-md-12">');
                    print('<div class="row">');
                        print('<div id="DivInfoPedidoActivo">');

                        print('</div>');
                    print('</div>');
                    print('<div class="row">');
                        print('<div id="DivItems">');

                        print('</div>');
                    print('</div>');
                    print('<div class="row">');
                        print('<div id="DivTotalesPedido">');

                        print('</div>');
                    print('</div>');
                print('</div>');
            print('</div>');
        break;//Fin caso 10    
        
        case 11:// Dibuje los productos favoritos
            
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            
            if($idPedido==''){
                $css->CrearTitulo("No se recibió un pedido");
                exit();
            }
            print('<div class="row">');
            $sql="SELECT t1.ID,t1.producto_id, 
                    (SELECT Referencia FROM productosventa t2 WHERE t2.idProductosVenta=t1.producto_id) as referencia,
                    (SELECT Nombre FROM productosventa t2 WHERE t2.idProductosVenta=t1.producto_id) as nombre_producto,
                    (SELECT PrecioVenta FROM productosventa t2 WHERE t2.idProductosVenta=t1.producto_id) as precio_venta 
                     FROM restaurante_productos_favoritos t1 ";
           $Consulta=$obCon->Query($sql);
           $i=1;
           while ($datos_producto = $obCon->FetchAssoc($Consulta)) {
               if($i==1){
                   print('<div class="row">');
               }
               $i++;
               
               $item_id=$datos_producto["ID"];
               $producto_id=$datos_producto["producto_id"];
               if($TipoUser=="administrador"){
                    $contenido='<div class="pull-right"><li onclick="frm_editar_favorito(`'.$item_id.'`)" class="fa fa-edit" style="color:green;cursor:pointer;"></li></div>';
                }else{
                    $contenido='';
                }
               
                   $contenido=substr($datos_producto["nombre_producto"],0,14).$contenido;
             
              
                print('<div id="div_'.$item_id.'"  class="col-sm-4" >
                            <div class="info-box">
                            <span class="info-box-icon bg-blue" onclick="agregar_item(`'.$item_id.'`,`'.$producto_id.'`);" style="cursor:pointer;"><i class="fa fa-star-o"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-number" style="font-size:14px;">'.$contenido.'</span>
                              <span class="info-box-number" style="font-size:12px;">'.($datos_producto["referencia"]).'</span> 
                              <span class="info-box-number">'.number_format($datos_producto["precio_venta"]).'</span>     
                              <span class="info-box-number" ><textarea style="font-size:14px;" rows="1" id="Observaciones_'.$datos_producto["ID"].'" class="form-control" placeholder="Observaciones"></textarea></span>    
                            </div>  
                        </div>    
                          </div>');
               
                if($i==4){
                    $i=1;
                   print('</div>');
               }
            }
            print('</div>');
        break;//Fin caso 11    
        
        case 12://Formulario para editar un favorito
            $favorito_id=$obCon->normalizar($_REQUEST["favorito_id"]);
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 4, "", "", "", "");
            $css->input("hidden", "favorito_id", "", "product_id_favorite", "", $favorito_id, "", "", "", "");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Producto</strong>", 1,"C");
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print('<td>');
                        $css->select("product_id_favorite", "form-control", "product_id_favorite", "", "", "", 'style="width:100%;"');
                            $css->option("", "", "", "", "", "");
                                print("Seleccione un producto");
                            $css->Coption();
                        $css->Cselect();
                    print('</td>');
                    
                $css->CierraFilaTabla();
            $css->CerrarTabla();
                
                
            
        break;//Fin caso 12
    
        case 13://Dibuja el listado de pedidos
            
            $sql="SELECT * FROM vista_restaurante_pendiente_preparar";
            $Consulta=$obCon->Query($sql);
            
            print('<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Pendientes por Preparar</h3>

                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      
                    </div>
                  </div>
                  <!-- /.box-tools -->
                </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                
                <div class="btn-group">
                   <!-- <a title="Nuevo" onclick="FormularioCrearPedido()" class="btn btn-social-icon btn-github btn-lg"><i class="fa fa-plus"></i></a>-->
                    
                </div>
                
                <div class="pull-right">
                <!--
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  -->
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>');
            
                  
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                
                $idPedido=$DatosPedido["pedido_id"];
                $item_id=$DatosPedido["item_id"];
                $bg="blue";
                $InfoAdicional="";
                $EntregaTardia=0;
                $TipoPedido=$DatosPedido["tipo_pedido"];
                if($TipoPedido==1){//Si es un pedido de mesa
                    $Titulo=$DatosPedido["nombre_mesa"];
                    $NombreUsuario=$DatosPedido["nombre_usuario"];
                }
                
                if($TipoPedido==2){//Si es un domicilio
                    $bg="purple";
                    $Titulo=$DatosPedido["NombreCliente"];
                    $NombreUsuario=$DatosPedido["nombre_usuario"];
                }
                
                if($TipoPedido==3){//Si es para llevar
                    $bg="red";
                    $Titulo=$DatosPedido["NombreCliente"];
                    $NombreUsuario=$DatosPedido["nombre_usuario"];
                }
                
                    
                $FechaCreacion=$DatosPedido["creacion_item"];
                $TiempoTranscurrido=$obCon->CalcularTiempoPedido($FechaCreacion);
                $InfoAdicional="$TiempoTranscurrido min atrás";
                if($TiempoTranscurrido>14){
                    $EntregaTardia=1;
                }
               
                if($EntregaTardia==1){
                        $InfoAdicional=('                       
                        <div style="color:red">
                         <li class="fa fa-clock-o"> Entrega Tardía
                          </li>
                        </div>
                        ');
                    }
                
                
                print('<tr onclick="preparar_item(`'.$item_id.'`)">');
                    
                print('   
                    
                    <td style="cursor:pointer" class="mailbox-star"><a ><i class="fa fa-star text-'.$bg.' "></i> <strong>'.$idPedido.'</strong></a></td>
                    <td style="cursor:pointer" class="mailbox-attachment">'.$DatosPedido["nombre_tipo_pedido"].'</td>    
                    <td style="cursor:pointer" class="mailbox-name"><a >'.$Titulo.'</a></td>
                    <td style="cursor:pointer" class="mailbox-subject" ><b>'.$DatosPedido["nombre_producto"].' </b> </td>
                    <td style="cursor:pointer" class="mailbox-subject" ><b>'.$DatosPedido["cantidad"].' </b> </td>
                    <td style="cursor:pointer" class="mailbox-subject" ><b>'.$DatosPedido["observaciones"].' </b> </td>
                    
                    <td style="cursor:pointer" class="mailbox-attachment">'.$NombreUsuario.'</td>
                    <td class="mailbox-date">'.$InfoAdicional.'</td>
                  </tr>');
                
                //print('<tr><td colspan="6"> </td></tr>');
            }
            
            
            
            print('      </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
          </div>');
        break;//Fin caso 13
        
        case 14://Listar opciones
            print('<div class="col-md-12">');
                print('<a class="btn btn-app bg-navy " onclick=ModalCrearTercero(`ModalAccionesPOS`,`DivFrmPOS`);>
                            <i class="fa fa-users"></i> Terceros
                          </a>');
            //print('</div>');
            //print('<div class="col-md-3">');
                print('<a class="btn btn-app bg-navy " onclick="ModalCrearEgreso();">
                            <i class="fa fa-dollar"></i> Egresos
                          </a>');
            //print('</div>');
            //print('<div class="col-md-3">');
                print('<a class="btn btn-app bg-maroon " onclick="FormularioCerrarTurno();">
                            <i class="fa fa-cog"></i> Cerrar Turno
                          </a>');
            print('</div>');
            
            print('<div class="row">');
                print('<div id="div_mensajes_opciones" class="col-md-12">');
                    
                print('</div>');
            print('</div>');
            
            
        break;//Fin caso 14
    
        case 15://Formulario para crear un egreso
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 5, "", "", "", ""); //3 sirve para indicarle al sistema que debe guardar el formulario de crear un egreso
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Tipo de Egreso</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    
                    $css->ColTabla("<strong>Número de Soporte</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td>");
                        $css->select("TipoEgreso", "form-control", "TipoEgreso", "", "", "", "style=width:300px");
                        $Consulta=$obCon->ConsultarTabla("subcuentas", " WHERE (PUC LIKE '5135%' or PUC LIKE '5105%' or PUC LIKE '5195%' or PUC LIKE '1130%') AND LENGTH(PUC)>4 ");
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
                        $css->input_number_format("number", "SubtotalEgreso", "form-control", "SubtotalEgreso", "SubtotalEgreso", "", "Subtotal", "off", "", "", "onkeyup=CalculeTotalEgreso()");                    
                        $css->input_number_format("number", "IVAEgreso", "form-control", "IVAEgreso", "IVAEgreso", 0, "IVA", "off", "", "", "onkeyup=CalculeTotalEgreso()");
                        $css->input_number_format("number", "TotalEgreso", "form-control", "TotalEgreso", "TotalEgreso", "", "Total", "off", "", "", "","disabled");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
            $css->CerrarTabla();
        break;//fin caso 15
        
        case 16://Dibuja el resumen de los pedidos
            
            $sql="SELECT * FROM vista_restaurante_pedidos_resumen WHERE idCierre=0 ";
            $Consulta=$obCon->Query($sql);
           
            print('<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Resumen del Turno Actual</h3>

                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      
                    </div>
                  </div>
                  <!-- /.box-tools -->
                </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                
                
                
                <div class="pull-right">
                
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table mailbox-messages">
                <table class="table table-responsive table-hover table-striped">
                  <tbody><tr><td colspan="6" style="text-align:center"><strong>PEDIDOS</strong></td></tr>');
            
            $total=0;      
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                $total=$total+$DatosPedido["total"];
                $idPedido=$DatosPedido["ID"];
                $bg="blue";
                $InfoAdicional="";
                $EntregaTardia=0;
                
                print('<tr>');
                    
                print('   
                    <td class="mailbox-star"><a ><i class="fa fa-star text-'.$bg.' "></i> <strong>'.$DatosPedido["nombre_tipo_pedido"].'</strong></a></td>
                    <td class="mailbox-name"><a >'.$DatosPedido["nombre_estado"].'</a></td>
                    <td class="mailbox-attachment" style="text-align:right">'.number_format($DatosPedido["total_pedidos"]).'</td>
                    <td class="mailbox-attachment" style="text-align:right">'.number_format($DatosPedido["subtotal"]).'</td>
                    <td class="mailbox-attachment" style="text-align:right">'.number_format($DatosPedido["iva"]).'</td>
                    <td class="mailbox-attachment" style="text-align:right">'.number_format($DatosPedido["total"]).'</td>
                    
                  </tr>');
                
                
            }
            print('<tr><td colspan="5" style="text-align:right"><strong>TOTAL:</strong></td><td style="text-align:right">'.number_format($total).'</td></tr>');
            
            
            print('      </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
          </div>');
            
            
            //Resumen de pedidos items
            
            $sql="SELECT * FROM vista_restaurante_pedidos_items_resumen WHERE idCierre=0 ";
            $Consulta=$obCon->Query($sql);
           
            print('<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Resumen de los productos en el turno actual</h3>

                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      
                    </div>
                  </div>
                  <!-- /.box-tools -->
                </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                
                
                
                <div class="pull-right">
                
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table mailbox-messages">
                <table class="table table-responsive table-hover table-striped">
                  <tbody><tr><td colspan="5" style="text-align:center"><strong>PRODUCTOS</strong></td></tr>');
            
            $total=0;      
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                $total=$total+$DatosPedido["total"];
                
                $bg="blue";
                $InfoAdicional="";
                $EntregaTardia=0;
                
                print('<tr>');
                    
                print('   
                    <td class="mailbox-star"><a ><i class="fa fa-star text-'.$bg.' "></i> <strong>'.$DatosPedido["NombreProducto"].'</strong></a></td>
                    <td class="mailbox-attachment" style="text-align:right">'.number_format($DatosPedido["cantidad"]).'</td>
                    <td class="mailbox-attachment" style="text-align:right">'.number_format($DatosPedido["subtotal"]).'</td>
                    <td class="mailbox-attachment" style="text-align:right">'.number_format($DatosPedido["iva"]).'</td>
                    <td class="mailbox-attachment" style="text-align:right">'.number_format($DatosPedido["total"]).'</td>
                    
                  </tr>');
                
                
            }
            print('<tr><td colspan="4" style="text-align:right"><strong>TOTAL:</strong></td><td style="text-align:right">'.number_format($total).'</td></tr>');
            
            
            print('      </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
          </div>');
        break;//Fin caso 16
        
        case 17://Dibuja el resumen actual del turno
            
            $css->CrearBotonEvento("BtnExportarExcel", "Exportar Resumen del turno", 1, "onclick", "ExportarTablaToExcel('tblResumenTurno')", "verde", "");
           
            
           
            $css->CrearTabla('tblResumenTurno');
                 
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ID</strong>", 1);
                    $css->ColTabla("<strong>Producto</strong>", 1);
                    $css->ColTabla("<strong>Recibe</strong>", 1);
                    $css->ColTabla("<strong>Compras</strong>", 1);
                    $css->ColTabla("<strong>Altas</strong>", 1);
                    $css->ColTabla("<strong>Ventas</strong>", 1);
                    $css->ColTabla("<strong>Bajas</strong>", 1);
                    $css->ColTabla("<strong>Saldo Final</strong>", 1);
                    $css->ColTabla("<strong>Total Ventas</strong>", 1);
                    $css->ColTabla("<strong>Comision 1</strong>", 1);
                    $css->ColTabla("<strong>Comision 2</strong>", 1);
                    $css->ColTabla("<strong>Comision 3</strong>", 1);
                    $css->ColTabla("<strong>Comision 4</strong>", 1);
                    $css->ColTabla("<strong>Total Casa</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $sql="SELECT * FROM vista_resumen_restaurante_turno_actual  ";
                        
                $Consulta=$obCon->Query($sql);
                $TotalVentas=0;
                $TotalComision1=0;
                $TotalComision2=0;
                $TotalComision3=0;
                $TotalComision4=0;
                $TotalCasa=0;
                while($DatosAgenda=$obCon->FetchAssoc($Consulta)){
                    $TotalVentas=$TotalVentas+$DatosAgenda["TotalVentas"];    
                    $TotalComision1=$TotalComision1+$DatosAgenda["TotalComisiones1"];  
                    $TotalComision2=$TotalComision2+$DatosAgenda["TotalComisiones2"];  
                    $TotalComision3=$TotalComision3+$DatosAgenda["TotalComisiones3"];  
                    $TotalComision4=$TotalComision4+$DatosAgenda["TotalComisiones4"];  
                    $TotalCasa=$TotalCasa+$DatosAgenda["TotalCasa"];  
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosAgenda["idProductosVenta"], 1);
                        $css->ColTabla($DatosAgenda["Nombre"], 1);
                        $css->ColTabla($DatosAgenda["CantidadRecibida"], 1);
                        $css->ColTabla($DatosAgenda["ItemsCompras"], 1);
                        $css->ColTabla($DatosAgenda["TotalAltas"], 1);
                        $css->ColTabla($DatosAgenda["ItemsVentas"], 1);
                        $css->ColTabla($DatosAgenda["TotalBajas"], 1);
                        $css->ColTabla($DatosAgenda["SaldoFinal"], 1);
                        $css->ColTabla(number_format($DatosAgenda["TotalVentas"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["TotalComisiones1"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["TotalComisiones2"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["TotalComisiones3"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["TotalComisiones4"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["TotalCasa"]), 1);
                        
                    $css->CierraFilaTabla();
                }
                
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1,"R");
                        $css->ColTabla(" ", 1,"R");
                        $css->ColTabla(" ", 1,"R");
                        $css->ColTabla(" ", 1,"R");
                        $css->ColTabla(" ", 1,"R");
                        $css->ColTabla(" ", 1,"R");
                        $css->ColTabla(" ", 1,"R");
                        //$css->ColTabla(" ", 1,"R");                        
                        $css->ColTabla("<strong>TOTALES:</strong>", 1,"R");
                        $css->ColTabla("<strong>".number_format($TotalVentas)."</strong>", 1);
                        $css->ColTabla("<strong>".number_format($TotalComision1)."</strong>", 1);
                        $css->ColTabla("<strong>".number_format($TotalComision2)."</strong>", 1);
                        $css->ColTabla("<strong>".number_format($TotalComision3)."</strong>", 1);
                        $css->ColTabla("<strong>".number_format($TotalComision4)."</strong>", 1);
                        $css->ColTabla("<strong>".number_format($TotalCasa)."</strong>", 1);
                        
                    $css->CierraFilaTabla();
           $css->CerrarTabla(); 
        break; //Fin caso 17
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>