<?php
$msg = "";
if(!isset($_GET['hash'])){
	$msg = "no";
} else {
	include('../libs/creaVar.php');
	include('../libs/dbConn.php');
	$hash = preg_replace('([^A-Za-z0-9])', '', $_GET['hash']);
	if(strlen($_GET['hash']) == 64){
		if($getM=$db->query("SELECT `user` FROM `validaciones` WHERE `validaciones`.`hash` = '".$hash."';")){
			if($user = $getM->fetch_array()['user']){
				if($getM=$db->query("DELETE FROM `validaciones` WHERE `validaciones`.`user` = '".$user."';")){
					if($getM=$db->query("UPDATE `usuarios` SET `type` = 'normal' WHERE `usuarios`.`user` = '".$user."';")){
						$msg = "Correcto: El usuario ha sido validado.<br>Puede iniciar sesión aquí: <a href=\"https://".$_SERVER['HTTP_HOST']."/\" style=\"display: inline-block; background: #569046; color: #fff; text-decoration: none; cursor: pointer; padding: 10px 10px; line-height: normal; -webkit-transition: all 500ms ease; -o-transition: all 500ms ease; transition: all 500ms ease; border-radius: 5px;\">Ir</a>";
					} else {
						$msg = "Error: No se pudo encontrar el usuario.";
					}
				} else {
					$msg = "Error: No se pudo encontrar el usuario.";
				}
			} else {
				$msg = "Error: No se pudo encontrar el usuario.<br>Es posible que ya esté validado el usuario, en caso de estarlo puede iniciar sesión aquí: <a href=\"https://".$_SERVER['HTTP_HOST']."/\" style=\"display: inline-block; background: #569046; color: #fff; text-decoration: none; cursor: pointer; padding: 10px 10px; line-height: normal; -webkit-transition: all 500ms ease; -o-transition: all 500ms ease; transition: all 500ms ease; border-radius: 5px;\">Ir</a>";
			}
		} else {
			$msg = "Error: No se pudo encontrar el usuario.<br>Es posible que ya esté validado el usuario, en caso de estarlo puede iniciar sesión aquí: <a href=\"https://".$_SERVER['HTTP_HOST']."/\" style=\"display: inline-block; background: #569046; color: #fff; text-decoration: none; cursor: pointer; padding: 10px 10px; line-height: normal; -webkit-transition: all 500ms ease; -o-transition: all 500ms ease; transition: all 500ms ease; border-radius: 5px;\">Ir</a>";
		}
	} else {
		$msg = "no";
	}
	$db->close();
}
if($msg == "no"){
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/');
	//header('Location: https://mitazu.000webhostapp.com/');
}
?>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<?php
echo $msg;//." <br> Redirigiendo...";
//sleep(5);
//header('Location: https://mitazu.000webhostapp.com/');
?>
