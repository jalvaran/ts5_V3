/**
 * Controlador para realizar la administracion de los tickets
 * JULIAN ALVARAN 2019-05-20
 * TECHNO SOLUCIONES SAS 
 * 
 */

var TipoListado=1;

/**
 * Cierra una ventana modal
 * @param {type} idModal
 * @returns {undefined}
 */
function CierraModal(idModal) {
    $("#"+idModal).modal('hide');//ocultamos el modal
    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}

function AbreModal(idModal){
    $("#"+idModal).modal();
}


/**
 * Muestra u oculta un elemento por su id
 * @param {type} id
 * @returns {undefined}
 */

function MuestraOcultaXID(id){
    
    var estado=document.getElementById(id).style.display;
    if(estado=="none" | estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}

/**
 * Limpia los divs de la compra despues de guardar
 * @returns {undefined}
 */
function LimpiarDivs(){
    document.getElementById('DivItemsCompra').innerHTML='';
    document.getElementById('DivTotalesCompra').innerHTML='';
}

/*
$('#CmbBusquedas').bind('change', function() {
    
    document.getElementById('CodigoBarras').value = document.getElementById('CmbBusquedas').value;
    BusquePrecioVentaCosto();
    
});

*/


function VerTablero(){
    var idDivDraw="DivDrawFE";
     
    var form_data = new FormData();
        form_data.append('Accion', 1);
        form_data.append('TipoListado', TipoListado);
        $.ajax({
        url: './Consultas/panel_factura_electronica.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           document.getElementById(idDivDraw).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function VerListado(Page=1){
    var idDivDraw="DivDrawListFE";
    //document.getElementById(idDivDraw).innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busqueda=document.getElementById('TxtBusquedas').value;
        
    var form_data = new FormData();
        form_data.append('Accion', 2);
        form_data.append('Page', Page);
        form_data.append('Busqueda', Busqueda);
        form_data.append('TipoListado', TipoListado);
        $.ajax({
        url: './Consultas/panel_factura_electronica.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           document.getElementById(idDivDraw).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function CambiePagina(Page=""){
    
    if(Page==""){
        Page = document.getElementById('CmbPage').value;
    }
    VerListado(Page);
}

function MarqueErrorElemento(idElemento){
    
    if(idElemento==undefined){
       return; 
    }
    document.getElementById(idElemento).style.backgroundColor="pink";
    document.getElementById(idElemento).focus();
}

function GenereFacturasElectronicas(){
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 1);
                      
    $.ajax({
        //async:false,
        url: '../../general/procesadores/facturacionElectronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                GenereFacturasElectronicas();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                           
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                VerifiqueFacturasElectronicas();
                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function VerifiqueFacturasElectronicas(){
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 2);
                        
    $.ajax({
        //async:false,
        url: '../../general/procesadores/facturacionElectronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                VerifiqueFacturasElectronicas();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                           
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                GenerePDFFacturasElectronicas();
                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function GenerePDFFacturasElectronicas(){
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 3);
                        
    $.ajax({
        //async:false,
        url: '../../general/procesadores/facturacionElectronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                GenerePDFFacturasElectronicas();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                           
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                GenereXMLFacturasElectronicas();
                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function GenereXMLFacturasElectronicas(){
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 4);
                        
    $.ajax({
        //async:false,
        url: '../../general/procesadores/facturacionElectronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                GenereXMLFacturasElectronicas();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                           
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                EnvieFacturasElectronicasXMail();
                                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function EnvieFacturasElectronicasXMail(){
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 7);
                        
    $.ajax({
        //async:false,
        url: '../../general/procesadores/facturacionElectronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                EnvieFacturasElectronicasXMail();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                           
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                VerTablero();
                VerListado();
                setTimeout(GenereFacturasElectronicas, 60000);
                //GenereXMLFacturasElectronicas();
                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function VerMensajeFacturaElectronica(idItemFacturasLog){
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones');  
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('idItemFacturasLog', idItemFacturasLog);
        form_data.append('TipoListado', TipoListado);
        $.ajax({
        url: './Consultas/panel_factura_electronica.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           document.getElementById(idDivDraw).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function VerJSONFacturaElectronica(idFactura){
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones');  
    var form_data = new FormData();
        form_data.append('Accion', 4);
        form_data.append('idFactura', idFactura);
        form_data.append('TipoListado', TipoListado);
        $.ajax({
        url: './Consultas/panel_factura_electronica.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           document.getElementById(idDivDraw).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function ReportarFacturaElectronica(idFactura){
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones');
    document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 1);
        form_data.append('idFactura', idFactura);            
    $.ajax({
        //async:false,
        url: '../../general/procesadores/facturacionElectronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                           
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function SeleccioneAccionFormularios(){
    var Accion = document.getElementById("idFormulario").value;
        
    if(Accion==103){
        var idTercero=document.getElementById("idTercero").value;
        EditarTercero('ModalAcciones','BntModalAcciones',idTercero,'clientes');
    }
}

function ActualizarErroresFacturasElectronicas(){
    var idDivDraw="DivProcessFE";
   
    document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Actualizacion de Documentos Corregidos</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 5);
               
    $.ajax({
        //async:false,
        url: '../../general/procesadores/facturacionElectronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
                alertify.success(respuestas[1]);
                document.getElementById(idDivDraw).innerHTML='';
                
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                alertify.error(respuestas[1]);           
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                alertify.error(respuestas[1]);                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

document.getElementById('BtnMuestraMenuLateral').click();
VerListado();
VerTablero();
GenereFacturasElectronicas();