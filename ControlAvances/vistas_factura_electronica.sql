
DROP VIEW IF EXISTS `vista_listado_facturas_electronicas`;
CREATE VIEW vista_listado_facturas_electronicas AS
SELECT t1.*,
    (SELECT Fecha FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as FechaFactura,
    (SELECT Prefijo FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as PrefijoFactura,
    (SELECT NumeroFactura FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as NumeroFactura,
    (SELECT Total FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as Total,
    (SELECT Clientes_idClientes FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as idCliente,
    (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT idCliente)) as RazonSocialCliente,
    (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT idCliente)) as NIT_Cliente,
    (SELECT NombreEstado FROM facturas_electronicas_log_estados t2 WHERE t1.Estado=t2.ID) as NombreEstado
FROM facturas_electronicas_log t1;    

DROP VIEW IF EXISTS `vista_notas_credito_fe`;
CREATE VIEW vista_notas_credito_fe AS
SELECT t1.*,
    (SELECT Fecha FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as FechaFactura,
    (SELECT Prefijo FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as PrefijoFactura,
    (SELECT NumeroFactura FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as NumeroFactura,
    (SELECT Total FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as Total,
    (SELECT Clientes_idClientes FROM facturas t2 WHERE CONVERT(t1.idFactura USING utf8)=CONVERT(t2.idFacturas USING utf8)) as idCliente,
    (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT idCliente)) as RazonSocialCliente,
    (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT idCliente)) as NIT_Cliente,
    (SELECT NombreEstado FROM facturas_electronicas_log_estados t2 WHERE t1.Estado=t2.ID) as NombreEstado
FROM notas_credito t1;    


