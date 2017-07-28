<?php 
require '../../Datos/config.php';
require "../../Datos/rut.php";

#Valores por defecto de fecha
date_default_timezone_set("America/Santiago");

$accion = 'I';
$estructura = $_POST['estructura'];
$usuario = $_POST['id'];
$tipo_poblacion = $_POST['categoria'];
$fecha_registro = date("Y-m-d H:i:s");
$fecha_llegada = $_POST['fecha_llegada'];
$nacionalidad = $_POST['nacionalidad'];
$numero_documento = $_POST['rut'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$nombre_completo = $nombre." ".$apellido;
$observación = $_POST['observacion'];
$estacionamiento = $_POST['estacionamiento'];
$usrCreacion = $_POST['usrCreacion'];
$estado = 2;
$perfil = $_POST['perfil'];
$nombre_perfil = "";
$condominio = $_POST['condominio'];

if($perfil == '1'){
	$nombre_perfil = 'R';
}else{
	if($perfil >= '2' || $perfil == '-1'){
		$nombre_perfil = 'P';
	}
}

if(Validar_formato($numero_documento) === FALSE){
	$msg = "<script type='text/javascript'>alert('El Rut ingresado es no cumple con el formato correcto'); javascript:history.back()</script>";
	echo $msg;
	die();
}

if($nacionalidad == 1){
	if(validaRut($numero_documento) === FALSE){
		$msg = "<script type='text/javascript'>alert('El Rut ingresado es inválido'); javascript:history.back()</script>";
		echo $msg;
		die();
	}else{
		$SP_Query = "call SP_Registro_poblacion_flotante('$accion', '$nombre_perfil', $condominio, $estructura, 1, $usuario, $tipo_poblacion, '$fecha_registro', $nacionalidad, '$numero_documento', '$nombre_completo','$observación', $estacionamiento, '$fecha_llegada', '$usrCreacion')";
		$resultado = mysqli_query($conexion, $SP_Query);	
	}
}else{
	$SP_Query = "call SP_Registro_poblacion_flotante('$accion', '$nombre_perfil', $condominio, $estructura, 1, $usuario, $tipo_poblacion, '$fecha_registro', $nacionalidad, '$numero_documento', '$nombre_completo','$observación', $estacionamiento, '$fecha_llegada', '$usrCreacion')";
	$resultado = mysqli_query($conexion, $SP_Query);
}


while($fila = mysqli_fetch_assoc($resultado)){
	$valor = $fila['valor'];
}

switch ($valor) {
	case '0':
		$msg = "<script type='text/javascript'>alert('Hubo un error al ejecutar la consulta'); javascript:history.back()</script>";
		echo $msg;
		break;
	case '-1':
		$msg = "<script type='text/javascript'>alert('Ya existe registro para la misma fecha y hora'); javascript:history.back()</script>";
		echo $msg;
		break;
	case '-2':
		$msg = "<script type='text/javascript'>alert('Ya existe registro para la misma fecha'); javascript:history.back()'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Registro insertado correctamente'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '-7':
		$msg = "<script type='text/javascript'>alert('Usuario sin privilegios en el condominio'); javascript:history.back()</script>";
		echo $msg;
		break;
}

?>