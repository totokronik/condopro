<?php
session_start();
require "../../../Datos/config.php";
require "../../../Datos/sidebar.php";

if(isset($_SESSION['loggedin'])){
    if(isset($_SESSION['condominio'])){

    }else{
        echo "<script>alert('No se ha seleccionado condominio'); window.location.href = '../condominio.php'</script>";
    }
}else{
    echo "<script>alert('Está página es solo para usuarios registrados'); window.location.href = '../login.html'</script>";
}

$perfil = $_SESSION['perfil'];
$condominio = $_SESSION['condominio'];
$usuario = $_SESSION['username'];
$consulta = "SELECT * FROM usuarios WHERE username = '$usuario'";
$resultado = mysqli_query($conexion, $consulta);
while ($fila = $resultado->fetch_assoc()) {
$nombre = $fila['nombres'];
$apellido = $fila['apellidos'];
$id_usuario = $fila['id_usuario'];
$nro_documento = $fila['numero_documento'];
$telefono_celular = $fila['telefono_celular'];
$email = $fila['email'];
$nacionalidad = $fila['chileno'];
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
            <h1 class="page-header">Perfil</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Perfil de usuario
            </div>
            <br>
            <!-- /.panel-heading -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr style="display: none;">
                            <td>ID</td>
                            <td><?php echo $id_usuario; ?></td>
                        </tr>
                        <tr style="vertical-align: middle;">
                            <td>Numero Documento</td>
                            <td><?php echo $nro_documento; ?></td>
                        </tr>
                        <tr style="vertical-align: middle;">
                            <td>Nombre</td>
                            <td><?php echo $nombre." ".$apellido ?></td>
                        </tr>
                        <tr style="vertical-align: middle;">
                            <td>Telefono/Celular</td>
                            <td><?php echo $telefono_celular; ?></td>
                        </tr>
                        <tr style="vertical-align: middle;">
                            <td>Email</td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <tr style="vertical-align: middle;">
                            <td>Nacionalidad</td>
                            <td>
                                <?php
                                if ($nacionalidad == 1) {
                                echo "Chileno";
                                }else{
                                echo "Extranjero";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <a class="btn btn-primary btn-block" href="usuario.password.php?idusuario=<?php echo $id_usuario; ?>">Cambiar contraseña</a>
                </div>
            </div>
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