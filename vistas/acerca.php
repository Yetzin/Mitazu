<?php
include('libs/creaVar.php');
include('libs/dbConn.php');
include('libs/usuario.php');
?>
<style>
	.titulo_home{
		background: linear-gradient(rgba(100, 100, 100, 0.2), rgba(100, 100, 100, 0.2)), url('multimedia/essentialiving-yvG7vDXCzDE-unsplash.jpg');
	}
	/*header{ position: absolute; }*/
	.mitad{
		/*position: absolute;
		top: 30%;*/
		width: 100%;
		padding: 0 5% 0 5%;
		color: #663131;
		padding-bottom: 50px;
		text-align: left;
	}
	.mitad .linea_pre_1{
		background: linear-gradient(to right, #423131, transparent, transparent);
		height: 6px;
		width: 100%;
		border-radius: 2px;
	}
	.conten{
		padding-top: 0;
		width: 100%;
		position: absolute;
		top: 160px;
		min-height: 100%;
		z-index: 2;
		text-align: center;
	}
	.pie_pag{
		background-color: #252932;
		background-color: #2529329b;
		color: #fff;
		width: 100%;
		padding: 20px 7% 50px 7%;
		position: absolute;
		bottom: 0;
		right: 0;
		left: 0;
	}
	.sub_menu{
		text-align: center;
		width: 100%;
		overflow: auto;
	}
	.con_sub{
		width: 33%;
		min-width: 320px;
		padding: 60px 30px;
		display: inline-block;
	}
	.msg_tip{
		width: 100%;
		height: 250px;
		background: #fff;
		background: #ffffff8b;
		padding: 40px 30px;
		text-align: left;
		-webkit-box-shadow: 5px 5px 15px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 5px 5px 15px 0px rgba(0,0,0,0.75);
		box-shadow: 5px 5px 15px 0px rgba(0,0,0,0.75);
		display: table;
	}
	.msg_tip:hover{
	}
	#un_pic{
		text-decoration: underline;
		color: #fff;
	}
	.div_n{
		width: 100%;
		display: table-row;
	}
	.enl_ini:hover{
		text-decoration: underline;
		cursor: pointer;
	}
	.flechita_uwu_1, .flechita_uwu_2, .flechita_uwu_3{
		display: none;
		position: absolute;
		width: 30px;
		height: 30px;
		background-color: transparent;
		top: 230px;
		z-index: -1;
		-ms-transform: rotate(45deg); /* IE 9 */
		-webkit-transform: rotate(45deg); /* Chrome, Safari, Opera */
		transform: rotate(45deg);
		-webkit-box-shadow: 6px -6px 5px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 6px -6px 5px 0px rgba(0,0,0,0.75);
		box-shadow: 6px -6px 5px 0px rgba(0,0,0,0.75);
	}
	.flechita_uwu_1{ right: 40px; }
	.flechita_uwu_2{ right: 60px; }
	.flechita_uwu_3{ right: 80px; }
	.flechita_uwu_1:hover, .flechita_uwu_2:hover, .flechita_uwu_3:hover{
		-webkit-box-shadow: 6px -6px 5px 0px rgba(100, 100, 100,0.75);
		-moz-box-shadow: 6px -6px 5px 0px rgba(100, 100, 100,0.75);
		box-shadow: 6px -6px 5px 0px rgba(100, 100, 100,0.75);
	}
	.opciones a{
		display: inline-block;
		color: #fff;
		text-decoration: none;
		cursor: pointer;
		padding: 10px 10px;
		line-height: normal;
		-webkit-transition: all 500ms ease;
		-o-transition: all 500ms ease;
		transition: all 500ms ease;
		vertical-align: middle;
		border-bottom: 4px solid #569046;
	}
	.sep_a{
		display: inline;
		padding: 0 10px;
	}
	.opciones a:hover{
		background: #c0adff;
		color: #000;
	}
	@media screen and (max-width: 2000px){
		.titulo_home{
			background: linear-gradient(rgba(100, 100, 100, 0.2), rgba(100, 100, 100, 0.2)), url('multimedia/essentialiving-yvG7vDXCzDE-unsplash(1).jpg');
		}
	}

	@media screen and (max-width: 1500px){
		.mitad .linea_pre_1{
			background: linear-gradient(to right, #423131, transparent);
		}
		.titulo_home{
			background: linear-gradient(rgba(100, 100, 100, 0.2), rgba(100, 100, 100, 0.2)), url('multimedia/essentialiving-yvG7vDXCzDE-unsplash(2).jpg');
		}
		.sub_menu{ display: flex; }
		.con_sub{
			min-width: 33%;
			padding: 2%;
		}
	}

	@media screen and (max-width: 850px){
		.sub_menu{ display: inline-block; }
		.con_sub{
			min-width: 100%;
			padding: 10px 30px;
		}
		.msg_tip{
			height: 100%;
		}
	}

	@media screen and (max-width: 800px){
		.botones{
			width: 100%;
			text-align: right;
		}
		._menu_h{
			padding-right: 0;
			text-align: right;
		}
	}

	@media screen and (max-width: 600px){
		.botones{
			width: 330px;
		}
		._menu_h{
			padding-right: 0;
		}
	}

	@media screen and (max-width: 500px){
		.titulo_home{
			background: linear-gradient(rgba(100, 100, 100, 0.2), rgba(100, 100, 100, 0.2)), url('multimedia/essentialiving-yvG7vDXCzDE-unsplash(3).jpg');
		}
		.mitad{
			padding-bottom: 30px;
		}
		.botones{
			width: 270px;
		}
		._menu_h{
			font-size: 12px;
			width: 100%;
		}
		#registro, #acceso{
			padding-top: 160px;
		}
		#nombre, #mail, #user, #pass, #userl, #passl{
			height: 30px;
			padding: 0 20px 0 20px;
			font-size: 12px;
		}
	}

	@media screen and (max-width: 400px){
		header .logo{ display: none; }
		._menu_h{
			font-size: 12px;
			width: 100%;
			text-align: center;
		}
		.botones{
			width: 100%;
			text-align: center;
		}
	}

	.titulo_home{
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
		width: 100%;
		min-height: 100%;
		vertical-align: middle;
		min-height: 100%;
		color: black;
		position: fixed;
		z-index: 0;
	}
</style>
<div class="hola">
	<p id="quees">¿Qué es Mitazu?</p>
	<p id="expl">Es una agenda online, pero a diferencia de otras agendas que a veces pueden ser un poco complicadas, o bien, tediosas de organizar, Mitazu prefiere entregar una que sólo pida una <u><b>descripción y una fecha de finalización de la actividad</b></u>.</p>
	<p id="estodo"><b>¡Y eso es todo! :D</b></p>
	<p id="expl">Bueno más o menos, siéntete libre de usar esta aplicación a tu conveniencia.</p>
	<!--p id="expl">Adicional a eso podrás ver un indicador del rendimiento o productividad que estés consiguiendo de acuerdo a tu autoevaluación sobre las actividades que termines satisfactoriamente, las que termines fuera de tiempo y las que no termines.</p>
	<p id="expl">También podrás ver el historial de las actividades que registres en tu cuenta.</p>
	<p id="expl">Espero te guste y sobre todo que sea de mucha utilidad para ti.</p-->
</div>
<br>
<br>
<br>
<br>
<div class="hola">
	<p id="expl">Adicional a eso podrás ver un indicador del rendimiento o productividad que estés consiguiendo de acuerdo a tu autoevaluación sobre las actividades que termines satisfactoriamente, las que termines fuera de tiempo y las que no termines.</p>
	<p id="expl">También podrás ver el historial de las actividades que registres en tu cuenta.</p>
	<p id="expl">Espero te guste y sobre todo que sea de mucha utilidad para ti.</p>
	<p><b>:)</b></p>
	<!--nav class="botones"><a onclick="registro()">Registrarse</a></nav-->
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
