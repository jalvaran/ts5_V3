<?php

session_start();
if (!isset($_SESSION['username'])){// valida que el usuario tenga alguna sesion iniciada 
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];// se crea una variable iduser para saber almacenar que usuario esta tabajando

include_once("../clases/ts_domi.class.php");// se debe incluir la clase del modulo 
include_once("../../../constructores/paginas_constructor.php");// siempre debera de ir ya que utilizara html que esta en el constructor

if(!empty($_REQUEST["Accion"]) ){// se verifica si el indice accion es diferente a vacio 
    
    $css =  new PageConstruct("", "", 1, "", 1, 0);// se instancia para poder utilizar el html
    $obCon = new Domi($idUser);// se instancia para poder conectarse con la base de datos 
    
    switch($_REQUEST["Accion"]) {
       
        case 1://dibuja el listado de los locales
                        
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
            
            $Condicion=" WHERE ID>0 ";
            
            if($Busquedas<>''){
                $Condicion.=" AND (Nombre like '%$Busquedas%' or Telefono like '%$Busquedas%')";
            }
            
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items 
                   FROM locales $Condicion;";
            
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000);//Allí se aloja la informacion del servidor de DOMI
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
                        
            $sql="SELECT *
                  FROM locales $Condicion ORDER BY Orden ASC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
            
            $css->CrearTitulo("Lista de Locales Registrados", "verde");
            
            
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                
                    print('<a class="btn btn-app" style="background-color:#12a900;color:white;" onclick=FormularioCrearEditarLocal()>
                        <span class="badge bg-blue" style="font-size:14px">'.$ResultadosTotales.'</span>
                        <i class="fa fa-user-plus"></i> Agregar 
                      </a>');
                   
                    $css->div("", "pull-right", "", "", "", "", "");
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
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                $NombreCompleto= utf8_encode($RegistrosTabla["Nombre"]." ".$RegistrosTabla["Direccion"]." ".$RegistrosTabla["Telefono"]);
                                print('<tr>');
                                    print("<td>");
                                        print('<button type="button" class="btn btn-warning btn-sm" onclick=FormularioCrearEditarLocal(`2`,`'.$idItem.'`)><i class="fa fa-edit"></i></button>');
                                    print("</td>");
                                    print("<td class='mailbox-name'>");
                                        print($RegistrosTabla["ID"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".utf8_encode($RegistrosTabla["Nombre"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print(utf8_encode($RegistrosTabla["Direccion"]));
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".utf8_encode($RegistrosTabla["Telefono"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print(utf8_encode($RegistrosTabla["Descripcion"]));
                                    print("</td>");
                                    print("<td class='mailbox-date'>");
                                        print(($RegistrosTabla["Orden"]));
                                    print("</td>");                                    
                                    print("<td class='mailbox-date'>");
                                        print(($RegistrosTabla["Estado"]));
                                    print("</td>");
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
        break;//fin caso 1
        
        case 2:// formulario para crear o editar un local
            $TipoFormulario=$obCon->normalizar($_REQUEST["TipoFormulario"]);
            $idEditar=$obCon->normalizar($_REQUEST["idEditar"]);
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000);//Servidor DOMI
            $sql="SELECT * FROM locales WHERE ID='$idEditar'";
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
            $DatosLocal=$obCon->FetchAssoc($Consulta);
            $css->CrearTitulo("Crear o Editar Local", "naranja");
            $css->CrearDiv("", "box box-default", "", 1, 1);
                $css->CrearDiv("", "box-body", "", 1, 1);
                    $css->CrearDiv("", "row", "", 1, 1);
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Categoria</label>');
                                $css->select("cmbCategoriaLocal", "form-control", "cmbCategoriaLocal", "", "", "", "");
                                    $sel=0;
                                    $css->option("", "", "", '', "", "",$sel);
                                        print("Seleccione una Categoria");
                                    $css->Coption();
                                    
                                    $sql="SELECT * FROM catalogo_categorias WHERE Estado='1'";
                                    $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
                                    while($DatosCatalogo=$obCon->FetchAssoc($Consulta)){
                                        $sel=0;
                                        if($DatosLocal["idCategoria"]==$DatosCatalogo["ID"]){
                                            $sel=1;
                                        }
                                        $css->option("", "", "", $DatosCatalogo["ID"], "", "",$sel);
                                            print($DatosCatalogo["Nombre"]);
                                        $css->Coption();
                                    }
                                    
                                $css->Cselect();
                            $css->CerrarDiv();                             
                        $css->CerrarDiv();
                        
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Nombre</label>');                                
                                $css->input("text", "NombreLocal", "form-control", "NombreLocal", "Numero Local", $DatosLocal["Nombre"], "Nombre del local", "off", "", "");
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv(); 
                        
                        
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Estado</label>');
                                $css->select("cmbEstadoLocal", "form-control", "cmbEstadoLocal", "", "", "", "");
                                    $sel=0;
                                    if($DatosLocal["Estado"]==1){
                                        $sel=1;
                                    }
                                    $css->option("", "", "", '1', "", $sel);
                                        print("Activo");
                                    $css->Coption();
                                    $sel=0;
                                    if($DatosLocal["Estado"]==0){
                                        $sel=1;
                                    }
                                    $css->option("", "", "", '0', "", $sel);
                                        print("Deshabilitado");
                                    $css->Coption();
                                                                        
                                $css->Cselect();
                            $css->CerrarDiv();                             
                        $css->CerrarDiv();
                                                
                    $css->CerrarDiv();
                    $css->CrearDiv("", "row", "", 1, 1);
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Direccion</label>');                                
                                $css->input("text", "Direccion", "form-control", "Direccion", "Direccion", $DatosLocal["Direccion"], "Direccion", "off", "", "");
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv(); 
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Telefono</label>');                                
                                $css->input("text", "Telefono", "form-control", "Telefono", "Telefono", $DatosLocal["Telefono"], "Telefono", "off", "", "");
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv(); 
                        
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Fondo</label>');
                                $css->input("file", "Fondo", "form-control", "Fondo", "Fondo", "", "Fondo", "off", "", "");
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv(); 
                        
                    $css->CerrarDiv();
                    $css->CrearDiv("", "row", "", 1, 1);
                        $css->CrearDiv("", "col-md-8", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Descripción</label>');
                                $css->textarea("Descripcion", "form-control", "Descripcion", "", "Descripcion", "", "");
                                    print($DatosLocal["Descripcion"]);
                                $css->Ctextarea();
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv();  
                         
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Guardar</label>');
                                $css->CrearBotonEvento("btnGuardarLocal", "Guardar", 1, "onclick", "ConfirmaGuardarEditarLocal(`$TipoFormulario`,`$idEditar`)", "rojo");
                            $css->CerrarDiv();                             
                        $css->CerrarDiv();  
                        
                        
                    $css->CerrarDiv(); 
                    //Fin Fila 2
                    
                $css->CerrarDiv();
                
            $css->CerrarDiv();
            
        break;// fin caso 2  
        
        case 3://Listar las clasificaciones
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
            $idLocal=$obCon->normalizar($_REQUEST["idLocal"]);
            $dbLocal=$obCon->normalizar($_REQUEST["dbLocal"]);
            if($idLocal==''){
                $css->CrearTitulo("No se envío el ID de un local","rojo");
                exit();
            }
            if($dbLocal==''){
                $css->CrearTitulo("No se envío la base de datos un local","rojo");
                exit();
            }
            
            $Condicion=" WHERE ID>0 ";
            if($Busquedas<>''){
                $Condicion.=" AND (Clasificacion like '%$Busquedas%')";
            }
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000);//Allí se aloja la informacion del servidor de DOMI
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items 
                   FROM inventarios_clasificacion $Condicion;";
            
            
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $dbLocal, "");
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
                        
            $sql="SELECT *
                  FROM inventarios_clasificacion $Condicion ORDER BY ID ASC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $dbLocal, "");
            
            $css->CrearTitulo("Clasificacion del Inventario o Servicios", "verde");   
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                
                    print('<a class="btn btn-app" style="background-color:blue;color:white;" onclick=FormularioCrearEditarClasificacion()>
                        <span class="badge bg-orange" style="font-size:14px">'.$ResultadosTotales.'</span>
                        <i class="fa fa-sitemap"></i> Agregar 
                      </a>');
                   
                    $css->div("", "pull-right", "", "", "", "", "");
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
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button type="button" class="btn btn-warning btn-sm" onclick=FormularioCrearEditarClasificacion(`2`,`'.$idItem.'`)><i class="fa fa-edit"></i></button>');
                                    print("</td>");
                                    print("<td class='mailbox-name'>");
                                        print($RegistrosTabla["ID"]);
                                    print("</td>");
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".utf8_encode($RegistrosTabla["Clasificacion"])."</strong>");
                                    print("</td>");
                                                                
                                    print("<td class='mailbox-date'>");
                                        print(($RegistrosTabla["Estado"]));
                                    print("</td>");
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
        break;// fin caso 3
        
        case 4:// formulario para crear o editar una clasificacion
            $TipoFormulario=$obCon->normalizar($_REQUEST["TipoFormulario"]);
            $idEditar=$obCon->normalizar($_REQUEST["idEditar"]);
            $dbLocal=$obCon->normalizar($_REQUEST["dbLocal"]);
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000);//Servidor DOMI
            $sql="SELECT * FROM inventarios_clasificacion WHERE ID='$idEditar'";
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $dbLocal, "");
            $DatosLocal=$obCon->FetchAssoc($Consulta);
            $css->CrearTitulo("Crear o Editar una Clasificacion", "naranja");
            $css->CrearDiv("", "box box-default", "", 1, 1);
                $css->CrearDiv("", "box-body", "", 1, 1);
                    $css->CrearDiv("", "row", "", 1, 1);
                                               
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Clasificacion</label>');                                
                                $css->input("text", "Clasificacion", "form-control", "Clasificacion", "Clasificacion", $DatosLocal["Clasificacion"], "Clasificacion", "off", "", "");
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv(); 
                        
                        
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Estado</label>');
                                $css->select("Estado", "form-control", "Estado", "", "", "", "");
                                    $sel=0;
                                    if($DatosLocal["Estado"]==1){
                                        $sel=1;
                                    }
                                    $css->option("", "", "", '1', "", $sel);
                                        print("Activo");
                                    $css->Coption();
                                    $sel=0;
                                    if($DatosLocal["Estado"]==0){
                                        $sel=1;
                                    }
                                    $css->option("", "", "", '0', "", $sel);
                                        print("Deshabilitado");
                                    $css->Coption();
                                                                        
                                $css->Cselect();
                            $css->CerrarDiv();                             
                        $css->CerrarDiv();
                        
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Guardar</label>');
                                $css->CrearBotonEvento("btnGuardarClasificacion", "Guardar", 1, "onclick", "ConfirmaGuardarEditarClasificacion(`$TipoFormulario`,`$idEditar`)", "rojo");
                            $css->CerrarDiv();                             
                        $css->CerrarDiv();  
                                                
                    $css->CerrarDiv();
                    
                    //Fin Fila 1
                    
                $css->CerrarDiv();
                
            $css->CerrarDiv();
            
        break;// fin caso 4
        
        case 5://Listar productos
            
            $Limit=20;
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            $Busquedas=$obCon->normalizar($_REQUEST["Busquedas"]);
            $idLocal=$obCon->normalizar($_REQUEST["idLocal"]);
            $dbLocal=$obCon->normalizar($_REQUEST["dbLocal"]);
            if($idLocal==''){
                $css->CrearTitulo("No se envío el ID de un local","rojo");
                exit();
            }
            if($dbLocal==''){
                $css->CrearTitulo("No se envío la base de datos un local","rojo");
                exit();
            }
            
            $Condicion=" WHERE ID>0 ";
            if($Busquedas<>''){
                $Condicion.=" AND (Nombre like '%$Busquedas%' or Referencia like '$Busquedas%')";
            }
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000);//Allí se aloja la informacion del servidor de DOMI
                        
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(ID) as Items 
                   FROM productos_servicios $Condicion;";
            
            
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $dbLocal, "");
            $totales = $obCon->FetchAssoc($Consulta);
            $ResultadosTotales = $totales['Items'];
                        
            $sql="SELECT t1.*,
                (SELECT t2.Clasificacion FROM inventarios_clasificacion t2 WHERE t2.ID=t1.idClasificacion LIMIT 1) AS NombreClasificacion 
                  FROM productos_servicios t1 $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $dbLocal, "");
            
            $css->CrearTitulo("Lista de Productos o Servicios", "azul");   
            
            $css->div("", "box-body no-padding", "", "", "", "", "");
                $css->div("", "mailbox-controls", "", "", "", "", "");
                
                    print('<a class="btn btn-app primary" style="background-color:aqua" onclick=FormularioCrearEditarProducto()>
                        <span class="badge bg-orange" style="font-size:14px">'.$ResultadosTotales.'</span>
                        <i class="fa fa-th-list"></i> Agregar 
                      </a>');
                   
                    $css->div("", "pull-right", "", "", "", "", "");
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
                   
                $css->CrearDiv("", "table-responsive mailbox-messages", "", 1, 1);
                    print('<table class="table table-hover table-striped">');
                        print('<tbody>');
                            while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                                
                                $idItem=$RegistrosTabla["ID"];
                                
                                print('<tr>');
                                    print("<td>");
                                        print('<button type="button" class="btn btn-warning btn-sm" onclick=FormularioCrearEditarProducto(`2`,`'.$idItem.'`)><i class="fa fa-edit"></i></button>');
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".utf8_encode($RegistrosTabla["Nombre"])."</strong>");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".number_format($RegistrosTabla["PrecioVenta"])."</strong>");
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".utf8_encode($RegistrosTabla["DescripcionCorta"])."</strong>");
                                    print("</td>");
                                    print("<td class='mailbox-name'>");
                                        print($RegistrosTabla["Orden"]);
                                    print("</td>");
                                    
                                    print("<td class='mailbox-name'>");
                                        print($RegistrosTabla["ID"]);
                                    print("</td>");
                                    
                                    print("<td class='mailbox-subject'>");
                                        print("<strong>".utf8_encode($RegistrosTabla["DescripcionLarga"])."</strong>");
                                    print("</td>");
                                                                
                                    print("<td class='mailbox-date'>");
                                        print(($RegistrosTabla["Estado"]));
                                    print("</td>");
                                                                        
                                print('</tr>');

                            }

                        print('</tbody>');
                    print('</table>');
                $css->Cdiv();
            $css->Cdiv();
            
        break;//Fin caso 5 
        
        case 7:// formulario para crear o editar un producto
            $TipoFormulario=$obCon->normalizar($_REQUEST["TipoFormulario"]);
            $idEditar=$obCon->normalizar($_REQUEST["idEditar"]);
            $dbLocal=$obCon->normalizar($_REQUEST["dbLocal"]);
            
            $DatosServidor=$obCon->DevuelveValores("servidores", "ID", 1000);//Servidor DOMI
            
            $sql="SELECT * FROM productos_servicios WHERE ID='$idEditar'";
            $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $dbLocal, "");
            
            $DatosLocal=$obCon->FetchAssoc($Consulta);
            
            $css->CrearTitulo("Crear o Editar un Producto", "azul");
            
            $css->CrearDiv("", "box box-default", "", 1, 1);
                $css->CrearDiv("", "box-body", "", 1, 1);
                    $css->CrearDiv("", "row", "", 1, 1);
                                               
                        $css->CrearDiv("", "col-md-2", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Clasificacion</label>');
                                $sql="SELECT * FROM inventarios_clasificacion";
                                $Consulta=$obCon->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $dbLocal, "");
                                
                                $css->select("idClasificacion", "form-control", "idClasificacion", "", "", "", "");
                                    $css->option("", "", "", "", "", "");
                                        print("Seleccione la clasificacion");
                                    $css->Coption();
                                    
                                    while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                                        $sel=0;
                                        if($DatosConsulta["ID"]==$DatosLocal["idClasificacion"]){
                                            $sel=1;
                                        }
                                        $css->option("", "", "", $DatosConsulta["ID"], "", "",$sel);
                                            print(utf8_encode($DatosConsulta["Clasificacion"]));
                                        $css->Coption();
                                    }
                                $css->Cselect();
                                
                            $css->CerrarDiv(); 
                           
                        $css->CerrarDiv(); 
                        
                        $css->CrearDiv("", "col-md-3", "", 1, 1);
                            
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Referencia</label>');  
                                $Referencia=$obCon->getUniqId();
                                if($DatosLocal["Referencia"]<>""){
                                    $Referencia=$DatosLocal["Referencia"];
                                }
                                $css->input("text", "Referencia", "form-control", "Referencia", "", $Referencia, "Referencia", "off", "", "");
                                
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv();
                        
                        $css->CrearDiv("", "col-md-3", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Nombre</label>');
                                
                                $css->input("text", "Nombre", "form-control", "Nombre", "", $DatosLocal["Nombre"], "Nombre", "off", "", "");
                                
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv();
                        
                        $css->CrearDiv("", "col-md-2", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Precio de Venta</label>');                                
                                $css->input("number", "PrecioVenta", "form-control", "PrecioVenta", "", $DatosLocal["PrecioVenta"], "PrecioVenta", "off", "", "");
                                
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv();
                        
                        $css->CrearDiv("", "col-md-2", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Orden</label>');                                
                                $css->input("number", "Orden", "form-control", "Orden", "", $DatosLocal["Orden"]+1, "Orden", "off", "", "");
                                
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv();
                        
                    $css->CerrarDiv();    
                    $css->CrearDiv("", "row", "", 1, 1);    
                        
                        $css->CrearDiv("", "col-md-3", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Descripcion Corta</label>');                                
                                $css->textarea("DescripcionCorta", "form-control", "DescripcionCorta", "", "Descripcion Corta", "", "");
                                    print($DatosLocal["DescripcionCorta"]);
                                $css->Ctextarea();
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv();
                        
                        $css->CrearDiv("", "col-md-3", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Descripcion Larga</label>');                                
                                $css->textarea("DescripcionLarga", "form-control", "DescripcionLarga", "", "Descripcion Larga", "", "");
                                    print($DatosLocal["DescripcionLarga"]);
                                $css->Ctextarea();
                            $css->CerrarDiv(); 
                            
                        $css->CerrarDiv();
                    
                        $css->CrearDiv("", "col-md-4", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Imagen</label>');
                                $css->input("file", "ImagenProducto", "form-control", "ImagenProducto", "", "", "Seleccione una imagen", "", "", "");
                            $css->CerrarDiv();                             
                        $css->CerrarDiv();
                        
                        $css->CrearDiv("", "col-md-2", "", 1, 1);
                            $css->CrearDiv("", "form-group", "", 1, 1);
                                print('<label>Guardar</label>');
                                $css->select("Estado", "form-control", "Estado", "", "", "", "");
                                    $sel=0;
                                    if($DatosLocal["Estado"]==1){
                                        $sel=1;
                                    }
                                    $css->option("", "", "", '1', "", $sel);
                                        print("Activo");
                                    $css->Coption();
                                    $sel=0;
                                    if($DatosLocal["Estado"]==0){
                                        $sel=1;
                                    }
                                    $css->option("", "", "", '0', "", $sel);
                                        print("Deshabilitado");
                                    $css->Coption();
                                                                        
                                $css->Cselect();
                                print("<br>");
                                $css->CrearBotonEvento("btnGuardarProducto", "Guardar", 1, "onclick", "ConfirmaGuardarEditarProducto(`$TipoFormulario`,`$idEditar`)", "rojo");
                            $css->CerrarDiv();                             
                        $css->CerrarDiv();  
                                                
                    $css->CerrarDiv();
                    
                    //Fin Fila 1
                    
                $css->CerrarDiv();
                
            $css->CerrarDiv();
            
            
        break;// fin caso 7
        
 }
    
          
}else{
    print("No se enviaron parametros");
}
?>