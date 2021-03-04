<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
include_once("../../../modelo/php_conexion.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new conexion($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //Dibuja el tablero de facturas electronicas
            $TipoListado=$obCon->normalizar($_REQUEST["TipoListado"]);
            $sql="SELECT COUNT(ID) as Total FROM facturas_electronicas_log WHERE Estado=1";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalEmitidos=$DatosTotales["Total"];
            
            $sql="SELECT COUNT(ID) as Total FROM facturas_electronicas_log WHERE Estado>=10 AND Estado<20";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalErrores=$DatosTotales["Total"];
            
            $sql="SELECT COUNT(ID) as Total FROM facturas_electronicas_log WHERE Estado>=20 AND Estado<30";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalPendientes=$DatosTotales["Total"];
            
            $sql="SELECT COUNT(ID) as Total FROM notas_credito WHERE Estado=1";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalNotas=$DatosTotales["Total"];
            
            $sql="SELECT COUNT(ID) as Total FROM notas_credito WHERE Estado=0";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalNotasPendientes=$DatosTotales["Total"];
            
            $TotalRecibidos=0;
            $Opacidad1="opacity:0.3;";  
            $Opacidad2="opacity:0.5;";
            $Opacidad3="opacity:0.5;";
            $Opacidad4="opacity:0.5;";
           
            if($TipoListado==1){
                
                $Opacidad1="opacity:1;";
            }
            if($TipoListado==2){
                
                $Opacidad2="opacity:1;";
            }
            if($TipoListado==3){
                
                $Opacidad3="opacity:1;";
            }
            if($TipoListado==4){
                
                $Opacidad4="opacity:1;";
            }
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-aqua" style="cursor:pointer;'.$Opacidad1.'" onclick=TipoListado=1;VerListado();VerTablero();>
                    <span class="info-box-icon"><i class="fa fa-send"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Facturas</span>
                      <span class="info-box-number">'.number_format($TotalEmitidos).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Doc. Emitidos
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-green" style="cursor:pointer;'.$Opacidad2.'" onclick=TipoListado=2;VerListado();VerTablero();>
                    <span class="info-box-icon"><i class="fa fa-inbox"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Notas Credito</span>
                      <span class="info-box-number">'.number_format($TotalNotas).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Notas Credito
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-yellow" style="cursor:pointer;'.$Opacidad3.'" onclick=TipoListado=3;VerListado();VerTablero();>
                    <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Notas Pendientes</span>
                      <span class="info-box-number">'.number_format($TotalNotasPendientes).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Doc. Pendientes
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-red" style="cursor:pointer;'.$Opacidad4.'" onclick=TipoListado=4;VerListado();VerTablero();>
                    <span class="info-box-icon"><i class="fa fa-warning" ></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Errores</span>
                      <span class="info-box-number">'.number_format($TotalErrores).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Doc. con errores
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
        break; //Fin caso 1
    
        case 2: // se dibuja el listado de facturas electronicas
            $TipoListado=$obCon->normalizar($_REQUEST["TipoListado"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $Condicional="WHERE ID>0 ";
            $OrderBy=" ORDER BY ID DESC";
            $TablaConsulta="vista_listado_facturas_electronicas";
            if($TipoListado==1){ //Documentos enviados
                $Condicional.=" AND Estado=1 ";
                $Titulo="Listado de Documentos Enviados";
                $ColorStatus="blue";
            }
            if($TipoListado==2){ //Notas credito enviadas
                $TablaConsulta="vista_notas_credito_fe";
                $Condicional.=" AND Estado=1 ";
                $Titulo="Listado de Notas Credito Enviadas";
                $ColorStatus="green";
            }
            
            if($TipoListado==3 ){ //Notas credito pendientes
                $TablaConsulta="vista_notas_credito_fe";
                $Condicional.=" AND Estado=0 OR Estado=11";
                $Titulo="Listado de Notas Credito Pendientes";
                $ColorStatus="orange";
            }
            
            if($TipoListado==4 ){ //Documentos pendientes
                $Condicional.=" AND Estado>=10 AND Estado<20 ";
                $Titulo="Listado de Documentos Con Errores";
                $ColorStatus="red";
            }
           
            //Paginacion
            if(isset($_REQUEST['Page'])){
                $NumPage=$obCon->normalizar($_REQUEST['Page']);
            }else{
                $NumPage=1;
            }
            
            if(isset($_REQUEST['Busqueda'])){
                $Busqueda=$obCon->normalizar($_REQUEST['Busqueda']);
                if($Busqueda<>''){
                    $Condicional.=" AND (NumeroFactura LIKE '%$Busqueda%' OR RazonSocialCliente LIKE '%$Busqueda%' OR NIT_Cliente LIKE '%$Busqueda%') ";
                                        
                }
                
            }
                      
                        
            $statement=" `$TablaConsulta` $Condicional ";
            if(isset($_REQUEST['st'])){

                $statement= urldecode($_REQUEST['st']);
                //print($statement);
            }
            
            $limit = 15;
            $startpoint = ($NumPage * $limit) - $limit;
            
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num` FROM {$statement}";
            //print($query);
            $row = $obCon->FetchArray($obCon->Query($query));
            $ResultadosTotales = $row['num'];
            
            $st_reporte=$statement;
            $Limit=" LIMIT $startpoint,$limit";
            
            $query="SELECT * ";
            //print("$query FROM $statement $OrderBy $Limit ");
            $Consulta=$obCon->Query("$query FROM $statement $OrderBy $Limit ");
            $TotalPaginas= ceil($ResultadosTotales/$limit);
            
            $css->CrearDiv("", "box-header with-border", "", 1, 1);
                
                print("<a><strong>$Titulo</strong></a>");
                print('<span class="label label-primary pull-right"><h4><strong>'.$ResultadosTotales.'</strong></h4></span>');
            $css->CerrarDiv();
            
            $css->CrearDiv("", "box-body no-padding", "", 1, 1);
                $css->CrearDiv("", "mailbox-controls", "", 1, 1);
                    print('<button type="button" class="btn btn-default btn-sm" onclick="VerListado()"><i class="fa fa-refresh" title="Refrescar"></i></button>');
                    print(' <button type="button" class="btn btn-default btn-sm" onclick="VerificarAcuseReciboDocumentos()" style="color:green" ><i class="fa fa-bookmark" title="Verificar acuse de recibo"></i></button>');
                    if($TipoListado==4){
                        print(' <button type="button" class="btn btn-default btn-sm" onclick="ActualizarErroresFacturasElectronicas();" style="color:red" title="Actualizar Errores"><i class="fa fa-cogs"></i></button>');
                    }
                    
                    $css->CrearDiv("", "pull-right", "", 1, 1);
                       
                        print('<div class="input-group">');   
                            if($TotalPaginas==0){
                                $TotalPaginas=1;
                            }
                            if($NumPage>1){
                                 $goPage=$NumPage-1;
                                 
                                 print('<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left" onclick="VerListado('.$goPage.')"></i></button>');
                                 
                             }
                            print("Página $NumPage de $TotalPaginas ");
                            
                            
                             
                             if($NumPage<>$TotalPaginas){
                                $goPage=$NumPage+1;
                                print('<button type="button" class="btn btn-default btn-sm" onclick="VerListado('.$goPage.')"><i class="fa fa-chevron-right"></i></button>');
                            
                            }
                        $css->CerrarDiv();
                        
                    $css->CerrarDiv();  
                $css->CerrarDiv();
                
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<tbody>');
                        while($DatosFacturas=$obCon->FetchAssoc($Consulta)){
                            $idItem=$DatosFacturas["ID"];
                            $idFactura=$DatosFacturas["idFactura"];
                            $RutaPDF=$DatosFacturas["RutaPDF"];
                            $RutaXML=$DatosFacturas["RutaXML"];
                            print("<tr>");
                                print("<td class='mailbox-date' style='text-align:center'>");
                                    print("<i class='fa fa-fw fa-circle' style='color:$ColorStatus;cursor:pointer' onclick='VerMensajeFacturaElectronica(`$idItem`)' title='Mensajes API'></i>");
                                print("</td>"); 
                                print("<td class='mailbox-date' style='text-align:center'>");
                                    print("<i class='fa fa-fw fa-commenting' style='color:blue;cursor:pointer' onclick='ObtenerLogsDocumento(`$idItem`,`$TipoListado`)' title='Logs del documento'></i>");
                                print("</td>"); 
                                print("<td class='mailbox-date' style='text-align:center'>");
                                    print("<i class='fa fa-send' style='color:blue;cursor:pointer' onclick='enviar_x_mail(`$idItem`,`$TipoListado`)' title='Enviar por Mail'></i>");
                                print("</td>"); 
                                print("<td class='mailbox-date' style='text-align:center'>");
                                    print("<i class='fa fa-file-pdf-o' style='color:blue;cursor:pointer' onclick='ver_representacion_factura_electronica(`$idFactura`)' title='Ver PDF'></i>");
                                print("</td>"); 
                                print("<td class='mailbox-date' style='text-align:center'>");
                                    if($TipoListado==3){
                                        print("<i class='fa fa-fw fa-code' style='color:blue;cursor:pointer' onclick='VerJSONNotaCreditoFE(`$idItem`)' title='Ver JSON'></i>");
                                    }else{
                                        print("<i class='fa fa-fw fa-code' style='color:blue;cursor:pointer' onclick='VerJSONFacturaElectronica(`$idFactura`)' title='Ver JSON'></i>");
                                    }
                                    
                                print("</td>"); 
                                if($TipoListado==4){
                                    print("<td class='mailbox-date' style='text-align:center'>");
                                        print("<i class='fa fa-share' style='color:red;cursor:pointer' onclick='ReportarFacturaElectronica(`$idFactura`)' title='Generar Factura Electronica Nuevamente'></i>");
                                    print("</td>"); 
                                }
                                
                                if($TipoListado==3){
                                    print("<td class='mailbox-date' style='text-align:center'>");
                                        print("<i class='fa fa-share' style='color:red;cursor:pointer' onclick='ReportarNotaCreditoElectronica(`$idItem`)' title='Enviar Nota Credito Electronica Nuevamente'></i>");
                                    print("</td>"); 
                                }
                                if($TipoListado==1 or $TipoListado==4){
                                    print("<td class='mailbox-date' style='text-align:right'>");
                                        print('<b>'.$DatosFacturas["PrefijoFactura"].'</b>');
                                    print("</td>");
                                }
                                if($TipoListado==2 or $TipoListado==3){
                                    print("<td class='mailbox-date' style='text-align:right'>");
                                        print('<a href="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID='.$idFactura.'" target="_blank"><b>'.$DatosFacturas["ID"].'</b></a>');
                                        //print('<b>'.$DatosFacturas["NumeroFactura"].'</b>');
                                    print("</td>");
                                    
                                }
                                
                                print("<td class='mailbox-date' style='text-align:right'>");
                                    print('<a href="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID='.$idFactura.'" target="_blank"><b>'.$DatosFacturas["NumeroFactura"].'</b></a>');
                                    //print('<b>'.$DatosFacturas["NumeroFactura"].'</b>');
                                print("</td>");
                                
                                
                                if($TipoListado==1 or $TipoListado==4){
                                    print("<td class='mailbox-date' style='text-align:right'>");
                                        print($DatosFacturas["FechaFactura"]);
                                    print("</td>");
                                }
                                if($TipoListado==2 or $TipoListado==3){
                                    print("<td class='mailbox-date' style='text-align:right'>");
                                        print($DatosFacturas["Fecha"]);
                                    print("</td>");
                                }
                                print("<td class='mailbox-date' style='text-align:right'>");
                                    print('<b onclick="ModalEditarTercero(`ModalAcciones`,`DivFrmModalAcciones`,`'.$DatosFacturas["idCliente"].'`,`clientes`);">'.($DatosFacturas["NIT_Cliente"]).'</b>');
                                print("</td>");
                                print("<td class='mailbox-date' style='text-align:left'>");
                                    print(utf8_encode($DatosFacturas["RazonSocialCliente"]));
                                print("</td>");
                                print("<td class='mailbox-date' style='text-align:right'>");
                                    print(utf8_encode(number_format($DatosFacturas["Total"])));
                                print("</td>");
                                if($TipoListado==1 or $TipoListado==2){
                                    
                                    print("<td class='mailbox-date' style='text-align:center'>");
                                        print("<a href='$RutaPDF' target='_blank'><i class='fa fa-file-pdf-o' style='color:green;cursor:pointer;font-size:30px;'></i></a>");
                                    print("</td>"); 
                                    if($TipoListado==1){
                                        print("<td class='mailbox-date' style='text-align:center'>");
                                            print("<a href='$RutaXML' target='_blank'><i class='fa fa-file-zip-o' style='color:#c69900;cursor:pointer;font-size:30px;'></i></a>");
                                        print("</td>"); 
                                    }
                                    
                                }
                                print("<td class='mailbox-date' style='text-align:left'>");
                                    print($DatosFacturas["NombreEstado"]);
                                print("</td>");
                                print("<td class='mailbox-date' style='text-align:left'>");
                                    print($DatosFacturas["NombreEstadoAcuse"]);
                                print("</td>");
                                if($TipoListado==1){
                                    print("<td class='mailbox-date' style='text-align:center'>");
                                        print("<i class='fa fa-remove ' style='color:red;cursor:pointer' onclick='FormularioNuevaNotaCredito($idItem)' title='Nota Credito'></i>");
                                    print("</td>"); 
                                }
                            print("</tr>");
                        }
                        print('</tbody>');
                    $css->CerrarTabla();
                $css->CerrarDiv();
                
                $css->CrearDiv("", "box-footer no-padding", "", 1, 1);
                
                $css->CerrarDiv();
                
                
            $css->CerrarDiv();
            
        break; //Fin caso 2
        
        case 3:// Ver detalles de un documento 
            $idItemFacturasLog=$obCon->normalizar($_REQUEST["idItemFacturasLog"]);
            $TipoListado=$obCon->normalizar($_REQUEST["TipoListado"]);
            
            if($TipoListado==1 or $TipoListado==4){
                $Tabla="facturas_electronicas_log";
            }
            if($TipoListado==2 or $TipoListado==3){
                $Tabla="notas_credito";
            }
            $DatosDocumento=$obCon->DevuelveValores($Tabla, "ID", $idItemFacturasLog);
            $JSONDocumento= json_decode($DatosDocumento["RespuestaCompletaServidor"]);
            $JSONDocumento=str_replace(PHP_EOL, '', $JSONDocumento);
            if(!is_object($JSONDocumento)){
                $JSONDocumento=$DatosDocumento["RespuestaCompletaServidor"];
            }
             
            $css->CrearTitulo("Detalles del Documento $idItemFacturasLog", "verde");
            print("<pre>");
                print_r($JSONDocumento);
            print("</pre>");
        break;//Fin caso 3 
    
        case 4:// Ver el JSON de una Factura Electronica
            include_once("../../../general/clases/facturacion_electronica.class.php");
            $obFactura=new Factura_Electronica($idUser);
                    
            $idFactura=$obCon->normalizar($_REQUEST["idFactura"]);
            $TipoListado=$obCon->normalizar($_REQUEST["TipoListado"]);
            $JSONFactura=$obFactura->JSONFactura($idFactura);
            
            $css->CrearTitulo("JSON para Reporte de Factura electronica $idFactura", "verde");
            print("<pre>");
                print_r($JSONFactura);
            print("</pre>");
        break;//Fin caso 4
    
        case 5://formulario para una Nota credito
            $idFacturaElectronica=$obCon->normalizar($_REQUEST["idFacturaElectronica"]);
            $DatosFacturaElectronica=$obCon->DevuelveValores("vista_listado_facturas_electronicas", "ID", $idFacturaElectronica);
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", "");
            $css->input("hidden", "idFacturaElectronica", "", "idFacturaElectronica", "", 1, "", "", "", "");
            $idFactura=$DatosFacturaElectronica["idFactura"];
            $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $idFactura);
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>DATOS DE LA NOTA CREDITO</strong>", 5,"C");                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha de la Nota:</strong>", 1);                    
                    $css->ColTabla("<strong>Observaciones:</strong>", 4);  
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        $css->input("date", "TxtFecha", "form-control", "TxtFecha", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;'");
                    print("</td>");                  
                    print("<td colspan=4>");
                        $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "", "Observaciones", "", "");
                        
                        $css->Ctextarea(); 
                    print("</td>");    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>DATOS DE LA FACTURA A LA QUE AFECTA LA NOTA</strong>", 5,"C");                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha de la Factura:</strong>", 1);
                    $css->ColTabla("<strong>Numero de Factura:</strong>", 1);
                    $css->ColTabla("<strong>Cliente:</strong>", 1);   
                    $css->ColTabla("<strong>Valor Total de la Factura:</strong>", 1);  
                    $css->ColTabla("<strong>Guardar Nota Credito:</strong>", 1);  
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla($DatosFactura["Fecha"], 1);
                    $css->ColTabla($DatosFactura["Prefijo"].$DatosFactura["NumeroFactura"], 1);
                    $css->ColTabla($DatosFacturaElectronica["RazonSocialCliente"]." ".$DatosFacturaElectronica["NIT_Cliente"], 1);   
                    $css->ColTabla(number_format($DatosFactura["Total"]), 1); 
                    print("<td style='font-size:30px;text-align:center;color:red' title='Borrar'>"); 
                        $css->li("BtnGuardarNota", "fa  fa-save", "", "onclick=ConfirmaGuardarNota(`$idFacturaElectronica`) style=font-size:60px;cursor:pointer;text-align:center;color:green");
                        $css->Cli();
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            $css->CrearDiv("DivItemsFactura", "col-md-6", "left", 1, 1);
                $css->CrearTitulo("<strong>ITEMS DE LA FACTURA:</strong>", "rojo");
                $css->CrearTabla();
                    $css->FilaTabla(12);
                        $css->ColTabla("<strong>REF</strong>", 1);
                        $css->ColTabla("<strong>Producto o Servicio</strong>", 1);
                        //$css->ColTabla("<strong>Precio Unitario</strong>", 1);
                        $css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Subtotal</strong>", 1);
                        $css->ColTabla("<strong>IVA</strong>", 1);
                        $css->ColTabla("<strong>Total</strong>", 1);
                        $css->ColTabla("<strong>Agregar</strong>", 1);
                    $css->CierraFilaTabla();
                    $Consulta=$obCon->ConsultarTabla("facturas_items", " WHERE idFactura='$idFactura'");
                    while($DatosItemsFactura=$obCon->FetchAssoc($Consulta)){
                        $idItem=$DatosItemsFactura["ID"];
                        $css->FilaTabla(12);
                        $css->ColTabla($DatosItemsFactura["Referencia"], 1);
                        $css->ColTabla($DatosItemsFactura["Nombre"], 1);
                        //$css->ColTabla(number_format($DatosItemsFactura["ValorUnitarioItem"]), 1);
                        print("<td>");
                            $css->input("number", "TxtCantidad_".$idItem, "form-control", "TxtCantidad_".$idItem, "cantidad", $DatosItemsFactura["Cantidad"]*$DatosItemsFactura["Dias"], "Cantidad", "off", "", "");
                        print("</td>");
                        
                        $css->ColTabla(number_format($DatosItemsFactura["SubtotalItem"]), 1);
                        $css->ColTabla(number_format($DatosItemsFactura["IVAItem"]), 1);
                        $css->ColTabla(number_format($DatosItemsFactura["TotalItem"]), 1);
                        print("<td style='font-size:30px;text-align:center;color:blue' title='Agregar'>"); 
                            $css->li("BtnAgregarItem_$idItem", "fa  fa-plus-circle", "", "onclick=AgregarItemANota(`$idItem`,`$idFacturaElectronica`) style=font-size:30px;cursor:pointer;text-align:center;color:blue");
                            $css->Cli();
                        print("</td>");
                       
                    $css->CierraFilaTabla();
                    }
                $css->CerrarTabla();
            $css->CerrarDiv();
            $css->CrearDiv("DivItemsNota", "col-md-6", "left", 1, 1);
            
            $css->CerrarDiv();
            print("<br><br><br><br><br><br><br><br><br><br><br><br>");
            print("<br><br><br><br><br><br><br><br><br><br><br><br>");
        break;//Fin caso 5
        
        case 6:// dibuja los items de la nota
            $idFacturaElectronica=$obCon->normalizar($_REQUEST["idFacturaElectronica"]);
            $css->CrearTitulo("<strong>ITEMS DE LA NOTA CREDITO:</strong>", "azul");
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>REF</strong>", 1);
                    $css->ColTabla("<strong>Producto o Servicio</strong>", 1);
                    //$css->ColTabla("<strong>Precio Unitario</strong>", 1);
                    $css->ColTabla("<strong>Cantidad</strong>", 1);
                    $css->ColTabla("<strong>Subtotal</strong>", 1);
                    $css->ColTabla("<strong>IVA</strong>", 1);
                    $css->ColTabla("<strong>Total</strong>", 1);
                    $css->ColTabla("<strong>Accion</strong>", 1);
                $css->CierraFilaTabla();
            $Consulta=$obCon->ConsultarTabla("notas_credito_items", "WHERE idFacturaElectronica='$idFacturaElectronica' AND idNotaCredito=''");
            $Subtotal=0;
            $Impuestos=0;
            $Total=0;
            while($DatosItems=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosItems["ID"];
                $Subtotal=$Subtotal+$DatosItems["SubtotalItem"];
                $Impuestos=$Impuestos+$DatosItems["IVAItem"];
                $Total=$Total+$DatosItems["TotalItem"];
                $css->FilaTabla(14);
                    $css->ColTabla($DatosItems["Referencia"], 1);
                    $css->ColTabla($DatosItems["Nombre"], 1);
                    $css->ColTabla(number_format($DatosItems["Cantidad"]), 1);
                    $css->ColTabla(number_format($DatosItems["SubtotalItem"]), 1);
                    $css->ColTabla(number_format($DatosItems["IVAItem"]), 1);
                    $css->ColTabla(number_format($DatosItems["TotalItem"]), 1);
                    print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>"); 
                        $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`1`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                        $css->Cli();
                    print("</td>");
                $css->CierraFilaTabla();
            }
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Subtotal:</strong>", 5, "R");
                $css->ColTabla("<strong>".number_format($Subtotal)."</strong>", 1, "l");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Impuestos:</strong>", 5, "R");
                $css->ColTabla("<strong>".number_format($Impuestos)."</strong>", 1, "l");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Total:</strong>", 5, "R");
                $css->ColTabla("<strong>".number_format($Total)."</strong>", 1, "l");
            $css->CierraFilaTabla();
            $css->CerrarTabla();
        break;//fin caso 6
        
        case 7:// Ver el JSON de una Nota Credito
            include_once("../../../general/clases/facturacion_electronica.class.php");
            $obFactura=new Factura_Electronica($idUser);
                    
            $idNotaCredito=$obCon->normalizar($_REQUEST["idNota"]);
            $TipoListado=$obCon->normalizar($_REQUEST["TipoListado"]);
            $JSONNota=$obFactura->JSONNotaCredito($idNotaCredito);
            
            $css->CrearTitulo("JSON para Reporte de la Nota Credito $idNotaCredito", "verde");
            print("<pre>");
                print_r($JSONNota);
            print("</pre>");
        break;//Fin caso 7
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>