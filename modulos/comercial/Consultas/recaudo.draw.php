<?php

@session_start();
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
        
        
        case 1: //Dibuja las cuentas x cobrar de un tercero agrupado por documento externo            
            
            //Paginacion
            if(isset($_REQUEST['Page'])){
                $NumPage=$obCon->normalizar($_REQUEST['Page']);
            }else{
                $NumPage=1;
            }
            
            $Condicional=" WHERE Total>1  ";
            $Tercero="";
            if(isset($_REQUEST['Tercero'])){
                $Tercero=$obCon->normalizar($_REQUEST['Tercero']);
                if($Tercero<>''){
                    $Condicional.=" AND (Tercero_Identificacion = '$Tercero') ";
                }
                
            }
                        
            $statement=" `vista_cuentasxcobrardetallado` $Condicional ";
            if(isset($_REQUEST['st'])){

                $statement= urldecode($_REQUEST['st']);
                //print($statement);
            }
            
            $limit = 50;
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
                    
                    print("<td  colspan=3  style='text-align:center'>");
                        if($Tercero==''){
                            print("<strong>Buscando Documento</strong>");
                        }else{
                            print("<strong>Cuentas X Cobrar del Tercero:</strong> <h4 style=color:blue>". number_format($Tercero)."</h4>");
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
                                
                                $FuncionJS="CambiePagina(`$NumPage1`);";
                                print("<strong>Atrás</strong><br>");
                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=1 style=text-align:center>");
                            print("<strong>Página: </strong>");

                            
                            $FuncionJS="onchange=CambiePagina(``);";
                            $css->select("CmbPageCuentasXPagar", "form-control", "CmbPageCuentasXPagar", "", "", $FuncionJS, "");
                            
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
                                $FuncionJS="CambiePagina(`$NumPage1`);";
                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                                //$css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                      
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Referencia</strong>", 1);
                    $css->ColTabla("<strong>Cuenta</strong>", 1);
                    $css->ColTabla("<strong>Nombre Cuenta</strong>", 1);                    
                    $css->ColTabla("<strong>Total</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                
                while($DatosCuentasXPagar=$obCon->FetchAssoc($Consulta)){
                    $css->FilaTabla(14);
                        $idItem=$DatosCuentasXPagar["ID"];
                        $css->ColTabla($DatosCuentasXPagar["Fecha"], 1);
                        print("<td style='text-align:center'>");
                            print('<a href="#" onclick="VerMovimientosCuentaXCobrar('.$idItem.');">'.$DatosCuentasXPagar["NumeroDocumentoExterno"].' <i class="fa fa-eye"></i></a>');
                        print("</td>");
                        //$css->ColTabla($DatosCuentasXPagar["NumeroDocumentoExterno"], 1);
                        $css->ColTabla($DatosCuentasXPagar["CuentaPUC"], 1);
                        $css->ColTabla($DatosCuentasXPagar["NombreCuenta"], 1);                        
                        $css->ColTabla(number_format($DatosCuentasXPagar["Total"]), 1,'R');
                        
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
        break; //Fin caso 1
    
        case 2:
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            
            $DatosMovimiento=$obCon->DevuelveValores("vista_cuentasxtercerosdocumentos_v2", "ID", $idItem);
            
            
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
                
                $sql="SELECT * FROM librodiario WHERE Num_Documento_Externo='$DatosMovimiento[NumeroDocumentoExterno]' and Tercero_Identificacion='$DatosMovimiento[Tercero_Identificacion]' AND CuentaPUC like '13%' ";
                $Consulta=$obCon->Query($sql);
            
                while($DatosLibro=$obCon->FetchAssoc($Consulta)){
                    $css->FilaTabla(14);
                        $css->ColTabla($DatosLibro["Fecha"], 1);
                        $css->ColTabla(utf8_encode($DatosLibro["Tercero_Razon_Social"]." ".$DatosLibro["Tercero_Identificacion"]), 1);
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
            
        break;//Fin caso 2   
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>