<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/inventarios.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Inventarios($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //dibuja el listado de productos para la venta
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Filtro=$obCon->normalizar($_REQUEST["Filtro"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
                        
            $Condicion=" WHERE idProductosVenta>0 ";
            
            if($Busquedas<>''){
                $Condicion.=" AND (idProductosVenta = '$Busquedas' or Referencia like '$Busquedas%' or Nombre like '%$Busquedas%')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items,SUM(Existencias) as TotalExistencias,SUM(CostoTotal) as CostoTotal, SUM(PrecioVenta) as TotalPrecioVenta 
                   FROM productosventa t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $TotalExistencias=$totales["TotalExistencias"];
            $CostoTotal=$totales["CostoTotal"];
            $TotalPrecioVenta=$totales["TotalPrecioVenta"]*$TotalExistencias;
            
            $sql="SELECT * 
                  FROM productosventa $Condicion ORDER BY idProductosVenta DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>Productos para la Venta</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                        $Altura="170";
                        $css->CrearDiv("", "col-md-2", "center", 1, 1,"",'height:'.$Altura.'px;'); 
                            print('<strong>Crear:</strong><br><br><a class="btn btn-app" style="background-color:#0f6106;color:white;width:120px;height:120px;border-radius: 25px;" onclick=FormularioCreacionProductos(``,`DivGeneralDraw`,``)>

                                <i class="fa fa-plus-square" style="font-size:80px"></i> 
                              </a>');    
                        $css->Cdiv();
                        $css->CrearDiv("", "col-md-2", "center", 1, 1,"",'height:'.$Altura.'px;');                
                            print("<strong>Productos:</strong><br><br>");                
                            $css->dialInput("dialItems", "dial", $ResultadosTotales, $ResultadosTotales, 1,"#021c90");             

                        $css->Cdiv();
                        $css->CrearDiv("", "col-md-2", "center", 1, 1,"",'height:'.$Altura.'px;');
                            $Color="#021c90";
                            $Titulo="Existencias:";
                            if($TotalExistencias<0){
                                $Color="#f52a01";
                                $Titulo="Existencias (-):";
                            }
                            print("<strong>$Titulo</strong><br><br>");                
                            $css->dialInput("dialExistencias", "dial",abs($TotalExistencias), abs($TotalExistencias), 1,$Color);             

                        $css->Cdiv();
                        $css->CrearDiv("", "col-md-2", "center", 1, 1,"",'height:'.$Altura.'px;');                
                            $Color="#021c90";
                            $Titulo="Costo Total:";
                            if($CostoTotal<0){
                                $Color="#f52a01";
                                $Titulo="Costo Total (-):";
                            }
                            print("<strong>$Titulo</strong><br><br>");                
                            $css->dialInput("dialCosto", "dial", abs($CostoTotal), abs($CostoTotal), 1,$Color);             

                        $css->Cdiv();
                        
                        $css->CrearDiv("", "col-md-2", "center", 1, 1,"",'height:'.$Altura.'px;'); 
                            print('<strong>Bajar del servidor:</strong><br><br><button id="btnDescargarProductos" class="btn btn-app" style="background-color:#353978;color:white;width:120px;height:120px;border-radius: 25px;" onclick=ConfirmaDescargarDesdeServidor()>

                                <i class="fa fa-cloud-download" style="font-size:80px"></i> 
                              </button>');    
                        $css->Cdiv();
                        
                        $css->CrearDiv("", "col-md-2", "center", 1, 1,"",'height:'.$Altura.'px;'); 
                            print('<strong>Subir al servidor:</strong><br><br><button id="btnSubirProductos" class="btn btn-app" style="background-color:#ab0a0a;color:white;width:120px;height:120px;border-radius: 25px;" onclick=ConfirmaCargarAlServidor()>

                                <i class="fa fa-cloud-upload" style="font-size:80px"></i> 
                              </button>');    
                        $css->Cdiv();
                        
                        /*
                        $css->CrearDiv("", "col-md-2", "center", 1, 1,"",'height:'.$Altura.'px;'); 
                            $Color="#021c90";
                            $Titulo="Total Venta:";
                            if($TotalPrecioVenta<0){
                                $Color="#f52a01";
                                $Titulo="Total Venta (-):";
                            }
                            
                            print("<strong>$Titulo</strong><br>");                
                            $css->dialInput("dialTotalVenta", "dial", abs($TotalPrecioVenta), abs($TotalPrecioVenta), 1,$Color);             

                        $css->Cdiv();
                         * 
                         */
                    $css->Cdiv();
                     
                                       
                    $css->div("", "pull-left", "", "", "", "", "");
                        if($ResultadosTotales>$Limit){
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`1`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(`1`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`1`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                        }    
                    $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<thead>');  
                            $css->FilaTabla(16);    
                                print("<td colspan='10' style='width:100%'>");
                                        
                                print("</td>");
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);    
                                $css->ColTabla("<strong>Acciones</strong>", 1,"C");
                                $css->ColTabla("<strong>ID</strong>", 1,"C");
                                $css->ColTabla("<strong>Referencia</strong>", 1,"C");
                                $css->ColTabla("<strong>Nombre</strong>", 1,"C");
                                $css->ColTabla("<strong>Existencias</strong>", 1,"C");
                                $css->ColTabla("<strong>Precio Venta</strong>", 1,"C");
                                $css->ColTabla("<strong>Costo Unitario</strong>", 1,"C");
                                $css->ColTabla("<strong>Costo Total</strong>", 1,"C");
                                $css->ColTabla("<strong>IVA</strong>", 1,"C");
                                $css->ColTabla("<strong>Cuenta Contable</strong>", 1,"C");
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["idProductosVenta"];
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button type="button" class="btn btn-warning btn-sm" onclick=FormularioCrearEditarPaciente(`2`,`'.$idItem.'`)><i class="fa fa-edit"></i></button>');
                                    print("</td>");
                                    print("<td class='mailbox-name'>");
                                        print($idItem);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["Referencia"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["Nombre"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print(number_format($RegistrosTabla["Existencias"]));
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".number_format($RegistrosTabla["PrecioVenta"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".number_format($RegistrosTabla["CostoUnitario"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".number_format($RegistrosTabla["CostoTotal"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["IVA"])."</strong>");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print(($RegistrosTabla["CuentaPUC"]));
                                    print("</td>");
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 1
        
        case 2: //dibuja el listado de separados
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            
            
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $Estado='';
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            
                        
            $Condicion=" WHERE ID>0 ";
            
            if($Busquedas<>''){
                $Condicion.=" AND ( RazonSocial Like '%$Busquedas%' or Num_Identificacion = '$Busquedas' )";
            }
            
            if($Estado<>''){
                $Condicion.="AND Estado='$Estado' ";
            }

            if($FechaInicialRangos<>''){
                $Condicion.="AND FechaVencimiento>='$FechaInicialRangos' ";
            }

            if($FechaFinalRangos<>''){
                $Condicion.="AND FechaVencimiento<='$FechaFinalRangos' ";
            }
        
            $obCon->crearVistaSeparados();
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items,SUM(Total) as TotalSeparados, SUM(Saldo) as TotalSaldo    
                   FROM vista_separados_reportes t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $TotalSeparados = $totales['TotalSeparados'];
            $TotalSaldo = $totales['TotalSaldo'];
                        
            $sql="SELECT * 
                  FROM vista_separados_reportes $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>Separados</strong>", "naranja");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                  <div class="inner">
                                    <h3>'.$ResultadosTotales.'</h3>

                                    <p>Separados</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-object-ungroup" ></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        print('<div class="col-lg-4 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-blue">
                                  <div class="inner">
                                    <h3>'.number_format($TotalSaldo).'</h3>

                                    <p>Saldo Total</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-dollar" ></i>
                                  </div>
                                  
                                </div>
                              </div>');
                        $CondicionBase64= base64_encode(urlencode($Condicion));
                        $Link="procesadores/inventarios.process.php?Accion=13&c=$CondicionBase64";
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                  <div class="inner">
                                    <h3>Exportar</h3>

                                    <p>Separados</p>
                                  </div>
                                  <div class="icon">
                                    <a href="'.$Link.'" target="_blank" class="fa fa-file-excel-o" style="cursor:pointer" ></a>
                                  </div>
                                  
                                </div>
                              </div>');
                        
                        
                    $css->Cdiv();
                     
                                       
                    $css->div("", "pull-left", "", "", "", "", "");
                        if($ResultadosTotales>$Limit){
                            $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                            print('<div class="input-group" style=width:150px>');
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                            print('<span class="input-group-addon" onclick=CambiePagina(`6`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                            }
                            $FuncionJS="onchange=CambiePagina(`6`);";
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
                            print('<span class="input-group-addon" onclick=CambiePagina(`6`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
                            }
                            print("</div>");
                        }    
                    $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<thead>');  
                            $css->FilaTabla(16);    
                                print("<td colspan='10' style='width:100%'>");
                                        
                                print("</td>");
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);    
                                $css->ColTabla("<strong>Items</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Abonos</strong>", 1,"C"); 
                                $css->ColTabla("<strong>ID</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Fecha</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Fecha Vencimiento</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Cliente</strong>", 1,"C");
                                $css->ColTabla("<strong>Identificacion</strong>", 1,"C");
                                $css->ColTabla("<strong>Telefono</strong>", 1,"C");                                
                                $css->ColTabla("<strong>Valor</strong>", 1,"C");
                                $css->ColTabla("<strong>Saldo</strong>", 1,"C");
                                $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                //$css->ColTabla("<strong>Anular</strong>", 1,"C");
                                                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button type="button" class="btn btn-primary btn-sm" onclick=VerItemsSeparado(`'.$idItem.'`)><i class="fa fa-eye"></i></button>');
                                    print("</td>");
                                    
                                    print("<td>");
                                        print('<button type="button" class="btn btn-success btn-sm" onclick=VerAbonosSeparado(`'.$idItem.'`)><i class="fa fa-dollar"></i></button>');
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["ID"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["Fecha"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["FechaVencimiento"]."<strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["RazonSocial"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["Num_Identificacion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["Telefono"])."");
                                    print("</td>");
                                   
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["Total"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".number_format($RegistrosTabla["Saldo"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Estado"])."</strong>");
                                    print("</td>");
                                    
                                    /*
                                    print("<td>");
                                        $Icon="fa fa-trash";
                                        $Color="danger";
                                        $disabled="";
                                        if($RegistrosTabla["Estado"]<>'Abierto'){
                                            $disabled="disabled";
                                        }
                                        print('<button type="button" '.$disabled.' class="btn btn-'.$Color.' btn-sm" onclick=CambieEstadoCliente(`'.$idItem.'`)><i class="'.$Icon.'"></i></button>');
                                    print("</td>");
                                     * 
                                     */
                                                                                                            
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 2
        
        case 3: //ver items de los separados
            
            $idSeparado=$obCon->normalizar($_REQUEST["idSeparado"]);                       
            $sql="SELECT * 
                  FROM separados_items WHERE idSeparado='$idSeparado'";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>Items del Separado $idSeparado</strong>", "naranja");
            
            
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<thead>');  
                            $css->FilaTabla(16);    
                                print("<td colspan='10' style='width:100%'>");
                                        
                                print("</td>");
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);    
                                $css->ColTabla("<strong>Referencia</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Nombre</strong>", 1,"C"); 
                                $css->ColTabla("<strong>ValorUnitario</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Cantidad</strong>", 1,"C");
                                $css->ColTabla("<strong>TotalItem</strong>", 1,"C");
                                                                                               
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                print('<tr>');
                                                                      
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["Referencia"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["Nombre"]);
                                    print("</td>");
                                                                       
                                    print("<td class='mailbox-subject' style='text-align:right'>");
                                        print("".number_format($RegistrosTabla["ValorUnitarioItem"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject' style='text-align:right'>");
                                        print("<strong>".number_format($RegistrosTabla["Cantidad"])."</strong>");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject' style='text-align:right'>");
                                        print("".number_format($RegistrosTabla["TotalItem"])."");
                                    print("</td>");
                                    
                                                                                                                                                
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 3
        
        case 4: //ver los abonos de un separado
            
            $idSeparado=$obCon->normalizar($_REQUEST["idSeparado"]);                       
            $sql="SELECT * 
                  FROM separados_abonos WHERE idSeparado='$idSeparado'";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>Abonos del Separado $idSeparado</strong>", "verde");
            
            
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<thead>');  
                            $css->FilaTabla(16);    
                                print("<td colspan='10' style='width:100%'>");
                                        
                                print("</td>");
                            $css->CierraFilaTabla();
                            $css->FilaTabla(16);    
                                $css->ColTabla("<strong>Fecha</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Valor</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Comprobante</strong>", 1,"C"); 
                                $css->ColTabla("<strong>Usuario</strong>", 1,"C"); 
                                                                                               
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                print('<tr>');
                                                                      
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["Fecha"]." ".$RegistrosTabla["Hora"]." </strong>");
                                    print("</td>");
                                                                                                          
                                    print("<td class='mailbox-subject' style='text-align:right'>");
                                        print("".number_format($RegistrosTabla["Valor"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject' style='text-align:right'>");
                                        print("<strong>".($RegistrosTabla["idComprobanteIngreso"])."</strong>");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject' style='text-align:right'>");
                                        print("".($RegistrosTabla["idUsuarios"])."");
                                    print("</td>");
                                    
                                                                                                                                                
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 4
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>