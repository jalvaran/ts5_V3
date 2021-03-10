<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/ReportesContables.class.php");
include_once("../clases/PDF_ReportesContables.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Contabilidad($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //Crea las opciones para el reporte de Balance de comprobacion
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tipo</a>");
                    $css->Clegend();
                    $css->select("CmbTipo", "form-control", "CmbTipo", "", "", "", "");                
                        $css->option("", "", "Rango", 1, "", "");
                            print("Rango de fechas");
                        $css->Coption();
                        $css->option("", "", "Fecha de Corte", 2, "", "");
                            print("Fecha de Corte");
                        $css->Coption();                
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Inicial</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaInicial", "form-control", "TxtFechaInicial", "", date("Y-m-d"), "Fecha Inicial", "off", "", "style='line-height: 15px;'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Final</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaFinal", "form-control", "TxtFechaFinal", "", date("Y-m-d"), "Fecha Inicial", "off", "", "style='line-height: 15px;'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa</a>");
                    $css->Clegend();
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("empresapro", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                                print($DatosEmpresa["idEmpresaPro"]." ".$DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Centro de Costos</a>");
                    $css->Clegend();
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("centrocosto", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["ID"], "", "");
                                print($DatosEmpresa["ID"]." ".$DatosEmpresa["Nombre"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            print("<br><br><br><br><br>");
            $css->CrearDiv("DivAccion", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Opciones</a>");
                    $css->Clegend();
                    $css->select("CmbOpciones", "form-control", "CmbOpciones", "", "", "", ""); 
                        $css->option("", "", "", "1", "", "");
                            print("Detallado");
                        $css->Coption();
                        
                        $css->option("", "", "", "0", "", "");
                            print("Sin Detalles");
                        $css->Coption();
                        
                        
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tercero</a>");
                    $css->Clegend();
                    $css->select("CmbTercero", "form-control", "CmbTercero", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Seleccione un tercero");
                        $css->Coption();
                        
                    $css->Cselect();
                $css->Cfieldset();
                
            $css->CerrarDiv();
            
            $css->CrearDiv("DivAccion", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Cuenta</a>");
                    $css->Clegend();
                    $css->input("text", "TxtCuentaContable", "form-control", "TxtCuentaContable", "", "", "Cuenta Contable", "off", "", "");
                $css->Cfieldset();
                
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-3", "center", 1, 1);
            $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Generar</a>");
                    $css->Clegend();
                    $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereBalanceXTerceros()", "verde", "");

                $css->Cfieldset();
            
            $css->CerrarDiv();
        break; 
    
        case 2: //Crea la vista para el balance x tercero
            $Tipo=$obCon->normalizar($_REQUEST["CmbTipo"]);
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $Empresa=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);
            $CentroCostos=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CmbOpciones=$obCon->normalizar($_REQUEST["CmbOpciones"]);
            $CmbTercero=$obCon->normalizar($_REQUEST["CmbTercero"]);
            $TxtCuentaContable=$obCon->normalizar($_REQUEST["TxtCuentaContable"]);
            $obCon->ConstruirVistaBalanceTercero($Tipo, $FechaInicial, $FechaFinal, $Empresa, $CentroCostos,$CmbTercero,$TxtCuentaContable, "");
            $Encabezado=1;
            if($CmbTercero<>'' or $TxtCuentaContable<>'' ){
                $Encabezado=0;
            }
            $link="procesadores/ReportesContables.process.php?Accion=1&Opciones=$CmbOpciones&Encabezado=$Encabezado";
            $html="<a id='LinkExport' href='$link' target='_BLANK' >Ver</a>";
            print($html);
        break; 
    
        case 3: //Crea las opciones para el certificado de retenciones
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Inicial</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaInicial", "form-control", "TxtFechaInicial", "", date("Y-m-d"), "Fecha Inicial", "off", "", "style='line-height: 15px;'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Final</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaFinal", "form-control", "TxtFechaFinal", "", date("Y-m-d"), "Fecha Inicial", "off", "", "style='line-height: 15px;'");
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tercero</a>");
                    $css->Clegend();
                    $css->select("CmbTercero", "form-control", "CmbTercero", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Seleccione un tercero");
                        $css->Coption();
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa</a>");
                    $css->Clegend();
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("empresapro", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                                print($DatosEmpresa["idEmpresaPro"]." ".$DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Centro de Costos</a>");
                    $css->Clegend();
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("centrocosto", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["ID"], "", "");
                                print($DatosEmpresa["ID"]." ".$DatosEmpresa["Nombre"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();                
            $css->CerrarDiv();
            print("<br><br><br><br><br>");
            $css->CrearDiv("", "col-md-6", "center", 1, 1);
                
                    $css->select("CmbCiudadRetencion", "form-control", "CmbCiudadRetencion", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Ciudad donde se practicó la Retención");
                        $css->Coption();                        
                    $css->Cselect();
                
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-6", "center", 1, 1);
                
                    $css->select("CmbCiudadPago", "form-control", "CmbCiudadPago", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Ciudad donde se consignó la Retención");
                        $css->Coption();                        
                    $css->Cselect();
                
            $css->CerrarDiv();
            
            print("<br><br><br>");
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);

                $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereCertificaRetenciones()", "verde", "");

            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        break; //Fin caso 3
        case 4: //Crea el link para ver el certificado de retenciones
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $Empresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCostos=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);  
            $CmbTercero=$obCon->normalizar($_REQUEST["CmbTercero"]);
            $CmbCiudadRetencion=$obCon->normalizar($_REQUEST["CmbCiudadRetencion"]);
            $CmbCiudadPago=$obCon->normalizar($_REQUEST["CmbCiudadPago"]);
            $fecha_id= str_replace("-", "", $FechaInicial.$FechaFinal);
            $comprobante_id=$CmbTercero.$fecha_id;
            $datos_tercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $CmbTercero);
                        
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Tercero:</strong>", 1);
                    $css->ColTabla("<strong>Periodo:</strong>", 1);
                    $css->ColTabla("<strong>Ciudad donde se Practicó:</strong>", 1);
                    $css->ColTabla("<strong>Ciudad donde se pagó:</strong>", 1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla($datos_tercero["RazonSocial"]." ".$datos_tercero["Num_Identificacion"], 1);
                    $css->ColTabla("$FechaInicial - $FechaFinal", 1);
                    $css->ColTabla("$CmbCiudadRetencion", 1);
                    $css->ColTabla("$CmbCiudadPago", 1);
                    
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
            $css->div("", "row", "", "", "", "", "");
                $css->div("div_cuentas_disponibles", "col-md-12", "", "", "", "", "");
                    $sql="select t1.CuentaPUC,t1.Detalle,sum(t1.Credito) as Creditos,  sum(t1.Debito) as Debitos 
                            FROM librodiario t1 INNER JOIN subcuentas t2 ON t1.CuentaPUC=t2.PUC 
                            WHERE t2.SolicitaBase = '1' AND Tercero_Identificacion='$CmbTercero' 
                                  AND t1.Fecha>='$FechaInicial' and  t1.Fecha<='$FechaFinal' 
                            GROUP BY CuentaPUC";
                    $Consulta=$obCon->Query($sql);
                    $css->CrearTabla();
                        $css->FilaTabla(16);
                            $css->ColTabla("<strong>Cuenta</strong>", 1);
                            $css->ColTabla("<strong>Concepto</strong>", 1);
                            $css->ColTabla("<strong>Creditos</strong>", 1);
                            $css->ColTabla("<strong>Debitos</strong>", 1);
                            $css->ColTabla("<strong>Porcentaje</strong>", 1);
                            $css->ColTabla("<strong>Base</strong>", 1);
                            $css->ColTabla("<strong>Agregado</strong>", 1);
                        $css->CierraFilaTabla();
                        $i=0;
                    while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                        $i++;
                        $valor_retencion=abs($datos_consulta["Creditos"]-$datos_consulta["Debitos"]);
                        $css->FilaTabla(16);
                            $css->ColTabla($datos_consulta["CuentaPUC"], 1);
                            $css->ColTabla(($datos_consulta["Detalle"]), 1);
                            $css->ColTabla(number_format($datos_consulta["Creditos"]), 1);
                            $css->ColTabla(number_format($datos_consulta["Debitos"]), 1);
                            print("<td>");
                                print('<input style="text-align:right" type="text" class="form-control" onkeyup="actualice_base_certificado('.$i.')" id="porcentaje_'.$i.'" data-concepto="'.$datos_consulta["Detalle"].'"  data-valor_retencion="'.$valor_retencion.'" data-id="porcentaje_'.$i.'" data-cuenta_puc="'.$datos_consulta["CuentaPUC"].'" data-certificado_id="'.$comprobante_id.'" value="" placeholder="Porcentaje"></input>');
                            print("</td>");
                            print("<td>");
                                print('<input type="text" disabled=true class="form-control"  id="base_'.$i.'"  value="" placeholder="Base"></input>');
                            print("</td>");
                            print("<td style='text-align:center'>");
                                print('<span id="sp_'.$i.'" class="fa fa-circle-o text-danger" style="text-size:25px;"></span>');
                            print("</td>");
                        $css->CierraFilaTabla();
                    } 
                    $css->CerrarTabla();
                     
                $css->Cdiv();
                
                
            $css->Cdiv();
            
            $page="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=34&comprobante_id=$comprobante_id&TxtFechaInicial=$FechaInicial&TxtFechaFinal=$FechaFinal"; 
            $page.="&CmbEmpresa=$Empresa&CmbCentroCosto=$CentroCostos&CmbTercero=$CmbTercero&CmbCiudadPago=$CmbCiudadPago&CmbCiudadRetencion=$CmbCiudadRetencion";
            $Target="FramePDF";
            //$Target="_blank";
            
            print("<a href='$page' class='btn btn-success' id='LinkPDF' target='$Target'>Generar PDF <li class='fa fa-file-pdf-o'></li></a><br><br><br><br>");
            
        break; // fin caso 4
    
        case 5: //Crea las opciones para el reporte de estado de resultados
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Año</a>");
                    $css->Clegend();
                    
                    $AnioActual=$obCon->normalizar($_REQUEST["CmbAnio"]);
                    
                    if($AnioActual==""){
                        $AnioActual=date("Y");
                    }
                    
                    $css->select("CmbAnio", "form-control", "CmbAnio", "", "", "", "onchange=DibujeOpcionesReporte()"); 
                        $sql="SELECT DISTINCT(SUBSTRING(Fecha,1,4)) as Anio FROM librodiario GROUP BY SUBSTRING(Fecha,1,4)";
                        $Consulta=$obCon->Query($sql);
                        while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                            $sel=0;
                            $Anio=$DatosLibro["Anio"];
                            if($Anio==$AnioActual){
                                $sel=1;
                            }
                            $css->option("", "", "Rango", "$Anio", "", "",$sel);
                                print($Anio);
                            $css->Coption();
                        }
                        
                                       
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $FechaMin=$AnioActual."-01-01";
            $FechaMax=$AnioActual."-12-31";
            $FechaSel=$AnioActual."-".date("m-d");
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Inicial</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaInicial", "form-control", "TxtFechaInicial", "", $FechaSel, "Fecha Inicial", "off", "", "style='line-height: 15px;'","min='$FechaMin' max='$FechaMax'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Final</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaFinal", "form-control", "TxtFechaFinal", "", $FechaSel, "Fecha Inicial", "off", "", "style='line-height: 15px;'","min='$FechaMin' max='$FechaMax'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa</a>");
                    $css->Clegend();
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("empresapro", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                                print($DatosEmpresa["idEmpresaPro"]." ".$DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Centro de Costos</a>");
                    $css->Clegend();
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("centrocosto", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["ID"], "", "");
                                print($DatosEmpresa["ID"]." ".$DatosEmpresa["Nombre"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            print("<br><br><br><br><br>");
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);

                $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereHTMLEstadoResultadosAnio()", "verde", "");

            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        break; //fin caso 5
        
        case 6: //Crea el pdf para visualizar el estado de resultados
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $Empresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCostos=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);             
            $CmbAnio=$obCon->normalizar($_REQUEST["CmbAnio"]);
            
            $obCon->ConstruirVistaEstadoResultados($CmbAnio, $Empresa, $CentroCostos, "");
            $page="Consultas/PDF_ReportesContables.draw.php?idDocumento=1&TxtFechaInicial=$FechaInicial&TxtFechaFinal=$FechaFinal"; 
            $page.="&CmbEmpresa=$Empresa&CmbCentroCosto=$CentroCostos&CmbAnio=$CmbAnio";
            $Target="FramePDF";
            $Target="_blank";
            print("<a href='$page' id='LinkPDF' target='$Target'></a>");
        break; // fin caso 6
    
        case 7: //Crea las opciones para el reporte de movimiento de cuentas
            $FechaActual=date("Y-m-d");
                        
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha_Inicial</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaInicial", "form-control", "TxtFechaInicial", "", $FechaActual, "Fecha Inicial", "off", "", "style='line-height: 15px;'","max='$FechaActual'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Final</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaFinal", "form-control", "TxtFechaFinal", "", $FechaActual, "Fecha Inicial", "off", "", "style='line-height: 15px;'"," max='$FechaActual'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tercero</a>");
                    $css->Clegend();
                    $css->select("CmbTercero", "form-control", "CmbTercero", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Seleccione un tercero");
                        $css->Coption();
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Cuenta</a>");
                    $css->Clegend();
                    $css->input("text", "TxtCuentaContable", "form-control", "TxtCuentaContable", "", "", "Cuenta Contable", "off", "", "");
                $css->Cfieldset();
                
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa</a>");
                    $css->Clegend();
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("empresapro", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                                print($DatosEmpresa["idEmpresaPro"]." ".$DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-1", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Costos</a>");
                    $css->Clegend();
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("centrocosto", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["ID"], "", "");
                                print($DatosEmpresa["ID"]." ".$DatosEmpresa["Nombre"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            print("<br><br><br><br><br>");
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);

                $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereHTMLMovimientoCuentas()", "verde", "");

            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        break; //fin caso 7
        
        case 8: //Crea las opciones para el reporte del balance general
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Año</a>");
                    $css->Clegend();
                    
                    $AnioActual=$obCon->normalizar($_REQUEST["CmbAnio"]);
                    
                    if($AnioActual==""){
                        $AnioActual=date("Y");
                    }
                    
                    $css->select("CmbAnio", "form-control", "CmbAnio", "", "", "", "onchange=DibujeOpcionesReporte()"); 
                        $sql="SELECT DISTINCT(SUBSTRING(Fecha,1,4)) as Anio FROM librodiario GROUP BY SUBSTRING(Fecha,1,4)";
                        $Consulta=$obCon->Query($sql);
                        while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                            $sel=0;
                            $Anio=$DatosLibro["Anio"];
                            if($Anio==$AnioActual){
                                $sel=1;
                            }
                            $css->option("", "", "Rango", "$Anio", "", "",$sel);
                                print($Anio);
                            $css->Coption();
                        }
                        
                                       
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $FechaMin=$AnioActual."-01-01";
            $FechaMax=$AnioActual."-12-31";
            $FechaSel=$AnioActual."-".date("m-d");
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Inicial</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaInicial", "form-control", "TxtFechaInicial", "", $FechaSel, "Fecha Inicial", "off", "", "style='line-height: 15px;'","min='$FechaMin' max='$FechaMax'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Final</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaFinal", "form-control", "TxtFechaFinal", "", $FechaSel, "Fecha Inicial", "off", "", "style='line-height: 15px;'","min='$FechaMin' max='$FechaMax'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa</a>");
                    $css->Clegend();
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("empresapro", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                                print($DatosEmpresa["idEmpresaPro"]." ".$DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Centro de Costos</a>");
                    $css->Clegend();
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("centrocosto", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["ID"], "", "");
                                print($DatosEmpresa["ID"]." ".$DatosEmpresa["Nombre"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            print("<br><br><br><br><br>");
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);

                $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereHTMLBalanceGeneralAnio()", "naranja", "");

            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        break; //fin caso 8
        
        case 9: //Crea las opciones para el reporte de balance de comprobacion por terceros
            $FechaActual=date("Y-m-d");
                        
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha_Inicial</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaInicial", "form-control", "TxtFechaInicial", "", $FechaActual, "Fecha Inicial", "off", "", "style='line-height: 15px;'","max='$FechaActual'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Final</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaFinal", "form-control", "TxtFechaFinal", "", $FechaActual, "Fecha Inicial", "off", "", "style='line-height: 15px;'"," max='$FechaActual'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tercero</a>");
                    $css->Clegend();
                    $css->select("CmbTercero", "form-control", "CmbTercero", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Seleccione un tercero");
                        $css->Coption();
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Cuenta</a>");
                    $css->Clegend();
                    $css->input("text", "TxtCuentaContable", "form-control", "TxtCuentaContable", "", "", "Cuenta Contable", "off", "", "");
                $css->Cfieldset();
                
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa</a>");
                    $css->Clegend();
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("empresapro", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                                print($DatosEmpresa["idEmpresaPro"]." ".$DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-1", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Costos</a>");
                    $css->Clegend();
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("centrocosto", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["ID"], "", "");
                                print($DatosEmpresa["ID"]." ".$DatosEmpresa["Nombre"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            print("<br><br><br><br><br>");
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);

                $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereHTMLBalanceComprobacionXTerceros()", "verde", "");

            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        break; //fin caso 9
        
        case 10: //Crea las opciones para los reportes fiscales
            $FechaActual=date("Y-m-d");
                        
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha_Inicial</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaInicial", "form-control", "TxtFechaInicial", "", $FechaActual, "Fecha Inicial", "off", "", "style='line-height: 15px;'","max='$FechaActual'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha Final</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFechaFinal", "form-control", "TxtFechaFinal", "", $FechaActual, "Fecha Inicial", "off", "", "style='line-height: 15px;'"," max='$FechaActual'");
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tercero</a>");
                    $css->Clegend();
                    $css->select("CmbTercero", "form-control", "CmbTercero", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Seleccione un tercero");
                        $css->Coption();
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Cuenta</a>");
                    $css->Clegend();
                    $css->input("text", "TxtCuentaContable", "form-control", "TxtCuentaContable", "", "2408", "Cuenta Contable", "off", "", "");
                $css->Cfieldset();
                
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa</a>");
                    $css->Clegend();
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("empresapro", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                                print($DatosEmpresa["idEmpresaPro"]." ".$DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-1", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Costos</a>");
                    $css->Clegend();
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");                
                        $css->option("", "", "", "ALL", "", "");
                            print("Completo");
                        $css->Coption();
                        $consulta=$obCon->ConsultarTabla("centrocosto", "");
                        while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosEmpresa["ID"], "", "");
                                print($DatosEmpresa["ID"]." ".$DatosEmpresa["Nombre"]);
                            $css->Coption();
                        }
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            print("<br><br><br><br><br>");
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);

                $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereHTMLReportesFiscales()", "verde", "");

            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        break; //fin caso 10
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>