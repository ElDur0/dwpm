<?php
    function obtenerCanciones($conn){
        
        $sql        = "SELECT * FROM canciones";
        $result     =   $conn->query($sql);
        $row        =   $result->fetch_all();
        $row        =  json_encode($row,UTF8);
        return $row;
        
    }
    function insertarCancion($conn, $nombre, $artista){
        $estado="activo";
        $stmt = $conn->prepare("INSERT INTO canciones (nombre,artista,estado) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $artista, $estado);  // "sis" significa string, integer, string
        
        if ($stmt->execute()) {    
            $respuesta = array(
                'nombre' => $nombre,
                'artista'=> $artista,
                'id'=>$conn->insert_id
            );
            return json_encode($respuesta,UTF8);
        } else {
            // Error en la ejecución
            echo "Error: ".$stmt->error;
        }

        // Cerrar el statement
        $stmt->close();

    }
    function modificarCancion($conn, $id, $nombre, $artista){
        $stmt = $conn->prepare("UPDATE canciones SET nombre=?, artista=? WHERE id=?");
        $stmt->bind_param("ssi", $nombre,$artista, $id);
        if ($stmt->execute()) {
            $respuesta = array(
                'nombre' => $nombre,
                'artista'=> $artista,
                'id'=>$id
            );
            return json_encode($respuesta,UTF8);
            
        }else{
            
            echo "Error: ".$stmt->error;
        }
        $stmt->close();
        
    }
    function eliminarCancion($conn , $id){
        $estado = "inactivo";
        $stmt = $conn->prepare("UPDATE canciones SET estado = ? WHERE id = ?");
        $stmt->bind_param("si",$estado,$id);
        if ($stmt->execute()) {
            $array = array(
                'estatus' => 200,
                'mensaje' => 'cancion eliminada'
            );
            return json_encode($array,UTF8);
        }else{
            
            echo json_encode("Error: ".$stmt->error,UTF8);
        }
        $stmt->close();
    }