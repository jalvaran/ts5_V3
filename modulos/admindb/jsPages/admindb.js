/**
 * Controlador para administrar los registros de una tabla en una base de datos
 * JULIAN ANDRES ALVARAN
 * 2020-01-26
 */

document.getElementById("BtnMuestraMenuLateral").click(); //da click sobre el boton que esconde el menu izquierdo de la pagina principal

$('#cmbDataBase').select2(); //Convertimos el selector de las bases de datos en un select2

/**
 * Funcion que lista las tablas de una base de datos
 * @returns {undefined}
 */

function ListTables(){
    
    var cmbDataBase =document.getElementById("cmbDataBase").value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);
        form_data.append('cmbDataBase', cmbDataBase);
        $.ajax({
        url: 'Consultas/admindb.draw.php',
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){            
            document.getElementById('DivTablasBaseDatos').innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

