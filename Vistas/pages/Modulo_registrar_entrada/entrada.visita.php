<?php
require "../../../Datos/config.php";

if (isset($_GET['term'])){
	# conectare la base de datos
 /*
 $queryval="SELECT numero_documento,
									   SUBSTR(nombre,1,POSITION(' ' IN nombre)) as nombre,
									   SUBSTR(nombre,(POSITION(' ' IN nombre))+1) as apellido,
									   id_registro
								FROM registro_poblacion_flotante
								WHERE numero_documento
								LIKE '%";
$queryval2 ="%' LIMIT 0 ,50";								
	*/
$return_arr = array();
/* Si la conexión a la base de datos , ejecuta instrucción SQL. */
if ($conexion)
{
	$fetch = mysqli_query($conexion,"SELECT numero_documento,
									   SUBSTR(nombre,1,POSITION(' ' IN nombre)) as nombre,
									   SUBSTR(nombre,(POSITION(' ' IN nombre))+1) as apellido,
									   id_registro
								FROM registro_poblacion_flotante
								WHERE numero_documento
								LIKE '%" . mysqli_real_escape_string($conexion,($_GET['term'])) . "%' LIMIT 0 ,50"); 

	$fetch = mysqli_query($conexion, $queryval.mysqli_real_escape_string($conexion,($_GET['term'])).$queryval2);
	
	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_registro=$row['id_registro'];
		$row_array['value'] = $row['numero_documento']." | ".$row['nombre']." ".$row['apellido'];
		$row_array['nombre'] = $row['nombre'];
		$row_array['apellido']=$row['apellido'];

		array_push($return_arr,$row_array);
    }
}

/* Cierra la conexión. */
mysqli_close($conexion);

/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);

}
?>
$consulta = 