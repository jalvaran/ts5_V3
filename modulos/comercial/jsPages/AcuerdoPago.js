/**
 * Busca un acuerdo de pago
 * @returns {undefined}
 */
function BuscarAcuerdo(){
    var TxtBuscarAcuerdo=(document.getElementById('TxtBuscarAcuerdo').value);    
    var form_data = new FormData();
        
        form_data.append('Accion', 1);
        form_data.append('TxtBuscarAcuerdo', TxtBuscarAcuerdo);
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivBusquedasPOS').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  


function ImprimirAcuerdoPago(idAcuerdo){
    
    var form_data = new FormData();
        form_data.append('Accion', 1);        
        form_data.append('idAcuerdo', idAcuerdo);
        
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
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



function FormularioAbonarAcuerdoPago(idAcuerdo){
    
    
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        form_data.append('idAcuerdo', idAcuerdo);
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivBusquedasPOS').innerHTML=data;
            DibujeHistorialDeCuotas(idAcuerdo);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  

function DibujeHistorialDeCuotas(idAcuerdo){
    
    
    var form_data = new FormData();
        
        form_data.append('Accion', 3);
        form_data.append('idAcuerdo', idAcuerdo);
        $.ajax({
        url: './Consultas/AcuerdoPago.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById('DivHistorialPagosAcuerdo').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })  
}  


function ConfirmarAbonoAcuerdoPago(idAcuerdo){
    document.getElementById("BtnGuardarAbonoAcuerdo").disabled=true;
    alertify.confirm('Realizar abono? '+idAcuerdo+'?',
        function (e) {
            if (e) {
                
                AbonarAcuerdoPago(idAcuerdo);
            }else{
                alertify.error("Se canceló el proceso");
                document.getElementById("BtnGuardarAbonoAcuerdo").disabled=false;
                return;
            }
        });
}


function AbonarAcuerdoPago(idAcuerdo){
    document.getElementById("BtnGuardarAbonoAcuerdo").disabled=true;
    var TxtValorAbonoAcuerdoExistente=document.getElementById('TxtValorAbonoAcuerdoExistente').value;
    var CmbMetodoPagoAbonoAcuerdo=document.getElementById('CmbMetodoPagoAbonoAcuerdo').value;
    var form_data = new FormData();
        form_data.append('Accion', 2);        
        form_data.append('idAcuerdo', idAcuerdo);
        form_data.append('TxtValorAbonoAcuerdoExistente', TxtValorAbonoAcuerdoExistente);
        form_data.append('CmbMetodoPagoAbonoAcuerdo', CmbMetodoPagoAbonoAcuerdo);
        
        $.ajax({
        url: './procesadores/AcuerdoPago.process.php',
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
                document.getElementById('TxtValorAbonoAcuerdoExistente').value=0;
                DibujeHistorialDeCuotas(idAcuerdo);
            }else if(respuestas[0]=="E1"){
                alertify.alert(respuestas[1]);
            }else{
                alertify.alert(data);
            }
            document.getElementById("BtnGuardarAbonoAcuerdo").disabled=false;           
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            document.getElementById("BtnGuardarAbonoAcuerdo").disabled=false;
          }
      });
}


