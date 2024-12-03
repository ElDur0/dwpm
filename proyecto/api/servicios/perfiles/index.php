<?php
$config = 'perfiles/configPerfiles.php';
include_once '../../base/encabezado.php';


switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $conn  =	conexion($conexion);
        if(isset($_GET['id'])){
            $id   = $_GET['id'];
            $res  = obtenerDatosPerfil($conn, $id);
        }else{

            $res   =	obtenerPerfiles($conn);
        }
            $array=array();
            $array['status']	=	200;
            $array['error']   	=	false;
            $array['data']   	=	$res;
            $array=json_encode($array,UTF8);
            echo $array;
            die();
        
        break;
    case 'POST':
        $conn  =	conexion($conexion);
        if($data = json_decode(file_get_contents("php://input"))){
            if($data->id){
                $res = eliminarPerfil($conn, $data->id);
            }else{

                $res   =	insertarPerfil($conn, $data->nombre, $data->puesto,$data->edad, $data->educacion, $data->locacion, "foto.jpg", $data->biografia, $data->metas, $data->motivaciones, $data->preocupaciones);
            }
            $array=array();
            $array['status']	=	200;
            $array['error']   	=	false;
            $array['data']   	=	$res;
            $array=json_encode($array,UTF8);
            echo $array;
            die();
        }else{
            $array=array();
            $array['status']	=	400;
            $array['error']   	=	true;
            $array['data']   	=	"";
            $array=json_encode($array);
            echo $array;
            die();
        }
        break;
}