<?php
require "config.php";

#Funciones para perfil 2 hasta 7
function CantidadRegistrosActuales($tipo, $condominio){
	$valor = 0;
	global $conexion;
	mysqli_query($conexion, "set @fecha = CURDATE()");
	switch ($tipo) {
		case 'V':
			$consulta = "SELECT
						 Count(rpf.id_registro) AS Cantidad
						 FROM
						 registro_poblacion_flotante AS rpf
						 INNER JOIN 
						 estructura_condominio AS ec 
						 ON 
						 rpf.id_estructura_condominio = ec.id_estructura_condominio
						 WHERE
						 DATE_FORMAT(rpf.fecha_hora_ingreso, '%Y-%m-%d') = @fecha 
						 AND
						 rpf.id_estado_registro = 2
						 AND
						 ec.id_condominio = $condominio";
			$resultado = mysqli_query($conexion, $consulta);
			while($fila = $resultado->fetch_assoc()){
				$valor = $fila['Cantidad'];
			}
			break;
		case 'E':
			$consulta = "SELECT
						 Count(rec.id_registro_reserva) AS Cantidad
						 FROM
						 registro_reserva_espacio_comun AS rec
						 INNER JOIN
						 espacios_comunes AS ec 
						 ON
						 rec.id_espacio_comun = ec.id_espacio_comun
						 WHERE
						 DATE_FORMAT(rec.fecha_hora_inicio, '%Y-%m-%d') = @fecha
						 AND
						 ec.id_condominio = $condominio";
			$resultado = mysqli_query($conexion, $consulta);
			while($fila = $resultado->fetch_assoc()){
				$valor = $fila['Cantidad'];
			}
			break;
		case 'R':
			$consulta = "SELECT
						 Count(rc.id_residente) AS Cantidad
						 FROM
						 residente_condominio AS rc
						 INNER JOIN 
						 estructura_condominio AS ec 
						 ON 
						 rc.id_estructura_condominio = ec.id_estructura_condominio
						 WHERE
						 ec.id_condominio = $condominio
						 AND
						 rc.id_usuario <> 0
						 AND
						 rc.activo = 1";
			$resultado = mysqli_query($conexion, $consulta);
			while($fila = $resultado->fetch_assoc()){
				$valor = $fila['Cantidad'];
			}
			break;	
	}

	return $valor;
}

function CantidadRegistro(){
	global $conexion;
	mysqli_query($conexion, "SET lc_time_names = 'es_ES'");
	mysqli_query($conexion, "SET @Fecha_Actual = DATE_FORMAT(NOW(),'%Y-%m')");
	$consulta = "SELECT	
				(SELECT COUNT(id_registro) FROM registro_poblacion_flotante WHERE id_tipo_poblacion_flotante = 1 AND DATE_FORMAT(fecha_hora_ingreso, '%Y-%m') = @Fecha_Actual) AS Visita,
				(SELECT COUNT(id_registro) FROM registro_poblacion_flotante WHERE id_tipo_poblacion_flotante = 2 AND DATE_FORMAT(fecha_hora_ingreso, '%Y-%m') = @Fecha_Actual) AS Proveedor,
				(SELECT COUNT(id_registro) FROM registro_poblacion_flotante WHERE id_tipo_poblacion_flotante = 3 AND DATE_FORMAT(fecha_hora_ingreso, '%Y-%m') = @Fecha_Actual) AS Emergencia,
				CONCAT(UCASE(LEFT(DATE_FORMAT(fecha_hora_ingreso, '%M'), 1)), LCASE(SUBSTR(DATE_FORMAT(fecha_hora_ingreso, '%M'),2))) AS Fecha
				FROM registro_poblacion_flotante
				WHERE DATE_FORMAT(fecha_hora_ingreso, '%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m')
				GROUP BY Fecha";
	$resultado = mysqli_query($conexion, $consulta);
	$valor = '';
	while($fila = $resultado->fetch_assoc()){
		$valor .= "{fecha:'".$fila['Fecha']."', visita:'".$fila['Visita']."', proveedor:'".$fila['Proveedor']."', emergencia:'".$fila['Emergencia']."'},";
	}
	$valor = substr($valor, 0, -1);

	return $valor;
}

function VisitasActivas($residente,$condominio){
	global $conexion;
	$consulta = "SELECT
				 Count(rpf.id_registro) AS Cantidad
				 FROM
				 registro_poblacion_flotante AS rpf
				 INNER JOIN residente_condominio AS rc ON rpf.id_usuario = rc.id_usuario
				 INNER JOIN estructura_condominio ec ON rc.id_estructura_condominio = ec.id_estructura_condominio
				 INNER JOIN condominios cn ON ec.id_condominio = cn.id_condominio
				 WHERE
				 rc.id_residente = $residente
				 AND
				 ec.id_condominio = $condominio
				 AND
				 DATE_FORMAT(rpf.fecha_hora_ingreso,'%Y-%m-%d') IN (DATE_FORMAT(NOW(),'%Y-%m-%d'))";
	$resultado = mysqli_query($conexion, $consulta);
	while($fila = $resultado->fetch_assoc()){
		$valor = $fila['Cantidad'];
	}

	return $valor;
}

function EspaciosReservados($residente, $condominio){
	global $conexion;
	$consulta = "SELECT
				Count(rrec.id_registro_reserva) AS Cantidad
				FROM
				registro_reserva_espacio_comun AS rrec
				INNER JOIN residente_condominio AS rc ON rrec.id_residente = rc.id_residente
				INNER JOIN estructura_condominio ec ON rc.id_estructura_condominio = ec.id_estructura_condominio
				INNER JOIN condominios cn ON ec.id_condominio = cn.id_condominio
				WHERE
				DATE_FORMAT(rrec.fecha_hora_inicio, '%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m')
				AND
				rrec.id_residente = $residente
				AND
				ec.id_condominio = $condominio";
	$resultado = mysqli_query($conexion, $consulta);
	while($fila = $resultado->fetch_assoc()){
		$valor = $fila['Cantidad'];
	}

	return $valor;
}

function nombremes($mes){
	setlocale(LC_TIME, 'spanish');  
	$nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
	return $nombre;
} 

?>