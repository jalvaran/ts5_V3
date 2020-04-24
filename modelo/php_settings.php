<?php
/* 
 * Aqui se establecen los datos de conexion a la base de datos
 */

$host="localhost";
$user="root";
$pw="pirlo1985";
$db="sup_oriente_sas";
 
const HOST="localhost", USER="root",PW="pirlo1985",DB="sup_oriente_sas";//para uso 

/* Para un servidor la combinacion deberá ser $TipoPC="Server"; $TipoKardex="Caja";
 * Para una Caja la combinacion deberá ser $TipoPC="Caja"; $TipoKardex="Caja";
 * Para un ServidorCaja la combinacion deberá ser $TipoPC="Caja"; $TipoKardex="Automatico";
 */
$TipoPC="Caja";         // Server para que al abrir el menu un timer registre las facturas en el libro diario y en el kardex, Caja para la otra opcion
$TipoKardex="Caja"; // Servidor se contabilizan las facturas pos desde el menu, Caja desde el pos
$PrintAutomatico="SI";    //IMPRIME LAS FACTURAS POS AUTOMATICAMENTE SI ES SI, SI ES NO NO IMPRIME FACTURA POR POR DEFECTO

?>