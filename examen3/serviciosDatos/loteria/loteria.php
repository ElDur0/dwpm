<?php
function obtenerCartas($conn){
    $sql        = "SELECT * FROM loteria";
    $result     =   $conn->query($sql);
    $row        =   $result->fetch_all();
    $row        =  json_encode($row,UTF8);
    return $row;

}

function obtenerNCartas($conn, $numero){
    //"SELECT * FROM  loteria ORDER BY RAND() LIMIT ?
    $sql        = "SELECT * FROM  loteria ORDER BY RAND() LIMIT $numero";
    $result     =   $conn->query($sql);
    $row        =   $result->fetch_all();
    $row        =  json_encode($row,UTF8);
    return $row;
    
}
function obtenerUnaCarta($conn, $id){
    $stmt = $conn->prepare("SELECT * FROM loteria WHERE id= ?");
    
    $sql        = "SELECT * FROM loteria WHERE id=$id";
    $result     =   $conn->query($sql);
    $row        =   $result->fetch_all();
    $row        =  json_encode($row,UTF8);
    return $row;
}