<?php
if(isset($_COOKIE['USER']) && isset($_COOKIE['PASS']) && isset($_POST['opc'])){
	if($_POST['opc'] == "[salir]"){
		setcookie("USER", $_COOKIE['USER'], time()-1, '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), false);
		setcookie("PASS", $_COOKIE['PASS'], time()-1, '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), false);
	} else {
		exit;
	}
} else {
	exit;
}
?>
