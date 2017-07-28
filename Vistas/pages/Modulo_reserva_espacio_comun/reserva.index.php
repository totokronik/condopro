<?php
session_start();
require "../../../Datos/config.php";
require "../../../Datos/sidebar.php";
if(isset($_SESSION['loggedin'])){
    if ($_SESSION['perfil'] >= 1) {

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
$usuario = $_SESSION['id_usuario'];
$consulta_sp = "SELECT id_residente
FROM residente_condominio
WHERE id_usuario = $usuario";
$resultado_sp = mysqli_query($conexion, $consulta_sp);
while ($fila_sp = $resultado_sp->fetch_assoc()) {
$usuario_residente = $fila_sp['id_residente'];
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

# Cargar calendario
$consulta_calendario = "SELECT
                        rec.id_registro_reserva AS reserva,
                        ec.descripcion AS titulo,
                        rec.fecha_hora_inicio AS inicio,
                        rec.fecha_hora_termino AS fin
                        FROM
                        registro_reserva_espacio_comun rec
                        INNER JOIN espacios_comunes ec ON rec.id_espacio_comun = ec.id_espacio_comun
                        INNER JOIN tipo_espacio te ON ec.id_tipo_espacio = te.id_tipo_espacio
                        WHERE
                        ec.id_condominio = $condominio";
$ejecutar_calendario = mysqli_query($conexion, $consulta_calendario);
$data = "";

if(mysqli_num_rows($ejecutar_calendario) > 0){
    while($fila_calendario = $ejecutar_calendario->fetch_assoc()){
        $data .= "{id: '".$fila_calendario['reserva']."', title: '".$fila_calendario['titulo']."', start: '".$fila_calendario['inicio']."', end: '".$fila_calendario['fin']."'}, ";
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
        <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Full Calendar -->
        <link href='../../vendor/calendar/fullcalendar.min.css' rel='stylesheet' />
        <link href='../../vendor/calendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
        <style>
            #calendar {
                margin: 0 auto;
            }
        </style>
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
            <h1 class="page-header">Gestión reserva espacios</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <b>Lista de reservas</b>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        &nbsp;&nbsp;&nbsp;
                        <a href="reserva.agregar.php" class="btn btn-primary btn-success"><span class="glyphicon glyphicon-plus"></span> Nueva Reserva</a>
                        <a href="reserva.eliminar.php" class="btn btn-primary btn-success"><span class="glyphicon glyphicon-search"></span> Reservas realizadas</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /#wrapper -->
<!-- JQuery -->
<script src="../../vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>
<!-- Full Calendar -->
<script src='../../vendor/calendar/moment.min.js'></script>
<script src='../../vendor/calendar/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {    
        $('#calendar').fullCalendar({
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            buttonText: {
                prevYear: "Año Anterior",
                nextYear: "Próximo Año",
                year: "Año",
                today: "Hoy",
                month: "Mes",
                week: "Semana",
                day: "Día"
            },
            titleRangeSeparator: " – ",
            allDayText: "Todo el día",
            views: {
                month: { buttonText: 'Mes' },
                agendaWeek: { buttonText: 'Semana' },
                agendaDay: { buttonText: 'Día' },
                listWeek: { buttonText: 'Agenda' },
            },
            defaultDate: new Date(),
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: [
            <?php echo $data; ?>
            ]
        }); 
    });
</script>
</body>
</html>