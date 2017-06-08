<?php 
require "../../Datos/config.php";

$accion = "U";
$perfil = "P";
$rol = $_POST['rol'];
$usrCreacion = $_POST['userCreacion'];
$id_usuario = $_POST['usuario'];
$id_personal = $_POST['personal'];
$id_condominio = $_POST['condominio'];
$activo = 1;

$SP_Query = "call SP_GESTIONAR_PERFIL_USUARIOS_V2('$accion','$perfil', $id_usuario, $id_condominio, 1, 1, $rol, $activo, '$usrCreacion')";


$resultado2 = mysqli_query($conexion, $SP_Query);

while($row2 = $resultado2->fetch_assoc()){
	$valor = $row2['valor'];
}

switch ($valor) {
	case '-22':
		$msg = "<script>alert('Personal no existe'); window.location.href = '../../Vistas/pages/Modulo_personal/personal.index.php'</script>";
		echo $msg;
		break;
	case '22':
		$msg = "<script>alert('Personal actualizado'); window.location.href = '../../Vistas/pages/Modulo_personal/personal.index.php'</script>";
		echo $msg;
		break;
}
?>