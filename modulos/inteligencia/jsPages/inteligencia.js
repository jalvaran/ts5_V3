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
    if(idListado==3){
        ListarMetaVentas();
    }
    if(idListado==4){
        
        ListarMetasDiarias();
    }
    if(idListado==5){
        
        reporte_grafico_metas();
    }
    
}

function construir_metas_diarias(){
    
    document.getElementById("DivGeneralDraw").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 14);        
        
        
        $.ajax({
        url: './procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        async: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                
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
    if(Funcion==4){
        ListarMetasDiarias(Page);
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



function ConfirmaCargarAlServidor(){
    alertify.confirm('Está seguro que desea Subir los clientes al servidor?',
        function (e) {
            if (e) {
                
                ObtengaTotalClientes();
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function ObtengaTotalClientes(){
    document.getElementById("DivMensajes").innerHTML="Obteniendo Total de Clientes a copiar";
    var idBoton="btn_subir";
    document.getElementById(idBoton).disabled=true;
    var form_data = new FormData();
        form_data.append('Accion', '6'); 
        
        
        $.ajax({
        url: './procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){
                
                alertify.success(respuestas[1]);                
                var total_clientes=parseInt(respuestas[2]);
               
                if(total_clientes==0){
                    document.getElementById(idBoton).disabled=false;
                    return;
                }else{
                    CopiarClientesAServidor(1,total_clientes);
                }
                
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
                MarqueErrorElemento(respuestas[2]);
                
            }else{
                document.getElementById(idBoton).disabled=false;  
                alertify.alert(data);
                
            }
                   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;   
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function CopiarClientesAServidor(page_clientes,total_clientes){
    var idBoton="btn_subir";
    var form_data = new FormData();
        form_data.append('Accion', '7'); 
        form_data.append('page_clientes', page_clientes); 
        form_data.append('total_clientes', total_clientes); 
        
        $.ajax({
        url: './procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){
                
                document.getElementById("DivMensajes").innerHTML=respuestas[1]; 
                var page_clientes=parseInt(respuestas[2]);
                CopiarClientesAServidor(page_clientes,total_clientes);                
                
            }else if(respuestas[0]=="END"){  
                alertify.success(respuestas[1]);
                document.getElementById("DivMensajes").innerHTML=respuestas[1]; 
                
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
                MarqueErrorElemento(respuestas[2]);
                
            }else{
                document.getElementById(idBoton).disabled=false;  
                alertify.alert(data);
                
            }
                   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;   
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function ConfirmaDescargarDesdeServidor(){
    alertify.confirm('Está seguro que desea Actulizar productos desde el Servidor?',
        function (e) {
            if (e) {
                
                ObtengaTotalClientesDescargar();
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function ObtengaTotalClientesDescargar(){
    document.getElementById("DivMensajes").innerHTML="Obteniendo Total de Registros a copiar";
    var idBoton="btn_descargar";
    document.getElementById(idBoton).disabled=true;
    var form_data = new FormData();
        form_data.append('Accion', '8'); 
        
        
        $.ajax({
        url: './procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){
                
                alertify.success(respuestas[1]);                
                var total_clientes=parseInt(respuestas[2]);
                
                if(total_clientes==0){
                    document.getElementById(idBoton).disabled=false;
                    return;
                }else{
                    CopiarClientesDesdeServidorExterno(1,total_clientes);
                }
                
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
                MarqueErrorElemento(respuestas[2]);
                
            }else{
                document.getElementById(idBoton).disabled=false;  
                alertify.alert(data);
                
            }
                   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;   
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function CopiarClientesDesdeServidorExterno(page_clientes,total_clientes){
    var idBoton="btn_descargar";
    var form_data = new FormData();
        form_data.append('Accion', '9'); 
        form_data.append('page_clientes', page_clientes); 
        form_data.append('total_clientes', total_clientes); 
        
        $.ajax({
        url: './procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){
                
                document.getElementById("DivMensajes").innerHTML=respuestas[1]; 
                var page_clientes=parseInt(respuestas[2]);
                CopiarClientesDesdeServidorExterno(page_clientes,total_clientes);                
                
            }else if(respuestas[0]=="END"){  
                alertify.success(respuestas[1]);
                document.getElementById("DivMensajes").innerHTML=respuestas[1]; 
                InsertarClientesNuevosDesdeTemporal();
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
                MarqueErrorElemento(respuestas[2]);
                
            }else{
                document.getElementById(idBoton).disabled=false;  
                alertify.alert(data);
                
            }
                   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;   
            alert(xhr.status);
            alert(thrownError);
          }
      });
}



function InsertarClientesNuevosDesdeTemporal(){
    document.getElementById("DivMensajes").innerHTML="Insertando Registros"; 
    var idBoton="btnDescargarProductos";
    var form_data = new FormData();
        form_data.append('Accion', '10'); 
                
        $.ajax({
        url: './procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){
                
                document.getElementById("DivMensajes").innerHTML=respuestas[1]; 
                MostrarListadoSegunID();               
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
                MarqueErrorElemento(respuestas[2]);
                
            }else{
                document.getElementById(idBoton).disabled=false;  
                alertify.alert(data);
                
            }
                   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;   
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function ListarMetaVentas(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 4);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        
                
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


function editar_registro_metas(tabla_id,item_id,campo,caja_id){
    var valor_nuevo=document.getElementById(caja_id).value;
    
    var form_data = new FormData();
        form_data.append('Accion', '12'); 
        form_data.append('tabla_id', tabla_id); 
        form_data.append('valor_nuevo', valor_nuevo); 
        form_data.append('item_id', item_id); 
        form_data.append('campo', campo); 
        
        $.ajax({
        url: './procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){
                
                alertify.success(respuestas[1]);
                //MostrarListadoSegunID();               
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                
                MarqueErrorElemento(respuestas[2]);
                
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

function crear_registros_iniciales_metas(ano){
   
    var form_data = new FormData();
        form_data.append('Accion', '13'); 
        form_data.append('ano', ano); 
               
        $.ajax({
        url: './procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){
                
                alertify.success(respuestas[1]);
                MostrarListadoSegunID();               
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


function ListarMetasDiarias(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
   
    var FechaInicialRangos =document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos =document.getElementById("FechaFinalRangos").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 5);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        
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


function reporte_grafico_metas(){
    var div_id="DivGeneralDraw";  
    var FechaInicialRangos =document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos =document.getElementById("FechaFinalRangos").value;   
    var form_data = new FormData();
        
        form_data.append('Accion', 6);
        
        form_data.append('fecha_inicial', FechaInicialRangos);
        form_data.append('fecha_final', FechaFinalRangos);
        
        $.ajax({
        url: '../../modulos/inteligencia/Consultas/inteligencia.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(div_id).innerHTML=data;
            obtener_datos_metas();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

function obtener_datos_metas(){
    var FechaInicialRangos =document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos =document.getElementById("FechaFinalRangos").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 11);        
        form_data.append('fecha_inicial', FechaInicialRangos);
        form_data.append('fecha_final', FechaFinalRangos);
        $.ajax({
        url: '../../modulos/inteligencia/procesadores/inteligencia.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                document.getElementById('frase_meta').innerHTML=respuestas[1];
                graphics_pie_draw("torta",'',respuestas[2],respuestas[3]);
                graphics_pie_draw("torta_mes","",respuestas[6],respuestas[7]);
                var json_metas=JSON.parse(respuestas[4]);
                var json_metas_cumplimiento=JSON.parse(respuestas[5]);
                graphics_bar_draw(json_metas,json_metas_cumplimiento);
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
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

function graphics_pie_draw(canvas_id,Frase,meta,cumplimiento){
    var texto_diferencia="Faltante";
    var diferencia=meta-cumplimiento;
    var color_diferencia="red";
    if(diferencia<0){
        diferencia=Math.abs(diferencia);
        texto_diferencia="Adicional";
        color_diferencia="green";
    }
    var xValues = ["Ventas","Meta",texto_diferencia];
    var yValues = [cumplimiento,meta,diferencia];
    var barColors = ["orange","blue",color_diferencia];
    
    new Chart(canvas_id, {
            type: "pie",
            data: {
              labels: xValues,
              datasets: [{
                backgroundColor: barColors,
                data: yValues
              }]
            },
            options: {
              title: {
                display: true,
                text: Frase
              }
            }
          });

}

function graphics_bar_draw(json_metas,json_metas_cumplimiento){
    
    var xValues = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    var barColors1 = ["green", "green","green","green","green","green","green", "green","green","green","green","green"];
    var barColors2 = ["blue", "blue","blue","blue","blue","blue","blue", "blue","blue","blue","blue","blue"];
    var valores_metas=JSON.stringify(json_metas,1);
    //console.log(valores_metas);
    var valores_metas_cumplimiento=JSON.stringify(json_metas_cumplimiento,1);
    //console.log(valores_metas_cumplimiento);
    new Chart("barras", {
        type: "bar",
        data: {
          labels: xValues,
          datasets: [{            
            data: json_metas,
            backgroundColor: barColors2,
            
            fill: false
          },{
            data: json_metas_cumplimiento,
            backgroundColor: barColors1,
            fill: false
          }]
        },
        options: {
          legend: {display: false}
        }
      });

}

MostrarListadoSegunID();