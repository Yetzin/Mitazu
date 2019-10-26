<?php
include('../libs/creaVar.php');
include('../libs/dbConn.php');
if((isset($_POST['user']) && isset($_POST['pass'])) && isset($db)){
	$user0 = $_POST['user'];
	$user = limpiarString($user0);
	if($getU=$db->query("SELECT `user`,`pass`,`type` FROM `usuarios` WHERE `user` LIKE '".$user."' OR `mail` LIKE '".$user."';")){
		if($getU->num_rows >= 1){
			if($row = $getU->fetch_array()){
				if($row['pass'] == hash('sha3-512', $_POST['pass'].$row['user'], false)){
					if($row['type'] == 'desactivado'){
						echo "[Desactivado]";
					} else {
						setcookie("USER", $row['user'], time()+(3600*24*7), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
						setcookie("PASS", $_POST['pass'], time()+(3600*24*7), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
						echo "[Correcto]";
					}
				} else {
					echo "[no]".$row['pass'].hash('sha3-512', $_POST['pass'].$row['user'], false);
				}
			}
		} else {
			echo "[no]";
		}
	}
/*	if($user == $user0){
		if($getU=$db->query("SELECT `id`,`type` FROM `usuarios` WHERE `user` LIKE '".$user."' AND `pass` LIKE '".hash('sha3-512', $_POST['pass'].$user, false)."';")){
			if($getU->num_rows == 1){
				if($row = $getU->fetch_array()){
					if($row['type'] == 'desactivado'){
						echo "[Desactivado]";
					} else {
						setcookie("USER", $_POST['user'], time()+(3600*24*7), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
						setcookie("PASS", $_POST['pass'], time()+(3600*24*7), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
						echo "[Correcto]";
					}
				} else {
					echo "[no]";
				}
			} else {
				if($getU=$db->query("SELECT `id`,`type` FROM `usuarios` WHERE `user` LIKE '".$user."' AND `pass` LIKE '".limpiarString($_POST['pass'])."';")){
					if($getU->num_rows == 1){
						if($setDato=$db->query("UPDATE `usuarios` SET `pass` = '".hash('sha3-512', $_POST['pass'].$user, false)."' WHERE `user` LIKE '".$user."';")){
							if($row = $getU->fetch_array()){
								if($row['type'] == 'desactivado'){
									echo "[Desactivado]";
								} else {
									setcookie("USER", $_POST['user'], time()+(3600*24*7), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
									setcookie("PASS", $_POST['pass'], time()+(3600*24*7), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
									echo "[Correcto]";
								}
							} else {
								echo "[no]";
							}
						} else {
							echo "[Error]";
						}
					}
				}
			}
		}
	}*/
}
$db->close();
?>