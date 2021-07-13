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


ALTER TABLE `empresapro_resoluciones_facturacion`
ADD `resolucion_id_api` int NOT NULL COMMENT 'id de la resolucion en el api de facura electronica' AFTER `technical_key`;

ALTER TABLE `facturas`
ADD `periodo_fecha_inicio` date NOT NULL AFTER `ReporteFacturaElectronica`,
ADD `periodo_fecha_fin` date NOT NULL AFTER `periodo_fecha_inicio`;

ALTER TABLE `ori_facturas`
ADD `periodo_fecha_inicio` date NOT NULL AFTER `ReporteFacturaElectronica`,
ADD `periodo_fecha_fin` date NOT NULL AFTER `periodo_fecha_inicio`;



ALTER TABLE `empresapro_regimenes`
CHANGE `Regimen` `Regimen` varchar(45) COLLATE 'utf8_spanish_ci' NOT NULL AFTER `ID`;
UPDATE `empresapro_regimenes` SET `Regimen` = 'Responsable de IVA' WHERE `ID` = '1';
UPDATE `empresapro_regimenes` SET `Regimen` = 'No Responsable de IVA' WHERE `ID` = '2';


UPDATE `cod_documentos` SET `Descripcion` = 'Cédula de ciudadanía ' WHERE `Codigo` = '13' AND `Descripcion` = 'C?dula de ciudadan?a ' AND `Descripcion` = 'C?dula de ciudadan?a ' COLLATE utf8mb4_bin AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Certificado de la Registraduría para sucesiones ilíquidas de personas naturales que no tienen ningún documento de identificación. ' WHERE `Codigo` = '14' AND MD5(CONVERT(`Descripcion` USING utf8mb4)) = '2f88a9973a3adfc1a77cf12abde74748' AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Tipo de documento que identifica una sucesión ilíquida, expedido por la notaria o por un juzgado' WHERE `Codigo` = '15' AND MD5(CONVERT(`Descripcion` USING utf8mb4)) = 'b86ea673b7cf73899494ee7b27e69699' AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Tarjeta de extranjería' WHERE `Codigo` = '21' AND `Descripcion` = 'Tarjeta de extranjer' AND `Descripcion` = 'Tarjeta de extranjer' COLLATE utf8mb4_bin AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Cédula de extranjería ' WHERE `Codigo` = '22' AND `Descripcion` = 'C?dula de extranjer?a ' AND `Descripcion` = 'C?dula de extranjer?a ' COLLATE utf8mb4_bin AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Identificación de extranjeros diferente al NIT asignado DIAN' WHERE `Codigo` = '33' AND `Descripcion` = 'Identificaci?n de extranjeros diferente al NIT asignado DIAN' AND `Descripcion` = 'Identificaci?n de extranjeros diferente al NIT asignado DIAN' COLLATE utf8mb4_bin AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Documento de identificación extranjero ' WHERE `Codigo` = '42' AND `Descripcion` = 'Documento de identificaci?n extranjero ' AND `Descripcion` = 'Documento de identificaci?n extranjero ' COLLATE utf8mb4_bin AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Sin identificación del exterior o para uso definido por la DIAN. ' WHERE `Codigo` = '43' AND MD5(CONVERT(`Descripcion` USING utf8mb4)) = '2ce4e908bd019cf0741e2c230403692b' AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Documento de Identificación extranjero Persona Jurídica ' WHERE `Codigo` = '44' AND `Descripcion` = 'Documento de Identificaci?n extranjero Persona Jur?dica ' AND `Descripcion` = 'Documento de Identificaci?n extranjero Persona Jur?dica ' COLLATE utf8mb4_bin AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;
UPDATE `cod_documentos` SET `Descripcion` = 'Carné Diplomótico: Documento expedido por el Ministerio de relaciones Exteriores a los miembros de la misiones diplomáticas y consulares, con el que se deben identificar ente las autoridades nacionales' WHERE `Codigo` = '46' AND MD5(CONVERT(`Descripcion` USING utf8mb4)) = '707523eaa180a0510b90672366ec5698' AND `Updated` = '2020-07-25 09:35:02' AND `Sync` = '2020-07-25 09:35:02' LIMIT 1;


ALTER TABLE `facturas_electronicas_log`
ADD INDEX `UUID` (`UUID`(45)),
ADD INDEX `PDFCreado` (`PDFCreado`),
ADD INDEX `ZIPCreado` (`ZIPCreado`),
ADD INDEX `EnviadoPorMail` (`EnviadoPorMail`);


update facturas_electronicas_log set EnviadoPorMail=1;

ALTER TABLE `notas_credito`
ADD `error_api` text COLLATE 'utf8_spanish_ci' NOT NULL AFTER `LogsDocumento`;

ALTER TABLE `notas_credito`
ADD `EnviadoPorMail` int NOT NULL AFTER `LogsDocumento`;
update notas_credito set EnviadoPorMail=1;

ALTER TABLE `notas_credito`
ADD INDEX `EnviadoPorMail` (`EnviadoPorMail`);


INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(43,	'FACTURA ELECTRÓNICA DE VENTA',	'001',	'F-GA-013',	'2016-05-11',	'',	'***GRACIAS POR SU COMPRA***; Los productos en promocion no tienen Cambio',	'2020-07-25 10:03:57',	'2020-07-25 10:03:57');


CREATE TABLE `contabilidad_certificados_rentenciones_movimientos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `certificado_id` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `cuenta_puc` bigint(20) NOT NULL,
  `concepto` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `valor_retenido` double NOT NULL,
  `porcentaje` float NOT NULL,
  `base` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `certificado_id` (`certificado_id`),
  KEY `cuenta_puc` (`cuenta_puc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `clientes`
ADD `actualizacion_datos` datetime NOT NULL AFTER `Estado`;

ALTER TABLE `proveedores`
ADD `actualizacion_datos` datetime NOT NULL AFTER `Estado`;

update clientes set actualizacion_datos=Created;


INSERT INTO `servidores` (`ID`, `IP`, `Nombre`, `Usuario`, `Password`, `DataBase`, `Puerto`, `TipoServidor`, `Observaciones`, `Updated`, `Sync`) VALUES
(111,	'http://35.238.236.240/api/ubl2.1/status/document/',	'obtener el estado de una factura',	'',	'',	'',	0,	'REST',	'Esta ruta devuelve el log de un documento, debe acompañarse por el uuid, ver documentacion: http://35.238.236.240/api/ubl2.1/documentation',	'2021-03-03 17:08:51',	'2020-07-25 10:06:36'),
(112,	'http://35.238.236.240/api/ubl2.1/mail/send/',	'Enviar Factura Electronica por mail',	'',	'',	'',	0,	'REST',	'Esta ruta devuelve el log de un documento, debe acompañarse por el uuid, ver documentacion: http://35.238.236.240/api/ubl2.1/documentation',	'2021-03-03 17:10:00',	'2020-07-25 10:06:36');

DROP TABLE IF EXISTS `cod_documentos`;
CREATE TABLE `cod_documentos` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `Codigo` (`Codigo`),
  KEY `Codigo_2` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `cod_documentos` (`Codigo`, `Descripcion`, `Updated`, `Sync`) VALUES
(11,	'Registro civil de nacimiento ',	'2020-07-25 14:35:02',	'2020-07-25 09:35:02'),
(12,	'Tarjeta de identidad ',	'2020-07-25 14:35:02',	'2020-07-25 09:35:02'),
(13,	'Cédula de ciudadanía ',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(14,	'Certificado de la Registraduría para sucesiones ilíquidas de personas naturales que no tienen ningún documento de identificación. ',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(15,	'Tipo de documento que identifica una sucesión ilíquida, expedido por la notaria o por un juzgado',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(21,	'Tarjeta de extranjería',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(22,	'Cédula de extranjería ',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(31,	'NIT ',	'2020-07-25 14:35:02',	'2020-07-25 09:35:02'),
(33,	'Identificación de extranjeros diferente al NIT asignado DIAN',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(41,	'Pasaporte ',	'2020-07-25 14:35:02',	'2020-07-25 09:35:02'),
(42,	'Documento de identificación extranjero ',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(43,	'Sin identificación del exterior o para uso definido por la DIAN. ',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(44,	'Documento de Identificación extranjero Persona Jurídica ',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02'),
(46,	'Carné Diplomótico: Documento expedido por el Ministerio de relaciones Exteriores a los miembros de la misiones diplomáticas y consulares, con el que se deben identificar ente las autoridades nacionale',	'2021-03-04 04:22:04',	'2020-07-25 09:35:02');


ALTER TABLE `facturas_electronicas_log`
ADD `firma_digital` text COLLATE 'utf8_spanish_ci' NOT NULL AFTER `UUID`;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(5000,	'API Key SendinBlue',	'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',	'2020-11-11 10:12:59',	'2020-07-25 09:59:30');

UPDATE `parametros_contables` SET `Descripcion` = 'Impuestos asumidos, aplica para los impuestos que no se pueden descontar', `CuentaPUC` = '53152001' WHERE `ID` = '29';


INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(44,	'DOCUMENTO EQUIVALENTE EQUIVALENTE A FACTURA DE COMPRA',	'001',	'F-GA-014',	'2021-04-11',	'',	'',	'2020-07-25 10:03:57',	'2020-07-25 10:03:57');

INSERT INTO `configuracion_tablas_acciones_adicionales` (`ID`, `TablaDB`, `JavaScript`, `ClaseIcono`, `Titulo`, `Ruta`, `Target`, `Updated`, `Sync`) VALUES
(9,	'vista_documentos_equivalentes',	'',	'fa fa-eye',	'Imprimir',	'Consultas/PDF_ReportesContables.draw.php?idDocumento=9&documento_id=',	'_BLANK',	'2020-07-25 09:59:43',	'2020-07-25 09:59:43');

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES
(13,	'vista_documentos_equivalentes',	0,	0,	0,	'',	1,	1,	0,	'2021-04-19 10:41:04',	'2020-07-25 09:35:14');


DROP TABLE IF EXISTS `documentos_equivalentes`;
CREATE TABLE `documentos_equivalentes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `consecutivo` bigint(20) NOT NULL,
  `resolucion_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tercero_id` bigint(20) NOT NULL,
  `concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `centro_costos_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `empresa_id` (`empresa_id`),
  KEY `centro_costos_id` (`centro_costos_id`),
  KEY `sucursal_id` (`sucursal_id`),
  KEY `resolucion_id` (`resolucion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `documentos_equivalentes_estados`;
CREATE TABLE `documentos_equivalentes_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `documentos_equivalentes_estados` (`ID`, `nombre`, `Updated`, `Sync`) VALUES
(1,	'Abierto',	'2021-04-06 03:51:31',	'0000-00-00 00:00:00'),
(2,	'Cerrado',	'2021-04-06 03:51:31',	'0000-00-00 00:00:00'),
(10,	'Anulado',	'2021-04-06 03:51:31',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `documentos_equivalentes_items`;
CREATE TABLE `documentos_equivalentes_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `documento_equivalente_id` bigint(20) NOT NULL,
  `descripcion` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` double NOT NULL,
  `valor_unitario` double NOT NULL,
  `total_item` double NOT NULL,
  `cuenta_puc` bigint(20) NOT NULL,
  `deleted` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `documento_equivalente_id` (`documento_equivalente_id`),
  KEY `cuenta_puc` (`cuenta_puc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `documentos_equivalentes_resoluciones`;
CREATE TABLE `documentos_equivalentes_resoluciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_interno` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `numero_resolucion` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `prefijo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `desde` bigint(20) NOT NULL,
  `hasta` bigint(20) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado` int(11) NOT NULL COMMENT '1 activa, 2 ocupada, 3 completada',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `documentos_equivalentes_retenciones`;
CREATE TABLE `documentos_equivalentes_retenciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `documento_equivalente_id` bigint(20) NOT NULL,
  `base` double NOT NULL,
  `porcentaje` float NOT NULL,
  `valor_retenido` double NOT NULL,
  `cuenta_puc` bigint(20) NOT NULL,
  `asumida` int(1) NOT NULL COMMENT '0 por tercero, por empresa',
  `deleted` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `documento_equivalente_id` (`documento_equivalente_id`),
  KEY `cuenta_puc` (`cuenta_puc`),
  KEY `asumida` (`asumida`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
('',	'Registrar un Documento Equivalente',	46,	10,	0,	'',	0,	'',	'documentos_equivalentes.php',	'_BLANK',	1,	'ordenessalida.png',	3,	'2020-07-25 10:05:03',	'2020-07-25 10:05:03');


CREATE TABLE `metas_ventas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Anio` int(11) NOT NULL,
  `Mes` int(11) NOT NULL,
  `Meta` double NOT NULL,
  `Frase` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Anio` (`Anio`),
  KEY `Mes` (`Mes`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `metas_ventas_diarias`;
CREATE TABLE `metas_ventas_diarias` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `meta` double NOT NULL,
  `total_ventas` double NOT NULL,
  `diferencia` double NOT NULL,
  `cumplimiento` double NOT NULL,
  `ventas_dia` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `traslados_items`
ADD `Deleted` datetime NOT NULL AFTER `idCierre`;
ALTER TABLE `traslados_items`
ADD INDEX `idTraslado` (`idTraslado`),
ADD INDEX `Referencia` (`Referencia`),
ADD INDEX `CodigoBarras` (`CodigoBarras`),
ADD INDEX `Destino` (`Destino`),
ADD INDEX `Estado` (`Estado`);


DROP TABLE IF EXISTS `traslados_estados`;
CREATE TABLE `traslados_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `traslados_estados` (`ID`, `Estado`, `Descripcion`, `Updated`, `Sync`) VALUES
(1,	'EN DESARROLLO',	'Estado que identifica un traslado cuando esta realizandose para agregar items',	'2021-06-28 21:10:13',	'0000-00-00 00:00:00'),
(2,	'PREPARADO',	'Traslado cerrado',	'2021-06-28 21:10:13',	'0000-00-00 00:00:00'),
(3,	'VERIFICADO',	'Cuando se valida por un traslado recibido',	'2021-06-28 21:10:13',	'0000-00-00 00:00:00'),
(4,	'ENVIADO',	'Cuando se envia el traslado',	'2021-06-28 21:10:13',	'0000-00-00 00:00:00'),
(5,	'RECIBIDO',	'Cuando se recibe un traslado',	'2021-06-28 21:10:13',	'0000-00-00 00:00:00');

ALTER TABLE `kardexmercancias`
ADD INDEX `Movimiento` (`Movimiento`),
ADD INDEX `idDocumento` (`idDocumento`),
ADD INDEX `ProductosVenta_idProductosVenta` (`ProductosVenta_idProductosVenta`);


ALTER TABLE `restaurante_pedidos_items`
ADD `deleted_at` datetime NOT NULL AFTER `Updated`;
ALTER TABLE `restaurante_pedidos_items`
ADD `created_at` datetime NOT NULL AFTER `deleted_at`;

DROP TABLE IF EXISTS `restaurante_estados_pedidos_items`;
CREATE TABLE `restaurante_estados_pedidos_items` (
  `ID` int(11) NOT NULL,
  `NombreEstado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `restaurante_estados_pedidos_items` (`ID`, `NombreEstado`, `Updated`, `Sync`) VALUES
(1,	'SOLICITADO',	'2021-07-08 20:08:37',	'0000-00-00 00:00:00'),
(2,	'PREPARADO',	'2021-07-08 20:09:44',	'0000-00-00 00:00:00'),
(3,	'ENTREGADO',	'2021-07-08 20:09:44',	'0000-00-00 00:00:00');


ALTER TABLE `modelos_db`
CHANGE `ValorServicio1` `valor_servicio_20` double NOT NULL COMMENT '20 minutos' AFTER `Telefono`,
CHANGE `ValorServicio2` `valor_servicio_30` double NOT NULL COMMENT '30 minutos' AFTER `valor_servicio_20`,
CHANGE `ValorServicio3` `valor_servicio_60` double NOT NULL COMMENT '1 hora' AFTER `valor_servicio_30`,
ADD `show` double NOT NULL COMMENT 'valor por show' AFTER `valor_servicio_60`,
ADD `masaje` double NOT NULL COMMENT 'valor por masaje' AFTER `show`,
ENGINE='MyISAM';

ALTER TABLE `modelos_db`
CHANGE `Estado` `Estado` varchar(1) COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'A' COMMENT 'A activo, I Inactivo' AFTER `masaje`;

ALTER TABLE `modelos_db`
ADD INDEX `Estado` (`Estado`);

CREATE TABLE `restaurante_productos_favoritos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `restaurante_productos_favoritos` (`ID`, `producto_id`, `Updated`, `Sync`) VALUES
(1,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(2,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(3,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(4,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(5,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(6,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(7,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(8,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(9,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(10,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(11,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(12,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(13,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(14,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00'),
(15,	0,	'2021-07-13 13:20:11',	'0000-00-00 00:00:00');


INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(18,	'../modulos/modelos/',	'2020-07-25 10:05:02',	'2019-07-25 10:05:02');

UPDATE `menu_submenus` SET `idCarpeta` = '18', `Pagina` = 'modelos.php' WHERE `Nombre` = 'Administrar Tiempos' ;

UPDATE `menu_submenus` SET `Pagina` = 'restobarpos.php' WHERE `Nombre` = 'Ventas';

