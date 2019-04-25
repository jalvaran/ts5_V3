<?php

/* 
 * Este archivo procesa la anulacion de un documento contable
 */

if(!empty($_REQUEST["BtnAnular"])){
    $obVenta=new ProcesoVenta($idUser);        
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
    $NombreDocumento=$obVenta->normalizar($_REQUEST["NombreDocumento"]);
    $ConsecutivoDocumento=$obVenta->normalizar($_REQUEST["ConsecutivoDocumento"]);
    $fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
    $ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);
    $obVenta->AnularMovimientoLibroDiario($NombreDocumento, $ConsecutivoDocumento, "");
    $obVenta->ActualizaRegistro("documentos_contables_registro_bases", "Base", 0, "idDocumentoContable", $idComprobante);
    $obVenta->ActualizaRegistro("documentos_contables_registro_bases", "Estado", "ANULADO", "idDocumentoContable", $idComprobante);
    $obVenta->ActualizaRegistro("documentos_contables_control", "Estado", "ANULADO", "ID", $idComprobante);
    
    //$idAnulacion=$obVenta->RegistraAnulacionNotaContable($fecha, $ConceptoAnulacion, $idComprobante, "");
    header("location:AnularDocumentoContable.php?TxtidComprobante=$idComprobante");
        
}
?>