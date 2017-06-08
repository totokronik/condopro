<?php 
session_start();
require "../../Datos/config.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql2 = "SELECT id_usuario FROM usuarios WHERE username = '$username'";

$resultado2 = mysqli_query($conexion, $sql2);
while ($fila = $resultado2->fetch_assoc()) {
	$id_usuario = $fila['id_usuario'];
}

$sql = "call LOGIN_USUARIO_SP('$username','$password')";

if($resultado = $conexion->query($sql)){
	while($row = mysqli_fetch_assoc($resultado)){
		$valor = $row['valor'];
	}
}

if($valor == '1'){
	header('Location: ../../Vistas/index.html');
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['id_usuario'] = $id_usuario;
}else{
	if($valor == '-1'){
		$msg = "<script type='text/javascript'>alert('El usuario no existe'); window.location.href = '../../Vistas/pages/login.html'</script>";
	}else{
		$msg = "<script type='text/javascript'>alert('La contraseña es incorrecta'); window.location.href = '../../Vistas/pages/login.html'</script>";
	}
}


echo $msg;
?>