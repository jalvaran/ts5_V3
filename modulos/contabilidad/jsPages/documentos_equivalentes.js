/**
 * Controlador para Documentos contables
 * JULIAN ALVARAN 2019-04-10
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */

function MuestraXID(id){
    
    
    document.getElementById(id).style.display="block";
    
    
}


function OcultaXID(id){
    
    
    document.getElementById(id).style.display="none";
    
    
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
        url: './Consultas/documentos_equivalentes.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmModalAcciones').innerHTML=data;
            $('#tercero_id').select2({
            
            placeholder: 'Selecciona una Tercero',
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
        CrearEditarDocumento();
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
function CrearEditarDocumento(){ 
    
    var idDocumentoActivo=document.getElementById('idDocumento').value;
    var Fecha = document.getElementById('TxtFecha').value;
    var resolucion_documento_equivalente = document.getElementById('resolucion_documento_equivalente').value;
    var Observaciones = document.getElementById('TxtObservaciones').value;
    var CmbEmpresa = document.getElementById('CmbEmpresa').value;
    var CmbSucursal = document.getElementById('CmbSucursal').value;
    var CmbCentroCosto = document.getElementById('CmbCentroCosto').value;
    var tercero_id = document.getElementById('tercero_id').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);        
        form_data.append('TxtFecha', Fecha);
        form_data.append('resolucion_documento_equivalente', resolucion_documento_equivalente);
        form_data.append('idDocumentoActivo', idDocumentoActivo);
        form_data.append('TxtObservaciones', Observaciones);
        form_data.append('CmbEmpresa', CmbEmpresa);
        form_data.append('CmbSucursal', CmbSucursal);
        form_data.append('CmbCentroCosto', CmbCentroCosto);
        form_data.append('tercero_id', tercero_id);
              
        $.ajax({
        url: './procesadores/documentos_equivalentes.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
          var respuestas = data.split(';'); 
          if (respuestas[0] == "OK"){ 
              
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

/**
 * Agrega un movimiento a un documento equivalente
 * @returns {undefined}
 */
function agregar_item(){ 
       
    var idDocumento=document.getElementById('idDocumento').value;
    var cantidad_item = document.getElementById('cantidad_item').value;
    var descripcion_item = document.getElementById('descripcion_item').value;
    var valor_unitario_item = document.getElementById('valor_unitario_item').value;
    var valor_total_item = document.getElementById('valor_total_item').value;
    var cuenta_item = document.getElementById('cuenta_item').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 3);        
        form_data.append('idDocumento', idDocumento);
        form_data.append('cantidad_item', cantidad_item);
        form_data.append('descripcion_item', descripcion_item );
        form_data.append('valor_unitario_item', valor_unitario_item);
        form_data.append('valor_total_item', valor_total_item );
        form_data.append('cuenta_item', cuenta_item );
             
         
        $.ajax({
        url: './procesadores/documentos_equivalentes.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
          var respuestas = data.split(';'); 
          if (respuestas[0] == "OK"){ 
                
                document.getElementById("descripcion_item").value='';
                document.getElementById("valor_unitario_item").value='';
                document.getElementById("valor_total_item").value='';
                document.getElementById("cantidad_item").value='1';
                             
                alertify.success(respuestas[1]);                
                document.getElementById('select2-cuenta_item-container').innerHTML="Seleccione una Cuenta";
                document.getElementById('cuenta_item').value="";
                dibuje_items_documento_equivalente();
          }else if(respuestas[0]=='E1'){
                alertify.error(respuestas[1]);      
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

/**
 * Dibuja el documento equivalente
 * @param {type} idDocumento
 * @returns {undefined}
 */
function DibujeDocumento(){
    
    var idDocumento = document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('idDocumento', idDocumento);
        $.ajax({
        url: './Consultas/documentos_equivalentes.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('div_documento_equivalente').innerHTML=data;
            $('#cuenta_item').select2({
            
                placeholder: 'Selecciona una cuenta',
                ajax: {
                  url: 'buscadores/cuenta_puc_documentos_contables.search.php?tipo=1',
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
              dibuje_items_documento_equivalente();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


/**
 * Guarda un documento contable
 * @param {type} idDocumento
 * @returns {undefined}
 */
function GuardarDocumento(idDocumento=''){
    document.getElementById('BtnGuardar').disabled=true;
    document.getElementById('BtnGuardar').value="Guardando...";
    if(idDocumento==''){
        var idDocumento = document.getElementById('idDocumento').value;
    }
    var cuenta_total_documento = document.getElementById('cuenta_total_documento').value;    
    
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('idDocumento', idDocumento);
        form_data.append('cuenta_total_documento', cuenta_total_documento);
        
        $.ajax({
        url: './procesadores/documentos_equivalentes.process.php',
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
                
                var x = document.getElementById("idDocumento");
                x.remove(x.selectedIndex);
                
                alertify.alert(mensaje);
            }else if(respuestas[0]=='E1'){
                alertify.error(respuestas[1]);    
            }else{
                alertify.alert("Error: <br>"+data);
                document.getElementById('BtnGuardar').disabled=false;
                document.getElementById('BtnGuardar').value="Guardar";
            }
            
            DibujeDocumento();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}
/**
 * Copia los movimientos de un documento a otro
 * @returns {undefined}
 */
function CopiarDocumento(){
    var idDocumento = document.getElementById('idDocumento').value;
    var idDocumentoACopiar = document.getElementById('idDocumentoAcciones').value;
    var TipoDocumento = document.getElementById('CmbTipoDocumentoAcciones').value;
    if(idDocumento==''){
        
        alertify.error("Debe Seleccionar un Documento");
        document.getElementById("idDocumento").style.backgroundColor="pink";   
        
        return;
    }else{
        document.getElementById("idDocumento").style.backgroundColor="white";
    }
    
    if(!$.isNumeric(idDocumentoACopiar) ||  idDocumentoACopiar<=0){
        
        alertify.error("Valor incorrecto");
        document.getElementById("idDocumentoAcciones").style.backgroundColor="pink";   
        
        return;
    }else{
        document.getElementById("idDocumentoAcciones").style.backgroundColor="white";
    }
    
    var form_data = new FormData();
        form_data.append('Accion', 6);
        form_data.append('idDocumento', idDocumento);
        form_data.append('idDocumentoACopiar', idDocumentoACopiar);
        form_data.append('TipoDocumento', TipoDocumento);
        $.ajax({
        url: './procesadores/DocumentosContables.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            if(data=='OK'){
                alertify.success("Documento Copiado");
            }else{
                alertify.alert(data);
            }
            
            DibujeDocumento();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function EditarTercero(idItem,idSelect){
    
    var Tercero = document.getElementById(idSelect).value;
    
    var form_data = new FormData();
        form_data.append('Accion', 9);
        form_data.append('idItem', idItem);
        form_data.append('Tercero', Tercero);
        
        $.ajax({
        url: './procesadores/DocumentosContables.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            if(data=='OK'){
                alertify.success("Tercero Editado");
            }else{
                alertify.alert(data);
            }
            
            DibujeDocumento();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
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
      
      $('#CuentaPUC').bind('change', function() {
        VerifiqueSolicitaBase();
      });
}


function AbrirDocumento(idDocumento){
    var form_data = new FormData();
        form_data.append('Accion', 14);
        form_data.append('idDocumento', idDocumento);
        
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
            if(respuestas[0]=='OK'){
                var idDocumento=respuestas[2];
                var TextoComboDocumento=respuestas[3];
                alertify.success(respuestas[1]);
                var x = document.getElementById("idDocumento");
                var option = document.createElement("option");
                option.text = TextoComboDocumento;
                option.value = idDocumento;
                x.add(option); 
                $("#idDocumento option:last").attr('selected','selected');
                DibujeDocumento();
            }else if(respuestas[0]=='E1'){
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

function editar_registro_documento_equivalente(tabla_id,item_id,campo_editar,campo_valor,obtener_valor='1'){
    if(obtener_valor==1){
        var nuevo_valor = document.getElementById(campo_valor).value;
    }else{
        var nuevo_valor = campo_valor;
    }
    var idDocumento = document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 2);
        form_data.append('tabla_id', tabla_id);
        form_data.append('item_id', item_id);
        form_data.append('campo_editar', campo_editar);
        form_data.append('nuevo_valor', nuevo_valor);
        form_data.append('idDocumento', idDocumento);
        
        $.ajax({
        url: './procesadores/documentos_equivalentes.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=='OK'){
                alertify.success(respuestas[1]);
                if(tabla_id==1){
                    DibujeDocumento();
                }
                if(tabla_id==2){
                    dibuje_items_documento_equivalente();
                }
                if(tabla_id==3){
                    dibuje_retenciones();
                    dibuje_total_documento_equivalente();
                }
            }else if(respuestas[0]=='E1'){
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


function frm_editar_tercero_documento(){
    $("#ModalAcciones").modal();
    var idDocumento = document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('idDocumento', idDocumento);
        $.ajax({
        url: './Consultas/documentos_equivalentes.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmModalAcciones').innerHTML=data;
            $('#tercero_id_documento').select2({
            
            placeholder: 'Selecciona una Tercero',
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
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


function dibuje_items_documento_equivalente(){
    
    var idDocumento = document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        form_data.append('idDocumento', idDocumento);
        $.ajax({
        url: './Consultas/documentos_equivalentes.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('div_items').innerHTML=data;
            $('.ts_select2').select2({
            
                placeholder: 'Selecciona una cuenta',
                ajax: {
                  url: 'buscadores/cuenta_puc_documentos_contables.search.php?tipo=1',
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
              dibuje_total_documento_equivalente();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


function dibuje_total_documento_equivalente(){
    
    var idDocumento = document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 5);
        form_data.append('idDocumento', idDocumento);
        $.ajax({
        url: './Consultas/documentos_equivalentes.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('div_totales_documento').innerHTML=data;
            $('.ts_select2').select2({
            
                placeholder: 'Selecciona una cuenta',
                ajax: {
                  url: 'buscadores/cuenta_puc_documentos_contables.search.php?tipo=2',
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
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

function calcule_total_item(){
    var cantidad_item = document.getElementById('cantidad_item').value;
    var valor_unitario_item = document.getElementById('valor_unitario_item').value;    
    document.getElementById('valor_total_item').value=cantidad_item*valor_unitario_item;
}

function calcule_retencion(){
    var porcentaje = document.getElementById('porcentaje_retenido').value;
    var base = document.getElementById('base_retencion').value;    
    document.getElementById('valor_retencion').value=Math.round((porcentaje/100)*base,2);
}

function frm_retenciones(){
    $("#ModalAcciones").modal();
    var idDocumento=document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 6);
        form_data.append('idDocumento', idDocumento);
        $.ajax({
        url: './Consultas/documentos_equivalentes.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivFrmModalAcciones').innerHTML=data;
            $('.ts_select2').select2({
            
                placeholder: 'Selecciona una cuenta',
                ajax: {
                  url: 'buscadores/cuenta_puc_documentos_contables.search.php?tipo=3',
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
              dibuje_retenciones();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

/**
 * Agrega una retencion a un documento equivalente
 * @returns {undefined}
 */
function agregar_retencion(){ 
       
    var idDocumento=document.getElementById('idDocumento').value;
    var porcentaje_retenido = document.getElementById('porcentaje_retenido').value;    
    var cuenta_retencion = document.getElementById('cuenta_retencion').value;
    var retencion_asumida = document.getElementById('retencion_asumida').value;
    
    
    var form_data = new FormData();
        form_data.append('Accion', 4);        
        form_data.append('idDocumento', idDocumento);
        form_data.append('porcentaje_retenido', porcentaje_retenido);
        form_data.append('cuenta_retencion', cuenta_retencion );
        form_data.append('retencion_asumida', retencion_asumida );
         
        $.ajax({
        url: './procesadores/documentos_equivalentes.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
          var respuestas = data.split(';'); 
          if (respuestas[0] == "OK"){ 
                
                document.getElementById("porcentaje_retenido").value='';
                document.getElementById("valor_retencion").value='';
                alertify.success(respuestas[1]);                
                
                dibuje_retenciones();
                dibuje_total_documento_equivalente();
          }else if(respuestas[0]=='E1'){
                alertify.error(respuestas[1]);      
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

function dibuje_retenciones(){
    
    var idDocumento = document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 7);
        form_data.append('idDocumento', idDocumento);
        $.ajax({
        url: './Consultas/documentos_equivalentes.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('div_retenciones_documento').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

initModule();
