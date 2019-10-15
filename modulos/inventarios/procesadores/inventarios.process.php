<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/inventarios.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Inventarios($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1://Verifica si ya existe la referencia de un producto o servicio
            $Referencia=$obCon->normalizar($_REQUEST['TxtReferencia']);
            $Tabla=$obCon->normalizar($_REQUEST['Tabla']);
            if($Tabla==1){
                $Tabla="productosventa";
            }
            $Datos=$obCon->ValorActual("$Tabla", "Referencia", " Referencia='$Referencia'");
            if($Datos["Referencia"]<>''){
                print("E1;La Referencia Digitada ya existe");
                exit();
            }
            print("OK;Referencia disponible");
        break;//Fin caso 1
        
        case 2: //Crear un producto para la venta
            
            $CmbDepartamento=$obCon->normalizar($_REQUEST["CmbDepartamento"]);
            $CmbSub1=$obCon->normalizar($_REQUEST["CmbSub1"]);
            $CmbSub2=$obCon->normalizar($_REQUEST["CmbSub2"]);
            $CmbSub3=$obCon->normalizar($_REQUEST["CmbSub3"]);
            $CmbSub4=$obCon->normalizar($_REQUEST["CmbSub4"]);
            $CmbSub6=$obCon->normalizar($_REQUEST["CmbSub6"]);
            $TxtNombre=$obCon->normalizar($_REQUEST["TxtNombre"]);
            $TxtReferencia=$obCon->normalizar($_REQUEST["TxtReferencia"]);
            $TxtExistencias=$obCon->normalizar($_REQUEST["TxtExistencias"]);
            $TxtPrecioVenta=$obCon->normalizar($_REQUEST["TxtPrecioVenta"]);
            $TxtPrecioMayorista=$obCon->normalizar($_REQUEST["TxtPrecioMayorista"]);
            $TxtCostoUnitario=$obCon->normalizar($_REQUEST["TxtCostoUnitario"]);
            $CmbIVA=$obCon->normalizar($_REQUEST["CmbIVA"]);
            $CmbCuentaPUC=$obCon->normalizar($_REQUEST["CmbCuentaPUC"]);
            $TxtCodigoBarras=$obCon->normalizar($_REQUEST["TxtCodigoBarras"]);
            $CmbSub5=0;
            $Vector["Sub6"]=$CmbSub6;
            
            $idProducto=$obCon->CrearProductoVenta($TxtNombre, $TxtCodigoBarras, $TxtReferencia, $TxtPrecioVenta, $TxtPrecioMayorista, $TxtExistencias, $TxtCostoUnitario, $CmbIVA, $CmbDepartamento, $CmbSub1, $CmbSub2, $CmbSub3, $CmbSub4, $CmbSub5, $CmbCuentaPUC, $Vector, "", "");
            
            print("OK;Se creó el producto $idProducto");            
            
        break; 
        
        
       
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>