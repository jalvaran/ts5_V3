<?php 
session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}

if(isset($_REQUEST["Opcion"])){
   
    include_once("../clases/AcuerdoPago.class.php"); 
       
    $idUser=$_SESSION['idUser'];
    $obCon = new AcuerdoPago($idUser);
    switch ($_REQUEST["Opcion"]){
        case 1: //Guardar Foto de un acuerdo de pago
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $imagenCodificada = $_REQUEST["foto"]; //Obtener la imagen
            if(strlen($imagenCodificada) <= 0) exit("No se recibió ninguna imagen");
            //La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
            $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", ($imagenCodificada));
            $Ruta=$obCon->CrearFotoDesdeBase64($imagenCodificadaLimpia, $idAcuerdo);
            //Terminar y regresar el nombre de la foto
            $Ruta= str_replace("../", "", $Ruta);
            $Ruta="../../".$Ruta;
            print("<a href='$Ruta' target='_blank'><h5>Ver foto</h5></a>");
            //exit($Ruta);
            break;//Fin caso 2
        
        }
}else{
    print("No se recibió parametro de opcion");
}

?>