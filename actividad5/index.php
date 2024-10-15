<?php

/*if ($_GET['opcion'] == null) {
    $_GET['opcion'] = " ";
}

$op = $_GET['opcion'];
    if($op == "jsonFile"){
        header("Location: jsonfile/index.php");
    }
    elseif($op == "jsonPHP"){
        header("Location: jsonphp/index.php");
    }
    elseif($op == "database"){
        header("Location: dwpm/index.php");
    }
    else{
        return 0;
    }

    print_r($_GET);*/

    if($_GET){
        $url=$_GET['opcion'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://localhost/actividad5/'.$url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

?>