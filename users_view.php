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

    if(rank($conn, $user['rank'], 'users_view') == 0){
      echo href($url . '/home', 0);
      die();
    }

    $get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));

    $rp = $conn->query("SELECT * FROM users WHERE id='$get'");$u = $rp->fetch_array();

    if(!$u['id']) {

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
    <div class="col s12 m12 black-text">
      <h3 class="card-title" style="padding: 40px 0px;"><i class="fal fa-user"></i> <b><?php echo $u['name']; ?></b>
      <form style="display: contents;" id="edit" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/users_edit&id=<?php echo $u['id']; ?>">
      <button type="submit" class="btn-small white-text green right tooltipped" data-position="top" data-tooltip="Guardar" style="margin-left: 10px;border-radius: 100%;padding: 0px 7px;"><i class="fal fa-check"></i></button>
      <a href="<?php echo $url; ?>/home" class="btn-floating btn-small white right tooltipped" data-position="left" data-tooltip="Atrás"><i class="fal fa-arrow-alt-left black-text"></i></a>
      </h3>
    </div>

    <div class="col s12 m6">
      <div class="card stats black-text white">
        <div class="card-content">
          <span class="card-title titl" style="padding: 0px !important;">
            <input class="card-title titl black-text" type="text" name="name" placeholder="..." value="<?php echo $u['name']; ?>" required>
          </span>
          <span class="card-title period" style="line-height: 15px;">Nombre y/o apellido<br><br></span>
        </div>
      </div>
    </div>

    <div class="col s12 m6">
        <div class="card stats black-text white" style="overflow: visible;">
          <div class="card-content">
            <span class="card-title titl" style="padding: 0px !important;">
            <br>
            <div class="input-field col s12">
              <select class="browser-default" name="rank" required>
                <option selected disabled>Seleccionar entrada...</option>
                <option value="<?php echo $u['rank']; ?>" selected><?php echo rank($conn, $u['rank'], "name"); ?></option>
              <?php $rtp = $conn->query("SELECT * FROM ranks");while ($r = $rtp->fetch_assoc()) { ?>
                <option value="<?php echo $r['id']; ?>"><?php echo $r['name']; ?></option>
              <?php } ?>
              </select>
            </div>
            </span>
            <span class="card-title period" style="line-height: 12.52px;">Rango<br><br><br></span>
          </div>
        </div>
    </div>

    <div class="col s12 m12"></div>

    <div class="col s12 m6">
      <div class="card stats black-text white">
        <div class="card-content">
          <span class="card-title titl" style="padding: 0px !important;">
            <input class="card-title titl black-text" type="text" name="username" placeholder="..." value="<?php echo $u['username']; ?>" disabled>
          </span>
          <span class="card-title period" style="line-height: 15px;">Nombre de usuario<br><br></span>
        </div>
      </div>
    </div>

    <div class="col s12 m6">
      <div class="card stats black-text white">
        <div class="card-content">
          <span class="card-title titl" style="padding: 0px !important;">
            <input class="card-title titl black-text" type="password" name="password" placeholder="...">
          </span>
          <span class="card-title period" style="line-height: 15px;">Contraseña<br><br></span>
        </div>
      </div>
    </div>

    <div class="col s12 m6">
      <div class="card stats black-text white">
        <div class="card-content">
          <span class="card-title titl" style="padding: 0px !important;">
            <input class="card-title titl black-text" type="text" disabled name="last_reg" placeholder="..." value="<?php echo date("d/m/y - H:i", strtotime($u['last_reg'])); ?>">
          </span>
          <span class="card-title period" style="line-height: 15px;">Últ. conexión<br><br></span>
        </div>
      </div>
    </div>

    <div class="col s12 m6">
      <div class="card stats black-text white">
        <div class="card-content">
          <span class="card-title titl" style="padding: 0px !important;">
            <input class="card-title titl black-text" type="text" disabled name="date_reg" placeholder="..." value="<?php echo date("d/m/y - H:i", strtotime($u['date_reg'])); ?>">
          </span>
          <span class="card-title period" style="line-height: 15px;">Fecha creación<br><br></span>
        </div>
      </div>
    </div>
    </form>

  </div>
</div>
</main>
<script type="text/javascript">
$(document).ready( function () {

    $("#edit").submit(function(event){
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
      "order": [[ 2, "desc" ]]
    } );

} );
</script>