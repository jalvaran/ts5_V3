<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
class Proyectos extends ProcesoVenta{
    
    
    function crear_vista_proyectos($db){
        $sql="DROP VIEW IF EXISTS $db.`vista_proyectos`;";
        $this->Query($sql);
        
        $sql="CREATE VIEW $db.vista_proyectos AS 
                SELECT t1.*,
                (t1.costos_mano_obra_planeacion+t1.costos_productos_planeacion+t1.gastos_fijos_planeados) as total_costos_planeacion,
                (t1.costos_mano_obra_ejecucion+t1.costos_productos_ejecucion+t1.gastos_fijos_ejecutados) as total_costos_ejecucion,
                ((select total_costos_planeacion) - (select total_costos_ejecucion)) as diferencia_costos_planeacion_ejecucion,
                (SELECT RazonSocial FROM $db.clientes t2 WHERE t2.idClientes=t1.cliente_id) as cliente_razon_social,
                (SELECT Num_Identificacion FROM $db.clientes t2 WHERE t2.idClientes=t1.cliente_id) as cliente_nit,
                (SELECT nombre_estado FROM $db.proyectos_estados t2 WHERE t2.ID=t1.estado) as nombre_estado  
                    
                FROM $db.proyectos t1
                ;
                    
           ";
        $this->Query($sql);
        
    }
    
    public function agregar_fecha_excluida($db,$proyecto_id,$fecha_excluida){
        $Datos["proyecto_id"]=$proyecto_id;
        $Datos["fecha_excluida"]=$fecha_excluida;
        $sql=$this->getSQLInsert("$db.proyectos_fechas_excluidas", $Datos);
        $this->Query($sql);
    }
    
    public function crear_editar_proyecto($db,$datos_proyecto){
        $proyecto_id=$datos_proyecto["proyecto_id"];
        $Tabla="$db.proyectos";
        $sql="SELECT ID FROM $Tabla WHERE proyecto_id='$proyecto_id'";
        $valida=$this->FetchAssoc($this->Query($sql));
        if($valida["ID"]>0){
            $sql=$this->getSQLUpdate($Tabla, $datos_proyecto);
            $sql.=" WHERE proyecto_id='$proyecto_id'";
        }else{
            $sql=$this->getSQLInsert($Tabla, $datos_proyecto);
        }
        $this->Query($sql);
    }
    
    public function RegistreAdjuntoProyecto($db,$proyecto_id, $destino, $Tamano, $NombreArchivo, $Extension, $idUser) {
        
        $tab="$db.proyectos_adjuntos";
        
        $Datos["proyecto_id"]=$proyecto_id;
        
        $Datos["Ruta"]=$destino;    
        $Datos["NombreArchivo"]=$NombreArchivo;    
        $Datos["Extension"]=$Extension;    
        $Datos["Tamano"]=$Tamano; 
        $Datos["idUser"]=$idUser;		
        $Datos["created"]=date("Y-m-d H:i:s");	
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
    }
    /**
     * Fin Clase
     */
}
