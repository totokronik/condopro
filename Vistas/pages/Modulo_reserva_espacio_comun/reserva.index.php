<?php
session_start();
require "../../../Datos/config.php";
if(isset($_SESSION['loggedin'])){
    if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] > 2) {
        
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
               <?php switch ($perfil) {
                    case '-1':
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
                    case '1':
                        echo   "<li>
                                    <a href='../index.php'><i class='fa fa-dashboard fa-fw'></i> Tablero</a>
                                </li>
                                <li>
                                    <a href='../Modulo_reserva_espacio_comun/reserva.index.php'><i class='fa fa-table fa-fw'></i> Reserva espacio común</a>
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
                                            <a href='../Modulo_usuario/usuario.index.php'>Usuarios</a>
                                        </li>
                                        <li>
                                            <a href='../Modulo_personal/personal.index.php'>Personal</a>
                                        </li>
                                        <li>
                                            <a href='../Modulo_residente/residente.index.php'>Residentes</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li>
                                    <a href='../Modulo_condominio/condominio.index.php'><i class='fa fa-table fa-fw'></i> Condominios</a>
                                </li>
                                <li>
                                    <a href='../Modulo_espacio_comun/espacio.index.php'><i class='fa fa-bicycle fa-fw'></i> Espacio Común</a>
                                </li>
                                <li>
                                    <a href='../Modulo_estructura_condominio/estructura.index.php'><i class='fa fa-building fa-fw'></i> Estructura Condominio</a>
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
                <!-- /.panel-heading -->
                <br>
                <div class="row">
                    <div></div>
                    <div class="col-md-12">
                        &nbsp;&nbsp;&nbsp;
                        <a href="reserva.agregar.php" class="btn btn-primary btn-success"><span class="glyphicon glyphicon-plus"></span> Ingresar reserva</a>
                    </div>
                </div>
                
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered" id="example">
                        <thead>
                            <tr>
                                <th style="display: none;">ID</th>
                                <th>Espacio común</th>
                                <th>Residente</th>
                                <th>Inicio</th>
                                <th>Termino</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT 
                                        rec.id_registro_reserva as id_reserva,
                                        rec.id_residente as id_residente,
                                        rec.id_espacio_comun as id_espacio_comun,
                                        ec.descripcion as nombre_espacio_comun,
                                        us.nombres as nombre_residente,
                                        rec.fecha_hora_inicio as hora_inicio,
                                        rec.fecha_hora_termino as hora_termino,
                                        ec.id_condominio as condominio
                                    FROM registro_reserva_espacio_comun rec
                                    JOIN espacios_comunes ec ON rec.id_espacio_comun = ec.id_espacio_comun
                                    JOIN residente_condominio rc ON rec.id_residente = rc.id_residente
                                    JOIN usuarios us ON rc.id_usuario = us.id_usuario
                                    WHERE ec.id_condominio = $condominio";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($row = $resultado->fetch_assoc()) {
                            ?>
                            <tr class="odd gradeX">
                                <td style="display: none;"><?php echo $row['id_personal']; ?></td>
                                <td><?php echo $row['nombre_espacio_comun']; ?></td>
                                <td><?php echo $row['nombre_residente']; ?></td>
                                <td><?php echo $row['hora_inicio']; ?></td>
                                <td><?php echo $row['hora_termino']; ?></td>
                                <td>
                                    <a href="../../../Clases/Reserva_espacio_comun/class.eliminar.php?id=<?php echo $row['id_reserva'];?>&user=<?php echo $_SESSION['username']; ?>" title="Eliminar" class="btn btn-danger btn-block"><i class="fa fa-times"></i></a>
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