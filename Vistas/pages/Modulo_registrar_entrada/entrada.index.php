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
$condominio = $_SESSION['condominio'];
$usuario = $_SESSION['id_usuario'];

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
        "buttons": [ 'excel', 'pdf', 'print' ],
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
            <h1 class="page-header">Población Flotante</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <b>Registro de entrada</b>
                </div>
                <!-- /.panel-heading -->
                <br>
                <div class="row">
                    <?php switch ($perfil) {
                        case '1':

                            # Verifica si el que ingresa al modulo es residente
                            $residente_existe = "SELECT id_residente FROM residente_condominio WHERE id_usuario = $usuario";
                            $resultado_existe = mysqli_query($conexion, $residente_existe);

                            if(mysqli_num_rows($resultado_existe) > 0){
                                while($fila_existe = $resultado_existe->fetch_assoc()){
                                    $residente = $fila_existe['id_residente'];
                                }

                                $residente_fav = "SELECT * FROM favoritos_residente WHERE id_residente = $residente";
                                $resultado_fav = mysqli_query($conexion, $residente_fav);
                                if(mysqli_num_rows($resultado_fav) > 0){
                                 echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.favorito.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada Favorito</a>
                                  </div>";
                                }else{
                                    echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    </div>";
                                }
                            }else{
                                echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                  </div>";
                            }
                            break;
                    	case '2':
                    		echo "<div class='col-md-6'>
			                        &nbsp;&nbsp;&nbsp;
			                        <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
			                        <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
			                      </div>";
                    		break;
                    	case '-1':
                    		echo "<div class='col-md-6'>
			                        &nbsp;&nbsp;&nbsp;
			                        <a href='entrada.agregar.php?condominio=<?php echo $condominio; ?>' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
			                      </div>";
                    		break;
                        case '4':
                            echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                  </div>";
                            break;
                        case '5':
                            # Verifica si el que ingresa al modulo es residente
                            $residente_existe = "SELECT id_residente FROM residente_condominio WHERE id_usuario = $usuario";
                            $resultado_existe = mysqli_query($conexion, $residente_existe);

                            if(mysqli_num_rows($resultado_existe) > 0){
                                while($fila_existe = $resultado_existe->fetch_assoc()){
                                    $residente = $fila_existe['id_residente'];
                                }

                                $residente_fav = "SELECT * FROM favoritos_residente WHERE id_residente = $residente";
                                $resultado_fav = mysqli_query($conexion, $residente_fav);
                                if(mysqli_num_rows($resultado_fav) > 0){
                                 echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.favorito.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada Favorito</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                  </div>";
                                }else{
                                    echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                    </div>";
                                }
                            }else{
                                echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                  </div>";
                            }
                            break;
                        case '6':
                            # Verifica si el que ingresa al modulo es residente
                            $residente_existe = "SELECT id_residente FROM residente_condominio WHERE id_usuario = $usuario";
                            $resultado_existe = mysqli_query($conexion, $residente_existe);

                            if(mysqli_num_rows($resultado_existe) > 0){
                                while($fila_existe = $resultado_existe->fetch_assoc()){
                                    $residente = $fila_existe['id_residente'];
                                }

                                $residente_fav = "SELECT * FROM favoritos_residente WHERE id_residente = $residente";
                                $resultado_fav = mysqli_query($conexion, $residente_fav);
                                if(mysqli_num_rows($resultado_fav) > 0){
                                 echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.favorito.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada Favorito</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                  </div>";
                                }else{
                                    echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                    </div>";
                                }
                            }else{
                                echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                  </div>";
                            }
                            break;
                        case '7':
                            # Verifica si el que ingresa al modulo es residente
                            $residente_existe = "SELECT id_residente FROM residente_condominio WHERE id_usuario = $usuario";
                            $resultado_existe = mysqli_query($conexion, $residente_existe);

                            if(mysqli_num_rows($resultado_existe) > 0){
                                while($fila_existe = $resultado_existe->fetch_assoc()){
                                    $residente = $fila_existe['id_residente'];
                                }

                                $residente_fav = "SELECT * FROM favoritos_residente WHERE id_residente = $residente";
                                $resultado_fav = mysqli_query($conexion, $residente_fav);
                                if(mysqli_num_rows($resultado_fav) > 0){
                                 echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.favorito.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada Favorito</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                  </div>";
                                }else{
                                    echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                    </div>";
                                }
                            }else{
                                echo "<div class='col-md-6'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='entrada.agregar.php?condominio=".$condominio."' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nueva Entrada</a>
                                    <a href='entrada.historial.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-list'></span> Historial de visitas</a>
                                  </div>";
                            }
                            break;
                    }?>
                </div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="example">
                        <thead>
                            <tr>
                                <th>Unidad</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Fecha/hora registro</th>
                                <th>Fecha/hora ingreso</th>
                                <th>Fecha/hora salida</th>
                                <th>Categoria</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            switch($perfil){
                                case '1':
                                        $consulta_total = "SELECT
                                        rpf.id_registro AS id_registro,
                                        rpf.chileno AS nacionalidad,
                                        rpf.nombre AS nombre,
                                        rpf.fecha_hora_registro AS registro,
                                        rpf.fecha_hora_ingreso AS ingreso,
                                        rpf.fecha_hora_salida AS salida,
                                        rpf.uso_estacionamiento AS estacionamiento,
                                        tpf.descripcion AS categoria,
                                        epf.descripcion AS estado,
                                        ec.unidad AS unidad
                                        FROM registro_poblacion_flotante AS rpf
                                        INNER JOIN tipo_poblacion_flotante AS tpf ON rpf.id_tipo_poblacion_flotante = tpf.id_tipo_poblacion_flotante
                                        INNER JOIN estados_poblacion_flotante AS epf ON rpf.id_estado_registro = epf.id_estado_registro
                                        INNER JOIN estructura_condominio AS ec ON ec.id_estructura_condominio = rpf.id_estructura_condominio
                                        WHERE ec.id_condominio = $condominio
                                        AND rpf.id_estado_registro BETWEEN '1' AND '2'
                                        AND rpf.id_usuario = $usuario";
                                    break;
                                default:
                                        $consulta_total = "SELECT
                                        rpf.id_registro AS id_registro,
                                        rpf.chileno AS nacionalidad,
                                        rpf.nombre AS nombre,
                                        rpf.fecha_hora_registro AS registro,
                                        rpf.fecha_hora_ingreso AS ingreso,
                                        rpf.fecha_hora_salida AS salida,
                                        rpf.uso_estacionamiento AS estacionamiento,
                                        tpf.descripcion AS categoria,
                                        epf.descripcion AS estado,
                                        ec.unidad AS unidad
                                        FROM registro_poblacion_flotante AS rpf
                                        INNER JOIN tipo_poblacion_flotante AS tpf ON rpf.id_tipo_poblacion_flotante = tpf.id_tipo_poblacion_flotante
                                        INNER JOIN estados_poblacion_flotante AS epf ON rpf.id_estado_registro = epf.id_estado_registro
                                        INNER JOIN estructura_condominio AS ec ON ec.id_estructura_condominio = rpf.id_estructura_condominio
                                        WHERE ec.id_condominio = $condominio
                                        AND rpf.id_estado_registro BETWEEN '1' AND '2'";
                                    break;

                            }
                            $resultado_total = mysqli_query($conexion, $consulta_total);
                            while ($row = $resultado_total->fetch_assoc()) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $row['unidad']; ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['estado']; ?></td>
                                <td><?php echo $row['registro']; ?></td>
                                <td><?php echo $row['ingreso']; ?></td>
                                <td><?php 
                                    if(empty($row['salida'])){
                                        echo "No hay salida registrada";
                                    }else{
                                        echo $row['salida']; 
                                    } ?>
                                </td>
                                <td><?php echo $row['categoria']; ?></td>
                                <?php switch ($perfil) {
                                    case '1':
                                        if($row['estado'] == 'Ingreso validado'){
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.salida.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-warning btn-block'><i class='fa fa-sign-out'></i></a>
                                             </td>";
                                        }else{
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.cancelar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-danger btn-block'><i class='fa fa-minus-circle'></i></a>
                                             </td>";
                                        }
                                        break;
                                	case '2':
                                        if($row['estado'] == 'Ingreso validado'){
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.salida.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-warning btn-block'><i class='fa fa-sign-out'></i></a>
                                             </td>";
                                        }else{
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.validar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-success btn-block'><i class='fa fa-check'></i></a>
                                             </td>";
                                        }
                                		break;
                                    case '3':
                                        if($row['estado'] == 'Ingreso validado'){
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.salida.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-warning btn-block'><i class='fa fa-sign-out'></i></a>
                                             </td>";
                                        }else{
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.validar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-success btn-block'><i class='fa fa-check'></i></a>
                                             </td>";
                                        }
                                        break;
                                    case '4':
                                        if($row['estado'] == 'Ingreso validado'){
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.salida.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-warning btn-block'><i class='fa fa-sign-out'></i></a>
                                             </td>";
                                        }else{
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.validar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-success btn-block'><i class='fa fa-check'></i></a>
                                             </td>";
                                        }
                                        break;
                                	case '5':
                                        if($row['estado'] == 'Ingreso validado'){
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.salida.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-warning btn-block'><i class='fa fa-sign-out'></i></a>
                                             </td>";
                                        }else{
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.validar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-success btn-block'><i class='fa fa-check'></i></a>
                                                <a href='../../../Clases/Registrar_entrada/class.cancelar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-danger btn-block'><i class='fa fa-minus-circle'></i></a>
                                             </td>";
                                        }
                                		break;
                                    case '6':
                                        if($row['estado'] == 'Ingreso validado'){
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.salida.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-warning btn-block'><i class='fa fa-sign-out'></i></a>
                                             </td>";
                                        }else{
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.validar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-success btn-block'><i class='fa fa-check'></i></a>
                                                <a href='../../../Clases/Registrar_entrada/class.cancelar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-danger btn-block'><i class='fa fa-minus-circle'></i></a>
                                             </td>";
                                        }
                                        break;
                                    case '7':
                                        if($row['estado'] == 'Ingreso validado'){
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.salida.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-warning btn-block'><i class='fa fa-sign-out'></i></a>
                                             </td>";
                                        }else{
                                            echo "<td>
                                                <a href='../../../Clases/Registrar_entrada/class.validar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-success btn-block'><i class='fa fa-check'></i></a>
                                                <a href='../../../Clases/Registrar_entrada/class.cancelar.php?id=".$row['id_registro']."&user=".$_SESSION['username']."' class='btn btn-danger btn-block'><i class='fa fa-minus-circle'></i></a>
                                             </td>";
                                        }
                                        break;
                                } ?>
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
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
</body>
</html>