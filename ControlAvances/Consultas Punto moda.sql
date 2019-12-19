SELECT *
FROM `facturas_items`
WHERE `FechaFactura` >= '2019-11-01' AND `FechaFactura` <= '2019-11-31'
AND IVAItem=0 AND Referencia <> 'REF7498' AND Departamento <> 7;

UPDATE facturas_items SET SubtotalItem = ROUND(TotalItem / 1.19 , 2), IVAItem= round(SubtotalItem*0.19,2),
 PorcentajeIVA='19%' WHERE `FechaFactura` >= '2019-11-01' AND `FechaFactura` <= '2019-11-31'
AND IVAItem=0 AND Referencia <> 'REF7498' AND Departamento <> 7;