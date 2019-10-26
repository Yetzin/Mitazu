<?php
if(!isset($sqlAcces))
	exit;
$db = @mysqli_connect(
	$sqlAcces['host'],
	$sqlAcces['userdb'],
	$sqlAcces['passdb'],
	$sqlAcces['database']
) or exit("Error: Problema desde servidor.");
function limpiarString($texto){
	// Es posible que se use mejor [^0-9&#;] para mayor seguridad, pero verificar si es necesario.
	$textoLimpio = str_replace('&#10;', '<br/>', preg_replace('([^A-Za-z0-9&#;])', '', $texto));
	return $textoLimpio;
}
?>
