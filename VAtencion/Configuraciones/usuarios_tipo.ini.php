<?php

$myTabla="usuarios_tipo";
$idTabla="ID";
$myPage="usuarios_tipo.php";
$myTitulo="Crear o Editar un tipo de Usuario";



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