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
     public function PagoAcuerdoPagos($NumeroCuota,$TipoCuota,$idAcuerdoPago,$ValorPago,$MetodoPago,$idUser) {
         $Datos["NumeroCuota"]=$NumeroCuota;
         $Datos["TipoCuota"]=$TipoCuota;
         $Datos["idAcuerdoPago"]=$idAcuerdoPago;
         $Datos["FechaPago"]=date("Y-m-d");
         $Datos["ValorPago"]=$ValorPago;
         $Datos["MetodoPago"]=$MetodoPago;
         $Datos["idUser"]=$idUser;
         $Datos["Created"]=date("Y-m-d H:i:s");
         $sql=$this->getSQLInsert("acuerdo_pago_cuotas_pagadas", $Datos);
         $this->Query($sql);         
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
     
     public function ContruyaProyeccionPagos($idAcuerdoPago,$ValorAProyectar,$ValorCuotaAcuerdo,$cicloPagos,$FechaInicial,$idUser) {
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
        
        $this->CuotaAcuerdoPagosTemporal($FechaInicial, 1, 2, $idAcuerdoPago, $ValorCuotaAcuerdo, $idUser);
        for($i=2;$i<=$NumeroCuotasCalculadas;$i++){
            if($cicloPagos==1){ //Si el ciclo es Semanal
                $DatosProyeccion["FechaCuotas"][$i]=$this->SumeSemanasAFecha($FechaInicial, $i-1);
            }
            if($cicloPagos==2){ //Si el ciclo es Quincenal
                $DatosProyeccion["FechaCuotas"][$i]=$this->SumeSemanasAFecha($FechaInicial, ($i-1)*2);
            }
            if($cicloPagos==3){ //Si el ciclo es Mensual
                $DatosProyeccion["FechaCuotas"][$i]=$this->SumeMesesAFecha($FechaInicial, ($i-1));
            }
            $DatosProyeccion["ValorCuota"][$i]=$ValorCuotaAcuerdo;
            if($i==$NumeroCuotasCalculadas){
                $DatosProyeccion["ValorCuota"][$i]=$ValorUltimaCuota;
            }
            $DatosProyeccion["FechaFinal"]=$DatosProyeccion["FechaCuotas"][$i];
            $DatosProyeccion["NombreDia"][$i]=$this->obtenerNombreDiaFecha($DatosProyeccion["FechaCuotas"][$i]);
            
            $this->CuotaAcuerdoPagosTemporal($DatosProyeccion["FechaCuotas"][$i], $i, 2, $idAcuerdoPago, $DatosProyeccion["ValorCuota"][$i], $idUser);
            
        }
        
        
        return($DatosProyeccion);
     }
     
     public function obtenerNombreDiaFecha($Fecha) {
        $NombreDia=array("","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"); 
        $fechaComoEntero = strtotime($Fecha);
        $dia = date("N", $fechaComoEntero); 
        $DiaSemana=$NombreDia[$dia];
        return($DiaSemana);
        
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
     
    /**
     * Fin Clase
     */
}
