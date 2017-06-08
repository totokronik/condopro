<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "I";
$username = $_POST['userCreacion'];
$id_condominio = $_POST['condominio'];
$id_tipo_espacio = $_POST['espacioComun'];
$descripcion = $_POST['descripcion'];
$activo = $_POST['activo'];


$SP_Query = "call CRUD_Espacios_Comunes_V2('$accion', 1, $id_condominio, $id_tipo_espacio, '$descripcion', $activo, '$username')";

$resultado = mysqli_query($conexion, $SP_Query);

while($row = $resultado->fetch_assoc()){
	$valor = $row['valor'];
}

switch ($valor) {
	case '-1':
		$msg = "<script type='text/javascript'>alert('El espacio ya existe'); window.location.href = '../../Vistas/pages/Modulo_espacio_comun/espacio.index.php'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Espacio ingresado correctamente'); window.location.href = '../../Vistas/pages/Modulo_espacio_comun/espacio.index.php'</script>";
		echo $msg;
		break;
}
?>