<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Facturacion.class.php");
include_once("../clases/AcuerdoPago.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Facturacion($idUser);
    $obAcuerdo = new AcuerdoPago($idUser);
    switch ($_REQUEST["Accion"]) {
                
        case 1://Dibuja un acuerdo de pago existente
            $key=$obCon->normalizar($_REQUEST["TxtBuscarAcuerdo"]);
            
            $sql="SELECT t1.*,
                    (SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t3 WHERE t3.idUsuarios=t1.idUser) as NombreUsuario,
                    (SELECT RazonSocial FROM clientes t4 WHERE t4.Num_Identificacion=t1.Tercero LIMIT 1) as NombreTercero
                    FROM acuerdo_pago t1 
                    WHERE t1.Tercero = 
                    (SELECT t2.Num_Identificacion FROM clientes t2 WHERE t2.RazonSocial LIKE '%$key%' or Num_Identificacion='$key' LIMIT 1) AND Estado=1";
            $Consulta=$obAcuerdo->Query($sql);
            print("<br><br>");
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                    
                    $css->ColTabla("<strong>ID</strong>", 1);
                    $css->ColTabla("<strong>Abonar</strong>", 1);
                    $css->ColTabla("<strong>Imprimir</strong>", 1);
                    $css->ColTabla("<strong>Ver</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
                    $css->ColTabla("<strong>Valor Cuota General</strong>", 1);
                    //$css->ColTabla("<strong>CicloPagos</strong>", 1);
                    $css->ColTabla("<strong>Saldo Anterior</strong>", 1);
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                    $css->ColTabla("<strong>Saldo Inicial</strong>", 1);
                    $css->ColTabla("<strong>Total Abonos</strong>", 1);
                    $css->ColTabla("<strong>Saldo Final</strong>", 1);
                    $css->ColTabla("<strong>Usuario</strong>", 1);
                    
                $css->CierraFilaTabla();
            
                while($DatosAcuerdo=$obAcuerdo->FetchAssoc($Consulta)){
                    $idAcuerdo=$DatosAcuerdo["idAcuerdoPago"];
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosAcuerdo["ID"], 1);
                        print("<td style='text-align:center'>");
                            
                            print('<span class="input-group-btn">
                                <button type="button" class="btn btn-warning btn-flat" onclick=TotalAbonoAcuerdo=0;FormularioAbonarAcuerdoPago(`'.$idAcuerdo.'`)> <i class="fa fa-plus"> </i> </button>
                              </span> ');
                        print("</td>");  
                        print("<td style='text-align:center'>");    
                            print('<span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat" onclick=ImprimirAcuerdoPago(`'.$idAcuerdo.'`)> <i class="fa fa-print"> </i> </button>
                              </span>');
                        print("</td>");  
                        print("<td style='text-align:center'>");        
                            print('<span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-flat" onclick=DibujarAcuerdoPagoExistente(`'.$idAcuerdo.'`)> <i class="fa fa-eye"> </i> </button>
                              </span>');
                                
                        print("</td>");
                        $css->ColTabla($DatosAcuerdo["Tercero"]." ".$DatosAcuerdo["NombreTercero"], 1);
                        $css->ColTabla($DatosAcuerdo["Fecha"], 1);
                        $css->ColTabla($DatosAcuerdo["FechaInicialParaPagos"], 1);
                        $css->ColTabla(number_format($DatosAcuerdo["ValorCuotaGeneral"]), 1);
                        //$css->ColTabla($DatosAcuerdo["CicloPagos"], 1);
                        $css->ColTabla(number_format($DatosAcuerdo["SaldoAnterior"]), 1);
                        $css->ColTabla($DatosAcuerdo["Observaciones"], 1);
                        $css->ColTabla(number_format($DatosAcuerdo["SaldoInicial"]), 1);
                        $css->ColTabla(number_format($DatosAcuerdo["TotalAbonos"]), 1);
                        $css->ColTabla("<h3>".number_format($DatosAcuerdo["SaldoFinal"])."</h3>", 1);
                        $css->ColTabla($DatosAcuerdo["NombreUsuario"], 1);

                    $css->CierraFilaTabla();
                }
                
            $css->CerrarTabla();
        break;// fin caso 1
        
        case 2:// Dibuja el formulario para realizar un abono
            $idAcuerdo=$obAcuerdo->normalizar($_REQUEST["idAcuerdo"]);
            
            $DatosAcuerdo=$obAcuerdo->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            $Mensaje="<strong>Realizar un abono al acuerdo $DatosAcuerdo[ID], del tercero $DatosAcuerdo[Tercero]</strong>";
            $css->CrearTitulo($Mensaje, "verde");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 5, "", "", "", "");
            $css->input("hidden", "idAcuerdoAbono", "", "idAcuerdoAbono", "", $DatosAcuerdo["idAcuerdoPago"], "", "", "", "");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Metodo de pago</strong>", 1);
                    $css->ColTabla("<strong>Valor del Abono</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        $css->select("CmbMetodoPagoAbonoAcuerdo", "form-control", "CmbMetodoPagoAbonoAcuerdo", "", "", "", "");
                            $sql="SELECT * FROM metodos_pago WHERE Estado=1";
                            $Consulta=$obAcuerdo->Query($sql);
                            while($DatosMetodo=$obAcuerdo->FetchAssoc($Consulta)){
                                $css->option("", "form-control", "", $DatosMetodo["ID"], "", "");
                                    print($DatosMetodo["Metodo"]);
                                $css->Coption();
                            }   
                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->input("number", "TxtValorAbonoAcuerdoExistente", "form-control", "TxtValorAbonoAcuerdoExistente", "", $DatosAcuerdo["ValorCuotaGeneral"], "Valor de la Cuota", "off", "", "");
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print('
                          <button type="button" id="BtnGuardarAbonoAcuerdo" class="btn btn-success btn-flat" onclick=ConfirmarAbonoAcuerdoPago(`'.$idAcuerdo.'`)><i class="fa fa-save"></i></button>
                        ');
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
            $css->CrearDiv("DivHistorialPagosAcuerdo", "", "left", 1, 1);
                
            $css->CerrarDiv();
                    
            
            
        break;//Fin caso 2  
        
        case 3://Dibuja el historial de pagos de un acuerdo
            $idAcuerdo=$obAcuerdo->normalizar($_REQUEST["idAcuerdo"]);
            $TotalCuotasPendientes=0;
            $TotalPagos=0;
            $obAcuerdo->ActualiceEstadosProyeccionPagos($idAcuerdo);
            $css->CrearDiv("", "col-md-6", "left", 1, 1);
                $css->CrearTitulo("<strong>CUOTAS PENDIENTES</strong>", "naranja");
                $css->CrearTabla();
                    
                    
                    $css->FilaTabla(16);
                        //$css->ColTabla("<strong>TipoCuota</strong>", 1, "C");
                        $css->ColTabla("<strong>Numero de Cuota</strong>", 1, "C");
                        $css->ColTabla("<strong>Fecha</strong>", 1, "C");
                        $css->ColTabla("<strong>Valor</strong>", 1, "C");
                        $css->ColTabla("<strong>Pagos</strong>", 1, "C");
                        $css->ColTabla("<strong>Saldo</strong>", 1, "C");
                        $css->ColTabla("<strong>Pago Individual</strong>", 1, "C");
                        $css->ColTabla("<strong>Estado</strong>", 1, "C");
                    $css->CierraFilaTabla();
                    
                    
                    $sql="SELECT t1.*,
                            (SELECT t2.NombreTipoCuota FROM acuerdo_pago_tipo_cuota t2 WHERE t2.ID=t1.TipoCuota) AS NombreTipoCuota,
                            (SELECT t3.NombreEstado FROM acuerdo_pago_proyeccion_estados t3 WHERE t3.ID=t1.Estado) AS NombreEstado
                            FROM acuerdo_pago_proyeccion_pagos t1 WHERE idAcuerdoPago='$idAcuerdo' AND (Estado=0 OR Estado=2 OR Estado=4 ) ORDER BY Fecha ASC";
                    $Consulta=$obAcuerdo->Query($sql);
                    
                    while($DatosCuotas=$obAcuerdo->FetchAssoc($Consulta)){
                        $idCuota=$DatosCuotas["ID"];
                        $TotalCuotasPendientes=$TotalCuotasPendientes+$DatosCuotas["ValorCuota"]-$DatosCuotas["ValorPagado"];
                        $css->FilaTabla(16);
                            //$css->ColTabla($DatosCuotas["NombreTipoCuota"], 1);
                            $css->ColTabla($DatosCuotas["NumeroCuota"], 1);
                            $css->ColTabla($DatosCuotas["Fecha"], 1);
                            $css->ColTabla(number_format($DatosCuotas["ValorCuota"]), 1);
                            $css->ColTabla(number_format($DatosCuotas["ValorPagado"]), 1);
                            $css->ColTabla(number_format($DatosCuotas["ValorCuota"]-$DatosCuotas["ValorPagado"]), 1);
                            print("<td style=text-align:center>");
                                print('<span class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-flat" onclick=AbonarCuotaAcuerdoIndividual(`'.$idAcuerdo.'`,`'.$idCuota.'`)> <i class="fa fa-plus"> </i> </button>
                                  </span> ');
                            print("</td>");
                            $css->ColTabla($DatosCuotas["NombreEstado"], 1);
                        $css->CierraFilaTabla();
                    }
                    
                    
                $css->CerrarTabla();
            $css->CerrarDiv();
            
            
            $css->CrearDiv("", "col-md-6", "left", 1, 1);
                $css->CrearTitulo("<strong>CUOTAS PAGADAS EN SU TOTALIDAD</strong>", "verde");
                $css->CrearTabla();
                    
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TipoCuota</strong>", 1, "C");
                        $css->ColTabla("<strong>Numero de Cuota</strong>", 1, "C");
                        $css->ColTabla("<strong>Fecha</strong>", 1, "C");
                        $css->ColTabla("<strong>Valor</strong>", 1, "C");
                        $css->ColTabla("<strong>Pagos</strong>", 1, "C");
                        $css->ColTabla("<strong>Fecha Pago</strong>", 1, "C");
                        $css->ColTabla("<strong>Estado</strong>", 1, "C");
                    $css->CierraFilaTabla();
                    
                    
                    $sql="SELECT t1.*,
                            (SELECT t2.NombreTipoCuota FROM acuerdo_pago_tipo_cuota t2 WHERE t2.ID=t1.TipoCuota) AS NombreTipoCuota,
                            (SELECT t3.NombreEstado FROM acuerdo_pago_proyeccion_estados t3 WHERE t3.ID=t1.Estado) AS NombreEstado,
                            (SELECT t4.FechaPago FROM acuerdo_pago_cuotas_pagadas t4 WHERE t4.ID=t1.idPago LIMIT 1) AS FechaPago
                            FROM acuerdo_pago_proyeccion_pagos t1 WHERE idAcuerdoPago='$idAcuerdo' AND (Estado=1 OR Estado=3 ) ORDER BY NumeroCuota DESC";
                    $Consulta=$obAcuerdo->Query($sql);
                    
                    while($DatosCuotas=$obAcuerdo->FetchAssoc($Consulta)){
                        $TotalPagos=$TotalPagos+$DatosCuotas["ValorPagado"];
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosCuotas["NombreTipoCuota"], 1);
                            $css->ColTabla($DatosCuotas["NumeroCuota"], 1);
                            $css->ColTabla($DatosCuotas["Fecha"], 1);
                            $css->ColTabla(number_format($DatosCuotas["ValorCuota"]), 1);
                            $css->ColTabla(number_format($DatosCuotas["ValorPagado"]), 1);
                            $css->ColTabla($DatosCuotas["FechaPago"], 1);
                            $css->ColTabla($DatosCuotas["NombreEstado"], 1);
                        $css->CierraFilaTabla();
                    }
                    
                    
                $css->CerrarTabla();
                $css->CrearTabla(); 
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTALES</strong>",2,'C');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTAL CUOTAS PENDIENTES</strong>", 1,'C');
                        $css->ColTabla("<strong>TOTAL CUOTAS PAGADAS</strong>", 1,'C');
                        
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla(number_format($TotalCuotasPendientes), 1,'C');
                        $css->ColTabla(number_format($TotalPagos), 1,'C');
                        
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
            $css->CerrarDiv();
        break;//Fin caso 3    
         
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>