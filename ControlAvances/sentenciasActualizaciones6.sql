ALTER TABLE `fe_webservice` ADD `Descripcion` VARCHAR(100) NOT NULL AFTER `Pass`;
ALTER TABLE `empresapro` ADD `CodigoDaneCiudad` INT(5) UNSIGNED ZEROFILL NOT NULL AFTER `Ciudad`;
ALTER TABLE `empresapro` ADD `TokenAPIFE` TEXT NOT NULL AFTER `CXPAutomaticas`;
ALTER TABLE `clientes` CHANGE `Cod_Mcipio` `Cod_Mcipio` INT(3) UNSIGNED ZEROFILL NOT NULL;
ALTER TABLE `proveedores` CHANGE `Cod_Mcipio` `Cod_Mcipio` INT(3) UNSIGNED ZEROFILL NOT NULL;
ALTER TABLE `clientes` CHANGE `Cod_Dpto` `Cod_Dpto` INT(2) UNSIGNED ZEROFILL NOT NULL;
ALTER TABLE `proveedores` CHANGE `Cod_Dpto` `Cod_Dpto` INT(2) UNSIGNED ZEROFILL NOT NULL;
ALTER TABLE `empresapro_resoluciones_facturacion` ADD `FacturaElectronica` INT(1) NOT NULL AFTER `Factura`;
ALTER TABLE `empresapro_resoluciones_facturacion` ADD `FechaDesde` DATE NOT NULL AFTER `Hasta`;
ALTER TABLE `empresapro_resoluciones_facturacion` ADD `technical_key` VARCHAR(95) NOT NULL AFTER `FechaVencimiento`;

DROP TABLE IF EXISTS `porcentajes_iva`;
CREATE TABLE `porcentajes_iva` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseImpuesto` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT '01' COMMENT '01 para IVA, 02 impoconsumo, 03 ICA',
  `Factor` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'M',
  `CuentaPUC` bigint(20) NOT NULL,
  `CuentaPUCIVAGenerado` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idImpuestoAPIFE` int(11) NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `porcentajes_iva` (`ID`, `Nombre`, `Valor`, `ClaseImpuesto`, `Factor`, `CuentaPUC`, `CuentaPUCIVAGenerado`, `NombreCuenta`, `idImpuestoAPIFE`, `Habilitado`, `Updated`, `Sync`) VALUES
(1,	'Sin IVA',	'0',	'01',	'M',	2408,	2408,	'',	15,	'SI',	'2019-09-26 22:57:02',	'2019-01-13 09:12:57'),
(2,	'Excluidos',	'E',	'01',	'M',	2408,	2408,	'',	15,	'SI',	'2019-09-26 22:57:02',	'2019-01-13 09:12:57'),
(3,	'IVA 5 %',	'0.05',	'01',	'M',	24080503,	24081003,	'Impuestos del 5%',	1,	'SI',	'2019-09-26 22:57:02',	'2019-01-13 09:12:57'),
(4,	'IVA del 8%',	'0.08',	'01',	'M',	24080502,	24081002,	'Impuestos del 8%',	4,	'SI',	'2019-09-26 22:57:02',	'2019-01-13 09:12:57'),
(5,	'IVA del 16%',	'0.16',	'01',	'M',	24080504,	24081004,	'Impuestos del 16%',	1,	'NO',	'2019-09-26 22:57:02',	'2019-01-13 09:12:57'),
(6,	'IVA del 19%',	'0.19',	'01',	'M',	24080501,	24081001,	'Impuestos del 19%',	1,	'SI',	'2019-09-26 22:57:02',	'2019-01-13 09:12:57'),
(7,	'ImpoConsumo Bolsas',	'20',	'02',	'S',	24080511,	24081011,	'IMPUESTO AL CONSUMO DE BOLSAS',	10,	'NO',	'2019-09-26 22:57:13',	'2019-01-13 09:12:57'),
(8,	'impuesto del 1.9%',	'0.019',	'01',	'M',	24080505,	24081005,	'Impuestos del 10% del 19%',	16,	'SI',	'2019-09-26 22:57:02',	'2019-01-13 09:12:57');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(12,	'Determina si se puede mostrar el icono para la creacion de un nuevo producto o servicio en el pos',	'0',	'2019-09-14 19:18:01',	'2019-09-13 19:18:01');


INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(13,	'Determina si se puede mostrar el icono para la creacion de un nuevo producto o servicio en el area de cotizaciones',	'0',	'2019-09-14 19:18:01',	'2019-09-13 19:18:01');

