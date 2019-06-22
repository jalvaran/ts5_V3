/**
 * Controlador para realizar las compras
 * JULIAN ALVARAN 2018-12-05
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */


/*
 * Abre el modal para registrar la nueva compra
 * @returns {undefined}
 */
function AbrirModalNuevoComprobante(Proceso="Nuevo"){
    $("#ModalAcciones").modal();
    var idComprobante=document.getElementById('idComprobante').value;
    
    var form_data = new FormData();
        if(Proceso=="Nuevo"){
            var Accion=1;
        }
        if(Proceso=="Editar"){
            var Accion=2;
            
        }
        form_data.append('Accion', Accion);
        form_data.append('idComprobante', idComprobante);
        $.ajax({
        url: './Consultas/BajasAltas.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmModalAcciones').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  
/**
 * Crear una compra
 * @returns {undefined}
 */
function CrearComprobante(){
    
    var idComprobanteActivo=document.getElementById('idComprobante').value;
    var Accion=document.getElementById('idFormulario').value;
    
    var Fecha = document.getElementById('TxtFecha').value;
    
    var Concepto = document.getElementById('TxtConcepto').value;
    
    if(Concepto==""){
        alertify.alert("Debe especificar un concepto");
        document.getElementById('TxtConcepto').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtConcepto').style.backgroundColor="white";
    }
    
    if(Fecha==""){
        alertify.alert("Debe seleccionar una fecha");
        document.getElementById('TxtFecha').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtFecha').style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', Accion);        
        form_data.append('Fecha', Fecha);        
        form_data.append('Concepto', Concepto);
        form_data.append('idComprobanteActivo', idComprobanteActivo);
        
    
        document.getElementById('TxtConcepto').value='';
        
    
        $.ajax({
        url: './procesadores/BajasAltas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
          var respuestas = data.split(';'); 
          if (respuestas[0] == "OK") { 
              CierraModal('ModalAcciones');
              if(Accion==1){
                var idComprobante=respuestas[1];
                alertify.success("Comprobante "+idComprobante+" creado");
                var x = document.getElementById("idComprobante");
                  var option = document.createElement("option");
                  option.text = idComprobante+" "+Concepto;
                  option.value = idComprobante;

                  x.add(option); 
                  $("#idComprobante option:last").attr('selected','selected');
                  DibujeComprobante();
              }  
              if(Accion==2){
                  var index = document.getElementById("idComprobante").selectedIndex;
                  var TextoOpcion=idComprobanteActivo+" "+respuestas[1]+" "+respuestas[2];
                  document.getElementById("idComprobante").options[index].text=TextoOpcion;
                  alertify.success("Comprobante "+idComprobanteActivo+" Editado");
              }
          
          }else{
              CierraModal('ModalAcciones');
              alertify.error("Error al crear el comprobante");
              document.getElementById('DivMensajesModulo').innerHTML=data;
          }
          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}
/**
 * Cierra una ventana modal
 * @param {type} idModal
 * @returns {undefined}
 */
function CierraModal(idModal) {
    $("#"+idModal).modal('hide');//ocultamos el modal
    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}
/**
 * Funcion para dibujar todos los componentes de una compra
 * @param {type} idCompra
 * @returns {undefined}
 */
function DibujeComprobante(idComprobante=""){
    if(document.getElementById('idComprobante').value==""){
        document.getElementById('BtnEditarCompra').disabled=true;
    }else{
        document.getElementById('BtnEditarCompra').disabled=false;
    }
    if(idComprobante==""){
        var idComprobante = document.getElementById('idComprobante').value;
        
    }
    
    DibujeItemsComprobante(idComprobante);
   
}


/**
 * Se dibujan los datos generales de una compra 
 * @param {type} idCompra
 * @returns {undefined}
 */
function DibujeItemsComprobante(idComprobante=""){
    if(idComprobante==""){
        var idComprobante = document.getElementById('idComprobante').value;
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('idComprobante', idComprobante);
        $.ajax({
        url: './Consultas/BajasAltas.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivItemsComprobantes').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
      
}


/**
 * cambia el select para realizar busquedas según el listado seleccionado
 * @returns {undefined}
 */
function ConvertirSelectBusquedas(){
    var Listado=document.getElementById('CmbListado').value;
    if(Listado==1){ //Opcion para buscar un producto
        document.getElementById('CmbBusquedas').value="";
        
        document.getElementById('Cantidad').value=1;
       
        $('#CmbBusquedas').select2({
		  
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
    
    
    if(Listado==2){ //Opcion para buscar un insumo
        document.getElementById('CmbBusquedas').value="";
        
        document.getElementById('Cantidad').value=1;
        
        $('#CmbBusquedas').select2({
            
            placeholder: 'Buscar insumo',
            ajax: {
              url: 'buscadores/insumos.search.php',
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
}
/**
 * Agrega un item a una FC
 * @returns {undefined}
 */
function AgregarItem(){
    
    var idComprobante=document.getElementById('idComprobante').value;
    var CmbListado=document.getElementById('CmbListado').value;
    var CmbBusquedas=document.getElementById('CmbBusquedas').value;    
    var TipoMovimiento = document.getElementById('TipoMovimiento').value;    
    var Cantidad = (document.getElementById('Cantidad').value);
    
    
    if(idComprobante==""){
        alertify.alert("Debe Seleccionar un comprobante");
        document.getElementById('idComprobante').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('idComprobante').style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Cantidad) || Cantidad == "" || Cantidad <= 0 ){
    
        alertify.alert("El campo Cantidad debe ser un número mayor a cero");
        document.getElementById('Cantidad').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('Cantidad').style.backgroundColor="white";
    }
    
    
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('CmbListado', CmbListado);
        form_data.append('idComprobante', idComprobante);
        form_data.append('CmbBusquedas', CmbBusquedas);
        form_data.append('TipoMovimiento', TipoMovimiento);
       
        form_data.append('Cantidad', Cantidad);
        
        
        document.getElementById('Cantidad').value=""; 
          
        $.ajax({
        url: './procesadores/BajasAltas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
          
          if (data == "OK") { 
              
                alertify.success("Item "+CmbListado+" Agregado");
                DibujeComprobante(idComprobante);
          
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
 * Elimina un item de una factura de compra
 * @param {type} Tabla
 * @param {type} idItem
 * @returns {undefined}
 */
function EliminarItem(Tabla,idItem){
        
    var form_data = new FormData();
        form_data.append('Accion', 4);
        form_data.append('Tabla', Tabla);
        form_data.append('idItem', idItem);
        $.ajax({
        url: './procesadores/BajasAltas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            alertify.error(data);
            DibujeComprobante();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

/**
 * Muestra u oculta un elemento por su id
 * @param {type} id
 * @returns {undefined}
 */

function MuestraOcultaXIDCompras(id){
    
    var estado=document.getElementById(id).style.display;
    if(estado=="none" | estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}
function ConfirmarBajaAlta(){
    
    alertify.confirm('Está seguro que desea Guardar este Comprobante?',
        function (e) {
            if (e) {
                
                GuardarComprobante();
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}
/**
 * Agrega los cargos al subtotal de los insumos
 * @param {type} event
 * @returns {undefined}
 */
function GuardarComprobante(){
    
    document.getElementById("DivItemsComprobantes").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    document.getElementById('BtnGuardarComprobante').disabled=true;
    var idComprobante = document.getElementById('idComprobante').value;
    if(idComprobante==""){
        alertify.alert("Debe Seleccionar un comprobante");
        document.getElementById('idComprobante').style.backgroundColor="pink";
        document.getElementById('BtnGuardarComprobante').disabled=false;
        return;
    }else{
        document.getElementById('idComprobante').style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('idComprobante', idComprobante);
        
        $.ajax({
        url: './procesadores/BajasAltas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                var mensaje=respuestas[1];
                CerrarComprobante();
                alertify.success(mensaje);
                
            }else{
                alertify.alert(data);
                document.getElementById('BtnGuardarComprobante').disabled=false;
            }
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}

/**
 * Agrega los cargos al subtotal de los insumos
 * @param {type} event
 * @returns {undefined}
 */
function CerrarComprobante(){
    
    
    document.getElementById('BtnGuardarComprobante').disabled=true;
    var idComprobante = document.getElementById('idComprobante').value;
    if(idComprobante==""){
        alertify.alert("Debe Seleccionar un comprobante");
        document.getElementById('idComprobante').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('idComprobante').style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', '6'); 
        form_data.append('idComprobante', idComprobante);
        
        $.ajax({
        url: './procesadores/BajasAltas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                
                var mensaje=respuestas[1];
                
                var x = document.getElementById("idComprobante");
                x.remove(x.selectedIndex);
                document.getElementById('BtnGuardarComprobante').disabled=false;
                alertify.alert(mensaje);
                LimpiarDivs();
                
            }else{
                alertify.alert(data);
                document.getElementById('BtnGuardarComprobante').disabled=false;
            }
            
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}

/**
 * Limpia los divs de la compra despues de guardar
 * @returns {undefined}
 */
function LimpiarDivs(){
    document.getElementById('DivItemsComprobantes').innerHTML='';
    
}



function SeleccioneAccionFormularios(){
    var Accion = document.getElementById("idFormulario").value;
        
    if(Accion==1 || Accion==2){
        CrearComprobante();
    }
}


document.getElementById('BtnMuestraMenuLateral').click();
ConvertirSelectBusquedas();

//$('#ValorUnitario').mask('1.999.999.##0,00', {reverse: true});
//$('#Cantidad').mask('9.999.##0,00', {reverse: true});