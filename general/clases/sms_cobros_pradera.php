<?php

//VARIABLES DE CUENTA DE USUARIO
//ESTAS CORRESPONDEN A SEBASTIAN CORREA
$account="10020317";
$apikey="N78H9g3uveQTL0LQnbGAQ2FkBuFJY5";
$token="cb8063f6dcc1ddcab8d1e075219dfc7c";




function enviarsms($numero,$mensaje,$referencia){
    $ch=curl_init();
    $post = array(
    'account' => $GLOBALS['account'], //número de usuario
    'apiKey' => $GLOBALS['apikey'], //clave API del usuario
    'token' => $GLOBALS['token'], // Token de usuario
    'toNumber' => $numero, //número de destino
    'sms' => $mensaje , // mensaje de texto
    'flash' => '0', //mensaje tipo flash
    'sendDate'=> time(), //fecha de envío del mensaje
    'isPriority' => 1, //mensaje prioritario
    'sc'=> '899991', //código corto para envío del mensaje de texto
    'request_dlvr_rcpt' => 0, //mensaje de texto con confirmación de entrega al celular
    );

    $url = "https://api101.hablame.co/api/sms/v2.1/send/"; //endPoint: Primario
    curl_setopt ($ch,CURLOPT_URL,$url) ;
    curl_setopt ($ch,CURLOPT_POST,1);
    curl_setopt ($ch,CURLOPT_POSTFIELDS, $post);
    curl_setopt ($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt ($ch,CURLOPT_TIMEOUT, 20);
    $response= curl_exec($ch);
    curl_close($ch);
    $response= json_decode($response ,true) ;

    //La respuesta estará alojada en la variable $response
    if ($response["status"]== '1x000' ){
        //echo 'El SMS se ha enviado exitosamente con el ID: '.$response["smsId"].PHP_EOL;
        $mensajetexto=1;
    } else {
        //echo 'Ha ocurrido un error:'.$response["error_description"].'('.$response ["status" ]. ')'. PHP_EOL;
        $mensajetexto=0;
    }
    
    return $mensajetexto;
  
}





