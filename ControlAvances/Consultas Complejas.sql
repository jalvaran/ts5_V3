SELECT Fecha,Tipo_Documento_Intero,Num_Documento_Interno,Num_Documento_Externo,
Tercero_Identificacion,Tercero_Razon_Social,CuentaPUC, NombreCuenta,
@SaldoInicial as SaldoInicialCuenta,
Debito AS Debitos,Credito AS Creditos, ( ((SELECT Debitos) - (SELECT Creditos)) ) as Saldo,
 @SaldoFinal := @SaldoFinal + (SELECT Saldo) AS SaldoFinalCuenta,
@SaldoInicial := @SaldoInicial+(SELECT Saldo)

FROM librodiario JOIN (SELECT @SaldoFinal:=0) tb2 
JOIN (SELECT @SaldoInicial:=(SELECT SUM(Debito-Credito) FROM librodiario WHERE Fecha < '2019-09-01' AND CuentaPUC like '5105%')) tb3 
WHERE Fecha>='2019-01-01' AND Fecha<='2019-09-01' AND CuentaPUC like '5105%' ORDER BY Fecha ;