<?php 
require '../../Datos/config.php';

$accion = 'I';
$estructura = $_POST['estructura'];
$usuario = $_POST['id'];
$tipo_poblacion = $_POST['categoria'];
$fecha_hora_estimada = $_POST['fecha'];
$fecha_hora = date('Y-m-d H:i:s');
$observación = "Registro realizado por Conserje";
$estacionamiento = $_POST['estacionamiento'];
$usrCreacion = $_POST['usrCreacion'];
$estado = 2;
$perfil = $_POST['perfil'];
$nombre_perfil = "";
$condominio = $_POST['condominio'];
$residente = $_POST['residente'];

$consulta_datos = "SELECT * FROM favoritos_residente WHERE id_residente = $residente";
$ejecutar_consulta = mysqli_query($conexion, $consulta_datos);
while($fila_datos = $ejecutar_consulta->fetch_assoc()){
	$numero_documento = $fila_datos['numero_documento'];
	$nombre_completo = $fila_datos['nombre'];
	$nacionalidad = $fila_datos['chileno'];
}


if($perfil == '1'){
	$nombre_perfil = 'R';
}else{
	if($perfil >= '2' || $perfil == '-1'){
		$nombre_perfil = 'P';
	}
}

$SP_Query = "call SP_Registro_poblacion_flotante('$accion', '$nombre_perfil', $condominio, $estructura, 1, $usuario, $tipo_poblacion, '$fecha_hora', $nacionalidad, '$numero_documento', '$nombre_completo','$observación', $estacionamiento, '$fecha_hora_estimada', '$usrCreacion')";

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