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
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-blue">
                                  <div class="inner">
                                   
                                    <h3>Mensajería</h3>
                                    <p>Enviar un correo</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-send" style="cursor:pointer" onclick=DibujeRedactarCorreoClientes(`'.$CondicionBase64.'`); return false></i>
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
                                        print('<button type="button" class="btn btn-'.$Color.' btn-sm" onclick=CambieEstadoCliente(`'.$idItem.'`)><i class="'.$Icon.'"></i></button>');
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
                        print('<div class="col-lg-4 col-xs-6">
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
                        
                        print('<div class="col-lg-4 col-xs-6">
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
                        print('<div class="col-lg-4 col-xs-6">
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
                                                                
                                //$css->ColTabla("<strong>Fecha</strong>", 1,"C");                                
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
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>