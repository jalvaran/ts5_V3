<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
class Servicios extends ProcesoVenta{
    
    public function NuevoServicio($idModelo,$Efectivo,$Tarjetas,$Valor,$TipoServicio,$idUser) {
        $DatosModelos= $this->DevuelveValores("modelos_db", "ID", $idModelo);
        $DatosServicios=$this->DevuelveValores("modelos_tipo_servicios", "ID", $TipoServicio);
        $Tiempo=$DatosServicios["Tiempo"];
        $Estado=0;
        $servicios_key[1]="valor_servicio_20";
        //print($TipoServicio);
        if($TipoServicio<=4){
            $keyValorModelo="ValorServicio".$TipoServicio;
            $ValorModelo=$DatosModelos[$keyValorModelo];
           
            if($Valor>$DatosServicios["Valor"]){
                $ValorRestante=$Valor-$DatosServicios["Valor"];
                $ValorModelo=$ValorModelo+$ValorRestante;
            }
             
            $ValorCasa=$Valor-$ValorModelo;
            
        }
        
        if($TipoServicio==4){// Multas
            $Estado=0;
            $ValorModelo=0;
            $ValorCasa=$Valor;
        }
        
        if($TipoServicio==5){ // Shows
            
            $ValorModelo=$DatosServicios["ValorModelo"];
            $ValorCasa=$Valor-$ValorModelo;
        }
        
        if($TipoServicio==6){ //fichas
            
            $ValorModelo=$Valor;
            $ValorCasa=0;
        }
        
        
        if($ValorModelo>$Valor){ 
            $ValorModelo=$Valor;
            $ValorCasa=0;
        }
        //////Ingreso a agenda          
        $tab="modelos_agenda";
        $NumRegistros=12;

        $Columnas[0]="idModelo";	$Valores[0]=$idModelo;
        $Columnas[1]="ValorPagado";     $Valores[1]=$Valor;
        $Columnas[2]="ValorModelo";     $Valores[2]=$ValorModelo;
        $Columnas[3]="ValorCasa";	$Valores[3]=$ValorCasa;
        $Columnas[4]="Minutos";         $Valores[4]=$Tiempo;
        $Columnas[5]="HoraInicial";	$Valores[5]=date("Y-m-d H:i:s");
        $Columnas[6]="HoraATerminar";	$Valores[6]=date( "Y-m-d H:i:s" ,strtotime($Valores[5])+($Tiempo*60));  
        $Columnas[7]="idUser";          $Valores[7]=$idUser;
        $Columnas[8]="Estado";          $Valores[8]=$Estado;
        $Columnas[9]="TipoServicio";    $Valores[9]=$TipoServicio;
        $Columnas[10]="Efectivo";       $Valores[10]=$Efectivo;
        $Columnas[11]="Tarjetas";       $Valores[11]=$Tarjetas;
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
    }
    
    public function PagoAModelo($Fecha,$idModelo,$ValorPago,$idUser) {
        
        $Datos["Fecha"]=$Fecha;
        $Datos["idModelo"]=$idModelo;
        $Datos["ValorPagado"]=$ValorPago;
        $Datos["idUser"]=$idUser;
        $sql=$this->getSQLInsert("modelos_pagos_realizados", $Datos);
        $this->Query($sql);
    }
        
    /**
     * Fin Clase
     */
}
