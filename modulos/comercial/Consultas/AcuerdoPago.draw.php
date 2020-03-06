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
                    $css->ColTabla("<strong>PDF</strong>", 1);
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
                    $css->ColTabla("<strong>Estado</strong>", 1);
                    $css->ColTabla("<strong>Usuario</strong>", 1);
                    
                $css->CierraFilaTabla();
            
                while($DatosAcuerdo=$obAcuerdo->FetchAssoc($Consulta)){
                    $idAcuerdo=$DatosAcuerdo["idAcuerdoPago"];
                    $EstadoAcuerdo=$obAcuerdo->ObtengaEstadoGeneralAcuerdo($idAcuerdo);
                    $EstadoGeneral="AL DIA";
                    if($EstadoAcuerdo==4){
                        $EstadoGeneral="EN MORA";
                    }
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
                                <button type="button" class="btn btn-success btn-flat" onclick=DibujarAcuerdoPagoExistente(`'.$idAcuerdo.'`,`DivBusquedasPOS`)> <i class="fa fa-eye"> </i> </button>
                              </span>');
                                
                        print("</td>");
                        print("<td style='text-align:center'>");        
                            print('<span class="input-group-btn">
                                <a class="btn btn-danger btn-flat" href="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=37&idAcuerdo='.$idAcuerdo.'&EstadoGeneral='.$EstadoAcuerdo.'" target="_blank"> <i class="fa fa-file-pdf-o"> </i> </a>
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
                        $css->ColTabla($EstadoGeneral, 1);
                        $css->ColTabla($DatosAcuerdo["NombreUsuario"], 1);

                    $css->CierraFilaTabla();
                }
                
            $css->CerrarTabla();
        break;// fin caso 1
        
        case 2:// Dibuja el formulario para realizar un abono
            $idAcuerdo=$obAcuerdo->normalizar($_REQUEST["idAcuerdo"]);
            
            $DatosAcuerdo=$obAcuerdo->DevuelveValores("acuerdo_pago", "idAcuerdoPago", $idAcuerdo);
            $Tercero=$DatosAcuerdo["Tercero"];
            $Parametros=$obAcuerdo->DevuelveValores("parametros_contables", "ID", 36);//Saldos a favor de clientes
            $CuentaPUCSaldoFavor=$Parametros["CuentaPUC"];
            $sql="SELECT SUM(Debito-Credito) as Saldo  FROM librodiario WHERE Tercero_Identificacion='$Tercero' AND CuentaPUC='$CuentaPUCSaldoFavor'";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $SaldoAFavor=($Totales["Saldo"])*(-1);
            
            $Parametros=$obAcuerdo->DevuelveValores("parametros_contables", "ID", 35);//anticipos de clientes
            $CuentaPUCSaldoFavor=$Parametros["CuentaPUC"];
            $sql="SELECT SUM(Debito-Credito) as Saldo  FROM librodiario WHERE Tercero_Identificacion='$Tercero' AND CuentaPUC='$CuentaPUCSaldoFavor'";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $Anticipos=($Totales["Saldo"])*(-1);
            
            
            $Mensaje="<strong>Realizar un abono al acuerdo $DatosAcuerdo[ID], del tercero $DatosAcuerdo[Tercero]</strong>";
            if($SaldoAFavor<>0){
                $Mensaje.=", Saldo a Favor: <strong>". number_format(ABS($SaldoAFavor))."</strong>";
            }
            if($Anticipos<>0){
                $Mensaje.=", Anticipos: <strong>". number_format(ABS($Anticipos))."</strong>";
            }
            $css->CrearTitulo($Mensaje, "verde");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 5, "", "", "", "");
            $css->input("hidden", "idAcuerdoAbono", "", "idAcuerdoAbono", "", $DatosAcuerdo["idAcuerdoPago"], "", "", "", "");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Metodo de pago</strong>", 1);
                    $css->ColTabla("<strong>Valor del Abono</strong>", 1);
                    $css->ColTabla("<strong>Recargos o Intereses</strong>", 1);
                    $css->ColTabla("<strong>Abonar</strong>", 1);
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
                    print("<td>");
                        $css->input("number", "TxtRecargosIntereses", "form-control", "TxtRecargosIntereses", "", "0", "Recargos o intereses", "off", "", "");
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
                        $css->ColTabla("<strong>ID</strong>", 1, "C");
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
                            $css->ColTabla($DatosCuotas["ID"], 1);
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
            
            $css->CrearDiv("", "col-md-6", "left", 1, 1);
                $css->CrearTitulo("<strong>HISTORIAL DE ABONOS</strong>", "verde");
                $css->CrearTabla();
                    
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>CUOTA</strong>", 1, "C");
                        $css->ColTabla("<strong>FECHA</strong>", 1, "C");
                        $css->ColTabla("<strong>TIPO CUOTA</strong>", 1, "C");
                        $css->ColTabla("<strong>VALOR</strong>", 1, "C");
                        $css->ColTabla("<strong>METODO</strong>", 1, "C");
                        $css->ColTabla("<strong>USUARIO QUE RECIBE</strong>", 1, "C");
                        
                    $css->CierraFilaTabla();
                    
                    
                    $sql="SELECT t1.*,
                    (SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t3 WHERE t3.idUsuarios=t1.idUser) AS NombreUsuario,
                    (SELECT t2.NombreTipoCuota FROM acuerdo_pago_tipo_cuota t2 WHERE t2.ID=t1.TipoCuota) AS NombreTipoCuota,                           
                    (SELECT t4.Metodo FROM metodos_pago t4 WHERE t4.ID=t1.MetodoPago LIMIT 1) AS NombreMetodoPago
                    FROM acuerdo_pago_cuotas_pagadas t1 WHERE idAcuerdoPago='$idAcuerdo' ORDER BY Created ASC";
                    $Consulta=$obAcuerdo->Query($sql);
                    $TotalPagos=0;
                    while($DatosCuotas=$obAcuerdo->FetchAssoc($Consulta)){
                        $TotalPagos=$TotalPagos+$DatosCuotas["ValorPago"];
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosCuotas["NumeroCuota"], 1);
                            $css->ColTabla($DatosCuotas["Created"], 1);
                            $css->ColTabla($DatosCuotas["NombreTipoCuota"], 1);
                            $css->ColTabla(number_format($DatosCuotas["ValorPago"]), 1);
                            $css->ColTabla(($DatosCuotas["NombreMetodoPago"]), 1);
                            $css->ColTabla($DatosCuotas["NombreUsuario"], 1);
                            
                        $css->CierraFilaTabla();
                    }
                    
                    
                $css->CerrarTabla();
                
                
            $css->CerrarDiv();
            
        break;//Fin caso 3    
        
        case 4://Dibuja un acuerdo de pago por completo
            
            $idAcuerdo=$obAcuerdo->normalizar($_REQUEST["idAcuerdo"]);
            $sql="SELECT t1.*, 
                (SELECT CONCAT(RazonSocial) FROM clientes t2 WHERE t2.Num_Identificacion=t1.Tercero LIMIT 1) AS NombreCliente, 
                (SELECT t3.NombreCiclo FROM acuerdo_pago_ciclos_pagos t3 WHERE t3.ID=t1.CicloPagos) AS NombreCicloPago,
                (SELECT t4.NombreEstado FROM acuerdo_pago_estados t4 WHERE t4.ID=t1.Estado) AS NombreEstado
                
                FROM acuerdo_pago t1 WHERE idAcuerdoPago='$idAcuerdo'";
        
            $DatosAcuerdo= $obAcuerdo->FetchAssoc($obAcuerdo->Query($sql));
            print("<br><br>");
            $css->CrearTitulo("Acuerdo de pago con: ".$DatosAcuerdo["NombreCliente"]." ".$DatosAcuerdo["Tercero"], "rojo");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Datos Generales</strong>", 6,'C');
                   
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Ciclo de pagos</strong>", 1);
                    $css->ColTabla("<strong>Cuota General</strong>", 1);
                    $css->ColTabla("<strong>Saldo Inicial</strong>", 1);
                    $css->ColTabla("<strong>Total Abonos</strong>", 1);
                    $css->ColTabla("<strong>Saldo Actual</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla($DatosAcuerdo["Fecha"], 1);
                    $css->ColTabla($DatosAcuerdo["NombreCicloPago"], 1);
                    $css->ColTabla(number_format($DatosAcuerdo["ValorCuotaGeneral"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoInicial"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["TotalAbonos"]), 1);
                    $css->ColTabla(number_format($DatosAcuerdo["SaldoFinal"]), 1);
                $css->CierraFilaTabla();
            $TotalCuotasPendientes =0;    
            $TotalPagos =0;    
            $css->CerrarTabla();
            
            $css->CrearDiv("", "col-md-12", "left", 1, 1);
                $css->CrearTitulo("<strong>CUOTAS PENDIENTES</strong>", "naranja");
                $css->CrearTabla();
                    
                    
                    $css->FilaTabla(16);
                        //$css->ColTabla("<strong>TipoCuota</strong>", 1, "C");
                        $css->ColTabla("<strong>Numero de Cuota</strong>", 1, "C");
                        $css->ColTabla("<strong>Fecha</strong>", 1, "C");
                        $css->ColTabla("<strong>Valor</strong>", 1, "C");
                        $css->ColTabla("<strong>Pagos</strong>", 1, "C");
                        $css->ColTabla("<strong>Saldo</strong>", 1, "C");
                        //$css->ColTabla("<strong>Pago Individual</strong>", 1, "C");
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
                            
                            $css->ColTabla($DatosCuotas["NombreEstado"], 1);
                        $css->CierraFilaTabla();
                    }
                    
                    
                $css->CerrarTabla();
            $css->CerrarDiv();
            
            
            $css->CrearDiv("", "col-md-12", "left", 1, 1);
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
            
            
            $css->CrearDiv("", "col-md-12", "left", 1, 1);
                $css->CrearTitulo("<strong>HISTORIAL DE PAGOS</strong>", "verde");
                $css->CrearTabla();
                    
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Fecha de Pago</strong>", 1, "C");
                        $css->ColTabla("<strong>Tipo de Cuota</strong>", 1, "C");
                        $css->ColTabla("<strong>Valor del pago</strong>", 1, "C");
                        $css->ColTabla("<strong>Metodo de pago</strong>", 1, "C");
                        $css->ColTabla("<strong>Usuario que recibió</strong>", 1, "C");
                        
                    $css->CierraFilaTabla();
                    
                    
                    $sql="SELECT t1.*,
                            (SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t2 WHERE t2.idUsuarios=t1.idUser) AS NombreUsuario,
                            (SELECT (Metodo) FROM metodos_pago t3 WHERE t3.ID=t1.MetodoPago) AS NombreMetodo,
                            (SELECT (NombreTipoCuota) FROM acuerdo_pago_tipo_cuota t4 WHERE t4.ID=t1.TipoCuota) AS NombreTipoCuota
                            FROM acuerdo_pago_cuotas_pagadas t1 WHERE idAcuerdoPago='$idAcuerdo' ORDER BY Created DESC";
                    $Consulta=$obAcuerdo->Query($sql);
                    $TotalPagos=0;
                    while($DatosCuotas=$obAcuerdo->FetchAssoc($Consulta)){
                        $TotalPagos=$TotalPagos+$DatosCuotas["ValorPago"];
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosCuotas["Created"], 1);
                            $css->ColTabla($DatosCuotas["NombreTipoCuota"], 1);
                            
                            $css->ColTabla(number_format($DatosCuotas["ValorPago"]), 1);
                            
                            $css->ColTabla($DatosCuotas["NombreMetodo"], 1);
                            $css->ColTabla($DatosCuotas["NombreUsuario"], 1);
                        $css->CierraFilaTabla();
                    }
                    
                    
                $css->CerrarTabla();
                $css->CrearTabla(); 
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTALES</strong>",2,'C');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTAL CUOTAS PENDIENTES</strong>", 1,'C');
                        $css->ColTabla("<strong>TOTAL PAGOS</strong>", 1,'C');
                        
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla(number_format($TotalCuotasPendientes), 1,'C');
                        $css->ColTabla(number_format($TotalPagos), 1,'C');
                        
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
            $css->CerrarDiv();
            
        break;//Fin caso 4    
        
        case 5://Dibuja el formulario para agregar los datos adicionales de un cliente
            $idCliente=$obAcuerdo->normalizar($_REQUEST["idCliente"]);
            
            if($idCliente==""){
                $css->CrearTitulo("<strong>NO SE RECIBIÓ EL ID DEL CLIENTE</strong>", "rojo");
                exit();
            }
            $DatosCliente=$obAcuerdo->DevuelveValores("clientes", "idClientes", $idCliente);
            $DatosAdicionalesCliente=$obAcuerdo->DevuelveValores("clientes_datos_adicionales", "idCliente", $idCliente);
            $css->CrearDiv("DivFormularioDatosAdicionalesCliente", "", "center", 1, 1);
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>DATOS ADICIONALES DE: </strong>". utf8_encode($DatosCliente["RazonSocial"])." ".$DatosCliente["Num_Identificacion"], 2);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Sobre Nombre</strong>", 2);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td colspan=2>");
                            $css->input("text", "SobreNombre", "form-control", "SobreNombre", "Sobre nombre", $DatosAdicionalesCliente["SobreNombre"], "Sobre Nombre", "off", "", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>Lugar de Trabajo</strong>", 1);
                        $css->ColTabla("<strong>Cargo</strong>", 1);
                        
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        
                        print("<td>");
                            $css->input("text", "LugarTrabajo", "form-control", "LugarTrabajo", "Sobre nombre", $DatosAdicionalesCliente["LugarTrabajo"], "Lugar Trabajo", "off", "", "");
                        print("</td>");
                        print("<td>");
                            $css->input("text", "Cargo", "form-control", "Cargo", "Sobre nombre", $DatosAdicionalesCliente["Cargo"], "Cargo", "off", "", "");
                        print("</td>");
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Direccion del Trabajo</strong>", 1);
                        $css->ColTabla("<strong>Telefono Trabajo</strong>", 1);
                        
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td>");
                            $css->input("text", "DireccionTrabajo", "form-control", "DireccionTrabajo", "Direccion Trabajo", $DatosAdicionalesCliente["DireccionTrabajo"], "Direccion Trabajo", "off", "", "");
                        print("</td>");
                        print("<td>");
                            $css->input("text", "TelefonoTrabajo", "form-control", "TelefonoTrabajo", "Telefono Trabajo", $DatosAdicionalesCliente["TelefonoTrabajo"], "Telefono Trabajo", "off", "", "");
                        print("</td>");
                        
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Facebook</strong>", 1);
                        $css->ColTabla("<strong>Instagram</strong>", 1);
                        
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td>");
                            $css->input("text", "TxtFacebook", "form-control", "TxtFacebook", "Facebooko", $DatosAdicionalesCliente["Facebook"], "Facebook", "off", "", "");
                        print("</td>");
                        print("<td>");
                            $css->input("text", "TxtInstagram", "form-control", "TxtInstagram", "Instagram", $DatosAdicionalesCliente["Instagram"], "Instagram", "off", "", "");
                        print("</td>");
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td colspan=2>");
                            $css->CrearBotonEvento("BtnGuardarDatosAdicionalesCliente", "Guardar", 1, "onclick", "GuardarDatosAdicionalesCliente(`$idCliente`)", "azul");
                        print("</td>");
                                                
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
            $css->CerrarDiv();
            
            
        break;//Fin caso 5    
        
        case 6://Dibuja el formulario para agregar los recomendados de un cliente
            $idCliente=$obAcuerdo->normalizar($_REQUEST["idCliente"]);
            
            if($idCliente==""){
                $css->CrearTitulo("<strong>NO SE RECIBIÓ EL ID DEL CLIENTE</strong>", "rojo");
                exit();
            }
            $DatosCliente=$obAcuerdo->DevuelveValores("clientes", "idClientes", $idCliente);
            
            $css->CrearDiv("DivFormularioRecomendadosCliente", "", "center", 1, 1);
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>AGREGAR RECOMENDADO DE: </strong>". utf8_encode($DatosCliente["RazonSocial"])." ".$DatosCliente["Num_Identificacion"], 2);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Nombre del Recomendado</strong>", 2);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td colspan=2>");
                            $css->input("text", "NombreRecomendado", "form-control", "NombreRecomendado", "Nombre Recomendado", "", "Nombre Recomendado", "off", "", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>Direccion</strong>", 1);
                        $css->ColTabla("<strong>Telefono</strong>", 1);
                        
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        
                        print("<td>");
                            $css->input("text", "DireccionRecomendado", "form-control", "DireccionRecomendado", "Direccion Recomendado", "", "Direccion Recomendado", "off", "", "");
                        print("</td>");
                        print("<td>");
                            $css->input("text", "TelefonoRecomendado", "form-control", "TelefonoRecomendado", "Telefono Recomendado", "", "Telefono Recomendado", "off", "", "");
                        print("</td>");
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Direccion del Trabajo</strong>", 1);
                        $css->ColTabla("<strong>Telefono Trabajo</strong>", 1);
                        
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td>");
                            $css->input("text", "DireccionTrabajoRecomendado", "form-control", "DireccionTrabajoRecomendado", "Direccion Trabajo", "", "Direccion Trabajo", "off", "", "");
                        print("</td>");
                        print("<td>");
                            $css->input("text", "TelefonoTrabajoRecomendado", "form-control", "TelefonoTrabajoRecomendado", "Telefono Trabajo", "", "Telefono Trabajo", "off", "", "");
                        print("</td>");
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td colspan=2>");
                            $css->CrearBotonEvento("BtnGuardarRecomendadosCliente", "Guardar", 1, "onclick", "GuardarRecomendadosCliente(`$idCliente`)", "naranja");
                        print("</td>");
                                                
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
            $css->CerrarDiv();
            
            $css->CrearDiv("DivRecomendadosExistentes", "", "center", 1, 1);
                
            $css->CerrarDiv();
            
        break;//Fin caso 6
        
        case 7://Dibuja los recomendados de un cliente
            $idCliente=$obAcuerdo->normalizar($_REQUEST["idCliente"]);
            $css->CrearTitulo("<strong>RECOMENDADOS DE ESTE CLIENTE:</strong>", "naranja");
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>NOMBRE</strong>", 1,"C");
                    $css->ColTabla("<strong>DIRECCIÓN</strong>", 1,"C");
                    $css->ColTabla("<strong>TELEFONO</strong>", 1,"C");
                    $css->ColTabla("<strong>DIRECCION DE TRABAJO</strong>", 1,"C");
                    $css->ColTabla("<strong>TELEFONO DEL TRABAJO</strong>", 1,"C");
                    
                $css->CierraFilaTabla();
                
                $sql="SELECT * FROM clientes_recomendados WHERE idCliente='$idCliente' ORDER BY ID DESC";
                $Consulta=$obAcuerdo->Query($sql);
                while($DatosRecomendado=$obAcuerdo->FetchAssoc($Consulta)){
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosRecomendado["NombreRecomendado"], 1);
                        $css->ColTabla($DatosRecomendado["DireccionRecomendado"], 1);
                        $css->ColTabla($DatosRecomendado["TelefonoRecomendado"], 1);
                        $css->ColTabla($DatosRecomendado["DireccionTrabajoRecomendado"], 1);
                        $css->ColTabla($DatosRecomendado["TelefonoTrabajoRecomendado"], 1);

                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
        break;//Fin caso 7    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>