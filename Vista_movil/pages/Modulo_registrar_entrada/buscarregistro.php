<?php

require "../../../Datos/config.php";
$rut = $_GET['term'];
$consulta = "SELECT numero_documento FROM registro_poblacion_flotante WHERE numero_documento LIKE '%$rut%'";

$result = $conexion->query($consulta);

if($result->num_rows > 0){
	while($fila = $result->fetch_array()){
		$usuarios[] = $fila['numero_documento'];		
	}
	echo json_encode($usuarios);
}


?>