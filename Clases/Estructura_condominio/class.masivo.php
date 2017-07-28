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

$contador = $sector * (($cantidad_piso+$primer_piso)-$primer_piso)*$unidades_por_piso;

#die($contador);
##Variables globales 
$EntroInsert = 0;
$SP_Resultado = '';
$SP_Valor = 0;
$SP_ValorCont = 0;

$SP_QueryCont = "Select Count(id_estructura_condominio) as cont from ESTRUCTURA_CONDOMINIO where id_condominio = $condominio and unidad <> '00000' group by id_condominio";

	$SP_ResultadoCont = mysqli_query($conexion, $SP_QueryCont);

while($SP_Fila = $SP_ResultadoCont->fetch_assoc()){
	$SP_ValorCont = $SP_Fila['cont'];
}
$SumaCont = $SP_ValorCont +  $contador;
if ($SumaCont > $contador)
{

$SP_Valor = -1;

}else
{


#Primer for para obtener names de inputs repetidos
for ($i=1; $i <= $sector; $i++) {
	$nombre = 'sector'.$i;
	$nombre_sector = $_POST[$nombre];
	#For para obtener el crear pisos
	for ($j=$primer_piso; $j <= $cantidad_piso+1; $j++) { 
		# Insertar la unidad
		 for ($p=1; $p <= $unidades_por_piso; $p++) {
			
		 	if ( $j < 10){
		 		if ($p < 10){
		 	$unidad = $j.'0'.$p; 
		 		}else{

		 			$unidad = $j.$p; 
		 		}

		 	}elseif ($p < 10){

		 		$unidad = $j.'0'.$p; 
		 	}else{

		 		$unidad = $j.$p; 
		 	}
					
			$Concat_Formato ="";
			switch ($formato) {

						case '1':
						$Concat_Formato = "CONCAT('$nombre_sector' ,'-', '$unidad')";
						$SP_Valor = 1;
							break;
						case '2':
						$Concat_Formato = "CONCAT('$unidad' ,'-', '$nombre_sector')";
						$SP_Valor = 2;
							break;
						case '3':
						$Concat_Formato = "CONCAT('$unidad')";
						$SP_Valor = 3;
							break;
							}

			$SP_Query = "INSERT INTO ESTRUCTURA_CONDOMINIO ( id_condominio, unidad, activo, usr_creacion, usr_ult_mod) VALUES ($condominio, $Concat_Formato, $activo, '$usrCreacion', '$usrCreacion')";

			try{

			$SP_Resultado = mysqli_query($conexion, $SP_Query);
				
			}	
			catch(Exception $e){

						$error= 'Message: ' .$e->getMessage();

			}

		}

	}
}

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