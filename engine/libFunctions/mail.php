<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function doSendMail($receiver, $receiverName, $function, $subject, $body) {
	
	$mail = new PHPMailer(true);
	try {
		//Server settings
	//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = config('mailHost');                     //Set the SMTP server to send through
		$mail->SMTPAuth   = config('SMTPAuth');                     //Enable SMTP authentication
		$mail->Username   = config('mailLogin');                    //SMTP username
		$mail->Password   = config('mailPassword');                 //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = config('mailPort');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		$mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)

		//Recipients
		$mail->setFrom(config('mailLogin'), $function);
		$mail->addAddress($receiver, $receiverName);     //Add a recipient
	
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = config('site_title').' - '.$subject;
		$mail->Body    = $body;
	
		$mail->send();
//		echo 'Message has been sent';
	} catch (Exception $e) {
//		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}


function doSendWarningQueries($name, $requisit) {
	$receiverName = "Colaborador";
	$function = "AVISO";
	$subject = "Requisição de Consulta";
	$body = "O usuário <b>$name</b> fez uma nova requisição de consulta, número da requisição <b>".doTransformCode($requisit)."</b>, verifique o quanto antes, e garanta a satisfação de seu cliente.";

	$selectCollaborator = getListAdmin(1); 
	if($selectCollaborator !== false) {
		foreach($selectCollaborator as $key) {
			doSendMail(getAccountEmail($key['account_ID']), $receiverName, $function, $subject, $body);
		}
	}
}

?>
