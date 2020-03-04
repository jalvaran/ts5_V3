<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
include_once("../clases/AcuerdoPago.class.php");
include_once("../clases/informesAcuerdosPago.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    
    $obCon = new informesAcuerdoPago($idUser);
    switch ($_REQUEST["Accion"]) {
                
        case 1://dibuja la vista de las cuenta x cobrar
            
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $cmbCicloPagos=$obCon->normalizar($_REQUEST["cmbCicloPagos"]);
            $Condicion=" WHERE ID>0 ";
            
            if($idCliente<>''){
                $Condicion.=" AND (Tercero = '$idCliente')";
            }
            if($FechaInicialRangos<>''){
                $Condicion.=" AND (Fecha >= '$FechaInicialRangos')";
            }
            if($FechaFinalRangos<>''){
                $Condicion.=" AND (Fecha <= '$FechaFinalRangos')";
            }
            if($cmbCicloPagos<>''){
                $Condicion.=" AND (CicloPagos = '$cmbCicloPagos')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items,SUM(ValorCuota) as Total
                   FROM acuerdo_pago_hoja_trabajo_informes t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $TotalCobros=$totales["Total"];
            
            $sql="SELECT *
                  FROM acuerdo_pago_hoja_trabajo_informes t1 $Condicion LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("Listado de Cuentas x Cobrar", "verde");
            
            $css->CrearTabla();
                
            
            $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        print("<strong>Total X Cobrar:</strong><br>");
                        print("".number_format($TotalCobros));
                    print("</td>");
                    
                    print("<td style='text-align:center'>");
                        $Ruta="procesadores/informesAcuerdoPago.process.php?Accion=2&c=". base64_encode($Condicion);
                        print('<a href="'.$Ruta.'" target="_blank"><button type="button" id="BtnExportarExcelCuentas" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i></button></a>');
                    print("</td>");
                   
                
                    if($ResultadosTotales>$Limit){

                        //$css->FilaTabla(14);
                            
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);
                            print("<td  style=text-align:center>");
                            //print("<strong>Página: </strong>");
                            
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina('.$NumPage1.') style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina();";
                            $css->select("CmbPage", "form-control", "CmbPage", "", "", $FuncionJS, "");
                            
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
                            if($ResultadosTotales>($PuntoInicio+$Limit)){
                                $NumPage1=$NumPage+1;
                            print('<span class="input-group-addon" onclick=CambiePagina('.$NumPage1.') style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                            print("</td>");
                            
                            
                          
                        }
            
            $css->FilaTabla(16);
                
                
                $css->ColTabla("<strong>ID</strong>", 1, "C");
                $css->ColTabla("<strong>Acuerdo</strong>", 1, "C");
                $css->ColTabla("<strong>Tercero</strong>", 1, "C"); 
                $css->ColTabla("<strong>Fecha</strong>", 1, "C"); 
                $css->ColTabla("<strong>Tipo de Cuota</strong>", 1, "C");
                $css->ColTabla("<strong>Numero de Cuota</strong>", 1, "C");                
                $css->ColTabla("<strong>Valor de Cuota</strong>", 1, "C"); 
                $css->ColTabla("<strong>Valor Pagado</strong>", 1, "C");
                $css->ColTabla("<strong>Estado</strong>", 1, "C");
                
            $css->CierraFilaTabla();

            
                while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                    
                    $idItem=$RegistrosTabla["ID"];
                    $css->FilaTabla(16);
                        
                        $css->ColTabla($RegistrosTabla["ID"], 1, "L");
                        $css->ColTabla($RegistrosTabla["ConsecutivoAcuerdo"], 1, "L");
                        $css->ColTabla(utf8_encode($RegistrosTabla["RazonSocial"]." || ".$RegistrosTabla["SobreNombreCliente"]." || ".$RegistrosTabla["TelefonoCliente"]." || ".$RegistrosTabla["Tercero"]), 1, "L");
                        $css->ColTabla($RegistrosTabla["Fecha"], 1, "L");
                        $css->ColTabla(($RegistrosTabla["NombreTipoCuota"]), 1, "L");         
                        $css->ColTabla($RegistrosTabla["NumeroCuota"], 1, "L");
                        $css->ColTabla(number_format($RegistrosTabla["ValorCuota"]), 1, "L");
                        $css->ColTabla(number_format($RegistrosTabla["ValorPagado"]), 1, "L");
                        $css->ColTabla($RegistrosTabla["NombreEstadoProyeccion"], 1, "L");
                        
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 1
        
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>