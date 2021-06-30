/**
 * Controlador para administrar los traslados
 * JULIAN ALVARAN 2021-06-28
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
var modal_id='ModalAcciones';

document.getElementById("BtnMuestraMenuLateral").click(); //da click sobre el boton que esconde el menu izquierdo de la pagina principal
/*
 * Funciones generales
 */
function MostrarMenuListados(){
    
    document.getElementById("DivMenuLateral").style.display = "block";
    document.getElementById("DivMenuLateral").style.width = "18%";
    document.getElementById("DivContenidoListado").style.width = "80%";
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

function events_add_traslados_items(){
        
    $("#TxtCodigo").unbind();
    $("#TxtCantidad").unbind();
    $("#producto_id").unbind();
    
    $("#TxtCodigo").keypress(function(e) {
        if(e.which == 13) {
          agregar_item_traslado();
        }
    });
    $("#TxtCantidad").keypress(function(e) {
        if(e.which == 13) {
          agregar_item_traslado();
        }
    });
    
    $('#producto_id').select2({
            
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
}



function MostrarListadoSegunID(){
    if(idListado==1){
        ListarTraslados();
    }
    if(idListado==2){
        ListarPendientesSubir();
    }
    if(idListado==3){
        ListarPendientesDescargar();
    }
    if(idListado==4){
        ListarPendientesValidar();
    }
    if(idListado==5){
        ListarTrasladosItems();
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
        ListarTraslados(Page);
    }
    if(Funcion==2){
        ListarPendientesSubir(Page);
    }
    if(Funcion==3){
        ListarPendientesDescargar(Page);
    }
    if(Funcion==4){
        ListarPendientesValidar(Page);
    }
    if(Funcion==5){
        ListarTrasladosItems(Page);
    }
    
    
}

function SeleccioneAccionFormularios(){
    var formulario_id =document.getElementById("formulario_id").value;
    if(formulario_id==1){
        confirma_crear_traslado();
    }
    
}


/**
 * Lista los traslados
 * @param {type} Page
 * @returns {undefined}
 */
function ListarTraslados(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busquedas =document.getElementById("TxtBusquedas").value;
    var cmb_estado_traslado =document.getElementById("cmb_estado_traslado").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('Filtro', Filtro);
        form_data.append('Busquedas', Busquedas);
        form_data.append('cmb_estado_traslado', cmb_estado_traslado);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
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


function frm_nuevo_traslado(){
    var idDiv="DivFrmModalAcciones";
    $("#ModalAcciones").modal();
    
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
                        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
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

function confirma_crear_traslado(){
    alertify.confirm('Está seguro que desea Crear este Traslado?',
        function (e) {
            if (e) {
                
                crear_traslado();
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function crear_traslado(){
   
    var idBoton="BntModalAcciones";
    document.getElementById(idBoton).disabled=true;
    var CmbDestino=document.getElementById('CmbDestino').value;
    var TxtDescripcion=document.getElementById('TxtDescripcion').value;
    var form_data = new FormData();
        form_data.append('Accion', '1'); 
        form_data.append('CmbDestino', CmbDestino); 
        form_data.append('TxtDescripcion', TxtDescripcion); 
        
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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
                var traslado_id=respuestas[2];                
                frm_agregar_items_traslado(traslado_id);
                document.getElementById(idBoton).disabled=false;
                CierraModal(modal_id);
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

function frm_agregar_items_traslado(traslado_id){
    var idDiv="DivGeneralDraw";
        
    var form_data = new FormData();
        form_data.append('Accion', 3);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('traslado_id', traslado_id);                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
                        
            events_add_traslados_items();
            listar_items_traslado(traslado_id);
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function agregar_item_traslado(){
   
    var idBoton="BntModalAcciones";
    document.getElementById(idBoton).disabled=true;
    var traslado_id=document.getElementById('traslado_id_add').value;
    var TxtCodigo=document.getElementById('TxtCodigo').value;
    var producto_id=document.getElementById('producto_id').value;
    var TxtCantidad=document.getElementById('TxtCantidad').value;
    var form_data = new FormData();
        form_data.append('Accion', '2'); 
        form_data.append('traslado_id', traslado_id); 
        form_data.append('TxtCodigo', TxtCodigo); 
        form_data.append('producto_id', producto_id); 
        form_data.append('TxtCantidad', TxtCantidad); 
                
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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
                document.getElementById('TxtCodigo').value='';  
                document.getElementById('producto_id').value='';  
                document.getElementById('select2-producto_id-container').innerHTML='Seleccione un producto';  
                listar_items_traslado(traslado_id);
                document.getElementById(idBoton).disabled=false;
                
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

function listar_items_traslado(traslado_id){
    var idDiv="div_traslados_items";
    
    var form_data = new FormData();
        form_data.append('Accion', 4);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('traslado_id', traslado_id);
                        
        $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
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

function borrar_item_traslado(tabla_id,item_id,traslado_id){
   
    
    var form_data = new FormData();
        form_data.append('Accion', '3'); 
        form_data.append('traslado_id', traslado_id); 
        form_data.append('tabla_id', tabla_id); 
        form_data.append('item_id', item_id); 
        
                
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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
                
                listar_items_traslado(traslado_id);
               
                
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

function confirma_guardar_traslado(traslado_id){
    alertify.confirm('Está seguro que desea Guardar este Traslado?',
        function (e) {
            if (e) {
                
                guardar_traslado(traslado_id);
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function guardar_traslado(traslado_id){
   
    var idBoton="btn_guardar_traslado";
    document.getElementById(idBoton).disabled=true;
        
    var form_data = new FormData();
        form_data.append('Accion', '4'); 
        form_data.append('traslado_id', traslado_id); 
                        
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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

function ListarPendientesSubir(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busquedas =document.getElementById("TxtBusquedas").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 5);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('Filtro', Filtro);
        form_data.append('Busquedas', Busquedas);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
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

function iniciar_subir_traslado(traslado_id){
   
    var idDiv="DivGeneralDraw";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><img   src="imagenes/procesando.gif" alt="Cargando" ></div>';
    
        
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('traslado_id', traslado_id); 
                        
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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
                subir_traslado(traslado_id);
                
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

function subir_traslado(traslado_id){
   
    var idDiv="DivGeneralDraw";
    
    var form_data = new FormData();
        form_data.append('Accion', '6'); 
        form_data.append('traslado_id', traslado_id); 
                        
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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
                
                MostrarListadoSegunID();
                
                
            }else{
                
                alertify.alert(data);
                MostrarListadoSegunID();
               
            }
                   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            MostrarListadoSegunID();
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function ListarPendientesDescargar(Page=1){
    var idDiv="DivGeneralDraw";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busquedas =document.getElementById("TxtBusquedas").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 6);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('Filtro', Filtro);
        form_data.append('Busquedas', Busquedas);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
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


function iniciar_descarga_traslado(traslado_id){
   
    var idDiv="DivGeneralDraw";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><img   src="imagenes/procesando.gif" alt="Cargando" ></div>';
    
        
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('traslado_id', traslado_id); 
                        
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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
                descargar_traslado(traslado_id);
                
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

function descargar_traslado(traslado_id){
   
    var form_data = new FormData();
        form_data.append('Accion', '7'); 
        form_data.append('traslado_id', traslado_id); 
                        
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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
                
                MostrarListadoSegunID();
                
                
            }else{
                
                alertify.alert(data);
                MostrarListadoSegunID();
               
            }
                   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            MostrarListadoSegunID();
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function ListarPendientesValidar(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busquedas =document.getElementById("TxtBusquedas").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 7);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('Filtro', Filtro);
        form_data.append('Busquedas', Busquedas);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
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


function frm_validar_traslado(traslado_id){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
        
    var form_data = new FormData();
        form_data.append('Accion', 8);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('traslado_id', traslado_id);
                        
        $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
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

function confirma_validar_traslado(traslado_id){
    alertify.confirm('Está seguro que desea Verificar este Traslado?',
        function (e) {
            if (e) {
                
                verificar_traslado(traslado_id);
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function verificar_traslado(traslado_id){
   
    var idBoton="btn_guardar_traslado";
    document.getElementById(idBoton).disabled=true;
        
    var form_data = new FormData();
        form_data.append('Accion', '8'); 
        form_data.append('traslado_id', traslado_id); 
                        
        $.ajax({
        url: './procesadores/admin_traslados.process.php',
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


function ListarTrasladosItems(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busquedas =document.getElementById("TxtBusquedas").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 9);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('Filtro', Filtro);
        form_data.append('Busquedas', Busquedas);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin_traslados.draw.php',// se indica donde llegara la informacion del objecto
        
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


MostrarListadoSegunID();