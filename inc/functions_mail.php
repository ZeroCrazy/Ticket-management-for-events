<?php

	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

	function mailSend($s, $to, $subject, $body, $code){
		$mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = $s['email']['hostname'];
        $mail->Port = $s['email']['port'];
        $mail->SMTPAuth = true;
        $mail->SMTPAutoTLS = true;
        $mail->Username = $s['email']['noreply']['username'];
        $mail->Password = $s['email']['noreply']['password'];
        $mail->setFrom($s['email']['noreply']['username'], $s['name']);
        $mail->addReplyTo($s['email']['noreply']['username'], $s['name']);
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = '<div class="container" style="width: 480px;margin-left: auto;margin-right: auto;padding: 20px 0px;">        <center>            <img width="300" src="'. $s['url'] .'/assets/images/logo.png">        </center>        <br><br>';
        $mail->Body .= '<h1 class="center blue" style="text-align: center;color: #00004e;">'. $s['name'] .'</h1>';
        $mail->Body .= $body;
        #$mail->Body .= '<p style="font-size: 15px;">Se ha generado una factura automáticamente. Te recomendamos que hagas cuanto antes el pago para evitar futuros recargos en la cuenta.</p>';
        $mail->Body .= '<br><br><br>';
        $mail->Body .= '<a style="display: block;background: #004bf3;width: 200px;padding: 15px 0px;text-align: center;color: #fff;text-decoration: none;margin-left: auto;margin-right: auto;margin-bottom: 3px;border-radius: 4px;" href="'. $s['url'] .'/tv/'. $code .'">Ver entrada</a>';
        $mail->Body .= '<br>';
        $mail->Body .= '<p><i style="color: gray;font-size: 12px;">Este correo ha sido generado automáticamente por el sistema de '. $s['name'] .', por favor, no responda a este mensaje ya que no recibiría respuesta. En caso de querer ponerte en contacto con nosotros enviando un correo a <a href="mailto:'. $s['email']['contact']['username'] .'">'. $s['email']['contact']['username'] .'</a></i></p>';
        $mail->Body .= '<br><br><br>';
        $mail->Body .= '<div class="newsletter" style="color: #3b3f44;font-family: arial,helvetica,sans-serif;font-size: 18px;line-height: 1.5;padding: 15px;text-align: center;background-color: #eff2f7;">            <p style="margin: 0px;"><strong>'. $s['name'] .'</strong></p>            <p style="margin: 0; font-size: 14px;">Este correo fue enviado a '. $to .'</p>            <br>            <a href="#" style="font-size: 14px;">Unsubscribe</a>        </div>';
        $mail->Body .= '</div>';
        $mail->CharSet = "UTF-8";
        $mail->send();
		#print_r($mail);
	}



?>