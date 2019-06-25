<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/pos2.class.php");
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
                        
        break; 
        case 2:// se dibuja el listado de pedidos
            
            $sql="SELECT rp.ID,rp.FechaCreacion,rp.Fecha,rp.Hora,rp.idUsuario,rp.idMesa, CONCAT(us.Nombre,' ',us.Apellido) as NombreUsuario,rm.Nombre as NombreMesa"
                . " FROM restaurante_pedidos rp "
                . "INNER JOIN usuarios us ON us.idUsuarios=rp.idUsuario "
                . "INNER JOIN restaurante_mesas rm ON rm.ID=rp.idMesa"
                . " WHERE rp.idUsuario='$idUser' AND rp.Estado='1' AND rp.Tipo='1'";
            $Consulta=$obCon->Query($sql);
            if($obCon->NumRows($Consulta)){
                $css->CrearTitulo("<strong>Lista de Pedidos</strong>");
               
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        
                        $css->ColTabla("<strong>ID</strong>", 1,"C");
                        $css->ColTabla("<strong>Mesa</strong>", 1,"C");                        
                        $css->ColTabla("<strong>Tiempo</strong>", 1,"C");
                                         
                        $css->ColTabla("<strong>Acciones</strong>", 1,"C");
                         
                        $css->ColTabla("<strong>Creado</strong>", 1,"C");
                        $css->ColTabla("<strong>Usuario</strong>", 1,"C");      
                    $css->CierraFilaTabla();
                
                while($DatosPedidos=$obCon->FetchAssoc($Consulta)){
                    $TiempoTranscurrido=$obCon->CalcularTiempoPedido($DatosPedidos["FechaCreacion"]);
                    $styles="";
                    if($TiempoTranscurrido>15){
                        $styles="style=background-color:#ffaeae;";
                    }
                    $css->FilaTabla(16);
                        $idPedido=$DatosPedidos["ID"];
                        $css->ColTabla($DatosPedidos["ID"], 1,"C");
                        $css->ColTabla($DatosPedidos["NombreMesa"], 1,"C");
                        
                        print("<td $styles>");
                            print($TiempoTranscurrido);
                        print("</td>");
                        
                        
                        print("<td>");
                            $css->IconButton("btnAgregar", "btnAgregar", "fa fa-opencart", "Mostrar", "onclick='DibujePedido($idPedido)'",$spanActivo=0,"orange",$style='style="background-color:#dbffae;color:red"');
                            $css->IconButton("btnCancelar", "btnCancelar", "fa fa-remove", "Eliminar", "onclick='AgregarItems($idPedido)'",$spanActivo=0,"orange",$style='style="background-color:#ffeaae;color:red"');
                        print("</td>");
                        
                        
                        $css->ColTabla($DatosPedidos["Fecha"]." ".$DatosPedidos["Hora"], 1,"C");
                        $css->ColTabla($DatosPedidos["NombreUsuario"], 1,"C");
                    $css->CierraFilaTabla();
                }
                $css->CerrarTabla();
            }else{
                $css->CrearTitulo("<strong>No hay pedidos</strong>",'rojo');
            }
            
        break;  
        
        case 3://Dibuje el titulo de un pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $DatosPedido=$obCon->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            $TipoPedido="";
            if($DatosPedido["Tipo"]==1){
                $Titulo="<strong>PEDIDO PARA LA MESA ".$DatosPedido["idMesa"]."</strong>";
            }
            $css->CrearTitulo($Titulo,'azul');
            $css->IconButton("btnAgregarItems", "btnAgregarItems", "fa fa-opencart", "Agregar Items", "onclick='MuestraOcultaXID(`DivAgregarItem`)'",$spanActivo=0,"orange",$style='style="background-color:#92ff71;color:black"');
            
            $css->IconButton("btnPrintPedido", "btnPrintPedido", "fa fa-print", "Imprimir Pedido", "onclick='ImprimirPedido(`$idPedido`)'",$spanActivo=0,"orange",$style='style="background-color:#ffcde5;color:black"');
            
            $css->IconButton("btnAgregarItems", "btnAgregarItems", "fa fa-print", "Imprimir Precuenta", "onclick='ImprimirPrecuenta(`$idPedido`)'",$spanActivo=0,"orange",$style='style="background-color:#cdd8ff;color:black"');
            
            $css->IconButton("btnAgregarItems", "btnAgregarItems", "fa fa-credit-card", "Facturar", "onclick='AbrirOpcionesFacturacion(`$idPedido`)'",$spanActivo=0,"orange",$style='style="background-color:#ffffcd;color:black"');
        break;// fin caso 3
        
        case 4://Dibuje los departamentos
            
            
            $Consulta=$obCon->ConsultarTabla("prod_departamentos", "");
            while($DatosDepartamento=$obCon->FetchAssoc($Consulta)){
                $idDepartamento=$DatosDepartamento["idDepartamentos"];
               // $css->CrearBotonEvento("BtnDepartamento", $DatosDepartamento["Nombre"], 1, "onclick", "MostrarProductos(`$idDepartamento`)", "verde", "");
                $css->IconButton("btnAgregarDepartamento", "btnAgregarDepartamento", "fa fa-institution", $DatosDepartamento["Nombre"], "onclick='MostrarProductos($idDepartamento)'",$spanActivo=0,"orange",$style='style="background-color:#aed0ff;color:black"');
                //print("<br><br>");
                
            }
        break;// fin caso 4

        
        case 5: //Dibuja los productos de un departamento
            $Condicion=" LIMIT 100";
            if(isset($_REQUEST["idDepartamento"])){
                $idDepartamento=$obCon->normalizar($_REQUEST["idDepartamento"]);
                $Condicion="WHERE Departamento='$idDepartamento'";
            }
            
            if(isset($_REQUEST["Busqueda"])){
                $key=$obCon->normalizar($_REQUEST["Busqueda"]);
                $Condicion="WHERE Nombre like '$key%' or idProductosVenta='$key' or Referencia='$key' LIMIT 100";
            }
            
            
            $Consulta=$obCon->ConsultarTabla("productosventa", $Condicion);
            while($DatosProducto=$obCon->FetchAssoc($Consulta)){
                $idProducto=$DatosProducto["idProductosVenta"];               
                $css->IconButton("btnAgregarProducto", "btnAgregarProducto", "fa  fa-hand-o-right", utf8_encode($DatosProducto["Nombre"])." $<strong>". number_format($DatosProducto["PrecioVenta"])."</strong>", "onclick='AgregarProducto($idProducto)'",$spanActivo=0,"orange",$style='style="background-color:#edeceb;color:black"');
                
            }
            
            
            break;//Fin caso 5
            
        case 6:
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            $sql="SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido' ORDER BY ID Desc";
            $Consulta=$obCon->Query($sql);
            if($obCon->NumRows($Consulta)){
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Nombre</strong>", 1);
                        $css->ColTabla("<strong>Total</strong>", 1);
                        $css->ColTabla("<strong>Acciones</strong>", 1);
                    $css->CierraFilaTabla();
                    while($DatosItems=$obCon->FetchAssoc($Consulta)){
                        $idItem=$DatosItems["ID"];
                        $css->FilaTabla(16);
                            $css->ColTabla($DatosItems["Cantidad"], 1);
                            $Observaciones="";
                            if ($DatosItems["Observaciones"]<>""){
                                $Observaciones="<br>Observaciones: ".$DatosItems["Observaciones"];
                            }
                            $css->ColTabla($DatosItems["NombreProducto"].$Observaciones, 1);
                            $css->ColTabla(number_format($DatosItems["Total"]), 1,'R');
                            print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");
                                $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`1`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                                $css->Cli();
                            print("</td>");
                        $css->CierraFilaTabla();
                    }
                $css->CerrarTabla();
            }else{
                $css->CrearTitulo("No hay Items en este pedido","rojo");
            }
        break;     //Fin caso 6
        
        case 7://Muestro el total del pedido
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            
            $Total=$obCon->SumeColumna("restaurante_pedidos_items", "Total", "idPedido", $idPedido);
            
            print("$idPedido, por un Total de: $". number_format($Total));
            
        break;    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>