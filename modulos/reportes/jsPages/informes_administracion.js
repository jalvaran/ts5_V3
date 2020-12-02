/**
 * Controlador para generar los reportes de venta 
 * JULIAN ALVARAN 2020-12-02
 * TECHNO SOLUCIONES SAS 
 * 317 774 0609
 */

/*
 * Genera el HTML con los datos de las ventas 
 * @returns {undefined}
 */
function crear_informe_administrador(){
    var idDiv="DivReportes";
    var idBoton="BtnCrearReporte";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/process.gif" alt="Cargando" height="100" width="100"></div>';
    document.getElementById(idBoton).disabled=true;
    var FechaInicial = document.getElementById('FechaInicial').value;
    var FechaFinal = document.getElementById('FechaFinal').value;
    var CmbEmpresaPro = document.getElementById('CmbEmpresaPro').value;
    var CmbCentroCostos = document.getElementById('CmbCentroCostos').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 1);
        form_data.append('CmbEmpresaPro', CmbEmpresaPro);       
        form_data.append('FechaInicial', FechaInicial);
        form_data.append('FechaFinal', FechaFinal);
        form_data.append('CmbCentroCostos', CmbCentroCostos);
        
        
        $.ajax({
        url: './Consultas/informes_administracion.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
                 
            document.getElementById(idDiv).innerHTML=data;        
            document.getElementById(idBoton).disabled=false;    
                    
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;    
            alert(xhr.status);
            alert(thrownError);
          }
      })        
}  

function ExportarTablaToExcel(idTabla){
    excel = new ExcelGen({
        "src_id": idTabla,
        "show_header": true,
        "type": "table"
    });
    excel.generate();
}


document.getElementById('BtnMuestraMenuLateral').click();