DROP VIEW IF EXISTS `vista_resumen_facturacion`;
CREATE VIEW vista_resumen_facturacion AS
SELECT ID,`FechaFactura` as FechaInicial,`FechaFactura` as FechaFinal,`Referencia`,(SELECT idProductosVenta FROM productosventa WHERE productosventa.Referencia=facturas_items.Referencia) as idProducto,`Nombre`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5`,SUM(`Cantidad`) as Cantidad,round(SUM(`TotalItem`),2) as TotalVenta,round(SUM(`SubtotalCosto`),2) as Costo
  FROM `facturas_items` GROUP BY `FechaFactura`,`Referencia`;


DROP VIEW IF EXISTS `vista_inventario_separados`;
CREATE VIEW vista_inventario_separados AS
SELECT si.`ID`,`Referencia`,`Nombre`,SUM(`Cantidad`) as Cantidad,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5` 
FROM `separados_items` si INNER JOIN separados s ON s.ID=si.`idSeparado` 
WHERE s.Estado='Abierto' GROUP BY si.`Referencia`;

DROP VIEW IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE VIEW vista_resumen_ventas_departamentos AS 
SELECT `FechaFactura`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5`, 
SUM(`TotalItem`) AS Total FROM `facturas_items`  
GROUP BY `FechaFactura`, `Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5` ;

DROP VIEW IF EXISTS `vista_factura_compra_totales`;
CREATE VIEW vista_factura_compra_totales AS 
SELECT `idFacturaCompra`,(SELECT Nombre FROM empresa_pro_sucursales WHERE empresa_pro_sucursales.ID=fc.idSucursal) AS Sede,(SELECT Fecha FROM factura_compra WHERE ID=`idFacturaCompra`) as Fecha,
(SELECT NumeroFactura FROM factura_compra WHERE ID=`idFacturaCompra`) as NumeroFactura,
fc.Tercero as Tercero,(SELECT RazonSocial FROM proveedores WHERE proveedores.Num_Identificacion=fc.Tercero LIMIT 1) as RazonSocial,
sum(`SubtotalCompra`) AS Subtotal, sum(`ImpuestoCompra`) as Impuestos,
(SELECT sum(ValorRetencion) FROM factura_compra_retenciones WHERE idCompra=`idFacturaCompra`) as TotalRetenciones,
sum(`TotalCompra`) as Total, fc.Concepto as Concepto,
(SELECT sum(Subtotal_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=fci.`idFacturaCompra`) as SubtotalServicios, 
(SELECT sum(Impuesto_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=fci.`idFacturaCompra`) as ImpuestosServicios,
(SELECT sum(Total_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=fci.`idFacturaCompra`) as TotalServicios,
(SELECT sum(SubtotalCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=fci.`idFacturaCompra`) as SubtotalDevoluciones,
(SELECT sum(ImpuestoCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=fci.`idFacturaCompra`) as ImpuestosDevueltos,
(SELECT sum(TotalCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=fci.`idFacturaCompra`) as TotalDevolucion,
fc.idUsuario as Usuario
FROM `factura_compra_items` fci INNER JOIN factura_compra fc ON fc.ID=fci.idFacturaCompra 
WHERE fc.Estado<>'ANULADA' GROUP BY `idFacturaCompra`;


DROP VIEW IF EXISTS `vista_diferencia_inventarios_selectivos`;
CREATE VIEW vista_diferencia_inventarios_selectivos AS
SELECT idProductosVenta,`Referencia`,`Nombre`,`Existencias` as ExistenciaAnterior,
(SELECT IFNULL((SELECT Cantidad FROM inventarios_conteo_selectivo WHERE productosventa.Referencia = inventarios_conteo_selectivo.Referencia),0)) as ExistenciaActual,
(SELECT ExistenciaActual) - (Existencias) as Diferencia,PrecioVenta,CostoUnitario,
(SELECT Diferencia)*CostoUnitario AS TotalCostosDiferencia,Departamento,Sub1,Sub2,Sub3,Sub4,Sub5
  FROM `productosventa` 
WHERE (SELECT IFNULL((SELECT Cantidad FROM inventarios_conteo_selectivo WHERE productosventa.Referencia = inventarios_conteo_selectivo.Referencia),0))-Existencias<>0
 AND (SELECT IFNULL((SELECT Cantidad FROM inventarios_conteo_selectivo WHERE productosventa.Referencia = inventarios_conteo_selectivo.Referencia),0))>0;


DROP VIEW IF EXISTS `vista_diferencia_inventarios`;
CREATE VIEW vista_diferencia_inventarios AS
SELECT idProductosVenta,`Referencia`,`Nombre`,`Existencias` as ExistenciaAnterior,
(SELECT IFNULL((SELECT Existencias FROM inventarios_temporal WHERE productosventa.Referencia = inventarios_temporal.Referencia),0)) as ExistenciaActual,
(SELECT ExistenciaActual) - (Existencias) as Diferencia,PrecioVenta,CostoUnitario,
(SELECT Diferencia)*CostoUnitario AS TotalCostosDiferencia,Departamento,Sub1,Sub2,Sub3,Sub4,Sub5
  FROM `productosventa` 
WHERE (SELECT IFNULL((SELECT Existencias FROM inventarios_temporal WHERE productosventa.Referencia = inventarios_temporal.Referencia),0))-Existencias<>0;


DROP VIEW IF EXISTS `vista_facturacion_detalles`;
CREATE VIEW vista_facturacion_detalles AS
SELECT `ID`,`FechaFactura`,
(SELECT NumeroFactura FROM facturas WHERE idFacturas=`idFactura`) as NumeroFactura,
(SELECT FormaPago FROM facturas WHERE idFacturas=`idFactura`) as TipoFactura, 
`TablaItems`,`Referencia`,`Nombre`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,
`SubGrupo4`,`SubGrupo5`,`ValorUnitarioItem`,`Cantidad`,`SubtotalItem`,`IVAItem`,`TotalItem`,
`PorcentajeIVA`,`PrecioCostoUnitario`,`SubtotalCosto`,CuentaPUC,idUsuarios,idCierre,
(SELECT ObservacionesFact FROM facturas WHERE idFacturas=`idFactura`) as Observaciones 
FROM `facturas_items` ;

DROP VIEW IF EXISTS `vista_documentos_equivalentes`;
CREATE VIEW vista_documentos_equivalentes AS
SELECT de.ID,de.Fecha,de.Tercero,de.Estado,
(SELECT SUM(Total) FROM documento_equivalente_items dei WHERE dei.idDocumento=de.`ID`) as Total
FROM `documento_equivalente` de ;


DROP VIEW IF EXISTS `vista_exogena`;
CREATE VIEW vista_exogena AS
select `librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,
(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)),
`librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,
`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,
`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,
`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,
`librodiario`.`Tercero_DV` AS `Tercero_DV`,
`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,
`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,
`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,
`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,
`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,
`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,
`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,
`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,
`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,
`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,
round(sum(`librodiario`.`Debito`)) AS `Debitos`,round(sum(`librodiario`.`Credito`)) AS `Creditos` 
from `librodiario` where ((`librodiario`.`Fecha` >= '2017-01-01') and (`librodiario`.`Fecha` <= '2017-12-31'))
 group by `librodiario`.`CuentaPUC`,`librodiario`.`Tercero_Identificacion`;

DROP VIEW IF EXISTS `vista_exogena2`;
CREATE VIEW vista_exogena2 AS
select 
`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,
`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,
`librodiario`.`Tercero_DV` AS `Tercero_DV`,
`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,
`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,
`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,
`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,
`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,
`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,
`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,
`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,
`librodiario`.`Concepto` AS `Concepto`,SUBSTRING(`CuentaPUC`,1,4) AS `CuentaPUC`,
`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,
round(sum(`librodiario`.`Debito`)) AS `Debitos`,round(sum(`librodiario`.`Credito`)) AS `Creditos` 
from `librodiario` where ((`librodiario`.`Fecha` >= '2017-01-01') and (`librodiario`.`Fecha` <= '2017-12-31'))
 group by SUBSTRING(`CuentaPUC`,1,4),`librodiario`.`Tercero_Identificacion`;


DROP VIEW IF EXISTS `vista_notas_devolucion`;
CREATE VIEW vista_notas_devolucion AS
SELECT `ID`,`Fecha`,`Tercero`,`Concepto`,(SELECT SUM(SubtotalCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idNotaDevolucion = factura_compra_notas_devolucion.ID) as Subtotal,
(SELECT SUM(ImpuestoCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idNotaDevolucion = factura_compra_notas_devolucion.ID) as IVA,
(SELECT SUM(TotalCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idNotaDevolucion = factura_compra_notas_devolucion.ID) as Total,
`idCentroCostos`,`idSucursal`,`idUser`,`Estado`
FROM `factura_compra_notas_devolucion`;

DROP VIEW IF EXISTS `vista_totales_facturacion`;
CREATE VIEW vista_totales_facturacion AS
SELECT `FechaFactura`,SUM(`Cantidad`) as Items, round(sum(`SubtotalItem`)) as Subtotal, round(SUM(`IVAItem`)) AS IVA, round(SUM(`ValorOtrosImpuestos`)) AS OtrosImpuestos, 
round(SUM(`TotalItem`)) AS Total FROM `facturas_items` 
GROUP BY `FechaFactura` ;

DROP VIEW IF EXISTS `vista_diferencia_inventarios_selectivos`;
CREATE VIEW vista_diferencia_inventarios_selectivos AS
SELECT idProductosVenta,`Referencia`,`Nombre`,`Existencias` as ExistenciaAnterior,
(SELECT IFNULL((SELECT Cantidad FROM inventarios_conteo_selectivo WHERE productosventa.idProductosVenta = inventarios_conteo_selectivo.Referencia),0)) as ExistenciaActual,
(SELECT ExistenciaActual) - (Existencias) as Diferencia,PrecioVenta,CostoUnitario,
(SELECT Diferencia)*CostoUnitario AS TotalCostosDiferencia,Departamento,Sub1,Sub2,Sub3,Sub4,Sub5
  FROM `productosventa` 
WHERE (SELECT IFNULL((SELECT Cantidad FROM inventarios_conteo_selectivo WHERE productosventa.idProductosVenta = inventarios_conteo_selectivo.Referencia),0))>0;

DROP VIEW IF EXISTS `vista_pedidos_restaurante`;
CREATE VIEW vista_pedidos_restaurante AS
SELECT ID,`Fecha`,`Hora`,`Estado`,idMesa , idCliente,NombreCliente, DireccionEnvio,TelefonoConfirmacion, Observaciones,idCierre,
(SELECT SUM(Subtotal) as Subtotal FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as Subtotal,
(SELECT SUM(IVA) as IVA FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as IVA,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as Total,
idUsuario
FROM `restaurante_pedidos`;



DROP VIEW IF EXISTS `vista_cierres_restaurante`;
CREATE VIEW vista_cierres_restaurante AS
SELECT ID,`Fecha`,`Hora`,`idUsuario`,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idCierre=restaurante_cierres.ID and restaurante_pedidos_items.Estado='FAPE') as PedidosFacturados,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idCierre=restaurante_cierres.ID and restaurante_pedidos_items.Estado='DEPE') as PedidosDescartados,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idCierre=restaurante_cierres.ID and restaurante_pedidos_items.Estado='FADO') as DomiciliosFacturados,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idCierre=restaurante_cierres.ID and restaurante_pedidos_items.Estado='DEDO') as DomiciliosDescartados,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idCierre=restaurante_cierres.ID and restaurante_pedidos_items.Estado='FALL') as ParaLlevarFacturado,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idCierre=restaurante_cierres.ID and restaurante_pedidos_items.Estado='DELL') as ParaLlevarDescartado,
(SELECT SUM(Efectivo) as Total FROM restaurante_registro_propinas WHERE restaurante_registro_propinas.idCierre=restaurante_cierres.ID) as PropinasEfectivo,
(SELECT SUM(Tarjetas) as Total FROM restaurante_registro_propinas WHERE restaurante_registro_propinas.idCierre=restaurante_cierres.ID) as PropinasTarjetas

FROM `restaurante_cierres`;

DROP VIEW IF EXISTS `vista_libro_diario`;
CREATE VIEW vista_libro_diario AS
SELECT `idLibroDiario`,`Fecha`,`Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)), `librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`Num_Documento_Externo`,`Tercero_Tipo_Documento`,
`Tercero_Identificacion`,`Tercero_DV`,`Tercero_Primer_Apellido`,
`Tercero_Segundo_Apellido`,`Tercero_Primer_Nombre`,`Tercero_Otros_Nombres`,
`Tercero_Razon_Social`,`Tercero_Direccion`,`Tercero_Cod_Dpto`,`Tercero_Cod_Mcipio`,`Tercero_Pais_Domicilio`,
`Concepto`,`CuentaPUC`,`NombreCuenta`,`Detalle`,`Debito`,`Credito`,`Neto`,`idCentroCosto`,
`idEmpresa`,`idSucursal`,`Estado`,`idUsuario` FROM `librodiario`;



DROP VIEW IF EXISTS `vista_facturas_frecuentes`;
CREATE VIEW vista_facturas_frecuentes AS
SELECT ID,idCliente,Periodo,FacturaBase,UltimaFactura, Realizada,
(SELECT RazonSocial FROM clientes WHERE clientes.idClientes=facturas_frecuentes.idCliente) AS RazonSocial,
(SELECT Direccion FROM clientes WHERE clientes.idClientes=facturas_frecuentes.idCliente) AS Direccion,
(SELECT Fecha FROM facturas WHERE facturas.idFacturas=facturas_frecuentes.UltimaFactura) as UltimaFechaFacturacion,
(SELECT DATE_ADD((SELECT UltimaFechaFacturacion), INTERVAL (SELECT Periodo) MONTH )) AS ProximaFechaFacturacion,
(SELECT Fecha FROM acueducto_lecturas WHERE acueducto_lecturas.idCliente=facturas_frecuentes.idCliente ORDER BY acueducto_lecturas.ID DESC LIMIT 1) as FechaUltimaLectura,
(SELECT LecturaContador FROM acueducto_lecturas WHERE acueducto_lecturas.idCliente=facturas_frecuentes.idCliente ORDER BY acueducto_lecturas.ID DESC LIMIT 1) as UltimaLectura,
(SELECT Facturado FROM acueducto_lecturas WHERE acueducto_lecturas.idCliente=facturas_frecuentes.idCliente ORDER BY acueducto_lecturas.ID DESC LIMIT 1) as EstadoFacturadoUltimo,
(SELECT Fecha FROM acueducto_lecturas WHERE acueducto_lecturas.idCliente=facturas_frecuentes.idCliente ORDER BY acueducto_lecturas.ID DESC LIMIT 1,1) as FechaPenultimaLectura,
(SELECT LecturaContador FROM acueducto_lecturas WHERE acueducto_lecturas.idCliente=facturas_frecuentes.idCliente ORDER BY acueducto_lecturas.ID DESC LIMIT 1,1) as PenultimaLectura,
(SELECT Facturado FROM acueducto_lecturas WHERE acueducto_lecturas.idCliente=facturas_frecuentes.idCliente ORDER BY acueducto_lecturas.ID DESC LIMIT 1,1) as EstadoFacturadoPenultimo

FROM facturas_frecuentes WHERE Habilitado=1;


DROP VIEW IF EXISTS `vista_nomina_servicios_turnos`;
CREATE VIEW vista_nomina_servicios_turnos AS
SELECT *, (SELECT Nombre FROM empresa_pro_sucursales WHERE empresa_pro_sucursales.ID=nomina_servicios_turnos.Sucursal LIMIT 1) AS NombreSucursal,
(SELECT RazonSocial FROM proveedores WHERE proveedores.Num_Identificacion=nomina_servicios_turnos.Tercero LIMIT 1) AS NombreTercero
FROM nomina_servicios_turnos WHERE Estado<>'ANULADO';


DROP VIEW IF EXISTS `vista_balancextercero1`;
CREATE VIEW vista_balancextercero1 AS
SELECT `Tercero_Identificacion`,`Tercero_Razon_Social`,`CuentaPUC`,
SUM(`Debito`) AS Debitos,SUM(`Credito`) AS Creditos, (SUM(`Debito`)-SUM(`Credito`)) AS Neto FROM `librodiario` 
GROUP BY `Tercero_Identificacion` ORDER BY SUBSTRING(`CuentaPUC`,1,8);

DROP VIEW IF EXISTS `vista_balancextercero2`;
CREATE VIEW vista_balancextercero2 AS
SELECT `Tercero_Identificacion`,`Tercero_Razon_Social`,`CuentaPUC` as Cuenta,
SUM(`Debito`) AS Debitos,SUM(`Credito`) AS Creditos,(SUM(`Debito`)-SUM(`Credito`)) AS Neto FROM `librodiario`
WHERE Fecha>='2018-01-01' AND Fecha <='2018-12-31'
GROUP BY `Tercero_Identificacion` ORDER BY SUBSTRING(`CuentaPUC`,1,8) ;

DROP VIEW IF EXISTS `vista_retenciones`;
CREATE VIEW vista_retenciones AS
SELECT `idCompra`,
(SELECT Fecha FROM factura_compra WHERE ID=`idCompra`) AS Fecha,
(SELECT Tercero FROM factura_compra WHERE ID=`idCompra`) AS Tercero,
(SELECT Estado FROM factura_compra WHERE ID=`idCompra`) AS Estado,
(SELECT RazonSocial FROM proveedores WHERE Num_Identificacion=(SELECT Tercero) LIMIT 1) AS RazonSocial,
(SELECT DV FROM proveedores WHERE Num_Identificacion=(SELECT Tercero) LIMIT 1) AS DV,
(SELECT Direccion FROM proveedores WHERE Num_Identificacion=(SELECT Tercero) LIMIT 1) AS Direccion,
(SELECT Ciudad FROM proveedores WHERE Num_Identificacion=(SELECT Tercero) LIMIT 1) AS Ciudad,
`CuentaPUC`,`NombreCuenta` as Cuenta,
ValorRetencion,PorcentajeRetenido,ROUND(((ValorRetencion/PorcentajeRetenido)*100),2) AS BaseRetencion,
(SELECT idEmpresa FROM factura_compra WHERE ID=`idCompra`) AS idEmpresa,
(SELECT idCentroCostos FROM factura_compra WHERE ID=`idCompra`) AS idCentroCostos,
(SELECT idSucursal FROM factura_compra WHERE ID=`idCompra`) AS idSucursal
FROM factura_compra_retenciones;


DROP VIEW IF EXISTS `vista_inventario_separados`;
CREATE VIEW vista_inventario_separados AS
SELECT si.`ID`,si.`idSeparado` as idSeparado,`Referencia`,`Nombre`,si.ValorUnitarioItem,si.Cantidad,si.TotalItem,si.PrecioCostoUnitario,si.SubtotalCosto,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5` 
FROM `separados_items` si INNER JOIN separados s ON s.ID=si.`idSeparado` 
WHERE s.Estado='Abierto' ;

DROP VIEW IF EXISTS `vista_documentos_contables`;
CREATE VIEW vista_documentos_contables AS
SELECT  dcc.`ID`,dcc.`Fecha`,dc.`Prefijo` as Prefijo,dc.`Nombre` as Nombre,dcc.`Consecutivo`,dcc.`Descripcion`,dcc.Estado,dcc.idUser,dcc.`idDocumento`,dcc.`idEmpresa`,dcc.`idSucursal`,dcc.`idCentroCostos`
FROM `documentos_contables_control` dcc INNER JOIN documentos_contables dc ON dc.ID=dcc.`idDocumento`;

DROP VIEW IF EXISTS `vista_cuentasxterceros_v2`;
CREATE VIEW vista_cuentasxterceros_v2 AS
SELECT CuentaPUC,NombreCuenta,Tercero_Identificacion,Tercero_Razon_Social,SUM(Debito) as Debitos,SUM(Credito) as Creditos,SUM(Debito-Credito) AS Total
FROM librodiario GROUP BY Tercero_Identificacion,CuentaPUC;


DROP VIEW IF EXISTS `vista_cuentasxpagar_v2`;
CREATE VIEW vista_cuentasxpagar_v2 AS
SELECT *
FROM vista_cuentasxterceros_v2 t1 WHERE (t1.Total<-1 or t1.Total>1) AND EXISTS (SELECT 1 FROM contabilidad_parametros_cuentasxpagar as t2 WHERE t1.CuentaPUC LIKE t2.CuentaPUC) ORDER BY Total;

DROP VIEW IF EXISTS `vista_cuentasxtercerosdocumentos_v2`;
CREATE VIEW vista_cuentasxtercerosdocumentos_v2 AS
SELECT idLibroDiario AS ID,CuentaPUC,NombreCuenta,Tercero_Identificacion,Tercero_Razon_Social,Fecha,Num_Documento_Externo as NumeroDocumentoExterno,SUM(Debito) as Debitos,SUM(Credito) as Creditos,SUM(Debito-Credito) AS Total
FROM librodiario GROUP BY Tercero_Identificacion,CuentaPUC,Num_Documento_Externo;


DROP VIEW IF EXISTS `vista_cuentasxpagardetallado_v2`;
CREATE VIEW vista_cuentasxpagardetallado_v2 AS
SELECT *
FROM vista_cuentasxtercerosdocumentos_v2 t1 WHERE (t1.Total<-1 or t1.Total>1) AND EXISTS (SELECT 1 FROM contabilidad_parametros_cuentasxpagar as t2 WHERE t1.CuentaPUC LIKE t2.CuentaPUC) ORDER BY Fecha;


DROP VIEW IF EXISTS `vista_cuentasxcobrar`;
CREATE VIEW vista_cuentasxcobrar AS
SELECT *
FROM vista_cuentasxterceros_v2 t1 WHERE t1.Total<>0 AND EXISTS (SELECT 1 FROM contabilidad_parametros_cuentasxcobrar as t2 WHERE t1.CuentaPUC LIKE t2.CuentaPUC) ORDER BY Total DESC;

DROP VIEW IF EXISTS `vista_cuentasxcobrardetallado`;
CREATE VIEW vista_cuentasxcobrardetallado AS
SELECT *
FROM vista_cuentasxtercerosdocumentos_v2 t1 WHERE t1.Total<>0 AND EXISTS (SELECT 1 FROM contabilidad_parametros_cuentasxcobrar as t2 WHERE t1.CuentaPUC LIKE t2.CuentaPUC) ORDER BY Fecha;

DROP VIEW IF EXISTS `vista_pedidos_restaurante`;
CREATE VIEW vista_pedidos_restaurante AS
SELECT ID,`Fecha`,`Hora`,`Estado`,idMesa , idCliente,NombreCliente, DireccionEnvio,TelefonoConfirmacion, Observaciones,idCierre,
(SELECT SUM(Subtotal) as Subtotal FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as Subtotal,
(SELECT SUM(IVA) as IVA FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as IVA,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as Total,
(SELECT SUM(TotalCostos) FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as TotalCostos,
idUsuario
FROM `restaurante_pedidos`;

DROP VIEW IF EXISTS `vista_compras_productos`;
CREATE VIEW vista_compras_productos AS 
SELECT `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,
fi.idProducto AS idProducto,pv.Referencia AS Referencia,pv.Nombre AS Producto, pv.PrecioVenta,fi.Cantidad,fi.CostoUnitarioCompra AS CostoUnitario, fi.SubtotalCompra AS Subtotal,
fi.ImpuestoCompra AS Impuestos, fi.TotalCompra AS Total,fi.Tipo_Impuesto AS Tipo_Impuesto,

`pv`.`Departamento` AS `Departamento`,
`pv`.`Sub1` AS `Sub1`,
`pv`.`Sub2` AS `Sub2`,
`pv`.`Sub3` AS `Sub3`,
`pv`.`Sub4` AS `Sub4`,
`pv`.`Sub5` AS `Sub5`,
`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,
`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,
`c`.`idSucursal` AS `idSucursal`,c.Updated,c.Sync
FROM factura_compra c INNER JOIN proveedores t ON `c`.`Tercero` = `t`.`Num_Identificacion` 
INNER JOIN factura_compra_items fi ON fi.idFacturaCompra=c.ID INNER JOIN productosventa pv ON fi.idProducto=pv.idProductosVenta
WHERE c.`Estado`='CERRADA';


DROP VIEW IF EXISTS `vista_cierre_restaurante_pos2`;
CREATE VIEW vista_cierre_restaurante_pos2 AS
SELECT ID,`Fecha`,`Hora`,`Estado`,idMesa , idCliente,NombreCliente, DireccionEnvio,TelefonoConfirmacion, Observaciones,idCierre,
(SELECT SUM(Subtotal) as Subtotal FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as Subtotal,
(SELECT SUM(IVA) as IVA FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as IVA,
(SELECT SUM(Total) as Total FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as Total,
(SELECT SUM(TotalCostos) FROM restaurante_pedidos_items WHERE restaurante_pedidos_items.idPedido=restaurante_pedidos.ID) as TotalCostos,
idUsuario
FROM `restaurante_pedidos`;


DROP VIEW IF EXISTS `vista_servicio_acompanamiento_turno_actual`;
CREATE VIEW vista_servicio_acompanamiento_turno_actual AS
SELECT t1.idModelo,t2.NombreArtistico,count(t1.ID) as NumeroServicios, SUM(t1.ValorPagado) as ValorPagado, 
      SUM(t1.ValorModelo) as ValorModelo,SUM(t1.ValorCasa) as ValorCasa 
FROM modelos_agenda t1 INNER JOIN modelos_db t2 ON t1.idModelo=t2.ID WHERE t1.idCierre=0 GROUP BY t1.idModelo ORDER BY t2.NombreArtistico;


DROP VIEW IF EXISTS `vista_servicio_acompanamiento_cuentas_x_pagar`;
CREATE VIEW vista_servicio_acompanamiento_cuentas_x_pagar AS
SELECT t1.idModelo,
    (SELECT NombreArtistico FROM modelos_db t2 WHERE t2.ID=t1.idModelo LIMIT 1) AS NombreArtistico,
    (SELECT IFNULL((SELECT SUM(ValorModelo) FROM modelos_agenda t3 WHERE t3.idModelo=t1.idModelo),0)) AS ValorTotalServiciosPrestados,
    (SELECT IFNULL((SELECT SUM(ValorPagado) FROM modelos_pagos_realizados t4 WHERE t4.idModelo=t1.idModelo),0)) AS ValorTotalServiciosPagados,
    ((SELECT ValorTotalServiciosPrestados)-(SELECT ValorTotalServiciosPagados)) as Saldo
FROM modelos_agenda t1 GROUP BY t1.idModelo;

DROP VIEW IF EXISTS `vista_resumen_restaurante_turno_actual`;
CREATE VIEW vista_resumen_restaurante_turno_actual AS

    SELECT t1.idProductosVenta,t1.Nombre,
        (SELECT IFNULL((SELECT SUM(Cantidad) FROM factura_compra_items fci WHERE t1.idProductosVenta=fci.idProducto AND idCierre='0'),0)) AS ItemsCompras,
        (SELECT IFNULL((SELECT SUM(Cantidad) FROM facturas_items fi WHERE t1.Referencia=fi.Referencia AND idCierre='0'),0)) as ItemsVentas,
        (SELECT IFNULL((SELECT SUM(Cantidad) FROM traslados_items ti WHERE CONVERT(ti.Referencia USING utf8)=CONVERT(t1.Referencia USING utf8 ) AND Destino='$SedeActual' AND idCierre='0'),0)) as TrasladosRecibidos,
        (SELECT IFNULL((SELECT SUM(Cantidad) FROM traslados_items ti WHERE CONVERT(ti.Referencia USING utf8)=CONVERT(t1.Referencia USING utf8 ) AND Destino<>'$SedeActual' AND idCierre='0' AND Estado='PREPARADO'),0)) as TrasladosEnviados,
        (SELECT IFNULL((SELECT SUM(Cantidad) FROM inventario_comprobante_movimientos_items icm WHERE t1.idProductosVenta=icm.idProducto AND TablaOrigen='productosventa' AND TipoMovimiento='BAJA' AND idCierre='0'),0)) AS TotalBajas,
        (SELECT IFNULL((SELECT SUM(Cantidad) FROM inventario_comprobante_movimientos_items icm WHERE t1.idProductosVenta=icm.idProducto AND TablaOrigen='productosventa' AND TipoMovimiento='ALTA' AND idCierre='0'),0)) AS TotalAltas,
        (t1.Existencias - (SELECT ItemsCompras) + (SELECT TrasladosEnviados) - (SELECT TrasladosRecibidos) + (SELECT TotalBajas) - (SELECT TotalAltas) + (SELECT ItemsVentas)) AS CantidadRecibida, 
        (t1.Existencias) as SaldoFinal,
        (SELECT IFNULL((SELECT SUM(TotalItem) FROM facturas_items fi WHERE t1.Referencia=fi.Referencia AND idCierre='0'),0)) as TotalVentas,
        (t1.ValorComision1 * (SELECT ItemsVentas)) as TotalComisiones1,
        (t1.ValorComision2 * (SELECT ItemsVentas)) as TotalComisiones2,
        (t1.ValorComision3 * (SELECT ItemsVentas)) as TotalComisiones3,
        (t1.ValorComision4 * (SELECT ItemsVentas)) as TotalComisiones4,
        ((SELECT TotalVentas)-(SELECT TotalComisiones1)-(SELECT TotalComisiones2)-(SELECT TotalComisiones3)-(SELECT TotalComisiones4)) as TotalCasa

    FROM productosventa t1;


