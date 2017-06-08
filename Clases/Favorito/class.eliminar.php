<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "D";
$favorito = $_GET['id'];


$SP_Query = "call CRUD_Favoritos('$accion', $favorito, 1, 1, 1, 1, 1)";

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
	case '-3':
		$msg = "<script type='text/javascript'>alert('No existe favorito'); window.location.href = '../../Vistas/pages/Modulo_favorito/favorito.index.php'</script>";
		echo $msg;
		break;
	case '3':
		$msg = "<script type='text/javascript'>alert('Favorito eliminado'); window.location.href = '../../Vistas/pages/Modulo_favorito/favorito.index.php'</script>";
		echo $msg;
		break;
}
?>