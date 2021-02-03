ALTER TABLE `empresapro` ADD `db` VARCHAR(100) NOT NULL DEFAULT 'ts5' AFTER `TokenAPIFE`;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(38,	'ruta para los soportes de los proyectos',	'../../../SoportesTS5/',	'2019-07-25 09:59:30',	'2020-07-25 09:59:30');

