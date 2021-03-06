ALTER TABLE `cotizacionesv5` CHANGE `Fecha` `Fecha` DATE NOT NULL;
ALTER TABLE `cotizacionesv5` ADD `Estado` VARCHAR(25) NOT NULL AFTER `Seguimiento`;
ALTER TABLE `cotizacionesv5` ADD INDEX(`Estado`);

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (49, 'Ingresos', '23', '1', b'1', '2019-01-13 09:12:43', '2019-01-13 09:12:43');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (186, 'Historial Comprobantes Ingreso', '49', '3', '0', 'comprobantes_ingreso', '1', 'onclick=\"SeleccioneTablaDB(`comprobantes_ingreso`)\";', 'comprobantes_ingreso.php', '_SELF', '1', 'historial3.png', '1', '2019-01-13 09:12:44', '2019-01-13 09:12:44');

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES (7, 'comprobantes_ingreso', '0', '0', '1', 'PDF_Documentos.php?idDocumento=4&idIngreso=', '1', '1', '0', '2019-01-13 09:04:48', '2019-01-13 09:04:48');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (3, 'comprobantes_ingreso', 'Clientes_idClientes', 'clientes', 'idClientes', 'Num_Identificacion', '2019-01-13 09:04:47', '2019-01-13 09:04:47');

ALTER TABLE `factura_compra_items` ADD `PrecioVenta` DOUBLE NOT NULL AFTER `SubtotalDescuento`;

UPDATE `parametros_contables` SET `CuentaPUC` = '280505' WHERE `parametros_contables`.`ID` = 20;
UPDATE `menu_submenus` SET `TipoLink` = '1' WHERE `menu_submenus`.`ID` = 55;
UPDATE `menu_submenus` SET `TablaAsociada` = 'productosventa' WHERE `menu_submenus`.`ID` = 55;
UPDATE `menu_submenus` SET `JavaScript` = 'onclick=\"SeleccioneTablaDB(`productosventa`)\";' WHERE `menu_submenus`.`ID` = 55;

UPDATE `menu_submenus` SET `Target` = '_SELF' WHERE `menu_submenus`.`ID` = 55;

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (4, 'productosventa', 'Departamento', 'prod_departamentos', 'Nombre', 'idDepartamentos', '2019-02-24 14:01:51', '2019-01-24 14:01:51');

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (5, 'productosventa', 'Sub1', 'prod_sub1', 'NombreSub1', 'idSub1', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (6, 'productosventa', 'Sub2', 'prod_sub2', 'NombreSub2', 'idSub2', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (7, 'productosventa', 'Sub3', 'prod_sub3', 'NombreSub3', 'idSub3', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (8, 'productosventa', 'Sub4', 'prod_sub4', 'NombreSub4', 'idSub4', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (9, 'productosventa', 'Sub5', 'prod_sub5', 'NombreSub5', 'idSub5', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (10, 'productosventa', 'Sub6', 'prod_sub6', 'NombreSub6', 'idSub6', '2019-02-24 14:01:51', '2019-01-24 14:01:51');


ALTER TABLE `cot_itemscotizaciones` ADD `PorcentajeIVA` VARCHAR(10) NOT NULL AFTER `TipoItem`, ADD `Departamento` INT NOT NULL AFTER `PorcentajeIVA`, ADD `SubGrupo1` INT NOT NULL AFTER `Departamento`, ADD `SubGrupo2` INT NOT NULL AFTER `SubGrupo1`, ADD `SubGrupo3` INT NOT NULL AFTER `SubGrupo2`, ADD `SubGrupo4` INT NOT NULL AFTER `SubGrupo3`, ADD `SubGrupo5` INT NOT NULL AFTER `SubGrupo4`;
ALTER TABLE `cot_itemscotizaciones` ADD `idPorcentajeIVA` INT NOT NULL AFTER `PorcentajeIVA`;

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES (8, 'clientes', '1', '1', '0', '', '1', '0', '0', '2019-01-13 09:04:48', '2019-01-13 09:04:48');
ALTER TABLE `configuracion_tablas_acciones_adicionales` CHANGE `ClaseIcono` `ClaseIcono` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL;

INSERT INTO `configuracion_tablas_acciones_adicionales` (`ID`, `TablaDB`, `JavaScript`, `ClaseIcono`, `Titulo`, `Ruta`, `Target`, `Updated`, `Sync`) VALUES ('4', 'comprobantes_ingreso', '', 'fa fa-fw fa-close', 'Anular', '../../VAtencion/AnularComprobanteIngreso.php?idComprobante=', '_BLANK', '2019-01-13 09:04:49', '2018-01-13 09:04:49');
UPDATE `configuracion_control_tablas` SET `AccionesAdicionales` = '1' WHERE `configuracion_control_tablas`.`ID` = 7;
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (11, 'cotizacionesv5', 'Clientes_idClientes', 'clientes', 'Num_Identificacion', 'idClientes', '2019-02-24 14:01:51', '2018-02-24 14:01:51');

ALTER TABLE `preventa` ADD `Nombre` VARCHAR(100) NOT NULL AFTER `TablaItem`;
ALTER TABLE `preventa` ADD `Referencia` TEXT NOT NULL AFTER `Nombre`;

CREATE TABLE `cotizaciones_anticipos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Valor` double NOT NULL,
  `idCotizacion` bigint(20) NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCotizacion` (`idCotizacion`),
  KEY `idComprobanteIngreso` (`idComprobanteIngreso`),
  KEY `Estado` (`Estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (12, 'clientes', 'Tipo_Documento', 'cod_documentos', 'Descripcion', 'Codigo', '2019-03-01 23:38:29', '2019-02-01 23:38:29');

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES ('13', 'clientes', 'Cod_Dpto', 'cod_departamentos', 'Nombre', 'Cod_dpto', '2019-03-01 23:38:29', '2019-02-01 23:38:29');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES ('14', 'clientes', 'Cod_Mcipio', 'cod_municipios_dptos', 'Ciudad', 'Cod_mcipio', '2019-03-01 23:38:29', '2019-02-01 23:38:29');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES ('15', 'clientes', 'Pais_Domicilio', 'cod_paises', 'Pais', 'Codigo', '2019-03-01 23:38:29', '2019-02-01 23:38:29');

ALTER TABLE `cajas` ADD `idEmpresa` INT NOT NULL AFTER `idTerceroIntereses`;
ALTER TABLE `cajas` ADD `idEmpresa` INT NOT NULL DEFAULT '1' AFTER `idTerceroIntereses`;
ALTER TABLE `cajas` ADD `idSucursal` INT NOT NULL DEFAULT '1' AFTER `idEmpresa`;

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(30,	'Cuenta para registrar los abonos o pagos en ventas rapidas a los creditos o ventas con otras formas de pago',	11050599,	'OTRAS FORMAS DE PAGO',	'2019-01-13 09:12:55',	'2018-01-13 09:12:55');

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(31,	'Anticipos realizados por clientes para los separados',	28050501,	'ANTICIPOS REALIZADOS POR CLIENTES EN SEPARADOS',	'2019-02-26 15:55:46',	'2019-02-26 15:55:46');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(2,'Valor por defecto si se imprime o no al momento de realizar una factura pos',	'1',	'2019-03-18 07:36:48',	'0000-00-00 00:00:00');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(3,	'Determina si se debe pedir autorizacion para retornar un item en pos',	'1',	'2019-02-18 07:44:40',	'2019-03-18 07:44:40');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(4,	'Determina si se debe pedir autorizacion para elimininar un item en pos',	'1',	'2019-02-18 08:20:26',	'2019-03-18 08:20:26');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(5,	'Determina si se debe pedir autorizacion para cambiar el precio de venta de un item en pos',	'1',	'2019-02-18 08:27:46',	'2019-03-18 08:27:46');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(6,	'Determina el valor maximo que se puede aplicar al descuento general',	'35',	'2019-03-18 08:33:01',	'2019-03-18 08:33:01');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(7,'Determina si se pueden realizar descuentos a precio de costo','1',	'2019-02-18 08:33:01',	'2019-03-18 08:33:01');

ALTER TABLE `clientes` ADD `CodigoTarjeta` VARCHAR(20) NOT NULL AFTER `Cupo`;
ALTER TABLE `proveedores` ADD `CodigoTarjeta` VARCHAR(20) NOT NULL AFTER `Cupo`;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(8,	'Determina cuantas copias saldrán del separado al crearse',	'2',	'2019-02-18 15:54:51',	'2019-03-18 15:54:51');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(9,	'Determina cuantas copias saldrán del egreso al crearse desde pos',	'2',	'2019-02-19 14:19:59',	'2019-03-19 14:19:59');


ALTER TABLE `ordenesdecompra` ADD `idCentroCostos` INT NOT NULL DEFAULT '1' AFTER `UsuarioCreador`, ADD `idSucursal` INT NOT NULL DEFAULT '1' AFTER `idCentroCostos`;

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(32,	'Retefuente por compra de Honorarios',	236515,	'Retencion en la fuente por honorarios',	'2019-03-30 11:53:40',	'2019-03-30 11:53:40');


INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES ('8', '../modulos/comercial/', '2019-01-13 09:12:43', '2018-01-13 09:12:43');
INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES ('9', '../modulos/compras/', '2019-01-13 09:12:43', '2018-01-13 09:12:43');
UPDATE `menu_submenus` SET `idCarpeta` = '9' WHERE `menu_submenus`.`ID` = 58;
UPDATE `menu_submenus` SET `Pagina` = 'OrdenCompra.php' WHERE `menu_submenus`.`ID` = 58;

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `Cuentas_idPUC`, `Updated`, `Sync`) VALUES
(132505,	'CUENTAS X COBRAR A SOCIOS',	NULL,	'1325',	'2019-04-06 13:20:16',	'0000-00-00 00:00:00'),
(132510,	'CUENTAS X COBRAR A ACCIONISTAS',	NULL,	'',	'2019-04-06 13:20:44',	'0000-00-00 00:00:00');

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `Cuentas_idPUC`, `Updated`, `Sync`) VALUES
(136505,	'VIVIENDA',	NULL,	'1365',	'2019-04-06 13:21:39',	'0000-00-00 00:00:00'),
(136510,	'VEHICULOS',	NULL,	'1365',	'2019-04-06 13:22:15',	'0000-00-00 00:00:00'),
(136515,	'ESTUDIO',	NULL,	'',	'2019-04-06 13:22:27',	'0000-00-00 00:00:00'),
(136520,	'MEDICOS, ODONTOLICOS Y SIMILARES',	NULL,	'',	'2019-04-06 13:22:57',	'0000-00-00 00:00:00'),
(136525,	'CALAMIDAD DOMESTICA',	NULL,	'',	'2019-04-06 13:23:17',	'0000-00-00 00:00:00'),
(136530,	'RESPONSABILIDADES',	NULL,	'',	'2019-04-06 13:23:31',	'0000-00-00 00:00:00'),
(136595,	'OTROS',	NULL,	'',	'2019-04-06 13:23:56',	'0000-00-00 00:00:00');

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `Cuentas_idPUC`, `Updated`, `Sync`) VALUES
(137005,	'PARTICULARES CON GARANTIA REAL',	NULL,	'',	'2019-04-06 13:24:41',	'0000-00-00 00:00:00'),
(137010,	'PARTICULARES CON GARANTIA PERSONAL',	NULL,	'',	'2019-04-06 13:25:00',	'0000-00-00 00:00:00');

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES ('35', 'CERTIFICADO DE PRESTAMO', '001', 'F-GH-002', '2018-05-15', '', '', '2019-01-31 17:08:58', '2018-01-31 17:08:58');
INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES (NULL, 'prestamos_terceros', '0', '0', '1', 'PDF_Documentos.draw.php?idDocumento=35&ID=', '1', '1', '0', '2019-03-01 23:38:30', '2018-03-01 23:38:30');

INSERT INTO `configuracion_tablas_acciones_adicionales` (`ID`, `TablaDB`, `JavaScript`, `ClaseIcono`, `Titulo`, `Ruta`, `Target`, `Updated`, `Sync`) VALUES (5, 'prestamos_terceros', 'onclick=AbreModalAbonar', 'fa fa-fw fa-plus', 'Abonar', '#', '_SELF', '2019-04-06 19:46:20', '2018-03-01 23:38:30');

INSERT INTO `configuracion_tablas_acciones_adicionales` (`ID`, `TablaDB`, `JavaScript`, `ClaseIcono`, `Titulo`, `Ruta`, `Target`, `Updated`, `Sync`) VALUES (6, 'prestamos_terceros', 'onclick=HistorialAbonos', 'fa fa-fw fa-history', 'Historial', '#', '_SELF', '2019-04-06 14:49:13', '2018-04-06 14:49:13');

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES (10, '../modulos/contabilidad/', '2019-04-01 08:02:36', '2018-04-01 08:02:36');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (187, 'Prestamos a Terceros', '14', '10', '0', '', '1', '', 'PrestamosATerceros.php', '_SELF', '1', 'abonar.jpg', '6', '2019-01-13 09:12:44', '2018-01-13 09:12:44');

CREATE TABLE `prestamos_terceros` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Valor` double NOT NULL,
  `Abonos` double NOT NULL,
  `Saldo` double NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `idCentroCostos` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Tercero` (`Tercero`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `prestamos_terceros_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idPrestamo` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `Valor` double NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idPrestamo` (`idPrestamo`),
  KEY `idComprobanteIngreso` (`idComprobanteIngreso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comercial_plataformas_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NIT` bigint(20) NOT NULL,
  `Activa` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comercial_plataformas_pago_ingresos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idPlataformaPago` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Valor` double NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Tercero` (`Tercero`),
  KEY `idComprobanteIngreso` (`idComprobanteIngreso`),
  KEY `idCierre` (`idCierre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comercial_plataformas_pago_ventas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idPlataformaPago` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Tercero` (`Tercero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(11,	'../modulos/reportes/',	'2019-04-07 08:27:38',	'2018-04-07 08:27:38');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(188,	'Reporte de Ingresos y Ventas por plataformas',	18,	11,	0,	'',	1,	'',	'ReportesPlataformas.php',	'_SELF',	1,	'reportes.jpg',	3,	'2019-04-08 09:14:07',	'2018-04-08 09:14:07');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(189,	'Reportes',	32,	11,	0,	'',	1,	'',	'ReportesTitulos.php',	'_SELF',	1,	'reportes.jpg',	13,	'2019-04-08 09:14:07',	'2018-04-08 09:14:07');

ALTER TABLE `documentos_contables` ADD `Prefijo` VARCHAR(20) NOT NULL AFTER `ID`;

DROP TABLE IF EXISTS `documentos_contables`;
CREATE TABLE `documentos_contables` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Prefijo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `documentos_contables` (`ID`, `Prefijo`, `Nombre`, `Descripcion`, `Updated`, `Sync`) VALUES
(1,	'CC-1',	'AJUSTE CONTABLE',	'Documento para generar ajustes a la contabilidad',	'2019-04-09 18:14:02',	'2018-04-09 13:10:53'),
(2,	'CC-2',	'MOVIMIENTO DE CUENTAS',	'',	'2019-04-09 18:14:02',	'2018-04-09 13:13:00'),
(3,	'CC-3',	'COSTEO',	'',	'2019-04-09 18:14:02',	'2018-04-09 13:13:00'),
(4,	'CC-4',	'DIFERIDOS',	'',	'2019-04-09 18:14:02',	'2018-04-09 13:13:00'),
(5,	'CC-5',	'LEGALIZACION DE VIATICOS',	'',	'2019-04-09 18:14:23',	'2018-04-09 13:13:00'),
(6,	'CC-6',	'LEGALIZACION DE CAJAS MENORES',	'',	'2019-04-09 18:14:23',	'2018-04-09 13:13:00'),
(7,	'CC-7',	'OBLIGACIONES FINANCIERAS',	'',	'2019-04-09 18:14:23',	'2018-04-09 13:13:00'),
(8,	'CC-8',	'NOMINA',	'',	'2019-04-09 18:16:44',	'2018-04-09 13:13:00'),
(9,	'CC-9',	'CIERRE CONTABLE',	'',	'2019-04-09 18:19:10',	'2018-04-09 13:13:00'),
(10,	'CC-10',	'SALDOS INICIALES',	'',	'2019-04-09 18:17:12',	'2018-04-09 13:13:00'),
(11,	'CC-11',	'DEPRECIACION',	'Para realizar depreciacion a los activos',	'2019-04-09 18:19:43',	'2018-04-09 13:11:57');

ALTER TABLE `documentos_contables_control` ADD `idEmpresa` INT NOT NULL AFTER `idUser`, ADD `idSucursal` INT NOT NULL AFTER `idEmpresa`, ADD `idCentroCostos` INT NOT NULL AFTER `idSucursal`, ADD `Soporte` INT NOT NULL AFTER `idCentroCostos`;
ALTER TABLE `documentos_contables_control` ADD INDEX(`idEmpresa`);
ALTER TABLE `documentos_contables_control` ADD INDEX(`idSucursal`);
ALTER TABLE `documentos_contables_control` ADD INDEX(`idCentroCostos`);

ALTER TABLE `documentos_contables_items`
  DROP `Nombre_Documento`,
  DROP `Numero_Documento`,
  DROP `Fecha`,
  DROP `CentroCostos`;

INSERT INTO `comercial_plataformas_pago` (`ID`, `Nombre`, `NIT`, `Activa`, `Updated`, `Sync`) VALUES
(1,	'SisteCredito',	811007713,	1,	'2019-04-11 09:17:16',	'0000-00-00 00:00:00');

UPDATE `menu_submenus` SET `idCarpeta` = '10' WHERE `menu_submenus`.`ID` = 173;
UPDATE `menu_submenus` SET `Pagina` = 'DocumentosContables.php' WHERE `menu_submenus`.`ID` = 173;
UPDATE `menu_submenus` SET `Estado` = '0' WHERE `menu_submenus`.`ID` = 172;

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES
(11,	'ordenesdecompra',	0,	0,	1,	'PDF_Documentos.draw.php?idDocumento=5&ID=',	1,	1,	0,	'2019-03-01 23:38:30',	'2018-03-01 23:38:30');

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES
(12,	'vista_factura_compra_totales',	0,	0,	1,	'PDF_Documentos.draw.php?idDocumento=23&ID=',	1,	1,	0,	'2019-03-01 23:38:30',	'2018-03-01 23:38:30');

ALTER TABLE `subcuentas`
  DROP `Cuentas_idPUC`;

ALTER TABLE `subcuentas` ADD `SolicitaBase` INT NOT NULL AFTER `Valor`;
UPDATE `subcuentas` SET `SolicitaBase`=1 WHERE SUBSTRING(`PUC`, 1, 4) = '2365';
UPDATE `subcuentas` SET `SolicitaBase`=1 WHERE SUBSTRING(`PUC`, 1, 4) = '2367';
UPDATE `subcuentas` SET `SolicitaBase`=1 WHERE SUBSTRING(`PUC`, 1, 4) = '2368';
UPDATE `subcuentas` SET `SolicitaBase`=1 WHERE SUBSTRING(`PUC`, 1, 4) = '1355';

INSERT INTO `cuentas` (`idPUC`, `Nombre`, `Valor`, `GupoCuentas_PUC`, `Updated`, `Sync`) VALUES
('1235',	'TITULOS',	NULL,	'',	'2019-04-25 13:03:10',	'0000-00-00 00:00:00');

CREATE TABLE `pos_registro_descuentos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TablaItem` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorDescuento` double NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(190,	'Configuracion General',	1,	3,	0,	'configuracion_general',	1,	'onclick=\"SeleccioneTablaDB(`configuracion_general`)\";',	'configuracion_general.php',	'_SELF',	1,	'configuracion.png',	7,	'2019-05-01 11:17:41',	'2018-05-01 11:17:41');


CREATE TABLE `contabilidad_parametros_cuentasxpagar` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `contabilidad_parametros_cuentasxpagar` (`ID`, `CuentaPUC`, `Updated`, `Sync`) VALUES
(1,	2205,	'2019-05-22 16:53:04',	'0000-00-00 00:00:00'),
(2,	220505,	'2019-05-22 16:53:04',	'0000-00-00 00:00:00');



CREATE TABLE `documentos_contables_registro_bases` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idDocumentoContable` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Base` double NOT NULL,
  `Porcentaje` double NOT NULL,
  `ValorPorcentaje` double NOT NULL,
  `Valor` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `idItemDocumentoContable` bigint(20) NOT NULL,
  `TipoMovimiento` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idDocumentoContable` (`idDocumentoContable`),
  KEY `idItemDocumentoContable` (`idItemDocumentoContable`),
  KEY `Estado` (`Estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(191,	'Dar de baja o alta a un insumo',	25,	3,	0,	'',	0,	'',	'BajaAlta.php',	'_BLANK',	1,	'bajaalta.jpg',	3,	'2019-06-03 08:57:08',	'2019-01-12 09:12:44');



CREATE TABLE `contabilidad_parametros_cuentasxcobrar` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `contabilidad_parametros_cuentasxcobrar` (`ID`, `CuentaPUC`, `Updated`, `Sync`) VALUES
(1,130505,	'2019-06-10 14:24:08',	'0000-00-00 00:00:00');

INSERT INTO `documentos_contables` (`ID`, `Prefijo`, `Nombre`, `Descripcion`, `Updated`, `Sync`) VALUES
(12,	'CC-12',	'COMPROBANTE DE EGRESO',	'Para realizar egresos de dinero',	'2019-04-11 09:01:47',	'2019-04-10 09:01:47'),
(13,	'CC-13',	'COMPROBANTE DE INGRESO',	'Para realizar ingresos de dinero',	'2019-06-10 09:07:07',	'2019-04-10 09:01:47');


UPDATE `menu_submenus` SET `Estado` = '0' WHERE `menu_submenus`.`ID` = 191;
INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(12,	'../modulos/inventarios/',	'2019-06-22 10:09:52',	'2019-04-07 09:14:07');

UPDATE `menu_submenus` SET `Nombre` = 'Dar de baja o alta a un producto o insumo' WHERE `menu_submenus`.`ID` = 72;
UPDATE `menu_submenus` SET `idCarpeta` = '12' WHERE `menu_submenus`.`ID` = 72;
UPDATE `menu_submenus` SET `Pagina` = 'BajasAltas.php' WHERE `menu_submenus`.`ID` = 72;

CREATE TABLE `inventario_comprobante_movimientos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `inventario_comprobante_movimientos_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `TipoMovimiento` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobante` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `restaurante_mesas` CHANGE `Estado` `Estado` INT(11) NOT NULL;
ALTER TABLE `restaurante_mesas` ADD `idUser` INT NOT NULL AFTER `Estado`;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(10,	'Determina cuantas copias saldrán al momento de imprimir un pedido de restaurante',	'2',	'2019-03-19 16:47:01',	'2019-03-18 16:47:01');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(11,	'Determina cuantas copias saldrán al momento de imprimir una precuenta de restaurante',	'1',	'2019-03-19 16:47:01',	'2019-03-18 16:47:01');

ALTER TABLE `restaurante_pedidos_items` ADD `TotalCostos` DOUBLE NOT NULL AFTER `Total`;

ALTER TABLE `inventario_comprobante_movimientos_items` ADD `CostoUnitario` DOUBLE NOT NULL AFTER `Estado`, ADD `CostoTotal` DOUBLE NOT NULL AFTER `CostoUnitario`;

UPDATE librodiario t1 INNER JOIN facturas t2 ON t1.Num_Documento_Interno=t2.idFacturas SET t1.Num_Documento_Externo=t2.NumeroFactura 
WHERE t1.Tipo_Documento_Intero='FACTURA';

ALTER TABLE `restaurante_pedidos` ADD `Tipo` VARCHAR(20) NOT NULL AFTER `Estado`;

CREATE TABLE `restaurante_registro_ventas_mesero` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Total` double NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idCierre` (`idCierre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `inventario_comprobante_movimientos_items` ADD `idCierre` BIGINT NOT NULL AFTER `idComprobante`;

ALTER TABLE `restaurante_cierres` ADD `Observaciones` TEXT NOT NULL AFTER `Hora`;

ALTER TABLE `traslados_items` ADD `idCierre` BIGINT NOT NULL AFTER `CodigoBarras4`;
ALTER TABLE `traslados_items` ADD INDEX(`idCierre`);
ALTER TABLE `factura_compra_items` ADD `idCierre` DOUBLE NOT NULL AFTER `PrecioVenta`;
ALTER TABLE `inventario_comprobante_movimientos_items` ADD INDEX(`TablaOrigen`);
ALTER TABLE `inventario_comprobante_movimientos_items` ADD INDEX(`idProducto`);
ALTER TABLE `inventario_comprobante_movimientos_items` ADD INDEX(`idComprobante`);
ALTER TABLE `inventario_comprobante_movimientos_items` ADD INDEX(`idCierre`);

ALTER TABLE `modelos_agenda` CHANGE `Estado` `Estado` INT(2) NOT NULL;

ALTER TABLE `modelos_agenda` ADD INDEX(`idModelo`);
ALTER TABLE `modelos_agenda` ADD INDEX(`idCierre`);
ALTER TABLE `modelos_agenda` ADD INDEX(`Estado`);
ALTER TABLE `modelos_agenda` ADD `HoraFinalizacion` DATETIME NOT NULL AFTER `HoraATerminar`;
ALTER TABLE `modelos_agenda` ADD `TipoServicio` INT NOT NULL AFTER `idModelo`;
ALTER TABLE `modelos_agenda` ADD INDEX(`TipoServicio`);


CREATE TABLE `modelos_pagos_realizados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` datetime NOT NULL,
  `idModelo` int(11) NOT NULL,
  `ValorPagado` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idModelo` (`idModelo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `modelos_tipo_servicios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Servicio` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `ValorModelo` double NOT NULL,
  `Tiempo` int(11) NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `librodiario` ADD `idCierre` BIGINT NOT NULL AFTER `idUsuario`, ADD INDEX `idCierre` (`idCierre`);

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(36,	'INFORME DE CIERRE',	'001',	'F-GC-003',	'2019-08-28',	'',	'',	'2019-01-31 12:08:58',	'2019-06-12 10:41:11');


INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(13,	'../modulos/restaurante/',	'2019-06-22 10:09:52',	'2019-04-07 09:14:07');

UPDATE `menu_submenus` SET `idCarpeta` = '13',`Pagina` = 'pos2.php' WHERE `menu_submenus`.`ID` = 83;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(192,	'Historial de Cierres',	30,	13,	0,	'',	0,	'',	'historial_cierres_restaurante.php',	'_BLANK',	CONV('1', 2, 10) + 0,	'historial.png',	1,	'2019-08-29 15:31:53',	'2019-01-23 11:16:14');


INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES
(14,	'restaurante_cierres',	0,	0,	1,	'PDF_Documentos.draw.php?idDocumento=36&ID=',	1,	1,	0,	'2019-01-23 06:07:37',	'2019-01-23 11:12:27');

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(14,	'../modulos/acompanantes/',	'2019-06-22 10:09:52',	'2019-04-07 09:14:07');

ALTER TABLE `productosventa` ADD `ValorComision4` INT NOT NULL AFTER `ValorComision3`;
ALTER TABLE `inventarios_temporal` ADD `ValorComision4` INT NOT NULL AFTER `ValorComision3`;

ALTER TABLE `restaurante_resumen_cierre` ADD `TotalPropinas4` DOUBLE NOT NULL AFTER `TotalPropinas3`;

