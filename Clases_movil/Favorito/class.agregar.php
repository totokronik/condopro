<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "I";
$residente = $_POST['residente'];
$chileno = $_POST['chileno'];
$nombre = $_POST['nombre'];
$documento = $_POST['documento'];
$usrCreacion = $_POST['userCreacion'];


$SP_Query = "call CRUD_Favoritos('$accion', 1, $residente, $chileno, '$documento', '$nombre', '$usrCreacion')";

$resultado = mysqli_query($conexion, $SP_Query);

while($row = mysqli_fetch_assoc($resultado)){
	$valor = $row['valor'];
}

switch ($valor) {
	case '-1':
		$msg = "<script type='text/javascript'>alert('El favorito ya existe'); window.location.href = '../../Vistas/pages/Modulo_favorito/favorito.index.php'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Favorito ingresado'); window.location.href = '../../Vistas/pages/Modulo_favorito/favorito.index.php'</script>";
		echo $msg;
		break;
}
?>