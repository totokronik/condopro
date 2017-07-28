<?php 
require "../../Datos/config.php";

#Valores por defecto de fecha
date_default_timezone_set("America/Santiago");

#Acción requerida para insertar registros
$accion = "I";
$username = $_POST['userCreacion'];
$id_residente = $_POST['residente'];
$observacion = $_POST['observacion'];
$espacio_comun = $_POST['espacioComun'];
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
			$SP_Query = "call SP_RESERVA_ESPACIOS_COMUNES('$accion', 1, $id_residente, $espacio_comun, '$observacion', '$fecha_inicio', '$fecha_termino', '$username')";
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
	case '-1':
		$msg = "<script type='text/javascript'>alert('Reserva ya existe'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
	case '-2':
		$msg = "<script type='text/javascript'>alert('Espacio/Equipo no disponible en fecha y horarios indicados'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Reserva realizada'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
		echo $msg;
		break;
}
?>