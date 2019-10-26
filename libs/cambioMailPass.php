<?php
if(isset($_POST['tipo']) && isset($_POST['dato'])){
	include('../libs/creaVar.php');
	include('../libs/dbConn.php');
	include('../libs/usuario.php');
	if($usuario['existe']){
		if($setDato=$db->query("UPDATE `usuarios` SET `".(limpiarString($_POST['tipo']) == "1"? "pass" : "mail")."` = '".(limpiarString($_POST['tipo']) == "1"? hash('sha3-512', $_POST['dato'].limpiarString($_COOKIE['USER']), false) : limpiarString($_POST['dato']))."' WHERE `usuarios`.`id` = ".$usuario['id'].";")){
			if(limpiarString($_POST['tipo']) == "1"){
				setcookie("USER", $_COOKIE['USER'], time()-(1), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
				setcookie("PASS", $_COOKIE['PASS'], time()-(1), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
			}
			echo "[Correcto]";
		} else {
			echo "[Error]";
		}
	}
	$db->close();
} else {
	exit("[Error]");
}
?>