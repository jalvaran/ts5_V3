<?php

$myTabla="config_puertos";
$idTabla="ID";
$myPage="config_puertos.php";
$myTitulo="Configuracion de Puertos";



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

        
$Vector["VerRegistro"]["Deshabilitado"]=1; 
///Columnas excluidas


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>