<?php
/* 
 * Clase para imprimir en una impresora termica para los acuerdos de pago
 * Julian Alvaran
 * Techno Soluciones SAS
 */
include_once "../../../modelo/PrintPos.php";
class AcuerdoPagoPrint extends PrintPos{
    
    
    function PrintAcuerdoPago($idAcuerdo,$Copias,$AbreCajon){
        
        
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('E1;La Impresora está ocupada o desconectada');
        }
        
        $sql="SELECT t1.*, 
                (SELECT CONCAT(RazonSocial) FROM clientes t2 WHERE t2.Num_Identificacion=t1.Tercero LIMIT 1) AS NombreCliente, 
                (SELECT t3.NombreCiclo FROM acuerdo_pago_ciclos_pagos t3 WHERE t3.ID=t1.CicloPagos) AS NombreCicloPago,
                (SELECT t4.NombreEstado FROM acuerdo_pago_estados t4 WHERE t4.ID=t1.Estado) AS NombreEstado
                
                FROM acuerdo_pago t1 WHERE idAcuerdoPago='$idAcuerdo'";
        
        $DatosAcuerdo= $this->FetchAssoc($this->Query($sql));
        
        $Titulo="ACUERDO DE PAGO ".$DatosAcuerdo["ID"];
        $NombreCliente=$DatosAcuerdo["NombreCliente"];
        
        $AnchoSeparador=36;
        
        for($i=1; $i<=$Copias;$i++){
            
            fwrite($handle,chr(27). chr(64));//REINICIO
            if($AbreCajon==1){
                fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
            }

            fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
            fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
            fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
            $this->SeparadorHorizontal($handle, "*", $AnchoSeparador);
            fwrite($handle,$Titulo); // ESCRIBO RAZON SOCIAL
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,$NombreCliente." ".$DatosAcuerdo["Tercero"]); // ESCRIBO RAZON SOCIAL
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            
            fwrite($handle,"CICLO DE PAGOS: ".$DatosAcuerdo["NombreCicloPago"]); // ciclo de pagos
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,"ESTADO: ".$DatosAcuerdo["NombreEstado"]); // ciclo de pagos
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            
            $this->SeparadorHorizontal($handle, "*", $AnchoSeparador);
            
            fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
            fwrite($handle,"INFORMACION GENERAL: "); // ciclo de pagos
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,"VALOR GENERAL DE LA CUOTA: $". number_format($DatosAcuerdo["ValorCuotaGeneral"])); 
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            
            fwrite($handle,"SALDO ANTERIOR: $". number_format($DatosAcuerdo["SaldoAnterior"])); 
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            
            fwrite($handle,"SALDO INICIAL: $". number_format($DatosAcuerdo["SaldoInicial"])); 
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,"TOTAL ABONOS: $". number_format($DatosAcuerdo["TotalAbonos"])); 
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,"SALDO FINAL: $". number_format($DatosAcuerdo["SaldoFinal"])); 
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA            
            fwrite($handle,"OBSERVACIONES: ". ($DatosAcuerdo["Observaciones"])); 
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            
            $this->SeparadorHorizontal($handle, "*", $AnchoSeparador);
            fwrite($handle,"RELACION DE PAGOS: "); // ciclo de pagos
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,"CUOTA INICIAL: "); // ciclo de pagos
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            $sql="SELECT t1.*,(SELECT t2.Metodo FROM metodos_pago t2 WHERE t2.ID=t1.MetodoPago) AS NombreFormaPago,
                    (SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t3 WHERE t3.idUsuarios=t1.idUser) AS NombreUsuario
                     FROM acuerdo_pago_cuotas_pagadas t1 WHERE t1.idAcuerdoPago='$idAcuerdo' AND t1.TipoCuota=0 ORDER BY t1.Created ASC";
            $Consulta= $this->Query($sql);
            while($DatosPagos= $this->FetchAssoc($Consulta)){
                fwrite($handle,"FECHA: ".$DatosPagos["Created"]);
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
                fwrite($handle,$DatosPagos["NombreFormaPago"]." || Valor: $". number_format($DatosPagos["ValorPago"])); // ciclo de pagos
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
                fwrite($handle,"RECIBIDO POR: ".$DatosPagos["NombreUsuario"]); // ciclo de pagos
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }
            
            fwrite($handle,"PAGO DE CUOTAS: "); // ciclo de pagos
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            $sql="SELECT t1.*,(SELECT t2.Metodo FROM metodos_pago t2 WHERE t2.ID=t1.MetodoPago) AS NombreFormaPago,
                    (SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t3 WHERE t3.idUsuarios=t1.idUser) AS NombreUsuario
                     FROM acuerdo_pago_cuotas_pagadas t1 WHERE t1.idAcuerdoPago='$idAcuerdo' AND t1.TipoCuota>0 ORDER BY t1.Created ASC";
            $Consulta= $this->Query($sql);
            while($DatosPagos= $this->FetchAssoc($Consulta)){
                fwrite($handle,"FECHA: ".$DatosPagos["Created"]);
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
                fwrite($handle,$DatosPagos["NombreFormaPago"]." || Valor: $". number_format($DatosPagos["ValorPago"])); // ciclo de pagos
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
                fwrite($handle,"RECIBIDO POR: ".$DatosPagos["NombreUsuario"]); // ciclo de pagos
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }
            
            
            fwrite($handle,"PAGOS AGRUPADOS POR FECHA: "); // ciclo de pagos
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            $sql="SELECT t1.Fecha,sum(ValorPagado) as TotalPago
                     FROM acuerdo_pago_cuotas_pagadas t1 WHERE t1.idAcuerdoPago='$idAcuerdo' AND t1.TipoCuota>0 GROUP BY t1.Fecha ORDER BY t1.Fecha ASC";
            $Consulta= $this->Query($sql);
            while($DatosPagos= $this->FetchAssoc($Consulta)){
                fwrite($handle,"FECHA: ".$DatosPagos["Fecha"]);                
                fwrite($handle," || Valor: $". number_format($DatosPagos["TotalPago"])); // ciclo de pagos                
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }
            
            
            $this->SeparadorHorizontal($handle, "*", $AnchoSeparador);
            fwrite($handle,"PROYECCION DE PAGOS: "); // ciclo de pagos
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            $sql="SELECT t1.*,(SELECT t2.NombreEstado FROM acuerdo_pago_proyeccion_estados t2 WHERE t2.ID=t1.Estado) as NombreEstado,
                              (SELECT t3.NombreTipoCuota FROM acuerdo_pago_tipo_cuota t3 WHERE t3.ID=t1.TipoCuota) as NombreTipoCuota
                
                    FROM acuerdo_pago_proyeccion_pagos t1 WHERE idAcuerdoPago='$idAcuerdo' ORDER BY t1.Fecha";
            $Consulta= $this->Query($sql);
            $TotalCuotasVencidas=0;
            while($DatosProyeccion= $this->FetchAssoc($Consulta)){
                $SaldoCuota=$DatosProyeccion["ValorCuota"]-$DatosPagos["ValorPagado"];
                if($DatosProyeccion["Estado"]==4){
                    $TotalCuotasVencidas=$TotalCuotasVencidas+$SaldoCuota;
                }
                fwrite($handle,$DatosProyeccion["NombreTipoCuota"]." || ".$DatosProyeccion["Fecha"]." || ". number_format($SaldoCuota)." || ".$DatosProyeccion["NombreEstado"]); 
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }
            
            if($TotalCuotasVencidas>1){
                fwrite($handle,"TOTAL DE CUOTAS VENCIDAS: ".number_format($TotalCuotasVencidas)); // ciclo de pagos
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }
            
            $this->Footer($handle);
            
            
        }
        
        fclose($handle); // cierra el fichero PRN
        $salida = shell_exec('lpr $COMPrinter');
        
    }
    
    //Fin Clases
}