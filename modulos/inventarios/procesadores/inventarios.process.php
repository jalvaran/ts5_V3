<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/inventarios.class.php");
include_once("../clases/inventariosExcel.class.php");

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
            
        break;//Fin caso 2
    
        case 3://Crea la tabla productos venta y codigos de barras si no existen y devuelve la cantidad de productos a copiar
            
            $sql="SELECT COUNT(*) as TotalItems FROM productosventa";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalItems=$DatosConsulta["TotalItems"];
            if($TotalItems==0){
                exit("E1;No existen productos para copiar");
            }
            $sql="SELECT COUNT(*) as TotalItems FROM prod_codbarras";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalBars=$DatosConsulta["TotalItems"];
            
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            $sql="DROP TABLE IF EXISTS productosventa";
            $obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            $sql="DROP TABLE IF EXISTS prod_codbarras";
            $obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            $sql="SHOW CREATE TABLE productosventa";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $sqlCreateTable=$DatosConsulta["Create Table"];
            $sqlCreateTable= str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sqlCreateTable);            
            $obCon->QueryExterno($sqlCreateTable, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            $sql="SHOW CREATE TABLE prod_codbarras";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $sqlCreateTable=$DatosConsulta["Create Table"];
            $sqlCreateTable= str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sqlCreateTable);            
            $obCon->QueryExterno($sqlCreateTable, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            print("OK;Se encontraron $TotalItems productos a copiar y $TotalBars codigos de barras;$TotalItems;$TotalBars");
            
        break;//Fin caso 3 
        
        case 4://Copiar los registros de la tabla productos venta de acuerdo a un limite
            $Limit=500;
            $pageProducts=$obCon->normalizar($_REQUEST["pageProducts"]);
            $totalProducts=$obCon->normalizar($_REQUEST["totalProducts"]);
            $TotalPaginas= ceil($totalProducts/$Limit);
            $PuntoInicio = ($pageProducts * $Limit) - $Limit;
            $Condicion="LIMIT $PuntoInicio,$Limit; ";
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            $sql=$obCon->ArmeSqlReplace("productosventa", $db, $Condicion, $DatosServer["DataBase"], date("Y-m-d H:i:s"), "");                   
            $obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            if($pageProducts>=$TotalPaginas){
                print("END;$pageProducts Bloques de $TotalPaginas Copiados");
            }else{
                $pageProducts=$pageProducts+1;
                print("OK;Copiando Bloque de productos $pageProducts de $TotalPaginas;$pageProducts");
            }
            
        break;//Fin caso 4
        
        case 5://Copiar los registros de la tabla prod_codbarras venta de acuerdo a un limite
            $Limit=500;
            $pageProducts=$obCon->normalizar($_REQUEST["pageProducts"]);
            $totalBars=$obCon->normalizar($_REQUEST["totalBars"]);
            if($totalBars==0){
                exit("E1;No hay codigos de barras para copiar");
            }
            $TotalPaginas= ceil($totalBars/$Limit);
            $PuntoInicio = ($pageProducts * $Limit) - $Limit;
            $Condicion="LIMIT $PuntoInicio,$Limit; ";
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            $sql=$obCon->ArmeSqlReplace("prod_codbarras", $db, $Condicion, $DatosServer["DataBase"], date("Y-m-d H:i:s"), "");                   
            if($sql<>''){
                
                $obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            }
            if($pageProducts>=$TotalPaginas){
                print("END;$pageProducts Bloques de $TotalPaginas Copiados");
            }else{
                $pageProducts=$pageProducts+1;
                print("OK;Copiando Bloque de barras $pageProducts de $TotalPaginas;$pageProducts");
            }
            
        break;//Fin caso 5
        
        case 6://Crea la tabla productos venta y codigos de barras tempornl en el servidor local si no existen y devuelve la cantidad de productos a copiar desde le servidor externo
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            $sql="SELECT COUNT(*) as TotalItems FROM productosventa";
            $Consulta=$obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            $DatosConsulta=$obCon->FetchAssoc($Consulta);
            $TotalItems=$DatosConsulta["TotalItems"];
            if($TotalItems==0){
                exit("E1;No existen productos para copiar en el servidor externo");
            }
            $sql="SELECT COUNT(*) as TotalItems FROM prod_codbarras";
            $Consulta=$obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            $DatosConsulta=$obCon->FetchAssoc($Consulta);
            $TotalBars=$DatosConsulta["TotalItems"];
            
            $sql="DROP TABLE IF EXISTS productosventa_temp";
            $obCon->Query($sql);            
            $sql="DROP TABLE IF EXISTS prod_codbarras_temp";
            $obCon->Query($sql);     
            
            $sql="SHOW CREATE TABLE productosventa";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $sqlCreateTable=$DatosConsulta["Create Table"];
            $sqlCreateTable= str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sqlCreateTable); 
            $sqlCreateTable= str_replace("productosventa", "productosventa_temp", $sqlCreateTable);
            $obCon->Query($sqlCreateTable);   
            
            $sql="SHOW CREATE TABLE prod_codbarras";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $sqlCreateTable=$DatosConsulta["Create Table"];
            $sqlCreateTable= str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sqlCreateTable); 
            $sqlCreateTable= str_replace("prod_codbarras", "prod_codbarras_temp", $sqlCreateTable);
            $obCon->Query($sqlCreateTable);   
            
            print("OK;Se encontraron $TotalItems productos a copiar y $TotalBars codigos de barras;$TotalItems;$TotalBars");
            
        break;//Fin caso 6
        
        case 7://Copiar los registros de la tabla productos venta externa y copiarlos la taba interna temporal de acuerdo a un limite
            $Limit=500;
            $pageProducts=$obCon->normalizar($_REQUEST["pageProducts"]);
            $totalProducts=$obCon->normalizar($_REQUEST["totalProducts"]);
            $TotalPaginas= ceil($totalProducts/$Limit);
            $PuntoInicio = ($pageProducts * $Limit) - $Limit;
            $Condicion="LIMIT $PuntoInicio,$Limit; ";
            
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            
            $VectorAS["TablaDestino"]="productosventa_temp";
            $sql=$obCon->ArmeSqlReplace("productosventa", DB, $Condicion, DB, "", $VectorAS,$DatosServer);
            
            $obCon->Query($sql);
         
            if($pageProducts>=$TotalPaginas){
                print("END;$pageProducts Bloques de $TotalPaginas Copiados");
            }else{
                $pageProducts=$pageProducts+1;
                print("OK;Copiando Bloque de productos $pageProducts de $TotalPaginas;$pageProducts");
            }
            
        break;//Fin caso 7
        
        case 8://Copiar los registros de la tabla prod_codbarras venta de acuerdo a un limite
            $Limit=500;
            $pageProducts=$obCon->normalizar($_REQUEST["pageProducts"]);
            $totalBars=$obCon->normalizar($_REQUEST["totalBars"]);
            if($totalBars==0){
                exit("E1;No hay codigos de barras para copiar");
            }
            $TotalPaginas= ceil($totalBars/$Limit);
            $PuntoInicio = ($pageProducts * $Limit) - $Limit;
            $Condicion="LIMIT $PuntoInicio,$Limit; ";
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            
            $VectorAS["TablaDestino"]="prod_codbarras_temp";
            $sql=$obCon->ArmeSqlReplace("prod_codbarras", DB, $Condicion, DB, "", $VectorAS,$DatosServer);
            
            $obCon->Query($sql);
            
            if($pageProducts>=$TotalPaginas){
                print("END;$pageProducts Bloques de $TotalPaginas Copiados");
            }else{
                $pageProducts=$pageProducts+1;
                print("OK;Copiando Bloque de barras $pageProducts de $TotalPaginas;$pageProducts");
            }
            
        break;//Fin caso 8
        
        case 9: //Insertar los productos que no esten pero si en la tabla temporal
            
            $sql="INSERT INTO productosventa (`idProductosVenta`,`CodigoBarras`,`Referencia`,`Nombre`,`Existencias`,`PrecioVenta`,`PrecioMayorista`,`CostoUnitario`,`CostoTotal`,`CostoUnitarioPromedio`,`CostoTotalPromedio`,`IVA`,`Bodega_idBodega`,`Departamento`,`Sub1`,`Sub2`,`Sub3`,`Sub4`,`Sub5`,`Sub6`,`Kit`,`Especial`,`CuentaPUC`,`ValorComision1`,`ValorComision2`,`ValorComision3`,`ValorComision4` )
                    SELECT `idProductosVenta`,`CodigoBarras`,`Referencia`,`Nombre`,'0',`PrecioVenta`,`PrecioMayorista`,`CostoUnitario`,'0',`CostoUnitario`,'0',`IVA`,`Bodega_idBodega`,`Departamento`,`Sub1`,`Sub2`,`Sub3`,`Sub4`,`Sub5`,`Sub6`,`Kit`,`Especial`,`CuentaPUC`,`ValorComision1`,`ValorComision2`,`ValorComision3`,`ValorComision4` 
                      FROM productosventa_temp t1
                     WHERE NOT EXISTS (SELECT NULL FROM productosventa t2 WHERE t2.Referencia = t1.Referencia)
                    
                    ";
            $obCon->Query($sql);
            //print("Copiados");
            print("OK;Nuevos productos copiados");
            
        break;//Fin caso 9 
        
        case 10: //Insertar los codigos nuevos que no esten pero si en la tabla temporal
            
            $sql="REPLACE INTO prod_codbarras 
                    SELECT *
                      FROM prod_codbarras_temp t1
                     WHERE NOT EXISTS (SELECT NULL FROM prod_codbarras t2 WHERE t2.CodigoBarras = t1.CodigoBarras)
                    
                    ";
            $obCon->Query($sql);
            print("OK;Nuevos codigos de barras copiados");
            
        break;//Fin caso 10
    
        case 11: //Actualizo los productos que no esten pero si en la tabla temporal
            $sql="UPDATE productosventa t1                     
                    INNER JOIN productosventa_temp t2 ON t1.Referencia=t2.Referencia 
                    SET t1.Nombre = t2.Nombre, t1.PrecioVenta= t2.PrecioVenta,t1.IVA=t2.IVA,t1.CuentaPUC=t2.CuentaPUC,
                        t1.CostoUnitario = t2.CostoUnitario,t1.Departamento= t2.Departamento,
                        t1.Sub1 = t2.Sub1,t1.Sub2 = t2.Sub2,t1.Sub3 = t2.Sub3,t1.Sub4 = t2.Sub4,t1.Sub5 = t2.Sub5,
                        t1.Sub6 = t2.Sub6,t1.CostoTotal=t1.CostoUnitario*t1.Existencias  
                     WHERE t1.Nombre <> t2.Nombre OR t1.PrecioVenta <> t2.PrecioVenta OR t1.CostoUnitario <> t2.CostoUnitario
                        OR t1.Departamento <> t2.Departamento OR t1.Sub1 <> t2.Sub1 OR t1.Sub2 <> t2.Sub2
                        OR t1.Sub3 <> t2.Sub3 OR t1.Sub4 <> t2.Sub4 OR t1.Sub5 <> t2.Sub5 OR t1.Sub6 <> t2.Sub6
                        OR t1.IVA <> t2.IVA OR t1.CuentaPUC <> t2.CuentaPUC ;


                    ";
            $obCon->Query($sql);
            
            print("OK;productos venta Actualizados");
            
        break;//Fin caso 11
    
        case 12: //Actualizo los codigos que no esten pero si en la tabla temporal
            
            $sql="UPDATE prod_codbarras t1                     
                    INNER JOIN prod_codbarras_temp t2 ON t1.CodigoBarras=t2.CodigoBarras  
                    SET t1.ProductosVenta_idProductosVenta = t2.ProductosVenta_idProductosVenta 
                     WHERE t1.ProductosVenta_idProductosVenta <> t2.ProductosVenta_idProductosVenta  ;
                    ";
            $obCon->Query($sql);
            print("OK;Codigos de barras Actualizados, Fin del proceso");
            
        break;//Fin caso 12
    
        case 13://Genere el excel con el listado de separados
            $obExcel= new ExcelIntentarios($idUser);
            $Condicion= urldecode(base64_decode($_REQUEST["c"]));            
            $obExcel->ListadoSeparadosExcel($Condicion);
            print("OK;Hoja Exportada");
        break;//fin caso 13
    
        
       
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>