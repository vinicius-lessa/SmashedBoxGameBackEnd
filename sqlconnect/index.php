<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    // header('Content-type: application/json; charset=UTF-8');

    echo "Olá Mundo!";

    if ($_SERVER['REQUEST_METHOD'] == 'PUT'):
        
        echo json_encode( ['verbo_http' => $_SERVER['REQUEST_METHOD']] );
    endif;

?>