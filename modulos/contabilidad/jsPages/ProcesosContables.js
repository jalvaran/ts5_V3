/**
 * Controlador para los procesos contables
 * JULIAN ALVARAN 2020-03-18
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
function initModule(){
    document.getElementById("BtnMuestraMenuLateral").click();
    
}

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
function IniciaCierreContable(){
    var idDiv="DivDrawTables";
    var idEmpresa=document.getElementById('idEmpresa').value;
    var CmbAnio=document.getElementById('CmbAnio').value;
    var idDocumento=document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('idEmpresa', idEmpresa);
        form_data.append('CmbAnio', CmbAnio);
        form_data.append('idDocumento', idDocumento);
        
        $.ajax({
        url: './Consultas/ProcesosContables.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  


function DibujeAgrupacionCuentas(Accion){
    var idDiv="DivDrawCuentas";
    var idEmpresa=document.getElementById('idEmpresa').value;
    var CmbAnio=document.getElementById('CmbAnio').value;
    var idDocumento=document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', Accion);
        form_data.append('idEmpresa', idEmpresa);
        form_data.append('CmbAnio', CmbAnio);
        form_data.append('idDocumento', idDocumento);
        
        $.ajax({
        url: './Consultas/ProcesosContables.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            
            $('.SelectTercero').select2({
		
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
function EjecutarProcesoSegunTipo(){
    var cmbTipoProceso = document.getElementById("cmbTipoProceso").value;
    
    if(cmbTipoProceso==1 ){
        MuestreAuditoriaSegunTipo();
    }
    
    if(cmbTipoProceso==2){
        IniciaCierreContable();
    }
}


function ConfirmaCierreCuentasResultados(){
    var idBoton='BtnCerrarCuentasResultado';
    document.getElementById(idBoton).disabled=true;
    document.getElementById(idBoton).value="Cerrando...";
    
    alertify.confirm('Está seguro que desea cerrar los saldos de las cuentas de Resultado?',
        function (e) {
            if (e) {
             
                CerrarCuentasResultados();
            }else{
                alertify.error("Se canceló el proceso");
                var idBoton='BtnCerrarCuentasResultado';
                document.getElementById(idBoton).disabled=false;
                document.getElementById(idBoton).value="Cerrar Cuentas de Resultados";
                return;
            }
        });
}

function ConfirmaCierreCuentasBalance(){
    var idBoton='BtnTrasladarCuentasBalance';
    document.getElementById(idBoton).disabled=true;
    document.getElementById(idBoton).value="Cerrando...";
    
    alertify.confirm('Está seguro que desea trasladar los saldos de las cuentas de Balance?',
        function (e) {
            if (e) {
             
                TrasladarSaldosCuentasBalance();
            }else{
                alertify.error("Se canceló el proceso");
                var idBoton='BtnTrasladarCuentasBalance';
                document.getElementById(idBoton).disabled=false;
                document.getElementById(idBoton).value="Trasladar Cuentas de Balance";
                return;
            }
        });
}

/**
 * Cerrar las cuentas de resultados
 * 
 * @returns {undefined}
 */
function CerrarCuentasResultados(){ 
    var idBoton='BtnCerrarCuentasResultado';
    var idEmpresa=document.getElementById('idEmpresa').value;
    var CmbAnio=document.getElementById('CmbAnio').value;
    var idDocumento=document.getElementById('idDocumento').value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('idEmpresa', idEmpresa);
        form_data.append('CmbAnio', CmbAnio);
        form_data.append('idDocumento', idDocumento);
        
    
        $.ajax({
        url: './procesadores/ProcesosContables.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if (respuestas[0] == "OK"){                 
                alertify.success(respuestas[1]);
                
            }else if(respuestas[0] == "E1"){
                alertify.error(respuestas[1]);
                MarqueErrorElemento(respuestas[2]);
            }else{
                alertify.alert(data);
              
          }
          
          document.getElementById(idBoton).disabled=false;
          document.getElementById(idBoton).value="Cerrar Cuentas de Resultados";
          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  

}


function MarqueErrorElemento(idElemento){
    
    if(idElemento==undefined){
       return; 
    }
    document.getElementById(idElemento).style.backgroundColor="pink";
    document.getElementById(idElemento).focus();
}


function LimpiarSelect(idSelect){
    
    if(idSelect==undefined){
       return; 
    }
    document.getElementById(idSelect).value="";
    var idSelect2="select2-"+idSelect+"-container";
    document.getElementById(idSelect2).innerHTML="Selecciona un Tercero";
}


function TrasladarSaldosCuentasBalance(){
        var idEmpresa=document.getElementById('idEmpresa').value;
        var CmbAnio=document.getElementById('CmbAnio').value;
        var idDocumento=document.getElementById('idDocumento').value;
        var GananciaPerdidaBalance=document.getElementById('GananciaPerdidaBalance').value;
        var GananciaPerdidaResultados=document.getElementById('GananciaPerdidaResultados').value;
        // Capturamnos el boton de envío
        var idBoton="BtnTrasladarCuentasBalance";
        var btnEnviar = $("#BtnTrasladarCuentasBalance");
        var jsonSelects=$('#frmTrasladarCuentas').serialize();
        //var jsonSelects = (datosform);
        
        console.log(jsonSelects);
        var form_data = new FormData();
        
            form_data.append('Accion', 2);
            form_data.append('idEmpresa', idEmpresa);
            form_data.append('CmbAnio', CmbAnio);
            form_data.append('idDocumento', idDocumento);
            form_data.append('GananciaPerdidaBalance', GananciaPerdidaBalance);
            form_data.append('GananciaPerdidaResultados', GananciaPerdidaResultados);
            form_data.append('jsonSelects',jsonSelects);
        
        $.ajax({
            url: './procesadores/ProcesosContables.process.php',
            //dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            //data: form_data,
            type: 'post',
            data: form_data,
            beforeSend: function(){
                /*
                * Esta función se ejecuta durante el envió de la petición al
                * servidor.
                * */
                // btnEnviar.text("Enviando"); Para button 
                btnEnviar.val("Enviando"); // Para input de tipo button
                btnEnviar.attr("disabled","disabled");
            },
            complete:function(data){
                /*
                * Se ejecuta al termino de la petición
                * */
                btnEnviar.val("Trasladar Cuentas de Balance");
                btnEnviar.removeAttr("disabled");
            },
            success: function(data){
               var respuestas = data.split(';'); 
                if (respuestas[0] == "OK"){                 
                    alertify.success(respuestas[1]);

                }else if(respuestas[0] == "E1"){
                    alertify.error(respuestas[1]);
                    MarqueErrorElemento(respuestas[2]);
                }else{
                    alertify.alert(data);

              }

              document.getElementById(idBoton).disabled=false;
              document.getElementById(idBoton).value="Trasladar Cuentas de Balance";
            },
            error: function(data){
                alert(xhr.status);
                alert(thrownError);
            }
        });
        // Nos permite cancelar el envio del formulario
        return false;
    

}

initModule();
