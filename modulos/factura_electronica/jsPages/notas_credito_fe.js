/**
 * Controlador para realizar la administracion de los tickets
 * JULIAN ALVARAN 2019-05-20
 * TECHNO SOLUCIONES SAS 
 * 
 */
var idNotaActiva=0;
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

function FormularioNuevaNotaCredito(){
    var idDivDraw="DivFrmModalAcciones";
    AbreModal('ModalAcciones');  
    var form_data = new FormData();
        form_data.append('Accion', 5);
        
        $.ajax({
        url: './Consultas/notas_credito_fe.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           document.getElementById(idDivDraw).innerHTML=data;
           $('#cmbIdFactura').select2({
		  
                placeholder: 'Selecciona un Factura',
                ajax: {
                  url: 'buscadores/facturas.search.php',
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
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function VerTablero(){
    var idDivDraw="DivDrawFE";
     
    var form_data = new FormData();
        form_data.append('Accion', 4);
        form_data.append('TipoListado', TipoListado);
        $.ajax({
        url: './Consultas/notas_credito_fe.draw.php',
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
        form_data.append('Accion', 5);
        form_data.append('Page', Page);
        form_data.append('Busqueda', Busqueda);
        form_data.append('TipoListado', TipoListado);
        $.ajax({
        url: './Consultas/notas_credito_fe.draw.php',
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

function SeleccioneAccionFormularios(){
    var Accion = document.getElementById("idFormulario").value;
        
    if(Accion==1){
        CrearNotaCredito();
    }
}

function CrearNotaCredito(){
    var idBoton="BntModalAcciones";
    document.getElementById(idBoton).disabled=true;
    document.getElementById(idBoton).value="Guardando...";
    var idDivDraw="DivFrmModalAcciones";
    var TxtFecha = document.getElementById("TxtFecha").value;
    var idFactura = document.getElementById("cmbIdFactura").value;
    var TxtObservaciones = document.getElementById("TxtObservaciones").value;
    var form_data = new FormData();
        form_data.append('Accion', 1);
        form_data.append('TxtFecha', TxtFecha);
        form_data.append('idFactura', idFactura);
        form_data.append('TxtObservaciones', TxtObservaciones);    
    $.ajax({
        //async:false,
        url: './procesadores/notas_credito.process.php',
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
                document.getElementById(idBoton).disabled=false;
                document.getElementById(idBoton).value="Guardar";
                CierraModal('ModalAcciones');
                DibujeNota(respuestas[2]);
            }else if(respuestas[0]==="E1"){
                CierraModal('ModalAcciones');
                document.getElementById(idDivDraw).innerHTML=respuestas[1];
                alertify.error(respuestas[1]);           
                document.getElementById(idBoton).disabled=false;
                document.getElementById(idBoton).value="Guardar";                       
            }else{
                CierraModal('ModalAcciones');
                document.getElementById(idDivDraw).innerHTML=data;
                document.getElementById(idBoton).disabled=false;
                document.getElementById(idBoton).value="Guardar";
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            CierraModal('ModalAcciones');
            
            document.getElementById(idBoton).disabled=false;
            document.getElementById(idBoton).value="Guardar";
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function DibujeNota(idNota){
    var idDivDraw="DivDrawListFE";
    idNotaActiva=idNota;
    document.getElementById(idDivDraw).innerHTML='<div id="GifProcess"><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var form_data = new FormData();
        form_data.append('Accion', 2);
        form_data.append('idNota', idNota);
        
        $.ajax({
        url: './Consultas/notas_credito_fe.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           document.getElementById(idDivDraw).innerHTML=data;
           DibujeItemsNota(idNotaActiva); 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function DibujeItemsNota(idNota){
    var idDivDraw="DivItemsNota";
    document.getElementById(idDivDraw).innerHTML='<div id="GifProcess"><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('idNota', idNota);
        
        $.ajax({
        url: './Consultas/notas_credito_fe.draw.php',
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

function AgregarItemANota(idItemFactura,idNota){
    var idBoton="BtnAgregarItem_"+idItemFactura;
    var idCantidad="TxtCantidad_"+idItemFactura;
    document.getElementById(idBoton).disabled=true;
    //document.getElementById(idBoton).value="Agregando...";
    var idDivDraw="DivItemsNota";
    var TxtCantidad = document.getElementById(idCantidad).value;
   
    var form_data = new FormData();
        form_data.append('Accion', 2);
        form_data.append('idItemFactura', idItemFactura);
        form_data.append('idNota', idNota);
        form_data.append('TxtCantidad', TxtCantidad); 
        
    $.ajax({
        //async:false,
        url: './procesadores/notas_credito.process.php',
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

function EliminarItem(Tabla,idItem){
    
    var idDivDraw="DivItemsNota";
    
   
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('Tabla', Tabla);
        form_data.append('idItem', idItem);
                
    $.ajax({
        //async:false,
        url: './procesadores/notas_credito.process.php',
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

function ConfirmaGuardarNota(idNota){
    
    alertify.confirm('Está seguro que desea Guardar la Nota Credito No '+idNota+'?',
        function (e) {
            if (e) {

                alertify.success("Guardando...");                    
                GuardarNotaCredito(idNota);
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function GuardarNotaCredito(idNota){
    
    var idDivDraw="DivItemsNota";
    var idBoton="BtnGuardarNota";
    
    document.getElementById(idBoton).disabled=true;
   
    var form_data = new FormData();
        form_data.append('Accion', 4);        
        form_data.append('idNota', idNota);
            
    $.ajax({
        //async:false,
        url: './procesadores/notas_credito.process.php',
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
                VerListado();
                                
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

document.getElementById('BtnMuestraMenuLateral').click();
VerListado();
VerTablero();
