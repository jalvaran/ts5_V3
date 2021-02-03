/**
 * Controlador para el modulo de proyectos
 * JULIAN ALVARAN 2021-02-01
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
/**
 * Variables generales
 * 
 */
var varMenuListados=1;
var idListado=1;

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
        listar_proyectos();
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
    idListado=Funcion;
    MostrarListadoSegunID();
    
        
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
 * Lista los proyectos
 * @param {type} Page
 * @returns {undefined}
 */
function listar_proyectos(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var empresa_id =document.getElementById("empresa_id").value;
    var cmb_filtro_proyectos =document.getElementById("cmb_filtro_proyectos").value;
    var FechaInicialRangos =document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos =document.getElementById("FechaFinalRangos").value;
    var busqueda_general =document.getElementById("busqueda_general").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('cmb_filtro_proyectos', cmb_filtro_proyectos);
        form_data.append('empresa_id', empresa_id);
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        form_data.append('busqueda_general', busqueda_general);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/proyectos.draw.php',// se indica donde llegara la informacion del objecto
        
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

function terceros_select2(){

    $('#cliente_id').select2({

        placeholder: 'Seleccione un Cliente',
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
  }
  
  
/**
 * formulario para crear un proyecto
 * @param {type} Page
 * @returns {undefined}
 */
function frm_crear_editar_proyecto(proyecto_id=''){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('proyecto_id', proyecto_id);
                        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/proyectos.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            terceros_select2();
            dibuje_fechas_excluidas(proyecto_id);
            add_events_dropzone_proyecto();
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function agregar_fecha_excluida(proyecto_id){    
    var idBoton='btn_excluir_fecha';
    document.getElementById(idBoton).disabled=true;
    var empresa_id =document.getElementById("empresa_id").value;
    var fecha_excluida =document.getElementById("fecha_excluida").value;
           
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('empresa_id', empresa_id);  
        form_data.append('proyecto_id', proyecto_id);  
        form_data.append('fecha_excluida', fecha_excluida);
                        
        $.ajax({
        url: 'procesadores/proyectos.process.php',
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
                dibuje_fechas_excluidas(proyecto_id);
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


function EliminarItem(tabla_id,item_id,proyecto_id){    
    
    var empresa_id =document.getElementById("empresa_id").value;
         
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('empresa_id', empresa_id);  
        form_data.append('item_id', item_id);  
        form_data.append('tabla_id', tabla_id);
                        
        $.ajax({
        url: 'procesadores/proyectos.process.php',
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
                dibuje_fechas_excluidas(proyecto_id);
                
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
                
                MarqueErrorElemento(respuestas[2]);
                
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


/**
 * dibuja las fechas excluidas de un proyecto
 * @param {type} Page
 * @returns {undefined}
 */
function dibuje_fechas_excluidas(proyecto_id=''){
    var idDiv="div_fechas_excluidas";
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 3);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('proyecto_id', proyecto_id);
                        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/proyectos.draw.php',// se indica donde llegara la informacion del objecto
        
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


function confirma_crear_editar_proyecto(){
    
    alertify.confirm('Está seguro que desea Guardar? ',
        function (e) {
            if (e) {
                
                crear_editar_proyecto();
            }else{
                alertify.error("Se canceló el proceso");
                
                return;
            }
        });
}

function crear_editar_proyecto(){    
    
    var empresa_id =document.getElementById("empresa_id").value;
    var proyecto_id =document.getElementById("proyecto_id").value;
    
    var cliente_id =document.getElementById("cliente_id").value;
    var nombre_proyecto =document.getElementById("nombre_proyecto").value;
    var horas_x_dia =document.getElementById("horas_x_dia").value;
    var excluir_sabados =document.getElementById("excluir_sabados").value;
    var excluir_domingos =document.getElementById("excluir_domingos").value;
         
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('empresa_id', empresa_id);  
        form_data.append('proyecto_id', proyecto_id);  
        form_data.append('cliente_id', cliente_id);
        
        form_data.append('nombre_proyecto', nombre_proyecto);
        form_data.append('horas_x_dia', horas_x_dia);
        form_data.append('excluir_sabados', excluir_sabados);
        form_data.append('excluir_domingos', excluir_domingos);
                                
        $.ajax({
        url: 'procesadores/proyectos.process.php',
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
                alertify.alert(respuestas[1]);
                
                MarqueErrorElemento(respuestas[2]);
                
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


function add_events_dropzone_proyecto(){
    Dropzone.autoDiscover = false;
           
    urlQuery='procesadores/proyectos.process.php';
    var proyecto_id=$("#proyecto_adjuntos").data("proyecto_id");
    var empresa_id=document.getElementById('empresa_id').value; 
    
    var myDropzone = new Dropzone("#proyecto_adjuntos", { url: urlQuery,paramName: "adjunto_proyecto"});
        myDropzone.on("sending", function(file, xhr, formData) { 

            formData.append("Accion", 4);
            formData.append("proyecto_id", proyecto_id);
            formData.append("empresa_id", empresa_id);
            
        });

        myDropzone.on("addedfile", function(file) {
            file.previewElement.addEventListener("click", function() {
                myDropzone.removeFile(file);
            });
        });

        myDropzone.on("success", function(file, data) {

            var respuestas = data.split(';');
            if(respuestas[0]=="OK"){
                alertify.success(respuestas[1]);
                listar_adjuntos_proyecto(proyecto_id);
            }else if(respuestas[0]=="E1"){
                alertify.error(respuestas[1]);
            }else{
                alert(data);
            }

        });
    listar_adjuntos_proyecto(proyecto_id);
}
 
 function listar_adjuntos_proyecto(proyecto_id=''){
    var idDiv="div_adjuntos_proyectos";
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 4);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('proyecto_id', proyecto_id);
                        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/proyectos.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            terceros_select2();
            dibuje_fechas_excluidas(proyecto_id);
            add_events_dropzone_proyecto();
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

MostrarListadoSegunID();