<?php 
require "../../Datos/config.php";

#Acción requerida para modificar registros
$accion = "U";
$nro_documento = $_POST['rut'];
$username = $_POST['username'];
$password = '1234';
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$activo = 1;
$chileno = $_POST['chilenoRadio'];
$usrCreacion = $_POST['usuario_creacion'];

$SP_Query = "call CRUD_Usuarios_por_Administrador('$accion', '$username', '$password', $chileno, '$nro_documento', '$nombre', '$apellido', $telefono, '$email', $activo, '$usrCreacion', '$usrCreacion')";

$resultado = mysqli_query($conexion, $SP_Query);

while($row = mysqli_fetch_assoc($resultado)){
	$valor = $row['valor'];
}

switch ($valor) {
	case '-3':
		$msg = "<script type='text/javascript'>alert('El usuario no existe'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.index.php'</script>";
		echo $msg;
		break;
	case '2':
		$msg = "<script type='text/javascript'>alert('Usuario modificado correctamente'); window.location.href = '../../Vistas/pages/Modulo_usuario/usuario.index.php'</script>";
		echo $msg;
		break;
}
?>