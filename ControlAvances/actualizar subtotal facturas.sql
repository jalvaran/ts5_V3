DROP VIEW IF EXISTS `vista_facturas_subtotal`;
CREATE VIEW vista_facturas_subtotal AS
SELECT t1.idFacturas,
(SELECT round(SUM(SubTotalItem),2) FROM facturas_items t2 WHERE t1.idFacturas = t2.idFactura) as subtotal_items 
from facturas t1;

update facturas t1 join vista_facturas_subtotal t2 on t1.idFacturas=t2.idFacturas 
set t1.Subtotal= t2.subtotal_items WHERE t1.idFacturas=t2.idFacturas;
