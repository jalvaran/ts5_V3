/* 
 * Controlador para las ventas por celular
 * 
 * 2021-08-10 por Julian Alvaran
 * 
 */

/**
 * Selecciona la accion a ejecutar del boton del modal
 * @returns {undefined}
 */
function AccionesPOS(){
    
    var idFormulario=document.getElementById('idFormulario').value; //determina el tipo de formulario que se va a guardar
    if(idFormulario==7){
        CerrarTurno();
    }
    if(idFormulario==100){
        CrearTercero('ModalAccionesPOS','BntModalPOS');
    }
}


/**
 * funcion para dibujar el formulario con el cual se agregarán los productos
 * @returns {undefined}
 */
function frm_agregar_producto(){
    
    $("#ModalAccionesPOS").modal();
        
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
                
        $.ajax({
        url: './Consultas/pos_cel.draw.php',
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
 *  funcion para cambiar la cantidad a agregar de un producto
 * @param {type} item_id => id del producto
 * @param {type} accion => indica la accion , sumar, restar o incrementar x 10
 * @returns {undefined}
 */
function cambiar_cantidad_agregar(item_id,accion){
    var cantidad_id="sp_cantidad_agregar_"+item_id;   
        
    var cantida=$('#'+cantidad_id).html();
    if(accion==1){
       cantida++;
    }
    if(accion==3){
       cantida++;
       cantida++;
       cantida++;
       cantida++;
       cantida++;
       cantida++;
       cantida++;
       cantida++;
       cantida++;
       cantida++;
    }
    if(accion==2 && cantida>1){
       cantida--;
    }
    if(accion==4 && cantida>10){
       cantidad=cantida-10;
    }
    $('#'+cantidad_id).html(cantida);
    
}

/**
 * Agregar un item a una preventa
 * @returns {undefined}
 */
function agregar_item(producto_id,valor=""){
    
    var idPreventa=document.getElementById('idPreventa').value; 
    var cantidad_id="sp_cantidad_agregar_"+producto_id;       
    var cantidad=$('#'+cantidad_id).html();
        
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('idPreventa', idPreventa);
        form_data.append('producto_id', producto_id);       
        form_data.append('cantidad', cantidad);
        form_data.append('valor', valor);
        
        $.ajax({
        url: './procesadores/pos_cel.process.php',
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
                
                var mensaje=respuestas[1];
                alertify.success(mensaje,1000);
                dibuje_preventa(idPreventa);
                dibuje_totales(idPreventa);
            }else{
                alertify.alert(data);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


function dibuje_preventa(idPreventa=""){
    
    var modal_id="div_preventa";
        
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('idPreventa', idPreventa);
                
        $.ajax({
        url: './Consultas/pos_cel.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(modal_id).innerHTML=data;
                   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
} 

function dibuje_totales(idPreventa=""){
    
    var modal_id="div_totales";
        
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('idPreventa', idPreventa);
                
        $.ajax({
        url: './Consultas/pos_cel.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(modal_id).innerHTML=data;
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
      })  
} 


/**
 * Abre el modal para crear un tercero
 * @returns {undefined}
 */
function frm_crear_tercero(){
    $("#ModalAccionesPOS").modal();
    
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        
        $.ajax({
        url: '../../general/Consultas/formularios.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmPOS').innerHTML=data;
            $('#CodigoMunicipio').select2();
            Number_Format_Input();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

/**
 * confirma si desea crear una factura desde la preventa
 * @param {type} idPreventa
 * @returns {undefined}
 */
function confirma_guardar_factura(idPreventa){
    
    alertify.confirm('Está seguro que desea Crear esta factura? ',
        function (e) {
            if (e) {
                facturar_preventa(idPreventa);
            }else{
                alertify.error("Se canceló el proceso");
                
                return;
            }
        });
}

/**
 * Facturar la Preventa
 * @param {type} idPreventa
 * @returns {undefined}
 */
function facturar_preventa(idPreventa){
    var boton_id="btn_facturar";
    var idCliente=document.getElementById('idCliente').value; 
    var CmbTipoPago=document.getElementById('CmbTipoPago').value;        
    document.getElementById(boton_id).disabled=true;
    document.getElementById(boton_id).value="Guardando...";        
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);       
        form_data.append('CmbTipoPago', CmbTipoPago);
        
        $.ajax({
        url: './procesadores/pos_cel.process.php',
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
                document.getElementById(boton_id).disabled=false;
                document.getElementById(boton_id).value="Facturar"; 
            }else if(respuestas[0]=="OK"){
                
                var mensaje=respuestas[1];
                $('#div_totales').html(mensaje);
                
                dibuje_preventa(idPreventa);
                document.getElementById("vinculoItems").click();
            }else{
                alertify.alert(data);
                dibuje_preventa(idPreventa);
                document.getElementById(boton_id).disabled=false;
                document.getElementById(boton_id).value="Facturar"; 
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            dibuje_preventa(idPreventa);
            document.getElementById(boton_id).disabled=false;
            document.getElementById(boton_id).value="Facturar"; 
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


/**
 * confirma si desea crear una factura desde la preventa
 * @param {type} idPreventa
 * @returns {undefined}
 */
function confirma_cotizar_preventa(idPreventa){
    
    alertify.confirm('Está seguro que desea Crear esta Cotización? ',
        function (e) {
            if (e) {
                cotizar_preventa(idPreventa);
            }else{
                alertify.error("Se canceló el proceso");
                
                return;
            }
        });
}

/**
 * Cotizar la Preventa
 * @param {type} idPreventa
 * @returns {undefined}
 */
function cotizar_preventa(idPreventa){
    var boton_id="btn_cotizar";
    var idCliente=document.getElementById('idCliente').value; 
    var CmbTipoPago=document.getElementById('CmbTipoPago').value;        
    document.getElementById(boton_id).disabled=true;
    document.getElementById(boton_id).value="Guardando...";        
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        form_data.append('idPreventa', idPreventa);
        form_data.append('idCliente', idCliente);       
        form_data.append('CmbTipoPago', CmbTipoPago);
        
        $.ajax({
        url: './procesadores/pos_cel.process.php',
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
                document.getElementById(boton_id).disabled=false;
                document.getElementById(boton_id).value="Facturar"; 
            }else if(respuestas[0]=="OK"){
                
                var mensaje=respuestas[1];
                $('#div_totales').html(mensaje);
                
                dibuje_preventa(idPreventa);
                document.getElementById("vinculoItems").click();
            }else{
                alertify.alert(data);
                dibuje_preventa(idPreventa);
                document.getElementById(boton_id).disabled=false;
                document.getElementById(boton_id).value="Facturar"; 
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            dibuje_preventa(idPreventa);
            document.getElementById(boton_id).disabled=false;
            document.getElementById(boton_id).value="Cotizar"; 
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

/**
 * edita la cantidad de un producto agregado a la preventa
 * @param {type} item_id
 * @param {type} accion
 * @returns {undefined}
 */
function editar_cantidad(item_id,accion){
    var cantidad_id="sp_cantidad_"+item_id;   
    var total_id="sp_total_"+item_id;   
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('item_id', item_id);
        form_data.append('accion_id', accion);
        
        $.ajax({
        url: './procesadores/pos_cel.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                //alertify.success(respuestas[1]);
                 var cantidad=respuestas[2];      
                 var total=respuestas[3];      
                 $('#'+cantidad_id).html(cantidad);
                 $('#'+total_id).html(total);
                 dibuje_preventa();
                 dibuje_totales();
            }else if(respuestas[0]=="E1"){
                
                alertify.error(respuestas[1]);
               
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

function EliminarItem(idItem){
        
    var form_data = new FormData();
        form_data.append('Accion', 6);        
        
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/pos_cel.process.php',
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
            dibuje_preventa();
            dibuje_totales();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

/**
 * Abre un modal para cerrar el turno
 * @returns {undefined}
 */
function ModalCerrarTurno(){
    
    $("#ModalAccionesPOS").modal();
    
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        
        $.ajax({
        url: './Consultas/pos_cel.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmPOS').innerHTML=data;
            Number_Format_Input();            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
      
      
}

/**
 * Cierra el turno
 * @returns {undefined}
 */
function CerrarTurno(){    
    document.getElementById("BntModalPOS").disabled=true;
    document.getElementById("BntModalPOS").value="Cerrando Turno...";
    var TotalRecaudadoCierre= document.getElementById("total_entrega").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 7);
        form_data.append('TotalRecaudadoCierre', TotalRecaudadoCierre); 
        
        $.ajax({
        url: './procesadores/pos_cel.process.php',
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
                
                document.getElementById("BntModalPOS").disabled=false;
                document.getElementById("BntModalPOS").value="Cerrar Turno";
            }else if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                document.getElementById("DivFrmPOS").innerHTML=respuestas[1];
                document.getElementById("BntModalPOS").disabled=false;
                document.getElementById("BntModalPOS").value="Cerrar Turno";
            }else{
                alertify.alert(data);
                document.getElementById("BntModalPOS").disabled=false;
                document.getElementById("BntModalPOS").value="Cerrar Turno";
            }
            
               
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById("BntModalPOS").disabled=false;
            document.getElementById("BntModalPOS").value="Cerrar Turno";
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

$(document).ready(function() {
    dibuje_preventa();
    dibuje_totales();
});