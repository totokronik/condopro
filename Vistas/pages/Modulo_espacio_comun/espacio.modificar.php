<?php
session_start();
require "../../../Datos/config.php";
require "../../../Datos/sidebar.php";
if(isset($_SESSION['loggedin'])){
    if ($_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 6 || $_SESSION['perfil'] == 7) {
        
    } else{
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
		<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- MetisMenu CSS -->
		<link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
		<!-- Custom Fonts -->
		<link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                    ?>&nbsp;<a href="../../../Clases/Condominio/class.cambiar.php">Cambiar</a></b>
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
			<h1 class="page-header">Gestión de Espacios Comunes</h1>
		</div>
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Formulario de espacio comun
				</div>
				<br>
				<!-- /.panel-heading -->
				<form action="../../../Clases/Espacio_comun/class.modificar.php" method="POST" accept-charset="utf-8">
					<div class="row">
						<div class="col-md-12">
							<?php
								$id = $_GET['id'];
							$sql = "SELECT
									ec.id_espacio_comun AS id,
									cnd.nombre_condominio AS condominio,
									ec.descripcion AS descripcion,
									ec.id_tipo_espacio AS id_tipo,
									ec.id_condominio AS id_condominio,
									te.descripcion AS tipo_descripcion
									FROM espacios_comunes AS ec
									JOIN condominios AS cnd ON ec.id_condominio = cnd.id_condominio
									INNER JOIN tipo_espacio AS te ON ec.id_tipo_espacio = te.id_tipo_espacio
							WHERE ec.id_espacio_comun = $id";
							$resultado = mysqli_query($conexion, $sql);
							while ($fila = $resultado->fetch_assoc()) {
							
							
							?>
							<div class="col-md-6">
								<div class="form-group" style="display: none;">
									<input type="text"  value="<?php echo $_SESSION['username']; ?>" name="username" />
								</div>
								<div class="form-group" style="display: none;">
									<input type="text" value="<?php echo $fila['id']; ?>" name="id_tipo" />
								</div>
								<div class="form-group">
									<label>Condominio</label>
									<select name="condominios" class="form-control" required>
										<optgroup label="Opcion actual">
											<option value="<?php echo $fila['id_condominio']; ?>"><?php echo $fila['condominio']; ?></option>
										</optgroup>
										<optgroup label="Opciones">
											<?php
											$consulta = "SELECT id_condominio, nombre_condominio FROM condominios";
											$resultado = mysqli_query($conexion, $consulta);
											while ($condominios = $resultado->fetch_assoc()) {
												echo "<option value=".$condominios['id_condominio'].">".$condominios['nombre_condominio']."</option>";
											}
											?>
										</optgroup>
									</select>
								</div>
								<div class="form-group">
									<label>Descripción</label>
									<input type="text" class="form-control" value="<?php echo $fila['descripcion']; ?>" placeholder="Descripcion" name="descripcion" required/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Tipo espacio</label>
									<select name="espacios" class="form-control" required>
										<optgroup label="Opcion actual">
											<option value="<?php echo $fila['id_tipo']; ?>"><?php echo $fila['tipo_descripcion']; ?></option>
										</optgroup>
										<optgroup label="Opciones">
											<?php
											$consulta = "SELECT id_tipo_espacio, descripcion FROM tipo_espacio";
											$resultado = mysqli_query($conexion, $consulta);
											while ($espacios = $resultado->fetch_assoc()) {
												echo "<option value=".$espacios['id_tipo_espacio'].">".$espacios['descripcion']."</option>";
											}
											?>
										</optgroup>
									</select>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<input type="submit" class="btn btn-block btn-primary btn-lg" value="Modificar">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<a href="espacio.index.php" class="btn btn-block btn-warning btn-lg">Volver</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-3"></div>
		</div>
		<!-- /.panel-body -->
	</div>
	<!-- /.col-lg-12 -->
</div>
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
</body>
</html>