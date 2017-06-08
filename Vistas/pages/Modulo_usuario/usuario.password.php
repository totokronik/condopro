<?php
session_start();
require "../../../Datos/config.php";
if(isset($_SESSION['loggedin'])){
if ($_SESSION['perfil'] != -1) {
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
                    ?>&nbsp;<a href="../../Clases/Condominio/class.cambiar.php">Cambiar</a></b>
                    <!-- /.dropdown-alerts -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username'];?> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li class="divider"></li>
                            <li><a href="#"><i class="fa fa-users fa-fw"></i> <?php echo $msg; ?></a></li>
                            
                            <li><a href="../Modulo_usuario/usuario.perfil.php"><i class="fa fa-user fa-fw"></i> Perfil</a>
                        </li>
                        <li><a href='../../../Clases/Login/class.logout.php'><i class='fa fa-sign-out fa-fw'></i> Desconectar</a></li>
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
                        echo    "<li>
                            <a href=../'index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
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
                        case '1':
                        echo   "<li>
                            <a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
                        </li>
                        <li>
                            <a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
                        </li>";
                        break;
                        case '2':
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
                                    <a href='../Modulo_residente/residente.index.php'>Residentes</a>
                                </li>
                            </ul>
                            <li>
                                <a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
                            </li>
                            <!-- /.nav-second-level -->
                        </li>";
                        break;
                        case '3':
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
                            <li>
                                <a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
                            </li>
                            <!-- /.nav-second-level -->
                        </li>";
                        break;
                        case '4':
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
                            <li>
                                <a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
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
                <div class="col-md-12">
                    <h1 class="page-header">Contraseña</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Cambio de Contraseña
                        </div>
                        <br>
                        <!-- /.panel-heading -->
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <form action="../../../Clases/Usuario/class.password.php" method="POST">
                                    <div class="form-group" style="display: none;">
                                        <input type="text" class="form-control" placeholder="Contraseña actual" value="<?php echo $usuario; ?>" name="usuario" />
                                    </div>
                                    <div class="form-group">
                                        <label>Contraseña actual</label>
                                        <input type="text" class="form-control" placeholder="Contraseña actual" name="old_pass" />
                                    </div>
                                    <div class="form-group">
                                        <label>Nueva contraseña</label>
                                        <input type="text" class="form-control" placeholder="Nueva contraseña" name="new_pass" />
                                    </div>
                                    <div class="form-group">
                                        <label>Repetir contraseña</label>
                                        <input type="text" class="form-control" placeholder="Repetir contraseña" name="renew_pass" />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-block btn-primary" value="Cambiar">
                                    </div>
                                    <div class="form-group">
                                        <a href="usuario.perfil.php" class="btn btn-block btn-warning">Volver</a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-1"></div>
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