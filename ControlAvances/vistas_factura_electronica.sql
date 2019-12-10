
DROP VIEW IF EXISTS `vista_creacion_facturas_electronicas`;
CREATE VIEW vista_creacion_facturas_electronicas AS
SELECT t1.idFacturas,
    (SELECT Factura FROM empresapro_resoluciones_facturacion t2 WHERE t1.idResolucion=t2.ID) as TipoFact
