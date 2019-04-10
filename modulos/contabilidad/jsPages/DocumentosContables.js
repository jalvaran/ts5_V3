/**
 * Controlador para Documentos contables
 * JULIAN ALVARAN 2019-04-10
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
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
 * Crea el formulario para guardar o editar un documento
 * @param {type} Proceso
 * @returns {undefined}
 */
function AbrirModalNuevoDocumento(Proceso="Nuevo"){
    $("#ModalAcciones").modal();
    var idDocumento=document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        if(Proceso=="Nuevo"){
            var Accion=1;
        }
        if(Proceso=="Editar"){
            var Accion=2;
            
        }
        form_data.append('Accion', Accion);
        form_data.append('idDocumento', idDocumento);
        $.ajax({
        url: './Consultas/DocumentosContables.draw.php',
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
 * Elije una accion a ejecutar de acuerdo a un formulario
 * @returns {undefined}
 */
function SeleccioneAccionFormularios(){
    var Accion = document.getElementById("idFormulario").value;
    
    if(Accion==1 || Accion==2){
        CrearEditarDocumento(Accion);
    }
    
    if(Accion==100){
        CrearTercero('ModalAcciones','BntModalAcciones');
    }
}
/**
 * Crear o editar una accion
 * @param {type} idAccion->1 para Crear 2 para Editar
 * @returns {undefined}
 */
function CrearEditarDocumento(Accion){ 
    
    var idDocumentoActivo=document.getElementById('idDocumento').value;
    var Fecha = document.getElementById('TxtFecha').value;
    var TipoDocumento = document.getElementById('CmbTipoDocumento').value;
    var Observaciones = document.getElementById('TxtObservaciones').value;
    var CmbEmpresa = document.getElementById('CmbEmpresa').value;
    var CmbSucursal = document.getElementById('CmbSucursal').value;
    var CmbCentroCosto = document.getElementById('CmbCentroCosto').value;
    
    
    if(Observaciones==""){
        alertify.alert("El campo Observaciones no puede estar vacío");
        document.getElementById('TxtObservaciones').style.backgroundColor="pink";
        return;
    }else{
        document.getElementById('TxtObservaciones').style.backgroundColor="white";
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
        form_data.append('TxtFecha', Fecha);
        form_data.append('CmbTipoDocumento', TipoDocumento);
        form_data.append('idDocumentoActivo', idDocumentoActivo);
        form_data.append('TxtObservaciones', Observaciones);
        form_data.append('CmbEmpresa', CmbEmpresa);
        form_data.append('CmbSucursal', CmbSucursal);
        form_data.append('CmbCentroCosto', CmbCentroCosto);
            
        document.getElementById('TxtObservaciones').value='';
        
    
        $.ajax({
        url: './procesadores/DocumentosContables.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
          var respuestas = data.split(';'); 
          if (respuestas[0] == "OK"){ 
              if(Accion==1){
                var idDocumento=respuestas[1];
                var TextoComboDocumento=respuestas[2];
                alertify.success("Documento "+idDocumento+" creado");
                var x = document.getElementById("idDocumento");
                  var option = document.createElement("option");
                  option.text = TextoComboDocumento;
                  option.value = idDocumento;

                  x.add(option); 
                  $("#idDocumento option:last").attr('selected','selected');
                  DibujeDocumento();
              }  
              if(Accion==2){
                  var index = document.getElementById("idDocumento").selectedIndex;
                  var TextoOpcion=respuestas[2];
                  document.getElementById("idDocumento").options[index].text=TextoOpcion;
                  alertify.success(respuestas[1]);
              }
              CierraModal('ModalAcciones');
          }else{
              alertify.alert("Error: "+data);
              
          }
          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  

}


function DibujeDocumento(idDocumento){
    
    if(document.getElementById('idDocumento').value==""){
        document.getElementById('BtnEditar').disabled=true;
    }else{
        document.getElementById('BtnEditar').disabled=false;
    }
    if(idDocumento==""){
        var idDocumento = document.getElementById('idDocumento').value;
        
    }
    
    DibujeItems(idDocumento);
    DibujeTotales(idDocumento);
    
}
/**
 * Inicializa el modulo
 * @returns {undefined}
 */
function initModule(){
    document.getElementById("BtnMuestraMenuLateral").click();
    
    $('#Tercero').select2({
		  
        placeholder: 'Selecciona un Tercero',
        ajax: {
          url: 'buscadores/proveedores.search.php',
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
      
      $('#CuentaPUC').select2({
		  
        placeholder: 'Selecciona un Cuenta',
        ajax: {
          url: 'buscadores/CuentaPUC.search.php',
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

initModule();
