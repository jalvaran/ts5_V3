/**
 * Controlador para administrar la plataforma domi
 * JULIAN ANDRES ALVARAN
 * 2020-02-16
 */
var idListado=1;
document.getElementById("BtnMuestraMenuLateral").click(); //da click sobre el boton que esconde el menu izquierdo de la pagina principal

function CopiarAlPortapapelesID(idElemento){
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(idElemento).text()).select();
    document.execCommand("copy");
    alertify.success("Texto Copiado: "+$(idElemento).text());
    $temp.remove();
}

function AbreModal(idModal){
    $("#"+idModal).modal();
}

function MostrarListadoSegunID(){
    if(idListado==1){
        ListarLocales();
    }
    if(idListado==2){
        ListarClasificacion();
    }
    if(idListado==3){
        ListarProductos();
    }
    if(idListado==4){
        ListarPedidos();
    }
}
function ListarLocales(Page=1){
    var idDiv="DivDraw";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var Busquedas =document.getElementById("TxtBusquedas").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Page', Page);
        form_data.append('Busquedas', Busquedas);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/ts_domi.draw.php',// se indica donde llegara la informacion del objecto
        
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

function FormularioCrearEditarLocal(TipoFormulario=1,idEditar=0){
    var idDiv="DivDraw";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
        
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('TipoFormulario', TipoFormulario);
        form_data.append('idEditar', idEditar);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/ts_domi.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; 
            
             },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

 
function CrearEditarLocal(TipoFormulario=1,idEditar=0){
    
    var idBoton='btnGuardarLocal';
    document.getElementById(idBoton).disabled=true;
    var cmbCategoriaLocal=document.getElementById("cmbCategoriaLocal").value;    
    var NombreLocal=document.getElementById("NombreLocal").value;    
    var cmbEstadoLocal=document.getElementById("cmbEstadoLocal").value; 
    var Direccion=document.getElementById("Direccion").value;   
    var Telefono=document.getElementById("Telefono").value;   
    var Descripcion=document.getElementById("Descripcion").value;   
     
    var form_data = new FormData();
        form_data.append('Accion', '1'); 
        form_data.append('cmbCategoriaLocal', cmbCategoriaLocal);
        form_data.append('NombreLocal', NombreLocal);
        form_data.append('cmbEstadoLocal', cmbEstadoLocal);
        form_data.append('Direccion', Direccion);
        form_data.append('Telefono', Telefono);
        form_data.append('Descripcion', Descripcion);
        form_data.append('Fondo', $('#Fondo').prop('files')[0]);
        form_data.append('TipoFormulario', TipoFormulario);
        form_data.append('idEditar', idEditar);
        
        $.ajax({
        url: './procesadores/ts_domi.process.php',
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
                document.getElementById(idBoton).disabled=false;
                ListarLocales();
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
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
      });
    
    }
    
 function ConfirmaGuardarEditarLocal(TipoFormulario=1,idEditar=0){
    alertify.confirm('Está seguro que desea Guardar?',
        function (e) {
            if (e) {
                
                CrearEditarLocal(TipoFormulario,idEditar);
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

function OcultaXID(id){
    
    
    document.getElementById(id).style.display="none";
    
    
}
    
function MarqueErrorElemento(idElemento){
    
    if(idElemento==undefined){
       return; 
    }
    document.getElementById(idElemento).style.backgroundColor="pink";
    document.getElementById(idElemento).focus();
}

function DesMarqueErrorElemento(idElemento){
    
    if(idElemento==undefined){
       return; 
    }
    document.getElementById(idElemento).style.backgroundColor="white";
    
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
        ListarLocales(Page);
    }
    if(Funcion==2){
        ListarClasificacion(Page);
    }
    if(Funcion==3){
        ListarProductos(Page);
    }
    if(Funcion==4){
        listarPedidos(Page);
    }
    
}

MostrarListadoSegunID();

