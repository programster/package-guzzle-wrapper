<?php

declare(strict_types = 1);

$headers = getallheaders();
$getParams = $_GET;
$postPrams = $_POST;

$responseArray = array(
    'headers' => $headers,
    'get_params' => $getParams,
    'post_params' => $postPrams
);

header('Content-Type: application/json');
echo json_encode($responseArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

