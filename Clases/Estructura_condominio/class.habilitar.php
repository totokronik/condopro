<?php 
require "../../Datos/config.php";

$accion = 'D';
$estructura = $_GET['id'];
$usuario = $_GET['user'];
$activo = 1;

$consulta = "call SP_CRUD_ESTRUCTURA_CONDOMINIO('$accion', 1, 1, 1, 'asd', 'asd', $activo, '$usuario',1)";

$resultado = mysqli_query($conexion, $consulta);

while ($fila = $resultado->fetch_assoc()) {
	$valor = $fila['valor'];
}

switch ($valor) {
	case '-5':
		$msg = "<script type='text/javascript'>alert('El registro no existe'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	
	case '7':
		$msg = "<script type='text/javascript'>alert('La estructura ha sido habilitada correctamente'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
}
?>