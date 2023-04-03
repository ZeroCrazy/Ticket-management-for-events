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

?>
<main>

  <div id="new_user" class="modal bottom-sheet">
    <form id="user_new" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/users_create">
    <div class="modal-content">
      <h4><i style="border-radius: 100%;border: 1px solid transparent;" class="fal fa-plus-circle green white-text"></i> Nuevo usuario</h4>
      <div class="row">
        <div class="input-field col s6 m3">
          <input id="name" name="name" type="text" class="validate" required>
          <label for="name">Nombre</label>
        </div>
        <div class="input-field col s6 m3">
          <input id="username" name="username" type="text" class="validate" required>
          <label for="username">Nombre de usuario</label>
        </div>
        <div class="input-field col s12 m3">
          <input id="password" name="password" type="password" class="validate" required>
          <label for="password">Contraseña</label>
        </div>
        <div class="input-field col s12 m3">
          <select name="rank" class="browser-default" required>
            <option value="" disabled selected>Rango</option>
            <?php $rtp = $conn->query("SELECT * FROM ranks");while ($r = $rtp->fetch_assoc()) { ?>
              <option value="<?php echo $r['id']; ?>"><?php echo $r['name']; ?></option>
              <?php } ?>
          </select>
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
    <div class="col s12 m12 black-text">
      <h3 class="card-title" style="padding: 40px 0px;"><i class="fal fa-user"></i> <b>Usuarios</b>
      <a href="#new_user" class="btn-floating btn-small red right tooltipped modal-trigger" data-position="top" data-tooltip="Crear" style="margin-left: 10px;"><i class="material-icons">add</i></a>
      <a href="<?php echo $url; ?>/home" class="btn-floating btn-small white right tooltipped" data-position="left" data-tooltip="Atrás"><i class="fal fa-arrow-alt-left black-text"></i></a>
      </h3>
    </div>

    <div class="col s12 m12">
      <table id="table" class="responsive-table">
        <thead>
          <tr>
              <th><i class="fal fa-user"></i> Usuario</th>
              <th><i class="fal fa-shield"></i> Rango</th>
              <th><i class="fal fa-clock"></i> Últ. conexión</th>
          </tr>
        </thead>

        <tbody>
          
        <?php $rtp = $conn->query("SELECT * FROM users");while ($u = $rtp->fetch_assoc()) { ?>
          <tr data-href="<?php echo $url; ?>/users/<?php echo $u['id']; ?>">
            <td><?php echo $u['name']; ?></td>
            <td><?php echo rank($conn, $u['rank'], "name"); ?></td>
            <td><?php echo date("d/m/y - H:i", strtotime($u['last_reg'])); ?></td>
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

    $("#user_new").submit(function(event){
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