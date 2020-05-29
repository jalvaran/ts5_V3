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
        MostrarOpcionesInformes();
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
  
MostrarListadoSegunID();