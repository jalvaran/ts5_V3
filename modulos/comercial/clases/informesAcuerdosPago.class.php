<?php

class informesAcuerdoPago extends AcuerdoPago{
    
    /**
     * Construye la hoja de trabajo que se utilizará para los informes
     */
    public function ConstruirHojaDeTrabajoAcuerdo($FechaFinal) {
        
        $HojaDeTrabajo="acuerdo_pago_hoja_trabajo_informes";
        $sql="DROP TABLE IF EXISTS $HojaDeTrabajo";
        $this->Query($sql);
            
        $sql="CREATE TABLE $HojaDeTrabajo AS
                SELECT t1.ID as ID,t2.ID as ConsecutivoAcuerdo,t1.idAcuerdoPago,t1.TipoCuota,t1.NumeroCuota,t1.Fecha,t1.ValorCuota,t1.ValorPagado,
                (t1.ValorCuota-t1.ValorPagado) as SaldoCuota,t1.idPago,
                t1.Estado as EstadoProyeccion,t2.Observaciones,'$FechaFinal' as FechaFinalConstruccion,";
        if($FechaFinal==''){
            $sql.="(SELECT SUM(t8.ValorCuota-t8.ValorPagado) FROM acuerdo_pago_proyeccion_pagos t8 WHERE t8.idAcuerdoPago=t1.idAcuerdoPago) as SaldoPendiente,";
        }else{
            $sql.="(SELECT SUM(t8.ValorCuota-t8.ValorPagado) FROM acuerdo_pago_proyeccion_pagos t8 WHERE t8.idAcuerdoPago=t1.idAcuerdoPago AND t8.Fecha<='$FechaFinal') as SaldoPendiente,";
        }
        
        $sql.="  (SELECT t3.NombreEstado FROM acuerdo_pago_proyeccion_estados t3 WHERE t3.ID=t1.Estado LIMIT 1) AS NombreEstadoProyeccion,
                (SELECT t6.NombreTipoCuota FROM acuerdo_pago_tipo_cuota t6 WHERE t6.ID=t1.TipoCuota LIMIT 1) AS NombreTipoCuota,
                t2.Tercero,
                (SELECT t4.RazonSocial FROM clientes t4 WHERE t4.Num_Identificacion=t2.Tercero LIMIT 1) AS RazonSocial,
                (SELECT t4.idClientes FROM clientes t4 WHERE t4.Num_Identificacion=t2.Tercero LIMIT 1) AS idClienteAcuerdo,
                (SELECT t4.Direccion FROM clientes t4 WHERE t4.Num_Identificacion=t2.Tercero LIMIT 1) AS DireccionCliente,
                (SELECT t4.Telefono FROM clientes t4 WHERE t4.Num_Identificacion=t2.Tercero LIMIT 1) AS TelefonoCliente,
                (SELECT t4.Puntaje FROM clientes t4 WHERE t4.Num_Identificacion=t2.Tercero LIMIT 1) AS PuntajeCliente,
                (SELECT t5.SobreNombre FROM clientes_datos_adicionales t5 WHERE t5.idCliente=(SELECT idClienteAcuerdo) LIMIT 1) AS SobreNombreCliente,
                t2.ValorCuotaGeneral,t2.CicloPagos,
                (SELECT t7.NombreCiclo FROM acuerdo_pago_ciclos_pagos t7 WHERE t7.ID=t2.CicloPagos LIMIT 1) AS NombreCicloPago,
                round(t2.SaldoAnterior) as SaldoAnterior,round(t2.SaldoInicial)  as SaldoInicial,t2.TotalAbonos,round(t2.SaldoFinal) as SaldoFinal,'0000-00-00 00:00:00' as Updated, '0000-00-00 00:00:00' as Sync 
                FROM acuerdo_pago_proyeccion_pagos t1 
                INNER JOIN acuerdo_pago t2 ON t1.idAcuerdoPago=t2.idAcuerdoPago 
                WHERE t2.Estado=1 AND (t1.Estado=0 OR t1.Estado=2 OR t1.Estado=4) ORDER BY Tercero,Fecha ";
        $this->Query($sql);
        
        $sql="ALTER TABLE $HojaDeTrabajo ADD PRIMARY KEY(`ID`),
                CHANGE `ID` `ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
                ADD INDEX(`ConsecutivoAcuerdo`),
                ADD INDEX(`idAcuerdoPago`),
                ADD INDEX(`TipoCuota`),
                ADD INDEX(`NumeroCuota`),
                ADD INDEX(`EstadoProyeccion`),
                ADD INDEX(`Tercero`),
                ADD INDEX(`CicloPagos`),                   
                ADD INDEX(`TelefonoCliente`),
                ENGINE = MyISAM;                     

                ";
        $this->Query($sql);
    }
    
    public function CrearVistaAbonosAcuerdoPago() {
        $sql="DROP VIEW IF EXISTS `vista_abonos_acuerdo_pago`;";
        $this->Query($sql);
        
        $sql="CREATE VIEW vista_abonos_acuerdo_pago AS
            SELECT t1.ID,t2.Tercero,
                (SELECT RazonSocial FROM clientes t4 WHERE t4.Num_Identificacion=t2.Tercero) as RazonSocialCliente,
                t1.NumeroCuota,t1.TipoCuota,
                (SELECT t3.NombreTipoCuota FROM acuerdo_pago_tipo_cuota t3 WHERE t3.ID=t1.TipoCuota LIMIT 1 ) AS NombreTipoCuota,
                t1.idAcuerdoPago,t2.ID as ConsecutivoAcuerdo,
                (SELECT t6.Fecha FROM acuerdo_pago_proyeccion_pagos t6 WHERE t6.ID=t1.idProyeccion LIMIT 1 ) AS FechaCuota,
                t1.FechaPago AS Fecha,t1.ValorPago,t1.MetodoPago,
                (SELECT t5.Metodo FROM metodos_pago t5 WHERE t5.ID=t1.MetodoPago) as NombreMetodoPago,
                t1.idUser,
                (SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t4 WHERE t4.idUsuarios=t1.idUser ) as NombreUsuario,
                t1.Created

            FROM acuerdo_pago_cuotas_pagadas t1 
            INNER JOIN acuerdo_pago t2 ON t1.idAcuerdoPago=t2.idAcuerdoPago 
             ORDER BY t2.Tercero,t1.Created DESC;";
        $this->Query($sql);
        
    }
    
    /**
     * Fin Clase
     */
}
