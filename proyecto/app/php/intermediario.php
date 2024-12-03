<?php
/* ----------- Header 		------------------------*/
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
/* ----------- Header 		------------------------*/

define("UTF8",JSON_UNESCAPED_UNICODE);  
session_start();

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

if(isset($_SESSION["llave_peticion"])){
  if(isset($data->endpoint)){
    if($data->endpoint == "getPerfiles"){
      if($data->metodo == "GET"){
        $url = 'http://localhost/dwpm/proyecto/api/servicios/perfiles/';
        $metodo = "GET";
        $datos=null;
        $auth = "123";
        $respuesta = curlPHP($url, $metodo, $datos, $auth);
        $respuesta = json_decode($respuesta);
        $html="";
        if($respuesta->status==200){
          $datos = json_decode($respuesta->data,true);
  
          foreach($datos as $perfil){
            $html.="
                  <div class='col'>
                    <div class='card shadow-sm'>
                      <img src='img/{$perfil[6]}' class='card-img-top' style='width: 100%; height: 225px; object-fit: cover;' alt='Imagen personalizada'>
                      <div class='card-body'>
                        <p class='card-text'>Perfil: {$perfil[1]} </p>
                        <div class='d-flex justify-content-between align-items-center'>
                          <div class='btn-group'>
                            <a href='perfil.html?id={$perfil[0]}' class='btn btn-sm btn-outline-secondary'>View</a>

                          </div>
                          <small class='text-body-secondary'>9 mins</small>
                        </div>
                      </div>
                    </div>
                  </div>

            ";
            
          }
          $respuesta = array(
            "card" => $html,
            "data" => $respuesta->data
          );
          $respuesta = json_encode($respuesta);
          $array=array();
          $array['status']	=	200;
          $array['error']   =	false;
          $array['data']   	=	$respuesta;
          $array=json_encode($array,UTF8);
          echo $array;
          die();
        }
      }
    }
    if($data->endpoint == "buscarPerfil"){
      if($data->metodo == "GET"){
        $id  = $data->query;
        $url = 'http://localhost/dwpm/proyecto/api/servicios/perfiles/';
        $url = $url.'?id='.$id;
        $metodo = "GET";
        $datos = null;
        $auth = "123";
        $respuesta = curlPHP($url,$metodo,$datos, $auth);
        $respuesta = json_decode($respuesta);
        $html="<h1>holo</h1>";
        
        if($respuesta->status==200){
          $datos = json_decode($respuesta->data, true);
          $perfil= $datos[0];

          $html ="
          <div class='row'>
      <div class='col-md-4 text-center'>
        <div class='profile-card'>
          <img src='img/$perfil[6]' alt='Ann Doe'>
          <h3>$perfil[1]</h3>
          <p>$perfil[2]r</p>
          <p><strong>Age:</strong>$perfil[3]</p>
          <p><strong>Education:</strong> $perfil[4]</p>
          <p><strong>Location:</strong> $perfil[5]</p>
        </div>
      </div>
      

      <div class='col-md-8'>
        <div class='row g-3'>
          <div class='col-md-6'>
            <div class='info-card'>
              <h5>Bio</h5>
              <p>$perfil[7]</p>
            </div>
          </div>
          <div class='col-md-6'>
            <div class='info-card'>
              <h5>Goals</h5>
              <p>$perfil[8]</p>
            </div>
          </div>
          <div class='col-md-6'>
            <div class='info-card'>
              <h5>Motivations</h5>
              <p>$perfil[9]</p>
            </div>
          </div>
          <div class='col-md-6'>
            <div class='info-card'>
              <h5>Concerns</h5>
              <p>$perfil[10]</p>
            </div>
          </div>
        </div>
      </div>
    </div>
          ";

          $resp = array(
            "contenido" => $html
          );
          $resp = json_encode($resp,UTF8);
          $array=array();
          $array['status']	=	200;
          $array['error']   =	false;
          $array['data']   	=	 $resp; 
          $array = json_encode($array,UTF8);
          echo $array;
          die();
        }

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