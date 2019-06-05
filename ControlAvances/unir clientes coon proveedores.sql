INSERT INTO `proveedores`( `Tipo_Documento`, `Num_Identificacion`, `DV`, `Primer_Apellido`, `Segundo_Apellido`, `Primer_Nombre`, `Otros_Nombres`, `RazonSocial`, `Direccion`, `Cod_Dpto`, `Cod_Mcipio`, `Pais_Domicilio`, `Telefono`, `Ciudad`) 
SELECT `Tipo_Documento`, `Num_Identificacion`, `DV`, `Primer_Apellido`, `Segundo_Apellido`, `Primer_Nombre`, `Otros_Nombres`, `RazonSocial`, `Direccion`, `Cod_Dpto`, `Cod_Mcipio`, `Pais_Domicilio`, `Telefono`, `Ciudad`FROM clientes t2 
WHERE NOT EXISTS (SELECT 1 FROM proveedores WHERE t2.Num_Identificacion=proveedores.Num_Identificacion);

INSERT INTO `clientes`( `Tipo_Documento`, `Num_Identificacion`, `DV`, `Primer_Apellido`, `Segundo_Apellido`, `Primer_Nombre`, `Otros_Nombres`, `RazonSocial`, `Direccion`, `Cod_Dpto`, `Cod_Mcipio`, `Pais_Domicilio`, `Telefono`, `Ciudad`) 
SELECT `Tipo_Documento`, `Num_Identificacion`, `DV`, `Primer_Apellido`, `Segundo_Apellido`, `Primer_Nombre`, `Otros_Nombres`, `RazonSocial`, `Direccion`, `Cod_Dpto`, `Cod_Mcipio`, `Pais_Domicilio`, `Telefono`, `Ciudad`FROM proveedores t2 
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE t2.Num_Identificacion=clientes.Num_Identificacion);

