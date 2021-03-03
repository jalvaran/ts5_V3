<?php

if(file_exists("../../../general/clases/ClasesPDFDocumentos.class.php")){
    include_once("../../../general/clases/ClasesPDFDocumentos.class.php");
}

class InformesAdmnistracion extends Documento{
    
    public function informe_admin_pdf($FechaInicial,$FechaFinal,$idEmpresa,$CentroCosto,$html ) {
        $TipoReporte="Rango";
        $idEmpresaEncabezado=$idEmpresa;
        if($idEmpresa=="ALL"){
            $idEmpresaEncabezado=1;
        }
        
        $Rango="Del $FechaInicial al $FechaFinal";
        
        $idFormato=16;
        $DatosFormatos= $this->obCon->DevuelveValores("formatos_calidad", "ID", $idFormato);
        
        $Documento="$DatosFormatos[Nombre] $Rango";
        
        $this->PDF_Ini($Documento, 8, "",1,"../../../");
        $this->PDF_Encabezado($FechaFinal,$idEmpresaEncabezado, $idFormato, "","","../../../");
        
        
        
        $this->PDF_Write($html);
             
        $this->PDF_Output("informe_admin $FechaInicial $FechaFinal");
    }
    
    //HTML Ventas discriminadas por departamentos
    public function HTML_VentasXDepartamentos($CondicionItems) {
        $html="";
        $sql="SELECT Departamento as idDepartamento,
                (SELECT Nombre FROM prod_departamentos WHERE prod_departamentos.idDepartamentos=fi.Departamento LIMIT 1) AS NombreDepartamento,
                SUM(SubtotalItem) as Subtotal,sum(SubtotalCosto) as total_costos, SUM(IVAItem) as IVA, SUM(TotalItem) as Total, SUM(Cantidad) as Items"
            . " $CondicionItems GROUP BY Departamento";
        $Datos=$this->obCon->Query($sql);
        ////print($sql);
        if($this->obCon->NumRows($Datos)){
            $html='<span style="color:RED;font-family:`Bookman Old Style`;font-size:14px;"><strong><em>Total de Ventas Discriminadas por Departamento:
            </em></strong></span><BR><BR>


            <table id="tbl_ventas_departamento" class="table table-responsive table-hover" border="1" cellspacing="2" align="center" >
              <tr> 
                <th><h3>Departamento</h3></th>
                    <th><h3>Nombre</h3></th>
                    <th><h3>Items</h3></th>
                    <th><h3>TotalCostos</h3></th>
                    <th><h3>SubTotal</h3></th>
                    <th><h3>IVA</h3></th>
                    <th><h3>Total</h3></th>
              </tr >

            ';
            $Subtotal=0;
            $TotalIVA=0;
            $TotalVentas=0;
            $TotalItems=0;
            $total_costos=0;
            $flagQuery=0;   //para indicar si hay resultados
            $i=0;
            
            while($DatosVentas= $this->obCon->FetchArray($Datos)){
                $flagQuery=1;	
                $SubtotalUser=number_format($DatosVentas["Subtotal"]);
                $TotalCostosUser=number_format($DatosVentas["total_costos"]);
                $IVA=number_format($DatosVentas["IVA"]);
                $Total=number_format($DatosVentas["Total"]);
                $Items=number_format($DatosVentas["Items"]);
                //$DatosDepartamento=$this->obCon->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosVentas["idDepartamento"]);
                $NombreDep=$DatosVentas["NombreDepartamento"];

                $Subtotal=$Subtotal+$DatosVentas["Subtotal"];
                $total_costos=$total_costos+$DatosVentas["total_costos"];
                $TotalIVA=$TotalIVA+$DatosVentas["IVA"];
                $TotalVentas=$TotalVentas+$DatosVentas["Total"];
                $TotalItems=$TotalItems+$DatosVentas["Items"];
                $idDepartamentos=$DatosVentas["idDepartamento"];
                $html.='
                            <tr>
                                <td>'.$idDepartamentos.'</td>
                                <td>'.$NombreDep.'</td>
                                <td align="right">'.$Items.'</td>
                                <td align="right">'.$TotalCostosUser.'</td>    
                                <td align="right">'.$SubtotalUser.'</td>
                                <td align="right">'.$IVA.'</td>
                                <td align="right">'.$Total.'</td>
                            </tr>
                            ';
            }
            if($flagQuery==1){
            $TotalItems=number_format($TotalItems);
            $Subtotal=number_format($Subtotal);
            $total_costos=number_format($total_costos);
            $TotalIVA=number_format($TotalIVA);
            $TotalVentas=number_format($TotalVentas);
            $html.= ' 
            
             <tr>
              <td align="right"><h3>SUMATORIA</h3></td>
              <td><h3>NA</h3></td>
              <td align="right"><h3>'.$TotalItems.'</h3></td>
              <td align="right"><h3>'.$total_costos.'</h3></td>
              <td align="right"><h3>'.$Subtotal.'</h3></td>
              <td align="right"><h3>'.$TotalIVA.'</h3></td>
              <td align="right"><h3>'.$TotalVentas.'</h3></td>
             </tr>
             
            ';
            }
        }
        $html.='</table>';
        return($html);
    }
    
    
    public function HTML_VentasXUsuario($sql,$sql_devoluciones) {
        $html="";
        
        
        $Datos= $this->obCon->Query($sql);
        if($this->obCon->NumRows($Datos)){
            $html='<br><span style="color:RED;font-family:Bookman Old Style;font-size:14px;"><strong><em>Total de Ventas Discriminadas por Usuarios y Tipo de Venta:
                </em></strong></span><BR>


                <table id="tbl_ventas_usuario" class="table table-responsive table-hover" border="1" cellspacing="2" align="center" >
                  <tr> 
                    <th><h3>Usuario</h3></th>
                        <th><h3>TipoVenta</h3></th>
                        <th><h3>Total Costos</h3></th>
                        <th><h3>SubTotal</h3></th>
                        <th><h3>IVA</h3></th>
                        <th><h3>Bolsas</h3></th>
                        <th><h3>Total</h3></th>
                  </tr >

                ';
            $Subtotal=0;
            $TotalIVA=0;
            $TotalVentas=0;
            $TotalCostos=0;
            $TotalBolsas=0;
            $flagQuery=0;
            $i=0;
            while($DatosVentas= $this->obCon->FetchArray($Datos)){
                $flagQuery=1;
                $SubtotalUser=number_format($DatosVentas["Subtotal"]);
                $IVA=number_format($DatosVentas["IVA"]);
                $Bolsas=number_format($DatosVentas["Bolsas"]);
                $Total=number_format($DatosVentas["Total"]+$DatosVentas["Bolsas"]);
                $Costos=number_format($DatosVentas["TotalCostos"]);
                $TipoVenta=$DatosVentas["TipoVenta"];
                $Subtotal=$Subtotal+$DatosVentas["Subtotal"];
                $TotalIVA=$TotalIVA+$DatosVentas["IVA"];
                $TotalBolsas=$TotalBolsas+$DatosVentas["Bolsas"];
                $TotalVentas=$TotalVentas+$DatosVentas["Total"]+$DatosVentas["Bolsas"];
                $TotalCostos=$TotalCostos+$DatosVentas["TotalCostos"];
                $idUser=$DatosVentas["IdUsuarios"];
                $html.=' 
                    
                        <tr>
                            <td>'.$DatosVentas["NombreUsuario"].'</td>
                            <td>'.$TipoVenta.'</td>
                            <td align="RIGHT">'.$Costos.'</td>
                            <td align="RIGHT">'.$SubtotalUser.'</td>
                            <td align="RIGHT">'.$IVA.'</td>
                            <td align="RIGHT">'.$Bolsas.'</td>    
                            <td align="RIGHT">'.$Total.'</td>
                        </tr>
                    
                    ';
            }
            if($flagQuery==1){
                $TotalCostos=number_format($TotalCostos);
                $Subtotal=number_format($Subtotal);
                $TotalIVA=number_format($TotalIVA);
                $TotalVentas=number_format($TotalVentas);
                $html.= '
                    
                        <tr>
                            <td align="RIGHT"><h3>SUMATORIA</h3></td>
                            <td><h3>NA</h3></td>
                            <td align="RIGHT"><h3>'.$TotalCostos.'</h3></td>
                            <td align="RIGHT"><h3>'.$Subtotal.'</h3></td>
                            <td align="RIGHT"><h3>'.$TotalIVA.'</h3></td>
                            <td align="RIGHT"><h3>'.number_format($TotalBolsas).'</h3></td>    
                            <td align="RIGHT"><h3>'.$TotalVentas.'</h3></td>
                        </tr>
                    
                ';
            }
        }
        
        $html.='</table>';
        //Total de devoluciones
        

        $Datos=$this->obCon->Query($sql_devoluciones);
        if($this->obCon->NumRows($Datos)){
            $html.='<BR><span style="color:RED;font-family:Bookman Old Style;font-size:14px;"><strong><em>Total devoluciones:
                </em></strong></span><BR><BR>
                <table class="table table-responsive table-hover" border="1" cellspacing="2" align="center" >
                  <tr> 
                    <th><h3>Usuario</h3></th>
                        <th><h3>Total Items</h3></th>
                        <th><h3>Total</h3></th>
                  </tr >

                ';
            $TotalVentas=0;
            $TotalItems=0;
            $i=0;
            while($DatosVentas= $this->obCon->FetchArray($Datos)){
                $Total=number_format($DatosVentas["Total"]);
		$Items=number_format($DatosVentas["Items"]);
		$TotalVentas=$TotalVentas+$DatosVentas["Total"];
		$TotalItems=$TotalItems+$DatosVentas["Items"];
		$idUser=$DatosVentas["IdUsuarios"];
                $html.='
                            <tr>
                                <td>'.$DatosVentas["NombreUsuario"].'</td>
                                <td align="RIGHT">'.$Items.'</td>
                                <td align="RIGHT">'.$Total.'</td>
                            </tr>
                        ';
            }
            $TotalItems=number_format($TotalItems);
            $TotalVentas=number_format($TotalVentas);
            $html.='
                        <tr>
                            <td align="RIGHT"><h3>SUMATORIA</h3></td>
                            <td align="RIGHT"><h3>'.$TotalItems.'</h3></td>
                            <td align="RIGHT"><h3>'.$TotalVentas.'</h3></td>
                        </tr>
                    ';
        }
        $html.='</table>';
        return($html);
    }
    
    
    //Resolucion de facturacion 
    public function HTML_Uso_Resoluciones($CondicionFecha2) {
        $html=' 
        <BR><span style="color:RED;font-family:Bookman Old Style;font-size:14px;"><strong><em>Informe de Numeracion Facturas:
        </em></strong></span><BR>


        <table class="table table-responsive table-hover" border="1" cellspacing="2" align="center" >
          <tr> 
            <th><h3>Resolucion</h3></th>
            <th><h3>Factura Inicial</h3></th>
            <th><h3>Factura Final</h3></th>
            <th ><h3>Total Clientes</h3></th>

          </tr >

        ';

        $sql="SELECT idResolucion,MAX(NumeroFactura) as MaxFact, MIN(NumeroFactura) as MinFact FROM facturas
                WHERE $CondicionFecha2 GROUP BY idResolucion";
        $Consulta= $this->obCon->Query($sql);
        while($DatosNumFact=$this->obCon->FetchArray($Consulta)){
                $MinFact=$DatosNumFact["MinFact"];
                $MaxFact=$DatosNumFact["MaxFact"];
                $idResolucion=$DatosNumFact["idResolucion"];
                $TotalFacts=$MaxFact-$MinFact+1;
                $html.='

                
                 <tr>
                  <td>'.$idResolucion.'</td>
                  <td>'.$MinFact.'</td>
                  <td>'.$MaxFact.'</td>
                  <td align="RIGHT">'.$TotalFacts.'</td>

                 </tr>
                 ';

        }
        $html.='</table>';
        return ($html);
    }
    
    public function HTML_Egresos_Admin($CondicionFecha2) {
        $html="";
        $sql="SELECT Usuario_idUsuario as IdUsuarios,(SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t3 WHERE t3.idUsuarios=Usuario_idUsuario LIMIT 1) as NombreUsuario, SUM(Subtotal) as Subtotal, SUM(IVA) as IVA, SUM(Valor) as Total FROM egresos
	WHERE $CondicionFecha2 GROUP BY Usuario_idUsuario";	
        $Datos= $this->obCon->Query($sql);
        if($this->obCon->NumRows($Datos)){
            $html='<BR><span style="color:RED;font-family:Bookman Old Style;font-size:14px;"><strong><em>Total Egresos:
                    </em></strong></span><BR>
                    <table class="table table-responsive table-hover" border="1" cellspacing="2" align="center" >
                      <tr> 
                        <th><h3>Usuario</h3></th>
                        <th><h3>SubTotal</h3></th>
                        <th><h3>IVA</h3></th>
                        <th><h3>Total</h3></th>
                      </tr >

                    ';
            
            $Subtotal=0;
            $TotalIVA=0;
            $TotalVentas=0;
            $TotalItems=0;
            $i=0;
            while($DatosVentas=$this->obCon->FetchArray($Datos)){
                $SubtotalUser=number_format($DatosVentas["Subtotal"]);
                $IVA=number_format($DatosVentas["IVA"]);
                $Total=number_format($DatosVentas["Total"]);
                $Subtotal=$Subtotal+$DatosVentas["Subtotal"];
                $TotalIVA=$TotalIVA+$DatosVentas["IVA"];
                $TotalVentas=$TotalVentas+$DatosVentas["Total"];
                $idUser=$DatosVentas["NombreUsuario"];
                $html.= ' 
                    
                        <tr>
                            <td>'.$idUser.'</td>
                            <td align="RIGHT">'.$SubtotalUser.'</td>
                            <td align="RIGHT">'.$IVA.'</td>
                            <td align="RIGHT">'.$Total.'</td>
                        </tr>
                    
                    ';
            }
            $TotalItems=number_format($TotalItems);
            $Subtotal=number_format($Subtotal);
            $TotalIVA=number_format($TotalIVA);
            $TotalVentas=number_format($TotalVentas);
	$html.=' 
            
                <tr>
                    <td align="RIGHT"><h3>SUMATORIA</h3></td>
                    <td><h3 align="RIGHT">'.$Subtotal.'</h3></td>
                    <td><h3 align="RIGHT">'.$TotalIVA.'</h3></td>
                    <td><h3 align="RIGHT">'.$TotalVentas.'</h3></td>
                </tr>
            
            ';
        }
        $html.='</table>';
        return($html);
    }
    
    
    //Funcion para armar el html de los abonos de separados en el informe de administrador
    public function HTML_Abonos_Separados_Admin($CondicionFecha2) {
        $html="";
        $sql="SELECT idUsuarios,(SELECT CONCAT(Nombre,' ',Apellido) FROM usuarios t3 WHERE t3.idUsuarios=separados_abonos.idUsuarios LIMIT 1) as NombreUsuario, SUM(Valor) as Subtotal FROM separados_abonos
	WHERE $CondicionFecha2
	GROUP BY idUsuarios";
	$Datos= $this->obCon->Query($sql);
        if($this->obCon->NumRows($Datos)){
            $html='<BR><span style="color:RED;font-family:Bookman Old Style;font-size:14px;"><strong><em>Total Abonos Separados:
                </em></strong></span><BR>
                <table class="table table-responsive table-hover" border="1" cellspacing="2" align="center" >
                    <tr> 
                      <th><h3>Usuario</h3></th>
                      
                      <th><h3>Total</h3></th>
                    </tr >
                ';
            $TotalAbonos=0;
            while($DatosAbonos=$this->obCon->FetchArray($Datos)){
                $TotalAbonos=$TotalAbonos+$DatosAbonos["Subtotal"];
                $html.='
                            <tr>
                                <td>'.$DatosAbonos["NombreUsuario"].'</td>
                                
                                <td align="RIGHT">'.number_format($DatosAbonos["Subtotal"]).'</td>

                            </tr>
                        ';
            }
            $html.=' 
            
                <tr>
                    <td align="RIGHT"><h3>SUMATORIA</h3></td>
                    
                    <td align="RIGHT"><h3>'.number_format($TotalAbonos).'</h3></td>
                </tr>
            
            ';
        }
        $html.='</table>';
        return($html);
    }
    
    public function HTML_Ventas_Colaboradores($fecha_inicial,$fecha_final) {
        $html=' 
        <BR><span style="color:RED;font-family:Bookman Old Style;font-size:12px;"><strong><em>Ventas X Colaboradores:
        </em></strong></span><BR>


        <table class="table table-responsive table-hover" border="1" cellspacing="2" align="center" >
          <tr> 
            
            <th><h3>Colaborador</h3></th>
            <th><h3>Tipo de Factura</h3></th>
            <th><h3>Total</h3></th>
            

          </tr >

        ';

        $sql="SELECT SUM(t1.Total) as Total,t2.FormaPago,(SELECT CONCAT(Nombre,' ',Identificacion) from colaboradores t3  where t3.Identificacion=t1.idColaborador LIMIT 1) AS NombreColaborador  
                FROM colaboradores_ventas t1 INNER JOIN facturas t2 ON t1.idFactura=t2.idFacturas 
                WHERE t1.Fecha>='$fecha_inicial' AND t1.Fecha<='$fecha_final' AND t2.FormaPago<>'ANULADA' GROUP BY t1.idColaborador,t2.FormaPago ";
        $Consulta= $this->obCon->Query($sql);
        while($DatosColaboradores=$this->obCon->FetchArray($Consulta)){
                
                $html.='

                
                 <tr>
                  <td>'.utf8_encode($DatosColaboradores["NombreColaborador"]).'</td>
                  <td>'.($DatosColaboradores["FormaPago"]).'</td>
                  <td align="RIGHT">'.number_format($DatosColaboradores["Total"]).'</td>
                 </tr>
                 ';

        }
        $html.='</table>';
        return ($html);
    }
    
    /**
     * Fin Clase
     */
}
