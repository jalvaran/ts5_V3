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
            //$documento_id=$obCon->normalizar($_REQUEST["idDocumento"]);
            $obPDF = new PDF_Documentos_Electronicos($db);
            $obFE = new Factura_Electronica($idUser);
            $Tabla="facturas_electronicas_log";
            $sql="SELECT ID,idFactura,UUID,RespuestaCompletaServidor FROM $Tabla  WHERE UUID<>'' and EnviadoPorMail=0 LIMIT 1";
            $DatosLogFactura=$obCon->FetchAssoc($obCon->Query($sql));
            $uuid=$DatosLogFactura["UUID"];
            if($uuid==''){
                exit("RE;No se encontraron Facturas a Enviar");
            }
            $datos_factura=$obCon->DevuelveValores("facturas", "idFacturas", $DatosLogFactura["idFactura"]);
            $datos_cliente=$obCon->DevuelveValores("clientes", "idClientes", $datos_factura["Clientes_idClientes"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
            
            $datos_configuracion_general=$obCon->DevuelveValores("configuracion_general", "ID", 16); //Ruta donde se almacenan las facturas electronicas
            
            $ruta=$obPDF->pdf_factura_electronica($DatosLogFactura["idFactura"], 1,"../".$datos_configuracion_general["Valor"]);
            $im = file_get_contents($ruta);
            $pdfBase64Bytes = base64_encode($im);
            
                     
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
                    ],
                    
                    "pdf_base64_bytes": "'.$pdfBase64Bytes.'"
                    
                  }';
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
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>