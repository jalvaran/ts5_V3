/**
 * Controlador para el pos de restaurantes
 * JULIAN ALVARAN 2020-01-30
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */


document.getElementById('BtnMuestraMenuLateral').click();

$('#idCliente').select2({
            
    placeholder: 'Clientes Varios',
    ajax: {
      url: 'buscadores/clientes.search.php',
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
  
  $('#CmbBusquedaItems').select2({
		  
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
  
  /**
 * Muestra u oculta un elemento de acuerdo a su id
 * @param {type} id
 * @returns {undefined}
 */
function MuestraOculta(id){
    
    var estado=document.getElementById(id).style.display;
    if(estado=="none" || estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}

function AccionesPOS(){
    var Accion = document.getElementById("idFormulario").value;
        
    if(Accion==100){
        CrearTercero('ModalAccionesPOS','BntModalPOS');
    }
    if(Accion==103){
        var idCliente = document.getElementById("idCliente").value;
        EditarTercero('ModalAccionesPOS','BntModalPOS',idCliente,"clientes");
    }
}

function EditarTerceroPOS(){
    var idCliente = document.getElementById("idCliente").value;
    ModalEditarTercero('ModalAccionesPOS','DivFrmPOS',idCliente,"clientes");
}