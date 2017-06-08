<?php
require "../../Datos/config.php";

$accion = "X";
$formato = $_POST['formato'];
$condominio = $_POST['condominio'];
$activo = 1;
$usrCreacion = $_POST['usrCreacion'];

#Obtener sector
$obtener_sector = "SELECT cantidad_sectores, primer_piso_habitable, cantidad_piso_habitables, unidades_por_piso FROM condominios WHERE id_condominio = $condominio";
$resultado_sector = mysqli_query($conexion, $obtener_sector);

while ($fila_sector = $resultado_sector->fetch_assoc()) {
	$sector = $fila_sector['cantidad_sectores'];
	$primer_piso = $fila_sector['primer_piso_habitable'];
	$cantidad_piso = $fila_sector['cantidad_piso_habitables'];
	$unidades_por_piso = $fila_sector['unidades_por_piso'];
}

$contador = $sector * (($cantidad_piso-$primer_piso)+1)*$unidades_por_piso;

#Primer for para obtener names de inputs repetidos
for ($i=1; $i <= $sector; $i++) {
	$nombre = 'sector'.$i;
	$nombre_sector = $_POST[$nombre];
	#For para obtener el crear pisos
	for ($j=$primer_piso; $j <= $cantidad_piso; $j++) { 
		# Insertar la unidad
		for ($p=1; $p <= $unidades_por_piso; $p++) {
			$unidad = $j.'0'.$p; 
			$SP_Query = "call SP_CRUD_ESTRUCTURA_CONDOMINIO('$accion', '$formato', $condominio, 1, '$nombre_sector', '$unidad', $activo, '$usrCreacion', $contador)";
			$SP_Resultado = mysqli_query($conexion, $SP_Query);
		}
	}
}
die();
while($SP_Fila = $SP_Resultado->fetch_assoc()){
	$SP_Valor = $SP_Fila['valor'];
}

switch ($SP_Valor) {
	case '-1':
		$msg = "<script type='text/javascript'>alert('Estructura condominio ya existe'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '1':
		$msg = "<script type='text/javascript'>alert('Estructura creada según formato Torre - Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '2':
		$msg = "<script type='text/javascript'>alert('Estructura creada según formato Unidad - Torre'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
	case '3':
		$msg = "<script type='text/javascript'>alert('Estructura creada según formato Unidad'); window.location.href = '../../Vistas/pages/Modulo_estructura_condominio/estructura.index.php'</script>";
		echo $msg;
		break;
}
?>