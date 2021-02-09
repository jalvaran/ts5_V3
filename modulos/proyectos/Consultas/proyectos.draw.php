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
                                    <a class="fa fa-medkit" style="cursor:pointer" onclick=frm_crear_editar_proyecto(``,`'.$Page.'`); return false></a>
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
                                $css->ColTabla("<strong>Acciones</strong>", 1,"C"); 
                                //$css->ColTabla("<strong>Ver</strong>", 1,"C");
                                $css->ColTabla("<strong>ID</strong>", 1,"C");
                                                                
                                $css->ColTabla("<strong>Nombre_del_proyecto</strong>", 1,"C");
                                $css->ColTabla("<strong>Razon_Social_del_Cliente</strong>", 1,"C");
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
                                        print('<button title="Editar" type="button" class="btn btn-primary btn-flat" onclick=frm_crear_editar_proyecto(`'.$idItem.'`,`'.$Page.'`)><i class="fa fa-edit"></i></button>');
                                        print('<button title="Tareas" type="button" class="btn btn-warning btn-flat" onclick=mostrar_calendario_proyecto(`'.$idItem.'`)><i class="fa fa-calendar"></i></button>');
                                    print("</td>");

                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["ID"]."</strong>");
                                    print("</td>");

                                    print("<td >");
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
                                /*
                                print('<tr >');
                                    print('<td colspan="22" id="fila_proyecto_'.$idItem.'" >');
                                    print('</td>');
                                print('</tr>');
                                 * 
                                 */

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 1
        
        case 2:  //formulario para crear o editar un proyecto
                
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $datos_proyecto=$obCon->DevuelveValores("$db.proyectos", "proyecto_id", $proyecto_id);
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            if($proyecto_id==''){
                $proyecto_id=$obCon->getUniqId("pr_");
            }
            $css->div("", "col-md-12", "", "", "", "", "");
                $css->CrearTitulo("Crear o Editar un proyecto","azul");
            $css->Cdiv(); 
            /*
            $css->CrearDiv("", "col-md-1", "right", 1, 1); 
                    
                    print("<button id='btn_home_proyectos' class='btn btn-primary fa fa-mail-reply' onclick='MostrarListadoSegunID(`$Page`);'></button>");
                $css->CerrarDiv(); 
             * 
             */
            $css->input("hidden", "proyecto_id", "", "proyecto_id", "", $proyecto_id, "", "", "", "");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", "");
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
            /*
            print("<br><br>");
            $css->CrearDiv("", "row", "center", 1, 1);
                $css->CrearDiv("", "col-md-9", "center", 1, 1);
                    
                $css->CerrarDiv();
                $css->CrearDiv("", "col-md-3", "center", 1, 1);
                    $css->CrearBotonEvento("btn_crear_editar_proyecto", "Guardar", 1, "onclick", "confirma_crear_editar_proyecto()", "azul", "");
                $css->CerrarDiv();
            $css->Cdiv();
             * 
             */
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
        
        
        case 5: //dibuja el listado de tareas 
            
            
            $Limit=50;
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            
            $tabla="$db.vista_proyectos_tareas";
            
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $cmb_filtro_tareas=$obCon->normalizar($_REQUEST["cmb_filtro_tareas"]);
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            
            $busqueda_general=$obCon->normalizar($_REQUEST["busqueda_general"]);
            $FechaInicialRangos=$obCon->normalizar($_REQUEST["FechaInicialRangos"]);
            $FechaFinalRangos=$obCon->normalizar($_REQUEST["FechaFinalRangos"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            
                        
            $Condicion=" WHERE ID>0 ";
            
            if($cmb_filtro_tareas<>''){
                $Condicion.=" AND estado = '$cmb_filtro_tareas' ";
            }
            
            if($proyecto_id<>''){
                $Condicion.=" AND proyecto_id = '$proyecto_id' ";
                $Limit=1000;
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
            
            if($proyecto_id ==''){
                $css->CrearTitulo("<strong>Tareas:</strong>", "verde");
            }else{
                $datos_proyecto=$obCon->DevuelveValores("$db.proyectos", "proyecto_id", $proyecto_id);
                $css->CrearTitulo("<strong>Tareas del proyecto $datos_proyecto[ID], $datos_proyecto[nombre]:</strong>", "verde");
            }
            
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                    $css->CrearDiv("", "row", "left", 1, 1);
                        print('<div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                  <div class="inner">
                                    <h3>'.$ResultadosTotales.'</h3>

                                    <p>Tareas</p>
                                  </div>
                                  <div class="icon">
                                    <a class="fa fa-plus-square" style="cursor:pointer" onclick=frm_crear_editar_proyecto_tarea(`'.$tarea_id.'`,`'.$proyecto_id.'`); return false;></a>
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

                                        <p>Tareas</p>
                                      </div>
                                      <div class="icon">
                                        <a href="'.$Link.'" target="_blank" class="fa fa-file-excel-o" style="cursor:pointer" ></a>
                                      </div>

                                    </div>
                                  </div>');
                        }
                        
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
                                $css->ColTabla("<strong>Nombre_del_proyecto</strong>", 1,"C");
                                $css->ColTabla("<strong>Nombre_de_la_Tarea</strong>", 1,"C");
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
                                $css->ColTabla("<strong>Costo Total de la tarea planeado</strong>", 1,"C");
                                $css->ColTabla("<strong>Costo Total de la tarea ejecutado</strong>", 1,"C");
                                $css->ColTabla("<strong>Diferencia Costos</strong>", 1,"C");                                
                                $css->ColTabla("<strong>Estado</strong>", 1,"C");
                                $css->ColTabla("<strong>Identificador</strong>", 1,"C");
                                
                            $css->CierraFilaTabla();
                        print('<t/head>');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["proyecto_id"];
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button title="Editar" type="button" class="btn btn-primary btn-flat" onclick=frm_crear_editar_proyecto(`'.$idItem.'`,`'.$Page.'`)><i class="fa fa-edit"></i></button>');
                                        print('<button title="Actividades" type="button" class="btn btn-success btn-flat" onclick=listar_actividades(`'.$idItem.'`)><i class="fa fa-list-alt"></i></button>');
                                    print("</td>");
                                                                        
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".$RegistrosTabla["ID"]."</strong>");
                                    print("</td>");
                                    
                                    print("<td >");
                                        print("<strong>".($RegistrosTabla["nombre_proyecto"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("".($RegistrosTabla["nombre_tarea"])."");
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
                                        print("".($RegistrosTabla["nombre_estado"])."");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print($RegistrosTabla["tarea_id"]);
                                    print("</td>");
                                                                                                            
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break; //Fin caso 5
        
        case 6: //dibuja el calendario de un proyecto
            
            $Limit=50;
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            
            $datos_proyecto=$obCon->DevuelveValores("$db.proyectos", "proyecto_id", $proyecto_id);
            
            $css->div("", "row", "", "", "", "", "");
                $css->CrearTitulo("<strong>Calendario de planeación del proyecto $datos_proyecto[ID], $datos_proyecto[nombre]</strong>", "azul");
                $css->div("div_lista_tareas", "col-md-3", "", "", "", "", "");
                    
                    
                $css->Cdiv(); 
                
                $css->div("", "col-md-9","", "", "", "", "");
                    $css->div("", "col-md-5","", "", "", "", "style='text-align:right'");
                        
                    $css->Cdiv();
                    $css->div("", "col-md-3","", "", "", "", "style='text-align:right'");
                        print("<strong>Ir a la fecha:</strong>");
                    $css->Cdiv();
                    $css->div("", "col-md-4","", "", "", "", "");
                        $css->input("date", "date_goto", "form-control", "date_goto", "Fecha", "", "ir a", "off", "", "","style='line-height: 15px;'");
                    $css->Cdiv();
                    $css->div("calendar-wrap", "", "", "", "", "", "");
                        $css->div("calendar", "col-md-12", "", "", "", "", "");
                        
                        $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
                
            $css->Cdiv();
            
        break; //Fin caso 6   
        
    
        case 7:  //formulario para crear o editar una tarea de un proyecto
                
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $tarea_id=$obCon->normalizar($_REQUEST["tarea_id"]);
            $datos_tarea=$obCon->DevuelveValores("$db.proyectos_tareas", "tarea_id", $tarea_id);
            
            if($tarea_id==''){
                $tarea_id=$obCon->getUniqId("");
            }
            $css->div("", "col-md-12", "", "", "", "", "");
                $css->CrearTitulo("Crear o Editar una tarea","azul");
            $css->Cdiv(); 
            
            $css->input("hidden", "proyecto_tarea_id", "", "proyecto_tarea_id", "", $proyecto_id, "", "", "", "");
            $css->input("hidden", "tarea_id", "", "tarea_id", "", $tarea_id, "", "", "", "");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 2, "", "", "", "");
            $css->CrearDiv("div_row", "row", "left", 1, 1);
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->CrearDiv("", "col-md-8", "center", 1, 1);
                        print("<strong>Título de la Tarea:</strong><br>");
                        $css->input("text", "titulo_tarea", "form-control", "titulo_tarea", "Título de la tarea", $datos_tarea["titulo_tarea"], "Título de la tarea", "off", "", "");
                    $css->Cdiv();

                    $css->CrearDiv("", "col-md-4", "center", 1, 1);
                        $color="#3041c2";
                        if($datos_tarea["color"]<>""){
                            $color=$datos_tarea["color"];
                        }
                        print("<strong>Color:</strong><br>");
                        $css->input("color", "color_tarea", "form-control", "color_tarea", "Color para esta tarea", $color, "Color para esta tarea", "off", "", "");
                    $css->Cdiv();    
                    print("<br><br><br>");
                    $css->CrearDiv("", "row", "center", 1, 1);
                        
                        $css->CrearDiv("", "col-md-12", "center", 1, 1);
                            $css->CrearTitulo("<strong>Subir adjuntos a esta tarea</strong>", "verde");
                            print('<div class="panel">

                                        <div class="panel-body">
                                            <form data-proyecto_id="'.$proyecto_id.'" data-tarea_id="'.$tarea_id.'" action="/" class="dropzone dz-clickable" id="tarea_adjuntos"><div class="dz-default dz-message"><span><i class="icon-plus"></i>Arrastre archivos aquí o de click para subir.<br> Suba cualquier tipo de archivos.</span></div></form>
                                        </div>
                                    </div>
                                ');
                        $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
                
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->CrearDiv("div_adjuntos_tareas", "col-md-12", "center", 1, 1);
                    
                    $css->CerrarDiv();
                $css->Cdiv();
                
            $css->Cdiv();
            
            
        break;//Fin caso 7
        
        case 8: //Dibuja los adjuntos de una tarea
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $tarea_id=$obCon->normalizar($_REQUEST["tarea_id"]);
            
            $DatosEmpresa=$obCon->ValorActual("empresapro", "db", " idEmpresaPro='$empresa_id'");
            $db=$DatosEmpresa["db"];
            
            $css->CrearTitulo("Adjuntos de esta tarea");
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                
                    $css->ColTabla("ID", 1);
                    $css->ColTabla("Nombre de Archivo", 1);
                    
                    $css->ColTabla("Eliminar", 1);
                    
                $css->CierraFilaTabla();
                
                $sql="SELECT t1.*
                        FROM $db.proyectos_tareas_adjuntos t1 
                        WHERE t1.tarea_id='$tarea_id' 
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
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`3`,`$idItem`,`$tarea_id`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                          
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
            
        break; //Fin caso 8
        
        case 9:// lista de tareas y actividades de un proyecto
            
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];            
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $sql="SELECT COUNT(ID) as total_items FROM $db.proyectos_tareas WHERE proyecto_id='$proyecto_id'";
            $datos_totales=$obCon->FetchAssoc($obCon->Query($sql));
            
            
            $css->div("external-events", "row", "", "", "", "", "");

                $css->div("", "box box-solid", "", "", "", "", "");
                    $css->div("", "box box-solid", "", "", "", "", "");
                        print('<strong class="box-title">Listado de Tareas</strong><br>');
                        print('<a class="btn btn-app" style="background-color:#282c4b;color:white;" onclick="frm_crear_editar_proyecto_tarea(``,`'.$proyecto_id.'`)">
                                    <span class="badge bg-blue" style="font-size:14px">'.$datos_totales["total_items"].'</span>
                                    <i class="fa fa-plus-circle"></i> Agregar Tarea 
                                  </a>');
                    $css->Cdiv();
                $css->Cdiv();
                
                $css->div("", "box-body", "", "", "", "", "");
                    $css->div("external-events-list", "", "", "", "", "", "");
                        $css->div("accordion", "box-group", "", "", "", "", "");
                                                    
                            $sql="SELECT * FROM $db.proyectos_tareas WHERE proyecto_id='$proyecto_id'";
                            $Consulta=$obCon->Query($sql);
                            $i=0;
                            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                                $i++;
                                $css->div("", "row", "", "", "", "", "");
                                $css->div("", "panel box box-primary", "", "", "", "", "");
                                    $tarea_id=$datos_consulta["tarea_id"];
                                    //$css->div("", "col-md-8", "", "", "", "", "");
                                        $css->div("", "box-header with-border", "", "", "", "", "");
                                            print('<h4 class="box-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$datos_consulta["ID"].'" aria-expanded="false" class="collapsed">
                                                          '.$datos_consulta["titulo_tarea"].'
                                                        </a>
                                                      </h4>');
                                            print('<span class="pull-right">
                                                    <i class="fa fa-plus-square-o" style="color:green;cursor:pointer;" onclick="frm_crear_editar_proyecto_tarea_actividad(``,`'.$datos_consulta["tarea_id"].'`,`'.$datos_consulta["proyecto_id"].'`)" ></i>                                                
                                                    <i class="fa fa-edit" style="color:orange;cursor:pointer;" onclick="frm_crear_editar_proyecto_tarea(`'.$datos_consulta["tarea_id"].'`,`'.$datos_consulta["proyecto_id"].'`)"  ></i>
                                                    <i class="fa fa-trash-o" style="color:red;cursor:pointer;"></i>
                                                  </span><br>');
                                            print('<small id="sp_horas_'.$datos_consulta["tarea_id"].'" class="label label-danger"><i class="fa fa-clock-o"></i> 2 Horas</small>');
                                            print('<div id="collapse_'.$datos_consulta["ID"].'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">');

                                                $css->div("div_actividades_".$tarea_id, "box-body", "", "", "", "", "");

                                                    
                                                    print("<h4>Actividades</h4>");
                                                    
                                                    $sql="SELECT * FROM $db.proyectos_actividades WHERE tarea_id='$tarea_id'";
                                                    $Consulta2=$obCon->Query($sql);
                                                    
                                                    while($datos_actividades=$obCon->FetchAssoc($Consulta2)){
                                                        $css->div("", "row", "", "", "", "", "");
                                                            
                                                            print('<div id="'.$datos_actividades["actividad_id"].'" data-actividad_id="'.$datos_actividades["actividad_id"].'" data-tarea_id="'.$tarea_id.'" data-proyecto_id="'.$proyecto_id.'" title="click izquierdo para editar, click derecho para eliminar" class=" fc-event  external-event ui-draggable ui-draggable-handle" style="position: relative;color:white;background-color:'.$datos_actividades["color"].'">'.$datos_actividades["titulo_actividad"].'</div>');
                                                            
                                                        $css->Cdiv();
                                                        
                                                    }
                                                    
                                                    
                                                $css->Cdiv();   
                                            $css->Cdiv();
                                        $css->Cdiv();
                                    //$css->Cdiv();
                                    //$css->div("", "col-md-4", "", "", "", "", "");
                                        
                                    //$css->Cdiv();
                                $css->Cdiv();
                                $css->Cdiv();
                                
                            }

                        $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();

            $css->Cdiv();
            
        break;//Fin caso 9
        
        
        case 10:  //formulario para crear o editar una actividad de una tarea en un proyecto
                
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $empresa_id);
            $db=$datos_empresa["db"];
            
            $proyecto_id=$obCon->normalizar($_REQUEST["proyecto_id"]);
            $tarea_id=$obCon->normalizar($_REQUEST["tarea_id"]);
            $actividad_id=$obCon->normalizar($_REQUEST["actividad_id"]);
            $datos_tarea=$obCon->DevuelveValores("$db.proyectos_tareas", "tarea_id", $tarea_id);
            $datos_actividad=$obCon->DevuelveValores("$db.proyectos_actividades", "actividad_id", $actividad_id);
            if($actividad_id==''){
                $actividad_id=$obCon->getUniqId("");
            }
            $css->div("", "col-md-12", "", "", "", "", "");
                $css->CrearTitulo("Crear o Editar una actividad para la tarea <strong>$datos_tarea[titulo_tarea]<strong>","rojo");
            $css->Cdiv(); 
            
            $css->input("hidden", "proyecto_tarea_id", "", "proyecto_tarea_id", "", $proyecto_id, "", "", "", "");
            $css->input("hidden", "tarea_id", "", "tarea_id", "", $tarea_id, "", "", "", "");
            $css->input("hidden", "actividad_id", "", "actividad_id", "", $actividad_id, "", "", "", "");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 3, "", "", "", "");
            $css->CrearDiv("div_row", "row", "left", 1, 1);
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->CrearDiv("", "col-md-8", "center", 1, 1);
                        print("<strong>Título de la Actividad:</strong><br>");
                        $css->input("text", "titulo_actividad", "form-control", "titulo_actividad", "Título de la actividad", $datos_actividad["titulo_actividad"], "Título de la actividad", "off", "", "");
                    $css->Cdiv();

                    $css->CrearDiv("", "col-md-4", "center", 1, 1);
                        $color="#3041c2";
                        if($datos_actividad["color"]<>""){
                            $color=$datos_actividad["color"];
                        }
                        print("<strong>Color:</strong><br>");
                        $css->input("color", "color_actividad", "form-control", "color_actividad", "Color para esta actividad", $color, "Color para esta actividad", "off", "", "");
                    $css->Cdiv();    
                    print("<br><br><br>");
                    $css->CrearDiv("", "row", "center", 1, 1);
                        
                        $css->CrearDiv("", "col-md-12", "center", 1, 1);
                            $css->CrearTitulo("<strong>Subir adjuntos a esta actividad</strong>", "verde");
                            print('<div class="panel">

                                        <div class="panel-body">
                                            <form data-actividad_id="'.$actividad_id.'" data-proyecto_id="'.$proyecto_id.'" data-tarea_id="'.$tarea_id.'" action="/" class="dropzone dz-clickable" id="actividad_adjuntos"><div class="dz-default dz-message"><span><i class="icon-plus"></i>Arrastre archivos aquí o de click para subir.<br> Suba cualquier tipo de archivos.</span></div></form>
                                        </div>
                                    </div>
                                ');
                        $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
                
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->CrearDiv("div_adjuntos_actividades", "col-md-12", "center", 1, 1);
                    
                    $css->CerrarDiv();
                $css->Cdiv();
                
            $css->Cdiv();
            
            
        break;//Fin caso 10
        
        case 11: //Dibuja los adjuntos en una actividad
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $actividad_id=$obCon->normalizar($_REQUEST["actividad_id"]);
            
            $DatosEmpresa=$obCon->ValorActual("empresapro", "db", " idEmpresaPro='$empresa_id'");
            $db=$DatosEmpresa["db"];
            $datos_proyecto=$obCon->DevuelveValores("$db.proyectos_actividades", "actividad_id", $actividad_id);
            $css->CrearTitulo("Adjuntos de esta actividad");
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                
                    $css->ColTabla("ID", 1);
                    $css->ColTabla("Nombre de Archivo", 1);
                    
                    $css->ColTabla("Eliminar", 1);
                    
                $css->CierraFilaTabla();
                
                $sql="SELECT t1.*
                        FROM $db.proyectos_actividades_adjuntos t1 
                        WHERE t1.actividad_id='$actividad_id' 
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
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`4`,`$idItem`,`$actividad_id`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                          
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
            
        break; //Fin caso 11
        
        case 12://listar las actividades de una tarea
            $empresa_id=$obCon->normalizar($_REQUEST["empresa_id"]);
            $tarea_id=$obCon->normalizar($_REQUEST["tarea_id"]);
            
            $DatosEmpresa=$obCon->ValorActual("empresapro", "db", " idEmpresaPro='$empresa_id'");
            $db=$DatosEmpresa["db"];
            
            print("<h4>Actividades</h4>");
                                                    
            $sql="SELECT * FROM $db.proyectos_actividades WHERE tarea_id='$tarea_id'";
            $Consulta2=$obCon->Query($sql);

            while($datos_actividades=$obCon->FetchAssoc($Consulta2)){
                $css->div("", "row", "", "", "", "", "");

                    print('<div id="'.$datos_actividades["actividad_id"].'" data-actividad_id="'.$datos_actividades["actividad_id"].'" data-tarea_id="'.$tarea_id.'" data-proyecto_id="'.$datos_actividades["proyecto_id"].'" title="click izquierdo para editar, click derecho para eliminar" class=" fc-event  external-event ui-draggable ui-draggable-handle" style="position: relative;color:white;background-color:'.$datos_actividades["color"].'">'.$datos_actividades["titulo_actividad"].'</div>');

                $css->Cdiv();

            }
            
        break;//Fin caso 12    
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>