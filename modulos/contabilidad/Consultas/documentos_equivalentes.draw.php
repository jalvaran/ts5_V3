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
        case 1: //Crea un formulario para el registro de un nuevo documento
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", "");
            $css->CrearDiv("", "row", "center", 1, 1);
                $css->CrearDiv("", "col-md-2", "center", 1, 1);
                    $css->fieldset("", "", "Field", "Documento", "", "");
                        $css->legend("", "");
                            print("<a href='#'>Fecha</a>");
                        $css->Clegend();           
                        $css->input("date", "TxtFecha", "form-control", "TxtFecha", "", date("Y-m-d"), "Fecha", "off", "", "style='line-height: 15px;'");
                    $css->Cfieldset();
                $css->CerrarDiv();

                $css->CrearDiv("", "col-md-4", "center", 1, 1);
                    $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                        $css->legend("", "");
                            print("<a href='#'>Resolución: </a>");
                        $css->Clegend();           
                        $css->select("resolucion_documento_equivalente", "form-control", "resolucion_documento_equivalente", "", "", "style=width:100%", "");

                        $Consulta=$obCon->ConsultarTabla("documentos_equivalentes_resoluciones", " WHERE estado=1");
                        while($DatosDocumentos=$obCon->FetchAssoc($Consulta)){
                            $css->option("", "", "", $DatosDocumentos["ID"], "", "");
                                print($DatosDocumentos["nombre_interno"]." ".$DatosDocumentos["numero_resolucion"]);

                            $css->Coption();
                        }
                    $css->Cselect();
                    $css->Cfieldset();
                $css->CerrarDiv();

                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                        $css->legend("", "");
                            print("<a href='#'>Tercero: </a>");
                        $css->Clegend();           
                        $css->select("tercero_id", "form-control", "tercero_id", "", "", "style=width:100%", "");


                        $css->option("", "", "","" , "", "");
                            print("Seleccione un Tercero");

                        $css->Coption();

                    $css->Cselect();
                    $css->Cfieldset();
                $css->CerrarDiv();
            $css->CerrarDiv();
            print("<br><br>");    
            $css->CrearDiv("", "row", "center", 1, 1);
                $css->CrearDiv("", "col-md-4", "center", 1, 1);
                    $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                        $css->legend("", "");
                            print("<a href='#'>Empresa:</a>");
                        $css->Clegend();           
                        $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "style=width:100%");
                            $sql="SELECT * FROM empresapro ";
                            $consulta=$obCon->Query($sql);

                            while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                                $css->option("", "", "", $DatosCuenta["idEmpresaPro"], "", "");
                                    print($DatosCuenta["idEmpresaPro"]." ".$DatosCuenta["RazonSocial"]." ".$DatosCuenta["NIT"]);
                                $css->Coption();
                            }

                        $css->Cselect();
                    $css->Cfieldset();
                $css->CerrarDiv();

                $css->CrearDiv("", "col-md-4", "center", 1, 1);
                    $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                        $css->legend("", "");
                            print("<a href='#'>Sucursal:</a>");
                        $css->Clegend();           
                        $css->select("CmbSucursal", "form-control", "CmbSucursal", "", "", "", "style=width:100%");
                            $sql="SELECT * FROM empresa_pro_sucursales ";
                            $consulta=$obCon->Query($sql);

                            while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                                $css->option("", "", "", $DatosCuenta["ID"], "", "");
                                    print($DatosCuenta["Nombre"]);
                                $css->Coption();
                            }

                        $css->Cselect();
                    $css->Cfieldset();
                $css->CerrarDiv();

                $css->CrearDiv("", "col-md-4", "center", 1, 1);
                    $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                        $css->legend("", "");
                            print("<a href='#'>Costos:</a>");
                        $css->Clegend();           
                        $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "style=width:100%");
                            $sql="SELECT * FROM centrocosto ";
                            $consulta=$obCon->Query($sql);

                            while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                                $css->option("", "", "", $DatosCuenta["ID"], "", "");
                                    print($DatosCuenta["Nombre"]);
                                $css->Coption();
                            }

                        $css->Cselect();
                    $css->Cfieldset();
                $css->CerrarDiv();
            $css->CerrarDiv();    
            print("<br><br>");      
            $css->CrearDiv("", "row", "center", 1, 1);     
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    $css->fieldset("", "", "FieldPrestamos", "Prestamo", "", "");
                        $css->legend("", "");
                            print("<a href='#'>Observaciones</a>");
                        $css->Clegend();           
                            $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "Observaciones", "Observaciones", "", "");
                            $css->Ctextarea();
                        $css->Cfieldset();
                $css->CerrarDiv();
            $css->CerrarDiv();
            
            
            
        break; //Fin caso 1
        
        case 2://Dibuja un documento equivalente
            
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            if($idDocumento<=0 or $idDocumento==''){
                print(" ");
                exit();
            }
            $datos_documento=$obCon->DevuelveValores("vista_documentos_equivalentes", "ID", $idDocumento);
            $datos_tercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $datos_documento["tercero_id"]);
            $datos_resolucion=$obCon->DevuelveValores("documentos_equivalentes_resoluciones", "ID", $datos_documento["resolucion_id"]);
            $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", $datos_documento["empresa_id"]);
            $css->div("", "container", "", "", "", "", "");
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>".$datos_empresa["RazonSocial"]."<br>
                                           NIT: ".$datos_empresa["NIT"]."<br>
                                           ".$datos_empresa["Direccion"]."<br>
                                           TEL: ".$datos_empresa["Telefono"]."
                                               
                                        </strong> ", 6,"C");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>DOCUMENTO EQUIVALENTE A FACTURA DE COMPRA</strong><br> (Art. 3 Decreto 522 Marzo de 2003): ", 5,"R");
                        $css->ColTabla("<strong>No. ".$datos_documento["consecutivo"]."</strong>", 1,"R");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<br><strong>Resolución DIAN No.".$datos_resolucion["numero_resolucion"]." del ".$datos_resolucion["fecha"]."<br>
                                           Numeración Autorizada: Desde el ".$datos_resolucion["desde"]." Hasta el ".$datos_resolucion["hasta"]."<br>                                           
                                           Vigencia: ".$datos_resolucion["fecha_final"]."
                                               
                                        </strong> ", 6,"C");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Fecha:</strong>", 2,"L");
                        print("<td colspan=4>");
                        $css->input("date", "fecha_documento", "form-control", "fecha_documento", "", $datos_documento["fecha"], "Fecha", "off", "", 'onchange=editar_registro_documento_equivalente(`1`,`'.$idDocumento.'`,`fecha`,`fecha_documento`)', "style='line-height: 15px;'");
                        
                        print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Nombre / Razon Social:</strong> <li class='fa fa-edit' title='Click para Editar el Tercero' onclick='frm_editar_tercero_documento(`$idDocumento`)' style='color:red;cursor:pointer;font-size:20px;'></li>", 2,"L");
                        $css->ColTabla($datos_documento["tercero_razon_social"], 3,"L");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Cedula / NIT:</strong>", 2,"L");
                        $css->ColTabla($datos_documento["tercero_id"], 4,"L");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Domicilio:</strong>", 2,"L");
                        $css->ColTabla($datos_tercero["Direccion"]." ".$datos_tercero["Ciudad"] , 4,"L");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Teléfono:</strong>", 2,"L");
                        $css->ColTabla($datos_tercero["Telefono"], 4,"L");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla(" ", 6,"L");
                        
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Cantidad</strong>", 1,"L");
                        $css->ColTabla("<strong>Descripcion</strong>", 1,"L");
                        $css->ColTabla("<strong>Valor Unitario</strong>", 1,"L");
                        $css->ColTabla("<strong>Valor Total</strong>", 1,"L");
                        $css->ColTabla("<strong>Cuenta</strong>", 1,"L");
                        $css->ColTabla("<strong>Agregar</strong>", 1,"L");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print('<td style=width:10%>');
                            $css->input("text", "cantidad_item", "form-control ts_form", "cantidad_item", "Cantidad", 1, "Cantidad", "off", "", "onchange=calcule_total_item()");
                        print('</td>');
                        print('<td style=width:30%>');
                            $css->input("text", "descripcion_item", "form-control ts_form", "descripcion_item", "Descripcion", "", "Descripcion", "on", "", "");
                        print('</td>');
                        print('<td style=width:15%>');
                            $css->input("text", "valor_unitario_item", "form-control ts_form", "valor_unitario_item", "Valor Unitario", "", "Valor Unitario", "off", "", "onchange=calcule_total_item()");
                        print('</td>');
                        print('<td style=width:15%>');
                            $css->input("text", "valor_total_item", "form-control ts_form", "valor_total_item", "Valor Total", "", "Valor Total", "off", "", "disabled=true");
                        print('</td>');
                        print('<td>');
                            
                            $css->select("cuenta_item", "form-control ts_form", "cuenta_item", "", "", "", "");
                                $css->option("", "", "", "", "", "");
                                    print("Seleccione una cuenta");
                                $css->Coption();
                            $css->Cselect();
                           
                        print('</td>');
                        print('<td >');
                            $css->li("", "btn btn-success fa fa-plus-square", "", 'onclick="agregar_item()"'." style=font-size:16px;cursor:pointer;");
                            $css->Cli();
                        print('</td>');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                    print('<td">');
                        
                    print('</td>');
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
                print('<div id="div_items"></div>');
                print('<div id="div_totales_documento"></div>');
                        
            $css->Cdiv();
            
        break;//Fin caso 2
        
        case 3://formulario para actualizar el tercero
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);            
            $datos_documento=$obCon->DevuelveValores("documentos_equivalentes", "ID", $idDocumento);
            $datos_tercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $datos_documento["tercero_id"]);
            $css->CrearTitulo("<strong>Editar el tercero del documento $datos_documento[consecutivo]</strong>");
            
            $css->div("", "container", "", "", "", "", "");
                $css->div("", "row", "", "", "", "", "");
                    $css->div("", "col-md-1", "", "", "", "", "");
                    
                    $css->Cdiv();
                    $css->div("", "col-md-8", "", "", "", "", "");
                        $css->select("tercero_id_documento", "form-control", "tercero_id_documento", "", "", 'onchange=editar_registro_documento_equivalente(`1`,`'.$idDocumento.'`,`tercero_id`,`tercero_id_documento`)', 'style="width:100%"');
                            $css->option("", "", "", $datos_documento["tercero_id"], "", "");
                                print($datos_tercero["RazonSocial"]." || ".$datos_tercero["Direccion"]);
                            $css->Coption();
                        $css->Cselect();
                    $css->Cdiv();    
                $css->Cdiv();
            $css->Cdiv();
            
        break;//Fin caso 3    
        
        case 4://Dibuja los items del documento
            
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            if($idDocumento<=0 or $idDocumento==''){
                print(" ");
                exit();
            }
            $sql="SELECT * FROM documentos_equivalentes_items WHERE documento_equivalente_id='$idDocumento' AND deleted='0000-00-00 00:00:00'";
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>ITEMS AGREGADOS A ESTE DOCUMENTO</strong>", 6,"C");
                $css->CierraFilaTabla();
            $Consulta=$obCon->Query($sql);
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                $item_id=$datos_consulta["ID"];
                $css->FilaTabla(14);
                   print('<td style=width:10%>');
                            $css->input("text", "cantidad_item_".$item_id, "form-control ts_form", "cantidad_item", "Cantidad", $datos_consulta["cantidad"], "Cantidad", "off", "", "onchange='editar_registro_documento_equivalente(`2`,`$item_id`,`cantidad`,`cantidad_item_".$item_id."`);'");
                        print('</td>');
                        print('<td style=width:30%>');
                            $css->input("text", "descripcion_item_".$item_id, "form-control ts_form", "descripcion_item", "Descripcion", $datos_consulta["descripcion"], "Descripcion", "on", "", "onchange=editar_registro_documento_equivalente(`2`,`$item_id`,`descripcion`,`descripcion_item_".$item_id."`);");
                        print('</td>');
                        print('<td style=width:15%>');
                            $css->input("text", "valor_unitario_item_".$item_id, "form-control ts_form", "valor_unitario_item", "Valor Unitario", $datos_consulta["valor_unitario"], "Valor Unitario", "off", "", "onchange=editar_registro_documento_equivalente(`2`,`$item_id`,`valor_unitario`,`valor_unitario_item_".$item_id."`);");
                        print('</td>');
                        print('<td style=width:15%;text-align:right>');
                            print(number_format($datos_consulta["total_item"],2));
                        print('</td>');
                        print('<td>');
                            
                                $css->select("cuenta_item_".$item_id, "form-control ts_select2", "cuenta_item", "", "", "onchange=editar_registro_documento_equivalente(`2`,`$item_id`,`cuenta_puc`,`cuenta_item_".$item_id."`);", "style=width:250px;");
                                    $css->option("", "", "", $datos_consulta["cuenta_puc"], "", "");
                                        print($datos_consulta["cuenta_puc"]);
                                    $css->Coption();
                                $css->Cselect();
                            
                        print('</td>');
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick='editar_registro_documento_equivalente(`2`,`$item_id`,`deleted`,`".date("Y-m-d H:i:s")."`,`2`);' style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                $css->CierraFilaTabla();
                
                
                
            }
            $css->CerrarTabla();
            
        break;//Fin caso 4
    
        case 5://Dibuja totales del documento
            
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            if($idDocumento<=0 or $idDocumento==''){
                print(" ");
                exit();
            }
            $datos_documento=$obCon->DevuelveValores("documentos_equivalentes", "ID", $idDocumento);
            $sql="SELECT SUM(total_item) as total_items FROM documentos_equivalentes_items WHERE documento_equivalente_id='$idDocumento' AND deleted='0000-00-00 00:00:00'";
            $totales_documento=$obCon->FetchAssoc($obCon->Query($sql));
            
            $sql="SELECT SUM(valor_retenido) as total_retenido FROM documentos_equivalentes_retenciones WHERE documento_equivalente_id='$idDocumento' AND deleted='0000-00-00 00:00:00'";
            $totales_retencion=$obCon->FetchAssoc($obCon->Query($sql));
            
            
            $total=$totales_documento["total_items"]-$totales_retencion["total_retenido"];
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Observaciones</strong>", 6,'C');
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    print('<td colspan="6"><textarea id="concepto_documento_equivalente" onchange="onchange=editar_registro_documento_equivalente(`1`,`'.$idDocumento.'`,`concepto`,`concepto_documento_equivalente`);">'.$datos_documento["concepto"].'</textarea></td>');
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>SUBTOTAL</strong>", 4,"R");
                    $css->ColTabla(number_format($totales_documento["total_items"],2), 1,"R");
                    $css->ColTabla(" ", 1,"R");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    print('<td colspan="4" style="text-align:right;width:60%" >');
                        print('<span><strong>RETENCIONES</strong> <li class="btn btn-primary fa fa-plus-square" onclick="frm_retenciones()" style=font-size:16px;cursor:pointer;"></li> </span>');
                        
                    print('</td>');
                    $css->ColTabla(number_format($totales_retencion["total_retenido"],2), 1,"R");
                    $css->ColTabla(" ", 1,"R");
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>TOTAL</strong>", 4,"R");
                    $css->ColTabla(number_format($total,2), 1,"R");
                    print('<td>');
                            
                            $css->select("cuenta_total_documento", "form-control ts_select2", "cuenta_total_documento", "", "", "", "style=width:250px;");
                                $css->option("", "", "", "", "", "");
                                    print("Seleccione una opcion");
                                $css->Coption();
                            $css->Cselect();

                    print('</td>');
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                    $css->ColTabla(" ", 4,"R");
                    print("<td colspan=1>");                        
                        $css->CrearBotonEvento("BtnGuardar", "Guardar", 1, "onclick", "GuardarDocumento()", "rojo", "");
                    print("</td>");
                    $css->ColTabla(" ", 1,"R");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
        break;//Fin caso 5
        
        case 6://formulario para agregar retenciones
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            if($idDocumento<=0 or $idDocumento==''){
                print(" ");
                exit();
            }
            $datos_documento=$obCon->DevuelveValores("documentos_equivalentes", "ID", $idDocumento);
            $sql="SELECT SUM(total_item) as total_items FROM documentos_equivalentes_items WHERE documento_equivalente_id='$idDocumento' AND deleted='0000-00-00 00:00:00'";
            $totales_documento=$obCon->FetchAssoc($obCon->Query($sql));
            
            $css->CrearTitulo("<strong>AGREGAR RETENCIONES AL DOCUMENTO No. $idDocumento</strong>");
            $css->CrearTabla();
                $css->FilaTabla(16);
                        print('<td style=width:10%>');
                            $css->input("text", "porcentaje_retenido", "form-control ts_form", "porcentaje_retenido", "Porcentaje", '', "Porcentaje", "off", "", "onchange=calcule_retencion()");
                        print('</td>');
                        print('<td style=width:15%>');
                            $css->input("text", "base_retencion", "form-control ts_form", "base_retencion", "Base", $totales_documento["total_items"], "Base", "off", "", "disabled=true");
                        print('</td>');
                        print('<td style=width:15%>');
                            $css->input("text", "valor_retencion", "form-control ts_form", "valor_retencion", "Valor Retencion", "", "Valor Retencion", "off", "", "disabled=true");
                        print('</td>');
                        
                        print('<td>');
                            
                            $css->select("cuenta_retencion", "form-control ts_select2", "cuenta_retencion", "", "", "", "");
                                $css->option("", "", "", "", "", "");
                                    print("Seleccione una cuenta");
                                $css->Coption();
                            $css->Cselect();
                           
                        print('</td>');
                        print('<td>');
                            
                            $css->select("retencion_asumida", "form-control", "retencion_asumida", "", "", "", "");
                                $css->option("", "", "", "0", "", "");
                                    print("Asumida por el Tercero");
                                $css->Coption();
                                $css->option("", "", "", "1", "", "");
                                    print("Asumida por la Empresa");
                                $css->Coption();
                            $css->Cselect();
                           
                        print('</td>');
                        print('<td >');
                            $css->li("", "btn btn-success fa fa-plus-square", "", 'onclick="agregar_retencion()"'." style=font-size:16px;cursor:pointer;");
                            $css->Cli();
                        print('</td>');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                    print('<td">');
                        
                    print('</td>');
                    $css->CierraFilaTabla();
            $css->CerrarTabla();
            
            print('<div id="div_retenciones_documento"></div>');
            
        break;//Fin caso 6   
        
        case 7://retenciones de un documento
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            if($idDocumento<=0 or $idDocumento==''){
                print(" ");
                exit();
            }
            $sql="SELECT * FROM documentos_equivalentes_retenciones WHERE documento_equivalente_id='$idDocumento' AND deleted='0000-00-00 00:00:00'";
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>RETENCIONES REALIZADAS A ESTE DOCUMENTO</strong>", 6,"C");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>PORCENTAJE %</strong>", 1,"C");
                    $css->ColTabla("<strong>BASE</strong>", 1,"C");
                    $css->ColTabla("<strong>VALOR RETENIDO</strong>", 1,"C");
                    $css->ColTabla("<strong>ASUMIDA POR</strong>", 1,"C");
                    $css->ColTabla("<strong>ELIMINAR</strong>", 1,"C");
                $css->CierraFilaTabla();
                
            $Consulta=$obCon->Query($sql);
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                $item_id=$datos_consulta["ID"];
                $css->FilaTabla(14);
                    $css->ColTabla($datos_consulta["porcentaje"], 1);
                    $css->ColTabla(number_format($datos_consulta["base"],2), 1);
                    $css->ColTabla(number_format($datos_consulta["valor_retenido"],2), 1,"R");
                    $asumido_por="El Tercero";
                    if($datos_consulta["asumida"]==1){
                        $asumido_por="La Empresa";
                    }
                    $css->ColTabla($asumido_por, 1);
                    print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   

                        $css->li("", "fa  fa-remove", "", "onclick='editar_registro_documento_equivalente(`3`,`$item_id`,`deleted`,`".date("Y-m-d H:i:s")."`,`2`);' style=font-size:16px;cursor:pointer;text-align:center;color:red");
                        $css->Cli();
                    print("</td>");
                $css->CierraFilaTabla();
                
                
                
            }
            $css->CerrarTabla();
        break;//Fin caso 7
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>