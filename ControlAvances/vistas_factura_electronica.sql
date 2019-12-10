
DROP VIEW IF EXISTS `vista_listado_facturas_electronicas`;
CREATE VIEW vista_listado_facturas_electronicas AS
SELECT t1.*,
    (SELECT Fecha FROM facturas t2 WHERE t1.idFactura=t2.idFacturas) as FechaFactura,
    (SELECT Prefijo FROM facturas t2 WHERE t1.idFactura=t2.idFacturas) as PrefijoFactura,
    (SELECT NumeroFactura FROM facturas t2 WHERE t1.idFactura=t2.idFacturas) as NumeroFactura,
    (SELECT Total FROM facturas t2 WHERE t1.idFactura=t2.idFacturas) as Total,
    (SELECT Clientes_idClientes FROM facturas t2 WHERE t1.idFactura=t2.idFacturas) as idCliente,
    (SELECT RazonSocial FROM clientes t2 WHERE t2.idClientes=(SELECT idCliente)) as RazonSocialCliente,
    (SELECT Num_Identificacion FROM clientes t2 WHERE t2.idClientes=(SELECT idCliente)) as NIT_Cliente,
    (SELECT NombreEstado FROM facturas_electronicas_log_estados t2 WHERE t1.Estado=t2.ID) as NombreEstado
FROM facturas_electronicas_log t1;    
