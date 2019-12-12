DROP TABLE IF EXISTS `catalogo_departamentos`;
CREATE TABLE `catalogo_departamentos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint(20) unsigned NOT NULL,
  `Nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoDANE` char(255) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NULL DEFAULT NULL,
  `Sync` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CodigoDANE` (`CodigoDANE`)
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `catalogo_departamentos` (`ID`, `country_id`, `Nombre`, `CodigoDANE`, `Updated`, `Sync`) VALUES
(1,	46,	'Amazonas',	'91',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(2,	46,	'Antioquia',	'05',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(3,	46,	'Arauca',	'81',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(4,	46,	'Atlántico',	'08',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(5,	46,	'Bogotá',	'11',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(6,	46,	'Bolívar',	'13',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(7,	46,	'Boyacá',	'15',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(8,	46,	'Caldas',	'17',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(9,	46,	'Caquetá',	'18',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(10,	46,	'Casanare',	'85',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(11,	46,	'Cauca',	'19',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(12,	46,	'Cesar',	'20',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(13,	46,	'Chocó',	'27',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(14,	46,	'Córdoba',	'23',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(15,	46,	'Cundinamarca',	'25',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(16,	46,	'Guainía',	'94',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(17,	46,	'Guaviare',	'95',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(18,	46,	'Huila',	'41',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(19,	46,	'La Guajira',	'44',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(20,	46,	'Magdalena',	'47',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(21,	46,	'Meta',	'50',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(22,	46,	'Nariño',	'52',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(23,	46,	'Norte de Santander',	'54',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(24,	46,	'Putumayo',	'86',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(25,	46,	'Quindío',	'63',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(26,	46,	'Risaralda',	'66',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(27,	46,	'San Andrés y Providencia',	'88',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(28,	46,	'Santander',	'68',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(29,	46,	'Sucre',	'70',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(30,	46,	'Tolima',	'73',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(31,	46,	'Valle del Cauca',	'76',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(32,	46,	'Vaupés',	'97',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06'),
(33,	46,	'Vichada',	'99',	'2019-09-26 18:54:06',	'2019-09-26 18:54:06');
