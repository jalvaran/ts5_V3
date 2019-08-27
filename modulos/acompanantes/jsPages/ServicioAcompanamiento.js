/**
 * Controlador para realizar las compras
 * JULIAN ALVARAN 2018-12-05
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
function startTime() {
    var today = new Date();
    
    var hr  = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    //Add a zero in front of numbers<10
    min = checkTime(min);
    sec = checkTime(sec);
    var HoraActual=hr + ":" + min + ":" + sec;
    //document.getElementById("clock").innerHTML = HoraActual;
    var Shapes=document.getElementsByName("Shape");
    var HoraFin=document.getElementsByName("PHoraIni");
    
    for (i = 0; i < Shapes.length; i++) {
        var FechaFin = new Date(HoraFin[i].innerHTML);
        if(FechaFin<today){
            Shapes[i].style.backgroundColor = "red";
            Shapes[i].style.color = "red";
            HoraFin[i].style.color = "red";
        }
        
       
    }
    
    var time = setTimeout(function(){ startTime() }, 500);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

startTime();


function CierraModal(idModal) {
    $("#"+idModal).modal('hide');//ocultamos el modal
    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}

function ObtengaValorServicio(){
    var CmbTipoServicio=document.getElementById('CmbTipoServicio').value;     
    var form_data = new FormData();
        form_data.append('Accion', 1);
        form_data.append('CmbTipoServicio', CmbTipoServicio);
        
        $.ajax({
        url: './procesadores/ServicioAcompanamiento.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=='OK'){
                document.getElementById('ValorServicio').value=respuestas[1];
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

function AgregarServicio(){
    document.getElementById('BtnAgregarServicio').disabled=true;
    document.getElementById('BtnAgregarServicio').value="Agregando...";
    var CmbTipoServicio=document.getElementById('CmbTipoServicio').value;     
    var CmbModelo=document.getElementById('CmbModelo').value;     
    var ValorServicio=document.getElementById('ValorServicio').value;     
    var form_data = new FormData();
        form_data.append('Accion', 2);
        form_data.append('CmbTipoServicio', CmbTipoServicio);
        form_data.append('CmbModelo', CmbModelo);
        form_data.append('ValorServicio', ValorServicio);
        
        $.ajax({
        url: './procesadores/ServicioAcompanamiento.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=='OK'){
                alertify.success(respuestas[1]);
                document.getElementById('BtnAgregarServicio').disabled=false;
                document.getElementById('BtnAgregarServicio').value="Agregar";
                document.getElementById('CmbTipoServicio').value="";
                document.getElementById('ValorServicio').value="";
                DibujeServicios();
            }else if(respuestas[0]=='E1'){
                alertify.alert(respuestas[1]);
                document.getElementById('BtnAgregarServicio').disabled=false;
                document.getElementById('BtnAgregarServicio').value="Agregar";
            }else{
                alertify.alert(data);
                document.getElementById('BtnAgregarServicio').disabled=false;
                document.getElementById('BtnAgregarServicio').value="Agregar";
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById('BtnAgregarServicio').disabled=false;
            document.getElementById('BtnAgregarServicio').value="Agregar";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function DibujeServicios(){
       
    var form_data = new FormData();
        form_data.append('Accion', 1);
        
        $.ajax({
        url: './Consultas/ServicioAcompanamiento.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            document.getElementById('DivServicios').innerHTML=data;                        
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function DibujeResumenTurno(){
       
    var form_data = new FormData();
        form_data.append('Accion', 2);
        
        $.ajax({
        url: './Consultas/ServicioAcompanamiento.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            document.getElementById('DivResumenTurno').innerHTML=data;                        
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function DibujeCuentasXPagarServicios(){
    
    document.getElementById("DivCuentasXPagar").innerHTML='<div id="GifProcess"><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 3);
        
        $.ajax({
        url: './Consultas/ServicioAcompanamiento.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            document.getElementById('DivCuentasXPagar').innerHTML=data;                        
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function FormularioPagarModelo(idModelo){
    $("#ModalAcciones").modal();
    document.getElementById('BntModalAcciones').style.display = 'none';
    var form_data = new FormData();
        form_data.append('Accion', 4);
        form_data.append('idModelo', idModelo);
        
        $.ajax({
        url: './Consultas/ServicioAcompanamiento.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            document.getElementById('DivFrmModalAcciones').innerHTML=data; 
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

DibujeServicios();

function TerminarServicio(idServicio){
    
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('idServicio', idServicio);
        
        $.ajax({
        url: './procesadores/ServicioAcompanamiento.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=='OK'){
                alertify.success(respuestas[1]);
                DibujeServicios();
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

function PagarAModelo(idModelo){
    document.getElementById('btnPagar').disabled=true;
    document.getElementById('btnPagar').value="Pagando...";
    
    var TxtValorPago=document.getElementById('TxtValorPago').value;     
    var form_data = new FormData();
        form_data.append('Accion', 4);
        form_data.append('TxtValorPago', TxtValorPago);
        form_data.append('idModelo', idModelo);
                
        $.ajax({
        url: './procesadores/ServicioAcompanamiento.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=='OK'){
                alertify.success(respuestas[1]);
                document.getElementById('btnPagar').disabled=false;
                document.getElementById('btnPagar').value="Pagar";                
                DibujeCuentasXPagarServicios();
                CierraModal('ModalAcciones');
            }else if(respuestas[0]=='E1'){
                alertify.alert(respuestas[1]);
                document.getElementById('btnPagar').disabled=false;
                document.getElementById('btnPagar').value="Pagar";
            }else{
                alertify.alert(data);
                document.getElementById('btnPagar').disabled=false;
                document.getElementById('btnPagar').value="Pagar";
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById('btnPagar').disabled=false;
            document.getElementById('btnPagar').value="Pagar";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

document.getElementById('BtnMuestraMenuLateral').click();

$('#CmbModelo').select2({
		  
    placeholder: 'Selecciona una modelo',
    ajax: {
      url: 'buscadores/modelos.search.php',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {

        return {                     
          results: data
        };
      },
     cache: true
    }
  });
  