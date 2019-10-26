<?php
include('../libs/creaVar.php');
include('../libs/dbConn.php');
include('../libs/usuario.php');
if($usuario['existe'] && $usuario['tipo'] != 'desactivado'){
	if(isset($_POST['id']) && isset($_POST['continua']) && isset($_POST['limit'])){
		if($getActividad=$db->query("SELECT `id`, `fecha`, `texto`,`estado` FROM `operaciones` WHERE `userID` = ".$usuario['id']." AND `estado` = ".limpiarString($_POST['id'])." ORDER BY fecha DESC LIMIT ".((0 + limpiarString($_POST['limit']))*(0 + limpiarString($_POST['continua']))).", ".(0 + limpiarString($_POST['limit'])).";")){
			$i = 0;
			while($row = $getActividad->fetch_array()){
				$i++;
				echo "
				<div class=\"Row\">
					<div class=\"Cell\">".$row['fecha']."</div>
					<div class=\"Cell\">".$row['id']."</div>
					<div class=\"Cell\">".$row['texto']."</div>
				</div>
				";
			}
			if($i == 0){
				echo "Sin más datos...";
			}
		}
	}
} else {
	echo "[Error]";
}
$db->close();
?>