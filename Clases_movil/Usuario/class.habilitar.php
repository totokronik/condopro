<?php 
require "../../Datos/config.php";
$usuario = $_GET['id'];

	$activo = 1;

	$consulta = "SELECT username FROM usuarios WHERE id_usuario = '$usuario'";
	$resultado1 = mysqli_query($conexion, $consulta);

	while ($fila = $resultado1->fetch_assoc()) {
		$username = $fila['username'];
	}

	$accion = 'D';

	$sql = "call CRUD_Usuarios_por_Administrador('$accion','$username', 'asd', 1, '12312313', 'asd ads', 'bda bdsa', 12321312, 'asd@gmail.com', $activo, 'asd', 'asd')";


	$resultado2 = mysqli_query($conexion, $sql);

	while($row = mysqli_fetch_assoc($resultado2)){
		$valor = $row['valor'];
	}

	switch ($valor) {
		case '-3':
			$msg = "<script>alert('Usuario no existe'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.index.php'</script>";
			echo $msg;
			break;
		case '3':
			$msg = "<script>alert('Usuario Habilitado'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.habilitar.php'</script>";
			echo $msg;
			break;
	}
?>