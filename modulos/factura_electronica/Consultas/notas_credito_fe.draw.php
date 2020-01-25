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
        case 1: //Dibuja el formulario para crear una nota credito
            
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", "");
            $css->CrearTitulo("<strong>Crear Nota Credito</strong>", "verde");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Factura que afecta</strong>", 1);
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        $css->input("date", "TxtFecha", "form-control", "TxtFecha", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;'");
                    print("</td>");   
                    print("<td>");
                        $css->select("cmbIdFactura", "form-control", "cmbIdFactura", "", "", "", "style=width:600px");
                            $css->option("", "", "", "", "", "");
                                print("Busque una factura");
                            $css->Coption();
                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "", "Observaciones", "", "");
                        
                        $css->Ctextarea();
                    print("</td>");
                    
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        break; //Fin caso 1
    
        case 2: //Dibuja los items de una nota credito
            $idNota=$obCon->normalizar($_REQUEST["idNota"]);
            $DatosNota=$obCon->DevuelveValores("notas_credito", "ID", $idNota);
            $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $DatosNota["idFactura"]);
            $idFactura=$DatosNota["idFactura"];
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
            print("<strong>Agregar los items a la nota credito $idNota</strong>");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>DATOS DE LA FACTURA A LA QUE AFECTA LA NOTA</strong>", 4,"C");                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha:</strong>", 1);
                    $css->ColTabla("<strong>Numero de Factura:</strong>", 1);
                    $css->ColTabla("<strong>Cliente:</strong>", 1);   
                    $css->ColTabla("<strong>Valor Total de la Factura:</strong>", 1);  
                    $css->ColTabla("<strong>Guardar Nota Credito:</strong>", 1);  
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla($DatosFactura["Fecha"], 1);
                    $css->ColTabla($DatosFactura["Prefijo"].$DatosFactura["NumeroFactura"], 1);
                    $css->ColTabla($DatosCliente["RazonSocial"]." ".$DatosCliente["Num_Identificacion"], 1);   
                    $css->ColTabla(number_format($DatosFactura["Total"]), 1); 
                    print("<td style='font-size:30px;text-align:center;color:red' title='Borrar'>"); 
                        $css->li("BtnGuardarNota", "fa  fa-save", "", "onclick=ConfirmaGuardarNota(`$idNota`) style=font-size:60px;cursor:pointer;text-align:center;color:green");
                        $css->Cli();
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            $css->CrearDiv("DivItemsFactura", "col-md-6", "left", 1, 1);
                $css->CrearTitulo("<strong>ITEMS DE LA FACTURA:</strong>", "rojo");
                $css->CrearTabla();
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>REF</strong>", 1);
                        $css->ColTabla("<strong>Producto o Servicio</strong>", 1);
                        $css->ColTabla("<strong>Precio Unitario</strong>", 1);
                        //$css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Subtotal</strong>", 1);
                        $css->ColTabla("<strong>IVA</strong>", 1);
                        $css->ColTabla("<strong>Total</strong>", 1);
                        $css->ColTabla("<strong>Accion</strong>", 1);
                    $css->CierraFilaTabla();
                    $Consulta=$obCon->ConsultarTabla("facturas_items", " WHERE idFactura='$idFactura'");
                    while($DatosItemsFactura=$obCon->FetchAssoc($Consulta)){
                        $idItem=$DatosItemsFactura["ID"];
                        $css->FilaTabla(14);
                        $css->ColTabla($DatosItemsFactura["Referencia"], 1);
                        $css->ColTabla($DatosItemsFactura["Nombre"], 1);
                        //$css->ColTabla(number_format($DatosItemsFactura["ValorUnitarioItem"]), 1);
                        print("<td>");
                            $css->input("number", "TxtCantidad_".$idItem, "form-control", "TxtCantidad_".$idItem, "cantidad", $DatosItemsFactura["Cantidad"], "Cantidad", "off", "", "");
                        print("</td>");
                        print("<td>");
                            $css->input("number", "TxtMultiplicador_".$idItem, "form-control", "TxtMultiplicador_".$idItem, "multiplicador", $DatosItemsFactura["Dias"], "Cantidad", "off", "", "");
                        print("</td>");
                        $css->ColTabla(number_format($DatosItemsFactura["SubtotalItem"]), 1);
                        $css->ColTabla(number_format($DatosItemsFactura["IVAItem"]), 1);
                        $css->ColTabla(number_format($DatosItemsFactura["TotalItem"]), 1);
                        print("<td>");
                            $css->CrearBotonEvento("BtnAgregarItem_$idItem", "Agregar", 1, "onclick", "AgregarItemANota(`$idItem`,`$idNota`)", "naranja");
                        print("</td>");
                    $css->CierraFilaTabla();
                    }
                $css->CerrarTabla();
            $css->CerrarDiv();
            $css->CrearDiv("DivItemsNota", "col-md-6", "left", 1, 1);
            
            $css->CerrarDiv();
            
        break;// fin caso 2
    
        case 3:// dibujar los items de la nota
            $idNota=$obCon->normalizar($_REQUEST["idNota"]);
            $css->CrearTitulo("<strong>ITEMS DE LA NOTA CREDITO:</strong>", "azul");
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>REF</strong>", 1);
                    $css->ColTabla("<strong>Producto o Servicio</strong>", 1);
                    $css->ColTabla("<strong>Precio Unitario</strong>", 1);
                    //$css->ColTabla("<strong>Cantidad</strong>", 1);
                    $css->ColTabla("<strong>Subtotal</strong>", 1);
                    $css->ColTabla("<strong>IVA</strong>", 1);
                    $css->ColTabla("<strong>Total</strong>", 1);
                    $css->ColTabla("<strong>Accion</strong>", 1);
                $css->CierraFilaTabla();
            $Consulta=$obCon->ConsultarTabla("notas_credito_items", "WHERE idNotaCredito='$idNota'");
            $Subtotal=0;
            $Impuestos=0;
            $Total=0;
            while($DatosItems=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosItems["ID"];
                $Subtotal=$Subtotal+$DatosItems["SubtotalItem"];
                $Impuestos=$Subtotal+$DatosItems["IVAItem"];
                $Total=$Subtotal+$DatosItems["TotalItem"];
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
        break;//fin caso 3    
    
        case 4://Dibuja el tablero de las notas credito
            $TipoListado=$obCon->normalizar($_REQUEST["TipoListado"]);
            $sql="SELECT COUNT(ID) as Total FROM notas_credito WHERE Estado=1";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalEmitidos=$DatosTotales["Total"];
            
            $sql="SELECT COUNT(ID) as Total FROM notas_credito WHERE Estado>=10 AND Estado<20";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalErrores=$DatosTotales["Total"];
            
            $sql="SELECT COUNT(ID) as Total FROM notas_credito WHERE Estado>=20 AND Estado<30";
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
        break;// Fin caso 4    
        
        case 5://Ver el listado de notas credito
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
                      
                        
            $statement=" `vista_notas_credito_fe` $Condicional ";
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
        break;//Fin notas credito    
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>