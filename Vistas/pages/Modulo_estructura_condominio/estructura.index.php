<?php
session_start();
require "../../../Datos/config.php";
require "../../../Datos/sidebar.php";
if(isset($_SESSION['loggedin'])){
    if ($_SESSION['perfil'] == -1 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 6 || $_SESSION['perfil'] == 7) {
        
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
		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="../../vendor/datatables/Bootstrap-3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../../vendor/datatables/DataTables-1.10.15/css/dataTables.bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../../vendor/datatables/AutoFill-2.2.0/css/autoFill.bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="../../vendor/datatables/Buttons-1.3.1/css/buttons.bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../../vendor/datatables/Responsive-2.1.1/css/responsive.bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../../vendor/datatables/Scroller-1.4.2/css/scroller.bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../../vendor/datatables/datatables.css"/>
		<!-- Datatables JS -->
		<script type="text/javascript" src="../../vendor/datatables/datatables.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/jQuery-2.2.4/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/JSZip-3.1.3/jszip.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/pdfmake-0.1.27/build/pdfmake.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/pdfmake-0.1.27/build/vfs_fonts.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/DataTables-1.10.15/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/DataTables-1.10.15/js/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/AutoFill-2.2.0/js/dataTables.autoFill.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/AutoFill-2.2.0/js/autoFill.bootstrap.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Buttons-1.3.1/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Buttons-1.3.1/js/buttons.bootstrap.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Buttons-1.3.1/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Buttons-1.3.1/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Buttons-1.3.1/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Responsive-2.1.1/js/dataTables.responsive.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Responsive-2.1.1/js/responsive.bootstrap.min.js"></script>
		<script type="text/javascript" src="../../vendor/datatables/Scroller-1.4.2/js/dataTables.scroller.min.js"></script>
		<!-- Custom CSS -->
		<link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
		<!-- Custom Fonts -->
		<link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- Datatables Inicialización -->
		<script type="text/javascript">
		$(document).ready(function() {
		$('#example').dataTable( {
		dom: 'Bfrtip',
		buttons: [
		'excel', 'pdf', 'print'
		],
		"language":{
		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}
		}
		} );
		} );
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
			<h1 class="page-header">Gestión de Estructura de Condominios</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<b>Estructura de Condominios</b>
				</div>
				<!-- /.panel-heading -->
				<br>
				<div class="row">
					<div class="col-md-12">
						&nbsp;&nbsp;&nbsp;
						<?php
							$consulta_es = "SELECT id_estructura_condominio FROM estructura_condominio WHERE unidad <> '00000' AND id_condominio = $condominio";
							$resultado_es = mysqli_query($conexion, $consulta_es);

							if(mysqli_num_rows($resultado_es) > 0){
								echo "<a href='estructura.agregar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Estructura de Condominio</a>";
							}else{
								if($perfil == -1){
									echo "<a href='estructura.agregar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Estructura de Condominio</a>
									<a href='estructura.torre.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva estructura masiva</a>";
								}else{
									if($perfil == 4 || $perfil == 7){
									echo "<a href='estructura.agregar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Estructura de Condominio</a>
									<a href='estructura.torre.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva estructura masiva</a>";
									}else{
										echo "<a href='estructura.agregar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Estructura de Condominio</a>";
									}	
								}
							}
						?>
						<a href="estructura.habilitar.php" class="btn btn-primary btn-success"><span class="glyphicon glyphicon-eye-close"></span> Estructura de Condominios Inhabilitados</a>
					</div>
				</div>
				
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th>Condominio</th>
								<th>Unidad</th>
								<th>Dirección</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$consulta = "SELECT
							ec.id_estructura_condominio AS id_estructura,
							ec.id_condominio AS id_condominio,
							ec.unidad AS unidad,
							ec.activo AS activo,
							cdn.direccion AS direccion,
							cdn.nombre_condominio AS condominio
							FROM estructura_condominio AS ec
							INNER JOIN condominios AS cdn ON ec.id_condominio = cdn.id_condominio
							WHERE ec.activo = 1
                            AND ec.unidad <> '00000'";
							$resultado = mysqli_query($conexion, $consulta);
							while ($fila = $resultado->fetch_assoc()) {
							?>
							<tr class="odd gradeX">
								<td><?php echo $fila['condominio']; ?></td>
								<td><?php echo $fila['unidad']; ?></td>
								<td><?php echo $fila['direccion']; ?></td>
								<td>
									<a href="estructura.modificar.php?id=<?php echo $fila['id_estructura'];?>&user=<?php echo $_SESSION['username']; ?>" title="Modificar" class="btn btn-info btn-block"><i class="fa fa-pencil"></i></a>
									<a href="../../../Clases/Estructura_condominio/class.inhabilitar.php?id=<?php echo $fila['id_estructura']; ?>&user=<?php echo $_SESSION['username']; ?>" title="Inhabilitar" class="btn btn-warning btn-block"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>
</body>
</html>