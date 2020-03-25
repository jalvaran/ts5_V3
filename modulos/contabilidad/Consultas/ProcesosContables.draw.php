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
        case 1: //dibuja el balance y estado de resultadoss
            
            $Empresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            $Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            
            if($Empresa==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR UNA EMPRESA PARA CERRAR</strong>","rojo");
                exit();
            }
            
            
            if($Anio==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR UN AÑO PARA CERRAR</strong>","rojo");
                exit();
            }
            
            if($idDocumento==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR DOCUMENTO DONDE SE REALIZARÁ EL CIERRE</strong>","rojo");
                 exit();
            }
            
            $sql="SELECT ID FROM cierre_contable_control WHERE Anio='$Anio' AND Estado=2";            
            $DatosControlCierre=$obCon->FetchAssoc($obCon->Query($sql));
            if($DatosControlCierre["ID"]<>''){
                $css->CrearTitulo("<strong>EL AÑO $Anio ya fué cerrado</strong>","rojo");
                exit();
            }
            $sql="SELECT ID FROM cierre_contable_control WHERE Anio='$Anio' AND Estado=1";            
            $DatosControlCierre=$obCon->FetchAssoc($obCon->Query($sql));
            
            if($DatosControlCierre["ID"]==''){
                $Datos["idDocumentoContable"]=$idDocumento;
                $Datos["Anio"]=$Anio;
                $Datos["idUser"]=$idUser;
                $Datos["Estado"]=1;
                $Datos["Created"]=date("Y-m-d");
                $sql=$obCon->getSQLInsert("cierre_contable_control", $Datos);
                $obCon->Query($sql);
            }
            
            $FechaInicial="$Anio-01-01";
            $FechaFinal="$Anio-12-31";
            $Condicion=" WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' ";
            
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
                
            }
            //Cambio las cuentas que son naturaleza credito
            $TotalPasivos=$TotalPasivos*(-1);
            $TotalPatrimonio=$TotalPatrimonio*(-1);
            $TotalIngresos=$TotalIngresos*(-1);
            $TotalGananciaPerdidaBalance=($TotalActivos-$TotalPasivos)-$TotalPatrimonio;
            $TotalGananciaPerdidaResultados=$TotalIngresos-$TotalCostosVenta-$TotalCostosProduccion-$TotalGastos;
            
            $css->input("hidden", "GananciaPerdidaBalance", "", "", "", $TotalGananciaPerdidaBalance, "", "", "", "");
            $css->input("hidden", "GananciaPerdidaResultados", "", "", "", $TotalGananciaPerdidaResultados, "", "", "", "");
            $css->CrearTitulo("<strong>BALANCE GENERAL</strong>", "naranja");
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ACTIVOS</strong>", 1);
                    $css->ColTabla("<strong>PASIVOS</strong>", 1);
                    $css->ColTabla("<strong>ACTIVOS + PASIVOS</strong>", 1);
                    $css->ColTabla("<strong>PATRIMONIO</strong>", 1);
                    $css->ColTabla("<strong>GANANCIA || PERDIDA</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(number_format($TotalActivos), 1);
                    $css->ColTabla(number_format($TotalPasivos), 1);
                    $css->ColTabla(number_format($TotalActivos-$TotalPasivos), 1);
                    $css->ColTabla(number_format($TotalPatrimonio), 1);
                    $css->ColTabla(number_format($TotalGananciaPerdidaBalance), 1);
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            $css->CrearTitulo("<strong>ESTADO DE RESULTADOS</strong>", "verde");
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>INGRESOS</strong>", 1);
                    $css->ColTabla("<strong>COSTOS DE VENTA</strong>", 1);
                    $css->ColTabla("<strong>COSTOS DE PRODUCCION</strong>", 1);
                    $css->ColTabla("<strong>GASTOS</strong>", 1);
                    $css->ColTabla("<strong>GANANCIA || PERDIDA</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla(number_format($TotalIngresos), 1);
                    $css->ColTabla(number_format($TotalCostosVenta), 1);
                    $css->ColTabla(number_format($TotalCostosProduccion), 1);
                    $css->ColTabla(number_format($TotalGastos), 1);
                    $css->ColTabla(number_format($TotalGananciaPerdidaResultados), 1);
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->CrearBotonEvento("BtnCuentasResultados", "Ver Cuentas de Resultado", 1, "onclick", "DibujeAgrupacionCuentas(2)", "azul");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->CrearBotonEvento("BtnCuentasOrden", "Ver Cuentas del Balance", 1, "onclick", "DibujeAgrupacionCuentas(3)", "verde");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->CrearBotonEvento("BtnContabilizarCierre", "Contabilizar el Cierre", 1, "onclick", "ConfirmeContabilizarCierre()", "naranja");
            $css->CerrarDiv();
            print("<br><br>");
            $css->CrearDiv("DivDrawCuentas", "col-md-12", "center", 1, 1);
            
            $css->CerrarDiv();
            
        break; //Fin caso 1
        
        case 2: //Dibuja las cuentas de resultados
            
            $Empresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            $Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            
            if($Empresa==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR UNA EMPRESA PARA CERRAR</strong>","rojo");
                exit();
            }
            
            
            if($Anio==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR UN AÑO PARA CERRAR</strong>","rojo");
                exit();
            }
            
            if($idDocumento==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR DOCUMENTO DONDE SE REALIZARÁ EL CIERRE</strong>","rojo");
                 exit();
            }
            $FechaInicial="$Anio-01-01";
            $FechaFinal="$Anio-12-31";
            $Condicion=" WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' ";
            
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
                
            }
            //Cambio las cuentas que son naturaleza credito
            $TotalPasivos=$TotalPasivos*(-1);
            $TotalPatrimonio=$TotalPatrimonio*(-1);
            $TotalIngresos=$TotalIngresos*(-1);
            $TotalGananciaPerdidaBalance=($TotalActivos-$TotalPasivos)-$TotalPatrimonio;
            $TotalGananciaPerdidaResultados=$TotalIngresos-$TotalCostosVenta-$TotalCostosProduccion-$TotalGastos;
            $css->CrearDiv("", "col-md-8", "center", 1, 1);
            
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->CrearBotonEvento("BtnCerrarCuentasResultado", "Cerrar Cuentas de Resultado", 1, "onclick", "ConfirmaCierreCuentasResultados()", "rojo");
            $css->CerrarDiv();
            print("<br>");
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>CUENTAS DE RESULTADO:</strong>", 6,"C");
                    $css->CierraFilaTabla();

                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>CLASE</strong>", 1);
                        $css->ColTabla("<strong>CUENTA</strong>", 1);
                        $css->ColTabla("<strong>NOMBRE</strong>", 1);
                        $css->ColTabla("<strong>DEBITO</strong>", 1);
                        $css->ColTabla("<strong>CREDITO</strong>", 1);
                        $css->ColTabla("<strong>SALDO</strong>", 1);
                    $css->CierraFilaTabla();

                    foreach ($Cuentas["CuentaPUC"] as $key => $value){

                        if($Cuentas["Saldo"][$key]<>0){
                            if($Cuentas["ClaseCuenta"][$key]==4 or $Cuentas["ClaseCuenta"][$key]==5 or $Cuentas["ClaseCuenta"][$key]==6 or $Cuentas["ClaseCuenta"][$key]==6){
                                $css->FilaTabla(16);
                                    $css->ColTabla($Cuentas["ClaseCuenta"][$key], 1);
                                    $css->ColTabla($Cuentas["CuentaPUC"][$key], 1);
                                    $css->ColTabla(utf8_encode($Cuentas["Nombre"][$key]), 1);
                                    $css->ColTabla(number_format($Cuentas["Debitos"][$key]), 1);
                                    $css->ColTabla(number_format($Cuentas["Creditos"][$key]), 1);
                                    $css->ColTabla(number_format($Cuentas["Saldo"][$key]), 1);
                                $css->CierraFilaTabla();
                            }
                        }
                    }

                $css->CerrarTabla();
            $css->CerrarDiv();
        break; //Fin caso 2
        
        case 3: //Dibuja las cuentas de balance
            
            $Empresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            $Anio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            
            if($Empresa==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR UNA EMPRESA PARA CERRAR</strong>","rojo");
                exit();
            }
            
            
            if($Anio==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR UN AÑO PARA CERRAR</strong>","rojo");
                exit();
            }
            
            if($idDocumento==''){
                $css->CrearTitulo("<strong>DEBES SELECCIONAR DOCUMENTO DONDE SE REALIZARÁ EL CIERRE</strong>","rojo");
                 exit();
            }
            $FechaInicial="$Anio-01-01";
            $FechaFinal="$Anio-12-31";
            $Condicion=" WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' ";
            
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
                
            }
            //Cambio las cuentas que son naturaleza credito
            $TotalPasivos=$TotalPasivos*(-1);
            $TotalPatrimonio=$TotalPatrimonio*(-1);
            $TotalIngresos=$TotalIngresos*(-1);
            $TotalGananciaPerdidaBalance=($TotalActivos-$TotalPasivos)-$TotalPatrimonio;
            $TotalGananciaPerdidaResultados=$TotalIngresos-$TotalCostosVenta-$TotalCostosProduccion-$TotalGastos;
            $css->CrearDiv("", "col-md-8", "center", 1, 1);
            
            $css->CerrarDiv();
            $css->form("frmTrasladarCuentas", "form-class", "frmTrasladarCuentas", "post", "procesadores/ProcesosContables.php", "#", "", "onsubmit=ConfirmaCierreCuentasBalance();return false;");
            //$css->input("hidden", "Accion", "", "Accion", "", 2, "", "", "", "");
            //$css->input("hidden", "idEmpresa", "", "idEmpresa", "", $Empresa, "", "", "", "");
            //$css->input("hidden", "CmbAnio", "", "CmbAnio", "", $Anio, "", "", "", "");
            //$css->input("hidden", "idDocumento", "", "idDocumento", "", $idDocumento, "", "", "", "");
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                //$css->input("submit", "BtnTrasladarCuentasBalance", "btn btn-danger", "BtnTrasladarCuentasBalance", "Enviar", "Trasladar Cuentas de Balance", "", "", "", "");
                $css->CrearBotonEvento("BtnTrasladarCuentasBalance", "Trasladar Cuentas de Balance", 1, "onclick", "ConfirmaCierreCuentasBalance()", "rojo");
            $css->CerrarDiv();   
            print("<br>");
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>CUENTAS DE BALANCE:</strong>", 8,"C");
                    $css->CierraFilaTabla();

                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>CUENTA:</strong>", 4,"C");
                        $css->ColTabla("<strong>TRASLADAR SALDO AL TERCERO:</strong>", 2,"C");
                    $css->CierraFilaTabla();

                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>CLASE</strong>", 1);
                        $css->ColTabla("<strong>CUENTA</strong>", 1);
                        $css->ColTabla("<strong>NOMBRE</strong>", 1);
                        //$css->ColTabla("<strong>DEBITO</strong>", 1);
                        //$css->ColTabla("<strong>CREDITO</strong>", 1);
                        $css->ColTabla("<strong>SALDO</strong>", 1);
                        $css->ColTabla("<strong>TERCERO</strong>", 2);
                    $css->CierraFilaTabla();

                    foreach ($Cuentas["CuentaPUC"] as $key => $value){

                        if($Cuentas["Saldo"][$key]<>0){
                            if($Cuentas["ClaseCuenta"][$key]==1 or $Cuentas["ClaseCuenta"][$key]==2 or $Cuentas["ClaseCuenta"][$key]==3){
                                $CuentaPUC=$Cuentas["CuentaPUC"][$key];
                                $css->FilaTabla(16);
                                    $css->ColTabla($Cuentas["ClaseCuenta"][$key], 1);
                                    $css->ColTabla($Cuentas["CuentaPUC"][$key], 1);
                                    $css->ColTabla(utf8_encode($Cuentas["Nombre"][$key]), 1);                                
                                    $css->ColTabla(number_format($Cuentas["Saldo"][$key]), 1);
                                    $idSelect="CmbTercero_".$CuentaPUC;
                                    print("<td colspan=2>");
                                        print('<div class="input-group input-group-md">');
                                            $css->input("hidden", "SaldoCuenta_".$CuentaPUC, "", "SaldoCuenta[$CuentaPUC]", "", $Cuentas["Saldo"][$CuentaPUC], "", "", "", "");
                                            $css->select($idSelect, "SelectTercero", "CmbTercero[$CuentaPUC]", "", "", "", "style=width:300px;",0);
                                                $css->option("", "", "", "", "", "");
                                                    print("Seleccionar Tercero");
                                                $css->Coption();
                                            $css->Cselect();
                                            print('<span class="input-group-btn">
                                                <button type="button" class="btn btn-primary btn-flat" onclick="LimpiarSelect(`'.$idSelect.'`)"><i class="fa fa-minus-square"></i></button>
                                              </span>');
                                            
                                            
                                        print("</div>");    
                                    print("</td>");
                                $css->CierraFilaTabla();
                            }
                        }
                    }

                $css->CerrarTabla();
                
            $css->CerrarDiv();    
            $css->Cform();
        break; //Fin caso 3
        
        case 4://Dibuja los registros contables que no tienen cuenta contable
            $idEmpresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            
            if($idEmpresa==''){
                $css->CrearTitulo("<strong>Por favor selecciona una Empresa</strong>", "rojo");
                exit();
            }
            
            $css->CrearTitulo("<strong>Registros Sin Cuenta Contable</strong>", "azul");
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ID</strong>", 1);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Documento</strong>", 1);
                    $css->ColTabla("<strong>Numero del Documento</strong>", 1);
                    $css->ColTabla("<strong>Referencia</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    $css->ColTabla("<strong>Cuenta</strong>", 1);
                    $css->ColTabla("<strong>Debito</strong>", 1);
                    $css->ColTabla("<strong>Credito</strong>", 1);
                $css->CierraFilaTabla();
                
                $sql="SELECT * FROM librodiario WHERE (CuentaPUC='' or CuentaPUC=0) AND idEmpresa='$idEmpresa' LIMIT 15";
                $Consulta=$obCon->Query($sql);
                while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosLibro["idLibroDiario"];
                    $css->FilaTabla(16);
                        $css->ColTabla($idItem, 1);
                        $css->ColTabla($DatosLibro["Fecha"], 1);
                        $css->ColTabla($DatosLibro["Tipo_Documento_Intero"], 1);
                        $css->ColTabla($DatosLibro["Num_Documento_Interno"], 1);
                        $css->ColTabla($DatosLibro["Num_Documento_Externo"], 1);
                        $css->ColTabla($DatosLibro["Tercero_Razon_Social"]." ".$DatosLibro["Tercero_Identificacion"], 1);
                        print("<td>");
                            print('<div class="input-group input-group-md">');
                                $css->select("cmbCuentaPUCAuditoria_".$idItem, "cmbCuentaPUC", "cmbCuentaPUCAuditoria", "", "", "", "style=width:300px;");
                                    $css->option("", "", "", "", "", "");
                                        print("Seleccione una Cuenta Contable");
                                    $css->Coption();
                                $css->Cselect();
                                print('<span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-flat" onclick="EditarCuentaContable(`'.$idItem.'`,`'."cmbCuentaPUCAuditoria_".$idItem.'`)"><i class="fa fa-edit"></i></button>
                                      </span>');
                                            
                                            
                            print("</div>");
                        print("</td>");
                        $css->ColTabla(number_format($DatosLibro["Debito"]), 1);
                        $css->ColTabla(number_format($DatosLibro["Credito"]), 1);
                    $css->CierraFilaTabla();
                }
                
            $css->CerrarTabla();
        break;//fin caso 4   
        
        case 5://Dibuja los registros contables que no tienen tercero
            $idEmpresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            
            if($idEmpresa==''){
                $css->CrearTitulo("<strong>Por favor selecciona una Empresa</strong>", "rojo");
                exit();
            }
            
            $css->CrearTitulo("<strong>Registros Sin Tercero</strong>", "verde");
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ID</strong>", 1);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Documento</strong>", 1);
                    $css->ColTabla("<strong>Numero del Documento</strong>", 1);
                    $css->ColTabla("<strong>Referencia</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    $css->ColTabla("<strong>Cuenta</strong>", 1);
                    $css->ColTabla("<strong>Debito</strong>", 1);
                    $css->ColTabla("<strong>Credito</strong>", 1);
                $css->CierraFilaTabla();
                
                $sql="SELECT * FROM librodiario WHERE (Tercero_Identificacion='' or Tercero_Identificacion=0) AND idEmpresa='$idEmpresa' LIMIT 15";
                $Consulta=$obCon->Query($sql);
                while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosLibro["idLibroDiario"];
                    $css->FilaTabla(16);
                        $css->ColTabla($idItem, 1);
                        $css->ColTabla($DatosLibro["Fecha"], 1);
                        $css->ColTabla($DatosLibro["Tipo_Documento_Intero"], 1);
                        $css->ColTabla($DatosLibro["Num_Documento_Interno"], 1);
                        $css->ColTabla($DatosLibro["Num_Documento_Externo"], 1);
                        
                        print("<td>");
                            print('<div class="input-group input-group-md">');
                                $css->select("cmbTercero_".$idItem, "cmbTercero", "cmbTercero", "", "", "", "style=width:300px;");
                                    $css->option("", "", "", "", "", "");
                                        print("Seleccione un tercero");
                                    $css->Coption();
                                $css->Cselect();
                                print('<span class="input-group-btn">
                                        <button type="button" class="btn btn-primary btn-flat" onclick="EditarTerceroEnRegistroContable(`'.$idItem.'`,`'."cmbTercero_".$idItem.'`)"><i class="fa fa-edit"></i></button>
                                      </span>');
                                            
                                            
                            print("</div>");
                        print("</td>");
                        $css->ColTabla($DatosLibro["CuentaPUC"]." ".$DatosLibro["NombreCuenta"], 1);
                        $css->ColTabla(number_format($DatosLibro["Debito"]), 1);
                        $css->ColTabla(number_format($DatosLibro["Credito"]), 1);
                    $css->CierraFilaTabla();
                }
                
            $css->CerrarTabla();
        break;//fin caso 5
        
        case 6://Dibuja los registros contables en una cuenta padre
            $idEmpresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            
            if($idEmpresa==''){
                $css->CrearTitulo("<strong>Por favor selecciona una Empresa</strong>", "rojo");
                exit();
            }
            
            $css->CrearTitulo("<strong>Registros En Cuentas Padre</strong>", "naranja");
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ID</strong>", 1);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Documento</strong>", 1);
                    $css->ColTabla("<strong>Numero del Documento</strong>", 1);
                    $css->ColTabla("<strong>Referencia</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    $css->ColTabla("<strong>Cuenta Actual</strong>", 1);
                    $css->ColTabla("<strong>Editar Cuenta A</strong>", 1);
                    $css->ColTabla("<strong>Debito</strong>", 1);
                    $css->ColTabla("<strong>Credito</strong>", 1);
                $css->CierraFilaTabla();
                
                $sql="SELECT * FROM librodiario WHERE LENGTH(CuentaPUC) <=4 AND idEmpresa='$idEmpresa' LIMIT 15";
                $Consulta=$obCon->Query($sql);
                while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosLibro["idLibroDiario"];
                    $css->FilaTabla(16);
                        $css->ColTabla($idItem, 1);
                        $css->ColTabla($DatosLibro["Fecha"], 1);
                        $css->ColTabla($DatosLibro["Tipo_Documento_Intero"], 1);
                        $css->ColTabla($DatosLibro["Num_Documento_Interno"], 1);
                        $css->ColTabla($DatosLibro["Num_Documento_Externo"], 1);
                        $css->ColTabla($DatosLibro["Tercero_Razon_Social"]." ".$DatosLibro["Tercero_Identificacion"], 1);
                        $css->ColTabla(($DatosLibro["CuentaPUC"]), 1);
                        print("<td>");
                            print('<div class="input-group input-group-md">');
                                $css->select("cmbCuentaPUCAuditoria_".$idItem, "cmbCuentaPUC", "cmbCuentaPUCAuditoria", "", "", "", "style=width:300px;");
                                    $css->option("", "", "", "", "", "");
                                        print("Seleccione una Cuenta Contable");
                                    $css->Coption();
                                $css->Cselect();
                                print('<span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-flat" title="Editar solo este registro" onclick="EditarCuentaContable(`'.$idItem.'`,`'."cmbCuentaPUCAuditoria_".$idItem.'`)"><i class="fa fa-edit"></i></button>
                                      </span>');
                                print('<span class="input-group-btn">
                                        <button type="button" class="btn btn-danger btn-flat" title="Editar todos los registros con esta cuenta" onclick="EditarCuentaContable(`'.$idItem.'`,`'."cmbCuentaPUCAuditoria_".$idItem.'`,`1`)"><i class="fa fa-retweet"></i></button>
                                      </span>');
                                            
                                            
                            print("</div>");
                        print("</td>");
                        $css->ColTabla(number_format($DatosLibro["Debito"]), 1);
                        $css->ColTabla(number_format($DatosLibro["Credito"]), 1);
                    $css->CierraFilaTabla();
                }
                
            $css->CerrarTabla();
        break;//fin caso 6
        
        case 7://Dibuja los documentos Contables descuadrados
            $idEmpresa=$obCon->normalizar($_REQUEST["idEmpresa"]);
            
            if($idEmpresa==''){
                $css->CrearTitulo("<strong>Por favor selecciona una Empresa</strong>", "rojo");
                exit();
            }
            $css->CrearDiv("DivDocumentosDescuadrados", "col-md-6", "left", 1, 1);
                $css->CrearTitulo("<strong>Documentos Descuadrados</strong>", "rojo");

                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Documento</strong>", 1);
                        $css->ColTabla("<strong>Numero</strong>", 1);
                        $css->ColTabla("<strong>Referencia</strong>", 1);                    
                        $css->ColTabla("<strong>Saldo</strong>", 1);
                        $css->ColTabla("<strong>Neto</strong>", 1);
                        $css->ColTabla("<strong>Ver</strong>", 1);
                    $css->CierraFilaTabla();

                    $sql="SELECT * FROM vista_auditoria_librodiario_documento_sin_balance WHERE idEmpresa='$idEmpresa' LIMIT 15";
                    $Consulta=$obCon->Query($sql);
                    while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                        $TipoDocumento=$DatosLibro["Tipo_Documento_Intero"];
                        $NumeroDocumento=$DatosLibro["Num_Documento_Interno"];
                        $css->FilaTabla(16);

                            $css->ColTabla($DatosLibro["Tipo_Documento_Intero"], 1);
                            $css->ColTabla($DatosLibro["Num_Documento_Interno"], 1);
                            $css->ColTabla($DatosLibro["Num_Documento_Externo"], 1);
                            $css->ColTabla(number_format($DatosLibro["TotalSaldo"]), 1);
                            $css->ColTabla(number_format($DatosLibro["SaldoNeto"]), 1);
                            print("<td>");
                                print('<div class="input-group input-group-md">');

                                    print('<span class="input-group-btn">
                                            <button type="button" class="btn btn-warning btn-flat" onclick="VerDocumentoDescuadrado(`'.$TipoDocumento.'`,`'.$NumeroDocumento.'`)"><i class="fa fa-eye"></i></button>
                                          </span>');


                                print("</div>");
                            print("</td>");
                        $css->CierraFilaTabla();
                    }

                $css->CerrarTabla();
            $css->CerrarDiv();
            
            $css->CrearDiv("DivMovimientosDocumentoDescuadrado", "col-md-6", "left", 1, 1);
            
            $css->CerrarDiv();
            
        break;//fin caso 7
        
        case 8://Veo los movimientos de un documento contable
            $TipoDocumento=$obCon->normalizar($_REQUEST["TipoDocumento"]);
            $NumeroDocumento=$obCon->normalizar($_REQUEST["NumeroDocumento"]);
            
            if($TipoDocumento==''){
                $css->CrearTitulo("<strong>No se recibió un tipo de documento</strong>", "rojo");
                exit();
            }
            
            if($NumeroDocumento==''){
                $css->CrearTitulo("<strong>No se recibió un Número de documento</strong>", "rojo");
                exit();
            }
            
            $css->CrearTitulo("<strong>Movimientos del $TipoDocumento No. $NumeroDocumento </strong>", "rojo");
            
            $sql="SELECT * FROM librodiario WHERE Tipo_Documento_Intero='$TipoDocumento' AND Num_Documento_Interno='$NumeroDocumento'";
            $Consulta=$obCon->Query($sql);
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Cuenta</strong>", 1);
                    $css->ColTabla("<strong>Debito</strong>", 1);
                    $css->ColTabla("<strong>Credito</strong>", 1);
                    $css->ColTabla("<strong>Neto</strong>", 1);
                $css->CierraFilaTabla();
            
            while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosLibro["idLibroDiario"];
                $css->FilaTabla(16);
                    $css->ColTabla($DatosLibro["CuentaPUC"], 1);
                    print("<td>");
                        $idCaja="TxtDebito_".$idItem;
                        $css->input("text", "TxtDebito_".$idItem, "form-control", "TxtDebito_".$idItem, "", $DatosLibro["Debito"], "Debito", "off", "", "onchange=EditarRegistroAuditoria(`1`,`$idItem`,`$idCaja`,`Debito`)");
                    print("</td>");
                    print("<td>");
                        $idCaja="TxtCredito_".$idItem;
                        $css->input("text", "TxtCredito_".$idItem, "form-control", "TxtCredito_".$idItem, "", $DatosLibro["Credito"], "Credito", "off", "", "onchange=EditarRegistroAuditoria(`1`,`$idItem`,`$idCaja`,`Credito`)");
                    print("</td>");
                    print("<td>");
                        $idCaja="TxtNeto_".$idItem;
                        $css->input("text", "TxtNeto_".$idItem, "form-control", "TxtNeto_".$idItem, "", $DatosLibro["Neto"], "Neto", "off", "", "onchange=EditarRegistroAuditoria(`1`,`$idItem`,`$idCaja`,`Neto`)");
                    print("</td>");
                $css->CierraFilaTabla();
            }
            
            $css->CerrarTabla();
            
        break;//Fin caso 8    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>