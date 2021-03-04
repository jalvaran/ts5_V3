<?php 
if(isset($_REQUEST["Accion"])){
    $myPage="PDF_Documentos_Electronicos.draw.php";
    include_once("../../../modelo/php_conexion.php");
    
    include_once("../clases/pdf_documentos_electronicos.class.php");
    @session_start();
    $idUser=$_SESSION["idUser"];
    $obCon = new conexion($idUser);
    
    $obDoc = new PDF_Documentos_Electronicos($db);
    $Accion=$obCon->normalizar($_REQUEST["Accion"]);
  
    
    switch ($Accion){
        
        case 1://Genera el PDF de un documento Electronico
            
            $idFactura=$obCon->normalizar($_REQUEST["ID"]);
            
            $obDoc->pdf_factura_electronica($idFactura,0);

        break;//Fin caso 1
        case 2://Genera el PDF de una nota credito
            
            $nota_id=$obCon->normalizar($_REQUEST["item_id"]);
            $datos_nota=$obCon->DevuelveValores("notas_credito", "ID", $nota_id);
            
            $response=str_replace(PHP_EOL, '', $datos_nota["RespuestaCompletaServidor"]);
            $response=str_replace("\n", '',$response);
            $response=str_replace("\r", '',$response);
            $response=str_replace("'", '',$response);
            $array_respuesta= json_decode($response,1);
            
            $pdf_base64=$array_respuesta["pdfBase64Bytes"];
            $data = base64_decode($pdf_base64);
            header('Content-Type: application/pdf');
            echo $data;
        break;//Fin caso 2
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>