<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Facturacion.class.php");
include_once("../clases/AcuerdoPago.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Facturacion($idUser);
    $obAcuerdo = new AcuerdoPago($idUser);
    switch ($_REQUEST["Accion"]) {
                
        case 1://Dibuja los items de una preventa
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            
            $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 12); //Consultamos si está permitido crear desde el pos
            if($idPreventa>=1 and $DatosConfiguracion["Valor"]==1){
                $Titulo="Crear";
                $Nombre="ImgShowMenu";
                $RutaImage="../../images/pop_servicios.png";
                $javascript="onclick=FormularioCreacionProductos('ModalAccionesPOS','DivFrmPOS','BntModalPOS')";
                $VectorBim["f"]=0;
                $target="#DialTabla";
                $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,$javascript,50,50,"fixed","right:10px;top:50px;z-index:100;",$VectorBim);
            }
            if($idPreventa>=1){
                $css->div("DivAcuerdoFlotanteTotales","", "", "", "", "", "style=position:fixed;right:10px;top:150px;z-index:100;");
                   
                $css->Cdiv();
            }
            $css->CrearTabla();
                $css->FilaTabla(16);
                    
                    $css->ColTabla("<strong>Nombre</strong>", 1, "C");
                    $css->ColTabla("<strong>Referencia</strong>", 1, "C");
                    $css->ColTabla("<strong>Cantidad</strong>", 1, "C");                    
                    $css->ColTabla("<strong>Valor_Unitario</strong>", 1, "C");                    
                    $css->ColTabla("<strong>Total</strong>", 1, "C");                    
                    $css->ColTabla("<strong>Eliminar</strong>", 1, "C");
                    
                $css->CierraFilaTabla();
                //Dibujo los productos
                $sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY idPrecotizacion DESC";
                $Consulta=$obCon->Query($sql);
                while ($DatosItems = $obCon->FetchAssoc($Consulta)) {
                    $idItem=$DatosItems["idPrecotizacion"];
                    
                    $css->FilaTabla(16);                        
                        
                        $css->ColTabla($DatosItems["Nombre"], 1, "C");                   
                        
                        $css->ColTabla($DatosItems["Referencia"], 1, "C");
                        print("<td>");
                            print('<div class="input-group input-group-md" style=width:100px>');
                            
                                $css->input("number", "TxtCantidad_$idItem", "form-control", "TxtCantidad_$idItem", "Cantidad", $DatosItems["Cantidad"], "", "off", "", "");
                                print('<span class="input-group-btn">');
                                    print('<button type="button" id="BtnEditarCantidad_'.$idItem.'" class="btn btn-info btn-flat" onclick=EditarItemCantidad('.$idItem.')>E</button>');
                                    
                                print('</span>');
                            print('</div>');
                            
                            
                        print("</td>");
                        
                                              
                        print("<td>");
                            
                            print('<div class="input-group input-group-md">
                                <input type="text" id="TxtValorUnitario_'.$idItem.'" value="'.$DatosItems["ValorAcordado"].'" class="form-control" placeholder="Valor Unitario">
                                <div class="input-group-btn">
                                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >Precio
                                    <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">');
                            
                            print('<li><a href="#" onclick="EditarPrecioVenta(`'.$idItem.'`,`0`)" title="Valor Libre">Valor Libre</a></li>');
                            print('<li><a href="#" onclick="EditarPrecioVenta(`'.$idItem.'`,`1`)" title="Precio Mayorista">Mayorista</a></li>');            

                            print('</ul></div></div>');
                                

                         print("</td>");
                        
                        
                        $css->ColTabla(number_format($DatosItems["TotalVenta"],2,",","."), 1, "C");
                        
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                        
                    $css->CierraFilaTabla();
                }
                
                
            $css->CerrarTabla();
        break;// fin caso 1
        
        case 2://Dibujo los Totales
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            
            $sql="SELECT COUNT(*) AS CantidadRegistros,SUM(Cantidad) as TotalItems,SUM(Subtotal) AS Subtotal, SUM(Impuestos) as IVA, round(SUM(TotalVenta)) as Total FROM preventa WHERE VestasActivas_idVestasActivas = '$idPreventa'";
            $Consulta=$obCon->Query($sql);
            $Totales=$obCon->FetchAssoc($Consulta);
            
            $Subtotal=$Totales["Subtotal"];
            $IVA=$Totales["IVA"];
            $Total=$Totales["Total"];
            $CantidadRegistros=$Totales["CantidadRegistros"];
            $sql="SELECT Devuelve FROM facturas WHERE Usuarios_idUsuarios='$idUser' ORDER BY idFacturas DESC LIMIT 1";
            $consulta=$obCon->Query($sql);
            $DatosDevuelta=$obCon->FetchArray($consulta);
    
            //$css->input("hidden", "TxtTotalDocumento", "", "TxtTotalDocumento", "", $Total, "", "", "", "");
           
                
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTALES</strong>", 2,'C');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Última Devuelta:</strong>", 1,'L'); 
                        $css->ColTabla(number_format($DatosDevuelta["Devuelve"]), 1,'R'); 
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Items:</strong>", 1,'L'); 
                        $css->ColTabla(($Totales["TotalItems"]), 1,'R');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Subtotal:</strong>", 1,'L'); 
                        $css->ColTabla(number_format($Subtotal), 1,'R');  
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Impuestos:</strong>", 1,'L');
                        $css->ColTabla(number_format($IVA), 1,'R');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(30);
                        $css->ColTabla("<strong>Total:</strong>", 1,'L');
                        $css->ColTabla("<strong>".number_format($Total)."</strong>", 1,'R');
                    $css->CierraFilaTabla();
                    
                    
                                        
                    $css->FilaTabla(16);
                        print("<td colspan=3 style='text-align:center'>");
                            $habilitaBotones=0;
                             if($CantidadRegistros>0){ //Verifico que hayan productos, servicios o insumos agregados
                                 $habilitaBotones=1;
                             }
                             $css->CrearBotonEvento("BtnFacturar", "Facturar", $habilitaBotones, "onclick", "MostrarOpcionesFacturacionPOS()", "naranja", "");
                            
                            print("<br><br>");
                            $css->CrearBotonEvento("BtnCotizar", "Cotizar", $habilitaBotones, "onclick", "CotizarPOS()", "verde", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                $css->CerrarTabla(); 
            
                   
            
            
        break; // fin caso 4
        
        case 5: 
            $Listado=$obCon->normalizar($_REQUEST["listado"]);
            $idBusqueda=$obCon->normalizar($_REQUEST["CmbBusquedas"]);
            
            if($Listado==1){
                $tab="productosventa";
            }
            if($Listado==2){
                $tab="servicios";
            }
            if($Listado==3){
                $tab="productosalquiler";
            }
            $Datos=$obCon->ValorActual($tab, "PrecioVenta", " idProductosVenta='$idBusqueda'");
            print($Datos["PrecioVenta"]);
        break;//Fin caso 5
        
        case 6: //Dibujo el formulario para facturar 
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            $NIT=$DatosCliente["Num_Identificacion"];
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 20);//Aqui se encuentra la cuenta para los anticipos
            $CuentaAnticipos=$Parametros["CuentaPUC"];
            $sql="SELECT SUM(Debito) as Debito, SUM(Credito) AS Credito FROM librodiario WHERE CuentaPUC='$CuentaAnticipos' AND Tercero_Identificacion='$NIT'";
            $Consulta=$obCon->Query($sql);
            $DatosAnticipos=$obCon->FetchAssoc($Consulta);
            $SaldoAnticiposTercero=$DatosAnticipos["Credito"]-$DatosAnticipos["Debito"];
            
            $sql="SELECT round(SUM(TotalVenta)) as Total FROM preventa WHERE VestasActivas_idVestasActivas = '$idPreventa'";
            $Consulta=$obCon->Query($sql);
            $Totales=$obCon->FetchAssoc($Consulta);
            
            $TotalFactura=$Totales["Total"];
            $css->input("hidden", "TxtTotalFactura", "", "TxtTotalFactura", "", $TotalFactura, "", "", "", ""); 
            $css->input("hidden", "TxtTotalAnticiposFactura", "", "TxtTotalAnticiposFactura", "", $SaldoAnticiposTercero, "", "", "", "");  
            
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", ""); //1 sirve para indicarle al sistema que debe guardar el formulario de crear una factura
            
            $css->CrearTabla();
                $css->FilaTabla(22);
                    $css->ColTabla("Facturar Esta preventa al Cliente: $DatosCliente[RazonSocial] $DatosCliente[Num_Identificacion], por un total de:<strong> ". number_format($TotalFactura)."</strong>", 5);
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(14);
                    
                    $css->ColTabla("<strong>Efectivo</strong>", 1);
                    $css->ColTabla("<strong>Tarjetas</strong>", 1);
                    $css->ColTabla("<strong>Cheques</strong>", 1);
                    $css->ColTabla("<strong>Bonos</strong>", 1);
                    $css->ColTabla("<strong>Devolver</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                    
                    print("<td >");
                        
                        $css->input("number", "Efectivo", "form-control input-lg", "Efectivo", "Efectivo", $TotalFactura, "Efectivo", "off", "", "onKeyUp=CalculeDevuelta()");
                    print("</td>");
                    print("<td >");
                        
                        $css->input("number", "Tarjetas", "form-control input-lg", "Tarjetas", "Tarjetas", 0, "Tarjetas", "off", "", "onKeyUp=CalculeDevuelta()");
                    print("</td>");
                    print("<td>");
                        
                        $css->input("number", "Cheque", "form-control input-lg", "Cheque", "Cheque", 0, "Cheque", "off", "", "onKeyUp=CalculeDevuelta()");
                    print("</td>");
                    print("<td >");
                        
                        $css->input("number", "Otros", "form-control input-lg", "Otros", "Otros", 0, "Otros", "off", "", "onKeyUp=CalculeDevuelta()");
                    print("</td>");
                   
                    print("<td >");                        
                        $css->input("number", "Devuelta", "form-control input-lg", "Devuelta", "Devuelta", 0, "Efectivo", "off", "", " disabled");
                    print("</td>");
                    
                
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Forma de Pago</strong>", 1);
                    $css->ColTabla("<strong>Asignar</strong>", 1);
                    $css->ColTabla("<strong>Imprimir</strong>", 1);
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                    $css->ColTabla("<strong>Anticipos del Cliente: $".number_format($SaldoAnticiposTercero)."</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                print("<td>");
                        $css->select("CmbFormaPago", "form-control", "CmbFormaPago", "", "", "onchange=DibujeOpcionesAdicionales()", "");

                            $sql="SELECT * FROM repuestas_forma_pago";
                            $Consulta=$obCon->Query($sql);
                            if($idCliente==1){
                                $css->option("", "",'' , "Contado", "", "", "", "");
                                    print("Contado");
                                $css->Coption();
                            }
                            while($DatosFormaPago=$obCon->FetchAssoc($Consulta)){
                                if($idCliente<>1){
                                    $css->option("", "",'' , $DatosFormaPago["DiasCartera"], "", "", "", "");
                                        print($DatosFormaPago["Etiqueta"]);
                                    $css->Coption();
                                }
                            }


                        $css->Cselect();
                        
                        $css->CrearDiv("DivCuotaInicialCredito", "", "left", 0, 1);
                            print("<br>");
                            $css->input("text", "TxtCuotaInicialCredito", "form-control", "TxtCuotaInicialCredito", "", "", "Cuota Inicial", "off", "", "");
                        $css->CerrarDiv();
                    print("</td>");
                    
                print("<td>");
                        $css->select("CmbColaboradores", "form-control", "CmbColaboradores", "", "", "", "");

                            $sql="SELECT * FROM colaboradores WHERE Activo='SI'";
                            $Consulta=$obCon->Query($sql);
                                $css->option("", "",'' , '', "", "", "", "");
                                    print("Seleccione un colaborador");
                                $css->Coption();
                            while($DatosColaboradores=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "",'' , $DatosColaboradores["Identificacion"], "", "", "", "");
                                    print($DatosColaboradores["Nombre"]." ".$DatosColaboradores["Identificacion"]);
                                $css->Coption();
                            }


                        $css->Cselect();
                    print("</td>");
                    
                    print("<td>");
                        $DatosImpresion=$obCon->DevuelveValores("configuracion_general", "ID", 2);  //aqui está almaceda la info para saber si debe imprimir o no el tikete por defecto
                        $Imprime=$DatosImpresion["Valor"];
                        $css->select("CmbPrint", "form-control", "CmbPrint", "", "", "", "");
                            $Defecto=0;
                            if($Imprime==1){
                                $Defecto=1;
                            }
                            
                            $css->option("", "",'' , 'SI', "", "", $Defecto, "");
                                print("SI");
                            $css->Coption();
                            $Defecto=0;
                            if($Imprime==0){
                                $Defecto=1;
                            }
                            $css->option("", "",'' , 'NO', "", "", $Defecto, "");
                                print("NO");
                            $css->Coption();
                            
                            
                        $css->Cselect();
                    print("</td>");
                    
                    print("<td>");
                        $css->textarea("TxtObservacionesFactura", "form-control", "TxtObservacionesFactura", "Observaciones", "Observaciones", "", "");
                        $css->Ctextarea();
                    print("</td>"); 
                    
                    print("<td>");
                        
                        $css->input("number", "AnticiposCruzados", "form-control input-lg", "AnticiposCruzados", "Cruzar Anticipos", 0, "", "", "", "");
                    print("</td>");
                    
                    
                    $css->CierraFilaTabla();
                   
            $css->CerrarTabla();
            $css->CrearDiv("DivAcuerdoPago", "col-md-12", "left", 1, 1);
                            
            $css->CerrarDiv(); 
            $css->CrearDiv("", "col-md-10", "left", 1, 1);
            $css->CerrarDiv(); 
            $css->CrearDiv("DivAcuerdoPago", "col-md-2", "left", 1, 1);
                $css->CrearBotonEvento("BtnFacturarPOS", "Guardar", 1, "onclick", "GuardarFactura()", "rojo");
            $css->CerrarDiv(); 
        break;//Fin caso 6
        
        case 7://Dibuja las opciones al momento de autorizar
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<strong>Descuento General</strong><br>");
                
                $css->input("text", "TxtPorcentajeDescuento", "form-control", "TxtPorcentajeDescuento", "Porcentaje descuento", "", "Porcentaje", "off", "", "");
                $css->CrearBotonEvento("BtnDescuentoPorcentaje", "Aplicar", 1, "onclick", "DescuentoPorcentaje()", "naranja", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<strong>Listas de Precios</strong><br>");
                $css->select("CmbListaPrecio", "form-control", "CmbListaPrecio", "", "", "", "");
                    $Consulta=$obCon->ConsultarTabla("productos_lista_precios", "");
                    while($DatosListas=$obCon->FetchAssoc($Consulta)){
                        $css->option("", "", "", $DatosListas["ID"], "", "");
                            print($DatosListas["Nombre"]);
                        $css->Coption();
                    }
                $css->Cselect();
                $css->CrearBotonEvento("BtnListaPrecio", "Aplicar", 1, "onclick", "DescuentoListaPrecio()", "azul", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<strong>Descuento Costo</strong><br>");                
                $css->CrearBotonEvento("BtnDescuentoCosto", "Aplicar", 1, "onclick", "DescuentoCosto()", "rojo", "");
            $css->CerrarDiv();
            print("<br><br><br><br><br>");
        break;//Fin caso 7
        
        case 8: //Dibuja las opciones para crear un tercero
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 2, "", "", "", ""); //2 sirve para indicarle al sistema que debe guardar el formulario de crear un tercero
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Tipo de Documento</strong>", 1);
                    $css->ColTabla("<strong>Identificación</strong>", 1);
                    $css->ColTabla("<strong>Ciudad</strong>", 1);
                    $css->ColTabla("<strong>Teléfono</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td>");
                        $css->select("TipoDocumento", "form-control", "TipoDocumento", "", "", "", "style=width:300px");
                        $Consulta=$obCon->ConsultarTabla("cod_documentos", "");
                        while($DatosTipoDocumento=$obCon->FetchAssoc($Consulta)){
                            $sel=0;
                            if($DatosTipoDocumento["Codigo"]==13){
                                $sel=1;
                            }
                            $css->option("", "", "", $DatosTipoDocumento["Codigo"], "", "", $sel);
                                print($DatosTipoDocumento["Codigo"]." ".$DatosTipoDocumento["Descripcion"]);
                            $css->Coption();
                        }    
                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->input("number", "Num_Identificacion", "form-control", "Num_Identificacion", "", "", "Identificación", "off", "", "onchange=VerificaNIT()");
                    print("</td>");
                    print("<td>");
                        $css->select("CodigoMunicipio", "form-control", "CodigoMunicipio", "", "", "", "");
                            $Consulta=$obCon->ConsultarTabla("cod_municipios_dptos", "");
                            while($DatosMunicipios=$obCon->FetchAssoc($Consulta)){
                                $sel=0;
                                if($DatosMunicipios["ID"]==1011){
                                    $sel=1;
                                }
                                $css->option("", "", "", $DatosMunicipios["ID"], "", "", $sel);
                                    print($DatosMunicipios["Ciudad"]." ".$DatosMunicipios["Cod_mcipio"]);
                                $css->Coption();
                            }    
                        $css->Cselect();
                    print("</td>");
                    
                    print("<td>");
                        $css->input("text", "Telefono", "form-control", "Telefono", "", "", "Teléfono", "off", "", "");
                    print("</td>");
                    
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Nombres</strong>", 4,"C");
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td>");
                        $css->input("text", "PrimerNombre", "form-control", "PrimerNombre", "Primer Nombre", "", "Primer Nombre", "off", "", "onkeyup=CompletaRazonSocial()", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "OtrosNombres", "form-control", "OtrosNombres", "Otros Nombres", "", "Otros Nombres", "off", "", "onkeyup=CompletaRazonSocial()", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "PrimerApellido", "form-control", "PrimerApellido", "Primer Apellido", "", "Primer Apellido", "off", "", "onkeyup=CompletaRazonSocial()", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "SegundoApellido", "form-control", "SegundoApellido", "Segundo Apellido", "", "Segundo Apellido", "off", "", "onkeyup=CompletaRazonSocial()", "");
                    print("</td>");
                    $css->FilaTabla(16);
                        print("<td colspan=4>");
                            $css->input("text", "RazonSocial", "form-control", "RazonSocial", "Razon Social", "", "RazonSocial", "off", "", "", "");
                        print("</td>");
                    $css->CierraFilaTabla(); 
                    
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Dirección</strong>", 1);
                    $css->ColTabla("<strong>Email</strong>", 1);
                    $css->ColTabla("<strong>Cupo</strong>", 1);
                    $css->ColTabla("<strong>Código Tarjeta</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td>");
                        $css->input("text", "Direccion", "form-control", "Direccion", "Direccion", "", "Dirección", "off", "", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("text", "Email", "form-control", "Email", "Email", "", "Email", "off", "", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("number", "Cupo", "form-control", "Cupo", "Cupo", 0, "Cupo Crédito", "off", "", "", "");
                    print("</td>");
                    print("<td>");
                        $css->input("number", "CodigoTarjeta", "form-control", "CodigoTarjeta", "Codigo Tarjeta", "", "Código Tarjeta", "off", "", "", "onchange=VerificaCodigoTarjeta()");
                    print("</td>");
                $css->CierraFilaTabla();
                
            $css->CerrarTabla();
        break;//Fin caso 8
        
        case 9://Crear un separado
            
            $css->CrearDiv("", "col-md-8", "center", 1, 1);
                print("<strong>Abono</strong><br>");
                
                $css->input("number", "TxtAbonoCrearSeparado", "form-control", "TxtAbonoCrearSeparado", "Abono a Separado", "", "Abono a Separado", "off", "", "");
                
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<strong>Crear Separado</strong><br>");
                $css->CrearBotonEvento("BtnCrearSeparado", "Ejecutar", 1, "onclick", "CrearSeparado()", "rojo", "");
            $css->CerrarDiv();
            
            
            print("<br><br><br><br><br>");
            
        break;//Fin caso 9
    
        case 10://Formulario para crear un egreso
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 3, "", "", "", ""); //3 sirve para indicarle al sistema que debe guardar el formulario de crear un egreso
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Tipo de Egreso</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 1);
                    
                    $css->ColTabla("<strong>Número de Soporte</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td>");
                        $css->select("TipoEgreso", "form-control", "TipoEgreso", "", "", "", "style=width:300px");
                        $Consulta=$obCon->ConsultarTabla("subcuentas", " WHERE (PUC LIKE '5135%' or PUC LIKE '5105%' or PUC LIKE '5195%') AND LENGTH(PUC)>4 ");
                        while($DatosCuenta=$obCon->FetchAssoc($Consulta)){
                                                       
                            $css->option("", "", "", $DatosCuenta["PUC"], "", "", 0);
                                print($DatosCuenta["PUC"]." ".$DatosCuenta["Nombre"]);
                            $css->Coption();
                        }    
                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->select("CmbTerceroEgreso", "form-control", "CmbTerceroEgreso", "", "", "", "style=width:300px");
                            $css->option("", "", "", "", "", "");
                                print("Seleccione un tercero");
                            $css->Coption();
                        $css->Cselect();
                    print("</td>");
                    
                    
                    print("<td>");
                        $css->input("text", "TxtNumeroSoporteEgreso", "form-control", "TxtNumeroSoporteEgreso", "", "", "Número de Soporte", "off", "", "");
                    print("</td>");
                    
                    
                $css->CierraFilaTabla();
                                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Concepto</strong>", 2);
                    $css->ColTabla("<strong>Valor</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td colspan=2>");
                        $css->textarea("TxtConcepto", "form-control", "TxtConcepto", "Concepto", "Concepto", "", "");
                        $css->Ctextarea();
                    print("</td>");
                    
                    print("<td>");
                        $css->input("number", "SubtotalEgreso", "form-control", "SubtotalEgreso", "SubtotalEgreso", "", "Subtotal", "off", "", "", "onkeyup=CalculeTotalEgreso()");                    
                        $css->input("number", "IVAEgreso", "form-control", "IVAEgreso", "IVAEgreso", 0, "IVA", "off", "", "", "onkeyup=CalculeTotalEgreso()");
                        $css->input("number", "TotalEgreso", "form-control", "TotalEgreso", "TotalEgreso", "", "Total", "off", "", "", "","disabled");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
            $css->CerrarTabla();
        break;//fin caso 10
        
        case 11://Crea el formulario para abonar a un separado
            $key=$obCon->normalizar($_REQUEST["TxtBuscarSeparado"]);
            if(strlen($key)<4){
                print("Digite una palabra de más de 3 carácteres");
                exit();
            }
            $sql="SELECT sp.Fecha,sp.ID, cl.RazonSocial, cl.Num_Identificacion, sp.Total, sp.Saldo, sp.idCliente FROM separados sp"
                    . " INNER JOIN clientes cl ON sp.idCliente = cl.idClientes "
                    . " WHERE (sp.Estado<>'Cerrado' AND sp.Estado<>'ANULADO' AND sp.Saldo>0) AND (cl.RazonSocial LIKE '%$key%' OR cl.Num_Identificacion LIKE '%$key%') LIMIT 20";
            $Datos=$obCon->Query($sql);
            if($obCon->NumRows($Datos)){
                $css->CrearTabla();

                while($DatosSeparado=$obCon->FetchArray($Datos)){
                    $css->FilaTabla(14);
                    $css->ColTabla("<strong>Separado No. $DatosSeparado[ID]</strong>, del <strong>$DatosSeparado[Fecha]</strong>", 6);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td>");
                    //$css->CrearForm2("FormAbonosSeparados$DatosSeparado[ID]", $myPage, "post", "_self");
                    $idSeparado=$DatosSeparado["ID"];
                    
                    $css->input("number", "TxtAbonoSeparado_$idSeparado", "form-control", "TxtAbono", "Abonar", $DatosSeparado["Saldo"], "Abonar", "off", "", "");
                    
                    $css->CrearBotonEvento("BtnAbono_$idSeparado", "Abonar", 1, "onclick", "AbonarSeparado($idSeparado)", "rojo", "");
                    
                    print("</td>");
                    $css->ColTabla($DatosSeparado["ID"], 1);
                    $css->ColTabla($DatosSeparado["RazonSocial"], 1);
                    $css->ColTabla($DatosSeparado["Num_Identificacion"], 1);
                    $css->ColTabla("<strong>Total: </strong>".number_format($DatosSeparado["Total"]), 1);
                    $css->ColTabla("<strong>Abonos: </strong>".number_format($DatosSeparado["Total"]-$DatosSeparado["Saldo"]), 1);
                    $css->ColTabla("<strong>Saldo: </strong>".number_format($DatosSeparado["Saldo"]), 1);
                    $css->CierraFilaTabla();

                    $css->FilaTabla(16);
                    $css->ColTabla("ID Separado", 1);
                    $css->ColTabla("Referencia", 1);
                    $css->ColTabla("Nombre", 2);
                    $css->ColTabla("Cantidad", 1);
                    $css->ColTabla("TotalItem", 1);
                    $css->ColTabla("Opciones", 1);
                    $css->CierraFilaTabla();
                    $TotalAbonos=$DatosSeparado["Total"]-$DatosSeparado["Saldo"];
                    $ConsultaItems=$obCon->ConsultarTabla("separados_items", "WHERE idSeparado='$DatosSeparado[ID]'");
                    while($DatosItemsSeparados=$obCon->FetchArray($ConsultaItems)){
                        $CantidadMaxima=$DatosItemsSeparados["Cantidad"];
                        $ValorUnitarioItem=$DatosItemsSeparados["ValorUnitarioItem"];
                        $idItemSeparado=$DatosItemsSeparados["ID"];
                        $css->FilaTabla(14);
                        $css->ColTabla($DatosItemsSeparados["idSeparado"], 1);
                        $css->ColTabla($DatosItemsSeparados["Referencia"], 1);

                        $css->ColTabla($DatosItemsSeparados["Nombre"], 2);
                        print("<td>");
                        $css->input("number", "TxtCantidadItemSeparado_$idItemSeparado", "form-control", "Cantidad", "Cantidad", $DatosItemsSeparados["Cantidad"], "Cantidad", "off", "", "");
                        
                        print("</td>");

                        $css->ColTabla(number_format($DatosItemsSeparados["TotalItem"]), 1);
                        print("<td>");

                            $css->CrearBotonEvento("BtnFactItemSeparado_$idItemSeparado", "Facturar Item", 1, "onClick", "FacturarItemSeparado('$idItemSeparado','$TotalAbonos','$CantidadMaxima','$ValorUnitarioItem')", "naranja", "");
                        print("</td>");
                        $css->CierraFilaTabla();
                    }           



                }
                $css->CerrarTabla();
            }else{
                print("No hay resultados");
            }
        break;//Fin Caso 11
        
        case 12://Dibujo el formulario para abonar a un credito
            
            $key=$obCon->normalizar($_REQUEST["TxtBuscarCredito"]);
            if(strlen($key)<=3){

                print("Escriba mas de 3 caracteres");
                exit();  
            }
            $sql="SELECT cart.idCartera,cart.TipoCartera,cart.Facturas_idFacturas, cl.RazonSocial, cl.Num_Identificacion, cart.TotalFactura, cart.Saldo,cart.TotalAbonos, cl.idClientes FROM cartera cart"
                    . " INNER JOIN clientes cl ON cart.idCliente = cl.idClientes "
                    . " WHERE (cl.RazonSocial LIKE '%$key%' OR cl.Num_Identificacion LIKE '%$key%') AND cart.Saldo>1 LIMIT 40";
            $Datos=$obCon->Query($sql);
            if($obCon->NumRows($Datos)){
                $css->CrearTabla();

                while($DatosCredito=$obCon->FetchArray($Datos)){
                    $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $DatosCredito["Facturas_idFacturas"]);
                    $idCartera=$DatosCredito["idCartera"];
                    $idFactura=$DatosFactura["idFacturas"];
                            
                    $css->FilaTabla(14);
                    if($DatosFactura["FormaPago"]=='SisteCredito'){

                        print("<td colspan=6 style='background-color:#ff391a; color:white'>");
                    }else{
                        print("<td colspan=6 style='background-color:#daeecf;'>");
                    }

                    print("<strong>Factura No. ".$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"]." TIPO DE CREDITO: $DatosFactura[FormaPago] Fecha: $DatosFactura[Fecha]<strong>");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("</td>");
                    
                    $css->ColTabla("<strong>".$DatosCredito["RazonSocial"]."</strong>", 1);
                    $css->ColTabla("<strong>".$DatosCredito["Num_Identificacion"]."</strong>", 1);
                    $css->ColTabla("<strong>Total: </strong>".($DatosCredito["TotalFactura"]), 1);
                    $css->ColTabla("<strong>Abonos: </strong>".($DatosCredito["TotalFactura"]-$DatosCredito["Saldo"]), 1);
                    $css->ColTabla("<strong>Saldo: </strong>".($DatosFactura["SaldoFact"]), 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(14);
                    
                    print("<td>");
                        print("<strong>Efectivo:</strong>"); 
                        $css->input("number", "TxtAbonoCredito_$idCartera", "form-control", "TxtAbonoCredito_$idCartera", "Abono", $DatosFactura["SaldoFact"], "Efectivo: ", "off", "", "", "");
                    print("</td>");
                    
                    print("<td>");
                        print("<strong>Intereses:</strong>"); 
                        $css->input("number", "TxtInteresCredito_$idCartera", "form-control", "TxtInteresCredito_$idCartera", "Intereses", 0, "Intereses: ", "off", "", "", "");
                    print("</td>");
                    
                    print("<td>");
                        print("<strong>Tarjetas:</strong>"); 
                        $css->input("number", "TxtTarjetasCredito_$idCartera", "form-control", "TxtTarjetasCredito_$idCartera", "Tarjetas", 0, "Tarjetas: ", "off", "", "", "");
                    print("</td>");
                    
                    print("<td>");
                        print("<strong>Cheques:</strong>"); 
                        $css->input("number", "TxtChequesCredito_$idCartera", "form-control", "TxtChequesCredito_$idCartera", "Cheques", 0, "Cheques: ", "off", "", "", "");
                    print("</td>");
                    
                    print("<td>");
                        print("<strong>Otros:</strong>"); 
                        $css->input("number", "TxtOtrosCredito_$idCartera", "form-control", "TxtOtrosCredito_$idCartera", "Otros", 0, "Otros: ", "off", "", "", "");
                    print("</td>");
                    $css->FilaTabla(16);
                        print("<td colspan=3>");
                            $css->CrearBotonEvento("BtnItemFactura_$idCartera", "Ver Items de la Factura", 1, "onclick", "MostrarItemsFacturaCredito(`$idFactura`,`DivCredito_Items_$idCartera`)", "naranja", "");
                        print("</td>");
                        print("<td colspan=2>");
                            $css->CrearBotonEvento("BtnAbonoCredito_$idCartera", "Abonar a Credito", 1, "onclick", "AbonarCredito(`$idCartera`,`$idFactura`)", "rojo", "");
                        print("</td>");
                        
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                    print("<td colspan='5' style='text-align:center'>");
                        $css->CrearDiv("DivCredito_Items_$idCartera", "", "center", 1, 1);
                        $css->CerrarDiv();
                    print("</td>");   
                    $css->CierraFilaTabla();

                }
                $css->CerrarTabla();

            }else{
                print("No se encontraron datos");
            }
            
        break;//Fin caso 12
        
        case 13://Dibujo los items de una factura
            
            $idFactura=$obCon->normalizar($_REQUEST["idFactura"]);
            
            $css->CrearTabla();
            $css->FilaTabla(12);
                $css->ColTabla("<strong>REFERENCIA</strong>", 1);
                $css->ColTabla("<strong>NOMBRE</strong>", 1);
                $css->ColTabla("<strong>VALOR UNITARIO</strong>", 1);
                $css->ColTabla("<strong>CANTIDAD</strong>", 1);
                $css->ColTabla("<strong>SUBTOTAL</strong>", 1);
                $css->ColTabla("<strong>IVA</strong>", 1);
                $css->ColTabla("<strong>TOTAL</strong>", 1);
            $css->CierraFilaTabla();
            
            $sql="SELECT Referencia,Nombre,ValorUnitarioItem,Cantidad,SubtotalItem,IVAItem,TotalItem FROM facturas_items "
                    . " WHERE idFactura='$idFactura' LIMIT 100";
            $Consulta=$obCon->Query($sql);
            while ($DatosFactura=$obCon->FetchArray($Consulta)){
                $css->FilaTabla(12);
                    $css->ColTabla($DatosFactura["Referencia"], 1);
                    $css->ColTabla($DatosFactura["Nombre"], 1);
                    $css->ColTabla($DatosFactura["ValorUnitarioItem"], 1);
                    $css->ColTabla($DatosFactura["Cantidad"], 1);
                    $css->ColTabla($DatosFactura["SubtotalItem"], 1);
                    $css->ColTabla($DatosFactura["IVAItem"], 1);
                    $css->ColTabla($DatosFactura["TotalItem"], 1);
                $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        break;    //fin caso 13
        
        case 14://Formulario para recibir el ingreso de una plataforma de pagos
        
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 4, "", "", "", ""); //4 sirve para indicarle al sistema que debe guardar el formulario de crear un ingreso de una plataforma
            
            $css->CrearTabla();
                $css->FilaTabla(22);
                    $css->ColTabla("<strong>INGRESOS POR PLATAFORMAS</strong>", 5);
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(14);
                    
                    $css->ColTabla("<strong>Plataforma</strong>", 1);
                    $css->ColTabla("<strong>Tercero</strong>", 3);
                    $css->ColTabla("<strong>Valor</strong>", 1);
                                        
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                print("<td>");
                        $css->select("CmbPlataforma", "form-control", "CmbPlataforma", "", "", "", "");

                            $sql="SELECT * FROM comercial_plataformas_pago WHERE Activa=1";
                            $Consulta=$obCon->Query($sql);
                            
                            while($DatosFormaPago=$obCon->FetchAssoc($Consulta)){
                                
                                $css->option("", "",'' , $DatosFormaPago["ID"], "", "", "", "");
                                    print($DatosFormaPago["Nombre"]);
                                $css->Coption();
                                
                            }


                        $css->Cselect();
                    print("</td>");
                    
                print("<td colspan=3>");
                        $css->select("CmbTerceroIngresoPlataformas", "form-control", "CmbTerceroIngresoPlataformas", "", "", "", "style=width:400px");

                            
                            $css->option("", "",'' , '', "", "", "", "");
                                print("Seleccione un Tercero");
                            $css->Coption();
                        $css->Cselect();
                    print("</td>");
                    
                    
                    print("<td>");
                        
                        $css->input("number", "TxtIngresoPlataforma", "form-control input-md", "TxtIngresoPlataforma", "", 0, "", "", "", "style=width:300px");
                    print("</td>");
                    
                    
                    $css->CierraFilaTabla();
                    
            $css->CerrarTabla();
            
        break;//Fin caso 14
        
        case 15://Dibuja el formulario principal del acuerdo de pago
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            
            
            
            $DatosPreventa=$obCon->DevuelveValores("vestasactivas", "idVestasActivas", $idPreventa);
            $idAcuerdo=$DatosPreventa["IdentificadorUnico"];
            
            if($idAcuerdo==''){
                $idUnicoPreventa=$obCon->getId("ap_");
                $obCon->ActualizaRegistro("vestasactivas", "IdentificadorUnico", $idUnicoPreventa, "idVestasActivas", $idPreventa);
                $idAcuerdo=$idUnicoPreventa;
                
            }
            
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            $NIT= $DatosCliente["Num_Identificacion"];
            
            $sql="SELECT SUM(Debito - Credito) as Total FROM librodiario t2 WHERE t2.Tercero_Identificacion='$NIT' 
            AND EXISTS(SELECT 1 FROM contabilidad_parametros_cuentasxcobrar t3 WHERE t2.CuentaPUC like t3.CuentaPUC) ";
            
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $SaldoActualCliente=$Totales["Total"];
            $Cupo=$DatosCliente["Cupo"];
            
            $sql="SELECT SUM(TotalVenta) AS Total FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalPreventa=$Totales["Total"];
            
            $NuevoSaldo=$SaldoActualCliente+$TotalPreventa;
            $css->CrearTitulo("Crear Acuerdo de Pago para el Cliente <strong>$DatosCliente[RazonSocial] - $DatosCliente[Num_Identificacion]</strong>");
            
            $css->CrearDiv("", "col-md-6", "left", 1, 1);
            $css->input("text", "idAcuerdoPago", "form-control", "idAcuerdoPago", "idAcuerdoPago", $idAcuerdo, "id Acuerdo", "off", "", " disabled");
            $css->input("hidden", "SaldoActualAcuerdoPago", "form-control", "SaldoActualAcuerdoPago", "SaldoActualAcuerdoPago", $SaldoActualCliente, "", "off", "", " disabled");
            $css->input("hidden", "NuevoSaldoAcuerdoPago", "form-control", "NuevoSaldoAcuerdoPago", "NuevoSaldoAcuerdoPago", $NuevoSaldo, "", "off", "", " disabled");
                
                $css->CrearTabla();
                    $css->FilaTabla(16);                    
                        $css->ColTabla("<strong>Saldo Actual</strong>", 1);
                        $css->ColTabla("<strong>Cupo</strong>", 1); 
                        $css->ColTabla("<strong>Nuevo Saldo</strong>", 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);                    
                        $css->ColTabla(number_format($SaldoActualCliente), 1);
                        $css->ColTabla(number_format($Cupo), 1); 
                        $css->ColTabla("<h2>".number_format($NuevoSaldo)."</h2>", 1);
                    $css->CierraFilaTabla();
                    
            if($NuevoSaldo>$Cupo){
                $css->CrearTitulo("El Cliente no tiene cupo suficiente para realizar esta compra a credito", "rojo");
                $css->CerrarTabla();
                exit();
            }
            
            $ValorAnteriorCuota="";
            
            $sql="SELECT * FROM acuerdo_pago WHERE Tercero='$NIT' AND Estado=1";
            $DatosAcuerdoAnterior=$obCon->FetchAssoc($obCon->Query($sql));
            $disabledBtnAnteriorAcuerdo="disabled";
            if($DatosAcuerdoAnterior["ID"]>0){
                $disabledBtnAnteriorAcuerdo="";
            }
            $ValorAnteriorCuota=$DatosAcuerdoAnterior["ValorCuotaGeneral"];
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Acuerdo Anterior</strong>", "1", "C");
                $css->ColTabla("<strong>Datos Cliente || Adicional</strong>", "1", "C");
                
                $css->ColTabla("<strong>Recomendados</strong>", "1", "C");
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(16);
                print("<td style='text-align:center'>");        
                    print('<span class="input-group-btn"> 
                        <button type="button" class="btn btn-success btn-flat" '.$disabledBtnAnteriorAcuerdo.' onclick=DibujarAcuerdoPagoExistente(`'.$DatosAcuerdoAnterior["idAcuerdoPago"].'`,`DivProyeccionPagosAcuerdo`)> <i class="fa fa-eye"> </i> </button>
                      </span>');

                print("</td>");
                print("<td style='text-align:center' >");        
                    print('<span class="input-group-btn"> 
                        <button type="button" class="btn btn-info btn-flat" onclick=ModalEditarTercero(`ModalAccionesPOS`,`DivFrmPOS`,`'.$idCliente.'`,`clientes`)> <i class="fa fa-user"> </i> </button>
                      </span>');
                    print('<span class="input-group-btn"> 
                        <button type="button" class="btn btn-primary btn-flat" onclick=DibujarFormularioDatosAdicionalesCliente(`'.$idCliente.'`,`DivProyeccionPagosAcuerdo`)> <i class="fa fa-user-plus"> </i> </button>
                      </span>');

                print("</td>");
                
                print("<td style='text-align:center' >");        
                    print('<span class="input-group-btn"> 
                        <button type="button" class="btn btn-warning btn-flat" onclick=DibujarFormularioRecomendadosCliente(`'.$idCliente.'`,`DivProyeccionPagosAcuerdo`)> <i class="fa fa-users"> </i> </button>
                      </span>');

                print("</td>");
                $css->CierraFilaTabla();
                
            
                    $css->FilaTabla(16);   
                        $css->ColTabla("<strong>Cuota Inicial</strong>", 1);
                        $css->ColTabla("<strong>Metodo</strong>", 1); 
                        $css->ColTabla("<strong>Agregar</strong>", 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td>");
                           //$css->input("number", "CuotaInicialAcuerdo", "form-control", "CuotaInicialAcuerdo", "Cuota Inicial", "", "Cuota Inicial", "off", "", "onchange=CalculeCuotas()");
                            $css->input_number_format( "","CuotaInicialAcuerdo", "form-control", "CuotaInicialAcuerdo", "Cuota Inicial", "", "Cuota Inicial", "off", "", "onchange=CalculeCuotas()");
                        print("</td>");
                        print("<td>");
                            $css->select("metodoPagoCuotaInicial", "form-control", "metodoPagoCuotaInicial", "", "", "onchange=CalculeCuotasAcuerdo()", "");
                                
                                $sql="SELECT * FROM metodos_pago WHERE Estado=1";
                                $Consulta=$obCon->Query($sql);
                                while($DatosCiclo=$obCon->FetchAssoc($Consulta)){
                                    $css->option("", "", "", $DatosCiclo["ID"], "", "");
                                    print($DatosCiclo["Metodo"]);
                                $css->Coption();
                                }
                            $css->Cselect();
                        print("</td>");  
                        print("<td>");
                            $css->CrearBotonEvento("btnAgregarCuotaInicialAcuerdo", "+", 1, "onclick", "AgregarCuotaInicialAcuerdoPago('$idAcuerdo'); ", "verde");
                        print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>Cuota Programada</strong>", 1);                        
                        $css->ColTabla("<strong>Fecha cuota programada</strong>", 1);  
                        $css->ColTabla("<strong></strong>", 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td>");
                            //$css->input("number", "CuotaProgramadaAcuerdo", "form-control", "CuotaProgramadaAcuerdo", "Cuota Programada", "", "Cuota Programada", "off", "", "onchange=CalculeCuotas()");
                            $css->input_number_format("number", "CuotaProgramadaAcuerdo", "form-control", "CuotaProgramadaAcuerdo", "Cuota Programada", "", "Cuota Programada", "off", "", "onchange=CalculeCuotas()");
                        print("</td>");
                        print("<td>");
                            $css->input("date", "TxtFechaCuotaProgramada", "form-control", "TxtFechaCuotaProgramada", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;' min='".date("Y-m-d")."'");
                        print("</td>"); 
                        print("<td>");
                            $css->CrearBotonEvento("btnAgregarCuotaProgramada", "+", 1, "onclick", "AgregarCuotaProgramadaAcuerdoPagoTemporal('$idAcuerdo')", "verde");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>Ciclo</strong>", 1);
                        $css->ColTabla("<strong>Cuotas</strong>", 1);
                        $css->ColTabla("", 1);
                    $css->CierraFilaTabla();

                    $css->FilaTabla(16);
                        
                        
                        print("<td>");
                            $css->select("cicloPagos", "form-control", "cicloPagos", "", "", "onchange=CalculeCuotasAcuerdo()", "");
                                $css->option("", "", "", "", "", "");
                                    print("Seleccione el ciclo de pagos");
                                $css->Coption();
                                $sql="SELECT * FROM acuerdo_pago_ciclos_pagos";
                                $Consulta=$obCon->Query($sql);
                                while($DatosCiclo=$obCon->FetchAssoc($Consulta)){
                                    $css->option("", "", "", $DatosCiclo["ID"], "", "");
                                    print($DatosCiclo["NombreCiclo"]);
                                $css->Coption();
                                }
                            $css->Cselect();
                        print("</td>");
                        print("<td>");
                            $css->input("number", "NumeroCuotas", "form-control", "NumeroCuotas", "NumeroCuotas", "", "Numero de Cuotas", "off", "", "onchange=CalculeValorCuotaAcuerdo('$idAcuerdo')");
                        print("</td>");
                        print("<td>");
                           // $css->CrearBotonEvento("btnAgregar", "+", 1, "onclick", "AgregarNumeroDeCuotas('$idAcuerdo')", "verde");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>Fecha Inicial de pagos</strong>", 1);
                        $css->ColTabla("<strong>Valor de la Cuota</strong>", 1);  
                         
                        $css->ColTabla("<strong></strong>", 1);
                    $css->CierraFilaTabla(); 
                    $css->FilaTabla(16);
                        print("<td>");
                            $css->input("date", "TxtFechaInicialPagos", "form-control", "TxtFechaInicialPagos", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;' min='".date("Y-m-d")."'");
                        print("</td>"); 
                        print("<td>");
                            
                            $css->input_number_format("text", "ValorCuotaAcuerdo", "form-control", "ValorCuotaAcuerdo", "ValorCuotaAcuerdo", $ValorAnteriorCuota, "Valor de la Cuota", "off", "", "");
                        print("</td>"); 
                        
                        print("<td>");
                            //$css->CrearBotonEvento("btnAgregar", "+", 1, "onclick", "AgregarFechaInicialPagos('$idAcuerdo')", "verde");
                        print("</td>");
                        
                    $css->CierraFilaTabla(); 
                    
                    
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Observaciones</strong>", 3,"C");
                        
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td colspan=3>");
                            $css->textarea("TxtObservacionesAcuerdoPago", "form-control", "TxtObservacionesAcuerdoPago", "", "Observaciones", "", "");
                            $css->Ctextarea();
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print("<td colspan=3>");
                            $css->CrearBotonEvento("btnCalcularProyeccion", "Proyectar pagos", 1, "onclick", "CalculeProyeccionPagosAcuerdo('$idAcuerdo')", "verde");
                        print("</td>");
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
                $css->CrearTitulo("Tomar Fotografía", "naranja");
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->input("file", "upFoto", "form-control", "upFoto", "", "Subir Foto", "Subir Foto", "off", "", "");
                $css->CerrarDiv();
                $css->CrearDiv("", "col-md-6", "center", 1, 1);
                    $css->CrearBotonEvento("btnSubirFoto", "Subir Foto", 1, "onclick", "SubirFoto()", "verde");
                $css->CerrarDiv();
                print("<br><br><br>");
                $css->CrearDiv("", "col-md-12", "center", 1, 1);
                    $css->CrearBotonEvento("btnTomarFoto", "Tomar Foto", 1, "onclick", "TomarFoto()", "azul");
                    print('                
                    <div>
                        <select name="listaDeDispositivos" class="form-control" id="listaDeDispositivos"></select>

                        <p id="estado"></p>
                    </div>
                    <br>
                    <video muted="muted" id="video" style="width:400px"></video>
                    <canvas id="canvas" style="display: none;"></canvas>');
                $css->CerrarDiv();
            $css->CerrarDiv();
            
            
            
            
            $css->CrearDiv("DivProyeccionPagosAcuerdo", "col-md-6", "left", 1, 1);
                
            $css->CerrarDiv();
        break;//fin caso 15    
        
        case 16:// calcula y dibuja las cuotas a pagar de un acuerdo de pago
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicialPagos"]);
            $ValorCuotaAcuerdo=$obCon->normalizar($_REQUEST["ValorCuotaAcuerdo"]);
            $CuotaProgramadaAcuerdo=$obCon->normalizar($_REQUEST["CuotaProgramadaAcuerdo"]);
            $TxtFechaCuotaProgramada=$obCon->normalizar($_REQUEST["TxtFechaCuotaProgramada"]);
            $NumeroCuotas=$obCon->normalizar($_REQUEST["NumeroCuotas"]);
            $cicloPagos=$obCon->normalizar($_REQUEST["cicloPagos"]);  
            $css->CrearTitulo("Proyeccion de pagos", "verde");
            
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CUOTA INICIAL</strong>", 3);
                $css->CierraFilaTabla();
                
                $sql="SELECT t1.ID,t1.ValorPago,(SELECT t2.Metodo FROM metodos_pago t2 WHERE t2.ID=t1.MetodoPago LIMIT 1) AS NombreMetodoPago
                       FROM acuerdo_pago_cuotas_pagadas_temp t1 WHERE t1.idAcuerdoPago='$idAcuerdo' AND TipoCuota=0";
                $Consulta=$obCon->Query($sql);
                $TotalCuotaInicial=0;
                while($DatosCuota=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosCuota["ID"];
                    $TotalCuotaInicial=$TotalCuotaInicial+$DatosCuota["ValorPago"];
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosCuota["NombreMetodoPago"], 1);     
                        $css->ColTabla(number_format($DatosCuota["ValorPago"]), 1);                    
                                          
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");                           
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItemAcuerdo(`1`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                if($TotalCuotaInicial>0){
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTAL CUOTA INICIAL</strong>", 1,"R");
                        $css->ColTabla("<strong>". number_format($TotalCuotaInicial)."</strong>", 1,"L");
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
            $css->CrearTabla();
                
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>CUOTAS PROGRAMADAS</strong>", 3);
                $css->CierraFilaTabla();
                
                $sql="SELECT *
                       FROM acuerdo_pago_proyeccion_pagos_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=1";
                $Consulta=$obCon->Query($sql);
                $TotalCuotasProgramadas=0;
                while($DatosCuota=$obCon->FetchAssoc($Consulta)){
                    $idItem=$DatosCuota["ID"];
                    $TotalCuotasProgramadas=$TotalCuotasProgramadas+$DatosCuota["ValorCuota"];
                    $css->FilaTabla(16);
                        
                        $css->ColTabla($DatosCuota["Fecha"], 1);     
                        $css->ColTabla(number_format($DatosCuota["ValorCuota"]), 1);                    
                                          
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");                           
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItemAcuerdo(`2`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                if($TotalCuotasProgramadas>0){
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTAL CUOTAS PROGRAMADAS</strong>", 1,"R");
                        $css->ColTabla("<strong>". number_format($TotalCuotasProgramadas)."</strong>", 1,"L");
                    $css->CierraFilaTabla();
                }
                $css->CerrarTabla();
                
                $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
                $NIT= $DatosCliente["Num_Identificacion"];

                $sql="SELECT SUM(Debito - Credito) as Total FROM librodiario t2 WHERE t2.Tercero_Identificacion='$NIT' 
                AND EXISTS(SELECT 1 FROM contabilidad_parametros_cuentasxcobrar t3 WHERE t2.CuentaPUC like t3.CuentaPUC) ";

                $Totales=$obCon->FetchAssoc($obCon->Query($sql));
                $SaldoActualCliente=$Totales["Total"];
                $Cupo=$DatosCliente["Cupo"];

                $sql="SELECT SUM(TotalVenta) AS Total FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ";
                $Totales=$obCon->FetchAssoc($obCon->Query($sql));
                $TotalPreventa=$Totales["Total"];
                
                $TotalAcuerdoPago=$SaldoActualCliente+$TotalPreventa;
                $ValorAProyectar=$TotalAcuerdoPago-$TotalCuotaInicial-$TotalCuotasProgramadas;
                
                
            
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Total Del Acuerdo</strong>", 1);
                        $css->ColTabla("<strong>Cuota Inicial</strong>", 1);
                        $css->ColTabla("<strong>Valor en Cuotas Programadas</strong>", 1);
                        $css->ColTabla("<strong>Valor a Proyectar</strong>", 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla(number_format($TotalAcuerdoPago), 1);
                        $css->ColTabla(number_format($TotalCuotaInicial), 1);
                        $css->ColTabla(number_format($TotalCuotasProgramadas), 1);
                        $css->ColTabla("<strong>".number_format($ValorAProyectar)."</strong>", 1);
                    $css->CierraFilaTabla();
                           
                $css->CerrarTabla();
                
                $sql="DELETE FROM acuerdo_pago_proyeccion_pagos_temp WHERE idAcuerdoPago='$idAcuerdo' AND TipoCuota=2 ";
                $obCon->Query($sql);
                
                if($FechaInicial==''){
                    $css->CrearTitulo("Por favor seleccione una Fecha inicial de pagos", "rojo");
                    exit();
                }
                if( !is_numeric($ValorCuotaAcuerdo) or $ValorCuotaAcuerdo<=0 ){
                    $css->CrearTitulo("El valor de la cuota debe ser un número mayor a Cero", "rojo");
                    exit();
                }
                /*
                if( !is_numeric($NumeroCuotas) or $NumeroCuotas<=0 ){
                    $css->CrearTitulo("El número de cuotas debe ser un valor mayor a cero", "rojo");
                    exit();
                }
                 * 
                 */
                
                if( $cicloPagos=='' ){
                    $css->CrearTitulo("Por favor seleccione el ciclo de pagos", "rojo");
                    exit();
                }
                $DatosProyeccion=$obAcuerdo->ConstruyaProyeccionPagos($idAcuerdo,$ValorAProyectar, $ValorCuotaAcuerdo,$cicloPagos,$FechaInicial,$idUser);
                
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Fecha Primera Cuota</strong>", 1);
                        //$css->ColTabla("<strong>Valor de la Cuota</strong>", 1);
                        $css->ColTabla("<strong>Número de Cuotas Calculadas</strong>", 1);
                        $css->ColTabla("<strong>Ciclo de Pago</strong>", 1);
                        $css->ColTabla("<strong>Plazo Maximo de pago</strong>", 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla($FechaInicial, 1);
                        //$css->ColTabla(number_format($ValorCuotaAcuerdo), 1);
                        $css->ColTabla($DatosProyeccion["CuotasCalculadas"], 1);
                        $css->ColTabla($cicloPagos, 1);
                        $css->ColTabla($DatosProyeccion["FechaFinal"], 1);
                    $css->CierraFilaTabla();
                    
                    
                $css->CerrarTabla();
                
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Proyección de Pagos</strong>", 4,"C");                                                
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Cuota</strong>", 1); 
                        $css->ColTabla("<strong>Fecha</strong>", 1);   
                        $css->ColTabla("<strong>Día</strong>", 1);                        
                        $css->ColTabla("<strong>Valor Cuota</strong>", 1);                        
                    $css->CierraFilaTabla();
                    $sql="SELECT * FROM acuerdo_pago_proyeccion_pagos_temp WHERE TipoCuota=2 AND idAcuerdoPago='$idAcuerdo' ORDER BY Fecha ASC";    
                    $Consulta=$obAcuerdo->Query($sql);
                    while($DatosAcuerdoProyeccion=$obAcuerdo->FetchAssoc($Consulta)){ 
                        $idItem=$DatosAcuerdoProyeccion["ID"];
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosAcuerdoProyeccion["NumeroCuota"], 1); 
                            $css->ColTabla($DatosAcuerdoProyeccion["Fecha"], 1); 
                            $css->ColTabla(($obAcuerdo->obtenerNombreDiaFecha($DatosAcuerdoProyeccion["Fecha"])), 1);
                            print("<td>");
                                print('<div class="input-group input-group-md">');
                                    print('<span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-flat" onclick=SumaRestaDiferenciaCuota(`TxtValorCuotaNormal_'.$idItem.'`);EditarCuotaTemporal(`'.$idItem.'`)> <i class="fa fa-plus"> </i> </button>
                                      </span> ');
                                    $css->input_number_format("number", "TxtValorCuotaNormal_$idItem", "form-control", "TxtValorCuotaNormal_$idItem", "Cuota", round($DatosAcuerdoProyeccion["ValorCuota"]), "Valor de la cuota", "off", "", "onChange=EditarCuotaTemporal(`$idItem`)", "style=width:150px");
                                    
                                print("</div>");
                            print("</td>");
                                                     
                        $css->CierraFilaTabla();
                    }
                
                $css->CerrarTabla();
                
        break; //Fin caso 16    
        
        case 17://Dibuja los totales de la proyeccion comparados con la sumatoria de las cuotas
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $idAcuerdo=$obCon->normalizar($_REQUEST["idAcuerdo"]);
            $sql="SELECT SUM(TotalVenta) AS Total FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $TotalPreventa=$Totales["Total"];
            
            $ValorAProyectar=$obAcuerdo->ValorAProyectarTemporalAcuerdo($idAcuerdo, $TotalPreventa, $idCliente);
            print("Valor a Proyectar: <h2 style=color:red><strong>". number_format($ValorAProyectar)."</strong></h2>");
            $TotalCuotasProyectadas=$obAcuerdo->TotalCuotasTemporalAcuerdoPago($idAcuerdo);
            //print("Total Cuotas: <h2><strong>". number_format($TotalCuotasProyectadas)."</strong></h2>");
            $Diferencia=$ValorAProyectar-$TotalCuotasProyectadas;
            $css->input("hidden", "TxtDiferenciaCuotasAcuerdo", "", "TxtDiferenciaCuotasAcuerdo", "", $Diferencia, "", "", "", "");
            print("Diferencia: <h2><strong>". number_format($Diferencia)."</strong></h2>");
        break;//Fin caso 17   
    
        case 18://Dibuja el formulario para un anticipo
           
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]); 
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            if($idCliente<=1){
                $css->CrearTitulo("<strong>Debes Seleccionar un tercero</strong>", "rojo");
                exit();
            }
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 5, "", "", "", ""); //5 guarda el anticipo
            $css->CrearTitulo("Crear un Anticipo para el cliente ".$DatosCliente["RazonSocial"]." ".$DatosCliente["Num_Identificacion"]);

            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                    $css->ColTabla("<strong>Metodo de Pago</strong>", 1);
                    $css->ColTabla("<strong>Valor</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        $css->textarea("TxtObservacionesEncargos", "form-control", "TxtObservacionesEncargos", "", "Observaciones", "", "");
                        $css->Ctextarea();
                    print("</td>");
                    print("<td>");
                        $sql="SELECT * FROM metodos_pago WHERE SoloAdmin=0 ORDER BY ID";
                        $Consulta=$obCon->Query($sql);
                        $css->select("CmbMetodoPagoAnticipo", "form-control", "CmbMetodoPagoAnticipo", "", "", "", "");
                            while($DatosMetodos=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "", "", $DatosMetodos["ID"], "", "");
                                    print($DatosMetodos["Metodo"]);
                                $css->Coption();
                            }

                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->input("number", "TxtValorAnticipoEncargo", "form-control", "TxtValorAnticipoEncargo", "", "", "Valor", "off", "", "");
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        break;// Fin caso 18    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>