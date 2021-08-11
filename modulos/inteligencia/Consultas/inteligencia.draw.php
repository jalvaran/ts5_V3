<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../clases/inteligencia.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Inteligencia($idUser);
    
    $Meses =array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
       
    switch ($_REQUEST["Accion"]) {
        
        case 1: //dibuja el listado de clientes
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $cmbFiltroCliente=$obCon->normalizar($_REQUEST["cmbFiltroCliente"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            
                        
            $Condicion=" WHERE idClientes>0 ";
            
            if($cmbFiltroCliente=='1' and ($FechaInicialRangos<>'' or $FechaFinalRangos<>'')){
                if($FechaInicialRangos<>''){
                    $diaInicial=date("d", strtotime($FechaInicialRangos));
                    $mesInicial=date("m", strtotime($FechaInicialRangos));
                    $Condicion.=" AND (DiaNacimiento>='$diaInicial' AND MesNacimiento>='$mesInicial') ";
                }
                
                if($FechaFinalRangos<>''){
                    $diaFinal=date("d", strtotime($FechaFinalRangos));
                    $mesFinal=date("m", strtotime($FechaFinalRangos));
                    $Condicion.=" AND (DiaNacimiento<='$diaFinal' AND MesNacimiento<='$mesFinal') ";
                }
                
            }
                    
            if($cmbFiltroCliente=='2' and ($FechaInicialRangos<>'' or $FechaFinalRangos<>'')){
                if($FechaInicialRangos<>''){
                    $Condicion.=" AND Created >= '$FechaInicialRangos' ";
                }
                
                if($FechaFinalRangos<>''){
                    $Condicion.=" AND Created <= '$FechaFinalRangos' ";
                }
                
            }
            
            if($cmbFiltroCliente=='3' and ($FechaInicialRangos<>'' or $FechaFinalRangos<>'')){
                if($FechaInicialRangos<>''){
                    $Condicion.=" AND Puntaje >= '$FechaInicialRangos' ";
                }
                
                if($FechaFinalRangos<>''){
                    $Condicion.=" AND Puntaje <= '$FechaFinalRangos' ";
                }
                
            }
            
            if($cmbFiltroCliente=='4' and ($FechaInicialRangos<>'' or $FechaFinalRangos<>'')){
                if($FechaInicialRangos<>''){
                    $Condicion.=" AND Updated >= '$FechaInicialRangos' ";
                }
                
                if($FechaFinalRangos<>''){
                    $Condicion.=" AND Updated <= '$FechaFinalRangos' ";
                }
                
            }
            
            if($idCliente<>''){
                $Condicion.=" AND idClientes = '$idCliente' ";
            }
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items  
                   FROM clientes t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
                        
            $sql="SELECT * 
                  FROM clientes $Condicion ORDER BY idClientes DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>Clientes</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                  <div class="inner">
                                    <h3>'.$ResultadosTotales.'</h3>

                                    <p>Clientes Listados</p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-person-add" style="cursor:pointer" onclick=ModalCrearTercero(`ModalAcciones`,`DivFrmModalAcciones`); return false></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        $CondicionBase64= base64_encode(urlencode($Condicion));
                        $Link="procesadores/inteligencia.process.php?Accion=2&c=$CondicionBase64";
                        if($TipoUser=="administrador"){
                            print('<div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                      <div class="inner">
                                        <h3>Exportar</h3>

                                        <p>Clientes</p>
                                      </div>
                                      <div class="icon">
                                        <a href="'.$Link.'" target="_blank" class="fa fa-file-excel-o" style="cursor:pointer" ></a>
                                      </div>

                                    </div>
                                  </div>');
                        }
                        print('<div class="col-lg-2 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-blue">
                                  <div class="inner">
                                   
                                    <h3>Mensajería</h3>
                                    <p>Enviar un correo</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-send" id="btn_subir" style="cursor:pointer" onclick=DibujeRedactarCorreoClientes(`'.$CondicionBase64.'`); return false></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        
                        print('<div class="col-lg-2 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-orange">
                                  <div class="inner">
                                   
                                    <h3>Bajar</h3>
                                    <p>Clientes</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-cloud-download" id="btn_descargar" style="cursor:pointer" onclick="ConfirmaDescargarDesdeServidor();"></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        
                        print('<div class="col-lg-2 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red">
                                  <div class="inner">
                                   
                                    <h3>Subir</h3>
                                    <p>Clientes</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-cloud-upload" style="cursor:pointer" onclick="ConfirmaCargarAlServidor();"></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        
                    $css->Cdiv();
                     
                                       
                    $css->div("", "pull-left", "", "", "", "", "");
                        if($ResultadosTotales>$Limit){
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`1`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(`1`);";
                            $css->select("CmbPage", "form-control", "CmbPage", "", "", $FuncionJS, "");

                                for($p=1;$p<=$TotalPaginas;$p++){
                                    if($p==$NumPage){
                                        $sel=1;
                                    }else{
                                        $sel=0;
                                    }

                                    $css->option("", "", "", $p, "", "",$sel);
                                        print($p);
                                    $css->Coption();

                                }

                            $css->Cselect();
                            if($ResultadosTotales>($PuntoInicio+$Limit)){
                                $NumPage1=$NumPage+1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`1`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                        }    
                    $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<thead>');  
                            $css->FilaTabla(16);    
                                print("<td colspan='10' style='width:100%'>");
                                        
                                print("</td>");
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);    
                                $css->ColTabla("<strong>Editar</strong>", 1,"C");
                                $css->ColTabla("<strong>+ Datos</strong>", 1,"C");
                                $css->ColTabla("<strong>Referidos</strong>", 1,"C");
                                $css->ColTabla("<strong>ID</strong>", 1,"C");                                
                                $css->ColTabla("<strong>Nombre</strong>", 1,"C");
                                $css->ColTabla("<strong>Identificacion</strong>", 1,"C");
                                $css->ColTabla("<strong>Telefono</strong>", 1,"C");
                                $css->ColTabla("<strong>Dirección</strong>", 1,"C");
                                $css->ColTabla("<strong>Cumpleaños</strong>", 1,"C");
                                $css->ColTabla("<strong>Email</strong>", 1,"C");
                                $css->ColTabla("<strong>Puntaje</strong>", 1,"C");
                                $css->ColTabla("<strong>Betar/Habilitar</strong>", 1,"C");
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["idClientes"];
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button type="button" class="btn btn-warning btn-flat" onclick=ModalEditarTercero(`ModalAcciones`,`DivFrmModalAcciones`,`'.$idItem.'`,`clientes`)><i class="fa fa-edit"></i></button>');
                                    print("</td>");
                                    
                                    print('<td>');
                                        print('<button type="button" class="btn btn-primary btn-flat" onclick="DibujarFormularioDatosAdicionalesCliente(`'.$idItem.'`,`DivGeneralDraw`)"> <i class="fa fa-user-plus"> </i> </button>');
                                    print('</td>');
                                    
                                    print('<td>');
                                        print('<button type="button" class="btn btn-success btn-flat" onclick="DibujarFormularioRecomendadosCliente(`'.$idItem.'`,`DivGeneralDraw`)"> <i class="fa fa-users"> </i> </button>');
                                    print('</td>');
                                   
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["idClientes"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["RazonSocial"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Num_Identificacion"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["Telefono"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["Direccion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        $Mes=$RegistrosTabla["MesNacimiento"];
                                        print("".($RegistrosTabla["DiaNacimiento"])." de ".($Meses[$Mes]));
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["Email"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".number_format($RegistrosTabla["Puntaje"])."</strong>");
                                    print("</td>");
                                    
                                    print("<td>");
                                        $Icon="fa fa-user-times";
                                        $Color="danger";
                                        if($RegistrosTabla["Estado"]==10){
                                            $Icon="fa fa-check";
                                            $Color="success";
                                        }
                                        if($TipoUser=='administrador'){
                                            print('<button type="button" class="btn btn-'.$Color.' btn-sm" onclick=CambieEstadoCliente(`'.$idItem.'`)><i class="'.$Icon.'"></i></button>');
                                        }
                                        
                                    print("</td>");
                                                                                                            
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 1
        
        case 2: //dibuja el listado de productos vendidos
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $cmbFiltroCliente=$obCon->normalizar($_REQUEST["cmbFiltroCliente"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            
            
                        
            $Condicion=" WHERE ID>0 ";
            
            if($FechaInicialRangos=='' or $FechaFinalRangos==''){
                $css->Notificacion("Error", "Debes Seleccionar un rango de Fechas", "rojo", "", "");
                exit();
            }
             /*     
            if(($FechaInicialRangos<>'' or $FechaFinalRangos<>'')){
                if($FechaInicialRangos<>''){
                    $Condicion.=" AND FechaFactura >= '$FechaInicialRangos' ";
                }
                
                if($FechaFinalRangos<>''){
                    $Condicion.=" AND FechaFactura <= '$FechaFinalRangos' ";
                }
                
            }
              * 
              */
            
            if($idCliente<>''){
                $Condicion.=" AND idCliente = '$idCliente' ";
            }
            $obCon->crearVistaProductosPorCliente($FechaInicialRangos,$FechaFinalRangos);
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(Cantidad) as CantidadTotal,SUM(TotalItem) as Total   
                   FROM vista_productos_x_cliente t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $TotalVentas = $totales['Total'];
            $CantidadTotal = $totales['CantidadTotal'];
                        
            $sql="SELECT * 
                  FROM vista_productos_x_cliente $Condicion ORDER BY Cantidad DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>Productos Vendidos</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                  <div class="inner">
                                    <h3>'.number_format($CantidadTotal).'</h3>

                                    <p>Items vendidos</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-sellsy" ></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-orange">
                                  <div class="inner">
                                    <h3>'.number_format($TotalVentas).'</h3>

                                    <p>Total Ventas</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-dollar" ></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        $CondicionBase64= base64_encode(urlencode($Condicion));
                        $Link="procesadores/inteligencia.process.php?Accion=3&c=$CondicionBase64";
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                  <div class="inner">
                                    <h3>Exportar</h3>

                                    <p>Productos Vendidos</p>
                                  </div>
                                  <div class="icon">
                                    <a href="'.$Link.'" target="_blank" class="fa fa-file-excel-o" style="cursor:pointer" ></a>
                                  </div>
                                  
                                </div>
                              </div>');
                        
                        $Link="procesadores/inteligencia.process.php?Accion=5&fecha_inicial=$FechaInicialRangos&fecha_final=$FechaFinalRangos";
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-blue">
                                  <div class="inner">
                                    <h3>Informe</h3>

                                    <p>Inteligencia de Negocio</p>
                                  </div>
                                  <div class="icon">
                                    <a href="'.$Link.'" target="_blank" class="fa fa-file-pdf-o" style="cursor:pointer" ></a>
                                  </div>
                                  
                                </div>
                              </div>');
                        
                    $css->Cdiv();
                     
                                       
                    $css->div("", "pull-left", "", "", "", "", "");
                        if($ResultadosTotales>$Limit){
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`2`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(`2`);";
                            $css->select("CmbPage", "form-control", "CmbPage", "", "", $FuncionJS, "");

                                for($p=1;$p<=$TotalPaginas;$p++){
                                    if($p==$NumPage){
                                        $sel=1;
                                    }else{
                                        $sel=0;
                                    }

                                    $css->option("", "", "", $p, "", "",$sel);
                                        print($p);
                                    $css->Coption();

                                }

                            $css->Cselect();
                            if($ResultadosTotales>($PuntoInicio+$Limit)){
                                $NumPage1=$NumPage+1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`2`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                        }    
                    $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<thead>');  
                            $css->FilaTabla(16);    
                                print("<td colspan='10' style='width:100%'>");
                                        
                                print("</td>");
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);    
                                                                
                                $css->ColTabla("<strong>Tipo Factura</strong>", 1,"C");                                
                                $css->ColTabla("<strong>Referencia</strong>", 1,"C");
                                $css->ColTabla("<strong>Nombre</strong>", 1,"C");
                                $css->ColTabla("<strong>Cantidad</strong>", 1,"C");
                                $css->ColTabla("<strong>Total</strong>", 1,"C");
                                $css->ColTabla("<strong>Cliente</strong>", 1,"C");
                                $css->ColTabla("<strong>Identificacion</strong>", 1,"C");
                                                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                print('<tr>');
                                    
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["FormaPago"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["Referencia"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Nombre"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["Cantidad"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["TotalItem"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["RazonSocial"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Num_Identificacion"])."</strong>");
                                    print("</td>");
                                    
                                                                                                            
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 2
        
        
        case 3://Dibuja el formulario para enviar un mail
            $Condicion=$obCon->normalizar(urldecode( base64_decode($_REQUEST["Condicion"])));            
            $css->CrearTitulo("<strong>Redactar un Correo</strong>", "azul");
            $sql="SELECT Email FROM clientes $Condicion LIMIT 50";
            $Consulta=$obCon->Query($sql);
            $Mails="";
            while($DatosCliente=$obCon->FetchAssoc($Consulta)){
                if(filter_var($DatosCliente["Email"], FILTER_VALIDATE_EMAIL)){
                    $Mails.=$DatosCliente["Email"];
                    $Mails.=",";
                }
                
            }
            $Mails = substr($Mails, 0, -1);
            $css->input("text", "Destinatario", "form-control", "Destinatario", "", $Mails, "Para:", "off", "", "");
            print("<br>");
            $css->input("text", "Asunto", "form-control", "Asunto", "", "", "Asunto:", "off", "", "");
            print("<br>");
            print('<textarea id="Mensaje" class="summernote" rows="10"></textarea>');
            print("<br>");
            $css->div("", "row", "", "", "", "", "");
                $css->div("", "col-lg-4", "", "", "", "", "");
                $css->Cdiv();
                $css->div("", "col-lg-4", "", "", "", "", "");
                $css->Cdiv();
                $css->div("", "col-lg-4", "", "", "", "", "");
                    $css->CrearBotonEvento("btnEnviar", "Enviar", 1, "onclick", "EnviarMailClientes()", "verde");
                $css->Cdiv();
            $css->Cdiv();        
        break;//Fin caso 3    
        case 4://Dibuja la tabla de metas
            
            $sql="SELECT * FROM metas_ventas ORDER BY Anio DESC, Mes ASC";
            
            $consulta=$obCon->Query($sql);
            $ano_actual=date("Y");
            
            $css->CrearBotonEvento("btn_inicializar_ano", "Crear Tabla Metas $ano_actual", 1, "onclick", "crear_registros_iniciales_metas($ano_actual)", "azul");
            $cabecera=1;
            $r="";
            while($datos_consulta=$obCon->FetchAssoc($consulta)){
                
                $item_id=$datos_consulta["ID"];
                if($r<>$datos_consulta["Anio"]){
                    $r=$datos_consulta["Anio"];
                    $cabecera=1;
                }
                if($cabecera==1){
                    $css->CrearTabla();
                        $css->FilaTabla(14);
                            $css->ColTabla("<h2>Meta Mensual para el Año ".$datos_consulta["Anio"]."</h2>", 4,"C");
                        $css->CierraFilaTabla();    
                        $css->FilaTabla(14);                            
                            $css->ColTabla("Mes", 1);
                            $css->ColTabla("Meta", 1);
                            $css->ColTabla("Frase", 2);
                        $css->CierraFilaTabla();
                    $cabecera=0;
                }
                
                $css->FilaTabla(14);
                    $css->ColTabla($datos_consulta["Mes"], 1);
                    print("<td>");
                        $id="caja_meta_".$item_id;
                        $css->input("text", $id, "form-control", $id, "", $datos_consulta["Meta"], "Meta", "off", "", "onchange=editar_registro_metas(`1`,`$item_id`,`Meta`,`$id`)");
                    print("</td>");
                                  
                    print("<td>");
                        $id="frase_meta_".$item_id;
                        $css->textarea($id, "form-control", $id, "", "Frase de motivacion", "", "onchange=editar_registro_metas(`1`,`$item_id`,`Frase`,`$id`)");
                            print(($datos_consulta["Frase"]));
                        $css->Ctextarea();
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
            }
            
                
            
            
        break;//Fin caso 4    
        
        case 5: //dibuja el listado de metas diarias
            
            $Limit=100;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            
                        
            $Condicion=" WHERE ID>0 ";
            
            if($FechaInicialRangos<>''){
                $Condicion.=" AND fecha >= '$FechaInicialRangos' ";
            }

            if($FechaFinalRangos<>''){
                $Condicion.=" AND fecha <= '$FechaFinalRangos' ";
            }
                
           
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items  
                   FROM metas_ventas_diarias t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
                        
            $sql="SELECT * 
                  FROM metas_ventas_diarias $Condicion ORDER BY fecha ASC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>Cumplimiento de Metas Diarias</strong>", "azul");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                  <div class="inner">
                                    <h3>'.$ResultadosTotales.'</h3>

                                    <p>Cumplimiento Metas</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        $CondicionBase64= base64_encode(urlencode($Condicion));
                        $Link="procesadores/inteligencia.process.php?Accion=15&c=$CondicionBase64";
                        if($TipoUser=="administrador"){
                            print('<div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                      <div class="inner">
                                        <h3>Exportar</h3>

                                        <p>Cumplimiento de Metas</p>
                                      </div>
                                      <div class="icon">
                                        <a href="'.$Link.'" target="_blank" class="fa fa-file-excel-o" style="cursor:pointer" ></a>
                                      </div>

                                    </div>
                                  </div>');
                        }
                        
                        
                    $css->Cdiv();
                     
                                       
                    $css->div("", "pull-left", "", "", "", "", "");
                        if($ResultadosTotales>$Limit){
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`4`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(`4`);";
                            $css->select("CmbPage", "form-control", "CmbPage", "", "", $FuncionJS, "");

                                for($p=1;$p<=$TotalPaginas;$p++){
                                    if($p==$NumPage){
                                        $sel=1;
                                    }else{
                                        $sel=0;
                                    }

                                    $css->option("", "", "", $p, "", "",$sel);
                                        print($p);
                                    $css->Coption();

                                }

                            $css->Cselect();
                            if($ResultadosTotales>($PuntoInicio+$Limit)){
                                $NumPage1=$NumPage+1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`4`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                        }    
                    $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<thead>');  
                            $css->FilaTabla(16);    
                                print("<td colspan='10' style='width:100%'>");
                                        
                                print("</td>");
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);    
                                $css->ColTabla("<strong>ID</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha</strong>", 1,"C");
                                $css->ColTabla("<strong>Meta</strong>", 1,"C");
                                $css->ColTabla("<strong>Venta</strong>", 1,"C");                                
                                $css->ColTabla("<strong>Diferencia</strong>", 1,"C");
                                $css->ColTabla("<strong>Venta Día</strong>", 1,"C");
                                $css->ColTabla("<strong>Cumplimiento</strong>", 1,"C");
                                
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                print('<tr>');
                                    
                                    print("<td class='mailbox-subject' >");
                                        print("<strong>".$RegistrosTabla["ID"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["fecha"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject' style=text-align:right>");
                                        print("<strong>".number_format($RegistrosTabla["meta"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject' style=text-align:right>");
                                        print("".number_format($RegistrosTabla["total_ventas"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject' style=text-align:right>");
                                        print("".number_format($RegistrosTabla["diferencia"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject' style=text-align:right>");
                                        print("".number_format($RegistrosTabla["ventas_dia"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject' style=text-align:right>");
                                        print("<strong>".($RegistrosTabla["cumplimiento"])."</strong>");
                                    print("</td>");
                                    
                                                                                                            
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 5
        
        case 6:// Dibuja los espacios para las graficas de cumplimiento de metas
            $fecha_inicial=date("Y-m-d");
            $fecha_final=date("Y-m-d");
            
            if(isset($_REQUEST["fecha_inicial"]) and !empty($_REQUEST["fecha_inicial"]) ){
                $fecha_inicial=$_REQUEST["fecha_inicial"];
            }
            if(isset($_REQUEST["fecha_final"]) and !empty($_REQUEST["fecha_final"]) ){
                $fecha_final=$_REQUEST["fecha_final"];
            }
            
            $mes_ano_fecha_inicial=substr($fecha_inicial, 0,7);
            $mes_ano_fecha_final=substr($fecha_final, 0,7);
            if($mes_ano_fecha_inicial<>$mes_ano_fecha_final){
                $css->Notificacion("Error", "Debe elegir el mismo mes y un mismo año", "rojo", "", "");
                exit();
            }
            if($fecha_inicial>$fecha_final){
                $css->Notificacion("Error", "La fecha inicial no puede ser mayor a la final", "rojo", "", "");
                exit();
            }
            $html=('<div class="row">
                <div class="col-md-12">
                    <h3>Metas del '.$fecha_inicial.' al '.$fecha_final.' </h3>
                    <div id="frase_meta" style="font-size:30px"></div>
                </div>
                <div class="col-md-6">
                    <h3>Meta Diaria</h3>
                    <canvas id="torta" style="width:100%;max-width:700px"></canvas>
                </div>
                <div class="col-md-6">
                    <h3>Meta Mensual</h3>
                    <canvas id="torta_mes" style="width:100%;max-width:700px"></canvas>
                </div>
                <div class="col-md-6">
                    <h3>Metas Discriminadas por mes</h3>
                    <span class="btn btn-primary">Meta</span>
                    <span class="btn btn-success">Cumplimiento</span>
                    <br><br>
                    <canvas id="barras" style="width:100%;max-width:700px"></canvas>
                </div>
                
              
              ');  
            
            $ano_mes_consulta_inicial=$mes_ano_fecha_inicial.'-01';
            $sql="SELECT SUM(Total) as Total
                    FROM facturas
                    WHERE Fecha>='$ano_mes_consulta_inicial' AND Fecha<='$fecha_final' AND FormaPago<>'ANULADA' LIMIT 1";
            $Consulta=$obCon->Query($sql);
            $array_total=$obCon->FetchAssoc($Consulta);
            $total_ventas=$array_total["Total"];
            $sql="SELECT SUM(Total) as Total, FormaPago
                    FROM facturas
                    WHERE Fecha>='$ano_mes_consulta_inicial' AND Fecha<='$fecha_final' AND FormaPago<>'ANULADA' GROUP BY  FormaPago ";
            $Consulta=$obCon->Query($sql);
            
            $html.='<div class="col-md-6"><h3>Ventas X Tipo de Factura</h3>';
                
                $html.='<table class="table table-hover table-striped">';
                    $html.='<tr>';
                        $html.='<td><strong>TIPO DE FACTURA</strong></td>';
                        $html.='<td><strong>TOTAL</strong></td>';
                        $html.='<td><strong>PORCENTAJE</strong></td>';
                    $html.='</tr>';
                    $total=0;
                    while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                        $total=$total+$datos_consulta["Total"];
                        $porcentaje=round((100/$total_ventas)*$datos_consulta["Total"],2);
                        $html.='<tr>';
                            $html.='<td>'.$datos_consulta["FormaPago"].'</td>';
                            $html.='<td style="text-align:right">'.number_format($datos_consulta["Total"]).'</td>';
                            $html.='<td style="text-align:right">'.($porcentaje).'</td>';
                        $html.='</tr>';
                    }
                    $html.='<tr>';
                        $html.='<td style="text-align:right"><strong>TOTAL:</strong></td>';
                        $html.='<td style="text-align:right">'.number_format($total).'</td>';
                    $html.='</tr>';
                $html.='</table>';
                
            $html.='</div>';
            
            $html.='</div>';
            print($html);
        break;//Fin caso 6
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>