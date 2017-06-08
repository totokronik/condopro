<?php
session_start();
require '../../../Datos/config.php';
if(isset($_SESSION['loggedin'])){
	if($_SESSION['id_usuario'] == 0){

	}else{
		echo "<script>alert('No tienes privilegios para acceder al módulo'); window.location.href = '../condominio.php'</script>";
	}
}else{
echo "<script>alert('Está página es solo para usuarios registrados'); window.location.href = '../login.html'</script>";
}

$usuario = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		../<meta name="description" content="">
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
                <?php if(isset($_SESSION['condominio'])){ ?>
                    <b>Usted se encuentra en <?php 
                    $id = $_SESSION['condominio']; 
                    $consulta = "SELECT nombre_condominio FROM condominios WHERE id_condominio = $id";
                    $resultado = mysqli_query($conexion, $consulta);

                    while($fila = $resultado->fetch_assoc()){
                        $nombre = $fila['nombre_condominio'];
                    }

                    echo $nombre;
                    ?>&nbsp;<a href="../../../Clases/Condominio/class.cambiar.php">Cambiar</a></b>
                <?php }else{ ?>
                    <b>No ha seleccionado condominio &nbsp;<a href="../../../Clases/Condominio/class.cambiar.php">Seleccionar</a></b>
                <?php } ?>
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
				<?php switch ($usuario) {
				    case '0':
				        echo "<li>
				                    <a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
				                </li>
				                <li>
				                    <a href='#'><i class='fa fa-wrench fa-fw'></i> Administración<span class='fa arrow'></span></a>
				                    <ul class='nav nav-second-level'>
				                        <li>
				                            <a href='../Modulo_usuario/usuario.index.php'>Usuarios</a>
				                        </li>
				                        <li>
                                            <a href='../Modulo_personal/personal.index.php'>Personal</a>
                                        </li>
				                    </ul>
				                    <!-- /.nav-second-level -->
				                </li>
				                <li>
				                    <a href='../Modulo_condominio/condominio.index.php'><i class='fa fa-table fa-fw'></i> Condominios</a>
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
			<h1 class="page-header">Gestión de Condominios</h1>
		</div>
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Formulario de condominio
			</div>
			<br>
			<!-- /.panel-heading -->
			<form action="../../../Clases/Condominio/class.modificar.php" method="POST" accept-charset="utf-8">
				<?php
					$id = $_GET['id'];
					$consulta = "SELECT
				cnd.id_condominio as id,
				cnd.rut as rut,
				cnd.dv as digito,
				cnd.nombre_condominio as nombre,
				cnd.direccion as direccion,
				cnd.id_comuna as id_comuna,
				com.nombre_comuna as comuna,
				cnd.cantidad_sectores as cantidad_sectores,
				cnd.unidades_por_piso as unidades,
					cnd.primer_piso_habitable as primer_piso_habitable,
					cnd.cantidad_piso_habitables as cantidad_piso_habitables
				FROM condominios cnd
				JOIN comunas com ON cnd.id_comuna = com.id_comuna
				WHERE cnd.id_condominio = $id";
				$resultado = mysqli_query($conexion, $consulta);
				while($fila = $resultado->fetch_assoc()){
				?>
				<div class="row">
					<div class="col-md-12">
						<div style="display: none;">
							<input type="text" name="userCreacion" value="<?php echo $_SESSION['username']; ?>">
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Rut</label>
								<div class="row">
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="Rut" name="rut" value="<?php echo $fila['rut']; ?>" readonly required />
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" placeholder="Digito" name="dv" value="<?php echo $fila['digito']; ?>" readonly required />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Nombre condominio</label>
								<input type="text" class="form-control" placeholder="Nombre condominio" name="condominio" value="<?php echo $fila['nombre']; ?>" required />
							</div>
							<div class="form-group">
								<label>Dirección</label>
								<input type="text" class="form-control" placeholder="Dirección" name="direccion" value="<?php echo $fila['direccion']; ?>" required />
							</div>
							<div class="form-group">
								<label>Comuna</label>
								<select name="comunas" class="form-control" required>
									<optgroup label="Opción Actual">
										<option value="<?php echo $fila['id_comuna']; ?>"><?php echo $fila['comuna']; ?></option>
									</optgroup>
									<optgroup label="Opciones">
										<?php
										$consulta_c = "SELECT id_comuna, nombre_comuna FROM comunas";
										$resultado_c = mysqli_query($conexion, $consulta_c);
										while ($comunas = $resultado_c->fetch_assoc()) {
											echo "<option value=".$comunas['id_comuna'].">".$comunas['nombre_comuna']."</option>";
										}
										?>
									</optgroup>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cantidad sectores</label>
								<input type="number" class="form-control" placeholder="Cantidad sectores" name="sectores" value="<?php echo $fila['cantidad_sectores']; ?>" required />
							</div>
							<div class="form-group">
								<label>Cantidad pisos habitables</label>
								<input type="number" class="form-control" placeholder="Cantidad pisos habitables" name="cantidad_piso" value="<?php echo $fila['cantidad_piso_habitables']; ?>" required />
							</div>
							<div class="form-group">
								<label>Unidades por piso</label>
								<input type="number" class="form-control" placeholder="Unidades por piso" name="unidad_piso" value="<?php echo $fila['unidades'];?>" required />
							</div>
							<div class="form-group">
								<label>Primer piso habitable</label>
								<input type="number" class="form-control" placeholder="Primer piso habitable" name="primer_piso" value="<?php echo $fila['primer_piso_habitable']; ?>" required />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<input type="submit" class="btn btn-block btn-primary btn-lg" value="Registrar">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							<a href="condominio.index.php" class="btn btn-block btn-warning btn-lg">Volver</a>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</form>
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
</body>
</html>