<?php

@session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
include_once("../clases/Facturacion.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon= new Facturacion($idUser);
    switch ($_REQUEST["Accion"]) {
                
        case 1://Dibuja el formulario para agregar los productos
            $sql="SELECT * FROM productosventa ORDER BY Nombre ASC LIMIT 50";
            $Consulta=$obCon->Query($sql);
            
            print(' <div class="box box-primary"> 
                    
                        <div class="box-header with-border">
                            <h3 class="box-title">Lista de Productos</h3>
                              
                        </div>
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                        
                     ');
            
            while($datos_consulta=$obCon->FetchAssoc($Consulta)){
                $item_id=$datos_consulta["idProductosVenta"];
                print('<li class="item">
                        <div class="product-img">
                            <div class="btn-group-vertical"><br>
                            <button type="button" onclick="cambiar_cantidad_agregar(`'.$item_id.'`,`1`)" class="btn btn-bitbucket btn-lg" > <li class="fa fa-caret-up "></li> </button>
                            <button type="button" onclick="cambiar_cantidad_agregar(`'.$item_id.'`,`3`)" class="btn btn-default btn-lg"><span id="sp_cantidad_agregar_'.$item_id.'">1</span></button>

                            <div class="btn-group">
                              <button type="button" onclick="cambiar_cantidad_agregar(`'.$item_id.'`,`2`)" class="btn btn-bitbucket btn-lg" > <li class="fa fa-caret-down "></li> </button>
                              
                            </div>
                          </div>
                        </div>
                        <div class="product-info">
                            <a href="javascript:void(0)" class="product-title">'.$datos_consulta["Nombre"].'<br>
                                <a onclick="agregar_item(`'.$item_id.'`,`'.$datos_consulta["PrecioVenta"].'`)" class="btn btn-block btn-social btn-bitbucket btn-lg"><i class="fa fa-tag" > </i> '.number_format($datos_consulta["PrecioVenta"]).'</a>
                                <a onclick="agregar_item(`'.$item_id.'`,`'.$datos_consulta["precio_venta2"].'`)" class="btn btn-block btn-social btn-github btn-lg"><i class="fa fa-tags" ></i> '.number_format($datos_consulta["precio_venta2"]).'</a>
                                <a onclick="agregar_item(`'.$item_id.'`,`'.$datos_consulta["PrecioMayorista"].'`)" class="btn btn-block btn-social btn-flickr btn-lg"><i class="fa fa-star" ></i> '.number_format($datos_consulta["PrecioMayorista"]).'</a>
                                
                            
                        </div>
                      </li>');
            }
            
            print('</ul></div></div>');
            
        break;// fin caso 1
        
        case 2://Dibuja los items de una preventa
                
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            if($idPreventa==0 or $idPreventa==''){
                $idPreventa=$idUser;
            }
            $sql="SELECT t1.*,
                    (SELECT Nombre FROM productosventa t2 WHERE t2.idProductosVenta=t1.ProductosVenta_idProductosVenta LIMIT 1) AS nombre_producto 
                                       
                    FROM preventa t1 WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY idPrecotizacion DESC";
            $Consulta=$obCon->Query($sql);
            print('<div class="box">
            <div class="box-header">
              <h3 class="box-title"><strong>Productos Agregados</strong>
              </h3>
            </div>
            <div class="box-body">
              
            ');
            print('<table class="table table-responsive">');
                
                $css->FilaTabla(16);
                    //$css->ColTabla("<strong>ID</strong>", 1, "C");
                    $css->ColTabla("<strong>Producto</strong>", 1, "C");
                    $css->ColTabla("<strong>Cantidad</strong>", 1, "C");
                    $css->ColTabla("<strong>Total</strong>", 1, "C");
                    $css->ColTabla("<strong>Eliminar</strong>", 1, "C");
                $css->CierraFilaTabla();
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosPedido["idPrecotizacion"];
                $Descripcion= utf8_encode($DatosPedido["nombre_producto"]);
                
                print('<tr>');
                    //$css->ColTabla($DatosPedido["idProducto"], 1);
                    print('<td >');
                        print($Descripcion);
                    print('</td>');
                    print('<td style="text-align:center">');
                        print('<div class="btn-group-vertical"  >
                                    <button onclick="editar_cantidad(`'.$idItem.'`,`1`);"  type="button" class="btn bg-purple " onclick="frm_cambiar_cantidad(`'.$idItem.'`);" style="cursor:pointer;text-align:center;"><li class="fa fa-sort-up"></li></button>
                                        <span class="text-lg"><strong><span id=sp_cantidad_'.$idItem.'>'.$DatosPedido["Cantidad"].'</strong></span></span>
                                    <button onclick="editar_cantidad(`'.$idItem.'`,`2`);"  type="button" class="btn bg-purple " onclick="frm_cambiar_cantidad(`'.$idItem.'`);" style="cursor:pointer;text-align:center;"><li class="fa fa-sort-desc"></li></button>    
                                    
                                  </div>');
                    
                    print('</td>');
                    
                    print('<td style="text-align:right">');
                        print("<strong><span id=sp_total_".$idItem.">".number_format($DatosPedido["TotalVenta"])."</span></strong>");
                    print('</td>');
                    
                    
                    print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>"); 
                        $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                        $css->Cli();
                    print("</td>");                    
                $css->CierraFilaTabla();
            }
            
            $css->CerrarTabla();
            
            
            print('</div>
                    </div>');
            
            
        break;//Fin caso 2
        
        case 3:
            
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            if($idPreventa==0 or $idPreventa==''){
                $idPreventa=$idUser;
            }
            $sql="SELECT sum(TotalVenta) as total,SUM(Cantidad) as total_items                                       
                    FROM preventa t1 WHERE VestasActivas_idVestasActivas='$idPreventa' ";
            $datos_totales=$obCon->FetchArray($obCon->Query($sql));
            print('<div class="box">
            <div class="box-header">
              <h3 class="box-title"><strong>Total de esta venta</strong>
              </h3>
            </div>
            <div class="box-body">
              
            ');
            
            print('<div class="row"><div class="col-md-12">');
                if($datos_totales["total_items"]==0){
                    $css->CrearTitulo("Venta vacía");
                    exit();
                }
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("Items:", 1);
                        $css->ColTabla("<strong>".$datos_totales["total_items"]."</strong>", 1,"R");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("Total Venta:", 1);
                        $css->ColTabla("<strong>".number_format($datos_totales["total"])."</strong>", 1,"R");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print('<td colspan="2">');
                            print('<select id="idCliente" class="form-control">');
                                print('<option value="">Seleccione un Cliente</option>');
                                
                            print('</select>');
                        print('</td>');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print('<td colspan="2">');
                            print('<select id="CmbTipoPago" class="form-control">');
                                print('<option value="Contado">Contado</option>');
                                print('<option value="Bancos">Transferencias o Tarjetas</option>');
                                print('<option value="15">Credito a 15 días</option>');
                                print('<option value="30">Credito a 30 días</option>');
                            print('</select>');
                        print('</td>');
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        print('<td colspan="1">');
                            $css->CrearBotonEvento("btn_facturar", "Facturar", 1, "onclick", "confirma_guardar_factura(`$idPreventa`)", "rojo");
                        print('</td>');
                        print('<td colspan="1">');
                            $css->CrearBotonEvento("btn_cotizar", "Cotizar", 1, "onclick", "confirma_cotizar_preventa(`$idPreventa`)", "naranja");
                        print('</td>');
                    $css->CierraFilaTabla();
                    
                $css->CerrarTabla();
            print('</div></div>');
            
            
            print('</div></div>');
            
        break;//Fin caso 3    
        
        case 4:// formulario para cerrar turno
           
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 7, "", "", "", "");
            $css->div("", "row", "", "", "", "", "");
                $css->div("", "col-md-4", "", "", "", "", "");
                $css->Cdiv();
                $css->div("", "col-md-4", "", "", "", "", "");
                    $css->CrearTitulo("<strong>Por favor digite el total del efectivo recaudado</strong>", "verde");
                    $css->input_number_format("number", "total_entrega", "form-control", "total_entrega", "Entrega Total", 0, "Total recaudado", "off", "", "");
            
                $css->Cdiv();
                $css->div("", "col-md-4", "", "", "", "", "");
                $css->Cdiv();
            $css->Cdiv();    
            
        break;//Fin caso 4
            
        
    
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>