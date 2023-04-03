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

    if(rank($conn, $user['rank'], 'ticket_view') == 0){
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

  <div id="new_ticket" class="modal bottom-sheet">
    <form id="ticket_new" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/ticket_new&e=<?php echo $e['id']; ?>">
    <div class="modal-content">
      <h4><i style="border-radius: 100%;border: 1px solid transparent;" class="fal fa-plus-circle green white-text"></i> Entrada</h4>
      <p class="event alert">Como bien dice el titulo... "entrada = ticket" para acceder al local</p>
      <div class="row">
        <div class="input-field col s12 m4">
          <input id="namex<?php echo $t['id']; ?>" name="name" type="text" class="validate">
          <label for="namex">Nombre</label>
        </div>
        <div class="input-field col s12 m4">
          <input id="pricex<?php echo $t['id']; ?>" name="price" type="number" min="0" step="1" class="validate">
          <label for="pricex">Precio ( &euro; )</label>
        </div>
        <div class="input-field col s12 m4">
          <input id="ticketsx<?php echo $t['id']; ?>" name="tickets" type="number" min="0" step="1" class="validate">
          <label for="ticketsx">Nº Tickets</label>
        </div>
      </div>
      <div class="row">
        <div class="col s6 m6">
          <a href="#!" class="modal-close col s12 waves-effect waves-green btn red">Cerrar</a>
        </div>
        <div class="col s6 m6">
          <button type="submit" href="#!" class="col s12 waves-effect waves-green btn green">Guardar</button>
        </div>
      </div>
    </div>
    </form>
  </div>

  <div class="container">
    <div class="row">
      
      <div class="col s12 m12" style="margin-bottom: 40px;">
        <h3 class="card-title center white-text">
          <a class="btn-small black-text white tooltipped" data-position="left" data-tooltip="Atrás" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;" href="<?php echo $url; ?>/events/<?php echo $e['id']; ?>"><i class="fal fa-arrow-alt-left"></i></a>
          <a href="#new_ticket" class="btn-small white-text green tooltipped modal-trigger" data-position="right" data-tooltip="Nuevo" style="margin-top: -5px;border-radius: 100%;padding: 0px 8px;"><i class="fal fa-plus"></i></a>
          <br>
          <b><?php echo $e['name']; ?></b></h3>
        <div class="center white-text"><?php echo dates('dia', date("l", strtotime($e['date_event']))); ?> <?php echo strftime('%d %B %Y',strtotime($e['date_event'])); ?><br><span>desde <?php echo $e['hour_event_a']; ?> a <?php echo $e['hour_event_b']; ?></span></div>
      </div>

      <?php 
        $grpp = $conn->query("SELECT * FROM events_tickets WHERE event_id='$e[id]' ORDER BY id");while ($t = $grpp->fetch_assoc()) {
      ?>
      <form style="display: contents;" id="ticket<?php echo $t['id']; ?>" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/ticket&id=<?php echo $t['id']; ?>&e=<?php echo $e['id']; ?>">
        <div class="col s12 m6">
          <div class="card tickets">
            <div class="card-content white-text">
              <input type="text" name="name" value="<?php echo $t['name']; ?>" class="card-title name">
              <div class="row">
                <div class="input-field col s6">
                  <input id="price<?php echo $t['id']; ?>" value="<?php echo $t['price']; ?>" name="price" type="number" min="0" step="1" class="validate">
                  <label for="price">Precio ( &euro; )</label>
                </div>
                <div class="input-field col s6">
                  <input id="tickets<?php echo $t['id']; ?>" value="<?php echo $t['tickets']; ?>" name="tickets" type="number" min="0" step="1" class="validate">
                  <label for="tickets">Nº Tickets</label>
                </div>
                <div class="input-field col s6">
                  <a href="#modal_delete_event<?php echo $t['id']; ?>" type="submit" class="col s12 waves-effect waves-green btn red modal-trigger">Borrar</a>
                </div>
                <div class="input-field col s6">
                  <button type="submit" href="#!" class="col s12 waves-effect waves-green btn green">Guardar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>

      <div id="modal_delete_event<?php echo $t['id']; ?>" class="modal bottom-sheet">
        <div class="modal-content center">
          <h4><i style="border-radius: 100%;border: 1px solid transparent;" class="fal fa-exclamation-circle red white-text"></i> ¡Atención!</h4>
          <p class="event alert">Estás a punto de eliminar el ticket de <?php echo $e['name']; ?> "<?php echo $t['name']; ?>", ¿estás de acuerdo con la acción que estarás a punto de hacer? Los datos no se podrán recuperar...</p>
          <div class="row">
            <div class="col s6 m6">
              <a href="#!" class="modal-close col s12 waves-effect waves-green btn red"><b>No</b>, quiero conservarlo</a>
            </div>
            <div class="col s6 m6">
              <form id="delete_ticket<?php echo $t['id']; ?>" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/ticket_delete&id=<?php echo $t['id']; ?>">
                <button type="submit" href="#!" class="col s12 waves-effect waves-green btn green"><b>Sí</b>, deseo borrarlo</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>
        $("#ticket<?php echo $t['id']; ?>").submit(function(event){
            event.preventDefault();
            var post_url = $(this).attr("action");
            var request_method = $(this).attr("method");
            var form_data = $(this).serialize();
            
            $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){
                $("#server-results").html(response);
            });
        });
        $("#delete_ticket<?php echo $t['id']; ?>").submit(function(event){
            event.preventDefault();
            var post_url = $(this).attr("action");
            var request_method = $(this).attr("method");
            var form_data = $(this).serialize();
            
            $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){
                $("#server-results").html(response);
            });
        });
      </script>
      <?php } ?>

    </div>
  </div>





<div class="ev-banner blurry-flyer" style="background: url('<?php echo $e['banner_img']; ?>');"></div>
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

    $("#ticket_new").submit(function(event){
        event.preventDefault();
        var post_url = $(this).attr("action");
        var request_method = $(this).attr("method");
        var form_data = $(this).serialize();
        
        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data
        }).done(function(response){
            $("#server-results").html(response);
        });
    });

} );
</script>