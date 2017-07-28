<?php 
require "../../Datos/config.php";

#Acción requerida para insertar registros
$accion = "D";
$perfil = "R";
$activo = 1;
$residente = $_GET['id'];
$usrCreacion = $_GET['user'];

$sql = "SELECT 
            ec.id_condominio as condominio
        FROM residente_condominio rc
        JOIN estructura_condominio ec ON rc.id_estructura_condominio = ec.id_estructura_condominio
        WHERE rc.id_residente = $residente";
$resultado1 = mysqli_query($conexion, $sql);

while($row1 = $resultado1->fetch_assoc()){
	$condominio = $row1['condominio'];
}

$SP_Query = "call SP_GESTIONAR_PERFIL_USUARIOS('$accion','$perfil', 1, $condominio, 1, $residente, 1, $activo, '$usrCreacion')";


$resultado2 = mysqli_query($conexion, $SP_Query);

while($row2 = $resultado2->fetch_assoc()){
	$valor = $row2['valor'];
}
//die($valor);

switch ($valor) {
	case '-2':
		$msg = "<script type='text/javascript'>alert('No existe residente en el condominio'); window.location.href = '../../Vistas/pages/Modulo_residente/residente.index.php'</script>";
		echo $msg;
		break;
	case '3':
		$msg = "<script type='text/javascript'>alert('Residente habilitado'); window.location.href = '../../Vistas/pages/Modulo_residente/residente.index.php'</script>";
		echo $msg;
		break;
}
?>