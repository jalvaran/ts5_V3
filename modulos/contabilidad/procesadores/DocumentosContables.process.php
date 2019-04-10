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
        break; //Fin caso 2
    
        case 3: //Agrega un movimiento a un documento
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]); 
            $CuentaPUC=$obCon->normalizar($_REQUEST["CuentaPUC"]);            
            $Tercero=$obCon->normalizar($_REQUEST["Tercero"]);
            $TxtConcepto=$obCon->normalizar($_REQUEST["TxtConcepto"]);
            $TipoMovimiento=$obCon->normalizar($_REQUEST["TipoMovimiento"]);
            $Valor=$obCon->normalizar($_REQUEST["Valor"]);
            if(!is_numeric($Valor)){
                print("E1;El Campo Valor debe ser númerico");
                exit();
            }
            $obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaPUC, $TipoMovimiento, $Valor, $TxtConcepto, "", "");
            print("OK;Movimiento Agregado");
        break; //Fin caso 3
        
        case 4: //Eliminar un item de un documento
            $idTabla=$obCon->normalizar($_REQUEST["Tabla"]);
            $idItem=$obCon->normalizar($_REQUEST["idItem"]); 
            $Tabla="";
            if($idTabla==1){
                $Tabla="documentos_contables_items";
            }
            $obCon->BorraReg($Tabla, "ID", $idItem);
            print("Item Eliminado");
        break; //Fin caso 4
        
        case 5: //Guardar un documento contable
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            
            $Debitos=$obCon->Sume("documentos_contables_items", "Debito", "WHERE idDocumento='$idDocumento'");
            $Creditos=$obCon->Sume("documentos_contables_items", "Credito", "WHERE idDocumento='$idDocumento'");
            $Diferencia=$Debitos-$Creditos;
            if($Diferencia<>0){
                print("E1;El documento no está balanceado");
                exit();
            }
            $obCon->GuardarDocumentoContable($idDocumento); 
            $Ruta="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=32&idDocumentoContable=$idDocumento";
            $Mensaje="Documento Guardado <a href='$Ruta' target='_blank'>Imprimir</>";
            print("OK;$Mensaje");
        break; //Fin caso 4
        
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>