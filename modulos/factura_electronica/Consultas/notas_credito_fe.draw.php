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
        case 1: //Dibuja el formulario para crear una nota credito
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", "");
            $css->CrearTitulo("<strong>Crear Nota Credito</strong>", "verde");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Factura que afecta</strong>", 1);
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        $css->input("date", "TxtFecha", "form-control", "TxtFecha", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;'");
                    print("</td>");   
                    print("<td>");
                        $css->select("cmbIdFactura", "form-control", "cmbIdFactura", "", "", "", "style=width:600px");
                            $css->option("", "", "", "", "", "");
                                print("Busque una factura");
                            $css->Coption();
                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "", "Observaciones", "", "");
                        
                        $css->Ctextarea();
                    print("</td>");
                    
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        break; //Fin caso 1
    
        case 2: //Dibuja los items de una nota credito
            $idNota=$obCon->normalizar($_REQUEST["idNota"]);
            $DatosNota=$obCon->DevuelveValores("notas_credito", "ID", $idNota);
            $DatosFactura=$obCon->DevuelveValores("facturas", "idFacturas", $DatosNota["idFactura"]);
            $idFactura=$DatosNota["idFactura"];
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
            print("<strong>Agregar los items a la nota credito $idNota</strong>");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>DATOS DE LA FACTURA A LA QUE AFECTA LA NOTA</strong>", 4,"C");                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Fecha:</strong>", 1);
                    $css->ColTabla("<strong>Numero de Factura:</strong>", 1);
                    $css->ColTabla("<strong>Cliente:</strong>", 1);   
                    $css->ColTabla("<strong>Valor Total de la Factura:</strong>", 1);  
                    $css->ColTabla("<strong>Guardar Nota Credito:</strong>", 1);  
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla($DatosFactura["Fecha"], 1);
                    $css->ColTabla($DatosFactura["Prefijo"].$DatosFactura["NumeroFactura"], 1);
                    $css->ColTabla($DatosCliente["RazonSocial"]." ".$DatosCliente["Num_Identificacion"], 1);   
                    $css->ColTabla(number_format($DatosFactura["Total"]), 1); 
                    print("<td style='font-size:30px;text-align:center;color:red' title='Borrar'>"); 
                        $css->li("BtnGuardarNota", "fa  fa-save", "", "onclick=ConfirmaGuardarNota(`$idNota`) style=font-size:60px;cursor:pointer;text-align:center;color:green");
                        $css->Cli();
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            $css->CrearDiv("DivItemsFactura", "col-md-6", "left", 1, 1);
                $css->CrearTitulo("<strong>ITEMS DE LA FACTURA:</strong>", "rojo");
                $css->CrearTabla();
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>REF</strong>", 1);
                        $css->ColTabla("<strong>Producto o Servicio</strong>", 1);
                        $css->ColTabla("<strong>Precio Unitario</strong>", 1);
                        //$css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Subtotal</strong>", 1);
                        $css->ColTabla("<strong>IVA</strong>", 1);
                        $css->ColTabla("<strong>Total</strong>", 1);
                        $css->ColTabla("<strong>Accion</strong>", 1);
                    $css->CierraFilaTabla();
                    $Consulta=$obCon->ConsultarTabla("facturas_items", " WHERE idFactura='$idFactura'");
                    while($DatosItemsFactura=$obCon->FetchAssoc($Consulta)){
                        $idItem=$DatosItemsFactura["ID"];
                        $css->FilaTabla(14);
                        $css->ColTabla($DatosItemsFactura["Referencia"], 1);
                        $css->ColTabla($DatosItemsFactura["Nombre"], 1);
                        //$css->ColTabla(number_format($DatosItemsFactura["ValorUnitarioItem"]), 1);
                        print("<td>");
                            $css->input("number", "TxtCantidad_".$idItem, "form-control", "TxtCantidad_".$idItem, "cantidad", $DatosItemsFactura["Cantidad"], "Cantidad", "off", "", "");
                        print("</td>");
                        
                        $css->ColTabla(number_format($DatosItemsFactura["SubtotalItem"]), 1);
                        $css->ColTabla(number_format($DatosItemsFactura["IVAItem"]), 1);
                        $css->ColTabla(number_format($DatosItemsFactura["TotalItem"]), 1);
                        print("<td>");
                            $css->CrearBotonEvento("BtnAgregarItem_$idItem", "Agregar", 1, "onclick", "AgregarItemANota(`$idItem`,`$idNota`)", "naranja");
                        print("</td>");
                    $css->CierraFilaTabla();
                    }
                $css->CerrarTabla();
            $css->CerrarDiv();
            $css->CrearDiv("DivItemsNota", "col-md-6", "left", 1, 1);
            
            $css->CerrarDiv();
            
        break;// fin caso 2
    
        case 3:// dibujar los items de la nota
            $idNota=$obCon->normalizar($_REQUEST["idNota"]);
            $css->CrearTitulo("<strong>ITEMS DE LA NOTA CREDITO:</strong>", "azul");
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>REF</strong>", 1);
                    $css->ColTabla("<strong>Producto o Servicio</strong>", 1);
                    $css->ColTabla("<strong>Precio Unitario</strong>", 1);
                    //$css->ColTabla("<strong>Cantidad</strong>", 1);
                    $css->ColTabla("<strong>Subtotal</strong>", 1);
                    $css->ColTabla("<strong>IVA</strong>", 1);
                    $css->ColTabla("<strong>Total</strong>", 1);
                    $css->ColTabla("<strong>Accion</strong>", 1);
                $css->CierraFilaTabla();
            $Consulta=$obCon->ConsultarTabla("notas_credito_items", "WHERE idNotaCredito='$idNota'");
            $Subtotal=0;
            $Impuestos=0;
            $Total=0;
            while($DatosItems=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosItems["ID"];
                $Subtotal=$Subtotal+$DatosItems["SubtotalItem"];
                $Impuestos=$Subtotal+$DatosItems["IVAItem"];
                $Total=$Subtotal+$DatosItems["TotalItem"];
                $css->FilaTabla(14);
                    $css->ColTabla($DatosItems["Referencia"], 1);
                    $css->ColTabla($DatosItems["Nombre"], 1);
                    $css->ColTabla(number_format($DatosItems["Cantidad"]), 1);
                    $css->ColTabla(number_format($DatosItems["SubtotalItem"]), 1);
                    $css->ColTabla(number_format($DatosItems["IVAItem"]), 1);
                    $css->ColTabla(number_format($DatosItems["TotalItem"]), 1);
                    print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>"); 
                        $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`1`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                        $css->Cli();
                    print("</td>");
                $css->CierraFilaTabla();
            }
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Subtotal:</strong>", 5, "R");
                $css->ColTabla("<strong>".number_format($Subtotal)."</strong>", 1, "l");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Impuestos:</strong>", 5, "R");
                $css->ColTabla("<strong>".number_format($Impuestos)."</strong>", 1, "l");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Total:</strong>", 5, "R");
                $css->ColTabla("<strong>".number_format($Total)."</strong>", 1, "l");
            $css->CierraFilaTabla();
            $css->CerrarTabla();
        break;//fin caso 3    
    
                
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>