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
                
        case 1://dibuja la vista de las cuenta x cobrar
            
            
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $cmbCicloPagos=$obCon->normalizar($_REQUEST["cmbCicloPagos"]);
            $Condicion=" WHERE ID>0 ";
            
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
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(ValorCuota) as Total
                   FROM acuerdo_pago_hoja_trabajo_informes t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $TotalCobros=$totales["Total"];
            
            $sql="SELECT *
                  FROM acuerdo_pago_hoja_trabajo_informes t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Listado de Cuentas x Cobrar", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total X Cobrar:</strong><br>");
                        print("".number_format($TotalCobros));
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        $Ruta="procesadores/informesAcuerdoPago.process.php?Accion=2&FechaInicialRangos=$FechaInicialRangos&FechaFinalRangos=$FechaFinalRangos&c=".base64_encode($Condicion);
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
                            print('<span class="input-group-addon" onclick=CambiePagina('.$NumPage1.') style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina();";
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
                            print('<span class="input-group-addon" onclick=CambiePagina('.$NumPage1.') style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                $css->ColTabla("<strong>ID</strong>", 1, "C");
                $css->ColTabla("<strong>Acuerdo</strong>", 1, "C");
                $css->ColTabla("<strong>Tercero</strong>", 1, "C"); 
                $css->ColTabla("<strong>Fecha</strong>", 1, "C"); 
                $css->ColTabla("<strong>Tipo de Cuota</strong>", 1, "C");
                $css->ColTabla("<strong>Numero de Cuota</strong>", 1, "C");                
                $css->ColTabla("<strong>Valor de Cuota</strong>", 1, "C"); 
                $css->ColTabla("<strong>Valor Pagado</strong>", 1, "C");
                $css->ColTabla("<strong>Saldo Cuota</strong>", 1, "C");
                $css->ColTabla("<strong>Estado</strong>", 1, "C");
                
            $css->CierraFilaTabla();

            
                while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                    
                    $idItem=$RegistrosTabla["ID"];
                    $css->FilaTabla(16);
                        
                        $css->ColTabla($RegistrosTabla["ID"], 1, "L");
                        $css->ColTabla($RegistrosTabla["ConsecutivoAcuerdo"], 1, "L");
                        $css->ColTabla(utf8_encode($RegistrosTabla["RazonSocial"]." || ".$RegistrosTabla["SobreNombreCliente"]." || ".$RegistrosTabla["TelefonoCliente"]." || ".$RegistrosTabla["Tercero"]), 1, "L");
                        $css->ColTabla($RegistrosTabla["Fecha"], 1, "L");
                        $css->ColTabla(($RegistrosTabla["NombreTipoCuota"]), 1, "L");         
                        $css->ColTabla($RegistrosTabla["NumeroCuota"], 1, "L");
                        $css->ColTabla(number_format($RegistrosTabla["ValorCuota"]), 1, "L");
                        $css->ColTabla(number_format($RegistrosTabla["ValorPagado"]), 1, "L");
                        $css->ColTabla(number_format($RegistrosTabla["SaldoCuota"]), 1, "L");
                        $css->ColTabla($RegistrosTabla["NombreEstadoProyeccion"], 1, "L");
                        
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 1
        
        
        case 2://dibuja la vista de los productos adquiridos por un cliente por un acuerdo de pago
            
            
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            
            $Condicion=" WHERE ID>0 ";
            
            if($idCliente<>''){
                $Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
                                    
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(TotalItem) as Total
                   FROM vista_productos_facturas_acuerdo t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM vista_productos_facturas_acuerdo t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Listado de productos adquiridos en acuerdos de pago", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total:</strong><br>");
                        print("".number_format($Total));
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        $Ruta="../../general/procesadores/GeneradorCSV.process.php?Opcion=2&Tabla=vista_productos_facturas_acuerdo&c=". base64_encode($Condicion);
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`2`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`2`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`2`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                $css->ColTabla("<strong>ID</strong>", 1, "C");
                $css->ColTabla("<strong>Tercero</strong>", 1, "C");
                $css->ColTabla("<strong>Fecha</strong>", 1, "C");
                $css->ColTabla("<strong>Hora</strong>", 1, "C"); 
                $css->ColTabla("<strong>Prefijo</strong>", 1, "C"); 
                $css->ColTabla("<strong>NumeroFactura</strong>", 1, "C");
                $css->ColTabla("<strong>Referencia</strong>", 1, "C");                
                $css->ColTabla("<strong>Nombre</strong>", 1, "C"); 
                $css->ColTabla("<strong>TotalItem</strong>", 1, "C");
                               
            $css->CierraFilaTabla();

            
                while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                    
                    $idItem=$RegistrosTabla["ID"];
                    $css->FilaTabla(16);
                        
                        $css->ColTabla($RegistrosTabla["ID"], 1, "L");
                        $css->ColTabla($RegistrosTabla["Tercero"], 1, "L");
                        
                        $css->ColTabla($RegistrosTabla["Fecha"], 1, "L");
                        $css->ColTabla(($RegistrosTabla["Hora"]), 1, "L");         
                        $css->ColTabla($RegistrosTabla["Prefijo"], 1, "L");
                        $css->ColTabla($RegistrosTabla["NumeroFactura"], 1, "L");
                        $css->ColTabla($RegistrosTabla["Referencia"], 1, "L");
                        $css->ColTabla($RegistrosTabla["Nombre"], 1, "L");
                        $css->ColTabla(number_format($RegistrosTabla["TotalItem"]), 1, "L");
                                                
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 2
        
        case 3://dibuja la vista de los abonos realizados por un cliente
            
            
            $Limit=15;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            
            $Condicion=" WHERE ID>0 ";
            
            if($idCliente<>''){
                $Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
                                    
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(ValorPago) as Total
                   FROM vista_abonos_acuerdo_pago t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $Total=$totales["Total"];
            
            $sql="SELECT *
                  FROM vista_abonos_acuerdo_pago t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Listado de abonos de acuerdos de pago", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total:</strong><br>");
                        print("".number_format($Total));
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        $Ruta="../../general/procesadores/GeneradorCSV.process.php?Opcion=2&Tabla=vista_abonos_acuerdo_pago&c=". base64_encode($Condicion);
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`3`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(``,`3`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`'.$NumPage1.'`,`3`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                $css->ColTabla("<strong>ID</strong>", 1, "C");
                $css->ColTabla("<strong>Tercero</strong>", 1, "C");
                $css->ColTabla("<strong>Fecha</strong>", 1, "C");
                $css->ColTabla("<strong>Acuerdo</strong>", 1, "C"); 
                $css->ColTabla("<strong>Cuota</strong>", 1, "C"); 
                $css->ColTabla("<strong>Valor Pagado</strong>", 1, "C");
                $css->ColTabla("<strong>Metodo</strong>", 1, "C");                
                $css->ColTabla("<strong>Recibe</strong>", 1, "C"); 
                              
            $css->CierraFilaTabla();

            
                while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                    
                    $idItem=$RegistrosTabla["ID"];
                    $css->FilaTabla(16);
                        
                        $css->ColTabla($RegistrosTabla["ID"], 1, "L");
                        $css->ColTabla($RegistrosTabla["Tercero"], 1, "L");
                        
                        $css->ColTabla($RegistrosTabla["Created"], 1, "L");
                        $css->ColTabla(($RegistrosTabla["ConsecutivoAcuerdo"]), 1, "L");         
                        $css->ColTabla($RegistrosTabla["NumeroCuota"], 1, "L");
                        $css->ColTabla(number_format($RegistrosTabla["ValorPago"]), 1, "L");
                        $css->ColTabla($RegistrosTabla["NombreMetodoPago"], 1, "L");
                        $css->ColTabla($RegistrosTabla["NombreUsuario"], 1, "L");
                                                
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 3
        
        case 4:// Dibuja el informe de gestion de cartera
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            
            if($FechaInicialRangos==''){
                $css->CrearTitulo("Debe seleccionar una fecha inicial", "rojo");
                exit();
            }
            if($FechaFinalRangos==''){
                $css->CrearTitulo("Debe seleccionar una fecha final", "rojo");
                exit();
            }
            
            $sql="SELECT SUM(ValorCuota-ValorPagado) AS Total FROM acuerdo_pago_proyeccion_pagos t1
                    INNER JOIN acuerdo_pago t2 ON t1.idAcuerdoPago=t2.idAcuerdoPago 
                    WHERE t2.Estado=1 and  t1.Fecha >= '$FechaInicialRangos' AND t1.Fecha <= '$FechaFinalRangos';";
            $DatoConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalCarteraActual=$DatoConsulta["Total"];
            
            $DatosGenerales= $obCon->DevuelveValores("configuracion_general", "ID", 30);//Verifico cuantos dias de plazo tiene un cliente para pagar
            $DiasPlazo=$DatosGenerales["Valor"];
            $FechaFinalPlazo=$obCon->SumeDiasAFechaAcuerdo($FechaFinalRangos, $DiasPlazo);
            $FechaInicialPlazo=$obCon->ResteDiasAFechaAcuerdo($FechaFinalRangos, $DiasPlazo);
            
            $sql="SELECT SUM(ValorCuota-ValorPagado) AS Total FROM acuerdo_pago_proyeccion_pagos t1
                    INNER JOIN acuerdo_pago t2 ON t1.idAcuerdoPago=t2.idAcuerdoPago 
                    WHERE t2.Estado=1 and  t1.Fecha < '$FechaInicialRangos';";
            $DatoConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalCarteraVencida=$DatoConsulta["Total"];
            
            $sql="SELECT SUM(ValorCuota-ValorPagado) AS Total FROM acuerdo_pago_proyeccion_pagos t1
                    INNER JOIN acuerdo_pago t2 ON t1.idAcuerdoPago=t2.idAcuerdoPago 
                    WHERE t2.Estado=1 and  t1.Fecha > '$FechaFinalRangos';";
            $DatoConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalCarteraFutura=$DatoConsulta["Total"];
            
            $css->CrearTabla("TablaCumplimiento");
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CUMPLIMIENTO DE RECAUDO</strong>", 3,'C');
                    print("<td style=text-align:center>");
                        print('<button type="button" id="BtnExportarExcelCuentas" class="btn btn-success btn-flat" onclick="ExportarTablaToExcel(`TablaCumplimiento`)"><i class="fa fa-file-excel-o"></i></button>');
                    print("<td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CARTERA ACTUAL DE $FechaInicialRangos - $FechaFinalRangos </strong>", 3,'C');
                    $css->ColTabla("<strong>".number_format($TotalCarteraActual)."</strong>", 1,'R');
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>USUARIO</strong>", 1); 
                    $css->ColTabla("<strong>RECAUDO</strong>", 1);
                    $css->ColTabla("<strong>CUMPLIMIENTO</strong>", 1); 
                    $css->ColTabla("<strong>SALDO CARTERA</strong>", 1); 
                $css->CierraFilaTabla();
                $sql="SELECT SUM(ValorPago) AS Total,t1.idUser FROM acuerdo_pago_cuotas_pagadas t1 
                    WHERE FechaPago>='$FechaInicialRangos' AND FechaPago<='$FechaFinalPlazo' AND
                     EXISTS 
                    (SELECT 1 FROM acuerdo_pago_proyeccion_pagos t2 WHERE t2.ID=t1.idProyeccion 
                    AND Fecha>='$FechaInicialRangos' AND Fecha<='$FechaFinalRangos') GROUP BY t1.idUser;";
                $Consulta=($obCon->Query($sql));
                $TotalRecaudoUsuarios=0;
                $PorcentajeTotal=0;
                while($DatoConsulta=$obCon->FetchAssoc($Consulta)){
                    $TotalRecaudoUsuarios=$TotalRecaudoUsuarios+$DatoConsulta["Total"];
                    $TotalRecaudoCarteraActual=$DatoConsulta["Total"];
                    $Divisor=1;
                    if($TotalCarteraActual<>0){
                        $Divisor=$TotalCarteraActual;
                    }
                    $Porcentaje=(100/$Divisor)*$TotalRecaudoCarteraActual;
                    $PorcentajeTotal=$PorcentajeTotal+$Porcentaje;
                    $idUser=$DatoConsulta["idUser"];
                    $sql="SELECT CONCAT(Nombre,' ',Apellido) as Nombre FROM usuarios WHERE idUsuarios='$idUser' ";
                    $DatosUsuario=$obCon->FetchAssoc($obCon->Query($sql));
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>".$DatosUsuario["Nombre"]."</strong>", 1);
                         
                        $css->ColTabla(number_format($TotalRecaudoCarteraActual), 1,'R');
                        $css->ColTabla(number_format($Porcentaje,2 ), 1,'R'); 
                        $css->ColTabla("", 1);
                    $css->CierraFilaTabla();
                }
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>TOTALES</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($TotalRecaudoUsuarios)."</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($PorcentajeTotal,2)."</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($TotalCarteraActual-$TotalRecaudoUsuarios)."</strong>", 1,'R');
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CARTERA VENCIDA < $FechaInicialRangos </strong>", 3,'C');
                    $css->ColTabla("<strong>". number_format($TotalCarteraVencida)."</strong>", 1,'R');
                $css->CierraFilaTabla();
                
                $sql="SELECT SUM(ValorPago) AS Total,t1.idUser FROM acuerdo_pago_cuotas_pagadas t1 
                    WHERE FechaPago>='$FechaInicialRangos' AND FechaPago<='$FechaFinalPlazo' AND
                     EXISTS 
                    (SELECT 1 FROM acuerdo_pago_proyeccion_pagos t2 WHERE t2.ID=t1.idProyeccion 
                    AND Fecha<'$FechaInicialPlazo') GROUP BY t1.idUser;";
                $Consulta=($obCon->Query($sql));
                $TotalRecaudoUsuarios=0;
                $PorcentajeTotal=0;
                while($DatoConsulta=$obCon->FetchAssoc($Consulta)){
                    $TotalRecaudoUsuarios=$TotalRecaudoUsuarios+$DatoConsulta["Total"];
                    $Divisor=1;
                    if($TotalCarteraVencida<>0){
                        $Divisor=$TotalCarteraVencida;
                    }
                    $TotalRecaudoCarteraVencida=$DatoConsulta["Total"];
                    
                    $Porcentaje=(100/$Divisor)*$TotalRecaudoCarteraVencida;
                    $PorcentajeTotal=$PorcentajeTotal+$Porcentaje;
                    
                    
                    
                    $idUser=$DatoConsulta["idUser"];
                    $sql="SELECT CONCAT(Nombre,' ',Apellido) as Nombre FROM usuarios WHERE idUsuarios='$idUser' ";
                    $DatosUsuario=$obCon->FetchAssoc($obCon->Query($sql));
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>".$DatosUsuario["Nombre"]."</strong>", 1);                        
                        $css->ColTabla(number_format($TotalRecaudoCarteraVencida), 1);                       
                        $css->ColTabla(number_format($Porcentaje,2), 1); 
                        $css->ColTabla('', 1);      
                    $css->CierraFilaTabla();
                }
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>TOTALES</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($TotalRecaudoUsuarios)."</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($PorcentajeTotal,2)."</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($TotalCarteraVencida-$TotalRecaudoUsuarios)."</strong>", 1,'R');
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CARTERA X COBRAR > $FechaFinalRangos </strong>", 3,'C');
                    $css->ColTabla("<strong>". number_format($TotalCarteraFutura)."</strong>", 1,'R');
                $css->CierraFilaTabla();
                
                $sql="SELECT SUM(ValorPago) AS Total,t1.idUser FROM acuerdo_pago_cuotas_pagadas t1 
                    WHERE FechaPago>='$FechaInicialRangos' AND FechaPago<='$FechaFinalPlazo' AND
                     EXISTS 
                    (SELECT 1 FROM acuerdo_pago_proyeccion_pagos t2 WHERE t2.ID=t1.idProyeccion 
                    AND Fecha>'$FechaFinalPlazo') GROUP BY t1.idUser;";
                $Consulta=($obCon->Query($sql));
                $TotalRecaudoCarteraPosterior=$DatoConsulta["Total"];
                $TotalRecaudoUsuarios=0;
                $PorcentajeTotal=0;
                while($DatoConsulta=$obCon->FetchAssoc($Consulta)){
                    
                    $TotalRecaudoUsuarios=$TotalRecaudoUsuarios+$DatoConsulta["Total"];
                    $Divisor=1;
                    if($TotalCarteraFutura<>0){
                        $Divisor=$TotalCarteraFutura;
                    }
                    $TotalRecaudoCarteraPosterior=$DatoConsulta["Total"];
                    
                    $Porcentaje=(100/$Divisor)*$TotalRecaudoCarteraPosterior;
                    $PorcentajeTotal=$PorcentajeTotal+$Porcentaje;
                    
                    $idUser=$DatoConsulta["idUser"];
                    $sql="SELECT CONCAT(Nombre,' ',Apellido) as Nombre FROM usuarios WHERE idUsuarios='$idUser' ";
                    $DatosUsuario=$obCon->FetchAssoc($obCon->Query($sql));
                    
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>".$DatosUsuario["Nombre"]."</strong>", 1);
                        $css->ColTabla(number_format($TotalRecaudoCarteraPosterior), 1,'R');                        
                        $css->ColTabla(number_format($Porcentaje,2 ), 1,'R');  
                        $css->ColTabla('', 1,'R');   
                    $css->CierraFilaTabla();
                }
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>TOTALES</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($TotalRecaudoUsuarios)."</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($PorcentajeTotal,2)."</strong>", 1,'R');
                    $css->ColTabla("<strong>". number_format($TotalCarteraFutura-$TotalRecaudoUsuarios)."</strong>", 1,'R');
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
        break;//fin caso 4    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>