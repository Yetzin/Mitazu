<?php
/*
sleep(1);
hash('sha256', '('.$_POST['fech'].')user: '.$user.' y con pass: '.$pass.' - ('.$request.')', true)
str_replace("\n", '<p>', $str)
*/
if(isset($_POST['mail']) && isset($_POST['user']) && isset($_POST['pass'])){
	
	//	$sqlAcces e include() van juntos.
	include('../libs/creaVar.php');
	include('../libs/dbConn.php');
	
	$mail = limpiarString($_POST['mail']);
	$user = limpiarString($_POST['user']);
	$pass = hash('sha3-512', $_POST['pass'].$user, false);
	if(strlen($mail) >= 16 && strlen($user) > 0 && strlen($pass) > 0 && $mail == $_POST['mail'] && $user == $_POST['user']){
		if($getM=$db->query("SELECT * FROM `usuarios` WHERE `user` LIKE '".$user."';")){
			if($getM->num_rows == 0){
				if($getM=$db->query("INSERT INTO `usuarios` (`id`, `user`, `pass`, `mail`, `preferencia`, `type`) VALUES (NULL, '".$user."', '".$pass."', '".$mail."', '0', 'desactivado');")){
					//Hash para enviar por correo.
					$hashObt = hash('sha256', 'user: '.$user.' y con pass: '.$pass.' - ('.$mail.')', false);
					if($getM=$db->query("INSERT INTO `validaciones` (`hash`, `user`) VALUES ('".$hashObt."', '".$user."');")){
						//$setDato=$db->query("UPDATE `usuarios` SET `pass` = '".hash('sha3-512', $pass.$user, false)."' WHERE `user` LIKE '".$user."';");
						echo "[Correcto]";
					} else {
						echo "[Error1]";
					}
				} else {
					echo "[Error2]";
				}
			} else {
				echo "[Existente]";
			}
		}
	} else {
		echo "[Error3]";
	}
	$db->close();
} else {
	exit("[Error4]");
}
?>
