<?php
define("UTF", JSON_UNESCAPED_UNICODE);
$url = "restaurantes.json";
$jsonResponse = file_get_contents($url);

echo $jsonResponse; 