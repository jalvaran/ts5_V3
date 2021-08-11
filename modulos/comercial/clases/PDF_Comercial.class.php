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
        $FechaReporte=$datos_cierre["Fecha"];
        
        
        $this->PDF_Ini("Cierre de Turno", 8, "",1,"../../../");
        $this->PDF_Encabezado($FechaReporte,$idEmpresaEncabezado, 45, "","","../../../");
        //$TotalClases=$this->ArmeTemporalSubCuentas($TipoReporte,$FechaFinal,$FechaInicial,$CentroCosto,$idEmpresa,$Vector);
        $html="";
        //$html= $this->HTMLEstadoResultadosDetallado($TotalClases,$FechaReporte);
        $this->PDF_Write($html);
             
        $this->PDF_Output("Cierre_Turno_$cierre_id");
    }
    
    
    /**
     * Fin Clase
     */
}
