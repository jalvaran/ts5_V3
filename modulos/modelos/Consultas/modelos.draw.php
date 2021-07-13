<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../clases/modelos.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Modelos($idUser);
    
    switch ($_REQUEST["Accion"]) {
                
        case 1://Dibuja la base de datos de las modelos
            $Limit=20;
            $tabla="modelos_db";
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $busqueda=$obCon->normalizar($_REQUEST["busqueda"]);
            
            $Condicion=" WHERE ID>0 ";
            
            if($busqueda<>''){
                $Condicion.=" AND (Nombre LIKE '%$busqueda%' OR NombreArtistico LIKE '%$busqueda%' or Identificacion like '%$busqueda%')   ";
            }
                       
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items  
                   FROM $tabla t1 $Condicion;";
            
            
            $totales = $obCon->FetchAssoc($obCon->Query($sql));
            $ResultadosTotales = $totales['Items'];
            $TotalPaginas= ceil($ResultadosTotales/$Limit);
            $pagina_siguiente=$TotalPaginas;
            $pagina_anterior=1;
            if($ResultadosTotales>($PuntoInicio+$Limit)){
                $pagina_siguiente=$Page+1;
            }
            if($Page>1){
                $pagina_anterior=$Page-1;
            }
            $sql="SELECT * 
                  FROM $tabla $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            print('<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">BASE DE DATOS DE LAS MODELOS</h3>

                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      
                    </div>
                  </div>
                  <!-- /.box-tools -->
                </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                
                <div class="btn-group">
                    <a title="Nuevo Registro" onclick="frm_crear_editar_modelo()" class="btn btn-social-icon btn-github btn-lg"><i class="fa fa-plus"></i></a> 
                    <a title="Desactivar todos los registros" onclick="habilitar_deshabilitar(``,`I`,`'.$Page.'`)" class="btn btn-social-icon btn-dropbox btn-lg"><i class="fa fa-bolt"></i></a>

                </div>
                
                <div class="pull-right">
                
                  '.$Page.'-'.$TotalPaginas.'/'.$ResultadosTotales.'
                  <div class="btn-group">
                    <button type="button" onclick="ver_listado_segun_id(`'.$pagina_anterior.'`)" style="cursor:pointer" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" onclick="ver_listado_segun_id(`'.$pagina_siguiente.'`)" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                 
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table mailbox-messages">
                <table class="table table-responsive table-hover table-striped">
                  <tbody>');
            
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Activar/Inactivar</strong>", 1);
                $css->ColTabla("<strong>ID</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>NombreArtistico</strong>", 1);
                $css->ColTabla("<strong>Identificacion</strong>", 1);
                $css->ColTabla("<strong>Telefono</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_20</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_30</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_60</strong>", 1);
                $css->ColTabla("<strong>valor_show</strong>", 1);
                $css->ColTabla("<strong>valor_masaje</strong>", 1);
                $css->ColTabla("<strong>Estado</strong>", 1);
            $css->CierraFilaTabla();
                  
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                
                $ID=$datos_consulta["ID"];
                
                print('<tr >');
                $chk="";
                $activo='A';
                if($datos_consulta["Estado"]=='A'){
                    $chk="checked";
                    $activo='I';
                }       
                print('    
                    <td>
                        <input type="checkbox" '.$chk.' onchange="habilitar_deshabilitar(`'.$ID.'`,`'.$activo.'`,`'.$Page.'`)" class="ts_chk" data-toggle="toggle">
                    </td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-star"><a><strong>'.$ID.'</strong></a></td>
                   
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Nombre"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["NombreArtistico"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Identificacion"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Telefono"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_20"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_30"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_60"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["show"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["masaje"]).'</td>    
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-date">'.$datos_consulta["Estado"].'</td>
                  </tr>');
                
                //print('<tr><td colspan="6"> </td></tr>');
            }
            
            
            
            print('      </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
          </div>');
        break;//Fin caso 1
        
        case 2://Dibuja el formulario para crear un domicilio
            $item_id=$obCon->normalizar($_REQUEST["item_id"]);
            $datos_modelo=$obCon->DevuelveValores("modelos_db", "ID", $item_id);
            if($item_id==''){
                $Titulo="Crear Modelo";
            }else{
                $Titulo="Editar Modelo ".$datos_modelo["NombreArtistico"];
            }
            $css->CrearTitulo($Titulo, "verde");
            $css->input("hidden", "idFormulario", "form-control", "idFormulario", "1", "1", "idFormulario", "off", "", "");
            $css->input("hidden", "ID", "form-control ts_form", "ID", "", $item_id, "", "off", "", "");
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Nombre</strong>", 2,"C");
                    $css->ColTabla("<strong>Identificacion</strong>", 1,"C");
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    print("<td colspan=2>");
                        $css->input("text", "Nombre", "form-control ts_form", "Nombre", "", $datos_modelo["Nombre"], "Nombre", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "Identificacion", "form-control ts_form", "Identificacion", "",$datos_modelo["Identificacion"], "Identificacion", "off", "", "");
                    print("</td>");
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Nombre Artistico</strong>", 2,"C");
                    $css->ColTabla("<strong>Telefono</strong>", 1,"C");
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);    
                    print("<td colspan=2>");
                        $css->input("text", "NombreArtistico", "form-control ts_form", "NombreArtistico","" ,$datos_modelo["NombreArtistico"], "Nombre Artistico", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "Telefono", "form-control ts_form", "Telefono", "", $datos_modelo["Telefono"], "Telefono", "off", "", "");
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Valor X 20 Minutos</strong>", 1,"C");
                    $css->ColTabla("<strong>Valor X 30 Minutos</strong>", 1,"C");
                    $css->ColTabla("<strong>Valor X 60 Minutos</strong>", 1,"C");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    print("<td>");
                        $css->input("text", "valor_servicio_20", "form-control ts_form", "valor_servicio_20", "", $datos_modelo["valor_servicio_20"], "valor_servicio_20", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "valor_servicio_30", "form-control ts_form", "valor_servicio_30","" ,$datos_modelo["valor_servicio_30"], "valor_servicio_20", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "valor_servicio_60", "form-control ts_form", "valor_servicio_60","" ,$datos_modelo["valor_servicio_60"], "valor_servicio_60", "off", "", "");
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Valor X Show</strong>", 1,"C");
                    $css->ColTabla("<strong>Valor X Masaje</strong>", 1,"C");
                    $css->ColTabla("<strong>Activ@/Inactiv@</strong>", 1,"C");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    print("<td>");
                        $css->input("text", "show", "form-control ts_form", "show", "", $datos_modelo["show"], "show", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "masaje", "form-control ts_form", "masaje","" ,$datos_modelo["masaje"], "masaje", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->select("Estado", "form-control ts_form", "Estado", "", "", "", "");
                            $sel=0;
                            if($datos_modelo["Estado"]=="A"){
                                $sel=1;
                            }
                            $css->option("", "", "", "A", "", "",$sel);
                                print("Activ@");
                            $css->Coption();
                            $sel=0;
                            if($datos_modelo["Estado"]=="I"){
                                $sel=1;
                            }
                            $css->option("", "", "", "I", "", "",$sel);
                                print("InActiv@");
                            $css->Coption();
                        $css->Cselect();
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;//fin caso 7    
           
        case 3://Dibuja las modelos disponibles
            $Limit=20;
            $tabla="modelos_db";
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $busqueda=$obCon->normalizar($_REQUEST["busqueda"]);
            
            $Condicion=" WHERE Estado='A' ";
            
            if($busqueda<>''){
                $Condicion.=" AND (Nombre LIKE '%$busqueda%' OR NombreArtistico LIKE '%$busqueda%' or Identificacion like '%$busqueda%')   ";
            }
                      
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items  
                   FROM $tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $TotalPaginas= ceil($ResultadosTotales/$Limit);
            $pagina_siguiente=$TotalPaginas;
            $pagina_anterior=1;
            if($ResultadosTotales>($PuntoInicio+$Limit)){
                $pagina_siguiente=$Page+1;
            }
            if($Page>1){
                $pagina_anterior=$Page-1;
            }
            $sql="SELECT * 
                  FROM $tabla $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            print('<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">BASE DE DATOS DE LAS MODELOS</h3>

                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      
                    </div>
                  </div>
                  <!-- /.box-tools -->
                </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                
                <div class="btn-group">
                    <a title="Nuevo Registro" onclick="frm_crear_editar_modelo()" class="btn btn-social-icon btn-github btn-lg"><i class="fa fa-plus"></i></a>
                    <a title="Desactivar todos los registros" onclick="habilitar_deshabilitar(``,`I`,`'.$Page.'`)" class="btn btn-social-icon btn-dropbox btn-lg"><i class="fa fa-bolt"></i></a>

                </div>
                
                <div class="pull-right">
                
                  '.$Page.'-'.$TotalPaginas.'/'.$ResultadosTotales.'
                  <div class="btn-group">
                    <button type="button" onclick="ver_listado_segun_id(`'.$pagina_anterior.'`)" style="cursor:pointer" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" onclick="ver_listado_segun_id(`'.$pagina_siguiente.'`)" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                 
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table mailbox-messages">
                <table class="table table-responsive table-hover table-striped">
                  <tbody>');
            
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Activar/Inactivar</strong>", 1);
                $css->ColTabla("<strong>ID</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>NombreArtistico</strong>", 1);
                $css->ColTabla("<strong>Identificacion</strong>", 1);
                $css->ColTabla("<strong>Telefono</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_20</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_30</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_60</strong>", 1);
                $css->ColTabla("<strong>valor_show</strong>", 1);
                $css->ColTabla("<strong>valor_masaje</strong>", 1);
                $css->ColTabla("<strong>Estado</strong>", 1);
            $css->CierraFilaTabla();
                  
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                
                $ID=$datos_consulta["ID"];
                
                print('<tr >');
                $chk="";
                $activo='A';
                if($datos_consulta["Estado"]=='A'){
                    $chk="checked";
                    $activo='I';
                }       
                print('    
                    <td>
                        <input type="checkbox" '.$chk.' onchange="habilitar_deshabilitar(`'.$ID.'`,`'.$activo.'`,`'.$Page.'`)" class="ts_chk" data-toggle="toggle">
                    </td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-star"><a><strong>'.$ID.'</strong></a></td>
                   
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Nombre"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["NombreArtistico"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Identificacion"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Telefono"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_20"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_30"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_60"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["show"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["masaje"]).'</td>    
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-date">'.$datos_consulta["Estado"].'</td>
                  </tr>');
                
                //print('<tr><td colspan="6"> </td></tr>');
            }
            
            
            
            print('      </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
          </div>');
        break;//Fin caso 3
        
        case 4://Lista de servicios
            
            $tabla="modelos_agenda";
            
            $busqueda=$obCon->normalizar($_REQUEST["busqueda"]);
            
            $Condicion=" WHERE Estado='A' ";
            
            if($busqueda<>''){
                $Condicion.=" AND (Nombre LIKE '%$busqueda%' OR NombreArtistico LIKE '%$busqueda%' or Identificacion like '%$busqueda%')   ";
            }
                      
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items  
                   FROM $tabla t1 $Condicion;";
            
            $Consulta=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
            $TotalPaginas= ceil($ResultadosTotales/$Limit);
            $pagina_siguiente=$TotalPaginas;
            $pagina_anterior=1;
            if($ResultadosTotales>($PuntoInicio+$Limit)){
                $pagina_siguiente=$Page+1;
            }
            if($Page>1){
                $pagina_anterior=$Page-1;
            }
            $sql="SELECT * 
                  FROM $tabla $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            print('<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">BASE DE DATOS DE LAS MODELOS</h3>

                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      
                    </div>
                  </div>
                  <!-- /.box-tools -->
                </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                
                <div class="btn-group">
                    <a title="Nuevo Registro" onclick="frm_crear_editar_modelo()" class="btn btn-social-icon btn-github btn-lg"><i class="fa fa-plus"></i></a>
                    <a title="Desactivar todos los registros" onclick="habilitar_deshabilitar(``,`I`,`'.$Page.'`)" class="btn btn-social-icon btn-dropbox btn-lg"><i class="fa fa-bolt"></i></a>

                </div>
                
                <div class="pull-right">
                
                  '.$Page.'-'.$TotalPaginas.'/'.$ResultadosTotales.'
                  <div class="btn-group">
                    <button type="button" onclick="ver_listado_segun_id(`'.$pagina_anterior.'`)" style="cursor:pointer" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" onclick="ver_listado_segun_id(`'.$pagina_siguiente.'`)" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                 
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table mailbox-messages">
                <table class="table table-responsive table-hover table-striped">
                  <tbody>');
            
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Activar/Inactivar</strong>", 1);
                $css->ColTabla("<strong>ID</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>NombreArtistico</strong>", 1);
                $css->ColTabla("<strong>Identificacion</strong>", 1);
                $css->ColTabla("<strong>Telefono</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_20</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_30</strong>", 1);
                $css->ColTabla("<strong>valor_servicio_60</strong>", 1);
                $css->ColTabla("<strong>valor_show</strong>", 1);
                $css->ColTabla("<strong>valor_masaje</strong>", 1);
                $css->ColTabla("<strong>Estado</strong>", 1);
            $css->CierraFilaTabla();
                  
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                
                $ID=$datos_consulta["ID"];
                
                print('<tr >');
                $chk="";
                $activo='A';
                if($datos_consulta["Estado"]=='A'){
                    $chk="checked";
                    $activo='I';
                }       
                print('    
                    <td>
                        <input type="checkbox" '.$chk.' onchange="habilitar_deshabilitar(`'.$ID.'`,`'.$activo.'`,`'.$Page.'`)" class="ts_chk" data-toggle="toggle">
                    </td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-star"><a><strong>'.$ID.'</strong></a></td>
                   
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Nombre"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["NombreArtistico"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Identificacion"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-subject"><b>'.$datos_consulta["Telefono"].' </b></td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_20"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_30"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["valor_servicio_60"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["show"]).'</td>
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-attachment">'.number_format($datos_consulta["masaje"]).'</td>    
                    <td onclick="frm_crear_editar_modelo(`'.$ID.'`);" style="cursor:pointer" class="mailbox-date">'.$datos_consulta["Estado"].'</td>
                  </tr>');
                
                //print('<tr><td colspan="6"> </td></tr>');
            }
            
            
            
            print('      </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              
            </div>
          </div>');
        break;//Fin caso 4
        
           
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>