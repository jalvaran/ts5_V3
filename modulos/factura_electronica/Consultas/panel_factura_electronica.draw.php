<?php

session_start();
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
                      <span class="info-box-text">Enviados</span>
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
                      <span class="info-box-text">Recibidos</span>
                      <span class="info-box-number">'.number_format($TotalRecibidos).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Doc. Recibidos
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-yellow" style="cursor:pointer;'.$Opacidad3.'" onclick=TipoListado=3;VerListado();VerTablero();>
                    <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Pendientes</span>
                      <span class="info-box-number">'.number_format($TotalPendientes).'</span>

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
            $Condicional="WHERE Estado>0 ";
            $OrderBy=" ORDER BY ID DESC";
            if($TipoListado==1){ //Documentos enviados
                $Condicional.=" AND Estado=1 ";
                $Titulo="Listado de Documentos Enviados";
                $ColorStatus="blue";
            }
            if($TipoListado==2){ //Documentos recibidos
                $Condicional.=" AND Estado>=100 AND Estado<150  ";
                $Titulo="Listado de Documentos Recibido";
                $ColorStatus="green";
            }
            
            if($TipoListado==3 ){ //Documentos pendientes
                $Condicional.=" AND Estado>=20 AND Estado<30 ";
                $Titulo="Listado de Documentos Pendientes";
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
                      
                        
            $statement=" `vista_listado_facturas_electronicas` $Condicional ";
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
                                    print("<i class='fa fa-fw fa-circle' style='color:$ColorStatus;cursor:pointer' onclick='VerMensajeFacturaElectronica($idItem)' title='Mensajes API'></i>");
                                print("</td>"); 
                                print("<td class='mailbox-date' style='text-align:center'>");
                                    print("<i class='fa fa-fw fa-code' style='color:blue;cursor:pointer' onclick='VerJSONFacturaElectronica(`$idFactura`)' title='Ver JSON'></i>");
                                print("</td>"); 
                                if($TipoListado==4){
                                    
                                    
                                    print("<td class='mailbox-date' style='text-align:center'>");
                                        print("<i class='fa fa-share' style='color:red;cursor:pointer' onclick='ReportarFacturaElectronica(`$idFactura`)' title='Generar Factura Electronica Nuevamente'></i>");
                                    print("</td>"); 
                                }
                                print("<td class='mailbox-date' style='text-align:right'>");
                                    print('<b>'.$DatosFacturas["PrefijoFactura"].'</b>');
                                print("</td>");
                                print("<td class='mailbox-date' style='text-align:right'>");
                                    print('<a href="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID='.$idFactura.'" target="_blank"><b>'.$DatosFacturas["NumeroFactura"].'</b></a>');
                                    //print('<b>'.$DatosFacturas["NumeroFactura"].'</b>');
                                print("</td>");
                                print("<td class='mailbox-date' style='text-align:right'>");
                                    print($DatosFacturas["FechaFactura"]);
                                print("</td>");
                                print("<td class='mailbox-date' style='text-align:right'>");
                                    print('<b onclick="ModalEditarTercero(`ModalAcciones`,`DivFrmModalAcciones`,`'.$DatosFacturas["idCliente"].'`,`clientes`);">'.($DatosFacturas["NIT_Cliente"]).'</b>');
                                print("</td>");
                                print("<td class='mailbox-date' style='text-align:left'>");
                                    print(utf8_encode($DatosFacturas["RazonSocialCliente"]));
                                print("</td>");
                                print("<td class='mailbox-date' style='text-align:right'>");
                                    print(utf8_encode(number_format($DatosFacturas["Total"])));
                                print("</td>");
                                if($TipoListado==1){
                                    
                                    print("<td class='mailbox-date' style='text-align:center'>");
                                        print("<a href='$RutaPDF' target='_blank'><i class='fa fa-file-pdf-o' style='color:green;cursor:pointer;font-size:30px;'></i></a>");
                                    print("</td>"); 
                                    print("<td class='mailbox-date' style='text-align:center'>");
                                        print("<a href='$RutaXML' target='_blank'><i class='fa fa-file-zip-o' style='color:#c69900;cursor:pointer;font-size:30px;'></i></a>");
                                    print("</td>"); 
                                    
                                }
                                print("<td class='mailbox-date' style='text-align:left'>");
                                    print($DatosFacturas["NombreEstado"]);
                                print("</td>");
                                
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
            $DatosDocumento=$obCon->DevuelveValores("facturas_electronicas_log", "ID", $idItemFacturasLog);
            $JSONFactura= json_decode($DatosDocumento["RespuestaCompletaServidor"]);
            
            $css->CrearTitulo("Detalles del Documento $idItemFacturasLog", "verde");
            print("<pre>");
                print_r($JSONFactura);
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
        break;//Fin caso 3
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>