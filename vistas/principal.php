<?php
//$pendienteID;
include('../libs/creaVar.php');
include('../libs/dbConn.php');
include('../libs/usuario.php');
function ordenActual($ord){
	$txt = '';
	switch($ord){
		case 0:		$txt = "Fecha más próxima";		break;
		case 1:		$txt = "Mayor importancia";		break;
		case 2:		$txt = "Orden de creación";		break;
		default:	$txt = "Error";					break;
	}
	return $txt;
}
function ordenActualQuery($ord){
	$txt = '';
	switch($ord){
		case 0:		$txt = "fecha ASC";			break;
		case 1:		$txt = "importancia ASC";	break;
		case 2:		$txt = "id ASC";			break;
		default:	$txt = "fecha ASC";			break;
	}
	return $txt;
}
function colorImp($ord){
	$txt = '';
	switch($ord){
		case 0:		$txt = "b90c0c";	break;
		case 1:		$txt = "aa9b0f";	break;
		case 2:		$txt = "27931a";	break;
		case 3:		$txt = "1a6793";	break;
		case 4:		$txt = "712665";	break;
		default:	$txt = "000";		break;
	}
	return $txt;
}
function txtImp($ord){
	$txt = '';
	switch($ord){
		case 0:		$txt = "Imprescindible";		break;
		case 1:		$txt = "Importancia alta";		break;
		case 2:		$txt = "Importancia normal";	break;
		case 3:		$txt = "Importancia baja";		break;
		case 4:		$txt = "Prescindible";			break;
		default:	$txt = "Error";					break;
	}
	return $txt;
}
if($usuario['existe'] && $usuario['tipo'] != 'desactivado'){
	if($getActividad=$db->query("SELECT `id`, `fecha`, `importancia`, `texto` FROM `operaciones` WHERE `userID` = ".$usuario['id']." AND `estado` = 0 ORDER BY ".ordenActualQuery($usuario['preferencia']).";")){
		$i = 0;
		//echo "<a href=\"vistas/historial.php\" download=\"Historial.html\">Descargar Historial</a>";
		echo '<div class="ordenamiento">
			Ordenar como: <a class="ord_ops" onclick="muestraMenuOpc('.$usuario['preferencia'].');"><b id="mantener3">'.ordenActual($usuario['preferencia']).' <span id="mantener3" class="icon-circle-down"></span></b></a>
			<div id="mantener3" class="menu_ops">
				Cargando...
			</div>
		</div>
		<div class="fondo">
			<div class="finalizaOp">
				<div style="width: max-content; text-align: center; display: inline-block; vertical-align: middle;">
					<div id="mantener4" class="cont_opsT">
						<h2 id="mantener4">¿Desea continuar?</h2>
						<br id="mantener4">
						<a id="mantener4" class="acept_finlz">Aceptar</a>
						<div id="mantener4" class="sep_bts_2"></div>
						<a>Cancelar</a>
					</div>
				</div>
			</div>
		</div>
		';
/*		while($row = $getActividad->fetch_array()){
			$i++;
			echo "<div class=\"contenedorP\" id=\"pendiente\">
				<div id=\"descrip\" class=\"textoP".$row['id']."\">".$row['texto']."</div>
				<div id=\"fecha".$i."\" class=\"fechaCambio".$row['id']."\"></div>
				<div id=\"menu".$row['id']."\" style=\"display: inline-block;\">
					<ul class=\"listaT\">
						<li><a id=\"bFinal\">Finalizar</a>
							<ul>
								<li><a onclick=\"selecc(".$row['id'].", 1);\">Terminado a tiempo</a></li>
								<hr style=\"color: #c6c0cc;\">
								<li><a onclick=\"selecc(".$row['id'].", 2);\">Terminado fuera de tiempo</a></li>
								<hr style=\"color: #c6c0cc;\">
								<li><a onclick=\"selecc(".$row['id'].", 3);\">No terminado</a></li>
								<hr style=\"color: #c6c0cc;\">
								<li><a onclick=\"selecc(".$row['id'].", 4);\">No necesario</a></li>
							</ul>
						</li>
					</ul>
					<a id=\"bFinal\" onclick=\"editar(".$row['id'].", ".$row['importancia'].");\">Editar</a>
				</div>
			</div>
			<div id=\"cfecha".$i."\" class=\"fechaP".$row['id']."\" style=\"display: none;\">".$row['fecha']."</div>";
		}*/

		echo '<div class="pendientes_list">';
		while($row = $getActividad->fetch_array()){
			$i++;
			echo '
			<div class="fila_list" id="pendiente">
				<div style="display: none;" id="vis_'.$row['id'].'">0</div>
				<div class="hd_list" id="hd_list_'.$row['id'].'" onclick="mostrarTxt('.$row['id'].');">
					<div class="bt_list" style="background-color: #'.colorImp($row['importancia']).';"><b>'.txtImp($row['importancia']).'</b></div>
					<div id="fecha'.$i.'" class="fechaCambio'.$row['id'].'" style="width: max-content; font-weight: 800;"></div>
					<div id="list_'.$row['id'].'" class="mos_list">Click para mostrar <span class="icon-circle-down"></span></div>
				</div>
				<div id="pad_list" class="textoP_list'.$row['id'].'">
					<div id="txt_list">
						<div class="btns_list" id="btns_list'.$row['id'].'">
							<div id="listaT" class="listTerm'.$row['id'].'">
								<a id="mantenerT" onclick="selecc('.$row['id'].', 1);">Terminado a tiempo</a>
								<a id="mantenerT" onclick="selecc('.$row['id'].', 2);">Terminado fuera de tiempo</a>
								<a id="mantenerT" onclick="selecc('.$row['id'].', 3);">No terminado</a>
								<a id="mantenerT" onclick="selecc('.$row['id'].', 4);">No necesario</a>
							</div>
							<a id="mantenerT" class="bFinal" onclick="muestraListaT('.$row['id'].');">Finalizar</a>
							<div class="sep_bts_2"></div>
							<a id="bFinal" onclick="editar('.$row['id'].', '.$row['importancia'].');">Editar</a>
						</div>
						<br>
						<br>
						<div id="textoP" class="textoP'.$row['id'].'">'.$row['texto'].'</div>
					</div>
				</div>
				<div id="cfecha'.$i.'" class="fechaP'.$row['id'].'" style="display: none;">'.$row['fecha'].'</div>
			</div>
			<div class="sep_list"></div>
			';
		}
		echo '</div>';
		if($i == 0){
			echo "Sin datos...";
		} else {
			echo " <div id=\"cantidadPF\" style=\"display: none;\">".$i."</div>";
		}
	} else {
		echo "[Error]";
	}
} else {
	exit("[Error]");
}
$db->close();
?>
