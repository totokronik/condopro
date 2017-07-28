<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "U";
$perfil = "R";
$estructura = $_POST['estructura'];
$activo = 1;
$residente = $_POST['residente'];
$condominio = $_POST['condominio'];
$usrCreacion = $_POST['userCreacion'];


$SP_Query = "call SP_GESTIONAR_PERFIL_USUARIOS('$accion','$perfil', 1, $condominio, $estructura, $residente, 1, $activo, '$usrCreacion')";

$resultado = mysqli_query($conexion, $SP_Query);

while($row = $resultado->fetch_assoc()){
	$valor = $row['valor'];
}
//die($valor);

switch ($valor) {
	case '-2':
		$msg = "<script type='text/javascript'>alert('No existe residente en el condominio'); window.location.href = '../../Vistas/pages/Modulo_residente/residente.index.php'</script>";
		echo $msg;
		break;
	case '2':
		$msg = "<script type='text/javascript'>alert('Residente modificado'); window.location.href = '../../Vistas/pages/Modulo_residente/residente.index.php'</script>";
		echo $msg;
		break;
}
?>