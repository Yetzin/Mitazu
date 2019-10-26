<?php
/*
*	Es necesario agregar el contenido de cada respectivo campo en la variable $sqlAcces.
*/
$sqlAcces = array(
	'host' => "",
	'userdb' => "",
	'passdb' => "",
	'database' => ""
);
if($sqlAcces['host'] == "" && $sqlAcces['userdb'] == "" && $sqlAcces['passdb'] == "" && $sqlAcces['database'] == ""){
	echo "Faltan datos de acceso en creaVar<br>";
}
?>
