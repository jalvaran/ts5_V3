<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
include_once("../../../modelo/php_conexion.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new conexion($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //Dibuja las cuentas x pagar agrupadas por tercero
            
            //Paginacion
            if(isset($_REQUEST['Page'])){
                $NumPage=$obCon->normalizar($_REQUEST['Page']);
            }else{
                $NumPage=1;
            }
            $Condicional=" ";
            if(isset($_REQUEST['Busqueda'])){
                $Busqueda=$obCon->normalizar($_REQUEST['Busqueda']);
                if($Busqueda<>''){
                    $Condicional=" WHERE CuentaPUC like '$Busqueda%' or Tercero_Razon_Social like '%$Busqueda%' or Tercero_Identificacion like '$Busqueda%'";
                }
                
            }
            
            
            $statement=" `vista_cuentasxpagar_v2` $Condicional ";
            if(isset($_REQUEST['st'])){

                $statement= urldecode($_REQUEST['st']);
                //print($statement);
            }
            
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num`,SUM(Total) AS Total FROM {$statement}";
            $row = $obCon->FetchArray($obCon->Query($query));
            $ResultadosTotales = $row['num'];
            $Total=$row['Total'];
            $st_reporte=$statement;
            $Limit=" LIMIT $startpoint,$limit";
            
            $query="SELECT * ";
            $Consulta=$obCon->Query("$query FROM $statement $Limit");
            
            $css->CrearTabla();
            
            
                $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Total:</strong> <h4 style=color:red>". number_format($Total)."</h4>");
                    print("</td>");
                    
                    print("<td colspan='2' style='text-align:center'>");
                        $st1= urlencode($st_reporte);
                        //$css->CrearImageLink("ProcesadoresJS/GeneradorCSVReportesCartera.php?Opcion=1&sp=$Separador&st=$st1", "../images/csv.png", "_blank", 50, 50);

                    print("</td>");
                $css->CierraFilaTabla();
                
                $st= urlencode($st_reporte);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='1' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                
                                $FuncionJS="CambiePagina($NumPage1);";
                                print("<strong>Atrás</strong><br>");
                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=2 style=text-align:center>");
                            print("<strong>Página: </strong>");

                            
                            $FuncionJS="onchange=CambiePagina();";
                            $css->select("CmbPageCuentasXPagar", "form-control", "CmbPage", "", "", $FuncionJS, "");
                            
                                for($p=1;$p<=$TotalPaginas;$p++){
                                    if($p==$NumPage){
                                        $sel=1;
                                    }else{
                                        $sel=0;
                                    }
                                    
                                    $css->option("", "", "", $p, "", "",$sel);
                                        print($p);
                                    $css->Coption();
                                    
                                }

                            $css->Cselect();
                            print("</td>");
                            
                            print("<td colspan='1' style=text-align:center>");
                            
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                print("<strong>Siguiente</strong><br>");
                                $FuncionJS="CambiePagina($NumPage1);";
                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                                //$css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                      
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    $css->ColTabla("<strong>Razón Social</strong>", 1);
                    $css->ColTabla("<strong>Valor</strong>", 1);
                    $css->ColTabla("<strong>Acciones</strong>", 1);
                $css->CierraFilaTabla();
                
                
                while($DatosCuentasXPagar=$obCon->FetchAssoc($Consulta)){
                    $css->FilaTabla(14);
                        $NIT=$DatosCuentasXPagar["Tercero_Identificacion"];
                        $css->ColTabla($DatosCuentasXPagar["Tercero_Identificacion"], 1);
                        $css->ColTabla($DatosCuentasXPagar["Tercero_Razon_Social"], 1);
                        $css->ColTabla(number_format($DatosCuentasXPagar["Total"]), 1);
                        print("<td style='text-align:center'>");
                            print('<a id="BtnVer_'.$NIT.'" href="#" onclick="DibujeCuentasXPagarDocumentos(`1`,``,`'.$NIT.'`);"><i class="fa fa-fw fa-eye"></i></a>');
                        print("</td>");
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
        break; //Fin caso 1
        
        case 2: //Dibuja las cuentas x pagar de un tercero agrupado por documento externo            
            
            //Paginacion
            if(isset($_REQUEST['Page'])){
                $NumPage=$obCon->normalizar($_REQUEST['Page']);
            }else{
                $NumPage=1;
            }
            
            $Condicional=" WHERE Total<>0 ";
            $Tercero="";
            if(isset($_REQUEST['Tercero'])){
                $Tercero=$obCon->normalizar($_REQUEST['Tercero']);
                if($Tercero<>''){
                    $Condicional.=" AND (Tercero_Identificacion = '$Tercero') ";
                }
                
            }
            if(isset($_REQUEST['Busqueda'])){
                $Busqueda=$obCon->normalizar($_REQUEST['Busqueda']);
                if($Busqueda<>''){
                    $Condicional.=" AND (NumeroDocumentoExterno like '%$Busqueda%')";
                }
                
            }
            
            
            
            $statement=" librodiario 
                   WHERE Tercero_Identificacion='$Tercero' AND EXISTS "
                    . "(SELECT 1 FROM contabilidad_parametros_cuentasxpagar as t2 WHERE librodiario.CuentaPUC LIKE t2.CuentaPUC)  GROUP BY CuentaPUC,Num_Documento_Externo ORDER BY Fecha DESC ";
            $statement=" `vista_cuentasxpagardetallado_v2` $Condicional ";
            if(isset($_REQUEST['st'])){

                $statement= urldecode($_REQUEST['st']);
                //print($statement);
            }
            
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num`,SUM(Total) AS Total FROM {$statement}";
            $row = $obCon->FetchArray($obCon->Query($query));
            $ResultadosTotales = $row['num'];
            $Total=$row['Total'];
            $st_reporte=$statement;
            $Limit=" LIMIT $startpoint,$limit";
            
            $query="SELECT * ";
            //$query="SELECT idLibroDiario as ID,CuentaPUC,Fecha,Num_Documento_Externo as NumeroDocumentoExterno,NombreCuenta,Tercero_Identificacion,Tercero_Razon_Social,SUM(Debito) as Debitos,SUM(Credito) as Creditos,SUM(Debito-Credito) AS Total ";
            //print("$query FROM $statement $Limit");
            $Consulta=$obCon->Query("$query FROM $statement $Limit");
            
            $css->CrearTabla();
            
            
                $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td  colspan=3  style='text-align:center'>");
                        if($Tercero==''){
                            print("<strong>Buscando Documento</strong>");
                        }else{
                            print("<strong>Cuentas X Pagar del Tercero:</strong> <h4 style=color:blue>". number_format($Tercero)."</h4>");
                        }
                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Total:</strong> <h4 style=color:red>". number_format($Total)."</h4>");
                    print("</td>");
                    print("<td colspan='2' style='text-align:center'>");
                        $st1= urlencode($st_reporte);
                        //$css->CrearImageLink("ProcesadoresJS/GeneradorCSVReportesCartera.php?Opcion=1&sp=$Separador&st=$st1", "../images/csv.png", "_blank", 50, 50);

                    print("</td>");
                $css->CierraFilaTabla();
                
                $st= urlencode($st_reporte);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='1' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                
                                $FuncionJS="CambiePaginaReferencia(`$NumPage1`,`$Tercero`);";
                                print("<strong>Atrás</strong><br>");
                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=4 style=text-align:center>");
                            print("<strong>Página: </strong>");

                            
                            $FuncionJS="onchange=CambiePaginaReferencia(``,`$Tercero`);";
                            $css->select("CmbPageCuentasXPagarReferencia", "form-control", "CmbPageCuentasXPagarReferencia", "", "", $FuncionJS, "");
                            
                                for($p=1;$p<=$TotalPaginas;$p++){
                                    if($p==$NumPage){
                                        $sel=1;
                                    }else{
                                        $sel=0;
                                    }
                                    
                                    $css->option("", "", "", $p, "", "",$sel);
                                        print($p);
                                    $css->Coption();
                                    
                                }

                            $css->Cselect();
                            print("</td>");
                            
                            print("<td colspan='1' style=text-align:center>");
                            
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                print("<strong>Siguiente</strong><br>");
                                $FuncionJS="CambiePaginaReferencia(`$NumPage1`,`$Tercero`);";
                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                                //$css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                      
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Plazo Pago</strong>", 1);
                    $css->ColTabla("<strong>Referencia</strong>", 1);
                    $css->ColTabla("<strong>Cuenta</strong>", 1);
                    $css->ColTabla("<strong>Nombre Cuenta</strong>", 1);                    
                    $css->ColTabla("<strong>Total</strong>", 1);
                    $css->ColTabla("<strong>Acciones</strong>", 1);
                $css->CierraFilaTabla();
                
                
                while($DatosCuentasXPagar=$obCon->FetchAssoc($Consulta)){
                    $css->FilaTabla(14);
                        $idItem=$DatosCuentasXPagar["ID"];
                        $css->ColTabla($DatosCuentasXPagar["Fecha"], 1);
                        $css->ColTabla($DatosCuentasXPagar["PlazoPago"], 1);
                        print("<td style='text-align:center'>");
                            print('<a href="#" onclick="VerMovimientosCuentaXPagar('.$idItem.');">'.$DatosCuentasXPagar["NumeroDocumentoExterno"].' <i class="fa fa-eye"></i></a>');
                        print("</td>");
                        //$css->ColTabla($DatosCuentasXPagar["NumeroDocumentoExterno"], 1);
                        $css->ColTabla($DatosCuentasXPagar["CuentaPUC"], 1);
                        $css->ColTabla($DatosCuentasXPagar["NombreCuenta"], 1);                        
                        $css->ColTabla(number_format($DatosCuentasXPagar["Total"]), 1);
                        print("<td style='text-align:center'>");
                            print('<a href="#" onclick="AgregueMovimientoDesdeCuentaXPagar(`'.$idItem.'`,`'.$DatosCuentasXPagar["NumeroDocumentoExterno"].'`,`'.$DatosCuentasXPagar["Total"].'`,`'.$DatosCuentasXPagar["CuentaPUC"].'`,`'.$DatosCuentasXPagar["NombreCuenta"].'`,`'.$Tercero.'`);"><i class="fa fa-plus"></i></a>');
                        print("</td>");
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
        break; //Fin caso 2
    
        case 3:
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            
            $DatosMovimiento=$obCon->DevuelveValores("librodiario", "idLibroDiario", $idItem);
            
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    $css->ColTabla("<strong>Tipo Documento</strong>", 1);
                    $css->ColTabla("<strong>Documento Interno</strong>", 1);
                    $css->ColTabla("<strong>Documento Referencia</strong>", 1);
                    $css->ColTabla("<strong>Cuenta</strong>", 1);
                    $css->ColTabla("<strong>Nombre Cuenta</strong>", 1);
                    $css->ColTabla("<strong>Debito</strong>", 1);
                    $css->ColTabla("<strong>Credito</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $sql="SELECT * FROM librodiario WHERE Num_Documento_Externo='$DatosMovimiento[Num_Documento_Externo]' and Tercero_Identificacion='$DatosMovimiento[Tercero_Identificacion]' ";
                $Consulta=$obCon->Query($sql);
            
                while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                    $css->FilaTabla(14);
                        $css->ColTabla($DatosLibro["Fecha"], 1);
                        $css->ColTabla($DatosLibro["Tercero_Razon_Social"]." ".$DatosLibro["Tercero_Identificacion"], 1);
                        $css->ColTabla($DatosLibro["Tipo_Documento_Intero"], 1);
                        $css->ColTabla($DatosLibro["Num_Documento_Interno"], 1);
                        $css->ColTabla($DatosLibro["Num_Documento_Externo"], 1);
                        $css->ColTabla($DatosLibro["CuentaPUC"], 1);
                        $css->ColTabla($DatosLibro["NombreCuenta"], 1);
                        $css->ColTabla(number_format($DatosLibro["Debito"]), 1);
                        $css->ColTabla(number_format($DatosLibro["Credito"]), 1);

                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
        break;//Fin caso 3    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>