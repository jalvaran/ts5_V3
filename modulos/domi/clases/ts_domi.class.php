<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
class Domi extends ProcesoVenta{
    
        
    public function RegistreFondoLocal($DatosServidor,$idLocal,$destino,$Tamano, $NombreArchivo, $Extension, $idUser) {
        
        $tab="locales_imagenes";
        
        $Datos["idLocal"]=$idLocal;
        
        $Datos["Ruta"]=$destino;    
        $Datos["NombreArchivo"]=$NombreArchivo;    
        $Datos["Extension"]=$Extension;    
        $Datos["Tamano"]=$Tamano; 
        $Datos["idUser"]=$idUser;		
        $Datos["Created"]=date("Y-m-d H:i:s");	
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
    }
    
    public function RegistreImagenProducto($DatosServidor,$idProducto,$destino,$Tamano, $NombreArchivo, $Extension, $idUser) {
        
        $tab="productos_servicios_imagenes";
        
        $Datos["idProducto"]=$idProducto;
        
        $Datos["Ruta"]=$destino;    
        $Datos["NombreArchivo"]=$NombreArchivo;    
        $Datos["Extension"]=$Extension;    
        $Datos["Tamano"]=$Tamano; 
        $Datos["idUser"]=$idUser;		
        $Datos["Created"]=date("Y-m-d H:i:s");	
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->QueryExterno($sql, $DatosServidor["IP"], $DatosServidor["Usuario"], $DatosServidor["Password"], $DatosServidor["DataBase"], "");
    }
    
   
   
    /**
     * Fin Clase
     */
}
