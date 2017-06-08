<?php 
require "../../Datos/config.php";
$usuario = $_GET['id'];
$condominio = $_GET['condominio'];
$usrCreacion = $_GET['user'];
$activo = 1;
$accion = 'D';
$perfil = 'P';
$SP_Query = "call SP_GESTIONAR_PERFIL_USUARIOS_V2('$accion','$perfil', $usuario, $condominio, 1, 1, 3, $activo, '$usrCreacion')";

$resultado = mysqli_query($conexion, $SP_Query);

while($row = mysqli_fetch_assoc($resultado)){
	$valor = $row['valor'];
}

switch ($valor) {
	case '-2':
		$msg = "<script>alert('Personal no existe'); window.location.href = '../../Vistas/pages/Modulo_personal/personal.index.php'</script>";
		echo $msg;
		break;
	case '33':
		$msg = "<script>alert('Personal Habilitado'); window.location.href = '../../Vistas/pages/Modulo_personal/personal.index.php'</script>";
		echo $msg;
		break;
}
?>