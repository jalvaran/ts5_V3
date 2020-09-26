-- Adminer 4.7.5 MySQL dump

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


DROP TABLE IF EXISTS `acuerdo_pago`;
CREATE TABLE `acuerdo_pago` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'identificador unico del acuerdo de pago',
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL COMMENT 'Fecha del acuerdo',
  `FechaInicialParaPagos` date NOT NULL COMMENT 'Fecha donde se inicia a pagar el credito',
  `Tercero` bigint(20) NOT NULL COMMENT 'NIT del tercero con el cual se realiza el acuerdo de pago',
  `ValorCuotaGeneral` double NOT NULL COMMENT 'Valor de la cuota que se elige al crear un acuerdo de pago',
  `CicloPagos` int(11) NOT NULL COMMENT 'Ciclo de pagos, proviene de la tabla acuerdo_pago_ciclos_pagos, normalmente sera semanal, quincenal o mensual',
  `NumeroCuotas` int(11) NOT NULL COMMENT 'Cantidad de cuotas para el acuerdo de pago',
  `SaldoAnterior` double NOT NULL COMMENT 'Saldo anterior del cliente, viene de la sumatoria de la cuenta contable 1305',
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'observaciones del acuerdo',
  `SaldoInicial` double NOT NULL COMMENT 'Saldo inicial del acuerdo, sera el valor de la factura a credito mas el saldo anterior',
  `TotalAbonos` double NOT NULL COMMENT 'Registra el total de abonos realizados al documento',
  `SaldoFinal` double NOT NULL COMMENT 'Registra el saldo final con el que queda el documento',
  `Estado` int(11) NOT NULL COMMENT 'Estado en el que se encuentra el documento, relacionado con la tabla acuerdo_pago_estados',
  `idUser` int(11) NOT NULL COMMENT 'usuario que lo crea',
  `Created` datetime NOT NULL COMMENT 'Fecha de creacion del registro',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Tercero` (`Tercero`),
  KEY `CicloPagos` (`CicloPagos`),
  KEY `NumeroCuotas` (`NumeroCuotas`),
  KEY `Estado` (`Estado`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`),
  KEY `idFactura` (`idFactura`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_abonos_anulaciones`;
CREATE TABLE `acuerdo_pago_abonos_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAbono` bigint(20) NOT NULL,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Created` date NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`),
  KEY `idAbono` (`idAbono`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_anulaciones`;
CREATE TABLE `acuerdo_pago_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Created` date NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_ciclos_pagos`;
CREATE TABLE `acuerdo_pago_ciclos_pagos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCiclo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumeroDias` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_cuotas_pagadas`;
CREATE TABLE `acuerdo_pago_cuotas_pagadas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NumeroCuota` int(11) NOT NULL COMMENT 'Numero de la cuota que se paga, relacionada con la tabla acuerdo_pago_cuotas_planeadas',
  `idProyeccion` bigint(20) NOT NULL COMMENT 'id de la proyeccion de cuotas que se paga',
  `TipoCuota` int(11) NOT NULL COMMENT '1 para Inicial, 2 para cuota programada, 3 para cuota normal',
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id unico del acuerdo de pago',
  `FechaPago` date NOT NULL COMMENT 'Fecha del pago',
  `ValorPago` double NOT NULL COMMENT 'Valor que paga el cliente',
  `MetodoPago` int(11) NOT NULL COMMENT 'Relacion con la tabla metodos_pago, efectivo, tarjetas, cheques, bonos etc',
  `idUser` int(11) NOT NULL COMMENT 'usuario que recibe la cuota',
  `Estado` int(11) NOT NULL DEFAULT '1',
  `idCierre` bigint(20) NOT NULL COMMENT 'id del cierre donde se suma el abono del cliente, relaciona con la tabla cajas_aperturas_cierres',
  `Created` datetime NOT NULL COMMENT 'Fecha en que se crea el registro',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCierre` (`idCierre`),
  KEY `idUser` (`idUser`),
  KEY `NumeroCuota` (`NumeroCuota`),
  KEY `TipoCuota` (`TipoCuota`),
  KEY `MetodoPago` (`MetodoPago`),
  KEY `idProyeccion` (`idProyeccion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_cuotas_pagadas_estados`;
CREATE TABLE `acuerdo_pago_cuotas_pagadas_estados` (
  `ID` int(11) NOT NULL,
  `NombreEstado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_cuotas_pagadas_temp`;
CREATE TABLE `acuerdo_pago_cuotas_pagadas_temp` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NumeroCuota` int(11) NOT NULL COMMENT 'Numero de la cuota que se paga, relacionada con la tabla acuerdo_pago_cuotas_planeadas',
  `TipoCuota` int(11) NOT NULL COMMENT '1 para Inicial, 2 para cuota programada, 3 para cuota normal',
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id unico del acuerdo de pago',
  `FechaPago` date NOT NULL COMMENT 'Fecha del pago',
  `ValorPago` double NOT NULL COMMENT 'Valor que paga el cliente',
  `MetodoPago` int(11) NOT NULL COMMENT 'Relacion con la tabla metodos_pago, efectivo, tarjetas, cheques, bonos etc',
  `Estado` int(11) NOT NULL,
  `idUser` int(11) NOT NULL COMMENT 'usuario que recibe la cuota',
  `idCierre` bigint(20) NOT NULL COMMENT 'id del cierre donde se suma el abono del cliente, relaciona con la tabla cajas_aperturas_cierres',
  `Created` datetime NOT NULL COMMENT 'Fecha en que se crea el registro',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCierre` (`idCierre`),
  KEY `idUser` (`idUser`),
  KEY `NumeroCuota` (`NumeroCuota`),
  KEY `TipoCuota` (`TipoCuota`),
  KEY `MetodoPago` (`MetodoPago`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_estados`;
CREATE TABLE `acuerdo_pago_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del estado',
  `Observaciones` tinytext COLLATE utf8_spanish_ci NOT NULL COMMENT 'Observaciones del estado, aplicacion, cuando aplica',
  `Created` datetime NOT NULL COMMENT 'Fecha de creacion del registro',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_hoja_trabajo_informes`;
CREATE TABLE `acuerdo_pago_hoja_trabajo_informes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ConsecutivoAcuerdo` bigint(20) NOT NULL DEFAULT '0',
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id del acuerdo de pago',
  `TipoCuota` int(11) NOT NULL COMMENT 'Tipo de cuota, 1 cuota programable, 2 Cuota Normal',
  `NumeroCuota` int(11) NOT NULL COMMENT 'Numero de Cuota',
  `Fecha` date NOT NULL COMMENT 'Fecha proyectada para pago',
  `ValorCuota` double NOT NULL COMMENT 'Valor de la cuota',
  `ValorPagado` double NOT NULL,
  `SaldoCuota` double NOT NULL,
  `idPago` bigint(20) NOT NULL,
  `EstadoProyeccion` int(11) NOT NULL COMMENT '0 sin pagar, 1 pago parcial, 2 pago completo',
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'observaciones del acuerdo',
  `FechaFinalConstruccion` char(0) CHARACTER SET latin1 NOT NULL,
  `SaldoPendiente` double DEFAULT NULL,
  `NombreEstadoProyeccion` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreTipoCuota` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero` bigint(20) NOT NULL COMMENT 'NIT del tercero con el cual se realiza el acuerdo de pago',
  `RazonSocial` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idClienteAcuerdo` bigint(11) DEFAULT NULL,
  `DireccionCliente` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TelefonoCliente` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `PuntajeCliente` bigint(11) DEFAULT NULL,
  `SobreNombreCliente` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorCuotaGeneral` double NOT NULL COMMENT 'Valor de la cuota que se elige al crear un acuerdo de pago',
  `CicloPagos` int(11) NOT NULL COMMENT 'Ciclo de pagos, proviene de la tabla acuerdo_pago_ciclos_pagos, normalmente sera semanal, quincenal o mensual',
  `NombreCicloPago` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SaldoAnterior` double(17,0) NOT NULL,
  `SaldoInicial` double(17,0) NOT NULL,
  `TotalAbonos` double NOT NULL COMMENT 'Registra el total de abonos realizados al documento',
  `SaldoFinal` double(17,0) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ConsecutivoAcuerdo` (`ConsecutivoAcuerdo`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`),
  KEY `TipoCuota` (`TipoCuota`),
  KEY `NumeroCuota` (`NumeroCuota`),
  KEY `EstadoProyeccion` (`EstadoProyeccion`),
  KEY `Tercero` (`Tercero`),
  KEY `CicloPagos` (`CicloPagos`),
  KEY `TelefonoCliente` (`TelefonoCliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_productos_devueltos`;
CREATE TABLE `acuerdo_pago_productos_devueltos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idFacturasItems` bigint(20) NOT NULL,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorDevolucion` double NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFacturasItems` (`idFacturasItems`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_proyeccion_estados`;
CREATE TABLE `acuerdo_pago_proyeccion_estados` (
  `ID` int(11) NOT NULL,
  `NombreEstado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_proyeccion_pagos`;
CREATE TABLE `acuerdo_pago_proyeccion_pagos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id del acuerdo de pago',
  `TipoCuota` int(11) NOT NULL COMMENT 'Tipo de cuota, 1 cuota programable, 2 Cuota Normal',
  `NumeroCuota` int(11) NOT NULL COMMENT 'Numero de Cuota',
  `Fecha` date NOT NULL COMMENT 'Fecha proyectada para pago',
  `ValorCuota` double NOT NULL COMMENT 'Valor de la cuota',
  `ValorPagado` double NOT NULL,
  `idPago` bigint(20) NOT NULL,
  `Estado` int(11) NOT NULL COMMENT '0 sin pagar, 1 pago parcial, 2 pago completo',
  `idUser` int(11) NOT NULL COMMENT 'usuario creador',
  `Created` datetime NOT NULL COMMENT 'Fecha y hora del registro',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`),
  KEY `Estado` (`Estado`),
  KEY `idPago` (`idPago`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_proyeccion_pagos_temp`;
CREATE TABLE `acuerdo_pago_proyeccion_pagos_temp` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoCuota` int(11) NOT NULL COMMENT 'Tipo de cuota, 1 cuota programable, 2 Cuota Normal',
  `NumeroCuota` int(11) NOT NULL COMMENT 'Numero de Cuota',
  `Fecha` date NOT NULL COMMENT 'Fecha proyectada para pago',
  `ValorCuota` double NOT NULL COMMENT 'Valor de la cuota',
  `Estado` int(11) NOT NULL COMMENT '0 sin pagar, 1 pago parcial, 2 pago completo',
  `idUser` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idAcuerdoPago` (`idAcuerdoPago`),
  KEY `Estado` (`Estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_rel_abonos_comprobantes`;
CREATE TABLE `acuerdo_pago_rel_abonos_comprobantes` (
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobante` bigint(20) NOT NULL,
  `Created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `idAcuerdoPago` (`idAcuerdoPago`),
  KEY `idComprobante` (`idComprobante`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_pago_tipo_cuota`;
CREATE TABLE `acuerdo_pago_tipo_cuota` (
  `ID` int(11) NOT NULL,
  `NombreTipoCuota` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `acuerdo_recargos_intereses`;
CREATE TABLE `acuerdo_recargos_intereses` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idAcuerdoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id unico del acuerdo de pago',
  `FechaPago` date NOT NULL COMMENT 'Fecha del pago',
  `ValorRecargoInteres` double NOT NULL COMMENT 'Valor que paga el cliente',
  `MetodoPago` int(11) NOT NULL COMMENT 'Relacion con la tabla metodos_pago, efectivo, tarjetas, cheques, bonos etc',
  `idUser` int(11) NOT NULL COMMENT 'usuario que recibe la cuota',
  `idCierre` bigint(20) NOT NULL COMMENT 'id del cierre donde se suma el abono del cliente, relaciona con la tabla cajas_aperturas_cierres',
  `Created` datetime NOT NULL COMMENT 'Fecha en que se crea el registro',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCierre` (`idCierre`),
  KEY `idUser` (`idUser`),
  KEY `MetodoPago` (`MetodoPago`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `alertas`;
CREATE TABLE `alertas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AlertaTipo` enum('Backups,Normal') NOT NULL,
  `Mensaje` text NOT NULL,
  `Estado` int(11) NOT NULL,
  `TablaOrigen` varchar(100) NOT NULL,
  `idTabla` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `anticipos_encargos`;
CREATE TABLE `anticipos_encargos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL COMMENT 'Fecha del anticipo',
  `Tercero` bigint(20) NOT NULL COMMENT 'Tercero que da el anticipo',
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'Observaciones del anticipo',
  `idUser` int(11) NOT NULL COMMENT 'Usuario que recibe',
  `Estado` int(11) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de Creacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Tercero` (`Tercero`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `anticipos_encargos_abonos`;
CREATE TABLE `anticipos_encargos_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idAnticipo` bigint(20) NOT NULL,
  `Metodo` int(11) NOT NULL,
  `Valor` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idAnticipo` (`idAnticipo`),
  KEY `Metodo` (`Metodo`),
  KEY `idUser` (`idUser`),
  KEY `idCierre` (`idCierre`),
  KEY `idComprobanteIngreso` (`idComprobanteIngreso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `anticipos_encargos_estados`;
CREATE TABLE `anticipos_encargos_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  `TotalAbonosAcuerdos` double DEFAULT NULL,
  `TotalAbonosSeparados` double DEFAULT NULL,
  `TotalVentasSisteCredito` double NOT NULL,
  `TotalRetiroSeparados` double NOT NULL,
  `TotalDevoluciones` double NOT NULL,
  `TotalTarjetas` double NOT NULL,
  `TotalCheques` double NOT NULL,
  `TotalOtros` double NOT NULL,
  `TotalEntrega` double NOT NULL,
  `EfectivoRecaudado` double DEFAULT NULL,
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


DROP TABLE IF EXISTS `catalogo_departamentos`;
CREATE TABLE `catalogo_departamentos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint(20) unsigned NOT NULL,
  `Nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoDANE` char(255) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NULL DEFAULT NULL,
  `Sync` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `CodigoDANE` (`CodigoDANE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `catalogo_impuestos`;
CREATE TABLE `catalogo_impuestos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `code` char(255) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NULL DEFAULT NULL,
  `Sync` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `catalogo_municipios`;
CREATE TABLE `catalogo_municipios` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint(20) unsigned NOT NULL,
  `Nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoDANE` char(255) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NULL DEFAULT NULL,
  `Sync` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `CodigoDANE` (`CodigoDANE`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `centrocosto`;
CREATE TABLE `centrocosto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cierres_contables`;
CREATE TABLE `cierres_contables` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cierre_contable_control`;
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
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idDocumentoContable` (`idDocumentoContable`),
  KEY `Anio` (`Anio`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ciuu`;
CREATE TABLE `ciuu` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `clasecuenta`;
CREATE TABLE `clasecuenta` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clase` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  `Cod_Dpto` int(2) unsigned zerofill NOT NULL,
  `Cod_Mcipio` int(3) unsigned zerofill NOT NULL,
  `Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Contacto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelContacto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CIUU` int(11) NOT NULL,
  `TipoOrganizacion` int(11) NOT NULL COMMENT '1 juridico, 2 natural',
  `Cupo` double NOT NULL,
  `DiaNacimiento` int(11) NOT NULL,
  `MesNacimiento` int(11) NOT NULL,
  `Plazo` int(5) unsigned NOT NULL,
  `CodigoTarjeta` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Puntaje` int(2) NOT NULL DEFAULT '80',
  `Estado` int(11) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idClientes`),
  KEY `Num_Identificacion` (`Num_Identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `clientes_datos_adicionales`;
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


DROP TABLE IF EXISTS `clientes_recomendados`;
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


DROP TABLE IF EXISTS `cod_departamentos`;
CREATE TABLE `cod_departamentos` (
  `Cod_dpto` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Cod_dpto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cod_documentos`;
CREATE TABLE `cod_documentos` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `Codigo` (`Codigo`),
  KEY `Codigo_2` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `cod_paises`;
CREATE TABLE `cod_paises` (
  `Codigo` int(11) NOT NULL,
  `Pais` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `comercial_plataformas_pago_ingresos`;
CREATE TABLE `comercial_plataformas_pago_ingresos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idPlataformaPago` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Valor` double NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `Inicial` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Tercero` (`Tercero`),
  KEY `idComprobanteIngreso` (`idComprobanteIngreso`),
  KEY `idCierre` (`idCierre`),
  KEY `idUser` (`idUser`),
  KEY `Inicial` (`Inicial`)
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


DROP TABLE IF EXISTS `configuracion_correos_smtp`;
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


DROP TABLE IF EXISTS `configuracion_general`;
CREATE TABLE `configuracion_general` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `contabilidad_parametros_cuentasxcobrar`;
CREATE TABLE `contabilidad_parametros_cuentasxcobrar` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `contabilidad_parametros_cuentasxpagar`;
CREATE TABLE `contabilidad_parametros_cuentasxpagar` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `costos`;
CREATE TABLE `costos` (
  `idCostos` int(20) NOT NULL AUTO_INCREMENT,
  `NombreCosto` varchar(45) NOT NULL,
  `ValorCosto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCostos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
  `Fecha` date NOT NULL,
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


DROP TABLE IF EXISTS `documentos_contables_registro_bases`;
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


DROP TABLE IF EXISTS `domi_usuarios_as_locales`;
CREATE TABLE `domi_usuarios_as_locales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idLocal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  `CerradoDiario` bigint(20) NOT NULL,
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
  `CodigoDaneCiudad` int(5) unsigned zerofill NOT NULL,
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
  `TokenAPIFE` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEmpresaPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `empresapro_regimenes`;
CREATE TABLE `empresapro_regimenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Regimen` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `empresapro_resoluciones_facturacion`;
CREATE TABLE `empresapro_resoluciones_facturacion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreInterno` text COLLATE utf8_spanish_ci NOT NULL,
  `NumResolucion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `NumSolicitud` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `Factura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FacturaElectronica` int(1) NOT NULL,
  `Prefijo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Desde` int(16) NOT NULL,
  `Hasta` int(16) NOT NULL,
  `FechaDesde` date NOT NULL,
  `FechaVencimiento` date NOT NULL,
  `technical_key` varchar(95) COLLATE utf8_spanish_ci NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL COMMENT 'OC: Ocupada',
  `Completada` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `empresa_cargos`;
CREATE TABLE `empresa_cargos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCargo` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `empresa_nombres_procesos`;
CREATE TABLE `empresa_nombres_procesos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreProceso` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  KEY `ReporteFacturaElectronica` (`ReporteFacturaElectronica`),
  KEY `TipoFactura` (`TipoFactura`),
  KEY `FormaPago` (`FormaPago`),
  KEY `Clientes_idClientes` (`Clientes_idClientes`)
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
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Valor` double NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `CuentaIngreso` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`)
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


DROP TABLE IF EXISTS `facturas_contabilizar`;
CREATE TABLE `facturas_contabilizar` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`),
  KEY `Estado` (`Estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `facturas_electronicas_estados_acuse`;
CREATE TABLE `facturas_electronicas_estados_acuse` (
  `ID` varchar(2) NOT NULL,
  `NombreEstadoAcuse` varchar(25) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `facturas_electronicas_log`;
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


DROP TABLE IF EXISTS `facturas_electronicas_log_estados`;
CREATE TABLE `facturas_electronicas_log_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_electronicas_parametros`;
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
  `Realizada` int(1) NOT NULL,
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
  KEY `Referencia` (`Referencia`),
  KEY `GeneradoDesde` (`GeneradoDesde`),
  KEY `NumeroIdentificador` (`NumeroIdentificador`)
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
  `idCierre` double NOT NULL,
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
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
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
  `ValorComision4` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `inventario_comprobante_movimientos`;
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


DROP TABLE IF EXISTS `inventario_comprobante_movimientos_items`;
CREATE TABLE `inventario_comprobante_movimientos_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `TipoMovimiento` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` double NOT NULL,
  `CostoTotal` double NOT NULL,
  `idComprobante` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `TablaOrigen` (`TablaOrigen`),
  KEY `idProducto` (`idProducto`),
  KEY `idComprobante` (`idComprobante`),
  KEY `idCierre` (`idCierre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idLibroDiario`),
  KEY `Tipo_Documento_Intero` (`Tipo_Documento_Intero`),
  KEY `Tercero_Identificacion` (`Tercero_Identificacion`),
  KEY `Num_Documento_Interno` (`Num_Documento_Interno`),
  KEY `CuentaPUC` (`CuentaPUC`),
  KEY `Fecha` (`Fecha`),
  KEY `idCierre` (`idCierre`),
  KEY `idUsuario` (`idUsuario`),
  KEY `Num_Documento_Externo` (`Num_Documento_Externo`)
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


DROP TABLE IF EXISTS `menu_carpetas`;
CREATE TABLE `menu_carpetas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `metodos_pago`;
CREATE TABLE `metodos_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Metodo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  `SoloAdmin` int(11) NOT NULL,
  `CuentaPUCIngresos` bigint(20) NOT NULL,
  `NombreCuentaPUCIngresos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUCEgresos` bigint(20) NOT NULL,
  `NombreCuentaPUCEgresos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `modelos_agenda`;
CREATE TABLE `modelos_agenda` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idModelo` int(11) NOT NULL,
  `TipoServicio` int(11) NOT NULL,
  `Efectivo` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `ValorPagado` double NOT NULL,
  `ValorModelo` double NOT NULL,
  `ValorCasa` double NOT NULL,
  `Minutos` int(11) NOT NULL,
  `HoraInicial` datetime NOT NULL,
  `HoraATerminar` datetime NOT NULL,
  `HoraFinalizacion` datetime NOT NULL,
  `idCierreModelo` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Estado` int(2) NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idModelo` (`idModelo`),
  KEY `idCierre` (`idCierre`),
  KEY `Estado` (`Estado`),
  KEY `TipoServicio` (`TipoServicio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `modelos_cierres`;
CREATE TABLE `modelos_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `modelos_config_factura`;
CREATE TABLE `modelos_config_factura` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idItemFactura` bigint(20) NOT NULL,
  `TablaItem` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `modelos_pagos_realizados`;
CREATE TABLE `modelos_pagos_realizados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` datetime NOT NULL,
  `idModelo` int(11) NOT NULL,
  `ValorPagado` double NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idModelo` (`idModelo`),
  KEY `idCierre` (`idCierre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `modelos_tipo_servicios`;
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


DROP TABLE IF EXISTS `nomina_parametros_generales`;
CREATE TABLE `nomina_parametros_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `notas_credito`;
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


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `notas_credito_conceptos`;
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


DROP TABLE IF EXISTS `notas_credito_items`;
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
  `idImpuestoAPIFE` int(11) NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `pos_registro_descuentos`;
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
  `ValorComision4` int(11) NOT NULL,
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

DROP TABLE IF EXISTS `productosventa_bodega_1`;
CREATE TABLE `productosventa_bodega_1` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_bodega_2`;
CREATE TABLE `productosventa_bodega_2` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_bodega_3`;
CREATE TABLE `productosventa_bodega_3` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_bodega_4`;
CREATE TABLE `productosventa_bodega_4` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_bodega_5`;
CREATE TABLE `productosventa_bodega_5` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_complementos`;
CREATE TABLE `productosventa_complementos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Estado` int(11) NOT NULL DEFAULT '0',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_complementos_items`;
CREATE TABLE `productosventa_complementos_items` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `complemento_id` int(11) NOT NULL DEFAULT '0',
  `dia_semana_id` int(11) NOT NULL DEFAULT '0' COMMENT '0 para toda la semana, 1 lunes, 2 martes ... 7 domingo',
  `url_imagen` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Estado` int(11) NOT NULL DEFAULT '0',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `complemento_id` (`complemento_id`),
  KEY `dia_semana_id` (`dia_semana_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_temp`;
CREATE TABLE `productosventa_temp` (
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
  `ValorComision4` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productos_has_complementos`;
CREATE TABLE `productos_has_complementos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `complemento_id` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idProducto` (`idProducto`),
  KEY `complemento_id` (`complemento_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  PRIMARY KEY (`idCodBarras`),
  KEY `ProductosVenta_idProductosVenta` (`ProductosVenta_idProductosVenta`),
  KEY `CodigoBarras` (`CodigoBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_1`;
CREATE TABLE `prod_codbarras_bodega_1` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_2`;
CREATE TABLE `prod_codbarras_bodega_2` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_3`;
CREATE TABLE `prod_codbarras_bodega_3` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_4`;
CREATE TABLE `prod_codbarras_bodega_4` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_5`;
CREATE TABLE `prod_codbarras_bodega_5` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_temp`;
CREATE TABLE `prod_codbarras_temp` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'productosventa',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`),
  KEY `ProductosVenta_idProductosVenta` (`ProductosVenta_idProductosVenta`),
  KEY `CodigoBarras` (`CodigoBarras`)
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
  `Cod_Dpto` int(2) unsigned zerofill NOT NULL,
  `Cod_Mcipio` int(3) unsigned zerofill NOT NULL,
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
  `TipoOrganizacion` int(11) NOT NULL COMMENT '1 juridico, 2 natural',
  `Cupo` double NOT NULL,
  `DiaNacimiento` int(11) NOT NULL,
  `MesNacimiento` int(11) NOT NULL,
  `Plazo` int(11) NOT NULL COMMENT 'plazo para pago de facturas',
  `CodigoTarjeta` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Puntaje` int(11) NOT NULL DEFAULT '80',
  `Estado` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProveedores`),
  KEY `Num_Identificacion` (`Num_Identificacion`)
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


DROP TABLE IF EXISTS `respuestas_tipo_item`;
CREATE TABLE `respuestas_tipo_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_cierres`;
CREATE TABLE `restaurante_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `EfectivoEnCaja` double NOT NULL,
  `Diferencia` double NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `restaurante_estados_mesas`;
CREATE TABLE `restaurante_estados_mesas` (
  `ID` int(11) NOT NULL,
  `NombreEstado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_estados_pedidos`;
CREATE TABLE `restaurante_estados_pedidos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEstado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_estados_pedidos_items`;
CREATE TABLE `restaurante_estados_pedidos_items` (
  `ID` int(11) NOT NULL,
  `NombreEstado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_mesas`;
CREATE TABLE `restaurante_mesas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Estado` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_pedidos`;
CREATE TABLE `restaurante_pedidos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `Estado` int(11) NOT NULL COMMENT '''AB'' Abierto,''FAPE'' pedido facturado, ''FADO'' domicilio facturado, ''DEPE'' pedido descartado, ''DEDO'' domicilios descartados',
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
  PRIMARY KEY (`ID`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idMesa` (`idMesa`),
  KEY `Estado` (`Estado`),
  KEY `Tipo` (`Tipo`),
  KEY `idCierre` (`idCierre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_pedidos_items`;
CREATE TABLE `restaurante_pedidos_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idPedido` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `NombreProducto` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `TotalCostos` double NOT NULL,
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


DROP TABLE IF EXISTS `restaurante_pedidos_items_complementos`;
CREATE TABLE `restaurante_pedidos_items_complementos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `pedido_item_id` bigint(20) NOT NULL COMMENT 'id del item del pedido',
  `complemento_id` bigint(20) NOT NULL COMMENT 'id del complemento agregado',
  `complemento_item_id` bigint(20) NOT NULL COMMENT 'id del item del complemento agregado',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `pedido_item_id` (`pedido_item_id`),
  KEY `complemento_id` (`complemento_id`),
  KEY `complemento_item_id` (`complemento_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `restaurante_registro_ventas_mesero`;
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


DROP TABLE IF EXISTS `restaurante_resumen_cierre`;
CREATE TABLE `restaurante_resumen_cierre` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `NombreProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` double NOT NULL,
  `Compra` double NOT NULL,
  `Ventas` double NOT NULL,
  `TrasladosRecibidos` double NOT NULL,
  `TrasladosRealizados` double NOT NULL,
  `Bajas` double NOT NULL,
  `Altas` double NOT NULL,
  `Saldo` double NOT NULL,
  `TotalVentas` double NOT NULL,
  `TotalPropinas1` double NOT NULL,
  `TotalPropinas2` double NOT NULL,
  `TotalPropinas3` double NOT NULL,
  `TotalPropinas4` double NOT NULL,
  `TotalCasa` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idProducto` (`idProducto`),
  KEY `idUser` (`idUser`),
  KEY `idCierre` (`idCierre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `restaurante_tipos_pedido`;
CREATE TABLE `restaurante_tipos_pedido` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `salud_rips_pagos_validados`;
CREATE TABLE `salud_rips_pagos_validados` (
  `id_rips_pagos_validados` int(20) NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_pagado` double(15,2) DEFAULT NULL COMMENT 'Valor que la eps pago',
  `valor_diferencia` double(15,2) DEFAULT NULL COMMENT 'Valor de la diferencia del valor neto a pagar y el valor pagado',
  `fecha_pago` date DEFAULT NULL COMMENT 'Fecha de pago del ultimo abono',
  `num_comprobante` int(15) DEFAULT NULL COMMENT 'Numero de comprobante del ultimo abono',
  `eps_radicacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero con que se radico la factura',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_rips_pagos_validados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de pagos validados';


DROP TABLE IF EXISTS `salud_rips_vencidos`;
CREATE TABLE `salud_rips_vencidos` (
  `id_rips_vencidos` int(20) NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `nom_cargue` varchar(8) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre con el que se hizo el cargue al sistema de cartera',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha Y Hora que se hizo el cargue',
  `eps_radicacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero con que se radico la factura',
  `fecha_vencimiento` date NOT NULL COMMENT 'Fecha de vencimiento de la facrura ',
  `fecha_ult_validacion` datetime DEFAULT NULL COMMENT 'Fecha de ultima validacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_rips_vencidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='archivos de rips vencidos';


DROP TABLE IF EXISTS `salud_tesoreria`;
CREATE TABLE `salud_tesoreria` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad que paga',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad que paga',
  `fecha_transaccion` date NOT NULL COMMENT 'fecha entra el dinero al banco',
  `num_transaccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de la transaccion con la cual entra al banco',
  `banco_transaccion` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del banco donde entra la transaccion',
  `num_cuenta_banco` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de cuenta en la cual entra la transaccion',
  `valor_transaccion` double(15,2) NOT NULL COMMENT 'Valor de transaccion ',
  `Soporte` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Soporte que argumenta  o justifica el pago',
  `observacion` text COLLATE utf8_spanish_ci COMMENT 'observaciones de diagnostico ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `idUser` int(11) DEFAULT NULL COMMENT 'usuario que registra',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de tesoreria';


DROP TABLE IF EXISTS `salud_tipo_glosas`;
CREATE TABLE `salud_tipo_glosas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoGlosa` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `salud_upload_control`;
CREATE TABLE `salud_upload_control` (
  `id_upload_control` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_cargue` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `Analizado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_upload_control`),
  KEY `nom_cargue` (`nom_cargue`)
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
  `IP` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `DataBase` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Puerto` int(11) NOT NULL,
  `TipoServidor` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  `SolicitaBase` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProyecto` int(11) NOT NULL,
  `TipoTicket` int(11) NOT NULL,
  `idModuloProyecto` int(11) NOT NULL,
  `Prioridad` int(11) NOT NULL,
  `FechaApertura` datetime NOT NULL,
  `Asunto` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  `idUsuarioSolicitante` int(11) NOT NULL,
  `idUsuarioAsignado` int(11) NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  `idUsuarioActualiza` int(11) NOT NULL,
  `FechaCierre` datetime NOT NULL,
  `idUsuarioCierra` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `TipoTicket` (`TipoTicket`),
  KEY `idProyecto` (`idProyecto`),
  KEY `idModuloProyecto` (`idModuloProyecto`),
  KEY `Estado` (`Estado`),
  KEY `Asunto` (`Asunto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tickets_adjuntos`;
CREATE TABLE `tickets_adjuntos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `NombreArchivo` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Extension` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Tamano` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `idMensaje` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idMensaje` (`idMensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tickets_estados`;
CREATE TABLE `tickets_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tickets_mensajes`;
CREATE TABLE `tickets_mensajes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idTicket` bigint(20) NOT NULL,
  `Mensaje` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idTicket` (`idTicket`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tickets_modulos_proyectos`;
CREATE TABLE `tickets_modulos_proyectos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProyecto` int(11) NOT NULL,
  `NombreModulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tickets_prioridad`;
CREATE TABLE `tickets_prioridad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Prioridad` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tickets_proyectos`;
CREATE TABLE `tickets_proyectos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Proyecto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tickets_tipo`;
CREATE TABLE `tickets_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoTicket` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCierre` (`idCierre`)
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
  `Cargo` int(5) unsigned zerofill NOT NULL,
  `Proceso` int(5) unsigned zerofill NOT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Role` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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
  `IdentificadorUnico` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Usuario_idUsuario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Clientes_idClientes` int(11) NOT NULL DEFAULT '0',
  `SaldoFavor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVestasActivas`),
  KEY `IdentificadorUnico` (`IdentificadorUnico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP VIEW IF EXISTS `vista_abonos`;
CREATE TABLE `vista_abonos` (`Tabla` varchar(16), `TipoAbono` varchar(45), `Fecha` date, `Valor` double, `idUsuario` int(11), `idCierre` bigint(20));


DROP VIEW IF EXISTS `vista_abonos_acuerdo_pago`;
CREATE TABLE `vista_abonos_acuerdo_pago` (`ID` bigint(20), `Tercero` bigint(20), `RazonSocialCliente` varchar(100), `NumeroCuota` int(11), `TipoCuota` int(11), `NombreTipoCuota` varchar(15), `idAcuerdoPago` varchar(45), `ConsecutivoAcuerdo` bigint(20), `FechaCuota` date, `Fecha` date, `ValorPago` double, `MetodoPago` int(11), `NombreMetodoPago` varchar(25), `idUser` int(11), `NombreUsuario` varchar(91), `Created` datetime);


DROP VIEW IF EXISTS `vista_acuerdos_pago_proyeccion_historial`;
CREATE TABLE `vista_acuerdos_pago_proyeccion_historial` (`ID` bigint(20), `ConsecutivoAcuerdo` bigint(20), `idAcuerdoPago` varchar(45), `TipoCuota` int(11), `NombreTipoCuota` varchar(15), `NumeroCuota` int(11), `Fecha` date, `ValorCuota` double, `ValorPagado` double, `Saldo` double, `idPago` bigint(20), `EstadoProyeccion` int(11), `NombreEstadoProyeccion` varchar(20), `Tercero` bigint(20), `RazonSocial` varchar(100), `idClienteAcuerdo` bigint(11), `SobreNombreCliente` varchar(90), `CicloPagos` int(11), `NombreCicloPagos` varchar(45), `EstadoAcuerdo` int(11), `NombreEstadoAcuerdo` varchar(45));


DROP VIEW IF EXISTS `vista_acuerdo_pago`;
CREATE TABLE `vista_acuerdo_pago` (`ID` bigint(20), `idAcuerdoPago` varchar(45), `Fecha` date, `FechaInicialParaPagos` date, `Tercero` bigint(20), `RazonSocial` varchar(100), `Telefono` varchar(100), `Direccion` varchar(45), `ValorCuotaGeneral` double, `CicloPagos` int(11), `NombreCicloPagos` varchar(45), `SaldoAnterior` double(17,0), `Observaciones` text, `SaldoInicial` double(17,0), `TotalAbonos` double(17,0), `SaldoFinal` double(17,0), `Estado` int(11), `NombreEstado` varchar(45), `idUser` int(11), `NombreUsuario` varchar(91), `EstadoMora` bigint(11), `NombreEstadoMora` varchar(7), `Created` datetime);


DROP VIEW IF EXISTS `vista_acuerdo_pago_cuotas_pagadas`;
CREATE TABLE `vista_acuerdo_pago_cuotas_pagadas` (`ID` bigint(20), `ConsecutivoAcuerdo` bigint(20), `idAcuerdoPago` varchar(45), `TipoCuota` int(11), `NombreTipoCuota` varchar(15), `NumeroCuota` int(11), `Fecha` date, `idProyeccion` bigint(20), `ValorCuota` double, `ValorPago` double, `SaldoCuota` double, `NombreMetodoPago` varchar(25), `Tercero` bigint(20), `RazonSocial` varchar(100), `idClienteAcuerdo` bigint(11), `SobreNombreCliente` varchar(90), `CicloPagos` int(11), `NombreCicloPagos` varchar(45), `EstadoAcuerdo` int(11), `NombreEstadoAcuerdo` varchar(45), `Created` datetime);


DROP VIEW IF EXISTS `vista_acuerdo_pago_productos`;
CREATE TABLE `vista_acuerdo_pago_productos` (`ID` bigint(20) unsigned, `Fecha` date, `Clientes_idClientes` int(11), `Tercero` varchar(45), `RazonSocial` varchar(100), `Referencia` varchar(200), `Nombre` text, `Departamento` int(11), `ValorUnitarioItem` double(17,0), `Cantidad` double, `SubtotalItem` double(17,0), `IVAItem` double(17,0), `TotalItem` double(17,0), `PorcentajeIVA` varchar(10), `PrecioCostoUnitario` double, `SubtotalCosto` double(17,0), `GeneradoDesde` varchar(100), `idAcuerdoPago` varchar(45), `ConsecutivoAcuerdo` bigint(20), `EstadoAcuerdo` bigint(11));


DROP VIEW IF EXISTS `vista_anticipos_clientes`;
CREATE TABLE `vista_anticipos_clientes` (`Fecha` date, `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Razon_Social` varchar(100), `Detalle` varchar(45), `Concepto` varchar(500), `Tercero_Direccion` varchar(100), `Tercero_Cod_Mcipio` varchar(10), `TotalAnticipo` double, `CruceAnticipo` double);


DROP VIEW IF EXISTS `vista_auditoria_librodiario_documento_sin_balance`;
CREATE TABLE `vista_auditoria_librodiario_documento_sin_balance` (`Tipo_Documento_Intero` varchar(45), `Num_Documento_Interno` varchar(45), `Num_Documento_Externo` varchar(45), `idEmpresa` int(11), `TotalSaldo` double, `SaldoNeto` double);


DROP VIEW IF EXISTS `vista_auditoria_librodiario_sumas_saldos`;
CREATE TABLE `vista_auditoria_librodiario_sumas_saldos` (`Tipo_Documento_Intero` varchar(45), `Num_Documento_Interno` varchar(45), `Num_Documento_Externo` varchar(45), `idEmpresa` int(11), `TotalSaldo` double, `SaldoNeto` double);


DROP VIEW IF EXISTS `vista_balancextercero1`;
CREATE TABLE `vista_balancextercero1` (`Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `CuentaPUC` varchar(45), `Debitos` double, `Creditos` double, `Neto` double);


DROP VIEW IF EXISTS `vista_balancextercero2`;
CREATE TABLE `vista_balancextercero2` (`ID` varchar(8), `Fecha` date, `Identificacion` varchar(45), `Razon_Social` varchar(100), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `TipoDocumento` varchar(45), `NumDocumento` varchar(45), `DocumentoExterno` varchar(45), `SaldoInicialSubCuenta` double, `Clase` varchar(1), `NombreClase` varchar(45), `SaldoInicialClase` double, `DebitosClase` double, `CreditosClase` double, `Grupo` varchar(2), `NombreGrupo` varchar(45), `SaldoInicialGrupo` double, `DebitosGrupo` double, `CreditosGrupo` double, `CuentaPadre` varchar(4), `NombreCuentaPadre` varchar(45), `SaldoInicialCuentaPadre` double, `DebitosCuentaPadre` double, `CreditosCuentaPadre` double, `Debito` double, `Credito` double, `idEmpresa` int(11), `idCentroCosto` int(11));


DROP VIEW IF EXISTS `vista_balance_comprobacion_terceros`;
CREATE TABLE `vista_balance_comprobacion_terceros` (`CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Mcipio` varchar(10), `Debitos` double, `Creditos` double);


DROP VIEW IF EXISTS `vista_cierres_restaurante`;
CREATE TABLE `vista_cierres_restaurante` (`ID` bigint(20), `Fecha` date, `Hora` time, `idUsuario` bigint(20), `PedidosFacturados` double, `PedidosDescartados` double, `DomiciliosFacturados` double, `DomiciliosDescartados` double, `ParaLlevarFacturado` double, `ParaLlevarDescartado` double, `PropinasEfectivo` double, `PropinasTarjetas` double);


DROP VIEW IF EXISTS `vista_compras_productos`;
CREATE TABLE `vista_compras_productos` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `idProducto` bigint(20), `Referencia` varchar(200), `Producto` varchar(70), `PrecioVenta` double, `Cantidad` double, `CostoUnitario` double, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_compras_productos_devueltos`;
CREATE TABLE `vista_compras_productos_devueltos` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `idProducto` bigint(20), `Referencia` varchar(200), `Producto` varchar(70), `PrecioVenta` double, `Cantidad` double, `CostoUnitario` double, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_compras_servicios`;
CREATE TABLE `vista_compras_servicios` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `Cuenta` bigint(20), `NombreCuenta` varchar(100), `Concepto_Servicio` text, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` double, `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_comprobantes_ingreso`;
CREATE TABLE `vista_comprobantes_ingreso` (`ID` int(11), `Fecha` varchar(45), `Clientes_idClientes` int(11), `Tercero` int(11), `RazonSocial` varchar(100), `Valor` varchar(45), `Tipo` varchar(45), `Concepto` text, `Usuarios_idUsuarios` int(11), `Estado` varchar(45), `idCierre` bigint(20), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_cuentasxcobrar`;
CREATE TABLE `vista_cuentasxcobrar` (`CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `Debitos` double, `Creditos` double, `Total` double);


DROP VIEW IF EXISTS `vista_cuentasxcobrardetallado`;
CREATE TABLE `vista_cuentasxcobrardetallado` (`ID` bigint(20), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `Fecha` date, `NumeroDocumentoExterno` varchar(45), `Debitos` double, `Creditos` double, `Total` double);


DROP VIEW IF EXISTS `vista_cuentasxpagardetallado_v2`;
CREATE TABLE `vista_cuentasxpagardetallado_v2` (`ID` bigint(20), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `Fecha` date, `NumeroDocumentoExterno` varchar(45), `Debitos` double, `Creditos` double, `Total` double, `PlazoPago` date);


DROP VIEW IF EXISTS `vista_cuentasxpagar_v2`;
CREATE TABLE `vista_cuentasxpagar_v2` (`CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `Debitos` double, `Creditos` double, `Total` double);


DROP VIEW IF EXISTS `vista_cuentasxtercerosdocumentosexternos_v2`;
CREATE TABLE `vista_cuentasxtercerosdocumentosexternos_v2` (`CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `NumeroDocumentoExterno` varchar(45), `Debitos` double, `Creditos` double, `Total` double);


DROP VIEW IF EXISTS `vista_cuentasxtercerosdocumentos_v2`;
CREATE TABLE `vista_cuentasxtercerosdocumentos_v2` (`ID` bigint(20), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `Fecha` date, `NumeroDocumentoExterno` varchar(45), `Debitos` double, `Creditos` double, `Total` double);


DROP VIEW IF EXISTS `vista_cuentasxterceros_v2`;
CREATE TABLE `vista_cuentasxterceros_v2` (`CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `Debitos` double, `Creditos` double, `Total` double);


DROP VIEW IF EXISTS `vista_diferencia_inventarios`;
CREATE TABLE `vista_diferencia_inventarios` (`idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `ExistenciaActual` double, `ExistenciaAnterior` double, `Diferencia` double, `PrecioVenta` double, `CostoUnitario` double, `TotalCostosDiferencia` double, `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45));


DROP VIEW IF EXISTS `vista_diferencia_inventarios_selectivos`;
CREATE TABLE `vista_diferencia_inventarios_selectivos` (`idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `ExistenciaAnterior` double, `ExistenciaActual` double, `Diferencia` double, `PrecioVenta` double, `CostoUnitario` double, `TotalCostosDiferencia` double, `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45));


DROP VIEW IF EXISTS `vista_documentos_contables`;
CREATE TABLE `vista_documentos_contables` (`ID` bigint(20), `Fecha` date, `Prefijo` varchar(20), `Nombre` varchar(45), `Consecutivo` bigint(20), `Descripcion` text, `Estado` varchar(10), `idUser` int(11), `idDocumento` int(11), `idEmpresa` int(11), `idSucursal` int(11), `idCentroCostos` int(11));


DROP VIEW IF EXISTS `vista_documentos_equivalentes`;
CREATE TABLE `vista_documentos_equivalentes` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Estado` enum('AB','CE'), `Total` double);


DROP VIEW IF EXISTS `vista_estado_resultados_anio`;
CREATE TABLE `vista_estado_resultados_anio` (`idLibroDiario` bigint(20), `Fecha` date, `Tipo_Documento_Intero` varchar(45), `Num_Documento_Interno` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Dpto` varchar(10), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debito` double, `Credito` double, `Neto` double, `Mayor` varchar(45), `Esp` varchar(45), `idCentroCosto` int(11), `idEmpresa` int(11), `idSucursal` int(11), `Estado` varchar(20), `idUsuario` int(11), `idCierre` bigint(20), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_exogena`;
CREATE TABLE `vista_exogena` (`Tipo_Documento_Intero` varchar(45), `NumDocumento` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debitos` double(17,0), `Creditos` double(17,0));


DROP VIEW IF EXISTS `vista_exogena2`;
CREATE TABLE `vista_exogena2` (`Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(4), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debitos` double(17,0), `Creditos` double(17,0));


DROP VIEW IF EXISTS `vista_facturacion_detalles`;
CREATE TABLE `vista_facturacion_detalles` (`ID` bigint(20) unsigned, `FechaFactura` date, `NumeroFactura` bigint(16), `TipoFactura` varchar(20), `TablaItems` varchar(100), `Referencia` varchar(200), `Nombre` text, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `ValorUnitarioItem` double, `Cantidad` double, `SubtotalItem` double, `IVAItem` double, `TotalItem` double, `PorcentajeIVA` varchar(10), `PrecioCostoUnitario` double, `SubtotalCosto` double, `CuentaPUC` int(11), `idUsuarios` int(11), `idCierre` bigint(20), `Observaciones` mediumtext);


DROP VIEW IF EXISTS `vista_facturas_frecuentes`;
CREATE TABLE `vista_facturas_frecuentes` (`ID` bigint(20), `idCliente` bigint(20), `Periodo` int(11), `FacturaBase` varchar(45), `UltimaFactura` varchar(45), `Realizada` int(1), `RazonSocial` varchar(100), `Direccion` varchar(45), `UltimaFechaFacturacion` date, `ProximaFechaFacturacion` date, `FechaUltimaLectura` date, `UltimaLectura` bigint(20), `EstadoFacturadoUltimo` bigint(11), `FechaPenultimaLectura` date, `PenultimaLectura` bigint(20), `EstadoFacturadoPenultimo` bigint(11));


DROP VIEW IF EXISTS `vista_factura_compra_totales`;
CREATE TABLE `vista_factura_compra_totales` (`idFacturaCompra` bigint(20), `Sede` varchar(100), `Fecha` date, `NumeroFactura` varchar(100), `Tercero` bigint(20), `RazonSocial` varchar(300), `Subtotal` double, `Impuestos` double, `TotalRetenciones` double, `Total` double, `Concepto` text, `SubtotalServicios` double, `ImpuestosServicios` double, `TotalServicios` double, `SubtotalDevoluciones` double, `ImpuestosDevueltos` double, `TotalDevolucion` double, `Usuario` bigint(20));


DROP VIEW IF EXISTS `vista_inventario_separados`;
CREATE TABLE `vista_inventario_separados` (`ID` bigint(20) unsigned, `idSeparado` bigint(20), `Referencia` varchar(45), `Nombre` text, `ValorUnitarioItem` int(11), `Cantidad` int(11), `TotalItem` int(11), `PrecioCostoUnitario` int(11), `SubtotalCosto` int(11), `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11));


DROP VIEW IF EXISTS `vista_kardex`;
CREATE TABLE `vista_kardex` (`ID` bigint(20), `Fecha` date, `Movimiento` varchar(45), `Detalle` varchar(400), `idDocumento` varchar(100), `Cantidad` double, `ValorUnitario` double, `ValorTotal` double, `ProductosVenta_idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `Existencias` double, `CostoUnitario` double, `CostoTotal` double, `IVA` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_libro_diario`;
CREATE TABLE `vista_libro_diario` (`idLibroDiario` bigint(20), `Fecha` date, `Tipo_Documento_Intero` varchar(45), `NumDocumento` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Dpto` varchar(10), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debito` double, `Credito` double, `Neto` double, `idCentroCosto` int(11), `idEmpresa` int(11), `idSucursal` int(11), `Estado` varchar(20), `idUsuario` int(11));


DROP VIEW IF EXISTS `vista_listado_facturas_electronicas`;
CREATE TABLE `vista_listado_facturas_electronicas` (`ID` bigint(20), `idFactura` varchar(45), `RespuestaCompletaServidor` longtext, `UUID` text, `RutaPDF` text, `RutaXML` text, `Estado` int(11), `PDFCreado` int(11), `ZIPCreado` int(11), `EnviadoPorMail` int(11), `FechaReporte` datetime, `Created` datetime, `Updated` timestamp, `Sync` datetime, `FechaFactura` date, `PrefijoFactura` varchar(45), `NumeroFactura` bigint(16), `Total` double, `idCliente` bigint(11), `RazonSocialCliente` varchar(100), `NIT_Cliente` varchar(45), `NombreEstado` varchar(45));


DROP VIEW IF EXISTS `vista_movimientos_clase`;
CREATE TABLE `vista_movimientos_clase` (`Clase` varchar(1), `DebitosClase` double, `CreditosClase` double);


DROP VIEW IF EXISTS `vista_movimientos_cuenta_padre`;
CREATE TABLE `vista_movimientos_cuenta_padre` (`CuentaPadre` varchar(4), `DebitosCuentaPadre` double, `CreditosCuentaPadre` double);


DROP VIEW IF EXISTS `vista_movimientos_grupo`;
CREATE TABLE `vista_movimientos_grupo` (`Grupo` varchar(2), `DebitosGrupo` double, `CreditosGrupo` double);


DROP VIEW IF EXISTS `vista_nomina_servicios_turnos`;
CREATE TABLE `vista_nomina_servicios_turnos` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Sucursal` int(11), `Valor` double, `idUser` int(11), `Pagado` int(1), `Estado` varchar(10), `idDocumentoEquivalente` bigint(20), `Updated` timestamp, `Sync` datetime, `NombreSucursal` varchar(100), `NombreTercero` varchar(300));


DROP VIEW IF EXISTS `vista_notas_devolucion`;
CREATE TABLE `vista_notas_devolucion` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Concepto` text, `Subtotal` double, `IVA` double, `Total` double, `idCentroCostos` int(11), `idSucursal` int(11), `idUser` bigint(20), `Estado` varchar(10));


DROP VIEW IF EXISTS `vista_ori_facturas`;
CREATE TABLE `vista_ori_facturas` (`Fecha` date, `idFactura` varchar(45), `Referencia` varchar(200), `Nombre` varchar(500), `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `ValorUnitarioItem` int(11), `Cantidad` varchar(45), `Dias` varchar(45), `SubtotalItem` varchar(45), `IVAItem` varchar(45), `ValorOtrosImpuestos` double, `TotalItem` double, `PorcentajeIVA` varchar(10), `idOtrosImpuestos` int(11), `idPorcentajeIVA` int(11), `PrecioCostoUnitario` varchar(45), `SubtotalCosto` varchar(45), `TipoItem` varchar(10), `CuentaPUC` int(11), `GeneradoDesde` varchar(100), `NumeroIdentificador` varchar(45), `idUsuarios` int(11), `idCierre` bigint(20), `idResolucion` int(11), `TipoFactura` varchar(10), `Prefijo` varchar(45), `NumeroFactura` int(16), `Hora` varchar(20), `FormaPago` varchar(20), `CentroCosto` int(11), `idSucursal` int(11), `EmpresaPro_idEmpresaPro` int(11), `Clientes_idClientes` int(11), `ObservacionesFact` text);


DROP VIEW IF EXISTS `vista_pedidos_restaurante`;
CREATE TABLE `vista_pedidos_restaurante` (`ID` bigint(20), `Fecha` date, `Hora` time, `Estado` int(11), `idMesa` int(11), `idCliente` bigint(20), `NombreCliente` varchar(60), `DireccionEnvio` varchar(100), `TelefonoConfirmacion` varchar(100), `Observaciones` text, `idCierre` bigint(20), `Subtotal` double, `IVA` double, `Total` double, `TotalCostos` double, `idUsuario` bigint(20));


DROP VIEW IF EXISTS `vista_pedidos_restaurante_pos`;
CREATE TABLE `vista_pedidos_restaurante_pos` (`ID` bigint(20), `Fecha` date, `Hora` time, `idUsuario` bigint(20), `idMesa` int(11), `Estado` int(11), `Tipo` varchar(20), `idCliente` bigint(20), `NombreCliente` varchar(60), `DireccionEnvio` varchar(100), `TelefonoConfirmacion` varchar(100), `Observaciones` text, `idCierre` bigint(20), `FechaCreacion` datetime, `Updated` timestamp, `Sync` datetime, `Total` double, `NombreEstado` varchar(25), `NombreTipoPedido` varchar(45), `NombreUsuario` varchar(91));


DROP VIEW IF EXISTS `vista_preventa`;
CREATE TABLE `vista_preventa` (`VestasActivas_idVestasActivas` int(11), `TablaItems` varchar(14), `Referencia` varchar(200), `Nombre` varchar(70), `Departamento` varchar(45), `SubGrupo1` varchar(45), `SubGrupo2` varchar(45), `SubGrupo3` varchar(45), `SubGrupo4` varchar(45), `SubGrupo5` varchar(45), `ValorUnitarioItem` double, `Cantidad` double, `Dias` varchar(1), `SubtotalItem` double, `IVAItem` double, `ValorOtrosImpuestos` double, `TotalItem` double, `PorcentajeIVA` varchar(24), `PrecioCostoUnitario` double, `SubtotalCosto` double, `TipoItem` varchar(2), `CuentaPUC` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_productos_devueltos_acuerdos`;
CREATE TABLE `vista_productos_devueltos_acuerdos` (`ID` bigint(20), `Fecha` date, `idFacturasItems` bigint(20), `idAcuerdoPago` varchar(45), `Cantidad` double, `ValorDevolucion` double, `Observaciones` text, `idUser` int(11), `Created` datetime, `Updated` timestamp, `Sync` datetime, `Referencia` varchar(200), `Nombre` text, `ConsecutivoAcuerdo` bigint(20));


DROP VIEW IF EXISTS `vista_productos_facturas_acuerdo`;
CREATE TABLE `vista_productos_facturas_acuerdo` (`ID` bigint(20) unsigned, `idFactura` varchar(45), `Tercero` varchar(45), `Fecha` date, `Hora` varchar(20), `Prefijo` varchar(45), `NumeroFactura` int(16), `Referencia` varchar(200), `Nombre` text, `ValorUnitarioItem` double(17,0), `Cantidad` double, `SubtotalItem` double(17,0), `IVAItem` double(17,0), `TotalItem` double(17,0));


DROP VIEW IF EXISTS `vista_productos_x_cliente`;
CREATE TABLE `vista_productos_x_cliente` (`ID` bigint(20) unsigned, `Referencia` varchar(200), `Nombre` text, `FechaFactura` date, `Cantidad` double, `TotalItem` double, `idCliente` int(11), `RazonSocial` varchar(100), `Num_Identificacion` varchar(45));


DROP VIEW IF EXISTS `vista_proyeccion_acuerdos_pago`;
CREATE TABLE `vista_proyeccion_acuerdos_pago` (`idProyeccion` bigint(20), `ConsecutivoAcuerdo` bigint(20), `idAcuerdoPago` varchar(45), `TipoCuota` int(11), `NumeroCuota` int(11), `Fecha` date, `ValorCuota` double, `ValorPagado` double, `idPago` bigint(20), `EstadoProyeccion` int(11), `NombreEstadoProyeccion` varchar(20), `Tercero` bigint(20), `RazonSocial` varchar(100), `idClienteAcuerdo` bigint(11), `SobreNombreCliente` varchar(90), `ValorCuotaGeneral` double, `CicloPagos` int(11), `SaldoAnterior` double(17,0), `SaldoInicial` double(17,0), `TotalAbonos` double, `SaldoFinal` double(17,0));


DROP VIEW IF EXISTS `vista_resumen_facturacion`;
CREATE TABLE `vista_resumen_facturacion` (`ID` bigint(20) unsigned, `FechaInicial` date, `FechaFinal` date, `Referencia` varchar(200), `idProducto` bigint(20), `Nombre` text, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `Cantidad` double, `TotalVenta` double(19,2), `Costo` double(19,2));


DROP VIEW IF EXISTS `vista_resumen_restaurante_turno_actual`;
CREATE TABLE `vista_resumen_restaurante_turno_actual` (`idProductosVenta` bigint(20), `Nombre` varchar(70), `ItemsCompras` double, `ItemsVentas` double, `TrasladosRecibidos` decimal(32,0), `TrasladosEnviados` decimal(32,0), `TotalBajas` double, `TotalAltas` double, `CantidadRecibida` double, `SaldoFinal` double, `TotalVentas` double, `TotalComisiones1` double, `TotalComisiones2` double, `TotalComisiones3` double, `TotalComisiones4` double, `TotalCasa` double);


DROP VIEW IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE TABLE `vista_resumen_ventas_departamentos` (`FechaFactura` date, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `Total` double);


DROP VIEW IF EXISTS `vista_retenciones`;
CREATE TABLE `vista_retenciones` (`idCompra` bigint(20), `Fecha` date, `Tercero` bigint(20), `Estado` varchar(30), `RazonSocial` varchar(300), `DV` varchar(5), `Direccion` varchar(45), `Ciudad` varchar(100), `CuentaPUC` bigint(20), `Cuenta` varchar(200), `ValorRetencion` double, `PorcentajeRetenido` double, `BaseRetencion` double(19,2), `idEmpresa` bigint(11), `idCentroCostos` bigint(11), `idSucursal` bigint(11));


DROP VIEW IF EXISTS `vista_retenciones_tercero`;
CREATE TABLE `vista_retenciones_tercero` (`idCompra` bigint(20), `Fecha` date, `Tercero` bigint(20), `RazonSocial` varchar(300), `DV` varchar(5), `Direccion` varchar(45), `Ciudad` varchar(100), `CuentaPUC` bigint(20), `Cuenta` varchar(200), `ValorRetencion` double, `PorcentajeRetenido` double, `BaseRetencion` double(19,2));


DROP VIEW IF EXISTS `vista_saldos_iniciales_clase`;
CREATE TABLE `vista_saldos_iniciales_clase` (`Clase` varchar(1), `SaldoInicialClase` double);


DROP VIEW IF EXISTS `vista_saldos_iniciales_cuenta_padre`;
CREATE TABLE `vista_saldos_iniciales_cuenta_padre` (`CuentaPadre` varchar(4), `SaldoInicialCuentaPadre` double);


DROP VIEW IF EXISTS `vista_saldos_iniciales_grupo`;
CREATE TABLE `vista_saldos_iniciales_grupo` (`Grupo` varchar(2), `SaldoInicialGrupo` double);


DROP VIEW IF EXISTS `vista_saldo_inicial_clase_cuenta`;
CREATE TABLE `vista_saldo_inicial_clase_cuenta` (`ID` varchar(1), `SaldoInicial` double);


DROP VIEW IF EXISTS `vista_saldo_inicial_cuenta`;
CREATE TABLE `vista_saldo_inicial_cuenta` (`ID` varchar(4), `SaldoInicial` double);


DROP VIEW IF EXISTS `vista_saldo_inicial_cuentapuc`;
CREATE TABLE `vista_saldo_inicial_cuentapuc` (`ID` varchar(45), `Tercero_Identificacion` varchar(45), `SaldoInicial` double);


DROP VIEW IF EXISTS `vista_saldo_inicial_grupopuc`;
CREATE TABLE `vista_saldo_inicial_grupopuc` (`ID` varchar(2), `SaldoInicial` double);


DROP VIEW IF EXISTS `vista_separados_reportes`;
CREATE TABLE `vista_separados_reportes` (`ID` bigint(20), `Fecha` date, `Hora` time, `idCliente` int(11), `Total` int(11), `Saldo` int(11), `Estado` varchar(20), `Observaciones` text, `idUsuarios` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime, `RazonSocial` varchar(100), `Num_Identificacion` varchar(45), `Telefono` varchar(100), `Direccion` varchar(45), `FechaVencimiento` date);


DROP VIEW IF EXISTS `vista_sistemas`;
CREATE TABLE `vista_sistemas` (`ID` bigint(20), `idSistema` bigint(20), `Nombre_Sistema` mediumtext, `Observaciones` mediumtext, `TablaOrigen` varchar(90), `CodigoInterno` bigint(20), `Nombre` text, `Cantidad` double, `PrecioUnitario` double, `PrecioVenta` double(17,0), `CostoUnitario` double(17,0), `Costo_Total_Item` double(17,0), `IVA` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_tickets`;
CREATE TABLE `vista_tickets` (`ID` bigint(20), `idProyecto` int(11), `TipoTicket` int(11), `idModuloProyecto` int(11), `Prioridad` int(11), `FechaApertura` datetime, `Asunto` varchar(200), `Estado` int(11), `idUsuarioSolicitante` int(11), `idUsuarioAsignado` int(11), `FechaActualizacion` datetime, `idUsuarioActualiza` int(11), `FechaCierre` datetime, `idUsuarioCierra` int(11), `NombreSolicitante` varchar(45), `ApellidoSolicitante` varchar(45), `NombreAsignado` varchar(45), `ApellidoAsignado` varchar(45), `NombreEstado` varchar(45), `NombrePrioridad` varchar(15), `NombreProyecto` varchar(45), `NombreModulo` varchar(100), `NombreTipoTicket` varchar(20));


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

DROP TABLE IF EXISTS `vista_abonos_acuerdo_pago`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_abonos_acuerdo_pago` AS select `t1`.`ID` AS `ID`,`t2`.`Tercero` AS `Tercero`,(select `t4`.`RazonSocial` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t2`.`Tercero`)) AS `RazonSocialCliente`,`t1`.`NumeroCuota` AS `NumeroCuota`,`t1`.`TipoCuota` AS `TipoCuota`,(select `t3`.`NombreTipoCuota` from `acuerdo_pago_tipo_cuota` `t3` where (`t3`.`ID` = `t1`.`TipoCuota`) limit 1) AS `NombreTipoCuota`,`t1`.`idAcuerdoPago` AS `idAcuerdoPago`,`t2`.`ID` AS `ConsecutivoAcuerdo`,(select `t6`.`Fecha` from `acuerdo_pago_proyeccion_pagos` `t6` where (`t6`.`ID` = `t1`.`idProyeccion`) limit 1) AS `FechaCuota`,`t1`.`FechaPago` AS `Fecha`,`t1`.`ValorPago` AS `ValorPago`,`t1`.`MetodoPago` AS `MetodoPago`,(select `t5`.`Metodo` from `metodos_pago` `t5` where (`t5`.`ID` = `t1`.`MetodoPago`)) AS `NombreMetodoPago`,`t1`.`idUser` AS `idUser`,(select concat(`t4`.`Nombre`,' ',`t4`.`Apellido`) from `usuarios` `t4` where (`t4`.`idUsuarios` = `t1`.`idUser`)) AS `NombreUsuario`,`t1`.`Created` AS `Created` from (`acuerdo_pago_cuotas_pagadas` `t1` join `acuerdo_pago` `t2` on((`t1`.`idAcuerdoPago` = `t2`.`idAcuerdoPago`))) order by `t2`.`Tercero`,`t1`.`Created` desc;

DROP TABLE IF EXISTS `vista_acuerdos_pago_proyeccion_historial`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_acuerdos_pago_proyeccion_historial` AS select `t1`.`ID` AS `ID`,`t2`.`ID` AS `ConsecutivoAcuerdo`,`t1`.`idAcuerdoPago` AS `idAcuerdoPago`,`t1`.`TipoCuota` AS `TipoCuota`,(select `t6`.`NombreTipoCuota` from `acuerdo_pago_tipo_cuota` `t6` where (`t6`.`ID` = `t1`.`TipoCuota`) limit 1) AS `NombreTipoCuota`,`t1`.`NumeroCuota` AS `NumeroCuota`,`t1`.`Fecha` AS `Fecha`,`t1`.`ValorCuota` AS `ValorCuota`,`t1`.`ValorPagado` AS `ValorPagado`,((select `t1`.`ValorCuota`) - (select `t1`.`ValorPagado`)) AS `Saldo`,`t1`.`idPago` AS `idPago`,`t1`.`Estado` AS `EstadoProyeccion`,(select `t3`.`NombreEstado` from `acuerdo_pago_proyeccion_estados` `t3` where (`t3`.`ID` = `t1`.`Estado`) limit 1) AS `NombreEstadoProyeccion`,`t2`.`Tercero` AS `Tercero`,(select `t4`.`RazonSocial` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t2`.`Tercero`) limit 1) AS `RazonSocial`,(select `t4`.`idClientes` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t2`.`Tercero`) limit 1) AS `idClienteAcuerdo`,(select `t5`.`SobreNombre` from `clientes_datos_adicionales` `t5` where (`t5`.`idCliente` = (select `idClienteAcuerdo`)) limit 1) AS `SobreNombreCliente`,`t2`.`CicloPagos` AS `CicloPagos`,(select `t8`.`NombreCiclo` from `acuerdo_pago_ciclos_pagos` `t8` where (`t8`.`ID` = `t2`.`CicloPagos`) limit 1) AS `NombreCicloPagos`,`t2`.`Estado` AS `EstadoAcuerdo`,(select `t7`.`NombreEstado` from `acuerdo_pago_estados` `t7` where (`t7`.`ID` = `t2`.`Estado`)) AS `NombreEstadoAcuerdo` from (`acuerdo_pago_proyeccion_pagos` `t1` join `acuerdo_pago` `t2` on((`t1`.`idAcuerdoPago` = `t2`.`idAcuerdoPago`))) order by `t2`.`Tercero`,`t1`.`Fecha`;

DROP TABLE IF EXISTS `vista_acuerdo_pago`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_acuerdo_pago` AS select `t1`.`ID` AS `ID`,`t1`.`idAcuerdoPago` AS `idAcuerdoPago`,`t1`.`Fecha` AS `Fecha`,`t1`.`FechaInicialParaPagos` AS `FechaInicialParaPagos`,`t1`.`Tercero` AS `Tercero`,(select `t4`.`RazonSocial` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t1`.`Tercero`) limit 1) AS `RazonSocial`,(select `t4`.`Telefono` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t1`.`Tercero`) limit 1) AS `Telefono`,(select `t4`.`Direccion` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t1`.`Tercero`) limit 1) AS `Direccion`,`t1`.`ValorCuotaGeneral` AS `ValorCuotaGeneral`,`t1`.`CicloPagos` AS `CicloPagos`,(select `t2`.`NombreCiclo` from `acuerdo_pago_ciclos_pagos` `t2` where (`t2`.`ID` = `t1`.`CicloPagos`) limit 1) AS `NombreCicloPagos`,round(`t1`.`SaldoAnterior`,0) AS `SaldoAnterior`,`t1`.`Observaciones` AS `Observaciones`,round(`t1`.`SaldoInicial`,0) AS `SaldoInicial`,round(`t1`.`TotalAbonos`,0) AS `TotalAbonos`,round(`t1`.`SaldoFinal`,0) AS `SaldoFinal`,`t1`.`Estado` AS `Estado`,(select `t3`.`NombreEstado` from `acuerdo_pago_estados` `t3` where (`t3`.`ID` = `t1`.`Estado`)) AS `NombreEstado`,`t1`.`idUser` AS `idUser`,(select concat(`t4`.`Nombre`,' ',`t4`.`Apellido`) from `usuarios` `t4` where (`t4`.`idUsuarios` = `t1`.`idUser`)) AS `NombreUsuario`,(select max(`t5`.`Estado`) from `acuerdo_pago_proyeccion_pagos` `t5` where (`t5`.`idAcuerdoPago` = `t1`.`idAcuerdoPago`)) AS `EstadoMora`,if(((select `EstadoMora`) = 4),'EN MORA','AL DIA') AS `NombreEstadoMora`,`t1`.`Created` AS `Created` from `acuerdo_pago` `t1` order by `t1`.`Created` desc;

DROP TABLE IF EXISTS `vista_acuerdo_pago_cuotas_pagadas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_acuerdo_pago_cuotas_pagadas` AS select `t1`.`ID` AS `ID`,`t2`.`ID` AS `ConsecutivoAcuerdo`,`t1`.`idAcuerdoPago` AS `idAcuerdoPago`,`t1`.`TipoCuota` AS `TipoCuota`,(select `t6`.`NombreTipoCuota` from `acuerdo_pago_tipo_cuota` `t6` where (`t6`.`ID` = `t1`.`TipoCuota`) limit 1) AS `NombreTipoCuota`,`t1`.`NumeroCuota` AS `NumeroCuota`,`t1`.`FechaPago` AS `Fecha`,`t1`.`idProyeccion` AS `idProyeccion`,(select ifnull((select `t10`.`ValorCuota` from `acuerdo_pago_proyeccion_pagos` `t10` where (`t10`.`ID` = `t1`.`idProyeccion`)),0)) AS `ValorCuota`,`t1`.`ValorPago` AS `ValorPago`,((select `ValorCuota`) - `t1`.`ValorPago`) AS `SaldoCuota`,(select `t9`.`Metodo` from `metodos_pago` `t9` where (`t9`.`ID` = `t1`.`MetodoPago`)) AS `NombreMetodoPago`,`t2`.`Tercero` AS `Tercero`,(select `t4`.`RazonSocial` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t2`.`Tercero`) limit 1) AS `RazonSocial`,(select `t4`.`idClientes` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t2`.`Tercero`) limit 1) AS `idClienteAcuerdo`,(select `t5`.`SobreNombre` from `clientes_datos_adicionales` `t5` where (`t5`.`idCliente` = (select `idClienteAcuerdo`)) limit 1) AS `SobreNombreCliente`,`t2`.`CicloPagos` AS `CicloPagos`,(select `t8`.`NombreCiclo` from `acuerdo_pago_ciclos_pagos` `t8` where (`t8`.`ID` = `t2`.`CicloPagos`) limit 1) AS `NombreCicloPagos`,`t2`.`Estado` AS `EstadoAcuerdo`,(select `t7`.`NombreEstado` from `acuerdo_pago_estados` `t7` where (`t7`.`ID` = `t2`.`Estado`)) AS `NombreEstadoAcuerdo`,`t1`.`Created` AS `Created` from (`acuerdo_pago_cuotas_pagadas` `t1` join `acuerdo_pago` `t2` on((`t1`.`idAcuerdoPago` = `t2`.`idAcuerdoPago`))) order by `t2`.`Tercero`,`t1`.`Created` desc;

DROP TABLE IF EXISTS `vista_acuerdo_pago_productos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_acuerdo_pago_productos` AS select `t1`.`ID` AS `ID`,`t2`.`Fecha` AS `Fecha`,`t2`.`Clientes_idClientes` AS `Clientes_idClientes`,(select `t3`.`Num_Identificacion` from `clientes` `t3` where (`t3`.`idClientes` = `t2`.`Clientes_idClientes`) limit 1) AS `Tercero`,(select `t3`.`RazonSocial` from `clientes` `t3` where (`t3`.`idClientes` = `t2`.`Clientes_idClientes`) limit 1) AS `RazonSocial`,`t1`.`Referencia` AS `Referencia`,`t1`.`Nombre` AS `Nombre`,`t1`.`Departamento` AS `Departamento`,round(`t1`.`ValorUnitarioItem`,0) AS `ValorUnitarioItem`,`t1`.`Cantidad` AS `Cantidad`,round(`t1`.`SubtotalItem`,0) AS `SubtotalItem`,round(`t1`.`IVAItem`,0) AS `IVAItem`,round(`t1`.`TotalItem`,0) AS `TotalItem`,`t1`.`PorcentajeIVA` AS `PorcentajeIVA`,`t1`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,round(`t1`.`SubtotalCosto`,0) AS `SubtotalCosto`,`t1`.`GeneradoDesde` AS `GeneradoDesde`,`t1`.`NumeroIdentificador` AS `idAcuerdoPago`,(select `t4`.`ID` from `acuerdo_pago` `t4` where (`t4`.`idAcuerdoPago` = `t1`.`NumeroIdentificador`) limit 1) AS `ConsecutivoAcuerdo`,(select `t4`.`Estado` from `acuerdo_pago` `t4` where (`t4`.`idAcuerdoPago` = `t1`.`NumeroIdentificador`) limit 1) AS `EstadoAcuerdo` from (`facturas_items` `t1` join `facturas` `t2` on((`t1`.`idFactura` = `t2`.`idFacturas`))) where (`t1`.`GeneradoDesde` = 'Acuerdo') order by `t2`.`Fecha`,`t1`.`ID` desc;

DROP TABLE IF EXISTS `vista_anticipos_clientes`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_anticipos_clientes` AS select `librodiario`.`Fecha` AS `Fecha`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Detalle` AS `Detalle`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Credito` AS `TotalAnticipo`,`librodiario`.`Debito` AS `CruceAnticipo` from `librodiario` where (`librodiario`.`CuentaPUC` = (select `parametros_contables`.`CuentaPUC` from `parametros_contables` where (`parametros_contables`.`ID` = 20))) order by `librodiario`.`idLibroDiario` desc;

DROP TABLE IF EXISTS `vista_auditoria_librodiario_documento_sin_balance`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_auditoria_librodiario_documento_sin_balance` AS select `vista_auditoria_librodiario_sumas_saldos`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,`vista_auditoria_librodiario_sumas_saldos`.`Num_Documento_Interno` AS `Num_Documento_Interno`,`vista_auditoria_librodiario_sumas_saldos`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`vista_auditoria_librodiario_sumas_saldos`.`idEmpresa` AS `idEmpresa`,`vista_auditoria_librodiario_sumas_saldos`.`TotalSaldo` AS `TotalSaldo`,`vista_auditoria_librodiario_sumas_saldos`.`SaldoNeto` AS `SaldoNeto` from `vista_auditoria_librodiario_sumas_saldos` where (((`vista_auditoria_librodiario_sumas_saldos`.`TotalSaldo` > 1) and (`vista_auditoria_librodiario_sumas_saldos`.`TotalSaldo` < 1)) or ((`vista_auditoria_librodiario_sumas_saldos`.`SaldoNeto` > 1) and (`vista_auditoria_librodiario_sumas_saldos`.`SaldoNeto` < 1)) or (`vista_auditoria_librodiario_sumas_saldos`.`TotalSaldo` <> `vista_auditoria_librodiario_sumas_saldos`.`SaldoNeto`));

DROP TABLE IF EXISTS `vista_auditoria_librodiario_sumas_saldos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_auditoria_librodiario_sumas_saldos` AS select `librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,`librodiario`.`Num_Documento_Interno` AS `Num_Documento_Interno`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`idEmpresa` AS `idEmpresa`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `TotalSaldo`,sum(`librodiario`.`Neto`) AS `SaldoNeto` from `librodiario` group by `librodiario`.`Tipo_Documento_Intero`,`librodiario`.`Num_Documento_Interno`;

DROP TABLE IF EXISTS `vista_balancextercero1`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_balancextercero1` AS select `librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos`,(sum(`librodiario`.`Debito`) - sum(`librodiario`.`Credito`)) AS `Neto` from `librodiario` group by `librodiario`.`Tercero_Identificacion` order by substr(`librodiario`.`CuentaPUC`,1,8);

DROP TABLE IF EXISTS `vista_balancextercero2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_balancextercero2` AS select substr(`librodiario`.`CuentaPUC`,1,8) AS `ID`,`librodiario`.`Fecha` AS `Fecha`,`librodiario`.`Tercero_Identificacion` AS `Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Razon_Social`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Tipo_Documento_Intero` AS `TipoDocumento`,`librodiario`.`Num_Documento_Interno` AS `NumDocumento`,`librodiario`.`Num_Documento_Externo` AS `DocumentoExterno`,(select `vista_saldo_inicial_cuentapuc`.`SaldoInicial` from `vista_saldo_inicial_cuentapuc` where ((`librodiario`.`CuentaPUC` = `vista_saldo_inicial_cuentapuc`.`ID`) and (`librodiario`.`Tercero_Identificacion` = `vista_saldo_inicial_cuentapuc`.`Tercero_Identificacion`)) limit 1) AS `SaldoInicialSubCuenta`,substr(`librodiario`.`CuentaPUC`,1,1) AS `Clase`,(select `clasecuenta`.`Clase` from `clasecuenta` where (`clasecuenta`.`PUC` = substr(`librodiario`.`CuentaPUC`,1,1))) AS `NombreClase`,(select `vista_saldos_iniciales_clase`.`SaldoInicialClase` from `vista_saldos_iniciales_clase` where (`vista_saldos_iniciales_clase`.`Clase` = substr(`librodiario`.`CuentaPUC`,1,1)) limit 1) AS `SaldoInicialClase`,(select `vista_movimientos_clase`.`DebitosClase` from `vista_movimientos_clase` where (`vista_movimientos_clase`.`Clase` = substr(`librodiario`.`CuentaPUC`,1,1)) limit 1) AS `DebitosClase`,(select `vista_movimientos_clase`.`CreditosClase` from `vista_movimientos_clase` where (`vista_movimientos_clase`.`Clase` = substr(`librodiario`.`CuentaPUC`,1,1)) limit 1) AS `CreditosClase`,substr(`librodiario`.`CuentaPUC`,1,2) AS `Grupo`,(select `gupocuentas`.`Nombre` from `gupocuentas` where (`gupocuentas`.`PUC` = substr(`librodiario`.`CuentaPUC`,1,2))) AS `NombreGrupo`,(select `vista_saldos_iniciales_grupo`.`SaldoInicialGrupo` from `vista_saldos_iniciales_grupo` where (`vista_saldos_iniciales_grupo`.`Grupo` = substr(`librodiario`.`CuentaPUC`,1,2)) limit 1) AS `SaldoInicialGrupo`,(select `vista_movimientos_grupo`.`DebitosGrupo` from `vista_movimientos_grupo` where (`vista_movimientos_grupo`.`Grupo` = substr(`librodiario`.`CuentaPUC`,1,2)) limit 1) AS `DebitosGrupo`,(select `vista_movimientos_grupo`.`CreditosGrupo` from `vista_movimientos_grupo` where (`vista_movimientos_grupo`.`Grupo` = substr(`librodiario`.`CuentaPUC`,1,2)) limit 1) AS `CreditosGrupo`,substr(`librodiario`.`CuentaPUC`,1,4) AS `CuentaPadre`,(select `cuentas`.`Nombre` from `cuentas` where (`cuentas`.`idPUC` = substr(`librodiario`.`CuentaPUC`,1,4))) AS `NombreCuentaPadre`,(select `vista_saldos_iniciales_cuenta_padre`.`SaldoInicialCuentaPadre` from `vista_saldos_iniciales_cuenta_padre` where (`vista_saldos_iniciales_cuenta_padre`.`CuentaPadre` = substr(`librodiario`.`CuentaPUC`,1,4)) limit 1) AS `SaldoInicialCuentaPadre`,(select `vista_movimientos_cuenta_padre`.`DebitosCuentaPadre` from `vista_movimientos_cuenta_padre` where (`vista_movimientos_cuenta_padre`.`CuentaPadre` = substr(`librodiario`.`CuentaPUC`,1,4)) limit 1) AS `DebitosCuentaPadre`,(select `vista_movimientos_cuenta_padre`.`CreditosCuentaPadre` from `vista_movimientos_cuenta_padre` where (`vista_movimientos_cuenta_padre`.`CuentaPadre` = substr(`librodiario`.`CuentaPUC`,1,4)) limit 1) AS `CreditosCuentaPadre`,`librodiario`.`Debito` AS `Debito`,`librodiario`.`Credito` AS `Credito`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idCentroCosto` AS `idCentroCosto` from `librodiario` where ((`librodiario`.`Fecha` >= '2019-08-01') and (`librodiario`.`Fecha` <= '2020-04-24')) order by substr(`librodiario`.`CuentaPUC`,1,8),`librodiario`.`Tercero_Identificacion`,`librodiario`.`CuentaPUC`,`librodiario`.`Fecha`;

DROP TABLE IF EXISTS `vista_balance_comprobacion_terceros`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_balance_comprobacion_terceros` AS select `librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos` from `librodiario` where ((`librodiario`.`Fecha` >= '2020-09-03') and (`librodiario`.`Fecha` <= '2020-09-03') and (`librodiario`.`idEmpresa` = '2')) group by `librodiario`.`CuentaPUC`,`librodiario`.`Tercero_Identificacion`;

DROP TABLE IF EXISTS `vista_cierres_restaurante`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cierres_restaurante` AS select `restaurante_cierres`.`ID` AS `ID`,`restaurante_cierres`.`Fecha` AS `Fecha`,`restaurante_cierres`.`Hora` AS `Hora`,`restaurante_cierres`.`idUsuario` AS `idUsuario`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FAPE'))) AS `PedidosFacturados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DEPE'))) AS `PedidosDescartados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FADO'))) AS `DomiciliosFacturados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DEDO'))) AS `DomiciliosDescartados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FALL'))) AS `ParaLlevarFacturado`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DELL'))) AS `ParaLlevarDescartado`,(select sum(`restaurante_registro_propinas`.`Efectivo`) AS `Total` from `restaurante_registro_propinas` where (`restaurante_registro_propinas`.`idCierre` = `restaurante_cierres`.`ID`)) AS `PropinasEfectivo`,(select sum(`restaurante_registro_propinas`.`Tarjetas`) AS `Total` from `restaurante_registro_propinas` where (`restaurante_registro_propinas`.`idCierre` = `restaurante_cierres`.`ID`)) AS `PropinasTarjetas` from `restaurante_cierres`;

DROP TABLE IF EXISTS `vista_compras_productos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_productos` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fi`.`idProducto` AS `idProducto`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Producto`,`pv`.`PrecioVenta` AS `PrecioVenta`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`CostoUnitarioCompra` AS `CostoUnitario`,`fi`.`SubtotalCompra` AS `Subtotal`,`fi`.`ImpuestoCompra` AS `Impuestos`,`fi`.`TotalCompra` AS `Total`,`fi`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from (((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_items` `fi` on((`fi`.`idFacturaCompra` = `c`.`ID`))) join `productosventa` `pv` on((`fi`.`idProducto` = `pv`.`idProductosVenta`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_compras_productos_devueltos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_productos_devueltos` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fi`.`idProducto` AS `idProducto`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Producto`,`pv`.`PrecioVenta` AS `PrecioVenta`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`CostoUnitarioCompra` AS `CostoUnitario`,`fi`.`SubtotalCompra` AS `Subtotal`,`fi`.`ImpuestoCompra` AS `Impuestos`,`fi`.`TotalCompra` AS `Total`,`fi`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from (((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_items_devoluciones` `fi` on((`fi`.`idFacturaCompra` = `c`.`ID`))) join `productosventa` `pv` on((`fi`.`idProducto` = `pv`.`idProductosVenta`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_compras_servicios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_servicios` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fs`.`CuentaPUC_Servicio` AS `Cuenta`,`fs`.`Nombre_Cuenta` AS `NombreCuenta`,`fs`.`Concepto_Servicio` AS `Concepto_Servicio`,`fs`.`Subtotal_Servicio` AS `Subtotal`,`fs`.`Impuesto_Servicio` AS `Impuestos`,`fs`.`Total_Servicio` AS `Total`,`fs`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from ((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_servicios` `fs` on((`fs`.`idFacturaCompra` = `c`.`ID`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_comprobantes_ingreso`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_comprobantes_ingreso` AS select `t1`.`ID` AS `ID`,`t1`.`Fecha` AS `Fecha`,`t1`.`Clientes_idClientes` AS `Clientes_idClientes`,`t1`.`Tercero` AS `Tercero`,(select if((`t1`.`Clientes_idClientes` = '0'),(select `t2`.`RazonSocial` from `clientes` `t2` where (`t1`.`Tercero` = `t2`.`Num_Identificacion`) limit 1),(select `t2`.`RazonSocial` from `clientes` `t2` where (`t1`.`Clientes_idClientes` = `t2`.`idClientes`) limit 1))) AS `RazonSocial`,`t1`.`Valor` AS `Valor`,`t1`.`Tipo` AS `Tipo`,`t1`.`Concepto` AS `Concepto`,`t1`.`Usuarios_idUsuarios` AS `Usuarios_idUsuarios`,`t1`.`Estado` AS `Estado`,`t1`.`idCierre` AS `idCierre`,`t1`.`Updated` AS `Updated`,`t1`.`Sync` AS `Sync` from `comprobantes_ingreso` `t1`;

DROP TABLE IF EXISTS `vista_cuentasxcobrar`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cuentasxcobrar` AS select `t1`.`CuentaPUC` AS `CuentaPUC`,`t1`.`NombreCuenta` AS `NombreCuenta`,`t1`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`t1`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`t1`.`Debitos` AS `Debitos`,`t1`.`Creditos` AS `Creditos`,`t1`.`Total` AS `Total` from `vista_cuentasxterceros_v2` `t1` where ((`t1`.`Total` <> 0) and exists(select 1 from `contabilidad_parametros_cuentasxcobrar` `t2` where (`t1`.`CuentaPUC` like `t2`.`CuentaPUC`))) order by `t1`.`Total` desc;

DROP TABLE IF EXISTS `vista_cuentasxcobrardetallado`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cuentasxcobrardetallado` AS select `t1`.`ID` AS `ID`,`t1`.`CuentaPUC` AS `CuentaPUC`,`t1`.`NombreCuenta` AS `NombreCuenta`,`t1`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`t1`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`t1`.`Fecha` AS `Fecha`,`t1`.`NumeroDocumentoExterno` AS `NumeroDocumentoExterno`,`t1`.`Debitos` AS `Debitos`,`t1`.`Creditos` AS `Creditos`,`t1`.`Total` AS `Total` from `vista_cuentasxtercerosdocumentos_v2` `t1` where ((`t1`.`Total` <> 0) and exists(select 1 from `contabilidad_parametros_cuentasxcobrar` `t2` where (`t1`.`CuentaPUC` like `t2`.`CuentaPUC`))) order by `t1`.`Fecha`;

DROP TABLE IF EXISTS `vista_cuentasxpagardetallado_v2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cuentasxpagardetallado_v2` AS select `t1`.`ID` AS `ID`,`t1`.`CuentaPUC` AS `CuentaPUC`,`t1`.`NombreCuenta` AS `NombreCuenta`,`t1`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`t1`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`t1`.`Fecha` AS `Fecha`,`t1`.`NumeroDocumentoExterno` AS `NumeroDocumentoExterno`,`t1`.`Debitos` AS `Debitos`,`t1`.`Creditos` AS `Creditos`,`t1`.`Total` AS `Total`,(`t1`.`Fecha` + interval (select `t2`.`Plazo` from `proveedores` `t2` where (`t2`.`Num_Identificacion` = `t1`.`Tercero_Identificacion`) limit 1) day) AS `PlazoPago` from `vista_cuentasxtercerosdocumentos_v2` `t1` where (((`t1`.`Total` < -(1)) or (`t1`.`Total` > 1)) and exists(select 1 from `contabilidad_parametros_cuentasxpagar` `t2` where (`t1`.`CuentaPUC` like `t2`.`CuentaPUC`))) order by (`t1`.`Fecha` + interval (select `t2`.`Plazo` from `proveedores` `t2` where (`t2`.`Num_Identificacion` = `t1`.`Tercero_Identificacion`) limit 1) day);

DROP TABLE IF EXISTS `vista_cuentasxpagar_v2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cuentasxpagar_v2` AS select `t1`.`CuentaPUC` AS `CuentaPUC`,`t1`.`NombreCuenta` AS `NombreCuenta`,`t1`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`t1`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`t1`.`Debitos` AS `Debitos`,`t1`.`Creditos` AS `Creditos`,`t1`.`Total` AS `Total` from `vista_cuentasxterceros_v2` `t1` where ((`t1`.`Total` <> 0) and exists(select 1 from `contabilidad_parametros_cuentasxpagar` `t2` where (`t1`.`CuentaPUC` like `t2`.`CuentaPUC`))) order by `t1`.`Total`;

DROP TABLE IF EXISTS `vista_cuentasxtercerosdocumentosexternos_v2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cuentasxtercerosdocumentosexternos_v2` AS select `librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Num_Documento_Externo` AS `NumeroDocumentoExterno`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `Total` from `librodiario` group by `librodiario`.`Tercero_Identificacion`,`librodiario`.`CuentaPUC`,`librodiario`.`Num_Documento_Externo`;

DROP TABLE IF EXISTS `vista_cuentasxtercerosdocumentos_v2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cuentasxtercerosdocumentos_v2` AS select `librodiario`.`idLibroDiario` AS `ID`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Fecha` AS `Fecha`,`librodiario`.`Num_Documento_Externo` AS `NumeroDocumentoExterno`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `Total` from `librodiario` group by `librodiario`.`Tercero_Identificacion`,`librodiario`.`CuentaPUC`,`librodiario`.`Num_Documento_Externo`;

DROP TABLE IF EXISTS `vista_cuentasxterceros_v2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cuentasxterceros_v2` AS select `librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `Total` from `librodiario` group by `librodiario`.`Tercero_Identificacion`,`librodiario`.`CuentaPUC`;

DROP TABLE IF EXISTS `vista_diferencia_inventarios`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_diferencia_inventarios` AS select `productosventa`.`idProductosVenta` AS `idProductosVenta`,`productosventa`.`Referencia` AS `Referencia`,`productosventa`.`Nombre` AS `Nombre`,`productosventa`.`Existencias` AS `ExistenciaActual`,(select ifnull((select `inventarios_temporal`.`Existencias` from `inventarios_temporal` where (`productosventa`.`Referencia` = `inventarios_temporal`.`Referencia`)),0)) AS `ExistenciaAnterior`,((select `ExistenciaActual`) - (select `ExistenciaAnterior`)) AS `Diferencia`,`productosventa`.`PrecioVenta` AS `PrecioVenta`,`productosventa`.`CostoUnitario` AS `CostoUnitario`,((select `Diferencia`) * `productosventa`.`CostoUnitario`) AS `TotalCostosDiferencia`,`productosventa`.`Departamento` AS `Departamento`,`productosventa`.`Sub1` AS `Sub1`,`productosventa`.`Sub2` AS `Sub2`,`productosventa`.`Sub3` AS `Sub3`,`productosventa`.`Sub4` AS `Sub4`,`productosventa`.`Sub5` AS `Sub5` from `productosventa` where (((select ifnull((select `inventarios_temporal`.`Existencias` from `inventarios_temporal` where (`productosventa`.`Referencia` = `inventarios_temporal`.`Referencia`)),0)) - `productosventa`.`Existencias`) <> 0);

DROP TABLE IF EXISTS `vista_diferencia_inventarios_selectivos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_diferencia_inventarios_selectivos` AS select `productosventa`.`idProductosVenta` AS `idProductosVenta`,`productosventa`.`Referencia` AS `Referencia`,`productosventa`.`Nombre` AS `Nombre`,`productosventa`.`Existencias` AS `ExistenciaAnterior`,(select ifnull((select `inventarios_conteo_selectivo`.`Cantidad` from `inventarios_conteo_selectivo` where (`productosventa`.`idProductosVenta` = `inventarios_conteo_selectivo`.`Referencia`)),0)) AS `ExistenciaActual`,((select `ExistenciaActual`) - `productosventa`.`Existencias`) AS `Diferencia`,`productosventa`.`PrecioVenta` AS `PrecioVenta`,`productosventa`.`CostoUnitario` AS `CostoUnitario`,((select `Diferencia`) * `productosventa`.`CostoUnitario`) AS `TotalCostosDiferencia`,`productosventa`.`Departamento` AS `Departamento`,`productosventa`.`Sub1` AS `Sub1`,`productosventa`.`Sub2` AS `Sub2`,`productosventa`.`Sub3` AS `Sub3`,`productosventa`.`Sub4` AS `Sub4`,`productosventa`.`Sub5` AS `Sub5` from `productosventa` where ((select ifnull((select `inventarios_conteo_selectivo`.`Cantidad` from `inventarios_conteo_selectivo` where (`productosventa`.`idProductosVenta` = `inventarios_conteo_selectivo`.`Referencia`)),0)) > 0);

DROP TABLE IF EXISTS `vista_documentos_contables`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_documentos_contables` AS select `dcc`.`ID` AS `ID`,`dcc`.`Fecha` AS `Fecha`,`dc`.`Prefijo` AS `Prefijo`,`dc`.`Nombre` AS `Nombre`,`dcc`.`Consecutivo` AS `Consecutivo`,`dcc`.`Descripcion` AS `Descripcion`,`dcc`.`Estado` AS `Estado`,`dcc`.`idUser` AS `idUser`,`dcc`.`idDocumento` AS `idDocumento`,`dcc`.`idEmpresa` AS `idEmpresa`,`dcc`.`idSucursal` AS `idSucursal`,`dcc`.`idCentroCostos` AS `idCentroCostos` from (`documentos_contables_control` `dcc` join `documentos_contables` `dc` on((`dc`.`ID` = `dcc`.`idDocumento`)));

DROP TABLE IF EXISTS `vista_documentos_equivalentes`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_documentos_equivalentes` AS select `de`.`ID` AS `ID`,`de`.`Fecha` AS `Fecha`,`de`.`Tercero` AS `Tercero`,`de`.`Estado` AS `Estado`,(select sum(`dei`.`Total`) from `documento_equivalente_items` `dei` where (`dei`.`idDocumento` = `de`.`ID`)) AS `Total` from `documento_equivalente` `de`;

DROP TABLE IF EXISTS `vista_estado_resultados_anio`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_estado_resultados_anio` AS select `librodiario`.`idLibroDiario` AS `idLibroDiario`,`librodiario`.`Fecha` AS `Fecha`,`librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,`librodiario`.`Num_Documento_Interno` AS `Num_Documento_Interno`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Dpto` AS `Tercero_Cod_Dpto`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,`librodiario`.`Debito` AS `Debito`,`librodiario`.`Credito` AS `Credito`,`librodiario`.`Neto` AS `Neto`,`librodiario`.`Mayor` AS `Mayor`,`librodiario`.`Esp` AS `Esp`,`librodiario`.`idCentroCosto` AS `idCentroCosto`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idSucursal` AS `idSucursal`,`librodiario`.`Estado` AS `Estado`,`librodiario`.`idUsuario` AS `idUsuario`,`librodiario`.`idCierre` AS `idCierre`,`librodiario`.`Updated` AS `Updated`,`librodiario`.`Sync` AS `Sync` from `librodiario` where ((`librodiario`.`Fecha` >= '2020-01-01') and (`librodiario`.`Fecha` <= '2020-12-31'));

DROP TABLE IF EXISTS `vista_exogena`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_exogena` AS select `librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)),`librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,round(sum(`librodiario`.`Debito`),0) AS `Debitos`,round(sum(`librodiario`.`Credito`),0) AS `Creditos` from `librodiario` where ((`librodiario`.`Fecha` >= '2017-01-01') and (`librodiario`.`Fecha` <= '2017-12-31')) group by `librodiario`.`CuentaPUC`,`librodiario`.`Tercero_Identificacion`;

DROP TABLE IF EXISTS `vista_exogena2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_exogena2` AS select `librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,substr(`librodiario`.`CuentaPUC`,1,4) AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,round(sum(`librodiario`.`Debito`),0) AS `Debitos`,round(sum(`librodiario`.`Credito`),0) AS `Creditos` from `librodiario` where ((`librodiario`.`Fecha` >= '2017-01-01') and (`librodiario`.`Fecha` <= '2017-12-31')) group by substr(`librodiario`.`CuentaPUC`,1,4),`librodiario`.`Tercero_Identificacion`;

DROP TABLE IF EXISTS `vista_facturacion_detalles`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_facturacion_detalles` AS select `facturas_items`.`ID` AS `ID`,`facturas_items`.`FechaFactura` AS `FechaFactura`,(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `NumeroFactura`,(select `facturas`.`FormaPago` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `TipoFactura`,`facturas_items`.`TablaItems` AS `TablaItems`,`facturas_items`.`Referencia` AS `Referencia`,`facturas_items`.`Nombre` AS `Nombre`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,`facturas_items`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`facturas_items`.`Cantidad` AS `Cantidad`,`facturas_items`.`SubtotalItem` AS `SubtotalItem`,`facturas_items`.`IVAItem` AS `IVAItem`,`facturas_items`.`TotalItem` AS `TotalItem`,`facturas_items`.`PorcentajeIVA` AS `PorcentajeIVA`,`facturas_items`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`facturas_items`.`SubtotalCosto` AS `SubtotalCosto`,`facturas_items`.`CuentaPUC` AS `CuentaPUC`,`facturas_items`.`idUsuarios` AS `idUsuarios`,`facturas_items`.`idCierre` AS `idCierre`,(select `facturas`.`ObservacionesFact` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `Observaciones` from `facturas_items`;

DROP TABLE IF EXISTS `vista_facturas_frecuentes`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_facturas_frecuentes` AS select `facturas_frecuentes`.`ID` AS `ID`,`facturas_frecuentes`.`idCliente` AS `idCliente`,`facturas_frecuentes`.`Periodo` AS `Periodo`,`facturas_frecuentes`.`FacturaBase` AS `FacturaBase`,`facturas_frecuentes`.`UltimaFactura` AS `UltimaFactura`,`facturas_frecuentes`.`Realizada` AS `Realizada`,(select `clientes`.`RazonSocial` from `clientes` where (`clientes`.`idClientes` = `facturas_frecuentes`.`idCliente`)) AS `RazonSocial`,(select `clientes`.`Direccion` from `clientes` where (`clientes`.`idClientes` = `facturas_frecuentes`.`idCliente`)) AS `Direccion`,(select `facturas`.`Fecha` from `facturas` where (`facturas`.`idFacturas` = `facturas_frecuentes`.`UltimaFactura`)) AS `UltimaFechaFacturacion`,(select ((select `UltimaFechaFacturacion`) + interval (select `facturas_frecuentes`.`Periodo`) month)) AS `ProximaFechaFacturacion`,(select `acueducto_lecturas`.`Fecha` from `acueducto_lecturas` where (`acueducto_lecturas`.`idCliente` = `facturas_frecuentes`.`idCliente`) order by `acueducto_lecturas`.`ID` desc limit 1) AS `FechaUltimaLectura`,(select `acueducto_lecturas`.`LecturaContador` from `acueducto_lecturas` where (`acueducto_lecturas`.`idCliente` = `facturas_frecuentes`.`idCliente`) order by `acueducto_lecturas`.`ID` desc limit 1) AS `UltimaLectura`,(select `acueducto_lecturas`.`Facturado` from `acueducto_lecturas` where (`acueducto_lecturas`.`idCliente` = `facturas_frecuentes`.`idCliente`) order by `acueducto_lecturas`.`ID` desc limit 1) AS `EstadoFacturadoUltimo`,(select `acueducto_lecturas`.`Fecha` from `acueducto_lecturas` where (`acueducto_lecturas`.`idCliente` = `facturas_frecuentes`.`idCliente`) order by `acueducto_lecturas`.`ID` desc limit 1,1) AS `FechaPenultimaLectura`,(select `acueducto_lecturas`.`LecturaContador` from `acueducto_lecturas` where (`acueducto_lecturas`.`idCliente` = `facturas_frecuentes`.`idCliente`) order by `acueducto_lecturas`.`ID` desc limit 1,1) AS `PenultimaLectura`,(select `acueducto_lecturas`.`Facturado` from `acueducto_lecturas` where (`acueducto_lecturas`.`idCliente` = `facturas_frecuentes`.`idCliente`) order by `acueducto_lecturas`.`ID` desc limit 1,1) AS `EstadoFacturadoPenultimo` from `facturas_frecuentes` where (`facturas_frecuentes`.`Habilitado` = 1);

DROP TABLE IF EXISTS `vista_factura_compra_totales`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_factura_compra_totales` AS select `fci`.`idFacturaCompra` AS `idFacturaCompra`,(select `empresa_pro_sucursales`.`Nombre` from `empresa_pro_sucursales` where (`empresa_pro_sucursales`.`ID` = `fc`.`idSucursal`)) AS `Sede`,(select `factura_compra`.`Fecha` from `factura_compra` where (`factura_compra`.`ID` = `fci`.`idFacturaCompra`)) AS `Fecha`,(select `factura_compra`.`NumeroFactura` from `factura_compra` where (`factura_compra`.`ID` = `fci`.`idFacturaCompra`)) AS `NumeroFactura`,`fc`.`Tercero` AS `Tercero`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = `fc`.`Tercero`) limit 1) AS `RazonSocial`,sum(`fci`.`SubtotalCompra`) AS `Subtotal`,sum(`fci`.`ImpuestoCompra`) AS `Impuestos`,(select sum(`factura_compra_retenciones`.`ValorRetencion`) from `factura_compra_retenciones` where (`factura_compra_retenciones`.`idCompra` = `fci`.`idFacturaCompra`)) AS `TotalRetenciones`,sum(`fci`.`TotalCompra`) AS `Total`,`fc`.`Concepto` AS `Concepto`,(select sum(`factura_compra_servicios`.`Subtotal_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `SubtotalServicios`,(select sum(`factura_compra_servicios`.`Impuesto_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `ImpuestosServicios`,(select sum(`factura_compra_servicios`.`Total_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `TotalServicios`,(select sum(`factura_compra_items_devoluciones`.`SubtotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `SubtotalDevoluciones`,(select sum(`factura_compra_items_devoluciones`.`ImpuestoCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `ImpuestosDevueltos`,(select sum(`factura_compra_items_devoluciones`.`TotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `TotalDevolucion`,`fc`.`idUsuario` AS `Usuario` from (`factura_compra_items` `fci` join `factura_compra` `fc` on((`fc`.`ID` = `fci`.`idFacturaCompra`))) where (`fc`.`Estado` <> 'ANULADA') group by `fci`.`idFacturaCompra`;

DROP TABLE IF EXISTS `vista_inventario_separados`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_inventario_separados` AS select `si`.`ID` AS `ID`,`si`.`idSeparado` AS `idSeparado`,`si`.`Referencia` AS `Referencia`,`si`.`Nombre` AS `Nombre`,`si`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`si`.`Cantidad` AS `Cantidad`,`si`.`TotalItem` AS `TotalItem`,`si`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`si`.`SubtotalCosto` AS `SubtotalCosto`,`si`.`Departamento` AS `Departamento`,`si`.`SubGrupo1` AS `SubGrupo1`,`si`.`SubGrupo2` AS `SubGrupo2`,`si`.`SubGrupo3` AS `SubGrupo3`,`si`.`SubGrupo4` AS `SubGrupo4`,`si`.`SubGrupo5` AS `SubGrupo5` from (`separados_items` `si` join `separados` `s` on((`s`.`ID` = `si`.`idSeparado`))) where (`s`.`Estado` = 'Abierto');

DROP TABLE IF EXISTS `vista_kardex`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_kardex` AS select `k`.`idKardexMercancias` AS `ID`,`k`.`Fecha` AS `Fecha`,`k`.`Movimiento` AS `Movimiento`,`k`.`Detalle` AS `Detalle`,`k`.`idDocumento` AS `idDocumento`,`k`.`Cantidad` AS `Cantidad`,`k`.`ValorUnitario` AS `ValorUnitario`,`k`.`ValorTotal` AS `ValorTotal`,`k`.`ProductosVenta_idProductosVenta` AS `ProductosVenta_idProductosVenta`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Existencias` AS `Existencias`,`pv`.`CostoUnitario` AS `CostoUnitario`,`pv`.`CostoTotal` AS `CostoTotal`,`pv`.`IVA` AS `IVA`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`k`.`Updated` AS `Updated`,`k`.`Sync` AS `Sync` from (`kardexmercancias` `k` join `productosventa` `pv` on((`k`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`)));

DROP TABLE IF EXISTS `vista_libro_diario`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_libro_diario` AS select `librodiario`.`idLibroDiario` AS `idLibroDiario`,`librodiario`.`Fecha` AS `Fecha`,`librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)),`librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Dpto` AS `Tercero_Cod_Dpto`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,`librodiario`.`Debito` AS `Debito`,`librodiario`.`Credito` AS `Credito`,`librodiario`.`Neto` AS `Neto`,`librodiario`.`idCentroCosto` AS `idCentroCosto`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idSucursal` AS `idSucursal`,`librodiario`.`Estado` AS `Estado`,`librodiario`.`idUsuario` AS `idUsuario` from `librodiario`;

DROP TABLE IF EXISTS `vista_listado_facturas_electronicas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_listado_facturas_electronicas` AS select `t1`.`ID` AS `ID`,`t1`.`idFactura` AS `idFactura`,`t1`.`RespuestaCompletaServidor` AS `RespuestaCompletaServidor`,`t1`.`UUID` AS `UUID`,`t1`.`RutaPDF` AS `RutaPDF`,`t1`.`RutaXML` AS `RutaXML`,`t1`.`Estado` AS `Estado`,`t1`.`PDFCreado` AS `PDFCreado`,`t1`.`ZIPCreado` AS `ZIPCreado`,`t1`.`EnviadoPorMail` AS `EnviadoPorMail`,`t1`.`FechaReporte` AS `FechaReporte`,`t1`.`Created` AS `Created`,`t1`.`Updated` AS `Updated`,`t1`.`Sync` AS `Sync`,(select `t2`.`Fecha` from `facturas` `t2` where (`t1`.`idFactura` = `t2`.`idFacturas`)) AS `FechaFactura`,(select `t2`.`Prefijo` from `facturas` `t2` where (`t1`.`idFactura` = `t2`.`idFacturas`)) AS `PrefijoFactura`,(select `t2`.`NumeroFactura` from `facturas` `t2` where (`t1`.`idFactura` = `t2`.`idFacturas`)) AS `NumeroFactura`,(select `t2`.`Total` from `facturas` `t2` where (`t1`.`idFactura` = `t2`.`idFacturas`)) AS `Total`,(select `t2`.`Clientes_idClientes` from `facturas` `t2` where (`t1`.`idFactura` = `t2`.`idFacturas`)) AS `idCliente`,(select `t2`.`RazonSocial` from `clientes` `t2` where (`t2`.`idClientes` = (select `idCliente`))) AS `RazonSocialCliente`,(select `t2`.`Num_Identificacion` from `clientes` `t2` where (`t2`.`idClientes` = (select `idCliente`))) AS `NIT_Cliente`,(select `t2`.`NombreEstado` from `facturas_electronicas_log_estados` `t2` where (`t1`.`Estado` = `t2`.`ID`)) AS `NombreEstado` from `facturas_electronicas_log` `t1`;

DROP TABLE IF EXISTS `vista_movimientos_clase`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_movimientos_clase` AS select substr(`librodiario`.`CuentaPUC`,1,1) AS `Clase`,sum(`librodiario`.`Debito`) AS `DebitosClase`,sum(`librodiario`.`Credito`) AS `CreditosClase` from `librodiario` where ((`librodiario`.`Fecha` >= '2019-08-01') and (`librodiario`.`Fecha` <= '2020-04-24')) group by substr(`librodiario`.`CuentaPUC`,1,1);

DROP TABLE IF EXISTS `vista_movimientos_cuenta_padre`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_movimientos_cuenta_padre` AS select substr(`librodiario`.`CuentaPUC`,1,4) AS `CuentaPadre`,sum(`librodiario`.`Debito`) AS `DebitosCuentaPadre`,sum(`librodiario`.`Credito`) AS `CreditosCuentaPadre` from `librodiario` where ((`librodiario`.`Fecha` >= '2019-08-01') and (`librodiario`.`Fecha` <= '2020-04-24')) group by substr(`librodiario`.`CuentaPUC`,1,4);

DROP TABLE IF EXISTS `vista_movimientos_grupo`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_movimientos_grupo` AS select substr(`librodiario`.`CuentaPUC`,1,2) AS `Grupo`,sum(`librodiario`.`Debito`) AS `DebitosGrupo`,sum(`librodiario`.`Credito`) AS `CreditosGrupo` from `librodiario` where ((`librodiario`.`Fecha` >= '2019-08-01') and (`librodiario`.`Fecha` <= '2020-04-24')) group by substr(`librodiario`.`CuentaPUC`,1,2);

DROP TABLE IF EXISTS `vista_nomina_servicios_turnos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_nomina_servicios_turnos` AS select `nomina_servicios_turnos`.`ID` AS `ID`,`nomina_servicios_turnos`.`Fecha` AS `Fecha`,`nomina_servicios_turnos`.`Tercero` AS `Tercero`,`nomina_servicios_turnos`.`Sucursal` AS `Sucursal`,`nomina_servicios_turnos`.`Valor` AS `Valor`,`nomina_servicios_turnos`.`idUser` AS `idUser`,`nomina_servicios_turnos`.`Pagado` AS `Pagado`,`nomina_servicios_turnos`.`Estado` AS `Estado`,`nomina_servicios_turnos`.`idDocumentoEquivalente` AS `idDocumentoEquivalente`,`nomina_servicios_turnos`.`Updated` AS `Updated`,`nomina_servicios_turnos`.`Sync` AS `Sync`,(select `empresa_pro_sucursales`.`Nombre` from `empresa_pro_sucursales` where (`empresa_pro_sucursales`.`ID` = `nomina_servicios_turnos`.`Sucursal`) limit 1) AS `NombreSucursal`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = `nomina_servicios_turnos`.`Tercero`) limit 1) AS `NombreTercero` from `nomina_servicios_turnos` where (`nomina_servicios_turnos`.`Estado` <> 'ANULADO');

DROP TABLE IF EXISTS `vista_notas_devolucion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_notas_devolucion` AS select `factura_compra_notas_devolucion`.`ID` AS `ID`,`factura_compra_notas_devolucion`.`Fecha` AS `Fecha`,`factura_compra_notas_devolucion`.`Tercero` AS `Tercero`,`factura_compra_notas_devolucion`.`Concepto` AS `Concepto`,(select sum(`factura_compra_items_devoluciones`.`SubtotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `Subtotal`,(select sum(`factura_compra_items_devoluciones`.`ImpuestoCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `IVA`,(select sum(`factura_compra_items_devoluciones`.`TotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `Total`,`factura_compra_notas_devolucion`.`idCentroCostos` AS `idCentroCostos`,`factura_compra_notas_devolucion`.`idSucursal` AS `idSucursal`,`factura_compra_notas_devolucion`.`idUser` AS `idUser`,`factura_compra_notas_devolucion`.`Estado` AS `Estado` from `factura_compra_notas_devolucion`;

DROP TABLE IF EXISTS `vista_ori_facturas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_ori_facturas` AS select `fi`.`FechaFactura` AS `Fecha`,`fi`.`idFactura` AS `idFactura`,`fi`.`Referencia` AS `Referencia`,`fi`.`Nombre` AS `Nombre`,`fi`.`Departamento` AS `Departamento`,`fi`.`SubGrupo1` AS `SubGrupo1`,`fi`.`SubGrupo2` AS `SubGrupo2`,`fi`.`SubGrupo3` AS `SubGrupo3`,`fi`.`SubGrupo4` AS `SubGrupo4`,`fi`.`SubGrupo5` AS `SubGrupo5`,`fi`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`Dias` AS `Dias`,`fi`.`SubtotalItem` AS `SubtotalItem`,`fi`.`IVAItem` AS `IVAItem`,`fi`.`ValorOtrosImpuestos` AS `ValorOtrosImpuestos`,`fi`.`TotalItem` AS `TotalItem`,`fi`.`PorcentajeIVA` AS `PorcentajeIVA`,`fi`.`idOtrosImpuestos` AS `idOtrosImpuestos`,`fi`.`idPorcentajeIVA` AS `idPorcentajeIVA`,`fi`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`fi`.`SubtotalCosto` AS `SubtotalCosto`,`fi`.`TipoItem` AS `TipoItem`,`fi`.`CuentaPUC` AS `CuentaPUC`,`fi`.`GeneradoDesde` AS `GeneradoDesde`,`fi`.`NumeroIdentificador` AS `NumeroIdentificador`,`fi`.`idUsuarios` AS `idUsuarios`,`fi`.`idCierre` AS `idCierre`,`f`.`idResolucion` AS `idResolucion`,`f`.`TipoFactura` AS `TipoFactura`,`f`.`Prefijo` AS `Prefijo`,`f`.`NumeroFactura` AS `NumeroFactura`,`f`.`Hora` AS `Hora`,`f`.`FormaPago` AS `FormaPago`,`f`.`CentroCosto` AS `CentroCosto`,`f`.`idSucursal` AS `idSucursal`,`f`.`EmpresaPro_idEmpresaPro` AS `EmpresaPro_idEmpresaPro`,`f`.`Clientes_idClientes` AS `Clientes_idClientes`,`f`.`ObservacionesFact` AS `ObservacionesFact` from (`ori_facturas_items` `fi` join `facturas` `f` on((`fi`.`idFactura` = `f`.`idFacturas`)));

DROP TABLE IF EXISTS `vista_pedidos_restaurante`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_pedidos_restaurante` AS select `restaurante_pedidos`.`ID` AS `ID`,`restaurante_pedidos`.`Fecha` AS `Fecha`,`restaurante_pedidos`.`Hora` AS `Hora`,`restaurante_pedidos`.`Estado` AS `Estado`,`restaurante_pedidos`.`idMesa` AS `idMesa`,`restaurante_pedidos`.`idCliente` AS `idCliente`,`restaurante_pedidos`.`NombreCliente` AS `NombreCliente`,`restaurante_pedidos`.`DireccionEnvio` AS `DireccionEnvio`,`restaurante_pedidos`.`TelefonoConfirmacion` AS `TelefonoConfirmacion`,`restaurante_pedidos`.`Observaciones` AS `Observaciones`,`restaurante_pedidos`.`idCierre` AS `idCierre`,(select sum(`restaurante_pedidos_items`.`Subtotal`) AS `Subtotal` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `Subtotal`,(select sum(`restaurante_pedidos_items`.`IVA`) AS `IVA` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `IVA`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `Total`,(select sum(`restaurante_pedidos_items`.`TotalCostos`) from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `TotalCostos`,`restaurante_pedidos`.`idUsuario` AS `idUsuario` from `restaurante_pedidos`;

DROP TABLE IF EXISTS `vista_pedidos_restaurante_pos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_pedidos_restaurante_pos` AS select `t1`.`ID` AS `ID`,`t1`.`Fecha` AS `Fecha`,`t1`.`Hora` AS `Hora`,`t1`.`idUsuario` AS `idUsuario`,`t1`.`idMesa` AS `idMesa`,`t1`.`Estado` AS `Estado`,`t1`.`Tipo` AS `Tipo`,`t1`.`idCliente` AS `idCliente`,`t1`.`NombreCliente` AS `NombreCliente`,`t1`.`DireccionEnvio` AS `DireccionEnvio`,`t1`.`TelefonoConfirmacion` AS `TelefonoConfirmacion`,`t1`.`Observaciones` AS `Observaciones`,`t1`.`idCierre` AS `idCierre`,`t1`.`FechaCreacion` AS `FechaCreacion`,`t1`.`Updated` AS `Updated`,`t1`.`Sync` AS `Sync`,(select sum(`t2`.`Total`) from `restaurante_pedidos_items` `t2` where (`t2`.`idPedido` = `t1`.`ID`)) AS `Total`,(select `t3`.`NombreEstado` from `restaurante_estados_pedidos` `t3` where (`t3`.`ID` = `t1`.`Estado`)) AS `NombreEstado`,(select `t4`.`Nombre` from `restaurante_tipos_pedido` `t4` where (`t4`.`ID` = `t1`.`Tipo`)) AS `NombreTipoPedido`,(select concat(`t5`.`Nombre`,' ',`t5`.`Apellido`) from `usuarios` `t5` where (`t5`.`idUsuarios` = `t1`.`idUsuario`)) AS `NombreUsuario` from `restaurante_pedidos` `t1`;

DROP TABLE IF EXISTS `vista_preventa`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_preventa` AS select `p`.`VestasActivas_idVestasActivas` AS `VestasActivas_idVestasActivas`,'productosventa' AS `TablaItems`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `SubGrupo1`,`pv`.`Sub2` AS `SubGrupo2`,`pv`.`Sub3` AS `SubGrupo3`,`pv`.`Sub4` AS `SubGrupo4`,`pv`.`Sub5` AS `SubGrupo5`,`p`.`ValorAcordado` AS `ValorUnitarioItem`,`p`.`Cantidad` AS `Cantidad`,'1' AS `Dias`,(`p`.`ValorAcordado` * `p`.`Cantidad`) AS `SubtotalItem`,((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`) AS `IVAItem`,((select `productos_impuestos_adicionales`.`ValorImpuesto` from `productos_impuestos_adicionales` where (`productos_impuestos_adicionales`.`idProducto` = `p`.`ProductosVenta_idProductosVenta`)) * `p`.`Cantidad`) AS `ValorOtrosImpuestos`,((`p`.`ValorAcordado` * `p`.`Cantidad`) + ((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`)) AS `TotalItem`,concat((`pv`.`IVA` * 100),'%') AS `PorcentajeIVA`,`pv`.`CostoUnitario` AS `PrecioCostoUnitario`,(`pv`.`CostoUnitario` * `p`.`Cantidad`) AS `SubtotalCosto`,(select `prod_departamentos`.`TipoItem` from `prod_departamentos` where (`prod_departamentos`.`idDepartamentos` = `pv`.`Departamento`)) AS `TipoItem`,`pv`.`CuentaPUC` AS `CuentaPUC`,`p`.`Updated` AS `Updated`,`p`.`Sync` AS `Sync` from (`preventa` `p` join `productosventa` `pv` on((`p`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`))) where (`p`.`TablaItem` = 'productosventa');

DROP TABLE IF EXISTS `vista_productos_devueltos_acuerdos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_productos_devueltos_acuerdos` AS select `t1`.`ID` AS `ID`,`t1`.`Fecha` AS `Fecha`,`t1`.`idFacturasItems` AS `idFacturasItems`,`t1`.`idAcuerdoPago` AS `idAcuerdoPago`,`t1`.`Cantidad` AS `Cantidad`,`t1`.`ValorDevolucion` AS `ValorDevolucion`,`t1`.`Observaciones` AS `Observaciones`,`t1`.`idUser` AS `idUser`,`t1`.`Created` AS `Created`,`t1`.`Updated` AS `Updated`,`t1`.`Sync` AS `Sync`,`t2`.`Referencia` AS `Referencia`,`t2`.`Nombre` AS `Nombre`,`t3`.`ID` AS `ConsecutivoAcuerdo` from ((`acuerdo_pago_productos_devueltos` `t1` join `facturas_items` `t2` on((`t1`.`idFacturasItems` = `t2`.`ID`))) join `acuerdo_pago` `t3` on((`t1`.`idAcuerdoPago` = `t3`.`idAcuerdoPago`))) order by `t1`.`Created` desc;

DROP TABLE IF EXISTS `vista_productos_facturas_acuerdo`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_productos_facturas_acuerdo` AS select `t1`.`ID` AS `ID`,`t1`.`idFactura` AS `idFactura`,(select `t3`.`Num_Identificacion` from `clientes` `t3` where (`t3`.`idClientes` = `t2`.`Clientes_idClientes`) limit 1) AS `Tercero`,`t2`.`Fecha` AS `Fecha`,`t2`.`Hora` AS `Hora`,`t2`.`Prefijo` AS `Prefijo`,`t2`.`NumeroFactura` AS `NumeroFactura`,`t1`.`Referencia` AS `Referencia`,`t1`.`Nombre` AS `Nombre`,round(`t1`.`ValorUnitarioItem`,0) AS `ValorUnitarioItem`,`t1`.`Cantidad` AS `Cantidad`,round(`t1`.`SubtotalItem`,0) AS `SubtotalItem`,round(`t1`.`IVAItem`,0) AS `IVAItem`,round(`t1`.`TotalItem`,0) AS `TotalItem` from (`facturas_items` `t1` join `facturas` `t2` on((`t1`.`idFactura` = `t2`.`idFacturas`))) where (`t2`.`FormaPago` = 'Acuerdo') order by `t2`.`Clientes_idClientes`,`t2`.`Fecha` desc;

DROP TABLE IF EXISTS `vista_productos_x_cliente`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_productos_x_cliente` AS select `t1`.`ID` AS `ID`,`t1`.`Referencia` AS `Referencia`,`t1`.`Nombre` AS `Nombre`,`t1`.`FechaFactura` AS `FechaFactura`,sum(`t1`.`Cantidad`) AS `Cantidad`,sum(`t1`.`TotalItem`) AS `TotalItem`,`t2`.`Clientes_idClientes` AS `idCliente`,`t3`.`RazonSocial` AS `RazonSocial`,`t3`.`Num_Identificacion` AS `Num_Identificacion` from ((`facturas_items` `t1` join `facturas` `t2` on((`t1`.`idFactura` = `t2`.`idFacturas`))) join `clientes` `t3` on((`t2`.`Clientes_idClientes` = `t3`.`idClientes`))) where ((`t1`.`FechaFactura` >= '2020-01-01') and (`t1`.`FechaFactura` <= '2020-08-07')) group by `t1`.`Referencia`;

DROP TABLE IF EXISTS `vista_proyeccion_acuerdos_pago`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_proyeccion_acuerdos_pago` AS select `t1`.`ID` AS `idProyeccion`,`t2`.`ID` AS `ConsecutivoAcuerdo`,`t1`.`idAcuerdoPago` AS `idAcuerdoPago`,`t1`.`TipoCuota` AS `TipoCuota`,`t1`.`NumeroCuota` AS `NumeroCuota`,`t1`.`Fecha` AS `Fecha`,`t1`.`ValorCuota` AS `ValorCuota`,`t1`.`ValorPagado` AS `ValorPagado`,`t1`.`idPago` AS `idPago`,`t1`.`Estado` AS `EstadoProyeccion`,(select `t3`.`NombreEstado` from `acuerdo_pago_proyeccion_estados` `t3` where (`t3`.`ID` = `t1`.`Estado`) limit 1) AS `NombreEstadoProyeccion`,`t2`.`Tercero` AS `Tercero`,(select `t4`.`RazonSocial` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t2`.`Tercero`) limit 1) AS `RazonSocial`,(select `t4`.`idClientes` from `clientes` `t4` where (`t4`.`Num_Identificacion` = `t2`.`Tercero`) limit 1) AS `idClienteAcuerdo`,(select `t5`.`SobreNombre` from `clientes_datos_adicionales` `t5` where (`t5`.`idCliente` = (select `idClienteAcuerdo`)) limit 1) AS `SobreNombreCliente`,`t2`.`ValorCuotaGeneral` AS `ValorCuotaGeneral`,`t2`.`CicloPagos` AS `CicloPagos`,round(`t2`.`SaldoAnterior`,0) AS `SaldoAnterior`,round(`t2`.`SaldoInicial`,0) AS `SaldoInicial`,`t2`.`TotalAbonos` AS `TotalAbonos`,round(`t2`.`SaldoFinal`,0) AS `SaldoFinal` from (`acuerdo_pago_proyeccion_pagos` `t1` join `acuerdo_pago` `t2` on((`t1`.`idAcuerdoPago` = `t2`.`idAcuerdoPago`))) where ((`t2`.`Estado` = 1) and (`t1`.`Estado` <> 1) and (`t1`.`Estado` <> 2)) order by `t2`.`Tercero`,`t1`.`Fecha`;

DROP TABLE IF EXISTS `vista_resumen_facturacion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_facturacion` AS select `facturas_items`.`ID` AS `ID`,`facturas_items`.`FechaFactura` AS `FechaInicial`,`facturas_items`.`FechaFactura` AS `FechaFinal`,`facturas_items`.`Referencia` AS `Referencia`,(select `productosventa`.`idProductosVenta` from `productosventa` where (`productosventa`.`Referencia` = `facturas_items`.`Referencia`)) AS `idProducto`,`facturas_items`.`Nombre` AS `Nombre`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,sum(`facturas_items`.`Cantidad`) AS `Cantidad`,round(sum(`facturas_items`.`TotalItem`),2) AS `TotalVenta`,round(sum(`facturas_items`.`SubtotalCosto`),2) AS `Costo` from `facturas_items` group by `facturas_items`.`FechaFactura`,`facturas_items`.`Referencia`;

DROP TABLE IF EXISTS `vista_resumen_restaurante_turno_actual`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_restaurante_turno_actual` AS select `t1`.`idProductosVenta` AS `idProductosVenta`,`t1`.`Nombre` AS `Nombre`,(select ifnull((select sum(`fci`.`Cantidad`) from `factura_compra_items` `fci` where ((`t1`.`idProductosVenta` = `fci`.`idProducto`) and (`fci`.`idCierre` = '0'))),0)) AS `ItemsCompras`,(select ifnull((select sum(`fi`.`Cantidad`) from `facturas_items` `fi` where ((`t1`.`Referencia` = `fi`.`Referencia`) and (`fi`.`idCierre` = '0'))),0)) AS `ItemsVentas`,(select ifnull((select sum(`ti`.`Cantidad`) from `traslados_items` `ti` where ((convert(`ti`.`Referencia` using utf8) = convert(`t1`.`Referencia` using utf8)) and (`ti`.`Destino` = '$SedeActual') and (`ti`.`idCierre` = '0'))),0)) AS `TrasladosRecibidos`,(select ifnull((select sum(`ti`.`Cantidad`) from `traslados_items` `ti` where ((convert(`ti`.`Referencia` using utf8) = convert(`t1`.`Referencia` using utf8)) and (`ti`.`Destino` <> '$SedeActual') and (`ti`.`idCierre` = '0') and (`ti`.`Estado` = 'PREPARADO'))),0)) AS `TrasladosEnviados`,(select ifnull((select sum(`icm`.`Cantidad`) from `inventario_comprobante_movimientos_items` `icm` where ((`t1`.`idProductosVenta` = `icm`.`idProducto`) and (`icm`.`TablaOrigen` = 'productosventa') and (`icm`.`TipoMovimiento` = 'BAJA') and (`icm`.`idCierre` = '0'))),0)) AS `TotalBajas`,(select ifnull((select sum(`icm`.`Cantidad`) from `inventario_comprobante_movimientos_items` `icm` where ((`t1`.`idProductosVenta` = `icm`.`idProducto`) and (`icm`.`TablaOrigen` = 'productosventa') and (`icm`.`TipoMovimiento` = 'ALTA') and (`icm`.`idCierre` = '0'))),0)) AS `TotalAltas`,((((((`t1`.`Existencias` - (select `ItemsCompras`)) + (select `TrasladosEnviados`)) - (select `TrasladosRecibidos`)) + (select `TotalBajas`)) - (select `TotalAltas`)) + (select `ItemsVentas`)) AS `CantidadRecibida`,`t1`.`Existencias` AS `SaldoFinal`,(select ifnull((select sum(`fi`.`TotalItem`) from `facturas_items` `fi` where ((`t1`.`Referencia` = `fi`.`Referencia`) and (`fi`.`idCierre` = '0'))),0)) AS `TotalVentas`,(`t1`.`ValorComision1` * (select `ItemsVentas`)) AS `TotalComisiones1`,(`t1`.`ValorComision2` * (select `ItemsVentas`)) AS `TotalComisiones2`,(`t1`.`ValorComision3` * (select `ItemsVentas`)) AS `TotalComisiones3`,(`t1`.`ValorComision4` * (select `ItemsVentas`)) AS `TotalComisiones4`,(((((select `TotalVentas`) - (select `TotalComisiones1`)) - (select `TotalComisiones2`)) - (select `TotalComisiones3`)) - (select `TotalComisiones4`)) AS `TotalCasa` from `productosventa` `t1`;

DROP TABLE IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_ventas_departamentos` AS select `facturas_items`.`FechaFactura` AS `FechaFactura`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,sum(`facturas_items`.`TotalItem`) AS `Total` from `facturas_items` group by `facturas_items`.`FechaFactura`,`facturas_items`.`Departamento`,`facturas_items`.`SubGrupo1`,`facturas_items`.`SubGrupo2`,`facturas_items`.`SubGrupo3`,`facturas_items`.`SubGrupo4`,`facturas_items`.`SubGrupo5`;

DROP TABLE IF EXISTS `vista_retenciones`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_retenciones` AS select `factura_compra_retenciones`.`idCompra` AS `idCompra`,(select `factura_compra`.`Fecha` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `Fecha`,(select `factura_compra`.`Tercero` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `Tercero`,(select `factura_compra`.`Estado` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `Estado`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `RazonSocial`,(select `proveedores`.`DV` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `DV`,(select `proveedores`.`Direccion` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `Direccion`,(select `proveedores`.`Ciudad` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `Ciudad`,`factura_compra_retenciones`.`CuentaPUC` AS `CuentaPUC`,`factura_compra_retenciones`.`NombreCuenta` AS `Cuenta`,`factura_compra_retenciones`.`ValorRetencion` AS `ValorRetencion`,`factura_compra_retenciones`.`PorcentajeRetenido` AS `PorcentajeRetenido`,round(((`factura_compra_retenciones`.`ValorRetencion` / `factura_compra_retenciones`.`PorcentajeRetenido`) * 100),2) AS `BaseRetencion`,(select `factura_compra`.`idEmpresa` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idEmpresa`,(select `factura_compra`.`idCentroCostos` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idCentroCostos`,(select `factura_compra`.`idSucursal` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idSucursal` from `factura_compra_retenciones`;

DROP TABLE IF EXISTS `vista_retenciones_tercero`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_retenciones_tercero` AS select `vista_retenciones`.`idCompra` AS `idCompra`,`vista_retenciones`.`Fecha` AS `Fecha`,`vista_retenciones`.`Tercero` AS `Tercero`,`vista_retenciones`.`RazonSocial` AS `RazonSocial`,`vista_retenciones`.`DV` AS `DV`,`vista_retenciones`.`Direccion` AS `Direccion`,`vista_retenciones`.`Ciudad` AS `Ciudad`,`vista_retenciones`.`CuentaPUC` AS `CuentaPUC`,`vista_retenciones`.`Cuenta` AS `Cuenta`,`vista_retenciones`.`ValorRetencion` AS `ValorRetencion`,`vista_retenciones`.`PorcentajeRetenido` AS `PorcentajeRetenido`,`vista_retenciones`.`BaseRetencion` AS `BaseRetencion` from `vista_retenciones` where ((`vista_retenciones`.`Fecha` >= '2019-01-20') and (`vista_retenciones`.`Fecha` <= '2019-01-20') and (`vista_retenciones`.`Tercero` = '94481747'));

DROP TABLE IF EXISTS `vista_saldos_iniciales_clase`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_saldos_iniciales_clase` AS select substr(`librodiario`.`CuentaPUC`,1,1) AS `Clase`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `SaldoInicialClase` from `librodiario` where (`librodiario`.`Fecha` < '2019-08-01') group by substr(`librodiario`.`CuentaPUC`,1,1);

DROP TABLE IF EXISTS `vista_saldos_iniciales_cuenta_padre`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_saldos_iniciales_cuenta_padre` AS select substr(`librodiario`.`CuentaPUC`,1,4) AS `CuentaPadre`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `SaldoInicialCuentaPadre` from `librodiario` where (`librodiario`.`Fecha` < '2019-08-01') group by substr(`librodiario`.`CuentaPUC`,1,4);

DROP TABLE IF EXISTS `vista_saldos_iniciales_grupo`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_saldos_iniciales_grupo` AS select substr(`librodiario`.`CuentaPUC`,1,2) AS `Grupo`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `SaldoInicialGrupo` from `librodiario` where (`librodiario`.`Fecha` < '2019-08-01') group by substr(`librodiario`.`CuentaPUC`,1,2);

DROP TABLE IF EXISTS `vista_saldo_inicial_clase_cuenta`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_saldo_inicial_clase_cuenta` AS select distinct substr(`librodiario`.`CuentaPUC`,1,1) AS `ID`,(select sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) from `librodiario` where ((`librodiario`.`Fecha` < '2018-01-01') and (substr(`librodiario`.`CuentaPUC`,1,1) = (select `ID`)))) AS `SaldoInicial` from `librodiario` where ((`librodiario`.`Fecha` >= '2018-01-01') and (`librodiario`.`Fecha` <= '2019-04-25')) order by substr(`librodiario`.`CuentaPUC`,1,1);

DROP TABLE IF EXISTS `vista_saldo_inicial_cuenta`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_saldo_inicial_cuenta` AS select substr(`librodiario`.`CuentaPUC`,1,4) AS `ID`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `SaldoInicial` from `librodiario` where ((`librodiario`.`Fecha` >= '2018-01-01') and (`librodiario`.`Fecha` <= '2019-04-25')) group by substr(`librodiario`.`CuentaPUC`,1,4);

DROP TABLE IF EXISTS `vista_saldo_inicial_cuentapuc`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_saldo_inicial_cuentapuc` AS select `librodiario`.`CuentaPUC` AS `ID`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `SaldoInicial` from `librodiario` where ((`librodiario`.`Fecha` >= '2019-08-01') and (`librodiario`.`Fecha` <= '2020-04-24')) group by `librodiario`.`CuentaPUC`,`librodiario`.`Tercero_Identificacion`;

DROP TABLE IF EXISTS `vista_saldo_inicial_grupopuc`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_saldo_inicial_grupopuc` AS select substr(`librodiario`.`CuentaPUC`,1,2) AS `ID`,sum((`librodiario`.`Debito` - `librodiario`.`Credito`)) AS `SaldoInicial` from `librodiario` where ((`librodiario`.`Fecha` >= '2018-01-01') and (`librodiario`.`Fecha` <= '2019-04-25')) group by substr(`librodiario`.`CuentaPUC`,1,2);

DROP TABLE IF EXISTS `vista_separados_reportes`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_separados_reportes` AS select `t1`.`ID` AS `ID`,`t1`.`Fecha` AS `Fecha`,`t1`.`Hora` AS `Hora`,`t1`.`idCliente` AS `idCliente`,`t1`.`Total` AS `Total`,`t1`.`Saldo` AS `Saldo`,`t1`.`Estado` AS `Estado`,`t1`.`Observaciones` AS `Observaciones`,`t1`.`idUsuarios` AS `idUsuarios`,`t1`.`idSucursal` AS `idSucursal`,`t1`.`Updated` AS `Updated`,`t1`.`Sync` AS `Sync`,`t2`.`RazonSocial` AS `RazonSocial`,`t2`.`Num_Identificacion` AS `Num_Identificacion`,`t2`.`Telefono` AS `Telefono`,`t2`.`Direccion` AS `Direccion`,(select (`t1`.`Fecha` + interval 2 month)) AS `FechaVencimiento` from (`separados` `t1` join `clientes` `t2` on((`t1`.`idCliente` = `t2`.`idClientes`)));

DROP TABLE IF EXISTS `vista_sistemas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_sistemas` AS select `si`.`ID` AS `ID`,`st`.`ID` AS `idSistema`,`st`.`Nombre` AS `Nombre_Sistema`,`st`.`Observaciones` AS `Observaciones`,`si`.`TablaOrigen` AS `TablaOrigen`,`s`.`idProductosVenta` AS `CodigoInterno`,`s`.`Nombre` AS `Nombre`,`si`.`Cantidad` AS `Cantidad`,`si`.`ValorUnitario` AS `PrecioUnitario`,round((`si`.`ValorUnitario` * `si`.`Cantidad`),0) AS `PrecioVenta`,round(`s`.`CostoUnitario`,0) AS `CostoUnitario`,round((`si`.`Cantidad` * `s`.`CostoUnitario`),0) AS `Costo_Total_Item`,`s`.`IVA` AS `IVA`,`s`.`Departamento` AS `Departamento`,`s`.`Sub1` AS `Sub1`,`s`.`Sub2` AS `Sub2`,`s`.`Sub3` AS `Sub3`,`s`.`Sub4` AS `Sub4`,`s`.`Sub5` AS `Sub5`,`st`.`Updated` AS `Updated`,`st`.`Sync` AS `Sync` from ((`sistemas_relaciones` `si` join `servicios` `s` on((`s`.`Referencia` = `si`.`Referencia`))) join `sistemas` `st` on((`st`.`ID` = `si`.`idSistema`))) union select `si`.`ID` AS `ID`,`st`.`ID` AS `idSistema`,`st`.`Nombre` AS `Nombre_Sistema`,`st`.`Observaciones` AS `Observaciones`,`si`.`TablaOrigen` AS `TablaOrigen`,`s`.`idProductosVenta` AS `CodigoInterno`,`s`.`Nombre` AS `Nombre`,`si`.`Cantidad` AS `Cantidad`,`si`.`ValorUnitario` AS `PrecioUnitario`,round((`si`.`ValorUnitario` * `si`.`Cantidad`),0) AS `PrecioVenta`,round(`s`.`CostoUnitario`,0) AS `CostoUnitario`,round((`si`.`Cantidad` * `s`.`CostoUnitario`),0) AS `Costo_Total_Item`,`s`.`IVA` AS `IVA`,`s`.`Departamento` AS `Departamento`,`s`.`Sub1` AS `Sub1`,`s`.`Sub2` AS `Sub2`,`s`.`Sub3` AS `Sub3`,`s`.`Sub4` AS `Sub4`,`s`.`Sub5` AS `Sub5`,`st`.`Updated` AS `Updated`,`st`.`Sync` AS `Sync` from ((`sistemas_relaciones` `si` join `productosventa` `s` on((`s`.`Referencia` = `si`.`Referencia`))) join `sistemas` `st` on((`st`.`ID` = `si`.`idSistema`)));

DROP TABLE IF EXISTS `vista_tickets`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_tickets` AS select `t1`.`ID` AS `ID`,`t1`.`idProyecto` AS `idProyecto`,`t1`.`TipoTicket` AS `TipoTicket`,`t1`.`idModuloProyecto` AS `idModuloProyecto`,`t1`.`Prioridad` AS `Prioridad`,`t1`.`FechaApertura` AS `FechaApertura`,`t1`.`Asunto` AS `Asunto`,`t1`.`Estado` AS `Estado`,`t1`.`idUsuarioSolicitante` AS `idUsuarioSolicitante`,`t1`.`idUsuarioAsignado` AS `idUsuarioAsignado`,`t1`.`FechaActualizacion` AS `FechaActualizacion`,`t1`.`idUsuarioActualiza` AS `idUsuarioActualiza`,`t1`.`FechaCierre` AS `FechaCierre`,`t1`.`idUsuarioCierra` AS `idUsuarioCierra`,(select `usuarios`.`Nombre` from `usuarios` where (`usuarios`.`idUsuarios` = `t1`.`idUsuarioSolicitante`)) AS `NombreSolicitante`,(select `usuarios`.`Apellido` from `usuarios` where (`usuarios`.`idUsuarios` = `t1`.`idUsuarioSolicitante`)) AS `ApellidoSolicitante`,(select `usuarios`.`Nombre` from `usuarios` where (`usuarios`.`idUsuarios` = `t1`.`idUsuarioAsignado`)) AS `NombreAsignado`,(select `usuarios`.`Apellido` from `usuarios` where (`usuarios`.`idUsuarios` = `t1`.`idUsuarioAsignado`)) AS `ApellidoAsignado`,(select `t2`.`Estado` from `tickets_estados` `t2` where (`t2`.`ID` = `t1`.`Estado`)) AS `NombreEstado`,(select `t2`.`Prioridad` from `tickets_prioridad` `t2` where (`t2`.`ID` = `t1`.`Prioridad`)) AS `NombrePrioridad`,(select `t2`.`Proyecto` from `tickets_proyectos` `t2` where (`t2`.`ID` = `t1`.`idProyecto`)) AS `NombreProyecto`,(select `t2`.`NombreModulo` from `tickets_modulos_proyectos` `t2` where (`t2`.`ID` = `t1`.`idModuloProyecto`)) AS `NombreModulo`,(select `t2`.`TipoTicket` from `tickets_tipo` `t2` where (`t2`.`ID` = `t1`.`TipoTicket`)) AS `NombreTipoTicket` from `tickets` `t1`;

DROP TABLE IF EXISTS `vista_titulos_abonos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_abonos` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`Hora` AS `Hora`,`td`.`Monto` AS `Monto`,`td`.`idVenta` AS `idVenta`,`tv`.`Promocion` AS `Promocion`,`tv`.`Mayor1` AS `Mayor`,`td`.`Observaciones` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`Estado` AS `Estado`,`td`.`idComprobanteIngreso` AS `idComprobanteIngreso`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_abonos` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_titulos_comisiones`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_comisiones` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`Hora` AS `Hora`,`td`.`Monto` AS `Monto`,`td`.`idVenta` AS `idVenta`,`tv`.`Promocion` AS `Promocion`,`tv`.`Mayor1` AS `Mayor`,`td`.`Observaciones` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`idUsuario` AS `idUsuario`,`td`.`idEgreso` AS `idEgreso`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_comisiones` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_titulos_devueltos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_devueltos` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`idVenta` AS `idVenta`,`td`.`Promocion` AS `Promocion`,`td`.`Mayor` AS `Mayor`,`td`.`Concepto` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`idUsuario` AS `idUsuario`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_devoluciones` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_totales_facturacion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_totales_facturacion` AS select `facturas_items`.`FechaFactura` AS `FechaFactura`,sum(`facturas_items`.`Cantidad`) AS `Items`,round(sum(`facturas_items`.`SubtotalItem`),0) AS `Subtotal`,round(sum(`facturas_items`.`IVAItem`),0) AS `IVA`,round(sum(`facturas_items`.`ValorOtrosImpuestos`),0) AS `OtrosImpuestos`,round(sum(`facturas_items`.`TotalItem`),0) AS `Total` from `facturas_items` group by `facturas_items`.`FechaFactura`;

-- 2020-09-26 13:02:57
