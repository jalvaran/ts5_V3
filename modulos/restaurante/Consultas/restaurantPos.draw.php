<?php

session_start();
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
            
            $css->CrearTabla();
            
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ID</strong>", 1, "C");
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
                $css->FilaTabla(15);
                    $css->ColTabla($DatosPedido["idProducto"], 1);
                    $css->ColTabla($Descripcion, 1);
                    $css->ColTabla($DatosPedido["Cantidad"], 1);
                    print("<td>");
                        print('<div class="input-group input-group-md">');
                        $css->input("number", "TxtTotal_".$idItem, "form-control", "TxtTotal", "", $DatosPedido["Total"], "Cantidad", "off", "", "");
                        print('<span class="input-group-btn">
                          <button type="button" class="btn btn-success btn-flat" onclick=EditarPrecioVenta(`'.$idItem.'`,`'."TxtTotal_".$idItem.'`)><i class="fa fa-edit"></i></button>
                        </span>');
                        print("</div>");
                    print("</td>");
                    //$css->ColTabla("<strong>".number_format($DatosPedido["Total"])."</strong>", 1,"R");
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
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                $idPedido=$DatosPedido["ID"];
                $bg="bg-blue";
                $InfoAdicional="";
                $EntregaTardia=0;
                if($TipoPedido==1){//Si es un pedido de mesa
                    $Titulo=$DatosPedido["NombreMesa"];
                    $NombreUsuario=$DatosPedido["NombreUsuario"];
                }
                
                if($TipoPedido==2){//Si es un domicilio
                    $bg="bg-purple";
                    $Titulo=$DatosPedido["NombreCliente"];
                    $NombreUsuario=$DatosPedido["DireccionEnvio"]." || ".$DatosPedido["TelefonoConfirmacion"]." || ".$DatosPedido["Observaciones"];
                }
                
                if($TipoPedido==3){//Si es para llevar
                    $bg="bg-red";
                    $Titulo=$DatosPedido["NombreCliente"];
                    $NombreUsuario=$DatosPedido["DireccionEnvio"];
                }
                if($DatosPedido["Estado"]==1){//Estado abierto o reabierto se mostrará el tiempo que lleva 
                    
                    $FechaCreacion=$DatosPedido["FechaCreacion"];
                    $TiempoTranscurrido=$obCon->CalcularTiempoPedido($FechaCreacion);
                    $InfoAdicional=" HACE $TiempoTranscurrido MINUTOS";
                    if($TiempoTranscurrido>14){
                        $EntregaTardia=1;
                    }
                }
                
                if($DatosPedido["Estado"]==6){//Estado entregado
                    $bg="bg-green";
                }
                
                if($DatosPedido["Estado"]==4){//Estado preparado
                    $bg="bg-orange";
                }
                
                print('<div class="box box-widget widget-user">
                    
                    <div class="widget-user-header '.$bg.'" onclick="idPedidoActivo='.$DatosPedido["ID"].'; DibujePedidoActivo();" style="cursor:pointer;height:140px;">
                        <h3 class="widget-user-username"><strong>Pedido:  '.$idPedido.'</strong></h3>
                        <h3 class="widget-user-username"><strong >'.$Titulo.'</strong></h3>
                        <h5 class="widget-user-desc">'.$NombreUsuario.'</h5>
                        <h5 class="widget-user-desc">'.$DatosPedido["NombreEstado"].$InfoAdicional.'</h5>
                    </div>
                    <div class="widget-user-image" style=color >
                    
                        <img class="img-circle" >
                        </img>
                      
                    
                    </div>
                    ');
                    
                    if($EntregaTardia==1){
                        print('                       
                        <div style="font-size:40px;color:red">
                         <li class="fa fa-clock-o">Entrega Tardía
                          </li>
                        </div>
                        ');
                    }
                    print('
                     <div class="box-footer">
                      <div class="row">
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            
                            ');
                    print('<span class="input-group-btn">
                            <button type="button" id="BtnImprimePrecuenta" class="btn btn-warning btn-flat" onclick=ImprimirPrecuenta(`'.$idPedido.'`) title="Imprimir Precuenta" style="font-size:30px;"><i class="fa fa-credit-card"></i></button>
                          </span>');
                    print('   
                            <span class="description-text" style="font-size:20px;"><strong>'.number_format($DatosPedido["TotalPedido"]).'</strong></span>
                            
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            
                            
                            ');
                    print('<span class="input-group-btn">
                            <button type="button" id="BtnImprimePedido" class="btn btn-success btn-flat" onclick=ImprimirPedido(`'.$idPedido.'`) title="Imprimir Pedido" style="font-size:30px;"><i class="fa fa-print"></i></button>
                          </span>');
                    print('  
                            <span class="description-text" style="font-size:15px;"><strong>PEDIDO</strong></span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3">
                          <div class="description-block">
                            ');
                    print('<span class="input-group-btn">
                            <button type="button" id="BtnImprimePedido" class="btn btn-info btn-flat" onclick=EntregarPedido(`'.$idPedido.'`) title="Entregar Pedido" style="font-size:30px;"><i class="fa fa-hand-paper-o"></i></button>
                          </span>');
                    print('  
                            <span class="description-text" style="font-size:15px;"><strong>ENTREGAR</strong></span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3">
                          <div class="description-block">
                            ');
                    if($TipoUser=="administrador"){
                        print('<span class="input-group-btn">
                                <button type="button" id="BtnAnular" class="btn btn-danger btn-flat" onclick=AnularPedido(`'.$idPedido.'`) title="Anular Pedido" style="font-size:30px;"><i class="fa fa-remove"></i></button>
                                </span>
                                <span class="description-text" style="font-size:15px;"><strong>ANULAR</strong></span>  
                            ');
                    }
                    print('  
                        
                            
                          </div> 
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                  </div>');
            }
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
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                $css->CrearTitulo("<strong>Cerrar Turno</strong>", "verde");
                $css->input("number", "EfectivoEnCaja", "form-control", "EfectivoEnCaja", "", "", "Efectivo en Caja", "off", "", "style=width:250px;");
                print("<br>");
                $css->textarea("ObservacionesCierre", "form-control", "ObservacionesCierre", "", "Observaciones", "", "style=width:250px;");

                $css->Ctextarea();
            $css->CerrarDiv();    
            
        break;// fin caso 8    
        
        case 9:// dibuja el formulario para agregar complementos a un producto
            $idProducto=$obCon->normalizar($_REQUEST["Codigo"]);
            
            print('<div class="row"> <div class="col-md-6">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class=""><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Tab 1</a></li>
              <li class=""><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Tab 2</a></li>
              <li class="active"><a href="#tab_3-2" data-toggle="tab" aria-expanded="true">Tab 3</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                </ul>
              </li>
              <li class="pull-left header"><i class="fa fa-th"></i> Custom Tabs</li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="tab_1-1">
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
              <div class="tab-pane" id="tab_2-2">
                The European languages are members of the same family. Their separate existence is a myth.
                For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                in their grammar, their pronunciation and their most common words. Everyone realizes why a
                new common language would be desirable: one could refuse to pay expensive translators. To
                achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                words. If several languages coalesce, the grammar of the resulting language is more simple
                and regular than that of the individual languages.
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="tab_3-2">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                like Aldus PageMaker including versions of Lorem Ipsum.
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div></div>');
            
        break;// fin caso 9
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>