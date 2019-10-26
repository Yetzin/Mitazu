<?php
if(isset($_POST['id']) && isset($_POST['estado'])){
	include('../libs/creaVar.php');
	include('../libs/dbConn.php');
	include('../libs/usuario.php');
	$idT = limpiarString($_POST['id']);
	$estado = limpiarString($_POST['estado']);
	if(strlen($idT) > 0 && strlen($estado) > 0 && $usuario['existe']){
		if($setDato=$db->query("UPDATE `operaciones` SET `estado` = '".$estado."' WHERE `operaciones`.`id` = ".$idT." AND `operaciones`.`userID` = ".$usuario['id'].";")){
			//echo "[Correcto][".$db->insert_id."]";
			echo "[Correcto]";
		} else {
			echo "[Error]";
		}
	} else {
		echo "[Error]";
	}
	//echo 'Texto: '.$_POST['text'].'<br>'.(($_POST['date'] == "")? "Sin fecha establecida." : "Fecha: ".$_POST['date'])."<br>";
	$db->close();
} else {
	exit("[Error]");
}
?>