<?php
session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/facturacion_electronica.class.php");
//include_once("restclient.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Factura_Electronica($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear facturas electronicas
            if(!isset($_REQUEST["idFactura"])){
                $sql="SELECT t1.idFacturas,t1.NumeroFactura FROM facturas t1 
                    WHERE TipoFactura='FE' AND NOT EXISTS (SELECT 1 FROM facturas_electronicas_log t2 WHERE t1.idFacturas=t2.idFactura AND t2.Estado<20) LIMIT 1";

                $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
                $idFactura=$DatosConsulta["idFacturas"];
                $NumeroFactura=$DatosConsulta["NumeroFactura"];
            }else{
                $idFactura=$obCon->normalizar($_REQUEST["idFactura"]);
                $sql="SELECT ID FROM facturas_electronicas_log WHERE idFactura='$idFactura' AND Estado=1";                
                $DatosLog=$obCon->FetchAssoc($obCon->Query($sql));
                if($DatosLog["ID"]>0){
                    exit("E1;La Factura $idFactura ya fue reportada");
                }
                $sql="SELECT NumeroFactura FROM facturas WHERE idFacturas='$idFactura'";
                $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
                $NumeroFactura=$DatosConsulta["NumeroFactura"];
            }
            
            
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 104);            
            $url=$DatosServidor["IP"];
            if($idFactura<>''){
                $sql="SELECT COUNT(ID) AS TotalItems FROM facturas_items WHERE idFactura='$idFactura'";
                $DatosTotal=$obCon->FetchAssoc($obCon->Query($sql));
                $response="";
                $Estado=0;
                if($DatosTotal["TotalItems"]>0){ //Verifico que la factura tenga items
                    $body=$obCon->JSONFactura($idFactura);
                    $response = $obCon->callAPI('POST', $url, $body);  
                }else{
                    $Estado=11;
                }
                $obCon->FacturaElectronica_Registre_Respuesta_Server($idFactura,$response,$Estado);
                exit("OK;Factura $NumeroFactura Reportada");
            }else{
                exit("RE;No hay Facturas a Generar");
            }    
        break; //Fin caso 1
        
        case 2: // Verificar las facturas Electronicas, si se generaron bien o no
            
            $sql="SELECT * FROM facturas_electronicas_log WHERE Estado=0 LIMIT 1";
            
            $DatosLogFactura=$obCon->FetchAssoc($obCon->Query($sql));
            $idFactura=$DatosLogFactura["idFactura"];
            $idLog=$DatosLogFactura["ID"];
            if($idFactura<>''){
                if($DatosLogFactura["RespuestaCompletaServidor"]==''){
                    $obCon->ActualizaRegistro("facturas_electronicas_log", "Estado", 20, "ID", $idLog);
                    
                }else{
                    $JSONFactura= json_decode($DatosLogFactura["RespuestaCompletaServidor"]);
                    if((property_exists($JSONFactura, "responseDian"))){
                        $RespuestaReporte=$JSONFactura->responseDian->Envelope->Body->SendTestSetAsyncResponse->SendTestSetAsyncResult->ErrorMessageList->_attributes->nil;
                    }else{
                        
                        $obCon->ActualizaRegistro("facturas_electronicas_log", "Estado", 13, "ID", $idLog);
                        exit("OK;Factura $idFactura Verificada");
                    }
                    
                    if($RespuestaReporte=='true'){
                        $CUFE=$JSONFactura->uuid;
                        $obCon->ActualizaRegistro("facturas_electronicas_log", "Estado", 1, "ID", $idLog);
                        $obCon->ActualizaRegistro("facturas_electronicas_log", "UUID", $CUFE, "ID", $idLog);
                    }else{
                        $obCon->ActualizaRegistro("facturas_electronicas_log", "Estado", 10, "ID", $idLog);
                    }
                }
                exit("OK;Factura $idFactura Verificada");
            }else{
                exit("RE;No hay Facturas por validar");
            }    
        break;
        
        case 3://Crear los PDF
            $sql="SELECT * FROM facturas_electronicas_log WHERE Estado=1 AND PDFCreado=0 LIMIT 1";
            
            $DatosLogFactura=$obCon->FetchAssoc($obCon->Query($sql));
            $idFactura=$DatosLogFactura["idFactura"];
            $idLog=$DatosLogFactura["ID"];
            if($idFactura<>''){
                $JSONFactura= json_decode($DatosLogFactura["RespuestaCompletaServidor"]);
                $NumeroFactura=$JSONFactura->number;
                $Ruta=$obCon->CrearPDFDesdeBase64($JSONFactura->pdfBase64Bytes,$NumeroFactura);
                $obCon->ActualizaRegistro("facturas_electronicas_log", "PDFCreado", 1, "ID", $idLog);
                $obCon->ActualizaRegistro("facturas_electronicas_log", "RutaPDF", $Ruta, "ID", $idLog);
                exit("OK;PDF de la Factura Electronica $idFactura Creado Satisfactoriamente");
            }else{
                exit("RE;No hay Facturas para crear PDF");
            }
        break;//Fin caso 3 
    
        case 4://Crear los zip con los XML adentro
            $sql="SELECT * FROM facturas_electronicas_log WHERE Estado=1 AND ZIPCreado=0 LIMIT 1";
            
            $DatosLogFactura=$obCon->FetchAssoc($obCon->Query($sql));
            $idFactura=$DatosLogFactura["idFactura"];
            $idLog=$DatosLogFactura["ID"];
            if($idFactura<>''){
                $JSONFactura= json_decode($DatosLogFactura["RespuestaCompletaServidor"]);
                $NumeroFactura=$JSONFactura->number;
                $Ruta=$obCon->CrearZIPDesdeBase64($JSONFactura->zipBase64Bytes,$NumeroFactura);
                $obCon->ActualizaRegistro("facturas_electronicas_log", "ZIPCreado", 1, "ID", $idLog);
                $obCon->ActualizaRegistro("facturas_electronicas_log", "RutaXML", $Ruta, "ID", $idLog);
                exit("OK;ZIP con XML de la Factura Electronica $idFactura Creado Satisfactoriamente");
            }else{
                exit("RE;No hay Facturas para crear XML");
            }
        break;//Fin caso 4
        
        case 5://Editar Facturas que hayan sido reparadas
            $sql="SELECT * FROM facturas_electronicas_log WHERE Estado>=10 OR Estado<20";
            $Consulta=$obCon->Query($sql);
            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                $idFactura=$DatosConsulta["idFactura"];
                
                $sql="SELECT ID FROM facturas_electronicas_log WHERE idFactura='$idFactura' AND Estado='1'";
                $DatosValidacion=$obCon->FetchAssoc($obCon->Query($sql));
                if($DatosValidacion["ID"]>0){
                    $sql="UPDATE facturas_electronicas_log SET Estado=30 WHERE idFactura='$idFactura' AND Estado>=10 AND Estado<20";
                    $obCon->Query($sql);
                }
            }
            exit("OK;Actualizacion de Documentos corregidos Realizada");
        break;//Fin caso 5
        
        case 6://Enviar una factura electronica por correo
            include_once("../clases/mail.class.php");            
            $obMail=new TS_Mail($idUser);
            
            $idFactura=$obCon->normalizar($_REQUEST["idFactura"]);
            $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $idFactura);
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
            $DatosEmpresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $DatosFactura["EmpresaPro_idEmpresaPro"]);
            if(!filter_var($DatosCliente["Email"], FILTER_VALIDATE_EMAIL)){
                exit("E1;El tercero no cuenta con un Mail Válido: ".$DatosCliente["Email"]);
            }
            $para=$DatosCliente["Email"];
            $de="technosolucionesfe@gmail.com";
            $nombreRemitente=$DatosEmpresa["RazonSocial"];
            $Configuracion=$obCon->DevuelveValores("configuracion_general", "ID", 22); //Almecena el asunto del correo
            $asunto=$Configuracion["Valor"];            
            $Configuracion=$obCon->DevuelveValores("configuracion_general", "ID", 23); //Almecena el cuerpo del mensaje del correo
            $mensajeHTML=$Configuracion["Valor"];
            $mensajeHTML= str_replace("@RazonSocial", $DatosCliente["RazonSocial"], $mensajeHTML);
            $mensajeHTML= str_replace("@NumeroFactura", $DatosFactura["NumeroFactura"], $mensajeHTML);
            $sql="SELECT RutaPDF,RutaXML FROM facturas_electronicas_log WHERE idFactura='$idFactura' AND Estado='1'";
            $RutasFE=$obCon->FetchArray($obCon->Query($sql));            
            $Adjunto=$RutasFE;
            //$status=$obMail->EnviarMailXPHPNativo($para, $de, $nombreRemitente, $asunto, $mensajeHTML,$Adjunto);
            $status=$obMail->EnviarMailXPHPMailer($para, $de, $nombreRemitente, $asunto, $mensajeHTML,$Adjunto);
            if($status=='OK'){
                exit("OK;Envío Realizado");
            }else{
                exit("E1;No se pudo realizar el envío");
            }
            
        break;//Fin caso 6
        
        case 7://Enviar las facturas electronicas por correo
            include_once("../clases/mail.class.php");            
            $obMail=new TS_Mail($idUser);
            
            $sql="SELECT * FROM facturas_electronicas_log WHERE Estado=1 AND EnviadoPorMail=0 LIMIT 1";
            
            $DatosLogFactura=$obCon->FetchAssoc($obCon->Query($sql));
            $idFactura=$DatosLogFactura["idFactura"];
            $idLog=$DatosLogFactura["ID"];
            if($idFactura<>''){
                $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $idFactura);
                $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
                $DatosEmpresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $DatosFactura["EmpresaPro_idEmpresaPro"]);
                if(!filter_var($DatosCliente["Email"], FILTER_VALIDATE_EMAIL)){
                    exit("E1;El tercero no cuenta con un Mail Válido: ".$DatosCliente["Email"]);
                }
                $para=$DatosCliente["Email"];
                $Configuracion=$obCon->DevuelveValores("configuracion_general", "ID", 24); //Almecena el correo que envia
                $de=$Configuracion["Valor"];
                $nombreRemitente=$DatosEmpresa["RazonSocial"];
                $Configuracion=$obCon->DevuelveValores("configuracion_general", "ID", 22); //Almecena el asunto del correo
                $asunto=$Configuracion["Valor"];            
                $Configuracion=$obCon->DevuelveValores("configuracion_general", "ID", 23); //Almecena el cuerpo del mensaje del correo
                $mensajeHTML=$Configuracion["Valor"];
                $mensajeHTML= str_replace("@RazonSocial", $DatosCliente["RazonSocial"], $mensajeHTML);
                $mensajeHTML= str_replace("@NumeroFactura", $DatosFactura["NumeroFactura"], $mensajeHTML);
                $sql="SELECT RutaPDF,RutaXML FROM facturas_electronicas_log WHERE idFactura='$idFactura' AND Estado='1'";
                $RutasFE=$obCon->FetchArray($obCon->Query($sql));            
                $Adjunto=$RutasFE;
                $Configuracion=$obCon->DevuelveValores("configuracion_general", "ID", 25); //Determina el metodo a usar para enviar el correo al cliente
                if($Configuracion["Valor"]==1){
                    $status=$obMail->EnviarMailXPHPNativo($para, $de, $nombreRemitente, $asunto, $mensajeHTML,$Adjunto);
                }
                if($Configuracion["Valor"]==2){
                    $status=$obMail->EnviarMailXPHPMailer($para, $de, $nombreRemitente, $asunto, $mensajeHTML,$Adjunto);
                }
                if($status=='OK'){
                    $obCon->ActualizaRegistro("facturas_electronicas_log", "EnviadoPorMail", 1, "ID", $idLog);
                    exit("OK;Envío de la factura $idFactura Realizado");
                }else{
                    exit("E1;No se pudo realizar el envío de la factura $idFactura");
                }
            }else{
                exit("RE;No hay Facturas para enviar por Mail");
            }    
        break;//Fin caso 7
    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
