<?php
require "../../Datos/config.php";

$accion = "U";
$condominio = $_POST['condominio'];
$formato = $_POST['formato'];
$unidad = $_POST['unidad'];
$torre = $_POST['torre'];
$usrCreacion = $_POST['usrCreacion'];
$SP_Query = "call SP_CRUD_ESTRUCTURA_CONDOMINIO_TEST('$accion', $formato, $condominio, 1, '$torre', '$unidad', 1, '$usrCreacion')";
$resultado = mysqli_query($conexion, $SP_Query);
while ($fila = $resultado->fetch_assoc()) {
	$valor = $fila['valor'];
}
switch ($valor) {
	case '-2':
		$msg = "<script type='text/javascript'>alert('Unidad a modificar ya existe según el formato Torre - unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '-3':
		$msg = "<script type='text/javascript'>alert('Unidad a modificar ya existe según el formato Unidad - torre'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '-4':
		$msg = "<script type='text/javascript'>alert('Unidad a modificar ya existe según el formato Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '-5':
		$msg = "<script type='text/javascript'>alert('Unidad no existe'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '4':
		$msg = "<script type='text/javascript'>alert('Unidad modificada según el formato Torre - Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '5':
		$msg = "<script type='text/javascript'>alert('Unidad modificada según el formato Unidad - Torre'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '6':
		$msg = "<script type='text/javascript'>alert('Unidad modificada según el formato Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
}
?>