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

if(isset($_SESSION["llave_peticion"])){
  $data = json_decode(file_get_contents("php://input"));
  if(isset($data->endpoint)){
    if($data->endpoint=="login"){
      if($data->metodo=="POST"){
        $url="http://localhost/dwpm/proyecto/api/servicios/login/";
        $metodo="POST";
        $datos['usuario']   = $data->usuario;
        $datos['password']  = $data->password;
        $datos= json_encode($datos,UTF8);
        $auth="123";
        $respuesta=curlPHP($url,$metodo,$datos,$auth);
        $respuesta=json_decode($respuesta);
        if($respuesta->status==200){
          $_SESSION["login"] =  true;
          $respuesta=$respuesta->data;
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
                      <img src='../../app/img/{$perfil[6]}' class='card-img-top' style='width: 100%; height: 225px; object-fit: cover;' alt='Imagen personalizada'>
                      <div class='card-body'>
                        <p class='card-text'>Perfil: {$perfil[1]} </p>
                        <div class='d-flex justify-content-between align-items-center'>
                          <div class='btn-group'>
                            <a href='../../app/perfil.html?id={$perfil[0]}' class='btn btn-sm btn-outline-secondary'>Ver</a>
                            <a  class='btn btn-sm btn-outline-secondary'>Editar</a>
                            <a  class='btn btn-sm btn-outline-secondary' onclick='eliminarPerfil({$perfil[0]})'>Eliminar</a>
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
    if($data->endpoint == "eliminarPerfil"){
      if($data->metodo == "POST"){
        $url = 'http://localhost/dwpm/proyecto/api/servicios/perfiles/';
        $metodo = "POST";
        $datos = array(
          'id'=>$data->query
        );
        $datos = json_encode($datos, JSON_UNESCAPED_UNICODE);
        $auth = "123";
        $respuesta = curlPHP($url, $metodo, $datos, $auth);
        $respuesta = json_decode($respuesta);
        if($respuesta->status==200){
          $array=array();
          $array['status']	=	200;
          $array['error']   =	false;
          $array['data']   	=	$respuesta->data;
          $array=json_encode($array,UTF8);
          echo $array;
          die();
        }else{
          $respuesta ="No jala";
          $array['status']	=	500;
          $array['error']   =	false;
          $array['data']   	=	$respuesta;
          $array=json_encode($array,UTF8);
          echo $array;
          die();

        }

      }
    }
    if($data->endpoint == "agregarPerfil"){
      if($data->metodo== "POST"){
        $url = 'http://localhost/dwpm/proyecto/api/servicios/perfiles/';
        $metodo = "POST";
        $datos = $data->datos;
        $datos = json_encode($datos, JSON_UNESCAPED_UNICODE);
        $auth = "123";
        $respuesta = curlPHP($url, $metodo, $datos, $auth);
        $respuesta = json_decode($respuesta);
        if($respuesta->status==200){
          $array=array();
          $array['status']	=	200;
          $array['error']   =	false;
          $array['data']   	=	$respuesta->data;
          $array=json_encode($array,UTF8);
          echo $array;
          die();
        }else{
          $respuesta ="No inserta";
          $array['status']	=	500;
          $array['error']   =	false;
          $array['data']   	=	$respuesta;
          $array=json_encode($array,UTF8);
          echo $array;
          die();

      }
    }
  }
  }else{
    $array=array();
    $array['status']	=	501;
    $array['error']   =	true;
    $array['data']   	=	"Error";
    $array=json_encode($array,UTF8);
    echo $array;
    die();  
  }
}else{
  $array=array();
  $array['status']	=	502;
  $array['error']   =	true;
  $array['data']   	=	"Error";
  $array=json_encode($array,UTF8);
  echo $array;
  die();  
}
