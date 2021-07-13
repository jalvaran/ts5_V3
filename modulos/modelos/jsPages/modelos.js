/**
 * Controlador para el modulo de modelos
 * JULIAN ALVARAN 2021-07-12
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
/*
 * variables globales
 * @type Number|
 */
var servicio_activo_id=0;
var codigo_activo="";
var listado_id=1;
var Timer1;
/*
 * Eventos iniciales
 */
//document.getElementById('BtnMuestraMenuLateral').click();


/*
 * Se agregan eventos o propiedades a los objetos
 */
$("#busqueda").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
            ver_listado_segun_id();   
        }
    });

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

function stopTimer1(){
    clearTimeout(Timer1);
}

/**
 * Dibuja el pedido que esté activo
 * @returns {undefined}
 */

function ver_listado_segun_id(Page=1){
    stopTimer1();
    if(listado_id==1){
        listado_servicios(Page);
    }
    if(listado_id==2){
        listado_modelos_activas(Page);
    }
    if(listado_id==3){
        listado_modelos(Page);
    }
}

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

/*
 * Determina la funcion que debe hacer el boton guardar de la venta modal
 * @returns {undefined}
 */
function AccionesPOS(){
    var Accion = document.getElementById("idFormulario").value;
    if(Accion==1){
        crear_editar_modelo();
    }
    if(Accion==2){
        CerrarTurno();
    }
    if(Accion==3){
        AgregarItemComplementos();
    }
    if(Accion==4){
        editar_favorito();
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
 * Dibuja el formulario para crear un pedido a una mesa
 */
function listado_servicios(){
    
    var div_id="list_1";
    var busqueda=document.getElementById('busqueda').value; 
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        
        form_data.append('busqueda', busqueda); 
       
        $.ajax({
        url: './Consultas/modelos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(div_id).innerHTML=data;
              
            Timer1=setTimeout(listado_servicios, 3000); 
                 
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
} 

function listado_modelos(Page=1){
    
    var div_id="list_3";
    var busqueda=document.getElementById('busqueda').value; 
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('Page', Page);
        form_data.append('busqueda', busqueda); 
       
        $.ajax({
        url: './Consultas/modelos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(div_id).innerHTML=data;
              
            $('.ts_chk').bootstrapToggle();
                 
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
} 

/*
 * Dibuja el formulario para crear un pedido a una mesa
 */
function listado_modelos_activas(Page=1){
    
    var div_id="list_2";
    var busqueda=document.getElementById('busqueda').value; 
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('Page', Page);
        form_data.append('busqueda', busqueda); 
       
        $.ajax({
        url: './Consultas/modelos.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(div_id).innerHTML=data;
            $('.ts_chk').bootstrapToggle();    
            
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
function frm_crear_editar_modelo(item_id=""){
    
    $("#ModalAccionesPOS").modal();
        
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('item_id', item_id);
        
        $.ajax({
        url: './Consultas/modelos.draw.php',
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

function crear_editar_modelo(){
    
    var jsonFormulario=$('.ts_form').serialize();
    
    var form_data = new FormData();
        form_data.append('Accion', '1'); 
        form_data.append('jsonFormulario', jsonFormulario);         
        $.ajax({
        url: './procesadores/modelos.process.php',
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
                CierraModal('ModalAccionesPOS');
                ver_listado_segun_id();
                
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

function habilitar_deshabilitar(item_id,estado,Page){
    
    
    var form_data = new FormData();
        form_data.append('Accion', '2'); 
        form_data.append('item_id', item_id); 
        form_data.append('estado', estado); 
        $.ajax({
        url: './procesadores/modelos.process.php',
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
                
                ver_listado_segun_id(Page);
                
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


function MarqueErrorElemento(idElemento){
    
    if(idElemento==undefined){
       return; 
    }
    document.getElementById(idElemento).style.backgroundColor="pink";
    document.getElementById(idElemento).focus();
}



