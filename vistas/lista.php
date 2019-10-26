<?php
include('../libs/creaVar.php');
include('../libs/dbConn.php');
include('../libs/usuario.php');
if($usuario['existe']){
	if($usuario['tipo'] != 'root')
		exit("Error: Acceso restringido.");
} else {
	exit("Error: Acceso restringido.");
}
?>
<p>Usuarios sin validar:</p>
<?php
$msg = "";
$i = 0;
if($getM=$db->query("SELECT * FROM `validaciones`;")){
	while($row = $getM->fetch_array()){
		if($getU=$db->query("SELECT `mail`,`id` FROM `usuarios` WHERE `user` LIKE '".$row['user']."';")){
			while($rows = $getU->fetch_array()){
				echo "
				<div id=\"descrip\">
				<nav class=\"botones\"><a onclick=\"validarUsuario('".$row['hash']."')\">Validar</a></nav>
				<p>[".($i + 1)."]</p>
				<textarea id=\"texto\" name=\"urlv\">https://".$_SERVER['HTTP_HOST']."/verificar/?hash=".$row['hash']."</textarea> <br>
				Id: ".$rows['id']." <br>
				Usuario: ".$row['user']." <br>
				Contraseña: ********** <br>
				Correo: ".$rows['mail']."
				</div>
				<br>
				";
			}
			$i++;
		}
	}
	if($i == 0){
		echo "Sin registros nuevos.";
	} else {
		echo "
		<br>
		<hr style=\"width: 100%;\">
		<br>
		";
	}
} else {
	$msg = "[Error]";
}
if($msg != "[Error]"){
	if($getM=$db->query("SELECT `mail`,`id`,`user`,`type` FROM `usuarios` WHERE `type` != 'desactivado';")){
		$i = 0;
		echo "
		<br>
		<br>
		<p>Usuarios registrados:</p>
		";
		while($row = $getM->fetch_array()){
			echo "
			<div id=\"descrip\">
			<p>[".($i + 1)."]</p>
			Usuario: ".$row['user']." <br>
			Contraseña: ********** <br>
			Tipo: ".$row['type']." <br>
			Id: ".$row['id']." <br>
			Correo: ".$row['mail']."
			</div>
			<br>
			";
			$i++;
		}
		if($i == 0)
			echo "Sin usuarios.";
	} else {
		$msg = "[Error]";
	}
}
echo $msg;
$db->close();
?>
