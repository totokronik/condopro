<?php
	
	require "../../../Datos/config.php";
	$usuario = $_POST['rut'];
	$consulta = "SELECT SUBSTR(nombre,1,POSITION(' ' in nombre)) as nombre, SUBSTR(nombre,(POSITION(' ' in nombre))+1) as apellido FROM registro_poblacion_flotante WHERE numero_documento = '$usuario'";

	$result = $conexion->query($consulta);
	
	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->nombre = $fila['nombre'];
		$respuesta->apellido = $fila['apellido'];	
	}
	echo json_encode($respuesta);

?>