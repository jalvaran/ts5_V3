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

/**
 * Agrega los cargos al subtotal de los insumos
 * @param {type} event
 * @returns {undefined}
 */
function GuardarCompra(idCompra=''){
    document.getElementById('BtnGuardarCompra').disabled=true;
    if(idCompra==''){
        var idCompra = document.getElementById('idCompra').value;
    }
        
    var CmbTipoPago = document.getElementById("CmbTipoPago").value;
    var CmbCuentaOrigen = document.getElementById("CmbCuentaOrigen").value;
    var CmbCuentaPUCCXP = document.getElementById("CmbCuentaPUCCXP").value;
    var TxtFechaProgramada = document.getElementById("TxtFechaProgramada").value;
    var CmbTraslado = document.getElementById("CmbTraslado").value;
    
    
    if(TxtFechaProgramada==''){
        alertify.alert("El campo fecha programada no puede estar vacío");
        document.getElementById("TxtFechaProgramada").style.backgroundColor="pink";
        return;
    }else{
        document.getElementById("TxtFechaProgramada").style.backgroundColor="white";
    }
    
    
    document.getElementById("TxtFechaProgramada").value='';
    var form_data = new FormData();
        form_data.append('Accion', '9'); 
        form_data.append('idCompra', idCompra);
        form_data.append('CmbTipoPago', CmbTipoPago);
        form_data.append('CmbCuentaOrigen', CmbCuentaOrigen);
        form_data.append('CmbCuentaPUCCXP', CmbCuentaPUCCXP);
        form_data.append('TxtFechaProgramada', TxtFechaProgramada);
        form_data.append('CmbTraslado', CmbTraslado);
        $.ajax({
        url: './procesadores/Compras.process.php',
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
                LimpiarDivs();
                var x = document.getElementById("idCompra");
                x.remove(x.selectedIndex);
                document.getElementById('BtnEditarCompra').disabled=true;
                alertify.alert(mensaje);
                
            }else{
                alertify.error(data,10000);
                document.getElementById('BtnGuardarCompra').disabled=false;
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
 * Copia los items desde una orden de compra
 * @param {type} idOrdenCompra
 * @returns {undefined}
 */
function CopiarItemsDesdeOrden(idOrdenCompra=''){
    var idCompra = document.getElementById('idCompra').value;
    if(idOrdenCompra==''){
        var idOrdenCompra = document.getElementById('idCompraAcciones').value;
    }
        
        
    if(idCompra==''){
        alertify.alert("Debes seleccionar una compra");
        document.getElementById("idCompra").style.backgroundColor="pink";
        return;
    }else{
        document.getElementById("idCompra").style.backgroundColor="white";
    }
    
    if(idOrdenCompra==''){
        alertify.alert("Debes digitar una valor");
        document.getElementById("idCompraAcciones").style.backgroundColor="pink";
        return;
    }else{
        document.getElementById("idCompraAcciones").style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', '10'); 
        form_data.append('idCompra', idCompra);
        form_data.append('idOrdenCompra', idOrdenCompra);
                
        document.getElementById("idCompraAcciones").value='';
        $.ajax({
        url: './procesadores/Compras.process.php',
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
                alertify.success(mensaje);
                
                
            }else{
                alertify.error(data,10000);
                
            }
            DibujeCompra();
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}

function CopiarItemsDesdeOrdenVerificada(idOrdenCompra=''){
    var idCompra = document.getElementById('idCompra').value;
    if(idOrdenCompra==''){
        var idOrdenCompra = document.getElementById('idCompraAcciones').value;
    }
        
        
    if(idCompra==''){
        alertify.alert("Debes seleccionar una compra");
        document.getElementById("idCompra").style.backgroundColor="pink";
        return;
    }else{
        document.getElementById("idCompra").style.backgroundColor="white";
    }
    
    if(idOrdenCompra==''){
        alertify.alert("Debes digitar una valor");
        document.getElementById("idCompraAcciones").style.backgroundColor="pink";
        return;
    }else{
        document.getElementById("idCompraAcciones").style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', '15'); 
        form_data.append('idCompra', idCompra);
        form_data.append('idOrdenCompra', idOrdenCompra);
                
        document.getElementById("idCompraAcciones").value='';
        $.ajax({
        url: './procesadores/Compras.process.php',
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
                alertify.success(mensaje);
                
                
            }else{
                alertify.alert(data);
                
            }
            DibujeCompra();
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
    document.getElementById('DivItemsCompra').innerHTML='';
    document.getElementById('DivTotalesCompra').innerHTML='';
}

/**
 * Busca el precio de venta y costo de un producto
 * @returns {undefined}
 */
function BusquePrecioVentaCosto(){
   
    var listado = document.getElementById('CmbListado').value;
    var Codigo = document.getElementById('CodigoBarras').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 5);
        form_data.append('listado', listado);
        form_data.append('Codigo', Codigo);
        $.ajax({
        url: './Consultas/Compras.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
            var respuestas = data.split(';');
            if(respuestas[0]=='OK'){
                document.getElementById('ValorUnitario').value=respuestas[1];
                document.getElementById('PrecioVenta').value=respuestas[2];
            }else{
                alertify.alert("Error "+ data);
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
      
}

function AplicarDescuentoItem(idItem){
    var idCaja="TxtDescuentoItem_"+idItem;
    var idBoton="BtnEditarDescuento_"+idItem;
    var Descuento=document.getElementById(idCaja).value;
    var idCompra = document.getElementById('idCompra').value;
    document.getElementById(idBoton).disabled=true;  
        
    if(Descuento==''){
        alertify.alert("El campo Descuento no puede estar vacío");
        document.getElementById(idCaja).style.backgroundColor="pink";
        document.getElementById(idBoton).disabled=false;
        return;
    }else{
        document.getElementById(idCaja).style.backgroundColor="white";
    }
            
    var form_data = new FormData();
        form_data.append('Accion', '11'); 
        form_data.append('idCompra', idCompra);
        form_data.append('idItem', idItem);
        form_data.append('Descuento', Descuento);
                
        
        $.ajax({
        url: './procesadores/Compras.process.php',
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
                alertify.success(mensaje);
                
                
            }else if(respuestas[0]=="E1"){
                var mensaje=respuestas[1];
                alertify.error(mensaje);             
                
            }else{
                alertify.alert(data);
            }
            document.getElementById(idBoton).disabled=false;
            DibujeCompra();
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
}
/**
 * Copia una factura de compra
 * @param {type} idOrdenCompra
 * @returns {undefined}
 */
function CopiarFacturaCompra(idFacturaCopiar=''){
    var idCompra = document.getElementById('idCompra').value;
    if(idFacturaCopiar==''){
        var idFacturaCopiar = document.getElementById('idCompraAcciones').value;
    }
        
        
    if(idCompra==''){
        alertify.alert("Debes seleccionar una compra");
        document.getElementById("idCompra").style.backgroundColor="pink";
        return;
    }else{
        document.getElementById("idCompra").style.backgroundColor="white";
    }
    
    if(idFacturaCopiar==''){
        alertify.alert("Debe digitar una valor");
        document.getElementById("idCompraAcciones").style.backgroundColor="pink";
        return;
    }else{
        document.getElementById("idCompraAcciones").style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', '12'); 
        form_data.append('idCompra', idCompra);
        form_data.append('idFacturaCopiar', idFacturaCopiar);
                
        document.getElementById("idCompraAcciones").value='';
        $.ajax({
        url: './procesadores/Compras.process.php',
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
                alertify.success(mensaje);
                
                
            }else{
                alertify.error(data,10000);
                
            }
            DibujeCompra();
            //DibujeTotalesCompra(idCompra);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
    
}

function EditarCostoUnitario(idCaja,idTabla,idItem){
    
    var Valor = document.getElementById(idCaja).value;
    
    if(Valor==''){
        
        alertify.error("El valor no puede estar vacío");
        document.getElementById(idCaja).style.backgroundColor="pink"; 
        
        return;
    }else{
        document.getElementById(idCaja).style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Valor) ||  Valor<=0){
        
        alertify.error("El Valor debe se un número mayor a Cero");
        document.getElementById(idCaja).style.backgroundColor="pink";   
        
        return;
    }else{
        document.getElementById(idCaja).style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 13);
        form_data.append('idItem', idItem);
        form_data.append('Valor', Valor);
        form_data.append('idTabla', idTabla);
        $.ajax({
        url: './procesadores/Compras.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            if(data=='OK'){
                alertify.success("Valor Editado");
            }else{
                alertify.alert(data);
            }
            
            DibujeCompra();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function EditarCantidadItem(idCaja,idTabla,idItem){
    
    var Valor = document.getElementById(idCaja).value;
    
    if(Valor==''){
        
        alertify.error("El valor no puede estar vacío");
        document.getElementById(idCaja).style.backgroundColor="pink"; 
        
        return;
    }else{
        document.getElementById(idCaja).style.backgroundColor="white";
    }
    
    if(!$.isNumeric(Valor) ||  Valor<=0){
        
        alertify.error("El Valor debe se un número mayor a Cero");
        document.getElementById(idCaja).style.backgroundColor="pink";   
        
        return;
    }else{
        document.getElementById(idCaja).style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 14);
        form_data.append('idItem', idItem);
        form_data.append('Valor', Valor);
        form_data.append('idTabla', idTabla);
        $.ajax({
        url: './procesadores/Compras.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            if(data=='OK'){
                alertify.success("Cantidad Editada");
            }else{
                alertify.alert(data);
            }
            
            DibujeCompra();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
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