/**
 * Controlador para realizar las compras
 * JULIAN ALVARAN 2018-12-05
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */


/*
 * Abre el modal para registrar la nueva compra
 * @returns {undefined}
 */

var idPestana = 0;
var contador =0;
function AbrirModalNuevoComprobante(Proceso="Nuevo"){
    $("#ModalAcciones").modal();
    var idComprobante=document.getElementById('idComprobante').value;
    
    var form_data = new FormData();
        if(Proceso=="Nuevo"){
            var Accion=1;
        }
        if(Proceso=="Editar"){
            var Accion=2;
            
        }
        form_data.append('Accion', Accion);
        form_data.append('idComprobante', idComprobante);
        $.ajax({
        url: './Consultas/BajasAltas.draw.php',
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
      })  
}  
/**
 * Crear una compra
 * @returns {undefined}
 */
function AbrirFormularioNuevoPedido(){
     
    var form_data = new FormData();
        form_data.append('Accion', 1);        
          
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivTa1_1').innerHTML=data;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}
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
/**
 * Funcion para dibujar todos los componentes de una compra
 * @param {type} idCompra
 * @returns {undefined}
 */
function DibujePedido(idPedido=""){
    document.getElementById('idPedido').value=idPedido;
    document.getElementById('TabCuentas5').click();
    DibujeTituloPedido(idPedido);
    DibujeItems();
    DibujeTotalPedido();
    DibujeDepartamentos(idPedido);
   
}

function DibujeDepartamentos(){
    
    var form_data = new FormData();
        form_data.append('Accion', 4);        
        
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivDepartamentos').innerHTML=data;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

function MostrarProductos(idDepartamento){
    document.getElementById("DivSelectProductos").innerHTML='<div id="GifProcess"><img   src="../../images/loader.gif" alt="Cargando" height="20" width="20"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 5);        
        form_data.append('idDepartamento', idDepartamento);       
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivSelectProductos').innerHTML=data;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

function BuscarProductos(){
    document.getElementById("DivProductos").innerHTML='<div id="GifProcess"><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    var Busqueda=document.getElementById("Busqueda").value;
    var form_data = new FormData();
        form_data.append('Accion', 5);        
        form_data.append('Busqueda', Busqueda);       
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivProductos').innerHTML=data;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}
/**
 * Se dibujan los datos del pedido
 * @param {type} idCompra
 * @returns {undefined}
 */
function DibujeItems(){
    
    var idPedido = document.getElementById('idPedido').value;
    
    
    var form_data = new FormData();
        form_data.append('Accion', 6);
        form_data.append('idPedido', idPedido);
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivItems').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}

function DibujePedidos(){
    
    var form_data = new FormData();
        form_data.append('Accion', 2);
       
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivListaPedidos').innerHTML=data;
            if(idPestana==2){
                //contador++;
                //console.log(contador);
                setTimeout(DibujePedidos, 3000);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


function DibujeTituloPedido(idPedido){
    
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('idPedido', idPedido);
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivTituloPedido').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}

function DibujeTotalPedido(){
    var idPedido = document.getElementById('idPedido').value;
    var form_data = new FormData();
        form_data.append('Accion', 7);
        form_data.append('idPedido', idPedido);
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('spTotal').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


function DibujePreparacion(idPedido=''){
    if(idPedido==''){
        var idPedido = document.getElementById('idPedido').value;
    }else{
        document.getElementById('idPedido').value=idPedido;
    }
    
    document.getElementById('TabCuentas4').click();
    
    var form_data = new FormData();
        form_data.append('Accion', 9);
        form_data.append('idPedido', idPedido);
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivTab4').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


/**
 * Elimina un item de una factura de compra
 * @param {type} Tabla
 * @param {type} idItem
 * @returns {undefined}
 */
function EliminarItem(Tabla,idItem){
        
    var form_data = new FormData();
        form_data.append('Accion', 6);
        form_data.append('Tabla', Tabla);
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/pos2.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            alertify.error(data);
            DibujeItems();
            DibujeTotalPedido();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function CambiarEstadoAPreparado(Estado,idItem){
    var idPedido = document.getElementById('idPedido').value;
    var form_data = new FormData();
        form_data.append('Accion', 7);
        form_data.append('idPedido', idPedido);
        form_data.append('Estado', Estado);
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/pos2.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            alertify.success(data);
            DibujePreparacion();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
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
function ConfirmarBajaAlta(){
    
    alertify.confirm('Está seguro que desea Guardar este Comprobante?',
        function (e) {
            if (e) {
                
                GuardarComprobante();
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}
/**
 * Agrega los cargos al subtotal de los insumos
 * @param {type} event
 * @returns {undefined}
 */
function CrearPedidoMesa(idMesa){
    var idDivMensajes='DivListaPedidos';
    document.getElementById('TabCuentas5').click();
        
    var form_data = new FormData();
        form_data.append('Accion', '1'); 
        form_data.append('idMesa', idMesa);
        
        $.ajax({
        url: './procesadores/pos2.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                AbrirFormularioNuevoPedido();
                
                var mensaje=respuestas[1];
                var idPedido=respuestas[2];
                alertify.success(mensaje);
                DibujePedido(idPedido);
                
            }else{
                document.getElementById(idDivMensajes).innerHTML=data;
                
            }
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}


function AgregarProducto(){
    var idProducto=document.getElementById("idProducto").value; 
    var idPedido=document.getElementById("idPedido").value; 
    var Cantidad = (document.getElementById('Cantidad').value);
    var Observaciones = document.getElementById('Observaciones').value; 
    if(!$.isNumeric(Cantidad) || Cantidad == "" || Cantidad <= 0 ){
    
        alertify.alert("El campo Cantidad debe ser un número mayor a cero");
        document.getElementById('Cantidad').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('Cantidad').style.backgroundColor="white";
    }
    
    if(!$.isNumeric(idProducto) || idProducto == "" ){
    
        alertify.alert("Debe Seleccionar un Producto");
        document.getElementById('idProducto').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('idProducto').style.backgroundColor="white";
    }
    var form_data = new FormData();
        form_data.append('Accion', '2'); 
        form_data.append('idProducto', idProducto);
        form_data.append('idPedido', idPedido);
        form_data.append('Cantidad', Cantidad);
        form_data.append('Observaciones', Observaciones);
        document.getElementById('Cantidad').value=1;
        document.getElementById('Observaciones').value="";
        
        $.ajax({
        url: './procesadores/pos2.process.php',
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
                DibujeItems();
                DibujeTotalPedido();
            }else if(respuestas[0]=="E1"){
                var mensaje=respuestas[1];
                alertify.alert(mensaje);
            
            }else{
                alertify.alert(data);
                              
            }
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}

function ImprimirPedido(){
    var idPedido=document.getElementById("idPedido").value; 
       
    var form_data = new FormData();
        form_data.append('Accion', '3');        
        form_data.append('idPedido', idPedido);
        
                
        $.ajax({
        url: './procesadores/pos2.process.php',
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
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}



function ImprimirPrecuenta(){
    var idPedido=document.getElementById("idPedido").value; 
     
    var form_data = new FormData();
        form_data.append('Accion', '4');        
        form_data.append('idPedido', idPedido);
        
                
        $.ajax({
        url: './procesadores/pos2.process.php',
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
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}


/**
 * Limpia los divs de la compra despues de guardar
 * @returns {undefined}
 */
function LimpiarDivs(){
    
    document.getElementById('DivTituloPedido').innerHTML='';
    document.getElementById('DivItems').innerHTML='';
    document.getElementById('DivTotales').innerHTML='';
}



function SeleccioneAccionFormularios(){
    var Accion = document.getElementById("idFormulario").value;
        
    if(Accion==1 || Accion==2){
        CrearComprobante();
    }
}

function IncrementaCantidad(){
    var Cantidad = parseFloat(document.getElementById("Cantidad").value);
    
    document.getElementById("Cantidad").value=Cantidad+1;
}

function DisminuyeCantidad(){
    
    var Cantidad = parseFloat(document.getElementById("Cantidad").value);
    
    document.getElementById("Cantidad").value=Cantidad-1;
}

function AbrirOpcionesFacturacion(idPedido=''){
    if(idPedido==''){
        var idPedido=document.getElementById('idPedido').value;
    }
    document.getElementById('TabCuentas3').click();
    document.getElementById("DivFormularioFacturacion").innerHTML='<div id="GifProcess"><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', '8');        
        form_data.append('idPedido', idPedido);
        
                
        $.ajax({
        url: './Consultas/pos2.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFormularioFacturacion').innerHTML=data;
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



function FacturarPedido(idPedido,Options=0){
        
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
        document.getElementById('DivProcesamiento').innerHTML ='Procesando...<br><img src="../../images/process.gif" alt="Cargando" height="100" width="100">';
                
        $.ajax({
        url: './procesadores/pos2.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                document.getElementById('DivProcesamiento').innerHTML ="";
                
                var mensaje=respuestas[1];            
                alertify.success(mensaje);
                document.getElementById('DivFormularioFacturacion').innerHTML =mensaje;
                document.getElementById('idPedido').value='';
                LimpiarDivs();
            }else if(respuestas[0]=="E1"){
                var mensaje=respuestas[1];
                alertify.alert(mensaje);
                document.getElementById('DivProcesamiento').innerHTML =mensaje;
            
            }else{
                alertify.alert(data);
                document.getElementById('DivProcesamiento').innerHTML =data;
                              
            }
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}

function EntregarPedido(idPedido){
      
    var form_data = new FormData();
        form_data.append('Accion', '8');        
        form_data.append('idPedido', idPedido);
        
                
        $.ajax({
        url: './procesadores/pos2.process.php',
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
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}

document.getElementById('BtnMuestraMenuLateral').click();
//ConvertirSelectBusquedas();

//$('#ValorUnitario').mask('1.999.999.##0,00', {reverse: true});
//$('#Cantidad').mask('9.999.##0,00', {reverse: true});