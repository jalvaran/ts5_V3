<?php 
if(isset($_REQUEST["idDocumento"])){
    
    //include_once("../../../modelo/php_conexion.php");
    //include_once("../../modelo/PrintPos.php");
    include_once("../clases/ReportesContables.class.php");
    include_once("../clases/PDF_ReportesContables.class.php");
    session_start();
    $idUser=$_SESSION["idUser"];
    $obCon = new Contabilidad($idUser);
    
    $obDoc = new PDF_ReportesContables($db);
    $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
    
    
    switch ($idDocumento){
        case 1://Genera el PDF de un estado de resultados
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $idEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCosto=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);             
            //$Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            
            $obDoc->EstadosResultadosAnio_PDF($FechaInicial,$FechaFinal,$idEmpresa,$CentroCosto,"" );
    
            
        break;
    
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
    
            
        break;
    
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
                exit("E1;Debe Seleccionar un Cuenta Contable");
            }
            
            $sql="SELECT Fecha,Tipo_Documento_Intero,Num_Documento_Interno,Num_Documento_Externo,
                Tercero_Identificacion,Tercero_Razon_Social,CuentaPUC, NombreCuenta,
                @SaldoInicial as SaldoInicialCuenta,
                Debito AS Debitos,Credito AS Creditos, ( ((SELECT Debitos) - (SELECT Creditos)) ) as Saldo,
                 @SaldoFinal := @SaldoFinal + (SELECT Saldo) AS SaldoFinalCuenta,
                @SaldoInicial := @SaldoInicial+(SELECT Saldo)

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
    
            
        break;
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>