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
    $sql="SELECT Role FROM usuarios WHERE idUsuarios='$idUser'";
    $DatosUsuario=$obCon->FetchAssoc($obCon->Query($sql));
    $userRole=$DatosUsuario["Role"];
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
            $Invoca=$obAcuerdo->normalizar($_REQUEST["Invoca"]);
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
            $ValorCuotaGeneral=$DatosAcuerdo["ValorCuotaGeneral"];
            if($Invoca==1){
                $idItemDevolucion=$obCon->normalizar($_REQUEST["idItemDevolucion"]);
                $CantidadDevolucion=$obCon->normalizar($_REQUEST["CantidadDevolucion"]);
                
                if($idItemDevolucion==''){
                    $css->CrearTitulo("No se recibió el item a Devolver", "rojo");
                    exit();
                }
                if(!is_numeric($CantidadDevolucion) or $CantidadDevolucion<=0){
                    $css->CrearTitulo("<strong>La cantidad de items a devolver debe ser mayor a cero</strong>", "rojo");
                    exit();
                }
                
                $DatosProducto=$obCon->DevuelveValores("facturas_items", "ID", $idItemDevolucion);
                $sql="SELECT sum(Cantidad) as CantidadDevoluciones FROM acuerdo_pago_productos_devueltos WHERE idFacturasItems='$idItemDevolucion'";
                $DatosConsulta=$obCon->FetchAssoc($obCon->Query($sql));
                $CantidadDevuelta=$DatosConsulta["CantidadDevoluciones"];
                if($CantidadDevuelta==''){
                    $CantidadDevuelta=0;
                }
                $CantidadDisponibleADevolver=$DatosProducto["Cantidad"]-$CantidadDevuelta;
                if($CantidadDisponibleADevolver<=0){
                    $css->CrearTitulo("<strong>Este producto no tiene cantidades disponibles para devolver</strong>",'rojo');
                    exit("");
                }
                if($CantidadDisponibleADevolver<$CantidadDevolucion){
                    $css->CrearTitulo("<strong>La cantidad digitada supera la cantidad disponible a devolver</strong>",'rojo');
                    exit("");
                }
                $ValorUnitario=round($DatosProducto["TotalItem"]/$DatosProducto["Cantidad"]);
                $ValorADevolver=$CantidadDevolucion*$ValorUnitario;
                $ValorCuotaGeneral=$ValorADevolver;
            }
            print('<button type="button" class="btn btn-success btn-flat" onclick="TotalAbonoAcuerdo=0;FormularioAbonarAcuerdoPago(`'.$DatosAcuerdo["idAcuerdoPago"].'`)"> <i class="fa fa-refresh"> </i> </button>');
            $css->CrearTitulo($Mensaje, "verde");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 5, "", "", "", "");
            $css->input("hidden", "idAcuerdoAbono", "", "idAcuerdoAbono", "", $DatosAcuerdo["idAcuerdoPago"], "", "", "", "");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Metodo de pago</strong>", 1);
                    $css->ColTabla("<strong>Valor del Abono</strong>", 1);
                    $css->ColTabla("<strong>Recargos o Intereses</strong>", 1);
                    $css->ColTabla("<strong>Abonar</strong>", 1);
                    $css->ColTabla("<strong>Imprimir</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        $css->select("CmbMetodoPagoAbonoAcuerdo", "form-control", "CmbMetodoPagoAbonoAcuerdo", "", "", "", "");
                            if($Invoca==1){//Indica que la funcion está siendo invocada por abonos desde una devolucion de un producto 
                                $sql="SELECT * FROM metodos_pago WHERE ID=12";
                            }else{
                                $sql="SELECT * FROM metodos_pago WHERE Estado=1 AND ID<>12 ";
                            }
                            
                            $Consulta=$obAcuerdo->Query($sql);
                            while($DatosMetodo=$obAcuerdo->FetchAssoc($Consulta)){
                                $css->option("", "form-control", "", $DatosMetodo["ID"], "", "");
                                    print($DatosMetodo["Metodo"]);
                                $css->Coption();
                            }   
                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->input_number_format("number", "TxtValorAbonoAcuerdoExistente", "form-control", "TxtValorAbonoAcuerdoExistente", "", $ValorCuotaGeneral, "Valor de la Cuota", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input_number_format("number", "TxtRecargosIntereses", "form-control", "TxtRecargosIntereses", "", "0", "Recargos o intereses", "off", "", "");
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print('
                          <button type="button" id="BtnGuardarAbonoAcuerdo" class="btn btn-success btn-flat" onclick=ConfirmarAbonoAcuerdoPago(`'.$idAcuerdo.'`)><i class="fa fa-save"></i></button>
                        ');
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print('<button type="button" class="btn btn-primary btn-flat" onclick="ImprimirAcuerdoPago(`'.$idAcuerdo.'`)"> <i class="fa fa-print"> </i> </button>');
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
                        $Back="";
                        if($DatosCuotas["Estado"]==4){
                            $Back="background-color:#f3351e;color:white";
                        }
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosCuotas["ID"], 1,"L",$Back);
                            $css->ColTabla($DatosCuotas["NumeroCuota"], 1,"L",$Back);
                            $css->ColTabla($DatosCuotas["Fecha"], 1,"L",$Back);
                            $css->ColTabla(number_format($DatosCuotas["ValorCuota"]), 1,"L",$Back);
                            $css->ColTabla(number_format($DatosCuotas["ValorPagado"]), 1,"L",$Back);
                            $css->ColTabla(number_format($DatosCuotas["ValorCuota"]-$DatosCuotas["ValorPagado"]), 1,"L",$Back);
                            print("<td style=text-align:center>");
                                print('<span class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-flat" onclick=AbonarCuotaAcuerdoIndividual(`'.$idAcuerdo.'`,`'.$idCuota.'`)> <i class="fa fa-plus"> </i> </button>
                                  </span> ');
                            print("</td>");
                            $css->ColTabla($DatosCuotas["NombreEstado"], 1,"L",$Back);
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
                    $css->ColTabla("<strong>Saldo Final</strong>", 1);
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
                        $css->ColTabla("<strong>Estado</strong>", 1, "C");
                        if($userRole=="SUPERVISOR"){
                            $css->ColTabla("<strong>Anular</strong>", 1, "C");
                        }
                        
                    $css->CierraFilaTabla();
                    
                    
                    $sql="SELECT t1.*,
                            (SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t2 WHERE t2.idUsuarios=t1.idUser) AS NombreUsuario,
                            (SELECT (Metodo) FROM metodos_pago t3 WHERE t3.ID=t1.MetodoPago) AS NombreMetodo,
                            (SELECT (NombreTipoCuota) FROM acuerdo_pago_tipo_cuota t4 WHERE t4.ID=t1.TipoCuota) AS NombreTipoCuota,
                            (SELECT t5.NombreEstado FROM acuerdo_pago_cuotas_pagadas_estados t5 WHERE t5.ID=t1.Estado) AS NombreEstadoAbono 
                            FROM acuerdo_pago_cuotas_pagadas t1 WHERE idAcuerdoPago='$idAcuerdo' ORDER BY Created DESC";
                    $Consulta=$obAcuerdo->Query($sql);
                    $TotalPagos=0;
                    while($DatosCuotas=$obAcuerdo->FetchAssoc($Consulta)){
                        $TotalPagos=$TotalPagos+$DatosCuotas["ValorPago"];
                        $idItem=$DatosCuotas["ID"];
                        $css->FilaTabla(16);
                            
                            $css->ColTabla($DatosCuotas["Created"], 1);
                            $css->ColTabla($DatosCuotas["NombreTipoCuota"], 1);
                            
                            $css->ColTabla(number_format($DatosCuotas["ValorPago"]), 1);
                            
                            $css->ColTabla($DatosCuotas["NombreMetodo"], 1);
                            $css->ColTabla($DatosCuotas["NombreUsuario"], 1);
                            $css->ColTabla($DatosCuotas["NombreEstadoAbono"], 1);
                            if($userRole=="SUPERVISOR"){
                                print("<td style='text-align:center'>");
                                    print('<button type="button" class="btn btn-danger btn-flat" onclick="FormularioAnularAbono(`'.$idItem.'`)"> <i class="fa fa-remove"> </i> </button>');
                                print("</td>");
                            }
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
                
                if($DatosAcuerdo["idFactura"]<>''){
                    $idFactura=$DatosAcuerdo["idFactura"];
                    $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $DatosAcuerdo["idFactura"]);
                    $NumeroFactura=$DatosFactura["NumeroFactura"];
                    $css->CrearDiv("", "col-md-12", "left", 1, 1);
                        $css->CrearTitulo("<strong>PRODUCTOS LLEVADOS EN ESTE ACUERDO POR MEDIO DE LA FACTURA $NumeroFactura</strong>", "naranja");
                        $css->CrearTabla();


                            $css->FilaTabla(16);
                                
                                $css->ColTabla("<strong>Referencia</strong>", 1, "C");
                                $css->ColTabla("<strong>Nombre</strong>", 1, "C");
                                $css->ColTabla("<strong>Cantidad</strong>", 1, "C");
                                $css->ColTabla("<strong>Total</strong>", 1, "C");

                            $css->CierraFilaTabla();


                            $sql="SELECT Referencia,Nombre,Cantidad,TotalItem
                                    FROM facturas_items WHERE idFactura='$idFactura'";
                            $Consulta=$obAcuerdo->Query($sql);
                            $Total=0;
                            while($DatosCuotas=$obAcuerdo->FetchAssoc($Consulta)){
                                $Total=$Total+$DatosCuotas["TotalItem"];
                                $css->FilaTabla(16);
                                    $css->ColTabla($DatosCuotas["Referencia"], 1);
                                    $css->ColTabla($DatosCuotas["Nombre"], 1);

                                    $css->ColTabla(number_format($DatosCuotas["Cantidad"]), 1);
                                    $css->ColTabla(number_format($DatosCuotas["TotalItem"]), 1);
                                    
                                $css->CierraFilaTabla();
                            }
                            $css->FilaTabla(16);
                                
                                $css->ColTabla("<strong>TOTAL</strong>", 3, "R");
                                
                                $css->ColTabla(number_format($Total), 1, "L");

                            $css->CierraFilaTabla();

                        $css->CerrarTabla();

                    $css->CerrarDiv();
                    
                    $css->CrearDiv("", "col-md-12", "left", 1, 1);
                        $css->CrearTitulo("<strong>PRODUCTOS DEVUELTOS EN ESTE ACUERDO</strong>", "rojo");
                        $css->CrearTabla();


                            $css->FilaTabla(16);
                                
                                $css->ColTabla("<strong>Referencia</strong>", 1, "C");
                                $css->ColTabla("<strong>Nombre</strong>", 1, "C");
                                $css->ColTabla("<strong>Cantidad</strong>", 1, "C");
                                $css->ColTabla("<strong>Total Devolucion</strong>", 1, "C");
                                $css->ColTabla("<strong>Observaciones</strong>", 1, "C");
                            $css->CierraFilaTabla();


                            $sql="SELECT t2.Referencia,t2.Nombre, t1.Cantidad,t1.ValorDevolucion,t1.Observaciones
                                    FROM acuerdo_pago_productos_devueltos t1 
                                    INNER JOIN facturas_items t2 ON t2.ID=t1.idFacturasItems 
                                    WHERE idAcuerdoPago='$idAcuerdo'";
                            $Consulta=$obAcuerdo->Query($sql);
                            $Total=0;
                            while($DatosCuotas=$obAcuerdo->FetchAssoc($Consulta)){
                                $Total=$Total+$DatosCuotas["ValorDevolucion"];
                                $css->FilaTabla(16);
                                    $css->ColTabla($DatosCuotas["Referencia"], 1);
                                    $css->ColTabla($DatosCuotas["Nombre"], 1);
                                    $css->ColTabla(number_format($DatosCuotas["Cantidad"]), 1);
                                    $css->ColTabla(number_format($DatosCuotas["ValorDevolucion"]), 1);
                                    $css->ColTabla(($DatosCuotas["Observaciones"]), 1);
                                $css->CierraFilaTabla();
                            }
                            $css->FilaTabla(16);
                                
                                $css->ColTabla("<strong>TOTAL</strong>", 3, "R");
                                
                                $css->ColTabla(number_format($Total), 1, "L");
                                $css->ColTabla(" ", 1, "R");
                            $css->CierraFilaTabla();

                        $css->CerrarTabla();

                    $css->CerrarDiv();
                    
                }else{
                    $css->CrearTitulo("Este Acuerdo no tiene una factura Asociada", "rojo");
                }
                
            $css->CerrarDiv();
            
        break;//Fin caso 4    
        
        case 5://Dibuja el formulario para agregar los datos adicionales de un cliente
            $idCliente=$obAcuerdo->normalizar($_REQUEST["idCliente"]);
            
            if($idCliente==""){
                $css->CrearTitulo("<strong>NO SE RECIBIÓ EL ID DEL CLIENTE</strong>", "rojo");
                exit();
            }
            $DatosCliente=$obAcuerdo->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
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
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
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
            $DatosCliente=$obAcuerdo->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
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
        
        case 15://Dibuja el formulario principal del acuerdo de pago
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $css->div("DivAcuerdoFlotanteTotales","", "", "", "", "", "style=position:fixed;right:10px;top:150px;z-index:100;");
                   
            $css->Cdiv();
            
            $idAcuerdo="";
            if($idPreventa<>'NA'){
                $DatosPreventa=$obCon->DevuelveValores("vestasactivas", "idVestasActivas", $idPreventa);
                $idAcuerdo=$DatosPreventa["IdentificadorUnico"];
            }
            
            
            if($idAcuerdo==''){
                $idUnicoPreventa=$obCon->getId("ap_");
                $obCon->ActualizaRegistro("vestasactivas", "IdentificadorUnico", $idUnicoPreventa, "idVestasActivas", $idPreventa);
                $idAcuerdo=$idUnicoPreventa;
                
            }
            
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
            $NIT= $DatosCliente["Num_Identificacion"];
           
            $sql="SELECT SUM(Debito - Credito) as Total FROM librodiario t2 WHERE t2.Tercero_Identificacion='$NIT' 
            AND EXISTS(SELECT 1 FROM contabilidad_parametros_cuentasxcobrar t3 WHERE t2.CuentaPUC like t3.CuentaPUC) ";
            
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $SaldoActualCliente=$Totales["Total"];
            $Cupo=$DatosCliente["Cupo"];
            
            $sql="SELECT SUM(TotalVenta) AS Total FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalPreventa=$Totales["Total"];
            
            $NuevoSaldo=$SaldoActualCliente+$TotalPreventa;
            $css->CrearTitulo("Crear Acuerdo de Pago para el Cliente <strong>$DatosCliente[RazonSocial] - $DatosCliente[Num_Identificacion]</strong>");
            
            $css->CrearDiv("", "col-md-6", "left", 1, 1);
            $css->input("text", "idAcuerdoPago", "form-control", "idAcuerdoPago", "idAcuerdoPago", $idAcuerdo, "id Acuerdo", "off", "", " disabled");
            $css->input("hidden", "SaldoActualAcuerdoPago", "form-control", "SaldoActualAcuerdoPago", "SaldoActualAcuerdoPago", $SaldoActualCliente, "", "off", "", " disabled");
            $css->input("hidden", "NuevoSaldoAcuerdoPago", "form-control", "NuevoSaldoAcuerdoPago", "NuevoSaldoAcuerdoPago", $NuevoSaldo, "", "off", "", " disabled");
                
                $css->CrearTabla();
                    $css->FilaTabla(16);                    
                        $css->ColTabla("<strong>Saldo Actual</strong>", 1);
                        $css->ColTabla("<strong>Esta venta</strong>", 1); 
                        $css->ColTabla("<strong>Cupo</strong>", 1); 
                        $css->ColTabla("<strong>Nuevo Saldo</strong>", 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);                    
                        $css->ColTabla(number_format($SaldoActualCliente), 1);
                        $css->ColTabla(number_format($TotalPreventa), 1); 
                        $css->ColTabla(number_format($Cupo), 1); 
                        $css->ColTabla("<h2>".number_format($NuevoSaldo)."</h2>", 1);
                    $css->CierraFilaTabla();
                    
            
            
            $ValorAnteriorCuota="";
            
            $sql="SELECT * FROM acuerdo_pago WHERE Tercero='$NIT' AND Estado=1";
            $DatosAcuerdoAnterior=$obCon->FetchAssoc($obCon->Query($sql));
            $disabledBtnAnteriorAcuerdo="disabled";
            if($DatosAcuerdoAnterior["ID"]>0){
                $disabledBtnAnteriorAcuerdo="";
            }
            $ValorAnteriorCuota=$DatosAcuerdoAnterior["ValorCuotaGeneral"];
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Acuerdo Anterior</strong>", "1", "C");
                $css->ColTabla("<strong>Datos Cliente</strong>", "1", "C");
                $css->ColTabla("<strong>Adicional</strong>", "1", "C");
                $css->ColTabla("<strong>Recomendados</strong>", "1", "C");
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(16);
                print("<td style='text-align:center'>");        
                    print('<span class="input-group-btn"> 
                        <button type="button" class="btn btn-success btn-flat" '.$disabledBtnAnteriorAcuerdo.' onclick=DibujarAcuerdoPagoExistente(`'.$DatosAcuerdoAnterior["idAcuerdoPago"].'`,`DivProyeccionPagosAcuerdo`)> <i class="fa fa-eye"> </i> </button>
                      </span>');

                print("</td>");
                print("<td style='text-align:center' >");        
                    print('<span class="input-group-btn"> 
                        <button type="button" class="btn btn-info btn-flat" onclick=ModalEditarTercero(`ModalAccionesPOS`,`DivFrmPOS`,`'.$idCliente.'`,`clientes`)> <i class="fa fa-user"> </i> </button>
                      </span>');
                print("</td>");
                print("<td style='text-align:center' >");      
                    print('<span class="input-group-btn"> 
                        <button type="button" class="btn btn-primary btn-flat" onclick=DibujarFormularioDatosAdicionalesCliente(`'.$idCliente.'`,`DivProyeccionPagosAcuerdo`)> <i class="fa fa-user-plus"> </i> </button>
                      </span>');

                print("</td>");
                
                print("<td style='text-align:center' >");        
                    print('<span class="input-group-btn"> 
                        <button type="button" class="btn btn-warning btn-flat" onclick=DibujarFormularioRecomendadosCliente(`'.$idCliente.'`,`DivProyeccionPagosAcuerdo`)> <i class="fa fa-users"> </i> </button>
                      </span>');

                print("</td>");
                $css->CierraFilaTabla();
                
                if($NuevoSaldo>$Cupo){
                    $css->CrearTitulo("El Cliente no tiene cupo suficiente para realizar esta compra a credito", "rojo");
                    $css->CerrarTabla();
                    exit();
                }
                    $css->FilaTabla(16);   
                        $css->ColTabla("<strong>Cuota Inicial</strong>", 2);
                        $css->ColTabla("<strong>Metodo</strong>", 1); 
                        $css->ColTabla("<strong>Agregar</strong>", 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td colspan=2>");
                           //$css->input("number", "CuotaInicialAcuerdo", "form-control", "CuotaInicialAcuerdo", "Cuota Inicial", "", "Cuota Inicial", "off", "", "onchange=CalculeCuotas()");
                            $css->input_number_format( "","CuotaInicialAcuerdo", "form-control", "CuotaInicialAcuerdo", "Cuota Inicial", "", "Cuota Inicial", "off", "", "onchange=CalculeCuotas()");
                        print("</td>");
                        print("<td>");
                            $css->select("metodoPagoCuotaInicial", "form-control", "metodoPagoCuotaInicial", "", "", "onchange=CalculeCuotasAcuerdo()", "");
                                
                                $sql="SELECT * FROM metodos_pago WHERE Estado=1";
                                $Consulta=$obCon->Query($sql);
                                while($DatosCiclo=$obCon->FetchAssoc($Consulta)){
                                    $css->option("", "", "", $DatosCiclo["ID"], "", "");
                                    print($DatosCiclo["Metodo"]);
                                $css->Coption();
                                }
                            $css->Cselect();
                        print("</td>");  
                        print("<td>");
                            $css->CrearBotonEvento("btnAgregarCuotaInicialAcuerdo", "+", 1, "onclick", "AgregarCuotaInicialAcuerdoPago('$idAcuerdo'); ", "verde");
                        print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>Cuota Programada</strong>", 2);                        
                        $css->ColTabla("<strong>Fecha cuota programada</strong>", 1);  
                        $css->ColTabla("<strong></strong>", 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td colspan=2>");
                            //$css->input("number", "CuotaProgramadaAcuerdo", "form-control", "CuotaProgramadaAcuerdo", "Cuota Programada", "", "Cuota Programada", "off", "", "onchange=CalculeCuotas()");
                            $css->input_number_format("number", "CuotaProgramadaAcuerdo", "form-control", "CuotaProgramadaAcuerdo", "Cuota Programada", "", "Cuota Programada", "off", "", "onchange=CalculeCuotas()");
                        print("</td>");
                        print("<td>");
                            $css->input("date", "TxtFechaCuotaProgramada", "form-control", "TxtFechaCuotaProgramada", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;' min='".date("Y-m-d")."'");
                        print("</td>"); 
                        print("<td>");
                            $css->CrearBotonEvento("btnAgregarCuotaProgramada", "+", 1, "onclick", "AgregarCuotaProgramadaAcuerdoPagoTemporal('$idAcuerdo')", "verde");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>Ciclo</strong>", 2);
                        $css->ColTabla("<strong>Cuotas</strong>", 1);
                        $css->ColTabla("", 1);
                    $css->CierraFilaTabla();

                    $css->FilaTabla(16);
                        
                        
                        print("<td colspan=2>");
                            $css->select("cicloPagos", "form-control", "cicloPagos", "", "", "onchange=CalculeCuotasAcuerdo()", "");
                                $css->option("", "", "", "", "", "");
                                    print("Seleccione el ciclo de pagos");
                                $css->Coption();
                                $sql="SELECT * FROM acuerdo_pago_ciclos_pagos";
                                $Consulta=$obCon->Query($sql);
                                while($DatosCiclo=$obCon->FetchAssoc($Consulta)){
                                    $css->option("", "", "", $DatosCiclo["ID"], "", "");
                                    print($DatosCiclo["NombreCiclo"]);
                                $css->Coption();
                                }
                            $css->Cselect();
                        print("</td>");
                        print("<td>");
                            $css->input("number", "NumeroCuotas", "form-control", "NumeroCuotas", "NumeroCuotas", "", "Numero de Cuotas", "off", "", "onchange=CalculeValorCuotaAcuerdo('$idAcuerdo')");
                        print("</td>");
                        print("<td>");
                           // $css->CrearBotonEvento("btnAgregar", "+", 1, "onclick", "AgregarNumeroDeCuotas('$idAcuerdo')", "verde");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>Fecha Inicial de pagos</strong>", 2);
                        $css->ColTabla("<strong>Valor de la Cuota</strong>", 1);  
                         
                        $css->ColTabla("<strong></strong>", 1);
                    $css->CierraFilaTabla(); 
                    $css->FilaTabla(16);
                        print("<td colspan=2>");
                            $css->input("date", "TxtFechaInicialPagos", "form-control", "TxtFechaInicialPagos", "Fecha", '', "Fecha", "off", "", "","style='line-height: 15px;' min='".date("Y-m-d")."'");
                        print("</td>"); 
                        print("<td>");
                            
                            $css->input_number_format("text", "ValorCuotaAcuerdo", "form-control", "ValorCuotaAcuerdo", "ValorCuotaAcuerdo", $ValorAnteriorCuota, "Valor de la Cuota", "off", "", "");
                        print("</td>"); 
                        
                        print("<td>");
                            //$css->CrearBotonEvento("btnAgregar", "+", 1, "onclick", "AgregarFechaInicialPagos('$idAcuerdo')", "verde");
                        print("</td>");
                        
                    $css->CierraFilaTabla(); 
                    
                    
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Observaciones</strong>", 4,"C");
                        
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td colspan=4>");
                            $css->textarea("TxtObservacionesAcuerdoPago", "form-control", "TxtObservacionesAcuerdoPago", "", "Observaciones", "", "");
                            $css->Ctextarea();
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td colspan=4>");
                            $css->CrearBotonEvento("btnCalcularProyeccion", "Proyectar pagos", 1, "onclick", "CalculeProyeccionPagosAcuerdo('$idAcuerdo')", "verde");
                        print("</td>");
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
                $css->CrearTitulo("Tomar Fotografía", "naranja");
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->input("file", "upFoto", "form-control", "upFoto", "", "Subir Foto", "Subir Foto", "off", "", "");
                $css->CerrarDiv();
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->CrearBotonEvento("btnSubirFoto", "Subir Foto", 1, "onclick", "SubirFoto()", "verde");
                $css->CerrarDiv();
                print("<br><br><br>");
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    $css->CrearBotonEvento("btnTomarFoto", "Tomar Foto", 1, "onclick", "TomarFoto()", "azul");
                    print('                
                    <div>
                        <select name="listaDeDispositivos" class="form-control" id="listaDeDispositivos"></select>

                        <p id="estado"></p>
                    </div>
                    <br>
                    <video muted="muted" id="video" style="width:400px"></video>
                    <canvas id="canvas" style="display: none;"></canvas>');
                $css->CerrarDiv();
            $css->CerrarDiv();
            
            
            
            
            $css->CrearDiv("DivProyeccionPagosAcuerdo", "col-md-6", "left", 1, 1);
                
            $css->CerrarDiv();
        break;//fin caso 15    
        
        case 16:// calcula y dibuja las cuotas a pagar de un acuerdo de pago
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicialPagos"]);
            $ValorCuotaAcuerdo=$obCon->normalizar($_REQUEST["ValorCuotaAcuerdo"]);
            $CuotaProgramadaAcuerdo=$obCon->normalizar($_REQUEST["CuotaProgramadaAcuerdo"]);
            $TxtFechaCuotaProgramada=$obCon->normalizar($_REQUEST["TxtFechaCuotaProgramada"]);
            $NumeroCuotas=$obCon->normalizar($_REQUEST["NumeroCuotas"]);
            $cicloPagos=$obCon->normalizar($_REQUEST["cicloPagos"]);  
            $css->CrearTitulo("Proyeccion de pagos", "verde");
            
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CUOTA INICIAL</strong>", 3);
                $css->CierraFilaTabla();
                
                $sql="SELECT t1.ID,t1.ValorPago,(SELECT t2.Metodo FROM metodos_pago t2 WHERE t2.ID=t1.MetodoPago LIMIT 1) AS NombreMetodoPago
                       FROM acuerdo_pago_cuotas_pagadas_temp t1 WHERE t1.idAcuerdoPago='$idAcuerdo' AND TipoCuota=0";
                $Consulta=$obCon->Query($sql);
                $TotalCuotaInicial=0;
                while($DatosCuota=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosCuota["ID"];
                    $TotalCuotaInicial=$TotalCuotaInicial+$DatosCuota["ValorPago"];
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosCuota["NombreMetodoPago"], 1);     
                        $css->ColTabla(number_format($DatosCuota["ValorPago"]), 1);                    
                                          
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");                           
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItemAcuerdo(`1`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                if($TotalCuotaInicial>0){
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTAL CUOTA INICIAL</strong>", 1,"R");
                        $css->ColTabla("<strong>". number_format($TotalCuotaInicial)."</strong>", 1,"L");
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CUOTAS PROGRAMADAS</strong>", 3);
                $css->CierraFilaTabla();
                
                $sql="SELECT *
                       FROM acuerdo_pago_proyeccion_pagos_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=1";
                $Consulta=$obCon->Query($sql);
                $TotalCuotasProgramadas=0;
                while($DatosCuota=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosCuota["ID"];
                    $TotalCuotasProgramadas=$TotalCuotasProgramadas+$DatosCuota["ValorCuota"];
                    $css->FilaTabla(16);
                        
                        $css->ColTabla($DatosCuota["Fecha"], 1);     
                        $css->ColTabla(number_format($DatosCuota["ValorCuota"]), 1);                    
                                          
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");                           
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItemAcuerdo(`2`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                if($TotalCuotasProgramadas>0){
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTAL CUOTAS PROGRAMADAS</strong>", 1,"R");
                        $css->ColTabla("<strong>". number_format($TotalCuotasProgramadas)."</strong>", 1,"L");
                    $css->CierraFilaTabla();
                }
                $css->CerrarTabla();
                
                $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
                $NIT= $DatosCliente["Num_Identificacion"];

                $sql="SELECT SUM(Debito - Credito) as Total FROM librodiario t2 WHERE t2.Tercero_Identificacion='$NIT' 
                AND EXISTS(SELECT 1 FROM contabilidad_parametros_cuentasxcobrar t3 WHERE t2.CuentaPUC like t3.CuentaPUC) ";

                $Totales=$obCon->FetchAssoc($obCon->Query($sql));
                $SaldoActualCliente=$Totales["Total"];
                $Cupo=$DatosCliente["Cupo"];

                $sql="SELECT SUM(TotalVenta) AS Total FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ";
                $Totales=$obCon->FetchAssoc($obCon->Query($sql));
                $TotalPreventa=$Totales["Total"];
                
                $TotalAcuerdoPago=$SaldoActualCliente+$TotalPreventa;
                $ValorAProyectar=$TotalAcuerdoPago-$TotalCuotaInicial-$TotalCuotasProgramadas;
                
                
            
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Total Del Acuerdo</strong>", 1);
                        $css->ColTabla("<strong>Cuota Inicial</strong>", 1);
                        $css->ColTabla("<strong>Valor en Cuotas Programadas</strong>", 1);
                        $css->ColTabla("<strong>Valor a Proyectar</strong>", 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla(number_format($TotalAcuerdoPago), 1);
                        $css->ColTabla(number_format($TotalCuotaInicial), 1);
                        $css->ColTabla(number_format($TotalCuotasProgramadas), 1);
                        $css->ColTabla("<strong>".number_format($ValorAProyectar)."</strong>", 1);
                    $css->CierraFilaTabla();
                           
                $css->CerrarTabla();
                
                $sql="DELETE FROM acuerdo_pago_proyeccion_pagos_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=2 ";
                $obCon->Query($sql);
                
                if($FechaInicial==''){
                    $css->CrearTitulo("Por favor seleccione una Fecha inicial de pagos", "rojo");
                    exit();
                }
                if( !is_numeric($ValorCuotaAcuerdo) or $ValorCuotaAcuerdo<=0 ){
                    $css->CrearTitulo("El valor de la cuota debe ser un número mayor a Cero", "rojo");
                    exit();
                }
                /*
                if( !is_numeric($NumeroCuotas) or $NumeroCuotas<=0 ){
                    $css->CrearTitulo("El número de cuotas debe ser un valor mayor a cero", "rojo");
                    exit();
                }
                 * 
                 */
                
                if( $cicloPagos=='' ){
                    $css->CrearTitulo("Por favor seleccione el ciclo de pagos", "rojo");
                    exit();
                }
                $DatosProyeccion=$obAcuerdo->ConstruyaProyeccionPagos($idAcuerdo,$ValorAProyectar, $ValorCuotaAcuerdo,$cicloPagos,$FechaInicial,$idUser);
                
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Fecha Primera Cuota</strong>", 1);
                        //$css->ColTabla("<strong>Valor de la Cuota</strong>", 1);
                        $css->ColTabla("<strong>Número de Cuotas Calculadas</strong>", 1);
                        $css->ColTabla("<strong>Ciclo de Pago</strong>", 1);
                        $css->ColTabla("<strong>Plazo Maximo de pago</strong>", 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla($FechaInicial, 1);
                        //$css->ColTabla(number_format($ValorCuotaAcuerdo), 1);
                        $css->ColTabla($DatosProyeccion["CuotasCalculadas"], 1);
                        $css->ColTabla($cicloPagos, 1);
                        $css->ColTabla($DatosProyeccion["FechaFinal"], 1);
                    $css->CierraFilaTabla();
                    
                    
                $css->CerrarTabla();
                
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Proyección de Pagos</strong>", 4,"C");                                                
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Cuota</strong>", 1); 
                        $css->ColTabla("<strong>Fecha</strong>", 1);   
                        $css->ColTabla("<strong>Día</strong>", 1);                        
                        $css->ColTabla("<strong>Valor Cuota</strong>", 1);                        
                    $css->CierraFilaTabla();
                    $sql="SELECT * FROM acuerdo_pago_proyeccion_pagos_temp WHERE TipoCuota=2 AND idAcuerdoPago='$idAcuerdo' ORDER BY Fecha ASC";    
                    $Consulta=$obAcuerdo->Query($sql);
                    while($DatosAcuerdoProyeccion=$obAcuerdo->FetchAssoc($Consulta)){ 
                        $idItem=$DatosAcuerdoProyeccion["ID"];
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosAcuerdoProyeccion["NumeroCuota"], 1); 
                            $css->ColTabla($DatosAcuerdoProyeccion["Fecha"], 1); 
                            $css->ColTabla(($obAcuerdo->obtenerNombreDiaFecha($DatosAcuerdoProyeccion["Fecha"])), 1);
                            print("<td>");
                                print('<div class="input-group input-group-md">');
                                    print('<span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-flat" onclick=SumaRestaDiferenciaCuota(`TxtValorCuotaNormal_'.$idItem.'`);EditarCuotaTemporal(`'.$idItem.'`)> <i class="fa fa-plus"> </i> </button>
                                      </span> ');
                                    $css->input_number_format("number", "TxtValorCuotaNormal_$idItem", "form-control", "TxtValorCuotaNormal_$idItem", "Cuota", round($DatosAcuerdoProyeccion["ValorCuota"]), "Valor de la cuota", "off", "", "onChange=EditarCuotaTemporal(`$idItem`)", "style=width:150px");
                                    
                                print("</div>");
                            print("</td>");
                                                     
                        $css->CierraFilaTabla();
                    }
                
                $css->CerrarTabla();
                if($idPreventa=='NA'){
                    $css->CrearBotonEvento("BtnGuardarAcuerdoPago", "Guardar", 1, "onclick", "GuardarAcuerdoPagoAdmin(`$idAcuerdo`)", "rojo");
                }
        break; //Fin caso 16    
        
        case 17://Dibuja los totales de la proyeccion comparados con la sumatoria de las cuotas
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$obCon->DevuelveValores("clientes", "Num_Identificacion", $idCliente);
                $idCliente=$DatosCliente["idClientes"];
            }
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $sql="SELECT SUM(TotalVenta) AS Total FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalPreventa=$Totales["Total"];
            
            $ValorAProyectar=$obAcuerdo->ValorAProyectarTemporalAcuerdo($idAcuerdo, $TotalPreventa, $idCliente);
            print("Valor a Proyectar: <h2 style=color:red><strong>". number_format($ValorAProyectar)."</strong></h2>");
            $TotalCuotasProyectadas=$obAcuerdo->TotalCuotasTemporalAcuerdoPago($idAcuerdo);
            //print("Total Cuotas: <h2><strong>". number_format($TotalCuotasProyectadas)."</strong></h2>");
            $Diferencia=$ValorAProyectar-$TotalCuotasProyectadas;
            $css->input("hidden", "TxtDiferenciaCuotasAcuerdo", "", "TxtDiferenciaCuotasAcuerdo", "", $Diferencia, "", "", "", "");
            print("Diferencia: <h2><strong>". number_format($Diferencia)."</strong></h2>");
        break;//Fin caso 17  
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>