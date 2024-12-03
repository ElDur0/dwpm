<?php
    function login($conn,$nombre,$password){
		$password=md5($password);
        $stmt 	= $conn->prepare("SELECT * FROM usuarios WHERE nombre=? AND password=?");
		$stmt->bind_param("ss",$nombre,$password);
		if ($stmt->execute()) {
        	$row["status"]   =  $stmt->fetch();
			if($row["status"]){
				$row["nombre"]   =  $nombre;
				$row["password"]  =  $password;
			}else{
				$row["status"]   =  false;
			}
        	$row       		 =  json_encode($row,UTF8);
        	return $row;
		}else{
			$row["status"]   =  false;
			return $row;
		}
    }