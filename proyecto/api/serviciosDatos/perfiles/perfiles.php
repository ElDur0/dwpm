<?php
    function obtenerPerfiles($conn){
        
        $sql        = "SELECT * FROM perfiles WHERE estado = 1";
        $result     =   $conn->query($sql);
        $row        =   $result->fetch_all();
        $row        =  json_encode($row,UTF8);
        return $row;
        
    }
    function eliminarPerfil($conn, $id) {
        // Prepara la consulta para evitar inyección SQL
        $stmt = $conn->prepare("UPDATE perfiles SET estado = 0 WHERE id = ?");
        $stmt->bind_param("i", $id); // "i" indica que $id es un entero
        if($stmt->execute()){
            $respuesta = array(
                'id'=> $conn->insert_id
            );
        }
        $stmt->close(); // Cierra el statement
        return json_encode($respuesta, UTF8); // Devuelve la respuesta en JSON
    }
    
    function obtenerDatosPerfil($conn, $id){
        $sql = "SELECT * FROM perfiles WHERE id = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_all();
        $row = json_encode($row, UTF8);
        return $row;
    }
    function insertarPerfil($conn, $nombre, $puesto, $edad, $educacion, $locacion, $foto, $biografia, $metas, $motivaciones, $preocupaciones){
        $stmt = $conn->prepare("INSERT INTO perfiles (nombre_perf, puesto, edad, educacion,locacion,foto,biografia,metas,motivaciones,preocupaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssssss", $nombre, $puesto, $edad, $educacion, $locacion, $foto, $biografia, $metas, $motivaciones, $preocupaciones);  // "sis" significa string, integer, string
        
        if ($stmt->execute()) {    
            $respuesta = array(
                'nombre' => $nombre,
                'puesto' => $puesto,
                'edad'=> $edad,
                'educacion'=> $educacion,
                'locacion'=> $locacion,
                'foto'=> $foto,
                'biografia'=> $biografia,
                'metas'=> $metas,
                'motivaciones'=> $motivaciones,
                'preocupaciones'=> $preocupaciones,
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
    function modificarPerfil($conn, $id, $nombre, $puesto, $edad, $educacion, $locacion, $foto, $biografia, $metas, $motivaciones, $preocupaciones){
        $stmt = $conn->prepare("UPDATE perfiles SET nombre_perf=?, puesto=?, edad=?, educacion=?, locacion=?, foto=?, biografia=?, metas=?, motivaciones=?, preocupaciones=? WHERE id=?");
        $stmt->bind_param("ssisssssssi", $nombre, $puesto, $edad, $educacion, $locacion, $foto, $biografia, $metas, $motivaciones, $preocupaciones,$id);
        if ($stmt->execute()) {
            $respuesta = array( 
                'id'=>$id,
                'nombre' => $nombre,
                'puesto' => $puesto,
                'edad'=> $edad,
                'educacion'=> $educacion,
                'locacion'=> $locacion,
                'foto'=> $foto,
                'biografia'=> $biografia,
                'metas'=> $metas,
                'motivaciones'=> $motivaciones,
                'preocupaciones'=> $preocupaciones
            );
            return json_encode($respuesta,UTF8);
            
        }else{
            
            echo "Error: ".$stmt->error;
        }
        $stmt->close();
        
    }