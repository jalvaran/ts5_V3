<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../clases/AcuerdoPago.class.php");
include_once("../clases/informesAcuerdosPago.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    
    $obCon = new informesAcuerdoPago($idUser);
    switch ($_REQUEST["Accion"]) {
                
        case 1://dibuja El Historial de los acuerdos de pago            
            
            $Tabla="vista_acuerdo_pago";
            $idCambioPagina=1;
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $cmbEstadosAcuerdos=$obCon->normalizar($_REQUEST["cmbEstadosAcuerdos"]);
            
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $cmbCicloPagos=$obCon->normalizar($_REQUEST["cmbCicloPagos"]);
            $Condicion=" WHERE ID>0 ";
            $Order="";
            if($Busqueda<>''){
                $Condicion.=" AND (ID = '$Busqueda' or idAcuerdoPago like '$Busqueda%')";
            }
            
            if($idCliente<>''){
                $Order="ORDER BY Fecha,ID DESC";
                $Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
            if($cmbCicloPagos<>''){
                $Condicion.=" AND (CicloPagos = '$cmbCicloPagos')";
            }
            
            if($cmbEstadosAcuerdos<>''){
                $Condicion.=" AND (Estado = '$cmbEstadosAcuerdos')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(SaldoFinal) as Total
                   FROM $Tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM $Tabla t1 $Condicion $Order LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Historial de Acuerdos de Pago", "verde");
            
            $css->CrearTabla();
                
            print('<thead >');
            $css->FilaTabla(16);
                    print("<th style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</th>");
                    print("<th>");
                    print("</th>");
                    print("<th>");
                    print("</th>");
                    print("<th>");
                    print("</th>");
                    print("<th style='text-align:center'>");
                        print("<strong>Total Saldo:</strong><br>");
                        print("".number_format($Total));
                    print("</th>");
                    
                    print("<th style='text-align:center'>");
                        $Ruta="../../general/procesadores/GeneradorCSV.process.php?Opcion=2&Tabla=$Tabla&c=". base64_encode($Condicion);
                        print('<a href="'.$Ruta.'" target="_blank"><button type="button" id="BtnExportarExcelCuentas" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i></button></a>');
                    print("</th>");
                   
                
                    if($ResultadosTotales>$Limit){

                        //$css->FilaTabla(14);
                            
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);
                            print("<th  style=text-align:center>");
                            //print("<strong>Página: </strong>");
                            
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`$idCambioPagina`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</th>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                $css->ColTabla("<strong>ID</strong>", 1); 
                $css->ColTabla("<strong>Imprimir</strong>", 1); 
                $css->ColTabla("<strong>Ver</strong>", 1);
                $css->ColTabla("<strong>Productos</strong>", 1);
                $css->ColTabla("<strong>PDF</strong>", 1);
                $css->ColTabla("<strong>Anular</strong>", 1);
                $css->ColTabla("<strong>Reportar</strong>", 1);
                $css->ColTabla("<strong>Tercero</strong>", 1);
                $css->ColTabla("<strong>Fecha</strong>", 1);
                $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
                $css->ColTabla("<strong>Valor Cuota General</strong>", 1);
                $css->ColTabla("<strong>CicloPagos</strong>", 1);
                $css->ColTabla("<strong>Saldo Anterior</strong>", 1);
                $css->ColTabla("<strong>Observaciones</strong>", 1);
                $css->ColTabla("<strong>Saldo Inicial</strong>", 1);
                $css->ColTabla("<strong>Total Abonos</strong>", 1);
                $css->ColTabla("<strong>Saldo Final</strong>", 1);
                $css->ColTabla("<strong>Mora</strong>", 1);
                $css->ColTabla("<strong>Estado</strong>", 1);
                $css->ColTabla("<strong>Usuario</strong>", 1);
                $css->ColTabla("<strong>idAcuerdo</strong>", 1);
                
            $css->CierraFilaTabla();
            
            print('</thead>');
            
                while($DatosAcuerdo=$obCon->FetchAssoc($Consulta)){
                    
                    $idAcuerdo=$DatosAcuerdo["idAcuerdoPago"];
                    
                    $EstadoGeneral=$DatosAcuerdo["NombreEstadoMora"];
                    $EstadoAcuerdo=$DatosAcuerdo["EstadoMora"];
                    
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosAcuerdo["ID"], 1);
                        print("<td style='text-align:center'>");    
                            print('<span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat" onclick=ImprimirAcuerdoPago(`'.$idAcuerdo.'`)> <i class="fa fa-print"> </i> </button>
                              </span>');
                        print("</td>");  
                        print("<td style='text-align:center;'>");  
                            print('<button type="button" class="btn btn-success btn-flat" onclick="DibujarAcuerdoPagoExistente(`'.$idAcuerdo.'`,`DivModalAcciones`,`ModalAcciones`)"> <i class="fa fa-eye"> </i> </button>');
                        print("</td>");
                        print("<td style='text-align:center;'>");  
                            print('<button type="button" class="btn btn-secondary btn-flat" onclick="HistorialProductosAcuerdos(`1`,`'.$idAcuerdo.'`)"> <i class="fa fa-list"> </i> </button>');
                        print("</td>");
                        print("<td style='text-align:center;'>");        
                            print('<span class="input-group-btn">
                                <a class="btn btn-primary btn-flat" href="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=37&idAcuerdo='.$idAcuerdo.'&EstadoGeneral='.$EstadoAcuerdo.'" target="_blank"> <i class="fa fa-file-pdf-o"> </i> </a>
                              </span>');
                                
                        print("</td>");
                        print("<td style='text-align:center'>");    
                            if($TipoUser=="administrador"){
                                print('<span class="input-group-btn">
                                    <button type="button" class="btn btn-warning btn-flat" onclick=FormularioAnularAcuerdoPago(`'.$idAcuerdo.'`)> <i class="fa fa-remove"> </i> </button>
                                  </span>');
                            }
                        print("</td>");  
                        print("<td style='text-align:center'>");   
                            if($TipoUser=="administrador"){
                                print('<span class="input-group-btn">
                                    <button type="button" class="btn btn-danger btn-flat" onclick=FormularioReportarAcuerdoPago(`'.$idAcuerdo.'`)> <i class="fa fa-trash"> </i> </button>
                                  </span>');
                            }    
                        print("</td>");
                        
                        $css->ColTabla($DatosAcuerdo["Tercero"]." ".$DatosAcuerdo["RazonSocial"], 1);
                        $css->ColTabla($DatosAcuerdo["Fecha"], 1);
                        $css->ColTabla($DatosAcuerdo["FechaInicialParaPagos"], 1);
                        $css->ColTabla(number_format($DatosAcuerdo["ValorCuotaGeneral"]), 1);
                        $css->ColTabla($DatosAcuerdo["NombreCicloPagos"], 1);
                        $css->ColTabla(number_format($DatosAcuerdo["SaldoAnterior"]), 1);
                        $css->ColTabla($DatosAcuerdo["Observaciones"], 1);
                        $css->ColTabla(number_format($DatosAcuerdo["SaldoInicial"]), 1);
                        $css->ColTabla(number_format($DatosAcuerdo["TotalAbonos"]), 1);
                        $css->ColTabla("<h3>".number_format($DatosAcuerdo["SaldoFinal"])."</h3>", 1);
                        $css->ColTabla($EstadoGeneral, 1);
                        $css->ColTabla($DatosAcuerdo["NombreEstado"], 1);
                        $css->ColTabla($DatosAcuerdo["NombreUsuario"], 1);
                        $css->ColTabla($idAcuerdo, 1);
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 1
        
        
        case 2://dibuja El Historial de la proyeccion de pagos        
            
            $Tabla="vista_acuerdos_pago_proyeccion_historial";
            $idCambioPagina=2;
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $cmbEstadosAcuerdos=$obCon->normalizar($_REQUEST["cmbEstadosAcuerdos"]);
            
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $cmbCicloPagos=$obCon->normalizar($_REQUEST["cmbCicloPagos"]);
            $cmbEstadosProyeccion=$obCon->normalizar($_REQUEST["cmbEstadosProyeccion"]);
            $Condicion=" WHERE ID>0 ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (ID = '$Busqueda' or idAcuerdoPago like '$Busqueda%')";
            }
            
            if($idCliente<>''){
                $Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
            if($cmbCicloPagos<>''){
                $Condicion.=" AND (CicloPagos = '$cmbCicloPagos')";
            }
            
            if($cmbEstadosAcuerdos<>''){
                $Condicion.=" AND (EstadoAcuerdo = '$cmbEstadosAcuerdos')";
            }
            
            if($cmbEstadosProyeccion<>''){
                $Condicion.=" AND (EstadoProyeccion = '$cmbEstadosProyeccion')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(Saldo) as Total
                   FROM $Tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM $Tabla t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Historial de Proyeccion pagos", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total Saldo:</strong><br>");
                        print("".number_format($Total));
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        $Ruta="../../general/procesadores/GeneradorCSV.process.php?Opcion=2&Tabla=$Tabla&c=". base64_encode($Condicion);
                        print('<a href="'.$Ruta.'" target="_blank"><button type="button" id="BtnExportarExcelCuentas" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i></button></a>');
                    print("</td>");
                   
                
                    if($ResultadosTotales>$Limit){

                        //$css->FilaTabla(14);
                            
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);
                            print("<td  style=text-align:center>");
                            //print("<strong>Página: </strong>");
                            
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`$idCambioPagina`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                $css->ColTabla("<strong>ID</strong>", 1);                              
                $css->ColTabla("<strong>Acuerdo</strong>", 1);
                $css->ColTabla("<strong>Tercero</strong>", 1);  
                $css->ColTabla("<strong>CicloPagos</strong>", 1);
                $css->ColTabla("<strong>Fecha</strong>", 1);
                $css->ColTabla("<strong>TipoCuota</strong>", 1);
                $css->ColTabla("<strong>NumeroCuota</strong>", 1);
                $css->ColTabla("<strong>ValorCuota</strong>", 1);
                $css->ColTabla("<strong>ValorPagado</strong>", 1);
                $css->ColTabla("<strong>Saldo</strong>", 1);
                $css->ColTabla("<strong>EstadoProyeccion</strong>", 1);
                $css->ColTabla("<strong>EstadoAcuerdo</strong>", 1);
                
            $css->CierraFilaTabla();

            
                while($DatosAcuerdo=$obCon->FetchAssoc($Consulta)){
                    
                    $css->ColTabla($DatosAcuerdo["ID"], 1);
                    $css->ColTabla($DatosAcuerdo["ConsecutivoAcuerdo"], 1);                        
                    $css->ColTabla($DatosAcuerdo["Tercero"]." ".$DatosAcuerdo["RazonSocial"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreCicloPagos"], 1);
                    $css->ColTabla($DatosAcuerdo["Fecha"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreTipoCuota"], 1);
                    $css->ColTabla($DatosAcuerdo["NumeroCuota"], 1);
                    $css->ColTabla(number_format($DatosAcuerdo["ValorCuota"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["ValorPagado"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["Saldo"]), 1);
                    $css->ColTabla($DatosAcuerdo["NombreEstadoProyeccion"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreEstadoAcuerdo"], 1);

                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 2 
        
        case 3://dibuja El Historial de los abonos
            
            $Tabla="vista_acuerdo_pago_cuotas_pagadas";
            $idCambioPagina=3;
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $cmbEstadosAcuerdos=$obCon->normalizar($_REQUEST["cmbEstadosAcuerdos"]);
            
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $cmbCicloPagos=$obCon->normalizar($_REQUEST["cmbCicloPagos"]);
            $cmbTiposCuota=$obCon->normalizar($_REQUEST["cmbTiposCuota"]);
            $Condicion=" WHERE estado_cuota<10 ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (ID = '$Busqueda' or idAcuerdoPago like '$Busqueda%')";
            }
            
            if($idCliente<>''){
                $Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
            if($cmbCicloPagos<>''){
                $Condicion.=" AND (CicloPagos = '$cmbCicloPagos')";
            }
            
            if($cmbEstadosAcuerdos<>''){
                $Condicion.=" AND (EstadoAcuerdo = '$cmbEstadosAcuerdos')";
            }
            
            if($cmbTiposCuota<>''){
                $Condicion.=" AND (TipoCuota = '$cmbTiposCuota')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(ValorPago) as Total
                   FROM $Tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM $Tabla t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Historial de Pagos realizados", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total Pagos:</strong><br>");
                        print("".number_format($Total));
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        $Ruta="../../general/procesadores/GeneradorCSV.process.php?Opcion=3&Tabla=$Tabla&c=". base64_encode(urlencode($Condicion));
                        print('<a href="'.$Ruta.'" target="_blank"><button type="button" id="BtnExportarExcelCuentas" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i></button></a>');
                    print("</td>");
                   
                
                    if($ResultadosTotales>$Limit){

                        //$css->FilaTabla(14);
                            
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);
                            print("<td  style=text-align:center>");
                            //print("<strong>Página: </strong>");
                            
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`$idCambioPagina`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                $css->ColTabla("<strong>ID</strong>", 1);                              
                $css->ColTabla("<strong>Acuerdo</strong>", 1);
                $css->ColTabla("<strong>Tercero</strong>", 1);  
                $css->ColTabla("<strong>CicloPagos</strong>", 1);
                $css->ColTabla("<strong>Fecha de Abono</strong>", 1);
                $css->ColTabla("<strong>Fecha de la cuota</strong>", 1);
                $css->ColTabla("<strong>TipoCuota</strong>", 1);
                $css->ColTabla("<strong>NumeroCuota</strong>", 1);
                $css->ColTabla("<strong>ValorCuota</strong>", 1);
                $css->ColTabla("<strong>ValorPagado</strong>", 1);
                $css->ColTabla("<strong>Saldo Cuota</strong>", 1);                
                $css->ColTabla("<strong>EstadoAcuerdo</strong>", 1);
                $css->ColTabla("<strong>Cierre</strong>", 1);
                
            $css->CierraFilaTabla();

            
                while($DatosAcuerdo=$obCon->FetchAssoc($Consulta)){
                    
                    $css->ColTabla($DatosAcuerdo["ID"], 1);
                    $css->ColTabla($DatosAcuerdo["ConsecutivoAcuerdo"], 1);                        
                    $css->ColTabla($DatosAcuerdo["Tercero"]." ".$DatosAcuerdo["RazonSocial"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreCicloPagos"], 1);
                    $css->ColTabla($DatosAcuerdo["Created"], 1);
                    $css->ColTabla($DatosAcuerdo["Fecha"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreTipoCuota"], 1);
                    $css->ColTabla($DatosAcuerdo["NumeroCuota"], 1);
                    $css->ColTabla(number_format($DatosAcuerdo["ValorCuota"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["ValorPago"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoCuota"]), 1);
                    
                    $css->ColTabla($DatosAcuerdo["NombreEstadoAcuerdo"], 1);
                    $css->ColTabla($DatosAcuerdo["idCierre"], 1);

                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 3
        
        case 4://dibuja la reconstruccion de cuenta de un cliente
            
            $Tabla="librodiario";
            $idCambioPagina=4;
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            if($idCliente==''){
                $css->CrearTitulo("<strong>Debe seleccionar un Cliente</strong>", "rojo");
                exit();
            }
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            
            $Condicion=" WHERE CuentaPUC like '1305%' ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (Tipo_Documento_Intero like '%$Busqueda%' or Concepto like '%$Busqueda%')";
            }
            
            if($idCliente<>''){
                $Condicion.=" AND (Tercero_Identificacion = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
                                    
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(idLibroDiario) as Items,SUM(Neto) as Total
                   FROM $Tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM $Tabla t1 $Condicion ORDER BY idLibroDiario DESC LIMIT $PuntoInicio,$Limit;";
            
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Reconstruccion de cuenta", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total Movimientos:</strong><br>");
                        print("".number_format($Total));
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        $Ruta="../../general/procesadores/GeneradorCSV.process.php?Opcion=2&Tabla=$Tabla&c=". base64_encode($Condicion);
                        print('<a href="'.$Ruta.'" target="_blank"><button type="button" id="BtnExportarExcelCuentas" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i></button></a>');
                    print("</td>");
                   
                
                    if($ResultadosTotales>$Limit){

                        //$css->FilaTabla(14);
                            
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);
                            print("<td  style=text-align:center>");
                            //print("<strong>Página: </strong>");
                            
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`$idCambioPagina`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                $css->ColTabla("<strong>ID</strong>", 1);     
                $css->ColTabla("<strong>Tercero</strong>", 1);  
                $css->ColTabla("<strong>Fecha</strong>", 1);
                $css->ColTabla("<strong>Documento</strong>", 1);
                $css->ColTabla("<strong>Identificador</strong>", 1);
                $css->ColTabla("<strong>Referencia</strong>", 1);                
                $css->ColTabla("<strong>CuentaPUC</strong>", 1);
                $css->ColTabla("<strong>NombreCuenta</strong>", 1);
                $css->ColTabla("<strong>Detalle</strong>", 1);
                $css->ColTabla("<strong>Debito</strong>", 1);
                $css->ColTabla("<strong>Credito</strong>", 1);
                $css->ColTabla("<strong>Neto</strong>", 1);
                                
            $css->CierraFilaTabla();

            
                while($DatosAcuerdo=$obCon->FetchAssoc($Consulta)){
                    
                    $css->ColTabla($DatosAcuerdo["idLibroDiario"], 1);
                    $css->ColTabla($DatosAcuerdo["Tercero_Identificacion"]." ".$DatosAcuerdo["Tercero_Razon_Social"], 1);
                    $css->ColTabla($DatosAcuerdo["Fecha"], 1);                        
                    
                    $css->ColTabla($DatosAcuerdo["Tipo_Documento_Intero"], 1);
                    $css->ColTabla($DatosAcuerdo["Num_Documento_Interno"], 1);
                    $css->ColTabla($DatosAcuerdo["Num_Documento_Externo"], 1);
                    $css->ColTabla($DatosAcuerdo["CuentaPUC"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreCuenta"], 1);
                    $css->ColTabla($DatosAcuerdo["Concepto"], 1);
                    $css->ColTabla(number_format($DatosAcuerdo["Debito"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["Credito"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["Neto"]), 1);
                    
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 4
        
        
        case 5://dibuja El Historial de los productos de un acuerdo de pago
            
            $Tabla="vista_acuerdo_pago_productos";
            $idCambioPagina=5;
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            $cmbEstadosAcuerdos=$obCon->normalizar($_REQUEST["cmbEstadosAcuerdos"]);
            
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            
            $Condicion=" WHERE ID>0 ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (idAcuerdoPago like '$Busqueda%' or Nombre like '%$Busqueda%')";
            }
            
            if($idCliente<>''){
                $Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
                        
            if($cmbEstadosAcuerdos<>''){
                $Condicion.=" AND (EstadoAcuerdo = '$cmbEstadosAcuerdos')";
            }
            
            if($idAcuerdoPago<>''){
                $Condicion.=" AND (idAcuerdoPago = '$idAcuerdoPago')";
            }
            
                                    
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(TotalItem) as Total
                   FROM $Tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM $Tabla t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Historial de Productos en Acuerdos", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total:</strong><br>");
                        print("".number_format($Total));
                    print("</td>");
                    
                    
                
                    if($ResultadosTotales>$Limit){

                        //$css->FilaTabla(14);
                            
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);
                            print("<td  style=text-align:center>");
                            //print("<strong>Página: </strong>");
                            
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`$idCambioPagina`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                $css->ColTabla("<strong>ID</strong>", 1);
                $css->ColTabla("<strong>Devolver</strong>", 1);
                $css->ColTabla("<strong>Fecha</strong>", 1);
                $css->ColTabla("<strong>Acuerdo</strong>", 1);
                $css->ColTabla("<strong>Tercero</strong>", 1);
                $css->ColTabla("<strong>Referencia</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>ValorUnitarioItem</strong>", 1);
                $css->ColTabla("<strong>Cantidad</strong>", 1);
                
                $css->ColTabla("<strong>SubtotalItem</strong>", 1);                
                $css->ColTabla("<strong>IVAItem</strong>", 1);
                $css->ColTabla("<strong>TotalItem</strong>", 1);
                $css->ColTabla("<strong>SubtotalCosto</strong>", 1);
                
            $css->CierraFilaTabla();

            
                while($DatosAcuerdo=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosAcuerdo["ID"];
                    $idAcuerdo=$DatosAcuerdo["idAcuerdoPago"];
                    $css->ColTabla($DatosAcuerdo["ID"], 1);
                    print("<td style='text-align:center'>");   
                        if($TipoUser=="administrador"){
                            print('<span class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-flat" onclick=FormularioDevolverItem(`'.$idAcuerdo.'`,`'.$idItem.'`)> <i class="fa fa-remove"> </i> </button>
                              </span>');
                        }
                    print("</td>"); 
                    $css->ColTabla($DatosAcuerdo["Fecha"], 1);
                    $css->ColTabla($DatosAcuerdo["ConsecutivoAcuerdo"], 1);                        
                    $css->ColTabla($DatosAcuerdo["Tercero"]." ".$DatosAcuerdo["RazonSocial"], 1);
                    $css->ColTabla($DatosAcuerdo["Referencia"], 1);
                    $css->ColTabla($DatosAcuerdo["Nombre"], 1);
                    
                    $css->ColTabla(number_format($DatosAcuerdo["ValorUnitarioItem"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["Cantidad"]), 1);
                    
                    
                    
                    $css->ColTabla(number_format($DatosAcuerdo["SubtotalItem"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["IVAItem"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["TotalItem"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["SubtotalCosto"]), 1);
                    
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 5
        
        case 6:// Historial productos devueltos en acuerdos 
            $Tabla="vista_productos_devueltos_acuerdos";
            $idCambioPagina=6;
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            $cmbEstadosAcuerdos=$obCon->normalizar($_REQUEST["cmbEstadosAcuerdos"]);
            $obCon->CrearVistaProductosDevueltosAcuerdoPago();
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            
            $Condicion=" WHERE ID>0 ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (idAcuerdoPago like '$Busqueda%' or Nombre like '%$Busqueda%')";
            }
            
            if($idCliente<>''){
                //$Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
                        
            if($cmbEstadosAcuerdos<>''){
                //$Condicion.=" AND (EstadoAcuerdo = '$cmbEstadosAcuerdos')";
            }
            
            if($idAcuerdoPago<>''){
                //$Condicion.=" AND (idAcuerdoPago = '$idAcuerdoPago')";
            }
            
                                    
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(ValorDevolucion) as Total
                   FROM $Tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM $Tabla t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Historial de Productos Devueltos en Acuerdos", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total:</strong><br>");
                        print("".number_format($Total));
                    print("</td>");
                    
                    
                
                    if($ResultadosTotales>$Limit){

                        //$css->FilaTabla(14);
                            
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);
                            print("<td  style=text-align:center>");
                            //print("<strong>Página: </strong>");
                            
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`$idCambioPagina`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                //$css->ColTabla("<strong>ID</strong>", 1);                
                $css->ColTabla("<strong>Fecha</strong>", 1);
                $css->ColTabla("<strong>Acuerdo</strong>", 1);
                //$css->ColTabla("<strong>Tercero</strong>", 1);
                $css->ColTabla("<strong>Referencia</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>ValorDevolucion</strong>", 1);
                $css->ColTabla("<strong>Cantidad</strong>", 1);                
                $css->ColTabla("<strong>Observaciones</strong>", 1);                
                $css->ColTabla("<strong>idUser</strong>", 1);        
                
            $css->CierraFilaTabla();

            
                while($DatosAcuerdo=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosAcuerdo["ID"];
                    $idAcuerdo=$DatosAcuerdo["idAcuerdoPago"];
                    //$css->ColTabla($DatosAcuerdo["ID"], 1);
                    
                    $css->ColTabla($DatosAcuerdo["Fecha"], 1);
                    $css->ColTabla($DatosAcuerdo["ConsecutivoAcuerdo"], 1);                        
                    //$css->ColTabla($DatosAcuerdo["Tercero"]." ".$DatosAcuerdo["RazonSocial"], 1);
                    $css->ColTabla($DatosAcuerdo["Referencia"], 1);
                    $css->ColTabla($DatosAcuerdo["Nombre"], 1);
                    
                    $css->ColTabla(number_format($DatosAcuerdo["ValorDevolucion"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["Cantidad"]), 1);
                    $css->ColTabla(($DatosAcuerdo["Observaciones"]), 1);
                    $css->ColTabla(($DatosAcuerdo["idUser"]), 1);
                    
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
        break; //Fin caso 6 
        
        case 7:// Historial anulacion de abonos 
            $Tabla="vista_abonos_acuerdo_pago_anulados";
            $idCambioPagina=3;
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $cmbEstadosAcuerdos=$obCon->normalizar($_REQUEST["cmbEstadosAcuerdos"]);
            
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $cmbCicloPagos=$obCon->normalizar($_REQUEST["cmbCicloPagos"]);
            $cmbTiposCuota=$obCon->normalizar($_REQUEST["cmbTiposCuota"]);
            $Condicion=" WHERE ID>0 ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (ID = '$Busqueda' or idAcuerdoPago like '$Busqueda%')";
            }
            
            if($idCliente<>''){
                $Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
            if($cmbCicloPagos<>''){
                $Condicion.=" AND (CicloPagos = '$cmbCicloPagos')";
            }
            
            if($cmbEstadosAcuerdos<>''){
                $Condicion.=" AND (EstadoAcuerdo = '$cmbEstadosAcuerdos')";
            }
            
            if($cmbTiposCuota<>''){
                $Condicion.=" AND (TipoCuota = '$cmbTiposCuota')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(ValorPago) as Total
                   FROM $Tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM $Tabla t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Historial de Pagos realizados", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total Pagos:</strong><br>");
                        print("".number_format($Total));
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        $Ruta="../../general/procesadores/GeneradorCSV.process.php?Opcion=2&Tabla=$Tabla&c=". base64_encode($Condicion);
                        print('<a href="'.$Ruta.'" target="_blank"><button type="button" id="BtnExportarExcelCuentas" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i></button></a>');
                    print("</td>");
                   
                
                    if($ResultadosTotales>$Limit){

                        //$css->FilaTabla(14);
                            
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);
                            print("<td  style=text-align:center>");
                            //print("<strong>Página: </strong>");
                            
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`$idCambioPagina`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`'.$idCambioPagina.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                $css->ColTabla("<strong>ID</strong>", 1);                              
                $css->ColTabla("<strong>Acuerdo</strong>", 1);
                $css->ColTabla("<strong>Tercero</strong>", 1);  
                $css->ColTabla("<strong>CicloPagos</strong>", 1);
                $css->ColTabla("<strong>Fecha</strong>", 1);
                $css->ColTabla("<strong>TipoCuota</strong>", 1);
                $css->ColTabla("<strong>NumeroCuota</strong>", 1);
                $css->ColTabla("<strong>ValorCuota</strong>", 1);
                $css->ColTabla("<strong>ValorPagado</strong>", 1);
                $css->ColTabla("<strong>Saldo Cuota</strong>", 1);                
                $css->ColTabla("<strong>EstadoAcuerdo</strong>", 1);
                
            $css->CierraFilaTabla();

            
                while($DatosAcuerdo=$obCon->FetchAssoc($Consulta)){
                    
                    $css->ColTabla($DatosAcuerdo["ID"], 1);
                    $css->ColTabla($DatosAcuerdo["ConsecutivoAcuerdo"], 1);                        
                    $css->ColTabla($DatosAcuerdo["Tercero"]." ".$DatosAcuerdo["RazonSocial"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreCicloPagos"], 1);
                    $css->ColTabla($DatosAcuerdo["Fecha"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreTipoCuota"], 1);
                    $css->ColTabla($DatosAcuerdo["NumeroCuota"], 1);
                    $css->ColTabla(number_format($DatosAcuerdo["ValorCuota"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["ValorPago"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoCuota"]), 1);
                    
                    $css->ColTabla($DatosAcuerdo["NombreEstadoAcuerdo"], 1);

                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
        break; //Fin caso 7
    
        case 8:// Historial productos de acuerdos devueltos
            
        break; //Fin caso 8
        
        case 9:// formulario para anular un producto
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            
            $DatosProducto=$obCon->DevuelveValores("facturas_items", "ID", $idItem);
            $idAcuerdo=$DatosProducto["NumeroIdentificador"];
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            $DatosTercero=$obCon->DevuelveValores("clientes", "Num_Identificacion", $DatosAcuerdo["Tercero"]);
            $sql="SELECT sum(Cantidad) as CantidadDevoluciones FROM acuerdo_pago_productos_devueltos WHERE idFacturasItems='$idItem'";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $CantidadDevuelta=$DatosConsulta["CantidadDevoluciones"];
            if($CantidadDevuelta==''){
                $CantidadDevuelta=0;
            }
            $CantidadDisponibleADevolver=$DatosProducto["Cantidad"]-$CantidadDevuelta;
            if($CantidadDisponibleADevolver<=0){
                $css->CrearTitulo("<strong>Este producto no tiene cantidades disponibles para devolver</strong>");
                exit("");
            }
            
            
                print('<span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-flat" onclick=FormularioDevolverItem(`'.$idAcuerdo.'`,`'.$idItem.'`)> <i class="fa fa-refresh"> </i> </button>
                  </span>');
            
            $css->input("hidden", "idItemDevolucionAcuerdo", "", "idItemDevolucionAcuerdo", "", $idItem, "", "", "", "");
            
            $ValorUnitario=round($DatosProducto["TotalItem"]/$DatosProducto["Cantidad"]);
            $ValorADevolver=$ValorUnitario*$CantidadDisponibleADevolver;
            $css->CrearTitulo("<strong>Devolución de un producto</strong>");
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Datos del Cliente</strong>", 4,'C');
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    $css->ColTabla("<strong>Razon Social</strong>", 1);
                    $css->ColTabla("<strong>Direccion</strong>", 1);
                    $css->ColTabla("<strong>Telefono</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla($DatosTercero["Num_Identificacion"], 1);
                    $css->ColTabla($DatosTercero["RazonSocial"], 1);
                    $css->ColTabla($DatosTercero["Direccion"], 1);
                    $css->ColTabla($DatosTercero["Telefono"], 1);
                $css->CierraFilaTabla();
                
                
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Datos del Producto</strong>", 4,'C');
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Referencia</strong>", 1);
                    $css->ColTabla("<strong>Producto</strong>", 1);
                    $css->ColTabla("<strong>Cantidad</strong>", 1);
                    $css->ColTabla("<strong>Devoluciones</strong>", 1);
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(16);
                    $css->ColTabla($DatosProducto["Referencia"], 1);
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    $css->ColTabla(($DatosProducto["Cantidad"]), 1);
                    $css->ColTabla($CantidadDevuelta, 1);
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Valor Unitario</strong>", 1);
                    $css->ColTabla("<strong>Total Disponible</strong>", 1);
                    $css->ColTabla("<strong>Cantidad</strong>", 1);
                    $css->ColTabla("<strong>Observacion</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(number_format($DatosProducto["TotalItem"]), 1);
                    $css->ColTabla(number_format($ValorADevolver), 1);
                    print("<td>");
                        $css->input("number", "Cantidad_Devolucion_Acuerdo_Pago", "form-control", "Cantidad_Devolucion", "", $CantidadDisponibleADevolver, "Cantidad", "off", "", "onchange=FormularioAbonarAcuerdoPago(`$idAcuerdo`,`DivAbonosDevolucion`,`1`)");
                        
                    print("</td>"); 
                    print("<td>");
                        $css->textarea("TxtObservacionesDevolucion", "form-control", "TxtObservacionesDevolucion", "", "Observaciones", "", "");
                        $css->Ctextarea();
                    print("</td>");
                $css->CierraFilaTabla();
                
            $css->CerrarTabla();
            
            $css->CrearDiv("DivAbonosDevolucion", "", "", 1, 1);
            $css->CerrarDiv();
            
            
        break; //Fin caso 9
        
        case 10://Formulario para Anular un acuerdo de pago
            
            $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdoPago);
            if($DatosAcuerdo["Estado"]>=10){
                $css->Notificacion("Error", "Este Acuerdo ya está anulado", "naranja", "", "");
                exit();
            }
            $DatosTercero=$obCon->DevuelveValores("clientes", "Num_Identificacion", $DatosAcuerdo["Tercero"]);
            $css->CrearTabla();
            
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ANULAR EL ACUERDO DE PAGO $DatosAcuerdo[ID]</strong>", 4, "C");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha:</strong>", 2, "L");
                    $css->ColTabla($DatosAcuerdo["Fecha"], 2, "L");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Cliente:</strong>", 1, "L");
                    $css->ColTabla($DatosTercero["RazonSocial"], 1, "L");
                    $css->ColTabla("<strong>Identificación:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosTercero["Num_Identificacion"]), 1, "L");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Saldo Anterior:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoAnterior"]), 1, "L");
                    $css->ColTabla("<strong>Saldo Inicial:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoInicial"]), 1, "L");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Total Abonos:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosAcuerdo["TotalAbonos"]), 1, "L");
                    $css->ColTabla("<strong>SaldoFinal:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoFinal"]), 1, "L");
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td colspan=4>");
                        $css->textarea("ObservacionesAnulacion", "form-control", "ObservacionesAnulacion", "", "Observaciones", "", "");
                        $css->Ctextarea();
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td colspan=3>");
                        
                    print("</td>");
                    print("<td colspan=1>");
                        $css->CrearBotonEvento("btnAnularAcuerdo", "Anular", 1, "onclick", "ConfirmeAnularAcuerdo(`$idAcuerdoPago`)", "rojo");
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
        break;//Fin caso 10
        
        case 11://Formulario para Anular un abono
            
            $idAbono=$obCon->normalizar($_REQUEST["idAbono"]);
            $DatosAbono=$obCon->DevuelveValores("acuerdo_pago_cuotas_pagadas", "ID", $idAbono);
            
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $DatosAbono["idAcuerdoPago"]);
            if($DatosAcuerdo["Estado"]>=10 ){
                $css->Notificacion("Error", "Este Acuerdo está anulado", "naranja", "", "");
                exit();
            }
            if($DatosAbono["Estado"]>=10){
                $css->Notificacion("Error", "Este Abono ya está anulado", "naranja", "", "");
                exit();
            }
            $DatosTercero=$obCon->DevuelveValores("clientes", "Num_Identificacion", $DatosAcuerdo["Tercero"]);
            $css->CrearTabla();
            
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ANULAR EL ABONO $idAbono por valor de $DatosAbono[ValorPago], del Acuerdo $DatosAcuerdo[ID]</strong>", 4, "C");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha:</strong>", 2, "L");
                    $css->ColTabla($DatosAbono["Created"], 2, "L");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Cliente:</strong>", 1, "L");
                    $css->ColTabla($DatosTercero["RazonSocial"], 1, "L");
                    $css->ColTabla("<strong>Identificación:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosTercero["Num_Identificacion"]), 1, "L");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Valor Del Abono:</strong>", 2, "L");
                    $css->ColTabla(number_format($DatosAbono["ValorPago"]), 2, "L");
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td colspan=4>");
                        $css->textarea("ObservacionesAnulacion", "form-control", "ObservacionesAnulacion", "", "Observaciones", "", "");
                        $css->Ctextarea();
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td colspan=3>");
                        
                    print("</td>");
                    print("<td colspan=1>");
                        $css->CrearBotonEvento("btnAnularAbono", "Anular", 1, "onclick", "ConfirmeAnularAbono(`$idAbono`)", "rojo");
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
        break;//Fin caso 11
        
        case 12://Formulario para Reportar  un acuerdo de pago
            
            $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdoPago);
            if($DatosAcuerdo["Estado"]>=10){
                $css->Notificacion("Error", "Este Acuerdo ya está reportado o anulado", "rojo", "", "");
                exit();
            }
            $DatosTercero=$obCon->DevuelveValores("clientes", "Num_Identificacion", $DatosAcuerdo["Tercero"]);
            $css->CrearTabla();
            
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>DESCARTAR EL ACUERDO DE PAGO $DatosAcuerdo[ID], Y BETAR EL CLIENTE</strong>", 4, "C");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha:</strong>", 2, "L");
                    $css->ColTabla($DatosAcuerdo["Fecha"], 2, "L");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Cliente:</strong>", 1, "L");
                    $css->ColTabla($DatosTercero["RazonSocial"], 1, "L");
                    $css->ColTabla("<strong>Identificación:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosTercero["Num_Identificacion"]), 1, "L");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Saldo Anterior:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoAnterior"]), 1, "L");
                    $css->ColTabla("<strong>Saldo Inicial:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoInicial"]), 1, "L");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Total Abonos:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosAcuerdo["TotalAbonos"]), 1, "L");
                    $css->ColTabla("<strong>SaldoFinal:</strong>", 1, "L");
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoFinal"]), 1, "L");
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td colspan=4>");
                        $css->textarea("ObservacionesAnulacion", "form-control", "ObservacionesAnulacion", "", "Observaciones", "", "");
                        $css->Ctextarea();
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td colspan=3>");
                        
                    print("</td>");
                    print("<td colspan=1>");
                        $css->CrearBotonEvento("btnReportarAcuerdo", "Reportar este Acuerdo", 1, "onclick", "ConfirmeReportarAcuerdo(`$idAcuerdoPago`)", "rojo");
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
        break;//Fin caso 12
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>