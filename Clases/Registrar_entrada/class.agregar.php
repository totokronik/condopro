<?php 
require '../../Datos/config.php';

$accion = 'I';
$estructura = $_POST['estructura'];
$usuario = $_POST['id'];
$tipo_poblacion = $_POST['categoria'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$fecha_hora_estimada = $fecha." ".$hora;
$fecha_hora = date('Y-m-d H:i:s');
$nacionalidad = $_POST['nacionalidad'];
$numero_documento = $_POST['rut'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$nombre_completo = $nombre." ".$apellido;
$observación = "Registro realizado por Conserje";
$estacionamiento = $_POST['estacionamiento'];
$usrCreacion = $_POST['usrCreacion'];
$estado = 2;
$perfil = $_POST['perfil'];
$nombre_perfil = "";
$condominio = $_POST['condominio'];

if($perfil == '1'){
	$nombre_perfil = 'R';
}else{
	if($perfil >= 2){
		$nombre_perfil = 'P';
	}
}

$SP_Query = "call SP_Registro_poblacion_flotante('$accion', '$nombre_perfil', $condominio, $estructura, 1, $usuario, $tipo_poblacion, '$fecha_hora_estimada', $nacionalidad, '$numero_documento', '$nombre_completo','$observación', $estacionamiento, '$fecha_hora', '$usrCreacion')";

$resultado = mysqli_query($conexion, $SP_Query);

while($fila = mysqli_fetch_assoc($resultado)){
	$valor = $fila['valor'];
}

switch ($valor) {
	case '0':
		$msg = "<script type='text/javascript'>alert('Hubo un error al ejecutar la consulta'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '-1':
		$msg = "<script type='text/javascript'>alert('Ya existe registro para la misma fecha y hora'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '-2':
		$msg = "<script type='text/javascript'>alert('Ya existe registro para la misma fecha'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Registro insertado correctamente'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '-7':
		$msg = "<script type='text/javascript'>alert('Usuario sin privilegios en el condominio'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
}

?>