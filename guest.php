<?php

    /*
        CODETECH.ES
        Sistema de Eventos 
        Departamento de Electrónica

        Desarrollo de un sistema de entradas para eventos y listado de participantes
        Autor: Daniel Garzón (ZeroCrazy)
        Año: 2023
    */

    
    require 'header.php';
    if(!$_SESSION['id']){

      echo href($url, 0);
      die();

    }

    if(rank($conn, $user['rank'], 'guest_view') == 0){
      echo href($url . '/home', 0);
      die();
    }

    $get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));

    $rp = $conn->query("SELECT * FROM events WHERE id='$get'");$e = $rp->fetch_array();

    if(!$e['id']) {

      echo href($url . '/home', 0);
      die();
      
    }

?>
<main>
<div class="container">
  <div class="row">
    <div class="col s12 m12 black-text">
      <h3 class="card-title" style="padding: 40px 0px;"><i class="fal fa-clipboard-list-check"></i> <b>Check-in</b>
      <a href="<?php echo $url; ?>/guests/<?php echo $e['id']; ?>/create" class="btn-floating btn-small red right tooltipped" data-position="top" data-tooltip="Crear" style="margin-left: 10px;"><i class="material-icons">add</i></a>
      <a href="<?php echo $url; ?>/events/<?php echo $e['id']; ?>" class="btn-floating btn-small white right tooltipped" data-position="left" data-tooltip="Atrás"><i class="fal fa-arrow-alt-left black-text"></i></a>
      </h3>
    </div>

    <div class="col s12 m12">
      <table id="table" class="responsive-table">
        <thead>
          <tr>
              <th><i class="fal fa-user"></i> Persona</th>
              <th><i class="fal fa-id-card"></i> DNI</th>
              <th><i class="fal fa-glass-cheers"></i> Evento</th>
              <th><i class="fal fa-ticket"></i> Entrada</th>
              <!--<th><i class="fal fa-microchip"></i> RRPP</th>-->
              <th><i class="fal fa-door-closed"></i> Check-in</th>
          </tr>
        </thead>

        <tbody>
          
        <?php $rtp = $conn->query("SELECT * FROM tickets WHERE event_id='$e[id]'");while ($t = $rtp->fetch_assoc()) { ?>
          <tr data-href="<?php echo $url; ?>/tv/<?php echo $t['code']; ?>">
            <td><?php echo $t['name'] ?></td>
            <td><?php echo $t['dni'] ?></td>
            <td><?php echo $e['name'] ?></td>
            <td><?php echo ticket($conn, $t['event_ticket_id'], 'name'); ?> (<?php echo ticket($conn, $t['event_ticket_id'], 'price'); ?>&euro;)</td>
            <!--<td><?php echo user($conn, $t['user_id'], 'name'); ?></td>-->
            <td><?php if($t['checkin'] == 'yes'){ echo '<i class="fal fa-door-open"></i> Sí ';echo date("H:i", strtotime($t['checkin_date'])); } else { echo '<i class="fal fa-door-closed"></i> No'; } ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>

  </div>
</div>
</main>
<script type="text/javascript">
$(document).ready( function () {

    // Indicamos que al poner el mouse por encima de cada registro, vaya al enlace que pongamos en el data-href
    $('#table').on('click', 'tbody tr', function() {
      window.location.href = $(this).data('href');
    });
    
    // Configuración de las tablas
    $('#table').DataTable( {
      "responsive": true,
      "bPaginate": true,
      "bLengthChange": true,
      "bInfo": false,
      "bFilter": true,
      "order": [[ 1, "desc" ]]
    } );

} );
</script>