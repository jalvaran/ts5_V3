ALTER TABLE `cot_itemscotizaciones`
CHANGE `idCliente` `idCliente` int NOT NULL DEFAULT '0' AFTER `ID`,
ADD `user_id` int NOT NULL AFTER `CuentaPUC`,
ADD `cierre_id` bigint NOT NULL AFTER `user_id`;

ALTER TABLE `cot_itemscotizaciones`
ADD INDEX `user_id` (`user_id`),
ADD INDEX `cierre_id` (`cierre_id`);

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(45,	'REPORTE DE CIERRE DE TURNO',	'001',	'F-GA-015',	'2021-08-11',	'',	'',	'2019-07-25 10:03:57',	'2020-07-25 10:03:57');

