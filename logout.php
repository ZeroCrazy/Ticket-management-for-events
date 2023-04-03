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
    require 'header.php'; 

    # Destruye la $_SESSION['id] actual.
    session_destroy();

    # Redirecciona instantáneamente a $url
    echo href($url, '0');
?>