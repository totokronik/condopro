<?php
session_start();
require "../../Datos/config.php";
require "../../Datos/metricas.php";
require "../../Datos/sidebar.php";

if(isset($_SESSION['loggedin'])){
    if(isset($_SESSION['condominio'])){

    }else{
        echo "<script>alert('No se ha seleccionado condominio'); window.location.href = 'condominio_movil.php'</script>";
    }
}else{
    echo "<script>alert('Esta página es sólo para usuarios registrados'); window.location.href = 'login_movil.html'</script>";
}

$perfil = $_SESSION['perfil'];
$condominio = $_SESSION['condominio'];
$usuario = $_SESSION['id_usuario'];
date_default_timezone_set("America/Santiago");

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

# Obtener id residente
$consulta = "SELECT id_residente FROM residente_condominio WHERE id_usuario = $usuario";
$resultado = mysqli_query($conexion, $consulta);

if(mysqli_num_rows($resultado) > 0){
    while ($fila = $resultado->fetch_assoc()) {
        $residente = $fila['id_residente'];
    }
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
					?>&nbsp;<a href="../../Clases_movil/Condominio/class.cambiar.php">Cambiar</a></b>
					<!-- /.dropdown-alerts -->
					<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username'];?> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-users fa-fw"></i> <?php echo $msg; ?></a>
                        </li>
                        <li class="divider"></li>
                            <li><a href="Modulo_usuario/usuario.perfil.php"><i class="fa fa-user fa-fw"></i> Perfil</a>
                        </li>
                        <?php
                            if($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 6 || $_SESSION['perfil'] == 7){
                                echo "<li><a href='Modulo_favorito/favorito.index.php'><i class='fa fa-gear fa-fw'></i> Favoritos</a></li>";
                            }
                        ?>
                        <li class="divider"></li>
                        <li><a href="../../Clases/Login/class.logout.php"><i class="fa fa-sign-out fa-fw"></i> Desconectar</a>
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
                            <?php echo MostrarNavegadorPrincipal($perfil); ?>
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
                <?php if($perfil != 1){ ?>
    			<div class="row">
    				<div class="col-lg-4 col-md-6">
    					<div class="panel panel-primary">
    						<div class="panel-heading">
    							<div class="row">
    								<div class="col-xs-3">
    									<i class="fa fa-user fa-5x"></i>
    								</div>
    								<div class="col-xs-9 text-right">
    									<div class="huge"><b><?php echo CantidadRegistrosActuales('V', $condominio); ?></b></div>
    									<div><b><i>Visitas Del Día</i></b></div>
    								</div>
    							</div>
    						</div>
    						<a href="Modulo_registrar_entrada/entrada.index.php">
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
    									<i class="fa fa-user-secret fa-5x"></i>
    								</div>
    								<div class="col-xs-9 text-right">
    									<div class="huge"><b><?php echo CantidadRegistrosActuales('E', $condominio); ?></b></div>
    									<div><b><i>Espacios Reservados Del Día</i></b></div>
    								</div>
    							</div>
    						</div>
    						<a href="Modulo_reserva_espacio_comun/reserva.index.php">
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
    									<i class="fa fa-user-md fa-5x"></i>
    								</div>
    								<div class="col-xs-9 text-right">
    									<div class="huge"><b><?php echo CantidadRegistrosActuales('R', $condominio) ?></b></div>
    									<div><b><i>Residentes activos</b></i></div>
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
                <?php }else{ ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user-md fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><b><?php echo VisitasActivas($residente, $condominio) ?></b></div>
                                        <div><b><i>Visitas activas del día</b></i></div>
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
                    <div class="col-lg-6 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user-md fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><b><?php echo EspaciosReservados($residente, $condominio) ?></b></div>
                                        <div><b><i>Espacios reservados en el Mes <?php echo nombremes(Date("m")); ?></b></i></div>
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
                <?php } ?>
                <br>
                <?php if($perfil != 1){ ?>
    			<div class="row">
    				<div class="col-lg-12 col-md-12 col-xs-12">
    					<div class="panel panel-default">
    						<div class="panel-heading">
    							<b>Visitas <?php echo date("m-Y"); ?></b>
    						</div>
    						<!-- /.panel-heading -->
    						<div class="panel-body">
    							<div id="registro_mes"></div>
    						</div>
    						<!-- /.panel-body -->
    					</div>
    					<!-- /.panel -->
    				</div>
    			</div>
                <?php } ?>
			</div>
			<!-- /#page-wrapper -->
		</div>
		<!-- /#wrapper -->
        <?php if($perfil != 1){ ?>
		<script>
    		Morris.Bar({
        		element : 'registro_mes',
        		data:[<?php echo CantidadRegistro(); ?>],
        		xkey:'fecha',
        		ykeys:['visita', 'proveedor', 'emergencia'],
        		labels:['Visita', 'Proveedor', 'Emergencia'],
        		hideHover:'auto'
    		});
		</script>
        <?php }else{ ?>
        
        <?php } ?>
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