<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/notas_credito.class.php");
include_once("../../../general/clases/facturacion_electronica.class.php");
include_once("../../../general/clases/mail.class.php");
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
            $obMail= new TS_Mail($idUser);
            
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
            $respuesta_server=str_replace( PHP_EOL, '', $DatosLogFactura["RespuestaCompletaServidor"]);
            $respuesta_server=str_replace( "\n", '', $respuesta_server);
            
            $array_documento= json_decode($respuesta_server,1);
            //print("<pre> Array: ");
            //print_r($array_documento);
            //print("</pre>");
            
            $link_aceptacion=$array_documento["urlAcceptance"];
            $link_rechazo=$array_documento["urlRejection"];
            
            
            
            $datos_factura=$obCon->DevuelveValores("facturas", "idFacturas", $DatosLogFactura["idFactura"]);
            $datos_cliente=$obCon->DevuelveValores("clientes", "idClientes", $datos_factura["Clientes_idClientes"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
            $pdfBase64Bytes='';
            $datos_configuracion_general=$obCon->DevuelveValores("configuracion_general", "ID", 16); //Ruta donde se almacenan las facturas electronicas
            $nombre_documento="";
            $zip_base64=$array_documento["zipBase64Bytes"];
            $nombre_archivos= str_replace(".zip", "", $array_documento["zipName"]);
            
            $ruta_archivo=$obFE->CrearZIPDesdeBase64($zip_base64, $nombre_archivos,"../../../");
            
            $ruta_pdf_xml="../".$datos_configuracion_general["Valor"];
            if (!file_exists($ruta_pdf_xml)) {
                mkdir($ruta_pdf_xml, 0777);
            }
            $ruta_pdf_xml.=$nombre_archivos;
            if (!file_exists($ruta_pdf_xml)) {
                mkdir($ruta_pdf_xml, 0777);
            }
            if($Tabla=="facturas_electronicas_log"){
                $ruta=$obPDF->pdf_factura_electronica($DatosLogFactura["idFactura"], 1,$ruta_pdf_xml."/",$nombre_archivos);
                $im = file_get_contents($ruta);
                $pdfBase64Bytes = base64_encode($im);
                $nombre_documento=$datos_factura["Prefijo"].$datos_factura["NumeroFactura"];
                $titulo_mensaje="FACTURA ELECTRÓNICA $nombre_documento";
                $asunto="Factura Electrónica $nombre_documento, ".$datos_empresa["RazonSocial"];
            }
            if($Tabla=="notas_credito"){
                $nombre_documento="NC".$DatosLogFactura["ID"];
                $titulo_mensaje="NOTA CRÉDITO ELECTRÓNICA $nombre_documento";
                $pdfBase64Bytes=$array_documento["pdfBase64Bytes"];
                $obFE->CrearPDFDesdeBase64($pdfBase64Bytes, "",$ruta_pdf_xml."/",$nombre_archivos);
                $asunto="Nota Crédito Electrónica $nombre_documento, ".$datos_empresa["RazonSocial"];
            }
            
            $zip = new ZipArchive();
            
            if ($zip->open($ruta_archivo) === true) {
                $zip->extractTo($ruta_pdf_xml);            
                $zip->close();                  
            }
            $ruta_pdf_xml.="/";
            $dir_open=opendir($ruta_pdf_xml);

            $filename=$ruta_pdf_xml.$nombre_archivos.".zip";
            $files = array();
            while ($current = readdir($dir_open)){
              if( $current != "." && $current != "..") {
                if(is_dir($ruta_pdf_xml.$current)) {
                 
                } else {
                 
                  $files[] = $current;
                }
              }
            }
            
            if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE){
              exit("E1;No se puede crear el zip"); 
            }

            // agrego los archivos que quedrán en el zip
            foreach($files as $file){
              
              $localfile = basename($file);
              
              $array_name_file= explode(".", $localfile);
              if($array_name_file[1]=='pdf'){
                  $localfile="$nombre_archivos".".pdf";
                  $zip->addfile($ruta_pdf_xml.$file, $localfile); // las demás opciones por defecto
              }
              if($array_name_file[1]=='xml'){
                  $localfile="$nombre_archivos".".xml";
                  $zip->addfile($ruta_pdf_xml.$file, $localfile); // las demás opciones por defecto
              }
              
            }

            $zip->close();
            
            $im = file_get_contents($filename);             
            $zipBase64Bytes=base64_encode($im);
            /*
            $ruta_archivo= str_replace("../", "", $filename);
            $ruta_archivo="../../".$ruta_archivo;
           
            print('<a href="'.$ruta_archivo.'" target="_blank"  >ver</a>');
            
            exit();
            
             * 
             */
            
            
            $datos_parametros=$obCon->DevuelveValores("facturas_electronicas_parametros", "ID", 5);
            $mensajeHTML='<div style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;background-color:#ffffff;color:#718096;height:100%;line-height:1.4;margin:0;padding:0;width:100%!important">

                        <table role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;background-color:#edf2f7;margin:0;padding:0;width:100%" width="100%" cellspacing="0" cellpadding="0">
                        <tbody><tr>
                        <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`" align="center">
                        <table role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;margin:0;padding:0;width:100%" width="100%" cellspacing="0" cellpadding="0">
                        <tbody><tr>
                        <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;padding:25px 0;text-align:center">
                        <a href="#" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;color:#3d4852;font-size:19px;font-weight:bold;text-decoration:none;display:inline-block" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://35.238.236.240:80&amp;source=gmail&amp;ust=1616861302531000&amp;usg=AFQjCNF0cJ1bl4Tvcy9-16fYFdizZj4K7Q">
                        @empresa_pro
                        </a>
                        </td>
                        </tr>


                        <tr>
                        <td cellpadding="0" cellspacing="0" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%" width="100%">
                        <table class="m_-4707899643165363748inner-body" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:570px" width="570" cellspacing="0" cellpadding="0" align="center">

                        <tbody><tr>
                        <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;max-width:100vw;padding:32px">
                        <h1 style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">@titulo_mensaje</h1>
                        <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Hola, <strong style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`">@razon_social_tercero</strong>, adjunto realizamos envío de la siguiente documentación:</p>
                        <ul style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;line-height:1.4;text-align:left">
                        <li style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`">Archivo PDF en donde encontrará: Representación Gráfica del documento electrónico N° @numero_documento y un archivo Zip con el correspondiente XML y PDF.
                        <br>
                        <strong>Acuse de recibido:</strong><br>

                        <a href="@link_aceptacion" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#48bb78;border-bottom:8px solid #48bb78;border-left:18px solid #48bb78;border-right:18px solid #48bb78;border-top:8px solid #48bb78" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://35.238.236.240/api/ubl2.1/document-received/3bffba2c732ec3120f601586fdd78c1440832ee5bb1b5c49b16c284c6d304fdf4be4ba263373009638c3754a82b379eb/1?expires%3D1615099973%26signature%3D379053754af082267049eeb14644fa19ba81ee7a11bdd28c938bcc355ce8944c&amp;source=gmail&amp;ust=1616862643869000&amp;usg=AFQjCNGh_M98j88BlgYjmqOQuY_ufcEGyw">Aceptar</a>
                        <a href="@link_rechazo" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#e53e3e;border-bottom:8px solid #e53e3e;border-left:18px solid #e53e3e;border-right:18px solid #e53e3e;border-top:8px solid #e53e3e" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://35.238.236.240/api/ubl2.1/document-received/3bffba2c732ec3120f601586fdd78c1440832ee5bb1b5c49b16c284c6d304fdf4be4ba263373009638c3754a82b379eb/0?expires%3D1615099973%26signature%3De2ea519e500cd2a6fe91a9828ea2c566d88fcf5db0680cbf37f863ac4a733e7d&amp;source=gmail&amp;ust=1616862643869000&amp;usg=AFQjCNFdnBuynIM5TzS9t5GgWIDZ5dwB3g">Rechazar</a>
                        </li>

                        </ul>


                        <table role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;border-top:1px solid #e8e5ef;margin-top:25px;padding-top:25px" width="100%" cellspacing="0" cellpadding="0">
                        <tbody><tr>
                        <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`">
                        <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;line-height:1.5em;margin-top:0;text-align:left;font-size:14px">Gracias,
                        @empresa_pro</p>

                        </td>
                        </tr>
                        </tbody></table>
                        </td>
                        </tr>
                        </tbody></table>
                        </td>
                        </tr>

                        <tr>
                        <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`">
                        <table class="m_-4707899643165363748footer" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;margin:0 auto;padding:0;text-align:center;width:570px" width="570" cellspacing="0" cellpadding="0" align="center">


                        <tbody><tr>
                        <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;max-width:100vw;padding:32px" align="center">
                        <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,`Segoe UI`,Roboto,Helvetica,Arial,sans-serif,`Apple Color Emoji`,`Segoe UI Emoji`,`Segoe UI Symbol`;line-height:1.5em;margin-top:0;color:#b0adc5;font-size:12px;text-align:center">© 2021 @empresa_pro. All rights reserved.</p>

                        </td>
                        </tr>
                        </tbody></table>

                        </td>
                        </tr>
                        </tbody></table>
                        </td>
                        </tr>
                        </tbody></table><div class="yj6qo"></div><div class="adL">
                        </div></div>';
            
            $mensajeHTML= str_replace("@empresa_pro", $datos_empresa["RazonSocial"], $mensajeHTML);
            $mensajeHTML= str_replace("@titulo_mensaje", $titulo_mensaje, $mensajeHTML);
            $mensajeHTML= str_replace("@razon_social_tercero", $datos_cliente["RazonSocial"], $mensajeHTML);
            $mensajeHTML= str_replace("@numero_documento", $nombre_documento, $mensajeHTML);
            $mensajeHTML= str_replace("@link_aceptacion", $link_aceptacion, $mensajeHTML);
            $mensajeHTML= str_replace("@link_rechazo", $link_rechazo, $mensajeHTML);
            
            $destinatarios[0]["email"]=$datos_cliente["Email"];
            $destinatarios[0]["name"]=$datos_cliente["RazonSocial"];
            $destinatarios[1]["email"]=$datos_empresa["Email"];
            $destinatarios[1]["name"]=$datos_empresa["RazonSocial"];
                        
            //$adjuntos[0]["ContentType"]="application/pdf";
            $adjuntos[0]["name"]="$nombre_documento".".pdf";
            $adjuntos[0]["content"]=$pdfBase64Bytes;
            
            //$adjuntos[1]["ContentType"]="application/zip";
            $adjuntos[1]["name"]="$nombre_archivos".".zip";
            $adjuntos[1]["content"]=$zipBase64Bytes;
            
            $respuesta=$obMail->enviar_mail_sendinblue($destinatarios, $asunto, $mensajeHTML,$adjuntos);
            if($respuesta=='OK'){
                print("OK;Factura $DatosLogFactura[idFactura] Enviada");
                $obCon->ActualizaRegistro($Tabla, "EnviadoPorMail", 1, "idFactura", $DatosLogFactura["idFactura"]);
            }else{
                print("E1;La Factura $DatosLogFactura[idFactura] No pudo ser enviada Enviada");
            }
            
        break;//Fin caso 5
        
        /*  usar para enviar el mail desde el api fe directamente 
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
        
         * 
         */
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