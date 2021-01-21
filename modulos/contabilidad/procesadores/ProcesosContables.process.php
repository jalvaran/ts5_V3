<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/DocumentosContables.class.php");
//include_once("../../../general/clases/contabilidad.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new DocumentosContables($idUser);
    //$obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
            
        case 1: //Agrega los movimientos
            $Empresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            $Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            $AnioSiguiente=$Anio+1;
            if($Empresa==''){
                exit("<strong>DEBES SELECCIONAR UNA EMPRESA PARA CERRAR</strong>");
                
            }
            
            
            if($Anio==''){
                exit("<strong>DEBES SELECCIONAR UN AÑO PARA CERRAR</strong>");
                
            }
            
            if($idDocumento==''){
                exit("<strong>DEBES SELECCIONAR DOCUMENTO DONDE SE REALIZARÁ EL CIERRE</strong>");
                 
            }
            $AnioActual=date("Y");
            if($Anio==$AnioActual){
                exit("<strong>EL AÑO SELECCIONADO ES EL ACTUAL, EL PROCESO NO SE PUEDE REALIZAR</strong>");
                 
            }
            $sql="SELECT CerrarCuentasResultado FROM cierre_contable_control WHERE Anio='$Anio' AND Estado=1";
            $DatosControl=$obCon->FetchAssoc($obCon->Query($sql));
            if($DatosControl["CerrarCuentasResultado"]==1){
                exit("Las Cuentas de Resultado ya han sido cerradas");
            }
            
            $FechaInicial="$Anio-01-01";
            $FechaFinal="$Anio-12-31";
            $Condicion=" WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' ";
            $FechaMes13="$AnioSiguiente-00-00";
            $DatosEmpresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $Empresa);
            $Tercero=$DatosEmpresa["NIT"];
            $DatosTercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $Tercero);
            if($DatosTercero["RazonSocial"]==''){
                $DatosTercero=$obCon->DevuelveValores("clientes", "Num_Identificacion", $Tercero);
                if($DatosTercero["RazonSocial"]==''){
                    exit("E1;Debes Crear la empresa como un tercero;idEmpresa");
                }
            }
            if($Empresa<>''){
                $Condicion.=" AND idEmpresa='$Empresa' ";
            }
            $TotalActivos=0;
            $TotalPasivos=0;
            $TotalPatrimonio=0;
            $TotalIngresos=0;
            $TotalCostosVenta=0;
            $TotalGastos=0;
            $TotalCostosProduccion=0;
                
            $sql="SELECT CuentaPUC,NombreCuenta,
                    SUM(Debito) as Debitos,SUM(Credito) AS Creditos 
                    FROM librodiario  $Condicion
                    GROUP BY CuentaPUC";
            $Consulta=$obCon->Query($sql);
            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                $CuentaPUC=$DatosConsulta["CuentaPUC"];
                $Clase=substr($CuentaPUC, 0,1);
                $Saldo=$DatosConsulta["Debitos"]-$DatosConsulta["Creditos"];
                
                $Cuentas["ClaseCuenta"][$CuentaPUC]=$Clase;
                $Cuentas["CuentaPUC"][$CuentaPUC]=$CuentaPUC;                
                $Cuentas["Nombre"][$CuentaPUC]=$DatosConsulta["NombreCuenta"];
                $Cuentas["Debitos"][$CuentaPUC]=$DatosConsulta["Debitos"];
                $Cuentas["Creditos"][$CuentaPUC]=$DatosConsulta["Creditos"];
                $Cuentas["Saldo"][$CuentaPUC]=$Saldo;
                
                if($Clase==1){
                    $TotalActivos=$TotalActivos+$Saldo;
                }
                if($Clase==2){
                    $TotalPasivos=$TotalPasivos+$Saldo;
                }
                if($Clase==3){
                    $TotalPatrimonio=$TotalPatrimonio+$Saldo;
                }
                if($Clase==4){
                    $TotalIngresos=$TotalIngresos+$Saldo;
                }
                if($Clase==5){
                    $TotalGastos=$TotalGastos+$Saldo;
                }
                if($Clase==6){
                    $TotalCostosVenta=$TotalCostosVenta+$Saldo;
                }
                if($Clase==7){
                    $TotalCostosProduccion=$TotalCostosProduccion+$Saldo;
                }
                if($Saldo<>0){
                    if($Clase==4 or $Clase==5 or $Clase==6 or $Clase==7){
                        $TipoMovimiento="CR";
                        if($Saldo<0){
                            $TipoMovimiento="DB";
                        }

                        $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaPUC, $TipoMovimiento, abs($Saldo), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaMes13);
                    }
                }
            }
            //Cambio las cuentas que son naturaleza credito
            $TotalPasivos=$TotalPasivos*(-1);
            $TotalPatrimonio=$TotalPatrimonio*(-1);
            $TotalIngresos=$TotalIngresos*(-1);
            $TotalGananciaPerdidaBalance=($TotalActivos-$TotalPasivos)-$TotalPatrimonio;
            $TotalGananciaPerdidaResultados=$TotalIngresos-$TotalCostosVenta-$TotalCostosProduccion-$TotalGastos;
            
            if($TotalGananciaPerdidaResultados>0){ //Si hay ganacia
                $CuentaGPPatrimonio=$obCon->DevuelveValores("parametros_contables", "ID", 11); //Cuenta patrimonio para utilidades 
                $CuentaGPResultado=$obCon->DevuelveValores("parametros_contables", "ID", 13); //Cuenta patrimonio para utilidades 
                
                $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaGPPatrimonio["CuentaPUC"], "CR", abs($TotalGananciaPerdidaResultados), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaFinal);
                $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaGPResultado["CuentaPUC"], "DB", abs($TotalGananciaPerdidaResultados), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaFinal);
                $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaGPResultado["CuentaPUC"], "CR", abs($TotalGananciaPerdidaResultados), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaMes13);
            }
            
            if($TotalGananciaPerdidaResultados<0){ //si hay perdida
                $CuentaGPPatrimonio=$obCon->DevuelveValores("parametros_contables", "ID", 12); //Cuenta patrimonio para utilidades 
                $CuentaGPResultado=$obCon->DevuelveValores("parametros_contables", "ID", 13); //Cuenta patrimonio para utilidades 
                
                $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaGPPatrimonio["CuentaPUC"], "DB", abs($TotalGananciaPerdidaResultados), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaFinal);
                $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaGPResultado["CuentaPUC"], "CR", abs($TotalGananciaPerdidaResultados), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaFinal);
                $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaGPResultado["CuentaPUC"], "DB", abs($TotalGananciaPerdidaResultados), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaMes13);
                
            }
            
            $sql="UPDATE cierre_contable_control SET CerrarCuentasResultado=1 WHERE Anio='$Anio' AND Estado=1";
            //print($sql);
            $obCon->Query($sql);
               
            print("OK;Cierre de cuentas de Resultado agregados");
        break; //Fin caso 1
            
        case 2://Trasladar saldos de las cuentas del balance
            $Empresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            $Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            $GananciaPerdidaBalance=$obCon->normalizar($_REQUEST["GananciaPerdidaBalance"]);
            $GananciaPerdidaResultados=$obCon->normalizar($_REQUEST["GananciaPerdidaResultados"]);
            $jsonSelects= $_REQUEST["jsonSelects"];
            $AnioSiguiente=$Anio+1;
            if($Empresa==''){
                exit("<strong>DEBES SELECCIONAR UNA EMPRESA PARA CERRAR</strong>");
                
            }
            
            
            if($Anio==''){
                exit("<strong>DEBES SELECCIONAR UN AÑO PARA CERRAR</strong>");
                
            }
            
            if($idDocumento==''){
                exit("<strong>DEBES SELECCIONAR DOCUMENTO DONDE SE REALIZARÁ EL CIERRE</strong>");
                 
            }
            if($jsonSelects==''){
                exit("<strong>NO SE RECIBIÓ NINGUNA CUENTA A TRASLADAR</strong>");
               
            }
            
            $sql="SELECT CerrarCuentasResultado FROM cierre_contable_control WHERE Anio='$Anio' AND Estado=1";
            $DatosControl=$obCon->FetchAssoc($obCon->Query($sql));
            if($DatosControl["CerrarCuentasResultado"]==0){
                exit("Debe cerrar primero las cuentas de Resultado");
            }
            
            $sql="SELECT TrasladarSaldosBalance FROM cierre_contable_control WHERE Anio='$Anio' AND Estado=1";
            $DatosControl=$obCon->FetchAssoc($obCon->Query($sql));
            if($DatosControl["TrasladarSaldosBalance"]==1){
                exit("Las Cuentas de Balance ya han sido Trasladadas");
            }
            
            parse_str($jsonSelects,$CuentasTraslados);
            //print($CuentasTraslados["SaldoCuenta"][110505]);
            //print_r($CuentasTraslados);
            //exit();
            $FechaInicial="$Anio-01-01";
            $FechaFinal="$Anio-12-31";
            $Condicion=" WHERE (CuentaPUC LIKE '1%' OR CuentaPUC LIKE '2%' OR CuentaPUC LIKE '3%') AND (Fecha>='$FechaInicial' AND Fecha<='$FechaFinal') ";
            $FechaMes13="$AnioSiguiente-00-00";
            $FechaTraslado="$AnioSiguiente-01-01";
            
            $DatosEmpresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $Empresa);
            $Tercero=$DatosEmpresa["NIT"];
            $DatosTercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $Tercero);
            if($DatosTercero["RazonSocial"]==''){
                $DatosTercero=$obCon->DevuelveValores("clientes", "Num_Identificacion", $Tercero);
                if($DatosTercero["RazonSocial"]==''){
                    exit("E1;Debes Crear la empresa como un tercero;idEmpresa");
                }
            }
            if($Empresa<>''){
                $Condicion.=" AND idEmpresa='$Empresa' ";
            }
                            
            $sql="SELECT CuentaPUC,NombreCuenta, Tercero_Identificacion as Tercero,
                    SUM(Debito) as Debitos,SUM(Credito) AS Creditos 
                    FROM librodiario $Condicion GROUP BY CuentaPUC,Tercero_Identificacion
                    ";
            $Consulta=$obCon->Query($sql);
            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                $CuentaPUC=$DatosConsulta["CuentaPUC"];
                $Clase=substr($CuentaPUC, 0,1);
                $Saldo=$DatosConsulta["Debitos"]-$DatosConsulta["Creditos"];
                $Tercero=$DatosConsulta["Tercero"];
                $Cuentas["ClaseCuenta"][$CuentaPUC]=$Clase;
                $Cuentas["CuentaPUC"][$CuentaPUC]=$CuentaPUC;                
                $Cuentas["Nombre"][$CuentaPUC]=$DatosConsulta["NombreCuenta"];
                $Cuentas["Debitos"][$CuentaPUC]=$DatosConsulta["Debitos"];
                $Cuentas["Creditos"][$CuentaPUC]=$DatosConsulta["Creditos"];
                $Cuentas["Saldo"][$CuentaPUC]=$Saldo;
                if($Saldo<>0){
                    if(!isset($Flags[$CuentaPUC]) and isset($CuentasTraslados["CmbTercero"][$CuentaPUC]) and $CuentasTraslados["CmbTercero"][$CuentaPUC]<>''){
                        $Flags[$CuentaPUC]=1;
                        $TipoMovimiento="DB";
                        $TipoMovimientoMes13="CR";
                        if($CuentasTraslados["SaldoCuenta"][$CuentaPUC]<0){
                            $TipoMovimiento="CR";
                            $TipoMovimientoMes13="DB";
                        }
                        
                        $obCon->AgregaMovimientoDocumentoContable($idDocumento, $CuentasTraslados["CmbTercero"][$CuentaPUC], $CuentaPUC, $TipoMovimiento, abs($CuentasTraslados["SaldoCuenta"][$CuentaPUC]), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaTraslado);
                        $obCon->AgregaMovimientoDocumentoContable($idDocumento, $CuentasTraslados["CmbTercero"][$CuentaPUC], $CuentaPUC, $TipoMovimientoMes13, abs($CuentasTraslados["SaldoCuenta"][$CuentaPUC]), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaMes13);
                        continue;
                    }
                    if(!isset($Flags[$CuentaPUC])){
                        $TipoMovimiento="DB";
                        $TipoMovimientoMes13="CR";
                        if($Saldo<0){
                            $TipoMovimiento="CR";
                            $TipoMovimientoMes13="DB";
                        }

                        $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaPUC, $TipoMovimiento, abs($Saldo), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaTraslado);
                        $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaPUC, $TipoMovimientoMes13, abs($Saldo), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaMes13);
                        
                    }    
                }
                
            }
            
            $sql="SELECT SUM(Debito-Credito) AS Diferencia FROM documentos_contables_items WHERE idDocumento='$idDocumento'";
            $TotalConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalDocumentoContable=$TotalConsulta["Diferencia"];
            $Diferencia=$GananciaPerdidaBalance-$TotalDocumentoContable;  
            
            $GananciaPerdidaBalance=$GananciaPerdidaBalance-$Diferencia;
            
            if($GananciaPerdidaBalance>0){ //Si hay ganacia
                $CuentaGPPatrimonio=$obCon->DevuelveValores("parametros_contables", "ID", 11); //Cuenta patrimonio para utilidades 
               
                $obCon->AgregaMovimientoDocumentoContable($idDocumento, $DatosEmpresa["NIT"], $CuentaGPPatrimonio["CuentaPUC"], "CR", abs($GananciaPerdidaBalance), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaTraslado);
                
            }
            
            if($GananciaPerdidaBalance<0){ //si hay perdida
                $CuentaGPPatrimonio=$obCon->DevuelveValores("parametros_contables", "ID", 12); //Cuenta patrimonio para utilidades 
                
                $obCon->AgregaMovimientoDocumentoContable($idDocumento, $DatosEmpresa["NIT"], $CuentaGPPatrimonio["CuentaPUC"], "DB", abs($GananciaPerdidaBalance), "Cierre Contable Año $Anio","Cierre $Anio",  "",$FechaTraslado);
                
            }
                       
            $sql="UPDATE cierre_contable_control SET TrasladarSaldosBalance=1 WHERE Anio='$Anio' AND Estado=1";
            $obCon->Query($sql);
            
            print("OK;Traslado de cuentas de Balance agregadas");
        break;//Fin caso 2    
        case 3://Editar la cuenta de un registro contable
            $idLibro=$obCon->normalizar($_REQUEST["idLibro"]);
            $CuentaPUC=$obCon->normalizar($_REQUEST["CuentaPUC"]);
            $TodosLosRegistros=$obCon->normalizar($_REQUEST["TodosLosRegistros"]);
            if($idLibro==''){
                exit("E1;No se recibió el id del libro diario a editar");
            }
            if($CuentaPUC==''){
                exit("E1;No se recibió La Cuenta Contable");
            }
            $DatosCuenta=$obCon->DevuelveValores("subcuentas", "PUC", $CuentaPUC);
            
            $NombreCuenta=$DatosCuenta["Nombre"];
            $Condicion=" WHERE idLibroDiario='$idLibro' ";
            if($TodosLosRegistros==1){
                $DatosLibro=$obCon->DevuelveValores("librodiario", "idLibroDiario", $idLibro);
                $CuentaAEditar=$DatosLibro["CuentaPUC"];
                $Condicion="WHERE CuentaPUC='$CuentaAEditar'";
            
            }
            
            $sql="UPDATE librodiario SET CuentaPUC='$CuentaPUC',NombreCuenta='$NombreCuenta' $Condicion";
            
            $obCon->Query($sql);
            
            exit("OK;Se cambió el registro a la cuenta contable $CuentaPUC");
            
        break;//Fin caso 3 
        
        case 4://Editar el tercero de un registro contable
            $idLibro=$obCon->normalizar($_REQUEST["idLibro"]);
            $Tercero=$obCon->normalizar($_REQUEST["Tercero"]);
            if($idLibro==''){
                exit("E1;No se recibió el id del libro diario a editar");
            }
            if($Tercero==''){
                exit("E1;No se recibió el Tercero");
            }
            $DatosTercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $Tercero);
            
            $sql="UPDATE librodiario SET Tercero_Tipo_Documento='$DatosTercero[Tipo_Documento]',
                    Tercero_Identificacion='$DatosTercero[Num_Identificacion]',
                    Tercero_DV='$DatosTercero[DV]',
                    Tercero_Primer_Apellido='$DatosTercero[Primer_Apellido]',
                    Tercero_Segundo_Apellido='$DatosTercero[Segundo_Apellido]',
                    Tercero_Primer_Nombre='$DatosTercero[Primer_Nombre]',
                    Tercero_Otros_Nombres='$DatosTercero[Otros_Nombres]',
                    Tercero_Razon_Social='$DatosTercero[RazonSocial]', 
                        
                    Tercero_Direccion='$DatosTercero[Direccion]',
                    Tercero_Cod_Dpto='$DatosTercero[Cod_Dpto]',
                    Tercero_Cod_Mcipio='$DatosTercero[Cod_Mcipio]',
                    Tercero_Pais_Domicilio='$DatosTercero[Pais_Domicilio]'      

                    WHERE idLibroDiario='$idLibro'";
            
            $obCon->Query($sql);
            
            exit("OK;Se cambió el registro al Tercero $Tercero");
            
        break;//Fin caso 4
        
        case 5://editar el registro de una tabla
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $ValorEditar=$obCon->normalizar($_REQUEST["ValorEditar"]);
            $ColumnaEditar=$obCon->normalizar($_REQUEST["ColumnaEditar"]);
            $idCaja=$obCon->normalizar($_REQUEST["idCaja"]);
            
            if($Tabla==''){
                exit("E1; No se recibió la tabla a editar");
            }
            if(!is_numeric($ValorEditar) ){
                exit("E1;El Valor a Editar debe ser un número;$idCaja");
            }
            if($ColumnaEditar==''){
                exit("E1; No se recibió la Columna a editar");
            }
            if($idItem==''){
                exit("E1; No se recibió id del registro a editar");
            }
            
            if($Tabla==1){
                $TablaEdit="librodiario";
                $idTabla="idLibroDiario";
            }
            
            $sql="UPDATE $TablaEdit SET $ColumnaEditar='$ValorEditar' WHERE $idTabla='$idItem' ";
            $obCon->Query($sql);
            exit("OK;La Columna $ColumnaEditar del Registo $idItem fue editada con el valor $ValorEditar");
        break;//Fin caso 5    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>