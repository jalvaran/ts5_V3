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


INSERT INTO `servidores` (`ID`, `IP`, `Nombre`, `Usuario`, `Password`, `DataBase`, `Puerto`, `TipoServidor`, `Observaciones`, `Updated`, `Sync`) VALUES
(100,	'http://35.238.236.240/api/ubl2.1/config/',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la creacion de una empresa en el servidor de Facturacion electronica, ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:45:26',	'2019-01-13 09:14:10'),
(101,	'http://35.238.236.240/api/ubl2.1/config/software',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la configuracion del software en el servidor de Facturacion electronica, ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:49:32',	'2019-01-13 09:14:10'),
(102,	'http://35.238.236.240/api/ubl2.1/config/certificate',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la configuracion del certificado digital en el servidor de Facturacion electronica, ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:50:24',	'2019-01-13 09:14:10'),
(103,	'http://35.238.236.240/api/ubl2.1/config/resolution',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la configuracion de la resolucion de facturacion electronica en el servidor de Facturacion electronica, ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:50:24',	'2019-01-13 09:14:10'),
(104,	'http://35.238.236.240/api/ubl2.1/invoice/6ce20f05-a1e4-4188-ab56-8d8e366746e6',	'SERVIDOR FACTURACION ELECTRONICA',	'',	'',	'',	0,	'REST',	'Ruta para la el envío de una factura electronica, para habilitar el servidor real dejar la ruta solo hasta invoice  ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-09 07:50:24',	'2019-01-13 09:14:10'),
(200,	'172.16.26.192',	'SERVIDOR PARA REGISTRO DE GLOSAS',	'admin',	'pirlo1985',	'',	21,	'FTP',	'Servidor FTP para Uso General',	'2019-12-09 07:45:35',	'0000-00-00 00:00:00');

INSERT INTO `servidores` (`ID`, `IP`, `Nombre`, `Usuario`, `Password`, `DataBase`, `Puerto`, `TipoServidor`, `Observaciones`, `Updated`, `Sync`) VALUES
(105,	'http://35.238.236.240/api/ubl2.1/credit-note/662be8f7-6f1a-4b34-894c-1e1f0e2f43eb',	'SERVIDOR NOTAS CREDITO ELECTRONICAS',	'',	'',	'',	0,	'REST',	'Ruta para la el envío de una nota credito electronica, para habilitar el servidor real dejar la ruta solo hasta invoice  ver: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-20 21:06:14',	'2019-01-13 09:14:10'),
(106,	'http://35.238.236.240/api/ubl2.1/logs/',	'VALIDAR LOGS DE UN DOCUMENTO ELECTRONICO',	'',	'',	'',	0,	'REST',	'Esta ruta devuelve el log de un documento, debe acompañarse por el uuid, ver documentacion: http://35.238.236.240/api/ubl2.1/documentation',	'2019-12-20 21:06:14',	'2019-01-13 09:14:10');

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



INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(28,	'Determina si se envía correo de notificacion al cliente con la factura electronica',	'0',	'2019-12-22 10:34:26',	'0000-00-00 00:00:00'),
(27,	'Determina el metodo de envio de un documento electronico, 1 para sinrono(De esta manera el test de la DIAN no suma y se obtienen mas datos al momento de la respuesta) 2 ASincrono (no se puede consultar inmediatamente si el documento fue aceptado o no pero realiza el conteo del documento en el test)',	'1',	'2019-12-22 10:25:18',	'0000-00-00 00:00:00'),
(26,	'Determina el los dias que tendrá el cliente para rechazar una factura electronica, si no se recibe el acuse de recibo se cambiará a aceptado automaticamente despues de los dias establecidos en este parametro',	'8',	'2019-12-12 13:13:50',	'0000-00-00 00:00:00');


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


CREATE TABLE `facturas_electronicas_estados_acuse` (
  `ID` varchar(2) NOT NULL,
  `NombreEstadoAcuse` varchar(25) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `facturas_electronicas_estados_acuse` (`ID`, `NombreEstadoAcuse`, `Updated`, `Sync`) VALUES
('0',	'Rechazado',	'2019-12-23 16:03:27',	'0000-00-00 00:00:00'),
('1',	'Aceptado',	'2019-12-23 16:03:27',	'0000-00-00 00:00:00'),
('11',	'Aceptacion Automatica',	'2019-12-23 16:03:27',	'0000-00-00 00:00:00'),
('',	'Esperando Acuse',	'2019-12-23 16:03:27',	'0000-00-00 00:00:00');

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
  `LogsDocumento` text COLLATE utf8_spanish_ci NOT NULL,
  `AcuseRecibo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `FechaReporte` datetime NOT NULL,
  `Created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`),
  KEY `Estado` (`Estado`),
  KEY `AcuseRecibido` (`AcuseRecibo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_electronicas_log_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `facturas_electronicas_log_estados` (`ID`, `NombreEstado`, `Updated`, `Sync`) VALUES
(1,	'Verificada',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(2,	'Completada',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(10,	'Error',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(11,	'Factura Sin Items',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(12,	'No hubo respuesta del API',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(13,	'Error de estructura o de datos',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(20,	'No hay respuesta, debe intentarse de nuevo',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(30,	'Documento Corregido',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00');

CREATE TABLE `facturas_electronicas_parametros` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Recurso` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` text COLLATE utf8_spanish_ci NOT NULL,
  `Clave` text COLLATE utf8_spanish_ci NOT NULL,
  `Funcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `facturas_electronicas_parametros` (`ID`, `Recurso`, `Valor`, `Clave`, `Funcion`, `Updated`, `Sync`) VALUES
(1,	'Certificado Digital',	'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',	'thET5qHgup',	'Certificado digital para la generacion de facturas',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(2,	'Identificador de Software ante la DIAN',	'df23549e-d959-42df-9a56-022f2706a514',	'12345',	'habilitacion del software ante la DIAN',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(3,	'llave tecnica de la Resolucion de la DIAN',	'fc8eac422eba16e22ffd8c6f94b3f40a6e38162c',	'',	'',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(4,	'Token Cliente TS5',	'D6581Lz696nNTWYDOgJHdACC1dzjQeuYTTyiiwbJ5YKz4TucppYYUZWBNgsjV5VbwpQV2gbrDDJdgs95',	'',	'Token que da el API de factura electronica identificando el Cliente TS5',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00');


CREATE TABLE `notas_credito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idFactura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `idFacturaElectronica` bigint(20) NOT NULL,
  `RespuestaCompletaServidor` longtext COLLATE utf8_spanish_ci NOT NULL,
  `UUID` text COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaPDF` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `RutaXML` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `PDFCreado` int(11) NOT NULL,
  `AcuseRecibo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `LogsDocumento` text COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Estado` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`),
  KEY `idFacturaElectronica` (`idFacturaElectronica`),
  KEY `AcuseRecibido` (`AcuseRecibo`),
  KEY `Estado` (`Estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `notas_credito_conceptos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `TipoDocumento` bigint(20) unsigned NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Codigo` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created` timestamp NULL DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `notas_credito_conceptos` (`ID`, `TipoDocumento`, `Nombre`, `Codigo`, `Created`, `Updated`, `Sync`) VALUES
(1,	5,	'Devolución de parte de los bienes; no aceptación de partes del servicio',	'1',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(2,	5,	'Anulación de factura electrónica',	'2',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(3,	5,	'Rebaja total aplicada',	'3',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(4,	5,	'Descuento total aplicado',	'4',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(5,	5,	'Rescisión: nulidad por falta de requisitos',	'5',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(6,	5,	'Otros',	'6',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(7,	6,	'Intereses',	'1',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(8,	6,	'Gastos por cobrar',	'2',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(9,	6,	'Cambio del valor',	'3',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00'),
(10,	6,	'Otros',	'4',	'2019-12-12 21:23:51',	'2019-12-19 20:53:15',	'0000-00-00 00:00:00');

CREATE TABLE `notas_credito_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idItemFactura` bigint(20) NOT NULL,
  `idFacturaElectronica` bigint(20) NOT NULL,
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



ALTER TABLE `clientes` ADD `TipoOrganizacion` INT(5) UNSIGNED  NOT NULL AFTER `CIUU`;
ALTER TABLE `proveedores` ADD `TipoOrganizacion` INT(5) UNSIGNED  NOT NULL AFTER `CIUU`;

ALTER TABLE `proveedores` ADD `Plazo` INT(5) UNSIGNED  NOT NULL AFTER `Cupo`;
ALTER TABLE `clientes` ADD `Plazo` INT(5) UNSIGNED  NOT NULL AFTER `Cupo`;

ALTER TABLE `restaurante_cierres` ADD `EfectivoEnCaja` DOUBLE NOT NULL AFTER `Observaciones`;
ALTER TABLE `restaurante_cierres` ADD `Diferencia` DOUBLE NOT NULL AFTER `EfectivoEnCaja`;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(30,	'Dias de plazo para pagar una cuota en el modulo acuerdo de pagos',	'5',	'2019-12-22 10:34:26',	'0000-00-00 00:00:00');


ALTER TABLE `usuarios` ADD `Cargo` INT(5) UNSIGNED ZEROFILL NOT NULL AFTER `TipoUser`;
ALTER TABLE `usuarios` ADD `Proceso` INT(5) UNSIGNED ZEROFILL NOT NULL AFTER `Cargo`;

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(15,	'../modulos/tickets/',	'2019-06-22 10:09:52',	'2019-04-07 09:14:07');

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `CSS_Clase`, `Orden`, `Updated`, `Sync`) VALUES
(33,	'Tickets',	1,	'MnuTickets.php',	'_BLANK',	1,	'tickets.png',	'fa fa-share',	16,	'2019-01-13 09:12:42',	'2019-01-13 09:12:42');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(51,	'Tickets',	33,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 09:12:43',	'2019-01-13 09:12:43');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(195,	'Tickets',	51,	15,	33,	'',	0,	'',	'tickets.php',	'_BLANK',	1,	'tickets.png',	1,	'2020-02-21 11:51:51',	'2019-01-12 09:12:44'),
(194,	'Informes',	51,	15,	33,	'',	0,	'',	'adminTickets.php',	'_BLANK',	1,	'admin.png',	1,	'2020-02-21 11:51:51',	'2019-01-12 09:12:44');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(31,	'Determina si se envía correo de notificacion al realizar un ticket',	'1',	'2019-12-23 16:47:38',	'0000-00-00 00:00:00');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(32,	'Determina si es obligatorio pedir la foto en un acuerdo de pago',	'1',	'2019-12-23 16:47:38',	'0000-00-00 00:00:00');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(33,	'Determina si se verifica que un cliente tenga datos adicionales para guardar un acuerdo de pago',	'1',	'2019-12-23 16:47:38',	'0000-00-00 00:00:00');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(34,	'Determina si debe verificarse que el cliente tenga un recomendado para guardar un acuerdo de pago',	'1',	'2019-12-23 16:47:38',	'0000-00-00 00:00:00');


CREATE TABLE `clientes_datos_adicionales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCliente` bigint(20) NOT NULL,
  `SobreNombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `LugarTrabajo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cargo` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `DireccionTrabajo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TelefonoTrabajo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Facebook` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Instagram` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCliente` (`idCliente`),
  KEY `SobreNombre` (`SobreNombre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `clientes_recomendados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCliente` bigint(20) NOT NULL,
  `NombreRecomendado` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `DireccionRecomendado` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TelefonoRecomendado` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `DireccionTrabajoRecomendado` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TelefonoTrabajoRecomendado` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCliente` (`idCliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(36,	'INFORME DE CIERRE DE RESTAURANTE',	'001',	'F-GC-036',	'2020-02-22',	'',	'',	'2019-04-06 14:18:54',	'2019-04-06 14:18:54');


INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(37,	'ACUERDO DE PAGO',	'001',	'F-GC-037',	'2020-02-22',	'',	'',	'2019-04-06 14:18:54',	'2019-04-06 14:18:54');

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(36,	'Cuenta para registrar los saldos de facturas negativas de un cliente, se contabiliza como un anticipo',	28050503,	'ANTICIPOS REALIZADOS POR CLIENTES EN FACTURAS A FAVOR',	'2019-02-26 15:55:46',	'2019-02-26 15:55:46'),
(35,	'Anticipos realizados por clientes para los encargos',	28050502,	'ANTICIPOS REALIZADOS POR CLIENTES EN ENCARGOS',	'2020-02-25 05:56:46',	'2019-02-26 15:55:46');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(35,	'Determina si una factura negativa debe llevarse a una ganancia ocasional y no devolver el dinero al cliente en el POS',	'0',	'2019-12-23 16:47:38',	'0000-00-00 00:00:00');

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(37,	'Cuenta para Contabilizar un ingreso no operacional',	47057001,	'INGRESOS NO OPERACIONALES POR DEVOLUCIONES EN POS',	'2019-01-13 09:12:55',	'2019-01-13 09:12:55');

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(38,	'Cuenta para Contabilizar un ingreso no operacional por recargos o intereses',	47057002,	'INGRESOS NO OPERACIONALES POR RECARGOS O INTERESES',	'2019-01-13 09:12:55',	'2019-01-13 09:12:55');

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `SolicitaBase`, `Updated`, `Sync`) VALUES
(47057001,	'INGRESOS NO OPERACIONALES POR DEVOLUCIONES EN POS',	'0',	0,	'2019-04-24 15:48:18',	'2019-04-24 15:48:18');


INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `SolicitaBase`, `Updated`, `Sync`) VALUES
(47057002,	'INGRESOS NO OPERACIONALES POR RECARGOS O INTERESES',	'0',	0,	'2019-04-24 15:48:18',	'2019-04-24 15:48:18');


INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `SolicitaBase`, `Updated`, `Sync`) VALUES
(28050503,	'SALDO A FAVOR DE CLIENTES POR DEVOLUCIONES',	'0',	0,	'2019-04-24 15:48:18',	'2019-04-24 15:48:18');

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `SolicitaBase`, `Updated`, `Sync`) VALUES
(28050501,	'ANTICIPOS REALIZADOS POR CLIENTES EN SEPARADOS',	'0',	0,	'2019-04-24 15:48:18',	'2019-04-24 15:48:18');


INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `SolicitaBase`, `Updated`, `Sync`) VALUES
(28050502,	'ANTICIPOS REALIZADOS POR CLIENTES EN ENCARGOS',	'0',	0,	'2019-04-24 15:48:18',	'2019-04-24 15:48:18');


CREATE TABLE `restaurante_estados_pedidos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `restaurante_estados_pedidos` (`ID`, `NombreEstado`, `Updated`, `Sync`) VALUES
(1,	'ABIERTO',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(2,	'CERRADO',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(3,	'RE ABIERTO',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(4,	'PREPARADO',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(5,	'ENVIADO',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(6,	'ENTREGADO',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(7,	'ANULADO',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00');

CREATE TABLE `restaurante_tipos_pedido` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `restaurante_tipos_pedido` (`ID`, `Nombre`, `Updated`, `Sync`) VALUES
(1,	'MESAS',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(2,	'DOMICILIO',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(3,	'LLEVAR',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00'),
(4,	'BARRA',	'2020-02-22 19:56:37',	'0000-00-00 00:00:00');

CREATE TABLE `factura_compra_notas_devolucion` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `idCentroCostos` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `restaurante_registro_propinas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `Efectivo` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(52,	'Acuerdos de pago',	2,	4,	CONV('1', 2, 10) + 0,	'2019-01-13 09:12:43',	'2019-01-13 09:12:43');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(197,	'Listados de Cartera',	52,	8,	0,	'acuerdos_pago',	1,	'onclick=\"SeleccioneTablaDB(`acuerdos_pago`)\";',	'informesAcuerdosPago.php',	'_SELF',	1,	'informes5.png',	1,	'2019-01-13 09:12:44',	'2018-01-13 09:12:44'),
(196,	'Panel de Administracion',	52,	8,	0,	'acuerdos_pago',	1,	'onclick=\"SeleccioneTablaDB(`acuerdos_pago`)\";',	'adminAcuerdosPago.php',	'_SELF',	1,	'acuerdo.png',	1,	'2019-01-13 09:12:44',	'2018-01-13 09:12:44');

INSERT INTO `configuracion_tablas_acciones_adicionales` (`ID`, `TablaDB`, `JavaScript`, `ClaseIcono`, `Titulo`, `Ruta`, `Target`, `Updated`, `Sync`) VALUES
('',	'vista_documentos_contables',	'onclick=AbrirDocumento',	'fa fa-fw fa-history',	'Abrir',	'#',	'_SELF',	'2020-03-01 10:33:56',	'2019-04-07 08:23:24');

ALTER TABLE `facturas` ADD INDEX(`FormaPago`);
ALTER TABLE `facturas` ADD INDEX(`Clientes_idClientes`);
ALTER TABLE `facturas_items` ADD INDEX(`GeneradoDesde`);
ALTER TABLE `facturas_items` ADD INDEX(`NumeroIdentificador`);

ALTER TABLE `documentos_contables_items` ADD `Fecha` DATE NOT NULL AFTER `idDocumento`;
ALTER TABLE `acuerdo_pago` ADD `idFactura` VARCHAR(45) NOT NULL AFTER `idAcuerdoPago`;
ALTER TABLE `acuerdo_pago` ADD INDEX(`idFactura`);

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(198,	'Procesos Contables',	16,	10,	0,	'',	0,	'',	'ProcesosContables.php',	'_BLANK',	1,	'contabilidad.jpg',	5,	'2019-01-13 09:12:44',	'2019-01-13 09:12:44');


DROP TABLE IF EXISTS `cierres_contables` ;
CREATE TABLE `cierres_contables` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(38,	'BALANCE DE COMPROBACION POR TERCEROS',	'001',	'F-GF-002',	'2017-08-09',	'',	'',	'2019-03-31 09:07:01',	'2019-03-31 15:57:34');


CREATE TABLE `cierre_contable_control` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idDocumentoContable` bigint(20) NOT NULL COMMENT 'Docuemento contable con el que se crea el cierre',
  `Anio` int(4) NOT NULL COMMENT 'Anio del cierre',
  `CerrarCuentasResultado` int(11) NOT NULL COMMENT '1 indica que las cuentas de resultado fueron cerradas',
  `TrasladarSaldosBalance` int(11) NOT NULL COMMENT '1 indica que las cuentas del balance fueron trasladadas',
  `ContabilizarCierre` int(11) NOT NULL COMMENT '1 indica que el cierre fué contabilizado',
  `idUser` int(11) NOT NULL COMMENT 'usuario que lo realiza',
  `Estado` int(11) NOT NULL COMMENT '1 para abierto, 2 para cerrado, 3 para anulado',
  `Created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de Creacion',
  PRIMARY KEY (`ID`),
  KEY `idDocumentoContable` (`idDocumentoContable`),
  KEY `Anio` (`Anio`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `acuerdo_pago_cuotas_pagadas` ADD `Estado` INT NOT NULL DEFAULT '1' AFTER `idUser`;

CREATE TABLE `acuerdo_pago_rel_abonos_comprobantes` (
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobante` bigint(20) NOT NULL,
  `Created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  KEY `idAcuerdoPago` (`idAcuerdoPago`),
  KEY `idComprobante` (`idComprobante`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `acuerdo_pago_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Created` date NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `acuerdo_pago_abonos_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAbono` bigint(20) NOT NULL,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Created` date NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`),
  KEY `idAbono` (`idAbono`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `clientes` ADD INDEX(`Num_Identificacion`);
ALTER TABLE `proveedores` ADD INDEX(`Num_Identificacion`);
ALTER TABLE `clientes` ADD `Puntaje` INT NOT NULL DEFAULT '80' AFTER `Soporte`, ADD `Estado` INT NOT NULL AFTER `Puntaje`;
ALTER TABLE `proveedores` ADD `Puntaje` INT NOT NULL DEFAULT '80' AFTER `Soporte`, ADD `Estado` INT NOT NULL AFTER `Puntaje`;

INSERT INTO `acuerdo_pago_estados` (`ID`, `NombreEstado`, `Observaciones`, `Created`, `Updated`, `Sync`) VALUES
(12,	'Reportado por Usuario',	'Se Reporta y se beta al usuario',	'0000-00-00 00:00:00',	'2020-02-22 14:56:35',	'0000-00-00 00:00:00');

ALTER TABLE `prod_codbarras` ADD INDEX(`ProductosVenta_idProductosVenta`);
ALTER TABLE `prod_codbarras` ADD INDEX(`CodigoBarras`);

ALTER TABLE `clientes` ADD `DiaNacimiento` INT NOT NULL AFTER `Cupo`, ADD `MesNacimiento` INT NOT NULL AFTER `DiaNacimiento`;
ALTER TABLE `proveedores` ADD `DiaNacimiento` INT NOT NULL AFTER `Cupo`, ADD `MesNacimiento` INT NOT NULL AFTER `DiaNacimiento`;

ALTER TABLE `clientes` ADD `Created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `Estado`;
ALTER TABLE `proveedores` ADD `Created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `Estado`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(199,	'Inteligencia de Negocio',	18,	16,	0,	'',	1,	'',	'inteligencia.php',	'_SELF',	1,	'inteligencia.png',	5,	'2019-04-08 09:14:07',	'2019-04-08 09:14:07');

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(16,	'../modulos/inteligencia/',	'2019-06-22 10:09:52',	'2019-04-07 09:14:07');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(200,	'Administrador de inventarios',	22,	12,	0,	'',	1,	'',	'adminInventarios.php',	'_SELF',	1,	'admin.png',	13,	'2020-06-02 15:25:19',	'2019-01-13 09:12:44');


ALTER TABLE `cajas_aperturas_cierres` ADD `EfectivoRecaudado` DOUBLE NULL AFTER `TotalEntrega`;

