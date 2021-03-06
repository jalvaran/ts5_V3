<?php 
if(isset($_REQUEST["idDocumento"])){
    $myPage="PDF_Documentos.php";
    include_once("../sesiones/php_control.php");
    include_once("../modelo/PrintPos.php");
    include_once("clases/ClasesPDFDocumentos.php");
    
    $obVenta = new ProcesoVenta($idUser);
    $obPrint=new PrintPos($idUser);
    $obDoc = new Documento($db);
    $idDocumento=$obVenta->normalizar($_REQUEST["idDocumento"]);
    
    
    switch ($idDocumento){
        case 4: //Comprobante de ingreso
            $idIngreso=$obVenta->normalizar($_REQUEST["idIngreso"]);
            $obDoc->PDF_CompIngreso($idIngreso);
            $obPrint->ComprobanteIngresoPOS($idIngreso, $DatosImpresora["Puerto"], 1);
            break;
        case 25: //Comprobante de altas y bajas
            $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
            $obDoc->PDF_CompBajasAltas($idComprobante);     
            $obPrint->ImprimeComprobanteBajaAlta($idComprobante, "", 1, "");
            break;
        case 30: //Cuenta de cobro para un tercero
            $idCuenta=$obVenta->normalizar($_REQUEST["idCuenta"]);
            $obDoc->CuentaCobroTercero($idCuenta,"");            
            break;
        case 31: //ODF de una nota de devolucion
            $idNota=$obVenta->normalizar($_REQUEST["idNotaDevolucion"]);
            $obDoc->PDF_NotaDevolucion($idNota,"");            
            break;
        case 32: //PDF de un documento contable
            $idDocumento=$obVenta->normalizar($_REQUEST["idDocumentoContable"]);
            $obDoc->PDF_DocumentoContable($idDocumento,"");            
            break;
        case 33: //PDF de un documento equivalente a factura para nomina
            $idDocumento=$obVenta->normalizar($_REQUEST["idDocEqui"]);
            $obDoc->NominaPDFDocumentoEquivalente($idDocumento,"");            
            break;
    }
}else{
    print("No se recibió parametro de documento");
}

?>