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
        break;//Fin caso 3 
    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
