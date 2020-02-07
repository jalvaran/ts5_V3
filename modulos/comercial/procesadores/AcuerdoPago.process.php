<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/AcuerdoPago.class.php");
include_once("../clases/AcuerdoPago.print.class.php");

include_once("../../../general/clases/contabilidad.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new AcuerdoPago($idUser);
    $obPrint=new AcuerdoPagoPrint($idUser);
    $obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Imprimir acuerdo de pago
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            if($idAcuerdo==''){
                exit("E1;No se recibió el id del acuerdo");
            }    
            $obPrint->PrintAcuerdoPago($idAcuerdo, 1, 0);
            print("OK;Acuerdo impreso");
        break; //fin caso 1
        
        
        case 2: //Abonar a un acuerdo de pago
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $MetodoPago=$obCon->normalizar($_REQUEST["CmbMetodoPagoAbonoAcuerdo"]);
            $ValorAbono=$obCon->normalizar($_REQUEST["TxtValorAbonoAcuerdoExistente"]);
            
            if($idAcuerdo==''){
                exit("E1;No se recibió el id del acuerdo");
            }    
            if($MetodoPago==''){
                exit("E1;No se recibió un metodo de pago");
            }
            if(!is_numeric($ValorAbono) or $ValorAbono<=0){
                exit("E1;El valor del abono debe ser un numero mayor a cero");
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
            $obCon->AbonarAcuerdoPago($idAcuerdo,$MetodoPago,$ValorAbono,$idUser);
            $sql="UPDATE acuerdo_pago SET TotalAbonos=(TotalAbonos+$ValorAbono),SaldoFinal=(SaldoInicial-TotalAbonos) WHERE idAcuerdoPago='$idAcuerdo'";
            $obCon->Query($sql);
            
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            if($MetodoPago==1){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 10); //Efectivo
                $CuentaDestino=$Parametros["CuentaPUC"];
            
            }elseif($MetodoPago==2 or $MetodoPago==3){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 17); //Bancos
                $CuentaDestino=$Parametros["CuentaPUC"];
            }else{
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 30); //Otras formas de pago
                $CuentaDestino=$Parametros["CuentaPUC"];
            }
            
            
            $Tercero=$DatosAcuerdo["Tercero"];
            $Fecha=date("Y-m-d");
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Contrapartida del comprobante de ingreso aqui se aloja la cuenta de clientes
            $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $ValorAbono, "AbonoAcuerdoPago", "Ingreso por Acuerdo de Pago $idAcuerdo", "CERRADO");
            $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);
            $obPrint->PrintAcuerdoPago($idAcuerdo, 1, 0);
            print("OK;Pago Ingresado");
        break; //fin caso 2
        
             
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
