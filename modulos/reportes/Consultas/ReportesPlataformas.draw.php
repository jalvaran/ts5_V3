<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/ReportesComparativos.class.php");
//include_once("../clases/PDF_ReportesContables.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Reportes($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //Dibuja la tabla con los abonos realizados
            $Plataforma=$obCon->normalizar($_REQUEST["Plataforma"]);
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $css->CrearTitulo("<strong>ABONOS RECIBIDOS</strong>", "azul");
            $css->CrearDiv("DivTabla", "col-md-12", "center", 1, 1);
            $css->CrearBotonEvento("BtnExportar", "Exportar", 1, "onclick", "ExportarTablaToExcel('TblReporteIngresos')", "verde", "");
                $css->CrearTabla("TblReporteIngresos");
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>Fecha</strong>", 1,"C");
                        $css->ColTabla("<strong>Inicial</strong>", 1,"C");
                        $css->ColTabla("<strong>Hora</strong>", 1,"C");
                        $css->ColTabla("<strong>Tercero</strong>", 1,"C");
                        $css->ColTabla("<strong>Valor</strong>", 1,"C");
                        $css->ColTabla("<strong>Metodo Pago</strong>", 1,"C");
                        $css->ColTabla("<strong>Anular</strong>", 1,"C");
                        $css->ColTabla("<strong>Usuario que anula</strong>", 1,"C");
                        $css->ColTabla("<strong>Fecha de Anulacion</strong>", 1,"C");
                        $css->ColTabla("<strong>Valor Anulado</strong>", 1,"C");
                                                
                    $css->CierraFilaTabla();
                    $sql="SELECT ID,usuario_anulacion,fecha_anulacion,valor_anulado,Fecha,Hora,Inicial,Tercero,round(Valor) as Valor,(SELECT Metodo FROM metodos_pago t2 where t2.ID=comercial_plataformas_pago_ingresos.metodo_pago_id LIMIT 1 ) as nombre_metodo_pago "
                            . "FROM comercial_plataformas_pago_ingresos "
                            . "WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND idPlataformaPago='$Plataforma'";
                    $Consulta=$obCon->Query($sql);
                    
                    while ($DatosIngresos = $obCon->FetchAssoc($Consulta)) {
                        $idItem=$DatosIngresos["ID"];
                        $css->FilaTabla(14);
                            $css->ColTabla($DatosIngresos["Fecha"], 1);
                            $css->ColTabla($DatosIngresos["Inicial"], 1);
                            $css->ColTabla($DatosIngresos["Hora"], 1);
                            $css->ColTabla($DatosIngresos["Tercero"], 1);
                            $css->ColTabla($DatosIngresos["Valor"], 1);
                            $css->ColTabla($DatosIngresos["nombre_metodo_pago"], 1);
                            print("<td style='font-size:16px;text-align:center;color:red' title='Anular'>");   
                            
                                $css->li("", "fa  fa-remove", "", "onclick=confirma_anular_abono(`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                                $css->Cli();
                            print("</td>");
                            $css->ColTabla($DatosIngresos["usuario_anulacion"], 1);
                            $css->ColTabla($DatosIngresos["fecha_anulacion"], 1);
                            $css->ColTabla($DatosIngresos["valor_anulado"], 1);
                            
                        $css->CierraFilaTabla();
                    }    
                    
                $css->CerrarTabla();
            $css->CerrarDiv();  
            unset($DatosIngresos);
                       
            
        break; //Fin caso 1
        
        case 2: //Reporte de ventas de siste credito
            $Plataforma=$obCon->normalizar($_REQUEST["Plataforma"]);
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $css->CrearTitulo("<strong>REPORTE DE VENTAS</strong>", "verde");
            $css->CrearDiv("DivTabla", "col-md-12", "center", 1, 1);
            $css->CrearBotonEvento("BtnExportar", "Exportar", 1, "onclick", "ExportarTablaToExcel('TblReporteVentas')", "verde", "");
                $css->CrearTabla("TblReporteVentas");
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>Fecha</strong>", 1,"C");
                        $css->ColTabla("<strong>Hora</strong>", 1,"C");
                        $css->ColTabla("<strong>Tercero</strong>", 1,"C");
                        $css->ColTabla("<strong>Valor</strong>", 1,"C");
                                                
                    $css->CierraFilaTabla();
                    $sql="SELECT Fecha,Hora,Tercero,round(Valor) as Valor FROM comercial_plataformas_pago_ventas "
                            . "WHERE Fecha>='$FechaInicial' AND Fecha<='$FechaFinal' AND idPlataformaPago='$Plataforma'";
                    $Consulta=$obCon->Query($sql);
                    
                    while ($DatosVentas = $obCon->FetchAssoc($Consulta)) {
                        $css->FilaTabla(14);
                            $css->ColTabla($DatosVentas["Fecha"], 1);
                            $css->ColTabla($DatosVentas["Hora"], 1);
                            $css->ColTabla($DatosVentas["Tercero"], 1);
                            $css->ColTabla($DatosVentas["Valor"], 1);
                            
                        $css->CierraFilaTabla();
                    }    
                    
                $css->CerrarTabla();
            $css->CerrarDiv();  
            unset($DatosIngresos);
        break; //Fin caso 2
        
        
    
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>