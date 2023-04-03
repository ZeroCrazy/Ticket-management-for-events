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
    require 'vendor/autoload.php';

    # En caso que tenga la sesión iniciada, permitirá los siguientes formularios...
    if($_SESSION['id']){


        # Borrar registro
        if($_GET['page'] == 'event_delete'){

            $get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));

            $result = $conn->query("SELECT * FROM events WHERE id='$get'");
            $g = $result->fetch_array();

            if(rank($conn, $user['rank'], 'event_delete') == 0){

                alert('No tienes permisos', 'red');

            } elseif(!$g['id']){

                echo alert('No existe', 'red');

            } else {

                mysqli_query($conn, "DELETE FROM events WHERE id='$get'");
                mysqli_query($conn, "DELETE FROM events_tickets WHERE event_id='$get'");
                echo href($url . '/home', 0);

            }

        }

        # Editar evento
        if($_GET['page'] == 'event'){

            $get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));
            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            $description = htmlspecialchars(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
            $hour_event_a = htmlspecialchars(filter_var($_POST['hour_event_a'], FILTER_SANITIZE_STRING));
            $hour_event_b = htmlspecialchars(filter_var($_POST['hour_event_b'], FILTER_SANITIZE_STRING));
            $date_event = htmlspecialchars(filter_var($_POST['date_event'], FILTER_SANITIZE_STRING));
            $banner_img = htmlspecialchars(filter_var($_POST['banner_img'], FILTER_SANITIZE_STRING));
            $address = htmlspecialchars($_POST['address']);
            $musical_style = htmlspecialchars(filter_var($_POST['musical_style'], FILTER_SANITIZE_STRING));
            $capacity = htmlspecialchars(filter_var($_POST['capacity'], FILTER_SANITIZE_STRING));

            $result = $conn->query("SELECT * FROM events WHERE id='$get'");
            $g = $result->fetch_array();

            if(rank($conn, $user['rank'], 'event_edit') == 0){

                alert('No tienes permisos', 'red');

            } elseif(!$g['id']){

                echo alert('No existe', 'red');

            } else {

                mysqli_query($conn, "UPDATE events SET name='$name', description='$description', hour_event_a='$hour_event_a', hour_event_b='$hour_event_b', date_event='$date_event', banner_img='$banner_img', address='$address', musical_style='$musical_style', capacity='$capacity' WHERE id='$g[id]'");
                #mysqli_query($conn, "UPDATE tfg_gases SET SN='$SN', CO2='$CO2', NH3='$NH3', humedad='$humedad', presion='$presion', temperatura='$temperatura', altitud='$altitud', ITH='$ITH' WHERE ID='$g[ID]'");
                echo alert('Cambios guardados', 'green');
                echo href($url . '/events/' . $g['id'], '2000');

            }

        }

        # Crear evento
        if($_GET['page'] == 'event_create'){

            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            $description = htmlspecialchars(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
            $hour_event_a = htmlspecialchars(filter_var($_POST['hour_event_a'], FILTER_SANITIZE_STRING));
            $hour_event_b = htmlspecialchars(filter_var($_POST['hour_event_b'], FILTER_SANITIZE_STRING));
            $date_event = htmlspecialchars(filter_var($_POST['date_event'], FILTER_SANITIZE_STRING));
            $banner_img = htmlspecialchars(filter_var($_POST['banner_img'], FILTER_SANITIZE_STRING));
            $address = htmlspecialchars($_POST['address']);
            $musical_style = htmlspecialchars(filter_var($_POST['musical_style'], FILTER_SANITIZE_STRING));
            $capacity = htmlspecialchars(filter_var($_POST['capacity'], FILTER_SANITIZE_STRING));

            if(rank($conn, $user['rank'], 'event_create') == 0){

                alert('No tienes permisos', 'red');

            } elseif(empty($name) || empty($description) || empty($hour_event_a) || empty($hour_event_b) || empty($date_event) || empty($banner_img) || empty($address) || empty($capacity)){

                echo alert($lang['event_create']['form']['messages']['empty'], 'red');

            } else {

                mysqli_query($conn, "INSERT INTO events (name,user_id,description,hour_event_a,hour_event_b,date_event,banner_img,address,musical_style,capacity,date_reg) VALUES ('$name','$user[id]','$description','$hour_event_a','$hour_event_b','$date_event','$banner_img','$address','$musical_style','$capacity',NOW())");
                echo alert($lang['event_create']['form']['messages']['success'], 'green');
                $result = $conn->query("SELECT * FROM events ORDER BY id DESC LIMIT 1");
                $e = $result->fetch_array();
                echo href($url . '/events/' . $e['id'], '1500');

            }
        }

        # Crear entrada para una persona
        if($_GET['page'] == 'guest_create'){

            $event_id = htmlspecialchars(filter_var($_GET['event_id'], FILTER_SANITIZE_STRING));
            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            $event_ticket_id = htmlspecialchars(filter_var($_POST['event_ticket_id'], FILTER_SANITIZE_STRING));
            $email = htmlspecialchars(filter_var($_POST['email'], FILTER_SANITIZE_STRING));
            $dni = htmlspecialchars(filter_var($_POST['dni'], FILTER_SANITIZE_STRING));
            $code = md5(uniqid($event_id . $name . $event_ticket_id . $dni . date('Y-m-d H:i:s'), true));

            if(rank($conn, $user['rank'], 'guest_create') == 0){
                
                alert('No tienes permisos', 'red');

            } elseif(empty($name) || empty($event_ticket_id)){

                echo alert('Rellena el formulario', 'red');

            } else {

                mysqli_query($conn, "INSERT INTO tickets (user_id,name,dni,event_id,event_ticket_id,code,email,date_reg) VALUES ('$user[id]','$name','$dni','$event_id','$event_ticket_id','$code','$email',NOW())");
                echo alert('Entrada creada', 'green');
                $result = $conn->query("SELECT * FROM tickets WHERE code='$code'");$g = $result->fetch_array();
                echo href($url . '/guests/' . $event_id, '1000');
                echo mailSend($s, $email, "[Ticket] Aquí tienes tu entrada!", "Hola ". $name .", para visualizar tu entrada haz clic en el siguiente botón que verás a continuación.", $code);


            }

        }

        # Comprobar entrada
        if($_GET['page'] == 'check_ticket'){

            $code = htmlspecialchars(filter_var($_POST['code'], FILTER_SANITIZE_STRING));
            $rp = $conn->query("SELECT * FROM tickets WHERE code='$code'");$t = $rp->fetch_array();            

            if(rank($conn, $user['rank'], 'check_ticket') == 0){
                
                alert('No tienes permisos', 'red');

            } elseif(empty($code)){

                echo alert($lang['check_ticket']['form']['empty'], 'red');
                
            } elseif($rp->num_rows <= 0){

                echo alert($lang['check_ticket']['form']['error'], 'red');
                echo media('error');
                
            } elseif($t['checkin'] == 'yes'){

                echo alert($lang['check_ticket']['form']['used'], 'orange');
                echo media('error');
                
            } else {
                
                echo alert($lang['check_ticket']['form']['success'], 'green');
                echo media('success');
                mysqli_query($conn, "UPDATE tickets SET checkin='yes', checkin_date=NOW(), auth_id='$user[id]' WHERE id='$t[id]'");

            }


        }

        # Editar ticket
        if($_GET['page'] == 'ticket'){

            $ticket_get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));
            $event_get = htmlspecialchars(filter_var($_GET['e'], FILTER_SANITIZE_STRING));
            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            $price = htmlspecialchars(filter_var($_POST['price'], FILTER_SANITIZE_STRING));
            $tickets = htmlspecialchars(filter_var($_POST['tickets'], FILTER_SANITIZE_STRING));

            $result = $conn->query("SELECT * FROM events WHERE id='$event_get'");
            $e = $result->fetch_array();

            $resultx = $conn->query("SELECT * FROM events_tickets WHERE id='$ticket_get'");
            $t = $resultx->fetch_array();
            
            if(rank($conn, $user['rank'], 'ticket_edit') == 0){
                
                alert('No tienes permisos', 'red');

            } elseif(!$e['id']){

                echo alert('No existe evento', 'red');

            } else {

                if(!$t['id']){

                    echo alert('No existe ticket', 'red');

                } else {

                    mysqli_query($conn, "UPDATE events_tickets SET name='$name', price='$price', tickets='$tickets' WHERE id='$t[id]'");
                    echo alert('Cambios guardados', 'green');
                    #echo href($url . '/events/' . $e['id'], '2000');

                }

            }

        }

        # Crear ticket
        if($_GET['page'] == 'ticket_new'){

            $event_get = htmlspecialchars(filter_var($_GET['e'], FILTER_SANITIZE_STRING));
            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            $price = htmlspecialchars(filter_var($_POST['price'], FILTER_SANITIZE_STRING));
            $tickets = htmlspecialchars(filter_var($_POST['tickets'], FILTER_SANITIZE_STRING));

            $result = $conn->query("SELECT * FROM events WHERE id='$event_get'");
            $e = $result->fetch_array();

            if(rank($conn, $user['rank'], 'ticket_create') == 0){
                
                alert('No tienes permisos', 'red');

            } elseif(!$e['id']){

                echo alert('No existe evento', 'red');

            } else {

                mysqli_query($conn, "INSERT INTO events_tickets (event_id,name,tickets,price,date_reg) VALUES ('$e[id]','$name','$tickets','$price',NOW())");
                echo alert('Cambios guardados', 'green');
                echo href($url . '/tickets/' . $e['id'], '1500');

            }

        }

        # Borrar ticket
        if($_GET['page'] == 'ticket_delete'){

            $get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));

            $result = $conn->query("SELECT * FROM events_tickets WHERE id='$get'");
            $g = $result->fetch_array();

            if(rank($conn, $user['rank'], 'ticket_delete') == 0){
                
                alert('No tienes permisos', 'red');

            } elseif(!$g['id']){

                echo alert('No existe', 'red');

            } else {

                mysqli_query($conn, "DELETE FROM events_tickets WHERE id='$get'");
                echo href($url . '/tickets/' . $g['event_id'], 0);

            }

        }

        # Crear usuario
        if($_GET['page'] == 'users_create'){

            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            $username = htmlspecialchars(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
            $password = htmlspecialchars(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
            $rank = htmlspecialchars(filter_var($_POST['rank'], FILTER_SANITIZE_STRING));

            $result_user = $conn->query("SELECT * FROM users WHERE username='$username'");$u = $result_user->fetch_array();

            if(rank($conn, $user['rank'], 'users_create') == 0){

                alert('No tienes permisos', 'red');

            } elseif(empty($name) || empty($username) || empty($password) || empty($rank)){

                alert('Faltan campos por rellenar', 'red');

            } elseif($result_user->num_rows > 0){

                alert('Ya existe ' . $username, 'red');

            } else {

                alert('Cambios guardados', 'green');
                mysqli_query($conn, "INSERT INTO users (username,password,name,rank,date_reg) VALUES ('$username','". password_hash($password, PASSWORD_BCRYPT) ."','$name','$rank','". date('Y-m-d H:i:s') ."')");

            }


        }

        # Crear rango
        if($_GET['page'] == 'ranks_create'){

            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            # Evento
            $event_view = htmlspecialchars(filter_var(isset($_POST['event_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $event_edit = htmlspecialchars(filter_var(isset($_POST['event_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $event_delete = htmlspecialchars(filter_var(isset($_POST['event_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $event_create = htmlspecialchars(filter_var(isset($_POST['event_create']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Check-in
            $guest_view = htmlspecialchars(filter_var(isset($_POST['guest_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $guest_edit = htmlspecialchars(filter_var(isset($_POST['guest_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $guest_delete = htmlspecialchars(filter_var(isset($_POST['guest_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $guest_create = htmlspecialchars(filter_var(isset($_POST['guest_create']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Entrada
            $ticket_view = htmlspecialchars(filter_var(isset($_POST['ticket_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ticket_edit = htmlspecialchars(filter_var(isset($_POST['ticket_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ticket_delete = htmlspecialchars(filter_var(isset($_POST['ticket_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ticket_create = htmlspecialchars(filter_var(isset($_POST['ticket_create']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Comprobar entrada
            $check_ticket = htmlspecialchars(filter_var(isset($_POST['check_ticket']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Users
            $users_view = htmlspecialchars(filter_var(isset($_POST['users_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $users_edit = htmlspecialchars(filter_var(isset($_POST['users_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $users_delete = htmlspecialchars(filter_var(isset($_POST['users_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $users_create = htmlspecialchars(filter_var(isset($_POST['users_create']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Rangos
            $ranks_view = htmlspecialchars(filter_var(isset($_POST['ranks_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ranks_edit = htmlspecialchars(filter_var(isset($_POST['ranks_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ranks_delete = htmlspecialchars(filter_var(isset($_POST['ranks_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ranks_create = htmlspecialchars(filter_var(isset($_POST['ranks_create']) ? 1 : 0, FILTER_SANITIZE_STRING));

            if(rank($conn, $user['rank'], 'ranks_create') == 0){

                alert('No tienes permisos', 'red');

            } else {

                alert($check_ticket, 'green');
                echo "<script>$('#new_rank').modal('close');</script>";
                mysqli_query($conn, "INSERT INTO ranks (name,event_view,event_edit,event_delete,event_create,guest_view,guest_edit,guest_delete,guest_create,ticket_view,ticket_edit,ticket_delete,ticket_create,check_ticket,users_view,users_edit,users_delete,users_create,ranks_view,ranks_edit,ranks_delete,ranks_create) VALUES ('$name','$event_view','$event_edit','$event_delete','$event_create','$guest_view','$guest_edit','$guest_delete','$guest_create','$ticket_view','$ticket_edit','$ticket_delete','$ticket_create','$check_ticket','$users_view','$users_edit','$users_delete','$users_create','$ranks_view','$ranks_edit','$ranks_delete','$ranks_create')");

            }

        }

        # Editar permisos de rango
        if($_GET['page'] == 'ranks_edit'){

            $get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));
            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            # Evento
            $event_view = htmlspecialchars(filter_var(isset($_POST['event_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $event_edit = htmlspecialchars(filter_var(isset($_POST['event_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $event_delete = htmlspecialchars(filter_var(isset($_POST['event_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $event_create = htmlspecialchars(filter_var(isset($_POST['event_create']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Check-in
            $guest_view = htmlspecialchars(filter_var(isset($_POST['guest_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $guest_edit = htmlspecialchars(filter_var(isset($_POST['guest_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $guest_delete = htmlspecialchars(filter_var(isset($_POST['guest_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $guest_create = htmlspecialchars(filter_var(isset($_POST['guest_create']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Entrada
            $ticket_view = htmlspecialchars(filter_var(isset($_POST['ticket_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ticket_edit = htmlspecialchars(filter_var(isset($_POST['ticket_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ticket_delete = htmlspecialchars(filter_var(isset($_POST['ticket_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ticket_create = htmlspecialchars(filter_var(isset($_POST['ticket_create']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Comprobar entrada
            $check_ticket = htmlspecialchars(filter_var(isset($_POST['check_ticket']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Users
            $users_view = htmlspecialchars(filter_var(isset($_POST['users_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $users_edit = htmlspecialchars(filter_var(isset($_POST['users_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $users_delete = htmlspecialchars(filter_var(isset($_POST['users_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $users_create = htmlspecialchars(filter_var(isset($_POST['users_create']) ? 1 : 0, FILTER_SANITIZE_STRING));
            # Rangos
            $ranks_view = htmlspecialchars(filter_var(isset($_POST['ranks_view']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ranks_edit = htmlspecialchars(filter_var(isset($_POST['ranks_edit']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ranks_delete = htmlspecialchars(filter_var(isset($_POST['ranks_delete']) ? 1 : 0, FILTER_SANITIZE_STRING));
            $ranks_create = htmlspecialchars(filter_var(isset($_POST['ranks_create']) ? 1 : 0, FILTER_SANITIZE_STRING));


            $result_rank = $conn->query("SELECT * FROM ranks WHERE id='$get'");$r = $result_rank->fetch_array();
            
            if(rank($conn, $user['rank'], 'ranks_edit') == 0){

                alert('No tienes permisos', 'red');

            } elseif($result_rank->num_rows <= 0){

                alert('Rango erróneo', 'red');

            } else {

                alert('Cambios guardados', 'green');
                mysqli_query($conn, "UPDATE ranks SET name='$name', event_view='$event_view', event_edit='$event_edit', event_delete='$event_delete', event_create='$event_create', guest_view='$guest_view', guest_edit='$guest_edit', guest_delete='$guest_delete', guest_create='$guest_create', ticket_view='$ticket_view', ticket_edit='$ticket_edit', ticket_delete='$ticket_delete', ticket_create='$ticket_create', check_ticket='$check_ticket', users_view='$users_view', users_edit='$users_edit', users_delete='$users_delete', users_create='$users_create', ranks_view='$ranks_view', ranks_edit='$ranks_edit', ranks_delete='$ranks_delete', ranks_create='$ranks_create' WHERE id='$r[id]'");

            }

        }

        # Editar usuario
        if($_GET['page'] == 'users_edit'){

            $get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));
            $name = htmlspecialchars(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            $rank = htmlspecialchars(filter_var($_POST['rank'], FILTER_SANITIZE_STRING));

            $result_user = $conn->query("SELECT * FROM users WHERE id='$get'");$u = $result_user->fetch_array();

            if(!$_POST['password'] == null){
                $password = password_hash(htmlspecialchars(filter_var($_POST['password'], FILTER_SANITIZE_STRING)), PASSWORD_BCRYPT);
            } else {
                $password = $u['password'];
            }

            if(rank($conn, $user['rank'], 'users_edit') == 0){

                alert('No tienes permisos', 'red');

            } elseif($result_user->num_rows <= 0){

                alert('Usuario erróneo', 'red');

            } else {

                alert('Cambios guardados', 'green');
                mysqli_query($conn, "UPDATE users SET name='$name', rank='$rank', password='$password' WHERE id='$u[id]'");

            }


        }


    } else {

        # Iniciar sesión
        if($_GET['page'] == 'login'){
            
            $username = htmlspecialchars(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
            $password = htmlspecialchars(filter_var($_POST['password'], FILTER_SANITIZE_STRING));

            $result_user = $conn->query("SELECT * FROM users WHERE username='$username'");$userresult = $result_user->fetch_array();

            if(empty($username) && empty($password)){

                echo alert('Faltan campos por rellenar', 'red');

            } elseif($result_user->num_rows <= 0){

                echo alert('Usuario erróneo', 'red');

            } elseif(password_verify($password, $userresult['password'])){
                
                echo alert('Iniciando sesión...', 'green');
                $_SESSION['id'] = $userresult['id'];
                echo href($url . '/home', '1000');

            } else {
                echo alert('Contraseña errónea', 'red');
            }

        }


    }

?>