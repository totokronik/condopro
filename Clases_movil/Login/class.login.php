<?php 
session_start();
require "../../Datos/config.php";

$username = $_POST['username'];
$password = $_POST['password'];


$sql2 = "SELECT id_usuario, username FROM usuarios WHERE username = '$username' or numero_documento = '$username'";

$resultado2 = mysqli_query($conexion, $sql2);
while ($fila = $resultado2->fetch_assoc()) {
	$id_usuario = $fila['id_usuario'];
	$usernamebd = $fila['username'];
}


$sql = "call LOGIN_USUARIO_SP_RESIDENTE('$username','$password')";

if($resultado = $conexion->query($sql)){
	while($row = mysqli_fetch_assoc($resultado)){
		$valor = $row['valor'];
	}
}


if($valor == '1'){
	header('Location: ../../Vistas_movil/index.html');
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $usernamebd;
	$_SESSION['id_usuario'] = $id_usuario;
}else{
	if($valor == '-1'){
		$msg = "<script type='text/javascript'>alert('El usuario no existe'); javascript:history.back()</script>";
	}elseif ($valor == '-3'){

		$msg = "<script type='text/javascript'>alert('El usuario no es residente, favor acceder a través de Versión Web'); javascript:history.back()</script>";
	
	}else{
		$msg = "<script type='text/javascript'>alert('La contraseña es incorrecta'); javascript:history.back()</script>";
	}
}


echo $msg;
?>