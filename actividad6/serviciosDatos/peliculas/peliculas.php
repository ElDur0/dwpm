<?php
    function obtenerPeliculas($conn){
        
        $sql        = "SELECT * FROM peliculas";
        $result     =   $conn->query($sql);
        $row        =   $result->fetch_all();
        $row        =  json_encode($row,UTF8);
        return $row;
        
    }
    function insertarPelicula($conn, $nombre, $year, $portada){
        // Preparar la consulta SQL para la inserción
        $stmt = $conn->prepare("INSERT INTO peliculas (nombre, year, portada) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nombre, $year, $portada);  // "sis" significa string, integer, string
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Respuesta exitosa
            $array = array(
                'estatus' => 200,
                'mensaje' => 'Película insertada correctamente'
            );
            echo json_encode($array);
        } else {
            // Error en la ejecución
            $array = array(
                'estatus' => 500,
                'error' => 'Error al insertar la película: ' . $stmt->error
            );
            echo json_encode($array,UTF8);
        }

        // Cerrar el statement
        $stmt->close();

    }