<?php

include 'conexion.php'; 

$sql = "SELECT * FROM perfiles";
$result = $conn->query($sql);

if ($result) { 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . "<br>";
            echo "Nombre: " . $row["nombre_perf"] ."<br>";
            echo "Puesto: " . $row["puesto"] . "<br>";
            echo "Edad: " . $row["edad"] . "<br>";
            echo "Educacion: " . $row["educacion"] . "<br>";
            echo "locacion: " . (is_null($row["locacion"]) ? "Sin foto" : $row["foto"]) . "<br>";
            echo "foto " . $row["foto"] . "<br>";
            echo "metas".$row["metas"]."<br>";
        }
    } else {
        echo "No se encontraron resultados.";
    }
} else {
    echo "Error en la consulta: " . $conn->error; // Manejo de error en la consulta
}


$conn->close(); 