<?php

$myTabla="restaurante_cierres";
$myPage="modelos_cierres.php";
$myTitulo="Historial de cierres";
$idTabla="ID";


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
 * Deshabilito Acciones
 * 
 */
  //Link para la accion ver
$Ruta="../general/consultas/PDF_Documentos.draw.php?idDocumento=36&ID=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

//$Vector["VerRegistro"]["Deshabilitado"]=1;       
$Vector["NuevoRegistro"]["Deshabilitado"]=1;                                 
$Vector["EditarRegistro"]["Deshabilitado"]=1;


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>