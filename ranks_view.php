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

    if(rank($conn, $user['rank'], 'ranks_view') == 0){
      echo href($url . '/home', 0);
      die();
    }

    $get = htmlspecialchars(filter_var($_GET['id'], FILTER_SANITIZE_STRING));

    $rp = $conn->query("SELECT * FROM ranks WHERE id='$get'");$r = $rp->fetch_array();

    if(!$r['id']) {

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
      <h3 class="card-title" style="padding: 40px 0px;"><i class="fal fa-shield"></i> <b><?php echo $r['name']; ?></b>
      <form style="display: contents;" id="edit" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/ranks_edit&id=<?php echo $r['id']; ?>">
      <button type="submit" class="btn-small white-text green right tooltipped" data-position="top" data-tooltip="Guardar" style="margin-left: 10px;border-radius: 100%;padding: 0px 7px;"><i class="fal fa-check"></i></button>
      <a href="<?php echo $url; ?>/ranks" class="btn-floating btn-small white right tooltipped" data-position="left" data-tooltip="Atrás"><i class="fal fa-arrow-alt-left black-text"></i></a>
      </h3>
    </div>

    <div class="col s12 m6">
      <div class="card stats black-text white">
        <div class="card-content">
          <span class="card-title titl" style="padding: 0px !important;">
            <input class="card-title titl black-text" type="text" name="name" placeholder="..." value="<?php echo $r['name']; ?>" required>
          </span>
          <span class="card-title period" style="line-height: 15px;">Nombre del permiso<br><br></span>
        </div>
      </div>
    </div>

    <div class="col s12 m6">
      <div class="card black-text white">
        <div class="card-content">
        <span class="card-title">Comprobar entrada</span>
        <div class="card-title titl center" style="padding: 0px !important;">
                  <label>
                    <input type="checkbox" name="check_ticket" value="<?php echo $r['check_ticket']; ?>" <?php if($r['check_ticket'] == 1){ echo 'checked="checked"'; } ?> />
                    <span>Ver</span>
                  </label>
                  <span class="card-title period" style="line-height: 15px;">Ver<br><br><br></span>
                </div>

        </div>
      </div>
    </div>

    <div class="col s12 m12">
      <div class="card black-text white">
        <div class="card-content">
        <span class="card-title">Eventos</span>
            <div class="row">


              <div class="col s6 m3 center">
                <span class="card-title titl" style="padding: 0px !important;">
                  <label>
                    <input type="checkbox" name="event_view" value="<?php echo $r['event_view']; ?>" <?php if($r['event_view'] == 1){ echo 'checked="checked"'; } ?> />
                    <span>Ver</span>
                  </label>
                </span>
                <span class="card-title period" style="line-height: 15px;">Ver<br><br></span>
              </div>

              <div class="col s6 m3 center">
                <span class="card-title titl" style="padding: 0px !important;">
                  <label>
                    <input type="checkbox" name="event_edit" value="<?php echo $r['event_edit']; ?>" <?php if($r['event_edit'] == 1){ echo 'checked="checked"'; } ?> />
                    <span>Editar</span>
                  </label>
                </span>
                <span class="card-title period" style="line-height: 15px;">Editar<br><br></span>
              </div>

              <div class="col s6 m3 center">
                <span class="card-title titl" style="padding: 0px !important;">
                  <label>
                    <input type="checkbox" name="event_create" value="<?php echo $r['event_create']; ?>" <?php if($r['event_create'] == 1){ echo 'checked="checked"'; } ?> />
                    <span>Crear</span>
                  </label>
                </span>
                <span class="card-title period" style="line-height: 15px;">Crear<br><br></span>
              </div>

              <div class="col s6 m3 center">
                <span class="card-title titl" style="padding: 0px !important;">
                  <label>
                    <input type="checkbox" name="event_delete" value="<?php echo $r['event_delete']; ?>" <?php if($r['event_delete'] == 1){ echo 'checked="checked"'; } ?> />
                    <span>Borrar</span>
                  </label>
                </span>
                <span class="card-title period" style="line-height: 15px;">Borrar<br><br></span>
              </div>


            </div>
        </div>
      </div>


      <div class="card black-text white">
        <div class="card-content">
        <span class="card-title">Check-in</span>
            <div class="row">
              

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="guest_view" value="<?php echo $r['guest_view']; ?>" <?php if($r['guest_view'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Ver</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Ver<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="guest_edit" value="<?php echo $r['guest_edit']; ?>" <?php if($r['guest_edit'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Editar</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Editar<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="guest_create" value="<?php echo $r['guest_create']; ?>" <?php if($r['guest_create'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Crear</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Crear<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="guest_delete" value="<?php echo $r['guest_delete']; ?>" <?php if($r['guest_delete'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Borrar</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Borrar<br><br></span>
            </div>


            </div>
        </div>
      </div>

      
      <div class="card black-text white">
        <div class="card-content">
        <span class="card-title">Entrada</span>
            <div class="row">
              

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="ticket_view" value="<?php echo $r['ticket_view']; ?>" <?php if($r['ticket_view'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Ver</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Ver<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="ticket_edit" value="<?php echo $r['ticket_edit']; ?>" <?php if($r['ticket_edit'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Editar</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Editar<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="ticket_create" value="<?php echo $r['ticket_create']; ?>" <?php if($r['ticket_create'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Crear</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Crear<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="ticket_delete" value="<?php echo $r['ticket_delete']; ?>" <?php if($r['ticket_delete'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Borrar</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Borrar<br><br></span>
            </div>


            </div>
        </div>
      </div>


      <div class="card black-text white">
        <div class="card-content">
        <span class="card-title">Usuarios</span>
            <div class="row">
              

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="users_view" value="<?php echo $r['users_view']; ?>" <?php if($r['users_view'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Ver</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Ver<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="users_edit" value="<?php echo $r['users_edit']; ?>" <?php if($r['users_edit'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Editar</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Editar<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="users_create" value="<?php echo $r['users_create']; ?>" <?php if($r['users_create'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Crear</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Crear<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="users_delete" value="<?php echo $r['users_delete']; ?>" <?php if($r['users_delete'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Borrar</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Borrar<br><br></span>
            </div>


            </div>
        </div>
      </div>


      <div class="card black-text white">
        <div class="card-content">
        <span class="card-title">Rangos</span>
            <div class="row">
              

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="ranks_view" value="<?php echo $r['ranks_view']; ?>" <?php if($r['ranks_view'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Ver</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Ver<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="ranks_edit" value="<?php echo $r['ranks_edit']; ?>" <?php if($r['ranks_edit'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Editar</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Editar<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="ranks_create" value="<?php echo $r['ranks_create']; ?>" <?php if($r['ranks_create'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Crear</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Crear<br><br></span>
            </div>

            <div class="col s6 m3 center">
            <span class="card-title titl" style="padding: 0px !important;">
              <label>
                <input type="checkbox" name="ranks_delete" value="<?php echo $r['ranks_delete']; ?>" <?php if($r['ranks_delete'] == 1){ echo 'checked="checked"'; } ?> />
                <span>Borrar</span>
              </label>
            </span>
            <span class="card-title period" style="line-height: 15px;">Borrar<br><br></span>
            </div>


            </div>
        </div>
      </div>
    </div>

    <div class="col s12 m12"></div>

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