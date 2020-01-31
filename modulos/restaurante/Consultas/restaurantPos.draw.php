<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/restaurantPos.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new VentasRestaurantePOS($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar el formulario para crear un pedido en una mesa
            print("<h4><strong>Mesas Disponibles:<strong></h4><br>");
            $css->input("hidden", "idFormulario", "", "idFormulario", "", "1", "", "", "", "");       
            $Consulta=$obCon->ConsultarTabla("restaurante_mesas", "WHERE Estado=0");
            
            while($DatosMesas=$obCon->FetchAssoc($Consulta)){
                $idMesa=$DatosMesas["ID"];
                $idBoton="BtnMesa_$idMesa";
                $js="onclick=CrearPedidoMesa(`$idMesa`)";
                $css->IconButton($idBoton,$idBoton,'fa fa-spoon',$DatosMesas["Nombre"],$js,$spanActivo=0,"orange",$style='style="background-color:#349cc2;color:white"');
                
            }
                        
        break; //Fin caso 1
        
        case 2: //Dibuja la informacion general de un pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $sql="SELECT t1.*, 
                   (SELECT Nombre FROM restaurante_tipos_pedido t2 WHERE t1.Tipo=t2.ID LIMIT 1) as NombreTipoPedido,
                   (SELECT Nombre FROM restaurante_mesas t3 WHERE t1.idMesa=t3.ID LIMIT 1) as NombreMesa
                   FROM restaurante_pedidos t1 WHERE ID='$idPedido'";
            $DatosPedido=$obCon->FetchAssoc($obCon->Query($sql));
            
            if($DatosPedido["Tipo"]==1){
                print('<div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-renren"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-number">Pedido No: '.$idPedido.'</span>
                          <span class="info-box-number">'.$DatosPedido["NombreMesa"].'</span>                      
                        </div>                   
                      </div>
                ');
            }
            
        break;//Fin caso 2    
        
        case 3://Dibuja los items de un pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            
            $sql="SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido' ORDER BY ID DESC";
            $Consulta=$obCon->Query($sql);
            
            $css->CrearTabla();
            
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ID</strong>", 1, "C");
                    $css->ColTabla("<strong>Producto</strong>", 1, "C");
                    $css->ColTabla("<strong>Cantidad</strong>", 1, "C");
                    $css->ColTabla("<strong>Total</strong>", 1, "C");
                    $css->ColTabla("<strong>Eliminar</strong>", 1, "C");
                $css->CierraFilaTabla();
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosPedido["ID"];
                $Descripcion= utf8_encode($DatosPedido["NombreProducto"]);
                if($DatosPedido["Observaciones"]<>''){
                    $Descripcion.="<br><strong>".utf8_encode($DatosPedido["Observaciones"])."</strong>";
                }
                $css->FilaTabla(15);
                    $css->ColTabla($DatosPedido["idProducto"], 1);
                    $css->ColTabla($Descripcion, 1);
                    $css->ColTabla($DatosPedido["Cantidad"], 1);
                    $css->ColTabla("<strong>".number_format($DatosPedido["Total"])."</strong>", 1,"R");
                    print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>"); 
                        $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                        $css->Cli();
                    print("</td>");                    
                $css->CierraFilaTabla();
            }
            
            $css->CerrarTabla();
        break;//Fin caso 3  
        
        case 4://Dibujo los totales del pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido==0 or $idPedido==''){
                $css->CrearTitulo("No se recibió un pedido válido", "rojo");
            }
            $sql="SELECT SUM(Cantidad) as Items,SUM(Subtotal) as Subtotal,SUM(IVA) as IVA,SUM(Total) as Total 
                    FROM restaurante_pedidos_items WHERE idPedido='$idPedido' ";
            $DatosTotales=$obCon->FetchAssoc($obCon->Query($sql));
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>TOTALES</strong>", 3, "C");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>ITEMS</strong>", 2, "L");
                    $css->ColTabla($DatosTotales["Items"], 1, "R");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>SUBTOTAL</strong>", 2, "L");
                    $css->ColTabla(number_format($DatosTotales["Subtotal"]), 1, "R");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>IMPUESTOS</strong>", 2, "L");
                    $css->ColTabla(number_format($DatosTotales["IVA"]), 1, "R");
                $css->CierraFilaTabla();
                $css->FilaTabla(24);
                    $css->ColTabla("<strong>TOTAL</strong>", 2, "L");
                    $css->ColTabla("<strong>".number_format($DatosTotales["Total"])."</strong>", 1, "R");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>OPCIONES</strong>", 3, "C");                    
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print('<span class="input-group-btn">
                            <button type="button" id="BtnImprimePedido" class="btn btn-success btn-flat" onclick=ImprimirPedido(`'.$idPedido.'`) title="Imprimir Pedido"><i class="fa fa-print"></i></button>
                          </span>');
                    print("</td>");
                    print("<td style='text-align:center'> ");
                        print('<span class="input-group-btn">
                            <button type="button" id="BtnImprimePrecuenta" class="btn btn-warning btn-flat" onclick=ImprimirPrecuenta(`'.$idPedido.'`) title="Imprimir Precuenta"><i class="fa fa-credit-card"></i></button>
                          </span>');
                    print("</td>"); 
                    print("<td style='text-align:center'>");
                        print('<span class="input-group-btn">
                            <button type="button" id="BtnImprimePedido" class="btn btn-danger btn-flat" onclick=AbrirOpcionesFacturacion(`'.$idPedido.'`) title="Facturar"><i class="fa fa-money"></i></button>
                          </span>');
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
            
        break;//fin caso 4    
           
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>