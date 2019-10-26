<?php
/*
require_once('../class.phpmailer.php');
$mail = new PHPMailer();
//indico a la clase que use SMTP
$mail->IsSMTP();
//permite modo debug para ver mensajes de las cosas que van ocurriendo
$mail->SMTPDebug = 2;
//Debo de hacer autenticación SMTP
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
//indico el servidor de Gmail para SMTP
$mail->Host = "smtp.gmail.com";
//indico el puerto que usa Gmail
$mail->Port = 465;
//indico un usuario / clave de un usuario de gmail
$mail->Username = "tu_correo_electronico_gmail@gmail.com";
$mail->Password = "tu clave";
$mail->SetFrom('tu_correo_electronico_gmail@gmail.com', 'Nombre completo');
$mail->AddReplyTo("tu_correo_electronico_gmail@gmail.com","Nombre completo");
$mail->Subject = "Envío de email usando SMTP de Gmail";
$mail->MsgHTML("Hola que tal, esto es el cuerpo del mensaje!");
//indico destinatario
$address = "destinatario@delcorreoe.com";
$mail->AddAddress($address, "Nombre completo");
if(!$mail->Send()) {
echo "Error al enviar: " . $mail->ErrorInfo;
} else {
echo "Mensaje enviado!";
}*/
if(isset($_POST['mail']) && isset($_POST['user']) && isset($_POST['pass'])){
	
	//	$sqlAcces e include() van juntos.
	include('../libs/creaVar.php');
	include('../libs/dbConn.php');
	
	$mail = limpiarString($_POST['mail']);
	$user = limpiarString($_POST['user']);
	$pass = limpiarString($_POST['pass']);
	if(strlen($mail) >= 16 && strlen($user) >= 16 && strlen($pass) >= 16){
		if($getM=$db->query("SELECT * FROM `usuarios` WHERE `user` LIKE '".$user."';")){
			if($getM->num_rows == 0){
				if($getM=$db->query("INSERT INTO `usuarios` (`id`, `user`, `pass`, `mail`, `type`) VALUES (NULL, '".$user."', '".$pass."', '".$mail."', 'desactivado');")){
					$hashObt = hash('sha256', 'user: '.$user.' y con pass: '.$pass.' - ('.$mail.')', false);
					if($getM=$db->query("INSERT INTO `validaciones` (`hash`, `user`) VALUES ('".$hashObt."', '".$user."');")){
						echo "[Correcto]";
					} else {
						echo "[Error]";
					}
				} else {
					echo "[Error]";
				}
			} else {
				echo "[Error]";
			}
		}
	} else {
		echo "[Error]";
	}
	$db->close();
} else {
	exit("[Error]");
}
?>
