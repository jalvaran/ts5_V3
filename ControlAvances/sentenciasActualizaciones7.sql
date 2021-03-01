ALTER TABLE `empresapro` ADD `db` VARCHAR(100) NOT NULL DEFAULT 'ts5' AFTER `TokenAPIFE`;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(38,	'ruta para los soportes de los proyectos',	'../../../SoportesTS5/',	'2019-07-25 09:59:30',	'2020-07-25 09:59:30');

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(42,	'INFORME GERENCIAL DE PROYECTOS',	'001',	'F-GC-004',	'2021-02-16',	'<br>A continuación encontrará un resumen de todos los aspectos relacionados con el proyecto <strong>@nombre_proyecto</strong>, donde evidenciará información muy relevante para la toma de decisiones y/o tener una idea de cuanto debe facturar para no tener pérdidas, debe tener en cuenta que la información presentada está basada en los datos que se ingresaron en el calendario del proyecto.',	'<br> esperamos que la información suministrada haya sido util para la realización de su proyecto, y que sea aprovechada al máximo para que pueda obtener la mayor utilidad posible.',	'2021-02-17 10:43:25',	'2020-07-25 10:03:57');

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(17,	'../modulos/proyectos/',	'2020-07-25 10:05:02',	'2020-07-25 10:05:02');

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `CSS_Clase`, `Orden`, `Updated`, `Sync`) VALUES
(34,	'Proyectos',	1,	'MnuProyectos.php',	'_BLANK',	1,	'proyectos.png',	'fa fa-share',	17,	'2020-07-25 10:05:00',	'2020-07-25 10:05:00');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(53,	'Proyectos',	34,	1,	CONV('1', 2, 10) + 0,	'2019-07-25 10:05:02',	'2020-07-25 10:05:02');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(208,	'Gestión de Proyectos',	53,	17,	0,	'vista_proyectos',	1,	'onclick=\"SeleccioneTablaDB(`vista_proyectos`)\";',	'proyectos.php',	'_SELF',	1,	'proyectos.png',	1,	'2019-07-25 10:05:03',	'2020-07-25 10:05:03');

CREATE TABLE `proyectos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo',
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico del proyecto',
  `cliente_id` int(11) NOT NULL COMMENT 'id del cliente asociado al proyecto',
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del Proyecto',
  `fecha_inicio_planeacion` datetime NOT NULL COMMENT 'Fecha de inicio planeada',
  `fecha_inicio_ejecucion` datetime NOT NULL COMMENT 'Fecha de inicio ejecutada',
  `fecha_final_planeacion` datetime NOT NULL COMMENT 'Fecha final planeada',
  `fecha_final_ejecucion` datetime NOT NULL COMMENT 'Fecha final ejecutada',
  `total_horas_planeadas` double NOT NULL COMMENT 'total de horas planeadas para este proyecto',
  `total_horas_ejecutadas` double NOT NULL COMMENT 'total de horas ejecutadas para este proyecto',
  `costos_planeacion` double NOT NULL COMMENT 'Costos y gastos planeados',
  `costos_ejecucion` double NOT NULL COMMENT 'Costos y gastos ejecutados',
  `valor_facturar` double NOT NULL COMMENT 'valor a facturar segun modulo',
  `valor_facturado` double NOT NULL COMMENT 'valor facturado',
  `utilidad_planeada` double NOT NULL COMMENT 'utilidad planeada',
  `utilidad_ejecutada` double NOT NULL COMMENT 'utilidad ejecutada',
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT 'estado del proyecto',
  `usuario_id` int(11) NOT NULL COMMENT 'usuario que crea el proyecto',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de creacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'ultima actualizacion',
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `proyecto_id` (`proyecto_id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `estado` (`estado`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_actividades` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo',
  `actividad_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico de la actividad',
  `tarea_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico de la tarea relacionada',
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico del proyecto relacionado',
  `titulo_actividad` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de la actividad',
  `fecha_inicio_planeacion` datetime NOT NULL COMMENT 'Fecha de inicio planeada',
  `fecha_inicio_ejecucion` datetime NOT NULL COMMENT 'Fecha de inicio ejecutada',
  `fecha_final_planeacion` datetime NOT NULL COMMENT 'Fecha final planeada',
  `fecha_final_ejecucion` datetime NOT NULL COMMENT 'Fecha final ejecutada',
  `total_horas_planeadas` double NOT NULL COMMENT 'Total de horas planeadas',
  `total_horas_ejecutadas` double NOT NULL COMMENT 'total de horas ejecutadas',
  `costos_planeacion` double NOT NULL COMMENT 'Costos y gastos planeados',
  `costos_ejecucion` double NOT NULL COMMENT 'Costos y gastos ejecutados',
  `valor_facturar` double NOT NULL COMMENT 'valor a facturar segun modulo',
  `color` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL COMMENT 'estado de la tarea',
  `usuario_asignado` int(11) NOT NULL COMMENT 'usuario que se asigna para ejecutar esta tarea',
  `usuario_id` int(11) NOT NULL COMMENT 'usuario que crea el registro',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de creacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'ultima actualizacion',
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `proyectos_actividades_id` (`actividad_id`),
  KEY `proyectos_tareas_id` (`tarea_id`),
  KEY `proyecto_id` (`proyecto_id`),
  KEY `estado` (`estado`),
  KEY `usuario_id` (`usuario_id`),
  KEY `usuario_asignado` (`usuario_asignado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_actividades_adjuntos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'id de la orden de trabajo',
  `tarea_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'id de la tarea',
  `actividad_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'id de la actividad',
  `Ruta` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'ruta del archivo',
  `NombreArchivo` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre del archivo',
  `Extension` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Extension del archivo',
  `Tamano` double NOT NULL DEFAULT '0' COMMENT 'Tamaño del archivo',
  `idUser` int(11) NOT NULL DEFAULT '0' COMMENT 'usuario que lo sube',
  `created` datetime NOT NULL COMMENT 'Fecha de Creacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `proyecto_id` (`proyecto_id`),
  KEY `tarea_id` (`tarea_id`),
  KEY `actividad_id` (`actividad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_actividades_eventos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo',
  `evento_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico del evento',
  `actividad_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico de la actividad',
  `tarea_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico de la tarea relacionada',
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico del proyecto relacionado',
  `titulo` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de la actividad',
  `fecha_inicial` datetime NOT NULL COMMENT 'Fecha de inicio planeada',
  `fecha_final` datetime NOT NULL COMMENT 'Fecha de final planeada',
  `todo_el_dia` int(11) NOT NULL COMMENT 'indica si el evento es todo el dia',
  `color` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'color del evento',
  `horas` double NOT NULL COMMENT 'horas totales del evento',
  `estado` int(11) NOT NULL COMMENT 'estado de la tarea',
  `usuario_id` int(11) NOT NULL COMMENT 'usuario que crea el registro',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de creacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'ultima actualizacion',
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `evento_id` (`evento_id`),
  KEY `actividad_id` (`actividad_id`),
  KEY `tarea_id` (`tarea_id`),
  KEY `proyecto_id` (`proyecto_id`),
  KEY `estado` (`estado`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_actividades_recursos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo',
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador del proyecto relacionado',
  `tarea_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador de la tarea relacionada',
  `actividad_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador de la actividad relacionada',
  `tabla_origen` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'tabla donde se aloja el insumo',
  `recurso_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id del recurso agregado',
  `nombre_recurso` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del recurso',
  `hora_fijo` int(11) NOT NULL COMMENT '0 para hora 1 para fijo',
  `tipo_recurso` int(11) NOT NULL COMMENT 'tipo del recurso',
  `cantidad_planeacion` double NOT NULL COMMENT 'cantidad del insumo en fase de planeacion, si es mano de obra calcular por horas',
  `costo_unitario_planeacion` double NOT NULL COMMENT 'costo unitario en fase de planeacion',
  `cantidad_ejecucion` double NOT NULL COMMENT 'Cantidad ejecutada',
  `costo_unitario_ejecucion` double NOT NULL COMMENT 'Costo unitario en Ejecucion',
  `utilidad_esperada` float NOT NULL COMMENT 'utilidad en decimal esperada',
  `utilidad_obtenida` float NOT NULL COMMENT 'utilidad obtenida en la ejecucion',
  `precio_venta_unitario_planeacion_segun_utilidad` double NOT NULL COMMENT 'precio unitario de venta planeado',
  `precio_venta_unitario_ejecucion_segun_utilidad` double NOT NULL COMMENT 'precio unitario de venta ejecutado',
  `precio_venta_total_planeado` double NOT NULL COMMENT 'precio total de venta ejecutado',
  `precio_venta_total_ejecutado` double NOT NULL COMMENT 'precio total de venta planeado',
  `estado` int(11) NOT NULL COMMENT 'estado del recurso',
  `usuario_id` int(11) NOT NULL COMMENT 'usuario que genera el registro',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `proyecto_id` (`proyecto_id`),
  KEY `proyectos_tareas_id` (`tarea_id`),
  KEY `proyectos_actividades_id` (`actividad_id`),
  KEY `insumo_id` (`recurso_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `estado` (`estado`),
  KEY `tipo_recurso` (`tipo_recurso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_adjuntos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'id de la orden de trabajo',
  `Ruta` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'ruta del archivo',
  `NombreArchivo` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre del archivo',
  `Extension` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Extension del archivo',
  `Tamano` double NOT NULL DEFAULT '0' COMMENT 'Tamaño del archivo',
  `idUser` int(11) NOT NULL DEFAULT '0' COMMENT 'usuario que lo sube',
  `created` datetime NOT NULL COMMENT 'Fecha de Creacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `proyecto_id` (`proyecto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `proyectos_estados` (`ID`, `nombre_estado`, `Updated`, `Sync`) VALUES
(1,	'En Planeacion',	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(2,	'En Ejecucion',	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(3,	'Cerrado',	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(10,	'Eliminado',	'2021-02-23 22:20:56',	'0000-00-00 00:00:00');

CREATE TABLE `proyectos_fechas_excluidas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo',
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id del proyecto a configurar',
  `fecha_excluida` date NOT NULL COMMENT 'Fecha que no debe tenerse en cuenta',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_recursos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `recurso_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador del recurso',
  `tipo` int(11) NOT NULL COMMENT 'tipo de recurso',
  `nombre_recurso` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del recurso',
  `hora_o_fijo` int(11) NOT NULL COMMENT '0 para indicar que es x hora 1 para indicar que es gasto fijo',
  `user_id` int(11) NOT NULL COMMENT 'usuario creador',
  `created` datetime NOT NULL COMMENT 'CURRENT_TIMESTAMP',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `recurso_id` (`recurso_id`),
  KEY `nombre_recurso` (`nombre_recurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_recursos_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_recurso` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de recurso',
  `descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del tipo de recurso',
  `visualizar_agrupado` int(11) NOT NULL COMMENT '0 para visualizar detallado 1 para visualizar agrupado en el informe, cotizacion o factura',
  `suma_horas` int(11) NOT NULL COMMENT 'indica si el recurso suma horas en el proyecto',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `proyectos_recursos_tipo` (`ID`, `tipo_recurso`, `descripcion`, `visualizar_agrupado`, `suma_horas`, `Updated`, `Sync`) VALUES
(1,	'gastos',	'todos los gastos que se incurran para desarrollar el proyecto',	0,	0,	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(2,	'costos',	'costos operacionales que se pueden incurrir para realizar el proyecto',	0,	0,	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(3,	'servicios',	'servicios para la venta en este proyecto',	1,	0,	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(4,	'insumos',	'insumos que se requieren para el proyecto',	1,	0,	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(5,	'productos',	'productos para la venta para el proyecto',	1,	0,	'2021-02-23 22:20:56',	'0000-00-00 00:00:00');

CREATE TABLE `proyectos_tareas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo',
  `tarea_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico de la tarea',
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico del proyecto',
  `titulo_tarea` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de la tarea',
  `fecha_inicio_planeacion` datetime NOT NULL COMMENT 'Fecha de inicio planeada',
  `fecha_inicio_ejecucion` datetime NOT NULL COMMENT 'Fecha de inicio ejecutada',
  `fecha_final_planeacion` datetime NOT NULL COMMENT 'Fecha final planeada',
  `fecha_final_ejecucion` datetime NOT NULL COMMENT 'Fecha final ejecutada',
  `total_horas_planeadas` double NOT NULL COMMENT 'Total de horas planeadas en la tarea',
  `total_horas_ejecutadas` double NOT NULL COMMENT 'Total de horas ejecutadas en la tarea',
  `costos_planeacion` double NOT NULL COMMENT 'Costos y gastos planeados',
  `costos_ejecucion` double NOT NULL COMMENT 'Costos y gastos ejecutados',
  `valor_facturar` double NOT NULL COMMENT 'valor a facturar segun modulo',
  `color` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'color de la tarea',
  `estado` int(11) NOT NULL COMMENT 'estado de la tarea',
  `usuario_id` int(11) NOT NULL COMMENT 'usuario que crea el registro',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de creacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'ultima actualizacion',
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `proyectos_tareas_id` (`tarea_id`),
  KEY `proyecto_id` (`proyecto_id`),
  KEY `estado` (`estado`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_tareas_adjuntos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `proyecto_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'id de la orden de trabajo',
  `tarea_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'id de la tarea',
  `Ruta` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'ruta del archivo',
  `NombreArchivo` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre del archivo',
  `Extension` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Extension del archivo',
  `Tamano` double NOT NULL DEFAULT '0' COMMENT 'Tamaño del archivo',
  `idUser` int(11) NOT NULL DEFAULT '0' COMMENT 'usuario que lo sube',
  `created` datetime NOT NULL COMMENT 'Fecha de Creacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `proyecto_id` (`proyecto_id`),
  KEY `tarea_id` (`tarea_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proyectos_tareas_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `estado_tarea` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `proyectos_tareas_estados` (`ID`, `estado_tarea`, `Updated`, `Sync`) VALUES
(1,	'Abierta',	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(2,	'Cerrada',	'2021-02-23 22:20:56',	'0000-00-00 00:00:00'),
(10,	'Anulada',	'2021-02-23 22:20:56',	'0000-00-00 00:00:00');


