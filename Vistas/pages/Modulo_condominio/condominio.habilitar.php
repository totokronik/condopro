<?php
session_start();
require '../../../Datos/config.php';
require "../../../Datos/sidebar.php";
if(isset($_SESSION['loggedin'])){
    if(isset($_SESSION['perfil'])){
        $perfil = $_SESSION['perfil'];
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

        if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 7 || $_SESSION['perfil'] == -1) {

        }else{
            echo "<script>alert('No tienes privilegios para acceder al módulo'); window.location.href = '../index.php'</script>";

        }
    }else{
        if(isset($_SESSION['id_usuario'])){
            $usuario = $_SESSION['id_usuario'];
            $msg = "Usuario Maestro";
        }else{
            echo "<script>alert('Sólo el usuario maestro tiene acceso a este módulo'); window.location.href = '../../../Clases/Login/class.logout.php'</script>";
        }
    }
}else{
    echo "<script>alert('Está página es solo para usuarios registrados'); window.location.href = '../login.html'</script>";
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
                        <li><a href="#"><i class="fa fa-users fa-fw"></i> <?php echo $msg; ?></a>
                        </li>
                        <li class="divider"></li>
                            <li><a href="../Modulo_usuario/usuario.perfil.php"><i class="fa fa-user fa-fw"></i> Perfil</a>
                        </li>
                        <?php
                            if(isset($perfil)){
                                if($perfil != -1){
                                    echo "<li><a href='Modulo_favorito/favorito.index.php'><i class='fa fa-gear fa-fw'></i> Favoritos</a></li>";
                                }
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
                <?php 
                    if (isset($usuario)) {
                        switch ($usuario) {
                            case '0':
                                echo "<li>
                                        <a href='Modulo_condominio/condominio.index.php'><i class='fa fa-table fa-fw'></i> Condominios</a>
                                    </li>";
                            break;
                        }
                    }else{
                        if(isset($perfil)){
                            echo MostrarNavegadorSecundario($perfil);
                        }
                    }
                ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
<div id="page-wrapper">
    <div class="row">
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row --><br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <b>Lista de condominios inhabilitados</b>
                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        &nbsp;&nbsp;&nbsp;
                        <a href="condominio.index.php" class="btn btn-primary btn-success"><span class="glyphicon glyphicon-eye-open"></span> Condominios Habilitados</a>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered" id="example">
                        <thead>
                            <tr>
                                <th style="display: none;">ID</th>
                                <th>Rut</th>
                                <th>Nombre condominio</th>
                                <th>Dirección</th>
                                <th>Comuna</th>
                                <th>Cant. sectores</th>
                                <th>1º piso habitable</th>
                                <th>Cantidad pisos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT
                            cnd.id_condominio as id,
                            CONCAT(cnd.rut, '-', cnd.dv) as rut,
                            cnd.nombre_condominio as nombre,
                            cnd.direccion as direccion,
                            com.nombre_comuna as comuna,
                            cnd.cantidad_sectores as cantidad_sectores,
                            cnd.primer_piso_habitable as primer_piso_habitable,
                            cnd.cantidad_piso_habitables as cantidad_piso_habitables
                            FROM condominios cnd
                            JOIN comunas com ON cnd.id_comuna = com.id_comuna
                            WHERE cnd.activo = 0";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($row = $resultado->fetch_assoc()) {
                            ?>
                            <tr class="odd gradeX">
                                <td style="display: none;"><?php echo $row['id']; ?></td>
                                <td><?php echo $row['rut']; ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['direccion']; ?></td>
                                <td><?php echo $row['comuna']; ?></td>
                                <td><?php echo $row['cantidad_sectores']; ?></td>
                                <td><?php echo $row['primer_piso_habitable']; ?></td>
                                <td><?php echo $row['cantidad_piso_habitables']; ?></td>
                                <td>
                                    <a href="../../../Clases/Condominio/class.habilitar.php?id=<?php echo $row['id']; ?>&user=<?php echo $_SESSION['username']; ?>" class="btn btn-success btn-block"><i class="fa fa-check"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
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