-- Adminer 4.7.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `abonos_libro`;
CREATE TABLE `abonos_libro` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Cantidad` float NOT NULL,
  `idLibroDiario` bigint(20) NOT NULL,
  `idComprobanteContable` bigint(20) NOT NULL,
  `TipoAbono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `activos`;
CREATE TABLE `activos` (
  `idActivos` int(16) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreAct` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Marca` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Serie` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorEstimado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Bodega` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idActivos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `act_movimientos`;
CREATE TABLE `act_movimientos` (
  `idAct_Movimientos` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MotivoMovimiento` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `BodegaDestino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Movimientos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `act_ordenes`;
CREATE TABLE `act_ordenes` (
  `idAct_Ordenes` int(16) NOT NULL AUTO_INCREMENT,
  `NumOrden` int(16) NOT NULL,
  `idAct_Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cerrada` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Ordenes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `act_pre_movimientos`;
CREATE TABLE `act_pre_movimientos` (
  `idAct_Movimientos` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MotivoMovimiento` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `BodegaDestino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Movimientos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `act_pre_ordenes`;
CREATE TABLE `act_pre_ordenes` (
  `idAct_Ordenes` int(16) NOT NULL DEFAULT '0',
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idAct_Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acueducto_configuraciones`;
CREATE TABLE `acueducto_configuraciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ConsumoBase` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acueducto_lecturas`;
CREATE TABLE `acueducto_lecturas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `LecturaContador` bigint(20) NOT NULL,
  `Facturado` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `alertas`;
CREATE TABLE `alertas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AlertaTipo` varchar(45) NOT NULL,
  `Mensaje` text NOT NULL,
  `Estado` int(11) NOT NULL,
  `TablaOrigen` varchar(100) NOT NULL,
  `idTabla` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `autorizaciones_generales`;
CREATE TABLE `autorizaciones_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Proceso` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clave` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `bodega`;
CREATE TABLE `bodega` (
  `idBodega` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idServidor` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idBodega`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cajas`;
CREATE TABLE `cajas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Base` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUCEfectivo` bigint(20) NOT NULL,
  `CuentaPUCCheques` bigint(20) NOT NULL,
  `CuentaPUCOtros` bigint(20) NOT NULL,
  `CuentaPUCIVAEgresos` bigint(20) NOT NULL,
  `idTerceroIntereses` bigint(20) NOT NULL COMMENT 'Nit del Tercero al que se va a ir la cuent x parar de intereses',
  `idEmpresa` int(11) NOT NULL DEFAULT '1',
  `idSucursal` int(11) NOT NULL DEFAULT '1',
  `CentroCostos` int(11) NOT NULL,
  `idResolucionDian` int(11) NOT NULL,
  `idBascula` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `cajas` (`ID`, `Nombre`, `Base`, `idUsuario`, `Estado`, `CuentaPUCEfectivo`, `CuentaPUCCheques`, `CuentaPUCOtros`, `CuentaPUCIVAEgresos`, `idTerceroIntereses`, `idEmpresa`, `idSucursal`, `CentroCostos`, `idResolucionDian`, `idBascula`, `Updated`, `Sync`) VALUES
(1,	'CAJA 1',	'200000',	3,	'ABIERTA',	110510,	11100502,	11100503,	240801,	900833180,	1,	1,	1,	3,	1,	'2019-03-08 17:02:05',	'2019-03-08 12:02:05'),
(2,	'CAJA 2',	'200000',	1,	'ABIERTA',	11051002,	11100502,	11100503,	240801,	900833180,	1,	1,	1,	2,	0,	'2019-03-08 17:02:05',	'2019-03-08 12:02:05'),
(3,	'CAJA 3',	'150000',	0,	'ABIERTA',	11051002,	11100502,	11100503,	240801,	900833180,	1,	1,	1,	1,	0,	'2019-03-08 17:02:05',	'2019-03-08 12:02:05');

DROP TABLE IF EXISTS `cajas_aperturas_cierres`;
CREATE TABLE `cajas_aperturas_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` int(11) NOT NULL,
  `idCaja` int(11) NOT NULL,
  `Efectivo` double NOT NULL,
  `Devueltas` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `AbonosCreditos` double NOT NULL,
  `AbonosSisteCredito` double NOT NULL,
  `TotalEgresos` double NOT NULL,
  `TotalEfectivo` double NOT NULL,
  `TotalVentas` double NOT NULL,
  `TotalVentasContado` double NOT NULL,
  `TotalVentasCredito` double NOT NULL,
  `TotalVentasSisteCredito` double NOT NULL,
  `TotalRetiroSeparados` double NOT NULL,
  `TotalDevoluciones` double NOT NULL,
  `TotalTarjetas` double NOT NULL,
  `TotalCheques` double NOT NULL,
  `TotalOtros` double NOT NULL,
  `TotalEntrega` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cartera`;
CREATE TABLE `cartera` (
  `idCartera` int(11) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FechaIngreso` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Fecha en la que ingresa a Cartera',
  `FechaVencimiento` date NOT NULL DEFAULT '0000-00-00',
  `DiasCartera` int(11) DEFAULT NULL,
  `idCliente` varchar(45) NOT NULL DEFAULT '0',
  `RazonSocial` varchar(100) DEFAULT NULL,
  `Telefono` varchar(45) NOT NULL,
  `Contacto` varchar(45) NOT NULL,
  `TelContacto` varchar(45) NOT NULL,
  `TotalFactura` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `Saldo` double NOT NULL DEFAULT '0',
  `Observaciones` text,
  `TipoCartera` varchar(45) NOT NULL DEFAULT 'Interna',
  `idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCartera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `centrocosto`;
CREATE TABLE `centrocosto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `centrocosto` (`ID`, `Nombre`, `EmpresaPro`, `Updated`, `Sync`) VALUES
(1,	'PRINCIPAL',	1,	'2019-01-13 14:04:37',	'2019-01-13 09:04:37');

DROP TABLE IF EXISTS `cierres_contables`;
CREATE TABLE `cierres_contables` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ciuu`;
CREATE TABLE `ciuu` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `ciuu` (`Codigo`, `Descripcion`, `Updated`, `Sync`) VALUES
(10,	' Asalariados',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(11,	'Cultivos agr?colas transitorios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(12,	'Cultivos agr?colas permanentes.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(13,	'Propagaci?n de plantas (actividades de los viveros, excepto viveros forestales).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(14,	'Ganader?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(15,	'Explotaci?n mixta (agr?cola y pecuaria).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(16,	'Actividades de apoyo a la agricultura y la ganader?a, y actividades posteriores a la cosecha.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(17,	'Caza ordinaria y mediante trampas y actividades de servicios conexas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(21,	'Silvicultura y otras actividades forestales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(22,	'Extracci?n de madera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(23,	'Recolecci?n de productos forestales diferentes a la madera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(24,	'Servicios de apoyo a la silvicultura.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(31,	'Pesca.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(32,	'Acuicultura.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(46,	'omercio al por mayor y en comisi?n o por contrata, excepto el comercio de veh?culos automotores y motocicletas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(51,	'Extracci?n de hulla (carb?n de piedra).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(52,	'Extracci?n de carb?n lignito.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(61,	'Extracci?n de petr?leo crudo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(62,	'Extracci?n de gas natural.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(71,	'Extracci?n de minerales de hierro.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(72,	'Extracci?n de minerales metal?feros no ferrosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(81,	' Personas Naturales sin Actividad Econ?mica',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(82,	' Personas Naturales Subsidiadas por Terceros',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(89,	'Extracci?n de otros minerales no met?licos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(90,	' Rentistas de Capital, solo para personas naturales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(91,	'Actividades de apoyo para la extracci?n de petr?leo y de gas natural.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(99,	'Actividades de apoyo para otras actividades de explotaci?n de minas y canteras.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(101,	'Procesamiento y conservaci?n de carne, pescado, crust?ceos y moluscos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(102,	'Procesamiento y conservaci?n de frutas, legumbres, hortalizas y tub?rculos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(103,	'Elaboraci?n de aceites y grasas de origen vegetal y animal.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(104,	'Elaboraci?n de productos l?cteos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(105,	'Elaboraci?n de productos de moliner?a, almidones y productos derivados del almid',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(106,	'Elaboraci?n de productos de caf',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(107,	'Elaboraci?n de az?car y panela.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(108,	'Elaboraci?n de otros productos alimenticios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(109,	'Elaboraci?n de alimentos preparados para animales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(110,	'Elaboraci?n de bebidas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(111,	' Cultivo de cereales (excepto arroz), legumbres y semillas oleaginosas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(112,	' Cultivo de arroz.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(113,	' Cultivo de hortalizas, ra?ces y tub?rculos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(114,	' Cultivo de tabaco.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(115,	' Cultivo de plantas textiles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(119,	' Otros cultivos transitorios n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(120,	'Elaboraci?n de productos de tabaco.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(121,	' Cultivo de frutas tropicales y subtropicales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(122,	' Cultivo de pl?tano y banano.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(123,	' Cultivo de caf',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(124,	' Cultivo de ca?a de az?car.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(125,	' Cultivo de flor de corte.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(126,	' Cultivo de palma para aceite (palma africana) y otros frutos oleaginosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(127,	' Cultivo de plantas con las que se preparan bebidas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(128,	' Cultivo de especias y de plantas arom?ticas y medicinales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(129,	' Otros cultivos permanentes n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(130,	' Propagaci?n de plantas (actividades de los viveros, excepto viveros forestales).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(131,	'Preparaci?n, hilatura, tejedur?a y acabado de productos textiles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(139,	'Fabricaci?n de otros productos textiles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(141,	'Confecci?n de prendas de vestir, excepto prendas de piel.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(142,	'Fabricaci?n de art?culos de piel.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(143,	'Fabricaci?n de art?culos de punto y ganchillo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(144,	' Cr?a de ganado porcino.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(145,	' Cr?a de aves de corral.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(149,	' Cr?a de otros animales n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(150,	' Explotaci?n mixta (agr?cola y pecuaria).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(151,	'Curtido y recurtido de cueros; fabricaci?n de art?culos de viaje, bolsos de mano y art?culos similares, y fabricaci?n de art?culos de talabarter?a y guarnicioner?a, adobo y te?ido de pieles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(152,	'Fabricaci?n de calzado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(161,	'Aserrado, acepillado e impregnaci?n de la madera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(162,	'Fabricaci?n de hojas de madera para enchapado; fabricaci?n de tableros contrachapados, tableros laminados, tableros de part?culas y otros tableros y paneles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(163,	'Fabricaci?n de partes y piezas de madera, de carpinter?a y ebanister?a para la construcci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(164,	'Fabricaci?n de recipientes de madera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(169,	'Fabricaci?n de otros productos de madera; fabricaci?n de art?culos de corcho, cester?a y esparter?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(170,	'Fabricaci?n de papel, cart?n y productos de papel y cart',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(181,	'Actividades de impresi?n y actividades de servicios relacionados con la impresi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(182,	'Producci?n de copias a partir de grabaciones originales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(191,	'Fabricaci?n de productos de hornos de coque.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(192,	'Fabricaci?n de productos de la refinaci?n del petr?leo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(201,	'Fabricaci?n de sustancias qu?micas b?sicas, abonos y compuestos inorg?nicos nitrogenados, pl?sticos y caucho sint?tico en formas primarias.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(202,	'Fabricaci?n de otros productos qu?micos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(203,	'Fabricaci?n de fibras sint?ticas y artificiales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(210,	'Fabricaci?n de productos farmac?uticos, sustancias qu?micas medicinales y productos bot?nicos de uso farmac?utico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(220,	' Extracci?n de madera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(221,	'Fabricaci?n de productos de caucho.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(222,	'Fabricaci?n de productos de pl?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(230,	' Recolecci?n de productos forestales diferentes a la madera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(231,	'Fabricaci?n de vidrio y productos de vidrio.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(239,	'Fabricaci?n de productos minerales no met?licos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(240,	' Servicios de apoyo a la silvicultura.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(241,	'Industrias b?sicas de hierro y de acero.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(242,	'Industrias b?sicas de metales preciosos y de metales no ferrosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(243,	'Fundici?n de metales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(251,	'Fabricaci?n de productos met?licos para uso estructural, tanques, dep?sitos y generadores de vapor.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(252,	'Fabricaci?n de armas y municiones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(259,	'Fabricaci?n de otros productos elaborados de metal y actividades de servicios relacionadas con el trabajo de metales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(261,	'Fabricaci?n de componentes y tableros electr?nicos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(262,	'Fabricaci?n de computadoras y de equipo perif?rico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(263,	'Fabricaci?n de equipos de comunicaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(264,	'Fabricaci?n de aparatos electr?nicos de consumo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(265,	'Fabricaci?n de equipo de medici?n, prueba, navegaci?n y control; fabricaci?n de relojes.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(266,	'Fabricaci?n de equipo de irradiaci?n y equipo electr?nico de uso m?dico y terap?utico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(267,	'Fabricaci?n de instrumentos ?pticos y equipo fotogr?fico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(268,	'Fabricaci?n de medios magn?ticos y ?pticos para almacenamiento de datos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(271,	'Fabricaci?n de motores, generadores y transformadores el?ctricos y de aparatos de distribuci?n y control de la energ?a el?ctrica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(272,	'Fabricaci?n de pilas, bater?as y acumuladores el?ctricos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(273,	'Fabricaci?n de hilos y cables aislados y sus dispositivos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(274,	'Fabricaci?n de equipos el?ctricos de iluminaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(275,	'Fabricaci?n de aparatos de uso dom?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(279,	'Fabricaci?n de otros tipos de equipo el?ctrico n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(281,	'Fabricaci?n de maquinaria y equipo de uso general.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(282,	'Fabricaci?n de maquinaria y equipo de uso especial.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(291,	'Fabricaci?n de veh?culos automotores y sus motores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(292,	'Fabricaci?n de carrocer?as para veh?culos automotores; fabricaci?n de remolques y semirremolques.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(293,	'Fabricaci?n de partes, piezas (autopartes) y accesorios (lujos) para veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(301,	'Construcci?n de barcos y otras embarcaciones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(302,	'Fabricaci?n de locomotoras y de material rodante para ferrocarriles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(303,	'Fabricaci?n de aeronaves, naves espaciales y de maquinaria conexa.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(304,	'Fabricaci?n de veh?culos militares de combate.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(309,	'Fabricaci?n de otros tipos de equipo de transporte n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(311,	'Fabricaci?n de muebles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(312,	'Fabricaci?n de colchones y somieres.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(321,	'Fabricaci?n de joyas, bisuter?a y art?culos conexos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(322,	'Fabricaci?n de instrumentos musicales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(323,	'Fabricaci?n de art?culos y equipo para la pr?ctica del deporte.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(324,	'Fabricaci?n de juegos, juguetes y rompecabezas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(325,	'Fabricaci?n de instrumentos, aparatos y materiales m?dicos y odontol?gicos (incluido mobiliario).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(329,	'Otras industrias manufactureras n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(331,	'Mantenimiento y reparaci?n especializado de productos elaborados en metal y de maquinaria y equipo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(332,	'Instalaci?n especializada de maquinaria y equipo industrial.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(351,	'Generaci?n, transmisi?n, distribuci?n y comercializaci?n de energ?a el?ctrica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(352,	'Producci?n de gas; distribuci?n de combustibles gaseosos por tuber?as.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(353,	'Suministro de vapor y aire acondicionado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(360,	'Captaci?n, tratamiento y distribuci?n de agua.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(370,	'Evacuaci?n y tratamiento de aguas residuales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(381,	'Recolecci?n de desechos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(382,	'Tratamiento y disposici?n de desechos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(383,	'Recuperaci?n de materiales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(390,	'Actividades de saneamiento ambiental y otros servicios de gesti?n de desechos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(411,	'Construcci?n de edificios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(421,	'Construcci?n de carreteras y v?as de ferrocarril.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(422,	'Construcci?n de proyectos de servicio p?blico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(429,	'Construcci?n de otras obras de ingenier?a civil.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(431,	'Demolici?n y preparaci?n del terreno.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(432,	'Instalaciones el?ctricas, de fontaner?a y otras instalaciones especializadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(433,	'Terminaci?n y acabado de edificios y obras de ingenier?a civil.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(439,	'Otras actividades especializadas para la construcci?n de edificios y obras de ingenier?a civil.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(451,	'Comercio de veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(452,	'Mantenimiento y reparaci?n de veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(453,	'Comercio de partes, piezas (autopartes) y accesorios (lujos) para veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(454,	'Comercio, mantenimiento y reparaci?n de motocicletas y de sus partes, piezas y accesorios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(461,	'Comercio al por mayor a cambio de una retribuci?n o por contrata.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(462,	'Comercio al por mayor de materias primas agropecuarias; animales vivos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(463,	'Comercio al por mayor de alimentos, bebidas y tabaco.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(464,	'Comercio al por mayor de art?culos y enseres dom?sticos (incluidas prendas de vestir).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(465,	'Comercio al por mayor de maquinaria y equipo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(466,	'Comercio al por mayor especializado de otros productos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(469,	'Comercio al por mayor no especializado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(471,	'Comercio al por menor en establecimientos no especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(472,	'Comercio al por menor de alimentos (v?veres en general), bebidas y tabaco, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(473,	'Comercio al por menor de combustible, lubricantes, aditivos y productos de limpieza para automotores, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(474,	'Comercio al por menor de equipos de inform?tica y de comunicaciones, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(475,	'Comercio al por menor de otros enseres dom?sticos en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(476,	'Comercio al por menor de art?culos culturales y de entretenimiento, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(477,	'Comercio al por menor de otros productos en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(478,	'Comercio al por menor en puestos de venta m?viles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(479,	'Comercio al por menor no realizado en establecimientos, puestos de venta o mercados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(491,	'Transporte f?rreo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(492,	'Transporte terrestre p?blico automotor.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(493,	'Transporte por tuber?as.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(501,	'Transporte mar?timo y de cabotaje.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(502,	'Transporte fluvial.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(510,	' Extracci?n de hulla (carb?n de piedra).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(511,	'Transporte a?reo de pasajeros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(512,	'Transporte a?reo de carga.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(520,	' Extracci?n de carb?n lignito.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(521,	'Almacenamiento y dep?sito.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(522,	'Actividades de las estaciones, v?as y servicios complementarios para el transporte.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(531,	'Actividades postales nacionales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(532,	'Actividades de mensajer?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(551,	'Actividades de alojamiento de estancias cortas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(552,	'Actividades de zonas de camping y parques para veh?culos recreacionales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(553,	'Servicio por horas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(559,	'Otros tipos de alojamiento n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(561,	'Actividades de restaurantes, cafeter?as y servicio m?vil de comidas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(562,	'Actividades de catering para eventos y otros servicios de comidas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(563,	'Expendio de bebidas alcoh?licas para el consumo dentro del establecimiento.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(581,	'Edici?n de libros, publicaciones peri?dicas y otras actividades de edici',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(582,	'Edici?n de programas de inform?tica (software).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(591,	'Actividades de producci?n de pel?culas cinematogr?ficas, video y producci?n de programas, anuncios y comerciales de televisi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(592,	'Actividades de grabaci?n de sonido y edici?n de m?sica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(601,	'Actividades de programaci?n y transmisi?n en el servicio de radiodifusi?n sonora.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(602,	'Actividades de programaci?n y transmisi?n de televisi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(610,	' Extracci?n de petr?leo crudo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(611,	'Actividades de telecomunicaciones al?mbricas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(612,	'Actividades de telecomunicaciones inal?mbricas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(613,	'Actividades de telecomunicaci?n satelital.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(619,	'Otras actividades de telecomunicaciones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(620,	'Desarrollo de sistemas inform?ticos (planificaci?n, an?lisis, dise?o, programaci?n, pruebas), consultor?a inform?tica y actividades relacionadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(631,	'Procesamiento de datos, alojamiento (hosting) y actividades relacionadas; portales web.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(639,	'Otras actividades de servicio de informaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(641,	'Intermediaci?n monetaria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(642,	'Otros tipos de intermediaci?n monetaria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(643,	'Fideicomisos, fondos (incluye fondos de cesant?as) y entidades financieras similares.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(649,	'Otras actividades de servicio financiero, excepto las de seguros y pensiones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(651,	'Seguros y capitalizaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(652,	'Servicios de seguros sociales de salud y riesgos profesionales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(653,	'Servicios de seguros sociales de pensiones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(661,	'Actividades auxiliares de las actividades de servicios financieros, excepto las de seguros y pensiones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(662,	'Actividades de servicios auxiliares de los servicios de seguros y pensiones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(663,	'Actividades de administraci?n de fondos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(681,	'Actividades inmobiliarias realizadas con bienes propios o arrendados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(682,	'Actividades inmobiliarias realizadas a cambio de una retribuci?n o por contrata.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(691,	'Actividades jur?dicas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(692,	'Actividades de contabilidad, tenedur?a de libros, auditor?a financiera y asesor?a tributaria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(701,	'Actividades de administraci?n empresarial.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(702,	'Actividades de consultar?a de gesti',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(710,	' Extracci?n de minerales de hierro.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(711,	'Actividades de arquitectura e ingenier?a y otras actividades conexas de consultor?a t?cnica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(712,	'Ensayos y an?lisis t?cnicos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(721,	'Investigaciones y desarrollo experimental en el campo de las ciencias naturales y la ingenier?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(722,	'Investigaciones y desarrollo experimental en el campo de las ciencias sociales y las humanidades.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(723,	' Extracci?n de minerales de n?quel.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(729,	' Extracci?n de otros minerales metal?feros no ferrosos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(731,	'Publicidad.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(732,	'Estudios de mercado y realizaci?n de encuestas de opini?n p?blica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(741,	'Actividades especializadas de dise',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(742,	'Actividades de fotograf?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(749,	'Otras actividades profesionales, cient?ficas y t?cnicas n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(750,	'Actividades veterinarias.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(771,	'Alquiler y arrendamiento de veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(772,	'Alquiler y arrendamiento de efectos personales y enseres dom?sticos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(773,	'Alquiler y arrendamiento de otros tipos de maquinaria, equipo y bienes tangibles n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(774,	'Arrendamiento de propiedad intelectual y productos similares, excepto obras protegidas por derechos de autor.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(781,	'Actividades de agencias de empleo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(782,	'Actividades de agencias de empleo temporal.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(783,	'Otras actividades de suministro de recurso humano.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(791,	'Actividades de las agencias de viajes y operadores tur?sticos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(799,	'Otros servicios de reserva y actividades relacionadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(801,	'Actividades de seguridad privada.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(802,	'Actividades de servicios de sistemas de seguridad.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(803,	'Actividades de detectives e investigadores privados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(811,	'Actividades combinadas de apoyo a instalaciones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(812,	'Actividades de limpieza.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(813,	'Actividades de paisajismo y servicios de mantenimiento conexos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(820,	' Extracci?n de esmeraldas, piedras preciosas y semipreciosas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(821,	'Actividades administrativas y de apoyo de oficina.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(822,	'Actividades de centros de llamadas (Call center).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(823,	'Organizaci?n de convenciones y eventos comerciales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(829,	'Actividades de servicios de apoyo a las empresas n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(841,	'Administraci?n del Estado y aplicaci?n de la pol?tica econ?mica y social de la comunidad.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(842,	'Prestaci?n de servicios a la comunidad en general.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(843,	'Actividades de planes de seguridad social de afiliaci?n obligatoria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(851,	'Educaci?n de la primera infancia, preescolar y b?sica primaria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(852,	'Educaci?n secundaria y de formaci?n laboral.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(853,	'Establecimientos que combinan diferentes niveles de educaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(854,	'Educaci?n superior.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(855,	'Otros tipos de educaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(856,	'Actividades de apoyo a la educaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(861,	'Actividades de hospitales y cl?nicas, con internaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(862,	'Actividades de pr?ctica m?dica y odontol?gica, sin internaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(869,	'Otras actividades de atenci?n relacionadas con la salud humana.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(871,	'Actividades de atenci?n residencial medicalizada de tipo general.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(872,	'Actividades de atenci?n residencial, para el cuidado de pacientes con retardo mental, enfermedad mental y consumo de sustancias psicoactivas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(873,	'Actividades de atenci?n en instituciones para el cuidado de personas mayores y/o discapacitadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(879,	'Otras actividades de atenci?n en instituciones con alojamiento.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(881,	'Actividades de asistencia social sin alojamiento para personas mayores y discapacitadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(889,	'Otras actividades de asistencia social sin alojamiento.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(891,	' Extracci?n de minerales para la fabricaci?n de abonos y productos qu?micos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(892,	' Extracci?n de halita (sal).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(899,	' Extracci?n de otros minerales no met?licos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(900,	'Actividades creativas, art?sticas y de entretenimiento.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(910,	'Actividades de bibliotecas, archivos, museos y otras actividades culturales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(920,	'Actividades de juegos de azar y apuestas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(931,	'Actividades deportivas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(932,	'Otras actividades recreativas y de esparcimiento.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(941,	'Actividades de asociaciones empresariales y de empleadores, y asociaciones profesionales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(942,	'Actividades de sindicatos de empleados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(949,	'Actividades de otras asociaciones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(951,	'Mantenimiento y reparaci?n de computadores y equipo de comunicaciones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(952,	'Mantenimiento y reparaci?n de efectos personales y enseres dom?sticos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(960,	'Otras actividades de servicios personales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(970,	'Actividades de los hogares individuales como empleadores de personal dom?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(981,	'Actividades no diferenciadas de los hogares individuales como productores de bienes para uso propio.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(982,	'Actividades no diferenciadas de los hogares individuales como productores de servicios para uso propio.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(990,	'Actividades de organizaciones y entidades extraterritoriales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1011,	' Procesamiento y conservaci?n de carne y productos c?rnicos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1012,	' Procesamiento y conservaci?n de pescados, crust?ceos y moluscos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1020,	' Procesamiento y conservaci?n de frutas, legumbres, hortalizas y tub?rculos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1030,	' Elaboraci?n de aceites y grasas de origen vegetal y animal.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1040,	' Elaboraci?n de productos l?cteos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1051,	' Elaboraci?n de productos de moliner?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1052,	' Elaboraci?n de almidones y productos derivados del almid',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1061,	' Trilla de caf',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1062,	' Descafeinado, tosti?n y molienda del caf',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1063,	' Otros derivados del caf',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1071,	' Elaboraci?n y refinaci?n de az?car.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1072,	' Elaboraci?n de panela.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1081,	' Elaboraci?n de productos de panader?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1082,	' Elaboraci?n de cacao, chocolate y productos de confiter?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1083,	' Elaboraci?n de macarrones, fideos, alcuzcuz y productos farin?ceos similares.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1084,	' Elaboraci?n de comidas y platos preparados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1089,	' Elaboraci?n de otros productos alimenticios n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1090,	' Elaboraci?n de alimentos preparados para animales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1101,	' Destilaci?n, rectificaci?n y mezcla de bebidas alcoh?licas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1102,	' Elaboraci?n de bebidas fermentadas no destiladas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1103,	' Producci?n de malta, elaboraci?n de cervezas y otras bebidas malteadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1104,	' Elaboraci?n de bebidas no alcoh?licas, producci?n de aguas minerales y de otras aguas embotelladas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1200,	' Elaboraci?n de productos de tabaco.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1311,	' Preparaci?n e hilatura de fibras textiles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1312,	' Tejedur?a de productos textiles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1313,	' Acabado de productos textiles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1391,	' Fabricaci?n de tejidos de punto y ganchillo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1392,	' Confecci?n de art?culos con materiales textiles, excepto prendas de vestir.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1393,	' Fabricaci?n de tapetes y alfombras para pisos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1394,	' Fabricaci?n de cuerdas, cordeles, cables, bramantes y redes.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1399,	' Fabricaci?n de otros art?culos textiles n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1410,	' Confecci?n de prendas de vestir, excepto prendas de piel.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1420,	' Fabricaci?n de art?culos de piel.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1430,	' Fabricaci?n de art?culos de punto y ganchillo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1511,	' Curtido y recurtido de cueros; recurtido y te?ido de pieles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1512,	' Fabricaci?n de art?culos de viaje, bolsos de mano y art?culos similares elaborados en cuero, y fabricaci?n de art?culos de talabarter?a y guarnicioner?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1513,	' Fabricaci?n de art?culos de viaje, bolsos de mano y art?culos similares; art?culos de talabarter?a y guarnicioner?a elaborados en otros materiales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1521,	' Fabricaci?n de calzado de cuero y piel, con cualquier tipo de suela.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1522,	' Fabricaci?n de otros tipos de calzado, excepto calzado de cuero y piel.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1523,	' Fabricaci?n de partes del calzado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1610,	' Aserrado, acepillado e impregnaci?n de la madera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1620,	' Fabricaci?n de hojas de madera para enchapado; fabricaci?n de tableros contrachapados, tableros laminados, tableros de part?culas y otros tableros y paneles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1630,	' Fabricaci?n de partes y piezas de madera, de carpinter?a y ebanister?a para la construcci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1640,	' Fabricaci?n de recipientes de madera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1690,	' Fabricaci?n de otros productos de madera; fabricaci?n de art?culos de corcho, cester?a y esparter?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1701,	' Fabricaci?n de pulpas (pastas) celul?sicas; papel y cart',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1702,	' Fabricaci?n de papel y cart?n ondulado (corrugado); fabricaci?n de envases, empaques y de embalajes de papel y cart',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1709,	' Fabricaci?n de otros art?culos de papel y cart',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1811,	' Actividades de impresi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1812,	' Actividades de servicios relacionados con la impresi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1820,	' Producci?n de copias a partir de grabaciones originales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1910,	' Fabricaci?n de productos de hornos de coque.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1921,	' Fabricaci?n de productos de la refinaci?n del petr?leo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(1922,	' Actividad de mezcla de combustibles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2011,	' Fabricaci?n de sustancias y productos qu?micos b?sicos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2012,	' Fabricaci?n de abonos y compuestos inorg?nicos nitrogenados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2013,	' Fabricaci?n de pl?sticos en formas primarias.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2014,	' Fabricaci?n de caucho sint?tico en formas primarias.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2021,	' Fabricaci?n de plaguicidas y otros productos qu?micos de uso agropecuario.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2022,	' Fabricaci?n de pinturas, barnices y revestimientos similares, tintas para impresi?n y masillas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2023,	' Fabricaci?n de jabones y detergentes, preparados para limpiar y pulir; perfumes y preparados de tocador.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2029,	' Fabricaci?n de otros productos qu?micos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2030,	' Fabricaci?n de fibras sint?ticas y artificiales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2100,	' Fabricaci?n de productos farmac?uticos, sustancias qu?micas medicinales y productos bot?nicos de uso farmac?utico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2211,	' Fabricaci?n de llantas y neum?ticos de caucho',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2212,	' Reencauche de llantas usadas',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2219,	' Fabricaci?n de formas b?sicas de caucho y otros productos de caucho n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2221,	' Fabricaci?n de formas b?sicas de pl?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2229,	' Fabricaci?n de art?culos de pl?stico n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2310,	' Fabricaci?n de vidrio y productos de vidrio.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2391,	' Fabricaci?n de productos refractarios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2392,	' Fabricaci?n de materiales de arcilla para la construcci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2393,	' Fabricaci?n de otros productos de cer?mica y porcelana.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2394,	' Fabricaci?n de cemento, cal y yeso.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2395,	' Fabricaci?n de art?culos de hormig?n, cemento y yeso.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2396,	' Corte, tallado y acabado de la piedra.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2399,	' Fabricaci?n de otros productos minerales no met?licos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2410,	' Industrias b?sicas de hierro y de acero.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2421,	' Industrias b?sicas de metales preciosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2429,	' Industrias b?sicas de otros metales no ferrosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2431,	' Fundici?n de hierro y de acero.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2432,	' Fundici?n de metales no ferrosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2511,	' Fabricaci?n de productos met?licos para uso estructural.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2512,	' Fabricaci?n de tanques, dep?sitos y recipientes de metal, excepto los utilizados para el envase o transporte de mercanc?as.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2513,	' Fabricaci?n de generadores de vapor, excepto calderas de agua caliente para calefacci?n central.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2520,	' Fabricaci?n de armas y municiones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2591,	' Forja, prensado, estampado y laminado de metal; pulvimetalurgia.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2592,	' Tratamiento y revestimiento de metales; mecanizado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2593,	' Fabricaci?n de art?culos de cuchiller?a, herramientas de mano y art?culos de ferreter?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2599,	' Fabricaci?n de otros productos elaborados de metal n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2610,	' Fabricaci?n de componentes y tableros electr?nicos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2620,	' Fabricaci?n de computadoras y de equipo perif?rico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2630,	' Fabricaci?n de equipos de comunicaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2640,	' Fabricaci?n de aparatos electr?nicos de consumo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2651,	' Fabricaci?n de equipo de medici?n, prueba, navegaci?n y control.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2652,	' Fabricaci?n de relojes.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2660,	' Fabricaci?n de equipo de irradiaci?n y equipo electr?nico de uso m?dico y terap?utico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2670,	' Fabricaci?n de instrumentos ?pticos y equipo fotogr?fico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2680,	' Fabricaci?n de medios magn?ticos y ?pticos para almacenamiento de datos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2711,	' Fabricaci?n de motores, generadores y transformadores el?ctricos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2712,	' Fabricaci?n de aparatos de distribuci?n y control de la energ?a el?ctrica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2720,	' Fabricaci?n de pilas, bater?as y acumuladores el?ctricos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2731,	' Fabricaci?n de hilos y cables el?ctricos y de fibra ?ptica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2732,	' Fabricaci?n de dispositivos de cableado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2740,	' Fabricaci?n de equipos el?ctricos de iluminaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2750,	' Fabricaci?n de aparatos de uso dom?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2790,	' Fabricaci?n de otros tipos de equipo el?ctrico n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2811,	' Fabricaci?n de motores, turbinas, y partes para motores de combusti?n interna.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2812,	' Fabricaci?n de equipos de potencia hidr?ulica y neum?tica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2813,	' Fabricaci?n de otras bombas, compresores, grifos y v?lvulas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2814,	' Fabricaci?n de cojinetes, engranajes, trenes de engranajes y piezas de transmisi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2815,	' Fabricaci?n de hornos, hogares y quemadores industriales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2816,	' Fabricaci?n de equipo de elevaci?n y manipulaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2817,	' Fabricaci?n de maquinaria y equipo de oficina (excepto computadoras y equipo perif?rico).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2818,	' Fabricaci?n de herramientas manuales con motor.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2819,	' Fabricaci?n de otros tipos de maquinaria y equipo de uso general n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2821,	' Fabricaci?n de maquinaria agropecuaria y forestal.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2822,	' Fabricaci?n de m?quinas formadoras de metal y de m?quinas herramienta.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2823,	' Fabricaci?n de maquinaria para la metalurgia.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2824,	' Fabricaci?n de maquinaria para explotaci?n de minas y canteras y para obras de construcci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2825,	' Fabricaci?n de maquinaria para la elaboraci?n de alimentos, bebidas y tabaco.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2826,	' Fabricaci?n de maquinaria para la elaboraci?n de productos textiles, prendas de vestir y cueros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2829,	' Fabricaci?n de otros tipos de maquinaria y equipo de uso especial n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2910,	' Fabricaci?n de veh?culos automotores y sus motores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2920,	' Fabricaci?n de carrocer?as para veh?culos automotores; fabricaci?n de remolques y semirremolques.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(2930,	' Fabricaci?n de partes, piezas (autopartes) y accesorios (lujos) para veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3011,	' Construcci?n de barcos y de estructuras flotantes.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3012,	' Construcci?n de embarcaciones de recreo y deporte.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3020,	' Fabricaci?n de locomotoras y de material rodante para ferrocarriles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3030,	' Fabricaci?n de aeronaves, naves espaciales y de maquinaria conexa.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3040,	' Fabricaci?n de veh?culos militares de combate.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3091,	' Fabricaci?n de motocicletas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3092,	' Fabricaci?n de bicicletas y de sillas de ruedas para personas con discapacidad.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3099,	' Fabricaci?n de otros tipos de equipo de transporte n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3110,	' Fabricaci?n de muebles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3120,	' Fabricaci?n de colchones y somieres.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3210,	' Fabricaci?n de joyas, bisuter?a y art?culos conexos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3220,	' Fabricaci?n de instrumentos musicales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3230,	' Fabricaci?n de art?culos y equipo para la pr?ctica del deporte.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3240,	' Fabricaci?n de juegos, juguetes y rompecabezas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3250,	' Fabricaci?n de instrumentos, aparatos y materiales m?dicos y odontol?gicos (incluido mobiliario).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3290,	' Otras industrias manufactureras n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3311,	' Mantenimiento y reparaci?n especializado de productos elaborados en metal.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3312,	' Mantenimiento y reparaci?n especializado de maquinaria y equipo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3313,	' Mantenimiento y reparaci?n especializado de equipo electr?nico y ?ptico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3314,	' Mantenimiento y reparaci?n especializado de equipo el?ctrico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3315,	' Mantenimiento y reparaci?n especializado de equipo de transporte, excepto los veh?culos automotores, motocicletas y bicicletas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3319,	' Mantenimiento y reparaci?n de otros tipos de equipos y sus componentes n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3320,	' Instalaci?n especializada de maquinaria y equipo industrial.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3511,	' Generaci?n de energ?a el?ctrica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3512,	' Transmisi?n de energ?a el?ctrica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3513,	' Distribuci?n de energ?a el?ctrica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3514,	' Comercializaci?n de energ?a el?ctrica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3520,	' Producci?n de gas; distribuci?n de combustibles gaseosos por tuber?as.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3530,	' Suministro de vapor y aire acondicionado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3600,	' Captaci?n, tratamiento y distribuci?n de agua.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3700,	' Evacuaci?n y tratamiento de aguas residuales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3811,	' Recolecci?n de desechos no peligrosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3812,	' Recolecci?n de desechos peligrosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3821,	' Tratamiento y disposici?n de desechos no peligrosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3822,	' Tratamiento y disposici?n de desechos peligrosos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3830,	' Recuperaci?n de materiales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(3900,	' Actividades de saneamiento ambiental y otros servicios de gesti?n de desechos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4111,	' Construcci?n de edificios residenciales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4112,	' Construcci?n de edificios no residenciales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4210,	' Construcci?n de carreteras y v?as de ferrocarril.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4220,	' Construcci?n de proyectos de servicio p?blico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4290,	' Construcci?n de otras obras de ingenier?a civil.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4311,	' Demolici',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4312,	' Preparaci?n del terreno.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4321,	' Instalaciones el?ctricas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4322,	' Instalaciones de fontaner?a, calefacci?n y aire acondicionado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4329,	' Otras instalaciones especializadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4330,	' Terminaci?n y acabado de edificios y obras de ingenier?a civil.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4390,	' Otras actividades especializadas para la construcci?n de edificios y obras de ingenier?a civil.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4511,	' Comercio de veh?culos automotores nuevos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4512,	' Comercio de veh?culos automotores usados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4520,	' Mantenimiento y reparaci?n de veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4530,	' Comercio de partes, piezas (autopartes) y accesorios (lujos) para veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4541,	' Comercio de motocicletas y de sus partes, piezas y accesorios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4542,	' Mantenimiento y reparaci?n de motocicletas y de sus partes y piezas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4610,	' Comercio al por mayor a cambio de una retribuci?n o por contrata.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4620,	' Comercio al por mayor de materias primas agropecuarias; animales vivos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4631,	' Comercio al por mayor de productos alimenticios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4632,	' Comercio al por mayor de bebidas y tabaco.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4641,	' Comercio al por mayor de productos textiles, productos confeccionados para uso dom?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4642,	' Comercio al por mayor de prendas de vestir.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4643,	' Comercio al por mayor de calzado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4644,	' Comercio al por mayor de aparatos y equipo de uso dom?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4645,	' Comercio al por mayor de productos farmac?uticos, medicinales, cosm?ticos y de tocador.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4649,	' Comercio al por mayor de otros utensilios dom?sticos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4651,	' Comercio al por mayor de computadores, equipo perif?rico y programas de inform?tica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4652,	' Comercio al por mayor de equipo, partes y piezas electr?nicos y de telecomunicaciones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4653,	' Comercio al por mayor de maquinaria y equipo agropecuarios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4659,	' Comercio al por mayor de otros tipos de maquinaria y equipo n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4661,	' Comercio al por mayor de combustibles s?lidos, l?quidos, gaseosos y productos conexos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4662,	' Comercio al por mayor de metales y productos metal?feros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4663,	' Comercio al por mayor de materiales de construcci?n, art?culos de ferreter?a, pinturas, productos de vidrio, equipo y materiales de fontaner?a y calefacci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4664,	' Comercio al por mayor de productos qu?micos b?sicos, cauchos y pl?sticos en formas primarias y productos qu?micos de uso agropecuario.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4665,	' Comercio al por mayor de desperdicios, desechos y chatarra.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4669,	' Comercio al por mayor de otros productos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4690,	' Comercio al por mayor no especializado.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4711,	' Comercio al por menor en establecimientos no especializados con surtido compuesto principalmente por alimentos, bebidas o tabaco.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4719,	' Comercio al por menor en establecimientos no especializados, con surtido compuesto principalmente por productos diferentes de alimentos (v?veres en general), bebidas y tabaco.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4721,	' Comercio al por menor de productos agr?colas para el consumo en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4722,	' Comercio al por menor de leche, productos l?cteos y huevos, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4723,	' Comercio al por menor de carnes (incluye aves de corral), productos c?rnicos, pescados y productos de mar, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4724,	' Comercio al por menor de bebidas y productos del tabaco, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4729,	' Comercio al por menor de otros productos alimenticios n.c.p., en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4731,	' Comercio al por menor de combustible para automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4732,	' Comercio al por menor de lubricantes (aceites, grasas), aditivos y productos de limpieza para veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4741,	' Comercio al por menor de computadores, equipos perif?ricos, programas de inform?tica y equipos de telecomunicaciones en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4742,	' Comercio al por menor de equipos y aparatos de sonido y de video, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4751,	' Comercio al por menor de productos textiles en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4752,	' Comercio al por menor de art?culos de ferreter?a, pinturas y productos de vidrio en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4753,	' Comercio al por menor de tapices, alfombras y cubrimientos para paredes y pisos en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4754,	' Comercio al por menor de electrodom?sticos y gasodom?sticos de uso dom?stico, muebles y equipos de iluminaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4755,	' Comercio al por menor de art?culos y utensilios de uso dom?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4759,	' Comercio al por menor de otros art?culos dom?sticos en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4761,	' Comercio al por menor de libros, peri?dicos, materiales y art?culos de papeler?a y escritorio, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4762,	' Comercio al por menor de art?culos deportivos, en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4769,	' Comercio al por menor de otros art?culos culturales y de entretenimiento n.c.p. en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4771,	' Comercio al por menor de prendas de vestir y sus accesorios (incluye art?culos de piel) en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4772,	' Comercio al por menor de todo tipo de calzado y art?culos de cuero y suced?neos del cuero en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4773,	' Comercio al por menor de productos farmac?uticos y medicinales, cosm?ticos y art?culos de tocador en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4774,	' Comercio al por menor de otros productos nuevos en establecimientos especializados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4775,	' Comercio al por menor de art?culos de segunda mano.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4781,	' Comercio al por menor de alimentos, bebidas y tabaco, en puestos de venta m?viles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4782,	' Comercio al por menor de productos textiles, prendas de vestir y calzado, en puestos de venta m?viles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4789,	' Comercio al por menor de otros productos en puestos de venta m?viles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4791,	' Comercio al por menor realizado a trav?s de internet.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4792,	' Comercio al por menor realizado a trav?s de casas de venta o por correo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4799,	' Otros tipos de comercio al por menor no realizado en establecimientos, puestos de venta o mercados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4911,	' Transporte f?rreo de pasajeros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4912,	' Transporte f?rreo de carga.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4921,	' Transporte de pasajeros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4922,	' Transporte mixto.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4923,	' Transporte de carga por carretera.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(4930,	' Transporte por tuber?as.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5011,	' Transporte de pasajeros mar?timo y de cabotaje.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5012,	' Transporte de carga mar?timo y de cabotaje.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5021,	' Transporte fluvial de pasajeros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5022,	' Transporte fluvial de carga.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5111,	' Transporte a?reo nacional de pasajeros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5112,	' Transporte a?reo internacional de pasajeros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5121,	' Transporte a?reo nacional de carga.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5122,	' Transporte a?reo internacional de carga.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5210,	' Almacenamiento y dep?sito.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5221,	' Actividades de estaciones, v?as y servicios complementarios para el transporte terrestre.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5222,	' Actividades de puertos y servicios complementarios para el transporte acu?tico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5223,	' Actividades de aeropuertos, servicios de navegaci?n a?rea y dem?s actividades conexas al transporte a?reo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5224,	' Manipulaci?n de carga.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5229,	' Otras actividades complementarias al transporte.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5310,	' Actividades postales nacionales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5320,	' Actividades de mensajer?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5511,	' Alojamiento en hoteles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5512,	' Alojamiento en apartahoteles.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5513,	' Alojamiento en centros vacacionales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5514,	' Alojamiento rural.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5519,	' Otros tipos de alojamientos para visitantes.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5520,	' Actividades de zonas de camping y parques para veh?culos recreacionales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5530,	' Servicio por horas',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5590,	' Otros tipos de alojamiento n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5611,	' Expendio a la mesa de comidas preparadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5612,	' Expendio por autoservicio de comidas preparadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5613,	' Expendio de comidas preparadas en cafeter?as.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5619,	' Otros tipos de expendio de comidas preparadas n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5621,	' Catering para eventos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5629,	' Actividades de otros servicios de comidas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5630,	' Expendio de bebidas alcoh?licas para el consumo dentro del establecimiento.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5811,	' Edici?n de libros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5812,	' Edici?n de directorios y listas de correo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5813,	' Edici?n de peri?dicos, revistas y otras publicaciones peri?dicas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5819,	' Otros trabajos de edici',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5820,	' Edici?n de programas de inform?tica (software).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5911,	' Actividades de producci?n de pel?culas cinematogr?ficas, videos, programas, anuncios y comerciales de televisi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5912,	' Actividades de posproducci?n de pel?culas cinematogr?ficas, videos, programas, anuncios y comerciales de televisi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5913,	' Actividades de distribuci?n de pel?culas cinematogr?ficas, videos, programas, anuncios y comerciales de televisi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5914,	' Actividades de exhibici?n de pel?culas cinematogr?ficas y videos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(5920,	' Actividades de grabaci?n de sonido y edici?n de m?sica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6010,	' Actividades de programaci?n y transmisi?n en el servicio de radiodifusi?n sonora.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6020,	' Actividades de programaci?n y transmisi?n de televisi',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6110,	' Actividades de telecomunicaciones al?mbricas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6120,	' Actividades de telecomunicaciones inal?mbricas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6130,	' Actividades de telecomunicaci?n satelital.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6190,	' Otras actividades de telecomunicaciones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6201,	' Actividades de desarrollo de sistemas inform?ticos (planificaci?n, an?lisis, dise?o, programaci?n, pruebas).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6202,	' Actividades de consultor?a inform?tica y actividades de administraci?n de instalaciones inform?ticas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6209,	' Otras actividades de tecnolog?as de informaci?n y actividades de servicios inform?ticos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6311,	' Procesamiento de datos, alojamiento (hosting) y actividades relacionadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6312,	' Portales web.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6391,	' Actividades de agencias de noticias.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6399,	' Otras actividades de servicio de informaci?n n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6411,	' Banco Central.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6412,	' Bancos comerciales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6421,	' Actividades de las corporaciones financieras.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6422,	' Actividades de las compa??as de financiamiento.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6423,	' Banca de segundo piso.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6424,	' Actividades de las cooperativas financieras.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6431,	' Fideicomisos, fondos y entidades financieras similares.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6432,	' Fondos de cesant?as.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6491,	' Leasing financiero (arrendamiento financiero).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6492,	' Actividades financieras de fondos de empleados y otras formas asociativas del sector solidario.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6493,	' Actividades de compra de cartera o factoring.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6494,	' Otras actividades de distribuci?n de fondos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6495,	' Instituciones especiales oficiales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6499,	' Otras actividades de servicio financiero, excepto las de seguros y pensiones n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6511,	' Seguros generales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6512,	' Seguros de vida.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6513,	' Reaseguros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6514,	' Capitalizaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6521,	' Servicios de seguros sociales de salud.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6522,	' Servicios de seguros sociales de riesgos profesionales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6531,	' R?gimen de prima media con prestaci?n definida (RPM).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6532,	' R?gimen de ahorro individual (RAI).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6611,	' Administraci?n de mercados financieros.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6612,	' Corretaje de valores y de contratos de productos b?sicos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6613,	' Otras actividades relacionadas con el mercado de valores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6614,	' Actividades de las casas de cambio.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6615,	' Actividades de los profesionales de compra y venta de divisas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6619,	' Otras actividades auxiliares de las actividades de servicios financieros n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6621,	' Actividades de agentes y corredores de seguros',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6629,	' Evaluaci?n de riesgos y da?os, y otras actividades de servicios auxiliares',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6630,	' Actividades de administraci?n de fondos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6810,	' Actividades inmobiliarias realizadas con bienes propios o arrendados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6820,	' Actividades inmobiliarias realizadas a cambio de una retribuci?n o por contrata.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6910,	' Actividades jur?dicas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(6920,	' Actividades de contabilidad, tenedur?a de libros, auditor?a financiera y asesor?a tributaria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7010,	' Actividades de administraci?n empresarial.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7020,	' Actividades de consultar?a de gesti',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7110,	' Actividades de arquitectura e ingenier?a y otras actividades conexas de consultor?a t?cnica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7120,	' Ensayos y an?lisis t?cnicos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7210,	' Investigaciones y desarrollo experimental en el campo de las ciencias naturales y la ingenier?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7220,	' Investigaciones y desarrollo experimental en el campo de las ciencias sociales y las humanidades.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7310,	' Publicidad.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7320,	' Estudios de mercado y realizaci?n de encuestas de opini?n p?blica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7410,	' Actividades especializadas de dise',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7420,	' Actividades de fotograf?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7490,	' Otras actividades profesionales, cient?ficas y t?cnicas n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7500,	' Actividades veterinarias.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7710,	' Alquiler y arrendamiento de veh?culos automotores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7721,	' Alquiler y arrendamiento de equipo recreativo y deportivo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7722,	' Alquiler de videos y discos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7729,	' Alquiler y arrendamiento de otros efectos personales y enseres dom?sticos n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7730,	' Alquiler y arrendamiento de otros tipos de maquinaria, equipo y bienes tangibles n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7740,	' Arrendamiento de propiedad intelectual y productos similares, excepto obras protegidas por derechos de autor.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7810,	' Actividades de agencias de empleo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7820,	' Actividades de agencias de empleo temporal.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7830,	' Otras actividades de suministro de recurso humano.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7911,	' Actividades de las agencias de viaje.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7912,	' Actividades de operadores tur?sticos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(7990,	' Otros servicios de reserva y actividades relacionadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8010,	' Actividades de seguridad privada.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8020,	' Actividades de servicios de sistemas de seguridad.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8030,	' Actividades de detectives e investigadores privados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8110,	' Actividades combinadas de apoyo a instalaciones.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8121,	' Limpieza general interior de edificios.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8129,	' Otras actividades de limpieza de edificios e instalaciones industriales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8130,	' Actividades de paisajismo y servicios de mantenimiento conexos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8211,	' Actividades combinadas de servicios administrativos de oficina.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8219,	' Fotocopiado, preparaci?n de documentos y otras actividades especializadas de apoyo a oficina.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8220,	' Actividades de centros de llamadas (Call center).',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8230,	' Organizaci?n de convenciones y eventos comerciales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8291,	' Actividades de agencias de cobranza y oficinas de calificaci?n crediticia.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8292,	' Actividades de envase y empaque.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8299,	' Otras actividades de servicio de apoyo a las empresas n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8411,	' Actividades legislativas de la administraci?n p?blica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8412,	' Actividades ejecutivas de la administraci?n p?blica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8413,	' Regulaci?n de las actividades de organismos que prestan servicios de salud, educativos, culturales y otros servicios sociales, excepto servicios de seguridad social.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8414,	' Actividades reguladoras y facilitadoras de la actividad econ?mica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8415,	' Actividades de los otros ?rganos de control.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8421,	' Relaciones exteriores.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8422,	' Actividades de defensa.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8423,	' Orden p?blico y actividades de seguridad.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8424,	' Administraci?n de justicia.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8430,	' Actividades de planes de seguridad social de afiliaci?n obligatoria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8511,	' Educaci?n de la primera infancia.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8512,	' Educaci?n preescolar.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8513,	' Educaci?n b?sica primaria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8521,	' Educaci?n b?sica secundaria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8522,	' Educaci?n media acad?mica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8523,	' Educaci?n media t?cnica y de formaci?n laboral.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8530,	' Establecimientos que combinan diferentes niveles de educaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8541,	' Educaci?n t?cnica profesional.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8542,	' Educaci?n tecnol?gica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8543,	' Educaci?n de instituciones universitarias o de escuelas tecnol?gicas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8544,	' Educaci?n de universidades.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8551,	' Formaci?n acad?mica no formal.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8552,	' Ense?anza deportiva y recreativa.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8553,	' Ense?anza cultural.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8559,	' Otros tipos de educaci?n n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8560,	' Actividades de apoyo a la educaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8610,	' Actividades de hospitales y cl?nicas, con internaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8621,	' Actividades de la pr?ctica m?dica, sin internaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8622,	' Actividades de la pr?ctica odontol?gica.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8691,	' Actividades de apoyo diagn?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8692,	' Actividades de apoyo terap?utico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8699,	' Otras actividades de atenci?n de la salud humana.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8710,	' Actividades de atenci?n residencial medicalizada de tipo general.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8720,	' Actividades de atenci?n residencial, para el cuidado de pacientes con retardo mental, enfermedad mental y consumo de sustancias psicoactivas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8730,	' Actividades de atenci?n en instituciones para el cuidado de personas mayores y/o discapacitadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8790,	' Otras actividades de atenci?n en instituciones con alojamiento',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8810,	' Actividades de asistencia social sin alojamiento para personas mayores y discapacitadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(8890,	' Otras actividades de asistencia social sin alojamiento.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9001,	' Creaci?n literaria.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9002,	' Creaci?n musical.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9003,	' Creaci?n teatral.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9004,	' Creaci?n audiovisual.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9005,	' Artes pl?sticas y visuales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9006,	' Actividades teatrales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9007,	' Actividades de espect?culos musicales en vivo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9008,	' Otras actividades de espect?culos en vivo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9101,	' Actividades de bibliotecas y archivos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9102,	' Actividades y funcionamiento de museos, conservaci?n de edificios y sitios hist?ricos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9103,	' Actividades de jardines bot?nicos, zool?gicos y reservas naturales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9200,	' Actividades de juegos de azar y apuestas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9311,	' Gesti?n de instalaciones deportivas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9312,	' Actividades de clubes deportivos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9319,	' Otras actividades deportivas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9321,	' Actividades de parques de atracciones y parques tem?ticos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9329,	' Otras actividades recreativas y de esparcimiento n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9411,	' Actividades de asociaciones empresariales y de empleadores',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9412,	' Actividades de asociaciones profesionales',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9420,	' Actividades de sindicatos de empleados.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9491,	' Actividades de asociaciones religiosas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9492,	' Actividades de asociaciones pol?ticas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9499,	' Actividades de otras asociaciones n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9511,	' Mantenimiento y reparaci?n de computadores y de equipo perif?rico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9512,	' Mantenimiento y reparaci?n de equipos de comunicaci',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9521,	' Mantenimiento y reparaci?n de aparatos electr?nicos de consumo.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9522,	' Mantenimiento y reparaci?n de aparatos y equipos dom?sticos y de jardiner?a.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9523,	' Reparaci?n de calzado y art?culos de cuero.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9524,	' Reparaci?n de muebles y accesorios para el hogar.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9529,	' Mantenimiento y reparaci?n de otros efectos personales y enseres dom?sticos.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9601,	' Lavado y limpieza, incluso la limpieza en seco, de productos textiles y de piel.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9602,	' Peluquer?a y otros tratamientos de belleza.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9603,	' Pompas f?nebres y actividades relacionadas.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9609,	' Otras actividades de servicios personales n.c.p.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9700,	' Actividades de los hogares individuales como empleadores de personal dom?stico.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9810,	' Actividades no diferenciadas de los hogares individuales como productores de bienes para uso propio.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9820,	' Actividades no diferenciadas de los hogares individuales como productores de servicios para uso propio.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
(9900,	' Actividades de organizaciones y entidades extraterritoriales.',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39');

DROP TABLE IF EXISTS `clasecuenta`;
CREATE TABLE `clasecuenta` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clase` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `clasecuenta` (`PUC`, `Clase`, `Valor`, `Updated`, `Sync`) VALUES
('1',	'Activo',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
('2',	'Pasivo',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
('3',	'Patrimonio',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
('4',	'Ingresos',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
('5',	'Gastos',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
('6',	'Costos de Venta',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
('7',	'Costos de produccion o de operacion',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
('8',	'Cuentas de Orden Deudoras',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39'),
('9',	'Cuentas de orden Acreedoras',	'0',	'2019-01-13 14:04:39',	'2019-01-13 09:04:39');

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `idClientes` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int(11) NOT NULL,
  `Num_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DV` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Lugar_Expedicion_Documento` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RazonSocial` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Contacto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelContacto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CIUU` int(11) NOT NULL,
  `Cupo` double NOT NULL,
  `CodigoTarjeta` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idClientes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cod_departamentos`;
CREATE TABLE `cod_departamentos` (
  `Cod_dpto` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Cod_dpto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `cod_departamentos` (`Cod_dpto`, `Nombre`, `Updated`, `Sync`) VALUES
(5,	'ANTIOQUIA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(8,	'ATLANTICO',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(11,	'BOGOTA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(13,	'BOLIVAR',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(15,	'BOYACA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(17,	'CALDAS',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(18,	'CAQUETA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(19,	'CAUCA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(20,	'CESAR',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(23,	'CORDOBA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(25,	'CUNDINAMARCA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(27,	'CHOCO',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(41,	'HUILA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(44,	'LA GUAJIRA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(47,	'MAGDALENA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(50,	'META',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(52,	'NARI?O',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(54,	'N. DE SANTANDER',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(63,	'QUINDIO',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(66,	'RISARALDA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(68,	'SANTANDER',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(70,	'SUCRE',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(73,	'TOLIMA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(76,	'VALLE DEL CAUCA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(81,	'ARAUCA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(85,	'CASANARE',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(86,	'PUTUMAYO',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(88,	'SAN ANDRES',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(91,	'AMAZONAS',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(94,	'GUAINIA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(95,	'GUAVIARE',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(97,	'VAUPES',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(99,	'VICHADA',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41');

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
(11,	'Registro civil de nacimiento ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(12,	'Tarjeta de identidad ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(13,	'C?dula de ciudadan?a ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(14,	'Certificado de la Registradur?a para sucesiones il?quidas de personas naturales que no tienen ning?n documento de identificaci?n. ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(15,	'Tipo de documento que identifica una sucesi?n il?quida, expedido por la notaria o por un juzgado',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(21,	'Tarjeta de extranjer',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(22,	'C?dula de extranjer?a ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(31,	'NIT ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(33,	'Identificaci?n de extranjeros diferente al NIT asignado DIAN',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(41,	'Pasaporte ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(42,	'Documento de identificaci?n extranjero ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(43,	'Sin identificaci?n del exterior o para uso definido por la DIAN. ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(44,	'Documento de Identificaci?n extranjero Persona Jur?dica ',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41'),
(46,	'Carn? Diplom?tico: Documento expedido por el Ministerio de relaciones Exteriores a los miembros de la misiones diplom?ticas y consulares, con el que se deben identificar ente las autoridades nacionale',	'2019-01-13 14:04:41',	'2019-01-13 09:04:41');

DROP TABLE IF EXISTS `cod_municipios_dptos`;
CREATE TABLE `cod_municipios_dptos` (
  `ID` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Dpto` int(11) NOT NULL,
  `Departamento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `cod_municipios_dptos` (`ID`, `Cod_mcipio`, `Cod_Dpto`, `Departamento`, `Ciudad`, `Updated`, `Sync`) VALUES
('1',	'001',	5,	'ANTIOQUIA',	'MEDELLIN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('10',	'040',	5,	'ANTIOQUIA',	'ANORI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('100',	'674',	5,	'ANTIOQUIA',	'SAN VICENTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1000',	'854',	73,	'TOLIMA',	'VALLE DE SAN JUAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1001',	'861',	73,	'TOLIMA',	'VENADILLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1002',	'870',	73,	'TOLIMA',	'VILLAHERMOSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1003',	'873',	73,	'TOLIMA',	'VILLARRICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1004',	'001',	76,	'VALLE DEL CAUCA',	'CALI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1005',	'020',	76,	'VALLE DEL CAUCA',	'ALCALA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1006',	'036',	76,	'VALLE DEL CAUCA',	'ANDALUCIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1007',	'041',	76,	'VALLE DEL CAUCA',	'ANSERMANUEVO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1008',	'054',	76,	'VALLE DEL CAUCA',	'ARGELIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1009',	'100',	76,	'VALLE DEL CAUCA',	'BOLIVAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('101',	'679',	5,	'ANTIOQUIA',	'SANTA BARBARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1010',	'109',	76,	'VALLE DEL CAUCA',	'BUENAVENTURA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1011',	'111',	76,	'VALLE DEL CAUCA',	'GUADALAJARA DE BUGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1012',	'113',	76,	'VALLE DEL CAUCA',	'BUGALAGRANDE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1013',	'122',	76,	'VALLE DEL CAUCA',	'CAICEDONIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1014',	'126',	76,	'VALLE DEL CAUCA',	'CALIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1015',	'130',	76,	'VALLE DEL CAUCA',	'CANDELARIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1016',	'147',	76,	'VALLE DEL CAUCA',	'CARTAGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1017',	'233',	76,	'VALLE DEL CAUCA',	'DAGUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1018',	'243',	76,	'VALLE DEL CAUCA',	'EL AGUILA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1019',	'246',	76,	'VALLE DEL CAUCA',	'EL CAIRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('102',	'686',	5,	'ANTIOQUIA',	'SANTA ROSA DE OSOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1020',	'248',	76,	'VALLE DEL CAUCA',	'EL CERRITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1021',	'250',	76,	'VALLE DEL CAUCA',	'EL DOVIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1022',	'275',	76,	'VALLE DEL CAUCA',	'FLORIDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1023',	'306',	76,	'VALLE DEL CAUCA',	'GINEBRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1024',	'318',	76,	'VALLE DEL CAUCA',	'GUACARI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1025',	'364',	76,	'VALLE DEL CAUCA',	'JAMUNDI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1026',	'377',	76,	'VALLE DEL CAUCA',	'LA CUMBRE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1027',	'400',	76,	'VALLE DEL CAUCA',	'LA UNION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1028',	'403',	76,	'VALLE DEL CAUCA',	'LA VICTORIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1029',	'497',	76,	'VALLE DEL CAUCA',	'OBANDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('103',	'690',	5,	'ANTIOQUIA',	'SANTO DOMINGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1030',	'520',	76,	'VALLE DEL CAUCA',	'PALMIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1031',	'563',	76,	'VALLE DEL CAUCA',	'PRADERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1032',	'606',	76,	'VALLE DEL CAUCA',	'RESTREPO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1033',	'616',	76,	'VALLE DEL CAUCA',	'RIOFRIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1034',	'622',	76,	'VALLE DEL CAUCA',	'ROLDANILLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1035',	'670',	76,	'VALLE DEL CAUCA',	'SAN PEDRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1036',	'736',	76,	'VALLE DEL CAUCA',	'SEVILLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1037',	'823',	76,	'VALLE DEL CAUCA',	'TORO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1038',	'828',	76,	'VALLE DEL CAUCA',	'TRUJILLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1039',	'834',	76,	'VALLE DEL CAUCA',	'TULUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('104',	'697',	5,	'ANTIOQUIA',	'EL SANTUARIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1040',	'845',	76,	'VALLE DEL CAUCA',	'ULLOA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1041',	'863',	76,	'VALLE DEL CAUCA',	'VERSALLES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1042',	'869',	76,	'VALLE DEL CAUCA',	'VIJES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1043',	'890',	76,	'VALLE DEL CAUCA',	'YOTOCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1044',	'892',	76,	'VALLE DEL CAUCA',	'YUMBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1045',	'895',	76,	'VALLE DEL CAUCA',	'ZARZAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1046',	'001',	81,	'ARAUCA',	'ARAUCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1047',	'065',	81,	'ARAUCA',	'ARAUQUITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1048',	'220',	81,	'ARAUCA',	'CRAVO NORTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1049',	'300',	81,	'ARAUCA',	'FORTUL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('105',	'736',	5,	'ANTIOQUIA',	'SEGOVIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1050',	'591',	81,	'ARAUCA',	'PUERTO RONDON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1051',	'736',	81,	'ARAUCA',	'SARAVENA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1052',	'794',	81,	'ARAUCA',	'TAME',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1053',	'001',	85,	'CASANARE',	'YOPAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1054',	'010',	85,	'CASANARE',	'AGUAZUL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1055',	'015',	85,	'CASANARE',	'CHAMEZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1056',	'125',	85,	'CASANARE',	'HATO COROZAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1057',	'136',	85,	'CASANARE',	'LA SALINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1058',	'139',	85,	'CASANARE',	'MANI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1059',	'162',	85,	'CASANARE',	'MONTERREY',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('106',	'756',	5,	'ANTIOQUIA',	'SONSON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1060',	'225',	85,	'CASANARE',	'NUNCHIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1061',	'230',	85,	'CASANARE',	'OROCUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1062',	'250',	85,	'CASANARE',	'PAZ DE ARIPORO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1063',	'263',	85,	'CASANARE',	'PORE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1064',	'279',	85,	'CASANARE',	'RECETOR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1065',	'300',	85,	'CASANARE',	'SABANALARGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1066',	'315',	85,	'CASANARE',	'SACAMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1067',	'325',	85,	'CASANARE',	'SAN LUIS DE PALENQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1068',	'400',	85,	'CASANARE',	'TAMARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1069',	'410',	85,	'CASANARE',	'TAURAMENA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('107',	'761',	5,	'ANTIOQUIA',	'SOPETRAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1070',	'430',	85,	'CASANARE',	'TRINIDAD',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1071',	'440',	85,	'CASANARE',	'VILLANUEVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1072',	'001',	86,	'PUTUMAYO',	'MOCOA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1073',	'219',	86,	'PUTUMAYO',	'COLON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1074',	'320',	86,	'PUTUMAYO',	'ORITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1075',	'568',	86,	'PUTUMAYO',	'PUERTO ASIS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1076',	'569',	86,	'PUTUMAYO',	'PUERTO CAICEDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1077',	'571',	86,	'PUTUMAYO',	'PUERTO GUZMAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1078',	'573',	86,	'PUTUMAYO',	'LEGUIZAMO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1079',	'749',	86,	'PUTUMAYO',	'SIBUNDOY',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('108',	'789',	5,	'ANTIOQUIA',	'TAMESIS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1080',	'755',	86,	'PUTUMAYO',	'SAN FRANCISCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1081',	'757',	86,	'PUTUMAYO',	'SAN MIGUEL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1082',	'760',	86,	'PUTUMAYO',	'SANTIAGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1083',	'865',	86,	'PUTUMAYO',	'VALLE DEL GUAMUEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1084',	'885',	86,	'PUTUMAYO',	'VILLAGARZON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1085',	'001',	88,	'SAN ANDRES',	'SAN ANDRES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1086',	'564',	88,	'SAN ANDRES',	'PROVIDENCIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1087',	'001',	91,	'AMAZONAS',	'LETICIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1088',	'263',	91,	'AMAZONAS',	'EL ENCANTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1089',	'405',	91,	'AMAZONAS',	'LA CHORRERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('109',	'790',	5,	'ANTIOQUIA',	'TARAZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1090',	'407',	91,	'AMAZONAS',	'LA PEDRERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1091',	'430',	91,	'AMAZONAS',	'LA VICTORIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1092',	'460',	91,	'AMAZONAS',	'MIRITI - PARANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1093',	'530',	91,	'AMAZONAS',	'PUERTO ALEGRIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1094',	'536',	91,	'AMAZONAS',	'PUERTO ARICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1095',	'540',	91,	'AMAZONAS',	'PUERTO NARI?O',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1096',	'669',	91,	'AMAZONAS',	'PUERTO SANTANDER',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1097',	'798',	91,	'AMAZONAS',	'TARAPACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1098',	'001',	94,	'GUAINIA',	'INIRIDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1099',	'343',	94,	'GUAINIA',	'BARRANCO MINAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('11',	'042',	5,	'ANTIOQUIA',	'SANTAFE DE ANTIOQUIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('110',	'792',	5,	'ANTIOQUIA',	'TARSO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1100',	'663',	94,	'GUAINIA',	'MAPIRIPANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1101',	'883',	94,	'GUAINIA',	'SAN FELIPE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1102',	'884',	94,	'GUAINIA',	'PUERTO COLOMBIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1103',	'885',	94,	'GUAINIA',	'LA GUADALUPE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1104',	'886',	94,	'GUAINIA',	'CACAHUAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1105',	'887',	94,	'GUAINIA',	'PANA PANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1106',	'888',	94,	'GUAINIA',	'MORICHAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1107',	'001',	95,	'GUAVIARE',	'SAN JOSE DEL GUAVIARE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1108',	'015',	95,	'GUAVIARE',	'CALAMAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1109',	'025',	95,	'GUAVIARE',	'EL RETORNO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('111',	'809',	5,	'ANTIOQUIA',	'TITIRIBI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1110',	'200',	95,	'GUAVIARE',	'MIRAFLORES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1111',	'001',	97,	'VAUPES',	'MITU',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1112',	'161',	97,	'VAUPES',	'CARURU',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1113',	'511',	97,	'VAUPES',	'PACOA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1114',	'666',	97,	'VAUPES',	'TARAIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1115',	'777',	97,	'VAUPES',	'PAPUNAUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1116',	'889',	97,	'VAUPES',	'YAVARATE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1117',	'001',	99,	'VICHADA',	'PUERTO CARRE?O',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1118',	'524',	99,	'VICHADA',	'LA PRIMAVERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1119',	'624',	99,	'VICHADA',	'SANTA ROSALIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('112',	'819',	5,	'ANTIOQUIA',	'TOLEDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('1120',	'773',	99,	'VICHADA',	'CUMARIBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('113',	'837',	5,	'ANTIOQUIA',	'TURBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('114',	'842',	5,	'ANTIOQUIA',	'URAMITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('115',	'847',	5,	'ANTIOQUIA',	'URRAO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('116',	'854',	5,	'ANTIOQUIA',	'VALDIVIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('117',	'856',	5,	'ANTIOQUIA',	'VALPARAISO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('118',	'858',	5,	'ANTIOQUIA',	'VEGACHI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('119',	'861',	5,	'ANTIOQUIA',	'VENECIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('12',	'044',	5,	'ANTIOQUIA',	'ANZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('120',	'873',	5,	'ANTIOQUIA',	'VIGIA DEL FUERTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('121',	'885',	5,	'ANTIOQUIA',	'YALI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('122',	'887',	5,	'ANTIOQUIA',	'YARUMAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('123',	'890',	5,	'ANTIOQUIA',	'YOLOMBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('124',	'893',	5,	'ANTIOQUIA',	'YONDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('125',	'895',	5,	'ANTIOQUIA',	'ZARAGOZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('126',	'001',	8,	'ATLANTICO',	'BARRANQUILLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('127',	'078',	8,	'ATLANTICO',	'BARANOA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('128',	'137',	8,	'ATLANTICO',	'CAMPO DE LA CRUZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('129',	'141',	8,	'ATLANTICO',	'CANDELARIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('13',	'045',	5,	'ANTIOQUIA',	'APARTADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('130',	'296',	8,	'ATLANTICO',	'GALAPA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('131',	'372',	8,	'ATLANTICO',	'JUAN DE ACOSTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('132',	'421',	8,	'ATLANTICO',	'LURUACO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('133',	'433',	8,	'ATLANTICO',	'MALAMBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('134',	'436',	8,	'ATLANTICO',	'MANATI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('135',	'520',	8,	'ATLANTICO',	'PALMAR DE VARELA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('136',	'549',	8,	'ATLANTICO',	'PIOJO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('137',	'558',	8,	'ATLANTICO',	'POLONUEVO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('138',	'560',	8,	'ATLANTICO',	'PONEDERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('139',	'573',	8,	'ATLANTICO',	'PUERTO COLOMBIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('14',	'051',	5,	'ANTIOQUIA',	'ARBOLETES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('140',	'606',	8,	'ATLANTICO',	'REPELON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('141',	'634',	8,	'ATLANTICO',	'SABANAGRANDE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('142',	'638',	8,	'ATLANTICO',	'SABANALARGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('143',	'675',	8,	'ATLANTICO',	'SANTA LUCIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('144',	'685',	8,	'ATLANTICO',	'SANTO TOMAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('145',	'758',	8,	'ATLANTICO',	'SOLEDAD',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('146',	'770',	8,	'ATLANTICO',	'SUAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('147',	'832',	8,	'ATLANTICO',	'TUBARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('148',	'849',	8,	'ATLANTICO',	'USIACURI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('149',	'001',	11,	'BOGOTA',	'BOGOTA, D.C.',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('15',	'055',	5,	'ANTIOQUIA',	'ARGELIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('150',	'001',	13,	'BOLIVAR',	'CARTAGENA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('151',	'006',	13,	'BOLIVAR',	'ACHI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('152',	'030',	13,	'BOLIVAR',	'ALTOS DEL ROSARIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('153',	'042',	13,	'BOLIVAR',	'ARENAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('154',	'052',	13,	'BOLIVAR',	'ARJONA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('155',	'062',	13,	'BOLIVAR',	'ARROYOHONDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('156',	'074',	13,	'BOLIVAR',	'BARRANCO DE LOBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('157',	'140',	13,	'BOLIVAR',	'CALAMAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('158',	'160',	13,	'BOLIVAR',	'CANTAGALLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('159',	'188',	13,	'BOLIVAR',	'CICUCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('16',	'059',	5,	'ANTIOQUIA',	'ARMENIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('160',	'212',	13,	'BOLIVAR',	'CORDOBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('161',	'222',	13,	'BOLIVAR',	'CLEMENCIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('162',	'244',	13,	'BOLIVAR',	'EL CARMEN DE BOLIVAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('163',	'248',	13,	'BOLIVAR',	'EL GUAMO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('164',	'268',	13,	'BOLIVAR',	'EL PE?ON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('165',	'300',	13,	'BOLIVAR',	'HATILLO DE LOBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('166',	'430',	13,	'BOLIVAR',	'MAGANGUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('167',	'433',	13,	'BOLIVAR',	'MAHATES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('168',	'440',	13,	'BOLIVAR',	'MARGARITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('169',	'442',	13,	'BOLIVAR',	'MARIA LA BAJA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('17',	'079',	5,	'ANTIOQUIA',	'BARBOSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('170',	'458',	13,	'BOLIVAR',	'MONTECRISTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('171',	'468',	13,	'BOLIVAR',	'MOMPOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('172',	'490',	13,	'BOLIVAR',	'NOROSI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('173',	'473',	13,	'BOLIVAR',	'MORALES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('174',	'549',	13,	'BOLIVAR',	'PINILLOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('175',	'580',	13,	'BOLIVAR',	'REGIDOR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('176',	'600',	13,	'BOLIVAR',	'RIO VIEJO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('177',	'620',	13,	'BOLIVAR',	'SAN CRISTOBAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('178',	'647',	13,	'BOLIVAR',	'SAN ESTANISLAO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('179',	'650',	13,	'BOLIVAR',	'SAN FERNANDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('18',	'086',	5,	'ANTIOQUIA',	'BELMIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('180',	'654',	13,	'BOLIVAR',	'SAN JACINTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('181',	'655',	13,	'BOLIVAR',	'SAN JACINTO DEL CAUCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('182',	'657',	13,	'BOLIVAR',	'SAN JUAN NEPOMUCENO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('183',	'667',	13,	'BOLIVAR',	'SAN MARTIN DE LOBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('184',	'670',	13,	'BOLIVAR',	'SAN PABLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('185',	'673',	13,	'BOLIVAR',	'SANTA CATALINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('186',	'683',	13,	'BOLIVAR',	'SANTA ROSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('187',	'688',	13,	'BOLIVAR',	'SANTA ROSA DEL SUR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('188',	'744',	13,	'BOLIVAR',	'SIMITI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('189',	'760',	13,	'BOLIVAR',	'SOPLAVIENTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('19',	'088',	5,	'ANTIOQUIA',	'BELLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('190',	'780',	13,	'BOLIVAR',	'TALAIGUA NUEVO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('191',	'810',	13,	'BOLIVAR',	'TIQUISIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('192',	'836',	13,	'BOLIVAR',	'TURBACO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('193',	'838',	13,	'BOLIVAR',	'TURBANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('194',	'873',	13,	'BOLIVAR',	'VILLANUEVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('195',	'894',	13,	'BOLIVAR',	'ZAMBRANO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('196',	'001',	15,	'BOYACA',	'TUNJA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('197',	'022',	15,	'BOYACA',	'ALMEIDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('198',	'047',	15,	'BOYACA',	'AQUITANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('199',	'051',	15,	'BOYACA',	'ARCABUCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('2',	'002',	5,	'ANTIOQUIA',	'ABEJORRAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('20',	'091',	5,	'ANTIOQUIA',	'BETANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('200',	'087',	15,	'BOYACA',	'BELEN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('201',	'090',	15,	'BOYACA',	'BERBEO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('202',	'092',	15,	'BOYACA',	'BETEITIVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('203',	'097',	15,	'BOYACA',	'BOAVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('204',	'104',	15,	'BOYACA',	'BOYACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('205',	'106',	15,	'BOYACA',	'BRICE?O',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('206',	'109',	15,	'BOYACA',	'BUENAVISTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('207',	'114',	15,	'BOYACA',	'BUSBANZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('208',	'131',	15,	'BOYACA',	'CALDAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('209',	'135',	15,	'BOYACA',	'CAMPOHERMOSO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('21',	'093',	5,	'ANTIOQUIA',	'BETULIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('210',	'162',	15,	'BOYACA',	'CERINZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('211',	'172',	15,	'BOYACA',	'CHINAVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('212',	'176',	15,	'BOYACA',	'CHIQUINQUIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('213',	'180',	15,	'BOYACA',	'CHISCAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('214',	'183',	15,	'BOYACA',	'CHITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('215',	'185',	15,	'BOYACA',	'CHITARAQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('216',	'187',	15,	'BOYACA',	'CHIVATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('217',	'189',	15,	'BOYACA',	'CIENEGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('218',	'204',	15,	'BOYACA',	'COMBITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('219',	'212',	15,	'BOYACA',	'COPER',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('22',	'101',	5,	'ANTIOQUIA',	'CIUDAD BOLIVAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('220',	'215',	15,	'BOYACA',	'CORRALES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('221',	'218',	15,	'BOYACA',	'COVARACHIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('222',	'223',	15,	'BOYACA',	'CUBARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('223',	'224',	15,	'BOYACA',	'CUCAITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('224',	'226',	15,	'BOYACA',	'CUITIVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('225',	'232',	15,	'BOYACA',	'CHIQUIZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('226',	'236',	15,	'BOYACA',	'CHIVOR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('227',	'238',	15,	'BOYACA',	'DUITAMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('228',	'244',	15,	'BOYACA',	'EL COCUY',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('229',	'248',	15,	'BOYACA',	'EL ESPINO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('23',	'107',	5,	'ANTIOQUIA',	'BRICE?O',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('230',	'272',	15,	'BOYACA',	'FIRAVITOBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('231',	'276',	15,	'BOYACA',	'FLORESTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('232',	'293',	15,	'BOYACA',	'GACHANTIVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('233',	'296',	15,	'BOYACA',	'GAMEZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('234',	'299',	15,	'BOYACA',	'GARAGOA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('235',	'317',	15,	'BOYACA',	'GUACAMAYAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('236',	'322',	15,	'BOYACA',	'GUATEQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('237',	'325',	15,	'BOYACA',	'GUAYATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('238',	'332',	15,	'BOYACA',	'GsICAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('239',	'362',	15,	'BOYACA',	'IZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('24',	'113',	5,	'ANTIOQUIA',	'BURITICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('240',	'367',	15,	'BOYACA',	'JENESANO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('241',	'368',	15,	'BOYACA',	'JERICO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('242',	'377',	15,	'BOYACA',	'LABRANZAGRANDE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('243',	'380',	15,	'BOYACA',	'LA CAPILLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('244',	'401',	15,	'BOYACA',	'LA VICTORIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('245',	'403',	15,	'BOYACA',	'LA UVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('246',	'407',	15,	'BOYACA',	'VILLA DE LEYVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('247',	'425',	15,	'BOYACA',	'MACANAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('248',	'442',	15,	'BOYACA',	'MARIPI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('249',	'455',	15,	'BOYACA',	'MIRAFLORES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('25',	'120',	5,	'ANTIOQUIA',	'CACERES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('250',	'464',	15,	'BOYACA',	'MONGUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('251',	'466',	15,	'BOYACA',	'MONGUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('252',	'469',	15,	'BOYACA',	'MONIQUIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('253',	'476',	15,	'BOYACA',	'MOTAVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('254',	'480',	15,	'BOYACA',	'MUZO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('255',	'491',	15,	'BOYACA',	'NOBSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('256',	'494',	15,	'BOYACA',	'NUEVO COLON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('257',	'500',	15,	'BOYACA',	'OICATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('258',	'507',	15,	'BOYACA',	'OTANCHE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('259',	'511',	15,	'BOYACA',	'PACHAVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('26',	'125',	5,	'ANTIOQUIA',	'CAICEDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('260',	'514',	15,	'BOYACA',	'PAEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('261',	'516',	15,	'BOYACA',	'PAIPA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('262',	'518',	15,	'BOYACA',	'PAJARITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('263',	'522',	15,	'BOYACA',	'PANQUEBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('264',	'531',	15,	'BOYACA',	'PAUNA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('265',	'533',	15,	'BOYACA',	'PAYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('266',	'537',	15,	'BOYACA',	'PAZ DE RIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('267',	'542',	15,	'BOYACA',	'PESCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('268',	'550',	15,	'BOYACA',	'PISBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('269',	'572',	15,	'BOYACA',	'PUERTO BOYACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('27',	'129',	5,	'ANTIOQUIA',	'CALDAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('270',	'580',	15,	'BOYACA',	'QUIPAMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('271',	'599',	15,	'BOYACA',	'RAMIRIQUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('272',	'600',	15,	'BOYACA',	'RAQUIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('273',	'621',	15,	'BOYACA',	'RONDON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('274',	'632',	15,	'BOYACA',	'SABOYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('275',	'638',	15,	'BOYACA',	'SACHICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('276',	'646',	15,	'BOYACA',	'SAMACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('277',	'660',	15,	'BOYACA',	'SAN EDUARDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('278',	'664',	15,	'BOYACA',	'SAN JOSE DE PARE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('279',	'667',	15,	'BOYACA',	'SAN LUIS DE GACENO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('28',	'134',	5,	'ANTIOQUIA',	'CAMPAMENTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('280',	'673',	15,	'BOYACA',	'SAN MATEO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('281',	'676',	15,	'BOYACA',	'SAN MIGUEL DE SEMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('282',	'681',	15,	'BOYACA',	'SAN PABLO DE BORBUR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('283',	'686',	15,	'BOYACA',	'SANTANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('284',	'690',	15,	'BOYACA',	'SANTA MARIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('285',	'693',	15,	'BOYACA',	'SANTA ROSA DE VITERBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('286',	'696',	15,	'BOYACA',	'SANTA SOFIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('287',	'720',	15,	'BOYACA',	'SATIVANORTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('288',	'723',	15,	'BOYACA',	'SATIVASUR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('289',	'740',	15,	'BOYACA',	'SIACHOQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('29',	'138',	5,	'ANTIOQUIA',	'CA?ASGORDAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('290',	'753',	15,	'BOYACA',	'SOATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('291',	'755',	15,	'BOYACA',	'SOCOTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('292',	'757',	15,	'BOYACA',	'SOCHA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('293',	'759',	15,	'BOYACA',	'SOGAMOSO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('294',	'761',	15,	'BOYACA',	'SOMONDOCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('295',	'762',	15,	'BOYACA',	'SORA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('296',	'763',	15,	'BOYACA',	'SOTAQUIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('297',	'764',	15,	'BOYACA',	'SORACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('298',	'774',	15,	'BOYACA',	'SUSACON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('299',	'776',	15,	'BOYACA',	'SUTAMARCHAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('3',	'004',	5,	'ANTIOQUIA',	'ABRIAQUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('30',	'142',	5,	'ANTIOQUIA',	'CARACOLI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('300',	'778',	15,	'BOYACA',	'SUTATENZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('301',	'790',	15,	'BOYACA',	'TASCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('302',	'798',	15,	'BOYACA',	'TENZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('303',	'804',	15,	'BOYACA',	'TIBANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('304',	'806',	15,	'BOYACA',	'TIBASOSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('305',	'808',	15,	'BOYACA',	'TINJACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('306',	'810',	15,	'BOYACA',	'TIPACOQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('307',	'814',	15,	'BOYACA',	'TOCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('308',	'816',	15,	'BOYACA',	'TOGsI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('309',	'820',	15,	'BOYACA',	'TOPAGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('31',	'145',	5,	'ANTIOQUIA',	'CARAMANTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('310',	'822',	15,	'BOYACA',	'TOTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('311',	'832',	15,	'BOYACA',	'TUNUNGUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('312',	'835',	15,	'BOYACA',	'TURMEQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('313',	'837',	15,	'BOYACA',	'TUTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('314',	'839',	15,	'BOYACA',	'TUTAZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('315',	'842',	15,	'BOYACA',	'UMBITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('316',	'861',	15,	'BOYACA',	'VENTAQUEMADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('317',	'879',	15,	'BOYACA',	'VIRACACHA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('318',	'897',	15,	'BOYACA',	'ZETAQUIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('319',	'001',	17,	'CALDAS',	'MANIZALES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('32',	'147',	5,	'ANTIOQUIA',	'CAREPA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('320',	'013',	17,	'CALDAS',	'AGUADAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('321',	'042',	17,	'CALDAS',	'ANSERMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('322',	'050',	17,	'CALDAS',	'ARANZAZU',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('323',	'088',	17,	'CALDAS',	'BELALCAZAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('324',	'174',	17,	'CALDAS',	'CHINCHINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('325',	'272',	17,	'CALDAS',	'FILADELFIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('326',	'380',	17,	'CALDAS',	'LA DORADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('327',	'388',	17,	'CALDAS',	'LA MERCED',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('328',	'433',	17,	'CALDAS',	'MANZANARES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('329',	'442',	17,	'CALDAS',	'MARMATO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('33',	'148',	5,	'ANTIOQUIA',	'EL CARMEN DE VIBORAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('330',	'444',	17,	'CALDAS',	'MARQUETALIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('331',	'446',	17,	'CALDAS',	'MARULANDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('332',	'486',	17,	'CALDAS',	'NEIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('333',	'495',	17,	'CALDAS',	'NORCASIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('334',	'513',	17,	'CALDAS',	'PACORA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('335',	'524',	17,	'CALDAS',	'PALESTINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('336',	'541',	17,	'CALDAS',	'PENSILVANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('337',	'614',	17,	'CALDAS',	'RIOSUCIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('338',	'616',	17,	'CALDAS',	'RISARALDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('339',	'653',	17,	'CALDAS',	'SALAMINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('34',	'150',	5,	'ANTIOQUIA',	'CAROLINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('340',	'662',	17,	'CALDAS',	'SAMANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('341',	'665',	17,	'CALDAS',	'SAN JOSE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('342',	'777',	17,	'CALDAS',	'SUPIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('343',	'867',	17,	'CALDAS',	'VICTORIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('344',	'873',	17,	'CALDAS',	'VILLAMARIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('345',	'877',	17,	'CALDAS',	'VITERBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('346',	'001',	18,	'CAQUETA',	'FLORENCIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('347',	'029',	18,	'CAQUETA',	'ALBANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('348',	'094',	18,	'CAQUETA',	'BELEN DE LOS ANDAQUIES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('349',	'150',	18,	'CAQUETA',	'CARTAGENA DEL CHAIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('35',	'154',	5,	'ANTIOQUIA',	'CAUCASIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('350',	'205',	18,	'CAQUETA',	'CURILLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('351',	'247',	18,	'CAQUETA',	'EL DONCELLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('352',	'256',	18,	'CAQUETA',	'EL PAUJIL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('353',	'410',	18,	'CAQUETA',	'LA MONTA?ITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('354',	'460',	18,	'CAQUETA',	'MILAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('355',	'479',	18,	'CAQUETA',	'MORELIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('356',	'592',	18,	'CAQUETA',	'PUERTO RICO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('357',	'610',	18,	'CAQUETA',	'SAN JOSE DEL FRAGUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('358',	'753',	18,	'CAQUETA',	'SAN VICENTE DEL CAGUAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('359',	'756',	18,	'CAQUETA',	'SOLANO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('36',	'172',	5,	'ANTIOQUIA',	'CHIGORODO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('360',	'785',	18,	'CAQUETA',	'SOLITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('361',	'860',	18,	'CAQUETA',	'VALPARAISO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('362',	'001',	19,	'CAUCA',	'POPAYAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('363',	'022',	19,	'CAUCA',	'ALMAGUER',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('364',	'050',	19,	'CAUCA',	'ARGELIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('365',	'075',	19,	'CAUCA',	'BALBOA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('366',	'100',	19,	'CAUCA',	'BOLIVAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('367',	'110',	19,	'CAUCA',	'BUENOS AIRES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('368',	'130',	19,	'CAUCA',	'CAJIBIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('369',	'137',	19,	'CAUCA',	'CALDONO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('37',	'190',	5,	'ANTIOQUIA',	'CISNEROS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('370',	'142',	19,	'CAUCA',	'CALOTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('371',	'212',	19,	'CAUCA',	'CORINTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('372',	'256',	19,	'CAUCA',	'EL TAMBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('373',	'290',	19,	'CAUCA',	'FLORENCIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('374',	'300',	19,	'CAUCA',	'GUACHENE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('375',	'318',	19,	'CAUCA',	'GUAPI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('376',	'355',	19,	'CAUCA',	'INZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('377',	'364',	19,	'CAUCA',	'JAMBALO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('378',	'392',	19,	'CAUCA',	'LA SIERRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('379',	'397',	19,	'CAUCA',	'LA VEGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('38',	'197',	5,	'ANTIOQUIA',	'COCORNA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('380',	'418',	19,	'CAUCA',	'LOPEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('381',	'450',	19,	'CAUCA',	'MERCADERES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('382',	'455',	19,	'CAUCA',	'MIRANDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('383',	'473',	19,	'CAUCA',	'MORALES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('384',	'513',	19,	'CAUCA',	'PADILLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('385',	'517',	19,	'CAUCA',	'PAEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('386',	'532',	19,	'CAUCA',	'PATIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('387',	'533',	19,	'CAUCA',	'PIAMONTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('388',	'548',	19,	'CAUCA',	'PIENDAMO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('389',	'573',	19,	'CAUCA',	'PUERTO TEJADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('39',	'206',	5,	'ANTIOQUIA',	'CONCEPCION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('390',	'585',	19,	'CAUCA',	'PURACE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('391',	'622',	19,	'CAUCA',	'ROSAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('392',	'693',	19,	'CAUCA',	'SAN SEBASTIAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('393',	'698',	19,	'CAUCA',	'SANTANDER DE QUILICHAO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('394',	'701',	19,	'CAUCA',	'SANTA ROSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('395',	'743',	19,	'CAUCA',	'SILVIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('396',	'760',	19,	'CAUCA',	'SOTARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('397',	'780',	19,	'CAUCA',	'SUAREZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('398',	'785',	19,	'CAUCA',	'SUCRE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('399',	'807',	19,	'CAUCA',	'TIMBIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('4',	'021',	5,	'ANTIOQUIA',	'ALEJANDRIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('40',	'209',	5,	'ANTIOQUIA',	'CONCORDIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('400',	'809',	19,	'CAUCA',	'TIMBIQUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('401',	'821',	19,	'CAUCA',	'TORIBIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('402',	'824',	19,	'CAUCA',	'TOTORO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('403',	'845',	19,	'CAUCA',	'VILLA RICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('404',	'001',	20,	'CESAR',	'VALLEDUPAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('405',	'011',	20,	'CESAR',	'AGUACHICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('406',	'013',	20,	'CESAR',	'AGUSTIN CODAZZI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('407',	'032',	20,	'CESAR',	'ASTREA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('408',	'045',	20,	'CESAR',	'BECERRIL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('409',	'060',	20,	'CESAR',	'BOSCONIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('41',	'212',	5,	'ANTIOQUIA',	'COPACABANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('410',	'175',	20,	'CESAR',	'CHIMICHAGUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('411',	'178',	20,	'CESAR',	'CHIRIGUANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('412',	'228',	20,	'CESAR',	'CURUMANI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('413',	'238',	20,	'CESAR',	'EL COPEY',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('414',	'250',	20,	'CESAR',	'EL PASO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('415',	'295',	20,	'CESAR',	'GAMARRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('416',	'310',	20,	'CESAR',	'GONZALEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('417',	'383',	20,	'CESAR',	'LA GLORIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('418',	'400',	20,	'CESAR',	'LA JAGUA DE IBIRICO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('419',	'443',	20,	'CESAR',	'MANAURE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('42',	'234',	5,	'ANTIOQUIA',	'DABEIBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('420',	'517',	20,	'CESAR',	'PAILITAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('421',	'550',	20,	'CESAR',	'PELAYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('422',	'570',	20,	'CESAR',	'PUEBLO BELLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('423',	'614',	20,	'CESAR',	'RIO DE ORO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('424',	'621',	20,	'CESAR',	'LA PAZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('425',	'710',	20,	'CESAR',	'SAN ALBERTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('426',	'750',	20,	'CESAR',	'SAN DIEGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('427',	'770',	20,	'CESAR',	'SAN MARTIN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('428',	'787',	20,	'CESAR',	'TAMALAMEQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('429',	'001',	23,	'CORDOBA',	'MONTERIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('43',	'237',	5,	'ANTIOQUIA',	'DON MATIAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('430',	'068',	23,	'CORDOBA',	'AYAPEL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('431',	'079',	23,	'CORDOBA',	'BUENAVISTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('432',	'090',	23,	'CORDOBA',	'CANALETE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('433',	'162',	23,	'CORDOBA',	'CERETE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('434',	'168',	23,	'CORDOBA',	'CHIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('435',	'182',	23,	'CORDOBA',	'CHINU',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('436',	'189',	23,	'CORDOBA',	'CIENAGA DE ORO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('437',	'300',	23,	'CORDOBA',	'COTORRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('438',	'350',	23,	'CORDOBA',	'LA APARTADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('439',	'417',	23,	'CORDOBA',	'LORICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('44',	'240',	5,	'ANTIOQUIA',	'EBEJICO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('440',	'419',	23,	'CORDOBA',	'LOS CORDOBAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('441',	'464',	23,	'CORDOBA',	'MOMIL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('442',	'466',	23,	'CORDOBA',	'MONTELIBANO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('443',	'500',	23,	'CORDOBA',	'MO?ITOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('444',	'555',	23,	'CORDOBA',	'PLANETA RICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('445',	'570',	23,	'CORDOBA',	'PUEBLO NUEVO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('446',	'574',	23,	'CORDOBA',	'PUERTO ESCONDIDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('447',	'580',	23,	'CORDOBA',	'PUERTO LIBERTADOR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('448',	'586',	23,	'CORDOBA',	'PURISIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('449',	'660',	23,	'CORDOBA',	'SAHAGUN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('45',	'250',	5,	'ANTIOQUIA',	'EL BAGRE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('450',	'670',	23,	'CORDOBA',	'SAN ANDRES SOTAVENTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('451',	'672',	23,	'CORDOBA',	'SAN ANTERO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('452',	'675',	23,	'CORDOBA',	'SAN BERNARDO DEL VIENTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('453',	'678',	23,	'CORDOBA',	'SAN CARLOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('454',	'686',	23,	'CORDOBA',	'SAN PELAYO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('455',	'807',	23,	'CORDOBA',	'TIERRALTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('456',	'855',	23,	'CORDOBA',	'VALENCIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('457',	'001',	25,	'CUNDINAMARCA',	'AGUA DE DIOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('458',	'019',	25,	'CUNDINAMARCA',	'ALBAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('459',	'035',	25,	'CUNDINAMARCA',	'ANAPOIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('46',	'264',	5,	'ANTIOQUIA',	'ENTRERRIOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('460',	'040',	25,	'CUNDINAMARCA',	'ANOLAIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('461',	'053',	25,	'CUNDINAMARCA',	'ARBELAEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('462',	'086',	25,	'CUNDINAMARCA',	'BELTRAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('463',	'095',	25,	'CUNDINAMARCA',	'BITUIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('464',	'099',	25,	'CUNDINAMARCA',	'BOJACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('465',	'120',	25,	'CUNDINAMARCA',	'CABRERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('466',	'123',	25,	'CUNDINAMARCA',	'CACHIPAY',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('467',	'126',	25,	'CUNDINAMARCA',	'CAJICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('468',	'148',	25,	'CUNDINAMARCA',	'CAPARRAPI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('469',	'151',	25,	'CUNDINAMARCA',	'CAQUEZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('47',	'266',	5,	'ANTIOQUIA',	'ENVIGADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('470',	'154',	25,	'CUNDINAMARCA',	'CARMEN DE CARUPA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('471',	'168',	25,	'CUNDINAMARCA',	'CHAGUANI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('472',	'175',	25,	'CUNDINAMARCA',	'CHIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('473',	'178',	25,	'CUNDINAMARCA',	'CHIPAQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('474',	'181',	25,	'CUNDINAMARCA',	'CHOACHI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('475',	'183',	25,	'CUNDINAMARCA',	'CHOCONTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('476',	'200',	25,	'CUNDINAMARCA',	'COGUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('477',	'214',	25,	'CUNDINAMARCA',	'COTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('478',	'224',	25,	'CUNDINAMARCA',	'CUCUNUBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('479',	'245',	25,	'CUNDINAMARCA',	'EL COLEGIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('48',	'282',	5,	'ANTIOQUIA',	'FREDONIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('480',	'258',	25,	'CUNDINAMARCA',	'EL PE?ON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('481',	'260',	25,	'CUNDINAMARCA',	'EL ROSAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('482',	'269',	25,	'CUNDINAMARCA',	'FACATATIVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('483',	'279',	25,	'CUNDINAMARCA',	'FOMEQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('484',	'281',	25,	'CUNDINAMARCA',	'FOSCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('485',	'286',	25,	'CUNDINAMARCA',	'FUNZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('486',	'288',	25,	'CUNDINAMARCA',	'FUQUENE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('487',	'290',	25,	'CUNDINAMARCA',	'FUSAGASUGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('488',	'293',	25,	'CUNDINAMARCA',	'GACHALA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('489',	'295',	25,	'CUNDINAMARCA',	'GACHANCIPA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('49',	'284',	5,	'ANTIOQUIA',	'FRONTINO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('490',	'297',	25,	'CUNDINAMARCA',	'GACHETA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('491',	'299',	25,	'CUNDINAMARCA',	'GAMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('492',	'307',	25,	'CUNDINAMARCA',	'GIRARDOT',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('493',	'312',	25,	'CUNDINAMARCA',	'GRANADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('494',	'317',	25,	'CUNDINAMARCA',	'GUACHETA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('495',	'320',	25,	'CUNDINAMARCA',	'GUADUAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('496',	'322',	25,	'CUNDINAMARCA',	'GUASCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('497',	'324',	25,	'CUNDINAMARCA',	'GUATAQUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('498',	'326',	25,	'CUNDINAMARCA',	'GUATAVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('499',	'328',	25,	'CUNDINAMARCA',	'GUAYABAL DE SIQUIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('5',	'030',	5,	'ANTIOQUIA',	'AMAGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('50',	'306',	5,	'ANTIOQUIA',	'GIRALDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('500',	'335',	25,	'CUNDINAMARCA',	'GUAYABETAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('501',	'339',	25,	'CUNDINAMARCA',	'GUTIERREZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('502',	'368',	25,	'CUNDINAMARCA',	'JERUSALEN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('503',	'372',	25,	'CUNDINAMARCA',	'JUNIN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('504',	'377',	25,	'CUNDINAMARCA',	'LA CALERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('505',	'386',	25,	'CUNDINAMARCA',	'LA MESA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('506',	'394',	25,	'CUNDINAMARCA',	'LA PALMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('507',	'398',	25,	'CUNDINAMARCA',	'LA PE?A',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('508',	'402',	25,	'CUNDINAMARCA',	'LA VEGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('509',	'407',	25,	'CUNDINAMARCA',	'LENGUAZAQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('51',	'308',	5,	'ANTIOQUIA',	'GIRARDOTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('510',	'426',	25,	'CUNDINAMARCA',	'MACHETA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('511',	'430',	25,	'CUNDINAMARCA',	'MADRID',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('512',	'436',	25,	'CUNDINAMARCA',	'MANTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('513',	'438',	25,	'CUNDINAMARCA',	'MEDINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('514',	'473',	25,	'CUNDINAMARCA',	'MOSQUERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('515',	'483',	25,	'CUNDINAMARCA',	'NARI?O',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('516',	'486',	25,	'CUNDINAMARCA',	'NEMOCON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('517',	'488',	25,	'CUNDINAMARCA',	'NILO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('518',	'489',	25,	'CUNDINAMARCA',	'NIMAIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('519',	'491',	25,	'CUNDINAMARCA',	'NOCAIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('52',	'310',	5,	'ANTIOQUIA',	'GOMEZ PLATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('520',	'506',	25,	'CUNDINAMARCA',	'VENECIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('521',	'513',	25,	'CUNDINAMARCA',	'PACHO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('522',	'518',	25,	'CUNDINAMARCA',	'PAIME',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('523',	'524',	25,	'CUNDINAMARCA',	'PANDI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('524',	'530',	25,	'CUNDINAMARCA',	'PARATEBUENO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('525',	'535',	25,	'CUNDINAMARCA',	'PASCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('526',	'572',	25,	'CUNDINAMARCA',	'PUERTO SALGAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('527',	'580',	25,	'CUNDINAMARCA',	'PULI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('528',	'592',	25,	'CUNDINAMARCA',	'QUEBRADANEGRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('529',	'594',	25,	'CUNDINAMARCA',	'QUETAME',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('53',	'313',	5,	'ANTIOQUIA',	'GRANADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('530',	'596',	25,	'CUNDINAMARCA',	'QUIPILE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('531',	'599',	25,	'CUNDINAMARCA',	'APULO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('532',	'612',	25,	'CUNDINAMARCA',	'RICAURTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('533',	'645',	25,	'CUNDINAMARCA',	'SAN ANTONIO DEL TEQUENDAMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('534',	'649',	25,	'CUNDINAMARCA',	'SAN BERNARDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('535',	'653',	25,	'CUNDINAMARCA',	'SAN CAYETANO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('536',	'658',	25,	'CUNDINAMARCA',	'SAN FRANCISCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('537',	'662',	25,	'CUNDINAMARCA',	'SAN JUAN DE RIO SECO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('538',	'718',	25,	'CUNDINAMARCA',	'SASAIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('539',	'736',	25,	'CUNDINAMARCA',	'SESQUILE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('54',	'315',	5,	'ANTIOQUIA',	'GUADALUPE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('540',	'740',	25,	'CUNDINAMARCA',	'SIBATE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('541',	'743',	25,	'CUNDINAMARCA',	'SILVANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('542',	'745',	25,	'CUNDINAMARCA',	'SIMIJACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('543',	'754',	25,	'CUNDINAMARCA',	'SOACHA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('544',	'758',	25,	'CUNDINAMARCA',	'SOPO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('545',	'769',	25,	'CUNDINAMARCA',	'SUBACHOQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('546',	'772',	25,	'CUNDINAMARCA',	'SUESCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('547',	'777',	25,	'CUNDINAMARCA',	'SUPATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('548',	'779',	25,	'CUNDINAMARCA',	'SUSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('549',	'781',	25,	'CUNDINAMARCA',	'SUTATAUSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('55',	'318',	5,	'ANTIOQUIA',	'GUARNE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('550',	'785',	25,	'CUNDINAMARCA',	'TABIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('551',	'793',	25,	'CUNDINAMARCA',	'TAUSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('552',	'797',	25,	'CUNDINAMARCA',	'TENA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('553',	'799',	25,	'CUNDINAMARCA',	'TENJO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('554',	'805',	25,	'CUNDINAMARCA',	'TIBACUY',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('555',	'807',	25,	'CUNDINAMARCA',	'TIBIRITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('556',	'815',	25,	'CUNDINAMARCA',	'TOCAIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('557',	'817',	25,	'CUNDINAMARCA',	'TOCANCIPA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('558',	'823',	25,	'CUNDINAMARCA',	'TOPAIPI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('559',	'839',	25,	'CUNDINAMARCA',	'UBALA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('56',	'321',	5,	'ANTIOQUIA',	'GUATAPE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('560',	'841',	25,	'CUNDINAMARCA',	'UBAQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('561',	'843',	25,	'CUNDINAMARCA',	'VILLA DE SAN DIEGO DE UBATE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('562',	'845',	25,	'CUNDINAMARCA',	'UNE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('563',	'851',	25,	'CUNDINAMARCA',	'UTICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('564',	'862',	25,	'CUNDINAMARCA',	'VERGARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('565',	'867',	25,	'CUNDINAMARCA',	'VIANI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('566',	'871',	25,	'CUNDINAMARCA',	'VILLAGOMEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('567',	'873',	25,	'CUNDINAMARCA',	'VILLAPINZON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('568',	'875',	25,	'CUNDINAMARCA',	'VILLETA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('569',	'878',	25,	'CUNDINAMARCA',	'VIOTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('57',	'347',	5,	'ANTIOQUIA',	'HELICONIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('570',	'885',	25,	'CUNDINAMARCA',	'YACOPI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('571',	'898',	25,	'CUNDINAMARCA',	'ZIPACON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('572',	'899',	25,	'CUNDINAMARCA',	'ZIPAQUIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('573',	'001',	27,	'CHOCO',	'QUIBDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('574',	'006',	27,	'CHOCO',	'ACANDI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('575',	'025',	27,	'CHOCO',	'ALTO BAUDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('576',	'050',	27,	'CHOCO',	'ATRATO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('577',	'073',	27,	'CHOCO',	'BAGADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('578',	'075',	27,	'CHOCO',	'BAHIA SOLANO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('579',	'077',	27,	'CHOCO',	'BAJO BAUDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('58',	'353',	5,	'ANTIOQUIA',	'HISPANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('580',	'099',	27,	'CHOCO',	'BOJAYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('581',	'135',	27,	'CHOCO',	'EL CANTON DEL SAN PABLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('582',	'150',	27,	'CHOCO',	'CARMEN DEL DARIEN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('583',	'160',	27,	'CHOCO',	'CERTEGUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('584',	'205',	27,	'CHOCO',	'CONDOTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('585',	'245',	27,	'CHOCO',	'EL CARMEN DE ATRATO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('586',	'250',	27,	'CHOCO',	'EL LITORAL DEL SAN JUAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('587',	'361',	27,	'CHOCO',	'ISTMINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('588',	'372',	27,	'CHOCO',	'JURADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('589',	'413',	27,	'CHOCO',	'LLORO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('59',	'360',	5,	'ANTIOQUIA',	'ITAGUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('590',	'425',	27,	'CHOCO',	'MEDIO ATRATO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('591',	'430',	27,	'CHOCO',	'MEDIO BAUDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('592',	'450',	27,	'CHOCO',	'MEDIO SAN JUAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('593',	'491',	27,	'CHOCO',	'NOVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('594',	'495',	27,	'CHOCO',	'NUQUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('595',	'580',	27,	'CHOCO',	'RIO IRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('596',	'600',	27,	'CHOCO',	'RIO QUITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('597',	'615',	27,	'CHOCO',	'RIOSUCIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('598',	'660',	27,	'CHOCO',	'SAN JOSE DEL PALMAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('599',	'745',	27,	'CHOCO',	'SIPI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('6',	'031',	5,	'ANTIOQUIA',	'AMALFI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('60',	'361',	5,	'ANTIOQUIA',	'ITUANGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('600',	'787',	27,	'CHOCO',	'TADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('601',	'800',	27,	'CHOCO',	'UNGUIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('602',	'810',	27,	'CHOCO',	'UNION PANAMERICANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('603',	'001',	41,	'HUILA',	'NEIVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('604',	'006',	41,	'HUILA',	'ACEVEDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('605',	'013',	41,	'HUILA',	'AGRADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('606',	'016',	41,	'HUILA',	'AIPE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('607',	'020',	41,	'HUILA',	'ALGECIRAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('608',	'026',	41,	'HUILA',	'ALTAMIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('609',	'078',	41,	'HUILA',	'BARAYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('61',	'364',	5,	'ANTIOQUIA',	'JARDIN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('610',	'132',	41,	'HUILA',	'CAMPOALEGRE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('611',	'206',	41,	'HUILA',	'COLOMBIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('612',	'244',	41,	'HUILA',	'ELIAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('613',	'298',	41,	'HUILA',	'GARZON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('614',	'306',	41,	'HUILA',	'GIGANTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('615',	'319',	41,	'HUILA',	'GUADALUPE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('616',	'349',	41,	'HUILA',	'HOBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('617',	'357',	41,	'HUILA',	'IQUIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('618',	'359',	41,	'HUILA',	'ISNOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('619',	'378',	41,	'HUILA',	'LA ARGENTINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('62',	'368',	5,	'ANTIOQUIA',	'JERICO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('620',	'396',	41,	'HUILA',	'LA PLATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('621',	'483',	41,	'HUILA',	'NATAGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('622',	'503',	41,	'HUILA',	'OPORAPA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('623',	'518',	41,	'HUILA',	'PAICOL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('624',	'524',	41,	'HUILA',	'PALERMO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('625',	'530',	41,	'HUILA',	'PALESTINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('626',	'548',	41,	'HUILA',	'PITAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('627',	'551',	41,	'HUILA',	'PITALITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('628',	'615',	41,	'HUILA',	'RIVERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('629',	'660',	41,	'HUILA',	'SALADOBLANCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('63',	'376',	5,	'ANTIOQUIA',	'LA CEJA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('630',	'668',	41,	'HUILA',	'SAN AGUSTIN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('631',	'676',	41,	'HUILA',	'SANTA MARIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('632',	'770',	41,	'HUILA',	'SUAZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('633',	'791',	41,	'HUILA',	'TARQUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('634',	'797',	41,	'HUILA',	'TESALIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('635',	'799',	41,	'HUILA',	'TELLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('636',	'801',	41,	'HUILA',	'TERUEL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('637',	'807',	41,	'HUILA',	'TIMANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('638',	'872',	41,	'HUILA',	'VILLAVIEJA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('639',	'885',	41,	'HUILA',	'YAGUARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('64',	'380',	5,	'ANTIOQUIA',	'LA ESTRELLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('640',	'001',	44,	'LA GUAJIRA',	'RIOHACHA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('641',	'035',	44,	'LA GUAJIRA',	'ALBANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('642',	'078',	44,	'LA GUAJIRA',	'BARRANCAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('643',	'090',	44,	'LA GUAJIRA',	'DIBULLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('644',	'098',	44,	'LA GUAJIRA',	'DISTRACCION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('645',	'110',	44,	'LA GUAJIRA',	'EL MOLINO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('646',	'279',	44,	'LA GUAJIRA',	'FONSECA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('647',	'378',	44,	'LA GUAJIRA',	'HATONUEVO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('648',	'420',	44,	'LA GUAJIRA',	'LA JAGUA DEL PILAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('649',	'430',	44,	'LA GUAJIRA',	'MAICAO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('65',	'390',	5,	'ANTIOQUIA',	'LA PINTADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('650',	'560',	44,	'LA GUAJIRA',	'MANAURE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('651',	'650',	44,	'LA GUAJIRA',	'SAN JUAN DEL CESAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('652',	'847',	44,	'LA GUAJIRA',	'URIBIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('653',	'855',	44,	'LA GUAJIRA',	'URUMITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('654',	'874',	44,	'LA GUAJIRA',	'VILLANUEVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('655',	'001',	47,	'MAGDALENA',	'SANTA MARTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('656',	'030',	47,	'MAGDALENA',	'ALGARROBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('657',	'053',	47,	'MAGDALENA',	'ARACATACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('658',	'058',	47,	'MAGDALENA',	'ARIGUANI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('659',	'161',	47,	'MAGDALENA',	'CERRO SAN ANTONIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('66',	'400',	5,	'ANTIOQUIA',	'LA UNION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('660',	'170',	47,	'MAGDALENA',	'CHIBOLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('661',	'189',	47,	'MAGDALENA',	'CIENAGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('662',	'205',	47,	'MAGDALENA',	'CONCORDIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('663',	'245',	47,	'MAGDALENA',	'EL BANCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('664',	'258',	47,	'MAGDALENA',	'EL PI?ON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('665',	'268',	47,	'MAGDALENA',	'EL RETEN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('666',	'288',	47,	'MAGDALENA',	'FUNDACION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('667',	'318',	47,	'MAGDALENA',	'GUAMAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('668',	'460',	47,	'MAGDALENA',	'NUEVA GRANADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('669',	'541',	47,	'MAGDALENA',	'PEDRAZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('67',	'411',	5,	'ANTIOQUIA',	'LIBORINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('670',	'545',	47,	'MAGDALENA',	'PIJI?O DEL CARMEN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('671',	'551',	47,	'MAGDALENA',	'PIVIJAY',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('672',	'555',	47,	'MAGDALENA',	'PLATO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('673',	'570',	47,	'MAGDALENA',	'PUEBLOVIEJO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('674',	'605',	47,	'MAGDALENA',	'REMOLINO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('675',	'660',	47,	'MAGDALENA',	'SABANAS DE SAN ANGEL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('676',	'675',	47,	'MAGDALENA',	'SALAMINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('677',	'692',	47,	'MAGDALENA',	'SAN SEBASTIAN DE BUENAVISTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('678',	'703',	47,	'MAGDALENA',	'SAN ZENON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('679',	'707',	47,	'MAGDALENA',	'SANTA ANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('68',	'425',	5,	'ANTIOQUIA',	'MACEO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('680',	'720',	47,	'MAGDALENA',	'SANTA BARBARA DE PINTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('681',	'745',	47,	'MAGDALENA',	'SITIONUEVO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('682',	'798',	47,	'MAGDALENA',	'TENERIFE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('683',	'960',	47,	'MAGDALENA',	'ZAPAYAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('684',	'980',	47,	'MAGDALENA',	'ZONA BANANERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('685',	'001',	50,	'META',	'VILLAVICENCIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('686',	'006',	50,	'META',	'ACACIAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('687',	'110',	50,	'META',	'BARRANCA DE UPIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('688',	'124',	50,	'META',	'CABUYARO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('689',	'150',	50,	'META',	'CASTILLA LA NUEVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('69',	'440',	5,	'ANTIOQUIA',	'MARINILLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('690',	'223',	50,	'META',	'CUBARRAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('691',	'226',	50,	'META',	'CUMARAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('692',	'245',	50,	'META',	'EL CALVARIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('693',	'251',	50,	'META',	'EL CASTILLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('694',	'270',	50,	'META',	'EL DORADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('695',	'287',	50,	'META',	'FUENTE DE ORO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('696',	'313',	50,	'META',	'GRANADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('697',	'318',	50,	'META',	'GUAMAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('698',	'325',	50,	'META',	'MAPIRIPAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('699',	'330',	50,	'META',	'MESETAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('7',	'034',	5,	'ANTIOQUIA',	'ANDES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('70',	'467',	5,	'ANTIOQUIA',	'MONTEBELLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('700',	'350',	50,	'META',	'LA MACARENA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('701',	'370',	50,	'META',	'URIBE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('702',	'400',	50,	'META',	'LEJANIAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('703',	'450',	50,	'META',	'PUERTO CONCORDIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('704',	'568',	50,	'META',	'PUERTO GAITAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('705',	'573',	50,	'META',	'PUERTO LOPEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('706',	'577',	50,	'META',	'PUERTO LLERAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('707',	'590',	50,	'META',	'PUERTO RICO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('708',	'606',	50,	'META',	'RESTREPO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('709',	'680',	50,	'META',	'SAN CARLOS DE GUAROA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('71',	'475',	5,	'ANTIOQUIA',	'MURINDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('710',	'683',	50,	'META',	'SAN JUAN DE ARAMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('711',	'686',	50,	'META',	'SAN JUANITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('712',	'689',	50,	'META',	'SAN MARTIN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('713',	'711',	50,	'META',	'VISTAHERMOSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('714',	'001',	52,	'NARI?O',	'PASTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('715',	'019',	52,	'NARI?O',	'ALBAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('716',	'022',	52,	'NARI?O',	'ALDANA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('717',	'036',	52,	'NARI?O',	'ANCUYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('718',	'051',	52,	'NARI?O',	'ARBOLEDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('719',	'079',	52,	'NARI?O',	'BARBACOAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('72',	'480',	5,	'ANTIOQUIA',	'MUTATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('720',	'083',	52,	'NARI?O',	'BELEN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('721',	'110',	52,	'NARI?O',	'BUESACO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('722',	'203',	52,	'NARI?O',	'COLON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('723',	'207',	52,	'NARI?O',	'CONSACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('724',	'210',	52,	'NARI?O',	'CONTADERO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('725',	'215',	52,	'NARI?O',	'CORDOBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('726',	'224',	52,	'NARI?O',	'CUASPUD',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('727',	'227',	52,	'NARI?O',	'CUMBAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('728',	'233',	52,	'NARI?O',	'CUMBITARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('729',	'240',	52,	'NARI?O',	'CHACHAGsI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('73',	'483',	5,	'ANTIOQUIA',	'NARI?O',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('730',	'250',	52,	'NARI?O',	'EL CHARCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('731',	'254',	52,	'NARI?O',	'EL PE?OL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('732',	'256',	52,	'NARI?O',	'EL ROSARIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('733',	'258',	52,	'NARI?O',	'EL TABLON DE GOMEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('734',	'260',	52,	'NARI?O',	'EL TAMBO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('735',	'287',	52,	'NARI?O',	'FUNES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('736',	'317',	52,	'NARI?O',	'GUACHUCAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('737',	'320',	52,	'NARI?O',	'GUAITARILLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('738',	'323',	52,	'NARI?O',	'GUALMATAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('739',	'352',	52,	'NARI?O',	'ILES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('74',	'490',	5,	'ANTIOQUIA',	'NECOCLI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('740',	'354',	52,	'NARI?O',	'IMUES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('741',	'356',	52,	'NARI?O',	'IPIALES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('742',	'378',	52,	'NARI?O',	'LA CRUZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('743',	'381',	52,	'NARI?O',	'LA FLORIDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('744',	'385',	52,	'NARI?O',	'LA LLANADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('745',	'390',	52,	'NARI?O',	'LA TOLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('746',	'399',	52,	'NARI?O',	'LA UNION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('747',	'405',	52,	'NARI?O',	'LEIVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('748',	'411',	52,	'NARI?O',	'LINARES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('749',	'418',	52,	'NARI?O',	'LOS ANDES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('75',	'495',	5,	'ANTIOQUIA',	'NECHI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('750',	'427',	52,	'NARI?O',	'MAGsI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('751',	'435',	52,	'NARI?O',	'MALLAMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('752',	'473',	52,	'NARI?O',	'MOSQUERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('753',	'480',	52,	'NARI?O',	'NARI?O',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('754',	'490',	52,	'NARI?O',	'OLAYA HERRERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('755',	'506',	52,	'NARI?O',	'OSPINA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('756',	'520',	52,	'NARI?O',	'FRANCISCO PIZARRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('757',	'540',	52,	'NARI?O',	'POLICARPA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('758',	'560',	52,	'NARI?O',	'POTOSI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('759',	'565',	52,	'NARI?O',	'PROVIDENCIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('76',	'501',	5,	'ANTIOQUIA',	'OLAYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('760',	'573',	52,	'NARI?O',	'PUERRES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('761',	'585',	52,	'NARI?O',	'PUPIALES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('762',	'612',	52,	'NARI?O',	'RICAURTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('763',	'621',	52,	'NARI?O',	'ROBERTO PAYAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('764',	'678',	52,	'NARI?O',	'SAMANIEGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('765',	'683',	52,	'NARI?O',	'SANDONA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('766',	'685',	52,	'NARI?O',	'SAN BERNARDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('767',	'687',	52,	'NARI?O',	'SAN LORENZO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('768',	'693',	52,	'NARI?O',	'SAN PABLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('769',	'694',	52,	'NARI?O',	'SAN PEDRO DE CARTAGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('77',	'541',	5,	'ANTIOQUIA',	'PE?OL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('770',	'696',	52,	'NARI?O',	'SANTA BARBARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('771',	'699',	52,	'NARI?O',	'SANTACRUZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('772',	'720',	52,	'NARI?O',	'SAPUYES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('773',	'786',	52,	'NARI?O',	'TAMINANGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('774',	'788',	52,	'NARI?O',	'TANGUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('775',	'835',	52,	'NARI?O',	'SAN ANDRES DE TUMACO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('776',	'838',	52,	'NARI?O',	'TUQUERRES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('777',	'885',	52,	'NARI?O',	'YACUANQUER',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('778',	'001',	54,	'N. DE SANTANDER',	'CUCUTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('779',	'003',	54,	'N. DE SANTANDER',	'ABREGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('78',	'543',	5,	'ANTIOQUIA',	'PEQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('780',	'051',	54,	'N. DE SANTANDER',	'ARBOLEDAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('781',	'099',	54,	'N. DE SANTANDER',	'BOCHALEMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('782',	'109',	54,	'N. DE SANTANDER',	'BUCARASICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('783',	'125',	54,	'N. DE SANTANDER',	'CACOTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('784',	'128',	54,	'N. DE SANTANDER',	'CACHIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('785',	'172',	54,	'N. DE SANTANDER',	'CHINACOTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('786',	'174',	54,	'N. DE SANTANDER',	'CHITAGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('787',	'206',	54,	'N. DE SANTANDER',	'CONVENCION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('788',	'223',	54,	'N. DE SANTANDER',	'CUCUTILLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('789',	'239',	54,	'N. DE SANTANDER',	'DURANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('79',	'576',	5,	'ANTIOQUIA',	'PUEBLORRICO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('790',	'245',	54,	'N. DE SANTANDER',	'EL CARMEN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('791',	'250',	54,	'N. DE SANTANDER',	'EL TARRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('792',	'261',	54,	'N. DE SANTANDER',	'EL ZULIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('793',	'313',	54,	'N. DE SANTANDER',	'GRAMALOTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('794',	'344',	54,	'N. DE SANTANDER',	'HACARI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('795',	'347',	54,	'N. DE SANTANDER',	'HERRAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('796',	'377',	54,	'N. DE SANTANDER',	'LABATECA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('797',	'385',	54,	'N. DE SANTANDER',	'LA ESPERANZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('798',	'398',	54,	'N. DE SANTANDER',	'LA PLAYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('799',	'405',	54,	'N. DE SANTANDER',	'LOS PATIOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('8',	'036',	5,	'ANTIOQUIA',	'ANGELOPOLIS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('80',	'579',	5,	'ANTIOQUIA',	'PUERTO BERRIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('800',	'418',	54,	'N. DE SANTANDER',	'LOURDES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('801',	'480',	54,	'N. DE SANTANDER',	'MUTISCUA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('802',	'498',	54,	'N. DE SANTANDER',	'OCA?A',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('803',	'518',	54,	'N. DE SANTANDER',	'PAMPLONA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('804',	'520',	54,	'N. DE SANTANDER',	'PAMPLONITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('805',	'553',	54,	'N. DE SANTANDER',	'PUERTO SANTANDER',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('806',	'599',	54,	'N. DE SANTANDER',	'RAGONVALIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('807',	'660',	54,	'N. DE SANTANDER',	'SALAZAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('808',	'670',	54,	'N. DE SANTANDER',	'SAN CALIXTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('809',	'673',	54,	'N. DE SANTANDER',	'SAN CAYETANO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('81',	'585',	5,	'ANTIOQUIA',	'PUERTO NARE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('810',	'680',	54,	'N. DE SANTANDER',	'SANTIAGO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('811',	'720',	54,	'N. DE SANTANDER',	'SARDINATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('812',	'743',	54,	'N. DE SANTANDER',	'SILOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('813',	'800',	54,	'N. DE SANTANDER',	'TEORAMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('814',	'810',	54,	'N. DE SANTANDER',	'TIBU',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('815',	'820',	54,	'N. DE SANTANDER',	'TOLEDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('816',	'871',	54,	'N. DE SANTANDER',	'VILLA CARO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('817',	'874',	54,	'N. DE SANTANDER',	'VILLA DEL ROSARIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('818',	'001',	63,	'QUINDIO',	'ARMENIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('819',	'111',	63,	'QUINDIO',	'BUENAVISTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('82',	'591',	5,	'ANTIOQUIA',	'PUERTO TRIUNFO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('820',	'130',	63,	'QUINDIO',	'CALARCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('821',	'190',	63,	'QUINDIO',	'CIRCASIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('822',	'212',	63,	'QUINDIO',	'CORDOBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('823',	'272',	63,	'QUINDIO',	'FILANDIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('824',	'302',	63,	'QUINDIO',	'GENOVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('825',	'401',	63,	'QUINDIO',	'LA TEBAIDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('826',	'470',	63,	'QUINDIO',	'MONTENEGRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('827',	'548',	63,	'QUINDIO',	'PIJAO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('828',	'594',	63,	'QUINDIO',	'QUIMBAYA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('829',	'690',	63,	'QUINDIO',	'SALENTO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('83',	'604',	5,	'ANTIOQUIA',	'REMEDIOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('830',	'001',	66,	'RISARALDA',	'PEREIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('831',	'045',	66,	'RISARALDA',	'APIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('832',	'075',	66,	'RISARALDA',	'BALBOA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('833',	'088',	66,	'RISARALDA',	'BELEN DE UMBRIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('834',	'170',	66,	'RISARALDA',	'DOSQUEBRADAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('835',	'318',	66,	'RISARALDA',	'GUATICA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('836',	'383',	66,	'RISARALDA',	'LA CELIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('837',	'400',	66,	'RISARALDA',	'LA VIRGINIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('838',	'440',	66,	'RISARALDA',	'MARSELLA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('839',	'456',	66,	'RISARALDA',	'MISTRATO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('84',	'607',	5,	'ANTIOQUIA',	'RETIRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('840',	'572',	66,	'RISARALDA',	'PUEBLO RICO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('841',	'594',	66,	'RISARALDA',	'QUINCHIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('842',	'682',	66,	'RISARALDA',	'SANTA ROSA DE CABAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('843',	'687',	66,	'RISARALDA',	'SANTUARIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('844',	'001',	68,	'SANTANDER',	'BUCARAMANGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('845',	'013',	68,	'SANTANDER',	'AGUADA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('846',	'020',	68,	'SANTANDER',	'ALBANIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('847',	'051',	68,	'SANTANDER',	'ARATOCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('848',	'077',	68,	'SANTANDER',	'BARBOSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('849',	'079',	68,	'SANTANDER',	'BARICHARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('85',	'615',	5,	'ANTIOQUIA',	'RIONEGRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('850',	'081',	68,	'SANTANDER',	'BARRANCABERMEJA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('851',	'092',	68,	'SANTANDER',	'BETULIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('852',	'101',	68,	'SANTANDER',	'BOLIVAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('853',	'121',	68,	'SANTANDER',	'CABRERA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('854',	'132',	68,	'SANTANDER',	'CALIFORNIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('855',	'147',	68,	'SANTANDER',	'CAPITANEJO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('856',	'152',	68,	'SANTANDER',	'CARCASI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('857',	'160',	68,	'SANTANDER',	'CEPITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('858',	'162',	68,	'SANTANDER',	'CERRITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('859',	'167',	68,	'SANTANDER',	'CHARALA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('86',	'628',	5,	'ANTIOQUIA',	'SABANALARGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('860',	'169',	68,	'SANTANDER',	'CHARTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('861',	'176',	68,	'SANTANDER',	'CHIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('862',	'179',	68,	'SANTANDER',	'CHIPATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('863',	'190',	68,	'SANTANDER',	'CIMITARRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('864',	'207',	68,	'SANTANDER',	'CONCEPCION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('865',	'209',	68,	'SANTANDER',	'CONFINES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('866',	'211',	68,	'SANTANDER',	'CONTRATACION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('867',	'217',	68,	'SANTANDER',	'COROMORO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('868',	'229',	68,	'SANTANDER',	'CURITI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('869',	'235',	68,	'SANTANDER',	'EL CARMEN DE CHUCURI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('87',	'631',	5,	'ANTIOQUIA',	'SABANETA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('870',	'245',	68,	'SANTANDER',	'EL GUACAMAYO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('871',	'250',	68,	'SANTANDER',	'EL PE?ON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('872',	'255',	68,	'SANTANDER',	'EL PLAYON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('873',	'264',	68,	'SANTANDER',	'ENCINO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('874',	'266',	68,	'SANTANDER',	'ENCISO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('875',	'271',	68,	'SANTANDER',	'FLORIAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('876',	'276',	68,	'SANTANDER',	'FLORIDABLANCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('877',	'296',	68,	'SANTANDER',	'GALAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('878',	'298',	68,	'SANTANDER',	'GAMBITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('879',	'307',	68,	'SANTANDER',	'GIRON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('88',	'642',	5,	'ANTIOQUIA',	'SALGAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('880',	'318',	68,	'SANTANDER',	'GUACA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('881',	'320',	68,	'SANTANDER',	'GUADALUPE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('882',	'322',	68,	'SANTANDER',	'GUAPOTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('883',	'324',	68,	'SANTANDER',	'GUAVATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('884',	'327',	68,	'SANTANDER',	'GsEPSA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('885',	'344',	68,	'SANTANDER',	'HATO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('886',	'368',	68,	'SANTANDER',	'JESUS MARIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('887',	'370',	68,	'SANTANDER',	'JORDAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('888',	'377',	68,	'SANTANDER',	'LA BELLEZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('889',	'385',	68,	'SANTANDER',	'LANDAZURI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('89',	'647',	5,	'ANTIOQUIA',	'SAN ANDRES DE CUERQUIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('890',	'397',	68,	'SANTANDER',	'LA PAZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('891',	'406',	68,	'SANTANDER',	'LEBRIJA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('892',	'418',	68,	'SANTANDER',	'LOS SANTOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('893',	'425',	68,	'SANTANDER',	'MACARAVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('894',	'432',	68,	'SANTANDER',	'MALAGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('895',	'444',	68,	'SANTANDER',	'MATANZA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('896',	'464',	68,	'SANTANDER',	'MOGOTES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('897',	'468',	68,	'SANTANDER',	'MOLAGAVITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('898',	'498',	68,	'SANTANDER',	'OCAMONTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('899',	'500',	68,	'SANTANDER',	'OIBA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('9',	'038',	5,	'ANTIOQUIA',	'ANGOSTURA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('90',	'649',	5,	'ANTIOQUIA',	'SAN CARLOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('900',	'502',	68,	'SANTANDER',	'ONZAGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('901',	'522',	68,	'SANTANDER',	'PALMAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('902',	'524',	68,	'SANTANDER',	'PALMAS DEL SOCORRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('903',	'533',	68,	'SANTANDER',	'PARAMO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('904',	'547',	68,	'SANTANDER',	'PIEDECUESTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('905',	'549',	68,	'SANTANDER',	'PINCHOTE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('906',	'572',	68,	'SANTANDER',	'PUENTE NACIONAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('907',	'573',	68,	'SANTANDER',	'PUERTO PARRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('908',	'575',	68,	'SANTANDER',	'PUERTO WILCHES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('909',	'615',	68,	'SANTANDER',	'RIONEGRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('91',	'652',	5,	'ANTIOQUIA',	'SAN FRANCISCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('910',	'655',	68,	'SANTANDER',	'SABANA DE TORRES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('911',	'669',	68,	'SANTANDER',	'SAN ANDRES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('912',	'673',	68,	'SANTANDER',	'SAN BENITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('913',	'679',	68,	'SANTANDER',	'SAN GIL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('914',	'682',	68,	'SANTANDER',	'SAN JOAQUIN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('915',	'684',	68,	'SANTANDER',	'SAN JOSE DE MIRANDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('916',	'686',	68,	'SANTANDER',	'SAN MIGUEL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('917',	'689',	68,	'SANTANDER',	'SAN VICENTE DE CHUCURI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('918',	'705',	68,	'SANTANDER',	'SANTA BARBARA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('919',	'720',	68,	'SANTANDER',	'SANTA HELENA DEL OPON',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('92',	'656',	5,	'ANTIOQUIA',	'SAN JERONIMO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('920',	'745',	68,	'SANTANDER',	'SIMACOTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('921',	'755',	68,	'SANTANDER',	'SOCORRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('922',	'770',	68,	'SANTANDER',	'SUAITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('923',	'773',	68,	'SANTANDER',	'SUCRE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('924',	'780',	68,	'SANTANDER',	'SURATA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('925',	'820',	68,	'SANTANDER',	'TONA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('926',	'855',	68,	'SANTANDER',	'VALLE DE SAN JOSE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('927',	'861',	68,	'SANTANDER',	'VELEZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('928',	'867',	68,	'SANTANDER',	'VETAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('929',	'872',	68,	'SANTANDER',	'VILLANUEVA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('93',	'658',	5,	'ANTIOQUIA',	'SAN JOSE DE LA MONTA?A',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('930',	'895',	68,	'SANTANDER',	'ZAPATOCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('931',	'001',	70,	'SUCRE',	'SINCELEJO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('932',	'110',	70,	'SUCRE',	'BUENAVISTA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('933',	'124',	70,	'SUCRE',	'CAIMITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('934',	'204',	70,	'SUCRE',	'COLOSO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('935',	'215',	70,	'SUCRE',	'COROZAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('936',	'221',	70,	'SUCRE',	'COVE?AS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('937',	'230',	70,	'SUCRE',	'CHALAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('938',	'233',	70,	'SUCRE',	'EL ROBLE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('939',	'235',	70,	'SUCRE',	'GALERAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('94',	'659',	5,	'ANTIOQUIA',	'SAN JUAN DE URABA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('940',	'265',	70,	'SUCRE',	'GUARANDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('941',	'400',	70,	'SUCRE',	'LA UNION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('942',	'418',	70,	'SUCRE',	'LOS PALMITOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('943',	'429',	70,	'SUCRE',	'MAJAGUAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('944',	'473',	70,	'SUCRE',	'MORROA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('945',	'508',	70,	'SUCRE',	'OVEJAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('946',	'523',	70,	'SUCRE',	'PALMITO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('947',	'670',	70,	'SUCRE',	'SAMPUES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('948',	'678',	70,	'SUCRE',	'SAN BENITO ABAD',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('949',	'702',	70,	'SUCRE',	'SAN JUAN DE BETULIA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('95',	'660',	5,	'ANTIOQUIA',	'SAN LUIS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('950',	'708',	70,	'SUCRE',	'SAN MARCOS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('951',	'713',	70,	'SUCRE',	'SAN ONOFRE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('952',	'717',	70,	'SUCRE',	'SAN PEDRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('953',	'742',	70,	'SUCRE',	'SAN LUIS DE SINCE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('954',	'771',	70,	'SUCRE',	'SUCRE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('955',	'820',	70,	'SUCRE',	'SANTIAGO DE TOLU',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('956',	'823',	70,	'SUCRE',	'TOLU VIEJO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('957',	'001',	73,	'TOLIMA',	'IBAGUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('958',	'024',	73,	'TOLIMA',	'ALPUJARRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('959',	'026',	73,	'TOLIMA',	'ALVARADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('96',	'664',	5,	'ANTIOQUIA',	'SAN PEDRO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('960',	'030',	73,	'TOLIMA',	'AMBALEMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('961',	'043',	73,	'TOLIMA',	'ANZOATEGUI',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('962',	'055',	73,	'TOLIMA',	'ARMERO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('963',	'067',	73,	'TOLIMA',	'ATACO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('964',	'124',	73,	'TOLIMA',	'CAJAMARCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('965',	'148',	73,	'TOLIMA',	'CARMEN DE APICALA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('966',	'152',	73,	'TOLIMA',	'CASABIANCA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('967',	'168',	73,	'TOLIMA',	'CHAPARRAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('968',	'200',	73,	'TOLIMA',	'COELLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('969',	'217',	73,	'TOLIMA',	'COYAIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('97',	'665',	5,	'ANTIOQUIA',	'SAN PEDRO DE URABA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('970',	'226',	73,	'TOLIMA',	'CUNDAY',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('971',	'236',	73,	'TOLIMA',	'DOLORES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('972',	'268',	73,	'TOLIMA',	'ESPINAL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('973',	'270',	73,	'TOLIMA',	'FALAN',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('974',	'275',	73,	'TOLIMA',	'FLANDES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('975',	'283',	73,	'TOLIMA',	'FRESNO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('976',	'319',	73,	'TOLIMA',	'GUAMO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('977',	'347',	73,	'TOLIMA',	'HERVEO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('978',	'349',	73,	'TOLIMA',	'HONDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('979',	'352',	73,	'TOLIMA',	'ICONONZO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('98',	'667',	5,	'ANTIOQUIA',	'SAN RAFAEL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('980',	'408',	73,	'TOLIMA',	'LERIDA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('981',	'411',	73,	'TOLIMA',	'LIBANO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('982',	'443',	73,	'TOLIMA',	'MARIQUITA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('983',	'449',	73,	'TOLIMA',	'MELGAR',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('984',	'461',	73,	'TOLIMA',	'MURILLO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('985',	'483',	73,	'TOLIMA',	'NATAGAIMA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('986',	'504',	73,	'TOLIMA',	'ORTEGA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('987',	'520',	73,	'TOLIMA',	'PALOCABILDO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('988',	'547',	73,	'TOLIMA',	'PIEDRAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('989',	'555',	73,	'TOLIMA',	'PLANADAS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('99',	'670',	5,	'ANTIOQUIA',	'SAN ROQUE',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('990',	'563',	73,	'TOLIMA',	'PRADO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('991',	'585',	73,	'TOLIMA',	'PURIFICACION',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('992',	'616',	73,	'TOLIMA',	'RIOBLANCO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('993',	'622',	73,	'TOLIMA',	'RONCESVALLES',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('994',	'624',	73,	'TOLIMA',	'ROVIRA',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('995',	'671',	73,	'TOLIMA',	'SALDA?A',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('996',	'675',	73,	'TOLIMA',	'SAN ANTONIO',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('997',	'678',	73,	'TOLIMA',	'SAN LUIS',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('998',	'686',	73,	'TOLIMA',	'SANTA ISABEL',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('999',	'770',	73,	'TOLIMA',	'SUAREZ',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42'),
('ID',	'idMcipio',	0,	'depat',	'muni',	'2019-01-13 14:04:42',	'2019-01-13 09:04:42');

DROP TABLE IF EXISTS `cod_paises`;
CREATE TABLE `cod_paises` (
  `Codigo` int(11) NOT NULL,
  `Pais` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `cod_paises` (`Codigo`, `Pais`, `Updated`, `Sync`) VALUES
(1,	'NIVE ISLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(13,	'AFGANISTAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(17,	'ALBANIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(23,	'ALEMANIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(26,	'ARMENIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(27,	'ARUBA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(29,	'BOSNIA-HERZEGOVINA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(31,	'BURKINA FASSO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(32,	'SERBIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(33,	'ISLA DE MAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(37,	'ANDORRA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(40,	'ANGOLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(41,	'ANGUILLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(43,	'ANTIGUA Y BARBUDA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(47,	'ANTILLAS HOLANDESAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(53,	'ARABIA SAUDITA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(59,	'ARGELIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(63,	'ARGENTINA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(69,	'AUSTRALIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(72,	'AUSTRIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(74,	'AZERBAIJAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(77,	'BAHAMAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(80,	'BAHREIN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(81,	'BANGLADESH',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(83,	'BARBADOS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(87,	'BELGICA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(88,	'BELICE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(90,	'BERMUDAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(91,	'BELORUS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(93,	'BIRMANIA (MYANMAR)',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(97,	'BOLIVIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(101,	'BOTSWANA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(105,	'BRASIL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(108,	'BRUNEI DARUSSALAM',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(111,	'BULGARIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(115,	'BURUNDI',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(119,	'BUTAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(127,	'CABO VERDE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(137,	'CAIMAN, ISLAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(141,	'KAMPUCHEA (CAMBOYA)',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(145,	'CAMERUN, REPUBLICA U',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(149,	'CANADA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(155,	'CANAL(NORMANDAS),ISL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(157,	'CANTON ENDERBURY,ISL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(159,	'CIUDAD DEL VATICANO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(165,	'COCOS (KEELING), ISL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(169,	'COLOMBIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(173,	'COMORAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(177,	'CONGO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(183,	'COOK, ISLAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(187,	'COREA DEL NORTE,REPU',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(190,	'COREA DEL SUR, REPUB',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(193,	'COSTA DE MARFIL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(196,	'COSTA RICA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(198,	'CROACIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(199,	'CUBA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(203,	'CHAD',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(211,	'CHILE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(215,	'CHINA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(218,	'TAIWAN (FORMOSA)',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(221,	'CHIPRE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(229,	'BENIN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(232,	'DINAMARCA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(235,	'DOMINICA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(239,	'ECUADOR',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(240,	'EGIPTO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(242,	'EL SALVADOR',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(243,	'ERITREA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(244,	'EMIRATOS ARABES UNID',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(245,	'ESPA?A',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(246,	'ESLOVAQUIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(247,	'ESLOVENIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(249,	'ESTADOS UNIDOS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(251,	'ESTONIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(253,	'ETIOPIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(259,	'FEROE, ISLAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(267,	'FILIPINAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(271,	'FINLANDIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(275,	'FRANCIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(281,	'GABON',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(285,	'GAMBIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(286,	'GAZA Y JERICO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(287,	'GEORGIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(289,	'GHANA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(293,	'GIBRALTAR',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(297,	'GRANADA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(301,	'GRECIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(305,	'GROENLANDIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(309,	'GUADALUPE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(313,	'GUAM',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(317,	'GUATEMALA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(325,	'GUAYANA FRANCESA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(329,	'GUINEA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(331,	'GUINEA ECUATORIAL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(334,	'GUINEA - BISSAU',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(337,	'GUYANA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(341,	'HAITI',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(345,	'HONDURAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(351,	'HONG KONG',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(355,	'HUNGRIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(361,	'INDIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(365,	'INDONESIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(369,	'IRAK',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(372,	'IRAN, REPUBLICA ISLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(375,	'IRLANDA (EIRE)',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(379,	'ISLANDIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(383,	'ISRAEL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(386,	'ITALIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(391,	'JAMAICA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(395,	'JOHNSTON,ISLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(399,	'JAPON',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(403,	'JORDANIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(406,	'KAZAJSTAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(410,	'KENYA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(411,	'KIRIBATI',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(412,	'KIRGUIZISTAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(413,	'KUWAIT',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(420,	'LAOS,REPUBLICA POPUL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(426,	'LESOTHO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(429,	'LETONIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(431,	'LIBANO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(434,	'LIBERIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(438,	'LIBIA(INCLUYE FEZZAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(440,	'LIECHTENSTEIN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(443,	'LITUANIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(445,	'LUXEMBURGO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(447,	'MACAO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(448,	'MACEDONIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(450,	'MADAGASCAR',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(455,	'MALASIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(458,	'MALAWI',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(461,	'MALDIVAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(464,	'MALI',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(467,	'MALTA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(469,	'MARIANAS DEL NORTE,I',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(472,	'MARSHALL, ISLAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(474,	'MARRUECOS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(477,	'MARTINICA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(485,	'MAURICIO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(488,	'MAURITANIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(493,	'MEXICO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(494,	'MICRONESIA,ESTADOS F',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(495,	'MIDWAY, ISLAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(496,	'MOLDAVIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(497,	'MONGOLIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(498,	'MONACO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(501,	'MONSERRAT, ISLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(502,	'MONTENEGRO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(505,	'MOZAMBIQUE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(507,	'NAMIBIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(508,	'NAURU',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(511,	'NAVIDAD (CHRISTMAS)',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(517,	'NEPAL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(521,	'NICARAGUA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(525,	'NIGER',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(528,	'NIGERIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(531,	'NIUE, ISLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(535,	'NORFOLK, ISLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(538,	'NORUEGA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(542,	'NUEVA CALEDONIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(545,	'PAPUASIA NUEV GUINEA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(548,	'NUEVA ZELANDIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(551,	'VANUATU',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(556,	'OMAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(566,	'ISLAS MENORES DE ESTADOS UNIDOS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(573,	'PAISES BAJOS(HOLANDA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(576,	'PAKISTAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(578,	'PALAU, ISLAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(579,	'PALESTINA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(580,	'PANAMA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(586,	'PARAGUAY',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(589,	'PERU',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(593,	'PITCAIRN, ISLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(599,	'POLINESIA FRANCESA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(603,	'POLONIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(607,	'PORTUGAL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(611,	'PUERTO RICO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(618,	'QATAR',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(628,	'REINO UNIDO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(640,	'REPUBLICA CENTROAFRI',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(644,	'REPUBLICA CHECA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(647,	'REPUBLICA DOMINICANA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(660,	'REUNION',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(665,	'ZIMBABWE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(670,	'RUMANIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(675,	'RWANDA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(676,	'RUSIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(677,	'SALOMSN, ISLAS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(685,	'SAHARA OCCIDENTAL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(687,	'SAMOA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(690,	'SAMOA NORTEAMERICANA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(695,	'SAN CRISTOBAL Y NIEVES',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(697,	'SAN MARINO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(700,	'SAN PEDRO Y MIGUELON',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(705,	'SAN VICENTE Y LAS GR',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(710,	'SANTA ELENA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(715,	'SANTA LUCIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(720,	'SANTO TOME Y PRINCIP',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(728,	'SENEGAL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(731,	'SEYCHELLES',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(735,	'SIERRA LEONA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(741,	'SINGAPUR',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(744,	'SIRIA,REPUBLICA ARAB',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(748,	'SOMALIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(750,	'SRI LANKA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(756,	'SUDAFRICA,REPUBLICA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(759,	'SUDAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(764,	'SUECIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(767,	'SUIZA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(770,	'SURINAM',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(773,	'SWAZILANDIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(774,	'TADJIKISTAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(776,	'TAILANDIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(780,	'TANZANIA,REPUBLICA U',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(783,	'DJIBOUTI',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(786,	'TERRI ANTARTICO BRIT',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(787,	'TERRITORI BRITANICO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(788,	'TIMOR DEL ESTE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(789,	'CURACAO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(800,	'TOGO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(805,	'TOKELAU',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(810,	'TONGA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(815,	'TRINIDAD Y TOBAGO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(820,	'TUNICIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(823,	'TURCAS Y CAICOS,ISLA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(825,	'TURKMENISTAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(827,	'TURQUIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(828,	'TUVALU',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(830,	'UCRANIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(833,	'UGANDA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(845,	'URUGUAY',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(847,	'UZBEKISTAN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(850,	'VENEZUELA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(855,	'VIETNAM',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(863,	'VIRGENES,ISLAS(BRITA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(866,	'VIRGENES,ISLAS(NORTE',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(870,	'FIJI',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(875,	'WALLIS Y FORTUNA,ISL',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(880,	'YEMEN',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(885,	'YUGOSLAVIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(888,	'REPUBLICA DEMOCRATICA DEL CONGO',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(890,	'ZAMBIA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(895,	'ZONA CANAL DE PANAMA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(897,	'ZONA NEUTRAL(PALESTA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(998,	'COMUNIDAD EUROPEA',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43'),
(999,	'NO DECLARADOS',	'2019-01-13 14:04:43',	'2019-01-13 09:04:43');

DROP TABLE IF EXISTS `colaboradores`;
CREATE TABLE `colaboradores` (
  `idColaboradores` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Identificacion` bigint(20) DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Contacto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NumContacto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SalarioBasico` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idColaboradores`),
  UNIQUE KEY `Identificacion` (`Identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `colaboradores_ventas`;
CREATE TABLE `colaboradores_ventas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` float NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `col_registrohoras`;
CREATE TABLE `col_registrohoras` (
  `IdColRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `IdColaborador` int(11) NOT NULL,
  `RegistroFecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RegistroHora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `EntradaSalida` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`IdColRegistro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comercial_plataformas_pago`;
CREATE TABLE `comercial_plataformas_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NIT` bigint(20) NOT NULL,
  `Activa` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `comercial_plataformas_pago` (`ID`, `Nombre`, `NIT`, `Activa`, `Updated`, `Sync`) VALUES
(1,	'SisteCredito',	811007713,	1,	'2019-04-08 14:13:56',	'2019-04-08 09:13:56'),
(2,	'KUPY',	0,	1,	'2019-04-08 14:13:56',	'2019-04-08 09:13:56');

DROP TABLE IF EXISTS `comercial_plataformas_pago_ingresos`;
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


DROP TABLE IF EXISTS `comercial_plataformas_pago_ventas`;
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


DROP TABLE IF EXISTS `comisiones`;
CREATE TABLE `comisiones` (
  `idComisiones` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comisionesporventas`;
CREATE TABLE `comisionesporventas` (
  `idComisionesPorVentas` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT '5105',
  `NombreCuenta` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Colaboradores_idColaboradores` int(11) NOT NULL,
  `Ventas_NumVenta` int(11) NOT NULL,
  `Paga` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComisionesPorVentas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras` (
  `idCompras` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT '62',
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Retenciones` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoPago` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'Contado',
  `Pagada` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Proveedores_idProveedores` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCompras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `compras_activas`;
CREATE TABLE `compras_activas` (
  `idComprasActivas` int(11) NOT NULL AUTO_INCREMENT,
  `idProveedor` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Factura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombrePro` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaProg` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TotalCompra` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DocumentoGenerado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumComprobante` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComprasActivas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `compras_precompra`;
CREATE TABLE `compras_precompra` (
  `idPreCompra` int(11) NOT NULL AUTO_INCREMENT,
  `idProductosVenta` int(11) NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprasActivas` int(11) NOT NULL,
  `PrecioVentaPre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPreCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_contabilidad`;
CREATE TABLE `comprobantes_contabilidad` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_contabilidad_items`;
CREATE TABLE `comprobantes_contabilidad_items` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idComprobante` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_egreso_items`;
CREATE TABLE `comprobantes_egreso_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idComprobante` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `OrigenMovimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idOrigen` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_ingreso`;
CREATE TABLE `comprobantes_ingreso` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_ingreso_anulaciones`;
CREATE TABLE `comprobantes_ingreso_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_ingreso_items`;
CREATE TABLE `comprobantes_ingreso_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idComprobante` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `OrigenMovimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idOrigen` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_pre`;
CREATE TABLE `comprobantes_pre` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteContabilidad` int(16) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `concejales`;
CREATE TABLE `concejales` (
  `ID` bigint(20) NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Terminacion` date NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `concejales_intervenciones`;
CREATE TABLE `concejales_intervenciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcejal` bigint(20) NOT NULL,
  `idSesionConcejo` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `HoraInicio` time NOT NULL,
  `HoraFin` time NOT NULL,
  `Expresado` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `concejo_sesiones`;
CREATE TABLE `concejo_sesiones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Sesion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `concejo_tipo_sesiones`;
CREATE TABLE `concejo_tipo_sesiones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `conceptos`;
CREATE TABLE `conceptos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaHoraCreacion` datetime NOT NULL,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Genera` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Completo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `TerceroCuentaCobro` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `conceptos_montos`;
CREATE TABLE `conceptos_montos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcepto` int(11) NOT NULL,
  `NombreMonto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Depende` bigint(20) NOT NULL,
  `Operacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorDependencia` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `conceptos_movimientos`;
CREATE TABLE `conceptos_movimientos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcepto` int(11) NOT NULL,
  `idMonto` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoMovimiento` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `configuraciones_nombres_campos`;
CREATE TABLE `configuraciones_nombres_campos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreDB` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Visualiza` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `configuracion_campos_asociados`;
CREATE TABLE `configuracion_campos_asociados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `CampoTablaOrigen` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `TablaAsociada` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `CampoAsociado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `IDCampoAsociado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES
(1,	'empresapro',	'Ciudad',	'cod_municipios_dptos',	'Ciudad',	'Ciudad',	'2019-01-13 14:04:47',	'2019-01-13 09:04:47'),
(2,	'empresapro',	'Regimen',	'empresapro_regimenes',	'Regimen',	'Regimen',	'2019-01-13 14:04:47',	'2019-01-13 09:04:47'),
(3,	'comprobantes_ingreso',	'Clientes_idClientes',	'clientes',	'Num_Identificacion',	'idClientes',	'2019-02-24 19:01:51',	'2019-02-24 14:01:51'),
(4,	'productosventa',	'Departamento',	'prod_departamentos',	'Nombre',	'idDepartamentos',	'2019-02-24 19:01:51',	'2019-02-24 14:01:51'),
(5,	'productosventa',	'Sub1',	'prod_sub1',	'NombreSub1',	'idSub1',	'2019-02-26 22:00:37',	'2019-02-26 17:00:37'),
(6,	'productosventa',	'Sub2',	'prod_sub2',	'NombreSub2',	'idSub2',	'2019-02-26 22:02:42',	'2019-02-26 17:02:42'),
(7,	'productosventa',	'Sub3',	'prod_sub3',	'NombreSub3',	'idSub3',	'2019-02-26 22:02:42',	'2019-02-26 17:02:42'),
(8,	'productosventa',	'Sub4',	'prod_sub4',	'NombreSub4',	'idSub4',	'2019-02-26 22:02:42',	'2019-02-26 17:02:42'),
(9,	'productosventa',	'Sub5',	'prod_sub5',	'NombreSub5',	'idSub5',	'2019-02-26 22:02:42',	'2019-02-26 17:02:42'),
(10,	'productosventa',	'Sub6',	'prod_sub6',	'NombreSub6',	'idSub6',	'2019-02-26 22:02:42',	'2019-02-26 17:02:42'),
(11,	'cotizacionesv5',	'Clientes_idClientes',	'clientes',	'Num_Identificacion',	'idClientes',	'2019-03-02 04:38:29',	'2019-03-01 23:38:29'),
(12,	'clientes',	'Tipo_Documento',	'cod_documentos',	'Descripcion',	'Codigo',	'2019-03-07 16:45:07',	'2019-03-07 11:45:07'),
(13,	'clientes',	'Cod_Dpto',	'cod_departamentos',	'Nombre',	'Cod_dpto',	'2019-03-07 16:45:07',	'2019-03-07 11:45:07'),
(14,	'clientes',	'Cod_Mcipio',	'cod_departamentos',	'Ciudad',	'Cod_mcipio',	'2019-03-07 16:45:07',	'2019-03-07 11:45:07'),
(15,	'clientes',	'Pais_Domicilio',	'cod_paises',	'Pais',	'Codigo',	'2019-03-07 16:45:07',	'2019-03-07 11:45:07');

DROP TABLE IF EXISTS `configuracion_control_tablas`;
CREATE TABLE `configuracion_control_tablas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaDB` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Agregar` int(1) NOT NULL,
  `Editar` int(1) NOT NULL,
  `Ver` int(1) NOT NULL,
  `LinkVer` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Exportar` int(1) NOT NULL,
  `AccionesAdicionales` int(1) NOT NULL,
  `Eliminar` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES
(1,	'empresapro',	1,	1,	0,	'',	1,	0,	0,	'2019-01-13 14:04:48',	'2019-01-13 09:04:48'),
(2,	'formatos_calidad',	1,	1,	0,	'',	1,	0,	0,	'2019-01-13 14:04:48',	'2019-01-13 09:04:48'),
(3,	'facturas',	0,	0,	1,	'PDF_Documentos.draw.php?idDocumento=2&ID=',	1,	1,	0,	'2019-01-13 14:04:48',	'2019-01-13 09:04:48'),
(4,	'cotizacionesv5',	0,	1,	1,	'PDF_Documentos.draw.php?idDocumento=1&ID=',	1,	1,	0,	'2019-03-02 04:38:30',	'2019-03-01 23:38:30'),
(5,	'cot_itemscotizaciones',	0,	1,	0,	'',	1,	0,	0,	'2019-01-13 14:04:48',	'2019-01-13 09:04:48'),
(6,	'empresapro_resoluciones_facturacion',	1,	1,	0,	'',	1,	0,	0,	'2019-01-13 14:04:48',	'2019-01-13 09:04:48'),
(7,	'comprobantes_ingreso',	0,	0,	1,	'PDF_Documentos.draw.php?idDocumento=4&idIngreso=',	1,	1,	0,	'2019-03-02 04:38:30',	'2019-03-01 23:38:30'),
(8,	'clientes',	1,	1,	0,	'',	1,	0,	0,	'2019-03-02 04:38:30',	'2019-03-01 23:38:30'),
(9,	'prestamos_terceros',	0,	0,	1,	'PDF_Documentos.draw.php?idDocumento=35&ID=',	1,	1,	0,	'2019-04-06 19:19:59',	'2019-04-06 14:19:59'),
(10,	'vista_documentos_contables',	0,	0,	1,	'PDF_Documentos.draw.php?idDocumento=32&idDocumentoContable=',	1,	1,	0,	'2019-04-11 14:01:47',	'2019-04-11 09:01:47');

DROP TABLE IF EXISTS `configuracion_general`;
CREATE TABLE `configuracion_general` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(1,	'RUTA PARA EXPORTAR TABLAS EN CSV',	'../../htdocs/ts5/exports/tabla.csv',	'2019-01-13 14:04:49',	'2019-01-13 09:04:49'),
(2,	'Valor por defecto si se imprime o no al momento de realizar una factura pos',	'1',	'2019-03-18 12:44:40',	'2019-03-18 07:44:40'),
(3,	'Determina si se debe pedir autorizacion para retornar un item en pos',	'1',	'2019-03-18 13:20:26',	'2019-03-18 08:20:26'),
(4,	'Determina si se debe pedir autorizacion para elimininar un item en pos',	'1',	'2019-03-18 13:27:46',	'2019-03-18 08:27:46'),
(5,	'Determina si se debe pedir autorizacion para cambiar el precio de venta de un item en pos',	'1',	'2019-03-18 13:33:01',	'2019-03-18 08:33:01'),
(6,	'Determina el valor maximo que se puede aplicar al descuento general',	'50',	'2019-03-18 13:33:01',	'2019-03-18 08:33:01'),
(7,	'Determina si se pueden realizar descuentos a precio de costo',	'0',	'2019-03-18 20:54:51',	'2019-03-18 15:54:51'),
(8,	'Determina cuantas copias saldrán del separado al crearse',	'2',	'2019-03-19 19:19:59',	'2019-03-19 14:19:59'),
(9,	'Determina cuantas copias saldrán del egreso al crearse desde pos',	'2',	'2019-03-19 21:47:01',	'2019-03-19 16:47:01');

DROP TABLE IF EXISTS `configuracion_tablas_acciones_adicionales`;
CREATE TABLE `configuracion_tablas_acciones_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaDB` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `JavaScript` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseIcono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Titulo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Ruta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Target` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_tablas_acciones_adicionales` (`ID`, `TablaDB`, `JavaScript`, `ClaseIcono`, `Titulo`, `Ruta`, `Target`, `Updated`, `Sync`) VALUES
(1,	'facturas',	'',	'fa fa-fw fa-copy',	'Copia',	'../../general/Consultas/PDF_Documentos.draw.php?TipoFactura=COPIA&idDocumento=2&ID=	',	'_BLANK',	'2019-01-13 14:04:49',	'2019-01-13 09:04:49'),
(2,	'facturas',	'',	'fa fa-fw fa-book',	'Contabilidad',	'../../general/Consultas/PDF_Documentos.draw.php?TipoFactura=CONTABILIDAD&idDocumento=2&ID=	',	'_BLANK',	'2019-01-13 14:04:49',	'2019-01-13 09:04:49'),
(3,	'facturas',	'',	'fa fa-fw fa-close',	'Anular',	'../../VAtencion/AnularFactura.php?idFactura=',	'_BLANK',	'2019-01-13 14:04:49',	'2019-01-13 09:04:49'),
(4,	'comprobantes_ingreso',	'',	'fa fa-fw fa-close',	'Anular',	'../../VAtencion/AnularComprobanteIngreso.php?idComprobante=',	'_BLANK',	'2019-03-02 04:38:30',	'2019-03-01 23:38:30'),
(5,	'prestamos_terceros',	'onclick=AbreModalAbonar',	'fa fa-fw fa-plus',	'Abonar',	'#',	'_SELF',	'2019-04-06 19:49:13',	'2019-04-06 14:49:13'),
(6,	'prestamos_terceros',	'onclick=HistorialAbonos',	'fa fa-fw fa-history',	'Historial',	'#',	'_SELF',	'2019-04-07 13:23:24',	'2019-04-07 08:23:24');

DROP TABLE IF EXISTS `config_codigo_barras`;
CREATE TABLE `config_codigo_barras` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TituloEtiqueta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DistaciaEtiqueta1` int(11) NOT NULL,
  `DistaciaEtiqueta2` int(11) NOT NULL,
  `DistaciaEtiqueta3` int(11) NOT NULL,
  `AlturaLinea1` int(11) NOT NULL,
  `AlturaLinea2` int(11) NOT NULL,
  `AlturaLinea3` int(11) NOT NULL,
  `AlturaLinea4` int(11) NOT NULL,
  `AlturaLinea5` int(11) NOT NULL,
  `AlturaCodigoBarras` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `config_codigo_barras` (`ID`, `TituloEtiqueta`, `DistaciaEtiqueta1`, `DistaciaEtiqueta2`, `DistaciaEtiqueta3`, `AlturaLinea1`, `AlturaLinea2`, `AlturaLinea3`, `AlturaLinea4`, `AlturaLinea5`, `AlturaCodigoBarras`, `Updated`, `Sync`) VALUES
(1,	'TRAKI',	10,	280,	560,	1,	20,	40,	60,	120,	30,	'2019-01-13 14:04:45',	'2019-01-13 09:04:45');

DROP TABLE IF EXISTS `config_puertos`;
CREATE TABLE `config_puertos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Puerto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Utilizacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `config_puertos` (`ID`, `Puerto`, `Utilizacion`, `Habilitado`, `Updated`, `Sync`) VALUES
(1,	'COM3',	'IMPRESORA POS EPSON',	'NO',	'2019-01-13 14:04:46',	'2019-01-13 09:04:46'),
(2,	'COM5',	'IMPRESORA CODIGO DE BARRAS',	'SI',	'2019-01-14 21:33:23',	'2019-01-14 16:33:23');

DROP TABLE IF EXISTS `config_tiketes_promocion`;
CREATE TABLE `config_tiketes_promocion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTiket` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tope` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Multiple` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `config_tiketes_promocion` (`ID`, `NombreTiket`, `Tope`, `Multiple`, `Activo`, `Updated`, `Sync`) VALUES
(1,	'PROMOCION DEL MES',	'10000',	'NO',	'NO',	'2019-01-13 14:04:46',	'2019-01-13 09:04:46');

DROP TABLE IF EXISTS `costos`;
CREATE TABLE `costos` (
  `idCostos` int(20) NOT NULL AUTO_INCREMENT,
  `NombreCosto` varchar(45) NOT NULL,
  `ValorCosto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCostos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `costos` (`idCostos`, `NombreCosto`, `ValorCosto`, `Updated`, `Sync`) VALUES
(1,	'participacion ',	2000000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(2,	'Transporte',	240000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(3,	'Publicidad',	100000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(4,	'Arriendo',	1200000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(5,	'Energia',	1400000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(6,	'Telefono',	220000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(7,	'Mano de Obra ',	11531200,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(8,	'Agua',	40000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(9,	'Contador',	230000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(10,	'Aceite Hid.',	8000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(11,	'Aceite Caja ',	13500,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(12,	'Formularios Cont.',	0,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(13,	'Gas',	5500,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(14,	'Oxigeno',	80000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(15,	'Aseo',	10000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(16,	'Cumplea',	11000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(17,	'Dotacion',	125000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(18,	'Anchetas fda',	21000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(19,	'Herramientas',	1800000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(20,	'otros gastos de administracion ',	1200000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(21,	'Gastos Financieros ',	2271420,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(22,	'internet ',	108700,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(23,	'Asistente administrativo ',	1364260,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(24,	'auxiliar contable',	1125930,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(25,	'papeleria ',	200000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(26,	'dsadas',	43243234.5,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50'),
(27,	'ARRIENDO',	50000,	'2019-01-13 14:04:50',	'2019-01-13 09:04:50');

DROP TABLE IF EXISTS `cotizacionesv5`;
CREATE TABLE `cotizacionesv5` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `NumSolicitud` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Seguimiento` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Estado` (`Estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cotizaciones_anexos`;
CREATE TABLE `cotizaciones_anexos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaCreacion` datetime NOT NULL,
  `Titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `NumCotizacion` bigint(20) NOT NULL,
  `Anexo` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cotizaciones_anticipos`;
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


DROP TABLE IF EXISTS `cot_itemscotizaciones`;
CREATE TABLE `cot_itemscotizaciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) NOT NULL DEFAULT '0',
  `NumCotizacion` int(16) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(45) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ValorUnitario` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Descuento` double NOT NULL,
  `ValorDescuento` double NOT NULL,
  `PrecioCosto` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `TipoItem` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `PorcentajeIVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idPorcentajeIVA` int(11) NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `Devuelto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) CHARACTER SET utf8 NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `NumCotizacion` (`NumCotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `crono_controles`;
CREATE TABLE `crono_controles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idSesionConcejo` bigint(20) NOT NULL,
  `idConcejal` bigint(20) NOT NULL,
  `Estado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Inicio` time NOT NULL,
  `Fin` time NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `idPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `GupoCuentas_PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `cuentas` (`idPUC`, `Nombre`, `Valor`, `GupoCuentas_PUC`, `Updated`, `Sync`) VALUES
('1105',	'Caja',	'0',	'11',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1110',	'Bancos',	'0',	'11',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1115',	'Remesas en tr?nsito',	'0',	'11',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1120',	'Cuentas de ahorro',	'0',	'11',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1125',	'Fondos',	'0',	'11',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1205',	'Acciones',	'0',	'12',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1210',	'Cuotas o partes de inter?s social',	'0',	'12',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1215',	'Bonos',	'0',	'12',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1220',	'C?dulas',	'0',	'12',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1225',	'Certificados',	'0',	'12',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1305',	'Clientes',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1310',	'Cuentas corrientes comerciales',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1315',	'Cuentas por cobrar a casa matriz',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1320',	'Cuentas por cobrar a vinculados econ?micos',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1323',	'Cuentas por cobrar a directores',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1325',	'Cuentas por cobrar a socios y accionistas',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1328',	'Aportes por cobrar',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1330',	'Anticipos y avances',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1332',	'Cuentas de operaci?n conjunta',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1335',	'Dep?sitos',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1340',	'Promesas de compra venta',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1345',	'Ingresos por cobrar',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1350',	'Retenci?n sobre contratos',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1355',	'Anticipo de impuestos y contribuciones o sald',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1360',	'Reclamaciones',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1365',	'Cuentas por cobrar a trabajadores',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1370',	'Pr?stamos a particulares',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1380',	'Deudores varios',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1385',	'Derechos de recompra de cartera negociada',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1390',	'Deudas de dif?cil cobro',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1399',	'Provisiones',	'0',	'13',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1405',	'Materias primas',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1410',	'Productos en proceso',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1415',	'Obras de construcci?n en curso',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1417',	'Obras de urbanismo',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1420',	'Contratos en ejecuci',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1425',	'Cultivos en desarrollo',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1428',	'Plantaciones agr?colas',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1430',	'Productos terminados',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1435',	'Mercancias no fabricadas por la empresa',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1440',	'Bienes ra?ces para la venta',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1445',	'Semovientes',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1450',	'Terrenos',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1455',	'Materiales, repuestos y accesorios',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1460',	'Envases y empaques',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1465',	'Inventarios en tr?nsito',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1499',	'Provisiones',	'0',	'14',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1504',	'Terrenos',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1506',	'Materiales proyectos petroleros',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1508',	'Construcciones en curso',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1512',	'Maquinaria y equipos en montaje',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1516',	'Construcciones y edificaciones',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1520',	'Maquinaria y equipo',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1524',	'Equipo de oficina',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1528',	'Equipo de computacion y comunicaci',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1532',	'Equipo m?dico-cient?fico',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1536',	'Equipo de hoteles y restaurantes',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1540',	'Flota y equipo de transporte',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1544',	'Flota y equipo fluvial y/o mar?timo',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1548',	'Flota y equipo a?reo',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1552',	'Flota y equipo f?rreo',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1556',	'Acueductos, plantas y redes',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1560',	'Armamento de vigilancia',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1562',	'Envases y empaques',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1564',	'Plantaciones agr?colas y forestales',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1568',	'V?as de comunicaci',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1572',	'Minas y canteras',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1576',	'Pozos artesianos',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1580',	'Yacimientos',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1584',	'Semovientes',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1588',	'Propiedades, planta y equipo en tr?nsito',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1592',	'Depreciaci?n acumulada',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1596',	'Depreciaci?n diferida',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1597',	'Amortizaci?n acumulada',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1598',	'Agotamiento acumulado',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1599',	'Provisiones',	'0',	'15',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1605',	'Cr?dito mercantil',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1610',	'Marcas',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1615',	'Patentes',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1620',	'Concesiones y franquicias',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1625',	'Derechos',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1630',	'Know how',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1635',	'Licencias',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1698',	'Depreciaci?n y/o amortizaci?n acumulada',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1699',	'Provisiones',	'0',	'16',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1705',	'Gastos pagados por anticipado',	'0',	'17',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1710',	'Cargos diferidos',	'0',	'17',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1715',	'Costos de exploraci?n por amortizar',	'0',	'17',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1720',	'Costos de explotaci?n y desarrollo',	'0',	'17',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1730',	'Cargos por correcci?n monetaria diferida',	'0',	'17',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1798',	'Amortizaci?n acumulada',	'0',	'17',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1805',	'Bienes de arte y cultura',	'0',	'18',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1895',	'Diversos',	'0',	'18',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1899',	'Provisiones',	'0',	'18',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1905',	'De inversiones',	'0',	'19',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1910',	'De propiedades, planta y equipo',	'0',	'19',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('1995',	'De otros activos',	'0',	'19',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2105',	'Bancos nacionales',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2110',	'Bancos del exterior',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2115',	'Corporaciones financieras',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2120',	'Compa??as de financiamiento comercial',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2125',	'Corporaciones de ahorro y vivienda',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2130',	'Entidades financieras del exterior',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2135',	'Compromisos de recompra de inversiones negoci',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2140',	'Compromisos de recompra de cartera negociada',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2145',	'Obligaciones gubernamentales',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2195',	'Otras obligaciones',	'0',	'21',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2205',	'Nacionales',	'0',	'22',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2210',	'Del exterior',	'0',	'22',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2215',	'Cuentas corrientes comerciales',	'0',	'22',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2220',	'Casa matriz',	'0',	'22',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2225',	'Compañias vinculadas',	'0',	'22',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2305',	'Cuentas corrientes comerciales',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2310',	'A casa matriz',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2315',	'A compañias vinculadas',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2320',	'A contratistas',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2330',	'Ordenes de compra por utilizar',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2335',	'Costos y gastos por pagar',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2340',	'Instalamentos por pagar',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2345',	'Acreedores oficiales',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2350',	'Regalias por pagar',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2355',	'Deudas con accionistas o socios',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2357',	'Deudas con directores',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2360',	'Dividendos o participaciones por pagar',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2365',	'Retencion en la fuente',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2367',	'Impuesto a las ventas retenido',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2368',	'Impuesto de industria y comercio retenido',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2370',	'Retenciones y aportes de nomina',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2375',	'Cuotas por devolver',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2380',	'Acreedores varios',	'0',	'23',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2404',	'De renta y complementarios',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2408',	'Impuesto sobre las ventas por pagar',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2412',	'De industria y comercio',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2416',	'A la propiedad raiz',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2420',	'Derechos sobre instrumentos publicos',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2424',	' De valorizacion',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2428',	'De turismo',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2432',	'Tasa por utilizacion de puertos',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2436',	'De vehiculos',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2440',	'De espectaculos publicos',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2444',	'De hidrocarburos y minas',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2448',	'Regalias e impuestos a la pequeña y mediana m',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2452',	'A las exportaciones cafeteras',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2456',	'A las importaciones',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2460',	'Cuotas de fomento',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2464',	'De licores, cervezas y cigarrillos',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2468',	'Al sacrificio de ganado',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2472',	'Al azar y juegos',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2476',	'Gravamenes y regalias por utilizacion del sue',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2495',	'Otros',	'0',	'24',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2505',	'Salarios por pagar',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2510',	'Cesantias consolidadas',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2515',	'Intereses sobre cesantias',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2520',	'Prima de servicios',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2525',	'Vacaciones consolidadas',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2530',	'Prestaciones extralegales',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2532',	'Pensiones por pagar',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2535',	'Cuotas partes pensiones de jubilacion',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2540',	'Indemnizaciones laborales',	'0',	'25',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2605',	'Para costos y gastos',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2610',	'Para obligaciones laborales',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2615',	'Para obligaciones fiscales',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2620',	'Pensiones de jubilacion',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2625',	'Para obras de urbanismo',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2630',	'Para mantenimiento y reparaciones',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2635',	'Para contingencias',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2640',	'Para obligaciones de garantias',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2695',	'Provisiones diversas',	'0',	'26',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2705',	'Ingresos recibidos por anticipado',	'0',	'27',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2710',	'Abonos diferidos',	'0',	'27',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2715',	'Utilidad diferida en ventas a plazos',	'0',	'27',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2720',	'Credito por correccion monetaria diferida',	'0',	'27',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2725',	'Impuestos diferidos',	'0',	'27',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2805',	'Anticipos y avances recibidos',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2810',	'Depositos recibidos',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2815',	'Ingresos recibidos para terceros',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2820',	'Cuentas de operacion conjunta',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2825',	'Retenciones a terceros sobre contratos',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2830',	'Embargos judiciales',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2835',	'Acreedores del sistema',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2840',	'Cuentas en participacion',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2895',	'Diversos',	'0',	'28',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2905',	'Bonos en circulacion',	'0',	'29',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2910',	'Bonos obligatoriamente convertibles en accion',	'0',	'29',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2915',	'Papeles comerciales',	'0',	'29',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2920',	'Bonos pensionales',	'0',	'29',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('2925',	'Titulos pensionales',	'0',	'29',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3105',	'Capital suscrito y pagado',	'0',	'31',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3115',	'Aportes sociales',	'0',	'31',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3120',	'Capital asignado',	'0',	'31',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3125',	'Inversi?n suplementaria al capital asignado',	'0',	'31',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3130',	'Capital de personas naturales',	'0',	'31',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3135',	'Aportes del Estado',	'0',	'31',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3140',	'Fondo social',	'0',	'31',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3205',	'Prima en colocaci?n de acciones, cuotas o par',	'0',	'32',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3210',	'Donaciones',	'0',	'32',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3215',	'Cr?dito mercantil',	'0',	'32',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3220',	'Know how',	'0',	'32',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3225',	'Super?vit m?todo de participaci',	'0',	'32',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3305',	'Reservas obligatorias',	'0',	'33',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3310',	'Reservas estatutarias',	'0',	'33',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3315',	'Reservas ocasionales',	'0',	'33',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3405',	'Ajustes por inflaci',	'0',	'34',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3410',	'Saneamiento fiscal',	'0',	'34',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3415',	'Ajustes por inflaci?n Decreto 3019 de 1989',	'0',	'34',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3505',	'Dividendos decretados en acciones',	'0',	'35',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3510',	'Participaciones decretadas en cuotas o partes',	'0',	'35',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3605',	'Utilidad del ejercicio',	'0',	'36',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3610',	'P?rdida del ejercicio',	'0',	'36',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3705',	'Utilidades acumuladas',	'0',	'37',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3710',	'P?rdidas acumuladas',	'0',	'37',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3805',	'De inversiones',	'0',	'38',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3810',	'De propiedades, planta y equipo',	'0',	'38',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('3895',	'De otros activos',	'0',	'38',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4105',	'Agricultura, ganaderia, caza y silvicultura',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4110',	'Pesca',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4115',	'Explotaci?n de minas y canteras',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4120',	'Industrias manufactureras',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4125',	'Suministro de electricidad, gas y agua',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4130',	'Construcci',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4135',	'Comercio al por mayor y al por menor',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4140',	'Hoteles y restaurantes',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4145',	'Transporte, almacenamiento y comunicaciones',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4150',	'Actividad financiera',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4155',	'Actividades inmobiliarias, empresariales y de',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4160',	'Ense?anza',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4165',	'Servicios sociales y de salud',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4170',	'Otras actividades de servicios comunitarios, ',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4175',	'Devoluciones en ventas (DB)',	'0',	'41',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4205',	'Otras ventas',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4210',	'Financieros',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4215',	'Dividendos y participaciones',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4218',	'Ingresos m?todo de participaci',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4220',	'Arrendamientos',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4225',	'Comisiones',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4230',	'Honorarios',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4235',	'Servicios',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4240',	'Utilidad en venta de inversiones',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4245',	'Utilidad en venta de propiedades, planta y eq',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4248',	'Utilidad en venta de otros bienes',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4250',	'Recuperaciones',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4255',	'Indemnizaciones',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4260',	'Participaciones en concesiones',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4265',	'Ingresos de ejercicios anteriores',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4275',	'Devoluciones en otras ventas (DB)',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4295',	'Diversos',	'0',	'42',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('4705',	'Correcci?n monetaria',	'0',	'47',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5105',	'Gastos de personal',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5110',	'Honorarios',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5115',	'Impuestos',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5120',	'Arrendamientos',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5125',	'Contribuciones y afiliaciones',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5130',	'Seguros',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5135',	'Servicios',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5140',	'Gastos legales',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5145',	'Mantenimiento y reparaciones',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5150',	'Adecuaci?n e instalaci',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5155',	'Gastos de viaje',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5160',	'Depreciaciones',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5165',	'Amortizaciones',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5195',	'Diversos',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5199',	'Provisiones',	'0',	'51',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5205',	'Gastos de personal',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5210',	'Honorarios',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5215',	'Impuestos',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5220',	'Arrendamientos',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5225',	'Contribuciones y afiliaciones',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5230',	'Seguros',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5235',	'Servicios',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5240',	'Gastos legales',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5245',	'Mantenimiento y reparaciones',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5250',	'Adecuaci?n e instalaci',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5255',	'Gastos de viaje',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5260',	'Depreciaciones',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5265',	'Amortizaciones',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5270',	'Financieros-reajuste del sistema',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5275',	'P?rdidas m?todo de participaci',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5295',	'Diversos',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5299',	'Provisiones',	'0',	'52',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5305',	'Financieros',	'0',	'53',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5310',	'P?rdida en venta y retiro de bienes',	'0',	'53',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5313',	'P?rdidas m?todo de participaci',	'0',	'53',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5315',	'Gastos extraordinarios',	'0',	'53',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5395',	'Gastos diversos',	'0',	'53',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5405',	'Impuesto de renta y complementarios',	'0',	'54',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('5905',	'Ganancias y p?rdidas',	'0',	'59',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6105',	'Agricultura, ganader?a, caza y silvicultura',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6110',	'Pesca',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6115',	'Explotaci?n de minas y canteras',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6120',	'Industrias manufactureras',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6125',	'Suministro de electricidad, gas y agua',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6130',	'Construcci',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6135',	'Comercio al por mayor y al por menor',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6140',	'Hoteles y restaurantes',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6145',	'Transporte, almacenamiento y comunicaciones',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6150',	'Actividad financiera',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6155',	'Actividades inmobiliarias, empresariales y de',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6160',	'Ense?anza',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6165',	'Servicios sociales y de salud',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6170',	'Otras actividades de servicios comunitarios, ',	'0',	'61',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6205',	'De mercanc?as',	'0',	'62',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6210',	'De materias primas',	'0',	'62',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6215',	'De materiales indirectos',	'0',	'62',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6220',	'Compra de energ',	'0',	'62',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('6225',	'Devoluciones en compras (CR)',	'0',	'62',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('7101',	'Materia Prima',	NULL,	'71',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('7201',	'Mano de Obra Directa',	NULL,	'72',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('7301',	'Costos Indirectos',	NULL,	'73',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('7401',	'Contratos de Servicios',	NULL,	'74',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8105',	'Bienes y valores entregados en custodia',	'0',	'81',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8110',	'Bienes y valores entregados en garant',	'0',	'81',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8115',	'Bienes y valores en poder de terceros',	'0',	'81',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8120',	'Litigios y/o demandas',	'0',	'81',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8125',	'Promesas de compraventa',	'0',	'81',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8195',	'Diversas',	'0',	'81',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8305',	'Bienes recibidos en arrendamiento financiero',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8310',	'T?tulos de inversi?n no colocados',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8315',	'Propiedades, planta y equipo totalmente depre',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8320',	'Cr?ditos a favor no utilizados',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8325',	'Activos castigados',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8330',	'T?tulos de inversi?n amortizados',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8335',	'Capitalizaci?n por revalorizaci?n de patrimon',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8395',	'Otras cuentas deudoras de control',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('8399',	'Ajustes por inflaci?n activos',	'0',	'83',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9105',	'10Bienes muebles',	'0',	'91',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9110',	'Bienes y valores recibidos en garant',	'0',	'91',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9115',	'Bienes y valores recibidos de terceros',	'0',	'91',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9120',	'Litigios y/o demandas',	'0',	'91',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9125',	'Promesas de compraventa',	'0',	'91',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9130',	'Contratos de administraci?n delegada',	'0',	'91',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9135',	'Cuentas en participaci',	'0',	'91',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9195',	'Otras responsabilidades contingentes',	'0',	'91',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9305',	'Contratos de arrendamiento financiero',	'0',	'93',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9395',	'Otras cuentas de orden acreedoras de control',	'0',	'93',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52'),
('9399',	'Ajustes por inflaci?n patrimonio',	'0',	'93',	'2019-01-13 14:04:52',	'2019-01-13 09:04:52');

DROP TABLE IF EXISTS `cuentasfrecuentes`;
CREATE TABLE `cuentasfrecuentes` (
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsoFuturo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `cuentasfrecuentes` (`CuentaPUC`, `Nombre`, `ClaseCuenta`, `UsoFuturo`, `Updated`, `Sync`) VALUES
('110505',	'CAJA GENERAL',	'ACTIVOS',	'',	'2019-01-13 14:04:53',	'2019-01-13 09:04:53'),
('11051001',	'CAJA MENOR CAJA 1',	'ACTIVOS',	'',	'2019-01-13 14:04:53',	'2019-01-13 09:04:53'),
('11051002',	'CAJA MENOR CAJA 2',	'ACTIVOS',	'',	'2019-01-13 14:04:53',	'2019-01-13 09:04:53'),
('11100501',	'CUENTA DE AHORROS DAVIVIENDA',	'ACTIVOS',	'_',	'2019-01-13 14:04:53',	'2019-01-13 09:04:53'),
('523505',	'Aseo y vigilacia',	'EGRESOS',	'',	'2019-01-13 14:04:53',	'2019-01-13 09:04:53');

DROP TABLE IF EXISTS `cuentasxpagar`;
CREATE TABLE `cuentasxpagar` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `DocumentoReferencia` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `FechaProgramada` date NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Retenciones` double NOT NULL,
  `Total` double NOT NULL,
  `Abonos` double NOT NULL,
  `Saldo` double NOT NULL,
  `idProveedor` bigint(20) NOT NULL,
  `RazonSocial` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaBancaria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `A_Nombre_De` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TipoCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EntidadBancaria` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idCentroCostos` int(11) NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DocumentoCruce` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT '220505',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cuentasxpagar_abonos`;
CREATE TABLE `cuentasxpagar_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idCuentaXPagar` text COLLATE utf8_spanish_ci NOT NULL,
  `Monto` double NOT NULL,
  `idUsuarios` bigint(20) NOT NULL,
  `idComprobanteEgreso` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cuentas_frecuentes`;
CREATE TABLE `cuentas_frecuentes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Tercero` bigint(20) NOT NULL,
  `idCotizacion` bigint(20) NOT NULL,
  `DiaCobro` int(11) NOT NULL,
  `UltimoPago` date NOT NULL,
  `TotalCuotas` int(11) NOT NULL,
  `CuotasPagas` int(11) NOT NULL,
  `CuotasFaltantes` int(11) NOT NULL,
  `Estado` enum('A','I') COLLATE utf8_spanish_ci NOT NULL,
  `MesPago` enum('S','N') COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `devolucionesventas`;
CREATE TABLE `devolucionesventas` (
  `idComprasDevoluciones` int(11) NOT NULL AUTO_INCREMENT,
  `NumVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `EfectivoDevuelto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComprasDevoluciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
(1,	'CC-1',	'AJUSTE CONTABLE',	'Documento para generar ajustes a la contabilidad',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(2,	'CC-2',	'MOVIMIENTO DE CUENTAS',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(3,	'CC-3',	'COSTEO',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(4,	'CC-4',	'DIFERIDOS',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(5,	'CC-5',	'LEGALIZACION DE VIATICOS',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(6,	'CC-6',	'LEGALIZACION DE CAJAS MENORES',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(7,	'CC-7',	'OBLIGACIONES FINANCIERAS',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(8,	'CC-8',	'NOMINA',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(9,	'CC-9',	'CIERRE CONTABLE',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(10,	'CC-10',	'SALDOS INICIALES',	'',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47'),
(11,	'CC-11',	'DEPRECIACION',	'Para realizar depreciacion a los activos',	'2019-04-11 14:01:47',	'2019-04-11 09:01:47');

DROP TABLE IF EXISTS `documentos_contables_control`;
CREATE TABLE `documentos_contables_control` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(11) NOT NULL,
  `Consecutivo` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `idCentroCostos` int(11) NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Consecutivo` (`Consecutivo`),
  KEY `idDocumento` (`idDocumento`),
  KEY `idEmpresa` (`idEmpresa`),
  KEY `idSucursal` (`idSucursal`),
  KEY `idCentroCostos` (`idCentroCostos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `documentos_contables_items`;
CREATE TABLE `documentos_contables_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `documentos_contables_items_temp`;
CREATE TABLE `documentos_contables_items_temp` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(11) NOT NULL,
  `Nombre_Documento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Numero_Documento` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `documentos_generados`;
CREATE TABLE `documentos_generados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Abreviatura` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `Libro` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Abreviatura` (`Abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `documento_equivalente`;
CREATE TABLE `documento_equivalente` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Estado` enum('AB','CE') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'AB' COMMENT 'AB abierto,CE Cerrado',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `documento_equivalente_items`;
CREATE TABLE `documento_equivalente_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Total` double NOT NULL,
  `idDocumento` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `egresos`;
CREATE TABLE `egresos` (
  `idEgresos` int(45) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) NOT NULL,
  `PagoProg` varchar(10) NOT NULL,
  `FechaPagoPro` varchar(20) NOT NULL,
  `FechaPago` varchar(20) NOT NULL,
  `Concepto` varchar(300) NOT NULL,
  `TipoEgreso` varchar(45) NOT NULL,
  `ServicioPago` varchar(45) NOT NULL,
  `Beneficiario` varchar(45) NOT NULL,
  `NIT` varchar(45) NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `Ciudad` varchar(45) NOT NULL,
  `Subtotal` varchar(45) NOT NULL,
  `IVA` varchar(45) NOT NULL,
  `Valor` varchar(45) NOT NULL,
  `Retenciones` varchar(45) NOT NULL,
  `NumFactura` varchar(45) NOT NULL,
  `idProveedor` varchar(45) NOT NULL,
  `Cuenta` varchar(45) NOT NULL,
  `Soporte` text NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  `CerradoDiario` varchar(3) NOT NULL,
  `FechaCierreDiario` varchar(45) NOT NULL,
  `HoraCierreDiario` varchar(45) NOT NULL,
  `UsuarioCierreDiario` varchar(45) NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEgresos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `egresos_activos`;
CREATE TABLE `egresos_activos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `Cuentas_idCuentas` int(11) NOT NULL,
  `Visible` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `egresos_anulaciones`;
CREATE TABLE `egresos_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteEgreso` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `egresos_items`;
CREATE TABLE `egresos_items` (
  `ID` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaDestino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero` int(11) NOT NULL,
  `Debito` int(11) NOT NULL,
  `Credito` int(11) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `TipoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaProgramada` date NOT NULL,
  `NumeroComprobante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `egresos_pre`;
CREATE TABLE `egresos_pre` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCuentaXPagar` bigint(20) NOT NULL,
  `Abono` double NOT NULL,
  `Descuento` double NOT NULL,
  `CruceNota` double NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `egresos_tipo`;
CREATE TABLE `egresos_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Cuentas_idCuentas` int(11) NOT NULL,
  `Visible` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `egresos_tipo` (`id`, `Nombre`, `Cuentas_idCuentas`, `Visible`, `Updated`, `Sync`) VALUES
(1,	'Gastos de Personal',	5105,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(2,	'Honorarios',	5110,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(3,	'Impuestos',	5115,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(4,	'Arrendamientos',	5120,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(5,	'Seguros',	5130,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(6,	'Servicios',	5135,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(7,	'Gastos Legales',	5140,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(8,	'Mantenimiento y Reparaciones',	5145,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(9,	'Adecuacion e instalacion',	5150,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(10,	'Gastos de Viaje',	5155,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(11,	'Diversos',	5195,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(12,	'Costos',	71,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(50,	'Mercancias no fabricadas por la empresa',	1435,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(51,	'Equipo Medico Cientifico',	1532,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(52,	'Equipos de Oficina',	1524,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(53,	'Equipos de Computacion y Comunicacion',	1528,	1,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54');

DROP TABLE IF EXISTS `empresapro`;
CREATE TABLE `empresapro` (
  `idEmpresaPro` int(11) NOT NULL AUTO_INCREMENT,
  `RazonSocial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NIT` bigint(20) DEFAULT NULL,
  `DigitoVerificacion` int(1) NOT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Barrio` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Celular` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ResolucionDian` text COLLATE utf8_spanish_ci NOT NULL,
  `Regimen` enum('SIMPLIFICADO','COMUN') COLLATE utf8_spanish_ci DEFAULT 'SIMPLIFICADO',
  `TipoPersona` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT '1 Persona jurica, 2 persona natural,3 grandes contribuyentes',
  `TipoDocumento` int(11) NOT NULL,
  `MatriculoMercantil` bigint(20) NOT NULL,
  `ActividadesEconomicas` text COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `WEB` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ObservacionesLegales` text COLLATE utf8_spanish_ci NOT NULL,
  `PuntoEquilibrio` bigint(20) DEFAULT NULL,
  `DatosBancarios` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaImagen` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'LogosEmpresas/logotipo1.png',
  `FacturaSinInventario` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CXPAutomaticas` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEmpresaPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `empresapro` (`idEmpresaPro`, `RazonSocial`, `NIT`, `DigitoVerificacion`, `Direccion`, `Barrio`, `Telefono`, `Celular`, `Ciudad`, `ResolucionDian`, `Regimen`, `TipoPersona`, `TipoDocumento`, `MatriculoMercantil`, `ActividadesEconomicas`, `Email`, `WEB`, `ObservacionesLegales`, `PuntoEquilibrio`, `DatosBancarios`, `RutaImagen`, `FacturaSinInventario`, `CXPAutomaticas`, `Updated`, `Sync`) VALUES
(1,	'Ftech Colombia SAS',	901143311,	1,	'AvPoblado Cra 43 A 19 17',	'MEDELLIN',	'3177740609',	'3177740609',	'MEDELLIN',	'IVA REGIMEN COMUN ACTIVIDAD ECONOMICA CIIU 8020',	'COMUN',	'3',	31,	1234567,	'O-42;O-42',	'info@technosoluciones.com',	'www.technosoluciones.com',	'Esta Factura de Venta se asimila en todos sus efectos a una letra de cambio (Art. 621 y siguientes del Codigo de Comercio). En caso de mora se causaran los intereses legales Vigentes.',	5000000,	'_',	'LogosEmpresas/logotipo1.png',	'SI',	'SI',	'2019-01-13 14:04:55',	'2019-01-13 09:04:55');

DROP TABLE IF EXISTS `empresapro_regimenes`;
CREATE TABLE `empresapro_regimenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Regimen` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `empresapro_regimenes` (`ID`, `Regimen`, `Updated`, `Sync`) VALUES
(1,	'COMUN',	'2019-01-13 14:04:55',	'2019-01-13 09:04:55'),
(2,	'SIMPLIFICADO',	'2019-01-13 14:04:55',	'2019-01-13 09:04:55');

DROP TABLE IF EXISTS `empresapro_resoluciones_facturacion`;
CREATE TABLE `empresapro_resoluciones_facturacion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreInterno` text COLLATE utf8_spanish_ci NOT NULL,
  `NumResolucion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `NumSolicitud` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `Factura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Prefijo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Desde` int(16) NOT NULL,
  `Hasta` int(16) NOT NULL,
  `FechaVencimiento` date NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL COMMENT 'OC: Ocupada',
  `Completada` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `empresapro_resoluciones_facturacion` (`ID`, `NombreInterno`, `NumResolucion`, `Fecha`, `NumSolicitud`, `Tipo`, `Factura`, `Prefijo`, `Desde`, `Hasta`, `FechaVencimiento`, `idEmpresaPro`, `Estado`, `Completada`, `Updated`, `Sync`) VALUES
(1,	'Facturas por computador',	'150000055430',	'2015-03-26',	'242',	'02',	'Computador',	'A',	1,	300000000,	'2017-03-26',	1,	'',	'NO',	'2019-03-07 16:45:11',	'2019-03-07 11:45:11'),
(2,	'Facturas por POS',	'1555431',	'2016-03-28',	'248',	'03',	'POS',	'B',	1001,	2000,	'2017-03-27',	1,	'',	'SI',	'2019-03-02 04:39:56',	'2019-03-01 23:39:56'),
(3,	'Factura pruebas electronica',	'9000000123973223',	'2018-01-11',	'248',	'03',	'FE',	'PRUE',	980000000,	985000000,	'2028-01-11',	1,	'',	'NO',	'2019-04-09 17:14:46',	'2019-04-09 12:14:46');

DROP TABLE IF EXISTS `empresa_pro_sucursales`;
CREATE TABLE `empresa_pro_sucursales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Visible` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Actual` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `idServidor` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `empresa_pro_sucursales` (`ID`, `Nombre`, `Ciudad`, `Direccion`, `idEmpresaPro`, `Visible`, `Actual`, `idServidor`, `Updated`, `Sync`) VALUES
(1,	'TECHNO YOTOCO',	'YOTOCO',	'',	1,	'SI',	'1',	0,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(2,	'TECHNO BUGA',	'BUGA',	'',	1,	'SI',	'0',	3,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(3,	'TECHNO GINEBRA',	'GINEBRA',	'',	1,	'SI',	'0',	0,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54'),
(4,	'TECHNO SAN PEDRO',	'SAN PEDRO',	'',	1,	'SI',	'0',	0,	'2019-01-13 14:04:54',	'2019-01-13 09:04:54');

DROP TABLE IF EXISTS `estadosfinancieros_mayor_temporal`;
CREATE TABLE `estadosfinancieros_mayor_temporal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaCorte` date NOT NULL,
  `Clase` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `SaldoAnterior` double NOT NULL,
  `Neto` double NOT NULL,
  `SaldoFinal` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `color` varchar(7) DEFAULT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `facturas`;
CREATE TABLE `facturas` (
  `idFacturas` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idResolucion` int(11) NOT NULL,
  `TipoFactura` varchar(10) NOT NULL,
  `Prefijo` varchar(45) NOT NULL,
  `NumeroFactura` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) NOT NULL,
  `OCompra` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `OSalida` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Descuentos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Total` double NOT NULL,
  `SaldoFact` double NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro_idEmpresaPro` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `TotalCostos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` bigint(20) NOT NULL,
  `FechaCierreDiario` date NOT NULL,
  `HoraCierreDiario` time NOT NULL,
  `ObservacionesFact` text NOT NULL,
  `Efectivo` double NOT NULL,
  `Devuelve` double NOT NULL,
  `Cheques` double NOT NULL,
  `Otros` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `idTarjetas` int(11) NOT NULL,
  `ReporteFacturaElectronica` int(1) NOT NULL COMMENT 'indica si ya fue reportada como factura electronica',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`),
  KEY `ReporteFacturaElectronica` (`ReporteFacturaElectronica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DELIMITER ;;

CREATE TRIGGER `InsertFacturaOri` AFTER INSERT ON `facturas` FOR EACH ROW
BEGIN

INSERT INTO ori_facturas SELECT * FROM facturas WHERE idFacturas=New.idFacturas;


END;;

CREATE TRIGGER `Actualiza_OriFacturas` AFTER UPDATE ON `facturas` FOR EACH ROW
BEGIN

REPLACE INTO ori_facturas SELECT * FROM facturas WHERE idFacturas=New.idFacturas;


END;;

DELIMITER ;

DROP TABLE IF EXISTS `facturas_abonos`;
CREATE TABLE `facturas_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `TipoPagoAbono` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Facturas_idFacturas` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteIngreso` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_anticipos`;
CREATE TABLE `facturas_anticipos` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `CuentaIngreso` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_autoretenciones`;
CREATE TABLE `facturas_autoretenciones` (
  `idFacturasAutoretenciones` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreAutoRetencion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Monto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Paga` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `FechaPago` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Soportes_idSoportes` int(11) DEFAULT NULL,
  `Facturas_idFacturas` int(11) DEFAULT NULL,
  `idImpRet` int(11) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturasAutoretenciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_electronicas`;
CREATE TABLE `facturas_electronicas` (
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `XmlFiscal` text COLLATE utf8_spanish_ci NOT NULL,
  `NumeroDocumento` text COLLATE utf8_spanish_ci NOT NULL,
  `idDocumento` text COLLATE utf8_spanish_ci NOT NULL,
  `EstadoCUFE` text COLLATE utf8_spanish_ci NOT NULL,
  `CUFE` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_electronicas_contador`;
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


DROP TABLE IF EXISTS `facturas_formapago`;
CREATE TABLE `facturas_formapago` (
  `idFacturas_FormaPago` int(16) NOT NULL AUTO_INCREMENT,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Paga` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Devuelve` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas_FormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_frecuentes`;
CREATE TABLE `facturas_frecuentes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCliente` bigint(20) NOT NULL,
  `Periodo` int(11) NOT NULL,
  `FacturaBase` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UltimaFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `FacturaBase` (`FacturaBase`),
  KEY `UltimaFactura` (`UltimaFactura`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_frecuentes_items_adicionales`;
CREATE TABLE `facturas_frecuentes_items_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idTablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idItem` bigint(20) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Cantidad` double NOT NULL,
  `idFacturaFrecuente` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_intereses_sistecredito`;
CREATE TABLE `facturas_intereses_sistecredito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_items`;
CREATE TABLE `facturas_items` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TablaItems` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Dias` double NOT NULL,
  `SubtotalItem` double NOT NULL,
  `IVAItem` double NOT NULL,
  `ValorOtrosImpuestos` double NOT NULL,
  `TotalItem` double NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `idOtrosImpuestos` int(11) NOT NULL,
  `idPorcentajeIVA` int(11) NOT NULL,
  `PrecioCostoUnitario` double NOT NULL,
  `SubtotalCosto` double NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`),
  KEY `idCierre` (`idCierre`),
  KEY `FechaFactura` (`FechaFactura`),
  KEY `Referencia` (`Referencia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DELIMITER ;;

CREATE TRIGGER `InsertFacturasItems` AFTER INSERT ON `facturas_items` FOR EACH ROW
BEGIN

INSERT INTO ori_facturas_items SELECT * FROM facturas_items WHERE ID=New.ID;

END;;

DELIMITER ;

DROP TABLE IF EXISTS `facturas_kardex`;
CREATE TABLE `facturas_kardex` (
  `idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaDestino` bigint(20) NOT NULL,
  `Kardex` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_pre`;
CREATE TABLE `facturas_pre` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TablaItems` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Dias` double NOT NULL,
  `SubtotalItem` double NOT NULL,
  `IVAItem` double NOT NULL,
  `TotalItem` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `PrecioCostoUnitario` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `TipoItem` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_reten_aplicadas`;
CREATE TABLE `facturas_reten_aplicadas` (
  `idFacturasRetAplicadas` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreRetencion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Monto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cruzada` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `FechaCruce` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Soportes_idSoportes` int(11) DEFAULT NULL,
  `Facturas_idFacturas` int(11) DEFAULT NULL,
  `idImpRet` int(11) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturasRetAplicadas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `ActualizaSaldoFact` AFTER INSERT ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=NEW.Facturas_idFacturas;

SET @Saldo=@SaldoAnt-NEW.Monto;

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=NEW.Facturas_idFacturas;


END;;

CREATE TRIGGER `ActualizaSaldoFactUpdate` AFTER UPDATE ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=NEW.Facturas_idFacturas;

SET @Saldo=@SaldoAnt+(OLD.Monto-NEW.Monto);

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=NEW.Facturas_idFacturas;


END;;

CREATE TRIGGER `ActualizaSaldoFactDel` BEFORE DELETE ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=OLD.Facturas_idFacturas;

SET @Saldo=@SaldoAnt+OLD.Monto;

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=OLD.Facturas_idFacturas;


END;;

DELIMITER ;

DROP TABLE IF EXISTS `facturas_tipo_pago`;
CREATE TABLE `facturas_tipo_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Leyenda` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `facturas_tipo_pago` (`ID`, `TipoPago`, `Leyenda`, `Updated`, `Sync`) VALUES
(1,	'Contado',	'Contado',	'2019-01-13 14:10:59',	'2019-01-13 09:10:59'),
(2,	'15',	'Credito a 15 dias',	'2019-01-13 14:10:59',	'2019-01-13 09:10:59'),
(3,	'30',	'Credito a 30 dias',	'2019-01-13 14:10:59',	'2019-01-13 09:10:59'),
(4,	'60',	'Credito a 60 dias',	'2019-01-13 14:10:59',	'2019-01-13 09:10:59'),
(5,	'90',	'Credito a 90 dias',	'2019-01-13 14:10:59',	'2019-01-13 09:10:59'),
(6,	'SisteCredito',	'SisteCredito',	'2019-01-13 14:10:59',	'2019-01-13 09:10:59');

DROP TABLE IF EXISTS `factura_compra`;
CREATE TABLE `factura_compra` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `NumeroFactura` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `TipoCompra` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `TipoPago` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idEmpresa` int(11) NOT NULL DEFAULT '1',
  `idCentroCostos` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `factura_compra_anulaciones`;
CREATE TABLE `factura_compra_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idCompra` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `factura_compra_descuentos`;
CREATE TABLE `factura_compra_descuentos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUCDescuento` bigint(20) NOT NULL,
  `NombreCuentaDescuento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `PorcentajeDescuento` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `factura_compra_impuestos_adicionales`;
CREATE TABLE `factura_compra_impuestos_adicionales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Porcentaje` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `factura_compra_insumos`;
CREATE TABLE `factura_compra_insumos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoUnitarioCompra` double NOT NULL,
  `SubtotalCompra` double NOT NULL,
  `ImpuestoCompra` double NOT NULL,
  `TotalCompra` double NOT NULL,
  `Tipo_Impuesto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ProcentajeDescuento` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `SubtotalDescuento` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFacturaCompra` (`idFacturaCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `factura_compra_items`;
CREATE TABLE `factura_compra_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoUnitarioCompra` double NOT NULL,
  `SubtotalCompra` double NOT NULL,
  `ImpuestoCompra` double NOT NULL,
  `TotalCompra` double NOT NULL,
  `Tipo_Impuesto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ProcentajeDescuento` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `SubtotalDescuento` double NOT NULL,
  `PrecioVenta` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFacturaCompra` (`idFacturaCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `factura_compra_items_devoluciones`;
CREATE TABLE `factura_compra_items_devoluciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idNotaDevolucion` bigint(20) NOT NULL,
  `idFacturaCompra` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoUnitarioCompra` double NOT NULL,
  `SubtotalCompra` double NOT NULL,
  `ImpuestoCompra` double NOT NULL,
  `TotalCompra` double NOT NULL,
  `Tipo_Impuesto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `factura_compra_notas_devolucion`;
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


DROP TABLE IF EXISTS `factura_compra_retenciones`;
CREATE TABLE `factura_compra_retenciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `ValorRetencion` double NOT NULL,
  `PorcentajeRetenido` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `factura_compra_servicios`;
CREATE TABLE `factura_compra_servicios` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `CuentaPUC_Servicio` bigint(20) NOT NULL,
  `Nombre_Cuenta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto_Servicio` text COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal_Servicio` double NOT NULL,
  `Impuesto_Servicio` double NOT NULL,
  `Total_Servicio` double NOT NULL,
  `Tipo_Impuesto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `fechas_descuentos`;
CREATE TABLE `fechas_descuentos` (
  `idFechaDescuentos` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Motivo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFechaDescuentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `fe_webservice`;
CREATE TABLE `fe_webservice` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DireccionWebService` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `User` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Pass` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `formatos_calidad`;
CREATE TABLE `formatos_calidad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Version` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `CuerpoFormato` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `NotasPiePagina` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES
(1,	'PROPUESTA ECONOMICA',	'002',	'F-GA-015',	'2016-05-11',	'',	'Esta Propuesta tiene 15 dias de Vigencia',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(2,	'FACTURA DE VENTA',	'001',	'F-GA-013',	'2016-05-11',	'',	'***GRACIAS POR SU COMPRA***; Los productos en promocion no tienen Cambio',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(3,	'CONTROL DE MANTENIMIENTO',	'001',	'F-GO-001',	'2016-05-11',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(4,	'COMPROBANTE DE INGRESO',	'001',	'F-GA-016',	'2016-05-11',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(5,	'ORDEN DE COMPRA',	'001',	'F-GA-006',	'2016-05-11',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(6,	'ORDEN DE SERVICIO',	'001',	'F-GA-014',	'2016-05-11',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(7,	'REMISION',	'001',	'F-GA-012',	'2016-05-11',	'',	'Certifico que los equipos o mercancia entregada se recibio completa y en buen estado y me hago totalmente responsable del buen uso que se le de, asi mismo a pagar los faltantes que se produzcan.',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(8,	'SEGUIMIENTO COTIZACIONES',	'001',	'F-GC-001',	'2016-05-11',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(9,	'COMPROBANTE DE AJUSTE DE REMISION',	'001',	'F-GA-030',	'2016-06-06',	'',	'Los elementos o articulos faltantes se cobraran por su valor en el comercio.',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(10,	'NOTA DE CONTABILIDAD',	'001',	'F-GC-031',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(11,	'COMPROBANTE DE EGRESO',	'001',	'F-GC-032',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(12,	'COMPROBANTE DE CONTABILIDAD',	'001',	'F-GC-033',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(13,	'NOTA CREDITO',	'001',	'F-GC-034',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(14,	'INFORME DE MOVIMIENTO DE CUENTAS',	'001',	'F-GC-035',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(15,	'ESTADOS FINANCIEROS',	'001',	'F-GC-036',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(16,	'INFORME GENERAL DE VENTAS',	'001',	'F-GC-037',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(17,	'COMPROBANTE DE TRASLADO',	'001',	'F-GI-038',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(18,	'ACTA DE ENTREGA DE TITULOS',	'001',	'F-GI-040',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(19,	'AUXILIAR DETALLADO',	'001',	'F-GI-041',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(20,	'BALANCE COMPROBACION',	'001',	'F-GC-050',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(21,	'DATOS EXPORTADOS EN PDF',	'001',	'F-GC-051',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(22,	'TRASLADO DE TITULO',	'001',	'F-GC-052',	'2016-06-06',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(23,	'FACTURA DE COMPRA',	'001',	'F-GC-002',	'2016-05-11',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(24,	'INFORME FISCAL DE IVA',	'001',	'F-GF-005',	'2017-08-09',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(25,	'COMPROBANTE DE BAJAS O ALTAS',	'001',	'F-GI-006',	'2017-08-09',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(26,	'ESTADO DE RESULTADO INTEGRAL',	'001',	'F-GF-002',	'2017-08-09',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(27,	'COBRO PREJURIDICO 1',	'001',	'F-GSL-001',	'2018-01-02',	'<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Fundamento Legal</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: </span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>C&oacute;digo de Comercio</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: Arts. 864, 850, 851, 852, 853 y 884</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>C&oacute;digo Civil</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: Arts. 1602, 1603, 1604, 1608 n&uacute;m. 1&ordm; y 2&ordm;, 1609, 1610 n&uacute;m. 3&ordm;, 1615, 1616, 1617 y 2232.</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Conocedores de lo importante que representa para usted, su imagen crediticia y de lo que conlleva a un mejoramiento continuo en cuanto a las relaciones comerciales se refiere, nuestra Instituci&oacute;n lo invita a presentarse a la Central de Cartera ubicado en la Direcci&oacute;n: Carrera 4 N&deg; 0-93 Edificio Panorama-Popay&aacute;n Cauca, para dar cumplimiento oportuno a su compromiso comercial que se encuentra vencido; la cual se dar&aacute; aplicaci&oacute;n de car&aacute;cter supletorio con fundamento en las normas Comercial y Civil. En caso contrario le invitamos a comunicarse al tel&eacute;fono <strong>3146873552</strong>, para que reporte dentro del mes su respectiva fecha de pago, o en su defecto a las siguiente ruta electr&oacute;nica: </span></span><a href=mailto:carteraguapi2016@gmail style=color:blue; text-decoration:underline><strong><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>carteraguapi2016@gmail</span></span></span></strong></a><strong><u><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>.com</span></span></span></u></strong><u> </u><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>incumplimiento de la obligaci&oacute;n de pagar por la prestaci&oacute;n del servicio de la Empresa Social del Estado HOSPITAL GUAPI puede acarrear la imposici&oacute;n de la sanci&oacute;n prevista en la ley, consistente en el pago, recordando que </span></span></span><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;><span style=color:black>no hay raz&oacute;n alguna que haga inconstitucional la aplicaci&oacute;n de dicha sanci&oacute;n pues se trata de una consecuencia que deviene del incumplimiento de la obligaci&oacute;n de pagar una suma de dinero.</span></span></span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;><span style=color:black>La Sentencia C-389 de 2002, proferida por la Honorable Corte Constitucional en aparte jurisprudencial se desprende que el cobro de intereses de mora es facultativo y no obligatorio. En efecto, el legislador utiliz&oacute; el verbo&nbsp;<strong><u>podr&aacute;n</u></strong>, dejando a la empresa prestataria del servicio <strong><u>la facultad</u>&nbsp;</strong>de cobrarlos, rebajarlos o exonerarlos o hacer convenios con los deudores.</span></span></span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>De otra parte, le informo que la Empresa Social del Estado HOSPITAL GUAPI, se encuentra vinculada al programa de Centrales de Riesgo DATACREDITO y CIFIN, reportando el comportamiento de pago de la obligaci&oacute;n en menci&oacute;n.</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Si&nbsp;ya&nbsp;cancelo&nbsp;por&nbsp;favor&nbsp;haga&nbsp;caso&nbsp;omiso&nbsp;a&nbsp;esta&nbsp;comunicaci&oacute;n, sin otro en particular&nbsp;</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Cordialmente,</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>JOHN DIRLEY MORALES</span></span></strong></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Jefe de Cartera </span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Empresa Social del Estado HOSPITAL GUAPI</span></span></span></span></p>\r\n',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(28,	'COBRO PREJURIDICO 2',	'001',	'F-GSL-002',	'2018-01-02',	'<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Fundamento Legal</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: </span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>C&oacute;digo de Comercio</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: Arts. 864, 850, 851, 852, 853 y 884</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>C&oacute;digo Civil</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: Arts. 1602, 1603, 1604, 1608 n&uacute;m. 1&ordm; y 2&ordm;, 1609, 1610 n&uacute;m. 3&ordm;, 1615, 1616, 1617 y 2232.</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Conocedores de lo importante que representa para usted, su imagen crediticia y de lo que conlleva a un mejoramiento continuo en cuanto a las relaciones comerciales se refiere, nuestra Instituci&oacute;n lo invita a presentarse a la Central de Cartera ubicado en la Direcci&oacute;n: Carrera 4 N&deg; 0-93 Edificio Panorama-Popay&aacute;n Cauca, para dar cumplimiento oportuno a su compromiso comercial que se encuentra vencido; la cual se dar&aacute; aplicaci&oacute;n de car&aacute;cter supletorio con fundamento en las normas Comercial y Civil. En caso contrario le invitamos a comunicarse al tel&eacute;fono <strong>3146873552</strong>, para que reporte dentro del mes su respectiva fecha de pago, o en su defecto a las siguiente ruta electr&oacute;nica: </span></span><a href=mailto:carteraguapi2016@gmail style=color:blue; text-decoration:underline><strong><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>carteraguapi2016@gmail</span></span></span></strong></a><strong><u><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>.com</span></span></span></u></strong><u> </u><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>incumplimiento de la obligaci&oacute;n de pagar por la prestaci&oacute;n del servicio de la Empresa Social del Estado HOSPITAL GUAPI puede acarrear la imposici&oacute;n de la sanci&oacute;n prevista en la ley, consistente en el pago, recordando que </span></span></span><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;><span style=color:black>no hay raz&oacute;n alguna que haga inconstitucional la aplicaci&oacute;n de dicha sanci&oacute;n pues se trata de una consecuencia que deviene del incumplimiento de la obligaci&oacute;n de pagar una suma de dinero.</span></span></span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=background-color:white><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;><span style=color:black>La Sentencia C-389 de 2002, proferida por la Honorable Corte Constitucional en aparte jurisprudencial se desprende que el cobro de intereses de mora es facultativo y no obligatorio. En efecto, el legislador utiliz&oacute; el verbo&nbsp;<strong><u>podr&aacute;n</u></strong>, dejando a la empresa prestataria del servicio <strong><u>la facultad</u>&nbsp;</strong>de cobrarlos, rebajarlos o exonerarlos o hacer convenios con los deudores.</span></span></span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>De otra parte, le informo que la Empresa Social del Estado HOSPITAL GUAPI, se encuentra vinculada al programa de Centrales de Riesgo DATACREDITO y CIFIN, reportando el comportamiento de pago de la obligaci&oacute;n en menci&oacute;n.</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Si&nbsp;ya&nbsp;cancelo&nbsp;por&nbsp;favor&nbsp;haga&nbsp;caso&nbsp;omiso&nbsp;a&nbsp;esta&nbsp;comunicaci&oacute;n, sin otro en particular&nbsp;</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Cordialmente,</span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>JOHN DIRLEY MORALES</span></span></strong></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Jefe de Cartera </span></span></span></span></p>\r\n\r\n<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Empresa Social del Estado HOSPITAL GUAPI</span></span></span></span></p>\r\n',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(29,	'ACUMULADO DE CUENTA POR TERCERO',	'001',	'F-GFC-003',	'2018-02-13',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(30,	'CUENTA DE COBRO',	'001',	'F-GFC-004',	'2018-02-13',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(31,	'NOTA DE DEVOLUCION',	'001',	'F-GC-003',	'2016-05-11',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(32,	'DOCUMENTO CONTABLE',	'001',	'F-GC-004',	'2018-05-15',	'',	'',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(33,	'DOCUMENTO EQUIVALENTE A FACTURA',	'001',	'F-GC-004',	'2018-05-15',	'',	'CUENTA DE COBRO (Art. 4 Decreto 3050/97), DCTO. EQUIVALENTE Art. 3 Decreto 522/03), NOTA DE CONTABILIDAD (Art. 3 Decreto 380/96). ',	'2019-01-13 14:11:00',	'2019-01-13 09:11:00'),
(34,	'CERTIFICADO DE RETENCIONES',	'001',	'F-GC-006',	'2018-05-15',	'',	'Forma Continua Impresa por Computador no necesita Firma Autografa (Art. 10 D.R. 836/91, recopilado Art. 1.6.1.12.12 del DUT 1625 de 2016-10-11, que regula el contenido del certificado de renta.',	'2019-01-31 22:08:58',	'2019-01-31 17:08:58'),
(35,	'CERTIFICADO DE PRESTAMO',	'001',	'F-GH-002',	'2018-05-15',	'',	'',	'2019-04-06 19:18:54',	'2019-04-06 14:18:54');

DROP TABLE IF EXISTS `gupocuentas`;
CREATE TABLE `gupocuentas` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ClaseCuenta_PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `gupocuentas` (`PUC`, `Nombre`, `Valor`, `ClaseCuenta_PUC`, `Updated`, `Sync`) VALUES
('11',	'Disponible',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('12',	'Inversiones',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('13',	'Deudores',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('14',	'Inventarios',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('15',	'Propiedades, Planta y Equipos',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('16',	'Intangibles',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('17',	'Diferidos',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('18',	'Otros Activos',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('19',	'Valorizaciones',	'0',	'1',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('21',	'Obligaciones Financieras',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('22',	'Proveedores',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('23',	'Cuentas Por Pagar',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('24',	'Impuestos, Gravamenes y tasas',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('25',	'Obligaciones Laborales',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('26',	'Pasivos Estimados y Provisiones',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('27',	'Diferidos',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('28',	'Otros Pasivos',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('29',	'Bonos y papeles comerciales',	'0',	'2',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('31',	'Capital Social',	'0',	'3',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('32',	'Superavit de Capital',	'0',	'3',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('33',	'Reservas',	'0',	'3',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('34',	'Revalorizacion del patrimonio',	'0',	'3',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('35',	'Dividendos o participaciones decretados en ac',	'0',	'3',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('36',	'Resultados del ejercicio',	'0',	'3',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('37',	'Resultados de ejercicios anteriores',	'0',	'3',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('38',	'Superavit por valorizaciones',	'0',	'3',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('41',	'Operacionales',	'0',	'4',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('42',	'No Operacionales',	'0',	'4',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('47',	'Ajustes por Inflacion',	'0',	'4',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('51',	'Operacionales de Administracion',	'0',	'5',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('52',	'Operacionales de Ventas',	'0',	'5',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('53',	'No Operacionales',	'0',	'5',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('54',	'Impuesto de renta y complementarios',	'0',	'5',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('59',	'Ganancias y perdidas',	'0',	'5',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('61',	'Costo de ventas y de prestacion de servicios',	'0',	'6',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('62',	'Compras',	'0',	'6',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('71',	'Materia Prima',	'0',	'7',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('72',	'Mano de Obra Directa',	'0',	'7',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('73',	'Costos Indirectos',	'0',	'7',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('74',	'Contratos de Servicios',	'0',	'7',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('81',	'Derechos Contingentes',	'0',	'8',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('82',	'Deudoras Fiscales',	'0',	'8',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('83',	'Deudoras de Control',	'0',	'8',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('84',	'Derechos contingentes por contra (CR)',	'0',	'8',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('85',	'Deudoras fiscales por contra (CR)',	'0',	'8',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('86',	'Deudoras de control por contra (CR)',	'0',	'8',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('91',	'Responsabilidades contingentes',	'0',	'9',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('92',	'Acreedoras fiscales',	'0',	'9',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('93',	'Acreedoras de control',	'0',	'9',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('94',	'Responsabilidades contingentes por contra (DB',	'0',	'9',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('95',	'Acreedoras fiscales por contra (DB)',	'0',	'9',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
('96',	'Acreedoras de control por contra (DB)',	'0',	'9',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01');

DROP TABLE IF EXISTS `impret`;
CREATE TABLE `impret` (
  `idImpRet` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaRetFavor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaRetRealizadas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Aplicable_A` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idImpRet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `impret` (`idImpRet`, `Nombre`, `Tipo`, `Valor`, `CuentaRetFavor`, `CuentaRetRealizadas`, `Aplicable_A`, `Updated`, `Sync`) VALUES
(1,	'IVA',	'Impuesto',	'16',	'',	'',	'Subtotal',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
(2,	'RETEFUENTE',	'Retencion',	'0.04',	'135515',	'',	'Subtotal',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
(3,	'CREE',	'Autorretencion',	'0.008',	'135595',	'',	'Subtotal',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
(4,	'RETEIVA',	'Retencion',	'0.15',	'135517',	'',	'IVA',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
(5,	'RETENCION ICA',	'Retencion',	'0.009',	'135518',	'',	'Subtotal',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
(6,	'Retencion en la Fuente Aplicado al Regimen Simplificado por Servicios',	'RetencionAplicada',	'0.06',	'',	'2365',	'Subtotal',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
(7,	'Retencion en la Fuente Aplicado al Regimen Comun por Servicios',	'RetencionAplicada',	'0.04',	'',	'2365',	'Subtotal',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
(8,	'Impuesto a las ventas retenido, aplicado al IVA',	'RetencionAplicada',	'0.15',	'',	'2367',	'IVA',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01'),
(9,	'Impuesto de industria y comercio retenido, las tarifas dependen de la ciudad y actividad',	'RetencionAplicada',	'0.009',	'',	'2368',	'Subtotal',	'2019-01-13 14:11:01',	'2019-01-13 09:11:01');

DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE `ingresos` (
  `idIngresos` int(200) NOT NULL AUTO_INCREMENT,
  `Observaciones` varchar(500) NOT NULL,
  `Total` int(10) NOT NULL,
  `Fecha` varchar(10) NOT NULL,
  `Facturas_idFacturas` int(45) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `CerradoDiario` varchar(5) NOT NULL,
  `FechaCierreDiario` varchar(25) NOT NULL,
  `HoraCierreDiario` varchar(25) NOT NULL,
  `UsuarioCierreDiario` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idIngresos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ingresosvarios`;
CREATE TABLE `ingresosvarios` (
  `idIngresosVarios` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idIngresosVarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `insumos`;
CREATE TABLE `insumos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Existencia` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `CostoTotal` double NOT NULL,
  `Unidad` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `insumos_kardex`;
CREATE TABLE `insumos_kardex` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double DEFAULT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `ReferenciaInsumo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `ReferenciaInsumo` (`ReferenciaInsumo`),
  KEY `Movimiento` (`Movimiento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `inventarios_conteo_selectivo`;
CREATE TABLE `inventarios_conteo_selectivo` (
  `Referencia` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `inventarios_diferencias`;
CREATE TABLE `inventarios_diferencias` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ExistenciaAnterior` double NOT NULL,
  `ExistenciaActual` double NOT NULL,
  `Diferencia` double DEFAULT NULL,
  `PrecioVenta` double DEFAULT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `inventarios_temporal`;
CREATE TABLE `inventarios_temporal` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double DEFAULT NULL,
  `CostoTotal` double DEFAULT NULL,
  `CostoUnitarioPromedio` double NOT NULL,
  `CostoTotalPromedio` double NOT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub6` int(11) NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `ValorComision1` int(11) NOT NULL,
  `ValorComision2` int(11) NOT NULL,
  `ValorComision3` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `kardexmercancias`;
CREATE TABLE `kardexmercancias` (
  `idKardexMercancias` bigint(20) NOT NULL AUTO_INCREMENT,
  `idBodega` int(11) NOT NULL DEFAULT '1',
  `Fecha` date DEFAULT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `CostoUnitarioPromedio` double NOT NULL,
  `CostoTotalPromedio` double NOT NULL,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKardexMercancias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `kardexmercancias_temporal`;
CREATE TABLE `kardexmercancias_temporal` (
  `idKardexMercancias` bigint(20) NOT NULL AUTO_INCREMENT,
  `idBodega` int(11) NOT NULL DEFAULT '1',
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoPromedioUnitario` double NOT NULL,
  `CostoPromedioTotal` double NOT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKardexMercancias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `kardex_alquiler`;
CREATE TABLE `kardex_alquiler` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `Equipo` text COLLATE utf8_spanish_ci NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `RazonSocial` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Detalle` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idProducto` (`idProducto`),
  KEY `idProducto_2` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `kits`;
CREATE TABLE `kits` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `kits_relaciones`;
CREATE TABLE `kits_relaciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaProducto` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `ReferenciaProducto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `IDKit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `librodiario`;
CREATE TABLE `librodiario` (
  `idLibroDiario` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Tipo_Documento_Intero` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Num_Documento_Interno` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Num_Documento_Externo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Tipo_Documento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero_DV` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Razon_Social` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Debito` double DEFAULT NULL,
  `Credito` double DEFAULT NULL,
  `Neto` double DEFAULT NULL,
  `Mayor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Esp` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idCentroCosto` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idLibroDiario`),
  KEY `Tipo_Documento_Intero` (`Tipo_Documento_Intero`),
  KEY `Tercero_Identificacion` (`Tercero_Identificacion`),
  KEY `Num_Documento_Interno` (`Num_Documento_Interno`),
  KEY `CuentaPUC` (`CuentaPUC`),
  KEY `Fecha` (`Fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `libromayorbalances`;
CREATE TABLE `libromayorbalances` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaInicial` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `CuentaPUC` bigint(20) DEFAULT NULL,
  `NombreCuenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SaldoAnterior` double NOT NULL,
  `Debito` double DEFAULT NULL,
  `Credito` double DEFAULT NULL,
  `NuevoSaldo` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `maquinas`;
CREATE TABLE `maquinas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '_SELF',
  `Estado` int(1) NOT NULL DEFAULT '1',
  `Image` text COLLATE utf8_spanish_ci NOT NULL,
  `CSS_Clase` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `CSS_Clase`, `Orden`, `Updated`, `Sync`) VALUES
(1,	'Administrar',	1,	'Admin.php',	'_BLANK',	1,	'admin.png',	'fa fa-share',	1,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(2,	'Gestión Comercial',	1,	'MnuVentas.php',	'_BLANK',	1,	'comercial.png',	'fa fa-share',	2,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(3,	'Facturación',	1,	'MnuFacturacion.php',	'_BLANK',	1,	'factura.png',	'fa fa-share',	3,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(4,	'Cartera',	3,	'cartera.php',	'_BLANK',	1,	'cartera.png',	'fa fa-share',	4,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(5,	'Compras',	1,	'MnuCompras.php',	'_BLANK',	1,	'factura_compras.png',	'fa fa-share',	5,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(6,	'Egresos',	1,	'MnuEgresos.php',	'_BLANK',	1,	'egresos.png',	'fa fa-share',	6,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(7,	'Comprobantes Contables',	3,	'CreaComprobanteCont.php',	'_BLANK',	1,	'egresoitems.png',	'fa fa-share',	7,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(8,	'Conceptos Contables',	3,	'ConceptosContablesUtilidad.php',	'_BLANK',	1,	'conceptos.png',	'fa fa-share',	8,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(9,	'Clientes',	3,	'clientes.php',	'_BLANK',	1,	'clientes.png',	'fa fa-share',	9,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(10,	'Proveedores',	3,	'proveedores.php',	'_BLANK',	1,	'proveedores.png',	'fa fa-share',	10,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(11,	'Cuentas X Pagar',	1,	'MnuCuentasxPagar.php',	'_BLANK',	1,	'cuentasxpagar.png',	'fa fa-share',	11,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(12,	'Inventarios',	1,	'MnuInventarios.php',	'_BLANK',	1,	'inventarios.png',	'fa fa-share',	12,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(13,	'Ordenes de Servicio',	3,	'ordenesdetrabajo.php',	'_BLANK',	1,	'ordentrabajo.png',	'fa fa-share',	13,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(14,	'Producción',	3,	'CronogramaProduccion.php',	'_BLANK',	1,	'produccion.png',	'fa fa-share',	14,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(15,	'Títulos',	1,	'MnuTitulos.php',	'_BLANK',	1,	'titulos.jpg',	'fa fa-share',	15,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(16,	'Restaurante',	1,	'MnuRestaurante.php',	'_BLANK',	1,	'restaurante.png',	'fa fa-share',	16,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(17,	'Informes',	1,	'MnuInformes.php',	'_BLANK',	1,	'informes.png',	'fa fa-share',	17,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(18,	'Gestión de Requerimientos',	1,	'MnuRequerimientos.php',	'_BLANK',	1,	'requerimientos.png',	'fa fa-share',	18,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(19,	'Ajustes y Servicios Generales',	1,	'MnuAjustes.php',	'_BLANK',	1,	'ajustes.png',	'fa fa-share',	19,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(20,	'Salir',	2,	'destruir.php',	'_SELF',	1,	'salir.png',	'fa fa-share',	50,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(21,	'Administrar Tiempos',	3,	'crono_admin_sesiones.php',	'_BLANK',	0,	'admin.png',	'fa fa-share',	21,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(22,	'Visualizar Tiempo',	3,	'crono.php',	'_BLANK',	0,	'crono.png',	'fa fa-share',	22,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(23,	'Ingresos',	1,	'MnuIngresos.php',	'_BLANK',	1,	'ingresos.png',	'fa fa-share',	5,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(24,	'Traslados',	1,	'MnuTraslados.php',	'_BLANK',	0,	'traslados.png',	'fa fa-share',	1,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(25,	'Marketing',	1,	'MnuPublicidad.php',	'_BLANK',	1,	'pub.png',	'fa fa-share',	17,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(26,	'Salud',	1,	'MnuSalud.php',	'_BLANK',	1,	'salud.png',	'fa fa-share',	18,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(27,	'Gestión Documental',	1,	'MnuGestionDocumental.php',	'_BLANK',	0,	'gestiondocumental.png',	'fa fa-share',	1,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(28,	'Graficos',	1,	'MnuGraficosVentas.php',	'_BLANK',	0,	'graficos.png',	'fa fa-share',	1,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(29,	'Reservas',	1,	'MnuReservas.php',	'_BLANK',	1,	'reservas.png',	'fa fa-share',	18,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(30,	'Modelos',	1,	'MnuModelos.php',	'_BLANK',	1,	'modelos.png',	'fa fa-share',	18,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(31,	'Documentos Contables',	1,	'MnuDocumentosContables.php',	'_BLANK',	1,	'documentos_contables.png',	'fa fa-share',	8,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42'),
(32,	'Gestión del Personal',	1,	'MnuNomina.php',	'_BLANK',	1,	'colaboradores.png',	'fa fa-share',	20,	'2019-01-13 14:12:42',	'2019-01-13 09:12:42');

DROP TABLE IF EXISTS `menu_carpetas`;
CREATE TABLE `menu_carpetas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(1,	'',	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(2,	'../',	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(3,	'../VAtencion/',	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(4,	'../VMenu/',	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(5,	'../Graficos/',	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(6,	'../VSalud/',	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(7,	'../modulos/',	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(8,	'../modulos/comercial/',	'2019-04-01 13:02:36',	'2019-04-01 08:02:36'),
(9,	'../modulos/compras/',	'2019-04-01 13:02:36',	'2019-04-01 08:02:36'),
(10,	'../modulos/contabilidad/',	'2019-04-07 13:27:38',	'2019-04-07 08:27:38'),
(11,	'../modulos/reportes/',	'2019-04-08 14:14:07',	'2019-04-08 09:14:07');

DROP TABLE IF EXISTS `menu_pestanas`;
CREATE TABLE `menu_pestanas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idMenu` int(11) NOT NULL,
  `Orden` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(1,	'Empresa',	1,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(2,	'Usuarios',	1,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(3,	'Impuestos',	1,	3,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(4,	'Colaboradores',	1,	4,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(5,	'Descuentos',	1,	5,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(6,	'Finanzas',	1,	6,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(7,	'Informes',	1,	7,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(8,	'Hardware',	1,	8,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(9,	'Ventas',	2,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(10,	'Cotizaciones',	2,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(11,	'Remisiones',	2,	3,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(12,	'Facturacion',	3,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(13,	'Compras',	5,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(14,	'Egresos',	6,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(15,	'Cuentas X Pagar',	11,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(16,	'Financieros',	17,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(17,	'Auxiliares',	17,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(18,	'Reporte de Ventas',	17,	3,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(19,	'Fiscales',	17,	4,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(20,	'Compras',	17,	5,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(21,	'Auditoria',	17,	6,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(22,	'Inventarios',	12,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(23,	'Clasificacion de Inventarios',	12,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(24,	'Bodegas',	12,	3,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(25,	'Movimientos',	12,	4,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(26,	'General',	12,	5,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(27,	'Sistemas',	12,	6,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(28,	'Conteo Fisico',	12,	7,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(29,	'Requerimientos',	18,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(30,	'Restaurante',	16,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(31,	'Configuracion',	16,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(32,	'Titulos',	15,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(33,	'Traslados',	24,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(34,	'Seguimiento',	24,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(35,	'Publicidad',	25,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(36,	'RIPS',	26,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(37,	'Auditoria',	26,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(38,	'Archivos',	26,	4,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(39,	'Legal',	26,	3,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(40,	'Informes Gerenciales',	26,	5,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(41,	'Reportes Graficos',	17,	7,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(42,	'Ventas',	28,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(43,	'Tesoreria',	26,	6,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(44,	'Reservas',	29,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(45,	'Modelos',	30,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(46,	'Documentos',	31,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(47,	'Ordenes de Compra',	5,	2,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(48,	'Colaboradores',	20,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43'),
(49,	'Ingresos',	23,	1,	CONV('1', 2, 10) + 0,	'2019-01-13 14:12:43',	'2019-01-13 09:12:43');

DROP TABLE IF EXISTS `menu_submenus`;
CREATE TABLE `menu_submenus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idPestana` int(11) NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `TablaAsociada` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoLink` int(1) NOT NULL,
  `JavaScript` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Pagina` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(1) NOT NULL,
  `Image` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(1,	'Crear/Editar Empresa',	1,	3,	0,	'empresapro',	1,	'onclick=\"SeleccioneTablaDB(`empresapro`)\";',	'empresapro.php',	'_SELF',	1,	'empresa.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(2,	'Crear/Editar Sucursal',	1,	3,	0,	'empresa_pro_sucursales',	1,	'onclick=\"SeleccioneTablaDB(`empresa_pro_sucursales`)\";',	'empresa_pro_sucursales.php',	'_SELF',	1,	'sucursal.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(3,	'Resoluciones de Facturacion',	1,	3,	0,	'empresapro_resoluciones_facturacion',	1,	'onclick=\"SeleccioneTablaDB(`empresapro_resoluciones_facturacion`)\";',	'empresapro_resoluciones_facturacion.php',	'_SELF',	1,	'resolucion.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(4,	'Formatos de Calidad',	1,	3,	0,	'formatos_calidad',	1,	'onclick=\"SeleccioneTablaDB(`formatos_calidad`)\";',	'formatos_calidad.php',	'_SELF',	1,	'notacredito.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(5,	'Centros de Costos',	1,	3,	0,	'centrocosto',	1,	'onclick=\"SeleccioneTablaDB(`centrocosto`)\";',	'centrocosto.php',	'_SELF',	1,	'centrocostos.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(6,	'Crear/Editar Cajas',	1,	3,	0,	'cajas',	1,	'onclick=\"SeleccioneTablaDB(`cajas`)\";',	'cajas.php',	'_SELF',	1,	'cajas.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(7,	'Configurar Tikete de Promocion',	1,	3,	0,	'config_tiketes_promocion',	1,	'onclick=\"SeleccioneTablaDB(`config_tiketes_promocion`)\";',	'config_tiketes_promocion.php',	'_SELF',	1,	'tiketes.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(8,	'Costos operativos',	1,	3,	0,	'costos',	1,	'onclick=\"SeleccioneTablaDB(`costos`)\";',	'costos.php',	'_SELF',	1,	'costos.png',	8,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(9,	'Crear/Editar un Usuario',	2,	3,	0,	'usuarios',	1,	'onclick=\"SeleccioneTablaDB(`usuarios`)\";',	'usuarios.php',	'_SELF',	1,	'usuarios.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(10,	'Crear/Editar un Tipo de Usuario',	2,	3,	0,	'usuarios_tipo',	1,	'onclick=\"SeleccioneTablaDB(`usuarios_tipo`)\";',	'usuarios_tipo.php',	'_SELF',	1,	'usuariostipo.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(11,	'Asignar usuarios a cajas',	2,	3,	0,	'',	0,	'',	'HabilitarUser.php',	'_BLANK',	1,	'autorizarcajas.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(12,	'Crear/Editar un impuesto o una retencion',	3,	3,	0,	'impret',	1,	'onclick=\"SeleccioneTablaDB(`impret`)\";',	'impret.php',	'_SELF',	1,	'impuestos.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(13,	'Colaboradores',	4,	3,	0,	'colaboradores',	1,	'onclick=\"SeleccioneTablaDB(`colaboradores`)\";',	'colaboradores.php',	'_SELF',	1,	'colaboradores.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(14,	'Fechas Descuentos',	5,	3,	0,	'fechas_descuentos',	1,	'onclick=\"SeleccioneTablaDB(`fechas_descuentos`)\";',	'fechas_descuentos.php',	'_SELF',	1,	'descuentos.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(15,	'Libro Diario',	6,	3,	0,	'librodiario',	1,	'onclick=\"SeleccioneTablaDB(`librodiario`)\";',	'librodiario.php',	'_SELF',	1,	'librodiario.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(16,	'Historial de Facturacion',	6,	3,	0,	'facturas',	1,	'onclick=\"SeleccioneTablaDB(`facturas`)\";',	'facturas.php',	'_SELF',	1,	'facturas.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(17,	'Cuentas',	6,	3,	0,	'subcuentas',	1,	'onclick=\"SeleccioneTablaDB(`subcuentas`)\";',	'subcuentas.php',	'_SELF',	1,	'cuentas.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(18,	'Cuentas Frecuentes',	6,	3,	0,	'cuentasfrecuentes',	1,	'onclick=\"SeleccioneTablaDB(`cuentasfrecuentes`)\";',	'cuentasfrecuentes.php',	'_SELF',	1,	'cuentasfrecuentes.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(19,	'Informe Administrador',	7,	3,	0,	'',	0,	'',	'InformeVentasAdmin.php',	'_BLANK',	1,	'informes2.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(20,	'Hardware',	8,	3,	0,	'config_puertos',	1,	'onclick=\"SeleccioneTablaDB(`config_puertos`)\";',	'config_puertos.php',	'_SELF',	1,	'configuracion.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(21,	'Ventas Rapidas',	9,	3,	0,	'',	0,	'',	'VentasRapidasV2.php',	'_BLANK',	1,	'vender.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(22,	'Historial de Cierres',	9,	3,	0,	'cajas_aperturas_cierres',	1,	'onclick=\"SeleccioneTablaDB(`cajas_aperturas_cierres`)\";',	'cajas_aperturas_cierres.php',	'_SELF',	1,	'cierres_caja.jpg',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(23,	'Historial de Separados',	9,	3,	0,	'separados',	1,	'onclick=\"SeleccioneTablaDB(`separados`)\";',	'separados.php',	'_SELF',	1,	'separados.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(24,	'Historial de Abonos a Facturas',	9,	3,	0,	'facturas_abonos',	1,	'onclick=\"SeleccioneTablaDB(`facturas_abonos`)\";',	'facturas_abonos.php',	'_SELF',	1,	'abonar.jpg',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(25,	'Agregar Codigo de Barras',	9,	3,	0,	'prod_codbarras',	1,	'onclick=\"SeleccioneTablaDB(`prod_codbarras`)\";',	'prod_codbarras.php',	'_SELF',	1,	'codigobarras.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(26,	'Cotizar',	10,	3,	0,	'',	0,	'',	'../modulos/comercial/CotizacionesV2.php',	'_BLANK',	1,	'cotizacion.png',	1,	'2019-03-02 04:40:25',	'2019-03-01 23:40:25'),
(27,	'Historial de Cotizaciones',	10,	3,	0,	'cotizacionesv5',	1,	'onclick=\"SeleccioneTablaDB(`cotizacionesv5`)\";',	'cotizacionesv5.php',	'_SELF',	1,	'historial.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(28,	'Historial Cotizaciones Detallado',	10,	3,	0,	'cot_itemscotizaciones',	1,	'onclick=\"SeleccioneTablaDB(`cot_itemscotizaciones`)\";',	'cot_itemscotizaciones.php',	'_SELF',	1,	'historial2.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(29,	'Anexos a Cotizaciones',	10,	3,	0,	'cotizaciones_anexos',	1,	'onclick=\"SeleccioneTablaDB(`cotizaciones_anexos`)\";',	'cotizaciones_anexos.php',	'_SELF',	1,	'anexos2.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(30,	'Remisiones',	11,	3,	0,	'',	0,	'',	'Remisiones.php',	'_BLANK',	1,	'remision.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(31,	'Ajuste a Remision',	11,	3,	0,	'',	0,	'',	'Devoluciones.php',	'_BLANK',	1,	'devolucion2.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(32,	'Historial de Facturas',	12,	3,	0,	'facturas',	1,	'onclick=\"SeleccioneTablaDB(`facturas`)\";',	'facturas.php',	'_SELF',	1,	'factura.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(33,	'Historial de Facturas Detallado',	12,	3,	0,	'vista_facturacion_detalles',	1,	'onclick=\"SeleccioneTablaDB(`vista_facturacion_detalles`)\";',	'vista_facturacion_detalles.php',	'_SELF',	1,	'detalle.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(34,	'Historial de Notas Credito',	12,	3,	0,	'notascredito',	1,	'onclick=\"SeleccioneTablaDB(`notascredito`)\";',	'notascredito.php',	'_SELF',	1,	'historial3.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(35,	'Facturar desde Cotizacion',	12,	3,	0,	'',	0,	'',	'FactCoti.php',	'_BLANK',	1,	'cotizacion.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(36,	'Historial',	13,	3,	0,	'factura_compra',	1,	'onclick=\"SeleccioneTablaDB(`factura_compra`)\";',	'factura_compra.php',	'_SELF',	1,	'historial2.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(37,	'Historial de Productos Comprados',	13,	3,	0,	'vista_compras_productos',	1,	'onclick=\"SeleccioneTablaDB(`vista_compras_productos`)\";',	'vista_compras_productos.php',	'_SELF',	1,	'historial.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(38,	'Historial de Productos Devueltos',	13,	3,	0,	'vista_compras_productos_devoluciones',	1,	'onclick=\"SeleccioneTablaDB(`vista_compras_productos_devoluciones`)\";',	'vista_compras_productos_devoluciones.php',	'_SELF',	1,	'devoluciones.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(39,	'Historial de Compras Servicios',	13,	3,	0,	'vista_compras_servicios',	1,	'onclick=\"SeleccioneTablaDB(`vista_compras_servicios`)\";',	'vista_compras_servicios.php',	'_SELF',	1,	'servicios_compras.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(40,	'Registrar una Compra',	13,	3,	7,	'',	0,	'',	'../modulos/compras/Compras.php',	'_BLANK',	1,	'compras.png',	1,	'2019-01-29 04:02:50',	'2019-01-28 23:02:50'),
(41,	'Historial Egresos',	14,	3,	0,	'egresos',	1,	'onclick=\"SeleccioneTablaDB(`egresos`)\";',	'egresos.php',	'_SELF',	1,	'historial.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(42,	'Historial Notas Contables',	14,	3,	0,	'notascontables',	1,	'onclick=\"SeleccioneTablaDB(`notascontables`)\";',	'notascontables.php',	'_SELF',	1,	'historial3.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(43,	'Registrar Gasto o Compra',	14,	3,	0,	'',	0,	'',	'Egresos2.php',	'_BLANK',	1,	'compramercancias.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(44,	'Historial de Compras Activas',	14,	3,	0,	'compras_activas',	1,	'onclick=\"SeleccioneTablaDB(`compras_activas`)\";',	'compras_activas.php',	'_SELF',	1,	'historial4.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(45,	'Realizar un comprobante de Egreso Libre',	14,	3,	0,	'',	0,	'',	'ComprobantesEgresoLibre.php',	'_BLANK',	1,	'precuenta.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(46,	'Historial de Cuentas x Pagar',	15,	3,	0,	'',	0,	'',	'cuentasxpagar_all.php',	'_BLANK',	1,	'historial.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(47,	'Pagar',	15,	3,	0,	'',	0,	'',	'cuentasxpagar.php',	'_BLANK',	1,	'cuentasxpagar.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(48,	'Balance General y Estado de Resultados',	16,	3,	0,	'',	0,	'',	'BalanceComprobacion.php',	'_BLANK',	1,	'resultados.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(49,	'Cuentas Auxiliares',	17,	3,	0,	'',	0,	'',	'Auxiliares.php',	'_BLANK',	1,	'auxiliar.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(50,	'Informe de Ventas',	18,	3,	0,	'',	0,	'',	'InformeVentas.php',	'_BLANK',	1,	'infventas.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(51,	'Reporte de IVA',	19,	3,	0,	'',	0,	'',	'ReporteFiscalIVA.php',	'_BLANK',	1,	'fiscales.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(52,	'Informe de Compras',	20,	3,	0,	'',	0,	'',	'InformeCompras.php',	'_BLANK',	1,	'otrosinformes.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(53,	'Auditoria de Documentos',	21,	3,	0,	'',	0,	'',	'AuditoriaDocumentos.php',	'_BLANK',	1,	'auditoria.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(54,	'Historial de Ediciones',	21,	3,	0,	'registra_ediciones',	1,	'onclick=\"SeleccioneTablaDB(`registra_ediciones`)\";',	'registra_ediciones.php',	'_SELF',	1,	'registros.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(55,	'Productos para la venta',	22,	3,	0,	'productosventa',	1,	'onclick=\"SeleccioneTablaDB(`productosventa`)\";',	'productosventa.php',	'_SELF',	1,	'productosventa.png',	1,	'2019-02-26 21:51:57',	'2019-02-26 16:51:57'),
(56,	'Productos para alquilar',	22,	3,	0,	'productosalquiler',	1,	'onclick=\"SeleccioneTablaDB(`productosalquiler`)\";',	'productosalquiler.php',	'_SELF',	1,	'alquiler.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(57,	'Servicios para la venta',	22,	3,	0,	'servicios',	1,	'onclick=\"SeleccioneTablaDB(`servicios`)\";',	'servicios.php',	'_SELF',	1,	'servicios.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(58,	'Crear Orden',	47,	9,	0,	'',	0,	'',	'OrdenCompra.php',	'_BLANK',	1,	'ordendecompra.png',	4,	'2019-04-01 13:02:37',	'2019-04-01 08:02:37'),
(59,	'Kardex',	22,	3,	0,	'vista_kardex',	1,	'onclick=\"SeleccioneTablaDB(`vista_kardex`)\";',	'vista_kardex.php',	'_SELF',	1,	'kardex.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(60,	'Historial de Compras',	22,	3,	0,	'',	0,	'',	'relacioncompras.php',	'_BLANK',	1,	'compras.png',	11,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(61,	'Agregar o Editar CB',	22,	3,	0,	'prod_codbarras',	1,	'onclick=\"SeleccioneTablaDB(`prod_codbarras`)\";',	'prod_codbarras.php',	'_SELF',	1,	'codigobarras.png',	9,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(62,	'Traslados',	22,	1,	0,	'',	0,	'',	'MnuTraslados.php',	'_BLANK',	1,	'traslados.png',	10,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(63,	'Crear Departamentos',	23,	3,	0,	'prod_departamentos',	1,	'onclick=\"SeleccioneTablaDB(`prod_departamentos`)\";',	'prod_departamentos.php',	'_SELF',	1,	'departamentos.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(64,	'Subgrupo 1',	23,	3,	0,	'prod_sub1',	1,	'onclick=\"SeleccioneTablaDB(`prod_sub1`)\";',	'prod_sub1.php',	'_SELF',	1,	'uno.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(65,	'Subgrupo 2',	23,	3,	0,	'prod_sub2',	1,	'onclick=\"SeleccioneTablaDB(`prod_sub2`)\";',	'prod_sub2.php',	'_SELF',	1,	'dos.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(66,	'Subgrupo 3',	23,	3,	0,	'prod_sub3',	1,	'onclick=\"SeleccioneTablaDB(`prod_sub3`)\";',	'prod_sub3.php',	'_SELF',	1,	'tres.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(67,	'Subgrupo 4',	23,	3,	0,	'prod_sub4',	1,	'onclick=\"SeleccioneTablaDB(`prod_sub4`)\";',	'prod_sub4.php',	'_SELF',	1,	'cuatro.jpg',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(68,	'Subgrupo 5',	23,	3,	0,	'prod_sub5',	1,	'onclick=\"SeleccioneTablaDB(`prod_sub5`)\";',	'prod_sub5.php',	'_SELF',	1,	'cinco.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(69,	'Ver/Crear/Editar Bodega',	24,	3,	0,	'bodega',	1,	'onclick=\"SeleccioneTablaDB(`bodega`)\";',	'bodega.php',	'_SELF',	1,	'bodega.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(70,	'Ver Bodegas Externas',	24,	3,	0,	'bodegas_externas',	1,	'onclick=\"SeleccioneTablaDB(`bodegas_externas`)\";',	'bodegas_externas.php',	'_SELF',	1,	'externas.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(71,	'Ver el historial de las bajas y altas',	25,	3,	0,	'prod_bajas_altas',	1,	'onclick=\"SeleccioneTablaDB(`prod_bajas_altas`)\";',	'prod_bajas_altas.php',	'_SELF',	1,	'historial.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(72,	'Dar de baja o alta a un producto',	25,	3,	0,	'',	0,	'',	'DarBajaAlta.php',	'_BLANK',	1,	'baja.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(73,	'Actualizaciones Generales',	26,	3,	0,	'',	0,	'',	'ActualizacionesGeneralesInventarios.php',	'_BLANK',	1,	'actualizar.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(74,	'Consolidado Sistemas',	27,	3,	0,	'vista_sistemas',	1,	'onclick=\"SeleccioneTablaDB(`vista_sistemas`)\";',	'vista_sistemas.php',	'_SELF',	1,	'sistema.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(75,	'Crear',	27,	3,	0,	'',	0,	'',	'CreaSistema.php',	'_BLANK',	1,	'crearsistema.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(76,	'Agregar Productos desde CSV',	28,	3,	0,	'',	0,	'',	'AgregarItemsXCB.php',	'_BLANK',	1,	'csv.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(77,	'Preparar Conteo Fisico',	28,	3,	0,	'',	0,	'',	'inventario_preparacion.php',	'_BLANK',	1,	'terminado.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(78,	'Tabla Temporal',	28,	3,	0,	'inventarios_temporal',	1,	'onclick=\"SeleccioneTablaDB(`inventarios_temporal`)\";',	'inventarios_temporal.php',	'_SELF',	1,	'pedidos.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(79,	'Realizar Conteo Fisico',	28,	3,	0,	'',	0,	'',	'ConteoFisico.php',	'_BLANK',	1,	'conteo_inventario.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(80,	'Iniciar',	28,	3,	0,	'',	0,	'',	'ConteoFisicoPDA.php',	'_BLANK',	1,	'PDA.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(81,	'Diferencias en los inventarios',	28,	3,	0,	'vista_diferencia_inventarios',	1,	'onclick=\"SeleccioneTablaDB(`vista_diferencia_inventarios`)\";',	'vista_diferencia_inventarios.php',	'_SELF',	1,	'inventarios_diferencias.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(82,	'Proyectos',	29,	3,	0,	'',	0,	'',	'requerimientos_proyectos.php',	'_BLANK',	1,	'proyectos.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(83,	'Atencion Mesas',	30,	3,	0,	'',	0,	'',	'AtencionMeseros2.php',	'_BLANK',	0,	'mesero.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(84,	'Atencion Domicilios',	30,	3,	0,	'',	0,	'',	'AtencionDomicilios.php',	'_BLANK',	0,	'atencion_domicilios.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(85,	'Pedidos',	30,	3,	0,	'',	0,	'',	'Restaurante_Admin.php',	'_BLANK',	0,	'pedidos.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(86,	'Crear o Editar Mesas',	31,	3,	0,	'restaurante_mesas',	1,	'onclick=\"SeleccioneTablaDB(`restaurante_mesas`)\";',	'restaurante_mesas.php',	'_SELF',	1,	'mesas.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(87,	'Promociones',	32,	3,	0,	'titulos_promociones',	1,	'onclick=\"SeleccioneTablaDB(`titulos_promociones`)\";',	'titulos_promociones.php',	'_SELF',	1,	'promociones.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(88,	'Inventario de Titulos',	32,	3,	0,	'',	0,	'',	'listados_titulos.php',	'_BLANK',	1,	'inventarios_titulos.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(89,	'Historial de Actas de Entrega',	32,	3,	0,	'titulos_asignaciones',	1,	'onclick=\"SeleccioneTablaDB(`titulos_asignaciones`)\";',	'titulos_asignaciones.php',	'_SELF',	1,	'acta.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(90,	'Venta de Titulos',	32,	3,	0,	'',	0,	'',	'VentasTitulos.php',	'_BLANK',	1,	'ventastitulos.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(91,	'Historial de Venta de Titulos',	32,	3,	0,	'titulos_ventas',	1,	'onclick=\"SeleccioneTablaDB(`titulos_ventas`)\";',	'titulos_ventas.php',	'_SELF',	1,	'historial.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(92,	'Historial de Abonos a Ventas',	32,	3,	0,	'titulos_abonos',	1,	'onclick=\"SeleccioneTablaDB(`titulos_abonos`)\";',	'titulos_abonos.php',	'_SELF',	1,	'abonos.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(93,	'Historial de Titulos Devueltos',	32,	3,	0,	'titulos_devoluciones',	1,	'onclick=\"SeleccioneTablaDB(`titulos_devoluciones`)\";',	'titulos_devoluciones.php',	'_SELF',	1,	'historial2.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(94,	'Cuentas X Cobrar',	32,	3,	0,	'titulos_cuentasxcobrar',	1,	'onclick=\"SeleccioneTablaDB(`titulos_cuentasxcobrar`)\";',	'titulos_cuentasxcobrar.php',	'_SELF',	1,	'cuentasxcobrar.png',	8,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(95,	'Comisiones',	32,	3,	0,	'titulos_comisiones',	1,	'onclick=\"SeleccioneTablaDB(`titulos_comisiones`)\";',	'titulos_comisiones.php',	'_SELF',	1,	'comisiones.png',	9,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(96,	'Historial de Traslados',	32,	3,	0,	'titulos_traslados',	1,	'onclick=\"SeleccioneTablaDB(`titulos_traslados`)\";',	'titulos_traslados.php',	'_SELF',	1,	'traslado.png',	10,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(97,	'Historial de Anulacion de Abonos',	32,	3,	0,	'comprobantes_ingreso_anulaciones',	1,	'onclick=\"SeleccioneTablaDB(`comprobantes_ingreso_anulaciones`)\";',	'comprobantes_ingreso_anulaciones.php',	'_SELF',	1,	'historial3.png',	11,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(98,	'Informes',	32,	3,	0,	'',	0,	'',	'InformeTitulos.php',	'_BLANK',	1,	'informes.png',	12,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(99,	'Historial',	33,	3,	0,	'traslados_mercancia',	1,	'onclick=\"SeleccioneTablaDB(`traslados_mercancia`)\";',	'traslados_mercancia.php',	'_SELF',	1,	'historial.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(100,	'Nuevo',	33,	3,	0,	'',	0,	'',	'CrearTraslado2.php',	'_BLANK',	1,	'nuevo.png',	2,	'2019-02-19 21:04:30',	'2019-02-19 16:04:30'),
(101,	'Subir Traslados',	33,	3,	0,	'',	0,	'',	'SubirTraslado.php',	'_BLANK',	1,	'upload.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(102,	'Descargar Traslados',	33,	3,	0,	'',	0,	'',	'DescargarTraslados.php',	'_BLANK',	1,	'descargar.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(103,	'Seguimiento',	34,	3,	0,	'',	0,	'',	'_.php',	'_BLANK',	1,	'departamentos.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(104,	'Crear o Editar cartel de publicidad',	35,	3,	0,	'',	0,	'',	'CrearCartelPublicitario.php',	'_BLANK',	1,	'cartel.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(105,	'Resumen de facturacion',	12,	3,	0,	'',	0,	'',	'vista_resumen_facturacion.php',	'_BLANK',	1,	'resumen.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(106,	'Kardex Alquiler',	22,	3,	0,	'kardex_alquiler',	1,	'onclick=\"SeleccioneTablaDB(`kardex_alquiler`)\";',	'kardex_alquiler.php',	'_SELF',	1,	'kardex_alquiler.png',	8,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(107,	'Historial de Cierres',	30,	3,	0,	'restaurante_cierres',	1,	'onclick=\"SeleccioneTablaDB(`restaurante_cierres`)\";',	'restaurante_cierres.php',	'_SELF',	1,	'historial.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(108,	'Historial de Pedidos',	30,	3,	0,	'restaurante_pedidos',	1,	'onclick=\"SeleccioneTablaDB(`restaurante_pedidos`)\";',	'restaurante_pedidos.php',	'_SELF',	1,	'historial2.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(109,	'Historial de Eliminaciones',	21,	3,	0,	'registra_eliminaciones',	1,	'onclick=\"SeleccioneTablaDB(`registra_eliminaciones`)\";',	'registra_eliminaciones.php',	'_SELF',	1,	'papelera.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(110,	'Resumen de facturacion X Fecha',	12,	3,	0,	'',	0,	'',	'facturacionxfecha.php',	'_BLANK',	1,	'fecha.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(111,	'Historial detallado',	33,	3,	0,	'traslados_items',	1,	'onclick=\"SeleccioneTablaDB(`traslados_items`)\";',	'traslados_items.php',	'_SELF',	1,	'historial2.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(112,	'Sistemas',	27,	3,	0,	'sistemas',	1,	'onclick=\"SeleccioneTablaDB(`sistemas`)\";',	'sistemas.php',	'_SELF',	1,	'sistem.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(113,	'Inventario de Separados',	22,	3,	0,	'vista_inventario_separados',	1,	'onclick=\"SeleccioneTablaDB(`vista_inventario_separados`)\";',	'vista_inventario_separados.php',	'_SELF',	1,	'inventario_separados.png',	12,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(114,	'Comparacion Anual',	9,	5,	0,	'',	0,	'',	'YearsComparison.php',	'_BLANK',	1,	'anualcomp.jpg',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(115,	'Comparacion Diaria',	9,	5,	0,	'',	0,	'',	'DiasComparacion.php',	'_BLANK',	1,	'diascomp.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(116,	'Subir RIPS Generados',	36,	6,	0,	'',	0,	'',	'Salud_SubirRips.php',	'_BLANK',	1,	'upload2.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(117,	'Subir RIPS de pago',	36,	6,	0,	'',	0,	'',	'Salud_SubirRipsPagos.php',	'_BLANK',	1,	'upload.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(118,	'Radicar Facturas',	36,	6,	0,	'',	0,	'',	'salud_radicacion_facturas.php',	'_BLANK',	1,	'radicar.jpg',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(119,	'Historial de Facturas Pagas',	36,	6,	0,	'',	0,	'',	'vista_salud_facturas_pagas.php',	'_BLANK',	1,	'historial.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(120,	'Historial de Facturas NO Pagadas',	36,	6,	0,	'',	0,	'',	'vista_salud_facturas_no_pagas.php',	'_BLANK',	1,	'historial2.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(121,	'Historial de Facturas Con Diferencias',	36,	6,	0,	'',	0,	'',	'vista_salud_facturas_diferencias.php',	'_BLANK',	1,	'historial3.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(122,	'Listas de precios',	22,	3,	0,	'productos_lista_precios',	1,	'onclick=\"SeleccioneTablaDB(`productos_lista_precios`)\";',	'productos_lista_precios.php',	'_SELF',	1,	'listasprecios.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(123,	'Precios Adicionales',	22,	3,	0,	'productos_precios_adicionales',	1,	'onclick=\"SeleccioneTablaDB(`productos_precios_adicionales`)\";',	'productos_precios_adicionales.php',	'_SELF',	1,	'productos_precios.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(124,	'Glosas',	37,	6,	0,	'',	0,	'',	'SaludGlosasDevoluciones.php',	'_BLANK',	1,	'glosas.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(125,	'Informe de Estado de Rips',	40,	6,	0,	'',	0,	'',	'SaludInformeEstadoRips.php',	'_BLANK',	1,	'estadorips.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(126,	'Cartera X Edades',	40,	6,	0,	'',	0,	'',	'salud_edad_cartera.php',	'_BLANK',	1,	'cartera.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(127,	'Registro de Glosas',	37,	6,	0,	'',	0,	'',	'salud_registro_glosas.php',	'_BLANK',	1,	'glosas2.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(128,	'Archivo de Consultas AC',	38,	6,	0,	'',	0,	'',	'salud_archivo_consultas.php',	'_BLANK',	1,	'ac.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(129,	'Archivo de Hospitalizaciones AH',	38,	6,	0,	'',	0,	'',	'salud_archivo_hospitalizaciones.php',	'_BLANK',	1,	'ah.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(130,	'Archivo de Medicamentos AM',	38,	6,	0,	'',	0,	'',	'salud_archivo_medicamentos.php',	'_BLANK',	1,	'am.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(131,	'Otros Servicios AT',	38,	6,	0,	'',	0,	'',	'salud_archivo_otros_servicios.php',	'_BLANK',	1,	'at.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(132,	'Archivo de Procedimientos AP',	38,	6,	0,	'',	0,	'',	'salud_archivo_procedimientos.php',	'_BLANK',	1,	'ap.jpg',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(134,	'Archivo de usuarios US',	38,	6,	0,	'',	0,	'',	'salud_archivo_usuarios.php',	'_BLANK',	1,	'us.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(135,	'Facturacion Generada AF',	38,	6,	0,	'',	0,	'',	'salud_archivo_facturacion_mov_generados.php',	'_BLANK',	1,	'af.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(136,	'Facturacion Recaudada AR',	38,	6,	0,	'',	0,	'',	'salud_archivo_facturacion_mov_pagados.php',	'_BLANK',	1,	'ar.png',	8,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(137,	'Listado de EPS',	36,	6,	0,	'',	0,	'',	'salud_eps.php',	'_BLANK',	1,	'eps.png',	8,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(138,	'Pagos de posibles VIGENCIAS ANTERIORES',	36,	6,	0,	'',	0,	'',	'vista_salud_pagas_no_generadas.php',	'_BLANK',	1,	'factura3.png',	8,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(139,	'Libro Mayor y Balances',	16,	3,	0,	'libromayorbalances',	1,	'onclick=\"SeleccioneTablaDB(`libromayorbalances`)\";',	'libromayorbalances.php',	'_SELF',	1,	'libromayor.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(140,	'Generar Prejuridicos',	39,	6,	0,	'',	0,	'',	'SaludPrejuridicos.php',	'_BLANK',	1,	'prejuridico.jpg',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(141,	'Reportes Graficos',	41,	1,	0,	'',	0,	'',	'MnuGraficosVentas.php',	'_BLANK',	1,	'graficos.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(142,	'Comparacion Anual',	42,	5,	0,	'',	0,	'',	'YearsComparison.php',	'_BLANK',	1,	'anualcomp.jpg',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(143,	'Comparacion Diaria',	42,	5,	0,	'',	0,	'',	'DiasComparacion.php',	'_BLANK',	1,	'diascomp.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(144,	'Graficos Ventas Departamentos',	42,	3,	0,	'',	0,	'',	'GraficosVentasXDepartamentos.php',	'_BLANK',	1,	'graficos.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(145,	'Circular 030',	40,	6,	0,	'',	0,	'',	'salud_genere_circular_030.php',	'_BLANK',	1,	'030.jpg',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(146,	'SIHO',	40,	6,	0,	'',	0,	'',	'SIHO.php',	'_BLANK',	1,	'siho.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(147,	'Totales en Compras',	13,	3,	0,	'vista_factura_compra_totales',	1,	'onclick=\"SeleccioneTablaDB(`vista_factura_compra_totales`)\";',	'vista_factura_compra_totales.php',	'_SELF',	1,	'historial3.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(148,	'Generar Comprobante de Acumulado Cuenta por Tercero',	16,	3,	0,	'',	0,	'',	'ComprobantesContables.php',	'_BLANK',	1,	'comprobantes.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(149,	'Diagnostico de RIPS Circular 030',	40,	6,	0,	'',	0,	'',	'salud_edad_cartera.php',	'_BLANK',	1,	'diagnostico.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(150,	'Historial Prejuridicos',	39,	6,	0,	'',	0,	'',	'salud_cobros_prejuridicos.php',	'_BLANK',	1,	'historial.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(151,	'Historial de pagos ingresados por tesoreria',	43,	6,	0,	'',	0,	'',	'salud_tesoreria.php',	'_BLANK',	1,	'historial2.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(152,	'Registrar Pago',	43,	6,	0,	'',	0,	'',	'Salud_Ingresar_Pago_Tesoreria.php',	'_BLANK',	1,	'pago.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(153,	'Procesos Gerenciales',	40,	6,	0,	'',	0,	'',	'salud_procesos_gerenciales.php',	'_BLANK',	1,	'gestion.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(154,	'Reserva de Espacios',	44,	3,	0,	'',	0,	'',	'ReservaEspacios.php',	'_BLANK',	1,	'reservas2.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(155,	'Subir Circular 030 inicial',	40,	6,	0,	'',	0,	'',	'salud_subir_circular_030_inicial.php',	'_BLANK',	1,	'030_inicial.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(156,	'Historial de Autorizaciones',	21,	3,	0,	'registro_autorizaciones_pos',	1,	'onclick=\"SeleccioneTablaDB(`registro_autorizaciones_pos`)\";',	'registro_autorizaciones_pos.php',	'_SELF',	1,	'autorizacion.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(157,	'Inventarios Selectivos',	28,	3,	0,	'vista_diferencia_inventarios_selectivos',	1,	'onclick=\"SeleccioneTablaDB(`vista_diferencia_inventarios_selectivos`)\";',	'vista_diferencia_inventarios_selectivos.php',	'_SELF',	1,	'diferencias.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(158,	'Conteo Selectivo',	28,	3,	0,	'',	0,	'',	'ConteoFisicoSelectivo.php',	'_BLANK',	1,	'conteo_selectivo.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(159,	'Actualizacion de Precios Manual',	26,	3,	0,	'',	0,	'',	'ActualizarPreciosManual.php',	'_BLANK',	1,	'pagos.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(160,	'Informes',	44,	3,	0,	'',	0,	'',	'ReservasInformes.php',	'_BLANK',	1,	'informes.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(161,	'Historial de Documentos Equivalentes',	12,	3,	0,	'documento_equivalente_items',	1,	'onclick=\"SeleccioneTablaDB(`documento_equivalente_items`)\";',	'documento_equivalente_items.php',	'_SELF',	1,	'equivalente.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(162,	'Realizar un documento equivalente',	12,	3,	0,	'',	0,	'',	'CrearDocumentoEquivalente.php',	'_BLANK',	1,	'docequivalente.png',	8,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(163,	'Base de Datos de Modelos',	45,	3,	0,	'modelos_db',	1,	'onclick=\"SeleccioneTablaDB(`modelos_db`)\";',	'modelos_db.php',	'_SELF',	1,	'modelos.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(164,	'Administrar Tiempos',	45,	3,	0,	'',	0,	'',	'modelos_admin.php',	'_BLANK',	1,	'modelos_admin.png',	2,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(165,	'Historial de Agenda',	45,	3,	0,	'modelos_agenda',	1,	'onclick=\"SeleccioneTablaDB(`modelos_agenda`)\";',	'modelos_agenda.php',	'_SELF',	1,	'historial.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(166,	'Notas de Devolucion',	13,	3,	0,	'',	0,	'',	'RegistraNotaDevolucion.php',	'_BLANK',	1,	'devolucion.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(167,	'Totales en Facturacion',	12,	3,	0,	'vista_totales_facturacion',	1,	'onclick=\"SeleccioneTablaDB(`vista_totales_facturacion`)\";',	'vista_totales_facturacion.php',	'_SELF',	1,	'totales_facturacion.png',	9,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(168,	'Historial de Cierres',	45,	3,	0,	'modelos_cierres',	1,	'onclick=\"SeleccioneTablaDB(`modelos_cierres`)\";',	'modelos_cierres.php',	'_SELF',	1,	'historial2.png',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(169,	'Ventas',	30,	3,	0,	'',	0,	'',	'VentasRestaurante.php',	'_BLANK',	1,	'vender.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(170,	'Historial de Notas de Devolucion',	13,	3,	0,	'factura_compra_notas_devolucion',	1,	'onclick=\"SeleccioneTablaDB(`factura_compra_notas_devolucion`)\";',	'factura_compra_notas_devolucion.php',	'_SELF',	1,	'historial4.png',	8,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(171,	'Vista Libro Diario ',	6,	3,	0,	'vista_libro_diario',	1,	'onclick=\"SeleccioneTablaDB(`vista_libro_diario`)\";',	'vista_libro_diario.php',	'_SELF',	1,	'anexos2.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(172,	'Crear un Documento Contable',	46,	3,	0,	'',	0,	'',	'documentos_contables.php',	'_BLANK',	0,	'030.jpg',	3,	'2019-04-12 00:54:12',	'2019-01-13 09:12:44'),
(173,	'Registrar Documento Contable',	46,	10,	0,	'',	0,	'',	'DocumentosContables.php',	'_BLANK',	1,	'ordenessalida.png',	2,	'2019-04-12 00:53:08',	'2019-01-13 09:12:44'),
(174,	'Historial Documentos Contables',	46,	3,	0,	'documentos_contables_control',	1,	'onclick=\"SeleccioneTablaDB(`documentos_contables_control`)\";',	'documentos_contables_control.php',	'_SELF',	1,	'historial.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(175,	'Historial de Pedidos Items',	30,	3,	0,	'restaurante_pedidos_items',	1,	'onclick=\"SeleccioneTablaDB(`restaurante_pedidos_items`)\";',	'restaurante_pedidos_items.php',	'_SELF',	1,	'historial3.png',	6,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(176,	'Recetas',	27,	3,	0,	'',	0,	'',	'CrearReceta.php',	'_BLANK',	1,	'recetas.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(177,	'Insumos',	22,	3,	0,	'insumos',	1,	'onclick=\"SeleccioneTablaDB(`insumos`)\";',	'insumos.php',	'_SELF',	1,	'insumos.png',	3,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(178,	'Subgrupo 6',	23,	3,	0,	'prod_sub6',	1,	'onclick=\"SeleccioneTablaDB(`prod_sub6`)\";',	'prod_sub6.php',	'_SELF',	1,	'usuariostipo.png',	7,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(179,	'Facturación Frecuente',	12,	3,	0,	'',	0,	'',	'GenerarFacturacionFrecuente.php',	'_BLANK',	1,	'repetitivo.png',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(180,	'Historial',	47,	3,	0,	'ordenesdecompra',	1,	'onclick=\"SeleccioneTablaDB(`ordenesdecompra`)\";',	'ordenesdecompra.php',	'_SELF',	1,	'historial.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(181,	'Historial de Documentos Equivalentes',	48,	3,	0,	'nomina_documentos_equivalentes',	1,	'onclick=\"SeleccioneTablaDB(`nomina_documentos_equivalentes`)\";',	'nomina_documentos_equivalentes.php',	'_SELF',	1,	'historial.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(182,	'Manejo de Turnos',	48,	3,	0,	'',	0,	'',	'AdministrarTurnos.php',	'_BLANK',	1,	'turnos.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(183,	'Verificar Orden',	47,	3,	0,	'',	0,	'',	'../modulos/compras/ReciboOrdenCompra.php',	'_BLANK',	1,	'verificarOC.jpg',	5,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(184,	'Reportes',	16,	3,	0,	'',	0,	'',	'../modulos/contabilidad/ReportesContabilidad.php',	'_BLANK',	1,	'reportes.jpg',	4,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(185,	'Inteligencia de Negocio',	18,	11,	0,	'',	1,	'',	'ReportesComparativos.php',	'_SELF',	1,	'abonar.jpg',	2,	'2019-04-08 14:14:07',	'2019-04-08 09:14:07'),
(186,	'Historial Comprobantes Ingreso',	49,	3,	0,	'comprobantes_ingreso',	1,	'onclick=\"SeleccioneTablaDB(`comprobantes_ingreso`)\";',	'comprobantes_ingreso.php',	'_SELF',	1,	'historial3.png',	1,	'2019-01-13 14:12:44',	'2019-01-13 09:12:44'),
(187,	'Prestamos a Terceros',	14,	10,	0,	'',	1,	'',	'PrestamosATerceros.php',	'_SELF',	1,	'abonar.jpg',	6,	'2019-04-07 13:29:47',	'2019-04-07 08:29:47'),
(188,	'Reporte de Ingresos y Ventas por plataformas',	18,	11,	0,	'',	1,	'',	'ReportesPlataformas.php',	'_SELF',	1,	'reportes.jpg',	3,	'2019-04-08 14:14:07',	'2019-04-08 09:14:07'),
(189,	'Reportes',	32,	11,	0,	'',	1,	'',	'ReportesTitulos.php',	'_SELF',	1,	'reportes.jpg',	13,	'2019-04-09 14:54:50',	'2019-04-09 09:54:50');

DROP TABLE IF EXISTS `modelos_agenda`;
CREATE TABLE `modelos_agenda` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idModelo` int(11) NOT NULL,
  `ValorPagado` double NOT NULL,
  `ValorModelo` double NOT NULL,
  `ValorCasa` double NOT NULL,
  `Minutos` int(11) NOT NULL,
  `HoraInicial` datetime NOT NULL,
  `HoraATerminar` datetime NOT NULL,
  `idCierreModelo` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Abierto',
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `modelos_cierres`;
CREATE TABLE `modelos_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `modelos_config_factura`;
CREATE TABLE `modelos_config_factura` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idItemFactura` bigint(20) NOT NULL,
  `TablaItem` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `modelos_config_factura` (`ID`, `idItemFactura`, `TablaItem`, `Updated`, `Sync`) VALUES
(1,	1,	'servicios',	'2019-01-29 15:57:27',	'2019-01-29 10:57:27');

DROP TABLE IF EXISTS `modelos_db`;
CREATE TABLE `modelos_db` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `NombreArtistico` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Identificacion` bigint(20) NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorServicio1` double NOT NULL,
  `ValorServicio2` double NOT NULL,
  `ValorServicio3` double NOT NULL,
  `Estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'A',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NombreArtistico` (`NombreArtistico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `nomina_configuracion_documentos_equivalentes`;
CREATE TABLE `nomina_configuracion_documentos_equivalentes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `Articulo1` text COLLATE utf8_spanish_ci NOT NULL,
  `Articulo2` text COLLATE utf8_spanish_ci NOT NULL,
  `Articulo3` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `nomina_documentos_equivalentes`;
CREATE TABLE `nomina_documentos_equivalentes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Sucursal` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `nomina_parametros_contables`;
CREATE TABLE `nomina_parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `nomina_parametros_contables` (`ID`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(1,	'523510',	'Servicios Temporales',	'2019-01-13 14:12:46',	'2019-01-13 09:12:46'),
(2,	'236540',	'RETEFUENTE',	'2019-01-13 14:12:46',	'2019-01-13 09:12:46'),
(3,	'233525',	'CUENTA POR PAGAR',	'2019-01-13 14:12:46',	'2019-01-13 09:12:46'),
(4,	'236805',	'RETENCION DE INDUSTRIA Y COMERCIO',	'2019-01-13 14:12:46',	'2019-01-13 09:12:46');

DROP TABLE IF EXISTS `nomina_parametros_generales`;
CREATE TABLE `nomina_parametros_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `nomina_parametros_generales` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(1,	'RETENCION DE ICA',	0.0066,	'2019-01-13 14:12:47',	'2019-01-13 09:12:47'),
(2,	'Tope para realizar retencion de ICA',	99000,	'2019-01-13 14:12:47',	'2019-01-13 09:12:47'),
(3,	'Retefuente por servicios para personas naturales',	0.06,	'2019-01-13 14:12:47',	'2019-01-13 09:12:47'),
(4,	'Tope en servicios para personas naturales',	133000,	'2019-01-13 14:12:47',	'2019-01-13 09:12:47');

DROP TABLE IF EXISTS `nomina_servicios_turnos`;
CREATE TABLE `nomina_servicios_turnos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Sucursal` int(11) NOT NULL,
  `Valor` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `Pagado` int(1) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idDocumentoEquivalente` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Estado` (`Estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `notascontables`;
CREATE TABLE `notascontables` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `FechaProgramada` date NOT NULL,
  `Detalle` text COLLATE utf8_spanish_ci NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Soporte` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `notascontables_anulaciones`;
CREATE TABLE `notascontables_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idNota` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `notascredito`;
CREATE TABLE `notascredito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Cliente` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ordenesdecompra`;
CREATE TABLE `ordenesdecompra` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `PlazoEntrega` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NoCotizacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Condiciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Solicitante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioCreador` int(11) NOT NULL,
  `idCentroCostos` int(11) NOT NULL DEFAULT '1',
  `idSucursal` int(11) NOT NULL DEFAULT '1',
  `Estado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ordenesdecompra_items`;
CREATE TABLE `ordenesdecompra_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NumOrden` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Tipo_Impuesto` double NOT NULL,
  `Faltante` double NOT NULL,
  `Devuelto` double NOT NULL,
  `Recibido` double NOT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `NumOrden` (`NumOrden`),
  KEY `idProducto` (`idProducto`),
  KEY `NumOrden_2` (`NumOrden`),
  KEY `idProducto_2` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ordenesdetrabajo`;
CREATE TABLE `ordenesdetrabajo` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `FechaOT` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DireccionServicio` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `NombreSolicitante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TipoOrden` int(11) NOT NULL,
  `idUsuarioCreador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Hora` time NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ordenesdetrabajo_items`;
CREATE TABLE `ordenesdetrabajo_items` (
  `ID` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idOT` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Actividad` text COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `TiempoEstimadoHoras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ordenesdetrabajo_tipo`;
CREATE TABLE `ordenesdetrabajo_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ori_facturas`;
CREATE TABLE `ori_facturas` (
  `idFacturas` varchar(45) CHARACTER SET utf8 NOT NULL,
  `idResolucion` int(11) NOT NULL,
  `TipoFactura` varchar(10) CHARACTER SET utf8 NOT NULL,
  `Prefijo` varchar(45) CHARACTER SET utf8 NOT NULL,
  `NumeroFactura` int(16) NOT NULL,
  `Fecha` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Hora` varchar(20) CHARACTER SET utf8 NOT NULL,
  `OCompra` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `OSalida` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descuentos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `SaldoFact` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro_idEmpresaPro` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `TotalCostos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` bigint(20) NOT NULL,
  `FechaCierreDiario` date NOT NULL,
  `HoraCierreDiario` time NOT NULL,
  `ObservacionesFact` text CHARACTER SET utf8 NOT NULL,
  `Efectivo` double NOT NULL,
  `Devuelve` double NOT NULL,
  `Cheques` double NOT NULL,
  `Otros` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `idTarjetas` double NOT NULL,
  `ReporteFacturaElectronica` int(1) NOT NULL COMMENT 'indica si ya fue reportada como factura electronica',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ori_facturas_items`;
CREATE TABLE `ori_facturas_items` (
  `ID` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TablaItems` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` int(11) NOT NULL,
  `Cantidad` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalItem` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `IVAItem` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ValorOtrosImpuestos` double NOT NULL,
  `TotalItem` double NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `idOtrosImpuestos` int(11) NOT NULL,
  `idPorcentajeIVA` int(11) NOT NULL,
  `PrecioCostoUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalCosto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `idFactura` (`idFactura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `TipoPagina` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `paginas` (`ID`, `Nombre`, `TipoPagina`, `Visible`, `Updated`, `Sync`) VALUES
(1,	'Admin.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(2,	'MnuEgresos.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(3,	'MnuFacturacion.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(4,	'MnuInformes.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(5,	'MnuIngresos.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(6,	'MnuInventarios.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(7,	'MnuTraslados.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(8,	'MnuVentas.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(9,	'abonos_libro.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(10,	'AgregaItemsOC.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(11,	'AgregaItemsOT.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(12,	'AgregarItemsXCB.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(13,	'AnularFactura.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(14,	'BalanceComprobacion.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(15,	'buscar_item.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(16,	'cajas.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(17,	'cajas_aperturas_cierres.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(18,	'cartera.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(19,	'centrocosto.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(20,	'clientes.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(21,	'colaboradores.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(22,	'CompraMercancias.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(23,	'comprobantes_contabilidad_items.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(24,	'comprobantes_ingreso.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(25,	'ComprobantesIngreso.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(26,	'config_puertos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(27,	'config_tiketes_promocion.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(28,	'cot_itemscotizaciones.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(29,	'Cotizaciones.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(30,	'cotizacionesv5.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(31,	'CreaComprobanteCont.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(32,	'CreaTraslado.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(33,	'cuentasfrecuentes.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(34,	'CuentasXCobrar.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(35,	'CuentasXPagar.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(36,	'DescargarTraslados.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(37,	'Devoluciones.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(38,	'EditarRegistro.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(39,	'egresos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(40,	'Egresos2.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(41,	'empresapro.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(42,	'empresapro_resoluciones_facturacion.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(43,	'FactCoti.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(44,	'FacturaCotizacion.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(45,	'facturas.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(46,	'facturas_items.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(47,	'fechas_descuentos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(48,	'FormatoFact.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(49,	'formatos_calidad.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(50,	'HabilitarUser.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(51,	'historialremisiones.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(52,	'impret.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(53,	'InformeAdministracion.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(54,	'InformeVentas.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(55,	'InformeVentasAdmin.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(56,	'kardexmercancias.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(57,	'librodiario.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(58,	'notascontables.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(59,	'notascredito.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(60,	'OrdenesActivos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(61,	'ordenesdecompra.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(62,	'ordenesdetrabajo.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(63,	'pedidos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(64,	'prod_codbarras.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(65,	'prod_departamentos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(66,	'prod_sub1.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(67,	'prod_sub2.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(68,	'prod_sub3.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(69,	'prod_sub4.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(70,	'prod_sub5.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(71,	'productosalquiler.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(72,	'productosventa.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(73,	'proveedores.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(74,	'RegistrarAnticipos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(75,	'RegistrarIngreso.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(76,	'RegistrarTraslado.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(77,	'Remisiones.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(78,	'separados.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(79,	'separados_abonos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(80,	'separados_items.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(81,	'servicios.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(82,	'subcuentas.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(83,	'SubirTraslado.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(84,	'traslados_mercancia.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(85,	'usuarios.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(86,	'VentasRapidas.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(87,	'MnuAjustes.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(88,	'backups.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(89,	'bodega.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(90,	'bodegas_externas.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(91,	'empresa_pro_sucursales.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(92,	'AgregueParametros.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(93,	'Menu.php',	'Menu',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(94,	'DarBajaAlta.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(95,	'prod_bajas_altas.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(96,	'CronogramaProduccion.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(97,	'Ejecutar_Actividades.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54'),
(98,	'facturas_abonos.php',	'Vista',	1,	'2019-01-13 14:12:54',	'2019-01-13 09:12:54');

DROP TABLE IF EXISTS `paginas_bloques`;
CREATE TABLE `paginas_bloques` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoUsuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Pagina` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `paginas_bloques` (`ID`, `TipoUsuario`, `Pagina`, `Habilitado`, `Updated`, `Sync`) VALUES
(1,	'comercial',	'MnuVentas.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(2,	'comercial',	'Menu.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(3,	'comercial',	'VentasRapidas.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(4,	'comercial',	'cotizacionesv5.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(5,	'comercial',	'Cotizaciones.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(6,	'comercial',	'cajas_aperturas_cierres.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(7,	'comercial',	'separados.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(8,	'comercial',	'separados_abonos.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(9,	'comercial',	'separados_items.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(10,	'comercial',	'Remisiones.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(11,	'comercial',	'historialremisiones.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(12,	'comercial',	'Devoluciones.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(13,	'comercial',	'facturas.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(14,	'comercial',	'facturas_items.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(15,	'comercial',	'MnuFacturacion.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(16,	'comercial',	'notascredito.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(17,	'comercial',	'FactCoti.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(18,	'comercial',	'FacturaCotizacion.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(19,	'comercial',	'cartera.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(20,	'comercial',	'RegistrarIngreso.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(22,	'comercial',	'clientes.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(23,	'comercial',	'proveedores.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(24,	'comercial',	'prod_codbarras.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(25,	'cajero',	'Menu.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(26,	'cajero',	'MnuVentas.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(27,	'cajero',	'VentasRapidasV2.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(28,	'cajero',	'separados.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(29,	'cajero',	'separados_abonos.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(30,	'cajero',	'separados_items.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(31,	'cajero',	'prod_codbarras.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(32,	'cajero',	'facturas_abonos.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(33,	'bodega',	'Menu.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(34,	'bodega',	'MnuInventarios.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(35,	'bodega',	'productosventa.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(36,	'bodega',	'ordenesdecompra.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(37,	'bodega',	'vista_kardex.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(38,	'bodega',	'kardexmercancias.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(39,	'bodega',	'relacioncompras.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(40,	'bodega',	'prod_codbarras.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(41,	'bodega',	'MnuTraslados.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(42,	'bodega',	'traslados_mercancia.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(43,	'bodega',	'CreaTraslado.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(44,	'bodega',	'SubirTraslado.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(45,	'bodega',	'DescargarTraslados.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(46,	'bodega',	'prod_departamentos.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(47,	'bodega',	'prod_sub1.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(48,	'bodega',	'prod_sub2.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(49,	'bodega',	'prod_sub3.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(50,	'bodega',	'prod_sub4.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(51,	'bodega',	'prod_sub5.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(52,	'bodega',	'prod_bajas_altas.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(53,	'bodega',	'DarBajaAlta.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(54,	'bodega',	'MnuInformes.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(55,	'bodega',	'InformeCompras.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(56,	'bodega',	'CrearProductoVenta.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(57,	'bodega',	'InsertarRegistro.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(58,	'bodega',	'EditarRegistro.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(59,	'comercial',	'VentasRestaurante.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(60,	'comercial',	'MnuRestaurante.php',	'SI',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55');

DROP TABLE IF EXISTS `parametros_contables`;
CREATE TABLE `parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(1,	'Cuenta que se utiliza para el iva generado en las operaciones de venta ',	24080501,	'Impuesto sobre las ventas por pagar Generado',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(2,	'Cuenta Costo de venta de la mercancia',	613501,	'Venta de Mercancias No Fabricadas por la Empresa',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(3,	'Cuenta Gasto Para Bajas de Mercancias no fabricadas por la empresa',	529915,	'',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(4,	'Cuenta donde se alojan los inventarios de las mercancias no fabricadas por la empresa',	143501,	'Mercancias No Fabricadas por la Empresa',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(5,	'Cuenta para Realizar el Credito a las altas de un producto',	529915,	'',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(6,	'Cuenta para realizar creditos o debitos a los clientes',	130505,	'CLIENTES NACIONALES',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(7,	'Cuenta para registrar el gasto por otros descuentos cuando se registra un ingreso por cartera',	521095,	'OTROS DESCUENTOS',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(8,	'CUENTA PARA REGISTRAR EL PAGO DE COMISIONES',	520518,	'COMISIONES',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(9,	'Cuenta para registrar la devolucion de una venta',	417501,	'DEVOLUCIONES EN VENTA',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(10,	'CUENTA ORIGEN DE LA CREACION DE UN EGRESO A PARTIR DE UN CONCEPTO CONTABLE CREADO.',	110505,	'CAJA GENERAL',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(11,	'Cuenta para llevar la utilidad del ejercicio',	3605,	'Utilidad del Ejercicio',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(12,	'Cuenta para llevar la perdida del ejercicio',	3610,	'Perdida del Ejercicio',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(13,	'Contrapartida para llevar la perdida o ganancia del ejercicio',	5905,	'Ganancias y perdidas',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(14,	'Cuenta x pagar proveedores',	220505,	'PROVEEDORES NACIONALES',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(15,	'Descuentos en compras por pronto pago',	421040,	'DESCUENTOS COMERCIALES CONDICIONADOS',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(16,	'impuesto generado al consumo de bolsas plasticas',	24081004,	'IMPUESTO AL CONSUMO DE BOLSAS PLASTICAS',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(17,	'Cuenta para registrar los abonos o pagos a los creditos o ventas desde ventas rapidas con tarjetas',	11100501,	'BANCOS',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(18,	'Cuenta para registrar los abonos o pagos en ventas rapidas a los creditos o ventas con Cheques',	11100510,	'BANCOS CHEQUES',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(19,	'Cuenta x pagar Intereses Siste Credito',	220505,	'PROVEEDORES NACIONALES',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(20,	'Anticipos realizados por clientes',	280505,	'ANTICIPOS REALIZADOS POR CLIENTES',	'2019-02-26 20:55:46',	'2019-02-26 15:55:46'),
(21,	'Cuenta para utilizar en operaciones donde el ingreso o la salida van a la caja general, ejemplo facturacion desde Reservas',	110505,	'CAJA GENERAL',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(22,	'Cuenta para contabilizar la compra de materia prima o insumos',	140505,	'Materias Primas',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(23,	'Cuenta para contabilizar el ingreso a inventario de  productos fabricados',	143005,	'Productos Manufacturados',	'2019-01-13 14:12:55',	'2019-01-13 09:12:55'),
(24,	'Retefuente por compra de productos',	236540,	'Retencion en la fuente por compras',	'2019-01-15 21:06:42',	'2019-01-15 16:06:42'),
(25,	'ReteICA por compra de productos',	236801,	'Retencion de industria y comercio',	'2019-01-15 21:19:14',	'2019-01-15 16:19:14'),
(26,	'ReteIVA en Compras',	236701,	'ReteIVA',	'2019-01-15 21:23:26',	'2019-01-15 16:23:26'),
(27,	'Retefuente por compra de servicios',	236525,	'Retencion en la fuente por servicios',	'2019-01-15 21:23:26',	'2019-01-15 16:23:26'),
(28,	'Descuentos Comerciales en compras',	421040,	'Descuentos comerciales condicionados',	'2019-01-15 21:23:26',	'2019-01-15 16:23:26'),
(29,	'Impuestos asumidos, aplica para el impoconsumo cuando no se puede descontar',	531520,	'Impuestos Asumidos',	'2019-01-15 21:23:26',	'2019-01-15 16:23:26'),
(30,	'Cuenta para registrar los abonos o pagos en ventas rapidas a los creditos o ventas con otras formas de pago',	11050599,	'OTRAS FORMAS DE PAGO',	'2019-03-11 16:04:00',	'2019-03-11 11:04:00'),
(31,	'Anticipos realizados por clientes para los separados',	28050501,	'ANTICIPOS REALIZADOS POR CLIENTES EN SEPARADOS',	'2019-02-26 20:55:46',	'2019-02-26 15:55:46'),
(32,	'Retefuente por compra de Honorarios',	236515,	'Retencion en la fuente por honorarios',	'2019-03-30 16:53:40',	'2019-03-30 11:53:40');

DROP TABLE IF EXISTS `parametros_generales`;
CREATE TABLE `parametros_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KardexCotizacion` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `plataforma_tablas`;
CREATE TABLE `plataforma_tablas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `porcentajes_iva` (`ID`, `Nombre`, `Valor`, `ClaseImpuesto`, `Factor`, `CuentaPUC`, `CuentaPUCIVAGenerado`, `NombreCuenta`, `Habilitado`, `Updated`, `Sync`) VALUES
(1,	'Sin IVA',	'0',	'01',	'M',	2408,	2408,	'',	'SI',	'2019-01-13 14:12:57',	'2019-01-13 09:12:57'),
(2,	'Excluidos',	'E',	'01',	'M',	2408,	2408,	'',	'SI',	'2019-01-13 14:12:57',	'2019-01-13 09:12:57'),
(3,	'IVA 5 %',	'0.05',	'01',	'M',	24080503,	24081003,	'Impuestos del 5%',	'SI',	'2019-01-13 14:12:57',	'2019-01-13 09:12:57'),
(4,	'IVA del 8%',	'0.08',	'01',	'M',	24080502,	24081002,	'Impuestos del 8%',	'SI',	'2019-01-13 14:12:57',	'2019-01-13 09:12:57'),
(5,	'IVA del 16%',	'0.16',	'01',	'M',	24080504,	24081004,	'Impuestos del 16%',	'NO',	'2019-01-13 14:12:57',	'2019-01-13 09:12:57'),
(6,	'IVA del 19%',	'0.19',	'01',	'M',	24080501,	24081001,	'Impuestos del 19%',	'SI',	'2019-01-13 14:12:57',	'2019-01-13 09:12:57'),
(7,	'ImpoConsumo Bolsas',	'20',	'02',	'S',	24080511,	24081011,	'IMPUESTO AL CONSUMO DE BOLSAS',	'SI',	'2019-01-13 14:12:57',	'2019-01-13 09:12:57'),
(8,	'impuesto del 1.9%',	'0.019',	'01',	'M',	24080505,	24081005,	'Impuestos del 10% del 19%',	'SI',	'2019-01-13 14:12:57',	'2019-01-13 09:12:57');

DROP TABLE IF EXISTS `precotizacion`;
CREATE TABLE `precotizacion` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NumSolicitud` varchar(45) NOT NULL,
  `Cantidad` double NOT NULL,
  `Multiplicador` int(11) NOT NULL DEFAULT '1',
  `Referencia` varchar(45) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `SubTotal` double NOT NULL,
  `Descripcion` text NOT NULL,
  `IVA` double NOT NULL,
  `Descuento` double NOT NULL,
  `ValorDescuento` double NOT NULL,
  `PrecioCosto` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `Total` double NOT NULL,
  `TipoItem` varchar(10) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `CuentaPUC` varchar(45) NOT NULL,
  `Tabla` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `prestamos_terceros`;
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


DROP TABLE IF EXISTS `prestamos_terceros_abonos`;
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


DROP TABLE IF EXISTS `preventa`;
CREATE TABLE `preventa` (
  `idPrecotizacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Cantidad` double NOT NULL,
  `VestasActivas_idVestasActivas` int(11) NOT NULL,
  `idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `TablaItem` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` text COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `ValorAcordado` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `Descuento` double NOT NULL,
  `Impuestos` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `TotalVenta` double NOT NULL,
  `TipoItem` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idSistema` int(11) NOT NULL,
  `Autorizado` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPrecotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `produccion_actividades`;
CREATE TABLE `produccion_actividades` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idOrdenTrabajo` bigint(20) NOT NULL,
  `Fecha_Planeada_Inicio` date NOT NULL,
  `Fecha_Planeada_Fin` date NOT NULL,
  `Hora_Planeada_Inicio` time NOT NULL,
  `Hora_Planeada_Fin` time NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date NOT NULL,
  `Hora_Inicio` time NOT NULL,
  `Hora_Fin` time NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idMaquina` int(11) NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tiempo_Operacion` float NOT NULL,
  `Pausas_Operativas` float NOT NULL,
  `Pausas_No_Operativas` float NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `produccion_horas_cronograma`;
CREATE TABLE `produccion_horas_cronograma` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Hora` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `produccion_ordenes_trabajo`;
CREATE TABLE `produccion_ordenes_trabajo` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Compromiso_Entrega` date NOT NULL,
  `FechaTerminacion` date NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `TotalHorasPlaneadas` float NOT NULL,
  `TotalHorasEmpleadas` float NOT NULL,
  `Pausas_Operativas` float NOT NULL,
  `Pausas_No_Operativas` float NOT NULL,
  `Tiempo_Operacion` float NOT NULL,
  `ValorSugerido` bigint(20) NOT NULL,
  `ValorMateriales` bigint(20) NOT NULL,
  `ValorCotizado` bigint(20) NOT NULL,
  `ValorFacturado` bigint(20) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Facturado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `produccion_pausas_predefinidas`;
CREATE TABLE `produccion_pausas_predefinidas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Suma` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `produccion_registro_tiempos`;
CREATE TABLE `produccion_registro_tiempos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idActividad` bigint(20) NOT NULL,
  `FechaHora` datetime NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Suma` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosalquiler`;
CREATE TABLE `productosalquiler` (
  `idProductosVenta` int(11) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Existencias` int(11) NOT NULL,
  `EnAlquiler` int(11) NOT NULL,
  `EnBodega` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ImagenRuta` text COLLATE utf8_spanish_ci NOT NULL,
  `PesoUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PesoTotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitarioActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `Kit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa`;
CREATE TABLE `productosventa` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double DEFAULT NULL,
  `CostoTotal` double DEFAULT NULL,
  `CostoUnitarioPromedio` double NOT NULL,
  `CostoTotalPromedio` double NOT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub6` int(11) NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `ValorComision1` int(11) NOT NULL,
  `ValorComision2` int(11) NOT NULL,
  `ValorComision3` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `insKardex` AFTER INSERT ON `productosventa` FOR EACH ROW
BEGIN

SET @fecha=CURDATE();
    INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (@fecha,'ENTRADA','INICIO',NEW.Existencias,NEW.CostoUnitario,NEW.CostoTotal,NEW.idProductosVenta);
    
    INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (@fecha,'SALDOS','INICIO',NEW.Existencias,NEW.CostoUnitario,NEW.CostoTotal,NEW.idProductosVenta);

SET @Dep=LPAD(NEW.Departamento,2,'0');

SET @Sub1=LPAD(NEW.Sub1,2,'0');

SET @id=LPAD(NEW.idProductosVenta,7,'0');
    
    
SET @Codigo=CONCAT(@Dep,@Sub1,@id);

INSERT INTO prod_codbarras (`CodigoBarras`,`ProductosVenta_idProductosVenta`) VALUES (@Codigo,NEW.idProductosVenta);

END;;

DELIMITER ;

DROP TABLE IF EXISTS `productos_impuestos_adicionales`;
CREATE TABLE `productos_impuestos_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreImpuesto` text COLLATE utf8_spanish_ci NOT NULL,
  `idProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorImpuesto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Incluido` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productos_lista_precios`;
CREATE TABLE `productos_lista_precios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productos_precios_adicionales`;
CREATE TABLE `productos_precios_adicionales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `idListaPrecios` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `TablaVenta` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='tabla para agregar precios a los productos';


DROP TABLE IF EXISTS `prod_bajas_altas`;
CREATE TABLE `prod_bajas_altas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoTotal` double NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_bodega`;
CREATE TABLE `prod_bodega` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProductoAlquiler` int(11) NOT NULL,
  `Bodega_idCliente` int(11) NOT NULL,
  `CantidadProd` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras`;
CREATE TABLE `prod_codbarras` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'productosventa',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_comisiones`;
CREATE TABLE `prod_comisiones` (
  `idProd_Comisiones` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Comision` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `P_V` int(2) NOT NULL COMMENT '1 Valor 0 Porcentaje',
  `ValorComision1` double NOT NULL,
  `ValorComision2` double NOT NULL,
  `ValorComision3` double NOT NULL,
  `Porcentaje_Comision` double NOT NULL,
  `Dep_Comision` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProd_Comisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_departamentos`;
CREATE TABLE `prod_departamentos` (
  `idDepartamentos` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoItem` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `ManejaExistencias` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idDepartamentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_kits`;
CREATE TABLE `prod_kits` (
  `idKits` int(11) NOT NULL AUTO_INCREMENT,
  `TablaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ReferenciaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKits`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sinc`;
CREATE TABLE `prod_sinc` (
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `Productos_Sinc` AFTER INSERT ON `prod_sinc` FOR EACH ROW
BEGIN

UPDATE productosventa SET PrecioVenta=NEW.PrecioVenta WHERE Referencia=NEW.Referencia AND Departamento=NEW.Departamento;

UPDATE productosventa SET PrecioMayorista=NEW.PrecioMayorista WHERE Referencia=NEW.Referencia AND Departamento=NEW.Departamento;

END;;

DELIMITER ;

DROP TABLE IF EXISTS `prod_sub1`;
CREATE TABLE `prod_sub1` (
  `idSub1` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub1` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDepartamento` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub2`;
CREATE TABLE `prod_sub2` (
  `idSub2` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub2` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub1` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub3`;
CREATE TABLE `prod_sub3` (
  `idSub3` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub3` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub2` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub4`;
CREATE TABLE `prod_sub4` (
  `idSub4` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub4` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub3` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub4`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub5`;
CREATE TABLE `prod_sub5` (
  `idSub5` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub5` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub4` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub6`;
CREATE TABLE `prod_sub6` (
  `idSub6` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub6` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub5` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub6`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `idProveedores` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int(11) NOT NULL,
  `Num_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DV` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Lugar_Expedicion_Documento` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RazonSocial` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '169',
  `Telefono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Contacto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelContacto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaBancaria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `A_Nombre_De` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TipoCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EntidadBancaria` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `CIUU` int(11) NOT NULL,
  `Cupo` double NOT NULL,
  `CodigoTarjeta` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProveedores`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `publicidad_encabezado_cartel`;
CREATE TABLE `publicidad_encabezado_cartel` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `ColorTitulo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Desde` int(11) NOT NULL,
  `Hasta` int(11) NOT NULL,
  `Mes` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Anio` int(11) NOT NULL,
  `ColorRazonSocial` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ColorPrecios` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ColorBordes` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `publicidad_encabezado_cartel` (`ID`, `Titulo`, `ColorTitulo`, `Desde`, `Hasta`, `Mes`, `Anio`, `ColorRazonSocial`, `ColorPrecios`, `ColorBordes`, `Updated`, `Sync`) VALUES
(1,	'DIA DEL PADRE',	'#ff0000',	1,	30,	'Julio',	2017,	'#ff0000',	'#ff0000',	'#58f1fa',	'2019-01-13 14:14:06',	'2019-01-13 09:14:06');

DROP TABLE IF EXISTS `publicidad_paginas`;
CREATE TABLE `publicidad_paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `recetas_relaciones`;
CREATE TABLE `recetas_relaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ReferenciaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto que se realiza con receta',
  `ReferenciaIngrediente` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio que hace parte de la receta',
  `TablaIngrediente` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'tabla del producto de la receta',
  `Cantidad` double NOT NULL COMMENT 'Cantidad del insumo para crear un producto',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `ReferenciaProducto` (`ReferenciaProducto`),
  KEY `ReferenciaIngrediente` (`ReferenciaIngrediente`),
  KEY `TablaIngrediente` (`TablaIngrediente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `registra_apertura_documentos`;
CREATE TABLE `registra_apertura_documentos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Documento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ConceptoApertura` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `registra_ediciones`;
CREATE TABLE `registra_ediciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Tabla` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Campo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorAnterior` text COLLATE utf8_spanish_ci NOT NULL,
  `ValorNuevo` text COLLATE utf8_spanish_ci NOT NULL,
  `ConsultaRealizada` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `registra_eliminaciones`;
CREATE TABLE `registra_eliminaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Campo` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` text COLLATE utf8_spanish_ci NOT NULL,
  `Causal` text COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idTabla` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idItemEliminado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `TablaOrigen` (`TablaOrigen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `registra_eliminaciones_pedidos_items_restaurant`;
CREATE TABLE `registra_eliminaciones_pedidos_items_restaurant` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `Total` double NOT NULL,
  `idPedido` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `FechaHora` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idPedido` (`idPedido`),
  KEY `idProducto` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `registro_autorizaciones_pos`;
CREATE TABLE `registro_autorizaciones_pos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` datetime NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `TablaItem` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorAcordado` double NOT NULL,
  `Cantidad` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `Total` double NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `registro_basculas`;
CREATE TABLE `registro_basculas` (
  `Gramos` double NOT NULL,
  `idBascula` int(11) NOT NULL,
  `Leido` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `idBascula` (`idBascula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `relacioncompras`;
CREATE TABLE `relacioncompras` (
  `idRelacionCompras` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Documento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitarioAntesIVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TotalAntesIVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idRelacionCompras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `KardexCompras` AFTER INSERT ON `relacioncompras` FOR EACH ROW
BEGIN


SELECT Existencias into @Cantidad FROM productosventa WHERE idProductosVenta=NEW.ProductosVenta_idProductosVenta;


SET @Saldo=@Cantidad+NEW.Cantidad;

SET @PrecioPromedio=NEW.TotalAntesIVA;
          
SET @TotalSaldo=NEW.ValorUnitarioAntesIVA*@Saldo;

    
 INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'ENTRADA',NEW.Documento,NEW.NumDocumento,NEW.Cantidad,NEW.ValorUnitarioAntesIVA,NEW.TotalAntesIVA,NEW.ProductosVenta_idProductosVenta);
    

INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALDOS',NEW.Documento,NEW.NumDocumento,@Saldo,NEW.ValorUnitarioAntesIVA,@TotalSaldo,NEW.ProductosVenta_idProductosVenta);

SELECT Existencias into @Saldoext FROM productosventa WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

SET @Saldoext=@Saldoext+NEW.Cantidad;

UPDATE productosventa SET `Existencias`= @Saldoext WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

UPDATE productosventa SET `CostoUnitario`= NEW.ValorUnitarioAntesIVA WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

UPDATE productosventa SET `CostoTotal`= @TotalSaldo WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;


END;;

DELIMITER ;

DROP TABLE IF EXISTS `remisiones`;
CREATE TABLE `remisiones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Obra` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Retira` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `FechaDespacho` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraDespacho` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ObservacionesRemision` text COLLATE utf8_spanish_ci NOT NULL,
  `Anticipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `rem_devoluciones`;
CREATE TABLE `rem_devoluciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idRemision` int(16) NOT NULL,
  `idItemCotizacion` int(16) NOT NULL,
  `Cantidad` int(16) NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDevolucion` int(16) NOT NULL,
  `FechaDevolucion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `HoraDevolucion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `rem_devoluciones_totalizadas`;
CREATE TABLE `rem_devoluciones_totalizadas` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `FechaDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idRemision` int(16) NOT NULL,
  `TotalDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ObservacionesDevolucion` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(16) NOT NULL,
  `Clientes_idClientes` int(16) NOT NULL,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `rem_pre_devoluciones`;
CREATE TABLE `rem_pre_devoluciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idRemision` int(16) NOT NULL,
  `idItemCotizacion` int(16) NOT NULL,
  `Cantidad` int(16) NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `rem_relaciones`;
CREATE TABLE `rem_relaciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaEntrega` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CantidadEntregada` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `idItemCotizacion` int(11) NOT NULL,
  `idRemision` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `repuestas_forma_pago`;
CREATE TABLE `repuestas_forma_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DiasCartera` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Etiqueta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `repuestas_forma_pago` (`ID`, `DiasCartera`, `Etiqueta`, `Updated`, `Sync`) VALUES
(1,	'Contado',	'Contado',	'2019-01-13 14:14:08',	'2019-01-13 09:14:08'),
(2,	'1',	'Credito a 1 Dia',	'2019-02-27 19:22:38',	'2019-02-27 14:22:38'),
(3,	'8',	'Credito a 8 Dias',	'2019-02-27 19:22:38',	'2019-02-27 14:22:38'),
(4,	'15',	'Credito a 15 Dias',	'2019-02-27 19:23:41',	'2019-02-27 14:23:41'),
(5,	'30',	'Credito a 30 Dias',	'2019-02-27 19:23:41',	'2019-02-27 14:23:41'),
(6,	'60',	'Credito a 60 Dias',	'2019-02-27 19:23:41',	'2019-02-27 14:23:41'),
(7,	'90',	'Credito a 90 Dias',	'2019-02-27 19:23:41',	'2019-02-27 14:23:41'),
(8,	'SisteCredito',	'SisteCredito',	'2019-02-27 19:23:41',	'2019-02-27 14:23:41');

DROP TABLE IF EXISTS `requerimientos_proyectos`;
CREATE TABLE `requerimientos_proyectos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `HorasDesarrollo` double NOT NULL,
  `CostoEstimado` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `reservas_espacios`;
CREATE TABLE `reservas_espacios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraInicial` int(11) NOT NULL,
  `HoraFinal` int(11) NOT NULL,
  `TarifaNormal` double NOT NULL,
  `TarifaMinima` double NOT NULL,
  `TarifaNormal2` double NOT NULL,
  `idProductoRelacionado` bigint(20) NOT NULL COMMENT 'Indica el producto que esta relacionado al momento de realizar una factura',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `reservas_eventos`;
CREATE TABLE `reservas_eventos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idEspacio` int(11) NOT NULL,
  `NombreEvento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFin` datetime NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Tarifa` double NOT NULL,
  `Estado` enum('RE','FA','AN') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'RE' COMMENT 'FA:Facturado,RE:Reservado,AN:Anulado',
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `FechaInicio` (`FechaInicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `respuestas_condicional`;
CREATE TABLE `respuestas_condicional` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `respuestas_condicional` (`ID`, `Valor`, `Updated`, `Sync`) VALUES
(1,	'NO',	'2019-01-13 14:14:09',	'2019-01-13 09:14:09'),
(2,	'SI',	'2019-01-13 14:14:09',	'2019-01-13 09:14:09');

DROP TABLE IF EXISTS `respuestas_tipo_item`;
CREATE TABLE `respuestas_tipo_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `respuestas_tipo_item` (`ID`, `Valor`, `Updated`, `Sync`) VALUES
(1,	'PR',	'2019-01-13 14:14:09',	'2019-01-13 09:14:09'),
(2,	'MO',	'2019-01-13 14:14:09',	'2019-01-13 09:14:09'),
(3,	'AQ',	'2019-01-13 14:14:09',	'2019-01-13 09:14:09');

DROP TABLE IF EXISTS `restaurante_cierres`;
CREATE TABLE `restaurante_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_mesas`;
CREATE TABLE `restaurante_mesas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `restaurante_mesas` (`ID`, `Nombre`, `Capacidad`, `Estado`, `Updated`, `Sync`) VALUES
(1,	'Mesa 1',	4,	'',	'2019-01-16 00:13:44',	'2019-01-15 19:13:44'),
(2,	'Mesa 2',	4,	'',	'2019-01-16 00:13:44',	'2019-01-15 19:13:44'),
(3,	'Mesa 3',	4,	'',	'2019-01-16 00:14:48',	'2019-01-15 19:14:48');

DROP TABLE IF EXISTS `restaurante_pedidos`;
CREATE TABLE `restaurante_pedidos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `Estado` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT '''AB'' Abierto,''FAPE'' pedido facturado, ''FADO'' domicilio facturado, ''DEPE'' pedido descartado, ''DEDO'' domicilios descartados',
  `Tipo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `NombreCliente` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `DireccionEnvio` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelefonoConfirmacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_pedidos_items`;
CREATE TABLE `restaurante_pedidos_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idPedido` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `NombreProducto` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `ProcentajeIVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idPedido` (`idPedido`),
  KEY `Estado` (`Estado`),
  KEY `Estado_2` (`Estado`),
  KEY `Estado_3` (`Estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_registro_propinas`;
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


DROP TABLE IF EXISTS `separados`;
CREATE TABLE `separados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Saldo` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `separados_abonos`;
CREATE TABLE `separados_abonos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idSeparado` bigint(20) unsigned NOT NULL,
  `Valor` double NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `separados_items`;
CREATE TABLE `separados_items` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idSeparado` bigint(20) NOT NULL,
  `TablaItems` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `SubtotalItem` int(11) NOT NULL,
  `IVAItem` int(11) NOT NULL,
  `TotalItem` int(11) NOT NULL,
  `PorcentajeIVA` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioCostoUnitario` int(11) NOT NULL,
  `SubtotalCosto` int(11) NOT NULL,
  `TipoItem` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` int(11) NOT NULL,
  `GeneradoDesde` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumeroIdentificador` int(11) NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `servicios`;
CREATE TABLE `servicios` (
  `idProductosVenta` int(16) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ImagenRuta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `Kit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `servidores`;
CREATE TABLE `servidores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `DataBase` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `servidores` (`ID`, `IP`, `Nombre`, `Usuario`, `Password`, `DataBase`, `Updated`, `Sync`) VALUES
(1,	'35.226.66.89',	'SERVIDOR GENERAL',	'techno',	'pirlo1985',	'techno_ts5_replica',	'2019-03-21 19:35:29',	'2019-03-21 14:35:29'),
(2,	'35.226.66.89',	'SERVIDOR PARA BACKUPS',	'techno',	'pirlo1985',	'techno_ts5_replica',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10');

DROP TABLE IF EXISTS `sistemas`;
CREATE TABLE `sistemas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `sistemas_relaciones`;
CREATE TABLE `sistemas_relaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `idSistema` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `subcuentas`;
CREATE TABLE `subcuentas` (
  `PUC` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cuentas_idPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `Cuentas_idPUC`, `Updated`, `Sync`) VALUES
(1435,	'Mercancias no fabricadas por la empresa',	'0',	'1435',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(4135,	'COMERCIO AL POR MAYOR Y AL POR MENOR',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(6135,	'Mercancias no fabricadas por la empresa',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(110505,	' Caja general',	'0',	'1105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(110510,	' Cajas menores',	'0',	'1105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(110515,	' Moneda extranjera',	'0',	'1105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(111005,	' Moneda nacional',	'0',	'1110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(111010,	' Moneda extranjera',	'0',	'1110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(111505,	' Moneda nacional',	'0',	'1115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(111510,	' Moneda extranjera',	'0',	'1115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(112005,	' Bancos',	'0',	'1120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(112010,	' Corporaciones de ahorro y vivienda',	'0',	'1120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(112015,	' Organismos cooperativos financieros',	'0',	'1120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(112505,	' Rotatorios moneda nacional',	'0',	'1125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(112510,	' Rotatorios moneda extranjera',	'0',	'1125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(112515,	' Especiales moneda nacional',	'0',	'1125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(112520,	' Especiales moneda extranjera',	'0',	'1125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(130505,	'CLIENTES NACIONALES',	NULL,	'1305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(132505,	'CUENTAS X COBRAR A SOCIOS',	NULL,	'1325',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(132510,	'CUENTAS X COBRAR A ACCIONISTAS',	NULL,	'',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(135515,	'Retencion en la Fuente',	'0',	'1355',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(135517,	'Impuesto a las Ventas Retenido',	'0',	'1355',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(135518,	'Impuesto de Industria y Comercio Retenido',	'0',	'1355',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(135595,	'Otros Autorretencion CREE',	'0',	'1355',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(136505,	'VIVIENDA',	NULL,	'1365',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(136510,	'VEHICULOS',	NULL,	'1365',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(136515,	'ESTUDIO',	NULL,	'',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(136520,	'MEDICOS, ODONTOLICOS Y SIMILARES',	NULL,	'',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(136525,	'CALAMIDAD DOMESTICA',	NULL,	'',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(136530,	'RESPONSABILIDADES',	NULL,	'',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(136595,	'OTROS',	NULL,	'',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(137005,	'PARTICULARES CON GARANTIA REAL',	NULL,	'',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(137010,	'PARTICULARES CON GARANTIA PERSONAL',	NULL,	'',	'2019-04-06 19:09:20',	'2019-04-06 14:09:20'),
(140505,	'MATERIAS PRIMAS',	NULL,	'1405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(143005,	'PRODUCTOS MANUFACTURADOS',	NULL,	'1430',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(143501,	'Mercancias no fabricadas por la empresa',	NULL,	'1435',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(152001,	'HERRAMIENTA DE DOTACION',	'0',	'1520',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(152405,	'Muebles y Enseres',	'0',	'1524',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(152410,	'Equipos',	'0',	'1524',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(152495,	'Otros',	'0',	'1524',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(210505,	' Sobregiros',	'0',	'2105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(210510,	' Pagares',	'0',	'2105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(210515,	' Cartas de credito',	'0',	'2105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(210520,	' Aceptaciones bancarias',	'0',	'2105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(211005,	' Sobregiros',	'0',	'2110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(211010,	' Pagares',	'0',	'2110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(211015,	' Cartas de credito',	'0',	'2110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(211020,	' Aceptaciones bancarias',	'0',	'2110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(211505,	' Pagares',	'0',	'2115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(211510,	' Aceptaciones financieras',	'0',	'2115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(211515,	' Cartas de credito',	'0',	'2115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(211520,	' Contratos de arrendamiento financiero (leasi',	'0',	'2115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(212005,	' Pagares',	'0',	'2105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(212010,	' Aceptaciones financieras',	'0',	'2110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(212020,	' Contratos de arrendamiento financiero (leasi',	'0',	'2120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(212505,	' Sobregiros',	'0',	'2125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(212510,	' Pagares',	'0',	'2125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(212515,	' Hipotecarias',	'0',	'2125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213505,	' Acciones',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213510,	' Cuotas o partes de interes social',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213515,	' Bonos',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213520,	' Cedulas',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213525,	' Certificados',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213530,	' Papeles comerciales',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213535,	' Titulos',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213540,	' Aceptaciones bancarias o financieras',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(213595,	' Otros',	'0',	'2135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(214505,	' Gobierno Nacional',	'0',	'2145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(214510,	' Entidades oficiales',	'0',	'2145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(219505,	' Particulares',	'0',	'2195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(219510,	' Compañias vinculadas',	'0',	'2195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(219515,	' Casa matriz',	'0',	'2195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(219520,	' Socios o accionistas',	'0',	'2195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(219525,	' Fondos y cooperativas',	'0',	'2195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(219530,	' Directores',	'0',	'2195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(219595,	' Otras',	'0',	'2195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(220505,	'PROVEEDORES NACIONALES',	NULL,	'2205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233505,	' Gastos financieros',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233510,	' Gastos legales',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233515,	' Libros suscripciones periodicos y revistas',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233520,	' Comisiones',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233525,	' Honorarios',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233530,	' Servicios tecnicos',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233535,	' Servicios de mantenimiento',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233540,	' Arrendamientos',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233545,	' Transportes fletes y acarreos',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233550,	' Servicios publicos',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233555,	' Seguros',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233560,	' Gastos de viaje',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233565,	' Gastos de representacion y relaciones public',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233570,	' Servicios aduaneros',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(233595,	' Otros',	'0',	'2335',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(235505,	' Accionistas',	'0',	'2355',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(235510,	' Socios',	'0',	'2355',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236005,	' Dividendos',	'0',	'2360',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236010,	' Participaciones',	'0',	'2360',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236505,	' Salarios y pagos laborales',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236510,	' Dividendos y/o participaciones',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236515,	' Honorarios',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236520,	' Comisiones',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236525,	' Servicios',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236530,	' Arrendamientos',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236535,	' Rendimientos financieros',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236540,	' Compras',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236545,	' Loterias rifas apuestas y similares',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236550,	' Por pagos al exterior',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236555,	' Por ingresos obtenidos en el exterior',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236560,	' Enajenacion propiedades planta y equipo pers',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236565,	' Por impuesto de timbre',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236570,	' Otras retenciones y patrimonio (CREE)',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236575,	' Autorretenciones',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236701,	'Impuesto a las ventas retenido',	'0',	'2367',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(236801,	'Impuesto de industria y comercio retenido',	'0',	'2368',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237005,	' Aportes a entidades promotoras de salud EPS',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237006,	' Aportes a administradoras de riesgos profesi',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237010,	' Aportes al ICBF SENA y cajas de compensacion',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237015,	' Aportes al FIC',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237025,	' Embargos judiciales',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237030,	' Libranzas',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237035,	' Sindicatos',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237040,	' Cooperativas',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237045,	' Fondos',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(237095,	' Otros',	'0',	'2370',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(238005,	' Depositarios',	'0',	'2380',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(238010,	' Comisionistas de bolsas',	'0',	'2380',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(238015,	' Sociedad administradora-Fondos de inversion',	'0',	'2380',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(238020,	' Reintegros por pagar',	'0',	'2380',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(238025,	' Fondo de perseverancia',	'0',	'2380',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(238030,	' Fondos de cesantias y/o pensiones',	'0',	'2380',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(238035,	' Donaciones asignadas por pagar',	'0',	'2380',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(238095,	' Otros',	'0',	'2380',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(240405,	' Vigencia fiscal corriente',	'0',	'2404',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(240410,	' Vigencias fiscales anteriores',	'0',	'2404',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(240801,	'IVA',	'0',	'2408',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(241205,	' Vigencia fiscal corriente',	'0',	'2412',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(241210,	' Vigencias fiscales anteriores',	'0',	'2412',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(242405,	' Vigencia fiscal corriente',	'0',	'2424',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(242410,	' Vigencias fiscales anteriores',	'0',	'2424',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(243605,	' Vigencia fiscal corriente',	'0',	'2436',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(243610,	' Vigencias fiscales anteriores',	'0',	'2436',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(244405,	' De hidrocarburos',	'0',	'2444',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(244410,	' De minas',	'0',	'2444',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(246405,	' De licores',	'0',	'2464',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(246410,	' De cervezas',	'0',	'2464',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(246415,	' De cigarrillos',	'0',	'2464',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(251005,	' Ley laboral anterior',	'0',	'2510',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(251010,	' Ley 50 de 1990 y normas posteriores',	'0',	'2510',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(253005,	' Primas',	'0',	'2530',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(253010,	' Auxilios',	'0',	'2530',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(253015,	' Dotacion y suministro a trabajadores',	'0',	'2530',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(253020,	' Bonificaciones',	'0',	'2530',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(253025,	' Seguros',	'0',	'2530',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(253095,	' Otras',	'0',	'2530',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260505,	' Intereses',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260510,	' Comisiones',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260515,	' Honorarios',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260520,	' Servicios tecnicos',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260525,	' Transportes fletes y acarreos',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260530,	' Gastos de viaje',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260535,	' Servicios publicos',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260540,	' Regalias',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260545,	' Garantias',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260550,	' Materiales y repuestos',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(260595,	' Otros',	'0',	'2605',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261010,	' Intereses sobre cesantias',	'0',	'2610',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261015,	' Vacaciones',	'0',	'2610',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261020,	' Prima de servicios',	'0',	'2610',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261025,	' Prestaciones extralegales',	'0',	'2610',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261030,	' Viaticos',	'0',	'2610',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261095,	' Otras',	'0',	'2610',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261505,	' De renta y complementarios',	'0',	'2615',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261510,	' De industria y comercio',	'0',	'2615',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261515,	' Tasa por utilizacion de puertos',	'0',	'2615',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261520,	' De vehiculos',	'0',	'2615',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261525,	' De hidrocarburos y minas',	'0',	'2615',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(261595,	' Otros',	'0',	'2615',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(262005,	' Calculo actuarial pensiones de jubilacion',	'0',	'2620',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(262010,	' Pensiones de jubilacion por amortizar (DB)',	'0',	'2620',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(262505,	' Acueducto y alcantarillado',	'0',	'2625',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(262510,	' Energia electrica',	'0',	'2625',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(262515,	' Telefonos',	'0',	'2625',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(262595,	' Otros',	'0',	'2625',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263005,	' Terrenos',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263010,	' Construcciones y edificaciones',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263015,	' Maquinaria y equipo',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263020,	' Equipo de oficina',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263025,	' Equipo de computacion y comunicacion',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263030,	' Equipo medico-cientifico',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263035,	' Equipo de hoteles y restaurantes',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263040,	' Flota y equipo de transporte',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263045,	' Flota y equipo fluvial y/o maritimo',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263050,	' Flota y equipo aereo',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263055,	' Flota y equipo ferreo',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263060,	' Acueductos plantas y redes',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263065,	' Armamento de vigilancia',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263070,	' Envases y empaques',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263075,	' Plantaciones agricolas y forestales',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263080,	' Vias de comunicacion',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263085,	' Pozos artesianos',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263095,	' Otros',	'0',	'2630',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263505,	' Multas y sanciones autoridades administrativ',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263510,	' Intereses por multas y sanciones',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263515,	' Reclamos',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263520,	' Laborales',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263525,	' Civiles',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263530,	' Penales',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263535,	' Administrativos',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263540,	' Comerciales',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(263595,	' Otras',	'0',	'2635',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269505,	' Para beneficencia',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269510,	' Para comunicaciones',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269515,	' Para perdida en transporte',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269520,	' Para operacion',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269525,	' Para proteccion de bienes agotables',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269530,	' Para ajustes en redencion de unidades',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269535,	' Autoseguro',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269540,	' Planes y programas de reforestacion y electr',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(269595,	' Otras',	'0',	'2695',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270505,	' Intereses',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270510,	' Comisiones',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270515,	' Arrendamientos',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270520,	' Honorarios',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270525,	' Servicios tecnicos',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270530,	' De suscriptores',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270535,	' Transportes fletes y acarreos',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270540,	' Mercancia en transito ya vendida',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270545,	' Matriculas y pensiones',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270550,	' Cuotas de administracion',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(270595,	' Otros',	'0',	'2705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(271005,	' Reajuste del sistema',	'0',	'2710',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(272505,	' Por depreciacion flexible',	'0',	'2725',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(272595,	' Diversos',	'0',	'2725',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(272599,	' Ajustes por inflacion',	'0',	'2725',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(280505,	' De clientes',	'0',	'2805',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(280510,	' Sobre contratos',	'0',	'2805',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(280515,	' Para obras en proceso',	'0',	'2805',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(280595,	' Otros',	'0',	'2805',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281005,	' Para futura suscripcion de acciones',	'0',	'2810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281010,	' Para futuro pago de cuotas o derechos social',	'0',	'2810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281015,	' Para garantia en la prestacion de servicios',	'0',	'2810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281020,	' Para garantia de contratos',	'0',	'2810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281025,	' De licitaciones',	'0',	'2810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281030,	' De manejo de bienes',	'0',	'2810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281035,	' Fondo de reserva',	'0',	'2810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281095,	' Otros',	'0',	'2810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281505,	' Valores recibidos para terceros',	'0',	'2815',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(281510,	' Venta por cuenta de terceros',	'0',	'2815',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(282505,	' Cumplimiento obligaciones laborales',	'0',	'2825',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(282510,	' Para estabilidad de obra',	'0',	'2825',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(282515,	' Garantia cumplimiento de contratos',	'0',	'2825',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(283005,	' Indemnizaciones',	'0',	'2830',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(283010,	' Depositos judiciales',	'0',	'2830',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(283505,	' Cuotas netas',	'0',	'2835',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(283510,	' Grupos en formacion',	'0',	'2835',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(289505,	' Prestamos de productos',	'0',	'2895',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(289510,	' Reembolso de costos exploratorios',	'0',	'2895',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(289515,	' Programa de extension agropecuaria',	'0',	'2895',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(292005,	' Valor bonos pensionales',	'0',	'2920',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(292010,	' Bonos pensionales por amortizar (DB)',	'0',	'2920',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(292015,	' Intereses causados sobre bonos pensionales',	'0',	'2920',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(292505,	' Valor titulos pensionales',	'0',	'2925',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(292510,	' Titulos pensionales por amortizar (DB)',	'0',	'2925',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(292515,	' Intereses causados sobre titulos pensionales',	'0',	'2925',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(310505,	'Capital autorizado',	'0',	'3105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(310510,	'Capital por suscribir (DB)',	'0',	'3105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(310515,	'Capital suscrito por cobrar (DB)',	'0',	'3105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(311505,	'Cuotas o partes de inter?s social',	'0',	'3115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(311510,	'Aportes de socios-fondo mutuo de inversi',	'0',	'3115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(311515,	'Contribuci?n de la empresa-fondo mutuo de inv',	'0',	'3115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(311520,	'Suscripciones del p?blico',	'0',	'3115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(320505,	'Prima en colocaci?n de acciones',	'0',	'3205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(320510,	'Prima en colocaci?n de acciones por cobrar (D',	'0',	'3205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(320515,	'Prima en colocaci?n de cuotas o partes de int',	'0',	'3205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(321005,	'En dinero',	'0',	'3210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(321010,	'En valores mobiliarios',	'0',	'3210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(321015,	'En bienes muebles',	'0',	'3210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(321020,	'En bienes inmuebles',	'0',	'3210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(321025,	'En intangibles',	'0',	'3210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(322505,	'De acciones',	'0',	'3225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(322510,	'De cuotas o partes de inter?s social',	'0',	'3225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330505,	'Reserva legal',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330510,	'Reservas por disposiciones fiscales',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330515,	'Reserva para readquisici?n de acciones',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330516,	'Acciones propias readquiridas (DB)',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330517,	'Reserva para readquisici?n de cuotas o partes',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330518,	'Cuotas o partes de inter?s social propias rea',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330520,	'Reserva para extensi?n agropecuaria',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330525,	'Reserva Ley 7? de 1990',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330530,	'Reserva para reposici?n de semovientes',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330535,	'Reserva Ley 4? de 1980',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(330595,	'Otras',	'0',	'3305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331005,	'Para futuras capitalizaciones',	'0',	'3310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331010,	'Para reposici?n de activos',	'0',	'3310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331015,	'Para futuros ensanches',	'0',	'3310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331095,	'Otras',	'0',	'3310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331505,	'Para beneficencia y civismo',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331510,	'Para futuras capitalizaciones',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331515,	'Para futuros ensanches',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331520,	'Para adquisici?n o reposici?n de propiedades,',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331525,	'Para investigaciones y desarrollo',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331530,	'Para fomento econ?mico',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331535,	'Para capital de trabajo',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331540,	'Para estabilizaci?n de rendimientos',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331545,	'A disposici?n del m?ximo ?rgano social',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(331595,	'Otras',	'0',	'3315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340505,	'De capital social',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340510,	'De super?vit de capital',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340515,	'De reservas',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340520,	'De resultados de ejercicios anteriores',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340525,	'De activos en per?odo improductivo',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340530,	'De saneamiento fiscal',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340535,	'De ajustes Decreto 3019 de 1989',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340540,	'De dividendos y participaciones decretadas en',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(340545,	'Super?vit m?todo de participaci',	'0',	'3405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(380505,	'Acciones',	'0',	'3805',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(380510,	'Cuotas o partes de inter?s social',	'0',	'3805',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(380515,	'Derechos fiduciarios',	'0',	'3805',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381004,	'Terrenos',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381006,	'Materiales proyectos petroleros',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381008,	'Construcciones y edificaciones',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381012,	'Maquinaria y equipo',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381016,	'Equipo de oficina',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381020,	'Equipo de computaci?n y comunicaci',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381024,	'Equipo m?dico-cient?fico',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381028,	'Equipo de hoteles y restaurantes',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381032,	'Flota y equipo de transporte',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381036,	'Flota y equipo fluvial y/o mar?timo',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381040,	'Flota y equipo a?reo',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381044,	'Flota y equipo f?rreo',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381048,	'Acueductos, plantas y redes',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381052,	'Armamento de vigilancia',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381056,	'Envases y empaques',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381060,	'Plantaciones agr?colas y forestales',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381064,	'V?as de comunicaci',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381068,	'Minas y canteras',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381072,	'Pozos artesianos',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381076,	'Yacimientos',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(381080,	'Semovientes',	'0',	'3810',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(389505,	'Bienes de arte y cultura',	'0',	'3895',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(389510,	'Bienes entregados en comodato',	'0',	'3895',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(389515,	'Bienes recibidos en pago',	'0',	'3895',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(389520,	'Inventario de semovientes',	'0',	'3895',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410505,	'Cultivo de cereales',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410510,	'Cultivos de hortalizas, legumbres y plantas o',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410515,	'Cultivos de frutas, nueces y plantas arom?tic',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410520,	'Cultivo de caf',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410525,	'Cultivo de flores',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410530,	'Cultivo de ca?a de az?car',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410535,	'Cultivo de algod?n y plantas para material te',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410540,	'Cultivo de banano',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410545,	'Otros cultivos agr?colas',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410550,	'Cr?a de ovejas, cabras, asnos, mulas y burd?g',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410555,	'Cr?a de ganado caballar y vacuno',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410560,	'Producci?n av?cola',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410565,	'Cr?a de otros animales',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410570,	'Servicios agr?colas y ganaderos',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410575,	'Actividad de caza',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410580,	'Actividad de silvicultura',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410595,	'Actividades conexas',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(410599,	'Ajustes por inflaci',	'0',	'4105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411005,	'Actividad de pesca',	'0',	'4110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411010,	'Explotaci?n de criaderos de peces',	'0',	'4110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411095,	'Actividades conexas',	'0',	'4110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411099,	'Ajustes por inflaci',	'0',	'4110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411505,	'Carb',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411510,	'Petr?leo crudo',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411512,	'Gas natural',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411514,	'Servicios relacionados con extracci?n de petr',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411515,	'Minerales de hierro',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411520,	'Minerales metal?feros no ferrosos',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411525,	'Piedra, arena y arcilla',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411527,	'Piedras preciosas',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411528,	'Oro',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411530,	'Otras minas y canteras',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411532,	'Prestaci?n de servicios sector minero',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411595,	'Actividades conexas',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(411599,	'Ajustes por inflaci',	'0',	'4115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412001,	'Producci?n y procesamiento de carnes y produc',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412002,	'Productos de pescado',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412003,	'Productos de frutas, legumbres y hortalizas',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412004,	'Elaboraci?n de aceites y grasas',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412005,	'Elaboraci?n de productos l?cteos',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412006,	'Elaboraci?n de productos de moliner',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412007,	'Elaboraci?n de almidones y derivados',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412008,	'Elaboraci?n de alimentos para animales',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412009,	'Elaboraci?n de productos para panader',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412010,	'Elaboraci?n de az?car y melazas',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412011,	'Elaboraci?n de cacao, chocolate y confiter',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412012,	'Elaboraci?n de pastas y productos farin?ceos',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412013,	'Elaboraci?n de productos de caf',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412014,	'Elaboraci?n de otros productos alimenticios',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412015,	'Elaboraci?n de bebidas alcoh?licas y alcohol ',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412016,	'Elaboraci?n de vinos',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412017,	'Elaboraci?n de bebidas malteadas y de malta',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412018,	'Elaboraci?n de bebidas no alcoh?licas',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412019,	'Elaboraci?n de productos de tabaco',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412020,	'Preparaci?n e hilatura de fibras textiles y t',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412021,	'Acabado de productos textiles',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412022,	'Elaboraci?n de art?culos de materiales textil',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412023,	'Elaboraci?n de tapices y alfombras',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412024,	'Elaboraci?n de cuerdas, cordeles, bramantes y',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412025,	'Elaboraci?n de otros productos textiles',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412026,	'Elaboraci?n de tejidos',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412027,	'Elaboraci?n de prendas de vestir',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412028,	'Preparaci?n, adobo y te?ido de pieles',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412029,	'Curtido, adobo o preparaci?n de cuero',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412030,	'Elaboraci?n de maletas, bolsos y similares',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412031,	'Elaboraci?n de calzado',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412032,	'Producci?n de madera, art?culos de madera y c',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412033,	'Elaboraci?n de pasta y productos de madera, p',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412034,	'Ediciones y publicaciones',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412035,	'Impresi',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412036,	'Servicios relacionados con la edici?n y la im',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412037,	'Reproducci?n de grabaciones',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412038,	'Elaboraci?n de productos de horno de coque',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412039,	'Elaboraci?n de productos de la refinaci?n de ',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412040,	'Elaboraci?n de sustancias qu?micas b?sicas',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412041,	'Elaboraci?n de abonos y compuestos de nitr?ge',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412042,	'Elaboraci?n de pl?stico y caucho sint?tico',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412043,	'Elaboraci?n de productos qu?micos de uso agro',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412044,	'Elaboraci?n de pinturas, tintas y masillas',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412045,	'Elaboraci?n de productos farmac?uticos y bot?',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412046,	'Elaboraci?n de jabones, detergentes y prepara',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412047,	'Elaboraci?n de otros productos qu?micos',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412048,	'Elaboraci?n de fibras',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412049,	'Elaboraci?n de otros productos de caucho',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412050,	'Elaboraci?n de productos de pl?stico',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412051,	'Elaboraci?n de vidrio y productos de vidrio',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412052,	'Elaboraci?n de productos de cer?mica, loza, p',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412053,	'Elaboraci?n de cemento, cal y yeso',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412054,	'Elaboraci?n de art?culos de hormig?n, cemento',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412055,	'Corte, tallado y acabado de la piedra',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412056,	'Elaboraci?n de otros productos minerales no m',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412057,	'Industrias b?sicas y fundici?n de hierro y ac',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412058,	'Productos primarios de metales preciosos y de',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412059,	'Fundici?n de metales no ferrosos',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412060,	'Fabricaci?n de productos met?licos para uso e',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412061,	'Forja, prensado, estampado, laminado de metal',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412062,	'Revestimiento de metales y obras de ingenier?',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412063,	'Fabricaci?n de art?culos de ferreter',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412064,	'Elaboraci?n de otros productos de metal',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412065,	'Fabricaci?n de maquinaria y equipo',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412066,	'Fabricaci?n de equipos de elevaci?n y manipul',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412067,	'Elaboraci?n de aparatos de uso dom?stico',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412068,	'Elaboraci?n de equipo de oficina',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412069,	'Elaboraci?n de pilas y bater?as primarias',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412070,	'Elaboraci?n de equipo de iluminaci',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412071,	'Elaboraci?n de otros tipos de equipo el?ctric',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412072,	'Fabricaci?n de equipos de radio, televisi?n y',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412073,	'Fabricaci?n de aparatos e instrumentos m?dico',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412074,	'Fabricaci?n de instrumentos de medici?n y con',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412075,	'Fabricaci?n de instrumentos de ?ptica y equip',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412076,	'Fabricaci?n de relojes',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412077,	'Fabricaci?n de veh?culos automotores',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412078,	'Fabricaci?n de carrocer?as para automotores',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412079,	'Fabricaci?n de partes piezas y accesorios par',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412080,	'Fabricaci?n y reparaci?n de buques y otras em',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412081,	'Fabricaci?n de locomotoras y material rodante',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412082,	'Fabricaci?n de aeronaves',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412083,	'Fabricaci?n de motocicletas',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412084,	'Fabricaci?n de bicicletas y sillas de ruedas',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412085,	'Fabricaci?n de otros tipos de transporte',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412086,	'Fabricaci?n de muebles',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412087,	'Fabricaci?n de joyas y art?culos conexos',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412088,	'Fabricaci?n de instrumentos de m?sica',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412089,	'Fabricaci?n de art?culos y equipo para deport',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412090,	'Fabricaci?n de juegos y juguetes',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412091,	'Reciclamiento de desperdicios',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412095,	'Productos de otras industrias manufactureras',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412099,	'Ajustes por inflaci',	'0',	'4120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412505,	'Generaci?n, captaci?n y distribuci?n de energ',	'0',	'4125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412510,	'Fabricaci?n de gas y distribuci?n de combusti',	'0',	'4125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412515,	'Captaci?n, depuraci?n y distribuci?n de agua',	'0',	'4125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412595,	'Actividades conexas',	'0',	'4125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(412599,	'Ajustes por inflaci',	'0',	'4125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413005,	'Preparaci?n de terrenos',	'0',	'4130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413010,	'Construcci?n de edificios y obras de ingenier',	'0',	'4130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413015,	'Acondicionamiento de edificios',	'0',	'4130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413020,	'Terminaci?n de edificaciones',	'0',	'4130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413025,	'Alquiler de equipo con operarios',	'0',	'4130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413095,	'Actividades conexas',	'0',	'4130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413099,	'Ajustes por inflaci',	'0',	'4130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413502,	'Venta de veh?culos automotores',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413504,	'Mantenimiento, reparaci?n y lavado de veh?cul',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413506,	'Venta de partes, piezas y accesorios de veh?c',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413508,	'Venta de combustibles s?lidos, l?quidos, gase',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413510,	'Venta de lubricantes, aditivos, llantas y luj',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413512,	'Venta a cambio de retribuci?n o por contrata',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413514,	'Venta de insumos, materias primas agropecuari',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413516,	'Venta de otros insumos y materias primas no a',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413518,	'Venta de animales vivos y cueros',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413520,	'Venta de productos en almacenes no especializ',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413522,	'Venta de productos agropecuarios',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413524,	'Venta de productos textiles, de vestir, de cu',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413526,	'Venta de papel y cart',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413528,	'Venta de libros, revistas, elementos de papel',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413530,	'Venta de juegos, juguetes y art?culos deporti',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413532,	'Venta de instrumentos quir?rgicos y ortop?dic',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413534,	'Venta de art?culos en relojer?as y joyer?as',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413536,	'Venta de electrodom?sticos y muebles',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413538,	'Venta de productos de aseo, farmac?uticos, me',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413540,	'Venta de cubiertos, vajillas, cristaler?a, po',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413542,	'Venta de materiales de construcci?n, fontaner',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413544,	'Venta de pinturas y lacas',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413546,	'Venta de productos de vidrios y marqueter',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413548,	'Venta de herramientas y art?culos de ferreter',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413550,	'Venta de qu?micos',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413552,	'Venta de productos intermedios, desperdicios ',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413554,	'Venta de maquinaria, equipo de oficina y prog',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413556,	'Venta de art?culos en cacharrer?as y miscel?n',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413558,	'Venta de instrumentos musicales',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413560,	'Venta de art?culos en casas de empe?o y prend',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413562,	'Venta de equipo fotogr?fico',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413564,	'Venta de equipo ?ptico y de precisi',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413566,	'Venta de empaques',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413568,	'Venta de equipo profesional y cient?fico',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413570,	'Venta de loter?as, rifas, chance, apuestas y ',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413572,	'Reparaci?n de efectos personales y electrodom',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413595,	'Venta de otros productos',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(413599,	'Ajustes por inflaci',	'0',	'4135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414005,	'Hoteler',	'0',	'4140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414010,	'Campamento y otros tipos de hospedaje',	'0',	'4140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414015,	'Restaurantes',	'0',	'4140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414020,	'Bares y cantinas',	'0',	'4140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414095,	'Actividades conexas',	'0',	'4140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414099,	'Ajustes por inflaci',	'0',	'4140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414505,	'Servicio de transporte por carretera',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414510,	'Servicio de transporte por v?a f?rrea',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414515,	'Servicio de transporte por v?a acu?tica',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414520,	'Servicio de transporte por v?a a?rea',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414525,	'Servicio de transporte por tuber?as',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414530,	'Manipulaci?n de carga',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414535,	'Almacenamiento y dep?sito',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414540,	'Servicios complementarios para el transporte',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414545,	'Agencias de viaje',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414550,	'Otras agencias de transporte',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414555,	'Servicio postal y de correo',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414560,	'Servicio telef?nico',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414565,	'Servicio de tel?grafo',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414570,	'Servicio de transmisi?n de datos',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414575,	'Servicio de radio y televisi?n por cable',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414580,	'Transmisi?n de sonido e im?genes por contrato',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414595,	'Actividades conexas',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(414599,	'Ajustes por inflaci',	'0',	'4145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415005,	'Venta de inversiones',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415010,	'Dividendos de sociedades an?nimas y/o asimila',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415015,	'Participaciones de sociedades limitadas y/o a',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415020,	'Intereses',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415025,	'Reajuste monetario-UPAC (hoy UVR)',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415030,	'Comisiones',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415035,	'Operaciones de descuento',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415040,	'Cuotas de inscripci?n-consorcios',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415045,	'Cuotas de administraci?n-consorcios',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415050,	'Reajuste del sistema-consorcios',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415055,	'Eliminaci?n de suscriptores-consorcios',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415060,	'Cuotas de ingreso o retiro-sociedad administr',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415065,	'Servicios a comisionistas',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415070,	'Inscripciones y cuotas',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415075,	'Recuperaci?n de garant?as',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415080,	'Ingresos m?todo de participaci',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415095,	'Actividades conexas',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415099,	'Ajustes por inflaci',	'0',	'4150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415505,	'Arrendamientos de bienes inmuebles',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415510,	'Inmobiliarias por retribuci?n o contrata',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415515,	'Alquiler equipo de transporte',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415520,	'Alquiler maquinaria y equipo',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415525,	'Alquiler de efectos personales y enseres dom?',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415530,	'Consultor?a en equipo y programas de inform?t',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415535,	'Procesamiento de datos',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415540,	'Mantenimiento y reparaci?n de maquinaria de o',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415545,	'Investigaciones cient?ficas y de desarrollo',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415550,	'Actividades empresariales de consultor',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415555,	'Publicidad',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415560,	'Dotaci?n de personal',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415565,	'Investigaci?n y seguridad',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415570,	'Limpieza de inmuebles',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415575,	'Fotograf',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415580,	'Envase y empaque',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415585,	'Fotocopiado',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415590,	'Mantenimiento y reparaci?n de maquinaria y eq',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415595,	'Actividades conexas',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(415599,	'Ajustes por inflaci',	'0',	'4155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416005,	'Actividades relacionadas con la educaci',	'0',	'4160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416095,	'Actividades conexas',	'0',	'4160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416099,	'Ajustes por inflaci',	'0',	'4160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416505,	'Servicio hospitalario',	'0',	'4165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416510,	'Servicio medico',	'0',	'4165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416515,	'Servicio odontol?gico',	'0',	'4165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416520,	'Servicio de laboratorio',	'0',	'4165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416525,	'Actividades veterinarias',	'0',	'4165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416530,	'Actividades de servicios sociales',	'0',	'4165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416595,	'Actividades conexas',	'0',	'4165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(416599,	'Ajustes por inflaci',	'0',	'4165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417005,	'Eliminaci?n de desperdicios y aguas residuale',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417010,	'Actividades de asociaci',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417015,	'Producci?n y distribuci?n de filmes y videoci',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417020,	'Exhibici?n de filmes y videocintas',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417025,	'Actividad de radio y televisi',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417030,	'Actividad teatral, musical y art?stica',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417035,	'Grabaci?n y producci?n de discos',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417040,	'Entretenimiento y esparcimiento',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417045,	'Agencias de noticias',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417050,	'Lavander?as y similares',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417055,	'Peluquer?as y similares',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417060,	'Servicios funerarios',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417065,	'Zonas francas',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417095,	'Actividades conexas',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417099,	'Ajustes por inflaci',	'0',	'4170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(417599,	'Ajustes por inflaci',	'0',	'4175',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420505,	'Materia prima',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420510,	'Material de desecho',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420515,	'Materiales varios',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420520,	'Productos de diversificaci',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420525,	'Excedentes de exportaci',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420530,	'Envases y empaques',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420535,	'Productos agr?colas',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420540,	'De propaganda',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420545,	'Productos en remate',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420550,	'Combustibles y lubricantes',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(420599,	'Ajustes por inflaci',	'0',	'4205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421005,	'Intereses',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421010,	'Reajuste monetario-UPAC (hoy UVR)',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421015,	'Descuentos amortizados',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421020,	'Diferencia en cambio',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421025,	'Financiaci?n veh?culos',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421030,	'Financiaci?n sistemas de viajes',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421035,	'Aceptaciones bancarias',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421040,	'Descuentos comerciales condicionados',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421045,	'Descuentos bancarios',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421050,	'Comisiones cheques de otras plazas',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421055,	'Multas y recargos',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421060,	'Sanciones cheques devueltos',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421095,	'Otros',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421099,	'Ajustes por inflaci',	'0',	'4210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421505,	'De sociedades an?nimas y/o asimiladas',	'0',	'4215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421510,	'De sociedades limitadas y/o asimiladas',	'0',	'4215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421599,	'Ajustes por inflaci',	'0',	'4215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421805,	'De sociedades an?nimas y/o asimiladas',	'0',	'4218',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(421810,	'De sociedades limitadas y/o asimiladas',	'0',	'4218',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422005,	'Terrenos',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422010,	'Construcciones y edificios',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422015,	'Maquinaria y equipo',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422020,	'Equipo de oficina',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422025,	'Equipo de computaci?n y comunicaci',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422030,	'Equipo m?dico-cient?fico',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422035,	'Equipo de hoteles y restaurantes',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422040,	'Flota y equipo de transporte',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422045,	'Flota y equipo fluvial y/o mar?timo',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422050,	'Flota y equipo a?reo',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422055,	'Flota y equipo f?rreo',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422060,	'Acueductos, plantas y redes',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422062,	'Envases y empaques',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422065,	'Plantaciones agr?colas y forestales',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422070,	'Aer?dromos',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422075,	'Semovientes',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422099,	'Ajustes por inflaci',	'0',	'4220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422505,	'Sobre inversiones',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422510,	'De concesionarios',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422515,	'De actividades financieras',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422520,	'Por venta de servicios de taller',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422525,	'Por venta de seguros',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422530,	'Por ingresos para terceros',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422535,	'Por distribuci?n de pel?culas',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422540,	'Derechos de autor',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422545,	'Derechos de programaci',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(422599,	'Ajustes por inflaci',	'0',	'4225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423005,	'Asesor?as',	'0',	'4230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423010,	'Asistencia t?cnica',	'0',	'4230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423015,	'Administraci?n de vinculadas',	'0',	'4230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423099,	'Ajustes por inflaci',	'0',	'4230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423505,	'De b?scula',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423510,	'De transporte',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423515,	'De prensa',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423520,	'Administrativos',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423525,	'T?cnicos',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423530,	'De computaci',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423535,	'De telefax',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423540,	'Taller de veh?culos',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423545,	'De recepci?n de aeronaves',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423550,	'De transporte programa gas natural',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423555,	'Por contratos',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423560,	'De trilla',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423565,	'De mantenimiento',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423570,	'Al personal',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423575,	'De casino',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423580,	'Fletes',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423585,	'Entre compa??as',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423595,	'Otros',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(423599,	'Ajustes por inflaci',	'0',	'4235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424005,	'Acciones',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424010,	'Cuotas o partes de inter?s social',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424015,	'Bonos',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424020,	'C?dulas',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424025,	'Certificados',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424030,	'Papeles comerciales',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424035,	'T?tulos',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424045,	'Derechos fiduciarios',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424050,	'Obligatorias',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424095,	'Otras',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424099,	'Ajustes por inflaci',	'0',	'4240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424504,	'Terrenos',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424506,	'Materiales industria petrolera',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424508,	'Construcciones en curso',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424512,	'Maquinaria en montaje',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424516,	'Construcciones y edificaciones',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424520,	'Maquinaria y equipo',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424524,	'Equipo de oficina',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424528,	'Equipo de computaci?n y comunicaci',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424532,	'Equipo m?dico-cient?fico',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424536,	'Equipo de hoteles y restaurantes',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424540,	'Flota y equipo de transporte',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424544,	'Flota y equipo fluvial y/o mar?timo',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424548,	'Flota y equipo a?reo',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424552,	'Flota y equipo f?rreo',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424556,	'Acueductos, plantas y redes',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424560,	'Armamento de vigilancia',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424562,	'Envases y empaques',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424564,	'Plantaciones agr?colas y forestales',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424568,	'V?as de comunicaci',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424572,	'Minas y Canteras',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424580,	'Pozos artesianos',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424584,	'Yacimientos',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424588,	'Semovientes',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424599,	'Ajustes por inflaci',	'0',	'4245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424805,	'Intangibles',	'0',	'4248',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424810,	'Otros activos',	'0',	'4248',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(424899,	'Ajustes por inflaci',	'0',	'4248',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425005,	'Deudas malas',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425010,	'Seguros',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425015,	'Reclamos',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425020,	'Reintegro por personal en comisi',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425025,	'Reintegro garant?as',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425030,	'Descuentos concedidos',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425035,	'De provisiones',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425040,	'Gastos bancarios',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425045,	'De depreciaci',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425050,	'Reintegro de otros costos y gastos',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425099,	'Ajustes por inflaci',	'0',	'4250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425505,	'Por siniestro',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425510,	'Por suministros',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425515,	'Lucro cesante compa??as de seguros',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425520,	'Da?o emergente compa??as de seguros',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425525,	'Por p?rdida de mercanc',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425530,	'Por incumplimiento de contratos',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425535,	'De terceros',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425540,	'Por incapacidades ISS',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425595,	'Otras',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(425599,	'Ajustes por inflaci',	'0',	'4255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(426099,	'Ajustes por inflaci',	'0',	'4260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(426599,	'Ajustes por inflaci',	'0',	'4265',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(427599,	'Ajustes por inflaci',	'0',	'4275',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429503,	'CERT',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429505,	'Aprovechamientos',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429507,	'Auxilios',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429509,	'Subvenciones',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429511,	'Ingresos por investigaci?n y desarrollo',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429513,	'Por trabajos ejecutados',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429515,	'Regal?as',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429517,	'Derivados de las exportaciones',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429519,	'Otros ingresos de explotaci',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429521,	'De la actividad ganadera',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429525,	'Derechos y licitaciones',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429530,	'Ingresos por elementos perdidos',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429533,	'Multas y recargos',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429535,	'Preavisos descontados',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429537,	'Reclamos',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429540,	'Recobro de da',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429543,	'Premios',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429545,	'Bonificaciones',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429547,	'Productos descontados',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429549,	'Reconocimientos ISS',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429551,	'Excedentes',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429553,	'Sobrantes de caja',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429555,	'Sobrantes en liquidaci?n fletes',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429557,	'Subsidios estatales',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429559,	'Capacitaci?n distribuidores',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429561,	'De escrituraci',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429563,	'Registro promesas de venta',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429567,	'?tiles, papeler?a y fotocopias',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429571,	'Resultados, matr?culas y traspasos',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429573,	'Decoraciones',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429575,	'Manejo de carga',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429579,	'Historia cl?nica',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429581,	'Ajuste al peso',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429583,	'Llamadas telef?nicas',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429595,	'Otros',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(429599,	'Ajustes por inflaci',	'0',	'4295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470505,	'Inversiones (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470510,	'Inventarios (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470515,	'Propiedades, planta y equipo (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470520,	'Intangibles (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470525,	'Activos diferidos',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470530,	'Otros activos (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470535,	'Pasivos sujetos de ajuste',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470540,	'Patrimonio',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470545,	'Depreciaci?n acumulada (DB)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470550,	'Depreciaci?n diferida (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470555,	'Agotamiento acumulado (DB)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470560,	'Amortizaci?n acumulada (DB)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470565,	'Ingresos operacionales (DB)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470568,	'Devoluciones en ventas (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470570,	'Ingresos no operacionales (DB)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470575,	'Gastos operacionales de administraci?n (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470580,	'Gastos operacionales de ventas (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470585,	'Gastos no operacionales (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470590,	'Compras (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470591,	'Devoluciones en compras (DB)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470592,	'Costo de ventas (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(470594,	'Costos de producci?n o de operaci?n (CR)',	'0',	'4705',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510503,	'Salario integral',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510506,	'Sueldos',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510512,	'Jornales',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510515,	'Horas extras y recargos',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510518,	'Comisiones',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510521,	'Vi?ticos',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510524,	'Incapacidades',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510527,	'Auxilio de transporte',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510530,	'Cesant?as',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510533,	'Intereses sobre cesant?as',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510536,	'Prima de servicios',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510539,	'Vacaciones',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510542,	'Primas extralegales',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510545,	'Auxilios',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510548,	'Bonificaciones',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510551,	'Dotaci?n y suministro a trabajadores',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510554,	'Seguros',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510557,	'Cuotas partes pensiones de jubilaci',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510558,	'Amortizaci?n c?lculo actuarial pensiones de j',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510559,	'Pensiones de jubilaci',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510560,	'Indemnizaciones laborales',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510561,	'Amortizaci?n bonos pensionales',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510562,	'Amortizaci?n t?tulos pensionales',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510563,	'Capacitaci?n al personal',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510566,	'Gastos deportivos y de recreaci',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510568,	'Aportes a administradoras de riesgos profesio',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510569,	'Aportes a entidades promotoras de salud, EPS',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510570,	'Aportes a fondos de pensiones y/o cesant?as',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510572,	'Aportes cajas de compensaci?n familiar',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510575,	'Aportes ICBF',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510578,	'SENA',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510581,	'Aportes sindicales',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510584,	'Gastos m?dicos y drogas',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510595,	'Otros',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(510599,	'Ajustes por inflaci',	'0',	'5105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511005,	'Junta directiva',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511010,	'Revisor?a fiscal',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511015,	'Auditor?a externa',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511020,	'Aval?os',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511025,	'Asesor?a jur?dica',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511030,	'Asesor?a financiera',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511035,	'Asesor?a t?cnica',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511095,	'Otros',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511099,	'Ajustes por inflaci',	'0',	'5110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511505,	'Industria y comercio',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511510,	'De timbres',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511515,	'A la propiedad ra',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511520,	'Derechos sobre instrumentos p?blicos',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511525,	'De valorizaci',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511530,	'De turismo',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511535,	'Tasa por utilizaci?n de puertos',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511540,	'De veh?culos',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511545,	'De espect?culos p?blicos',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511550,	'Cuotas de fomento',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511570,	'IVA descontable',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511595,	'Otros',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(511599,	'Ajustes por inflaci',	'0',	'5115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512005,	'Terrenos',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512010,	'Construcciones y edificaciones',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512015,	'Maquinaria y equipo',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512020,	'Equipo de oficina',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512025,	'Equipo de computaci?n y comunicaci',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512030,	'Equipo m?dico-cient?fico',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512035,	'Equipo de hoteles y restaurantes',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512040,	'Flota y equipo de transporte',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512045,	'Flota y equipo fluvial y/o mar?timo',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512050,	'Flota y equipo a?reo',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512055,	'Flota y equipo f?rreo',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512060,	'Acueductos, plantas y redes',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512065,	'Aer?dromos',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512070,	'Semovientes',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512095,	'Otros',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512099,	'Ajustes por inflaci',	'0',	'5120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512505,	'Contribuciones',	'0',	'5125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512510,	'Afiliaciones y sostenimiento',	'0',	'5125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(512599,	'Ajustes por inflaci',	'0',	'5125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513005,	'Manejo',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513010,	'Cumplimiento',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513015,	'Corriente d?bil',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513020,	'Vida colectiva',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513025,	'Incendio',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513030,	'Terremoto',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513035,	'Sustracci?n y hurto',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513040,	'Flota y equipo de transporte',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513045,	'Flota y equipo fluvial y/o mar?timo',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513050,	'Flota y equipo a?reo',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513055,	'Flota y equipo f?rreo',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513060,	'Responsabilidad civil y extracontractual',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513065,	'Vuelo',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513070,	'Rotura de maquinaria',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513075,	'Obligatorio accidente de tr?nsito',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513080,	'Lucro cesante',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513085,	'Transporte de mercanc',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513095,	'Otros',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513099,	'Ajustes por inflaci',	'0',	'5130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513505,	'Aseo y vigilancia',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513510,	'Temporales',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513515,	'Asistencia t?cnica',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513520,	'Procesamiento electr?nico de datos',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513525,	'Acueducto y alcantarillado',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513530,	'Energ?a el?ctrica',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513535,	'Tel?fono',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513540,	'Correo, portes y telegramas',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513545,	'Fax y t?lex',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513550,	'Transporte, fletes y acarreos',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513555,	'Gas',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513595,	'Otros',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(513599,	'Ajustes por inflaci',	'0',	'5135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514005,	'Notariales',	'0',	'5140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514010,	'Registro mercantil',	'0',	'5140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514015,	'Tr?mites y licencias',	'0',	'5140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514020,	'Aduaneros',	'0',	'5140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514025,	'Consulares',	'0',	'5140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514095,	'Otros',	'0',	'5140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514099,	'Ajustes por inflaci',	'0',	'5140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514505,	'Terrenos',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514510,	'Construcciones y edificaciones',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514515,	'Maquinaria y equipo',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514520,	'Equipo de oficina',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514525,	'Equipo de computaci?n y comunicaci',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514530,	'Equipo m?dico-cient?fico',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514535,	'Equipo de hoteles y restaurantes',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514540,	'Flota y equipo de transporte',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514545,	'Flota y equipo fluvial y/o mar?timo',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514550,	'Flota y equipo a?reo',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514555,	'Flota y equipo f?rreo',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514560,	'Acueductos, plantas y redes',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514565,	'Armamento de vigilancia',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514570,	'V?as de comunicaci',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(514599,	'Ajustes por inflaci',	'0',	'5145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515005,	'Instalaciones el?ctricas',	'0',	'5150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515010,	'Arreglos ornamentales',	'0',	'5150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515015,	'Reparaciones locativas',	'0',	'5150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515095,	'Otros',	'0',	'5150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515099,	'Ajustes por inflaci',	'0',	'5150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515505,	'Alojamiento y manutenci',	'0',	'5155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515510,	'Pasajes fluviales y/o mar?timos',	'0',	'5155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515515,	'Pasajes a?reos',	'0',	'5155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515520,	'Pasajes terrestres',	'0',	'5155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515525,	'Pasajes f?rreos',	'0',	'5155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515595,	'Otros',	'0',	'5155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(515599,	'Ajustes por inflaci',	'0',	'5155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516005,	'Construcciones y edificaciones',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516010,	'Maquinaria y equipo',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516015,	'Equipo de oficina',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516020,	'Equipo de computaci?n y comunicaci',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516025,	'Equipo m?dico-cient?fico',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516030,	'Equipo de hoteles y restaurantes',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516035,	'Flota y equipo de transporte',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516040,	'Flota y equipo fluvial y/o mar?timo',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516045,	'Flota y equipo a?reo',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516050,	'Flota y equipo f?rreo',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516055,	'Acueductos, plantas y redes',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516060,	'Armamento de vigilancia',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516099,	'Ajustes por inflaci',	'0',	'5160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516505,	'V?as de comunicaci',	'0',	'5165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516510,	'Intangibles',	'0',	'5165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516515,	'Cargos diferidos',	'0',	'5165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516595,	'Otras',	'0',	'5165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(516599,	'Ajustes por inflaci',	'0',	'5165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519505,	'Comisiones',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519510,	'Libros, suscripciones, peri?dicos y revistas',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519515,	'M?sica ambiental',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519520,	'Gastos de representaci?n y relaciones p?blica',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519525,	'Elementos de aseo y cafeter',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519530,	'?tiles, papeler?a y fotocopias',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519535,	'Combustibles y lubricantes',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519540,	'Envases y empaques',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519545,	'Taxis y buses',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519550,	'Estampillas',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519555,	'Microfilmaci',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519560,	'Casino y restaurante',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519565,	'Parqueaderos',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519570,	'Indemnizaci?n por da?os a terceros',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519575,	'P?lvora y similares',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519595,	'Otros',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519599,	'Ajustes por inflaci',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519905,	'Inversiones',	'0',	'5199',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519910,	'Deudores',	'0',	'5199',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519915,	'Propiedades, planta y equipo',	'0',	'5199',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519995,	'Otros activos',	'0',	'5199',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(519999,	'Ajustes por inflaci',	'0',	'5199',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520503,	'Salario integral',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520506,	'Sueldos',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520512,	'Jornales',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520515,	'Horas extras y recargos',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520518,	'Comisiones',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520521,	'Vi?ticos',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520524,	'Incapacidades',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520527,	'Auxilio de transporte',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520530,	'Cesant?as',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520533,	'Intereses sobre cesant?as',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520536,	'Prima de servicios',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520539,	'Vacaciones',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520542,	'Primas extralegales',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520545,	'Auxilios',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520548,	'Bonificaciones',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520551,	'Dotaci?n y suministro a trabajadores',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520554,	'Seguros',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520557,	'Cuotas partes pensiones de jubilaci',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520558,	'Amortizaci?n c?lculo actuarial pensiones de j',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520559,	'Pensiones de jubilaci',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520560,	'Indemnizaciones laborales',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520561,	'Amortizaci?n bonos pensionales',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520562,	'Amortizaci?n t?tulos pensionales',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520563,	'Capacitaci?n al personal',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520566,	'Gastos deportivos y de recreaci',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520568,	'Aportes a administradoras de riesgos profesio',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520569,	'Aportes a entidades promotoras de salud, EPS',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520570,	'Aportes a fondos de pensiones y/o cesant?as',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520572,	'Aportes cajas de compensaci?n familiar',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520575,	'Aportes ICBF',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520578,	'SENA',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520581,	'Aportes sindicales',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520584,	'Gastos m?dicos y drogas',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520595,	'Otros',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(520599,	'Ajustes por inflaci',	'0',	'5205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521005,	'Junta directiva',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521010,	'Revisor?a fiscal',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521015,	'Auditor?a externa',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521020,	'Aval?os',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521025,	'Asesor?a jur?dica',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521030,	'Asesor?a financiera',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521035,	'Asesor?a t?cnica',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521095,	'Otros',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521099,	'Ajustes por inflaci',	'0',	'5210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521505,	'Industria y comercio',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521510,	'De timbres',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521515,	'A la propiedad ra',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521520,	'Derechos sobre instrumentos p?blicos',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521525,	'De valorizaci',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521530,	'De turismo',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521535,	'Tasa por utilizaci?n de puertos',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521540,	'De veh?culos',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521545,	'De espect?culos p?blicos',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521550,	'Cuotas de fomento',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521555,	'Licores',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521560,	'Cervezas',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521565,	'Cigarrillos',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521570,	'IVA descontable',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521595,	'Otros',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(521599,	'Ajustes por inflaci',	'0',	'5215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522005,	'Terrenos',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522010,	'Construcciones y edificaciones',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522015,	'Maquinaria y equipo',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522020,	'Equipo de oficina',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522025,	'Equipo de computaci?n y comunicaci',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522030,	'Equipo m?dico-cient?fico',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522035,	'Equipo de hoteles y restaurantes',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522040,	'Flota y equipo de transporte',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522045,	'Flota y equipo fluvial y/o mar?timo',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522050,	'Flota y equipo a?reo',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522055,	'Flota y equipo f?rreo',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522060,	'Acueductos, plantas y redes',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522065,	'Aer?dromos',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522070,	'Semovientes',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522095,	'Otros',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522099,	'Ajustes por inflaci',	'0',	'5220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522505,	'Contribuciones',	'0',	'5225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522510,	'Afiliaciones y sostenimiento',	'0',	'5225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(522599,	'Ajustes por inflaci',	'0',	'5225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523005,	'Manejo',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523010,	'Cumplimiento',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523015,	'Corriente d?bil',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523020,	'Vida colectiva',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523025,	'Incendio',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523030,	'Terremoto',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523035,	'Sustracci?n y hurto',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523040,	'Flota y equipo de transporte',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523045,	'Flota y equipo fluvial y/o mar?timo',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523050,	'Flota y equipo a?reo',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523055,	'Flota y equipo f?rreo',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523060,	'Responsabilidad civil y extracontractual',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523065,	'Vuelo',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523070,	'Rotura de maquinaria',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523075,	'Obligatorio accidente de tr?nsito',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523080,	'Lucro cesante',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523095,	'Otros',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523099,	'Ajustes por inflaci',	'0',	'5230',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523505,	'Aseo y vigilancia',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523510,	'Temporales',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523515,	'Asistencia t?cnica',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523520,	'Procesamiento electr?nico de datos',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523525,	'Acueducto y alcantarillado',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523530,	'Energ?a el?ctrica',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523535,	'Tel?fono',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523540,	'Correo, portes y telegramas',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523545,	'Fax y t?lex',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523550,	'Transporte, fletes y acarreos',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523555,	'Gas',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523560,	'Publicidad, propaganda y promoci',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523595,	'Otros',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(523599,	'Ajustes por inflaci',	'0',	'5235',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524005,	'Notariales',	'0',	'5240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524010,	'Registro mercantil',	'0',	'5240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524015,	'Tr?mites y licencias',	'0',	'5240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524020,	'Aduaneros',	'0',	'5240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524025,	'Consulares',	'0',	'5240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524095,	'Otros',	'0',	'5240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524099,	'Ajustes por inflaci',	'0',	'5240',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524505,	'Terrenos',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524510,	'Construcciones y edificaciones',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524515,	'Maquinaria y equipo',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524520,	'Equipo de oficina',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524525,	'Equipo de computaci?n y comunicaci',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524530,	'Equipo m?dico-cient?fico',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524535,	'Equipo de hoteles y restaurantes',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524540,	'Flota y equipo de transporte',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524545,	'Flota y equipo fluvial y/o mar?timo',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524550,	'Flota y equipo a?reo',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524555,	'Flota y equipo f?rreo',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524560,	'Acueductos, plantas y redes',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524565,	'Armamento de vigilancia',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524570,	'V?as de comunicaci',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(524599,	'Ajustes por inflaci',	'0',	'5245',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525005,	'Instalaciones el?ctricas',	'0',	'5250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525010,	'Arreglos ornamentales',	'0',	'5250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525015,	'Reparaciones locativas',	'0',	'5250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525095,	'Otros',	'0',	'5250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525099,	'Ajustes por inflaci',	'0',	'5250',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525505,	'Alojamiento y manutenci',	'0',	'5255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525510,	'Pasajes fluviales y/o mar?timos',	'0',	'5255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525515,	'Pasajes a?reos',	'0',	'5255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525520,	'Pasajes terrestres',	'0',	'5255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525525,	'Pasajes f?rreos',	'0',	'5255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525595,	'Otros',	'0',	'5255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(525599,	'Ajustes por inflaci',	'0',	'5255',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526005,	'Construcciones y edificaciones',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526010,	'Maquinaria y equipo',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526015,	'Equipo de oficina',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526020,	'Equipo de computaci?n y comunicaci',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526025,	'Equipo m?dico-cient?fico',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526030,	'Equipo de hoteles y restaurantes',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526035,	'Flota y equipo de transporte',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526040,	'Flota y equipo fluvial y/o mar?timo',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526045,	'Flota y equipo a?reo',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526050,	'Flota y equipo f?rreo',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526055,	'Acueductos, plantas y redes',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526060,	'Armamento de vigilancia',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526065,	'Envases y empaques',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526099,	'Ajustes por inflaci',	'0',	'5260',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526505,	'V?as de comunicaci',	'0',	'5265',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526510,	'Intangibles',	'0',	'5265',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526515,	'Cargos diferidos',	'0',	'5265',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526595,	'Otras',	'0',	'5265',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(526599,	'Ajustes por inflaci',	'0',	'5265',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(527099,	'Ajustes por inflaci',	'0',	'5270',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(527505,	'De sociedades an?nimas y/o asimiladas',	'0',	'5275',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(527510,	'De sociedades limitadas y/o asimiladas',	'0',	'5275',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529505,	'Comisiones',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529510,	'Libros, suscripciones, peri?dicos y revistas',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529515,	'M?sica ambiental',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529520,	'Gastos de representaci?n y relaciones p?blica',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529525,	'Elementos de aseo y cafeter',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529530,	'?tiles, papeler?a y fotocopias',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529535,	'Combustibles y lubricantes',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529540,	'Envases y empaques',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529545,	'Taxis y buses',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529550,	'Estampillas',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529555,	'Microfilmaci',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529560,	'Casino y restaurante',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529565,	'Parqueaderos',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529570,	'Indemnizaci?n por da?os a terceros',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529575,	'P?lvora y similares',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529595,	'Otros',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529599,	'Ajustes por inflaci',	'0',	'5295',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529905,	'Inversiones',	'0',	'5299',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529910,	'Deudores',	'0',	'5299',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529915,	'Inventarios',	'0',	'5299',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529920,	'Propiedades, planta y equipo',	'0',	'5299',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529995,	'Otros activos',	'0',	'5299',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(529999,	'Ajustes por inflaci',	'0',	'5299',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530505,	'Gastos bancarios',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530510,	'Reajuste monetario-UPAC (hoy UVR)',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530515,	'Comisiones',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530520,	'Intereses',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530525,	'Diferencia en cambio',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530530,	'Gastos en negociaci?n certificados de cambio',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530535,	'Descuentos comerciales condicionados',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530540,	'Gastos manejo y emisi?n de bonos',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530545,	'Prima amortizada',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530595,	'Otros',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(530599,	'Ajustes por inflaci',	'0',	'5305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531005,	'Venta de inversiones',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531010,	'Venta de cartera',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531015,	'Venta de propiedades, planta y equipo',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531020,	'Venta de intangibles',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531025,	'Venta de otros activos',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531030,	'Retiro de propiedades, planta y equipo',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531035,	'Retiro de otros activos',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531040,	'P?rdidas por siniestros',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531095,	'Otros',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531099,	'Ajustes por inflaci',	'0',	'5310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531305,	'De sociedades an?nimas y/o asimiladas',	'0',	'5313',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531310,	'De sociedades limitadas y/o asimiladas',	'0',	'5313',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531505,	'Costas y procesos judiciales',	'0',	'5315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531510,	'Actividades culturales y c?vicas',	'0',	'5315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531515,	'Costos y gastos de ejercicios anteriores',	'0',	'5315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531520,	'Impuestos asumidos',	'0',	'5315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531595,	'Otros',	'0',	'5315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(531599,	'Ajustes por inflaci',	'0',	'5315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539505,	'Demandas laborales',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539510,	'Demandas por incumplimiento de contratos',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539515,	'Indemnizaciones',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539520,	'Multas, sanciones y litigios',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539525,	'Donaciones',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539530,	'Constituci?n de garant?as',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539535,	'Amortizaci?n de bienes entregados en comodato',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539595,	'Otros',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(539599,	'Ajustes por inflaci',	'0',	'5395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(540505,	'Impuesto de renta y complementarios',	'0',	'5405',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(590505,	'Ganancias y p?rdidas',	'0',	'5905',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610505,	'Cultivo de cereales',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610510,	'Cultivos de hortalizas, legumbres y plantas o',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610515,	'Cultivos de frutas, nueces y plantas arom?tic',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610520,	'Cultivo de caf',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610525,	'Cultivo de flores',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610530,	'Cultivo de ca?a de az?car',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610535,	'Cultivo de algod?n y plantas para material te',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610540,	'Cultivo de banano',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610545,	'Otros cultivos agr?colas',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610550,	'Cr?a de ovejas, cabras, asnos, mulas y burd?g',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610555,	'Cr?a de ganado caballar y vacuno',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610560,	'Producci?n av?cola',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610565,	'Cr?a de otros animales',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610570,	'Servicios agr?colas y ganaderos',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610575,	'Actividad de caza',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610580,	'Actividad de silvicultura',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610595,	'Actividades conexas',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(610599,	'Ajustes por inflaci',	'0',	'6105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611005,	'Actividad de pesca',	'0',	'6110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611010,	'Explotaci?n de criaderos de peces',	'0',	'6110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611095,	'Actividades conexas',	'0',	'6110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611099,	'Ajustes por inflaci',	'0',	'6110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611505,	'Carb',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611510,	'Petr?leo crudo',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611512,	'Gas natural',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611514,	'Servicios relacionados con extracci?n de petr',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611515,	'Minerales de hierro',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611520,	'Minerales metal?feros no ferrosos',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611525,	'Piedra, arena y arcilla',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611527,	'Piedras preciosas',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611528,	'Oro',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611530,	'Otras minas y canteras',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611532,	'Prestaci?n de servicios sector minero',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611595,	'Actividades conexas',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(611599,	'Ajustes por inflaci',	'0',	'6115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612001,	'Producci?n y procesamiento de carnes y produc',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612002,	'Productos de pescado',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612003,	'Productos de frutas, legumbres y hortalizas',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612004,	'Elaboraci?n de aceites y grasas',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612005,	'Elaboraci?n de productos l?cteos',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612006,	'Elaboraci?n de productos de moliner',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612007,	'Elaboraci?n de almidones y derivados',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612008,	'Elaboraci?n de alimentos para animales',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612009,	'Elaboraci?n de productos para panader',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612010,	'Elaboraci?n de az?car y melazas',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612011,	'Elaboraci?n de cacao, chocolate y confiter',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612012,	'Elaboraci?n de pastas y productos farin?ceos',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612013,	'Elaboraci?n de productos de caf',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612014,	'Elaboraci?n de otros productos alimenticios',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612015,	'Elaboraci?n de bebidas alcoh?licas y alcohol ',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612016,	'Elaboraci?n de vinos',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612017,	'Elaboraci?n de bebidas malteadas y de malta',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612018,	'Elaboraci?n de bebidas no alcoh?licas',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612019,	'Elaboraci?n de productos de tabaco',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612020,	'Preparaci?n e hilatura de fibras textiles y t',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612021,	'Acabado de productos textiles',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612022,	'Elaboraci?n de art?culos de materiales textil',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612023,	'Elaboraci?n de tapices y alfombras',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612024,	'Elaboraci?n de cuerdas, cordeles, bramantes y',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612025,	'Elaboraci?n de otros productos textiles',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612026,	'Elaboraci?n de tejidos',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612027,	'Elaboraci?n de prendas de vestir',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612028,	'Preparaci?n, adobo y te?ido de pieles',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612029,	'Curtido, adobo o preparaci?n de cuero',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612030,	'Elaboraci?n de maletas, bolsos y similares',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612031,	'Elaboraci?n de calzado',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612032,	'Producci?n de madera, art?culos de madera y c',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612033,	'Elaboraci?n de pasta y productos de madera, p',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612034,	'Ediciones y publicaciones',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612035,	'Impresi',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612036,	'Servicios relacionados con la edici?n y la im',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612037,	'Reproducci?n de grabaciones',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612038,	'Elaboraci?n de productos de horno de coque',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612039,	'Elaboraci?n de productos de la refinaci?n de ',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612040,	'Elaboraci?n de sustancias qu?micas b?sicas',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612041,	'Elaboraci?n de abonos y compuestos de nitr?ge',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612042,	'Elaboraci?n de pl?stico y caucho sint?tico',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612043,	'Elaboraci?n de productos qu?micos de uso agro',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612044,	'Elaboraci?n de pinturas, tintas y masillas',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612045,	'Elaboraci?n de productos farmac?uticos y bot?',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612046,	'Elaboraci?n de jabones, detergentes y prepara',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612047,	'Elaboraci?n de otros productos qu?micos',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612048,	'Elaboraci?n de fibras',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612049,	'Elaboraci?n de otros productos de caucho',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612050,	'Elaboraci?n de productos de pl?stico',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612051,	'Elaboraci?n de vidrio y productos de vidrio',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612052,	'Elaboraci?n de productos de cer?mica, loza, p',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612053,	'Elaboraci?n de cemento, cal y yeso',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612054,	'Elaboraci?n de art?culos de hormig?n, cemento',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612055,	'Corte, tallado y acabado de la piedra',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612056,	'Elaboraci?n de otros productos minerales no m',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612057,	'Industrias b?sicas y fundici?n de hierro y ac',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612058,	'Productos primarios de metales preciosos y de',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612059,	'Fundici?n de metales no ferrosos',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612060,	'Fabricaci?n de productos met?licos para uso e',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612061,	'Forja, prensado, estampado, laminado de metal',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612062,	'Revestimiento de metales y obras de ingenier?',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612063,	'Fabricaci?n de art?culos de ferreter',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612064,	'Elaboraci?n de otros productos de metal',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612065,	'Fabricaci?n de maquinaria y equipo',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612066,	'Fabricaci?n de equipos de elevaci?n y manipul',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612067,	'Elaboraci?n de aparatos de uso dom?stico',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612068,	'Elaboraci?n de equipo de oficina',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612069,	'Elaboraci?n de pilas y bater?as primarias',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612070,	'Elaboraci?n de equipo de iluminaci',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612071,	'Elaboraci?n de otros tipos de equipo el?ctric',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612072,	'Fabricaci?n de equipos de radio, televisi?n y',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612073,	'Fabricaci?n de aparatos e instrumentos m?dico',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612074,	'Fabricaci?n de instrumentos de medici?n y con',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612075,	'Fabricaci?n de instrumentos de ?ptica y equip',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612076,	'Fabricaci?n de relojes',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612077,	'Fabricaci?n de veh?culos automotores',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612078,	'Fabricaci?n de carrocer?as para automotores',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612079,	'Fabricaci?n de partes, piezas y accesorios pa',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612080,	'Fabricaci?n y reparaci?n de buques y otras em',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612081,	'Fabricaci?n de locomotoras y material rodante',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612082,	'Fabricaci?n de aeronaves',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612083,	'Fabricaci?n de motocicletas',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612084,	'Fabricaci?n de bicicletas y sillas de ruedas',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612085,	'Fabricaci?n de otros tipos de transporte',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612086,	'Fabricaci?n de muebles',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612087,	'Fabricaci?n de joyas y art?culos conexos',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612088,	'Fabricaci?n de instrumentos de m?sica',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612089,	'Fabricaci?n de art?culos y equipo para deport',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612090,	'Fabricaci?n de juegos y juguetes',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612091,	'Reciclamiento de desperdicios',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612095,	'Productos de otras industrias manufactureras',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612099,	'Ajustes por inflaci',	'0',	'6120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612505,	'Generaci?n, captaci?n y distribuci?n de energ',	'0',	'6125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612510,	'Fabricaci?n de gas y distribuci?n de combusti',	'0',	'6125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612515,	'Captaci?n, depuraci?n y distribuci?n de agua',	'0',	'6125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612595,	'Actividades conexas',	'0',	'6125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(612599,	'Ajustes por inflaci',	'0',	'6125',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613005,	'Preparaci?n de terrenos',	'0',	'6130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613010,	'Construcci?n de edificios y obras de ingenier',	'0',	'6130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613015,	'Acondicionamiento de edificios',	'0',	'6130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613020,	'Terminaci?n de edificaciones',	'0',	'6130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613025,	'Alquiler de equipo con operario',	'0',	'6130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613095,	'Actividades conexas',	'0',	'6130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613099,	'Ajustes por inflaci',	'0',	'6130',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613502,	'Venta de veh?culos automotores',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613504,	'Mantenimiento, reparaci?n y lavado de veh?cul',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613506,	'Venta de partes, piezas y accesorios de veh?c',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613508,	'Venta de combustibles s?lidos, l?quidos, gase',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613510,	'Venta de lubricantes, aditivos, llantas y luj',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613512,	'Venta a cambio de retribuci?n o por contrata',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613514,	'Venta de insumos, materias primas agropecuari',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613516,	'Venta de otros insumos y materias primas no a',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613518,	'Venta de animales vivos y cueros',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613520,	'Venta de productos en almacenes no especializ',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613522,	'Venta de productos agropecuarios',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613524,	'Venta de productos textiles, de vestir, de cu',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613526,	'Venta de papel y cart',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613528,	'Venta de libros, revistas, elementos de papel',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613530,	'Venta de juegos, juguetes y art?culos deporti',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613532,	'Venta de instrumentos quir?rgicos y ortop?dic',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613534,	'Venta de art?culos en relojer?as y joyer?as',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613536,	'Venta de electrodom?sticos y muebles',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613538,	'Venta de productos de aseo, farmac?uticos, me',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613540,	'Venta de cubiertos, vajillas, cristaler?a, po',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613542,	'Venta de materiales de construcci?n, fontaner',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613544,	'Venta de pinturas y lacas',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613546,	'Venta de productos de vidrios y marqueter',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613548,	'Venta de herramientas y art?culos de ferreter',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613550,	'Venta de qu?micos',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613552,	'Venta de productos intermedios, desperdicios ',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613554,	'Venta de maquinaria, equipo de oficina y prog',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613556,	'Venta de art?culos en cacharrer?as y miscel?n',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613558,	'Venta de instrumentos musicales',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613560,	'Venta de art?culos en casas de empe?o y prend',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613562,	'Venta de equipo fotogr?fico',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613564,	'Venta de equipo ?ptico y de precisi',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613566,	'Venta de empaques',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613568,	'Venta de equipo profesional y cient?fico',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613570,	'Venta de loter?as, rifas, chance, apuestas y ',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613572,	'Reparaci?n de efectos personales y electrodom',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613595,	'Venta de otros productos',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(613599,	'Ajustes por inflaci',	'0',	'6135',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614005,	'Hoteler',	'0',	'6140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614010,	'Campamento y otros tipos de hospedaje',	'0',	'6140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614015,	'Restaurantes',	'0',	'6140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614020,	'Bares y cantinas',	'0',	'6140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614095,	'Actividades conexas',	'0',	'6140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614099,	'Ajustes por inflaci',	'0',	'6140',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614505,	'Servicio de transporte por carretera',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614510,	'Servicio de transporte por v?a f?rrea',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614515,	'Servicio de transporte por v?a acu?tica',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614520,	'Servicio de transporte por v?a a?rea',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614525,	'Servicio de transporte por tuber?as',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614530,	'Manipulaci?n de carga',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614535,	'Almacenamiento y dep?sito',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614540,	'Servicios complementarios para el transporte',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614545,	'Agencias de viaje',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614550,	'Otras agencias de transporte',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614555,	'Servicio postal y de correo',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614560,	'Servicio telef?nico',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614565,	'Servicio de tel?grafo',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614570,	'Servicio de transmisi?n de datos',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614575,	'Servicio de radio y televisi?n por cable',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614580,	'Transmisi?n de sonido e im?genes por contrato',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614595,	'Actividades conexas',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(614599,	'Ajustes por inflaci',	'0',	'6145',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615005,	'De inversiones',	'0',	'6150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615010,	'De servicio de bolsa',	'0',	'6150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615099,	'Ajustes por inflaci',	'0',	'6150',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615505,	'Arrendamientos de bienes inmuebles',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615510,	'Inmobiliarias por retribuci?n o contrata',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615515,	'Alquiler equipo de transporte',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615520,	'Alquiler maquinaria y equipo',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615525,	'Alquiler de efectos personales y enseres dom?',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615530,	'Consultor?a en equipo y programas de inform?t',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615535,	'Procesamiento de datos',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615540,	'Mantenimiento y reparaci?n de maquinaria de o',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615545,	'Investigaciones cient?ficas y de desarrollo',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615550,	'Actividades empresariales de consultor',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615555,	'Publicidad',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615560,	'Dotaci?n de personal',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615565,	'Investigaci?n y seguridad',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615570,	'Limpieza de inmuebles',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615575,	'Fotograf',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615580,	'Envase y empaque',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615585,	'Fotocopiado',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615590,	'Mantenimiento y reparaci?n de maquinaria y eq',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615595,	'Actividades conexas',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(615599,	'Ajustes por inflaci',	'0',	'6155',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616005,	'Actividades relacionadas con la educaci',	'0',	'6160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616095,	'Actividades conexas',	'0',	'6160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616099,	'Ajustes por inflaci',	'0',	'6160',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616505,	'Servicio hospitalario',	'0',	'6165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616510,	'Servicio m?dico',	'0',	'6165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616515,	'Servicio odontol?gico',	'0',	'6165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616520,	'Servicio de laboratorio',	'0',	'6165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616525,	'Actividades veterinarias',	'0',	'6165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616530,	'Actividades de servicios sociales',	'0',	'6165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616595,	'Actividades conexas',	'0',	'6165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(616599,	'Ajustes por inflaci',	'0',	'6165',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617005,	'Eliminaci?n de desperdicios y aguas residuale',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617010,	'Actividades de asociaci',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617015,	'Producci?n y distribuci?n de filmes y videoci',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617020,	'Exhibici?n de filmes y videocintas',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617025,	'Actividad de radio y televisi',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617030,	'Actividad teatral, musical y art?stica',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617035,	'Grabaci?n y producci?n de discos',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617040,	'Entretenimiento y esparcimiento',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617045,	'Agencias de noticias',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617050,	'Lavander?as y similares',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617055,	'Peluquer?as y similares',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617060,	'Servicios funerarios',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617065,	'Zonas francas',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617095,	'Actividades conexas',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(617099,	'Ajustes por inflaci',	'0',	'6170',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(620599,	'Ajustes por inflaci',	'0',	'6205',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(621099,	'Ajustes por inflaci',	'0',	'6210',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(621599,	'Ajustes por inflaci',	'0',	'6215',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(622099,	'Ajustes por inflaci',	'0',	'6220',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(622599,	'Ajustes por inflaci',	'0',	'6225',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(810505,	'Valores mobiliarios',	'0',	'8105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(810510,	'Bienes muebles',	'0',	'8105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(810599,	'Ajustes por inflaci',	'0',	'8105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811005,	'Valores mobiliarios',	'0',	'8110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811010,	'Bienes muebles',	'0',	'8110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811015,	'Bienes inmuebles',	'0',	'8110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811020,	'Contratos de ganado en participaci',	'0',	'8110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811099,	'Ajustes por inflaci',	'0',	'8110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811505,	'En arrendamiento',	'0',	'8115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811510,	'En pr?stamo',	'0',	'8115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811515,	'En dep?sito',	'0',	'8115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811520,	'En consignaci',	'0',	'8115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(811599,	'Ajustes por inflaci',	'0',	'8115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(812005,	'Ejecutivos',	'0',	'8120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(812010,	'Incumplimiento de contratos',	'0',	'8120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(819505,	'Valores adquiridos por recibir',	'0',	'8195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(819595,	'Otras',	'0',	'8195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(819599,	'Ajustes por inflaci',	'0',	'8195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(830505,	'Bienes muebles',	'0',	'8305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(830510,	'Bienes inmuebles',	'0',	'8305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(830599,	'Ajustes por inflaci',	'0',	'8305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831005,	'Acciones',	'0',	'8310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831010,	'Bonos',	'0',	'8310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831095,	'Otros',	'0',	'8310',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831506,	'Materiales proyectos petroleros',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831516,	'Construcciones y edificaciones',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831520,	'Maquinaria y equipo',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831524,	'Equipo de oficina',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831528,	'Equipo de computaci?n y comunicaci',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831532,	'Equipo m?dico-cient?fico',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831536,	'Equipo de hoteles y restaurantes',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831540,	'Flota y equipo de transporte',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831544,	'Flota y equipo fluvial y/o mar?timo',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831548,	'Flota y equipo a?reo',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831552,	'Flota y equipo f?rreo',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831556,	'Acueductos, plantas y redes',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831560,	'Armamento de vigilancia',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831562,	'Envases y empaques',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831564,	'Plantaciones agr?colas y forestales',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831568,	'V?as de comunicaci',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831572,	'Minas y canteras',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831576,	'Pozos artesianos',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831580,	'Yacimientos',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831584,	'Semovientes',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(831599,	'Ajustes por inflaci',	'0',	'8315',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(832005,	'Pa',	'0',	'8320',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(832010,	'Exterior',	'0',	'8320',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(832505,	'Inversiones',	'0',	'8325',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(832510,	'Deudores',	'0',	'8325',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(832595,	'Otros activos',	'0',	'8325',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(833005,	'Bonos',	'0',	'8330',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(833095,	'Otros',	'0',	'8330',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839505,	'Cheques posfechados',	'0',	'8395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839510,	'Certificados de dep?sito a t?rmino',	'0',	'8395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839515,	'Cheques devueltos',	'0',	'8395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839520,	'Bienes y valores en fideicomiso',	'0',	'8395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839525,	'Intereses sobre deudas vencidas',	'0',	'8395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839595,	'Diversas',	'0',	'8395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839599,	'Ajustes por inflaci',	'0',	'8395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839905,	'Inversiones',	'0',	'8399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839910,	'Inventarios',	'0',	'8399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839915,	'Propiedades, planta y equipo',	'0',	'8399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839920,	'Intangibles',	'0',	'8399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839925,	'Cargos diferidos',	'0',	'8399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(839995,	'Otros activos',	'0',	'8399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(910505,	'Valores mobiliarios',	'0',	'9105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(910510,	'Bienes muebles',	'0',	'9105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(910599,	'Ajustes por inflaci',	'0',	'9105',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911005,	'Valores mobiliarios',	'0',	'9110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911010,	'Bienes muebles',	'0',	'9110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911015,	'Bienes inmuebles',	'0',	'9110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911020,	'Contratos de ganado en participaci',	'0',	'9110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911099,	'Ajustes por inflaci',	'0',	'9110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911505,	'En arrendamiento',	'0',	'9115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911510,	'En pr?stamo',	'0',	'9115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911515,	'En dep?sito',	'0',	'9115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911520,	'En consignaci',	'0',	'9115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911525,	'En comodato',	'0',	'9115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(911599,	'Ajustes por inflaci',	'0',	'9115',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(912005,	'Laborales',	'0',	'9120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(912010,	'Civiles',	'0',	'9120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(912015,	'Administrativos o arbitrales',	'0',	'9120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(912020,	'Tributarios',	'0',	'9120',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(930505,	'Bienes muebles',	'0',	'9305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(930510,	'Bienes inmuebles',	'0',	'9305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939505,	'Documentos por cobrar descontados',	'0',	'9395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939510,	'Convenios de pago',	'0',	'9395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939515,	'Contratos de construcciones e instalaciones p',	'0',	'9395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939525,	'Adjudicaciones pendientes de legalizar',	'0',	'9395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939530,	'Reserva art?culo 3? Ley 4? de 1980',	'0',	'9395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939535,	'Reserva costo reposici?n semovientes',	'0',	'9395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939595,	'Diversas',	'0',	'9395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939599,	'Ajustes por inflaci',	'0',	'9395',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939905,	'Capital social',	'0',	'9399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939910,	'Super?vit de capital',	'0',	'9399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939915,	'Reservas',	'0',	'9399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939925,	'Dividendos o participaciones decretadas en ac',	'0',	'9399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(939930,	'Resultados de ejercicios anteriores',	'0',	'9399',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(11100501,	'CUENTA DE AHORROS DAVIVIENDA',	'0',	'1110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(11100502,	'CHEQUES RECIBIDOS',	NULL,	'1110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(11100503,	'BONOS U OTROS RECIBIDOS',	NULL,	'1110',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(13050517,	'CLIENTES NACIONALES SEGURIDAD ATLAS LTDA',	'0',	'1305',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(13559503,	'CUENTAS X COBRAR ANTICIPOS X GASTOS',	NULL,	'1355',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(23657502,	'Autorretenciones (CREE)',	'0',	'2365',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(24080218,	'IVA DESCONTABLE X SERVICIOS Y GASTOS',	NULL,	'2408',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(24081004,	'IMPUESTO AL CONSUMO DE BOLSAS PLASTICAS',	NULL,	'2408',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10'),
(51950101,	'Peajes',	'0',	'5195',	'2019-01-13 14:14:10',	'2019-01-13 09:14:10');

DROP TABLE IF EXISTS `subcuentas_equivalencias_niif`;
CREATE TABLE `subcuentas_equivalencias_niif` (
  `CuentaNIIF` int(11) NOT NULL,
  `NombreCuentaNIIF` int(11) NOT NULL,
  `Equivale_A` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaNIIF`),
  UNIQUE KEY `Equivale_A` (`Equivale_A`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tablas_campos_control`;
CREATE TABLE `tablas_campos_control` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreTabla` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Campo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Visible` int(1) NOT NULL,
  `Editable` int(1) NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `TipoUser` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tablas_campos_control` (`ID`, `NombreTabla`, `Campo`, `Visible`, `Editable`, `Habilitado`, `TipoUser`, `idUser`, `Updated`, `Sync`) VALUES
(1,	'usuarios',	'Password',	0,	1,	0,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(3,	'usuarios',	'Nombre',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(4,	'usuarios',	'Apellido',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(6,	'usuarios',	'Sync',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(7,	'usuarios',	'idUsuarios',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(8,	'usuarios',	'Updated',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(9,	'usuarios',	'Telefono',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(10,	'usuarios',	'Login',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(11,	'usuarios',	'Role',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(12,	'usuarios',	'Identificacion',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(13,	'clientes',	'CIUU',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(14,	'clientes',	'Lugar_Expedicion_Documento',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(15,	'clientes',	'Cod_Dpto',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(16,	'clientes',	'Pais_Domicilio',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(17,	'clientes',	'Cod_Mcipio',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(18,	'clientes',	'Contacto',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(19,	'clientes',	'TelContacto',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(20,	'clientes',	'Soporte',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(21,	'clientes',	'Updated',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(22,	'clientes',	'Sync',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(23,	'salud_archivo_facturacion_mov_generados',	'valor_neto_pagar',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(24,	'salud_archivo_facturacion_mov_generados',	'valor_descuentos',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(25,	'salud_archivo_facturacion_mov_generados',	'razon_social',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(26,	'salud_archivo_facturacion_mov_generados',	'cod_prest_servicio',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(27,	'usuarios',	'TipoUser',	0,	1,	1,	'administrador',	3,	'2019-02-01 21:23:16',	'2019-02-01 16:23:16'),
(28,	'usuarios',	'Email',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(29,	'clientes',	'Tipo_Documento',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(30,	'clientes',	'Telefono',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(31,	'clientes',	'Ciudad',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(32,	'clientes',	'Email',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(33,	'clientes',	'Cupo',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(34,	'costos',	'Updated',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(35,	'costos',	'Sync',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(36,	'costos',	'ValorCosto',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(37,	'costos',	'idCostos',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(38,	'costos',	'NombreCosto',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(39,	'facturas',	'idResolucion',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(40,	'facturas',	'TipoFactura',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(41,	'facturas',	'OCompra',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(42,	'facturas',	'OSalida',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(43,	'facturas',	'Descuentos',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(44,	'facturas',	'Cotizaciones_idCotizaciones',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(45,	'facturas',	'EmpresaPro_idEmpresaPro',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(46,	'facturas',	'CentroCosto',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(47,	'facturas',	'idSucursal',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(48,	'facturas',	'Usuarios_idUsuarios',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(49,	'facturas',	'CerradoDiario',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(50,	'facturas',	'FechaCierreDiario',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(51,	'facturas',	'HoraCierreDiario',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(52,	'facturas',	'Efectivo',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(53,	'facturas',	'Devuelve',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(54,	'facturas',	'Cheques',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(55,	'facturas',	'Otros',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(56,	'facturas',	'Tarjetas',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(57,	'facturas',	'idTarjetas',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(58,	'facturas',	'Updated',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(59,	'facturas',	'Sync',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(60,	'modelos_db',	'Updated',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(61,	'modelos_db',	'Sync',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(62,	'vista_cierres_restaurante',	'Fecha',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(63,	'documentos_contables_items',	'idDocumento',	0,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(64,	'empresapro',	'CXPAutomaticas',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(65,	'empresapro',	'FacturaSinInventario',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(66,	'empresapro',	'RutaImagen',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(67,	'empresapro',	'DatosBancarios',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(68,	'empresapro',	'PuntoEquilibrio',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(69,	'empresapro',	'ObservacionesLegales',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(70,	'empresapro',	'WEB',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(71,	'empresapro',	'Email',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(72,	'empresapro',	'MatriculoMercantil',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(73,	'empresapro',	'Regimen',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(74,	'vista_balancextercero2',	'idCentroCosto',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(75,	'vista_balancextercero2',	'idEmpresa',	1,	1,	1,	'administrador',	3,	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(76,	'librodiario',	'Num_Documento_Externo',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:43:47',	'2019-01-16 09:43:47'),
(77,	'librodiario',	'Tercero_Tipo_Documento',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:43:47',	'2019-01-16 09:43:47'),
(78,	'librodiario',	'Tercero_Identificacion',	1,	1,	1,	'administrador',	3,	'2019-03-02 04:40:40',	'2019-03-01 23:40:40'),
(79,	'librodiario',	'Tercero_DV',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:43:47',	'2019-01-16 09:43:47'),
(80,	'librodiario',	'Tercero_Primer_Apellido',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:43:50',	'2019-01-16 09:43:50'),
(81,	'librodiario',	'Tercero_Segundo_Apellido',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(82,	'librodiario',	'Tercero_Primer_Nombre',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(83,	'librodiario',	'Tercero_Otros_Nombres',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(84,	'librodiario',	'Tercero_Razon_Social',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(85,	'librodiario',	'Tercero_Direccion',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(86,	'librodiario',	'Tercero_Cod_Dpto',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(87,	'librodiario',	'Tercero_Cod_Mcipio',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(88,	'librodiario',	'Tercero_Pais_Domicilio',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(89,	'librodiario',	'Mayor',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(90,	'librodiario',	'Esp',	0,	1,	1,	'administrador',	3,	'2019-01-16 14:44:54',	'2019-01-16 09:44:54'),
(91,	'librodiario',	'Detalle',	1,	1,	1,	'administrador',	3,	'2019-01-16 15:04:57',	'2019-01-16 10:04:57'),
(92,	'librodiario',	'Concepto',	0,	1,	1,	'administrador',	3,	'2019-04-09 17:18:01',	'2019-04-09 12:18:01'),
(93,	'librodiario',	'Tipo_Documento_Intero',	1,	1,	1,	'administrador',	3,	'2019-03-02 04:40:40',	'2019-03-01 23:40:40'),
(94,	'productosventa',	'ValorComision3',	0,	1,	1,	'administrador',	3,	'2019-02-26 22:22:26',	'2019-02-26 17:22:26'),
(95,	'productosventa',	'ValorComision2',	0,	1,	1,	'administrador',	3,	'2019-02-26 22:22:26',	'2019-02-26 17:22:26'),
(96,	'productosventa',	'ValorComision1',	0,	1,	1,	'administrador',	3,	'2019-02-26 22:22:26',	'2019-02-26 17:22:26'),
(97,	'librodiario',	'Num_Documento_Interno',	1,	1,	1,	'administrador',	3,	'2019-03-02 04:40:40',	'2019-03-01 23:40:40'),
(98,	'facturas',	'Prefijo',	0,	1,	1,	'administrador',	3,	'2019-03-13 14:16:10',	'2019-03-13 09:16:10'),
(99,	'facturas',	'NumeroFactura',	0,	1,	1,	'administrador',	3,	'2019-03-13 14:16:10',	'2019-03-13 09:16:10'),
(100,	'facturas',	'Fecha',	0,	1,	1,	'administrador',	3,	'2019-03-13 14:16:10',	'2019-03-13 09:16:10');

DROP TABLE IF EXISTS `tablas_ventas`;
CREATE TABLE `tablas_ventas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTabla` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idTabla` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVAIncluido` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUCDefecto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tablas_ventas` (`ID`, `NombreTabla`, `idTabla`, `TipoVenta`, `IVAIncluido`, `CuentaPUCDefecto`, `Updated`, `Sync`) VALUES
(1,	'productosventa',	'idProductosVenta',	'PRODUCTOS',	'SI',	'4135',	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(2,	'servicios',	'idProductosVenta',	'SERVICIOS',	'SI',	'412060',	'2019-01-13 14:14:12',	'2019-01-13 09:14:12'),
(3,	'productosalquiler',	'idProductosVenta',	'ALQUILER DE SERVICIOS',	'SI',	'4135',	'2019-01-13 14:14:12',	'2019-01-13 09:14:12');

DROP TABLE IF EXISTS `tarjetas_forma_pago`;
CREATE TABLE `tarjetas_forma_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PorcentajeComision` float NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tarjetas_forma_pago` (`ID`, `Tipo`, `Nombre`, `PorcentajeComision`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(1,	'CREDITO',	'AMERICAN EXPRESS',	0.03,	11100501,	'CUENTA DE AHORROS DAVIVIENDA',	'2019-01-13 14:14:13',	'2019-01-13 09:14:13'),
(2,	'CREDITO',	'VISA',	0.04,	11100501,	'CUENTA DE AHORROS DAVIVIENDA',	'2019-01-13 14:14:13',	'2019-01-13 09:14:13'),
(3,	'DEBITO',	'TARJETAS DEBITO',	0,	11100501,	'CUENTA DE AHORROS DAVIVIENDA',	'2019-01-13 14:14:13',	'2019-01-13 09:14:13');

DROP TABLE IF EXISTS `terceros_cuentas_cobro`;
CREATE TABLE `terceros_cuentas_cobro` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `idConceptoContable` int(11) NOT NULL COMMENT 'relacion que mostrara el concepto y movimientos contables a realizar viene de la tabla conceptos',
  `Valor` double NOT NULL,
  `Observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla para realizar cuentas de cobro por parte de terceros';


DROP TABLE IF EXISTS `tiposretenciones`;
CREATE TABLE `tiposretenciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPasivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuentaPasivo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuentaActivo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tiposretenciones` (`ID`, `Nombre`, `CuentaPasivo`, `NombreCuentaPasivo`, `CuentaActivo`, `NombreCuentaActivo`, `Updated`, `Sync`) VALUES
(1,	'RETENCION EN LA FUENTE',	'236540',	'Rete Fuente x compras',	'135515',	'Anticipo de Impuestos Retefuente',	'2019-01-13 14:14:13',	'2019-01-13 09:14:13'),
(2,	'RETEIVA',	'236701',	'IVA retenido',	'135517',	'Anticipo de Impuestos ReteIVA',	'2019-01-13 14:14:13',	'2019-01-13 09:14:13'),
(3,	'RETE-ICA',	'2368',	'Rete Fuente x ICA',	'135518',	'Anticipo de Impuestos ReteICA',	'2019-01-13 14:14:13',	'2019-01-13 09:14:13');

DROP TABLE IF EXISTS `titulos_abonos`;
CREATE TABLE `titulos_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_asignaciones`;
CREATE TABLE `titulos_asignaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Desde` int(11) NOT NULL,
  `Hasta` int(11) NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_comisiones`;
CREATE TABLE `titulos_comisiones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idEgreso` bigint(20) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_cuentasxcobrar`;
CREATE TABLE `titulos_cuentasxcobrar` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaIngreso` date NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idTercero` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RazonSocial` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `Saldo` double NOT NULL,
  `CicloPagos` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `UltimoPago` date NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_devoluciones`;
CREATE TABLE `titulos_devoluciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_listados_promocion_1`;
CREATE TABLE `titulos_listados_promocion_1` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `idActa` bigint(20) NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_listados_promocion_6`;
CREATE TABLE `titulos_listados_promocion_6` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_listados_promocion_7`;
CREATE TABLE `titulos_listados_promocion_7` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `idActa` bigint(20) NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_promociones`;
CREATE TABLE `titulos_promociones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MayorInicial` int(11) NOT NULL,
  `MayorFinal` int(11) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Valor` bigint(20) NOT NULL,
  `ComisionAPagar` bigint(20) NOT NULL,
  `Loteria` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumeroGanador` int(11) NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL DEFAULT '413570',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_traslados`;
CREATE TABLE `titulos_traslados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor1` int(11) NOT NULL,
  `idColaboradorAnterior` bigint(20) NOT NULL,
  `NombreColaboradorAnterior` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idColaboradorAsignado` bigint(20) NOT NULL,
  `NombreColaboradorAsignado` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `titulos_ventas`;
CREATE TABLE `titulos_ventas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `Valor` bigint(20) NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `ComisionAPagar` bigint(20) NOT NULL,
  `SaldoComision` double NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `traslados_estados`;
CREATE TABLE `traslados_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `traslados_items`;
CREATE TABLE `traslados_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idTraslado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` int(11) NOT NULL,
  `CodigoBarras` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `CuentaPUC` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ServerSincronizado` datetime NOT NULL,
  `DestinoSincronizado` datetime NOT NULL,
  `CodigoBarras1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoBarras2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoBarras3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoBarras4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `traslados_mercancia`;
CREATE TABLE `traslados_mercancia` (
  `ID` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Origen` int(11) NOT NULL,
  `ConsecutivoInterno` bigint(20) NOT NULL,
  `Destino` int(11) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `idBodega` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Abre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cierra` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ServerSincronizado` datetime NOT NULL,
  `DestinoSincronizado` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Apellido` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Identificacion` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Login` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Password` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoUser` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Role` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `usuarios` (`idUsuarios`, `Nombre`, `Apellido`, `Identificacion`, `Telefono`, `Login`, `Password`, `TipoUser`, `Email`, `Role`, `Habilitado`, `Updated`, `Sync`) VALUES
(1,	'TECHNO ',	'SOLUCIONES',	'900833180',	'3177740609',	'admin',	'ede60ea0d2b47fe418be2e6cb94e1cc8',	'administrador',	'info@technosoluciones.com',	'SUPERVISOR',	'SI',	'2019-01-13 14:14:14',	'2019-01-13 09:14:14'),
(2,	'ADMINISTRADOR',	'SOFTCONTECH',	'1',	'1',	'administrador',	'91f5167c34c400758115c2a6826ec2e3',	'operador',	'no@no.com',	'SUPERVISOR',	'SI',	'2019-01-13 14:14:14',	'2019-01-13 09:14:14'),
(3,	'JULIAN ANDRES',	'ALVARAN',	'94481747',	'3177740609',	'jalvaran',	'pirlo1985',	'administrador',	'jalvaran@gmail.com',	'SUPERVISOR',	'SI',	'2019-04-08 20:35:50',	'2019-04-08 15:35:50'),
(4,	'WILSON',	'ALBERTO MOSQUERA',	'1',	'318 5658225',	'wamc',	'f5dc2d19e23c69e58e398ea72ae06fd4',	'comercial',	'no',	'ADMINISTRADOR',	'SI',	'2019-01-13 14:14:14',	'2019-01-13 09:14:14');

DROP TABLE IF EXISTS `usuarios_ip`;
CREATE TABLE `usuarios_ip` (
  `Direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Direccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `usuarios_keys`;
CREATE TABLE `usuarios_keys` (
  `KeyUsuario` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`KeyUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `usuarios_tipo`;
CREATE TABLE `usuarios_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `usuarios_tipo` (`ID`, `Tipo`, `Updated`, `Sync`) VALUES
(1,	'administrador',	'2019-01-13 14:14:14',	'2019-01-13 09:14:14'),
(2,	'operador',	'2019-01-13 14:14:14',	'2019-01-13 09:14:14'),
(3,	'comercial',	'2019-01-13 14:14:14',	'2019-01-13 09:14:14'),
(4,	'cajero',	'2019-01-13 14:14:14',	'2019-01-13 09:14:14'),
(5,	'bodega',	'2019-01-13 14:14:14',	'2019-01-13 09:14:14');

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `idVentas` int(11) NOT NULL AUTO_INCREMENT,
  `NumVenta` int(16) DEFAULT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Productos_idProductos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Producto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorCostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorVentaUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Impuestos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descuentos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TotalCosto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TotalVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'Contado' COMMENT 'Credito o contado',
  `Cotizaciones_idCotizaciones` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `CerradoDiario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `FechaCierreDiario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `HoraCierreDiario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraVenta` time NOT NULL,
  `NoReclamacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVentas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `UpdateProductos` AFTER INSERT ON `ventas` FOR EACH ROW
BEGIN


SELECT Existencias into @Cantidad FROM productosventa WHERE idProductosVenta=NEW.Productos_idProductos;

SET @PrecioPromedio=NEW.ValorCostoUnitario;

SET @Saldo=@Cantidad-NEW.Cantidad;

SET @TotalSaldo=@Saldo*@PrecioPromedio;
SET @TotalMov=NEW.Cantidad*@PrecioPromedio;
    
 INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALIDA','VENTA',NEW.NumVenta,NEW.Cantidad,@PrecioPromedio,@TotalMov,NEW.Productos_idProductos);
    

INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALDOS','VENTA',NEW.NumVenta,@Saldo,@PrecioPromedio,@TotalSaldo,NEW.Productos_idProductos);

UPDATE productosventa SET `Existencias`= @Saldo WHERE idProductosVenta = NEW.Productos_idProductos;

UPDATE productosventa SET `CostoTotal`= @TotalSaldo WHERE idProductosVenta = NEW.Productos_idProductos;

SET @SubTotal=NEW.TotalVenta-NEW.Impuestos;

IF (NEW.Especial = "NO" ) THEN

INSERT INTO cotizaciones (`NumCotizacion`, `Fecha`, `Descripcion`,`Referencia`, `ValorUnitario`,`Cantidad`, `Subtotal`, `IVA`, `Total`, `ValorDescuento`,`Clientes_idClientes`, `SubtotalCosto`,`Usuarios_idUsuarios`, `TipoItem`, `PrecioCosto`) VALUES (NEW.Cotizaciones_idCotizaciones,NEW.Fecha,NEW.Producto,NEW.Referencia,NEW.ValorVentaUnitario,NEW.Cantidad,@SubTotal,NEW.Impuestos, NEW.TotalVenta,NEW.Descuentos,NEW.Clientes_idClientes,NEW.TotalCosto,NEW.Usuarios_idUsuarios,'PR',@PrecioPromedio);

END IF;

END;;

DELIMITER ;

DROP TABLE IF EXISTS `ventas_devoluciones`;
CREATE TABLE `ventas_devoluciones` (
  `idDevoluciones` int(16) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalCosto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioCierreDiario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idDevoluciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ventas_fechas_especiales`;
CREATE TABLE `ventas_fechas_especiales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreFecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicial` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ventas_fechas_especiales_precios`;
CREATE TABLE `ventas_fechas_especiales_precios` (
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ventas_nota_credito`;
CREATE TABLE `ventas_nota_credito` (
  `idNotasCredito` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DBCR` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Facturas_idFacturas` int(11) NOT NULL,
  `Concepto` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idNotasCredito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ventas_separados`;
CREATE TABLE `ventas_separados` (
  `idVentas_Separados` int(11) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` int(11) NOT NULL,
  `Retirado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `FechaRetiro` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuariosEntrega` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVentas_Separados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `vestasactivas`;
CREATE TABLE `vestasactivas` (
  `idVestasActivas` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Usuario_idUsuario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Clientes_idClientes` int(11) NOT NULL DEFAULT '0',
  `SaldoFavor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVestasActivas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP VIEW IF EXISTS `vista_abonos`;
CREATE TABLE `vista_abonos` (`Tabla` varchar(16), `TipoAbono` varchar(45), `Fecha` date, `Valor` double, `idUsuario` int(11), `idCierre` bigint(20));


DROP VIEW IF EXISTS `vista_af`;
CREATE TABLE `vista_af` ();


DROP VIEW IF EXISTS `vista_balancextercero1`;
CREATE TABLE `vista_balancextercero1` (`Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `CuentaPUC` varchar(45), `Debitos` double, `Creditos` double, `Neto` double);


DROP VIEW IF EXISTS `vista_balancextercero2`;
CREATE TABLE `vista_balancextercero2` (`ID` char(0), `Identificacion` varchar(45), `Razon_Social` varchar(100), `Cuenta` varchar(45), `Nombre_Cuenta` varchar(200), `Debitos` double, `Creditos` double, `Neto` double, `idEmpresa` int(11), `idCentroCosto` int(11));


DROP VIEW IF EXISTS `vista_cierres_restaurante`;
CREATE TABLE `vista_cierres_restaurante` (`ID` bigint(20), `Fecha` date, `Hora` time, `idUsuario` bigint(20), `PedidosFacturados` double, `PedidosDescartados` double, `DomiciliosFacturados` double, `DomiciliosDescartados` double, `ParaLlevarFacturado` double, `ParaLlevarDescartado` double, `PropinasEfectivo` double, `PropinasTarjetas` double);


DROP VIEW IF EXISTS `vista_compras_productos`;
CREATE TABLE `vista_compras_productos` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `idProducto` bigint(20), `Referencia` varchar(200), `Producto` varchar(70), `PrecioVenta` double, `Cantidad` double, `CostoUnitario` double, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_compras_productos_devueltos`;
CREATE TABLE `vista_compras_productos_devueltos` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `idProducto` bigint(20), `Referencia` varchar(200), `Producto` varchar(70), `PrecioVenta` double, `Cantidad` double, `CostoUnitario` double, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_compras_servicios`;
CREATE TABLE `vista_compras_servicios` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `Cuenta` bigint(20), `NombreCuenta` varchar(100), `Concepto_Servicio` text, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` double, `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_diferencia_inventarios`;
CREATE TABLE `vista_diferencia_inventarios` (`idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `ExistenciaAnterior` double, `ExistenciaActual` double, `Diferencia` double, `PrecioVenta` double, `CostoUnitario` double, `TotalCostosDiferencia` double, `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45));


DROP VIEW IF EXISTS `vista_diferencia_inventarios_selectivos`;
CREATE TABLE `vista_diferencia_inventarios_selectivos` (`idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `ExistenciaAnterior` double, `ExistenciaActual` double, `Diferencia` double, `PrecioVenta` double, `CostoUnitario` double, `TotalCostosDiferencia` double, `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45));


DROP VIEW IF EXISTS `vista_documentos_contables`;
CREATE TABLE `vista_documentos_contables` (`ID` bigint(20), `Fecha` date, `Prefijo` varchar(20), `Nombre` varchar(45), `Consecutivo` bigint(20), `Descripcion` text, `Estado` varchar(10), `idUser` int(11), `idDocumento` int(11), `idEmpresa` int(11), `idSucursal` int(11), `idCentroCostos` int(11));


DROP VIEW IF EXISTS `vista_documentos_equivalentes`;
CREATE TABLE `vista_documentos_equivalentes` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Estado` enum('AB','CE'), `Total` double);


DROP VIEW IF EXISTS `vista_estado_resultados_anio`;
CREATE TABLE `vista_estado_resultados_anio` (`idLibroDiario` bigint(20), `Fecha` date, `Tipo_Documento_Intero` varchar(45), `Num_Documento_Interno` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Dpto` varchar(10), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debito` double, `Credito` double, `Neto` double, `Mayor` varchar(45), `Esp` varchar(45), `idCentroCosto` int(11), `idEmpresa` int(11), `idSucursal` int(11), `Estado` varchar(20), `idUsuario` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_exogena`;
CREATE TABLE `vista_exogena` (`Tipo_Documento_Intero` varchar(45), `NumDocumento` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debitos` double(17,0), `Creditos` double(17,0));


DROP VIEW IF EXISTS `vista_exogena2`;
CREATE TABLE `vista_exogena2` (`Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(4), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debitos` double(17,0), `Creditos` double(17,0));


DROP VIEW IF EXISTS `vista_facturacion_detalles`;
CREATE TABLE `vista_facturacion_detalles` (`ID` bigint(20) unsigned, `FechaFactura` date, `NumeroFactura` bigint(16), `TipoFactura` varchar(20), `TablaItems` varchar(100), `Referencia` varchar(200), `Nombre` text, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `ValorUnitarioItem` double, `Cantidad` double, `SubtotalItem` double, `IVAItem` double, `TotalItem` double, `PorcentajeIVA` varchar(10), `PrecioCostoUnitario` double, `SubtotalCosto` double, `CuentaPUC` int(11), `idUsuarios` int(11), `idCierre` bigint(20), `Observaciones` mediumtext);


DROP VIEW IF EXISTS `vista_factura_compra_totales`;
CREATE TABLE `vista_factura_compra_totales` (`idFacturaCompra` bigint(20), `Sede` varchar(100), `Fecha` date, `NumeroFactura` varchar(100), `Tercero` bigint(20), `RazonSocial` varchar(300), `Subtotal` double, `Impuestos` double, `TotalRetenciones` double, `Total` double, `Concepto` text, `SubtotalServicios` double, `ImpuestosServicios` double, `TotalServicios` double, `SubtotalDevoluciones` double, `ImpuestosDevueltos` double, `TotalDevolucion` double, `Usuario` bigint(20));


DROP VIEW IF EXISTS `vista_inventario_separados`;
CREATE TABLE `vista_inventario_separados` (`ID` bigint(20) unsigned, `idSeparado` bigint(20), `Referencia` varchar(45), `Nombre` text, `ValorUnitarioItem` int(11), `Cantidad` int(11), `TotalItem` int(11), `PrecioCostoUnitario` int(11), `SubtotalCosto` int(11), `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11));


DROP VIEW IF EXISTS `vista_kardex`;
CREATE TABLE `vista_kardex` (`ID` bigint(20), `Fecha` date, `Movimiento` varchar(45), `Detalle` varchar(400), `idDocumento` varchar(100), `Cantidad` double, `ValorUnitario` double, `ValorTotal` double, `ProductosVenta_idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `Existencias` double, `CostoUnitario` double, `CostoTotal` double, `IVA` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_libro_diario`;
CREATE TABLE `vista_libro_diario` (`idLibroDiario` bigint(20), `Fecha` date, `Tipo_Documento_Intero` varchar(45), `NumDocumento` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Dpto` varchar(10), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debito` double, `Credito` double, `Neto` double, `idCentroCosto` int(11), `idEmpresa` int(11), `idSucursal` int(11), `Estado` varchar(20), `idUsuario` int(11));


DROP VIEW IF EXISTS `vista_nomina_servicios_turnos`;
CREATE TABLE `vista_nomina_servicios_turnos` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Sucursal` int(11), `Valor` double, `idUser` int(11), `Pagado` int(1), `Estado` varchar(10), `idDocumentoEquivalente` bigint(20), `Updated` timestamp, `Sync` datetime, `NombreSucursal` varchar(100), `NombreTercero` varchar(300));


DROP VIEW IF EXISTS `vista_notas_devolucion`;
CREATE TABLE `vista_notas_devolucion` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Concepto` text, `Subtotal` double, `IVA` double, `Total` double, `idCentroCostos` int(11), `idSucursal` int(11), `idUser` bigint(20), `Estado` varchar(10));


DROP VIEW IF EXISTS `vista_ori_facturas`;
CREATE TABLE `vista_ori_facturas` (`Fecha` date, `idFactura` varchar(45), `Referencia` varchar(200), `Nombre` varchar(500), `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `ValorUnitarioItem` int(11), `Cantidad` varchar(45), `Dias` varchar(45), `SubtotalItem` varchar(45), `IVAItem` varchar(45), `ValorOtrosImpuestos` double, `TotalItem` double, `PorcentajeIVA` varchar(10), `idOtrosImpuestos` int(11), `idPorcentajeIVA` int(11), `PrecioCostoUnitario` varchar(45), `SubtotalCosto` varchar(45), `TipoItem` varchar(10), `CuentaPUC` int(11), `GeneradoDesde` varchar(100), `NumeroIdentificador` varchar(45), `idUsuarios` int(11), `idCierre` bigint(20), `idResolucion` int(11), `TipoFactura` varchar(10), `Prefijo` varchar(45), `NumeroFactura` int(16), `Hora` varchar(20), `FormaPago` varchar(20), `CentroCosto` int(11), `idSucursal` int(11), `EmpresaPro_idEmpresaPro` int(11), `Clientes_idClientes` int(11), `ObservacionesFact` text);


DROP VIEW IF EXISTS `vista_pedidos_restaurante`;
CREATE TABLE `vista_pedidos_restaurante` (`ID` bigint(20), `Fecha` date, `Hora` time, `Estado` varchar(4), `idMesa` int(11), `idCliente` bigint(20), `NombreCliente` varchar(60), `DireccionEnvio` varchar(100), `TelefonoConfirmacion` varchar(100), `Observaciones` text, `idCierre` bigint(20), `Subtotal` double, `IVA` double, `Total` double, `idUsuario` bigint(20));


DROP VIEW IF EXISTS `vista_preventa`;
CREATE TABLE `vista_preventa` (`VestasActivas_idVestasActivas` int(11), `TablaItems` varchar(14), `Referencia` varchar(200), `Nombre` varchar(70), `Departamento` varchar(45), `SubGrupo1` varchar(45), `SubGrupo2` varchar(45), `SubGrupo3` varchar(45), `SubGrupo4` varchar(45), `SubGrupo5` varchar(45), `ValorUnitarioItem` double, `Cantidad` double, `Dias` varchar(1), `SubtotalItem` double, `IVAItem` double, `ValorOtrosImpuestos` double, `TotalItem` double, `PorcentajeIVA` varchar(24), `PrecioCostoUnitario` double, `SubtotalCosto` double, `TipoItem` varchar(2), `CuentaPUC` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_resumen_facturacion`;
CREATE TABLE `vista_resumen_facturacion` (`ID` bigint(20) unsigned, `FechaInicial` date, `FechaFinal` date, `Referencia` varchar(200), `idProducto` bigint(20), `Nombre` text, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `Cantidad` double, `TotalVenta` double(19,2), `Costo` double(19,2));


DROP VIEW IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE TABLE `vista_resumen_ventas_departamentos` (`FechaFactura` date, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `Total` double);


DROP VIEW IF EXISTS `vista_retenciones`;
CREATE TABLE `vista_retenciones` (`idCompra` bigint(20), `Fecha` date, `Tercero` bigint(20), `RazonSocial` varchar(300), `DV` varchar(5), `Direccion` varchar(45), `Ciudad` varchar(100), `CuentaPUC` bigint(20), `Cuenta` varchar(200), `ValorRetencion` double, `PorcentajeRetenido` double, `BaseRetencion` double(19,2), `idEmpresa` bigint(11), `idCentroCostos` bigint(11), `idSucursal` bigint(11));


DROP VIEW IF EXISTS `vista_retenciones_tercero`;
CREATE TABLE `vista_retenciones_tercero` (`idCompra` bigint(20), `Fecha` date, `Tercero` bigint(20), `RazonSocial` varchar(300), `DV` varchar(5), `Direccion` varchar(45), `Ciudad` varchar(100), `CuentaPUC` bigint(20), `Cuenta` varchar(200), `ValorRetencion` double, `PorcentajeRetenido` double, `BaseRetencion` double(19,2));


DROP VIEW IF EXISTS `vista_sistemas`;
CREATE TABLE `vista_sistemas` (`ID` bigint(20), `idSistema` bigint(20), `Nombre_Sistema` mediumtext, `Observaciones` mediumtext, `TablaOrigen` varchar(90), `CodigoInterno` bigint(20), `Nombre` text, `Cantidad` double, `PrecioUnitario` double, `PrecioVenta` double(17,0), `CostoUnitario` double(17,0), `Costo_Total_Item` double(17,0), `IVA` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_titulos_abonos`;
CREATE TABLE `vista_titulos_abonos` (`ID` bigint(20), `Fecha` date, `Hora` time, `Monto` double, `idVenta` bigint(20), `Promocion` int(11), `Mayor` int(11), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `Estado` varchar(45), `idComprobanteIngreso` bigint(20), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


DROP VIEW IF EXISTS `vista_titulos_comisiones`;
CREATE TABLE `vista_titulos_comisiones` (`ID` bigint(20), `Fecha` date, `Hora` time, `Monto` double, `idVenta` bigint(20), `Promocion` int(11), `Mayor` int(11), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `idUsuario` int(11), `idEgreso` bigint(20), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


DROP VIEW IF EXISTS `vista_titulos_devueltos`;
CREATE TABLE `vista_titulos_devueltos` (`ID` bigint(20), `Fecha` date, `idVenta` bigint(20), `Promocion` int(11), `Mayor` bigint(20), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `idUsuario` int(11), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


DROP VIEW IF EXISTS `vista_totales_facturacion`;
CREATE TABLE `vista_totales_facturacion` (`FechaFactura` date, `Items` double, `Subtotal` double(17,0), `IVA` double(17,0), `OtrosImpuestos` double(17,0), `Total` double(17,0));


DROP TABLE IF EXISTS `vista_abonos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_abonos` AS select 'abonos_factura' AS `Tabla`,`fa`.`FormaPago` AS `TipoAbono`,`fa`.`Fecha` AS `Fecha`,`fa`.`Valor` AS `Valor`,`fa`.`Usuarios_idUsuarios` AS `idUsuario`,`fa`.`idCierre` AS `idCierre` from `facturas_abonos` `fa` union select 'abonos_separados' AS `Tabla`,'Separados' AS `TipoAbono`,`fa`.`Fecha` AS `Fecha`,`fa`.`Valor` AS `Valor`,`fa`.`idUsuarios` AS `idUsuario`,`fa`.`idCierre` AS `idCierre` from `separados_abonos` `fa`;

DROP TABLE IF EXISTS `vista_af`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_af` AS select `ts5`.`salud_archivo_facturacion_mov_generados`.`id_fac_mov_generados` AS `id_fac_mov_generados`,`ts5`.`salud_archivo_facturacion_mov_generados`.`cod_prest_servicio` AS `cod_prest_servicio`,`ts5`.`salud_archivo_facturacion_mov_generados`.`razon_social` AS `razon_social`,`ts5`.`salud_archivo_facturacion_mov_generados`.`tipo_ident_prest_servicio` AS `tipo_ident_prest_servicio`,`ts5`.`salud_archivo_facturacion_mov_generados`.`num_ident_prest_servicio` AS `num_ident_prest_servicio`,`ts5`.`salud_archivo_facturacion_mov_generados`.`num_factura` AS `num_factura`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_factura` AS `fecha_factura`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_inicio` AS `fecha_inicio`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_final` AS `fecha_final`,`ts5`.`salud_archivo_facturacion_mov_generados`.`cod_enti_administradora` AS `cod_enti_administradora`,`ts5`.`salud_archivo_facturacion_mov_generados`.`nom_enti_administradora` AS `nom_enti_administradora`,`ts5`.`salud_archivo_facturacion_mov_generados`.`num_contrato` AS `num_contrato`,`ts5`.`salud_archivo_facturacion_mov_generados`.`plan_beneficios` AS `plan_beneficios`,`ts5`.`salud_archivo_facturacion_mov_generados`.`num_poliza` AS `num_poliza`,`ts5`.`salud_archivo_facturacion_mov_generados`.`valor_total_pago` AS `valor_total_pago`,`ts5`.`salud_archivo_facturacion_mov_generados`.`valor_comision` AS `valor_comision`,`ts5`.`salud_archivo_facturacion_mov_generados`.`valor_descuentos` AS `valor_descuentos`,`ts5`.`salud_archivo_facturacion_mov_generados`.`valor_neto_pagar` AS `valor_neto_pagar`,`ts5`.`salud_archivo_facturacion_mov_generados`.`tipo_negociacion` AS `tipo_negociacion`,`ts5`.`salud_archivo_facturacion_mov_generados`.`nom_cargue` AS `nom_cargue`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_cargue` AS `fecha_cargue`,`ts5`.`salud_archivo_facturacion_mov_generados`.`idUser` AS `idUser`,`ts5`.`salud_archivo_facturacion_mov_generados`.`eps_radicacion` AS `eps_radicacion`,`ts5`.`salud_archivo_facturacion_mov_generados`.`dias_pactados` AS `dias_pactados`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_radicado` AS `fecha_radicado`,`ts5`.`salud_archivo_facturacion_mov_generados`.`numero_radicado` AS `numero_radicado`,`ts5`.`salud_archivo_facturacion_mov_generados`.`Soporte` AS `Soporte`,`ts5`.`salud_archivo_facturacion_mov_generados`.`estado` AS `estado`,`ts5`.`salud_archivo_facturacion_mov_generados`.`EstadoCobro` AS `EstadoCobro`,`ts5`.`salud_archivo_facturacion_mov_generados`.`Arma030Anterior` AS `Arma030Anterior`,`ts5`.`salud_archivo_facturacion_mov_generados`.`Updated` AS `Updated`,`ts5`.`salud_archivo_facturacion_mov_generados`.`Sync` AS `Sync`,(select `ts5`.`salud_eps`.`Genera030` from `salud_eps` where (`ts5`.`salud_eps`.`cod_pagador_min` = `ts5`.`salud_archivo_facturacion_mov_generados`.`cod_enti_administradora`)) AS `GeneraCircular` from `salud_archivo_facturacion_mov_generados`;

DROP TABLE IF EXISTS `vista_balancextercero1`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_balancextercero1` AS select `librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos`,(sum(`librodiario`.`Debito`) - sum(`librodiario`.`Credito`)) AS `Neto` from `librodiario` group by `librodiario`.`Tercero_Identificacion` order by substr(`librodiario`.`CuentaPUC`,1,8);

DROP TABLE IF EXISTS `vista_balancextercero2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_balancextercero2` AS select '' AS `ID`,`librodiario`.`Tercero_Identificacion` AS `Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Razon_Social`,`librodiario`.`CuentaPUC` AS `Cuenta`,`librodiario`.`NombreCuenta` AS `Nombre_Cuenta`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos`,(sum(`librodiario`.`Debito`) - sum(`librodiario`.`Credito`)) AS `Neto`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idCentroCosto` AS `idCentroCosto` from `librodiario` where (`librodiario`.`Fecha` <= '2019-04-11') group by `librodiario`.`Tercero_Identificacion` order by substr(`librodiario`.`CuentaPUC`,1,8),`librodiario`.`Tercero_Razon_Social`;

DROP TABLE IF EXISTS `vista_cierres_restaurante`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cierres_restaurante` AS select `restaurante_cierres`.`ID` AS `ID`,`restaurante_cierres`.`Fecha` AS `Fecha`,`restaurante_cierres`.`Hora` AS `Hora`,`restaurante_cierres`.`idUsuario` AS `idUsuario`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FAPE'))) AS `PedidosFacturados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DEPE'))) AS `PedidosDescartados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FADO'))) AS `DomiciliosFacturados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DEDO'))) AS `DomiciliosDescartados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FALL'))) AS `ParaLlevarFacturado`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DELL'))) AS `ParaLlevarDescartado`,(select sum(`restaurante_registro_propinas`.`Efectivo`) AS `Total` from `restaurante_registro_propinas` where (`restaurante_registro_propinas`.`idCierre` = `restaurante_cierres`.`ID`)) AS `PropinasEfectivo`,(select sum(`restaurante_registro_propinas`.`Tarjetas`) AS `Total` from `restaurante_registro_propinas` where (`restaurante_registro_propinas`.`idCierre` = `restaurante_cierres`.`ID`)) AS `PropinasTarjetas` from `restaurante_cierres`;

DROP TABLE IF EXISTS `vista_compras_productos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_productos` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fi`.`idProducto` AS `idProducto`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Producto`,`pv`.`PrecioVenta` AS `PrecioVenta`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`CostoUnitarioCompra` AS `CostoUnitario`,`fi`.`SubtotalCompra` AS `Subtotal`,`fi`.`ImpuestoCompra` AS `Impuestos`,`fi`.`TotalCompra` AS `Total`,`fi`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from (((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_items` `fi` on((`fi`.`idFacturaCompra` = `c`.`ID`))) join `productosventa` `pv` on((`fi`.`idProducto` = `pv`.`idProductosVenta`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_compras_productos_devueltos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_productos_devueltos` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fi`.`idProducto` AS `idProducto`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Producto`,`pv`.`PrecioVenta` AS `PrecioVenta`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`CostoUnitarioCompra` AS `CostoUnitario`,`fi`.`SubtotalCompra` AS `Subtotal`,`fi`.`ImpuestoCompra` AS `Impuestos`,`fi`.`TotalCompra` AS `Total`,`fi`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from (((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_items_devoluciones` `fi` on((`fi`.`idFacturaCompra` = `c`.`ID`))) join `productosventa` `pv` on((`fi`.`idProducto` = `pv`.`idProductosVenta`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_compras_servicios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_servicios` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fs`.`CuentaPUC_Servicio` AS `Cuenta`,`fs`.`Nombre_Cuenta` AS `NombreCuenta`,`fs`.`Concepto_Servicio` AS `Concepto_Servicio`,`fs`.`Subtotal_Servicio` AS `Subtotal`,`fs`.`Impuesto_Servicio` AS `Impuestos`,`fs`.`Total_Servicio` AS `Total`,`fs`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from ((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_servicios` `fs` on((`fs`.`idFacturaCompra` = `c`.`ID`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_diferencia_inventarios`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_diferencia_inventarios` AS select `productosventa`.`idProductosVenta` AS `idProductosVenta`,`productosventa`.`Referencia` AS `Referencia`,`productosventa`.`Nombre` AS `Nombre`,`productosventa`.`Existencias` AS `ExistenciaAnterior`,(select ifnull((select `inventarios_temporal`.`Existencias` from `inventarios_temporal` where (`productosventa`.`Referencia` = `inventarios_temporal`.`Referencia`)),0)) AS `ExistenciaActual`,((select `ExistenciaActual`) - `productosventa`.`Existencias`) AS `Diferencia`,`productosventa`.`PrecioVenta` AS `PrecioVenta`,`productosventa`.`CostoUnitario` AS `CostoUnitario`,((select `Diferencia`) * `productosventa`.`CostoUnitario`) AS `TotalCostosDiferencia`,`productosventa`.`Departamento` AS `Departamento`,`productosventa`.`Sub1` AS `Sub1`,`productosventa`.`Sub2` AS `Sub2`,`productosventa`.`Sub3` AS `Sub3`,`productosventa`.`Sub4` AS `Sub4`,`productosventa`.`Sub5` AS `Sub5` from `productosventa` where (((select ifnull((select `inventarios_temporal`.`Existencias` from `inventarios_temporal` where (`productosventa`.`Referencia` = `inventarios_temporal`.`Referencia`)),0)) - `productosventa`.`Existencias`) <> 0);

DROP TABLE IF EXISTS `vista_diferencia_inventarios_selectivos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_diferencia_inventarios_selectivos` AS select `productosventa`.`idProductosVenta` AS `idProductosVenta`,`productosventa`.`Referencia` AS `Referencia`,`productosventa`.`Nombre` AS `Nombre`,`productosventa`.`Existencias` AS `ExistenciaAnterior`,(select ifnull((select `inventarios_conteo_selectivo`.`Cantidad` from `inventarios_conteo_selectivo` where (`productosventa`.`idProductosVenta` = `inventarios_conteo_selectivo`.`Referencia`)),0)) AS `ExistenciaActual`,((select `ExistenciaActual`) - `productosventa`.`Existencias`) AS `Diferencia`,`productosventa`.`PrecioVenta` AS `PrecioVenta`,`productosventa`.`CostoUnitario` AS `CostoUnitario`,((select `Diferencia`) * `productosventa`.`CostoUnitario`) AS `TotalCostosDiferencia`,`productosventa`.`Departamento` AS `Departamento`,`productosventa`.`Sub1` AS `Sub1`,`productosventa`.`Sub2` AS `Sub2`,`productosventa`.`Sub3` AS `Sub3`,`productosventa`.`Sub4` AS `Sub4`,`productosventa`.`Sub5` AS `Sub5` from `productosventa` where ((select ifnull((select `inventarios_conteo_selectivo`.`Cantidad` from `inventarios_conteo_selectivo` where (`productosventa`.`idProductosVenta` = `inventarios_conteo_selectivo`.`Referencia`)),0)) > 0);

DROP TABLE IF EXISTS `vista_documentos_contables`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_documentos_contables` AS select `dcc`.`ID` AS `ID`,`dcc`.`Fecha` AS `Fecha`,`dc`.`Prefijo` AS `Prefijo`,`dc`.`Nombre` AS `Nombre`,`dcc`.`Consecutivo` AS `Consecutivo`,`dcc`.`Descripcion` AS `Descripcion`,`dcc`.`Estado` AS `Estado`,`dcc`.`idUser` AS `idUser`,`dcc`.`idDocumento` AS `idDocumento`,`dcc`.`idEmpresa` AS `idEmpresa`,`dcc`.`idSucursal` AS `idSucursal`,`dcc`.`idCentroCostos` AS `idCentroCostos` from (`documentos_contables_control` `dcc` join `documentos_contables` `dc` on((`dc`.`ID` = `dcc`.`idDocumento`)));

DROP TABLE IF EXISTS `vista_documentos_equivalentes`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_documentos_equivalentes` AS select `de`.`ID` AS `ID`,`de`.`Fecha` AS `Fecha`,`de`.`Tercero` AS `Tercero`,`de`.`Estado` AS `Estado`,(select sum(`dei`.`Total`) from `documento_equivalente_items` `dei` where (`dei`.`idDocumento` = `de`.`ID`)) AS `Total` from `documento_equivalente` `de`;

DROP TABLE IF EXISTS `vista_estado_resultados_anio`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_estado_resultados_anio` AS select `librodiario`.`idLibroDiario` AS `idLibroDiario`,`librodiario`.`Fecha` AS `Fecha`,`librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,`librodiario`.`Num_Documento_Interno` AS `Num_Documento_Interno`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Dpto` AS `Tercero_Cod_Dpto`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,`librodiario`.`Debito` AS `Debito`,`librodiario`.`Credito` AS `Credito`,`librodiario`.`Neto` AS `Neto`,`librodiario`.`Mayor` AS `Mayor`,`librodiario`.`Esp` AS `Esp`,`librodiario`.`idCentroCosto` AS `idCentroCosto`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idSucursal` AS `idSucursal`,`librodiario`.`Estado` AS `Estado`,`librodiario`.`idUsuario` AS `idUsuario`,`librodiario`.`Updated` AS `Updated`,`librodiario`.`Sync` AS `Sync` from `librodiario` where ((`librodiario`.`Fecha` >= '2019-01-01') and (`librodiario`.`Fecha` <= '2019-12-31'));

DROP TABLE IF EXISTS `vista_exogena`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_exogena` AS select `librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)),`librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,round(sum(`librodiario`.`Debito`),0) AS `Debitos`,round(sum(`librodiario`.`Credito`),0) AS `Creditos` from `librodiario` where ((`librodiario`.`Fecha` >= '2017-01-01') and (`librodiario`.`Fecha` <= '2017-12-31')) group by `librodiario`.`CuentaPUC`,`librodiario`.`Tercero_Identificacion`;

DROP TABLE IF EXISTS `vista_exogena2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_exogena2` AS select `librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,substr(`librodiario`.`CuentaPUC`,1,4) AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,round(sum(`librodiario`.`Debito`),0) AS `Debitos`,round(sum(`librodiario`.`Credito`),0) AS `Creditos` from `librodiario` where ((`librodiario`.`Fecha` >= '2017-01-01') and (`librodiario`.`Fecha` <= '2017-12-31')) group by substr(`librodiario`.`CuentaPUC`,1,4),`librodiario`.`Tercero_Identificacion`;

DROP TABLE IF EXISTS `vista_facturacion_detalles`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_facturacion_detalles` AS select `facturas_items`.`ID` AS `ID`,`facturas_items`.`FechaFactura` AS `FechaFactura`,(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `NumeroFactura`,(select `facturas`.`FormaPago` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `TipoFactura`,`facturas_items`.`TablaItems` AS `TablaItems`,`facturas_items`.`Referencia` AS `Referencia`,`facturas_items`.`Nombre` AS `Nombre`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,`facturas_items`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`facturas_items`.`Cantidad` AS `Cantidad`,`facturas_items`.`SubtotalItem` AS `SubtotalItem`,`facturas_items`.`IVAItem` AS `IVAItem`,`facturas_items`.`TotalItem` AS `TotalItem`,`facturas_items`.`PorcentajeIVA` AS `PorcentajeIVA`,`facturas_items`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`facturas_items`.`SubtotalCosto` AS `SubtotalCosto`,`facturas_items`.`CuentaPUC` AS `CuentaPUC`,`facturas_items`.`idUsuarios` AS `idUsuarios`,`facturas_items`.`idCierre` AS `idCierre`,(select `facturas`.`ObservacionesFact` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `Observaciones` from `facturas_items`;

DROP TABLE IF EXISTS `vista_factura_compra_totales`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_factura_compra_totales` AS select `fci`.`idFacturaCompra` AS `idFacturaCompra`,(select `empresa_pro_sucursales`.`Nombre` from `empresa_pro_sucursales` where (`empresa_pro_sucursales`.`ID` = `fc`.`idSucursal`)) AS `Sede`,(select `factura_compra`.`Fecha` from `factura_compra` where (`factura_compra`.`ID` = `fci`.`idFacturaCompra`)) AS `Fecha`,(select `factura_compra`.`NumeroFactura` from `factura_compra` where (`factura_compra`.`ID` = `fci`.`idFacturaCompra`)) AS `NumeroFactura`,`fc`.`Tercero` AS `Tercero`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = `fc`.`Tercero`) limit 1) AS `RazonSocial`,sum(`fci`.`SubtotalCompra`) AS `Subtotal`,sum(`fci`.`ImpuestoCompra`) AS `Impuestos`,(select sum(`factura_compra_retenciones`.`ValorRetencion`) from `factura_compra_retenciones` where (`factura_compra_retenciones`.`idCompra` = `fci`.`idFacturaCompra`)) AS `TotalRetenciones`,sum(`fci`.`TotalCompra`) AS `Total`,`fc`.`Concepto` AS `Concepto`,(select sum(`factura_compra_servicios`.`Subtotal_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `SubtotalServicios`,(select sum(`factura_compra_servicios`.`Impuesto_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `ImpuestosServicios`,(select sum(`factura_compra_servicios`.`Total_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `TotalServicios`,(select sum(`factura_compra_items_devoluciones`.`SubtotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `SubtotalDevoluciones`,(select sum(`factura_compra_items_devoluciones`.`ImpuestoCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `ImpuestosDevueltos`,(select sum(`factura_compra_items_devoluciones`.`TotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `TotalDevolucion`,`fc`.`idUsuario` AS `Usuario` from (`factura_compra_items` `fci` join `factura_compra` `fc` on((`fc`.`ID` = `fci`.`idFacturaCompra`))) where (`fc`.`Estado` <> 'ANULADA') group by `fci`.`idFacturaCompra`;

DROP TABLE IF EXISTS `vista_inventario_separados`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_inventario_separados` AS select `si`.`ID` AS `ID`,`si`.`idSeparado` AS `idSeparado`,`si`.`Referencia` AS `Referencia`,`si`.`Nombre` AS `Nombre`,`si`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`si`.`Cantidad` AS `Cantidad`,`si`.`TotalItem` AS `TotalItem`,`si`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`si`.`SubtotalCosto` AS `SubtotalCosto`,`si`.`Departamento` AS `Departamento`,`si`.`SubGrupo1` AS `SubGrupo1`,`si`.`SubGrupo2` AS `SubGrupo2`,`si`.`SubGrupo3` AS `SubGrupo3`,`si`.`SubGrupo4` AS `SubGrupo4`,`si`.`SubGrupo5` AS `SubGrupo5` from (`separados_items` `si` join `separados` `s` on((`s`.`ID` = `si`.`idSeparado`))) where (`s`.`Estado` = 'Abierto');

DROP TABLE IF EXISTS `vista_kardex`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_kardex` AS select `k`.`idKardexMercancias` AS `ID`,`k`.`Fecha` AS `Fecha`,`k`.`Movimiento` AS `Movimiento`,`k`.`Detalle` AS `Detalle`,`k`.`idDocumento` AS `idDocumento`,`k`.`Cantidad` AS `Cantidad`,`k`.`ValorUnitario` AS `ValorUnitario`,`k`.`ValorTotal` AS `ValorTotal`,`k`.`ProductosVenta_idProductosVenta` AS `ProductosVenta_idProductosVenta`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Existencias` AS `Existencias`,`pv`.`CostoUnitario` AS `CostoUnitario`,`pv`.`CostoTotal` AS `CostoTotal`,`pv`.`IVA` AS `IVA`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`k`.`Updated` AS `Updated`,`k`.`Sync` AS `Sync` from (`kardexmercancias` `k` join `productosventa` `pv` on((`k`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`)));

DROP TABLE IF EXISTS `vista_libro_diario`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_libro_diario` AS select `librodiario`.`idLibroDiario` AS `idLibroDiario`,`librodiario`.`Fecha` AS `Fecha`,`librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)),`librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Dpto` AS `Tercero_Cod_Dpto`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,`librodiario`.`Debito` AS `Debito`,`librodiario`.`Credito` AS `Credito`,`librodiario`.`Neto` AS `Neto`,`librodiario`.`idCentroCosto` AS `idCentroCosto`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idSucursal` AS `idSucursal`,`librodiario`.`Estado` AS `Estado`,`librodiario`.`idUsuario` AS `idUsuario` from `librodiario`;

DROP TABLE IF EXISTS `vista_nomina_servicios_turnos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_nomina_servicios_turnos` AS select `nomina_servicios_turnos`.`ID` AS `ID`,`nomina_servicios_turnos`.`Fecha` AS `Fecha`,`nomina_servicios_turnos`.`Tercero` AS `Tercero`,`nomina_servicios_turnos`.`Sucursal` AS `Sucursal`,`nomina_servicios_turnos`.`Valor` AS `Valor`,`nomina_servicios_turnos`.`idUser` AS `idUser`,`nomina_servicios_turnos`.`Pagado` AS `Pagado`,`nomina_servicios_turnos`.`Estado` AS `Estado`,`nomina_servicios_turnos`.`idDocumentoEquivalente` AS `idDocumentoEquivalente`,`nomina_servicios_turnos`.`Updated` AS `Updated`,`nomina_servicios_turnos`.`Sync` AS `Sync`,(select `empresa_pro_sucursales`.`Nombre` from `empresa_pro_sucursales` where (`empresa_pro_sucursales`.`ID` = `nomina_servicios_turnos`.`Sucursal`) limit 1) AS `NombreSucursal`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = `nomina_servicios_turnos`.`Tercero`) limit 1) AS `NombreTercero` from `nomina_servicios_turnos` where (`nomina_servicios_turnos`.`Estado` <> 'ANULADO');

DROP TABLE IF EXISTS `vista_notas_devolucion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_notas_devolucion` AS select `factura_compra_notas_devolucion`.`ID` AS `ID`,`factura_compra_notas_devolucion`.`Fecha` AS `Fecha`,`factura_compra_notas_devolucion`.`Tercero` AS `Tercero`,`factura_compra_notas_devolucion`.`Concepto` AS `Concepto`,(select sum(`factura_compra_items_devoluciones`.`SubtotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `Subtotal`,(select sum(`factura_compra_items_devoluciones`.`ImpuestoCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `IVA`,(select sum(`factura_compra_items_devoluciones`.`TotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `Total`,`factura_compra_notas_devolucion`.`idCentroCostos` AS `idCentroCostos`,`factura_compra_notas_devolucion`.`idSucursal` AS `idSucursal`,`factura_compra_notas_devolucion`.`idUser` AS `idUser`,`factura_compra_notas_devolucion`.`Estado` AS `Estado` from `factura_compra_notas_devolucion`;

DROP TABLE IF EXISTS `vista_ori_facturas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_ori_facturas` AS select `fi`.`FechaFactura` AS `Fecha`,`fi`.`idFactura` AS `idFactura`,`fi`.`Referencia` AS `Referencia`,`fi`.`Nombre` AS `Nombre`,`fi`.`Departamento` AS `Departamento`,`fi`.`SubGrupo1` AS `SubGrupo1`,`fi`.`SubGrupo2` AS `SubGrupo2`,`fi`.`SubGrupo3` AS `SubGrupo3`,`fi`.`SubGrupo4` AS `SubGrupo4`,`fi`.`SubGrupo5` AS `SubGrupo5`,`fi`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`Dias` AS `Dias`,`fi`.`SubtotalItem` AS `SubtotalItem`,`fi`.`IVAItem` AS `IVAItem`,`fi`.`ValorOtrosImpuestos` AS `ValorOtrosImpuestos`,`fi`.`TotalItem` AS `TotalItem`,`fi`.`PorcentajeIVA` AS `PorcentajeIVA`,`fi`.`idOtrosImpuestos` AS `idOtrosImpuestos`,`fi`.`idPorcentajeIVA` AS `idPorcentajeIVA`,`fi`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`fi`.`SubtotalCosto` AS `SubtotalCosto`,`fi`.`TipoItem` AS `TipoItem`,`fi`.`CuentaPUC` AS `CuentaPUC`,`fi`.`GeneradoDesde` AS `GeneradoDesde`,`fi`.`NumeroIdentificador` AS `NumeroIdentificador`,`fi`.`idUsuarios` AS `idUsuarios`,`fi`.`idCierre` AS `idCierre`,`f`.`idResolucion` AS `idResolucion`,`f`.`TipoFactura` AS `TipoFactura`,`f`.`Prefijo` AS `Prefijo`,`f`.`NumeroFactura` AS `NumeroFactura`,`f`.`Hora` AS `Hora`,`f`.`FormaPago` AS `FormaPago`,`f`.`CentroCosto` AS `CentroCosto`,`f`.`idSucursal` AS `idSucursal`,`f`.`EmpresaPro_idEmpresaPro` AS `EmpresaPro_idEmpresaPro`,`f`.`Clientes_idClientes` AS `Clientes_idClientes`,`f`.`ObservacionesFact` AS `ObservacionesFact` from (`ori_facturas_items` `fi` join `facturas` `f` on((`fi`.`idFactura` = `f`.`idFacturas`)));

DROP TABLE IF EXISTS `vista_pedidos_restaurante`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_pedidos_restaurante` AS select `restaurante_pedidos`.`ID` AS `ID`,`restaurante_pedidos`.`Fecha` AS `Fecha`,`restaurante_pedidos`.`Hora` AS `Hora`,`restaurante_pedidos`.`Estado` AS `Estado`,`restaurante_pedidos`.`idMesa` AS `idMesa`,`restaurante_pedidos`.`idCliente` AS `idCliente`,`restaurante_pedidos`.`NombreCliente` AS `NombreCliente`,`restaurante_pedidos`.`DireccionEnvio` AS `DireccionEnvio`,`restaurante_pedidos`.`TelefonoConfirmacion` AS `TelefonoConfirmacion`,`restaurante_pedidos`.`Observaciones` AS `Observaciones`,`restaurante_pedidos`.`idCierre` AS `idCierre`,(select sum(`restaurante_pedidos_items`.`Subtotal`) AS `Subtotal` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `Subtotal`,(select sum(`restaurante_pedidos_items`.`IVA`) AS `IVA` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `IVA`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `Total`,`restaurante_pedidos`.`idUsuario` AS `idUsuario` from `restaurante_pedidos`;

DROP TABLE IF EXISTS `vista_preventa`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_preventa` AS select `p`.`VestasActivas_idVestasActivas` AS `VestasActivas_idVestasActivas`,'productosventa' AS `TablaItems`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `SubGrupo1`,`pv`.`Sub2` AS `SubGrupo2`,`pv`.`Sub3` AS `SubGrupo3`,`pv`.`Sub4` AS `SubGrupo4`,`pv`.`Sub5` AS `SubGrupo5`,`p`.`ValorAcordado` AS `ValorUnitarioItem`,`p`.`Cantidad` AS `Cantidad`,'1' AS `Dias`,(`p`.`ValorAcordado` * `p`.`Cantidad`) AS `SubtotalItem`,((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`) AS `IVAItem`,((select `productos_impuestos_adicionales`.`ValorImpuesto` from `productos_impuestos_adicionales` where (`productos_impuestos_adicionales`.`idProducto` = `p`.`ProductosVenta_idProductosVenta`)) * `p`.`Cantidad`) AS `ValorOtrosImpuestos`,((`p`.`ValorAcordado` * `p`.`Cantidad`) + ((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`)) AS `TotalItem`,concat((`pv`.`IVA` * 100),'%') AS `PorcentajeIVA`,`pv`.`CostoUnitario` AS `PrecioCostoUnitario`,(`pv`.`CostoUnitario` * `p`.`Cantidad`) AS `SubtotalCosto`,(select `prod_departamentos`.`TipoItem` from `prod_departamentos` where (`prod_departamentos`.`idDepartamentos` = `pv`.`Departamento`)) AS `TipoItem`,`pv`.`CuentaPUC` AS `CuentaPUC`,`p`.`Updated` AS `Updated`,`p`.`Sync` AS `Sync` from (`preventa` `p` join `productosventa` `pv` on((`p`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`))) where (`p`.`TablaItem` = 'productosventa');

DROP TABLE IF EXISTS `vista_resumen_facturacion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_facturacion` AS select `facturas_items`.`ID` AS `ID`,`facturas_items`.`FechaFactura` AS `FechaInicial`,`facturas_items`.`FechaFactura` AS `FechaFinal`,`facturas_items`.`Referencia` AS `Referencia`,(select `productosventa`.`idProductosVenta` from `productosventa` where (`productosventa`.`Referencia` = `facturas_items`.`Referencia`)) AS `idProducto`,`facturas_items`.`Nombre` AS `Nombre`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,sum(`facturas_items`.`Cantidad`) AS `Cantidad`,round(sum(`facturas_items`.`TotalItem`),2) AS `TotalVenta`,round(sum(`facturas_items`.`SubtotalCosto`),2) AS `Costo` from `facturas_items` group by `facturas_items`.`FechaFactura`,`facturas_items`.`Referencia`;

DROP TABLE IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_ventas_departamentos` AS select `facturas_items`.`FechaFactura` AS `FechaFactura`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,sum(`facturas_items`.`TotalItem`) AS `Total` from `facturas_items` group by `facturas_items`.`FechaFactura`,`facturas_items`.`Departamento`,`facturas_items`.`SubGrupo1`,`facturas_items`.`SubGrupo2`,`facturas_items`.`SubGrupo3`,`facturas_items`.`SubGrupo4`,`facturas_items`.`SubGrupo5`;

DROP TABLE IF EXISTS `vista_retenciones`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_retenciones` AS select `factura_compra_retenciones`.`idCompra` AS `idCompra`,(select `factura_compra`.`Fecha` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `Fecha`,(select `factura_compra`.`Tercero` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `Tercero`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `RazonSocial`,(select `proveedores`.`DV` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `DV`,(select `proveedores`.`Direccion` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `Direccion`,(select `proveedores`.`Ciudad` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `Ciudad`,`factura_compra_retenciones`.`CuentaPUC` AS `CuentaPUC`,`factura_compra_retenciones`.`NombreCuenta` AS `Cuenta`,`factura_compra_retenciones`.`ValorRetencion` AS `ValorRetencion`,`factura_compra_retenciones`.`PorcentajeRetenido` AS `PorcentajeRetenido`,round(((`factura_compra_retenciones`.`ValorRetencion` / `factura_compra_retenciones`.`PorcentajeRetenido`) * 100),2) AS `BaseRetencion`,(select `factura_compra`.`idEmpresa` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idEmpresa`,(select `factura_compra`.`idCentroCostos` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idCentroCostos`,(select `factura_compra`.`idSucursal` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idSucursal` from `factura_compra_retenciones`;

DROP TABLE IF EXISTS `vista_retenciones_tercero`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_retenciones_tercero` AS select `vista_retenciones`.`idCompra` AS `idCompra`,`vista_retenciones`.`Fecha` AS `Fecha`,`vista_retenciones`.`Tercero` AS `Tercero`,`vista_retenciones`.`RazonSocial` AS `RazonSocial`,`vista_retenciones`.`DV` AS `DV`,`vista_retenciones`.`Direccion` AS `Direccion`,`vista_retenciones`.`Ciudad` AS `Ciudad`,`vista_retenciones`.`CuentaPUC` AS `CuentaPUC`,`vista_retenciones`.`Cuenta` AS `Cuenta`,`vista_retenciones`.`ValorRetencion` AS `ValorRetencion`,`vista_retenciones`.`PorcentajeRetenido` AS `PorcentajeRetenido`,`vista_retenciones`.`BaseRetencion` AS `BaseRetencion` from `vista_retenciones` where ((`vista_retenciones`.`Fecha` >= '2019-01-20') and (`vista_retenciones`.`Fecha` <= '2019-01-20') and (`vista_retenciones`.`Tercero` = '94481747'));

DROP TABLE IF EXISTS `vista_sistemas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_sistemas` AS select `si`.`ID` AS `ID`,`st`.`ID` AS `idSistema`,`st`.`Nombre` AS `Nombre_Sistema`,`st`.`Observaciones` AS `Observaciones`,`si`.`TablaOrigen` AS `TablaOrigen`,`s`.`idProductosVenta` AS `CodigoInterno`,`s`.`Nombre` AS `Nombre`,`si`.`Cantidad` AS `Cantidad`,`si`.`ValorUnitario` AS `PrecioUnitario`,round((`si`.`ValorUnitario` * `si`.`Cantidad`),0) AS `PrecioVenta`,round(`s`.`CostoUnitario`,0) AS `CostoUnitario`,round((`si`.`Cantidad` * `s`.`CostoUnitario`),0) AS `Costo_Total_Item`,`s`.`IVA` AS `IVA`,`s`.`Departamento` AS `Departamento`,`s`.`Sub1` AS `Sub1`,`s`.`Sub2` AS `Sub2`,`s`.`Sub3` AS `Sub3`,`s`.`Sub4` AS `Sub4`,`s`.`Sub5` AS `Sub5`,`st`.`Updated` AS `Updated`,`st`.`Sync` AS `Sync` from ((`sistemas_relaciones` `si` join `servicios` `s` on((`s`.`Referencia` = `si`.`Referencia`))) join `sistemas` `st` on((`st`.`ID` = `si`.`idSistema`))) union select `si`.`ID` AS `ID`,`st`.`ID` AS `idSistema`,`st`.`Nombre` AS `Nombre_Sistema`,`st`.`Observaciones` AS `Observaciones`,`si`.`TablaOrigen` AS `TablaOrigen`,`s`.`idProductosVenta` AS `CodigoInterno`,`s`.`Nombre` AS `Nombre`,`si`.`Cantidad` AS `Cantidad`,`si`.`ValorUnitario` AS `PrecioUnitario`,round((`si`.`ValorUnitario` * `si`.`Cantidad`),0) AS `PrecioVenta`,round(`s`.`CostoUnitario`,0) AS `CostoUnitario`,round((`si`.`Cantidad` * `s`.`CostoUnitario`),0) AS `Costo_Total_Item`,`s`.`IVA` AS `IVA`,`s`.`Departamento` AS `Departamento`,`s`.`Sub1` AS `Sub1`,`s`.`Sub2` AS `Sub2`,`s`.`Sub3` AS `Sub3`,`s`.`Sub4` AS `Sub4`,`s`.`Sub5` AS `Sub5`,`st`.`Updated` AS `Updated`,`st`.`Sync` AS `Sync` from ((`sistemas_relaciones` `si` join `productosventa` `s` on((`s`.`Referencia` = `si`.`Referencia`))) join `sistemas` `st` on((`st`.`ID` = `si`.`idSistema`)));

DROP TABLE IF EXISTS `vista_titulos_abonos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_abonos` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`Hora` AS `Hora`,`td`.`Monto` AS `Monto`,`td`.`idVenta` AS `idVenta`,`tv`.`Promocion` AS `Promocion`,`tv`.`Mayor1` AS `Mayor`,`td`.`Observaciones` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`Estado` AS `Estado`,`td`.`idComprobanteIngreso` AS `idComprobanteIngreso`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_abonos` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_titulos_comisiones`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_comisiones` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`Hora` AS `Hora`,`td`.`Monto` AS `Monto`,`td`.`idVenta` AS `idVenta`,`tv`.`Promocion` AS `Promocion`,`tv`.`Mayor1` AS `Mayor`,`td`.`Observaciones` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`idUsuario` AS `idUsuario`,`td`.`idEgreso` AS `idEgreso`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_comisiones` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_titulos_devueltos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_devueltos` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`idVenta` AS `idVenta`,`td`.`Promocion` AS `Promocion`,`td`.`Mayor` AS `Mayor`,`td`.`Concepto` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`idUsuario` AS `idUsuario`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_devoluciones` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_totales_facturacion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_totales_facturacion` AS select `facturas_items`.`FechaFactura` AS `FechaFactura`,sum(`facturas_items`.`Cantidad`) AS `Items`,round(sum(`facturas_items`.`SubtotalItem`),0) AS `Subtotal`,round(sum(`facturas_items`.`IVAItem`),0) AS `IVA`,round(sum(`facturas_items`.`ValorOtrosImpuestos`),0) AS `OtrosImpuestos`,round(sum(`facturas_items`.`TotalItem`),0) AS `Total` from `facturas_items` group by `facturas_items`.`FechaFactura`;

-- 2019-04-12 14:22:54
