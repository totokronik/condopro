<?php 
	require "../../Datos/config.php";
	$condominio = $_GET['id'];
	$usuario = $_GET['user'];

	$activo = 1;

	$consulta = "SELECT rut, dv FROM condominios WHERE id_condominio = $condominio";
	$resultado1 = mysqli_query($conexion, $consulta);

	while ($fila = $resultado1->fetch_assoc()) {
		$rut = $fila['rut'];
		$dv = $fila['dv'];
	}

	$accion = 'D';

	$sql = "call CRUD_Condominio_V2('$accion', $condominio, $rut, '$dv', 'algo', 'algo', 1, 1, 1, 1, 1, $activo, '$usuario')";


	$resultado2 = mysqli_query($conexion, $sql);

	while($row = mysqli_fetch_assoc($resultado2)){
		$valor = $row['valor'];
	}

	switch ($valor) {
		case '-3':
			$msg = "<script>alert('Condominio no existe'); window.location.href = '../../Vistas/pages/Modulo_condominio/condominio.habilitar.php'</script>";
			echo $msg;
			break;
		case '3':
			$msg = "<script>alert('Condominio Habilitado'); window.location.href = '../../Vistas/pages/Modulo_condominio/condominio.habilitar.php'</script>";
			echo $msg;
			break;
	}
?>