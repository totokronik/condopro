<?php 
$DB_HOST = 'localhost';
$DB_NAME = 'condopro';
$DB_USER = 'root';
$DB_PASS = '';

$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$acentos = $conexion->query("SET NAMES 'utf8'");

if($conexion === false){
	echo "Ha ocurrido un problema".mysqli_connect_error();
}

?>