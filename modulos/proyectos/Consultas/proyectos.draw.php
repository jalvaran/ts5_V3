<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../clases/proyectos.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Proyectos($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //dibuja el listado de proyectos
            
            
            $Limit=20;
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            
            $tabla="$db.vista_proyectos";
            $obCon->crear_vista_proyectos($db);
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $cmb_filtro_proyectos=$obCon->normalizar($_REQUEST["cmb_filtro_proyectos"]);
            $busqueda_general=$obCon->normalizar($_REQUEST["busqueda_general"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            
                        
            $Condicion=" WHERE ID>0 ";
            
            if($cmb_filtro_proyectos<>''){
                $Condicion.=" AND estado = '$cmb_filtro_proyectos' ";
            }
            
            if($FechaInicialRangos<>''){
                $Condicion.=" AND created >= '$FechaInicialRangos 00:00:00' ";
            }
            
            if($FechaFinalRangos<>''){
                $Condicion.=" AND created <= '$FechaFinalRangos 23:59:59' ";
            }
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items  
                   FROM $tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
                        
            $sql="SELECT * 
                  FROM $tabla $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            $css->CrearTitulo("<strong>Proyectos:</strong>", "verde");
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-blue">
                                  <div class="inner">
                                    <h3>'.$ResultadosTotales.'</h3>

                                    <p>Proyectos</p>
                                  </div>
                                  <div class="icon">
                                    <a class="fa fa-medkit" style="cursor:pointer" onclick=frm_crear_editar_proyecto(); return false></a>
                                  </div>
                                  
                                </div>
                              </div>');
                        $CondicionBase64= base64_encode(urlencode($Condicion));
                        $Link="procesadores/proyectos.process.php?Accion=2&c=$CondicionBase64";
                        if($TipoUser=="administrador"){
                            print('<div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                      <div class="inner">
                                        <h3>Exportar</h3>

                                        <p>Proyectos</p>
                                      </div>
                                      <div class="icon">
                                        <a href="'.$Link.'" target="_blank" class="fa fa-file-excel-o" style="cursor:pointer" ></a>
                                      </div>

                                    </div>
                                  </div>');
                        }
                        /*
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-blue">
                                  <div class="inner">
                                   
                                    <h3>Mensajería</h3>
                                    <p>Enviar un correo</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-send" style="cursor:pointer" onclick=DibujeRedactarCorreoClientes(`'.$CondicionBase64.'`); return false></i>
                                  </div>
                                  
                                </div>
                              </div>');
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
                                $css->ColTabla("<strong>Editar</strong>", 1,"C"); 
                                //$css->ColTabla("<strong>Ver</strong>", 1,"C");
                                $css->ColTabla("<strong>ID</strong>", 1,"C");
                                                                
                                $css->ColTabla("<strong>Nombre</strong>", 1,"C");
                                $css->ColTabla("<strong>Cliente</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha Inicio Planeada</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha Final Planeada</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha Inicio Ejecutada</strong>", 1,"C");
                                $css->ColTabla("<strong>Fecha Final Ejecutada</strong>", 1,"C");
                                $css->ColTabla("<strong>Costos Mano de Obra Planeada</strong>", 1,"C");
                                $css->ColTabla("<strong>Costos Mano de Obra Ejecutada</strong>", 1,"C");
                                $css->ColTabla("<strong>Costos Productos Planeados</strong>", 1,"C");
                                $css->ColTabla("<strong>Costos Productos Ejecutados</strong>", 1,"C");                                
                                $css->ColTabla("<strong>Gastos Fijos Planeados</strong>", 1,"C");
                                $css->ColTabla("<strong>Gastos Fijos Ejecutados</strong>", 1,"C");
                                $css->ColTabla("<strong>Costo Total del proyecto planeado</strong>", 1,"C");
                                $css->ColTabla("<strong>Costo Total del proyecto ejecutado</strong>", 1,"C");
                                $css->ColTabla("<strong>Diferencia Costos</strong>", 1,"C");
                                $css->ColTabla("<strong>Horas por Día</strong>", 1,"C");
                                $css->ColTabla("<strong>Excluir Sabados</strong>", 1,"C");
                                $css->ColTabla("<strong>Excluir Domingos</strong>", 1,"C");
                                $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                $css->ColTabla("<strong>Identificador</strong>", 1,"C");
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["proyecto_id"];
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button type="button" class="btn btn-warning btn-flat" onclick=frm_crear_editar_proyecto(`'.$idItem.'`)><i class="fa fa-edit"></i></button>');
                                    print("</td>");
                                                                        
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["ID"]."</strong>");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".($RegistrosTabla["nombre"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["cliente_razon_social"]." ".$RegistrosTabla["cliente_nit"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["fecha_inicio_planeacion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["fecha_final_planeacion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["fecha_inicio_ejecucion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["fecha_final_ejecucion"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["costos_mano_obra_planeacion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["costos_mano_obra_ejecucion"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["costos_productos_planeacion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["costos_productos_ejecucion"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["gastos_fijos_planeados"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["gastos_fijos_ejecutados"])."");
                                    print("</td>");
                                    
                                    
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["total_costos_planeacion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["total_costos_ejecucion"])."");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".number_format($RegistrosTabla["diferencia_costos_planeacion_ejecucion"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["horas_x_dia"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["excluir_sabados"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["excluir_domingos"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["nombre_estado"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["proyecto_id"]);
                                    print("</td>");
                                                                                                            
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 1
        
        case 2:  //formulario para crear un proyecto
                
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $datos_proyecto=$obCon->DevuelveValores("$db.proyectos", "proyecto_id", $proyecto_id);
            if($proyecto_id==''){
                $proyecto_id=$obCon->getUniqId("pr_");
            }
            $css->CrearTitulo("Crear o Editar un poyecto","azul");
            
            $css->input("hidden", "proyecto_id", "", "proyecto_id", "", $proyecto_id, "", "", "", "");
            $css->CrearDiv("div_row", "row", "left", 1, 1);
                $css->CrearDiv("", "col-md-5", "center", 1, 1);
                    print("<strong>Cliente:</strong><br>");
                    $css->select("cliente_id", "form-control", "cliente_id", "", "", "", "");
                        if($datos_proyecto["cliente_id"]<>''){
                            $css->option("", "", "", $datos_proyecto["cliente_id"], "", "");
                                $datos_cliente=$obCon->DevuelveValores($db.".clientes", "idClientes", $datos_proyecto["cliente_id"]);
                                print($datos_cliente["RazonSocial"]." ".$datos_cliente["Num_Identificacion"]);
                            $css->Coption();
                        }else{
                            $css->option("", "", "", "", "", "");
                                print("Seleccione un Cliente");
                            $css->Coption();
                        }
                        
                    $css->Cselect();
                $css->Cdiv();
                
                $css->CrearDiv("", "col-md-4", "center", 1, 1);
                    print("<strong>Nombre del Proyecto:</strong><br>");
                    $css->input("text", "nombre_proyecto", "form-control", "nombre_proyecto", "Nombre del proyecto", $datos_proyecto["nombre"], "Nombre del proyecto", "off", "", "");
                $css->Cdiv();
                
                $css->CrearDiv("", "col-md-3", "center", 1, 1);
                    print("<strong>Horas de Trabajo por día:</strong><br>");
                    $css->input("text", "horas_x_dia", "form-control", "horas_x_dia", "Horas de trabajo por día", $datos_proyecto["horas_x_dia"], "Horas", "off", "", "");
                $css->Cdiv();
                
                
                
            $css->Cdiv();
            print("<br><br>");
            $css->CrearDiv("div_row2", "row", "left", 1, 1);
                $css->CrearDiv("", "col-md-2", "center", 1, 1);
                    print("<strong>Excluir Sábados:</strong><br>");
                    $css->select("excluir_sabados", "form-control", "excluir_sabados", "", "", "", "");
                        $sel=0;
                        if($datos_proyecto["excluir_sabados"]==1){
                            $sel=1;
                        }
                        $css->option("", "", "", "0", "", "",$sel);
                            print("NO");
                        $css->Coption();
                        $sel=0;
                        if($datos_proyecto["excluir_sabados"]==1){
                            $sel=1;
                        }
                        $css->option("", "", "", "1", "", "",$sel);
                            print("SI");
                        $css->Coption();
                    $css->Cselect();
                $css->Cdiv();
                
                $css->CrearDiv("", "col-md-2", "center", 1, 1);
                    print("<strong>Excluir Domingos:</strong><br>");
                    $css->select("excluir_domingos", "form-control", "excluir_domingos", "", "", "", "");
                        $sel=0;
                        if($datos_proyecto["excluir_domingos"]==1){
                            $sel=1;
                        }
                        $css->option("", "", "", "0", "", "",$sel);
                            print("NO");
                        $css->Coption();
                        $sel=0;
                        if($datos_proyecto["excluir_domingos"]==1){
                            $sel=1;
                        }
                        $css->option("", "", "", "1", "", "",$sel);
                            print("SI");
                        $css->Coption();
                    $css->Cselect();
                $css->Cdiv();
                $css->CrearDiv("", "col-md-3", "center", 1, 1);
                    print("<strong>Excluir una fecha específica:</strong><br>");
                    print('<div class="input-group input-group-md">
                            <input id="fecha_excluida" type="date" class="form-control" style="line-height: 15px;">
                                <span class="input-group-btn">
                                  <button id="btn_excluir_fecha" type="button" class="btn btn-info btn-flat" onclick="agregar_fecha_excluida(`'.$proyecto_id.'`)" >Agregar</button>
                                </span>
                          </div>');
                $css->CerrarDiv();
                
                $css->CrearDiv("div_fechas_excluidas", "col-md-5", "center", 1, 1);
                    
                $css->CerrarDiv();
             
            $css->Cdiv();
            print("<br><br>");
            $css->CrearDiv("", "row", "center", 1, 1);
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                $css->CrearTitulo("<strong>Subir adjuntos al proyecto</strong>", "verde");
                print('<div class="panel">
                            
                            <div class="panel-body">
                                <form data-proyecto_id="'.$proyecto_id.'" action="/" class="dropzone dz-clickable" id="proyecto_adjuntos"><div class="dz-default dz-message"><span><i class="icon-plus"></i>Arrastre archivos aquí o de click para subir.<br> Suba cualquier tipo de archivos.</span></div></form>
                            </div>
                        </div>
                    ');
                $css->Cdiv();
                $css->CrearDiv("div_adjuntos_proyectos", "col-md-6", "center", 1, 1);
                    
                $css->CerrarDiv();
                
            $css->Cdiv();
            print("<br><br>");
            $css->CrearDiv("", "row", "center", 1, 1);
                $css->CrearDiv("", "col-md-9", "center", 1, 1);
                    
                $css->CerrarDiv();
                $css->CrearDiv("", "col-md-3", "center", 1, 1);
                    $css->CrearBotonEvento("btn_crear_editar_proyecto", "Guardar", 1, "onclick", "confirma_crear_editar_proyecto()", "azul", "");
                $css->CerrarDiv();
            $css->Cdiv();
        break;//Fin caso 2    
        
        case 3://Dibuja las fechas excluidas de un proyecto
            
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            
            $css->CrearTitulo("Fechas Excluidas en este proyecto", "azul");
            
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>ID</strong>", 1);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Eliminar</strong>", 1);
                $css->CierraFilaTabla();
                $sql="SELECT * FROM $db.proyectos_fechas_excluidas WHERE proyecto_id='$proyecto_id'";
                $Consulta=$obCon->Query($sql);
                while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                    $item_id=$datos_consulta["ID"];
                    $css->FilaTabla(14);
                        $css->ColTabla($datos_consulta["ID"], 1);
                        $css->ColTabla($datos_consulta["fecha_excluida"], 1);
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`1`,`$item_id`,`$proyecto_id`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                
            $css->CerrarTabla();
            
        break;//Fin caso 3   
        
        case 4: //Dibuja los adjuntos en un proyecto
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            
            $DatosEmpresa=$obCon->ValorActual("empresapro", "db", " idEmpresaPro='$empresa_id'");
            $db=$DatosEmpresa["db"];
            $datos_proyecto=$obCon->DevuelveValores("$db.proyectos", "proyecto_id", $proyecto_id);
            $css->CrearTitulo("Adjuntos de este proyecto");
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                
                    $css->ColTabla("ID", 1);
                    $css->ColTabla("Nombre de Archivo", 1);
                    
                    $css->ColTabla("Eliminar", 1);
                    
                $css->CierraFilaTabla();
                
                $sql="SELECT t1.*
                        FROM $db.proyectos_adjuntos t1 
                        WHERE t1.proyecto_id='$proyecto_id' 
                            ";
                $Consulta=$obCon->Query($sql);
                while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosConsulta["ID"];
                    $Nombre=$DatosConsulta["NombreArchivo"];
                    $css->FilaTabla(14);
                
                        $css->ColTabla($idItem, 1);
                       
                        print('<td style="text-align:center;color:blue;font-size:18px;">');
                            $Ruta= "../../".str_replace("../", "", $DatosConsulta["Ruta"]);
                            print('<a href="'.$Ruta.'" target="blank">'.$Nombre.' <li class="fa fa-paperclip"></li></a>');
                        print('</td>');
                        
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`2`,`$idItem`,`$proyecto_id`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                          
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
            
        break; //Fin caso 4
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>