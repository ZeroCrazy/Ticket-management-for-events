<?php

    /*
        CODETECH.ES
        Sistema de Eventos 
        Departamento de Electrónica

        Desarrollo de un sistema de entradas para eventos y listado de participantes
        Autor: Daniel Garzón (ZeroCrazy)
        Año: 2023
    */

    # Conexión global
    require 'inc/conn.php'; 
    
    if($_SESSION['id']){

        echo href($url . '/home', 0);
        die();

    } else {

        echo href($url . '/login', 0);
        die();

    }

?>