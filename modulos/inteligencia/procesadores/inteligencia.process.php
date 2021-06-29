<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/inteligencia.class.php");
include_once("../clases/inteligenciaExcel.class.php");
include_once("../clases/pdf_inteligencia.class.php");
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
    
        case 5://Generar el informe de inteligencia de negocio
            $fecha_inicial=$obCon->normalizar($_REQUEST['fecha_inicial']);
            $fecha_final=$obCon->normalizar($_REQUEST['fecha_final']);
            $obPDF=new PDF_Inteligencia(DB);
            $obPDF->pdf_inteligencia_negocio($fecha_inicial, $fecha_final, 1);
        break;//Fin caso 5
        
        case 6://Crea la tabla clientes si no existe y devuelve la cantidad de clientes a copiar
            
            $sql="SELECT COUNT(*) as TotalItems FROM clientes";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalItems=$DatosConsulta["TotalItems"];
            if($TotalItems==0){
                exit("E1;No existen clientes para copiar");
            }
                        
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            $sql="DROP TABLE IF EXISTS clientes";
            $obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            $sql="SHOW CREATE TABLE clientes";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $sqlCreateTable=$DatosConsulta["Create Table"];
            $sqlCreateTable= str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sqlCreateTable);            
            $obCon->QueryExterno($sqlCreateTable, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            
            print("OK;Se encontraron $TotalItems clientes a copiar;$TotalItems");
            
        break;//Fin caso 6
        
        case 7://Copiar los registros de la tabla clientes de acuerdo a un limite
            $Limit=500;
            $page_clientes=$obCon->normalizar($_REQUEST["page_clientes"]);
            $total_clientes=$obCon->normalizar($_REQUEST["total_clientes"]);
            $TotalPaginas= ceil($total_clientes/$Limit);
            $PuntoInicio = ($page_clientes * $Limit) - $Limit;
            $Condicion="LIMIT $PuntoInicio,$Limit; ";
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            $sql=$obCon->ArmeSqlReplace("clientes", $db, $Condicion, $DatosServer["DataBase"], date("Y-m-d H:i:s"), "");                   
            $obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            if($page_clientes>=$TotalPaginas){
                print("END;$page_clientes Bloques de $TotalPaginas Copiados");
            }else{
                $page_clientes=$page_clientes+1;
                print("OK;Copiando Bloque de productos $page_clientes de $TotalPaginas;$page_clientes");
            }
            
        break;//Fin caso 7
        
        case 8://Crea la tabla temporal clientes en el servidor local si no existen y devuelve la cantidad de clientes a copiar desde le servidor externo
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            $sql="SELECT COUNT(*) as TotalItems FROM clientes";
            $Consulta=$obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            $DatosConsulta=$obCon->FetchAssoc($Consulta);
            $TotalItems=$DatosConsulta["TotalItems"];
            if($TotalItems==0){
                exit("E1;No existen clientes para copiar en el servidor externo");
            }
                        
            $sql="DROP TABLE IF EXISTS temp_clientes";
            $obCon->Query($sql);            
            
            $sql="SHOW CREATE TABLE clientes";
            $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
            $sqlCreateTable=$DatosConsulta["Create Table"];
            $sqlCreateTable= str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sqlCreateTable); 
            $sqlCreateTable= str_replace("clientes", "temp_clientes", $sqlCreateTable);
            $obCon->Query($sqlCreateTable);   
            
            print("OK;Se encontraron $TotalItems clientes a copiar;$TotalItems");
            
        break;//Fin caso 8
        
        case 9://Copiar los registros de la tabla clientes externa y copiarlos la tabla interna temporal de acuerdo a un limite
            $Limit=500;
            $page_clientes=$obCon->normalizar($_REQUEST["page_clientes"]);
            $total_clientes=$obCon->normalizar($_REQUEST["total_clientes"]);
            $TotalPaginas= ceil($total_clientes/$Limit);
            $PuntoInicio = ($page_clientes * $Limit) - $Limit;
            $Condicion="LIMIT $PuntoInicio,$Limit; ";
            
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 1);
            
            $VectorAS["TablaDestino"]="temp_clientes";
            $sql=$obCon->ArmeSqlReplace("clientes", DB, $Condicion, DB, "", $VectorAS,$DatosServer);
            
            $obCon->Query($sql);
         
            if($page_clientes>=$TotalPaginas){
                print("END;$page_clientes Bloques de $TotalPaginas Copiados");
            }else{
                $page_clientes=$page_clientes+1;
                print("OK;Copiando Bloque $page_clientes de $TotalPaginas;$page_clientes");
            }
            
        break;//Fin caso 9
        
        case 10: //Insertar los clientes que no esten en la tabla principal pero si en la tabla temporal
            
            $sql="REPLACE INTO clientes 
                    SELECT * 
                    FROM temp_clientes t1
                     
                    ";
            $obCon->Query($sql);
            //print("Copiados");
            print("OK;Nuevos clientes copiados");
            
        break;//Fin caso 10
    
        case 11://Obtener los valores de las metas
            $fecha_inicial=date("Y-m-d");
            $fecha_final=date("Y-m-d");
            
            if(isset($_REQUEST["fecha_inicial"]) and !empty($_REQUEST["fecha_inicial"]) ){
                $fecha_inicial=$_REQUEST["fecha_inicial"];
            }
            if(isset($_REQUEST["fecha_final"]) and !empty($_REQUEST["fecha_final"]) ){
                $fecha_final=$_REQUEST["fecha_final"];
            }
            
            $datos_metas=$obCon->obtener_cumplimiento_metas($fecha_inicial, $fecha_final);
            $cumplimiento_mes_actual=$datos_metas["cumplimiento_mes_actual"];
            $cumplimiento_mes_meta=$datos_metas["cumplimiento_mes_meta"];
            $cumplimiento_dia_actual=$datos_metas["cumplimiento_dia_actual"];
            $cumplimiento_dia_meta=$datos_metas["cumplimiento_dia_meta"];
            for ($i=1;$i<=12;$i++){
                if(!isset($datos_metas[$i]["meta"])){
                    $meta[$i]=0;
                }else{
                    $meta[$i]=$datos_metas[$i]["meta"];
                }
                if(!isset($datos_metas["ventas_anio"][$i]["total_venta_mes"])){
                    $meta_ventas[$i]=0;
                }else{
                    $meta_ventas[$i]=$datos_metas["ventas_anio"][$i]["total_venta_mes"];
                }
            }
            $array_meta=[$meta[1],$meta[2],$meta[3],$meta[4],$meta[5],$meta[6],$meta[7],$meta[8],$meta[9],$meta[10],$meta[11],$meta[12]];
            $array_meta_ventas=[$meta_ventas[1],$meta_ventas[2],$meta_ventas[3],$meta_ventas[4],$meta_ventas[5],$meta_ventas[6],$meta_ventas[7],$meta_ventas[8],$meta_ventas[9],$meta_ventas[10],$meta_ventas[11],$meta_ventas[12]];
            
            $json_meta= json_encode($array_meta);
            $json_meta_ventas= json_encode($array_meta_ventas);
            
            $frase_mes_actual=$datos_metas["frase_mes_actual"];
            $valores_metas_cumplimiento=[];
            print('OK;'.($frase_mes_actual).';'.$cumplimiento_dia_meta.';'.$cumplimiento_dia_actual.';'.$json_meta.';'.$json_meta_ventas.';'.$cumplimiento_mes_meta.';'.$cumplimiento_mes_actual);
        break;//fin caso 11    
        
        case 12: //editar un registro en una tabla del modulo
            $tabla_id=$obCon->normalizar($_REQUEST["tabla_id"]);
            $valor_nuevo=$obCon->normalizar($_REQUEST["valor_nuevo"]);
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);
            $campo=$obCon->normalizar($_REQUEST["campo"]);
            $tab="";
            if($tabla_id==1){
                $tab="metas_ventas";
            }
            if($tab<>''){
                $sql="UPDATE $tab SET $campo='$valor_nuevo' WHERE ID='$item_id' ";
                $obCon->Query($sql);
            }
            print("OK;Registro Actualizado");
            
        break;//Fin caso 12
        
        case 13: //inserta los registros para inicializar las metas de un año
            $ano=$obCon->normalizar($_REQUEST["ano"]);
            $validacion=$obCon->DevuelveValores("metas_ventas", "Anio", $ano);
            if($ano<2010 or $ano>2050){
                exit("E1;Año fuera de rango");
            }
            if($validacion["Anio"]>0){
                exit("E1;ya existen metas para el año $ano");
            }else{
                $sql="INSERT INTO `metas_ventas` (`ID`, `Anio`, `Mes`) VALUES
                    ('',	$ano,	1),
                    ('',	$ano,	2),
                    ('',	$ano,	3),
                    ('',	$ano,	4),
                    ('',	$ano,	5),
                    ('',	$ano,	6),
                    ('',	$ano,	7),
                    ('',	$ano,	8),
                    ('',	$ano,	9),
                    ('',	$ano,	10),
                    ('',	$ano,	11),
                    ('',	$ano,	12);";
                $obCon->Query($sql);
            }
            print("OK;Registros Inicializados");
            
        break;//Fin caso 13
        
        case 14://Agregar los registros de las metas diarias de acuerdo a la tabla metas_ventas
            
            $obCon->construir_metas_diarias();
            print("OK;Tabla de metas diaras construida correctamente");
        break;//fin caso 14
    
        case 15://Genere el excel con el listado de metas diarias
            $obExcel= new ExcelInteligencia($idUser);
            $Condicion= urldecode(base64_decode($_REQUEST["c"]));            
            $obExcel->ListadoMetasDiariasExcel($Condicion);
            print("OK;Metas Exportadas");
        break;//fin caso 15
    
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>