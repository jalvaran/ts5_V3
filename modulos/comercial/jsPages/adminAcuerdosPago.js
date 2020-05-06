

document.getElementById("BtnMuestraMenuLateral").click();


$('#idCliente').select2({
		  
    placeholder: 'Todos los clientes',
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
          
          
/**
 * Historial de acuerdos de pago
 * @returns {undefined}
 */
function HistorialAcuerdosPago(Page=1){
    
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var idCliente=document.getElementById("idCliente").value;
    var cmbCicloPagos=document.getElementById("cmbCicloPagos").value;
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;
    var cmbEstadosAcuerdos=document.getElementById("cmbEstadosAcuerdos").value;
    var Busqueda=document.getElementById("Busqueda").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('Page', Page);
        form_data.append('idCliente', idCliente);
        form_data.append('cmbCicloPagos', cmbCicloPagos);
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        form_data.append('Busqueda', Busqueda);
        form_data.append('cmbEstadosAcuerdos', cmbEstadosAcuerdos);
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
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


/**
 * Historial proyeccion de pagos
 * @returns {undefined}
 */
function HistorialProyeccionPagos(Page=1){
    
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var idCliente=document.getElementById("idCliente").value;
    var cmbCicloPagos=document.getElementById("cmbCicloPagos").value;
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;
    var cmbEstadosAcuerdos=document.getElementById("cmbEstadosAcuerdos").value;
    var Busqueda=document.getElementById("Busqueda").value;
    var cmbEstadosProyeccion=document.getElementById("cmbEstadosProyeccion").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('Page', Page);
        form_data.append('idCliente', idCliente);
        form_data.append('cmbCicloPagos', cmbCicloPagos);
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        form_data.append('Busqueda', Busqueda);
        form_data.append('cmbEstadosAcuerdos', cmbEstadosAcuerdos);
        form_data.append('cmbEstadosProyeccion', cmbEstadosProyeccion);
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
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


/**
 * Historial proyeccion de pagos
 * @returns {undefined}
 */
function HistorialAbonos(Page=1){
    
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var idCliente=document.getElementById("idCliente").value;
    var cmbCicloPagos=document.getElementById("cmbCicloPagos").value;
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;
    var cmbEstadosAcuerdos=document.getElementById("cmbEstadosAcuerdos").value;
    var Busqueda=document.getElementById("Busqueda").value;
    var cmbTiposCuota=document.getElementById("cmbTiposCuota").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('Page', Page);
        form_data.append('idCliente', idCliente);
        form_data.append('cmbCicloPagos', cmbCicloPagos);
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        form_data.append('Busqueda', Busqueda);
        form_data.append('cmbEstadosAcuerdos', cmbEstadosAcuerdos);
        form_data.append('cmbTiposCuota', cmbTiposCuota);
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
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


/**
 * Historial proyeccion de pagos
 * @returns {undefined}
 */
function ReconstruccionDeCuenta(Page=1){
    
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var idCliente=document.getElementById("idCliente").value;    
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;    
    var Busqueda=document.getElementById("Busqueda").value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        form_data.append('Page', Page);
        form_data.append('idCliente', idCliente);
        
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        form_data.append('Busqueda', Busqueda);
        
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
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

/**
 * Historial proyeccion de pagos
 * @returns {undefined}
 */
function HistorialProductosAcuerdos(Page=1,idAcuerdoPago=""){
    
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var idCliente=document.getElementById("idCliente").value;
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;
    var cmbEstadosAcuerdos=document.getElementById("cmbEstadosAcuerdos").value;
    var Busqueda=document.getElementById("Busqueda").value;
    
    var form_data = new FormData();
        
        form_data.append('Accion', 5);
        form_data.append('Page', Page);
        form_data.append('idCliente', idCliente);
        
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        form_data.append('Busqueda', Busqueda);
        form_data.append('cmbEstadosAcuerdos', cmbEstadosAcuerdos);
        form_data.append('idAcuerdoPago', idAcuerdoPago);
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
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

function FormularioDevolverItem(idAcuerdoPago,idItem){
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var form_data = new FormData();
        
        form_data.append('Accion', 9);
        form_data.append('idItem', idItem);
       
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idDiv).innerHTML=data;
            FormularioAbonarAcuerdoPago(idAcuerdoPago,'DivAbonosDevolucion',1);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}

function ConstruyeHojaDeTrabajoInforme(){
    var idDiv="DivDrawTables";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Construyendo la hoja de trabajo...<br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var form_data = new FormData();
        form_data.append('Accion', 1);        
        
        $.ajax({
        url: './procesadores/informesAcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                document.getElementById(idDiv).innerHTML="";
                alertify.success(respuestas[1]);
                //DibujeHojaDeTrabajoInforme();
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
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

function CambiePagina(Page="",Funcion=1){
    
    if(Page==""){
        Page = document.getElementById('CmbPage').value;
    }
    if(Funcion==1){
        HistorialAcuerdosPago(Page);
    }
    if(Funcion==2){
        HistorialProyeccionPagos(Page);
    }
    if(Funcion==3){
        HistorialAbonos(Page);
    }
    if(Funcion==4){
        ReconstruccionDeCuenta(Page);
    }
    if(Funcion==5){
        HistorialProductosAcuerdos(Page);
    }
}

function DibujeListadoSegunTipo(cmbTipoInforme=""){
    if(cmbTipoInforme==""){
        var cmbTipoInforme=document.getElementById("cmbTipoInforme").value;
    }
    if(cmbTipoInforme=="1"){//Acuerdos de pago 
        
        HistorialAcuerdosPago(); 
        MuestraObjeto("DivEstadosAcuerdos");
        OcultaObjeto("DivEstadosProyeccion");
        OcultaObjeto("DivTiposCuota");
        
    }
    if(cmbTipoInforme=="2"){//Facturas a credito
        HistorialProyeccionPagos();  
        MuestraObjeto("DivEstadosAcuerdos");
        MuestraObjeto("DivEstadosProyeccion");
        OcultaObjeto("DivTiposCuota");
    }
    if(cmbTipoInforme=="3"){//Abonos
        HistorialAbonos();    
        MuestraObjeto("DivEstadosAcuerdos");
        OcultaObjeto("DivEstadosProyeccion");
        MuestraObjeto("DivTiposCuota");
    }
    if(cmbTipoInforme=="4"){//Muestra todo el movimiento contable de un cliente
        OcultaObjeto("DivEstadosAcuerdos");
        OcultaObjeto("DivEstadosProyeccion");
        OcultaObjeto("DivTiposCuota");
        ReconstruccionDeCuenta();     
    }
    
    if(cmbTipoInforme=="5"){//Muestra el historial de productos llevados en un acuerdo de pago
        MuestraObjeto("DivEstadosAcuerdos");
        OcultaObjeto("DivEstadosProyeccion");
        OcultaObjeto("DivTiposCuota");
        HistorialProductosAcuerdos();     
    }
    
}

function LimpiarFiltros(){
    document.getElementById("idCliente").value='';
    document.getElementById("select2-idCliente-container").innerHTML='Todos los Clientes';
    document.getElementById("cmbCicloPagos").value='';
    document.getElementById("FechaInicialRangos").value='';
    document.getElementById("FechaFinalRangos").value='';
    document.getElementById("Busqueda").value='';
}

function MuestraObjeto(id){
   
    document.getElementById(id).style.display="block";
    
}

function OcultaObjeto(id){
    
    document.getElementById(id).style.display="none";
    
}


function ExportarTablaToExcel(idTabla){
    excel = new ExcelGen({
        "src_id": idTabla,
        "show_header": true
        
    });
    excel.generate();
}

function FormularioAnularAcuerdoPago(idAcuerdoPago){
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var form_data = new FormData();
        
        form_data.append('Accion', 10);
        form_data.append('idAcuerdoPago', idAcuerdoPago);
       
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
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

function ConfirmeAnularAcuerdo(idAcuerdoPago){
    
    alertify.confirm('Está Seguro que desea Anular este acuerdo? ',
        function (e) {
            if (e) {
                
                AnularAcuerdoPago(idAcuerdoPago);
            }else{
                alertify.error("Se canceló el proceso");
                
                return;
            }
        });
}

function AnularAcuerdoPago(idAcuerdoPago){
    var idBoton="btnAnularAcuerdo";
    document.getElementById(idBoton).disabled=true;    
    var Observaciones=document.getElementById("ObservacionesAnulacion").value;
   
    var form_data = new FormData();
        form_data.append('Accion', 8);        
        form_data.append('idAcuerdoPago', idAcuerdoPago);
        form_data.append('Observaciones', Observaciones);  
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idBoton).disabled=false;
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){                
                alertify.success(respuestas[1]);
                DibujeListadoSegunTipo();
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function FormularioAnularAbono(idAbono){
    var idDiv="DivDrawTables";
    CierraModal("ModalAcciones");
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var form_data = new FormData();
        
        form_data.append('Accion', 11);
        form_data.append('idAbono', idAbono);
       
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
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

function ConfirmeAnularAbono(idAbono){
    
    alertify.confirm('Está Seguro que desea Anular este abono? ',
        function (e) {
            if (e) {
                
                AnularAbonoAcuerdoPago(idAbono);
            }else{
                alertify.error("Se canceló el proceso");
                
                return;
            }
        });
}

function AnularAbonoAcuerdoPago(idAbono){
    var idBoton="btnAnularAbono";
    document.getElementById(idBoton).disabled=true;    
    var Observaciones=document.getElementById("ObservacionesAnulacion").value;
   
    var form_data = new FormData();
        form_data.append('Accion', 9);        
        form_data.append('idAbono', idAbono);
        form_data.append('Observaciones', Observaciones);  
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idBoton).disabled=false;
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){                
                alertify.success(respuestas[1]);
                DibujeListadoSegunTipo();
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            alert(xhr.status);
            alert(thrownError);
          }
      });
}



function FormularioReportarAcuerdoPago(idAcuerdo){
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess"><br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var form_data = new FormData();
        
        form_data.append('Accion', 12);
        form_data.append('idAcuerdo', idAcuerdo);
       
        
        $.ajax({
        url: './Consultas/adminAcuerdosPago.draw.php',
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

function ConfirmeReportarAcuerdo(idAcuerdo){
    
    alertify.confirm('Está Seguro que desea Reportar este Acuerdo de Pago? ',
        function (e) {
            if (e) {
                
                ReportarAcuerdoPago(idAcuerdo);
            }else{
                alertify.error("Se canceló el proceso");
                
                return;
            }
        });
}

function ReportarAcuerdoPago(idAcuerdo){
    var idBoton="btnReportarAcuerdo";
    document.getElementById(idBoton).disabled=true;    
    var Observaciones=document.getElementById("ObservacionesAnulacion").value;
   
    var form_data = new FormData();
        form_data.append('Accion', 10);        
        form_data.append('idAcuerdo', idAcuerdo);
        form_data.append('Observaciones', Observaciones);  
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idBoton).disabled=false;
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){                
                alertify.success(respuestas[1]);
                DibujeListadoSegunTipo();
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

DibujeListadoSegunTipo(1);

