<?php

$css->CrearDiv("", "col-md-10", "left", 1, 1); 
        $css->h3("", "", "", "");
                print("<strong>Documentos Contables</strong>");
        $css->Ch3();
    $css->CerrarDiv(); 
    $css->CrearDiv("", "col-md-2", "right", 1, 1); 
        $css->h3("", "", "", "");
            print("<a onclick=MuestraOcultaXID('DivOpcionesGenerales') style='cursor:pointer'><strong>Opciones</strong>");
            print('<i class="fa fa-fw fa-bars"></i></a>');
                
        $css->Ch3();
    $css->CerrarDiv(); 
    $css->CrearDiv("DivOpcionesGenerales", "col-md-12", "left", 0, 0);
        $css->fieldset("", "", "FieldDatosCotizacion", "DatosCotizacion", "", "");
            $css->legend("", "");
                print("<a href='#'>Opciones Adicionales:</a>");
            $css->Clegend();   
            $css->CrearDiv("", "col-md-3", "left", 1, 1);
                $css->CrearBotonEvento("BtnCrearTercero", "Crear Tercero", 1, "onclick", "ModalCrearTercero(`ModalAcciones`,`DivFrmModalAcciones`);", "azul", "");
                
                
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "left", 1, 1);
                $css->CrearBotonEvento("BtnHistorialDocumentos", "Historial de Documentos", 1, "onclick", "SeleccioneTablaDB(`vista_documentos_contables`);", "azul", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "left", 1, 1);
                $css->select("CmbTipoDocumentoAcciones", "form-control", "CmbTipoDocumentoAcciones", "", "", "", "");
                    
                    $Consulta=$obCon->ConsultarTabla("documentos_contables", "");
                    while($DatosDocumentos=$obCon->FetchAssoc($Consulta)){
                        $css->option("", "", "", $DatosDocumentos["ID"], "", "");
                            print($DatosDocumentos["Prefijo"]." ".$DatosDocumentos["Nombre"]);
                        
                        $css->Coption();
                    }
                $css->Cselect();
                
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "left", 1, 1);
            
            print('<div class="input-group input-group-md">
                <input type="text" id="idDocumentoAcciones" class="form-control" placeholder="id Documento">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >Acción
                    <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu">
                    
                        <li><a href="#" onclick="CopiarDocumento()">Copiar</a></li>
                        
                    
                  </ul>
                </div>
               
              </div>');
            
                
            $css->CerrarDiv();
            
        $css->Cfieldset();
        print("<br><br>");
    $css->CerrarDiv();  
    $css->CrearDiv("DivOpcionesCrear", "col-md-12", "left", 1, 1); 
    $css->CrearDiv("DivMensajesModulo", "", "center", 1, 1); 
    $css->CerrarDiv();  
    
        $css->fieldset("", "", "FieldDatos", "Datos", "", "");
            $css->legend("", "");
                print("<a href='#'>Cree, Seleccione un documento</a>");
            $css->Clegend();   
            
        $css->CrearDiv("DivBtnCrear", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnNuevo", "Crear Documento", 1, "onClick", "AbrirModalNuevoDocumento()", "azul", "");
        $css->CerrarDiv();
        $css->CrearDiv("DivDatosDocumento", "col-md-8", "left", 1, 1); 
            $css->select("idDocumento", "form-control", "idDocumento", "", "", "onchange=DibujeDocumento()", "");
            $css->option("", "", "","", "", "");
                print("Seleccione un Documento");
            $css->Coption();
            $consulta = $obCon->ConsultarTabla("vista_documentos_contables","WHERE Estado='ABIERTO'");
            while($DatosDocumento=$obCon->FetchArray($consulta)){
                
                
                $css->option("", "", "", $DatosDocumento['ID'], "", "");
                    print($DatosDocumento['Fecha']." ".$DatosDocumento['Prefijo']." ".$DatosDocumento["Nombre"]." ".$DatosDocumento["Consecutivo"]." ".$DatosDocumento["Descripcion"]);
                $css->Coption();
            }
            $css->Cselect();
           
        $css->CerrarDiv();
        $css->CrearDiv("DivBtnEditar", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnEditar", "Editar Datos", 0, "onClick", "AbrirModalNuevoDocumento('Editar')", "azul", "");
        $css->CerrarDiv();
        
        $css->Cfieldset(); 
    $css->CerrarDiv();
    print("<br><br><br><br><br><br><br><br><br>");
    $css->CrearDiv("DivDatos", "col-md-12", "left", 1, 1); //Datos para la creacion del documento
        $css->fieldset("", "", "FieldDatos", "Datos", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Agregar Conceptos</a>");
                    $css->Clegend();    
        $css->CrearDiv("DivAgregarItems", "", "center", 1, 1);   
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->select("CuentaPUC", "form-control", "CuentaPUC", "Cuenta PUC<br>", "", "", "");
                    $css->option("", "", "", "", "", "");
                        print("Seleccione una Cuenta");
                    $css->Coption();
                    
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                $css->select("Tercero", "form-control", "Tercero", "Tercero<br>", "", "", "style=width:100%");
                   
                    $css->option("", "", "", "", "", "");
                        print("Tercero");
                    $css->Coption();
                    
                    
                $css->Cselect();
            $css->CerrarDiv();            
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                print("<strong>Concepto</strong><br>");
                $css->textarea("TxtConcepto", "form-control", "TxtConcepto", "<strong>Concepto</strong>", "Concepto", "", "");
                $css->Ctextarea();
            $css->CerrarDiv();  
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
            
                $css->select("TipoMovimiento", "form-control", "TipoMovimiento", "Movimiento<br>", "", "", "");
                    
                    $css->option("", "", "", "DB", "", "");
                        print("Débito");
                    $css->Coption();
                    
                    $css->option("", "", "", "CR", "", "");
                        print("Crédito");
                    $css->Coption();
                    
                    
                $css->Cselect();
             $css->input("text", "TxtDocReferencia", "form-control", "TxtDocReferencia", "", "", "Doc. Referencia", "", "", "");   
             $css->CerrarDiv();  
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
               $css->CrearDiv("DivBases", "", "", 0, 1);
               $css->input("hidden", "TxtSolicitaBase", "form-control", "TxtSolicitaBase", "", "", "", "", "", "");

                
                print("<strong>Porcentaje %</strong>");
                $css->input("text", "Porcentaje", "form-control", "Porcentaje", "Porcentaje", "0", "Porcentaje", "off", "", "onkeyup=CalculeBase()");
            
                print("<strong>Base</strong>");
                $css->input("text", "Base", "form-control", "Base", "Base", "0", "Base", "off", "", "onkeyup=CalculeBase()");


                
               $css->Cdiv();
               print("<strong>Valor</strong>");
               $css->input("number", "Valor", "form-control", "Valor", "Valor", "", "Valor", "off", "", "");
            
                
                $css->CrearBotonEvento("BtnAgregarItem", "Agregar", 1, "onClick", "AgregarItem()", "verde", "");
            $css->CerrarDiv();
            
        
        $css->CerrarDiv();       
            $css->Cfieldset();
    $css->CerrarDiv();
    //$css->CerrarDiv();

    print("<br><br><br><br><br><br><br><br>");
    $css->CrearDiv("DivDatosDocumento", "col-md-9", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosDocumento", "Movimiento agregados", "", "");
            $css->legend("", "");
                print("<a href='#'>Movimientos Agregados</a>");
            $css->Clegend();    
            $css->CrearDiv("DivItems", "", "center", 1, 1,"","height: 400px;overflow: auto;");   

            $css->CerrarDiv();       
        $css->Cfieldset();
        $css->CerrarDiv();
        
        $css->CrearDiv("DivInfoTotales", "col-md-3", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosDocumento", "Totales", "", "");
            $css->legend("", "");
                print("<a href='#'>Totales</a>");
            $css->Clegend();    
           
            $css->CrearDiv("DivTotales", "", "center", 1, 1);   
                
            $css->CerrarDiv(); 
        $css->Cfieldset();    
    //$css->CerrarDiv();
    //$css->CerrarDiv();
    
    $css->Cdiv();