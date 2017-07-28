<?php
session_start();
require "../../../Datos/config.php";
require "../../../Datos/rut.php";
require "../../../Datos/sidebar.php";

if(isset($_SESSION['loggedin'])){
    if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 6) {
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
$usuario = $_GET['id'];
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
        <link href="../../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <!-- DataTables Responsive CSS -->
        <link href="../../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
        <!-- Morris Charts CSS -->
        <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">
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
                    <!-- /.dropdown -->
                    <b>Usted se encuentra en <?php
                    $id = $_SESSION['condominio'];
                    $consulta = "SELECT nombre_condominio FROM condominios WHERE id_condominio = $id";
                    $resultado = mysqli_query($conexion, $consulta);
                    while($fila = $resultado->fetch_assoc()){
                    $nombre = $fila['nombre_condominio'];
                    }
                    echo $nombre;
                    ?>&nbsp;<a href="../../../Clases/Condominio/class.cambiar.php">Cambiar</a></b>
                    <!-- /.dropdown-alerts -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username'];?> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
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
                    <h1 class="page-header">Gestión de Usuarios</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Formulario de usuario
                    </div>
                    <br>
                    <!-- /.panel-heading -->
                    <form action="../../../Clases/Usuario/class.modificar.php" method="POST" accept-charset="utf-8">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                $sql = "SELECT * FROM usuarios WHERE id_usuario = $usuario";
                                $resultado = mysqli_query($conexion, $sql);
                                while ($fila = $resultado->fetch_assoc()) {
                                $num_documento = $fila['numero_documento'];
                                $nombre_usuario = $fila['username'];
                                $nombres = $fila['nombres'];
                                $apellidos = $fila['apellidos'];
                                $email = $fila['email'];
                                $telefono_celular = $fila['telefono_celular'];
                                }
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group" style="display: none;">
                                        <label>Usuario creación</label>
                                        <input type="text" class="form-control" placeholder="Usuario" name="usuario_creacion" value="<?php echo $_SESSION['username']; ?>" />
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Usuario</label>
                                        <input type="text" class="form-control" placeholder="Usuario" name="id_usuario" value="<?php echo $usuario; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>Número de documento</label>
                                        <input type="text" class="form-control" value="<?php echo $num_documento; ?>" placeholder="Número de documento" name="rut" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre de usuario</label>
                                        <input type="text" class="form-control" value="<?php echo $nombre_usuario; ?>" placeholder="Nombre de usuario" name="username" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Nombres</label>
                                        <input type="text" class="form-control" value="<?php echo $nombres; ?>" name="nombre" placeholder="Nombre" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Apellidos</label>
                                        <input type="text" class="form-control" value="<?php echo $apellidos; ?>" name="apellido" placeholder="Apellido" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" value="<?php echo $email; ?>" name="email" placeholder="Email" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Telefono Celular</label>
                                        <input type="text" class="form-control" value="<?php echo $telefono_celular; ?>" name="telefono" placeholder="Telefono" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Chileno</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chilenoRadio" id="chilenoRadio1" value="1" checked>Si
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label>
                                                <input type="radio" name="chilenoRadio" id="chilenoRadio2" value="0">No
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
                                        <a href="usuario.index.php" class="btn btn-block btn-warning btn-lg">Volver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>
</html>