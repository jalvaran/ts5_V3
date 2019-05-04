<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class Contabilidad extends conexion{
    /**
     * Crea la vista para el balance x terceros
     * @param type $Tipo
     * @param type $FechaInicial
     * @param type $FechaFinal
     * @param type $Empresa
     * @param type $CentroCostos
     * @param type $vector
     * @return type
     */
    public function ConstruirVistaBalanceTercero($Tipo,$FechaInicial,$FechaFinal,$Empresa,$CentroCostos,$vector){
        
        $sql="DROP VIEW IF EXISTS `vista_balancextercero2`;";
        $this->Query($sql);
        
        $sql="DROP VIEW IF EXISTS `vista_saldo_inicial_cuentapuc`;";
        $this->Query($sql);
        
        $CondicionEmpresa="";
        $Condicion=" WHERE ";
        $CondicionSaldos=" WHERE Fecha <'$FechaInicial'";
        if($Tipo==1){
            $Condicion.="Fecha>='$FechaInicial' AND Fecha <='$FechaFinal'";
            
        }else{
            $Condicion.="Fecha <='$FechaFinal'";
            
        }
        if($Empresa<>"ALL"){
            $CondicionEmpresa=" AND idEmpresa = '$Empresa'";
        }
        
        $CondicionCentroCostos="";
        if($CentroCostos<>"ALL"){
            $CondicionCentroCostos=" AND idCentroCosto = '$CentroCostos'";
        }
        
        
        
        
        $sql="CREATE VIEW vista_saldo_inicial_cuentapuc AS
            SELECT CuentaPUC as ID,Tercero_Identificacion,SUM(Debito-Credito) as SaldoInicial
            FROM `librodiario`
            $Condicion $CondicionEmpresa $CondicionCentroCostos
            GROUP BY CuentaPUC,Tercero_Identificacion";         
        $this->Query($sql);
        
        
        
        $sql="CREATE VIEW vista_balancextercero2 AS
            SELECT (SUBSTRING(CuentaPUC,1,8)) as ID,Fecha,`Tercero_Identificacion` as Identificacion,`Tercero_Razon_Social` AS Razon_Social,
            `CuentaPUC` , `NombreCuenta`,  
            (SELECT SaldoInicial FROM vista_saldo_inicial_cuentapuc WHERE librodiario.CuentaPUC=vista_saldo_inicial_cuentapuc.ID AND librodiario.Tercero_Identificacion=vista_saldo_inicial_cuentapuc.Tercero_Identificacion LIMIT 1) AS SaldoInicialSubCuenta, 
            
            SUBSTRING(CuentaPUC,1,1) AS Clase,
            (SELECT Clase FROM clasecuenta WHERE PUC=SUBSTRING(CuentaPUC,1,1)) AS NombreClase, 
            
            SUBSTRING(CuentaPUC,1,2) AS Grupo,
            (SELECT Nombre FROM gupocuentas WHERE PUC=SUBSTRING(CuentaPUC,1,2)) AS NombreGrupo,
            
            SUBSTRING(CuentaPUC,1,4) AS CuentaPadre,
            (SELECT Nombre FROM cuentas WHERE idPUC=SUBSTRING(CuentaPUC,1,4)) AS NombreCuentaPadre,
            
            `Debito`,`Credito`,
            idEmpresa,idCentroCosto
            FROM `librodiario`
            $Condicion $CondicionEmpresa $CondicionCentroCostos
            ORDER BY SUBSTRING(CuentaPUC,1,8),Identificacion,CuentaPUC,Fecha ASC";         
        $this->Query($sql);
        
        
        
    }
    /**
     * Constuye una vista con la informacion de las retenciones practicadas a un tercero
     * @param type $FechaInicial
     * @param type $FechaFinal
     * @param type $CmbTercero
     * @param type $Empresa
     * @param type $CentroCostos
     * @param type $CmbCiudadRetencion
     * @param type $CmbCiudadPago
     * @param type $Vector
     */
    public function ConstruirVistaRetencionesXTercero($FechaInicial, $FechaFinal,$CmbTercero, $Empresa, $CentroCostos,$CmbCiudadRetencion,$CmbCiudadPago, $Vector) {
        $sql="DROP VIEW IF EXISTS `vista_retenciones_tercero`;";
        $this->Query($sql);
        $CondicionEmpresa="";
        $Condicion=" WHERE Fecha>='$FechaInicial' AND Fecha <='$FechaFinal' AND Tercero='$CmbTercero' ";
        
        if($Empresa<>"ALL"){
            $CondicionEmpresa=" AND idEmpresa = '$Empresa'";
        }
        
        $CondicionCentroCostos="";
        if($CentroCostos<>"ALL"){
            $CondicionCentroCostos=" AND idCentroCosto = '$CentroCostos'";
        }
        $sql="CREATE VIEW vista_retenciones_tercero AS
            SELECT *
            FROM vista_retenciones $Condicion;";         
        $this->Query($sql);
    }
    /**
     * Construye la vista para el estado de resultados por año
     * @param type $FechaInicial
     * @param type $FechaFinal
     * @param type $CmbAnio
     * @param type $Empresa
     * @param type $CentroCostos
     * @param type $Vector
     */
     public function ConstruirVistaEstadoResultados($CmbAnio, $Empresa, $CentroCostos,$Vector) {
        $FechaInicial= $CmbAnio."-01-01";
        $FechaFinal = $CmbAnio."-12-31";
        $sql="DROP VIEW IF EXISTS `vista_estado_resultados_anio`;";
        $this->Query($sql);
        $CondicionEmpresa="";
        $Condicion=" WHERE Fecha>='$FechaInicial' AND Fecha <='$FechaFinal' ";
        
        if($Empresa<>"ALL"){
            $CondicionEmpresa=" AND idEmpresa = '$Empresa'";
        }
        
        $CondicionCentroCostos="";
        if($CentroCostos<>"ALL"){
            $CondicionCentroCostos=" AND idCentroCosto = '$CentroCostos'";
        }
        $sql="CREATE VIEW vista_estado_resultados_anio AS
            SELECT *
            FROM librodiario $Condicion;";         
        $this->Query($sql);
    }
    
    /**
     * Fin Clase
     */
}
