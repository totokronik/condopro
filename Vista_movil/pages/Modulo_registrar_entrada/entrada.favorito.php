<?php
session_start();
require "../../../Datos/config.php";
require "../../../Datos/sidebar.php";

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
$id_usuario = $_SESSION['id_usuario'];
$condominio = $_SESSION['condominio'];
$id_condominio = $_GET['condominio'];

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

$usuario = $_SESSION['id_usuario'];
$residente = "SELECT id_residente FROM residente_condominio WHERE id_usuario = $usuario";

$result_residente = mysqli_query($conexion, $residente);

while($fila = $result_residente->fetch_assoc()){
    $id_residente = $fila['id_residente'];
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
		<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- MetisMenu CSS -->
		<link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
		<!-- Custom Fonts -->
		<link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- Datetime Picker -->
        <link rel="stylesheet" type="text/css" href="../../vendor/datepicker/jquery.datetimepicker.css">
        <!-- Chosen CSS -->
        <link rel="stylesheet" type="text/css" href="../../vendor/chosen/css/chosen.css">
        <link rel="stylesheet" type="text/css" href="../../vendor/chosen/css/prism.css">
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
					?>&nbsp;<a href="../../../Clases_movil/Condominio/class.cambiar.php">Cambiar</a></b>
					<!-- /.dropdown -->
					<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username'];?> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-users fa-fw"></i> <?php echo $msg; ?></a>
                        </li>
                        <li class="divider"></li>
                            <li><a href="../Modulo_usuario/usuario.perfil.php"><i class="fa fa-user fa-fw"></i> Perfil</a>
                        </li>
                        <?php
                            if($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 6 || $_SESSION['perfil'] == 7){
                                echo "<li><a href='../Modulo_favorito/favorito.index.php'><i class='fa fa-gear fa-fw'></i> Favoritos</a></li>";
                            }
                        ?>
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
                <?php echo MostrarNavegadorSecundario($perfil); ?>
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
					<b>Registro de entrada para Favoritos</b>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<form action="../../../Clases/Registrar_entrada/class.favorito.php" method="POST">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="favorito">Favorito</label>
									<select name="favorito" class="form-control">
										<?php
											$consulta = "SELECT * FROM favoritos_residente WHERE id_residente = $id_residente";
											$exec_consulta = mysqli_query($conexion, $consulta);

											while ($fila_consulta = $exec_consulta->fetch_assoc()){
												echo "<option value='".$fila_consulta['id_favorito']."'>".$fila_consulta['nombre']."</option>";
											}
										?>
									</select>
								</div>
							</div>
						</div>
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
                                <div class="form-group" style="display: none;">
                                    <input type="text" name="residente" value="<?php echo $id_residente; ?>">
                                </div>
								<div class="form-group">
									<label>Categoria</label>
									<select name="categoria" class="form-control" required>
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
												$consulta_pob = "SELECT * FROM tipo_poblacion_flotante";
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
								<div class="form-group">
									<label>Fecha y hora estimada</label>&nbsp;&nbsp;
									<input type="text" name="fecha" class="form-control datetimepicker">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Unidad</label>
									<select name="estructura" class="form-control" required>
										<?php
										switch ($perfil) {
                                            case '1':
                                               $consulta_ec = "SELECT ec.* FROM estructura_condominio ec inner join residente_condominio rc on rc.id_estructura_condominio = ec.id_estructura_condominio WHERE ec.id_condominio = $id_condominio AND ec.id_estructura_condominio <> '00000' and rc.id_usuario = $id_usuario";
                                                $resultado_ec = mysqli_query($conexion, $consulta_ec);
                                                while($fila_ec = $resultado_ec->fetch_assoc()){
                                                    echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
                                                }
                                                break;
                                            case '2':
                                                $consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio AND id_estructura_condominio <> '00000'";
                                                $resultado_ec = mysqli_query($conexion, $consulta_ec);
                                                while($fila_ec = $resultado_ec->fetch_assoc()){
                                                    echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
                                                }
                                                break;
											case '3':
												$consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio AND id_estructura_condominio LIKE ('00000')";
												$resultado_ec = mysqli_query($conexion, $consulta_ec);
												while($fila_ec = $resultado_ec->fetch_assoc()){
													echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
												}
												break;
                                            case '4':
                                                $consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio AND id_estructura_condominio LIKE ('00000')";
                                                $resultado_ec = mysqli_query($conexion, $consulta_ec);
                                                while($fila_ec = $resultado_ec->fetch_assoc()){
                                                    echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
                                                }
                                                break;
                                            case '5':
                                                $consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio AND id_estructura_condominio <> '00000'";
                                                $resultado_ec = mysqli_query($conexion, $consulta_ec);
                                                while($fila_ec = $resultado_ec->fetch_assoc()){
                                                    echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
                                                }
                                                break;
											case '6':
												$consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio";
												$resultado_ec = mysqli_query($conexion, $consulta_ec);
												while($fila_ec = $resultado_ec->fetch_assoc()){
													echo "<option value=".$fila_ec['id_estructura_condominio'].">".$fila_ec['unidad']."</option>";
												}
												break;
											case '7':
												$consulta_ec = "SELECT * FROM estructura_condominio WHERE id_condominio = $id_condominio";
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
<!-- Chosen JS -->
<script type="text/javascript" src="../../vendor/chosen/js/jquery.js"></script>
<script type="text/javascript" src="../../vendor/chosen/js/chosen.proto.min.js"></script>
<script type="text/javascript" src="../../vendor/chosen/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="../../vendor/chosen/js/site.js"></script>
<script type="text/javascript" src="../../vendor/datepicker/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
    jQuery.datetimepicker.setLocale('es');
    $(".datetimepicker").datetimepicker();
</script>
</body>
</html>