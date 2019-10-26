<?php
include('../libs/creaVar.php');
include('../libs/dbConn.php');
include('../libs/usuario.php');
if($usuario['existe'] && $usuario['tipo'] != 'desactivado'){
	if($getU=$db->query("SELECT `mail` FROM `usuarios` WHERE `id` = '".$usuario['id']."';")){
		if($getU->num_rows == 1){
			if($row = $getU->fetch_array()){
				echo "<p>Información del usuario:</p>
				<div id=\"descrip\">
					Usuario: ".$_COOKIE['USER']."
					<br>
					<br>
					Contraseña: <div id=\"editPas\">&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;</div><div class=\"msgCambio1\">msg</div>
					<a class=\"cambioUser1\" onclick=\"cambioPass();\">Cambiar</a>
					<a class=\"cambioUserCancel1\" onclick=\"cancelKeyP();\">Cancelar</a>
					<br>
					<br>
					Correo: <div id=\"editMail\">".$row['mail']."</div><div class=\"msgCambio2\">msg</div>
					<a class=\"cambioUser2\" onclick=\"cambioMail();\">Cambiar</a>
					<a class=\"cambioUserCancel2\" onclick=\"cancelKeyM();\">Cancelar</a>
				</div>
				<br>
				";
			} else {
				echo "Error.";
			}
		} else {
			echo "Error.";
		}
	}
} else {
	exit("[Error]");
}
$db->close();
?>
