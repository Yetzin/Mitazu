<?php
include('../libs/creaVar.php');
include('../libs/dbConn.php');
include('../libs/usuario.php');
if($usuario['existe'] && $usuario['tipo'] != 'desactivado'){
	$tipoOP = array(
		1 => array('cantidad' => 0, 'titulo' => 'Terminados a tiempo'),
		2 => array('cantidad' => 0, 'titulo' => 'Terminados fuera de tiempo'),
		3 => array('cantidad' => 0, 'titulo' => 'No terminados'),
		4 => array('cantidad' => 0, 'titulo' => 'No necesarios')
	);
	$limiteMostrar = 10;
	setlocale(LC_ALL, "es_MX.UTF-8");
	for($j = 1; $j <= 4; $j++){
		if($getCantidad=$db->query("SELECT count(id) FROM `operaciones` WHERE `userID` = ".$usuario['id']." AND `estado` = ".$j." ORDER BY fecha DESC;")){
			if($cantidad = $getCantidad->fetch_array()){
				$tipoOP[$j]['cantidad'] = 0 + $cantidad[0];
			}
		}
		$topesFilas = round((((0 + $tipoOP[$j]['cantidad']) / $limiteMostrar) - 0.5), 0, PHP_ROUND_HALF_UP);
		$faltante = (0 + $tipoOP[$j]['cantidad']) % $limiteMostrar;
		if($topesFilas > 0){
			$topesFilas--;
			$topesFilas+=($faltante > 0? 1 : 0);
		} else {
			$topesFilas = 0;
		}
		//echo $topesFilas." <-> ".$faltante;
		if($getActividad=$db->query("SELECT `id`, `fecha`, `texto`,`estado` FROM `operaciones` WHERE `userID` = ".$usuario['id']." AND `estado` = ".$j." ORDER BY fecha DESC LIMIT ".$limiteMostrar.";")){
			echo "
			<div class=\"contenedorP\" id=\"pendiente\">
				<div class=\"TitleTable\">".$tipoOP[$j]['titulo']." (".($tipoOP[$j]['cantidad'] > 0? $tipoOP[$j]['cantidad'] : "Sin datos").")</div>
				".($tipoOP[$j]['cantidad'] > 0? "<a id=\"bMostrar".$j."\" onclick=\"mostrarOcultar(".$j.");\">Mostrar</a>" : "")."
				<a id=\"bOcultar".$j."\" onclick=\"mostrarOcultar(".$j.");\">Ocultar</a>
				<div id=\"seccion".$j."\" style=\"display: none;\">".$topesFilas."</div>
				<div id=\"plegado".$j."\">
					<div class=\"Table\" id=\"mostrado".$j."\">
						<div class=\"Heading\">
							<div class=\"Cell\">Fecha</div>
							<div class=\"Cell\">Id</div>
							<div class=\"Cell\">Descripción</div>
						</div>
			";
			while($row = $getActividad->fetch_array()){
				echo "
				<div class=\"Row\">
					<div class=\"Cell\">".strftime("%d de %B %G", strtotime($row['fecha']))."</div>
					<div class=\"Cell\">".$row['id']."</div>
					<div class=\"Cell\">".$row['texto']."</div>
				</div>
				";
			}
			if($tipoOP[$j]['cantidad'] == 0){
				echo "Sin datos...";
			}
			echo "
					</div>
					".($topesFilas > 0? "<a id=\"bMostrarMas".$j."\" onclick=\"mostrarMas(".$j.", ".$limiteMostrar.");\">+ Mostrar más</a>" : "")."
				</div>
			</div>
			";
		} else {
			echo "[Error]";
		}
	}
} else {
	exit("[Error]");
}
$db->close();
?>
