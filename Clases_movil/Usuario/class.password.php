<?php 
require "../../Datos/config.php";
$usuario = $_POST['usuario'];
$old_pass = $_POST['old_pass'];
$new_pass = $_POST['new_pass'];
$renew_pass = $_POST['renew_pass'];

$consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = '$usuario'";

$resultado_usuario = mysqli_query($conexion, $consulta_usuario);

while($fila_usuario = $resultado_usuario->fetch_assoc()){
	$nombre_usuario = $fila_usuario['username'];
}

if(empty($old_pass) || empty($new_pass) || empty($renew_pass)){
	echo "<script>alert('No pueden quedar en blanco'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.password.php'</script>";
}else{
	if($new_pass != $renew_pass){
		echo "<script>alert('Las contraseñas no coinciden'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.password.php'</script>";
	}else{
		$sql = "call UPDATE_PASSWORD('$usuario', '$nombre_usuario', '$old_pass', '$new_pass')";

		$resultado = mysqli_query($conexion, $sql);

		while($row = mysqli_fetch_assoc($resultado)){
			$valor = $row['Valor'];
		}

		if($valor == '-1'){
			$msg = "<script type='text/javascript'>alert('No se pudo actualizar la contraseña, la contraseña actual no es correcta'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.password.php'</script>";
		}else{
			if($valor == '0'){
				$msg = "<script type='text/javascript'>alert('Hubo un error al ejecutar la consulta'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.password.php'</script>";
			}else{
				$msg = "<script type='text/javascript'>alert('Contraseña actualizada correctamente'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.perfil.php'</script>";
			}
		}

		echo $msg;
	}
}

?>