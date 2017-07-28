<?php 
require "../../Datos/config.php";

#Valores por defecto de fecha
date_default_timezone_set("America/Santiago");

#Acción requerida para insertar registros
$accion = "U";
$username = $_POST['userCreacion'];
$reserva = $_POST['reserva'];
$observacion = "Modificado";
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_termino = $_POST['fecha_termino'];
$fecha_actual = date('Y-m-d H:i:s');

if ($fecha_inicio >= $fecha_actual) {
	if($fecha_termino <= $fecha_inicio){
		$msg = "<script type='text/javascript'>alert('La fecha de termino no puede ser menor o igual a la fecha de inicio'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
	}else{
		if($fecha_termino <= $fecha_actual){
			$msg = "<script type='text/javascript'>alert('La fecha de termino no puede ser menor o igual a la fecha actual'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
			echo $msg;
		}else{
			$SP_Query = "call SP_RESERVA_ESPACIOS_COMUNES('$accion', $reserva, 1, 1, '$observacion', '$fecha_inicio', '$fecha_termino', '$username')";
			$resultado = mysqli_query($conexion, $SP_Query);
		}
	}
} else{
	$msg = "<script type='text/javascript'>alert('La fecha ingresada es menor a la actual'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
	echo $msg;
}

while($row = $resultado->fetch_assoc()){
	$valor = $row['valor'];
}

switch ($valor) {
	case '-3':
		$msg = "<script type='text/javascript'>alert('Reserva ya existe'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
	case '-4':
		$msg = "<script type='text/javascript'>alert('No estas dentro del plazo disponible'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
	case '-2':
		$msg = "<script type='text/javascript'>alert('No es posible realizar la reserva, ya existe una reserva dentro de ese horario'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
	case '2':
		$msg = "<script type='text/javascript'>alert('Se ha modificado correctamente'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
}
?>