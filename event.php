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

    if(rank($conn, $user['rank'], 'event_view') == 0){
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

  <div id="modal_delete_event" class="modal bottom-sheet">
    <div class="modal-content center">
      <h4><i style="border-radius: 100%;border: 1px solid transparent;" class="fal fa-exclamation-circle red white-text"></i> ¡Atención!</h4>
      <p class="event alert">Estás a punto de eliminar el evento "<?php echo $e['name']; ?>", ¿estás de acuerdo con la acción que estarás a punto de hacer? Los datos no se podrán recuperar...</p>
      <div class="row">
        <div class="col s6 m6">
          <a href="#!" class="modal-close col s12 waves-effect waves-green btn red"><b>No</b>, quiero conservarlo</a>
        </div>
        <div class="col s6 m6">
          <form id="delete_event" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/event_delete&id=<?php echo $e['id']; ?>">
            <button type="submit" href="#!" class="col s12 waves-effect waves-green btn green"><b>Sí</b>, deseo borrarlo</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      
      <div class="col s12 m12" style="margin-bottom: 40px;">
        <h3 class="card-title center white-text">
          <a class="btn-small black-text white tooltipped" data-position="left" data-tooltip="Atrás" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;" href="<?php echo $url; ?>/home"><i class="fal fa-arrow-alt-left"></i></a>
          <a href="#modal_delete_event" class="btn-small white-text red tooltipped modal-trigger" data-position="top" data-tooltip="Borrar" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;"><i class="fal fa-ban"></i></a>
          <form style="display: contents;" id="event" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/event&id=<?php echo $e['id']; ?>">
          <button type="submit" class="btn-small white-text green tooltipped" data-position="right" data-tooltip="Guardar" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;"><i class="fal fa-check"></i></button>
          <br>
          <b><?php echo $e['name']; ?></b></h3>
        <div class="center white-text"><?php echo dates('dia', date("l", strtotime($e['date_event']))); ?> <?php echo strftime('%d %B %Y',strtotime($e['date_event'])); ?><br><span>desde <?php echo $e['hour_event_a']; ?> a <?php echo $e['hour_event_b']; ?></span></div>
      </div>


        <a href="<?php echo $url; ?>/tickets/<?php echo $e['id']; ?>">
          <div class="col s6 m6">
              <div class="card stats pink tooltipped" data-position="top" data-tooltip="Entradas">
                <div class="card-content" style="height: 203.98px;">
                  <div class="row">
                    <div class="col s12 m12 center">
                      <span class="card-title titl white-text" style="margin-top: 38px;"><i class="fal fa-ticket-alt"></i></span>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </a>
        <a href="<?php echo $url; ?>/guests/<?php echo $e['id']; ?>">
          <div class="col s6 m6">
              <div class="card stats pink tooltipped" data-position="top" data-tooltip="Listado">
                <div class="card-content" style="height: 203.98px;">
                  <div class="row">
                    <div class="col s12 m12 center">
                      <span class="card-title titl white-text" style="margin-top: 38px;"><i class="fal fa-clipboard-list-check"></i></span>
                    </div>             
                  </div>
                </div>
              </div>
          </div>
        </a>
        <div class="col s12 m6">
            <div class="card stats white-text black">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" type="text" name="name" placeholder="Ej: Halloween party" value="<?php echo $e['name']; ?>" required>
                </span>
                <span class="card-title period" style="line-height: 15px;">¿Qué nombre merece el evento?<br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text black">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <textarea class="card-title titl white-text" style="font-size: 14px;height: 95px;border: none !important;resize: none;" type="text" name="description" placeholder="Introduce texto..."><?php echo $e['description']; ?></textarea>
                </span>
                <span class="card-title period" style="line-height: 15px;">¿Cómo lo describirías?<br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m12">
            <div class="card stats white">
              <div class="card-content">

              <div class="row">
                <div class="col s12 m4 center">
                  <span class="card-title titl" style="padding: 0px !important;">
                    <input class="card-title titl black-text timepicker" style="font-size: 2rem;" type="text" placeholder="Introduce una hora..." name="hour_event_a" value="<?php echo $e['hour_event_a']; ?>">
                  </span>
                  <span class="card-title black-text period" style="line-height: 15px;">¿Hora de entrada?<br><br></span>
                </div>

                <div class="col s12 m4 center">
                  <span class="card-title titl" style="padding: 0px !important;">
                    <input class="card-title titl black-text datepicker" maxlength="10" style="font-size: 2rem;" type="text" placeholder="Introduce una fecha..." name="date_event" value="<?php echo substr($e['date_event'], 0, 10); ?>">
                  </span>
                  <span class="card-title black-text period" style="line-height: 15px;">¿Día de evento?<br><br></span>
                </div>

                <div class="col s12 m4 center">
                  <span class="card-title titl" style="padding: 0px !important;">
                    <input class="card-title titl black-text timepicker" style="font-size: 2rem;" type="text" placeholder="Introduce una hora..." name="hour_event_b" value="<?php echo $e['hour_event_b']; ?>">
                  </span>
                  <span class="card-title black-text period" style="line-height: 15px;">¿Hora de salida?<br><br></span>
                </div>                
              </div>
              
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text green">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 1rem;" type="text" placeholder="Introduce una dirección..." name="address" value="<?php echo $e['address']; ?>">
                </span>
                <span class="card-title period" style="line-height: 15px;">¿Dónde se hará el evento?<br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text blue">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 2rem;" type="text" placeholder="Introduce un estilo..." name="musical_style" value="<?php echo $e['musical_style']; ?>">
                </span>
                <span class="card-title period" style="line-height: 15px;">¿Qué estilo músical será?<br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text orange">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 2rem;" type="number" min="1" placeholder="Introduce un número..." name="capacity" value="<?php echo $e['capacity']; ?>">
                </span>
                <span class="card-title period" style="line-height: 15px;">¿Cuál será el máx. aforo?<br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text red">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 1rem;" type="text" placeholder="Introduce un enlace..." name="banner_img" value="<?php echo $e['banner_img']; ?>">
                </span>
                <span class="card-title period" style="line-height: 15px;font-size: 1.3rem;padding: 0px 0px 15px 0px;">Pega el enlace generado<br><a class="black-text" href="https://www.imgur.com/" target="_blank">desde aquí</a><br><br></span>
              </div>
            </div>
        </div>
      </form>

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

    $("#event").submit(function(event){
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
    $("#delete_event").submit(function(event){
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