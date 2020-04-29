

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
 * Busca un acuerdo de pago
 * @returns {undefined}
 */
function DibujeHojaDeTrabajoInforme(Page=1){
    ConstruyeHojaDeTrabajoInforme();
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Construyendo la hoja de trabajo...<br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var idCliente=document.getElementById("idCliente").value;
    var cmbCicloPagos=document.getElementById("cmbCicloPagos").value;
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('Page', Page);
        form_data.append('idCliente', idCliente);
        form_data.append('cmbCicloPagos', cmbCicloPagos);
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        
        $.ajax({
        url: './Consultas/informesAcuerdosPago.draw.php',
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


function ConstruyeHojaDeTrabajoInforme(){
    var idDiv="DivDrawTables";
    var FechaFinalRangos = document.getElementById('FechaFinalRangos').value;
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Construyendo la hoja de trabajo...<br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var form_data = new FormData();
        form_data.append('Accion', 1);        
        form_data.append('FechaFinalRangos', FechaFinalRangos);     
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

function ExporteHojaDeTrabajoInforme(Condicion){
    var idDiv="DivDrawTables";
    var FechaInicialRangos = document.getElementById('FechaInicialRangos').value;
    var FechaFinalRangos = document.getElementById('FechaFinalRangos').value;
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Exportando la hoja de trabajo...<br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var form_data = new FormData();
        form_data.append('Accion', 2);        
        form_data.append('Condicion', Condicion);  
        form_data.append('FechaInicialRangos', FechaInicialRangos);  
        form_data.append('FechaFinalRangos', FechaFinalRangos);  
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
                DibujeHojaDeTrabajoInforme();
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
        DibujeHojaDeTrabajoInforme(Page);
    }
    if(Funcion==2){
        DibujeFacturasCreditoCliente(Page);
    }
    if(Funcion==3){
        DibujeAbonosAcuerdosPagoInformes(Page);
    }
}

function DibujeFacturasCreditoCliente(Page=1){
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Construyendo la hoja de trabajo...<br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var idCliente=document.getElementById("idCliente").value;
    
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('Page', Page);
        form_data.append('idCliente', idCliente);
        
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        
        $.ajax({
        url: './Consultas/informesAcuerdosPago.draw.php',
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

function DibujeAbonosAcuerdosPagoInformes(Page=1){
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Construyendo la hoja de trabajo...<br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    var idCliente=document.getElementById("idCliente").value;
    
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('Page', Page);
        form_data.append('idCliente', idCliente);
        
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        
        $.ajax({
        url: './Consultas/informesAcuerdosPago.draw.php',
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


function DibujeGestionCartera(){
    var idDiv="DivDrawTables";
    
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Construyendo la hoja de trabajo...<br><img   src="../../images/loading.gif" alt="Cargando" height="50" width="50"></div>';  
    
    var FechaInicialRangos=document.getElementById("FechaInicialRangos").value;
    var FechaFinalRangos=document.getElementById("FechaFinalRangos").value;
    var form_data = new FormData();
        
        form_data.append('Accion', 4);
        
        form_data.append('FechaInicialRangos', FechaInicialRangos);
        form_data.append('FechaFinalRangos', FechaFinalRangos);
        
        $.ajax({
        url: './Consultas/informesAcuerdosPago.draw.php',
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

function DibujeListadoSegunTipo(){
    var cmbTipoInforme=document.getElementById("cmbTipoInforme").value;
    if(cmbTipoInforme=="1"){//Cuentas por cobrar
        DibujeHojaDeTrabajoInforme();     
    }
    if(cmbTipoInforme=="2"){//Facturas a credito
        DibujeFacturasCreditoCliente();     
    }
    if(cmbTipoInforme=="3"){//Abonos
        DibujeAbonosAcuerdosPagoInformes();     
    }
    if(cmbTipoInforme=="4"){//gestion de cartera
        DibujeGestionCartera();     
    }
}

function DibujeFormularioSegunTipoInforme(){
    var cmbTipoInforme=document.getElementById("cmbTipoInforme").value;
    if(cmbTipoInforme=="1"){//Cuentas por cobrar
        document.getElementById("idCliente").value='';
        document.getElementById("select2-idCliente-container").innerHTML='Todos los Clientes';
        document.getElementById("cmbCicloPagos").value='';
        document.getElementById("FechaInicialRangos").value='';
        DibujeHojaDeTrabajoInforme();       
        
    }
    if(cmbTipoInforme=="2"){//facturas a credito
        document.getElementById("idCliente").value='';
        document.getElementById("select2-idCliente-container").innerHTML='Todos los Clientes';
        document.getElementById("cmbCicloPagos").value='';
        document.getElementById("FechaInicialRangos").value='';
        DibujeFacturasCreditoCliente();       
        
    }
    
    if(cmbTipoInforme=="3"){//abonos
        document.getElementById("idCliente").value='';
        document.getElementById("select2-idCliente-container").innerHTML='Todos los Clientes';
        document.getElementById("cmbCicloPagos").value='';
        document.getElementById("FechaInicialRangos").value='';
        DibujeAbonosAcuerdosPagoInformes();       
        
    }
    if(cmbTipoInforme=="4"){//Gestion de carter
        document.getElementById("idCliente").value='';
        document.getElementById("select2-idCliente-container").innerHTML='Todos los Clientes';
        document.getElementById("cmbCicloPagos").value='';
        document.getElementById("FechaInicialRangos").value='';
        DibujeGestionCartera();       
        
    }
}


function ExportarTablaToExcel(idTabla){
    excel = new ExcelGen({
        "src_id": idTabla,
        "show_header": true
        
    });
    excel.generate();
}
DibujeHojaDeTrabajoInforme();


