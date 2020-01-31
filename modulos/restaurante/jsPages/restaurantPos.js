/**
 * Controlador para el pos de restaurantes
 * JULIAN ALVARAN 2020-01-30
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
/*
 * variables globales
 * @type Number|
 */
var idPedidoActivo=0;

/*
 * Eventos iniciales
 */
document.getElementById('BtnMuestraMenuLateral').click();


/*
 * Se agregan eventos o propiedades a los objetos
 */
$('#CmbBusquedaItems').bind('change', function() {    
    document.getElementById('Codigo').value = document.getElementById('CmbBusquedaItems').value;
    
});

$('#idCliente').select2({
            
    placeholder: 'Clientes Varios',
    ajax: {
      url: 'buscadores/clientes.search.php',
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
  
  $('#CmbBusquedaItems').select2({
		  
        placeholder: 'Selecciona un producto',
        
        ajax: {
          url: 'buscadores/productosventa.search.php',
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
  
/**
 * le agrego una funcion al campo codigo para detectar si se oprime el enter
 */
    $("#Codigo").keypress(function(e) {
        
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
            AgregarItem();
        }
    });

  
  /*
   * Inicio de las funciones del modulo
   * 
   */
  
  /**
 * Muestra u oculta un elemento de acuerdo a su id
 * @param {type} id
 * @returns {undefined}
 */
function MuestraOculta(id){
    
    var estado=document.getElementById(id).style.display;
    if(estado=="none" || estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}
/**
 * Posiciona el cursor en un elemento del dom
 * @param {type} id
 * @returns {undefined}
 */

function posiciona(id){
   document.getElementById(id).focus();
}
/*
 * Determina la funcion que debe hacer el boton guardar de la venta modal
 * @returns {undefined}
 */
function AccionesPOS(){
    var Accion = document.getElementById("idFormulario").value;
        
    if(Accion==100){
        CrearTercero('ModalAccionesPOS','BntModalPOS');
    }
    if(Accion==103){
        var idCliente = document.getElementById("idCliente").value;
        EditarTercero('ModalAccionesPOS','BntModalPOS',idCliente,"clientes");
    }
}
/*
 * Edita un tercero
 * @returns {undefined}
 */
function EditarTerceroPOS(){
    var idCliente = document.getElementById("idCliente").value;
    ModalEditarTercero('ModalAccionesPOS','DivFrmPOS',idCliente,"clientes");
}

/*
 * Selecciona el formulario a crear dependiendo del tipo de pedido
 * @returns {undefined}
 */
function FormularioCrearPedido(){
    var TipoPedido = document.getElementById("TipoPedido").value;
    if(TipoPedido==1){ //Pedidos para mesas
        FormularioPedidoMesa();
    }
    if(TipoPedido==2){ //Pedidos para Domicilios
        FormularioPedidoDomicilio();
    }
    if(TipoPedido==3){ //Pedidos para llevar
        FormularioPedidoLlevar();
    }
}
/*
 * Dibuja el formulario para crear un pedido a una mesa
 */
function FormularioPedidoMesa(){
    
    $("#ModalAccionesPOS").modal();
    var TipoPedido = document.getElementById("TipoPedido").value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('TipoPedido', TipoPedido);
        
        $.ajax({
        url: './Consultas/restaurantPos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmPOS').innerHTML=data;
                  
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
} 
/**
 * Crea un pedido para una mesa
 * @param {type} idMesa
 * @returns {undefined}
 */
function CrearPedidoMesa(idMesa){
    var idDivMensajes='DivMensajes';
       
    var form_data = new FormData();
        form_data.append('Accion', '1'); 
        form_data.append('idMesa', idMesa);
        
        $.ajax({
        url: './procesadores/restaurantPos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                
                idPedidoActivo=respuestas[2];
                alertify.success(respuestas[1]);
                CierraModal('ModalAccionesPOS');
                DibujePedidoActivo();
                
            }else{
                document.getElementById(idDivMensajes).innerHTML=data;
                
            }
                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}
/**
 * Dibuja el pedido que esté activo
 * @returns {undefined}
 */

function DibujePedidoActivo(){
    DibujeInformacionGeneralPedidoActivo();
    DibujeItemsPedido();
}


function DibujeInformacionGeneralPedidoActivo(){
    var idDiv="DivInfoPedidoActivo";
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('idPedido', idPedidoActivo);
        
        $.ajax({
        url: './Consultas/restaurantPos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            posiciona('Codigo');      
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

function DibujeItemsPedido(){
    var idDiv="DivItems";
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('idPedido', idPedidoActivo);
        
        $.ajax({
        url: './Consultas/restaurantPos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            posiciona('Codigo');      
            DibujeTotalesPedido();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}
/**
 * Dibuja los totales de un item
 * @returns {undefined}
 */
function DibujeTotalesPedido(){
    var idDiv="DivTotalesPedido";
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        form_data.append('idPedido', idPedidoActivo);
        
        $.ajax({
        url: './Consultas/restaurantPos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            posiciona('Codigo');      
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

function AgregarItem(){
    var idBoton="BtnAgregarItem";
    document.getElementById(idBoton).disabled=true;
    var Codigo=document.getElementById("Codigo").value;    
    var Cantidad = (document.getElementById('Cantidad').value);
    var Observaciones = document.getElementById('Observaciones').value; 
    
    var form_data = new FormData();
        form_data.append('Accion', '2'); 
        form_data.append('idProducto', Codigo);
        form_data.append('idPedido', idPedidoActivo);
        form_data.append('Cantidad', Cantidad);
        form_data.append('Observaciones', Observaciones);
                
        $.ajax({
        url: './procesadores/restaurantPos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                
                document.getElementById('Cantidad').value=1;
                document.getElementById('Codigo').value="";
                document.getElementById('Observaciones').value="";  
                alertify.success(respuestas[1]);
                DibujeItemsPedido();
            }else if(respuestas[0]=="E1"){
                
                alertify.alert(respuestas[1]);
            
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
      });
}

function EliminarItem(idItem){
        
    var form_data = new FormData();
        form_data.append('Accion', 6);        
        
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/restaurantPos.process.php',
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
            }
            if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }
            DibujeItemsPedido();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

/**
 * Imprime un pedido
 * @returns {undefined}
 */
function ImprimirPedido(idPedido=''){
    if(idPedido==''){
        idPedido=idPedidoActivo;
    }  
    var form_data = new FormData();
        form_data.append('Accion', '3');        
        form_data.append('idPedido', idPedido);
        
                
        $.ajax({
        url: './procesadores/restaurantPos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                                
                var mensaje=respuestas[1];            
                alertify.success(mensaje);
                
            }else if(respuestas[0]=="E1"){
                var mensaje=respuestas[1];
                alertify.alert(mensaje);
            
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


/**
 * Imprime una precuenta
 * @param {type} idPedido
 * @returns {undefined}
 */

function ImprimirPrecuenta(idPedido=''){
    if(idPedido==''){
        idPedido=idPedidoActivo;
    }
    var form_data = new FormData();
        form_data.append('Accion', '4');        
        form_data.append('idPedido', idPedido);
        
                
        $.ajax({
        url: './procesadores/restaurantPos.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                                
                var mensaje=respuestas[1];            
                alertify.success(mensaje);
                
            }else if(respuestas[0]=="E1"){
                var mensaje=respuestas[1];
                alertify.alert(mensaje);
            
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
