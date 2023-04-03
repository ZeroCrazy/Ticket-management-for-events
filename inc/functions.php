<?php

    /*
        CODETECH.ES
        Sistema de Eventos 
        Departamento de Electrónica

        Desarrollo de un sistema de entradas para eventos y listado de participantes
        Autor: Daniel Garzón (ZeroCrazy)
        Año: 2023
    */

    
    # La función alert avisa con un mensaje en los formularios con diferentes tipos de estados.
    function alert($a,$b){
        /*
            $a -> cuerpo mensaje
            $b -> color
            $c -> tipo de mensaje (estados: warning, error, success, info, question)
        */
        echo '
        <script>
            M.toast(
                {
                    html: "'.$a.'",
                    classes: "'.$b.'"
                }
            )
        </script>
        ';
    }

    # La función href básicamente redirecciona al sitio web que se indique en la variable después de X*1000 segundos.
    function href($a, $b){
        /*
            $a -> enlace
            $b -> segundos (1 segundo = 1000)
        */
        echo "
        <script>
            var timer = setTimeout(function() {
                window.location='$a'
            }, $b);
        </script>
        ";
    }

    function media($a){
        echo '<audio style="position: absolute;visibility: hidden;" autoplay><source src="../assets/media/'.$a.'.mp3" type="audio/mpeg"></audio>';
    }

    function event($conn, $a, $b){

        $x = $conn->query("SELECT * FROM events WHERE id='$a'");$z = $x->fetch_array();
        echo $z[$b];

    }

    function ticket($conn, $a, $b){

        $x = $conn->query("SELECT * FROM events_tickets WHERE id='$a'");$z = $x->fetch_array();
        echo $z[$b];

    }

    function user($conn, $a, $b){

        $x = $conn->query("SELECT * FROM users WHERE id='$a'");$z = $x->fetch_array();
        echo $z[$b];

    }

    function rank($conn, $a, $b){

        $x = $conn->query("SELECT * FROM ranks WHERE id='$a'");$z = $x->fetch_array();
        return $z[$b];

    }
    
    function rank_total_permissions($conn, $a){

        $x = $conn->query("SELECT * FROM ranks WHERE id='$a'");$z = $x->fetch_array();
        return ($z['event_view']+$z['event_edit']+$z['event_delete']+$z['event_create']+$z['guest_view']+$z['guest_edit']+$z['guest_delete']+$z['guest_create']+$z['ticket_view']+$z['ticket_edit']+$z['ticket_delete']+$z['ticket_create']+$z['check_ticket']+$z['users_view']+$z['users_edit']+$z['users_delete']+$z['users_create']+$z['ranks_view']+$z['ranks_edit']+$z['ranks_delete']+$z['ranks_create']);

    }

    function rank_total_users($conn, $a){

        $x = $conn->query("SELECT * FROM users WHERE rank='$a'");$z = $x->fetch_array();
        return $x->num_rows;

    }

    function dates($a, $b){
        switch ($a) {
            case 'dia':
                $day = array(
                    'Monday' => 'Lunes',
                    'Tuesday' => 'Martes',
                    'Wednesday' => 'Miércoles',
                    'Thursday' => 'Jueves',
                    'Friday' => 'Viernes',
                    'Saturday' => 'Sábado',
                    'Sunday' => 'Domingo'
                );
                return $day[$b];
                break;

            case 'mes':
                $month = array(
                    'Enero' => 'January',
                    'Febrero' => 'February',
                    'Marzo' => 'March',
                    'Abril' => 'April',
                    'Mayo' => 'May',
                    'Junio' => 'June',
                    'Julio' => 'July',
                    'Agosto' => 'August',
                    'Septiembre' => 'September',
                    'Octubre' => 'October',
                    'Noviembre' => 'November',
                    'Diciembre' => 'December'
                );
                return $month[$b];
                break;
            
            default:
                return "DATE_ERROR";
                break;
        }
    }

    $dia=date("l");
	if ($dia=="Monday") $dia="Lunes";
	if ($dia=="Tuesday") $dia="Martes";
	if ($dia=="Wednesday") $dia="Miércoles";
	if ($dia=="Thursday") $dia="Jueves";
	if ($dia=="Friday") $dia="Viernes";
	if ($dia=="Saturday") $dia="Sábado";
	if ($dia=="Sunday") $dia="Domingo";
	$mes=date("F");
	if ($mes=="January") $mes="Enero";
	if ($mes=="February") $mes="Febrero";
	if ($mes=="March") $mes="Marzo";
	if ($mes=="April") $mes="Abril";
	if ($mes=="May") $mes="Mayo";
	if ($mes=="June") $mes="Junio";
	if ($mes=="July") $mes="Julio";
	if ($mes=="August") $mes="Agosto";
	if ($mes=="September") $mes="Septiembre";
	if ($mes=="October") $mes="Octubre";
	if ($mes=="November") $mes="Noviembre";
	if ($mes=="December") $mes="Diciembre";
	$ano=date("Y");
	$dia2=date("j");

    require 'functions_mail.php';
    
?>