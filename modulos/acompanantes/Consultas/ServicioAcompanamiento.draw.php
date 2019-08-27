<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/ServicioAcompanamiento.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Servicios($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar la agenda de las modelos
            
           $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Modelo</strong>", 1);
                    $css->ColTabla("<strong>Valor</strong>", 1);
                    $css->ColTabla("<strong>Tipo de Servicio</strong>", 1);
                    $css->ColTabla("<strong>Finaliza</strong>", 1);
                    $css->ColTabla("<strong>Estado</strong>", 1);
                    $css->ColTabla("<strong>Terminar</strong>", 1);
                $css->CierraFilaTabla();
                
                $sql="SELECT t1.*,t2.NombreArtistico FROM modelos_agenda t1 INNER JOIN modelos_db t2 ON t1.idModelo=t2.ID  "
                        . "  WHERE t1.Estado=0";
                $Consulta=$obCon->Query($sql);
                
                while($DatosAgenda=$obCon->FetchAssoc($Consulta)){
                    $idServicio=$DatosAgenda["ID"];
                    $DatosTipoServicio=$obCon->DevuelveValores("modelos_tipo_servicios", "ID", $DatosAgenda["TipoServicio"]);
                    
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosAgenda["NombreArtistico"], 1);
                        $css->ColTabla(number_format($DatosAgenda["ValorPagado"]), 1);
                        $css->ColTabla($DatosTipoServicio["Servicio"], 1);
                        print("<td>");
                            print("<p name='PHoraIni'>".$DatosAgenda["HoraATerminar"]."</p>");
                        print("</td>");
                        print("<td style='text-align:center'>");
                            print("<div name='Shape' style='background-color:green;color:green;height:20px;width:20px;border-radius:10px;text-align:center'></div>");
                        print("</td>");
                        print("<td>");
                            $css->CrearBotonEvento("btnTerminarServicio", "Terminar", 1, "onclick", "TerminarServicio($idServicio)", "verde", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                       
           $css->CerrarTabla(); 
            
        break; //fin Caso 1
        
        case 2: //dibujar resumen del turno actual
            
           $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Modelo</strong>", 1);
                    $css->ColTabla("<strong>Número de servicios</strong>", 1);
                    $css->ColTabla("<strong>Total Servicios</strong>", 1);
                    $css->ColTabla("<strong>Valor Modelo</strong>", 1);
                    $css->ColTabla("<strong>Valor Casa</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $sql="SELECT * FROM vista_servicio_acompanamiento_turno_actual ";
                        
                $Consulta=$obCon->Query($sql);
                $TotalServicios=0;
                $TotalModelos=0;
                $TotalPagado=0;
                $TotalCasa=0;
                
                while($DatosAgenda=$obCon->FetchAssoc($Consulta)){
                    $TotalServicios=$TotalServicios+$DatosAgenda["NumeroServicios"];    
                    $TotalPagado=$TotalPagado+$DatosAgenda["ValorPagado"];  
                    $TotalModelos=$TotalModelos+$DatosAgenda["ValorModelo"];  
                    $TotalCasa=$TotalCasa+$DatosAgenda["ValorCasa"];  
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosAgenda["NombreArtistico"], 1);
                        $css->ColTabla(number_format($DatosAgenda["NumeroServicios"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["ValorPagado"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["ValorModelo"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["ValorCasa"]), 1);
                        
                    $css->CierraFilaTabla();
                }
                
                $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTALES:</strong>", 1,"R");
                        $css->ColTabla("<strong>".number_format($TotalServicios)."</strong>", 1);
                        $css->ColTabla("<strong>".number_format($TotalPagado)."</strong>", 1);
                        $css->ColTabla("<strong>".number_format($TotalModelos)."</strong>", 1);
                        $css->ColTabla("<strong>".number_format($TotalCasa)."</strong>", 1);
                        
                    $css->CierraFilaTabla();
           $css->CerrarTabla(); 
            
        break; //fin Caso 2
        
        case 3: //dibujar las cuentas x pagar de las modelos
            
           $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>idModelo</strong>", 1);
                    $css->ColTabla("<strong>Nombre Artistico</strong>", 1);
                    $css->ColTabla("<strong>Total Servicios Prestados</strong>", 1);
                    $css->ColTabla("<strong>Total Servicios Pagados</strong>", 1);
                    $css->ColTabla("<strong>Saldo a Pagar</strong>", 1);
                    $css->ColTabla("<strong>Terminar</strong>", 1);
                $css->CierraFilaTabla();
                
                $sql="SELECT * FROM vista_servicio_acompanamiento_cuentas_x_pagar  "
                        . "  WHERE Saldo<>0 ORDER BY NombreArtistico LIMIT 20";
                $Consulta=$obCon->Query($sql);
                
                while($DatosAgenda=$obCon->FetchAssoc($Consulta)){
                    $idModelo=$DatosAgenda["idModelo"];
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosAgenda["idModelo"], 1);
                        $css->ColTabla($DatosAgenda["NombreArtistico"], 1);
                        $css->ColTabla(number_format($DatosAgenda["ValorTotalServiciosPrestados"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["ValorTotalServiciosPagados"]), 1);
                        $css->ColTabla(number_format($DatosAgenda["Saldo"]), 1);
                        
                        print("<td>");
                            $css->CrearBotonEvento("btnPagarModelo", "Pagar", 1, "onclick", "FormularioPagarModelo($idModelo)", "verde", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                       
           $css->CerrarTabla(); 
            
        break; //fin Caso 3
        
        case 4://Formulario para grabar un pago a una modelo
            $idModelo=$obCon->normalizar($_REQUEST["idModelo"]);
            $DatosModelo=$obCon->DevuelveValores("modelos_db", "ID", $idModelo);                 
            $css->CrearTitulo("Realizar pago a la modelo: ".$DatosModelo["NombreArtistico"].", ID: $idModelo", "rojo");
            $css->CrearTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        $css->input("text", "TxtValorPago", "form-control", "TxtValorPago", "Valor Pago", "", "Valor del Pago", "off", "", "");
                    print("</td>");
                    print("<td>");
                        $css->CrearBotonEvento("btnPagar", "Pagar", 1, "onclick", "PagarAModelo($idModelo)", "rojo", "");
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        break;// fin caso 4    
        
    }
    
          
}else{
    print("No se enviaron parametros");
}
?>