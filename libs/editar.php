<?php
if(isset($_POST['editadoid']) && isset($_POST['text']) && isset($_POST['date']) && isset($_POST['opcImp'])){
	include('../libs/creaVar.php');
	include('../libs/dbConn.php');
	include('../libs/usuario.php');
	$editadoid = limpiarString($_POST['editadoid']);
	$text = limpiarString($_POST['text']);
	$date = limpiarString($_POST['date']);
	$imprt = limpiarString($_POST['opcImp']);
	if(strlen($text) > 0 && strlen($date) > 0 && strlen($editadoid) > 0 && $usuario['existe']){
		if($setDato=$db->query("UPDATE `operaciones` SET `fecha` = '".$date."', `importancia` = '".$imprt."', `texto` = '".$text."' WHERE `operaciones`.`id` = ".$editadoid." AND `operaciones`.`userID` = ".$usuario['id'].";")){
			echo "[Correcto]";
		} else {
			echo "[Error]";
		}
	} else {
		echo "[Error]";
	}
	$db->close();
} else {
	exit("[Error]");
}
?>