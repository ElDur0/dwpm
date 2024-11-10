<?php
    $config = 'peliculas/configPeliculas.php';
    include_once '../../base/encabezado.php';
    //echo $_SESSION["llave_peticion"];

    $conn = conexion($conexion);
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $res  = obtenerPeliculas($conn);
            array();
            $array['status']    = 200;
            $array['error']     = false;
            $array['data']      = $res;
            $array = json_encode($array);
            echo $array;
            die();
            break;
        
        case 'POST':
            if ($data = json_decode(file_get_contents("php://input"))) {
                
                $respuesta = insertarPelicula($conn, $data->nombre, $data->year, $data->portada,$data->estado);
                $array=array();
                $array['estatus']   = 200;
                $array['error']     = false;
                $array['data']      = $respuesta;
                $array= json_encode($array);
                echo $array;
                die(); 
            }else {
                $array=array();
                $array['estatus']   = 400;
                $array['error']     = true;
                $array['data']      = "Error en la insersión";
                $array= json_encode($array);
                echo $array;
                die(); 
            }
            break;
        case 'PATCH':
            if ($data = json_decode(file_get_contents("php://input"))) {
                
                $respuesta = modificarPelicula($conn, $data->id, $data->nombre, $data->year,$data->portada);
                $array=array();
                $array['estatus']   = 200;
                $array['error']     = false;
                $array['data']      = $respuesta;
                $array= json_encode($array);
                echo $array;
                die(); 
            }else {
                $array=array();
                $array['estatus']   = 400;
                $array['error']     = true;
                $array['data']      = "Error al modificar pelicula";
                $array= json_encode($array);
                echo $array;
                die(); 
            }
            break;
            
        case 'DELETE':
            if($data = json_decode(file_get_contents('php://input'))){
                $respuesta = eliminarPelicula($conn, $data->id);
                $array=array();
                $array['estatus']=200;
                $array['error'] = false;
                $array['data'] = $respuesta;
                $array= json_encode($array);
                echo $array;
                die();
            }else {
                $array=array();
                $array['estatus']   = 400;
                $array['error']     = true;
                $array['data']      = "Error al eliminar pelicula";
                $array= json_encode($array);
                echo $array;
                die(); 
            }
            break;

        default:
            echo"no deberías estar aqui";
        
            break;
    }
    cerrarConexion($conn, $conexion);


