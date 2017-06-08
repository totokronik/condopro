<?php
require "../../Datos/config.php";

$accion = "D";
$registro = $_GET['id'];
$nombre_usuario = $_GET['user'];

$consulta = "SELECT 
				rpf.id_registro as id_registro,
				rpf.id_usuario as id_usuario,
				ec.id_condominio as condominio,
				rpf.id_estructura_condominio as estructura
			FROM registro_poblacion_flotante rpf
			JOIN estructura_condominio ec ON rpf.id_estructura_condominio = ec.id_estructura_condominio
			JOIN condominios c ON ec.id_condominio = c.id_condominio
			WHERE rpf.id_registro = $registro";
$resultado = mysqli_query($conexion, $consulta);

while ($fila = $resultado->fetch_assoc()) {
	$usuario = $fila['id_usuario'];
	$condominio = $fila['condominio'];
	$estructura = $fila['estructura'];
}

$SP_Query = "call SP_Registro_poblacion_flotante('$accion', 'lll', $condominio, $estructura, $registro, $usuario, 1, date('Y-m-d H:i:s'), 1, 'dsakjhd', 'dsad', 'dsa', 1, date('Y-m-d H:i:s'), '$nombre_usuario')";

$SP_Resultado = mysqli_query($conexion, $SP_Query);

while ($SP_Fila = $SP_Resultado->fetch_assoc()) {
	$SP_Valor = $SP_Fila['valor'];
}

switch ($SP_Valor) {
	case '-6':
		$msg = "<script type='text/javascript'>alert('No es residente'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '-3':
		$msg = "<script type='text/javascript'>alert('Registro no existe'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
	case '3':
		$msg = "<script type='text/javascript'>alert('Registro cancelado'); window.location.href = '../../Vistas/pages/Modulo_registrar_entrada/entrada.index.php'</script>";
		echo $msg;
		break;
}
?>