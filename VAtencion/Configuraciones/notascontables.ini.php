<?php

$myTabla="notascontables";
$MyID="ID";
$myPage="notascontables.php";
$myTitulo="Historial Notas Contables";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
//$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="../tcpdf/examples/NotaContablePrint.php?ImgPrintComp=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */

// Nueva Accion
$Ruta="AnularNota.php?idNota=";
$Vector["NuevaAccionLink"][1]="Anular";
$Vector["NuevaAccion"]["Anular"]["Titulo"]="Anular";
$Vector["NuevaAccion"]["Anular"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Anular"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Anular"]["Target"]="_self";


$Vector["CentroCostos"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CentroCostos"]["TablaVinculo"]="centrocosto";  //tabla de donde se vincula
$Vector["CentroCostos"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["CentroCostos"]["Display"]="Nombre"; 
$Vector["CentroCostos"]["Predeterminado"]=1;

$Vector["EmpresaPro"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["EmpresaPro"]["TablaVinculo"]="empresapro";  //tabla de donde se vincula
$Vector["EmpresaPro"]["IDTabla"]="idEmpresaPro"; //id de la tabla que se vincula
$Vector["EmpresaPro"]["Display"]="RazonSocial"; 
$Vector["EmpresaPro"]["Predeterminado"]=1;

$Vector["idProveedor"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idProveedor"]["TablaVinculo"]="proveedores";  //tabla de donde se vincula
$Vector["idProveedor"]["IDTabla"]="idProveedores"; //id de la tabla que se vincula
$Vector["idProveedor"]["Display"]="RazonSocial"; 
$Vector["idProveedor"]["Predeterminado"]=1;

$Vector["Soporte"]["Link"]=1;   //Indico que esta columna tendra un vinculo

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>