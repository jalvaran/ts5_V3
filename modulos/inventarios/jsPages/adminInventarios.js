/**
 * Controlador para administrar los inventarios
 * JULIAN ALVARAN 2020-05-06
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

function MostrarListadoSegunID(){
    if(idListado==1){
        ListarProductos();
    }
    if(idListado==2){
        ListarServicios();
    }
    if(idListado==3){
        ListarTraslados();
    }
    if(idListado==4){
        ListarInsumos();
    }
    if(idListado==5){
        ListarKardex();
    }
    if(idListado==6){
        ListarSeparados();
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
        ListarProductos(Page);
    }
    if(Funcion==2){
        ListarServicios(Page);
    }
    if(Funcion==3){
        ListarTraslados(Page);
    }
    if(Funcion==4){
        ListarInsumos(Page);
    }
    if(Funcion==5){
        ListarKardex(Page);
    }
    if(Funcion==6){
        ListarSeparados(Page);
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
 * Lista los productos para la venta
 * @param {type} Page
 * @returns {undefined}
 */
function ListarProductos(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busquedas =document.getElementById("TxtBusquedas").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('Filtro', Filtro);
        form_data.append('Busquedas', Busquedas);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/adminInventarios.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            inicializarDial("dialItems");
            inicializarDial("dialExistencias");
            inicializarDial("dialCosto");
            inicializarDial("dialTotalVenta");
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function ConfirmaCargarAlServidor(){
    alertify.confirm('Está seguro que desea Cargar este inventario en el Servidor?',
        function (e) {
            if (e) {
                
                ObtengaTotalProductos();
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function ObtengaTotalProductos(){
    document.getElementById("DivMensajes").innerHTML="Obteniendo Total de Registros a copiar";
    var idBoton="btnSubirProductos";
    document.getElementById(idBoton).disabled=true;
    var form_data = new FormData();
        form_data.append('Accion', '3'); 
        
        
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                var totalProducts=parseInt(respuestas[2]);
                var totalBars=parseInt(respuestas[3]);
                if(totalProducts==0){
                    document.getElementById(idBoton).disabled=false;
                    return;
                }else{
                    CopiarProductosAServidor(1,totalProducts,totalBars);
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

function CopiarProductosAServidor(pageProducts,totalProducts,totalBars){
    var idBoton="btnSubirProductos";
    var form_data = new FormData();
        form_data.append('Accion', '4'); 
        form_data.append('pageProducts', pageProducts); 
        form_data.append('totalProducts', totalProducts); 
        
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                var pageProducts=parseInt(respuestas[2]);
                CopiarProductosAServidor(pageProducts,totalProducts,totalBars);                
                
            }else if(respuestas[0]=="END"){  
                alertify.success(respuestas[1]);
                
                CopiarCodigoBarrasProductosAServidor(1,totalBars);   
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

function CopiarCodigoBarrasProductosAServidor(pageProducts,totalBars){
    var idBoton="btnSubirProductos";
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('pageProducts', pageProducts); 
        form_data.append('totalBars', totalBars); 
        
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                var pageProducts=parseInt(respuestas[2]);
                CopiarCodigoBarrasProductosAServidor(pageProducts,totalBars);                
                
            }else if(respuestas[0]=="END"){  
                alertify.success(respuestas[1]);
                document.getElementById(idBoton).disabled=false;
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


function ConfirmaDescargarDesdeServidor(){
    alertify.confirm('Está seguro que desea Actulizar productos desde el Servidor?',
        function (e) {
            if (e) {
                
                ObtengaTotalProductosDescargar();
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function ObtengaTotalProductosDescargar(){
    document.getElementById("DivMensajes").innerHTML="Obteniendo Total de Registros a copiar";
    var idBoton="btnDescargarProductos";
    document.getElementById(idBoton).disabled=true;
    var form_data = new FormData();
        form_data.append('Accion', '6'); 
        
        
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                var totalProducts=parseInt(respuestas[2]);
                var totalBars=parseInt(respuestas[3]);
                if(totalProducts==0){
                    document.getElementById(idBoton).disabled=false;
                    return;
                }else{
                    CopiarProductosDesdeServidorExterno(1,totalProducts,totalBars);
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

function CopiarProductosDesdeServidorExterno(pageProducts,totalProducts,totalBars){
    var idBoton="btnDescargarProductos";
    var form_data = new FormData();
        form_data.append('Accion', '7'); 
        form_data.append('pageProducts', pageProducts); 
        form_data.append('totalProducts', totalProducts); 
        
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                var pageProducts=parseInt(respuestas[2]);
                CopiarProductosDesdeServidorExterno(pageProducts,totalProducts,totalBars);                
                
            }else if(respuestas[0]=="END"){  
                alertify.success(respuestas[1]);
                
                CopiarCodigoBarrasProductosDesdeServidorExterno(1,totalBars);   
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

function CopiarCodigoBarrasProductosDesdeServidorExterno(pageProducts,totalBars){
    var idBoton="btnDescargarProductos";
    var form_data = new FormData();
        form_data.append('Accion', '8'); 
        form_data.append('pageProducts', pageProducts); 
        form_data.append('totalBars', totalBars); 
        
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                var pageProducts=parseInt(respuestas[2]);
                CopiarCodigoBarrasProductosAServidor(pageProducts,totalBars);                
                
            }else if(respuestas[0]=="END"){  
                console.log("FIn");
                InsertarProductosNuevosDesdeTemporal();
                alertify.success(respuestas[1]);
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

function InsertarProductosNuevosDesdeTemporal(){
    document.getElementById("DivMensajes").innerHTML="Insertando Registors"; 
    var idBoton="btnDescargarProductos";
    var form_data = new FormData();
        form_data.append('Accion', '9'); 
                
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                
                InsertarBarrasNuevasDesdeTemporal();                
                
               
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

function InsertarBarrasNuevasDesdeTemporal(){
    var idBoton="btnDescargarProductos";
    var form_data = new FormData();
        form_data.append('Accion', '10'); 
                
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                
                ActualizarProductosDesdeTemporal();                
                
               
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

function ActualizarProductosDesdeTemporal(){
    var idBoton="btnDescargarProductos";
    var form_data = new FormData();
        form_data.append('Accion', '11'); 
                
        $.ajax({
        url: './procesadores/inventarios.process.php',
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
                
                ActualizarBarrasDesdeTemporal();                
                
               
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

function ActualizarBarrasDesdeTemporal(){
    var idBoton="btnDescargarProductos";
    var form_data = new FormData();
        form_data.append('Accion', '12'); 
                
        $.ajax({
        url: './procesadores/inventarios.process.php',
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


/**
 * Lista los separados
 * @param {type} Page
 * @returns {undefined}
 */
function ListarSeparados(Page=1){
    var idDiv="DivGeneralDraw";
    //document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busquedas =document.getElementById("TxtBusquedas").value;
    var FechaInicialRangos =document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos =document.getElementById("FechaFinalRangos").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('Filtro', Filtro);
        form_data.append('Busquedas', Busquedas);
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/adminInventarios.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            inicializarDial("dialItems");
            inicializarDial("dialExistencias");
            inicializarDial("dialCosto");
            inicializarDial("dialTotalVenta");
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


/**
 * Lista los separados
 * @param {type} Page
 * @returns {undefined}
 */
function VerItemsSeparado(idSeparado){
    var idDiv="DivFrmModalAcciones";
       $("#ModalAcciones").modal();     
    var form_data = new FormData();
        form_data.append('Accion', 3);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('idSeparado', idSeparado);
                        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/adminInventarios.draw.php',// se indica donde llegara la informacion del objecto
        
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


function VerAbonosSeparado(idSeparado){
    var idDiv="DivFrmModalAcciones";
       $("#ModalAcciones").modal();     
    var form_data = new FormData();
        form_data.append('Accion', 4);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('idSeparado', idSeparado);
                        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/adminInventarios.draw.php',// se indica donde llegara la informacion del objecto
        
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