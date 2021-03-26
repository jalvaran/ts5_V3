<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/notas_credito.class.php");
include_once("../../../general/clases/facturacion_electronica.class.php");
include_once("../clases/pdf_documentos_electronicos.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new NotasCredito($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una nota credito
            $idFactura=$obCon->normalizar($_REQUEST["idFactura"]); 
            $TxtFecha=$obCon->normalizar($_REQUEST["TxtFecha"]);
            $TxtObservaciones=$obCon->normalizar($_REQUEST["TxtObservaciones"]);
            
            if($idFactura==''){
                exit("E1;Debe seleccionar una factura;select2-cmbIdFactura-container");
            }
            
            if($TxtFecha==''){
                exit("E1;Debe seleccionar una prioridad;TxtFecha");
            }
            
            if($TxtObservaciones==''){
                exit("E1;el campo observaciones no puede estar vacío;TxtObservaciones");
            }
            
            $idNota=$obCon->CrearNotaCredito($idFactura,$TxtFecha,$TxtObservaciones,$idUser);
            
            print("OK;Nota $idNota Creada;$idNota");          
            
        break; //fin caso 1
        
        case 2://Agregar un item a una nota credito
            $idFacturaElectronica=$obCon->normalizar($_REQUEST["idFacturaElectronica"]);
            $idItemFactura=$obCon->normalizar($_REQUEST["idItemFactura"]);
            $Cantidad=$obCon->normalizar($_REQUEST["TxtCantidad"]);
            $DatosItem=$obCon->DevuelveValores("facturas_items", "ID", $idItemFactura);
            $DatosFacturaElectronica=$obCon->DevuelveValores("vista_listado_facturas_electronicas", "ID", $idFacturaElectronica);
            if($idFacturaElectronica==''){
                exit("E1;No se recibió el id de la factura electronica");
            }
            if($idItemFactura==''){
                exit("E1;No se recibió el item de la factura a agregar en la nota credito");
            }
            if(!is_numeric($Cantidad) or $Cantidad<=0){
                exit("E1;La cantidad debe ser un valor numerico y positivo;TxtCantidad_$idItemFactura");
            }
            if($DatosItem["idFactura"]<>$DatosFacturaElectronica["idFactura"]){
                exit("E1;El item seleccionado no corresponde a la factura que se seleccionó en la nota credito");
            }
            $sql="SELECT SUM(Cantidad) as CantidadActual FROM notas_credito_items WHERE idItemFactura='$idItemFactura'";
            $CantidadActual=$obCon->FetchAssoc($obCon->Query($sql));
            
            $CantidadTotal=$Cantidad+$CantidadActual["CantidadActual"];
            if($CantidadTotal>($DatosItem["Cantidad"]*$DatosItem["Dias"])){
                exit("E1;La cantidad de este producto no puede superar la cantidad que hay en la factura;TxtCantidad_$idItemFactura");
            }
            $Respuesta=$obCon->AgregarItemANotaCredito($idFacturaElectronica,$idItemFactura,$Cantidad,$idUser);
            
            if($Respuesta=="OK"){
                exit("OK;Item agregado;$idFacturaElectronica");
            }else{
                exit("E1;".$Respuesta);
            }
            
        break;//Fin caso 2   
        
        case 3://eliminar un item a una nota credito
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $idFacturaElectronica=$obCon->normalizar($_REQUEST["idFacturaElectronica"]);
            if($idItem==''){
                exit("E1;No se recibió el item a eliminar");
            }
            
            if($Tabla==''){
                exit("E1;No se recibió la tabla para eliminar el item");
            }
            if($Tabla==1){
                $Tabla="notas_credito_items";
            }else{
                exit("E1;Tabla invalida");
            }
            $obCon->BorraReg($Tabla, "ID", $idItem);
            exit("OK;Item Eliminado;$idFacturaElectronica");
        break;//Fin caso 3
        
        case 4://Guardar una nota credito
            $idFacturaElectronica=$obCon->normalizar($_REQUEST["idFacturaElectronica"]); 
            $TxtFecha=$obCon->normalizar($_REQUEST["TxtFecha"]);
            $TxtObservaciones=$obCon->normalizar($_REQUEST["TxtObservaciones"]);
            
            if($idFacturaElectronica==''){
                exit("E1;No se recibió el id de la Factura electronica");
            }
            
            if($TxtFecha==''){
                exit("E1;Debe seleccionar una Fecha;TxtFecha");
            }
            
            if($TxtObservaciones==''){
                exit("E1;el campo observaciones no puede estar vacío;TxtObservaciones");
            }
            $sql="SELECT idFactura FROM vista_listado_facturas_electronicas WHERE ID='$idFacturaElectronica'";
            $DatosFacturaElectronica=$obCon->FetchAssoc($obCon->Query($sql));
            $idNota=$obCon->CrearNotaCredito($DatosFacturaElectronica["idFactura"],$idFacturaElectronica,$TxtFecha,$TxtObservaciones,$idUser);
            $sql="UPDATE notas_credito_items SET idNotaCredito='$idNota' WHERE idFacturaElectronica='$idFacturaElectronica' AND idNotaCredito=''";
            $obCon->Query($sql);
            $obCon->ContabilizarNotaCredito($idNota);    
            
            exit("OK;Nota Credito No. $idNota creada");
        break;//Fin caso 4   
        
        case 5:// envie un documento electronico por mail
            
            if(isset($_REQUEST["idDocumento"])){
                $documento_id=$obCon->normalizar($_REQUEST["idDocumento"]);
            }else{
                $documento_id='';
            }
            $Tabla="facturas_electronicas_log";
            if(isset($_REQUEST["TipoDocumento"])){
                if($_REQUEST["TipoDocumento"]==2){
                    $Tabla="notas_credito";
                }
                
            }
            
            $obPDF = new PDF_Documentos_Electronicos($db);
            $obFE = new Factura_Electronica($idUser);
            
            
            if($documento_id==''){
                $condicion="WHERE UUID<>'' and EnviadoPorMail=0 LIMIT 1";
            }else{
                $condicion="WHERE UUID<>'' and ID='$documento_id' LIMIT 1";
            }
            $sql="SELECT ID,idFactura,UUID,RespuestaCompletaServidor FROM $Tabla  $condicion";
            $DatosLogFactura=$obCon->FetchAssoc($obCon->Query($sql));
            $uuid=$DatosLogFactura["UUID"];
            if($uuid==''){
                exit("RE;No se encontraron Facturas a Enviar");
            }
            $datos_factura=$obCon->DevuelveValores("facturas", "idFacturas", $DatosLogFactura["idFactura"]);
            $datos_cliente=$obCon->DevuelveValores("clientes", "idClientes", $datos_factura["Clientes_idClientes"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
            $pdfBase64Bytes='';
            $datos_configuracion_general=$obCon->DevuelveValores("configuracion_general", "ID", 16); //Ruta donde se almacenan las facturas electronicas
            if($Tabla=="facturas_electronicas_log"){
                $ruta=$obPDF->pdf_factura_electronica($DatosLogFactura["idFactura"], 1,"../".$datos_configuracion_general["Valor"]);
                $im = file_get_contents($ruta);
                $pdfBase64Bytes = base64_encode($im);
            }
                     
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 112); //Ruta para enviar un mail     
            $url=$DatosServidor["IP"];   

            $url=$url.$uuid;
            
            $body='{
                    "to": [
                      {
                        "email": "'.$datos_cliente["Email"].'"
                      }
                    ],
                    "cc": [
                      {
                        "email": "'.$datos_empresa["Email"].'"
                      }
                    ]'; 
            if($pdfBase64Bytes<>''){
                $body.=',
                    
                    "pdf_base64_bytes": "'.$pdfBase64Bytes.'"';
            }
            $body.='}';
            
            
                 
            $response = $obFE->callAPI('POST', $url, $body);
            $array_respuesta= json_decode($response,1);
            
            if(isset($array_respuesta["is_valid"])){
                print("OK;Factura $DatosLogFactura[idFactura] Enviada");
                $obCon->ActualizaRegistro($Tabla, "EnviadoPorMail", 1, "idFactura", $DatosLogFactura["idFactura"]);
            }else{
                print("E1;La Factura $DatosLogFactura[idFactura] No pudo ser enviada Enviada");
            }
            
        break;//Fin caso 5
        
        case 6:// crea el pdf de la factura electronica
            $documento_id=$obCon->normalizar($_REQUEST["documento_id"]);
            $obPDF = new PDF_Documentos_Electronicos($db);
            
            $datos_configuracion_general=$obCon->DevuelveValores("configuracion_general", "ID", 16); //Ruta donde se almacenan las facturas electronicas
            
            $ruta=$obPDF->pdf_factura_electronica($documento_id, 1,"../".$datos_configuracion_general["Valor"]);
            print("<a href='$ruta' target='_blank'>Ver Factura</a>");
        break;//Fin caso 6
    
        case 7://Reporte las notas credito
            $obFE=new Factura_Electronica($idUser);
            $nota_id='';
            if(isset($_REQUEST["idNota"])){
                $nota_id=$obCon->normalizar($_REQUEST["idNota"]);
            }
            if($nota_id==''){
                $sql="SELECT ID FROM notas_credito  
                    WHERE Estado=0 LIMIT 1";
            }else{
                $sql="SELECT ID FROM notas_credito  
                    WHERE ID='$nota_id' LIMIT 1";
            }
            

            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $idNota=$DatosConsulta["ID"];
            
            if($idNota==''){
                exit("RE;No hay Notas a Generar");
            }
            
            $sql="SELECT COUNT(ID) AS TotalItems FROM notas_credito_items WHERE idNotaCredito='$idNota'";
            $DatosTotal=$obCon->FetchAssoc($obCon->Query($sql));
            $response="";
            $Estado=0;

            if($DatosTotal["TotalItems"]>0){ //Verifico que la nota tenga items
                $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 105); //Ruta para enviar las notas credito            
                $url=$DatosServidor["IP"];
                $body=$obFE->JSONNotaCredito($idNota);
                $response = $obFE->callAPI('POST', $url, $body);  
                $response=str_replace(PHP_EOL, '', $response);
                $response=str_replace("\n", '',$response);
                $response=str_replace("\r", '',$response);
                $response=str_replace("'", '',$response);
                
                $sql="UPDATE notas_credito SET RespuestaCompletaServidor='$response' WHERE ID='$idNota'";
                $obCon->Query($sql);
                $JsonRespuesta= json_decode($response);
                if((property_exists($JsonRespuesta, "responseDian"))){
                    $RespuestaReporte=$JsonRespuesta->responseDian->Envelope->Body->SendBillSyncResponse->SendBillSyncResult->IsValid;
                    if($RespuestaReporte==true){
                            
                        $obCon->ActualizaRegistro("notas_credito", "Estado", 1, "ID", $idNota);
                        
                    }else{
                        $obCon->ActualizaRegistro("notas_credito", "Estado", 11, "ID", $idNota);
                    }    
                }else{
                    $obCon->ActualizaRegistro("notas_credito", "Estado", 11, "ID", $idNota);
                }
            }else{
                $obCon->ActualizaRegistro("notas_credito", "Estado", 1, "ID", $idNota);
                exit("OK;Nota Credito $idNota Enviada");
            }
        break;//fin caso 7 
        
        case 8:// actualice uuid de las notas
            $sql="SELECT * FROM notas_credito WHERE UUID='' ORDER BY ID DESC ";
            $Consulta=$obCon->Query($sql);
            
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                $response=str_replace(PHP_EOL, '', $datos_consulta["RespuestaCompletaServidor"]);
                $response=str_replace("\n", '',$response);
                $response=str_replace("\r", '',$response);
                $response=str_replace("'", '',$response);
                $array_respuesta= json_decode($response,1);
                if(isset($array_respuesta["uuid"])){
                    $obCon->ActualizaRegistro("notas_credito", "UUID", $array_respuesta["uuid"], "ID", $datos_consulta["ID"]);
                }else{
                    $obCon->ActualizaRegistro("notas_credito", "Estado", 10, "ID", $datos_consulta["ID"]);
                }
                
            }
            
            print("OK;UUID de las notas actualizados");
        break;//Fin caso 8    
        
        case 9:// envie una nota credito por mail
            $documento_id='';
            if(isset($_REQUEST["idDocumento"])){
                $documento_id=$obCon->normalizar($_REQUEST["idDocumento"]);
            }
            
            $obPDF = new PDF_Documentos_Electronicos($db);
            $obFE = new Factura_Electronica($idUser);
            $Tabla="notas_credito";
            
            if($documento_id==''){
                $condicion="WHERE UUID<>'' and EnviadoPorMail=0 ORDER BY ID DESC LIMIT 1";
            }else{
                $condicion="WHERE UUID<>'' and ID='$documento_id' LIMIT 1";
            }
            $sql="SELECT ID,idFactura,UUID,RespuestaCompletaServidor FROM $Tabla  $condicion";
            $DatosLogFactura=$obCon->FetchAssoc($obCon->Query($sql));
            $uuid=$DatosLogFactura["UUID"];
            if($uuid==''){
                exit("RE;No se encontraron Notas a Enviar X Email");
            }
            $datos_factura=$obCon->DevuelveValores("facturas", "idFacturas", $DatosLogFactura["idFactura"]);
            $datos_cliente=$obCon->DevuelveValores("clientes", "idClientes", $datos_factura["Clientes_idClientes"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
            
            $datos_configuracion_general=$obCon->DevuelveValores("configuracion_general", "ID", 16); //Ruta donde se almacenan las facturas electronicas
            /*
            $ruta=$obPDF->pdf_factura_electronica($DatosLogFactura["idFactura"], 1,"../".$datos_configuracion_general["Valor"]);
            $im = file_get_contents($ruta);
            $pdfBase64Bytes = base64_encode($im);
            
             * 
             */
                     
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 112); //Ruta para enviar un mail     
            $url=$DatosServidor["IP"];   

            $url=$url.$uuid;
            /*
            $body='{
                    "to": [
                      {
                        "email": "'.$datos_cliente["Email"].'"
                      }
                    ],
                    "cc": [
                      {
                        "email": "'.$datos_empresa["Email"].'"
                      }
                    ],
                    
                    "pdf_base64_bytes": "'.$pdfBase64Bytes.'"
                    
                  }';
            
             * 
             */
            $body='{
                    "to": [
                      {
                        "email": "'.$datos_cliente["Email"].'"
                      }
                    ],
                    "cc": [
                      {
                        "email": "'.$datos_empresa["Email"].'"
                      }
                    ]
                    
                  }';
            $response = $obFE->callAPI('POST', $url, $body);
            $array_respuesta= json_decode($response,1);
           
            if(isset($array_respuesta["is_valid"])){
                print("OK;Nota $DatosLogFactura[ID] Enviada");
                $obCon->ActualizaRegistro($Tabla, "EnviadoPorMail", 1, "ID", $DatosLogFactura["ID"]);
            }else{
                print("OK;Nota $DatosLogFactura[ID] No pudo ser Enviada");
                $obCon->ActualizaRegistro($Tabla, "EnviadoPorMail", 2, "ID", $DatosLogFactura["ID"]);
            }
            
        break;//Fin caso 9
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>