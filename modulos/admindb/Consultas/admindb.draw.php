<?php

session_start();
if (!isset($_SESSION['username'])){// valida que el usuario tenga alguna sesion iniciada 
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];// se crea una variable iduser para saber almacenar que usuario esta tabajando

include_once("../clases/admindb.class.php");// se debe incluir la clase del modolo 
include_once("../../../constructores/paginas_constructor.php");// siempre debera de ir ya que utilizara html que esta en el constructor

if(!empty($_REQUEST["Accion"]) ){// se verifica si el indicce accion es diferente a vacio 
    
    $css =  new PageConstruct("", "", 1, "", 1, 0);// se instancia para poder utilizar el html
    $obCon = new AdminDataBase($idUser);// se instancia para poder conectarse con la base de datos 
    
    switch($_REQUEST["Accion"]) {
        case 1://listar las tablas de una base de datos
            
            $DataBase=$obCon->normalizar($_REQUEST["cmbDataBase"]);// la funcion normalizar lo que haces es verificar que el contenido no lleve instrucciones para hacer daños en la base de datos 
            $sql="SELECT table_name, table_rows
                FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '$DataBase';";
            $Consulta=$obCon->Query($sql);
            
            while($DatosTablas=$obCon->FetchAssoc($Consulta)){
                $tabla=$DatosTablas["table_name"];
                print("<a href='#'  target='_self' onclick=page=1;muestraRegistros(`$tabla`) >");
                print($DatosTablas["table_name"]."</a><br>");
            }
            
        break;//fin caso 1  
        
       ////////////////////////////////////////////////////////////////////////////////////////////////// 
        
        case 2://muestra los regitros de una tabla especifica de la base de datos seleccionada en el caso 1
            
            $DataBase=$obCon->normalizar($_REQUEST["cmbDataBase"]);// la funcion normalizar lo que haces es verificar que el contenido no lleve instrucciones para hacer daños en la base de datos 
            $TableDataBase=$obCon->normalizar($_REQUEST["tableDataBase"]);// la funcion normalizar lo que haces es verificar que el contenido no lleve instrucciones para hacer daños en la base de datos 
            
            $Limit=$obCon->normalizar($_REQUEST["limit"]);
            $Page=$obCon->normalizar($_REQUEST["page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            
            $Condicion="";
            
            if($Busqueda<>''){
                $Columnas=$obCon->ShowColums($TableDataBase); //muestra las columnas de la tabla
                $Condicion=" WHERE ";
                foreach ($Columnas["Field"] as $key => $value) { // recorre el array que tiene las columnas de la tabla
                    
                    $Condicion.="`".$value."` LIKE '%$Busqueda%' OR"; // arma la condicion para la consulta teniendo en cuenta todas las columnas de la tabla
                }
                $Condicion= substr($Condicion,0, -2); // le elimina los dos ultimos caracteres a la condicion
                
            }
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            
            $sql="SELECT * FROM  $DataBase.$TableDataBase $Condicion LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            $css->input("hidden", "TxtTableName", "", "", "", $TableDataBase, "", "", "", "","disabled");
            $css->CrearTitulo($TableDataBase, "verde");
            
            $css->CrearTabla();
                
            $Columnas=$obCon->ShowColums("$DataBase.$TableDataBase");
            
            $css->FilaTabla(16);
                foreach ($Columnas["Field"] as $key => $value) {
                    $css->ColTabla("<strong>".$value."</strong>", 1, "C");
                }

            $css->CierraFilaTabla();

            
                while($RegistrosTabla=$obCon->FetchAssoc($Consulta)){
                    
                    $css->FilaTabla(16);
                    foreach ($RegistrosTabla as $key => $value) {
                        $css->ColTabla(utf8_encode($value), 1, "L");
                    }
                      
                    $css->CierraFilaTabla();
                    
                }
            
            $css->CerrarTabla();
            
        break;//fin caso 2
        
        case 3: // dibujar el paginador
            $DataBase=$obCon->normalizar($_REQUEST["cmbDataBase"]);
            $Table=$obCon->normalizar($_REQUEST["tableDataBase"]);
            $Limit=$obCon->normalizar($_REQUEST["limit"]);
            $Page=$obCon->normalizar($_REQUEST["page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            
            $Condicion="";
            if($Busqueda<>''){// si hay una busqueda
                $Columnas=$obCon->ShowColums($Table); //muestra las columnas de la tabla
                $Condicion=" WHERE ";
                foreach ($Columnas["Field"] as $key => $value) { // recorre el array que tiene las columnas de la tabla
                    
                    $Condicion.="`".$value."` LIKE '%$Busqueda%' OR"; // arma la condicion para la consulta teniendo en cuenta todas las columnas de la tabla
                }
                $Condicion= substr($Condicion,0, -2); // le elimina los dos ultimos caracteres a la condicion
                
            }
            $sql="SELECT COUNT(*) AS Total FROM `$DataBase`.`$Table` $Condicion; ";
            $Totales=$obCon->FetchAssoc($obCon->Query($sql));
            $RegistrosTotales=$Totales["Total"];
            $TotalPaginas= ceil($RegistrosTotales/$Limit);
            
            if($RegistrosTotales>0){           
            
                print('  
                <div class="row">
                        <div class="col-md-5">
                           <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                               Página '.$Page.' de '.$TotalPaginas.'<br> Total de Registros: '.number_format($RegistrosTotales).'
                           </div>
                        </div>
                        <div class="col-md-7">
                           <div class="box-tools pull-right" >
                           <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                               <ul class="pagination">');
                               
                               if($Page>1){
                                   
                              
                                    print('  
                                        <li class="paginate_button next " id="example2_next" >
                                            <a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Inicio</a>
                                        </li>
                                        <li class="paginate_button previous " id="example2_previous" >
                                            <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" onclick="DisminuirPagina(`'.$Table.'`)">Anterior</a>
                                        </li>');
                                    }
                                       print('<li class="paginate_button active">
                                           <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" onclick="page=`'.$Page.'`;muestraRegistros(`'.$Table.'`)">'.$Page.'</a>
                                       </li>');
                                       if(($Page+1)<=$TotalPaginas){
                                            print('<li class="paginate_button">
                                                <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" onclick="page=`'.($Page+1).'`;muestraRegistros(`'.$Table.'`)">'.($Page+1).'</a>
                                            </li>');
                                       }
                                       if(($Page+2)<=$TotalPaginas){
                                       print('<li class="paginate_button">
                                           <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" onclick="page=`'.($Page+2).'`;muestraRegistros(`'.$Table.'`)">'.($Page+2).'</a>
                                       </li>');
                                       }
                                       if(($Page+3)<=$TotalPaginas){
                                       print('<li class="paginate_button">
                                           <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" onclick="page=`'.($Page+3).'`;muestraRegistros(`'.$Table.'`)">'.($Page+3).'</a>
                                       </li>');
                                       }
                                   
                                   if($Page<$TotalPaginas){
                                        print(' 
                                        <li class="paginate_button next " id="example2_next">
                                            <a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" onclick="AumentarPagina(`'.$Table.'`)">Siguiente</a>
                                        </li>
                                        <li class="paginate_button next" id="example2_next">
                                            <a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Ultimo</a>
                                        </li>');
                                   }
                                   print('   
                               </ul>
                           </div>
                        </div>
                            </div>
                     </div>
                ');
            }           
        break; //fin caso 3    
        
        case 4:// formulario para nuevo registro
            
            
            $css->div("div", "col-md-4", "", "", "", "", "");
                $css->input("date", "Fecha", "form-control", "Fecha", "Fecha", "", "Fecha", "off", "", "");
            $css->Cdiv();
            $css->div("div", "col-md-4", "", "", "", "", "");
                $css->input("number", "Cantidad", "form-control", "Cantidad", "Cantidad", "", "Cantidad", "off", "", "");
            $css->Cdiv();
            $css->div("div", "col-md-4", "", "", "", "", "");
                $css->input("number", "idLibroDiario", "form-control", "idLibroDiario", "idLibroDiario", "", "idLibroDiario", "off", "", "");
            $css->Cdiv();
            $css->div("div", "col-md-4", "", "", "", "", "");
                $css->input("number", "idComprobanteContable", "form-control", "idComprobanteContable", "idComprobanteContable", "", "idComprobanteContable", "off", "", "");
            $css->Cdiv();
            $css->div("div", "col-md-4", "", "", "", "", "");
                $css->input("text", "TipoAbono", "form-control", "TipoAbono", "TipoAbono", "", "TipoAbono", "off", "", "");
            $css->Cdiv();
            
            $css->CrearBotonEvento("BtnGuardar", "Guardar", 1, "onclick", "InsertarDatos()", "rojo");
            
        break;// fin caso 4    
        
 }
    
          
}else{
    print("No se enviaron parametros");
}
?>