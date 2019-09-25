/**
 * Controlador para realizar las facturas electronicas
 * JULIAN ALVARAN 2019-03-01
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */
/**
 * Posiciona un elemento indicando el id
 * @param {type} id
 * @returns {undefined}
 */

/**
 * Agrega una opcion de preventa
 * @returns {undefined}
 */
function VerificaReporteFacturas(){
       
    var form_data = new FormData();
        
        form_data.append('Accion', 2);
        
        $.ajax({
        url: './procesadores/facturacionElectronica.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        method: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
            if(respuestas[0]=="OK"){
                var jsonFe=JSON.parse(respuestas[1]);
                //console.log(jsonFe);
                document.getElementById("DivMensajes").innerHTML=respuestas[1];   
                CreeFacturaElectronica(jsonFe);
            }
            else if(respuestas[0]=="E1"){
                alertify.alert("No se pueden crear mas de 3 preventas");            
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

function CreeFacturaElectronica(jsonFe){
    
                
        $.ajax({
        url: 'http://35.238.236.240/api/ubl2.1/config/900833180/7',
        dataType: 'jsonp',
        Accept:'jsonp,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        
        cache: false,
        contentType: 'jsonp,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        processData: false,
        data: jsonFe,
        method: 'put',
       
        success: function(data){
            console.log(data);
            document.getElementById("DivMensajes").innerHTML=data;   
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            alertify.error(xhr.status);
            alertify.error(thrownError);
          }
      })   


}

document.getElementById("BtnMuestraMenuLateral").click();