<?php
session_start();
require "../../Datos/config.php";

$accion = "V";
$registro = $_GET['id'];
$nombre_usuario = $_GET['user'];
$id_usuario = $_SESSION['id_usuario'];

$consulta = "SELECT 
				rpf.id_registro as id_registro,
				rpf.id_usuario as id_usuario,
				ec.id_condominio as condominio
			FROM registro_poblacion_flotante rpf
			JOIN estructura_condominio ec ON rpf.id_estructura_condominio = ec.id_estructura_condominio
			JOIN condominios c ON ec.id_condominio = c.id_condominio
			WHERE rpf.id_registro = $registro";
$resultado = mysqli_query($conexion, $consulta);

while ($fila = $resultado->fetch_assoc()) {
	$usuario = $fila['id_usuario'];
	$condominio = $fila['condominio'];
}

$SP_Query = "call SP_Registro_poblacion_flotante('$accion', 'lll', $condominio, 1, $registro, $id_usuario, 1, date('Y-m-d H:i:s'), 1, 'dsakjhd', 'dsad', 'dsa', 1, date('Y-m-d H:i:s'), '$nombre_usuario' )";


$SP_Resultado = mysqli_query($conexion, $SP_Query);

while ($SP_Fila = $SP_Resultado->fetch_assoc()) {
	$SP_Valor = $SP_Fila['valor'];
}

switch ($SP_Valor) {
	case '-4':
		$msg = "<script type='text/javascript'>alert('No es conserje'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '-5':
		$msg = "<script type='text/javascript'>alert('No existe'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '5':
		$msg = "<script type='text/javascript'>alert('Registro validado'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
}
?>