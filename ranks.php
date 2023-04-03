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

?>
<main>

  <div id="new_rank" class="modal">
    <form id="user_new" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/ranks_create">
    <div class="modal-content">
      <h4><i style="border-radius: 100%;border: 1px solid transparent;" class="fal fa-plus-circle green white-text"></i> Nuevo rango</h4>
      <div class="row">

        <div class="input-field col s12 m6">
        <div class="card stats black-text white">
            <div class="card-content">
            <span class="card-title titl" style="padding: 0px !important;">
            <input class="card-title titl black-text" type="text" name="name" placeholder="..." value="<?php echo $r['name']; ?>" required>
          </span>
          <span class="card-title period" style="line-height: 15px;">Nombre del permiso<br><br></span>
            </div>
          </div>
        </div>

        <div class="input-field col s12 m6">
        <div class="card black-text white">
            <div class="card-content">
              <span class="card-title">Comprobar entrada</span>
              <div class="row center" style="margin: 0px !important;">
                <div class="col s6 m3">
                  <div class="card-title titl" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="check_ticket" />
                      <span>Ver</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Ver<br><br><br></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="input-field col s12 m12">
        <div class="card black-text white">
            <div class="card-content">
              <span class="card-title">Eventos</span>
              <div class="row" style="margin: 0px !important;">
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="event_view"/>
                      <span>Ver</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Ver<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="event_edit"/>
                      <span>Editar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Editar<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="event_create"/>
                      <span>Crear</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Crear<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="event_delete"/>
                      <span>Borrar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Borrar<br><br><br></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="input-field col s12 m12">
        <div class="card black-text white">
            <div class="card-content">
              <span class="card-title">Check-in</span>
              <div class="row" style="margin: 0px !important;">
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="guest_view"/>
                      <span>Ver</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Ver<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="guest_edit"/>
                      <span>Editar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Editar<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="guest_create"/>
                      <span>Crear</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Crear<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="guest_delete"/>
                      <span>Borrar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Borrar<br><br><br></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="input-field col s12 m12">
        <div class="card black-text white">
            <div class="card-content">
              <span class="card-title">Entrada</span>
              <div class="row" style="margin: 0px !important;">
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="ticket_view"/>
                      <span>Ver</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Ver<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="ticket_edit"/>
                      <span>Editar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Editar<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="ticket_create"/>
                      <span>Crear</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Crear<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="ticket_delete"/>
                      <span>Borrar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Borrar<br><br><br></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="input-field col s12 m12">
        <div class="card black-text white">
            <div class="card-content">
              <span class="card-title">Usuarios</span>
              <div class="row" style="margin: 0px !important;">
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="users_view"/>
                      <span>Ver</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Ver<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="users_edit"/>
                      <span>Editar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Editar<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="users_create"/>
                      <span>Crear</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Crear<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="users_delete"/>
                      <span>Borrar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Borrar<br><br><br></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="input-field col s12 m12">
        <div class="card black-text white">
            <div class="card-content">
              <span class="card-title">Rangos</span>
              <div class="row" style="margin: 0px !important;">
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="ranks_view"/>
                      <span>Ver</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Ver<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="ranks_edit"/>
                      <span>Editar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Editar<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="ranks_create"/>
                      <span>Crear</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Crear<br><br><br></span>
                  </div>
                </div>
                <div class="col s6 m3">
                  <div class="card-title titl center" style="padding: 0px !important;">
                    <label>
                      <input type="checkbox" name="ranks_delete"/>
                      <span>Borrar</span>
                    </label>
                    <span class="card-title period" style="line-height: 15px;">Borrar<br><br><br></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
      <h3 class="card-title" style="padding: 40px 0px;"><i class="fal fa-shield"></i> <b>Rangos</b>
      <a href="#new_rank" class="btn-floating btn-small red right tooltipped modal-trigger" data-position="top" data-tooltip="Crear" style="margin-left: 10px;"><i class="material-icons">add</i></a>
      <a href="<?php echo $url; ?>/home" class="btn-floating btn-small white right tooltipped" data-position="left" data-tooltip="Atrás"><i class="fal fa-arrow-alt-left black-text"></i></a>
      </h3>
    </div>

    <div class="col s12 m12">
      <table id="table" class="responsive-table">
        <thead>
          <tr>
              <th><i class="fal fa-shield"></i> Rango</th>
              <th><i class="fal fa-fist-raised"></i> Permisos</th>
              <th><i class="fal fa-user"></i> Usuarios</th>
          </tr>
        </thead>

        <tbody>
          
        <?php $rtp = $conn->query("SELECT * FROM ranks");while ($r = $rtp->fetch_assoc()) { ?>
          <tr data-href="<?php echo $url; ?>/ranks/<?php echo $r['id']; ?>">
            <td><?php echo $r['name']; ?></td>
            <td><?php echo rank_total_permissions($conn, $r['id']); ?></td>
            <td><?php echo rank_total_users($conn, $r['id']); ?></td>
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
      "order": [[ 1, "desc" ]]
    } );

} );
</script>