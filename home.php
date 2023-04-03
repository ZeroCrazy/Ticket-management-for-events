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

?>
<main>
<div class="container">

  <div class="row">
    <div class="col s12 m12">
      <h3 class="card-title" style="padding: 40px 0px;font-size: 2rem;"><i style="border-radius: 100%;border: 1px solid transparent;" class="fal fa-check-circle green white-text"></i> <b>Próximos eventos</b></h3>
      
      <div class="row">
      <?php 
        $rpp = $conn->query("SELECT * FROM events WHERE date_event >= NOW() ORDER BY  id DESC LIMIT 6");while ($e = $rpp->fetch_assoc()) {
      ?>
      <div class="col s12 m4">
        <a href="<?php echo $url; ?>/events/<?php echo $e['id']; ?>">
        <div class="card events <?php if($e['date_event'] < date('Y-m-d')){ echo 'finalizado'; } ?>">
          <div class="card-content">
          
          

          <div class="banner <?php if($e['date_event'] < date('Y-m-d')){ echo 'finalizado'; } ?>" css-text-waitroom="Finalizado" css-text-soldout="Agotado" style="background: url('<?php echo $e['banner_img']; ?>');"></div>
          <div class="date_event center"><?php echo dates('dia', date("l", strtotime($e['date_event']))); ?> <?php echo strftime('%d %B %Y',strtotime($e['date_event'])); ?><br><span>desde <?php echo $e['hour_event_a']; ?> a <?php echo $e['hour_event_b']; ?></span></div>
          <div style="padding: 24px;padding-top: 0px;">
            <span class="card-title"><?php echo $e['name']; ?> - <?php echo dates('dia', date("l", strtotime($e['date_event']))); ?></span>
            <?php if($e['musical_style']){ ?><p class="info"><i class="fal fa-music"></i> <?php echo $e['musical_style']; ?></p><?php } ?>
            <p class="info"><i class="fal fa-map-marker-alt"></i> <?php if($e['address']){ echo $e['address']; } else { echo $name; }?></p>
          </div>
          </div>
        </div>
        </a>

      </div>
      <?php } if($rpp->num_rows <= 0){ echo '<i class="grey-text">Sin resultados</i>'; } ?>
      </div>

    </div>

    <div class="col s12 m12">
      <h3 class="card-title" style="padding: 40px 0px;font-size: 2rem;"><i style="border-radius: 100%;border: 1px solid transparent;" class="fal fa-times-circle red white-text"></i> <b>Eventos finalizados</b></h3>
      
      <div class="row">
      <?php 
        $rppx = $conn->query("SELECT * FROM events WHERE date_event <= NOW() ORDER BY date_event DESC LIMIT 3");while ($e = $rppx->fetch_assoc()) {
      ?>
      <div class="col s12 m4">
        <a href="<?php echo $url; ?>/events/<?php echo $e['id']; ?>">
        <div class="card events <?php if($e['date_event'] < date('Y-m-d')){ echo 'finalizado'; } ?>">
          <div class="card-content">
          
          

          <div class="banner <?php if($e['date_event'] < date('Y-m-d')){ echo 'finalizado'; } ?>" css-text-waitroom="Finalizado" css-text-soldout="Agotado" style="background: url('<?php echo $e['banner_img']; ?>');"></div>
          <div class="date_event center"><?php echo dates('dia', date("l", strtotime($e['date_event']))); ?> <?php echo strftime('%d %B %Y',strtotime($e['date_event'])); ?><br><span>desde <?php echo $e['hour_event_a']; ?> a <?php echo $e['hour_event_b']; ?></span></div>
          <div style="padding: 24px;padding-top: 0px;">
            <span class="card-title"><?php echo $e['name']; ?> - <?php echo dates('dia', date("l", strtotime($e['date_event']))); ?></span>
            <?php if($e['musical_style']){ ?><p class="info"><i class="fal fa-music"></i> <?php echo $e['musical_style']; ?></p><?php } ?>
            <p class="info"><i class="fal fa-map-marker-alt"></i> <?php if($e['address']){ echo $e['address']; } else { echo $name; }?></p>
          </div>
          </div>
        </div>
        </a>

      </div>
      <?php } if($rppx->num_rows <= 0){ echo '<i class="grey-text">Sin resultados</i>'; } ?>
      </div>

    </div>
  </div>

</div>
</main>