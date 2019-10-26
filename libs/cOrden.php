<?php
if(isset($_POST['opc'])){
	include('../libs/creaVar.php');
	include('../libs/dbConn.php');
	include('../libs/usuario.php');
	$opc = limpiarString($_POST['opc']);
	$opc = (0 + $opc);
	if($opc >= 0 && $opc <= 2 && $usuario['existe']){
		if($setDato=$db->query("UPDATE `usuarios` SET `preferencia` = '".$opc."' WHERE `usuarios`.`id` = ".$usuario['id'].";")){
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