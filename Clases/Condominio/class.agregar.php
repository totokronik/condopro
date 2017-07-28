<?php 
require "../../Datos/config.php";

$accion = "I";
$usuario = $_POST['userCreacion'];
$rut = $_POST['rut'];
$digito = $_POST['dv'];
$condominio = $_POST['condominio'];
$direccion = $_POST['direccion'];
$comunas = $_POST['comuna'];
$sectores = $_POST['sectores'];
$cantidad_piso = $_POST['cantidad_piso'];
$unidad_piso = $_POST['unidad_piso'];
$primer_piso = $_POST['primer_piso'];
$activo = $_POST['activo'];

$SP_Query = "call CRUD_Condominio('$accion', 1, $rut, '$digito', '$condominio', '$direccion', $comunas, $sectores, $primer_piso, $cantidad_piso, $unidad_piso, $activo, '$usuario')";

$resultado = mysqli_query($conexion, $SP_Query);

while($fila = mysqli_fetch_assoc($resultado)){
	$valor = $fila['valor'];
}

switch ($valor) {
	case '-1':
		$msg = "<script type='text/javascript'>alert('El Rut existe'); window.location.href = '../../Vistas/pages/Modulo_condominio/condominio.index.php'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Condominio ingresado correctamente'); window.location.href = '../../Vistas/pages/Modulo_condominio/condominio.index.php'</script>";
		echo $msg;
		break;
}
?>