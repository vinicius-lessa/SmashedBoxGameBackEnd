<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    // header('Content-type: application/json; charset=UTF-8');

    require_once 'classes/Class.Crud.php';
    
    # Estabelece Conexão com o BANCO DE DADOS
    
    // Class.Conexao.php
    $pdo = Conexao::getConexao();
    
    // Class.Class.Crud.php
    Crud::setConexao($pdo);
    
    // Parâmetro passado pela URL
    $uri = basename($_SERVER['REQUEST_URI']);

    echo "Olá Mundo!";

    if ($_SERVER['REQUEST_METHOD'] == 'PUT'):
        
        echo json_encode( ['verbo_http' => $_SERVER['REQUEST_METHOD']] );
    endif;

?>