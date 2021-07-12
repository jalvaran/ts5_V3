<?php

$myTabla="vista_notas_credito_general";
$MyID="ID";
$myPage="notascredito.php";
$myTitulo="Notas Credito";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;      
/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="../tcpdf/examples/notacredito.php?idComprobante=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */

$Vector["Excluir"]["RespuestaCompletaServidor"]=1; 
$Vector["Excluir"]["LogsDocumento"]=1; 
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>