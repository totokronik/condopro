<?php
session_start();
require '../../../Datos/config.php';
require "../../../Datos/rut.php";
require "../../../Datos/sidebar.php";

if(isset($_SESSION['loggedin'])){
    if ($_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 6 || $_SESSION['perfil'] == 7) {
        
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
            <h1 class="page-header">Gestión de Residentes</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <b>Lista de residentes</b>
                </div>
                <!-- /.panel-heading -->
                <?php  
                switch ($perfil) {
                    case '3':
                        echo "<br>
                            <div class='row'>
                                <div></div>
                                <div class='col-md-12'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='residente.agregar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nuevo Residente</a>
                                    <a href='residente.habilitar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-eye-close'></span> Residentes Inhabilitados</a>
                                </div>
                            </div>";
                        break;
                    case '4':
                        echo "<br>
                            <div class='row'>
                                <div></div>
                                <div class='col-md-12'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='residente.agregar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nuevo Residente</a>
                                    <a href='residente.habilitar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-eye-close'></span> Residentes Inhabilitados</a>
                                </div>
                            </div>";
                        break;
                    case '6':
                        echo "<br>
                            <div class='row'>
                                <div></div>
                                <div class='col-md-12'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='residente.agregar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nuevo Residente</a>
                                    <a href='residente.habilitar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-eye-close'></span> Residentes Inhabilitados</a>
                                </div>
                            </div>";
                        break;
                    case '7':
                        echo "<br>
                            <div class='row'>
                                <div></div>
                                <div class='col-md-12'>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href='residente.agregar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-plus'></span> Nuevo Residente</a>
                                    <a href='residente.habilitar.php' class='btn btn-primary btn-success'><span class='glyphicon glyphicon-eye-close'></span> Residentes Inhabilitados</a>
                                </div>
                            </div>";
                        break;
                }
                ?>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered" id="example">
                        <thead>
                            <tr>
                                <th style="display: none;">ID</th>
                                <th>Rut</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Estructura condominio</th>
                                <?php switch ($perfil) {
                                    case '3':
                                        echo "<th>Acciones</th>";
                                        break;
                                    case '4':
                                        echo "<th>Acciones</th>";
                                        break;
                                    case '6':
                                        echo "<th>Acciones</th>";
                                        break;
                                    case '7':
                                        echo "<th>Acciones</th>";
                                        break;
                                } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT
                            us.id_usuario as usuario,
                            rc.id_residente as id,
                            rc.id_estructura_condominio as estructura_condominio,
                            us.numero_documento as rut,
                            us.nombres as nombres,
                            us.apellidos as apellidos,
                            us.telefono_celular as telefono,
                            us.email as email,
                            rc.activo as activo,
                            ec.unidad as unidad_condominio
                            FROM residente_condominio rc
                            JOIN usuarios us ON rc.id_usuario = us.id_usuario
                            JOIN estructura_condominio ec ON rc.id_estructura_condominio = ec.id_estructura_condominio
                            WHERE rc.activo = 1
                            AND ec.id_condominio = $condominio 
                            AND us.id_usuario <> 0";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($row = $resultado->fetch_assoc()) {
                            
                            ?>
                            <tr class="odd gradeX">
                                <td style="display: none;"><?php echo $row['id']; ?></td>
                                <td><?php echo formateo_rut($row['rut']); ?></td>
                                <td><?php echo $row['nombres']; ?></td>
                                <td><?php echo $row['apellidos']; ?></td>
                                <td><?php echo $row['telefono']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['unidad_condominio']; ?></td>
                                <?php switch ($perfil) {
                                    case '3':
                                        echo "<td>
                                                <a href='residente.modificar.php?id=".$row['id']."&estructura=".$row['estructura_condominio']."' title='Modificar' class='btn btn-info btn-block'><i class='fa fa-pencil'></i></a>
                                                <a href='../../../Clases/Residente/class.inhabilitar.php?id=".$row['id']."&estructura=".$row['estructura_condominio']."&user=".$_SESSION['username']."' title='Inhabilitar' class='btn btn-warning btn-block'><i class='fa fa-times'></i></a>
                                            </td>";
                                        break;
                                    case '4':
                                        echo "<td>
                                                <a href='residente.modificar.php?id=".$row['id']."&estructura=".$row['estructura_condominio']."' title='Modificar' class='btn btn-info btn-block'><i class='fa fa-pencil'></i></a>
                                                <a href='../../../Clases/Residente/class.inhabilitar.php?id=".$row['id']."&estructura=".$row['estructura_condominio']."&user=".$_SESSION['username']."' title='Inhabilitar' class='btn btn-warning btn-block'><i class='fa fa-times'></i></a>
                                            </td>";
                                        break;
                                    case '6':
                                        echo "<td>
                                                <a href='residente.modificar.php?id=".$row['id']."&estructura=".$row['estructura_condominio']."' title='Modificar' class='btn btn-info btn-block'><i class='fa fa-pencil'></i></a>
                                                <a href='../../../Clases/Residente/class.inhabilitar.php?id=".$row['id']."&estructura=".$row['estructura_condominio']."&user=".$_SESSION['username']."' title='Inhabilitar' class='btn btn-warning btn-block'><i class='fa fa-times'></i></a>
                                            </td>";
                                        break;
                                    case '7':
                                        echo "<td>
                                                <a href='residente.modificar.php?id=".$row['id']."&estructura=".$row['estructura_condominio']."' title='Modificar' class='btn btn-info btn-block'><i class='fa fa-pencil'></i></a>
                                                <a href='../../../Clases/Residente/class.inhabilitar.php?id=".$row['id']."&estructura=".$row['estructura_condominio']."&user=".$_SESSION['username']."' title='Inhabilitar' class='btn btn-warning btn-block'><i class='fa fa-times'></i></a>
                                            </td>";
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
</body>
</html>