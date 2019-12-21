<?php
if(file_exists("../../modelo/php_conexion.php")){
    include_once("../../modelo/php_conexion.php");
}
/* 
 * Clase que realiza los procesos de facturacion electronica
 * Julian Alvaran
 * Techno Soluciones SAS
 */

class Factura_Electronica extends ProcesoVenta{
    
    public function callAPI($method, $url, $data) {
        
        $DatosParametrosFE=$this->DevuelveValores("facturas_electronicas_parametros", "ID", 4);
        $TokenTS5=$DatosParametrosFE["Valor"];
        
        $curl = curl_init();

        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Authorization: Bearer '.$TokenTS5,
           'Content-Type: application/json',
           'Accept: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }
    
    public function JSONFactura($idFactura) {
        $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
        $idEmpresaPro=$DatosFactura["EmpresaPro_idEmpresaPro"];
        $DatosEmpresaPro=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $NumeroFactura=$DatosFactura["NumeroFactura"];
        $TipoDocumento=1; // 1 Factura nacional  ver type_documents de la base de datos del api
        $FechaFactura=$DatosFactura["Fecha"];
        $HoraFactura=$DatosFactura["Hora"];
        
        $MonedaFactura="COP";
        $Datos["Fecha"]=$DatosFactura["Fecha"];
        $Datos["Dias"]=30;
        $FechaVencimiento=$this->SumeDiasFecha($Datos);
        
        //Datos Adquiriente
        
        $AdqNit=$DatosCliente["Num_Identificacion"];
        $AdqTipoDocumento=$DatosCliente["Tipo_Documento"];
        $AdqTipoPersona=2;
        if($AdqTipoDocumento==31 or $AdqTipoDocumento==44){
            $AdqTipoPersona=1; //1 Juridica 2 Persona Natural
        }
        $adqNumTipoRegimen=0;
        $AdqRazonSocial= str_replace("'", "", $DatosCliente["RazonSocial"]);
        $AdqRazonSocial= str_replace('"', "", $AdqRazonSocial);
        $AdqDireccion=str_replace("'", "",$DatosCliente["Direccion"]);
        $AdqDireccion=str_replace('"', "",$AdqDireccion);
        if($AdqDireccion==''){
            $AdqDireccion="CALLE 1 1 106";
        }
        $DatosMunicipio=$this->DevuelveValores("catalogo_municipios", "CodigoDANE", $DatosCliente["Cod_Dpto"].$DatosCliente["Cod_Mcipio"]);
        $AdqCiudad=$DatosMunicipio["ID"];
        $AdqContactoTelefono=$DatosCliente["Telefono"];
        if($AdqContactoTelefono==''){
            $AdqContactoTelefono=3117222619;
        }
        $AdqContactoMail=$DatosCliente["Email"];
        if($AdqContactoMail==""){
            $AdqContactoMail='no@gmail.com';
        }
        $idFormaPago=2;
        if($DatosFactura["FormaPago"]=="Contado"){
            $idFormaPago=1;
        }
        $json_factura='{
            "number": '.$NumeroFactura.',
            "sync": true,
            "send": true,
            "date": "'.$FechaFactura.'", 
            "time": "'.$HoraFactura.'", 
            "type_document_id": '.$TipoDocumento.',
            "customer": {
                "identification_number": '.$AdqNit.',
                "name": "'.$AdqRazonSocial.'",
                "phone": "'.$AdqContactoTelefono.'",
                "address": "'.$AdqDireccion.'",
                "email": "'.$AdqContactoMail.'",
                "merchant_registration": "NA"
            },
            "payment_form": {
                "payment_form_id": "'.$idFormaPago.'",
                "payment_due_date": "'.$FechaVencimiento.'",
                "duration_measure": "30"
            },
            ';
        if($DatosFactura["ObservacionesFact"]<>''){
            $json_factura.=' 
            "notes": [{
                "text":"'.$DatosFactura["ObservacionesFact"].'"
            }],';
        }
        $json_factura.='"tax_totals": [';
        $sql="SELECT SUM(SubtotalItem) as Subtotal, SUM(IVAItem) as IVA, SUM(TotalItem) as Total,PorcentajeIVA FROM facturas_items 
                WHERE idFactura='$idFactura' GROUP BY PorcentajeIVA ";
        $Consulta= $this->Query($sql);
        $SubtotalFactura=0;
        $BaseGravable=0;
        $ImpuestosFactura=0;
        $TotalAPagar=0;
        while($DatosItems= $this->FetchAssoc($Consulta)){
            $PorcentajeIVA=$DatosItems["PorcentajeIVA"];
            $SubtotalFactura=$SubtotalFactura+$DatosItems["Subtotal"];
            $BaseGravable=$BaseGravable+$DatosItems["Subtotal"];
            $ImpuestosFactura=$ImpuestosFactura+$DatosItems["IVA"];
            
            if($PorcentajeIVA=="Exc" or $PorcentajeIVA=="0%"){
                $json_factura.='
                    {
                        "tax_id": 15,
                        "percent": "0.00",
                        "tax_amount": "0.00",
                        "taxable_amount": "'.round($DatosItems["Total"],2).'"
                    },';
            }else{
                $PorcentajeIVA = str_replace("%", "", $PorcentajeIVA);                
                $PorcentajeIVA = round($PorcentajeIVA/100,2);
                $DatosImpuestos= $this->DevuelveValores("porcentajes_iva", "Valor", $PorcentajeIVA);
                $idImpuestoAPI=$DatosImpuestos["idImpuestoAPIFE"];
                if(is_numeric($idImpuestoAPI)){
                    $Impuesto=round($DatosItems["PorcentajeIVA"],2);
                    $json_factura.='
                    {
                        "tax_id": '.$idImpuestoAPI.',
                        "percent": "'.round($Impuesto,2).'",
                        "tax_amount": "'.round($DatosItems["IVA"],2).'",
                        "taxable_amount": "'.round($DatosItems["Subtotal"],2).'"
                    },';
                }
            }
        }
            $TotalAPagar=round($SubtotalFactura+$ImpuestosFactura,2);
            $json_factura=substr($json_factura, 0, -1);
            $json_factura.='],';
            $json_factura.='"legal_monetary_totals":
                { 
                    "line_extension_amount": "'.round($SubtotalFactura,2).'",
                    "tax_exclusive_amount": "'.round($BaseGravable,2).'",
                    "tax_inclusive_amount": "'.round($TotalAPagar,2).'",
                    "allowance_total_amount": "0.00",
                    "charge_total_amount": "0.00",    
                    "payable_amount": "'.round($TotalAPagar,2).'"
                },';
            
            $json_factura.='"invoice_lines":[';
            
            $sql="SELECT * FROM facturas_items WHERE idFactura='$idFactura'";
            $Consulta= $this->Query($sql);
            while($DatosItemsFactura = $this->FetchAssoc($Consulta)){
                $PorcentajeIVA=$DatosItemsFactura["PorcentajeIVA"];
                if($PorcentajeIVA=="Exc" or $PorcentajeIVA=="0%" or $PorcentajeIVA=="0"){
                    $idImpuestoAPI=15;
                    $Impuestos="0.00";
                    $Subtotal=round($DatosItemsFactura["SubtotalItem"],2);
                    $Porcentaje="0.00";
                    $Total=round($Subtotal+$Impuestos,2);
                }else{
                    $PorcentajeIVA = str_replace("%", "", $PorcentajeIVA); 
                    $Porcentaje=$PorcentajeIVA;
                    $PorcentajeIVA = round($PorcentajeIVA/100,2);
                    
                    $DatosImpuestos= $this->DevuelveValores("porcentajes_iva", "Valor", $PorcentajeIVA);
                    $idImpuestoAPI=$DatosImpuestos["idImpuestoAPIFE"];
                    $Subtotal=round($DatosItemsFactura["SubtotalItem"],2);
                    $Impuestos=round($DatosItemsFactura["IVAItem"],2);
                    $Total=round($Subtotal+$Impuestos,2);                    
                }
                if(!isset($Totales[$idImpuestoAPI]["Subtotal"])){
                    $Totales[$idImpuestoAPI]["Subtotal"]=0;
                    $Totales[$idImpuestoAPI]["Impuestos"]=0;
                    $Totales[$idImpuestoAPI]["Total"]=0;
                }
                $Totales[$idImpuestoAPI]["Subtotal"]=$Totales[$idImpuestoAPI]["Subtotal"]+$Subtotal;
                $Totales[$idImpuestoAPI]["Impuestos"]=$Totales[$idImpuestoAPI]["Impuestos"]+$Impuestos;
                $Totales[$idImpuestoAPI]["Total"]=$Totales[$idImpuestoAPI]["Total"]+$Total;
                $NombreItem= str_replace('"', "", $DatosItemsFactura["Nombre"]);
                $NombreItem= str_replace("'", "", $NombreItem);
                $ReferenciaItem= str_replace('"', "", $DatosItemsFactura["Referencia"]);
                $ReferenciaItem= str_replace("'", "", $ReferenciaItem);
                $json_factura.='{ 
                    "unit_measure_id": 642, 
                    "invoiced_quantity": "'.round($DatosItemsFactura["Cantidad"]*$DatosItemsFactura["Dias"],6).'", 
                    "line_extension_amount": "'.round($DatosItemsFactura["SubtotalItem"],2).'", 
                    "free_of_charge_indicator": false,
                    "tax_totals": [{
                        "tax_id": '.$idImpuestoAPI.',
                        "tax_amount": "'.round($DatosItemsFactura["IVAItem"],2).'",  
                        "taxable_amount": "'.round($DatosItemsFactura["SubtotalItem"],2).'",
                        "percent": "'.round($Porcentaje,2).'" 
                    }],                    
                    "description": "'. str_replace("\n","",$NombreItem).'",
                        "code": "'.trim(preg_replace("/[\r\n|\n|\r]+/", "", $ReferenciaItem)).'",
                        "type_item_identification_id": 3,
                        "price_amount": "'.round($DatosItemsFactura["ValorUnitarioItem"],2).'",
                        "base_quantity": "1.000000"
                    },';
                
            }
            
            $json_factura=substr($json_factura, 0, -1);
            $json_factura.=']}';
            
        return($json_factura);
    }
    
    public function JSONNotaCredito($idNota) {
        $DatosNota=$this->DevuelveValores("notas_credito", "ID", $idNota);
        $idFactura=$DatosNota["idFactura"];
        $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
        $DatosFacturaElectronica=$this->DevuelveValores("facturas_electronicas_log", "ID", $DatosNota["idFacturaElectronica"]);
        $Cufe=$DatosFacturaElectronica["UUID"];
        $idEmpresaPro=$DatosFactura["EmpresaPro_idEmpresaPro"];
        $DatosEmpresaPro=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $NumeroFactura=$DatosFactura["NumeroFactura"];
        $TipoDocumento=5; // 5 nota credito
        $FechaFactura=$DatosFactura["Fecha"];
        $HoraFactura=$DatosFactura["Hora"];
        
        $MonedaFactura="COP";
        $Datos["Fecha"]=$DatosFactura["Fecha"];
        $Datos["Dias"]=30;
        $FechaVencimiento=$this->SumeDiasFecha($Datos);
        
        //Datos Adquiriente
        
        $AdqNit=$DatosCliente["Num_Identificacion"];
        $AdqTipoDocumento=$DatosCliente["Tipo_Documento"];
        $AdqTipoPersona=2;
        if($AdqTipoDocumento==31 or $AdqTipoDocumento==44){
            $AdqTipoPersona=1; //1 Juridica 2 Persona Natural
        }
        $adqNumTipoRegimen=0;
        $AdqRazonSocial= str_replace("'", "", $DatosCliente["RazonSocial"]);
        $AdqRazonSocial= str_replace('"', "", $AdqRazonSocial);
        $AdqDireccion=str_replace("'", "",$DatosCliente["Direccion"]);
        $AdqDireccion=str_replace('"', "",$AdqDireccion);
        if($AdqDireccion==''){
            $AdqDireccion="CALLE 1 1 106";
        }
        $DatosMunicipio=$this->DevuelveValores("catalogo_municipios", "CodigoDANE", $DatosCliente["Cod_Dpto"].$DatosCliente["Cod_Mcipio"]);
        $AdqCiudad=$DatosMunicipio["ID"];
        $AdqContactoTelefono=$DatosCliente["Telefono"];
        if($AdqContactoTelefono==''){
            $AdqContactoTelefono=3117222619;
        }
        $AdqContactoMail=$DatosCliente["Email"];
        if($AdqContactoMail==""){
            $AdqContactoMail='no@gmail.com';
        }
        $idFormaPago=2;
        if($DatosFactura["FormaPago"]=="Contado"){
            $idFormaPago=1;
        }
        
        $json_factura='{
                "billing_reference": {
                    "number": "'.$DatosFactura["Prefijo"].$NumeroFactura.'",
                    "uuid": "'.$Cufe.'",
                    "issue_date": "'.$FechaFactura.'"
                },
                "discrepancy_response": {
                    "correction_concept_id": 1
                },';
        
        $json_factura.='
            "number": '.$idNota.',
            "sync": true,
            "send": true,
            "type_document_id": '.$TipoDocumento.',
            "customer": {
                "identification_number": '.$AdqNit.',
                "name": "'.$AdqRazonSocial.'",
                "phone": "'.$AdqContactoTelefono.'",
                "address": "'.$AdqDireccion.'",
                "email": "'.$AdqContactoMail.'",
                "merchant_registration": "NA"
            },
            
            ';
        
        $json_factura.='"tax_totals": [';
        $sql="SELECT SUM(SubtotalItem) as Subtotal, SUM(IVAItem) as IVA, SUM(TotalItem) as Total,PorcentajeIVA FROM notas_credito_items 
                WHERE idNotaCredito='$idNota' GROUP BY PorcentajeIVA ";
        $Consulta= $this->Query($sql);
        $SubtotalFactura=0;
        $BaseGravable=0;
        $ImpuestosFactura=0;
        $TotalAPagar=0;
        while($DatosItems= $this->FetchAssoc($Consulta)){
            $PorcentajeIVA=$DatosItems["PorcentajeIVA"];
            $SubtotalFactura=$SubtotalFactura+$DatosItems["Subtotal"];
            $BaseGravable=$BaseGravable+$DatosItems["Subtotal"];
            $ImpuestosFactura=$ImpuestosFactura+$DatosItems["IVA"];
            
            if($PorcentajeIVA=="Exc" or $PorcentajeIVA=="0%"){
                $json_factura.='
                    {
                        "tax_id": 15,
                        "percent": "0.00",
                        "tax_amount": "0.00",
                        "taxable_amount": "'.round($DatosItems["Total"],2).'"
                    },';
            }else{
                $PorcentajeIVA = str_replace("%", "", $PorcentajeIVA);                
                $PorcentajeIVA = round($PorcentajeIVA/100,2);
                $DatosImpuestos= $this->DevuelveValores("porcentajes_iva", "Valor", $PorcentajeIVA);
                $idImpuestoAPI=$DatosImpuestos["idImpuestoAPIFE"];
                if(is_numeric($idImpuestoAPI)){
                    $Impuesto=round($DatosItems["PorcentajeIVA"],2);
                    $json_factura.='
                    {
                        "tax_id": '.$idImpuestoAPI.',
                        "percent": "'.round($Impuesto,2).'",
                        "tax_amount": "'.round($DatosItems["IVA"],2).'",
                        "taxable_amount": "'.round($DatosItems["Subtotal"],2).'"
                    },';
                }
            }
        }
            $TotalAPagar=round($SubtotalFactura+$ImpuestosFactura,2);
            $json_factura=substr($json_factura, 0, -1);
            $json_factura.='],';
            $json_factura.='"legal_monetary_totals":
                { 
                    "line_extension_amount": "'.round($SubtotalFactura,2).'",
                    "tax_exclusive_amount": "'.round($BaseGravable,2).'",
                    "tax_inclusive_amount": "'.round($TotalAPagar,2).'",
                    "allowance_total_amount": "0.00",
                    "charge_total_amount": "0.00",    
                    "payable_amount": "'.round($TotalAPagar,2).'"
                },';
            
            $json_factura.='"credit_note_lines":[';
            
            $sql="SELECT * FROM notas_credito_items WHERE idNotaCredito='$idNota'";
            $Consulta= $this->Query($sql);
            while($DatosItemsFactura = $this->FetchAssoc($Consulta)){
                $PorcentajeIVA=$DatosItemsFactura["PorcentajeIVA"];
                if($PorcentajeIVA=="Exc" or $PorcentajeIVA=="0%" or $PorcentajeIVA=="0"){
                    $idImpuestoAPI=15;
                    $Impuestos="0.00";
                    $Subtotal=round($DatosItemsFactura["SubtotalItem"],2);
                    $Porcentaje="0.00";
                    $Total=round($Subtotal+$Impuestos,2);
                }else{
                    $PorcentajeIVA = str_replace("%", "", $PorcentajeIVA); 
                    $Porcentaje=$PorcentajeIVA;
                    $PorcentajeIVA = round($PorcentajeIVA/100,2);
                    
                    $DatosImpuestos= $this->DevuelveValores("porcentajes_iva", "Valor", $PorcentajeIVA);
                    $idImpuestoAPI=$DatosImpuestos["idImpuestoAPIFE"];
                    $Subtotal=round($DatosItemsFactura["SubtotalItem"],2);
                    $Impuestos=round($DatosItemsFactura["IVAItem"],2);
                    $Total=round($Subtotal+$Impuestos,2);                    
                }
                if(!isset($Totales[$idImpuestoAPI]["Subtotal"])){
                    $Totales[$idImpuestoAPI]["Subtotal"]=0;
                    $Totales[$idImpuestoAPI]["Impuestos"]=0;
                    $Totales[$idImpuestoAPI]["Total"]=0;
                }
                $Totales[$idImpuestoAPI]["Subtotal"]=$Totales[$idImpuestoAPI]["Subtotal"]+$Subtotal;
                $Totales[$idImpuestoAPI]["Impuestos"]=$Totales[$idImpuestoAPI]["Impuestos"]+$Impuestos;
                $Totales[$idImpuestoAPI]["Total"]=$Totales[$idImpuestoAPI]["Total"]+$Total;
                $NombreItem= str_replace('"', "", $DatosItemsFactura["Nombre"]);
                $NombreItem= str_replace("'", "", $NombreItem);
                $ReferenciaItem= str_replace('"', "", $DatosItemsFactura["Referencia"]);
                $ReferenciaItem= str_replace("'", "", $ReferenciaItem);
                $json_factura.='{ 
                    "unit_measure_id": 642, 
                    "invoiced_quantity": "'.round($DatosItemsFactura["Cantidad"]*$DatosItemsFactura["Dias"],6).'", 
                    "line_extension_amount": "'.round($DatosItemsFactura["SubtotalItem"],2).'", 
                    "free_of_charge_indicator": false,
                    "tax_totals": [{
                        "tax_id": '.$idImpuestoAPI.',
                        "tax_amount": "'.round($DatosItemsFactura["IVAItem"],2).'",  
                        "taxable_amount": "'.round($DatosItemsFactura["SubtotalItem"],2).'",
                        "percent": "'.round($Porcentaje,2).'" 
                    }],                    
                    "description": "'. str_replace("\n","",$NombreItem).'",
                        "code": "'.trim(preg_replace("/[\r\n|\n|\r]+/", "", $ReferenciaItem)).'",
                        "type_item_identification_id": 3,
                        "price_amount": "'.round($DatosItemsFactura["ValorUnitarioItem"],2).'",
                        "base_quantity": "1.000000"
                    },';
                
            }
            
            $json_factura=substr($json_factura, 0, -1);
            $json_factura.=']}';
            
        return($json_factura);
    }
    
    public function FacturaElectronica_Registre_Respuesta_Server($idFactura,$RespuestaServidor,$Estado) {
        $Datos["idFactura"]=$idFactura;
        $Datos["Estado"]=$Estado;
        $Datos["RespuestaCompletaServidor"]=$RespuestaServidor;
        $Datos["Created"]=date("Y-m-d H:i:s");
        $sql=$this->getSQLInsert("facturas_electronicas_log", $Datos);
        $this->Query($sql);
    }
    
    public function CrearPDFDesdeBase64($pdf_base64,$NumeroFactura) {
        
        $DatosRuta=$this->DevuelveValores("configuracion_general", "ID", 16);
        $Ruta=$DatosRuta["Valor"];
        $NombreArchivo=$DatosRuta["Valor"].$NumeroFactura."_FE.pdf";
        $pdf_decoded = base64_decode($pdf_base64);
        
        $pdf = fopen ($NombreArchivo,'w');
        fwrite ($pdf,$pdf_decoded);
        fclose ($pdf);
        return($NombreArchivo);
    }
    
    public function CrearZIPDesdeBase64($zip_base64,$NumeroFactura) {
        
        $DatosRuta=$this->DevuelveValores("configuracion_general", "ID", 16);
        $Ruta=$DatosRuta["Valor"];
        $NombreArchivo=$DatosRuta["Valor"].$NumeroFactura."_FE.zip";
        $pdf_decoded = base64_decode($zip_base64);
        
        $pdf = fopen ($NombreArchivo,'w');
        fwrite ($pdf,$pdf_decoded);
        fclose ($pdf);
        return($NombreArchivo);
    }
    
    
    //Fin Clases
}