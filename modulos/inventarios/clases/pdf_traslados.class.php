<?php

if(file_exists("../../../general/clases/ClasesPDFDocumentos.class.php")){
    include_once("../../../general/clases/ClasesPDFDocumentos.class.php");
}

class PDF_Traslados extends Documento{
      
    
    public function pdf_traslado($traslado_id) {
        
        $DatosEmpresaPro=$this->obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
        $datos_traslado=$this->obCon->DevuelveValores("traslados_mercancia", "ID", $traslado_id);
        
        $this->PDF_Ini("Informe de Inteligencia de Negocio", 8, "",1,"../../../");
        
        $idFormato=17;
        $DatosFormatoCalidad=$this->obCon->DevuelveValores("formatos_calidad", "ID", $idFormato);
        $DatosFormatoCalidad["Nombre"]= utf8_encode($DatosFormatoCalidad["Nombre"]);
        $nombre_formato="TRASLADO $traslado_id";
        $this->PDF_Encabezado($datos_traslado["Fecha"],1, $idFormato, "",$nombre_formato,"../../../");
        
        $this->pdf_traslado_encabezado($datos_traslado);
        $this->traslado_items($traslado_id);
        $this->PDF_Output("traslado_$traslado_id".".pdf");
    }
    
    public function pdf_traslado_encabezado($datos_traslado) {
        $DatosSucursalOrigen=$this->obCon->DevuelveValores("empresa_pro_sucursales","ID",$datos_traslado["Origen"]);
        $DatosSucursalDestino=$this->obCon->DevuelveValores("empresa_pro_sucursales","ID",$datos_traslado["Destino"]);
        $tbl = <<<EOD
      
        <table cellpadding="1" border="1">
            <tr>
                <td><strong>ORIGEN:</strong></td>
                <td colspan="2">$DatosSucursalOrigen[Nombre]</td>

            </tr>
            <tr>
                <td><strong>DESTINO:</strong></td>
                <td colspan="2">$DatosSucursalDestino[Nombre]</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Dirección:</strong></td>
                <td><strong>Ciudad:</strong></td>

            </tr>
            <tr>
                <td colspan="2">$DatosSucursalDestino[Direccion]</td>
                <td>$DatosSucursalDestino[Ciudad]</td>

            </tr>
            <tr>
                <td colspan="2"><strong>Fecha: </strong></td>
                <td colspan="1">$datos_traslado[Fecha]</td>
            </tr>

        </table>       
EOD;

        $this->PDF->MultiCell(95, 25, $tbl, 0, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');
        $observaciones= utf8_decode($datos_traslado['Descripcion']);
        $usuario= ($datos_traslado['Abre']);
        $tbl = <<<EOD

        <table cellpadding="1" border="1">
            <tr>
                <td colspan="3"><strong>Descripcion:</strong></td>


            </tr>
            <tr>
                <td colspan="3" height="36">$observaciones</td>

            </tr>
            <tr>
                <td colspan="3"><strong>Usuario:</strong> $usuario</td>

            </tr>


        </table>       
EOD;

        $this->PDF->MultiCell(90, 25, $tbl, 0, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');
    }
    
    
    public function traslado_items($idTraslado) {
        $obVenta=new ProcesoVenta(1);
        $this->PDF->writeHTML("<br>", true, false, false, false, '');
        $tbl = <<<EOD
            <table cellspacing="1" cellpadding="2" border="0">
                <tr>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Ref</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>CodBar</strong></td>
                    <td align="center" colspan="2" style="border-bottom: 2px solid #ddd;"><strong>Producto</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Costo</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Cant</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Total</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Dpto</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Sub1</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Sub2</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Sub3</strong></td>

                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>PUC</strong></td>
                    <td align="center" style="border-bottom: 2px solid #ddd;"><strong>Ver</strong></td>
                </tr>
    
         
EOD;

        $sql="SELECT * FROM traslados_items WHERE idTraslado='$idTraslado' AND Deleted='0000-00-00 00:00:00' ";
        $Consulta=$obVenta->Query($sql);
        $h=1;  
        $SubtotalCosto=0;
 
        while($DatosItemTraslado=$obVenta->FetchArray($Consulta)){
            $SubtotalCosto=$SubtotalCosto+($DatosItemTraslado["CostoUnitario"]*$DatosItemTraslado["Cantidad"]);

            $CostoUnitario=  number_format($DatosItemTraslado["CostoUnitario"]);
            $SubTotalItem=  number_format($DatosItemTraslado["CostoUnitario"]*$DatosItemTraslado["Cantidad"]);
            $NombreProducto= utf8_encode($DatosItemTraslado["Nombre"]);
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            }
            $tbl .= <<<EOD

            <tr>
                <td align="left" style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosItemTraslado[Referencia]</td>
                <td align="right"  style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosItemTraslado[CodigoBarras]</td>
                <td align="center" colspan="2" style="border-bottom: 1px solid #ddd;background-color: $Back;">$NombreProducto</td>
                <td align="right" style="border-bottom: 1px solid #ddd;background-color: $Back;">$CostoUnitario</td>
                <td align="right" style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosItemTraslado[Cantidad]</td>
                <td align="right" style="border-bottom: 1px solid #ddd;background-color: $Back;">$SubTotalItem</td>
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosItemTraslado[Departamento]</td>
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosItemTraslado[Sub1]</td>
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosItemTraslado[Sub2]</td>
                <td align="center" style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosItemTraslado[Sub3]</td>

                <td align="right" style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosItemTraslado[CuentaPUC]</td>
                    <td align="center" style="border-bottom: 1px solid #ddd;background-color: $Back;">[__]</td>
            </tr>
    
     
    
        
EOD;
    
        }

        $tbl .= <<<EOD
                </table>
EOD;

        $this->PDF->MultiCell(184, 160, $tbl, 1, 'C', 1, 0, '', '', true,1, true, true, 10, 'M');
        $this->PDF->writeHTML("<br><br>", true, false, false, false, '');


        ////Totales de la cotizacion
        ////
        ////

        $Subtotal=number_format($SubtotalCosto);

        //$TotalLetras=numtoletras($TotalFactura, "PESOS COLOMBIANOS");


        $tbl = <<<EOD

        <table  cellpadding="2" border="0">
            <tr>
                <td height="25" colspan="4" style="border-bottom: 1px solid #ddd;background-color: white;"></td> 

                <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><h3>TOTAL COSTO:</h3></td>
                <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><h3>$ $Subtotal</h3></td>
            </tr>
            <tr>
                <td colspan="4" height="25" border="1" style="border-bottom: 1px solid #ddd;background-color: white;">Observaciones:</td> 
                <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><h3></h3></td>
                <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><h3></h3></td>
            </tr>
            <tr>
                <td colspan="2" height="50" align="center" style="border-bottom: 1px solid #ddd;background-color: white;"><br/><br/><br/><br/><br/>Firma Responsable: ________________</td> 
                <td colspan="2" height="50" align="center" style="border-bottom: 1px solid #ddd;background-color: white;"><br/><br/><br/><br/><br/>Firma Verificado:  ________________</td> 
                <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><h3></h3></td>
                <td align="rigth" style="border-bottom: 1px solid #ddd;background-color: white;"><h3></h3></td>
            </tr>

        </table>

        
EOD;

        $this->PDF->MultiCell(184, 30, $tbl, 1, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');
           
    }
    
    
    
    /**
     * Fin Clase
     */
}
