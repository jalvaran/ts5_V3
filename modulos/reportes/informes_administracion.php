<?php
/**
 * Reportes de ventas
 * 2019-02-11, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */
$myPage="informes_adinistracion.php";
$myTitulo="Reporte de Ventas";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");

$css = new PageConstruct($myTitulo, "", "", "");
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);

    $css->CrearDiv("", "col-md-3", "center", 1, 1);       
        $css->fieldset("", "", "FieldFechaInicial", "Fecha Inicial", "", "");
            $css->legend("", "");
                print("<a href='#'>Fecha Inicial</a>");
            $css->Clegend();          
        
            $css->input("date", "FechaInicial", "form-control", "FechaInicial", "Fecha Inicial", date("Y-m-d"), "Fecha Inicial", "NO", "", "style='line-height: 15px;'");
        $css->Cfieldset();
        $css->CerrarDiv();  
        
    $css->CrearDiv("", "col-md-3", "center", 1, 1);       
        $css->fieldset("", "", "FieldFechaFinal", "Fecha Final", "", "");
            $css->legend("", "");
                print("<a href='#'>Fecha Final</a>");
            $css->Clegend();          
        
            $css->input("date", "FechaFinal", "form-control", "FechaFinal", "Fecha Final", date("Y-m-d"), "Fecha Inicial", "NO", "", "style='line-height: 15px;'");
        $css->Cfieldset();
        $css->CerrarDiv();  
    
        $css->CrearDiv("", "col-md-2", "center", 1, 1);
            $css->fieldset("", "", "FieldTipo", "Nivel", "", "");
                $css->legend("", "");
                    print("<a href='#'>Empresa</a>");
                $css->Clegend();
                $css->select("CmbEmpresaPro", "form-control", "CmbEmpresaPro", "", "", "", "");     
                    $css->option("", "", "","ALL", "", "");
                        print("Todas");
                    $css->Coption();
                $Consulta=$obCon->ConsultarTabla("empresapro", "");
                while($DatosPlataformas=$obCon->FetchAssoc($Consulta)){
                    $css->option("", "", "Empresa", $DatosPlataformas["idEmpresaPro"], "", "");
                        print($DatosPlataformas["RazonSocial"]);
                    $css->Coption(); 
                    
                }
                
                $css->Cselect();
            $css->Cfieldset();
        $css->CerrarDiv();
        
        
        $css->CrearDiv("", "col-md-2", "center", 1, 1);
            $css->fieldset("", "", "FieldTipo", "Nivel", "", "");
                $css->legend("", "");
                    print("<a href='#'>Centro de costos</a>");
                $css->Clegend();
                $css->select("CmbCentroCostos", "form-control", "CmbCentroCostos", "", "", "", "");     
                    $css->option("", "", "","ALL", "", "");
                        print("Todos");
                    $css->Coption();
                $Consulta=$obCon->ConsultarTabla("centrocosto", "");
                while($DatosPlataformas=$obCon->FetchAssoc($Consulta)){
                    $css->option("", "", "Centro costos", $DatosPlataformas["ID"], "", "");
                        print($DatosPlataformas["Nombre"]);
                    $css->Coption(); 
                    
                }
                
                $css->Cselect();
            $css->Cfieldset();
        $css->CerrarDiv();
        
        
    $css->CrearDiv("", "col-md-2", "center", 1, 1);       
        $css->fieldset("", "", "FieldFechaInicial", "Fecha Inicial", "", "");
            $css->legend("", "");
                print("<a href='#'>Acciones</a>");
            $css->Clegend();          
        
           $css->CrearBotonEvento("BtnCrearReporte", "Crear PDF", 1, "onclick", "crear_informe_administrador()", "azul", "");
           $css->CrearBotonEvento("BtnCrearReporteExcel", "Crear Excel", 1, "onclick", "crear_informe_administrador_excel()", "verde", "");
        $css->Cfieldset();
        $css->CerrarDiv();  
        
    $css->CrearDiv("DivProceso", "", "center", 1, 1);
    
    $css->CerrarDiv(); 
    print("<br><br><br><br><br>");
        
    $css->CrearDiv("DivReportes", "col-md-12", "center", 1, 1);
    
    $css->CerrarDiv(); 
    
    
$css->PageFin();

//print('<script src="../../general/js/notificaciones.js"></script>');
print('<script src="jsPages/informes_administracion.js"></script>');
$css->AddJSExcel();

$css->Cbody();
$css->Chtml();

?>