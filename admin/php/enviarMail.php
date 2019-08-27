<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

require_once 'datosdb.php';

require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';

function enviarMail($para, $titulo, $mensaje, $mensajeAlt, $adjunto = [], $replyTo = '', $cc = '', $bcc = '') {
	global $raiz, $crlf, $lang;

	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->isHTML(true);
	$mail->setLanguage($lang, $raiz . 'admin/vendor/phpmailer/phpmailer/language/');
	$mail->isSMTP();
	$mail->Host = '';
	$mail->SMTPAuth = true;
	$mail->Username = '';
	$mail->Password = '';
	$mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;

	if ($replyTo != '') {
		$mail->AddReplyTo($replyTo);
	}

	$mail->setFrom('', '');

	$direcciones = explode(',', $para);
	foreach ($direcciones as $dir) {
		$mail->addAddress(trim($dir));
	}

	$direcciones = explode(',', $cc);
	foreach ($direcciones as $dir) {
		$mail->addCC(trim($dir));
	}

	$direcciones = explode(',', $bcc);
	foreach ($direcciones as $dir) {
		$mail->addBCC(trim($dir));
	}

	$mail->Subject = $titulo;
	$mail->Body = $mensaje;
	$mail->AltBody = $mensajeAlt;

	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);

	if (count($adjunto) > 0) {
		$mail->addAttachment($adjunto['tmp_name'], $adjunto['name']);
	}

	if (!$mail->send()) {
		$salida = array('estado' => false, 'msg' => 'Error al enviar mail!' . $crlf . $mail->ErrorInfo);
	} else {
		$salida = array('estado' => true, 'msg' => 'Datos enviados!');
	}
	return $salida;
}
?>
