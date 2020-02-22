-- Adminer 4.7.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

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
  PRIMARY KEY (`ID`),
  KEY `TipoTicket` (`TipoTicket`),
  KEY `idProyecto` (`idProyecto`),
  KEY `idModuloProyecto` (`idModuloProyecto`),
  KEY `Estado` (`Estado`),
  KEY `Asunto` (`Asunto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `tickets_adjuntos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `NombreArchivo` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Extension` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Tamano` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `idMensaje` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idMensaje` (`idMensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `tickets_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tickets_estados` (`ID`, `Estado`) VALUES
(1,	'ABIERTO'),
(2,	'EN ANALISIS'),
(3,	'RESPONDIDO'),
(11,	'ARCHIVADO'),
(10,	'CERRADO'),
(12,	'ELIMINADO'),
(4,	'EN DESARROLLO'),
(5,	'EN PRUEBAS');

CREATE TABLE `tickets_mensajes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idTicket` bigint(20) NOT NULL,
  `Mensaje` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idTicket` (`idTicket`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `tickets_modulos_proyectos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProyecto` int(11) NOT NULL,
  `NombreModulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tickets_modulos_proyectos` (`ID`, `idProyecto`, `NombreModulo`, `Estado`) VALUES
(1,	1,	'FACTURACION',	1),
(2,	1,	'CONTABILIDAD',	1),
(3,	1,	'ACUERDOS DE PAGO',	1),
(4,	1,	'INFORMES',	1),
(5,	1,	'COTIZACIONES',	1),
(6,	1,	'MODULO DE MANTENIMIENTO DE VEHICULOS',	1),
(7,	1,	'TICKETS',	1),
(8,	1,	'GENERAL',	1),
(9,	1,	'RESTAURANTE',	1),
(10,	1,	'MODELOS',	1);

CREATE TABLE `tickets_prioridad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Prioridad` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tickets_prioridad` (`ID`, `Prioridad`) VALUES
(1,	'Baja'),
(2,	'Media'),
(3,	'Alta');

CREATE TABLE `tickets_proyectos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Proyecto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tickets_proyectos` (`ID`, `Proyecto`, `Estado`) VALUES
(1,	'TS5',	1),
(2,	'TAGS',	1),
(3,	'TSS',	1);

CREATE TABLE `tickets_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoTicket` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `tickets_tipo` (`ID`, `TipoTicket`) VALUES
(1,	'Requerimiento'),
(2,	'Hallazgo'),
(3,	'Soporte Técnico'),
(4,	'Notificación'),
(5,	'Labor Asignada'),
(6,	'Acta de Reunion');

-- 2020-02-21 16:37:04



CREATE TABLE `empresa_cargos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCargo` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `empresa_nombres_procesos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreProceso` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `usuarios` ADD `Cargo` INT(5) UNSIGNED ZEROFILL NOT NULL AFTER `TipoUser`;
ALTER TABLE `usuarios` ADD `Proceso` INT(5) UNSIGNED ZEROFILL NOT NULL AFTER `Cargo`;


DROP VIEW IF EXISTS `vista_tickets`;
CREATE VIEW vista_tickets AS 
SELECT *,
    (SELECT Nombre FROM usuarios WHERE idUsuarios=t1.idUsuarioSolicitante) AS NombreSolicitante,
    (SELECT Apellido FROM usuarios WHERE idUsuarios=t1.idUsuarioSolicitante) AS ApellidoSolicitante,
    (SELECT Nombre FROM usuarios WHERE idUsuarios=t1.idUsuarioAsignado) AS NombreAsignado,
    (SELECT Apellido FROM usuarios WHERE idUsuarios=t1.idUsuarioAsignado) AS ApellidoAsignado,
    (SELECT Estado FROM tickets_estados t2 WHERE t2.ID=t1.Estado) AS NombreEstado, 
    (SELECT Prioridad FROM tickets_prioridad t2 WHERE t2.ID=t1.Prioridad) AS NombrePrioridad,
    (SELECT Proyecto FROM tickets_proyectos t2 WHERE t2.ID=t1.idProyecto) AS NombreProyecto,
    (SELECT NombreModulo FROM tickets_modulos_proyectos t2 WHERE t2.ID=t1.idModuloProyecto) AS NombreModulo,
    (SELECT TipoTicket FROM tickets_tipo t2 WHERE t2.ID=t1.TipoTicket) AS NombreTipoTicket
FROM tickets t1 ;


