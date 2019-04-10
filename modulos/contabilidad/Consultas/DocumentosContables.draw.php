<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
include_once("../../../modelo/php_conexion.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new conexion($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //Crea un formulario para el registro de un nuevo documento
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", "");
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "Field", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFecha", "form-control", "TxtFecha", "", date("Y-m-d"), "Fecha", "off", "", "style='line-height: 15px;'");
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tipo de Documento</a>");
                    $css->Clegend();           
                    $css->select("CmbTipoDocumento", "form-control", "CmbTipoDocumento", "", "", "", "");
                    
                    $Consulta=$obCon->ConsultarTabla("documentos_contables", "");
                    while($DatosDocumentos=$obCon->FetchAssoc($Consulta)){
                        $css->option("", "", "", $DatosDocumentos["ID"], "", "");
                            print($DatosDocumentos["Prefijo"]." ".$DatosDocumentos["Nombre"]);
                        
                        $css->Coption();
                    }
                $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa:</a>");
                    $css->Clegend();           
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "style=width:100%");
                        $sql="SELECT * FROM empresapro ";
                        $consulta=$obCon->Query($sql);
                        
                        while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosCuenta["idEmpresaPro"], "", "");
                                print($DatosCuenta["idEmpresaPro"]." ".$DatosCuenta["RazonSocial"]." ".$DatosCuenta["NIT"]);
                            $css->Coption();
                        }
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Sucursal:</a>");
                    $css->Clegend();           
                    $css->select("CmbSucursal", "form-control", "CmbSucursal", "", "", "", "style=width:100%");
                        $sql="SELECT * FROM empresa_pro_sucursales ";
                        $consulta=$obCon->Query($sql);
                        
                        while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosCuenta["ID"], "", "");
                                print($DatosCuenta["Nombre"]);
                            $css->Coption();
                        }
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Costos:</a>");
                    $css->Clegend();           
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "style=width:100%");
                        $sql="SELECT * FROM centrocosto ";
                        $consulta=$obCon->Query($sql);
                        
                        while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                            $css->option("", "", "", $DatosCuenta["ID"], "", "");
                                print($DatosCuenta["Nombre"]);
                            $css->Coption();
                        }
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
                 print("<br><br><br><br><br>");       
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Prestamo", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Observaciones</a>");
                    $css->Clegend();           
                        $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "Observaciones", "Observaciones", "", "");
                        $css->Ctextarea();
                    $css->Cfieldset();
            $css->CerrarDiv();
            
            
            print("<br><br><br><br><br><br><br><br><br>");
            
        break; //Fin caso 1
    
        case 2://Formulario para editar un documento
            $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
            $DatosDocumentoGeneral=$obCon->DevuelveValores("documentos_contables_control", "ID", $idDocumento);
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 2, "", "", "", "");
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "Field", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Fecha</a>");
                    $css->Clegend();           
                    $css->input("date", "TxtFecha", "form-control", "TxtFecha", "", $DatosDocumentoGeneral["Fecha"], "Fecha", "off", "", "style='line-height: 15px;'");
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tipo de Documento</a>");
                    $css->Clegend();           
                    $css->select("CmbTipoDocumento", "form-control", "CmbTipoDocumento", "", "", "", "disabled");
                    
                    $Consulta=$obCon->ConsultarTabla("documentos_contables", "");
                    while($DatosDocumentos=$obCon->FetchAssoc($Consulta)){
                        $Sel=0;
                        if($DatosDocumentoGeneral["idDocumento"]==$DatosDocumentos["ID"]){
                            $Sel=1;
                        }
                        
                        $css->option("", "", "", $DatosDocumentos["ID"], "", "",$Sel);
                            print($DatosDocumentos["Prefijo"]." ".$DatosDocumentos["Nombre"]);                        
                        $css->Coption();
                    }
                $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Empresa:</a>");
                    $css->Clegend();           
                    $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "style=width:100%");
                        $sql="SELECT * FROM empresapro ";
                        $consulta=$obCon->Query($sql);
                        
                        while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                            $Sel=0;
                            if($DatosDocumentoGeneral["idEmpresa"]==$DatosCuenta["idEmpresa"]){
                                $Sel=1;
                            }
                            $css->option("", "", "", $DatosCuenta["idEmpresaPro"], "", "",$Sel);
                                print($DatosCuenta["idEmpresaPro"]." ".$DatosCuenta["RazonSocial"]." ".$DatosCuenta["NIT"]);
                            $css->Coption();
                        }
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Sucursal:</a>");
                    $css->Clegend();           
                    $css->select("CmbSucursal", "form-control", "CmbSucursal", "", "", "", "style=width:100%");
                        $sql="SELECT * FROM empresa_pro_sucursales ";
                        $consulta=$obCon->Query($sql);
                        
                        while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                            $Sel=0;
                            if($DatosDocumentoGeneral["idSucursal"]==$DatosCuenta["idSucursal"]){
                                $Sel=1;
                            }
                            $css->option("", "", "", $DatosCuenta["ID"], "", "",$Sel);
                                print($DatosCuenta["Nombre"]);
                            $css->Coption();
                        }
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Documento", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Costos:</a>");
                    $css->Clegend();           
                    $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "style=width:100%");
                        $sql="SELECT * FROM centrocosto ";
                        $consulta=$obCon->Query($sql);
                        
                        while($DatosCuenta=$obCon->FetchAssoc($consulta)){
                            $Sel=0;
                            if($DatosDocumentoGeneral["idCentroCostos"]==$DatosCuenta["idCentroCostos"]){
                                $Sel=1;
                            }
                            $css->option("", "", "", $DatosCuenta["ID"], "", "");
                                print($DatosCuenta["Nombre"]);
                            $css->Coption();
                        }
                        
                    $css->Cselect();
                $css->Cfieldset();
            $css->CerrarDiv();
                 print("<br><br><br><br><br>");       
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                $css->fieldset("", "", "FieldPrestamos", "Prestamo", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Observaciones</a>");
                    $css->Clegend();           
                        $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "Observaciones", "Observaciones", "", "");
                        print($DatosDocumentoGeneral["Descripcion"]);
                        $css->Ctextarea();
                    $css->Cfieldset();
            $css->CerrarDiv();
            
            
            print("<br><br><br><br><br><br><br><br><br>");
        break;//Fin caso 2
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>