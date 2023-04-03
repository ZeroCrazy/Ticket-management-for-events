<?php

    /*
        CODETECH.ES
        Sistema de Eventos 
        Departamento de Electrónica

        Desarrollo de un sistema de entradas para eventos y listado de participantes
        Autor: Daniel Garzón (ZeroCrazy)
        Año: 2023
    */

    
    # No mostrar errores de código PHP/MySQL en la web.
    error_reporting(0);

    
    setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain', 'Spanish');
    header('Content-Type: text/html; charset=utf-8');
    date_default_timezone_set('Europe/Madrid');

    # [DB] Conexión a la base de datos.
    $conn = mysqli_connect(
        'YOUR_HOST',
        'YOUR_USERNAME',
        'YOUR_PASSWORD',
        'YOUR_DATABASE'
    );
    if(!$conn->set_charset("utf8")){
        printf("Error cargando el conjunto de caracteres utf8: %\n", $conn->error);
        exit();
      }

    # Creamos session para los usuarios.
    session_start();
    
    # Identificamos al usuario a través del $_SESSION['id].
    if($_SESSION['id']){

        $result_sql_user = $conn->query("SELECT * FROM users WHERE id='". $_SESSION['id'] ."'");
        $user = $result_sql_user->fetch_array();

        mysqli_query($conn, "UPDATE users SET last_reg='". date('Y-m-d H:i:s') ."' WHERE id='$user[id]'");
        
    }

    # Funciones
    require 'functions.php';

    # Configuración
    require 'config.php';

    # Idiomas
    require 'languages.php';
    

?>