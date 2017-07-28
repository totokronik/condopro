<?php
require "../../Datos/config.php";

$accion = "S";
$registro = $_GET['id'];
$nombre_usuario = $_GET['user'];

$SP_Query = "call SP_Registro_poblacion_flotante('$accion', 'lll', 1, 1, $registro, 1, 1, date('Y-m-d H:i:s'), 1, 'dsakjhd', 'dsad', 'dsa', 1, date('Y-m-d H:i:s'), '$nombre_usuario' )";

$SP_Resultado = mysqli_query($conexion, $SP_Query);

while ($SP_Fila = $SP_Resultado->fetch_assoc()) {
	$SP_Valor = $SP_Fila['valor'];
}

switch ($SP_Valor) {
	case '-3':
		$msg = "<script type='text/javascript'>alert('No existe el registro'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '4':
		$msg = "<script type='text/javascript'>alert('Salida marcada'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
}
?>