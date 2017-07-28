<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "I";
$perfil = "R";
$estructura = $_POST['estructura'];
$activo = $_POST['activo'];
$username = $_POST['usuario'];
$usrCreacion = $_POST['userCreacion'];


// echo $estructura."<br>";
// echo $activo."<br>";
// echo $username."<br>";
// echo $usrCreacion."<br>";
// die();


$SP_Query = "call SP_GESTIONAR_PERFIL_USUARIOS('$accion','$perfil', $username, 1, $estructura, 1, 1, $activo, '$usrCreacion')";


$resultado = mysqli_query($conexion, $SP_Query);

while($row = $resultado->fetch_assoc()){
	$valor = $row['valor'];
}
//die($valor);

switch ($valor) {
	case '-1':
		$msg = "<script type='text/javascript'>alert('El usuario ya existe como residente'); window.location.href = '../../Vistas/pages/Modulo_residente/residente.index.php'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Usuario asociado como residente a estructura del condominio'); window.location.href = '../../Vistas/pages/Modulo_residente/residente.index.php'</script>";
		echo $msg;
		break;
}
?>