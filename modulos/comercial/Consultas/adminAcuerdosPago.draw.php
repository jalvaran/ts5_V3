<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
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
            
            if($Busqueda<>''){
                $Condicion.=" AND (ID = '$Busqueda')";
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
                  FROM $Tabla t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Historial de Acuerdos de Pago", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    print("<td>");
                    print("</td>");
                    print("<td>");
                    print("</td>");
                    print("<td>");
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
                
            $css->CierraFilaTabla();

            
                while($DatosAcuerdo=$obCon->FetchAssoc($Consulta)){
                    
                    $idAcuerdo=$DatosAcuerdo["idAcuerdoPago"];
                    
                    $EstadoGeneral=$DatosAcuerdo["NombreEstadoMora"];
                    $EstadoAcuerdo=$DatosAcuerdo["EstadoMora"];
                    
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosAcuerdo["ID"], 1);
                        print("<td style='text-align:center;'>");        
                            print('<span class="input-group-btn">
                                <a class="btn btn-success btn-flat" href="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=37&idAcuerdo='.$idAcuerdo.'&EstadoGeneral='.$EstadoAcuerdo.'" target="_blank"> <i class="fa fa-file-pdf-o"> </i> </a>
                              </span>');
                                
                        print("</td>");
                        print("<td style='text-align:center'>");    
                            print('<span class="input-group-btn">
                                <button type="button" class="btn btn-warning btn-flat" onclick=FormularioAnularAcuerdoPago(`'.$idAcuerdo.'`)> <i class="fa fa-remove"> </i> </button>
                              </span>');
                        print("</td>");  
                        print("<td style='text-align:center'>");        
                            print('<span class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-flat" onclick=FormularioReportarAcuerdoPago(`'.$idAcuerdo.'`)> <i class="fa fa-trash"> </i> </button>
                              </span>');
                                
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
                $Condicion.=" AND (ID = '$Busqueda')";
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
            $Condicion=" WHERE ID>0 ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (ID = '$Busqueda')";
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
            
        break;//fin caso 3
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>