/**
 * Controlador para administrar los registros de una tabla en una base de datos
 * JULIAN ANDRES ALVARAN
 * 2020-01-26
 */
// variables globales para paginacion
var limit=10;
var page=1;

document.getElementById("BtnMuestraMenuLateral").click(); //da click sobre el boton que esconde el menu izquierdo de la pagina principal

$('#cmbDataBase').select2(); //Convertimos el selector de las bases de datos en un select2

/**
 * Funcion que lista las tablas de una base de datos
 * @returns {undefined}
 */

function ListTables(){
    
    document.getElementById("DivTablasBaseDatos").innerHTML='<div id="GifProcess">procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var cmbDataBase =document.getElementById("cmbDataBase").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('cmbDataBase', cmbDataBase);// pasamos en in indice llamado cmbDataBase el nombre de la base de datos'
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admindb.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById('DivTablasBaseDatos').innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
             },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById('DivTablasBaseDatos').innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function muestraRegistros(tabla){
    
    var cmbDataBase =document.getElementById("cmbDataBase").value;
    var Busqueda =document.getElementById("TxtBusquedas").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('cmbDataBase', cmbDataBase);// pasamos en in indice llamado cmbDataBase el nombre de la base de datos'
        form_data.append('tableDataBase', tabla);// pasamos en un indice llamado tabla el nombre de la base de datos
        form_data.append('limit', limit);// enviamos la variable global limit
        form_data.append('page', page);// enviamos la variable global page
        form_data.append('Busqueda', Busqueda);// enviamos la variable global page
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admindb.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById('DivDrawTables').innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            dibujaPaginacion(tabla);
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function dibujaPaginacion(tabla){
    
    var cmbDataBase =document.getElementById("cmbDataBase").value;
    var Busqueda =document.getElementById("TxtBusquedas").value;
    var form_data = new FormData();
        form_data.append('Accion', 3);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('cmbDataBase', cmbDataBase);// pasamos en in indice llamado cmbDataBase el nombre de la base de datos'
        form_data.append('tableDataBase', tabla);// pasamos en un indice llamado tabla el nombre de la base de datos
        form_data.append('limit', limit);// enviamos la variable global limit
        form_data.append('page', page);// enviamos la variable global page
        form_data.append('Busqueda', Busqueda);// enviamos la variable global page
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admindb.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById('DivPager').innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
             },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function DisminuirPagina(tabla){
   
        page=page-1;
        muestraRegistros(tabla);
  
   
}

function AumentarPagina(tabla){
   
   page=page+1;
    
   muestraRegistros(tabla);
}