<?php
session_start();
require "../../../Datos/config.php";
if(isset($_SESSION['loggedin'])){
	if($_SESSION['perfil'] >= 1){
	}else{
echo "<script>alert('No tienes privilegios para acceder al módulo'); window.location.href = '../index.php'</script>";
}
if(isset($_SESSION['condominio'])){
}else{
echo "<script>alert('No se ha seleccionado condominio'); window.location.href = '../condominio.php'</script>";
}
}else{
echo "<script>alert('Está página es solo para usuarios registrados'); window.location.href = '../login.html'</script>";
}
$perfil = $_SESSION['perfil'];
$condominio = $_SESSION['condominio'];
$id_condominio = $_GET['condominio'];
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
		<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- MetisMenu CSS -->
		<link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
		<link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- JQuery UI CSS -->
		<link rel="stylesheet" href="../../dist/css/jquery-ui.css">
		<!-- JQuery UI -->
		<script src="../../vendor/jquery/jquery-ui.js"></script>
		<script type="text/javascript">
			$(function() {
				$("#rut").autocomplete({
					source: "entrada.visita.php",
					minLength: 1,
					select: function(event, ui) {
						event.preventDefault();
						$('#rut').val(ui.item.numero_documento);
						$('#nombre').val(ui.item.nombre);
						$('#apellido').val(ui.item.apellido);
						$('#id_registro').val(ui.item.id_registr);
					}
				});
			});
		</script>
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
					<a class="navbar-brand" href="../index.php">C O N D O P R O</a>
				</div>
				<!-- /.navbar-header -->
				<ul class="nav navbar-top-links navbar-right">
					<b>Usted se encuentra en <?php
					$id = $_SESSION['condominio'];
					$consulta = "SELECT nombre_condominio FROM condominios WHERE id_condominio = $id";
					$resultado = mysqli_query($conexion, $consulta);
					while($fila = $resultado->fetch_assoc()){
					$nombre = $fila['nombre_condominio'];
					}
					echo $nombre;
					?>&nbsp;<a href="../../../Clases/Condominio/class.cambiar.php">Cambiar</a></b>
					<!-- /.dropdown -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username'];?> <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="../Modulo_usuario/usuario.perfil.php"><i class="fa fa-user fa-fw"></i> Perfil</a>
						</li>
						<li><a href="../Modulo_favorito/favorito.index.php"><i class="fa fa-gear fa-fw"></i> Favoritos</a>
					</li>
					<li class="divider"></li>
					<li><a href="../../../Clases/Login/class.logout.php"><i class="fa fa-sign-out fa-fw"></i> Desconectar</a>
				</li>
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
				echo "<li>
							<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
				</li>
				<li>
							<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
							<ul class='nav nav-second-level'>
										<li>
													<a href='../Modulo_usuario/usuario.index.php'>Usuarios</a>
										</li>
							</ul>
					<!-- /.nav-second-level -->
				</li>
				<li>
					<a href='../Modulo_condominio/condominio.index.php'><i class='fa fa-table fa-fw'></i> Condominios</a>
				</li>";
				break;
				case '4':
				echo "<li>
					<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
				</li>
				<li>
					<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
					<ul class='nav nav-second-level'>
						<li>
							<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
						</li>
					</ul>
				</li>
				<li>
					<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
					<ul class='nav nav-second-level'>
						<li>
							<a href='../Modulo_personal/personal.index.php'>Personal</a>
						</li>
						<li>
							<a href='../Modulo_residente/residente.index.php'>Residentes</a>
						</li>
					</ul>
					<!-- /.nav-second-level -->
				</li>
				<li>
					<a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
				</li>
				<li>
					<a href='../Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
				</li>";
				break;
				
				default:
				echo  "<li>
					<a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
				</li>
				<li>
					<a href='#'><i class='fa fa-users fa-fw'></i> Población Flotante<span class='fa arrow'></span></a>
					<ul class='nav nav-second-level'>
						<li>
							<a href='../Modulo_registrar_entrada/entrada.index.php'>Registrar Entrada</a>
						</li>
					</ul>
				</li>
				<li>
					<a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
					<ul class='nav nav-second-level'>
						<li>
							<a href='../Modulo_personal/personal.index.php'>Personal</a>
						</li>
						<li>
							<a href='../Modulo_residente/residente.index.php'>Residentes</a>
						</li>
					</ul>
					<!-- /.nav-second-level -->
				</li>
				<li>
					<a href='../Modulo_condominio/condominio.index.php'><i class='fa fa-table fa-fw'></i> Condominios</a>
				</li>
				<li>
					<a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
				</li>
				<li>
					<a href='../Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
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
			<h1 class="page-header">Población Flotante</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<b>Registro de entrada</b>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<form action="../../../Clases/Registrar_entrada/class.agregar.php" method="POST">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group" style="display: none;">
									<input type="text" name="usrCreacion" value="<?php echo $_SESSION['username']; ?>">
								</div>
								<div class="form-group" style="display: none;">
									<input type="text" name="id" value="<?php echo $_SESSION['id_usuario']; ?>">
								</div>
								<div class="form-group" style="display: none;">
									<input type="text" name="perfil" value="<?php echo $_SESSION['perfil']; ?>">
								</div>
								<div class="form-group" style="display: none;">
									<input type="text" name="condominio" value="<?php echo $id_condominio; ?>">
								</div>
								<div class="form-group">
									<label>Categoria</label>
									<select name="categoria" class="form-control">
										<?php
										switch ($perfil) {
											case '1':
												$consulta_pob = "SELECT * FROM tipo_poblacion_flotante WHERE id_tipo_poblacion_flotante = 1";
												$resultado_pob = mysqli_query($conexion, $consulta_pob);
												while($fila_pob = $resultado_pob->fetch_assoc()){
												echo "<option value=".$fila_pob['id_tipo_poblacion_flotante'].">".$fila_pob['descripcion']."</option>";
												}
												break;
											case '2':
												$consulta_pob = "SELECT * FROM tipo_poblacion_flotante";
												$resultado_pob = mysqli_query($conexion, $consulta_pob);
												while($fila_pob = $resultado_pob->fetch_assoc()){
												echo "<option value=".$fila_pob['id_tipo_poblacion_flotante'].">".$fila_pob['descripcion']."</option>";
												}
												break;
											case '3':
												$consulta_pob = "SELECT * FROM tipo_poblacion_flotante";
												$resultado_pob = mysqli_query($conexion, $consulta_pob);
												while($fila_pob = $resultado_pob->fetch_assoc()){
												echo "<option value=".$fila_pob['id_tipo_poblacion_flotante'].">".$fila_pob['descripcion']."</option>";
												}
												break;
											case '4':
												$consulta_pob = "SELECT * FROM tipo_poblacion_flotante WHERE id_tipo_poblacion_flotante > 0";
												$resultado_pob = mysqli_query($conexion, $consulta_pob);
												while($fila_pob = $resultado_pob->fetch_assoc()){
												echo "<option value=".$fila_pob['id_tipo_poblacion_flotante'].">".$fila_pob['descripcion']."</option>";
												}
												break;
											case '5':
												$consulta_pob = "SELECT * FROM tipo_poblacion_flotante";
												$resultado_pob = mysqli_query($conexion, $consulta_pob);
												while($fila_pob = $resultado_pob->fetch_assoc()){
												echo "<option value=".$fila_pob['id_tipo_poblacion_flotante'].">".$fila_pob['descripcion']."</option>";
												}
												break;
											case '6':
												$consulta_pob = "SELECT * FROM tipo_poblacion_flotante";
												$resultado_pob = mysqli_query($conexion, $consulta_pob);
												while($fila_pob = $resultado_pob->fetch_assoc()){
												echo "<option value=".$fila_pob['id_tipo_poblacion_flotante'].">".$fila_pob['descripcion']."</option>";
												}
												break;
											case '7':
												$consulta_pob = "SELECT * FROM tipo_poblacion_flotante";
												$resultado_pob = mysqli_query($conexion, $consulta_pob);
												while($fila_pob = $resultado_pob->fetch_assoc()){
												echo "<option value=".$fila_pob['id_tipo_poblacion_flotante'].">".$fila_pob['descripcion']."</option>";
												}
												break;
											default:
												break;
										}
										?>
									</select>
								</div>
								<div class="ui-widget">
									<label>Número de documento</label>
									<input type="text" class="form-control" placeholder="Rut" name="rut" id="rut" />
								</div>
								<div class="form-group">
									<label>Nacionalidad</label>&nbsp;&nbsp;
									<label class="radio-inline">
										<input type="radio" name="nacionalidad" id="nacionalidad1" value="1" checked>Chileno
									</label>
									<label class="radio-inline">
										<input type="radio" name="nacionalidad" id="nacionalidad2" value="0">Extranjero
									</label>
								</div>
								<div class="form-group">
									<label>Fecha y hora estimada</label>&nbsp;&nbsp;
									<div class="row">
										<div class="col-md-7">
											<input type="date" name="fecha" min="2017-01-01" class="form-control">
										</div>
										<div class="col-md-5">
											<input type="time" name="hora" min="08:00" max="22:00" step="1" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="ui-widget">
									<label>Nombre</label>
									<input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" />
								</div>
								<div class="ui-widget">
									<label>Apellido</label>
									<input type="text" class="form-control" placeholder="Apellido" name="apellido" id="apellido"/>
								</div>
								<div class="form-group">
									<label>Unidad</label>
									<select name="estructura" class="form-control">
										<?php
										switch ($perfil) {
											case '3':
												$consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio AND id_estructura_condominio LIKE ('00000')";
												$resultado_ec = mysqli_query($conexion, $consulta_ec);
												while($fila_ec = $resultado_ec->fetch_assoc()){
													echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
												}
												break;
											case '6':
												$consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio AND id_estructura_condominio LIKE ('00000')";
												$resultado_ec = mysqli_query($conexion, $consulta_ec);
												while($fila_ec = $resultado_ec->fetch_assoc()){
													echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
												}
												break;
											case '7':
												$consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio AND id_estructura_condominio LIKE ('00000')";
												$resultado_ec = mysqli_query($conexion, $consulta_ec);
												while($fila_ec = $resultado_ec->fetch_assoc()){
													echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
												}
												break;
											default:
												$consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio AND id_estructura_condominio <> '00000'";
												$resultado_ec = mysqli_query($conexion, $consulta_ec);
												while($fila_ec = $resultado_ec->fetch_assoc()){
													echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
												}
												break;
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Uso de Estacionamiento</label>&nbsp;&nbsp;
									<label class="radio-inline">
										<input type="radio" name="estacionamiento" id="estacionamiento1" value="1" checked>Si
									</label>
									<label class="radio-inline">
										<input type="radio" name="estacionamiento" id="estacionamiento2" value="0">No
									</label>
								</div>
							</div>
							  <input type="hidden" id="id_registro">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="submit" class="btn btn-block btn-lg btn-primary" value="Registrar">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<a href="entrada.index.php" class="btn btn-block btn-lg btn-warning">Volver</a>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
		<div class="col-lg-2"></div>
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script src="../../vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>
</body>
</html>