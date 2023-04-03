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

?>
<!DOCTYPE html>
  <html>
    <head>
      
      <title><?php echo $name; ?></title>
      <link rel="icon" type="image/png" href="<?php echo $url; ?>/assets/images/motherboard.png">

      <!-- Fuentes -->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">

      <!-- CSS -->
      <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/assets/css/all.css">
      <link type="text/css" rel="stylesheet" href="<?php echo $url; ?>/assets/css/materialize.min.css"  media="screen,projection"/>
      <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/assets/css/style.css?v=<?php echo time(); ?>" />

      <!-- JS -->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script type="text/javascript" src="<?php echo $url; ?>/assets/js/materialize.min.js"></script>
      <script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

      <!-- Metas -->
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta name="theme-color" content="#006687">

      <!-- 
        ##
        # Scripts para inicializar el sidenav y modal
        ##

        sidenav: Es el menú que se desplaza de la izquierda a la derecha.
        modal: Cuando editas un registro, es el box que se abre.
    
      -->
      <script>
        $(document).ready(function(){
            $('.sidenav').sidenav();
            $('.modal').modal();
            $('.tooltipped').tooltip();
            $('.timepicker').timepicker({
              twelveHour: false
            });
            $('select').formSelect();
            $('.datepicker').datepicker({
              firstDay: true, 
              format: 'yyyy-mm-dd',
              i18n: {
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
              },
              cancel: 'Cancelar',
              clear: 'Limpar',
              done: 'Ok'
            });
        });
      </script>
    </head>

    <body>

    <main id="main">
    
    <!-- En `server-results` se mostrarán las alertas de los formularios -->
    <div id="server-results"></div>
    <?php if($_SESSION['id']){ ?>
        <header>
        <nav>
            <div class="nav-wrapper">
            <a href="<?php echo $url; ?>/home" class="brand-logo center"><?php echo $name; ?></a>
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="left hide-on-med-and-down">
                <li><a style="display: block;" href="#" data-target="slide-out" class="sidenav-trigger"><i style="font-size: 26px !important;" class="material-icons">menu</i></a></li>
            </ul>
            </div>
        </nav>
    

        <ul id="slide-out" class="sidenav">
            <li><a class="subheader"><?php echo $name; ?></a></li>
            <li>
              <div class="user-view">
                <div class="background">
                  <img src="<?php echo $url; ?>/assets/images/sidenav.jpg">
                </div>
                <a href="#user"><img class="circle" src="<?php echo $url; ?>/assets/images/profile.jpg"></a>
                <a href="#name"><span class="white-text name"><?php echo $user['name']; ?></span></a>
                <a href="#email"><span class="white-text email"><?php echo date('d/m/Y'); ?></span></a>
              </div>
            </li>
            <li><a href="<?php echo $url; ?>/home">Inicio</a></li>
            <?php if(rank($conn, $user['rank'], 'check_ticket') == 1){ ?>
            <li><a href="<?php echo $url; ?>/ticket/check">Comprobar entrada</a></li>
            <?php } ?>
            <?php if(rank($conn, $user['rank'], 'event_create') == 1){ ?>
            <li><a href="<?php echo $url; ?>/create/event">Crear evento</a></li>
            <?php } ?>
            <?php if(rank($conn, $user['rank'], 'users_view') == 1){ ?>
            <li><a href="<?php echo $url; ?>/users">Usuarios</a></li>
            <?php } ?>
            <?php if(rank($conn, $user['rank'], 'ranks_view') == 1){ ?>
            <li><a href="<?php echo $url; ?>/ranks">Rangos</a></li>
            <?php } ?>
            <li><a href="<?php echo $url; ?>/logout">Cerrar sesión</a></li>
        </ul>
        </header>
    <?php } ?>