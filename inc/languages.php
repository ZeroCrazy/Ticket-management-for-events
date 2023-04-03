<?php

    if(isset($_SESSION['id'])){

        $lang = $user['language'];

    } else {

        $lang = $s['default_lang'];

    }

    $dir_langs = dirname(__DIR__, 1) . '/inc/languages/';
    if(file_exists($dir_langs . $lang . '.php')){

        require 'languages/' . $lang . '.php';

    } else {

        require 'languages/' . $lang . '.php';

    }

?>