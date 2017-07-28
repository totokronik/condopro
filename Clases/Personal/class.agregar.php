<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "I";
$perfil = "P";
$condominio = $_POST['condominio'];
$rol = $_POST['rol'];
$activo = $_POST['activo'];
$username = $_POST['usuario'];
$usrCreacion = $_POST['userCreacion'];


$SP_Query = "call SP_GESTIONAR_PERFIL_USUARIOS('$accion','$perfil', $username, $condominio, 1, 1, $rol, $activo, '$usrCreacion')";

$resultado = mysqli_query($conexion, $SP_Query);

while($row = mysqli_fetch_assoc($resultado)){
	$valor = $row['valor'];
}

switch ($valor) {
	case '-11':
		$msg = "<script type='text/javascript'>alert('El usuario ya existe como personal'); window.location.href = '../../Vistas/pages/Modulo_personal/personal.index.php'</script>";
		echo $msg;
		break;
	case '11':
		$msg = "<script type='text/javascript'>alert('Usuario asociado como personal del condominio'); window.location.href = '../../Vistas/pages/Modulo_personal/personal.index.php'</script>";
		echo $msg;
		break;
}
?>