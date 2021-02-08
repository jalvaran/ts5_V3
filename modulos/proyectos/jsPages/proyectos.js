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
var idModal="ModalAcciones";
var actividad_id="";
document.getElementById("BtnMuestraMenuLateral").click(); //da click sobre el boton que esconde el menu izquierdo de la pagina principal


/*
 * Funciones generales
 */
function MostrarMenuListados(){
    
    $("#DivMenuLateral").show('slow');
    $("#DivMenuLateral").animate({width:"18%"},'slow');
    
    $("#DivContenidoListado").animate({width:"100%"},'slow');
    $("#DivContenidoFiltros").animate({width:"80%"},'slow');
    $("#DivGeneralDraw").animate({width:"100%"},'slow');
    $("#DivGeneralDrawBox").animate({width:"100%"},'slow');
    
    
}

function OcultarMenuListados(){
    
    $("#DivMenuLateral").hide('slow');
    //document.getElementById("DivMenuLateral").style.display = "none";
    $("#DivContenidoListado").animate({width:"100%"},'slow');
    $("#DivContenidoFiltros").animate({width:"100%"},'slow');
    $("#DivGeneralDraw").animate({width:"100%"},'slow');
    $("#DivGeneralDrawBox").animate({width:"100%"},'slow');
    
}

function MostrarOcultarMenuListados(){
    varMenuListados=!varMenuListados;
    if(varMenuListados==1){        
        MostrarMenuListados();
    }else{        
        OcultarMenuListados();
    }
}

function MostrarListadoSegunID(Page=1){
    if(idListado==1){
        listar_proyectos(Page);
    }
    if(idListado==2){
        listar_tareas(Page);
    }
    if(idListado==3){
        listar_actividades(Page);
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
    MostrarListadoSegunID(Page);
    
        
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
function frm_crear_editar_proyecto(proyecto_id='',Page){
    var idDiv="DivFrmModalAcciones";
   
    $("#"+idModal).modal();
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('proyecto_id', proyecto_id);
        form_data.append('Page', Page);
                        
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
                if(tabla_id==1){
                    dibuje_fechas_excluidas(proyecto_id);
                }
                if(tabla_id==2){
                    listar_adjuntos_proyecto(proyecto_id);
                }
                if(tabla_id==3){
                    listar_adjuntos_tareas(proyecto_id);
                }
                if(tabla_id==4){
                    listar_adjuntos_actividades(proyecto_id);
                }
                
                
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
                CierraModal(idModal);
                
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
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


/**
 * Lista los proyectos
 * @param {type} Page
 * @returns {undefined}
 */
function listar_tareas(Page=1,proyecto_id=''){
    if(proyecto_id==''){
        var idDiv="DivGeneralDraw";
    }else{
        var idDiv="fila_proyecto_"+proyecto_id;
    }
    
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var empresa_id =document.getElementById("empresa_id").value;
    var cmb_filtro_tareas =document.getElementById("cmb_filtro_tareas").value;
    var FechaInicialRangos =document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos =document.getElementById("FechaFinalRangos").value;
    var busqueda_general =document.getElementById("busqueda_general").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 5);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('cmb_filtro_tareas', cmb_filtro_tareas);
        form_data.append('empresa_id', empresa_id);
        form_data.append('Page', Page);
        form_data.append('proyecto_id', proyecto_id);
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


/**
 * formulario para crear un proyecto
 * @param {type} Page
 * @returns {undefined}
 */
function frm_crear_editar_proyecto_tarea(tarea_id='',proyecto_id=''){
    var idDiv="DivFrmModalAcciones";
   
    $("#"+idModal).modal();
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 7);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('tarea_id', tarea_id);
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
            
            add_events_dropzone_tareas();
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function SeleccioneAccionFormularios(){
    
    var idFormulario=document.getElementById('idFormulario').value; //determina el tipo de formulario que se va a guardar
    
    if(idFormulario==1){
        crear_editar_proyecto();
    }
    if(idFormulario==2){
        crear_editar_proyecto_tarea();
    }
    if(idFormulario==3){
        crear_editar_proyecto_tarea_actividad();
    }
    
}

/**
 * Lista los proyectos
 * @param {type} Page
 * @returns {undefined}
 */
function mostrar_calendario_proyecto(proyecto_id=''){
    
    var idDiv="DivGeneralDraw";
    
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 6);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
       
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
            init_calendar(proyecto_id);
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function agrega_eventos_actividades(){
    $(".fc-event").unbind();
    var containerEl = document.getElementById('external-events-list');
    new FullCalendar.Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function(eventEl) {
        //Aqui puedo colocar el id de la actividad        
          actividad_id=eventEl.id;
          var event_id=actividad_id+"_"+uuid.v4();
          return {
            title: eventEl.innerText.trim(),
            id: event_id            
          }
        }
        
      
    });
}

function init_calendar(proyecto_id){
    listar_tareas_proyecto(proyecto_id);
    
    //agrega_eventos_actividades();
    

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      locale: 'es',
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      
      eventReceive: function(e) {
            console.log(e.event.id);
            
            var todo_el_dia=0;
            horas_sumar="01:00:00";
            if(e.event.allDay){
                horas_sumar="23:59:59";
                todo_el_dia=1;                
            }
            if(e.event.start){
                var fecha_inicial=moment(e.event.start).format("YYYY-MM-DD HH:mm:ss");
            }
            if(e.event.end){
                var fecha_final=moment(e.event.end).format("YYYY-MM-DD HH:mm:ss");
            }else{
                var m1=moment(fecha_inicial);
                var m1= m1.add(moment.duration(horas_sumar));
                var fecha_final=moment(m1).format("YYYY-MM-DD HH:mm:ss");
            }
            
            
            console.log(fecha_inicial+" "+fecha_final);
      },
      eventResize: function(e) {
            console.log(e.event.id);
            
            var fecha_inicial=moment(e.event.start).format("YYYY-MM-DD HH:mm:ss");
            var fecha_final=moment(e.event.end).format("YYYY-MM-DD HH:mm:ss");
            console.log(fecha_inicial+" "+fecha_final);      
          
        
      },
      
      eventDrop: function(e ) { //Cuando está en otra fecha del mes y se arrastra a una nueva
            
            console.log(e.event.id);
           
            var todo_el_dia=0;
            horas_sumar="01:00:00";
            if(e.event.allDay){
                horas_sumar="23:59:59";
                todo_el_dia=1;                
            }
            if(e.event.start){
                var fecha_inicial=moment(e.event.start).format("YYYY-MM-DD HH:mm:ss");
            }
            if(e.event.end){
                var fecha_final=moment(e.event.end).format("YYYY-MM-DD HH:mm:ss");
            }else{
                var m1=moment(fecha_inicial);
                var m1= m1.add(moment.duration(horas_sumar));
                var fecha_final=moment(m1).format("YYYY-MM-DD HH:mm:ss");
            }
            
            console.log(fecha_inicial+" "+fecha_final);
        
      },
      eventClick: function(e) {
        if (confirm('Está seguro que desea eliminar esta actividad?' + e.event.id)) {
            var event_id=e.event.id;
            e.event.remove();
        }
      }
      
    });
    var date_selector = document.getElementById('date_goto');
    date_selector.addEventListener('change', function() {
      if (this.value) {
        calendar.gotoDate(this.value);
      }
    });
    
    calendar.render();
    
}



function add_events_dropzone_tareas(){
    Dropzone.autoDiscover = false;
           
    urlQuery='procesadores/proyectos.process.php';
    var tarea_id=$("#tarea_adjuntos").data("tarea_id");
    var proyecto_id=$("#tarea_adjuntos").data("proyecto_id");
    var empresa_id=document.getElementById('empresa_id').value; 
    
    var myDropzone = new Dropzone("#tarea_adjuntos", { url: urlQuery,paramName: "adjunto_tarea"});
        myDropzone.on("sending", function(file, xhr, formData) { 

            formData.append("Accion", 5);
            formData.append("proyecto_id", proyecto_id);
            formData.append("tarea_id", tarea_id);
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
                listar_adjuntos_tareas(tarea_id);
            }else if(respuestas[0]=="E1"){
                alertify.error(respuestas[1]);
            }else{
                alert(data);
            }

        });
    listar_adjuntos_tareas(tarea_id);
}


 
 function listar_adjuntos_tareas(tarea_id=''){
    var idDiv="div_adjuntos_tareas";
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 8);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('tarea_id', tarea_id);
                        
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


function crear_editar_proyecto_tarea(){    
    
    var empresa_id =document.getElementById("empresa_id").value;
    var proyecto_tarea_id =document.getElementById("proyecto_tarea_id").value;
    var tarea_id =document.getElementById("tarea_id").value;
    
    var titulo_tarea =document.getElementById("titulo_tarea").value;
    var color_tarea =document.getElementById("color_tarea").value;
             
    var form_data = new FormData();
        
        form_data.append('Accion', 6);
        form_data.append('empresa_id', empresa_id);  
        form_data.append('proyecto_id', proyecto_tarea_id);  
        form_data.append('tarea_id', tarea_id);        
        form_data.append('titulo_tarea', titulo_tarea);
        form_data.append('color_tarea', color_tarea);
       
                                
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
                listar_tareas_proyecto(proyecto_tarea_id);
                CierraModal(idModal);
                
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

function listar_tareas_proyecto(proyecto_id){
    var idDiv="div_lista_tareas";
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 9);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('proyecto_id', proyecto_id);
                        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/proyectos.draw.php',// se indica donde llegara la informacion del objecto
        async: false,  //Lo ponemos asyncrono porque se debe cargar primero para poder colocar sus eventos
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            agrega_eventos_actividades();
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function frm_crear_editar_proyecto_tarea_actividad(actividad_id='',tarea_id='',proyecto_id=''){
    var idDiv="DivFrmModalAcciones";
   
    $("#"+idModal).modal();
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 10);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('tarea_id', tarea_id);
        form_data.append('proyecto_id', proyecto_id);
        form_data.append('actividad_id', actividad_id);
        
                        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/proyectos.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            
            add_events_dropzone_actividades();
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function add_events_dropzone_actividades(){
    Dropzone.autoDiscover = false;
           
    urlQuery='procesadores/proyectos.process.php';
    var tarea_id=$("#actividad_adjuntos").data("tarea_id");
    var proyecto_id=$("#actividad_adjuntos").data("proyecto_id");
    var actividad_id=$("#actividad_adjuntos").data("actividad_id");
    var empresa_id=document.getElementById('empresa_id').value; 
    
    var myDropzone = new Dropzone("#actividad_adjuntos", { url: urlQuery,paramName: "adjunto_actividad"});
        myDropzone.on("sending", function(file, xhr, formData) { 

            formData.append("Accion", 7);
            formData.append("proyecto_id", proyecto_id);
            formData.append("tarea_id", tarea_id);
            formData.append("empresa_id", empresa_id);
            formData.append("actividad_id", actividad_id);
            
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
                listar_adjuntos_actividades(actividad_id);
            }else if(respuestas[0]=="E1"){
                alertify.error(respuestas[1]);
            }else{
                alert(data);
            }

        });
    listar_adjuntos_actividades(actividad_id);
}

function listar_adjuntos_actividades(actividad_id=''){
    var idDiv="div_adjuntos_actividades";
    
    var empresa_id =document.getElementById("empresa_id").value;
        
    var form_data = new FormData();
        form_data.append('Accion', 11);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        
        form_data.append('empresa_id', empresa_id);
        form_data.append('actividad_id', actividad_id);
                        
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

function crear_editar_proyecto_tarea_actividad(){    
    
    var empresa_id =document.getElementById("empresa_id").value;
    var proyecto_tarea_id =document.getElementById("proyecto_tarea_id").value;
    var tarea_id =document.getElementById("tarea_id").value;
    var actividad_id =document.getElementById("actividad_id").value;
    
    var titulo_actividad =document.getElementById("titulo_actividad").value;
    var color_actividad =document.getElementById("color_actividad").value;
             
    var form_data = new FormData();
        
        form_data.append('Accion', 8);
        form_data.append('empresa_id', empresa_id);  
        form_data.append('proyecto_id', proyecto_tarea_id);  
        form_data.append('tarea_id', tarea_id);       
        form_data.append('actividad_id', actividad_id);        
        form_data.append('titulo_actividad', titulo_actividad);
        form_data.append('color_actividad', color_actividad);
       
                                
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
                //listar_actividades_tarea(tarea_id);
                CierraModal(idModal);
                
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


MostrarListadoSegunID();