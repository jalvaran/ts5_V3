<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");
include_once("../../../modelo/php_conexion.php");
include_once("../../../modelo/PrintPos.php");
include_once("../../../general/clases/contabilidad.class.php");

if( !empty($_REQUEST["Accion"]) ){
    
    
    $obCon = new contabilidad($idUser);
    $obPrint = new PrintPos($idUser);
    switch ($_REQUEST["Accion"]) {
        
                
        case 1: //Abonar a una cuenta
            
            $Tercero=$obCon->normalizar($_REQUEST["cmbTercero"]);
            $ValorAbono=$obCon->normalizar($_REQUEST["txtAbono"]);
            
            if(!is_numeric($ValorAbono) or $ValorAbono<0){
                exit("E1;El valor del abono debe ser un numero mayor a cero");
            }
            
            if($Tercero==""){
                exit("E1;Debe seleccionar un tercero");
            }
            if(isset($_REQUEST["idEmpresa"])){
                $idEmpresa=$_REQUEST["idEmpresa"];
            }else{
                $idEmpresa=1;
            }
            if(isset($_REQUEST["idSucursal"])){
                $idSucursal=$_REQUEST["idSucursal"];
            }else{
                $idSucursal=1;
            }
            if(isset($_REQUEST["idCentroCostos"])){
                $idCentroCostos=$_REQUEST["idCentroCostos"];
            }else{
                $idCentroCostos=1;
            }
            
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 10); //Efectivo
            $CuentaDebito=$Parametros["CuentaPUC"];
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Contrapartida del comprobante de ingreso aqui se aloja la cuenta de clientes
            $CuentaCredito=$Parametros["CuentaPUC"];
            $Fecha=date("Y-m-d");
            
            
            $idComprobante=$obCon->CrearComprobanteIngreso($Fecha, "", $Tercero, $ValorAbono, "Abono Recaudo", "Ingreso por Recaudo", "CERRADO");
            //$obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);
            
            $sql="SELECT SUM(Total) as Total FROM `vista_cuentasxcobrardetallado` WHERE Total>1 AND Tercero_Identificacion = '$Tercero' LIMIT 1";
            $arrayTotal=$obCon->FetchAssoc($obCon->Query($sql));
            $Total=$arrayTotal["Total"];
            if($ValorAbono>$Total){
                exit("E1;El valor del abono no puede ser superior al total de la deuda del tercero");
            }
            $DatosCuentaDebito= $obCon->DevuelveValores("subcuentas", "PUC", $CuentaDebito);
            $DatosCuentaCredito= $obCon->DevuelveValores("subcuentas", "PUC", $CuentaCredito);
            
            $sql="SELECT * FROM `vista_cuentasxcobrardetallado` WHERE Total>1 AND Tercero_Identificacion = '$Tercero' ";
            $Consulta=$obCon->Query($sql);
            $AbonoRestante=$ValorAbono;
            $NuevoSaldo=$Total-$ValorAbono;
            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                
                if($AbonoRestante<=$DatosConsulta["Total"]){
                    $Abono=$AbonoRestante;
                }else{
                    $Abono=$DatosConsulta["Total"];
                }
                $obCon->IngreseMovimientoLibroDiario($Fecha, "ComprobanteIngreso", $idComprobante, $DatosConsulta["NumeroDocumentoExterno"], $Tercero, $CuentaDebito, $DatosCuentaDebito["Nombre"], "Ingreso", "DB", $Abono, "Ingreso por recaudo", $idCentroCostos, $idSucursal, "");
                $obCon->IngreseMovimientoLibroDiario($Fecha, "ComprobanteIngreso", $idComprobante, $DatosConsulta["NumeroDocumentoExterno"], $Tercero, $CuentaCredito, $DatosCuentaCredito["Nombre"], "Ingreso", "CR", $Abono, "Ingreso por recaudo", $idCentroCostos, $idSucursal, "");
                $AbonoRestante=$AbonoRestante-$Abono;
                if($AbonoRestante<=0){
                    break;
                }
            }
            $obPrint->ComprobanteIngresoPOS($idComprobante, "", 1);
            $LinkFactura="../../VAtencion/PDF_Documentos.php?idDocumento=4&idIngreso=$idComprobante";
            $Mensaje="<br><strong>Comprobande de ingreso No. $idComprobante Creado Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
            
            print("OK;Pago Ingresado, Nuevo saldo del Tercero <strong>$Tercero</strong>: <h2><strong>". number_format($NuevoSaldo)."</h2></strong>;$Mensaje");
        break; //fin caso 1
        
          
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
