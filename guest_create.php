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

    if(rank($conn, $user['rank'], 'guest_create') == 0){
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
<style>
  .select-wrapper input.select-dropdown {
    color: #fff;
    border: none !important;
    text-align: center;
  }
  .select-wrapper .caret {
    fill: rgb(255 255 255 / 87%);
  }
  .browser-default {
    background-color: transparent;
    border: none !important;
    font-size: 1rem;
    text-align: center;
    font-weight: bold;
    margin-bottom: 9px;
  }
</style>
<main>

  <div class="container">
    <div class="row">
      
      <div class="col s12 m12" style="margin-bottom: 40px;">
        <h3 class="card-title center white-text">
          <a class="btn-small black-text white tooltipped" data-position="left" data-tooltip="Atrás" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;" href="<?php echo $url; ?>/guests/<?php echo $e['id']; ?>"><i class="fal fa-arrow-alt-left"></i></a>
          <form style="display: contents;" id="create" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/guest_create&event_id=<?php echo $e['id']; ?>">
          <button type="submit" class="btn-small white-text green tooltipped" data-position="right" data-tooltip="Crear" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;"><i class="fal fa-check"></i></button>
          <br>
          <b>Asignar entrada</b></h3>
      </div>


        <div class="col s12 m6">
            <div class="card stats white-text black">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" type="text" name="name" placeholder="Ej: Daniel" required>
                </span>
                <span class="card-title period" style="line-height: 15px;">¿Quién comprará la entrada?<br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text red" style="overflow: visible;">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                <br>
                <div class="input-field col s12">
                  <select class="browser-default" name="event_ticket_id" required>
                    <option selected disabled>Seleccionar entrada...</option>
                  <?php $rtp = $conn->query("SELECT * FROM events_tickets WHERE event_id='$e[id]'");while ($t = $rtp->fetch_assoc()) { ?>
                    <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
                  <?php } ?>
                  </select>
                </div>
                </span>
                <span class="card-title period" style="line-height: 12.52px;">¿Qué entrada escogerá?<br><br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m12"></div>
        <div class="col s12 m6">
            <div class="card stats white-text green">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 2rem;" type="email" placeholder="Introduce un email..." name="email">
                </span>
                <span class="card-title period" style="line-height: 15px;">Correo electrónico<br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text green">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 2rem;" type="text" placeholder="Introduce un identificador..." name="dni">
                </span>
                <span class="card-title period" style="line-height: 15px;">DNI / NIE / NIF<br><br></span>
              </div>
            </div>
        </div>
      </form>

    </div>
  </div>





<div class="ev-banner blurry-flyer" style="background: url('<?php echo $url; ?>/assets/images/vaporwave_wallpaper.jpg');"></div>
</main>
<script type="text/javascript">
$(document).ready( function () {

    $("#create").submit(function(event){
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