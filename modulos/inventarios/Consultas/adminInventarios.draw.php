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
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>