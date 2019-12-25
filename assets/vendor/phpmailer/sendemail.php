<?php
use PHPMailer\PHPMailer\PHPMailer;
require __DIR__ . '/../../vendor/autoload.php';

define('GMailUSER', 'bubbleboost.help@gmail.com');
define('GMailNAME', 'BubbleBoost');
define('GMailPASSWORD', 'Suvovanty');
?>

<?php
function sendemail($destinataire, $subject, $body, $name = NULL) {
	$mail = new PHPMailer;
	$mail->isSMTP();
//	$mail->SMTPDebug = 4;
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);
	$mail->SMTPSecure = 'ssl';
	$mail->SMTPAuth = true;
	$mail->Username = GMailUSER;
	$mail->Password = GMailPASSWORD;
	if($name != NULL) {
		$mail->addAddress(GMailUSER);
		$mail->AddReplyTo($destinataire, $name);
	}
	else
		$mail->addAddress($destinataire);
	$mail->setFrom(GMailUSER, GMailNAME);
	$mail->isHTML();
	$mail->CharSet = 'UTF-8';
	$mail->Subject = $subject;
	$mail->Body = $body;
	if (!$mail->send()) {
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	    return false;
	} else {
	    return true;
	}
}
?>