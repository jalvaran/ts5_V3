<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/ServicioAcompanamiento.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Servicios($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //obtiene el valor por defecto de un servicio
            $CmbTipoServicio=$obCon->normalizar($_REQUEST["CmbTipoServicio"]);
            $sql="SELECT Valor FROM modelos_tipo_servicios WHERE ID='$CmbTipoServicio'";
            $DatosServicio=$obCon->FetchAssoc($obCon->Query($sql));            
            print("OK;".$DatosServicio["Valor"]);            
            
        break; //fin caso 1
    
        case 2: //agrega un nuevo servicio
            $CmbTipoServicio=$obCon->normalizar($_REQUEST["CmbTipoServicio"]);
            $CmbModelo=$obCon->normalizar($_REQUEST["CmbModelo"]);
            $ValorServicio=$obCon->normalizar($_REQUEST["ValorServicio"]);
            if($CmbModelo==''){
                exit("E1;Debes elegir una modelo");
            }  
            
            if($CmbTipoServicio==''){
                exit("E1;Debes elegir un tipo de servicio");
            }  
            
            if(!is_numeric($ValorServicio) or $ValorServicio<=0){
                exit("E1;El valor del servicio debe ser u número entero mayor a Cero");
            }  
            $sql="SELECT ID FROM modelos_agenda WHERE idModelo='$CmbModelo' AND Estado='0'";
            $DatosAgenda=$obCon->FetchAssoc($obCon->Query($sql));
            if($DatosAgenda["ID"]<>''){
                exit("E1;La modelo seleccionada ya se encuentra en servicio");
            }
            
            $obCon->NuevoServicio($CmbModelo, $ValorServicio, $CmbTipoServicio, $idUser);            
            print("OK;Servicio agregado");            
            
        break; //Fin caso 2
        
        case 3://Terminar un servicio
            $idServicio=$obCon->normalizar($_REQUEST["idServicio"]);
            $FechaActual=date("Y-m-d H:i:s");
            $obCon->ActualizaRegistro("modelos_agenda", "Estado", 1, "ID", $idServicio);
            $obCon->ActualizaRegistro("modelos_agenda", "HoraFinalizacion", $FechaActual, "ID", $idServicio);
            print("OK;Servicio Finalizado");
            
        break;  //Fin caso 3  
    
        case 4://Registrar Pago a Modelo
            $idModelo=$obCon->normalizar($_REQUEST["idModelo"]);            
            $ValorPago=$obCon->normalizar($_REQUEST["TxtValorPago"]);
            $FechaPago=date("Y-m-d H:i:s");
            
            if($idModelo==''){
                exit("E1;No se recibió el ID de la modelo a pagar");
            }
            if(!is_numeric($ValorPago) or $ValorPago<=0){
                exit("E1;El campo de texto Valor Pagado debe ser un Número mayor a Cero");
            }
            $DatosModelo=$obCon->DevuelveValores("vista_servicio_acompanamiento_cuentas_x_pagar", "idModelo", $idModelo);
            if($ValorPago>$DatosModelo["Saldo"]){
                exit("E1;El valor a pagar no puede superar el saldo");
            }
            $obCon->PagoAModelo($FechaPago, $idModelo, $ValorPago,$idUser);
            print("OK;Pago Registrado a al modelo $idModelo");
            
        break;  //Fin caso 4
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>