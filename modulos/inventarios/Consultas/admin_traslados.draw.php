<?php

@session_start();
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
        
        case 1: //dibuja el listado de traslados
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Filtro=$obCon->normalizar($_REQUEST["Filtro"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
            $Estado=$obCon->normalizar($_REQUEST["cmb_estado_traslado"]);            
            $Condicion=" WHERE ID<>'' ";
            
            if($Busquedas<>''){
                $Condicion.=" AND (ID like '$Busquedas%')";
            }
            if($Estado<>''){
                $Condicion.=" AND (Estado like '$Estado')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items  
                   FROM traslados_mercancia t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            
            
            $sql="SELECT * 
                  FROM traslados_mercancia $Condicion ORDER BY Fecha DESC,ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>$ResultadosTotales Traslados</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                                                               
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
                                $css->ColTabla("<strong>Acciones</strong>", 2,"C");
                                $css->ColTabla("<strong>ID</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha</strong>", 1,"C");
                                $css->ColTabla("<strong>Hora</strong>", 1,"C");
                                $css->ColTabla("<strong>Origen</strong>", 1,"C");
                                $css->ColTabla("<strong>Consecutivo Interno</strong>", 1,"C");
                                $css->ColTabla("<strong>Destino</strong>", 1,"C");
                                $css->ColTabla("<strong>Descripcion</strong>", 1,"C");
                                $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                $disabled="";
                                if($RegistrosTabla["Estado"]<>'EN DESARROLLO'){
                                    $disabled="disabled";
                                }
                                print('<tr>');
                                    print("<td>");
                                        print('<button title="Agregar Items" '.$disabled.' type="button" class="btn btn-primary btn-sm" onclick=frm_agregar_items_traslado(`'.$idItem.'`)><i class="fa fa-plus-square"></i></button>');
                                        
                                    print("</td>");
                                    print("<td>");
                                        $link="procesadores/pdf_traslados.process.php?Accion=1&traslado_id=$idItem";
                                        print('<a title="Ver PDF" href="'.$link.'" target="_blank" class="btn btn-danger btn-sm" ><i class="fa fa-file-pdf-o"></i></button>');
                                        
                                    print("</td>");
                                    print("<td class='mailbox-name'>");
                                        print($idItem);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["Fecha"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["Hora"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print(($RegistrosTabla["Origen"]));
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["ConsecutivoInterno"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Destino"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Descripcion"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Estado"])."</strong>");
                                    print("</td>");
                                    
                                    
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 1
        
        case 2://Formulario para crear un traslado
            $css->input("hidden", "formulario_id", "form-control", "formulario_id", "", 1, "", "", "", "");
            $css->CrearTabla();
                $css->FilaTabla(16);
                   

                    $css->ColTabla("<strong>Destino</strong>", 1);
                    $css->ColTabla("<strong>Descripcion</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                     
                print("<td>"); 
                    $css->select("CmbDestino", "form-control", "CmbDestino", "", "", "", "");
                        $css->option("", "", "", 0, "", "");
                            print("Seleccione el destino");
                        $css->Coption();
                        $sql="SELECT * FROM empresa_pro_sucursales WHERE Visible='SI' AND Actual=0";
                        $Consulta=$obCon->Query($sql);
                        while($DatosSucursales=$obCon->FetchArray($Consulta)){
                            $css->option("", "", "", $DatosSucursales["ID"], "", "");
                               print("$DatosSucursales[Nombre] $DatosSucursales[Ciudad] $DatosSucursales[Direccion]");
                            $css->Coption();
                        }
                    $css->Cselect();
                
                  
                print("</td>");
                print("<td>");
                    $css->textarea("TxtDescripcion", "form-control", "TxtDescripcion", "", "Descripcion", "", "");
                    
                    $css->Ctextarea();
                print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
            
        break;//Fin caso 2
        
        case 3://Formulario para agregar items a un traslado
            
            $traslado_id=$obCon->normalizar($_REQUEST["traslado_id"]);
            if($traslado_id==''){
                $css->Notificacion("Error", "No se recibió el numero de un traslado", "rojo", "", "");
                exit();
            }
            
            $datos_traslado=$obCon->DevuelveValores("traslados_mercancia", "ID", $traslado_id);
            if($datos_traslado["Estado"]<>'EN DESARROLLO'){
                $css->Notificacion("Error", "El traslado $traslado_id no se encuentra en estado de desarrollo", "rojo", "", "");
                exit();
            }
            $observaciones=$datos_traslado["Descripcion"];
            $css->input("hidden", "traslado_id_add", "form-control", "traslado_id_add", "", $traslado_id, "", "", "", "");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("AGREGAR ITEMS PARA EL TRASLADO <strong>$traslado_id</strong>, $observaciones", 5,"C");                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CÓDIGO</strong>",1,"C");
                    $css->ColTabla("<strong>BUSCAR</strong>",2,"C"); 
                    $css->ColTabla("<strong>CANTIDAD</strong>",1,"C");
                    $css->ColTabla("<strong>AGREGAR</strong>",1,"C");                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print('<td>');
                        $css->input("text", "TxtCodigo", "form-control", "TxtCodigo", "", "", "Codigo", "off", "", "");
                    print('</td>');
                    print('<td colspan="2">');
                    
                        $css->select("producto_id", "form-control", "producto_id", "", "", '', 'style="width:500px;"');
                            $css->option("", "", "", "", "", "");
                                print("Seleccione un producto");
                            $css->Coption();
                        $css->Cselect();
                    print('</td>');
                    print('<td>');
                        $css->input("number", "TxtCantidad", "form-control", "TxtCantidad", "", "1", "Cantidad", "off", "", "");
                    print('</td>');
                    print('<td>');
                        $css->CrearBotonEvento("btn_agregar_item", "Agregar", 1, "onclick", "agregar_item_traslado()", "verde");
                    print('</td>');
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
            $css->CrearDiv("div_traslados_items", "col-md-12", "left", 1, 1);
            
            $css->CerrarDiv();
            
        break;//Fin caso 3
        
        case 4://listado de items de un traslado
            
            $traslado_id=$obCon->normalizar($_REQUEST["traslado_id"]);
            
            if($traslado_id==''){
                $css->Notificacion("Error", "No se recibió el numero de un traslado", "rojo", "", "");
                exit();
            }
            
            $sql="SELECT * FROM traslados_items WHERE idTraslado='$traslado_id' AND Deleted='0000-00-00 00:00:00' ORDER BY Updated DESC";
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>ITEMS AGREGADOS AL TRASLADO</strong>", 4,"C");
                    print("<td>");
                        $css->CrearBotonEvento("btn_guardar_traslado", "Guardar", 1, "onclick", "confirma_guardar_traslado(`$traslado_id`)", "rojo");
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>ID DEL PRODUCTO</strong>", 1,"C");
                    $css->ColTabla("<strong>PRODUCTO</strong>", 1,"C");
                    $css->ColTabla("<strong>REFERENCIA</strong>", 1,"C");
                    $css->ColTabla("<strong>CANTIDAD</strong>", 1,"C");
                    $css->ColTabla("<strong>ELIMINAR</strong>", 1,"C");
                $css->CierraFilaTabla();
                
            $Consulta=$obCon->Query($sql);
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                $item_id=$datos_consulta["ID"];
                $css->FilaTabla(14);
                    $css->ColTabla($datos_consulta["CodigoBarras"], 1);
                    $css->ColTabla($datos_consulta["Nombre"], 1);
                    $css->ColTabla($datos_consulta["Referencia"], 1);
                    $css->ColTabla($datos_consulta["Cantidad"], 1,"R");
                    
                    print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   

                        $css->li("", "fa  fa-remove", "", "onclick='borrar_item_traslado(`1`,`$item_id`,`$traslado_id`);' style=font-size:16px;cursor:pointer;text-align:center;color:red");
                        $css->Cli();
                    print("</td>");
                $css->CierraFilaTabla();
                
                
                
            }
            $css->CerrarTabla();
            
        break;//Fin caso 4    
        
        
        case 5: //dibuja el listado de traslados pendientes por subir
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Filtro=$obCon->normalizar($_REQUEST["Filtro"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
            $datos_sucursal=$obCon->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
            $sucursal_id=$datos_sucursal["ID"];
                  
            $Condicion=" WHERE Origen='$sucursal_id' AND Estado='PREPARADO' AND ServerSincronizado='0000-00-00 00:00:00'";
            
            if($Busquedas<>''){
                $Condicion.=" AND (ID like '$Busquedas%')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items  
                   FROM traslados_mercancia t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            
            
            $sql="SELECT * 
                  FROM traslados_mercancia $Condicion ORDER BY Fecha DESC,ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>$ResultadosTotales Traslados por subir</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                                                               
                        $css->div("", "pull-left", "", "", "", "", "");
                            if($ResultadosTotales>$Limit){
                                $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                                print('<div class="input-group" style=width:150px>');
                                if($NumPage>1){
                                    $NumPage1=$NumPage-1;
                                print('<span class="input-group-addon" onclick=CambiePagina(`2`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                                }
                                $FuncionJS="onchange=CambiePagina(`2`);";
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
                                print('<span class="input-group-addon" onclick=CambiePagina(`2`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
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
                                $css->ColTabla("<strong>Acciones</strong>", 2,"C");
                                $css->ColTabla("<strong>ID</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha</strong>", 1,"C");
                                $css->ColTabla("<strong>Hora</strong>", 1,"C");
                                $css->ColTabla("<strong>Origen</strong>", 1,"C");
                                $css->ColTabla("<strong>Consecutivo Interno</strong>", 1,"C");
                                $css->ColTabla("<strong>Destino</strong>", 1,"C");
                                $css->ColTabla("<strong>Descripcion</strong>", 1,"C");
                                $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                $disabled="";
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button id="btn_subir_'.$idItem.'" title="Subir Traslado" '.$disabled.' type="button" class="btn btn-success btn-sm" onclick=iniciar_subir_traslado(`'.$idItem.'`)><i class="fa fa-cloud-upload"></i></button>');
                                        
                                    print("</td>");
                                    print("<td>");
                                        $link="procesadores/pdf_traslados.process.php?Accion=1&traslado_id=$idItem";
                                        print('<a title="Ver PDF" href="'.$link.'" target="_blank" class="btn btn-danger btn-sm" ><i class="fa fa-file-pdf-o"></i></button>');
                                        
                                    print("</td>");
                                    print("<td class='mailbox-name'>");
                                        print($idItem);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["Fecha"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["Hora"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print(($RegistrosTabla["Origen"]));
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["ConsecutivoInterno"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Destino"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Descripcion"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Estado"])."</strong>");
                                    print("</td>");
                                    
                                    
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 5
        
        case 6: //dibuja el listado de traslados pendientes por descargar
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Filtro=$obCon->normalizar($_REQUEST["Filtro"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
            $datos_sucursal=$obCon->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
            
            $sucursal_id=$datos_sucursal["ID"];
            $datos_servidores=$obCon->DevuelveValores("servidores", "ID", 1);   
            $Condicion=" WHERE Destino='$sucursal_id' AND (Estado='PREPARADO' or Estado='ENVIADO') AND DestinoSincronizado='0000-00-00 00:00:00'";
            
            if($Busquedas<>''){
                $Condicion.=" AND (ID like '$Busquedas%')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items  
                   FROM traslados_mercancia t1 $Condicion;";
            
            //$Consulta=$obCon->Query($sql);
            $Consulta=$obCon->QueryExterno($sql, $datos_servidores["IP"], $datos_servidores["Usuario"], $datos_servidores["Password"], $datos_servidores["DataBase"], "");
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            
            
            $sql="SELECT * 
                  FROM traslados_mercancia $Condicion ORDER BY Fecha DESC,ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->QueryExterno($sql, $datos_servidores["IP"], $datos_servidores["Usuario"], $datos_servidores["Password"], $datos_servidores["DataBase"], "");
            //$Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>$ResultadosTotales Traslados por Descargar</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                                                               
                        $css->div("", "pull-left", "", "", "", "", "");
                            if($ResultadosTotales>$Limit){
                                $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                                print('<div class="input-group" style=width:150px>');
                                if($NumPage>1){
                                    $NumPage1=$NumPage-1;
                                print('<span class="input-group-addon" onclick=CambiePagina(`3`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                                }
                                $FuncionJS="onchange=CambiePagina(`3`);";
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
                                print('<span class="input-group-addon" onclick=CambiePagina(`3`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
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
                                $css->ColTabla("<strong>Fecha</strong>", 1,"C");
                                $css->ColTabla("<strong>Hora</strong>", 1,"C");
                                $css->ColTabla("<strong>Origen</strong>", 1,"C");
                                $css->ColTabla("<strong>Consecutivo Interno</strong>", 1,"C");
                                $css->ColTabla("<strong>Destino</strong>", 1,"C");
                                $css->ColTabla("<strong>Descripcion</strong>", 1,"C");
                                $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                $disabled="";
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button id="btn_descargar_'.$idItem.'" title="Descargar Traslado" '.$disabled.' type="button" class="btn btn-warning btn-sm" onclick=iniciar_descarga_traslado(`'.$idItem.'`)><i class="fa fa-cloud-download"></i></button>');
                                        
                                    print("</td>");
                                    
                                    print("<td class='mailbox-name'>");
                                        print($idItem);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["Fecha"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["Hora"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print(($RegistrosTabla["Origen"]));
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["ConsecutivoInterno"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Destino"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Descripcion"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Estado"])."</strong>");
                                    print("</td>");
                                    
                                    
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 6
        
        case 7: //dibuja el listado de pendientes por verificar
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Filtro=$obCon->normalizar($_REQUEST["Filtro"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
            $datos_sucursal=$obCon->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
            $sucursal_id=$datos_sucursal["ID"];
                  
            $Condicion=" WHERE Destino='$sucursal_id' AND (Estado='PREPARADO' OR Estado='RECIBIDO' ) ";
            
            if($Busquedas<>''){
                $Condicion.=" AND (ID like '$Busquedas%')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items  
                   FROM traslados_mercancia t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            
            
            $sql="SELECT * 
                  FROM traslados_mercancia $Condicion ORDER BY Fecha DESC,ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>$ResultadosTotales Traslados pendientes por Validar</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                                                               
                        $css->div("", "pull-left", "", "", "", "", "");
                            if($ResultadosTotales>$Limit){
                                $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                                print('<div class="input-group" style=width:150px>');
                                if($NumPage>1){
                                    $NumPage1=$NumPage-1;
                                print('<span class="input-group-addon" onclick=CambiePagina(`4`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                                }
                                $FuncionJS="onchange=CambiePagina(`4`);";
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
                                print('<span class="input-group-addon" onclick=CambiePagina(`4`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
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
                                $css->ColTabla("<strong>Acciones</strong>", 2,"C");
                                $css->ColTabla("<strong>ID</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha</strong>", 1,"C");
                                $css->ColTabla("<strong>Hora</strong>", 1,"C");
                                $css->ColTabla("<strong>Origen</strong>", 1,"C");
                                $css->ColTabla("<strong>Consecutivo Interno</strong>", 1,"C");
                                $css->ColTabla("<strong>Destino</strong>", 1,"C");
                                $css->ColTabla("<strong>Descripcion</strong>", 1,"C");
                                $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                $disabled="";
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button id="btn_validar_'.$idItem.'" title="Validar Traslado" '.$disabled.' type="button" class="btn btn-success btn-sm" onclick=frm_validar_traslado(`'.$idItem.'`)><i class="fa fa-check-square-o"></i></button>');
                                        
                                    print("</td>");
                                    print("<td>");
                                        $link="procesadores/pdf_traslados.process.php?Accion=1&traslado_id=$idItem";
                                        print('<a title="Ver PDF" href="'.$link.'" target="_blank" class="btn btn-danger btn-sm" ><i class="fa fa-file-pdf-o"></i></button>');
                                        
                                    print("</td>");
                                    print("<td class='mailbox-name'>");
                                        print($idItem);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["Fecha"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["Hora"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print(($RegistrosTabla["Origen"]));
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["ConsecutivoInterno"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Destino"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Descripcion"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Estado"])."</strong>");
                                    print("</td>");
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 7
        
        case 8:// dibuja los items de un traslado para verificarlo
            $traslado_id=$obCon->normalizar($_REQUEST["traslado_id"]);
            
            if($traslado_id==''){
                $css->Notificacion("Error", "No se recibió el numero de un traslado", "rojo", "", "");
                exit();
            }
            
            $sql="SELECT * FROM traslados_items WHERE idTraslado='$traslado_id' AND Deleted='0000-00-00 00:00:00'";
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("ITEMS DEL TRASLADO <strong>$traslado_id</strong>", 3,"C");
                    print("<td>");
                        $css->CrearBotonEvento("btn_guardar_traslado", "Verificar Traslado", 1, "onclick", "confirma_validar_traslado(`$traslado_id`)", "rojo");
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>ID DEL PRODUCTO</strong>", 1,"C");
                    $css->ColTabla("<strong>PRODUCTO</strong>", 1,"C");
                    $css->ColTabla("<strong>REFERENCIA</strong>", 1,"C");
                    $css->ColTabla("<strong>CANTIDAD</strong>", 1,"C");
                    
                $css->CierraFilaTabla();
                
            $Consulta=$obCon->Query($sql);
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                $item_id=$datos_consulta["ID"];
                $css->FilaTabla(14);
                    $css->ColTabla($datos_consulta["CodigoBarras"], 1);
                    $css->ColTabla($datos_consulta["Nombre"], 1);
                    $css->ColTabla($datos_consulta["Referencia"], 1);
                    $css->ColTabla($datos_consulta["Cantidad"], 1,"R");                
                    
                $css->CierraFilaTabla();
                
                
                
            }
            $css->CerrarTabla();
        break;//Fin caso 8   
        
        case 9: //dibuja los items de los traslados
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Filtro=$obCon->normalizar($_REQUEST["Filtro"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
                        
            $Condicion=" WHERE Deleted='0000-00-00 00:00:00' ";
            
            if($Busquedas<>''){
                $Condicion.=" AND (idTraslado = '$Busquedas' or CodigoBarras = '$Busquedas' or Referencia like '$Busquedas%' or Nombre like '%$Busquedas%')";
            }
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(*) as Items  
                   FROM traslados_items t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            
            
            $sql="SELECT * 
                  FROM traslados_items $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>$ResultadosTotales items en los traslados</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                                                               
                        $css->div("", "pull-left", "", "", "", "", "");
                            if($ResultadosTotales>$Limit){
                                $TotalPaginas= ceil($ResultadosTotales/$Limit);                               
                                print('<div class="input-group" style=width:150px>');
                                if($NumPage>1){
                                    $NumPage1=$NumPage-1;
                                print('<span class="input-group-addon" onclick=CambiePagina(`5`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-left"></i></span>');
                                }
                                $FuncionJS="onchange=CambiePagina(`5`);";
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
                                print('<span class="input-group-addon" onclick=CambiePagina(`5`,`'.$NumPage1.'`) style=cursor:pointer><i class="fa fa-chevron-right" ></i></span>');
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
                                
                                $css->ColTabla("<strong>ID</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha</strong>", 1,"C");
                                $css->ColTabla("<strong>Traslado</strong>", 1,"C");
                                $css->ColTabla("<strong>ID Producto</strong>", 1,"C");
                                $css->ColTabla("<strong>Referencia</strong>", 1,"C");
                                $css->ColTabla("<strong>Nombre</strong>", 1,"C");
                                $css->ColTabla("<strong>Cantidad</strong>", 1,"C");
                                $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                print('<tr>');
                                    
                                    print("<td class='mailbox-name'>");
                                        print($idItem);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["Fecha"]."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject' style=text-align:right>");
                                        print($RegistrosTabla["idTraslado"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject' style=text-align:right>");
                                        print(($RegistrosTabla["CodigoBarras"]));
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Referencia"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Nombre"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject' style=text-align:right>");
                                        print("<strong>".($RegistrosTabla["Cantidad"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["Estado"])."</strong>");
                                    print("</td>");
                                    
                                    
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 9
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>