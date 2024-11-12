<?php
    $config = 'loteria/configLoteria.php';
    include_once '../../base/encabezado.php';


    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
			$conn  =	conexion($conexion);
				if(isset($_GET['num'])){
					$num = $_GET['num'];
					$res = obtenerNCartas($conn, $num);
				}else{
					if(isset($_GET['id'])){
						$id = $_GET['id'];
						$res = obtenerUnaCarta($conn,$id);
					}else{

						$res   =	obtenerCartas($conn);	
					}
				}
			
			$array=array();
			$array['status']	=	200;
			$array['error']   	=	false;
			$array['data']   	=	$res;
			$array=json_encode($array,UTF8);
			echo $array;
			die();
        break;
        default:
            $array=array();
            $array['status']	=	401;
            $array['error']   	=	true;
            $array['data']   	=	"No deberías estar aquí";
            $array=json_encode($array,UTF8);
            echo $array;
            die();
        break;
        

    }