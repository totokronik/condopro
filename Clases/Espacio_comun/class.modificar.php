<?php 
require "../Datos/config.php";

$accion = 'U';
$usuario = $_POST['username'];
$id_espacio_comun = $_POST['id_tipo'];
$nombre_condominio = $_POST['condominios'];
$descripcion = $_POST['descripcion'];
$id_tipo_espacio = $_POST['espacios'];
$activo = 1;

$sql = "call CRUD_Espacios_Comunes_V2('$accion', $id_espacio_comun, $nombre_condominio, $id_tipo_espacio, '$descripcion', $activo, '$usuario')";

$resultado = mysqli_query($conexion, $sql);

while($row = mysqli_fetch_assoc($resultado)){
	$valor = $row['valor'];
}

	switch ($valor) {
		case '-2':
			$msg = "<script>alert('Espacio no existe'); window.location.href = '../Vistas/pages/gestion_espacios_comunes.php'</script>";
			echo $msg;
			break;
		case '2':
			$msg = "<script>alert('Espacio actualizado'); window.location.href = '../Vistas/pages/gestion_espacios_comunes.php'</script>";
			echo $msg;
			break;
	}
?>