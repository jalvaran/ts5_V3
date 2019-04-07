<?php
if(file_exists("../../modelo/php_conexion.php")){
    include_once("../../modelo/php_conexion.php");
}

class contabilidad extends ProcesoVenta{
   
    function CrearComprobanteIngreso($Fecha,$idCliente,$Tercero,$Valor,$Tipo,$Concepto,$Estado) {
        $Tabla="comprobantes_ingreso";
        $Datos["Fecha"]=$Fecha;
        $Datos["Clientes_idClientes"]=$idCliente;
        $Datos["Tercero"]=$Tercero;
        $Datos["Valor"]=$Valor;
        $Datos["Tipo"]=$Tipo;
        $Datos["Concepto"]=$Concepto;
        $Datos["Usuarios_idUsuarios"]=$_SESSION["idUser"];
        $Datos["Estado"]=$Estado;
        $sql=$this->getSQLInsert($Tabla, $Datos);
        $this->Query($sql);
        $idComprobante=$this->ObtenerMAX($Tabla, "ID", 1, "");
        return($idComprobante);
    }
    
    function ContabilizarComprobanteIngreso($idComprobante,$Tercero,$CuentaDebito,$CuentaCredito,$idEmpresa,$idSede,$idCentroCostos) {
        $DatosComprobante=$this->DevuelveValores("comprobantes_ingreso", "ID", $idComprobante);
        $DatosCuentaDebito= $this->DevuelveValores("subcuentas", "PUC", $CuentaDebito);
        $DatosCuentaCredito= $this->DevuelveValores("subcuentas", "PUC", $CuentaCredito);
        $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteIngreso", $idComprobante, "", $Tercero, $CuentaDebito, $DatosCuentaDebito["Nombre"], "Ingreso", "DB", $DatosComprobante["Valor"], $DatosComprobante["Concepto"], $idCentroCostos, $idSede, "");
        $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteIngreso", $idComprobante, "", $Tercero, $CuentaCredito, $DatosCuentaCredito["Nombre"], "Ingreso", "CR", $DatosComprobante["Valor"], $DatosComprobante["Concepto"], $idCentroCostos, $idSede, "");
    }
    /**
     * Fin Clase
     */
}
