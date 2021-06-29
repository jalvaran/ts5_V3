<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
include_once 'Recetas.class.php';
class Inventarios extends ProcesoVenta{
    
    public function InventariosCrearProductoVenta($Fecha, $Observaciones, $idUser,$Vector ) {
        $tab="inventario_comprobante_movimientos";
        $Datos["Fecha"]=$Fecha;
        $Datos["Observaciones"]=$Observaciones;
        $Datos["idUser"]=$idUser;
        $Datos["Estado"]="ABIERTO";
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
        $idComprobante=$this->ObtenerMAX($tab,"ID", 1,"");
        
        return $idComprobante;
    }
    /**
     * Agrega un item
     * @param type $idProducto
     * @param type $TablaOrigen
     * @param type $Cantidad
     * @param type $TipoMovimiento
     * @param type $Vector
     */
    public function AgregarItem($idComprobante,$idProducto, $TablaOrigen, $Cantidad,$TipoMovimiento,$Vector ) {
        $idTabla="ID";
        if($TablaOrigen=="productosventa"){
            $idTabla="idProductosVenta";
        }
        
        $DatosProducto=$this->DevuelveValores($TablaOrigen, $idTabla, $idProducto);
        $tab="inventario_comprobante_movimientos_items";
        $Datos["idProducto"]=$idProducto;
        $Datos["TablaOrigen"]=$TablaOrigen;
        $Datos["Cantidad"]=$Cantidad;
        $Datos["CostoUnitario"]=$DatosProducto["CostoUnitario"];
        $Datos["CostoTotal"]=$DatosProducto["CostoUnitario"]*$Cantidad;
        $Datos["TipoMovimiento"]=$TipoMovimiento;
        $Datos["idComprobante"]=$idComprobante;
        $sql=$this->getSQLInsert($tab, $Datos);
        
        $this->Query($sql);
        
    }
    
    //Ingrese los items al inventario o retire items del inventario
    public function RealizarMovimientosInventario($idComprobante,$idUser) {
        $obInsumos=new Recetas(1);
        $DatosComprobante=$this->DevuelveValores("inventario_comprobante_movimientos", "ID", $idComprobante);
        $DatosEmpresaPro=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
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
                $idProductoVenta=$DatosProductos["idProducto"];
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
                /*
                $TotalCosto=$DatosProductos["Cantidad"]*$DatosProductoGeneral['CostoUnitario'];
                $DatosParametros= $this->DevuelveValores("parametros_contables", "ID", 4);
                $CuentaInventarios=$DatosParametros["CuentaPUC"];
                $NombreCuentaInventarios=$DatosParametros["NombreCuenta"];
                $DatosParametros= $this->DevuelveValores("parametros_contables", "ID", 3);
                $CuentaBajas=$DatosParametros["CuentaPUC"];
                $DatosParametros= $this->DevuelveValores("parametros_contables", "ID", 5);
                $CuentaAltas=$DatosParametros["CuentaPUC"];
                $NombreCuentaAltas=$DatosParametros["NombreCuenta"];
                if($DatosProductos["TipoMovimiento"]=="ALTA"){
                    //print("Entra Alta");
                    $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteMovimientosInventario", $idComprobante,$idComprobante , $DatosEmpresaPro["NIT"], $CuentaInventarios, $NombreCuentaInventarios, "Movimiento en Inventario $Movimiento", "DB", $TotalCosto, $DatosComprobante["Observaciones"], 1, 1, "");
                    $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteMovimientosInventario", $idComprobante,$idComprobante , $DatosEmpresaPro["NIT"], $CuentaAltas, $NombreCuentaAltas, "Movimiento en Inventario $Movimiento", "CR", $TotalCosto, $DatosComprobante["Observaciones"], 1, 1, "");
                }
                if($DatosProductos["TipoMovimiento"]=="BAJA"){
                    //print("Entra Baja");
                    $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteMovimientosInventario", $idComprobante,$idComprobante , $DatosEmpresaPro["NIT"], $CuentaInventarios, $NombreCuentaInventarios, "Movimiento en Inventario $Movimiento", "CR", $TotalCosto, $DatosComprobante["Observaciones"], 1, 1, "");
                    $this->IngreseMovimientoLibroDiario($DatosComprobante["Fecha"], "ComprobanteMovimientosInventario", $idComprobante,$idComprobante , $DatosEmpresaPro["NIT"], $CuentaAltas, $NombreCuentaAltas, "Movimiento en Inventario $Movimiento", "DB", $TotalCosto,$DatosComprobante["Observaciones"], 1, 1, "");
                }
                 * 
                 */
            }
            
            if($DatosProductos["TablaOrigen"]=='insumos'){
                $DatosProductoGeneral= $this->DevuelveValores("insumos", "ID", $DatosProductos["idProducto"]);
            
                $obInsumos->KardexInsumo($Movimiento, $Detalle, $idComprobante, $DatosProductoGeneral["Referencia"], $DatosProductos["Cantidad"], $DatosProductoGeneral["CostoUnitario"], "");
            }
            
            $this->ActualizaRegistro("inventario_comprobante_movimientos_items", "Estado", "KARDEX", "ID", $idItem);
            
        }
        
          
        
    }
    
    
    function crearVistaSeparados(){
        $sql="DROP VIEW IF EXISTS `vista_separados_reportes`;";
        $this->Query($sql);
                
        $sql="CREATE VIEW vista_separados_reportes AS 
                SELECT t1.*,t2.RazonSocial,t2.Num_Identificacion,t2.Telefono,t2.Direccion,          
                (SELECT DATE_ADD(t1.Fecha, INTERVAL 2 MONTH) ) as FechaVencimiento 
                FROM separados t1 INNER JOIN clientes t2 ON t1.idCliente=t2.idClientes 
                
                ;
                    
           ";
        $this->Query($sql);
    }
    
    public function crear_traslado($ID, $Fecha, $Hora,$Origen,$ConsecutivoInterno, $Destino,$Descripcion,$idUser) {
        $sql="SELECT Identificacion FROM usuarios WHERE idUsuarios='$idUser'";
        $datos_usuario=$this->FetchAssoc($this->Query($sql));
        $tab="traslados_mercancia";
        $Datos["ID"]=$ID;
        $Datos["Fecha"]=$Fecha;
        $Datos["Hora"]=$Hora;
        $Datos["Origen"]=$Origen;
        $Datos["ConsecutivoInterno"]=$ConsecutivoInterno;
        $Datos["Destino"]=$Destino;
        $Datos["Descripcion"]=$Descripcion;
        $Datos["Abre"]=$datos_usuario["Identificacion"];
        $Datos["idBodega"]=1;
        $Datos["Estado"]="EN DESARROLLO";
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
        
    }
    
    public function agregar_item_traslado($idComprobante,$idProducto,$Cantidad,$DatosProducto){
         
        $DatosTraslado=$this->DevuelveValores("traslados_mercancia", "ID", $idComprobante);   

        $sql="SELECT * FROM traslados_items WHERE idTraslado='$idComprobante' AND CodigoBarras='$idProducto'";
        $consulta=$this->Query($sql);
        $DatosItems=$this->FetchAssoc($consulta);
        if($DatosItems["ID"]==''){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 5";
            $consulta=$this->Query($sql);
            $i=0;
            $Codigo[0]="";
            $Codigo[1]="";
            $Codigo[2]="";
            $Codigo[3]="";
            $Codigo[4]="";
            while($CodigoBarras=$this->FetchArray($consulta)){

                 $Codigo[$i]=$CodigoBarras["CodigoBarras"];
                 $i++;
            }

            $tab="traslados_items";
                        
            $Datos["Fecha"]=$DatosTraslado["Fecha"];
            $Datos["CodigoBarras"]=$idProducto;
            $Datos["Referencia"]=$DatosProducto["Referencia"];
            $Datos["Nombre"]=$DatosProducto["Nombre"];
            $Datos["Cantidad"]=$Cantidad;
            $Datos["PrecioVenta"]=$DatosProducto["PrecioVenta"];
            $Datos["PrecioMayorista"]=$DatosProducto["PrecioMayorista"];
            $Datos["CostoUnitario"]=$DatosProducto["CostoUnitario"];
            $Datos["IVA"]=$DatosProducto["IVA"];
            $Datos["Departamento"]=$DatosProducto["Departamento"];
            $Datos["Sub1"]=$DatosProducto["Sub1"];
            $Datos["Sub2"]=$DatosProducto["Sub2"];
            $Datos["Sub3"]=$DatosProducto["Sub3"];
            $Datos["Sub4"]=$DatosProducto["Sub4"];
            $Datos["Sub5"]=$DatosProducto["Sub5"];
            $Datos["CuentaPUC"]=$DatosProducto["CuentaPUC"];
            $Datos["idTraslado"]=$idComprobante;
            $Datos["Estado"]="EN DESARROLLO";
            $Datos["Destino"]=$DatosTraslado["Destino"];
            $Datos["CodigoBarras1"]=$Codigo[0];
            $Datos["CodigoBarras2"]=$Codigo[1];
            $Datos["CodigoBarras3"]=$Codigo[2];
            $Datos["CodigoBarras4"]=$Codigo[3];
            
            $sql=$this->getSQLInsert($tab, $Datos);
            $this->Query($sql);
        }else{
           $Cantidad=$Cantidad+$DatosItems["Cantidad"];
           
           $this->ActualizaRegistro("traslados_items", "Cantidad", $Cantidad, "ID", $DatosItems["ID"]);
        }
       
    
    }
    
    public function guardar_traslado($idComprobante) {
        $Costo=0;
        $sql="SELECT * FROM traslados_items WHERE idTraslado='$idComprobante' AND Deleted='0000-00-00 00:00:00' ";
        $consulta=$this->Query($sql);
        
        $VectorCosto["F"]=0;
        while($DatosItems=  $this->FetchArray($consulta)){
            $fecha=$DatosItems["Fecha"];
            $Costo=$Costo+($DatosItems["CostoUnitario"]*$DatosItems["Cantidad"]);
            $DatosProducto=$this->DevuelveValores("productosventa", "Referencia", $DatosItems["Referencia"]);
            $DatosKardex["Cantidad"]=$DatosItems['Cantidad'];
            $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
            $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
            $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
            $DatosKardex["Detalle"]="Traslado";
            $DatosKardex["idDocumento"]=$idComprobante;
            $DatosKardex["TotalCosto"]=$DatosItems['Cantidad']*$DatosProducto['CostoUnitario'];
            $DatosKardex["Movimiento"]="SALIDA";
            $DatosKardex["CostoUnitarioPromedio"]=$DatosProducto["CostoUnitarioPromedio"];
            $DatosKardex["CostoTotalPromedio"]=$DatosProducto["CostoUnitarioPromedio"]*$DatosKardex["Cantidad"];
            $this->InserteKardex($DatosKardex);
        }
        
        $this->RegistreCostoLibroDiario("NO", $Costo,$fecha,$idComprobante,1,$VectorCosto);
        $this->update("traslados_mercancia", "Estado", "PREPARADO", "WHERE ID='$idComprobante'");
        $this->update("traslados_items", "Estado", "PREPARADO", "WHERE idTraslado='$idComprobante' AND Deleted='0000-00-00 00:00:00'");
    }
    
    public function imprime_traslado($idTraslado,$Copias) {
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $Titulo="Traslado No. $idTraslado";
        $DatosComprobante=$this->DevuelveValores("traslados_mercancia", "ID", $idTraslado);
        $Fecha=$DatosComprobante["Fecha"];
             
        
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Titulo); // Titulo
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Observaciones / ".$DatosComprobante["Descripcion"]);
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea    
        
        $sql="SELECT * FROM traslados_items  "
                . " WHERE idTraslado='$idTraslado' AND Deleted='0000-00-00 00:00:00'";
        $Consulta=$this->Query($sql);
        while($DatosItems=$this->FetchAssoc($Consulta)){
            fwrite($handle,$DatosItems["Referencia"]." / ");
            //fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,$DatosItems["Cantidad"]." / ".$DatosItems["Nombre"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        }
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea    
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
        
        
        }
        fclose($handle); // cierra el fichero PRN
        $salida = shell_exec('lpr $COMPrinter');
    }
    
    public function subir_traslado($traslado_id){
                        
        $VectorAS["f"]=0;
        $DatosServer=$this->DevuelveValores("servidores", "ID", 1); 
        $FechaSinc=date("Y-m-d H:i:s");
        //$Condicion=" WHERE ServerSincronizado='0000-00-00 00:00:00'";
        
        $CondicionTraslado=" WHERE ID = '$traslado_id' AND Estado='PREPARADO'";
        $CondicionItems=" WHERE idTraslado = '$traslado_id' AND Estado='PREPARADO'";
        $sql1=$this->ArmeSqlInsert("traslados_mercancia", DB, $CondicionTraslado,$DatosServer["DataBase"],$FechaSinc, $VectorAS);
        $VectorAS["AI"]=1; //Indicamos que la tabla tiene id con autoincrement
        $sql2=$this->ArmeSqlInsert("traslados_items", DB, $CondicionItems,$DatosServer["DataBase"],$FechaSinc, $VectorAS);
        
        //$this->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
        if(!empty($sql1)){
            $this->QueryExterno($sql1, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            //$this->Query($sql1);
        }
        if(!empty($sql2)){
            $this->QueryExterno($sql2, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            //$this->Query($sql2);
        }
        
        //$this->ConToServer($host, $user, $pw, $db, $VectorCon);   
        $this->update("traslados_mercancia", "ServerSincronizado", $FechaSinc, $CondicionTraslado); 
        $this->update("traslados_mercancia", "Estado", 'ENVIADO', $CondicionTraslado); 
        $this->update("traslados_items", "ServerSincronizado", $FechaSinc, $CondicionItems); 
        $this->update("traslados_items", "Estado", 'ENVIADO', "WHERE idTraslado = '$traslado_id'"); 
               
     }
    
    /**
     * Fin Clase
     */
}
