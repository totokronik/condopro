<?php 
require "../../Datos/config.php";
$espacio_comun = $_GET['id'];
$username = $_GET['username'];


	$activo = 0;

	$consulta = "SELECT 
                     ec.id_espacio_comun as id,
                     ec.id_condominio as id_condominio,
                     ec.id_tipo_espacio as id_tipo_espacio
                 FROM espacios_comunes ec
                 JOIN condominios cnd ON ec.id_condominio = cnd.id_condominio";

	$resultado1 = mysqli_query($conexion, $consulta);

	while ($fila = $resultado1->fetch_assoc()) {
		$condominio = $fila['id_condominio'];
		$tipo_espacio = $fila['id_tipo_espacio'];
	}


	$accion = 'D';

	$sql = "call CRUD_Espacios_Comunes('$accion', $espacio_comun, $condominio, $tipo_espacio, 'asdad', $activo, '$username')";


	$resultado2 = mysqli_query($conexion, $sql);

	while($row = mysqli_fetch_assoc($resultado2)){
		$valor = $row['valor'];
	}

	switch ($valor) {
		case '-3':
			$msg = "<script>alert('Espacio no existe'); window.location.href = '../../Vistas/pages/Modulo_espacio_comun/espacio.index.php'</script>";
			echo $msg;
			break;
		case '3':
			$msg = "<script>alert('Espacio Inhabilitado'); window.location.href = '../../Vistas/pages/Modulo_espacio_comun/espacio.index.php'</script>";
			echo $msg;
			break;
	}
?>