<?php 
if(isset($_REQUEST["Accion"])){
    
    include_once("../../../modelo/php_conexion.php");
    
    include_once("../clases/informes_administracion.class.php");
    include_once("../../../constructores/paginas_constructor.php");
    
    
    @session_start();
    $idUser=$_SESSION["idUser"];
    $obCon = new ProcesoVenta($idUser);
    
    $obDoc = new InformesAdmnistracion($db);
    $Accion=$obCon->normalizar($_REQUEST["Accion"]);
    
    
    switch ($Accion){
        case 1://Genera el html para el informe de admin
            
            $FechaInicial=$obCon->normalizar($_REQUEST["FechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["FechaFinal"]);
            $empresa_id=$obCon->normalizar($_REQUEST["CmbEmpresaPro"]);
            $centro_costos_id=$obCon->normalizar($_REQUEST["CmbCentroCostos"]);             
            
            if($FechaInicial==''){
                exit("<h1>No se recibió la  Fecha Inicial</h1>");
            }
            if($FechaFinal==''){
                exit("<h1>No se recibió la  Fecha Final</h1>");
            }
            
            $Condicion=" facturas_items WHERE ";
            $Condicion2=" facturas WHERE ";
            
            $CondicionFecha1=" FechaFactura >= '$FechaInicial' AND FechaFactura <= '$FechaFinal' ";
            $CondicionFecha2=" Fecha >= '$FechaInicial' AND Fecha <= '$FechaFinal' ";
            $CondicionFecha3=" fi.FechaFactura >= '$FechaInicial' AND fi.FechaFactura <= '$FechaFinal' ";
            $Rango="De $FechaInicial a $FechaFinal";
            

            $CondicionItems=$Condicion.$CondicionFecha1;
            $CondicionFacturas=$Condicion2.$CondicionFecha2;
            
            $CondicionItems=" FROM `facturas_items` fi INNER JOIN facturas f ON fi.`idFactura` = f.idFacturas 
                WHERE $CondicionFecha1 AND f.FormaPago<>'ANULADA'
                ";
            $html="";
            $html=$obDoc->HTML_VentasXDepartamentos($CondicionItems);
            
            $sql="SELECT fi.idUsuarios as IdUsuarios,f.FormaPago as TipoVenta,sum(fi.`TotalItem`) as Total,sum(fi.`IVAItem`) as IVA,
                sum(fi.`SubtotalItem`) as Subtotal,sum(fi.`SubtotalCosto`) as TotalCostos, sum(fi.`ValorOtrosImpuestos`) as Bolsas, 
                SUM(fi.`Cantidad`) AS Items, 
                (SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t3 WHERE t3.idUsuarios=fi.idUsuarios) as NombreUsuario FROM facturas f INNER JOIN facturas_items fi ON fi.`idFactura` = f.idFacturas 
                WHERE Fecha >= '$FechaInicial' AND Fecha <= '$FechaFinal' 
                GROUP BY fi.idUsuarios,f.FormaPago";
            
            $sql_devoluciones="SELECT idUsuarios as IdUsuarios, Sum(Cantidad) as Items, 
                SUM(TotalItem) as Total,(SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t3 WHERE t3.idUsuarios=facturas_items.idUsuarios) as NombreUsuario "
             . "  FROM facturas_items WHERE Cantidad < 0 AND $CondicionFecha1 GROUP BY idUsuarios";
            
            $html.=$obDoc->HTML_VentasXUsuario($sql,$sql_devoluciones);
            
            $sql="SELECT f.FormaPago as TipoVenta,sum(fi.`TotalItem`) as Total,sum(fi.`IVAItem`) as IVA,
                sum(fi.`SubtotalItem`) as Subtotal,sum(fi.`SubtotalCosto`) as TotalCostos, sum(fi.`ValorOtrosImpuestos`) as Bolsas, 
                SUM(fi.`Cantidad`) AS Items
                FROM facturas f INNER JOIN facturas_items fi ON fi.`idFactura` = f.idFacturas 
                WHERE Fecha >= '$FechaInicial' AND Fecha <= '$FechaFinal' 
                GROUP BY f.FormaPago";
            $html.=$obDoc->HTML_ventas_agrupadas_x_tipo($sql);
            
            $html.=$obDoc->HTML_Uso_Resoluciones($CondicionFecha2);
            $html.=$obDoc->HTML_Egresos_Admin($CondicionFecha2);
            $html.=$obDoc->HTML_Abonos_Separados_Admin($CondicionFecha2);
            $html.=$obDoc->HTML_Ventas_Colaboradores($FechaInicial,$FechaFinal);
            
            if(isset($_REQUEST["pdf"]) and $_REQUEST["pdf"]==1){
                $obDoc->informe_admin_pdf($FechaInicial, $FechaFinal, $empresa_id, $centro_costos_id,$html);
                exit();
            }
            $link="Consultas/informes_administracion.draw.php?Accion=1&FechaInicial=$FechaInicial&FechaFinal=$FechaFinal&CmbEmpresaPro=$empresa_id&CmbCentroCostos=$centro_costos_id&pdf=1";
            $html_link='<a title="Exportar a PDF" href="'.$link.'" target="_blank" style="font-size:50px;"> <li style="font-size:50px" class="fa fa-file-pdf-o text-color:danger"> </li> </a>';
            $html_link_excel='<a onclick="ExportarTablaToExcel(`tbl_ventas_departamento`)" title="Exportar a Excel" target="_blank" style="font-size:50px;cursor:pointer"> <li style="font-size:50px" class="fa fa-file-excel-o text-color:success"> </li> </a>';
            
            
            print($html_link.$html_link_excel."<br>".$html);
        break;//Fin caso 1
    
        case 2://Genera el html con los datos del informe de administrador en excel
            $css =  new PageConstruct("", "", 1, "", 1, 0);
            $FechaInicial=$obCon->normalizar($_REQUEST["FechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["FechaFinal"]);
            $empresa_id=$obCon->normalizar($_REQUEST["CmbEmpresaPro"]);
            $centro_costos_id=$obCon->normalizar($_REQUEST["CmbCentroCostos"]);             
            
            if($FechaInicial==''){
                exit("<h1>No se recibió la  Fecha Inicial</h1>");
            }
            if($FechaFinal==''){
                exit("<h1>No se recibió la  Fecha Final</h1>");
            }
            $css->div("", "col-md-4", "", "", "", "", "");
            
            $css->Cdiv();
            
            $css->div("", "col-md-4", "", "", "", "", "");
                $css->CrearBotonEvento("btn_exportar_excel", "exportar", 1, "onclick", "ExportarTablaToExcel(`tbl_informe_admin`)", "verde");
            $css->Cdiv();
            
            $css->div("", "col-md-4", "", "", "", "", "");
            
            $css->Cdiv();
            
            $css->div("", "col-md-2", "", "", "", "", "");
            
            $css->Cdiv();
            
            $css->div("", "col-md-8", "", "", "", "", "");
                $css->CrearTabla("tbl_informe_admin");
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("INFORME DE ADMINISTRADOR DEL $FechaInicial AL $FechaFinal", 1);
                        $css->ColTabla(" ", 1);
                    $css->CierraFilaTabla();
                    
                    //Facturacion negativa
                
                $sql="SELECT SUM(Total) as Total FROM facturas WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND Total<0";
                $DatosFacturacionNegativa=$obCon->FetchAssoc($obCon->Query($sql));
                $FacturacionNegativa=$DatosFacturacionNegativa["Total"];
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("FACTURACION NEGATIVA:", 1);
                    $css->ColTabla(number_format($FacturacionNegativa), 1);
                $css->CierraFilaTabla();
                
                //Totales
                
                $sql="SELECT COUNT(ID) as TotalCierres, SUM(TotalVentas) as TotalVentas, SUM(TotalVentasContado) as TotalVentasContado,
                     SUM(TotalVentasCredito) as TotalVentasCredito,SUM(TotalRetiroSeparados) as TotalRetiroSeparados,
                     SUM(TotalVentasSisteCredito) as TotalVentasSisteCredito,SUM(TotalAbonosSeparados) as TotalAbonosSeparados,
                     SUM(AbonosSisteCredito) as AbonosSisteCredito, SUM(TotalEgresos) as TotalEgresos, 
                     SUM(TotalTarjetas) as TotalTarjetas, SUM(TotalCheques) as TotalCheques, 
                     SUM(TotalOtros) as TotalOtros, SUM(TotalEntrega) as TotalEntrega, 
                     SUM(EfectivoRecaudado) as EfectivoRecaudado, SUM(TotalEfectivo) AS TotalEfectivo  
                     
                     
                 FROM cajas_aperturas_cierres WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal'    ";
        
                $DatosCierre=$obCon->FetchAssoc($obCon->Query($sql));    
                
                $sql="SELECT SUM(Valor) as Abono, TipoPagoAbono FROM facturas_abonos WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' GROUP BY TipoPagoAbono ";
                $ConsultaAbonos=$obCon->Query($sql);
                $AbonosCreditoEfectivo=0;
                $AbonosCreditoTarjeta=0;
                $AbonosCreditoCheque=0;
                $AbonosCreditoOtros=0;
                while ($DatosAbonos=$obCon->FetchArray($ConsultaAbonos)){
                    if($DatosAbonos["TipoPagoAbono"]==""){
                        $AbonosCreditoEfectivo=$AbonosCreditoEfectivo+$DatosAbonos["Abono"];
                    }
                    if($DatosAbonos["TipoPagoAbono"]=="Tarjetas"){
                        $AbonosCreditoTarjeta=$AbonosCreditoTarjeta+$DatosAbonos["Abono"];
                    }
                    if($DatosAbonos["TipoPagoAbono"]=="Cheques"){
                        $AbonosCreditoCheque=$AbonosCreditoCheque+$DatosAbonos["Abono"];
                    }
                    if($DatosAbonos["TipoPagoAbono"]=="Bonos"){
                        $AbonosCreditoOtros=$AbonosCreditoOtros+$DatosAbonos["Abono"];
                    }
                }
                $TotalInteresesSisteCredito=$obCon->Sume("facturas_intereses_sistecredito", "Valor", "WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal'");
     
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("TOTAL VENTAS:", 1);
                    $css->ColTabla(number_format($DatosCierre["TotalVentas"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("TOTAL VENTAS CONTADO:", 1);
                    $css->ColTabla(number_format($DatosCierre["TotalVentasContado"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("TOTAL VENTAS CREDITO:", 1);
                    $css->ColTabla(number_format($DatosCierre["TotalVentasCredito"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("RETIROS SEPARADOS:", 1);
                    $css->ColTabla(number_format($DatosCierre["TotalRetiroSeparados"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(" ", 1);
                    $css->ColTabla("ABONOS SEPARADOS:", 1);
                    $css->ColTabla(number_format($DatosCierre["TotalAbonosSeparados"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(" ", 1);
                    $css->ColTabla("ABONOS CRED EFECTIVO:", 1);
                    $css->ColTabla(number_format($AbonosCreditoEfectivo), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(" ", 1);
                    $css->ColTabla("ABONOS CRED TARJETAS:", 1);
                    $css->ColTabla(number_format($AbonosCreditoTarjeta), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(" ", 1);
                    $css->ColTabla("ABONOS CRED CHEQUES:", 1);
                    $css->ColTabla(number_format($AbonosCreditoCheque), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(" ", 1);
                    $css->ColTabla("ABONOS CRED BONOS:", 1);
                    $css->ColTabla(number_format($AbonosCreditoOtros), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(" ", 1);
                    $css->ColTabla("ABONOS SISTECREDITO:", 1);
                    $css->ColTabla(number_format($DatosCierre["AbonosSisteCredito"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("TOTAL VENTAS SISTE CREDITO:", 1);
                    $css->ColTabla(number_format($DatosCierre["TotalVentasSisteCredito"]), 1);
                $css->CierraFilaTabla();
                
                                
                $sql="SELECT SUM(Valor) as TotalIniciales FROM comercial_plataformas_pago_ingresos WHERE idPlataformaPago=1 AND Inicial=1 AND Fecha>='$FechaInicial' AND Fecha<='$FechaFinal'";
                $DatosInicialSiste=$obCon->FetchAssoc($obCon->Query($sql));
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("INICIALES SISTE CREDITO:", 1);
                    $css->ColTabla(number_format($DatosInicialSiste["TotalIniciales"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("INTERESES SISTECREDITO:", 1);
                    $css->ColTabla(number_format($TotalInteresesSisteCredito), 1);
                $css->CierraFilaTabla();
                
                $sql="SELECT SUM(ValorPago) as Total FROM acuerdo_pago_cuotas_pagadas WHERE FechaPago>='$FechaInicial' AND FechaPago<='$FechaFinal' AND MetodoPago=1 AND Estado<10";
                $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
                $AbonosAcuerdoEfectivo=$DatosPagosAcuerdo["Total"];

                $sql="SELECT SUM(ValorPago) as Total FROM acuerdo_pago_cuotas_pagadas WHERE FechaPago>='$FechaInicial' AND FechaPago<='$FechaFinal' AND MetodoPago<>1 AND Estado<10";
                $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
                $AbonosAcuerdoOtrosMetodos=$DatosPagosAcuerdo["Total"];

                if($AbonosAcuerdoEfectivo>0 or $AbonosAcuerdoOtrosMetodos>0){
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("ABONOS ACUERDOS EFECTIVO:", 1);
                        $css->ColTabla(number_format($AbonosAcuerdoEfectivo), 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("ABONOS ACUERDOS NO EFECTIVO:", 1);
                        $css->ColTabla(number_format($AbonosAcuerdoOtrosMetodos), 1);
                    $css->CierraFilaTabla();
                    
                }
    
                
                
                
                
                $sql="SELECT SUM(ValorRecargoInteres) as Total FROM acuerdo_recargos_intereses WHERE FechaPago>='$FechaInicial' AND FechaPago<='$FechaFinal' AND MetodoPago=1";
                $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
                $InteresesAcuerdoEfectivo=$DatosPagosAcuerdo["Total"];

                $sql="SELECT SUM(ValorRecargoInteres) as Total FROM acuerdo_recargos_intereses WHERE FechaPago>='$FechaInicial' AND FechaPago<='$FechaFinal' AND MetodoPago<>1";
                $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
                $InteresesAcuerdoOtrosMetodos=$DatosPagosAcuerdo["Total"];

                if($InteresesAcuerdoEfectivo>0 or $InteresesAcuerdoOtrosMetodos>0){
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("INTERESES ACUERDOS EFECTIVO:", 1);
                        $css->ColTabla(number_format($InteresesAcuerdoEfectivo), 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("INTERESES ACUERDOS NO EFECTIVO:", 1);
                        $css->ColTabla(number_format($InteresesAcuerdoOtrosMetodos), 1);
                    $css->CierraFilaTabla();
                    
                }

                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("CRUCE DE ANTICIPOS POR ENCARGOS:", 1);
                        $css->ColTabla(" ", 1);
                    $css->CierraFilaTabla();
                    
                    $sql="SELECT * FROM librodiario 
                            WHERE Tipo_Documento_Intero='FACTURA' AND Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND Debito>0 AND CuentaPUC=(SELECT CuentaPUC from parametros_contables WHERE ID=20)";

                    $Consulta=$obCon->Query($sql);
                
                    
                    $total_cruce_anticipos=0;
                    while($DatosConsulta= $obCon->FetchAssoc($Consulta)){
                        $Titulo="Factura ".$DatosConsulta["Num_Documento_Externo"];
                        $total_cruce_anticipos=$total_cruce_anticipos+$DatosConsulta["Debito"];
                        $css->FilaTabla(16);
                            $css->ColTabla("Factura No.", 1);
                            $css->ColTabla($DatosConsulta["Num_Documento_Externo"], 1);
                            $css->ColTabla(number_format($DatosConsulta["Debito"]), 1);
                        $css->CierraFilaTabla();
                        
                        
                    }
                
                $sql="SELECT SUM(Valor) as Total FROM anticipos_encargos_abonos WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND Metodo=1";
                $DatosPagosAnticiposEncargos= $obCon->FetchAssoc($obCon->Query($sql));
                $AbonosAnticiposEncargosEfectivo=$DatosPagosAnticiposEncargos["Total"];

                $sql="SELECT SUM(Valor) as Total FROM anticipos_encargos_abonos WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND Metodo<>1";
                $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
                $AbonosAnticiposEncargosOtrosMetodos=$DatosPagosAcuerdo["Total"];

                if($AbonosAnticiposEncargosEfectivo>0 or $AbonosAnticiposEncargosOtrosMetodos>0){
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("ABONOS ANTICIPOS EFECTIVO:", 1);
                        $css->ColTabla(number_format($AbonosAnticiposEncargosEfectivo), 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("ABONOS ANTICIPOS NO EFECTIVO:", 1);
                        $css->ColTabla(number_format($AbonosAnticiposEncargosOtrosMetodos), 1);
                    $css->CierraFilaTabla();
                    
                  
                }
                
                
                $TotalAnticiposRecibidos=$obCon->Sume("comprobantes_ingreso", "Valor", "WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND Estado='ABIERTO' AND Tipo='ANTICIPO'");
                $TotalAnticiposCruzados=$obCon->Sume("comprobantes_ingreso", "Valor", "WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND Estado='CERRADO' AND Tipo='ANTICIPO'");

                if($TotalAnticiposRecibidos>0){
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("ANTICIPOS RECIBIDOS:", 1);
                        $css->ColTabla(number_format($TotalAnticiposRecibidos), 1);
                    $css->CierraFilaTabla();
                    
                }
                if($TotalAnticiposCruzados>0){
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("ANTICIPOS CRUZADOS:", 1);
                        $css->ColTabla(number_format($TotalAnticiposCruzados), 1);
                    $css->CierraFilaTabla();
                    
                }
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("EGRESOS:", 1);
                        $css->ColTabla(number_format($DatosCierre["TotalEgresos"]), 1);
                    $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("TOTAL TARJETAS:", 1);
                        $css->ColTabla(number_format($DatosCierre["TotalTarjetas"]), 1);
                    $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("TOTAL CONSIGNACIONES:", 1);
                        $css->ColTabla(number_format($DatosCierre["TotalCheques"]), 1);
                    $css->CierraFilaTabla();
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("TOTAL OTROS:", 1);
                        $css->ColTabla(number_format($DatosCierre["TotalOtros"]), 1);
                    $css->CierraFilaTabla();
                
                $TotalOtrosImpuestos=$obCon->Sume("facturas_items", "ValorOtrosImpuestos", "WHERE FechaFactura>='$FechaInicial' AND FechaFactura<='$FechaFinal'");

                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("OTROS IMPUESTOS:", 1);
                        $css->ColTabla(number_format($TotalOtrosImpuestos), 1);
                    $css->CierraFilaTabla();
                
                $Parametros= $obCon->DevuelveValores("configuracion_general", "ID", 35);//Se Valida si las facturas negativas se devulven al cliente o no
                $TotalFacturasNegativas=0;   
                if($Parametros["Valor"]=="1"){
                    $TotalFacturasNegativas=$obCon->Sume("facturas", "Total", "WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND Total<0");
                    $TotalFacturasNegativas=ABS($TotalFacturasNegativas);
                }
                $total_entrega=$DatosCierre["TotalEntrega"]+$TotalOtrosImpuestos+$TotalInteresesSisteCredito+$TotalAnticiposRecibidos+$AbonosAcuerdoOtrosMetodos+$TotalFacturasNegativas+$InteresesAcuerdoEfectivo+$InteresesAcuerdoOtrosMetodos+$AbonosAnticiposEncargosEfectivo+$AbonosAnticiposEncargosOtrosMetodos;
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("TOTAL ENTREGA:", 1);
                        $css->ColTabla(number_format($total_entrega), 1);
                    $css->CierraFilaTabla();
                
                $SaldoEnCaja=$DatosCierre["TotalEfectivo"]+$TotalOtrosImpuestos+$TotalInteresesSisteCredito+$TotalAnticiposRecibidos+$TotalFacturasNegativas+$InteresesAcuerdoEfectivo+$InteresesAcuerdoOtrosMetodos+$AbonosAnticiposEncargosEfectivo;
                $Diferencia=$DatosCierre["EfectivoRecaudado"]-$SaldoEnCaja;
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("EFECTIVO EN CAJA:", 1);
                        $css->ColTabla(number_format($DatosCierre["EfectivoRecaudado"]), 1);
                    $css->CierraFilaTabla();
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("SALDO EN CAJA:", 1);
                        $css->ColTabla(number_format($SaldoEnCaja), 1);
                    $css->CierraFilaTabla();  
                    
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("DIFERENCIA:", 1);
                        $css->ColTabla(number_format($Diferencia), 1);
                    $css->CierraFilaTabla();      
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("TOTAL DE CIERRES:", 1);
                        $css->ColTabla(number_format($DatosCierre["TotalCierres"]), 1);
                    $css->CierraFilaTabla();   
                
                               
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("FORMAS DE PAGO EN FACTURACION:", 1);
                        $css->ColTabla(" ", 1);
                    $css->CierraFilaTabla();
                
                $sql="SELECT SUM(Efectivo-Devuelve) as Efectivo,SUM(Cheques) as Cheques,SUM(Otros) as Otros, SUM(Tarjetas) as Tarjetas FROM facturas WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal'";

                $TotalesFormasPagoFactura=$obCon->FetchAssoc($obCon->Query($sql));
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("EFECTIVO:", 1);
                    $css->ColTabla(number_format($TotalesFormasPagoFactura["Efectivo"]), 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("CONSIGNACIONES:", 1);
                    $css->ColTabla(number_format($TotalesFormasPagoFactura["Cheques"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("BONOS:", 1);
                    $css->ColTabla(number_format($TotalesFormasPagoFactura["Otros"]), 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("TARJETAS:", 1);
                    $css->ColTabla(number_format($TotalesFormasPagoFactura["Tarjetas"]), 1);
                $css->CierraFilaTabla();
                
                
                $sql="SELECT SUM(t1.`ValorPago`) as TotalAbono,MetodoPago,TipoCuota,
                (SELECT NombreTipoCuota FROM acuerdo_pago_tipo_cuota t3 WHERE t1.TipoCuota=t3.ID) as NombreTipoCuota,
                (SELECT Metodo FROM metodos_pago t2 WHERE t1.MetodoPago=t2.ID) as Metodo 
                FROM `acuerdo_pago_cuotas_pagadas` t1
                WHERE FechaPago>='$FechaInicial' AND FechaPago<='$FechaFinal' AND t1.Estado<10 GROUP BY t1.MetodoPago,t1.TipoCuota ORDER BY MetodoPago,TipoCuota ";
        
                $Consulta=$obCon->Query($sql);
                $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("FORMAS DE PAGO EN ABONOS ACUERDOS:", 1);
                        $css->ColTabla(" ", 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("Tipo Cuota", 1);
                        $css->ColTabla("Metodo", 1);
                        $css->ColTabla("Valor", 1);
                    $css->CierraFilaTabla();
                    while($DatosConsulta= $obCon->FetchAssoc($Consulta)){
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosConsulta["NombreTipoCuota"], 1);
                            $css->ColTabla($DatosConsulta["Metodo"], 1);
                            $css->ColTabla(number_format($DatosConsulta["TotalAbono"]), 1);
                        $css->CierraFilaTabla();
                        
                    }
                
                
                    $sql="SELECT SUM(t1.Valor) as Total,(SELECT Metodo FROM metodos_pago t2 WHERE t1.Metodo=t2.ID) as MetodoPago  FROM anticipos_encargos_abonos t1 WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' GROUP BY Metodo";
      
                    $Consulta=$obCon->Query($sql);
                    
                    
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("ANTICIPOS POR ENCARGOS:", 1);
                        $css->ColTabla(" ", 1);
                    $css->CierraFilaTabla();
                    
                    

                    while($DatosConsulta= $obCon->FetchAssoc($Consulta)){
                        $css->FilaTabla(16);
                            $css->ColTabla("", 1);
                            $css->ColTabla($DatosConsulta["MetodoPago"], 1);
                            $css->ColTabla(number_format($DatosConsulta["Total"]), 1);
                        $css->CierraFilaTabla();
                        
                    }
                    
                    
                    
                    $sql="SELECT * FROM librodiario 
                                WHERE Tipo_Documento_Intero='CompEgreso' AND Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND Debito>0";

                    $Consulta=$obCon->Query($sql);
                    
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 1);
                        $css->ColTabla("EGRESOS REALIZADOS:", 1);
                        $css->ColTabla(" ", 1);
                    $css->CierraFilaTabla();

                    while($DatosConsulta= $obCon->FetchAssoc($Consulta)){

                        $Titulo="Egreso ".$DatosConsulta["Num_Documento_Interno"]." ".$DatosConsulta["Concepto"];
                        $LongitudTitulo= strlen($Titulo);        
                        $css->FilaTabla(16);
                            $css->ColTabla("Egreso No. ".$DatosConsulta["Num_Documento_Interno"], 1);
                            $css->ColTabla($DatosConsulta["Concepto"], 1);
                            $css->ColTabla(number_format($DatosConsulta["Debito"]), 1);
                        $css->CierraFilaTabla();
                        
                    }
                    
                    
                    
                 //Devoluciones
                    
                    
                $css->FilaTabla(16);
                    $css->ColTabla(" ", 1);
                    $css->ColTabla("DEVOLUCIONES", 1);
                    $css->ColTabla(" ", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("CANTIDAD", 1);
                    $css->ColTabla("REFERENCIA", 1);
                    $css->ColTabla("TOTAL", 1);
                $css->CierraFilaTabla();
                
                $sql = "SELECT Cantidad as Cantidad, TotalItem as Total, Referencia as Referencia"
                . " FROM facturas_items fi "
                . " WHERE Cantidad < 0 AND FechaFactura>='$FechaInicial' AND FechaFactura<='$FechaFinal' ";
	
                $consulta=$obCon->Query($sql);
                $TotalDevoluciones=0;						
                while($DatosVenta=$obCon->FetchArray($consulta)){

                    $TotalDevoluciones=$TotalDevoluciones+$DatosVenta["Total"];
                    
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosVenta["Cantidad"], 1);
                        $css->ColTabla($DatosVenta["Referencia"], 1);
                        $css->ColTabla(number_format($DatosVenta["Total"]), 1);
                    $css->CierraFilaTabla();
                }    
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("Total", 1);
                    $css->ColTabla(number_format($TotalDevoluciones), 1);
                $css->CierraFilaTabla();
            
                //descuentos
                
                $css->FilaTabla(16);
                    $css->ColTabla(" ", 1);
                    $css->ColTabla("DESCUENTOS", 1);
                    $css->ColTabla(" ", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("CANTIDAD", 1);
                    $css->ColTabla("ID DEL PRODUCTO", 1);
                    $css->ColTabla("TOTAL", 1);
                $css->CierraFilaTabla();
                
                $sql = "SELECT Cantidad, ValorDescuento as Total, idProducto"
                . " FROM pos_registro_descuentos "
                . " WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal'";
	
                $consulta=$obCon->Query($sql);
                $TotalDescuentos=0;						
                while($DatosVenta=$obCon->FetchArray($consulta)){

                    $TotalDescuentos=$TotalDescuentos+$DatosVenta["Total"];
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosVenta["Cantidad"], 1);
                        $css->ColTabla($DatosVenta["idProducto"], 1);
                        $css->ColTabla(number_format($DatosVenta["Total"]), 1);
                    $css->CierraFilaTabla();
                }    
                $css->FilaTabla(16);
                    $css->ColTabla("", 1);
                    $css->ColTabla("Total", 1);
                    $css->ColTabla(number_format($TotalDescuentos), 1);
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
            $css->Cdiv();
            $css->div("", "col-md-2", "", "", "", "", "");
            
            $css->Cdiv();
        break;//Fin caso 2
    
        
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>