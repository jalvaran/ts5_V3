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
            $RecargosIntereses=$obCon->normalizar($_REQUEST["TxtRecargosIntereses"]);
            
            if($idAcuerdo==''){
                exit("E1;No se recibió el id del acuerdo");
            }    
            if($MetodoPago==''){
                exit("E1;No se recibió un metodo de pago");
            }
            if(!is_numeric($ValorAbono) or $ValorAbono<0){
                exit("E1;El valor del abono debe ser un numero mayor a cero");
            }
            if(!is_numeric($RecargosIntereses) or $RecargosIntereses<0){
                exit("E1;El valor de los recargos o intereses debe ser un numero positivo");
            }
            if($RecargosIntereses==0 and $ValorAbono==0){
                exit("E1;El valor de los abonos y de los intereses es cero");
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
            
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            
            if($MetodoPago==1){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 10); //Efectivo
                $CuentaDestino=$Parametros["CuentaPUC"];
            
            }elseif($MetodoPago==2 or $MetodoPago==3){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 17); //Bancos
                $CuentaDestino=$Parametros["CuentaPUC"];
            }elseif($MetodoPago==10){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 36); //Saldo a Favor de un cliente
                $CuentaDestino=$Parametros["CuentaPUC"];
                
                $CuentaPUCSaldoFavor=$Parametros["CuentaPUC"];
                $sql="SELECT SUM(Debito-Credito) as Saldo  FROM librodiario WHERE Tercero_Identificacion='$Tercero' AND CuentaPUC='$CuentaPUCSaldoFavor'";
                $Totales=$obCon->FetchAssoc($obCon->Query($sql));
                $SaldoAFavor=$Totales["Saldo"]*(-1);
                if($SaldoAFavor<$ValorAbono){
                    exit("E1;El Saldo a Favor del cliente es menor al Valor del Abono");
                }
            }elseif($MetodoPago==11){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 35); //Anticipos de un cliente
                $CuentaDestino=$Parametros["CuentaPUC"];    
                $CuentaPUCSaldoFavor=$Parametros["CuentaPUC"];
                $sql="SELECT SUM(Debito-Credito) as Saldo  FROM librodiario WHERE Tercero_Identificacion='$Tercero' AND CuentaPUC='$CuentaPUCSaldoFavor'";
                $Totales=$obCon->FetchAssoc($obCon->Query($sql));
                $TotalAnticipos=$Totales["Saldo"]*(-1);
                if($TotalAnticipos<$ValorAbono){
                    exit("E1;Los Anticipos del cliente Son menores al Valor del Abono");
                }   
            }else{
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 30); //Otras formas de pago
                $CuentaDestino=$Parametros["CuentaPUC"];
            }
            
            
            $Tercero=$DatosAcuerdo["Tercero"];
            $Fecha=date("Y-m-d");
            if($ValorAbono>0){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Contrapartida del comprobante de ingreso aqui se aloja la cuenta de clientes
                $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $ValorAbono, "AbonoAcuerdoPago", "Ingreso por Acuerdo de Pago $idAcuerdo", "CERRADO");
                $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);

                $obCon->AbonarAcuerdoPago($idAcuerdo,$MetodoPago,$ValorAbono,$idUser);

                $sql="UPDATE acuerdo_pago SET TotalAbonos=(TotalAbonos+$ValorAbono),SaldoFinal=(SaldoInicial-TotalAbonos) WHERE idAcuerdoPago='$idAcuerdo'";
                $obCon->Query($sql);
            }
            
            if($RecargosIntereses>0){
                $idInteres=$obCon->InteresesAcuerdoPagos($idAcuerdo, $RecargosIntereses, $MetodoPago, $idUser);
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 38); //ingresos no operacionales por recargos o intereses
                $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $RecargosIntereses, "RecargoInteresAcuerdoPago", "Ingreso por Interes o Recargo de Pago $idAcuerdo", "CERRADO");
                $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);

            }
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            if($DatosAcuerdo["SaldoFinal"]<=0){
                $obCon->ActualizaRegistro("acuerdo_pago", "Estado", 2, "idAcuerdoPago", $idAcuerdo);
            }
            $obPrint->PrintAcuerdoPago($idAcuerdo, 1, 0);
            print("OK;Pago Ingresado");
        break; //fin caso 2
        
        case 3://Obtiene los valores de una cuota
            $idCuota=$obCon->normalizar($_REQUEST["idCuota"]);
            $DatosCuota=$obCon->DevuelveValores("acuerdo_pago_proyeccion_pagos", "ID", $idCuota);
            if($DatosCuota["ID"]==''){
                exit("E1;No existe la cuota Solicitada");
               
            }
            $Saldo=$DatosCuota["ValorCuota"]-$DatosCuota["ValorPagado"];
            $Mensaje="OK";
            $Mensaje.=";".$DatosCuota["NumeroCuota"];
            $Mensaje.=";".$DatosCuota["Fecha"];
            $Mensaje.=";".$DatosCuota["ValorCuota"];
            $Mensaje.=";".$DatosCuota["ValorPagado"];
            $Mensaje.=";".$Saldo;
            print($Mensaje);
        break;//Fin caso 3    
        
        case 4://Realiza el abono a una cuota individual
            $idCuota=$obCon->normalizar($_REQUEST["idCuota"]);
            $ValorAbono=$obCon->normalizar($_REQUEST["ValorAbono"]);
            $MetodoPago=$obCon->normalizar($_REQUEST["MetodoPago"]);
            $TotalAbono=$obCon->normalizar($_REQUEST["TotalAbono"]);
            $RecargosIntereses=$obCon->normalizar($_REQUEST["TxtRecargosIntereses"]);
            if(!is_numeric($ValorAbono) or $ValorAbono<0){
                exit("E1;El valor del abono debe ser un numero mayor a cero");
            }
            if(!is_numeric($TotalAbono) or $TotalAbono<=0){
                exit("E1;El Total del abono debe ser un numero mayor a Cero");
            }
            if(!is_numeric($RecargosIntereses) or $RecargosIntereses<0){
                exit("E1;El valor del recargo o interes debe ser un numero positivo");
            }
            if($RecargosIntereses==0 AND $ValorAbono==0){
                exit("E1;Los intereses y Abonos están en cero");
            }
            
            if($ValorAbono > $TotalAbono){
                exit("E1;El Valor del Abono no puede ser mayor al Total del Abono");
            }
            
            if($MetodoPago==''){
                exit("E1;No se recibió el metodo de pago");
            }
            $DatosCuota=$obCon->DevuelveValores("acuerdo_pago_proyeccion_pagos", "ID", $idCuota);
            $idAcuerdo=$DatosCuota["idAcuerdoPago"];
            
            
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
            
            
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            if($DatosAcuerdo["SaldoFinal"]<=0){
                
            }
            if($MetodoPago==1){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 10); //Efectivo
                $CuentaDestino=$Parametros["CuentaPUC"];
            
            }elseif($MetodoPago==2 or $MetodoPago==3){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 17); //Bancos
                $CuentaDestino=$Parametros["CuentaPUC"];
                
            }elseif($MetodoPago==10){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 36); //Saldo a Favor de un cliente
                $CuentaDestino=$Parametros["CuentaPUC"];
                
                $CuentaPUCSaldoFavor=$Parametros["CuentaPUC"];
                $sql="SELECT SUM(Debito-Credito) as Saldo  FROM librodiario WHERE Tercero_Identificacion='$Tercero' AND CuentaPUC='$CuentaPUCSaldoFavor'";
                $Totales=$obCon->FetchAssoc($obCon->Query($sql));
                $SaldoAFavor=$Totales["Saldo"]*(-1);
                if($SaldoAFavor<$ValorAbono){
                    exit("E1;El Saldo a Favor del cliente es menor al Valor del Abono");
                }
            }elseif($MetodoPago==11){
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 35); //Anticipos de un cliente
                $CuentaDestino=$Parametros["CuentaPUC"];    
                $CuentaPUCSaldoFavor=$Parametros["CuentaPUC"];
                $sql="SELECT SUM(Debito-Credito) as Saldo  FROM librodiario WHERE Tercero_Identificacion='$Tercero' AND CuentaPUC='$CuentaPUCSaldoFavor'";
                $Totales=$obCon->FetchAssoc($obCon->Query($sql));
                $TotalAnticipos=$Totales["Saldo"]*(-1);
                if($TotalAnticipos<$ValorAbono){
                    exit("E1;Los Anticipos del cliente Son menores al Valor del Abono");
                }
            }else{
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 30); //Otras formas de pago
                $CuentaDestino=$Parametros["CuentaPUC"];
            }
            $Tercero=$DatosAcuerdo["Tercero"];
            $Fecha=date("Y-m-d");
            if($ValorAbono>0){
                $obCon->AbonarCuotaAcuerdo($idCuota, $ValorAbono, $MetodoPago, $idUser);
                $sql="UPDATE acuerdo_pago SET TotalAbonos=(TotalAbonos+$ValorAbono),SaldoFinal=(SaldoInicial-TotalAbonos) WHERE idAcuerdoPago='$idAcuerdo'";
                $obCon->Query($sql);

                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Contrapartida del comprobante de ingreso aqui se aloja la cuenta de clientes
                $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $ValorAbono, "AbonoAcuerdoPago", "Ingreso por Acuerdo de Pago $idAcuerdo", "CERRADO");
                $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);
                $obPrint->PrintAcuerdoPago($idAcuerdo, 1, 0);
            }
            if($RecargosIntereses>0){
                $idInteres=$obCon->InteresesAcuerdoPagos($idAcuerdo, $RecargosIntereses, $MetodoPago, $idUser);
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 38); //ingresos no operacionales por recargos o intereses
                $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $RecargosIntereses, "RecargoInteresAcuerdoPago", "Ingreso por Interes o Recargo de Pago $idAcuerdo", "CERRADO");
                $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);

            }
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            if($DatosAcuerdo["SaldoFinal"]<=0){
                $obCon->ActualizaRegistro("acuerdo_pago", "Estado", 2, "idAcuerdoPago", $idAcuerdo);
            }
            print("OK;Abono Registrado");
        break;//FIn caso 4    
        
        case 5://Guarda una foto subida como soporte para el acuerdo de pago
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            
            if($idAcuerdo==""){
                exit("E1;No se recibió el id del acuerdo de pago");
            }
            if(!empty($_FILES['upFoto']['name'])){
                $obCon->GuardarFotoSubida($_FILES['upFoto']['name'],$_FILES['upFoto']['tmp_name'], $idAcuerdo);
                                
            }else{
                exit("E1;No se recibió la foto");
            }
            
            exit("OK;Foto subida");
            
        break;//Fin caso 5   
        
        case 6://Agregar los datos adicionales de un cliente
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $SobreNombre=$obCon->normalizar($_REQUEST["SobreNombre"]);
            $LugarTrabajo=$obCon->normalizar($_REQUEST["LugarTrabajo"]);
            $Cargo=$obCon->normalizar($_REQUEST["Cargo"]);
            $DireccionTrabajo=$obCon->normalizar($_REQUEST["DireccionTrabajo"]);
            $TelefonoTrabajo=$obCon->normalizar($_REQUEST["TelefonoTrabajo"]);
            $TxtFacebook=$obCon->normalizar($_REQUEST["TxtFacebook"]);
            $TxtInstagram=$obCon->normalizar($_REQUEST["TxtInstagram"]);
            
            if($idCliente==''){
                exit("E1;No se recibió el id del cliente");
            }
            if($SobreNombre==''){
                exit("E1;Debe digitar el Sobre Nombre del Cliente;SobreNombre");
            }
            if($LugarTrabajo==''){
                exit("E1;Debe digitar el Lugar Trabajo del Cliente;LugarTrabajo");
            }
            if($Cargo==''){
                exit("E1;Debe digitar el Cargo del Cliente;Cargo");
            }
            if($DireccionTrabajo==''){
                exit("E1;Debe digitar la Direccion de Trabajo del Cliente;DireccionTrabajo");
            }
            if($TelefonoTrabajo==''){
                exit("E1;Debe digitar el Telefono de Trabajo del Cliente;TelefonoTrabajo");
            }
            if($TxtFacebook==''){
                exit("E1;Debe digitar el Facebook del Cliente;TxtFacebook");
            }
            if($TxtInstagram==''){
                exit("E1;Debe digitar el Instagram del Cliente;TxtInstagram");
            }
            
            $obCon->AgregaDatosAdicionalesCliente($idCliente, $SobreNombre, $LugarTrabajo, $Cargo, $DireccionTrabajo, $TelefonoTrabajo, $TxtFacebook, $TxtInstagram);
            print("OK;Datos adicionales del cliente agregados");
            
        break;//Fin caso 6  
        
        case 7://Agregar un recomendado de un cliente
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $NombreRecomendado=$obCon->normalizar($_REQUEST["NombreRecomendado"]);
            $DireccionRecomendado=$obCon->normalizar($_REQUEST["DireccionRecomendado"]);
            $TelefonoRecomendado=$obCon->normalizar($_REQUEST["TelefonoRecomendado"]);
            $DireccionTrabajoRecomendado=$obCon->normalizar($_REQUEST["DireccionTrabajoRecomendado"]);
            $TelefonoTrabajoRecomendado=$obCon->normalizar($_REQUEST["TelefonoTrabajoRecomendado"]);
            
            if($idCliente==''){
                exit("E1;No se recibió el id del cliente");
            }
            if($NombreRecomendado==''){
                exit("E1;Debe digitar el Nombre del Recomendado;NombreRecomendado");
            }
            if($DireccionRecomendado==''){
                exit("E1;Debe digitar la Direccion de Recomendado;DireccionRecomendado");
            }
            if($TelefonoRecomendado==''){
                exit("E1;Debe digitar el Telefono del Recomendado;TelefonoRecomendado");
            }
            if($DireccionTrabajoRecomendado==''){
                exit("E1;Debe digitar la Direccion del Trabajo del Recomendado;DireccionTrabajoRecomendado");
            }
            if($TelefonoTrabajoRecomendado==''){
                exit("E1;Debe digitar el Telefono del Trabajo del Recomendado;TelefonoTrabajoRecomendado");
            }
                        
            $obCon->AgregaRecomendadoCliente($idCliente, $NombreRecomendado, $DireccionRecomendado, $TelefonoRecomendado, $DireccionTrabajoRecomendado, $TelefonoTrabajoRecomendado);
            print("OK;Recomendado agregado");
            
        break;//Fin caso 7
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
