<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
header('Accept: application/json; charset=utf-8');
/*
session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");
 * 
 */
function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Authorization: Bearer GJiJV7727Oa1d6TZvLQVb3Z85Zj28kJwiDXMaT646mgTlqZ1lpO6a4OvGogfZDPinDVOV27e1FNa66HO',
      'Content-Type: application/json',
      'Accept: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}
//include_once("../clases/Facturacion.class.php");
//include_once("restclient.php");
if( !empty($_REQUEST["Accion"]) ){
   // $obCon = new Facturacion($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una preventa
            
            $jsonFactura= json_encode('{
                "type_document_identification_id": 6,
                "type_organization_id": 1,
                "type_regime_id": 2,
                "type_liability_id": 19,
                "business_name": "TECHNO SOLUCIONES SAS",
                "merchant_registration": "58653",
                "municipality_id": 1013,
                "address": "CALLE 5 SUR 16 62",
                "phone": 3177740609,
                "email": "jalvaran@gmail.com"
              }
            ');
            
            $jsonFactura= json_encode('{
    "number": 990000003,
    "type_document_id": 1,
    "customer": {
        "identification_number": 1094925334,
        "name": "Frank Aguirre",
        "phone": 3060606,
        "address": "CALLE 47 42C 24",
        "email": "faguirre@soenac.com",
        "merchant_registration": "No tiene"
    },
    "tax_totals": [
        {
            "tax_id": 1,
            "percent": "19.00",
            "tax_amount": "57000.00",
            "taxable_amount": "300000.00"
        }
    ],
    "legal_monetary_totals": {
        "line_extension_amount": "300000.00",
        "tax_exclusive_amount": "300000.00",
        "tax_inclusive_amount": "357000.00",
        "allowance_total_amount": "0.00",
        "charge_total_amount": "0.00",
        "payable_amount": "357000.00"
    },
    "invoice_lines": [{
            "unit_measure_id": 642,
            "invoiced_quantity": "1.000000",
            "line_extension_amount": "300000.00",
            "free_of_charge_indicator": false,
            "tax_totals": [{
                "tax_id": 1,
                "tax_amount": "57000.00",
                "taxable_amount": "300000.00",
                "percent": "19.00"
            }],
            "description": "Base para TV",
            "code": "6543542313534",
            "type_item_identification_id": 3,
            "price_amount": "300000.00",
            "base_quantity": "1.000000"
        }
    ]
}

            ');
            
            
           
            //print_r($jsonFactura);
            
            $opciones = array(
                'http'=>array(
                  'method'=>"PUT",
                  'header'=>"Accept: application/json,charset=utf-8,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8;" .
                            "content-type: application/json,charset=utf-8;",
                                            
                            
                   'content'=>$jsonFactura
                )
              );
            
            $url='http://35.238.236.240/api/ubl2.1/config/900833180/7';
            $contexto = stream_context_create($opciones);
            echo (file_get_contents($url, true, $contexto));
                
            print("OK;$jsonFactura");            
          
        break; //Fin caso 1
        
        case 2:
        $jsonFactura= ('{
                "type_document_identification_id": 6,
                "type_organization_id": 1,
                "type_regime_id": 2,
                "type_liability_id": 19,
                "business_name": "TECHNO SOLUCIONES SAS",
                "merchant_registration": "58653",
                "municipality_id": 1013,
                "address": "CALLE 5 SUR 16 62",
                "phone": 3177740609,
                "email": "jalvaran@gmail.com"
              }
            ');
            
            print("OK;$jsonFactura");    
        break;
    
        case 3:
            $url='http://35.238.236.240/api/ubl2.1/invoice/6ce20f05-a1e4-4188-ab56-8d8e366746e6';
            /*
             $jsonFactura= ('{
                "type_document_identification_id": 6,
                "type_organization_id": 1,
                "type_regime_id": 2,
                "type_liability_id": 19,
                "business_name": "TECHNO SOLUCIONES SAS",
                "merchant_registration": "58653",
                "municipality_id": 1013,
                "address": "CALLE 5 SUR 16 62",
                "phone": 3177740609,
                "email": "jalvaran@gmail.com"
              }
            ');
             * 
             */
             
             $jsonFactura= ('{
                    "number": 990000000,
                    "type_document_id": 1,
                    "customer": {
                        "identification_number": 1094925334,
                        "name": "Frank Aguirre",
                        "phone": 3060606,
                        "address": "CALLE 47 42C 24",
                        "email": "faguirre@soenac.com",
                        "merchant_registration": "No tiene"
                    },
                    "tax_totals": [
                        {
                            "tax_id": 1,
                            "percent": "19.00",
                            "tax_amount": "57000.00",
                            "taxable_amount": "300000.00"
                        }
                    ],
                    "legal_monetary_totals": {
                        "line_extension_amount": "300000.00",
                        "tax_exclusive_amount": "300000.00",
                        "tax_inclusive_amount": "357000.00",
                        "allowance_total_amount": "0.00",
                        "charge_total_amount": "0.00",
                        "payable_amount": "357000.00"
                    },
                    "invoice_lines": [{
                            "unit_measure_id": 642,
                            "invoiced_quantity": "1.000000",
                            "line_extension_amount": "300000.00",
                            "free_of_charge_indicator": false,
                            "tax_totals": [{
                                "tax_id": 1,
                                "tax_amount": "57000.00",
                                "taxable_amount": "300000.00",
                                "percent": "19.00"
                            }],
                            "description": "Base para TV",
                            "code": "6543542313534",
                            "type_item_identification_id": 3,
                            "price_amount": "300000.00",
                            "base_quantity": "1.000000"
                        }
                    ]
                }


            ');

              $make_call = callAPI('POST', $url, json_encode($jsonFactura,true));
              $response = ($make_call);
              //$errors   = $response['response']['errors'];
              //$data     = $response['response']['data'][0];
              print_r($response);
            break;
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>
