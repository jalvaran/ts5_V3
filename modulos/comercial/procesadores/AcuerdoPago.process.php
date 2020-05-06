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
            $idItemDevolucionAcuerdo=$obCon->normalizar($_REQUEST["idItemDevolucionAcuerdo"]);
            $Cantidad_Devolucion_Acuerdo_Pago=$obCon->normalizar($_REQUEST["Cantidad_Devolucion_Acuerdo_Pago"]);
            $ObservacionesDevolucion=$obCon->normalizar($_REQUEST["TxtObservacionesDevolucion"]);
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
            $Tercero=$DatosAcuerdo["Tercero"];
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

                $obCon->AbonarAcuerdoPago($idAcuerdo,$MetodoPago,$ValorAbono,$idUser,$idComprobante);

                $sql="UPDATE acuerdo_pago SET TotalAbonos=(TotalAbonos+$ValorAbono),SaldoFinal=(SaldoInicial-TotalAbonos) WHERE idAcuerdoPago='$idAcuerdo'";
                $obCon->Query($sql);
            }
            
            if($RecargosIntereses>0){
                
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 38); //ingresos no operacionales por recargos o intereses
                $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $RecargosIntereses, "RecargoInteresAcuerdoPago", "Ingreso por Interes o Recargo de Pago $idAcuerdo", "CERRADO");
                $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);
                $idInteres=$obCon->InteresesAcuerdoPagos($idAcuerdo, $RecargosIntereses, $MetodoPago, $idUser,$idComprobante);
            }
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            if($DatosAcuerdo["SaldoFinal"]<=0){
                $obCon->ActualizaRegistro("acuerdo_pago", "Estado", 2, "idAcuerdoPago", $idAcuerdo);
            }
            
            if($idItemDevolucionAcuerdo<>''){
                $obCon->RegistreDevolucionProductoAcuerdo($idAcuerdo, $idItemDevolucionAcuerdo, $Cantidad_Devolucion_Acuerdo_Pago, $ValorAbono, $ObservacionesDevolucion, $idUser);
            }
            
            //$obPrint->PrintAcuerdoPago($idAcuerdo, 1, 0);
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
            $idItemDevolucionAcuerdo=$obCon->normalizar($_REQUEST["idItemDevolucionAcuerdo"]);
            $Cantidad_Devolucion_Acuerdo_Pago=$obCon->normalizar($_REQUEST["Cantidad_Devolucion_Acuerdo_Pago"]);
            $ObservacionesDevolucion=$obCon->normalizar($_REQUEST["TxtObservacionesDevolucion"]);
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
                

                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Contrapartida del comprobante de ingreso aqui se aloja la cuenta de clientes
                $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $ValorAbono, "AbonoAcuerdoPago", "Ingreso por Acuerdo de Pago $idAcuerdo", "CERRADO");
                $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);
                
                $obCon->AbonarCuotaAcuerdo($idCuota, $ValorAbono, $MetodoPago, $idUser,$idComprobante);
                $sql="UPDATE acuerdo_pago SET TotalAbonos=(TotalAbonos+$ValorAbono),SaldoFinal=(SaldoInicial-TotalAbonos) WHERE idAcuerdoPago='$idAcuerdo'";
                $obCon->Query($sql);
            }
            if($RecargosIntereses>0){
                
                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 38); //ingresos no operacionales por recargos o intereses
                $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $RecargosIntereses, "RecargoInteresAcuerdoPago", "Ingreso por Interes o Recargo de Pago $idAcuerdo", "CERRADO");
                $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], $idEmpresa,$idSucursal, $idCentroCostos);
                $idInteres=$obCon->InteresesAcuerdoPagos($idAcuerdo, $RecargosIntereses, $MetodoPago, $idUser,$idComprobante);
            }
            $DatosAcuerdo=$obCon->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            if($DatosAcuerdo["SaldoFinal"]<=0){
                $obCon->ActualizaRegistro("acuerdo_pago", "Estado", 2, "idAcuerdoPago", $idAcuerdo);
            }
            if($idItemDevolucionAcuerdo<>''){
                $obCon->RegistreDevolucionProductoAcuerdo($idAcuerdo, $idItemDevolucionAcuerdo, $Cantidad_Devolucion_Acuerdo_Pago, $ValorAbono, $ObservacionesDevolucion, $idUser);
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
        
        case 8://Anular un acuerdo de pago
            
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]);
            $obCon->AnularAcuerdoPago($idAcuerdo, $Observaciones, $idUser);
            print("OK;Documento Anulado");
        break;//Fin caso 8    
        
        case 9://Anular un abono
            
            $idAbono=$obCon->normalizar($_REQUEST["idAbono"]);
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]);
            $obCon->AnularAbonoAcuerdo($idAbono, $Observaciones, $idUser);
            print("OK;Abono Anulado");
            
        break;//Fin caso 9   
    
        case 10://Reportar un acuerdo de pago
            
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]);
            $obCon->ReportarAcuerdoPago($idAcuerdo, $Observaciones, $idUser);
            print("OK;Acuerdo Reportado");
        break;//Fin caso 10
    
        case 25:// agrega la cuota inicial a un acuerdo de pago temporal
            
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
            $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            $TipoCuota=0;
            $NumeroCuota=0;
            $ValorPago=$obCon->normalizar($_REQUEST["ValorPago"]);
            $MetodoPago=$obCon->normalizar($_REQUEST["MetodoPago"]);            
            
            if($idAcuerdoPago==''){
                exit("E1;No se recibió el id del acuerdo de pago");
            }
            
            if(!is_numeric($ValorPago) or $ValorPago<0){
                exit("E1;La cuota inicial del acuerdo debe ser un numero mayor a cero;CuotaInicialAcuerdo");
            }
            if($MetodoPago==''){
                exit("E1;Debe seleccionar un metodo de pago para la cuota inicial;metodoPagoCuotaInicial");
            }
            
            $obCon->PagoAcuerdoPagosTemporal($NumeroCuota, $TipoCuota, $idAcuerdoPago, $ValorPago, $MetodoPago, $idUser);
            
            print("OK;Pago de cuota registrado");
            
        break; //Fin caso 25    
        
        case 26://Eliminar un item de alguna de las tablas del acuerdo de pago
            
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            if($Tabla==1){
                $Tabla="acuerdo_pago_cuotas_pagadas_temp";
            }
            if($Tabla==2){
                $Tabla="acuerdo_pago_proyeccion_pagos_temp";
            }
            $obCon->BorraReg($Tabla, "ID", $idItem);
            print("OK;Registro eliminado");
        break;//Fin caso 26    
        
        case 27:// agrega la cuotas programables a un acuerdo de pago temporal
            
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);  
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
            $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            $TipoCuota=$obCon->normalizar($_REQUEST["TipoCuota"]);            
            $ValorCuota=$obCon->normalizar($_REQUEST["CuotaProgramadaAcuerdo"]);
            $FechaCuotaProgramable=$obCon->normalizar($_REQUEST["TxtFechaCuotaProgramada"]);            
            
            if($idAcuerdoPago==''){
                exit("E1;No se recibió el id del acuerdo de pago");
            }
            if($TipoCuota==''){
                exit("E1;No se recibió el tipo de cuota");
            }
            if(!is_numeric($ValorCuota) or $ValorCuota<0){
                exit("E1;El valor de la cuota debe ser un numero mayor a cero;CuotaProgramadaAcuerdo");
            }
            if($FechaCuotaProgramable==''){
                exit("E1;Debe seleccionar una fecha de pago para la cuota programada;TxtFechaCuotaProgramada");
            }
            $obCon->CuotaAcuerdoPagosTemporal($FechaCuotaProgramable, 0, $TipoCuota, $idAcuerdoPago, $ValorCuota, $idUser);
            
            print("OK;Cuota registrado");
            
        break; //Fin caso 27
        
        case 28://calcule el valor de las cuotas según el numero de cuotas
            $obAcuerdo = new AcuerdoPago($idUser);
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $NumeroCuotas=$obCon->normalizar($_REQUEST["NumeroCuotas"]);
                       
            $sql="SELECT SUM(TotalVenta) AS Total FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalPreventa=$Totales["Total"];
            $ValorAProyectar=$obAcuerdo->ValorAProyectarTemporalAcuerdo($idAcuerdo, $TotalPreventa, $idCliente);
            $ValorCuotaCalculada=round($ValorAProyectar/$NumeroCuotas);
            print("OK;Cuota Calculada;$ValorCuotaCalculada");
        break;//Fin caso 28
    
        case 29://Editar un item de alguna de las tablas del acuerdo de pago
            
            $Valor=$obCon->normalizar($_REQUEST["ValorCuota"]);          
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);            
            $Tabla="acuerdo_pago_proyeccion_pagos_temp";
            
            $obCon->ActualizaRegistro($Tabla, "ValorCuota", $Valor, "ID", $idItem, 1);
            print("OK;Cuota Actualizada");
        break;//Fin caso 29
    
        case 30://Guardo un acuerdo de pago desde admin
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
            $_REQUEST["idCliente"]=$idCliente;
            $obCon->ValidarDatosCreacionAcuerdoPagoPOS($_REQUEST);
            
            $idAcuerdoPago=$obCon->normalizar($_REQUEST["idAcuerdoPago"]);
            $FechaInicialParaPagos=$obCon->normalizar($_REQUEST["TxtFechaInicialPagos"]);
            $ValorCuotaGeneral=$obCon->normalizar($_REQUEST["ValorCuotaAcuerdo"]);
            $CicloPagos=$obCon->normalizar($_REQUEST["cicloPagos"]);                
            $Observaciones=$obCon->normalizar($_REQUEST["TxtObservacionesAcuerdoPago"]);
            $SaldoAnterior=$obCon->normalizar($_REQUEST["SaldoActualAcuerdoPago"]);
            $SaldoFinal=$obCon->normalizar($_REQUEST["NuevoSaldoAcuerdoPago"]);
            $sql="SELECT SUM(ValorPago) as TotalCuotaInicial FROM acuerdo_pago_cuotas_pagadas_temp WHERE idAcuerdoPago='$idAcuerdoPago' AND TipoCuota=0";
            $TotalesCuotaInicial=$obCon->FetchAssoc($obCon->Query($sql));
            $CuotaInicial=$TotalesCuotaInicial["TotalCuotaInicial"];
            $SaldoInicial=$SaldoFinal;
            $SaldoFinal=$SaldoInicial-$CuotaInicial;
            $obCon->CrearAcuerdoPagoDesdePOS($idAcuerdoPago,"", $FechaInicialParaPagos, $DatosCliente["Num_Identificacion"],$ValorCuotaGeneral, $CicloPagos, $Observaciones,$SaldoAnterior,$CuotaInicial, $SaldoInicial, $SaldoFinal, 1, $idUser);
                
            $DatosCuenta=$obCon->DevuelveValores("parametros_contables", "ID", 21); //Cuenta caja
            $CuentaDestino=$DatosCuenta["CuentaPUC"];
            $NombreCuentaDestino=$DatosCuenta["NombreCuenta"];
            
            $CentroCosto=1;
            $Tercero=$DatosCliente["Num_Identificacion"];

            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 6);
            $Abono=$CuotaInicial;
            $Fecha=date("Y-m-d");
            if($Abono>0){
                $idComprobante=$obContabilidad->CrearComprobanteIngreso($Fecha, "", $Tercero, $Abono, "AbonoAcuerdoPago", "Ingreso por Acuerdo de Pago $idAcuerdoPago", "CERRADO");
                $obContabilidad->ContabilizarComprobanteIngreso($idComprobante, $Tercero, $CuentaDestino, $Parametros["CuentaPUC"], 1, 1, 1);
                $obCon->RelacionAbonosComprobantesIngreso($idAcuerdoPago, $idComprobante);
            }
            $LinkAcuerdo="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=37&idAcuerdo=$idAcuerdoPago&EstadoGeneral=0";
            $Mensaje2="<br><strong>Acuerdo de Pago Creado Correctamente </strong><a href='$LinkAcuerdo'  target='blank'> Imprimir</a>";
             
            $LinkProcessMail="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=39&idAcuerdoPago=$idAcuerdoPago";
            $MensajeMail="<br><a href='$LinkProcessMail'  target='blank'><strong>Click para enviar Acuerdo por Email</strong></a>";
            print("OK;$Mensaje2.$MensajeMail");
                
        break;//Fin caso 30    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
