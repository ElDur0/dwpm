<?php
/* ----------- Header 		------------------------*/
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
/* ----------- Header 		------------------------*/

define("UTF8",JSON_UNESCAPED_UNICODE);  

function curlPHP($url,$metodo,$datos,$auth){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $metodo,
    CURLOPT_POSTFIELDS => $datos,
    CURLOPT_HTTPHEADER => array(
      'Authorization: '.$auth,
      'Content-Type: application/json'
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}


$data = json_decode(file_get_contents("php://input"));

if(isset($data->endpoint)){
  if($data->endpoint=="login"){
    if($data->metodo=="POST"){
      $url="http://localhost/dwpm/login/servicios/login/";
      $metodo="POST";
      $datos['usuario']   = $data->usuario;
      $datos['clave']  = $data->clave;
      $datos= json_encode($datos,UTF8);
      $auth="123";
      $respuesta=curlPHP($url,$metodo,$datos,$auth);
      $respuesta=json_decode($respuesta);
      $response=array();
      if($respuesta->status==200){
        $response=json_encode($response,UTF8);
        $array=array();
        $array['status']	=	200;
        $array['error']   =	false;
        $array['data']   	=	$response;
        $array=json_encode($array,UTF8);
        echo $array;
        die();         
      }
    }
  }
}else{
  $array=array();
  $array['status']	=	500;
  $array['error']   =	true;
  $array['data']   	=	"Error";
  $array=json_encode($array,UTF8);
  echo $array;
  die();  
}

