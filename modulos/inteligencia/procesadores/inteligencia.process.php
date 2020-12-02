<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/inteligencia.class.php");
include_once("../clases/inteligenciaExcel.class.php");
include_once("../../../general/clases/mail.class.php");
if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Inteligencia($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1://Betar o habilitar un cliente
            $idCliente=$obCon->normalizar($_REQUEST['idCliente']);
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Estado"]==10){
                $obCon->ActualizaRegistro("clientes", "Estado", 0, "idClientes", $idCliente);
                $Mensaje="OK;El cliente ".$DatosCliente["RazonSocial"]." ha sido habilitado";
            }else{
                $obCon->ActualizaRegistro("clientes", "Estado", 10, "idClientes", $idCliente);
                
                $Mensaje="E1;El cliente ".$DatosCliente["RazonSocial"]." ha sido betado";
            }
            print($Mensaje);
            
        break;//Fin caso 1
        
        case 2://Genere el excel con el listado de clientes
            $obExcel= new ExcelInteligencia($idUser);
            $Condicion= urldecode(base64_decode($_REQUEST["c"]));            
            $obExcel->ListadoClientesExcel($Condicion);
            print("OK;Hoja Exportada");
        break;//fin caso 2
    
        case 3://Genere el excel con el listado de productos compradados por un cliente
            $obExcel= new ExcelInteligencia($idUser);
            $Condicion= urldecode(base64_decode($_REQUEST["c"]));            
            $obExcel->ListadoProductosClientes($Condicion);
            print("OK;Hoja Exportada");
        break;//fin caso 3
    
        case 4://Enviar un mail a los clientes
            $Destinatario=$obCon->normalizar($_REQUEST['Destinatario']);
            $Asunto=$obCon->normalizar($_REQUEST['Asunto']);
            $Mensaje=($_REQUEST['Mensaje']);
            
            $obMail=new TS_Mail($idUser);
            
            $obMail->EnviarMailXPHPNativo($Destinatario, "klam@gmail.com", "Klam", $Asunto, $Mensaje);
            print("OK;Mensaje Enviado");
        break;//Fin caso 4    
        
            
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>