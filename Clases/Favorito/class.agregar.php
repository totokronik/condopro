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

// IN pAccion			CHAR(1),
// IN pIdFavorito		INT,
// IN pIdResidente		INT,
// IN pChileno			BIT,
// IN pNumeroDocumento	VARCHAR(20),
// IN pNombre			VARCHAR(255),
// IN pUsuario			VARCHAR(30)

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