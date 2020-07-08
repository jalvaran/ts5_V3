var TotalAbonoAcuerdo=0;

/**
 * Busca un acuerdo de pago
 * @returns {undefined}
 */
function BuscarAcuerdo(){
    var TxtBuscarAcuerdo=(document.getElementById('TxtBuscarAcuerdo').value);    
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('TxtBuscarAcuerdo', TxtBuscarAcuerdo);
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivBusquedasPOS').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  


function ImprimirAcuerdoPago(idAcuerdo){
    
    var form_data = new FormData();
        form_data.append('Accion', 1);        
        form_data.append('idAcuerdo', idAcuerdo);
        
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}



function FormularioAbonarAcuerdoPago(idAcuerdo,divDraw='DivBusquedasPOS',Invoca=0){
    
    if(Invoca==1){//Si la funcion está siendo invocada desde la devolucion de un producto
        var idItemDevolucion=document.getElementById('idItemDevolucionAcuerdo').value;
        var CantidadDevolucion=document.getElementById('Cantidad_Devolucion_Acuerdo_Pago').value;
        
    }
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('idAcuerdo', idAcuerdo);
        form_data.append('Invoca', Invoca);
        if(Invoca==1){
            form_data.append('idItemDevolucion', idItemDevolucion);
            form_data.append('CantidadDevolucion', CantidadDevolucion);
            
        }
        
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(divDraw).innerHTML=data;
            Number_Format_Input();
            DibujeHistorialDeCuotas(idAcuerdo);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

function DibujeHistorialDeCuotas(idAcuerdo){
    
    
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('idAcuerdo', idAcuerdo);
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivHistorialPagosAcuerdo').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  


function ConfirmarAbonoAcuerdoPago(idAcuerdo){
    document.getElementById("BtnGuardarAbonoAcuerdo").disabled=true;
    alertify.confirm('Desea Registrar este abono? ',
        function (e) {
            if (e) {
                
                AbonarAcuerdoPago(idAcuerdo);
            }else{
                alertify.error("Se canceló el proceso");
                document.getElementById("BtnGuardarAbonoAcuerdo").disabled=false;
                return;
            }
        });
}


function AbonarAcuerdoPago(idAcuerdo){
    document.getElementById("BtnGuardarAbonoAcuerdo").disabled=true;
    var idItemDevolucionAcuerdo="";
    var Cantidad_Devolucion_Acuerdo_Pago="";
    var TxtObservacionesDevolucion="";
    if($("#idItemDevolucionAcuerdo").length>0){
        idItemDevolucionAcuerdo=document.getElementById("idItemDevolucionAcuerdo").value;
        Cantidad_Devolucion_Acuerdo_Pago=document.getElementById("Cantidad_Devolucion_Acuerdo_Pago").value;
        TxtObservacionesDevolucion=document.getElementById("TxtObservacionesDevolucion").value;
    }
    var TxtValorAbonoAcuerdoExistente=document.getElementById('TxtValorAbonoAcuerdoExistente').value;
    var TxtRecargosIntereses=document.getElementById('TxtRecargosIntereses').value;
    var CmbMetodoPagoAbonoAcuerdo=document.getElementById('CmbMetodoPagoAbonoAcuerdo').value;
    var form_data = new FormData();
        form_data.append('Accion', 2);        
        form_data.append('idAcuerdo', idAcuerdo);
        form_data.append('TxtValorAbonoAcuerdoExistente', TxtValorAbonoAcuerdoExistente);
        form_data.append('CmbMetodoPagoAbonoAcuerdo', CmbMetodoPagoAbonoAcuerdo);
        form_data.append('TxtRecargosIntereses', TxtRecargosIntereses);
        form_data.append('idItemDevolucionAcuerdo', idItemDevolucionAcuerdo);
        form_data.append('Cantidad_Devolucion_Acuerdo_Pago', Cantidad_Devolucion_Acuerdo_Pago);
        form_data.append('TxtObservacionesDevolucion', TxtObservacionesDevolucion);
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                document.getElementById('TxtValorAbonoAcuerdoExistente').value=0;
                document.getElementById('TxtRecargosIntereses').value=0;
                document.getElementById('TxtValorAbonoAcuerdoExistente_Format_Number').value=0;
                document.getElementById('TxtRecargosIntereses_Format_Number').value=0;
                try{
                    DibujeListadoSegunTipo();
                }catch(err) {
                    console.log(err.message);
                }
                try{
                    DibujeHistorialDeCuotas(idAcuerdo);
                }catch(err) {
                    console.log(err.message);
                }
                
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
            document.getElementById("BtnGuardarAbonoAcuerdo").disabled=false;           
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            document.getElementById("BtnGuardarAbonoAcuerdo").disabled=false;
          }
      });
}


function AbonarCuotaAcuerdoIndividual(idAcuerdo,idCuota){
    
    var form_data = new FormData();
        form_data.append('Accion', 3);        
        form_data.append('idCuota', idCuota);
                
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuesta= data.split(';'); 
            if(respuesta[0]=='OK'){
                PregunteValorCuota(idAcuerdo,idCuota,respuesta);
            }else if(respuesta[0]=='E1'){
                alertify.error(respuesta[1]);
            }else{
                alertify.alert(data);
            }
            
                           
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            
          }
      });
}


function PregunteValorCuota(idAcuerdo,idCuota,DatosCuota){
    
    alertify.prompt('Digite el valor del abono para la cuota del '+ DatosCuota[2]+':',
    
    function(evt, value) { 
        if(value==undefined){
            alertify.error("Accion cancelada");
        }else{
            RegistrePagoCuotaIndividual(idAcuerdo,idCuota,value);
            
        }
         },(DatosCuota[5])
            
            
    );

}


function RegistrePagoCuotaIndividual(idAcuerdo,idCuota,value){
    var TotalAbono=document.getElementById("TxtValorAbonoAcuerdoExistente").value;
    var TxtRecargosIntereses=document.getElementById("TxtRecargosIntereses").value;
    var CmbMetodoPagoAbonoAcuerdo=document.getElementById("CmbMetodoPagoAbonoAcuerdo").value;
    var idItemDevolucionAcuerdo="";
    var Cantidad_Devolucion_Acuerdo_Pago="";
    var TxtObservacionesDevolucion="";
    if($("#idItemDevolucionAcuerdo").length>0){
        idItemDevolucionAcuerdo=document.getElementById("idItemDevolucionAcuerdo").value;
        Cantidad_Devolucion_Acuerdo_Pago=document.getElementById("Cantidad_Devolucion_Acuerdo_Pago").value;
        TxtObservacionesDevolucion=document.getElementById("TxtObservacionesDevolucion").value;
    }
    var form_data = new FormData();
        form_data.append('Accion', 4);        
        form_data.append('idCuota', idCuota);
        form_data.append('ValorAbono', value);  
        form_data.append('MetodoPago', CmbMetodoPagoAbonoAcuerdo); 
        form_data.append('TotalAbono', TotalAbono); 
        form_data.append('TxtRecargosIntereses', TxtRecargosIntereses); 
        form_data.append('idItemDevolucionAcuerdo', idItemDevolucionAcuerdo); 
        form_data.append('Cantidad_Devolucion_Acuerdo_Pago', Cantidad_Devolucion_Acuerdo_Pago); 
        form_data.append('TxtObservacionesDevolucion', TxtObservacionesDevolucion); 
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuesta= data.split(';'); 
            if(respuesta[0]=='OK'){
                var SaldoAbono=TotalAbono-value;
                document.getElementById("TxtValorAbonoAcuerdoExistente").value=SaldoAbono;
                document.getElementById("TxtValorAbonoAcuerdoExistente_Format_Number").value=number_format(SaldoAbono);
                document.getElementById("TxtRecargosIntereses").value=0;
                alertify.success(respuesta[1]);
                try{
                    DibujeListadoSegunTipo();
                }catch(err) {
                    console.log(err.message);
                }
                try{
                    DibujeHistorialDeCuotas(idAcuerdo);
                }catch(err) {
                    console.log(err.message);
                }
                
            }else if(respuesta[0]=='E1'){
                alertify.alert(respuesta[1]);
            }else{
                alertify.alert(data);
            }
            
                           
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            
          }
      });
}

function DibujarAcuerdoPagoExistente(idAcuerdo,idDiv='DivHistorialAcuerdoPago',idModal=""){
    if(idModal != ''){
        
        $("#"+idModal).modal();
    }
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        form_data.append('idAcuerdo', idAcuerdo);
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}



function SubirFoto(idAcuerdoPago=""){
    if(idAcuerdoPago==""){
        var idAcuerdoPago=document.getElementById("idAcuerdoPago").value;
    }
    var form_data = new FormData();
        form_data.append('Accion', 5);        
        form_data.append('idAcuerdoPago', idAcuerdoPago);
        form_data.append('upFoto', $('#upFoto').prop('files')[0]);
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            
            if(respuestas[0]=="E1"){
                
                alertify.alert(respuestas[1]);
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
            }else{
                alertify.alert(data);
            }
                        
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function DibujarFormularioDatosAdicionalesCliente(idCliente='',idDiv=""){
    if(idCliente==''){
        var idCliente = document.getElementById('idCliente').value;   
    }
     
    var idCliente=document.getElementById('idCliente').value;
        
    var form_data = new FormData();
        form_data.append('Accion', 5);        
        form_data.append('idCliente', idCliente);
                
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}



function MarqueErrorElemento(idElemento){
    console.log(idElemento);
    if(idElemento==undefined){
       return; 
    }
    document.getElementById(idElemento).style.backgroundColor="pink";
    document.getElementById(idElemento).focus();
}

function GuardarDatosAdicionalesCliente(idCliente){    
    var idBoton='BtnGuardarDatosAdicionalesCliente';
    document.getElementById(idBoton).disabled=true;
    var SobreNombre=document.getElementById('SobreNombre').value;
    var LugarTrabajo=document.getElementById('LugarTrabajo').value;        
    var Cargo = document.getElementById('Cargo').value;    
    var DireccionTrabajo = document.getElementById('DireccionTrabajo').value; 
    var TelefonoTrabajo = document.getElementById('TelefonoTrabajo').value;  
    var TxtFacebook = document.getElementById('TxtFacebook').value;  
    var TxtInstagram = document.getElementById('TxtInstagram').value;  
       
    var form_data = new FormData();
        
        form_data.append('Accion', 6);
        form_data.append('idCliente', idCliente);        
        form_data.append('SobreNombre', SobreNombre);
        form_data.append('LugarTrabajo', LugarTrabajo);
        form_data.append('Cargo', Cargo);
        form_data.append('DireccionTrabajo', DireccionTrabajo);
        form_data.append('TelefonoTrabajo', TelefonoTrabajo);
        form_data.append('TxtFacebook', TxtFacebook);
        form_data.append('TxtInstagram', TxtInstagram);
        
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
                MarqueErrorElemento(respuestas[2]);
                
            }else{
                alertify.alert(data);
            }
               
            document.getElementById(idBoton).disabled=false;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  



function DibujarFormularioRecomendadosCliente(idCliente='',idDiv=""){
    if(idCliente==''){
        var idCliente = document.getElementById('idCliente').value;   
    }
     
    var idCliente=document.getElementById('idCliente').value;
        
    var form_data = new FormData();
        form_data.append('Accion', 6);        
        form_data.append('idCliente', idCliente);
                
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            DibujeRecomendadosCliente(idCliente);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


function GuardarRecomendadosCliente(idCliente){    
    var idBoton='BtnGuardarRecomendadosCliente';
    document.getElementById(idBoton).disabled=true;
    var NombreRecomendado=document.getElementById('NombreRecomendado').value;
    var DireccionRecomendado=document.getElementById('DireccionRecomendado').value;        
    var TelefonoRecomendado = document.getElementById('TelefonoRecomendado').value;    
    var DireccionTrabajoRecomendado = document.getElementById('DireccionTrabajoRecomendado').value; 
    var TelefonoTrabajoRecomendado = document.getElementById('TelefonoTrabajoRecomendado').value;  
       
    var form_data = new FormData();
        
        form_data.append('Accion', 7);
        form_data.append('idCliente', idCliente);        
        form_data.append('NombreRecomendado', NombreRecomendado);
        form_data.append('DireccionRecomendado', DireccionRecomendado);
        form_data.append('TelefonoRecomendado', TelefonoRecomendado);
        form_data.append('DireccionTrabajoRecomendado', DireccionTrabajoRecomendado);
        form_data.append('TelefonoTrabajoRecomendado', TelefonoTrabajoRecomendado);
                
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                LimpiarFormularioRecomendos();
                DibujeRecomendadosCliente(idCliente);
                document.getElementById(idBoton).disabled=false;
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
                MarqueErrorElemento(respuestas[2]);
                
            }else{
                alertify.alert(data);
            }
               
            document.getElementById(idBoton).disabled=false;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

function LimpiarFormularioRecomendos(){
    document.getElementById('NombreRecomendado').value='';
    document.getElementById('DireccionRecomendado').value='';        
    document.getElementById('TelefonoRecomendado').value='';    
    document.getElementById('DireccionTrabajoRecomendado').value=''; 
    document.getElementById('TelefonoTrabajoRecomendado').value='';  
}

function DibujeRecomendadosCliente(idCliente='',idDiv="DivRecomendadosExistentes"){
    if(idCliente==''){
        var idCliente = document.getElementById('idCliente').value;   
    }
     
    var idCliente=document.getElementById('idCliente').value;
        
    var form_data = new FormData();
        form_data.append('Accion', 7);        
        form_data.append('idCliente', idCliente);
                
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}

function SumaRestaDiferenciaCuota(idCaja){
    var Diferencia = document.getElementById('TxtDiferenciaCuotasAcuerdo').value;
    var CuotaActual = document.getElementById(idCaja).value;
    var TotalCuota=parseInt(CuotaActual)+parseInt(Diferencia);
    document.getElementById(idCaja).value=TotalCuota;
    document.getElementById(idCaja+"_Format_Number").value=number_format(TotalCuota);
    
}

function DibujeFormularioAcuerdoPago(idPreventa="",idDiv='DivAcuerdoPago'){
    if(idPreventa==""){
        var idPreventa = document.getElementById('idPreventa').value;
    }
    var idCliente=document.getElementById('idCliente').value;
    var form_data = new FormData();
        form_data.append('Accion', 15);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            
            Number_Format_Input();
            
            VisualizarTotalesAcuerdo();
            inicieVideo();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


function AgregarCuotaInicialAcuerdoPago(idAcuerdoPago){    
    var idBoton='btnAgregarCuotaInicialAcuerdo';
    document.getElementById(idBoton).disabled=true;
    var CuotaInicialAcuerdo=document.getElementById('CuotaInicialAcuerdo').value;
    var metodoPagoCuotaInicial=document.getElementById('metodoPagoCuotaInicial').value; 
    var idPreventa='NA';
    if($("#idPreventa").length){
        var idPreventa = document.getElementById('idPreventa').value;    
    }
    
    var idCliente = document.getElementById('idCliente').value;    
       
    var form_data = new FormData();
        
        form_data.append('Accion', 25);
        form_data.append('idAcuerdoPago', idAcuerdoPago);
        form_data.append('TipoCuota', 1);
        form_data.append('ValorPago', CuotaInicialAcuerdo);
        form_data.append('MetodoPago', metodoPagoCuotaInicial);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                CalculeProyeccionPagosAcuerdo();
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                MarqueErrorElemento(respuestas[2]);
            }else{
                alertify.alert(data);
            }
               
            document.getElementById(idBoton).disabled=false;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  



function AgregarCuotaProgramadaAcuerdoPagoTemporal(idAcuerdoPago){    
    var idBoton='btnAgregarCuotaProgramada';
    document.getElementById(idBoton).disabled=true;
    var CuotaProgramadaAcuerdo=document.getElementById('CuotaProgramadaAcuerdo').value;
    var TxtFechaCuotaProgramada=document.getElementById('TxtFechaCuotaProgramada').value; 
    var idPreventa='NA';
    if($("#idPreventa").length){
        var idPreventa = document.getElementById('idPreventa').value;    
    }
    
    var idCliente = document.getElementById('idCliente').value;    
       
    var form_data = new FormData();
        
        form_data.append('Accion', 27);
        form_data.append('idAcuerdoPago', idAcuerdoPago);
        form_data.append('TipoCuota', 1);
        form_data.append('CuotaProgramadaAcuerdo', CuotaProgramadaAcuerdo);
        form_data.append('TxtFechaCuotaProgramada', TxtFechaCuotaProgramada);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';');
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                CalculeProyeccionPagosAcuerdo();
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                MarqueErrorElemento(respuestas[2]);
            }else{
                alertify.alert(data);
            }
               
            document.getElementById(idBoton).disabled=false;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  



function CalculeProyeccionPagosAcuerdo(idAcuerdo=''){
    if(idAcuerdo==''){
        var idAcuerdo = document.getElementById('idAcuerdoPago').value;   
    }
     
    var idCliente=document.getElementById('idCliente').value;
    var idPreventa='NA';
    if($("#idPreventa").length){
        var idPreventa = document.getElementById('idPreventa').value;    
    }
    var TxtFechaInicialPagos=document.getElementById('TxtFechaInicialPagos').value;
    var ValorCuotaAcuerdo=document.getElementById('ValorCuotaAcuerdo').value;
    var CuotaProgramadaAcuerdo=document.getElementById('CuotaProgramadaAcuerdo').value;
    var TxtFechaCuotaProgramada=document.getElementById('TxtFechaCuotaProgramada').value;
    var NumeroCuotas=document.getElementById('NumeroCuotas').value;
    var cicloPagos=document.getElementById('cicloPagos').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 16);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);
        form_data.append('idAcuerdo', idAcuerdo);
        form_data.append('TxtFechaInicialPagos', TxtFechaInicialPagos);
        form_data.append('ValorCuotaAcuerdo', ValorCuotaAcuerdo);
        form_data.append('CuotaProgramadaAcuerdo', CuotaProgramadaAcuerdo);
        form_data.append('TxtFechaCuotaProgramada', TxtFechaCuotaProgramada);
        form_data.append('NumeroCuotas', NumeroCuotas);
        form_data.append('cicloPagos', cicloPagos);
        
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivProyeccionPagosAcuerdo').innerHTML=data;
            Number_Format_Input();
            VisualizarTotalesAcuerdo();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}

function EliminarItemAcuerdo(Tabla,idItem){
    var idCliente=document.getElementById('idCliente').value; 
    
    var form_data = new FormData();
        form_data.append('Accion', 26);        
        form_data.append('Tabla', Tabla);
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                alertify.error(respuestas[1]);
                if(Tabla == 3){
                    DibujeRecomendadosCliente(idCliente);
                }
            }
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }
            if(Tabla != 3){
                CalculeProyeccionPagosAcuerdo();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function CalculeValorCuotaAcuerdo(idAcuerdo=''){
    
    if(idAcuerdo==''){
        var idAcuerdo = document.getElementById('idAcuerdoPago').value;   
    }   
    var idCliente = document.getElementById('idCliente').value; 
    var idPreventa='NA';
    if($("#idPreventa").length){
        var idPreventa = document.getElementById('idPreventa').value;    
    } 
    var NumeroCuotas = document.getElementById('NumeroCuotas').value;   
    var form_data = new FormData();
        form_data.append('Accion', 28);        
        form_data.append('idAcuerdo', idAcuerdo);
        form_data.append('NumeroCuotas', NumeroCuotas);
        form_data.append('idCliente', idCliente);
        form_data.append('idPreventa', idPreventa);
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                 document.getElementById('ValorCuotaAcuerdo').value=respuestas[2];
                 
                 document.getElementById('ValorCuotaAcuerdo_Format_Number').value=number_format(respuestas[2],2);
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function TomarFoto(idAcuerdo='') {
    if(idAcuerdo==''){
        var idAcuerdo = document.getElementById('idAcuerdoPago').value;   
    }
    document.querySelector("#video").pause();
    
    //Obtener contexto del canvas y dibujar sobre él
    let contexto = document.querySelector("#canvas").getContext("2d");
    document.querySelector("#canvas").width = document.querySelector("#video").videoWidth;
    document.querySelector("#canvas").height = document.querySelector("#video").videoHeight;
    contexto.drawImage(document.querySelector("#video"), 0, 0, document.querySelector("#canvas").width, document.querySelector("#canvas").height);

    let foto = document.querySelector("#canvas").toDataURL(); //Esta es la foto, en base 64
    document.querySelector("#estado").innerHTML = "Enviando foto. Por favor, espera...";
    
    var form_data = new FormData();
        form_data.append('Opcion', 1); 
        form_data.append('idAcuerdo', idAcuerdo);      
        form_data.append('foto', foto);
        
        $.ajax({
        url: './procesadores/webcam.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.querySelector("#estado").innerHTML = data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    //Reanudar reproducción
    document.querySelector("#video").play();
};


function EditarCuotaTemporal(idItem){
    var ValorCuota = document.getElementById('TxtValorCuotaNormal_'+idItem).value;        
    var form_data = new FormData();
        form_data.append('Accion', 29);        
        form_data.append('ValorCuota', ValorCuota);
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                VisualizarTotalesAcuerdo();
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function VisualizarTotalesAcuerdo(idAcuerdo=''){
    if(idAcuerdo==''){
        var idAcuerdo = document.getElementById('idAcuerdoPago').value;   
    }
    var DivDraw = "DivAcuerdoFlotanteTotales";
    var idCliente=document.getElementById('idCliente').value;
    var idPreventa='NA';
    if(document.getElementById('idPreventa')){
        var idPreventa=document.getElementById('idPreventa').value;
    }
    
        
    var form_data = new FormData();
        form_data.append('Accion', 17);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);
        form_data.append('idAcuerdo', idAcuerdo);
                
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(DivDraw).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


function AccionesPOS(){
    
    var idFormulario=document.getElementById('idFormulario').value; //determina el tipo de formulario que se va a guardar
    
    if(idFormulario==103){
        var idTercero=document.getElementById("idTercero").value;
        EditarTercero('ModalAccionesPOS','BntModalPOS',idTercero,'clientes');
    }
}

function GuardarAcuerdoPagoAdmin(idAcuerdo){
    
    var idCliente = (document.getElementById('idCliente').value);
    var idAcuerdoPago = (document.getElementById('idAcuerdoPago').value);
    var TxtFechaInicialPagos = (document.getElementById('TxtFechaInicialPagos').value);
    var ValorCuotaAcuerdo = (document.getElementById('ValorCuotaAcuerdo').value);
    var cicloPagos = (document.getElementById('cicloPagos').value);
    var SaldoActualAcuerdoPago = (document.getElementById('SaldoActualAcuerdoPago').value);
    var NuevoSaldoAcuerdoPago = (document.getElementById('NuevoSaldoAcuerdoPago').value);
    var TxtObservacionesAcuerdoPago = (document.getElementById('TxtObservacionesAcuerdoPago').value);
    var idPreventa='NA';
    
    var form_data = new FormData();
        form_data.append('Accion', 30);  
        form_data.append('idCliente', idCliente);
        form_data.append('idAcuerdoPago', idAcuerdoPago);
        form_data.append('TxtFechaInicialPagos', TxtFechaInicialPagos);
        form_data.append('ValorCuotaAcuerdo', ValorCuotaAcuerdo);
        form_data.append('cicloPagos', cicloPagos);
        form_data.append('SaldoActualAcuerdoPago', SaldoActualAcuerdoPago);
        form_data.append('NuevoSaldoAcuerdoPago', NuevoSaldoAcuerdoPago);
        form_data.append('TxtObservacionesAcuerdoPago', TxtObservacionesAcuerdoPago);
        form_data.append('idPreventa', idPreventa);
        
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                alertify.alert(respuestas[1]);
                DibujeListadoSegunTipo();
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

