<?php

$myTabla="separados_abonos";
$MyID="ID";
$myPage="separados_abonos.php";
$myTitulo="Historial de Abonos";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

/*
 * Deshabilito Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1;  


//Link para la accion ver
$Ruta="$myPage?idSeparado=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idSeparado";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */

$Vector["Usuario"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Usuario"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["Usuario"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["Usuario"]["Display"]="Apellido";                    //Columna que quiero mostrar

$Vector["idCliente"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idCliente"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector["idCliente"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector["idCliente"]["Display"]="RazonSocial";                    //Columna que quiero mostrar

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>