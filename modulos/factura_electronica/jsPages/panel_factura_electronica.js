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
    console.log("mostrando tablero");
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
    console.log("mostrando listado");
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
    console.log("generando facturas");
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
                GenereNotasCreditoElectronicas();
                           
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


function GenereNotasCreditoElectronicas(){
    console.log("generando notas");
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 7);
                      
    $.ajax({
        //async:false,
        url: 'procesadores/panel_factura_electronica.process.php',
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
                GenereNotasCreditoElectronicas();
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
    console.log("verificando facturas electronicas");
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
    console.log("guardando pdf facturas");
    var idDivDraw="NotificacionProcesos";
    console.log("Generando pdf facturas electronicas");
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
    console.log("generando xml facturas");
    var idDivDraw="NotificacionProcesos";
     console.log("Generando xml facturas electronicas");
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
                envie_facturas_x_mail();         
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                envie_facturas_x_mail();
                                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            setTimeout(GenereFacturasElectronicas, 600000);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function VerificarAcuseReciboDocumentos(){
     console.log("verificando acuse");
    var idDivDraw="NotificacionProcesosLargos";
    document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de verificacion de acuse de recibo</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 10);
                        
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
                VerTablero();
                VerListado();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                    
            }else if(respuestas[0]==="RE"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                VerTablero();
                VerListado();
                                           
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

function VerJSONNotaCreditoFE(idNota){
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones');  
    var form_data = new FormData();
        form_data.append('Accion', 7);
        form_data.append('idNota', idNota);
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
    console.log("reportando factura");
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

function ReportarNotaCreditoElectronica(idNota){
    console.log("reportando nota credito");
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones');
    document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 8);
        form_data.append('idNota', idNota);            
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


function FormularioNuevaNotaCredito(idFacturaElectronica){
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones');  
    var form_data = new FormData();
        form_data.append('Accion', 5);
        form_data.append('idFacturaElectronica', idFacturaElectronica);
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
           DibujeItemsNota(idFacturaElectronica);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function AgregarItemANota(idItemFactura,idFacturaElectronica){
    var idBoton="BtnAgregarItem_"+idItemFactura;
    var idCantidad="TxtCantidad_"+idItemFactura;
    document.getElementById(idBoton).disabled=true;
    //document.getElementById(idBoton).value="Agregando...";
    var idDivDraw="DivItemsNota";
    var TxtCantidad = document.getElementById(idCantidad).value;
   
    var form_data = new FormData();
        form_data.append('Accion', 2);
        form_data.append('idItemFactura', idItemFactura);
        form_data.append('idFacturaElectronica', idFacturaElectronica);
        form_data.append('TxtCantidad', TxtCantidad); 
        
    $.ajax({
        //async:false,
        url: './procesadores/panel_factura_electronica.process.php',
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
                DibujeItemsNota(idFacturaElectronica);
                document.getElementById(idBoton).disabled=false;
                //document.getElementById(idBoton).value="Agregar";
                
            }else if(respuestas[0]==="E1"){
                
                
                alertify.error(respuestas[1]); 
                MarqueErrorElemento(respuestas[2]);
                document.getElementById(idBoton).disabled=false;
                //document.getElementById(idBoton).value="Agregar";                       
            }else{
                
                document.getElementById(idDivDraw).innerHTML=data;
                document.getElementById(idBoton).disabled=false;
                //document.getElementById(idBoton).value="Agregar";
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
                        
            document.getElementById(idBoton).disabled=false;
            document.getElementById(idBoton).value="Agregar";
            alert(xhr.status);
            alert(thrownError);
          }
      })
}



function DibujeItemsNota(idFacturaElectronica){
    var idDivDraw="DivItemsNota";
    document.getElementById(idDivDraw).innerHTML='<div id="GifProcess"><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var form_data = new FormData();
        form_data.append('Accion', 6);
        form_data.append('idFacturaElectronica', idFacturaElectronica);
        
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



function EliminarItem(Tabla,idItem,idFacturaElectronica){
    
    var idDivDraw="DivItemsNota";
    
   
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('Tabla', Tabla);
        form_data.append('idItem', idItem);
        form_data.append('idFacturaElectronica', idFacturaElectronica);  
    $.ajax({
        //async:false,
        url: './procesadores/panel_factura_electronica.process.php',
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
                DibujeItemsNota(respuestas[2]);
                                
            }else if(respuestas[0]==="E1"){
                
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

function ConfirmaGuardarNota(idFacturaElectronica){
    
    alertify.confirm('Está seguro que desea Guardar la Nota Credito ?',
        function (e) {
            if (e) {

                alertify.success("Guardando...");                    
                GuardarNotaCredito(idFacturaElectronica);
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function GuardarNotaCredito(idFacturaElectronica){
    
    var idDivDraw="DivFrmModalAcciones";
    var idBoton="BtnGuardarNota";
    
    document.getElementById(idBoton).disabled=true;
    var TxtFecha = document.getElementById("TxtFecha").value;    
    var TxtObservaciones = document.getElementById("TxtObservaciones").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 4);        
        form_data.append('idFacturaElectronica', idFacturaElectronica);
        form_data.append('TxtFecha', TxtFecha);
        form_data.append('TxtObservaciones', TxtObservaciones);
            
    $.ajax({
        //async:false,
        url: './procesadores/panel_factura_electronica.process.php',
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
                document.getElementById(idDivDraw).innerHTML="<h1>"+respuestas[1]+"</h1>";
                /*
                TipoListado=2;
                VerListado();
                VerTablero();
                  */
                clearTimeout();
                TipoListado=2;
                VerListado();
                VerTablero();
                GenereFacturasElectronicas();
            }else if(respuestas[0]==="E1"){
                MarqueErrorElemento(respuestas[2]);
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


function ObtenerLogsDocumento(idDocumento){
    console.log("obteniendo logs");
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones'); 
    document.getElementById(idDivDraw).innerHTML='<a><h3>Obteniendo logs del documento</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 9);
        form_data.append('TipoDocumento', TipoListado);
        form_data.append('idDocumento', idDocumento);
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
                
                document.getElementById(idDivDraw).innerHTML=respuestas[2];
                
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

function enviar_x_mail(idDocumento,TipoListado){
    console.log("enviando mail");
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones'); 
    document.getElementById(idDivDraw).innerHTML='<a><h3>Enviando Factura al Correo</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 5);
        form_data.append('TipoDocumento', TipoListado);
        form_data.append('idDocumento', idDocumento);
    $.ajax({
        //async:false,
        url: 'procesadores/panel_factura_electronica.process.php',
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


function envie_facturas_x_mail(){
    console.log("enviando facturas por mail 2");
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 5);
                        
    $.ajax({
        //async:false,
        url: 'procesadores/panel_factura_electronica.process.php',
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
                envie_facturas_x_mail();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                VerTablero();
                VerListado();
                setTimeout(GenereFacturasElectronicas, 100000);           
            }else if(respuestas[0]==="RE"){
                
                actualice_uuid_notas();
                                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            setTimeout(GenereFacturasElectronicas, 600000);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}


function actualice_uuid_notas(){
    console.log("actualizando uuid notas");
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 8);
                        
    $.ajax({
        //async:false,
        url: 'procesadores/panel_factura_electronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
                
                envie_notas_x_mail();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                VerTablero();
                VerListado();
                setTimeout(GenereFacturasElectronicas, 100000);           
                                   
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            setTimeout(GenereFacturasElectronicas, 600000);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function envie_notas_x_mail(){
    console.log("enviando notas por mail ");
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Enviando notas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 9);
                        
    $.ajax({
        //async:false,
        url: 'procesadores/panel_factura_electronica.process.php',
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
                envie_notas_x_mail();
            }else if(respuestas[0]==="E1"){
                
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                VerTablero();
                VerListado();
                setTimeout(GenereFacturasElectronicas, 100000);           
            }else if(respuestas[0]==="RE"){
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                VerTablero();
                VerListado();
                setTimeout(GenereFacturasElectronicas, 60000);  
                                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            setTimeout(GenereFacturasElectronicas, 600000);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}


function ver_representacion_factura_electronica(documento_id){
    console.log("representacion grafica");
    var idDivDraw="NotificacionProcesos";
    //document.getElementById(idDivDraw).innerHTML='<a><h3>Iniciando Proceso de Generacion de Facturas Electronicas</h3></a>';
    var form_data = new FormData();
        form_data.append('Accion', 6);
        form_data.append('documento_id', documento_id);
                        
    $.ajax({
        //async:false,
        url: 'procesadores/panel_factura_electronica.process.php',
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
                        
            
                                           
            }else{
                document.getElementById(idDivDraw).innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            setTimeout(GenereFacturasElectronicas, 600000);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}


document.getElementById('BtnMuestraMenuLateral').click();
VerListado();
VerTablero();
GenereFacturasElectronicas();
VerificarAcuseReciboDocumentos();