<?php
$config = 'perfiles/configPerfiles.php';
include_once '../../base/encabezado.php';


switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
            $conn  =	conexion($conexion);
            $res   =	obtenerPerfiles($conn);
            $array=array();
            $array['status']	=	200;
            $array['error']   	=	false;
            $array['data']   	=	$res;
            $array=json_encode($array,UTF8);
            echo $array;
            die();
        
        break;
    case 'POST':
        break;
}