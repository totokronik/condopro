<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "D";
$id_reserva = $_GET['id'];
$username = $_GET['user'];

$consulta_sp = "SELECT 
				fecha_hora_inicio
			FROM registro_reserva_espacio_comun
			WHERE id_registro_reserva = $id_reserva";

$resultado_sp = mysqli_query($conexion, $consulta_sp);
while ($fila_sp = $resultado_sp->fetch_assoc()) {
	$fecha_inicio = $fila_sp['fecha_hora_inicio'];
}

$SP_Query = "call SP_RESERVA_ESPACIOS_COMUNES('$accion', $id_reserva, 1, 1, 'asd', '$fecha_inicio', 'asd', '$username')";



$resultado = mysqli_query($conexion, $SP_Query);

while($row = mysqli_fetch_assoc($resultado)){
	$valor = $row['valor'];
}


switch ($valor) {
	case '-3':
		$msg = "<script type='text/javascript'>alert('Reserva no existe'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
	case '-4':
		$msg = "<script type='text/javascript'>alert('Hora limite cumplida'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
	case '-1000':
		$msg = "<script type='text/javascript'>alert('Hora incongruente'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
	case '3':
		$msg = "<script type='text/javascript'>alert('Reserva eliminada'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
}
?>