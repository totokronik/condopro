<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "I";
$username = $_POST['userCreacion'];
$id_residente = $_POST['residente'];
$observacion = "Reserva hecha";
$espacio_comun = $_POST['espacioComun'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$fecha_hora = $fecha." ".$hora;
$horaAnadir=60;
$segundos_horaInicial=strtotime($hora);
$segundos_minutoAnadir=$horaAnadir*60;
$nuevaHora=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);
$fecha_hora_termino = $fecha." ".$nuevaHora;


$fecha_actual = date('Y-m-d');
if ($fecha >= $fecha_actual) {
	$SP_Query = "call SP_RESERVA_ESPACIOS_COMUNES('$accion', 1, $id_residente, $espacio_comun, '$observacion', '$fecha_hora', '$fecha_hora_termino', '$username')";
} else{
	$msg = "<script type='text/javascript'>alert('La fecha ingresada es menor a la actual'); window.location.href = '../../Vistas/pages/Modulo_reserva_espacio_comun/reserva.index.php'</script>";
	echo $msg;
}




//(id_residente, id_espacio_comun, fecha_hora_registro, observacion, fecha_hora_inicio, fecha_hora_termino, usr_creacion, usr_ult_mod)
// IN `pAccion` char(1),
// IN `pIdReserva` integer, 
// IN `pIdResidente` integer , 
// IN `pIdEspacioComun` integer ,
// IN `pObservacion`  blob ,
// IN `pFechaHoraInicio` timestamp ,
// IN `pFechaHoraTermino` timestamp ,
// IN `pUsuario`  varchar(30)



$resultado = mysqli_query($conexion, $SP_Query);

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