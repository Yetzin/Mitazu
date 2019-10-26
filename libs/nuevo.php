<?php
if(isset($_POST['text']) && isset($_POST['date']) && isset($_POST['opcImp'])){
	include('../libs/creaVar.php');
	include('../libs/dbConn.php');
	include('../libs/usuario.php');
	$texto = limpiarString($_POST['text']);
	$fecha = limpiarString($_POST['date']);
	$imprt = limpiarString($_POST['opcImp']);
	if(strlen($texto) > 0 && strlen($fecha) >= 4 && $usuario['existe']){
		if($setDato=$db->query("INSERT INTO `operaciones` (`id`, `estado`, `fecha`, `importancia`, `texto`, `userID`) VALUES (NULL, '0', '".$fecha."', '".$imprt."', '".$texto."', ".$usuario['id'].");")){
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