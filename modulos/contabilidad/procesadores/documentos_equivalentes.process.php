<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/documentos_equivalentes.class.php");
//include_once("../../../general/clases/contabilidad.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new DocumentosEquivalentes($idUser);
    //$obContabilidad = new contabilidad($idUser);
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear o editar un documento equivalente
            $Tabla="documentos_equivalentes";
            $Datos["fecha"]=$obCon->normalizar($_REQUEST["TxtFecha"]);            
            $Datos["resolucion_id"]=$obCon->normalizar($_REQUEST["resolucion_documento_equivalente"]);
            $Datos["empresa_id"]=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $Datos["sucursal_id"]=$obCon->normalizar($_REQUEST["CmbSucursal"]);
            $Datos["centro_costos_id"]=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);
            $Datos["concepto"]=$obCon->normalizar($_REQUEST["TxtObservaciones"]);
            $Datos["tercero_id"]=$obCon->normalizar($_REQUEST["tercero_id"]);
            $Datos["estado"]=1;
            $Datos["idUser"]=$idUser;
            $resolucion_id=$Datos["resolucion_id"];
            $sql="SELECT MAX(consecutivo) as consecutivo_actual FROM documentos_equivalentes WHERE resolucion_id='$resolucion_id'";
            $datos_consulta=$obCon->FetchAssoc($obCon->Query($sql));
            $Consecutivo= $datos_consulta["consecutivo_actual"];
            $Consecutivo++;
            $datos_resolucion=$obCon->DevuelveValores("documentos_equivalentes_resoluciones", "ID", $resolucion_id);
            if($Consecutivo>$datos_resolucion["hasta"]){
                $obCon->ActualizaRegistro("documentos_equivalentes_resoluciones", "estado", 3, "ID", $resolucion_id);
                exit("E1;la resolución seleccionada ya fué completada");

            }
            $Datos["consecutivo"]=$Consecutivo;
            
            $sql=$obCon->getSQLInsert($Tabla, $Datos);
            $obCon->Query($sql);
            $idDocumento= $obCon->ObtenerMAX($Tabla, "ID", 1, "");           
            $datos_documento=$obCon->DevuelveValores("vista_documentos_equivalentes", "ID", $idDocumento);
            print("OK;$idDocumento;$datos_documento[ID] || $datos_documento[fecha] || $datos_documento[tercero_razon_social] || $datos_documento[tercero_id]");
        break; 
    
        case 2: //edita los valores de un documento
            $tabla_id=$obCon->normalizar($_REQUEST["tabla_id"]); 
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);            
            $campo_editar=$obCon->normalizar($_REQUEST["campo_editar"]);
            $nuevo_valor=$obCon->normalizar($_REQUEST["nuevo_valor"]);
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            if($tabla_id==1){
                if($nuevo_valor==''){
                    exit("E1; El campo no puede estar vacío");
                }
                $obCon->ActualizaRegistro("documentos_equivalentes", $campo_editar, $nuevo_valor, "ID", $item_id,0);
            }
            if($tabla_id==2){
                if($nuevo_valor==''){
                    exit("E1; El campo no puede estar vacío");
                }
                $datos_documento=$obCon->DevuelveValores("documentos_equivalentes_items", 'ID', $item_id);
                if($campo_editar=="valor_unitario"){
                    $total_item=round($nuevo_valor*$datos_documento["cantidad"],2);
                    $obCon->ActualizaRegistro("documentos_equivalentes_items", "total_item", $total_item, "ID", $item_id,0);
                
                }
                if($campo_editar=="cantidad"){
                    $total_item=round($nuevo_valor*$datos_documento["valor_unitario"],2);
                    $obCon->ActualizaRegistro("documentos_equivalentes_items", "total_item", $total_item, "ID", $item_id,0);
                
                }
                $obCon->ActualizaRegistro("documentos_equivalentes_items", $campo_editar, $nuevo_valor, "ID", $item_id,0);
                
            }
            if($tabla_id==3){
                if($nuevo_valor==''){
                    exit("E1; El campo no puede estar vacío");
                }
                $obCon->ActualizaRegistro("documentos_equivalentes_retenciones", $campo_editar, $nuevo_valor, "ID", $item_id,0);
            }
            $obCon->actualizar_retenciones($idDocumento);
            print("OK;Registro modificado");
        break; //Fin caso 2
    
        case 3: //Agrega un movimiento a un documento
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]); 
            $Datos["cantidad"]=$obCon->normalizar($_REQUEST["cantidad_item"]);            
            $Datos["descripcion"]=$obCon->normalizar($_REQUEST["descripcion_item"]);   
            $Datos["valor_unitario"]=$obCon->normalizar($_REQUEST["valor_unitario_item"]);   
             
            $Datos["cuenta_puc"]=$obCon->normalizar($_REQUEST["cuenta_item"]);   
            $Datos["documento_equivalente_id"]=$idDocumento;       
            foreach ($Datos as $key => $value) {
                if($value==''){
                    exit("E1;El campo $key no puede estar vacío");
                }
            }
            if(!is_numeric($Datos["cantidad"]) or $Datos["cantidad"]<=0){
                exit("E1;El campo Cantidad debe ser un valor númerico mayor a cero");
            }
            if(!is_numeric($Datos["valor_unitario"]) or $Datos["valor_unitario"]<=0){
                exit("E1;El campo Valor Unitario debe ser un valor númerico mayor a cero");
            }
            $Datos["total_item"]=round($Datos["valor_unitario"]*$Datos["cantidad"],2);  
            $Tabla="documentos_equivalentes_items";
            $sql=$obCon->getSQLInsert($Tabla, $Datos);
            $obCon->Query($sql);
            $obCon->actualizar_retenciones($idDocumento);
            print("OK;Item Agregado");
        break; //Fin caso 3
        
        case 4: //Agrega una retencion a un documento
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]); 
            $Datos["porcentaje"]=$obCon->normalizar($_REQUEST["porcentaje_retenido"]);            
            $Datos["cuenta_puc"]=$obCon->normalizar($_REQUEST["cuenta_retencion"]);   
            $Datos["asumida"]=$obCon->normalizar($_REQUEST["retencion_asumida"]);   
             
            $Datos["documento_equivalente_id"]=$idDocumento;       
            foreach ($Datos as $key => $value) {
                if($value==''){
                    exit("E1;El campo $key no puede estar vacío");
                }
            }
            if(!is_numeric($Datos["porcentaje"]) or $Datos["porcentaje"]<=0){
                exit("E1;El campo Porcentaje debe ser un valor númerico mayor a cero");
            }
            $sql="SELECT SUM(total_item) as total_items FROM documentos_equivalentes_items WHERE documento_equivalente_id='$idDocumento' AND deleted='0000-00-00 00:00:00'";
            $totales_documento=$obCon->FetchAssoc($obCon->Query($sql));
            $base=$totales_documento["total_items"];
            $Datos["valor_retenido"]=round(($Datos["porcentaje"]/100)*$base,2); 
            $Datos["base"]=$base;  
            $Tabla="documentos_equivalentes_retenciones";
            $sql=$obCon->getSQLInsert($Tabla, $Datos);
            $obCon->Query($sql);
            
            
            
            print("OK;Retencion Agregada");
        break; //Fin caso 4
        
        case 5: //Guardar un documento contable
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            $DatosDocumento=$obCon->DevuelveValores("documentos_contables_control", "ID", $idDocumento);
            
            $Debitos=$obCon->Sume("documentos_contables_items", "Debito", "WHERE idDocumento='$idDocumento'");
            $Creditos=$obCon->Sume("documentos_contables_items", "Credito", "WHERE idDocumento='$idDocumento'");
            $Diferencia=$Debitos-$Creditos;
            if($Diferencia<>0){
                print("E1;El documento no está balanceado");
                exit();
            }
            $obCon->GuardarDocumentoContable($idDocumento); 
            
            if($DatosDocumento["idDocumento"]==9){ //Verifico si es un cierre contable y cambio el estado en el control
                $Anio=substr($DatosDocumento["Fecha"],0,4);                
                $sql="UPDATE cierre_contable_control SET ContabilizarCierre=1, Estado=2 WHERE Anio='$Anio' AND ContabilizarCierre=0 AND Estado=1";
                $obCon->Query($sql);                
            }
            $Ruta="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=32&idDocumentoContable=$idDocumento";
            $Mensaje="Documento Guardado <a href='$Ruta' target='_blank'>Imprimir</>";
            print("OK;$Mensaje");
        break; //Fin caso 5
        
        case 6: //Copiar un documento contable
            $idDocumentoDestino=$obCon->normalizar($_REQUEST["idDocumento"]);
            $idDocumentoACopiar=$obCon->normalizar($_REQUEST["idDocumentoACopiar"]);
            $TipoDocumento=$obCon->normalizar($_REQUEST["TipoDocumento"]);
            if($idDocumentoDestino==''){
                print("Debe seleccionar un documento destino");
                exit();
            }
            if($idDocumentoACopiar==''){
                print("Debe seleccionar un documento a copiar");
                exit();
            }
            $obCon->CopiarItemsDocumento($TipoDocumento,$idDocumentoACopiar, $idDocumentoDestino);
            print("OK");
        break; //Fin caso 6
        
        case 7: //Editar el valor de un debito o un Credito en un movimiento de un documento contable
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Valor=$obCon->normalizar($_REQUEST["Valor"]);
            $TipoMovimiento=$obCon->normalizar($_REQUEST["TipoMovimiento"]);
            if($Valor==''){
                print("Debe Escribir un valor");
                exit();
            }
            if(!is_numeric($Valor)){
                print("El valor debe ser númerico");
                exit();
            }
            if($TipoMovimiento=="DB"){
                $CampoEditar="Debito";
            }else{
                $CampoEditar="Credito";
            }
            
            $DatosBase=$obCon->DevuelveValores("documentos_contables_registro_bases", "idItemDocumentoContable", $idItem);
            if($DatosBase["ValorPorcentaje"]=='' or $DatosBase["ValorPorcentaje"]==0){
                $Divisor=1;
            }else{
                $Divisor=$DatosBase["ValorPorcentaje"];
            }
            $Base=$Valor/$Divisor;
            $obCon->ActualizaRegistro("documentos_contables_registro_bases", "Base", $Base, "idItemDocumentoContable", $idItem);
            
            $obCon->ActualizaRegistro("documentos_contables_items", $CampoEditar, $Valor, "ID", $idItem);
            print("OK");
        break; //Fin caso 7
        
        case 8: //Editar la cuenta en un movimiento de un documento contable
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $CuentaPUC=$obCon->normalizar($_REQUEST["CuentaPUC"]);
            
            if($CuentaPUC==''){
                print("Debe Escribir un valor");
                exit();
            }
            if(!is_numeric($CuentaPUC)){
                print("El valor debe ser númerico");
                exit();
            }
            
            $DatosCuentas=$obCon->DevuelveValores("subcuentas", "PUC", $CuentaPUC);
            $SolicitaBase=$obCon->VerificaSiCuentaSolicitaBase($CuentaPUC);
            $DatosBase=$obCon->DevuelveValores("documentos_contables_registro_bases", "idItemDocumentoContable", $idItem);
            if(($DatosBase["Base"]=='' or $DatosBase["Base"]=='0') and $SolicitaBase==1){
                print("La Cuenta $CuentaPUC Solicita una Base, no puedes editar este movimiento, se debe eliminar el movimiento y hacerlo nuevamente");
                exit();
            }
            
            $obCon->ActualizaRegistro("documentos_contables_items", "CuentaPUC", $CuentaPUC, "ID", $idItem);
            $obCon->ActualizaRegistro("documentos_contables_items", "NombreCuenta", $DatosCuentas["Nombre"], "ID", $idItem);
            
            if($DatosCuentas["SolicitaBase"]==0){
                $obCon->ActualizaRegistro("documentos_contables_registro_bases", "Base", 0, "idItemDocumentoContable", $idItem);
                $obCon->ActualizaRegistro("documentos_contables_registro_bases", "Estado", 'ANULADO', "idItemDocumentoContable", $idItem);
            }
            
            print("OK");
        break; //Fin caso 8
        
        case 9: //Editar el un tercero 
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Tercero=$obCon->normalizar($_REQUEST["Tercero"]);
            
            if($Tercero==''){
                print("Debe Escribir un valor");
                exit();
            }
            if(!is_numeric($Tercero)){
                print("El valor debe ser númerico");
                exit();
            }
            
            $obCon->ActualizaRegistro("documentos_contables_items", "Tercero", $Tercero, "ID", $idItem);
           
            print("OK");
        break; //Fin caso 9
        
        case 10: //Consulta si la cuenta solicita Base
            $CuentaPUC=$obCon->normalizar($_REQUEST["CuentaPUC"]);
          
            print($obCon->VerificaSiCuentaSolicitaBase($CuentaPUC));
        break; //Fin caso 10
    
        case 11: //Editar la base
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Base=$obCon->normalizar($_REQUEST["Valor"]);
            
            if($Base==''){
                print("Debe Escribir un valor");
                exit();
            }
            if(!is_numeric($Base)){
                print("El valor debe ser númerico");
                exit();
            }
            
            if($Base<=0){
                print("El valor debe ser un número mayor a cero");
                exit();
            }
            
            $DatosBase=$obCon->DevuelveValores("documentos_contables_registro_bases", "ID", $idItem);
            
            $Valor=$Base*$DatosBase["ValorPorcentaje"];
            $obCon->ActualizaRegistro("documentos_contables_registro_bases", "Valor", $Valor, "ID", $idItem);
            $obCon->ActualizaRegistro("documentos_contables_registro_bases", "Base", $Base, "ID", $idItem);
            $Columna="Debito";
            if($DatosBase["TipoMovimiento"]=='CR'){
                $Columna="Credito";
            }
            $obCon->ActualizaRegistro("documentos_contables_items", $Columna, $Valor, "ID", $DatosBase["idItemDocumentoContable"]);
            print("OK");
        break; //Fin caso 11
        
        case 12: //Editar el porcentaje
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Porcentaje=$obCon->normalizar($_REQUEST["Valor"]);
            
            if($Porcentaje==''){
                print("Debe Escribir un Porcentaje");
                exit();
            }
            if(!is_numeric($Porcentaje)){
                print("El Porcenje debe ser númerico");
                exit();
            }
            
            if($Porcentaje<=0 or $Porcentaje>100){
                print("El porcentaje debe ser un número mayor a cero y menor a 100");
                exit();
            }
            $Porcentaje=round($Porcentaje,2);
            $DatosBase=$obCon->DevuelveValores("documentos_contables_registro_bases", "ID", $idItem);
            $multiplo=round($Porcentaje/100,2);
            $Valor=$DatosBase["Base"]*$multiplo;
            $obCon->ActualizaRegistro("documentos_contables_registro_bases", "Valor", $Valor, "ID", $idItem);
            $obCon->ActualizaRegistro("documentos_contables_registro_bases", "Porcentaje", $Porcentaje, "ID", $idItem);
            $obCon->ActualizaRegistro("documentos_contables_registro_bases", "ValorPorcentaje", $multiplo, "ID", $idItem);
            $Columna="Debito";
            if($DatosBase["TipoMovimiento"]=='CR'){
                $Columna="Credito";
            }
            $obCon->ActualizaRegistro("documentos_contables_items", $Columna, $Valor, "ID", $DatosBase["idItemDocumentoContable"]);
            print("OK");
        break; //Fin caso 12
        
        
        case 13: //Agrega un movimiento a un documento desde una cuenta x pagar o x cobrar
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]); 
            $idItem=$obCon->normalizar($_REQUEST["idItem"]); 
            $Total=$obCon->normalizar($_REQUEST["Total"]); 
            $CuentaPUC=$obCon->normalizar($_REQUEST["CuentaPUC"]); 
            $NombreCuenta=$obCon->normalizar($_REQUEST["NombreCuenta"]); 
            $Tercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            $TxtDocReferencia=$obCon->normalizar($_REQUEST["DocReferencia"]); 
            
            //$DatosMovimiento=$obCon->DevuelveValores("vista_cuentasxtercerosdocumentos_v2", "ID", $idItem);
            //$CuentaPUC=$DatosMovimiento["CuentaPUC"];            
            //$Tercero=$DatosMovimiento["Tercero_Identificacion"];
            $TxtConcepto="Cuenta x Pagar";
            $Valor=abs($Total); 
            if($Total>=0){
                $TipoMovimiento="CR";
            }else{
                $TipoMovimiento="DB";
            }
            
            //$TxtDocReferencia=$DatosMovimiento["NumeroDocumentoExterno"];
            
            $Base=0;
            $Porcentaje=0;
            if(!is_numeric($Valor)){
                print("E1;El Campo Valor debe ser númerico");
                exit();
            }
            
            if(!is_numeric($Base)){
                print("E1;El Campo Base debe ser númerico");
                exit();
            }
            
            if(!is_numeric($Porcentaje)){
                print("E1;El Campo Porcentaje debe ser númerico");
                exit();
            }
            
            $idItem=$obCon->AgregaMovimientoDocumentoContable($idDocumento, $Tercero, $CuentaPUC, $TipoMovimiento, $Valor, $TxtConcepto,$TxtDocReferencia,  "");
            if($Base>0){
                $obCon->AgregueBaseAMovimientoContable($idDocumento, $TxtConcepto, $Base, $Porcentaje, $Valor, $idUser, $idItem);
            }
            print("OK;Movimiento Agregado");
        break; //Fin caso 13
        
        case 14:// abre un documento contable
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            $sql="SELECT t1.Consecutivo, t1.Estado,
                    (SELECT t2.Nombre FROM documentos_contables t2 WHERE t1.idDocumento=t2.ID LIMIT 1) AS NombreDocumento 
                    FROM documentos_contables_control t1 WHERE t1.ID='$idDocumento';";
            $DatosDocumento= $obCon->FetchAssoc($obCon->Query($sql));
            if($DatosDocumento["Estado"]=='ABIERTO'){
                exit("E1;El documento ya está abierto");
            }
            $obCon->AbrirDocumentoContable($idDocumento);
            $DatosDocumentoControl=$obCon->DevuelveValores("documentos_contables_control", "ID", $idDocumento);
            if($DatosDocumentoControl["idDocumento"]==9){//Comprueba si es un cierre contable y si lo es reicio el control y borro los items del documento
                $Anio=substr($DatosDocumentoControl["Fecha"],0,4);                
                $sql="UPDATE cierre_contable_control SET CerrarCuentasResultado=0,TrasladarSaldosBalance=0,ContabilizarCierre=0,Estado=1 WHERE Anio='$Anio' AND Estado=2";
                $obCon->Query($sql);
                $sql="DELETE FROM documentos_contables_items WHERE idDocumento='$idDocumento'";
                $obCon->Query($sql);
            }
            print("OK;$DatosDocumento[NombreDocumento] $DatosDocumento[Consecutivo] Abierto;$idDocumento;$DatosDocumento[NombreDocumento] $DatosDocumento[Consecutivo]");
        break;// fin caso 15
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>