/**
 * Controlador para Cuentas x cobrar
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
 * Dibuja todas las cuentas x pagar
 * @param {type} idDocumento
 * @returns {undefined}
 */
function DibujeCuentasXCobrar(Page=1,Busqueda=''){
    document.getElementById("DivCuentasGeneral").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('Page', Page);
        form_data.append('Busqueda', Busqueda);
        $.ajax({
        url: './Consultas/recaudo.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivCuentasGeneral').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


function CambiePagina(Page=''){
    if(Page==''){
       var Page=document.getElementById("CmbPageCuentasXPagar").value;
    }
    
    DibujeCuentaTercero(Page);
}


function DibujeCuentaTercero(Page=1){
    
    document.getElementById("DivDocumentosTercero").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    var Tercero=document.getElementById("cmbTercero").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('Page', Page);        
        form_data.append('Tercero', Tercero);
        $.ajax({
        url: './Consultas/recaudo.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivDocumentosTercero').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


function VerMovimientosCuentaXCobrar(idItem){
        document.getElementById("TabCuentas3").click();
        
     var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('idItem', idItem);
        
        $.ajax({
        url: './Consultas/recaudo.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivDetallesCuentasXPagar').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}


function confirmaAbono(){
    
    
    alertify.confirm('Está seguro que desea Guardar?',
        function (e) {
            if (e) {
             
                RealizarAbono();
            }else{
                alertify.error("Se canceló el proceso");
                
                return;
            }
        });
}

function RealizarAbono(){
    var idBoton='btnGuardar';
    document.getElementById(idBoton).disabled=true;
    document.getElementById(idBoton).value="Guardando...";
    
    var idDiv="DivDocumentosTercero";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Realizando el Abono...<br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var cmbTercero=document.getElementById('cmbTercero').value;
    var txtAbono=document.getElementById('txtAbono').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1); 
        form_data.append('cmbTercero', cmbTercero);       
        form_data.append('txtAbono', txtAbono);       
        
        $.ajax({
        url: './procesadores/recaudo.process.php',
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
                document.getElementById(idDiv).innerHTML=respuestas[2]+' <br>'+respuestas[1];
                
                document.getElementById('cmbTercero').value="";
                document.getElementById('txtAbono_Format_Number').value="0";
                document.getElementById('txtAbono').value="0";
                document.getElementById('select2-cmbTercero-container').innerHTML="Seleccione un tercero";
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
            document.getElementById(idBoton).disabled=false;
            document.getElementById(idBoton).value="Guardar";           
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            document.getElementById(idBoton).value="Guardar";    
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

document.getElementById("BtnMuestraMenuLateral").click();


$('#cmbTercero').select2({
		  
    placeholder: 'Selecciona un tercero',
    ajax: {
      url: 'buscadores/terceros.search.php',
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
          
Number_Format_Input();
