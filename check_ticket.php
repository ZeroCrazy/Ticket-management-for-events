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

    if(rank($conn, $user['rank'], 'check_ticket') == 0){
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
<script src="<?php echo $url; ?>/assets/js/html5-qrcode.min.js"></script>
<main>

  <div class="container">
    <div class="row">
      
      <div class="col s12 m12" style="margin-bottom: 40px;">
        <h3 class="card-title center white-text">
          <a class="btn-small black-text white tooltipped" data-position="left" data-tooltip="<?php echo $lang['back']; ?>" style="margin-top: -5px;border-radius: 100%;padding: 0px 7px;" href="<?php echo $url; ?>/home"><i class="fal fa-arrow-alt-left"></i></a>
          <br>
          <b><?php echo $lang['name']; ?></b></h3>
      </div>


        <div class="col s12 m12 l4 offset-l4">
            <div class="card stats white-text black center">
              <div class="card-content">
              
              <div id="qr-reader" style="width:100%;"></div>
              <div id="qr-reader-results"></div>


              <script>
                var resultContainer = document.getElementById('qr-reader-results');
                  var lastResult, countResults = 0;

                  function onScanSuccess(decodedText, decodedResult) {
                      if (decodedText !== lastResult) {
                          ++countResults;
                          lastResult = decodedText;
                          // Handle on success condition with the decoded message.
                          console.log(`Scan result ${decodedText}`, decodedResult);
                          //alert(decodedText);
                          //window.location='<?php echo $url; ?>/ticket/check/' + decodedText;

                          $.ajax({
                              url : '<?php echo $url; ?>/form/check_ticket',
                              type: 'POST',
                              data : { code : decodedText }
                          }).done(function(response){
                              $("#server-results").html(response);
                          });
                          /*
                          html5QrcodeScanner.clear();
                          setTimeout(() => {
                            html5QrcodeScanner.render(onScanSuccess);
                          }, 1500);*/

                      }
                  }
                  var html5QrcodeScanner = new Html5QrcodeScanner(
                      "qr-reader", { fps: 10, qrbox: 250, videoConstraints: { facingMode: { exact: "environment" } } });
                      html5QrcodeScanner.render(onScanSuccess);
                  setInterval(() => {
                    
                    
                  
                    
                  }, 5000);

                  
                </script>
              </div>
            </div>
        </div>

    </div>
  </div>





<div class="ev-banner blurry-flyer" style="background: url('<?php echo $url; ?>/assets/images/vaporwave_wallpaper.jpg');"></div>
</main>