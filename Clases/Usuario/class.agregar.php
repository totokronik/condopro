<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "I";
$nro_documento = $_POST['rut'];
$username = $_POST['username'];
$password = $_POST['pass'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$activo = $_POST['activoRadio'];
$chileno = $_POST['chilenoRadio'];
$usrCreacion = $_POST['userCreacion'];

$SP_Query = "call CRUD_Usuarios_por_Administrador('$accion', '$username', '$password', '$chileno', '$nro_documento', '$nombre', '$apellido', $telefono, '$email', '$activo', '$usrCreacion', '$usrCreacion')";

$resultado = mysqli_query($conexion, $SP_Query);

while($row = mysqli_fetch_assoc($resultado)){
	$valor = $row['valor'];
}

switch ($valor) {
	case '-1':
		$msg = "<script type='text/javascript'>alert('El Número de documento ya existe'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.index.php'</script>";
		echo $msg;
		break;
	case '-2':
		$msg = "<script type='text/javascript'>alert('El Nombre de usuario ya existe'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.index.php'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Usuario ingresado correctamente'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.index.php'</script>";
		echo $msg;
		break;
}
?>