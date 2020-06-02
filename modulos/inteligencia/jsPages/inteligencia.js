/**
 * Controlador para el modulo de inteligencia de negocios
 * JULIAN ALVARAN 2020-05-28
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
/**
 * Variables generales
 * @type Boolean|Number
 */
var varMenuListados=1;
var idListado=1;
var Filtro='';

document.getElementById("BtnMuestraMenuLateral").click(); //da click sobre el boton que esconde el menu izquierdo de la pagina principal
/*
 * Funciones generales
 */
function MostrarMenuListados(){
    
    document.getElementById("DivMenuLateral").style.display = "block";
    document.getElementById("DivMenuLateral").style.width = "18%";
    document.getElementById("DivContenidoListado").style.width = "100%";
    document.getElementById("DivContenidoFiltros").style.width = "80%";
    document.getElementById("DivGeneralDraw").style.width = "100%";
    document.getElementById("DivGeneralDrawBox").style.width = "100%";
    
}

function OcultarMenuListados(){
    
    document.getElementById("DivMenuLateral").style.display = "none";
    document.getElementById("DivContenidoListado").style.width = "100%";
    document.getElementById("DivContenidoFiltros").style.width = "100%";
    document.getElementById("DivGeneralDraw").style.width = "100%";
    document.getElementById("DivGeneralDrawBox").style.width = "100%";
    
}

function MostrarOcultarMenuListados(){
    varMenuListados=!varMenuListados;
    if(varMenuListados==1){        
        MostrarMenuListados();
    }else{        
        OcultarMenuListados();
    }
}

function MostrarListadoSegunID(){
    if(idListado==1){
        ListarClientes();
    }
    if(idListado==2){
        ListarProductosVendidos();
    }
    
}

function CambiePagina(Funcion,Page=""){
    
    if(Page==""){
        if(document.getElementById('CmbPage')){
            Page = document.getElementById('CmbPage').value;
        }else{
            Page=1;
        }
    }
    if(Funcion==1){
        ListarClientes(Page);
    }
    if(Funcion==2){
        ListarProductosVendidos(Page);
    }
    
}

function inicializarDial(idDial,Deshabilitar=1){
    var idDial="#"+idDial;
    var dialValue=$(idDial).val();
    $(idDial).knob();
    $({ Counter: 0 }).animate({
        Counter: dialValue
      }, {
        duration: 1000,
        easing: 'swing',
        step: function() {
          $(idDial).val((this.Counter)).trigger("change"); 
        },
        complete: function(){
            $(idDial).val(number_format(dialValue));
            if(Deshabilitar==1){
                $(idDial).prop( "disabled", true );
            }
        }
      });
      
}

/**
 * Lista los clientes
 * @param {type} Page
 * @returns {undefined}
 */
function ListarClientes(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var idCliente =document.getElementById("idCliente").value;
    var cmbFiltroCliente =document.getElementById("cmbFiltroCliente").value;
    var FechaInicialRangos =document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos =document.getElementById("FechaFinalRangos").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('cmbFiltroCliente', cmbFiltroCliente);
        form_data.append('idCliente', idCliente);
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/inteligencia.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
                        
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


$('#idCliente').select2({
		  
    placeholder: 'Todos los clientes',
    ajax: {
      url: 'buscadores/terceros.search.php',
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
  
  
function SeleccioneAccionFormularios(){
    var idFormulario=document.getElementById('idFormulario').value; //determina el tipo de formulario que se va a guardar
    
    if(idFormulario==100){
        CrearTercero('ModalAcciones','BntModalAcciones');
        MostrarListadoSegunID();
    }
    
    if(idFormulario==103){
        var idTercero=document.getElementById("idTercero").value;
        EditarTercero('ModalAcciones','BntModalAcciones',idTercero,'clientes');
        MostrarListadoSegunID();
    }
}
  
function CambiarTipoRango(){
    if($('#cmbFiltroCliente').val()=='' || $('#cmbFiltroCliente').val()=='1' ||  $('#cmbFiltroCliente').val()=='2'){
        $('#FechaInicialRangos').attr("type", "date");
        $('#FechaInicialRangos').attr("placeholder", "Fecha inicial");
        $('#FechaFinalRangos').attr("type", "date");
        $('#FechaFinalRangos').attr("placeholder", "Fecha Final");
    }
    
    if($('#cmbFiltroCliente').val()=='3'){
        $('#FechaInicialRangos').attr("type", "text");
        $('#FechaInicialRangos').attr("placeholder", "Puntaje inicial");
        $('#FechaFinalRangos').attr("type", "text");
        $('#FechaFinalRangos').attr("placeholder", "Puntaje Final");
    }
    
}  
  
function CambieEstadoCliente(idCliente){
    var form_data = new FormData();
        form_data.append('Accion', 1);        
        form_data.append('idCliente', idCliente);
        
        $.ajax({
        url: './procesadores/inteligencia.process.php',
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
                MostrarListadoSegunID();
            }else if(respuestas[0]=="E1"){
                alertify.error(respuestas[1]);
                MostrarListadoSegunID();
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
 * Lista los clientes
 * @param {type} Page
 * @returns {undefined}
 */
function ListarProductosVendidos(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var idCliente =document.getElementById("idCliente").value;
    var cmbFiltroCliente =document.getElementById("cmbFiltroCliente").value;
    var FechaInicialRangos =document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos =document.getElementById("FechaFinalRangos").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('cmbFiltroCliente', cmbFiltroCliente);
        form_data.append('idCliente', idCliente);
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/inteligencia.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
                        
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function DibujarFormularioDatosAdicionalesCliente(idCliente='',idDiv=""){
    if(idCliente==''){
        var idCliente = document.getElementById('idCliente').value;   
    }
     
            
    var form_data = new FormData();
        form_data.append('Accion', 5);        
        form_data.append('idCliente', idCliente);
                
        $.ajax({
        url: './../comercial/Consultas/AcuerdoPago.draw.php',
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
        url: './../comercial/procesadores/AcuerdoPago.process.php',
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
        
    var form_data = new FormData();
        form_data.append('Accion', 6);        
        form_data.append('idCliente', idCliente);
                
        $.ajax({
        url: './../comercial/Consultas/AcuerdoPago.draw.php',
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
        url: './../comercial/procesadores/AcuerdoPago.process.php',
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
         
    var form_data = new FormData();
        form_data.append('Accion', 7);        
        form_data.append('idCliente', idCliente);
                
        $.ajax({
        url: './../comercial/Consultas/AcuerdoPago.draw.php',
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


function DibujeRedactarCorreoClientes(Condicion){
    var idDiv="DivGeneralDraw";
    var form_data = new FormData();
        form_data.append('Accion', 3);        
        form_data.append('Condicion', Condicion);
                
        $.ajax({
        url: 'Consultas/inteligencia.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            $('.summernote').summernote({
                height: 300
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function EnviarMailClientes(idCliente){    
    var idBoton='btnEnviar';
    document.getElementById(idBoton).disabled=true;
    var Destinatario=document.getElementById('Destinatario').value;
    var Asunto=document.getElementById('Asunto').value;        
    var Mensaje = document.getElementById('Mensaje').value;    
           
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        form_data.append('Destinatario', Destinatario);        
        form_data.append('Asunto', Asunto);
        form_data.append('Mensaje', Mensaje);
                
        $.ajax({
        url: 'procesadores/inteligencia.process.php',
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

MostrarListadoSegunID();