<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class VentasRestaurantePOS extends ProcesoVenta{
    /**
     * Crea una compra
     * @param type $Fecha
     * @param type $idTercero
     * @param type $Observaciones
     * @param type $CentroCostos
     * @param type $idSucursal
     * @param type $idUser
     * @param type $TipoCompra
     * @param type $NumeroFactura
     * @param type $Concepto
     * @param type $Vector
     * @return type
     */
    public function CrearPedido($idMesa,$idCliente,$NombreCliente, $DireccionEnvio,$Telefono,$Observaciones, $idUser,$Vector ) {
        $Fecha=date("Y-m-d");
        $Hora=date("H:i:s");
        $FechaCreacion=$Fecha." ".$Hora;
        $tab="restaurante_pedidos";
        $Datos["Fecha"]=$Fecha;
        $Datos["Hora"]=$Hora;
        $Datos["idUsuario"]=$idUser;
        $Datos["idMesa"]=$idMesa;
        $Datos["Estado"]="1";
        $Datos["Tipo"]=1;
        $Datos["idCliente"]=$idCliente;
        $Datos["NombreCliente"]=$NombreCliente;
        $Datos["DireccionEnvio"]=$DireccionEnvio;
        $Datos["TelefonoConfirmacion"]=$Telefono;
        $Datos["Observaciones"]=$Observaciones;
        
        $Datos["FechaCreacion"]=$FechaCreacion;
        
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
        $idPedido=$this->ObtenerMAX($tab,"ID", 1,"");
        
        return $idPedido;
    }
    
    public function CalcularTiempoPedido($FechaCreacion) {
        $fecha1 = date_create($FechaCreacion);
        $fecha2 = date_create(date("Y-m-d H:i:s"));
        $DatosDiferencias= date_diff($fecha1, $fecha2);
        $Dias=$DatosDiferencias->d;
        $Horas=$DatosDiferencias->h;
        $Minutos=$DatosDiferencias->i;
        $Segundos=$DatosDiferencias->s;
        $TotalTranscurrido=($Dias*1140)+($Horas*60)+$Minutos;
        return($TotalTranscurrido);
    }
    
    public function AgregueProductoAPedido($idPedido,$Cantidad,$idProducto,$Observaciones,$idUser,$Vector) {
            
            $fecha=date("Y-m-d");
            $hora=date("H:i:s");
            $DatosProductos=$this->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
            $ValoresProducto=$this->CalculeValoresItem($fecha, $idProducto, "productosventa", $Cantidad, "");
            $tab="restaurante_pedidos_items";
            $NumRegistros=20; 

            $Columnas[0]="idProducto";          $Valores[0]=$idProducto;
            $Columnas[1]="NombreProducto";      $Valores[1]=$DatosProductos["Nombre"];
            $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
            $Columnas[3]="ValorUnitario";       $Valores[3]=$ValoresProducto["ValorUnitario"];
            $Columnas[4]="Subtotal";            $Valores[4]=$ValoresProducto["Subtotal"];
            $Columnas[5]="IVA";                 $Valores[5]=$ValoresProducto["IVA"];
            $Columnas[6]="Total";               $Valores[6]=$ValoresProducto["Total"];
            $Columnas[7]="Observaciones";       $Valores[7]=$Observaciones;
            $Columnas[8]="idPedido";            $Valores[8]=$idPedido;
            $Columnas[9]="idUsuario";           $Valores[9]=  $idUser;
            $Columnas[10]="Fecha";              $Valores[10]=$fecha;
            $Columnas[11]="Hora";               $Valores[11]= $hora;
            $Columnas[12]="ProcentajeIVA";      $Valores[12]=($DatosProductos["IVA"]*100)."%";
            $Columnas[13]="Departamento";       $Valores[13]=$DatosProductos["Departamento"];
            $Columnas[14]="Sub1";               $Valores[14]=$DatosProductos["Sub1"];
            $Columnas[15]="Sub2";               $Valores[15]= $DatosProductos["Sub2"];
            $Columnas[16]="Sub3";               $Valores[16]= $DatosProductos["Sub3"];
            $Columnas[17]="Sub4";               $Valores[17]= $DatosProductos["Sub4"];
            $Columnas[18]="Sub5";               $Valores[18]= $DatosProductos["Sub5"];
            $Columnas[19]="Estado";             $Valores[19]= "AB";
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            
        }
        
    
    //Ingrese los items al inventario o retire items del inventario
    public function RealizarMovimientosInventario($idComprobante,$idUser) {
        $obInsumos=new Recetas(1);
        $Detalle="ComprobanteBajaAlta";
        $sql="SELECT * FROM inventario_comprobante_movimientos_items WHERE idComprobante='$idComprobante' AND Estado=''";
        $Consulta=$this->Query($sql);
        while($DatosProductos= $this->FetchArray($Consulta)){
            if($DatosProductos["TipoMovimiento"]=="BAJA"){
                $Movimiento="SALIDA";
            }else{
                $Movimiento="ENTRADA";
            }
            $idItem=$DatosProductos["ID"];
            if($DatosProductos["TablaOrigen"]=='productosventa'){
                
                $DatosProductoGeneral= $this->DevuelveValores("productosventa", "idProductosVenta", $DatosProductos["idProducto"]);
                $DatosKardex["Cantidad"]=$DatosProductos["Cantidad"];
                $DatosKardex["idProductosVenta"]=$DatosProductos["idProducto"];
                $DatosKardex["CostoUnitario"]=$DatosProductoGeneral['CostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProductoGeneral['Existencias'];

                $DatosKardex["Detalle"]=$Detalle;   
                $DatosKardex["idDocumento"]=$idComprobante;
                $DatosKardex["TotalCosto"]=$DatosProductos["Cantidad"]*$DatosProductoGeneral['CostoUnitario'];
                $DatosKardex["Movimiento"]=$Movimiento;
                $DatosKardex["CostoUnitarioPromedio"]=$DatosProductoGeneral["CostoUnitarioPromedio"];
                $DatosKardex["CostoTotalPromedio"]=$DatosProductoGeneral["CostoUnitarioPromedio"]*$DatosKardex["Cantidad"];
                $this->InserteKardex($DatosKardex);
            }
            
            if($DatosProductos["TablaOrigen"]=='insumos'){
                $DatosProductoGeneral= $this->DevuelveValores("insumos", "ID", $DatosProductos["idProducto"]);
            
                $obInsumos->KardexInsumo($Movimiento, $Detalle, $idComprobante, $DatosProductoGeneral["Referencia"], $DatosProductos["Cantidad"], $DatosProductoGeneral["CostoUnitario"], "");
            }
            
            $this->ActualizaRegistro("inventario_comprobante_movimientos_items", "Estado", "KARDEX", "ID", $idItem);
            
        }
        
          
        
    }
    
    /**
     * Fin Clase
     */
}
