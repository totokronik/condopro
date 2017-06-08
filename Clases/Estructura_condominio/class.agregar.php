<?php

require "../../Datos/config.php";

$accion = 'I';
$condominio = $_POST['condominio'];
$formato = $_POST['formato'];
$unidad = $_POST['unidad'];
$torre = $_POST['torre'];
$usrCreacion = $_POST['usrCreacion'];

$consulta = "SELECT nombre_condominio FROM condominios WHERE id_condominio = $condominio";
$resultado_consulta = mysqli_query($conexion, $consulta);

while($fila_cond = $resultado_consulta->fetch_assoc()){
	$nombre = $fila_cond['nombre_condominio'];
}

$SP_Query = "call SP_CRUD_ESTRUCTURA_CONDOMINIO('$accion', $formato, $condominio, 1, '$torre', '$unidad', 1, '$usrCreacion',0)";

$resultado = mysqli_query($conexion, $SP_Query);

while($row = $resultado->fetch_assoc()){
	$valor = $row['valor'];
}

switch ($valor) {
	case '-6':
		$msg = "<script type='text/javascript'>alert('Unidad ya existe'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '-2':
		$msg = "<script type='text/javascript'>alert('La unidad ya fue creada según el formato Torre - Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '-3':
		$msg = "<script type='text/javascript'>alert('La unidad ya fue creada según el formato Unidad - Torre'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '-4':
		$msg = "<script type='text/javascript'>alert('La unidad ya fue creada según el formato Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '4':
		$msg = "<script type='text/javascript'>alert('Unidad creada correctamente con el formato Torre - Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '5':
		$msg = "<script type='text/javascript'>alert('Unidad creada correctamente con el formato Unidad - Torre'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '6':
		$msg = "<script type='text/javascript'>alert('Estructura creada según el formato Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
}
?>