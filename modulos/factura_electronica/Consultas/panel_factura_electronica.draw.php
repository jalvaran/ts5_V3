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
        case 1: //Dibuja el tablero de facturas electronicas
            
            $sql="SELECT COUNT(ID) as Total FROM facturas_electronicas_log WHERE Estado=1";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalEmitidos=$DatosTotales["Total"];
            
            $sql="SELECT COUNT(ID) as Total FROM facturas_electronicas_log WHERE Estado>=10 AND Estado<20";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalErrores=$DatosTotales["Total"];
            
            $sql="SELECT COUNT(ID) as Total FROM facturas_electronicas_log WHERE Estado>=20 AND Estado<30";
            $DatosTotales=$obCon->FetchArray($obCon->Query($sql));            
            $TotalPendientes=$DatosTotales["Total"];
            
            $TotalRecibidos=0;
                    
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-send"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Enviados</span>
                      <span class="info-box-number">'.number_format($TotalEmitidos).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Doc. Emitidos
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-inbox"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Recibidos</span>
                      <span class="info-box-number">'.number_format($TotalRecibidos).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Doc. Recibidos
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Pendientes</span>
                      <span class="info-box-number">'.number_format($TotalPendientes).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Doc. Pendientes
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print('<div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-warning"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Errores</span>
                      <span class="info-box-number">'.number_format($TotalErrores).'</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                      </div>
                      <span class="progress-description">
                            Doc. con errores
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>');
            $css->CerrarDiv();
        break; //Fin caso 1
        
           
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>