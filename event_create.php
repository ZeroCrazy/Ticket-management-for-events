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

    if(rank($conn, $user['rank'], 'event_create') == 0){
      echo href($url . '/home', 0);
      die();
    }

?>
<main>

  <div class="container">
    <div class="row">
      
      <div class="col s12 m12" style="margin-bottom: 40px;">
        <h3 class="card-title center white-text">
          <a class="btn-small black-text white tooltipped" data-position="left" data-tooltip="<?php echo $lang['back']; ?>" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;" href="<?php echo $url; ?>/home"><i class="fal fa-arrow-alt-left"></i></a>
          <form style="display: contents;" id="create" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/event_create">
          <button type="submit" class="btn-small white-text green tooltipped" data-position="right" data-tooltip="<?php echo $lang['create']; ?>" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;"><i class="fal fa-check"></i></button>
          <br>
          <b><?php echo $lang['event_create']['name']; ?></b></h3>
      </div>


        <div class="col s12 m6">
            <div class="card stats white-text black">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" type="text" name="name" placeholder="..." required>
                </span>
                <span class="card-title period" style="line-height: 15px;"><?php echo $lang['event_create']['form']['name']; ?><br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text black">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <textarea class="card-title titl white-text" style="font-size: 14px;height: 95px;border: none !important;resize: none;" type="text" name="description" placeholder="..."></textarea>
                </span>
                <span class="card-title period" style="line-height: 15px;"><?php echo $lang['event_create']['form']['description']; ?><br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m12">
            <div class="card stats white">
              <div class="card-content">

              <div class="row">
                <div class="col s12 m4 center">
                  <span class="card-title titl" style="padding: 0px !important;">
                    <input class="card-title titl black-text timepicker" style="font-size: 2rem;" type="text" placeholder="..." name="hour_event_a" required>
                  </span>
                  <span class="card-title black-text period" style="line-height: 15px;"><?php echo $lang['event_create']['form']['hour_event_a']; ?><br><br></span>
                </div>

                <div class="col s12 m4 center">
                  <span class="card-title titl" style="padding: 0px !important;">
                    <input class="card-title titl black-text datepicker" maxlength="10" style="font-size: 2rem;" type="text" placeholder="..." name="date_event" required>
                  </span>
                  <span class="card-title black-text period" style="line-height: 15px;"><?php echo $lang['event_create']['form']['date_event']; ?><br><br></span>
                </div>

                <div class="col s12 m4 center">
                  <span class="card-title titl" style="padding: 0px !important;">
                    <input class="card-title titl black-text timepicker" style="font-size: 2rem;" type="text" placeholder="..." name="hour_event_b" required>
                  </span>
                  <span class="card-title black-text period" style="line-height: 15px;"><?php echo $lang['event_create']['form']['hour_event_b']; ?><br><br></span>
                </div>                
              </div>
              
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text green">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 1rem;" type="text" placeholder="..." name="address">
                </span>
                <span class="card-title period" style="line-height: 15px;"><?php echo $lang['event_create']['form']['address']; ?><br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text blue">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 2rem;" type="text" placeholder="..." name="musical_style">
                </span>
                <span class="card-title period" style="line-height: 15px;"><?php echo $lang['event_create']['form']['musical_style']; ?><br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text orange">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 2rem;" type="number" min="1" placeholder="..." name="capacity" required>
                </span>
                <span class="card-title period" style="line-height: 15px;"><?php echo $lang['event_create']['form']['capacity']; ?><br><br></span>
              </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card stats white-text red">
              <div class="card-content">
                <span class="card-title titl" style="padding: 0px !important;">
                  <input class="card-title titl white-text" style="font-size: 1rem;" type="text" placeholder="..." name="banner_img">
                </span>
                <span class="card-title period" style="line-height: 15px;font-size: 1.3rem;padding: 0px 0px 15px 0px;"><?php echo $lang['event_create']['form']['banner_img']; ?><br><br></span>
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