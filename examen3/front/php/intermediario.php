<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset-UTF-8");
 header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
 header("Access-Control-Max-Age: 3600");
 header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


define("UTF8",JSON_UNESCAPED_UNICODE);
 function curlPHP($url,$metodo,$datos,$auth){
   
   $curl = curl_init();
   curl_setopt_array($curl,array(
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
  if($data->endpoint == "getCartas"){
    if($data->metodo == "GET"){
      $url = 'http://localhost/dwpm/examen3/servicios/loteria/';
      $metodo = "GET";
      $datos=null;
      $auth = "123";
      $respuesta = curlPHP($url, $metodo, $datos, $auth);
      $respuesta = json_decode($respuesta);
      $html="";
      if($respuesta->status==200){
        $datos = json_decode($respuesta->data,true);

        foreach($datos as $loteria){
          $html.="
          
                <div class='card'>
                    <img src='img/$loteria[0]' alt='{$loteria[0]}' class='card-img'>
                    <div class='card-content'>
                        <h3 class='card-title'>{$loteria[1]}</h3>
                    </div>
                </div>
          ";
        }
        $respuesta = array(
          "tablero" => $html,
        );
        $respuesta = json_encode($respuesta);
        $array=array();
        $array['status']	=	200;
        $array['error']   =	false;
        $array['data']   	=	$respuesta;
        //$array=json_encode($array,UTF8);
        echo $array;
        die();
      }
    }
  }
}else{
  $array = array();
  $array['status']	=	500;
  $array['error']   =	true;
  $array['data']   	=	"Error";
  $array=json_encode($array,UTF8);
  echo $array;
  die();
}
