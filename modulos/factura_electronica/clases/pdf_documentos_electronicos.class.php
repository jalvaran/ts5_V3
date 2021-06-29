<?php

if(file_exists("../../../general/clases/ClasesPDFDocumentos.class.php")){
    include_once("../../../general/clases/ClasesPDFDocumentos.class.php");
}

class PDF_Documentos_Electronicos extends Documento{
      
    
    public function pdf_factura_electronica($idFactura,$Guardar=0,$Ruta="../../tmp/",$nombre_factura="factura") {
        $VistaFactura=1;
        $empresa_id=1;
        $DatosFactura=$this->obCon->DevuelveValores("facturas", "idFacturas", $idFactura);
        $DatosEmpresaPro=$this->obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
        $sql="SELECT * FROM facturas_electronicas_log WHERE idFactura='$idFactura' AND UUID<>'' ";
        $datos_documento_electronico=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        //$datos_documento_electronico=$this->obCon->DevuelveValores("facturas_electronicas_log", "idFactura", $idFactura);
        $datos_tercero=$this->obCon->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $DatosFactura["uuid"]=$datos_documento_electronico["UUID"];
        $DatosFactura["firma_digital"]=$datos_documento_electronico["firma_digital"];
        $CodigoFactura="$DatosFactura[Prefijo]-$DatosFactura[NumeroFactura]";
        $Documento="";
        
        $this->PDF_Ini("documento_electronico", 8, "",1,"../../../");
        $idFormato=43;
        $DatosFormatoCalidad=$this->obCon->DevuelveValores("formatos_calidad", "ID", $idFormato);
        $DatosFormatoCalidad["Nombre"]= utf8_encode($DatosFormatoCalidad["Nombre"]);
        //$this->PDF_Encabezado($DatosFactura["Fecha"],1, $idFormato, "",$Documento);
        $this->pdf_encabezado_documento_electronico($datos_tercero,$empresa_id, $DatosFormatoCalidad, $DatosFactura,$Documento,"../../../");
        $this->informacion_general($DatosFactura,$datos_tercero);
        $Position=$this->PDF->GetY();
        //$this->PDF->SetY($Position+35);
        $html= $this->HTML_Items_Factura($idFactura);
        
        $this->PDF_Write($html);
        
        $Position=$this->PDF->GetY();
        if($Position>251){
          $this->PDF_Add();
        }
        
        $html= $this->HTML_Totales_Factura($idFactura, $DatosFactura["ObservacionesFact"], $DatosEmpresaPro["ObservacionesLegales"]);
       
        if($VistaFactura==1)
        $this->PDF->SetY(250);
        $this->PDF_Write($html);
        if($VistaFactura==3){
            $this->PDF_Write("<br>");
            $html=$this->FirmaDocumentos();
            $this->PDF_Write($html);
        }
        
        $this->PDF_Output("$nombre_factura",$Guardar,$Ruta);
        return($Ruta."$nombre_factura".".pdf");
    }
    
    public function pdf_encabezado_documento_electronico($datos_tercero,$idEmpresa,$DatosFormatoCalidad,$datos_factura,$NumeracionDocumento="",$Patch='../../') {
        $DatosEmpresaPro=$this->obCon->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresa);
        
        
        $RutaLogo=$Patch."$DatosEmpresaPro[RutaImagen]";
        if(!file_exists($RutaLogo)){
            $DatosEmpresaPro1=$this->obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
            $RutaLogo=$Patch."$DatosEmpresaPro1[RutaImagen]";
        }
        $titulo="<h2><br><br>".$DatosFormatoCalidad["Nombre"]."<br>".$datos_factura["Prefijo"]."-".$datos_factura["NumeroFactura"]."</h2>";
        $titulo_cufe="<h4>CUFE: ".$datos_factura["uuid"]."</h4>";
        $titulo_firma_digital="<h6>Firma Digital: ".$datos_factura["firma_digital"]."</h6>";
        ///////////////////////////////////////////////////////
        //////////////encabezado//////////////////
        ////////////////////////////////////////////////////////
        //////
        //////
        $tbl = ' 
            <table cellspacing="0" cellpadding="1" border="1">
                <tr border="1">
                    <td width="183px" border="1" style="text-align: center;"><br><br><img src="'.$RutaLogo.'" style="width:150px;height:80px;"></td>

                    <td width="290px" height="110px" style="text-align: center; vertical-align: center;">'.$titulo.'</td>
                    <td width="183px" border="1" style="text-align: center;"></td>
                </tr>
                <tr border="1">
                    <td colspan="3">'.$titulo_cufe.'</td>
                </tr>';
            if($datos_factura["firma_digital"]<>''){
                $tbl.='<tr border="1">
                        <td colspan="3">'.$titulo_firma_digital.'</td>
                    </tr>';
            }
        
        $tbl.='</table>
            ';
        $this->PDF->writeHTML($tbl, true, false, false, false, '');
        $this->PDF->SetFillColor(255, 255, 255);
        $txt="<h3>".($DatosEmpresaPro["RazonSocial"])."<br>NIT ".$DatosEmpresaPro["NIT"]." - ".$DatosEmpresaPro["DigitoVerificacion"]."</h3>";
        $this->PDF->MultiCell(62, 5, $txt, 0, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');
        $txt=$DatosEmpresaPro["Direccion"]."<br>".$DatosEmpresaPro["Telefono"]."<br>".$DatosEmpresaPro["Ciudad"]."<br>".$DatosEmpresaPro["WEB"];
        $this->PDF->MultiCell(62, 5, $txt, 0, 'C', 1, 0, '', '', true,0, true, true, 10, 'M');
        $Documento="<strong>$NumeracionDocumento</strong><br><h5>Impreso por TS5, Techno Soluciones SAS <BR>NIT 900.833.180 3177740609</h5><br>";
        $this->PDF->MultiCell(62, 5, $Documento, 0, 'R', 1, 0, '', '', true,0, true ,true, 10, 'M');
        $this->PDF->writeHTML("<br>", true, false, false, false, '');
        $idFactura=$datos_factura["idFacturas"];
        $sql="SELECT SUM(ValorOtrosImpuestos) as ValorOtrosImpuestos,SUM(SubtotalItem) as Subtotal, SUM(IVAItem) as IVA, SUM(TotalItem) as Total FROM facturas_items "
                . " WHERE idFactura='$idFactura'";
        $totales_factura=$this->obCon->FetchAssoc($this->obCon->Query($sql));
        $dato_codigo='NumFac: '.$datos_factura["Prefijo"].$datos_factura["NumeroFactura"].'
                    FecFac: '.$datos_factura["Fecha"].'
                    HorFac: '.$datos_factura["Hora"].'
                    NitFac: '.$DatosEmpresaPro["NIT"].'
                    DocAdq: '.$datos_tercero["Num_Identificacion"].'
                    ValFac: '.round($totales_factura["Subtotal"],2).'
                    ValIva: '.round($totales_factura["IVA"],2).'
                    ValOtroIm: '.round($totales_factura["ValorOtrosImpuestos"],2).'
                    ValTolFac: '.round($totales_factura["Total"],2).'
                    CUFE: '.$datos_factura["uuid"].'
                    QRCode: https://catalogo-vpfe-hab.dian.gov.co/document/searchqr?documentkey='.$datos_factura["uuid"];
                    
                    $style = array(
                        'border' => false,
                        'padding' => 0,
                        'fgcolor' => array(0,0,0),
                        'bgcolor' => false
                    );
                    
                    $this->PDF->write2DBarcode($dato_codigo, 'QRCODE,H', 156, 12, 27, 27, $style, 'N');
                    $this->PDF->Text(30, 30, '');
    }
    
    /**
     * Encabezado de las Facturas
     * @param type $idFactura
     * @return type
     */
    public function informacion_general($DatosFactura,$DatosCliente) {
        
        $DatosCentroCostos=$this->obCon->DevuelveValores("centrocosto","ID",$DatosFactura["CentroCosto"]);
        $DatosEmpresaPro=$this->obCon->DevuelveValores("empresapro", "idEmpresaPro", $DatosCentroCostos["EmpresaPro"]);
        
        $DatosResolucion=$this->obCon->DevuelveValores("empresapro_resoluciones_facturacion","ID",$DatosFactura["idResolucion"]);
        $datos_departamento=$this->obCon->DevuelveValores("catalogo_departamentos","CodigoDANE",$DatosCliente["Cod_Dpto"]);
        
        
        $periodo="";
        if($DatosFactura["periodo_fecha_inicio"]<>'0000-00-00' and $DatosFactura["periodo_fecha_fin"]<>'0000-00-00'){
            $periodo=$DatosFactura["periodo_fecha_inicio"].' - '.$DatosFactura["periodo_fecha_fin"];
        }
        $info_legal="$DatosEmpresaPro[ResolucionDian], RES DIAN: $DatosResolucion[NumResolucion] del $DatosResolucion[Fecha]
             FACTURA AUT. $DatosResolucion[Prefijo]-$DatosResolucion[Desde] A $DatosResolucion[Prefijo]-$DatosResolucion[Hasta] Vigencia: $DatosResolucion[FechaVencimiento]";
        
        $dias_pago= str_replace("Credito", "", $DatosFactura["FormaPago"]);
        $dias_pago= str_replace("dias", "", $dias_pago);
        $dias_pago= str_replace(" ", "", $dias_pago);
        $dias_pago= str_replace("a", "", $dias_pago);
        //print($dias_pago);
        if(is_numeric($dias_pago)){
            
            $Datos["Dias"]=$dias_pago;
            
        }else{
            $Datos["Dias"]=30;
        }
        $Datos["Fecha"]=$DatosFactura["Fecha"];
        $FechaVencimiento=$this->obCon->SumeDiasFecha($Datos);
        
        if($DatosFactura["FormaPago"]=='Contado'){
            $FechaVencimiento=$DatosFactura["Fecha"];
        }
        
        
        
        $tbl = ' <br><br><br><br><br><br><br><br><br><br><br><br>
                <table cellspacing="0" cellpadding="2" border="1">
                    <tr>
                        <td colspan="6">'.$info_legal.'</td>      
                    </tr>
                    
                    <tr>
                        <td width="95px" ><strong>Fecha de Emisión:</strong></td>
                        <td width="55px"><strong>Hora:</strong></td>
                        <td width="160px" align="center"  ><strong>Orden de Compra</strong></td>
                        <td width="120px" align="center" ><strong>Periodo</strong></td>
                        <td width="120px" ><strong>Fecha de Vencimiento:</strong></td>
                        <td width="100px" align="center" ><strong>Forma de Pago</strong></td>
                    </tr>
                    <tr>
                        <td >'.$DatosFactura["Fecha"].'</td>
                        <td >'.$DatosFactura["Hora"].'</td>
                        <td >'.$DatosFactura["OCompra"].'</td>
                        <td align="center" >'.$periodo.'</td>
                        <td align="center" >'.$FechaVencimiento.'</td>
                        <td align="center" >'.$DatosFactura["FormaPago"].'</td>
                    </tr>
                        
                   
                </table>

                ';
        
        $datos_tipo_documento=$this->obCon->DevuelveValores("cod_documentos","Codigo",$DatosCliente["Tipo_Documento"]);
        
        
        if($DatosCliente["Tipo_Documento"]==31){
            $tercero_identificacion=$DatosCliente["Num_Identificacion"].' - '.$DatosCliente["DV"];
            $tipo_contribuyente="Jurídica";
            $regimen_contable="Responsable de IVA";
        }else{
            $tercero_identificacion=$DatosCliente["Num_Identificacion"];
            $tipo_contribuyente="Natural y asimiladas";
            $regimen_contable="No Responsable de IVA";
        }
        if($DatosCliente["TipoOrganizacion"]==1){
            $tipo_contribuyente="Jurídica";
        }
        if($DatosCliente["TipoOrganizacion"]==2){
            $tipo_contribuyente="Natural y asimiladas";
        }
        $tbl .= '<br><br>
                <table cellspacing="0" cellpadding="2" border="1">
                    <tr>
                        <td width="70px"><strong>Adquiriente:</strong></td>
                        <td width="300px">'.$DatosCliente["RazonSocial"].'</td>
                        <td width="120px"><strong>'.utf8_encode($datos_tipo_documento["Descripcion"]).':</strong></td>
                        <td width="160px">'.$tercero_identificacion.'</td>
                            
                    </tr>
                    
                    <tr>
                        <td><strong>Dirección:</strong></td>
                        <td>'.$DatosCliente["Direccion"].'</td>
                            
                        <td><strong>Ciudad:</strong></td>
                        <td>'.$DatosCliente["Ciudad"].'</td>
                        
                    </tr>
                    <tr>
                        <td><strong>País:</strong></td>
                        <td>Colombia</td>
                            
                        <td><strong>Departamento:</strong></td>
                        <td>'.utf8_encode($datos_departamento["Nombre"]).'</td>
                        
                    </tr>
                    
                    <tr>
                        <td><strong>Teléfono:</strong></td>
                        <td>'.$DatosCliente["Telefono"].'</td>
                            
                        <td><strong>Correo:</strong></td>
                        <td>'.$DatosCliente["Email"].'</td>
                        
                    </tr>
                    
                    <tr>
                        <td><strong>Persona:</strong></td>                        
                        <td>'.$tipo_contribuyente.'</td>
                        <td><strong>Régimen Contable:</strong></td>
                        <td>'.$regimen_contable.'</td>
                    </tr>
                    
                </table>

                ';

        $this->PDF->writeHTML($tbl, true, false, false, false, '');
           
    }
    
    /**
     * Arme HTML de los Items de una Factura
     * @param type $idFactura
     * @return type
     */
    public function HTML_Items_Factura($idFactura) {
        $tbl = '
        <table cellspacing="1" cellpadding="2" border="0">
            <tr>
                <td align="center" width="30px" ><strong>No</strong></td>
                <td align="center" width="60px" ><strong>Referencia</strong></td>
                <td align="center" colspan="3"><strong>Producto o Servicio</strong></td>
                <td align="center" ><strong>Precio Unitario</strong></td>
                <td align="center" ><strong>Cantidad</strong></td>
                <td align="center" width="30px" ><strong>U/M</strong></td>
                <td align="center" width="100px" ><strong>IVA</strong></td>
                <td align="center" width="30px" ><strong>ICA</strong></td>
                <td align="center" width="100px" ><strong>INC</strong></td>
                <td align="center" ><strong>Valor Venta Item</strong></td>
            </tr>


        ';

        $sql="SELECT fi.Dias, fi.Referencia,fi.IVAItem,fi.ValorOtrosImpuestos, fi.Nombre, fi.ValorUnitarioItem, fi.Cantidad, fi.SubtotalItem"
                . " FROM facturas_items fi WHERE fi.idFactura='$idFactura'";
        $Consulta= $this->obCon->Query($sql);
        $h=1;  
        $i=0;
        while($DatosItemFactura=$this->obCon->FetchArray($Consulta)){
            $ValorUnitario=  number_format($DatosItemFactura["ValorUnitarioItem"]);
            $SubTotalItem=  number_format($DatosItemFactura["SubtotalItem"]);
            $Multiplicador=$DatosItemFactura["Cantidad"];
            $i=$i+1;
            if($DatosItemFactura["Dias"]>1){
                $Multiplicador="$DatosItemFactura[Cantidad] X $DatosItemFactura[Dias]";
            }
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            }

            $tbl .=' 

            <tr>
                <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$i.'</td>
                <td align="left" style="font-size:8px;border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$DatosItemFactura["Referencia"].'</td>
                <td align="left" colspan="3" style="font-size:8px;border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$DatosItemFactura["Nombre"].'</td>
                <td align="right" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$ValorUnitario.'</td>
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$Multiplicador.'</td>
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">EA</td>   
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($DatosItemFactura["IVAItem"]).'</td>
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">0</td>
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($DatosItemFactura["ValorOtrosImpuestos"]).'</td>
                <td align="right" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$SubTotalItem.'</td>
            </tr>




        ';

        }

        $tbl .='</table>';

        return($tbl);

    }
    
    
    /**
     * Totales de la factura
     * @param type $idFactura
     * @param type $ObservacionesFactura
     * @param type $ObservacionesLegales
     * @return string
     */
    public function HTML_Totales_Factura($idFactura,$ObservacionesFactura,$ObservacionesLegales) {
        $sql="SELECT SUM(ValorOtrosImpuestos) as ValorOtrosImpuestos,SUM(SubtotalItem) as Subtotal, SUM(IVAItem) as IVA, SUM(TotalItem) as Total, PorcentajeIVA FROM facturas_items "
                . " WHERE idFactura='$idFactura' GROUP BY PorcentajeIVA";
        $Consulta=$this->obCon->Query($sql);
        $SubtotalFactura=0;
        $TotalFactura=0;
        $TotalIVAFactura=0;
        $OtrosImpuestos=0;
        //print($ObservacionesLegales);
        $ObservacionesFactura= utf8_encode($ObservacionesFactura);
        while($TotalesFactura= $this->obCon->FetchArray($Consulta)){
            
            $OtrosImpuestos=$OtrosImpuestos+$TotalesFactura["ValorOtrosImpuestos"];
            $SubtotalFactura=$SubtotalFactura+$TotalesFactura["Subtotal"];
            $TotalFactura=$TotalFactura+$TotalesFactura["Total"];
            $TotalIVAFactura=$TotalIVAFactura+$TotalesFactura["IVA"];
            $PorcentajeIVA=$TotalesFactura["PorcentajeIVA"];
            
            $TiposIVA[$PorcentajeIVA]=$TotalesFactura["PorcentajeIVA"];
            $IVA[$PorcentajeIVA]["Valor"]=$TotalesFactura["IVA"];
            $Bases[$PorcentajeIVA]["Valor"]=$TotalesFactura["Subtotal"];
        }
        
        $sql="SELECT SUM(Valor) as Anticipos FROM facturas_anticipos WHERE idFactura='$idFactura' ";
        $DatosAnticipos= $this->obCon->FetchAssoc($this->obCon->Query($sql));
        if($DatosAnticipos["Anticipos"]>0){
            $ObservacionesFactura.=$ObservacionesFactura." || Anticipos Cruzados: ".number_format($DatosAnticipos["Anticipos"]);
        }
    $tbl = '
        <table cellspacing="1" cellpadding="2" border="1">
        <tr>
            <td height="25" width="435" style="border-bottom: 1px solid #ddd;background-color: white;">Observaciones: '.$ObservacionesFactura.'</td> 

            
            <td align="rigth" width="217" style="border-bottom: 1px solid #ddd;background-color: white;"><strong>SUBTOTAL: $ '.number_format($SubtotalFactura).'</strong></td>
        </tr>
        </table> 
        ';
        
        $NumIvas=count($TiposIVA);
        
            $ReferenciaIVA="TOTAL IVA ";
            $tbl.='<table cellspacing="1" cellpadding="2" border="1">'
                . ' <tr>';
                      
            
            foreach($TiposIVA as $PorcentajeIVA){
                
                if(isset($Bases[$PorcentajeIVA]["Valor"])){
                    $tbl.='<td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><strong>Base '.$PorcentajeIVA.': $ '.number_format($Bases[$PorcentajeIVA]["Valor"]).'</strong></td>';

                }
                if(isset($IVA[$PorcentajeIVA]["Valor"])){

                   $tbl.='<td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><strong>IVA '.$PorcentajeIVA.': $ '.number_format($IVA[$PorcentajeIVA]["Valor"]).'</strong></td>';

                }
                
            }
            if($OtrosImpuestos>0){
                $tbl.='<td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><strong>Impoconsumo: $ '.number_format($OtrosImpuestos).'</strong></td>';

            }
        
        $tbl.='</tr></table>';
    
    
    $tbl.= '
        <table cellspacing="1" cellpadding="2" border="1">
        <tr>
            <td height="25" width="435" style="border-bottom: 1px solid #ddd;background-color: white;">'.utf8_encode($ObservacionesLegales).'</td> 
            <td align="rigth" width="217" style="border-bottom: 1px solid #ddd;background-color: white;"><strong>Total Impuestos: $ '.number_format($TotalIVAFactura+$OtrosImpuestos).'</strong></td>
        </tr>
        </table> 
        ';
    $tbl.='<table cellspacing="1" cellpadding="2" border="1"> <tr>
        
        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><strong>TOTAL: $ '.number_format($TotalFactura+$OtrosImpuestos).'</strong></td>
    </tr>
     
</table>';
    
    return $tbl;
    }
    
    /**
     * Fin Clase
     */
}
