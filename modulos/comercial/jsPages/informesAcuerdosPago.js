

document.getElementById("BtnMuestraMenuLateral").click();

/**
 * Busca un acuerdo de pago
 * @returns {undefined}
 */
function DibujeFormularioSegunTipoInforme(){
    var cmbTipoInforme=(document.getElementById('cmbTipoInforme').value);    
    var form_data = new FormData();
        
        form_data.append('Accion', cmbTipoInforme);
        
        $.ajax({
        url: './Consultas/informesAcuerdosPago.draw.php',
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



function FormularioAbonarAcuerdoPago(idAcuerdo){
    
    
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
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
            document.getElementById('DivBusquedasPOS').innerHTML=data;
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
    var TxtValorAbonoAcuerdoExistente=document.getElementById('TxtValorAbonoAcuerdoExistente').value;
    var TxtRecargosIntereses=document.getElementById('TxtRecargosIntereses').value;
    var CmbMetodoPagoAbonoAcuerdo=document.getElementById('CmbMetodoPagoAbonoAcuerdo').value;
    var form_data = new FormData();
        form_data.append('Accion', 2);        
        form_data.append('idAcuerdo', idAcuerdo);
        form_data.append('TxtValorAbonoAcuerdoExistente', TxtValorAbonoAcuerdoExistente);
        form_data.append('CmbMetodoPagoAbonoAcuerdo', CmbMetodoPagoAbonoAcuerdo);
        form_data.append('TxtRecargosIntereses', TxtRecargosIntereses);
        
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
                DibujeHistorialDeCuotas(idAcuerdo);
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
    var form_data = new FormData();
        form_data.append('Accion', 4);        
        form_data.append('idCuota', idCuota);
        form_data.append('ValorAbono', value);  
        form_data.append('MetodoPago', CmbMetodoPagoAbonoAcuerdo); 
        form_data.append('TotalAbono', TotalAbono); 
        form_data.append('TxtRecargosIntereses', TxtRecargosIntereses); 
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
                document.getElementById("TxtValorAbonoAcuerdoExistente").value=TotalAbono-value;
                document.getElementById("TxtRecargosIntereses").value=0;
                alertify.success(respuesta[1]);
                DibujeHistorialDeCuotas(idAcuerdo);
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

function DibujarAcuerdoPagoExistente(idAcuerdo,idDiv='DivHistorialAcuerdoPago'){
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


DibujeFormularioSegunTipoInforme();