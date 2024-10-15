<?php
    $config = 'peliculas/configPeliculas.php';
    include_once '../../base/encabezado.php';
    //echo $_SESSION["llave_peticion"];

    $conn = conexion($conexion);
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $res  = obtenerPeliculas($conn);
            echo $res;
            break;
        
        case 'POST':
             
            if ($data = json_decode(file_get_contents("php://input"),true)) {
                //$data2 = json_encode($data);
                //echo $data2;
                //$conn = conexion($conexion);
                //echo $data['nombre'];
                $nombre     = $data['nombre'];
                $year       = $data['year'];
                $portada    = $data['portada'];
                insertarPelicula($conn, $nombre, $year, $portada);
            }else {
                $array=array();
                $array['estatus'] = 400;
                $array['error'] = "Error de datos";
                $array = json_encode($array);
                echo $array;
                die(); 
            }
            break;
            default:
            break;
    }
    cerrarConexion($conn, $conexion);


   /* include_once '../../base/MySQL.php';
    $servername =  "localhost";
    $username   =  "Luis";
    $password   =  "peliculas";
    $dbname     =  "clase";
    $conn        = conexion($servername,$username,$password,$dbname);
    $sql        = "SELECT * FROM peliculas";
    $result     =   $conn->query($sql);
    $row        =   $result->fetch_all();
    $row        =  json_encode($row,UTF8);
    $conn->close();
    echo $row;*/
