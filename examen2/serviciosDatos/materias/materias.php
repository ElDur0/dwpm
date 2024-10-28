<?php
    function obtenerMaterias($conn){
        
        $sql        = "SELECT * FROM materias";
        $result     =   $conn->query($sql);
        $row        =   $result->fetch_all();
        $row        =  json_encode($row,UTF8);
        return $row;
        
    }
    function insertarMateria($conn, $nombre, $departamento){
        $estado="activo";
        $stmt = $conn->prepare("INSERT INTO materias (nombre,departamento,estado) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $departamento,$estado);  // "sis" significa string, integer, string
        
        if ($stmt->execute()) {    
            $respuesta = array(
                'nombre' => $nombre,
                'departamento'=> $departamento,
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
    function modificarMateria($conn, $id, $nombre, $departamento){
        $stmt = $conn->prepare("UPDATE materias SET nombre=?, departamento=? WHERE id=?");
        $stmt->bind_param("ssi", $nombre,$departamento, $id);
        if ($stmt->execute()) {
            $respuesta = array(
                'nombre' => $nombre,
                'departamento'=> $departamento,
                'id'=>$id
            );
            return json_encode($respuesta,UTF8);
            
        }else{
            
            echo "Error: ".$stmt->error;
        }
        $stmt->close();
        
    }
    function eliminarMateria($conn , $id){
        $estado = "inactivo";
        $stmt = $conn->prepare("UPDATE materias SET estado = ? WHERE id = ?");
        $stmt->bind_param("si",$estado,$id);
        if ($stmt->execute()) {
            $array = array(
                'estatus' => 200,
                'mensaje' => 'materia eliminada'
            );
            return json_encode($array,UTF8);
        }else{
            
            echo json_encode("Error: ".$stmt->error,UTF8);
        }
        $stmt->close();
    }