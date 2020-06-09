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
var Timer1;
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
    if(Accion==1){
        CrearDomicilioLlevar();
    }
    if(Accion==2){
        CerrarTurno();
    }
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
    if(TipoPedido==2 || TipoPedido==3){ //Pedidos para Domicilios
        FormularioDomicilioLlevar();
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

/*
 * Dibuja el formulario para crear un domicilio 
 */
function FormularioDomicilioLlevar(){
    
    $("#ModalAccionesPOS").modal();
    var TipoPedido = document.getElementById("TipoPedido").value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 7);
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

function CrearDomicilioLlevar(){
    var idDivMensajes='DivMensajes';
    var TelefonoPedido=document.getElementById("TelefonoPedido").value;    
    var NombrePedido=document.getElementById("NombrePedido").value;    
    var DireccionPedido=document.getElementById("DireccionPedido").value;    
    var ObservacionesPedido=document.getElementById("ObservacionesPedido").value;  
    var TipoPedido=document.getElementById("TipoPedido").value; 
    
    var form_data = new FormData();
        form_data.append('Accion', '12'); 
        form_data.append('TelefonoPedido', TelefonoPedido);
        form_data.append('NombrePedido', NombrePedido);
        form_data.append('DireccionPedido', DireccionPedido);
        form_data.append('ObservacionesPedido', ObservacionesPedido);
        form_data.append('TipoPedido', TipoPedido);
        
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
                DibujePedidoActivo();
                CierraModal('ModalAccionesPOS');
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                MarqueErrorElemento(respuestas[2]);
                
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
            }else if(respuestas[0]=="E2"){
                
                DibujeComplementos();
                
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


function AbrirOpcionesFacturacion(idPedido=''){
    if(idPedido==''){
        var idPedido=idPedidoActivo;
    }
    $("#ModalAccionesPOS").modal();
    document.getElementById("DivFrmPOS").innerHTML='<div id="GifProcess"><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', '5');        
        form_data.append('idPedido', idPedido);
        
                
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
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
}

//calcular la devuelta
function CalculeDevueltaRestaurante(Total){
    var Efectivo=$('#TxtEfectivo').val();
    var Tarjetas=$('#TxtTarjetas').val();
    var Cheques=$('#TxtCheques').val();
    var Bonos=$('#TxtBonos').val();
    var PropinaEfectivo=$('#TxtPropinaEfectivo').val();
    var PropinaTarjetas=$('#TxtPropinaTarjetas').val();
    var TotalPagos=parseInt(Efectivo)+parseInt(Tarjetas)+parseInt(Cheques)+parseInt(Bonos);
    var TotalPropinas=parseInt(PropinaEfectivo)+parseInt(PropinaTarjetas);
    document.getElementById("GranTotalPropinas").value = TotalPropinas;
    document.getElementById("TxtDevuelta").value = TotalPagos-(parseInt(Total)+parseInt(TotalPropinas));
}



function FacturarPedido(idPedido='',Options=0){
    var idBoton="BtnFacturarPedido";
    document.getElementById(idBoton).disabled=true;
    if(idPedido==''){
        idPedido=idPedidoActivo;
    }  
    
    var form_data = new FormData();
        form_data.append('Accion', 5)
    if(Options==0){
    
        form_data.append('idPedido', idPedido)
        form_data.append('idCliente', $('#idCliente').val())
        form_data.append('TxtTarjetas', $('#TxtTarjetas').val())
        form_data.append('TxtCheques', $('#TxtCheques').val()) 
        form_data.append('TxtBonos', $('#TxtBonos').val())
        form_data.append('CmbTipoPago', $('#CmbTipoPago').val())
        form_data.append('CmbColaboradores', $('#CmbColaboradores').val()) 
        form_data.append('TxtObservaciones', $('#TxtObservacionesFactura').val())
        form_data.append('TxtEfectivo', $('#TxtEfectivo').val()) 
        form_data.append('TxtDevuelta', $('#TxtDevuelta').val())
        form_data.append('TxtPropinaEfectivo', $('#TxtPropinaEfectivo').val()) 
        form_data.append('TxtPropinaTarjetas', $('#TxtPropinaTarjetas').val())
        
    }
    if(Options==1){
    
        form_data.append('idPedido', idPedido)
        form_data.append('idCliente', 1)
        form_data.append('TxtTarjetas', 0)
        form_data.append('TxtCheques', 0) 
        form_data.append('TxtBonos', 0)
        form_data.append('CmbTipoPago', 'Contado')
        form_data.append('CmbColaboradores', '') 
        form_data.append('TxtObservaciones', '')
        form_data.append('TxtEfectivo', 'NA') 
        form_data.append('TxtDevuelta', '0')
        form_data.append('TxtPropinaEfectivo', 0) 
        form_data.append('TxtPropinaTarjetas', 0)
        
    }
        document.getElementById('DivMensajes').innerHTML ='Procesando...<br><img src="../../images/process.gif" alt="Cargando" height="100" width="100">';
                
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
                document.getElementById('DivMensajes').innerHTML =mensaje;
                CierraModal('ModalAccionesPOS');
                idPedidoActivo=0;
                document.getElementById("vinculoInicio").click();
                DibujePedidoActivo();
                
            }else if(respuestas[0]=="E1"){
                var mensaje=respuestas[1];
                alertify.alert(mensaje);
                document.getElementById('DivMensajes').innerHTML =mensaje;
            
            }else{
                alertify.alert(data);
                document.getElementById('DivMensajes').innerHTML =data;
                              
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


/**
 * Dibuja el listado de pedidos
 * @returns {undefined}
 */
function DibujeListaPedidos(){
    var idDiv="DivListadoPedidos";
    var TipoPedido=document.getElementById("TipoPedido").value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 6);
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
            document.getElementById(idDiv).innerHTML=data;
            Timer1=setTimeout(DibujeListaPedidos, 3000); 
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


function EntregarPedido(idPedido){
      
    var form_data = new FormData();
        form_data.append('Accion', '8');        
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


function AutocompleteDatos(){
    var TelefonoPedido=document.getElementById("TelefonoPedido").value;   
    var form_data = new FormData();
        form_data.append('Accion', '11');        
        form_data.append('TelefonoPedido', TelefonoPedido);
        
                
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
                                
                document.getElementById("NombrePedido").value=respuestas[1];
                document.getElementById("DireccionPedido").value=respuestas[2];
                
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

function stopTimer1(){
    clearTimeout(Timer1);
}

function CambiarListaPedidos(){
    stopTimer1();
    DibujeListaPedidos();
}

function FormularioCerrarTurno(){
    
    $("#ModalAccionesPOS").modal();
    document.getElementById("DivFrmPOS").innerHTML='<div id="GifProcess"><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', '8');        
                        
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
      });
     
}


function CerrarTurno(){
    var idBoton="BntModalPOS";
    document.getElementById(idBoton).disabled=true;
    
    var idDivMensajes='DivFrmPOS';
    var EfectivoEnCaja=document.getElementById("EfectivoEnCaja").value; 
    var ObservacionesCierre=document.getElementById("ObservacionesCierre").value;  
    
    
    var form_data = new FormData();
        form_data.append('Accion', '9'); 
        form_data.append('EfectivoEnCaja', EfectivoEnCaja);
        form_data.append('ObservacionesCierre', ObservacionesCierre);
        
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
                
                alertify.success(respuestas[1]);                
                document.getElementById(idBoton).disabled=false;
    
                CierraModal('ModalAccionesPOS');
            }else if(respuestas[0]=="E1"){
                alertify.error(respuestas[1],0);
                MarqueErrorElemento(respuestas[2]);
                document.getElementById(idBoton).disabled=false;
            }else{
                document.getElementById(idDivMensajes).innerHTML=data;
                document.getElementById(idBoton).disabled=false;
                
            }
                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}

function MarqueErrorElemento(idElemento){
    
    if(idElemento==undefined){
       return; 
    }
    document.getElementById(idElemento).style.backgroundColor="pink";
    document.getElementById(idElemento).focus();
}

function AnularPedido(idPedido){
    alertify.confirm('Está seguro que desea Anular el pedido '+idPedido+'?',
        function (e) {
            if (e) {
                
                EnviaAnularPedido(idPedido);
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function EnviaAnularPedido(idPedido){
      
    var form_data = new FormData();
        form_data.append('Accion', '14');        
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
                idPedidoActivo=0;
                DibujePedidoActivo();
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

function EditarPrecioVenta(idItem,idCajaTexto){
    var idDivMensajes='DivMensajes';
    var Total=document.getElementById(idCajaTexto).value;   
    var form_data = new FormData();
        form_data.append('Accion', '15'); 
        form_data.append('idItem', idItem);
        form_data.append('Total', Total);
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
                
                alertify.success(respuestas[1]);                
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

/*
 * Dibuja el formulario para crear un pedido a una mesa
 */
function DibujeComplementos(){
    
    $("#ModalAccionesPOS").modal();
    var Codigo = document.getElementById("Codigo").value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 9);
        form_data.append('Codigo', Codigo);
        
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


DibujeListaPedidos();
