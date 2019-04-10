<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class DocumentosContables extends ProcesoVenta{
    /**
     * Crea un documento contable
     * @param type $TipoDocumento
     * @param type $Fecha
     * @param type $Descripcion
     * @param type $idEmpresa
     * @param type $idSucursal
     * @param type $idCentroCostos
     * @param type $Soporte
     * @param type $idUser
     * @return type
     */
    function CrearDocumentoContable($TipoDocumento,$Fecha,$Descripcion,$idEmpresa,$idSucursal,$idCentroCostos,$Soporte,$idUser){
        
        $Tabla="documentos_contables_control";
        $Consecutivo= $this->ObtenerMAX($Tabla, "Consecutivo", "idDocumento", $TipoDocumento);
        $Consecutivo++;
        $Datos["idDocumento"]=$TipoDocumento;
        $Datos["Consecutivo"]=$Consecutivo;
        $Datos["Fecha"]=$Fecha;
        $Datos["Descripcion"]=$Descripcion;
        $Datos["Estado"]="ABIERTO";
        $Datos["idUser"]=$idUser;
        $Datos["idEmpresa"]=$idEmpresa;
        $Datos["idSucursal"]=$idSucursal;
        $Datos["idCentroCostos"]=$idCentroCostos;
        $Datos["Soporte"]=$Soporte;
        $sql= $this->getSQLInsert($Tabla, $Datos);
        $this->Query($sql);
        $idDocNew= $this->ObtenerMAX($Tabla, "ID", 1, "");
        return($idDocNew);
        
    }
    /**
     * Fin Clase
     */
}
