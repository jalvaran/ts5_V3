<?php 
if(isset($_REQUEST["Accion"])){
    
    include_once("../../../modelo/php_conexion.php");
    
    include_once("../clases/informes_administracion.class.php");
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
            
            $html.=$obDoc->HTML_Uso_Resoluciones($CondicionFecha2);
            $html.=$obDoc->HTML_Egresos_Admin($CondicionFecha2);
            $html.=$obDoc->HTML_Abonos_Separados_Admin($CondicionFecha2);
            $html.=$obDoc->HTML_Ventas_Colaboradores($FechaInicial,$FechaFinal);
            
            if(isset($_REQUEST["pdf"]) and $_REQUEST["pdf"]==1){
                $obDoc->informe_admin_pdf($FechaInicial, $FechaFinal, $empresa_id, $centro_costos_id,$html);
                exit();
            }
            $link="Consultas/informes_administracion.draw.php?Accion=1&FechaInicial=$FechaInicial&FechaFinal=$FechaFinal&CmbEmpresaPro=$empresa_id&CmbCentroCostos=$centro_costos_id&pdf=1";
            $html_link='<a title="Exportar a PDF" href="'.$link.'" target="_blank" style="font-size:50px;"> <li style="font-size:50px" class="fa fa-file-pdf-o text-color:success"> </li> </a>';
            print($html_link."<br>".$html);
        break;//Fin caso 1
    
        case 2://Genera el html con los datos del estado de resultados
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $idEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCosto=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);             
            $Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            $obCon->ConstruirVistaEstadoResultados($Anio, $idEmpresa, $CentroCosto, "");
            $FechaReporte="Del $FechaInicial al $FechaFinal";
            $TotalClases=$obDoc->ArmeTemporalSubCuentas("Rango", $FechaFinal, $FechaInicial, $CentroCosto, $idEmpresa, "");
            $html=$obDoc->HTMLEstadoResultadosDetallado($TotalClases, $FechaReporte);
            $page="Consultas/PDF_ReportesContables.draw.php?idDocumento=1&TxtFechaInicial=$FechaInicial&TxtFechaFinal=$FechaFinal"; 
            $page.="&CmbEmpresa=$idEmpresa&CmbCentroCosto=$CentroCosto&CmbAnio=$Anio";
            print("<a href='$page' target='_blank'><button class='btn btn-warning' >Exportar a PDF</button></a>");
            print("<input type='button' class='btn btn-success' value='Exportar a Excel' onclick=ExportarTablaToExcel('EstadoResultados')> ");
            //$css->CrearBotonEvento("BtnExportar", "Exportar", 1, "onclick", "ExportarTablaToExcel('TblReporte')", "verde", "");
            print($html);
            //$obDoc->EstadosResultadosAnio_PDF($FechaInicial,$FechaFinal,$idEmpresa,$CentroCosto,"" );
    
            
        break;//Fin caso 2
    
        case 3://Genera el html con los datos del movimiento de cuentas
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $idEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCosto=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);             
            $CmbTercero=$obCon->normalizar($_REQUEST["CmbTercero"]);
            $TxtCuentaContable=$obCon->normalizar($_REQUEST["TxtCuentaContable"]);
            $Condicional="";
            if($CmbTercero<>""){
                $Condicional="AND Tercero_Identificacion='$CmbTercero'";
            }
            
            if($FechaInicial==""){
                exit("E1;Debe Seleccionar una Fecha Inicial");
            }
            if($FechaFinal==""){
                exit("E1;Debe Seleccionar una Fecha Final");
            }
            if($idEmpresa==""){
                exit("E1;Debe Seleccionar una Empresa");
            }
            if($CentroCosto==""){
                exit("E1;Debe Seleccionar un Centro de Costos");
            }
            
            if($TxtCuentaContable==""){
                //exit("E1;Debe Seleccionar un Cuenta Contable");
            }
            
            $sql="SELECT Fecha,Tipo_Documento_Intero,Num_Documento_Interno,Num_Documento_Externo,
                Tercero_Identificacion,Tercero_Razon_Social,CuentaPUC, NombreCuenta,Concepto,Detalle,
                @SaldoInicial as SaldoInicialCuenta,
                Debito AS Debitos,Credito AS Creditos, ( ((SELECT Debitos) - (SELECT Creditos)) ) as Saldo,
                 @SaldoFinal := @SaldoFinal + (SELECT Saldo) AS SaldoMovimiento,
                 
                @SaldoInicial := @SaldoInicial+(SELECT Saldo) as SaldoFinalCuenta

                FROM librodiario JOIN (SELECT @SaldoFinal:=0) tb2 
                JOIN (SELECT @SaldoInicial:=(SELECT SUM(Debito-Credito) FROM librodiario WHERE Fecha < '$FechaInicial' AND CuentaPUC like '$TxtCuentaContable%')) tb3 
                WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND CuentaPUC like '$TxtCuentaContable%' $Condicional ORDER BY Fecha ;";
            
            $html=$obDoc->HTMLReporteMovimientoDeCuentas($sql);
            /*
            $page="Consultas/PDF_ReportesContables.draw.php?idDocumento=1&TxtFechaInicial=$FechaInicial&TxtFechaFinal=$FechaFinal"; 
            $page.="&CmbEmpresa=$idEmpresa&CmbCentroCosto=$CentroCosto&CmbAnio=$Anio";
            print("<a href='$page' target='_blank'><button class='btn btn-warning' >Exportar a PDF</button></a>");
            
             * 
             */
            print("<input type='button' class='btn btn-success' value='Exportar a Excel' onclick=ExportarTablaToExcel('ReporteMovimientoCuentas')> ");
            //$css->CrearBotonEvento("BtnExportar", "Exportar", 1, "onclick", "ExportarTablaToExcel('TblReporte')", "verde", "");
            print($html);
            //$obDoc->EstadosResultadosAnio_PDF($FechaInicial,$FechaFinal,$idEmpresa,$CentroCosto,"" );
    
            
        break;//Fin caso 3
        
        case 4://Genera el html con los datos del balance general
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $idEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCosto=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);             
            $Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            $obCon->ConstruirVistaEstadoResultados($Anio, $idEmpresa, $CentroCosto, "");
            $FechaReporte="Del $FechaInicial al $FechaFinal";
            $TotalClases=$obDoc->ArmeTemporalSubCuentas("Rango", $FechaFinal, $FechaInicial, $CentroCosto, $idEmpresa, "");
            $html=$obDoc->HTMLBalanceGeneralDetallado($TotalClases, $FechaReporte);
            $page="Consultas/PDF_ReportesContables.draw.php?idDocumento=7&TxtFechaInicial=$FechaInicial&TxtFechaFinal=$FechaFinal"; 
            $page.="&CmbEmpresa=$idEmpresa&CmbCentroCosto=$CentroCosto&CmbAnio=$Anio";
            print("<a href='$page' target='_blank'><button class='btn btn-warning' >Exportar a PDF</button></a>");
            print("<input type='button' class='btn btn-success' value='Exportar a Excel' onclick=ExportarTablaToExcel('EstadoResultados')> ");
            //$css->CrearBotonEvento("BtnExportar", "Exportar", 1, "onclick", "ExportarTablaToExcel('TblReporte')", "verde", "");
            print($html);
            //$obDoc->EstadosResultadosAnio_PDF($FechaInicial,$FechaFinal,$idEmpresa,$CentroCosto,"" );
    
            
        break;//Fin caso 4
    
        case 5://Genera el html con los datos del balance de comprobacion por tercerso
            
           
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $Empresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCostos=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);             
            $CmbTercero=$obCon->normalizar($_REQUEST["CmbTercero"]);
            $TxtCuentaContable=$obCon->normalizar($_REQUEST["TxtCuentaContable"]);
            
            if($FechaInicial==""){
                exit("E1;Debe elegir una fecha inicial;TxtFechaInicial");
            }
            if($FechaFinal==""){
                exit("E1;Debe elegir una fecha Final;TxtFechaFinal");
            }
                        
            $obCon->ConstruirVistaBalanceComprobacionXTercero($FechaInicial, $FechaFinal, $CmbTercero, $Empresa, $CentroCostos, $TxtCuentaContable);
            $html=$obDoc->HtmlBalanceComprobacionXTerceros();
            $page="Consultas/PDF_ReportesContables.draw.php?idDocumento=6&TxtFechaInicial=$FechaInicial&TxtFechaFinal=$FechaFinal"; 
            $page.="&CmbEmpresa=$Empresa&CmbCentroCosto=$CentroCostos";
            print("<a href='$page' target='_blank'><button class='btn btn-warning' >Exportar a PDF</button></a>");
            print("<input type='button' class='btn btn-success' value='Exportar a Excel' onclick=ExportarTablaToExcel('TableBalanceComprobacionXTerceros')> ");
            print($html);
            
        break;//Fin caso 5
        
        case 6://Genera el PDF de un balance de comprobacion por terceros
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $idEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCosto=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);             
            
            $obDoc->BalanceComprobacionXTerceros_PDF($FechaInicial,$FechaFinal,$idEmpresa,$CentroCosto );
    
            
        break;//Fin caso 6
    
        case 7://Genera el PDF de un balance general
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $idEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCosto=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);             
            $Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            $obCon->ConstruirVistaEstadoResultados($Anio, $idEmpresa, $CentroCosto, "");
            $FechaReporte="Del $FechaInicial al $FechaFinal";
            //$TotalClases=$obDoc->ArmeTemporalSubCuentas("Rango", $FechaFinal, $FechaInicial, $CentroCosto, $idEmpresa, "");
            //$html=$obDoc->HTMLBalanceGeneralDetallado($TotalClases, $FechaReporte);
            
            $obDoc->EstadoSituacionFinaciera_PDF($FechaInicial,$FechaFinal,$idEmpresa,$CentroCosto,"" );
    
            
        break;//Fin caso 7
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>