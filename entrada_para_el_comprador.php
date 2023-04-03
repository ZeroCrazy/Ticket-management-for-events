<?php

    require 'header.php';
    require 'vendor/autoload.php';

    use chillerlan\QRCode\QRCode;
  use chillerlan\QRCode\QROptions;

    $options = new QROptions(
      [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
      ]
    );

    $get = htmlspecialchars(filter_var($_GET['code'], FILTER_SANITIZE_STRING));
    $rp = $conn->query("SELECT * FROM tickets WHERE code='$get'");$t = $rp->fetch_array();
    $ep = $conn->query("SELECT * FROM events WHERE id='$t[event_id]'");$e = $ep->fetch_array();

    if(!$t['id']) {

        echo href($url, 0);
        die();

    }

    $qrcode = (new QRCode($options))->render($t['code']);

?>
<style>
.loogo {
  color: #212424;
    font-family: poppins, helvetica, arial, sans-serif;
    font-weight: bold;
    text-transform: lowercase;
    letter-spacing: -3px;
    display: inline-block;
    font-size: 2.5rem;
}
.name, .dni {
  font-size: x-large;
  text-transform: uppercase;
  font-weight: bold;
}
.dni {
  font-weight: normal;
}
.qr {
  width: 100%;
  border-radius: 20px;
}
.text-ticket {
  color: #fff;
  text-shadow: 0px 0px 5px #000;
}
.checkin {
  font-weight: bold;
  text-shadow: 0px 0px 5px #000;
}
.checkin.success {
  color: #00ff00;
}
hr {
  filter: blur(1px) !important;
  background-color: #fff !important;
  height: 2px !important;
  border: 1px solid #fff !important;
}
.entrada {
  font-weight: bold;
  color: pink;
  text-shadow: 0px 0px 5px #e400ff;
  font-size: 2rem;
  padding-bottom: 10px;
}
</style>

<div class="container">
  <div class="row">
  <div class="col s12 m12 center" style="margin-bottom: 40px;">
    <a class="loogo"><?php echo $s['name']; ?></a>
  </div>
  <div class="col s12 m6 text-ticket center">
    <b><?php echo $e['name']; ?><br></b>
    <div class="center"><?php echo dates('dia', date("l", strtotime($t['date_event']))); ?> <?php echo strftime('%d %B %Y',strtotime($e['date_event'])); ?><br><span><?php echo $lang['entrada_para_el_comprador']['since']; ?> <?php echo $e['hour_event_a']; ?> <?php echo $lang['entrada_para_el_comprador']['to']; ?> <?php echo $e['hour_event_b']; ?></span></div>
    <hr>
    <span class="name"><?php echo $t['name']; ?></span>
    <br>
    <span class="dni"><?php echo $t['dni']; ?></span>
    <br>
    <div class="entrada"><?php echo ticket($conn, $t['event_ticket_id'], 'name'); ?> (<?php echo ticket($conn, $t['event_ticket_id'], 'price'); ?>&euro;)</div>
    <?php if($t['checkin'] == 'yes'){ ?>
    <hr>
    <p class="checkin success"><?php echo $t['name']; ?> <?php echo $lang['entrada_para_el_comprador']['joined']; ?> <?php echo dates('dia', date("l", strtotime($t['date_event']))); ?>, <?php echo strftime('%d %B',strtotime($t['checkin_date'])); ?> <?php echo $lang['entrada_para_el_comprador']['at']; ?> <?php echo date("H:i", strtotime($t['checkin_date'])); ?></p>
    <?php } ?>
  </div>
  <div class="col s12 m6 text-ticket center">
    <img src='<?= $qrcode ?>' class="qr" alt='QR Code'>
  </div>
</div>
</div>
<div class="ev-banner blurry-flyer" style="background: url('<?php echo $e['banner_img']; ?>');"></div>