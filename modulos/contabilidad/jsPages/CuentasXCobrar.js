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
 * Dibuja todas las cuentas x pagar
 * @param {type} idDocumento
 * @returns {undefined}
 */
function DibujeCuentasXPagar(Page=1,Busqueda=''){
    document.getElementById("DivCuentasGeneral").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('Page', Page);
        form_data.append('Busqueda', Busqueda);
        $.ajax({
        url: './Consultas/CuentasXCobrar.draw.php',
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
    
    var Busqueda=document.getElementById("TxtBusquedasTercero").value;
    
    
    DibujeCuentasXPagar(Page,Busqueda);
}

function BuscarTercero(){
    var Busqueda=document.getElementById("TxtBusquedasTercero").value;
    DibujeCuentasXPagar(1,Busqueda);
}


function DibujeCuentasXPagarDocumentos(Page=1,Busqueda='',Tercero=''){
    document.getElementById("TxtBtnVerActivo").value="BtnVer_"+Tercero;
    document.getElementById("DivDocumentosTercero").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('Page', Page);
        form_data.append('Busqueda', Busqueda);
        form_data.append('Tercero', Tercero);
        $.ajax({
        url: './Consultas/CuentasXCobrar.draw.php',
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


function CambiePaginaReferencia(Page='',Tercero){
    if(Page==''){
       var Page=document.getElementById("CmbPageCuentasXPagarReferencia").value;
    }
    
    var Busqueda=document.getElementById("TxtBusquedasReferencia").value;
        
    DibujeCuentasXPagarDocumentos(Page,Busqueda,Tercero);
}

function BuscarDocumentoReferencia(){
    var Busqueda=document.getElementById("TxtBusquedasReferencia").value;
    DibujeCuentasXPagarDocumentos(1,Busqueda);
}


function AgregueMovimientoDesdeCuentaXPagar(idItem,DocReferencia,Total,CuentaPUC,NombreCuenta,Tercero){
    document.getElementById("TabCuentas2").click();
    document.getElementById("TxtDocReferencia").value=DocReferencia;
    var idDocumento=document.getElementById('idDocumento').value;
    if(idDocumento==""){
        alertify.alert("Debe seleccionar un Documento");
        document.getElementById('idDocumento').style.backgroundColor="pink";
         
        return;
    }else{
        document.getElementById('idDocumento').style.backgroundColor="white";
    }
    var form_data = new FormData();
        form_data.append('Accion', 13);        
        form_data.append('idDocumento', idDocumento);
        form_data.append('idItem', idItem);
        form_data.append('Total', Total);
        form_data.append('CuentaPUC', CuentaPUC);
        form_data.append('NombreCuenta', NombreCuenta);
        form_data.append('Tercero', Tercero);
        form_data.append('DocReferencia', DocReferencia);
        form_data.append('idItem', idItem);
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
                                
                alertify.success(respuestas[1]);                
                
          }else{
              alertify.alert("Error: "+data);
              
          }
          
          DibujeDocumento();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            
          }
      })  
    
}

function VerMovimientosCuentaXPagar(idItem){
        document.getElementById("TabCuentas3").click();
        
     var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('idItem', idItem);
        
        $.ajax({
        url: './Consultas/CuentasXCobrar.draw.php',
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
function DibujeCuentasXCobrarCompleta(Page=1,Busqueda=''){
    
    document.getElementById("DivDocumentosTercero").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        form_data.append('Page', Page);
        form_data.append('Busqueda', Busqueda);
        
        $.ajax({
        url: './Consultas/CuentasXCobrar.draw.php',
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


function CambiePaginaReferencia2(Page='',Tercero){
    if(Page==''){
       var Page=document.getElementById("CmbPageCuentasXPagarReferencia").value;
    }
    
    var Busqueda=document.getElementById("TxtBusquedasReferencia").value;
        
    DibujeCuentasXCobrarCompleta(Page,Busqueda,Tercero);
}


//document.getElementById("BtnMuestraMenuLateral").click();
DibujeCuentasXPagar();
