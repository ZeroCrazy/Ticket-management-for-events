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

    if($_SESSION['id']){

      echo href($url, 0);
      die();

    }
    
?>

<style>
body {
  background: url(<?php echo $url; ?>/assets/images/vaporwave_wallpaper.jpg) center top;
  overflow: hidden;
}
.special {
  background: transparent;
  border: 2px solid #fff;
  filter: blur(5px);
}
#back-to-login {
  overflow: auto;
    background: transparent;
    border: 2px solid rgba(255,255,255,0.5);
    backdrop-filter: blur(15px);
}
h2 {
  font-weight: bold !important;
}
button {
  border-radius: 100px !important;
}
.card-title {
  margin-bottom: 1.424rem !important;
}
</style>

<div class="cover"></div>

<div class="container">
  <div class="row">
    <div class="col s12 m12">
      <h3 class="card-title white-text center" style="padding: 40px 0px;"><b><?php echo $name; ?></b></h3>
    </div>

    <div class="col s12 m12 l4 offset-l4">
      <div class="card white-text" id="back-to-login">

        <div class="card-content center" style="">
          <div class="row" style="margin-bottom: 0px;">
          <h2 class="card-title">Panel</h2>
          <form id="login" method="POST" autocomplete="off" action="<?php echo $url; ?>/form/login">
            <div class="input-field col s12 m12">
              <i class="fal fa-user prefix"></i>
              <input type="text" name="username" id="user" class="validate" required>
              <label for="user">Usuario</label>
            </div>
            <div class="input-field col s12 m12">
              <i class="fal fa-lock-alt prefix"></i>
              <input type="password" name="password" id="password" class="validate" required>
              <label for="password">Contraseña</label>
            </div>
            <div class="input-field col s12">
              <button type="submit" class="btn waves-effect waves-light col s12 black-text #ffffff white">Iniciar sesión</button>
            </div>
          </form>
          </div>
        </div>
        
      </div>
    </div>

  </div>
</div>

<script>
  $("#login").submit(function(event){
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
<?php require 'footer.php'; ?>