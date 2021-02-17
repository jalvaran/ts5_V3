DROP VIEW IF EXISTS `vista_proyectos`;
CREATE VIEW vista_proyectos AS 
        SELECT t1.*,
        
        ((t1.costos_planeacion) - (t1.costos_ejecucion)) as diferencia_costos_planeacion_ejecucion,
        (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=t1.cliente_id) as cliente_razon_social,
        (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=t1.cliente_id) as cliente_nit,
        (SELECT nombre_estado FROM proyectos_estados t2 WHERE t2.ID=t1.estado) as nombre_estado  

        FROM proyectos t1;

DROP VIEW IF EXISTS `vista_proyectos_tareas`;
CREATE VIEW vista_proyectos_tareas AS 
        SELECT t1.*,
        (SELECT nombre FROM proyectos t2 WHERE t2.proyecto_id=t1.proyecto_id) as nombre_proyecto, 
        
        ((t1.costos_planeacion) - (t1.costos_ejecucion)) as diferencia_costos_planeacion_ejecucion,
        
        (SELECT estado_tarea FROM proyectos_tareas_estados t2 WHERE t2.ID=t1.estado) as nombre_estado  

        FROM proyectos_tareas t1;

DROP VIEW IF EXISTS `vista_proyectos_costos`;
CREATE VIEW vista_proyectos_costos AS 
select t1.hora_fijo,t1.tipo_recurso,t1.actividad_id,t1.proyecto_id,t1.tarea_id,
       (SELECT t5.nombre from proyectos t5 where t5.proyecto_id=t1.proyecto_id limit 1) as nombre_proyecto,
       (SELECT t5.titulo_tarea from proyectos_tareas t5 where t5.tarea_id=t1.tarea_id limit 1) as nombre_tarea,
       (SELECT t5.titulo_actividad from proyectos_actividades t5 where t5.actividad_id=t1.actividad_id limit 1) as nombre_actividad,
       (SELECT t4.tipo_recurso FROM proyectos_recursos_tipo t4 WHERE t4.ID=t1.tipo_recurso) as nombre_tipo_recurso,
       (SELECT min(t2.fecha_inicial) FROM proyectos_actividades_eventos t2 WHERE t2.actividad_id=t1.actividad_id  AND estado<=9) as fecha_inicial_planeada,
       (SELECT max(t2.fecha_final) FROM proyectos_actividades_eventos t2 WHERE t2.actividad_id=t1.actividad_id  AND estado<=9) as fecha_final_planeada,
         
       (SELECT IF(t1.hora_fijo=0,(SELECT SUM(horas) FROM proyectos_actividades_eventos t2 WHERE t2.actividad_id=t1.actividad_id  AND estado<=9),1 ) ) as multiplicador_horas_planeacion,
       (SELECT (SUM(t3.costo_unitario_planeacion*t3.cantidad_planeacion))*(SELECT multiplicador_horas_planeacion) from proyectos_actividades_recursos t3 WHERE t3.actividad_id=t1.actividad_id AND t3.tipo_recurso=t1.tipo_recurso) as total_costos_planeacion,
       (SELECT (SUM(t3.precio_venta_total_planeado))*(SELECT multiplicador_horas_planeacion) from proyectos_actividades_recursos t3 WHERE t3.actividad_id=t1.actividad_id AND t3.tipo_recurso=t1.tipo_recurso) as precio_venta_planeado,
       (SELECT ROUND(((SELECT 100/(SELECT total_costos_planeacion) * (SELECT precio_venta_planeado) )-100 ),2)) AS utilidad_planeacion 
       from proyectos_actividades_recursos t1 where estado<=9 group by t1.actividad_id,t1.tarea_id,t1.proyecto_id,t1.hora_fijo,t1.tipo_recurso;