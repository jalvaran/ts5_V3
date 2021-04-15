<?php
/**
 * Pagina para la creacion de compras 
 * 2018-11-27, Julian Alvaran Techno Soluciones SAS
 */
$myPage="documentos_equivalentes.php";
$myTitulo="Documento Equivalente";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");
$css =  new PageConstruct($myTitulo, ""); //objeto con las funciones del html
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
    
        
    $css->Modal("ModalAcciones", "TS5", "", 1);
        $css->div("DivFrmModalAcciones", "", "", "", "", "", "");
        $css->Cdiv();
        
    $css->CModal("BntModalAcciones", "onclick=SeleccioneAccionFormularios()", "button", "Guardar");
    
    $css->CrearDiv("", "col-md-10", "left", 1, 1); 
        $css->h3("", "", "", "");
                print("<strong>Documentos Equivalentes</strong>");
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
                $css->CrearBotonEvento("BtnHistorialDocumentos", "Historial de Documentos", 1, "onclick", "SeleccioneTablaDB(`vista_documentos_equivalentes`);", "azul", "");
            $css->CerrarDiv();
            
            
        $css->Cfieldset();
        print("<br><br>");
    $css->CerrarDiv();  
    $css->CrearDiv("DivOpcionesCrear", "col-md-12", "left", 1, 1); 
    $css->CrearDiv("DivMensajesModulo", "", "center", 1, 1); 
    $css->CerrarDiv();  
    
        $css->fieldset("", "", "FieldDatos", "Datos", "", "");
            $css->legend("", "");
                print("<a href='#'>Cree, Seleccione un documento equivalente</a>");
            $css->Clegend();   
            
        $css->CrearDiv("DivBtnCrear", "col-md-2", "left", 1, 1); 
            $css->CrearBotonEvento("BtnNuevo", "Crear Documento", 1, "onClick", "AbrirModalNuevoDocumento()", "azul", "");
        $css->CerrarDiv();
        $css->CrearDiv("DivDatosDocumento", "col-md-8", "left", 1, 1); 
            $css->select("idDocumento", "form-control", "idDocumento", "", "", "onchange=DibujeDocumento()", "");
            $css->option("", "", "","", "", "");
                print("Seleccione un Documento");
            $css->Coption();
            $consulta = $obCon->ConsultarTabla("vista_documentos_equivalentes","WHERE Estado='1'");
            while($DatosDocumento=$obCon->FetchArray($consulta)){
                
                
                $css->option("", "", "", $DatosDocumento['ID'], "", "");
                    print($DatosDocumento['ID']." || ".$DatosDocumento['fecha']." || ".$DatosDocumento['tercero_razon_social']." || ".$DatosDocumento["tercero_id"]);
                $css->Coption();
            }
            $css->Cselect();
           
        $css->CerrarDiv();
        $css->CrearDiv("DivBtnEditar", "col-md-2", "left", 1, 1); 
            //$css->CrearBotonEvento("BtnEditar", "Editar Datos", 0, "onClick", "AbrirModalNuevoDocumento('Editar')", "azul", "");
        $css->CerrarDiv();
        
        $css->Cfieldset(); 
    $css->CerrarDiv();
    

    print("<br><br><br><br><br><br><br><br>");
    $css->CrearDiv("DivDatosDocumento", "col-md-12", "left", 1, 1); //Datos para la creacion de la compra
        $css->fieldset("", "", "FieldDatosDocumento", "", "", "");
            $css->legend("", "");
                print("<a href='#'>Documento Equivalente</a>");
            $css->Clegend();    
            $css->CrearDiv("div_documento_equivalente", "", "center", 1, 1,"","");   

            $css->CerrarDiv();       
        $css->Cfieldset();
        $css->CerrarDiv();
            
    $css->Cdiv();

$css->PageFin();

print('<script src="jsPages/documentos_equivalentes.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>