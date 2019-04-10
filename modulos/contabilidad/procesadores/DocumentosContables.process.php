<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/DocumentosContables.class.php");
//include_once("../../../general/clases/contabilidad.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new DocumentosContables($idUser);
    //$obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crea un documento contable
            $Fecha=$obCon->normalizar($_REQUEST["TxtFecha"]); 
            
            $CmbTipoDocumento=$obCon->normalizar($_REQUEST["CmbTipoDocumento"]);
            $CmbEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CmbSucursal=$obCon->normalizar($_REQUEST["CmbSucursal"]);
            $CmbCentroCosto=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);
            $TxtObservaciones=$obCon->normalizar($_REQUEST["TxtObservaciones"]);
             
            $idDocumento=$obCon->CrearDocumentoContable($CmbTipoDocumento, $Fecha, $TxtObservaciones, $CmbEmpresa, $CmbSucursal, $CmbCentroCosto, "", $idUser);
            $DatosDocumento=$obCon->DevuelveValores("vista_documentos_contables", "ID", $idDocumento);
            print("OK;$idDocumento;$DatosDocumento[Prefijo] $DatosDocumento[Nombre] $DatosDocumento[Consecutivo] $DatosDocumento[Descripcion]");
        break; 
    
        case 2: //edita los valores de un documento
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumentoActivo"]);              
            
            $Fecha=$obCon->normalizar($_REQUEST["TxtFecha"]);            
            $CmbTipoDocumento=$obCon->normalizar($_REQUEST["CmbTipoDocumento"]);
            $CmbEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CmbSucursal=$obCon->normalizar($_REQUEST["CmbSucursal"]);
            $CmbCentroCosto=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);
            $TxtObservaciones=$obCon->normalizar($_REQUEST["TxtObservaciones"]);
            
            $obCon->ActualizaRegistro("documentos_contables_control", "Fecha", $Fecha, "ID", $idDocumento,0);
            $obCon->ActualizaRegistro("documentos_contables_control", "Descripcion", $TxtObservaciones, "ID", $idDocumento,0);
            $obCon->ActualizaRegistro("documentos_contables_control", "idEmpresa", $CmbEmpresa, "ID", $idDocumento,0);
            $obCon->ActualizaRegistro("documentos_contables_control", "idSucursal", $CmbSucursal, "ID", $idDocumento,0);
            $obCon->ActualizaRegistro("documentos_contables_control", "idCentroCostos", $CmbCentroCosto, "ID", $idDocumento,0);
            $DatosDocumento=$obCon->DevuelveValores("vista_documentos_contables", "ID", $idDocumento);
            print("OK;Documento $idDocumento editado;$DatosDocumento[Prefijo] $DatosDocumento[Nombre] $DatosDocumento[Consecutivo] $DatosDocumento[Descripcion]");
        break; 
        
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>