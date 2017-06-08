<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "U";
$favorito = $_POST['favorito'];
//$residente = $_POST['residente'];
$chileno = $_POST['chileno'];
$nombre = $_POST['nombre'];
$documento = $_POST['documento'];
$usrCreacion = $_POST['userCreacion'];



// echo $favorito."<br>";
// echo $residente."<br>";
// echo $chileno."<br>";
// echo $nombre."<br>";
// echo $documento."<br>";
// echo $usrCreacion."<br>";
// die();

$SP_Query = "call CRUD_Favoritos('$accion', $favorito, 1, $chileno, '$documento', '$nombre', '$usrCreacion')";

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
	case '-2':
		$msg = "<script type='text/javascript'>alert('Favorito no existe'); window.location.href = '../../Vistas/pages/Modulo_favorito/favorito.index.php'</script>";
		echo $msg;
		break;
	case '2':
		$msg = "<script type='text/javascript'>alert('Datos actualizados'); window.location.href = '../../Vistas/pages/Modulo_favorito/favorito.index.php'</script>";
		echo $msg;
		break;
}
?>