<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class AcuerdoPago extends ProcesoVenta{
   
   
     /**
      * Obtiene un id unico para uso general
      * @param type $prefijo
      */
     public function getId($prefijo) {
         return (str_replace(".","",uniqid($prefijo, true)));
     }
     
     /**
      * Esta funcion permite registrar un pago a un acuerdo de pago temporal
      * @param type $NumeroCuota
      * @param type $TipoCuota
      * @param type $idAcuerdoPago
      * @param type $ValorPago
      * @param type $MetodoPago
      * @param type $idUser
      */
     public function PagoAcuerdoPagosTemporal($NumeroCuota,$TipoCuota,$idAcuerdoPago,$ValorPago,$MetodoPago,$idUser) {
         $Datos["NumeroCuota"]=$NumeroCuota;
         $Datos["TipoCuota"]=$TipoCuota;
         $Datos["idAcuerdoPago"]=$idAcuerdoPago;
         $Datos["FechaPago"]=date("Y-m-d");
         $Datos["ValorPago"]=$ValorPago;
         $Datos["MetodoPago"]=$MetodoPago;
         $Datos["idUser"]=$idUser;
         $Datos["Created"]=date("Y-m-d H:i:s");
         $sql=$this->getSQLInsert("acuerdo_pago_cuotas_pagadas_temp", $Datos);
         $this->Query($sql);         
     }
     
     /**
      * Esta funcion permite registrar un pago a un acuerdo de pago temporal
      * @param type $NumeroCuota
      * @param type $TipoCuota
      * @param type $idAcuerdoPago
      * @param type $ValorPago
      * @param type $MetodoPago
      * @param type $idUser
      */
     public function PagoAcuerdoPagos($idProyeccion,$NumeroCuota,$TipoCuota,$idAcuerdoPago,$ValorPago,$MetodoPago,$idUser) {
         $Datos["NumeroCuota"]=$NumeroCuota;
         $Datos["TipoCuota"]=$TipoCuota;
         $Datos["idProyeccion"]=$idProyeccion;
         $Datos["idAcuerdoPago"]=$idAcuerdoPago;
         $Datos["FechaPago"]=date("Y-m-d");
         $Datos["ValorPago"]=$ValorPago;
         $Datos["MetodoPago"]=$MetodoPago;
         $Datos["idUser"]=$idUser;
         $Datos["Created"]=date("Y-m-d H:i:s");
         $sql=$this->getSQLInsert("acuerdo_pago_cuotas_pagadas", $Datos);
         $this->Query($sql);   
         $ID=$this->ObtenerMAX("acuerdo_pago_cuotas_pagadas", "ID", "idAcuerdoPago", $idAcuerdoPago);
         return($ID);
     }
     /**
      * Agrega una cuota a la proyeccion de pagos temporal
      * @param type $Fecha
      * @param type $NumeroCuota
      * @param type $TipoCuota
      * @param type $idAcuerdoPago
      * @param type $ValorCuota
      * @param type $idUser
      */
     public function CuotaAcuerdoPagosTemporal($Fecha,$NumeroCuota,$TipoCuota,$idAcuerdoPago,$ValorCuota,$idUser) {
         $Datos["idAcuerdoPago"]=$idAcuerdoPago;
         $Datos["TipoCuota"]=$TipoCuota;
         $Datos["NumeroCuota"]=$NumeroCuota;
         $Datos["Fecha"]=$Fecha;
         $Datos["ValorCuota"]=$ValorCuota;        
         $Datos["idUser"]=$idUser;
         $Datos["Created"]=date("Y-m-d H:i:s");
         $sql=$this->getSQLInsert("acuerdo_pago_proyeccion_pagos_temp", $Datos);
         $this->Query($sql);         
     }
     
     /**
      * Agrega una cuota a la proyeccion de pagos 
      * @param type $Fecha
      * @param type $NumeroCuota
      * @param type $TipoCuota
      * @param type $idAcuerdoPago
      * @param type $ValorCuota
      * @param type $idUser
      */
     public function CuotaAcuerdoPagos($Fecha,$NumeroCuota,$TipoCuota,$idAcuerdoPago,$ValorCuota,$idUser) {
         $Datos["idAcuerdoPago"]=$idAcuerdoPago;
         $Datos["TipoCuota"]=$TipoCuota;
         $Datos["NumeroCuota"]=$NumeroCuota;
         $Datos["Fecha"]=$Fecha;
         $Datos["ValorCuota"]=$ValorCuota;        
         $Datos["idUser"]=$idUser;
         $Datos["Created"]=date("Y-m-d H:i:s");
         $sql=$this->getSQLInsert("acuerdo_pago_proyeccion_pagos", $Datos);
         $this->Query($sql);         
     }
     
     public function ConstruyaProyeccionPagos($idAcuerdoPago,$ValorAProyectar,$ValorCuotaAcuerdo,$cicloPagos,$FechaInicial,$idUser) {
        $NumeroCuotasCalculadas=ceil($ValorAProyectar/$ValorCuotaAcuerdo);
        $DatosCicloPago=$this->DevuelveValores("acuerdo_pago_ciclos_pagos", "ID", $cicloPagos);
        $NumeroDiasCiclo=$DatosCicloPago["NumeroDias"];
                        
        $SumaCuotasIguales=$ValorCuotaAcuerdo*($NumeroCuotasCalculadas-1);
        $ValorUltimaCuota=$ValorAProyectar-$SumaCuotasIguales;
        $DatosProyeccion["CuotasCalculadas"]=$NumeroCuotasCalculadas;
        
        $DatosProyeccion["ValorUltimaCuota"]=$ValorUltimaCuota;
        
        $DatosProyeccion["FechaCuotas"][1]=$FechaInicial;
        $DatosProyeccion["ValorCuota"][1]=$ValorCuotaAcuerdo;
        $DatosProyeccion["NombreDia"][1]=$this->obtenerNombreDiaFecha($FechaInicial);
        $DatosProyeccion["FechaFinal"]=$FechaInicial;
        //$this->CuotaAcuerdoPagosTemporal($FechaInicial, 1, 2, $idAcuerdoPago, $ValorCuotaAcuerdo, $idUser);
        for($i=2;$i<=$NumeroCuotasCalculadas;$i++){
            if($cicloPagos==1){ //Si el ciclo es Semanal
                $DatosProyeccion["FechaCuotas"][$i]=$this->SumeSemanasAFecha($FechaInicial, $i-1);
            }
            if($cicloPagos==2){ //Si el ciclo es Quincenal
                $DatosProyeccion["FechaCuotas"][$i]=$this->SumeDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i-1], 15);
                $DiaActual=date("d", strtotime($DatosProyeccion["FechaCuotas"][$i-1]));
                $CantidadDias= $this->obtenerCantidadDiasMes($DatosProyeccion["FechaCuotas"][$i-1]);
                $MesActual=date("m", strtotime($DatosProyeccion["FechaCuotas"][$i]));
                $DiaMesActual=date("d", strtotime($DatosProyeccion["FechaCuotas"][$i]));
                    if($DiaActual>15 and $CantidadDias==31){                        
                        $DatosProyeccion["FechaCuotas"][$i]= $this->SumeDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i], 1);
                        
                    }
                    if($DiaActual<=15 and $CantidadDias==28){
                        
                       $DatosProyeccion["FechaCuotas"][$i]= $this->ResteDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i], 2);
                      
                       
                    }
                    if($DiaActual<=15 and $CantidadDias==29){
                        $DatosProyeccion["FechaCuotas"][$i]= $this->ResteDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i], 1);
                    }
                   
                if($MesActual=='03' AND $DiaMesActual>15 and $DiaMesActual<29){
                    if(isset($DatosProyeccion["FechaCuotas"][$i-2])){
                        $CantidadDias= $this->obtenerCantidadDiasMes($DatosProyeccion["FechaCuotas"][$i-2]);
                   
                        if($CantidadDias==28){
                            $DatosProyeccion["FechaCuotas"][$i-2]= $this->SumeDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i-2], 2);

                        }
                        if($CantidadDias==29){
                            $DatosProyeccion["FechaCuotas"][$i-2]= $this->SumeDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i-2], 1);

                        }
                     
                    }
                }                        
                   
            }
            if($cicloPagos==3){ //Si el ciclo es Mensual
                $DatosProyeccion["FechaCuotas"][$i]=$this->SumeMesesAFecha($FechaInicial, ($i-1));
                $DiaMes=date("m-d", strtotime($DatosProyeccion["FechaCuotas"][$i-1]));
                if($DiaMes=="01-30"){
                    $FechaTemporal= $this->SumeDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i-1], 5);
                    $CantidadDias= $this->obtenerCantidadDiasMes($FechaTemporal);
                    if($CantidadDias==28){
                        $DatosProyeccion["FechaCuotas"][$i]= $this->ResteDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i], 2);
                    }
                    if($CantidadDias==29){
                        $DatosProyeccion["FechaCuotas"][$i]= $this->ResteDiasAFechaAcuerdo($DatosProyeccion["FechaCuotas"][$i], 1);
                    }
                }
            }
            $DatosProyeccion["ValorCuota"][$i]=$ValorCuotaAcuerdo;
            if($i==$NumeroCuotasCalculadas){
                $DatosProyeccion["ValorCuota"][$i]=$ValorUltimaCuota;
            }
            $DatosProyeccion["FechaFinal"]=$DatosProyeccion["FechaCuotas"][$i];
            $DatosProyeccion["NombreDia"][$i]=$this->obtenerNombreDiaFecha($DatosProyeccion["FechaCuotas"][$i]);
            
            
        }
          
        foreach ($DatosProyeccion["FechaCuotas"] as $key => $value) {
            $this->CuotaAcuerdoPagosTemporal($value, $key, 2, $idAcuerdoPago, $DatosProyeccion["ValorCuota"][$key], $idUser);
            
        }  
        return($DatosProyeccion);
     }
     
     public function obtenerCantidadDiasMes($Fecha) {
         $numeroDias=date("t", strtotime($Fecha));
         return($numeroDias);
     }
     
     public function obtenerNombreDiaFecha($Fecha) {
        $NombreDia=array("","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"); 
        $fechaComoEntero = strtotime($Fecha);
        $dia = date("N", $fechaComoEntero); 
        $DiaSemana=$NombreDia[$dia];
        return($DiaSemana);
        
     }
     public function SumeDiasAFechaAcuerdo($Fecha,$NumeroDias) {         
        $nuevafecha = date('Y-m-d', strtotime($Fecha) + 86400);        
        $nuevafecha = date('Y-m-d', strtotime("$Fecha + $NumeroDias day"));
        
        return($nuevafecha);
     }
     
     public function ResteDiasAFechaAcuerdo($Fecha,$NumeroDias) {         
        $nuevafecha = date('Y-m-d', strtotime($Fecha) + 86400);        
        $nuevafecha = date('Y-m-d', strtotime("$Fecha - $NumeroDias day"));
        
        return($nuevafecha);
     }
       
     public function SumeSemanasAFecha($Fecha,$NumeroSemanas) {         
        $nuevafecha = date('Y-m-d', strtotime($Fecha) + 86400);        
        $nuevafecha = date('Y-m-d', strtotime("$Fecha + $NumeroSemanas week"));
        
        return($nuevafecha);
     }
     
     public function SumeMesesAFecha($Fecha,$NumeroMeses) {         
        $nuevafecha = date('Y-m-d', strtotime($Fecha) + 86400);
        $nuevafecha = date('Y-m-d', strtotime("$Fecha + $NumeroMeses month"));
        return($nuevafecha);
     }
     
     public function CrearFotoDesdeBase64($Base64,$idAcuerdo) {
        //print($Base64);
        $DatosRuta=$this->DevuelveValores("configuracion_general", "ID", 29); //Contiene la ruta donde se crea la foto para el acuerdo de pago
        $Ruta=$DatosRuta["Valor"];
        $NombreArchivo= $Ruta.$idAcuerdo.".png";
        $png_decoded = base64_decode($Base64);
        
        $png = fopen ($NombreArchivo,'w');
        fwrite ($png,$png_decoded);
        fclose ($png);
        return($NombreArchivo);
    }
    
    public function GuardarFotoSubida($NombreArchivo,$DirectorioTemporal,$idAcuerdo) {
        //print($Base64);
        $info = new SplFileInfo($NombreArchivo);
        $Extension=$info->getExtension();
       
        if($Extension<>'png' and $Extension<>'jpg' and $Extension<>'jpeg' and $Extension<>'bmp'){
            exit("E1;El archivo no es valido, debe ser una imagen");
        }
        $DatosRuta=$this->DevuelveValores("configuracion_general", "ID", 29); //Contiene la ruta donde se crea la foto para el acuerdo de pago
        $Ruta=$DatosRuta["Valor"];
        $NombreArchivo= $Ruta.$idAcuerdo.".png";
        move_uploaded_file($DirectorioTemporal,$NombreArchivo);
        return($NombreArchivo);
    }
     
    public function ValidarDatosCreacionAcuerdoPagoPOS($VariablesAcuerdo) {
        $idCliente= $this->normalizar($VariablesAcuerdo["idCliente"]);
        $idPreventa= $this->normalizar($VariablesAcuerdo["idPreventa"]);
        if($VariablesAcuerdo["idAcuerdoPago"]==''){
            exit("E4;No se recibió un id para el acuerdo de pago");            
        }
        if(!isset($VariablesAcuerdo["SaldoActualAcuerdoPago"])){
            exit("E4;No se recibió el saldo actual del cliente");            
        }
        if($VariablesAcuerdo["NuevoSaldoAcuerdoPago"]==''){
            exit("E4;No se recibió un el nuevo saldo del cliente");            
        }
        if($VariablesAcuerdo["TxtObservacionesAcuerdoPago"]==''){
            exit("E4;Debe escribir las observaciones del acuerdo de pago");            
        }
        $idAcuerdo= $this->normalizar($VariablesAcuerdo["idAcuerdoPago"]);
        if($VariablesAcuerdo["TxtFechaInicialPagos"]==''){
            exit("E4;No se recibió la fecha inicial de pagos para el acuerdo;TxtFechaInicialPagos");            
        }
        if(!is_numeric($VariablesAcuerdo["ValorCuotaAcuerdo"]) AND $VariablesAcuerdo["ValorCuotaAcuerdo"]<=0){
            exit("E4;El valor de la cuota del acuerdo debe ser un numero mayor a cero;ValorCuotaAcuerdo");            
        }
        if($VariablesAcuerdo["cicloPagos"]==''){
            exit("E4;Debe seleccionar el ciclo de pagos;cicloPagos");            
        }
        $sql="SELECT ID FROM acuerdo_pago_cuotas_pagadas_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=0 LIMIT 1";
        $DatosAcuerdo= $this->FetchAssoc($this->Query($sql));
        if($DatosAcuerdo["ID"]==""){
            exit("E4;Debe agregar una cuota inicial");
        }
        $sql="SELECT ID FROM acuerdo_pago_proyeccion_pagos_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=2 LIMIT 1";
        $DatosAcuerdo= $this->FetchAssoc($this->Query($sql));
        if($DatosAcuerdo["ID"]==""){
            exit("E4;No se ha realizado la proyeccion de pagos");
        }
        $Parametro=$this->DevuelveValores("configuracion_general", "ID", 32); //parametro para saber si es obligatorio pedir la foto
        $ValidarFoto=$Parametro["Valor"];
        if($ValidarFoto==1){
            $DatosRuta=$this->DevuelveValores("configuracion_general", "ID", 29); //Contiene la ruta donde se crea la foto para el acuerdo de pago
            $Ruta=$DatosRuta["Valor"];
            $NombreArchivo= $Ruta.$idAcuerdo.".png";
            if(!file_exists($NombreArchivo)){
                exit("E4;No se ha tomado la foto para evidencia del acuerdo de pago");
            }
        }
        $Parametro=$this->DevuelveValores("configuracion_general", "ID", 33); //parametro para saber si se validan los datos adicionales del cliente
        $ValidarDatosAdicionales=$Parametro["Valor"];
        if($ValidarDatosAdicionales==1){
            $sql="SELECT ID FROM clientes_datos_adicionales WHERE idCliente='$idCliente' LIMIT 1";
            $Validacion= $this->FetchAssoc($this->Query($sql));
            if($Validacion["ID"]==''){
                exit("E4;Debe Agregar los datos adicionales del cliente");
            }
        }
        $Parametro=$this->DevuelveValores("configuracion_general", "ID", 34); //parametro para saber si se validan los recomendados del cliente
        $ValidarDatosAdicionales=$Parametro["Valor"];
        if($ValidarDatosAdicionales==1){
            $sql="SELECT ID FROM clientes_recomendados WHERE idCliente='$idCliente' LIMIT 1";
            $Validacion= $this->FetchAssoc($this->Query($sql));
            if($Validacion["ID"]==''){
                exit("E4;Debe al menos un recomendado del cliente");
            }
        }
        
        $sql="SELECT SUM(TotalVenta) AS Total FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ";
        $Totales=$this->FetchAssoc($this->Query($sql));
        $TotalPreventa=$Totales["Total"];
        $ValorAProyectar=$this->ValorAProyectarTemporalAcuerdo($idAcuerdo, $TotalPreventa, $idCliente);
        $TotalCuotasAcuerdo=$this->TotalCuotasTemporalAcuerdoPago($idAcuerdo);
        $DiferenciaEnValores=$ValorAProyectar-$TotalCuotasAcuerdo;
        
        if(ABS($DiferenciaEnValores)>1){
            exit("E4;La sumatoria de las cuotas no es igual al Valor a Proyectar");
        }
    }
    
    public function CrearAcuerdoPago($idAcuerdoPago,$FechaInicialParaPagos,$Tercero,$ValorCuotaGeneral,$CicloPagos,$Observaciones,$SaldoAnterior,$TotalAbonos,$SaldoInicial,$SaldoFinal,$Estado,$idUser) {
        $Datos["idAcuerdoPago"]=$idAcuerdoPago;
        $Datos["Fecha"]=date("Y-m-d");
        $Datos["FechaInicialParaPagos"]=$FechaInicialParaPagos;
        $Datos["Tercero"]=$Tercero;
        $Datos["ValorCuotaGeneral"]=$ValorCuotaGeneral;
        $Datos["CicloPagos"]=$CicloPagos;        
        $Datos["Observaciones"]=$Observaciones;
        $Datos["SaldoAnterior"]=$SaldoAnterior;
        $Datos["SaldoInicial"]=$SaldoInicial;
        $Datos["TotalAbonos"]=$TotalAbonos;
        $Datos["SaldoFinal"]=$SaldoFinal;
        $Datos["Estado"]=$Estado;
        $Datos["idUser"]=$idUser;
        $Datos["Created"]=date("Y-m-d H:i:s");
        $sql= $this->getSQLInsert("acuerdo_pago", $Datos);
        $this->Query($sql);
        
    }
    
    public function CopiarProyeccionCuotasDesdeTemporal($idAcuerdo) {
        $sql="INSERT INTO acuerdo_pago_proyeccion_pagos (idAcuerdoPago,TipoCuota,NumeroCuota,Fecha,ValorCuota,Estado,idUser,Created)
              SELECT   idAcuerdoPago,TipoCuota,NumeroCuota,Fecha,ValorCuota,Estado,idUser,Created FROM  acuerdo_pago_proyeccion_pagos_temp 
              WHERE acuerdo_pago_proyeccion_pagos_temp.idAcuerdoPago='$idAcuerdo' ";
        $this->Query($sql);
    }
    
    public function CopiarCuotasPagadasDesdeTemporal($idAcuerdo) {
        $sql="INSERT INTO acuerdo_pago_cuotas_pagadas (idAcuerdoPago,TipoCuota,NumeroCuota,FechaPago,ValorPago,MetodoPago,idUser,idCierre,Created)
              SELECT   idAcuerdoPago,TipoCuota,NumeroCuota,FechaPago,ValorPago,MetodoPago,idUser,idCierre,Created 
              FROM  acuerdo_pago_cuotas_pagadas_temp 
              WHERE acuerdo_pago_cuotas_pagadas_temp.idAcuerdoPago='$idAcuerdo' ";
        $this->Query($sql);
    }
    public function CrearAcuerdoPagoDesdePOS($idAcuerdoPago, $FechaInicialParaPagos, $Tercero,$ValorCuotaGeneral, $CicloPagos, $Observaciones,$SaldoAnterior,$TotalAbonos, $SaldoInicial, $SaldoFinal, $Estado, $idUser) {
        
        $this->CrearAcuerdoPago($idAcuerdoPago, $FechaInicialParaPagos, $Tercero,$ValorCuotaGeneral, $CicloPagos, $Observaciones,$SaldoAnterior,$TotalAbonos, $SaldoInicial, $SaldoFinal, $Estado, $idUser);
        $this->CopiarCuotasPagadasDesdeTemporal($idAcuerdoPago);
        $this->CopiarProyeccionCuotasDesdeTemporal($idAcuerdoPago);
        $this->BorraReg("acuerdo_pago_cuotas_pagadas_temp", 'idAcuerdoPago', $idAcuerdoPago);
        $this->BorraReg("acuerdo_pago_proyeccion_pagos_temp", 'idAcuerdoPago', $idAcuerdoPago);
        $sql="UPDATE acuerdo_pago SET Estado=10 WHERE Tercero='$Tercero' AND idAcuerdoPago<>'$idAcuerdoPago'";
        $this->Query($sql);
        
    }
    
    public function SaldoActualCliente($Tercero) {
        $sql="SELECT SUM(Debito - Credito) as Total FROM librodiario t2 WHERE t2.Tercero_Identificacion='$Tercero' 
        AND EXISTS(SELECT 1 FROM contabilidad_parametros_cuentasxcobrar t3 WHERE t2.CuentaPUC like t3.CuentaPUC) ";

        $Totales=$this->FetchAssoc($this->Query($sql));
        $SaldoActualCliente=$Totales["Total"];
        return($SaldoActualCliente);
    }
    
    public function TotalCuotaInicialTemporalAcuerdoPago($idAcuerdo) {
        $sql="SELECT SUM(ValorPago) AS Total FROM acuerdo_pago_cuotas_pagadas_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=0";
        $DatosCuotas= $this->FetchAssoc($this->Query($sql));
        return($DatosCuotas["Total"]);
        
    }
    
    public function TotalCuotasProgramadasTemporalAcuerdoPago($idAcuerdo) {
        $sql="SELECT SUM(ValorCuota) AS Total FROM acuerdo_pago_proyeccion_pagos_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=1";
        $DatosCuotas= $this->FetchAssoc($this->Query($sql));
        return($DatosCuotas["Total"]);        
    }
    
    public function TotalCuotasTemporalAcuerdoPago($idAcuerdo) {
        $sql="SELECT SUM(ValorCuota) AS Total FROM acuerdo_pago_proyeccion_pagos_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=2";
        $DatosCuotas= $this->FetchAssoc($this->Query($sql));
        return($DatosCuotas["Total"]);        
    }
    
    public function ValorAProyectarTemporalAcuerdo($idAcuerdo,$ValorAdicional,$idCliente) {
        $DatosCliente= $this->DevuelveValores("clientes", "idClientes", $idCliente);
        $NIT= $DatosCliente["Num_Identificacion"];
        $SaldoActual=$this->SaldoActualCliente($NIT);
        $SaldoActual=$SaldoActual+$ValorAdicional;
        $CuotaInicial=$this->TotalCuotaInicialTemporalAcuerdoPago($idAcuerdo);
        $CuotasProgramadas=$this->TotalCuotasProgramadasTemporalAcuerdoPago($idAcuerdo);
        $ValorAProyectar=$SaldoActual-$CuotaInicial-$CuotasProgramadas;
        return($ValorAProyectar);
    }
    
    
    function AbonarAcuerdoPago($idAcuerdo,$MetodoPago,$ValorAbono,$idUser) {
        $DatosAcuerdo=$this->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
        $Saldo=round($DatosAcuerdo["SaldoFinal"]);
        
        if($ValorAbono>$Saldo){
            exit("E1;El valor del Abono supera el saldo del Cliente");
        }
        $DatosGenerales= $this->DevuelveValores("configuracion_general", "ID", 30);//Verifico cuantos dias de plazo tiene un cliente para pagar
        $DiasPlazo=$DatosGenerales["Valor"];
        $sql="SELECT * FROM acuerdo_pago_proyeccion_pagos WHERE idAcuerdoPago='$idAcuerdo' AND (Estado=0 or Estado=2 or Estado=4) ORDER BY Fecha ASC";
        $Consulta= $this->Query($sql);
        $ContadorPago=$ValorAbono;
        
        while($DatosProyeccion= $this->FetchAssoc($Consulta)){
            
            $idProyeccion=$DatosProyeccion["ID"];
            $SaldoAPagarCuota=$DatosProyeccion["ValorCuota"]-$DatosProyeccion["ValorPagado"];
            if($ContadorPago<=0){
                break;
            }
            if($ContadorPago>=$SaldoAPagarCuota){//en el caso que se pague por completo la cuota
                
                $ValorPago=$SaldoAPagarCuota;
                $ContadorPago=$ContadorPago-$SaldoAPagarCuota;
                $idPago=$this->PagoAcuerdoPagos($idProyeccion,$DatosProyeccion["NumeroCuota"], $DatosProyeccion["TipoCuota"], $idAcuerdo, $ValorPago, $MetodoPago, $idUser);
                $FechaVencimiento=$this->SumeDiasAFechaAcuerdo($DatosProyeccion["Fecha"], $DiasPlazo);
                $FechaActual=date("Y-m-d");
                $Estado=1;
                if($FechaActual>$FechaVencimiento){
                    $Estado=3; // se marca como pago extemporaneo
                }
                $sql="UPDATE acuerdo_pago_proyeccion_pagos SET Estado='$Estado',ValorPagado=ValorCuota,idPago='$idPago' WHERE ID='$idProyeccion'";
                $this->Query($sql);
                //print($sql);
            }elseif($ContadorPago<$SaldoAPagarCuota) {
                
                $ValorPago=$ContadorPago;
                
                $ContadorPago=0;
                $idPago=0;
                $idPago=$this->PagoAcuerdoPagos($idProyeccion,$DatosProyeccion["NumeroCuota"], $DatosProyeccion["TipoCuota"], $idAcuerdo, $ValorPago, $MetodoPago, $idUser);
                //$FechaVencimiento=$this->SumeDiasAFechaAcuerdo($DatosProyeccion["Fecha"], $DiasPlazo);
                //$FechaActual=date("Y-m-d");
                $Estado=2;
                
                $sql="UPDATE acuerdo_pago_proyeccion_pagos SET Estado='$Estado',ValorPagado=(ValorPagado+$ValorPago),idPago='$idPago' WHERE ID='$idProyeccion'";
                
                $this->Query($sql);
                //exit("E1;$sql");
                break;
            }
            
            
            
            
        }
        
        

        
    }
    
    public function ActualiceEstadosProyeccionPagos($idAcuerdo) {
        $DatosGenerales= $this->DevuelveValores("configuracion_general", "ID", 30);//Verifico cuantos dias de plazo tiene un cliente para pagar
        $DiasPlazo=$DatosGenerales["Valor"];
        $sql="SELECT * FROM acuerdo_pago_proyeccion_pagos WHERE idAcuerdoPago='$idAcuerdo' AND Estado=0";
        $Consulta= $this->Query($sql);
        while($DatosProyeccion= $this->FetchAssoc($Consulta)){
            $idProyeccion=$DatosProyeccion["ID"];
            $FechaVencimiento=$this->SumeDiasAFechaAcuerdo($DatosProyeccion["Fecha"], $DiasPlazo);
            $FechaActual=date("Y-m-d");
            if($FechaActual>$FechaVencimiento){
                $Estado=4; // se marca como cuota vencida
                $sql="UPDATE acuerdo_pago_proyeccion_pagos SET Estado='$Estado' WHERE ID='$idProyeccion'";
                $this->Query($sql);
                
            }
        }
    }
    
    
    function AbonarCuotaAcuerdo($idCuota,$ValorAbono,$MetodoPago,$idUser) {
        $DatosProyeccion=$this->DevuelveValores("acuerdo_pago_proyeccion_pagos", "ID", $idCuota);
        $idAcuerdo=$DatosProyeccion["idAcuerdoPago"];
        $DatosAcuerdo=$this->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $DatosProyeccion["idAcuerdoPago"]);
        $SaldoAPagarCuota=$DatosProyeccion["ValorCuota"]-$DatosProyeccion["ValorPagado"];
        
        if($ValorAbono>$SaldoAPagarCuota){
            exit("E1;El valor del Abono supera el saldo de la Cuota");
        }
        $DatosGenerales= $this->DevuelveValores("configuracion_general", "ID", 30);//Verifico cuantos dias de plazo tiene un cliente para pagar
        $DiasPlazo=$DatosGenerales["Valor"];
        
        
            $idProyeccion=$DatosProyeccion["ID"];
           
            if($ValorAbono==$SaldoAPagarCuota){//en el caso que se pague por completo la cuota
                $ValorPago=$SaldoAPagarCuota;
                
                $idPago=$this->PagoAcuerdoPagos($idProyeccion,$DatosProyeccion["NumeroCuota"], $DatosProyeccion["TipoCuota"], $idAcuerdo, $ValorPago, $MetodoPago, $idUser);
                $FechaVencimiento=$this->SumeDiasAFechaAcuerdo($DatosProyeccion["Fecha"], $DiasPlazo);
                $FechaActual=date("Y-m-d");
                $Estado=1;
                if($FechaActual>$FechaVencimiento){
                    $Estado=3; // se marca como pago extemporaneo
                }
                $sql="UPDATE acuerdo_pago_proyeccion_pagos SET Estado='$Estado',ValorPagado=ValorCuota,idPago='$idPago' WHERE ID='$idProyeccion'";
                $this->Query($sql);
                
            }elseif($ValorAbono<$SaldoAPagarCuota) {
                $ValorPago=$ValorAbono;
                
                $idPago=$this->PagoAcuerdoPagos($idProyeccion,$DatosProyeccion["NumeroCuota"], $DatosProyeccion["TipoCuota"], $idAcuerdo, $ValorPago, $MetodoPago, $idUser);
                $FechaVencimiento=$this->SumeDiasAFechaAcuerdo($DatosProyeccion["Fecha"], $DiasPlazo);
                $FechaActual=date("Y-m-d");
                $Estado=2;
                
                $sql="UPDATE acuerdo_pago_proyeccion_pagos SET Estado='$Estado',ValorPagado=(ValorPagado+$ValorPago),idPago='$idPago' WHERE ID='$idProyeccion'";
                $this->Query($sql);
               
            }
            
        
    }
    
    
    public function AgregaDatosAdicionalesCliente($idCliente,$SobreNombre,$LugarTrabajo,$Cargo,$DireccionTrabajo,$TelefonoTrabajo,$Facebook,$Instagram) {
        $DatosAdicionales= $this->DevuelveValores("clientes_datos_adicionales", "idCliente", $idCliente);
        $Datos["idCliente"]=$idCliente;
        $Datos["SobreNombre"]=$SobreNombre;
        $Datos["LugarTrabajo"]=$LugarTrabajo;
        $Datos["Cargo"]=$Cargo;
        $Datos["DireccionTrabajo"]=$DireccionTrabajo;
        $Datos["TelefonoTrabajo"]=$TelefonoTrabajo;
        $Datos["Facebook"]=$Facebook;
        $Datos["Instagram"]=$Instagram;
        $Datos["Created"]=date("Y-m-d H:i:s");
        
        if($DatosAdicionales["ID"]==''){
            $sql= $this->getSQLInsert("clientes_datos_adicionales", $Datos);
            
        }else{
            $idDatosAdicionales=$DatosAdicionales["ID"];
            $sql= $this->getSQLUpdate("clientes_datos_adicionales", $Datos);
            $sql=$sql." WHERE ID='$idDatosAdicionales' ";
        }
        
        $this->Query($sql);
    }
    
    public function AgregaRecomendadoCliente($idCliente, $NombreRecomendado, $DireccionRecomendado, $TelefonoRecomendado, $DireccionTrabajoRecomendado, $TelefonoTrabajoRecomendado) {
        
        $Datos["idCliente"]=$idCliente;
        $Datos["NombreRecomendado"]=$NombreRecomendado;
        $Datos["DireccionRecomendado"]=$DireccionRecomendado;
        $Datos["TelefonoRecomendado"]=$TelefonoRecomendado;
        $Datos["DireccionTrabajoRecomendado"]=$DireccionTrabajoRecomendado;
        $Datos["TelefonoTrabajoRecomendado"]=$TelefonoTrabajoRecomendado;        
        $Datos["Created"]=date("Y-m-d H:i:s");
        
        $sql= $this->getSQLInsert("clientes_recomendados", $Datos);            
        $this->Query($sql);
    }
    
    public function InteresesAcuerdoPagos($idAcuerdoPago,$ValorPago,$MetodoPago,$idUser) {
         
         $Datos["idAcuerdoPago"]=$idAcuerdoPago;
         $Datos["FechaPago"]=date("Y-m-d");
         $Datos["ValorRecargoInteres"]=$ValorPago;
         $Datos["MetodoPago"]=$MetodoPago;
         $Datos["idUser"]=$idUser;
         $Datos["Created"]=date("Y-m-d H:i:s");
         $sql=$this->getSQLInsert("acuerdo_recargos_intereses", $Datos);
         $this->Query($sql);   
         $ID=$this->ObtenerMAX("acuerdo_recargos_intereses", "ID", "idAcuerdoPago", $idAcuerdoPago);
         return($ID);
     }
     
     public function ObtengaEstadoGeneralAcuerdo($idAcuerdo) {
         $this->ActualiceEstadosProyeccionPagos($idAcuerdo);
         $MaxEstado=$this->ObtenerMAX("acuerdo_pago_proyeccion_pagos", "Estado", "idAcuerdoPago", $idAcuerdo);
         return($MaxEstado);
     }
    
    /**
     * Fin Clase
     */
}
