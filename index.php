<?php
if(!isset($_SERVER['HTTPS']) && $_SERVER['HTTP_HOST'] != 'pc4'){
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/'.($_SERVER['HTTP_HOST'] == 'localhost'? 'mitazu' : ''));
	//header('Location: https://mitazu.000webhostapp.com/');
}
include('libs/creaVar.php');
include('libs/dbConn.php');
include('libs/usuario.php');
$tipoDeCarga = "";
$vista = "principal";
if(isset($_GET['lcv'])){
	switch($_GET['lcv']){
		case "perfil":
		case "historial":
		case "indicadores":
			$vista = $_GET['lcv'];
			break;
	}
}
if($usuario['existe']){
	if(isset($_GET['lcv'])){
		if($_GET['lcv'] == "lista" && $usuario['tipo'] == 'root'){
			$vista = $_GET['lcv'];
		}
	}
	$tipoDeCarga = "cargar('".$vista."');";
} else {
	$tipoDeCarga = "login();";
}
if($usuario['existe'] && $usuario['tipo'] != 'desactivado'){
	setcookie("USER", $_COOKIE['USER'], time()+(3600*24*7), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
	setcookie("PASS", $_COOKIE['PASS'], time()+(3600*24*7), '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
}
$db->close();
$ver_libs = "3.10";
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<!--
			Creador: Germán Yetzín Ramírez Rivera
			Correo: mermin@protonmail.ch
			Correo secundario: mermin444@gmail.com
		-->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<meta charset="UTF-8">
		<title>Mitazu</title>
		<link rel="shortcut icon" href="multimedia/logo.png">
		<!--script type="text/javascript" src="js/jquery-3.3.1.min.js"></script-->
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="css/li.css?v=<?=$ver_libs; ?>">
		<script type="text/javascript" src="js/li.js?v=<?=$ver_libs; ?>"></script>
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
			._pol_ckie{
				color: #fff;
				text-decoration: none;
			}
			._pol_ckie:hover{ text-decoration: underline; }
			@keyframes girar{
				from { transform: rotate(0deg); }
				to{ transform: rotate(360deg); }
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
				<div class="logo">
					<a onclick="<?=($usuario['existe']? "sust('principal',true)" : "login()"); ?>;" title="Inicio"><p>Mitazu Agenda</p></a>
				</div>
				<nav class="botones">
					<?php
					if($usuario['existe']){
						echo '
						<a onclick="nuevo()" id="mantener" class="new_pd"><span id="mantener" class="icon-plus"></span> Nuevo</a>
						<div class="sep_bts"></div>
						<div class="sep_bts_2"></div>
						<a onclick="mostrarMenu()" id="mantieneMen" class="menuUser icon-bars1"></a>
						';
					} else {
						echo '
						<div class="sep_a">
							<a onclick="registro()" id="mantener">Registrarse</a>
						</div>
						<div class="sep_a">
							<a onclick="ingreso()" id="mantener">Ingresar</a>
						</div>
						';
					}
					?>
				</nav>
			</div>
		</header>
		<div id="mantieneMen" class="menuContenidoUser">
			<ul style="display: inline-block; text-align: left;" id="mantieneMen">
				<a onclick="sust('principal',true);"><li><span class="icon-circle-left"></span>Inicio</li></a>
				<a onclick="sust('perfil',true);"><li><span class="icon-user"></span>Perfil</li></a>
				<a onclick="sust('historial',true);"><li><span class="icon-calendar"></span>Historial</li></a>
				<a onclick="sust('indicadores',true);"><li><span class="icon-stats-dots"></span>Indicador</li></a>
				<?php
				if($usuario['tipo'] == 'root'){
					echo '<a onclick="sust(\'lista\',true);"><li><span class="icon-users"></span>Usuarios</li></a>';
				}
				?>
				<div class="sep_list"></div>
				<a href="/instrucciones"><li><span class="icon-clipboard"></span>Documentación</li></a>
				<a href="/ayuda"><li><span class="icon-question"></span>Ayuda o soporte</li></a>
				<a href="/uso"><li><span class="icon-list2"></span>Política de privacidad y uso de cookies</li></a>
				<div class="sep_list"></div>
				<a onclick="salir();"><li><span class="icon-log-out"></span>Cerrar sesión</li></a>
				<!--a onclick=""><li><span class="icon-chart"></span>Prueba 2</li></a>
				<a onclick=""><li><span class="icon-bars"></span>Prueba 3</li></a>
				<a onclick=""><li><span class="icon-graph"></span>Prueba 4</li></a>
				<a onclick=""><li><span class="icon-bars1"></span>Prueba 5</li></a>
				<a onclick=""><li><span class="icon-navicon"></span>Prueba 6</li></a>
				<a onclick=""><li><span class="icon-reorder"></span>Prueba 7</li></a>
				<a onclick=""><li><span class="icon-pushpin"></span>Prueba 8</li></a>
				<a onclick=""><li><span class="icon-calendar"></span>Prueba 9</li></a>
				<a onclick=""><li><span class="icon-display"></span>Prueba 10</li></a>
				<a onclick=""><li><span class="icon-mobile2"></span>Prueba 11</li></a>
				<a onclick=""><li><span class="icon-tablet"></span>Prueba 12</li></a>
				<a onclick=""><li><span class="icon-database"></span>Prueba 13</li></a>
				<a onclick=""><li><span class="icon-user"></span>Prueba 14</li></a>
				<a onclick=""><li><span class="icon-users"></span>Prueba 15</li></a>
				<a onclick=""><li><span class="icon-stats-dots"></span>Prueba 16</li></a>
				<a onclick=""><li><span class="icon-stats-bars"></span>Prueba 17</li></a>
				<a onclick=""><li><span class="icon-clipboard"></span>Prueba 18</li></a>
				<a onclick=""><li><span class="icon-list2"></span>Prueba 19</li></a>
				<a onclick=""><li><span class="icon-warning"></span>Prueba 20</li></a>
				<a onclick=""><li><span class="icon-notification"></span>Prueba 21</li></a>
				<a onclick=""><li><span class="icon-question"></span>Prueba 22</li></a>
				<a onclick=""><li><span class="icon-plus"></span>Prueba 23</li></a>
				<a onclick=""><li><span class="icon-minus"></span>Prueba 24</li></a>
				<a onclick=""><li><span class="icon-cancel-circle"></span>Prueba 25</li></a>
				<a onclick=""><li><span class="icon-arrow-right"></span>Prueba 26</li></a>
				<a onclick=""><li><span class="icon-circle-up"></span>Prueba 27</li></a>
				<a onclick=""><li><span class="icon-circle-right"></span>Prueba 28</li></a>
				<a onclick=""><li><span class="icon-circle-down"></span>Prueba 29</li></a>
				<a onclick=""><li><span class="icon-circle-left"></span>Prueba 30</li></a>
				<a onclick=""><li><span class="icon-checkbox-checked"></span>Prueba 31</li></a>
				<a onclick=""><li><span class="icon-checkbox-unchecked"></span>Prueba 32</li></a>
				<a onclick=""><li><span class="icon-table2"></span>Prueba 33</li></a>
				<a onclick=""><li><span class="icon-share2"></span>Prueba 34</li></a-->
			</ul>
		</div>
		<?php
		if(!$usuario['existe']){
			echo '
			<div class="titulo_home"></div>
			<section class="wrapper" id="ingresoD">
				<form id="registro">
					<div class="reg" id="mantener"><h3 id="mantener">Ingrese sus datos de registro:</h3></div>
					<br>
					<br>
					<input id="mail" placeholder="Correo electrónico"/>
					<br>
					<br>
					<input id="user" placeholder="Usuario"/>
					<br>
					<br>
					<input id="pass" type="password" placeholder="Contraseña"/>
					<br>
					<br>
					<br>
					<div class="opciones" id="mantener">
						<div style="display: inline-block;" id="mantener">
							<a onclick="acept(1)" id="mantener" style="transform: translate(-20px);">Aceptar</a>
							<a onclick="cancel(1)" id="mantener" style="transform: translate(20px);">Cancelar</a>
						</div>
					</div>
					<p id="mensaje1"></p>
				</form>
				<form id="acceso">
					<div class="reg" id="mantener"><h3 id="mantener">Acceso:</h3></div>
					<br>
					<br>
					<input id="userl" onkeyup="if(event.keyCode == 13) acept(2);" placeholder="Usuario o correo electrónico"/>
					<br>
					<br>
					<input id="passl" onkeyup="if(event.keyCode == 13) acept(2);" type="password" placeholder="Contraseña"/>
					<br>
					<br>
					<br>
					<div class="opciones" id="mantener">
						<div style="display: inline-block;" id="mantener">
							<a onclick="acept(2)" id="mantener" style="transform: translate(-20px);">Aceptar</a>
							<a onclick="cancel(2)" id="mantener" style="transform: translate(20px);">Cancelar</a>
						</div>
					</div>
					<p id="mensaje2"></p>
				</form>
			</section>';
		}
		?>
		<div class="conten">
			<div id="contenedor_carga">
				<div id="carga_ext"><div id="carga"></div></div>
			</div>
			<section class="wrapper">
				<form id="nuevo_bloque">
					<p id="descr">Descripción de la actividad:</p>
					<textarea id="texto" name="descr"></textarea>
					<nav class="opciones" id="mantener">
						<div id="imprt">
							<a id="imprt_b" onclick="elegImp();">Importancia <span class="icon-circle-down" id="mantener2"></span></a>
							<div id="opc_imprt">
								<table id="mantener2">
									<tr id="mantener2">
										<th id="mantener2">Elija el nivel de importancia:</th>
									</tr>
									<tr id="mantener2">
										<td onclick="elegI(0);" id="mantener2_0">Imprescindible</td>
									</tr>
									<tr id="mantener2">
										<td onclick="elegI(1);" id="mantener2_1">Alta</td>
									</tr>
									<tr id="mantener2">
										<td onclick="elegI(2);" id="mantener2_2">Normal</td>
									</tr>
									<tr id="mantener2">
										<td onclick="elegI(3);" id="mantener2_3">Baja</td>
									</tr>
									<tr id="mantener2">
										<td onclick="elegI(4);" id="mantener2_4">Prescindible</td>
									</tr>
								</table>
							</div>
						</div>
						<input type="date" id="date">
						<br>
						<div class="bts_pendts" style="display: inline-block;" id="mantener">
							<a class="btAceptar" onclick="aceptar()" id="mantener"><b id="mantener">Aceptar</b></a>
							<a class="btEditar" onclick="terminarEdi()" id="mantener"><b id="mantener">Terminar edición</b></a>
							<div class="sep_bts_2" id="mantener"></div>
							<a onclick="cancelar()" id="mantener"><b id="mantener">Cancelar</b></a>
						</div>
					</nav>
					<p id="mensaje"></p>
				</form>
			</section>
			<section class="wrapper" id="conten">
			</section>
			<?php
			if(!$usuario['existe']){
				echo '
				<footer class="pie_pag">
					<div style="float: left;"><a href="uso/" class="_pol_ckie"><b>Política de privacidad y uso de cookies</b></a></div>
					<br>
					<hr>
					<br>
					<div style="float: right;">Desarrollado por Yetzín</div>
					<br>
					<div style="float: left;">Versión 2.2</div>
					<div style="float: right;">Photo by <a id="un_pic" href="https://unsplash.com/@essentialiving" target="_blank">Essentialiving</a> on <a id="un_pic" href="https://unsplash.com" target="_blank">Unsplash</a></div>
				</footer>
				';
			}
			?>
		</div>
		<script>
			window.onload = function(){
				<?php
				echo $tipoDeCarga;
				?>
			}
		</script>
	</body>
</html>
