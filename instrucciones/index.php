<?php
if(!isset($_SERVER['HTTPS']) && $_SERVER['HTTP_HOST'] != 'pc4'){
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/'.($_SERVER['HTTP_HOST'] == 'localhost'? 'mitazu' : ''));
}
include('../libs/creaVar.php');
include('../libs/dbConn.php');
include('../libs/usuario.php');
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<!--
			Creador: Germán Yetzín Ramírez Rivera
			Correo: mermin@protonmail.ch
			Correo secundario: mermin444@gmail.com
		-->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<title>Mitazu</title>
		<link rel="shortcut icon" href="../multimedia/logo.png">
		<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/li.css?v=1.7">
		<script type="text/javascript" src="../js/li.js?v=1.7"></script>
		<script>
			window.onload = function(){
				$("#contenedor_carga").css("display","none");
			}
		</script>
		<style>
			html, body{ height: 100%; }
			*, *:after, *:before{
				margin: 0;
				padding: 0;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			#contenedor_carga{
				height: 67px;
				width: 67px;
				border-radius: 50%;
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				margin: auto;
				-webkit-transition: all 1s ease;
				-o-transition: all 1s ease;
				transition: all 1s ease;
				z-index: 3;
			}
			#carga_ext{
				border: 7px solid transparent;
				border-top-color: #25aa00;
				height: 100%;
				width: 100%;
				border-radius: 50%;
				-webkit-animation: girar 1500ms linear infinite;
				-o-animation: girar 1500ms linear infinite;
				animation: girar 1500ms linear infinite;
			}
			#carga{
				border: 7px solid transparent;
				border-bottom-color: #25aa00;
				height: 100%;
				width: 100%;
				border-radius: 50%;
				-webkit-animation: girar 1000ms linear infinite;
				-o-animation: girar 1000ms linear infinite;
				animation: girar 1000ms linear infinite;
			}
			header{ background-color: #2529329b; }
			._pol_ckie{
				color: #fff;
				text-decoration: none;
			}
			._pol_ckie:hover{ text-decoration: underline; }
			.pie_pag{
				background-color: #252932;
				background-color: #2529329b;
				color: #fff;
				width: 100%;
				padding: 20px 7% 50px 7%;
				position: absolute;
				top: 100%;
				left: 0;
				right: 0;
			}
			#un_pic {
				text-decoration: underline;
				color: #fff;
			}
			.conten{
				min-height: 100%;
				text-align: center;
				width: 100%;
				position: absolute;
				z-index: 0;
			}
			#contens{
				display: inline-block;
				background-color: #ffffff;
				background-color: #ffffffab;
				text-align: justify;
				width: 90%;
				max-width: 1000px;
				padding: 20px;
			}
			.butt_reg{
				position: fixed;
				left: 5%;
				top: 5px;
				padding: 2px;
				background-color: #df7a52;
				color: #000;
			}
			.con_but_reg{
				padding: 5px;
				border: 2px solid #000;
				border-radius: 4px;
				background-color: transparent;
				-webkit-transition: all 500ms ease;
				-o-transition: all 500ms ease;
				transition: all 500ms ease;
			}
			.con_but_reg:hover{
				background: #c0adff;
			}
			@keyframes girar{
				from { transform: rotate(0deg); }
				to { transform: rotate(360deg); }
			}
		</style>
		<?php
		if($usuario['tipo'] == 'root'){
			echo '<script type="text/javascript">
				function verUsuarios(){
					mostrarM = true;
					$(".menuContenidoUser").css("display","none");
					$(\'#conten\').html(\'\');
					$("#contenedor_carga").css("display","flex");
					var request = $.ajax({
						url: \'vistas/lista.php\',
						method: \'GET\',
						dataType: \'html\'
					});
					request.done(function(m) {
						$("#nuevo_bloque").css("display","none");
						$(\'.botones\').html(\'<a onclick="sust(\\\'principal\\\',true)">Regresar</a>\' + botonesHTML);
						$("#contenedor_carga").css("display","none");
						$(\'#conten\').html(m);
					});
					request.fail(function(jqXHR, textStatus) {
						console.log("Request failed: " + textStatus);
						$("#contenedor_carga").css("display","none");
						alert("Lo sentimos, ha ocurrido un error al intentar cargar el contenido.\n" + textStatus);
					});
				}
				function validarUsuario(hash){
					$("#contenedor_carga").css("display","flex");
					var request = $.ajax({
						url: \'verificar/?hash=\' + hash,
						method: \'GET\',
						dataType: \'html\'
					});
					request.done(function() {
						verUsuarios();
					});
					request.fail(function(jqXHR, textStatus) {
						$("#contenedor_carga").css("display","none");
						alert("Lo sentimos, ha ocurrido un error al intentar cargar el contenido.\n" + textStatus);
					});
				}
			</script>';
		}
		?>
	</head>
	<body>
		<div id="quec"></div>
		<header>
			<div class="wrapper">
				<nav style="float: left;" class="botones"><a class="butt_reg" onclick="window.history.back();"><div class="con_but_reg">&#171; Regresar</div></a></nav>
			</div>
		</header>
		<div id="mantieneMen" class="menuContenidoUser">
			<ul style="display: inline-block; text-align: left;">
				<a onclick="sust('perfil',true);"><li>Perfil</li></a>
				<hr style="color: #c6c0cc;">
				<a onclick="sust('historial',true);"><li>Historial</li></a>
				<hr style="color: #c6c0cc;">
				<a onclick="sust('indicadores',true);"><li>Indicador</li></a>
				<hr style="color: #c6c0cc;">
				<?php
				if($usuario['tipo'] == 'root'){
					echo '<a onclick="verUsuarios();"><li>Usuarios</li></a>
					<hr style="color: #c6c0cc;">';
				}
				?>
				<a onclick="salir();"><li>Cerrar sesión</li></a>
			</ul>
		</div>
		<div class="titulo_home"></div>
		<div class="conten">
			<div id="contenedor_carga">
				<div id="carga_ext"><div id="carga"></div></div>
			</div>
			<br>
			<section id="contens">
				<h1>Instrucciones de uso</h1>
				<br>
				<h3>Texto</h3>
				<p>Texto</p>
			</section>
			<br>
			<br>
			<br>
			<br>
			<footer class="pie_pag">
				<div style="float: right;">Desarrollado por Yetzín</div>
				<br>
				<div style="float: left;">Versión 2.1</div>
				<div style="float: right;">Photo by <a id="un_pic" href="https://unsplash.com/@essentialiving" target="_blank">Essentialiving</a> on <a id="un_pic" href="https://unsplash.com" target="_blank">Unsplash</a></div>
				<br>
				<hr>
			</footer>
		</div>
		<?php
		if(!$usuario['existe']){
			echo '
			';
		}
		?>
	</body>
</html>
