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

ALTER TABLE `servidores` ADD `Puerto` INT NOT NULL AFTER `DataBase`, ADD `TipoServidor` VARCHAR(15) NOT NULL AFTER `Puerto`, ADD `Observaciones` TEXT NOT NULL AFTER `TipoServidor`;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(21,	'Ruta para almacenar los xml de las Notas Debito de Factura electronica',	'../../SoportesTS5/ND_XML_Facturas_Electronicas/',	'2019-12-09 09:10:51',	'2019-09-13 19:18:01'),
(20,	'Ruta para almacenar los pdf de las Notas Debito de Factura electronica',	'../../SoportesTS5/ND_PDF_Facturas_Electronicas/',	'2019-12-09 09:10:48',	'2019-09-13 19:18:01'),
(19,	'Ruta para almacenar los xml de las Notas Credito de Factura electronica',	'../../SoportesTS5/NC_XML_Facturas_Electronicas/',	'2019-12-09 09:08:02',	'2019-09-13 19:18:01'),
(18,	'Ruta para almacenar los pdf de las Notas Credito de Factura electronica',	'../../SoportesTS5/NC_PDF_Facturas_Electronicas/',	'2019-12-09 09:08:02',	'2019-09-13 19:18:01'),
(17,	'Ruta para almacenar las facturas electronicas en XML',	'../../SoportesTS5/XML_Facturas_Electronicas/',	'2019-12-09 09:08:02',	'2019-09-13 19:18:01'),
(16,	'Ruta para almacenar las facturas electronicas en PDF',	'../../SoportesTS5/PDF_Facturas_Electronicas/',	'2019-12-09 09:08:02',	'2019-09-13 19:18:01'),
(15,	'RUTA SERVIDOR FTP PARA ALOJAR ARCHIVOS GENERADOS PARA GESTION DE GLOSAS',	'd\\:\\xampp\\htdocs\\ts_eps\\soportes\\glosas\\xml\\',	'2019-01-13 09:04:49',	'2019-01-13 09:04:49'),
(14,	'RUTA LOCAL PARA ALOJAR ARCHIVOS GENERADOS PARA GESTION DE GLOSAS',	'../../htdocs/tss/SoportesSalud/GestionGlosas/XML/',	'2019-01-13 09:04:49',	'2019-01-13 09:04:49');


CREATE TABLE `facturas_electronicas_contador` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaHabilitacion` date NOT NULL,
  `FechaVencimiento` date NOT NULL,
  `NumeroTransaccionesDisponibles` int(11) NOT NULL,
  `TransaccionesActuales` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_electronicas_log` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RespuestaCompletaServidor` longtext COLLATE utf8_spanish_ci NOT NULL,
  `UUID` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaPDF` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaXML` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  `PDFCreado` int(11) NOT NULL,
  `ZIPCreado` int(11) NOT NULL,
  `EnviadoPorMail` int(11) NOT NULL,
  `FechaReporte` datetime NOT NULL,
  `Created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_electronicas_log_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `facturas_electronicas_log_estados` (`ID`, `NombreEstado`) VALUES
(1,	'Verificada'),
(2,	'Completada'),
(10,	'Error'),
(11,	'Factura Sin Items'),
(12,	'No hubo respuesta del API'),
(13,	'Error de estructura o de datos'),
(20,	'No hay respuesta, debe intentarse de nuevo'),
(30,	'Documento Corregido');

CREATE TABLE `facturas_electronicas_parametros` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Recurso` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` text COLLATE utf8_spanish_ci NOT NULL,
  `Clave` text COLLATE utf8_spanish_ci NOT NULL,
  `Funcion` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `facturas_electronicas_parametros` (`ID`, `Recurso`, `Valor`, `Clave`, `Funcion`) VALUES
(1,	'Certificado Digital',	'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',	'cnec7KU922',	'Certificado digital para la generacion de facturas'),
(2,	'Identificador de Software ante la DIAN',	'7166f2cf-1c23-4256-babc-6590588ec878',	'12345',	'habilitacion del software ante la DIAN'),
(3,	'llave tecnica de la Resolucion de la DIAN',	'fc8eac422eba16e22ffd8c6f94b3f40a6e38162c',	'',	''),
(4,	'Token Cliente TS5',	'8Jb24CVCVm6cKNprE4jLmOR3J0H2E5s7hQeRi4rRGsK3Elcp8wImVnN9CtDBu74vjhA0w8t3vFGjNCXi',	'',	'Token que da el API de factura electronica identificando el Cliente TS5');

INSERT INTO `servidores` (`ID`, `IP`, `Nombre`, `Usuario`, `Password`, `DataBase`, `Puerto`, `TipoServidor`, `Observaciones`, `Updated`, `Sync`) VALUES
(100,	'http://35.238.236.240/api/ubl2.1/config/',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la creacion de una empresa en el servidor de Facturacion electronica, ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:45:26',	'2019-01-13 09:14:10'),
(101,	'http://35.238.236.240/api/ubl2.1/config/software',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la configuracion del software en el servidor de Facturacion electronica, ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:49:32',	'2019-01-13 09:14:10'),
(102,	'http://35.238.236.240/api/ubl2.1/config/certificate',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la configuracion del certificado digital en el servidor de Facturacion electronica, ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:50:24',	'2019-01-13 09:14:10'),
(103,	'http://35.238.236.240/api/ubl2.1/config/resolution',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la configuracion de la resolucion de facturacion electronica en el servidor de Facturacion electronica, ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:50:24',	'2019-01-13 09:14:10'),
(104,	'http://35.238.236.240/api/ubl2.1/invoice/6ce20f05-a1e4-4188-ab56-8d8e366746e6',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la el envío de una factura electronica, para habilitar el servidor real dejar la ruta solo hasta invoice  ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:50:24',	'2019-01-13 09:14:10'),
(200,	'172.16.26.192',	'SERVIDOR PARA REGISTRO DE GLOSAS',	'admin',	'pirlo1985',	'',	21,	'FTP',	'Servidor FTP para Uso General',	'2019-12-09 07:45:35',	'0000-00-00 00:00:00');


ALTER TABLE `prod_codbarras` ADD `TablaOrigen` VARCHAR(45) NOT NULL  DEFAULT 'productosventa' AFTER `CodigoBarras`;


INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(23,	'Configura el cuerpo del mensaje a enviar en una factura electronica',	'Cordial Saludo <strong> @RazonSocial </strong>,\r\n<br><br>\r\nPor medio del presente nos permitimos enviarle su factura electrónica @NumeroFactura .\r\n<br><br>\r\nQue tenga un excelente día.\r\n ',	'2019-12-11 21:02:13',	'0000-00-00 00:00:00'),
(22,	'Configura el asunto a mostrar cuando se envia una factura electronica.',	'<strong>FACTURA ELECTRÓNICA @NumeroFactura </strong>',	'2019-12-11 20:58:45',	'0000-00-00 00:00:00');


INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(25,	'Determina el metodo de envío de correo electrónico, 1 para php nativo (Windows), 2 para phpmailer (LINUX).',	'1',	'2019-12-12 13:13:50',	'0000-00-00 00:00:00'),
(24,	'Se configura el Correo que envía la factura electronica',	'technosolucionesfe@gmail.com',	'2019-12-12 03:09:23',	'0000-00-00 00:00:00');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(25,	'Determina el metodo de envío de correo electrónico, 1 para php nativo (Windows), 2 para phpmailer (LINUX).',	'2',	'2019-12-12 13:13:50',	'0000-00-00 00:00:00');

CREATE TABLE `configuracion_correos_smtp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SMTPSecure` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Host` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Port` bigint(20) NOT NULL,
  `Username` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_correos_smtp` (`ID`, `SMTPSecure`, `Host`, `Port`, `Username`, `Password`, `Updated`, `Sync`) VALUES
(1,	'ssl',	'smtp.gmail.com',	465,	'technosolucionesfe@gmail.com',	'pirlo1985',	'2019-12-17 11:35:35',	'0000-00-00 00:00:00');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(50,	'Facturacion Electronica',	3,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 09:12:43',	'2019-01-13 09:12:43');

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(14,	'../modulos/factura_electronica/',	'2019-06-22 10:09:52',	'2019-04-07 09:14:07');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(193,	'Notas Credito',	50,	14,	0,	'',	0,	'',	'notas_credito_fe.php',	'_BLANK',	1,	'notas_credito.png',	2,	'2019-12-13 10:14:11',	'2019-01-12 09:12:44'),
(192,	'Panel de Facturacion Electronica',	50,	14,	0,	'',	0,	'',	'panel_factura_electronica.php',	'_BLANK',	1,	'factura_electronica.png',	1,	'2019-12-13 10:14:59',	'2019-01-12 09:12:44');



CREATE TABLE `notas_credito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idFactura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Estado` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `notas_credito_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idItemFactura` bigint(20) NOT NULL,
  `idNotaCredito` bigint(20) NOT NULL,
  `TablaItems` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitarioItem` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Dias` double NOT NULL,
  `SubtotalItem` double NOT NULL,
  `IVAItem` double NOT NULL,
  `ValorOtrosImpuestos` double NOT NULL,
  `TotalItem` double NOT NULL,
  `PorcentajeIVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idOtrosImpuestos` int(11) NOT NULL,
  `idPorcentajeIVA` int(11) NOT NULL,
  `PrecioCostoUnitario` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `TipoItem` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

