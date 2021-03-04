<?php 
if(isset($_REQUEST["idDocumento"])){
    $myPage="PDF_Documentos_Electronicos.draw.php";
    include_once("../../../modelo/php_conexion.php");
    
    include_once("../clases/pdf_documentos_electronicos.class.php");
    @session_start();
    $idUser=$_SESSION["idUser"];
    $obCon = new conexion($idUser);
    
    $obDoc = new PDF_Documentos_Electronicos($db);
    $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
    
    
    switch ($idDocumento){
        
        case 1://Genera el PDF de un documento Electronico
            
            $idFactura=$obCon->normalizar($_REQUEST["ID"]);
            $TipoFactura="ORIGINAL";
            $Guardar=0;
            
            if(isset($_REQUEST["Guardar"])){
                $Guardar=$obCon->normalizar($_REQUEST["Guardar"]);
            }
            
            $obDoc->pdf_factura_electronica($idFactura,$Guardar);

            
        break;//Fin caso 1
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>