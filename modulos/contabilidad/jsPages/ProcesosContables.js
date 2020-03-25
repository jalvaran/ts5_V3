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
    
    if(cmbTipoProceso==1){
        
        MuestraXID("DivProcesosAuditoria");
        MuestreAuditoriaSegunTipo();
    }
    
    if(cmbTipoProceso==2){
        
        OcultaXID("DivProcesosAuditoria");
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


function ConfirmeContabilizarCierre(){
    var idBoton='BtnContabilizarCierre';
    document.getElementById(idBoton).disabled=true;
    document.getElementById(idBoton).value="Contabilizando...";
    
    alertify.confirm('Está seguro que desea Contabilizar el Cierre Contable?',
        function (e) {
            if (e) {
             
                ContabilizarCierreContable();
            }else{
                alertify.error("Se canceló el proceso");
                var idBoton='BtnContabilizarCierre';
                document.getElementById(idBoton).disabled=false;
                document.getElementById(idBoton).value="Contabilizar el Cierre";
                return;
            }
        });
}


function ContabilizarCierreContable(idDocumento=''){
    
    if(idDocumento==''){
        var idDocumento = document.getElementById('idDocumento').value;
    }
        
    
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
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
            if(respuestas[0]=="OK"){
                                
                var mensaje=respuestas[1];
                
                var x = document.getElementById("idDocumento");
                x.remove(x.selectedIndex);
                
                var y = document.getElementById("CmbAnio");
                y.remove(y.selectedIndex);
                
                alertify.alert(mensaje);
                EjecutarProcesoSegunTipo();
            }else{
                alertify.alert(data);
                document.getElementById('BtnContabilizarCierre').disabled=false;
                document.getElementById('BtnContabilizarCierre').value="Guardar";
            }
            
                        
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function MuestreAuditoriaSegunTipo(){
    
    var cmbTipoAuditoria = document.getElementById("cmbTipoAuditoria").value;
    
    if(cmbTipoAuditoria==1){
        MuestreRegistrosSinCuentaContable();
    }
    
    if(cmbTipoAuditoria==2){
        MuestreRegistrosSinTercero();
    }
    
    if(cmbTipoAuditoria==3){
        
        MuestreRegistrosACuentasPadre();
    }
    
    if(cmbTipoAuditoria==4){
        MuestreDocumentosSinBalance();
    }
}

function MuestreRegistrosSinCuentaContable(){
    var idDiv="DivDrawTables";
    var idEmpresa=document.getElementById('idEmpresa').value;
   
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        form_data.append('idEmpresa', idEmpresa);
                
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
            
            $('.cmbCuentaPUC').select2({
		
                placeholder: 'Seleccione una Cuenta Contable',
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
              
              
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

function EditarCuentaContable(idLibro,idSelect,TodosLosRegistros=0){
            
    var CuentaPUC=document.getElementById(idSelect).value;
   
    var form_data = new FormData();
        form_data.append('Accion', '3'); 
        form_data.append('idLibro', idLibro);
        form_data.append('CuentaPUC', CuentaPUC);
        form_data.append('TodosLosRegistros', TodosLosRegistros);
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
            if(respuestas[0]=="OK"){
                                
                alertify.success(respuestas[1]);
            }else if(respuestas[0]=="E1"){
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


function MuestreRegistrosSinTercero(){
    var idDiv="DivDrawTables";
    var idEmpresa=document.getElementById('idEmpresa').value;
   
    var form_data = new FormData();
        
        form_data.append('Accion', 5);
        form_data.append('idEmpresa', idEmpresa);
                
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
            
            $('.cmbTercero').select2({
		
                placeholder: 'Seleccione un tercero',
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

function EditarTerceroEnRegistroContable(idLibro,idSelect){
            
    var Tercero=document.getElementById(idSelect).value;
   
    var form_data = new FormData();
        form_data.append('Accion', '4'); 
        form_data.append('idLibro', idLibro);
        form_data.append('Tercero', Tercero);
        
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
            if(respuestas[0]=="OK"){
                                
                alertify.success(respuestas[1]);
            }else if(respuestas[0]=="E1"){
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

function MuestreRegistrosACuentasPadre(){
    var idDiv="DivDrawTables";
    var idEmpresa=document.getElementById('idEmpresa').value;
   
    var form_data = new FormData();
        
        form_data.append('Accion', 6);
        form_data.append('idEmpresa', idEmpresa);
                
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
            
            $('.cmbCuentaPUC').select2({
		
                placeholder: 'Seleccione una Cuenta Contable',
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
              
              
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  


function MuestreDocumentosSinBalance(){
    var idDiv="DivDrawTables";
    var idEmpresa=document.getElementById('idEmpresa').value;
   
    var form_data = new FormData();
        
        form_data.append('Accion', 7);
        form_data.append('idEmpresa', idEmpresa);
                
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

function VerDocumentoDescuadrado(TipoDocumento,NumeroDocumento){
    var idDiv="DivMovimientosDocumentoDescuadrado";
    var form_data = new FormData();
        
        form_data.append('Accion', 8);
        form_data.append('TipoDocumento', TipoDocumento);
        form_data.append('NumeroDocumento', NumeroDocumento);
                
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

function EditarRegistroAuditoria(Tabla,idItem,idCaja,ColumnaEditar){
    var ValorEditar=document.getElementById(idCaja).value;  
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('Tabla', Tabla);
        form_data.append('idItem', idItem);
        form_data.append('ValorEditar', ValorEditar);
        form_data.append('ColumnaEditar', ColumnaEditar);
        form_data.append('idCaja', idCaja);
        
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
            if(respuestas[0]=="OK"){                                
                alertify.success(respuestas[1]);
            }else if(respuestas[0]=="E1"){
                alertify.error(respuestas[1]);
                MarqueErrorElemento(respuestas[2]);
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

initModule();
