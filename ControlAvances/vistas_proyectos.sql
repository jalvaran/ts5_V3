DROP VIEW IF EXISTS `vista_proyectos`;
CREATE VIEW vista_proyectos AS 
        SELECT t1.*,
        (t1.costos_mano_obra_planeacion+t1.costos_productos_planeacion+t1.gastos_fijos_planeados) as total_costos_planeacion,
        (t1.costos_mano_obra_ejecucion+t1.costos_productos_ejecucion+t1.gastos_fijos_ejecutados) as total_costos_ejecucion,
        ((select total_costos_planeacion) - (select total_costos_ejecucion)) as diferencia_costos_planeacion_ejecucion,
        (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=t1.cliente_id) as cliente_razon_social,
        (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=t1.cliente_id) as cliente_nit,
        (SELECT nombre_estado FROM proyectos_estados t2 WHERE t2.ID=t1.estado) as nombre_estado  

        FROM proyectos t1;

DROP VIEW IF EXISTS `vista_proyectos_tareas`;
CREATE VIEW vista_proyectos_tareas AS 
        SELECT t1.*,
        (SELECT nombre FROM proyectos t2 WHERE t2.proyecto_id=t1.proyecto_id) as nombre_proyecto, 
        (t1.costos_mano_obra_planeacion+t1.costos_productos_planeacion+t1.gastos_fijos_planeados) as total_costos_planeacion,
        (t1.costos_mano_obra_ejecucion+t1.costos_productos_ejecucion+t1.gastos_fijos_ejecutados) as total_costos_ejecucion,
        ((select total_costos_planeacion) - (select total_costos_ejecucion)) as diferencia_costos_planeacion_ejecucion,
        
        (SELECT estado_tarea FROM proyectos_tareas_estados t2 WHERE t2.ID=t1.estado) as nombre_estado  

        FROM proyectos_tareas t1;