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

