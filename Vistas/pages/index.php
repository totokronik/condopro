<?php
session_start();
require "../../Datos/config.php";
if(isset($_SESSION['loggedin'])){
if(isset($_SESSION['condominio'])){
}else{
echo "<script>alert('No se ha seleccionado condominio'); window.location.href = 'condominio.php'</script>";
}
}else{
echo "<script>alert('Está página es solo para usuarios registrados'); window.location.href = 'login.html'</script>";
}
$perfil = $_SESSION['perfil'];
$condominio = $_SESSION['condominio'];
//Residentes
$consulta_residentes = "SELECT
Count(rc.id_residente) AS identificador
FROM usuarios AS us
INNER JOIN residente_condominio AS rc ON us.id_usuario = rc.id_usuario
WHERE us.activo = 1";
$resultado_residentes = mysqli_query($conexion, $consulta_residentes);
while($fila_residente = $resultado_residentes->fetch_assoc()){
$residente = $fila_residente['identificador'];
}
//Usuario
$consulta_usuario = "SELECT
Count(id_usuario) AS identificador
FROM usuarios
WHERE activo = 1";
$resultado_usuario = mysqli_query($conexion, $consulta_usuario);
while($fila_usuario = $resultado_usuario->fetch_assoc()){
$usuario = $fila_usuario['identificador'];
}
//Personal
$consulta_personal = "SELECT
Count(id_personal_condominio) AS identificador
FROM  personal_condominio
WHERE activo = 1";
$resultado_personal = mysqli_query($conexion, $consulta_personal);
while($fila_personal = $resultado_personal->fetch_assoc()){
$personal = $fila_personal['identificador'];
}
//**************************************************
//Tipo poblacion flotante
//**************************************************
$consulta_grafico1 = "SELECT
count(rpf.id_registro) as cantidad,
tpf.descripcion
FROM registro_poblacion_flotante rpf
JOIN tipo_poblacion_flotante tpf ON rpf.id_tipo_poblacion_flotante = tpf.id_tipo_poblacion_flotante
WHERE tpf.descripcion = 'Visita'
GROUP BY tpf.id_tipo_poblacion_flotante";
$result1 = mysqli_query($conexion, $consulta_grafico1);
while($row1 = $result1->fetch_assoc()){
$Visita = $row1['cantidad'];
}
$consulta_grafico11 = "SELECT
COUNT(rpf.id_registro) as cantidad,
tpf.descripcion
FROM registro_poblacion_flotante rpf
JOIN tipo_poblacion_flotante tpf ON rpf.id_tipo_poblacion_flotante = tpf.id_tipo_poblacion_flotante
WHERE tpf.descripcion = 'Proveedor'
GROUP BY tpf.id_tipo_poblacion_flotante";
$result11 = mysqli_query($conexion, $consulta_grafico11);
while($row11 = $result11->fetch_assoc()){
$Proveedor = $row11['cantidad'];
}
$consulta_grafico111 = "SELECT
COUNT(rpf.id_registro) as cantidad,
tpf.descripcion
FROM registro_poblacion_flotante rpf
JOIN tipo_poblacion_flotante tpf ON rpf.id_tipo_poblacion_flotante = tpf.id_tipo_poblacion_flotante
WHERE tpf.descripcion = 'Emergencias'
GROUP BY tpf.id_tipo_poblacion_flotante";
$result111 = mysqli_query($conexion, $consulta_grafico111);
while($row111 = $result111->fetch_assoc()){
$Emergencias = $row111['cantidad'];
}
//**************************************************
//Grafico Torta Espacios comunes activos/inactivos
//**************************************************
$consulta_grafico2 = "SELECT COUNT(id_espacio_comun) as espacios
FROM espacios_comunes
WHERE activo = 1";
$result2 = mysqli_query($conexion, $consulta_grafico2);
while($fila2 = $result2->fetch_assoc()){
$activo = $fila2['espacios'];
}
$consulta_grafico3 = "SELECT COUNT(id_espacio_comun) as espacios
FROM espacios_comunes
WHERE activo = 0";
$result3 = mysqli_query($conexion, $consulta_grafico3);
while($fila3 = $result3->fetch_assoc()){
$inactivo = $fila3['espacios'];
}
//**************************************************
//Grafico Barras Cantidad de sectores por condominio
//**************************************************
$consulta_grafico4 = "SELECT
COUNT(rec.id_registro_reserva) as cantidad,
tp.descripcion as descripcion
FROM registro_reserva_espacio_comun rec
JOIN residente_condominio rc ON rec.id_residente = rc.id_residente
JOIN usuarios us ON rc.id_usuario = us.id_usuario
JOIN espacios_comunes ec ON rec.id_espacio_comun = ec.id_espacio_comun
JOIN tipo_espacio tp ON ec.id_tipo_espacio = tp.id_tipo_espacio
GROUP BY rec.id_espacio_comun";
$result4 = mysqli_query($conexion, $consulta_grafico4);
$chart_data2 = '';
while($row4 = $result4->fetch_assoc()){
$chart_data2 .= "{ descripcion:'".$row4['descripcion']."', cantidad:'".$row4['cantidad']."'}, ";
}
//*******************************************************
//Grafico barras cantidad condominios creados en cada año
//*******************************************************
$consulta_grafico4 = "SELECT
COUNT(id_condominio) as cantidad,
DATE_FORMAT(fecha_creacion, '%Y') as fecha
FROM condominios
GROUP BY fecha";
$result4 = mysqli_query($conexion, $consulta_grafico4);
$chart_data4 = '';
while($row4 = $result4->fetch_assoc()){
$chart_data4 .= "{ fecha:'".$row4['fecha']."', cantidad:'".$row4['cantidad']."'}, ";
}
#Obtener perfil para mostrar en desplegable del nombre de usuario
switch ($perfil) {
case '-1':
$msg = "Usuario Maestro";
break;
case '1':
$msg = "Residente";
break;
case '2':
$msg = "Conserje";
break;
case '3':
$msg = "Mayordomo";
break;
case '4':
$msg = "Administrador de condominio";
break;
case '5':
$msg = "Conserje y Residente";
break;
case '6':
$msg = "Mayordomo y Residente";
break;
case '7':
$msg = "Administrador y Residente";
break;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>CONDOPRO</title>
		<!-- Bootstrap Core CSS -->
		<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- MetisMenu CSS -->
		<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="../dist/css/sb-admin-2.css" rel="stylesheet">
		<!-- Morris Charts CSS -->
		<!-- <link href="../vendor/morrisjs/morris.css" rel="stylesheet"> -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
		<!-- Custom Fonts -->
		<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="wrapper">
			<!-- Navigation -->
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">C O N D O P R O</a>
				</div>
				<!-- /.navbar-header -->
				<ul class="nav navbar-top-links navbar-right">
					<!-- /.dropdown -->
					<b>Usted se encuentra en <?php
					$id = $_SESSION['condominio'];
					$consulta = "SELECT nombre_condominio FROM condominios WHERE id_condominio = $id";
					$resultado = mysqli_query($conexion, $consulta);
					while($fila = $resultado->fetch_assoc()){
						$nombre = $fila['nombre_condominio'];
					}
					echo $nombre;
					?>&nbsp;<a href="../../Clases/Condominio/class.cambiar.php">Cambiar</a></b>
					<!-- /.dropdown-alerts -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username'];?> <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li class="divider"></li>
							<li>
								<li><a href="#"><i class="fa fa-users fa-fw"></i> <?php echo $msg; ?></a></li>
							</li>
							<li class="divider"></li>
							<li><a href="Modulo_usuario/usuario.perfil.php"><i class="fa fa-user fa-fw"></i> Perfil</a>
						</li>
						<?php 
						switch ($perfil) {
							case '-1':
								
								break;
							
							default:
								echo "<li><a href='Modulo_favorito/favorito.index.php'><i class='fa fa-gear fa-fw'></i> Favoritos</a></li>
						<li class='divider'></li>";
								break;
						}
						?>
						<li><a href="../../Clases/Login/class.logout.php"><i class="fa fa-sign-out fa-fw"></i> Desconectar</a></li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
			</ul>
			<!-- /.navbar-top-links -->
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<?php switch ($perfil) {
						case '-1':
						echo 	"<li>
									<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
								</li>
								<li>
									<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_usuario/usuario.index.php'>Usuarios</a>
										</li>
										<li>
											<a href='Modulo_personal/personal.index.php'>Personal</a>
										</li>
									</ul>
									<!-- /.nav-second-level -->
								</li>
								<li>
									<a href='Modulo_condominio/condominio.index.php'><i class='fa fa-table fa-fw'></i> Condominios</a>
								</li>";
						break;
						case '1':
						echo   "<li>
									<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
								</li>
								<li>
									<a href='Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
								</li>";
						break;
						case '2':
							echo  "<li>
									<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
								</li>
								<li>
									<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
										</li>
									</ul>
								</li>
								<li>
									<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_residente/residente.index.php'>Residentes</a>
										</li>
									</ul>
								<li>
									<a href='Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
								</li>
									<!-- /.nav-second-level -->
								</li>";
						break;
						case '3':
							echo  "<li>
									<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
								</li>
								<li>
									<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
										</li>
									</ul>
								</li>
								<li>
									<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_personal/personal.index.php'>Personal</a>
										</li>
										<li>
											<a href='Modulo_residente/residente.index.php'>Residentes</a>
										</li>
									</ul>
								<li>
									<a href='Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
								</li>
									<!-- /.nav-second-level -->
								</li>";
						break;
						case '4':
							echo  "<li>
									<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
								</li>
								<li>
									<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
										</li>
									</ul>
								</li>
								<li>
									<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_personal/personal.index.php'>Personal</a>
										</li>
										<li>
											<a href='Modulo_residente/residente.index.php'>Residentes</a>
										</li>
									</ul>
								</li>
								<li>
									<a href='Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
								</li>
								<li>
				                    <a href='Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
				                </li>";
						break;
						default:
						  echo  "<li>
									<a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
								</li>
								<li>
									<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
										</li>
									</ul>
								</li>
								<li>
									<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
									<ul class='nav nav-second-level'>
										<li>
											<a href='Modulo_personal/personal.index.php'>Personal</a>
										</li>
										<li>
											<a href='Modulo_residente/residente.index.php'>Residentes</a>
										</li>
									</ul>
								<li>
									<a href='Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
								</li>
									<!-- /.nav-second-level -->
								</li>";
						break;
						} ?>
					</ul>
				</div>
				<!-- /.sidebar-collapse -->
			</div>
			<!-- /.navbar-static-side -->
		</nav>
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Tablero</h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-comments fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php echo $residente; ?></div>
									<div>Residentes activos</div>
								</div>
							</div>
						</div>
						<a href="Modulo_residente/residente.index.php">
							<div class="panel-footer">
								<span class="pull-left">Ver Detalles</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-tasks fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php echo $usuario; ?></div>
									<div>Usuarios activos</div>
								</div>
							</div>
						</div>
						<a href="Modulo_usuario/usuario.index.php">
							<div class="panel-footer">
								<span class="pull-left">Ver Detalles</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-shopping-cart fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php  echo $personal; ?></div>
									<div>Personal activo</div>
								</div>
							</div>
						</div>
						<a href="Modulo_personal/personal.index.php">
							<div class="panel-footer">
								<span class="pull-left">Ver Detalles</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Cantidad de condominios por año</b>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div id="chart4"></div>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Cantidad de espacios comunes activos e inactivos</b>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div id="chart2"></div>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<div class="col-lg-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Tipo población flotante</b>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div id="chart1"></div>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Reserva de espacios</b>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div id="chart3"></div>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /#page-wrapper -->
		</div>
		<!-- /#wrapper -->
		<!-- <script>
		Morris.Bar({
		element : 'chart1',
		data:[<?php #echo $chart_data1; ?>],
		xkey:'nombre',
		ykeys:['sectores', 'pisos', 'unidades'],
		labels:['Sectores','Pisos', 'Unidades'],
		hideHover:'auto'
		//, stacked:true
		});
		</script> -->
		<script>
		Morris.Donut({
		element: 'chart2',
		data: [
		{label: "Activos", value: <?php echo $activo; ?>},
		{label: "Inactivos", value: <?php echo $inactivo; ?>}
		],
		labelColor: '#060',
		colors: [
		'#efaa09',
		'#47402f'
		],
		});
		</script>
		<script>
		Morris.Bar({
		element : 'chart3',
		data:[<?php echo $chart_data2; ?>],
		xkey:'descripcion',
		ykeys:['cantidad'],
		labels:['Cantidad'],
		hideHover:'auto'
		//, stacked:true
		});
		</script>
		<script>
		Morris.Bar({
		element : 'chart4',
		data:[<?php echo $chart_data4; ?>],
		xkey:'fecha',
		ykeys:['cantidad'],
		labels:['Cantidad'],
		hideHover:'auto'
		//, stacked:true
		});
		</script>
		<script>
		Morris.Donut({
		element: 'chart1',
		data: [
		{label: "Visita", value: <?php echo $Visita; ?>},
		{label: "Proveedor", value: <?php echo $Proveedor; ?>},
		{label: "Emergencias", value: <?php echo $Emergencias; ?>}
		],
		labelColor: '#060',
		colors: [
		'#1dabf7',
		'#efa209',
		'#0c9b56'
		],
		});
		</script>
		<!-- jQuery -->
		<script src="../vendor/jquery/jquery.min.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
		<!-- Metis Menu Plugin JavaScript -->
		<script src="../vendor/metisMenu/metisMenu.min.js"></script>
		<!-- Morris Charts JavaScript -->
		<script src="../vendor/raphael/raphael.min.js"></script>
		<script src="../vendor/morrisjs/morris.min.js"></script>
		<!-- <script src="../data/morris-data.js"></script> -->
		<!-- Custom Theme JavaScript -->
		<script src="../dist/js/sb-admin-2.js"></script>
	</body>
</html>