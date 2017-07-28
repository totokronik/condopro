<?php 
require "../../Datos/config.php";

$accion = "U";
$usuario = $_POST['userCreacion'];
$rut = $_POST['rut'];
$digito = $_POST['dv'];
$condominio = $_POST['condominio'];
$idcondominio = $_POST['idcondominio'];
$direccion = $_POST['direccion'];
$comunas = $_POST['comunas'];
$sectores = $_POST['sectores'];
$cantidad_piso = $_POST['cantidad_piso'];
$unidad_piso = $_POST['unidad_piso'];
$primer_piso = $_POST['primer_piso'];
$activo = 1;

$SP_Query = "call CRUD_Condominio_V2('$accion', $idcondominio, $rut, '$digito', '$condominio', '$direccion', $comunas, $sectores, $primer_piso, $cantidad_piso, $unidad_piso, $activo, '$usuario')";


$resultado = mysqli_query($conexion, $SP_Query);

while($fila = mysqli_fetch_assoc($resultado)){
	$valor = $fila['valor'];
}

switch ($valor) {
	case '-2':
		$msg = "<script type='text/javascript'>alert('Condominio no existe'); window.location.href = '../../Vistas/pages/Modulo_condominio/condominio.index.php'</script>";
		echo $msg;
		break;
	case '2':
		$msg = "<script type='text/javascript'>alert('Condominio modificado correctamente'); window.location.href = '../../Vistas/pages/Modulo_condominio/condominio.index.php'</script>";
		echo $msg;
		break;
}
?>