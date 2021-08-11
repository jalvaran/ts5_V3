<?php

if(file_exists("../../../general/clases/ClasesPDFDocumentos.class.php")){
    include_once("../../../general/clases/ClasesPDFDocumentos.class.php");
}

class PDF_Comercial extends Documento{
    
    public function PDF_ComprobanteIngresoPOS($comprobante_id) {
        $obCon=new ProcesoVenta(1);
        $tamano_papel["ancho"]=80;
        $tamano_papel["alto"]=100;
        $this->PDF_Ini("Estado de Resultados", 8, $tamano_papel,1,"../../../");
        $datos_comprobante=$obCon->DevuelveValores("comprobantes_ingreso", "ID", $comprobante_id);
        $datos_empresa=$obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
        $datos_tercero=$obCon->DevuelveValores("clientes", "Num_Identificacion", $datos_comprobante["Tercero"]);
        $datos_usuario=$obCon->DevuelveValores("usuarios", "idUsuarios", $datos_comprobante["Usuarios_idUsuarios"]);
        $html= "<h2>".$datos_empresa["RazonSocial"]."</h2><br>";
        $html.= "<h4>".$datos_empresa["Telefono"]."</h4><br>";
        $html.= "<h4>Comprobante de Ingreso No. $comprobante_id</h4><br>";
        $html.= "<h3>Fecha y Hora: <strong>".$datos_comprobante["Created"]."</strong></h3><br>";
        $html.= "<h3>Tercero: <strong>".$datos_tercero["RazonSocial"]." ".$datos_tercero["Num_Identificacion"]."</strong></h3><br>";
        $html.= "<h3>Valor Pagado: <strong>$".number_format($datos_comprobante["Valor"])."</strong></h3><br><br><br>";
        
        $html.= "<h3>Recibe: <strong>".$datos_usuario["Nombre"]." ".$datos_usuario["Apellido"]."</strong></h3>";
        $this->PDF_Write($html);
             
        $this->PDF_Output("Comprobante_Ingreso_$comprobante_id");
    }
    
    public function PDF_cierre_turno($cierre_id) {
        $obCon=new ProcesoVenta(1);
        $idEmpresaEncabezado=1;
        $datos_cierre=$obCon->DevuelveValores("cajas_aperturas_cierres", "ID", $cierre_id);
        $DatosUsuario=$obCon->DevuelveValores("usuarios", "idUsuarios", $datos_cierre["Usuario"]);
        $idUsuario=$DatosUsuario["idUsuarios"];
        $FechaReporte=$datos_cierre["Fecha"];
        
        
        $this->PDF_Ini("Cierre de Turno", 8, "",1,"../../../");
        $this->PDF_Encabezado($FechaReporte,$idEmpresaEncabezado, 45, "","","../../../");        
        $html="REPORTE DE CIERRE DEL $FechaReporte POR EL USUARIO: ".$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"];
        
        $this->PDF_Write($html);
        
        $html= $this->html_cierre_devoluciones($cierre_id);
        if($html<>''){
            $this->PDF_Write($html);
        }
        
        $html= $this->html_cierre_descuentos($cierre_id);
        if($html<>''){
            $this->PDF_Write($html);
        }
        $html= $this->html_cierre_ventas_general($datos_cierre);
        $this->PDF_Write($html);
        
        $html= $this->html_cierre_formas_pago_acuerdos($cierre_id);
        if($html<>''){
            $this->PDF_Write($html);
        }
        
        $html= $this->html_cierre_anticipos($cierre_id);
        if($html<>''){
            $this->PDF_Write($html);
        }
        
        $html= $this->html_cierre_egresos($cierre_id);
        if($html<>''){
            $this->PDF_Write($html);
        }
        
        $html= $this->html_cierre_saldos_finales($datos_cierre);
        if($html<>''){
            $this->PDF_Write($html);
        }
        
        $this->PDF_Output("Cierre_Turno_$cierre_id");
    }
    
    public function html_cierre_saldos_finales($DatosCierre) {
        $idCierre=$DatosCierre["ID"];
        $obCon=new ProcesoVenta(1);
        $sql="SELECT SUM(Valor) as Total_efectivo FROM comercial_plataformas_pago_ingresos WHERE idPlataformaPago=1 AND metodo_pago_id=1 AND idCierre='$idCierre'";
        $TotalesSisteCredito=$obCon->FetchAssoc($obCon->Query($sql));
        $total_ingresos_siste_efectivo=$TotalesSisteCredito["Total_efectivo"];
        $sql="SELECT SUM(Valor) as Total_no_efectivo FROM comercial_plataformas_pago_ingresos WHERE idPlataformaPago=1 AND metodo_pago_id<>1 AND idCierre='$idCierre'";
        $TotalesSisteCredito=$obCon->FetchAssoc($obCon->Query($sql));
        $total_ingresos_siste_no_efectivo=$TotalesSisteCredito["Total_no_efectivo"];
	
        $sql="SELECT SUM(Valor) as Abono, TipoPagoAbono FROM facturas_abonos WHERE idCierre='$idCierre' GROUP BY TipoPagoAbono ";
        $ConsultaAbonos=$obCon->Query($sql);
        $AbonosCreditoEfectivo=0;
        $AbonosCreditoTarjeta=0;
        $AbonosCreditoCheque=0;
        $AbonosCreditoOtros=0;
        while ($DatosAbonos=$obCon->FetchArray($ConsultaAbonos)){
            if($DatosAbonos["TipoPagoAbono"]==""){
                $AbonosCreditoEfectivo=$AbonosCreditoEfectivo+$DatosAbonos["Abono"];
            }
            if($DatosAbonos["TipoPagoAbono"]=="Tarjetas"){
                $AbonosCreditoTarjeta=$AbonosCreditoTarjeta+$DatosAbonos["Abono"];
            }
            if($DatosAbonos["TipoPagoAbono"]=="Cheques"){
                $AbonosCreditoCheque=$AbonosCreditoCheque+$DatosAbonos["Abono"];
            }
            if($DatosAbonos["TipoPagoAbono"]=="Bonos"){
                $AbonosCreditoOtros=$AbonosCreditoOtros+$DatosAbonos["Abono"];
            }
        }
        $TotalInteresesSisteCredito=$obCon->Sume("facturas_intereses_sistecredito", "Valor", "WHERE idCierre='$idCierre'");
     
        
        $html='';
        
        $total=0;
        $h=0;
        $titulo=1;
        
        $html='   
            <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                <tr align="center">
                    <td colspan="2"><strong>SALDOS FINALES DEL CIERRE</strong></td>

                </tr>
                <tr align="center">
                    <td><strong>ITEM</strong></td>   
                    <td><strong>TOTAL</strong></td>
                </tr>';
        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS SEPARADOS</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalAbonosSeparados"]).'</strong></td>
                </tr>';
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS CREDITO EFECTIVO</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($AbonosCreditoEfectivo).'</strong></td>
                </tr>';

        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS CREDITO TARJETAS</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($AbonosCreditoTarjeta).'</strong></td>
                </tr>';
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS CREDITO CHEQUES</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($AbonosCreditoCheque).'</strong></td>
                </tr>';
        
        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS CREDITO BONOS </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($AbonosCreditoOtros).'</strong></td>
                </tr>';
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS SISTECREDITO EFECTIVO</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($total_ingresos_siste_efectivo).'</strong></td>
                </tr>';
        
        $Back="#f2f2f2";
        
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS SISTECREDITO NO EFECTIVO</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($total_ingresos_siste_no_efectivo).'</strong></td>
                </tr>';
        
        
        $sql="SELECT SUM(ValorPago) as Total FROM acuerdo_pago_cuotas_pagadas WHERE idCierre='$idCierre' AND MetodoPago=1 AND Estado<10";
        $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
        $AbonosAcuerdoEfectivo=$DatosPagosAcuerdo["Total"];

        $sql="SELECT SUM(ValorPago) as Total FROM acuerdo_pago_cuotas_pagadas WHERE idCierre='$idCierre' AND MetodoPago<>1 AND Estado<10";
        $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
        $AbonosAcuerdoOtrosMetodos=$DatosPagosAcuerdo["Total"];
        if($AbonosAcuerdoEfectivo>0 or $AbonosAcuerdoOtrosMetodos>0){
            $Back="white";
            $html.=' <tr >
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS ACUERDOS EFECTIVO</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($AbonosAcuerdoEfectivo).'</strong></td>
                    </tr>';

            $Back="#f2f2f2";

            $html.=' <tr >
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS ACUERDOS NO EFECTIVO</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($AbonosAcuerdoOtrosMetodos).'</strong></td>
                    </tr>';
        }
        
        $sql="SELECT SUM(ValorRecargoInteres) as Total FROM acuerdo_recargos_intereses WHERE idCierre='$idCierre' AND MetodoPago=1";
        $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
        $InteresesAcuerdoEfectivo=$DatosPagosAcuerdo["Total"];

        $sql="SELECT SUM(ValorRecargoInteres) as Total FROM acuerdo_recargos_intereses WHERE idCierre='$idCierre' AND MetodoPago<>1";
        $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
        $InteresesAcuerdoOtrosMetodos=$DatosPagosAcuerdo["Total"];

        if($InteresesAcuerdoEfectivo>0 or $InteresesAcuerdoOtrosMetodos>0){
            $Back="white";
            $html.=' <tr >
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>INTERESES ACUERDOS EFECTIVO</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($InteresesAcuerdoEfectivo).'</strong></td>
                    </tr>';

            $Back="#f2f2f2";

            $html.=' <tr >
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>INTERESES ACUERDOS NO EFECTIVO</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($InteresesAcuerdoOtrosMetodos).'</strong></td>
                    </tr>';
        }
    
        $sql="SELECT SUM(Valor) as Total FROM anticipos_encargos_abonos WHERE idCierre='$idCierre' AND Metodo=1";
        $DatosPagosAnticiposEncargos= $obCon->FetchAssoc($obCon->Query($sql));
        $AbonosAnticiposEncargosEfectivo=$DatosPagosAnticiposEncargos["Total"];

        $sql="SELECT SUM(Valor) as Total FROM anticipos_encargos_abonos WHERE idCierre='$idCierre' AND Metodo<>1";
        $DatosPagosAcuerdo= $obCon->FetchAssoc($obCon->Query($sql));
        $AbonosAnticiposEncargosOtrosMetodos=$DatosPagosAcuerdo["Total"];

        if($AbonosAnticiposEncargosEfectivo>0 or $AbonosAnticiposEncargosOtrosMetodos>0){
            
            $Back="white";
            $html.=' <tr >
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS ANTICIPOS EFECTIVO</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($AbonosAnticiposEncargosEfectivo).'</strong></td>
                    </tr>';

            $Back="#f2f2f2";

            $html.=' <tr >
                        <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ABONOS ANTICIPOS NO EFECTIVO</strong></td>   
                        <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($AbonosAnticiposEncargosOtrosMetodos).'</strong></td>
                    </tr>';

        }
    
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>INTERESES SISTECREDITO</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalInteresesSisteCredito).'</strong></td>
                </tr>';
        
        
        $TotalAnticiposRecibidos=$obCon->Sume("comprobantes_ingreso", "Valor", "WHERE idCierre='$idCierre' AND Estado='ABIERTO' AND Tipo='ANTICIPO'");
        $TotalAnticiposCruzados=$obCon->Sume("comprobantes_ingreso", "Valor", "WHERE idCierre='$idCierre' AND Estado='CERRADO' AND Tipo='ANTICIPO'");

        if($TotalAnticiposRecibidos>0){
            
            $Back="#f2f2f2";
            $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ANTICIPOS RECIBIDOS </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalAnticiposRecibidos).'</strong></td>
                </tr>';
        }
        if($TotalAnticiposCruzados>0){
            
            $Back="#f2f2f2";
            $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>ANTICIPOS CRUZADOS </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalAnticiposCruzados).'</strong></td>
                </tr>';
        }
        
        
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>EGRESOS</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalEgresos"]).'</strong></td>
                </tr>';
        
        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL TARJETAS </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalTarjetas"]).'</strong></td>
                </tr>';
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL CONSIGNACIONES</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalCheques"]).'</strong></td>
                </tr>';
        
        $Back="#f2f2f2";
        
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL OTROS</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalOtros"]).'</strong></td>
                </tr>';
        
        $TotalOtrosImpuestos=$obCon->Sume("facturas_items", "ValorOtrosImpuestos", "WHERE idCierre='$idCierre'");
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL OTROS IMPUESTOS</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalOtrosImpuestos).'</strong></td>
                </tr>';
            
        $Parametros= $obCon->DevuelveValores("configuracion_general", "ID", 35);//Se Valida si las facturas negativas se devulven al cliente o no
        $TotalFacturasNegativas=0;   
        if($Parametros["Valor"]=="1"){
            $TotalFacturasNegativas=$obCon->Sume("facturas", "Total", "WHERE CerradoDiario='$idCierre' AND Total<0");
            $TotalFacturasNegativas=ABS($TotalFacturasNegativas);
        }
        
        
        $sql="SELECT SUM(Debito) as total_cruce_anticipos FROM librodiario 
                WHERE Tipo_Documento_Intero='FACTURA' AND idCierre='$idCierre' AND Debito>0 AND CuentaPUC=(SELECT CuentaPUC from parametros_contables WHERE ID=20)";
      
        $datos_consulta=$obCon->FetchArray($obCon->Query($sql));
        $total_cruce_anticipos=$datos_consulta["total_cruce_anticipos"];
        $total_entrega_cierre=$DatosCierre["TotalEntrega"]+$TotalOtrosImpuestos+$TotalInteresesSisteCredito+$TotalAnticiposRecibidos-$total_cruce_anticipos+$AbonosAcuerdoOtrosMetodos+$TotalFacturasNegativas+$InteresesAcuerdoEfectivo+$InteresesAcuerdoOtrosMetodos+$AbonosAnticiposEncargosEfectivo+$AbonosAnticiposEncargosOtrosMetodos;
        
        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL ENTREGA</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($total_entrega_cierre).'</strong></td>
                </tr>';
        
        
        $SaldoEnCaja=$DatosCierre["TotalEfectivo"]+$TotalOtrosImpuestos+$TotalInteresesSisteCredito+$TotalAnticiposRecibidos-$total_cruce_anticipos+$TotalFacturasNegativas+$InteresesAcuerdoEfectivo+$InteresesAcuerdoOtrosMetodos+$AbonosAnticiposEncargosEfectivo-$total_ingresos_siste_no_efectivo;
        $Diferencia=$DatosCierre["EfectivoRecaudado"]-$SaldoEnCaja;
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>EFECTIVO EN CAJA</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["EfectivoRecaudado"]).'</strong></td>
                </tr>';
        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>SALDO EN CAJA </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($SaldoEnCaja).'</strong></td>
                </tr>';
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>DIFERENCIA </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($Diferencia).'</strong></td>
                </tr>';
        
        
        $html.='</table><BR><BR>';
        return($html);
        
    }
    
    public function html_cierre_egresos($cierre_id) {
        $obCon=new ProcesoVenta(1);
        
        $sql="SELECT * FROM librodiario 
                WHERE Tipo_Documento_Intero='CompEgreso' AND idCierre='$cierre_id' AND Debito>0";
        
        $Consulta=$obCon->Query($sql);
	
        $html='';
        
        $total=0;
        $h=0;
        $titulo=1;
        $entra=0;
        while($datos_consulta=$this->obCon->FetchArray($Consulta)){
            $entra=1;
            if($titulo==1){
                $html='   
                    <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                        <tr align="center">
                            <td colspan="2"><strong>EGRESOS</strong></td>
                                                       
                        </tr>
                        <tr align="center">
                            <td><strong>Concepto</strong></td>   
                            
                            <td><strong>Valor</strong></td>
                                                        
                        </tr>


                ';
                $titulo=0;
            }
            $Titulo="Egreso ".$datos_consulta["Num_Documento_Interno"]." ".$datos_consulta["Concepto"];
            $total=$total+$datos_consulta["Debito"];
            
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            } 
            
            $html.= '  
            
                <tr align="left">
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$Titulo.'</td>
                    
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($datos_consulta["Debito"]).'</td>
                    
                </tr>

            
            ';

        }
        if($entra==1){
            $Back='#F7F8E0';
            $html.='<tr > '
                    . '<td align="rigth" colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">Total:</td>'
                    .' <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($total).'</td>' 

                   .'</tr>';
            $html.='</table><BR><BR>';
        }
        
        return($html);
        
    }
    
    
    public function html_cierre_anticipos($idCierre) {
        $obCon=new ProcesoVenta(1);
        
        $sql="SELECT SUM(t1.Valor) as Total,(SELECT Metodo FROM metodos_pago t2 WHERE t1.Metodo=t2.ID) as MetodoPago  FROM anticipos_encargos_abonos t1 WHERE idCierre='$idCierre' GROUP BY Metodo";
      
        $Consulta=$obCon->Query($sql);
	
        $html='';
        
        $total=0;
        $h=0;
        $titulo=1;
        $entra=0;
        while($datos_consulta=$this->obCon->FetchArray($Consulta)){
            $entra=1;
            if($titulo==1){
                $html='   
                    <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                        <tr align="center">
                            <td colspan="2"><strong>ANTICIPOS POR ENCARGOS</strong></td>
                                                       
                        </tr>
                        <tr align="center">
                            
                            <td><strong>Metodo</strong></td>   
                            <td><strong>Valor</strong></td>
                                                        
                        </tr>


                ';
                $titulo=0;
            }
            
            $total=$total+$datos_consulta["Total"];
            
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            } 
            
            $html.= '  
            
                <tr align="left">
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["MetodoPago"].'</td>
                    
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($datos_consulta["Total"]).'</td>
                    
                </tr>

            
            ';

        }
        if($entra==1){
            $Back='#F7F8E0';
            $html.='<tr > '
                    . '<td align="rigth" colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">Total:</td>'
                    .' <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($total).'</td>' 

                   .'</tr>';
            $html.='</table><BR><BR>';
        }
        
        
        
        $sql="SELECT * FROM librodiario 
                WHERE Tipo_Documento_Intero='FACTURA' AND idCierre='$idCierre' AND Debito>0 AND CuentaPUC=(SELECT CuentaPUC from parametros_contables WHERE ID=20)";
      
        $Consulta=$obCon->Query($sql);
        
        
        $total=0;
        $h=0;
        $titulo=1;
        $entra=0;
        while($datos_consulta=$this->obCon->FetchArray($Consulta)){
            $entra=1;
            if($titulo==1){
                
                $html.='   
                    <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                        <tr align="center">
                            <td colspan="2"><strong>CRUCE DE ANTICIPOS POR ENCARGOS</strong></td>
                                                       
                        </tr>
                        <tr align="center">
                            
                            <td><strong>Factura</strong></td>   
                            <td><strong>Valor</strong></td>
                                                        
                        </tr>


                ';
                $titulo=0;
            }
            
            $total=$total+$datos_consulta["Debito"];
            
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            } 
            $Titulo="Factura ".$datos_consulta["Num_Documento_Externo"];
            $html.= '  
            
                <tr align="left">
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$Titulo.'</td>
                    
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($datos_consulta["Debito"]).'</td>
                    
                </tr>

            
            ';

        }
        if($entra==1){
            $Back='#F7F8E0';
            $html.='<tr > '
                    . '<td align="rigth" colspan="1" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">Total:</td>'
                    .' <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($total).'</td>' 

                   .'</tr>';
            $html.='</table><BR><BR>';
        }
        
        
        return($html);
        
    }
    
    public function html_cierre_formas_pago_acuerdos($cierre_id) {
        $obCon=new ProcesoVenta(1);
        
        $sql="SELECT SUM(t1.`ValorPago`) as TotalAbono,MetodoPago,TipoCuota,
                (SELECT NombreTipoCuota FROM acuerdo_pago_tipo_cuota t3 WHERE t1.TipoCuota=t3.ID) as NombreTipoCuota,
                (SELECT Metodo FROM metodos_pago t2 WHERE t1.MetodoPago=t2.ID) as Metodo 
                FROM `acuerdo_pago_cuotas_pagadas` t1
                WHERE `idCierre` = '$cierre_id' AND t1.Estado<10 GROUP BY t1.MetodoPago,t1.TipoCuota ORDER BY MetodoPago,TipoCuota ";
        
        $Consulta=$obCon->Query($sql);
	
        $html='';
        
        $total=0;
        $h=0;
        $titulo=1;
        $entra=0;
        while($datos_consulta=$this->obCon->FetchArray($Consulta)){
            $entra=1;
            if($titulo==1){
                $html='   
                    <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                        <tr align="center">
                            <td colspan="3"><strong>FORMAS DE PAGO EN ACUERDOS</strong></td>
                                                       
                        </tr>
                        <tr align="center">
                            <td><strong>Tipo de Cuota</strong></td>   
                            <td><strong>Metodo</strong></td>   
                            <td><strong>Valor</strong></td>
                                                        
                        </tr>


                ';
                $titulo=0;
            }
            
            $total=$total+$datos_consulta["TotalAbono"];
            
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            } 
            
            $html.= '  
            
                <tr align="left">
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["NombreTipoCuota"].'</td>
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Metodo"].'</td>
                    
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($datos_consulta["TotalAbono"]).'</td>
                    
                </tr>

            
            ';

        }
        if($entra==1){
            $Back='#F7F8E0';
            $html.='<tr > '
                    . '<td align="rigth" colspan="2" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">Total:</td>'
                    .' <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($total).'</td>' 

                   .'</tr>';
            $html.='</table><BR><BR>';
        }
        
        return($html);
        
    }
    
    
    public function html_cierre_ventas_general($DatosCierre) {
        $idCierre=$DatosCierre["ID"];
        $obCon=new ProcesoVenta(1);
        $sql="SELECT SUM(Total) as Total FROM facturas WHERE CerradoDiario='$idCierre' AND Total<0";
        $DatosFacturacionNegativa=$obCon->FetchAssoc($obCon->Query($sql));
        $FacturacionNegativa=$DatosFacturacionNegativa["Total"];
	
        $html='';
        
        $total=0;
        $h=0;
        $titulo=1;
        
        $html='   
            <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                <tr align="center">
                    <td colspan="2"><strong>DATOS GENERALES</strong></td>

                </tr>
                <tr align="center">
                    <td><strong>ITEM</strong></td>   
                    <td><strong>TOTAL</strong></td>
                </tr>';
        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>FACTURACION NEGATIVA</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'.$FacturacionNegativa.'</strong></td>
                </tr>';
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL VENTAS</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalVentas"]).'</strong></td>
                </tr>';

        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL VENTAS CONTADO</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalVentasContado"]).'</strong></td>
                </tr>';
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL VENTAS CREDITO</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalVentasCredito"]).'</strong></td>
                </tr>';
        
        $Back="#f2f2f2";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>RETIROS SEPARADOS </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalRetiroSeparados"]).'</strong></td>
                </tr>';
        
        $Back="white";
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL VENTAS SISTE CREDITO</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosCierre["TotalVentasSisteCredito"]).'</strong></td>
                </tr>';
        
        $Back="#f2f2f2";
        
        $sql="SELECT SUM(Valor) as TotalIniciales FROM comercial_plataformas_pago_ingresos WHERE idPlataformaPago=1 AND Inicial=1 AND idCierre='$idCierre'";
        $DatosInicialSiste=$obCon->FetchAssoc($obCon->Query($sql));
        
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>INICIALES SISTE CREDITO </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($DatosInicialSiste["TotalIniciales"]).'</strong></td>
                </tr>';
        
        $Back="white";
        
        $sql="SELECT SUM(Total) as Total FROM cot_itemscotizaciones WHERE cierre_id='$idCierre'";
        $TotalCotizaciones=$obCon->FetchAssoc($obCon->Query($sql));
        
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TOTAL COTIZACIONES </strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalCotizaciones["Total"]).'</strong></td>
                </tr>';
        
         
        $Back="white";
      
        $html.='   
            
                <tr align="center">
                    <td colspan="2"><strong>FORMAS DE PAGO EN FACTURACION</strong></td>

                </tr>
                <tr align="center">
                    <td><strong>ITEM</strong></td>   
                    <td><strong>TOTAL</strong></td>
                </tr>';   
         
        
        $sql="SELECT SUM(Efectivo-Devuelve) as Efectivo,SUM(Cheques) as Cheques,SUM(Otros) as Otros, SUM(Tarjetas) as Tarjetas FROM facturas WHERE CerradoDiario='$idCierre'";
    
        $TotalesFormasPagoFactura=$obCon->FetchAssoc($obCon->Query($sql));
        
        $Back="#f2f2f2";        
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>EFECTIVO</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalesFormasPagoFactura["Efectivo"]).'</strong></td>
                </tr>';
        
        $Back="white";        
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>CONSIGNACIONES</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalesFormasPagoFactura["Cheques"]).'</strong></td>
                </tr>';
         
        $Back="#f2f2f2";        
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>BONOS U OTROS</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalesFormasPagoFactura["Otros"]).'</strong></td>
                </tr>';
        
        $Back="white";        
        $html.=' <tr >
                    <td align="left" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>TARJETAS</strong></td>   
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"><strong>'."$".number_format($TotalesFormasPagoFactura["Tarjetas"]).'</strong></td>
                </tr>';
        
        $html.='</table><BR><BR>';
        return($html);
        
    }
    
    public function html_cierre_descuentos($cierre_id) {
        $obCon=new ProcesoVenta(1);
        $sql = "SELECT Cantidad, ValorDescuento as Total, idProducto, (SELECT Nombre FROM productosventa t2 WHERE t2.idProductosVenta=t1.idProducto LIMIT 1) as nombre_producto"
                . " FROM pos_registro_descuentos t1 "
                . " WHERE idCierre='$cierre_id'";
	
        $consulta=$obCon->Query($sql);
	
        $html='';
        
        $total=0;
        $h=0;
        $titulo=1;
        $entra=0;
        while($datos_consulta=$this->obCon->FetchArray($consulta)){
            $entra=1;
            if($titulo==1){
                $html='   
                    <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                        <tr align="center">
                            <td colspan="4"><strong>TOTAL DESCUENTOS</strong></td>
                                                       
                        </tr>
                        <tr align="center">
                            <td><strong>ID Producto</strong></td>   
                            <td><strong>Nombre</strong></td>   
                            <td><strong>Cantidad</strong></td>
                            <td><strong>Total</strong></td>
                            
                        </tr>


                ';
                $titulo=0;
            }
            
            $total=$total+$datos_consulta["Total"];
            
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            } 
            $html.= '  
            
                <tr align="left">
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["idProducto"].'</td>
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["nombre_producto"].'</td>
                    
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Cantidad"].'</td>
                    
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($datos_consulta["Total"]).'</td>
                    
                </tr>

            
            ';

        }
        if($entra==1){
            $Back='#F7F8E0';
            $html.='<tr > '
                    . '<td align="rigth" colspan="3" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">Total:</td>'
                    .' <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($total).'</td>' 

                   .'</tr>';
            $html.='</table><BR><BR>';
        }
        
        return($html);
        
    }
    
    
    
    public function html_cierre_devoluciones($cierre_id) {
        $obCon=new ProcesoVenta(1);
        $sql = "SELECT Cantidad as Cantidad, TotalItem as Total, Referencia as Referencia,Nombre "
                . " FROM facturas_items fi "
                . " WHERE Cantidad < 0 AND idCierre='$cierre_id'";
	
        $consulta=$obCon->Query($sql);
	
        $html='';
        
        $total=0;
        $h=0;
        $titulo=1;
        $entra=0;
        while($datos_consulta=$this->obCon->FetchArray($consulta)){
            $entra=1;
            if($titulo==1){
                $html='   
                    <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                        <tr align="center">
                            <td colspan="4"><strong>TOTAL DEVOLUCIONES</strong></td>
                                                       
                        </tr>
                        <tr align="center">
                            <td><strong>Referencia</strong></td>
                            <td><strong>Nombre</strong></td>
                            <td><strong>Cantidad</strong></td>
                            <td><strong>Total</strong></td>
                            
                        </tr>


                ';
                $titulo=0;
            }
            
            $total=$total+$datos_consulta["Total"];
            
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            } 
            $html.= '  
            
                <tr align="left">
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Referencia"].'</td>
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Nombre"].'</td>
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$datos_consulta["Cantidad"].'</td>
                    
                    <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($datos_consulta["Total"]).'</td>
                    
                </tr>

            
            ';

        }
        if($entra==1){
        $Back='#F7F8E0';
        $html.='<tr > '
                . '<td align="rigth" colspan="3" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">Total:</td>'
                .' <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($total).'</td>' 
                  
               .'</tr>';
        $html.='</table><BR><BR>';
        }
        return($html);
        
    }
    
    
    /**
     * Fin Clase
     */
}
