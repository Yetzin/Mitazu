<?php
$usuario = array('existe'=> false, 'id' => '', 'preferencia' => '', 'tipo' => '');
if(((isset($_COOKIE['USER']) && isset($_COOKIE['PASS'])) || (isset($_POST['user']) && isset($_POST['pass']))) && isset($db)){
	$user0 = isset($_COOKIE['USER'])? $_COOKIE['USER'] : $_POST['user'];
	$user = limpiarString($user0);
	if($user == $user0){
		if($getU=$db->query("SELECT `id`,`preferencia`,`type` FROM `usuarios` WHERE `user` LIKE '".$user."' AND `pass` LIKE '".hash('sha3-512', (isset($_COOKIE['PASS'])? $_COOKIE['PASS'] : $_POST['pass']).$user, false)."';")){
			if($getU->num_rows == 1){
				if($row = $getU->fetch_array()){
					$usuario['existe'] = true;
					$usuario['id'] = $row['id'];
					$usuario['preferencia'] = $row['preferencia'];
					$usuario['tipo'] = $row['type'];
					/*
						La variable de usuario no contiene ni el nombre del usuario ni la contraseña puesto
						que esos datos ya vienen en una cookie o un post, sólo con verificar que
						$usuario['existe'] sea igual a true basta para saber que los datos que recibe el
						servidor son correctos y pueden ser usados sin ningún problema.
					*/
				}
			}
		}
	}
}
?>